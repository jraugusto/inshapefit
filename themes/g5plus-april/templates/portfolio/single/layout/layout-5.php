<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/20/2017
 * Time: 10:32 AM
 */
?>
<div class="gf-single-portfolio-wrap clearfix">
    <div id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single clearfix layout-5'); ?>>
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
    <?php
    /**
     * @hooked - portfolio_related - 10
     *
     **/
    do_action('g5plus_after_single_portfolio');
    ?>
</div>