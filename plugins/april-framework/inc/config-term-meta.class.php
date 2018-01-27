<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Term_Meta')) {
    class G5P_Inc_Config_Term_Meta
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
            // Defined Theme Options
            add_filter('gsf_term_meta_config', array($this, 'register_term_meta'));
        }

	    public function getTaxonomy() {
		    return apply_filters('gsf_term_meta_taxonomy',array('category','product_cat', 'portfolio_cat'));
	    }

        public function register_term_meta()
        {
            $prefix = G5P()->getMetaPrefix();

            $configs['gsf_taxonomy_setting'] = array(
                'name'     => esc_html__('Advance Setting', 'april-framework'),
                'layout'   => 'horizontal',
                'taxonomy' => $this->getTaxonomy(),
                'fields' => array(
	                array(
		                'id' => "{$prefix}group_page_title",
		                'type' => 'group',
		                'title' => esc_html__('Page Title','april-framework'),
		                'fields' => array(
			                G5P()->configOptions()->get_config_toggle(array(
				                'title' => esc_html__('Page Title Enable','april-framework'),
				                'id' => "{$prefix}page_title_enable"
			                ),true),
			                G5P()->configOptions()->get_config_content_block(array(
				                'id' => "{$prefix}page_title_content_block",
				                'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'april-framework'),
				                'required' => array("{$prefix}page_title_enable", '!=', 'off')
			                ),true),

			                array(
				                'title'       => esc_html__('Custom Page title', 'april-framework'),
				                'id'          => "{$prefix}page_title_content",
				                'type'        => 'text',
				                'default'     => '',
				                'required' => array("{$prefix}page_title_enable", '!=', 'off'),
				                'desc'        => esc_html__('Enter custom page title for this page', 'april-framework')
			                )
		                )
	                )
                ));

            return $configs;
        }
    }
}