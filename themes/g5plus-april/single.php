<?php
/**
 * The template for displaying single
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$single_post_layout = g5Theme()->options()->get_single_post_layout();
g5Theme()->helper()->getTemplate("single/{$single_post_layout}/layout");


