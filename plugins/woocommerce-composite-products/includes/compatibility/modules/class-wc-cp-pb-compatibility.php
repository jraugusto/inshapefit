<?php
/**
 * WC_CP_PB_Compatibility class
 *
 * @author   SomewhereWarm <info@somewherewarm.gr>
 * @package  WooCommerce Composite Products
 * @since    3.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hooks for Product Bundles compatibility.
 *
 * @version  3.13.1
 */
class WC_CP_PB_Compatibility {

	public static function init() {

		// Extend PB group modes to support 'No parent' group mode of composited bundles.
		add_filter( 'woocommerce_bundles_group_mode_options_data', array( __CLASS__, 'composited_no_parent_group_mode' ) );

		// Bundles support.
		add_action( 'woocommerce_add_cart_item', array( __CLASS__, 'bundled_cart_item_price_modification' ), 9 );
		add_action( 'woocommerce_get_cart_item_from_session', array( __CLASS__, 'bundled_cart_item_price_modification' ), 9 );

		add_action( 'woocommerce_add_cart_item', array( __CLASS__, 'bundled_cart_item_after_price_modification' ), 11 );
		add_action( 'woocommerce_get_cart_item_from_session', array( __CLASS__, 'bundled_cart_item_after_price_modification' ), 11 );
	}

	/**
	 * Add hidden Group Mode for composited bundles.
	 *
	 * @param  array  $group_mode_data
	 * @return array
	 */
	public static function composited_no_parent_group_mode( $group_mode_data ) {

		$group_mode_data[ 'none_composited' ] = array(
			'title'      => __( 'No parent (composited)', 'woocommerce-composite-products' ),
			'features'   => array( 'parent_item', 'child_item_indent', 'aggregated_subtotals' ),
			'is_visible' => false
		);

		return $group_mode_data;
	}

	/**
	 * Add filters to modify bundled product prices when parent product is composited and has a discount.
	 *
	 * @param  array   $cart_item
	 * @return void
	 */
	public static function bundled_cart_item_price_modification( $cart_item ) {

		if ( $bundle_container_item = wc_pb_get_bundled_cart_item_container( $cart_item ) ) {
			if ( $composite_container_item = wc_cp_get_composited_cart_item_container( $bundle_container_item ) ) {

				$bundle           = $bundle_container_item[ 'data' ];
				$composite        = $composite_container_item[ 'data' ];
				$component_id     = $bundle_container_item[ 'composite_item' ];
				$component_option = $composite->get_component_option( $component_id, $bundle->get_id() );

				if ( $component_option ) {
					$component_option->add_filters();
				}
			}

		} elseif ( wc_pb_is_bundle_container_cart_item( $cart_item ) ) {
			$cart_item[ 'data' ]->set_group_mode( 'none_composited' );
		}

		return $cart_item;
	}

	/**
	 * Remove filters that modify bundled product prices when parent product is composited and has a discount.
	 *
	 * @param  string  $cart_item
	 * @return void
	 */
	public static function bundled_cart_item_after_price_modification( $cart_item ) {

		if ( $bundle_container_item = wc_pb_get_bundled_cart_item_container( $cart_item ) ) {
			if ( $composite_container_item = wc_cp_get_composited_cart_item_container( $bundle_container_item ) ) {

				$bundle           = $bundle_container_item[ 'data' ];
				$composite        = $composite_container_item[ 'data' ];
				$component_id     = $bundle_container_item[ 'composite_item' ];
				$component_option = $composite->get_component_option( $component_id, $bundle->get_id() );

				if ( $component_option ) {
					$component_option->remove_filters();
				}
			}
		}

		return $cart_item;
	}
}

WC_CP_PB_Compatibility::init();
