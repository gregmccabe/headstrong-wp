<?php
if(!class_exists('T2T_TextAreaHelper')) {
	/**
	 * T2T_TextAreaHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_TextAreaHelper extends T2T_FormHelper 
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
				if(isset($data['maxlength'])) {
				  $this->maxlength = $data['maxlength'];
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
				$html = "<textarea ". 
					((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
					((isset($this->name) && $this->name != "") ? "name=\"$this->name\" " : "") .
					((isset($this->class) && $this->class != "") ? "class=\"$this->class\" " : "") .
					((isset($this->maxlength) && $this->maxlength != "") ? "maxlength=\"$this->maxlength\" " : "") .
					((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") . ">" .
					((isset($this->value) && $this->value != "") ? $this->value : $this->default_value()) . "</textarea>\n";
					
	      if(isset($this->description)) {
	      	$description = "<span>$this->description</span>";
	      }
	      else {
					$description = "";
	      }
	      
	      if(isset($this->label)) {
					$html = "<label for=\"$this->id\">$this->label $description</label>$html ";
	      }

	      if(isset($this->maxlength)) {
	      	$html .= "<div id=\"". $this->name ."-limit\" class=\"textarea-limit\">100</div>";
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