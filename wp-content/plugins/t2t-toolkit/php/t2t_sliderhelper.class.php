<?php
if(!class_exists('T2T_SliderHelper')) {
	/**
	 * T2T_SliderHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_SliderHelper extends T2T_FormHelper 
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
				if(isset($data['step'])) {
				  $this->step = $data['step'];
				} 
			  if(isset($data['range'])) {
			    $this->range = $data['range'];
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
				$html = "<div class=\"slider_wrapper ". ((isset($this->class) && $this->class != "") ? $this->class : "") ."\">";

				$html .= "<div class=\"noUiSlider\" ". 
					((isset($this->range) && $this->range != "") ? "data-range=\"$this->range\" " : "data-range=\"0,100\" ") .
					((isset($this->value) && $this->value != "") ? "data-start=\"$this->value\" " : "data-start=\"" . $this->default_value() . "\" ") .
					((isset($this->step) && $this->step != "") ? "data-step=\"$this->step\" " : "data-step=\"1\" ") . "></div>\n";

				$html .= "<input type=\"hidden\" ". 
					((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
					((isset($this->name) && $this->name != "") ? "name=\"$this->name\" " : "") .
	        ((isset($this->class) && $this->class != "") ? " class=\"$this->class\"" : "") .
					((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") .
					((isset($this->value) && $this->value != "") ? "value=\"$this->value\" " : "value=\"" . $this->default_value() ."\"") . " />\n";
				
				$html .= "<span class=\"slider_value\">".((isset($this->value) && $this->value != "") ? "$this->value" : "")."</span></div>";

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