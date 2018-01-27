<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $desktop
 * @var $mobile
 * @var $tablet
 * @var $tablet_portrait
 * @var $mobile_landscape
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Space
 */
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_script(G5P()->assetsHandle('space_js'), G5P()->helper()->getAssetUrl('shortcodes/space/assets/js/space.min.js'), array( 'jquery' ), G5P()->pluginVer(), true);
if($mobile == "" && $tablet == "")
    $mobile =  $tablet =  $desktop;
$sid = uniqid();
?>
<div class="g5plus-space space-<?php echo esc_attr($sid); ?>" data-id="<?php echo esc_attr($sid); ?>" data-tablet="<?php echo esc_attr($tablet); ?>" data-tablet-portrait="<?php echo esc_attr($tablet_portrait); ?>" data-mobile="<?php echo esc_attr($mobile); ?>" data-mobile-landscape="<?php echo esc_attr($mobile_landscape); ?>" style="clear: both; display: block; height: <?php echo esc_attr($desktop); ?>px"></div>