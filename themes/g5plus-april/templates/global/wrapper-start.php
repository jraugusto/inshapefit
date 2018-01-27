<?php
/**
 * The template for displaying wrapper-start
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */

$content_full_width = g5Theme()->options()->get_content_full_width();
$sidebar_layout = g5Theme()->options()->get_sidebar_layout();
$sidebar_width = g5Theme()->options()->get_sidebar_width();
$wrapper_classes = array();

$inner_classes = array();


if ($content_full_width === 'on') {
	$wrapper_classes[] = 'gf-content-full-width';
}

$sidebar_col = 0;
if ($sidebar_layout !== 'none') {
	$sidebar_col = ($sidebar_width === 'large') ? 4 : 3;
}

$inner_classes[] = 'col-md-'. (12 - $sidebar_col);
if ($sidebar_layout === 'left') {
	$inner_classes[] = "col-md-push-{$sidebar_col}";
}


$wrapper_class = implode(' ', array_filter($wrapper_classes));
$inner_class = implode(' ', array_filter($inner_classes));
/**
 * @hooked - g5Theme()->templates()->page_title() - 5
 **/
do_action('g5plus_before_main_content');
?>
<!-- Primary Content Wrapper -->
<div id="primary-content" class="<?php echo esc_attr($wrapper_class); ?>">
	<!-- Primary Content Container -->
	<?php if ($content_full_width !== 'on'): ?>
	<div class="container clearfix">
	<?php endif; ?>
		<?php do_action('g5plus_main_content_top') ?>
		<!-- Primary Content Row -->
		<div class="row clearfix">
			<!-- Primary Content Inner -->
			<div class="<?php echo esc_attr($inner_class); ?>">


