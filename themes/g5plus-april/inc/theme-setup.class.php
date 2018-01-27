<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Inc_Theme_Setup')) {
	class G5Plus_Inc_Theme_Setup {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init(){
			/**
			 * Make theme available for translation.
			 */
			load_theme_textdomain('g5plus-april', get_template_directory() . '/languages');

			// Add default posts and comments RSS feed links to head.
			add_theme_support('automatic-feed-links');

            add_theme_support('woocommerce');

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support('title-tag');

			/**
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			 */
			add_theme_support('post-thumbnails');

			/**
			 * Register Menu Location
			 */
            register_nav_menus(array(
                'primary' => esc_html__('Primary Menu', 'g5plus-april'),
                'left-menu' => esc_html__('Left Menu', 'g5plus-april'),
                'right-menu' => esc_html__('Right Menu', 'g5plus-april'),
                'mobile'  => esc_html__('Mobile Menu', 'g5plus-april'),
            ));

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support('html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			));

			/**
			 * Enable support for Post Formats.
			 * See https://developer.wordpress.org/themes/functionality/post-formats/
			 */
			add_theme_support('post-formats', array(
				'gallery',
				'video',
				'audio',
				'quote',
				'link'
			));

			// add image sizes


			add_theme_support("custom-header");
			add_theme_support("custom-background");
			add_theme_support('customize-selective-refresh-widgets');

            $editor_style = apply_filters('g5plus_editor_style',array(
                'assets/vendors/font-awesome/css/font-awesome.min.css',
                'assets/vendors/bootstrap/css/bootstrap.min.css',
                'assets/css/editor-style.css'
            ));
			add_editor_style($editor_style);

			$GLOBALS['content_width'] = apply_filters('g5plus_content_width', 1170);
		}
	}
}