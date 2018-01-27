<?php
/**
 * WC_CP_Compatibility class
 *
 * @author   SomewhereWarm <info@somewherewarm.gr>
 * @package  WooCommerce Composite Products
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 3rd-party Extensions Compatibility.
 *
 * @class    WC_CP_Compatibility
 * @version  3.13.2
 */
class WC_CP_Compatibility {

	/**
	 * Array of min required plugin versions.
	 * @var array
	 */
	private $required = array();

	/**
	 * The single instance of the class.
	 * @var WC_CP_Compatibility
	 *
	 * @since 3.7.0
	 */
	protected static $_instance = null;

	/**
	 * Main WC_CP_Compatibility instance.
	 *
	 * Ensures only one instance of WC_CP_Compatibility is loaded or can be loaded.
	 *
	 * @static
	 * @return WC_CP_Compatibility
	 * @since  3.7.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 3.7.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Foul!', 'woocommerce-composite-products' ), '3.7.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 3.7.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Foul!', 'woocommerce-composite-products' ), '3.7.0' );
	}

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->required = array(
			'pb'     => '5.7.2',
			'addons' => '2.9.1'
		);

		// Initialize.
		$this->load_modules();
	}

	/**
	 * Initialize.
	 *
	 * @since  3.10.2
	 *
	 * @return void
	 */
	protected function load_modules() {

		if ( is_admin() ) {
			// Check plugin min versions.
			add_action( 'admin_init', array( $this, 'check_required_versions' ) );
		}

		// Initialize.
		add_action( 'plugins_loaded', array( $this, 'module_includes' ), 100 );

		// Prevent initialization of deprecated mini-extensions.
		$this->unload_modules();
	}

	/**
	 * Prevent deprecated mini-extensions from initializing.
	 *
	 * @since 3.7.0
	 */
	protected function unload_modules() {

		// Conditional Components mini-extension was merged into CP v3.7+.
		if ( class_exists( 'WC_CP_Scenario_Action_Conditional_Components' ) ) {
			remove_action( 'plugins_loaded', array( 'WC_CP_Scenario_Action_Conditional_Components', 'load' ), 10 );
		}
	}

	/**
	 * Core compatibility functions.
	 *
	 * @since  3.10.2
	 */
	public static function core_includes() {
		require_once( 'core/class-wc-cp-core-compatibility.php' );
	}

	/**
	 * Init compatibility classes.
	 */
	public function module_includes() {

		// Addons support.
		if ( class_exists( 'WC_Product_Addons' ) && defined( 'WC_PRODUCT_ADDONS_VERSION' ) && version_compare( WC_PRODUCT_ADDONS_VERSION, $this->required[ 'addons' ] ) >= 0 ) {
			require_once( 'modules/class-wc-cp-addons-compatibility.php' );
		}

		// NYP support.
		if ( function_exists( 'WC_Name_Your_Price' ) ) {
			require_once( 'modules/class-wc-cp-nyp-compatibility.php' );
		}

		// Points and Rewards support.
		if ( class_exists( 'WC_Points_Rewards_Product' ) ) {
			require_once( 'modules/class-wc-cp-pnr-compatibility.php' );
		}

		// Pre-orders support.
		if ( class_exists( 'WC_Pre_Orders' ) ) {
			require_once( 'modules/class-wc-cp-po-compatibility.php' );
		}

		// Product Bundles support.
		if ( class_exists( 'WC_Bundles' ) ) {
			require_once( 'modules/class-wc-cp-pb-compatibility.php' );
		}

		// One Page Checkout support.
		if ( function_exists( 'is_wcopc_checkout' ) ) {
			require_once( 'modules/class-wc-cp-opc-compatibility.php' );
		}

		// Cost of Goods support.
		if ( class_exists( 'WC_COG' ) ) {
			require_once( 'modules/class-wc-cp-cog-compatibility.php' );
		}

		// Shipwire integration.
		if ( class_exists( 'WC_Shipwire' ) ) {
			require_once( 'modules/class-wc-cp-shipwire-compatibility.php' );
		}

		// Shipstation integration.
		require_once( 'modules/class-wc-cp-shipstation-compatibility.php' );

		// QuickView support.
		if ( class_exists( 'WC_Quick_View' ) ) {
			require_once( 'modules/class-wc-cp-qv-compatibility.php' );
		}

		// WC Quantity Increment support.
		if ( class_exists( 'WooCommerce_Quantity_Increment' ) ) {
			require_once( 'modules/class-wc-cp-qi-compatibility.php' );
		}

		// PIP support.
		if ( class_exists( 'WC_PIP' ) ) {
			require_once( 'modules/class-wc-cp-pip-compatibility.php' );
		}

		// Subscriptions fixes.
		if ( class_exists( 'WC_Subscriptions' ) ) {
			require_once( 'modules/class-wc-cp-subscriptions-compatibility.php' );
		}

		// Min Max Quantities integration.
		if ( class_exists( 'WC_Min_Max_Quantities' ) ) {
			require_once( 'modules/class-wc-cp-min-max-compatibility.php' );
		}
	}

	/**
	 * Checks minimum required versions of compatible/integrated extensions.
	 */
	public function check_required_versions() {

		global $woocommerce_bundles;

		// PB version check.
		if ( ! empty( $woocommerce_bundles ) ) {
			$required_version = $this->required[ 'pb' ];
			if ( version_compare( $woocommerce_bundles->version, $required_version ) < 0 ) {
				$extension = 'WooCommerce Product Bundles';
				$notice    = sprintf( __( 'The installed version of <strong>%1$s</strong> is not supported by Composite Products. Please update <strong>%1$s</strong> to version <strong>%2$s</strong> or higher.', 'woocommerce-composite-products' ), $extension, $required_version );
				WC_CP_Admin_Notices::add_notice( $notice, 'warning' );
			}
		}

		// CC existence check.
		if ( class_exists( 'WC_CP_Scenario_Action_Conditional_Components' ) ) {
			$notice = sprintf( __( 'The <strong>WooCommerce Composite Products - Conditional Components</strong> mini-extension is now part of <strong>WooCommerce Composite Products</strong>. Please deactivate and remove the <strong>WooCommerce Composite Products - Conditional Components</strong> plugin.', 'woocommerce-composite-products' ) );
			WC_CP_Admin_Notices::add_notice( $notice, 'warning' );
		}

		// Addons version check.
		if ( class_exists( 'WC_Product_Addons' ) ) {
			$required_version = $this->required[ 'addons' ];
			if ( ! defined( 'WC_PRODUCT_ADDONS_VERSION' ) || version_compare( WC_PRODUCT_ADDONS_VERSION, $required_version ) < 0 ) {
				$extension = 'WooCommerce Product Add-ons';
				$notice    = sprintf( __( 'The installed version of <strong>%1$s</strong> is not supported by Composite Products. Please update <strong>%1$s</strong> to version <strong>%2$s</strong> or higher.', 'woocommerce-composite-products' ), $extension, $required_version );
				WC_CP_Admin_Notices::add_notice( $notice, 'warning' );
			}
		}
	}

	/**
	 * Rendering a PIP document?
	 *
	 * @since  3.12.0
	 *
	 * @param  string  $type
	 * @return boolean
	 */
	public function is_pip( $type = '' ) {
		return class_exists( 'WC_CP_PIP_Compatibility' ) && WC_CP_PIP_Compatibility::rendering_document( $type );
	}


	/**
	 * Tells if a product is a Name Your Price product, provided that the extension is installed.
	 *
	 * @param  mixed  $product
	 * @return boolean
	 */
	public function is_nyp( $product ) {

		if ( ! class_exists( 'WC_Name_Your_Price_Helpers' ) ) {
			return false;
		}

		if ( WC_Name_Your_Price_Helpers::is_nyp( $product ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Checks PHP version.
	 *
	 * @param  string  $version
	 * @return boolean
	 */
	public static function php_version_gte( $version ) {
		return function_exists( 'phpversion' ) && version_compare( phpversion(), $version, '>=' );
	}
}

WC_CP_Compatibility::core_includes();
