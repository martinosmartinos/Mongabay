<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

if ( ! function_exists( 'block_grid_first_cat' ) ) {
	function block_grid_first_cat() {
		$categories = get_the_category();
		if ($categories) {
			return '<span class="meta-cat"><a href="' . esc_url(get_category_link( $categories[0]->term_id )) . '" title="'. esc_attr($categories[0]->name) . '">' . $categories[0]->name.'</a></span>';
		}
	}
}
if ( ! function_exists( 'content_first_cat' ) ) {
	function content_first_cat($star) {
		$rev_position = rd_field( 'abomb_review_position', get_the_ID() );
		if($rev_position == 'disable' || $rev_position=='') {
			$categories = get_the_category();
			if ($categories) {
				return '<span class="meta-cat"><a href="' . esc_url(get_category_link( $categories[0]->term_id )) . '" title="'. esc_attr($categories[0]->name) . '">' . $categories[0]->name.'</a></span>';
			}
		}
	}
}
if ( ! function_exists( 'content_small_date' ) ) {
	function content_small_date($star) {
		$rev_position = rd_field( 'abomb_review_position', get_the_ID() );
		if($rev_position == 'disable' || $rev_position=='') {
			return '<span class="meta-date">'.get_the_date('jS F Y').'</span>';
		}
	}
}
if ( ! function_exists( 'content_star' ) ) {
	function content_star() {
		$rev_position = rd_field( 'abomb_review_position', get_the_ID() );
		if($rev_position == 'top' || $rev_position == 'bottom' || $rev_position == 'custom') {
			return abomb_review_loop('star', 'abomb_review_criteria');
		}
	}
}
if ( ! function_exists( 'content_cat' ) ) {
	function content_cat() {
		return '<span class="meta-cat">'.get_the_category_list(' / ').'</span>';
	}
}
if ( ! function_exists( 'content_meta_date' ) ) {
	function content_meta_date() {
		return '<time itemprop="dateCreated datePublished" class="meta-date updated"  datetime="' . esc_attr(date(DATE_W3C, get_the_time('U'))) . '">' .get_the_date('M d'). '</time>';
	}
}
if ( ! function_exists( 'content_meta_complete_date' ) ) {
	function content_meta_complete_date() {
		return '<time itemprop="dateCreated datePublished" class="meta-date updated"  datetime="' . esc_attr(date(DATE_W3C, get_the_time('U'))) . '">' .get_the_date('jS F Y'). '</time>';
	}
}
if ( ! function_exists( 'content_meta_clock' ) ) {
	function content_meta_clock() {
		return '<time itemprop="dateCreated datePublished" class="meta-clock updated"  datetime="' . esc_attr(date(DATE_W3C, get_the_time('U'))) . '">' .get_the_date('g:i A T'). '</time>';
	}
}
if ( ! function_exists( 'content_meta_views' ) ) {
	function content_meta_views() {
		if (function_exists('the_views')) {
			return '<span class="meta-views">' .the_views(). '</span>';
		} 
		else {
			return '<span class="meta-views">' .getPostViews(get_the_ID()). '</span>';
		}
	}
}
if ( ! function_exists( 'content_meta_twitter' ) ) {
	function content_meta_twitter() {
		if(get_the_author_meta( 'twitter' )) {
			return '<span class="meta-twitter"><a href="//twitter.com/'.esc_attr(get_the_author_meta( 'twitter' )).'" target="_blank">@' .get_the_author_meta( 'twitter' ). '</a></span>';
		}
	}
}
if ( ! function_exists( 'fb_comment_count' ) ) {
	function fb_comment_count($url) {
		$sanitize = esc_url($url);
		$filecontent = file_get_contents(rd_ssl().'://graph.facebook.com/?ids=' . esc_url($url));
		$json = json_decode($filecontent);
		if (!empty($json->$sanitize->comments)){
			$count = $json->$sanitize->comments;
			if ($count == 0 || !isset($count)) {
				$count = 0;
			}
			return $count;
		}
		else {
			return 0;
		}
	}
}
if ( ! function_exists( 'disqus_embed' ) ) {
	function disqus_embed($disqus_shortname) {
		if($disqus_shortname){
			global $post;
			echo '<div id="disqus_thread"></div>';
			echo '<script type="text/javascript">
				var disqus_shortname = "'.$disqus_shortname.'";
				(function() {
					var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
					dsq.src = "//" + disqus_shortname + ".disqus.com/embed.js";
					(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
				})();
			</script>';
		}
		else{
			echo 'Make sure you have input your "DISQUS SHORTNAME". Go to here <STRONG>Theme Options->General->Disqus Shortname</STRONG>';
		}
	}
}
if ( ! function_exists( 'content_meta_comments' ) ) {
	function content_meta_comments($comment_type = 'facebook', $hastag) {
		$write_comments = '';
		if ($comment_type == 'facebook') {
			$num_comments = fb_comment_count(esc_url(get_permalink( get_the_ID() )));
			if ($hastag == 'yes') {
				$link_comments = get_permalink( get_the_ID() ). '#comments';
			}
			else {
				$link_comments = get_permalink( get_the_ID() );
			}
		}
		else {
			$num_comments = get_comments_number();
			if ($hastag == 'yes') {
				$link_comments = get_comments_link();
			}
			else {
				$link_comments = get_permalink( get_the_ID() );
			}
		}
		if ( comments_open() && $comment_type != 'disqus') {
			if ( $num_comments == 0 ) {
				$comments = __('No Comments','abomb');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . __(' Comments','abomb');
			} else {
				$comments = __('1 Comment','abomb');
			}
				$write_comments = '<span class="meta-comments"><a href="' . esc_url($link_comments) .'">'. $comments.'</a></span>';
		}
		return $write_comments;
	}
}
if ( ! function_exists( 'content_meta_shares' ) ) {
	function content_meta_shares() {
		$out = '';
		$title=urlencode(esc_attr(get_the_title( get_the_ID())));
		$url=urlencode(esc_url(get_permalink( get_the_ID() )));
		$summary=urlencode(get_the_excerpt());
		$imagePinImg=wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large' );
		$imagePin=urlencode(esc_url($imagePinImg[0]));
		$out .= '<span class="meta-shares">';
		
		$out .= '<a href="http://www.facebook.com/share.php?u='.$url.'&amp;title='.$title.'" target="_blank"><i class="fa fa-facebook">Facebook</i></a>';
		
		$out .= '<a href="https://plus.google.com/share?url='.$url.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
		
		$out .= '<a href="http://twitter.com/home?status='.$title.'+'.$url.'" target="_blank"><i class="fa fa-twitter"></i></a>';
		
		$out .= '<a href="http://pinterest.com/pin/create/bookmarklet/?media='.$imagePin.'&amp;url='.$url.'&amp;is_video=false&amp;description='.$title.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
		
		$out .= '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$url.'amp;title='.$title.'amp;summary='.$summary.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
		
		$out .= '</span>';
		return $out;
	}
}
if ( ! function_exists( 'meta_author' ) ) {
	function meta_author($author_id) {
		return '<span class="meta-author"><span class="el-left">'.__('By','abomb').'</span>&nbsp;<a href="'.esc_url(get_author_posts_url($author_id)).'" rel="author" class="vcard author el-right"><span class="fn">'.get_the_author_meta( 'display_name' ).'</span></a></span>';
	}
}
if ( ! function_exists( 'content_title' ) ) {
	function content_title() {
		$sticky = '';
		if ( is_sticky() && is_home() && ! is_paged() ) {
			$sticky = '<span class="single-sticky el-left">'.__( 'Featured', 'abomb' ).'</span>';
		}
		return $sticky.'<h3 class="entry-title"><a rel="bookmark" href="' . esc_url(get_permalink( get_the_ID() )) . '" title="' . esc_attr(get_the_title( get_the_ID() )) . '">' . get_the_title( get_the_ID() ) . '</a></h3>';
	}
}
if ( ! function_exists( 'content_single_title' ) ) {
	function content_single_title() {
		return '<h1 itemprop="name headline" class="entry-title">'. get_the_title() . '</h1>';
	}
}
if ( ! function_exists( 'content_image' ) ) {
	function content_image($thumb_size, $video, $audio, $gallery) {
		$icon_thumb = '';
		if((has_post_format('video') && $video) || (has_post_format('audio') && $audio)){
			$icon_thumb = '<span class="thumb-icon"><i class="fa fa-play"></i></span>';
		}
		else if (has_post_format('gallery') && $gallery) {
			$icon_thumb = '<span class="thumb-icon gallery"><i class="fa fa-camera"></i></span>';
		}
		return '<a href="' . esc_url(get_permalink( get_the_ID() )). '" title="' . esc_attr(get_the_title( get_the_ID() )) . '">' . get_the_post_thumbnail( get_the_ID(), $thumb_size) . $icon_thumb . '</a>';
	}
}
if ( ! function_exists( 'word_count' ) ) {
	function word_count($string, $limit) {
		return wp_trim_words( $string, $limit, ' <a class="excerpt-cont" title="'.esc_attr(__('Continue reading','abomb')).'" href="'. esc_url(get_permalink(get_the_ID())) .'">...</a>' );
	}
}
if ( ! function_exists( 'single_featured_image' ) ) {
	function single_featured_image($thumb_size, $video, $audio, $gallery, $block_ajax) {
		$out = '';
		if(has_post_format('video') && $video){
			$out .= '<div class="entry-image">';
				$out .= wp_oembed_get( esc_url($video) );
			$out .= '</div>';
		}
		else if(has_post_format('audio') && $audio){
			$out .= '<div class="entry-image">';
				$out .= wp_oembed_get( esc_url($audio) );
			$out .= '</div>';
		}
		else if(has_post_format('gallery') && $gallery && $block_ajax != 'ajax'){
			$rtl = "no";
			if (is_rtl()) { $rtl= 'yes';}
			$out.='<div class="entry-image thumb-'.$thumb_size.' other-slider" data-navigation="yes" data-pagination="no" data-auto="6" data-rtl="'.$rtl.'">';
				foreach( $gallery as $image ):
					$caption = $alt = '';
					if ($image['caption']) {$caption = '<div class="wp-caption-text gallery-caption">'.$image['caption'].'</div>';}
					if ($image['alt']) {$alt = ' alt="'.esc_attr($image['alt']).'" ';}
					
					$img_src = $image['sizes'][$thumb_size];
					$size = GetImageSize( $img_src );
						$out.= '<div class="item">';
							$out.= '<a href="'.esc_url($image['url']).'">';
								$out.= '<img src="'  . esc_url($img_src) . '"'  . $alt . 'width="'  . $size[0] . '" height="'  . $size[1] . '" itemprop="image"/>';
							$out.='</a>';
							$out .= $caption;
						$out.='</div>';
				endforeach;
			$out.='</div>';
		}
		else {
			if (has_post_thumbnail()) {
				$out .= '<div class="entry-image featured-image">';
					$thumbnail = get_the_post_thumbnail(get_the_ID(),$thumb_size, array( 'itemprop' => 'image' ));
					$image_full = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
					$out.= '<a class="popup" href="'.esc_url($image_full[0]).'">';
						$out.= $thumbnail;
					$out.='</a>';

				$out .= '</div>';
			}
		}
		return $out;
	}
}
if ( ! function_exists( 'authorBox' ) ) {
	function authorBox($user_id) {
		$out = '';
		$out .= '<div class="author-box-avatar el-left">';
			$out .= '<a href="'.esc_url(get_author_posts_url($user_id)).'" title="'.esc_attr(get_the_author_meta( 'display_name', $user_id )).'">'.get_avatar( $user_id, 90 ).'</a>';
		$out .= '</div>';
		$out .= '<div class="author-box-detail">';
		
			$out .= '<div class="author-box-title-position">';
			$out .= '<a href="'.esc_url(get_author_posts_url($user_id)).'" class="author-box-title vcard author" rel="author"><span class="fn">'.get_the_author_meta( 'display_name', $user_id ).'</span></a>';
			if (get_the_author_meta( 'position', $user_id )){ $out .= '<span class="author-box-position">'.get_the_author_meta( 'position', $user_id ).'</span>'; }
			$out .= '</div>';
			
			if (get_the_author_meta( 'description', $user_id )) { $out .= '<div class="author-box-desc">'.get_the_author_meta( 'description', $user_id ).'</div>'; }
			
			if (get_the_author_meta( 'twitter', $user_id )||get_the_author_meta( 'facebook', $user_id )||get_the_author_meta( 'googleplus', $user_id )||get_the_author_meta( 'instagram', $user_id )||get_the_author_meta( 'youtube', $user_id )||get_the_author_meta( 'vimeo', $user_id )||get_the_author_meta( 'pinterest', $user_id )||get_the_author_meta( 'linkedin', $user_id )||get_the_author_meta( 'dribbble', $user_id )||get_the_author_meta( 'flickr', $user_id )||get_the_author_meta( 'soundcloud', $user_id )||get_the_author_meta( 'github', $user_id )||get_the_author_meta( 'skype', $user_id )){
				$out .= '<div class="author-box-social">';
					if (get_the_author_meta( 'twitter', $user_id )){$out .= '<a target="_blank" href="//twitter.com/'.esc_attr(get_the_author_meta( 'twitter', $user_id )).'">'.__('Twitter','abomb').'</a>';}
					if (get_the_author_meta( 'facebook', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'facebook', $user_id )).'">'.__('Facebook','abomb').'</a>';}
					if (get_the_author_meta( 'googleplus', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'googleplus', $user_id )).'">'.__('Google','abomb').'<span class="plus"> +</span></a>';}
					if (get_the_author_meta( 'instagram', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'instagram', $user_id )).'">'.__('Instagram','abomb').'</a>';}
					if (get_the_author_meta( 'youtube', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'youtube', $user_id )).'">'.__('Youtube','abomb').'</a>';}
					if (get_the_author_meta( 'vimeo', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'vimeo', $user_id )).'">'.__('Vimeo','abomb').'</a>';}
					if (get_the_author_meta( 'pinterest', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'pinterest', $user_id )).'">'.__('Pinterest','abomb').'</a>';}
					if (get_the_author_meta( 'linkedin', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'linkedin', $user_id )).'">'.__('Linkedin','abomb').'</a>';}
					if (get_the_author_meta( 'dribbble', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'dribbble', $user_id )).'">'.__('Dribbble','abomb').'</a>';}
					if (get_the_author_meta( 'flickr', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'flickr', $user_id )).'">'.__('Flickr','abomb').'</a>';}
					if (get_the_author_meta( 'soundcloud', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'soundcloud', $user_id )).'">'.__('Soundcloud','abomb').'</a>';}
					if (get_the_author_meta( 'github', $user_id )){$out .= '<a target="_blank" href="'.esc_url(get_the_author_meta( 'github', $user_id )).'">'.__('Github','abomb').'</a>';}
					if (get_the_author_meta( 'skype', $user_id )){$out .= '<a href="skype:'.esc_attr(get_the_author_meta( 'skype', $user_id )).'?call">'.__('Skype','abomb').'</a>';}
				$out .= '</div>';
			}
		$out .= '</div>';
		return $out;
	}
}
if ( ! function_exists( 'relatedPosts' ) ) {
	function relatedPosts($count, $type, $post_id, $sidebar){
		
		$key = 'relposts-'.$count.'-'.$type.'-'.$post_id.'-'.get_locale();
		
		if ($relposts = get_transient($key)) return $relposts;
		else {
		
		  $out = $categories = $param = '';
	  
		  $topics =  array_slice(wp_get_object_terms(get_the_ID(), 'topic' , array('orderby' => 'count', 'order' => 'DESC')),0,1);
		  $locations =  array_slice(wp_get_object_terms(get_the_ID(), 'location' , array('orderby' => 'count', 'order' => 'DESC')),0,1);
		  
		  
		  $topic_id = reset($topics)->term_id;
		  $location_id = reset($locations)->term_id;
		  
		  if ($type == 'topic-location') {
			  
			  $args=array(
			  'post_type' 			=> 	'post',
			  'tax_query' => array(
				  'relation' => 'AND',
				  array(
					  'taxonomy' => 'topic',
					  'field'    => 'term_id',
					  'terms'    => array($topic_id),
				  ),
				  array(
					  'taxonomy' => 'location',
					  'field'    => 'term_id',
					  'terms'    => array($location_id),
				  ),
			  ),
			  'post__not_in' 		=> 	array($post_id),
			  'posts_per_page'		=>	$count, 
			  'ignore_sticky_posts '	=>	1,
			  'orderby'				=> 'date'
			  );
			  
			  $related = new WP_Query($args); 
			  //if(!($related->have_posts() && $related->found_posts >= 6)) $type = 'topic';
		  }
		  
		  if ($type == 'topic') {
			  $args=array(
			  'post_type' 			=> 	'post',
			  'tax_query' => array(
				  array(
					  'taxonomy' => 'topic',
					  'field'    => 'term_id',
					  'terms'    => array($topic_id),
				  ),
				  
			  ),
			  'post__not_in' 		=> 	array($post_id),
			  'posts_per_page'		=>	$count, 
			  'ignore_sticky_posts '	=>	1,
			  'orderby'				=> 'date'
			  );
		  }
		  
		  if ($type == 'location') {
			  $args=array(
			  'post_type' 			=> 	'post',
			  'tax_query' => array(
				  array(
					  'taxonomy' => 'location',
					  'field'    => 'term_id',
					  'terms'    => array($location_id),
				  ),
			  ),			
			  'post__not_in' 		=> 	array($post_id),
			  'posts_per_page'		=>	$count, 
			  'ignore_sticky_posts '	=>	1,
			  'orderby'				=> 'date'
			  );
		  }
		  
		  $related = new WP_Query($args); 
		  
		  if($related->have_posts() && $related->found_posts >= 1):
			  $out.='<div class="single-block entry-related clearfix">';
				  $out.='<h4 class="single-block-title">';
					  $out.= __('Related Articles','abomb');
				  $out.='</h4>';
				  $out.='<div class="block block-seven clearfix">';
					  $out.='<div class="row-inner clearfix">';
						  $count=1;
						  while($related->have_posts()): $related->the_post();
							  $column = '4'; $column_count = '3';
							  $videoURL = rd_field( 'abomb_post_video' );
							  $audioURL = rd_field( 'abomb_post_audio' );
							  $gallery = rd_field( 'abomb_post_gallery' );
							  if($sidebar == 'left') {$column = 'grid-4'; $column_count = '3';}
							  elseif($sidebar == 'right') {$column = 'grid-4'; $column_count = '3';}
							  elseif($sidebar == 'double') {$column = 'grid-6'; $column_count = '2';}
							  else {$column = 'grid-3'; $column_count = '4';}
							  $atts = array (
								  'align' 					=> 'default',
								  'column' 				    => $column,
								  'thumb' 					=> 'double-sidebar',
								  'thumb_size'				=> '520x330',
								  'video' 					=> $videoURL,
								  'audio' 					=> $audioURL,
								  'gallery' 					=> $gallery,
								  'first_cat' 				=> 'no',
								  'excerpt' 					=> '',
								  'star' 						=> 'yes',
							  );
							  ob_start();
							  block_grid_content($atts);
							  $out.= ob_get_clean();
							  if($count%$column_count==0){$out .='<div class="clear"></div>';}
							  $count++;
						  endwhile;
					  $out.='</div>';
				  $out.='</div>';
			  $out.='</div>';
			  endif; 
		  wp_reset_postdata();
		  
		  set_transient($key,$out,DAY_IN_SECONDS);
		  return $out;
		}
		
		
	}
}
if ( ! function_exists( 'get_image_attachment_data' ) ) {
	function get_image_attachment_data($post_id, $size = 'thumbnail', $count = 1 ) {
		$objMeta = array();
		$meta = '';// (stdClass)
		$args = array(
			'numberposts' => $count,
			'post_parent' => $post_id,
			'post_type' => 'attachment',
			'nopaging' => false,
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'orderby' => 'menu_order ID',
			'post_status' => 'any'
		);

		$attachments = get_children($args);

		if ($attachments) {
			foreach ($attachments as $attachment) {
				$meta = new stdClass();
				$meta->ID = $attachment->ID;
				$meta->title = $attachment->post_title;
				$meta->caption = $attachment->post_excerpt;
				$meta->description = $attachment->post_content;
				$meta->alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

				// Image properties
				$props = wp_get_attachment_image_src( $attachment->ID, $size, false );
				$meta->properties['url'] = esc_url($props[0]);
				$meta->properties['width'] = $props[1];
				$meta->properties['height'] = $props[2];

				$objMeta[] = $meta;
			}

			return ( count( $attachments ) == 1 ) ? $meta : $objMeta;
		}
	}
}
if ( ! function_exists( 'block_title' ) ) {
	function block_title($atts) {
		$out = '';
		if(function_exists('vc_set_as_theme')){ 
			if ($atts['big_title'] == 'yes') {
				if ($atts['primary_title'] || $atts['second_title']) {
					$out .= '<h4 class="big-title '.$atts['title_align'].'">';
						if ($atts['title_link']) { $out .= '<a href="'.esc_url($atts['title_link']).'">'; }
							if ($atts['primary_title']) { $out .= '<span class="primary-title">'.$atts['primary_title'].'</span>'; }
							if ($atts['primary_title'] && $atts['second_title']) { $out .= '&nbsp;'; }
							if ($atts['second_title']) { $out .= '<span class="second-title">'.$atts['second_title'].'</span>'; }
						if ($atts['title_link']) { $out .= '</a>'; }
					$out .= '</h4>';
				}
			}
			else {
				$out .= wpb_widget_title( array( 'title' => $atts['title'], 'link' => $atts['title_link'], 'extraclass' => $atts['title_align']) ); 
			}
		}
		return $out;
	}
}
?>