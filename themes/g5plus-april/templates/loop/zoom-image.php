<?php
/**
 * The template for displaying zoom-image.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $post_id
 * @var $image_id
 * @var $gallery_id
 * @var $image_size
 */
$image = wp_get_attachment_image_src($image_id,'full');
if ($image === false) return;
@list($src, $width, $height) = $image;
$args = array();
if ($gallery_id !== '') {
	$args['galleryId'] = $gallery_id;
}
$icon = 'fa fa-expand';
$class = 'zoom-image';
$post_format = get_post_format($post_id);
if (($post_format == 'video') && function_exists('gfPostFormatUi')) {
    $src = get_post_meta($post_id,gfPostFormatUi()->get_format_video_embed(),true);
	$args['type'] = 'iframe';
	$args['mainClass'] = 'mfp-fade';
	$icon = 'fa fa-play';
	$class = 'zoom-video';
}
?>
<a data-magnific="true" data-gallery-id="<?php echo esc_attr($gallery_id); ?>" data-magnific-options='<?php echo json_encode($args) ?>' href="<?php echo esc_url($src) ?>" class="<?php echo esc_attr($class); ?>"><i class="<?php echo esc_attr($icon); ?>"></i></a>

