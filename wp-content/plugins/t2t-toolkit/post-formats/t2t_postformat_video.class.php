<?php
if(!class_exists('T2T_PostFormat_Video')) {
  /**
   * T2T_PostFormat_Video
   *
   * @package T2T_PostFormat_Video
   */
  class T2T_PostFormat_Video extends T2T_PostFormat
  {
    /**
     * get_fields
     *
     * @since 1.0.0
     *
     * @return array $fields
     */
    public static function get_fields() {
      $fields = array();

      array_push($fields, new T2T_TextHelper(array(
        "id"          => "video_url",
        "name"        => "video_url",
        "class"       => "post-format-video",
        "label"       => __("Video URL"),
        "description" => __("Provide a URL to the video from one of our ")."<a href=\"http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F\" target=\"_blank\">".__("supported providers")."</a> or use an embed code below."
      )));

      array_push($fields, new T2T_TextareaHelper(array(
        "id"          => "video_embed",
        "name"        => "video_embed",
        "class"       => "post-format-video",
        "label"       => __("Video Embed Code"),
        "description" => __("Copy & paste the video embed code.")
      )));
    
      return $fields;
    }
  }
}
?>