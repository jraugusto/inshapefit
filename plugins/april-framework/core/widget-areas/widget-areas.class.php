<?php
if (!class_exists('G5P_Core_Widget_Areas')) {
	class G5P_Core_Widget_Areas {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		protected $widget_areas = array();

		protected $version = '1.0';

		protected $widget_areas_key =  'gsf-widget-areas';

		public function init() {
			add_action('widgets_init',array($this, 'register_custom_widget_areas'),11);
			if (is_admin()) {
				add_action( 'admin_print_scripts', array($this, 'add_new_widget_area_box') );
				add_action( 'load-widgets.php', array($this, 'add_widget_area_area'), 100 );
				add_action( 'load-widgets.php', array( $this, 'enqueue' ), 100 );
				add_action( 'wp_ajax_gsf_delete_widget_area', array( $this, 'delete_widget_area' ) );
			}
		}

		public function enqueue() {
			wp_enqueue_script(G5P()->assetsHandle('widget-areas'), G5P()->helper()->getAssetUrl('core/widget-areas/assets/js/widget-areas.min.js'), array('jquery'), $this->version);
			wp_enqueue_style(G5P()->assetsHandle('widget-areas'), G5P()->helper()->getAssetUrl('core/widget-areas/assets/css/widget-areas.min.css'), array(), $this->version, 'screen');
			wp_localize_script(
				G5P()->assetsHandle('widget-areas'),
				'gsf_widget_areas_variable',
				array(
					'ajax_url' => admin_url('admin-ajax.php'),
					'confirm_delete' => esc_html__('Are you sure to delete this widget areas?', 'april-framework')
				)
			);
		}


		public function get_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( !empty($this->widget_areas) ) {
				return $this->widget_areas;
			}

			$db = get_option($this->widget_areas_key);
			if (!empty($db)) {
				$this->widget_areas = array_unique(array_merge($this->widget_areas, $db));
			}
			return $this->widget_areas;
		}

		public function register_custom_widget_areas() {
			// If the single instance hasn't been set, set it now.
			if ( empty($this->widget_areas) ) {
				$this->widget_areas = $this->get_widget_areas();
			}
			$args = array(
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>',
			);
			$args = apply_filters('gsf_custom_widget_args', $args);
			if (is_array($this->widget_areas)) {
				foreach (array_unique($this->widget_areas) as $key => $value) {
					$args['class']   = 'gsf-widgets-custom';
					$args['name']    = $value;
					$args['id']      = $key;
					register_sidebar($args);
				}
			}
		}

		function save_widget_areas() {
			update_option($this->widget_areas_key,array_unique( $this->widget_areas ));
		}

		public function add_new_widget_area_box() {
			include_once plugin_dir_path(__FILE__) . 'views/widget-area-box.php';
		}

		public function add_widget_area_area() {
			if(!empty($_POST['gsf-add-widget-input'])) {
				$this->widget_areas = $this->get_widget_areas();
				$widgetName = $this->check_widget_area_name($_POST['gsf-add-widget-input']);
				$widgetId = sanitize_key($widgetName);
				$this->widget_areas[$widgetId] = $widgetName;
				$this->save_widget_areas();
				wp_redirect( admin_url('widgets.php') );
				die();
			}
		}

		public function check_widget_area_name($name) {
			global $wp_registered_sidebars;
			if(empty($wp_registered_sidebars))
				return $name;

			$taken = array();
			foreach ( $wp_registered_sidebars as $widget_area ) {
				$taken[] = $widget_area['name'];
			}
			if(in_array($name, $taken)) {
				$counter  = substr($name, -1);
				$new_name = "";

				if(!is_numeric($counter)) {
					$new_name = $name . " 1";
				} else {
					$new_name = substr($name, 0, -1) . ((int) $counter + 1);
				}

				$name = $this->check_widget_area_name($new_name);
			}
			return $name;
		}

		function delete_widget_area() {
			if (!check_ajax_referer('gsf-delete-widget-area-nonce','_wpnonce')) return;
			if(!empty($_REQUEST['name'])) {
				$name = strip_tags( ( stripslashes( $_REQUEST['name'] ) ) );
				$this->widget_areas = $this->get_widget_areas();
				if( array_key_exists($name, $this->widget_areas )) {
					unset($this->widget_areas[$name]);
					$this->save_widget_areas();
				}
				echo "widget-area-deleted";
			}
			die();
		}
	}
}