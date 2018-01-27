<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $link
 * @var $icon_bg_color
 * @var $icon_color
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Video
 */

$link = $icon_bg_color = $icon_color = $css_animation = $animation_duration =
$animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

if(empty($link)) {
    return;
}
$wrapper_classes = array(
    'gf-video',
    'text-center',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}
if(empty($icon_bg_color)) {
    $icon_bg_color = '#f76b6a';
}
if(empty($icon_color)) {
    $icon_color = '#fff';
}
$video_class = 'gf-video-'.random_int( 1000, 9999 );
$video_css = <<<CSS
	.{$video_class} .view-video {
		background-color: {$icon_bg_color};
		border: 2px solid {$icon_bg_color};
	}
	.{$video_class} .view-video:hover,
	.{$video_class} .view-video:focus {
	    background-color: transparent;
	}
	.{$video_class} .view-video i {
	    color: {$icon_color};
	}
	.{$video_class} .view-video:hover i,
	.{$video_class} .view-video:focus i {
	    color: {$icon_bg_color};
	}
CSS;
GSF()->customCss()->addCss($video_css);

$wrapper_classes[] = $video_class;

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
	wp_enqueue_style(G5P()->assetsHandle('g5-video'), G5P()->helper()->getAssetUrl('shortcodes/video/assets/css/video.min.css'), array(), G5P()->pluginVer());
}

$args = array(
    'type' => 'iframe',
    'mainClass' => 'mfp-fade'
);
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<a data-magnific="true" data-magnific-options='<?php echo json_encode($args) ?>' href="<?php echo esc_url($link) ?>" class="view-video">
        <i class="fa fa-play"></i>
	</a>
</div>

