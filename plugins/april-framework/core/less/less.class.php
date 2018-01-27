<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!function_exists('G5P_Core_Less')) {
	class G5P_Core_Less
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
			// compile sass to css only dev
			add_action('wp_ajax_gsf_dev_less_to_css', array($this, 'devCompileCss'));
			add_action('wp_ajax_nopriv_gsf_dev_less_to_css', array($this, 'devCompileCss'));

            add_action('wp_ajax_gsf_dev_less_to_css_rtl', array($this, 'devCompileCssRTL'));
            add_action('wp_ajax_nopriv_gsf_dev_less_to_css_rtl', array($this, 'devCompileCssRTL'));

			add_action('wp_ajax_gsf_dev_less_skin_to_css', array($this, 'devCompileSkinCss'));
			add_action('wp_ajax_nopriv_gsf_dev_less_skin_to_css', array($this, 'devCompileSkinCss'));

			add_action('gsf_before_enqueue_skin_css', array($this, 'createSkinCssFile'));

			add_action('gsf_after_change_options/' . G5P()->getOptionSkinName(), array($this, 'deleteSkinCssFile'));

			add_action('gsf_after_change_options/' . G5P()->getOptionName(), array($this, 'deleteSkinCssFile'));

			add_action('gsf_after_change_options/' . G5P()->getOptionName(), array($this, 'deleteMainCssFile'), 10, 2);

			add_action('gsf_after_change_options/' . G5P()->getOptionName(), array($this, 'deleteRTLCssFile'));

			add_action('gsf_before_enqueue_main_css', array($this, 'createMainCssFile'));

			add_action('gsf_after_delete_preset', array($this, 'deletePresetCssFile'), 10, 2);

			add_action('gsf_before_enqueue_main_css_rtl',array($this,'createRTLCssFile'));



		}

		private function shortCodeDir()
		{
			return G5P()->pluginDir('shortcodes/');
		}

		private function lessDir()
		{
			return trailingslashit(get_template_directory()) . 'assets/less/';
		}

		private function themeDir()
		{
			return trailingslashit(get_template_directory());
		}

		private function themeUrl()
		{
			return trailingslashit(get_template_directory_uri());
		}

		public function presetDir()
		{
			return $this->themeDir() . 'assets/preset/';
		}

		public function skinDir()
		{
			return $this->themeDir() . 'assets/skin/';
		}

		/**
		 * Get Css From Less
		 *
		 * @param array $files
		 * @param bool $compress
		 * @param string $variable
		 * @return string
		 */
		public function getCssFromLess($files = array(), $compress = true, $variable = '')
		{
			require_once G5P()->pluginDir('core/less/Less.php');
			$parser = new Less_Parser(array('compress' => $compress));
			if ($variable === '') {
				$variable = $this->getMainVariable();
			}
			$parser->parse($variable);
			foreach ($files as $file) {
				if (file_exists($file)) {
					$parser->parseFile($file, $this->themeUrl());
				}
			}
			return $parser->getCss();
		}


		/**
		 * Compress Css
		 *
		 * @param string $css
		 * @return string
		 */
		public function compressCss($css = '')
		{
			require_once G5P()->pluginDir('core/less/Less.php');
			$parser = new Less_Parser(array('compress' => true));
			$parser->parse($css);
			return $parser->getCss();
		}

		/**
		 * Get Theme Header Info
		 *
		 * @return mixed
		 */
		private function getThemeInfo()
		{
			return G5P()->file()->getContents($this->themeDir() . 'theme-info.txt');
		}


		public function devCompileCss()
		{
			/**
			 * Make sure we set the correct MIME type
			 */
			header('Content-Type: text/css');

			/**
			 * Render Style CSS
			 */
			echo $this->getCssFromLess($this->getMainFile(), false);
			$this->shortCodesCss('echo');
			die();
		}

		public function devCompileCssRTL()
        {
            /**
             * Make sure we set the correct MIME type
             */
            header('Content-Type: text/css');
            /**
             * Render RTL CSS
             */
            echo $this->getCssFromLess(array($this->lessDir() . 'rtl.less'), false);
            die();
        }

		public function devCompileSkinCss()
		{
			/**
			 * Make sure we set the correct MIME type
			 */
			header('Content-Type: text/css');

			$skin_id = isset($_GET['skin_id']) ? $_GET['skin_id'] : '';
			echo $this->getSkinCss($skin_id, false);
			die();
		}

		private function getMainFile()
		{
			$files = array($this->lessDir() . 'style.less');
            if (class_exists('WooCommerce')) {
                $files[] = $this->lessDir() . 'woocommerce.less';
            }
            $custom_post_type_disable = G5P()->options()->get_custom_post_type_disable();
            if(!in_array('portfolio', $custom_post_type_disable)) {
                $files[] = $this->lessDir() . 'portfolio.less';
            }
			$loading_animation = G5P()->options()->get_loading_animation();
			if (array_key_exists($loading_animation, G5P()->settings()->get_loading_animation())) {
				$files[] = $this->lessDir() . "loading/{$loading_animation}.less";
			}
			return $files;
		}

		public function createEditorCssFile()
		{

			require_once G5P()->pluginDir('core/less/Less.php');
			$parser = new Less_Parser(array('compress' => false));

			$parser->parse($this->getMainVariable());
			$parser->parseFile($this->lessDir() . 'editor.less');

			$custom_css = <<<CSS
body {
	margin: 10px !important;
}
CSS;
			$parser->parse($custom_css);
			$css = $parser->getCss();

			$file_path = $this->themeDir() . 'assets/css/editor-style.css';

			echo "**LESS TO CSS:$file_path<br/>";

			if (!G5P()->file()->putContents($file_path, $css)) {
				echo "ERROR MIN:$file_path<br/>";
			}

		}

		public function getSkinCss($skin_id, $compress = true)
		{
			if (empty($skin_id)) return '';
			$files = array($this->lessDir() . 'skin.less');
			$variables = $this->getSkinVariable($skin_id);
			$accent_color = G5P()->options()->get_accent_color();
			$foreground_accent_color = G5P()->options()->get_foreground_accent_color();
			$variable = <<<LESS_VARIABLE
			@accent_color: {$accent_color};
			@foreground_accent_color: {$foreground_accent_color};
LESS_VARIABLE;
			foreach ($variables as $key => $value) {
				$variable .= "@{$key}: {$value};\r\n";
			}

			return $this->getCssFromLess($files, $compress, $variable);
		}


		public function shortCodesCss($type = '')
		{
			$file_paths = glob($this->shortCodeDir() . '*/assets/css/*.less');
			foreach ($file_paths as $file_path) {
				$name = wp_basename($file_path);
				$path = substr($file_path, 0, strlen($file_path) - strlen($name));

				$less_file_exp = explode('.', $name);
				$file_name = $less_file_exp[0];

				$less = array($this->lessDir() . 'variable.less', $file_path);
				if ($type == 'echo') {
					echo $this->getCssFromLess($less, false);
				} else {
					echo "**LESS TO CSS:$file_path<br/>";
					if (!G5P()->file()->putContents($path . $file_name . '.min.css', $this->getCssFromLess($less))) {
						echo "ERROR MIN:$file_path<br/>";
					}

					if (!G5P()->file()->putContents($path . $file_name . '.css', $this->getCssFromLess($less, false))) {
						echo "ERROR CSS:$file_path<br/>";
					}
				}
			}
		}


		/**
		 *
		 * Get Main Variable
		 * @return array
		 */
		public function getMainVariable()
		{
			$body_font = G5P()->options()->get_body_font();
            $body_font = GSF()->core()->fonts()->processFont($body_font);
            $body_font_family = GSF()->core()->fonts()->getFontFamily($body_font['font_family']);

			$primary_font = G5P()->options()->get_primary_font();
			$primary_font = GSF()->core()->fonts()->getFontFamily($primary_font['font_family']);

            $h1_font = G5P()->options()->get_h1_font();
            $h1_font = GSF()->core()->fonts()->processFont($h1_font);
            $h1_font_family = GSF()->core()->fonts()->getFontFamily($h1_font['font_family']);

            $h2_font = G5P()->options()->get_h2_font();
            $h2_font = GSF()->core()->fonts()->processFont($h2_font);
            $h2_font_family = GSF()->core()->fonts()->getFontFamily($h2_font['font_family']);

            $h3_font = G5P()->options()->get_h3_font();
            $h3_font = GSF()->core()->fonts()->processFont($h3_font);
            $h3_font_family = GSF()->core()->fonts()->getFontFamily($h3_font['font_family']);

            $h4_font = G5P()->options()->get_h4_font();
            $h4_font = GSF()->core()->fonts()->processFont($h4_font);
            $h4_font_family = GSF()->core()->fonts()->getFontFamily($h4_font['font_family']);

            $h5_font = G5P()->options()->get_h5_font();
            $h5_font = GSF()->core()->fonts()->processFont($h5_font);
            $h5_font_family = GSF()->core()->fonts()->getFontFamily($h5_font['font_family']);

            $h6_font = G5P()->options()->get_h6_font();
            $h6_font = GSF()->core()->fonts()->processFont($h6_font);
            $h6_font_family = GSF()->core()->fonts()->getFontFamily($h6_font['font_family']);

			$menu_font = G5P()->options()->get_menu_font();
            $menu_font = GSF()->core()->fonts()->processFont($menu_font);
			$menu_font_family = GSF()->core()->fonts()->getFontFamily($menu_font['font_family']);

			$sub_menu_font = G5P()->options()->get_sub_menu_font();
            $sub_menu_font = GSF()->core()->fonts()->processFont($sub_menu_font);
			$sub_menu_font_family = GSF()->core()->fonts()->getFontFamily($sub_menu_font['font_family']);

			$header_responsive_breakpoint = G5P()->options()->get_header_responsive_breakpoint();
			$accent_color = G5P()->options()->get_accent_color();
			$foreground_accent_color = G5P()->options()->get_foreground_accent_color();

			$spinner_color = G5P()->options()->get_spinner_color();
			if (empty($spinner_color)) {
				$spinner_color = $accent_color;
			}

			$header_layout = G5P()->options()->get_header_layout();
			$header_spacing_default = &$this->get_header_spacing_default($header_layout);

			$logo_max_height = G5P()->options()->get_logo_max_height();
			$logo_max_height = $this->process_unit_value(isset($logo_max_height['height']) ? $logo_max_height['height'] : '', $header_spacing_default['logo_max_height']);

			$mobile_logo_max_height = G5P()->options()->get_mobile_logo_max_height();
			$mobile_logo_max_height = $this->process_unit_value(isset($mobile_logo_max_height['height']) ? $mobile_logo_max_height['height'] : '', '80');

			$logo_padding = G5P()->options()->get_logo_padding();
			$logo_padding = $this->process_spacing($logo_padding, array(
				'top' => $header_spacing_default['logo_padding_top'],
				'bottom' => $header_spacing_default['logo_padding_bottom'],
			));

			$mobile_logo_padding = G5P()->options()->get_mobile_logo_padding();
			$mobile_logo_padding = $this->process_spacing($mobile_logo_padding, array(
				'top' => '10px',
				'bottom' => '10px',
			));

			$navigation_height = G5P()->options()->get_navigation_height();
			$navigation_height = $this->process_unit_value(isset($navigation_height['height']) ? $navigation_height['height'] : '', $header_spacing_default['navigation_height']);
			if ('header-6' !== $header_layout) {
				$navigation_height = $logo_max_height;
			}
			$navigation_spacing = $this->process_unit_value(G5P()->options()->get_navigation_spacing(), '30');
			$header_customize_nav_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_nav_spacing(), '15');
			$header_customize_left_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_left_spacing(), '15');
			$header_customize_right_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_right_spacing(), '15');
			$header_customize_mobile_spacing = $this->process_unit_value(G5P()->options()->get_header_customize_mobile_spacing(), '15');


			/**
			 * Content Skin
			 */
			$content_skin_variables = $this->getSkinVariable(G5P()->options()->getOptions('content_skin'));
			$text_color = $content_skin_variables['text_color'];
            $text_hover_color = (isset($content_skin_variables['text_hover_color']) && !empty($content_skin_variables['text_hover_color'])) ? $content_skin_variables['text_hover_color'] : G5P()->options()->get_accent_color();
			$background_color = $content_skin_variables['background_color'];
			$heading_color = $content_skin_variables['heading_color'];
			$disable_color = $content_skin_variables['disable_color'];
			$border_color = $content_skin_variables['border_color'];


			return <<<LESS_VARIABLE
			@body_font : '{$body_font_family}';
			@body_font_size:  {$body_font['font_size']};
			@body_font_weight : {$body_font['font_weight']};
			@body_font_style : {$body_font['font_style']};
			@primary_font : '{$primary_font}';
			@h1_font : '{$h1_font_family}';
			@h1_font_size:  {$h1_font['font_size']};
			@h1_font_weight : {$h1_font['font_weight']};
			@h1_font_style : {$h1_font['font_style']};
			@h2_font : '{$h2_font_family}';
			@h2_font_size:  {$h2_font['font_size']};
			@h2_font_weight : {$h2_font['font_weight']};
			@h2_font_style : {$h2_font['font_style']};
			@h3_font : '{$h3_font_family}';
			@h3_font_size:  {$h3_font['font_size']};
			@h3_font_weight : {$h3_font['font_weight']};
			@h3_font_style : {$h3_font['font_style']};
			@h4_font : '{$h4_font_family}';
			@h4_font_size:  {$h4_font['font_size']};
			@h4_font_weight : {$h4_font['font_weight']};
			@h4_font_style : {$h4_font['font_style']};
			@h5_font : '{$h5_font_family}';
			@h5_font_size:  {$h5_font['font_size']};
			@h5_font_weight : {$h5_font['font_weight']};
			@h5_font_style : {$h5_font['font_style']};
			@h6_font : '{$h6_font_family}';
			@h6_font_size:  {$h6_font['font_size']};
			@h6_font_weight : {$h6_font['font_weight']};
			@h6_font_style : {$h6_font['font_style']};
			@menu_font: '{$menu_font_family}';
			@menu_font_size: {$menu_font['font_size']};
			@menu_font_weight: {$menu_font['font_weight']};
			@menu_font_style: {$menu_font['font_style']};
			@sub_menu_font: '{$sub_menu_font_family}';
			@sub_menu_font_size: {$sub_menu_font['font_size']};
			@sub_menu_font_weight: {$sub_menu_font['font_weight']};
			@sub_menu_font_style: {$sub_menu_font['font_style']};
			@header_responsive_breakpoint: {$header_responsive_breakpoint}px;
			@spinner_color: {$spinner_color};
			@accent_color: {$accent_color};
			@foreground_accent_color: {$foreground_accent_color};
			@logo_max_height: {$logo_max_height};
			@logo_padding_top: {$logo_padding['top']};
			@logo_padding_bottom: {$logo_padding['bottom']};
			@mobile_logo_max_height: {$mobile_logo_max_height};
			@mobile_logo_padding_top: {$mobile_logo_padding['top']};
			@mobile_logo_padding_bottom: {$mobile_logo_padding['bottom']};
			@navigation_height: {$navigation_height};
			@navigation_spacing: {$navigation_spacing};
			@header_customize_nav_spacing: {$header_customize_nav_spacing};
			@header_customize_left_spacing: {$header_customize_left_spacing};
			@header_customize_right_spacing: {$header_customize_right_spacing};
			@header_customize_mobile_spacing: {$header_customize_mobile_spacing};
			@text_color: {$text_color};
			@text_hover_color: {$text_hover_color};
			@background_color: {$background_color};
			@heading_color: {$heading_color};
			@disable_color: {$disable_color};
			@border_color: {$border_color};

LESS_VARIABLE;
		}

		private function process_unit_value($value, $default)
		{
			return (empty($value) ? $default : $value) . 'px';
		}

		private function process_spacing($spacing, $default)
		{
			foreach ($default as $key => $value) {
				$spacing[$key] = (!isset($spacing[$key]) || empty($spacing[$key]) ? $value : $spacing[$key]) . 'px';
			}
			return $spacing;
		}

		private function &get_header_spacing_default($header_layout)
		{
			$header_default = null;
			switch ($header_layout) {
				case 'header-7':
				case 'header-8':
					$header_default = array(
						'navigation_height' => '40',
						'header_padding_top' => '0',
						'header_padding_bottom' => '0',
						'logo_max_height' => '170',
						'logo_padding_top' => '10',
						'logo_padding_bottom' => '10',
					);
					break;
				case 'header-6':
					$header_default = array(
						'navigation_height' => '70',
						'header_padding_top' => '0',
						'header_padding_bottom' => '0',
						'logo_max_height' => '150',
						'logo_padding_top' => '10',
						'logo_padding_bottom' => '10',
					);
					break;
				default:
					$header_default = array(
						'navigation_height' => '120',
						'header_padding_top' => '0',
						'header_padding_bottom' => '0',
						'logo_max_height' => '120',
						'logo_padding_top' => '10',
						'logo_padding_bottom' => '10',
					);
					break;
			}
			return $header_default;
		}

		private function getSkinsVariable()
		{
			$color_keys = array(
				'background_color',
				'text_color',
                'text_hover_color',
				'heading_color',
				'disable_color',
				'border_color',
			);
			$skins = array();
			$options_default = G5P()->optionsSkin()->getDefault();
			$css_variable_default = $options_default['color_skin'][0];
			$color_skin = G5P()->optionsSkin()->get_color_skin();
			if (is_array($color_skin)) {
				foreach ($color_skin as $key => $value) {
					foreach ($color_keys as $color_key) {
						$value[$color_key] = empty($value[$color_key]) ? $css_variable_default[$color_key] : $value[$color_key];
						if($color_key === 'text_hover_color' && empty($value[$color_key])) {
						    $value[$color_key] = G5P()->options()->get_accent_color();
                        }
					}
					if (isset($value['skin_id'])) {
						$skins[$value['skin_id']] = $value;
					}
				}
			}
			return $skins;
		}

		public function getSkinVariable($skin_id)
		{
			$skins = $this->getSkinsVariable();
			if (array_key_exists($skin_id, $skins)) {
				return $skins[$skin_id];
			}
			$options_default = G5P()->optionsSkin()->getDefault();
			return $options_default['color_skin'][0];
		}


		/**
		 * Create Skin Css File
		 *
		 * @param $skin_id
		 */
		public function createSkinCssFile($skin_id)
		{

			$file = $this->skinDir() . "{$skin_id}.css";
			$fileMin = $this->skinDir() . "{$skin_id}.min.css";

			if (file_exists($fileMin)) return;

			$skinCss = $this->getSkinCss($skin_id, false);
			if (!file_exists($this->skinDir())) {
                G5P()->file()->mkdir($this->skinDir());
			}
            G5P()->file()->putContents($file, $skinCss);

			$skinCss = $this->compressCss($skinCss);
            G5P()->file()->putContents($fileMin, $skinCss);
		}

		/**
		 * Delete Skin Css
		 */
		public function deleteSkinCssFile()
		{
			if (!defined('CSS_DEBUG') || CSS_DEBUG == false) {
				G5P()->file()->rmdir($this->skinDir(), true);
			}
		}

		/**
		 * Delete Main File Css
		 *
		 * @param $options
		 * @param $current_preset
		 */
		public function deleteMainCssFile($options, $current_preset)
		{
			if (!defined('CSS_DEBUG') || CSS_DEBUG == false) {
				if (empty($current_preset)) {
					// remove file style.min.css
					$file = $this->themeDir() . 'style.min.css';
					if (file_exists($file)) {
						G5P()->file()->delete($file, false, 'f');
					}
				}
				G5P()->file()->rmdir($this->presetDir(), true);
			}
		}

		/**
		 * Delete Preset Css File
		 *
		 * @param $options
		 * @param $current_preset
		 */
		public function deletePresetCssFile($options, $current_preset)
		{
			if (!defined('CSS_DEBUG') || CSS_DEBUG == false) {
				$presetFilePath = array(
					$this->presetDir() . "{$current_preset}.min.css",
					$this->presetDir() . "{$current_preset}.css"
				);
				foreach ($presetFilePath as $file) {
					if (file_exists($file)) {
						G5P()->file()->delete($file, false, 'f');
					}
				}
			}
		}


		/**
		 * Create Main File Css
		 *
		 * @param $preset
		 */
		public function createMainCssFile($preset)
		{
			$fileMin = $this->themeDir() . 'style.min.css';
			$file = $this->themeDir() . 'style.css';
			$dir = $this->themeDir();

			if (!empty($preset)) {
				$fileMin = $this->presetDir() . "{$preset}.min.css";
				$file = $this->presetDir() . "{$preset}.css";
				$dir = $this->presetDir();
			}

			if (file_exists($fileMin)) return;

			$css = '';
			if (empty($preset)) {
				$css = $this->getThemeInfo();
			}

			$css .= $this->getCssFromLess($this->getMainFile(), false);
			if (!empty($preset) && !file_exists($dir)) {
                G5P()->file()->mkdir($dir);
			}

			G5P()->file()->putContents($file, $css);

			$css = $this->compressCss($css);
            G5P()->file()->putContents($fileMin, $css);
		}

		/**
		 * Create RTL File Css
		 */
		public function createRTLCssFile() {
			$fileMin = $this->themeDir() . 'assets/css/rtl.min.css';
			$file = $this->themeDir() . 'assets/css/rtl.css';
			$dir = $this->themeDir() . 'assets/css';

			if (file_exists($fileMin)) return;

			$css = $this->getCssFromLess(array($this->lessDir() . 'rtl.less'), false);

			if (!file_exists($dir)) {
                G5P()->file()->mkdir($dir);
			}

            G5P()->file()->putContents($file, $css);
			$css = $this->compressCss($css);
            G5P()->file()->putContents($fileMin, $css);
		}

		/**
		 * Delete File RTL Css
		 */
		public function deleteRTLCssFile() {
			if (!defined('CSS_DEBUG') || CSS_DEBUG == false) {
				$presetFilePath = array(
					$this->themeDir() . "assets/css/rtl.min.css",
					$this->themeDir() . "assets/css/rtl.css"
				);
				foreach ($presetFilePath as $file) {
					if (file_exists($file)) {
						G5P()->file()->delete($file, false, 'f');
					}
				}
			}
		}

	}
}