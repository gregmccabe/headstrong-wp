<?php
if(!class_exists("T2T_CheckboxHelper")) {
	/**
	 * T2T_CheckboxHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_CheckboxHelper extends T2T_FormHelper 
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
				if(isset($data["checked"]) && $data["checked"] === true) {
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
		public function toString($selected = "none", $version = TOSTRING_FULL) {
			// determine which version of the object to dislay
			if($version == TOSTRING_FULL) {
				$html = "<input type=\"checkbox\" ". 
	  			((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
	  			((isset($this->name) && $this->name != "") ? "name=\"$this->name\" " : "") .
	  			((isset($this->class) && $this->class != "") ? "class=\"$this->class\" " : "") .
	  			((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") .
	  			((isset($this->value) && $this->value != "") ? "value=\"$this->value\" " : "") .
	  			((isset($this->checked) && $this->checked != "") ? "checked=\"checked\" " : "") . " />\n";
					
				// surround in a label if one is provided
		    if(isset($this->description)) {
	        $description = "<span>$this->description</span>";
	      }
				else {
					$description = "";
	      }


				if(isset($this->label)) {
					$html = "<label for=\"$this->id\" class=\"checkbox_row\">$html $this->label $description</label>";
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

if(!class_exists("T2T_CheckboxGroupHelper")) {
	/**
	 * T2T_CheckboxGroupHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_CheckboxGroupHelper extends T2T_FormHelper 
	{
	  /**
		 * Holds all checkbox helpers of this element.
		 *
		 * @since 1.0.0
		 *
		 * @var array
		 */
		protected $checkboxhelpers = array();
	    
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
	      if(isset($data["checkboxes"])) {
	        foreach($data["checkboxes"] as $checkbox) {
	          array_push($this->checkboxhelpers, $checkbox);
	        }
	      }
	      
	      $this->default = array();
			}
		}
		
		/**
		 * addCheckbox
		 *
		 * @since 1.0.0
		 *
		 * @param checkboxhelper $option 
		 */
		public function addCheckbox($checkbox) {	    
			array_push($this->checkboxes, $checkbox);
		}
		
		/**
		 * addCheckboxes
		 *
		 * @since 1.0.0
		 *
		 * @param string $checkboxes 
		 *
		 * @return false if not an array, void otherwise
		 */
		public function addCheckboxes($checkboxes) {
			if(!is_array($checkboxes)) {
				return false;
			}
			
			foreach($checkboxes as $checkbox) {
				$this->addCheckbox($checkbox);
			}
		}

		/**
		 * toString
		 *
		 * @since 1.0.0
		 *
		 * @return Default value of this field
		 */
	  public function default_value() {
	    if(isset($this->default)) {
	      return $this->default;
	    }
	    else {
	    	return array();
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
		    
	      foreach($this->checkboxhelpers as $checkbox) {
	        // if this groups value matches this checkboxs value
	        if((isset($this->value) && in_array($checkbox->value, $this->value)) || 
	        	(!isset($this->value) && in_array($checkbox->value, $this->default_value()))) {
	          $checkbox->checked = true;
	        }

	        $html .= $checkbox->toString($version);
	      }
		    
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
?>