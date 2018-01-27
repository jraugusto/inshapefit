<?php
/**
 * The template for displaying layout-1.php
 */
get_header();
while (have_posts()) : the_post();
	g5Theme()->helper()->getTemplate('single/layout-1/content');
endwhile;
get_footer();