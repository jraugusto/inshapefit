<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Iconic_WDS_Settings.
 *
 * @class    Iconic_WDS_Settings
 * @version  1.0.0
 * @author   Iconic
 */
class Iconic_WDS_Settings {

	/**
	 * Get introduction.
	 *
	 * @return string
	 */
	public static function get_introduction() {
		ob_start();
		?>
		<h3><?php _e( 'Welcome to WooCommerce Delivery Slots', 'jckwds' ); ?></h3>
		<p><?php _e( "You're awesome! We've been looking forward to having you onboard, and we're pleased to see the day has finally come.", 'jckwds' ); ?></p>
		<p><?php printf( __( 'Make yourself at home. If you get stuck, check out the <a href="%s" target="_blank">documentation</a>, or create a support ticket using the button below.', 'jckwds' ), 'http://docs.iconicwp.com/category/29-delivery-slots' ); ?></p>
		<?php
		return ob_get_clean();
	}

	/**
	 * Documentation link.
	 */
	public static function documentation_link() {
		return sprintf( '<a href="http://docs.iconicwp.com/category/29-delivery-slots" class="button button-secondary" target="_blank">%s</a>', __( 'Read Documentation', 'jckwds' ) );
	}

}