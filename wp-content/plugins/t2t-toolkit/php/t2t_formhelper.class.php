<?php
if(!class_exists('T2T_FormHelper')) {
	/**
	 * T2T_FormHelper
	 *
	 * @package T2T_FormHelper
	 */
	class T2T_FormHelper extends T2T_BaseClass
	{
		/**
		 * __construct
		 *
		 * @since 1.0.0
		 */
		public function __construct($data) {
			if($data != null) {
				// every form element could contain the following
				if(isset($data['class'])) {
					$this->class = $data['class'];
				}
				if(isset($data['style'])) {
					$this->style = $data['style'];
				}
				if(isset($data['name'])) {
					$this->name = $data['name'];
				}
				if(isset($data['id'])) {
					$this->id = $data['id'];	
				}
	      if(isset($data['value'])) {
					$this->value = $data['value'];  
	      }
	      else {
	      	$this->value = null;
	      }
	      if(isset($data['default'])) {
					$this->default = $data['default'];  
	      }
				if(isset($data['disabled'])) {
					$this->disabled = $data['disabled'];	
				}
	      if(isset($data['label'])) {
					$this->label = $data['label'];  
	      }
	      if(isset($data['description'])) {
					$this->description = $data['description'];  
	      }

	      // allow elements to be added to a form without being rendered,
	      // this will be used for saving metaboxes, as the fields have to
	      // available, but we might not want to render them
	      if(isset($data['render'])) {
					$this->render = $data['render'];  
	      }
	      else {
	      	$this->render = true;
	      }
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
	  }
	    
		/**
		 * toString
		 *
		 * @since 1.0.0
		 */
		public function toString() {
			return "The " . get_class($this) . " object does not provide a toString() method.";
		}
		
		public function __toString() {
			return $this->toString();
		}
	}
}
?>