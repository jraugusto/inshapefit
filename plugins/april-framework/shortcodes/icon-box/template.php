<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $icon_bg_style
 * @var $icon_color
 * @var $icon_bg_color
 * @var $icon_size
 * @var $icon_align
 * @var $title
 * @var $title_font_size
 * @var $description
 * @var $des_letter_spacing
 * @var $use_theme_fonts
 * @var $typography
 * @var $icon_type
 * @var $image
 * @var $icon_font
 * @var $icon_hover_style
 * @var $link
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Icon_Box
 */

$layout_style = $icon_bg_style = $icon_color = $icon_bg_color = $icon_size = $icon_align = $title = $title_font_size =
$description = $des_letter_spacing = $use_theme_fonts = $typography = $icon_type = $image = $icon_font = $link = $icon_hover_style =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

if ( in_array($layout_style, array('ib-left', 'ib-right'))) {
    $icon_align = '';
}
if('image' === $icon_type) {
    $icon_font = '';
} else {
    $image = '';
}
if ( $layout_style == 'ib-left-inline' || $layout_style == 'ib-right-inline' || $layout_style == 'ib-right-bg' ) {
    $icon_bg_style = 'iconbox-classic';
}
if('iconbox-classic' === $icon_bg_style) {
    $icon_hover_style = '';
}

$wrapper_classes = array(
    'gsf-icon-box',
    $layout_style,
    'clearfix',
    'iconbox-' . $icon_type,
    $icon_align,
    $icon_bg_style,
    $icon_size,
    $icon_hover_style,
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);

// animation
if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}

if(empty($icon_color)) $icon_color = '#e0e0e0';
if(empty($icon_bg_color)) $icon_bg_color = '#333';

$ib_custom_class = 'iconbox-' . uniqid();
$icon_box_css = <<<CSS
    .{$ib_custom_class} .iconbox-title {
        font-size: {$title_font_size}px !important;
    }
    .{$ib_custom_class} .ib-content p {
        letter-spacing: {$des_letter_spacing}em !important;
    }
CSS;
if(in_array($icon_bg_style, array('iconbox-bg-circle-fill', 'iconbox-bg-square-fill'))) {
    $icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-shape-inner {
            background-color: {$icon_bg_color};
            border-color: {$icon_bg_color} !important;
            color: {$icon_color};
        }
CSS;
} elseif(in_array($icon_bg_style, array('iconbox-bg-circle-outline', 'iconbox-bg-square-outline'))) {
    $icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-shape-inner {
            border-color: {$icon_bg_color} !important;
            color: {$icon_color};
        }
CSS;
} else {
    $icon_box_css .= <<<CSS
        .{$ib_custom_class} .ib-shape-inner {
            color: {$icon_color};
        }
CSS;
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
    $icon_box_css .= <<<CSS
        .{$ib_custom_class} .iconbox-title {
            font-family: {$typography[0]} !important;
            font-weight: {$typography[2]} !important;
            font-style: {$typography[3]} !important;
        }
CSS;
}

GSF()->customCss()->addCss($icon_box_css);
$wrapper_classes[] = $ib_custom_class;

$ib_class = array(
    'ib-shape-inner'
);

//parse link
$link_attributes = $title_attributes = array();
$link            = ( '||' === $link ) ? '' : $link;
$link            = vc_build_link( $link );
$use_link        = false;
if ( strlen( $link['url'] ) > 0 ) {
    $use_link          = true;
    $link_attributes[] = 'href="' . esc_url( trim( $link['url'] ) ) . '"';
    if ( strlen( $link['target'] ) > 0 ) {
        $link_attributes[] = 'target="' . trim( $link['target'] ) . '"';
    }
    if ( strlen( $link['rel'] ) > 0 ) {
        $link_attributes[] = 'rel="' . trim( $link['rel'] ) . '"';
    }
    $title_attributes = $link_attributes;
    if ( strlen( $link['title'] ) > 0 ) {
        $link_attributes[] = 'title="' . trim( $link['title'] ) . '"';
    }
    $title_attributes[] = 'title="' . esc_attr( trim( $title ) ) . '"';
}

// icon html
$icon_html = '';
if('icon' === $icon_type && !empty($icon_font)) {
    $icon_html = '<i class="' . esc_attr($icon_font) . '"></i>';
} elseif ('image' === $icon_type && !empty($image)) {
    if('iconbox-classic' === $icon_bg_style) {
        $img = wp_get_attachment_image_src($image, 'full');
        if(!empty($img)) {
            $icon_html = '<img alt="' . esc_attr($title) . '" src="' . esc_url($img[0]) . '">';
        }
    } else {
        $image_full = wpb_resize($image, null, 160, 160, true);
        $image_src = '';
        if (sizeof($image_full) > 0) {
            $image_src = $image_full['url'];
        }
        $icon_html = '<img alt="' . esc_attr($title) . '" src="' . esc_url($image_src) . '">';
    }
}

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
    wp_enqueue_style(G5P()->assetsHandle('icon-box'), G5P()->helper()->getAssetUrl('shortcodes/icon-box/assets/css/icon-box.min.css'), array(), G5P()->pluginVer());
}

?>
<div class="<?php echo esc_attr( $css_class ) ?>">
    <?php if ( $layout_style == 'ib-left-inline' ): ?>
        <?php if ( !empty( $title ) || !empty( $description ) || !empty( $icon_html ) ): ?>
            <div class="ib-content">
                <div class="ib-shape">
                    <div class="<?php echo implode( ' ', $ib_class ); ?>">
                        <?php if ( $use_link ): ?>
                            <a <?php echo implode( ' ', $link_attributes ); ?> class="gsf-link">
                                <?php echo wp_kses_post($icon_html ); ?>
                            </a>
                        <?php else:
                            echo wp_kses_post($icon_html );
                        endif; ?>
                    </div>
                </div>
                <?php if ( !empty( $title ) ):
                    if ( $use_link ): ?>
                        <h4 class="iconbox-title"><a <?php echo implode( ' ', $title_attributes ); ?> class="gsf-link">
                                <span><?php echo esc_attr( $title ) ?></span>
                            </a></h4>
                    <?php else: ?>
                        <h4 class="iconbox-title"><?php echo esc_attr( $title ) ?></h4>
                    <?php endif;
                endif;
                if ( !empty( $description ) ): ?>
                    <p><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php elseif ( $layout_style == 'ib-right-inline' ): ?>
        <?php if ( !empty( $title ) || !empty( $description ) || !empty( $icon_html ) ): ?>
            <div class="ib-content">
                <?php if ( !empty( $title ) ):
                    if ( $use_link ): ?>
                        <h4 class="iconbox-title"><a <?php echo implode( ' ', $title_attributes ); ?> class="gsf-link">
                                <span><?php echo esc_attr( $title ) ?></span>
                            </a></h4>
                    <?php else: ?>
                        <h4 class="iconbox-title"><?php echo esc_attr( $title ) ?></h4>
                    <?php endif;
                endif; ?>
                <div class="ib-shape">
                    <div class="<?php echo implode( ' ', $ib_class ); ?>">
                        <?php if ( $use_link ): ?>
                            <a <?php echo implode( ' ', $link_attributes ); ?> class="gsf-link">
                                <?php echo wp_kses_post( $icon_html ); ?>
                            </a>
                        <?php else:
                            echo wp_kses_post( $icon_html );
                        endif; ?>
                    </div>
                </div>
                <?php if ( !empty( $description ) ): ?>
                    <p><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php elseif ( $layout_style != 'ib-right' && $layout_style != 'ib-right-bg' ): ?>
        <div class="ib-shape">
            <div class="<?php echo implode( ' ', $ib_class ); ?>">
                <?php if ( $use_link ): ?>
                    <a <?php echo implode( ' ', $link_attributes ); ?> class="gsf-link">
                        <?php echo wp_kses_post( $icon_html ); ?>
                    </a>
                <?php else:
                    echo wp_kses_post( $icon_html );
                endif; ?>
            </div>
        </div>
        <?php if ( !empty( $title ) || !empty( $description ) ): ?>
            <div class="ib-content">
                <?php if ( !empty( $title ) ):
                    if ( $use_link ): ?>
                        <h4 class="iconbox-title"><a <?php echo implode( ' ', $title_attributes ); ?> class="gsf-link">
                                <span><?php echo esc_attr( $title ) ?></span>
                            </a></h4>
                    <?php else: ?>
                        <h4 class="iconbox-title"><?php echo esc_attr( $title ) ?></h4>
                    <?php endif;
                endif;
                if ( !empty( $description ) ): ?>
                    <p><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php if ( !empty( $title ) || !empty( $description ) ): ?>
            <div class="ib-content">
                <?php if ( !empty( $title ) ):
                    if ( $use_link ): ?>
                        <h4 class="iconbox-title"><a <?php echo implode( ' ', $title_attributes ); ?> class="gsf-link">
                                <span><?php echo esc_attr( $title ) ?></span>
                            </a></h4>
                    <?php else: ?>
                        <h4 class="iconbox-title"><?php echo esc_attr( $title ) ?></h4>
                    <?php endif;
                endif;
                if ( !empty( $description ) ): ?>
                    <p><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="ib-shape">
            <div class="<?php echo implode( ' ', $ib_class ); ?>">
                <?php if ( $use_link ): ?>
                    <a <?php echo implode( ' ', $link_attributes ); ?> class="gsf-link">
                        <?php echo wp_kses_post( $icon_html ); ?>
                    </a>
                <?php else:
                    echo wp_kses_post( $icon_html );
                endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
