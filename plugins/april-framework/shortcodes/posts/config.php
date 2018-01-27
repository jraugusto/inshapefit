<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
return array(
	'base' => 'gsf_posts',
	'name' => esc_html__( 'Posts', 'april-framework' ),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-file-text',
	'params' => array_merge(
		array(
			array(
				'param_name' => 'post_layout',
				'heading' => esc_html__( 'Post Layout', 'april-framework' ),
				'description' => esc_html__( 'Specify your post layout', 'april-framework' ),
				'type' => 'gsf_image_set',
				'value' => G5P()->settings()->get_post_layout(),
				'std' => 'large-image',
				'admin_label' => true
			),
            array(
                'param_name' => "post_item_skin",
                'heading' => esc_html__('Post Item Skin','april-framework'),
                'type'     => 'gsf_image_set',
                'value'  => G5P()->settings()->get_post_item_skin(),
                'std'  => 'post-skin-01',
                'dependency' => array('element' => 'post_layout', 'value' => array('grid', 'masonry')),
            )
		),
		G5P()->shortcode()->get_post_filter(),
		array(
			array(
				'param_name' => 'posts_per_page',
				'heading' => esc_html__( 'Posts Per Page', 'april-framework' ),
				'description' => esc_html__( 'Enter number of posts per page you want to display. Default 10', 'april-framework' ),
				'type' => 'textfield',
				'std' => 10
			),
			array(
				'param_name' => 'show_cate_filter',
				'heading' => esc_html__( 'Category Filter', 'april-framework' ),
				'type' => 'gsf_switch',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => '0'
			),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Category Filter Alignment', 'april-framework'),
                'param_name' => 'cate_filter_align',
                'value' => array(
                    esc_html__('Left', 'april-framework') => 'cate-filter-left',
                    esc_html__('Center', 'april-framework') => 'cate-filter-center',
                    esc_html__('Right', 'april-framework') => 'cate-filter-right'
                ),
                'std' => 'cate-filter-left',
                'dependency' => array('element'=>'show_cate_filter', 'value'=> 'on'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
		),
		array(
			array(
				'param_name' => 'post_columns_gutter',
				'heading' => esc_html__( 'Post Columns Gutter', 'april-framework' ),
				'description' => esc_html__( 'Specify your horizontal space between post.', 'april-framework' ),
				'type' => 'dropdown',
				'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_post_columns_gutter() ),
				'std' => '30',
				'dependency' => array( 'element' => 'post_layout', 'value' => array( 'grid', 'masonry', 'mix-1', 'grid-2', 'tall-1', 'tall-2', 'tall-3', 'medium-image-2' ) )
			),

            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Is Slider?', 'april-framework' ),
                'param_name' => 'is_slider',
                'std' => '',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Carousel Rows', 'april-framework'),
                'param_name' => 'rows',
                'value' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ),
                'dependency' => array('element' => 'is_slider','value' => 'on'),
                'group' => esc_html__('Slider Options','april-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            G5P()->shortcode()->vc_map_add_pagination(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'april-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
            G5P()->shortcode()->vc_map_add_navigation_position(array(
                'group' => esc_html__('Slider Options', 'april-framework')
            )),
            G5P()->shortcode()->vc_map_add_navigation_style(array(
                'group' => esc_html__('Slider Options', 'april-framework')
            )),
            G5P()->shortCode()->vc_map_add_autoplay_enable(array(
                'dependency' => array('element' => 'is_slider', 'value' => 'on'),
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(array(
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
			array(
				'param_name' => 'post_paging',
				'heading' => esc_html__( 'Post Paging', 'april-framework' ),
				'description' => esc_html__( 'Specify your post paging mode', 'april-framework' ),
				'type' => 'dropdown',
				'value' => array(
					esc_html__('No Pagination', 'april-framework')=>'none',
					esc_html__('Pagination', 'april-framework') => 'pagination',
					esc_html__('Ajax - Pagination', 'april-framework') => 'pagination-ajax',
					esc_html__('Ajax - Next Prev', 'april-framework') => 'next-prev',
					esc_html__('Ajax - Load More', 'april-framework') => 'load-more',
					esc_html__('Ajax - Infinite Scroll', 'april-framework') => 'infinite-scroll'
				),
                'dependency' => array('element' => 'is_slider','value_not_equal_to' => array('on')),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => ''
			),
			array(
				'param_name' => 'post_animation',
				'heading' => esc_html__( 'Animation', 'april-framework' ),
				'description' => esc_html__( 'Specify your post animation', 'april-framework' ),
				'type' => 'dropdown',
				'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_animation(true) ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => '-1'
			),
        ),
        G5P()->shortCode()->get_column_responsive(array(
            'element'=>'layout_style',
            'value'=>array('grid')
        )),
        array(
			G5P()->shortcode()->vc_map_add_css_animation(),
			G5P()->shortcode()->vc_map_add_animation_duration(),
			G5P()->shortcode()->vc_map_add_animation_delay(),
			G5P()->shortcode()->vc_map_add_extra_class(),
			G5P()->shortcode()->vc_map_add_css_editor(),
			G5P()->shortcode()->vc_map_add_responsive()
		)
	)
);