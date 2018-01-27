<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $use_skin_border_color
 * @var $border_color
 * @var $border_height
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Border
 */
$use_skin_border_color = $border_color = $border_height = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-border-container',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$border_class = 'gsf-border-' . random_int(1000, 9999);
if(intval($border_height) <= 0) {
    $border_height = 1;
}
$border_css = <<<CSS
	.{$border_class} {
		height: {$border_height}px;
	}
CSS;
if('on' !== $use_skin_border_color) {
	$border_css .= <<<CSS
	.{$border_class} {
		background-color: {$border_color} !important;
	}
CSS;
}

GSF()->customCss()->addCss($border_css);
$wrapper_classes[] = $border_class;
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
</div>