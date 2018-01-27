<?php
/**
 * The template for displaying category.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
get_header();
$blog_filter_enable = g5Theme()->options()->get_blog_filter_enable();
$query_args = $settings = null;
$current_cat = get_category( get_query_var( 'cat' ) );
if('on' === $blog_filter_enable) {
    $settings['category_filter_enable'] = true;
    $settings['current_cat'] = $current_cat->term_id;
}
g5Theme()->blog()->archive_markup($query_args,$settings);
get_footer();