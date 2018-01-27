<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('G5P_Inc_ShortCode')) {
	class G5P_Inc_ShortCode
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
			// Auto Loader Class
			spl_autoload_register(array($this, 'autoload_class_file'));

			// vc learn map
			add_action('vc_before_mapping', array($this, 'vc_lean_map'));

		}

		/**
		 * Auto Loader Class
		 *
		 * @param $class_name
		 */
		public function autoload_class_file($class)
		{

			$file_name = preg_replace('/^WPBakeryShortCode_gsf_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				G5P()->loadFile(G5P()->pluginDir("shortcodes/{$file_name}/{$file_name}.php"));
			}
		}

		public function includes()
		{
			G5P()->loadFile(G5P()->pluginDir('shortcodes/shortcode-base.class.php'));
		}

		/**
		 * Get Shortcodes category name
		 *
		 * @return string
		 */
		public function get_category_name()
		{
			$current_theme = wp_get_theme();
			return $current_theme['Name'] . ' Shortcodes';
		}

		/**
		 * Get List Shortcodes
		 *
		 * @return mixed|void
		 */
		private function get_shortcodes()
		{
			return apply_filters('gsf_shorcodes', array(
				'gsf_banner',
				'gsf_border',
				'gsf_breadcrumbs',
				'gsf_button',
				'gsf_countdown',
				'gsf_counter',
				'gsf_gallery',
				'gsf_google_map',
				'gsf_heading',
				'gsf_icon_box',
				'gsf_lists',
				'gsf_menu_column',
				'gsf_our_team',
				'gsf_page_title',
				'gsf_partner_carousel',
				'gsf_posts',
				'gsf_slider_container',
				'gsf_social_networks',
				'gsf_social_share',
				'gsf_space',
				'gsf_testimonials',
				'gsf_video',
                'gsf_video_with_background',
                'gsf_view_demo'
			));
		}

		public function vc_lean_map()
		{
			$shorcodes = $this->get_shortcodes();
			foreach ($shorcodes as $key) {
				$directory = preg_replace('/^gsf_/', '', $key);
				vc_lean_map($key, null, G5P()->pluginDir('shortcodes/' . str_replace('_', '-', $directory) . '/config.php'));
			}
		}

		/**
		 * Get Setting Icon Font
		 *
		 * @param array $args
		 * @return array
		 */
		public function vc_map_add_icon_font($args = array())
		{
			$default = array(
				'type' => 'gsf_icon_picker',
				'heading' => esc_html__('Icon', 'april-framework'),
				'param_name' => 'icon_font',
				'value' => '',
				'description' => esc_html__('Select icon from library.', 'april-framework')
			);

			$default = array_merge($default,$args);
			return $default;
		}

		/**
		 * Animation Style
		 *
		 * @param bool $label
		 * @return array
		 */
		public function vc_map_add_css_animation($label = true)
		{
			$data =  array(
				'type' => 'animation_style',
				'heading' => esc_html__('CSS Animation', 'april-framework'),
				'param_name' => 'css_animation',
				'admin_label' => $label,
				'value' => '',
				'settings' => array(
					'type' => 'in',
					'custom' => array(
						array(
							'label' => esc_html__('Default', 'april-framework'),
							'values' => array(
								esc_html__('Top to bottom', 'april-framework') => 'top-to-bottom',
								esc_html__('Bottom to top', 'april-framework') => 'bottom-to-top',
								esc_html__('Left to right', 'april-framework') => 'left-to-right',
								esc_html__('Right to left', 'april-framework') => 'right-to-left',
								esc_html__('Appear from center', 'april-framework') => 'appear',
							),
						),
					),
				),
				'description' => esc_html__('Select type of animation for element to be animated when it enters the browsers viewport (Note: works only in modern browsers).', 'april-framework'),
				'group' => esc_html__('Animation', 'april-framework')
			);
			return apply_filters( 'vc_map_add_css_animation', $data, $label );
		}


		/**
		 * Animation Duration
		 *
		 * @return array
		 */
		public function vc_map_add_animation_duration()
		{
			return array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'april-framework'),
				'param_name' => 'animation_duration',
				'value' => '',
				'description' => wp_kses_post(__('Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'april-framework')),
				'group' => esc_html__('Animation', 'april-framework')
			);
		}

		/**
		 * Animation Delay
		 *
		 * @return array
		 */
		public function vc_map_add_animation_delay()
		{
			return array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'april-framework'),
				'param_name' => 'animation_delay',
				'value' => '',
				'description' => esc_html__('Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'april-framework'),
				'group' => esc_html__('Animation', 'april-framework')
			);
		}



		/**
		 * Extra Class
		 *
		 * @return array
		 */
		public function vc_map_add_extra_class()
		{
			$args = array(
				'type' => 'gsf_selectize',
				'heading' => esc_html__('Extra class name', 'april-framework'),
				'param_name' => 'el_class',
				'tags' => true,
				'std' => '',
				'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'april-framework'),
			);
			$extra_class = &G5P()->helper()->get_extra_class();
			if (is_array($extra_class) && sizeof($extra_class) > 0) {
				$args['value'] = $extra_class;
			}
			return $args;
		}

		/**
		 * Design Options
		 *
		 * @return array
		 */
		public function vc_map_add_css_editor()
		{
			return array(
				'type' => 'css_editor',
				'heading' => esc_html__('CSS box', 'april-framework'),
				'param_name' => 'css',
				'group' => esc_html__('Design Options', 'april-framework'),
			);
		}

		public function vc_map_add_responsive() {
			return array(
				'type' => 'gsf_responsive',
				'heading' => esc_html__( 'Responsive', 'april-framework' ),
				'param_name' => 'responsive',
				'group' => esc_html__( 'Responsive Options', 'april-framework' ),
				'description' => esc_html__( 'Adjust column for different screen sizes. Control visibility settings.', 'april-framework' ),
			);
		}

		public function vc_map_add_color_skin($args = array()) {
			$default = array(
				'type' => 'dropdown',
				'heading' => esc_html__('Color Skin', 'april-framework'),
				'param_name' => 'color_skin',
				'description' => esc_html__('Select color skin.', 'april-framework'),
				'value' => $this->get_color_skin(true),
				'std' => '',
				'admin_label' => true,

			);
			$default = array_merge($default,$args);
			return $default;
		}

		/**
		 * Get Color Skin
		 *
		 * @param bool $default
		 * @return array
		 */
		public function get_color_skin($default = false)
		{
			$skins = array();
			if ($default) {
				$skins[esc_html__('Inherit', 'april-framework')] = '';
			}
			$custom_color_skin = G5P()->optionsSkin()->get_color_skin();
			if (is_array($custom_color_skin)) {
				foreach ($custom_color_skin as $key => $value) {
					if (isset($value['skin_name']) && isset($value['skin_id'])) {
						$skins[$value['skin_name']] = $value['skin_id'];
					}

				}
			}
			return $skins;
		}

		/**
		 * @param array $args
		 * @return array
		 */
		public function vc_map_add_narrow_category($args = array()) {
			$category = array();
			$categories = get_categories(array('hide_empty' => '1'));
			if (is_array($categories)) {
				foreach ($categories as $cat) {
					$category[$cat->name] = $cat->slug;
				}
			}
			$default =  array(
				'type' => 'gsf_selectize',
				'heading' => esc_html__('Narrow Category', 'april-framework'),
				'param_name' => 'category',
				'value' => $category,
				'multiple' => true,
				'description' => esc_html__( 'Enter categories by names to narrow output (Note: only listed categories will be displayed, divide categories with linebreak (Enter)).', 'april-framework' ),
				'std' => ''
			);
			$default = array_merge($default,$args);
			return $default;
		}

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_product_category($args = array()) {
            $category = array();
            $categories = get_categories(array('hide_empty' => '1', 'taxonomy' => 'product_cat'));
            if (is_array($categories)) {
                foreach ($categories as $cat) {
                    $category[$cat->name] = $cat->slug;
                }
            }
            $default =  array(
                'type' => 'dropdown',
                'heading' => esc_html__('Category', 'april-framework'),
                'param_name' => 'category',
                'value' => $category,
                'description' => esc_html__( 'Enter categories by names to narrow output (Note: only listed categories will be displayed, divide categories with linebreak (Enter)).', 'april-framework' ),
                'std' => ''
            );
            $default = array_merge($default,$args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_product_narrow_categories($args = array()) {
            $category = array();
            $categories = get_categories(array('hide_empty' => '1', 'taxonomy' => 'product_cat'));
            if (is_array($categories)) {
                foreach ($categories as $cat) {
                    $category[$cat->name] = $cat->slug;
                }
            }
            $default =  array(
                'value' => $category,
                'type' => 'gsf_selectize',
                'heading' => esc_html__('Narrow Category', 'april-framework'),
                'param_name' => 'category',
                'multiple' => true,
                'description' => esc_html__( 'Enter categories by names to narrow output (Note: only listed categories will be displayed, divide categories with linebreak (Enter)).', 'april-framework' ),
                'std' => ''
            );
            $default = array_merge($default,$args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_portfolio_narrow_categories($args = array()) {
            $category = array();
            $categories = get_categories(array('hide_empty' => '1', 'taxonomy' => 'portfolio_cat'));
            if (is_array($categories)) {
                foreach ($categories as $cat) {
                    $category[$cat->name] = $cat->slug;
                }
            }
            $default =  array(
                'value' => $category,
                'type' => 'gsf_selectize',
                'heading' => esc_html__('Narrow Category', 'april-framework'),
                'param_name' => 'category',
                'multiple' => true,
                'description' => esc_html__( 'Enter categories by names to narrow output (Note: only listed categories will be displayed, divide categories with linebreak (Enter)).', 'april-framework' ),
                'std' => ''
            );
            $default = array_merge($default,$args);
            return $default;
        }

		/**
		 * @param array $args
		 * @return array
		 */
		public function vc_map_add_narrow_tag($args = array()) {
			$tag = array();
			$tags = get_tags(array('hide_empty' => '1'));
			if (is_array($tags)) {
				foreach ($tags as $tg) {
					$tag[$tg->name] = $tg->slug;
				}
			}
			$default =  array(
				'type' => 'gsf_selectize',
				'heading' => esc_html__('Narrow Tag', 'april-framework'),
				'param_name' => 'tag',
				'value' => $tag,
				'multiple' => true,
				'description' => esc_html__( 'Enter tags by names to narrow output).', 'april-framework' ),
				'std' => ''
			);
			$default = array_merge($default,$args);
			return $default;
		}

		/**
		 * @param array $array
		 * @return array
		 */
		public function switch_array_key_value($array = array() ) {
			$result = array();
			foreach ($array as $key => $value) {
				$result[$value] = $key;
			}
			return $result;
		}

		/**
		 * @return array
		 */
		public function get_toggle() {
			return array(
				esc_html__( 'On', 'april-framework' ) => '1',
				esc_html__( 'Off', 'april-framework' ) => '0'
			);
		}

		/**
		 * @param array $args
		 * @return array
		 */
		public function vc_map_add_title($args = array()) {
			$default = array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'april-framework' ),
				'param_name' => 'title'
			);
			$default = array_merge($default,$args);
			return $default;
		}

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_pagination($args = array()) {
            $default = array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Show pagination control', 'april-framework'),
                'param_name' => 'dots',
                'std' => '',
            );
            $default = array_merge($default,$args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_navigation($args = array()) {
            $default = array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Show navigation control', 'april-framework'),
                'param_name' => 'nav',
                'std' => 'on',
            );
            $default = array_merge($default,$args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_navigation_position($args = array()) {
            $default = array(
                'type' => 'dropdown',
                'heading' => esc_html__('Navigation Position', 'april-framework'),
                'param_name' => 'nav_position',
                'value' => array(
                    esc_html__('Top Right','april-framework') => 'nav-top-right',
                    esc_html__('Center','april-framework') => 'nav-center',
                    esc_html__('Bottom Left','april-framework') => 'nav-bottom-left',
                    esc_html__('Bottom Center','april-framework') => 'nav-bottom-center',
                    esc_html__('Bottom Right','april-framework') => 'nav-bottom-right'
                ),
                'std' => 'nav-top-right',
                'dependency' => array('element' => 'nav', 'value' => 'on')
            );
            $default = array_merge($default,$args);
            return $default;
        }

        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_navigation_style($args = array()) {
            $default = array(
                'type' => 'dropdown',
                'heading' => esc_html__('Navigation Style', 'april-framework'),
                'param_name' => 'nav_style',
                'value' => array(
                    esc_html__('Only Icon','april-framework') => 'nav-icon',
                    esc_html__('Square with Icon','april-framework') => 'nav-square-icon',
                    esc_html__('Square with Text','april-framework') => 'nav-square-text',
                    esc_html__('Circle with Icon','april-framework') => 'nav-circle-icon',
                    esc_html__('Circle with Text','april-framework') => 'nav-circle-text',
                ),
                'std' => 'nav-square-icon',
                'dependency' => array('element' => 'nav', 'value' => 'on')
            );
            $default = array_merge($default,$args);
            return $default;
        }


        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_autoplay_enable($args = array()) {
            $default = array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Autoplay Enable', 'april-framework'),
                'param_name' => 'autoplay',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            );
            $default = array_merge($default,$args);
            return $default;
        }


        /**
         * @param array $args
         * @return array
         */
        public function vc_map_add_autoplay_timeout($args = array()) {
            $default = array(
                'type' => 'gsf_number',
                'heading' => esc_html__('Autoplay Timeout', 'april-framework'),
                'param_name' => 'autoplay_timeout',
                'std' => '5000',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'autoplay', 'value' => 'on')
            );
            $default = array_merge($default,$args);
            return $default;
        }

		/**
		 * @return array
		 */
		public function get_post_filter() {
			return array(
				$this->vc_map_add_narrow_category(array(
					'group' => esc_html__( 'Posts Filter', 'april-framework' )
				)),
				$this->vc_map_add_narrow_tag(array(
					'group' => esc_html__( 'Posts Filter', 'april-framework' )
				)),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Narrow Post', 'april-framework' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						//'sortable' => true,
						'unique_values' => true,
						'display_inline' => true
					),
					'save_always' => true,
					'group' => esc_html__( 'Posts Filter', 'april-framework' ),
					'description' => esc_html__( 'Enter List of Posts', 'april-framework' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'april-framework' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Date', 'april-framework' ) => 'date',
						esc_html__( 'Order by post ID', 'april-framework' ) => 'ID',
						esc_html__( 'Author', 'april-framework' ) => 'author',
						esc_html__( 'Title', 'april-framework' ) => 'title',
						esc_html__( 'Last modified date', 'april-framework' ) => 'modified',
						esc_html__( 'Post/page parent ID', 'april-framework' ) => 'parent',
						esc_html__( 'Number of comments', 'april-framework' ) => 'comment_count',
						esc_html__( 'Menu order/Page Order', 'april-framework' ) => 'menu_order',
						esc_html__( 'Meta value', 'april-framework' ) => 'meta_value',
						esc_html__( 'Meta value number', 'april-framework' ) => 'meta_value_num',
						esc_html__( 'Random order', 'april-framework' ) => 'rand',
					),
					'group' => esc_html__( 'Posts Filter', 'april-framework' ),
					'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'april-framework' )
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Time Filter', 'april-framework' ),
					'param_name'  => 'time_filter',
					'value'     => array(
						esc_html__( 'No Filter', 'april-framework' ) => 'none',
						esc_html__( 'Today Posts', 'april-framework' ) => 'today',
						esc_html__( 'Today + Yesterday Posts', 'april-framework' ) => 'yesterday',
						esc_html__( 'This Week Posts', 'april-framework' ) => 'week',
						esc_html__( 'This Month Posts', 'april-framework' ) => 'month',
						esc_html__( 'This Year Posts', 'april-framework' ) => 'year'
					),
					'group' => esc_html__( 'Posts Filter', 'april-framework' )
				),
				array(
					'type' => 'gsf_button_set',
					'heading' => esc_html__( 'Sorting', 'april-framework' ),
					'param_name' => 'order',
					'value' => array(
						esc_html__( 'Descending', 'april-framework' ) => 'DESC',
						esc_html__( 'Ascending', 'april-framework' ) => 'ASC',
					),
					'std' => 'DESC',
					'group' => esc_html__( 'Posts Filter', 'april-framework' ),
					'description' => esc_html__( 'Select sorting order.', 'april-framework' ),
				),

				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Meta key', 'april-framework' ),
					'param_name' => 'meta_key',
					'description' => esc_html__( 'Input meta key for grid ordering.', 'april-framework' ),
					'group' => esc_html__( 'Posts Filter', 'april-framework' ),
					'dependency' => array(
						'element' => 'orderby',
						'value' => array( 'meta_value', 'meta_value_num' ),
					),
				)
			);
		}

		public function get_post_carousel_layout($inherit = false) {
			$config =  apply_filters('gsf_post_layout',array(
				'large-image' => array(
					'label' => esc_html__('Large Image', 'april-framework'),
					'img' => G5P()->pluginUrl('assets/images/theme-options/blog-large-image.png'),
				),
				'medium-image' => array(
					'label' => esc_html__('Medium Image', 'april-framework'),
					'img' => G5P()->pluginUrl('assets/images/theme-options/blog-medium-image.png'),
				),
				'medium-image-2' => array(
					'label' => esc_html__('Medium Image 2', 'april-framework'),
					'img' => G5P()->pluginUrl('assets/images/theme-options/blog-medium-image-2.png'),
				),
				'grid' => array(
					'label' => esc_html__('Grid', 'april-framework'),
					'img' => G5P()->pluginUrl('assets/images/theme-options/blog-grid.png'),
				)
			));
			if ($inherit) {
				$config = array(
						'-1' => array(
							'label' => esc_html__('Default', 'april-framework'),
							'img' => G5P()->pluginUrl('assets/images/theme-options/default.png'),
						),
					) + $config;
			}
			return $config;
		}

		public function get_column_responsive($dependency = array()) {
		    $responsive = array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Large Devices', 'april-framework'),
                    'description' => esc_html__('Browser Width >= 1200px', 'april-framework'),
                    'param_name' => 'columns',
                    'value' => G5P()->settings()->get_post_columns(),
                    'std' => 3,
                    'group' => esc_html__('Responsive','april-framework'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Medium Devices', 'april-framework'),
                    'param_name' => 'columns_md',
                    'description' => esc_html__('Browser Width < 1200px', 'april-framework'),
                    'value' => G5P()->settings()->get_post_columns(),
                    'std' => 2,
                    'group' => esc_html__('Responsive','april-framework'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Small Devices', 'april-framework'),
                    'param_name' => 'columns_sm',
                    'description' => esc_html__('Browser Width < 992px', 'april-framework'),
                    'value' => G5P()->settings()->get_post_columns(),
                    'std' => 2,
                    'group' => esc_html__('Responsive','april-framework'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Extra Small Devices', 'april-framework'),
                    'param_name' => 'columns_xs',
                    'description' => esc_html__('Browser Width < 768px', 'april-framework'),
                    'value' => G5P()->settings()->get_post_columns(),
                    'std' => 1,
                    'group' => esc_html__('Responsive','april-framework'),
                    'dependency' => $dependency
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Extra Extra Small Devices', 'april-framework'),
                    'param_name' => 'columns_mb',
                    'description' => esc_html__('Browser Width < 600px', 'april-framework'),
                    'value' => G5P()->settings()->get_post_columns(),
                    'std' => 1,
                    'group' => esc_html__('Responsive','april-framework'),
                    'dependency' => $dependency
                )
            );
		    return $responsive;
        }
	}
}