<?php
/**
 * The template for displaying custom-html
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $customize_location
 */
$custom_html = g5Theme()->options()->getOptions("header_customize_{$customize_location}_custom_html");
echo wp_kses_post($custom_html);