<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $product_ids
 * @var $product_animation
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Products_Index
 */
$product_ids = $product_animation = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-products-index',
	'woocommerce',
	'product',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
if(empty($product_ids)) return;
$product_ids = explode(',', $product_ids);
$query_args = array(
    'post_status'    => 'publish',
    'post_type'      => 'product',
    'no_found_rows'  => 1,
    'post__in' => $product_ids,
    'orderby' => 'post__in'
);


$carousel_args = $owl_args = array(
    'items' => 1,
    'margin' => 0,
    'slideBy' => 1,
    'dots' => false,
    'nav' => false
);
$settings = array(
    'post_layout'            => 'grid',
    'itemSelector'           => 'article',
    'category_filter_enable' => false,
    'post_type' => 'product',
    'carousel' => $carousel_args
);

if($product_animation !== '') {
    $settings['post_animation'] = $product_animation;
}
$wrapper_class = implode(' ', array_filter($wrapper_classes));
if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
    wp_enqueue_style(G5P()->assetsHandle('gf-products-index'), G5P()->helper()->getAssetUrl('shortcodes/products-index/assets/css/products-index.min.css'), array(), G5P()->pluginVer());
}
wp_enqueue_script(G5P()->assetsHandle('products-index'), G5P()->helper()->getAssetUrl('shortcodes/products-index/assets/js/products-index.min.js'), array( 'jquery' ), G5P()->pluginVer(), true);
global $product;
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
    <div class="products-wrap">
        <?php if(function_exists('g5Theme')): ?>
            <?php g5Theme()->woocommerce()->archive_markup($query_args, $settings); ?>
        <?php endif; ?>
    </div>
    <div class="product-index-wrap">
        <?php foreach ($product_ids as $index=>$value): ?>
            <?php
            $index_text = $index;
            $index_text++;
            if($index < 10) $index_text = '0' . $index_text;?>
            <div class="index-item <?php echo ($index == 0 ? 'active' : ''); ?>" data-item-index="<?php echo esc_attr($index); ?>"><?php echo esc_attr($index_text); ?></div>
        <?php endforeach; ?>
    </div>
</div>