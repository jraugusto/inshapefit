<?php
return array(
	'base' => 'gsf_portfolio_meta',
	'name' => esc_html__( 'Portfolio Meta', 'april-framework' ),
	'icon' => 'fa fa-info-circle',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Meta Title', 'april-framework'),
			'param_name' => 'title',
			'admin_label' => true,
		),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Include share?', 'april-framework'),
            'param_name' => 'include_share',
            'std' => ''
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);