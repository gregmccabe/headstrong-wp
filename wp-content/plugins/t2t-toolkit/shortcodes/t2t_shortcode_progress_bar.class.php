<?php
if(!class_exists('T2T_Shortcode_Progress_Bar')) {
	/**
	 * T2T_Shortcode_Progress_Bar
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_Progress_Bar extends T2T_Shortcode
	{
	  const SHORTCODE_ID    = "progress_bar";
		const SHORTCODE_NAME  = "Progress Bar";

	  /**
	   * configure_attributes
	   *
	   * @since 1.0.0
	   */
	  public function configure_attributes() {
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "content",
			  "name"        => "content",
			  "label"       => __("Title", "t2t")
			)));
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "bar_color",
			  "name"        => "bar_color",
			  "class"       => "t2t-color-picker",
			  "label"       => __("Bar Color", "t2t"),
			  "description" => __("Color of the progress bar", "t2t"),
			  "default"			=> "#333333"
			)));
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "background_color",
			  "name"        => "background_color",
			  "class"       => "t2t-color-picker",
			  "label"       => __("Background Color", "t2t"),
			  "description" => __("Background color of the progress bar", "t2t"),
			  "default"			=> "#dcdcdc"
			)));
			array_push($this->attributes, new T2T_SliderHelper(array(
			  "id"          => "percentage",
			  "name"        => "percentage",
			  "label"       => __("Percentage", "t2t"),
			  "range"       => "1,100",
			  "step"        => "1",
			  "default"     => "50"
			)));
	  }

	  /**
	   * handle_shortcode
	   *
	   * @since 1.0.0
	   *
	   * @param array $atts Attributes of the shortcode
	   * @param string $content Content of the shortcode
	   *
	   * @return HTML representing this shortcode
	   */
	  public function handle_shortcode($atts, $content = null) {
	    $options = shortcode_atts($this->get_attributes_as_defaults(), $atts);

	    // allow modifcation to the markup
	    $output = apply_filters("t2t_shortcode_progress_bar_output", $this->handle_output($options, $content), $options, $content);

	    return apply_filters("t2t_shortcode_progress_bar_wrapper", $output, $options);
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

	    $html = "<div class=\"progress_bar_wrap\">";
	    if(isset($content) && $content != "") {
	    	$html .= "	<span class=\"title\">$content</span>";
	    }
	    $html .= "	<div class=\"progress_bar\" data-width=\"$percentage\" style=\"background: $background_color;\">";
	    $html .= "		<div style=\"background: $bar_color;\"></div>";
	    $html .= "	</div>";
	    $html .= "</div>";

	    return $html;
	  }
	}
}
?>