<?php
if(!class_exists('T2T_MetaBox_Gallery')) {
  /**
   * T2T_MetaBox_Gallery
   *
   * @package T2T_MetaBox
   */
  class T2T_MetaBox_Gallery extends T2T_MetaBox
  {   
    /**
     * __construct
     *
     * @since 1.0.0
     *
     * @param array $data Initial values for this field
     */
    public function __construct($data = array()) {
      $defaults = array(
        "id"        => "gallery_metabox",
        "title"     => __("Photos", "t2t"),
        "context"   => "normal",
        "priority"  => "core"
      );

      // merge defaults into the provided arguments
      $data = array_merge($defaults, $data);

      // call parent constructor
      parent::__construct($data);
    }

     /**
     * configure_fields
     *
     * @since 1.0.0
     */
    public function configure_fields() {  
      array_push($this->fields, new T2T_ButtonHelper(array(
        "id"    => "t2t_gallery_button",
        "name"  => "t2t_gallery_button",
        "class" => "button button-primary button-large",
        "value" => "Add Photos"
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "gallery_image_ids",
        "name"   => "gallery_image_ids",
        "render" => false
      )));
    }

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @param post $post An object containing the current post
     * @param metabox $metabox An array with metabox id, title, callback, and args elements.
     */
    public function handle_output($post, $metabox) {
      // print out the fields
      $html = parent::handle_output($post, $metabox);

      $html .= "<div class=\"t2t-gallery-thumbs\">\n";

      // retrieve the photos already added
      $image_ids = get_post_meta($post->ID, 'gallery_image_ids');

      $html .= "<ul data-images=\"". join(',', $image_ids) ."\">\n";

      // only print the lis if images exist
      if(!empty($image_ids)) {
        // display each photo thumbnail
        foreach($image_ids as $thumb ) {
          $hidden_field = new T2T_HiddenHelper(array(
            "name"    => "gallery_image_ids[]",
            "value"   => $thumb
          ));
          $html .= "<li>" . wp_get_attachment_image($thumb, "thumbnail") . $hidden_field->toString() ."</li>\n";
        }
      }

      $html .= "</ul>\n";

      $html .= "</div>\n";

      echo $html;
    }
  }
}
?>