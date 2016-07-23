<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

// Block One Template
function block_one_ajax_template($atts) {
	global $block_id;
	$block_id++;
	$atts['block_id'] = 'one'.$block_id;
	$atts['def_sidebar'] = $GLOBALS['sidebar_layout'];
	ob_start(); ?>
	<div id="block<?php echo $atts['block_id']; ?>" class="wpb_content_element block block-one clearfix">
		<?php echo block_title($atts);?>
		<div id="block-ajax-query-content<?php echo $atts['block_id']; ?>" class="block-ajax-query-content clearfix">
			<?php echo block_one_ajax_query($atts); ?>
		</div>
		<?php if($atts['nav'] == 'ajax'): ?>
			<div class="style-button block-ajax-query-button clearfix" data-blockid="<?php echo esc_attr( $atts['block_id']); ?>" data-ajaxtype="block_one_ajax_query" data-homeurl="<?php echo esc_url( mongabay_url('') );?>" data-nomore="<?php echo _e('No More','abomb'); ?>" data-paramencode='<?php echo json_encode($atts); ?>'>
				<span class="ajax-icon-progress"><i class="fa fa-refresh fa-spin"></i></span><span class="ajax-icon-load"><i class="fa fa-rotate-right"></i></span><span class="ajax-text-load"><?php _e('Load More ...','abomb'); ?></span>
			</div>
		<?php endif; ?>
	</div>
	<?php
	$html = ob_get_clean();
	return $html;
}

// Block One Query
function block_one_ajax_query($atts='') {
	header("Access-Control-Allow-Origin: *");
	echo '<p>hello world</p>';
	exit();
	$is_ajax = 0;
	if($atts==''){
		$is_ajax=1;
		$atts=$_GET;
		if($atts['global_query']){
			unset($atts['no_found_rows']);
			unset($atts['suppress_filters']);
			unset($atts['cache_results']);
			unset($atts['update_post_term_cache']);
			unset($atts['update_post_meta_cache']);
			unset($atts['nopaging']);
		}
	}
	$atts['is_ajax'] = $is_ajax;
	$query = null;
	$query = new WP_Query( $atts );
	$html = ''; 

	if ( $query->have_posts() ) {
		ob_start();
		$i = 0;
		while ( $query->have_posts() ):
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
		endwhile;
		if ($atts['nav'] == 'numbered') {
			rd_pagination($query->max_num_pages);
		}
		wp_reset_postdata();
		$html = ob_get_clean();
		if($is_ajax==1){
			echo $html; 
			exit();
		}
		return $html;
	}
	else{
		if($is_ajax==1){
			echo '-11';
			exit();
		}
		return '';
	}
}
add_action("wp_ajax_block_one_ajax_query", "block_one_ajax_query");
add_action("wp_ajax_nopriv_block_one_ajax_query", "block_one_ajax_query");
?>