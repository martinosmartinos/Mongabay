<?php 
	get_header(); 
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }
?>
<div class="single-content block-page">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>
		<?php 
			$hide_title='';
			if (rd_field('abomb_page_title')=='0') {
				$hide_title=' hide-element';
			}
		?>
		<div class="entry-header<?php echo $hide_title; ?>">
			<?php echo content_single_title(); ?>
		</div>
		<?php 
			if (rd_field('abomb_page_image')!=0) {
				$video = $audio = $gallery = '';
				echo single_featured_image(thumb_sidebar($sidebar_layout), $video, $audio, $gallery,'no');
			}
		?>
		<div class="entry-content">
			<?php 
				the_content(); 
				wp_link_pages( array(
					'before'      => '<div class="page-links el-left"><span class="page-links-title">' . __( 'Pages:', 'abomb' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
		</div>
		
		<div class="hide-element">
			<?php echo meta_author(get_the_author_meta( 'ID' )); ?>
			<?php echo content_meta_complete_date(); ?>
		</div>
	</div>
<?php endwhile; wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>