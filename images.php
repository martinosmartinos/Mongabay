<?php
$sec = get_query_var('section');
$c1 = get_query_var('nc1');
$c2 = get_query_var('nc2');
$sclass = "";
$GLOBALS['sidebar_layout'] = 'right';

$fav_topics = array('wildlife','people','rainforests','animals','birds','mammals','scenery','aerial','deforestation');
$fav_locations = array('indonesia','malaysia','madagascar','costa-rica','colombia','peru','united-states','australia','laos');

if (!$sec && !$c1) {
	$sclass = 'images-page-all-topic';
	$htitle = __('Photography','mongabay-theme');
	$GLOBALS['images_header'] = mongabay_images_head('general');
} elseif ($sec=='countries' && !$c1) {
	$sclass = 'images-page-all-location';
	$htitle = __('Images by Country','mongabay-theme');
	$GLOBALS['images_header'] = mongabay_images_head('general-c');
} elseif ($sec=='gallery' && $c1 && !$c2) {
	if ($items = get_terms(array('topic','location'), array('slug' => $c1))) {
		$term = reset($items);		
		$sclass = 'images-page-galleries images-page-galleries-'.$term->taxonomy;
		$htitle = $term->name . ' ' . __('Galleries','mongabay-theme');
		$GLOBALS['images_header'] = mongabay_images_head($term->taxonomy,$term);
		}
	else $redirect= mongabay_prot().'images.'.mongabay_domain();
} elseif ($sec=='gallery' && $c1 && $c2) {
	if ($c2 == 'highlights') {
		if ($items = get_terms(array('topic','location'), array('slug' => $c1))) {
			$hterm = reset($items);	
			$htitle = $hterm->name . ' ' . __('Highlights','mongabay-theme');
			$sclass = 'images-page-highlights';
			$GLOBALS['images_header'] = mongabay_images_head('highlights',$hterm);
			}
		else $redirect= mongabay_prot().'images.'.mongabay_domain();	
		
	} else {
		$topics = get_terms('topic', array('slug' => $c1));
		$locations = get_terms('location', array('slug' => $c2));
		if ($topics && $locations) {
			$topic= reset($topics);
			$location= reset($locations);	
			$htitle = $location->name . ' ' . $topic->name .' '. __('Gallery','mongabay-theme');
			$GLOBALS['images_header'] = mongabay_images_head('gallery',array($topic,$location));
		}
		else $redirect= mongabay_prot().'images.'.mongabay_domain();

	}
}

if (!empty($redirect)) {
	echo '<script type="text/javascript">window.stop(); window.location.replace(\''.$redirect.'\');</script>';
	exit;
}

/* Set custom title */
if (!empty($htitle)) {
	global $header_title;
	$header_title = $htitle;
	$htitle_func =  function($title, $sep) { global $header_title; return $header_title.' '.$sep.' '.get_bloginfo( 'name', 'display' ); };
	add_filter( 'wp_title', $htitle_func, 10, 2 );
}

?>
<?php get_header(); ?>
<div id="section-images-wrap" class="<?php echo $sclass; ?>">

<?php if (!$sec && !$c1): // ALL IMAGES BY TOPIC / IMAGES LANDING PAGE ?>
	<div class="images-block images-block-favorites">
    	<h3 class="images-block-title"><?php _e('Our Favorite <em>Topics</em>','mongabay-theme'); ?></h3>
  		<div class="images-block-body">
		   <?php 
          foreach ($fav_topics as $topic_slug):
            	$topic = get_term_by('slug', $topic_slug, 'topic');
				if (empty($topic)) continue;
				?>
               <a class="images-item" href="<?php echo mongabay_url('topic-image',$topic->slug); ?>">
               	 <?php echo mongabay_term_image($topic); ?>
                   <h4><?php echo $topic->name; ?></h4> 
                   <p><?php echo wp_trim_words( $topic->description, 14); ?></p>
               </a>
          <?php endforeach; ?>
		</div>
	</div>
    <div class="images-block images-block-others">
    	<h6><?php _e('Want to browse our image database by location instead ?','mongabay-theme'); ?></h6>
       <p><?php _e('Like') ?> '<a href="<?php echo mongabay_url('topic-image','madagascar') ?>" ><?php _e('Madagascar','mongabay-theme') ?></a>', '<a href="<?php echo mongabay_url('topic-image','indonesia') ?>" ><?php _e('Indonesia','mongabay-theme') ?></a>' <?php _e('or','mongabay-theme') ?> '<a href="<?php echo mongabay_url('topic-image','peru') ?>" ><?php _e('Peru','mongabay-theme') ?></a>' ?</p>
       <a class="button button-location" href="<?php echo mongabay_url('images-by-location'); ?>"><?php _e('Browse images by location','mongabay-theme'); ?></a>
       <?php echo mongabay_adsense_show('images-listing-1'); ?>
    </div>
    <div class="images-block images-block-list">
    	<h3 class="images-block-title"><?php _e('All other <em>Topics</em>','mongabay-theme'); ?></h3>
  		<div class="images-block-body">
		   <?php 
		   $topics = array_diff(mongabay_get_terms_post_type('topic','image'),$fav_topics);
          foreach ($topics as $topic_slug):
            	$topic = get_term_by('slug', $topic_slug, 'topic');
				if ($item_image = mongabay_term_image($topic,145)):
				?>
               <a class="images-item" href="<?php echo mongabay_url('topic-image',$topic->slug); ?>">
               	 <?php echo $item_image; ?>
                   <h5><?php echo $topic->name; ?></h5> 
               </a>
          <?php endif; endforeach; ?>
		</div>
	</div>
    <div class="images-block images-block-others">
    	<h6><?php _e('Want to browse our image database by location instead ?','mongabay-theme'); ?></h6>
       <p><?php _e('Like') ?> '<a href="<?php echo mongabay_url('topic-image','madagascar') ?>" ><?php _e('Madagascar','mongabay-theme') ?></a>', '<a href="<?php echo mongabay_url('topic-image','indonesia') ?>" ><?php _e('Indonesia','mongabay-theme') ?></a>' <?php _e('or','mongabay-theme') ?> '<a href="<?php echo mongabay_url('topic-image','peru') ?>" ><?php _e('Peru','mongabay-theme') ?></a>' ?</p>
       <a class="button button-location" href="<?php echo mongabay_url('images-by-location'); ?>"><?php _e('Browse images by location','mongabay-theme'); ?></a>
       <?php echo mongabay_adsense_show('images-listing-2'); ?>
    </div>
    
<?php elseif ($sec=='countries' && !$c1): // ALL IMAGES BY LOCATION ?>
	<div class="images-block images-block-favorites">
    	<h3 class="images-block-title"><?php _e('Our Favorite <em>Places</em>','mongabay-theme'); ?></h3>
  		<div class="images-block-body">
		   <?php 
          foreach ($fav_locations as $location_slug):
            	$location = get_term_by('slug', $location_slug, 'location');
				if (empty($location)) continue;
				?>
               <a class="images-item" href="<?php echo mongabay_url('location-image',$location->slug); ?>">
               	 <?php echo mongabay_term_image($location); ?>
                   <h4><?php echo $location->name; ?></h4> 
                   <p><?php echo wp_trim_words( $location->description, 14); ?></p>
               </a>
          <?php endforeach; ?>
		</div>
	</div>
    <div class="images-block images-block-others">
    	<h6><?php _e('Want to browse our image database by topic instead ?','mongabay-theme'); ?></h6>
       <p><?php _e('Like') ?> '<a href="<?php echo mongabay_url('location-image','animals') ?>" ><?php _e('Animals','mongabay-theme') ?></a>', '<a href="<?php echo mongabay_url('topic-image','scenery') ?>" ><?php _e('Scenery','mongabay-theme') ?></a>' <?php _e('or','mongabay-theme') ?> '<a href="<?php echo mongabay_url('topic-image','people') ?>" ><?php _e('People','mongabay-theme') ?></a>' ?</p>
       <a class="button button-topic" href="<?php echo mongabay_url('images'); ?>"><?php _e('Browse images by topic','mongabay-theme'); ?></a>
       <?php echo mongabay_adsense_show('images-listing-1'); ?>
    </div>
    <div class="images-block images-block-list">
    	<h3 class="images-block-title"><?php _e('All other <em>Places</em>','mongabay-theme'); ?></h3>
  		<div class="images-block-body">
		   <?php 
		   $locations = array_diff(mongabay_get_terms_post_type('location','image'),$fav_locations);
          foreach ($locations as $location_slug):
            	$location = get_term_by('slug', $location_slug, 'location');
				if ($item_image = mongabay_term_image($location,145)):
				?>
               <a class="images-item" href="<?php echo mongabay_url('location-image',$location->slug); ?>">
               	 <?php echo $item_image; ?>
                   <h5><?php echo $location->name; ?></h5> 
               </a>
          <?php endif; endforeach; ?>
		</div>
	</div>
   <div class="images-block images-block-others">
    	<h6><?php _e('Want to browse our image database by topic instead ?','mongabay-theme'); ?></h6>
       <p><?php _e('Like') ?> '<a href="<?php echo mongabay_url('location-image','animals') ?>" ><?php _e('Animals','mongabay-theme') ?></a>', '<a href="<?php echo mongabay_url('topic-image','scenery') ?>" ><?php _e('Scenery','mongabay-theme') ?></a>' <?php _e('or','mongabay-theme') ?> '<a href="<?php echo mongabay_url('topic-image','people') ?>" ><?php _e('People','mongabay-theme') ?></a>' ?</p>
       <a class="button button-topic" href="<?php echo mongabay_url('images'); ?>"><?php _e('Browse images by topic','mongabay-theme'); ?></a>
       <?php echo mongabay_adsense_show('images-listing-2'); ?>
   </div>  
<?php elseif (!empty($term)): // FIRST LEVEL GALLERY ?>
	<div class="images-block images-block-highlights">
  		<div class="images-block-body">
		   <?php 
		   $items = mongabay_images_by_rating($term,4);
		   $big_item = array_shift($items);
		   ?>
          <a class="images-highlight-blocklink" href="<?php echo mongabay_url('gallery',array($term->slug,'highlights')); ?>">
           <div class="term-image term-image-300"><img class="images-higlight-large" src="<?php echo get_post_meta( $big_item->ID, 'image-url-medium', true); ?>" style="max-width: 300px; max-height: 200px" /></div>
           <div class="images-highlight-title-wrap">
           	<h3 class="images-block-title"><?php echo $term->name; ?> <em><?php _e('Highlights','mongabay-theme'); ?></em></h3>
           	<p><i><?php _e('See the hand-picked gallery of best ','mongabay-theme'); ?> <?php echo $term->name; ?> <?php _e('shots!','mongabay-theme'); ?></i></p>
           </div>
           <?php foreach ($items as $item): ?>
           <img class="images-higlight-small" src="<?php echo get_post_meta( $item->ID, 'image-url-thumb', true); ?>" style="max-width: 150px; max-height: 100px" />
           <?php endforeach; ?>
           </a>
          
		  
		</div>
	</div>
   <div class="images-block images-block-galleries">
    	<h3 class="images-block-title"><?php echo $term->name; ?> <em><?php _e(($term->taxonomy=='location'?'Topics':'Around the world'),'mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
		   if ($term->taxonomy=='location') $get = 'topic'; else $get = 'location';
		   $items = mongabay_get_terms_combined( $get, $term );
          foreach ($items as $item_slug):
            	$item = get_term_by('slug', $item_slug, $get);
				if ($item_image = mongabay_term_image(array($item,$term))):
				
				  if ($get=='topic') $url = mongabay_url('gallery',array($item->slug,$term->slug));
				  else $url = mongabay_url('gallery',array($term->slug,$item->slug));
				?>
               <a class="images-item" href="<?php echo $url; ?>">
               	 <?php echo $item_image; ?>
                   <h5><?php echo $item->name; ?></h5> 
               </a>
          <?php endif; endforeach; ?>
         <div class="images-galleries-ads">
           <?php echo mongabay_adsense_show('images-listing-1'); ?>
           <?php echo mongabay_adsense_show('images-listing-2'); ?>
         </div>
		</div>
	</div>
	<div class="images-block images-block-news block-seven">
    	<h3 class="images-block-title"><?php echo $term->name; ?> <em><?php _e('News','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php
		   $args=array(
			'post_type' 			=> 	'post',
			'tax_query' => array(
				array(
					'taxonomy' => $term->taxonomy,
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				),
				
			),
			'posts_per_page'		=>	3, 
			);
			
			$related = new WP_Query($args); 
			if($related->have_posts() && $related->found_posts >= 1):
				while($related->have_posts()): $related->the_post();
					$atts = array (
								'align' 					=> 'default',
								'column' 				    => 'grid-4',
								'thumb' 					=> 'medium',
								'thumb_size'				=> '250x166',
								'video' 					=> rd_field( 'abomb_post_video' ),
								'audio' 					=> rd_field( 'abomb_post_audio' ),
								'gallery' 					=>  rd_field( 'abomb_post_gallery' ),
								'first_cat' 				=> 'no',
								'excerpt' 					=> '',
								'star' 						=> 'yes',
							);
					block_grid_content($atts);
				endwhile;
			endif;
		   ?>
           <div class="links" style="clear: both;">
       			<a class="button button-news" href="<?php echo mongabay_url($term->taxonomy,$term->slug); ?>"><?php _e('See all','mongabay-theme'); ?> <?php echo $term->name; ?> <?php _e('News','mongabay-theme'); ?></a>
           </div>
		</div>
	</div> 
   <?php /* <div class="images-block images-block-similar">
    	<h3 class="images-block-title"><?php _e('Similar <em>'.($term->taxonomy=='location'?'Locations':'Topics').'</em>','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
		   $similars = mongabay_get_similar_tags($term);
		   foreach ($similars as $sim): ?>
			   <a class="images-item" href="<?php echo mongabay_url('topic-image',$sim->slug); ?>">
               	 <?php echo mongabay_term_image($sim); ?>
                   <h4><?php echo $sim->name; ?></h4> 
                   <p><?php echo wp_trim_words( $sim->description, 14); ?></p>
               </a>
		   <?php endforeach; ?>
          <div class="links" style="clear: both;">
          		<?php if ($term->taxonomy=='topic'): ?>
       			<a class="button button-topic" href="<?php echo mongabay_url('images'); ?>"><?php _e('See more topics','mongabay-theme'); ?></a>
              <?php else: ?>
              <a class="button button-location" href="<?php echo mongabay_url('images-by-location'); ?>"><?php _e('See more locations','mongabay-theme'); ?></a>

              <?php endif; ?>
           </div>
		</div> 
	</div> */ ?>
<?php elseif (!empty($hterm)): // HIGHLIGHTS ?>
	<div class="images-block images-block-best">
    	<h3 class="images-block-title"><?php echo $hterm->name; ?> <em><?php _e('Best Pictures','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
         	$items = mongabay_images_by_rating($hterm,9);
			foreach ($items as $item): 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$hterm->slug.'/highlights'; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-250"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-medium', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 250px; max-height: 166px" /></div>
                   <h6><?php echo $title; ?></h6> 
               </a>
				
			<?php endforeach; ?>
		</div>
	</div>
   <div class="images-block images-block-all">
    	<h3 class="images-block-title"><?php echo $hterm->name; ?> <em><?php _e('All Shots','mongabay-theme'); ?></em><p class="images-list-count"><i><strong><?php echo mongabay_images_count(array($hterm)); ?></strong> <?php _e('Images in total','mongabay-theme'); ?>.</i></p></h3>
  		<div class="images-block-body">
		   <?php $items = mongabay_images_by_rating($hterm,25,0); 
			foreach ($items as $item) { 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$hterm->slug.'/highlights'; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-145"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-thumb', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 145px; max-height: 97px" /></div>
                   <h6><?php echo $title; ?></h6> 
               </a>
				 
			<?php } ?>
		</div>
       <div class="button button-load button-load-images" data-start="25", data-<?php echo $hterm->taxonomy; ?>="<?php echo $hterm->slug; ?>" data-append=".images-block-all .images-block-body" ><?php _e('Load More Images','mongabay-theme'); ?></div>
	</div>
    <?php /* <div class="images-block images-block-similar">
    	<h3 class="images-block-title"><?php _e('Similar <em>'.($hterm->taxonomy=='topic'?'Topics':'Locations').'</em>','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
		   $similars = mongabay_get_similar_tags($hterm);
		   foreach ($similars as $sim): ?>
			   <a class="images-item" href="<?php echo mongabay_url('gallery',$hterm->slug); ?>">
               	 <?php echo mongabay_term_image($sim); ?>
                   <h4><?php echo $sim->name; ?></h4> 
                   <p><?php echo wp_trim_words( $sim->description, 14); ?></p>
               </a>
		   <?php endforeach; ?>
          <div class="links" style="clear: both;">
              <?php if ($hterm->taxonomy=='topic'): ?>
       			<a class="button button-topic" href="<?php echo mongabay_url('images'); ?>"><?php _e('See more topics','mongabay-theme'); ?></a>
              <?php else: ?>
              <a class="button button-location" href="<?php echo mongabay_url('images-by-location'); ?>"><?php _e('See more locations','mongabay-theme'); ?></a>

              <?php endif; ?>
           </div>
		</div>
	</div> */ ?>
	<div class="images-block images-block-news block-seven">
    	<h3 class="images-block-title"><?php echo $hterm->name; ?> <em><?php _e('News','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php
		   $args=array(
			'post_type' 			=> 	'post',
			'tax_query' => array(
				array(
					'taxonomy' => $hterm->taxonomy,
					'field'    => 'term_id',
					'terms'    => $hterm->term_id,
				),
				
			),
			'posts_per_page'		=>	3, 
			);
			
			$related = new WP_Query($args); 
			if($related->have_posts() && $related->found_posts >= 1):
				while($related->have_posts()): $related->the_post();
					$atts = array (
								'align' 					=> 'default',
								'column' 				    => 'grid-4',
								'thumb' 					=> 'medium',
								'thumb_size'				=> '250x166',
								'video' 					=> rd_field( 'abomb_post_video' ),
								'audio' 					=> rd_field( 'abomb_post_audio' ),
								'gallery' 					=>  rd_field( 'abomb_post_gallery' ),
								'first_cat' 				=> 'no',
								'excerpt' 					=> '',
								'star' 						=> 'yes',
							);
					block_grid_content($atts);
				endwhile;
			endif;
		   ?>
           <div class="links" style="clear: both;">
       			<a class="button button-news" href="<?php echo mongabay_url($hterm->taxonomy,$hterm->slug); ?>"><?php _e('See all','mongabay-theme'); ?> <?php echo $hterm->name; ?> <?php _e('News','mongabay-theme'); ?></a>
           </div>
		</div>
	</div> 
<?php elseif (!empty($topic) && !empty($location)): // GALLERY PAGES ?>
	<div class="images-block images-block-best">
    	<h3 class="images-block-title"><?php echo $location->name; ?> <?php echo $topic->name; ?> <em><?php _e('Best Pictures','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
         	$items = mongabay_images_by_rating(array($topic,$location),9);
			foreach ($items as $item): 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$topic->slug.'/'.$location->slug; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-250"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-medium', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 250px; max-height: 166px" /></div>
                   <h6><?php echo $title; ?></h6> 
               </a>
				
			<?php endforeach; ?>
		</div>
	</div>
    <div class="images-block images-block-all">
    	<h3 class="images-block-title"><?php echo $location->name; ?> <?php echo $topic->name; ?> <em><?php _e('All Shots','mongabay-theme'); ?></em><p class="images-list-count"><i><strong><?php echo mongabay_images_count(array($topic,$location)); ?></strong> <?php _e('Images in total','mongabay-theme'); ?>.</i></p></h3>
  		<div class="images-block-body">
		   <?php $items = mongabay_images_by_rating(array($topic,$location),25,0); ?>
			<?php
			foreach ($items as $item): 
				$title = get_the_title($item->ID);
				$link = get_permalink($item->ID).'?gallery='.$topic->slug.'/'.$location->slug; 
				?>
				<a class="images-item" href="<?php echo $link; ?>">
               	 <div class="images-item-image images-item-image-250"><img class="image-thumb" src="<?php echo get_post_meta( $item->ID, 'image-url-thumb', true); ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="max-width: 145px; max-height: 97px" /></div>
                   <h6><?php echo $title; ?></h6> 
               </a>
				
			<?php endforeach; ?>
		</div>
       <div class="button button-load button-load-images" data-start="25", data-topic="<?php echo $topic->slug; ?>" data-location="<?php echo $location->slug; ?>" data-append=".images-block-all .images-block-body" ><?php _e('Load More Images','mongabay-theme'); ?></div>
	</div>
    <?php /*<div class="images-block images-block-similar">
    	<h3 class="images-block-title"><?php echo $location->name; ?> <?php _e('Similar <em>Topics</em>','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
		   $similars = mongabay_get_similar_tags($topic);
		   foreach ($similars as $sim): ?>
			   <a class="images-item" href="<?php echo mongabay_url('gallery',array($sim->slug,$location->slug)); ?>">
               	 <?php echo mongabay_term_image($sim); ?>
                   <h4><?php echo $sim->name; ?></h4> 
                   <p><?php echo wp_trim_words( $sim->description, 14); ?></p>
               </a>
		   <?php endforeach; ?>
          <div class="links" style="clear: both;">
              <a class="button button-gallery" href="<?php echo mongabay_url('location',$location->slug); ?>"><?php _e('See all','mongabay-theme'); ?> <?php echo $location->name; ?> <?php _e('galleries','mongabay-theme'); ?></a>
           </div>
		</div>
	</div> */ ?>
	<div class="images-block images-block-news block-seven">
    	<h3 class="images-block-title"><?php echo $location->name; ?> <em><?php _e('News','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php
		   $args=array(
			'post_type' 			=> 	'post',
			'tax_query' => array(
				array(
					'taxonomy' => $location->taxonomy,
					'field'    => 'term_id',
					'terms'    => $location->term_id,
				),
				
			),
			'posts_per_page'		=>	3, 
			);
			
			$related = new WP_Query($args); 
			if($related->have_posts() && $related->found_posts >= 1):
				while($related->have_posts()): $related->the_post();
					$atts = array (
								'align' 					=> 'default',
								'column' 				    => 'grid-4',
								'thumb' 					=> 'medium',
								'thumb_size'				=> '250x166',
								'video' 					=> rd_field( 'abomb_post_video' ),
								'audio' 					=> rd_field( 'abomb_post_audio' ),
								'gallery' 					=>  rd_field( 'abomb_post_gallery' ),
								'first_cat' 				=> 'no',
								'excerpt' 					=> '',
								'star' 						=> 'yes',
							);
					block_grid_content($atts);
				endwhile;
			endif;
		   ?>
           <div class="links" style="clear: both;">
       			<a class="button button-news" href="<?php echo mongabay_url($location->taxonomy,$location->slug); ?>"><?php _e('See all','mongabay-theme'); ?> <?php echo $location->name; ?> <?php _e('News','mongabay-theme'); ?></a>
           </div>
		</div>
	</div> 
	<?php /* <div class="images-block images-block-similar">
    	<h3 class="images-block-title"><?php _e('Similar <em>Locations</em>','mongabay-theme'); ?></em></h3>
  		<div class="images-block-body">
		   <?php 
		   $similars = mongabay_get_similar_tags($location);
		   foreach ($similars as $sim): ?>
			   <a class="images-item" href="<?php echo mongabay_url('topic-image',$sim->slug); ?>">
               	 <?php echo mongabay_term_image($sim); ?>
                   <h4><?php echo $sim->name; ?></h4> 
                   <p><?php echo wp_trim_words( $sim->description, 14); ?></p>
               </a>
		   <?php endforeach; ?>
          <div class="links" style="clear: both;">
              <a class="button button-location" href="<?php echo mongabay_url('images-by-location'); ?>"><?php _e('See more locations','mongabay-theme'); ?></a>
           </div>
		</div>
	</div> */ ?>
<?php endif; // end of pages ?>
</div>
<?php get_footer(); ?>