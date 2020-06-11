<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_slideshow extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('main');
        loggedIn();
    }
    
    /**
     * Calls the Events Function
     */

    public function index()
    {
        $title = "SlideShow - TK Photography";

        $data = [
                'title' => $title,
                'user' => 'admin'
            ];
        $this->load->view('admin/slideshow', $data);
    }

    public function show()
    {
        $collections = [];

        $slideshows = $this->User_model->find_all('slideshow', 'created_at', 'DESC');
        if(empty($slideshows)){
            echo json_encode(['success' => false, 'error' => 'empty_slideshow']);
            return false;
        }

        foreach ($slideshows as $slideshow) {
            $collections[] = array(
                        'id' => $slideshow->id,
                        'title' => $slideshow->title,
                        'url'=> base_url($slideshow->url),
                        'date' => to_nice_date($slideshow->created_at),
                    );
        }
        // Get Images
        $slides = $this->load_images();

        if (!empty($slides)) {
            echo json_encode(['success' => true, 'data' => $slides]);
        } else {
            echo json_encode(['success' => false, 'error' => 'empty_slideshow']);
        }
    }

    private function load_images()
    {
        $images = array();

        $image_data = [];
        $fetch_images = $slideshows = $this->User_model->find_all('slideshow', 'created_at', 'DESC');

        if (!empty($fetch_images)) {
            foreach ($fetch_images as $fetch_image) {
                $image_data[] = [
                    'id' => $fetch_image->id,
                    'url' => $fetch_image->url,
                    'title' => $fetch_image->title,
                    'descrip'=> ''
                ];
            }
        }

        if (empty($image_data)) {
            return [];
        }

        $get_property = function ($image) {
            $path = 'assets/img/slider/' .$image['url'];

            if(!file_exists($path)) return [];
            
            $data = [];
            $explode_date = explode('_', $image['url']);
            $unix_date = $explode_date[0];
            $to_date = unix_to_human($unix_date, true, 'rsa');
            $temp_year = explode('-', $to_date);
            $year = (int) $temp_year[0];
            $data = [
                'id' => $image['id'],
                'title' => $image['title'],
                'url' => base_url($path),
                'descrip'=> $image['descrip'],
                'date' => $to_date,
                'year' => $year,
                'unix_date' => $unix_date,
            ];

            return $data;
        };

        $image_info = [];
        foreach ($image_data as $image) {
            $info = $get_property($image);
            if (!empty($info)) {
                $image_info[] = $info;
            }
        }

        if (empty($image_info)) {
            return [];
        }

        // Arrange Images

        $arranged_images = $this->arrange_images($image_info);

        return $arranged_images;
    }

    private function arrange_images($images)
    {
        if (empty($images)) {
            return [];
        }

        // Sorting Desc
        $temp_info = [];
        foreach ($images as $key => $sort_image) {
            $temp_info[$key] = $sort_image['unix_date'];
        }

        array_multisort($temp_info, SORT_DESC, $images);

        // Separate by year
        $separate_year = [];
        foreach ($images as $image) {
            $separate_year[$image['year']][] = [
                'id' => $image['id'],
                'title' => $image['title'],
                'descrip'=> $image['descrip'],
                'url' => $image['url'],
                'date' => $image['date'],
            ];
        }

        $clean_data = [];
        foreach ($separate_year as $key => $fix_data) {
            $clean_data[] = [
                'year' => $key,
                'data' => $fix_data,
            ];
        }

        return $clean_data;
    }

    public function manage_slideshow()
    {

        $action = strtolower($this->uri->segment(3));
        $title = '';

        $edit_data = [];
        $action_type = '';
        if ($action == "new") {
            $title = "New Slide";
            $action_type = $title;
        } else {
            redirect('admin/slideshow');
        }       

        $data = [
            'title' => $title . " - TK Photography",
            'action_type' => $action_type
        ];
        $this->load->view('admin/manage_slideshow', $data);
    }

}
