<?php
if(!class_exists('T2T_Utility_Address')) {
	/**
	 * T2T_FormHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_Utility_Address extends T2T_BaseClass
	{
		/**
		 * generate_address_parts
		 *
		 * @since 2.0.0
		 */
		public static function generate_address_parts($options, $keys = array()) {
			$address_keys = array_merge(array(
				"address"         => "address",
				"address_details" => "address_details",
				"city"            => "city",
				"state"           => "state",
				"postal_code"     => "postal_code",
				"country"         => "country"
			), $keys);

			$address_parts = array();

			if(isset($options["address"]) && $options["address"] != "") {
				$address_parts["address"] = $options["address"];
			}

			if(isset($options["address_details"]) && $options["address_details"] != "") {
				$address_parts["address_details"] = $options["address_details"];
			}

			if(isset($options["city"]) && $options["city"] != "") {
				$address_parts["city"] = $options["city"];
			}

			if(isset($options["state"]) && $options["state"] != "") {
				$address_parts["state"] = $options["state"];
			}

			if(isset($options["postal_code"]) && $options["postal_code"] != "") {
				$address_parts["postal_code"] = $options["postal_code"];
			}

			if(isset($options["country"]) && $options["country"] != "") {
				$address_parts["country"] = $options["country"];
			}

			return $address_parts;
		}

		/**
		 * generate_address_string
		 *
		 * @since 2.0.0
		 */
		public static function generate_address_string($options, $keys = array()) {
			// generate the parts
			$address_parts = T2T_Utility_Address::generate_address_parts($options, $keys);

			// return the parts joined by a comma
			return join(", ", $address_parts);
		}

		/**
		 * generate_grouped_address_parts
		 *
		 * @since 2.0.0
		 */
		public static function generate_grouped_address_parts($options, $keys = array()) {
			$address_keys = array_merge(array(
				"address"         => "address",
				"address_details" => "address_details",
				"city"            => "city",
				"state"           => "state",
				"postal_code"     => "postal_code",
				"country"         => "country"
			), $keys);

			$formatted_address_parts = array();

			// generate the parts
			$address_parts = T2T_Utility_Address::generate_address_parts($options, $keys);

			if(isset($address_parts["address"]) && $address_parts["address"] != "") {
				array_push($formatted_address_parts, $address_parts["address"]);
			}
			if(isset($address_parts["address_details"]) && $address_parts["address_details"] != "") {
				array_push($formatted_address_parts, $address_parts["address_details"]);
			}

			$cspc_parts = array();
			if(isset($address_parts["city"]) && $address_parts["city"] != "") {
				array_push($cspc_parts, $address_parts["city"]);
			}
			if(isset($address_parts["state"]) && $address_parts["state"] != "") {
				array_push($cspc_parts, $address_parts["state"]);
			}
			if(isset($address_parts["postal_code"]) && $address_parts["postal_code"] != "") {
				array_push($cspc_parts, $address_parts["postal_code"]);
			}

			// append the grouped city, state, and postal code
			array_push($formatted_address_parts, join(", ", $cspc_parts));

			if(isset($address_parts["country"]) && $address_parts["country"] != "") {
				array_push($formatted_address_parts, $address_parts["country"]);
			}

			return $formatted_address_parts;
		}

		/**
		 * generate_grouped_address_string
		 *
		 * @since 2.0.0
		 */
		public static function generate_grouped_address_string($options, $keys = array()) {
			// generate the parts
			$address_parts = T2T_Utility_Address::generate_grouped_address_parts($options, $keys);

			// return the parts joined by a comma
			return join(", ", $address_parts);
		}

		/**
		 * generate_geocode_url
		 *
		 * @since 2.0.0
		 */
		public static function generate_geocode_url($options, $keys = array()) {
			// compate a readable address string from the provided data
			$address_string = T2T_Utility_Address::generate_address_string($options, $keys);

			// encode the address to be url friendly
			$address = urlencode($address_string);

			// return a url representing the map associated with this address
			return "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";
		}

		/**
		 * generate_map_url
		 *
		 * @since 2.0.0
		 */
		public static function generate_map_url($options, $keys = array()) {
			// generate a url given address information
			$url = T2T_Utility_Address::generate_geocode_url($options, $keys);

			// geocode the url using the selected provider
			$geocode        = wp_remote_get($url);
			$geocode_output = json_decode($geocode["body"]);

			// extract the lat and long from the result
			if(!empty($geocode_output->results)) {
				$lat  = $geocode_output->results[0]->geometry->location->lat;
				$long = $geocode_output->results[0]->geometry->location->lng;

				// return a url representing the map associated with this address
				return "http://maps.google.com/?ll=$lat,$long";
			}
		}

		/**
		 * generate_map_embed
		 *
		 * @since 2.0.0
		 */
		public static function generate_map_embed($options, $keys = array()) {
			// generate a url given address information
			$url = T2T_Utility_Address::generate_geocode_url($options, $keys);

			// geocode the url using the selected provider
			$geocode        = wp_remote_get($url);
			$geocode_output = json_decode($geocode["body"]);

			// extract the lat and long from the result
			$lat  = $geocode_output->results[0]->geometry->location->lat;
			$long = $geocode_output->results[0]->geometry->location->lng;

			$map_id = "map-" . $options["uid"];
			$map_classes = array();
			if(isset($options["classes"]) && $options["classes"] != "") {
				$map_classes = $options["classes"];
			}

			// generate the markup to return
			$output =  '<div id="' . $map_id . '" class="' . $map_classes . '"></div>';
			$output .= '<script type="text/javascript">';
			$output .= '  var myLatlng = new google.maps.LatLng(' . $lat . ', ' . $long . ');';		
			$output .= '  var myOptions = {';
			$output .= '    zoom: 12,';
			$output .= '    center: myLatlng,';
			$output .= '    mapTypeId: google.maps.MapTypeId.ROADMAP';
			$output .= '  };';

			$output .='  var map = new google.maps.Map(document.getElementById("' . $map_id . '"), myOptions);';

			$output .='  var marker = new google.maps.Marker({';
			$output .='    position: myLatlng,';
			$output .='    map: map,';

			if(isset($options["name"]) && $options["name"] != "") {
				$output .='    title:"' . $options["name"] . '",';
			}

			$output .='    animation: google.maps.Animation.DROP';
			$output .='  });';

			$info_window_content = array();
			if(isset($options["name"]) && $options["name"] != "") {
				array_push($info_window_content, "<b>" . $options["name"] . "</b>");
			}
			$info_window_content = T2T_Utility_Address::generate_grouped_address_parts($options, $keys);

			$output .='  var infoWindow = new google.maps.InfoWindow({';
			$output .='    content: "<address>' . join("<br />", $info_window_content) . '</address>"';
			$output .='  });';

			$output .='  google.maps.event.addListener(marker, "click", function() {';
			$output .='    infoWindow.open(map, marker);';
			$output .='  });';

			$output .='</script>';

			return $output;
		}
	}
}
?>