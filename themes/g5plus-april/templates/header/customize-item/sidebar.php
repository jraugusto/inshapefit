<?php
/**
 * The template for displaying sidebar
 * @var $customize_location
 */
global $wp_registered_sidebars;
$sidebar = g5Theme()->options()->getOptions("header_customize_{$customize_location}_sidebar");
?>
<?php if (is_active_sidebar($sidebar)): ?>
	<?php dynamic_sidebar($sidebar) ?>
<?php elseif (isset($wp_registered_sidebars[$sidebar])): ?>
	<div class="gf-no-widget-content"> <?php printf(wp_kses_post(__('Please insert widget into sidebar <b>%s</b> in Appearance > <a title="manage widgets" href="%s">Widgets</a> ','g5plus-april')),$wp_registered_sidebars[$sidebar]['name'],admin_url( 'widgets.php' )); ?></div>
<?php endif; ?>
