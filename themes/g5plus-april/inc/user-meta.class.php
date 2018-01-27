<?php
if (!class_exists('G5Plus_Inc_User_Meta')) {
    class G5Plus_Inc_User_Meta {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_social_networks($id = ''){ return $this->getMetaValue('gsf_april_social_networks', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $current_user = wp_get_current_user();
                $id = $current_user->ID;
            }

            $value = get_user_meta($id, $meta_key, true);
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
                'gsf_april_social_networks' =>
                    array (
                        0 =>
                            array (
                                'social_name' => 'Facebook',
                                'social_id' => 'social-facebook',
                                'social_icon' => 'fa fa-facebook',
                                'social_link' => '',
                                'social_color' => '#3b5998',
                            ),
                        1 =>
                            array (
                                'social_name' => 'Twitter',
                                'social_id' => 'social-twitter',
                                'social_icon' => 'fa fa-twitter',
                                'social_link' => '',
                                'social_color' => '#1da1f2',
                            ),
                        2 =>
                            array (
                                'social_name' => 'Pinterest',
                                'social_id' => 'social-pinterest',
                                'social_icon' => 'fa fa-pinterest',
                                'social_link' => '',
                                'social_color' => '#bd081c',
                            ),
                        3 =>
                            array (
                                'social_name' => 'Dribbble',
                                'social_id' => 'social-dribbble',
                                'social_icon' => 'fa fa-dribbble',
                                'social_link' => '',
                                'social_color' => '#00b6e3',
                            ),
                        4 =>
                            array (
                                'social_name' => 'LinkedIn',
                                'social_id' => 'social-linkedIn',
                                'social_icon' => 'fa fa-linkedin',
                                'social_link' => '',
                                'social_color' => '#0077b5',
                            ),
                        5 =>
                            array (
                                'social_name' => 'Vimeo',
                                'social_id' => 'social-vimeo',
                                'social_icon' => 'fa fa-vimeo',
                                'social_link' => '',
                                'social_color' => '#1ab7ea',
                            ),
                        6 =>
                            array (
                                'social_name' => 'Tumblr',
                                'social_id' => 'social-tumblr',
                                'social_icon' => 'fa fa-tumblr',
                                'social_link' => '',
                                'social_color' => '#35465c',
                            ),
                        7 =>
                            array (
                                'social_name' => 'Skype',
                                'social_id' => 'social-skype',
                                'social_icon' => 'fa fa-skype',
                                'social_link' => '',
                                'social_color' => '#00aff0',
                            ),
                        8 =>
                            array (
                                'social_name' => 'Google+',
                                'social_id' => 'social-google-plus',
                                'social_icon' => 'fa fa-google-plus',
                                'social_link' => '',
                                'social_color' => '#dd4b39',
                            ),
                        9 =>
                            array (
                                'social_name' => 'Flickr',
                                'social_id' => 'social-flickr',
                                'social_icon' => 'fa fa-flickr',
                                'social_link' => '',
                                'social_color' => '#ff0084',
                            ),
                        10 =>
                            array (
                                'social_name' => 'YouTube',
                                'social_id' => 'social-youTube',
                                'social_icon' => 'fa fa-youtube',
                                'social_link' => '',
                                'social_color' => '#cd201f',
                            ),
                        11 =>
                            array (
                                'social_name' => 'Foursquare',
                                'social_id' => 'social-foursquare',
                                'social_icon' => 'fa fa-foursquare',
                                'social_link' => '',
                                'social_color' => '#f94877',
                            ),
                        12 =>
                            array (
                                'social_name' => 'Instagram',
                                'social_id' => 'social-instagram',
                                'social_icon' => 'fa fa-instagram',
                                'social_link' => '',
                                'social_color' => '#405de6',
                            ),
                        13 =>
                            array (
                                'social_name' => 'GitHub',
                                'social_id' => 'social-gitHub',
                                'social_icon' => 'fa fa-github',
                                'social_link' => '',
                                'social_color' => '#4078c0',
                            ),
                        14 =>
                            array (
                                'social_name' => 'Xing',
                                'social_id' => 'social-xing',
                                'social_icon' => 'fa fa-xing',
                                'social_link' => '',
                                'social_color' => '#026466',
                            ),
                        15 =>
                            array (
                                'social_name' => 'Behance',
                                'social_id' => 'social-behance',
                                'social_icon' => 'fa fa-behance',
                                'social_link' => '',
                                'social_color' => '#1769ff',
                            ),
                        16 =>
                            array (
                                'social_name' => 'Deviantart',
                                'social_id' => 'social-deviantart',
                                'social_icon' => 'fa fa-deviantart',
                                'social_link' => '',
                                'social_color' => '#05cc47',
                            ),
                        17 =>
                            array (
                                'social_name' => 'Sound Cloud',
                                'social_id' => 'social-soundCloud',
                                'social_icon' => 'fa fa-soundcloud',
                                'social_link' => '',
                                'social_color' => '#ff8800',
                            ),
                        18 =>
                            array (
                                'social_name' => 'Yelp',
                                'social_id' => 'social-yelp',
                                'social_icon' => 'fa fa-yelp',
                                'social_link' => '',
                                'social_color' => '#af0606',
                            ),
                        19 =>
                            array (
                                'social_name' => 'RSS Feed',
                                'social_id' => 'social-rss',
                                'social_icon' => 'fa fa-rss',
                                'social_link' => '',
                                'social_color' => '#f26522',
                            ),
                        20 =>
                            array (
                                'social_name' => 'VK',
                                'social_id' => 'social-vk',
                                'social_icon' => 'fa fa-vk',
                                'social_link' => '',
                                'social_color' => '#45668e',
                            ),
                        21 =>
                            array (
                                'social_name' => 'Email',
                                'social_id' => 'social-email',
                                'social_icon' => 'fa fa-envelope',
                                'social_link' => '',
                                'social_color' => '#4285f4',
                            ),
                    ),
            );
            return $default;
        }
    }
}