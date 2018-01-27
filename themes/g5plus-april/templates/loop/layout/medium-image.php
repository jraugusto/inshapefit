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
global $hasThumb;
$excerpt = get_the_excerpt();
$excerpt = g5Theme()->helper()->truncateText($excerpt,200);
$quote_content = get_post_meta(get_the_ID(),gfPostFormatUi()->get_format_quote_content(),true);
?>
<article <?php post_class($post_class) ?>>
	<div class="<?php echo esc_attr($post_inner_class); ?>">
        <?php if(!(has_post_format('quote') && !empty($quote_content))): ?>
            <?php g5Theme()->blog()->render_post_thumbnail_markup(array(
                'image_size' => $image_size,
                'placeholder_enable' => $placeholder_enable,
                'mode' => 'full'
            )); ?>
        <?php endif; ?>
		<div class="gf-post-content">
            <div class="gf-post-cat-meta">
                <?php echo get_the_category_list(', '); ?>
            </div>
			<?php g5Theme()->helper()->getTemplate('loop/post-title') ?>
            <?php if(!(has_post_format('quote') && !empty($quote_content))): ?>
                <?php if(!$hasThumb): ?>
                    <div class="gf-post-excerpt">
                        <?php echo esc_html($excerpt); ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="entry-quote-content">
                    <div class="block-center">
                        <div class="block-center-inner">
                            <div class="gf-post-quote-content">
                                <i class="fa fa-quote-right"></i>
                                <p>« <?php echo esc_html($quote_content); ?> »</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php g5Theme()->helper()->getTemplate('loop/post-meta') ?>

		</div>
	</div>
</article>
