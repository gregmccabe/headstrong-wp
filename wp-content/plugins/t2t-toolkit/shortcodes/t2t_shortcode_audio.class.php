<?php
if(!class_exists('T2T_Shortcode_Audio')) {
  /**
   * T2T_Shortcode_Audio
   *
   * @package T2T_Shortcode
   */
  class T2T_Shortcode_Audio extends T2T_Shortcode
  {
    const SHORTCODE_ID    = "audio";
    const SHORTCODE_NAME  = "Audio";

    /**
     * configure_attributes
     *
     * @since 1.0.0
     */
    public function configure_attributes() {
      array_push($this->attributes, new T2T_UploadHelper(array(
        "id"          => "content",
        "name"        => "content",
        "label"       => __("Audio File", "t2t"),
        "media_type"  => "audio"
      )));
      array_push($this->attributes, new T2T_SelectHelper(array(
        "id"          => "loop",
        "name"        => "loop",
        "label"       => __("Loop", "t2t"),
        "description" => __("Whether or not to loop the audio file.", "t2t"),
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
        "description" => __("Whether or not to automatically play the audio file.", "t2t"),
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
        "description" => __("What part of the audio to preload when the page is loaded.", "t2t"),
        "options"     => array(
          "none"     => "None",
          "metadata" => "Metadata",
          "auto"     => "Auto"
        ),
        "default"     => "none"
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

      if($autoplay == "off") {
        $autoplay = "";
      }

      if($loop == "off") {
        $loop = "";
      }

      return "<div class=\"audio_player\">" . wp_audio_shortcode(array(
        "src"      => $content,
        "loop"     => $loop,
        "autoplay" => $autoplay,
        "preload"  => $preload
      )) . "</div>";
    }
  }
}
?>