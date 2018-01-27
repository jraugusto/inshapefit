<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
return array(
	'base' => 'gsf_page_title',
	'name' => esc_html__('Page Title', 'april-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-pinterest-p',
	'params' => array(
		array(
			'type' => 'font_container',
			'param_name' => 'font_container',
			'value' => 'text_align:left|font_size:80|color:#333333',
			'settings' => array(
				'fields' => array(
					'text_align' =>'left',
					'font_size' => '80px',
					'color' => '#333333',
					'text_align_description' => __( 'Select text alignment.', 'april-framework' ),
					'font_size_description' => __( 'Enter font size.', 'april-framework' ),
					'color_description' => __( 'Select heading color.', 'april-framework' ),
				),
			),
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
	)
);