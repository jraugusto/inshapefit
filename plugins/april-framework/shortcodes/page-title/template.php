<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $use_theme_fonts
 * @var $typography
 * @var $font_container
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Page_Title
 */
$use_theme_fonts = $font_container = $typography = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'page-title-container',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$attributes = $this->get_font_container_attributes($font_container);
$page_title_custom_css = array();
if (isset($attributes['font_size'])) {
    $page_title_custom_css[] = "font-size: {$attributes['font_size']} !important";
}

if (isset($attributes['color'])) {
    $page_title_custom_css[] = "color: {$attributes['color']} !important";
}

$heading_classes = array(
  'mg-top-0',
  'mg-bottom-10'
);
if (isset($attributes['text_align'])) {
    $heading_classes[] = $attributes['text_align'];
}
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

    $page_title_custom_css[] = "font-family: '{$typography[0]}' !important";
    $page_title_custom_css[] = "font-weight: {$typography[2]} !important";
    $page_title_custom_css[] = "font-style: {$typography[3]} !important";
}

$heading_class = implode(' ', array_filter($heading_classes));
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php $page_title = '';
	if(function_exists( 'g5Theme' )){
		$page_title = g5Theme()->helper()->get_page_title();
	}
	?>
    <h1 class="<?php echo esc_attr($heading_class) ?>" style="<?php echo implode(';',$page_title_custom_css) ?>"><?php echo esc_html($page_title); ?></h1>
</div>