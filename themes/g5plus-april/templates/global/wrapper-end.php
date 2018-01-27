<?php
/**
 * The template for displaying wrapper-end
 */
$content_full_width = g5Theme()->options()->get_content_full_width();
?>
			</div> <!-- End Primary Content Inner -->
			<?php get_sidebar(); ?>
		</div> <!-- End Primary Content Row -->
	<?php if ($content_full_width !== 'on'): ?>
	</div> <!-- End Primary Content Container -->
	<?php endif; ?>
</div> <!-- End Primary Content Wrapper -->
