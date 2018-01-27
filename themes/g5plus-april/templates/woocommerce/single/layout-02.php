<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 08/08/2017
 * Time: 5:00 CH
 */
global $product_images;
if(is_array($product_images) && count($product_images) > 1) {
?>
    <div class="single-product-gallery">
        <div class="single-product-gallery-inner row clearfix">
            <?php
                /**
                 * g5plus_april_show_product_gallery hook.
                 *
                 * @hooked shop_loop_single_gallery - 10
                */
                do_action('g5plus_april_show_product_gallery');
            ?>
        </div>
    </div>
<?php }