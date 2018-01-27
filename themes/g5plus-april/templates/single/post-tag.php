<?php
/**
 * The template for displaying post-tag.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$single_tag_enable = g5Theme()->options()->get_single_tag_enable();
$single_share_enable = g5Theme()->options()->get_single_share_enable();
if ($single_tag_enable !== 'on') return;
?>
<?php if ($single_share_enable === 'on'): ?>
    <div class="gf-post-single-inline">
<?php endif; ?>
<div class="gf-post-meta-tag">
	<?php the_tags('<i class="ion-ios-pricetags disable-color"></i> <div class="tagcloud disable-color">',', ','</div>'); ?>
</div>
