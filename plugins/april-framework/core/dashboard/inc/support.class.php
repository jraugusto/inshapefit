<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Dashboard_Support')) {
	class G5P_Dashboard_Support
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
		}



		public function binderPage() {
			G5P()->helper()->getTemplate('core/dashboard/templates/dashboard', array('current_page' => 'support'));
		}

		/**
		 * Get Support Forum Url
		 *
		 * @return mixed|void
		 */
		private function getSupportForumUrl() {
			return apply_filters('gsf-support-forum-url','http://support.g5plus.net/') ;
		}

		/**
		 * Get Documentation Url
		 *
		 * @return mixed|void
		 */
		private function getDocumentationUrl() {
			return apply_filters('gsf-documentation-url','#');
		}

		/**
		 * Get Knowledgebase Url
		 *
		 * @return mixed|void
		 */
		private function getKnowledgeBaseUrl() {
			return apply_filters('gsf-knowledgebase-url','http://support.g5plus.net/knowledge-base/');
		}

		/**
		 * Get Video Tutorials Url
		 *
		 * @return mixed|void
		 */
		private function getVideoTutorialsUrl() {
			return apply_filters('gsf-video-tutorials-url','#');
		}

		/**
		 * Get Features Support
		 *
		 * @return array
		 */
		public function getFeatures()
		{
			$current_theme = wp_get_theme();
			return array(
				array(
					'icon' => 'dashicons dashicons-sos',
					'label' => esc_html__('Support forum', 'april-framework'),
					'description' => sprintf(__('We offer outstanding support through our forum. To get support first you need to register (create an account) and open a thread in the %1$s Section.','april-framework'),$current_theme['Name']),
					'button_text' => esc_html__('Open Forum', 'april-framework'),
					'button_url' => $this->getSupportForumUrl()
				),
				array(
					'icon' => 'dashicons dashicons-book',
					'label' => esc_html__('Documentation', 'april-framework'),
					'description' => sprintf(__('This is the place to go to reference different aspects of the theme. Our online documentation is an incredible resource for learning the ins and outs of using %1$s.', 'april-framework'),$current_theme['Name']),
					'button_text' => esc_html__('Documentation', 'april-framework'),
					'button_url' => $this->getDocumentationUrl()
				),
				array(
					'icon' => 'dashicons dashicons-portfolio',
					'label' => esc_html__('Knowledge Base', 'april-framework'),
					'description' => esc_html__('Our knowledge base contains additional content that is not inside of our documentation. This information is more specific and unique to various versions or aspects of theme.', 'april-framework'),
					'button_text' => esc_html__('Knowledgebase', 'april-framework'),
					'button_url' => $this->getKnowledgeBaseUrl()
				),
				array(
					'icon' => 'dashicons dashicons-format-video',
					'label' => esc_html__('Video Tutorials', 'april-framework'),
					'description' => sprintf(__('Nothing is better than watching a video to learn. We have a growing library of high-definititon, narrated video tutorials to help teach you the different aspects of using %1$s.','april-framework'),$current_theme['Name']),
					'button_text' => esc_html__('Watch Videos', 'april-framework'),
					'button_url' => $this->getVideoTutorialsUrl()
				)
			);
		}
	}
}