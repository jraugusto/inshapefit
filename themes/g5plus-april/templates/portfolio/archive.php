<?php
global $wp_query;
$post_settings = &g5Theme()->blog()->get_layout_settings();
$post_layout = isset($post_settings['post_layout']) ? $post_settings['post_layout'] : 'large-image';
$portfolio_item_skin = isset($post_settings['portfolio_item_skin']) ? $post_settings['portfolio_item_skin'] : 'portfolio-item-skin-02';
if(!in_array($post_layout, array('grid', 'masonry'))) {
    $portfolio_item_skin = 'portfolio-item-skin-02';
}
$post_animation = isset($post_settings['post_animation']) ? $post_settings['post_animation'] : '';
$post_paging = isset($post_settings['post_paging']) ? $post_settings['post_paging'] : 'pagination';
$layout_matrix = g5Theme()->blog()->get_layout_matrix($post_layout);
$placeholder_enable = isset($layout_matrix['placeholder_enable']) ? $layout_matrix['placeholder_enable'] : true;
$image_size = isset($post_settings['image_size']) ? $post_settings['image_size'] :  g5Theme()->options()->get_portfolio_image_size();
$image_size_base = $image_size;
$image_ratio = '';
if (in_array($post_layout, array('grid','metro-1','metro-2','metro-3','metro-4','metro-5')) && ($image_size === 'full')) {
    $image_ratio = isset($post_settings['image_ratio']) ? $post_settings['image_ratio'] : '';
    if (empty($image_ratio)) {
        $image_ratio = g5Theme()->options()->get_portfolio_image_ratio();
    }

    if ($image_ratio === 'custom') {
        $image_ratio_custom = isset($post_settings['image_ratio_custom']) ? $post_settings['image_ratio_custom'] : g5Theme()->options()->get_portfolio_image_ratio_custom();
        if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
            $image_ratio_custom_width = intval($image_ratio_custom['width']);
            $image_ratio_custom_height = intval($image_ratio_custom['height']);
            if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
                $image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
            }
        } elseif (preg_match('/x/',$image_ratio_custom)) {
            $image_ratio = $image_ratio_custom;
        }
    }

    if ($image_ratio === 'custom') {
        $image_ratio = '1x1';
    }
}

$image_ratio_base = $image_ratio;

if ($post_layout === 'masonry') {
	$image_width = isset($post_settings['image_width']) ? $post_settings['image_width'] :  g5Theme()->options()->get_portfolio_image_width();
	if (is_array($image_width) && isset($image_width['width'])) {
		$image_width = intval($image_width['width']);
	} else {
		$image_width = 400;
	}
	
	if ($image_width <= 0) {
		$image_width = 400;
	}
	$image_size = "{$image_width}x0";
}
$hover_effect = isset($post_settings['portfolio_hover_effect']) ? $post_settings['portfolio_hover_effect'] : g5Theme()->options()->get_portfolio_hover_effect();
$portfolio_light_box = isset($post_settings['portfolio_light_box']) ? $post_settings['portfolio_light_box'] : g5Theme()->options()->get_portfolio_light_box();
$wrapper_attributes = array();
$inner_attributes = array();
$inner_classes = array(
    'gf-blog-inner',
    'clearfix',
    "layout-{$post_layout}",
    $portfolio_item_skin
);

$post_inner_classes = array(
    'portfolio-item-inner',
    'clearfix',
    g5Theme()->helper()->getCSSAnimation($post_animation),
    "gsf-hover-{$hover_effect}"
);

$post_classes = array(
    'clearfix',
    'portfolio-default',
    $portfolio_item_skin
);

if (isset($post_settings['carousel'])) {
    $inner_classes[] = 'owl-carousel owl-theme';
    if (isset($post_settings['carousel_class'])) {
        $inner_classes[] = $post_settings['carousel_class'];
    }
    $inner_attributes[] = "data-owl-options='" . json_encode($post_settings['carousel']) . "'";
} else {
    if (isset($layout_matrix['columns_gutter'])) {
        $inner_classes[] = "gf-gutter-{$layout_matrix['columns_gutter']}";
    }

    if (isset($layout_matrix['carousel'])) {
        $inner_classes[] = 'owl-carousel owl-theme';
        if (isset($layout_matrix['carousel_class'])) {
            $inner_classes[] = $layout_matrix['carousel_class'];
        }
        $inner_attributes[] = "data-owl-options='" . json_encode($layout_matrix['carousel']) . "'";
    }

    if (isset($layout_matrix['isotope'])) {
        $inner_classes[] = 'isotope';
        $inner_attributes[] = "data-isotope-options='" . json_encode($layout_matrix['isotope']) . "'";
        $wrapper_attributes[] = 'data-isotope-wrapper="true"';

        if (isset($layout_matrix['isotope']['metro'])) {
            if ($image_size_base === 'full') {
                $inner_attributes[] = "data-image-size-base='" . $image_ratio_base . "'";
            } else {
                $image_size_base_dimension =  g5Theme()->helper()->get_image_dimension($image_size_base);
                if ($image_size_base_dimension) {
                    $inner_attributes[] = "data-image-size-base='" . $image_size_base_dimension['width'] . 'x' . $image_size_base_dimension['height'] . "'";
                }
            }
        }
    }
}

$wrapper_attributes[] = 'data-items-wrapper';
$inner_attributes[] = 'data-items-container="true"';

$paged = $wp_query->get('page') ? intval($wp_query->get('page')) : $wp_query->get('paged') ? intval($wp_query->get('paged')) : 1;
$inner_class = implode(' ', array_filter($inner_classes));
$post_inner_class = implode(' ', array_filter($post_inner_classes));
?>
<div <?php echo implode(' ', $wrapper_attributes); ?> class="gf-portfolio-wrap clearfix">
    <?php
    // You can use this for adding codes before the main loop
    do_action('g5plus_before_archive_wrapper');
    ?>
    <div <?php echo implode(' ', $inner_attributes); ?> class="<?php echo esc_attr($inner_class); ?>">
        <?php
            if (have_posts()) {
                if (isset($layout_matrix['layout'])) {
                    $layout_settings = $layout_matrix['layout'];
                    $index = intval($wp_query->get('index', 0));
                    $carousel_index = 0;
                    while (have_posts()) : the_post();
                        $index = $index % sizeof($layout_settings);
                        $current_layout = $layout_settings[$index];
                        $isFirst = isset($current_layout['isFirst']) ? $current_layout['isFirst'] : false;
                        if ($isFirst && ($paged > 1) && in_array($post_paging, array('load-more', 'infinite-scroll'))) {
                            if (isset($layout_settings[$index + 1])) {
                                $current_layout = $layout_settings[$index + 1];
                            } else {
                                continue;
                            }
                        }

                        $template = $current_layout['template'];
                        $classes = array(
                            "portfolio-{$template}"
                        );

                        if(isset($post_settings['carousel_rows']) && $carousel_index == 0) {
                            echo '<div class="carousel-item clearfix">';
                        }
                        if ((!isset($post_settings['carousel']) && isset($current_layout['columns'])) || isset($post_settings['carousel_rows'])) {
                            $classes[] = $current_layout['columns'];
                        }

                        $image_size = isset($current_layout['image_size'])  ? $current_layout['image_size'] : $image_size;
                        $post_attributes = array();
                        $post_inner_attributes = array();

                        if (isset($current_layout['layout_ratio'])) {
                            $layout_ratio = isset($current_layout['layout_ratio']) ? $current_layout['layout_ratio'] : '1x1';
                            if ($image_size_base !== 'full') {
                                $image_size = g5Theme()->helper()->get_metro_image_size($image_size_base,$layout_ratio,$layout_matrix['columns_gutter']);
                            } else {
                                $image_ratio =  g5Theme()->helper()->get_metro_image_ratio($image_ratio_base,$layout_ratio);
                            }
                            $post_inner_attributes[] = 'data-ratio="'. $layout_ratio .'"';
                        }

                        $classes = wp_parse_args($classes, $post_classes);
                        $post_class = implode(' ', array_filter($classes));

                        g5Theme()->helper()->getTemplate("portfolio/layout/{$template}", array(
                            'post_inner_attributes' => $post_inner_attributes,
                            'post_attributes' => $post_attributes,
                            'image_size' => $image_size,
                            'post_class' => $post_class,
                            'post_inner_class' => $post_inner_class,
                            'placeholder_enable' => $placeholder_enable,
                            'image_ratio' => $image_ratio,
                            'portfolio_light_box' => $portfolio_light_box,
                            'portfolio_item_skin' => $portfolio_item_skin
                        ));

                        if ($isFirst) {
                            unset($layout_settings[$index]);
                            $layout_settings = array_values($layout_settings);
                        }

                        if ($isFirst && $paged === 1) {
                            $index = 0;
                        } else {
                            $index++;
                        }
                        $carousel_index++;
                        if(isset($post_settings['carousel_rows']) && $carousel_index == $post_settings['carousel_rows']['items_show']) {
                            echo '</div>';
                            $carousel_index = 0;
                        }
                    endwhile;
                    if(isset($post_settings['carousel_rows']) && $carousel_index != $post_settings['carousel_rows']['items_show'] && $carousel_index != 0) {
                        echo '</div>';
                    }
                }

            } else if (isset($post_settings['isMainQuery'])) {
                g5Theme()->helper()->getTemplate('loop/content-none');
            }
        ?>
    </div>
    <?php
    // You can use this for adding codes before the main loop
    do_action('g5plus_after_archive_wrapper');
    ?>
</div>