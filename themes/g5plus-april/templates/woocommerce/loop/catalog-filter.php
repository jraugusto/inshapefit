<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $wp_registered_sidebars;
if (!woocommerce_products_will_display()) return;
$woocommerce_customize = g5Theme()->options()->get_woocommerce_customize();
$product_layout = g5Theme()->options()->get_product_catalog_layout();
if(!in_array($product_layout, array('grid', 'list'))) {
    if(isset($woocommerce_customize['left']['switch-layout'])) {
        unset($woocommerce_customize['left']['switch-layout']);
    }
    if(isset($woocommerce_customize['right']['switch-layout'])) {
        unset($woocommerce_customize['right']['switch-layout']);
    }
}
?>
<div data-table-cell="true" class="gsf-catalog-filter gf-table-cell">
    <div class="gf-table-cell-left">
    <?php if(isset($woocommerce_customize['left'])): ?>
        <ul class="gf-inline">
            <?php foreach ($woocommerce_customize['left'] as $key => $value): ?>
                <li class="gsf-catalog-filter-<?php echo esc_attr($key)?>">
                    <?php g5Theme()->helper()->getTemplate("woocommerce/loop/catalog-item/{$key}"); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </div>
    <div class="gf-table-cell-right">
    <?php if(isset($woocommerce_customize['right'])): ?>
        <ul class="gf-inline">
            <?php foreach ($woocommerce_customize['right'] as $key => $value): ?>
                <li class="gsf-catalog-filter-<?php echo esc_attr($key)?>">
                    <?php g5Theme()->helper()->getTemplate("woocommerce/loop/catalog-item/{$key}"); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </div>
</div>
