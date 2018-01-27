<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Inc_Portfolio')) {
    class G5Plus_Inc_Portfolio
    {
        private static $_instance;
        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        private $_post_type = 'portfolio';
        private $_taxonomy_category = 'portfolio_cat';

        public function get_post_type() {
            return $this->_post_type;
        }

        public function get_taxonomy_category() {
            return $this->_taxonomy_category;
        }

        public function init() {
            add_filter('g5plus_post_layout_matrix', array($this, 'layout_matrix'),10,4);
            add_action('g5plus_after_single_portfolio',array($this,'portfolio_related'));
            add_action('wp_head', array($this, 'portfolio_single_layout'), 10);
        }

        public function render_thumbnail_markup($args = array())
        {
            $defaults = array(
                'post_id'            => get_the_ID(),
                'image_size'         => 'thumbnail',
                'placeholder_enable' => true,
                'image_mode'         => 'background',
                'image_ratio'        => ''
            );
            $defaults = wp_parse_args($args, $defaults);
            g5Theme()->helper()->getTemplate('portfolio/thumbnail', $defaults);
        }

        public function layout_matrix($matrix) {
            $post_settings = g5Theme()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'portfolio') {
                $post_settings = g5Theme()->portfolio()->get_layout_settings();
            }
            $columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
                'lg' => 3,
                'md' => 3,
                'sm' => 2,
                'xs' => 1,
                'mb' => 1
            );
            $columns_class = g5Theme()->helper()->get_bootstrap_columns($columns);
            $columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 30);
            $matrix[$this->get_post_type()] = array(
                'grid' => array(
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'placeholder_enable' => true,
                    'columns_gutter'     => $columns_gutter,
                    /*'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'fitRows',
                    ),*/
                    'layout'             => array(
                        array('columns' => $columns_class, 'template' => 'grid')
                    )
                ),
                'carousel' => array(
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'placeholder_enable' => true,
                    'columns_gutter'     => $columns_gutter,
                    /*'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'fitRows',
                    ),*/
                    'layout'             => array(
                        array('columns' => $columns_class, 'template' => 'grid')
                    )
                ),
                'masonry' => array(
                    'columns_gutter'     => $columns_gutter,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                    ),
                    'layout'             => array(
                        array('columns' => $columns_class, 'template' => 'grid')
                    )
                ),
                'scattered' => array(
                    'columns_gutter'     => '0',
                    'layout'             => array(
                        array('columns' => 'scattered-index-1 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '320x320'),
                        array('columns' => 'scattered-index-2 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '280x470'),
                        array('columns' => 'scattered-index-3 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '320x240'),
                        array('columns' => 'scattered-index-4 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 1.5,'md' => 1.5,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '570x240'),
                        array('columns' => 'scattered-index-5 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '280x360'),
                        array('columns' => 'scattered-index-6 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '320x320'),
                        array('columns' => 'scattered-index-7 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '320x240'),
                        array('columns' => 'scattered-index-8 ' . g5Theme()->helper()->get_bootstrap_columns(array('lg' => 3,'md' => 3,'sm' => 1,'xs' => 1,'mb' => 1)), 'template' => 'grid','image_size' => '320x320'),

                    )
                ),
                'metro-1' => array(
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
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '2x1'),

                    )
                ),
                'metro-2' => array(
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
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '2x1'),

                    )
                ),
                'metro-3' => array(
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
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 4,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid','layout_ratio' => '1x1'),
                    )
                ),
                'metro-4' => array(
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
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'layout'             => array(
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                    )
                ),
                'metro-5' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
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
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x0.625'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.1875'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x0.8125'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.1875'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x0.8125'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x0.625'),
                    )
                ),
                'metro-6' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
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
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1')
                    )
                ),
                'metro-7' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
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
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 2,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => g5Theme()->helper()->get_bootstrap_columns(array('lg' => 4,'md' => 2,'sm' => 2,'xs' => 2,'mb' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1')
                    )
                ),
                'carousel-3d' => array(
                    'carousel' => array(
                        'items' => 2,
                        'center' => true,
                        'loop' => true,
                        'responsive' => array(
                            0 => array(
                                'items' =>  1,
                                'center' => false
                            ),
                            600 => array(
                                'items' =>  2
                            )
                        )
                    ),
                    'carousel_class' => 'carousel-3d',
                    'image_size' => g5Theme()->options()->get_portfolio_image_size(),
                    'layout' => array(
                        array('template' => 'grid')
                    )
                )
            );
            return $matrix;
        }

        public function get_layout_settings() {
            return array(
                'post_layout'            => g5Theme()->options()->get_portfolio_layout(),
                'portfolio_item_skin'    => g5Theme()->options()->get_portfolio_item_skin(),
                'post_columns'           => array(
                    'lg' => intval(g5Theme()->options()->get_portfolio_columns()),
                    'md' => intval(g5Theme()->options()->get_portfolio_columns_md()),
                    'sm' => intval(g5Theme()->options()->get_portfolio_columns_sm()),
                    'xs' => intval(g5Theme()->options()->get_portfolio_columns_xs()),
                    'mb' => intval(g5Theme()->options()->get_portfolio_columns_mb()),
                ),
                'post_columns_gutter'    => intval(g5Theme()->options()->get_portfolio_columns_gutter()),
                'portfolio_hover_effect' => g5Theme()->options()->get_portfolio_hover_effect(),
                'portfolio_light_box'    => g5Theme()->options()->get_portfolio_light_box(),
                'post_paging'            => g5Theme()->options()->get_portfolio_paging(),
                'post_animation'         => g5Theme()->options()->get_portfolio_animation(),
                'itemSelector'           => 'article',
                'category_filter_enable' => false,
                'post_type' => $this->get_post_type(),
                'taxonomy' => $this->get_taxonomy_category()
            );
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

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                add_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['tabs'])) {
                add_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'tabs_markup'));
            }

            g5Theme()->helper()->getTemplate('portfolio/archive');

            if (isset($settings['tabs'])) {
                remove_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'tabs_markup'));
            }

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                remove_action('g5plus_before_archive_wrapper', array(g5Theme()->blog(), 'category_filter_markup'));
            }

            g5Theme()->blog()->unset_layout_settings();

            if (isset($query_args)) {
                wp_reset_query();
            }

        }

        public function the_permalink($post = 0) {
            $custom_link =  g5Theme()->metaBoxPortfolio()->get_single_portfolio_custom_link();
            if (!empty($custom_link)) {
                echo esc_url($custom_link);
            } else {
                the_permalink($post);
            }
        }

        public function get_category_parents( $id, $link = false, $separator = '/', $nicename = false, $deprecated = array() ) {

            if ( ! empty( $deprecated ) ) {
                _deprecated_argument( __FUNCTION__, '4.8.0' );
            }

            $format = $nicename ? 'slug' : 'name';

            $args = array(
                'separator' => $separator,
                'link'      => $link,
                'format'    => $format,
            );

            return get_term_parents_list( $id, $this->get_taxonomy_category(), $args );
        }

        public function get_category_link( $category ) {
            if ( ! is_object( $category ) )
                $category = (int) $category;

            $category = get_term_link( $category, $this->get_taxonomy_category() );

            if ( is_wp_error( $category ) )
                return '';

            return $category;
        }

        public function the_category( $separator = '', $parents = '', $post_id = false ) {
            echo $this->get_the_category_list( $separator, $parents, $post_id );
        }

        public function get_the_category_list($separator = '', $parents = '', $post_id = false) {
            $categories = get_the_terms( $post_id, $this->get_taxonomy_category() );
            if ( empty( $categories ) ) {
                /** This filter is documented in wp-includes/category-template.php */
                return apply_filters( 'the_portfolio_category', esc_html__('Uncategorized','g5plus-april'), $separator, $parents );
            }

            $thelist = '';
            if ( '' == $separator ) {
                $thelist .= '<ul class="portfolio-categories">';
                foreach ( $categories as $category ) {
                    $thelist .= "\n\t<li>";
                    switch ( strtolower( $parents ) ) {
                        case 'multiple':
                            if ( $category->parent )
                                $thelist .= $this->get_category_parents( $category->parent, true, $separator );
                            $thelist .= '<a href="' . esc_url( $this->get_category_link( $category->term_id ) ) . '">' . $category->name.'</a></li>';
                            break;
                        case 'single':
                            $thelist .= '<a href="' . esc_url( $this->get_category_link( $category->term_id ) ) . '">';
                            if ( $category->parent )
                                $thelist .= $this->get_category_parents( $category->parent, false, $separator );
                            $thelist .= $category->name.'</a></li>';
                            break;
                        case '':
                        default:
                            $thelist .= '<a href="' . esc_url( $this->get_category_link( $category->term_id ) ) . '">' . $category->name.'</a></li>';
                    }
                }
                $thelist .= '</ul>';
            } else {
                $i = 0;
                foreach ( $categories as $category ) {
                    if ( 0 < $i )
                        $thelist .= $separator;
                    switch ( strtolower( $parents ) ) {
                        case 'multiple':
                            if ( $category->parent )
                                $thelist .= $this->get_category_parents( $category->parent, true, $separator );
                            $thelist .= '<a href="' . esc_url( $this->get_category_link( $category->term_id ) ) . '">' . $category->name.'</a>';
                            break;
                        case 'single':
                            $thelist .= '<a href="' . esc_url( $this->get_category_link( $category->term_id ) ) . '">';
                            if ( $category->parent )
                                $thelist .= $this->get_category_parents( $category->parent, false, $separator );
                            $thelist .= "$category->name</a>";
                            break;
                        case '':
                        default:
                            $thelist .= '<a href="' . esc_url( $this->get_category_link( $category->term_id ) ) . '">' . $category->name.'</a>';
                    }
                    ++$i;
                }
            }

            return apply_filters( 'the_portfolio_category', $thelist, $separator, $parents );
        }

        public function portfolio_related() {
            g5Theme()->helper()->getTemplate('portfolio/single/portfolio-related');
        }

        public function portfolio_single_layout() {
            if (is_singular($this->get_post_type())) {
                $portfolio_single_layout = g5Theme()->options()->get_single_portfolio_layout();
                if ('layout-2' === $portfolio_single_layout) {
                    add_action('g5plus_before_main_content', array(g5Theme()->templates(), 'portfolio_single_top'), 10);
                }
            }
        }

        function get_portfolio_term_ids( $portfolio_id) {
            $terms = get_the_terms( $portfolio_id, $this->get_taxonomy_category() );
            return ( empty( $terms ) || is_wp_error( $terms ) ) ? array() : wp_list_pluck( $terms, 'term_id' );
        }
    }
}