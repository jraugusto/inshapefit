<?php
/**
 * The template for displaying infinite-scroll.php
 * @var $settingId
 */
global $wp_query;
$paged   =  $wp_query->get( 'page' ) ? intval( $wp_query->get( 'page' ) ) : $wp_query->get( 'paged' ) ? intval( $wp_query->get( 'paged' ) ) : 1;
$paged = intval($paged) + 1;
if ($paged > $wp_query->max_num_pages) return;
$accent_color = g5Theme()->options()->get_accent_color();
?>
<div data-items-paging="infinite-scroll" class="gf-paging infinite-scroll clearfix text-center" data-id="<?php echo esc_attr($settingId) ?>">
	<a data-paged="<?php echo esc_attr($paged); ?>" data-style="zoom-in" data-spinner-size="40" data-spinner-color="<?php echo esc_attr($accent_color); ?>"  class="no-animation ladda-button" href="#">
	</a>
</div>
