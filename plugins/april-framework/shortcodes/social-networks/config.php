<?php
return array(
	'base' => 'gsf_social_networks',
	'name' => esc_html__( 'Social Networks', 'april-framework' ),
	'icon' => 'fa fa-share-alt',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'param_name' => 'social_networks',
			'heading' => esc_html__('Social Networks', 'april-framework'),
			'type' => 'gsf_selectize',
			'multiple' => true,
			'drag' => true,
			'description' => esc_html__('Select Social Networks', 'april-framework'),
			'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_social_networks())
		),
		array(
			'param_name' => 'social_shape',
			'heading' => esc_html__('Social Shape', 'april-framework'),
			'type' => 'dropdown',
			'value' => array(
				esc_html__( 'Classic', 'april-framework' ) => 'classic',
				esc_html__( 'Circle Fill', 'april-framework' ) => 'circle',
                esc_html__( 'Circle Outline', 'april-framework' ) => 'circle-outline',
                esc_html__( 'Square', 'april-framework' ) => 'square',
			),
			'std' => 'classic'
		),
        array(
            'param_name' => 'social_size',
            'heading' => esc_html__('Social Size', 'april-framework'),
            'type' => 'dropdown',
            'value' => array(
                esc_html__( 'Small', 'april-framework' ) => 'small',
                esc_html__( 'Normal', 'april-framework' ) => 'normal',
                esc_html__( 'Large', 'april-framework' ) => 'large'
            ),
            'std' => 'normal'
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);