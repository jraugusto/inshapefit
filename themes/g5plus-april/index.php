<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
get_header();
$blog_filter_enable = g5Theme()->options()->get_blog_filter_enable();
$query_args = $settings = null;
if('on' === $blog_filter_enable) {
    $settings['category_filter_enable'] = true;
}
g5Theme()->blog()->archive_markup($query_args,$settings);
get_footer();