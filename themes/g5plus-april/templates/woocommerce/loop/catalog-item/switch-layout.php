<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 07/08/2017
 * Time: 8:11 SA
 */
$catalog_layout = g5Theme()->options()->get_product_catalog_layout();
?>
<ul class="gf-shop-switch-layout gf-inline">
    <li class="<?php echo esc_attr($catalog_layout === 'grid' ? 'active' : ''); ?>"><a data-toggle="tooltip" href="#" data-layout="grid" title="<?php esc_attr_e('Grid','g5plus-april'); ?>"><i class="ion-ios-keypad"></i></a></li>
    <li class="<?php echo esc_attr($catalog_layout === 'list' ? 'active' : ''); ?>"><a data-toggle="tooltip" href="#" data-layout="list" title="<?php esc_attr_e('List','g5plus-april'); ?>"><i class="ion-navicon-round"></i></a></li>
</ul>