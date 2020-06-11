<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('loggedIn')) {

    function loggedIn($check = false){
        $loggedIn = false;
        if(isset($_SESSION['ID'])){
            $loggedIn = true;
        }
        $CI = &get_instance();

        if($CI->input->is_ajax_request() && !$loggedIn && $check){
            exit(json_encode(['success'=> false, 'error'=> 'not_authenticated']));
        }

        if(!$loggedIn && !$check) redirect('admin/login');
        
        if($check && $loggedIn) redirect('admin/dashboard');
    }
}