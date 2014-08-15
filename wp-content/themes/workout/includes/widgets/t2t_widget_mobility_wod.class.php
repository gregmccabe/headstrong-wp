<?php
if(!class_exists('T2T_Widget_Mobility_WOD')) {
  /**
   * T2T_Widget_Mobility_WOD
   *
   * @package T2T_Widget
   */
  class T2T_Widget_Mobility_WOD extends T2T_Widget
  {  
    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param string $data 
     */
  	function __construct() {
      // call the parent to register the widget
      parent::__construct(array(
        "id"   => "mobility_wod_link",
        "name" => __("MobilityWOD Link", "t2t"),
        "widget_opts" => array(
          "description"  => __("Display a link to the MobilityWOD website.", "t2t")
        )
      ));
  	}

    /**
     * configure_fields
     *
     * @since 1.0.0
     */
    public function configure_fields() {
      array_push($this->fields, new T2T_TextHelper(array(
        "id"    => "title",
        "name"  => "title",
        "label" => __("Title", "t2t")
      )));

      $this->fields = apply_filters("t2t_widget_mobility_wod_fields", $this->fields);
    }

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @return HTML representing this widget
     */
    public function handle_output($instance) {
      $markup = array();

      array_push($markup, "<a href=\"http://www.mobilitywod.com\" target=\"_blank\" title=\"MobilityWOD\">");
      array_push($markup, "  <img src=\"http://www.mobilitywod.com/mwod-banners/400x72.jpg\" alt=\"MobilityWOD\" />");
      array_push($markup, "</a>");

      $markup = join("\n", $markup);

      return apply_filters("t2t_widget_mobility_wod_output", $markup, $instance);
    }
  }
}
?>