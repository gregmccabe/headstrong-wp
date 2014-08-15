<?php
if(!class_exists('T2T_Shortcode_Dropcap')) {
  /**
   * T2T_Shortcode_Dropcap
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Dropcap extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "dropcap";
    const SHORTCODE_NAME  = "Drop Cap";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "style",
        "name"    => "style",
        "label"   => __("Style", "t2t"),
        "options" => array(
          ""    => __("Enclosed", "t2t"),
          "simple"   => __("Simple", "t2t")
        )
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Letter", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"      => "text_color",
        "name"    => "text_color",
        "class"   => "t2t-color-picker",
        "label"   => __("Text Color", "t2t"),
        "default" => "#ffffff"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"      => "background_color",
        "name"    => "background_color",
        "class"   => "t2t-color-picker",
        "label"   => __("Background Color", "t2t")
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

      if($style != "simple") {
        $background = "background: $background_color !important;";
      } else {
        $background = "";
      }

      return "<span class=\"dropcap $style\" style=\"$background color: $text_color;\">" . do_shortcode($content) . "</span>";
    }
  }
}
?>