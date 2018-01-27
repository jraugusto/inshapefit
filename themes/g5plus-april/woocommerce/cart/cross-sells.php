<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 * @var $cross_sells
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product_cross_sells_enable = g5Theme()->options()->get_product_cross_sells_enable();
if('on' !== $product_cross_sells_enable) return;

$product_cross_sells_gutter = intval(g5Theme()->options()->get_product_cross_sells_columns_gutter());
$product_columns = intval(g5Theme()->options()->get_product_cross_sells_columns());
$product_columns_md = intval(g5Theme()->options()->get_product_cross_sells_columns_md());
$product_columns_sm = intval(g5Theme()->options()->get_product_cross_sells_columns_sm());
$product_columns_xs = intval(g5Theme()->options()->get_product_cross_sells_columns_xs());
$product_columns_mb = intval(g5Theme()->options()->get_product_cross_sells_columns_mb());
$product_animation = g5Theme()->options()->get_product_cross_sells_animation();

$settings = array(
    'post_layout'            => 'grid',
    'post_columns'           => array(
        'lg' => $product_columns,
        'md' => $product_columns_md,
        'sm' => $product_columns_sm,
        'xs' => $product_columns_xs,
        'mb' => $product_columns_mb,
    ),
    'post_columns_gutter'    => $product_cross_sells_gutter,
    'post_paging'            => 'none',
    'post_animation'         => $product_animation,
    'itemSelector'           => 'article',
    'category_filter_enable' => false,
    'post_type' => 'product'
);

$settings['carousel'] = array(
    'items' => $product_columns,
    'margin' => $product_columns == 1 ? 0 : $product_cross_sells_gutter,
    'slideBy' => $product_columns,
    'responsive' => array(
        '1200' => array(
            'items' => $product_columns,
            'margin' => $product_columns == 1 ? 0 : $product_cross_sells_gutter,
            'slideBy' => $product_columns,
        ),
        '992' => array(
            'items' => $product_columns_md,
            'margin' => $product_columns_md == 1 ? 0 : $product_cross_sells_gutter,
            'slideBy' => $product_columns_md,
        ),
        '768' => array(
            'items' => $product_columns_sm,
            'margin' => $product_columns_sm == 1 ? 0 : $product_cross_sells_gutter,
            'slideBy' => $product_columns_sm,
        ),
        '600' => array(
            'items' => $product_columns_xs,
            'margin' => $product_columns_xs == 1 ? 0 : $product_cross_sells_gutter,
            'slideBy' => $product_columns_xs,
        ),
        '0' => array(
            'items' => $product_columns_mb,
            'margin' => $product_columns_mb == 1 ? 0 : $product_cross_sells_gutter,
            'slideBy' => $product_columns_mb,
        )
    ),
    'autoHeight' => true,
);


g5Theme()->blog()->set_layout_settings($settings);

if ( $cross_sells ) : ?>

	<div class="cross-sells">

		<h2><?php _e( 'Cross sells product', 'g5plus-april' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				 	$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
g5Theme()->blog()->unset_layout_settings();