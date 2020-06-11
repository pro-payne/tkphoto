<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        loggedIn();
    }

    /**
     * Calls the Dashboard Function
     */
    public function index()
    {
        redirect('admin/dashboard');
    }

    public function dashboard()
    {
        $getEnquiries = $this->db->query("SELECT * FROM enquiries ORDER BY created_at DESC")->result();
        $enquiries = [];
        if(!empty($getEnquiries)){
            foreach($getEnquiries as $enquiry){
                $enquiries[] = [
                    'subject' => $enquiry->subject,
                    'sender' => [
                        'name' => $enquiry->name,
                        'email' => $enquiry->email
                    ],
                    'message' => $enquiry->message
                ];
            }
        }

        $data = [
            'enquiries' => $enquiries
        ];
        $this->load->view('admin/dashboard', $data);
    }
}
