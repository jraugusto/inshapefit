<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $thumb_shape
 * @var $image
 * @var $ourteam_name
 * @var $ourteam_position
 * @var $link
 * @var $socials
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Our_Team
 */
$thumb_shape = $image = $ourteam_name = $ourteam_position = $link = $socials = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$socials = (array)vc_param_group_parse_atts($socials);

$wrapper_classes = array(
    'gsf-our-team',
    'text-center',
    'clearfix',
    $thumb_shape,
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}

// get image src
if (!empty($image)) {
    $image_id = preg_replace('/[^\d]/', '', $image);
    $width = 405; $height = 435;
    if('thumb-circle' === $thumb_shape) {
        $height = 405;
    }
    $image_full = wpb_resize($image_id, null, $width, $height, true);
    $image_src = '';
    if (sizeof($image_full) > 0) {
        $image_src = $image_full['url'];
    }
}

//parse link
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$use_link = false;
if (strlen($link['url']) > 0) {
    $use_link = true;
    $a_href = $link['url'];
    $a_title = $link['title'];
    $a_target = $link['target'];
} else {
    $a_href = '#';
}
if (empty($a_target)) {
    $a_target = '_self';
}

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
    wp_enqueue_style(G5P()->assetsHandle('gf-our-team'), G5P()->helper()->getAssetUrl('shortcodes/our-team/assets/css/our-team.min.css'), array(), G5P()->pluginVer());
}
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if (!empty($image_src)): ?>
        <div class="ourteam-thumb">
            <?php if($use_link): ?>
                <a title="<?php echo esc_attr($ourteam_name); ?>" target="<?php echo esc_attr($a_target) ?>"
                   href="<?php echo esc_url($a_href); ?>"></a>
            <?php endif; ?>
            <div class="ourteam-thumb-inner">
                <img alt="<?php echo esc_attr($ourteam_name); ?>" src="<?php echo esc_url($image_src) ?>">
            </div>
        </div>
    <?php endif; ?>
    <div class="ourteam-content">
        <?php if (!empty($ourteam_name)): ?>
            <h5 class="ourteam-name">
                <?php if($use_link): ?>
                <a title="<?php echo esc_attr($ourteam_name); ?>" target="<?php echo esc_attr($a_target) ?>"
                        href="<?php echo esc_url($a_href); ?>"><?php echo esc_attr($ourteam_name); ?></a>
                <?php else: ?>
                    <?php echo esc_attr($ourteam_name); ?>
                <?php endif; ?>
            </h5>
        <?php endif;
        if (!empty($ourteam_position)): ?>
            <span class="ourteam-position"><?php echo wp_kses_post($ourteam_position); ?></span>
        <?php endif; ?>
        <?php if (!empty($socials)): ?>
            <div class="ourteam-socials">
                <?php G5P()->helper()->getTemplate('shortcodes/our-team/socials', array('socials'=>$socials)); ?>
            </div>
        <?php endif; ?>
    </div>
</div>