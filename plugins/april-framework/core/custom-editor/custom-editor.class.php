<?php
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( !class_exists( 'G5P_Core_Custom_Editor' ) ) {
    class G5P_Core_Custom_Editor
    {
        /**
         * The instance of this object
         *
         * @var null|object
         */
        private static $_instance;

        /**
         * Init G5P_Core_Custom_Editor
         *
         * @return G5P_Core_Custom_Editor|null|object
         */
        public static function getInstance()
        {
            if ( self::$_instance == NULL ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function init()
        {
            add_filter('mce_buttons', array($this, 'custom_editor_register_buttons'));
            add_filter('mce_external_plugins', array($this, 'custom_editor_register_tinymce_javascript'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public function enqueue_scripts()
        {
			wp_enqueue_script(G5P()->assetsHandle('custom-editor'), G5P()->helper()->getAssetUrl('core/custom-editor/assets/js/custom-editor.min.js'), array( 'jquery' ), G5P()->pluginVer(), true);
            wp_localize_script( G5P()->assetsHandle('custom-editor'), 'custom_editor_var',
                array(
                    'menu_name' => esc_html__('Customs', 'april-framework'),
                    'blockquote_text' => array(
                        esc_html__('Blockquote', 'april-framework'),
                        esc_html__('Blockquote - Circle', 'april-framework'),
                        esc_html__('Blockquote - Center', 'april-framework'),
                        is_rtl() ? esc_html__('Blockquote - Right', 'april-framework') : esc_html__('Blockquote - Left', 'april-framework'),
                        is_rtl() ? esc_html__('Blockquote - Left', 'april-framework') : esc_html__('Blockquote - Right', 'april-framework'),
                    ),
                    'content_padding_text' => array(
                        esc_html__('Content Paddings', 'april-framework'),
                        esc_html__('Content ⇠', 'april-framework'),
                        esc_html__('⇢ Content', 'april-framework'),
                        esc_html__('⇢ Content ⇠', 'april-framework'),
                        esc_html__('⇢ Content ⇠⇠', 'april-framework'),
                        esc_html__('⇢⇢ Content ⇠', 'april-framework'),
                        esc_html__('⇢⇢ Content ⇠⇠', 'april-framework'),
                        esc_html__('⇢⇢⇢ Content ⇠⇠⇠', 'april-framework')
                    ),
                    'dropcap_text' => array(
                        esc_html__('Dropcap', 'april-framework'),
                        esc_html__('Dropcap - Simple', 'april-framework'),
                        esc_html__('Dropcap - Square', 'april-framework'),
                        esc_html__('Dropcap - Square Outline', 'april-framework'),
                        esc_html__('Dropcap - Cirlce', 'april-framework'),
                        esc_html__('Dropcap - Circle Outline', 'april-framework')
                    ),
                    'highlighted_text' => array(
                        esc_html__('Highlighted Text', 'april-framework'),
                        esc_html__('Highlighted Yellow', 'april-framework'),
                        esc_html__('Highlighted Red', 'april-framework')
                    ),
                    'column_text' => array(
                        esc_html__('Columns', 'april-framework'),
                        esc_html__('2 Columns', 'april-framework'),
                        esc_html__('3 Columns', 'april-framework'),
                        esc_html__('4 Columns', 'april-framework')
                    ),
                    'custom_list_text' => array(
                        esc_html__('Custom List', 'april-framework'),
                        esc_html__('Check List', 'april-framework'),
                        esc_html__('Star List', 'april-framework'),
                        esc_html__('Edit List', 'april-framework'),
                        esc_html__('Folder List', 'april-framework'),
                        esc_html__('File List', 'april-framework'),
                        esc_html__('Heart List', 'april-framework'),
                        esc_html__('Asterisk List', 'april-framework')
                    ),
                    'divider_text' => array(
                        esc_html__('Drives', 'april-framework'),
                        esc_html__('Drive Full', 'april-framework'),
                        esc_html__('Drive Small', 'april-framework'),
                        esc_html__('Drive Tiny', 'april-framework'),
                        esc_html__('Drive Large', 'april-framework')
                    ),
                    'alert_text' => array(
                        esc_html__('Alerts', 'april-framework'),
                        esc_html__('Alert Simple', 'april-framework'),
                        esc_html__('Alert Success', 'april-framework'),
                        esc_html__('Alert Info', 'april-framework'),
                        esc_html__('Alert Warning', 'april-framework'),
                        esc_html__('Alert Danger', 'april-framework'),
                    ),
                    'white_text' => esc_html__('White Text', 'april-framework')
                )
            );
            wp_enqueue_style(G5P()->assetsHandle('custom-editor'), G5P()->helper()->getAssetUrl('core/custom-editor/assets/css/custom-editor.min.css'), array(), G5P()->pluginVer());
        }

        public function custom_editor_register_buttons( $buttons )
        {
            array_push( $buttons, 'custom_editor', 'separator' );
            return $buttons;
        }

        public function custom_editor_register_tinymce_javascript( $plugin_array )
        {
            $plugin_array['custom_editor'] = G5P()->pluginUrl() . 'core/custom-editor/assets/js/custom-editor-menu.js';
            return $plugin_array;
        }
    }
}