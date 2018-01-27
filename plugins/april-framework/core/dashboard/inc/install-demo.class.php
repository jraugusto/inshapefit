<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Dashboard_Install_Demo')) {
	class G5P_Dashboard_Install_Demo
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

		public function init()
		{
			add_action('admin_enqueue_scripts', array($this, 'adminEnqueueResource'));
		}

		public function adminEnqueueResource() {
			wp_enqueue_style(G5P()->assetsHandle('install_demo_data'), G5P()->helper()->getAssetUrl('core/dashboard/inc/install-demo/assets/css/style.min.css'),array(),G5P()->pluginVer());
			wp_enqueue_script(G5P()->assetsHandle('install_demo_data'), G5P()->helper()->getAssetUrl('core/dashboard/inc/install-demo/assets/js/app.min.js'), array('jquery'), G5P()->pluginVer(), true);
			wp_localize_script(G5P()->assetsHandle('install_demo_data'), 'gsf_install_demo_meta', array(
				'ajax_url' => admin_url('admin-ajax.php?activate-multi=true')
			));
		}



		public function binderPage() {
			G5P()->helper()->getTemplate('core/dashboard/templates/dashboard', array('current_page' => 'install_demo'));
		}

		public function installDemo() {
			/**
			 * Check security
			 */
			if (!(isset($_REQUEST['security']) && current_user_can( 'manage_options' )) )
			{
				ob_end_clean();
				$data_response = array(
					'code' => 'error',
					'message' => esc_html__("Permission error!",'april-framework')
				);
				echo json_encode($data_response);
				die();
			}

			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true );
			}
			// Load Importer API
			require_once ABSPATH . 'wp-admin/includes/import.php';

			if ( file_exists( ABSPATH . 'wp-content/plugins/revslider/revslider_admin.php' ) ) {
				G5P()->loadFile(ABSPATH . 'wp-content/plugins/revslider/revslider_admin.php');
			}

			$demo_site = isset($_REQUEST['demo_site']) ? $_REQUEST['demo_site'] : '.';

			$importer_error = false;
			$import_file_path    = G5P()->pluginDir("assets/data-demo/{$demo_site}/demo-data.xml");
			$import_setting_path = G5P()->pluginDir("assets/data-demo/{$demo_site}/setting.json");
			$import_setting_minimal_path = G5P()->pluginDir("assets/data-demo/{$demo_site}/setting-minimal.json");

			//check if wp_importer, the base importer class is available, otherwise include it
			if ( ! class_exists( 'WP_Importer' ) ) {
				if (!G5P()->loadFile(ABSPATH . 'wp-admin/includes/class-wp-importer.php')) {
					$importer_error = true;
				}
			}

			if (!G5P()->loadFile(G5P()->pluginDir('core/dashboard/inc/install-demo/wordpress-importer.php'))) {
				$importer_error = true;
			}

			if (!G5P()->loadFile(G5P()->pluginDir('core/dashboard/inc/install-demo/g5plus_import_class.php'))) {
				$importer_error = true;
			}


			/**
			 * File Not Found
			 */
			if ($importer_error !== false) {
				ob_end_clean();
				$data_response = array(
					'code' => 'fileNotFound',
					'message' => esc_html__("The Auto importing script could not be loaded. please use the wordpress importer and import the XML file that is located in your themes folder manually.",'april-framework')
				);
				echo json_encode($data_response);
				die();
			}
			else {

				$importer = new GF_Import();
				$type      = $_REQUEST['type'];
				$other_data = $_REQUEST['other_data'];
				ob_start();
				switch (trim($type)) {
					case 'init':
						$demo_data_directory = G5P()->pluginDir("assets/data-demo/{$demo_site}/");
						$arr_demo_file = array(
							"{$demo_data_directory}demo-data.xml",
							"{$demo_data_directory}setting.json",
							"{$demo_data_directory}change-data.json",
						);
						foreach ( $arr_demo_file as $file_demo ) {
							if (!file_exists($file_demo)) {
								ob_end_clean();
								$data_response = array(
									'code' => 'fileNotFound',
									'message' => sprintf(esc_html__("File not found! Please check file exists in directory:\n[%s]/assets/data-demo/%s",'april-framework'),G5P()->pluginName(),$demo_site)
								);
								echo json_encode($data_response);
								die();
							}
						}

						/**
						 * Remove log file
						 */
						if ( $handle = opendir( G5P()->pluginDir('assets/data-demo/log/')) ) {
							while ( false !== ( $entry = readdir( $handle ) ) ) {
								if ( $entry != "." && $entry != ".." ) {
									unlink(G5P()->pluginDir("assets/data-demo/log/{$entry}"));
								}
							}
						}

						/**
						 * Clear All Post & Page
						 */

						global $wpdb;

						$sql_query = $wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE 1", '');
						$wpdb->query($sql_query);

						// posts
						$sql_query = $wpdb->prepare("DELETE FROM $wpdb->posts WHERE 1", '');
						$wpdb->query($sql_query);

						$sql_query = $wpdb->prepare("DELETE FROM $wpdb->termmeta WHERE 1", '');
						$wpdb->query($sql_query);

						$sql_query = $wpdb->prepare("DELETE FROM $wpdb->term_taxonomy WHERE 1", '');
						$wpdb->query($sql_query);


						$sql_query = $wpdb->prepare("DELETE FROM $wpdb->term_relationships WHERE 1", '');
						$wpdb->query($sql_query);


						$sql_query = $wpdb->prepare("DELETE FROM $wpdb->terms WHERE 1", '');
						$wpdb->query($sql_query);



						ob_end_clean();
						$data_response = array(
							'code' => 'setting',
							'message' => ''
						);
						echo json_encode($data_response);
						break;
					case 'setting':
						if ( ! $importer->saveOptions( $import_setting_path ) ) {
							ob_end_clean();
							$data_response = array(
								'code' => 'fileNotFound',
								'message' => sprintf(esc_html__("File not found! Please check file exists in directory:\n[%s]/assets/data-demo/%s",'april-framework'),G5P()->pluginName(),$demo_site)
							);
							echo json_encode($data_response);
							die();
						}

						ob_end_clean();
						$data_response = array(
							'code' => 'core',
							'message' => ''
						);
						echo json_encode($data_response);
						die();

					case 'core':
						$importer->fetch_attachments = true;
						try {
							$import_return = $importer->import( $import_file_path );
							if ( $import_return !== true ) {
								ob_end_clean();
								$data_response = array(
									'code' => 'core',
									'message' => $import_return
								);
								echo json_encode($data_response);
								die();
							}
						}
						catch (Exception $ex) {
							ob_end_clean();
							$data_response = array(
								'code' => 'core',
								'message' => $other_data
							);
							echo json_encode($data_response);
							die();
						}

						ob_end_clean();
						$data_response = array(
							'code' => 'slider',
							'message' => ''
						);
						echo json_encode($data_response);
						die();
					case 'slider':
						$import_return = $importer->import_revslider($other_data);
						if ( $import_return === false  ) {
							ob_end_clean();
							$data_response = array(
								'code' => 'fileNotFound',
								'message' => sprintf(esc_html__("File not found! Please check file exists in directory:\n[%s]/assets/data-demo/%s",'april-framework'),G5P()->pluginName(),$demo_site)
							);
							echo json_encode($data_response);
							die();
						}
						else if ( $import_return !== 'done'  ) {
							ob_end_clean();
							$data_response = array(
								'code' => 'slider',
								'message' => $import_return
							);
							echo json_encode($data_response);
							die();
						}

						$data_response = array(
							'code' => 'update-id',
							'message' => ''
						);
						echo json_encode($data_response);
						die();
					case 'update-id':
						// update post id has changed after import
						$importer->update_missing_id();

					    ob_end_clean();

						$data_response = array(
							'code' => 'done',
							'message' => ''
						);
						echo json_encode($data_response);

						die();
					case 'fix-data':
						$demo_data_directory = G5P()->pluginDir("assets/data-demo/{$demo_site}/");
						$arr_demo_file = array(
							"{$demo_data_directory}setting.json",
							"{$demo_data_directory}change-data.json",
						);
						foreach ( $arr_demo_file as $file_demo ) {
							if (!file_exists($file_demo)) {
								ob_end_clean();
								$data_response = array(
									'code' => 'fileNotFound',
									'message' => sprintf(esc_html__("File not found! Please check file exists in directory:\n[%s]/assets/data-demo/%s",'april-framework'),G5P()->pluginName(),$demo_site)
								);
								echo json_encode($data_response);
								die();
							}
						}

						// update post id has changed after import
						$importer->update_missing_id();

						ob_end_clean();

						$data_response = array(
							'code' => 'done',
							'message' => ''
						);
						echo json_encode($data_response);
						die();
					case 'import-setting':
						$importer->fetch_attachments = true;
						try {
							$importer->import_setting( $import_file_path );
						}
						catch (Exception $ex) {
							ob_end_clean();
							$data_response = array(
								'code' => 'error',
								'message' => esc_html__('Import Error','april-framework')
							);
							echo json_encode($data_response);
							die();
						}

						if ( ! $importer->saveOptions( $import_setting_minimal_path ) ) {
							ob_end_clean();
							$data_response = array(
								'code' => 'fileNotFound',
								'message' => sprintf(esc_html__("File not found! Please check file exists in directory:\n[%s]/assets/data-demo/%s",'april-framework'),G5P()->pluginName(),$demo_site)
							);
							echo json_encode($data_response);
							die();
						}

						ob_end_clean();
						$data_response = array(
							'code' => 'done',
							'message' => ''
						);
						echo json_encode($data_response);
						die();
				}
			}
			die();
		}
	}
}