<?php
if(!class_exists('T2T_Shortcode_Blockquote')) {
  /**
   * T2T_Shortcode_Blockquote
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Blockquote extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "blockquote";
    const SHORTCODE_NAME  = "Blockquote";

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
          "simple"   => __("Simple", "t2t"),
          "boxed"    => __("Boxed", "t2t")
        ),
        "default" => "white"
      )));
      array_push($this->attributes, new T2T_TextAreaHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Content", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "cite",
        "name"  => "cite",
        "label" => __("Cite", "t2t")
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
      
      $html = "<div class=\"blockquote $style\">";
      $html .= "<p>".do_shortcode($content)."</p>";
      if($cite) {
        $html .= "<cite>$cite</cite>";
      }
      $html .= "</div>";

      return $html;
    }
  }
}
?>