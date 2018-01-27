<?php
/**
 * The template for displaying sidebar
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$sidebar_layout = g5Theme()->options()->get_sidebar_layout();
if ($sidebar_layout === 'none') return;
global $wp_registered_sidebars;
$sidebar = g5Theme()->options()->get_sidebar();
$sidebar_width = g5Theme()->options()->get_sidebar_width();
$sidebar_sticky_enable = g5Theme()->options()->get_sidebar_sticky_enable();
$mobile_sidebar_enable = g5Theme()->options()->get_mobile_sidebar_enable();
$mobile_sidebar_canvas = g5Theme()->options()->get_mobile_sidebar_canvas();

$wrapper_classes = array(
	'primary-sidebar',
	'sidebar'
);

$inner_classes = array(
	'primary-sidebar-inner'
);


$sidebar_col = ($sidebar_width == 'large') ? 4 : 3;
$wrapper_classes[] = "col-md-{$sidebar_col}";
if ($sidebar_layout === 'left') {
	$wrapper_classes[] = 'col-md-pull-'. (12- $sidebar_col);
}

if ($mobile_sidebar_enable !== 'on') {
	$wrapper_classes[] = 'hidden-sm';
	$wrapper_classes[] = 'hidden-xs';
} elseif ($mobile_sidebar_canvas === 'on') {
	$wrapper_classes[] = 'gf-sidebar-canvas';
}

if ($sidebar_sticky_enable === 'on') {
	$wrapper_classes[] = 'gf-sticky';
}


$wrapper_class = implode(' ', array_filter($wrapper_classes));
$inner_class = implode(' ', array_filter($inner_classes));
?>
<div class="<?php echo esc_attr($wrapper_class); ?>">
	<?php if ($mobile_sidebar_canvas === 'on'): ?>
		<a href="javascript:;" title="<?php esc_attr_e('Click to show sidebar', 'g5plus-april') ?>" class="gf-sidebar-toggle"><i class="fa fa-sliders"></i></a>
	<?php endif; ?>
	<div class="<?php echo esc_attr($inner_class); ?>">
		<?php if (is_active_sidebar($sidebar)): ?>
			<?php dynamic_sidebar($sidebar); ?>
		<?php elseif (isset($wp_registered_sidebars[$sidebar])): ?>
			<div class="gf-no-widget-content"> <?php printf(wp_kses_post(__('Please insert widget into sidebar <b>%s</b> in Appearance > <a title="manage widgets" href="%s">Widgets</a> ','g5plus-april')),$wp_registered_sidebars[$sidebar]['name'],admin_url( 'widgets.php' )); ?></div>
		<?php endif; ?>
	</div>
</div>
