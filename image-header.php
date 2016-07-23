<?php
$image_id = get_the_ID();
// set up browsing gallery 
if (!empty($_GET['gallery'])) {
	$terms = explode('/',strtolower(trim($_GET['gallery'])),2);
	if (($terms[1])=='highlights') {
		$hterms = get_terms(array('topic','location'), array('slug' => $terms[0]));
		if ($hterms) {
			$hterm = reset($hterms);
			$gterms = array($hterm);
			$gtitle = $hterm->name . ' ' . __('Highlights','mongabay-theme'); 
			$in_gallery = mongabay_is_image_in_gallery($image_id,array($hterm));
		}
	} else {
		$topics = get_terms('topic', array('slug' => $terms[0]));
		$locations = get_terms('location', array('slug' => $terms[1]));
		if ($topics && $locations) {
			$topic = reset($topics);
			$location = reset($locations);
			$gterms = array($topic,$location);
			$gtitle = $location->name . ' ' . $topic->name;
			$in_gallery = mongabay_is_image_in_gallery($image_id,array($topic,$location));
		}
	}
}

// not set yet, set default
if (empty($_GET['gallery']) || (empty($hterms) && (empty($topic) || empty($location))) || empty($in_gallery)) {
	
	$locations =  wp_get_object_terms($image_id, 'location' , array('orderby' => 'count', 'order' => 'DESC'));
	$topics =  wp_get_object_terms($image_id, 'topic' , array('orderby' => 'count', 'order' => 'DESC'));
	$location = reset($locations);
	$topic = reset($topics);
	if (empty($location) || empty($topic))  {
		if (empty($location)) { 
			$gterms = array($topic);
			$gtitle = $topic->name . ' ' . __('Highlights','mongabay-theme'); 
			$_GET['gallery'] =  $topic->slug . '/highlights';
		}
		
		if (empty($topic)) { 
			$gterms = array($location);
			$gtitle = $location->name . ' ' . __('Highlights','mongabay-theme'); 
			$_GET['gallery'] =  $location->slug . '/highlights';
		}
	} else {
		$gterms = array($topic,$location);
		$gtitle = $location->name . ' ' . $topic->name;
		$_GET['gallery'] =  $location->slug . '/' . $topic->slug;
	}
}

$GLOBALS['current_gallery'] = mongabay_images_by_rating($gterms,25,0);
//$GLOBALS['current_gallery_full'] = mongabay_images_by_rating($gterms,-1,0);
$GLOBALS['current_gallery_terms'] = $gterms;
$total = mongabay_images_count($gterms);
$adj = mongabay_adjacent_images($image_id,$gterms);
$next = $adj['next']; $prev = $adj['prev'];

/*foreach ($GLOBALS['current_gallery_full'] as $k=>$g_image) {
	if ($g_image->ID==$image_id) {
		$current_no = $k+1;
		if ($k!=0) $prev = $GLOBALS['current_gallery_full'][$k-1];
		if ($k!=$total-1) $next = $GLOBALS['current_gallery_full'][$k+1];
		break;
	}
}*/

if (mongabay_is_member()) $is_member = true;
else $is_member = false;

?>
<div class="image-header">
	<div class="image-header-left">
    	<div class="headline">
        	<h1 class="image-single-title"><?php echo get_the_title(); ?></h1>
           <?php if (get_field('identified')=='No'): ?><div class="image-single-unidetified"><em><?php _e('Unidentified picture.','mongabay-theme'); ?></em> <?php _e('Do you know what species is the fauna or flora?','mongabay-theme'); ?> <a href="<?php echo mongabay_url('contact','identify&picture='.$picture_id); ?>"><?php _e('Please let us now!','mongabay-theme'); ?></a></div><?php endif; ?>
           <div class="image-single-date">
		    <?php 
			  if (get_field('date_taken') != '19700101') {
				  $imgdate = get_field('date_taken');
				  $imgdate = DateTime::createFromFormat('Ymd', get_field('date_taken'))->format( 'F d, Y' );
			  }
			  else $imgdate = get_the_date();
			  echo $imgdate; 
			?>
           </div>
           <div class="image-single-author">
           <?php 
		   		$astr = __('Photographed by','mongabay-theme').' ';
				$authors =  wp_get_object_terms($image_id, 'author' , array('orderby' => 'count', 'order' => 'DESC'));
				if ($authors) {
					$authors_count = count($authors);
					foreach ($authors as $author) {
						$alinks[] = '<a class="author-link" href="'.mongabay_url('author',$author->slug).'">'.$author->name.'</a>';
					}
					if ($authors_count == 1) {
						echo $astr.reset($alinks);
					} elseif ($authors_count == 2) {
						echo $astr.implode(' & ',$alinks);
					} elseif ($authors_count < 2) echo $astr.implode(', ',$alinks);
				}
			
			?>
           </div>
        </div>
        <div class="image-single <?php echo $is_member?'image-single-member':''; ?>">
        <?php 
		 $img =  get_post_meta(get_the_ID(),'image-url-large',true); 
		 if (!$img)  $img = get_post_meta(get_the_ID(),'image-url-medium',true); 
		 ?>
        	<img src="<?php echo $img; ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" />
        </div>
        <div class="image-awrap">
        	<?php echo mongabay_adsense_show('image-under'); ?>
		 </div>
    </div>
    <div class="image-header-right">
    	<div class="image-single-nav">
        	<h3><em><?php _e('Current Gallery','mongabay-theme'); ?></em> <?php echo $gtitle; ?></h3>
           <div class="image-single-nav-prev">
           	<?php if (!empty($prev)): $link = get_permalink($prev->ID).'?gallery='.$_GET['gallery']; ?>
            	<a class="images-nav-item" href="<?php echo $link; ?>">
                	<img class="image-thumb" src="<?php echo mongabay_sanitize_image_url(get_post_meta( $prev->ID, 'image-url-thumb', true)); ?>" style="max-width: 145px; max-height: 97px" />
                  <div class="image-single-nav-label"><?php _e('Previous Image','mongabay-theme'); ?></div>
                  <h6 class="image-single-nav-title"><?php echo get_the_title( $prev->ID ); ?></h6>
              </a>
            	<?php endif; ?>
           </div>
           <div class="image-single-nav-next">
           	<?php if (!empty($next)): $link = get_permalink($next->ID).'?gallery='.$_GET['gallery']; ?>
            	<a class="images-nav-item" href="<?php echo $link; ?>">
                	<img class="image-thumb" src="<?php echo  mongabay_sanitize_image_url(get_post_meta( $next->ID, 'image-url-thumb', true)); ?>" style="max-width: 145px; max-height: 97px" />
                  <div class="image-single-nav-label"><?php _e('Next Image','mongabay-theme'); ?></div>
                  <h6 class="image-single-nav-title"><?php echo get_the_title( $next->ID ); ?></h6>
              </a>
            	<?php endif; ?>
           </div>
           <div class="image-single-nav-meta">
           	<?php _e('Image','mongabay-theme'); ?> <strong><?php echo $adj['pos']; ?></strong> <?php _e('of','mongabay-theme'); ?> <strong><?php echo $total; ?></strong> 
           </div>
           <a href="<?php echo mongabay_url('gallery',explode('/',$_GET['gallery'])); ?>" class="button button-gallery"><?php _e('See whole gallery','mongabay-theme'); ?></a>
        </div>
        <div class="image-single-buy">
        	<?php if (get_field('for_sale', $image_id)=='Yes'): 
			 // camera model and link
			 if ($camera=get_field('camera', $image_id)) {
				 if ($cameralink = get_field('camera_link', $image_id)) {
					 $cameraline = '<a href="'.$cameralink.'">'.$camera.'</a>';
				 } else $cameraline = $camera;
			 } else $cameraline = "";
			 
			 // resolution 
			 if ( ! $resolution = get_post_meta($image_id,'full_resolution',true)) {
				 $file = mongabay_aws_get_image_from_url(mongabay_aws_connect(),get_post_meta($image_id,'image-url-full',true));
				 $imagesize = getimagesize($file);				 
				 $resolution = $imagesize[0].' x '.$imagesize[1].' px ('.round($imagesize[0]*$imagesize[1]/1000000,2).'MP)';
				 add_post_meta($image_id,'full_resolution',$resolution);
				 unlink($file);
			 }
			 // format
			 $path_parts = pathinfo(get_post_meta($image_id,'image-url-full',true));
			 $format = strtoupper($path_parts['extension']);
			?>
              <h3><?php _e('<em>Purchase</em> Image','mongabay-theme'); ?></h3>
              <p><?php _e('For royalty-free and personal user only.','mongabay-theme'); ?></p>
				<div class="image-single-buy-stats">
                	<div><span><?php _e('Resoultion','mongabay-theme'); ?>: </span><?php echo $resolution; ?></div>
                  <div><span><?php _e('Camera','mongabay-theme'); ?>: </span><?php echo $cameraline; ?></div>
                  <div><span><?php _e('Format','mongabay-theme'); ?>: </span><?php echo $format; ?></div>
               </div>
			
           <div class="image-single-buy-cart">
           <?php
		    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", 'image_single' ) );
			$product = new WC_Product( $product_id );
			?>
           	<span class="price"><?php echo $product->get_price_html(); ?></span> <?php _e('per picture','mongabay-theme'); ?>
            	<a class="button button-purchase" href="<?php echo mongabay_url('cart',$product_id.'&picture='.$image_id); ?>"><?php _e('Purchase','mongabay-theme'); ?></a>
           </div>
           <p><?php _e('Interested in commercial usage, re-publishment or extensive amount of images?','mongabay-theme'); ?> <a href="<?php echo mongabay_url('contact','image-rights'); ?>"><?php _e('Contact Us','mongabay-theme'); ?>.</a></p>
           <?php else: echo mongabay_adsense_show('image-buy'); endif; ?>
        </div>
    </div>
</div>

<?php if ($is_member):
$img_exp = get_post_meta(get_the_ID(),'image-url-xlarge',true); 
?><div id="image-single-member-expanded"><img src="<?php echo $img_exp; ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" /></div>
<?php endif;

