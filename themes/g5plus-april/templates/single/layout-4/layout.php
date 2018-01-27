<?php
/**
 * The template for displaying layout-1.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
add_action('g5plus_main_content_top',array(g5Theme()->templates(),'post_single_image'));
get_header();
while (have_posts()) : the_post();
	g5Theme()->helper()->getTemplate('single/layout-4/content');
endwhile;
get_footer();