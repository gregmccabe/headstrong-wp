<?php
if(!class_exists('T2T_Shortcode_Section_Title')) {
  /**
   * T2T_Shortcode_Section_Title
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Section_Title extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "section_title";
    const SHORTCODE_NAME  = "Section Title";

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
          "simple"          => __("Simple", "t2t"),
          "underline"       => __("Underline", "t2t"),
          "strikethrough"   => __("Strikethrough", "t2t"),
          "with_sub_title"  => __("With Sub Title", "t2t")
        ),
        "default" => "simple"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "border_color",
        "name"        => "border_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Border Color", "t2t"),
        "default"     => "#dddddd"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Title", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "sub_title",
        "name"  => "sub_title",
        "label" => __("Sub Title", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "top_margin",
        "name"  => "top_margin",
        "label" => __("Top Margin", "t2t"),
        "description" => "The spacing above the section title (in px). Leave blank for default."
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "bottom_margin",
        "name"  => "bottom_margin",
        "label" => __("Bottom Margin", "t2t"),
        "description" => "The spacing below the section title (in px). Leave blank for default."
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

      // set a uid for this instance of the shortcode, this
      // allows more than one of the same shortcode to appear 
      // on one page
      $uid = uniqid();

      $options = array_merge($options, array(
        "uid" => $uid
      ));

      $border_color = ((isset($border_color) && $border_color != "") ? $border_color : "");

      $html  = "<div id=\"section-title-" . $uid . "\" class=\"section_title $style\" style=\"border-color: $border_color;\">";
      $html .= "  <span class=\"title\">".do_shortcode($content)."</span> <span class=\"line\"><span style=\"background: $border_color;\"></span></span>";

      if(isset($sub_title) && $sub_title != "") {
        $html .= "  <span class=\"sub_title\">". do_shortcode($sub_title) ."</span>";
      }

      $html .= "</div>";    


      return $this->handle_styles($options) . $html;
    }

    /**
     * handle_styles
     *
     * @since 2.0.0
     *
     * @param array $options Options provided to the markup
     *
     * @return CSS supporting the HTML representing this shortcode
     */
    public function handle_styles($options) {
      $root_css = array();
      
      if(isset($options["top_margin"]) && $options["top_margin"] != "") {
        $root_css["margin-top"] = $options["top_margin"] . "px";
      }

      if(isset($options["bottom_margin"]) && $options["bottom_margin"] != "") {
        $root_css["margin-bottom"] = $options["bottom_margin"] . "px";
      }

      $shortcode_styles = array(
        array(
          "rule" => "#section-title-" . $options["uid"],
          "atts" => $root_css
        )
      );

      if($options["style"] == "underline" && isset($options["border_color"]) && $options["border_color"] != "") {
        array_push($shortcode_styles, array(
          "rule" => "#section-title-" . $options["uid"] . ".underline span.title:after",
          "atts" => array(
            "border-color"    => $options["border_color"]
          )
        ));
      }

      return T2T_Toolkit::stringify_styles($shortcode_styles, true);
    }

  }
}
?>