<?php
/**
 * The template for displaying cat-filter.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $settingId
 * @var $pagenum_link
 * @var $filter_vertical
 * @var $filter_type
 * @var $post_type
 * @var $category_filter
 * @var $current_cat
 * @var $taxonomy
 */
global $wp_query;
$args = array(
	'hide_empty'	=> 1,
	'orderby' => 'include',
    'taxonomy' => $taxonomy
);

if (is_array($category_filter)){
    $args['include'] = $category_filter;
}


$prettyTabsOptions = array(
    'more_text' => '<span>+</span>'
);


$cate_attributes = array();
if($filter_vertical == true) {
    $cate_attributes[] = 'data-filter-vertical=1';
} else {
    $cate_attributes[] = 'data-filter-vertical=0';
}

if(!empty($filter_type)) {
    $cate_attributes[] = ' data-filter-type=' . $filter_type;
}
$categories = get_categories( $args );
$accent_color = g5Theme()->options()->get_accent_color();
$query_str = $_SERVER['QUERY_STRING'];
?>
<ul data-id="<?php echo esc_attr($settingId); ?>" data-items-cate class="nav nav-tabs gf-cate-filter <?php echo esc_attr($filter_vertical === true ? '' : 'gsf-pretty-tabs'); ?>" <?php echo implode(' ',$cate_attributes); ?> data-pretty-tabs-options='<?php echo json_encode($prettyTabsOptions); ?>'>
    <?php
    $cate_link = get_post_type_archive_link($post_type);
    if(!empty($query_str)) {
        $cate_link .= '?' . $query_str;
    }?>
    <li class="<?php echo esc_attr(-1 == $current_cat ? ' active' : '') ?>">
        <a data-style="zoom-in" data-spinner-size="20" data-spinner-color='<?php echo esc_attr($accent_color); ?>' data-id="-1" data-name=""
           title="<?php esc_html_e('All', 'g5plus-april') ?>" class="no-animation ladda-button" href="<?php echo esc_url($cate_link); ?>"><?php esc_html_e('All', 'g5plus-april') ?></a>
    </li>
    <?php foreach ($categories as $category):
        $cate_link = trailingslashit(get_term_link($category));
        if(!empty($query_str)) {
            $cate_link .= '?' . $query_str;
        }
        ?>
        <li class="<?php echo esc_attr($category->cat_ID == $current_cat ? ' active' : '') ?>">
            <a data-style="zoom-in" data-spinner-size="20" data-spinner-color='<?php echo esc_attr($accent_color); ?>' data-id="<?php echo esc_attr($category->cat_ID); ?>"  data-name="<?php echo esc_attr($category->slug); ?>" title="<?php echo esc_attr($category->name) ?>" class="no-animation ladda-button"
               href="<?php echo esc_url($cate_link) ?>"><?php echo esc_html($category->name)?></a>
        </li>
    <?php endforeach; ?>
</ul>