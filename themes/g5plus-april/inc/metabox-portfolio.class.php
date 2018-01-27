<?php
if (!class_exists('G5Plus_Inc_MetaBox_Portfolio')) {
    class G5Plus_Inc_MetaBox_Portfolio {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_single_portfolio_layout($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_layout', $id); }
        public function get_single_portfolio_gallery_layout($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_layout', $id); }
        public function get_single_portfolio_gallery_image_size($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_image_size', $id); }
        public function get_single_portfolio_gallery_image_ratio($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_image_ratio', $id); }
        public function get_single_portfolio_gallery_image_ratio_custom($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_image_ratio_custom', $id); }
        public function get_single_portfolio_gallery_columns_gutter($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_columns_gutter', $id); }
        public function get_single_portfolio_gallery_columns($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_columns', $id); }
        public function get_single_portfolio_gallery_columns_md($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_columns_md', $id); }
        public function get_single_portfolio_gallery_columns_sm($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_columns_sm', $id); }
        public function get_single_portfolio_gallery_columns_xs($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_columns_xs', $id); }
        public function get_single_portfolio_gallery_columns_mb($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery_columns_mb', $id); }
        public function get_single_portfolio_custom_link($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_custom_link', $id); }
        public function get_single_portfolio_media_type($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_media_type', $id); }
        public function get_single_portfolio_gallery($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_gallery', $id); }
        public function get_single_portfolio_video($id = ''){ return $this->getMetaValue('gsf_april_single_portfolio_video', $id); }
        public function get_portfolio_details_client($id = ''){ return $this->getMetaValue('gsf_april_portfolio_details_client', $id); }
        public function get_portfolio_details_location($id = ''){ return $this->getMetaValue('gsf_april_portfolio_details_location', $id); }
        public function get_portfolio_details_gross_building_area($id = ''){ return $this->getMetaValue('gsf_april_portfolio_details_gross_building_area', $id); }
        public function get_portfolio_details_year_completed($id = ''){ return $this->getMetaValue('gsf_april_portfolio_details_year_completed', $id); }
        public function get_portfolio_details_value($id = ''){ return $this->getMetaValue('gsf_april_portfolio_details_value', $id); }
        public function get_portfolio_details_architect($id = ''){ return $this->getMetaValue('gsf_april_portfolio_details_architect', $id); }
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
                'gsf_april_single_portfolio_layout' => '',
                'gsf_april_single_portfolio_gallery_layout' => 'carousel',
                'gsf_april_single_portfolio_gallery_image_size' => 'medium',
                'gsf_april_single_portfolio_gallery_image_ratio' => '1x1',
                'gsf_april_single_portfolio_gallery_image_ratio_custom' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'gsf_april_single_portfolio_gallery_columns_gutter' => '10',
                'gsf_april_single_portfolio_gallery_columns' => '3',
                'gsf_april_single_portfolio_gallery_columns_md' => '3',
                'gsf_april_single_portfolio_gallery_columns_sm' => '2',
                'gsf_april_single_portfolio_gallery_columns_xs' => '2',
                'gsf_april_single_portfolio_gallery_columns_mb' => '1',
                'gsf_april_single_portfolio_custom_link' => '',
                'gsf_april_single_portfolio_media_type' => 'image',
                'gsf_april_single_portfolio_gallery' => '',
                'gsf_april_single_portfolio_video' =>
                    array (
                        0 => '',
                    ),
                'gsf_april_portfolio_details_client' => '',
                'gsf_april_portfolio_details_location' => '',
                'gsf_april_portfolio_details_gross_building_area' => '',
                'gsf_april_portfolio_details_year_completed' => '',
                'gsf_april_portfolio_details_value' => '',
                'gsf_april_portfolio_details_architect' => '',
            );
            return $default;
        }
    }
}