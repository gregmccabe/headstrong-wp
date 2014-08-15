<?php
if(!class_exists('T2T_Shortcode_Video')) {
  /**
   * T2T_Shortcode_Video
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Video extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "video";
    const SHORTCODE_NAME  = "Video";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"          => "content",
        "name"        => "content",
        "label"       => __("Video File", "t2t"),
        "media_type"  => "video"
      )));
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"          => "poster",
        "name"        => "poster",
        "label"       => __("Poster", "t2t"),
        "description" => __("Select an image to display before playing the video, leave blank for default functionality.", "t2t"),
        "media_type"  => "image"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "loop",
        "name"        => "loop",
        "label"       => __("Loop", "t2t"),
        "description" => __("Whether or not to loop the video file.", "t2t"),
        "options"     => array(
          "on"  => "On",
          "off" => "Off"
        ),
        "default"     => "off"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "autoplay",
        "name"        => "autoplay",
        "label"       => __("Autoplay", "t2t"),
        "description" => __("Whether or not to automatically play the video file.", "t2t"),
        "options"     => array(
          "on"  => "On",
          "off" => "Off"
        ),
        "default"     => "off"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "preload",
        "name"        => "preload",
        "label"       => __("Preload?", "t2t"),
        "description" => __("What part of the video to preload when the page is loaded.", "t2t"),
        "options"     => array(
          "none"     => "None",
          "metadata" => "Metadata",
          "auto"     => "Auto"
        ),
        "default"     => "none"
      )));
      array_push($this->attributes, new T2T_SliderHelper(array(
        "id"          => "width",
        "name"        => "width",
        "label"       => __("Width", "t2t"),
        "description" => __("Set the display width of the video, the height will auto adjust.", "t2t"),
        "range"       => "100,940",
        "step"        => "10",
        "default"     => "940"
      )));
    }

    /**
     * handle_output
     *
     * @since 1.0.0
     *
     * @param array $options Options provided to the markup
     * @param string $content Content of the shortcode
     *
     * @return HTML representing this shortcode
     */
    public function handle_output($options, $content = null) {
      extract(shortcode_atts($this->get_attributes_as_defaults(), $options));

      return "<div class=\"video_player\">" . wp_video_shortcode(array(
        "src"      => $content,
        "poster"   => $poster,
        "loop"     => $loop,
        "autoplay" => $autoplay,
        "preload"  => $preload,
        "width"    => $width
      )) . "</div>";
    }
  }
}
?>