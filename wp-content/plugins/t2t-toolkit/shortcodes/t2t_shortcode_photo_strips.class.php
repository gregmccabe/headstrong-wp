<?php
if(!class_exists('T2T_Shortcode_Photo_Strips')) {
  /**
   * T2T_Shortcode_Photo_Strips
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Photo_Strips extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "photo_strips";
    const SHORTCODE_NAME  = "Photo Strips";

    /**
     * configure_attributes
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Photo", "t2t")
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "strips",
        "name"        => "strips",
        "label"       => __("Number Of Strips", "t2t"),
        "description" => __("Number of strips to split the photo into", "t2t"),
        "range"       => "2,50",
        "step"        => "1",
        "default"     => "15"
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "horizontal_spacing",
        "name"        => "horizontal_spacing",
        "label"       => __("Space Between Strips", "t2t"),
        "description" => __("Space between the strips (in pixels)", "t2t"),
        "range"       => "1,50",
        "step"        => "1",
        "default"     => "5"
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "vertical_spacing",
        "name"        => "vertical_spacing",
        "label"       => __("Space Above/Below Strips", "t2t"),
        "description" => __("Space above and below the strips (in pixels)", "t2t"),
        "range"       => "1,50",
        "step"        => "1",
        "default"     => "10"
      )));
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

      wp_enqueue_script("photo_strips", 
        plugin_dir_url(dirname(__FILE__)) . "js/photostrips.js", 
        array("jquery"), 
        true, true);

      // set a uid for this instance of the shortcode, this
      // allows more than one of the same shortcode to appear 
      // on one page
      $uid = uniqid();

      $options = array_merge($options, array(
        "uid" => $uid
      ));
      
      $output = "<div id=\"photo_strip-$uid\" class=\"photo_strips\"><img src=\"$content\" data-strips=\"$strips\" data-horizontal_spacing=\"$horizontal_spacing\" data-vertical_spacing=\"$vertical_spacing\"></div>";

      return $this->handle_styles($options) . $output;
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
          "rule" => "#photo_strip-" . $options["uid"],
          "atts" => array(
            "margin-bottom" => ($options["vertical_spacing"]+20)."px",
            "margin-top" => $options["vertical_spacing"]."px"
          )
        )
      );

      return T2T_Toolkit::stringify_styles($shortcode_styles, true);
    }
  }
}
?>