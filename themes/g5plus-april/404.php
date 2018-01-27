<?php
g5Theme()->options()->setOptions('sidebar_layout','none');
g5Theme()->options()->setOptions('content_full_width','on');
$content_block = g5Theme()->options()->get_404_content_block();
if (!empty($content_block)) {
    g5Theme()->options()->setOptions('content_padding',array('left' => '', 'right' => '','top' => '', 'bottom' => ''));
}
get_header();
?>
<?php if (!empty($content_block)): ?>
    <?php echo g5Theme()->helper()->content_block($content_block); ?>
<?php else: ?>
    <?php $content = g5Theme()->options()->get_404_content(); ?>
    <div class="container">
        <div class="gf-404-wrap">
            <?php if (!empty($content)): ?>
                <?php g5Theme()->helper()->shortCodeContent($content); ?>
            <?php else: ?>
                <h2><?php esc_html_e('404','g5plus-april'); ?></h2>
                <h4><?php esc_html_e('Oops! Page not found', 'g5plus-april') ?></h4>
                <p><?php esc_html_e('Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.', 'g5plus-april') ?></p>
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-primary"><?php esc_html_e('Go to home page', 'g5plus-april'); ?></a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php
get_footer();