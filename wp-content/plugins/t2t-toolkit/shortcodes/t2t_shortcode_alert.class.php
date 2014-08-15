<?php
if(!class_exists('T2T_Shortcode_Alert')) {
  /**
   * T2T_Shortcode_Alert
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Alert extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "alert";
    const SHORTCODE_NAME  = "Alert";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
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
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "style",
        "name"    => "style",
        "label"   => __("Color", "t2t"),
        "options" => array(
          "white"   => __("White", "t2t"),
          "gray"    => __("Gray", "t2t"),
          "red"     => __("Red", "t2t"),
          "yellow"  => __("Yellow", "t2t"),
          "green"   => __("Green", "t2t")
        ),
        "default" => "white"
      )));
      array_push($this->attributes, new T2T_IconSelectHelper(array(
        "id"          => "icon",
        "name"        => "icon",
        "label"       => __("Icon", "t2t"),
        "description" => __("Choose the icon to insert.", "t2t")
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

      $classes = array();

      $html = "<div class=\"alert $style\">";
      if(isset($icon) && $icon != "") {
        $html .= "  <div class=\"alert_icon\">";
        $html .=      "<span class=\"$icon\"></span>";
        $html .= "  </div>";
      } else {
        $classes[] = "no_icon";
      }
      $html .= "  <div class=\"alert_text ". join(" ", $classes) ."\">";
      $html .= "    <strong>$title</strong>";
      $html .=      do_shortcode($content);
      $html .= "  </div>";
      $html .= "</div>";

      return $html;

    }
  }
}
?>