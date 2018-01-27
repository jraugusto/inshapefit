<?php
define( 'G5PLUS_LOG_PROCESS_SLIDER', G5P()->pluginDir('assets/data-demo/log/log_process_slider.log'));

class GF_Import extends G5_Import {

	var $preStringOption;
	var $results;
	var $getOptions;
	var $saveOptions;
	var $termNames;

	/**
	 * Save Options
	 */
	function saveOptions( $option_file ) {
		global $wpdb;
		if ( ! is_file( $option_file ) ) {
			return false;
		}
		$setting_data = (array)json_decode(G5P()->file()->getContents( $option_file ), true);

		foreach($setting_data as $key => $value) {
			if (get_option($key) === false) {
				$s_query = $wpdb->prepare("insert into $wpdb->options(`option_name`, `option_value`, `autoload`) values(%s, %s, %s)", $key, base64_decode($value["option_value"]), $value["autoload"]);
			}
			else {
				$s_query = $wpdb->prepare("update $wpdb->options set `option_value` = %s , `autoload` = %s where option_name = %s", base64_decode($value["option_value"]), $value["autoload"], $key);
			}

			$wpdb->query($s_query);
		}


		return true;
	}

	/**
	 * Import Revolution Slider
	 * @param $other_data
	 * @return object|string
	 */
	function import_revslider($other_data) {
		$count_installed = 0;
		if (file_exists(G5PLUS_LOG_PROCESS_SLIDER)) {
			$count_installed = G5P()->file()->getContents(G5PLUS_LOG_PROCESS_SLIDER);
		}

		$is_import = false;
		$demo_site = isset($_REQUEST['demo_site']) ? $_REQUEST['demo_site'] : '.';


		if ( $handle = opendir(G5P()->pluginDir("assets/data-demo/{$demo_site}/revslider")) ) {
			$amount = 0;
			while ( false !== ( $entry = readdir( $handle ) ) ) {
				if ( $entry != "." && $entry != ".." ) {
					$amount +=1;
				}
			}
			closedir( $handle );
		}

		if ( $handle = opendir( G5P()->pluginDir("assets/data-demo/{$demo_site}/revslider")) ) {
			$count = 0;
			while ( false !== ( $entry = readdir( $handle ) ) ) {
				if ( $entry != "." && $entry != ".." ) {
					if ($count < $count_installed) {
						$count+=1;
						continue;
					}
					$rev_import_file = G5P()->pluginDir("assets/data-demo/{$demo_site}/revslider/{$entry}");
					if ( class_exists( 'RevSlider' ) ) {
						$slider   = new RevSlider();
						$slider->importSliderFromPost( true, true, $rev_import_file );
						$is_import = true;
                        G5P()->file()->putContents(G5PLUS_LOG_PROCESS_SLIDER, $count_installed + 1);
						break;
					} else {
						closedir( $handle );
						return 'done';
					}
				}
			}
			closedir( $handle );
		} else {
			return 'done';
		}

		if ($is_import) {
			return (object) array(
				'count' => 	$count_installed + 1,
				'amount' => $amount
			);
		}
		return 'done';
	}

	/**
	 * Update Missing Id
	 */
	function update_missing_id() {
		global $wpdb,$terms_id;

		$site_url = site_url();

		$demo_path = isset($_REQUEST['demo_path']) ? $_REQUEST['demo_path'] : '';

		// update menu_url
		$sql_query = $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key = '_menu_item_url'", G5PLUS_SITE_DEMO_URL . $demo_path ,$site_url );
		$wpdb->query($sql_query);

		// update xmenu config
		$sql_query = $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key = '_menu_item_xmenu_config'", G5PLUS_SITE_DEMO_URL . $demo_path ,$site_url );
		$wpdb->query($sql_query);

		//update post content
		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", G5PLUS_SITE_DEMO_URL . $demo_path , $site_url);
		$wpdb->query($sql_query);

		// update postmeta - meta_value
		$sql_query = $wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = replace(meta_value, %s, %s) WHERE meta_key = '_wpb_shortcodes_custom_css'", G5PLUS_SITE_DEMO_URL . $demo_path , $site_url);
		$wpdb->query($sql_query);

		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", urlencode(G5PLUS_SITE_DEMO_URL) . urlencode($demo_path)  , urlencode($site_url));
		$wpdb->query($sql_query);

		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", urlencode(urlencode(G5PLUS_SITE_DEMO_URL)) . urlencode(urlencode($demo_path))  , urlencode(urlencode($site_url)));
		$wpdb->query($sql_query);



		// updage guid in posts
		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", G5PLUS_SITE_DEMO_URL . $demo_path , $site_url);
		$wpdb->query($sql_query);

		$sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", 'http://demo2.woothemes.com/woocommerce', $site_url);
		$wpdb->query($sql_query);

		// Update COUNT term_taxonomy
		$sql_query = "UPDATE $wpdb->term_taxonomy tt SET count = (SELECT count(p.ID) FROM $wpdb->term_relationships tr LEFT JOIN wp_posts p ON (p.ID = tr.object_id AND p.post_status = 'publish') WHERE tr.term_taxonomy_id = tt.term_taxonomy_id)";
		$wpdb->query($sql_query);

		// Update MailChimp
		$rows = $wpdb->get_results($wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = %s and post_status = 'publish'", 'mc4wp-form' ) );
		if (count($rows) > 0) {
			update_option('mc4wp_default_form_id', $rows[0]->ID);
		}


		$posts_id = json_decode( G5P()->file()->getContents( PROCESS_POSTS ), true );
		$terms_id = json_decode( G5P()->file()->getContents( PROCESS_TERM ), true );

		$options_changed_id = (array)json_decode(G5P()->file()->getContents( CHANGE_DATA_FILE), true);

		// Update Options Page/Post ID
		if (isset($options_changed_id['posts']) && is_array($options_changed_id['posts'])) {
			foreach ($options_changed_id['posts'] as $key => $value) {
				update_option($key, isset($posts_id[$value]) ? $posts_id[$value] : $value);
			}
		}

		// Change nav_menu_location
		$data = get_option('theme_mods_' . G5PLUS_THEME_MOD_NAME);

		if (isset($data['nav_menu_locations'])) {
			foreach ($data['nav_menu_locations'] as $key => $value) {
				$data['nav_menu_locations'][$key] = isset($terms_id[$value]) ? $terms_id[$value] : $value;
			}
		}
		update_option('theme_mods_' . get_option("stylesheet"), $data);

		// Change theme_mod
		$data['sidebars_widgets'] = array(
			'time' => time(),
			'data' => get_option('sidebars_widgets')
		);

		if (is_child_theme()) {
			update_option('theme_mods_' . get_template(), $data);
		}
		else {
			update_option('theme_mods_' . get_option("stylesheet") . '-child', $data);
		}

		unset($data);

		// Change nav_menu ID in widget
        $data_nav_menu = get_option('widget_nav_menu');
        if (isset($data_nav_menu) && is_array($data_nav_menu)) {
            foreach ($data_nav_menu as $key => $value) {
                if (is_array($value) && isset($value['nav_menu'])) {
                    $data_nav_menu[$key]['nav_menu'] = isset($terms_id[$value['nav_menu']]) ? $terms_id[$value['nav_menu']] : $value['nav_menu'];
                }
            }
        }
        update_option('widget_nav_menu', $data_nav_menu);



		$widget_keys = array('widget_gsf-payment');
        foreach ($widget_keys as $widget_key) {
            $data = get_option($widget_key);
            if (isset($data) && $data) {
                $data_json = json_encode($data);
                $demo_url_json = json_encode(G5PLUS_SITE_DEMO_URL . $demo_path);
                $demo_url_json = substr($demo_url_json,1,strlen($demo_url_json)-2);
                $site_url_json = json_encode($site_url);
                $site_url_json = substr($site_url_json,1,strlen($site_url_json)-2);

                $data_json = str_replace($demo_url_json ,$site_url_json,$data_json);
                update_option($widget_key,json_decode($data_json,true));
            }
        }


        $rows = $wpdb->get_results($wpdb->prepare("SELECT ID, post_content  FROM $wpdb->posts WHERE post_status = %s", 'publish'));
        foreach ($rows as $row) {
            $row->post_content = preg_replace_callback('/(vc_wp_custommenu nav_menu\=\")(\d+)(\")/', array($this, 'replace_nav_id_callback'), $row->post_content);
            $sql_query = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = %s where ID = %d ", $row->post_content, $row->ID);
            $wpdb->query($sql_query);
        }

		// Change term id in post meta
		$metaPrefix = G5P()->getMetaPrefix();
		$options_key = array(
			"{$metaPrefix}page_menu" => '='
		);

		foreach ($options_key as $key => $value) {
			$rows = $wpdb->get_results($wpdb->prepare("SELECT post_id, meta_value, meta_key FROM $wpdb->postmeta WHERE meta_key $value %s", $key));
			foreach ($rows as $row) {
				if (isset($terms_id[$row->meta_value])) {
					update_post_meta($row->post_id,$row->meta_key,$terms_id[$row->meta_value]);
				}
			}
		}



		if (function_exists('rev_slider_shortcode')) {
			if (isset($options_changed_id['wp_revslider_navigations']) && is_array($options_changed_id['wp_revslider_navigations'])) {
				$table_name = $wpdb->prefix . "revslider_navigations";
				if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
					foreach ($options_changed_id['wp_revslider_navigations'] as $nav_items ) {
						$sql_query = $wpdb->prepare( "INSERT INTO $table_name (id, name, handle, css, markup, settings) VALUES (%d, %s, %s, %s, %s, %s)",
							$nav_items['id'],
							$nav_items['name'],
							$nav_items['handle'],
							$nav_items['css'],
							$nav_items['markup'],
							$nav_items['settings']
						);
						$wpdb->query($sql_query);
					}
				}
			}
		}

		// change url in theme-option
		$options = $wpdb->get_results($wpdb->prepare("SELECT option_name FROM $wpdb->options WHERE option_name like %s", G5P()->getOptionName() . '%'));
		foreach ($options as $option) {
			$optionValue = get_option($option->option_name);
			foreach ($optionValue as $key => &$value) {
				if (isset($value['url'])) {
					$value['url'] = str_replace(G5PLUS_SITE_DEMO_URL . $demo_path,$site_url,$value['url']);
				}

				if (isset($value['background_image_url'])) {
					$value['background_image_url'] = str_replace(G5PLUS_SITE_DEMO_URL . $demo_path,$site_url,$value['background_image_url']);
				}

			}
			update_option($option->option_name,$optionValue);

		}
	}

	function import_setting( $file ) {
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

		$this->import_start( $file );

		$this->get_author_mapping();

		wp_suspend_cache_invalidation( true );
		$this->process_categories();
		$this->process_tags();
		$this->process_terms();

		$this->process_posts(true);

		wp_suspend_cache_invalidation( false );

		// update incorrect/missing information in the DB
		$this->backfill_parents();
		$this->backfill_attachment_urls();
		$this->remap_featured_images();
		$this->import_end();

		return true;
	}

	function replace_nav_id_callback($match) {
	    global $terms_id;
        $id =  isset($terms_id[$match[2]]) ? $terms_id[$match[2]] : $match[2];
        return $match[1] . $id . $match[3];
    }
} 