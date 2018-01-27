<?php
/**
 * The template for displaying post-share.php
 */
$single_share_enable = g5Theme()->options()->get_single_share_enable();
$single_tag_enable = g5Theme()->options()->get_single_tag_enable();
if ($single_share_enable !== 'on') return;
do_action('g5plus_single_post_share');
if($single_tag_enable === 'on') {
    echo '</div>';
}