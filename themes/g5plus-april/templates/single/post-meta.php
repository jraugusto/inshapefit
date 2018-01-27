<?php
/**
 * The template for displaying post-meta.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
?>
<ul class="gf-post-meta disable-color gf-inline">
    <?php g5Theme()->templates()->post_view(); ?>
    <?php g5Theme()->templates()->post_like(); ?>
    <li class="meta-date">
        <i class="ion-ios-calendar-outline"></i> <?php echo get_the_date(get_option('date_format')); ?>
    </li>
</ul>
