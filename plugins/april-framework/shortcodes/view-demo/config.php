<?php
return array(
    'base'        => 'gsf_view_demo',
    'name'        => esc_html__('View Demo', 'april-framework'),
    'icon'        => 'fa fa-eye',
    'category' => G5P()->shortcode()->get_category_name(),
    'params'      => array_merge(
        array(
            array(
                'type' => 'gsf_image_set',
                'heading' => esc_html__('Layout Style', 'april-framework'),
                'param_name' => 'layout_style',
                'value' => array(
                    'style-01' => array(
                        'label' => esc_html__('Style 01', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/view-demo-01.png')
                    ),
                    'style-02' => array(
                        'label' => esc_html__('Style 02', 'april-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/view-demo-02.png')
                    )
                ),
                'std' => 'style-01',
                'admin_label' => true
            ),
            array(
                'type'       => 'param_group',
                'heading'    => esc_html__('Demo Items', 'april-framework'),
                'param_name' => 'demo_items',
                'params'     => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title demo', 'april-framework'),
                        'param_name'  => 'title',
                        'value'       => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'attach_image',
                        'heading'     => esc_html__('Images', 'april-framework'),
                        'param_name'  => 'image',
                        'value'       => ''
                    ),
                    array(
                        'type' => 'gsf_switch',
                        'heading' => esc_html__('Mark as Coming Soon', 'april-framework'),
                        'param_name' => 'is_coming_soon',
                        'std' => ''
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('URL (Link)', 'april-framework'),
                        'param_name' => 'link',
                        'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'on')
                    ),
                    array(
                        'type' => 'gsf_switch',
                        'heading' => esc_html__('Mark as New Item', 'april-framework'),
                        'param_name' => 'is_new',
                        'std' => '',
                        'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'on')
                    )
                ),
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
);
