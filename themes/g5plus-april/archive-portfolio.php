<?php
get_header();
$portfolio_filter_enable = g5Theme()->options()->get_portfolio_filter_enable();
$query_args = $settings = null;
if('on' === $portfolio_filter_enable) {
    $settings['category_filter_enable'] = true;
    if (is_tax(g5Theme()->portfolio()->get_taxonomy_category())) {
        global $wp_query;
        if (isset($wp_query->queried_object)) {
            $settings['current_cat'] = $wp_query->queried_object->term_id;
        }
    }
}
g5Theme()->portfolio()->archive_markup($query_args,$settings);
get_footer();