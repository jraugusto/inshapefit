<?php
/**
 * The template for displaying social-networks
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $customize_location
 */
$social_networks =  g5Theme()->options()->getOptions("header_customize_{$customize_location}_social_networks");
g5Theme()->templates()->social_networks($social_networks,'classic');

