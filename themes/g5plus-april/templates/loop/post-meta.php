<?php
/**
 * The template for displaying post-meta
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
global $cat_badge;
?>
<ul class="gf-post-meta gf-inline">
    <?php g5Theme()->templates()->post_view(); ?>
    <?php g5Theme()->templates()->post_like(); ?>
	<li class="meta-date">
		<i class="ion-ios-calendar-outline"></i> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"> <?php echo  get_the_date(get_option('date_format'));?> </a>
	</li>
	<?php edit_post_link(esc_html__( 'Edit', 'g5plus-april' ), '<li class="edit-link"><i class="fa fa-pencil"></i> ', '</li>' ); ?>
</ul>
<?php $cat_badge = false; ?>

