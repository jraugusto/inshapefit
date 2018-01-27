<?php
/**
 * The template for displaying post-view.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
if (in_array('post-views-counter/post-views-counter.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    $post_views_counter_settings_display = get_option('post_views_counter_settings_display');
    if (is_array($post_views_counter_settings_display) && isset($post_views_counter_settings_display['position']) && $post_views_counter_settings_display['position'] === 'manual') {
        ?>
        <li class="meta-view">
            <?php
            echo do_shortcode('[post-views]');
            ?>
        </li>
        <?php
    }
}

