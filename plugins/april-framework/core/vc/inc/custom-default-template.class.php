<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Vc_Custom_Default_Template')) {
	class G5P_Vc_Custom_Default_Template
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
			add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_resources'));
			add_action('vc_load_default_templates', array(&$this, 'add_default_template'));
			add_filter('vc_templates_render_category', array(&$this, 'renderTemplateBlock',), 100);
		}


		public function enqueue_admin_resources() {
			if (class_exists('Vc_Manager') && Vc_Manager::getInstance()->backendEditor()->isValidPostType()) {
				wp_enqueue_style(G5P()->assetsHandle('template-vc'));
				wp_enqueue_script(G5P()->assetsHandle('template-vc'));
			}
		}

		/**
		 * Load Item To Default Template
		 *
		 * @param $templates
		 * @return array
		 */
		public function add_default_template($templates)
		{
			$templates = array(); // Clear VC default templates
			$gfTemplates = get_posts(array(
				'numberposts' => -1,
				'post_type' => G5P()->cpt()->get_template_post_type(),
			));
			foreach ($gfTemplates as $gfTemplate) {
				$custom_class = array();
				$terms = get_the_terms($gfTemplate->ID, G5P()->cpt()->get_template_taxonomy());
				if ($terms) {
					foreach ($terms as $term) {
						$custom_class[] = $term->slug;
					}
				}
				$templates[$gfTemplate->ID] = array(
					'name' => $gfTemplate->post_title,
					'content' => $gfTemplate->post_content,
					'custom_class' => implode(' ', $custom_class)
				);
			}
			return $templates;
		}



		public function renderTemplateBlock($category)
		{
			if ($category['category'] === 'default_templates') {

				$html = '<div id="vc-panel-popup-default-template" class="vc_ui-panel-popup">';
				$html .= '<div class="vc_ui-panel-template-content vc_ui-panel-popup-item">';

				if (isset($category['category_name']) || isset($category['category_description'])) {
					$html .= '<div class="vc_ui-panel-message">';
					if (isset($category['category_name'])) {
						$html .= '<h3 class="vc_ui-panel-title">' . esc_html($category['category_name']) . '</h3>';
					}
					if (isset($category['category_description'])) {
						$html .= '<p class="vc_description">' . esc_html($category['category_description']) . '</p>';
					}
					$html .= '</div>';
				}


				$content_cat = get_categories(array('taxonomy' => G5P()->cpt()->get_template_taxonomy()));
				if (sizeof($content_cat) > 0) {
					$html .= '<ul class="vc_ui-category-box vc_ui-panel-message vc_ui-panel-search-box clearfix">';
					$html .= '<li class="cat-item cat-item-0"><a class="active" data-filter="*" href="#">' . esc_html__('All', 'april-framework') . '</a></li>';
					$html .= wp_list_categories(array(
						'walker' => new G5P_Vc_Walker_Template_Cat_List,
						'title_li' => '',
						'echo' => 0,
						'hierarchical' => false,
						'show_count' => 1,
						'taxonomy' => G5P()->cpt()->get_template_taxonomy()
					));

					$html .= '</ul>';
				}

				// Template
				$html .= '<div class="vc_ui-panel-template-grid" id="vc_template-default">';
				if (!empty($category['templates'])) {
					foreach ($category['templates'] as $template) {
						$html .= $this->renderTemplateItem($template);
					}
				}
				$html .= '</div>';

				$html .= '</div>';
				$html .= '</div>';
				$category['output'] = $html;
			}
			return $category;
		}

		private function renderTemplateItem($template)
		{
			$name = isset($template['name']) ? esc_html($template['name']) : esc_html(__('No title', 'april-framework'));
			$template_id = esc_attr($template['unique_id']);
			$template_id_hash = md5($template_id); // needed for jquery target for TTA
			$template_name = esc_html($name);
			$template_image = vc_asset_url('vc/vc_gitem_image.png');
			$template_name_lower = esc_attr(vc_slugify($template_name));
			$template_type = esc_attr(isset($template['type']) ? $template['type'] : 'custom');
			$custom_class = esc_attr(isset($template['custom_class']) ? $template['custom_class'] : '');
			$add_template_title = esc_attr('Add template', 'april-framework');
			$preview_template_title = esc_attr('Preview template', 'april-framework');
			$link = esc_url(get_the_permalink($template_id));

			$output = <<< HTML
			<div class="vc_ui-panel-template-item $custom_class"
						data-template_id="$template_id"
						data-template_id_hash="$template_id_hash"
						data-category="$template_type"
						data-template_unique_id="$template_id"
						data-template_name="$template_name_lower"
						data-template_type="$template_type"
						data-vc-content=".vc_ui-template-content">
			<span class="vc_ui-panel-template-item-content magnific-wrap">
				<img src="$template_image" alt="$template_name"/>
				<span class="vc_ui-panel-template-item-overlay">
HTML;

				$output .= <<< HTML
				<a title="$preview_template_title" href="$link" target="_blank" class="vc_ui-panel-template-item-overlay-button vc_ui-panel-template-preview-button"
					data-title="$template_name" data-template-id="$template_id"><i class="vc-composer-icon vc-c-icon-search"></i></a>
HTML;
			$output .= <<< HTML
					<a data-template-handler="" title="$add_template_title" href="javascript:;" class="vc_ui-panel-template-item-overlay-button vc_ui-panel-template-download-button">
						<i class="vc-composer-icon vc-c-icon-add"></i>
					</a>
				</span>
			</span>
			<a href="javascript:;" title="$add_template_title" data-template-handler="" class="vc_ui-panel-template-item-name">$template_name</a>
			</div>
HTML;
			return $output;
		}
	}
}