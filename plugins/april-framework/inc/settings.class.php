<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists(' G5P_Inc_Settings')) {
	class  G5P_Inc_Settings
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
		 * Get Main Layout
		 *
		 * @param bool $default
		 * @return mixed|void
		 */
		public function get_main_layout($default = false)
		{
			$defaults = array();
			if ($default) {
				$defaults[''] = array(
					'label' => esc_html__('Inherit', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
				);
			}
			$config = apply_filters('gsf_options_main_layout', array(
				'wide'     => array(
					'label' => esc_html__('Wide', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-wide.png'),
				),
				'boxed'    => array(
					'label' => esc_html__('Boxed', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-boxed.png'),
				),
				'framed'   => array(
					'label' => esc_html__('Framed', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-framed.png'),
				),
				'bordered' => array(
					'label' => esc_html__('Bordered', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-bordered.png'),
				)
			));

			$config = wp_parse_args($config, $defaults);
			return $config;
		}

		/**
		 * Get Sidebar Layout
		 *
		 * @param bool $inherit
		 * @return mixed|void
		 */
		public function get_sidebar_layout($inherit = false)
		{
			$config = apply_filters('gsf_options_sidebar_layout', array(
				'none'  => array(
					'label' => esc_html__('Full Width', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/sidebar-none.png'),
				),
				'left'  => array(
					'label' => esc_html__('Left Sidebar', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/sidebar-left.png'),
				),
				'right' => array(
					'label' => esc_html__('Right Sidebar', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/sidebar-right.png'),
				)
			));

			if ($inherit) {
				$config = array(
						'' => array(
							'label' => esc_html__('Inherit', 'april-framework'),
							'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
						)
					) + $config;
			}
			return $config;
		}

		/**
		 * Get Sidebar Width
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_sidebar_width($inherit = false)
		{
			$config = apply_filters('gsf_options_sidebar_width', array(
				'small' => esc_html__('Small (1/4)', 'april-framework'),
				'large' => esc_html__('Large (1/3)', 'april-framework')
			));
			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}
			return $config;
		}

		/**
		 * Get Toggle
		 *
		 * @param bool $inherit
		 * @return array
		 */
		public function get_toggle($inherit = false)
		{
			$config = array(
				'on'  => esc_html__('On', 'april-framework'),
				'off' => esc_html__('Off', 'april-framework')
			);

			if ($inherit) {
				$config = array('' => esc_html__('Inherit', 'april-framework')) + $config;
			}
			return $config;
		}

		/**
		 * Get Header Customize Nav Required
		 *
		 * @return array
		 */
		public function get_header_customize_nav_required()
		{
			return apply_filters('gsf_options_header_customize_nav_required', array('header-1', 'header-2', 'header-3', 'header-7', 'header-8'));
		}

		/**
		 * Get Header Customize Left Required
		 *
		 * @return array
		 */
		public function get_header_customize_left_required()
		{
			return apply_filters('gsf_options_header_customize_nav_required', array('header-4', 'header-6'));
		}

		/**
		 * Get Header Customize Right Required
		 *
		 * @return array
		 */
		public function get_header_customize_right_required()
		{
			return apply_filters('gsf_options_header_customize_nav_required', array('header-4', 'header-5', 'header-6'));
		}

		/**
		 * Get Search Ajax Post Type
		 *
		 * @return array
		 */
		public function get_search_ajax_popup_post_type()
		{

			$output = array(
				'post' => esc_html__('Post', 'april-framework'),
				'page' => esc_html__('Page', 'april-framework'),
			);

			if (class_exists('WooCommerce')) {
				$output['product'] = esc_html__('Product', 'april-framework');
			}


			return apply_filters('gsf_options_get_search_popup_ajax_post_type', $output);
		}

		/**
		 * Get Maintenance Mode
		 *
		 * @return array
		 */
		public function get_maintenance_mode()
		{
			return apply_filters('gsf_options_maintenance_mode', array(
				'2' => 'On (Custom Page)',
				'1' => 'On (Standard)',
				'0' => 'Off',
			));
		}

		/**
		 * Get Header Layout
		 *
		 * @return array
		 */
		public function get_header_layout()
		{
			return apply_filters('gsf_options_header_layout', array(
				'header-1' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-1.jpg'),
					'label' => esc_html__('Header 1', 'april-framework')
				),
				'header-2' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-2.jpg'),
					'label' => esc_html__('Header 2', 'april-framework')
				),
				'header-3' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-3.jpg'),
					'label' => esc_html__('Header 3', 'april-framework')
				),
				'header-4' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-4.jpg'),
					'label' => esc_html__('Header 4', 'april-framework')
				),
				'header-5' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-5.jpg'),
					'label' => esc_html__('Header 5', 'april-framework')
				),
				'header-6' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-6.jpg'),
					'label' => esc_html__('Header 6', 'april-framework')
				),
				'header-7' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-7.jpg'),
					'label' => esc_html__('Header 7', 'april-framework')
				),
				'header-8' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-8.jpg'),
					'label' => esc_html__('Header 8', 'april-framework')
				),
			));
		}

		/**
		 * Get Header Customize
		 *
		 * @return array
		 */
		public function get_header_customize()
		{
			$settings = array(
				'search'          => esc_html__('Search', 'april-framework'),
				'social-networks' => esc_html__('Social Networks', 'april-framework'),
				'sidebar'         => esc_html__('Sidebar', 'april-framework'),
				'custom-html'     => esc_html__('Custom Html', 'april-framework'),
				'canvas-sidebar'  => esc_html__('Canvas Sidebar', 'april-framework'),
			);
			if (class_exists('WooCommerce')) {
				$settings['shopping-cart'] = esc_html__('Shopping Cart', 'april-framework');
			} else {
			    unset($settings['shopping-cart']);
            }
			return apply_filters('gsf_options_header_customize', $settings);
		}

		/**
		 * Get Header Mobile Layout
		 *
		 * @return array
		 */
		public function get_header_mobile_layout()
		{
			return apply_filters('gsf_options_header_mobile_layout', array(
				'header-1' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-mobile-layout-1.png'),
					'label' => esc_html__('Layout 1', 'april-framework')
				),
				'header-2' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-mobile-layout-2.png'),
					'label' => esc_html__('Layout 2', 'april-framework')
				),
				'header-3' => array(
					'img'   => G5P()->pluginUrl('assets/images/theme-options/header-mobile-layout-3.png'),
					'label' => esc_html__('Layout 3', 'april-framework')
				)
			));
		}




		/**
		 * Get Bottom Bar Layout
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_border_layout($inherit = false)
		{
			$config = apply_filters('gsf_options_border_layout', array(
				'none'      => esc_html__('None', 'april-framework'),
				'full'      => esc_html__('Full', 'april-framework'),
				'container' => esc_html__('Container', 'april-framework')
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}
			return $config;
		}

		/**
		 * Get Loading Animation
		 *
		 * @return array
		 */
		public function get_loading_animation()
		{
			return apply_filters('gsf_options_loading_animation', array(
				''              => esc_html__('None','april-framework'),
				'chasing-dots'  => esc_html__('Chasing Dots', 'april-framework'),
				'circle'        => esc_html__('Circle', 'april-framework'),
				'cube'          => esc_html__('Cube', 'april-framework'),
				'double-bounce' => esc_html__('Double Bounce', 'april-framework'),
				'fading-circle' => esc_html__('Fading Circle', 'april-framework'),
				'folding-cube'  => esc_html__('Folding Cube', 'april-framework'),
				'pulse'         => esc_html__('Pulse', 'april-framework'),
				'three-bounce'  => esc_html__('Three Bounce', 'april-framework'),
				'wave'          => esc_html__('Wave', 'april-framework'),
			));
		}

		/**
		 * Get Top Drawer Mode
		 *
		 * @return mixed|void
		 */
		public function get_top_drawer_mode()
		{
			return apply_filters('gsf_options_top_drawer_mode', array(
				'hide'   => esc_html__('Hide', 'april-framework'),
				'toggle' => esc_html__('Toggle', 'april-framework'),
				'show'   => esc_html__('Show', 'april-framework')
			));
		}

		/**
		 * Get Color Skin default
		 *
		 * @return mixed|void
		 */
		public function &get_color_skin_default()
		{
			$skin_default = array(
				array(
					'skin_id'          => 'skin-light',
					'skin_name'        => esc_html__('Light', 'april-framework'),
					'background_color' => '#fff',
					'text_color'       => '#696969',
                    'text_hover_color'    => '',
					'heading_color'    => '#333',
					'disable_color'    => '#ababab',
					'border_color'     => '#efefef'
				),
				array(
					'skin_id'          => 'skin-dark',
					'skin_name'        => esc_html__('Dark', 'april-framework'),
					'background_color' => '#333',
					'text_color'       => '#ababab',
                    'text_hover_color'    => '',
					'heading_color'    => '#fff',
					'disable_color'    => '#696969',
					'border_color'     => '#4d4d4d'
				),
			);
			return $skin_default;
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
				$skins[] = esc_html__('Inherit', 'april-framework');
			}
			$custom_color_skin = G5P()->optionsSkin()->get_color_skin();
			if (is_array($custom_color_skin)) {
				foreach ($custom_color_skin as $key => $value) {
					if (isset($value['skin_name']) && isset($value['skin_id'])) {
						$skins[$value['skin_id']] = $value['skin_name'];
					}

				}
			}
			return $skins;
		}

		public function getPresetPostType()
		{
			$settings = array(
				'page_404' => array(
					'title' => esc_html__('404 Page', 'april-framework')
				),
				'post'     => array(
					'title'  => esc_html__('Blog', 'april-framework'),
					'preset' => array(
						'blog'        => array(
							'title' => esc_html__('Blog Listing', 'april-framework'),
						),
						'single_blog' => array(
							'title'     => esc_html__('Single Blog', 'april-framework'),
							'is_single' => true,
						)
					)
				)
			);

			if (class_exists('WooCommerce')) {
				$settings = array_merge($settings, array(
					'product' => array(
						'title'  => esc_html__('Woocommerce', 'april-framework'),
						'preset' => array(
							'archive_product' => array(
								'title'      => esc_html__('Product Listing', 'april-framework'),
								'category'   => 'product_cat',
								'tag'        => 'product_tag',
								'is_archive' => true,
							),
							'single_product'  => array(
								'title'     => esc_html__('Single Product', 'april-framework'),
								'is_single' => true,
							)
						)
					)
				));
			}
			return apply_filters('gsf_options_preset', $settings);
		}

		public function get_custom_post_layout_settings()
		{
			$settings = array(
				'search' => array(
					'title' => esc_html__('Search Listing', 'april-framework')
				)
			);

			return apply_filters('gsf_options_custom_post_layout_settings', $settings);
		}

		/**
		 * Get social networks default
		 *
		 * @return array
		 */
		public function get_social_networks_default()
		{
			$social_networks = array(
				array(
					'social_name'  => esc_html__('Facebook', 'april-framework'),
					'social_id'    => 'social-facebook',
					'social_icon'  => 'fa fa-facebook',
					'social_link'  => '',
					'social_color' => '#3b5998'
				),
				array(
					'social_name'  => esc_html__('Twitter', 'april-framework'),
					'social_id'    => 'social-twitter',
					'social_icon'  => 'fa fa-twitter',
					'social_link'  => '',
					'social_color' => '#1da1f2'
				),
				array(
					'social_name'  => esc_html__('Pinterest', 'april-framework'),
					'social_id'    => 'social-pinterest',
					'social_icon'  => 'fa fa-pinterest',
					'social_link'  => '',
					'social_color' => '#bd081c'
				),
				array(
					'social_name'  => esc_html__('Dribbble', 'april-framework'),
					'social_id'    => 'social-dribbble',
					'social_icon'  => 'fa fa-dribbble',
					'social_link'  => '',
					'social_color' => '#00b6e3'
				),
				array(
					'social_name'  => esc_html__('LinkedIn', 'april-framework'),
					'social_id'    => 'social-linkedIn',
					'social_icon'  => 'fa fa-linkedin',
					'social_link'  => '',
					'social_color' => '#0077b5'
				),
				array(
					'social_name'  => esc_html__('Vimeo', 'april-framework'),
					'social_id'    => 'social-vimeo',
					'social_icon'  => 'fa fa-vimeo',
					'social_link'  => '',
					'social_color' => '#1ab7ea'
				),
				array(
					'social_name'  => esc_html__('Tumblr', 'april-framework'),
					'social_id'    => 'social-tumblr',
					'social_icon'  => 'fa fa-tumblr',
					'social_link'  => '',
					'social_color' => '#35465c'
				),
				array(
					'social_name'  => esc_html__('Skype', 'april-framework'),
					'social_id'    => 'social-skype',
					'social_icon'  => 'fa fa-skype',
					'social_link'  => '',
					'social_color' => '#00aff0'
				),
				array(
					'social_name'  => esc_html__('Google+', 'april-framework'),
					'social_id'    => 'social-google-plus',
					'social_icon'  => 'fa fa-google-plus',
					'social_link'  => '',
					'social_color' => '#dd4b39'
				),
				array(
					'social_name'  => esc_html__('Flickr', 'april-framework'),
					'social_id'    => 'social-flickr',
					'social_icon'  => 'fa fa-flickr',
					'social_link'  => '',
					'social_color' => '#ff0084'
				),
				array(
					'social_name'  => esc_html__('YouTube', 'april-framework'),
					'social_id'    => 'social-youTube',
					'social_icon'  => 'fa fa-youtube',
					'social_link'  => '',
					'social_color' => '#cd201f'
				),
				array(
					'social_name'  => esc_html__('Foursquare', 'april-framework'),
					'social_id'    => 'social-foursquare',
					'social_icon'  => 'fa fa-foursquare',
					'social_link'  => '',
					'social_color' => '#f94877'
				),
				array(
					'social_name'  => esc_html__('Instagram', 'april-framework'),
					'social_id'    => 'social-instagram',
					'social_icon'  => 'fa fa-instagram',
					'social_link'  => '',
					'social_color' => '#405de6'
				),
				array(
					'social_name'  => esc_html__('GitHub', 'april-framework'),
					'social_id'    => 'social-gitHub',
					'social_icon'  => 'fa fa-github',
					'social_link'  => '',
					'social_color' => '#4078c0'
				),
				array(
					'social_name'  => esc_html__('Xing', 'april-framework'),
					'social_id'    => 'social-xing',
					'social_icon'  => 'fa fa-xing',
					'social_link'  => '',
					'social_color' => '#026466'
				),
				array(
					'social_name'  => esc_html__('Behance', 'april-framework'),
					'social_id'    => 'social-behance',
					'social_icon'  => 'fa fa-behance',
					'social_link'  => '',
					'social_color' => '#1769ff'
				),
				array(
					'social_name'  => esc_html__('Deviantart', 'april-framework'),
					'social_id'    => 'social-deviantart',
					'social_icon'  => 'fa fa-deviantart',
					'social_link'  => '',
					'social_color' => '#05cc47'
				),
				array(
					'social_name'  => esc_html__('Sound Cloud', 'april-framework'),
					'social_id'    => 'social-soundCloud',
					'social_icon'  => 'fa fa-soundcloud',
					'social_link'  => '',
					'social_color' => '#ff8800'
				),
				array(
					'social_name'  => esc_html__('Yelp', 'april-framework'),
					'social_id'    => 'social-yelp',
					'social_icon'  => 'fa fa-yelp',
					'social_link'  => '',
					'social_color' => '#af0606'
				),
				array(
					'social_name'  => esc_html__('RSS Feed', 'april-framework'),
					'social_id'    => 'social-rss',
					'social_icon'  => 'fa fa-rss',
					'social_link'  => '',
					'social_color' => '#f26522'
				),
				array(
					'social_name'  => esc_html__('VK', 'april-framework'),
					'social_id'    => 'social-vk',
					'social_icon'  => 'fa fa-vk',
					'social_link'  => '',
					'social_color' => '#45668e'
				),
				array(
					'social_name'  => esc_html__('Email', 'april-framework'),
					'social_id'    => 'social-email',
					'social_icon'  => 'fa fa-envelope',
					'social_link'  => '',
					'social_color' => '#4285f4'
				),

			);
			return $social_networks;
		}

		public function get_social_networks()
		{
			$social_networks = G5P()->options()->get_social_networks();
			$options = array();
			if (is_array($social_networks)) {
				foreach ($social_networks as $social_network) {
					$options[$social_network['social_id']] = $social_network['social_name'];
				}
			}
			return $options;
		}

		/**
		 * Get social share
		 *
		 * @return array
		 */
		public function get_social_share()
		{
			$social_share = array(
				'facebook'  => esc_html__('Facebook', 'april-framework'),
				'twitter'   => esc_html__('Twitter', 'april-framework'),
				'google'    => esc_html__('Google +', 'april-framework'),
				'linkedin'  => esc_html__('Linkedin', 'april-framework'),
				'tumblr'    => esc_html__('Tumblr', 'april-framework'),
				'pinterest' => esc_html__('Pinterest', 'april-framework'),
				'email'     => esc_html__('Email', 'april-framework'),
				'telegram'  => esc_html__('Telegram', 'april-framework'),
				'whatsapp'  => esc_html__('WhatsApp', 'april-framework')
			);
			return $social_share;
		}

		/**
		 * Get Post Layout
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_post_layout($inherit = false)
		{
			$config = apply_filters('gsf_options_post_layout', array(
				'large-image'    => array(
					'label' => esc_html__('Large Image', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/blog-large-image.png'),
				),
				'medium-image'   => array(
					'label' => esc_html__('Medium Image', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/blog-medium-image.png'),
				),
				'grid'         => array(
					'label' => esc_html__('Grid', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/blog-grid.png'),
				),
				'masonry'        => array(
					'label' => esc_html__('Masonry', 'april-framework'),
					'img'   => G5P()->pluginUrl('assets/images/theme-options/blog-masonry.png'),
				)
			));
			if ($inherit) {
				$config = array(
						'' => array(
							'label' => esc_html__('Inherit', 'april-framework'),
							'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
						),
					) + $config;
			}
			return $config;
		}

        public function get_single_post_layout($inherit = false)
        {
            $config = apply_filters('gsf_options_single_post_layout', array(
                'layout-1' => array(
                    'label' => esc_html__('Layout 1', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-layout-1.png'),
                ),
                'layout-2' => array(
                    'label' => esc_html__('Layout 2', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-layout-2.png'),
                ),
                'layout-3' => array(
                    'label' => esc_html__('Layout 3', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-layout-3.png'),
                ),
                'layout-4' => array(
                    'label' => esc_html__('Layout 4', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-layout-4.png'),
                ),
                'layout-5' => array(
                    'label' => esc_html__('Layout 5', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-layout-5.png'),
                ),

            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

		/**
		 * Get Post Columns
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_post_columns($inherit = false)
		{
			$config = apply_filters('gsf_options_post_columns', array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
                '5' => '5',
				'6' => '6'
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}

			return $config;
		}

		/**
		 * Get Post Columns Gap
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_post_columns_gutter($inherit = false)
		{
			$config = apply_filters('gsf_options_post_columns_gutter', array(
				'none'  => esc_html__('None', 'april-framework'),
				'10' => '10px',
				'20' => '20px',
				'30' => '30px'
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}

			return $config;
		}

		/**
		 * Get Post Paging Mode
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_post_paging_mode($inherit = false)
		{
			$config = apply_filters('gsf_options_post_paging_mode', array(
				'pagination'      => esc_html__('Pagination', 'april-framework'),
				'pagination-ajax' => esc_html__('Ajax - Pagination', 'april-framework'),
				'next-prev'       => esc_html__('Ajax - Next Prev', 'april-framework'),
				'load-more'       => esc_html__('Ajax - Load More', 'april-framework'),
				'infinite-scroll' => esc_html__('Ajax - Infinite Scroll', 'april-framework')
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}

			return $config;
		}

		public function get_post_paging_small_mode($inherit = false)
		{
			$config = apply_filters('gsf_options_post_paging_small_mode', array(
				'none'            => esc_html__('None', 'april-framework'),
				'pagination-ajax' => esc_html__('Ajax - Pagination', 'april-framework'),
				'next-prev'       => esc_html__('Ajax - Next Prev', 'april-framework'),
				'load-more'       => esc_html__('Ajax - Load More', 'april-framework'),
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}

			return $config;
		}

		/**
		 * Get Animation
		 *
		 * @param $inherit
		 * @return array|mixed|void
		 */
		public function get_animation($inherit = false)
		{
			$config = apply_filters('gsf_options_animation', array(
				'none'          => esc_html__('None', 'april-framework'),
				'top-to-bottom' => esc_html__('Top to bottom', 'april-framework'),
				'bottom-to-top' => esc_html__('Bottom to top', 'april-framework'),
				'left-to-right' => esc_html__('Left to right', 'april-framework'),
				'right-to-left' => esc_html__('Right to left', 'april-framework'),
				'appear'        => esc_html__('Appear from center', 'april-framework')
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}

			return $config;
		}





		/**
		 * Get Related Post Algorithm
		 *
		 * @param bool $inherit
		 * @return array|mixed|void
		 */
		public function get_related_post_algorithm($inherit = false)
		{
			$config = apply_filters('gsf_options_related_post_algorithm', array(
				'cat'            => esc_html__('by Category', 'april-framework'),
				'tag'            => esc_html__('by Tag', 'april-framework'),
				'author'         => esc_html__('by Author', 'april-framework'),
				'cat-tag'        => esc_html__('by Category & Tag', 'april-framework'),
				'cat-tag-author' => esc_html__('by Category & Tag & Author', 'april-framework'),
				'random'         => esc_html__('Randomly', 'april-framework')
			));

			if ($inherit) {
				$config = array(
						'' => esc_html__('Inherit', 'april-framework')
					) + $config;
			}

			return $config;

		}

        /**
         * Get Related Product Algorithm
         *
         * @param bool $inherit
         * @return array|mixed|void
         */
        public function get_related_product_algorithm()
        {
            $config = apply_filters('gsf_options_related_product_algorithm', array(
                'cat'            => esc_html__('by Category', 'april-framework'),
                'tag'            => esc_html__('by Tag', 'april-framework'),
                'cat-tag'        => esc_html__('by Category & Tag', 'april-framework')
            ));
            return $config;

        }


        public function get_product_catalog_layout($inherit = false)
        {
            $config = apply_filters('gsf_options_product_catalog_layout', array(
                'grid' => array(
                    'label' => esc_html__('Grid', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/shop-grid.jpg'),
                ),
                'list' => array(
                    'label' => esc_html__('List', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/shop-list.jpg'),
                ),
                'metro-01' => array(
                    'label' => esc_html__('Metro 01', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-metro-01.png'),
                ),
                'metro-02' => array(
                    'label' => esc_html__('Metro 02', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-metro-02.png'),
                ),
                'metro-03' => array(
                    'label' => esc_html__('Metro 03', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-metro-03.png'),
                ),
                'metro-04' => array(
                    'label' => esc_html__('Metro 04', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-metro-04.png'),
                ),
                'metro-05' => array(
                    'label' => esc_html__('Metro 05', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-metro-05.png'),
                ),
                'metro-06' => array(
                    'label' => esc_html__('Metro 06', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/layout-metro-06.png'),
                ),
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_product_item_skin($inherit = false)
        {
            $config = apply_filters('gsf_options_product_item_skin', array(
                'product-skin-01' => array(
                    'label' => esc_html__('Skin 01', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-skin-01.png'),
                ),
                'product-skin-02' => array(
                    'label' => esc_html__('Skin 02', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-skin-02.png'),
                ),
                'product-skin-04' => array(
                    'label' => esc_html__('Skin 03', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-skin-04.png'),
                ),
                'product-skin-05' => array(
                    'label' => esc_html__('Skin 04', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-skin-05.png'),
                )
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_post_item_skin($inherit = false)
        {
            $config = apply_filters('gsf_options_post_item_skin', array(
                'post-skin-01' => array(
                    'label' => esc_html__('Skin 01', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-skin-01.png')
                ),
                'post-skin-02' => array(
                    'label' => esc_html__('Skin 02', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-skin-02.png')
                ),
                'post-skin-03' => array(
                    'label' => esc_html__('Skin 03', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/post-skin-03.png')
                )
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png')
                        ),
                    ) + $config;
            }
            return $config;
        }


        public function get_image_ratio($inherit = false)
        {
            $config = apply_filters('gsf_options_image_ratio', array(
                '1x1' => '1:1',
                '4x3' => '4:3',
                '3x4' => '3:4',
                '16x9' => '16:9',
                '9x16' => '9:16',
                'custom' => esc_html__('Custom','april-framework')
            ));
            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'april-framework'),
                    ) + $config;
            }
            return $config;
        }
        public function get_product_single_layout($inherit = false)
        {
            $config = apply_filters('gsf_options_product_single_layout', array(
                'layout-01' => array(
                    'label' => esc_html__('Layout 01', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-single-01.jpg')
                ),
                'layout-02' => array(
                    'label' => esc_html__('Layout 02', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-single-02.jpg')
                ),
                'layout-03' => array(
                    'label' => esc_html__('Layout 03', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-single-03.jpg')
                ),
                'layout-04' => array(
                    'label' => esc_html__('Layout 04', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/product-single-04.jpg')
                )
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_product_image_hover_effect($inherit = false)
        {
            $config = apply_filters('gsf_product_image_hover_effect',array(
                'none' => esc_html__('None','april-framework'),
                'change-image' => esc_html__('Change Image','april-framework'),
                'flip-back' => esc_html__('Flip Back','april-framework')
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'april-framework')
                    ) + $config;
            }

            return $config;
        }
        public function get_portfolio_hover_effect($inherit = false)
        {
            $config = apply_filters('gsf_portfolio_hover_effect',array(
                'none' => esc_html__('None','april-framework'),
                'suprema' => esc_html__('Suprema','april-framework'),
                'layla' => esc_html__('Layla','april-framework'),
                'bubba' => esc_html__('Bubba','april-framework'),
                'jazz' => esc_html__('Jazz','april-framework')
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'april-framework')
                    ) + $config;
            }

            return $config;
        }

        public function get_portfolio_layout($inherit = false)
        {
            $config = apply_filters('gsf_options_portfolio_layout', array(
                'grid' => array(
                    'label' => esc_html__('Grid', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-grid.png'),
                ),
                'masonry' => array(
                    'label' => esc_html__('Masonry', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-masonry.png'),
                ),
                'scattered' => array(
                    'label' => esc_html__('Scattered', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-masonry-sd.png'),
                ),
                'metro-1' => array(
                    'label' => esc_html__('Metro 01', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-1.png'),
                ),
                'metro-2' => array(
                    'label' => esc_html__('Metro 02', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-2.png'),
                ),
                'metro-3' => array(
                    'label' => esc_html__('Metro 03', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-3.png'),
                ),
                'metro-4' => array(
                    'label' => esc_html__('Metro 04', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-4.png'),
                ),
                'metro-5' => array(
                    'label' => esc_html__('Metro 05', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-5.png'),
                ),
                'metro-6' => array(
                    'label' => esc_html__('Metro 06', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-6.png'),
                ),
                'metro-7' => array(
                    'label' => esc_html__('Metro 07', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-7.png'),
                ),
                'carousel-3d' => array(
                    'label' => esc_html__('Carousel 3D', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-3d-carousel.png'),
                ),
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }
        public function get_portfolio_item_skin($inherit = false)
        {
            $config = apply_filters('gsf_options_portfolio_item_skin', array(
                'portfolio-item-skin-01' => array(
                    'label' => esc_html__('Skin 01', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-item-skin-01.png'),
                ),
                'portfolio-item-skin-02' => array(
                    'label' => esc_html__('Skin 02', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-item-skin-02.png'),
                )
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_portfolio_details_default()
        {
            $configs = array(
                array(
                    'title'    => esc_html__('Client','april-framework'),
                    'id'  => 'portfolio_details_client',
                ),
                array(
                    'title'    => esc_html__('My team','april-framework'),
                    'id'  => 'portfolio_details_team',
                ),
                array(
                    'title'    => esc_html__('Awards','april-framework'),
                    'id'  => 'portfolio_details_awards',
                )
            );
            return apply_filters('gsf_portfolio_details_default',$configs);
        }
        public function get_single_portfolio_layout($inherit = false)
        {
            $config = apply_filters('gsf_options_single_portfolio_layout', array(
                'layout-1' => array(
                    'label' => esc_html__('Layout 1', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/single-portfolio-layout-1.png'),
                ),
                'layout-2' => array(
                    'label' => esc_html__('Layout 2', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/single-portfolio-layout-2.png'),
                ),
                'layout-3' => array(
                    'label' => esc_html__('Layout 3', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/single-portfolio-layout-3.png'),
                ),
                'layout-4' => array(
                    'label' => esc_html__('Layout 4', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/single-portfolio-layout-4.png'),
                ),
                'layout-5' => array(
                    'label' => esc_html__('Layout 5', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/single-portfolio-layout-5.png'),
                ),

            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_single_portfolio_gallery_layout($inherit = false)
        {
            $config = apply_filters('gsf_options_single_portfolio_gallery_layout', array(
                'carousel' => array(
                    'label' => esc_html__('Slider', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-gallery-carousel.png'),
                ),
                'thumbnail' => array(
                    'label' => esc_html__('Gallery', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-gallery-thumbnail.png'),
                ),
                'carousel-center' => array(
                    'label' => esc_html__('Slider Center', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-gallery-carousel-center.png'),
                ),
                'grid' => array(
                    'label' => esc_html__('Grid', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-gallery-grid.png'),
                ),
                'carousel-3d' => array(
                    'label' => esc_html__('Slider 3D', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-3d-carousel.png'),
                ),
                'metro' => array(
                    'label' => esc_html__('Metro', 'april-framework'),
                    'img'   => G5P()->pluginUrl('assets/images/theme-options/portfolio-gallery-metro.png'),
                )
            ));
            if ($inherit) {
                $config = array(
                        '' => array(
                            'label' => esc_html__('Inherit', 'april-framework'),
                            'img'   => G5P()->pluginUrl('assets/images/theme-options/default.png'),
                        ),
                    ) + $config;
            }
            return $config;
        }

        public function get_portfolio_related_algorithm($inherit = false)
        {
            $config = apply_filters('gsf_options_portfolio_related_algorithm', array(
                'cat'            => esc_html__('by Category', 'april-framework'),
                'author'         => esc_html__('by Author', 'april-framework'),
                'cat-author' => esc_html__('by Category & Author', 'april-framework'),
                'random'         => esc_html__('Randomly', 'april-framework')
            ));

            if ($inherit) {
                $config = array(
                        '' => esc_html__('Inherit', 'april-framework')
                    ) + $config;
            }

            return $config;

        }
    }
}