<?php
/**
 * The template for displaying head-meta
 *
 * @package WordPress
 * @subpackage april
 * @since april 1.0
 */
$viewport_content = apply_filters('g5plus_viewport_content','width=device-width, initial-scale=1, maximum-scale=1');
$favicon = '';
if (is_readable(g5Theme()->themeDir('assets/images/favicon.ico'))) {
    $favicon = g5Theme()->themeUrl('assets/images/favicon.ico');
}
$custom_favicon = g5Theme()->options()->get_custom_favicon();
if (isset($custom_favicon['url']) && !empty($custom_favicon['url'])) {
	$favicon = $custom_favicon['url'];
}
$custom_ios_icon144 = g5Theme()->options()->get_custom_ios_icon144();
$custom_ios_icon114 = g5Theme()->options()->get_custom_ios_icon114();
$custom_ios_icon72 = g5Theme()->options()->get_custom_ios_icon72();
$custom_ios_icon57 = g5Theme()->options()->get_custom_ios_icon57();
$custom_ios_title = g5Theme()->options()->get_custom_ios_title();
?>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="viewport" content="<?php echo esc_attr($viewport_content);?>">

<?php if (!empty($custom_ios_title)) : ?>
	<meta name="apple-mobile-web-app-title" content="<?php echo esc_attr($custom_ios_title); ?>">
<?php endif; ?>

<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
<?php endif;?>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<?php if ((!function_exists('has_site_icon') || ! has_site_icon()) && !empty($favicon))  : ?>
	<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" />
<?php endif; ?>


<?php if (isset($custom_ios_icon144['url']) && !empty($custom_ios_icon144['url'])) :?>
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url($custom_ios_icon144['url']); ?>">
<?php endif;?>

<?php if (isset($custom_ios_icon114['url']) && !empty($custom_ios_icon114['url'])) :?>
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($custom_ios_icon114['url']); ?>">
<?php endif;?>

<?php if (isset($custom_ios_icon72['url']) && !empty($custom_ios_icon72['url'])) :?>
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($custom_ios_icon72['url']); ?>">
<?php endif;?>

<?php if (isset($custom_ios_icon57['url']) && !empty($custom_ios_icon57['url'])) :?>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url($custom_ios_icon57['url']); ?>">
<?php endif;?>
