<?php
if(!class_exists('T2T_Widget')) {
  /**
   * T2T_Widget
   *
   * @package T2T_Widget
   */
  class T2T_Widget extends WP_Widget
  {
    /**
     * Holds all fields (attributes) of the widget.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Holds all post types this widget depends on.
     *
     * @since 1.0.0
     *
     * @var array
     */
  	public $post_type_dependencies = array();

  	/**
     * __construct
     *
     * @since 1.0.0
     *
     * @param string $options 
     */
  	function __construct($options = array()) {
  		if(isset($options['id'])) {
  			$this->id = $options['id'];	
  		}
  		if(isset($options['name'])) {
  			$this->name = $options['name'];
  		}
  		if(isset($options["widget_opts"])) {
        $this->widget_opts = $options["widget_opts"];
      }
      if(isset($options["control_opts"])) {
        $this->control_opts = $options["control_opts"];
      }
  		if(isset($options["post_type_dependencies"])) {
        $this->post_type_dependencies = $options["post_type_dependencies"];
      }

      // set default values
      $default_widget_opts = array();

      // if widget_opts have been set, merge them into the defaults
      if(isset($this->widget_opts) && !empty($this->widget_opts)) {
        $this->widget_opts = array_merge($default_widget_opts, $this->widget_opts);
      }
      else {
        $this->widget_opts = $default_widget_opts;
      }

      // set default value
      $default_control_opts = array();

      // if control_opts have been set, merge them into the defaults
      if(isset($this->control_opts) && !empty($this->control_opts)) {
        $this->control_opts = array_merge($default_control_opts, $this->control_opts);
      }
      else {
        $this->control_opts = $default_control_opts;
      }
  		
      $this->configure_fields();

  		// call the parent to register the widget
  		parent::__construct(
  			$this->id,
  			$this->name,
  			$this->widget_opts, $this->control_opts
  		);  
  	}

  	/**
     * configure_fields
     *
     * @since 1.0.0
     */
    public function configure_fields() {}

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @return HTML representing this widget
     */
    public function handle_output($instance) {
      return "";
    }

  	/**
     * form
     *
     * Back-end widget form.
     *
     * @since 1.0.0
     *
     * @see WP_Widget::form()
     *
     * @param array $new_instance
     * @param args $old_instance
     */
  	function form($instance) {		
    	foreach($this->fields as $field) {
    		// set the value based on the currently stored value
    		if(isset($instance[$field->name])) {
    			$field->value = $instance[$field->name];
    		}

    		// store the current values of id and name
    		$previous_id   = $field->id;
    		$previous_name = $field->name;

    		// use wp methods for generating the name and id of the
    		// field, based on the names we've provided
    		$field->id   = $this->get_field_id($field->id);
    		$field->name = $this->get_field_name($field->name);

    		// display this field
    	  echo "<p class=\"t2t_widget_row\">" . $field->toString() . "</p>";
  			
  			// now that the fields are uniquely named and printed,
  			// rever their names
  			$field->id   = $previous_id;
    		$field->name = $previous_name;
    	}
  	}

  	/**
     * update
     *
     * @since 1.0.0
     *
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance
     * @param args $old_instance
     */
    function update($new_instance, $old_instance) {
      // initialization
      $instance = $old_instance;

      // loop through each field for this widget
      foreach($this->fields as $field) {
        // set the value provided
        $instance[$field->name] = strip_tags($new_instance[$field->name]);
      }
      
      // return an instance containing the new values
      return $instance;
    }

  	/**
     * widget
     *
     * @since 1.0.0
     *
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args
     * @param args $instance
     */
  	function widget($args, $instance) {
  	  $markup  = array();

      array_push($markup, $args["before_widget"]);

      if(isset($instance["title"]) && $instance["title"] != "") {
    		$title = apply_filters("widget_title", $instance["title"]);
    		
    	  array_push($markup, $args["before_title"] . $title . $args["after_title"]);
      }

  	  // widget markup defined by user
      array_push($markup, $this->handle_output($instance));
      
  		array_push($markup, $args["after_widget"]);
  		
  		// print all the generated markup
  		foreach($markup as $element) {
        echo $element . "\n";
      }
  	}
  }
}

if(!class_exists('T2T_Custom_Widget')) {
  /**
   * T2T_Custom_Widget
   *
   * @package T2T_Widget
   */
  class T2T_Custom_Widget extends T2T_Widget {}
}
?>