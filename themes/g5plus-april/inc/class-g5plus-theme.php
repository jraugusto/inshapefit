<?php
/**
 * Class G5Plus Theme
 */
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Theme')) {
	class G5Plus_Theme
	{

		/**
		 * The instance of this object
		 *
		 * @static
		 * @access private
		 * @var null | object
		 */
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			spl_autoload_register(array($this, 'incAutoload'));

			$this->hook()->init();

			$this->custom_css()->init();

			$this->custom_js()->init();

			$this->image_resize()->init();

			$this->requirePlugin()->init();

			$this->includes();

            if (class_exists( 'WooCommerce' )) {
                $this->woocommerce()->init();
            }
            if (class_exists('G5P_Inc_Portfolio')) {
                $this->portfolio()->init();
            }
		}

		private function includes()
		{
			require_once($this->themeDir('inc/theme-functions.php'));

			require_once($this->themeDir('core/post-format-ui/post-format-ui.php'));
		}



		/**
		 * Get Theme Dir
		 *
		 * @param string $path
		 * @return string
		 */
		public function themeDir($path = '') {

			return trailingslashit(get_template_directory()) . $path;
		}

		/**
		 * Get Theme url
		 * @param string $path
		 * @return string
		 */
		public function themeUrl($path = '') {
			return trailingslashit(get_template_directory_uri()) . $path;
		}


		/**
		 * Register sidebar
		 */
		public function registerSidebar()
		{
			return G5Plus_Inc_Register_Sidebar::getInstance();
		}


		/**
		 * Inc library auto loader
		 *
		 * @param $class
		 */
		public function incAutoload($class)
		{
			$file_name = preg_replace('/^G5Plus_Inc_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				set_include_path(g5Theme()->themeDir("inc/"));
				spl_autoload_extensions('.class.php');
				spl_autoload($file_name);
			}
		}

		/**
		 * Custom Css Object
		 *
		 * @return G5Plus_Inc_Custom_Css
		 */
		public function custom_css()
		{
			return G5Plus_Inc_Custom_Css::getInstance();
		}

		/**
		 * Custom Js Object
		 *
		 * @return G5Plus_Inc_Custom_Js
		 */
		public function custom_js()
		{
			return G5Plus_Inc_Custom_Js::getInstance();
		}

		/**
		 * Breadcrumbs Object
		 *
		 * @return G5Plus_Inc_Breadcrumbs|null|object
		 */
		public function breadcrumbs()
		{
			return G5Plus_Inc_Breadcrumbs::getInstance();
		}

		/**
		 * Helper Object
		 *
		 * @return G5Plus_Inc_Helper|null|object
		 */
		public function helper()
		{
			return G5Plus_Inc_Helper::getInstance();
			//return G5Plus_Helper::init();
		}

		/**
		 * Template Object
		 *
		 * @return G5Plus_Inc_Templates|null|object
		 */
		public function templates()
		{
			return G5Plus_Inc_Templates::getInstance();
		}

		/**
		 * Blog Object
		 *
		 * @return G5Plus_Inc_Blog|null|object
		 */
		public function blog()
		{
			return G5Plus_Inc_Blog::getInstance();
		}

		/**
		 * Ajax Object
		 * @return G5Plus_Inc_Ajax|null|object
		 */
		public function ajax()
		{
			return G5Plus_Inc_Ajax::getInstance();
		}

		/**
		 * Image Resize
		 * @return G5Plus_Image_Resize|null|object
		 */
		public function image_resize()
		{
            require_once(g5Theme()->themeDir('inc/libs/class-g5plus-image-resize.php'));
			return G5Plus_Image_Resize::getInstance();
		}

		/**
		 * Query
		 * @return G5Plus_Inc_Query|null|object
		 */
		public function query() {
			return G5Plus_Inc_Query::getInstance();
		}

		/**
		 * G5Plus Assets
		 *
		 * @return G5Plus_Inc_Assets
		 */
		public function assets() {
			return G5Plus_Inc_Assets::getInstance();
		}

		/**
		 * @return G5Plus_Inc_Hook
		 */
		public function hook() {
			return G5Plus_Inc_Hook::getInstance();
		}

		/**
		 * @return G5Plus_Inc_Options
		 */
		public function options() {
			return G5Plus_Inc_Options::getInstance();
		}

		/**
		 * @return G5Plus_Inc_Options_Skin
		 */
		public function optionsSkin() {
			return G5Plus_Inc_Options_Skin::getInstance();
		}

		/**
		 * @return G5Plus_Inc_MetaBox
		 */
		public function metaBox() {
			return G5Plus_Inc_MetaBox::getInstance();
		}

		/**
		 * @return G5Plus_Inc_MetaBox_Post
		 */
		public function metaBoxPost() {
			return G5Plus_Inc_MetaBox_Post::getInstance();
		}

        /**
         * @return G5Plus_Inc_MetaBox_Portfolio
         */
        public function metaBoxPortfolio() {
            return G5Plus_Inc_MetaBox_Portfolio::getInstance();
        }

		/**
		 * @return G5Plus_Inc_Theme_Setup
		 */
		public function themeSetup() {
			return G5Plus_Inc_Theme_Setup::getInstance();
		}

		/**
		 * @return G5Plus_Inc_Require_Plugin
		 */
		public function requirePlugin() {
			return G5Plus_Inc_Require_Plugin::getInstance();
		}

		/**
		 * @return G5Plus_Inc_Font_Icon
		 */
		public function fontIcons() {
			return G5Plus_Inc_Font_Icon::getInstance();
		}

        /**
         * @return G5Plus_Inc_Term_Meta
         */
        public function termMeta() {
            return G5Plus_Inc_Term_Meta::getInstance();
        }

		/**
		 * @return G5Plus_Inc_User_Meta
		 */
		public function userMeta() {
			return G5Plus_Inc_User_Meta::getInstance();
		}

        /**
         * @return G5Plus_Inc_Woocommerce
         */
		public function woocommerce() {
		    return G5Plus_Inc_Woocommerce::getInstance();
        }

        /**
         * @return G5Plus_Inc_Portfolio
         */
        public function portfolio() {
            return G5Plus_Inc_Portfolio::getInstance();
        }

        public function getMetaPrefix() {
            if (function_exists('G5P')) {
                return G5P()->getMetaPrefix();
            }
            return 'gsf_april_';
        }
	}

	function g5Theme()
	{
		return G5Plus_Theme::getInstance();
	}

	g5Theme()->init();
}
