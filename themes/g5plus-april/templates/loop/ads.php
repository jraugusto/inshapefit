<?php
/**
 * The template for displaying ads.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $post_class
 * @var $post_inner_class
 */
if (!is_home() && !is_post_type_archive('post') && !is_category()) return;
global $wp_query;
$paged = $wp_query->get('page') ? intval($wp_query->get('page')) : $wp_query->get('paged') ? intval($wp_query->get('paged')) : 1;
if ($paged !== 1) return;
$post_settings = &g5Theme()->blog()->get_layout_settings();
$post_layout = isset($post_settings['post_layout']) ? $post_settings['post_layout'] : 'large-image';
if (!in_array($post_layout, array('large-image', 'medium-image'))) return;
$post_ads = g5Theme()->options()->get_post_ads();
if (!is_array($post_ads)) return;
$post_class = $post_class . ' gf-ads';
?>
<?php foreach ($post_ads as $ads): ?>
	<?php $position = isset($ads['position']) ? intval($ads['position']) : -1; ?>
	<?php if ($position === ($wp_query->current_post + 1)): ?>
		<article <?php post_class($post_class) ?>>
			<div class="<?php echo esc_attr($post_inner_class); ?>">
				<?php g5Theme()->helper()->shortCodeContent($ads['content']); ?>
			</div>
		</article>
	<?php endif; ?>
<?php endforeach; ?>
