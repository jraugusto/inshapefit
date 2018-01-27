<?php
/**
 * The template for displaying content-large-image
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $image_size
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder_enable
 */
$quote_content = get_post_meta(get_the_ID(),gfPostFormatUi()->get_format_quote_content(),true);
?>
<article <?php post_class($post_class) ?>>
	<div class="<?php echo esc_attr($post_inner_class); ?>">
		<?php g5Theme()->blog()->render_post_thumbnail_markup(array(
			'image_size' => $image_size,
			'placeholder_enable' => $placeholder_enable,
			'mode' => 'full',
            'image_mode'         => 'image'
		)); ?>
		<div class="gf-post-content">
            <?php if(!(has_post_format('quote') && !empty($quote_content))): ?>
                <div class="gf-post-cat-meta">
                    <?php echo get_the_category_list(', '); ?>
                </div>
                <?php g5Theme()->helper()->getTemplate('loop/post-title') ?>
                <?php g5Theme()->helper()->getTemplate('loop/post-meta') ?>
                <div class="gf-post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>
            <div class="gf-post-control">
                <div class="gf-post-read-more">
                    <a href="<?php the_permalink(); ?>" class="btn btn-black btn-classic btn-square btn-md"><?php esc_html_e('Read More', 'g5plus-april'); ?></a>
                </div>
                <?php do_action('g5plus_post_share') ?>
            </div>
		</div>
	</div>
</article>