<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
return array(
	'base' => 'gsf_products_index',
	'name' => esc_html__('Products Index', 'april-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-product-hunt',
	'params' => array(
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose product to show', 'april-framework' ),
			'param_name' => 'product_ids',
            'settings' => array(
                'multiple' => true,
                'unique_values' => true,
                'display_inline' => true
            ),
            'save_always' => true,
		),
        array(
            'param_name' => 'product_animation',
            'heading' => esc_html__( 'Product Animation', 'april-framework' ),
            'description' => esc_html__( 'Specify your product animation', 'april-framework' ),
            'type' => 'dropdown',
            'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_animation(true) ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => ''
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);