<?php
/**
 *    Plugin Name: April Framework
 *    Plugin URI: http://g5plus.net
 *    Description: The April Framework plugin.
 *    Version: 2.1
 *    Author: g5plus
 *    Author URI: http://g5plus.net
 *
 *    Text Domain: april-framework
 *    Domain Path: /languages/
 *
 * @package G5Plus Framework
 * @category Core
 * @author g5plus
 *
 **/
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
// REMOVE WHEN DEPLOYMENT
require_once '_remove_when_deploy/dev.php';
if (!class_exists('G5Plus_Framework')) {
	class G5Plus_Framework {
		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Init plugin
		 */
		public function init() {
			/**
			 * Auto load libraries
			 */
			spl_autoload_register(array($this, 'incAutoload'));
			spl_autoload_register(array($this, 'coreAutoload'));
            spl_autoload_register(array($this, 'dashboardAutoload'));

            $this->hook()->init();
            $this->loadFile(G5P()->pluginDir('libs/smart-framework/smart-framework.php'));

            $this->cpt()->init();
            $this->core()->init();
            $this->configOptions()->init();
            $this->configMetaBox()->init();
            $this->configTermMeta()->init();
            $this->configUserMeta()->init();
            $this->widget()->init();
            $custom_post_type_disable = $this->options()->get_custom_post_type_disable();
            if(!in_array('portfolio', $custom_post_type_disable)) {
                $this->portfolio()->init();
            }

            add_action( 'plugins_loaded', array($this,'loadTextDomain'));
        }

		public function loadTextDomain() {
			load_plugin_textdomain( 'april-framework', false, $this->pluginDir('languages'));
		}

        public function includeFramework() {
            $this->loadFile(G5P()->pluginDir('libs/smart-framework/smart-framework.php'));
        }

        /**
		 * Get plugin url
		 *
		 * @param string $path
		 * @return string
		 */
		public function pluginUrl($path = '') {
			$plugin_dir = str_replace('\\', '/', trailingslashit(dirname(__FILE__)));
			$template_dir = str_replace('\\', '/', trailingslashit(get_template_directory()));
			if (strpos($plugin_dir, $template_dir) === false) {
				return trailingslashit(plugins_url($this->pluginName())) . $path;
			}

			$sub_template_dir = substr($plugin_dir, strlen($template_dir));
			return trailingslashit(get_template_directory_uri() . $sub_template_dir) . $path;
		}

		public function pluginName() {
			return 'april-framework';
		}

		/**
		 * Get Plugin Dir
		 *
		 * @param string $path
		 * @return string
		 */
		public function pluginDir($path = '') {
			return plugin_dir_path(__FILE__) . $path;
		}

		public function loadFile($path) {
			if ( $path && is_readable($path) ) {
				include_once($path);
				return true;
			}
			return false;
		}

		public function assetsHandle($handle = '') {
			return apply_filters('gsf_assets_prefix', 'gsf_') . $handle;
		}

		/**
		 * Auto load libraries included
		 *
		 * @param string $class Class name
		 */
		public function incAutoLoad($class) {
			$file_name = preg_replace('/^G5P_Inc_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile(G5P()->pluginDir("inc/{$file_name}.class.php"));
			}
		}

		/**
		 * Field auto loader
		 * @param $class
		 */
		public function coreAutoload($class)
		{
			$file_name = preg_replace('/^G5P_Core_/', '', $class);
			if ($file_name !== $class) {
				$file_name = strtolower($file_name);
				$file_name = str_replace('_', '-', $file_name);
				$this->loadFile(G5P()->pluginDir("core/{$file_name}/{$file_name}.class.php"));
			}
		}

        public function dashboardAutoload($class)
        {
            $file_name = preg_replace('/^G5P_Dashboard_/', '', $class);
            if ($file_name !== $class) {
                $file_name = strtolower($file_name);
                $file_name = str_replace('_', '-', $file_name);
                G5P()->loadFile(G5P()->pluginDir("core/dashboard/inc/{$file_name}.class.php"));
            }
        }



		/**
		 * Get Option Name
		 * @return string
		 */
		public function getOptionName() {
			return 'gsf_april_options';
		}

		/**
		 * Get Option Skin Name
		 * @return string
		 */
		public function getOptionSkinName() {
			return 'gsf_april_skin_options';
		}

		/**
		 * Get Meta Prefix
		 * @return string
		 */
		public function getMetaPrefix() {
			return 'gsf_april_';
		}

		public function pluginVer() {
			if (!function_exists('get_plugin_data')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			$plugin_data = get_plugin_data( __FILE__ );
			return $plugin_data['Version'];
		}

		/**
		 * @return G5P_Inc_Hook
		 */
		public function hook() {
			return G5P_Inc_Hook::getInstance();
		}

		/**
		 * GSF Assets
		 *
		 * @return G5P_Inc_Assets
		 */
		public function assets() {
			return G5P_Inc_Assets::getInstance();
		}

		/**
		 * @return G5P_Inc_Settings
		 */
		public function settings() {
			return G5P_Inc_Settings::getInstance();
		}

		/**
		 * @return G5P_Inc_Config_Options
		 */
		public function configOptions() {
			return G5P_Inc_Config_Options::getInstance();
		}

		/**
		 * @return G5P_Inc_Config_Meta_Boxes
		 */
		public function configMetaBox() {
			return G5P_Inc_Config_Meta_Boxes::getInstance();
		}

		/**
		 * @return G5P_Inc_Config_Term_Meta
		 */
		public function configTermMeta() {
			return G5P_Inc_Config_Term_Meta::getInstance();
		}

		/**
		 * @return G5P_Inc_Config_User_Meta
		 */
		public function configUserMeta() {
			return G5P_Inc_Config_User_Meta::getInstance();
		}

		/**
		 * @return G5P_Inc_Custom_Post_Type
		 */
		public function cpt() {
			return G5P_Inc_Custom_Post_Type::getInstance();
		}

		/**
		 * @return G5P_Inc_Options
		 */
		public function options() {
			return G5P_Inc_Options::getInstance();
		}

		/**
		 * @return G5P_Inc_Options_Skin
		 */
		public function optionsSkin() {
			return G5P_Inc_Options_Skin::getInstance();
		}

		/**
		 * @return G5P_Inc_MetaBox
		 */
		public function metaBox() {
			return G5P_Inc_MetaBox::getInstance();
		}

		/**
		 * @return G5P_Inc_MetaBox_Post
		 */
		public function metaBoxPost() {
			return G5P_Inc_MetaBox_Post::getInstance();
		}

		/**
		 * @return G5P_Inc_Term_Meta
		 */
		public function termMeta() {
			return G5P_Inc_Term_Meta::getInstance();
		}

		/**
		 * @return G5P_Inc_User_Meta
		 */
		public function userMeta() {
			return G5P_Inc_User_Meta::getInstance();
		}


		/**
		 * @return G5P_Inc_ShortCode
		 */
		public function shortCode() {
			return G5P_Inc_ShortCode::getInstance();
		}

		/**
		 * GSF helper function
		 * @return G5P_Inc_Helper
		 */
		public function helper() {
			return G5P_Inc_Helper::getInstance();
		}

        /**
         * GSF file function
         * @return G5P_Inc_File
         */
        public function file() {
            return G5P_Inc_File::getInstance();
        }

		/**
		 * GSF Core
		 * @return G5P_Core_Core
		 */
		public function core() {
			return G5P_Core_Core::getInstance();
		}

		/**
		 * @return G5P_Inc_Widget
		 */
		public function widget() {
			return G5P_Inc_Widget::getInstance();
		}

        /**
         * @return G5P_Inc_Portfolio
         */
        public function portfolio() {
            return G5P_Inc_Portfolio::getInstance();
        }

        /**
         * @return G5P_Inc_MetaBox_Portfolio
         */
        public function metaBoxPortfolio() {
            return G5P_Inc_MetaBox_Portfolio::getInstance();
        }

	}

	/**
	 * Get Plugin Object Instance
	 *
	 * @return G5Plus_Framework
	 */
	function G5P() {
		return G5Plus_Framework::getInstance();
	}

	/**
	 * Init Plugin
	 */
	G5P()->init();



}