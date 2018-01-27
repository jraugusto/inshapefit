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

$header_inner_classes = array(
	'header-inner',
    'x-nav-menu-container'
);

if ($header_border === 'container') {
	$header_inner_classes[] = 'gf-border-bottom';
	$header_inner_classes[] = 'border-color';
}

if ($header_border == 'full') {
	$header_classes[] = 'gf-border-bottom';
	$header_classes[] = 'border-color';
}

if ($header_sticky_enable == 'on') {
	$header_classes[] = 'header-sticky';
}

if ($header_content_full_width === 'on') {
    $header_classes[] = 'header-full-width';
}

$header_class = implode(' ', array_filter($header_classes));
$header_inner_class = implode(' ', array_filter($header_inner_classes));
?>
<div class="<?php echo esc_attr($header_class) ?>">
    <div class="container">
		<div class="<?php echo esc_attr($header_inner_class) ?>">
            <?php g5Theme()->helper()->getTemplate('header/header-customize', array('customize_location' => 'left', 'canvas_position' => 'left')); ?>
			<nav class="primary-menu">
				<div class="primary-menu-inner">
                    <div class="left-menu">
                        <?php if (has_nav_menu('left-menu') || $page_menu): ?>
                            <?php
                            $arg_menu = array(
                                'menu_id' => 'left-menu',
                                'container' => '',
                                'theme_location' => 'left-menu',
                                'menu_class' => 'main-menu clearfix sub-menu-left',
                                'main_menu' => true
                            );
                            if (!empty($page_menu)) {
                                $arg_menu['menu'] = $page_menu;
                            }
                            wp_nav_menu($arg_menu);
                            ?>
                        <?php else: ?>
                            <div class="no-menu"><?php printf(wp_kses_post(__('Please assign a menu to the <b>Left Menu</b> in Appearance > <a title="Menus" href="%s">Menus</a>', 'g5plus-april')), admin_url('nav-menus.php')); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php g5Theme()->helper()->getTemplate('header/desktop/logo',array('header_layout' => $header_layout)); ?>
                    <div class="right-menu">
                        <?php if (has_nav_menu('right-menu') || $page_menu): ?>
                            <?php
                            $arg_menu = array(
                                'menu_id' => 'right-menu',
                                'container' => '',
                                'theme_location' => 'right-menu',
                                'menu_class' => 'main-menu clearfix sub-menu-right',
                                'main_menu' => true
                            );
                            if (!empty($page_menu)) {
                                $arg_menu['menu'] = $page_menu;
                            }
                            wp_nav_menu($arg_menu);
                            ?>
                        <?php else: ?>
                            <div class="no-menu"><?php printf(wp_kses_post(__('Please assign a menu to the <b>Right Menu</b> in Appearance > <a title="Menus" href="%s">Menus</a>', 'g5plus-april')), admin_url('nav-menus.php')); ?></div>
                        <?php endif; ?>
                    </div>
				</div>
			</nav>
            <?php g5Theme()->helper()->getTemplate('header/header-customize', array('customize_location' => 'right', 'canvas_position' => 'right')); ?>
		</div>
    </div>
</div>


