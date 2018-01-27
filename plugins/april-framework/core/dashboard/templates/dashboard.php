<?php
/**
 * The template for displaying dashboard
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 * @var $current_page
 */
$pages_settings = G5P()->core()->dashboard()->getConfigPages();
$current_theme = wp_get_theme();
?>
<div class="gsf-dashboard wrap">
	<h2 class="screen-reader-text"><?php printf(esc_html__('%s Dashboard', 'april-framework'), $current_theme['Name']) ?></h2>
	<div class="gsf-message-box">
		<h1 class="welcome"><?php esc_html_e('Welcome to', 'april-framework') ?> <span
				class="gsf-theme-name"><?php echo esc_html($current_theme['Name']) ?></span> <span
				class="gsf-theme-version">v<?php echo esc_html($current_theme['Version']) ?></span></h1>
		<p class="about"><?php printf(esc_html__('%s is now installed and ready to use! Get ready to build something beautiful. Read below for additional information. We hope you enjoy it!', 'april-framework'), $current_theme['Name']); ?></p>
	</div>
	<div class="gsf-dashboard-tab-wrapper">
		<ul class="gsf-dashboard-tab">
			<?php foreach ($pages_settings as $key => $value): ?>
				<?php
					$href = isset($value['link']) ? $value['link'] :  admin_url("admin.php?page=gsf_{$key}");
				?>
				<li class="<?php echo esc_attr(($current_page === $key) ? 'active' : '') ?>">
					<a href="<?php echo esc_url($href) ?>"><?php echo esc_html($value['menu_title']) ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="gsf-dashboard-content">
			<?php G5P()->helper()->getTemplate("core/dashboard/templates/{$current_page}") ?>
	</div>
</div>

