<div id="comments">
	<div id="comments-block"><div id="comments-block-inner">
	<?php if ( have_comments() || comments_open()  ) : ?> 
        <h4 class="single-block-title comments-title">
            <?php _e( 'Recent comments', 'abomb' ) ?>
            <span class="comments-count">
                <?php comments_number(); ?>
            </span>
        </h4>
    <?php endif; ?>

	<?php 
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$comments_args = array(
			'title_reply'=>'',
			'title_reply_to'=>'',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'logged_in_as' => '',
			'label_submit' => __( 'Post Comment', 'abomb' ),
			'comment_field' => '<div class="text-comment"><textarea id="comment" placeholder="'.__('Comment','abomb').( $req ? ' *' : '' ) .'" name="comment" aria-required="true" rows="7"></textarea></div>',
			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' =>
				  '<div class="text-name el-left"><input id="author" placeholder="'.__('Name','abomb').( $req ? ' *' : '' ) .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				  '" size="30"' . $aria_req . ' /></div>',
				'email' =>
				  '<div class="text-email el-left"><input id="email" placeholder="'.__('Email','abomb').( $req ? ' *' : '' ) .'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				  '" size="30"' . $aria_req . ' /></div>',
				'url' =>
				  '<div class="text-web"><input id="url" placeholder="'.__('Website','abomb').'" name="url" type="text" value="' . esc_url( $commenter['comment_author_url'] ) .
				  '" size="30" /></div>'
				)
		  ),
	);
	
	?>
<?php if ( have_comments() ) : ?> 
	<ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'reedwan_comment', 'style' => 'ol' ) ); ?>
	</ol>
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>
		<div class="comment-navigation">			
			<div class="nav-previous el-left"><?php previous_comments_link( __( '&larr; Older Comments', 'abomb' ) ); ?></div>
			<div class="nav-next el-right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'abomb' ) ); ?></div>
		</div> 
	<?php endif; ?>

	<?php if ( ! comments_open() ) : ?>
		<p class="nocomments">
			<?php _e( 'Comments are closed.', 'abomb' ); ?>
		</p>
	<?php endif;?>
<?php endif; ?> 
    <?php if (mongabay_is_legacy_post()): ?>
	<div class="fb-comments-wrap">
    	<h4><?php _e('Facebook Comments','mongabay-theme') ?></h4>
    	<div class="fb-comments" data-href="<?php echo mongabay_sharebox_share_url(get_the_ID()); ?>" data-width="760" data-numposts="5"></div>
    </div>
	<?php endif; ?>
	</div></div>
	<aside id="comments-form">
    <?php 
	if ( comments_open() ) comment_form($comments_args);
	echo mongabay_adsense_show('comments-form');
	?>
    </aside>
</div>
