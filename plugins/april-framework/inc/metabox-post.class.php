<?php
if (!class_exists('G5P_Inc_MetaBox_Post')) {
	class G5P_Inc_MetaBox_Post {
		private static $_instance;
		public static function getInstance() {
			if (self::$_instance == NULL) { self::$_instance = new self(); }
			return self::$_instance;
		}
        public function get_single_post_layout($id = ''){ return $this->getMetaValue('gsf_april_single_post_layout', $id); }
        public function get_custom_single_image_padding($id = ''){ return $this->getMetaValue('gsf_april_custom_single_image_padding', $id); }
        public function get_post_single_image_padding($id = ''){ return $this->getMetaValue('gsf_april_post_single_image_padding', $id); }
        public function get_custom_single_image_mobile_padding($id = ''){ return $this->getMetaValue('gsf_april_custom_single_image_mobile_padding', $id); }
        public function get_post_single_image_mobile_padding($id = ''){ return $this->getMetaValue('gsf_april_post_single_image_mobile_padding', $id); }
        public function get_single_reading_process_enable($id = ''){ return $this->getMetaValue('gsf_april_single_reading_process_enable', $id); }
        public function get_single_tag_enable($id = ''){ return $this->getMetaValue('gsf_april_single_tag_enable', $id); }
        public function get_single_share_enable($id = ''){ return $this->getMetaValue('gsf_april_single_share_enable', $id); }
        public function get_single_navigation_enable($id = ''){ return $this->getMetaValue('gsf_april_single_navigation_enable', $id); }
        public function get_single_author_info_enable($id = ''){ return $this->getMetaValue('gsf_april_single_author_info_enable', $id); }
        public function get_single_related_post_enable($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_enable', $id); }
        public function get_single_related_post_algorithm($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_algorithm', $id); }
        public function get_single_related_post_carousel_enable($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_carousel_enable', $id); }
        public function get_single_related_post_per_page($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_per_page', $id); }
        public function get_single_related_post_columns_gutter($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_columns_gutter', $id); }
        public function get_single_related_post_columns($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_columns', $id); }
        public function get_single_related_post_columns_md($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_columns_md', $id); }
        public function get_single_related_post_columns_sm($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_columns_sm', $id); }
        public function get_single_related_post_columns_xs($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_columns_xs', $id); }
        public function get_single_related_post_columns_mb($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_columns_mb', $id); }
        public function get_single_related_post_paging($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_paging', $id); }
        public function get_single_related_post_animation($id = ''){ return $this->getMetaValue('gsf_april_single_related_post_animation', $id); }
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
                'gsf_april_single_post_layout' => '',
                'gsf_april_custom_single_image_padding' => '',
                'gsf_april_post_single_image_padding' =>
                    array (
                        'left' => 0,
                        'right' => 0,
                        'top' => 0,
                        'bottom' => 0,
                    ),
                'gsf_april_custom_single_image_mobile_padding' => '',
                'gsf_april_post_single_image_mobile_padding' =>
                    array (
                        'left' => 0,
                        'right' => 0,
                        'top' => 0,
                        'bottom' => 0,
                    ),
                'gsf_april_single_reading_process_enable' => '',
                'gsf_april_single_tag_enable' => '',
                'gsf_april_single_share_enable' => '',
                'gsf_april_single_navigation_enable' => '',
                'gsf_april_single_author_info_enable' => '',
                'gsf_april_single_related_post_enable' => '',
                'gsf_april_single_related_post_algorithm' => '',
                'gsf_april_single_related_post_carousel_enable' => '',
                'gsf_april_single_related_post_per_page' => '',
                'gsf_april_single_related_post_columns_gutter' => '',
                'gsf_april_single_related_post_columns' => '',
                'gsf_april_single_related_post_columns_md' => '',
                'gsf_april_single_related_post_columns_sm' => '',
                'gsf_april_single_related_post_columns_xs' => '',
                'gsf_april_single_related_post_columns_mb' => '',
                'gsf_april_single_related_post_paging' => '',
                'gsf_april_single_related_post_animation' => '',
            );
            return $default;
        }
    }
}