<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 08/08/2017
 * Time: 5:00 CH
 */
$sidebar_layout = g5Theme()->options()->get_sidebar_layout();
$col_left_class = 'col-sm-6 sm-mg-bottom-30';
$col_right_class = 'col-sm-6 gf-sticky';
if($sidebar_layout === 'none') {
    $col_left_class = 'col-sm-5 sm-mg-bottom-30';
    $col_right_class = 'col-sm-7 gf-sticky';
}
?>
<div class="single-product-info single-style-03">
    <div class="single-product-info row clearfix">
        <div class="<?php echo esc_attr($col_left_class); ?>">
            <div class="single-product-image">
                <?php
                remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
                add_action('woocommerce_before_single_product_summary', array(g5Theme()->templates(), 'shop_show_product_images_layout_3'), 20);
                /**
                 * woocommerce_before_single_product_summary hook.
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked shop_show_product_images_layout_3 - 20
                 */
                do_action( 'woocommerce_before_single_product_summary' );
                ?>
            </div>
        </div>
        <div class="<?php echo esc_attr($col_right_class); ?>">
            <div class="summary-product entry-summary mg-bottom-85">

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
                 * @hooked g5plus_woocommerce_template_single_function - 35
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>

            </div><!-- .summary -->
        </div>
    </div>
</div>
