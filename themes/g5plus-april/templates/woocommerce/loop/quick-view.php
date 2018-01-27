<?php
/**
 * Template display quickview
 *
 * @package WordPress
 * @subpackage April
 * @since April 1.0
 */
global $product;
$product_quick_view = g5Theme()->options()->get_product_quick_view_enable();
if ('on' !== $product_quick_view) return;
?>
<a data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Quick view', 'g5plus-april') ?>" class="product-quick-view no-animation" data-product_id="<?php echo esc_attr($product->get_id()); ?>" href="<?php the_permalink(); ?>"><i class="ion-ios-search-strong"></i></a>