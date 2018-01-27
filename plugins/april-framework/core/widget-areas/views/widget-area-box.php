<?php
/**
 * The template for displaying widget-area-box.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$nonce =  wp_create_nonce('gsf-delete-widget-area-nonce');
?>
<script type="text/html" id="gsf-add-widget-template">
	<div id="gsf-add-widget" class="widgets-holder-wrap">
		<input type="hidden" name="gsf-widget-areas-nonce" value="<?php echo esc_attr($nonce) ?>" />
		<div class="sidebar-name">
			<h3><?php esc_html_e('Create Widget Area', 'april-framework'); ?></h3>
		</div>
		<div class="sidebar-description">
			<form id="addWidgetAreaForm" action="" method="post">
				<div class="widget-content">
					<input id="gsf-add-widget-input" name="gsf-add-widget-input" type="text" class="regular-text" title="<?php echo esc_attr(esc_html__('Name','april-framework')); ?>" placeholder="<?php echo esc_attr(esc_html__('Name','april-framework')); ?>" />
				</div>
				<div class="widget-control-actions">
					<input class="addWidgetArea-button button-primary" type="submit" value="<?php echo esc_attr(esc_html__('Create Widget Area', 'april-framework')); ?>" />
				</div>
			</form>
		</div>
	</div>
</script>
