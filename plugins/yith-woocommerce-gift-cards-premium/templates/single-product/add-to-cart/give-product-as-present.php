<?php
/**
 * Variable product add to cart
 *
 * @author  Yithemes
 * @package YITH WooCommerce Gift Cards
 *
 */
if ( ! defined ( 'ABSPATH' ) ) {
    exit;
}

do_action ( 'yith_gift_cards_template_before_add_to_cart_form' );
?>
    <button id="give-as-present"
            class="btn btn-ghost give-as-present"><?php echo apply_filters( 'yith_wcgc_gift_this_product_button_label',__( "Gift this product", 'yith-woocommerce-gift-cards' )); ?></button>
<?php
YITH_YWGC ()->frontend->show_gift_card_generator ();
