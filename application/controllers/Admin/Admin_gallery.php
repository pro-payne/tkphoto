<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_gallery extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        loggedIn();
        
        $this->load->helper('main');
        $this->dates = gallery_dates();
    }

    /**
     * Calls the Gallery Function
     */
    public function index()
    {
        redirect('admin/gallery');
    }

    public function gallery()
    {
        $data = [
            'title' => "Gallery - Admin - TK Photography",
            'available_years' => $this->dates,
            'user' => 'admin',
        ];
        $this->load->view('admin/admin_gallery', $data);
    }

    public function gallery_upload(){

        $categories = $this->User_model->find_all('categories', 'name', 'ASC');
        $data = [
            'title' => "Gallery Upload - Admin - TK Photography",
            'categories' => $categories,
            'type' => 'admin',
        ];

        $this->load->view('admin/gallery_upload', $data);
    }
}
