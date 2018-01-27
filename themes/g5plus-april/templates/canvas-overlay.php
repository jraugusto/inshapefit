<?php
/**
 * The template for displaying canvas-overlay.php
 */
$image_url = g5Theme()->themeUrl('assets/images/close.png');
$custom_css = <<<CSS
	.canvas-overlay {
		cursor: url({$image_url}) 15 15, default;
	}
CSS;
g5Theme()->custom_css()->addCss($custom_css,'canvas_overlay');

?>
<div class="canvas-overlay"></div>
