<?php
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


add_action( 'wp_enqueue_scripts', 'mongabay_theme_scripts');

function mongabay_theme_scripts() {
	$sub = mongabay_sub();
	//$par_style_path = get_template_directory_uri().'/style.css';
	//if ($sub!='www') $par_style_path = str_replace('://www.','://'.$sub.'.',$par_style_path);
	
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	
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

	wp_register_script('mongabay-theme-cacheactions', get_stylesheet_directory_uri() . '/js/cacheactions.js?'.filemtime( get_stylesheet_directory() . '/js/cacheactions.js'), false,false,true);
	
	
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

function theme_translate() {
    load_child_theme_textdomain( 'mongabay-theme', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'theme_translate' );

function mongabay_features() {
	// Post Formats
	add_theme_support( 'post-formats', array( 'aside','video','chat','featured' ) );
	
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

/* LAYOUT FOR SECTION HOMEPAGES */
$sub = mongabay_sub();
if (($_SERVER['REQUEST_URI']=='/' || !$_SERVER['REQUEST_URI']) && !($sub=='www' || !$sub)) {
	$GLOBALS['section_homepage']=true;
}


/* NICE TITLE */
// add_filter( 'wp_title', 'mongabay_wp_title', 10, 2 );
// function mongabay_wp_title( $title, $sep ) {
// 	if (is_front_page())
// 		return __("Mongabay Environmental News",'Mongabay');
// 	elseif (is_single() || is_page()) 
// 		return get_the_title();
// 	elseif (get_query_var('nc1') !=='' || get_query_var('nc2') !==''){
// 		$taxname = get_query_var('nc1');
// 		//var_dump($taxname);
// 		return $taxname.'news';
// 	}
// 	return $title.'news';
// }

/* Parallax JS */
if (get_post_format() =='aside'){
	add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );
	function add_theme_scripts() {
		wp_enqueue_script( 'parallax', get_stylesheet_directory_uri() . '/js/jquery.parallax-1.1.3.js', array(), '1.1.3', true );
		wp_enqueue_script( 'custom-parallax', get_stylesheet_directory_uri() . '/js/custom-parallax.js', array(), '1.0', true );
	}
}

/* Parallax Shortcode */
add_shortcode('parallax-img','parallax_img');
function parallax_img($atts){
	extract(shortcode_atts(array('imagepath' => 'Image Needed','id' => '1', 'px_title' => 'Slide Title', 'title_color' => '#FFFFFF' , 'img_caption' => 'Your image caption'),$atts));
 	return "<section class='parallax' id='".$id."' style='background-image: url(".$imagepath."); background-position: 50% -80px;'><div class='title-outer'><div class='title-inner'><span style='color:".$title_color."'>".$px_title."</span></div></div><figcaption class='wp-caption-text'>".$img_caption."</figcaption></section>";
}

add_shortcode('open-parallax-content','parallax_open');
function parallax_open(){
 return "<div class='parallax_container'><div class='parallax_content'><article itemprop='articleBody' class='entry-content-text'>";
}

add_shortcode('close-parallax-content','parallax_close');
function parallax_close(){
 return "</article></div></div>";
}

/* Parallax Slide Shortcode Button in a text editor*/
function px_shortcode_button()
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
               
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton(
                    "parallax_shortcode",
                    "ParallaxSlide",
                    callback
                );

                function callback()
                {
                    var selected_text = getSel();
                    QTags.insertContent("[parallax-img imagepath='image_url' id='1' px_title='First Title' title_color='#333333' img_caption='Your image caption']");
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "px_shortcode_button");

/* Parallax Content Shortcode Button in a text editor*/
function open_close_px_content()
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
               
                function getSel()
                {
                    var txtarea = document.getElementById("content");
                    var start = txtarea.selectionStart;
                    var finish = txtarea.selectionEnd;
                    return txtarea.value.substring(start, finish);
                }

                QTags.addButton(
                    "pxcontent_shortcode",
                    "ParallaxContent",
                    callback
                );

                function callback()
                {
                    var selected_text = getSel();
                    QTags.insertContent("[open-parallax-content]" +  selected_text + "[close-parallax-content]")
                }
            </script>
        <?php
    }
}
add_action("admin_print_footer_scripts", "open_close_px_content");