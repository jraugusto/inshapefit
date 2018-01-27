<?php
return array(
    'base'        => 'gsf_testimonials',
    'name'        => esc_html__('Testimonials', 'april-framework'),
    'icon'        => 'fa fa-quote-right',
    'category'    => G5P()->shortcode()->get_category_name(),
    'params'      => array_merge(
        array(
            array(
                'type'        => 'gsf_image_set',
                'heading'     => esc_html__('Testimonials Layout', 'april-framework'),
                'description' => esc_html__('Select our testimonial layout.', 'april-framework'),
                'param_name'  => 'layout_style',
                'value'       => array(
                    'style-01' => array(
                        'label' => esc_html__('Style 01', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-01.jpg')
                    ),
                    'style-02' => array(
                        'label' => esc_html__('Style 02', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-02.jpg')
                    ),
                    'style-03' => array(
                        'label' => esc_html__('Style 03', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-03.jpg')
                    ),
                    'style-04' => array(
                        'label' => esc_html__('Style 04', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-04.png')
                    ),
                    'style-05' => array(
                        'label' => esc_html__('Style 05', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-05.png')
                    )
                ),
                'std' => 'style-02',
                'admin_label' => true,
            ),
            array(
                'type'             => 'dropdown',
                'heading'          => esc_html__('Columns Gutter', 'april-framework'),
                'param_name'       => 'columns_gutter',
                'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_post_columns_gutter() ),
                'std' => '30',
                'dependency'       => array(
                    'element' => 'layout_style',
                    'value'   => array('style-01')
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__('Upload Blockquote Image:', 'april-framework'),
                'param_name'  => 'image',
                'value'       => '',
                'dependency'       => array(
                    'element' => 'layout_style',
                    'value'   => array('style-02')
                )
            ),
            array(
                'type'        => 'gsf_button_set',
                'heading'     => esc_html__('Testimonial Style', 'april-framework'),
                'param_name'  => 'tes_style',
                'value'       => array(
                    esc_html__('Thin', 'april-framework') => 'text-thin',
                    esc_html__('Fat', 'april-framework') => 'text-fat'
                ),
                'dependency'       => array(
                    'element' => 'layout_style',
                    'value'   => array('style-03')
                ),
                'std' => 'text-thin'
            ),
            array(
                'type'        => 'param_group',
                'heading'     => esc_html__('Values', 'april-framework'),
                'param_name'  => 'values',
                'description' => esc_html__('Enter values for author', 'april-framework'),
                'value'       => '',
                'params'      => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Author Name', 'april-framework'),
                        'param_name'  => 'author_name',
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Author Job', 'april-framework'),
                        'param_name'  => 'author_job',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'textarea',
                        'heading'    => esc_html__('Content testimonials of the author', 'april-framework'),
                        'param_name' => 'author_bio'
                    ),
                    array(
                        'type'        => 'attach_image',
                        'heading'     => esc_html__('Upload Avatar:', 'april-framework'),
                        'param_name'  => 'author_avatar',
                        'value'       => '',
                        'dependency' => array('element' => 'layout_style', 'value' => array('style-01', 'style-02')),
                        'description' => esc_html__('Upload avatar for author.', 'april-framework'),
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Author Link', 'april-framework'),
                        'param_name' => 'author_link'
                    ),
                )
            ),
            G5P()->shortcode()->vc_map_add_pagination(array(
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation_position(array(
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation_style(array(
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortCode()->vc_map_add_autoplay_enable(),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(),
        ),
        G5P()->shortCode()->get_column_responsive(array(
            'element'=>'layout_style',
            'value'=>array('style-01')
        )),
        array(
            G5P()->shortcode()->vc_map_add_css_animation(),
            G5P()->shortcode()->vc_map_add_animation_duration(),
            G5P()->shortcode()->vc_map_add_animation_delay(),
            G5P()->shortcode()->vc_map_add_extra_class(),
            G5P()->shortcode()->vc_map_add_css_editor(),
            G5P()->shortcode()->vc_map_add_responsive()
        )
    )
);