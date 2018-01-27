<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $partners
 * @var $items
 * @var $columns_gutter
 * @var $opacity
 * @var $items_md
 * @var $items_sm
 * @var $items_xs
 * @var $items_mb
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Partner_Carousel
 */
$partners = $items = $columns_gutter = $opacity = $items_md = $items_sm = $items_xs = $items_mb =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_attributes = array();
$wrapper_styles = array();

$wrapper_classes = array(
	'gsf-partner',
	'owl-carousel',
	'clearfix',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}

if ($items_md == -1) {
	$items_md = 4;
}

if ($items_sm == -1) {
	$items_sm = 3;
}

if ($items_xs == -1) {
	$items_xs = 2;
}

if ($items_mb == -1) {
	$items_mb = 1;
}

if(intval($opacity) <0 || intval($opacity) > 100) {
    $opacity = 100;
}

$owl_attributes = array(
    'items' => intval($items),
	'autoHeight' => true,
	'loop' => false,
	'margin' => intval($columns_gutter),
	'responsive' => array(
	    '0' => array(
	        'items' => intval($items_mb)
        ),
        '600' => array(
            'items' => intval($items_xs)
        ),
        '768' => array(
            'items' => intval($items_sm)
        ),
        '992' => array(
            'items' => intval($items_md)
        ),
        '1200' => array(
            'items' => intval($items)
        )
    )
);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

if (!(defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
    wp_enqueue_style(G5P()->assetsHandle('partner-carousel'), G5P()->helper()->getAssetUrl('shortcodes/partner-carousel/assets/css/partner-carousel.min.css'), array(), G5P()->pluginVer());
}
?>

<div class="<?php echo esc_attr($css_class) ?>" data-owl-options='<?php echo json_encode( $owl_attributes );?>'>
	<?php
	$values = (array)vc_param_group_parse_atts($partners);
	foreach ($values as $data) {
		$partner_img = isset($data['image']) ? $data['image'] : '';
        $partner_img = wp_get_attachment_image_src($partner_img, 'full');
        if(!empty($partner_img)) {
            $partner_img = $partner_img[0];
        }
		$link = isset($data['link']) ? $data['link'] : '';
		$link = ($link == '||') ? '' : $link;
		$link_arr = vc_build_link($link);
		$a_title = '';
		$a_target = '_blank';
		$a_href = '#';
		$use_link = false;
		if (strlen($link_arr['url']) > 0) {
            $use_link = true;
			$a_href = $link_arr['url'];
			$a_title = $link_arr['title'];
			$a_target = strlen($link_arr['target']) > 0 ? $link_arr['target'] : '_blank';
		}
		?>
		<div class='partner-item' style="opacity: <?php echo esc_attr($opacity / 100) ?>">
			<?php if ($use_link): ?>
			    <a title="<?php echo esc_attr($a_title); ?>" target="<?php echo trim(esc_attr($a_target)); ?>"
			   href="<?php echo esc_url($a_href) ?>">
            <?php endif; ?>
				<img src="<?php echo esc_url($partner_img) ?>" alt="<?php echo esc_attr($a_title); ?>">
            <?php if ($use_link): ?>
                </a>
            <?php endif; ?>
		</div>
	<?php
	}
	?>
</div>