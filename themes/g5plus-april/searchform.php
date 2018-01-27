<?php
/**
 * Template for displaying search forms in april
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) )  ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'g5plus-april' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
	<button type="submit" class="search-submit"><?php echo esc_attr_x( 'Search', 'submit button','g5plus-april' ) ?> <i class="ion-ios-search-strong"></i></button>
</form>
