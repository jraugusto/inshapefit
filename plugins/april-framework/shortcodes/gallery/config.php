<?php
return array(
	'base' => 'gsf_gallery',
	'name' => esc_html__( 'Gallery', 'april-framework' ),
	'icon' => 'fa fa-th',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array_merge(
	    array(
            array(
                'type' => 'gsf_image_set',
                'param_name' => 'layout_style',
                'heading' => esc_html__('Layout Style', 'april-framework'),
                'value' => array(
                    'grid' => array(
                        'label' => esc_html__('Grid', 'april-framework'),
                        'img'   => G5P()->pluginUrl('assets/images/shortcode/gallery-grid.png'),
                    ),
                    'carousel' => array(
                        'label' => esc_html__('Slider', 'april-framework'),
                        'img'   => G5P()->pluginUrl('assets/images/shortcode/carousel.png'),
                    ),
                    'thumbnail' => array(
                        'label' => esc_html__('Sync Carousel', 'april-framework'),
                        'img'   => G5P()->pluginUrl('assets/images/shortcode/gallery-thumbnail.png'),
                    ),
                    'masonry' => array(
                        'label' => esc_html__('Masonry', 'april-framework'),
                        'img'   => G5P()->pluginUrl('assets/images/shortcode/gallery-masonry.png'),
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
                    'carousel-3d' => array(
                        'label' => esc_html__('Carousel 3D', 'april-framework'),
                        'img'   => G5P()->pluginUrl('assets/images/shortcode/gallery-carousel-3d.png')
                    )
                ),
                'std' => 'grid'
            ),
            array(
                'param_name'       => 'image_size',
                'heading'    => esc_html__('Image size', 'april-framework'),
                'description' => esc_html__('Enter your product image size', 'april-framework'),
                'type'     => 'textfield',
                'std'  => 'medium',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('masonry'))
            ),
            array(
                'param_name'       => 'image_ratio',
                'heading'    => esc_html__('Image ratio', 'april-framework'),
                'description' => esc_html__('Specify your image product ratio', 'april-framework'),
                'type'     => 'dropdown',
                'value'  => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_image_ratio()),
                'std'  => '1x1',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full')
            ),
            array(
                'param_name'       => 'image_ratio_custom_width',
                'heading'    => esc_html__('Image ratio custom width', 'april-framework'),
                'description' => esc_html__('Enter custom width for image ratio', 'april-framework'),
                'type'     => 'gsf_number',
                'std'      => '600',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name'       => 'image_ratio_custom_height',
                'heading'    => esc_html__('Image ratio custom height', 'april-framework'),
                'description' => esc_html__('Enter custom height for image ratio', 'april-framework'),
                'type'     => 'gsf_number',
                'std' => '500',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name'       => 'image_masonry_width',
                'heading'    => esc_html__('Image masonry width', 'april-framework'),
                'type'     => 'gsf_number',
                'std'      => '400',
                'dependency' => array('element' => 'layout_style', 'value' => 'masonry')
            ),
            array(
                'type' => 'attach_images',
                'heading' => esc_html__('Images', 'april-framework'),
                'param_name' => 'images'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Hover effect', 'april-framework'),
                'param_name' => 'hover_effect',
                'std' => 'default-effect',
                'value'      => array(
                    esc_html__('Default', 'april-framework') => 'default-effect',
                    esc_html__('Suprema', 'april-framework')   => 'suprema-effect',
                    esc_html__('Layla', 'april-framework')   => 'layla-effect',
                    esc_html__('Bubba', 'april-framework')   => 'bubba-effect',
                    esc_html__('Jazz', 'april-framework')    => 'jazz-effect',
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Columns Gutter', 'april-framework'),
                'param_name' => 'columns_gutter',
                'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_post_columns_gutter() ),
                'std' => '10',
                'dependency' => array('element' => 'layout_style','value_not_equal_to' => array('carousel-3d')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
        ),

        G5P()->shortCode()->get_column_responsive(array(
            'element'=>'layout_style',
            'value'=> array('grid', 'carousel', 'masonry', 'thumbnail')
        )),
        array(
            G5P()->shortcode()->vc_map_add_pagination(
                array(
                    'group' => esc_html__('Slider Options', 'april-framework'),
                    'dependency' => array('element' => 'layout_style', 'value' =>  array('carousel', 'carousel-3d'))
                )
            ),
            G5P()->shortcode()->vc_map_add_navigation(array(
                'group' => esc_html__('Slider Options', 'april-framework'),
                'dependency' => array('element' => 'layout_style', 'value' => array('carousel', 'carousel-3d'))
            )),
            G5P()->shortcode()->vc_map_add_navigation_position(array(
                'group' => esc_html__('Slider Options', 'april-framework')
            )),
            G5P()->shortcode()->vc_map_add_navigation_style(array(
                'group' => esc_html__('Slider Options', 'april-framework')
            )),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Center', 'april-framework'),
                'param_name' => 'center',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'group' => esc_html__('Slider Options', 'april-framework'),
                'dependency' => array('element' => 'layout_style', 'value' => array('carousel'))
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Loop', 'april-framework'),
                'param_name' => 'loop',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'group' => esc_html__('Slider Options', 'april-framework'),
                'dependency' => array('element' => 'layout_style', 'value' => array('carousel', 'carousel-3d'))
            ),
            G5P()->shortCode()->vc_map_add_autoplay_enable(array(
                'dependency' => array('element' => 'layout_style', 'value' => array('carousel', 'carousel-3d')),
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(array(
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
            G5P()->shortcode()->vc_map_add_css_animation(),
            G5P()->shortcode()->vc_map_add_animation_duration(),
            G5P()->shortcode()->vc_map_add_animation_delay(),
            G5P()->shortcode()->vc_map_add_extra_class(),
            G5P()->shortcode()->vc_map_add_css_editor(),
            G5P()->shortcode()->vc_map_add_responsive()
        )
	),
);