<?php
/**
 * The template for displaying logo
 * @var $header_layout
 */
$logo = g5Theme()->options()->get_logo();
$logo = isset($logo['url']) ? $logo['url'] : '';


$logo_retina = g5Theme()->options()->get_logo_retina();
$logo_retina = isset($logo_retina['url']) ? $logo_retina['url'] : '';

$sticky_logo = g5Theme()->options()->get_sticky_logo();
$sticky_logo = isset($sticky_logo['url']) ? $sticky_logo['url'] : '';

$sticky_logo_retina = g5Theme()->options()->get_sticky_logo_retina();
$sticky_logo_retina = isset($sticky_logo_retina['url']) ? $sticky_logo_retina['url'] : '';

$logo_classes = array(
	'logo-header'
);

$logo_title = esc_attr(get_bloginfo('name', 'display')) . '-' . get_bloginfo('description', 'display');
$logo_text = get_bloginfo('name', 'display');
$header_logo_sticky_layout = array('header-1', 'header-2','header-3','header-4','header-5');
if (in_array($header_layout, $header_logo_sticky_layout) && ($sticky_logo)) {
	$logo_classes[] = 'has-logo-sticky';
}

$logo_attributes = array();
if ($logo_retina && ($logo_retina != $logo)) {
	$logo_attributes[] = 'data-retina="' . esc_url($logo_retina) . '"';
}

$logo_sticky_attributes = array();
if ($sticky_logo_retina && ($sticky_logo_retina != $sticky_logo)) {
	$logo_sticky_attributes[] = 'data-retina="' . esc_url($sticky_logo_retina) . '"';
}

$logo_class = implode(' ', array_filter($logo_classes));
?>
<div class="<?php echo esc_attr($logo_class) ?>">
	<a class="main-logo gsf-link" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
		<?php if (!empty($logo)): ?>
			<img <?php echo implode(' ', $logo_attributes); ?> src="<?php echo esc_url($logo) ?>" alt="<?php echo esc_attr($logo_title) ?>">
		<?php else: ?>
			<h2 class="logo-text"><?php echo esc_html($logo_text); ?></h2>
		<?php endif; ?>
	</a>
	<?php if (in_array($header_layout, $header_logo_sticky_layout) && ($sticky_logo)): ?>
		<a class="sticky-logo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
			<img <?php echo implode(' ', $logo_sticky_attributes); ?> src="<?php echo esc_url($sticky_logo) ?>" alt="<?php echo esc_attr($logo_title) ?>">
		</a>
	<?php endif; ?>
</div>
