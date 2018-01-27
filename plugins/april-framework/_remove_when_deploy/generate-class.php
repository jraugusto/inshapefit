<?php
if (!class_exists('DEV_Generate_Class')) {
	class DEV_Generate_Class {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
		public function init() {
			add_action('wp_ajax_gsf_generate_class', array($this, 'renderClass'));
		}

		public function renderClass() {
			$type = $_GET['type'];
			$class_name = isset($_GET['class_name']) ? $_GET['class_name'] : '';
			$GLOBALS['gsf_options_default'] = array();

			switch ($type) {
				case 'option': {
					if (empty($class_name)) {
						$class_name = 'G5P_Inc_Options';
					}
					$page = $_GET['page'];
					$configs = GSF()->adminThemeOption()->getOptionConfig($page, false);
					$option_name = $configs['option_name'];

					$s = $this->getStartClass($class_name);
					$s .= $this->getConfigMethod($configs, $type);
					$s .= $this->getOptionMethod($option_name);
					$s .= $this->getEndClass();
					echo $s;
					die();
				}
				case 'post_meta': {
					if (empty($class_name)) {
						$class_name = 'G5P_Inc_MetaBox';
					}
					$meta_id = $_GET['meta_id'];
					$meta_configs = GSF()->adminMetaBoxes()->getMetaConfig();
					$s = $this->getStartClass($class_name);

					$s .= $this->getConfigMethod($meta_configs[$meta_id], $type);

					$s .= $this->getPostMetaMethod();
					$s .= $this->getEndClass();

					echo $s;
					die();
					break;
				}

				case 'term_meta': {
					if (empty($class_name)) {
						$class_name = 'G5P_Inc_Term_Meta';
					}
					$meta_id = $_GET['meta_id'];
					$meta_configs = GSF()->adminTaxonomy()->getMetaConfig();
					$s = $this->getStartClass($class_name);

					$s .= $this->getConfigMethod($meta_configs[$meta_id], $type);

					$s .= $this->getTermMetaMethod();
					$s .= $this->getEndClass();

					echo $s;
					die();
					break;
				}
				case 'user_meta': {
					if (empty($class_name)) {
						$class_name = 'G5P_Inc_User_Meta';
					}
					$meta_id = $_GET['meta_id'];
					$meta_configs = GSF()->adminUserMeta()->getMetaConfig();
					$s = $this->getStartClass($class_name);

					$s .= $this->getConfigMethod($meta_configs[$meta_id], $type);

					$s .= $this->getUserMetaMethod();
					$s .= $this->getEndClass();

					echo $s;
					die();
					break;
				}
			}
		}

		private function getStartClass($class_name) {
			$s = '<?php';
			$s .= "\nif (!class_exists('$class_name')) {";
			$s .= "\nclass $class_name {";
			$s .= "\n\tprivate static \$_instance;";
			$s .= "\n\tpublic static function getInstance() {";
			$s .= "\n\tif (self::\$_instance == NULL) { self::\$_instance = new self(); }";
			$s .= "\n\treturn self::\$_instance;";
			$s .= "\n\t}";
			return $s;
		}

		private function getEndClass() {
			$default_array_string = var_export($GLOBALS['gsf_options_default'], true);

			$s = "\n";
			$s .= "\n\tpublic function &getDefault() {";
			$s .= "\n\t\t\$default = $default_array_string;";
			$s .= "\n\treturn \$default;";
			$s .= "\n\t}";
			$s .= "\n}";
			$s .= "\n}";

			return $s;
		}

		private function getConfigMethod($configs, $meta_type) {
			$s = '';
			if (isset($configs['section'])) {
				foreach ($configs['section'] as $key => &$section) {
					if (isset($section['fields'])) {
						$s .= $this->getConfigMethodField($section['fields'], $meta_type);
					}
				}
			}
			else {
				if (isset($configs['fields'])) {
					$s .= $this->getConfigMethodField($configs['fields'], $meta_type);
				}
			}
			return $s;
		}
		private function getConfigMethodField($configs, $meta_type) {
			$s = '';
			foreach ($configs as $key => &$config) {
				$type = isset($config['type']) ? $config['type'] : '';
				$id = isset($config['id']) ? $config['id'] : '';
				if (empty($type)) {
					continue;
				}

				switch ($type) {
					case 'group':
					case 'row':
						if (isset($config['fields'])) {
							$s .= $this->getConfigMethodField($config['fields'], $meta_type);
						}
						break;
					case 'divide':
					case 'info':
						break;
					default:
						if (!empty($id)) {
							$field = GSF()->helper()->createField($type);
							$field->_setting = $config;
							$default =  $field->getFieldDefault();
							$GLOBALS['gsf_options_default'][$id] = $default;

							switch ($meta_type) {
								case 'post_meta':
								case 'term_meta':
								case 'user_meta': {
									$prefix = G5P()->getMetaPrefix();
									$attr_id = preg_replace("/^{$prefix}/", '', $id);
									$s .= sprintf("\n\tpublic function get_%s(\$id = ''){ return \$this->getMetaValue('%s', \$id); }", $attr_id, $id);
									break;
								}
								case 'option': {
									$s .= sprintf("\n\tpublic function get_%s(){ return \$this->getOptions('%s'); }", $id, $id);
									break;
								}
							}


						}
						break;
				}
			}
			return $s;
		}

		private function getOptionMethod($option_name) {
			$s = <<<FUC_STR

	public function getOptions(\$key) {
		if (function_exists('GSF')) {
			\$option = &GSF()->adminThemeOption()->getOptions('$option_name');
		} else {
			\$option = &\$this->getDefault();
		}
		if (isset(\$option[\$key])) {
			return \$option[\$key];
		}
		\$option = &\$this->getDefault();
		if (isset(\$option[\$key])) {
			return \$option[\$key];
		}
		return '';
	}

	public function setOptions(\$key, \$value) {
		if (function_exists('GSF')) {
			\$option = &GSF()->adminThemeOption()->getOptions('$option_name');
		} else {
			\$option = &\$this->getDefault();
		}
		\$option[\$key] = \$value;
	}
FUC_STR;

			return $s;
		}

		private function getPostMetaMethod() {
			$s = <<<FUC_STR

	public function getMetaValue(\$meta_key, \$id = '') {
		if (\$id === '') {
			\$id = get_the_ID();
		}

		\$value = get_post_meta(\$id, \$meta_key, true);
		if (\$value === '') {
			\$default = &\$this->getDefault();
			if (isset(\$default[\$meta_key])) {
				\$value = \$default[\$meta_key];
			}
		}
		return \$value;
	}

FUC_STR;

			return $s;
		}

		private function getTermMetaMethod() {
			$s = <<<FUC_STR

	public function getMetaValue(\$meta_key, \$id = '') {
		if (\$id === '') {
			\$queried_object = get_queried_object();
			\$id = \$queried_object->term_id;
		}

		\$value = get_term_meta(\$id, \$meta_key, true);
		if (\$value === '') {
			\$default = &\$this->getDefault();
			if (isset(\$default[\$meta_key])) {
				\$value = \$default[\$meta_key];
			}
		}
		return \$value;
	}

FUC_STR;
			return $s;
		}

		private function getUserMetaMethod() {
			$s = <<<FUC_STR

	public function getMetaValue(\$meta_key, \$id = '') {
		if (\$id === '') {
			\$current_user = wp_get_current_user();
			\$id = \$current_user->ID;
		}

		\$value = get_user_meta(\$id, \$meta_key, true);
		if (\$value === '') {
			\$default = &\$this->getDefault();
			if (isset(\$default[\$meta_key])) {
				\$value = \$default[\$meta_key];
			}
		}
		return \$value;
	}

FUC_STR;
			return $s;
		}

	}
}