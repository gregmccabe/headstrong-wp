<?php
if(!class_exists('T2T_TextHelper')) {
	/**
	 * T2T_TextHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_TextHelper extends T2T_FormHelper 
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
				$html = "<input type=\"text\" ". 
					((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
					((isset($this->name) && $this->name != "") ? "name=\"$this->name\" " : "") .
					((isset($this->class) && $this->class != "") ? "class=\"$this->class\" " : "") .
					((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") .
					((isset($this->value) && $this->value != "") ? "value=\"$this->value\" " : "value=\"" . $this->default_value() ."\"") . " />\n";
					
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