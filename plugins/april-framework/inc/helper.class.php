<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5P_Inc_Helper')) {
	class G5P_Inc_Helper {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		/**
		 * Get template
		 * @param $slug
		 * @param $args
		 */
		public function getTemplate($slug, $args = array()) {
			if ($args && is_array($args)) {
				extract($args);
			}
			$located = G5P()->pluginDir($slug . '.php');
			if (!file_exists($located)) {
				_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $slug), '1.0');

				return;
			}
			include($located);
		}

		/**
		 * Get plugin assets url
		 * @param $file
		 * @return string
		 */
		public function getAssetUrl($file) {
			if (!file_exists(G5P()->pluginDir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
				$ext = explode('.', $file);
				$ext = end($ext);
				$normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
				if ($normal_file != $file) {
					$normal_file = untrailingslashit($normal_file) . ".{$ext}";
					if (file_exists(G5P()->pluginDir($normal_file))) {
						return G5P()->pluginUrl(untrailingslashit($normal_file));
					}
				}
			}
			return G5P()->pluginUrl(untrailingslashit($file));
		}

		public function memorySizeFormat( $size ) {
			$l   = substr( $size, -1 );
			$ret = substr( $size, 0, -1 );
			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
				case 'T':
					$ret *= 1024;
				case 'G':
					$ret *= 1024;
				case 'M':
					$ret *= 1024;
				case 'K':
					$ret *= 1024;
			}
			return $ret;
		}

		public function &get_extra_class(){
			$extra_class = array();
			if (!isset($GLOBALS['gsf_extra_class'])) {
				$extra_class = apply_filters('gsf_extra_class',$extra_class);
				$GLOBALS['gsf_extra_class'] = $extra_class;
			} else {
				$extra_class = $GLOBALS['gsf_extra_class'];
			}
			return $extra_class;
		}

		public function getCurrentPreset(){

			if (isset($GLOBALS['gsf_current_preset'])) {
				return $GLOBALS['gsf_current_preset'];
			}


			$preset = '';
			global $post;
			$post_type = get_post_type($post);
			// post type
			$presetPostType = G5P()->settings()->getPresetPostType();

			foreach ($presetPostType as $key => $value) {
				$configPostType = $key;
				if (isset($value['preset']) && is_array($value['preset'])) {
					foreach ($value['preset'] as $presetKey => $presetValue) {
						if ((($presetKey === 'page_404') && is_404())
							|| (($presetKey == 'blog') && (is_home() || is_category() || is_tag() || is_search() || (is_archive() && $post_type == 'post')))
							|| (isset($presetValue['is_single']) && $presetValue['is_single'] && is_singular($configPostType))
							|| (isset($presetValue['is_archive']) && $presetValue['is_archive'] && is_post_type_archive($configPostType))
							|| (isset($presetValue['category']) && is_tax($presetValue['category']))
							|| (isset($presetValue['tag']) && is_tax($presetValue['tag']))
						) {
							$preset = G5P()->options()->getOptions("preset_{$presetKey}");
							break;
						}
					}
				} else {
					if ((($key === 'page_404') && is_404())
						|| (($key == 'blog') && (is_home() || is_category() || is_tag() || is_search() || (is_archive() && $post_type == 'post')))
						|| (isset($value['is_single']) && $value['is_single'] && is_singular($configPostType))
						|| (isset($value['is_archive']) && $value['is_archive'] && is_post_type_archive($configPostType))
						|| (isset($value['category']) && is_tax($value['category']))
						|| (isset($value['tag']) && is_tax($value['tag']))
					) {
						$preset = G5P()->options()->getOptions("preset_{$key}");
						break;
					}
				}
			}

			// page setting
			if (is_singular()) {
				$presetMetaBox = G5P()->metaBox()->get_page_preset();
				if (!empty($presetMetaBox)) {
					$preset = $presetMetaBox;
				}
			}
			$presets =  GSF()->adminThemeOption()->getPresetOptionKeys(G5P()->getOptionName());

            if(isset($_GET['preset_name']) && !empty($_GET['preset_name']) && array_key_exists($_GET['preset_name'], $presets)) {
                $preset = $_GET['preset_name'];
            }
			if (!isset($presets[$preset])) $preset = '';

			$GLOBALS['gsf_current_preset'] = $preset;
			return $preset;
		}

		public function get_term_ids_from_slugs($slugs, $taxonomy) {
		    $ids = array();
		    if(!empty($slugs)) {
		        foreach ($slugs as $slug) {
		            $term = get_term_by('slug', $slug, $taxonomy);
		            if($term) {
		                $ids[] = $term->term_id;
                    }
                }
            }
            return $ids;
        }

        public function shortCodeContent($content, $echo = true) {
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
            if (!$echo) {
                return $content;
            }
            printf('%s', $content);
        }
	}
}