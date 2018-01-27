<?php
/**
 * Class Defined Templates
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!class_exists('G5Plus_Inc_Templates')) {
	class G5Plus_Inc_Templates {

		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Template Site Loading
		 */
		public function site_loading() {
			g5Theme()->helper()->getTemplate('site-loading');
		}

		/**
		 * Template Top Drawer
		 */
		public function top_drawer() {
			g5Theme()->helper()->getTemplate('top-drawer');
		}

		/**
		 * Template Header
		 */
		public function header() {
			g5Theme()->helper()->getTemplate('header');
		}

		/**
		 * Template Search Popup
		 */
		public function search_popup() {
			g5Theme()->helper()->getTemplate('popup/search');
		}

		/**
		 * Template Canvas Sidebar
		 */
		public function canvas_sidebar() {
			g5Theme()->helper()->getTemplate('canvas-sidebar');
		}

		/**
		 * Template Content Wrapper Start
		 */
		public function content_wrapper_start() {
			g5Theme()->helper()->getTemplate('global/wrapper-start');
		}

		/**
		 * Template Content Wrapper End
		 */
		public function content_wrapper_end() {
			g5Theme()->helper()->getTemplate('global/wrapper-end');
		}

		/**
		 * Template Back To Top
		 */
		public function back_to_top() {
			g5Theme()->helper()->getTemplate('back-to-top');
		}

		/**
		 * Template Page Title
		 */
		public function page_title() {
			g5Theme()->helper()->getTemplate('page-title');
		}

		/**
		 * Head Meta
		 */
		public function head_meta() {
			g5Theme()->helper()->getTemplate('head/head-meta');
		}

		/**
		 * Social Meta
		 */
		public function social_meta() {
			g5Theme()->helper()->getTemplate('head/social-meta');
		}

		/**
		 * Footer
		 */
		public function footer() {
			g5Theme()->helper()->getTemplate('footer');
		}

		/**
		 * Get Template Social Network
		 *
		 * @param array $social_networks
		 * @param string $layout - The layout of social network. Accepts 'classic', 'circle', 'square'
		 */
		public function social_networks($social_networks = array(),$layout = 'classic',$size = 'normal') {
			g5Theme()->helper()->getTemplate('social-networks',array('social_networks' => $social_networks, 'layout' => $layout, 'size' => $size));
		}


		public function zoom_image_thumbnail($args)
		{
			g5Theme()->helper()->getTemplate('loop/zoom-image', $args);
		}


		public function post_single_tag() {
			g5Theme()->helper()->getTemplate('single/post-tag');
		}

		public function post_single_share() {
			g5Theme()->helper()->getTemplate('single/post-share');
		}

		public function post_single_navigation(){
			g5Theme()->helper()->getTemplate('single/post-navigation');
		}

		public function post_single_author_info() {
			g5Theme()->helper()->getTemplate('single/post-author-info');
		}

		public function post_single_related() {
			g5Theme()->helper()->getTemplate('single/post-related');
		}

		public function post_single_comment(){
			g5Theme()->helper()->getTemplate('single/post-comment');
		}

		public function post_single_image() {
			g5Theme()->helper()->getTemplate('single/post-image');
		}

		public function mobile_navigation() {
			g5Theme()->helper()->getTemplate('header/mobile/navigation');
		}

		public function canvas_overlay() {
			g5Theme()->helper()->getTemplate('canvas-overlay');
		}

        public function post_view() {
            g5Theme()->helper()->getTemplate('loop/post-view');
        }

        public function post_like() {
            g5Theme()->helper()->getTemplate('loop/post-like');
        }

        /**
         * Template Canvas Filter
         */
        public function canvas_filter() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/canvas-woocommerce-filter');
        }


		public function userSocialNetworks($userId,$layout = '') {
			g5Theme()->helper()->getTemplate('user-social-networks', array('userId' => $userId,'layout' => $layout));
		}

        public function post_single_reading_process() {
            g5Theme()->helper()->getTemplate('single/post-reading-process');
        }

        public function shop_catalog_filter() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/catalog-filter');
        }

        public function shop_loop_product_title() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/title' );
        }

        public function shop_loop_product_cat() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/product-cat' );
        }

        function shop_loop_quick_view() {
            g5Theme()->helper()->getTemplate( 'woocommerce/loop/quick-view' );
        }

        public function shop_loop_compare() {
            if (in_array('yith-woocommerce-compare/init.php', apply_filters('active_plugins', get_option('active_plugins'))) && get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
                if (!shortcode_exists('yith_compare_button') && class_exists('YITH_Woocompare') && function_exists('yith_woocompare_constructor')) {
                    $context = isset($_REQUEST['context']) ? $_REQUEST['context'] : null;
                    $_REQUEST['context'] = 'frontend';
                    yith_woocompare_constructor();
                    $_REQUEST['context'] = $context;
                }


                global $yith_woocompare;
                if ( isset($yith_woocompare) && isset($yith_woocompare->obj)) {
                    remove_action( 'woocommerce_after_shop_loop_item', array($yith_woocompare->obj,'add_compare_link'), 20 );
                }

                echo do_shortcode('[yith_compare_button container="false" type="link"]');
            }
        }

        public function shop_loop_add_to_cart(){
            $product_add_to_cart_enable = g5Theme()->options()->get_product_add_to_cart_enable();
            if ('on' === $product_add_to_cart_enable) {
                global $product;
                echo '<div class="product-action-item add_to_cart_tooltip" data-toggle="tooltip" data-original-title="'.$product->add_to_cart_text().'">';
                woocommerce_template_loop_add_to_cart(array(
                    'class'    => implode( ' ', array_filter( array(
                        'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'product_out_of_stock',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
                    ) ) )
                ));
                echo '</div>';
            }
        }

        public function shop_loop_list_add_to_cart(){
            $product_add_to_cart_enable = g5Theme()->options()->get_product_add_to_cart_enable();
            if ('on' === $product_add_to_cart_enable) {
                global $product;
                echo '<div class="product-action-item">';
                woocommerce_template_loop_add_to_cart(array(
                    'class'    => implode( ' ', array_filter( array(
                        'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'product_out_of_stock',
                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
                    ) ) )
                ));
                echo '</div>';
            }
        }

        public function shop_loop_sale_count_down() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/sale-count-down', array('is_single'=> false));
        }

        public function shop_single_loop_sale_count_down() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/sale-count-down', array('is_single'=> true));
        }

        public function shop_loop_wishlist() {
            if (in_array('yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option('active_plugins'))) && (get_option( 'yith_wcwl_enabled' ) == 'yes')) {
                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
            }
        }

        public function shop_single_function() {
            g5Theme()->helper()->getTemplate('woocommerce/single/product-functions');
        }

        public function shop_show_product_images_layout_2() {
            g5Theme()->helper()->getTemplate('woocommerce/single/product-image-2');
        }

        public function shop_show_product_images_layout_3() {
            g5Theme()->helper()->getTemplate('woocommerce/single/product-image-3');
        }

        public function shop_single_top() {
            g5Theme()->helper()->getTemplate('woocommerce/single/product-single-top');
        }

        public function portfolio_single_top() {
            g5Theme()->helper()->getTemplate('portfolio/single/portfolio-single-top');
        }

        public function shop_loop_single_gallery() {
            g5Theme()->helper()->getTemplate('woocommerce/single/product-gallery');
        }

        public function shop_loop_quick_view_product_title() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/title');
        }

        public function quick_view_show_product_images() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/product-image');
        }

        public function quickview_rating() {
            g5Theme()->helper()->getTemplate('woocommerce/loop/rating');
        }

        public function shop_loop_rating() {
            wc_get_template('loop/rating.php');
        }
	}
}