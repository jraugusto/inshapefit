<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/20/2017
 * Time: 10:32 AM
 */
?>
<div class="gf-single-portfolio-wrap portfolio-single-layout-1 clearfix">
    <div id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single clearfix layout-1'); ?>>
        <?php g5Theme()->helper()->getTemplate('portfolio/single/portfolio-gallery'); ?>
        <div class="gf-portfolio-content row">
            <div class="col-md-8 gf-sticky">
                <div class="portfolio-item-category">
                    <?php g5Theme()->portfolio()->the_category(', ') ?>
                </div>
                <?php g5Theme()->helper()->getTemplate('portfolio/single/portfolio-title') ?>
                <div class="gf-entry-content clearfix ">
                    <?php
                    the_content();
                    wp_link_pages(array(
                        'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:','g5plus-april') . '</span>',
                        'after' => '</div>',
                        'link_before' => '<span class="page-link">',
                        'link_after' => '</span>',
                    ));
                    ?>
                </div>
            </div>
            <div class="col-md-4 gf-sticky gf-portfolio-meta-wrap">
                <?php g5Theme()->helper()->getTemplate('portfolio/single/portfolio-meta') ?>
            </div>
        </div>
    </div>
    <?php
    /**
     * @hooked - portfolio_related - 10
     *
     **/
    do_action('g5plus_after_single_portfolio')
    ?>
</div>