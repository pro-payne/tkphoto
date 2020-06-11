<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slideshow_api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        loggedIn();
        $this->placeholder = 'assets/img/placeholder.png';
    }
    /**
     * Api for resource
     */
    public function index()
    {

    }

    private function validate_request($request)
    {

        $results = [];
        $trimmer = function ($data, $item) {
            $strlen = strlen(trim($data));
            $input_item = '';
            if ($strlen == 0) {
                $input_item = $item;
            }
            return $input_item;
        };

        if (empty($request)) {
            return [];
        }
        foreach ($request as $key => $request_item) {
            $value = $trimmer($request_item, $key);
            if ($value != '') {
                $results[] = $value;
            }
        }

        $result = [];
        if (sizeof($results) == 0) {
            $result = ['success' => true];
        } else {
            $result = ['success' => false, 'errors' => $results];
        }

        return $result;
    }

    private function validate_upload($file, $post_data, $change_file = 'true')
    {
        $file_info = [
            'file' => '',
            'name' => '',
            'success' => true,
        ];

        $upload_results = [];

        $_file = (isset($file['image'])) ? $file['image'] : [];

        if(empty($_file)){
            return array('success' => false, 'error' => 'no_selected_file');
        }
        $upload_results = $this->docUpload($_file);
        if (!$upload_results['success']) {
            return array('success' => false, 'error' => $upload_results['error']);
        }

        if (!empty($upload_results)) {
            $file_info['file'] = $upload_results['url'];
            $file_info['name'] = $upload_results['name'];
        }

        return $file_info;
    }

    private function docUpload($file)
    {
        $file_name = $file['name'];
        $explode_name = explode(".", $file_name);
        $file_name = $explode_name[0];
        $file_name_ext = strtolower($explode_name[1]);
        $type = 'image';
        $config['allowed_types'] = 'jpg|png|jpeg';

        $renamed_file = now() . '_' . md5($file_name);
        $url = 'assets/img/slider/';
        $config['upload_path'] = $url;
        $config['file_name'] = $renamed_file; // rename a file
        $this->load->library('upload', $config);

        $results = ['success' => false];
        $file_path = $renamed_file . '.' . $file_name_ext;

        $upload = function ($file_path, $type, $file_name) {
            $result = ['success' => false];
            if (!$this->upload->do_upload($type)) {
                $result['error'] = $this->upload->display_errors();
            } else {
                $result['success'] = true;
                $result['url'] = $file_path;
                $result['name'] = $file_name;
            }
            return $result;
        };
        if (file_exists($url.$file_path)) {
            if (!unlink($url.$file_path)) {
                $results['error'] = "cant_delete";
            } else {
                $results = $upload($file_path, $type, $file_name);
            }
        } else {
            $results = $upload($file_path, $type, $file_name);
        }

        return $results;
    }

    public function store()
    {
        $post_data = $this->input->post();
        $file = $_FILES;

        $validate_upload = $this->validate_upload($file, $post_data);
        if (!$validate_upload['success']) {
            echo json_encode([
                'success' => false,
                'error' => $validate_upload['error'],
            ]);
            return false;
        }

        $file_info = [
            'file' => (isset($validate_upload['file']) && $validate_upload['file'] != '') ? $validate_upload['file'] : $this->placeholder,
        ];

        $unlink = function($file){
            $results = '';
            if ($file != '' && $file != $this->placeholder) {
                if (!unlink($file)) {
                    $results = "cant_delete";
                }
            }
            return $results;
        };
        // Validate Request
        $request = $this->validate_request($post_data);
        if (!$request['success']) {
            $delete_on_error = $unlink($file_info['file']);
            if($delete_on_error != ''){
                $request['errors'][] = $delete_on_error;
            }
            echo json_encode(array('success' => false, 'errors' => $request['errors']));
            return false;
        }

        // Store slide
        $submit_data = [
            'title' => trim($post_data['title']),
            'url' => $file_info['file'],
        ];

        $store = $this->User_model->submit('slideshow', $submit_data);
        unset($submit_data);
        $success = false;
        if ($store) {
            $success = true;
        } else {
            $delete_on_error = $unlink($file_info['file']);
            if($delete_on_error != ''){
                $results['error'] = $delete_on_error;
            }
        }

        echo json_encode(array('success' => $success));
    }

    public function delete()
    {
        $delete_data = $this->input->post();
        $raw_data = (isset($delete_data['images']) && $delete_data['images'] != '') ? (array) json_decode($delete_data['images']) : [];

        if (empty($raw_data)) {
            echo json_encode(['success' => false, 'error' => 'no_selected_image']);
            return false;
        }

        $images = [];
        foreach ($raw_data as $value) {
            $extract = explode('_', $value->token);
            if(isset($extract[1])){
                $images[] = [
                    'token' => $value->token,
                    'id' => (int) $extract[1],
                ];
            }            
        }

        $deleted_images = [];
        foreach ($images as $image) {
            $delete_result = $this->delete_image($image['id']);
            if ($delete_result) {
                $deleted_images[] = ['token' => $image['token']];
            }
        }

        if (empty($deleted_images)) {
            echo json_encode(['success' => false, 'error' => 'no_deleted_image']);
            return false;
        }

        $result_msg = '';
        if (sizeof($images) > 0) {
            $result_msg = sizeof($deleted_images) . '/' . sizeof($images) . ' images';
        } else {
            $result_msg = sizeof($deleted_images) . '/1 image';
        }

        $results = ['success' => true, 'msg' => $result_msg . ' deleted', 'data' => $deleted_images];
        echo json_encode($results);

    }

    private function delete_image($id)
    {
        $get_file = $this->User_model->select('slideshow', ['id' => $id]);

        if (empty($get_file)) {
            return false;
        }

        $file = "assets/img/slider/" . $get_file[0]->url;

        if (file_exists($file)) {
            if (!unlink($file)) {
                return false;
            }
        }

        $result = false;
        $delete = $this->User_model->delete('slideshow', ['id' => $id]);
        if ($delete) {
            $result = true;
        }

        return $result;

    }
}
