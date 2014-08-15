<?php
if(!class_exists('T2T_UploadHelper')) {
	/**
	 * T2T_UploadHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_UploadHelper extends T2T_FormHelper 
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

			$this->media_types = array("audio", "video", "image");

			if($data != null) {
				if(isset($data["media_type"]) && $data["media_type"] != "") {
					$this->media_type = $data["media_type"];	
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
				
				$html = new T2T_TextHelper(array(
				  "id"     => ((isset($this->id) && $this->id != "") ? $this->id : ""),
				  "name"   => ((isset($this->name) && $this->name != "") ? $this->name : ""),
				  "value"  => ((isset($this->value) && $this->value != "") ? $this->value : ""),
				  "class"  => "t2t-uploader attr"
				));  

				$classes = array("t2t-uploader-button", "button");
				if(isset($this->media_type) && in_array($this->media_type, $this->media_types)) {
					array_push($classes, "is_" . $this->media_type);
				}

				$html .= "<input type=\"button\" class=\"" . join($classes, " ") . "\" value=\"Upload\" />";
					
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


if(!class_exists('T2T_MultiUploadHelper')) {
	/**
	 * T2T_MultiUploadHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_MultiUploadHelper extends T2T_FormHelper 
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
				if(isset($data['limit'])) {
				  $this->limit = $data['limit'];
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

				$html = "<div class=\"t2t-gallery-thumbs\"><ul></ul></div>";

				$html .= new T2T_HiddenHelper(array(
				  "id"     => ((isset($this->id) && $this->id != "") ? $this->id : ""),
				  "name"   => ((isset($this->name) && $this->name != "") ? $this->name : ""),
				  "value"  => ((isset($this->value) && $this->value != "") ? $this->value : ""),
				  "class"  => "t2t-uploader attr"
				));  

				$html .= "<input type=\"button\" class=\"t2t-uploader-button multi-uploader button " .((isset($this->class) && $this->class != "") ? $this->class : ""). "\" data-limit=\"" .((isset($this->limit) && $this->limit != "") ? $this->limit : ""). "\" value=\"Upload Photos\" />";
					
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