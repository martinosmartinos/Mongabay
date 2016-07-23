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
		<div class="error-button center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button medium"><span><i class="fa fa-long-arrow-left"></i> <?php _e('Back To Homepage','abomb');?></span></a></div>
	</div> 
	<?php get_footer(); endif; ?>