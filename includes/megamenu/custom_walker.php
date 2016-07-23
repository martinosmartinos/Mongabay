<?php
class rd_mega_walker extends Walker_Nav_Menu
{
	private $menutype;
	private $column;
	
	public function start_lvl( &$output,  $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		
		if ( $depth == 0 && $this->menutype == 2 ){
			$output .= "\n$indent<div class=\"megamenu\">\n<div class=\"row clearfix\">\n<div class=\"megaposts-full clearfix\">\n<div class=\"row-inner clearfix\">\n";
		}
		else if ( $depth > 0 && $this->menutype == 2 ){
			$output .= "\n$indent<ul>\n";
		}
		else if ( $depth == 0 && $this->menutype == 3){
			$output .= "\n$indent<div class=\"megalist\">\n<ul>\n";
		}
		else if ($depth == 0 && $this->menutype == 1) {
			$output .= "\n$indent<div class=\"megamenu h-menu\">\n<div class=\"row clearfix\">\n<div class=\"megaposts-full clearfix\">\n<ul>\n";
		}
		else {
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		
		if ( $depth == 0 && $this->menutype == 2){
			$output .= "\n$indent</div>\n</div>\n</div>\n</div>\n";
		}
		else if ( $depth == 0 && $this->menutype == 3){
			$output .= "\n$indent</ul>\n</div>\n";
		}
		else if ($depth == 0 && $this->menutype == 1) {
			$output .= "\n$indent</ul>\n</div>\n</div>\n</div>\n";
		}
		else {
			$output .= "\n$indent</ul>\n";
		}
	}
	
    public function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		if($depth == 0){     
			$this->column = get_post_meta( $item->ID, '_menu_item_column', true );
			$this->menutype = get_post_meta( $item->ID, '_menu_item_menutype', true );	
		}
		$this->nav_label = get_post_meta( $item->ID, '_menu_item_nav_label', true );
		   
		global $wp_query;
		$cat = $item->object_id;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $class_section_megamenu = $class_megamenu = $item_output = $children = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );     
		
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
	
		
		// mega menu
		if($depth == 1 && $this->menutype == 2){
			if (!empty($this->column)) {
				$class_section_megamenu = ' grid-'.$this->column;
			}
			else {
				$class_section_megamenu = ' grid-3';
			}
			$class_names = ' class="'. esc_attr( $class_names ) .$class_section_megamenu. '"';
			$output .= $indent . '<div ' . $class_names.'>';
			//$output .= $indent . '<div id="' . $args->menu_id . '-' . $item->ID . '"' . $class_names.'>';
		}
		// other menu
		else{
			$class_names = ' class="'. esc_attr( $class_names ).'"';
			$output .= $indent . '<li ' . $class_names.'>';
			//$output .= $indent . '<li id="' . $args->menu_id . '-' . $item->ID . '"' . $class_names.'>';
		}
	   
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';

		$item_output .= $args->before;
		
		// mega menu title
		if($depth == 1 && $this->menutype == 2){
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			if( $this->nav_label == 1 && $title != '-' && $title != '"-"' ) {
				$heading = do_shortcode($title);
				$link = '';
				$link_closing = '';

				if( ! empty($item->url) && $item->url != '#' && $item->url != 'http://') {
					$link = '<a href="' . esc_url($item->url) . '">';
					$link_closing = '</a>';
				}

				$heading = sprintf( '%s%s%s', $link, $title, $link_closing );
				$item_output .= "<div class='megamenu-title'>" . $heading . "</div>";
			}
		}
		// other menu
		else{
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );            
			$item_output .= $args->link_after;
			$item_output .= '</a>';
		}
		// category menu
		if ( $depth == 0 && $item->object == 'category' && $this->menutype == 3) {
				$item_output .= '<div class="megamenu"><div class="row clearfix">';
		}
		$item_output .= $args->after;
		
		// Posts category
		if ( $depth == 0 && $item->object == 'category' && $this->menutype == 3) { 
			$cat = $item->object_id;
			$megacat_full = '';
			if ( empty( $children )){ 
				$megacat_full = '-full'; 
			}
			global $post;
			$post_args = array( 'posts_per_page' => 4, 'offset'=> 0, 'category' => $cat );
			$menuposts = get_posts( $post_args );
			$item_output .= '<div class="megaposts'.$megacat_full.'">';
				$item_output .= '<div class="row-inner">';
					foreach( $menuposts as $post ) : setup_postdata( $post );
						if ( empty( $children ) ){
							$thumb = 'double-sidebar';
						}
						else {
							$thumb = thumb_checker( 'mega-post', '205x130', 'double-sidebar' );
						}
						$videoURL = rd_field( 'abomb_post_video' );
						$audioURL = rd_field( 'abomb_post_audio' );
						$gallery = rd_field( 'abomb_post_gallery' );
						$item_output .= '<div class="grid-3 post-menu" itemscope="itemscope" itemtype="'. rd_ssl() .'://schema.org/BlogPosting">';
							$item_output .= '<div class="entry-image">'.content_image($thumb, $videoURL, $audioURL,$gallery).'</div>';
							$item_output .= content_title();
						$item_output .= '</div>';
					endforeach;
					wp_reset_postdata();
				$item_output .= '</div>';
			$item_output .= '</div>';
		}
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	function end_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		if ( $depth == 0 && $item->object == 'category' && $this->menutype == 3) {
				$output  .= '</div></div>';
		}
		if($depth == 1 && $this->menutype == 2){
			$output .= "</div>\n";
			$output .= mongabay_megamenu_items($item);
		}
		else{
			$output .= "</li>\n";
		}
		
	}


}

function mongabay_megamenu_items($item) {
	global $post;
	
	$type = 'general';
	if ($item->url=='/images') $type = 'images';
	
	
	$tax_query = array();
	$meta_query = array();

	switch($item->url) {
		case "/rainforests":
			$tax_query = array( array(
			  'taxonomy' => 'topic',
			  'field'    => 'slug',
			  'terms'    => array('rainforests','forests','deforestation'),
			  'operator' => 'IN',
			));
			break;
		case "/oceans":
			$tax_query = array( array(
			  'taxonomy' => 'topic',
			  'field'    => 'slug',
			  'terms'    => 'oceans',
			  'terms'    => array( 'oceans', 'seas', 'waters', 'water', 'fishing', 'marine'),
			  'operator' => 'IN',
			));
			break;
		case "/environment":
			$tax_query = array( array(
			  'taxonomy' => 'topic',
			  'field'    => 'slug',
			  'terms'    => array( 'environment', 'wildlife', 'conservation', 'speciesdiscovery'),
			  'operator' => 'IN',
			));
			break;
		case "/kids":
			$meta_query =  array( array(
			  'key'     => 'post_category',
			  'value'   => 'kids',
			));
			break;
		case "/wildtech":
			$meta_query =  array( array(
			  'key'     => 'post_category',
			  'value'   => 'wildtech',
			));
			break;
		case "/images":
			$meta_query =  array( array(
			  'key'     => 'rating',
			  'value'   => 0,
			));
			break;
		default:
			return;
		}

	if ($type=='general') $post_args = array( 'posts_per_page' => 4, 'offset'=> 0, 'tax_query' => $tax_query, 'meta_query' => $meta_query,  'suppress_filters' => 0 );
	if ($type=='images') $post_args = array( 'post_type' => 'image', 'posts_per_page' => 4, 'offset'=> 0, 'tax_query' => $tax_query, 'meta_query' => $meta_query );
	$menuposts = get_posts($post_args);
	
	//$menuposts = get_posts( $post_args );	
	$item_output = "";
	$item_output .= '<div class="megaposts">';
		$item_output .= '<div class="row-inner">';
			foreach( $menuposts as $post ) : setup_postdata( $post ); 
				if ( empty( $children ) ){
					$thumb = 'double-sidebar';
				}
				else {
					$thumb = thumb_checker( 'mega-post', '205x130', 'double-sidebar' );
				}
				$videoURL = rd_field( 'abomb_post_video' );
				$audioURL = rd_field( 'abomb_post_audio' );
				$gallery = rd_field( 'abomb_post_gallery' );
				$item_output .= '<div class="grid-3 post-menu">';
					if ($type=='images') {
						$item_output .= '<div class="entry-image"><a href="'.get_permalink().'" alt="'.get_the_title().'"><img src="'.get_post_meta(get_the_ID(), 'image-url-medium',true).'" style="max-width: 200px; max-height: 133px" /></a></div>';
					}
						
					else $item_output .= '<div class="entry-image">'.content_image('megamenu', $videoURL, $audioURL,$gallery).'</div>';
					$item_output .= content_title();
				$item_output .= '</div>';
			endforeach;
			wp_reset_postdata();
		$item_output .= '</div>';
	$item_output .= '</div>';
	
	return $item_output;
	
}