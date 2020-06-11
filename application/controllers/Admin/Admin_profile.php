<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        loggedIn();
    }

    /**
     * Calls the Profile Function
     */
    public function index()
    {

    }

    public function profile()
    {
        $id = $_SESSION['ID'];
        $get_profile = $this->User_model->select('admin_profile', ['id' => $id]);
        $profile = [];
        if (!empty($get_profile)) {
            $get_profile = $get_profile[0];
            $profile = [
                'fname' => $get_profile->first_name,
                'lname' => $get_profile->last_name,
                'email' => $get_profile->email,
            ];
        }
        $data = [
            'title' => "Profile - Admin - IDAM",
            'profile' => $profile,
        ];
        $this->load->view('admin/admin_profile', $data);
    }

    public function update()
    {
        $post_data = $this->input->post();
        $id = $_SESSION['ID'];

        $email = (isset($post_data['email'])) ? strtolower(trim($post_data['email'])) : '';
        $firstname = (isset($post_data['firstname'])) ? strtolower(trim($post_data['firstname'])) : '';
        $lastname = (isset($post_data['lastname'])) ? strtolower(trim($post_data['lastname'])) : '';

        $continue = false;
        if ($email != '' && $lastname != '' && $firstname != '') {
            $continue = true;
        } else {
            echo json_encode(['success' => false, 'error' => 'Fill in all required fields']);
            return false;
        }

        $profile = [
            'first_name' => $post_data['firstname'],
            'last_name' => $post_data['lastname'],
            'email' => $post_data['email'],
        ];
        $update = $this->User_model->update('admin_profile', $profile, ['id' => $id]);
        if($update){
            echo json_encode(['success'=> true]);
        }else{
            echo json_encode(['success'=> false]);
        }
    }

}
