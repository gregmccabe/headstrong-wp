<?php
if(!class_exists('T2T_Shortcode_Schedule')) {
	/**
	 * T2T_Shortcode_Schedule
	 *
	 * @package T2T_Shortcode
	 */
	class T2T_Shortcode_Schedule extends T2T_Shortcode
	{
        const SHORTCODE_ID    = "t2t_schedule";
        const SHORTCODE_NAME  = "Schedule";

        /**
         * configure_attributes
         *
         * @since 1.0.0
         */
        public function configure_attributes() {
            // gather all the albums created
            $service_result = new WP_Query(array(
                "posts_per_page" => -1,
                "post_type"      => T2T_Service::get_name()
            ));

            // -1 in WP_Query refers to all items
            $to_show_array = array(-1 => __("All", "t2t"));

            // list of services for attribute
            $service_list = array();

            // initialize the index and option counter
            $i = 0;

            // create a standard array to pass as options
            while($service_result->have_posts()) {
                $service_result->the_post();

                // increment index and option counter
                $i++;

                // add the index as an option
                $to_show_array[$i] = $i;

                // append this service to the array
                $service_list[get_the_ID()] = get_the_title();
            }

            array_push($this->attributes, new T2T_SelectHelper(array(
                "id"          => "program_id",
                "name"        => "program_id",
                "label"       => sprintf(__('%1$s', 't2t'), T2T_Service::get_title()),
                "description" => sprintf(__('Choose a specific %1$s you\'d like a schedule displayed for.', 't2t'), strtolower(T2T_Service::get_title())),
                "options"     => $service_list,
                "prompt"      => sprintf(__('Select a %1$s', 't2t'), T2T_Service::get_title())
            )));
            array_push($this->attributes, new T2T_SelectHelper(array(
                "id"          => "show_program_filter",
                "name"        => "show_program_filter",
                "label"       => __("Show Program Filter?", "framework"),
                "description" => sprintf(__('Whether or not to include a list of programs that will allow visitors to filter your %1$s.', 't2t'), strtolower(T2T_Toolkit::pluralize(T2T_Service::get_title()))),
                "options"     => array(
                    "true"  => __("Yes", "framework"),
                    "false" => __("No", "framework")
                ),
                "default"     => "true"
            )));
            array_push($this->attributes, new T2T_TimeSelectHelper(array(
                "id"          => "open_time",
                "name"        => "open_time",
                "label"       => __("Opening Time", "t2t"),
                "description" => __("Where to start the time for this schedule.", "t2t"),
                "prompt"      => "Auto"
            )));
            array_push($this->attributes, new T2T_TimeSelectHelper(array(
                "id"          => "close_time",
                "name"        => "close_time",
                "label"       => __("Closing Time", "t2t"),
                "description" => __("Where to end the time for this schedule.", "t2t"),
                "prompt"      => "Auto"
            )));

            // reset to main query
            wp_reset_postdata();

            $this->attributes = apply_filters("t2t_shortcode_schedule_fields", $this->attributes);
        }

        /**
         * handle_shortcode
         *
         * @since 1.0.0
         *
         * @param array $atts Version of the field to display
         * @param string $content Main content of the shortcode
         *
         * @return HTML representing this shortcode
         */
        public function handle_shortcode($atts, $content = null) {
            $options = shortcode_atts($this->get_attributes_as_defaults(), $atts);

            // allow modifcation to the markup
            $output = apply_filters("t2t_shortcode_schedule_output", $this->handle_output($options, $content), $options, $content);

            return apply_filters("t2t_shortcode_schedule_wrapper", $output, $options);
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

            // allow override of default timezone
            $default_timezone = apply_filters("t2t_default_timezone", "UTC");

            // give wordpress admin the last say in the timezone preference
            $timezone = get_option("timezone_string", $default_timezone);

            // handle case of empty timezone string
            $timezone = (empty($timezone) ? $default_timezone : $timezone);

            // set php timezone
            date_default_timezone_set($timezone);

            // options from the shortcode and defaults
            // to be provided to fullcalendar as json
            $calendar_options = array(
            	"header"       => "false",
            	"defaultView"  => "agendaWeek",
            	"allDaySlot"   => false,
            	"firstDay"     => get_option("start_of_week"),
            	"timeFormat"   => array(
            		"agenda" => T2T_Toolkit::time_format_php_to_js(get_option("time_format"))
            	),
            	"columnFormat" => array(
            		"day"  => "dddd",
            		"week" => "dddd"
            	),
            	"contentHeight" => 999999,
            	"timezone" => $timezone,
                "dayNames" => array(
                    __("sunday", "t2t"),
                    __("monday", "t2t"),
                    __("tuesday", "t2t"),
                    __("wednesday", "t2t"),
                    __("thursday", "t2t"),
                    __("friday", "t2t"),
                    __("saturday", "t2t")
                )
            );

            $calendar_id = mt_rand(99, 999);

            if(isset($open_time) && $open_time != "auto") {
            	$calendar_options["minTime"] = $open_time;
            }
            if(isset($close_time) && $close_time != "auto") {
            	$calendar_options["maxTime"] = $close_time;
            }

            $html = "";

            if(isset($program_id) && $program_id != "") {
                // a single program was selected
                $events = $this->gather_times($program_id);

                // make sure events exist
                if(!empty($events)) {
                	// if a minimum time was not provided, set one based on
                	// the event data
            	    if(!isset($calendar_options["minTime"])) {
            	    	$calendar_options["minTime"] = $this->determine_min_time($events);
            	    }

            	    // if a maximum time was not provided, set one based on
            	    // the event data
            	    if(!isset($calendar_options["maxTime"])) {
            	    	$calendar_options["maxTime"] = $this->determine_max_time($events);
            	    }
                }

                // set the events option for full calendar
            	$calendar_options["events"] = $events;
            }
            else {
            	// gather all the programs created
                $program_result = new WP_Query(array(
                    "posts_per_page" => -1,
                    "post_type"      => T2T_Service::get_name()
                ));

                $all_events = array();

                // iteration used to determine which color from
                // the default color array to use
                $iteration = 0;

                // used to store min and max times for each program
                // which will later get sorted again to determine the
                // min and max times for the calendar
                $min_times = array();
                $max_times = array();

                // create a standard array to pass as options
                while($program_result->have_posts()) {
                    $program_result->the_post();

                    $events = $this->gather_times(get_the_ID());

                    // add this array of times to the event sources array
                    // array_push($all_events, $events);
                    $all_events = array_merge($all_events, $events);

                    // increment the counter
                    $iteration++;
                }

                // confirm this program has times
                if(!empty($all_events)) {
                    // sort by start time, placing the earliest event first
                    usort($all_events, array("T2T_Shortcode_Schedule", "compare_start_times"));

                    array_push($min_times, $all_events[0]);

                    // sort by end time, placing the earliest event first
                    usort($all_events, array("T2T_Shortcode_Schedule", "compare_end_times"));

                    array_push($max_times, $all_events[0]);
                }

                // if a minimum time was not provided, set one based on
                // the event data
                if(!isset($calendar_options["minTime"])) {
                    $calendar_options["minTime"] = $this->determine_min_time($all_events);
                }

                // if a maximum time was not provided, set one based on
                // the event data
                if(!isset($calendar_options["maxTime"])) {
                    $calendar_options["maxTime"] = $this->determine_max_time($all_events);
                }

                // set the eventSources option for full calendar
                $calendar_options["events"] = $all_events;

                // if the user elected to show the filter at the top
                if(filter_var($options["show_program_filter"], FILTER_VALIDATE_BOOLEAN)) {
                    wp_reset_postdata();

                    $iteration = 0;

                    $html .= "<div class=\"program_filter_wrapper\">";
                    $html .= "<select class=\"program_filter\" data-calendar_id=\"calendar-$calendar_id\" data-all_events='". json_encode($all_events) ."'>";
                    $html .= "	<option value=\"all\" selected=\"selected\">". __("All Programs", "t2t") ."</option>";

                    // iterate through and add each program as a filter
                    while($program_result->have_posts()) {
            	        $program_result->the_post();

                        // color set by the user for this program
                        $color = T2T_Toolkit::get_post_meta(get_the_ID(), "accent_color", true, "#444444");

                        $html .= "	<option data-color=\"$color\" value=\"" . T2T_Service::get_name() . "_" . get_the_ID() . "\">" . get_the_title() . "</option>";

                        // increment the counter
                        $iteration++;
                    }

                    $html .= "</select>";
                    $html .= "</div>";
            	}
            }

            // container for the calendar
            $html .= "<article class=\"calendar\">";
            $html .= "	<div class=\"inner\">";
            $html .= "		<div class=\"calendar_nav\">";
            $html .= "			<a href=\"javascript:;\" class=\"prev_day\"><span class=\"entypo-left-open\"></span></a>";
            $html .= "			<a href=\"javascript:;\" class=\"next_day\"><span class=\"entypo-right-open\"></span></a>";
            $html .= "		</div>";
            $html .= "		<div id=\"calendar-$calendar_id\"></div>";
            $html .= "	</div>";
            $html .= "</article>";

            // javascript to render the calendar
            $html .= "<script type=\"text/javascript\">";
            $html .= "jQuery(document).ready(function($) {";
            $html .= "	jQuery('#calendar-$calendar_id').";
            $html .= "		fullCalendar(" . json_encode($calendar_options) . ");";
            $html .= "});";
            $html .= "</script>";

            return $html;
        }

        /**
         * gather_times
         *
         * @since 2.0.0
         *
         * @param integer $program_id The ID of the program to get times for
         * @param array $options Options to append to the event hash
         *
         * @return An array of events (times) that belong to the provided program
         */
        private function gather_times($program_id, $options = array()) {
            $schedule_times = array();

            // get the program by the id provided
            $post = get_post($program_id);

            // these strings cannot be localized, they are not used for display
            // but rather for comparison with PHP and lookup in the database
            $days = array(
                "sunday",
                "monday",
                "tuesday",
                "wednesday",
                "thursday",
                "friday",
                "saturday"
            );

            // because fullcalendar is an actual calendar we
            // are unable to just slap days on the top of the
            // columns -- we'll use the current week instead
            $start_of_week = get_option("start_of_week");

            // regardless of the 'start_of_week' value, we always start
            // gathering data at the 0 value above, sunday. the adjustments
            // below compensate for the date since we are using *real*
            // calendar instead of filling in arbitrary cells of a table.
            foreach($days as $index => $day) {
                // color set by the user for this program
                $color = T2T_Toolkit::get_post_meta($post->ID, "accent_color", true, "#444444");

                // retrieve all the times for this day
                $times = get_post_meta($post->ID, $day . "_time");

                if($index == $start_of_week) {
                  $adjustment = $index - date("w");
                }
                else if($index < $start_of_week) {
                    // if the day were on ($index) is less than the
                    // day displayed first on the calendar
                    if(date("w") == 0) {
                    	// if today is sunday, don't adjust
                    	$adjustment = $index;
                    }
                    else {
                    	if($start_of_week > date("w")) {
                        	$adjustment = ($index - date("w"));
                        }
                        else {
                        	$adjustment = ($index + (7 - date("w")));
                        }
                    }
                }
                else {
                    // the adjustment starting at the start of week
                    $digit = date("w");

                    // a single edge case
                    if($digit == 0) {
                    	$digit = 7;
                    }
                    elseif($start_of_week > date("w")) {
                    	$digit = (7 + date("w"));
                    }

                    $adjustment = ($index - $digit);
                }

                // positive or negative increment (negative numbers
                // translate to strings, positives do not)
                $sign  = "";
                if($adjustment >= 0) {
                    $sign = "+";
                }

                // simply handling pluralization of the unit of time
                $units = "days";
                if(abs($adjustment) == 1) {
                    $units = "day";
                }

                // determines the actual date of the 'cell' relative to 'today'
                // so that the data provided to the calendar represent the
                // actual days displayed
                $day = date("Y-m-d", strtotime("$sign$adjustment $units"));

                // confirm that there are times for this day
                if(!empty($times)) {
                    // display each time
                    foreach($times as $key => $time) {
                        // extract start and end time from each pair
                        list($start_time, $end_time) = explode(",", $time);

                        $start_date = "$day $start_time";
                        $end_date   = "$day $end_time";

                        if($end_date <= $start_date) {
                        	$end_date = date("Y-m-d H:i", strtotime("+24 hours", strtotime($end_date)));
                        }

                        $post_url = T2T_Toolkit::get_post_meta($post->ID, 'service_external_url', true, get_permalink($post->ID));

                        // add this time to the events hash
                        array_push($schedule_times, array_merge($options, array(
                        	"id"      => T2T_Service::get_name() . "_" . $post->ID,
                        	"title"   => $post->post_title,
                        	"start"   => $start_date,
                        	"end"     => $end_date,
                        	"allDay"  => false,
                        	"color"   => $color,
                        	"url"     => $post_url
                        )));
            		}
            	}
            }

            // return the collected times as an array
            return $schedule_times;
        }

        /**
         * determine_min_time
         *
         * @since 2.0.0
         *
         * @param array $events All events to appear on the calendar
         *
         * @return the minimum time as a string to display on the schedule.
         */
        public function determine_min_time($events) {
            // sort by start time, placing the earliest event first
            usort($events, array("T2T_Shortcode_Schedule", "compare_start_times"));

            $minimum_time = strtotime($events[0]["start"]);

            // determine the default min time with a bit of cushion
            if(intval(date("i", $minimum_time)) > 0) {
                return date("H:00", $minimum_time);
            }
            else {
            	if(intval(date("H", $minimum_time)) > 0) {
                	return date("H:00", strtotime("-1 hour", $minimum_time));
            	}
            	else {
                	return date("H:00", $minimum_time);
            	}
            }
        }

        /**
         * determine_max_time
         *
         * @since 2.0.0
         *
         * @param array $events All events to appear on the calendar
         *
         * @return the maximum time as a string to display on the schedule.
         */
        public function determine_max_time($events) {
            // sort by end time, placing the latest event first
            usort($events, array("T2T_Shortcode_Schedule", "compare_end_times"));

            // determine the default max time with a bit of cushion
            $maximum_time = strtotime($events[0]["end"]);

            // always round up to the next hour
            $hours = intval(date("H", $maximum_time)) + 1;

            // return the new formatted time
            return "$hours:00";
        }

        /**
         * compare_start_times
         *
         * @since 2.0.0
         *
         * @param string $a Value to compare to $b
         * @param string $b Value to compare to $a
         *
         * @return < 0 if $a is less than $b; > 0 if $a is greater than $b, and 0 if they are equal.
         */
        public static function compare_start_times($a, $b) {
            return strcmp(date("H:i", strtotime($a["start"])), date("H:i", strtotime($b["start"])));
        }

        /**
         * compare_end_times
         *
         * @since 2.0.0
         *
         * @param string $a Value to compare to $b
         * @param string $b Value to compare to $a
         *
         * @return < 0 if $a is less than $b; > 0 if $a is greater than $b, and 0 if they are equal.
         */
        public static function compare_end_times($a, $b) {
            return strcmp(date("H:i", strtotime($b["end"])), date("H:i", strtotime($a["end"])));
        }
	}
}
?>