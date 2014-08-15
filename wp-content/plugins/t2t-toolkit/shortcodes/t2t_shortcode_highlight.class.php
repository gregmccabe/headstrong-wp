<?php
if(!class_exists('T2T_Shortcode_Highlight')) {
  /**
   * T2T_Shortcode_Highlight
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Highlight extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "highlight";
    const SHORTCODE_NAME  = "Highlight";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "bg_color",
        "name"        => "bg_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Background Color", "t2t"),
        "description" => __("Color of the background", "t2t"),
        "default"       => "#f7e938"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "text_color",
        "name"        => "text_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Text Color", "t2t"),
        "description" => __("Color of the text", "t2t"),
        "default"       => "#ffffff"
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
      
       return "<span class=\"highlight\" style=\"background: $bg_color; color: $text_color;\">" . do_shortcode($content) . "</span>";
    }
  }
}
?>