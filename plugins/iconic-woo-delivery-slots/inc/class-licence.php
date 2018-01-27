<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Iconic_WDS_Licence.
 *
 * @class    Iconic_WDS_Licence
 * @version  1.0.0
 * @category Class
 * @author   Iconic
 */
class Iconic_WDS_Licence {

	/**
	 * @var string $settings_uri
	 */
	public static $settings_uri = 'jckwds-settings';

	/**
	 * Run.
	 */
	public static function run() {

		self::configure();
		self::add_filters();

	}

	/**
	 * Configure.
	 */
	public static function configure() {

		global $iconic_wds_fs;

		if ( ! isset( $iconic_wds_fs ) ) {
			// Include Freemius SDK.
			require_once ICONIC_WDS_INC_PATH . 'freemius/start.php';

			$iconic_wds_fs = fs_dynamic_init( array(
				'id'                  => '1038',
				'slug'                => 'iconic-woo-delivery-slots',
				'type'                => 'plugin',
				'public_key'          => 'pk_ae98776906ff416522057aab876c0',
				'is_premium'          => ! ICONIC_WDS_IS_ENVATO,
				'is_premium_only'     => ! ICONIC_WDS_IS_ENVATO,
				'has_premium_version' => ! ICONIC_WDS_IS_ENVATO,
				'has_paid_plans'      => ! ICONIC_WDS_IS_ENVATO,
				'has_addons'          => false,
				'is_org_compliant'    => false,
				'trial'               => array(
					'days'               => 14,
					'is_require_payment' => true,
				),
				'menu'                => array(
					'slug'    => self::$settings_uri,
					'contact' => false,
					'support' => false,
					'account' => false,
					'pricing' => ! ICONIC_WDS_IS_ENVATO,
					'parent'  => array(
						'slug' => 'woocommerce',
					),
				),
			) );
		}

		return $iconic_wds_fs;

	}

	/**
	 * Add filters.
	 */
	public static function add_filters() {

		global $iconic_wds_fs;

		$iconic_wds_fs->add_filter( 'show_trial', '__return_false' );
		$iconic_wds_fs->add_filter( 'templates/account.php', array( __CLASS__, 'back_to_settings_link' ), 10, 1 );
		$iconic_wds_fs->add_filter( 'templates/billing.php', array( __CLASS__, 'back_to_settings_link' ), 10, 1 );
		add_filter( 'parent_file', array( __CLASS__, 'highlight_menu' ), 10, 1 );

	}

	/**
	 * Highlight menu.
	 */
	public static function highlight_menu( $parent_file ) {
		global $plugin_page;

		$page = empty( $_GET['page'] ) ? false : $_GET['page'];

		if ( self::$settings_uri . '-account' == $page ) {
			$plugin_page = self::$settings_uri;
		}

		return $parent_file;
	}

	/**
	 * Account link.
	 */
	public static function account_link() {
		return sprintf( '<a href="%s" class="button button-secondary">%s</a>', admin_url( 'admin.php?page=' . self::$settings_uri . '-account' ), __( 'Manage Licence', 'iconic-wssv' ) );
	}

	/**
	 * Billing link.
	 */
	public static function billing_link() {
		return sprintf( '<a href="%s" class="button button-secondary">%s</a>', admin_url( 'admin.php?page=' . self::$settings_uri . '-account&tab=billing' ), __( 'Manage Billing', 'iconic-wssv' ) );
	}

	/**
	 * Contact link.
	 */
	public static function contact_link() {
		global $iconic_wds_fs;

		return sprintf( '<a href="%s" class="button button-secondary">%s</a>', $iconic_wds_fs->contact_url(), __( 'Create Support Ticket', 'iconic-wssv' ) );
	}

	/**
	 * Get contact URL.
	 */
	public static function get_contact_url( $subject = false, $message = false ) {
		global $iconic_wds_fs;

		return $iconic_wds_fs->contact_url( $subject, $message );
	}

	/**
	 * Back to settings link.
	 */
	public static function back_to_settings_link( $html ) {
		return $html . sprintf( '<a href="%s" class="button button-secondary">&larr; %s</a>', admin_url( 'admin.php?page=' . self::$settings_uri ), __( 'Back to Settings', 'iconic-wssv' ) );
	}

	/**
	 * Has valid licence.
	 *
	 * @return bool
	 */
	public static function has_valid_licence() {
		global $iconic_wds_fs;

		if ( ICONIC_WDS_IS_ENVATO || $iconic_wds_fs->can_use_premium_code() ) {
			return true;
		}

		return false;
	}
}