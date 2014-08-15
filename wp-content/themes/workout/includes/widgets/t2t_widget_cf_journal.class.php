<?php
if(!class_exists('T2T_Widget_Cf_Journal')) {
  /**
   * T2T_Widget_Cf_Journal
   *
   * @package T2T_Widget
   */
  class T2T_Widget_Cf_Journal extends T2T_Widget
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
        "id"   => "cf_journal_link",
        "name" => __("CrossFit Journal Link", "t2t"),
        "widget_opts" => array(
          "description"  => __("Display a link to the CrossFit Journal (required for all CrossFit Affiliates).", "t2t")
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
      
      array_push($this->fields, new T2T_SelectHelper(array(
        "id"          => "image_style",
        "name"        => "image_style",
        "label"       => __("Image Style", "t2t"),
        "description" => __("Choose the style of the CrossFit Journal banner you'd like to use.", "t2t"),
        "options"     => array(
          "graphic"    => __("Graphic", "t2t"),
          "white_text" => __("White Text", "t2t"),
          "black_text" => __("Black Text", "t2t")
        ),
        "default"     => 3
      )));

      $this->fields = apply_filters("t2t_widget_cf_journal_fields", $this->fields);
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

      if(isset($instance["image_style"]) && in_array($instance["image_style"], array("graphic", "white_text", "black_text"))) {
        $title = __("CrossFit Journal: The Performance-Based Lifestyle Resource", "t2t");

        if($instance["image_style"] == "graphic") {
          array_push($markup, "<a href=\"http://journal.crossfit.com/start.tpl?version=CFJ-graphic300x150\" target=\"_blank\" title=\"" . $title . "\">");
          array_push($markup, "  <img src=\"http://journal.crossfit.com/templates/images/graphic-300x150.jpg\" alt=\"" . $title . "\" />");
          array_push($markup, "</a>");
        }
        elseif($instance["image_style"] == "black_text") {
          array_push($markup, "<a href=\"http://journal.crossfit.com/start.tpl?version=CFJ-black300x150\" target=\"_blank\" title=\"" . $title . "\">");
          array_push($markup, "  <img src=\"http://journal.crossfit.com/templates/images/black-300x150.png\" alt=\"" . $title . "\" />");
          array_push($markup, "</a>");
        }
        elseif($instance["image_style"] == "white_text") {
          array_push($markup, "<a href=\"http://journal.crossfit.com/start.tpl?version=CFJ-white300x150\" target=\"_blank\" title=\"" . $title . "\">");
          array_push($markup, "  <img src=\"http://journal.crossfit.com/templates/images/white-300x150.png\" alt=\"" . $title . "\" />");
          array_push($markup, "</a>");
        }
      }

      $markup = join("\n", $markup);

      return apply_filters("t2t_widget_cf_journal_output", $markup, $instance);
    }
  }
}
?>