<?php
/**
 * The template for displaying layout-1.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
add_action('g5plus_before_main_content',array(g5Theme()->templates(),'post_single_image'),10);
get_header();
while (have_posts()) : the_post();
	g5Theme()->helper()->getTemplate('single/layout-5/content');
endwhile;
get_footer();