<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/11/2016
 * Time: 10:25 AM
 * @var $name
 * @var $job
 * @var $bio
 * @var $image_src
 * @var $url
 * @var $image
 */
$bq_image_src = '';
if (!empty($image)) {
    $bq_image_src = wp_get_attachment_image_src($image, 'full');
    if ($bq_image_src && !empty($bq_image_src[0])) {
        $bq_image_src = $bq_image_src[0];
    }
}
?>
<div class="testimonial-item">
    <img class="testimonials-before" src="<?php echo esc_url($bq_image_src); ?>" alt="<?php echo esc_attr($name); ?>">
    <div class="testimonials-content">
        <?php if (!empty($bio)): ?>
            <p><?php echo wp_kses_post($bio); ?></p>
        <?php endif; ?>
    </div>
    <?php if (!empty($name) || !empty($job) || !empty($image_src)): ?>
        <div class="author-info clearfix">
            <div class="author-avatar">
                <?php if(!empty($image_src)): ?>
                    <img src="<?php echo esc_url($image_src); ?>" title="<?php echo esc_attr($name); ?>" alt="<?php echo esc_attr($name); ?>">
                <?php endif; ?>
            </div>
            <div class="author-attr">
                <?php if (!empty($name)): ?>
                    <h6 class="author-name">
                        <?php if (!empty($url)): ?>
                        <a href="<?php echo esc_url($url) ?>">
                            <?php endif;
                            echo esc_attr($name);
                            if (!empty($url)): ?>
                        </a>
                    <?php endif; ?>
                    </h6>
                <?php endif; ?>
                <?php if (!empty($job)): ?>
                    <span>/ <?php echo esc_html($job); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>