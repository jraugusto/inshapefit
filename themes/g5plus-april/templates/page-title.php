<?php
/**
 * The template for displaying page-title
 */
$page_title_enable = g5Theme()->options()->get_page_title_enable();
if ($page_title_enable !== 'on') return;
$content_block = g5Theme()->options()->get_page_title_content_block();
$skin = g5Theme()->options()->get_page_title_skin();

$wrapper_classes = array(
	'gf-page-title'
);

$skin_classes = g5Theme()->helper()->getSkinClass($skin);
$wrapper_classes = array_merge($wrapper_classes,$skin_classes);
if (empty($content_block)){
    $wrapper_classes[] = 'gf-page-title-default';
}

$wrapper_class = implode(' ', array_filter($wrapper_classes));

?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php if (!empty($content_block)): ?>
		<?php echo g5Theme()->helper()->content_block($content_block); ?>
	<?php else: ?>
		<?php $page_title = g5Theme()->helper()->get_page_title(); ?>
		<div class="container">
			<div data-table-cell="true" class="page-title-inner gf-table-cell">
				<div class="gf-table-cell-left">
					<h1><?php echo esc_html($page_title);?></h1>
				</div>
				<div class="gf-table-cell-right">
					<?php g5Theme()->breadcrumbs()->get_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
