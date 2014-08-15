<?php
if(!class_exists('T2T_SubmenuPage')) {
  /**
   * T2T_SubmenuPage
   *
   * @package T2T_SubmenuPage
   */
	class T2T_SubmenuPage extends T2T_BaseClass {

		/**
		 * __construct
		 *
		 * @since 1.0.0
		 *
		 * @param array $options Initial values for this page
		 */
		public function __construct($options = array()) {
		  $defaults = array(
		    "parent_slug" => "options-general.php"
		  );

		  // merge defaults into the provided arguments
		  $options = array_merge($defaults, $options);

			if(isset($options["parent_slug"])) {
				$this->parent_slug = $options["parent_slug"];
			}

			if(isset($options["page_title"])) {
				$this->page_title = $options["page_title"];
			}

			if(isset($options["menu_title"])) {
				$this->menu_title = $options["menu_title"];
			}

			if(isset($options["capability"])) {
				$this->capability = $options["capability"];
			}

			if(isset($options["menu_slug"])) {
				$this->menu_slug = $options["menu_slug"];
			}

			// add_action('admin_menu', array(&$this, 'add_page'));\
			$this->add_page();
		}

    /**
     * add_page
     *
     * @since 1.0.0
     */
		function add_page () {
			// wp call to add this page to the admin
			add_submenu_page(
				$this->parent_slug,
				$this->page_title,
				$this->menu_title,
				$this->capability,
				$this->menu_slug,
				array($this, "handle_output"));
		}

    /**
     * handle_output
     *
     * @since 1.0.0
     */
		function handle_output() {
			$output  = "<div class=\"wrap\">";
			$output .= "	" . get_screen_icon();
			$output .= "	<h2>" . __("Method Missing") . "</h2>";
			$output .= "  <div class=\"manage-menus\">";
 			$output .= "	  <span class=\"add-edit-menu-action\">";
			$output .= "	  " . __("This page does not properly override the <b><i>handle_output</i></b> method.", "t2t");
			$output .= "	  </span>";
			$output .= "  </div>";
			$output .= "</div>";

			echo $output;
		}
	}
}
?>