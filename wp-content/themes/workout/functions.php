<?php

/*-----------------------------------------------------------------------------------

	Below we have all of the custom functions for the theme
	Please be extremely cautious editing this file!

-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Global theme variables
/*-----------------------------------------------------------------------------------*/
$theme = wp_get_theme();
$themename = $theme->Name;
$shortname = "t2t";

// Customizer
require_once(get_template_directory() . '/includes/customizer.php');

// Plugin activation
require_once(get_template_directory()  . '/includes/plugins.php');

// Shortcode filters and extensions
require_once(get_template_directory()  . '/includes/shortcodes.php');

// Widget filters and extensions
require_once(get_template_directory()  . '/includes/widgets.php');

// Metabox filters and extensions
require_once(get_template_directory()  . '/includes/meta_boxes.php');

// Theme colors
require_once(get_template_directory()  . '/stylesheets/theme_colors.php');

/**
 * meta boxes
 *
 */
foreach(scandir(get_template_directory() . "/includes/page_template_options") as $filename) {
  $path = get_template_directory() . '/includes/page_template_options/' . $filename;

  if(is_file($path) && preg_match("/template-[a-z_-]+.php/", $filename)) {
    require_once($path);
  }
}


/*-----------------------------------------------------------------------------------*/
/*	Add Localization Support
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain('framework', get_template_directory() . '/languages');

/*-----------------------------------------------------------------------------------*/
/*	Set Max Content Width
/*-----------------------------------------------------------------------------------*/

if(!isset($content_width)) {
 $content_width = 940;
}

add_theme_support('automatic-feed-links');

function t2t_layout_style($classes) {

  $current_layout = array();

  // If homepage template
	if(is_page_template("template-home.php")) {
		$classes[] = "homepage";
	}

	// Set animation style
	if(get_theme_mod("t2t_customizer_animation_style")) {
		$classes[] = "animate-".get_theme_mod("t2t_customizer_animation_style", "flip");
	} else {
		$classes[] = "animate-flip";
	}

	// Set theme color
	if(get_theme_mod("t2t_customizer_theme_color")) {
		$classes[] = "theme-".get_theme_mod("t2t_customizer_theme_color", "flip");
	} else {
		$classes[] = "theme-light";
	}

	// Set header style
	if(get_theme_mod("t2t_customizer_header_style") == "centered") {
		$classes[] = "header-centered";
	}

	return $classes;
}
add_filter('body_class','t2t_layout_style');

function t2t_header_layout() {

	$classes = array();

	if(get_theme_mod("t2t_customizer_header_style") == "centered") {
		$classes[] = "centered";
	}

	return join(" ", $classes);
}

/*-----------------------------------------------------------------------------------*/
/*	WooCommerce support
/*-----------------------------------------------------------------------------------*/

add_theme_support('woocommerce');

/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/

if(function_exists('register_sidebar')) {
	register_sidebar(array(
		"id"                => "blog-sidebar",
		"name"              => __("Blog", "framework"),
		"description"       => __("Appears on the blog template.", "framework"),
    "before_widget"     => '<div id="%1$s" class="widget %2$s">',
		"after_widget"      => "</div>",
		"before_title"      => "<h5>",
		"after_title"       => "</h5>"
	));

	register_sidebar(array(
		"id"                => "page-sidebar",
		"name"              => __("Page", "framework"),
		"description"       => __("Appears on page templates.", "framework"),
    "before_widget"     => '<div id="%1$s" class="widget %2$s">',
		"after_widget"      => "</div>",
		"before_title"      => "<h5>",
		"after_title"       => "</h5>"
	));

  register_sidebar(array(
    "id"                => "footer-widget-1",
    "name"              => __("Footer Widget 1", "framework"),
    "description"       => __("Appears in the footer area.", "framework"),
    "before_widget"     => '<div id="%1$s" class="widget %2$s">',
    "after_widget"      => "</div>",
    "before_title"      => "<h5 class=\"widget-title\">",
    "after_title"       => "</h5>"
  ));

  register_sidebar(array(
    "id"                => "footer-widget-2",
    "name"              => __("Footer Widget 2", "framework"),
    "description"       => __("Appears in the footer area.", "framework"),
    "before_widget"     => '<div id="%1$s" class="widget %2$s">',
    "after_widget"      => "</div>",
    "before_title"      => "<h5 class=\"widget-title\">",
    "after_title"       => "</h5>"
  ));

  register_sidebar(array(
    "id"                => "footer-widget-3",
    "name"              => __("Footer Widget 3", "framework"),
    "description"       => __("Appears in the footer area.", "framework"),
    "before_widget"     => '<div id="%1$s" class="widget %2$s">',
    "after_widget"      => "</div>",
    "before_title"      => "<h5 class=\"widget-title\">",
    "after_title"       => "</h5>"
  ));

  register_sidebar(array(
    "id"                => "footer-widget-4",
    "name"              => __("Footer Widget 4", "framework"),
    "description"       => __("Appears in the footer area.", "framework"),
    "before_widget"     => '<div id="%1$s" class="widget %2$s">',
    "after_widget"      => "</div>",
    "before_title"      => "<h5 class=\"widget-title\">",
    "after_title"       => "</h5>"
  ));
}

/*-----------------------------------------------------------------------------------*/
/*	Google typography settings
/*-----------------------------------------------------------------------------------*/

if(function_exists('register_typography')) {
  register_typography(array(
    'logo' => array(
    	'preview_text' => 'Website Name',
    	'preview_color' => 'light',
    	'font_family' => 'Exo',
    	'font_variant' => 'normal',
    	'font_size' => '40px',
    	'font_color' => '#444444',
    	'css_selectors' => 'header .logo'
    ),
		'slider_titles' => array(
    	'preview_text' => 'Slider Titles',
    	'preview_color' => 'light',
    	'font_family' => 'Open Sans',
    	'font_variant' => '300',
    	'font_size' => '45px',
    	'font_color' => '#555555',
    	'css_selectors' => '.slide-content .title'
    ),
		'slider_captions' => array(
    	'preview_text' => 'Slider Captions',
    	'preview_color' => 'light',
    	'font_family' => 'Open Sans',
    	'font_variant' => '300',
    	'font_size' => '18px',
    	'font_color' => '#555555',
    	'css_selectors' => '.slide-content .caption'
    ),
		'paragraphs' => array(
    	'preview_text' => 'Paragraph Text',
    	'preview_color' => 'light',
    	'font_family' => 'Open Sans',
    	'font_variant' => 'normal',
    	'font_size' => '14px',
    	'font_color' => '#8a8a8a',
    	'css_selectors' => 'p'
    )
  ));
}

/*-----------------------------------------------------------------------------------*/
/*	If WP 3.0 or > include support for wp_nav_menu()
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'primary-menu' => __('Main Menu', 'framework' )
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Gravatar Support
/*-----------------------------------------------------------------------------------*/
function t2t_custom_gravatar( $avatar_defaults ) {
    $tz_avatar = get_template_directory_uri() . '/images/gravatar.png';
    $avatar_defaults[$tz_avatar] = 'Custom Gravatar (/images/gravatar.png)';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 't2t_custom_gravatar' );

/*-----------------------------------------------------------------------------------*/
/*	Add/configure thumbnails
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );

	// change the default thumbnail size
	update_option("thumbnail_size_w", 290);
	update_option("thumbnail_size_h", 290);
	update_option("thumbnail_crop", 1);

	update_option('shop_catalog_image_size',
		array(
			"width" 	=> "290",
			"height"	=> "290",
			"crop"		=> 1
		)
	);

	// change the default medium size
	update_option("medium_size_w", 560);
	update_option("medium_size_h", 420);
	update_option("medium_crop", 1);

	update_option('shop_single_image_size',
		array(
			"width" 	=> "560",
			"height"	=> "420",
			"crop"		=> 1
		)
	);

	// change the default medium size
	update_option("large_size_w", 940);
	update_option("large_size_h", 999999);
	update_option("large_crop", 0);
}

/*-----------------------------------------------------------------------------------*/
/*	Register and load javascripts
/*-----------------------------------------------------------------------------------*/
function t2t_register_js() {
	global $theme;

	if (!is_admin()) {


		// wp_register_script('moment', get_template_directory_uri() . '/javascripts/moment.min.js', 'jquery', $theme->version, true);
		// wp_register_script('html5shiv', get_template_directory_uri() . '/javascripts/html5shiv.js', 'jquery', $theme->version, true);
		// wp_register_script('easing', get_template_directory_uri() . '/javascripts/jquery.easing.js', 'jquery', $theme->version, true);
		// wp_register_script('bacond', get_template_directory_uri() . '/javascripts/jquery.ba-cond.min.js', 'jquery', $theme->version, true);
		// wp_register_script('tipsy', get_template_directory_uri() . '/javascripts/jquery.tipsy.js', 'jquery', $theme->version, true);
		// wp_register_script('isotope', get_template_directory_uri() . '/javascripts/jquery.isotope.js', 'jquery', $theme->version, true);
		// wp_register_script('imagesloaded', get_template_directory_uri() . '/javascripts/jquery.imagesloaded.js', 'jquery', $theme->version, true);
		// wp_register_script('mobilemenu', get_template_directory_uri() . '/javascripts/jquery.mobilemenu.js', 'jquery', $theme->version, true);
		// wp_register_script('retinise', get_template_directory_uri() . '/javascripts/jquery.retinise.js', 'jquery', $theme->version, true);
		// wp_register_script('fullcalendar', get_template_directory_uri() . '/javascripts/fullcalendar.js', 'jquery', $theme->version, true);
		// wp_register_script('uitotop', get_template_directory_uri() . '/javascripts/jquery.ui.totop.js', 'jquery', $theme->version, true);
		// wp_register_script('waypoints', get_template_directory_uri() . '/javascripts/jquery.waypoints.js', 'jquery', $theme->version, true);
		// wp_register_script('hoverintent', get_template_directory_uri() . '/javascripts/jquery.hoverIntent.js', 'jquery', $theme->version, true);
		// wp_register_script('headroom', get_template_directory_uri() . '/javascripts/headroom.js', 'jquery', $theme->version, true);
		// wp_register_script('jcarousel', get_template_directory_uri() . '/javascripts/jquery.jcarousel.js', 'jquery', $theme->version, true);
		// wp_register_script('fancyselect', get_template_directory_uri() . '/javascripts/fancySelect.js', 'jquery', $theme->version, true);

		wp_register_script('combined', get_template_directory_uri() . '/javascripts/_combined.min.js', 'jquery', $theme->version, true);
		wp_register_script('custom', get_template_directory_uri() . '/javascripts/custom.js', 'jquery', $theme->version, true);

		wp_enqueue_script('jquery');
		// wp_enqueue_script('moment');
		// wp_enqueue_script('html5shiv');
		// wp_enqueue_script('easing');
		// wp_enqueue_script('bacond');
		// wp_enqueue_script('tipsy');
		// wp_enqueue_script('isotope');
		// wp_enqueue_script('imagesloaded');
		// wp_enqueue_script('retinise');
		// wp_enqueue_script('fullcalendar');
		// wp_enqueue_script('uitotop');
		// wp_enqueue_script('waypoints');
		// wp_enqueue_script('hoverintent');
		// wp_enqueue_script('headroom');
		// wp_enqueue_script('jcarousel');
		// wp_enqueue_script('fancyselect');
		// wp_enqueue_script('mobilemenu');
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
	    wp_enqueue_script('comment-reply');
		}
		wp_enqueue_script('combined');
		wp_enqueue_script('custom');
	}

}
add_action('wp_enqueue_scripts', 't2t_register_js');

/*-----------------------------------------------------------------------------------*/
/*	Register and load css
/*-----------------------------------------------------------------------------------*/
function t2t_register_css() {
	global $theme;

	if (!is_admin()) {

    wp_enqueue_style("google-fonts", 'http://fonts.googleapis.com/css?family=Exo:100,200,300,400,500,600,700,800,900,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic|Source+Sans+Pro:300,400,600,700', false, false, "all");

		wp_register_style('fullcalendar', get_template_directory_uri() . '/stylesheets/fullcalendar.css', array());
		wp_register_style('tipsy', get_template_directory_uri() . '/stylesheets/tipsy.css', array());
		wp_register_style('fancyselect', get_template_directory_uri() . '/stylesheets/fancySelect.css', array());
		wp_register_style('style', get_stylesheet_uri(), array());

		wp_enqueue_style('fullcalendar');
		wp_enqueue_style('tipsy');
		wp_enqueue_style('fancyselect');
		if(!class_exists("T2T_Toolkit")) {
			wp_enqueue_style("icons", get_template_directory_uri() . "/stylesheets/icons.css", array(), $theme->version, "screen");
		}
		wp_enqueue_style('style');

	}
}
add_action('wp_enqueue_scripts', 't2t_register_css');


function t2t_register_admin_head() {

	$admin_head = "";

	// Google typography tweaks
	$css = '<style type="text/css">';
  $css .= '#google_typography input { box-shadow: none; }';
  $css .= '#google_typography .wp-picker-container { display: none; }';
	$css .= '#google_typography .preview_color { display: none; }';
  $css .= 'div#google_typography .collection[data-default="true"] .font_options a.delete_collection { display: none; }';
	$css .= '</style>';
	$admin_head .= $css;

	// Meta box tweaks
	$js = "<script type=\"text/javascript\">";
	$js .= "	jQuery(document).ready(function($) {";
	$js .= "		$('#album_layout_style, #t2t_album-album_layout_style').parent().hide();";
	$js .= "	});";
	$js .= "</script>";
	$admin_head .= $js;

	echo $admin_head;
}
add_action('admin_head', 't2t_register_admin_head');

function themeit_add_editor_style() {
  add_editor_style( 'style-editor.css' );
}
add_action( 'after_setup_theme', 'themeit_add_editor_style' );

/*-----------------------------------------------------------------------------------*/
/*	Theme customizer hooks
/*-----------------------------------------------------------------------------------*/

function t2t_customizer_css() {

	$css = '<style type="text/css">';
	$css .= get_theme_mod('t2t_customizer_css');
	$css .= '</style>';

	echo $css;

}
add_action('wp_head', 't2t_customizer_css');

function t2t_customizer_analytics() {

  echo get_theme_mod('t2t_customizer_analytics');

}
add_action('wp_footer', 't2t_customizer_analytics');

/*-----------------------------------------------------------------------------------*/
/*	Function to output social links
/*-----------------------------------------------------------------------------------*/
function get_t2t_social_links() {
	$social_links = array(
		"twitter"   => array(
			"rounded"  => "entypo-twitter-circled",
			"circular" => "typicons-social-twitter-circular",
			"simple"   => "typicons-social-twitter",
			"href"     => get_theme_mod("t2t_customizer_social_twitter")
		),
		"facebook"  => array(
			"rounded"  => "entypo-facebook-circled",
			"circular" => "typicons-social-facebook-circular",
			"simple"   => "typicons-social-facebook",
			"href"     => get_theme_mod("t2t_customizer_social_facebook")
		),
		"flickr"    => array(
			"rounded"  => "entypo-flickr-circled",
			"circular" => "typicons-social-flickr-circular",
			"simple"   => "typicons-social-flickr",
			"href"     => get_theme_mod("t2t_customizer_social_flickr")
		),
		"github"    => array(
			"rounded"  => "entypo-github-circled",
			"circular" => "typicons-social-github-circular",
			"simple"   => "typicons-social-github",
			"href"     => get_theme_mod("t2t_customizer_social_github")
		),
		"vimeo"     => array(
			"rounded"  => "entypo-vimeo-circled",
			"circular" => "typicons-social-vimeo-circular",
			"simple"   => "typicons-social-vimeo",
			"href"     => get_theme_mod("t2t_customizer_social_vimeo")
		),
		"pinterest" => array(
			"rounded"  => "entypo-pinterest-circled",
			"circular" => "typicons-social-pinterest-circular",
			"simple"   => "typicons-social-pinterest",
			"href"     => get_theme_mod("t2t_customizer_social_pinterest")
		),
		"linkedin"  => array(
			"rounded"  => "entypo-linkedin-circled",
			"circular" => "typicons-social-linkedin-circular",
			"simple"   => "typicons-social-linkedin",
			"href"     => get_theme_mod("t2t_customizer_social_linked")
		),
		"dribbble"  => array(
			"rounded"  => "entypo-dribbble-circled",
			"circular" => "typicons-social-dribbble-circular",
			"simple"   => "typicons-social-dribbble",
			"href"     => get_theme_mod("t2t_customizer_social_dribbble")
		),
		"lastfm"    => array(
			"rounded"  => "entypo-lastfm-circled",
			"circular" => "typicons-social-last-fm-circular",
			"simple"   => "typicons-social-last-fm",
			"href"     => get_theme_mod("t2t_customizer_social_lastfm")
		),
		"skype"     => array(
			"rounded"  => "entypo-skype-circled",
			"circular" => "typicons-social-skype-outline",
			"simple"   => "typicons-social-skype",
			"href"     => get_theme_mod("t2t_customizer_social_skype")
		),
		"email"     => array(
			"rounded"  => "typicons-at",
			"circular" => "typicons-at",
			"simple"   => "typicons-mail",
			"href"     => get_theme_mod("t2t_customizer_social_email")
		)
	);

	$social_style = get_theme_mod("t2t_customizer_social_style", "rounded");

	$html = "<ul class=\"social " . $social_style . "\">";

	foreach($social_links as $site => $settings) {
		// only include the link if a url was provided
		if(!empty($settings["href"]) && $settings["href"] != "") {
			$html .= "<li><a href=\"" . $settings["href"] . "\" title=\"" . $site . "\" rel=\"tipsy\" target=\"_blank\"><span class=\"" . $settings[$social_style] . "\"></span></a></li>";
		}
	}

	$html .= '</ul>';

	return $html;
}

// same as get_t2t_social_links method but rather than
// returning the markup, it prints it by default
function t2t_social_links() {
	echo get_t2t_social_links();
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Excerpt Functions
/*-----------------------------------------------------------------------------------*/
function custom_excerpt_length( $length ) {
	return 13;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*-----------------------------------------------------------------------------------*/
/*	Password protected posts
/*-----------------------------------------------------------------------------------*/

function custom_password_text($content) {
	$before = 'Password:';
	$after = '';
	$content = str_replace($before, $after, $content);
	return $content;
}
add_filter('the_password_form', 'custom_password_text');

function custom_password_prompt($content) {
	$before = 'This post is password protected. To view it please enter your password below:';
	$after = 'This content is password protected. To view it please enter your password below:';
	$content = str_replace($before, $after, $content);
	return $content;
}
add_filter('the_password_form', 'custom_password_prompt');

/*-----------------------------------------------------------------------------------*/
/*	Register plugins
/*-----------------------------------------------------------------------------------*/
function t2t_required_plugins() {

	$plugins = array(
		array(
			'name' 		      => 'T2T Toolkit',
			'slug' 		      => 't2t-toolkit',
			'source' 			  => 'http://assets.t2themes.com/plugins/t2t-toolkit/t2t-toolkit-latest.zip',
			'external_url'  => 'http://t2themes.com',
			'required' 	    => true
		),
		array(
			'name' 		=> 'Google Typography',
			'slug' 		=> 'google-typography',
			'required' 	=> false
		),
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false
		),
		array(
			'name' 		=> 'Easy Theme and Plugin Upgrades',
			'slug' 		=> 'easy-theme-and-plugin-upgrades',
			'required' 	=> false
		)
	);

	$theme_text_domain = 'framework';

	$config = array('domain' => $theme_text_domain, 'menu' => 'install-required-plugins');

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 't2t_required_plugins' );

add_theme_support( 'post-formats' );


function rw_title($title, $sep, $seplocation) {
    global $page, $paged;

    // don't affect in feeds.
    if(is_feed())  {
	    return $title;
    }

    // add the blog name
    if($seplocation == "right") {
	    $title .= get_bloginfo('name');
    }
    else {
      $title = get_bloginfo("name") . $title;
    }

    // add the blog description for the home/front page.
    $site_description = get_bloginfo("description", "display");
    if($site_description && (is_home() || is_front_page())) {
      $title .= " {$sep} {$site_description}";
    }

    // add a page number if necessary:
    if($paged >= 2 || $page >= 2) {
      $title .= " {$sep} " . sprintf(__('Page %s', 'dbt'), max($paged, $page));
    }

    return $title;
}
add_filter("wp_title", "rw_title", 10, 3);

/*-----------------------------------------------------------------------------------*/
/*	T2T_Toolkit-ness
/*-----------------------------------------------------------------------------------*/
function enable_t2t_post_types($post_types) {

	if(class_exists("T2T_Page")) {
		array_push($post_types, new T2T_Page());
	}
	if(class_exists("T2T_Post")) {
		array_push($post_types, new T2T_Post());
	}
	if(class_exists("T2T_SlitSlider")) {
		array_push($post_types, new T2T_SlitSlider(array(
			"show_shortcodes" => false
		)));
	}
	if(class_exists("T2T_ElasticSlider")) {
		array_push($post_types, new T2T_ElasticSlider(array(
			"show_shortcodes" => false
		)));
	}
	if(class_exists("T2T_FlexSlider")) {
		array_push($post_types, new T2T_FlexSlider(array(
			"show_shortcodes" => false,
			"args" => array(
				"supports" => array("title", "editor", "thumbnail", "post-formats")
			)
		)));
	}
	if(class_exists("T2T_Person")) {
		array_push($post_types, new T2T_Person());
	}
	if(class_exists("T2T_Service")) {
		array_push($post_types, new T2T_Service());
	}
	if(class_exists("T2T_Album")) {
		array_push($post_types, new T2T_Album());
	}
	if(class_exists("T2T_Testimonial")) {
		array_push($post_types, new T2T_Testimonial());
	}
	if(class_exists("T2T_Special")) {
		array_push($post_types, new T2T_Special());
	}
	if(class_exists("T2T_Carousel")) {
		array_push($post_types, new T2T_Carousel(array(
			"show_taxonomy" => false,
			"args" => array(
				"supports" => array("title")
			)
		)));
	}

	return $post_types;
}
add_filter("t2t_toolkit_enabled_post_types", "enable_t2t_post_types");

function enable_icon_sets($available_sets) {
	// override the enabled icon sets
	return array(
		"fiticon",
		"maki"
	);
}
add_filter("t2t_toolkit_icon_sets", "enable_icon_sets");

function rename_person_name($current) {
    return "t2t_coach";
}
add_filter("t2t_post_type_person_name", "rename_person_name");

function rename_person_title($current) {
    return __("Coach", "framework");
}
add_filter("t2t_post_type_person_title", "rename_person_title");

function rename_service_name($current) {
    return "t2t_program";
}
add_filter("t2t_post_type_service_name", "rename_service_name");

function rename_service_title($current) {
    return __("Program", "framework");
}
add_filter("t2t_post_type_service_title", "rename_service_title");

function rename_album_name($current) {
    return "t2t_gallery";
}
add_filter("t2t_post_type_album_name", "rename_album_name");

function rename_album_title($current) {
    return __("Gallery", "framework");
}
add_filter("t2t_post_type_album_title", "rename_album_title");

function post_post_formats($formats) {
	return array("standard", "aside" => "WOD", "video", "image", "quote", "audio", "gallery");
}
add_filter("post_post_formats", "post_post_formats");

function t2t_flexslider_post_formats($formats) {
	return array("image", "video");
}
add_filter("t2t_flexslider_post_formats", "t2t_flexslider_post_formats");
?>