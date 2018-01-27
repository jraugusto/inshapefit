<?php
/**
 * The template for displaying pagination.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $settingId
 * @var $pagenum_link
 */
global $wp_query, $wp_rewrite;
$paged   =  $wp_query->get( 'page' ) ? intval( $wp_query->get( 'page' ) ) : $wp_query->get( 'paged' ) ? intval( $wp_query->get( 'paged' ) ) : 1;
if (!isset($pagenum_link) || ($pagenum_link === '')) {
	$pagenum_link = html_entity_decode( get_pagenum_link() );
}
$query_args   = array();
$url_parts    = explode( '?', $pagenum_link );

if ( isset( $url_parts[1] ) ) {
	wp_parse_str( $url_parts[1], $query_args );
}

$pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
?>
<div data-items-paging="pagination" class="gf-paging blog-pagination clearfix">
	<?php echo paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => wp_kses_post(__('Prev', 'g5plus-april')),
		'next_text' => wp_kses_post(__('Next', 'g5plus-april')),
	) );
	?>
</div>
