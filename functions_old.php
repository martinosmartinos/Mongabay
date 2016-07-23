<?php
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


add_action( 'wp_enqueue_scripts', 'mongabay_theme_scripts');
function mongabay_theme_scripts() {
	$sub = mongabay_sub();
	$par_style_path = get_template_directory_uri().'/style.css';
	if ($sub!='www') $par_style_path = str_replace('://www.','://'.$sub.'.',$par_style_path);
	
	wp_enqueue_style( 'parent-style' );
	
	$styles = array('general','front','single','mobile','extra');
	foreach ($styles as $style) {
		//wp_enqueue_style( 'mongabay-'.$style.'-style', get_stylesheet_directory_uri() .'/css/'.$style.'.css' );
		wp_enqueue_style( 'mongabay-'.$style.'-style', get_stylesheet_directory_uri() .'/css/'.$style.'.css?'.filemtime( get_stylesheet_directory() . '/css/'.$style.'.css') );
	} 
	wp_dequeue_style('screen');
	wp_deregister_style('screen');
	
	wp_register_script('mongabay-theme-source', get_stylesheet_directory_uri() . '/js/source.js', false,false,true);
	wp_enqueue_script('mongabay-theme-source');
	
	wp_register_script('mongabay-theme-init', get_stylesheet_directory_uri() . '/js/init.js?'.filemtime( get_stylesheet_directory() . '/js/init.js'), false,false,true);
	//	wp_register_script('mongabay-theme-init-header', get_stylesheet_directory_uri() . '/js/init-header.js?'.filemtime( get_stylesheet_directory() . '/js/init-header.js') );

	//wp_register_script('mongabay-theme-cacheactions', get_stylesheet_directory_uri() . '/js/cacheactions.js?'.filemtime( get_stylesheet_directory() . '/js/cacheactions.js'), false,false,true);
	
	
	wp_enqueue_script('mongabay-theme-init');
	//wp_enqueue_script('mongabay-theme-init-header');
	wp_enqueue_script('mongabay-theme-cacheactions');
}

function mongabay_jquery_in_footer() {
	if ( !(is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' )) )) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.11.2', true);
		wp_enqueue_script('jquery');
	}
}
add_action('wp_enqueue_scripts', 'mongabay_jquery_in_footer',1);

// TDM Lines removed -- error and version suppression

/* Theme functions customization starts here
-------------------------------------------------------------- */

/* AFTER THEME SETUP */
function mongabay_features() {
	// Post Formats
	add_theme_support( 'post-formats', array( 'aside','video','chat' ) );
	
	add_theme_support( 'post-thumbnails' );
	/*add_image_size( 'double-sidebar', 520, 330, true );
	add_image_size( 'thumbnail', 135, 135, true );*/
	remove_image_size('shop_thumbnail');
	remove_image_size('shop_catalog');
	remove_image_size('shop_single');
	add_image_size( 'single', 850, 310, true );
	add_image_size( 'mediumthumb', 251, 159, true );
	add_image_size( 'megamenu', 200, 133, true );
}


add_action( 'after_setup_theme', 'mongabay_features', 20 );


/* Re-written elements from main theme */
require_once ( 'elements/element.php' );
require_once ( 'elements/content.php' );
require_once ( 'includes/megamenu/mega-menu.php' );
require_once ( 'includes/login-reg.php' );

/* Custom Elements */
require_once ( 'elements/home.php' );
require_once ( 'elements/images.php' );
require_once ( 'elements/comment.php');


/* EXTRA MENUS */
function mongabay_register_menus() {
  register_nav_menus(
    array(
      'footer-left-menu' => __( 'Footer Menu - Left (Information)' ),
      'footer-right-menu' => __( 'Footer Menu - Right (Other Sites)' )
    )
  );
}
add_action( 'init', 'mongabay_register_menus' );

/* LAYOUT FOR SECION HOMEPAGES */
$sub = mongabay_sub();
if (($_SERVER['REQUEST_URI']=='/' || !$_SERVER['REQUEST_URI']) && !($sub=='www' || !$sub)) {
	$GLOBALS['section_homepage']=true;
}


/* NICE TITLE */
add_filter( 'wp_title', 'mongabay_wp_title', 100, 2 );
function mongabay_wp_title( $title, $sep ) {
	if (is_front_page())
		return __("Mongabay Environmental News",'Mongabay');
	elseif (is_single() || is_page()) 
		return get_the_title();
	
	return $title;
}
