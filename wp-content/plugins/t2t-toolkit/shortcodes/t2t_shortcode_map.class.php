<?php
if(!class_exists('T2T_Shortcode_Map')) {
/**
   * T2T_Shortcode_Map
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Map extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "map";
    const SHORTCODE_NAME  = "Map";

    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this attribute
     */
    public function __construct($data = array()) {
      // call parent constructor
      parent::__construct($data);

      $maps_url = "https://maps.googleapis.com/maps/api/js?v=3&sensor=false";

      // check for a configured api key
      $api_key = get_theme_mod("t2t_customizer_google_api_key", "");
      if($api_key != "") {
        $maps_url .= "&key=$api_key";
      }

      // load the google maps api javascript
      wp_enqueue_script("google-maps", $maps_url, array('jquery'), true, false);
    }

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"      => "address",
        "name"    => "address",
        "label"   => __("Address for map", "t2t"),
        "default" => "1 Infinite Loop, Cupertino CA",
        "description" => __("Use this to look up the latitude and longitude, or provide it manually below.", "t2t")
      )));
      array_push($this->attributes, new T2T_ButtonHelper(array(
        "id"      => "geocode_search",
        "name"    => "geocode_search",
        "class"   => "button",
        "value"   => __("Geocode", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"      => "latitude",
        "name"    => "latitude",
        "label"   => __("Latitude for map", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"      => "longitude",
        "name"    => "longitude",
        "label"   => __("Longitude for map", "t2t")
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "zoom",
        "name"        => "zoom",
        "label"       => __("Zoom", "t2t"),
        "description" => __("Enter a zoom amount (1-20)", "t2t"),
        "range"       => "1,20",
        "step"        => "1",
        "default"     => "12"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"      => "type",
        "name"    => "type",
        "label"   => __("Map Type", "t2t"),
        "options" => array(
          "roadmap"   => __("Map", "t2t"),
          "satellite" => __("Satellite", "t2t"),
          "hybrid"    => __("Hybrid", "t2t"),
          "terrain"   => __("Terrain", "t2t")
        ),
        "default" => "m"
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "height",
        "name"        => "height",
        "label"       => __("Map Height", "t2t"),
        "description" => __("Enter a height in pixels", "t2t"),
        "default"     => "350"
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

      if(!(empty($latitude) && $latitude !== "") || !(empty($longitude) && $longitude !== "")) {
        $html  = "<div id=\"map-" . $uid . "\" class=\"google-map\" style=\"width: 100%; height: ". $height ."px;\"></div>";
        $html .= "<script type=\"text/javascript\">";
        $html .= "  var myLatlng = new google.maps.LatLng($latitude,$longitude);";

        $map_options = "{" .
          "  center: myLatlng,\n" .
          "  maptype: google.maps.MapTypeId." . strtoupper($type) . ",\n" .
          "  zoom: " . intval($zoom) . ",\n";

        // get styles from the customizer
        $styles = get_theme_mod("t2t_customizer_map_styles", "[]");

        if($styles != "") {
          $html .= "  styles: " . $styles . ",\n";
        }

        $map_options .= "}\n";

        $html .= "  mapOptions = $map_options";

        $html .= "  var map = new google.maps.Map(document.getElementById('map-$uid'), mapOptions);";
        $html .= "  var contentString = '$address';";
        $html .= "  var infowindow = new google.maps.InfoWindow({";
        $html .= "       content: contentString";
        $html .= "  });";
        $html .= "  var marker = new google.maps.Marker({";
        $html .= "    position: myLatlng,";
        $html .= "    map: map";
        $html .= "  });";
        $html .= "  google.maps.event.addListener(marker, 'click', function() {";
        $html .= "    infowindow.open(map,marker);";
        $html .= "  });";

        $html .= "</script>";

        return $html;
      } else {
        return "<p>Please check your map configuration.</p>";
      }

    }
  }
}
?>