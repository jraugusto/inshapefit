<?php
/**
 * The template for displaying layout-1
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $header_layout
 * @var $header_float_enable
 * @var $header_border
 * @var $header_content_full_width
 * @var $header_sticky_enable
 * @var $navigation_skin
 * @var $page_menu
 */

$header_classes = array(
	'header-wrap'
);

$header_above_inner_classes = array(
	'header-inner',
    'x-nav-menu-container'
);

$header_above_classes = array(
	'header-above'
);

$navigation_classes = array(
	'primary-menu'
);

$navigation_inner_classes = array(
	'primary-menu-inner'
);

$navigation_attributes = array();

if (!empty($navigation_skin)) {
	$navigation_skin_classes = g5Theme()->helper()->getSkinClass($navigation_skin);
	$navigation_classes = array_merge($navigation_classes,$navigation_skin_classes);
	$navigation_attributes[] = 'data-skin="gf-skin '. $navigation_skin .'"';
}

if ($header_border === 'container') {
	$navigation_inner_classes[] = 'gf-border-bottom';
	$navigation_inner_classes[] = 'border-color';
}

if ($header_border == 'full') {
	$header_classes[] = 'gf-border-bottom';
	$header_classes[] = 'border-color';
}

if ($header_sticky_enable == 'on') {
	$navigation_classes[] = 'header-sticky';
}

$header_above_border = g5Theme()->options()->get_header_above_border();
if ($header_above_border === 'container') {
	$header_above_inner_classes[] = 'gf-border-bottom';
	$header_above_inner_classes[] = 'border-color';
}

if ($header_above_border == 'full') {
	$header_above_classes[] = 'gf-border-bottom';
	$header_above_classes[] = 'border-color';
}

if ($header_content_full_width === 'on') {
    $header_above_classes[] = 'header-full-width';
    $navigation_classes[] = 'header-full-width';
}

$header_class = implode(' ', array_filter($header_classes));
$header_above_inner_class = implode(' ', array_filter($header_above_inner_classes));
$header_above_class = implode(' ', array_filter($header_above_classes));
$navigation_class = implode(' ', array_filter($navigation_classes));
$navigation_inner_class = implode(' ', array_filter($navigation_inner_classes));
?>
<div class="<?php echo esc_attr($header_class) ?>">
	<div class="<?php echo esc_attr($header_above_class); ?>">
		<div class="container">
			<div class="<?php echo esc_attr($header_above_inner_class) ?>">
				<?php g5Theme()->helper()->getTemplate('header/header-customize', array('customize_location' => 'left', 'canvas_position' => 'left')); ?>
				<?php g5Theme()->helper()->getTemplate('header/desktop/logo',array('header_layout' => $header_layout)); ?>
				<?php g5Theme()->helper()->getTemplate('header/header-customize', array('customize_location' => 'right', 'canvas_position' => 'right')); ?>
			</div>
		</div>
	</div>

	<nav <?php echo implode(' ',$navigation_attributes);?> class="<?php echo esc_attr($navigation_class); ?>">
		<div class="container">
			<div class="<?php echo esc_attr($navigation_inner_class); ?>">
				<?php if (has_nav_menu('primary') || $page_menu): ?>
					<?php
					$arg_menu = array(
						'menu_id' => 'main-menu',
						'container' => '',
						'theme_location' => 'primary',
						'menu_class' => 'main-menu clearfix',
                        'main_menu' => true
					);
                    if (!empty($page_menu)) {
                        $arg_menu['menu'] = $page_menu;
                    }
					wp_nav_menu($arg_menu);
					?>
				<?php else: ?>
					<div class="no-menu"><?php printf(wp_kses_post(__('Please assign a menu to the <b>Primary Menu</b> in Appearance > <a title="Menus" href="%s">Menus</a>', 'g5plus-april')), admin_url('nav-menus.php')); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</nav>
</div>


