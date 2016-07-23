<?php 
if ($_SERVER['REQUEST_URI']!='/404'):
	header('HTTP/1.1 301 Moved Permanently'); 
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/404');
else:
	header("HTTP/1.0 404 Not Found");
	get_header(); ?>
	<div class="error-wrap">
		<h1 class="error-title center"><?php echo __('Ooops... Error 404','abomb') ?></h1> 
		<p class="error-desc center"><?php echo __("We're sorry, but the page you are looking for doesn't exist.","abomb"); ?></p>
		<BR>

			<style type="text/css">
			@import url(//www.google.com/cse/api/branding.css);
			</style>
			<div class="cse-branding-bottom center" style="background-color:#FFFFFF;color:#000000">
			  <div class="cse-branding-form center">
			    <form action="http://www.google.com" id="cse-search-box" target="_blank">
			      <div>
			        <input type="hidden" name="cx" value="partner-pub-7638076456673025:8482957247" />
			        <input type="hidden" name="ie" value="UTF-8" />
			        <input type="text" name="q" size="58" />
			        <input type="submit" name="sa" value="Search" />
			      </div>
			    </form>
			  </div>
			  <div class="cse-branding-logo center">
			    <img src="http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif" alt="Google" />
			  </div>
			</div>


		<BR>
		<div class="error-button center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button medium"><span><i class="fa fa-long-arrow-left"></i> <?php _e('Back To Homepage','abomb');?></span></a></div>
	</div> 
	<?php get_footer(); endif; ?>