<?php
if(!class_exists('T2T_Shortcode_Photo_Grid')) {
  /**
   * T2T_Shortcode_Photo_Grid
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Photo_Grid extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "photo_grid";
    const SHORTCODE_NAME  = "Photo Grid";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_MultiUploadHelper(array(
        "id"    => "photos",
        "name"  => "photos",
        "label" => __("Photos", "t2t"),
        "description" => "Click the button below to upload between <b>3 to 6 photos</b>. Hold CMD (Mac) or CTRL (Windows) to select multiple photos.",
        "limit" => 6
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "layout",
        "name"    => "layout",
        "label"   => __("Layout", "t2t"),
        "options" => array(
          "12"    => __("1 Up, 2 Down", "t2t"),
          "21"    => __("2 Up, 1 Down", "t2t"),
          "13"    => __("1 Up, 3 Down", "t2t"),
          "22"    => __("2 Up, 2 Down", "t2t"),
          "31"    => __("3 Up, 1 Down", "t2t"),
          "14"    => __("1 Up, 4 Down", "t2t"),
          "23"    => __("2 Up, 3 Down", "t2t"),
          "32"    => __("3 Up, 2 Down", "t2t"),
          "41"    => __("4 Up, 1 Down", "t2t"),
          "15"    => __("1 Up, 5 Down", "t2t"),
          "24"    => __("2 Up, 4 Down", "t2t"),
          "33"    => __("3 Up, 3 Down", "t2t"),
          "42"    => __("4 Up, 2 Down", "t2t"),
          "51"    => __("5 Up, 1 Down", "t2t")
        )
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "spacing",
        "name"        => "spacing",
        "label"       => __("Space Between Photos", "t2t"),
        "description" => __("Space between the photos (in pixels)", "t2t"),
        "range"       => "1,20",
        "step"        => "1",
        "default"     => "5"
      )));
      array_push($this->attributes, new T2T_CheckboxHelper(array(
        "id"    => "fancybox",
        "name"  => "fancybox",
        "label" => __("Open in lightbox on click?", "t2t"), 
        "description" => "Open these photos in a lightbox when clicked.",
        "checked" => true
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

      wp_enqueue_script("photoset-grid", 
        plugin_dir_url(dirname(__FILE__)) . "js/jquery.photoset-grid.js", 
        array("jquery"), 
        true, true);

      // allow modifcation to the markup
      $output = apply_filters("t2t_shortcode_photo_grid_output", $this->handle_output($options, $content), $options, $content);

      return apply_filters("t2t_shortcode_photo_grid_wrapper", $output, $options);
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

      $photos = explode(",", $photos);

      $html = "<div class=\"photo_grid\" data-layout=\"$layout\" data-gutter=\"$spacing\" data-fancybox=\"$fancybox\" style=\"visibility: hidden;\">";

      foreach($photos as $photo) {
        if(isset($photo) && $photo != "") {

          $photo_full = wp_get_attachment_image_src($photo, 'full');
          $photo_thumb = wp_get_attachment_image_src($photo, 'large');

          $html .= "<img src=\"". $photo_thumb[0] ."\" data-highres=\"$photo_full[0]\">";
        }
      }

      $html .= "</div>";

      return $html;

    }
  }
}
?>