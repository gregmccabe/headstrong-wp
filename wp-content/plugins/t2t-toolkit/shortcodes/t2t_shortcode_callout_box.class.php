<?php
if(!class_exists('T2T_Shortcode_Callout_Box')) {
  /**
   * T2T_Shortcode_Callout_Box
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Callout_Box extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "callout_box";
    const SHORTCODE_NAME  = "Callout Box";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "image",
        "name"  => "image",
        "label" => __("Image", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "title",
        "name"  => "title",
        "label" => __("Title", "t2t")
      )));
      array_push($this->attributes, new T2T_TextAreaHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Content", "t2t")
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

      // initialize array to hold classes
      $classes = array();

      // initialize output
      $output = "<div class=\"callout_box\">";

      // if an image was provided
      if(isset($image) && $image != "") {
        $output .= "<img src=\"$image\" class=\"callout_box_image\">";
      } else {
        array_push($classes, "no_image");
      }

      $output .= "<div class=\"callout_box_content ".join(" ", $classes)."\">";

      // if a title was provided
      if(isset($title) && $title != "") {
        $output .= "<h4>$title</h4>";
      }

      $output .= do_shortcode($content);

      $output .= "</div>";
      $output .= "</div>";

      return $output;
    }
  }
}
?>