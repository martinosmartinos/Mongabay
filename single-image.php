<?php get_header(); ?>
<?php 
$gal = $GLOBALS['current_gallery'];
$terms = $GLOBALS['current_gallery_terms'];
if (count($terms)==1) $title = $terms[0]->name . ' '.  __('Highlights','mongabay-theme');
else $title = $terms[0]->name . ' ' . $terms[1]->name;

?>       
              
<div class="single-content block-page">
<?php
/*if (!get_queried_object()) {
	$post_id = intval(get_query_var('nc1'));
	if (empty($post_id)) $redirect= mongabay_prot().'images.'.mongabay_domain();
	else {
		$query = new WP_Query( 'p='.$post_id.'&post_type=image' );
		if (!$query->have_posts()) $redirect= mongabay_prot().'images.'.mongabay_domain();
	}
	if (!empty($redirect)) {
		echo '<script type="text/javascript">window.stop(); window.location.replace(\''.$redirect.'\');</script>';
		exit;
	}	
	$query->the_post();
}*/
if (have_posts()) : while (have_posts()) : the_post(); 
?>
<div class="entry-content">
   <?php mongabay_sharebox(get_the_ID()); ?>
   
    <div class="images-block images-block-all">
    	<h3 class="images-block-title"><?php echo $title; ?> <em><?php _e('Gallery','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
			<?php
			foreach ($gal as $item): 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$_GET['gallery']; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-145"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-thumb', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 145px; max-height: 97px" />
                   <h6><?php echo $title; ?></h6></div>
               </a>
				
			<?php endforeach; ?>
		</div>
       <div class="links" style="clear: both;">
       		  <div class="button button-load button-load-images" data-start="25" data-<?php echo $terms[0]->taxonomy; ?>="<?php echo $terms[0]->slug; ?>" <?php echo empty($terms[1])?'':('data-'.$terms[1]->taxonomy.'="'.$terms[1]->slug.'"'); ?> data-append=".images-block-all .images-block-body" ><?php _e('Load More Images','mongabay-theme'); ?></div>
              
            <a class="button button-gallery" href="<?php echo mongabay_url('gallery',explode('/',$_GET['gallery'])); ?>"><?php _e('See Whole Gallery','mongabay-theme'); ?></a>
             <?php echo mongabay_adsense_show('images-listing-1'); ?>
      </div>
      
	</div>
<?php if (count($terms)==2): ?>
	<div class="images-block images-block-best">
    	<h3 class="images-block-title"><?php echo $terms[0]->name; ?> <em><?php _e('Best Pictures','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
         	$items = mongabay_images_by_rating($terms[0],6);
			foreach ($items as $item): 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$_GET['gallery']; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-250"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-medium', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 250px; max-height: 166px" />
                   <h6><?php echo $title; ?></h6></div>
               </a>
       
			<?php endforeach; ?>
		</div>
       <div class="links" style="clear: both;">
          <a class="button button-gallery" href="<?php echo mongabay_url('topic-image',$terms[0]->slug); ?>"><?php echo __('See All','mongabay-theme') . ' ' .  $terms[0]->name . ' ' . __('Images','mongabay-theme'); ?></a>
      </div>
	</div>
    <div class="images-block images-block-best">
    	<h3 class="images-block-title"><?php echo $terms[1]->name; ?> <em><?php _e('Best Pictures','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
         	$items = mongabay_images_by_rating($terms[1],6);
			foreach ($items as $item): 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$_GET['gallery']; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-250"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-medium', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 250px; max-height: 166px" />
                   <h6><?php echo $title; ?></h6></div>
               </a>
				
			<?php endforeach; ?>
		</div>
        <div class="links" style="clear: both;">
          <a class="button button-gallery" href="<?php echo mongabay_url('topic-image',$terms[1]->slug); ?>"><?php echo __('See All ','mongabay-theme') . ' ' . $terms[1]->name . ' ' . __('Images','mongabay-theme'); ?></a>
           <?php echo mongabay_adsense_show('images-listing-2'); ?>
      </div>
	</div>
    
<?php endif; ?>

</div>
<?php endwhile; wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>	