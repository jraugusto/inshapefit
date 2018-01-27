<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('GSF_Core_Dashboard')) {
	class G5P_Core_Dashboard
	{
		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {


			add_action('admin_menu', array($this, 'dashboardMenu'),1);

			add_action('admin_bar_menu',array($this,'presetMenu'),100);

			add_action( 'admin_bar_menu', array( $this, 'dashboardMenuBar' ), 81 );
			if ($this->isDashboardPage()) {
				add_action('admin_enqueue_scripts', array($this, 'adminEnqueueStyles'));
				add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScripts'), 15);
			}

			if ($this->isDashboardPage('install_demo')) {
				$this->installDemo()->init();
			}
		}



		public function dashboardMenu() {
			$current_theme = wp_get_theme();
			$current_theme_name = $current_theme->get('Name');
			add_menu_page(
				$current_theme_name,
				$current_theme_name,
				'manage_options',
				'gsf_welcome',
				array($this, 'binderPage'),
				'dashicons-lightbulb',
				30
			);

			$pages = $this->getConfigPages();
			foreach ($pages as $key => $value) {
				add_submenu_page(
					'gsf_welcome',
					$value['page_title'],
					$value['menu_title'],
					'manage_options',
					"gsf_{$key}",
					$value['function_binder']
				);
			}
		}

		public function dashboardMenuBar($admin_bar) {
			$current_theme = wp_get_theme();
			$current_theme_name = $current_theme->get('Name');

			$admin_bar->add_node(array(
				'id' => 'gsf-parent-welcome',
				'title' => sprintf('<span class="ab-icon"></span><span class="ab-label">%s</span>',$current_theme_name),
				'href' => admin_url("admin.php?page=_welcome"),
			));

			$pages = $this->getConfigPages();

			foreach ($pages as $key => $value) {
				$href = admin_url("admin.php?page=gsf_{$key}");
				$admin_bar->add_node(array(
					'id' => "{$key}",
					'title' => $value['menu_title'],
					'href' => $href,
					'parent' => 'gsf-parent-welcome'
				));
			}

			$admin_bar->add_node(array(
				'id' => '_fonts_management',
				'title' => esc_html__('Fonts Management','april-framework'),
				'href' => admin_url('admin.php?page=_fonts_management'),
				'parent' => 'gsf-parent-welcome'
			));

			$admin_bar->add_node(array(
				'id' => '_skins',
				'title' => esc_html__('Skins Options','april-framework'),
				'href' => admin_url('admin.php?page=gsf_skins'),
				'parent' => 'gsf-parent-welcome'
			));

			$admin_bar->add_node(array(
				'id' => '_options',
				'title' => esc_html__('Theme Options','april-framework'),
				'href' => admin_url('admin.php?page=gsf_options'),
				'parent' => 'gsf-parent-welcome'
			));


		}

		public function adminEnqueueStyles() {
			wp_enqueue_style(G5P()->assetsHandle('dashboard'), G5P()->helper()->getAssetUrl('core/dashboard/assets/dashboard.min.css'), array(), G5P()->pluginVer());
		}
		public function adminEnqueueScripts() {
		}

		public function binderPage() {}

		public function getConfigPages()
		{
			return array(
				'welcome' => array(
					'page_title' => esc_html__('Welcome', 'april-framework'),
					'menu_title' => esc_html__('Welcome', 'april-framework'),
					'function_binder' => array($this->systemStatus(),'binderPage')
				),
				'install_demo' => array(
					'page_title' => esc_html__('Install Demo', 'april-framework'),
					'menu_title' => esc_html__('Install Demo', 'april-framework'),
					'function_binder' => array($this->installDemo(),'binderPage')
				),
				'support' => array(
					'page_title' => esc_html__('Support', 'april-framework'),
					'menu_title' => esc_html__('Support', 'april-framework'),
					'function_binder' => array($this->support(),'binderPage')
				),
			);
		}

		/**
		 * @return G5P_Dashboard_System_Status
		 */
		public function systemStatus() {
			return G5P_Dashboard_System_Status::getInstance();
		}

		/**
		 * @return G5P_Dashboard_Install_Demo
		 */
		public function installDemo() {
			return G5P_Dashboard_Install_Demo::getInstance();
		}

		/**
		 * @return G5P_Dashboard_Support
		 */
		public function support() {
			return G5P_Dashboard_Support::getInstance();
		}

		public function isDashboardPage($page = '') {
			global $pagenow;
			if ($pagenow === 'admin.php' && !empty($_GET['page'])) {
				$current_page = $_GET['page'];
				$current_page = preg_replace('/gsf_/','',$current_page);
				if ($page) {
					return $current_page === $page;
				} else {
					$pages = $this->getConfigPages();
					return array_key_exists($current_page,$pages);
				}
			}
			return false;
		}

		public function presetMenu($admin_bar) {
			if (!is_admin_bar_showing()) {
				return;
			}

			$preset = G5P()->helper()->getCurrentPreset();
			if (!empty($preset)) {
				$admin_bar->add_node(array(
					'id'    => 'preset',
					'title' => sprintf('<span class="ab-icon"></span><span class="ab-label">%s</span>',esc_html__('Edit Preset', 'april-framework')),
					'href'  => admin_url("admin.php?page=gsf_options&_gsf_preset={$preset}"),
					'meta' => array(
						'target' => '_blank',
					)
				));
			}

		}
	}
}