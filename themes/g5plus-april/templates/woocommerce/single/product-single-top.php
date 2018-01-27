<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 10/08/2017
 * Time: 9:47 SA
 */
global $product;
if ( ! is_a( $product, 'WC_Product' ) ) {
    $product = wc_get_product( get_the_ID() );
}
?>
<div class="single-product-info single-style-02 clearfix">
    <div class="col-sm-6 sm-mg-bottom-30">
        <div class="single-product-image">
            <?php
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_loop_sale_flash', 10);
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
            add_action('woocommerce_before_single_product_summary', array(g5Theme()->templates(), 'shop_show_product_images_layout_2'), 20);
            /**
             * woocommerce_before_single_product_summary hook.
             *
             * @hooked shop_show_product_images_layout_2 - 20
             */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="summary-product entry-summary">
            <?php
            $product_add_to_cart_enable = g5Theme()->options()->get_product_add_to_cart_enable();
            if (!$product_add_to_cart_enable) {
                remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
            }
            ?>

            <?php
            /**
             * woocommerce_single_product_summary hook.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked shop_single_loop_sale_count_down - 15
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked g5plus_woocommerce_template_single_function - 60
             */
            do_action( 'woocommerce_single_product_summary' );
            ?>

        </div><!-- .summary -->
    </div>
</div>