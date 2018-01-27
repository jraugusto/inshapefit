<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Inc_Register_Sidebar')) {
	class G5Plus_Inc_Register_Sidebar {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init(){
			$sidebars = array(
				array(
					'id' => 'main',
					'name' => esc_html__('Main', 'g5plus-april'),
				),
				array(
					'name' => esc_html__("Top Bar Left", 'g5plus-april'),
					'id' => 'top_bar_left',
				),
				array(
					'name' => esc_html__("Top Bar Right", 'g5plus-april'),
					'id' => 'top_bar_right',
				),
				array(
					'name' => esc_html__("Footer 1", 'g5plus-april'),
					'id' => 'footer_1',
				),
				array(
					'name' => esc_html__("Footer 2", 'g5plus-april'),
					'id' => 'footer_2',
				),
				array(
					'name' => esc_html__("Footer 3", 'g5plus-april'),
					'id' => 'footer_3',
				),
				array(
					'name' => esc_html__("Footer 4", 'g5plus-april'),
					'id' => 'footer_4',
				),
				array(
					'name' => esc_html__("Bottom Bar Left", 'g5plus-april'),
					'id' => 'bottom_bar_left',
				),
				array(
					'name' => esc_html__("Bottom Bar Right", 'g5plus-april'),
					'id' => 'bottom_bar_right',
				),
				array(
					'name' => esc_html__("Canvas", 'g5plus-april'),
					'id' => 'canvas',
				),
                array(
                    'name' => esc_html__("Woocommerce Filter", 'g5plus-april'),
                    'id' => 'woocommerce-filter',
                )
			);
			foreach ($sidebars as $sidebar) {
				register_sidebar(array(
					'name' => $sidebar['name'],
					'id' => $sidebar['id'],
					'description' => isset($sidebar['description']) ? $sidebar['description'] : sprintf(esc_html__('Add widgets here to appear in %s sidebar', 'g5plus-april'), $sidebar['name']),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget' => '</aside>',
					'before_title' => '<h4 class="widget-title"><span>',
					'after_title' => '</span></h4>',
				));
			}
		}
	}
}