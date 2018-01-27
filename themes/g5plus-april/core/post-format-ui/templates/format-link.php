<?php
/**
 * The template for displaying format-link
 */
global $post;
?>
<div class="gf-form-group">
	<label for="<?php echo esc_attr(gfPostFormatUi()->get_format_link_text()) ?>"><?php esc_html_e('Text','g5plus-april'); ?></label>
	<input class="gf-form-control" type="text" placeholder="<?php esc_attr_e('Text','g5plus-april'); ?>" name="<?php echo esc_attr(gfPostFormatUi()->get_format_link_text()) ?>" value="<?php echo esc_attr(get_post_meta($post->ID, gfPostFormatUi()->get_format_link_text(), true)); ?>" id="<?php echo esc_attr(gfPostFormatUi()->get_format_link_text()) ?>" tabindex="1" />
</div>
<div class="gf-form-group">
	<label for="<?php echo esc_attr(gfPostFormatUi()->get_format_link_url()) ?>"><?php esc_html_e('Url','g5plus-april'); ?></label>
	<input class="gf-form-control" type="text" placeholder="<?php esc_attr_e('Url','g5plus-april'); ?>" name="<?php echo esc_attr(gfPostFormatUi()->get_format_link_url()) ?>" value="<?php echo esc_attr(get_post_meta($post->ID, gfPostFormatUi()->get_format_link_url(), true)); ?>" id="<?php echo esc_attr(gfPostFormatUi()->get_format_link_url()) ?>" tabindex="2" />
</div>
