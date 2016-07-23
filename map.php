<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?> class="map-html" >
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' );?>" />
<?php if(rd_options('abomb_responsive') == 1): ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php endif; ?>
<?php if ( ! function_exists( '_wp_render_title_tag' ) ): ?>
<title>
<?php wp_title( '|', true, 'right' ); ?>
</title>
<?php endif; ?>
<link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>" />
<?php if(rd_options_array('abomb_favicon','url')): ?>
<link rel="shortcut icon" href="<?php echo esc_url(rd_options_array('abomb_favicon','url')); ?>" type="image/x-icon" />
<?php endif; ?>
<?php if(rd_options_array('abomb_iphone_icon','url')): ?>
<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url(rd_options_array('abomb_iphone_icon','url')); ?>">
<?php endif; ?>
<?php if(rd_options_array('abomb_iphone_icon_retina','url')): ?>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo esc_url(rd_options_array('abomb_iphone_icon_retina','url')); ?>">
<?php endif; ?>
<?php if(rd_options_array('abomb_ipad_icon','url')): ?>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo esc_url(rd_options_array('abomb_ipad_icon','url')); ?>">
<?php endif; ?>
<?php if(rd_options_array('abomb_ipad_icon_retina','url')): ?>
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo esc_url(rd_options_array('abomb_ipad_icon_retina','url')); ?>">
<?php endif; ?>
<?php wp_head(); ?>
<?php
	$maptype = 'news';
	$section = get_query_var('section');
	if ($section=='mapimages') $maptype = 'images';
	mongamap_head($maptype); 
?>
</head>

<body <?php body_class(array($GLOBALS['responsive'],'subdomain-'.mongabay_sub())); ?> itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WebPage"<?php echo $GLOBALS['theme_bg']; ?>>
	<div class="layout-wrap fluid">
		<header role="banner" class="header-wrap clearfix header1" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WPHeader">
       		<?php get_template_part('parts/header-map'); ?>
       	</header>
       <div id="map-container">
	   		<?php mongamap_init_map($maptype); ?>
       </div>
 	</div>

<?php wp_footer(); ?>

</body>
</html>