<?php
return array(
	'base' => 'gsf_heading',
	'name' => esc_html__( 'Heading', 'april-framework' ),
	'icon' => 'fa fa-header',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'april-framework'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-01.jpg'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-02.jpg'),
                ),
                'style-03' => array(
                    'label' => esc_html__('Style 03', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-03.jpg'),
                ),
                'style-04' => array(
                    'label' => esc_html__('Style 04', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-04.jpg'),
                ),
                'style-05' => array(
                    'label' => esc_html__('Style 05', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-05.png'),
                )
            ),
            'std' => 'style-01',
            'admin_label' => true,
        ),
		G5P()->shortcode()->vc_map_add_title(array(
		    'admin_label' => true,
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        )),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title Color', 'april-framework'),
            'param_name' => 'title_color',
            'std' => '#333',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'gsf_number',
            'heading' => esc_html__('Title font size', 'april-framework'),
            'param_name' => 'title_font_size',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 34
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Subtitle', 'april-framework'),
            'param_name' => 'sub_title',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'layout_style', 'value' => 'style-03')
        ),
        array(
            'type' => 'gsf_number',
            'heading' => esc_html__('Subtitle font size', 'april-framework'),
            'param_name' => 'sub_title_font_size',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'layout_style', 'value' => 'style-03'),
            'std' => 80
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Text Alignment', 'april-framework'),
			'param_name' => 'text_align',
			'description' => esc_html__('Select text alignment.', 'april-framework'),
			'value' => array(
				esc_html__('Left', 'april-framework') => 'text-left',
				esc_html__('Center', 'april-framework') => 'text-center',
				esc_html__('Right', 'april-framework') => 'text-right'
			),
			'std' => 'text-center',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
			'admin_label' => true,
		),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Letter Spacing', 'april-framework'),
            'param_name' => 'letter_spacing',
            'value' => array(
                '0' => '0',
                '100' => '0.1',
                '200' => '0.2',
                '300' => '0.3',
                '400' => '0.4',
                '500' => '0.5',
                '600' => '0.6',
                '700' => '0.7',
                '800' => '0.8',
                '900' => '0.9',
                '1000' => '1',
            ),
            'std' => '0',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __( 'Use theme default font family?', 'april-framework' ),
            'param_name' => 'use_theme_fonts',
            'std' => 'on',
            'description' => __( 'Use font family from the theme.', 'april-framework' ),
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'typography',
            'dependency' => array('element' => 'use_theme_fonts', 'value_not_equal_to' => 'on')
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);