<?php
if(!class_exists('T2T_Shortcode')) {
  /**
   * T2T_Shortcode
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode extends T2T_BaseClass
  {
    /**
     * Holds all attributes of this shortcode.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $attributes = array();

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

  		// every form element could contain the following
      if(isset($data["id"])) {
        $this->id = $data["id"];
      }
      else {
        $this->id = constant(get_class($this)."::SHORTCODE_ID");
      }
      if(isset($data["name"])) {
        $this->name = $data["name"];
      }
      else {
        $this->name = constant(get_class($this)."::SHORTCODE_NAME");
      }
      if(isset($data['attributes'])) {
        foreach($data['attributes'] as $attribute) {
          $this->add_attribute($attribute);
        }
      }

      // configure all the attributes of this shortcode
      $this->configure_attributes();

      add_shortcode($this->id, array($this, "handle_shortcode"));
  	}

   /**
     * get_id
     *
     * @since 2.0.0
     *
     * @return string ID of this shortcode
     */
    public static function get_id() {
      // static::SHORTCODE_ID;
      call_user_func(array($this, SHORTCODE_ID));
    }

   /**
     * get_name
     *
     * @since 2.0.0
     *
     * @return string Name of this shortcode
     */
    public static function get_name() {
      // static::SHORTCODE_NAME;
      call_user_func(array($this, SHORTCODE_NAME));
    }

  	/**
  	 * add_attribute
     *
     * @since 1.0.0
  	 *
  	 * @param array $attribute
  	 */
  	public function add_attribute($attribute) {
      // add the attribute to the private array of attributes
      array_push($this->attributes, $attribute);
  	}

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {}

  	/**
  	 * get_attributes
     *
     * @since 1.0.0
  	 *
  	 * @return array $attributes
  	 */
  	public function get_attributes($field_prefix = "") {
      if($field_prefix == "") {
        return $this->attributes;
      }
      else {
        // copy the attributes array
        $attributes = $this->attributes;

        // prefix each attribute
        foreach($attributes as $attribute) {
          $attribute->id   = $field_prefix . "_" . $attribute->id;
          $attribute->name = $field_prefix . "_" . $attribute->name;
        }

        return $attributes;
      }
  	}

    /**
     * get_attributes_as_defaults
     *
     * @since 1.0.0
     *
     * @return array $result
     */
    public function get_attributes_as_defaults() {
      $result = array();

      foreach($this->get_attributes() as $attribute) {
        // wordpress uses content, ignore it
        if($attribute->id != "content") {
          $result[$attribute->id] = $attribute->default_value();
        }
      }

      return $result;
    }

  	/**
  	 * toString
     *
     * @since 1.0.0
  	 *
  	 * @param string $version Version of the attribute to display
  	 *
  	 * @return HTML representing this attribute
  	 */
  	public function toString($version = TOSTRING_FULL) {
      // determine which version of the object to dislay
  		if($version == TOSTRING_FULL) {
        $html = "<div id=\"div_" . $this->id ."\" class=\"rm_section\" style=\"display: none;\">";

        // display each attribute for this shortcode
    	  foreach($this->get_attributes() as $attribute) {
    	    // doctor up the id and name elements to help with javascrip
          $attribute->id    = $this->id . "-" . $attribute->id;
          $attribute->name  = str_replace("-", "_", $this->id) . "_" . $attribute->name;

          if(isset($attribute->class)) {
            $attribute->class = join(" ", array($attribute->class, "attr"));
          }
          else {
            $attribute->class = "attr";
          }

          $html .= "<div id=\"" . $this->id . "_attr_wrapper\">\n";
          $html .= $attribute->toString();
          $html .= "</div>\n";
      	}

        $generate_button = new T2T_ButtonHelper(array(
          "id"    => $this->id,
          "name"  => str_replace("-", "_", $this->id) . "-button",
          "value" => "Insert Shortcode",
          "class" => "button-primary shortcode_button"
        ));

        $html .= $generate_button->toString();

        $html .= "</div>";

        return $html;
  		}
  	}

    /**
     * handle_shortcode
     *
     * @since 1.0.0
     *
     * @param array $atts options selected by user for this shortcode
     * @param string $content Main content of the shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_shortcode($atts, $content = null) {
      // $markup = "[raw]" . $this->handle_markup($atts, $content) . "[/raw]";

      // $styles = $this->handle_styles($atts, $content);

      // return  $markup . $styles;

      return $this->handle_output($atts, $content);
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
      return "";
    }

    /**
     * handle_wrapper
     *
     * @since 1.0.0
     *
     * @param string $output Output to wrap
     * @param array $options options selected by user for this shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_wrapper($output, $options) {
      return $output;
    }

    /**
     * compare
     *
     * @since 1.0.0
     *
     * @param string $a Value to compare to $b
     * @param string $b Value to compare to $a
     *
     * @return < 0 if $a is less than $b; > 0 if $a is greater than $b, and 0 if they are equal.
     */
    public static function compare($a, $b) {
      return strcmp($a->name, $b->name);
    }
  }
}

if(!class_exists('T2T_Custom_Shortcode')) {
  /**
   * T2T_Custom_Shortcode
   *
   * @package T2T_Shortcode
   */
  class T2T_Custom_Shortcode extends T2T_Shortcode {}
}
?>