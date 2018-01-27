<?php
return array(
	'name' => esc_html__( 'Video', 'april-framework' ),
	'base' => 'gsf_video',
	'icon' => 'fa fa-play-circle',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Link', 'april-framework' ),
			'param_name' => 'link',
			'value' => '',
			'description' => esc_html__( 'Enter link video', 'april-framework' ),
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Background Color', 'april-framework' ),
            'param_name' => 'icon_bg_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#f76b6a'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Color', 'april-framework' ),
            'param_name' => 'icon_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#fff'
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);