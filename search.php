<?php get_header(); ?>
<div class="archive-wrap">
	<div class="archive-head clearfix">
		<div class="archive-title clearfix">
			<h1><?php printf( __( 'Search Results for "%s"', 'abomb' ), get_search_query() ); ?></h1>
			<a class="rss-link" href="<?php echo esc_url(get_search_feed_link( get_search_query() )); ?>" target="_blank"><i class="fa fa-rss deskpadview"></i></a>
		</div>
	</div>
	<div class="archive-search clearfix">
		<p><?php echo __("If you're not happy with the results, please do another search or","mongabay-theme"); ?> <b><a href="#googlesearch"><?php echo __("use our full site search function","mongabay-theme"); ?></a><b>.</p>
		<?php get_search_form(); ?>
	</div>
	<?php
		$post_loop_count = 1;
		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if($page > 1) $post_loop_count = ((int) ($page - 1) * (int) get_query_var('posts_per_page')) +1;
		
	?>
	<div class="block">
	<?php if (have_posts()) : ?> 
		<?php while (have_posts()) : the_post(); ?>
			<div class="search-post clearfix" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/BlogPosting">
				<span class="search-number el-left"><?php echo $post_loop_count; ?></span>
				<div class="entry-header">
					<?php echo content_title(); ?>
					<div class="entry-meta">
						<?php echo content_meta_complete_date(); ?><span class="meta-author"><?php mongabay_authorslink(get_the_ID()); ?></span> - 
					</div>
				</div>
				<div class="entry-content">
					<?php echo word_count(get_the_excerpt(),40); ?>
				</div>
			</div>
		<?php $post_loop_count++; ?>
		<?php endwhile; wp_reset_postdata(); ?>
		<?php rd_pagination(); ?>
		
	<?php else: ?>
		<div class="block search-post clearfix">
			<div class="search-number el-left"><i class="fa fa-exclamation"></i></div>
			<div class="entry-content no-post">
				<?php echo __('Sorry, no posts matched your criteria. Please try another search.','abomb'); ?>
			</div>
		</div>
	<?php endif; ?>
	</div>
    
    <div class="google-search" id="googlesearch">
    	<p><?php echo __("If you're not happy with the results, please do another search or use our full site search function.","mongabay-theme"); ?></p>
		<form action=" https://news.mongabay.com/search-results/" id="cse-search-box">
			 <div>
			   <input type="hidden" name="cx" value="partner-pub-7638076456673025:1053415248" />
			   <input type="hidden" name="cof" value="FORID:10" />
			   <input type="hidden" name="ie" value="UTF-8" />
			   <input type="text" name="q" size="55" />
			   <input type="submit" name="sa" value="Search" />
			 </div>
		</form>

		<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>
    </div>
    
</div>
<?php get_footer(); ?>