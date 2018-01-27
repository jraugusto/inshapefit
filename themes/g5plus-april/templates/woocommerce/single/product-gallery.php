<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 10/08/2017
 * Time: 8:29 SA
 */

global $product_images, $gallery_id, $post;
$two_col = false;
$index = 0;
if(isset($product_images) && !empty($product_images) && count($product_images) > 0) {
    foreach ($product_images as $key => $value) {
        if($key == 0) continue;
        if ($index == 0) {
            $two_col = !$two_col;
            if ($two_col) {
                $index = 2;
            } else {
                $index = 3;
            }
        }
        $item_class = array('gallery-item');
        if ($two_col) {
            $item_class[] = 'col-sm-6';
        } else {
            $item_class[] = 'col-sm-4';
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
    }
}