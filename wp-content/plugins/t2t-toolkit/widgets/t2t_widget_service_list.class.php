<?php
if(!class_exists('T2T_Widget_Service_List')) {
  /**
   * T2T_Widget_Service_List
   *
   * @package T2T_Widget
   */
  class T2T_Widget_Service_List extends T2T_Custom_Widget
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
        "id"   => sprintf(__('%1$s_list', 't2t'), T2T_Service::get_name()),
        "name" => sprintf(__('%1$s List', 't2t'), T2T_Service::get_title()),
        "widget_opts" => array(
          "classname"   => get_class($this),
          "description" => sprintf(__('Display a list of %1$s.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
        ),
        "post_type_dependencies" => array(T2T_Service::get_name())
      ));
    }

    /**
     * configure_fields
     *
     * @since 1.0.0
     */
    public function configure_fields() {
      array_push($this->fields, new T2T_TextHelper(array(
        "id"      => "title",
        "name"    => "title",
        "label"   => __("Title", "t2t"),
        "default" => sprintf(__('%1$s', 't2t'), T2T_Service::get_title())
      )));

      $service_result = new WP_Query(array(
        "post_type" => T2T_Service::get_name()
      ));

      // -1 in WP_Query refers to all items
      $to_show_array = array(-1 => __("All", "t2t"));

      // confirm posts exist
      if($service_result->found_posts > 0) {
        // in order to preserve the precious keys, manually construct
        // the rest of the options
        foreach(range(1, $service_result->found_posts) as $option) {
          $to_show_array[$option] = $option;
        }
      }
          
      array_push($this->fields, new T2T_SelectHelper(array(
        "id"          => "posts_to_show",
        "name"        => "posts_to_show",
        "label"       => sprintf(__('%1$s Count', 't2t'), T2T_Service::get_title()),
        "description" => sprintf(__('Choose how many %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
        "options"     => $to_show_array,
      )));

      $this->fields = apply_filters("t2t_widget_service_list_fields", $this->fields);
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

      array_push($markup, "<div class=\"services\">");
      array_push($markup, "<ul>");

      $services_loop = new WP_Query(array(
        "post_type"      => T2T_Service::get_name(),
        "posts_per_page" => $instance["posts_to_show"]
      ));

      while($services_loop->have_posts() ) {
        // wordpress scope, grab this post
        $services_loop->the_post();
        
        $external_url = T2T_Toolkit::get_post_meta(get_the_id(), 'service_external_url', true, get_permalink());

        if(get_permalink() != $external_url) {
          $target = "_blank";
        } else {
          $target = "_self";      
        }
        
        array_push($markup, "<li>");
        array_push($markup, "<a href=\"" . T2T_Toolkit::get_post_meta(get_the_id(), 'service_external_url', true, get_permalink()) . "\" target=\"" . $target . "\">" . T2T_Toolkit::display_icon(get_post_meta(get_the_id(), 'service_icon', true)) . get_the_title() . "</a>");
        array_push($markup, "</li>");
      }
      
      array_push($markup, "</ul>");
      array_push($markup, "</div>");

      $markup = join("\n", $markup);

      return apply_filters("t2t_widget_service_list_output", $markup, $instance);
    }
  }
}
?>