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
 * @var $index
 */
$index = ($index < 10 ? '#0' : '#') . $index;
?>
<div class="testimonial-item" data-item-before="<?php echo esc_attr($index); ?>">
    <div class="testimonials-content">
        <?php if (!empty($bio)): ?>
            <p>« <?php echo wp_kses_post($bio); ?> »</p>
        <?php endif; ?>
    </div>
    <?php if (!empty($name) || !empty($job) || !empty($image_src)): ?>
        <div class="author-info clearfix">
            <div class="gf-table-cell">
                <div class="author-avatar gf-table-cell-left">
                    <?php if(!empty($image_src)): ?>
                        <?php if (!empty($url)): ?>
                            <a href="<?php echo esc_url($url) ?>" title="<?php echo esc_attr($name); ?>">
                        <?php endif; ?>
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($name); ?>">
                        <?php if (!empty($url)): ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="gf-table-cell-right author-attr">
                    <?php if (!empty($name)): ?>
                        <h6 class="author-name">
                            <?php if (!empty($url)): ?>
                                <a href="<?php echo esc_url($url) ?>" title="<?php echo esc_attr($name); ?>">
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
        </div>
    <?php endif; ?>
</div>