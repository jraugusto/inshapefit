<?php
return array(
	'base' => 'gsf_social_share',
	'name' => esc_html__( 'Social Share', 'april-framework' ),
	'icon' => 'fa fa-share',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
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
            'std' => 'circle-outline'
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);