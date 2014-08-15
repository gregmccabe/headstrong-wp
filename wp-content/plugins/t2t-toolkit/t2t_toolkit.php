<?php
/*
	Plugin Name: T2T Toolkit
	Plugin URI: http://t2themes.com
	Description: A simple WordPress plugin to enable all T2T theme functionality
	Version: 2.1.10
	Author: T2T Themes
	Author URI: http://t2themes.com
	License: GPL2
*/
/*
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * toString display options
 *
 */
if(!defined("TOSTRING_FULL"))   define("TOSTRING_FULL", 4);
if(!defined("TOSTRING_MEDIUM")) define("TOSTRING_MEDIUM", 3);
if(!defined("TOSTRING_SHORT"))  define("TOSTRING_SHORT", 2);
if(!defined("TOSTRING_SINGLE")) define("TOSTRING_SINGLE", 1);
if(!defined("TOSTRING_HIDE"))   define("TOSTRING_HIDE", 0);

/**
 * supporting classes
 *
 */
require_once(dirname(__FILE__) . "/php/t2t_baseclass.class.php");
require_once(dirname(__FILE__) . "/php/t2t_shortcode.class.php");
require_once(dirname(__FILE__) . "/php/t2t_widget.class.php");
require_once(dirname(__FILE__) . "/php/t2t_post_type.class.php");
require_once(dirname(__FILE__) . "/php/t2t_post_type_slider.class.php");
require_once(dirname(__FILE__) . "/php/t2t_meta_box.class.php");
require_once(dirname(__FILE__) . "/php/t2t_submenu_page.class.php");
require_once(dirname(__FILE__) . "/php/plugin-update-checker.php");
require_once(dirname(__FILE__) . "/php/t2t_taxonomy.class.php");
require_once(dirname(__FILE__) . "/php/t2t_postformat.class.php");
require_once(dirname(__FILE__) . "/php/face-detection/face-detect.php");

/**
 * utilities
 *
 */
foreach(scandir(dirname(__FILE__) . "/php/utilities") as $filename) {
  $path = dirname(__FILE__) . '/php/utilities/' . $filename;

  if(is_file($path) && preg_match("/t2t_utility_[a-z|_.]+.php/", $filename)) {
    require_once($path);
  }
}

/**
 * form helpers
 *
 */
require_once(dirname(__FILE__) . "/php/t2t_formhelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_buttonhelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_checkboxhelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_radiohelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_selecthelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_texthelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_uploadhelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_sliderhelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_textareahelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_hiddenhelper.class.php");
require_once(dirname(__FILE__) . "/php/t2t_datepickerhelper.class.php");

/**
 * post types
 *
 */
foreach(scandir(dirname(__FILE__) . "/post-types") as $filename) {
  $path = dirname(__FILE__) . '/post-types/' . $filename;

  if(is_file($path) && preg_match("/t2t_[a-z|_]+.class.php/", $filename)) {
    require_once($path);
  }
}

/**
 * meta boxes
 *
 */
foreach(scandir(dirname(__FILE__) . "/meta-boxes") as $filename) {
  $path = dirname(__FILE__) . '/meta-boxes/' . $filename;

  if(is_file($path) && preg_match("/t2t_meta_box[a-z|_]+.class.php/", $filename)) {
    require_once($path);
  }
}

/**
 * shortcodes
 *
 */
foreach(scandir(dirname(__FILE__) . "/shortcodes") as $filename) {
  $path = dirname(__FILE__) . '/shortcodes/' . $filename;

  if(is_file($path) && preg_match("/t2t_shortcode_[a-z|_]+.class.php/", $filename)) {
    require_once($path);
  }
}

// include shortcodes created within the selected theme
if(is_dir(get_template_directory() . "/includes/shortcodes")) {
	foreach(scandir(get_template_directory() . "/includes/shortcodes") as $filename) {
	  $path = get_template_directory() . '/includes/shortcodes/' . $filename;

	  if(is_file($path) && preg_match("/t2t_shortcode_[a-z|_]+.class.php/", $filename)) {
	    require_once($path);
	  }
	}
}

/**
 * widgets
 *
 */
foreach(scandir(dirname(__FILE__) . "/widgets") as $filename) {
  $path = dirname(__FILE__) . '/widgets/' . $filename;

  if(is_file($path) && preg_match("/t2t_widget_[a-z|_]+.class.php/", $filename)) {
    require_once($path);
  }
}

// include widgets created within the selected theme
if(is_dir(get_template_directory() . "/includes/widgets")) {
	foreach(scandir(get_template_directory() . "/includes/widgets") as $filename) {
	  $path = get_template_directory() . '/includes/widgets/' . $filename;

	  if(is_file($path) && preg_match("/t2t_widget_[a-z|_]+.class.php/", $filename)) {
	    require_once($path);
	  }
	}
}

/**
 * pages
 *
 */
foreach(scandir(dirname(__FILE__) . "/pages") as $filename) {
  $path = dirname(__FILE__) . '/pages/' . $filename;

  if(is_file($path) && preg_match("/t2t_submenu_page_[a-z|_]+.class.php/", $filename)) {
    require_once($path);
  }
}

/**
 * post formats
 *
 */
foreach(scandir(dirname(__FILE__) . "/post-formats") as $filename) {
  $path = dirname(__FILE__) . '/post-formats/' . $filename;

  if(is_file($path) && preg_match("/t2t_postformat_[a-z|_]+.class.php/", $filename)) {
    require_once($path);
  }
}

if(!class_exists('T2T_Toolkit')) {
	/**
	 * T2T_Toolkit
	 *
	 * @package T2T_Toolkit
	 *
	 * @author Ryan Abbott <ryan@lateralventures.com>
	 * @author Eric Alli <eric@trilabmedia.com>
	 *
	 * @license http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
	 */
	class T2T_Toolkit {
		/**
		 * Holds all post types the plugin has enabled.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
	  public $post_types = array();

		/**
		 * Holds all shortcodes the plugin has enabled.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
	  public $shortcodes = array();

		/**
		 * Holds all submenu_pages the plugin has enabled.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
	  public $submenu_pages = array();

	  /**
	   * Holds all enabled post formats of this post type.
	   *
	   * @since 1.0.0
	   *
	   * @var array
	   */
	  protected $enabled_post_formats = array(
	    "aside",
	    "gallery",
	    "link",
	    "image",
	    "quote",
	    "status",
	    "video",
	    "audio",
	    "chat"
	  );

	  /**
	   * Construct the plugin object
	   *
	   * @since 1.0.0
	   */
	  public function __construct() {
	    if(is_admin()) {
	      add_action("admin_enqueue_scripts", array($this, "shared_scripts"));
	      add_action("admin_enqueue_scripts", array($this, "admin_scripts"));
	      add_action("admin_init", array($this, "localize_datepicker"));
	      add_action("admin_menu", array($this, "add_shortcode_meta_box"));
	      add_action("admin_menu", array($this, "configure_submenu_pages"));
	      add_action("admin_menu", array($this, "configure_menu_separators"));
	      add_action("admin_head", array($this, "admin_head"));
	      add_action('wp_ajax_get_post_list', array($this, "get_post_list"));
	      add_action('wp_ajax_nopriv_get_post_list', array($this, "get_post_list"));
	    }
	    else {
	      add_action('wp_enqueue_scripts', array($this, "shared_scripts"));
	    }

	    // actions
	    add_action("init", array($this, "configure_post_types"));
	    add_action("init", array($this, "configure_shortcodes"));
	    add_action("widgets_init", array($this, "configure_widgets"));
			add_action("after_setup_theme", array($this, "configure_post_formats"));
			add_action("after_setup_theme", array($this, "load_textdomain"));

	    // filters
	    add_filter("the_content", array($this, "fix_enabled_core_shortcodes"), 5);

	    // check for updates
	    $t2t_updater = new PluginUpdateChecker(
        'http://assets.t2themes.com/plugins/t2t-toolkit/t2t-toolkit.json',
        __FILE__,
        't2t-toolkit'
	    );
	  }

	  /**
	   * Load the language file for the plugin
	   *
	   * @since 1.0.0
	   */
		public function load_textdomain() {
			load_theme_textdomain("t2t", get_template_directory() . "/languages/");
		}

      /**
	   * shared_scripts
	   *
	   * Register and enqueue shared scripts
	   *
	   * @since 1.0.0
	   */
	  public function shared_scripts() {
	    //stylesheets
	    wp_enqueue_style("icons",
	      plugin_dir_url(__FILE__) . "css/icons.css",
	      array(),
	      T2T_Toolkit::get_version(),
	      "screen");

	    wp_enqueue_style("jquery-ui",
	      plugin_dir_url(__FILE__) . "css/jquery-ui.css",
	      array(),
	      T2T_Toolkit::get_version(),
	      "screen");

	    if(!is_admin()) {

	      // stylesheets
	      wp_enqueue_style("shared",
	        plugin_dir_url(__FILE__) . "css/_shared.css",
	        array(),
	        T2T_Toolkit::get_version(),
	        "screen");

	      // In _shared.css
	      // wp_enqueue_style("fancybox", plugin_dir_url(__FILE__) . "js/fancybox/jquery.fancybox.css", array(), T2T_Toolkit::get_version(), "screen");
	      // wp_enqueue_style("fancybox-thumbs", plugin_dir_url(__FILE__) . "js/fancybox/helpers/jquery.fancybox-thumbs.css", array(), T2T_Toolkit::get_version(), "screen");
	      // wp_enqueue_style("fancybox-buttons", plugin_dir_url(__FILE__) . "js/fancybox/helpers/jquery.fancybox-buttons.css", array(), T2T_Toolkit::get_version(), "screen");
	      // wp_enqueue_style("eislideshow", plugin_dir_url(__FILE__) . "css/eislideshow.css", array(), T2T_Toolkit::get_version(), "screen");
	      // wp_enqueue_style("flexslider", plugin_dir_url(__FILE__) . "css/flexslider.css", array(), T2T_Toolkit::get_version(), "screen");

	      wp_enqueue_style("shortcodes",
	      	plugin_dir_url(__FILE__) .
		      "css/shortcodes.css",
		      array(),
		      T2T_Toolkit::get_version(),
		      "screen");

	      // javascripts
				wp_enqueue_script("modernizr",
					plugin_dir_url(__FILE__) .
					"js/modernizr.js", array("jquery"),
					T2T_Toolkit::get_version(),
					false);

				wp_enqueue_script("shared",
					plugin_dir_url(__FILE__) .
					"js/_shared.js", array("jquery"),
					T2T_Toolkit::get_version(),
					true);

				// In _shared.js
				// wp_enqueue_script("fancybox", plugin_dir_url(__FILE__) . "js/fancybox/jquery.fancybox.pack.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("fancybox-thumbs", plugin_dir_url(__FILE__) . "js/fancybox/helpers/jquery.fancybox-thumbs.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("fancybox-buttons", plugin_dir_url(__FILE__) . "js/fancybox/helpers/jquery.fancybox-buttons.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("move", plugin_dir_url(__FILE__) . "js/jquery.event.move.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("fitvids", plugin_dir_url(__FILE__) . "js/jquery.fitvids.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("appear", plugin_dir_url(__FILE__) . "js/jquery.appear.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("backstretch", plugin_dir_url(__FILE__) . "js/jquery.backstretch.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("eislideshow", plugin_dir_url(__FILE__) . "js/jquery.eislideshow.js", array("jquery"), T2T_Toolkit::get_version(), true);
				// wp_enqueue_script("flexslider", plugin_dir_url(__FILE__) . "js/jquery.flexslider.js", array("jquery"), T2T_Toolkit::get_version(), true);

				wp_enqueue_script("shortcodes",
					plugin_dir_url(__FILE__) .
					"js/shortcodes.js",
					array("jquery"),
					T2T_Toolkit::get_version(),
					true);
	    }
	  }

	  /**
	   * admin_scripts
		 *
	   * Register and enqueue scripts for the admin
	   *
	   * @since 1.0.0
	   */
	  public function admin_scripts() {
	    // javascripts
	    wp_enqueue_script("jquery");

	    // wp_enqueue_script("admin",
	    //   plugin_dir_url(__FILE__) . "js/_admin.js",
	    //   array("jquery"),
	    //   T2T_Toolkit::get_version(), true);

	    // In _admin.js
	    wp_enqueue_script("select2", plugin_dir_url(__FILE__) . "js/select2.js", array("jquery"), T2T_Toolkit::get_version(), true);
	    wp_enqueue_script("nouislider", plugin_dir_url(__FILE__) . "js/jquery.nouislider.min.js", array("jquery"), T2T_Toolkit::get_version(), true);
	    wp_enqueue_script("zclip", plugin_dir_url(__FILE__) . "js/jquery.zclip.js", array("jquery"), T2T_Toolkit::get_version(), true);

	    wp_enqueue_script("t2t_admin",
	      plugin_dir_url(__FILE__) . "js/admin.js",
	      array("jquery", "jquery-ui-core", "wp-color-picker"),
	      T2T_Toolkit::get_version(), true);

	    wp_enqueue_style("wp-color-picker");

	    // stylesheets
	    // wp_enqueue_style("admin",
	    //   plugin_dir_url(__FILE__) . "css/_admin.css",
	    //   array(),
	    //   T2T_Toolkit::get_version(),
	    //   "screen");

	    // In _admin.css
	    wp_enqueue_style("select2", plugin_dir_url(__FILE__) . "css/select2.css", array(), T2T_Toolkit::get_version(), "screen");
	    wp_enqueue_style("nouislider", plugin_dir_url(__FILE__) . "css/nouislider.fox.css", array(), T2T_Toolkit::get_version(), "screen");

	    wp_enqueue_style("t2t_admin",
	      plugin_dir_url(__FILE__) . "css/admin.css",
	      array(),
	      T2T_Toolkit::get_version(),
	      "screen");
	  }

    /**
     * admin_head
  	 *
     * Append content to the admin header
     *
     * @since 1.0.0
     */
    public function admin_head() {

    	// parse the json file containing all icons
    	$file  = file_get_contents(plugin_dir_path(__FILE__) . "resources/icons.json");

    	// conver to json
    	$icons = json_decode($file, TRUE);

    	// initialize the available sets array
    	$available_sets = array();

    	// pull all available sets
    	foreach($icons["results"] as $icon_set) {
    		array_push($available_sets, $icon_set["key"]);
    	}

    	// initialize the sets to use array
    	$icons_to_use = array();

    	$filtered_icon_sets = apply_filters("t2t_toolkit_icon_sets", $available_sets);

    	// enable the filtered list of icon sets
    	foreach($icons["results"] as $icon_set) {
    		if(in_array($icon_set["key"], $filtered_icon_sets)) {
    			$icons_to_use = array_merge($icons_to_use, $icon_set["children"]);
    		}
    	}

    	// Output the json into a js variable
    	$html = "<script type=\"text/javascript\">";
    	$html .= "var t2t_toolkit_path = '". plugin_dir_url(__FILE__) ."';";
    	$html .= "var t2t_icons = ". json_encode($icons_to_use) .";";
    	$html .= "</script>";

    	echo $html;
    }

	  /**
	   * configure_post_types
	   *
	   * Instantiate and record each custom post type
	   *
	   * @since 1.0.0
	   */
	  public function configure_post_types() {
	    // instantiate custom post types
	    $enabled_post_types = apply_filters("t2t_toolkit_enabled_post_types", $this->post_types);

	    foreach($enabled_post_types as $obj) {
	      array_push($this->post_types, $obj);
	    }
	  }

	  /**
	   * configure_shortcodes
	   *
	   * Instantiate and record each shortcode
	   *
	   * @since 1.0.0
	   */
	  public function configure_shortcodes() {
	  	// initialize the shortcodes with those included in the plugin
	  	$this->enable_core_shortcodes();

	    // allow for user defined list of shortcodes
	    $shortcodes = apply_filters("t2t_toolkit_enabled_shortcodes", array());

	    foreach($shortcodes as $shortcode) {
	      // add_shortcode($shortcode->id, array($shortcode, "handle_shortcode"));

	    	array_push($this->shortcodes, new $shortcode());
	    }
	  }

		/**
	   * configure_widgets
	   *
	   * @since 1.0.0
	   */
	  public function configure_widgets() {
	    $enabled_post_types = apply_filters("t2t_toolkit_enabled_post_types", $this->post_types);
	    // $enabled_post_types = $this->post_types;

	  	// retrieves all the declared classes
	    foreach(get_declared_classes() as $class) {
				$register = false;

	    	// looping through, if the current class is a subclass of T2T_Widget
	    	if(get_parent_class($class) == "T2T_Widget" && $class != "T2T_Custom_Widget") {
					$register = true;
	    	}
	    	elseif(get_parent_class($class) == "T2T_Custom_Widget") {
	    		// instantiate widget object to get member variables
	    		$widget_obj = new $class();

	    		// store the dependencies
	    		$dependencies = $widget_obj->post_type_dependencies;

	    		// empty array to hold post types that are dependencies and registered
	    		$registered_dependencies = array();

	    		// for each post type registered
	    		foreach($enabled_post_types as $post_type) {
	    			// if this is a dependency of the widget
	    			if(in_array(call_user_func(array($post_type, 'get_name')), $dependencies)) {
	    				// store it
	    				array_push($registered_dependencies, call_user_func(array($post_type, 'get_name')));
	    			}
	    		}

	    		// if the dependencies and registered dependencies are equal
		    	if($dependencies == $registered_dependencies) {
		    		// register this widget
		    		$register = true;
		    	}
	    	}

	    	// if this class meets the criteria above, it is
	    	// a widget we need to register
	    	if($register) {
	    		// do so
	    		register_widget($class);
	    	}
	    }
	  }

		/**
	   * configure_post_formats
	   *
	   * @since 1.1.0
	   */
	  public function configure_post_formats() {
	    add_theme_support("post-formats", $this->enabled_post_formats);
	  }

		/**
	   * configure_submenu_pages
	   *
	   * @since 1.0.0
	   */
	  public function configure_submenu_pages() {
	  	// retrieves all the declared classes
	    foreach(get_declared_classes() as $class) {
	    	// looping through, if the current class is a subclass of T2T_SubmenuPage
	    	if(is_subclass_of($class, "T2T_SubmenuPage")) {
	    		// use reflection to check the location of the file declaring this class
	    		$reflector = new ReflectionClass($class);

	    		// get the file name
	    		$filename = $reflector->getFileName();

	    		// get path parts to get the directory
	    	 	$path_parts = pathinfo($filename);

	    		if(strstr($path_parts["dirname"], dirname(__FILE__)) != false) {
		    		// instantiate and add the shortcode
						array_push($this->submenu_pages, new $class());
	    		}
	    	}
	    }
	  }

		/**
	   * configure_menu_separators
	   *
	   * @since 1.0.0
	   */
	  public function configure_menu_separators() {
	  	// separator for custom post types
			$this->add_post_type_separator(30);
	  }

	  /**
	   * fix_enabled_core_shortcodes
	   *
	   * Fix for WP bug dealing with shortcodes and random p tags
	   *
	   * @since 1.0.0
	   */
	  public function fix_enabled_core_shortcodes($content) {
			global $shortcode_tags;

			$orig_shortcode_tags = $shortcode_tags;

			// remove_all_shortcodes();

			foreach($this->shortcodes as $shortcode) {
			  add_shortcode($shortcode->id, array($shortcode, "handle_shortcode"));
			}

			$content = do_shortcode($content);

			$shortcode_tags = $orig_shortcode_tags;

			return $content;

	  }

	  /**
	   * add_shortcode_meta_box
	   *
	   * @since 1.0.0
	   */
	  public function add_shortcode_meta_box() {
	    // wp context
	    $post_types = get_post_types(
	      array(
	        "public" => true
	      )
	    );

	    foreach($post_types as $post_type) {
	    	// default to true
	    	$show_shortcodes = true;

	    	// determine if this class is a child of our custom post type class
	    	// $is_custom_post_type = is_subclass_of($post_type, "T2T_PostType");
	    	// $is_custom_post_type = is_subclass_of(new $post_type, new T2T_PostType());

	    	// only check custom post types for custom attribute 'show_shortcodes'
	    	// if($is_custom_post_type) {
	    		// find this instantiated object in our member variable
	    		// containing all custom post types
	    		foreach($this->post_types as $custom_post_type) {
	    			// if this post type is found in our member variable, use it's
	    			// value of show_shortcodes
	    			if(strcasecmp(get_class($custom_post_type), $post_type) == 0) {
	    				$show_shortcodes = $custom_post_type->show_shortcodes;
	    			}
	    		// }
	    	}

	    	// if we are to show the shortcodes for this post type, do so
	    	if($show_shortcodes === true) {
	    		$shortcode_meta_box = new T2T_MetaBox_Shortcodes(array(
	    			"shortcodes" => $this->shortcodes
	    		));

	    		// make sure the meta_box has fields before displaying it
					if(sizeof($shortcode_meta_box->get_fields(true)) > 0) {
		    		add_meta_box(
						$shortcode_meta_box->id,
						$shortcode_meta_box->title,
						array($shortcode_meta_box, "handle_output"),
						$post_type,
						$shortcode_meta_box->context,
						$shortcode_meta_box->priority,
						$shortcode_meta_box->get_fields());
		    	}
	    	}
	    }
	  }

	  /**
	   * enable_core_shortcodes
	   *
	   * @since 1.0.0
		 *
	   * @param array $shortcodes Array of shortcodes previously added
	   *
	   * @return An array of T2T_Shortcodes
	   */
	  public function enable_core_shortcodes() {
	  	// retrieves all the declared classes
	    foreach(get_declared_classes() as $class) {
	    	// looping through, if the current class is a subclass of T2T_Shortcode
	    	if(get_parent_class($class) == "T2T_Shortcode" && $class != "T2T_Custom_Shortcode") {

	    		// instantiate and add the shortcode
					array_push($this->shortcodes, new $class());
	    	}
	    }
	  }

	 	/**
	 	 * activate
	 	 *
		 * Activation hook
		 *
		 * @since 1.0.0
		 */
	  public static function activate() {
	    flush_rewrite_rules();
	  }

	  /**
	   * deactivate
	   *
	   * Deactivation hook
	   *
	   * @since 1.0.0
	   */
	  public static function deactivate() {
	    flush_rewrite_rules();
	  }

	  /**
	   * get_version
	   *
	   * Plugin Data
	   *
	   * @since 1.0.0
	   */
	  public static function get_version() {
			if(!function_exists( 'get_plugins')) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$plugin_folder = get_plugins('/' . plugin_basename( dirname( __FILE__ )));
			$plugin_file   = basename((__FILE__ ));

			return $plugin_folder[$plugin_file]['Version'];
	  }

	  /**
	   * determine_loop_classes
	   *
		 * @since 1.0.0
		 *
		 * @uses T2T_Toolkit::determine_fractional_class to retrieve the fractional class of the loop iteration
		 *
	   * @param integer $total_posts Total number of posts in the query this is being used in
	   * @param integer $current_position Position of the loop
	   * @param array $options Options array
	   *
	   * @return String representation of the classes to be appended, separated by " "
	   */
	  public static function determine_loop_classes($total_posts, $current_position, $options) {
	  	// prevent users from changing the shortcode in the editor to unsupported values
	  	if($options["posts_per_row"] > 4) {
	  		$options["posts_per_row"] = 4;
	  	}

	    // handle cases where the total number of objects is
	    // less than the number requested
	    if(isset($options["posts_to_show"]) && $options["posts_to_show"] < $total_posts && $options["posts_to_show"] >= 0) {
	      $total_posts = $options["posts_to_show"];
	    }

	    // get classes for this iteration of a looped grid display
	    $classes = T2T_Toolkit::determine_fractional_class($total_posts, $options["posts_per_row"]);

	    // determine if this service requires the column_last class
	    if($total_posts < $options["posts_per_row"]) {
	      // if we have not completed an entire row, the last
	      // item still needs the column_last class
	      if($current_position == $total_posts) {
	        $classes .= " column_last";
	      }
	    }
	    else {
	      // is the counter divisible by posts_per_row
	      if($current_position % $options["posts_per_row"] == 0) {
	        $classes .= " column_last";
	      }
	    }

	    return $classes;
	  }

	  /**
	   * determine_fractional_class
	   *
	   * @since 1.0.0
	   *
		 * @param integer $count Total number of posts
	   * @param integer $slots Number of columns to fill
	   *
	   * @return String representation of the classes to be appended, separated by " "
	   */
	  private static function determine_fractional_class($count, $slots) {
	    // prevent an attempt to display more elements than there are slots
	    if($count > $slots) {
	    	$count = $slots;
	   	}

	    // denominator values for up to 10 slots
	    $denominators = array(
	      "full", "half", "third", "fourth", "fifth",
	      "sixth", "seventh", "eighth", "ninth", "tenth");

	    // if there is only 1 value return full, otherwise
	    // return the text representation of the fraction
	    if($count <= 1) {
	      return "full";
	    }
	    else {
	      return "one_" . $denominators[$count - 1];
	    }
	  }

	  /**
	   * truncate_string
	   *
	   * @since 1.0.0
	   *
		 * @param string $string String to consider
	   * @param integer $length How many characters to display before truncating
	   *
	   * @return String representation of the classes to be appended, separated by " "
	   */
	  public static function truncate_string($string, $length = 125) {
	  	// stick to wp standards, if -1 is provided
	  	if($length == -1) {
	  		// return the entire string.
	  		return $string;
	  	}

	  	// if the desired length is less than the characters we show to truncate
	  	if($length <= 3) {
	  		// return an empty string
	  		return "";
	  	}

	    return (mb_strlen($string) > $length) ? mb_substr($string, 0, ($length - 3)) . "..." : $string;
	    // return (strlen($string) > $length) ? substr($string, 0, strpos(wordwrap($string, $length), "\n")) . "..." : $string;
	  }

	  /**
	   * display_icon
	   *
	 	 * @since 1.0.0
		 *
	   * @param string $code Character to render
	   *
	   * @return HTML representation of span and character with appropriate class
	   */
	  public static function display_icon($code) {
	    return "<span class=\"" . $code . "\"></span>";
	  }

	  /**
	   * stringify_styles
	   *
	 	 * @since 2.0.0
		 *
	   * @param array $rules Array of css rules
	   *
	   * @return CSS representation of the provided css array
	   */
	  public static function stringify_styles($rules, $include_style_tag = true) {
	  	$css = "";

	  	if(!is_array($rules) || empty($rules)) {
	  		return;
	  	}

			// iterate through each rule
			foreach($rules as $rule) {
				// initialize an emtpy attributes array
				$attributes = array();

				// iterate through each attribute checking to make
				// sure that they are not empty
				foreach($rule["atts"] as $property => $value) {
					if(!empty($property)) {
						$attributes[$property] = $value;
					}
				}

				// if attributes were provided, print them
				if(!empty($attributes)) {
					if(array_key_exists("rules", $rule)) {
						$css .= join(", ", $rule["rules"]) . " {\n";
					}
					else {
						$css .= $rule["rule"] . " {\n";
					}

					foreach($attributes as $property => $value) {
						$css .= "  " . $property . ": " . $value . " !important;\n";
					}

					$css .= "}\n";
				}
			}

			if($include_style_tag == true) {
				return "<style type=\"text/css\">" . $css . "</style>";
			}
			else {
				return $css;
			}
	  }

	  /**
	   * get_post_meta
	   *
	   * @since 1.0.0
	   *
		 * @param integer $post_id ID of the post to lookup meta data for
	   * @param string $key Key of the meta data to look up
	   * @param boolean $single Single result or not
	   * @param mixed $default Default value is nothing is found
	   *
	   * @return Meta value for the key and post provided, or the default value
	   */
	  public static function get_post_meta($post_id, $key, $single, $default = "") {
	    // only allow defaults for single results
	    if($single) {
	      // retrieve the value
	      $value = get_post_meta($post_id, $key, $single);

	      if(trim($value) == "") {
	        // if the value stored is empty (or not stored),
	        // then return the default (default: "")
	        return __($default);
	      }
	      else {
	        // a value exists, return it
	        return $value;
	      }
	    }
	    else {
	      // for multiple key requests, use the WP default function
	      get_post_meta($post_id, $key, $single);
	    }
	  }

	  /**
	   * get_gallery_images
	   *
	   * @since 1.0.0
	   *
		 * @param integer $post_id ID of the post to lookup meta data for
	   * @param array $options Array of options
	   *
	   * @return Meta value for the key and post provided, or the default value
	   */
	  public static function get_gallery_images($post_id, $options = array()) {
	    if(version_compare(get_bloginfo('version'), '3.5', '>=')) {
	      $image_ids = get_post_meta($post_id, 'gallery_image_ids', false);

	      if(is_array($image_ids) && !empty($image_ids)) {
	        if(isset($options["posts_to_show"]) && $options["posts_to_show"] > 0) {
	          return array_slice($image_ids, 0, $options["posts_to_show"], true);
	        }

	        return $image_ids;
	      }
	      else {
	        return array();
	      }
	    }
	    else {
	      // find images in the content and add them to an array, this will
	      // allow us to exclude images in the content from the gallery in older
	      // versions of wordpress
	      preg_match_all('/<img[^>]?class=["|\'][^"]*wp-image-([0-9]*)[^"]*["|\'][^>]*>/i', get_the_content(), $result);

	      // regex result from above
	      $exclude_imgs = $result[1];

	      // exclude thumbnail from slider
	      if(get_post_meta($post_id, "thumbnail", true) == "exclude") {
	        $feat_img = get_post_thumbnail_id( $post_id );
	        $exclude_imgs[] = $feat_img;
	      }

	      // do the heavy lifting for wordpress #facepalm
	      $args = array(
	        "order"           => "ASC",
	        "orderby"         => "date",
	        "post_type"       => "attachment",
	        "post_parent"     => $post_id,
	        "exclude"         => $exclude_imgs,
	        "post_mime_type"  => "image",
	        "post_status"     => null,
	        "numberposts"     => -1,
	        "fields"          => "ids"
	      );

	      if(isset($options["posts_to_show"])) {
	        $args["posts_per_page"] = $options["posts_to_show"];
	      }

	      // retrieve the images
	      $images = get_posts($args);

	      // reset to main query
	      wp_reset_postdata();

	      return $images;
	    }
	  }

	  /**
	   * pluralize
	   *
	   * @todo There are plenty of edge cases in pluralization that are not covered here, that could be.
	   *
	   * @param string $string The word to pluralize
	   *
	   * @return A pluralized version of the word provided
	   */
	  public static function pluralize($string) {
	  	// mutated plurals
	  	if(substr($string, 1) == "erson") {
	  		return str_replace("erson", "eople", $string);
	  	}
	  	elseif(substr($string, 1) == "hild") {
	  		return str_replace("hild", "hildren", $string);
	  	}

	  	// if its not a mutated plural
	    $last     = $string[strlen($string) - 1];
	    $last_two = substr($string, (strlen($string) - 2), strlen($string));

	    if(in_array($last, array("s", "x", "z")) || in_array($last_two, array("ch", "sh"))) {
	      $plural = $string . "es";
	    }
	    elseif(in_array($last, array("f"))) {
	      // strip the last character (f)
	      $cut = substr($string, 0, -1);

	      // append ies
	      $plural = $cut . "ves";
	    }
	    elseif(in_array($last_two, array("fe"))) {
	      // strip the last character (f)
	      $cut = substr($string, 0, -2);

	      // append ies
	      $plural = $cut . "ves";
	    }
	    elseif($last == "y") {
	      // strip the last character (y)
	      $cut = substr($string, 0, -1);

	      // append ies
	      $plural = $cut . "ies";
	    }
	    else{
	      // append an s
	      $plural = $string . "s";
	    }

	    return $plural;
	  }

	  /**
	   * darken_hex
	   *
	   * @since 1.0.0
		 *
	   * @param string $hex The hex value to darken
	   * @param string $factor The factor of the darkness
	   *
	   * @return A darkened hex value
	   */
	  public static function darken_hex($hex, $factor = 30) {
	    $new_hex = "";

	    if($hex == "") {
				return false;
	    }

	    $hex = str_replace('#', "", $hex);

	    $base['R'] = hexdec($hex{0}.$hex{1});
	    $base['G'] = hexdec($hex{2}.$hex{3});
	    $base['B'] = hexdec($hex{4}.$hex{5});

	    foreach ($base as $k => $v) {
				$amount = $v / 100;
				$amount = round($amount * $factor);
				$new_decimal = $v - $amount;

				$new_hex_component = dechex($new_decimal);
				if(strlen($new_hex_component) < 2) {
					$new_hex_component = "0" . $new_hex_component;
				}

				$new_hex .= $new_hex_component;
			}

	    return "#" . $new_hex;
    }

    /**
     * hex_to_rgba
     *
     * @since 1.1.0
  	 *
     * @param string $hex The hex value to convert to rgba
     *
     * @return An rgba value
     */
    public static function hex_to_rgba($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);

       return implode(",", $rgb); // returns the rgb values separated by commas
       // return $rgb; // returns an array with the rgb values
    }

    /**
     * add_post_type_separator
     *
     * @since 1.0.0
  	 *
     * @param string $attachment_url The url for the attachment
     */
    public function add_post_type_separator($position) {
		  global $menu;

		  // initialize the index
		  $index = 0;

		  // loop through all menu options
		  foreach($menu as $offset => $section) {
		  	// keep track of how many separators there are so that when
		  	// we create a new one, we can append an index to its id
		    if(substr($section[2], 0, 9) == "separator") {
		      $index++;
		    }

		    // if the current offset is gte the requested postion
		    if($offset >= $position) {
		    	// set the menu item at position to a separator
		      $menu[$position] = array("","read","separator{$index}","","wp-menu-separator");

		      // found the desired position and added the
		      // separator, we can break the loop
		      break;
		    }
		  }

		  // sort the menu by key
		  ksort($menu);
		}

	  /**
	   * localize_datepicker
	   *
	   * @since 1.0.0
	   */
		function localize_datepicker() {
			global $wp_locale;

			// add the jQuery UI elements shipped with WP
			// wp_enqueue_script("jquery");
			// wp_enqueue_script("jquery-ui-datepicker");

			// add our instantiator js
			wp_enqueue_script("datepicker-init", plugin_dir_url(__FILE__) . "js/datepicker-init.js", array("jquery-ui-datepicker"));

			// localize our js
			$localized_array = array(
				"closeText"       => __("Done", "t2t"),
				"currentText"     => __("Today", "t2t"),
				"monthNames"      => array_values($wp_locale->month),
				"monthNamesShort" => array_values($wp_locale->month_abbrev),
				"monthStatus"     => __("Show a different month", "t2t"),
				"dayNames"        => array_values($wp_locale->weekday),
				"dayNamesShort"   => array_values($wp_locale->weekday_abbrev),
				"dayNamesMin"     => array_values($wp_locale->weekday_initial),
				"altFormat"       => T2T_Toolkit::date_format_php_to_js(get_option("date_format")),
				"firstDay"        => get_option("start_of_week"),
				"isRTL"           => is_rtl(),
			);

			// pass the array to the enqueued js
			wp_localize_script("datepicker-init", "objectL10n", $localized_array);
		}

	  /**
	   * date_format_php_to_js
	   *
	   * @since 1.0.0
		 *
	   * @param string $given_format_string String representation of the desired date format
	   *
	   * @return String representing the javascript version of the date format
	   */
		public static function date_format_php_to_js($given_format_string) {
			switch($given_format_string) {
				// predefined WP date formats
				case "F j, Y":
					return("MM dd, yy");
					break;
				case "Y/m/d":
					return("yy/mm/dd");
					break;
				case "m/d/Y":
					return("mm/dd/yy");
					break;
				case "d/m/Y":
					return("dd/mm/yy");
					break;
			}
		}

	  /**
	   * time_format_php_to_js
	   *
	   * @since 2.0.0
		 *
	   * @param string $given_format_string String representation of the desired time format
	   *
	   * @return String representing the javascript version of the time format
	   */
		public static function time_format_php_to_js($given_format_string) {
			switch($given_format_string) {
				// predefined WP time formats
				case "g:i a":
					return("h:mm a");
					break;
				case "g:i A":
					return("h:mm A");
					break;
				case "H:i":
					return("HH:mm");
					break;
			}
		}

	    /**
	      * get_post_list
	      *
	      * @since 2.1.7
	      *
	      * @param Array $post_types Array of post types to collect
	      *
	      * @return JSON representing the pages and their respective IDS
	      */
		public static function get_post_list($post_types_classes = array()) {
			$post_types_classes = array();

			if(empty($post_types_classes)) {
				$post_types_classes = array("page", "post");
			}
			else {
				foreach($post_types_classes as $post_type_class) {
					if(class_exists($post_type_class)) {
					  array_push($post_types_classes,
					  	call_user_func(array($post_type_class, 'get_name')));
					}
				}
			}

			// print_r($post_types);

			$pages = get_posts(array(
			  "posts_per_page" => -1 ,
			  "post_type"      => $post_types_classes,
			  "orderby"        => "title",
			  "order"          => "asc"
			));

			$page_options = array();

			foreach($pages as $page) {
			  $post_type = get_post_type_object($page->post_type);

			  if($post_type != null) {
			    if(!isset($page_options[$post_type->label])) {
			      $page_options[$post_type->label] = array();
			    }

			    // $page_options["results"][$page->ID] = $page->post_title;
			    array_push($page_options[$post_type->label], array(
			    	"id" => $page->ID,
			    	"text" => $page->post_title
			    ));
			  }
			}

			echo die(json_encode($page_options));
		}
	}
}

/**
 * Initiate the plugin
 */
if(class_exists("T2T_Toolkit")) {
  // installation and uninstallation hooks
  register_activation_hook(__FILE__, array("T2T_Toolkit", "activate"));
  register_deactivation_hook(__FILE__, array("T2T_Toolkit", "deactivate"));

  // instantiate the plugin class
  $t2t_toolkit = new T2T_Toolkit();
}
?>
