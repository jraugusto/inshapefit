<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5P_Inc_Assets')) {
	class G5P_Inc_Assets {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function registerScript() {

			wp_register_script(G5P()->assetsHandle('template-vc'), G5P()->helper()->getAssetUrl('assets/js/template-vc.min.js'), array('jquery'), G5P()->pluginVer(), true);
            wp_register_script(G5P()->assetsHandle('admin-portfolio'), G5P()->helper()->getAssetUrl('assets/js/admin-portfolio.min.js'), array('jquery'), G5P()->pluginVer(), true);
		}
		public function registerStyle() {

			/**
			 * Framework style
			 */
			wp_register_style(G5P()->assetsHandle('template-vc'), G5P()->helper()->getAssetUrl('assets/css/template-vc.min.css'), array(), G5P()->pluginVer());
			wp_register_style(G5P()->assetsHandle('admin-bar'), G5P()->helper()->getAssetUrl('assets/css/admin-bar.min.css'), array(), G5P()->pluginVer());
            wp_register_style(G5P()->assetsHandle('admin-portfolio'), G5P()->helper()->getAssetUrl('assets/css/admin-portfolio.min.css'), array(), G5P()->pluginVer());
		}


	}
}