<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
return array(
	'base' => 'gsf_portfolios',
	'name' => esc_html__( 'Portfolios', 'april-framework' ),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-windows',
	'params' => array_merge(
		array(
			array(
				'param_name' => 'portfolio_layout',
				'heading' => esc_html__( 'Portfolio Layout', 'april-framework' ),
				'description' => esc_html__( 'Specify your portfolio layout', 'april-framework' ),
				'type' => 'gsf_image_set',
				'value' => array_merge(array(
                    'carousel' => array(
                        'label' => esc_html__('Slider', 'april-framework'),
                        'img'   => G5P()->pluginUrl('assets/images/shortcode/carousel.png')
                    ),
                ), G5P()->settings()->get_portfolio_layout()),
				'std' => 'grid',
				'admin_label' => true
			),
            array(
                'param_name' => "portfolio_item_skin",
                'heading' => esc_html__('Portfolio Item Skin','april-framework'),
                'type'     => 'gsf_image_set',
                'value'  => G5P()->settings()->get_portfolio_item_skin(),
                'std'  => 'portfolio-item-skin-02',
                'dependency' => array('element' => 'portfolio_layout', 'value' => array('grid', 'masonry', 'carousel')),
            ),
            array(
                'param_name'       => 'image_size',
                'heading'    => esc_html__('Image size', 'april-framework'),
                'description' => esc_html__('Enter your portfolio image size', 'april-framework'),
                'type'     => 'textfield',
                'std'  => 'medium',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'portfolio_layout', 'value_not_equal_to' => array('masonry', 'scattered'))
            ),
            array(
                'param_name'       => 'image_ratio',
                'heading'    => esc_html__('Image ratio', 'april-framework'),
                'description' => esc_html__('Specify your image portfolio ratio', 'april-framework'),
                'type'     => 'dropdown',
                'value'  => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_image_ratio()),
                'std'  => '1x1',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full')
            ),
            array(
                'param_name'       => 'image_ratio_custom_width',
                'heading'    => esc_html__('Image ratio custom width', 'april-framework'),
                'description' => esc_html__('Enter custom width for image ratio', 'april-framework'),
                'type'     => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name'       => 'image_ratio_custom_height',
                'heading'    => esc_html__('Image ratio custom height', 'april-framework'),
                'description' => esc_html__('Enter custom height for image ratio', 'april-framework'),
                'type'     => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name'       => 'image_masonry_width',
                'heading'    => esc_html__('Image masonry width', 'april-framework'),
                'type'     => 'gsf_number',
                'std'      => '400',
                'dependency' => array('element' => 'portfolio_layout', 'value' => 'masonry')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Show', 'april-framework'),
                'param_name' => 'show',
                'value' => array(
                    esc_html__('All', 'april-framework') => 'all',
                    esc_html__('Featured', 'april-framework') => 'featured',
                    esc_html__('Narrow Portfolios', 'april-framework') => 'portfolios'
                )
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__( 'Narrow Portfolios', 'april-framework' ),
                'param_name' => 'portfolio_ids',
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'unique_values' => true,
                ),
                'save_always' => true,
                'description' => esc_html__( 'Enter List of Portfolios', 'april-framework' ),
                'dependency' => array('element' => 'show', 'value' => 'portfolios')
            ),
            G5P()->shortCode()->vc_map_add_portfolio_narrow_categories(array(
                'dependency' => array('element' => 'show', 'value_not_equal_to' => array('portfolios'))
            )),
			array(
				'param_name' => 'portfolios_per_page',
				'heading' => esc_html__( 'Portfolios Per Page', 'april-framework' ),
				'description' => esc_html__( 'Enter number of portfolio per page you want to display. Default 10', 'april-framework' ),
				'type' => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => 10
			),
            array(
                'param_name' => 'portfolio_columns_gutter',
                'heading' => esc_html__( 'Portfolio Columns Gutter', 'april-framework' ),
                'description' => esc_html__( 'Specify your horizontal space between portfolio item.', 'april-framework' ),
                'type' => 'dropdown',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'value' => array(
                    esc_html__('None', 'april-framework') => 'none',
                    '10px' => '10',
                    '20px' => '20',
                    '30px' => '30',
                    '40px' => '40',
                    '50px' => '50'
                ),
                'std' => '30',
                'dependency' => array( 'element' => 'portfolio_layout', 'value_not_equal_to' => array( 'carousel-3d', 'scattered') )
            ),
			array(
				'param_name' => 'show_cate_filter',
				'heading' => esc_html__( 'Category Filter', 'april-framework' ),
				'type' => 'gsf_switch',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => ''
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
                'dependency' => array('element' => 'portfolio_layout','value' => array('carousel')),
                'group' => esc_html__('Slider Options','april-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            G5P()->shortcode()->vc_map_add_pagination(array(
                'dependency' => array('element' => 'portfolio_layout','value' => array('carousel', 'carousel-3d')),
                'group' => esc_html__('Slider Options', 'april-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
                'dependency' => array('element' => 'portfolio_layout','value' => array('carousel', 'carousel-3d')),
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
            G5P()->shortcode()->vc_map_add_navigation_position(array(
                'group' => esc_html__('Slider Options', 'april-framework')
            )),
            G5P()->shortcode()->vc_map_add_navigation_style(array(
                'group' => esc_html__('Slider Options', 'april-framework')
            )),
            G5P()->shortCode()->vc_map_add_autoplay_enable(array(
                'dependency' => array('element' => 'portfolio_layout','value' => array('carousel', 'carousel-3d')),
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
            G5P()->shortCode()->vc_map_add_autoplay_timeout(array(
                'group' => esc_html__('Slider Options', 'april-framework'),
            )),
			array(
				'param_name' => 'portfolio_paging',
				'heading' => esc_html__( 'Portfolio Paging', 'april-framework' ),
				'description' => esc_html__( 'Specify your portfolio paging mode', 'april-framework' ),
				'type' => 'dropdown',
				'value' => array(
					esc_html__('No Pagination', 'april-framework')=>'none',
					esc_html__('Pagination', 'april-framework') => 'pagination',
					esc_html__('Ajax - Pagination', 'april-framework') => 'pagination-ajax',
					esc_html__('Ajax - Next Prev', 'april-framework') => 'next-prev',
					esc_html__('Ajax - Load More', 'april-framework') => 'load-more',
					esc_html__('Ajax - Infinite Scroll', 'april-framework') => 'infinite-scroll'
				),
                'dependency' => array('element' => 'portfolio_layout','value_not_equal_to' => array('carousel', 'carousel-3d')),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => ''
			),
			array(
				'param_name' => 'portfolio_animation',
				'heading' => esc_html__( 'Animation', 'april-framework' ),
				'description' => esc_html__( 'Specify your portfolio animation', 'april-framework' ),
				'type' => 'dropdown',
				'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_animation(true) ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => '-1'
			),
            array(
                'param_name' => 'portfolio_hover_effect',
                'type'     => 'dropdown',
                'heading'    => esc_html__('Hover Effect', 'april-framework'),
                'value'  => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_portfolio_hover_effect(true) ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std'  => ''
            ),
            array(
                'param_name'       => 'portfolio_light_box',
                'type'     => 'dropdown',
                'heading'    => esc_html__('Light Box', 'april-framework'),
                'value'  => array(
                    esc_html__('Inherit', 'april-framework') => '',
                    esc_html__('Feature Image', 'april-framework') => 'feature',
                    esc_html__('Media Gallery', 'april-framework') => 'media'
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std'  => ''
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Order By', 'april-framework'),
                'param_name' => 'order_by',
                'value'      => array(
                    esc_html__('Date', 'april-framework') => 'date',
                    esc_html__('Portfolio Id', 'april-framework') => 'ID',
                    esc_html__('Portfolio Title', 'april-framework') => 'title'
                ),
                'default' => 'date',
                'dependency' => array('element' => 'show','value' => array('all')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Order', 'april-framework'),
                'param_name' => 'order',
                'value'      => array(
                    esc_html__('Ascending', 'april-framework') => 'ASC',
                    esc_html__('Descending', 'april-framework') => 'DESC'),
                'dependency' => array('element' => 'show','value' => array('all')),
                'default' => 'ASC',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )
        ),
        G5P()->shortCode()->get_column_responsive(array(
            'element'=>'portfolio_layout',
            'value'=>array('grid', 'masonry', 'carousel')
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