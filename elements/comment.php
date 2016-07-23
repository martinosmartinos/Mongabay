<?php
if ( ! function_exists( 'reedwan_comment' ) ) :
function reedwan_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-wrap">
			<div class="comment-author vcard el-left">
				<?php echo get_avatar( $comment, 110 ); ?>
			</div>
			<div class="comment-body">
				<div class="comment-body-head">
					<?php printf( sprintf( '<span class="commenter-name">%s</span>', get_comment_author_link() ) ); ?>
					<span class="comment-date el-right"><?php echo abomb_time_diff( get_comment_date('U'), current_time('timestamp') ); ?></span>
                  <a class="comment-link el-right" href="<?php echo get_comment_link(); ?>"></a>
				</div>
				<div class="comment-body-text">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<span class="comment-awaiting-moderation"><em><?php _e( 'Your comment is awaiting moderation.', 'abomb' ); ?></em></span>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
				<div class="comment-body-foot">
					<span class="reply-comment el-left"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
					<?php if(rd_options('abomb_comment_like_dislike') == 1):?>
						<span class="comment-like el-left"><?php if(function_exists('abomb_like_counter')) { abomb_like_counter(__('Like','abomb')); }?><span class="alert-msg"></span></span>
						<span class="comment-dislike el-left"><?php if(function_exists('abomb_dislike_counter')) { abomb_dislike_counter(__('Dislike','abomb')); }?><span class="alert-msg"></span></span>
					<?php endif; ?>
					<span class="edit-comment el-right"><?php edit_comment_link( __( ' Edit', 'abomb' ), ' ' );?></span>
				</div>
			</div>
		</div>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'abomb' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'abomb' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;
?>