<?php
/**
 * The template for displaying top-bar
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$top_bar_enable = g5Theme()->options()->get_mobile_top_bar_enable();
if ($top_bar_enable !== 'on') return;
$content_block = g5Theme()->options()->get_mobile_top_bar_content_block();
$content_block = g5Theme()->helper()->content_block($content_block);
?>
<div class="mobile-top-bar">
    <?php if (!empty($content_block)) {
        echo wp_kses_post($content_block);
    } else { ?>
        <div class="gf-content-block-none dark text-center">
            <?php printf(wp_kses_post(__('Please specify the <b>Content Block</b> to use as a top bar content in <a title="Theme Options" href="%s">Theme Options</a>', 'g5plus-april')), g5Theme()->helper()->get_theme_options_url()); ?>
        </div>
    <?php } ?>
</div>
