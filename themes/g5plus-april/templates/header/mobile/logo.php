<?php
/**
 * The template for displaying logo.php
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */

$logo_retina = g5Theme()->options()->get_logo_retina();
$logo_retina = isset($logo_retina['url']) ? $logo_retina['url'] : '';

$mobile_logo = g5Theme()->options()->get_mobile_logo();
$mobile_logo = isset($mobile_logo['url']) ? $mobile_logo['url'] : $mobile_logo;

$mobile_logo_retina = g5Theme()->options()->get_mobile_logo_retina();
$mobile_logo_retina = isset($mobile_logo_retina['url']) ? $mobile_logo_retina['url'] : $logo_retina;

$logo_title = esc_attr(get_bloginfo('name', 'display')) . '-' . get_bloginfo('description', 'display');
$logo_text = get_bloginfo('name', 'display');

$logo_attributes = array();
if ($mobile_logo_retina && ($mobile_logo_retina != $mobile_logo)) {
	$logo_attributes[] = 'data-retina="' . esc_url($mobile_logo_retina) . '"';
}
?>
<div class="mobile-logo-header">
	<a class="gsf-link" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
		<?php if (!empty($mobile_logo)): ?>
			<img <?php echo implode(' ', $logo_attributes); ?> src="<?php echo esc_url($mobile_logo) ?>" alt="<?php echo esc_attr($logo_title) ?>">
		<?php else: ?>
			<h2 class="logo-text"><?php echo esc_html($logo_text); ?></h2>
		<?php endif; ?>
	</a>
</div>


