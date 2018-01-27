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
?>
<div class="testimonial-item">
    <div class="testimonials-content">
        <?php if (!empty($bio)): ?>
            <p><?php echo wp_kses_post($bio); ?></p>
        <?php endif; ?>
    </div>
    <?php if (!empty($name) || !empty($job)): ?>
        <div class="author-info">
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
                    <span><?php echo esc_html($job); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>