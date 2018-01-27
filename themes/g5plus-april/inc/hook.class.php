<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Inc_Hook')) {
	class G5Plus_Inc_Hook {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
		public function init() {
			$this->addAction();
			$this->addFilter();
		}

		private function addAction() {
			/**
			 * Initialize Theme
			 */
			add_action('after_setup_theme', array(g5Theme()->themeSetup(), 'init'));

			/**
			 * Required Plugins
			 */
			add_action('tgmpa_register', array(g5Theme()->requirePlugin(), 'init'));

			/**
			 * Register Sidebar
			 */
			add_action('widgets_init', array(g5Theme()->registerSidebar(), 'init'));

			add_action('init',array(g5Theme()->assets(),'registerAssets'));

			/**
			 * Enqueue FrontEnd Resource
			 */
			add_action('wp_enqueue_scripts', array(g5Theme()->assets(), 'enqueueAssets'),99);
            add_action('wp_enqueue_scripts',array(g5Theme()->assets(),'enqueue_icon_font'));
            add_action('wp_enqueue_scripts',array(g5Theme()->assets(),'getCustomCss'),100);
            add_action('wp_footer', array(g5Theme()->assets(), 'custom_script'));


			/**
			 * Head Meta
			 * *******************************************************
			 */
			add_action('wp_head',array(g5Theme()->templates(),'head_meta'), 0);

			/**
			 * Social Meta
			 * *******************************************************
			 */
			add_action('wp_head', array(g5Theme()->templates(),'social_meta'), 5);

			/**
			 * Search Popup
			 * *******************************************************
			 */
			add_action('wp_ajax_nopriv_search_popup', array(g5Theme()->ajax(),'search_result'));
			add_action('wp_ajax_search_popup', array(g5Theme()->ajax(),'search_result'));

			/**
			 * Load Posts
			 * *******************************************************
			 */
			add_action('wp_ajax_nopriv_pagination_ajax', array(g5Theme()->ajax(),'pagination_ajax_response'));
			add_action('wp_ajax_pagination_ajax', array(g5Theme()->ajax(),'pagination_ajax_response'));

            /**
             * Login, Register
             */
            add_action('wp_ajax_nopriv_gsf_user_login', array(g5Theme()->ajax(), 'gsf_user_login_callback'));
            add_action('wp_ajax_gsf_user_login', array(g5Theme()->ajax(), 'gsf_user_login_callback'));
            add_action('wp_ajax_nopriv_gsf_user_login_ajax', array(g5Theme()->ajax(), 'gsf_user_login_ajax_callback'));
            add_action('wp_ajax_gsf_user_login_ajax', array(g5Theme()->ajax(), 'gsf_user_login_ajax_callback'));
            add_action('wp_ajax_nopriv_gsf_user_sign_up', array(g5Theme()->ajax(), 'gsf_user_sign_up_callback'));
            add_action('wp_ajax_gsf_user_sign_up', array(g5Theme()->ajax(), 'gsf_user_sign_up_callback'));
            add_action('wp_ajax_nopriv_gsf_user_sign_up_ajax', array(g5Theme()->ajax(), 'gsf_user_sign_up_ajax_callback'));
            add_action('wp_ajax_gsf_user_sign_up_ajax', array(g5Theme()->ajax(), 'gsf_user_sign_up_ajax_callback'));

            /**
             * Product Quickview
             */
            add_action( 'wp_ajax_nopriv_product_quick_view', array(g5Theme()->ajax(),'popup_product_quick_view'));
            add_action( 'wp_ajax_product_quick_view', array(g5Theme()->ajax(),'popup_product_quick_view') );


            // Portfolio Show Gallery
            add_action( 'wp_ajax_nopriv_portfolio_gallery', array(g5Theme()->ajax(),'portfolio_gallery'));
            add_action( 'wp_ajax_portfolio_gallery', array(g5Theme()->ajax(),'portfolio_gallery') );

            /**
			 * Site Loading Template
			 * *******************************************************
			 */
			add_action('g5plus_before_page_wrapper',array(g5Theme()->templates(),'site_loading'),5);

			/**
			 * Top Drawer Template
			 * *******************************************************
			 */
			add_action('g5plus_before_page_wrapper_content',array(g5Theme()->templates(),'top_drawer'),10);

			/**
			 * Header Template
			 * *******************************************************
			 */
			add_action('g5plus_before_page_wrapper_content',array(g5Theme()->templates(),'header'),15);



			/**
			 * Content Wrapper Start Template
			 * *******************************************************
			 */
			add_action('g5plus_main_wrapper_content_start',array(g5Theme()->templates(),'content_wrapper_start'),1);

			/**
			 * Content Wrapper End Template
			 * *******************************************************
			 */
			add_action('g5plus_main_wrapper_content_end',array(g5Theme()->templates(),'content_wrapper_end'),1);

			/**
			 * Back To Top Template
			 * *******************************************************
			 */
			add_action('g5plus_after_page_wrapper',array(g5Theme()->templates(),'back_to_top'),5);

			/**
			 * Page Title Template
			 * *******************************************************
			 */
			add_action('g5plus_before_main_content',array(g5Theme()->templates(),'page_title'),5);

			/**
			 * Footer
			 * *******************************************************
			 */
			add_action('g5plus_after_page_wrapper_content',array(g5Theme()->templates(),'footer'),5);

			/**
			 * Blog
			 * *******************************************************
			 */
			add_action('g5plus_before_post_image',array(g5Theme()->templates(),'zoom_image_thumbnail'));
			add_action('g5plus_after_archive_wrapper',array(g5Theme()->blog(),'pagination_markup'));
			//add_action('g5plus_before_archive_wrapper',array(g5Theme()->blog(),'category_filter_markup'));
			add_action('g5plus_after_archive_post',array(g5Theme()->blog(),'archive_ads_markup'));


			add_action( 'pre_get_posts', array( g5Theme()->query(), 'pre_get_posts' ) );

			/**
			 * Single Blog
			 * *******************************************************
			 */
			add_action('g5plus_after_single_post',array(g5Theme()->templates(),'post_single_tag'),5);
			add_action('g5plus_after_single_post',array(g5Theme()->templates(),'post_single_share'),10);
            add_action('g5plus_after_single_post',array(g5Theme()->templates(),'post_single_author_info'),15);
			add_action('g5plus_after_single_post',array(g5Theme()->templates(),'post_single_navigation'),20);
			add_action('g5plus_after_single_post',array(g5Theme()->templates(),'post_single_related'),25);
			add_action('g5plus_after_single_post',array(g5Theme()->templates(),'post_single_comment'),30);
			//add_action('g5plus_main_wrapper_content_end',array(g5Theme()->templates(),'post_single_comment'),30);
            add_action('wp_footer',array(g5Theme()->templates(),'post_single_reading_process'));

			/**
			 * Single Page
			 * *******************************************************
			 */
			add_action('g5plus_after_single_page',array(g5Theme()->templates(),'post_single_comment'),30);

			add_action('wp_head',array(g5Theme()->assets(),'enqueueSubMenuAssets'));
		}

		private function addFilter() {
			// add icon font
			add_filter('gsf_font_icon_assets', array(g5Theme()->fontIcons(), 'registerAssets'));
			add_filter('gsf_font_icon_config', array(g5Theme()->fontIcons(), 'registerConfig'));

			add_filter('body_class',array(g5Theme()->helper(),'body_class'));
			add_filter('get_the_excerpt',array(g5Theme()->helper(),'excerpt'),100);
			add_filter('gsf_extra_class',array(g5Theme()->helper(),'extra_class'));
			add_filter('widget_categories_args', array(g5Theme()->helper(),'widget_categories_args'));
			add_filter('wp_list_categories',array(g5Theme()->helper(),'cat_count_span'),10,2);
			add_filter('get_archives_link', array(g5Theme()->helper(),'archive_count_span'));

			add_filter('wp_nav_menu_args', array(g5Theme()->helper(), 'main_menu_one_page'), 20);
			/*$lazy_load_images = g5Theme()->options()->get_lazy_load_images();
			if ($lazy_load_images === 'on') {
				add_filter( 'post_thumbnail_html', array(g5Theme()->helper(),'post_thumbnail_lazyLoad'), 10, 3 );
				add_filter('the_content',array(g5Theme()->helper(),'content_lazyLoad'));

			}*/

            add_filter('xmenu_submenu_transition', array($this, 'menuTransition'), 20,2);
			add_filter('xmenu_submenu_class',array($this,'subMenuSkin'),10,2);
            add_filter('gpl_spinner_color',array($this,'postLikeSpinnerColor'));
		}

		public function menuTransition($transition,$args) {
            if (isset($args->main_menu)) {
                $transition = g5Theme()->options()->get_menu_transition();
            }
		    return $transition;
        }

		public function subMenuSkin($classes,$args) {
		    if (isset($args->main_menu)) {
                $sub_menu_skin = g5Theme()->options()->get_sub_menu_skin();
                $classes[] = "gf-skin {$sub_menu_skin}";;
            }
			return $classes;
		}

        public function postLikeSpinnerColor() {
            return g5Theme()->options()->get_accent_color();
        }
	}
}
