<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Inc_Woocommerce')) {
    class G5Plus_Inc_Woocommerce {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init(){
            $this->filter();
            $this->hook();
        }

        public function filter() {
            add_filter('gsf_shorcodes', array($this, 'register_shortcode'));

            //page title
            add_filter('g5plus_page_title',array($this,'page_title'));

            add_filter('g5plus_post_layout_matrix',array($this,'layout_matrix'));

            // remove shop page title
            add_filter('woocommerce_show_page_title','__return_false');

            add_filter('woocommerce_product_description_heading','__return_false');
            add_filter('woocommerce_product_additional_information_heading','__return_false');
            add_filter('woocommerce_product_review_heading','__return_false');

            // single product related
            add_filter('woocommerce_output_related_products_args', array($this, 'product_related_products_args'));
            add_filter('woocommerce_product_related_posts_relate_by_category',array($this, 'product_related_posts_relate_by_category'));
            add_filter('woocommerce_product_related_posts_relate_by_tag',array($this, 'product_related_posts_relate_by_tag'));

            add_filter('woocommerce_output_related_products_args', array($this, 'product_related_posts_per_page'));

            add_filter('woocommerce_upsells_total', array($this, 'product_up_sells_posts_per_page'));

            // Cross sells
            add_filter('woocommerce_cross_sells_total', array($this, 'product_cross_sells_posts_per_page'));
        }

        public function hook() {
            // remove woocommerce sidebar
            remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

            // remove Breadcrumb
            remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);

            // remove archive description
            remove_action('woocommerce_archive_description','woocommerce_taxonomy_archive_description',10);
            remove_action('woocommerce_archive_description','woocommerce_product_archive_description',10);

            // remove result count and catalog ordering
            remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
            remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

            // remove pagination
            //remove_action('woocommerce_after_shop_loop','woocommerce_pagination',10);

            // remove product link close
            remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
            remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);

            //remove add to cart
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

            // remove product thumb
            remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10);

            // remove product title
            remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);

            // remove product rating
            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);

            // remove compare button
            global $yith_woocompare;
            if ( isset($yith_woocompare) && isset($yith_woocompare->obj)) {
                remove_action( 'woocommerce_after_shop_loop_item', array($yith_woocompare->obj,'add_compare_link'), 20 );
                remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
            }

            add_action('pre_get_posts',array($this,'changePostPerPage'),7);


            // product cat
            add_action('woocommerce_shop_loop_item_title',array(g5Theme()->templates(),'shop_loop_product_cat'),10);

            // product title
            add_action('woocommerce_shop_loop_item_title',array(g5Theme()->templates(),'shop_loop_product_title'),10);

            // product rating
            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',15);

            // Product description
            add_action('woocommerce_after_shop_loop_item_title', array($this, 'shop_loop_product_excerpt'),20);

            // product wishlist
            add_action('woocommerce_before_shop_loop_item_title',array(g5Theme()->templates(),'shop_loop_wishlist'),10);

            // Sale count down
            add_action('woocommerce_before_shop_loop_item_title',array(g5Theme()->templates(),'shop_loop_sale_count_down'),10);

            // product actions
            add_action('g5plus_woocommerce_product_actions',array(g5Theme()->templates(),'shop_loop_quick_view'),5);
            add_action('g5plus_woocommerce_product_actions',array(g5Theme()->templates(),'shop_loop_add_to_cart'),10);
            add_action('g5plus_woocommerce_product_actions',array(g5Theme()->templates(),'shop_loop_compare'),15);

            // Product List actions
            add_action( 'g5plus_woocommerce_shop_loop_list_info',array(g5Theme()->templates(),'shop_loop_list_add_to_cart'),10 );
            add_action( 'g5plus_woocommerce_shop_loop_list_info',array(g5Theme()->templates(),'shop_loop_quick_view'),15 );
            add_action( 'g5plus_woocommerce_shop_loop_list_info',array(g5Theme()->templates(),'shop_loop_compare'),20 );

            // single product
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

            add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_loop_sale_flash', 10);
            add_action('woocommerce_single_product_summary',array(g5Theme()->templates(),'shop_loop_rating'),10);
            add_action('woocommerce_single_product_summary',array(g5Theme()->templates(),'shop_single_loop_sale_count_down'),15);
            add_action('woocommerce_single_product_summary',array(g5Theme()->templates(),'shop_single_function'),60);



            add_action('wp_head', array($this, 'shop_single_layout'), 10);

            // single product gallery
            add_action('g5plus_april_show_product_gallery', array(g5Theme()->templates(), 'shop_loop_single_gallery'), 10);

            // Quick view
            add_action( 'wp_footer', array( $this, 'quick_view' ));

            add_action('woocommerce_before_quick_view_product_summary','woocommerce_show_product_loop_sale_flash',10);
            add_action('woocommerce_before_quick_view_product_summary',array(g5Theme()->templates(),'quick_view_show_product_images'),20);

            add_action('woocommerce_quick_view_product_summary', array(g5Theme()->templates(),'shop_loop_quick_view_product_title'),5);
            add_action('woocommerce_quick_view_product_summary',array(g5Theme()->templates(),'quickview_rating'),10);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_price',10);
            add_action('woocommerce_quick_view_product_summary',array(g5Theme()->templates(),'shop_single_loop_sale_count_down'),15);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_excerpt',20);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_meta',40);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_sharing',50);
            add_action('woocommerce_quick_view_product_summary',array(g5Theme()->templates(),'shop_single_function'),60);

            // Cart
            add_action('init', array($this, 'woocommerce_clear_cart_url'));
            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
            add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display',20 );
            add_action('woocommerce_before_cart_totals','woocommerce_shipping_calculator',5);

            // Shortcode Product singular
            add_action('april_product_singular_sale_flash', 'woocommerce_show_product_loop_sale_flash', 10);
            add_action('april_product_singular_product_actions',array(g5Theme()->templates(),'shop_loop_quick_view'),5);
            add_action('april_product_singular_product_actions',array(g5Theme()->templates(),'shop_loop_add_to_cart'),10);
            add_action('april_product_singular_product_actions',array(g5Theme()->templates(),'shop_loop_compare'),15);

        }

        public function register_shortcode($shortcodes) {
            $shortcodes = array_merge($shortcodes, array(
                'gsf_products',
                'gsf_products_index',
                'gsf_product_singular',
                'gsf_product_tabs',
                'gsf_shop_category'
            ));
            sort($shortcodes);
            return $shortcodes;
        }

        public function changePostPerPage($q) {
            if (!is_admin() && $q->is_main_query() && ($q->is_post_type_archive( 'product' ) || $q->is_tax( get_object_taxonomies( 'product' )))) {
                $woocommerce_customize = g5Theme()->options()->get_woocommerce_customize();
                if(!isset($woocommerce_customize['disable']) || !array_key_exists('items-show', $woocommerce_customize['disable'])) {
                    $product_per_page = g5Theme()->options()->get_woocommerce_customize_item_show();
                } else {
                    $product_per_page = g5Theme()->options()->get_product_per_page();
                }

                if(!empty($product_per_page)) {
                    $product_per_page_arr = explode(",", $product_per_page);
                } else {
                    $product_per_page_arr = array(intval(get_option( 'posts_per_page')));
                }
                $product_per_page = isset( $_GET['product_per_page'] ) ? wc_clean( $_GET['product_per_page'] ) : $product_per_page_arr[0];

                $q->set('posts_per_page',$product_per_page);
            }
        }

        /**
         * Get Post Layout Settings
         *
         * @return mixed
         */
        public function get_layout_settings()
        {
            $catalog_layout = g5Theme()->options()->get_product_catalog_layout();
            $product_item_skin = g5Theme()->options()->get_product_item_skin();
            return array(
                'post_layout'            => $catalog_layout,
                'product_item_skin'     => $product_item_skin,
                'post_columns'           => array(
                    'lg' => intval(g5Theme()->options()->get_product_columns()),
                    'md' => intval(g5Theme()->options()->get_product_columns_md()),
                    'sm' => intval(g5Theme()->options()->get_product_columns_sm()),
                    'xs' => intval(g5Theme()->options()->get_product_columns_xs()),
                    'mb' => intval(g5Theme()->options()->get_product_columns_mb()),
                ),
                'post_columns_gutter'    => intval(g5Theme()->options()->get_product_columns_gutter()),
                'post_image_size'        => g5Theme()->options()->get_product_image_size(),
                'post_paging'            => g5Theme()->options()->get_product_paging(),
                'post_animation'         => g5Theme()->options()->get_product_animation(),
                'itemSelector'           => 'article',
                'category_filter_enable' => false,
                'post_type' => 'product',
                'taxonomy'               => 'product_cat'
            );
        }


        public function layout_matrix($matrix) {
            $post_settings = g5Theme()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'product') {
                $post_settings = g5Theme()->woocommerce()->get_layout_settings();
            }
            $columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
                'lg' => 3,
                'md' => 3,
                'sm' => 2,
                'xs' => 1,
                'mb' => 1
            );
            $columns = g5Theme()->helper()->get_bootstrap_columns($columns);
            $columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 30);
            $image_size = isset($post_settings['post_image_size']) ? $post_settings['post_image_size'] : 'medium';
            $matrix['product'] = array(
                'list'    => array(
                    'image_size' => 'shop_catalog',
                    'columns_gutter' => $columns_gutter,
                    'layout'             => array(
                        array('columns' => $columns, 'template' => 'content-product'),
                    )
                ),
                'grid'           => array(
                    'placeholder_enable' => true,
                    'columns_gutter' => $columns_gutter,
                    'image_size' => 'shop_catalog',
                    /*'isotope'        => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'fitRows',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                    ),*/
                    'layout'         => array(
                        array('columns' => $columns, 'template' => 'content-product')
                    )
                ),
                'metro-01' => array(
                    'columns_gutter'     => $columns_gutter,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '2x1'),

                    )
                ),
                'metro-02' => array(
                    'columns_gutter'     => $columns_gutter,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '2x1'),

                    )
                ),
                'metro-03' => array(
                    'columns_gutter'     => $columns_gutter,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                    )
                ),
                'metro-04' => array(
                    'columns_gutter'     => $columns_gutter,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                    )
                ),
                'metro-05' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => $image_size,
                    'isotope' =>  array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1')
                    )
                ),
                'metro-06' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => $image_size,
                    'isotope' =>  array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'layout' => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 2,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 2,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),

                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 2,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 2,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 6,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                    )
                ),
            );
            return $matrix;
        }

        public function get_product_class() {
            $settings = g5Theme()->blog()->get_layout_settings();
            if ($settings['post_type'] !== 'product') {
                $settings = g5Theme()->woocommerce()->get_layout_settings();
            }
            $product_item_skin = isset($settings['product_item_skin'] ) ? $settings['product_item_skin'] : '';
            $post_classes = array(
                'clearfix',
                'product-item-wrap',
                'product-grid',
                $product_item_skin
            );
            if ( !isset( $settings['carousel'] ) || isset($settings['carousel_rows']) ) {
                if ( isset($settings['columns']) && ($settings['columns'] !== '') && !isset($settings['isMainQuery'])) {
                    $columns_lg = absint($settings['columns']);
                    $columns = array(
                        'lg' => $columns_lg,
                        'md' => $columns_lg > 4 ? 3 : $columns_lg,
                        'sm' => $columns_lg > 2 ? 2 : $columns_lg,
                        'xs' => 1,
                        'mb' => 1
                    );
                } else {
                    $columns = isset($settings['post_columns']) ? $settings['post_columns'] : array(
                        'lg' => 3,
                        'md' => 3,
                        'sm' => 2,
                        'xs' => 1,
                        'mb' => 1
                    );
                }
                $columns = g5Theme()->helper()->get_bootstrap_columns($columns);
                $post_classes[] = $columns;
            }
            return implode(' ', $post_classes);
        }

        public function get_product_inner_class() {
            $post_settings = g5Theme()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'product') {
                $post_settings = g5Theme()->woocommerce()->get_layout_settings();
            }
            $post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';

            $post_inner_classes = array(
                'product-item-inner',
                'clearfix',
                g5Theme()->helper()->getCSSAnimation( $post_animation )
            );
            return implode( ' ', array_filter( $post_inner_classes ) );
        }

        public function render_product_thumbnail_markup($args = array()){
            $defaults = array(
                'post_id'            => get_the_ID(),
                'image_size'         => 'shop_catalog',
                'placeholder_enable' => true,
                'image_mode'         => 'image',
                'display_permalink' => true,
            );
            $defaults = wp_parse_args($args, $defaults);
            g5Theme()->helper()->getTemplate('woocommerce/loop/product-thumbnail', $defaults);
        }

        public function shop_loop_product_excerpt(){
            global $post;
            if ( ! $post->post_excerpt ) {
                return;
            }
            ?>
            <div class="product-description">
                <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
            </div>
            <?php
        }

        public function archive_markup($query_args = null, $settings = null) {
            global $wp_query;
            if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

            if (!isset($query_args)) {
                $settings['isMainQuery'] = true;
            }
            $settings = wp_parse_args($settings,$this->get_layout_settings());
            g5Theme()->blog()->set_layout_settings($settings);

             if (isset($query_args)) {
                 $query_args = g5Theme()->query()->get_main_query_vars($query_args);
                 $is_category  = is_category();
                 query_posts($query_args);
                 $wp_query->is_category = $is_category;
             }

             if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                 add_action('g5plus_before_archive_wrapper',array(g5Theme()->templates(),'shop_catalog_filter'),5);
             }


            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                add_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['tabs'])) {
                add_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'tabs_markup'));
            }

             //if (have_posts()) {
                 if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                     /**
                      * woocommerce_before_shop_loop hook.
                      *
                      * @hooked wc_print_notices - 10
                      */
                     do_action( 'woocommerce_before_shop_loop' );
                 }

                 woocommerce_product_loop_start();

                if (have_posts()) {
                    if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                        woocommerce_product_subcategories(array('force_display' => true));
                    }

                    $post_settings = &g5Theme()->blog()->get_layout_settings();
                    $post_layout = isset( $post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'grid';
                    $item_skin = isset( $post_settings['product_item_skin'] ) ? $post_settings['product_item_skin'] : 'product-skin-01';
                    if(!in_array($post_layout, array('grid', 'list'))) {
                        $item_skin = '';
                    }
                    $layout_matrix = g5Theme()->blog()->get_layout_matrix( $post_layout );
                    $post_paging = isset( $post_settings['post_paging'] ) ? $post_settings['post_paging'] : 'pagination';
                    $post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';
                    $placeholder_enable = isset( $layout_matrix['placeholder_enable'] ) ? $layout_matrix['placeholder_enable'] : false;
                    $paged = $wp_query->get( 'page' ) ? intval( $wp_query->get( 'page' ) ) : $wp_query->get( 'paged' ) ? intval( $wp_query->get( 'paged' ) ) : 1;
                    $image_size = isset($post_settings['image_size']) ? $post_settings['image_size'] : isset($layout_matrix['image_size']) ? $layout_matrix['image_size'] :  'shop_catalog';

                    $image_size_base = $image_size;
                    $image_ratio = '';
                    if (in_array($post_layout, array('grid','metro-01','metro-02','metro-03','metro-04','metro-05','metro-06')) && ($image_size === 'full')) {
                        $image_ratio = isset($post_settings['image_ratio']) ? $post_settings['image_ratio'] : '';
                        if (empty($image_ratio)) {
                            $image_ratio = g5Theme()->options()->get_product_image_ratio();
                        }

                        if ($image_ratio === 'custom') {
                            $image_ratio_custom = isset($post_settings['image_ratio_custom']) ? $post_settings['image_ratio_custom'] : g5Theme()->options()->get_product_image_ratio_custom();
                            if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
                                $image_ratio_custom_width = intval($image_ratio_custom['width']);
                                $image_ratio_custom_height = intval($image_ratio_custom['height']);
                                if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
                                    $image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
                                }
                            } elseif (preg_match('/x/',$image_ratio_custom)) {
                                $image_ratio = $image_ratio_custom;
                            }
                        }

                        if ($image_ratio === 'custom') {
                            $image_ratio = '1x1';
                        }
                    }

                    $image_ratio_base = $image_ratio;

                    if ( isset( $layout_matrix['layout'] ) ) {
                        $layout_settings = $layout_matrix['layout'];
                        $index = intval( $wp_query->get( 'index', 0 ) );

                        $post_classes = array(
                            'clearfix',
                            'product-item-wrap',
                            $item_skin
                        );

                        $post_inner_classes = array(
                            'product-item-inner',
                            'clearfix',
                            g5Theme()->helper()->getCSSAnimation( $post_animation )
                        );
                        $carousel_index = 0;
                        while ( have_posts() ) : the_post();
                            $index = $index % sizeof( $layout_settings );
                            $current_layout = $layout_settings[$index];
                            $isFirst = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
                            if ( $isFirst && ( $paged > 1 ) && in_array( $post_paging, array( 'load-more', 'infinite-scroll' ) ) ) {
                                if ( isset( $layout_settings[$index + 1] ) ) {
                                    $current_layout = $layout_settings[$index + 1];
                                } else {
                                    continue;
                                }
                            }
                            $post_inner_attributes = array();

                            if (isset($current_layout['layout_ratio'])) {
                                $layout_ratio = !empty($current_layout['layout_ratio']) ? $current_layout['layout_ratio'] : '1x1';
                                if ($image_size_base !== 'full') {
                                    $image_size = g5Theme()->helper()->get_metro_image_size($image_size_base,$layout_ratio,$layout_matrix['columns_gutter']);
                                } else {
                                    $image_ratio =  g5Theme()->helper()->get_metro_image_ratio($image_ratio_base,$layout_ratio);
                                }
                                $post_inner_attributes[] = 'data-ratio="'. $layout_ratio .'"';
                            }

                            $post_columns = $current_layout['columns'];
                            $template = $current_layout['template'];

                            $classes = array(
                                "product-{$template}"
                            );
                            if(isset($settings['carousel_rows']) && $carousel_index == 0) {
                                echo '<div class="carousel-item clearfix">';
                            }
                            if ( !isset( $post_settings['carousel'] ) || isset($settings['carousel_rows']) ) {
                                $classes[] = $post_columns;
                            }
                            $classes = wp_parse_args( $classes, $post_classes );
                            $post_class = implode( ' ', array_filter( $classes ) );
                            $post_inner_class = implode( ' ', array_filter( $post_inner_classes ) );


                            wc_get_template( "{$template}.php", array(
                                'image_size' => $image_size,
                                'image_ratio' => $image_ratio,
                                'post_class' => $post_class,
                                'post_inner_class' => $post_inner_class,
                                'placeholder_enable' => $placeholder_enable,
                                'post_inner_attributes' => $post_inner_attributes,
                                'product_item_skin' => $item_skin
                            ));

                            if ( $isFirst ) {
                                unset( $layout_settings[$index] );
                                $layout_settings = array_values( $layout_settings );
                            }

                            if ( $isFirst && $paged === 1 ) {
                                $index = 0;
                            } else {
                                $index++;
                            }
                            $carousel_index++;
                            if(isset($settings['carousel_rows']) && $carousel_index == $settings['carousel_rows']['items_show']) {
                                echo '</div>';
                                $carousel_index = 0;
                            }
                        endwhile;
                        if(isset($settings['carousel_rows']) && $carousel_index != $settings['carousel_rows']['items_show'] && $carousel_index != 0) {
                            echo '</div>';
                        }
                    }
                } else{
                /**
                 * woocommerce_no_products_found hook.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                 do_action( 'woocommerce_no_products_found' );
                }




                 woocommerce_product_loop_end();

             //} else if (isset($post_settings['isMainQuery'])) {
                 /**
                  * woocommerce_no_products_found hook.
                  *
                  * @hooked wc_no_products_found - 10
                  */
                // do_action( 'woocommerce_no_products_found' );
             //}

            if (isset($settings['tabs'])) {
                remove_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'tabs_markup'));
            }

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                remove_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'category_filter_markup'));
            }

             if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                 remove_action('g5plus_before_archive_wrapper',array(g5Theme()->templates(),'shop_catalog_filter'),5);
             }

            g5Theme()->blog()->unset_layout_settings();

             if (isset($query_args)) {
                 wp_reset_query();
             }
        }
        public function page_title($page_title){
            if (is_post_type_archive('product')) {
                $shop_page_id = wc_get_page_id( 'shop' );
                if ($shop_page_id) {
                    if (!$page_title) {
                        $page_title   = get_the_title( $shop_page_id );
                    }
                    $custom_page_title = g5Theme()->metaBox()->get_page_title_content($shop_page_id);
                    if ($custom_page_title) {
                        $page_title = $custom_page_title;
                    }
                }
            } elseif (is_singular('product')) {
                global $single_product_title;
                $page_title = get_the_title(get_the_ID());
                $single_product_title = $page_title;
            }
            return $page_title;
        }
        public function shop_single_layout() {
            if(is_singular('product')) {
                $product_single_layout = g5Theme()->options()->get_product_single_layout();
                if('layout-02' === $product_single_layout) {
                    add_action('g5plus_before_main_content', array(g5Theme()->templates(), 'shop_single_top'), 10);
                }
            }
        }
        public function quick_view(){
            $product_quick_view = g5Theme()->options()->get_product_quick_view_enable();
            if ('on' === $product_quick_view) {
                wp_enqueue_script( 'wc-add-to-cart-variation' );
            }
        }

        public function product_related_products_args() {
            $products_per_page = intval(g5Theme()->options()->get_product_related_per_page());
            $args['posts_per_page'] = $products_per_page;
            return $args;
        }

        public function product_related_posts_relate_by_category() {
            $product_algorithm = g5Theme()->options()->get_product_related_algorithm();
            return (in_array($product_algorithm, array('cat', 'cat-tag'))) ? true : false;
        }
        public function product_related_posts_relate_by_tag() {
            $product_algorithm = g5Theme()->options()->get_product_related_algorithm();
            return (in_array($product_algorithm, array('tag', 'cat-tag'))) ? true : false;
        }

        public function product_related_posts_per_page($args) {
            $related_per_page = g5Theme()->options()->get_product_related_per_page();
            $args = array(
                'posts_per_page' 	=> intval($related_per_page),
                'columns' 			=> 4,
                'orderby' 			=> 'rand'
            );
            return $args;
        }
        public function product_up_sells_posts_per_page() {
            $up_sells_per_page = g5Theme()->options()->get_product_up_sells_per_page();
            return $up_sells_per_page;
        }

        public function product_cross_sells_posts_per_page() {
            $cross_sells_per_page = g5Theme()->options()->get_product_cross_sells_per_page();
            return $cross_sells_per_page;
        }

        public function woocommerce_clear_cart_url() {
            global $woocommerce;
            if( isset($_GET['empty-cart']) ) {
                $woocommerce->cart->empty_cart();
            }
        }
    }
}