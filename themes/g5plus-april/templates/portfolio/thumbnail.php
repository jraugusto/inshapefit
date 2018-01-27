<?php
/**
 * @var $post_id
 * @var $image_size
 * @var $placeholder_enable
 * @var $image_mode
 * @var $image_ratio
 */
remove_action('g5plus_before_post_image',array(g5Theme()->templates(),'zoom_image_thumbnail'));
if (has_post_thumbnail($post_id)) {
    $image_id = get_post_thumbnail_id($post_id);
    g5Theme()->blog()->render_post_image_markup(array(
        'post_id'           => $post_id,
        'image_id'          => $image_id,
        'image_size'        => $image_size,
        'display_permalink' => false,
        'image_mode'        => $image_mode,
        'image_ratio' =>    $image_ratio
    ));
} else if ($placeholder_enable === true) { ?>
    <div class="entry-thumbnail">
        <div class="entry-thumbnail-overlay thumbnail-size-<?php echo esc_attr($image_size); ?> placeholder-image">
        </div>
    </div>
<?php
}
add_action('g5plus_before_post_image',array(g5Theme()->templates(),'zoom_image_thumbnail'));
