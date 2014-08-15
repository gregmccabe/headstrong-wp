<?php
if(!class_exists('T2T_PostFormat_Audio')) {
  /**
   * T2T_PostFormat_Audio
   *
   * @package T2T_PostFormat_Audio
   */
  class T2T_PostFormat_Audio extends T2T_PostFormat
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
        "id"          => "audio_url",
        "name"        => "audio_url",
        "class"       => "post-format-audio",
        "label"       => __("Audio URL"),
        "description" => __("Provide a URL to the audio from one of our ")."<a href=\"http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F\" target=\"_blank\">".__("supported providers")."</a> or use an embed code below."
      )));

      array_push($fields, new T2T_TextareaHelper(array(
        "id"          => "audio_embed",
        "name"        => "audio_embed",
        "class"       => "post-format-audio",
        "label"       => __("Audio Embed Code"),
        "description" => __("Copy & paste the audio embed code.")
      )));

      return $fields;
    }
  }
}
?>