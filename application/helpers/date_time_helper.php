<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Returns a unix timestamp as date only - without hours, minutes and seconds. 
// Used for comparing existing dates with now(). 

function unix_timestamp_to_unix_timestamp_without_time($unix_timestamp) {
	$unix_to_human_timestamp = unix_to_human($unix_timestamp);
	$human_time_stamp_as_datetime = new DateTime($unix_to_human_timestamp);
	$human_time_stamp_as_datetime_formatted_without_time = date_format($human_time_stamp_as_datetime, 'Y-m-d');
	$human_time_as_datetime_without_time = new DateTime($human_time_stamp_as_datetime_formatted_without_time);
	$human_time_as_datetime_without_time_formatted = date_format($human_time_as_datetime_without_time, 'Y-m-d h:i:s A');
	$unix_timestamp_without_time = human_to_unix($human_time_as_datetime_without_time_formatted);
	return $unix_timestamp_without_time;
}