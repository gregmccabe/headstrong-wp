<?php
if(!class_exists('T2T_BaseClass')) {
	/**
	 * T2T_BaseClass
	 *
	 * @package T2T_BaseClass
	 *
	 * @license http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
	 */
	class T2T_BaseClass 
	{
		/**
		 * Holds all data members of this object.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		protected $data  = array();

		/**
		 * __construct
		 *
		 * @since 1.0.0
		 *
		 * @param array $data Initial values for this field
		 */
		public function __construct($data = null) {}

		/**
		 * Magic __set() method
		 *
		 * @since 1.0.0
		 *
		 * @param string $name Name of the field
		 * @param string $value Value of the field
		 */
	  public function __set($name, $value) {
	    if(is_array($value)) {
	      $this->data = array_merge($this->data, array($name => $value));
	    }
	    else {
	      $this->data[$name] = $value;            
	    }
	  }

		/**
	   * Magic __get() method
	   *
	   * @since 1.0.0
	   *
	   * @param string $name Name of the field
	   *
	   * @return The requested fields value, or null if field is not found
	   */
	  public function __get($name) {
	  	if(array_key_exists($name, $this->data)) {
	  		if(is_array($this->data[$name])) {
	  			return (array) $this->data[$name];
	  		}

	      return $this->data[$name];
	  	}

	  	$trace = debug_backtrace();
	  	trigger_error(
	  		'Undefined property via __get(): ' . $name .
	  		' in ' . $trace[0]['file'] .
	  		' on line ' . $trace[0]['line'],
	  		E_USER_NOTICE);

	  	return null;
	  }

	  /**
	   * Magic __isset() method
	   *
		 * @since 1.0.0
		 *
	   * @param string $name Name of the field
	   */
	  public function __isset($name) {
	    return isset($this->data[$name]);
	  }

		/**
		 * Magic __unset method
		 *
		 * @since 1.0.0
		 *
		 * @param string $name Name of the field
		 */
	  public function __unset($name) {
	    unset($this->data[$name]);
	  }

		/**
		 * __toString
		 *
		 * @since 1.0.0
		 */
		public function __toString() {
		  return $this->toString(array(
		    "version" => TOSTRING_MEDIUM
		  ));
		}

		/**
		 * toString
		 *
		 * @since 1.0.0
		 *
		 * @return output of this field
		 */
		public function toString() {
			return "The " . get_class($this) ." object does not provide a toString() method.";
		}
		
		/**
		 * getMemberVars
		 *
		 * @since 1.0.0
		 *
		 * @return Array of member variables
		 */
		public function getMemberVars() {
			return $this->data;
		}
	}
}
?>