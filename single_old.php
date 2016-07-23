<?php get_header(); 
?>
						
<div class="single-content block-page">
<?php
if (have_posts()) : while (have_posts()) : the_post(); $post_id=get_the_ID(); setPostViews($post_id); 
	if (get_post_format() !='aside'):
?>

		<div class="entry-content">
        <?php mongabay_sharebox($post_id); ?>

        <div class="videobox">
        <?php 
			if ($video){ 
				echo wp_oembed_get( esc_url($video));
			}
		?></div>
        
      <?php //the_excerpt();
	  		
			$bullet_count = get_post_meta($post_id,"mog_bullet",true);		
			if((int)$bullet_count > 0 && get_post_meta($post_id,"mog_bullet_0_mog_bulletpoint",true)){
				echo '<div class="mogbullets"><ul>';
				for($i=0;$i<$bullet_count;$i++){
					
					echo "<li>".get_post_meta($post_id,"mog_bullet_".$i."_mog_bulletpoint",true)."</li>";					
				}
				echo "</ul></div>";	
			} 
					?> 
           <div class="above-article-ad-cont">
		    	<?php 
				if (get_post_format()!='aside') $spot = 'article-top';
				else $spot = 'featured-top';
				//tochange echo mongabay_adsense_show($spot);
				
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
              <div class="all-topics">
              		
		   </div>
           
              <?php edit_post_link( __( 'Edit', 'abomb' ), '<span class="edit-link">', '</span>' ); ?>
              
              <div class="below-article-ads">
              <?php 
			  		//tochange echo mongabay_adsense_show('article-below-1').mongabay_adsense_show('article-below-2'); 						
				?>
               </div>
          </div>
         
          <?php mongabay_sharebox($post_id); ?>
		</div>
		
  <?php endif; ?> 
		
		<?php echo relatedPosts(6, 'topic-location', $post_id, $sidebar_layout);  ?>
        
<?php endwhile; wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>	