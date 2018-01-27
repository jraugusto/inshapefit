<?php
/**
 * The template for displaying archive
 */
global $wp_query;
$post_settings = &g5Theme()->blog()->get_layout_settings();
$post_layout = isset( $post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'large-image';
$post_item_skin = isset( $post_settings['post_item_skin'] ) ? $post_settings['post_item_skin'] : '';
if(!in_array($post_layout, array('grid', 'masonry'))) {
    $post_item_skin = '';
}
$post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';
$post_paging = isset( $post_settings['post_paging'] ) ? $post_settings['post_paging'] : 'pagination';
$layout_matrix = g5Theme()->blog()->get_layout_matrix( $post_layout );
$placeholder_enable = isset( $layout_matrix['placeholder_enable'] ) ? $layout_matrix['placeholder_enable'] : false;
$wrapper_attributes = array();
$inner_attributes = array();
$inner_classes = array(
	'gf-blog-inner',
	'clearfix',
	"layout-{$post_layout}",
    $post_item_skin
);

$post_inner_classes = array(
    'gf-post-inner',
    'clearfix',
    g5Theme()->helper()->getCSSAnimation( $post_animation )
);

$post_classes = array(
	'clearfix',
	'post-default',
    $post_item_skin
);


if ( isset( $post_settings['carousel'] ) ) {
	$inner_classes[] = 'owl-carousel owl-theme';
	if (isset($post_settings['carousel_class'])) {
		$inner_classes[] = $post_settings['carousel_class'];
	}
	$inner_attributes[] = "data-owl-options='" . json_encode( $post_settings['carousel'] ) . "'";
} else {
	if ( isset( $layout_matrix['columns_gutter'] ) ) {
		$inner_classes[] = "gf-gutter-{$layout_matrix['columns_gutter']}";
	} else {
		$inner_classes[] = 'row';
	}

	if ( isset( $layout_matrix['isotope'] ) ) {
		$inner_classes[] = 'isotope';
		$inner_attributes[] = "data-isotope-options='" . json_encode( $layout_matrix['isotope'] ) . "'";
		$wrapper_attributes[] = 'data-isotope-wrapper="true"';
	}
}

$wrapper_attributes[] = 'data-items-wrapper';
$inner_attributes[] = 'data-items-container="true"';

$paged = $wp_query->get( 'page' ) ? intval( $wp_query->get( 'page' ) ) : $wp_query->get( 'paged' ) ? intval( $wp_query->get( 'paged' ) ) : 1;

$inner_class = implode( ' ', array_filter( $inner_classes ) );
?>
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="gf-blog-wrap clearfix">
	<?php
	// You can use this for adding codes before the main loop
	do_action( 'g5plus_before_archive_wrapper' );
	?>
	<div <?php echo implode( ' ', $inner_attributes ); ?> class="<?php echo esc_attr( $inner_class ); ?>">
		<?php if ( have_posts() ) {
			if ( isset( $layout_matrix['layout'] ) ) {
				$layout_settings = $layout_matrix['layout'];
				$index = intval( $wp_query->get( 'index', 0 ) );
                $carousel_index = 0;
				while ( have_posts() ) : the_post();
					$index = $index % sizeof( $layout_settings );
					$current_layout = $layout_settings[$index];
					$isFirst = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
					if ( $isFirst && ( $paged > 1 ) && in_array( $post_paging, array( 'load-more', 'infinite-scroll' ) ) ) {
						if ( isset( $layout_settings[$index + 1] ) ) {
							$current_layout = $layout_settings[$index + 1];
						} else {
							continue;
						}
					}
					$post_columns = $current_layout['columns'];
					$template = $current_layout['template'];
					$image_size = $current_layout['image_size'];

					$classes = array(
						"post-{$template}"
					);
                    if(isset($post_settings['carousel_rows']) && $carousel_index == 0) {
                        echo '<div class="carousel-item clearfix">';
                    }
					if ( !isset( $post_settings['carousel'] )  || isset($post_settings['carousel_rows'])) {
						$classes[] = $post_columns;
					}

					$classes = wp_parse_args( $classes, $post_classes );

					$inner_classes = array();

					if ( is_sticky() && is_home() && !is_paged() && in_array( $template, array( 'large-image', 'medium-image', 'grid' ))) {
						$inner_classes[] = 'post-highlight';
					}


					$inner_classes = wp_parse_args( $inner_classes, $post_inner_classes );
					$post_class = implode( ' ', array_filter( $classes ) );
					$post_inner_class = implode( ' ', array_filter( $inner_classes ) );
					do_action( 'g5plus_before_archive_post', array( 'post_class' => $post_class, 'post_inner_class' => $post_inner_class ) );
					g5Theme()->helper()->getTemplate( "loop/layout/{$template}", array(
					    'image_size' => $image_size,
                        'post_class' => $post_class,
                        'post_inner_class' => $post_inner_class,
                        'placeholder_enable' => $placeholder_enable,
                        'post_item_skin' => $post_item_skin
                    ) );
					do_action( 'g5plus_after_archive_post', array( 'post_class' => $post_class, 'post_inner_class' => $post_inner_class ) );
					if ( $isFirst ) {
						unset( $layout_settings[$index] );
						$layout_settings = array_values( $layout_settings );
					}

					if ( $isFirst && $paged === 1 ) {
						$index = 0;
					} else {
						$index++;
					}
                    $carousel_index++;
                    if(isset($post_settings['carousel_rows']) && $carousel_index == $post_settings['carousel_rows']['items_show']) {
                        echo '</div>';
                        $carousel_index = 0;
                    }
				endwhile;
                if(isset($post_settings['carousel_rows']) && $carousel_index != $post_settings['carousel_rows']['items_show'] && $carousel_index != 0) {
                    echo '</div>';
                }
			}
		} else if (isset($post_settings['isMainQuery'])) {
			g5Theme()->helper()->getTemplate( 'loop/content-none' );
		}
		?>
	</div>
	<?php
	// You can use this for adding codes before the main loop
	do_action( 'g5plus_after_archive_wrapper' );
	?>
</div>



