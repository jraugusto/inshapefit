<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Inc_Require_Plugin')) {
    class G5Plus_Inc_Require_Plugin
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {

            require_once(g5Theme()->themeDir('inc/libs/class-tgm-plugin-activation.php'));

            /*
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */
            $plugins = array(
                array(
                    'name'               => esc_html__('April Framework', 'g5plus-april'), // The plugin name
                    'slug'               => 'april-framework', // The plugin slug (typically the folder name)
                    'source'             => get_template_directory() . '/inc/plugins//april-framework-v2.1.zip', // The plugin source
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required
                    'version'            => '2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url'       => '', // If set, overrides default API URL and points to an external URL
                ),
                array(
                    'name'               => 'Revolution Slider', // The plugin name
                    'slug'               => 'revslider', // The plugin slug (typically the folder name)
                    'source'             => get_template_directory() . '/inc/plugins/revslider_5.4.6.zip', // The plugin source
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required
                    'version'            => '5.4.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url'       => '', // If set, overrides default API URL and points to an external URL
                ),
                array(
                    'name'               => 'Visual Composer', // The plugin name
                    'slug'               => 'js_composer', // The plugin slug (typically the folder name)
                    'source'             => get_template_directory() . '/inc/plugins/js_composer_5.4.4.zip', // The plugin source
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required
                    'version'            => '5.4.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url'       => '', // If set, overrides default API URL and points to an external URL
                ),

                array(
                    'name'               => 'Envato Market', // The plugin name
                    'slug'               => 'envato-market', // The plugin slug (typically the folder name)
                    'source'             => get_template_directory() . '/inc/plugins/envato-market.zip', // The plugin source
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required
                    'version'            => '1.0.0-RC2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url'       => '', // If set, overrides default API URL and points to an external URL
                ),
                array(
                    'name' => esc_html__('Post Views Counter', 'g5plus-april'), // The plugin name
                    'slug' => 'post-views-counter', // The plugin slug (typically the folder name)
                    'required' => false, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name' => esc_html__('G5Plus Post Like', 'g5plus-april'), // The plugin name
                    'slug' => 'g5plus-post-like', // The plugin slug (typically the folder name)
                    'source' => get_template_directory() .  '/inc/plugins//g5plus-post-like-v1.0.zip', // The plugin source
                    'required' => false, // If false, the plugin is only 'recommended' instead of required
                    'version' => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url' => '', // If set, overrides default API URL and points to an external URL
                ),
                array(
                    'name' => 'WooCommerce', // The plugin name
                    'slug' => 'woocommerce', // The plugin slug (typically the folder name)
                    'required' => true, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name' => 'YITH WooCommerce Wishlist', // The plugin name
                    'slug' => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                    'required' => true, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name' => 'YITH Woocommerce Compare', // The plugin name
                    'slug' => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
                    'required' => true, // If false, the plugin is only 'recommended' instead of required
                ),

                array(
                    'name' => 'YITH WooCommerce Ajax Navigation', // The plugin name
                    'slug' => 'yith-woocommerce-ajax-navigation', // The plugin slug (typically the folder name)
                    'required' => true, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name'     => esc_html__('Contact Form 7', 'g5plus-april'), // The plugin name
                    'slug'     => 'contact-form-7', // The plugin slug (typically the folder name)
                    'required' => false, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name'     => esc_html__('WP Mail SMTP', 'g5plus-april'), // The plugin name
                    'slug'     => 'wp-mail-smtp', // The plugin slug (typically the folder name)
                    'required' => false, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name'     => esc_html__('MailChimp for WordPress', 'g5plus-april'), // The plugin name
                    'slug'     => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
                    'required' => false, // If false, the plugin is only 'recommended' instead of required
                ),
                array(
                    'name' => esc_html__('WP Instagram Widget','g5plus-april'),
                    'slug' => 'wp-instagram-widget',
                    'required' => false,
                )
            );

            /*
             * Array of configuration settings. Amend each line as needed.
             * If you want the default strings to be available under your own theme domain,
             * leave the strings uncommented.
             * Some of the strings are added into a sprintf, so see the comments at the
             * end of each line for what each argument will be.
             */

            // Change this to your theme text domain, used for internationalising strings
            $theme_text_domain = 'g5plus-april';
            $config = array(
                'domain'       => $theme_text_domain,
                'id'           => 'g5plus_theme_framework',// Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to pre-packaged plugins.
                'menu'         => 'install-required-plugins', // Menu slug.
                'parent_slug'  => 'themes.php',            // Parent menu slug.
                'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
                'strings'      => array(
                    'page_title'                      => esc_html__('Install Required Plugins', 'g5plus-april'),
                    'menu_title'                      => esc_html__('Install Plugins', 'g5plus-april'),
                    'installing'                      => esc_html__('Installing Plugin: %s', 'g5plus-april'), // %s = plugin name.
                    'oops'                            => esc_html__('Something went wrong with the plugin API.', 'g5plus-april'),
                    'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'g5plus-april'), // %1$s = plugin name(s).
                    'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'g5plus-april'), // %1$s = plugin name(s).
                    'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins', 'g5plus-april'),
                    'activate_link'                   => _n_noop('Begin activating plugin', 'Begin activating plugins', 'g5plus-april'),
                    'return'                          => esc_html__('Return to Required Plugins Installer', 'g5plus-april'),
                    'plugin_activated'                => esc_html__('Plugin activated successfully.', 'g5plus-april'),
                    'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'g5plus-april'), // %s = dashboard link.
                    'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
                )
            );
            tgmpa($plugins, $config);
        }
    }
}