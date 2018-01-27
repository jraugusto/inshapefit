<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php
	/**
	 * @hooked - g5Theme()->templates()->site_loading() - 5
	 **/
	do_action('g5plus_before_page_wrapper');
	?>
	<?php
		/**
		 * Color Skin
		 */
		$skin = g5Theme()->options()->get_content_skin();
		$skin_classes = g5Theme()->helper()->getSkinClass($skin);
		$class  = implode(' ',$skin_classes);
	?>
	<!-- Open Wrapper -->
	<div id="gf-wrapper" class="<?php echo esc_attr($class)?>">
		<?php
		/**
		 * @hooked - g5Theme()->templates()->top_drawer() - 10
		 * @hooked - g5Theme()->templates()->header() - 15
		 **/
		do_action('g5plus_before_page_wrapper_content');
		?>
		<!-- Open Wrapper Content -->
		<div id="wrapper-content" class="clearfix ">
			<?php
			/**
			 *
			 * @hooked - g5Theme()->templates()->content_wrapper_start() - 1
			 **/
			do_action('g5plus_main_wrapper_content_start');
			?>
