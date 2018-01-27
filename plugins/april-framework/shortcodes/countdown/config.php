<?php
/**
 * Created by PhpStorm.
 * User: Kaga
 * Date: 20/5/2016
 * Time: 3:57 PM
 */
return array(
	'name'        => esc_html__('Countdown', 'april-framework'),
	'base'        => 'gsf_countdown',
	'class'       => '',
	'icon'        => 'fa fa-clock-o',
    'category' => G5P()->shortcode()->get_category_name(),
	'params'      => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'april-framework'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/countdown-01.png'),
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'april-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/countdown-02.png'),
                )
            ),
            'std' => 'style-01',
            'admin_label' => true,
        ),
		array(
			'type'       => 'gsf_datetimepicker',
			'heading'    => esc_html__('Time Off', 'april-framework'),
			'param_name' => 'time',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__('Url Redirect', 'april-framework'),
			'param_name' => 'url_redirect',
			'value'      => '',
		),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);