<?php
if(!class_exists('T2T_Shortcode_Button')) {
	/**
	 * T2T_Shortcode_Button
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_Button extends T2T_Shortcode
	{
	  const SHORTCODE_ID    = "button";
		const SHORTCODE_NAME  = "Button";

	  /**
	   * configure_attributes
	   *
	   * @since 1.0.0
	   */
	  public function configure_attributes() {
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "content",
			  "name"        => "content",
			  "label"       => __("Button Text", "t2t"),
			  "description" => __("Text to appear on the button", "t2t")
			)));
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "url",
			  "name"        => "url",
			  "label"       => __("URL", "t2t"),
			  "description" => __("Enter a URL for the button", "t2t"),
			  "default"     => "#"
			)));
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "target",
			  "name"        => "target",
			  "label"       => __("Target", "t2t"),
			  "description" => __("Enter a window target to open this url in.", "t2t"),
			  "default"     => "_self"
			)));
			array_push($this->attributes, new T2T_IconSelectHelper(array(
			  "id"          => "icon",
			  "name"        => "icon",
			  "label"       => __("Icon", "t2t"),
			  "description" => __("Choose an optional icon to insert.", "t2t"),
			  "include_blank" => true
			)));
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "background_color",
			  "name"        => "background_color",
			  "class"       => "t2t-color-picker",
			  "label"       => __("Button Color", "t2t"),
			  "description" => __("Color of the button", "t2t"),
			  "default"       => "#616161"
			)));
			array_push($this->attributes, new T2T_SelectHelper(array(
			  "id"      => "text_color",
			  "name"    => "text_color",
			  "label"   => __("Text Color", "t2t"),
			  "description" => __("Color of the button's text", "t2t"),
			  "options" => array(
			    "light"   => __("Light", "t2t"),
			    "dark"    => __("Dark", "t2t")
			  ),
			  "default" => "light"
			)));
			array_push($this->attributes, new T2T_SelectHelper(array(
			  "id"      => "size",
			  "name"    => "size",
			  "label"   => __("Size", "t2t"),
			  "options" => array(
			    "small"   => __("Small", "t2t"),
			    "medium"  => __("Medium", "t2t"),
			    "large"   => __("Large", "t2t")
			  ),
			  "default" => "small"
			)));
			array_push($this->attributes, new T2T_SelectHelper(array(
			  "id"      => "style",
			  "name"    => "style",
			  "label"   => __("Button Style", "t2t"),
			  "description" => __("Choose either 2D or 3D button styles", "t2t"),
			  "options" => array(
			    "two-dimensional"    => __("2D", "t2t"),
			    "three-dimensional"  => __("3D", "t2t")
			  ),
			  "default" => "two-dimensional"
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

	    if(!empty($icon)) {
	      $icon = "<span class=\"$icon\"></span>";
	    } else {
	      $icon = "";
	    }
	    
	    return $this->handle_styles($options) . "<a id=\"button-" . $uid . "\" class=\"button " . $size . " " . $text_color . "-text " . $style . "\" href=\"" . $url . "\" target=\"$target\">" . $icon . do_shortcode($content) . "</a>";
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
		    	"rule" => "#button-" . $options["uid"],
					"atts" => array(
						"background" => $options["background_color"]
					)
				),
		    array(
		    	"rule" => "#button-" . $options["uid"] . ":hover",
					"atts" => array(
						"background" => T2T_Toolkit::darken_hex($options["background_color"], 7)
					)
				),
		    array(
		    	"rule" => "#button-" . $options["uid"] . ".three-dimensional",
					"atts" => array(
						"box-shadow" => "0px 3px 0px 0px ".T2T_Toolkit::darken_hex($options["background_color"], 20)
					)
				),
		    array(
		    	"rule" => "#button-" . $options["uid"] . ".three-dimensional:active",
					"atts" => array(
						"box-shadow" => "0px 1px 0px 0px ".T2T_Toolkit::darken_hex($options["background_color"], 20)
					)
				)
			);

			return T2T_Toolkit::stringify_styles($shortcode_styles, true);
		}
	}
}
?>