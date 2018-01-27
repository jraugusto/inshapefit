<?php
/**
 * The template for displaying search.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$mobile_header_search_enable = g5Theme()->options()->get_mobile_header_search_enable();
if ($mobile_header_search_enable !== 'on') return;
?>
<div class="mobile-header-search">
	<div class="container">
		<?php get_search_form(); ?>
	</div>
</div>
