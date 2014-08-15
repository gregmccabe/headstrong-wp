<?php
if(!class_exists('T2T_PostFormat_Gallery')) {
  /**
   * T2T_PostFormat_Gallery
   *
   * @package T2T_PostFormat_Gallery
   */
  class T2T_PostFormat_Gallery extends T2T_PostFormat
  {
    /**
     * get_fields
     *
     * @since 1.0.0
     *
     * @return array $fields
     */
    public static function get_fields() {
      $fields = apply_filters("t2t_post_format_gallery_fields", array());
      
      array_push($fields, new T2T_SelectHelper(array(
        "id"          => "effect",
        "name"        => "effect",
        "label"       => __("Slide Effect", "t2t"),
        "description" => __("Choose an effect to use for the slider.", "t2t"),
        "class"       => "post-format-gallery",
        "options"     => array(
          "fade"  => __("Fade", "t2t"),
          "slide" => __("Slide", "t2t")
        ),
        "default"     => "fade"
      )));
      array_push($fields, new T2T_SelectHelper(array(
        "id"    => "autoplay",
        "name"  => "autoplay",
        "label" => __("Enable Auto Play?", "t2t"), 
        "description" => "If checked, slides will play automatically.",
        "class"       => "post-format-gallery",
        "options"     => array(
          "true"  => __("True", "t2t"),
          "false" => __("False", "t2t")
        ),
        "default"     => "true"
      )));
      array_push($fields, new T2T_SliderHelper(array(
        "id"          => "interval",
        "name"        => "interval",
        "label"       => __("Autoplay Duration", "t2t"),
        "description" => __("Duration between auto play (in seconds)", "t2t"),
        "class"       => "post-format-gallery",
        "range"       => "1,30",
        "step"        => "1",
        "default"     => "5"
      )));
      array_push($fields, new T2T_ButtonHelper(array(
        "id"    => "t2t_gallery_button",
        "name"  => "t2t_gallery_button",
        "class" => "button button-primary button-large post-format-gallery",
        "value" => "Add Photos"
      )));
      array_push($fields, new T2T_HiddenHelper(array(
        "id"     => "gallery_image_ids",
        "name"   => "gallery_image_ids",
        "render" => false
      )));

      return $fields;
    }
  }
}
?>