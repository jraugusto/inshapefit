<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
return array(
	'base' => 'gsf_button',
	'name' => esc_html__('Button', 'april-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'description' => esc_html__('Eye catching button', 'april-framework'),
	'icon'        => 'fa fa-bold',
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Text', 'april-framework'),
			'param_name' => 'title',
			'value' => esc_html__('Text on the button', 'april-framework'),
			'admin_label' => true,
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__('URL (Link)', 'april-framework'),
			'param_name' => 'link',
			'description' => esc_html__('Add link to button.', 'april-framework'),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'april-framework'),
			'description' => esc_html__('Select button display style.', 'april-framework'),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Classic', 'april-framework') => 'classic',
				esc_html__('Outline', 'april-framework') => 'outline',
				esc_html__('3D', 'april-framework') => '3d',
                esc_html__('Link', 'april-framework') => 'link'
			),
			'std' => 'classic',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Shape', 'april-framework'),
			'description' => esc_html__('Select button shape.', 'april-framework'),
			'param_name' => 'shape',
			'value' => array(
				esc_html__('Rounded', 'april-framework') => 'rounded',
				esc_html__('Square', 'april-framework') => 'square',
				esc_html__('Round', 'april-framework') => 'round',
			),
            'dependency' => array(
                'element' => 'style',
                'value_not_equal_to' => array('link'),
            ),
			'std' => 'rounded',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Color', 'april-framework'),
			'param_name' => 'color',
			'description' => esc_html__('Select button color.', 'april-framework'),
			'value' => array(
				esc_html__('Primary', 'april-framework') => 'primary',
				esc_html__('Gray', 'april-framework') => 'gray',
				esc_html__('Black', 'april-framework') => 'black',
				esc_html__('White', 'april-framework') => 'white',
				esc_html__('Red', 'april-framework') => 'red',
			),
			'std' => 'primary',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Size', 'april-framework'),
			'param_name' => 'size',
			'description' => esc_html__('Select button display size.', 'april-framework'),
			'std' => 'sm',
			'value' => array(
				esc_html__('Mini', 'april-framework') => 'xs', // height 35px
				esc_html__('Small', 'april-framework') => 'sm', // height 40px - default
				esc_html__('Normal', 'april-framework') => 'md', // height 48px
				esc_html__('Large', 'april-framework') => 'lg', // height 54px
				esc_html__('Extra Large', 'april-framework') => 'xl', // height 56px
				esc_html__('Extra Extra Large', 'april-framework') => 'xxl', // height 60px
			),
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Alignment', 'april-framework'),
			'param_name' => 'align',
			'description' => esc_html__('Select button alignment.', 'april-framework'),
			'value' => array(
				esc_html__('Inline', 'april-framework') => 'inline',
				esc_html__('Left', 'april-framework') => 'left',
				esc_html__('Right', 'april-framework') => 'right',
				esc_html__('Center', 'april-framework') => 'center',
			),
			'std' => 'inline',
			'admin_label' => true,
		),
		array(
			'type' => 'gsf_switch',
			'heading' => esc_html__('Set full width button?', 'april-framework'),
			'param_name' => 'button_block',
			'std' => '',
			'dependency' => array(
				'element' => 'align',
				'value_not_equal_to' => 'inline',
			),
			'admin_label' => true,
		),

        G5P()->shortcode()->vc_map_add_icon_font(),
		array(
			'type' => 'gsf_button_set',
			'heading' => esc_html__('Icon Alignment', 'april-framework'),
			'description' => esc_html__('Select icon alignment.', 'april-framework'),
			'param_name' => 'icon_align',
			'value' => array(
				esc_html__('Left', 'april-framework') => 'left',
				esc_html__('Right', 'april-framework') => 'right',
			),
			'dependency' => array(
				'element' => 'icon_font',
				'value_not_equal_to' => array(''),
			),
		),
		array(
			'type' => 'gsf_switch',
			'heading' => esc_html__('Advanced on click action', 'april-framework'),
			'param_name' => 'custom_onclick',
			'std' => '',
			'description' => esc_html__('Insert inline onclick javascript action.', 'april-framework'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('On click code', 'april-framework'),
			'param_name' => 'custom_onclick_code',
			'description' => esc_html__('Enter onclick action code.', 'april-framework'),
			'dependency' => array(
				'element' => 'custom_onclick',
				'value' => 'on',
			),
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);