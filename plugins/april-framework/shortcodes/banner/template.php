<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $hover_effect
 * @var $image
 * @var $link
 * @var $title_size
 * @var $text_color
 * @var $text_bg_color
 * @var $content
 * @var $height_mode
 * @var $height
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Banner
 */

$layout_style = $hover_effect = $image = $link = $title_size = $text_color = $text_bg_color = $height_mode = $height =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$image_src = '';
$image_arr = wp_get_attachment_image_src( $image, 'full' );
if ( sizeof( $image_arr ) > 0 && ! empty( $image_arr[0] ) ) {
    $image_src = $image_arr[0];
}
if(empty( $image ) || empty($image_src)) return;
$wrapper_classes = array(
	'gf-banner',
	$hover_effect,
	'gf-banner-' . $layout_style,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if($layout_style === 'style-01') {
    $wrapper_classes[] = $title_size;
}
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$banner_bg_class = array('gf-banner-bg');

$link_attributes = $title_attributes = array();
$link = ( '||' === $link ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
$title = '';
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$link_attributes[] = 'href="' . esc_url( trim($link['url']) ) . '"';
	if(strlen($link['target']) >0) {
		$link_attributes[] = 'target="' . trim($link['target']) . '"';
	}
	if(strlen($link['rel']) >0) {
		$link_attributes[] = 'rel="' . trim($link['rel']) . '"';
	}
	if(strlen($link['title']) >0) {
		$link_attributes[] = 'title="' . trim($link['title']) . '"';
		if(empty($title)) {
			$title = trim($link['title']);
		}
	} elseif (!empty( $title )) {
		$link_attributes[] = 'title="' . trim($title) . '"';
	}
	if(empty($title)) {
		$wrapper_classes[] = 'gf_banner_link';
	}
}

$banner_class = 'gf-banner-'.random_int( 1000, 9999 );
$text_color = empty($text_color) ? '#333' : $text_color;
$text_bg_color = empty($text_bg_color) ? '#fff' : $text_bg_color;
$banner_css = '';
if($layout_style == 'style-02') {
    $banner_css = <<<CSS
        .{$banner_class} + .gf-banner-inner h5 {
            background-color: {$text_bg_color} !important;
            color: {$text_color} !important;
        }
CSS;
}
GSF()->customCss()->addCss($banner_css);

$banner_bg_css = '';
$img_width = $img_height = '';
list($img_width, $img_height) = getimagesize($image_src);
if ($height_mode != 'custom') {
    if ($height_mode === 'original') {
        $height_mode = ($img_height / $img_width) * 100;
    }
    $banner_bg_css = <<<CSS
    .{$banner_class} {
        background-image: url('{$image_src}');
        padding-bottom: {$height_mode}%;
    }
CSS;
} else {

    $banner_bg_css = <<<CSS
    .{$banner_class} {
        background-image: url('{$image_src}');
        height: {$height};
    }
CSS;
}
GSF()->customCss()->addCss($banner_bg_css);
if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
	wp_enqueue_style(G5P()->assetsHandle('g5-banner'), G5P()->helper()->getAssetUrl('shortcodes/banner/assets/css/banner.min.css'), array(), G5P()->pluginVer());
}
$banner_bg_class[] = $banner_class;
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if($layout_style !== 'style-03'): ?>
        <div class="effect-bg-image <?php echo join(' ', $banner_bg_class); ?>">
            <?php if((empty($title) || ($layout_style === 'style-04')) && $use_link): ?>
                <a <?php echo implode( ' ', $link_attributes ); ?>></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="gf-banner-inner <?php echo ($layout_style !== 'style-03') ? 'effect-content' : ''; ?>">
        <?php if (!empty($title)): ?>
            <div class="gf-banner-content">
                <?php if($layout_style == 'style-01'): ?>
                    <?php if($use_link): ?>
                        <a <?php echo implode( ' ', $link_attributes ); ?>>
                    <?php endif; ?>
                        <h4><?php echo esc_html($title); ?></h4>
                    <?php if($use_link): ?>
                        </a>
                    <?php endif; ?>
                <?php elseif ($layout_style == 'style-02'): ?>
                    <div class="banner-title-top">
                        <h5><?php echo esc_html($title); ?></h5>
                    </div>
                    <div class="banner-action text-center">
                        <?php if($use_link): ?>
                            <a <?php echo implode( ' ', $link_attributes ); ?> class="btn btn-link-md btn-black"><?php esc_html_e('shop now', 'april-framework'); ?></a>
                        <?php else: ?>
                            <button class="btn btn-link-md btn-black"><?php esc_html_e('shop now', 'april-framework'); ?></button>
                        <?php endif; ?>
                    </div>
                <?php elseif ($layout_style == 'style-03'): ?>
                    <h5 style="color: <?php echo esc_attr($text_color);?>"><?php echo esc_html($title); ?></h5>
                <?php elseif ($layout_style == 'style-04' && !empty($content)): ?>
                    <?php echo wpb_js_remove_wpautop( $content, true ); ?>
                 <?php endif; ?>
            </div>
        <?php elseif ($layout_style == 'style-04' && !empty($content)): ?>
            <div class="gf-banner-content">
                <?php echo wpb_js_remove_wpautop( $content, true ); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if($layout_style === 'style-03'): ?>
        <div class="effect-bg-image <?php echo join(' ', $banner_bg_class); ?> effect-content">
            <a <?php echo implode( ' ', $link_attributes ); ?>></a>
        </div>
    <?php endif; ?>
</div>