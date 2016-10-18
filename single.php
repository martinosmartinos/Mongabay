<?php get_header();?>	
<div class="single-content block-page">
	<?php
	if (have_posts()) : while (have_posts()) : the_post(); $post_id=get_the_ID(); setPostViews($post_id); 
		if (get_post_format() !='aside'):
	?>

	<div class="entry-content">
        <div class="videobox">
	        <?php 
				if ($video){ 
					echo wp_oembed_get( esc_url($video));
				}
			?>
		</div>
        
		<?php
			$mog_count = 0;
			for ($n=0;$n < 4;$n++){
				$single_bullet=get_post_meta($post_id,"mog_bullet_".$n."_mog_bulletpoint",true);
				if(!empty($single_bullet)) {
					$mog_count=$mog_count+1;				
				}
			}
			if((int)$mog_count > 0 && get_post_meta($post_id,"mog_bullet_0_mog_bulletpoint",true)){
				echo '<div class="mogbullets"><ul>';
				for($i=0;$i<$mog_count;$i++){
					
					echo "<li>".get_post_meta($post_id,"mog_bullet_".$i."_mog_bulletpoint",true)."</li>";					
				}
				echo "</ul></div>";	
			} 
		?> 
       <div class="above-article-ad-cont">
	    	<?php 
			if (get_post_format()!='aside') $spot = 'article-top';
			else $spot = 'featured-top';
			echo mongabay_adsense_show($spot);
			
			?>
       </div>
		<?php 
			mongabay_sanitized_content($post_id);
			 
			
			wp_link_pages( array(
				'before'      => '<div class="page-links el-left"><span class="page-links-title">' . __( 'Pages:', 'abomb' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			
			
		?>
          
		<div class="entry-meta-below-content">
				<p itemprop="publisher" itemscope itemtype="http://schema.org/Person"><?php _e('Article published by','mongabay-theme'); ?> <span itemprop="name"><?php the_author(); ?></span> <?php _e('on','mongabay-theme'); ?> <?php the_date(); ?>.</p>
				<?php echo do_shortcode ('[print-me target=".entryheader, .mogbullets, article"]');?>
		  <div class="all-topics">
			<h5>Article Topics:</h5>
			<?php
				$topics = wp_get_post_terms($post->ID, 'topic');
				foreach($topics as $topic) {
					echo '<a href="' . get_home_url().'/list/'.sanitize_title($topic->name). '"><span itemprop="name">'.$topic->name.'</span></a>';
				}
			?>		  
		  </div>

		  <?php edit_post_link( __( 'Edit', 'abomb' ), '<span class="edit-link">', '</span>' ); ?>
		  
		  <div class="below-article-ads">
		  <?php 
		  		echo mongabay_adsense_show('article-below-1').mongabay_adsense_show('article-below-2'); 						
			?>
		   </div>
		</div>
	</div>
		
	<?php endif; ?> 
		
	<?php echo relatedPosts(6, 'topic-location', $post_id, $sidebar_layout);  ?>
        
	<?php endwhile; wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>