<?php
if (!class_exists('G5P_Inc_MetaBox')) {
	class G5P_Inc_MetaBox {
		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}
        public function get_page_preset($id = ''){ return $this->getMetaValue('gsf_april_page_preset', $id); }
        public function get_main_layout($id = ''){ return $this->getMetaValue('gsf_april_main_layout', $id); }
        public function get_content_full_width($id = ''){ return $this->getMetaValue('gsf_april_content_full_width', $id); }
        public function get_custom_content_padding($id = ''){ return $this->getMetaValue('gsf_april_custom_content_padding', $id); }
        public function get_content_padding($id = ''){ return $this->getMetaValue('gsf_april_content_padding', $id); }
        public function get_sidebar_layout($id = ''){ return $this->getMetaValue('gsf_april_sidebar_layout', $id); }
        public function get_sidebar($id = ''){ return $this->getMetaValue('gsf_april_sidebar', $id); }
        public function get_page_title_enable($id = ''){ return $this->getMetaValue('gsf_april_page_title_enable', $id); }
        public function get_page_title_content_block($id = ''){ return $this->getMetaValue('gsf_april_page_title_content_block', $id); }
        public function get_page_title_content($id = ''){ return $this->getMetaValue('gsf_april_page_title_content', $id); }
        public function get_css_class($id = ''){ return $this->getMetaValue('gsf_april_css_class', $id); }
        public function get_page_menu($id = ''){ return $this->getMetaValue('gsf_april_page_menu', $id); }
        public function get_page_mobile_menu($id = ''){ return $this->getMetaValue('gsf_april_page_mobile_menu', $id); }
        public function get_is_one_page($id = ''){ return $this->getMetaValue('gsf_april_is_one_page', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $id = get_the_ID();
            }

            $value = get_post_meta($id, $meta_key, true);
            if ($value === '') {
                $default = &$this->getDefault();
                if (isset($default[$meta_key])) {
                    $value = $default[$meta_key];
                }
            }
            return $value;
        }


        public function &getDefault() {
            $default = array (
                'gsf_april_page_preset' => '',
                'gsf_april_main_layout' => '',
                'gsf_april_content_full_width' => '',
                'gsf_april_custom_content_padding' => '',
                'gsf_april_content_padding' =>
                    array (
                        'left' => 0,
                        'right' => 0,
                        'top' => 50,
                        'bottom' => 50,
                    ),
                'gsf_april_sidebar_layout' => '',
                'gsf_april_sidebar' => '',
                'gsf_april_page_title_enable' => '',
                'gsf_april_page_title_content_block' => '',
                'gsf_april_page_title_content' => '',
                'gsf_april_css_class' => '',
                'gsf_april_page_menu' => '',
                'gsf_april_page_mobile_menu' => '',
                'gsf_april_is_one_page' => '',
			);
			return $default;
		}
	}
}