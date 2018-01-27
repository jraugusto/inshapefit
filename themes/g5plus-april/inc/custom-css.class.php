<?php
/**
 * Custom Css In Page
 *
 * Add custom css any where and render it on footer (wp-footer)
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if (!class_exists('G5Plus_Inc_Custom_Css')) {
	class G5Plus_Inc_Custom_Css
	{
		private $_custom_css = array();
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Plugin construct
		 */
		public function init()
		{
            add_action('wp_footer', array($this, 'render_custom_css'),10);
		}

		/**
		 * Add custom css
		 *
		 * @param $css
		 * @param string $key (default: '')
		 */
		public function addCss($css, $key = '')
		{
			if ($key === '') {
				$this->_custom_css[] = $css;
			} else {
				$this->_custom_css[$key] = $css;
			}
		}

		/**
		 * Get Custom Css
		 *
		 * @return string
		 */
		public function getCss()
		{
			$css ='   ' . implode('', $this->_custom_css);
			return preg_replace('/\r\n|\n|\t/','',$css);
		}
        public function render_custom_css() {
            wp_register_style( g5Theme()->helper()->assetsHandle('custom-style'), false);
            wp_enqueue_style( g5Theme()->helper()->assetsHandle('custom-style'));
            wp_add_inline_style( g5Theme()->helper()->assetsHandle('custom-style'), $this->getCss() );
        }
	}
}