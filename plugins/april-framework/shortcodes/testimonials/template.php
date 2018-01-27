<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $columns_gutter
 * @var $image
 * @var $tes_style
 * @var $values
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Testimonials
 */

$layout_style = $columns_gutter = $image = $tes_style = $values = $dots = $nav = $nav_position = $nav_style = $autoplay = $autoplay_timeout =
$columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'gsf-testimonials',
    'owl-carousel owl-theme',
    'testimonials-' . $layout_style,
    'clearfix',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);
if($layout_style == 'style-03') {
    $wrapper_classes[] = $tes_style;
}

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}

$columns = intval($columns);
$columns_gutter = intval($columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$owl_attributes = '';
if('style-01' === $layout_style) {
    $owl_attributes = array(
        'items' => $columns,
        'margin' => $columns_gutter,
        'dots' => ($dots === 'on') ? true : false,
        'nav' => ($nav === 'on') ? true : false,
        'autoHeight' => true,
        'autoplay' => ($autoplay === 'on') ? true : false,
        'autoplayTimeout' => $autoplay_timeout,
        'responsive' => array(
            '1200' => array(
                'items' => $columns,
                'margin' => $columns == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns,
            ),
            '992' => array(
                'items' => $columns_md,
                'margin' => $columns_md == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_md,
            ),
            '768' => array(
                'items' => $columns_sm,
                'margin' => $columns_sm == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_sm,
            ),
            '600' => array(
                'items' => $columns_xs,
                'margin' => $columns_xs == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_xs,
            ),
            '0' => array(
                'items' => $columns_mb,
                'margin' => $columns_mb == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_mb,
            )
        )
    );
} else {
    $owl_attributes = array(
        'items' => 1,
        'margin' => 0,
        'dots' => ($dots === 'on') ? true : false,
        'nav' => ($nav === 'on') ? true : false,
        'autoHeight' => true,
        'autoplay' => ($autoplay === 'on') ? true : false,
        'autoplayTimeout' => $autoplay_timeout,
    );
}

if($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
    $owl_attributes['navText'] = array('<i class="fa fa-angle-left"></i> <span>'.esc_html__( 'Prev', 'april-framework' ).'</span>', '<span>'.esc_html__( 'Next', 'april-framework' ).'</span> <i class="fa fa-angle-right"></i>');
}

if($nav === 'on') {
    $wrapper_classes[] = ' ' . $nav_position. ' ' . $nav_style;
}

if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
    wp_enqueue_style(G5P()->assetsHandle('g5-testimonials'), G5P()->helper()->getAssetUrl('shortcodes/testimonials/assets/css/testimonials.min.css'), array(), G5P()->pluginVer());
}

$class_to_filter = implode(' ', $wrapper_classes);
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>" data-owl-options='<?php echo json_encode($owl_attributes); ?>'>
    <?php
    $values = (array)vc_param_group_parse_atts($values);
    $index = 0;
    ?>
    <?php foreach ($values as $value):
        $index++;
        $name = isset($value['author_name']) ? $value['author_name'] : '';
        $job = isset($value['author_job']) ? $value['author_job'] : '';
        $bio = isset($value['author_bio']) ? $value['author_bio'] : '';
        $url = isset($value['author_link']) ? $value['author_link'] : '';
        $avatar = isset($value['author_avatar']) ? $value['author_avatar'] : '';
        $image_src = '';
        if (!empty($avatar)) {
            $image_src = wpb_resize($avatar, null, 80, 80, true);
            if (sizeof($image_src) > 0 && !empty($image_src)) {
                $image_src = $image_src['url'];
            }
        }
        ?>
        <?php G5P()->helper()->getTemplate('shortcodes/testimonials/templates/' . $layout_style, array('name'=>$name, 'job' => $job, 'bio' => $bio, 'image_src' => $image_src, 'url' => $url, 'image' => $image,'index'=>$index)); ?>
    <?php endforeach; ?>
</div>
