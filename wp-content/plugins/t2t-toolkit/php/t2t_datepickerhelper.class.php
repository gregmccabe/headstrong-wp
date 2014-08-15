<?php
if(!class_exists('T2T_DatePickerHelper')) {
	/**
	 * T2T_DatePickerHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_DatePickerHelper extends T2T_FormHelper 
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
				if(isset($data['date_format'])) {
				  $this->date_format = $data['date_format'];
				}
				else {
					// default date format
					$this->date_format = "";
				}
			  if(isset($data['alt_format'])) {
			    $this->alt_format = $data['alt_format'];
			  }
			  else {
					// default to mysql date format
			  	$this->alt_format = "yy-mm-dd";
			  }
			  if(isset($data['inline'])) {
			    $this->inline = $data['inline'];
			  }
			  else {
			  	$this->inline = false;
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

				if($this->inline == true) {
					$html = "<div " . 
						((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
						((isset($this->class) && $this->class != "") ? "class=\"t2t_datepicker $this->class\" " : "class=\"t2t_datepicker\" ") . ">\n";
						"</div>";
				}
				else {
					$html = "<input type=\"text\" ". 
						((isset($this->id) && $this->id != "") ? "id=\"" . $this->id . "_alt\" " : "") .
						((isset($this->name) && $this->name != "") ? "name=\"" . $this->name . "_alt\" " : "") .
						((isset($this->class) && $this->class != "") ? "class=\"$this->class\" " : "") .
						((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") . " />\n";
				}

				$html .= "<a href=\"javascript:;\" class=\"t2t_datepicker_clear\"><span class=\"entypo-cancel\"></span></a>";

				$html .= "<input type=\"hidden\" ". 
					((isset($this->id) && $this->id != "") ? "id=\"" . $this->id . "\" " : "") .
					((isset($this->name) && $this->name != "") ? "name=\"" . $this->name . "\" " : "") .
					((isset($this->class) && $this->class != "") ? "class=\"t2t_datepicker $this->class\" " : "class=\"t2t_datepicker\" ") .
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