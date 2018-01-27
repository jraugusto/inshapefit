<?php
/**
 * Class Blog
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Inc_Blog')) {
	class G5Plus_Inc_Blog
	{

		public $key_post_layout_settings = 'gf_post_layout_settings';

		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		public function render_post_thumbnail_markup($args = array())
		{
			$defaults = array(
				'post_id'            => get_the_ID(),
				'image_size'         => 'full',
				'placeholder_enable' => false,
				'display_permalink'  => true,
				'mode'               => 'simple',
                'is_single'         => false,
				'image_mode'         => 'background'
			);
			$defaults = wp_parse_args($args, $defaults);
			g5Theme()->helper()->getTemplate('loop/post-thumbnail', $defaults);
		}

		public function render_post_image_markup($args = array())
		{
			$defaults = array(
				'post_id'           => get_the_ID(),
				'image_id'          => '',
				'image_size'        => 'full',
				'gallery_id'        => '',
				'is_single'         => false,
				'display_permalink' => true,
				'image_mode'        => 'background',
                'class'             => 'entry-thumbnail'
			);
			$defaults = wp_parse_args($args, $defaults);
			g5Theme()->helper()->getTemplate('loop/post-image', $defaults);
		}

		public function get_image_sizes()
		{
			$image_sizes = array(
				'blog-large'      => '870x430',
				'blog-medium'     => '555x330',
                'blog-widget'     => '100x70',
				'blog-masonry'    => '555x0'
			);
			return apply_filters('g5plus_image_sizes', $image_sizes);
		}

		public function pagination_markup()
		{
			global $wp_query;
			if (!isset($wp_query)) return;
			$settings = &$this->get_layout_settings();
			$post_paging = $settings['post_paging'];
			if (($wp_query->max_num_pages > 1) && ($post_paging !== '') && ($post_paging !== 'none')) {

				if (!isset($settings['settingId']) || $settings['settingId'] === '') {
					$settingId = mt_rand();
				} else {
					$settingId = $settings['settingId'];
				}

				if (!isset($settings['pagenum_link']) || $settings['pagenum_link'] === '') {
					$pagenum_link = html_entity_decode(get_pagenum_link());
					$settings['pagenum_link'] = $pagenum_link;
				} else {
					$pagenum_link = $settings['pagenum_link'];
				}
				if (($post_paging !== 'pagination') && (!isset($_REQUEST['action']) || empty($_REQUEST['action']))) {

					$query_args = array();
					if (is_home()) {
						$query_args['is_home'] = true;
					}
					g5Theme()->custom_js()->addJsVariable(array(
						'settings' => $settings,
						'query'    => g5Theme()->query()->get_ajax_query_vars($query_args)
					), "gf_ajax_paginate_{$settingId}");
				}

				g5Theme()->helper()->getTemplate("paging/{$post_paging}", array('settingId' => $settingId, 'pagenum_link' => $pagenum_link));
			}
		}

		public function category_filter_markup()
		{
			$settings = &$this->get_layout_settings();
			if (!isset($settings['settingId']) || $settings['settingId'] === '') {
				$settingId = mt_rand();
			} else {
				$settingId = $settings['settingId'];
			}

			if (!isset($settings['pagenum_link']) || $settings['pagenum_link'] === '') {
				$pagenum_link = html_entity_decode(get_pagenum_link());
				$settings['pagenum_link'] = $pagenum_link;
			} else {
				$pagenum_link = $settings['pagenum_link'];
			}


			if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
				$query_args = array();
				if (is_home()) {
					$query_args['is_home'] = true;
				}

				g5Theme()->custom_js()->addJsVariable(array(
					'settings' => $settings,
					'query'    => g5Theme()->query()->get_ajax_query_vars($query_args)
				), "gf_ajax_paginate_{$settingId}");
			}
			g5Theme()->helper()->getTemplate("loop/cat-filter", array(
			    'settingId' => $settingId,
                'pagenum_link' => $pagenum_link,
                'post_type' => $settings['post_type'],
                'taxonomy' => isset($settings['taxonomy']) ? $settings['taxonomy'] : 'category',
                'category_filter' => isset($settings['cat']) ? $settings['cat'] : '',
                'current_cat' => isset($settings['current_cat']) ? $settings['current_cat'] : -1,
                'filter_vertical' => isset($settings['category_filter_vertical']) ? $settings['category_filter_vertical'] : false,
                'filter_type' => isset($settings['category_filter_type']) ? $settings['category_filter_type'] : ''
            ));
		}

		public function tabs_markup() {
			$settings = &$this->get_layout_settings();
			$tabs = isset($settings['tabs']) ? $settings['tabs'] : array();
			unset($settings['tabs']);
			if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
				$index = 1;
				foreach ($tabs as &$tab) {
					$settingId = mt_rand();
					$query_args = $tab['query_args'];
					$tab['settingId'] = $settingId;
					if ($index === 1) {
						$settings['settingId'] = $settingId;
					}

					if (is_home()) {
						$query_args['is_home'] = true;
					}
					g5Theme()->custom_js()->addJsVariable(array(
						'settings' => $settings,
						'query'    => g5Theme()->query()->get_ajax_query_vars($query_args)
					), "gf_ajax_paginate_{$settingId}");
					$index++;
				}
			}
			g5Theme()->helper()->getTemplate("loop/tabs", array('tabs' => $tabs));
		}


		/**
		 * Get Post Layout Settings
		 *
		 * @return mixed
		 */
		public function &get_layout_settings()
		{
			if (isset($GLOBALS[$this->key_post_layout_settings]) && is_array($GLOBALS[$this->key_post_layout_settings])) {
				return $GLOBALS[$this->key_post_layout_settings];
			}

			$GLOBALS[$this->key_post_layout_settings] = array(
				'post_layout'            => g5Theme()->options()->get_post_layout(),
				'post_item_skin'         => g5Theme()->options()->get_post_item_skin(),
				'post_columns'           => array(
					'lg' => intval(g5Theme()->options()->get_post_columns()),
					'md' => intval(g5Theme()->options()->get_post_columns_md()),
					'sm' => intval(g5Theme()->options()->get_post_columns_sm()),
					'xs' => intval(g5Theme()->options()->get_post_columns_xs()),
                    'mb' => intval(g5Theme()->options()->get_post_columns_mb()),
				),
				'post_columns_gutter'    => intval(g5Theme()->options()->get_post_columns_gutter()),
				'post_paging'            => g5Theme()->options()->get_post_paging(),
				'post_animation'         => g5Theme()->options()->get_post_animation(),
				'itemSelector'           => 'article',
				'category_filter_enable' => false,
                'post_type' => 'post'
			);
			return $GLOBALS[$this->key_post_layout_settings];
		}

		public function unset_layout_settings()
		{
			unset($GLOBALS[$this->key_post_layout_settings]);
		}

		/**
		 * Set Post Layout Settings
		 *
		 * @param $args
		 */
		public function set_layout_settings($args)
		{
			$post_settings = &$this->get_layout_settings();
			$post_settings = wp_parse_args($args, $post_settings);
		}

		public function archive_markup($query_args = null, $settings = null)
		{
		    if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

			if (!isset($query_args)) {
				$settings['isMainQuery'] = true;
			}

			if (isset($settings) && (sizeof($settings) > 0)) {
				$this->set_layout_settings($settings);
			}

            if (isset($query_args)) {
                $is_category  = is_category();
                $query_args = g5Theme()->query()->get_main_query_vars($query_args);
                query_posts($query_args);
                global $wp_query;
                $wp_query->is_category = $is_category;
            }
			if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
				add_action('g5plus_before_archive_wrapper', array($this, 'category_filter_markup'));
			}

			if (isset($settings['tabs'])) {
				add_action('g5plus_before_archive_wrapper', array($this, 'tabs_markup'));
			}

			g5Theme()->helper()->getTemplate('archive');

			if (isset($settings['tabs'])) {
				remove_action('g5plus_before_archive_wrapper', array($this, 'tabs_markup'));
			}

			if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
				remove_action('g5plus_before_archive_wrapper', array($this, 'category_filter_markup'));
			}

			if (isset($settings) && (sizeof($settings) > 0)) {
				$this->unset_layout_settings();
			}


            if (isset($query_args)) {
                wp_reset_query();
            }

		}

		/**
		 * Get Primary Category
		 *
		 * @return array|mixed|null|object|WP_Error
		 */
		public function get_primary_cat()
		{
			// Primary category from Yoast SEO plugin
			if (class_exists('WPSEO_Primary_Term')) {
				$prim_cat = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true);
				if ($prim_cat) {
					$prim_cat = get_category($prim_cat);
					if (!is_wp_error($prim_cat)) {
						return $prim_cat;
					}
				}
			}

			global $wp_query;
			$prim_cat = intval($wp_query->get('gf_cat', -1));
			if ($prim_cat > 0) {
				$prim_cat = get_category($prim_cat);
				if (!is_wp_error($prim_cat)) {
					return $prim_cat;
				}
			}

			$category__in = $wp_query->get('category__in', array());
			if (sizeof($category__in) > 0) {
				$categories = get_the_category();
				for ($i = 0; $i < sizeof($categories); $i++) {
					if (!in_array($categories[$i]->term_id, $category__in)) {
						unset($categories[$i]);
					}
				}
				if (sizeof($categories) > 0) {
					return current($categories);
				}

			}

			// First cat
			return current(get_the_category());
		}

		public function archive_ads_markup($args)
		{
			g5Theme()->helper()->getTemplate('loop/ads', $args);
		}

		public function get_layout_matrix($layout = 'large-image')
		{
			$post_settings = &g5Theme()->blog()->get_layout_settings();
			$post_type = isset($post_settings['post_type']) ? $post_settings['post_type'] : 'post';
			$columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
				'lg' => 2,
				'md' => 2,
				'sm' => 1,
				'xs' => 1,
                'mb' => 1
			);
			$columns = g5Theme()->helper()->get_bootstrap_columns($columns);
			$columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 30);
			$matrix = apply_filters('g5plus_post_layout_matrix',array(
			    'post' => array(
                    'large-image'    => array(
                        'layout'             => array(
                            array('columns' => 'col-xs-12', 'template' => 'large-image', 'image_size' => 'blog-large'),
                        )
                    ),
                    'medium-image'   => array(
                        'layout'         => array(
                            array('columns' => 'col-xs-12', 'template' => 'medium-image', 'image_size' => 'blog-medium'),
                        )
                    ),
                    'grid'           => array(
                        'placeholder_enable' => true,
                        'columns_gutter' => $columns_gutter,
                        /*'isotope'        => array(
                            'itemSelector' => 'article',
                            'layoutMode'   => 'fitRows',
                        ),*/
                        'layout'         => array(
                            array('columns' => $columns, 'template' => 'grid', 'image_size' => 'blog-medium')
                        )
                    ),
                    'masonry'        => array(
                        'columns_gutter' => $columns_gutter,
                        'isotope'        => array(
                            'itemSelector' => 'article',
                            'layoutMode'   => 'masonry',
                        ),
                        'layout'         => array(
                            array('columns' => $columns, 'template' => 'grid', 'image_size' => 'blog-masonry'),
                        )
                    )
                )
			));
			if (!isset($matrix[$post_type][$layout])) return $matrix['post']['large-image'];
			return $matrix[$post_type][$layout];
		}


		public function get_list_comments_args($args = array())
		{
			// Default arguments for listing comments.
			$defaults = array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 70,
				'callback'    => 'g5plus_comments_callback'
			);
			// Filter default arguments to enable developers to change it. also return it.
			return apply_filters('g5plus_list_comments_args', wp_parse_args($args, $defaults));
		}

		public function get_comments_form_args($args = array())
		{
			$commenter = wp_get_current_commenter();
			$req = get_option('require_name_email');
			$aria_req = ($req ? " aria-required='true'" : '');
			$html_req = ($req ? " required='required'" : '');
			$html5 = true;
			$fields = array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__('Name', 'g5plus-april') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input placeholder="' . esc_html__('Name', 'g5plus-april') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'g5plus-april') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input placeholder="' . esc_html__('Email', 'g5plus-april') . '" id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . ' /></p>',
				'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__('Website', 'g5plus-april') . '</label> ' .
					'<input id="url" placeholder="' . esc_html__('Website', 'g5plus-april') . '" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" /></p>',
			);


			$defaults = array(
				'fields'             => $fields,
				'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'g5plus-april') . '</label> <textarea placeholder="' . esc_html__('Comment', 'g5plus-april') . '" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
				'title_reply'        => esc_html__('Leave your thought here', 'g5plus-april'),
				'title_reply_before' => '<h4 id="reply-title" class="gf-heading-title"><span>',
				'title_reply_after'  => '</span></h4>',
				'label_submit'       => esc_html__('Submit', 'g5plus-april'),
				'class_submit'       => 'btn btn-black btn-md btn-block'
			);

			// Filter default arguments to enable developers to change it. also return it.
			return apply_filters('g5plus_comments_form_args', wp_parse_args($args, $defaults));
		}
	}
}