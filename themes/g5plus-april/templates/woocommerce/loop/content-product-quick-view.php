<?php
/**
 * The template for displaying product quick-views
 *
 * @package WordPress
 * @subpackage April
 * @since april 1.0
 */
global $product;
?>
<div id="popup-product-quick-view-wrapper" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="product-quickview-navigation">
        <?php $prev_product = get_adjacent_post(false, '', true, 'product_cat');
        if($prev_product):?>
            <a href="<?php echo esc_url(get_permalink($prev_product->ID)); ?>" data-product_id="<?php echo esc_attr($prev_product->ID); ?>" class="prev-product product-quick-view" title="<?php echo esc_attr($prev_product->post_title); ?>">
                <i class="ion-chevron-left"></i>
            </a>
        <?php else: ?>
            <span class="prev-product disable ion-chevron-left"></span>
        <?php endif; ?>
        <?php $next_product = get_adjacent_post(false, '', false, 'product_cat');
        if($next_product):?>
            <a href="<?php echo esc_url(get_permalink($next_product->ID)); ?>" data-product_id="<?php echo esc_attr($next_product->ID); ?>" class="next-product product-quick-view" title="<?php echo esc_attr($next_product->post_title); ?>">
                <i class="ion-chevron-right"></i>
            </a>
        <?php else: ?>
            <span class="next-product disable ion-chevron-right"></span>
        <?php endif; ?>
    </div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<a class="popup-close ion-android-close" data-dismiss="modal" href="javascript:;"></a>
			<div class="modal-body">
				<div class="woocommerce">
					<div itemscope id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
						<div class="row single-product-info quick-view-product-image clearfix">
							<div class="col-sm-6">
								<div class="single-product-image">
									<?php
									/**
									 * woocommerce_before_single_product_summary hook.
									 *
									 * @hooked woocommerce_show_product_loop_sale_flash - 10
									 * @hooked quick_view_show_product_images - 20
									 */
									do_action( 'woocommerce_before_quick_view_product_summary' );
									?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="summary-product entry-summary">
									<?php
									$product_add_to_cart_enable = g5Theme()->options()->get_product_add_to_cart_enable();
									if ('on' !== $product_add_to_cart_enable) {
										remove_action('woocommerce_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);
									}
									?>
									<?php
									/**
									 * woocommerce_single_product_summary hook.
									 *
									 * @hooked shop_loop_quick_view_product_title - 5
									 * @hooked shop_loop_rating - 10
									 * @hooked woocommerce_template_single_price - 10
                                     * @hooked woocommerce_template_single_excerpt - 20
                                     * @hooked woocommerce_template_single_add_to_cart - 30
                                     * @hooked woocommerce_template_single_meta - 40
                                     * @hooked woocommerce_template_single_sharing - 50
                                     * @hooked shop_single_function - 60
									 */
									do_action( 'woocommerce_quick_view_product_summary' );
									?>

								</div><!-- .summary -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>