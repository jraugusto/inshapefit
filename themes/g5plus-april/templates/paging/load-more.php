<?php
/**
 * The template for displaying load-more.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $settingId
 * @var $pagenum_link
 */
global $wp_query;
$post_setting = g5Theme()->blog()->get_layout_settings();
if (isset($post_setting['currentPage'])) {
    $url = $post_setting['currentPage']['url'];
    $_SERVER['REQUEST_URI'] = substr($url,stripos($url,$_SERVER['SERVER_NAME']) + strlen($_SERVER['SERVER_NAME']));
    $GLOBALS['current_screen'] = new G5Plus_Inc_Ajax();
}
$next_link = get_next_posts_page_link($wp_query->max_num_pages);
if (empty($next_link)) return;
$accent_color = g5Theme()->options()->get_accent_color();
?>
<div data-items-paging="load-more" class="gf-paging load-more clearfix text-center" data-id="<?php echo esc_attr($settingId) ?>">
    <a data-style="zoom-in" data-spinner-size="20" data-spinner-color='<?php echo esc_attr($accent_color); ?>' class="no-animation ladda-button btn btn-black btn-md" href="<?php echo esc_url($next_link); ?>">
        <?php esc_html_e('Load More', 'g5plus-april') ?>
    </a>
</div>
