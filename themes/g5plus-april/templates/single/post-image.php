<?php
/**
 * The template for displaying post-image.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$single_post_layout = g5Theme()->options()->get_single_post_layout();
$image_size = 'blog-large';
$image_mode = 'image';
if (in_array($single_post_layout,array('layout-4','layout-5'))) {
	$image_mode = 'background';
}
g5Theme()->blog()->render_post_thumbnail_markup(array(
	'image_size' => $image_size,
	'placeholder_enable' => false,
	'mode' => 'full',
	'is_single' => true,
	'display_permalink' => false,
	'image_mode' => $image_mode,
));