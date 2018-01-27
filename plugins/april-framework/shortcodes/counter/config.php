<?php
return array(
	'base' => 'gsf_counter',
	'name' => esc_html__( 'Counter', 'april-framework' ),
	'icon' => 'fa fa-tachometer',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		G5P()->shortcode()->vc_map_add_title(array('admin_label' => true)),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Start Value', 'april-framework'),
			'param_name'       => 'start',
			'value'            => '',
			'std'              => '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('End Value', 'april-framework'),
			'param_name'       => 'end',
			'value'            => '',
			'std'              => '1000',
			'admin_label' => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimals', 'april-framework'),
			'param_name'       => 'decimals',
			'value'            => '',
			'std'              => '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Duration (s)', 'april-framework'),
			'param_name'       => 'duration',
			'value'            => '',
			'std'              => '2,5',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Separator', 'april-framework'),
			'param_name'       => 'separator',
			'value'            => '',
			'std'              => ',',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimal', 'april-framework'),
			'param_name'       => 'decimal',
			'value'            => '',
			'std'              => '.',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Prefix', 'april-framework'),
			'param_name'       => 'prefix',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Suffix', 'april-framework'),
			'param_name'       => 'suffix',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Value Color', 'april-framework'),
            'param_name' => 'value_color',
            'std' => '#f76b6a',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __( 'Use theme default font family for value?', 'april-framework' ),
            'param_name' => 'use_theme_fonts',
            'std' => 'on',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'description' => __( 'Use font family from the theme for counter value.', 'april-framework' ),
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