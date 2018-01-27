<?php
return array(
	'base' => 'gsf_icon_box',
	'name' => esc_html__('Icon Box','april-framework'),
	'icon' => 'fa fa-diamond',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Layout Style', 'april-framework'),
			'param_name' => 'layout_style',
			'value' => array(
				esc_html__('Icon top - Alignment center','april-framework') => 'text-center',
				esc_html__('Icon top - Alignment left','april-framework') => 'text-left',
				esc_html__('Icon left - Text right','april-framework') => 'ib-left',
				esc_html__('Icon right - Text left','april-framework') => 'ib-right',
				esc_html__('Icon left - Icon inline Title','april-framework') => 'ib-left-inline',
				esc_html__('Icon right - Icon inline Title','april-framework') => 'ib-right-inline'
			),
			'std' => 'text-center',
			'admin_label' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'april-framework' ),
			'param_name' => 'title',
			'value' => '',
			'admin_label' => true,
		),
        array(
            'type' => 'gsf_number',
            'heading' => esc_html__('Title font size', 'april-framework'),
            'param_name' => 'title_font_size',
            'std' => 24
        ),
		array(
			'type' => 'textarea',
			'heading' => esc_html__('Description', 'april-framework'),
			'param_name' => 'description',
			'value' => '',
			'description' => esc_html__('Provide the description for this element.', 'april-framework')
		),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Description Letter Spacing', 'april-framework'),
            'param_name' => 'des_letter_spacing',
            'value' => array(
                esc_html__('Large', 'april-framework') => '0.2',
                esc_html__('Medium', 'april-framework') => '0.1',
                esc_html__('None', 'april-framework') => '0',
            ),
            'std' => '0.2',
            'description' => esc_html__('Provide the description for this element.', 'april-framework')
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __( 'Use theme default font family?', 'april-framework' ),
            'param_name' => 'use_theme_fonts',
            'std' => 'on',
            'description' => __( 'Use font family from the theme.', 'april-framework' ),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'typography',
            'dependency' => array('element' => 'use_theme_fonts', 'value_not_equal_to' => 'on')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Background Style', 'april-framework'),
            'param_name' => 'icon_bg_style',
            'value' => array(
                esc_html__('Classic', 'april-framework') => 'iconbox-classic',
                esc_html__('Circle - Fill Color', 'april-framework') => 'iconbox-bg-circle-fill',
                esc_html__('Circle - Outline', 'april-framework') => 'iconbox-bg-circle-outline',
                esc_html__('Square - Fill Color', 'april-framework') => 'iconbox-bg-square-fill',
                esc_html__('Square - Outline', 'april-framework') => 'iconbox-bg-square-outline'
            ),
            'std' => 'iconbox-classic',
            'group' => esc_html__('Icon Options', 'april-framework'),
            'description' => esc_html__('Select Icon Background Style.', 'april-framework'),
            'dependency' => array('element'=>'layout_style', 'value'=>array('text-left', 'text-center', 'ib-left','ib-right'))
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Type', 'april-framework'),
            'param_name' => 'icon_type',
            'value' => array(
                esc_html__('Icon', 'april-framework') => 'icon',
                esc_html__('Image', 'april-framework') => 'image',
            ),
            'std' => 'icon'
        ),
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__('Images', 'april-framework'),
            'param_name'  => 'image',
            'value'       => '',
            'description' => esc_html__('Select images from media library.', 'april-framework'),
            'dependency' => array('element' => 'icon_type', 'value' => 'image')
        ),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'group' => esc_html__('Icon Options', 'april-framework'),
            'dependency' => array('element' => 'icon_type', 'value' => 'icon')
        )),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'april-framework'),
            'param_name' => 'icon_color',
            'std' => '#e0e0e0',
            'group' => esc_html__('Icon Options', 'april-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_font', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background Color', 'april-framework'),
            'param_name' => 'icon_bg_color',
            'std' => '#333',
            'group' => esc_html__('Icon Options', 'april-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element'=>'icon_bg_style', 'value_not_equal_to'=>'iconbox-classic')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Hover Style', 'april-framework'),
            'param_name' => 'icon_hover_style',
            'value' => array(
                esc_html__('Change Border and Color', 'april-framework') => '',
                esc_html__('Change Background and Color', 'april-framework') => 'hover-change-background-color'
            ),
            'std' => '',
            'group' => esc_html__('Icon Options', 'april-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element'=>'icon_bg_style', 'value_not_equal_to' => array('iconbox-classic'))
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Size', 'april-framework'),
            'param_name' => 'icon_size',
            'value' => array(
                esc_html__('Large', 'april-framework') => 'ib-large',
                esc_html__('Medium', 'april-framework') => 'ib-medium',
                esc_html__('Small', 'april-framework') => 'ib-small'
            ),
            'std' => 'ib-large',
            'group' => esc_html__('Icon Options', 'april-framework'),
            'description' => esc_html__('Select Color Scheme.', 'april-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Vertical Alignment', 'april-framework'),
            'param_name' => 'icon_align',
            'value' => array(
                esc_html__('Top', 'april-framework') => 'iconbox-align-top',
                esc_html__('Middle', 'april-framework') => 'iconbox-align-middle'
            ),
            'std' => 'iconbox-align-top',
            'group' => esc_html__('Icon Options', 'april-framework'),
            'description' => esc_html__('Select Icon Vertical Alignment.', 'april-framework'),
            'dependency' => array('element'=>'layout_style', 'value'=>array('ib-left','ib-right')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__('Link (url)', 'april-framework'),
			'param_name' => 'link',
			'value' => '',
		),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);