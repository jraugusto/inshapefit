<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $title
 * @var $title_font_size
 * @var $sub_title
 * @var $title_color
 * @var $sub_title_font_size
 * @var $text_align
 * @var $letter_spacing
 * @var $use_theme_fonts
 * @var $typography
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Heading
 */

$layout_style = $title = $title_color = $title_font_size = $sub_title = $sub_title_font_size = $text_align = $letter_spacing = $use_theme_fonts = $typography =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-heading',
	'gf-heading-'.$layout_style,
	$text_align,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

if($layout_style != 'style-03') {
    $sub_title = '';
}
if(empty($title_color)) {
    $title_color = '#333';
}
$heading_class = 'gf-heading-' . uniqid();
$heading_css = <<<CSS
.{$heading_class} .heading-sub-title {
font-size: {$sub_title_font_size}px;
line-height: {$title_font_size}px;
}
.{$heading_class} .heading-title {
font-size: {$title_font_size}px;
line-height: {$title_font_size}px;
letter-spacing: {$letter_spacing}em;
color: {$title_color};
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
    $heading_css .= <<<CSS
font-family: {$typography[0]};
font-weight: {$typography[2]};
font-style: {$typography[3]};
}
CSS;
} else {
    $font_weight = 800;
    if($layout_style == 'style-02') {
        $font_weight = 900;
    }
    $heading_css .= <<<CSS
        font-weight: {$font_weight};
        font-style: normal;
    }
CSS;
}
if($title_font_size > 34) {
    $heading_css .=<<<CSS
        @media (max-width: 599px) {
            .{$heading_class} .heading-title {
                font-size: 34px;
                line-height: 34px;
            }
        }
CSS;
}
GSF()->customCss()->addCss($heading_css);

if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
	wp_enqueue_style(G5P()->assetsHandle('g5-heading'), G5P()->helper()->getAssetUrl('shortcodes/heading/assets/css/heading.min.css'), array(), G5P()->pluginVer());
}

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<?php if(!empty( $title ) || !empty( $sub_title )): ?>
<div class="<?php echo esc_attr($css_class) ?>">
	<div class="gf-heading-inner <?php echo esc_attr( $heading_class ); ?>">
        <?php if (!empty($title)): ?>
            <h4 class="heading-title"><?php echo esc_html($title); ?></h4>
        <?php endif; ?>
        <?php if (!empty($sub_title)): ?>
            <span class="heading-sub-title"><?php echo esc_html($sub_title); ?></span>
        <?php endif; ?>
	</div>
</div>
<?php endif; ?>