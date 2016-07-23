<?php
class ReedwanWidgets__block9 extends WP_Widget {

	function ReedwanWidgets__block9() {
		// widget actual processes
		parent::WP_Widget(false, $name = __('Abomb - Posts Block 9', 'abomb_backend'), array(
			'description' => __('Fit on left and right sidebar. Display your latest, random, best commented, best view posts. Also display your latest and best review.', 'abomb_backend')
		));
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$title_link = $instance['title_link'];
		$title_align = $instance['title_align'];
		
		$sub = mongabay_sub();
		$date_query = array( array( 'after' => '1 week ago' ));
		if ($sub=='wildtech') $date_query = array( array( 'after' => '2 months ago' ));
		if ($sub=='kidsnews') $date_query = array( array( 'before' => 'now' ));
		if (mongabay_sub_is_lang()) $date_query = array( array( 'after' => '2 months ago' ));
		
		$atts = array (
			'title' 					=> '',
			'big_title'		 			=> '',
			'primary_title' 			=> '',
			'second_title'				=> '',
			'title_link' 				=> '',
			'title_align' 				=> '',
			'number' 					=> $instance['number'],
			'clock' 					=> $instance['clock'],
			'indicator' 				=> $instance['indicator'],
			'offset' 					=> 0,
			
			// Ads
			'ad' 						=> $instance['ad'],
			'codes' 					=> $instance['codes'],
			'codes_position' 			=> $instance['codes_position'],
			'encode' 					=> '0',
			
			// wp_query
			'post_status'				=> 'publish',
			'post_type' 				=> 'post',
			'ignore_sticky_posts'    	=> true,
			'category_name'         	=> $instance['category_name'],
			'tag'               		=> $instance['tag'],
			'posts_per_page'         	=> $instance['posts_per_page'],
			'nav'						=> $instance['nav'],
			'global_query'				=> '0',
			'date_query' 				=> $date_query
		);
		
		
		if ($sub=='wildtech') $atts['meta_query'] = array( 
			array(
				'key'     => 'post_category',
				'value'   => 'wildtech',
				'compare' => '=',
				),
			array(
				'key'     => 'post_views_count_real',
				'compate'   => 'EXISTS',
				),
			);
		elseif ($sub=='kidsnews') $atts['meta_query'] = array( 
			array(
				'key'     => 'post_category',
				'value'   => 'kids',
				'compare' => '=',
				),
			array(
				'key'     => 'post_views_count_real',
				'compate'   => 'EXISTS',
				),
			);
		else $atts['meta_query'] = array( 
			array(
				'key'     => 'post_views_count_real',
				'compate'   => 'EXISTS',
				),
			);
			
		$atts['orderby'] = 'post_views_count_real';
		$atts['order'] = 'DESC';
		
		echo $before_widget;
		$title = __('Most Read','mongabay');
		if ( $title) {
			echo '<h4 class="widgettitle '.$title_align.'">';
			if ($title_link) { echo '<a href="'.esc_url($title_link).'">'; }
				echo $title;
			if ($title_link) { echo '</a>'; }
			echo '</h4>';
		}
		$atts['paged'] = 1;
		if ($atts['nav']=='numbered') {
			$paged = 1;
			if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
			elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
			else { $paged = 1; }
			$atts['paged'] = $paged;
		}
		/*if($atts['orderby']=='post_views'){
			$atts['meta_key'] = 'post_views_count';
			$atts['orderby'] = 'meta_value_num';
		}
		if($atts['orderby']=='date_review'){
			$atts['meta_key'] = 'review_total_score';
			$atts['orderby'] = 'date';
		}
		if($atts['orderby']=='best_review'){
			$atts['meta_key'] = 'review_total_score';
			$atts['orderby'] = 'meta_value_num';
		}*/
		echo block_nine_ajax_template($atts);
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_link'] = strip_tags($new_instance['title_link']);
		$instance['title_align'] = strip_tags($new_instance['title_align']);
		
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['clock'] = strip_tags($new_instance['clock']);
		$instance['indicator'] = strip_tags($new_instance['indicator']);
		$instance['category_name'] = strip_tags($new_instance['category_name']);
		$instance['tag'] = strip_tags($new_instance['tag']);
		$instance['posts_per_page'] = strip_tags($new_instance['posts_per_page']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['nav'] = strip_tags($new_instance['nav']);
		$instance['ad'] = strip_tags($new_instance['ad']);
		if ( current_user_can('unfiltered_html') )
			$instance['codes'] =  $new_instance['codes'];
		else
			$instance['codes'] = wp_unslash( wp_filter_post_kses( addslashes($new_instance['codes']) ) );
		$instance['codes_position'] = strip_tags($new_instance['codes_position']);

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$title_link = isset($instance['title_link']) ? esc_attr($instance['title_link']) : '';
		if (isset($instance['title_align'])) {
            $align_select = esc_attr($instance['title_align']);
        } else {
            $align_select ='';
        }
		
		$instance['number'] = isset($instance['number']) ? esc_attr($instance['number']) : true;
		$instance['clock'] = isset($instance['clock']) ? esc_attr($instance['clock']) : true;
		$instance['indicator'] = isset($instance['indicator']) ? esc_attr($instance['indicator']) : false;
		$category_name = isset($instance['category_name']) ? esc_attr($instance['category_name']) : '';
		$tag = isset($instance['tag']) ? esc_attr($instance['tag']) : '';
		$posts_per_page = isset($instance['posts_per_page']) ? esc_attr($instance['posts_per_page']) : '5';
		
		if (isset($instance['orderby'])) {
            $orderby_select = esc_attr($instance['orderby']);
        } else {
            $orderby_select ='';
        }
		if (isset($instance['order'])) {
            $order_select = esc_attr($instance['order']);
        } else {
            $order_select ='';
        }
		
		if (isset($instance['nav'])) {
            $nav_select = esc_attr($instance['nav']);
        } else {
            $nav_select ='';
        }
		
		$instance['ad'] = isset($instance['ad']) ? esc_attr($instance['ad']) : '';
		$codes = isset($instance['codes']) ? esc_textarea($instance['codes']) : '';
		$codes_position = isset($instance['codes_position']) ? esc_attr($instance['codes_position']) : '3';
		
	?>

		<!-- admin widget starts -->
		<div class="rd-widget-form">
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'abomb_backend'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Title URL:', 'abomb_backend'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_link'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="text" value="<?php echo esc_attr($title_link); ?>" />
			</p>
			<p>
				<label for="order"><?php _e('Title align:', 'abomb_backend'); ?></label>
				<select class="widefat" name="<?php echo $this->get_field_name('title_align'); ?>" id="<?php echo $this->get_field_id('title_align'); ?>">
					<option <?php if($align_select == 'left') { echo 'selected';} ?> value="left"><?php _e('Left', 'abomb_backend'); ?></option>
					<option <?php if($align_select == 'right') { echo 'selected';} ?> value="right"><?php _e('Right', 'abomb_backend'); ?></option>
					<option <?php if($align_select == 'center') { echo 'selected';} ?> value="center"><?php _e('Center', 'abomb_backend'); ?></option>
				</select>
			</p>
			
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="yes" <?php if( $instance['number'] ) echo 'checked="checked"'; ?> type="checkbox" />
				<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Show with ordered list?', 'abomb_backend'); ?></label>
				<small>Will not working if you using ajax load more</small>
			</p>
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id( 'indicator' ); ?>" name="<?php echo $this->get_field_name( 'indicator' ); ?>" value="yes" <?php if( $instance['indicator'] ) echo 'checked="checked"'; ?> type="checkbox" />
				<label for="<?php echo $this->get_field_id( 'indicator' ); ?>"><?php _e('Show post format indicator?', 'abomb_backend'); ?></label>
			</p>
			<p>
				<input class="widefat" id="<?php echo $this->get_field_id( 'clock' ); ?>" name="<?php echo $this->get_field_name( 'clock' ); ?>" value="yes" <?php if( $instance['clock'] ) echo 'checked="checked"'; ?> type="checkbox" />
				<label for="<?php echo $this->get_field_id( 'clock' ); ?>"><?php _e('Show clock?', 'abomb_backend'); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('category_name'); ?>"><?php _e('Categories:', 'abomb_backend'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('category_name'); ?>" name="<?php echo $this->get_field_name('category_name'); ?>" type="text" value="<?php echo esc_attr($category_name); ?>" />
				<small>If you want to narrow output, enter category <strong>SLUG</strong> here. Divide category with <strong>comma</strong>. Leave blank if show all category.</small>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Tags:', 'abomb_backend'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo esc_attr($tag); ?>" />
				<small>If you want to narrow output, enter tag <strong>SLUG</strong> here. Divide tag with <strong>comma</strong>. Leave blank if show all tag.</small>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('posts_per_page'); ?>"><?php _e('Post count:', 'abomb_backend'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('posts_per_page'); ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" type="text" value="<?php echo esc_attr($posts_per_page); ?>" />
			</p>

			<p>
				<label for="orderby"><?php _e('Order by:', 'abomb_backend'); ?></label>
				<select class="widefat" name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>">
					<option <?php if($orderby_select == 'none') { echo 'selected';} ?> value="none"><?php _e('None', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'date') { echo 'selected';} ?> value="date"><?php _e('Date', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'rand') { echo 'selected';} ?> value="rand"><?php _e('Random', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'ID') { echo 'selected';} ?> value="ID"><?php _e('ID', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'title') { echo 'selected';} ?> value="title"><?php _e('Title', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'comment_count') { echo 'selected';} ?> value="comment_count"><?php _e('Comment Count', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'post_views') { echo 'selected';} ?> value="post_views"><?php _e('Post View Count', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'date_review') { echo 'selected';} ?> value="date_review"><?php _e('Date Review (only show post that has a review)', 'abomb_backend'); ?></option>
					<option <?php if($orderby_select == 'best_review') { echo 'selected';} ?> value="best_review"><?php _e('Best Review (only show post that has a review)', 'abomb_backend'); ?></option>
				</select>
			</p>
		
			<p>
				<label for="order"><?php _e('Order:', 'abomb_backend'); ?></label>
				<select class="widefat" name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>">
					<option <?php if($order_select == 'DESC') { echo 'selected';} ?> value="DESC"><?php _e('Descending', 'abomb_backend'); ?></option>
					<option <?php if($order_select == 'ASC') { echo 'selected';} ?> value="ASC"><?php _e('Ascending', 'abomb_backend'); ?></option>
				</select>
			</p>
			
			<div class="rdWidget-block">
				<p>
					<label for="order"><?php _e('Pagination:', 'abomb_backend'); ?></label>
					<select class="widefat" name="<?php echo $this->get_field_name('nav'); ?>" id="<?php echo $this->get_field_id('nav'); ?>">
						<option <?php if($nav_select == 'none') { echo 'selected';} ?> value="none"><?php _e('None', 'abomb_backend'); ?></option>
						<option <?php if($nav_select == 'numbered') { echo 'selected';} ?> value="numbered"><?php _e('Numbered', 'abomb_backend'); ?></option>
						<option <?php if($nav_select == 'ajax') { echo 'selected';} ?> value="ajax"><?php _e('Load more button', 'abomb_backend'); ?></option>
					</select>
				</p>
			</div>
			
			<div class="rdWidget-block">
				<p>
					<input class="widefat" id="<?php echo $this->get_field_id( 'ad' ); ?>" name="<?php echo $this->get_field_name( 'ad' ); ?>" value="yes" <?php if( $instance['ad'] ) echo 'checked="checked"'; ?> type="checkbox" />
					<label for="<?php echo $this->get_field_id( 'ad' ); ?>"><?php _e('Show ad codes beetwen posts?', 'abomb_backend'); ?></label>
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id('codes'); ?>"><?php _e('Ad codes:', 'abomb_backend'); ?></label>
					<textarea name="<?php echo $this->get_field_name('codes'); ?>" id="<?php echo $this->get_field_id('codes'); ?>" cols="30" rows="8"><?php echo $codes; ?></textarea>
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id('codes_position'); ?>"><?php _e('Ad codes position on after posts loop number:', 'abomb_backend'); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('codes_position'); ?>" name="<?php echo $this->get_field_name('codes_position'); ?>" type="text" value="<?php echo esc_attr($codes_position); ?>" />
				</p>
			</div>
			
		</div>
		<!-- admin widget ends -->
<?php
	}
}

// register widget
function ReedwanWidgets__block9_register_widgets() {
	register_widget( 'ReedwanWidgets__block9' );
}

add_action( 'widgets_init', 'ReedwanWidgets__block9_register_widgets' );
?>