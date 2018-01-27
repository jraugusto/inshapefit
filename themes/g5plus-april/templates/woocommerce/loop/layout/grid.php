<?php
/**
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $image_size
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder_enable
 */
wc_get_template( 'content-product.php', array(
    'image_size' => $image_size,
    'post_class' => $post_class,
    'post_inner_class' => $post_inner_class,
    'placeholder_enable' => $placeholder_enable
    ));

