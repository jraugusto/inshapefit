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
 * @version 3.1.0
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

?>
<div id="single-product-image" class="single-product-image-inner">
    <div class="single-product-image-main-wrap">
        <div class="single-product-image-main">
            <?php
            $image_id = $product_images[0]['image_id'];
            $variation_id = isset($product_images[0]['variation_id']) ? $product_images[0]['variation_id'] : '' ;
            $image_title 	= esc_attr( get_the_title( $image_id ) );
            $image_caption = '';
            $image_obj = get_post( $image_id );
            if (isset($image_obj) && isset($image_obj->post_excerpt)) {
                $image_caption 	= $image_obj->post_excerpt;
            }
            $image_link  	= wp_get_attachment_url( $image_id );
            $image_thumb = wp_get_attachment_image_src($image_id);
            $image       	= wp_get_attachment_image( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                'title'	=> $image_title,
                'alt'	=> $image_title
            ) );
            if (!empty($variation_id)) {?>
                <?php echo sprintf('%s', $image);
            } else {?>
                <?php echo sprintf('%s', $image);
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

    <div class="single-product-image-thumb mg-top-10 owl-carousel manual">
        <?php
        foreach($product_images as $key => $value) {
            $index = $key;
            $image_id = $value['image_id'];
            $variation_id = isset($value['variation_id']) ? $value['variation_id'] : '' ;
            $image_title 	= esc_attr( get_the_title( $image_id ) );
            $image_caption = '';
            $image_obj = get_post( $image_id );
            if (isset($image_obj) && isset($image_obj->post_excerpt)) {
                $image_caption 	= $image_obj->post_excerpt;
            }

            $large_img = wp_get_attachment_image_src($image_id, 'shop_single');
            if(!empty($large_img) && !empty($large_img[0])) {
                $large_img = $large_img[0];
            } else {
                $large_img = '';
            }
            $image_link  	=  wp_get_attachment_url( $image_id );
            $image       	= wp_get_attachment_image( $image_id,  apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
                'title'	=> $image_title,
                'alt'	=> $image_title
            ) );
            echo '<div class="product-image-thumb-item">';
            if (!empty($variation_id)) {?>
                <a href="<?php echo esc_url($image_link); ?>" class="woocommerce-thumbnail-image"
                   title="<?php echo esc_html($image_caption); ?>" data-variation_id="<?php echo esc_attr($variation_id); ?>"
                   data-index="<?php echo esc_attr($index); ?>" data-large-image="<?php echo esc_url($large_img) ?>"><?php echo sprintf('%s', $image); ?></a>
            <?php } else {?>
                <a href="<?php echo esc_url($image_link); ?>" class="woocommerce-thumbnail-image"
                   title="<?php echo esc_html($image_caption); ?>" data-index="<?php echo esc_attr($index); ?>"
                   data-large-image="<?php echo esc_url($large_img) ?>"><?php echo sprintf('%s', $image); ?></a>
            <?php }
            echo '</div>';
        }
        ?>
    </div>
</div>
