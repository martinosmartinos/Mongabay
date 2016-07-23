<?php 
/** 
Template Name: Homepage / Landing
 */
?>
<?php get_header(); ?>
<?php
$sub = mongabay_sub();
if ($sub=='kidsnews'){
	//$meta_query = array(array('key' => 'post_category', 'value' => 'kids', 'compare' => '='));
	$sectitle = '<span class="news-category">'.__('Kids','mongabay-theme').'</span> ';
	$title = __('<em>Environmental</em> Headlines for Kids','mongabay-theme');
	$head = __('Mongabay Kids is here to help children to learn about environment, rainforests and conservation.','mongabay-theme');
}
elseif ($sub=='wildtech'){
	//$meta_query = array(array('key' => 'post_category', 'value' => 'wildtech', 'compare' => '='));
	$sectitle = '<span class="news-category">'.__('Wildlife Tech','mongabay-theme').'</span> ';
	$title = __('<em>Wildtech</em> Headlines','mongabay-theme');
	$head = __('Wildtech, a joint initiative of Mongabay, RESOLVE’s Biodiversity and Wildlife Solutions program, and the World Resources Institute (WRI), intends to help accelerate the flow of information among scientists, forest and wildlife managers, technology innovators, and interested groups and catalyze the development and application of technologies for forest and wildlife conservation.','mongabay-theme');
}
else{
	//$meta_query = '';
	$sectitle = '';
	$title = __('<em>Environmental</em> Headlines','mongabay-theme');
	$head = __('Mongabay, <b>founded in 1999</b>, seeks to raise interest in and appreciation of <b>wild lands and wildlife</b>,  aims to be your best source of <b>tropical rainforest conservation and environmental science news</b>.','mongabay-theme');
}
//end of check

global $block_id;

$block_id++;	

$atts = array(
	'title' 					=> '',
	'big_title'		 			=> '',
	'primary_title' 			=> '',
	'second_title'				=> '',
	'title_link' 				=> '',
	'title_align' 				=> '',
	'big_post' 					=> 'yes',
	'first_cat' 				=> 'yes',
	'star'					 	=> 'yes',
	'big_excerpt' 				=> 36,
	'small_excerpt' 			=> 21,
	'offset' 					=> 0,
	//'multisite'					=> 1,
	//'sites__in'					=> 1,
	
	// Ads
	'ad' 						=> '',
	'codes' 					=> '',
	'codes_position' 			=> '',
	'encode' 					=> '1',
	
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
	'global_query'				=> '1',
	
	// related posts
	'related_posts' 			=> '',
	'related_by' 				=> '',
	
	'def_sidebar'				=> $GLOBALS['sidebar_layout'],
	'is_ajax'					=> 0,
	'block_id'					=> 'one'.$block_id,
	//'meta_query'				=> $meta_query,
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
	$query = new WP_Query($atts);
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
	echo mongabay_adsense_show('news-bottom');
	?>
    	</div>
    </div>
</div>
<?php get_footer();?>