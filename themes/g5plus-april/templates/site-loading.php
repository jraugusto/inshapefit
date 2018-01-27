<?php
/**
 * The template for displaying site-loading.php
 */
$loading_animation = g5Theme()->options()->get_loading_animation();
if (empty($loading_animation)) return;
$logo_loading = g5Theme()->options()->get_loading_logo();
?>
<div class="site-loading">
	<div class="block-center">
		<div class="block-center-inner">
			<?php if (isset($logo_loading['url']) && !empty($logo_loading['url'])): ?>
				<img class="logo-loading" alt="<?php esc_html_e('Logo Loading','g5plus-april') ?>" src="<?php echo esc_url($logo_loading['url']) ?>" />
			<?php endif; ?>
			<?php g5Theme()->helper()->getTemplate("loading/{$loading_animation}") ?>
		</div>
	</div>
</div>
