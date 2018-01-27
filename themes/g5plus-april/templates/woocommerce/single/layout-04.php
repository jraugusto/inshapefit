<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 08/08/2017
 * Time: 5:00 CH
 */
$sidebar_layout = g5Theme()->options()->get_sidebar_layout();
$col_left_class = 'col-sm-6 sm-mg-bottom-30';
$col_right_class = 'col-sm-6';
if($sidebar_layout === 'none') {
    $col_left_class = 'col-sm-5 sm-mg-bottom-30';
    $col_right_class = 'col-sm-7';
}
?>
<div class="single-product-controls gf-table-cell">
    <div class="gf-table-cell-left">
        <?php g5Theme()->breadcrumbs()->get_breadcrumbs(); ?>
    </div>
    <div class="gf-table-cell-right">
        <ul class="gf-inline">
            <li>
                <?php $prev_product = get_adjacent_post(false, '', true, 'product_cat');
                if($prev_product):?>
                    <?php $product = wc_get_product( $prev_product->ID ); ?>
                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="prev-product" title="<?php esc_html_e('Previous', 'g5plus-april') ?>">
                        <i class="ion-ios-arrow-thin-left"></i>
                    </a>
                    <div class="product-near">
                        <div class="product-near-thumb">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr($prev_product->post_title); ?>">
                                <?php echo wp_kses_post($product->get_image()); ?>
                            </a>
                        </div>
                        <div class="product-near-info">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr($prev_product->post_title); ?>" class="product-near-title">
                                <span class="product-title"><?php echo esc_html($product->get_name()); ?></span>
                            </a>
                            <p class="price">
                                <?php echo wp_kses_post($product->get_price_html()); ?>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <span class="prev-product disable ion-ios-arrow-thin-left"></span>
                <?php endif; ?>
            </li>
            <li>
                <?php $next_product = get_adjacent_post(false, '', false, 'product_cat');
                if($next_product):?>
                    <?php $product = wc_get_product( $next_product->ID ); ?>
                    <a href="<?php echo esc_url(get_permalink($next_product->ID)); ?>" class="next-product" title="<?php esc_html_e('Next', 'g5plus-april') ?>">
                        <i class="ion-ios-arrow-thin-right"></i>
                    </a>
                    <div class="product-near">
                        <div class="product-near-thumb">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr($prev_product->post_title); ?>">
                                <?php echo wp_kses_post($product->get_image()); ?>
                            </a>
                        </div>
                        <div class="product-near-info">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr($prev_product->post_title); ?>" class="product-near-title">
                                <span class="product-title"><?php echo esc_html($product->get_name()); ?></span>
                            </a>
                            <p class="price">
                                <?php echo wp_kses_post($product->get_price_html()); ?>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <span class="next-product disable ion-ios-arrow-thin-right"></span>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>
<div class="single-product-info single-style-01">
    <div class="single-product-info-inner row clearfix">
        <div class="<?php echo esc_attr($col_left_class); ?>">
            <div class="single-product-image">
                <?php
                /**
                 * woocommerce_before_single_product_summary hook.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action( 'woocommerce_before_single_product_summary' );
                ?>
            </div>
        </div>
        <div class="<?php echo esc_attr($col_right_class); ?>">
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
                 * @hooked shop_loop_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked shop_single_loop_sale_count_down - 15
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked shop_single_function - 60
                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>
            </div><!-- .summary -->
        </div>
    </div>
</div>
