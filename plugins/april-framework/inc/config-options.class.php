<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Options')) {
	class G5P_Inc_Config_Options
	{
		/*
		 * loader instances
		 */
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
			// Defined Theme Options
			add_filter('gsf_option_config', array($this, 'define_theme_options'));
		}

		public function define_theme_options($configs)
		{
			$configs['gsf_skins'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__('April Skin Options', 'april-framework'),
				'menu_title'  => esc_html__('Skins Options', 'april-framework'),
				'option_name' => G5P()->getOptionSkinName(),
				'permission'  => 'manage_options',
				'parent_slug' => 'gsf_welcome',
				'fields' => array(
					// Color Skin
					$this->get_config_section_color_skin(),
				),
			);

			$configs['gsf_options'] = array(
				'layout' => 'inline',
				'page_title' => esc_html__('April Theme Options', 'april-framework'),
				'menu_title' => esc_html__('Theme Options', 'april-framework'),
				'option_name' => G5P()->getOptionName(),
				'permission' => 'manage_options',
				'parent_slug' => 'gsf_welcome',
				'preset' => true,
				'section' => array(

					// General
					$this->get_config_section_general(),

					// Layout
					$this->get_config_section_layout(),

					// Top Drawer
					$this->get_config_section_top_drawer(),

					// Top Bar
					$this->get_config_section_top_bar(),

					// Header
					$this->get_config_section_header(),

					// Logo
					$this->get_config_section_logo(),

					// Page Title
					$this->get_config_section_page_title(),

					// Footer
					$this->get_config_section_footer(),

                    // Typography
                    $this->get_config_section_typography(),

					// Icon font
                    $this->get_config_section_icon_font(),

					// Color
					$this->get_config_section_colors(),

					// Connections
					$this->get_config_section_connections(),

					// Blog
					$this->get_config_section_blog(),

                    // Post Types
                    $this->get_config_section_custom_post_type(),

                    // Woocommerce
                    //$this->get_config_section_woocommerce(),

                    // Portfolio
                    //$this->get_config_section_portfolio(),
				)
			);

			if(class_exists('WooCommerce')) {
                $configs['gsf_options']['section'][] =  $this->get_config_section_woocommerce();
            }
            $custom_post_type_disable = G5P()->options()->get_custom_post_type_disable();
            if(!in_array('portfolio', $custom_post_type_disable)) {
                $configs['gsf_options']['section'][] = $this->get_config_section_portfolio();
            }
            $configs['gsf_options']['section'][] = $this->get_config_section_preset();
            $configs['gsf_options']['section'][] = $this->get_config_section_code();

			return $configs;
		}

		/**
		 * Get Config General
		 *
		 * @return array
		 */
		public function get_config_section_general()
		{
			return array(
				'id' => 'section_general',
				'title' => esc_html__('General', 'april-framework'),
				'icon' => 'dashicons dashicons-admin-site',
				'general_options' => true,
				'fields' => array(
					/**
					 * General
					 */
					array(
						'id' => 'section_general_group_general',
						'title' => esc_html__('General', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'smooth_scroll',
								'title' => esc_html__('Smooth Scroll', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable smooth scroll', 'april-framework'),
								'default' => ''
							)),
							$this->get_config_toggle(array(
								'id' => 'lazy_load_images',
								'title' => esc_html__('Lazy Load Images', 'april-framework'),
								'subtitle' => esc_html__('If enabled, images will only be loaded when they come to view', 'april-framework'),
								'default' => ''
							)),

							array(
								'id' => 'section_general_group_custom_scroll',
								'title' => esc_html__('Custom Scroll', 'april-framework'),
								'type' => 'group',
								'fields' => array(
									$this->get_config_toggle(array(
											'id' => 'custom_scroll',
											'title' => esc_html__('Custom Scroll', 'april-framework'),
											'subtitle' => esc_html__('Turn On this option if you want to custom scroll', 'april-framework'),
											'default' => ''
									)),
									array(
										'id' => 'custom_scroll_width',
										'type' => 'text',
										'input_type' => 'number',
										'title' => esc_html__('Custom Scroll Width', 'april-framework'),
										'subtitle' => esc_html__('This must be numeric (no px) or empty.', 'april-framework'),
										'default' => 10,
										'required' => array('custom_scroll', '=', 'on'),
									),
									array(
										'id' => 'custom_scroll_color',
										'type' => 'color',
										'title' => esc_html__('Custom Scroll Color', 'april-framework'),
										'default' => '#19394B',
										'required' => array('custom_scroll', '=', 'on'),
									),
									array(
										'id' => 'custom_scroll_thumb_color',
										'type' => 'color',
										'title' => esc_html__('Custom Scroll Thumb Color', 'april-framework'),
										'default' => '#69d2e7',
										'required' => array('custom_scroll', '=', 'on'),
									),
								)
							),
							$this->get_config_toggle(array(
								'id' => 'back_to_top',
								'title' => esc_html__('Back To Top', 'april-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable back to top', 'april-framework'),
								'default' => 'on'
							)),

							$this->get_config_toggle(array(
								'id' => 'rtl_enable',
								'title' => esc_html__('RTL Mode', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable rtl mode', 'april-framework'),
								'default' => ''
							)),
                            array(
                                'id' => 'menu_transition',
                                'type' => 'select',
                                'title' => esc_html__('Menu Transition','april-framework') ,
                                'default' => 'x-fadeInUp',
                                'general_options' => true,
                                'options' => array(
                                    'none' => esc_html__('None','april-framework'),
                                    'x-fadeIn' => esc_html__('Fade In','april-framework'),
                                    'x-fadeInUp' => esc_html__('Fade In Up','april-framework'),
                                    'x-fadeInDown' => esc_html__('Fade In Down','april-framework'),
                                    'x-fadeInLeft' => esc_html__('Fade In Left','april-framework'),
                                    'x-fadeInRight' => esc_html__('Fade In Right','april-framework'),
                                    'x-flipInX' => esc_html__('Flip In X','april-framework'),
                                    'x-slideInUp' => esc_html__('Slide In Up','april-framework')
                                )
                            ),

							array(
								'id' => 'section_general_group_social_meta',
								'title' => esc_html__('Social Meta', 'april-framework'),
								'type' => 'group',
								'fields' => array(

									$this->get_config_toggle(array(
										'id' => 'social_meta_enable',
										'title' => esc_html__('Enable Social Meta Tags', 'april-framework'),
										'subtitle' => esc_html__('Turn On this option if you want to enable social meta', 'april-framework'),
										'default' => ''
									)),
									array(
										'id' => 'twitter_author_username',
										'type' => 'text',
										'title' => esc_html__('Twitter Username', 'april-framework'),
										'subtitle' => esc_html__('Enter your twitter username here, to be used for the Twitter Card date. Ensure that you do not include the @ symbol.', 'april-framework'),
										'default' => '',
										'required' => array('social_meta_enable', '=', 'on'),
									),
									array(
										'id' => 'googleplus_author',
										'type' => 'text',
										'title' => esc_html__('Google+ Username', 'april-framework'),
										'subtitle' => esc_html__('Enter your Google+ username here, to be used for the authorship meta.', 'april-framework'),
										'default' => '',
										'required' => array('social_meta_enable', '=', 'on'),
									),
								)
							),

							array(
								'id' => 'section_general_group_search_popup',
								'title' => esc_html__('Search Popup', 'april-framework'),
								'type' => 'group',
								'fields' => array(
									array(
										'id' => 'search_popup_post_type',
										'type' => 'checkbox_list',
										'title' => esc_html__('Post Type For Ajax Search', 'april-framework'),
										'options' => G5P()->settings()->get_search_ajax_popup_post_type(),
										'multiple' => true,
										'default' => array('post', 'product'),
									),
									array(
										'id' => 'search_popup_result_amount',
										'type' => 'text',
										'input_type' => 'number',
										'title' => esc_html__('Amount Of Search Result', 'april-framework'),
										'default' => 8,
									)
								)
							),
						)
					),
					/**
					 * Maintenance
					 */
					array(
						'id' => 'section_general_group_maintenance',
						'title' => esc_html__('Maintenance', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'fields' => array(
							array(
								'id' => 'maintenance_mode',
								'type' => 'button_set',
								'title' => esc_html__('Maintenance Mode', 'april-framework'),
								'options' => G5P()->settings()->get_maintenance_mode(),
								'default' => '0'
							),
							array(
								'id' => 'maintenance_mode_page',
								'title' => esc_html__('Maintenance Mode Page', 'april-framework'),
								'subtitle' => esc_html__('Select the page that is your maintenance page, if you would like to show a custom page instead of the standard WordPress message. You should use the Holding Page template for this page.', 'april-framework'),
								'type' => 'selectize',
								'placeholder' => esc_html__('Select Page', 'april-framework'),
								'data' => 'page',
								'data_args' => array(
									'numberposts' => -1
								),
								'edit_link' => true,
								'default' => '',
								'required' => array('maintenance_mode', '=', '2'),

							),
						)
					),
					/**
					 * Page Transition Section
					 * *******************************************************
					 */
					array(
						'id' => 'section_general_group_page_transition',
						'title' => esc_html__('Page Transition', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'page_transition',
								'title' => esc_html__('Page Transition', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable page transition', 'april-framework'),
								'default' => ''
							)),
							array(
								'id' => 'loading_animation',
								'type' => 'select',
								'title' => esc_html__('Loading Animation', 'april-framework'),
								'subtitle' => esc_html__('Select type of pre load animation', 'april-framework'),
								'options' => G5P()->settings()->get_loading_animation(),
								'default' => ''
							),
							array(
								'id' => 'loading_logo',
								'type' => 'image',
								'title' => esc_html__('Logo Loading', 'april-framework'),
								'required' => array('loading_animation', '!=', ''),
							),

							array(
								'id' => 'loading_animation_bg_color',
								'title' => esc_html__('Loading Background Color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '#fff',
								'required' => array('loading_animation', '!=', ''),
							),

							array(
								'id' => 'spinner_color',
								'title' => esc_html__('Spinner color', 'april-framework'),
								'type' => 'color',
								'default' => '',
								'required' => array('loading_animation', '!=', ''),
							),

						)
					),
					/**
					 * Custom Favicon
					 * *******************************************************
					 */
					array(
						'id' => 'section_general_group_custom_favicon',
						'title' => esc_html__('Custom Favicon', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'fields' => array(
							array(
								'id' => 'custom_favicon',
								'type' => 'image',
								'title' => esc_html__('Custom favicon', 'april-framework'),
								'subtitle' => esc_html__('Upload a 16px x 16px Png/Gif/ico image that will represent your website favicon', 'april-framework'),
							),
							array(
								'id' => 'custom_ios_title',
								'type' => 'text',
								'title' => esc_html__('Custom iOS Bookmark Title', 'april-framework'),
								'subtitle' => esc_html__('Enter a custom title for your site for when it is added as an iOS bookmark.', 'april-framework'),
								'default' => ''
							),
							array(
								'id' => 'custom_ios_icon57',
								'type' => 'image',
								'title' => esc_html__('Custom iOS 57x57', 'april-framework'),
								'subtitle' => esc_html__('Upload a 57px x 57px Png image that will be your website bookmark on non-retina iOS devices.', 'april-framework'),
							),
							array(
								'id' => 'custom_ios_icon72',
								'type' => 'image',
								'title' => esc_html__('Custom iOS 72x72', 'april-framework'),
								'subtitle' => esc_html__('Upload a 72px x 72px Png image that will be your website bookmark on non-retina iOS devices.', 'april-framework'),
							),
							array(
								'id' => 'custom_ios_icon114',
								'type' => 'image',
								'title' => esc_html__('Custom iOS 114x114', 'april-framework'),
								'subtitle' => esc_html__('Upload a 114px x 114px Png image that will be your website bookmark on retina iOS devices.', 'april-framework'),
							),
							array(
								'id' => 'custom_ios_icon144',
								'type' => 'image',
								'title' => esc_html__('Custom iOS 144x144', 'april-framework'),
								'subtitle' => esc_html__('Upload a 144px x 144px Png image that will be your website bookmark on retina iOS devices.', 'april-framework'),
							),
						)
					),
					/**
					 * 404 Setting Section
					 * *******************************************************
					 */
					array(
						'id' => 'section_general_group_404',
						'title' => esc_html__('404 Page', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'fields' => array(
							$this->get_config_content_block(array(
								'id' => '404_content_block',
								'subtitle' => esc_html__('Specify the Content Block to use as a 404 page content.', 'april-framework'),
								'required' => array('404_content_block_enable', '=', '1')
							)),
							array(
								'id' => '404_content',
								'title' => esc_html__('404 Page Content', 'april-framework'),
								'default' => '',
								'type' => 'editor',
								'required' => array('404_content_block', '=', '')
							)
						)
					),
				)
			);
		}

		public function get_config_section_preset() {

			$configs = G5P()->settings()->getPresetPostType();
			$fields = array();
			foreach ($configs as $key => $config) {
				if (isset($config['preset']) && is_array($config['preset'])) {
					$group_fields = array();
					foreach ($config['preset'] as $presetKey => $presetValue) {
						$group_fields[] = $this->get_config_preset(array(
							'id' => "preset_{$presetKey}",
							'title' => $presetValue['title'],
							'create_link' => false,
							'link_target' => false,
						));
					}
					$group = array(
						'type' => 'group',
						'title' => $config['title'],
						'fields' => $group_fields
					);
					$fields[] = $group;
				} else {
					$fields[] = $this->get_config_preset(array(
						'id' => "preset_{$key}",
						'title' => $config['title'],
						'create_link' => false,
						'link_target' => false,
					));
				}
			}

			return array(
				'id' => 'section_preset',
				'title' => esc_html__('Preset Setting', 'april-framework'),
				'icon' => 'dashicons dashicons-admin-generic',
				'general_options' => true,
				'fields' => $fields
			);
		}

		/**
		 * Get Config Layout
		 *
		 * @return array
		 */
		public function get_config_section_layout()
		{
			return array(
				'id' => 'section_layout',
				'title' => esc_html__('Layout', 'april-framework'),
				'icon' => 'dashicons dashicons-editor-table',
				'fields' => array(
					array(
						'id' => 'main_layout',
						'title' => esc_html__('Site Layout', 'april-framework'),
						'type' => 'image_set',
						'options' => G5P()->settings()->get_main_layout(),
						'default' => 'wide',
					),


					array(
						'id' => 'section_layout_group_main_content',
						'title' => esc_html__('Main Content', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'content_full_width',
								'title' => esc_html__('Content Full Width', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'april-framework'),
								'default' => '',
							)),
							array(
								'id' => 'content_padding',
								'title' => esc_html__('Content Padding', 'april-framework'),
								'subtitle' => esc_html__('Set content padding', 'april-framework'),
								'type' => 'spacing',
								'default' => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
							),
							$this->get_config_sidebar_layout(array('id' => 'sidebar_layout')),
							$this->get_config_sidebar(array(
								'id' => 'sidebar',
								'default' => 'main',
								'required' => array('sidebar_layout', '!=', 'none')
							)),
							array(
								'id' => 'sidebar_width',
								'title' => esc_html__('Sidebar Width', 'april-framework'),
								'type' => 'button_set',
								'options' => G5P()->settings()->get_sidebar_width(),
								'default' => 'small',
								'required' => array('sidebar_layout', '!=', 'none'),
							),
							$this->get_config_toggle(array(
								'id' => 'sidebar_sticky_enable',
								'title' => esc_html__('Sidebar Sticky', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable sidebar sticky', 'april-framework'),
								'default' => '',
								'required' => array('sidebar_layout', '!=', 'none'),
							))

						)
					),

					array(
						'id' => 'section_layout_group_mobile',
						'title' => esc_html__('Mobile', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'mobile_sidebar_enable',
								'title' => esc_html__('Sidebar Mobile', 'april-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable sidebar on mobile', 'april-framework'),
								'default' => 'on',
								'required' => array('sidebar_layout', '!=', 'none'),
							)),
							$this->get_config_toggle(array(
								'id' => 'mobile_sidebar_canvas',
								'title' => esc_html__('Sidebar Mobile Canvas', 'april-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable canvas sidebar on mobile', 'april-framework'),
								'default' => 'on',
								'required' => array(
									array('sidebar_layout', '!=', 'none'),
									array('mobile_sidebar_enable', '=', 'on'),
								)
							)),
							array(
								'id' => 'mobile_content_padding',
								'title' => esc_html__('Content Padding Mobile', 'april-framework'),
								'subtitle' => esc_html__('Set content top/bottom padding', 'april-framework'),
								'type' => 'spacing'
							),
						)
					),
				)
			);
		}

		/**
		 * Get Config Top Drawer
		 *
		 * @return array
		 */
		public function get_config_section_top_drawer()
		{
			return array(
				'id' => 'section_top_drawer',
				'title' => esc_html__('Top Drawer', 'april-framework'),
				'icon' => 'dashicons dashicons-archive',
				'fields' => array(
					array(
						'id' => 'top_drawer_mode',
						'title' => esc_html__('Top Drawer Mode', 'april-framework'),
						'type' => 'button_set',
						'options' => G5P()->settings()->get_top_drawer_mode(),
						'default' => 'hide'
					),
					$this->get_config_content_block(array(
						'id' => 'top_drawer_content_block',
						'subtitle' => esc_html__('Specify the Content Block to use as a top drawer content.', 'april-framework'),
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
					$this->get_config_toggle(array(
						'id' => 'top_drawer_content_full_width',
						'title' => esc_html__('Top Drawer Full Width', 'april-framework'),
						'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'april-framework'),
						'default' => '',
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
					array(
						'id' => "top_drawer_padding",
						'title' => esc_html__('Padding', 'april-framework'),
						'subtitle' => esc_html__('Set top drawer padding', 'april-framework'),
						'type' => 'spacing',
						'default' => array(
							'top' => 10,
							'bottom' => 10
						),
						'required' => array('top_drawer_mode', '!=', 'hide')
					),
					$this->get_config_border_bottom('top_drawer_border',array(
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
					$this->get_config_toggle(array(
						'id' => 'mobile_top_drawer_enable',
						'title' => esc_html__('Mobile Enable', 'april-framework'),
						'subtitle' => esc_html__('Turn On this option if you want to enable top drawer on mobile', 'april-framework'),
						'default' => '',
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
				)
			);
		}

		/**
		 * Get Config Top Bar
		 *
		 * @return array
		 */
		public function get_config_section_top_bar()
		{
			return array(
				'id' => 'section_top_bar',
				'title' => esc_html__('Top Bar', 'april-framework'),
				'icon' => 'dashicons dashicons-schedule',
				'fields' => array(
					array(
						'id' => 'section_top_bar_group_desktop',
						'title' => esc_html__('Desktop', 'april-framework'),
						'type' => 'group',
						'required' => array('header_layout','not in',array('header-7','header-8')),
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'top_bar_enable',
								'title' => esc_html__('Top Bar Enable', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable top bar', 'april-framework'),
								'default' => ''
							)),
							$this->get_config_content_block(array(
								'id' => 'top_bar_content_block',
								'subtitle' => esc_html__('Specify the Content Block to use as a top bar content.', 'april-framework'),
								'required' => array('top_bar_enable', '=', 'on')
							)),
					)),

					array(
						'id' => 'section_top_bar_group_mobile',
						'title' => esc_html__('Mobile', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'mobile_top_bar_enable',
								'title' => esc_html__('Top Bar Enable', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable top bar', 'april-framework'),
								'default' => ''
							)),
							$this->get_config_content_block(array(
								'id' => 'mobile_top_bar_content_block',
								'subtitle' => esc_html__('Specify the Content Block to use as a top bar content.', 'april-framework'),
								'required' => array('mobile_top_bar_enable', '=', 'on')
							)),
					)),
				)
			);
		}

		/**
		 * Get Config Header
		 *
		 * @return array
		 */
		public function get_config_section_header()
		{
			return array(
				'id' => 'section_header',
				'title' => esc_html__('Header', 'april-framework'),
				'icon' => 'dashicons dashicons-editor-kitchensink',
				'fields' => array(
					G5P()->configOptions()->get_config_toggle( array(
						'id' => 'header_enable',
						'title' => esc_html__('Header Enable','april-framework') ,
						'default' => 'on',
						'subtitle' => esc_html__('Turn Off this option if you want to hide header', 'april-framework'),
					)),
					array(
						'id' => 'header_responsive_breakpoint',
						'type' => 'select',
						'title' => esc_html__('Header Responsive Breakpoint', 'april-framework'),
						'options' => array(
							'1199' => esc_html__('Large Devices: < 1200px', 'april-framework'),
							'991' => esc_html__('Medium Devices: < 992px', 'april-framework'),
							'767' => esc_html__('Tablet Portrait: < 768px', 'april-framework'),
						),
						'default' => '991',
						'required' => array('header_enable','=','on')
					),
					array(
						'id' => 'section_header_group_header_desktop',
						'title' => esc_html__('Desktop', 'april-framework'),
						'type' => 'group',
						'required' => array('header_enable','=','on'),
						'fields' => array(
							array(
								'id' => 'header_layout',
								'title' => esc_html__('Header Layout', 'april-framework'),
								'type' => 'image_set',
								'options' => G5P()->settings()->get_header_layout(),
								'default' => 'header-1',
							),
							$this->get_config_group_header_customize('section_header_group_customize_nav', esc_html__('Customize Navigation', 'april-framework'), 'header_customize_nav', array('search'), array('header_layout', 'in', G5P()->settings()->get_header_customize_nav_required())),
							$this->get_config_group_header_customize('section_header_group_customize_left', esc_html__('Customize Left', 'april-framework'), 'header_customize_left', array(), array('header_layout', 'in', G5P()->settings()->get_header_customize_left_required())),
							$this->get_config_group_header_customize('section_header_group_customize_right', esc_html__('Customize Right', 'april-framework'), 'header_customize_right', array(), array('header_layout', 'in', G5P()->settings()->get_header_customize_right_required())),
							$this->get_config_toggle(array(
								'id' => 'header_content_full_width',
								'title' => esc_html__('Header Full Width', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width', 'april-framework'),
								'default' => '',
								'required' => array('header_layout','not in', array('header-7','header-8'))
							)),
							$this->get_config_toggle(array(
								'id' => 'header_float_enable',
								'title' => esc_html__('Header Float', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable header float', 'april-framework'),
								'default' => '',
								'required' => array('header_layout','not in', array('header-7','header-8'))
							)),
							$this->get_config_toggle(array(
								'id' => 'header_sticky_enable',
								'title' => esc_html__('Header Sticky', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable header sticky', 'april-framework'),
								'default' => '',
								'required' => array('header_layout','not in', array('header-7','header-8'))
							)),
							$this->get_config_border_bottom('header_border',array(
								'required' => array('header_layout','not in', array('header-7','header-8'))
							)),
							$this->get_config_border_bottom('header_above_border',array(
								'title' => esc_html__('Header Above Border Bottom', 'april-framework'),
								'required' =>  array('header_layout','in',array('header-6'))
							)),
							array(
								'id' => 'header_padding',
								'type' => 'spacing',
								'title' => esc_html__('Header Padding', 'april-framework'),
								'subtitle' => esc_html__('If you would like to override the default header padding, then you can do so here.', 'april-framework'),
								'required' => array('header_layout','not in', array('header-7','header-8'))
							),

							array(
								'id' => 'section_header_group_navigation',
								'title' => esc_html__('Navigation', 'april-framework'),
								'type' => 'group',
								'required' => array('header_layout','not in', array('header-7','header-8')),
								'fields' => array(
									array(
										'id' => 'navigation_height',
										'type' => 'dimension',
										'title' => esc_html__('Navigation Height', 'april-framework'),
										'subtitle' => esc_html__('If you would like to override the default navigation height, then you can do so here.', 'april-framework'),
										'width' => false,
										'required' => array('header_layout', 'in', array('header-6'))
									),
									$this->get_config_spacing('navigation_spacing',array(
										'title' => esc_html__('Navigation Spacing', 'april-framework')
									))
								)
							)
						)
					),

					array(
						'id' => 'section_header_group_header_mobile',
						'title' => esc_html__('Mobile', 'april-framework'),
						'type' => 'group',
						'required' => array('header_enable','=','on'),
						'fields' => array(
							array(
								'id' => 'mobile_header_layout',
								'title' => esc_html__('Header Layout', 'april-framework'),
								'type' => 'image_set',
								'options' => G5P()->settings()->get_header_mobile_layout(),
								'default' => 'header-1'
							),
							$this->get_config_toggle(array(
								'id' => 'mobile_header_search_enable',
								'title' => esc_html__('Search Box', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable search box', 'april-framework'),
								'default' => '',
							)),
							$this->get_config_toggle(array(
								'id' => 'mobile_header_sticky_enable',
								'title' => esc_html__('Header Sticky', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable header sticky', 'april-framework'),
								'default' => '',
							)),
							$this->get_config_group_header_customize('section_mobile_header_group_customize', esc_html__('Customize', 'april-framework'), 'header_customize_mobile', array('search')),
							$this->get_config_border_bottom('mobile_header_border'),
							array(
								'id' => 'mobile_header_padding',
								'type' => 'spacing',
								'title' => esc_html__('Header Padding', 'april-framework'),
								'left' => false,
								'right' => false,
								'subtitle' => esc_html__('If you would like to override the default header padding, then you can do so here.', 'april-framework'),
							),
						)
					)

				)
			);
		}

		/**
		 * Get Config Logo
		 *
		 * @return array
		 */
		public function get_config_section_logo()
		{
			return array(
				'id' => 'section_logo',
				'title' => esc_html__('Logo', 'april-framework'),
				'icon' => 'dashicons dashicons-image-filter',
				'fields' => array(
					array(
						'id' => 'section_logo_group_desktop',
						'title' => esc_html__('Desktop', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'logo',
								'title' => esc_html__('Logo', 'april-framework'),
								'subtitle' => esc_html__('By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'april-framework'),
								'type' => 'image',
							),
							array(
								'id' => 'logo_retina',
								'title' => esc_html__('Logo Retina (2x)', 'april-framework'),
								'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'april-framework'),
								'type' => 'image',
								'default' => ''
							),
							array(
								'id' => 'sticky_logo',
								'title' => esc_html__('Sticky Logo', 'april-framework'),
								'type' => 'image',
								'required' => array('header_sticky_enable', '=', 'on')
							),
							array(
								'id' => 'sticky_logo_retina',
								'title' => esc_html__('Sticky Logo Retina', 'april-framework'),
								'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'april-framework'),
								'type' => 'image',
								'default' => '',
								'required' => array('header_sticky_enable', '=', 'on')
							),
							array(
								'id' => 'logo_max_height',
								'title' => esc_html__('Logo Max Height', 'april-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo max height, then you can do so here.', 'april-framework'),
								'type' => 'dimension',
								'width' => false
							),
							array(
								'id' => 'logo_padding',
								'title' => esc_html__('Logo Padding', 'april-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'april-framework'),
								'type' => 'spacing',
								'left' => false,
								'right' => false,
							)
						)
					),
					array(
						'id' => 'section_logo_group_mobile',
						'title' => esc_html__('Mobile', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'mobile_logo',
								'title' => esc_html__('Logo', 'april-framework'),
								'subtitle' => esc_html__('By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'april-framework'),
								'type' => 'image',
							),
							array(
								'id' => 'mobile_logo_retina',
								'title' => esc_html__('Logo Retina (2x)', 'april-framework'),
								'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'april-framework'),
								'type' => 'image',
								'default' => ''
							),
							array(
								'id' => 'mobile_logo_max_height',
								'title' => esc_html__('Logo Max Height', 'april-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo max height, then you can do so here.', 'april-framework'),
								'type' => 'dimension',
								'width' => false
							),
							array(
								'id' => 'mobile_logo_padding',
								'title' => esc_html__('Logo Padding', 'april-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'april-framework'),
								'type' => 'spacing',
								'left' => false,
								'right' => false,
							)
						)
					),
				)
			);
		}

		/**
		 * Get Config Page Title
		 *
		 * @return array
		 */
		public function get_config_section_page_title()
		{
			return array(
				'id' => 'section_page_title',
				'title' => esc_html__('Page Title', 'april-framework'),
				'icon' => 'dashicons dashicons-media-spreadsheet',
				'fields' => array(
					$this->get_config_toggle(array(
						'id' => 'page_title_enable',
						'title' => esc_html__('Page Title Enable', 'april-framework'),
						'subtitle' => esc_html__('Turn Of this option if you want to disable page title', 'april-framework'),
						'default' => 'on',
					)),
					$this->get_config_content_block(array(
						'id' => 'page_title_content_block',
						'subtitle' => esc_html__('Specify the Content Block to use as a page title content.', 'april-framework'),
						'required' => array('page_title_enable', '=', 'on')
					))
				)
			);
		}

		/**
		 * Get Config Footer
		 *
		 * @return array
		 */
		public function get_config_section_footer()
		{
			return array(
				'id' => 'section_footer',
				'title' => esc_html__('Footer', 'april-framework'),
				'icon' => 'dashicons dashicons-feedback',
				'fields' => array(
					$this->get_config_toggle(array(
						'id' => 'footer_enable',
						'title' => esc_html__('Footer Enable', 'april-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to disable footer', 'april-framework'),
						'default' => 'on'
					)),
                    $this->get_config_content_block(array(
                        'id' => 'footer_content_block',
                        'subtitle' => esc_html__('Specify the Content Block to use as a footer content.', 'april-framework'),
                        'required' => array('footer_enable', '=', 'on')
                    )),
                    $this->get_config_toggle(array(
                        'id' => 'footer_fixed_enable',
                        'title' => esc_html__('Footer Fixed', 'april-framework'),
                        'default' => '',
                        'required' => array('footer_enable', '=', 'on'),
                    )),
				)
			);
		}

		/**
		 * Get Config Typography
		 *
		 * @return array
		 */
		public function get_config_section_typography()
		{
			return array(
				'id' => 'section_typography',
				'title' => esc_html__('Typography', 'april-framework'),
				'icon' => 'dashicons dashicons-editor-textcolor',
				'general_options' => true,
				'fields' => array(
					array(
						'id' => 'section_typography_group_general',
						'title' => esc_html__('General', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'body_font',
								'title' => esc_html__('Body Font', 'april-framework'),
								'subtitle' => esc_html__('Specify the body font.', 'april-framework'),
								'type' => 'typography',
								'font_size' => true,
								'font_variants' => true,
								'default' => array(
									'font_family' => "Nunito Sans",
									'font_size' => '16px',
									'font_weight' => 'regular'
								)
							),
							array(
								'id' => 'primary_font',
								'title' => esc_html__('Primary Font', 'april-framework'),
								'subtitle' => esc_html__('Specify the primary font family.', 'april-framework'),
								'type' => 'typography',
								'default' => array(
									'font_family' => "Montserrat",
								)
							)
						)
					),
                    array(
                        'id' => 'section_typography_group_heading',
                        'title' => esc_html__('Heading Fonts', 'april-framework'),
                        'type' => 'group',
                        'fields' => array(
                            array(
                                'id' => 'h1_font',
                                'title' => esc_html__('H1 Font', 'april-framework'),
                                'subtitle' => esc_html__('Specify the h1 font.', 'april-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '54px',
                                    'font_weight' => '800'
                                )
                            ),
                            array(
                                'id' => 'h2_font',
                                'title' => esc_html__('H2 Font', 'april-framework'),
                                'subtitle' => esc_html__('Specify the h2 font.', 'april-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '40px',
                                    'font_weight' => '800'
                                )
                            ),
                            array(
                                'id' => 'h3_font',
                                'title' => esc_html__('H3 Font', 'april-framework'),
                                'subtitle' => esc_html__('Specify the h3 font.', 'april-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '34px',
                                    'font_weight' => '800'
                                )
                            ),
                            array(
                                'id' => 'h4_font',
                                'title' => esc_html__('H4 Font', 'april-framework'),
                                'subtitle' => esc_html__('Specify the h4 font.', 'april-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '24px',
                                    'font_weight' => '800'
                                )
                            ),
                            array(
                                'id' => 'h5_font',
                                'title' => esc_html__('H5 Font', 'april-framework'),
                                'subtitle' => esc_html__('Specify the h5 font.', 'april-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '18px',
                                    'font_weight' => '800'
                                )
                            ),
                            array(
                                'id' => 'h6_font',
                                'title' => esc_html__('H6 Font', 'april-framework'),
                                'subtitle' => esc_html__('Specify the h6 font.', 'april-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '14px',
                                    'font_weight' => '800'
                                )
                            )
                        )
                    ),
					array(
						'id' => 'section_typography_group_menu',
						'title' => esc_html__('Menu', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'menu_font',
								'title' => esc_html__('Menu Font', 'april-framework'),
								'subtitle' => esc_html__('Specify the menu font.', 'april-framework'),
								'type' => 'typography',
								'font_size' => true,
								'font_variants' => true,
								'default' => array(
									'font_family' => "Nunito Sans",
									'font_size' => '14px',
									'font_weight' => '800'
								)
							),
							array(
								'id' => 'sub_menu_font',
								'title' => esc_html__('Sub Menu Font', 'april-framework'),
								'subtitle' => esc_html__('Specify the sub menu font.', 'april-framework'),
								'type' => 'typography',
								'font_size' => true,
								'font_variants' => true,
								'default' => array(
									'font_family' => "Nunito Sans",
									'font_size' => '15px',
									'font_weight' => '600'
								)
							)
						)
					),
				)
			);
		}

        /**
         * Get Config Icon Font
         *
         * @return array
         */
		public function get_config_section_icon_font() {
            return array(
                'id' => 'section_icon_font',
                'title' => esc_html__('Icon Fonts', 'april-framework'),
                'icon' => 'dashicons dashicons-info',
                'general_options' => true,
                'fields' => array(
                    array(
                        'id' => 'icon_active',
                        'title' => esc_html__('Icon Active', 'april-framework'),
                        'subtitle' => esc_html__('Check if you want to use it on your site', 'april-framework'),
                        'type' => 'checkbox_list',
                        'default' => array(),
                        'options' => array(
                            'organic-food' => esc_html__('Organic Food Icon', 'april-framework')
                        )
                    )
                )
            );
        }

		/**
		 * Get Config Color Skin
		 *
		 * @return array
		 */
		public function get_config_section_color_skin()
		{
			return array(
				'id' => 'color_skin',
				'title' => esc_html__('Skin', 'april-framework'),
				'desc' => esc_html__('Define here all the color skin you will need.', 'april-framework'),
				'type' => 'panel',
				'sort' => true,
				'toggle_default' => false,
				'default' => G5P()->settings()->get_color_skin_default(),
				'panel_title' => 'skin_name',
				'fields' => array(
					array(
						'id' => 'skin_name',
						'title' => esc_html__('Title', 'april-framework'),
						'subtitle' => esc_html__('Enter your color skin name', 'april-framework'),
						'type' => 'text',
					),
					array(
						'id' => 'skin_id',
						'title' => esc_html__('Unique Skin Id', 'april-framework'),
						'subtitle' => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'april-framework'),
						'type' => 'text',
						'input_type' => 'unique_id',
						'default' => 'skin-'
					),
					array(
						'id' => 'section_color_skin_row_color_1',
						'type' => 'row',
						'col' => 4,
						'fields' => array(
							array(
								'id' => 'background_color',
								'title' => esc_html__('Background Color', 'april-framework'),
								'desc' => esc_html__('Specify the background color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '#fff',
								'layout' => 'full',
							),
							array(
								'id' => 'text_color',
								'title' => esc_html__('Text Color', 'april-framework'),
								'desc' => esc_html__('Specify the text color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '#696969',
								'layout' => 'full',
							),
                            array(
                                'id' => 'text_hover_color',
                                'title' => esc_html__('Text hover Color', 'april-framework'),
                                'desc' => esc_html__('Customize text hover color, set empty to use accent color', 'april-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '',
                                'layout' => 'full',
                            )
						)
					),
					array(
						'id' => 'section_color_skin_row_color_2',
						'type' => 'row',
						'col' => 4,
						'fields' => array(
							array(
								'id' => 'heading_color',
								'title' => esc_html__('Heading Color', 'april-framework'),
								'desc' => esc_html__('Specify the heading color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '#333',
								'layout' => 'full',
							),

							array(
								'id' => 'disable_color',
								'title' => esc_html__('Disable Color', 'april-framework'),
								'desc' => esc_html__('Specify the disable color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '#ababab',
								'layout' => 'full',
							),
							array(
								'id' => 'border_color',
								'title' => esc_html__('Border Color', 'april-framework'),
								'desc' => esc_html__('Specify the border color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '#efefef',
								'layout' => 'full',
							),
						)
					),
				),
			);
		}

		/**
		 * Get Config Color
		 *
		 * @return array
		 */
		public function get_config_section_colors()
		{
			return array(
				'id' => 'section_colors',
				'title' => esc_html__('Colors', 'april-framework'),
				'icon' => 'dashicons dashicons-admin-customizer',
				'fields' => array(
					array(
						'id' => 'section_color_group_general',
						'title' => esc_html__('General', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'body_background',
								'title' => esc_html__('Body Background', 'april-framework'),
								'subtitle' => esc_html__('Specify the body background color and media.', 'april-framework'),
								'type' => 'background',
							),

							array(
								'id' => 'accent_color',
								'title' => esc_html__('Accent Color', 'april-framework'),
								'subtitle' => esc_html__('Specify the accent color', 'april-framework'),
								'type' => 'color',
								'default' => '#f76b6a',
							),

							array(
								'id' => 'foreground_accent_color',
								'title' => esc_html__('Foreground Accent Color', 'april-framework'),
								'subtitle' => esc_html__('Specify the foreground accent color', 'april-framework'),
								'type' => 'color',
								'default' => '#fff',
							),

							array(
								'id' => 'content_skin',
								'title' => esc_html__('Content Skin', 'april-framework'),
								'subtitle' => esc_html__('Specify the content color skin', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_color_skin(),
								'default' => 'skin-light'
							),
							array(
								'id' => 'content_background_color',
								'title' => esc_html__('Content Background Color', 'april-framework'),
								'subtitle' => esc_html__('Specify a custom content background color.', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => ''
							)
						)
					),
					array(
						'id' => 'section_color_group_top_drawer',
						'title' => esc_html__('Top Drawer', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'required' => array('top_drawer_mode', '!=', 'hide'),
						'fields' => array(
							array(
								'id' => 'top_drawer_skin',
								'title' => esc_html__('Top Drawer Skin', 'april-framework'),
								'subtitle' => esc_html__('Specify the top drawer color skin', 'april-framework'),
								'type' => 'selectize',
								'placeholder' => esc_html__('Select Color Skin', 'april-framework'),
								'options' => G5P()->settings()->get_color_skin(true),
								'default' => 'skin-dark'
							),
							array(
								'id' => 'top_drawer_background_color',
								'title' => esc_html__('Top Drawer Background Color', 'april-framework'),
								'subtitle' => esc_html__('Specify a custom top drawer background color.', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => ''
							)
						)
					),
					array(
						'id' => 'section_color_group_header',
						'title' => esc_html__('Header', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'fields' => array(
							array(
								'id' => 'header_skin',
								'title' => esc_html__('Header Skin', 'april-framework'),
								'subtitle' => esc_html__('Specify the header color skin', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_color_skin(),
								'default' => 'skin-light'
							),
							array(
								'id' => 'header_background_color',
								'title' => esc_html__('Header Background Color', 'april-framework'),
								'subtitle' => esc_html__('Specify a custom header background color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => ''
							),
							array(
								'id' => 'header_sticky_skin',
								'title' => esc_html__('Header Sticky Skin', 'april-framework'),
								'subtitle' => esc_html__('Specify the header sticky color skin', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_color_skin(),
								'default' => 'skin-light',
								'required' => array(
									array('header_sticky_enable', '=', 'on'),
									array('header_layout','not in',array('header-7','header-8'))
								)
							),
							array(
								'id' => 'header_sticky_background_color',
								'title' => esc_html__('Header Sticky Background Color', 'april-framework'),
								'subtitle' => esc_html__('Specify a custom header sticky background color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => '',
								'required' => array(
									array('header_sticky_enable', '=', 'on'),
									array('header_layout','not in',array('header-7','header-8'))
								)
							),
							array(
								'id' => 'section_color_menu',
								'title' => esc_html__('Menu', 'april-framework'),
								'type' => 'group',
								'required' => array('header_layout','not in',array('header-7','header-8')),
								'fields' => array(
									array(
										'id' => 'navigation_skin',
										'title' => esc_html__('Navigation Skin', 'april-framework'),
										'subtitle' => esc_html__('Specify the navigation color skin', 'april-framework'),
										'type' => 'select',
										'options' => G5P()->settings()->get_color_skin(),
										'default' => 'skin-dark',
										'required' => array('header_layout','in',array('header-6'))
									),
									array(
										'id' => 'navigation_background_color',
										'title' => esc_html__('Navigation Background Color', 'april-framework'),
										'subtitle' => esc_html__('Specify a custom navigation background color', 'april-framework'),
										'type' => 'color',
										'alpha' => true,
										'default' => '',
										'required' => array('header_layout','in',array('header-6'))
									),
									array(
										'id' => 'sub_menu_skin',
										'title' => esc_html__('Sub Menu Skin', 'april-framework'),
										'type' => 'select',
										'placeholder' => esc_html__('Select Color Skin', 'april-framework'),
										'options' => G5P()->settings()->get_color_skin(),
										'default' => 'skin-light'
									),
									array(
										'id' => 'sub_menu_background_color',
										'title' => esc_html__('Sub Menu Background Color', 'april-framework'),
										'subtitle' => esc_html__('Specify a custom sub menu background color', 'april-framework'),
										'type' => 'color',
										'alpha' => true,
										'default' => ''
									),

								)
							),
							array(
								'id' => 'section_color_canvas_sidebar',
								'title' => esc_html__('Canvas Sidebar', 'april-framework'),
								'type' => 'group',
								'required' => array('header_customize_nav', 'contain', 'canvas-sidebar'),
								'fields' => array(
									array(
										'id' => 'canvas_sidebar_skin',
										'title' => esc_html__('Canvas Sidebar Skin', 'april-framework'),
										'subtitle' => esc_html__('Specify the canvas sidebar color skin', 'april-framework'),
										'type' => 'select',
										'options' => G5P()->settings()->get_color_skin(),
										'default' => 'skin-dark'
									),
									array(
										'id' => 'canvas_sidebar_background_color',
										'title' => esc_html__('Canvas Sidebar Background Color', 'april-framework'),
										'subtitle' => esc_html__('Specify a custom canvas sidebar background color', 'april-framework'),
										'type' => 'color',
										'alpha' => true,
										'default' => ''
									)
								)
							),
						)
					),

					array(
						'id' => 'section_color_group_header_mobile',
						'title' => esc_html__('Header Mobile', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'fields' => array(
							array(
								'id' => 'mobile_header_skin',
								'title' => esc_html__('Header Mobile Skin', 'april-framework'),
								'subtitle' => esc_html__('Specify the header mobile color skin', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_color_skin(),
								'default' => 'skin-light'
							),
							array(
								'id' => 'mobile_header_background_color',
								'title' => esc_html__('Header Mobile Background Color', 'april-framework'),
								'subtitle' => esc_html__('Specify a custom header mobile background color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => ''
							),
						)
					),

					array(
						'id' => 'section_color_group_page_title',
						'title' => esc_html__('Page Title', 'april-framework'),
						'type' => 'group',
						'toggle_default' => false,
						'required' => array('page_title_enable', '=', 'on'),
						'fields' => array(
							array(
								'id' => 'page_title_skin',
								'title' => esc_html__('Page Title Skin', 'april-framework'),
								'subtitle' => esc_html__('Specify the page title color skin', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_color_skin(true),
								'default' => '0'
							),
							array(
								'id' => 'page_title_background_color',
								'title' => esc_html__('Page Title Background Color', 'april-framework'),
								'subtitle' => esc_html__('Specify a custom page title background color', 'april-framework'),
								'type' => 'color',
								'alpha' => true,
								'default' => ''
							),
						)
					),
				)
			);
		}

		/**
		 * Get Config Section Connections
		 *
		 * @return array
		 */
		public function get_config_section_connections()
		{
			return array(
				'id' => 'section_connections',
				'title' => esc_html__('Connections', 'april-framework'),
				'icon' => 'dashicons dashicons-share',
				'general_options' => true,
				'fields' => array(
					array(
						'id' => 'section_connections_group_social_share',
						'title' => esc_html__('Social Share', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'social_share',
								'title' => esc_html__('Social Share', 'april-framework'),
								'subtitle' => esc_html__('Select active social share links and sort them', 'april-framework'),
								'type' => 'sortable',
								'options' => G5P()->settings()->get_social_share(),
                                'default' => array(
                                    'facebook'  => 'facebook',
                                    'twitter'   => 'twitter',
                                    'google'    => 'google',
                                    'linkedin'  => 'linkedin',
                                    'tumblr'    => 'tumblr',
                                    'pinterest' => 'pinterest'
                                )
							),
						)
					),
					array(
						'id' => 'section_connections_group_social_networks',
						'title' => esc_html__('Social Networks', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							array(
								'id' => 'social_networks',
								'title' => esc_html__('Social Networks', 'april-framework'),
								'desc' => esc_html__('Define here all the social networks you will need.', 'april-framework'),
								'type' => 'panel',
								'toggle_default' => false,
								'default' => G5P()->settings()->get_social_networks_default(),
								'panel_title' => 'social_name',
								'fields' => array(
									array(
										'id' => 'social_name',
										'title' => esc_html__('Title', 'april-framework'),
										'subtitle' => esc_html__('Enter your social network name', 'april-framework'),
										'type' => 'text',
									),
									array(
										'id' => 'social_id',
										'title' => esc_html__('Unique Social Id', 'april-framework'),
										'subtitle' => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'april-framework'),
										'type' => 'text',
										'input_type' => 'unique_id',
										'default' => 'social-'
									),
									array(
										'id' => 'social_icon',
										'title' => esc_html__('Social Network Icon', 'april-framework'),
										'subtitle' => esc_html__('Specify the social network icon', 'april-framework'),
										'type' => 'icon',
									),
									array(
										'id' => 'social_link',
										'title' => esc_html__('Social Network Link', 'april-framework'),
										'subtitle' => esc_html__('Enter your social network link', 'april-framework'),
										'type' => 'text',
									),
									array(
										'id' => 'social_color',
										'title' => esc_html__('Social Network Color', 'april-framework'),
										'subtitle' => sprintf(wp_kses_post(__('Specify the social network color. Reference in <a target="_blank" href="%s">brandcolors.net</a>', 'april-framework')), 'https://brandcolors.net/'),
										'type' => 'color'
									)
								)
							)
						)
					),
				)
			);
		}

		/**
		 * Get Config Section Blog
		 *
		 * @return array
		 */
		public function get_config_section_blog()
		{
			return array(
				'id' => 'section_blog',
				'title' => esc_html__('Blog', 'april-framework'),
				'icon' => 'dashicons dashicons-media-text',
				'general_options' => true,
				'fields' => array(
					$this->get_config_section_blog_listing('', '', false, array(
                        $this->get_config_toggle(array(
                            'id' => 'blog_filter_enable',
                            'title' => esc_html__('Show Category Filter', 'april-framework'),
                            'default' => ''
                        ))
                    )),
					$this->get_config_section_blog_listing(esc_html__('Search Listing', 'april-framework'),'search',true),
					$this->get_config_group_single_blog()
				)
			);
		}

		/**
		 * Get Config group single blog
		 *
		 * @return array
		 */
		public function get_config_group_single_blog() {
			return array(
				'id' => 'section_blog_group_single_blog',
				'title' => esc_html__('Single Blog', 'april-framework'),
				'type' => 'group',
				'fields' => array(
					array(
						'id' => 'single_post_layout',
						'title' => esc_html__('Post Layout', 'april-framework'),
						'subtitle' => esc_html__('Specify your post layout', 'april-framework'),
						'type' => 'image_set',
						'options' => G5P()->settings()->get_single_post_layout(),
						'default' => 'layout-1'
					),
                    array(
                        'id' => 'post_single_image_padding',
                        'title' => esc_html__('Single Image Padding', 'april-framework'),
                        'subtitle' => esc_html__('Set single image padding', 'april-framework'),
                        'type' => 'spacing',
                        'default' => array('left' => 0, 'right' => 0, 'top' => 0, 'bottom' => 0),
                        'required' => array('single_post_layout', '=', 'layout-5')
                    ),
                    array(
                        'id' => 'post_single_image_mobile_padding',
                        'title' => esc_html__('Single Image Mobile Padding', 'april-framework'),
                        'subtitle' => esc_html__('Set single image mobile padding', 'april-framework'),
                        'type' => 'spacing',
                        'default' => array('left' => 0, 'right' => 0, 'top' => 0, 'bottom' => 0),
                        'required' => array('single_post_layout', '=', 'layout-5')
                    ),
                    $this->get_config_toggle(array(
                        'id' => 'single_reading_process_enable',
                        'title' => esc_html__('Reading Process', 'april-framework'),
                        'subtitle' => esc_html__('Turn Off this option if you want to hide reading process on single blog', 'april-framework'),
                        'default' => 'on'
                    )),
					$this->get_config_toggle(array(
						'id' => 'single_tag_enable',
						'title' => esc_html__('Tags', 'april-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide tags on single blog', 'april-framework'),
						'default' => 'on'
					)),
					$this->get_config_toggle(array(
						'id' => 'single_share_enable',
						'title' => esc_html__('Share', 'april-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide share on single blog', 'april-framework'),
						'default' => 'on'
					)),
					$this->get_config_toggle(array(
						'id' => 'single_navigation_enable',
						'title' => esc_html__('Navigation', 'april-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide navigation on single blog', 'april-framework'),
						'default' => 'on'
					)),
					$this->get_config_toggle(array(
						'id' => 'single_author_info_enable',
						'title' => esc_html__('Author Info', 'april-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide author info area on single blog', 'april-framework'),
						'default' => 'on'
					)),
					array(
						'id' => 'group_single_related_posts',
						'title' => esc_html__('Related Posts', 'april-framework'),
						'type' => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id' => 'single_related_post_enable',
								'title' => esc_html__('Related Posts', 'april-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide related posts area on single blog', 'april-framework'),
								'default' => ''
							)),
							array(
								'id' => 'single_related_post_algorithm',
								'title' => esc_html__('Related Posts Algorithm', 'april-framework'),
								'subtitle' => esc_html__('Specify the algorithm of related posts', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_related_post_algorithm(),
								'default' => 'cat',
								'required' => array('single_related_post_enable','=','on')
							),
							$this->get_config_toggle(array(
								'id' => 'single_related_post_carousel_enable',
								'title' => esc_html__('Carousel Mode', 'april-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'april-framework'),
								'default' => 'on',
								'required' => array('single_related_post_enable','=','on')
							)),
							array(
								'id' => 'single_related_post_per_page',
								'title' => esc_html__('Posts Per Page', 'april-framework'),
								'subtitle' => esc_html__('Enter number of posts per page you want to display', 'april-framework'),
								'type' => 'text',
								'input_type' => 'number',
								'default' => 6,
								'required' => array('single_related_post_enable','=','on')
							),
							array(
								'id' => 'single_related_post_columns_gutter',
								'title' => esc_html__('Post Columns Gutter', 'april-framework'),
								'subtitle' => esc_html__('Specify your horizontal space between post.', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_post_columns_gutter(),
								'default' => '20',
								'required' => array('single_related_post_enable','=','on')
							),
							array(
								'id' => 'single_related_post_columns_group',
								'title' => esc_html__('Post Columns', 'april-framework'),
								'type' => 'group',
								'required' => array('single_related_post_enable','=','on'),
								'fields' => array(
									array(
										'id' => 'single_related_post_columns_row_1',
										'type' => 'row',
										'col' => 3,
										'fields' => array(
											array(
												'id' => 'single_related_post_columns',
												'title' => esc_html__('Large Devices', 'april-framework'),
												'desc' => esc_html__('Specify your post columns on large devices (>= 1200px)', 'april-framework'),
												'type' => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '3',
												'layout' => 'full',
											),
											array(
												'id' => 'single_related_post_columns_md',
												'title' => esc_html__('Medium Devices', 'april-framework'),
												'desc' => esc_html__('Specify your post columns on medium devices (>= 992px)', 'april-framework'),
												'type' => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '3',
												'layout' => 'full',
											),
											array(
												'id' => 'single_related_post_columns_sm',
												'title' => esc_html__('Small Devices', 'april-framework'),
												'desc' => esc_html__('Specify your post columns on small devices (>= 768px)', 'april-framework'),
												'type' => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout' => 'full',
											),
											array(
												'id' => 'single_related_post_columns_xs',
												'title' => esc_html__('Extra Small Devices ', 'april-framework'),
												'desc' => esc_html__('Specify your post columns on extra small devices (< 768px)', 'april-framework'),
												'type' => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout' => 'full',
											),
                                            array(
                                                'id' => "single_related_post_columns_mb",
                                                'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                'desc' => esc_html__('Specify your post columns on extra extra small devices (< 600px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout' => 'full',
                                            )
										)
									),
								)
							),
							array(
								'id' => 'single_related_post_paging',
								'title' => esc_html__('Post Paging', 'april-framework'),
								'subtitle' => esc_html__('Specify your post paging mode', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_post_paging_small_mode(),
								'default' => 'none',
								'required' => array('single_related_post_enable','=','on')
							),
							array(
								'id' => 'single_related_post_animation',
								'title' => esc_html__('Animation', 'april-framework'),
								'subtitle' => esc_html__('Specify your post animation', 'april-framework'),
								'type' => 'select',
								'options' => G5P()->settings()->get_animation(true),
								'default' => '-1',
								'required' => array('single_related_post_enable','=','on')
							),
						)
					)
				)
			);
		}

		/**
		 * Get Config Section Customize Css & Javascript
		 *
		 * @return array
		 */
		public function get_config_section_code()
		{
			return array(
				'id' => 'section_code',
				'title' => esc_html__('Css & Javascript', 'april-framework'),
				'icon' => 'dashicons dashicons-editor-code',
				'general_options' => true,
				'fields' => array(
					array(
						'id' => 'custom_css',
						'title' => esc_html__('Custom Css', 'april-framework'),
						'subtitle' => esc_html__('Enter here your custom CSS. Please do not include any style tags.', 'april-framework'),
						'type' => 'ace_editor',
						'mode' => 'css',
						'theme' => 'monokai',
						'min_line' => 20
					),
					array(
						'id' => 'custom_js',
						'title' => esc_html__('Custom Javascript', 'april-framework'),
						'subtitle' => esc_html__('Enter here your custom javascript code. Please do not include any script tags.', 'april-framework'),
						'type' => 'ace_editor',
						'mode' => 'javascript',
						'theme' => 'monokai',
						'min_line' => 20
					),
				)
			);
		}

		/**
		 * Get Config Content Block
		 *
		 * @param $id
		 * @param array $args
		 * @param bool $inherit
		 * @return array
		 */
		public function get_config_content_block($args = array())
		{
			$defaults =  array(
				'title' => esc_html__('Content Block', 'april-framework'),
				'placeholder' => esc_html__('Select Content Block', 'april-framework'),
				'type' => 'selectize',
				'allow_clear' => true,
				'data' => G5P()->cpt()->get_content_block_post_type(),
				'data_args' => array(
					'numberposts' => -1,
				)
			);

			$defaults = wp_parse_args($args,$defaults);
			return $defaults;
		}

		/**
		 * Get Config Sidebar Layout
		 *
		 * @param $id
		 * @param bool $inherit
		 * @param array $args
		 * @return array
		 */
		public function get_config_sidebar_layout($args = array(), $inherit = false)
		{
			$defaults = array(
				'title' => esc_html__('Sidebar Layout', 'april-framework'),
				'type' => 'image_set',
				'options' => G5P()->settings()->get_sidebar_layout($inherit),
				'default' => $inherit ? '' : 'right'
			);

			$defaults = wp_parse_args($args,$defaults);
			return $defaults;
		}

		/**
		 * Get Config Sidebar
		 *
		 * @param $id
		 * @param array $args
		 * @param $inherit
		 * @return array
		 */
		public function get_config_sidebar($args = array(),$inherit = false)
		{
			$defaults = array(
				'title' => esc_html__('Sidebar', 'april-framework'),
				'type' => 'selectize',
				'placeholder' => esc_html__('Select Sidebar', 'april-framework'),
				'data' => 'sidebar',
				'allow_clear' => true,
				'default' => ''
			);

			$defaults = wp_parse_args($args,$defaults);
			return $defaults;
		}



		/**
		 * Get Config Border Bottom
		 *
		 * @param $id
		 * @param array $args
		 * @param bool $inherit
		 * @return array
		 */
		public function get_config_border_bottom($id, $args = array(),$inherit = false)
		{
			$defaults =  array(
				'id' => $id,
				'type' => 'select',
				'title' => esc_html__('Border Bottom', 'april-framework'),
				'subtitle' => esc_html__('Specify the border bottom mode.', 'april-framework'),
				'options' => G5P()->settings()->get_border_layout($inherit),
				'default' => $inherit ? '' : 'none'
			);
			$defaults = wp_parse_args($args,$defaults);
			return $defaults;
		}

		/**
		 * Get Config Group Header Customize
		 *
		 * @param $id
		 * @param $title
		 * @param $prefixId
		 * @param array $default
		 * @param array $required
		 * @return array
		 */
		public function get_config_group_header_customize($id, $title, $prefixId, $default = array(), $required = array())
		{
			return array(
				'id' => $id,
				'title' => $title,
				'type' => 'group',
				'toggle_default' => true,
				'required' => $required,
				'fields' => array(
					array(
						'id' => $prefixId,
						'title' => esc_html__('Items', 'april-framework'),
						'type' => 'sortable',
						'options' => G5P()->settings()->get_header_customize(),
						'default' => $default
					),
					$this->get_config_toggle(array(
					    'id' => "{$prefixId}_separator",
                        'title' => esc_html__('Items separator enable', 'april-framework'),
                        'default' => '',
                        'required' => array('header_layout','not in',array('header-7','header-8'))
                    )),
                    array(
                        'id' => "{$prefixId}_separator_bg_color",
                        'title' => esc_html__('Items separator background color', 'april-framework'),
                        'default' => '#e0e0e0',
                        'type' => 'color',
                        'alpha' => true,
                        'required' => array(
                            array('header_layout','not in',array('header-7','header-8')),
                            array("{$prefixId}_separator", '=', 'on')
                        )
                    ),
                    $this->get_config_toggle(array(
                        'id' => "{$prefixId}_search_type",
                        'title' => esc_html__('Search type', 'april-framework'),
                        'type' => 'button_set',
                        'default' => 'icon',
                        'options' => array(
                            'icon' => esc_html__('Icon', 'april-framework'),
                            'box' => esc_html__('Box', 'april-framework')
                        ),
                        'required' => array($prefixId,'contain','search')
                    )),
					$this->get_config_sidebar(array(
						'id' => "{$prefixId}_sidebar",
						'required' => array($prefixId, 'contain', 'sidebar')
					)),
					array(
						'id' => "{$prefixId}_social_networks",
						'title' => esc_html__('Social Networks', 'april-framework'),
						'type' => 'selectize',
						'multiple' => true,
						'drag' => true,
						'placeholder' => esc_html__('Select Social Networks', 'april-framework'),
						'options' => G5P()->settings()->get_social_networks(),
						'required' => array($prefixId, 'contain', 'social-networks')
					),
					array(
						'id' => "{$prefixId}_custom_html",
						'title' => esc_html__('Custom Html Content', 'april-framework'),
						'type' => 'ace_editor',
						'mode' => 'html',
						'required' => array($prefixId, 'contain', 'custom-html')
					),
					$this->get_config_spacing("{$prefixId}_spacing",array(
						'title' => esc_html__('Items Spacing', 'april-framework'),
						'default' => 15
					)),
					array(
						'id' => "{$prefixId}_custom_css",
						'type' => 'text',
						'title' => esc_html__('Custom Css Class', 'april-framework'),
						'default' => ''
					)
				)
			);
		}

		/**
		 * Get Config Spacing
		 *
		 * @param $id
		 * @param array $args
		 * @return array
		 */
		public function get_config_spacing($id, $args = array())
		{
			$defaults =  array(
				'id' => $id,
				'type' => 'slider',
				'js_options' => array(
					'step' => 1,
					'min' => 1,
					'max' => 100
				),
				'default' => 30,
			);

			$defaults = wp_parse_args($args,$defaults);
			return $defaults;
		}


		/**
		 * Get Toggle Config
		 *
		 * @param array $args
		 * @param bool $inherit
		 * @return array
		 */
		public function get_config_toggle($args = array(),$inherit = false) {

			if (!$inherit) {
				$defaults = array(
					'type' => 'switch'
				);
			}
			else {
				$defaults = array(
					'type' => 'button_set',
					'options' => G5P()->settings()->get_toggle($inherit),
					'default' => '',
				);
			}
			$defaults = wp_parse_args($args,$defaults);
			return $defaults;
		}

		public function get_config_section_blog_listing($title = '', $prefix = '',$inherit = false, $addition = array()){
			if ($prefix !== '') {
				$prefix = "{$prefix}_";
			}

			if ($title === '') {
				$title = esc_html__('Blog Listing', 'april-framework');
			}

			$fields = array_merge(array(
				array(
					'id' => "{$prefix}post_layout",
					'title' => esc_html__('Post Layout', 'april-framework'),
					'subtitle' => esc_html__('Specify your post layout', 'april-framework'),
					'type' => 'image_set',
					'options' => G5P()->settings()->get_post_layout($inherit),
					'default' => $inherit ? '' : 'large-image'
				),
                array(
                    'id' => "{$prefix}post_item_skin",
                    'title' => esc_html__('Post Item Skin','april-framework'),
                    'type'     => 'image_set',
                    'options'  => G5P()->settings()->get_post_item_skin($inherit),
                    'default'  => $inherit ? '' : 'post-skin-01',
                    'required' => array("{$prefix}post_layout", 'in', array('grid', 'masonry')),
                ),
            ),
            $addition,
            array(
				array(
					'id' => "{$prefix}post_columns_gutter",
					'title' => esc_html__('Post Columns Gutter', 'april-framework'),
					'subtitle' => esc_html__('Specify your horizontal space between post.', 'april-framework'),
					'type' => 'select',
					'options' => G5P()->settings()->get_post_columns_gutter($inherit),
					'default' => $inherit ? '-1' : '30',
					'required' => array("{$prefix}post_layout", 'in', array('grid', 'masonry'))
				),
				array(
					'id' => "{$prefix}post_columns_group",
					'title' => esc_html__('Post Columns', 'april-framework'),
					'type' => 'group',
					'required' => array("{$prefix}post_layout", 'in', array('grid', 'masonry','grid')),
					'fields' => array(
						array(
							'id' => "{$prefix}post_columns_row_1",
							'type' => 'row',
							'col' => 3,
							'fields' => array(
								array(
									'id' => "{$prefix}post_columns",
									'title' => esc_html__('Large Devices', 'april-framework'),
									'desc' => esc_html__('Specify your post columns on large devices (>= 1200px)', 'april-framework'),
									'type' => 'select',
									'options' => G5P()->settings()->get_post_columns($inherit),
									'default' => $inherit ? '-1' : '2',
									'layout' => 'full',
								),
								array(
									'id' => "{$prefix}post_columns_md",
									'title' => esc_html__('Medium Devices', 'april-framework'),
									'desc' => esc_html__('Specify your post columns on medium devices (>= 992px)', 'april-framework'),
									'type' => 'select',
									'options' => G5P()->settings()->get_post_columns($inherit),
									'default' => $inherit ? '-1' : '2',
									'layout' => 'full',
								),
								array(
									'id' => "{$prefix}post_columns_sm",
									'title' => esc_html__('Small Devices', 'april-framework'),
									'desc' => esc_html__('Specify your post columns on small devices (>= 768px)', 'april-framework'),
									'type' => 'select',
									'options' => G5P()->settings()->get_post_columns($inherit),
									'default' => $inherit ? '-1' : '1',
									'layout' => 'full',
								),
								array(
									'id' => "{$prefix}post_columns_xs",
									'title' => esc_html__('Extra Small Devices ', 'april-framework'),
									'desc' => esc_html__('Specify your post columns on extra small devices (< 768px)', 'april-framework'),
									'type' => 'select',
									'options' => G5P()->settings()->get_post_columns($inherit),
									'default' => $inherit ? '-1' : '1',
									'layout' => 'full',
								),
                                array(
                                    'id' => "{$prefix}post_columns_mb",
                                    'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                    'desc' => esc_html__('Specify your post columns on extra extra small devices (< 600px)', 'april-framework'),
                                    'type' => 'select',
                                    'options' => G5P()->settings()->get_post_columns($inherit),
                                    'default' => $inherit ? '-1' : '1',
                                    'layout' => 'full',
                                )
							)
						),
					)
				),
				array(
					'id' => "{$prefix}posts_per_page",
					'title' => esc_html__('Posts Per Page', 'april-framework'),
					'subtitle' => esc_html__('Enter number of posts per page you want to display. Default 10', 'april-framework'),
					'type' => 'text',
					'input_type' => 'number',
					'default' => $inherit ? '' : 10
				),
				array(
					'id' => "{$prefix}post_paging",
					'title' => esc_html__('Post Paging', 'april-framework'),
					'subtitle' => esc_html__('Specify your post paging mode', 'april-framework'),
					'type' => 'select',
					'options' => G5P()->settings()->get_post_paging_mode($inherit),
					'default' => $inherit ? '-1' :  'pagination'
				),
				array(
					'id' => "{$prefix}post_animation",
					'title' => esc_html__('Animation', 'april-framework'),
					'subtitle' => esc_html__('Specify your post animation', 'april-framework'),
					'type' => 'select',
					'options' => G5P()->settings()->get_animation($inherit),
					'default' => $inherit ? '-1' : 'none'
				)
			));

			if ($prefix === '') {
				$fields[] = array(
					'id' => 'post_ads',
					'title' => esc_html__('Advertisement', 'april-framework'),
					'desc' => esc_html__('Define here all the advertisement for listing post you will need.', 'april-framework'),
					'type' => 'panel',
					'required' => array('post_layout', 'in', array('large-image', 'medium-image')),
					'panel_title' => 'name',
					'fields' => array(
						array(
							'id' => 'name',
							'title' => esc_html__('Title', 'april-framework'),
							'subtitle' => esc_html__('Enter your advertisement name', 'april-framework'),
							'type' => 'text',
						),
						array(
							'id' => 'content',
							'title' => esc_html__('Content', 'april-framework'),
							'subtitle' => esc_html__('Enter your advertisement content', 'april-framework'),
							'type' => 'editor',
						),
						array(
							'id' => 'position',
							'title' => esc_html__('Position', 'april-framework'),
							'subtitle' => esc_html__('Enter your advertisement position', 'april-framework'),
							'desc' => esc_html__('After how many post the ad will display.', 'april-framework'),
							'type' => 'text',
							'input_type' => 'number'
						),
					)
				);
			}
			if ($prefix === 'search_') {
				$fields[] = array(
					'id' => 'search_post_type',
					'type' => 'checkbox_list',
					'title' => esc_html__('Post Type For Search', 'april-framework'),
					'options' => G5P()->settings()->get_search_ajax_popup_post_type(),
					'multiple' => true,
					'default' => array('post'),
				);
			}
			$options = array(
				'id' => "{$prefix}section_blog_group_blog_listing",
				'title' => $title,
				'type' => 'group',
				'fields' => $fields
			);
			return $options;
		}

		/**
		 * Get preset config
		 *
		 * @param array $args
		 * @return array
		 */
		public function get_config_preset($args = array()) {
			$defaults = array(
				'title' => esc_html__('Preset', 'april-framework'),
				'type'  => 'selectize',
				'allow_clear' => true,
				'data' => 'preset',
				'data-option' => G5P()->getOptionName(),
				'create_link' => admin_url('admin.php?page=gsf_options'),
				'edit_link' => admin_url('admin.php?page=gsf_options'),
				'placeholder' => esc_html__('Select Preset', 'april-framework'),
				'multiple'    => false,
				'desc'        => esc_html__('Optionally you can choose to override the setting that is used on the page', 'april-framework'),
			);
			return wp_parse_args($args,$defaults);
		}

        public function get_config_section_custom_post_type() {
            return array(
                'id'     => 'section_custom_post_type',
                'title'  => esc_html__('Custom Post Type', 'april-framework'),
                'icon'   => 'dashicons dashicons-grid-view',
                'general_options' => true,
                'fields' => array(
                    array(
                        'id'       => 'custom_post_type_disable',
                        'type'     => 'checkbox_list',
                        'value_inline' => false,
                        'multiple' => true,
                        'title'    => esc_html__('Disable Custom Post Types', 'april-framework'),
                        'subtitle' => esc_html__('You can disable the custom post types used within the theme here, by checking the corresponding box. NOTE: If you do not want to disable any, then make sure none of the boxes are checked.','april-framework'),
                        'options'  => array(
                            'portfolio' => esc_html__('Portfolios', 'april-framework')
                        )
                    ),
                )
            );
        }
        /**
         * Get Woocommerce config
         */
        public function get_config_section_woocommerce()
        {
            return array(
                'id'     => 'section_woocommerce',
                'title'  => esc_html__('Woocommerce', 'april-framework'),
                'icon'   => 'dashicons dashicons-cart',
                'general_options' => true,
                'fields' => array(
                    array(
                        'id'     => 'section_woocommerce_group_general',
                        'title'  => esc_html__('General', 'april-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            $this->get_config_toggle(array(
                                'id'       => 'product_featured_label_enable',
                                'title'    => esc_html__('Show Featured Label', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to disable featured label', 'april-framework'),
                                'default'  => 'on'
                            )),
                            array(
                                'id'       => 'product_featured_label_text',
                                'type'     => 'text',
                                'title'    => esc_html__('Featured Label Text', 'april-framework'),
                                'subtitle' => esc_html__('Enter product featured label text','april-framework'),
                                'default'  => esc_html__('Hot', 'april-framework'),
                                'required' => array('product_featured_label_enable', '=', 'on')
                            ),
                            $this->get_config_toggle(array(
                                'id'       => 'product_sale_label_enable',
                                'title'    => esc_html__('Show Sale Label', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to disable sale label', 'april-framework'),
                                'default'  => 'on'
                            )),
                            array(
                                'id' => 'product_sale_flash_mode',
                                'title' => esc_html__('Sale Flash Mode','april-framework'),
                                'type' => 'button_set',
                                'options' => array(
                                    'text' => esc_html__('Text','april-framework'),
                                    'percent' => esc_html__('Percent','april-framework')
                                ),
                                'default' => 'text',
                                'required' => array('product_sale_label_enable','=','on')
                            ),
                            array(
                                'id'       => 'product_sale_label_text',
                                'type'     => 'text',
                                'title'    => esc_html__('Sale Label Text', 'april-framework'),
                                'subtitle' => esc_html__('Enter product sale label text','april-framework'),
                                'default'  => esc_html__('Sale', 'april-framework'),
                                'required' => array(
                                    array('product_sale_label_enable', '=', 'on'),
                                    array('product_sale_flash_mode', '=', 'text')
                                )
                            ),
                            $this->get_config_toggle(array(
                                'id'       => 'product_new_label_enable',
                                'title'    => esc_html__('Show New Label', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to disable new label', 'april-framework'),
                                'default'  => 'on'
                            )),
                            array(
                                'id'       => 'product_new_label_since',
                                'type'     => 'text',
                                'input_type' => 'number',
                                'title'    => esc_html__('Mark New After Published (Days)', 'april-framework'),
                                'subtitle' => esc_html__('Enter the number of days after the publication is marked as new','april-framework'),
                                'default'  => '5',
                                'required' => array('product_new_label_enable', '=', 'on')
                            ),
                            array(
                                'id'       => 'product_new_label_text',
                                'type'     => 'text',
                                'title'    => esc_html__('New Label Text', 'april-framework'),
                                'subtitle' => esc_html__('Enter product new label text','april-framework'),
                                'default'  => esc_html__('New', 'april-framework'),
                                'required' => array('product_new_label_enable', '=', 'on')
                            ),

                            $this->get_config_toggle(array(
                                'id'       => 'product_sale_count_down_enable',
                                'title'    => esc_html__('Show Sale Count Down', 'april-framework'),
                                'subtitle' => esc_html__('Turn On this option if you want to enable sale count down', 'april-framework'),
                                'default'  => ''
                            )),

                            $this->get_config_toggle(array(
                                'id'       => 'product_add_to_cart_enable',
                                'title'    => esc_html__('Show Add To Cart Button', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to disable add to cart button', 'april-framework'),
                                'default'  => 'on'
                            )),
                            array(
                                'id' => 'shop_cart_empty_text',
                                'title' => esc_html__('Set cart empty text', 'april-framework'),
                                'default' => esc_html__('No product in the cart.', 'april-framework'),
                                'type' => 'text'
                            ),
                        )),
                    array(
                        'id'     => 'section_woocommerce_group_archive',
                        'title'  => esc_html__('Shop and Category Page', 'april-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id' => 'product_catalog_layout',
                                'title' => esc_html__('Layout','april-framework'),
                                'subtitle' => esc_html__('Specify your product layout','april-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_product_catalog_layout(),
                                'default'  => 'grid',
                                'preset'   => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'grid',
                                        'fields' => array(
                                            array('product_per_page', 9),
                                            array('product_columns_gutter', 30)
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'list',
                                        'fields' => array(
                                            array('product_per_page', 6),
                                            array('product_columns_gutter', 30)
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-01',
                                        'fields' => array(
                                            array('product_per_page', 8),
                                            array('product_columns_gutter', 10),
                                            array('product_image_size', 'medium'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-02',
                                        'fields' => array(
                                            array('product_per_page', 8),
                                            array('product_columns_gutter', 10),
                                            array('product_image_size', 'medium'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-03',
                                        'fields' => array(
                                            array('product_per_page', 10),
                                            array('product_columns_gutter', 10),
                                            array('product_image_size', 'medium'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-04',
                                        'fields' => array(
                                            array('product_per_page', 8),
                                            array('product_columns_gutter', 10),
                                            array('product_image_size', '400x328'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-05',
                                        'fields' => array(
                                            array('product_per_page', 8),
                                            array('product_columns_gutter', 10),
                                            array('product_image_size', '384x328'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-06',
                                        'fields' => array(
                                            array('product_per_page', 12),
                                            array('product_columns_gutter', 10),
                                            array('product_image_size', '384x328'),
                                        )
                                    )
                                )
                            ),
                            array(
                                'id' => 'product_item_skin',
                                'title' => esc_html__('Product Item Skin','april-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_product_item_skin(),
                                'default'  => 'product-skin-01',
                                'required' => array('product_catalog_layout', '=', 'grid'),
                            ),
                            array(
                                'id'     => 'product_image_size_group',
                                'title'  => esc_html__('Product Image Size', 'april-framework'),
                                'type'   => 'group',
                                'required' => array('product_catalog_layout', 'not in', array('grid', 'list')),
                                'fields' => array(
                                    array(
                                        'id'       => 'product_image_size',
                                        'title'    => esc_html__('Image size', 'april-framework'),
                                        'subtitle' => esc_html__('Enter your product image size', 'april-framework'),
                                        'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'april-framework'),
                                        'type'     => 'text',
                                        'default'  => 'medium'
                                    ),
                                    array(
                                        'id'       => 'product_image_ratio',
                                        'title'    => esc_html__('Image ratio', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your image product ratio', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_image_ratio(),
                                        'default'  => '1x1',
                                        'required' => array('product_image_size', '=', 'full')
                                    ),
                                    array(
                                        'id'       => 'product_image_ratio_custom',
                                        'title'    => esc_html__('Image ratio custom', 'april-framework'),
                                        'subtitle' => esc_html__('Enter custom image ratio', 'april-framework'),
                                        'type'     => 'dimension',
                                        'required' => array(
                                            array('product_image_size', '=', 'full'),
                                            array('product_image_ratio', '=', 'custom')
                                        )
                                    )
                                )
                            ),
                            $this->get_config_toggle(array(
                                'id' => 'product_catalog_filter_enable',
                                'title' => esc_html__('Show Category Filter', 'april-framework'),
                                'default' => ''
                            )),
                            array(
                                'id'       => 'product_columns_gutter',
                                'title'    => esc_html__('Product Columns Gutter', 'april-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between product.', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_columns_gutter(),
                                'default'  =>'30',
                                'required' => array('product_catalog_layout', '!=', 'list')
                            ),
                            array(
                                'id'       => 'product_columns_group',
                                'title'    => esc_html__('Product Columns', 'april-framework'),
                                'type'     => 'group',
                                'required' => array('product_catalog_layout', '=', 'grid'),
                                'fields'   => array(
                                    array(
                                        'id'     => 'product_columns_row_1',
                                        'type'   => 'row',
                                        'col'    => 3,
                                        'fields' => array(
                                            array(
                                                'id'      => 'product_columns',
                                                'title'   => esc_html__('Large Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product columns on large devices (>= 1200px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'product_columns_md',
                                                'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product columns on medium devices (>= 992px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'product_columns_sm',
                                                'title'   => esc_html__('Small Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product columns on small devices (>= 768px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'product_columns_xs',
                                                'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product columns on extra small devices (< 768px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id' => "product_columns_mb",
                                                'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                'desc' => esc_html__('Specify your product columns on extra extra small devices (< 600px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout' => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'         => 'product_per_page',
                                'title'      => esc_html__('Products Per Page', 'april-framework'),
                                'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 9', 'april-framework'),
                                'type'       => 'text',
                                'default'    => '9',
                                'required' => array("woocommerce_customize[disable]", 'contain','items-show')
                            ),

                            array(
                                'id'       => 'product_paging',
                                'title'    => esc_html__('Product Paging', 'april-framework'),
                                'subtitle' => esc_html__('Specify your product paging mode', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_paging_mode(),
                                'default'  => 'pagination'
                            ),
                            array(
                                'id'       => 'product_animation',
                                'title'    => esc_html__('Animation', 'april-framework'),
                                'subtitle' => esc_html__('Specify your product animation', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_animation(),
                                'default'  => 'none'
                            ),
                            array(
                                'id'       => 'product_image_hover_effect',
                                'type'     => 'select',
                                'title'    => esc_html__( 'Product Image Hover Effect', 'april-framework' ),
                                'subtitle' => esc_html__('Specify your product image hover effect','april-framework'),
                                'desc'     => '',
                                'options'  => G5P()->settings()->get_product_image_hover_effect(),
                                'default'  => 'change-image'
                            ),
                            array(
                                'type' => 'group',
                                'id' => 'section_woocommerce_group_customize',
                                'title'  => esc_html__('Shop Above Customize', 'april-framework'),
                                'fields' => array(
                                    array(
                                        'id'       => 'woocommerce_customize',
                                        'title'    => esc_html__('Shop Above Customize Options', 'april-framework'),
                                        'type'     => 'sorter',
                                        'default'  => array(
                                            'left'  => array(
                                                'result-count'          => esc_html__('Result Count', 'april-framework')
                                            ),
                                            'right'  => array(
                                                'ordering'     => esc_html__('Ordering', 'april-framework'),
                                                'switch-layout'  => esc_html__('Switch Layout', 'april-framework')
                                            ),
                                            'disable' => array(
                                                'items-show' => esc_html__('Items Show', 'april-framework'),
                                                'sidebar'         => esc_html__('Sidebar', 'april-framework'),
                                                'filter'  => esc_html__('Filter', 'april-framework')
                                            )
                                        ),
                                    ),
                                    array(
                                        'id' => 'woocommerce_customize_item_show',
                                        'title' => esc_html__('Products per page', 'april-framework'),
                                        'type' => 'text',
                                        'default' => '6,12,18',
                                        'sub_title' => esc_html__('Input products per page (exp: 6,12,18)','april-framework'),
                                        'required' => array(
                                            array(
                                                array('woocommerce_customize[left]', 'contain', 'items-show'),
                                                array('woocommerce_customize[right]', 'contain', 'items-show')
                                            )
                                        )
                                    ),
                                    $this->get_config_sidebar(array(
                                        'id' => 'woocommerce_customize_sidebar',
                                        'required' => array(
                                            array(
                                                array('woocommerce_customize[left]', 'contain', 'sidebar'),
                                                array('woocommerce_customize[right]', 'contain', 'sidebar')
                                            )
                                        )
                                    ))
                                )
                            ),
                            $this->get_config_toggle(array(
                                'id'       => 'product_category_enable',
                                'title'    => esc_html__( 'Show Category', 'april-framework' ),
                                'default'  => ''
                            )),
                            $this->get_config_toggle(array(
                                'id'       => 'product_rating_enable',
                                'title'    => esc_html__( 'Show Rating', 'april-framework' ),
                                'default'  => ''
                            )),
                            $this->get_config_toggle(array(
                                'id'       => 'product_quick_view_enable',
                                'title'    => esc_html__( 'Show Quick View', 'april-framework' ),
                                'default'  => ''
                            ))
                        )
                    ),
                    array(
                        'id'     => 'section_woocommerce_group_single',
                        'title'  => esc_html__('Single Product', 'april-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id' => 'product_single_layout',
                                'title' => esc_html__('Layout','april-framework'),
                                'subtitle' => esc_html__('Specify your product single layout','april-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_product_single_layout(),
                                'default'  => 'layout-04'
                            ),
                            array(
                                'id'       => 'product_related_group',
                                'title'    => esc_html__('Product Related', 'april-framework'),
                                'type'     => 'group',
                                'fields'   => array(
                                    $this->get_config_toggle(array(
                                        'id'       => 'product_related_enable',
                                        'title'    => esc_html__( 'Show Product related', 'april-framework' ),
                                        'default'  => 'on'
                                    )),
                                    array(
                                        'id' => 'product_related_algorithm',
                                        'title' => esc_html__('Related Products Algorithm', 'april-framework'),
                                        'subtitle' => esc_html__('Specify the algorithm of related products', 'april-framework'),
                                        'type' => 'select',
                                        'options' => G5P()->settings()->get_related_product_algorithm(),
                                        'default' => 'cat-tag',
                                        'required' => array('product_related_enable','=','on')
                                    ),
                                    $this->get_config_toggle(array(
                                        'id' => 'product_related_carousel_enable',
                                        'title' => esc_html__('Carousel Mode', 'april-framework'),
                                        'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'april-framework'),
                                        'default' => '',
                                        'required' => array('product_related_enable','=','on')
                                    )),
                                    array(
                                        'id'       => 'product_related_columns_gutter',
                                        'title'    => esc_html__('Product Columns Gutter', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your horizontal space between product.', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_columns_gutter(),
                                        'default'  =>'30',
                                        'required' => array('product_related_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'       => 'product_related_columns_group',
                                        'title'    => esc_html__('Product Columns', 'april-framework'),
                                        'type'     => 'group',
                                        'required' => array('product_related_enable', '=', 'on'),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'product_related_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'product_related_columns',
                                                        'title'   => esc_html__('Large Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product related columns on large devices (>= 1200px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '4',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'product_related_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product related columns on medium devices (>= 992px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'product_related_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product related columns on small devices (>= 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'product_related_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product related columns on extra small devices (< 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id' => "product_related_columns_mb",
                                                        'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                        'desc' => esc_html__('Specify your product related columns on extra extra small devices (< 600px)', 'april-framework'),
                                                        'type' => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout' => 'full',
                                                    )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'         => 'product_related_per_page',
                                        'title'      => esc_html__('Products Per Page', 'april-framework'),
                                        'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 6', 'april-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'number',
                                        'default'    => '6',
                                        'required' => array('product_related_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'       => 'product_related_animation',
                                        'title'    => esc_html__('Animation', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your product animation', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_animation(true),
                                        'default'  => '',
                                        'required' => array('product_related_enable', '=', 'on')
                                    ),
                                )
                            ),
                            array(
                                'id'       => 'product_up_sells_group',
                                'title'    => esc_html__('Product Up Sells', 'april-framework'),
                                'type'     => 'group',
                                'fields'   => array(
                                    $this->get_config_toggle(array(
                                        'id'       => 'product_up_sells_enable',
                                        'title'    => esc_html__( 'Show Product Up Sells', 'april-framework' ),
                                        'default'  => 'on'
                                    )),
                                    array(
                                        'id'       => 'product_up_sells_columns_gutter',
                                        'title'    => esc_html__('Product Columns Gutter', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your horizontal space between product.', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_columns_gutter(),
                                        'default'  =>'30',
                                        'required' => array('product_up_sells_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'       => 'product_up_sells_columns_group',
                                        'title'    => esc_html__('Product Columns', 'april-framework'),
                                        'type'     => 'group',
                                        'required' => array('product_up_sells_enable', '=', 'on'),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'product_related_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'product_up_sells_columns',
                                                        'title'   => esc_html__('Large Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product up sells columns on large devices (>= 1200px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '4',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'product_up_sells_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product up sells columns on medium devices (>= 992px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'product_up_sells_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product up sells columns on small devices (>= 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'product_up_sells_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your product up sells columns on extra small devices (< 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id' => "product_up_sells_columns_mb",
                                                        'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                        'desc' => esc_html__('Specify your product up sells columns on extra extra small devices (< 600px)', 'april-framework'),
                                                        'type' => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout' => 'full',
                                                    )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'         => 'product_up_sells_per_page',
                                        'title'      => esc_html__('Products Per Page', 'april-framework'),
                                        'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 6', 'april-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'number',
                                        'default'    => '6',
                                        'required' => array('product_up_sells_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'       => 'product_up_sells_animation',
                                        'title'    => esc_html__('Animation', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your product animation', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_animation(true),
                                        'default'  => '',
                                        'required' => array('product_up_sells_enable', '=', 'on')
                                    ),
                                )
                            )
                        )
                    ),
                    array(
                        'id'       => 'product_cart_page_group',
                        'title'    => esc_html__('Cart Page', 'april-framework'),
                        'type'     => 'group',
                        'fields'   => array(
                            $this->get_config_toggle(array(
                                'id'       => 'product_cross_sells_enable',
                                'title'    => esc_html__( 'Show Product Cross Sells', 'april-framework' ),
                                'default'  => 'on'
                            )),
                            array(
                                'id'       => 'product_cross_sells_columns_gutter',
                                'title'    => esc_html__('Product Cross Sells Columns Gutter', 'april-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between product.', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_columns_gutter(),
                                'default'  =>'30',
                                'required' => array('product_cross_sells_enable', '=', 'on')
                            ),
                            array(
                                'id'       => 'product_cross_sells_columns_group',
                                'title'    => esc_html__('Product Cross Sells Columns', 'april-framework'),
                                'type'     => 'group',
                                'required' => array('product_cross_sells_enable', '=', 'on'),
                                'fields'   => array(
                                    array(
                                        'id'     => 'product_related_columns_row_1',
                                        'type'   => 'row',
                                        'col'    => 3,
                                        'fields' => array(
                                            array(
                                                'id'      => 'product_cross_sells_columns',
                                                'title'   => esc_html__('Large Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product cross sells columns on large devices (>= 1200px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '4',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'product_cross_sells_columns_md',
                                                'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product cross sells columns on medium devices (>= 992px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'product_cross_sells_columns_sm',
                                                'title'   => esc_html__('Small Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product cross sells columns on small devices (>= 768px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'product_cross_sells_columns_xs',
                                                'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                'desc'    => esc_html__('Specify your product cross sells columns on extra small devices (< 768px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id' => "product_cross_sells_columns_mb",
                                                'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                'desc' => esc_html__('Specify your product cross sells columns on extra extra small devices (< 600px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout' => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'         => 'product_cross_sells_per_page',
                                'title'      => esc_html__('Cross Sells Products Per Page', 'april-framework'),
                                'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 6', 'april-framework'),
                                'type'       => 'text',
                                'input_type' => 'number',
                                'default'    => '6',
                                'required' => array('product_cross_sells_enable', '=', 'on')
                            ),
                            array(
                                'id'       => 'product_cross_sells_animation',
                                'title'    => esc_html__('Animation', 'april-framework'),
                                'subtitle' => esc_html__('Specify your product animation', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_animation(true),
                                'default'  => '',
                                'required' => array('product_cross_sells_enable', '=', 'on')
                            ),
                        )
                    )
                )
            );
        }

        public function get_config_section_portfolio()
        {
            return array(
                'id'              => 'section_portfolio',
                'title'           => esc_html__('Portfolios', 'april-framework'),
                'icon'            => 'dashicons dashicons-images-alt2',
                'general_options' => true,
                'fields'          => array(
                    array(
                        'id'     => 'section_portfolio_group_archive',
                        'title'  => esc_html__('Archive and Category', 'april-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            $this->get_config_toggle(array(
                                'id'      => 'portfolio_filter_enable',
                                'title'   => esc_html__('Show Category Filter', 'april-framework'),
                                'default' => 'on'
                            )),
                            array(
                                'id'       => 'portfolio_layout',
                                'title'    => esc_html__('Layout', 'april-framework'),
                                'subtitle' => esc_html__('Specify your portfolio layout', 'april-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_portfolio_layout(),
                                'default'  => 'grid',
                                'preset'   => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'grid',
                                        'fields' => array(
                                            array('portfolio_per_page', 9),
                                            array('portfolio_image_size', 'medium'),
                                            array('portfolio_columns_gutter', 10),
                                            array('portfolio_columns', 3),
                                            array('portfolio_columns_md', 3),
                                            array('portfolio_columns_sm', 2),
                                            array('portfolio_columns_xs', 2),
                                            array('portfolio_columns_xs', 1),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'masonry',
                                        'fields' => array(
                                            array('portfolio_per_page', 9),
                                            array('portfolio_image_width[width]', 400),
                                            array('portfolio_columns_gutter', 10),
                                            array('portfolio_columns', 3),
                                            array('portfolio_columns_md', 3),
                                            array('portfolio_columns_sm', 2),
                                            array('portfolio_columns_xs', 2),
                                            array('portfolio_columns_xs', 1),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'scattered',
                                        'fields' => array(
                                            array('portfolio_per_page', 8)
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-1',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 10),
                                            array('portfolio_image_size', 'medium'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-2',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 10),
                                            array('portfolio_image_size', 'medium'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-3',
                                        'fields' => array(
                                            array('portfolio_per_page', 10),
                                            array('portfolio_columns_gutter', 10),
                                            array('portfolio_image_size', 'medium'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-4',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 'none'),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-5',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 'none'),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-6',
                                        'fields' => array(
                                            array('portfolio_per_page', 13),
                                            array('portfolio_columns_gutter', '30'),
                                            array('portfolio_image_size', '320x320'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-7',
                                        'fields' => array(
                                            array('portfolio_per_page', 11),
                                            array('portfolio_columns_gutter', '30'),
                                            array('portfolio_image_size', '270x310'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'carousel-3d',
                                        'fields' => array(
                                            array('portfolio_per_page', 9),
                                            array('portfolio_image_size', '804x468'),
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'       => 'portfolio_item_skin',
                                'title'    => esc_html__('Portfolio Item Skin', 'april-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_portfolio_item_skin(),
                                'default'  => 'portfolio-item-skin-02',
                                'required' => array('portfolio_layout', 'in', array('grid', 'masonry'))
                            ),
                            array(
                                'id'     => 'portfolio_image_size_group',
                                'title'  => esc_html__('Portfolio Image Size', 'april-framework'),
                                'type'   => 'group',
                                'fields' => array(
                                    array(
                                        'id'       => 'portfolio_image_size',
                                        'title'    => esc_html__('Image size', 'april-framework'),
                                        'subtitle' => esc_html__('Enter your portfolio image size', 'april-framework'),
                                        'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'april-framework'),
                                        'type'     => 'text',
                                        'default'  => 'medium',
                                        'required' => array('portfolio_layout', 'not in', array('masonry', 'scattered'))
                                    ),
                                    array(
                                        'id'       => 'portfolio_image_ratio',
                                        'title'    => esc_html__('Image ratio', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your image portfolio ratio', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_image_ratio(),
                                        'default'  => '1x1',
                                        'required' => array(
                                            array('portfolio_layout', 'not in', array('masonry', 'scattered')),
                                            array('portfolio_image_size', '=', 'full')
                                        )
                                    ),
                                    array(
                                        'id'       => 'portfolio_image_ratio_custom',
                                        'title'    => esc_html__('Image ratio custom', 'april-framework'),
                                        'subtitle' => esc_html__('Enter custom image ratio', 'april-framework'),
                                        'type'     => 'dimension',
                                        'required' => array(
                                            array('portfolio_layout', 'not in', array('masonry', 'scattered')),
                                            array('portfolio_image_size', '=', 'full'),
                                            array('portfolio_image_ratio', '=', 'custom')
                                        )
                                    ),
                                    array(
                                        'id'       => 'portfolio_image_width',
                                        'title'    => esc_html__('Image Width', 'april-framework'),
                                        'subtitle' => esc_html__('Enter image width', 'april-framework'),
                                        'type'     => 'dimension',
                                        'height'   => false,
                                        'default'  => array(
                                            'width' => '400'
                                        ),
                                        'required' => array('portfolio_layout', 'in', array('masonry'))
                                    )
                                )
                            ),

                            array(
                                'id'       => 'portfolio_columns_gutter',
                                'title'    => esc_html__('Portfolio Columns Gutter', 'april-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between portfolio.', 'april-framework'),
                                'type'     => 'select',
                                'options'  => array(
                                    'none'  => esc_html__('None', 'april-framework'),
                                    '10' => '10px',
                                    '20' => '20px',
                                    '30' => '30px',
                                    '40' => '40px',
                                    '50' => '50px'
                                ),
                                'default'  => '10',
                                'required' => array('portfolio_layout', 'not in', array('scattered', 'carousel-3d'))
                            ),
                            array(
                                'id'       => 'portfolio_columns_group',
                                'title'    => esc_html__('Portfolio Columns', 'april-framework'),
                                'type'     => 'group',
                                'required' => array('portfolio_layout', 'in', array('grid', 'masonry')),
                                'fields'   => array(
                                    array(
                                        'id'     => 'portfolio_columns_row_1',
                                        'type'   => 'row',
                                        'col'    => 3,
                                        'fields' => array(
                                            array(
                                                'id'      => 'portfolio_columns',
                                                'title'   => esc_html__('Large Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on large devices (>= 1200px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'portfolio_columns_md',
                                                'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on medium devices (>= 992px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'portfolio_columns_sm',
                                                'title'   => esc_html__('Small Devices', 'april-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on small devices (>= 768px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'portfolio_columns_xs',
                                                'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on extra small devices (< 768px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => "portfolio_columns_mb",
                                                'title'   => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on extra extra small devices (< 600px)', 'april-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout'  => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'       => 'portfolio_per_page',
                                'title'    => esc_html__('Portfolio Items Per Page', 'april-framework'),
                                'subtitle' => esc_html__('Controls the number of posts that display per page for portfolio archive pages. Set to -1 to display all. Set to 0 to use the number of posts from Settings > Reading.', 'april-framework'),
                                'type'     => 'text',
                                'default'  => '9',
                            ),
                            array(
                                'id'       => 'portfolio_paging',
                                'title'    => esc_html__('Portfolio Paging', 'april-framework'),
                                'subtitle' => esc_html__('Specify your portfolio paging mode', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_paging_mode(),
                                'default'  => 'load-more'
                            ),
                            array(
                                'id'       => 'portfolio_animation',
                                'title'    => esc_html__('Animation', 'april-framework'),
                                'subtitle' => esc_html__('Specify your portfolio animation', 'april-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_animation(),
                                'default'  => 'none'
                            ),
                            array(
                                'id'       => 'portfolio_hover_effect',
                                'type'     => 'select',
                                'title'    => esc_html__('Hover Effect', 'april-framework'),
                                'subtitle' => esc_html__('Specify your portfolio hover effect', 'april-framework'),
                                'desc'     => '',
                                'options'  => G5P()->settings()->get_portfolio_hover_effect(),
                                'default'  => 'none'
                            ),
                            array(
                                'id'       => 'portfolio_light_box',
                                'type'     => 'select',
                                'title'    => esc_html__('Light Box', 'april-framework'),
                                'subtitle' => esc_html__('Specify your portfolio light box', 'april-framework'),
                                'options'  => array(
                                    'feature' => esc_html__('Feature Image', 'april-framework'),
                                    'media'   => esc_html__('Media Gallery', 'april-framework')
                                ),
                                'default'  => 'feature'
                            )
                        )
                    ),
                    array(
                        'id'     => 'section_portfolio_group_details',
                        'title'  => esc_html__('Portfolio Details', 'april-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id'             => 'single_portfolio_details',
                                'title'          => esc_html__('Portfolio Details', 'april-framework'),
                                'desc'           => esc_html__('Define here all the portfolio details you will need.', 'april-framework'),
                                'type'           => 'panel',
                                'toggle_default' => false,
                                'sort'           => true,
                                'default'        => G5P()->settings()->get_portfolio_details_default(),
                                'panel_title'    => 'title',
                                'fields'         => array(
                                    array(
                                        'id'       => 'title',
                                        'title'    => esc_html__('Title', 'april-framework'),
                                        'subtitle' => esc_html__('Enter your portfolio details title', 'april-framework'),
                                        'type'     => 'text',
                                    ),
                                    array(
                                        'id'         => 'id',
                                        'title'      => esc_html__('Unique portfolio details Id', 'april-framework'),
                                        'subtitle'   => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'april-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'unique_id',
                                        'default'    => 'portfolio_details_'
                                    ),
                                )
                            ),
                        )
                    ),
                    array(
                        'id'     => 'section_portfolio_group_single',
                        'title'  => esc_html__('Single Portfolio', 'april-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id'       => 'single_portfolio_layout',
                                'title'    => esc_html__('Layout', 'april-framework'),
                                'subtitle' => esc_html__('Specify your single portfolio layout', 'april-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_single_portfolio_layout(),
                                'default'  => 'layout-1'
                            ),
                            array(
                                'id'       => 'single_portfolio_gallery_group',
                                'title'    => esc_html__('Gallery', 'april-framework'),
                                'type'     => 'group',
                                'required' => array('single_portfolio_layout', '!=', 'layout-5'),
                                'fields'   => array(
                                    array(
                                        'id'       => 'single_portfolio_gallery_layout',
                                        'title'    => esc_html__('Layout', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your single portfolio gallery layout', 'april-framework'),
                                        'type'     => 'image_set',
                                        'options'  => G5P()->settings()->get_single_portfolio_gallery_layout(),
                                        'default'  => 'carousel',
                                        'preset' => array(
                                            array(
                                                'op'     => '=',
                                                'value'  => 'carousel',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '4x3'),
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'thumbnail',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '4x3'),
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'carousel-center',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '4x3'),
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'grid',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'medium')
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'carousel-3d',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', '804x468')
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'metro',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', '370x320')
                                                )
                                            )
                                        )
                                    ),
                                    array(
                                        'id'     => 'single_portfolio_gallery_image_size_group',
                                        'title'  => esc_html__('Image Size', 'april-framework'),
                                        'type'   => 'group',
                                        'fields' => array(
                                            array(
                                                'id'       => 'single_portfolio_gallery_image_size',
                                                'title'    => esc_html__('Image size', 'april-framework'),
                                                'subtitle' => esc_html__('Enter your portfolio gallery image size', 'april-framework'),
                                                'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'april-framework'),
                                                'type'     => 'text',
                                                'default'  => 'medium'
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_gallery_image_ratio',
                                                'title'    => esc_html__('Image ratio', 'april-framework'),
                                                'subtitle' => esc_html__('Specify your image portfolio gallery ratio', 'april-framework'),
                                                'type'     => 'select',
                                                'options'  => G5P()->settings()->get_image_ratio(),
                                                'default'  => '1x1',
                                                'required' => array(
                                                    array('single_portfolio_gallery_image_size', '=', 'full')
                                                )
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_gallery_image_ratio_custom',
                                                'title'    => esc_html__('Image ratio custom', 'april-framework'),
                                                'subtitle' => esc_html__('Enter custom image ratio', 'april-framework'),
                                                'type'     => 'dimension',
                                                'required' => array(
                                                    array('single_portfolio_gallery_image_size', '=', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '=', 'custom')
                                                )
                                            )
                                        )
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_gallery_columns_gutter',
                                        'title'    => esc_html__('Portfolio Gallery Columns Gutter', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your horizontal space between portfolio gallery.', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_columns_gutter(),
                                        'default'  => '10',
                                        'required' => array('single_portfolio_gallery_layout', 'not in', array('thumbnail', 'carousel-3d'))
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_gallery_columns_group',
                                        'title'    => esc_html__('Portfolio Gallery Columns', 'april-framework'),
                                        'type'     => 'group',
                                        'required' => array('single_portfolio_gallery_layout', 'not in', array('thumbnail', 'carousel-3d', 'metro')),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'single_portfolio_gallery_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns',
                                                        'title'   => esc_html__('Large Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on large devices (>= 1200px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on medium devices (>= 992px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on small devices (>= 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on extra small devices (< 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_mb',
                                                        'title'   => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on extra extra small devices (< 600px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout'  => 'full',
                                                    )
                                                )
                                            ),
                                        )
                                    ),

                                )

                            ),
                            array(
                                'id' => 'single_portfolio_related_group',
                                'title' => esc_html__('Portfolio Related','april-framework'),
                                'type' => 'group',
                                'fields' => array(
                                    $this->get_config_toggle(array(
                                        'id' => 'single_portfolio_related_enable',
                                        'title' => esc_html__('Portfolio Related Enable','april-framework'),
                                        'default' => 'on',
                                        'subtitle' => esc_html__('Turn Off this option if you want to hide related portfolio area on single portfolio','april-framework')
                                    )),
                                    $this->get_config_toggle(array(
                                        'id' => 'single_portfolio_related_full_width_enable',
                                        'title' => esc_html__('Project Related Full Width','april-framework'),
                                        'default' => '',
                                        'subtitle' => esc_html__('Turn on this option if you want to project relate display full width','april-framework')
                                    )),
                                    array(
                                        'id'       => 'single_portfolio_related_algorithm',
                                        'title'    => esc_html__('Related Portfolio Algorithm', 'april-framework'),
                                        'subtitle' => esc_html__('Specify the algorithm of related portfolio', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_portfolio_related_algorithm(),
                                        'default'  => 'cat',
                                        'required' => array('single_portfolio_related_enable', '=', 'on')
                                    ),
                                    $this->get_config_toggle(array(
                                        'id'       => 'single_portfolio_related_carousel_enable',
                                        'title'    => esc_html__('Carousel Mode', 'april-framework'),
                                        'subtitle' => esc_html__('Turn Off this option if you want to disable carousel mode', 'april-framework'),
                                        'default'  => 'on',
                                        'required' => array('single_portfolio_related_enable', '=', 'on')
                                    )),
                                    array(
                                        'id'         => 'single_portfolio_related_per_page',
                                        'title'      => esc_html__('Posts Per Page', 'april-framework'),
                                        'subtitle'   => esc_html__('Enter number of posts per page you want to display', 'april-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'number',
                                        'default'    => 6,
                                        'required'   => array('single_portfolio_related_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'     => 'single_portfolio_related_image_size_group',
                                        'title'  => esc_html__('Portfolio Related Image Size', 'april-framework'),
                                        'type'   => 'group',
                                        'required' => array('single_portfolio_related_enable', '=', 'on'),
                                        'fields' => array(
                                            array(
                                                'id'       => 'single_portfolio_related_image_size',
                                                'title'    => esc_html__('Image size', 'april-framework'),
                                                'subtitle' => esc_html__('Enter your portfolio related image size', 'april-framework'),
                                                'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'april-framework'),
                                                'type'     => 'text',
                                                'default'  => 'medium',
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_related_image_ratio',
                                                'title'    => esc_html__('Image ratio', 'april-framework'),
                                                'subtitle' => esc_html__('Specify your image portfolio related ratio', 'april-framework'),
                                                'type'     => 'select',
                                                'options'  => G5P()->settings()->get_image_ratio(),
                                                'default'  => '1x1',
                                                'required' => array('single_portfolio_related_image_size', '=', 'full')
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_related_image_ratio_custom',
                                                'title'    => esc_html__('Image ratio custom', 'april-framework'),
                                                'subtitle' => esc_html__('Enter custom image ratio', 'april-framework'),
                                                'type'     => 'dimension',
                                                'required' => array(
                                                    array('single_portfolio_related_image_size', '=', 'full'),
                                                    array('single_portfolio_related_image_ratio', '=', 'custom')
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_related_columns_gutter',
                                        'title'    => esc_html__('Portfolio Related Columns Gutter', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your horizontal space between portfolio related.', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_columns_gutter(),
                                        'default'  => '30',
                                        'required' => array('single_portfolio_related_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_related_columns_group',
                                        'title'    => esc_html__('Portfolio Related Columns', 'april-framework'),
                                        'type'     => 'group',
                                        'required' => array('single_portfolio_related_enable', '=', 'on'),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'single_portfolio_related_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns',
                                                        'title'   => esc_html__('Large Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on large devices (>= 1200px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on medium devices (>= 992px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on small devices (>= 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on extra small devices (< 768px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_mb',
                                                        'title'   => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on extra extra small devices (< 600px)', 'april-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout'  => 'full',
                                                    )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_related_post_paging',
                                        'title'    => esc_html__('Post Paging', 'april-framework'),
                                        'subtitle' => esc_html__('Specify your post paging mode', 'april-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_paging_small_mode(),
                                        'default'  => 'none',
                                        'required' => array(
                                            array('single_portfolio_related_carousel_enable', '!=' ,'on'),
                                            array('single_portfolio_related_enable', '=', 'on')
                                        )
                                    )
                                )
                            )

                        )
                    )
                )
            );
        }
    }
}