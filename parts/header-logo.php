<?php
if (is_single() && mongabay_sub()=='news'&& get_post_meta(get_the_ID(),"news_category",true)) {
	$logo = 'https://wildtech.mongabay.com/wp-content/uploads/sites/22/2016/06/mongabay_wildtech_logo_137x37.jpg';
	$logoWidth = 137;
	$logoHeight = 37;
	$logo_retina = 'https://wildtech.mongabay.com/wp-content/uploads/sites/22/2016/06/mongabay_wildtech_logo.jpg';
}
else {
	if(rd_options_array('abomb_'.$GLOBALS['header_style'].'_logo','url')) {
		$logo = rd_options_array('abomb_'.$GLOBALS['header_style'].'_logo','url');
		$logoWidth = rd_options_array('abomb_'.$GLOBALS['header_style'].'_logo','width');
		$logoHeight = rd_options_array('abomb_'.$GLOBALS['header_style'].'_logo','height');
	}
	else{
		$logo = get_template_directory_uri() . '/images/'.$GLOBALS['header_style'].'-logo.png';
		$logoWidth = 137;
		$logoHeight = 28;
	}
	if(rd_options_array('abomb_'.$GLOBALS['header_style'].'_logo_retina','url')) {
		$logo_retina = rd_options_array('abomb_'.$GLOBALS['header_style'].'_logo_retina','url');
	}
	else {
		$logo_retina = '';
	}
}
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<img class="logo-img" src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr(bloginfo('name')); ?>" width="<?php echo esc_attr($logoWidth); ?>" height="<?php echo esc_attr($logoHeight); ?>" data-logoretina="<?php echo esc_url($logo_retina); ?>"/>
</a>
<?php if( is_home() || is_front_page()): ?>
	<h1 class="site-title hide-text" itemprop="headline"><?php bloginfo('name'); ?></h1>
	<h2 class="site-description hide-text" itemprop="description"><?php bloginfo( 'description' ); ?></h2>
<?php else: ?>
	<p class="site-title hide-text" itemprop="headline"><?php bloginfo('name'); ?></p>
	<p class="site-description hide-text" itemprop="description"><?php bloginfo( 'description' ); ?></p>
<?php endif; ?>