<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/28/2017
 * Time: 3:17 PM
 * @var $portfolio_light_box
 */
if (!has_post_thumbnail()) return;
?>
<?php if ('feature' === $portfolio_light_box): ?>
    <?php
    $settings = &g5Theme()->blog()->get_layout_settings();
    if (!isset($settings['settingId']) || $settings['settingId'] === '') {
        $settingId = mt_rand();
        $settings['settingId'] = $settingId;
    } else {
        $settingId = $settings['settingId'];
    }
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
    if ($image === false) return;
    @list($src, $width, $height) = $image;
    $gallery_id = "portfolio_gallery_{$settingId}";
    $args = array(
        'galleryId' => $gallery_id
    );
    ?>
    <a data-magnific="true" data-gallery-id="<?php echo esc_attr($gallery_id); ?>" data-magnific-options='<?php echo json_encode($args) ?>' href="<?php echo esc_url($src) ?>" class="gsf-link"><i class="fa fa-search"></i></a>
<?php else: ?>
    <a data-portfolio-gallery data-id="<?php echo esc_attr(get_the_ID()) ?>" href="#" class="gsf-link"><i class="fa fa-search"></i></a>
<?php endif; ?>



