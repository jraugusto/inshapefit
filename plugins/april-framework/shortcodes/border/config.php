<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
return array(
	'base' => 'gsf_border',
	'name' => esc_html__('Border', 'april-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-window-minimize',
	'params' => array(
		array(
			'type' => 'gsf_switch',
			'heading' => __( 'Use skin border color?', 'april-framework' ),
			'param_name' => 'use_skin_border_color',
            'std' => 'on'
		),
		array(
			'type' => 'colorpicker',
            'heading' => __( 'Border color', 'april-framework' ),
			'param_name' => 'border_color',
            'dependency' => array('element' => 'use_skin_border_color', 'value_not_equal_to' => 'on')
		),
		array(
		    'type' => 'gsf_number',
            'heading' => __( 'Border height', 'april-framework' ),
            'param_name' => 'border_height',
            'std' => 1,
            'admin_label' => true
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);