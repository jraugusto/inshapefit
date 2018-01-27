<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/21/2017
 * Time: 10:07 AM
 */
$single_portfolio_related_enable = g5Theme()->options()->get_single_portfolio_related_enable();
$single_portfolio_related_full_width =  g5Theme()->options()->get_single_portfolio_related_full_width_enable();
if ($single_portfolio_related_enable !== 'on') return;
global $post;
$post_id = $post->ID;
$post_algorithm = g5Theme()->options()->get_single_portfolio_related_algorithm();
$post_carousel_enable = g5Theme()->options()->get_single_portfolio_related_carousel_enable();
$posts_per_page = intval(g5Theme()->options()->get_single_portfolio_related_per_page());
$post_columns_gutter = intval(g5Theme()->options()->get_single_portfolio_related_columns_gutter());
$post_columns = intval(g5Theme()->options()->get_single_portfolio_related_columns());
$post_columns_md = intval(g5Theme()->options()->get_single_portfolio_related_columns_md());
$post_columns_sm = intval(g5Theme()->options()->get_single_portfolio_related_columns_sm());
$post_columns_xs = intval(g5Theme()->options()->get_single_portfolio_related_columns_xs());
$post_columns_mb = intval(g5Theme()->options()->get_single_portfolio_related_columns_mb());
$post_paging = g5Theme()->options()->get_single_portfolio_related_post_paging();

$container_class = '';
if ($post_carousel_enable) {
    $post_paging = 'none';
}
$full_width_class = '';
if('on' !== $single_portfolio_related_full_width){
    $full_width_class = 'container';
}
$query_args = array(
    'ignore_sticky_posts' => true,
    'posts_per_page' => $posts_per_page,
    'post__not_in' => array($post_id),
    'post_type' => g5Theme()->portfolio()->get_post_type(),
    'post_status'      => 'publish',
    'tax_query'      => array(
    ),
);
switch ($post_algorithm) {
    case 'cat':
        $query_args['tax_query'][] = array(
            'taxonomy' => g5Theme()->portfolio()->get_taxonomy_category(),
            'field' => 'term_id',
            'terms' => g5Theme()->portfolio()->get_portfolio_term_ids($post_id),
            'operator' 		=> 'IN'
        );
        break;
    case 'author':
        $query_args['author'] = $post->post_author;
        break;
    case 'cat-author':
        $query_args['author']       = $post->post_author;
        $query_args['tax_query'][] = array(
            'taxonomy' => g5Theme()->portfolio()->get_taxonomy_category(),
            'field' => 'term_id',
            'terms' => g5Theme()->portfolio()->get_portfolio_term_ids($post_id),
            'operator' 		=> 'IN'
        );
        break;
    case 'random':
        $query_args['orderby'] = 'rand';
        break;
}

$settings = array(
    'post_layout' => 'grid',
    'post_paging' => $post_paging,
);
$image_size = g5Theme()->options()->get_single_portfolio_related_image_size();
$settings['image_size'] = $image_size;
if ($image_size === 'full') {
    $image_ratio = g5Theme()->options()->get_single_portfolio_related_image_ratio();
    if ($image_ratio === 'custom') {
        $image_ratio_custom = g5Theme()->options()->get_single_portfolio_related_image_ratio_custom();
        if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
            $image_ratio_custom_width = intval($image_ratio_custom['width']);
            $image_ratio_custom_height = intval($image_ratio_custom['height']);
            if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
                $image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
            }
        } elseif (preg_match('/x/',$image_ratio_custom)) {
            $image_ratio = $image_ratio_custom;
        }
    }
    if ($image_ratio === 'custom') {
        $image_ratio = '1x1';
    }
    $settings['image_ratio'] = $image_ratio;
}

if ($post_carousel_enable !== 'on') {
    $settings['post_columns_gutter'] = $post_columns_gutter;
    $settings['post_columns'] = array(
        'lg' => $post_columns,
        'md' => $post_columns_md,
        'sm' => $post_columns_sm,
        'xs' => $post_columns_xs,
        'mb' => $post_columns_mb
    );
} else {
    $settings['carousel'] = array(
        'dots' => true,
        'items' => $post_columns,
        'margin' => $post_columns == 1 ? 0 : $post_columns_gutter,
        'slideBy' => $post_columns,
        'responsive' => array(
            '1200' => array(
                'items' => $post_columns,
                'margin' => $post_columns == 1 ? 0 : $post_columns_gutter,
                'slideBy' => $post_columns,
            ),
            '992' => array(
                'items' => $post_columns_md,
                'margin' => $post_columns_md == 1 ? 0 : $post_columns_gutter,
                'slideBy' => $post_columns_md,
            ),
            '768' => array(
                'items' => $post_columns_sm,
                'margin' => $post_columns_sm == 1 ? 0 : $post_columns_gutter,
                'slideBy' => $post_columns_sm,
            ),
            '600' => array(
                'items' => $post_columns_xs,
                'margin' => $post_columns_xs == 1 ? 0 : $post_columns_gutter,
                'slideBy' => $post_columns_xs,
            ),
            '0' => array(
                'items' => $post_columns_mb,
                'margin' => $post_columns_mb == 1 ? 0 : $post_columns_gutter,
                'slideBy' => $post_columns_mb,
            )
        ),
        'autoHeight' => true,
    );
}
?>
<div class="gf-single-portfolio-related-wrap mg-top-90 sm-mg-top-50 pd-top-70 sm-pd-top-50">
    <div class="portfolio-related-inner <?php echo esc_attr($full_width_class)?>">
        <h4 class="gf-heading-title fs-24 mg-bottom-45 mg-top-0"><?php esc_html_e('Related Portfolios', 'g5plus-april'); ?></h4>
        <?php g5Theme()->portfolio()->archive_markup($query_args, $settings); ?>
    </div>
</div>
