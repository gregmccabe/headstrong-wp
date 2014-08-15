<?php
if(!class_exists('T2T_Shortcode_Pie_Chart')) {
	/**
	 * T2T_Shortcode_Pie_Chart
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_Pie_Chart extends T2T_Shortcode
	{
	  const SHORTCODE_ID    = "pie_chart";
		const SHORTCODE_NAME  = "Pie Chart";

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
			array_push($this->attributes, new T2T_SelectHelper(array(
			  "id"      => "legend_style",
			  "name"    => "legend_style",
			  "label"   => __("Legend Style", "t2t"),
			  "options" => array(
			    "percentage"   => __("Percentage", "t2t"),
			    "custom_text"  => __("Custom Text", "t2t"),
			    "icon"         => __("Icon", "t2t")
			  ),
			  "default" => "simple"
			)));
			array_push($this->attributes, new T2T_IconSelectHelper(array(
			  "id"          => "icon",
			  "name"        => "icon",
			  "label"       => __("Icon", "t2t"),
			  "description" => __("Choose the icon to show within the chart.", "t2t")
			)));
			array_push($this->attributes, new T2T_TextHelper(array(
			  "id"          => "custom_text",
			  "name"        => "custom_text",
			  "label"       => __("Custom Text", "t2t")
			)));
			array_push($this->attributes, new T2T_SliderHelper(array(
			  "id"          => "line_width",
			  "name"        => "line_width",
			  "label"       => __("Line Width", "t2t"),
			  "range"       => "5,50",
			  "step"        => "1",
			  "default"     => "10"
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

	    wp_enqueue_script("excanvas", 
	      plugin_dir_url(dirname(__FILE__)) . "js/excanvas.js", 
	      array("jquery"), 
	      true, true);

	    wp_enqueue_script("easy-pie-chart", 
	      plugin_dir_url(dirname(__FILE__)) . "js/jquery.easy-pie-chart.js", 
	      array("jquery"), 
	      true, true);

	    wp_enqueue_script("appear", 
	      plugin_dir_url(dirname(__FILE__)) . "js/jquery.appear.js", 
	      array("jquery"), 
	      true, true);

	    $html  = "<div class=\"pie_chart\" data-percent=\"$percentage\" data-legend_style=\"$legend_style\" data-icon=\"$icon\" data-custom_text=\"$custom_text\" data-line_width=\"$line_width\" data-bar_color=\"$bar_color\" data-background_color=\"$background_color\">";
	    $html .= "	<div class=\"percentage\">";

	    if($legend_style == "percentage") {
	    	$html .= "<span>$percentage</span>%";
	    } 
	    elseif($legend_style == "custom_text") {
	    	$html .= "<span>$custom_text</span>";
	    } 
	    elseif($legend_style == "icon") {
	    	$html .= "<span class=\"chart_icon $icon\"></span>";
	    }

	    $html .= "	</div>";

	    if(isset($content) && $content != "") {
				$html .= "	<span class=\"caption\">". do_shortcode($content) ."</span>";
			}

	    $html .= "</div>";

	    return $html;
	  }
	}
}
?>