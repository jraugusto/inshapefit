<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post, $woocommerce, $product;
$index = 0;
$product_images = array();
$image_ids = array();

if (has_post_thumbnail()) {
    $product_images[$index] = array(
        'image_id' => get_post_thumbnail_id()
    );
    $image_ids[$index] = get_post_thumbnail_id();
    $index++;
}

// Additional Images
$attachment_ids = $product->get_gallery_image_ids();
if ($attachment_ids) {
    foreach ($attachment_ids as $attachment_id) {
        if (in_array($attachment_id, $image_ids)) continue;
        $product_images[$index] = array(
            'image_id' => $attachment_id
        );
        $image_ids[$index] = $attachment_id;
        $index++;
    }
}

// product variable type
if ($product->get_type() == 'variable') {
    $available_variations = $product->get_available_variations();

    if (isset($available_variations)) {
        foreach ($available_variations as $available_variation) {
            $variation_id = $available_variation['variation_id'];
            if (has_post_thumbnail($variation_id)) {
                $variation_image_id = get_post_thumbnail_id($variation_id);

                if (in_array($variation_image_id, $image_ids)) {
                    $index_of = array_search($variation_image_id, $image_ids);
                    if (isset($product_images[$index_of]['variation_id'])) {
                        $product_images[$index_of]['variation_id'] .= $variation_id . '|';
                    } else {
                        $product_images[$index_of]['variation_id'] = '|' . $variation_id . '|';
                    }
                    continue;
                }

                $product_images[$index] = array(
                    'image_id' => $variation_image_id,
                    'variation_id' => '|' . $variation_id . '|'
                );
                $image_ids[$index] = $variation_image_id;
                $index++;
            }
        }
    }
}

$gallery_id = rand();
?>
<div id="single-product-image" class="single-product-image-inner">
    <?php
    if(is_array($product_images) && count($product_images) > 0) :?>
        <div class="single-product-gallery">
            <div class="single-product-gallery-inner row clearfix">
                <?php
                $two_col = true;
                $index = 0;
                foreach($product_images as $key => $value) {
                    if ($index == 0) {
                        $two_col = !$two_col;
                        if ($two_col) {
                            $index = 2;
                        } else {
                            $index = 1;
                        }
                    }
                    $item_class = array('gallery-item');
                    if ($two_col) {
                        $item_class[] = 'col-sm-6';
                    } else {
                        $item_class[] = 'col-sm-12';
                    }
                    $image_id = $value['image_id'];
                    $variation_id = isset($value['variation_id']) ? $value['variation_id'] : '';
                    $image_title = esc_attr(get_the_title($image_id));
                    $image_caption = '';
                    $image_obj = get_post($image_id);
                    if (isset($image_obj) && isset($image_obj->post_excerpt)) {
                        $image_caption = $image_obj->post_excerpt;
                    }
                    $image_link = wp_get_attachment_url($image_id);
                    $image_thumb = wp_get_attachment_image_src($image_id);
                    $image = wp_get_attachment_image($image_id, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                        'title' => $image_title,
                        'alt' => $image_title
                    ));
                    echo '<div class="' . join(' ', $item_class) . '">';
                    echo '<div class="gallery-item-inner">';
                    if (!empty($variation_id)) {?>
                        <a href="<?php echo esc_url($image_link); ?>"
                           class="zoom-image" title="<?php echo esc_attr($image_caption); ?>" data-magnific="true"
                           data-magnific-options='<?php echo json_encode(array('galleryId' => $gallery_id)); ?>'
                           data-gallery-id="<?php echo esc_attr($gallery_id); ?>" data-variation_id="<?php echo esc_attr($variation_id); ?>"><i class="fa fa-expand"></i></a>
                        <?php echo sprintf('%s', $image);
                    } else {?>
                        <a href="<?php echo esc_url($image_link); ?>"
                           class="zoom-image" title="<?php echo esc_attr($image_caption); ?>" data-magnific="true"
                           data-magnific-options='<?php echo json_encode(array('galleryId' => $gallery_id)); ?>'
                           data-gallery-id="<?php echo esc_attr($gallery_id); ?>"><i class="fa fa-expand"></i></a>
                        <?php echo sprintf('%s', $image);
                    }

                    echo '</div>';
                    echo '</div>';
                    $index--;
                }?>
            </div>
            <?php
            /**
             * g5plus_after_single_product_image_main hook.
             *
             * @hooked g5plus_woocommerce_template_loop_sale_count_down - 10
             */
            do_action( 'g5plus_after_single_product_image_main' );
            ?>
        </div>
    <?php endif; ?>
</div>
