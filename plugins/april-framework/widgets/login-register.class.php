<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Login_Register')) {
    class G5P_Widget_Login_Register extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'widget-login-register';
            $this->widget_description = esc_html__("Display login register text", 'april-framework');
            $this->widget_id = 'gsf-login-register';
            $this->widget_name = esc_html__('G5Plus: Login - Register', 'april-framework');
            $this->settings = array(
                'fields' => array(
                    array(
                        'id' => 'login_text',
                        'type' => 'text',
                        'default' => esc_html__('Sign In', 'april-framework'),
                        'title' => esc_html__('Login Text', 'april-framework')
                    ),
                    array(
                        'id' => 'register_text',
                        'type' => 'text',
                        'default' => esc_html__('Join', 'april-framework'),
                        'title' => esc_html__('Register Text', 'april-framework')
                    )
                )
            );
            parent::__construct();
        }

        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $login_text = (!empty($instance['login_text'])) ? $instance['login_text'] : esc_html__('Sign In', 'april-framework');
            $register_text = (!empty($instance['register_text'])) ? $instance['register_text'] : esc_html__('Join', 'april-framework');
            ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if (!is_user_logged_in()): ?>
                <a class="gsf-login-link-sign-in" href="#"><?php echo esc_html($login_text); ?></a>
                <span class="gsf-login-register-separator"> / </span>
                <a class="gsf-login-link-sign-up" href="#"><?php echo esc_html($register_text); ?></a>
            <?php else: ?>
                <?php
                $current_user = wp_get_current_user();
                $display_name = empty($current_user->display_name) ? $current_user->user_login : $current_user->display_name;
                echo esc_html($display_name) . ',';
                ?>
            <a href="<?php echo esc_url(wp_logout_url(is_home() ? home_url('/') : get_permalink())); ?>"><i class="fa fa-unlock-alt"></i> <?php _e('Logout', 'april-framework'); ?></a>
            <?php endif; ?>
            <?php echo wp_kses_post($args['after_widget']);
        }
    }
}