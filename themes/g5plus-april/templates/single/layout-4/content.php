<?php
/**
 * The template for displaying content-single.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
?>
<div class="gf-single-wrap clearfix">
	<article id="post-<?php the_ID(); ?>" <?php post_class('post-single clearfix'); ?>>
		<div class="gf-entry-meta-top">
            <div class="gf-post-cat-meta">
                <?php echo get_the_category_list(', '); ?>
            </div>
			<?php g5Theme()->helper()->getTemplate('single/post-title') ?>
			<?php g5Theme()->helper()->getTemplate('single/post-meta') ?>
		</div>
		<div class="gf-post-content">
			<div class="gf-entry-content clearfix">
				<?php
				the_content();
				wp_link_pages(array(
					'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:','g5plus-april') . '</span>',
					'after' => '</div>',
					'link_before' => '<span class="page-link">',
					'link_after' => '</span>',
				));
				?>
			</div>
		</div>
	</article>
	<?php
	/**
	 * @hooked - post_single_tag - 5
	 * @hooked - post_single_share - 10
	 * @hooked - post_single_navigation - 15
	 * @hooked - post_single_author_info - 20
	 * @hooked - post_single_related - 25
	 * @hooked - post_single_comment - 30
	 *
	 **/
	do_action('g5plus_after_single_post')
	?>
</div>
