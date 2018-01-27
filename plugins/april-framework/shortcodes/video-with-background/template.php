<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $video_url
 * @var $height_mode
 * @var $height
 * @var $image
 * @var $icon_bg_color
 * @var $icon_color
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Video_With_Background
 */

$video_url = $height_mode = $height = $image = $icon_bg_color = $icon_color =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

if(empty($video_url)) return;
$wrapper_classes = array(
    'gf-video-bg',
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
$video_class = 'gf-video-bg-'.uniqid();
$video_css = '';
$image_src = '';
if (!empty($image)) {
    $image_src = wp_get_attachment_image_src($image, 'full');
    if (sizeof($image_src) > 0 && !empty($image_src[0])) {
        $image_src = $image_src[0];
        $video_css = <<<CSS
            .{$video_class} {
                background-image: url('{$image_src}');
            }
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
    }
}

if('custom' === $height_mode) {
    if(empty($height)) {
        $height = '400px';
    }
    $video_css .= <<<CSS
        .{$video_class} {
            height: {$height};
            padding-bottom: 0;
        }
CSS;
} else {
    $video_css .= <<<CSS
        .{$video_class} {
            padding-bottom: {$height_mode}%;
        }
CSS;
}

GSF()->customCss()->addCss($video_css);
if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
    wp_enqueue_style(G5P()->assetsHandle('g5-video-bg'), G5P()->helper()->getAssetUrl('shortcodes/video-with-background/assets/css/video-with-background.min.css'), array(), G5P()->pluginVer());
}
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>" >
    <?php if (!empty($image)):
        $args = array(
            'type' => 'iframe',
            'mainClass' => 'mfp-fade'
        ); ?>
        <div class="gf-video-bg <?php echo esc_attr($video_class); ?>">
            <a data-magnific="true" data-magnific-options='<?php echo json_encode($args) ?>' href="<?php echo esc_url($video_url) ?>" class="view-video">
                <i class="fa fa-play"></i>
            </a>
        </div>
    <?php else: ?>
        <div class="embed-responsive embed-responsive-16by9 <?php echo esc_attr($video_class); ?>">
            <?php echo wp_oembed_get($video_url, array('wmode' => 'transparent')); ?>
        </div>
    <?php endif; ?>
</div>