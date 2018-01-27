<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 15/11/2017
 * Time: 11:12 SA
 */

return array(
    'name' => esc_html__('Video with Background', 'april-framework'),
    'base' => 'gsf_video_with_background',
    'icon' => 'fa fa-youtube-play',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Video URL', 'april-framework' ),
            'param_name' => 'video_url',
            'value' => ''
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Custom Background', 'april-framework' ),
            'param_name' => 'image',
            'value' => '',
            'description' => esc_html__( 'Select an image from media library.', 'april-framework' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Height Mode', 'april-framework' ),
            'param_name' => 'height_mode',
            'value' => array(
                '1:1' => '100',
                '4:3' => '133.333333333',
                '3:4' => '75',
                '16:9' => '177.777777778',
                '9:16' => '56.25',
                esc_html__( 'Custom', 'april-framework' )=> 'custom'
            ),
            'std' => '56.25',
            'dependency' => array('element' => 'banner_bg_image', 'value_not_equal_to' => array('')),
            'description' => esc_html__( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'april-framework' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Height', 'april-framework' ),
            'param_name' => 'height',
            'std' => '400px',
            'dependency' => array('element' => 'height_mode', 'value' => 'custom'),
            'description' => esc_html__( 'Enter custom height (include unit)', 'april-framework' )
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Background Color', 'april-framework' ),
            'param_name' => 'icon_bg_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'image', 'value_not_equal_to' => array('')),
            'std' => '#f76b6a'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Color', 'april-framework' ),
            'param_name' => 'icon_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'image', 'value_not_equal_to' => array('')),
            'std' => '#fff'
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);