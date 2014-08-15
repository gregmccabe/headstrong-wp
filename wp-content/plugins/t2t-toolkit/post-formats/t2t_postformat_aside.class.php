<?php
if(!class_exists('T2T_PostFormat_Aside')) {
  /**
   * T2T_PostFormat_Aside
   *
   * @package T2T_PostFormat_Aside
   */
  class T2T_PostFormat_Aside extends T2T_PostFormat
  {
    /**
     * get_fields
     *
     * @since 1.0.0
     *
     * @return array $fields
     */
    public static function get_fields() {
      $fields = apply_filters("t2t_post_format_aside_fields", array());

      return $fields;
    }
  }
}
?>