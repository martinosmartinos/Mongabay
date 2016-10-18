<div id="featured-format-content">
	<div class="entry-content">
		<div class="videobox">
			<?php 
				if (get_query_var( $video)){ 
					echo wp_oembed_get( esc_url(get_query_var( $video)));
				}
			?>
		</div>
		
		<?php
			$mog_count = 0;
			$idd = get_the_ID();
				for ($n=0;$n < 4;$n++){
					$single_bullet=get_post_meta($idd,"mog_bullet_".$n."_mog_bulletpoint",true);
					if(!empty($single_bullet)) {
						$mog_count=$mog_count+1;				
					}
				}
				if((int)$mog_count > 0 && get_post_meta($idd,"mog_bullet_0_mog_bulletpoint",true)){
					echo '<div class="mogbullets"><ul>';
					for($i=0;$i<$mog_count;$i++){
						
						echo '<li>'.get_post_meta($idd,"mog_bullet_".$i."_mog_bulletpoint",true).'</li>';					
					}
					echo '</ul></div>';	
				};
			echo mongabay_adsense_show('featured-top');
			echo mongabay_sanitized_content($idd);
				wp_link_pages( array(
					'before'      => '<div class="page-links el-left"><span class="page-links-title">' . __( 'Pages:', 'abomb' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>'
				));
		?>
		<div class="entry-meta-below-content">
			<p>Article published by <?php the_author($idd); ?> on <?php the_date(); ?>.</p>
			<?php edit_post_link( __( 'Edit', 'abomb' ), '<span class="edit-link">', '</span>' ); ?>
			<div class="below-article-ads">
				<?php echo mongabay_adsense_show('featured-below'); ?>
			</div>
		</div>
	</div>
</div>