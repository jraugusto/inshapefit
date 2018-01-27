<?php
/**
 * The template for displaying page
 *
 */
get_header();
	while (have_posts()) : the_post();
		g5Theme()->helper()->getTemplate('content-page');
	endwhile;
get_footer();