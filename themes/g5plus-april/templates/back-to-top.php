<?php
/**
 * The template for displaying back-to-top
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$back_to_top = g5Theme()->options()->get_back_to_top();
if ($back_to_top !== 'on') return;
?>
<a class="back-to-top" href="javascript:;">
	<i class="fa fa-angle-up"></i>
</a>
