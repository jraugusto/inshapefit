<?php
return array(
    'name'     => esc_html__('Google Map', 'april-framework'),
    'base'     => 'gsf_google_map',
    'icon'     => 'fa fa-map-marker',
    'category' => G5P()->shortcode()->get_category_name(),
    'params'   => array(
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__('Markers', 'april-framework'),
            'param_name' => 'markers',
            'value'      => urlencode(json_encode(array(
                array(
                    'label' => esc_html__('Title', 'april-framework'),
                    'value' => '',
                ),
            ))),
            'params'     => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Latitude ', 'april-framework'),
                    'param_name'  => 'lat',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Longitude ', 'april-framework'),
                    'param_name'  => 'lng',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Title', 'april-framework'),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'       => 'textarea',
                    'heading'    => esc_html__('Description', 'april-framework'),
                    'param_name' => 'description',
                    'value'      => ''
                ),
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Marker Icon', 'april-framework'),
                    'param_name'  => 'icon',
                    'value'       => '',
                    'description' => esc_html__('Select an image from media library.', 'april-framework'),
                ),
            ),
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('API Key', 'april-framework'),
            'param_name' => 'api_key',
            'std'        => 'AIzaSyAwey_47Cen4qJOjwHQ_sK1igwKPd74J18',
        ),
        array(
            'type'             => 'textfield',
            'heading'          => esc_html__('Map height (px or %)', 'april-framework'),
            'param_name'       => 'map_height',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => '500px',
        ),
        array(
            'type'             => 'gsf_number',
            'heading'          => esc_html__('Map zoom level default', 'april-framework'),
            'param_name'       => 'map_zoom',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'args' => array(
                'min' => 0,
                'max' => 18,
                'step' => 1
            ),
            'std' => 15
        ),
        array(
            'type'             => 'gsf_switch',
            'heading'          => esc_html__('Zoom on scroll', 'april-framework'),
            'param_name'       => 'scroll_wheel',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => ''
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Map Style', 'april-framework'),
            'param_name' => 'map_style',
            'std' => 'light',
            'value' => array(
                esc_html__('Standar', 'april-framework') => 'standar',
                esc_html__('Light (Default)', 'april-framework') => 'light',
                esc_html__('Dark', 'april-framework') => 'dark',
                esc_html__('Sliver', 'april-framework') => 'sliver',
                esc_html__('Retro', 'april-framework') => 'retro',
                esc_html__('Night', 'april-framework') => 'night',
                esc_html__('Aubergine', 'april-framework') => 'aubergine',
                esc_html__('Custom', 'april-framework') => 'custom'
            ),
            'admin_label'      => true,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type'             => 'textarea_raw_html',
            'heading'          => esc_html__('Custom map style', 'april-framework'),
            'param_name'       => 'map_style_content',
            'dependency' => array('element' => 'map_style', 'value' => 'custom'),
            'description' => wp_kses_post(__('Come <a target="_blank" href="https://snazzymaps.com/">here</a> to search map style code!', 'april-framework'))
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    ),
);