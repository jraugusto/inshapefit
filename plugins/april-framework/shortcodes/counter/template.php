<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $end
 * @var $start
 * @var $decimals
 * @var $duration
 * @var $separator
 * @var $decimal
 * @var $prefix
 * @var $suffix
 * @var $value_color
 * @var $use_theme_fonts
 * @var $typography
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Counter
 */
$title = $end = $start = $decimals = $duration = $separator = $decimal = $prefix = $suffix = $value_color = $use_theme_fonts = $typography =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-counter',
	'text-center',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
//animation
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}


if(empty($value_color)) $value_color = '#f76b6a';

$ct_custom_class = 'gf-counter-' . uniqid();
$ct_css = <<<CSS
    .{$ct_custom_class} .counter-value {
        color: {$value_color} !important;
    }
CSS;
if('on' !== $use_theme_fonts) {
    if(empty($typography)) {
        $font = GSF()->core()->fonts()->getActiveFonts()[0];
        $font_family = $font_variant = $font_weight = $font_style = '';
        $font_family = isset($font['name']) ? $font['name'] : $font['family'];
        $font_variant = isset($font['variants'][0]) ? $font['variants'][0] : '400';
        if(strpos($font_variant, 'i') && strpos($font_variant, 'i') != -1) {
            $font_style = 'italic';
            $font_weight = substr($font_variant, 0, strpos($font_variant, 'i'));
            if(!$font_weight || '' == $font_weight) {
                $font_weight = '400';
            }
        } else {
            $font_style = 'normal';
            if($font_variant == 'regular') {
                $font_weight = '400';
            } else {
                $font_weight = $font_variant;
            }
        }
        $typography = array($font_family, $font_variant, $font_weight, $font_style);
    } else {
        $typography = explode('|', $typography);
    }
    $ct_css .= <<<CSS
        .{$ct_custom_class} .counter-value {
            font-family: {$typography[0]} !important;
            font-weight: {$typography[2]} !important;
            font-style: {$typography[3]} !important;
        }
CSS;
}

GSF()->customCss()->addCss($ct_css);
$wrapper_classes[] = $ct_custom_class;

//enqueue class
if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
	wp_enqueue_style(G5P()->assetsHandle('g5-counter'), G5P()->helper()->getAssetUrl('shortcodes/counter/assets/css/counter.min.css'), array(), G5P()->pluginVer());
}
wp_enqueue_script(G5P()->assetsHandle('counter'), G5P()->helper()->getAssetUrl('shortcodes/counter/assets/js/countUp.min.js'), array('jquery'), G5P()->pluginVer(), true);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>

<div class="<?php echo esc_attr($css_class)?>">
	<div class="ct-content">
		<?php if (!empty($end)): ?>
			<h4 class="counterup counter-value fs-40 mg-bottom-0 mg-top-0" data-start="<?php echo esc_attr($start) ?>"
				  data-end="<?php echo esc_attr($end) ?>" data-decimals="<?php echo esc_attr($decimals) ?>"
				  data-duration="<?php echo esc_attr($duration) ?>" data-separator="<?php echo esc_attr($separator) ?>"
				  data-decimal="<?php echo esc_attr($decimal) ?>" data-prefix="<?php echo esc_attr($prefix) ?>"
				  data-suffix="<?php echo wp_kses_post($suffix) ?>"><?php echo wp_kses_post($end) ?><span class="fs-24"><?php echo wp_kses_post($suffix) ?></span></h4>
		<?php endif; ?>
		<?php if ($title != ''): ?>
			<span class="mg-bottom-0 counter-title fs-14 fw-bold heading-color"><?php echo wp_kses_post($title) ?></span>
		<?php endif;?>
	</div>
</div>