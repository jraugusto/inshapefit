<?php
/**
 * The template for displaying comments.php
 * @var $comment
 * @var $args
 * @var $depth
 */
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
		<?php echo get_avatar($comment, $args['avatar_size']); ?>
		<div class="comment-text entry-content">
			<ul class="gf-inline comment-top">
				<li>
					<h4 class="author-name"><?php echo get_comment_author_link() ?></h4>
				</li>
				<li class="comment-meta-date disable-color">
					<i class="fa fa-clock-o"></i> <?php echo (get_comment_date(get_option('date_format')) . ' ' . esc_html__('at','g5plus-april') . ' ' . get_comment_date('H:i a')) ; ?>
				</li>
			</ul>
			<div class="gf-entry-content">
				<?php comment_text() ?>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php esc_html_e('Your comment is awaiting moderation.','g5plus-april');?></em>
				<?php endif; ?>
			</div>
			<div class="comment-meta disable-color">
				<?php edit_comment_link('<i class="ion-compose"></i> ' . esc_html__('Edit','g5plus-april')); ?>
				<?php comment_reply_link(array_merge($args, array(
					'depth' => $depth,
					'max_depth' => $args['max_depth'],
					'reply_text' => '<i class="ion-reply"></i> ' . esc_html__('Reply', 'g5plus-april'),
					'reply_to_text' => '<i class="ion-reply"></i> ' . esc_html__('Reply to %s', 'g5plus-april'),
					'login_text' => '<i class="ion-reply"></i> ' . esc_html__('Log in to Reply', 'g5plus-april'),
				))) ?>
			</div>
		</div>
	</div>
