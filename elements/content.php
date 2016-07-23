<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
$block_id = 0;
if ( ! function_exists( 'block_one_two_content' ) ) {
	function block_one_two_content($atts) {
		if ($atts['big_post'] == 'yes' && $atts['counter'] == 0 && $atts['is_ajax'] == 0): ?>
			<div class="big-post ajax-item thumb-<?php echo $atts['thumb']; ?> clearfix" >
					<div class="entry-image">
						<?php echo content_image('medium', $atts['video'], $atts['audio'], $atts['gallery']); ?>
					</div>
				<div class="entry-header">
						<div class="entry-meta">
							<?php $locations = array_slice(wp_get_object_terms(get_the_ID(), 'location', array('orderby' => 'count', 'order' => 'DESC')),0,1);
								$location=reset($locations);?>
                          <?php if (!empty($location->slug)): ?>
						  <a class="location-link" href="<?php echo mongabay_url('topic',$location->slug); ?>"><?php echo $location->name; ?></a><?php endif; ?>
						 	<span class="entry-date"><?php echo get_the_date(); ?></span>
                         <i class="entry-format-icon entry-format-icon-<?php echo get_post_format(); ?>"></i>
						</div>
					<?php echo content_title(); ?>
				</div>
				<?php if ($atts['big_excerpt']>0): ?>
					<div class="entry-content">
						<?php echo word_count(get_the_excerpt(),$atts['big_excerpt']); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="small-post ajax-item clearfix" >
				<?php $with_thumb=''; ?>
					<div class="entry-image">
						<?php echo content_image('thumbnail', $atts['video'], $atts['audio'], $atts['gallery']); ?>
					</div>
					<?php $with_thumb = ' with-thumb'; ?>
				<div class="entry-header<?php echo $with_thumb; ?>">
						<div class="entry-meta">
							<?php $locations = array_slice(wp_get_object_terms(get_the_ID(), 'location', array('orderby' => 'count', 'order' => 'DESC')),0,1);
								$location=reset($locations); ?>
                         <?php if (!empty($location->slug)): ?><a class="location-link" href="<?php echo mongabay_url('topic',$location->slug); ?>"><?php echo $location->name; ?></a><?php endif; ?>
						 	<span class="entry-date"><?php echo get_the_date(); ?></span>
                         <i class="entry-format-icon entry-format-icon-<?php echo get_post_format(); ?>"></i>
						</div>
					<?php echo content_title(); ?>
				</div>
				<?php if ($atts['small_excerpt']>0): ?>
					<div class="entry-content<?php echo $with_thumb; ?>">
						<?php echo word_count(get_the_excerpt(),$atts['small_excerpt']); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif;
	}
}
if ( ! function_exists( 'block_grid_content' ) ) {
	function block_grid_content($atts) {
	?>
		<div class="big-post <?php echo $atts['align']; ?> ajax-item <?php echo $atts['column']; ?> clearfix" >
			<?php if (has_post_thumbnail()): ?>
				<div class="entry-image">
					<?php echo content_image('mediumthumb', $atts['video'], $atts['audio'], $atts['gallery']); ?>
				</div>
			<?php endif; ?>
			<div class="entry-header">
              <div class="entry-date"><?php echo get_the_date(); ?></div>
				<?php echo content_title(); ?>
			</div>
			<?php if ($atts['excerpt']>0): ?>
				<div class="entry-content">
					<?php echo word_count(get_the_excerpt(),$atts['excerpt']); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php
	}
}
if ( ! function_exists( 'block_classic_content' ) ) {
	function block_classic_content($atts) {
	?>
		<div class="big-post ajax-item clearfix" >
			<?php $with_thumb=''; ?>
			<?php if (has_post_thumbnail()): ?>
				<div class="entry-image">
					<div class="image-triangle"></div>
					<?php echo content_image($atts['thumb'], $atts['video'], $atts['audio'], $atts['gallery']); ?>
				</div>
				<?php $with_thumb = ' with-thumb'; ?>
			<?php endif; ?>
			<div class="entry-header<?php echo $with_thumb; ?>">
				<?php if ($atts['first_cat']  == 'yes' || $atts['date']  == 'yes' || $atts['star']  == 'yes'): ?>
					<div class="entry-meta">
						<?php if ($atts['date']  == 'yes'): ?>
							<?php echo content_meta_date(); ?>
						<?php endif; ?>
						<?php if ($atts['first_cat']  == 'yes'): ?>
							<?php echo content_first_cat($atts['star']); ?>
						<?php endif; ?>
						<?php if ($atts['star']  == 'yes'): ?>
							<?php echo content_star(); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php echo content_title(); ?>
			</div>
			<?php if ($atts['excerpt']>0): ?>
				<div class="entry-content<?php echo $with_thumb; ?>">
					<?php echo word_count(get_the_excerpt(),$atts['excerpt']); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php
	}
}
if ( ! function_exists( 'block_six_content' ) ) {
	function block_six_content($atts) {
	?>
		<div class="big-post ajax-item clearfix" >
			<div class="entry-header">
				<?php if ($atts['first_cat']  == 'yes'): ?>
					<div class="entry-meta clearfix">
						<?php echo content_first_cat('no'); ?>
					</div>
				<?php endif; ?>
				<?php echo content_title(); ?>
				<?php if ($atts['meta']  == 'yes' && ($atts['date']  == 'yes' || $atts['post_author']  == 'yes' || $atts['views']  == 'yes' || $atts['shares']  == 'yes' || $atts['comments']  == 'yes' || $atts['twitter']  == 'yes')): ?>
					<div class="entry-meta bottom">
						<?php if ($atts['post_author']  == 'yes'): ?>
							<span class="meta-author"><?php echo _e('By', 'abomb');?> <?php echo the_author_posts_link(); ?></span>
						<?php endif; ?>
						<?php if ($atts['twitter']  == 'yes'): ?>
							<?php echo content_meta_twitter(); ?>
						<?php endif; ?>
						<?php if ($atts['date']  == 'yes'): ?>
							<?php echo content_meta_complete_date(); ?>
						<?php endif; ?>
						<?php if ($atts['comments']  == 'yes'): ?>
							<?php echo content_meta_comments($atts['comment_type'], 'no'); ?>
						<?php endif; ?>
						<?php if ($atts['views']  == 'yes'): ?>
							<?php echo content_meta_views(); ?>
						<?php endif; ?>
						<?php if ($atts['shares']  == 'yes'): ?>
							<?php echo content_meta_shares(); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
			</div>
			<?php echo single_featured_image($atts['thumb'], $atts['video'], $atts['audio'], $atts['gallery'], $atts['nav']); ?>
			<div class="entry-content">
				<?php 
				global $more; $more = 0;
				the_content(__( 'Continue reading...', 'abomb' )); 
				wp_link_pages( array(
						'before'      => '<div class="page-links el-left"><span class="page-links-title">' . __( 'Pages:', 'abomb' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
			</div>
		</div>
	<?php
	}
}
if ( ! function_exists( 'block_ten_content' ) ) {
	function block_ten_content($atts) { ?>
		<div class="big-post ajax-item thumb-<?php echo $atts['thumb']; ?> clearfix" >
			<?php if (has_post_thumbnail()): ?>
				<div class="entry-image">
					<?php echo content_image($atts['thumb'], $atts['video'], $atts['audio'], $atts['gallery']); ?>
				</div>
			<?php endif; ?>
			<div class="entry-header">
				<?php if ($atts['first_cat']  == 'yes' || $atts['star']  == 'yes'): ?>
					<div class="entry-meta">
						<?php if ($atts['first_cat']  == 'yes'): ?>
							<?php echo content_first_cat($atts['star']); ?>
						<?php endif; ?>
						<?php if ($atts['star']  == 'yes'): ?>
							<?php echo content_star(); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php echo content_title(); ?>
			</div>
			<?php if ($atts['big_excerpt']>0): ?>
				<div class="entry-content">
					<?php echo word_count(get_the_excerpt(),$atts['big_excerpt']); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
if ( ! function_exists( 'block_eleven_content' ) ) {
	function block_eleven_content($atts) {
		if ($atts['big_post'] == 'yes' && ($atts['counter'] == 1 || $atts['counter'] == 2)): ?>
			<div class="big-post grid-6 ajax-item clearfix" >
				<?php if (has_post_thumbnail()): ?>
					<div class="entry-image">
						<?php echo content_image($atts['thumb'], $atts['video'], $atts['audio'], $atts['gallery']); ?>
					</div>
				<?php endif; ?>
				<div class="entry-header">
					<?php if ($atts['first_cat']  == 'yes' || $atts['star']  == 'yes'): ?>
						<div class="entry-meta">
							<?php if ($atts['first_cat']  == 'yes'): ?>
								<?php echo content_first_cat($atts['star']); ?>
							<?php endif; ?>
							<?php if ($atts['star']  == 'yes'): ?>
								<?php echo content_star(); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php echo content_title(); ?>
				</div>
				<?php if ($atts['excerpt']>0): ?>
					<div class="entry-content">
						<?php echo word_count(get_the_excerpt(),$atts['excerpt']); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="small-post grid-6 ajax-item clearfix" >
				<?php $with_thumb=''; ?>
				<?php if (has_post_thumbnail()): ?>
					<div class="entry-image">
						<?php echo content_image('big-list-thumb', $atts['video'], $atts['audio'], $atts['gallery']); ?>
					</div>
					<?php $with_thumb = ' with-thumb'; ?>
				<?php endif; ?>
				<div class="entry-header<?php echo $with_thumb; ?>">
					<?php echo content_title(); ?>
					<?php if ($atts['date']  == 'yes' || $atts['star']  == 'yes'): ?>
						<div class="entry-meta">
							<?php if ($atts['date']  == 'yes'): ?>
								<?php echo content_small_date($atts['star']); ?>
							<?php endif; ?>
							<?php if ($atts['star']  == 'yes'): ?>
								<?php echo content_star(); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php
		endif;
	}
}

if ( ! function_exists( 'block_twelve_content' ) ) {
	function block_twelve_content($atts) {
		if ($atts['big_post'] == 'yes' && ($atts['counter']%5 == 0)): ?>
			<div class="big-post grid-6 ajax-item clearfix" >
				<?php if (has_post_thumbnail()): ?>
					<div class="entry-image">
						<?php echo content_image($atts['thumb'], $atts['video'], $atts['audio'], $atts['gallery']); ?>
					</div>
				<?php endif; ?>
				<div class="entry-header">
					<?php if ($atts['first_cat']  == 'yes' || $atts['star']  == 'yes'): ?>
						<div class="entry-meta">
							<?php if ($atts['first_cat']  == 'yes'): ?>
								<?php echo content_first_cat($atts['star']); ?>
							<?php endif; ?>
							<?php if ($atts['star']  == 'yes'): ?>
								<?php echo content_star(); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php echo content_title(); ?>
				</div>
				<?php if ($atts['excerpt']>0): ?>
					<div class="entry-content">
						<?php echo word_count(get_the_excerpt(),$atts['excerpt']); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="small-post grid-6 ajax-item clearfix" >
				<?php $with_thumb=''; ?>
				<?php if (has_post_thumbnail()): ?>
					<div class="entry-image">
						<?php echo content_image('big-list-thumb', $atts['video'], $atts['audio'], $atts['gallery']); ?>
					</div>
					<?php $with_thumb = ' with-thumb'; ?>
				<?php endif; ?>
				<div class="entry-header<?php echo $with_thumb; ?>">
					<?php echo content_title(); ?>
					<?php if ($atts['date']  == 'yes' || $atts['star']  == 'yes'): ?>
						<div class="entry-meta">
							<?php if ($atts['date']  == 'yes'): ?>
								<?php echo content_small_date($atts['star']); ?>
							<?php endif; ?>
							<?php if ($atts['star']  == 'yes'): ?>
								<?php echo content_star(); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif;
	}
}
?>