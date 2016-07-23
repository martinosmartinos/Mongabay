<!-- WPE -->
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' );?>" />
<?php if(rd_options('abomb_responsive') == 1): ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

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
</head>
<?php if (mongabay_sub()=='images' || is_page_template( 'templates/template-simple.php' )) $GLOBALS['sidebar_layout'] = 'right'; ?>
<body <?php body_class(array($GLOBALS['responsive'],'subdomain-'.mongabay_sub())); ?> itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WebPage"<?php echo $GLOBALS['theme_bg']; ?>>
<?php if (mongabay_is_legacy_post()): ?>
	<div id="fb-root"></div> 
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=1649584218610569";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <?php endif; ?>
  <?php if (mongabay_sub()=='kidsnews'): ?><div id="kidsnews-bg"></div><?php endif; ?>
<?php if ( $GLOBALS['top_header'] == 1 ): ?>
<div class="top-wrap deskpadview clearfix">
  <div class="boxed clearfix">
    <?php if ( has_nav_menu( 'top_menu' ) && $GLOBALS['top_nav'] == 1 ): ?>
    <nav role="navigation" class="top-menu el-left" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/SiteNavigationElement">
      <?php 
						$arg = array(
							'container' =>false, 
							'theme_location' => 'top_menu', 
							'menu_id' => 'topnav',
							'menu_class' => 'topnav',
							'depth' => 1,
							'walker' => new rd_mega_walker()
						);
						wp_nav_menu( $arg );
					?>
    </nav>
    <?php endif; ?>
    <?php if ( $GLOBALS['top_news'] == 1 && $GLOBALS['top_nav'] == 0): ?>
    <?php
					$title = '';
					if (rd_options( 'abomb_news_title')) { $title = rd_options( 'abomb_news_title'); }
					$icon = "right"; if (is_rtl()) { $icon= 'left';}
				?>
    <div class="headline-news-wrap el-left">
      <?php if($title != ''): ?>
      <div class="headline-news-title el-left"><?php echo esc_attr($title); ?><i class="fa fa-chevron-<?php echo $icon; ?>"></i></div>
      <?php endif; ?>
      <?php get_template_part('parts/headline-news'); ?>
    </div>
    <?php endif; ?>
    <?php if ( $GLOBALS['top_social'] == 1 && $GLOBALS['top_time'] == 0): ?>
    <?php if ((rd_options('abomb_email') || rd_options('abomb_twitter') ||rd_options('abomb_facebook') || rd_options('abomb_dribbble') || rd_options('abomb_rss') || rd_options('abomb_github') || rd_options('abomb_linkedin') || rd_options('abomb_pinterest') || rd_options('abomb_google') || rd_options('abomb_instagram') || rd_options('abomb_skype') || rd_options('abomb_soundcloud') || rd_options('abomb_youtube') || rd_options('abomb_vimeo') || rd_options('abomb_tumblr') || rd_options('abomb_flickr')) && rd_options('abomb_show_footer_social')==1): ?>
    <div class="social-head el-right"> <span class="toplinks">
      <?php get_template_part('parts/header-reg'); ?>
      </span>
      <?php get_template_part('parts/social'); ?>
      <?php if ( function_exists('icl_object_id') ) do_action('icl_language_selector'); ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ( $GLOBALS['top_time'] == 1): ?>
    <div class="top-time el-right deskview"><i class="fa fa-clock-o"></i><?php echo date_i18n(esc_attr($GLOBALS['top_time_format'])); ?></div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>
<div class="layout-wrap <?php echo $GLOBALS['theme_layout']; ?>">
<?php
				$sticky = '';
				if (rd_options('abomb_'.$GLOBALS['header_style'].'_sticky')) {
					$sticky = ' '.$GLOBALS['header_style'];
				}
			?>
<header role="banner" class="header-wrap clearfix<?php echo $sticky; ?>" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WPHeader">
<?php
					if ($GLOBALS['header_style'] == 'header5'){
						get_template_part('parts/header5');
					}
					else if ($GLOBALS['header_style'] == 'header4'){
						get_template_part('parts/header4');
					}
					else {
						get_template_part('parts/header123');
					}
				?>
<div id="sb-site">
<?php $has_slider = ""; ?>
<?php if (is_page_template( 'templates/template-home.php' ) && empty($GLOBALS['section_homepage']) ): ?>
<?php if (rd_field( 'abomb_show_slider')=='slider'): ?>
<?php $has_slider = " haveslider"; ?>
<div class="slider-wrap clearfix">
  <?php 
									if (rd_field( 'abomb_slider_type')=='type_2') {
										get_template_part('parts/slider2'); 
									}
									else {
										get_template_part('parts/slider');
										 if(rd_field( 'abomb_slider_nav')==1){ $has_slider = " havenav haveslider"; }
									}
								?>
</div>
<?php elseif (rd_field( 'abomb_show_slider')=='featured_grid'): ?>
<?php $has_slider = " haveslider"; ?>
<div class="featured-grid-wrap clearfix">
  <?php get_template_part('parts/featured-grid'); ?>
</div>
<?php endif; ?>
<?php endif; ?>
<div class="clearfix">
  <?php 
							if (is_single()) {
								if ($GLOBALS['media_position']  == 'fullwidth'){
									global $detect;
									$the_thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'mobile-full' );
									$thumbnail_src = esc_url($the_thumbnail_src[0]);
									$check_thumb = strpos($thumbnail_src, '480x240'); 
									if( $check_thumb && $detect->isMobile() && !$detect->isTablet() ) {
										echo single_featured_image('mobile-layout', $GLOBALS['video'], $GLOBALS['audio'], $GLOBALS['gallery'],'no'); 
									}
									else {
										echo single_featured_image('full-layout', $GLOBALS['video'], $GLOBALS['audio'], $GLOBALS['gallery'],'no'); 
									}
								}
							}
						?>
</div>
<?php if (is_page_template( 'templates/template-contact.php' )): ?>
<?php
							$address = rd_field( 'abomb_contact_address');
							$latitude = rd_field( 'abomb_contact_latitude');
							$longitude = rd_field( 'abomb_contact_longitude');
							$zoom = rd_field( 'abomb_contact_zoom');
							$mapHeight = rd_field( 'abomb_contact_height');
							$mapHeight = str_replace(array( 'px', ' ' ), array( '', '' ), $mapHeight);
						?>
<div class="entry-map">
  <div id="contact_map" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>" data-zoom="<?php echo esc_attr($zoom); ?>" data-height="<?php echo esc_attr($mapHeight); ?>" data-address="<?php echo esc_attr($address); ?>"></div>
</div>
<?php endif; ?>
<div class="main-wrap<?php echo $has_slider; ?> clearfix">
<div class="row main-wrap-row clearfix">
<?php 
								if($GLOBALS['sidebar_layout'] == 'left' || $GLOBALS['sidebar_layout'] == 'double') {
									get_sidebar( 'left' ); 
								}
								$scope = '';
								if ( is_author() ) {
									$scope = ' itemprop="mainContentOfPage" itemscope="itemscope" itemtype="'. rd_ssl() .'://schema.org/ProfilePage"';
								}
								else if (is_single() || is_archive() || is_home() || is_front_page() || is_page_template( 'templates/template-home.php' ) ) {
									$scope = ' itemprop="mainContentOfPage" itemscope="itemscope" itemtype="'. rd_ssl() .'://schema.org/Article"';
								}
								else if (is_page() || is_attachment()) {
									$scope = ' itemprop="mainContentOfPage" itemscope="itemscope" itemtype="'. rd_ssl() .'://schema.org/CreativeWork"';
								}
								else if ( is_search() ) {
									$scope = ' itemprop="mainContentOfPage" itemscope="itemscope" itemtype="'. rd_ssl() .'://schema.org/SearchResultsPage"';
								}
								
							                            
                            if(is_single()){
                            	?>
<div id="post-<?php the_ID(); ?>" <?php post_class('single-post category-'.get_field("post_category")); ?> itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/Article">
<div class="header-tags">
  <?php
	global $sitepress;
	$locations =  array_slice(mongabay_get_object_terms_in_lang(get_the_ID(), 'location' , array('orderby' => 'count', 'order' => 'DESC')),0,4);
	$i=0;
	foreach ($locations as $location) {
		if (function_exists('icl_object_id') && ICL_LANGUAGE_CODE!='en') {	
			remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
			$original_id = icl_object_id( $location->term_id, $location->taxonomy, true, 'en' );
			$original_ob = get_term( $original_id, $location->taxonomy );
			add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
			$slug = $original_ob->slug;
		} else $slug = $location->slug;
		
		echo '<a class="header-tag header-tag-location '.((!$i++)?'header-tag-first':'').'" href="'.mongabay_url('location'.(get_post_type()=='image'?'-image':''),$slug, ICL_LANGUAGE_CODE).'"><span itemprop="articleSection">'.$location->name.'</span></a>';
	}
		 
	$topics =  array_slice(mongabay_get_object_terms_in_lang(get_the_ID(), 'topic' , array('orderby' => 'count', 'order' => 'DESC')),0,4);
	$i=0;
	foreach ($topics as $topic) {
		if (function_exists('icl_object_id') && ICL_LANGUAGE_CODE!='en') {	
			remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
			$original_id = icl_object_id( $topic->term_id, $topic->taxonomy, true, 'en' );
			$original_ob = get_term( $original_id, $topic->taxonomy );
			add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
			$slug = $original_ob->slug;
		} else $slug = $topic->slug;
		
		echo '<a class="header-tag header-tag-topic '.((!$i++)?'header-tag-first':'').'"  href="'.mongabay_url('topic'.(get_post_type()=='image'?'-image':''),$slug,ICL_LANGUAGE_CODE).'"><span itemprop="articleSection">'.$topic->name.'</span></a>';
	}
?>
</div>
<?php if (get_post_type()=='post'): ?>
<div class="subheader <?php echo ((get_post_meta(get_the_ID(),'mongabay_post_legacy_status',true)=='yes')?'subheader-legacy':'subheader-new'); ?>">
  
  <div class="entryheader"> <?php echo mongabay_post_headermeta(get_field("post_category"),get_post_format()); ?>
    <?php
$serials = wp_get_object_terms(get_the_ID(), 'serial' , array('orderby' => 'count', 'order' => 'DESC'));
foreach ($serials as $serial)  $sline[] = '<a href="'.mongabay_url('serial',$serial->slug).'">'.$serial->name.'</a>';
if (!empty($sline)) echo __('Mongabay Series','mongabay-theme').': ',implode(', ',$sline); 
?>
    <?php echo content_single_title(); ?>
    <div class="authorportlet"> <?php echo content_meta_complete_date(); ?>
    <?php mongabay_authorslink(get_the_ID()); ?>
  </div>
<?php
	if ($tid = get_post_meta(get_the_ID(),'translated_by',true)) {
		$translator = get_term($tid,'author');
		echo '<div class="translatorline"><span>'.__('Translated by','mongabay-theme').'</span> <a href="'.mongabay_url('author',$translator->slug).'">'.$translator->name.'</a></div>';
	}
?>
    <h2 class="tagline" itemprop="description" >
  <?php //the_excerpt(); 
    echo get_post_meta(get_the_ID(),"mog_tagline",true);
    ?>
    </h2>
  </div>
  <?php 
  if (get_post_format()=='aside') $featured_format = 'full'; else $featured_format='single'; 
  echo single_featured_image($featured_format, 0, 0, 0,'no'); ?> </div>
<?php elseif (get_post_type()=='image'): 
get_template_part('image-header'); 
endif; 

?>
<?php if (get_post_format() =='aside') { set_query_var( 'video', $GLOBALS['video']); get_template_part( 'single', 'featured' ); } ?>
<?php 	
		} elseif (!empty($GLOBALS['images_header'])) echo $GLOBALS['images_header'];

		?>
<main role="main" class="main-grid main-content <?php echo $GLOBALS['sidebar_layout']; ?>-main-content <?php echo (is_single()?'main-singlepost':'')?>">
