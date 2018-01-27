<?php
/**
 * The template for displaying pagination.php
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
<div data-items-paging="pagination-ajax" class="gf-paging blog-pagination clearfix" data-id="<?php echo esc_attr($settingId) ?>">
	<?php $page_links =  paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => wp_kses_post(__('Prev','g5plus-april')) ,
		'next_text' => wp_kses_post(__('Next','g5plus-april')),
	) );
	$accent_color = g5Theme()->options()->get_accent_color();
	$page_links = preg_replace('/page-numbers/','no-animation ladda-button page-numbers',$page_links);
	$page_links = preg_replace('/<a/','<a data-style="zoom-in" data-spinner-size="20" data-spinner-color="'.$accent_color.'"',$page_links);
	echo ($page_links);
	?>
</div>
