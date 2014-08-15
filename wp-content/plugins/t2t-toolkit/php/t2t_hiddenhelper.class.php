<?php
if(!class_exists('T2T_HiddenHelper')) {
	/**
	 * T2T_HiddenHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_HiddenHelper extends T2T_FormHelper 
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
			if($this->render === false) {
				return false;
			}

			// determine which version of the object to dislay
			if($version == TOSTRING_FULL) {
				return "<input type=\"hidden\" ". 
					((isset($this->id) && $this->id != "") ? "id=\"$this->id\" " : "") .
					((isset($this->name) && $this->name != "") ? "name=\"$this->name\" " : "") .
					((isset($this->class) && $this->class != "") ? "class=\"$this->class\" " : "") .
					((isset($this->style) && $this->style != "") ? "style=\"$this->style\" " : "") .
					((isset($this->disabled) && $this->disabled != "" && $this->disabled === true) ? "disabled=\"disabled\" " : "") .
					((isset($this->value) && $this->value != "") ? "value=\"$this->value\" " : "value=\"" . $this->default_value() ."\"") . " />\n";
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