<?php
/**
 * The template for displaying post-thumbnail-simple.php
 * @var $post_id
 * @var $image_size
 * @var $placeholder_enable
 * @var $display_permalink
 * @var $mode
 * @var $image_mode
 * @var $is_single
 */
$gallery_id = '';
global $hasThumb;
$hasThumb = false;
ob_start();
?>
<?php if(has_post_format('gallery')): ?>
		<?php $gallery_images = get_post_meta($post_id,gfPostFormatUi()->get_format_gallery_images(),true); ?>
		<?php if ($gallery_images !== ''): ?>
			<?php $gallery_images = preg_split('/\|/',$gallery_images);
			$owl_args = array(
				'items' => 1,
				'loop' => false,
				'autoHeight' => true,
				'nav' => true
			);
			$gallery_id = rand();
			$hasThumb = true;
			?>
			<div class="owl-carousel owl-theme" data-owl-options='<?php echo json_encode($owl_args); ?>'>
				<?php foreach ($gallery_images as $image_id) : ?>
					<?php g5Theme()->blog()->render_post_image_markup(array(
						'post_id' => $post_id,
						'image_id' => $image_id,
						'image_size' => $image_size,
						'gallery_id' => $gallery_id,
						'display_permalink' => $display_permalink,
						'image_mode' => $image_mode
					)); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php elseif (has_post_format('video')): ?>
		<?php $video_embed = get_post_meta($post_id,gfPostFormatUi()->get_format_video_embed(),true);?>
		<?php if ($video_embed !== ''): ?>
			<?php if (wp_oembed_get($video_embed) !== false): ?>
				<?php if (has_post_thumbnail($post_id)): ?>
					<?php $hasThumb = true; ?>
					<?php g5Theme()->blog()->render_post_image_markup(array(
						'post_id' => $post_id,
						'image_id' => get_post_thumbnail_id($post_id),
						'image_size' => $image_size,
						'gallery_id' => $gallery_id,
						'display_permalink' => $display_permalink,
						'image_mode' => $image_mode
					)); ?>
				<?php elseif ($mode !== 'simple'): ?>
					<?php $hasThumb = true; ?>
					<div class="embed-responsive embed-responsive-16by9 embed-responsive-<?php echo esc_attr($image_size); ?>">
						<?php echo wp_oembed_get($video_embed, array('wmode' => 'transparent')); ?>
					</div>
				<?php endif; ?>
			<?php elseif ($mode !== 'simple'): ?>
				<?php $hasThumb = true; ?>
				<div class="embed-responsive embed-responsive-16by9 embed-responsive-<?php echo esc_attr($image_size); ?>">
					<?php echo wp_kses_post($video_embed); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

	<?php elseif (has_post_format('audio')): ?>
		<?php $audio_embed = get_post_meta($post_id,gfPostFormatUi()->get_format_audio_embed(),true); ?>
		<?php if ($audio_embed !== ''): ?>
			<?php $hasThumb = true; ?>
			<div class="embed-responsive embed-responsive-16by9 embed-responsive-<?php echo esc_attr($image_size); ?>">
				<?php if (wp_oembed_get($audio_embed)) : ?>
					<?php echo wp_oembed_get($audio_embed); ?>
				<?php else : ?>
					<?php echo wp_kses_post($audio_embed); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php elseif (has_post_format('quote') && ($mode !== 'simple')): ?>
		<?php
		$quote_content = get_post_meta($post_id,gfPostFormatUi()->get_format_quote_content(),true);
        $quote_author_text = get_post_meta($post_id,gfPostFormatUi()->get_format_quote_author_text(),true);
        $quote_author_url = get_post_meta($post_id,gfPostFormatUi()->get_format_quote_author_url(),true);
		?>
		<?php if ($quote_content !== ''): ?>
			<?php $hasThumb = true; ?>
			<div class="entry-quote-thumbnail thumbnail-size-<?php echo esc_attr($image_size); ?>">
				<?php if (has_post_thumbnail($post_id)): ?>
					<?php
					$quote_bg_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
					$quote_bg_image = $quote_bg_image[0];
					?>
					<div class="entry-quote-bg" style="background-image: url('<?php echo esc_url($quote_bg_image); ?>')"></div>
				<?php endif; ?>
				<div class="entry-quote-content">
					<div class="block-center">
						<div class="block-center-inner">
                            <?php if(!$is_single): ?>
                                <div class="gf-post-cat-meta">
                                    <?php echo get_the_category_list(', '); ?>
                                </div>
                                <?php if($image_size === 'blog-large'): ?>
                                    <?php g5Theme()->helper()->getTemplate('loop/post-title') ?>
                                    <?php g5Theme()->helper()->getTemplate('loop/post-meta') ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="gf-post-quote-content">
                                <i class="fa fa-quote-right"></i>
                                <p>« <?php echo esc_html($quote_content); ?> »</p>
                                <?php if ($quote_author_text !== '' && $is_single): ?>
                                    <div class="gf-post-quote-author">
                                        <a class="gsf-link" target="_blank" href="<?php echo esc_url($quote_author_url !== '' ? $quote_author_url : '#')?>" title="<?php echo esc_attr($quote_author_text)?>"><?php echo esc_html($quote_author_text) ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php elseif (has_post_format('link') && ($mode !== 'simple') ): ?>
		<?php
		$link_text = get_post_meta($post_id,gfPostFormatUi()->get_format_link_text(),true);
		$link_url = get_post_meta($post_id,gfPostFormatUi()->get_format_link_url(),true);
		?>
		<?php if ($link_text !== ''): ?>
			<?php $hasThumb = true; ?>
			<div class="entry-quote-thumbnail thumbnail-size-<?php echo esc_attr($image_size); ?>">
				<?php if (has_post_thumbnail($post_id)): ?>
					<?php
					$link_bg_image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
					$link_bg_image = $link_bg_image[0];
					?>
					<div class="entry-quote-bg" style="background-image: url('<?php echo esc_url($link_bg_image); ?>')"></div>
				<?php endif; ?>
				<div class="entry-quote-content">
					<div class="block-center">
						<div class="block-center-inner">
							<i class="fa fa-link"></i>
							<a target="_blank" href="<?php echo esc_url($link_url !== '' ? $link_url : '#')?>" title="<?php echo esc_attr($link_text)?>"><?php echo esc_html($link_text) ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

<?php if ($hasThumb === false): ?>
	<?php if (has_post_thumbnail($post_id)): ?>
		<?php $hasThumb = true; ?>
        <?php if ($image_size === 'blog-large') $image_size = 'full'; ?>
		<?php g5Theme()->blog()->render_post_image_markup(array(
			'post_id' => $post_id,
			'image_id' => get_post_thumbnail_id($post_id),
			'image_size' => $image_size,
			'gallery_id' => $gallery_id,
			'display_permalink' => $display_permalink,
			'image_mode' => $image_mode
		)); ?>
	<?php elseif ($placeholder_enable === true): ?>
		<?php $hasThumb = true;?>
		<div class="entry-thumbnail">
			<div class="entry-thumbnail-overlay thumbnail-size-<?php echo esc_attr($image_size); ?> placeholder-image">
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php $thumbnail_markup = ob_get_clean(); ?>
<?php if ($hasThumb === true): ?>
	<?php
	$wrapper_classes = array(
		'entry-thumb-wrap',
		"entry-thumb-mode-{$image_mode}",
		"entry-thumb-format-" . get_post_format()
	);
	if ($is_single) {
		$wrapper_classes[] = 'entry-thumb-single';
	}

	$wrapper_class = implode(' ', $wrapper_classes);
	?>
	<div class="<?php echo esc_attr($wrapper_class);?>">
		<?php echo ($thumbnail_markup); ?>
		<?php
		do_action('g5plus_after_post_thumbnail',array('image_size' => $image_size))
		?>
	</div>
<?php endif; ?>

