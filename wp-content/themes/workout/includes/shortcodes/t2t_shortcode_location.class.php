<?php
if(!class_exists('T2T_Shortcode_Location')) {
  /**
   * T2T_Shortcode_Location
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Location extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "location";
    const SHORTCODE_NAME  = "Location";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "title",
        "name"        => "title",
        "label"       => __("Title", "t2t"),
        "description" => __("Leave blank to not display a title.", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"    => "name",
        "name"  => "name",
        "label" => __("Name", "t2t")
      )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "address",
        "name"        => "address",
        "label"       => __("Address", "t2t")
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
      // array_push($this->attributes, new T2T_TextHelper(array(
      //   "id"          => "address_details",
      //   "name"        => "address_details",
      //   "label"       => __("Address Details", "t2t")
      // )));
      // array_push($this->attributes, new T2T_TextHelper(array(
      //   "id"          => "city",
      //   "name"        => "city",
      //   "label"       => __("City", "t2t")
      // )));
      // array_push($this->attributes, new T2T_TextHelper(array(
      //   "id"          => "state",
      //   "name"        => "state",
      //   "label"       => __("State / Province", "t2t")
      // )));
      // array_push($this->attributes, new T2T_TextHelper(array(
      //   "id"          => "postal_code",
      //   "name"        => "postal_code",
      //   "label"       => __("Postal Code", "t2t")
      // )));
      // array_push($this->attributes, new T2T_TextHelper(array(
      //   "id"          => "country",
      //   "name"        => "country",
      //   "label"       => __("Country", "t2t")
      // )));
      array_push($this->attributes, new T2T_TextHelper(array(
        "id"          => "phone",
        "name"        => "phone",
        "label"       => __("Phone Number", "t2t")
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
      $output = apply_filters("t2t_shortcode_location_output", $this->handle_output($options, $content), $options, $content);

      return apply_filters("t2t_shortcode_location_wrapper", $output, $options);
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

      $html = "<div id=\"location-" . $uid . "\">";

      // generate the map side
      $html .= "  <div class=\"three_fifth\">";
      $shortcode = new T2T_Shortcode_Map();
      $html .= $shortcode->handle_shortcode(array(
        "address"   => $address,
        "height"    => "275",
        "latitude"  => $latitude,
        "longitude" => $longitude,
        "zoom"      => $zoom
      ));
      $html .= "  </div>";

      // generate the address / description side
      $html .= "  <div class=\"description_box two_fifth column_last\">";

      if(isset($name) && $name != "") {
        $html .= "<h2>". $name ."</h2>";
      }

      $html .= "<ul>";

      if(isset($phone) && $phone != "") {
        $html .= "<li class=\"phone\"><p><span class=\"icon entypo-phone\"></span> ". $phone ."</p></li>";
      }

      $address_parts = T2T_Utility_Address::generate_grouped_address_parts($options);
      $html .= "<li class=\"address\"><p><span class=\"icon entypo-map\"></span> <span class=\"address\">". join("<br />", $address_parts) ."</span></p></li>";

      $address_string = T2T_Utility_Address::generate_address_string($options);
      $directions_url = "https://www.google.com/maps?daddr=".urlencode($address_string);

      $html .= "</ul>";

      $shortcode = new T2T_Shortcode_Button();
      $html .= $shortcode->handle_shortcode(array(
        "size"             => "large",
        "background_color" => get_theme_mod("t2t_customizer_accent_color", "#e21b58"),
        "icon"             => "",
        "style"            => "three-dimensional",
        "target"           => "_blank",
        "url"              => $directions_url
      ), __("Get Directions", "t2t"));

      $html .= "  </div>";
      $html .= "</div>";

      $html .= "<style type=\"text/css\">";
      $html .= "#map-".$uid." {";
      $html .= "  height: 250px;";
      $html .= "} ";
      $html .= "#location-".$uid." .description_box {";
      $html .= "  padding-top: 10px;";
      $html .= "}";
      $html .= "#location-".$uid." ul li .icon {";
      $html .= " width: 28px;";
      $html .= "  font-size: 18px;";
      $html .= "  float: left;";
      $html .= "}";
      $html .= "#location-".$uid." ul li .entypo-map {";
      $html .= "}";
      $html .= "#location-".$uid." ul li .address {";
      $html .= "  display: block;";
      $html .= "  margin-left: 28px;";
      $html .= "}";
      $html .= "</style>";

      return $html;
    }
  }
}
?>