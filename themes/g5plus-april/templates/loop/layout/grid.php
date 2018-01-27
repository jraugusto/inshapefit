<?php
/**
 * The template for displaying content-grid.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $image_size
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder_enable
 * @var $post_item_skin
 */
global $hasThumb;
$excerpt = get_the_excerpt();
$excerpt_length = 200;
if('post-skin-03' === $post_item_skin) {
    $excerpt_length = 120;
}
$excerpt = g5Theme()->helper()->truncateText($excerpt,$excerpt_length);
$quote_content = get_post_meta(get_the_ID(),gfPostFormatUi()->get_format_quote_content(),true);
?>
<article <?php post_class($post_class) ?>>
	<div class="<?php echo esc_attr($post_inner_class); ?>">
		<?php g5Theme()->blog()->render_post_thumbnail_markup(array(
			'image_size' => $image_size,
			'placeholder_enable' => $placeholder_enable,
			'mode' => 'full',
		)); ?>
		<div class="gf-post-content">
            <?php if(!(has_post_format('quote') && !empty($quote_content))): ?>
                <?php if('post-skin-03' !== $post_item_skin) : ?>
                    <div class="gf-post-cat-meta">
                        <?php echo get_the_category_list(', '); ?>
                    </div>
                <?php else: ?>
                    <?php g5Theme()->helper()->getTemplate('loop/post-meta-02') ?>
                <?php endif; ?>
                <?php g5Theme()->helper()->getTemplate('loop/post-title') ?>
                <?php if(!$hasThumb || 'post-skin-03' === $post_item_skin): ?>
                    <div class="gf-post-excerpt">
                        <?php echo esc_html($excerpt); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="gf-post-read-more">
                <a href="<?php the_permalink(); ?>" class="btn btn-black btn-link-xs"><?php esc_html_e('read more', 'g5plus-april'); ?></a>
            </div>
		</div>
	</div>
</article>