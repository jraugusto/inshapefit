<?php
/**
 * The template for displaying footer
 */
$footer_enable = g5Theme()->options()->get_footer_enable();
if ($footer_enable !== 'on') return;
$footer_fixed_enable = g5Theme()->options()->get_footer_fixed_enable();
$wrapper_classes = array(
	'main-footer-wrapper'
);

if ($footer_fixed_enable === 'on') {
	$wrapper_classes[] = 'footer-fixed';
}
$content_block = g5Theme()->options()->get_footer_content_block();
$content_block = g5Theme()->helper()->content_block($content_block);
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<footer class="<?php echo esc_attr($wrapper_class); ?>">
    <?php if (!empty($content_block)) : ?>
        <?php printf('%s', $content_block); ?>
    <?php else: ?>
        <div class="gf-content-block-none dark text-center">
            <?php printf(wp_kses_post(__('Please specify the <b>Content Block</b> to use as a footer content in <a title="Theme Options" href="%s">Theme Options</a>', 'g5plus-april')), g5Theme()->helper()->get_theme_options_url()); ?>
        </div>
    <?php endif; ?>
</footer>
