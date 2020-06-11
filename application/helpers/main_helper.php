<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('gallery_dates')) {

    function gallery_dates()
    {

        $CI = &get_instance();
        $gallery = $CI->User_model->find_all("gallery");
        if (empty($gallery)) {
            return [];
        }
        $dates = [];
        foreach ($gallery as $image) {
            $url = $image->image_url;
            $explode_url = explode('__', $url);

            if (!isset($explode_url[1])) {
                continue;
            }
            $get_year = explode('-', unix_to_human($explode_url[1], true, 'rsa'));
            $year = (int) $get_year[0];
            $dates[$year] = $year;
        }

        krsort($dates);
        return $dates;
    }
}

if (!function_exists('current_date')) {
    /**
     * Current date based on timezone
     *
     * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
     *
     * @param   string  format: us or euro
     * @return  human readable timestamp
     */
    function current_date($fmt = '')
    {
        return unix_to_human(now(), true, $fmt);
    }
}

if (!function_exists('to_nice_date')) {
    /**
     * Format timestamp into presentable dates
     *
     * @param Timestamp
     * @param $include_time, bool - whether to return only the date
     * @param Difference, bool - calculate the difference between days
     * @param Amp, bool
     *
     * @return human readable date
     */
    function to_nice_date($timestamp, $include_time = true, $difference = true, $amp = false)
    {
        if ($timestamp == '') {
            return '';
        }
        $separate = explode(' ', $timestamp);
        $date = $separate[0];
        $time = $separate[1];
        $separate_time = explode(':', $time);
        $hour = $separate_time[0];
        $minute = $separate_time[1];
        $seconds = $separate_time[2];
        $mn = 'am';
        if ($hour >= '12') {
            $mn = 'pm';
        }
        if ($amp) {
            $minute = $minute . $mn;
        }
        $separate_date = explode('-', $date);
        $year = $separate_date[0];
        $get_month = $separate_date[1];
        $day = $separate_date[2];
        $current_year = date('Y');
        $month = '';
        switch ($get_month) {
            case '01':
                $month = 'Jan';
                break;
            case '02':
                $month = 'Feb';
                break;
            case '03':
                $month = 'Mar';
                break;
            case '04':
                $month = 'Apr';
                break;
            case '05':
                $month = 'May';
                break;
            case '06':
                $month = 'Jun';
                break;
            case '07':
                $month = 'Jul';
                break;
            case '08':
                $month = 'Aug';
                break;
            case '09':
                $month = 'Sep';
                break;
            case '10':
                $month = 'Oct';
                break;
            case '11':
                $month = 'Nov';
                break;
            case '12':
                $month = 'Dec';
                break;
        }
        // Find the difference between the years
        $diff = $current_year - $year;
        $date_results = '';
        if ($difference) {
            if ($diff >= 1) {
                $short_year = substr($year, 2);
                if ($include_time) {
                    $date_results = $day . '/' . $get_month . '/' . $short_year . ', ' . $hour . ':' . $minute;
                } else {
                    $date_results = $day . '/' . $get_month . '/' . $short_year;
                }
            } else {
                $current = explode(' ', current_date());
                $dates = 0;
                $old_date = new DateTime($date);
                $current = new DateTime($current[0]);
                $difference = $current->diff($old_date);
                $dates = $difference->days;
                $number_of_days = $dates;
                if ($number_of_days === 0) {
                    $date_results = $hour . ':' . $minute;
                } elseif ($number_of_days === 1) {
                    $date_results = 'yesterday ' . $hour . ':' . $minute;
                } elseif ($number_of_days >= 2) {
                    if ($include_time) {
                        $date_results = $day . ' ' . $month . ', ' . $hour . ':' . $minute;
                    } else {
                        $date_results = $day . ' ' . $month;
                    }
                }
            }
        } else {
            if ($diff >= 1) {
                $short_year = substr($year, 2);
                if ($include_time) {
                    $date_results = $day . '/' . $get_month . '/' . $short_year . ', ' . $hour . ':' . $minute;
                } else {
                    $date_results = $day . '/' . $get_month . '/' . $short_year;
                }
            } else {
                if ($include_time) {
                    $date_results = $day . ' ' . $month . ', ' . $hour . ':' . $minute;
                } else {
                    $date_results = $day . ' ' . $month;
                }
            }
        }

        return $date_results;

    }
}