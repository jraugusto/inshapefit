<?php
if (!class_exists('G5P_Custom_Vc_Param_Number')) {
	class G5P_Custom_Vc_Param_Number {
		public function __construct(){
            add_action('vc_load_default_params', array($this, 'register_param'));
		}

		public function register_param(){
			vc_add_shortcode_param( 'gsf_number', array($this, 'render_param'));
		}

        public function render_param($settings, $value)
        {
            ob_start();
            G5P()->helper()->getTemplate('core/vc/vc-params/number/templates/number.tpl',array('settings' => $settings, 'value' => $value));
            return ob_get_clean();
        }
	}
	new G5P_Custom_Vc_Param_Number();
}