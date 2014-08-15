<?php
if(!class_exists('T2T_Shortcode_Price_Box')) {
  /**
   * T2T_Shortcode_Price_Box
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Price_Box extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "price_box";
    const SHORTCODE_NAME  = "Price Box";

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
        "id"    => "price",
        "name"  => "price",
        "label" => __("Price", "t2t")
      )));
      array_push($this->attributes, new T2T_TextAreaHelper(array(
        "id"    => "content",
        "name"  => "content",
        "label" => __("Features", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "title_color",
        "name"        => "title_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Title Color", "t2t"),
        "default"     => "#ffffff"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "text_color",
        "name"        => "text_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Text Color", "t2t"),
        "default"     => "#ffffff"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "accent_color",
        "name"        => "accent_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Accent Color", "t2t"),
        "default"     => "#555555"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "background_color",
        "name"        => "background_color",
        "class"       => "t2t-color-picker",
        "label"       => __("Box Background Color", "t2t"),
        "default"     => "#ffffff"
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

      $html = "<div id=\"price-box-" . $uid . "\" class=\"pricing_box\">";
      $html .= " <ul>";
      $html .= "  <li class=\"price\">";
      $html .= "    <h2>$title</h2>";

      if(isset($price) && $price != "") {
        $html .= "    <span>$price</span></li>";
      }
      
      $html .= "  </li>";
      $html .= "  <li class=\"details\">". do_shortcode($content) . "</li>";
      $html .= " </ul>";
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
      $shortcode_styles = array(
        array(
          "rule" => "#price-box-" . $options["uid"],
          "atts" => array(
            "background"   => $options["background_color"],
            "border-color" => T2T_Toolkit::darken_hex($options["background_color"], -40)
          )
        ),
        array(
          "rule" => "#price-box-" . $options["uid"] . " h2",
          "atts" => array(
            "color" => $options["title_color"],
          )
        ),
        array(
          "rule" => "#price-box-" . $options["uid"] . " .price",
          "atts" => array(
            "background" => $options["accent_color"]
          )
        ),
        array(
          "rule" => "#price-box-" . $options["uid"] . " .price span",
          "atts" => array(
            "color" => $options["text_color"]
          )
        ),
        array(
          "rule" => "#price-box-" . $options["uid"] . " ul li ul li, #price-box-" . $options["uid"] . " ul li ul li b",
          "atts" => array(
            "color"        => $options["text_color"],
            "border-color" => T2T_Toolkit::darken_hex($options["background_color"], -40)
          )
        )
      );

      return T2T_Toolkit::stringify_styles($shortcode_styles, true);
    }
  }
}
?>