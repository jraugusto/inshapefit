<?php
/**
 * The template for displaying single-xxx.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$options = &GSF()->adminThemeOption()->getOptions(G5P()->getOptionName());
$options['sidebar_layout'] = 'none';
$options['content_padding'] = array('left' => '', 'right' => '','top' => '50', 'bottom' => '50');
$options['content_full_width'] = 'on';
$options['header_float_enable'] = '';
//$options['header_skin'] = '';
//$options['navigation_skin'] = '';
get_header();
	while (have_posts()) : the_post();?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
			<div class="gf-entry-content clearfix">
				<?php the_content(); ?>
			</div>
		</article>
	<?php
	endwhile;
get_footer();