<?php
return array(
	'base' => 'gsf_banner',
	'name' => esc_html__( 'Banner', 'april-framework' ),
	'icon' => 'fa fa-image',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'april-framework'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/banner-01.jpg'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/banner-02.jpg'),
                ),
                'style-03' => array(
                    'label' => esc_html__('Style 03', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/banner-03.jpg'),
                ),
                'style-04' => array(
                    'label' => esc_html__('Custom Content', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/banner-04.jpg'),
                )
            ),
            'std' => 'style-01',
            'admin_label' => true,
        ),
		array(
			'param_name'        => 'hover_effect',
			'heading'     => esc_html__('Hover Effect', 'april-framework'),
			'type'      => 'dropdown',
			'std'      => '',
			'value' => array(
				esc_html__('None', 'april-framework') => '',
				esc_html__('Suprema', 'april-framework') => 'suprema-effect',
				esc_html__('Layla', 'april-framework') => 'layla-effect',
				esc_html__('Bubba', 'april-framework') => 'bubba-effect',
				esc_html__('Jazz', 'april-framework') => 'jazz-effect',
                esc_html__('Flash', 'april-framework') => 'flash-effect'
			)
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Background Image', 'april-framework'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'image'
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'Link (URL)', 'april-framework' ),
			'param_name' => 'link',
		),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__( 'Title Size', 'april-framework' ),
            'param_name' => 'title_size',
            'value' => array(
                esc_html__('Large', 'april-framework') => 'title-large',
                esc_html__('Medium', 'april-framework') => 'title-medium'
            ),
            'std' => 'title-medium',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'layout_style', 'value' => array('style-01'))
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text Color', 'april-framework' ),
            'param_name' => 'text_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#333',
            'dependency' => array('element' => 'layout_style', 'value' => array('style-02', 'style-03'))
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Text Background Color', 'april-framework' ),
            'param_name' => 'text_bg_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#fff',
            'dependency' => array('element' => 'layout_style', 'value' => array('style-02'))
        ),
        array(
            'type' => 'textarea_html',
            'heading' => esc_html__( 'Content Custom', 'april-framework' ),
            'param_name' => 'content',
            'dependency' => array('element' => 'layout_style', 'value' => array('style-04'))
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Height Mode', 'april-framework' ),
			'param_name' => 'height_mode',
            'value' => array(
                '1:1' => '100',
                esc_html__( 'Original', 'april-framework' )=> 'original',
                '4:3' => '133.333333333',
                '3:4' => '75',
                '16:9' => '177.777777778',
                '9:16' => '56.25',
                esc_html__( 'Custom', 'april-framework' )=> 'custom'
            ),
			'std' => 'original',
			'dependency' => array('element' => 'banner_bg_image', 'value_not_equal_to' => array('')),
			'description' => esc_html__( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'april-framework' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Height', 'april-framework' ),
			'param_name' => 'height',
			'std' => '340px',
			'dependency' => array('element' => 'height_mode', 'value' => 'custom'),
			'description' => esc_html__( 'Enter custom height (include unit)', 'april-framework' )
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);