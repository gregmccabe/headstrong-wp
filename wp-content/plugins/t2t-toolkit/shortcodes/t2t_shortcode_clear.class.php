<?php
if(!class_exists('T2T_Shortcode_Clear')) {
  /**
   * T2T_Shortcode_Clear
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Clear extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "clear";
    const SHORTCODE_NAME  = "Clear";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"        => "height",
        "name"      => "height",
        "label"     => __("Height (in pixels)", "t2t"),
        "default"   => 0
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

      // set a uid for this instance of the shortcode, this
      // allows more than one of the same shortcode to appear 
      // on one page
      $uid = uniqid();

      $options = array_merge($options, array(
        "uid" => $uid
      ));
      
      $output = "<div id=\"clear-$uid\" class=\"clear\"></div>";

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
          "rule" => "#clear-" . $options["uid"],
          "atts" => array(
            "padding-top" => $options["height"]."px",
          )
        )
      );

      return T2T_Toolkit::stringify_styles($shortcode_styles, true);
    }
  }
}
?>