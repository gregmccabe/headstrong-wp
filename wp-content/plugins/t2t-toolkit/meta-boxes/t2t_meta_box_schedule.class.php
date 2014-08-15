<?php
if(!class_exists('T2T_MetaBox_Schedule')) {
  /**
   * T2T_MetaBox_Schedule
   *
   * @package T2T_MetaBox
   */
  class T2T_MetaBox_Schedule extends T2T_MetaBox
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
        "id"        => "schedule_metabox",
        "title"     => __("Schedule", "t2t"),
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
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "monday_time",
        "name"   => "monday_time",
        "render" => false
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "tuesday_time",
        "name"   => "tuesday_time",
        "render" => false
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "wednesday_time",
        "name"   => "wednesday_time",
        "render" => false
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "thursday_time",
        "name"   => "thursday_time",
        "render" => false
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "friday_time",
        "name"   => "friday_time",
        "render" => false
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "saturday_time",
        "name"   => "saturday_time",
        "render" => false
      )));
      array_push($this->fields, new T2T_HiddenHelper(array(
        "id"     => "sunday_time",
        "name"   => "sunday_time",
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

      $days = array(
          __("sunday", "t2t"),    // 0
          __("monday", "t2t"),    // 1
          __("tuesday", "t2t"),   // 2
          __("wednesday", "t2t"), // 3
          __("thursday", "t2t"),  // 4
          __("friday", "t2t"),    // 5
          __("saturday", "t2t")   // 6
      );

      $html .= "<div class=\"schedule_wrapper\">";
      $html .= " <div class=\"schedule_form\">";
      $html .= "  <h2 style=\"margin-top: 0; padding-top: 0;\"></h2>";
      $html .= "  <div class=\"t2t-post-option-row\">";

      $start_time_field = new T2T_TimeSelectHelper(array(
        "id"          => "open_time",
        "name"        => "open_time",
        "label"       => __("Opening Time", "t2t"),
        "description" => __("Where to start the time for this schedule.", "t2t"),
        "class"       => "schedule_start_time",
        "start_time"  => "00",
        "end_time"    => "23",
        "minute_step" => get_theme_mod("t2t_customizer_scheduling_interval", 30)
      ));
      $html .= "    " . $start_time_field->toString();

      $html .= "  </div>";
      $html .= "  <div class=\"t2t-post-option-row\">";

      $end_time_field = new T2T_TimeSelectHelper(array(
        "id"          => "close_time",
        "name"        => "close_time",
        "label"       => __("Closing Time", "t2t"),
        "description" => __("Where to end the time for this schedule.", "t2t"),
        "class"       => "schedule_end_time",
        "start_time"  => "00",
        "end_time"    => "23",
        "minute_step" => get_theme_mod("t2t_customizer_scheduling_interval", 30)
      ));
      $html .= "    " . $end_time_field->toString();

      $html .= "  </div>";
      $html .= "  <div class=\"t2t-post-option-row\">";
      $html .= "    <a href=\"javascript:;\" class=\"button cancel\">Cancel</a>";
      $html .= "    <a href=\"javascript:;\" class=\"button button-primary\">Add Hours &rarr;</a>";
      $html .= "  </div>";
      $html .= " </div>";

      foreach($days as $day) {
        $html .= "<ul class=\"schedule ". $day ."\">";
        $html .= "  <li class=\"day\">$day</li>";

        $times = get_post_meta($post->ID, $day."_time");

        if(!empty($times)) {

          // sort the times for display
          usort($times, array("T2T_MetaBox_Schedule", "compare_times"));

          foreach($times as $key=>$time) {
            $hidden_field = new T2T_HiddenHelper(array(
              "name"    => $day."_time[]",
              "value"   => $time
            ));

            list($start_time, $end_time) = explode(",", $time);

            $html .= "<li id=\"" . $day . "_" . $key . "\" class=\"time\">";
            $html .= "<span>" . date("h:i a", strtotime("$day $start_time")) . "</span> ". $hidden_field->toString();
            $html .= "<a href=\"javascript:;\" class=\"edit_time\"><i class=\"typicons-pencil\"></i></a>";
            $html .= "<a href=\"javascript:;\" class=\"delete_time\"><i class=\"typicons-delete\"></i></a>";
            $html .= "</li>";
          }
        }

        $html .= "  <li class=\"add\"><a href=\"javascript:;\"><span class=\"entypo-plus\"></span>Add Time</a></li>";
        $html .= "</ul>";
      }

      $html .= "</div>";

      echo $html;
    }

    /**
     * compare_times
     *
     * @since 1.0.0
     *
     * @param string $a Value to compare to $b
     * @param string $b Value to compare to $a
     *
     * @return < 0 if $a is less than $b; > 0 if $a is greater than $b, and 0 if they are equal.
     */
    public static function compare_times($a, $b) {
      list($a_start, $a_end) = explode(",", $a);
      list($b_start, $b_end) = explode(",", $b);

      return strcmp($a_start, $b_start);
    }
  }
}
?>