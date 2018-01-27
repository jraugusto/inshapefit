<?php
return array(
	'base'        => 'gsf_partner_carousel',
	'name'        => esc_html__('Partner Carousel', 'april-framework'),
	'icon'        => 'fa fa-user-plus',
	'category'    => G5P()->shortcode()->get_category_name(),
	'params'      =>array(
		array(
            'type'       => 'param_group',
            'heading'    => esc_html__('Partner Info', 'april-framework'),
            'param_name' => 'partners',
            'params'     => array(
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Images', 'april-framework'),
                    'param_name'  => 'image',
                    'value'       => '',
                    'description' => esc_html__('Select images from media library.', 'april-framework')
                ),
                array(
                    'type'       => 'vc_link',
                    'heading'    => esc_html__('Link (url)', 'april-framework'),
                    'param_name' => 'link',
                    'value'      => '',
                ),
            ),
        ),
		array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Items', 'april-framework'),
            'param_name'       => 'items',
            'value'            => array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'              => 5,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'admin_label' => true,
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Columns Gutter', 'april-framework'),
            'param_name'       => 'columns_gutter',
            'value'            => array(
                '30px' => '30',
                '20px' => '20',
                '10px' => '10',
                esc_html__('None', 'april-framework') => '0',
            ),
            'std'              => '30',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
		array(
            'type'             => 'gsf_slider',
            'heading'          => esc_html__('Images opacity', 'april-framework'),
            'param_name'       => 'opacity',
            'args' => array(
                'min'   => 1,
                'max'   => 100,
                'step'  => 1
            ),
            'std' => 100,
            'description' => esc_html__('Select opacity for images at first.', 'april-framework'),
            'admin_label' => true,
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Tablet landscape', 'april-framework'),
            'param_name'  => 'items_md',
            'description' => esc_html__('Browser Width >= 992px and < 1200px', 'april-framework'),
            'value'       => array(esc_html__('Default', 'april-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'april-framework')
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Tablet portrait', 'april-framework'),
            'param_name'  => 'items_sm',
            'description' => esc_html__('Browser Width >= 768px and < 991px', 'april-framework'),
            'value'       => array(esc_html__('Default', 'april-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'april-framework')
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Mobile landscape', 'april-framework'),
            'param_name'  => 'items_xs',
            'description' => esc_html__('Browser Width >= 600px and < 768px', 'april-framework'),
            'value'       => array(esc_html__('Default', 'april-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'april-framework')
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Mobile portrait', 'april-framework'),
            'param_name'  => 'items_mb',
            'description' => esc_html__('Browser Width < 600px', 'april-framework'),
            'value'       => array(esc_html__('Default', 'april-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'april-framework')
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);

