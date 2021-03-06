<?php
/**
 * The template for displaying format-quote.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
global $post;
?>
<div class="gf-form-group">
	<label for="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_content()) ?>"><?php esc_html_e('Quote Content','g5plus-april'); ?></label>
	<textarea rows="5" placeholder="<?php esc_attr_e('Quote Content','g5plus-april'); ?>" class="gf-form-control" name="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_content()) ?>" id="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_content()) ?>" tabindex="1"><?php echo esc_textarea(get_post_meta($post->ID, gfPostFormatUi()->get_format_quote_content(), true)); ?></textarea>
</div>
<div class="gf-form-group">
	<label for="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_author_text()) ?>"><?php esc_html_e('Author Name','g5plus-april'); ?></label>
	<input class="gf-form-control" type="text" placeholder="<?php esc_attr_e('Author Name','g5plus-april'); ?>" name="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_author_text()) ?>" value="<?php echo esc_attr(get_post_meta($post->ID, gfPostFormatUi()->get_format_quote_author_text(), true)); ?>" id="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_author_text()) ?>" tabindex="2" />
</div>
<div class="gf-form-group">
	<label for="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_author_url()) ?>"><?php esc_html_e('Author Url','g5plus-april'); ?></label>
	<input class="gf-form-control" type="text" placeholder="<?php esc_attr_e('Author Url','g5plus-april'); ?>" name="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_author_url()) ?>" value="<?php echo esc_attr(get_post_meta($post->ID, gfPostFormatUi()->get_format_quote_author_url(), true)); ?>" id="<?php echo esc_attr(gfPostFormatUi()->get_format_quote_author_url()) ?>" tabindex="3" />
</div>