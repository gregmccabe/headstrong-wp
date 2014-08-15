<?php
if(!class_exists('T2T_SubmenuPage_Troubleshooting')) {
  /**
   * T2T_SubmenuPage_Troubleshooting
   *
   * @package T2T_SubmenuPage
   */
	class T2T_SubmenuPage_Troubleshooting extends T2T_SubmenuPage {
		/**
		 * __construct
		 *
		 * @since 1.0.0
		 *
		 * @param array $options Initial values for this page
		 */
		public function __construct($options = array()) {
		  $defaults = array(
		  	"parent_slug" => "tools.php",
		  	"page_title"  => "Troubleshooting",
		  	"menu_title"  => "Troubleshooting",
		  	"capability"  => "read",
		  	"menu_slug"   => "troubleshooting"
		  );

		  // merge defaults into the provided arguments
		  $options = array_merge($defaults, $options);

		  parent::__construct($options);
		}

    /**
     * handle_output
     *
     * @since 1.0.0
     */
		function handle_output() {
			// current theme information
			$current_theme = wp_get_theme();

			$output  = "<div class=\"wrap\">";
			$output .= "	" . get_screen_icon();
			$output .= "	<h2>" . __("Troubleshooting") . "</h2>";
			$output .= "	<p>" . __("Below is a set of information that is useful for troubleshooting various issues that you may experience. You can provide this information to our support staff to assist with the diagnostics process.") . "</p>";
			$output .= "  <table class=\"copy-to-clipboard-target wp-list-table widefat\" cellspacing=\"0\">";
			$output .= "    <thead>";
			$output .= "      <tr>";
			$output .= "        <th scope=\"col\" class=\"manage-column column-name\" colspan=\"2\">" . __("System Information") . "</th>";
			$output .= "      </tr>";
			$output .= "    </thead>";
			$output .= "    <tfoot><tr><th colspan=\"2\">" . __("Information pertaining to your php and wordpress installation.") . "</th></tr></tfoot>";
			$output .= "    <tbody>";
			$output .= "      <tr class=\"alternate\">";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("Theme Name") . ":</strong></td>";
			$output .= "        <td>" . $current_theme->Name . "</td>";
			$output .= "      </tr>";
			$output .= "      <tr>";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("Theme Version") . ":</strong></td>";
			$output .= "        <td>" . $current_theme->Version . "</td>";
			$output .= "      </tr>";
			$output .= "      <tr class=\"alternate\">";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("Theme Author") . ":</strong></td>";
			$output .= "        <td>" . $current_theme->Author . "</td>";
			$output .= "      </tr>";
			$output .= "      <tr>";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("Site URL") . ":</strong></td>";
			$output .= "        <td>" . get_bloginfo("url") . "</td>";
			$output .= "      </tr>";
			$output .= "      <tr class=\"alternate\">";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("Wordpress Version") . ":</strong></td>";
			$output .= "        <td>" . get_bloginfo("version") . "</td>";
			$output .= "      </tr>";
			$output .= "      <tr>";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("PHP Version") . ":</strong></td>";
			$output .= "        <td>" . phpversion() . "</td>";
			$output .= "      </tr>";

			$output .= "      <tr class=\"alternate\">";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("GD Version") . ":</strong></td>";

			// check for GD version, this is required to create thumbnails
			$gd = gd_info();
			if(isset($gd["GD Version"]) && $gd["GD Version"] != "") {
				$output .= "        <td>" . $gd["GD Version"] . "</td>";
			}
			else {
				$output .= "        <td>" . __("Not Installed") . "</td>";
			}

			$output .= "      </tr>";

			$output .= "      <tr>";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("Server") . ":</strong></td>";
			$output .= "        <td>" . $_SERVER["SERVER_SOFTWARE"] . "</td>";
			$output .= "      </tr>";

			if(strpos(ini_get("disable_functions"), "ini_set") === false) {
				$output .= "      <tr class=\"alternate\">";
				$output .= "        <td style=\"width: 200px;\"><strong>" . __("Max Upload Size") . ":</strong></td>";
				$output .= "        <td>" . ini_get("upload_max_filesize") . "</td>";
				$output .= "      </tr>";
				$output .= "      <tr>";
				$output .= "        <td style=\"width: 200px;\"><strong>" . __("Max POST Size") . ":</strong></td>";
				$output .= "        <td>" . ini_get("post_max_size") . "</td>";
				$output .= "      </tr>";
				$output .= "      <tr class=\"alternate\">";
				$output .= "        <td style=\"width: 200px;\"><strong>" . __("Memory Limit") . ":</strong></td>";
				$output .= "        <td>" . ini_get("memory_limit") . "</td>";
				$output .= "      </tr>";
				$output .= "      <tr>";
				$output .= "        <td style=\"width: 200px;\"><strong>" . __("Max Execution Time") . ":</strong></td>";
				$output .= "        <td>" . ini_get("max_execution_time") . "</td>";
				$output .= "      </tr>";
			}

			$output .= "      <tr class=\"alternate\">";
			$output .= "        <td style=\"width: 200px;\"><strong>" . __("WordPress Debug Mode") . ":</strong></td>";
			if(defined('WP_DEBUG') && WP_DEBUG) {
				$output .= "        <td>Enabled</td>";
			} else {
				$output .= "        <td>Disabled</td>";
			}
			$output .= "      </tr>";

			$output .= "    </tbody>";
			$output .= "  </table>";
			$output .= "  <br />";
			$output .= "  <table class=\"copy-to-clipboard-target wp-list-table widefat\" cellspacing=\"0\">";
			$output .= "    <thead>";
			$output .= "      <tr>";
			$output .= "        <th scope=\"col\" class=\"manage-column column-name\" colspan=\"2\">" . __("Active Plugins") . "</th>";
			$output .= "      </tr>";
			$output .= "    </thead>";
			$output .= "    <tfoot><tr><th colspan=\"3\">" . __("All of the plugins currently installed.") . "</th></tr></tfoot>";
			$output .= "    <tbody>";

			// initialize row counter
			$row = 0;

			// loop through each plugin
			foreach(get_plugins() as $key => $plugin) {
				// only include active plugins
				if(is_plugin_active($key)) {
					$output .= "      <tr class=\"" . (($row % 2 == 0) ? "alternate" : "") . "\">";
					$output .= "        <td style=\"width: 200px;\"><strong>" . $plugin["Name"] . " (" . $plugin["Version"] . "):</strong></td>";
					$output .= "        <td>" . $plugin["PluginURI"] . "</td>";
					$output .= "      </tr>";

					// increment row count
					$row++;
				}
			}

			$output .= "    </tbody>";
			$output .= "  </table>";

			$output .= "  <div class=\"tablenav bottom\">";	
			$output .= "  	<div class=\"alignleft actions\">";
			$output .= "  		<a href=\"javascript:;\" id=\"copy-to-clipboard\" class=\"button-primary\" target=\"_blank\">" . __("Copy to Clipboard") . "</a>";
			$output .= "  	</div>";
			$output .= "  	<div class=\"alignleft actions\">";
			$output .= "  		<a href=\"http://support.t2themes.com/\" class=\"button-primary\" target=\"_blank\">" . __("Help Desk →") . "</a>";
			$output .= "  	</div>";		
			$output .= "  	<br class=\"clear\">";
			$output .= "  </div>";
			$output .= "</div>";


			echo $output;
		}
	}
}
?>