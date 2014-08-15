<?php
if(!class_exists('T2T_Shortcode_Column')) {
  /**
   * T2T_Shortcode_Column
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Column extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "column";
    const SHORTCODE_NAME  = "Column";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "size",
        "name"    => "size",
        "label"   => __("Size", "t2t"),
        "options" => array(
          "one_half"     => __("One Half (1/2)", "t2t"),
          "one_third"    => __("One Third (1/3)", "t2t"),
          "two_third"    => __("Two Third (2/3)", "t2t"),
          "one_fourth"   => __("One Fourth (1/4)", "t2t"),
          "three_fourth" => __("Three Fourth (3/4)", "t2t"),
          "one_fifth"    => __("One Fifth (1/5)", "t2t"),
          "two_fifth"    => __("Two Fifth (2/5)", "t2t"),
          "three_fifth"  => __("Three Fifth (3/5)", "t2t"),
          "four_fifth"   => __("Four Fifth (4/5)", "t2t"),
          "one_sixth"    => __("One Sixth (1/6)", "t2t"),
          "five_sixth"   => __("Five Sixth (5/6)", "t2t")
        ),
        "default" => "one_half"
      )));
      array_push($this->attributes, new T2T_CheckboxHelper(array(
        "id"    => "is_last",
        "name"  => "is_last",
        "label" => __("Last Column?", "t2t")
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

      $classes = array();
      if($is_last == "true") {
        $classes[] = "column_last";
      }

      return "<div class=\"$size ".join(' ', $classes)."\">" . do_shortcode($content) . "</div>";
    }
  }
}
?>