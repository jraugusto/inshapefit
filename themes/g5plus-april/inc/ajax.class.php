<?php
/**
 * Class Ajax
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Inc_Ajax')) {
    class G5Plus_Inc_Ajax
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Search Result
         */
        public function search_result()
        {
            check_ajax_referer('search_popup_nonce', 'nonce');
            global $wpdb;
            $keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
            if (empty($keyword)) {
                wp_send_json_error();
            }

            $keyword = $wpdb->esc_like($keyword);
            $search_popup_post_type = g5Theme()->options()->get_search_popup_post_type();
            $search_popup_result_amount = g5Theme()->options()->get_search_popup_result_amount();
            if (empty($search_popup_result_amount)) {
                $search_popup_result_amount = 8;
            }

            $args = array(
                's' => $keyword,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => $search_popup_post_type,
                'posts_per_page' => $search_popup_result_amount
            );
            $query = new WP_Query($args);
            ob_start();
            ?>
            <ul class="search-popup-list">
                <?php if ($query->have_posts()): ?>
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        g5Theme()->helper()->getTemplate('popup/content');
                        wp_reset_postdata();
                    }
                    ?>
                <?php else: ?>
                    <li class="sa-nothing"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'g5plus-april'); ?></li>
                <?php endif; ?>
            </ul>
            <?php
            echo ob_get_clean();
            wp_die();
        }

        public function pagination_ajax_response()
        {
            $query_args = isset($_REQUEST['query']) ? $_REQUEST['query'] : array();
            ob_start();
            $settings = isset($_REQUEST['settings']) ? $_REQUEST['settings'] : array();
            $postType = isset($settings['post_type']) ? $settings['post_type'] : 'post';
            $query_args = g5Theme()->query()->parse_ajax_query($query_args);

            if ($postType === 'product') {
                g5Theme()->woocommerce()->archive_markup($query_args, $settings);
            } elseif($postType === 'portfolio'){
                g5Theme()->portfolio()->archive_markup($query_args, $settings);
            }else {
                g5Theme()->blog()->archive_markup($query_args, $settings);
            }

            echo ob_get_clean();
            wp_die();
        }

        public function gsf_user_login_callback()
        {
            ob_start();
            ?>
            <div id="gsf-popup-login-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="gsf-popup-login-form" class="modal-content">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="<?php _e('Close', 'g5plus-april'); ?>"><i class="fa fa-remove"></i>
                        </button>
                        <div class="modal-header">
                            <h4 class="modal-title"><?php _e('Login', 'g5plus-april'); ?></h4>
                            <p><?php _e('Hello. Welcome to your account.', 'g5plus-april'); ?></p>
                        </div>
                        <div class="modal-body">
                            <div class="gsf-popup-login-content">
                                <div class="form-group">
                                    <div class="input-icon">
                                        <input type="text" id="username" class="form-control" name="username"
                                               required="required"
                                               placeholder="<?php _e('Username', 'g5plus-april') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <input type="password" id="password" name="password" class="form-control"
                                               required="required"
                                               placeholder="<?php _e('Password', 'g5plus-april') ?>">
                                    </div>
                                </div>
                                <div class="login-message text-left fs-12"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?php do_action('login_form'); ?>
                            <input type="hidden" name="action" value="gsf_user_login_ajax"/>
                            <div class="modal-footer-left">
                                <input id="remember-me" type="checkbox" name="rememberme" checked="checked"/>
                                <label for="remember-me" no-value="<?php _e('NO', 'g5plus-april') ?>"
                                       yes-value="<?php _e('YES', 'g5plus-april') ?>"></label>
                                <?php _e('Remember me', 'g5plus-april') ?>
                            </div>
                            <div class="modal-footer-right">
                                <button data-style="zoom-in" data-spinner-size="30" data-spinner-color="#fff"
                                        type="submit"
                                        class="ladda-button btn btn-primary btn-classic btn-rounded btn-sm"><?php echo __('Login', 'g5plus-april'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            die(); // this is required to return a proper result
        }

        public function gsf_user_login_ajax_callback()
        {
            global $wpdb;

            //We shall SQL escape all inputs to avoid sql injection.
            $username = esc_sql($_REQUEST['username']);
            $password = esc_sql($_REQUEST['password']);
            $remember = esc_sql($_REQUEST['rememberme']);

            if ($remember) $remember = "true";
            else $remember = "false";

            $login_data = array();
            $login_data['user_login'] = $username;
            $login_data['user_password'] = $password;
            $login_data['remember'] = $remember;
            $user_verify = wp_signon($login_data, false);


            $code = 1;
            $message = '';

            if (is_wp_error($user_verify)) {
                $message = $user_verify->get_error_message();
                $code = -1;
            } else {
                wp_set_current_user($user_verify->ID, $username);
                do_action('set_current_user');
                $message = '';
            }

            $response_data = array(
                'code' => $code,
                'message' => $message
            );

            ob_end_clean();
            echo json_encode($response_data);
            die(); // this is required to return a proper result
        }

        public function gsf_user_sign_up_callback()
        {
            ?>
            <div id="gsf-popup-login-wrapper" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="gsf-popup-login-form" class="modal-content">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="<?php _e('Close', 'g5plus-april'); ?>"><i class="fa fa-remove"></i>
                        </button>
                        <div class="modal-header">
                            <h4 class="modal-title"><?php _e('Register', 'g5plus-april'); ?></h4>
                            <p><?php _e('Hello. Welcome to your account.', 'g5plus-april'); ?></p>
                        </div>
                        <div class="modal-body">
                            <div class="gsf-popup-login-content">
                                <div class="form-group">
                                    <div class="input-icon">
                                        <input type="text" id="username" class="form-control" name="username"
                                               required="required"
                                               placeholder="<?php _e('Username', 'g5plus-april') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <input type="email" id="email" name="email" class="form-control"
                                               required="required"
                                               placeholder="<?php _e('Email', 'g5plus-april') ?>">
                                    </div>
                                </div>
                                <div class="login-message text-left fs-12"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="action" value="gsf_user_sign_up_ajax"/>
                            <div class="">
                                <button data-style="zoom-in" data-spinner-size="30" data-spinner-color="#fff"
                                        type="submit"
                                        class="ladda-button btn btn-primary btn-classic btn-rounded btn-sm btn-block"><?php echo __('Register', 'g5plus-april'); ?></button>
                            </div>
                            <div
                                class="mg-top-20"><?php _e('The password will be emailed to you!', 'g5plus-april') ?></div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
            die(); // this is required to return a proper result
        }

        public function gsf_user_sign_up_ajax_callback()
        {
            include_once ABSPATH . WPINC . '/ms-functions.php';
            include_once ABSPATH . WPINC . '/user.php';

            global $wpdb;

            //We shall SQL escape all inputs to avoid sql injection.
            $user_name = esc_sql($_REQUEST['username']);
            $user_email = esc_sql($_REQUEST['email']);


            $error = wpmu_validate_user_signup($user_name, $user_email);
            $code = 1;
            $message = '';
            if ($error['errors']->get_error_code() != '') {
                $code = -1;
                foreach ($error['errors']->get_error_messages() as $key => $value) {
                    $message .= '<div/>' . __('<strong>ERROR:</strong> ', 'g5plus-april') . esc_html($value) . '</div>';
                }
            } else {
                register_new_user($user_name, $user_email);
            }

            $response_data = array(
                'code' => $code,
                'message' => $message
            );

            ob_end_clean();
            echo json_encode($response_data);
            die(); // this is required to return a proper result
        }

        public function popup_product_quick_view(){
            $product_id = $_REQUEST['id'];
            global $post, $product;
            $post = get_post($product_id);
            setup_postdata($post);
            $product = wc_get_product( $product_id );
            g5Theme()->helper()->getTemplate('woocommerce/loop/content-product-quick-view');
            wp_reset_postdata();
            die();

        }

        public function portfolio_gallery() {
            $portfolio_id = intval($_REQUEST['id']);
            $media_type =  g5Theme()->metaBoxPortfolio()->get_single_portfolio_media_type($portfolio_id);
            $items = array();

            if ($media_type === 'image') {
                $portfolio_gallery =  g5Theme()->metaBoxPortfolio()->get_single_portfolio_gallery($portfolio_id);
                $portfolio_gallery = explode('|',$portfolio_gallery);
                if (has_post_thumbnail($portfolio_id)) {
                    array_unshift($portfolio_gallery, get_post_thumbnail_id($portfolio_id));
                }
                foreach ($portfolio_gallery as $image_id) {
                    $image = wp_get_attachment_image_src($image_id,'full');
                    if ($image === false) continue;
                    @list($src, $width, $height) = $image;
                    $items[] = array(
                        'src' => $src
                    );
                }
            } else {
                $portfolio_video = g5Theme()->metaBoxPortfolio()->get_single_portfolio_video($portfolio_id);
                if (!empty($portfolio_video) && is_array($portfolio_video)) {
                    foreach ($portfolio_video as $video) {
                        if (wp_oembed_get($video) !== false) {
                            $items[] = array(
                                'src' => $video
                            );
                        }
                    }
                }
                if (sizeof($items) === 0) {
                    if (has_post_thumbnail($portfolio_id)) {
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($portfolio_id),'full');
                        if ($image !== false) {
                            $media_type = 'image';
                            @list($src, $width, $height) = $image;
                            $items[] = array(
                                'src' => $src
                            );
                        }
                    }
                }
            }
            $gallery = array(
                'type' =>  $media_type,
                'items' => $items
            );
            wp_send_json_success($gallery);
            die();
        }

        public function in_admin() {
            return false;
        }
    }
}