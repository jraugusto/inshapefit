<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Inc_Assets')) {
    class G5Plus_Inc_Assets
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function registerAssets()
        {
            // Bootstrap
            wp_register_style('bootstrap', g5Theme()->helper()->getAssetUrl('assets/vendors/bootstrap/css/bootstrap.min.css'), array(), '3.3.7');
            wp_register_script('bootstrap', g5Theme()->helper()->getAssetUrl('assets/vendors/bootstrap/js/bootstrap.min.js'), array('jquery'), '3.3.7', true);
            wp_register_style('custom-bootstrap', g5Theme()->helper()->getAssetUrl('assets/vendors/bootstrap/css/custom-bootstrap.min.css'), array('bootstrap'), '3.3.7');


            //Owl.Carousel
            wp_register_style('owl.carousel', g5Theme()->helper()->getAssetUrl('assets/vendors/owl.carousel/assets/owl.carousel.min.css'), array(), '2.2.0');
            wp_register_style('owl.carousel.theme.default', g5Theme()->helper()->getAssetUrl('assets/vendors/owl.carousel/assets/owl.theme.default.min.css'), array(), '2.2.0');
            wp_register_script('owl.carousel', g5Theme()->helper()->getAssetUrl('assets/vendors/owl.carousel/owl.carousel.min.js'), array('jquery'), '2.2.0', true);

            // isotope
            wp_register_script('isotope', g5Theme()->helper()->getAssetUrl('assets/vendors/isotope/isotope.pkgd.min.js'), array('jquery'), '3.0.5', true);

            // jquery.cookie
            wp_register_script('jquery.cookie', g5Theme()->helper()->getAssetUrl('assets/vendors/jquery.cookie/jquery.cookie.min.js'), array('jquery'), '1.4.1', true);

            // Perfect-scrollbar
            wp_register_script('perfect-scrollbar', g5Theme()->helper()->getAssetUrl('assets/vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js'), array('jquery'), '0.6.15', true);
            wp_register_style('perfect-scrollbar', g5Theme()->helper()->getAssetUrl('assets/vendors/perfect-scrollbar/css/perfect-scrollbar.min.css'), array(), '0.6.15');


            // Magnific Popup
            wp_register_style('magnific-popup', g5Theme()->helper()->getAssetUrl('assets/vendors/magnific-popup/magnific-popup.min.css'), array(), '1.1.0');
            wp_register_script('magnific-popup', g5Theme()->helper()->getAssetUrl('assets/vendors/magnific-popup/jquery.magnific-popup.min.js'), array('jquery'), '1.1.0', true);

            // waypoints
            wp_register_script('waypoints', g5Theme()->helper()->getAssetUrl('assets/vendors/waypoints/jquery.waypoints.min.js'), array('jquery'), '4.0.1', true);

            // animated
            wp_register_style('animate-css', g5Theme()->helper()->getAssetUrl('assets/css/animate.min.css'), array(), '1.0');

            //ladda
            wp_register_style('ladda', g5Theme()->helper()->getAssetUrl('assets/vendors/ladda/ladda-themeless.min.css'), array(), '1.0');
            wp_register_script('ladda', g5Theme()->helper()->getAssetUrl('assets/vendors/ladda/ladda.min.js'), array('jquery'), '1.0.0', true);
            wp_register_script('ladda-spin', g5Theme()->helper()->getAssetUrl('assets/vendors/ladda/spin.min.js'), array('jquery'), '1.0.0', true);

            // hc-sticky
            wp_register_script('hc-sticky', g5Theme()->helper()->getAssetUrl('assets/vendors/hc-sticky/jquery.hc-sticky.min.js'), array('jquery'), '1.2.43', true);

            // smooth-scroll
            wp_register_script('smooth-scroll', g5Theme()->helper()->getAssetUrl('assets/vendors/smoothscroll/SmoothScroll.min.js'), array('jquery'), '1.4.4', true);

            // lazy-load
            wp_register_script('jquery.lazyload', g5Theme()->helper()->getAssetUrl('assets/vendors/lazyload/jquery.lazyload.min.js'), array('jquery'), '1.9.3', true);


            // modernizr
            wp_register_script('modernizr', g5Theme()->helper()->getAssetUrl('assets/vendors/modernizr/modernizr.js'), array('jquery'), '3.5.0', true);

            // imagesloaded
            wp_register_script('imagesloaded', g5Theme()->helper()->getAssetUrl('assets/vendors/imagesloaded/imagesloaded.pkgd.min.js'), array('jquery'), '4.1.3', true);

            // jquery.easing
            wp_register_script('jquery.easing', g5Theme()->helper()->getAssetUrl('assets/vendors/jquery.easing/jquery.easing.1.3.js'), array('jquery'), '1.3', true);

            // jquery.countdown
            wp_register_script('jquery.countdown', g5Theme()->helper()->getAssetUrl('assets/vendors/jquery.countdown/jquery.countdown.min.js'), array('jquery'), '2.2.0', true);

            // jquery.nav
            wp_register_script('jquery.nav', g5Theme()->helper()->getAssetUrl('assets/vendors/jquery.nav/jquery.nav.min.js'), array('jquery'), '3.0.0', true);


            wp_register_script(g5Theme()->helper()->assetsHandle('core'), g5Theme()->helper()->getAssetUrl('assets/js/core.min.js'), array('jquery'), '1.0', true);
            wp_register_script(g5Theme()->helper()->assetsHandle('woocommerce'), g5Theme()->helper()->getAssetUrl('assets/js/woocommerce.min.js'), array(g5Theme()->helper()->assetsHandle('core')), '1.0', true);
            wp_register_script(g5Theme()->helper()->assetsHandle('portfolio'), g5Theme()->helper()->getAssetUrl('assets/js/portfolio.min.js'), array(g5Theme()->helper()->assetsHandle('core')), '1.0', true);

            wp_register_script(g5Theme()->helper()->assetsHandle('main'), g5Theme()->helper()->getAssetUrl('assets/js/main.min.js'), array('jquery'), '1.0', true);

            wp_register_style('font-awesome', g5Theme()->helper()->getAssetUrl('assets/vendors/font-awesome/css/font-awesome.css'), array(), '4.7.0');

            wp_register_script('pretty-tabs', g5Theme()->helper()->getAssetUrl('assets/vendors/pretty-tabs/jquery.pretty-tabs.min.js'), array('jquery'), '1.0', true);

            $color_skin = g5Theme()->optionsSkin()->get_color_skin();
            if (is_array($color_skin)) {
                foreach ($color_skin as $key => $value) {
                    if (isset($value['skin_id'])) {
                        // Enqueue skin.css
                        if (function_exists('G5P') && defined('CSS_DEBUG') && CSS_DEBUG) {
                            wp_register_style(g5Theme()->helper()->assetsHandle("skin_{$value['skin_id']}"), admin_url('admin-ajax.php') . '?action=gsf_dev_less_skin_to_css&skin_id=' . $value['skin_id'], array(), false);
                        } else {
                            do_action('gsf_before_enqueue_skin_css', $value['skin_id']);
                            wp_register_style(g5Theme()->helper()->assetsHandle("skin_{$value['skin_id']}"), g5Theme()->helper()->getAssetUrl("assets/skin/{$value['skin_id']}.min.css"));
                        }
                    }
                }
            }
        }


        public function enqueueAssets()
        {


            // modernizr
            wp_enqueue_script('modernizr');

            // modernizr
            wp_enqueue_script('imagesloaded');

            // jquery.easing
            wp_enqueue_script('jquery.easing');

            // jquery.countdown
            wp_enqueue_script('jquery.countdown');


            // Bootstrap
            wp_enqueue_style('bootstrap');
            wp_enqueue_script('bootstrap');
            wp_enqueue_style('custom-bootstrap');

            // Owl.Carousel
            wp_enqueue_style('owl.carousel');
            wp_enqueue_style('owl.carousel.theme.default');
            wp_enqueue_script('owl.carousel');

            //isotope
            wp_enqueue_script('isotope');

            // Perfect-scrollbar
            wp_enqueue_style('perfect-scrollbar');
            wp_enqueue_script('perfect-scrollbar');

            wp_enqueue_style('font-awesome');

            // Magnific Popup
            wp_enqueue_style('magnific-popup');
            wp_enqueue_script('magnific-popup');
            wp_enqueue_script('jquery.cookie');

            // animated
            wp_enqueue_style('animate-css');

            //waypoints
            wp_enqueue_script('waypoints');

            //ladda
            wp_enqueue_style('ladda');
            wp_enqueue_script('ladda-spin');
            wp_enqueue_script('ladda');


            // hc-sticky
            wp_enqueue_script('hc-sticky');

            wp_enqueue_script('pretty-tabs');


            // comment
            if (is_singular()) wp_enqueue_script('comment-reply');


            // smooth scroll
            $smooth_scroll = g5Theme()->options()->get_smooth_scroll();
            if ($smooth_scroll === 'on') {
                wp_enqueue_script('smooth-scroll');
            }

            // lazyLoad
            $lazy_load_images = g5Theme()->options()->get_lazy_load_images();
            if ($lazy_load_images === 'on') {
                wp_enqueue_script('jquery.lazyload');
            }

            $is_one_page = g5Theme()->metaBox()->get_is_one_page();
            if ($is_one_page === 'on') {
                wp_enqueue_script('jquery.nav');
            }

            // js Core
            wp_enqueue_script(g5Theme()->helper()->assetsHandle('core'));

            // js woocommerce
            if(class_exists( 'WooCommerce' )) {
                wp_enqueue_script(g5Theme()->helper()->assetsHandle('woocommerce'));
            }

            // js portfolio
            $custom_post_type_disable = G5P()->options()->get_custom_post_type_disable();
            if(!in_array('portfolio', $custom_post_type_disable)) {
                wp_enqueue_script(g5Theme()->helper()->assetsHandle('portfolio'));
            }

            // js Main
            wp_enqueue_script(g5Theme()->helper()->assetsHandle('main'));

            // js variable
            wp_localize_script(
                g5Theme()->helper()->assetsHandle('main'),
                'g5plus_variable',
                array(
                    'ajax_url'              => admin_url('admin-ajax.php'),
                    'theme_url'             => g5Theme()->themeUrl(),
                    'site_url'              => site_url(),
                    'pretty_tabs_more_text' => wp_kses_post(__('More <span class="caret"></span>', 'g5plus-april'))
                )
            );

            $presetId = g5Theme()->helper()->getCurrentPreset();

            $rtl = is_rtl() || g5Theme()->options()->get_rtl_enable() === 'on' || isset($_GET['RTL']);

            // Enqueue style.css
            if (function_exists('G5P') && defined('CSS_DEBUG') && CSS_DEBUG) {
                wp_enqueue_style(g5Theme()->helper()->assetsHandle('main'), admin_url('admin-ajax.php') . '?action=gsf_dev_less_to_css&_gsf_preset=' . $presetId, array(), false);
                if ($rtl) {
                    wp_enqueue_style(g5Theme()->helper()->assetsHandle('rtl'), admin_url('admin-ajax.php') . '?action=gsf_dev_less_to_css_rtl', array(), false);
                }

            } else {
                do_action('gsf_before_enqueue_main_css', $presetId);
                if (!$presetId || !$this->enqueuePreset($presetId)) {
                    wp_enqueue_style(g5Theme()->helper()->assetsHandle('main'), g5Theme()->helper()->getAssetUrl('style.min.css'));
                }

                if ($rtl) {
                    do_action('gsf_before_enqueue_main_css_rtl');
                    wp_enqueue_style(g5Theme()->helper()->assetsHandle('rtl'), g5Theme()->helper()->getAssetUrl('assets/css/rtl.min.css'));
                }
            }


            $skins = array();
            $skin_config = array(
                'header_skin',
                'mobile_header_skin',
                'content_skin',
                'sub_menu_skin'
            );

            // navigation skin
            $header_layout = g5Theme()->options()->get_header_layout();
            if (in_array($header_layout, array('header-6'))) {
                $skin_config[] = 'navigation_skin';
            }

            // page title skin
            $page_title_enable = g5Theme()->options()->get_page_title_enable();
            if ($page_title_enable === 'on') {
                $skin_config[] = 'page_title_skin';
            }

            // top drawer
            $top_drawer_mode = g5Theme()->options()->get_top_drawer_mode();
            if ($top_drawer_mode !== 'hide') {
                $skin_config[] = 'top_drawer_skin';
            }
            // header sticky
            $header_sticky_enable = g5Theme()->options()->get_header_sticky_enable();
            if (($header_sticky_enable === 'on') && !in_array($header_layout, array('header-8', 'header-7'))) {
                $skin_config[] = 'header_sticky_skin';
            }

            foreach ($skin_config as $skin_key) {
                $skin = g5Theme()->options()->getOptions($skin_key);
                if (!empty($skin) && !in_array($skin, $skins)) {
                    $skins[] = $skin;
                }
            }

            foreach ($skins as $skin_id) {
                // Enqueue skin.css
                wp_enqueue_style(g5Theme()->helper()->assetsHandle("skin_{$skin_id}"));
            }

        }

        public function enqueueSubMenuAssets()
        {
            $sub_menu_skin = g5Theme()->options()->get_sub_menu_skin();
            g5Theme()->helper()->getSkinClass($sub_menu_skin);
        }


        private function enqueuePreset($preset)
        {
            $filename = g5Theme()->themeDir("assets/preset/{$preset}.min.css");
            if (!file_exists($filename)) {
                return false;
            }
            wp_enqueue_style(g5Theme()->helper()->assetsHandle('main'), g5Theme()->helper()->getAssetUrl("assets/preset/{$preset}.min.css"));
            return true;
        }

        public function enqueue_icon_font()
        {
            if (!function_exists('G5P')) {
                $icon_font_css = g5Theme()->fontIcons()->registerAssets();
                foreach ($icon_font_css as $font_key => $font_value) {
                    wp_enqueue_style($font_key, $font_value['url'], array(), $font_value['ver']);
                }
                wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css?family=Nunito+Sans%3Aregular%2C400i%2C600%2C600i%2C700%2C700i%2C800%2C800i%2C900%2C900i%7CMontserrat%3Aregular%2C400i%2C600%2C600i%2C700%2C700i&subset=latin');
            }
        }

        public function getCustomCss()
        {
            $custom_css = '';

            /**
             * Custom Background
             */
            $custom_background = array(
                /**
                 * Body Background
                 */
                'body_background' => array(
                    'selector' => 'body',
                    'default'  => ''
                ),
            );
            foreach ($custom_background as $key => $value) {
                $background = g5Theme()->options()->getOptions($key);
                $background_attributes = array();
                if (isset($background['background_color']) && !empty($background['background_color'])) {
                    $background_attributes[] = "background-color: {$background['background_color']} !important";
                }

                if (isset($background['background_image_url']) && !empty($background['background_image_url'])) {
                    $background_repeat = isset($background['background_repeat']) ? $background['background_repeat'] : '';
                    $background_position = isset($background['background_position']) ? $background['background_position'] : '';
                    $background_size = isset($background['background_size']) ? $background['background_size'] : '';
                    $background_attachment = isset($background['background_attachment']) ? $background['background_attachment'] : '';

                    $background_attributes[] = "background-image: url('{$background['background_image_url']}')";

                    if (!empty($background_repeat)) {
                        $background_attributes[] = "background-repeat: {$background_repeat}";
                    }

                    if (!empty($background_position)) {
                        $background_attributes[] = "background-position: {$background_position}";
                    }

                    if (!empty($background_size)) {
                        $background_attributes[] = "background-size: {$background_size}";
                    }

                    if (!empty($background_attachment)) {
                        $background_attributes[] = "background-attachment: {$background_attachment}";
                    }

                }

                $background_css = implode('; ', array_filter($background_attributes));

                $custom_css .= <<<CSS
			{$value['selector']} {
				{$background_css}
			}
CSS;

            }

            /**
             * Custom Background Color
             */
            $custom_background_color = array(
                'loading_animation_bg_color'      => array('.site-loading' => 'background-color'), /* loading background color */
                'content_background_color'        => array('#gf-wrapper' => 'background-color'), /* content background color */
                'top_drawer_background_color'     => array('.top-drawer-wrap' => 'background-color', '.top-drawer-toggle' => 'border-top-color'), /* top drawer background color */
                'header_background_color'         => array('.main-header' => 'background-color'), /* header background color */
                'header_sticky_background_color'  => array('.main-header .header-sticky.affix' => 'background-color'), /* header sticky background color*/
                'navigation_background_color'     => array('.main-header.header-6 .primary-menu:not(.affix)' => 'background-color'), /* Navigation background color*/
                'sub_menu_background_color'       => array('.main-menu ul.sub-menu' => 'background-color'), /* Sub menu background color */
                'canvas_sidebar_background_color' => array('.canvas-sidebar-wrapper' => 'background-color'), /* Canvas Sidebar Background Color */
                'page_title_background_color'     => array('.gf-page-title' => 'background-color'), /* Page Title Background Color */
                'mobile_header_background_color'  => array('.mobile-header' => 'background-color'), /* header mobile background color*/
            );
            foreach ($custom_background_color as $key => $value) {
                $color = g5Theme()->options()->getOptions($key);
                if (!empty($color)) {
                    foreach ($value as $selector => $property) {
                        $custom_css .= <<<CSS
				{$selector} {
					{$property}: {$color} !important;
				}
CSS;
                    }
                }
            }


            /* Custom scroll */
            $custom_scroll = g5Theme()->options()->get_custom_scroll();
            if ($custom_scroll === 'on') {
                $custom_scroll_width = g5Theme()->options()->get_custom_scroll_width();
                $custom_scroll_color = g5Theme()->options()->get_custom_scroll_color();
                $custom_scroll_thumb_color = g5Theme()->options()->get_custom_scroll_thumb_color();

                $custom_css .= <<<CSS
				body::-webkit-scrollbar {
					width: {$custom_scroll_width}px;
					background-color: {$custom_scroll_color};
				}
				body::-webkit-scrollbar-thumb {
				background-color: {$custom_scroll_thumb_color};
				}
CSS;
            }

            /* Custom Padding*/
            $custom_padding = array(
                'top_drawer_padding'    => '.top-drawer-content',
                'header_padding'        => '.header-inner',
                'mobile_header_padding' => '.mobile-header-inner',
                'content_padding'       => '#primary-content'
            );
            $single_post_layout = g5Theme()->options()->get_single_post_layout();
            if ($single_post_layout === 'layout-5') {
                $custom_padding['post_single_image_padding'] = '.entry-thumb-single';
            }
            $custom_padding = apply_filters('gsf_custom_padding', $custom_padding);

            foreach ($custom_padding as $optionKey => $selector) {
                $padding = g5Theme()->options()->getOptions($optionKey);
                if (is_array($padding)) {
                    $padding_css = '';
                    foreach ($padding as $key => $value) {

                        if ($value !== '') {
                            $padding_css .= <<<CSS
                            padding-{$key}: {$value}px;
CSS;
                        }
                    }
                    if ($padding_css !== '') {
                        $custom_css .= <<<CSS
                        {$selector} {
                            {$padding_css}
                        }
CSS;
                    }
                }

            }

            /* Custom Padding Mobile */
            $header_responsive_breakpoint = g5Theme()->options()->get_header_responsive_breakpoint();
            $header_responsive_breakpoint = (int)$header_responsive_breakpoint;
            $custom_padding_mobile = array(
                'mobile_content_padding' => '#primary-content'
            );
            if ($single_post_layout === 'layout-5') {
                $custom_padding['post_single_image_mobile_padding'] = '.entry-thumb-single';
            }
            $custom_padding_mobile = apply_filters('gsf_custom_padding_mobile', $custom_padding_mobile);

            foreach ($custom_padding_mobile as $optionKey => $selector) {
                $padding = g5Theme()->options()->getOptions($optionKey);
                if (is_array($padding)) {
                    $padding_css = '';
                    foreach ($padding as $key => $value) {

                        if ($value !== '') {
                            $padding_css .= <<<CSS
                            padding-{$key}: {$value}px;
CSS;
                        }
                    }
                    if ($padding_css !== '') {
                        $custom_css .= <<<CSS
                        @media (max-width: {$header_responsive_breakpoint}px) {
                            {$selector} {
                                {$padding_css}
                            }
                        }

CSS;
                    }
                }

            }


            /* Image Size */
            global $_wp_additional_image_sizes;
            foreach (get_intermediate_image_sizes() as $_size) {
                $width = $height = 0;
                if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
                    $width = get_option("{$_size}_size_w");
                    $height = get_option("{$_size}_size_h");
                } elseif (isset($_wp_additional_image_sizes[$_size])) {
                    $width = $_wp_additional_image_sizes[$_size]['width'];
                    $height = $_wp_additional_image_sizes[$_size]['height'];
                }
                if ($height > 0 && $width > 0) {
                    $ratio = ($height / $width) * 100;
                    $custom_css .= <<<CSS
                .thumbnail-size-{$_size}:before {
                    padding-bottom: {$ratio}%;
                }
CSS;
                }
            }

            /* Content Block*/
            $content_blocks = array(
                'page_title_content_block',
                'footer_content_block',
                'top_bar_content_block',
                'mobile_top_bar_content_block',
                '404_content_block',
                'top_drawer_content_block'
            );
            foreach ($content_blocks as $content_block) {
                $contentBlockId = g5Theme()->options()->getOptions($content_block);
                if (!empty($contentBlockId)) {
                    wp_enqueue_style('js_composer_front');

                    /**
                     * Post Custom Css
                     */
                    $post_custom_css = get_post_meta($contentBlockId, '_wpb_post_custom_css', true);
                    if (!empty($post_custom_css)) {
                        $custom_css .= $post_custom_css;
                    }

                    /**
                     * Shortcodes Custom Css
                     */
                    $shortcodes_custom_css = get_post_meta($contentBlockId, '_wpb_shortcodes_custom_css', true);
                    if (!empty($shortcodes_custom_css)) {
                        $custom_css .= $shortcodes_custom_css;
                    }
                }
            }


            /*Canvas overlay*/
            $image_url = g5Theme()->themeUrl('assets/images/close.png');
            $custom_css .= <<<CSS
                .canvas-overlay {
                    cursor: url({$image_url}) 15 15, default;
                }
CSS;


            $custom_css .= g5Theme()->options()->get_custom_css();
            $custom_css = strip_tags($custom_css);;

            wp_add_inline_style(g5Theme()->helper()->assetsHandle('main'), $custom_css);
        }

        public function custom_script() {
            // Custom javascript
            $custom_js = g5Theme()->options()->get_custom_js();
            if (!empty($custom_js)) {
                if(preg_match('/\\<script/',$custom_js)) {
                    echo sprintf('%s', $custom_js);
                } else {
                    echo sprintf('<script type="text/javascript">%s</script>', $custom_js);
                }
            }
        }
    }
}