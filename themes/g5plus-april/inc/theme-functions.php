<?php
/**
 * The template for displaying theme-functions.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
if (!function_exists('g5plus_comments_callback')) {
	function g5plus_comments_callback($comment, $args, $depth) {
		g5Theme()->helper()->getTemplate('comments',array(
			'comment' => $comment,
			'args' => $args,
			'depth' => $depth
		));
	}
}
