<?php
function mongabay_widget_newsinline( $atts ) {
	$type = $atts['type'];
	$rstr = '';
	global $wp_query;
	$tax = get_taxonomy( $type );
	if (!$tax) return;
	
	if ($type == 'topic') { $cats = array('rainforests','oceans','wildlife','conservation'); $kw = 'Focus'; }
	elseif ($type == 'location') { $cats = array('indonesia','brazil','madagascar','malaysia'); $kw = 'Worldwide'; }
	else return;
	
	$rstr .= '<div class="newsinline-block newsinline-block-'.$type.'" style="width: 100%;">';
	if ($kw == 'Focus') $rstr .= '<div class="newsinline-head-wrap"><h2 class="newsinline-head">'.__('Mongabay <em>Focus</em>','mongabay-theme').'</h2><a class="button" href="'.mongabay_url($type == 'topic'?'topic':'locations').'">'.__('News by','mongabay-theme').' '.$tax->label.'</a></div>';
	if ($kw == 'Worldwide') $rstr .= '<div class="newsinline-head-wrap"><h2 class="newsinline-head">'.__('Mongabay <em>Worldwide</em>','mongabay-theme').'</h2><a class="button" href="'.mongabay_url($type == 'topic'?'topic':'locations').'">'.__('News by','mongabay-theme').' '.$tax->label.'</a></div>';
	
	foreach ($cats as $cat) {
		$rstr .= '<div class="newsinline-box">';
		$args = array(
			'post_type'  => 'post',
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => $type,
					'field'    => 'slug',
					'terms'    => $cat,
					),
				),
			);
		$term = get_term_by( 'slug', $cat, $type );
		$rstr .= '<h3 class="newsinline-item-head">'.$term->name.'</h3>';
			
		$query = new WP_Query($args);
		while ( $query->have_posts() ) {
			$query->the_post(); 
			$rstr .= '<a class="newsiline-item" href="'.get_permalink().'">'.get_the_title().'</a>';
		}
		wp_reset_postdata();
		
		$rstr .= '</div>';
	}
	$rstr .= '</div>';
	
	return $rstr;
	
	
}
add_shortcode( 'newsinline', 'mongabay_widget_newsinline' );