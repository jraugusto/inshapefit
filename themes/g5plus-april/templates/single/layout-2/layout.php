<?php
/**
 * The template for displaying layout-1.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
*/
get_header();
while (have_posts()) : the_post();
    g5Theme()->helper()->getTemplate('single/layout-2/content');
endwhile;
get_footer();