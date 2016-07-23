<?php
function mongabay_images_head($type,$term=NULL) {
	if ($type == 'general' || $type == 'general-c') {
		$text = __('Photos are a powerful way to raise interest in the world around us. Accordingly, Mongabay has put together a large collection of nature photos from around the world.<br /><br />The images are freely available for non-commercial use as described in our terms. We hope they inspire people to care more about the planet\'s other residents..','mongabay-theme');
		$updir = wp_upload_dir('2015/07');
		$image = $updir['url'] . '/scalecrestedpygmytyrant_cr_3924.jpg';
		
		$eclass='superimagesheader';
		
		$line1 = __('Mongabay','mongabay-theme');
		$line2 = __('Photography Collection','mongabay-theme');
		if ($type == 'general-c') $line2 = __('Photos by Country','mongabay-theme');
	}
	
	if ($type == 'location' || $type == 'topic') {
		$line1 = __('Mongabay Collection','mongabay-theme');
		$line2 = $term->name;
		$text = wp_trim_words( $term->description, 60); 
		$image = mongabay_term_image_url($term);
	}
	
	if ($type == 'gallery') {
		$line1 = __('Mongabay Collection','mongabay-theme');
		$line2 = $term[1]->name . ' <i>'.$term[0]->name.'</i>';
		$text = wp_trim_words( $term[1]->description, 60); 
		$image = mongabay_term_image_url($term);
	}
	
	if ($type == 'highlights') {
		$line1 = __('Mongabay Collection','mongabay-theme');
		$line2 = $term->name . ' <i>'.__('Highlights','mongabay-theme').'</i>';
		$text = wp_trim_words( $term->description, 60); 
		$image = mongabay_term_image_url($term);
	}
	
	if ($type == 'simple_page') {
		$line1 = get_the_title();
		$line2 = get_post_meta(get_the_ID(),'subtitle',true);
		$text = get_post_meta(get_the_ID(),'summary',true);
		$updir = wp_upload_dir('2015/06');
		if (get_post_thumbnail_id(get_the_ID())) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large' );
			$image = $image[0];
			$eclass='modified-bg';
		} else $image = $updir['url'] . '/simple-page-bg.jpg';

	}
		
	$html = '<div class="images-subheader '.(isset($eclass)?$eclass:'').'"><div class="images-subheader-inner" style="background-image: url(\''.$image.'\');"><h2 class="images-subheader-supertitle">'.$line1.'</h2><h1 class="images-subheader-title">'.$line2.'</h1><p>'.$text.'</p></div></div>';
	
	return $html;
}

function mongabay_images_homepage_slider() {
	
	$loc = get_locale();
	if ($loc=='en_US' || empty($loc)) {}
	else return;
	
	$key = 'homeimages-'.get_locale();
	
	
	
	if ($rstr = get_transient($key)) return $rstr;
	else {
		
		$rstr = '<div class="homeimages-block">';
		
		$rstr .= '<h3><em>'. __('Mongabay','mongabay-theme').'</em> '. __('In Pictures','mongabay-theme') . '</h3>';
		$rstr .= '<a href="'.mongabay_url('images').'" class="button button-gallery">'. __('View all Images','mongabay-theme').'</a>';
		
		$rstr .= '<div class="main-slider-wrap other-slider owl-slider owl-none" data-auto="0" data-rtl="no" data-navigation="yes" data-pagination="yes">';
		
		$args = array (
			'post_type' 				=> 'image',
			'posts_per_page'         	=> 5,
			'meta_key'   				=> 'rating',
			'meta_value' 				=> 0,
			'pagination'             	=> false,
			'ignore_sticky_posts'    	=> true,
			'orderby'                	=> 'date',
			'order'                  	=> 'DESC'
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ):
				$query->the_post(); 
				$rstr .= '<div class="item sitem" itemscope="itemscope" itemtype="'.rd_ssl().'://schema.org/BlogPosting">';
				$rstr .= '<a href="'.esc_url(get_permalink()).'"><img src="'.get_post_meta(get_the_ID(),'image-url-medium',true).'" style="max-width: 520px; max-height: 347px;" /></a>';
				$rstr .= '<div class="scaption">';
					$locations = array_slice(wp_get_object_terms(get_the_ID(), 'location' , array('orderby' => 'count', 'order' => 'DESC')),0,1);
					$location=reset($locations);
					if ($location) $rstr .= '<a class="location-link" href="'.mongabay_url('location-image',$location->slug).'">'.$location->name.'</a>';
					$rstr .= '<h4 class="stitle" itemprop="name"><a itemprop="url" rel="bookmark" href="'.esc_url(get_permalink()).'" title="'. esc_attr(get_the_title()).'">'.get_the_title().'</a></h4>';
					
				$rstr .= '</div>';
				$rstr .= '</div>';
			endwhile;
		}
		
		$rstr .= '</div>';
		
		$rstr .= '</div>';
		set_transient($key,$rstr,DAY_IN_SECONDS);
		return $rstr;
	}
}
add_shortcode( 'homeimages', 'mongabay_images_homepage_slider' );
