<?php
/**
 * Show a section with a product suggestion if the gift card was purchased as a gift for a product in the shop
 *
 * @author  YITHEMES
 * @package yith-woocommerce-gift-cards-premium\templates\emails
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$is_wc_ge3 = version_compare( WC()->version, '3.0', '>=' );
?>
<div class="ywgc-product-suggested">
	<span class="ywgc-suggested-text">
		<?php echo sprintf( __( "%s would like to suggest you to use this gift card to purchase the following product:", 'yith-woocommerce-gift-cards' ), $gift_card->sender_name ); ?>
	</span>

    <div style="overflow: hidden">
        <img class="ywgc-product-image"
             src="<?php echo $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src(); ?>" />

        <div class="ywgc-product-description">
            <span class="ywgc-product-title"><?php echo $product->get_title(); ?></span>

            <div
                class="ywgc-product-excerpt"><?php echo wp_trim_words( $is_wc_ge3 ? $product->get_short_description() : $product->post->post_excerpt, 20 ); ?></div>

            <a class="ywgc-product-link" href="<?php echo get_permalink( yit_get_prop( $product, 'id' ) ); ?>">
				<?php _e( "Go to the product", 'yith-woocommerce-gift-cards' ); ?></a>
        </div>
    </div>
</div>
