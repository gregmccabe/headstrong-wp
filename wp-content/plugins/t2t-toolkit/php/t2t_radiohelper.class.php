<?php
if(!class_exists('T2T_RadioHelper')) {
	/**
	 * T2T_RadioHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_RadioHelper extends T2T_FormHelper 
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
				if(isset($data['checked']) && $data['checked'] === true) {
					$this->checked = "checked"; 
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
		public function toString($version = TOSTRING_FULL) {
			// determine which version of the object to dislay
			if($version == TOSTRING_FULL) {
				$html = "<input type=\"radio\" ". 
					((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
					((isset($this->name) && $this->name != "") ? "name=\"$this->name\" " : "") .
					((isset($this->class) && $this->class != "") ? "class=\"$this->class\" " : "") .
					((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") .
					((isset($this->value) && $this->value != "") ? "value=\"$this->value\" " : "") .
					((isset($this->checked) && $this->checked != "") ? "checked=\"checked\" " : "") . " />\n";
					
				if(isset($this->label)) {
					$html = "<label for=\"$this->id\">$html $this->label</label>";
				}

				return $html;
			}
		}
	}
}

if(!class_exists('T2T_RadioGroupHelper')) {
	/**
	 * T2T_RadioGroupHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_RadioGroupHelper extends T2T_FormHelper 
	{
    /**
     * Holds all radio helpers of this element.
     *
     * @since 1.0.0
     *
     * @var array
     */
		protected $radiohelpers = array();
			
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
	      if(isset($data["radiohelpers"])) {
	        foreach($data["radiohelpers"] as $checkbox) {
	          array_push($this->radiohelpers, $checkbox);
	        }
	      }
	      
	      $this->default = array();
			}
		}

		/**
		 * addRadio
		 *
		 * @since 1.0.0
		 *
		 * @param checkboxhelper $option 
		 */
		public function addRadio($checkbox) {	    
			array_push($this->checkboxes, $checkbox);
		}
		
		/**
		 * addRadios
		 *
		 * @since 1.0.0
		 *
		 * @param string $checkboxes 
		 *
		 * @return false if not an array, void otherwise
		 */
		public function addRadios($checkboxes) {
			if(!is_array($checkboxes)) {
				return false;
			}
			
			foreach($checkboxes as $checkbox) {
				$this->addRadio($checkbox);
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
				$html = "";

				foreach($this->radiohelpers as $radio) {
					// if this groups value matches this radios value
					if((isset($this->value) && $this->value == $radio->value) || (!isset($this->value) && $this->default_value() == $radio->value)) {
						$radio->checked = true;
					}

					$html .= $radio->toString($version);
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
?>