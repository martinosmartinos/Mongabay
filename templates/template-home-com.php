<?php 
/** 
Template Name: Homepage COM / Landing
 */
?>
<?php get_header(); ?>
<?php
	$sectitle = '';
	$title = __('<em>Environmental</em> Headlines','mongabay-theme');
	$head = __('Mongabay, <b>founded in 1999</b>, seeks to raise interest in and appreciation of <b>wild lands and wildlife</b>,  aims to be your best source of <b>tropical rainforest conservation and environmental science news</b>.','mongabay-theme');
	$sectitle_w = '<span class="news-category">'.__('Wildlife Tech','mongabay-theme').'</span> ';
	$title_w = __('<em>Wildtech</em> Headlines','mongabay-theme');
	$head_w = __('Wildtech, a joint initiative of Mongabay, RESOLVE’s Biodiversity and Wildlife Solutions program, and the World Resources Institute (WRI), intends to help accelerate the flow of information among scientists, forest and wildlife managers, technology innovators, and interested groups and catalyze the development and application of technologies for forest and wildlife conservation.','mongabay-theme');

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
		'block_id'					=> 'one'.$block_id
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
					switch_to_blog(20);
					$query_news = new WP_Query($atts);
					if ( $query_news->have_posts() ) {
						$i = 0;
						while ( $query_news->have_posts() ) {
							$query_news->the_post();		
							$atts['video'] = rd_field( 'abomb_post_video' );
							$atts['audio'] = rd_field( 'abomb_post_audio' );
							$atts['gallery'] = rd_field( 'abomb_post_gallery' );
							$atts['thumb'] = thumb_sidebar($atts['def_sidebar']);
							$atts['thumb_two'] = thumb_checker( 'small-content', '135x135', 'thumbnail' );
							$atts['counter'] = $i;
							if ($i == $atts['codes_position'] && $atts['ad'] == 'yes' && $atts['codes']!='') {
								if ($atts['encode']=='1') { $content_codes = rawurldecode(base64_decode(strip_tags($atts['codes']))); }
								else { $content_codes = $atts['codes']; }
								echo '<div class="small-post post-ban">'.$content_codes.'</div>';
							}
							block_one_two_content($atts);
							$i++;
						}
				?>
			</div>
			<div class="clearfix" style="width:100%"></div>
			<a class="button" href="<?php echo get_home_url('20','/'); ?>" style="display: block; margin: 2rem auto; text-align: center; width: 170px;">More News</a>	
				<?php	
					}
				echo '<div class="clearfix" style="width:100%;margin-bottom:50px"></div>';
				restore_current_blog();
				?>
		</div>
    </div>
	<div id="section-news-header">
    	<h2><?php echo $title_w; ?></h2>
		<div id="section-news-header-inner"><?php echo $head_w; ?></div>
	</div>
	<div id="section-news-list" >
    	<div id="block<?php echo $atts['block_id']; ?>" class="block block-one clearfix">
        	<div id="block-ajax-query-content<?php echo $atts['block_id']; ?>" class="block-ajax-query-content clearfix">
				<?php
					switch_to_blog(22);
					$query_wildtech = new WP_Query($atts);
					if ( $query_wildtech->have_posts() ) {
						$i = 0;
						while ( $query_wildtech->have_posts() ) {
							$query_wildtech->the_post();		
							$atts['video'] = rd_field( 'abomb_post_video' );
							$atts['audio'] = rd_field( 'abomb_post_audio' );
							$atts['gallery'] = rd_field( 'abomb_post_gallery' );
							$atts['thumb'] = thumb_sidebar($atts['def_sidebar']);
							$atts['thumb_two'] = thumb_checker( 'small-content', '135x135', 'thumbnail' );
							$atts['counter'] = $i;
							if ($i == $atts['codes_position'] && $atts['ad'] == 'yes' && $atts['codes']!='') {
								if ($atts['encode']=='1') { $content_codes = rawurldecode(base64_decode(strip_tags($atts['codes']))); }
								else { $content_codes = $atts['codes']; }
								echo '<div class="small-post post-ban">'.$content_codes.'</div>';
							}
							block_one_two_content($atts);
							$i++;
						}
				?>
			</div>
			<div class="clearfix" style="width:100%"></div>
			<a class="button" href="<?php echo get_home_url('22','/'); ?>" style="display: block; margin: 2rem auto; text-align: center; width: 175px;">More Wildtech News</a>	
				<?php	
					}
					echo '<div class="clearfix" style="width:100%"></div>';
					echo mongabay_adsense_show('news-bottom');
					restore_current_blog();
				?>
    	</div>
    </div>
</div>
<?php get_footer();?>