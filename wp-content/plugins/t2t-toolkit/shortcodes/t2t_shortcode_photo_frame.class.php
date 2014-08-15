<?php
if(!class_exists('T2T_Shortcode_Photo_Frame')) {
  /**
   * T2T_Shortcode_Photo_Frame
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Photo_Frame extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "photo_frame";
    const SHORTCODE_NAME  = "Photo Frame";

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
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "frame_style",
        "name"    => "frame_style",
        "label"   => __("Frame Style", "t2t"),
        "options" => array(
          "rounded" => __("Rounded", "t2t"),
          "border"  => __("Border", "t2t"),
          "outline" => __("Outline", "t2t")
          ,
        ),
        "default" => "rounded"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "caption_title",
        "name"  => "caption_title",
        "label" => __("Caption Title", "t2t")
      )));      
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "caption_desc",
        "name"  => "caption_desc",
        "label" => __("Caption Description", "t2t")
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

      $html = "<div class=\"photo_frame $frame_style\">";
      $html .= "  <img src=\"$content\" alt=\"$caption_title\" />";
      if($caption_title || $caption_desc) {
        $html .= "<div class=\"caption\">";
        $html .= "<span class=\"title\">$caption_title</span>";
        $html .= "<span class=\"desc\">$caption_desc</span>";
        $html .= "</div>";
      }
      $html .= "</div>";

      return $html;
      
    }
  }
}
?>