<?php
/**
 * The template for displaying header-1.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $header_border
 * @var $header_sticky_enable
 */

$header_classes = array(
	'mobile-header-wrap'
);

$header_inner_classes = array(
	'mobile-header-inner',
	'clearfix'
);

if ($header_border === 'container') {
	$header_inner_classes[] = 'gf-border-bottom';
	$header_inner_classes[] = 'border-color';
}

if ($header_border == 'full') {
	$header_classes[] = 'gf-border-bottom';
	$header_classes[] = 'border-color';
}

if ($header_sticky_enable === 'on') {
	$header_classes[] = 'header-sticky';
}

$header_class = implode(' ', array_filter($header_classes));
$header_inner_class = implode(' ', array_filter($header_inner_classes));
?>
<div class="<?php echo esc_attr($header_class) ?>">
	<div class="container">
		<div class="<?php echo esc_attr($header_inner_class) ?>">
			<?php g5Theme()->helper()->getTemplate('header/mobile/toggle-menu',array('canvas_position' => 'left')) ?>
			<?php g5Theme()->helper()->getTemplate('header/mobile/logo') ?>
			<?php g5Theme()->helper()->getTemplate('header/header-customize', array('customize_location' => 'mobile','canvas_position' => 'right')); ?>
		</div>
	</div>
</div>
