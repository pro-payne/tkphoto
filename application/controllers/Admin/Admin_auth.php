<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();        
    }

    public function index()
    {
        redirect('admin/login');
    }

    public function login_page()
    {
        loggedIn(true);
        $this->load->view('admin/auth/admin_login');
    }

    function _register_page()
    {
        loggedIn(true);
        $this->load->view('admin/auth/admin_register');
    }

    public function login()
    {
        $throw = function(){
            echo json_encode(['success' => false, 'error' => 'Email/Password is incorrect']);
        };
        $post_data = $this->input->post();
        $email = (isset($post_data['email'])) ? strtolower(trim($post_data['email'])) : '';
        $password = (isset($post_data['password'])) ? strtolower(trim($post_data['password'])) : '';

        if ($email == '' || $password == '') {
            echo json_encode(['success' => false, 'error' => 'Fill in all required fields']);
            return false;
        }

        $check_account = $this->User_model->select('admin_profile', ['email' => $email]);
        if (empty($check_account)) {
            $throw();
            return false;
        }

        $user_account = $check_account[0];        
        if(!password_verify($password, $user_account->password)){
            $throw();
            return false;
        }

        $_SESSION['ID'] = (int) $user_account->id;
        
        echo json_encode(['success'=> true]);
    }

    function _register()
    {
        if(!$this->input->is_ajax_request()){
            redirect('admin/register');
        }
        $post_data = $this->input->post();
        $email = (isset($post_data['email'])) ? strtolower(trim($post_data['email'])) : '';
        $password = (isset($post_data['password'])) ? strtolower(trim($post_data['password'])) : '';
        $firstname = (isset($post_data['firstname'])) ? strtolower(trim($post_data['firstname'])) : '';
        $lastname = (isset($post_data['lastname'])) ? strtolower(trim($post_data['lastname'])) : '';

        $continue = false;
        if ($email != '' && $password != '' && $lastname != '' && $firstname != '') {
            $continue = true;
        }else{
            echo json_encode(['success' => false, 'error' => 'Fill in all required fields']);
            return false;
        }

        // Check if email doesn't exist
        $check_email = $this->User_model->select('admin_profile', ['email' => $email]);
        if (!empty($check_email)) {
            echo json_encode(['success' => false, 'error' => 'Email address already in use']);
            return false;
        }

        $passwd = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'first_name' => $firstname,
            'last_name' => $lastname,
            'password' => $passwd,
            'email' => $email,
        ];

        $create = $this->User_model->submit('admin_profile', $data);
        if ($create) {
            echo json_encode(['success' => true]);
        }else{
            echo json_encode(['success' => false, 'error'=> 'Something went wrong, please reload page']);
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        redirect('admin/login');
    }

}
