<?php
if(!class_exists('T2T_Shortcode_Icon')) {
  /**
   * T2T_Shortcode_Icon
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Icon extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "icon";
    const SHORTCODE_NAME  = "Icon";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_IconSelectHelper(array(
        "id"          => "content",
        "name"        => "content",
        "label"       => __("Icon", "t2t"),
        "description" => __("Choose the icon to insert.", "t2t")
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "size",
        "name"        => "size",
        "label"       => __("Size", "t2t"),
        "description" => __("Size of the icon (in pixels)", "t2t"),
        "range"       => "5,200",
        "step"        => "1",
        "default"      => "15"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "color",
        "name"        => "color",
        "class"       => "t2t-color-picker",
        "label"       => __("Color", "t2t"),
        "description" => __("Color of the icon", "t2t")
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

      $size = $size . "px";

      return "<span class=\"$content\" style=\"font-size: $size; line-height: $size; color: $color;\"></span>";
    }
  }
}
?>