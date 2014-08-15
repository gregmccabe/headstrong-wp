<?php
if(!class_exists('T2T_SelectHelper')) {
	/**
	 * T2T_SelectHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_SelectHelper extends T2T_FormHelper 
	{
		/**
		 * Holds all options of this select element.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
	  protected $options = array();

		/**
		 * Holds all option groups of this select element.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
	  protected $option_groups = array();
	    	    
	  /**
	   * __construct
	   *
	   * @since 1.0.0
	   *
	   * @param array $data Initial values for this field
	   */
	  public function __construct($data = null) {
	    parent::__construct($data);
	        
	    if($data != null) {
	      if(isset($data['options'])) {
	        $this->addOptions($data['options']);
	      } 
	      if(isset($data['include_blank'])) {
	        $this->include_blank = $data['include_blank']; 
	      }
	      if(isset($data['prompt'])) {
	        $this->prompt = $data['prompt']; 
	      }
	    }
	  }
	  
	  /**
	   * addOption
	   *
	   * @since 1.0.0
	   *
	   * @param string $key The key (text) of this option
	   * @param string $value The value of this option
	   * @param boolean $selected Whether or not this options should be selected
	   */
	  public function addOption($key, $value, $selected = "") {
	  	if(is_array($value)) {
		    array_push($this->option_groups, new T2T_OptionGroup($key, $value));
	  	}
	  	else {
		    array_push($this->options, new T2T_Option($key, $value, $selected));
	  	}
	  }
	  
	  /**
	   * addOptions
	   *
	   * @since 1.0.0
	   *
	   * @param array $options Array of options
	   *
	   * @return false if not an array, void otherwise
	   */
	  public function addOptions($options) {
	    if(!is_array($options)) {
	      return false;
	    }
	    
	    foreach($options as $value => $text) {
	      $this->addOption($value, $text);
	    }
	  }

	  /**
	   * getOptions
	   *
	   * @since 2.1.0
	   *
	   * @return array of options
	   */
	  public function getOptions() {
	  	return $this->options;
	  }

	  /**
	   * removeOption
	   *
	   * @since 2.1.0
	   *
	   * @param array $options Option to remove
	   */
	  public function removeOption(&$_option) {
	  	foreach($this->options as $key => $option) {
	  		if($option == $_option) {
			    unset($this->options[$key]);	  			
	  		}
	  	}
	  }

	    
	  /**
	   * toString
	   *
	   * @since 1.0.0
	   *
	   * @param string $version Version of the field to display
	   *
	   * @return HTML representing this field
	   */
	  public function toString($selected = "none", $version = TOSTRING_FULL) {
	    // determine which version of the object to dislay
	    if($version == TOSTRING_FULL) {
	      $html = "<select style='width:50%;'". 
	        ((isset($this->value) && $this->value != "") ? " data-value=\"$this->value\"" : "") .
	        ((isset($this->name) && $this->name != "") ? " name=\"$this->name\"" : "") .
	        ((isset($this->id) && $this->id != "") ? " id=\"$this->id\"" : "") .
	        ((isset($this->class) && $this->class != "") ? " class=\"$this->class\"" : "") .
	        ((isset($this->prompt) && $this->prompt != "") ? " data-placeholder=\"$this->prompt\"" : "") .
	        ((isset($this->disabled) && $this->disabled != "") ? " disabled=\"disabled\"" : "") .">\n";
	      
	      if(isset($this->options) || isset($this->option_groups)) {
	        if((isset($this->include_blank) && $this->include_blank) || (isset($this->prompt) && $this->prompt != "")) {
	          array_unshift($this->options, new T2T_Option("", ""));
	        }

	        foreach($this->options as $option) {
	          // check for selected value that was set after construction
	          if((isset($this->value) && $this->value == $option->key) || (!isset($this->value) && $this->default_value() == $option->key)) {
	            $option->selected = true;
	          }

	          $html .= $option->toString() ."\n";
	        }       

	        foreach($this->option_groups as $group) {
	          $html .= $group->toString($this->value, $this->default_value()) ."\n";
	        }         
	      }
	      
	      $html .= "</select>\n";
	      
	      if(isset($this->description)) {
	        $description = "<span>$this->description</span>";
	      }
	      else {
	        $description = "";
	      }

	      if(isset($this->label)) {
	        $html = "<label for=\"$this->id\">$this->label $description</label>$html ";
	      }
	                  
	      return $html;
	    }
	    else if($version == TOSTRING_MEDIUM) {
	      return $this->toString(TOSTRING_FULL);
	    }
	    else if($version == TOSTRING_SHORT) {
	      return $this->toString(TOSTRING_FULL);
	    }
	  }
	}
}

if(!class_exists('T2T_Option')) {
	/**
	 * T2T_Option
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_Option extends T2T_BaseClass 
	{
	  /**
	   * __construct
	   *
	   * @since 1.0.0
	   *
	   * @param string $key The key (text) of this option
	   * @param string $value The value of this option
	   * @param boolean $selected Whether or not this options should be selected
	   */
	  public function __construct($key, $value, $selected = false) {
	    parent::__construct();
	    
	    // set the required params
	    $this->key    = $key;
	    $this->value  = $value;
	    
	    // check selected
	    if(isset($selected) && $selected === true) {
	      $this->selected = true;
	    }
	    else {
	      $this->selected = false;
	    }
	  }
	  
	  /**
	   * toString
	   *
	   * @since 1.0.0
	   *
	   * @param string $version Version of the field to display
	   *
	   * @return HTML representing this field
	   */
	  public function toString($version = TOSTRING_FULL) {
	    // determine which version of the object to dislay
	    if($version == TOSTRING_FULL) {
	      return "<option value=\"$this->key\"" . (($this->selected) ? " selected=\"selected\"" : "").">$this->value</option>";
	    }
	    else if($version == TOSTRING_MEDIUM) {
	      return $this->toString(TOSTRING_FULL);
	    }
	    else if($version == TOSTRING_SHORT) {
	      return $this->toString(TOSTRING_FULL);
	    }
	  }
	}
}
if(!class_exists('T2T_OptionGroup')) {
	/**
	 * T2T_OptionGroup
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_OptionGroup extends T2T_BaseClass 
	{
		/**
		 * Holds all options of this select element.
		 *
		 * @since 1.1.0
		 *
		 * @var array
		 */
	  protected $options = array();

	  /**
	   * __construct
	   *
	   * @since 1.1.0
	   *
	   * @param string $label The label (text) of this option group
	   */
	  public function __construct($label, $options = null) {
	    if($options != null && isset($options)) {
        $this->addOptions($options);
	    }

	    parent::__construct();
	    
	    // set the required params
	    $this->label = $label;
	  }

	  /**
	   * addOption
	   *
	   * @since 1.1.0
	   *
	   * @param string $key The key (text) of this option
	   * @param string $value The value of this option
	   * @param boolean $selected Whether or not this options should be selected
	   */
	  public function addOption($key, $value, $selected = "") {     
	    array_push($this->options, new T2T_Option($key, $value, $selected));
	  }
	  
	  /**
	   * addOptions
	   *
	   * @since 1.1.0
	   *
	   * @param array $options Array of options
	   *
	   * @return false if not an array, void otherwise
	   */
	  public function addOptions($options) {
	    if(!is_array($options)) {
	      return false;
	    }
	    
	    foreach($options as $value => $text) {
	      $this->addOption($value, $text);
	    }
	  }
	  
	  /**
	   * toString
	   *
	   * @since 1.1.0
	   *
	   * @param string $version Version of the field to display
	   *
	   * @return HTML representing this field
	   */
	  public function toString($selected = null, $default = null, $version = TOSTRING_FULL) {
	    // determine which version of the object to dislay
	    if($version == TOSTRING_FULL) {
	      $html  = "<optgroup label=\"$this->label\">";

	      if(isset($this->options)) {
	        foreach($this->options as $option) {
	          // check for selected value that was set after construction
	          if((isset($selected) && $selected == $option->key) || (!isset($selected) && $default == $option->key)) {
	            $option->selected = true;
	          }

	          $html .= $option->toString() ."\n";
	        }         
	      }

	      $html .= "</optgroup>";

	      return $html;
	    }
	    else if($version == TOSTRING_MEDIUM) {
	      return $this->toString(TOSTRING_FULL);
	    }
	    else if($version == TOSTRING_SHORT) {
	      return $this->toString(TOSTRING_FULL);
	    }
	  }
	}
}

if(!class_exists('T2T_IconSelectHelper')) {
	/**
	 * T2T_IconSelectHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_IconSelectHelper extends T2T_SelectHelper 
	{
		/**
		 * toString
		 *
		 * @since 1.0.0
		 *
		 * @param string $version Version of the field to display
		 *
		 * @return HTML representing this field
		 */
		public function toString($selected = "none", $version = TOSTRING_FULL) {
		  // determine which version of the object to dislay
		  if($version == TOSTRING_FULL) {

		    $html = new T2T_HiddenHelper(array(
		      "id"     => ((isset($this->id) && $this->id != "") ? $this->id : ""),
		      "name"   => ((isset($this->name) && $this->name != "") ? $this->name : ""),
		      "value"  => ((isset($this->value) && $this->value != "") ? $this->value : ""),
		      "style"  => "width:50%;",
		      "class"  => "icon_selector attr"
		    ));  
		    
		    if(isset($this->description)) {
		      $description = "<span>$this->description</span>";
		    }
		    else {
		      $description = "";
		    }

		    if(isset($this->label)) {
		      $html = "<label for=\"$this->id\">$this->label $description</label>$html ";
		    }
		                
		    return $html;
		  }
		  else if($version == TOSTRING_MEDIUM) {
		    return $this->toString(TOSTRING_FULL);
		  }
		  else if($version == TOSTRING_SHORT) {
		    return $this->toString(TOSTRING_FULL);
		  }
		}
	}
}
if(!class_exists('T2T_TimeSelectHelper')) {
	/**
	 * T2T_TimeSelectHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_TimeSelectHelper extends T2T_SelectHelper 
	{
		/**
		 * __construct
		 *
		 * @since 1.0.0
		 *
		 * @param array $data Initial values for this field
		 */
		public function __construct($data = null) {
		  parent::__construct($data);
		      
		  if($data != null) {
		    if(isset($data['format_string'])) {
		      $this->format_string = $data['format_string']; 
		    }
		    else {
		    	$this->format_string = "h:i a";
		    }
		    if(isset($data['start_time'])) {
		      $this->start_time = $data['start_time']; 
		    }
		    else {
		    	$this->start_time = 8;
		    }
		    if(isset($data['end_time'])) {
		      $this->end_time = $data['end_time']; 
		    }
		    else {
		    	$this->end_time = 20;
		    }
		    if(isset($data['minute_step']) && $data['minute_step'] <= 60) {
		      $this->minute_step = $data['minute_step']; 
		    }
		    else {
		    	$this->minute_step = 30;
		    }
		  }

		  // initialize the start and end time
		  $start = strtotime($this->start_time . ":00");
		  $end   = strtotime($this->end_time . ":" . $this->minute_step);

		  // add the first option before we increment
	  	$this->addOption(date("H:i", $start), date($this->format_string, $start));

	  	// loop until we've reached the desired end
		  while($start !== $end) {
		  	// increment the time by the provided minute step
		  	$start = strtotime("+" . $this->minute_step . "minutes", $start);

		  	// add the option
		  	$this->addOption(date("H:i", $start), date($this->format_string, $start));
		  }
		}
	}
}

?>