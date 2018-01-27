<?php
/**
 * Checkout gift cards form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-gift-cards.php.
 *
 * @author  YIThemes
 * @package yith-woocommerce-gift-cards-premium/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'yith_gift_cards_show_field', true ) ) {
	return;
}

?>
<div class="ywgc-have-code">
    <span><?php echo apply_filters('ywgc_checkout_box_title', __( "Have a gift card?", 'yith-woocommerce-gift-cards' )); ?></span>
	<a href="#" class="ywgc-show-giftcard"><?php _e( 'Click here to enter your code', 'yith-woocommerce-gift-cards' ); ?></a>
</div>
<form class="ywgc-enter-code" method="post" style="display:none">

	<p class="form-row">
		<input type="text" name="gift_card_code" class="input-text"
               placeholder="<?php echo esc_attr( apply_filters( 'ywgc_checkout_box_placeholder', __( 'Gift card code', 'yith-woocommerce-gift-cards' ) ) ); ?>"
               id="giftcard_code"
		       value="" />
		<input type="submit" class="button" name="apply_gift_card"
		       value="<?php echo esc_attr( apply_filters( 'ywgc_checkout_apply_code', __( 'Apply gift card', 'yith-woocommerce-gift-cards' ) ) ); ?>" />
		<input type="hidden" name="is_gift_card"
		       value="1" />
	</p>

	<p class="form-row form-row-last">

	</p>

	<div class="clear"></div>
</form>
