<?php
return array(
	'base' => 'gsf_lists',
	'name' => esc_html__('Lists','april-framework'),
	'icon' => 'fa fa-list-ol',
    'category' => G5P()->shortcode()->get_category_name(),
	'params' =>	array(
	    array(
			'type' => 'dropdown',
			'heading' => esc_html__('Bullet Type', 'april-framework'),
			'param_name' => 'bullet_type',
			'value' => array(
				esc_html__('Number','april-framework') => 'list-number',
				esc_html__('Icon','april-framework') => 'list-icon',
				esc_html__('Dot','april-framework') => 'list-dot',
				esc_html__('Square','april-framework') => 'list-square',
			),
            'std' => 'list-number',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Bullet Style', 'april-framework'),
			'param_name' => 'bullet_style',
			'value' => array(
                esc_html__('Simple','april-framework') => 'list-simple',
                esc_html__('Square','april-framework') => 'list-square-outline',
                esc_html__('Circle','april-framework') => 'list-circle-outline',
            ),
			'std' => 'list-simple',
			'description' => esc_html__( 'Select lists design style.', 'april-framework' ),
			'admin_label' => true,
			'dependency'  => array('element' => 'bullet_type', 'value' => 'list-icon'),
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Bullet Color', 'april-framework' ),
            'param_name' => 'bullet_color',
            'std' => '#333',
            'description' => esc_html__( 'Select bullet color.', 'april-framework' )
        ),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Label Color', 'april-framework' ),
			'param_name' => 'label_color',
			'description' => esc_html__( 'Select Label color.', 'april-framework' ),
            'std' => '#696969'
		),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'dependency'  => array('element' => 'bullet_type', 'value' => 'list-icon')
        )),
		array(
			'type' => 'param_group',
			'heading' => esc_html__('Values','april-framework'),
			'param_name' => 'values',
			'description' => esc_html__('Enter values for list - icon and text','april-framework'),
			'value' => '',
			'params' => array(
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Label', 'april-framework' ),
					'param_name' => 'label',
					'admin_label' => true,
				),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Bullet Color', 'april-framework' ),
                    'param_name' => 'bullet_color',
                    'std' => '',
                    'description' => esc_html__( 'Set empty for default.', 'april-framework' )
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Label Color', 'april-framework' ),
                    'param_name' => 'label_color',
                    'description' => esc_html__( 'Set empty for default.', 'april-framework' ),
                    'std' => ''
                ),
                G5P()->shortcode()->vc_map_add_icon_font(),
			)
		),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);
