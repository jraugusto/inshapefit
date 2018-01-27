<?php
return array(
	'base'     => 'gsf_our_team',
	'name'     => esc_html__('Our Team', 'april-framework'),
	'icon'     => 'fa fa-users',
	'category' => G5P()->shortcode()->get_category_name(),
	'params'   => array(
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Thumbnail Shape', 'april-framework'),
            'param_name' => 'thumb_shape',
            'value'      => array(
                esc_html__('Square', 'april-framework') => 'thumb-square',
                esc_html__('Circle', 'april-framework') => 'thumb-circle'
            ),
            'std' => 'thumb-square'
        ),
        array(
            'type'       => 'attach_image',
            'heading'    => esc_html__('Image:', 'april-framework'),
            'param_name' => 'image',
            'value'      => '',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Name', 'april-framework'),
            'param_name'  => 'ourteam_name',
            'admin_label' => true,
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Position', 'april-framework'),
            'param_name' => 'ourteam_position',
            'value'      => ''
        ),
        array(
            'type'       => 'vc_link',
            'heading'    => esc_html__('Link (url)', 'april-framework'),
            'param_name' => 'link',
            'value'      => '',
        ),
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__('Social', 'april-framework'),
            'param_name' => 'socials',
            'params'     => array(
                G5P()->shortcode()->vc_map_add_icon_font(array(
                    'admin_label' => true
                )),
                array(
                    'type'       => 'vc_link',
                    'heading'    => esc_html__('Link (url)', 'april-framework'),
                    'param_name' => 'social_link',
                    'value'      => '',
                )
            )
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);
