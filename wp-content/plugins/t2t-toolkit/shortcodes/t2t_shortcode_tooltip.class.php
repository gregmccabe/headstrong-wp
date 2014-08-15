<?php
if(!class_exists('T2T_Shortcode_Tooltip')) {
  /**
   * T2T_Shortcode_Tooltip
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Tooltip extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "tooltip";
    const SHORTCODE_NAME  = "Tooltip";

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
      array_push($this->attributes, new T2T_TextHelper(array(
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

      return "<a href=\"javascript:;\" rel=\"tipsy\" title=\"" . $title . "\">" . do_shortcode($content) . "</a>";
    }
  }
}
?>