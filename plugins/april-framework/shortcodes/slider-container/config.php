<?php
return array(
	'name' => esc_html__('Slider Container', 'april-framework'),
	'base' => 'gsf_slider_container',
	'icon' => 'fa fa-ellipsis-h',
	'category' => G5P()->shortcode()->get_category_name(),
	'as_parent' => array('except' => 'gsf_slider_container'),
	'content_element' => true,
	'show_settings_on_create' => true,
	'params' => array_merge(
	    array(
            G5P()->shortcode()->vc_map_add_pagination(array(
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation_position(),
            G5P()->shortcode()->vc_map_add_navigation_style(),
            G5P()->shortCode()->vc_map_add_autoplay_enable(),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Margin', 'april-framework' ),
                'param_name' => 'margin',
                'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_post_columns_gutter()),
                'std' => '30',
                'description' => esc_html__( 'Margin-right(px) on item.', 'april-framework' ),
            )
        ),
        G5P()->shortCode()->get_column_responsive(),
		array(
            G5P()->shortcode()->vc_map_add_css_animation(),
            G5P()->shortcode()->vc_map_add_animation_duration(),
            G5P()->shortcode()->vc_map_add_animation_delay(),
            G5P()->shortcode()->vc_map_add_extra_class(),
            G5P()->shortcode()->vc_map_add_css_editor(),
            G5P()->shortcode()->vc_map_add_responsive()
        )
	),
    "js_view" => 'VcColumnView'
);