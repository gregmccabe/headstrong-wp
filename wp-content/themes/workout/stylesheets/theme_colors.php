<?php
function t2t_theme_colors() {

	$rules = array();

	$hover_rgba = "266,27,88";
	if(class_exists("T2T_Toolkit")) {
		$hover_rgba    = T2T_Toolkit::hex_to_rgba(get_theme_mod("t2t_customizer_accent_color", "#e21b58"));
		$darker_accent = T2T_Toolkit::darken_hex(get_theme_mod("t2t_customizer_accent_color", "#e21b58"), 5);

		array_push($rules, array(
			"rule" => "footer#carousel .copyright",
			"atts" => array(
				"background" => $darker_accent
			)
		));
	}

	$rules = array_merge($rules, array(
		array(
			"rule" => "body",
			"atts" => array(
				"background" => get_theme_mod("t2t_customizer_header_background_color", "#313131")." url('".get_theme_mod("t2t_customizer_header_background")."') fixed ".get_theme_mod("t2t_customizer_header_background_repeat"),
			)
		),
		array(
			"rule" => ".blockquote",
			"atts" => array(
				"border-color" => get_theme_mod("t2t_customizer_accent_color", "#e21b58")
			)
		),		
		array(
			"rules" => array(
				"section a:hover",
				".recent_blogs .post .title a",
				".woocommerce .price"
			),
			"atts" => array(
				"color" => get_theme_mod("t2t_customizer_accent_color", "#e21b58")
			)
		),
		array(
			"rules" => array(
				".featured_testimonials",
				"footer#carousel .container",
				"footer#carousel .jcarousel_wrapper",
				".dropcap",
				"p.form-submit input#submit",
				".wpcf7-submit",
				".comment-reply-link",
				"#searchform #searchsubmit",
				"input[name='Submit']",
				".galleries .caption",
				".gallery .caption",
				".woocommerce a.button",
				".woocommerce button.button",
				".woocommerce input.button",
				".woocommerce #review_form #submit",
				".woocommerce span.onsale",
				".woocommerce-page span.onsale",
				".mejs-time-current",
				".post.format-quote .inner"
			),
			"atts" => array(
				"background" => get_theme_mod("t2t_customizer_accent_color", "#e21b58")
			)
		),
		array(
			"rules" => array(
				".gallery .hover",
				".program .hover"
			),
			"atts" => array(
				"background" => "rgba($hover_rgba, 0.9)"
			)
		),
		array(
			"rule" => ".fc tbody .fc-today",
			"atts" => array(
				"background" => "rgba($hover_rgba, 0.1)"
			)
		)
	));

	echo "<style type=\"text/css\">";

	// iterate through each rule
	foreach($rules as $rule) {

		// initialize an emtpy attributes array
		$attributes = array();

		// iterate through each attribute checking to make
		// sure that they are not empty
		foreach($rule["atts"] as $property => $value) {
			if(!empty($property)) {
				$attributes[$property] = $value;
			}
		}

		// if attributes were provided, print them
		if(!empty($attributes)) {
			if(array_key_exists("rules", $rule)) {
				echo join(", ", $rule["rules"]) . " {\n";
			}
			else {
				echo $rule["rule"] . " {\n";				
			}
		
			foreach($attributes as $property => $value) {
				echo "  " . $property . ": " . $value . " !important;\n";
			}
		
			echo "}\n";
		}
	}

	echo "</style>";

}
add_action('wp_head', 't2t_theme_colors');

?>