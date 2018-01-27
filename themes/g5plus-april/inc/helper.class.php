<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Inc_Helper')) {
	class G5Plus_Inc_Helper
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Get template
		 * @param $slug
		 * @param $args
		 */
		public function getTemplate($slug, $args = array())
		{
            if ($args && is_array($args)) {
                extract($args);
            }
            $template_name = "templates/{$slug}.php";
            $located = trailingslashit(get_stylesheet_directory()) . $template_name;
            if (!file_exists($located)) {
                $located = trailingslashit(get_template_directory()) . $template_name;
            }

            if (!file_exists($located)) {
                _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $template_name), '1.0');
                return;
            }
            include($located);
		}

		/**
		 * Get plugin assets url
		 * @param $file
		 * @return string
		 */
		public function getAssetUrl($file)
		{
			if (!file_exists(g5Theme()->themeDir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
				$ext = explode('.', $file);
				$ext = end($ext);
				$normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
				if ($normal_file != $file) {
					$normal_file = untrailingslashit($normal_file) . ".{$ext}";
					if (file_exists(g5Theme()->themeDir($normal_file))) {
						return g5Theme()->themeUrl(untrailingslashit($normal_file));
					}
				}
			}
			return g5Theme()->themeUrl(untrailingslashit($file));
		}

		public function assetsHandle($handle = '')
		{
			return apply_filters('gsf_assets_prefix', 'gsf_') . $handle;
		}


		/**
		 * Truncate Text
		 *
		 * @param $text
		 * @param $length
		 * @return mixed|string
		 */
		public function truncateText($text, $length)
		{
			$text = strip_tags($text, '<img />');
			$length = abs((int)$length);
			if (strlen($text) > $length) {
				$text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
			}
			return $text;
		}

		/**
		 * Get Social Networks Config
		 *
		 * @return array
		 */
		public function &get_social_networks()
		{
			$social_networks = g5Theme()->options()->get_social_networks();
			$configs = array();
			if (is_array($social_networks)) {
				foreach ($social_networks as $social_network) {
					$configs[$social_network['social_id']] = $social_network;
				}
			}
			return $configs;
		}


		public function getSkinClass($skin_id, $echo = false)
		{
			if (empty($skin_id)) return array();
			$classes = array(
				'gf-skin',
				$skin_id
			);
			// Enqueue style.css
            if ($echo) {
                wp_enqueue_style(g5Theme()->helper()->assetsHandle("skin_{$skin_id}"));
            }
			return $classes;
		}

		/**
		 * Get Page Title
		 *
		 * @return string|void
		 */
		public function get_page_title()
		{
			$page_title = '';
			if (is_home() || is_single()) {
				$page_title = esc_html__('Blog', 'g5plus-april');
			} elseif (is_404()) {
				$page_title = esc_html__('Page Not Found', 'g5plus-april');
			} elseif (is_singular()) {
				$page_title = get_the_title();
			} elseif (is_category() || is_tax()) {
				$page_title = single_term_title('', false);
			} elseif (is_tag()) {
				$page_title = single_tag_title(esc_html__("Tags: ", 'g5plus-april'), false);
			} elseif (is_search()) {
				$page_title = sprintf(esc_html__('Search Results For: %s', 'g5plus-april'), get_search_query());
			} elseif (is_day()) {
				$page_title = sprintf(esc_html__('Daily Archives: %s', 'g5plus-april'), get_the_date());
			} elseif (is_month()) {
				$page_title = sprintf(esc_html__('Monthly Archives: %s', 'g5plus-april'), get_the_date(_x('F Y', 'monthly archives date format', 'g5plus-april')));
			} elseif (is_year()) {
				$page_title = sprintf(esc_html__('Yearly Archives: %s', 'g5plus-april'), get_the_date(_x('Y', 'yearly archives date format', 'g5plus-april')));
			} elseif (is_author()) {
				$page_title = sprintf(esc_html__('Author: %s', 'g5plus-april'), get_the_author());
			} elseif (is_tax('post_format', 'post-format-aside')) {
				$page_title = esc_html__('Asides', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-gallery')) {
				$page_title = esc_html__('Galleries', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-image')) {
				$page_title = esc_html__('Images', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-video')) {
				$page_title = esc_html__('Videos', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-quote')) {
				$page_title = esc_html__('Quotes', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-link')) {
				$page_title = esc_html__('Links', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-status')) {
				$page_title = esc_html__('Statuses', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-audio')) {
				$page_title = esc_html__('Audios', 'g5plus-april');
			} elseif (is_tax('post_format', 'post-format-chat')) {
				$page_title = esc_html__('Chats', 'g5plus-april');
			}
			if (is_singular()) {
				$page_title_content = g5Theme()->metaBox()->get_page_title_content();
				if ($page_title_content !== '') {
					$page_title = $page_title_content;
				}
			}

			if (is_category() || is_tax()) {
				$term = get_queried_object();
				if ($term && property_exists($term, 'term_id')) {
					$term_id = $term->term_id;
					$page_title_content = g5Theme()->termMeta()->get_page_title_content($term_id);
					if ($page_title_content !== '') {
						$page_title = $page_title_content;
					}
				}

			}
            $page_title = apply_filters('g5plus_page_title', $page_title);
			return $page_title;
		}

		/**
		 * Get Responsive Bootstrap columns
		 *
		 * @param $columns
		 * @return string
		 */
		public function get_bootstrap_columns($columns = array())
		{
			$default = array(
				'lg' => 2,
				'md' => 2,
				'sm' => 1,
				'xs' => 1,
                'mb' => 1
			);
			$columns = wp_parse_args($columns, $default);
			$classes = array();
			foreach ($columns as $key => $value) {
				if ($value > 0) {
				    if($value == 5){
                        $classes[$key] = "col-{$key}-12-5";
                    } else {
                        $classes[$key] = "col-{$key}-" . (12 / $value);
                    }
				}
			}
			return implode(' ', array_filter($classes));
		}

		public function getCSSAnimation($css_animation)
		{
			$output = '';
			if ('' !== $css_animation && 'none' !== $css_animation) {
				$output = ' gf_animate_when_almost_visible ' . $css_animation;
			}

			return $output;
		}

		/**
		 * Display Content Block
		 *
		 * @param $id
		 * @return mixed|string|void
		 */
		public function content_block($id)
		{
			if (empty($id)) return '';
			$content = get_post_field('post_content', $id);

			if (function_exists('vc_is_page_editable') && vc_is_page_editable()) {
                $content = do_shortcode($content);
            } else {
                $content = apply_filters('the_content', $content);
            }
			$content = str_replace(']]>', ']]&gt;', $content);
			return $content;
		}

		public function shortCodeContent($content, $echo = true) {
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
            if (!$echo) {
                return $content;
            }
            printf('%s', $content);
        }

		public function getCurrentPreset()
		{
			if (function_exists('G5P')) {
				return G5P()->helper()->getCurrentPreset();
			}
			return '';
		}

		/**
		 * Body Class
		 *
		 * @param $classes
		 * @return array
		 */
		public function body_class($classes)
		{
			global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
			if ($is_lynx) $classes[] = 'lynx';
			elseif ($is_gecko) $classes[] = 'gecko';
			elseif ($is_opera) $classes[] = 'opera';
			elseif ($is_NS4) $classes[] = 'ns4';
			elseif ($is_safari) $classes[] = 'safari';
			elseif ($is_chrome) $classes[] = 'chrome';
			elseif ($is_IE) $classes[] = 'ie';
			else $classes[] = 'unknown';
			if ($is_iphone) $classes[] = 'iphone';

			/**
			 * Page Transitions
			 */
			$action = isset($_GET['action']) ? $_GET['action'] : '';
			$page_transition = g5Theme()->options()->get_page_transition();
			if (($page_transition === 'on') && ($action != 'yith-woocompare-view-table')) {
				$classes[] = 'page-transitions';
			}

			if ($action === 'yith-woocompare-view-table') {
				$classes[] = 'woocommerce-compare-page';
			}

			/**
			 * Page Loading
			 */
			$loading_animation = g5Theme()->options()->get_loading_animation();
			if (!empty($loading_animation)) {
				$classes[] = 'page-loading';
			}

			/**
			 * Main Layout
			 */
			$main_layout = g5Theme()->options()->get_main_layout();
			if ($main_layout !== 'wide') {
				$classes[] = $main_layout;
			}

			$header_enable = g5Theme()->options()->get_header_enable();
			$header_layout = g5Theme()->options()->get_header_layout();

			if ($header_enable === 'on') {
				if (in_array($header_layout, array('header-7', 'header-8'))) {
					$classes[] = 'header-vertical';
					if ($header_layout === 'header-8') {
						$classes[] = 'header-left';
					} elseif ($header_layout === 'header-7') {
						$classes[] = 'header-right';
					}
				}
			}


			/**
			 * RTL Mode
			 */
			$rtl_enable = g5Theme()->options()->get_rtl_enable();
			if ($rtl_enable === 'on' || isset($_GET['RTL']) || is_rtl()) {
				$classes[] = 'rtl';
			}

			/**
			 * Single layout
			 */
			if (is_singular('post')) {
				$single_post_layout = g5Theme()->options()->get_single_post_layout();
				$classes[] = "single-post-{$single_post_layout}";
			}

			if (is_singular()) {
				$custom_page_css_class = g5Theme()->metaBox()->get_css_class();
				if (!empty($custom_page_css_class)) {
					$classes[] = $custom_page_css_class;
				}
			}

            $lazy_load_images = g5Theme()->options()->get_lazy_load_images();
            if ($lazy_load_images === 'on') {
                $classes[] = 'gf-lazy-load';
            }

			return $classes;
		}

		/**
		 * Excerpt
		 *
		 * @param $excerpt
		 * @return string
		 */
		public function excerpt($excerpt)
		{
			return wp_strip_all_tags($excerpt);
		}

		/**
		 * Extra Class
		 *
		 * @return array
		 */
		public function extra_class()
		{
			$extra_class = array(
				'heading-color',
				'disable-color',
				'border-color',
				'body-font',
				'primary-font',
				'bg-transparent',
				'gf-sticky'
			);
			/*for ($i = 0; $i <= 20;$i ++) {
				$spacing = $i * 5;
				$extra_class[] = "pd-top-$spacing";
				$extra_class[] = "sm-pd-top-$spacing";
				$extra_class[] = "xs-pd-top-$spacing";
				$extra_class[] = "pd-bottom-$spacing";
				$extra_class[] = "sm-pd-bottom-$spacing";
				$extra_class[] = "xs-pd-bottom-$spacing";
				$extra_class[] = "mg-top-$spacing";
				$extra_class[] = "sm-mg-top-$spacing";
				$extra_class[] = "xs-mg-top-$spacing";
				$extra_class[] = "mg-bottom-$spacing";
				$extra_class[] = "sm-mg-bottom-$spacing";
				$extra_class[] = "xs-mg-bottom-$spacing";
			}*/
			return $extra_class;
		}

		public function widget_categories_args($cat_args)
		{
			$cat_args['taxonomy'] = 'category';
			return $cat_args;
		}

		/**
		 * Move cat_count into tag A
		 *
		 * @param $links
		 * @param $args
		 * @return mixed
		 */
		public function cat_count_span($links, $args)
		{
			if (isset($args['taxonomy']) && ($args['taxonomy'] == 'category')) {
				$links = str_replace('(', '<span class="count">(', $links);
				$links = str_replace(')', ')</span>', $links);
			}
			return $links;
		}

		/**
		 * Move archive_count into tag A
		 *
		 * @param $links
		 * @return mixed
		 */
		public function archive_count_span($links)
		{
			$links = str_replace('&nbsp;(', '<span class="count">(', $links);
			$links = str_replace(')', ')</span>', $links);
			return $links;
		}

		/**
		 * Set Onepage menu
		 * *******************************************************
		 */
		public function main_menu_one_page($args)
		{
			if (isset($args['theme_location']) && !in_array($args['theme_location'], apply_filters('xmenu_location_apply', array('primary', 'mobile')))) {
				return $args;
			}
			$is_one_page = g5Theme()->metaBox()->get_is_one_page();
			if ($is_one_page === 'on') {
				$args['menu_class'] .= ' menu-one-page';
			}
			return $args;
		}

		public function post_thumbnail_lazyLoad($html, $post_id, $post_image_id)
		{
			$html = preg_replace('/src=/', 'data-original=', $html);
			$html = preg_replace('/srcset=/', 'data-original-set=', $html);
			return $html;
		}

		public function content_lazyLoad($content)
		{
			return preg_replace_callback('/<\s*img[^>]+[^>]+>/i', array($this, 'content_lazyLoad_callback'), $content);
		}

		public function content_lazyLoad_callback($img_match)
		{
			$img_replace = preg_replace('/src=/', 'src="#" data-original=', $img_match[0]);
			$img_replace = preg_replace('/srcset=/', 'data-original-set=', $img_replace);
			$img_replace = preg_replace('/class\s*=\s*"/i', 'class="gf-lazy ', $img_replace);
			return $img_replace;

		}


		function the_post_thumbnail($size = 'post-thumbnail', $attr = '')
		{
			the_post_thumbnail($size, $attr);
		}

        public function get_metro_image_size($image_size_base = '300x300', $layout_ratio = '1x1', $columns_gutter = 0) {
            global $_wp_additional_image_sizes;
            $image_width = 0;
            $image_height = 0;
            $layout_ratio_width = 1;
            $layout_ratio_height = 1;
            $columns_gutter = intval($columns_gutter);
            $width = 0;
            $height = 0;

            $image_size_base_dimension =  $this->get_image_dimension($image_size_base);
            if ($image_size_base_dimension) {
                $image_width = $image_size_base_dimension['width'];
                $image_height = $image_size_base_dimension['height'];
            }

            if (preg_match('/x/',$layout_ratio)) {
                $layout_ratio = preg_split('/x/', $layout_ratio);
                $layout_ratio_width = isset($layout_ratio[0]) ? floatval($layout_ratio[0]) : 0;
                $layout_ratio_height = isset($layout_ratio[1]) ? floatval($layout_ratio[1]) : 0;
            }

            if (($image_width > 0) && ($image_height > 0)) {
                $width = ($layout_ratio_width - 1) * $columns_gutter + $image_width * $layout_ratio_width;
                $height = ($layout_ratio_height - 1) * $columns_gutter + $image_height * $layout_ratio_height;
            }

            if (($width > 0) && ($height > 0)) {
                return "{$width}x{$height}";
            }

            return $image_size_base;
        }

        public function get_metro_image_ratio($image_ratio_base = '1x1', $layout_ratio = '1x1') {
            $layout_ratio_width = 1;
            $layout_ratio_height = 1;

            $image_ratio_base_width = 1;
            $image_ratio_base_height = 1;


            if (preg_match('/x/',$layout_ratio)) {
                $layout_ratio = preg_split('/x/', $layout_ratio);
                $layout_ratio_width = isset($layout_ratio[0]) ? floatval($layout_ratio[0]) : 0;
                $layout_ratio_height = isset($layout_ratio[1]) ? floatval($layout_ratio[1]) : 0;
            }

            if (preg_match('/x/',$image_ratio_base)) {
                $image_ratio_base = preg_split('/x/', $image_ratio_base);
                $image_ratio_base_width = isset($image_ratio_base[0]) ? floatval($image_ratio_base[0]) : 0;
                $image_ratio_base_height = isset($image_ratio_base[1]) ? floatval($image_ratio_base[1]) : 0;
            }

            if (($layout_ratio_width > 0)
                && ($layout_ratio_height > 0)
                && ($image_ratio_base_width > 0)
                && ($image_ratio_base_height > 0)) {
                $image_ratio_width = $image_ratio_base_width * $layout_ratio_width;
                $image_ratio_height = $image_ratio_base_height * $layout_ratio_height;
                return "{$image_ratio_width}x{$image_ratio_height}";
            }
            return $image_ratio_base;
        }

        public function get_image_dimension($image_size = 'thumbnail'){
            global $_wp_additional_image_sizes;
            $width = '';
            $height = '';
            if (preg_match('/x/',$image_size)) {
                $image_size = preg_split('/x/', $image_size);
                $width = $image_size[0];
                $height = $image_size[1];
            } elseif (in_array($image_size,array('thumbnail', 'medium','large'))) {
                $width = intval(get_option( $image_size . '_size_w' ));
                $height = intval(get_option( $image_size . '_size_h' ));
            } elseif (isset($_wp_additional_image_sizes[$image_size])) {
                $width = intval($_wp_additional_image_sizes[ $image_size ]['width']);
                $height = intval($_wp_additional_image_sizes[ $image_size ]['height']) ;
            }

            if ($width !== '' && $height !== '') {
                return array(
                    'width' => $width,
                    'height' => $height
                );
            }
            return false;
        }

        public function get_theme_options_url() {
            $url = '#';
            if (function_exists('G5P')) {
                $url =  admin_url('admin.php?page=gsf_options');
            }
            return $url;
        }
	}
}