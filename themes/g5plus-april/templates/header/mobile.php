<?php
/**
 * The template for displaying mobile
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$mobile_header_layout = g5Theme()->options()->get_mobile_header_layout();
$mobile_header_sticky_enable = g5Theme()->options()->get_mobile_header_sticky_enable();
$mobile_header_border = g5Theme()->options()->get_mobile_header_border();
$skin = g5Theme()->options()->get_mobile_header_skin();

$mobile_header_classes = array(
	'mobile-header',
	$mobile_header_layout
);
$header_attributes = array();

$skin_classes = g5Theme()->helper()->getSkinClass($skin);
$mobile_header_classes = array_merge($mobile_header_classes,$skin_classes);
if (!empty($skin)) {
	$header_attributes[] = 'data-sticky-skin="gf-skin '. $skin .'"';
}

$mobile_header_class = implode(' ',array_filter($mobile_header_classes));
?>
<header <?php echo implode(' ',$header_attributes)?> class="<?php echo esc_attr($mobile_header_class) ?>">
	<?php g5Theme()->helper()->getTemplate('header/mobile/top-bar'); ?>
	<?php g5Theme()->helper()->getTemplate("header/mobile/{$mobile_header_layout}",array(
		'header_layout' => $mobile_header_layout,
		'header_border' => $mobile_header_border,
		'header_sticky_enable' => $mobile_header_sticky_enable
	)); ?>
	<?php g5Theme()->helper()->getTemplate('header/mobile/search'); ?>
</header>
