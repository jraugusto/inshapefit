<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Meta_Boxes')) {
    class G5P_Inc_Config_Meta_Boxes
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
            add_filter('gsf_meta_box_config', array($this, 'register_meta_boxes'));
        }

	    public function getPostType() {
		    return apply_filters('gsf_page_setting_post_type', array('page', 'post'));
	    }

        public function register_meta_boxes($configs)
        {
            $prefix = G5P()->getMetaPrefix();

            /**
             * CUSTOM PAGE SETTINGS
             */
            $configs['gsf_page_setting'] = array(
                'name' => esc_html__('Page Settings', 'april-framework'),
                'post_type' => $this->getPostType(),
                'layout' => 'inline',
	            'section' => array(
		            array(
			            'id' =>  "{$prefix}section_general",
			            'title' => esc_html__('General', 'april-framework'),
			            'icon' => 'dashicons dashicons-admin-site',
			            'fields' => array(
				            G5P()->configOptions()->get_config_preset(array('id' => "{$prefix}page_preset")),
				            array(
					            'id' => "{$prefix}group_layout",
					            'type' => 'group',
					            'title' => esc_html__('Layout','april-framework'),
					            'fields' => array(
						            array(
							            'id' => "{$prefix}main_layout",
							            'title' => esc_html__('Site Layout', 'april-framework'),
							            'type' => 'image_set',
							            'options' => G5P()->settings()->get_main_layout(true),
							            'default' => '',
						            ),

						            G5P()->configOptions()->get_config_toggle(array(
							            'id' => "{$prefix}content_full_width",
							            'title' => esc_html__('Content Full Width', 'april-framework'),
							            'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'april-framework'),
							            'default' => '',
						            ),true),

						            G5P()->configOptions()->get_config_toggle(array(
							            'id' => "{$prefix}custom_content_padding",
							            'title' => esc_html__('Custom Content Padding','april-framework'),
							            'subtitle' => esc_html__('Turn On this option if you want to custom content padding.', 'april-framework'),
							            'default' => ''
						            )),

						            array(
							            'id' => "{$prefix}content_padding",
							            'title' => esc_html__('Content Padding', 'april-framework'),
							            'subtitle' => esc_html__('Set content padding', 'april-framework'),
							            'type' => 'spacing',
							            'default' => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
							            'required' => array("{$prefix}custom_content_padding",'=','on')
						            ),

						            G5P()->configOptions()->get_config_sidebar_layout(array(
							            'id' => "{$prefix}sidebar_layout",
						            ),true),
						            G5P()->configOptions()->get_config_sidebar(array(
							            'id' => "{$prefix}sidebar",
							            'required' => array("{$prefix}sidebar_layout",'!=','none')
						            )),
					            )
				            ),

				            array(
					            'id' => "{$prefix}group_page_title",
					            'type' => 'group',
					            'title' => esc_html__('Page Title','april-framework'),
					            'fields' => array(
						            G5P()->configOptions()->get_config_toggle(array(
							            'title' => esc_html__('Page Title Enable','april-framework'),
							            'id' => "{$prefix}page_title_enable"
						            ),true),
						            G5P()->configOptions()->get_config_content_block(array(
							            'id' => "{$prefix}page_title_content_block",
							            'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'april-framework'),
							            'required' => array("{$prefix}page_title_enable", '!=', 'off')
						            ),true),

						            array(
							            'title'       => esc_html__('Custom Page title', 'april-framework'),
							            'id'          => "{$prefix}page_title_content",
							            'type'        => 'text',
							            'default'     => '',
							            'required' => array("{$prefix}page_title_enable", '!=', 'off'),
							            'desc'        => esc_html__('Enter custom page title for this page', 'april-framework')
						            )
					            )
				            ),
				            array(
					            'title'        => esc_html__('Custom Css Class', 'april-framework'),
					            'id'          => "{$prefix}css_class",
					            'type'        => 'selectize',
					            'tags' => true,
					            'default'         => '',
					            'desc'        => esc_html__('Enter custom class for this page', 'april-framework')
				            )
			            )
		            ),
		            array(
			            'id' => "{$prefix}section_menu",
			            'title' => esc_html__('Menu', 'april-framework'),
			            'icon' => 'dashicons dashicons-menu',
			            'fields' => array(
				            array(
					            'id' => "{$prefix}page_menu",
					            'title' => esc_html__('Page Menu', 'april-framework'),
					            'type' => 'selectize',
					            'allow_clear' => true,
					            'placeholder' => esc_html__('Select Menu', 'april-framework'),
					            'desc' => esc_html__('Optionally you can choose to override the menu that is used on the page', 'april-framework'),
					            'data' => 'menu'
				            ),
				            array(
					            'id' => "{$prefix}page_mobile_menu",
					            'title' => esc_html__('Page Mobile Menu', 'april-framework'),
					            'type' => 'selectize',
					            'allow_clear' => true,
					            'placeholder' => esc_html__('Select Menu', 'april-framework'),
					            'desc' => esc_html__('Optionally you can choose to override the menu mobile that is used on the page', 'april-framework'),
					            'data' => 'menu'
				            ),
				            G5P()->configOptions()->get_config_toggle(array(
					            'id' => "{$prefix}is_one_page",
					            'title' => esc_html__('Is One Page', 'april-framework'),
					            'desc' => esc_html__('Set page style is One Page', 'april-framework'),
				            ))
			            )
		            ),

	            ),
            );

            /**
             * CUSTOME POST SETTING
             */
            $configs['gsf_post_setting'] = array(
                'name' => esc_html__('Post Settings', 'april-framework'),
                'post_type' => array('post'),
                'layout' => 'inline',
                'section' => array(
                    array(
                        'id' =>  "{$prefix}section_post_general",
                        'title' => esc_html__('Single Post', 'april-framework'),
                        'icon' => 'dashicons dashicons-welcome-write-blog',
                        'fields' => array(
                            array(
                                'id' => "{$prefix}single_post_layout",
                                'title' => esc_html__('Post Layout', 'april-framework'),
                                'subtitle' => esc_html__('Specify your post layout', 'april-framework'),
                                'type' => 'image_set',
                                'options' => G5P()->settings()->get_single_post_layout(true),
                                'default' => ''
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}custom_single_image_padding",
                                'title' => esc_html__('Custom Single Image Padding','april-framework'),
                                'default' => '',
                                'required' => array("{$prefix}single_post_layout", '=', 'layout-5')
                            )),
                            array(
                                'id' => "{$prefix}post_single_image_padding",
                                'title' => esc_html__('Single Image Padding', 'april-framework'),
                                'subtitle' => esc_html__('Set single image padding', 'april-framework'),
                                'type' => 'spacing',
                                'default' => array('left' => 0, 'right' => 0, 'top' => 0, 'bottom' => 0),
                                'required' => array("{$prefix}custom_single_image_padding", '=', 'on')
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}custom_single_image_mobile_padding",
                                'title' => esc_html__('Custom Single Image Mobile Padding','april-framework'),
                                'default' => '',
                                'required' => array("{$prefix}single_post_layout", '=', 'layout-5')
                            )),
                            array(
                                'id' => "{$prefix}post_single_image_mobile_padding",
                                'title' => esc_html__('Single Image Mobile Padding', 'april-framework'),
                                'subtitle' => esc_html__('Set single image mobile padding', 'april-framework'),
                                'type' => 'spacing',
                                'default' => array('left' => 0, 'right' => 0, 'top' => 0, 'bottom' => 0),
                                'required' => array("{$prefix}custom_single_image_mobile_padding", '=', 'on')
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_reading_process_enable",
                                'title' => esc_html__('Reading Process', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide reading process on single blog', 'april-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_tag_enable",
                                'title' => esc_html__('Tags', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide tags on single blog', 'april-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_share_enable",
                                'title' => esc_html__('Share', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide share on single blog', 'april-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_navigation_enable",
                                'title' => esc_html__('Navigation', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide navigation on single blog', 'april-framework'),
                                'default' => ''
                            ), true),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_author_info_enable",
                                'title' => esc_html__('Author Info', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide author info area on single blog', 'april-framework'),
                                'default' => ''
                            ), true)
                        )
                    ),
                    array(
                        'id' =>  "{$prefix}section_post_related",
                        'title' => esc_html__('Related Posts', 'april-framework'),
                        'icon' => 'dashicons dashicons-images-alt2',
                        'fields' => array(
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_related_post_enable",
                                'title' => esc_html__('Related Posts', 'april-framework'),
                                'subtitle' => esc_html__('Turn Off this option if you want to hide related posts area on single blog', 'april-framework'),
                                'default' => ''
                            ), true),
                            array(
                                'id' => "{$prefix}single_related_post_algorithm",
                                'title' => esc_html__('Related Posts Algorithm', 'april-framework'),
                                'subtitle' => esc_html__('Specify the algorithm of related posts', 'april-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_related_post_algorithm(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            G5P()->configOptions()->get_config_toggle(array(
                                'id' => "{$prefix}single_related_post_carousel_enable",
                                'title' => esc_html__('Carousel Mode', 'april-framework'),
                                'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'april-framework'),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ), true),
                            array(
                                'id' => "{$prefix}single_related_post_per_page",
                                'title' => esc_html__('Posts Per Page', 'april-framework'),
                                'subtitle' => esc_html__('Enter number of posts per page you want to display', 'april-framework'),
                                'type' => 'text',
                                'input_type' => 'number',
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_columns_gutter",
                                'title' => esc_html__('Post Columns Gutter', 'april-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between post.', 'april-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_post_columns_gutter(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_columns_group",
                                'title' => esc_html__('Post Columns', 'april-framework'),
                                'type' => 'group',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', '')),
                                'fields' => array(
                                    array(
                                        'id' => "{$prefix}single_related_post_columns_row_1",
                                        'type' => 'row',
                                        'col' => 3,
                                        'fields' => array(
                                            array(
                                                'id' => "{$prefix}single_related_post_columns",
                                                'title' => esc_html__('Large Devices', 'april-framework'),
                                                'desc' => esc_html__('Specify your post columns on large devices (>= 1200px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_md",
                                                'title' => esc_html__('Medium Devices', 'april-framework'),
                                                'desc' => esc_html__('Specify your post columns on medium devices (>= 992px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_sm",
                                                'title' => esc_html__('Small Devices', 'april-framework'),
                                                'desc' => esc_html__('Specify your post columns on small devices (>= 768px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_xs",
                                                'title' => esc_html__('Extra Small Devices ', 'april-framework'),
                                                'desc' => esc_html__('Specify your post columns on extra small devices (< 768px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            ),
                                            array(
                                                'id' => "{$prefix}single_related_post_columns_mb",
                                                'title' => esc_html__('Extra Extra Small Devices ', 'april-framework'),
                                                'desc' => esc_html__('Specify your post columns on extra extra small devices (< 600px)', 'april-framework'),
                                                'type' => 'select',
                                                'options' => G5P()->settings()->get_post_columns(true),
                                                'default' => '',
                                                'layout' => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_paging",
                                'title' => esc_html__('Post Paging', 'april-framework'),
                                'subtitle' => esc_html__('Specify your post paging mode', 'april-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_post_paging_small_mode(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            ),
                            array(
                                'id' => "{$prefix}single_related_post_animation",
                                'title' => esc_html__('Animation', 'april-framework'),
                                'subtitle' => esc_html__('Specify your post animation', 'april-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_animation(true),
                                'default' => '',
                                'required' => array("{$prefix}single_related_post_enable",'in',array('on', ''))
                            )
                        )
                    )
                )
            );




            return $configs;
        }
    }
}