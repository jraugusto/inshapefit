<?php
/**
 * The template for displaying support
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$features = G5P()->core()->dashboard()->support()->getFeatures();
?>
<div class="gsf-message-box">
	<h4 class="gsf-heading"><?php esc_html_e('Out standing 5 star support', 'april-framework') ?></h4>
	<p><?php esc_html_e('We care our product because know it needs support it\'s the reason why our customers are top priority and we do all presure to fix all issues. Our team is working hardly to help every customer, fix issues, keep documentation up to date, create new demos and develop new tools to make it more easily and powerful.', 'april-framework') ?></p>
</div>
<div class="gsf-feature-section clearfix">
	<?php foreach($features as $feature): ?>
		<div class="gsf-feature-box">
			<div class="gsf-box">
				<div class="gsf-box-head">
					<?php if (isset($feature['icon']) && !empty($feature['icon'])): ?>
						<i class="<?php echo esc_attr($feature['icon']) ?>"></i>
					<?php endif; ?>
					<span><?php echo esc_html($feature['label'])?></span>
				</div>
				<div class="gsf-box-body">
					<?php echo esc_html($feature['description']); ?>
				</div>
				<div class="gsf-box-footer">
					<a href="<?php echo esc_url($feature['button_url']) ?>" class="button button-large button-primary" target="_blank"><?php echo esc_html($feature['button_text'])?></a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>