<?php
if (!class_exists('DEV_Loader')) {
	class DEV_Loader
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			$this->includes();
			$this->generator()->init();
			$this->devMenu();
			add_action('admin_menu', array($this, 'adminMenu'));
		}

		public function includes()
		{
			require_once 'generate-class.php';
		}

		public function devMenu()
		{
			add_action('admin_bar_menu', array($this, 'makeDevMenu'), 999);
		}

		function makeDevMenu($wp_admin_bar)
		{
			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev',     // id of the existing child node (New > Post)
				'title' => sprintf('<span class="ab-icon"></span><span class="ab-label">%s</span>', esc_html__('G5 DEV', 'april-framework')),
				'parent' => false,          // set parent to false to make it a top level (parent) node
			));

			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_gen_option_class',
				'title' => 'Options Class', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'meta' => array(
					'target' => '_blank',
				),
				'href' => admin_url('admin-ajax.php?action=gsf_generate_class&type=option&page=gsf_options&class_name=G5P_Inc_Options')
			));

			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_gen_option_skin_class',
				'title' => 'Options Skin Class', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'meta' => array(
					'target' => '_blank',
				),
				'href' => admin_url('admin-ajax.php?action=gsf_generate_class&type=option&page=gsf_skins&class_name=G5P_Inc_Options_Skin')
			));

			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_gen_metabox_class',
				'title' => 'MetaBox Class', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'meta' => array(
					'target' => '_blank',
				),
				'href' => admin_url('admin-ajax.php?action=gsf_generate_class&type=post_meta&meta_id=gsf_page_setting&class_name=G5P_Inc_MetaBox')
			));

            $wp_admin_bar->add_node(array(
                'id' => '_gsf_dev_gen_metabox_portfolio_class',
                'title' => 'MetaBox Portfolio Class', // alter the title of existing node
                'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
                'meta' => array(
                    'target' => '_blank',
                ),
                'href' => admin_url('admin-ajax.php?action=gsf_generate_class&type=post_meta&meta_id=gsf_portfolio_setting&class_name=G5P_Inc_MetaBox_Portfolio')
            ));

			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_gen_termmeta_class',
				'title' => 'TermMeta Class', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'meta' => array(
					'target' => '_blank',
				),
				'href' => admin_url('admin-ajax.php?action=gsf_generate_class&type=term_meta&meta_id=gsf_taxonomy_setting&class_name=G5P_Inc_Term_Meta')
			));

			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_gen_user_meta_class',
				'title' => 'UserMeta Class', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'meta' => array(
					'target' => '_blank',
				),
				'href' => admin_url('admin-ajax.php?action=gsf_generate_class&type=user_meta&meta_id=gsf_user_meta_setting&class_name=G5P_Inc_User_Meta')
			));


			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_export_setting',
				'title' => 'Export Setting', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'href' => admin_url('themes.php?page=export-settings')
			));

			$wp_admin_bar->add_node(array(
				'id' => '_gsf_dev_shortcodes_less',
				'title' => 'Less To Css', // alter the title of existing node
				'parent' => '_gsf_dev',          // set parent to false to make it a top level (parent) node
				'href' => admin_url('themes.php?page=shortcode-less-to-css')
			));
		}


		public function adminMenu()
		{
			add_theme_page('Less To Css', 'Less To Css', 'manage_options', 'shortcode-less-to-css', array($this, 'shortcode_less_to_css_callback'));
			add_theme_page('Export Settings', 'Export Settings', 'manage_options', 'export-settings', array($this, 'exportSettings'));
		}

		public function shortcode_less_to_css_callback()
		{
			G5P()->core()->less()->shortCodesCss();
			G5P()->core()->less()->createEditorCssFile();
		}

		public function exportSettings()
		{
			$this->installDemoCreateSettingFile();
			$this->installDemoCreateSettingMinimalFile();
			$this->installDemoCreateAllowAttachment();
			$this->installDemoCreateChangeDataFile();
		}

		public function generator()
		{
			return DEV_Generate_Class::getInstance();
		}

		public function installDemoCreateSettingFile()
		{
			global $wpdb;
			$options_key = array(
				'sidebars_widgets' => '=',
				'widget_%' => 'like',
				'theme_mods_' . get_option('stylesheet') => '=',
				'gsf_preset_options_keys_%' => 'like',
				G5P()->getOptionName() . '%' => 'like',
				G5P()->getOptionSkinName() => '=',
				'show_on_front' => '=',
				'page_on_front' => '=',
				'page_for_posts' => '=',
				'shop_catalog_image_size' => '=',
				'shop_single_image_size' => '=',
				'shop_thumbnail_image_size' => '=',
				'yith_wcwl_button_position' => '=',
				'slickr_flickr_options' => '=',
				"woocommerce_%" => "like",
				"yith_woocompare_%" => "like",
				'mc4wp_lite_form' => '=',
				'mc4wp_default_form_id' => '=',
				'permalink_structure' => '=',
				'medium_size_w' => '=',
				'medium_size_h' => '=',
				'thumbnail_size_w' => '=',
				'thumbnail_size_h' => '=',
				'large_size_w' => '=',
				'large_size_h' => '=',
				'yit_wcan_options' => '=',
				'wpb_js_templates' => '=',
				'gsf-widget-areas' => '=',
				'grid_plus%' => 'like',
                'post_views_counter_settings_display' => '=',
                'wp_review_options' => '=',
                'gsf_font_options' => '='
			);

			$file_data = array();
			foreach ($options_key as $key => $value) {
				$rows = $wpdb->get_results($wpdb->prepare("SELECT option_name, option_value, autoload FROM $wpdb->options WHERE option_name $value %s", $key));

				foreach ($rows as $row) {
					$file_data[$row->option_name] = array(
						"autoload" => $row->autoload,
						"option_value" => base64_encode($row->option_value)
					);
				}
			}

			if (!file_exists(trailingslashit(get_template_directory()) . 'assets/cache/')) {
                G5P()->file()->mkdir(trailingslashit(get_template_directory()) . 'assets/cache/');
			}

			echo "Create file setting.json<br/>";
			if (!G5P()->file()->putContents(trailingslashit(get_template_directory()) . 'assets/cache/setting.json', json_encode($file_data))) {
				echo "Error Create file setting.json<br/>";
			}

		}

		public function installDemoCreateSettingMinimalFile()
		{
			global $wpdb;
			$options_key = array(
                'sidebars_widgets' => '=',
                'widget_%' => 'like',
                'theme_mods_' . get_option('stylesheet') => '=',
                'gsf_preset_options_keys_%' => 'like',
				G5P()->getOptionName() . '%' => 'like',
				G5P()->getOptionSkinName() => '=',
				'shop_catalog_image_size' => '=',
				'shop_single_image_size' => '=',
				'shop_thumbnail_image_size' => '=',
				'yith_wcwl_button_position' => '=',
				'slickr_flickr_options' => '=',
				"woocommerce_%" => "like",
				"yith_woocompare_%" => "like",
				'mc4wp_lite_form' => '=',
				'mc4wp_default_form_id' => '=',
				'widget_null-instagram-feed' => '=',
				'permalink_structure' => '=',
				'medium_size_w' => '=',
				'medium_size_h' => '=',
				'thumbnail_size_w' => '=',
				'thumbnail_size_h' => '=',
				'large_size_w' => '=',
				'large_size_h' => '=',
				'yit_wcan_options' => '=',
				'wpb_js_templates' => '=',
				'grid_plus%' => 'like',
                'post_views_counter_settings_display' => '=',
                'wp_review_options' => '=',
                'gsf_font_options' => '='
			);

			$file_data = array();
			foreach ($options_key as $key => $value) {
				$rows = $wpdb->get_results($wpdb->prepare("SELECT option_name, option_value, autoload FROM $wpdb->options WHERE option_name $value %s", $key));

				foreach ($rows as $row) {
					$file_data[$row->option_name] = array(
						"autoload" => $row->autoload,
						"option_value" => base64_encode($row->option_value)
					);
				}
			}

			if (!file_exists(trailingslashit(get_template_directory()) . 'assets/cache/')) {
				G5P()->file()->mkdir(trailingslashit(get_template_directory()) . 'assets/cache/');
			}

			echo "Create file setting-minimal.json<br/>";
			if (!G5P()->file()->putContents(trailingslashit(get_template_directory()) . 'assets/cache/setting-minimal.json', json_encode($file_data))) {
				echo "Error Create file setting-minimal.json<br/>";
			}

		}

		public function installDemoCreateAllowAttachment() {
			global $wpdb;

			$image_pattern  = array(
				'/\simage="((\d*))"/',
				'/\sparallax_image="((\d*))"/',
				'/\simages="(([^"]*))"/',
				'/\surl\((.*(?=\?id=))\?id=(\d+)/',
				'/\sbg_overlay_image="((\d*))"/',
				'/\sicon_image="((\d*))"/',
                '/\sauthor_avatar="((\d*))"/',
                '/\sicon="((\d*))"/',
			);


			$attachment_ids = array();

			$rows = $wpdb->get_results($wpdb->prepare("SELECT ID, post_content  FROM $wpdb->posts WHERE post_type in ('gsf_content','gsf_template') and post_status = %s", 'publish'));

			foreach ($rows as $row) {
				// Get post feature image id
				$id = get_post_thumbnail_id($row->ID);
				if ($id) {
					$attachment_ids[] = $id;
				}

				$post_content = $row->post_content;

				// single image
				foreach($image_pattern as $pattern) {
					if (preg_match_all($pattern, $post_content, $matches)) {
						foreach ($matches[2] as $matche) {
							$ids = explode(',',$matche);
							foreach ($ids as $id) {
								if ($id && !in_array($id, $attachment_ids)) {
									$attachment_ids[] = $id;
								}
							}
						}
					}
				}
			}


			if (!file_exists(trailingslashit(get_template_directory()) . 'assets/cache/')) {
                G5P()->file()->mkdir(trailingslashit(get_template_directory()) . 'assets/cache/');
			}

			echo "Create file allow-attachment.json<br/>";
			if (!G5P()->file()->putContents(trailingslashit(get_template_directory()) . 'assets/cache/allow-attachment.json', json_encode($attachment_ids))) {
				echo "Error Create file allow-attachment.json<br/>";
			}
		}

		public function installDemoCreateChangeDataFile()
		{
			$data = array();

			$options_post_missing = array(
				'page_for_posts',
				'page_on_front',
				'woocommerce_shop_page_id'
			);
			foreach ($options_post_missing as $value) {
				$option_val = get_option($value);
				if ($option_val !== false) {
					$data['posts'][$value] = $option_val;
				}
			}


			global $wpdb;
			$table_name = $wpdb->prefix . "revslider_navigations";
			if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
				$rows = $wpdb->get_results("SELECT `id`, `name`, `handle`, `css`, `markup`, `settings` FROM {$table_name}");
				foreach ($rows as $row) {
					$data['wp_revslider_navigations'][] = array(
						'id'       => $row->id,
						'name'     => $row->name,
						'handle'   => $row->handle,
						'css'      => $row->css,
						'markup'   => $row->markup,
						'settings' => $row->settings
					);
				}
			}

			if (!file_exists(trailingslashit(get_template_directory()) . 'assets/cache/')) {
                G5P()->file()->mkdir(trailingslashit(get_template_directory()) . 'assets/cache/');
			}

			echo "Create file change-data.json<br/>";
			if (!G5P()->file()->putContents(trailingslashit(get_template_directory()) . 'assets/cache/change-data.json', json_encode($data))) {
				echo "Error Create file change-data.json<br/>";
			}
		}
	}

	function DEV()
	{
		return DEV_Loader::getInstance();
	}

	DEV()->init();
}