<?php
/**
 * The template for displaying desktop
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$header_layout = g5Theme()->options()->get_header_layout();
$header_float_enable  = g5Theme()->options()->get_header_float_enable();
$header_border = g5Theme()->options()->get_header_border();
$header_content_full_width = g5Theme()->options()->get_header_content_full_width();
$header_sticky_enable = g5Theme()->options()->get_header_sticky_enable();
$skin = g5Theme()->options()->get_header_skin();
$navigation_skin = g5Theme()->options()->get_navigation_skin();
$page_menu = '';
if (is_singular()) {
	$page_menu = g5Theme()->metaBox()->get_page_menu();
}

$header_responsive_breakpoint = g5Theme()->options()->get_header_responsive_breakpoint();

$header_classes = array(
	'main-header',
	$header_layout
);
$skin_classes = g5Theme()->helper()->getSkinClass($skin);
$header_classes = array_merge($header_classes,$skin_classes);

if ($header_float_enable === 'on' && !in_array($header_layout,array('header-7','header-8'))) {
	$header_classes[] = 'header-float';
}

if (in_array($header_layout,array('header-7','header-8'))) {
	$header_classes[] = 'header-vertical';
}

/*if ($header_border == 'full') {
	$header_classes[] = 'gf-border-bottom';
}*/
$nav_spacing = g5Theme()->options()->get_navigation_spacing();
$header_attributes = array(
	'data-layout="'. esc_attr($header_layout) .'"',
	'data-responsive-breakpoint="'. esc_attr($header_responsive_breakpoint) .'"',
    'data-navigation="' . esc_attr($nav_spacing) . '"',
);
if (($header_sticky_enable === 'on') &&  !in_array($header_layout,array('header-7','header-8'))) {
	$sticky_skin = g5Theme()->options()->get_header_sticky_skin();
	$sticky_skin_classes = g5Theme()->helper()->getSkinClass($sticky_skin);
	$sticky_skin_class = implode(' ', $sticky_skin_classes);
	$header_attributes[] = 'data-sticky-skin="'. $sticky_skin_class .'"';
}
$header_class = implode(' ',array_filter($header_classes));
?>
<header <?php echo implode(' ', $header_attributes) ?> class="<?php echo esc_attr($header_class); ?>">
	<?php if (!in_array($header_layout,array('header-7','header-8'))) {g5Theme()->helper()->getTemplate('header/desktop/top-bar');}  ?>
	<?php g5Theme()->helper()->getTemplate("header/desktop/{$header_layout}",array(
		'header_layout' => $header_layout,
		'header_float_enable' => $header_float_enable,
		'header_border' => $header_border,
		'header_content_full_width' => $header_content_full_width,
		'header_sticky_enable' => $header_sticky_enable,
		'navigation_skin' => $navigation_skin,
		'page_menu' => $page_menu
	)); ?>
</header>
