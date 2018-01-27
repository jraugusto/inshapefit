<?php
/**
 * The template for displaying content-page
 */
?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('page gf-entry-content clearfix'); ?>>

        <?php
        the_content();
        wp_link_pages(array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'g5plus-april') . '</span>',
            'after'       => '</div>',
            'link_before' => '<span class="page-link">',
            'link_after'  => '</span>',
        ));
        ?>
    </div>
<?php
/**
 * @hooked - post_single_comment - 5
 *
 **/
do_action('g5plus_after_single_page');
