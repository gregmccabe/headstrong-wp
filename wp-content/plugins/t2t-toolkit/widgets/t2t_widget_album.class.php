<?php
if(!class_exists('T2T_Widget_Album')) {
  /**
   * T2T_Widget_Album
   *
   * @package T2T_Widget
   */
  class T2T_Widget_Album extends T2T_Custom_Widget
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
        "id"   => sprintf(__('%1$s', 't2t'), T2T_Album::get_name()),
        "name" => sprintf(__('%1$s', 't2t'), T2T_Album::get_title()),
        "widget_opts" => array(
          "description"  => sprintf(__('Display images from a selected %1$s.', 't2t'), strtolower(T2T_Album::get_title()))
        ),
        "post_type_dependencies" => array(T2T_Album::get_name())
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
      
      // query for all albums with photos
      $albums_loop = new WP_Query(array(
        "post_type" => T2T_Album::get_name(),
        "meta_query" => array(
          array(
            "key" => "gallery_image_ids",
            "compare" => "EXISTS"
          )
        )
      ));
      
      // initialize an options array
      $thumbnails = array();
      
      // create a standard array to pass as options
      while($albums_loop->have_posts()) { 
        $albums_loop->the_post();
        
        // append this album to the array
        $thumbnails[get_the_ID()] = get_the_title();
      }
      
      array_push($this->fields, new T2T_SelectHelper(array(
        "id"            => "album",
        "name"          => "album",
        "label"       => sprintf(__('%1$s', 't2t'), T2T_Album::get_title()),
        "description" => sprintf(__('Choose the %1$s you\'d like displayed.', 't2t'), strtolower(T2T_Album::get_title())),
        "options"       => $thumbnails
      )));
      
      array_push($this->fields, new T2T_SelectHelper(array(
        "id"            => "posts_to_show",
        "name"          => "posts_to_show",
        "label"         => __("Photo Count", "t2t"),
        "description"   => __("Choose the number of photos to be displayed.", "t2t"),
        "options"       => array(3 => 3, 4 => 4, 6 => 6, 8 => 8, 9 => 9, 12 => 12),
        "default"       => 9
      )));

      array_push($this->fields, new T2T_SelectHelper(array(
        "id"            => "posts_per_row",
        "name"          => "posts_per_row",
        "label"         => __("Photos Per Row", "t2t"),
        "description"   => __("Choose the number of photos to be displayed in each row.", "t2t"),
        "options"       => array(2 => 2, 3 => 3, 4 => 4),
        "default"       => 3
      )));

      $this->fields = apply_filters("t2t_widget_album_fields", $this->fields);
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

      array_push($markup, "<div class=\"gallery\">");

      // initialize options to send to t2t_get_gallery_images
      $options = array(
        "posts_to_show"  => $instance["posts_to_show"],
        "posts_per_row"  => $instance["posts_per_row"]
      );
      
      // gather the images
      $images = T2T_Toolkit::get_gallery_images($instance["album"], $options);
      
      // loop through each image returned
      foreach($images as $index => $image_id) {
        // collect the image information necessary
        $image_file  = wp_get_attachment_image($image_id, "thumbnail");
        $large_image = wp_get_attachment_image_src($image_id, "full");
        
        // initialize the class attribute for the image
        $classes = array("photo");
        
        array_push($classes, T2T_Toolkit::determine_loop_classes(sizeof($images), ($index + 1), $options));
        
        array_push($markup,           
          "<div class=\"" . join(" ", $classes) . "\">",
          "   <a href=\"" . get_attachment_link($image_id) . "\">",
          "       ". $image_file,
          "   </a>",
          "</div>"
        );
      }
      
      array_push($markup, "<div class=\"clear\"></div>");
      array_push($markup, "</div>");

      $markup = join("\n", $markup);

      return apply_filters("t2t_widget_album_output", $markup, $instance);
    }
  }
}
?>