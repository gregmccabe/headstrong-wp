<?php
if(!class_exists('T2T_Shortcode_Page_Section')) {
  /**
   * T2T_Shortcode_Page_Section
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Page_Section extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "page_section";
    const SHORTCODE_NAME  = "Page Section";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_TextAreaHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Content", "t2t")
      )));
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "background_image",
        "name"  => "background_image",
        "label" => __("Background Image", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "background_color",
        "name"        => "background_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Background Color", "t2t"),
        "description" => __("Choose a solid color instead of an image.", "t2t"),
        "default"     => "#444444"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "background_repeat",
        "name"    => "background_repeat",
        "label"   => __("Background Style", "t2t"),
        "options" => array(
          "no-repeat top left"       => __("No Repeat (Left Aligned)", "t2t"),
          "no-repeat top center"     => __("No Repeat (Center Aligned)", "t2t"),
          "no-repeat top right"      => __("No Repeat (Right Aligned)", "t2t"),
          "repeat"                   => __("Tile", "t2t"),
          "repeat-x"                 => __("Tile Horizontally", "t2t"),
          "repeat-y"                 => __("Tile Vertically", "t2t"),
          "no-repeat fixed top left" => __("Parallax", "t2t")
        ),
        "default" => "repeat"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "min_height",
        "name"        => "min_height",
        "label"       => __("Minimum Height (in pixels)", "t2t"),
        "description" => __("Set the minimum height for this section.", "t2t"),
        "default"     => "200"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "padding_top",
        "name"        => "padding_top",
        "label"       => __("Top Padding (in pixels)", "t2t"),
        "default"     => "35"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "padding_bottom",
        "name"        => "padding_Bottom",
        "label"       => __("Bottom Padding (in pixels)", "t2t"),
        "default"     => "35"
      )));

      // reset to main query
      wp_reset_postdata();

      $this->attributes = apply_filters("t2t_shortcode_page_section_fields", $this->attributes);
    }

    /**
     * handle_shortcode
     *
     * @since 1.0.0
     *
     * @param array $atts Attributes of the shortcode
     * @param string $content Content of the shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_shortcode($atts, $content = null) {
      $options = shortcode_atts($this->get_attributes_as_defaults(), $atts);

      // allow modifcation to the markup
      $output = apply_filters("t2t_shortcode_page_section_output", $this->handle_output($options, $content), $options, $content);

      return apply_filters("t2t_shortcode_page_section_wrapper", $output, $options);
    }

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @param array $options Options provided to the markup
     * @param string $content Content of the shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_output($options, $content = null) {
      extract(shortcode_atts($this->get_attributes_as_defaults(), $options));

      // set a uid for this instance of the shortcode, this
      // allows more than one of the same shortcode to appear 
      // on one page
      $uid = uniqid();

      $options = array_merge($options, array(
        "uid" => $uid
      ));

      $html = "<div id=\"page-section-" . $uid . "\" class=\"page_section\">";
      $html .= "  <div class=\"container\">";
      $html .=      do_shortcode($content);
      $html .= "  </div>";
      $html .= "</div>";

      $html = $this->handle_styles($options) . $html;

      if($background_repeat == "no-repeat fixed top left") {
        wp_enqueue_script("parallax", 
          plugin_dir_url(dirname(__FILE__)) . "js/jquery.parallax.js", 
          array("jquery"), 
          true, true);

        $html .= "<script type=\"text/javascript\">";
        $html .= "  jQuery(window).load(function() {";
        $html .= "    setTimeout(function(){";
        $html .= "      jQuery(\"#page-section-" . $uid . "\").parallax(\"50%\", 0.3);";
        $html .= "    }, 2000);";
        $html .= "  });";
        $html .= "</script>";
      } 

      return $html;
    }

    /**
     * handle_styles
     *
     * @since 2.0.0
     *
     * @param array $options Options provided to the markup
     *
     * @return CSS supporting the HTML representing this shortcode
     */
    public function handle_styles($options) {
      $shortcode_styles = array(
        array(
          "rule" => "#page-section-" . $options["uid"],
          "atts" => array(
            "background"     => $options["background_color"] . " url('" . $options["background_image"] . "') " . $options["background_repeat"],
            "min-height"     => $options["min_height"] . "px",
            "padding-top"    => $options["padding_top"] . "px",
            "padding-bottom" => $options["padding_bottom"] . "px"
          )
        )
      );

      return T2T_Toolkit::stringify_styles($shortcode_styles, true);
    }
  }
}
?>