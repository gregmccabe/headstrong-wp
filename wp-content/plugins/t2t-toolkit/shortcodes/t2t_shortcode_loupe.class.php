<?php
if(!class_exists('T2T_Shortcode_Loupe')) {
  /**
   * T2T_Shortcode_Loupe
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Loupe extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "loupe";
    const SHORTCODE_NAME  = "Loupe";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Photo", "t2t")
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "lens_size",
        "name"        => "lens_size",
        "label"       => __("Lens Size", "t2t"),
        "description" => __("Size of the lens in pixels", "t2t"),
        "range"       => "10,500",
        "step"        => "1",
        "default"     => "200"
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

      wp_enqueue_script("imageLens", 
        plugin_dir_url(dirname(__FILE__)) . "js/jquery.imageLens.js", 
        array("jquery"), 
        true, true);

      return "<img src=\"$content\" class=\"photo_loupe\" data-lens-size=\"$lens_size\">";
    }
  }
}
?>