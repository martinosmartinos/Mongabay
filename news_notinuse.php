<?php
// SET UP DATA

$sec = get_query_var('section');
$c1 = get_query_var('nc1');
$c2 = get_query_var('nc2');
$classes = $title = $head = "";
$tax_query = $meta_query = array();
$sub = mongabay_sub();
if (!$sec) $sec = 'list';

if ($sec == 'list') {
	if ($sub=='kidsnews') $sectitle = '<span class="news-category">'.__('Kids','mongabay-theme').'</span> ';
	elseif ($sub=='wildtech') $sectitle = '<span class="news-category">'.__('Wildlife Tech','mongabay-theme').'</span> ';
	else $sectitle = '';

	if (!empty($c1) && !empty($c2)) { // 2 items are set
		//if (function_exists('icl_object_id')) $sitepress->switch_lang('en');
		$items1 = get_terms(array('topic','location'), array('slug' => $c1));
		$items2 = get_terms(array('topic','location'), array('slug' => $c2));
		//if (function_exists('icl_object_id')) $sitepress->switch_lang(ICL_LANGUAGE_CODE);
		
		if (!$items1) {
			$redirect= mongabay_prot().'news.'.mongabay_domain();
		}
		$item1 = reset($items1);	
				
		if (!$items2) {
			$redirect= mongabay_prot().'news.'.mongabay_domain().'/list/'.$item1->slug;
		}
		$item2 = reset($items2);
		
		// reorder - topic has to be first
		if ($item1->taxonomy=='location' && $item2->taxonomy=='topic') {
			$redirect= mongabay_prot().'news.'.mongabay_domain().'/list/'.$item2->slug.'/'.$item1->slug;
		}
		
		// multi-lang fix
		/* if (function_exists('icl_object_id') && ICL_LANGUAGE_CODE!='en') {	
			$t_item1 = get_term(icl_object_id($item1->term_id, $item1->taxonomy, true), $item1->taxonomy);
			$t_item2 = get_term(icl_object_id($item2->term_id, $item2->taxonomy, true), $item2->taxonomy);
		} else { $t_item1 = $item1; $t_item2 = $item2; } */
	
		if ($item1->taxonomy == $item2->taxonomy)  $title = $sectitle.'<em class="em-'.$item1->taxonomy.'">'.$t_item1->name.'</em> '.__('and','mongabay-theme').' <em class="em-'.$item2->taxonomy.'">'.$t_item2->name.'</em> '.__('News','mongabay-theme');
		else  $title = __('News: ','mongabay-theme').$sectitle.'<em class="em-'.$item1->taxonomy.'">'.$t_item2->name.' / </em><em class="em-'.$item2->taxonomy.'">'.$t_item1->name.'</em> ';
		
		$img_url1 = mb_termmeta($item1->term_id,'cover_image_url');
		if ($img_url1) $img1 = '<img src="'.$img_url1.'" alt="'.strip_tags($title).'" />';
		$head1 = '<div class="section-news-header-left">'.(isset($img1)?$img1:'').$item1->description.'</div>';
		
		$img_url2 = mb_termmeta($item2->term_id,'cover_image_url');
		if ($img_url2) $img2 = '<img src="'.$img_url2.'" alt="'.strip_tags($title).'" />';
		$head2 = '<div class="section-news-header-right">'.(isset($img2)?$img2:'').$item2->description.'</div>';
		
		$head = $head1.$head2;
		$classes = 'section-news-double';
		$htitle = strip_tags($title);
		$tax_query = array('relation' => 'AND',
			array('taxonomy' => $item1->taxonomy,'field' => 'slug','terms' => $item1->slug),
			array('taxonomy' => $item2->taxonomy,'field' => 'slug','terms' => $item2->slug));
		
	}
	
	if (!empty($c1) && empty($c2)) {
		//if (function_exists('icl_object_id')) $sitepress->switch_lang('en');
		$items = get_terms(array('topic','location'), array('slug' => $c1));
		//if (function_exists('icl_object_id')) $sitepress->switch_lang(ICL_LANGUAGE_CODE);
		if (!$items) {
			$redirect= mongabay_prot().'news.'.mongabay_domain();
		} else {
			$item = reset($items);		
			
			// multi-lang fix
			/* $orig_item=$item;
			if (function_exists('icl_object_id') && ICL_LANGUAGE_CODE!='en') {	
				$icl = icl_object_id($orig_item->term_id, $orig_item->taxonomy, true);
				$item = get_term($icl, $orig_item->taxonomy);
			}  */
			
			$title = $sectitle.'<em>'.$item->name.'</em> '.__('News','mongabay-theme');
			$img_url = mb_termmeta($orig_item->term_id,'cover_image_url');
			if ($img_url) $img = '<img src="'.$img_url.'" alt="'.strip_tags($title).'" />';
			$head = (isset($img)?$img:'').$item->description;
			$classes = 'setion-news-'.$item->taxonomy;
			$htitle = strip_tags($title);
			$tax_query = array(array('taxonomy' => $orig_item->taxonomy,'field' => 'slug','terms' => $orig_item->slug));
		}
		
	}
	
	if (empty($c1)) { // error or general listing page
		$classes = 'section-news-landing';
		if ($sub=='kidsnews') {
			$title = __('<em>Environmental</em> Headlines for Kids','mongabay-theme');
			$head = __('Mongabay Kids is here to help children to learn about environment, rainforests and conservation.','mongabay-theme');
		}
		elseif ($sub=='wildtech') {
			$title = __('<em>Wildtech</em> Headlines','mongabay-theme');
			$head = __('Wildtech, a joint initiative of Mongabay, RESOLVE’s Biodiversity and Wildlife Solutions program, and the World Resources Institute (WRI), intends to help accelerate the flow of information among scientists, forest and wildlife managers, technology innovators, and interested groups and catalyze the development and application of technologies for forest and wildlife conservation.','mongabay-theme');
		}
		else {
			$title = __('<em>Environmental</em> Headlines','mongabay-theme');
			$head = __('Mongabay, <b>founded in 1999</b>, seeks to raise interest in and appreciation of <b>wild lands and wildlife</b>,  aims to be your best source of <b>tropical rainforest conservation and environmental science news</b>.','mongabay-theme');
		}
	}
	
	if ($sub=='kidsnews') $meta_query = array(array('key' => 'post_category', 'value' => 'kids', 'compare' => '='));
	if ($sub=='wildtech') $meta_query = array(array('key' => 'post_category', 'value' => 'wildtech', 'compare' => '='));
	
} elseif ($sec == 'series') {
	$items = get_terms(array('serial'), array('slug' => $c1));
	if (!$items) {
		$redirect= mongabay_prot().'news.'.mongabay_domain();
	} else {
		$item = reset($items);	
		$title = __('Mongabay Series','mongabay-theme').': <em>'.$item->name.'</em> ';
		$img_url = mb_termmeta($item->term_id,'cover_image_url');
		if ($img_url) $img = '<img src="'.$img_url.'" alt="'.strip_tags($title).'" />';
		$head = (isset($img)?$img:'').$item->description;
		$classes = 'setion-news-series';
		$htitle = $item->name;
		$tax_query = array(array('taxonomy' => 'serial','field' => 'slug','terms' => $item->slug));
	}

} elseif ($sec == 'author') {
	$items = get_terms(array('author'), array('slug' => $c1));
	if (!$items) {
		$redirect= mongabay_prot().'news.'.mongabay_domain();
	} else {
		$item = reset($items);	
		$title = __('Articles by','mongabay-theme').' <em>'.$item->name.'</em> ';
		$img_url = mb_termmeta($item->term_id,'cover_image_url');
		if ($img_url) $img = '<img src="'.$img_url.'" alt="'.strip_tags($title).'" />';
		$head = (isset($img)?$img:'').$item->description;
		$classes = 'setion-news-author';
		$htitle = strip_tags($title);
		$tax_query = array(array('taxonomy' => 'author','field' => 'slug','terms' => $item->slug));
	}
}

/* Set custom title */
if (!empty($htitle)) {
	global $header_title;
	$header_title = $htitle;
	$htitle_func =  function($title, $sep) { global $header_title; return $header_title.' '.$sep.' '.get_bloginfo( 'name', 'display' ); };
	add_filter( 'wp_title', $htitle_func, 10, 2 );
}
	
echo '<pre>$redirect<br>';
var_dump( $redirect );
echo '</pre>';
die();


if (!empty($redirect)) {
		echo '<script type="text/javascript">window.stop(); window.location.replace(\''.$redirect.'\');</script>';
		exit;
}

#echo '<pre>$redirect<br>';
#var_dump( $redirect );
#echo '</pre>';
#die();

?>
<?php get_header(); ?>
<?php
// NO redirect, let's get the query
var_dump($c1);
global $block_id;
$block_id++;	

$atts = array(
	'title' 					=> '',
	'big_title'		 		=> '',
	'primary_title' 			=> '',
	'second_title'				=> '',
	'title_link' 				=> '',
	'title_align' 				=> '',
	'big_post' 				=> 'yes',
	'first_cat' 				=> 'yes',
	'star'					 	=> 'yes',
	'big_excerpt' 				=> 36,
	'small_excerpt' 			=> 21,
	'offset' 					=> 0,
	
	// Ads
	/*tochange 'ad' 						=> '',
	'codes' 					=> '',
	'codes_position' 			=> '',
	'encode' 					=> '1', */
	
	// wp_query
	'post_status'				=> 'publish',
	'post_type' 				=> 'post',
	'category_name'         	=> '',
	'tag'               		=> '',
	'posts_per_page'         	=> 20,
	'ignore_sticky_posts'    	=> true,
	'orderby'                	=> '',
	'order'                  	=> '',
	'nav'						=> 'ajax',
	'global_query'				=> '0',
	
	// related posts
	'related_posts' 			=> '',
	'related_by' 				=> '',
	
	'def_sidebar'				=> $GLOBALS['sidebar_layout'],
	'is_ajax'					=> 0,
	'block_id'					=> 'one'.$block_id,
	
	// our meta query
	'meta_query' => $meta_query,
	
	// our tax query
	'tax_query' => $tax_query,
);
	
?>
<div id="section-news-wrap" class="<?php echo $classes; ?>">
	<div id="section-news-header">
    	<h2><?php echo $title; ?></h2>
		<div id="section-news-header-inner"><?php echo $head; ?></div>
	</div>
	<div id="section-news-list" >
    	<div id="block<?php echo $atts['block_id']; ?>" class="block block-one clearfix">
        	<div id="block-ajax-query-content<?php echo $atts['block_id']; ?>" class="block-ajax-query-content clearfix">
    <?php 
	$query = new WP_Query( $atts );
	if ( $query->have_posts() ) {
		$i = 0;
		while ( $query->have_posts() ) {
			$query->the_post();		
			$atts['video'] = rd_field( 'abomb_post_video' );
			$atts['audio'] = rd_field( 'abomb_post_audio' );
			$atts['gallery'] = rd_field( 'abomb_post_gallery' );
			$atts['thumb'] = thumb_sidebar($atts['def_sidebar']);
			$atts['thumb_two'] = thumb_checker( 'small-content', '135x135', 'thumbnail' );
			$atts['counter'] = $i;
			
			//if ($i == $atts['codes_position'] && $atts['ad'] == 'yes' && $atts['codes']!='' && $is_ajax==0) {
			if ($i == $atts['codes_position'] && $atts['ad'] == 'yes' && $atts['codes']!='') {
				if ($atts['encode']=='1') { $content_codes = rawurldecode(base64_decode(strip_tags($atts['codes']))); }
				else { $content_codes = $atts['codes']; }
				echo '<div class="small-post post-ban">'.$content_codes.'</div>';
			}
			 
			block_one_two_content($atts);
			$i++;
		}
		?> </div> <?php
		
		if($atts['nav'] == 'ajax') { ?>
        	
			<div class="style-button block-ajax-query-button clearfix" data-blockid="<?php echo esc_attr( $atts['block_id']); ?>" data-ajaxtype="block_one_ajax_query" data-homeurl="<?php echo esc_url(home_url( '/' ));?>" data-nomore="<?php echo _e('No More','abomb'); ?>" data-paramencode='<?php echo json_encode($atts); ?>'>
				<span class="ajax-icon-progress"><i class="fa fa-refresh fa-spin"></i></span><span class="ajax-icon-load"><i class="fa fa-rotate-right"></i></span><span class="ajax-text-load"><?php _e('Load More ...','abomb'); ?></span>
			</div>
		<?php }
	} else {
		?><div class="no-posts-found"><?php _e('Sorry, we haven\'t found any posts in this category. '); ?></div><?php
	}
	//tochange echo mongabay_adsense_show('news-bottom');
	?>
    	</div>
    </div>
</div>
<?php get_footer();
