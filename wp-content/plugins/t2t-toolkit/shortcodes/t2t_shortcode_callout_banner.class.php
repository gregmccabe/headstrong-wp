<?php
if(!class_exists('T2T_Shortcode_Callout_Banner')) {
  /**
   * T2T_Shortcode_Callout_Banner
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Callout_Banner extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "callout_banner";
    const SHORTCODE_NAME  = "Callout Banner";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "background_image",
        "name"  => "background_image",
        "label" => __("Background Image", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "text_color",
        "name"        => "text_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Text Color", "t2t"),
        "description" => __("Set the text color for the banner.", "t2t"),
        "default"       => "#ffffff"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "background_color",
        "name"        => "background_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Background Color", "t2t"),
        "description" => __("Choose a solid color instead of an image.", "t2t"),
        "default"       => "#444444"
      )));
      array_push($this->attributes, new T2T_TextAreaHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Content", "t2t")
      )));
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
      $output = apply_filters("t2t_shortcode_callout_banner_output", $this->handle_output($options, $content), $options, $content);

      return apply_filters("t2t_shortcode_callout_banner_wrapper", $output, $options);
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

      // initialize output
      $output = "<div id=\"callout-banner-" . $uid . "\" class=\"callout_banner\" data-background-image=\"". $background_image ."\">";
      $output .= "  <div class=\"container\">";
      $output .=      do_shortcode($content);
      $output .= "  </div>";
      $output .= "</div>";

      return $output . $this->handle_styles($options);
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
          "rule" => "#callout-banner-" . $options["uid"],
          "atts" => array(
            "background" => $options["background_color"] . " url('". $options["background_image"] . "') no-repeat top center",
            "color"      => $options["text_color"]
          )
        )
      );

      return T2T_Toolkit::stringify_styles($shortcode_styles, true);
    }
  }
}
?>