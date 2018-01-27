<?php
$single_layout = g5Theme()->options()->get_single_portfolio_layout();
get_header();
while (have_posts()) : the_post();
    g5Theme()->helper()->getTemplate("portfolio/single/layout/{$single_layout}");
endwhile;
get_footer();
