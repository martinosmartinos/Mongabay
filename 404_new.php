<?php get_header(); ?>
<?php
switch_to_blog( 20 );
$p_name = get_query_var('name');
$search_post = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_name FROM $wpdb->posts WHERE post_name = %s AND post_type = %s AND post_status = %s", $p_name, 'post', 'publish' ));
if ( is_array($search_post) && sizeof($search_post) > 0 ) {
	status_header(200);
    $post_id = get_post($search_post[0]->ID);
	//restore_current_blog();
    setup_postdata($post_id);
	?>
	<div class="entry-content">
        <?php mongabay_sharebox($post_id);?>

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
              <div class="all-topics">
				<h5>Article Topics:</h5>
				<?php
					//$meta = get_post_meta ($post->ID);
					//var_dump($meta);
					$topics = wp_get_post_terms($post->ID, 'topic');
					foreach($topics as $topic) {
						echo '<a href="' . get_term_link($topic) . '"><span itemprop="name">' . $topic->name . '</span></a>&nbsp';
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
         
          <?php mongabay_sharebox($post_id); ?>
		</div>
		<?php echo relatedPosts(6, 'topic-location', $post_id, $sidebar_layout);  ?>
<?	
    //include_single_redirect ('single-routed');
} else {
?>
	<div class="error-wrap">
		<h1 class="error-title center"><?php echo __('Ooops... Error 404','abomb') ?></h1> 
		<p class="error-desc center"><?php echo __("We're sorry, but the page you are looking for doesn't exist.","abomb"); ?></p>
		<BR>

			<style type="text/css">
			@import url(//www.google.com/cse/api/branding.css);
			</style>
			<div class="cse-branding-bottom center" style="background-color:#FFFFFF;color:#000000">
			  <div class="cse-branding-form center">
			    <form action="http://www.google.com" id="cse-search-box" target="_blank">
			      <div>
			        <input type="hidden" name="cx" value="partner-pub-7638076456673025:8482957247" />
			        <input type="hidden" name="ie" value="UTF-8" />
			        <input type="text" name="q" size="58" />
			        <input type="submit" name="sa" value="Search" />
			      </div>
			    </form>
			  </div>
			  <div class="cse-branding-logo center">
			    <img src="http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif" alt="Google" />
			  </div>
			</div>


		<BR>
		<div class="error-button center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button medium"><span><i class="fa fa-long-arrow-left"></i> <?php _e('Back To Homepage','abomb');?></span></a></div>
	</div>
<?};?>
	<?php get_footer();?>