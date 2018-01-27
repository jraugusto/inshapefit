<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/20/2017
 * Time: 10:00 AM
 */

$layout = g5Theme()->options()->get_single_portfolio_gallery_layout();

$image_size = g5Theme()->options()->get_single_portfolio_gallery_image_size();
$image_ratio = g5Theme()->options()->get_single_portfolio_gallery_image_ratio();
$image_ratio_custom = g5Theme()->options()->get_single_portfolio_gallery_image_ratio_custom();

$columns_gutter = intval(g5Theme()->options()->get_single_portfolio_gallery_columns_gutter());
$columns = intval(g5Theme()->options()->get_single_portfolio_gallery_columns());
$columns_md = intval(g5Theme()->options()->get_single_portfolio_gallery_columns_md());
$columns_sm = intval(g5Theme()->options()->get_single_portfolio_gallery_columns_sm());
$columns_xs = intval(g5Theme()->options()->get_single_portfolio_gallery_columns_xs());
$columns_mb = intval(g5Theme()->options()->get_single_portfolio_gallery_columns_mb());

$inner_class = $metro_layout = array();
$item_class = array('gallery-item');
$carousel_args = $isotope_args = array();
switch ($layout) {
    case 'carousel':
    case 'carousel-center':
        $inner_class[] = 'owl-carousel owl-theme';
        $carousel_args = array(
            'items' => $columns,
            'margin' => $columns == 1 ? 0 : $columns_gutter,
            'slideBy' => $columns,
            'dots' => true,
            'autoHeight' => true,
            'responsive' => array(
                '1200' => array(
                    'items'   => $columns,
                    'margin'  => $columns == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns,
                ),
                '992'  => array(
                    'items'   => $columns_md,
                    'margin'  => $columns_md == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_md,
                ),
                '768'  => array(
                    'items'   => $columns_sm,
                    'margin'  => $columns_sm == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_sm,
                ),
                '600'  => array(
                    'items'   => $columns_xs,
                    'margin'  => $columns_xs == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_xs,
                ),
                '0'    => array(
                    'items'   => $columns_mb,
                    'margin'  => $columns_mb == 1 ? 0 : $columns_gutter,
                    'slideBy' => $columns_mb,
                )
            )
        );
        break;
    case 'thumbnail':
        $inner_class[] = 'owl-carousel owl-theme manual single-portfolio-gallery-main mg-bottom-10';
        break;
    case 'carousel-3d':
        $inner_class[] = 'owl-carousel owl-theme carousel-3d nav-center';
        $carousel_args = array(
            'items' => 2,
            'center' => true,
            'loop' => true,
            'nav' => true,
            'responsive' => array(
                0 => array(
                    'items' =>  1,
                    'center' => false
                ),
                480 => array(
                    'items' =>  2
                )
            )
        );
        break;
    case 'metro':
        $isotope_args = array(
            'itemSelector' => '.grid-item',
            'layoutMode'   => 'masonry',
            'percentPosition' => true,
            'masonry' => array(
                'columnWidth' => '.gsf-col-base',
            ),
            'metro' => true
        );
        $inner_class[] = 'gf-gutter-' . $columns_gutter;
        $inner_class[] = 'isotope gf-blog-inner';
        $item_class[] = 'grid-item';
        $metro_layout = array(
            array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 1,'md' => 1,'sm' => 1,'xs' => 1,'mb' => 1)),'layout_ratio' => '2x1'),
            array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)),'layout_ratio' => '1x2'),
            array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)),'layout_ratio' => '1x1'),
            array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)),'layout_ratio' => '1x1'),
            array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)),'layout_ratio' => '1x1'),
            array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)),'layout_ratio' => '1x1')

        );
        break;
    default:
        $isotope_args = array(
            'itemSelector' => '.grid-item',
            'layoutMode'   => 'fitRows',
        );
        $inner_class[] = 'gf-gutter-' . $columns_gutter;
        $inner_class[] = 'isotope gf-blog-inner';
        $item_class[] = 'grid-item';
        $columns = array(
				'lg' => $columns,
				'md' => $columns_md,
				'sm' => $columns_sm,
				'xs' => $columns_xs,
                'mb' => $columns_mb
			);
        $item_class[] = g5Theme()->helper()->get_bootstrap_columns($columns);
        break;
}
if($layout === 'carousel-center') {
    $carousel_args['center'] = true;
    $carousel_args['loop'] = true;
}

$media_type = g5Theme()->metaBoxPortfolio()->get_single_portfolio_media_type();
$gallery = g5Theme()->metaBoxPortfolio()->get_single_portfolio_gallery();
if(!empty($gallery)) {
    $gallery = explode('|', $gallery);
} else {
    $gallery = array();
}
$portfolio_thumb = get_post_thumbnail_id();
if(!empty($portfolio_thumb) && !in_array($portfolio_thumb, $gallery)) {
    $gallery = array_merge(array($portfolio_thumb), $gallery);
}
$video = g5Theme()->metaBoxPortfolio()->get_single_portfolio_video();
$wrapper_class = array(
    'portfolio-single-gallery',
    'gallery-layout-' . $layout
);

$item_class[] = $media_type;
if ($image_size === 'full') {
    if (empty($image_ratio)) {
        $image_ratio = g5Theme()->options()->get_portfolio_image_ratio();
    }

    if ($image_ratio === 'custom') {
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
} else {
    $image_size_dimension =  g5Theme()->helper()->get_image_dimension($image_size);
    if ($image_size_dimension) {
        $image_ratio = $image_size_dimension['width'] . 'x' . $image_size_dimension['height'];
    }
}

if('video' === $media_type && 'metro' !== $layout) {
    $video_item_class = 'video-gallery-' . uniqid();
    $item_class[] = $video_item_class;
    $sizes = preg_split('/x/', $image_ratio);
    $image_width = isset($sizes[0]) ? intval($sizes[0]) : 0;
    $image_height = isset($sizes[1]) ? intval($sizes[1]) : 0;
    $padding_bottom = $image_height/$image_width * 100;
    $video_css = <<<CSS
        .{$video_item_class} .embed-responsive {
            padding-bottom: {$padding_bottom}%;
        }
CSS;
    g5Theme()->custom_css()->addCss($video_css);
}
$gallery_id = rand(1000, 9999);
$inner_attributes = array();
if('metro' === $layout) {
    if ($image_size === 'full') {
        $inner_attributes[] = "data-image-size-base='" . $image_size . "'";
    } else {
        $image_size_base_dimension =  g5Theme()->helper()->get_image_dimension($image_size);
        if ($image_size_base_dimension) {
            $inner_attributes[] = "data-image-size-base='" . $image_size_base_dimension['width'] . 'x' . $image_size_base_dimension['height'] . "'";
        }
    }
}
?>
<div class="<?php echo join(' ', $wrapper_class); ?>" data-isotope-wrapper="true">
    <div class="<?php echo join(' ', $inner_class); ?>" <?php echo implode(' ', $inner_attributes); ?> <?php if(!empty($carousel_args)): ?> data-owl-options='<?php echo json_encode( $carousel_args );?>'<?php endif; ?><?php if(!empty($isotope_args)): ?> data-isotope-options='<?php echo json_encode( $isotope_args );?>'<?php endif; ?>>
        <?php if('video' === $media_type):
            $index = 0;
            $custom_class = 'portfolio-gallery-item-' . uniqid();
            $custom_css = <<<CSS
        .{$custom_class} .entry-thumbnail-overlay:after {
            display: none;
        }
CSS;
            g5Theme()->custom_css()->addCss($custom_css);
            $item_class[] = $custom_class;
            foreach ($video as $video_item):
                $item_classes = $item_class;
                $img_size = $image_size;
                $img_ratio = $image_ratio;
                $item_inner_attr = array();
                if('metro' === $layout) {
                    $current_layout = $metro_layout[$index];
                    if (isset($current_layout['layout_ratio'])) {
                        $layout_ratio = !empty($current_layout['layout_ratio']) ? $current_layout['layout_ratio'] : '1x1';
                        if ($image_size !== 'full') {
                            $img_size = g5Theme()->helper()->get_metro_image_size($image_size,$layout_ratio,$columns_gutter);
                        } else {
                            $img_ratio =  g5Theme()->helper()->get_metro_image_ratio($image_size,$layout_ratio);
                        }
                        $item_inner_attr[] = 'data-ratio="'. $layout_ratio .'"';
                    }
                    $item_classes[] = $current_layout['columns'];
                }
                if (wp_oembed_get($video_item) !== false) :?>
                    <div class="<?php echo join(' ', $item_classes); ?>" data-index="<?php echo esc_attr($index); ?>">
                        <div class="item-inner" <?php echo join(' ', $item_inner_attr); ?>>
                            <div class="entry-thumbnail-overlay entry-thumbnail embed-responsive embed-responsive-16by9" style="padding-bottom: 0">
                                <?php echo wp_oembed_get($video_item, array('wmode' => 'transparent')); ?>
                            </div>
                        </div>
                    </div>
                    <?php $index++;
                    if($index == count($metro_layout)) {
                        $index = 0;
                    }?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else:
            $index = 0;
            foreach ($gallery as $gallery_item):
                $item_classes = $item_class;
                $img_size = $image_size;
                $img_ratio = $image_ratio;
                $item_inner_attr = array();
                if('metro' === $layout) {
                    $current_layout = $metro_layout[$index];
                    if (isset($current_layout['layout_ratio'])) {
                        $layout_ratio = !empty($current_layout['layout_ratio']) ? $current_layout['layout_ratio'] : '1x1';
                        if ($image_size !== 'full') {
                            $img_size = g5Theme()->helper()->get_metro_image_size($image_size,$layout_ratio,$columns_gutter);
                        } else {
                            $img_ratio =  g5Theme()->helper()->get_metro_image_ratio($image_size,$layout_ratio);
                        }
                        $item_inner_attr[] = 'data-ratio="'. $layout_ratio .'"';
                    }
                    $item_classes[] = $current_layout['columns'];
                }?>
                <div class="<?php echo join(' ', $item_classes); ?>" data-index="<?php echo esc_attr($index); ?>">
                    <div class="item-inner" <?php echo join(' ', $item_inner_attr); ?>>
                        <?php
                        g5Theme()->blog()->render_post_image_markup(array(
                            'image_id'          => $gallery_item,
                            'image_size'        => $img_size,
                            'display_permalink' => false,
                            'image_mode'        => 'background',
                            'image_ratio' =>    $img_ratio,
                            'gallery_id' => $gallery_id
                        ));
                        ?>
                    </div>
                </div>
                <?php $index++;
                if($index == count($metro_layout)) {
                    $index = 0;
                }?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if('thumbnail' === $layout): ?>
        <div class="owl-carousel owl-theme manual single-portfolio-gallery-thumb">
            <?php if('video' === $media_type):
                $index = 0;
                foreach ($video as $video_item):
                    if (wp_oembed_get($video_item) !== false) :?>
                        <div class="<?php echo join(' ', $item_class); ?>" data-index="<?php echo esc_attr($index); ?>">
                            <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
                                <?php echo wp_oembed_get($video_item, array('wmode' => 'transparent')); ?>
                                <div class="gallery-overlay" data-index="<?php echo esc_attr($index); ?>"></div>
                            </div>
                        </div>
                        <?php $index++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else:
                $index = 0;
                foreach ($gallery as $gallery_item): ?>
                    <div class="<?php echo join(' ', $item_class); ?>" data-index="<?php echo esc_attr($index); ?>">
                        <?php
                        remove_action('g5plus_before_post_image',array(g5Theme()->templates(),'zoom_image_thumbnail'));
                        g5Theme()->blog()->render_post_image_markup(array(
                            'image_id'          => $gallery_item,
                            'image_size'        => '300x200',
                            'display_permalink' => false,
                            'image_mode'        => 'background',
                            'image_ratio' =>    $image_ratio
                        ));
                        add_action('g5plus_before_post_image',array(g5Theme()->templates(),'zoom_image_thumbnail'));
                        ?>
                    </div>
                    <?php $index++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>