<?php
/*-----------------------------------------------------------------------------------*/
/* Customizer Helpers
/*-----------------------------------------------------------------------------------*/
function t2t_customizer_admin() {
  global $wp_version;

  // customizer was introduced in 3.4
  if(version_compare($wp_version, "3.5", "<=")) {
    add_theme_page("Customize", "Customize", "edit_theme_options", "customize.php");
  }
}
add_action("admin_menu", "t2t_customizer_admin");

function t2t_customize_register($wp_customize) {
  /**
   * T2T_Customize_Textarea_Control
   *
   * Custom implementation of standard text field customizer control
   * that renders a text area
   *
   * @license http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
   */
  class T2T_Customize_Textarea_Control extends WP_Customize_Control {
    /**
     * Holds the type of control.
     *
     * @var string
     */
    public $type        = "textarea";

    /**
     * Holds the description of this control.
     *
     * @var string
     */
    public $description = "";

    public function render_content() {
      echo "<label>";
      echo "  <span class=\"customize-control-title\">";
      echo "    " . esc_html($this->label);
      echo "  </span>";

      if($this->description != "") {
        echo "  <span class=\"customize-control-description\">" . $this->description . "</span>";
      }

      echo "  <textarea rows=\"5\" style=\"width: 100%;\" " . $this->get_link() . ">";
      echo "  " . esc_textarea($this->value());
      echo "  </textarea>";
      echo "</label>";
    }
  }

  /**
   * T2T_Customize_Separator
   *
   * Custom implementation of standard customizer control
   * that renders a a simple separator
   *
   * @license http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
   */
  class T2T_Customize_Separator extends WP_Customize_Control {

    public function render_content() {
      echo "<hr />";
    }
  }

  /**
   * T2T_Customize_Description
   *
   * Custom implementation of standard customizer control
   * that renders a a simple separator
   *
   * @license http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
   */
  class T2T_Customize_Description extends WP_Customize_Control {

    public function render_content() {
      echo "<span style=\"padding: 8px; font-size: 11px; background: #f2f2f2; display: block; color: #777;\">";
      echo "  " . $this->label;
      echo "</span>";
    }
  }

  /*-----------------------------------------------------------------------------------*/
  /* Customizer Options
  /*-----------------------------------------------------------------------------------*/

  /*
   * Options
   */
  $wp_customize->add_section('t2t_t2tfit_styling', array(
    'title'       => __('Theme Options', 'framework'),
    'priority'    => 100
  ));

  // Logo settings
  $wp_customize->add_setting('t2t_customizer_logo', array());
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 't2t_customizer_logo', array(
		'label'    => __('Logo Upload', 'framework'),
		'section'  => 't2t_t2tfit_styling',
		'settings' => 't2t_customizer_logo',
		'priority' => 1
	)));

  $wp_customize->add_setting('t2t_customizer_retina_logo', array());
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 't2t_customizer_retina_logo', array(
    'label'    => __('Retina Logo Upload', 'framework'),
    'section'  => 't2t_t2tfit_styling',
    'settings' => 't2t_customizer_retina_logo',
    'priority' => 2
  )));

	// Favicon settings
  $wp_customize->add_setting('t2t_customizer_favicon', array());
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 't2t_customizer_favicon', array(
		'label'    => __('Favicon Upload', 'framework'),
		'section'  => 't2t_t2tfit_styling',
		'settings' => 't2t_customizer_favicon',
		'priority' => 3
	)));

  // Animations
  $wp_customize->add_setting('t2t_customizer_theme_color', array('default' => 'light'));
  $wp_customize->add_control('t2t_customizer_theme_color', array(
    'label'    => __('Theme Color', 'framework'),
    'settings' => 't2t_customizer_theme_color',
    'section'  => 't2t_t2tfit_styling',
    'type'     => 'select',
    'choices'  => array(
      'light'   => 'Light',
      'dark'  => 'Dark'
    ),
    'priority' => 4
  ));

  // Accent color
  $wp_customize->add_setting('t2t_customizer_accent_color', array('default' => '#e21b58'));
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 't2t_customizer_accent_color', array(
    'label'    => __('Accent Color', 'framework'),
    'section'  => 't2t_t2tfit_styling',
    'settings' => 't2t_customizer_accent_color',
		'priority' => 5
  )));

  // Header
  $wp_customize->add_setting('t2t_customizer_header_style', array('default' => 'default'));
  $wp_customize->add_control('t2t_customizer_header_style', array(
    'label'    => __('Header Style', 'framework'),
    'settings' => 't2t_customizer_header_style',
    'section'  => 't2t_t2tfit_styling',
    'type'     => 'select',
    'choices'  => array(
      'default'   => 'Default',
      'centered'  => 'Centered'
    ),
    'priority' => 6
  ));

  // Animations
  $wp_customize->add_setting('t2t_customizer_animation_style', array('default' => 'flip'));
  $wp_customize->add_control('t2t_customizer_animation_style', array(
    'label'    => __('Animation Style', 'framework'),
    'settings' => 't2t_customizer_animation_style',
    'section'  => 't2t_t2tfit_styling',
    'type'     => 'select',
    'choices'  => array(
      'flip'   => 'Flip',
      'slide'  => 'Slide',
      'fade'   => 'Fade',
      'none'   => 'None'
    ),
    'priority' => 7
  ));

  // Scheduling
  $wp_customize->add_setting('t2t_customizer_scheduling_interval', array('default' => '30'));
  $wp_customize->add_control('t2t_customizer_scheduling_interval', array(
    'label'    => __('Scheduling Interval', 'framework'),
    'settings' => 't2t_customizer_scheduling_interval',
    'section'  => 't2t_t2tfit_styling',
    'type'     => 'select',
    'choices'  => array(
      '10'  => '10',
      '15'  => '15',
      '30'  => '30'
    ),
    'priority' => 8
  ));

  // Custom CSS
  $wp_customize->add_setting('t2t_customizer_css', array());
  $wp_customize->add_control( new T2T_Customize_Textarea_Control( $wp_customize, 't2t_customizer_css', array(
    'label'    => __('Custom CSS', 'framework'),
    'section'  => 't2t_t2tfit_styling',
    'settings' => 't2t_customizer_css',
		'priority' => 12
  )));

  // Custom JS
  $wp_customize->add_setting('t2t_customizer_js', array());
  $wp_customize->add_control( new T2T_Customize_Textarea_Control( $wp_customize, 't2t_customizer_js', array(
    'label'    => __('Custom JS', 'framework'),
    'section'  => 't2t_t2tfit_styling',
    'settings' => 't2t_customizer_js',
		'priority' => 13
  )));

  // Copyright
  $wp_customize->add_setting('t2t_customizer_copyright', array());
  $wp_customize->add_control('t2t_customizer_copyright', array(
    'label'    => __('Copyright', 'framework'),
    'settings' => 't2t_customizer_copyright',
    'section'  => 't2t_t2tfit_styling',
    'type'     => 'text',
    'priority' => 15
  ));

  /*
   * Theme Backgrounds
   */
  $wp_customize->add_section('t2t_t2tfit_backgrounds', array(
    'title'    => __('Theme Backgrounds', 'framework'),
    'priority' => 101
  ));

  // Header background
  $wp_customize->add_setting('t2t_customizer_header_background', array());
  $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 't2t_customizer_header_background', array(
    'label'    => __('Header Background', 'framework'),
    'settings' => 't2t_customizer_header_background',
    'section'  => 't2t_t2tfit_backgrounds',
    'context'  => 't2t_customizer_header_background',
    'priority' => 13
  )));

  $wp_customize->add_setting('t2t_customizer_header_background_repeat', array('default' => 'repeat'));
  $wp_customize->add_control('t2t_customizer_header_background_repeat', array(
    'label'    => __('Header Repeat', 'framework'),
    'settings' => 't2t_customizer_header_background_repeat',
    'section'  => 't2t_t2tfit_backgrounds',
    'type'     => 'select',
    'choices'  => array(
      'no-repeat top left'   => 'No Repeat (Left Aligned)',
      'no-repeat top center' => 'No Repeat (Center Aligned)',
      'no-repeat top right'  => 'No Repeat (Right Aligned)',
      'repeat'               => 'Tile',
      'repeat-x'             => 'Tile Horizontally',
      'repeat-y'             => 'Tile Vertically',
      'stretch'              => 'Stretch'
    ),
    'priority' => 14
  ));

  $wp_customize->add_setting('t2t_customizer_header_background_color', array('default' => '#313131'));

  $wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 't2t_customizer_header_background_color', array(
    'label'    => __("Header Color", 'framework'),
    'section'  => 't2t_t2tfit_backgrounds',
    'settings' => 't2t_customizer_header_background_color',
    'priority' => 15
  )));

  $wp_customize->add_setting('t2t_customizer_header_background_separator', array());
  $wp_customize->add_control( new T2T_Customize_Separator( $wp_customize, 't2t_customizer_header_background_separator', array(
    'section'  => 't2t_t2tfit_backgrounds',
    'priority' => 16
  )));

  /*
   * Theme Social Options
   */
  $wp_customize->add_section('t2t_t2tfit_social', array(
      'title'       => __('Theme Social Options', 'framework'),
      'priority'    => 102,
      'description' => __('Adds social icons to the footer of your site.', 'framework')
  ));

  $wp_customize->add_setting('t2t_customizer_social_style', array('default' => 'rounded'));
  $wp_customize->add_control('t2t_customizer_social_style', array(
    'label'    => __('Icon Style', 'framework'),
    'settings' => 't2t_customizer_social_style',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'select',
    'choices'  => array(
      'rounded'  => 'Rounded',
      'circular' => 'Outline',
      'simple'   => 'Simple'
    ),
    'priority' => 0
  ));

  $wp_customize->add_setting('t2t_customizer_social_twitter', array());
  $wp_customize->add_control('t2t_customizer_social_twitter', array(
    'label'    => __('Twitter URL', 'framework'),
    'settings' => 't2t_customizer_social_twitter',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
		'priority' => 1
  ));
  $wp_customize->add_setting('t2t_customizer_social_facebook', array());
  $wp_customize->add_control('t2t_customizer_social_facebook', array(
    'label'    => __('Facebook URL', 'framework'),
    'settings' => 't2t_customizer_social_facebook',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 2
  ));
  $wp_customize->add_setting('t2t_customizer_social_flickr', array());
  $wp_customize->add_control('t2t_customizer_social_flickr', array(
    'label'    => __('Flickr URL', 'framework'),
    'settings' => 't2t_customizer_social_flickr',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 3
  ));
  $wp_customize->add_setting('t2t_customizer_social_vimeo', array());
  $wp_customize->add_control('t2t_customizer_social_vimeo', array(
    'label'    => __('Vimeo URL', 'framework'),
    'settings' => 't2t_customizer_social_vimeo',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 6
  ));
  $wp_customize->add_setting('t2t_customizer_social_pinterest', array());
  $wp_customize->add_control('t2t_customizer_social_pinterest', array(
    'label'    => __('Pinterest URL', 'framework'),
    'settings' => 't2t_customizer_social_pinterest',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 8
  ));
  $wp_customize->add_setting('t2t_customizer_social_linkedin', array());
  $wp_customize->add_control('t2t_customizer_social_linkedin', array(
    'label'    => __('LinkedIn URL', 'framework'),
    'settings' => 't2t_customizer_social_linkedin',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 9
  ));
  $wp_customize->add_setting('t2t_customizer_social_lastfm', array());
  $wp_customize->add_control('t2t_customizer_social_lastfm', array(
    'label'    => __('Last.fm URL', 'framework'),
    'settings' => 't2t_customizer_social_lastfm',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 12
  ));
  $wp_customize->add_setting('t2t_customizer_social_skype', array());
  $wp_customize->add_control('t2t_customizer_social_skype', array(
    'label'    => __('Skype URL', 'framework'),
    'settings' => 't2t_customizer_social_skype',
    'section'  => 't2t_t2tfit_social',
    'type'     => 'text',
    'priority' => 15
  ));
 $wp_customize->add_setting('t2t_customizer_social_email', array());
 $wp_customize->add_control('t2t_customizer_social_email', array(
   'label'    => __('Email Address', 'framework'),
   'settings' => 't2t_customizer_social_email',
   'section'  => 't2t_t2tfit_social',
   'type'     => 'text',
   'priority' => 16
 ));

 /*
  * External Service Options
  */
 $wp_customize->add_section('t2t_t2tfit_external', array(
     'title'       => __('External Service Options', 'framework'),
     'priority'    => 103,
     'description' => __('API keys and configurations for external services.', 'framework')
 ));

 // Analytics code
 $wp_customize->add_setting('t2t_customizer_analytics', array());
 $wp_customize->add_control( new T2T_Customize_Textarea_Control( $wp_customize, 't2t_customizer_analytics', array(
   'label'    => __('Analytics Code', 'framework'),
   'section'  => 't2t_t2tfit_external',
   'settings' => 't2t_customizer_analytics',
   'priority' => 1,
   'description' => __('Retrieve your analytics JavaScript snippet from the Google Analytics <a href="https://www.google.com/analytics/web" target="_blank">Acount Dashboard</a>', 'framework')
 )));

 // Google APIs key
 $wp_customize->add_setting('t2t_customizer_google_api_key', array());
 $wp_customize->add_control( new T2T_Customize_Textarea_Control( $wp_customize, 't2t_customizer_google_api_key', array(
   'label'    => __('Google API Key', 'framework'),
   'section'  => 't2t_t2tfit_external',
   'settings' => 't2t_customizer_google_api_key',
   'priority' => 2,
   'description' => __('API keys can be acquired from Google\'s <a href="https://console.developers.google.com" target="_blank">Developer Console</a>', 'framework')
 )));

 // Map Styles
 $wp_customize->add_setting('t2t_customizer_map_styles', array());
 $wp_customize->add_control( new T2T_Customize_Textarea_Control( $wp_customize, 't2t_customizer_map_styles', array(
   'label'    => __('Map Styles', 'framework'),
   'section'  => 't2t_t2tfit_external',
   'settings' => 't2t_customizer_map_styles',
   'priority' => 3,
   'description' => __('Copy & paste a custom style from <a href="http://snazzymaps.com/" target="_blank">Snazzy Maps</a>', 'framework')
 )));

}

add_action('customize_register', 't2t_customize_register');
?>