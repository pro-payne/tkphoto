<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gallery_api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        loggedIn();
    }

    /**
     * Api for gallery
     */

    public function store()
    {
        $post_data = $this->input->post();
        $files = $_FILES;
        if (empty($files)) {
            echo json_encode(['success' => false, 'error' => 'no_files']);
            return false;
        }

        $category = trim($post_data['category']);
        $category_id = 0;
        $category_codename = '';
        $checkCategory = $this->User_model->select('categories', ['id' => $category]);
        if (!empty($checkCategory)) {
            $category_id = (int)$checkCategory[0]->id;
            $category_codename = $checkCategory[0]->codename;
        }

        if ($category_id == 0) {
            echo json_encode(['success' => false, 'error' => 'invalid_category']);
            return false;
        }
        $post_data['category'] = $category_codename;
        $uploads = $this->processImages($files, $post_data);

        $uploadCount = [
            'success' => 0,
            'fail' => 0,
        ];
        $submitData = [
            'category_id' => $category_id,
            'image_title' => $post_data['title']
        ];
        $results = ['success' => false];
        foreach ($uploads as $upload) {
            if ($upload['success']) {
                $submitData['image_url'] = $upload['url'];
                $submit = $this->User_model->submit('gallery', $submitData);
                if ($submit) {
                    $results['success'] = true;
                    $uploadCount['success']++;
                } else {
                    unlink($upload['url']);
                    $results['error'] = 'unable_to_submit';
                }
            } else {

                if (!empty($upload['error'])) {
                    $uploadCount['errors'][] = $upload['error'];
                }

                $uploadCount['fail']++;
            }
        }

        $results['results'] = $uploadCount;

        echo json_encode($results);

    }

    private function processImages($files, $extraData)
    {
        $verified = [];
        $this->load->library('upload');
        foreach ($files as $fileName => $file) {
            $verified[] = $this->upload($fileName, $extraData, $file);
        }
        return $verified;
    }

    private function upload($name, $extraData, $file)
    {
        $file_name = $file['name'];
        $explode_name = explode(".", $file_name);
        $file_name = $explode_name[0];
        $file_name_ext = strtolower(end($explode_name));
        $date = now();
        if ($extraData['date_taken'] != '') {
            $date_taken = $extraData['date_taken'];
            $date = unix_to_human($date, true, 'rsa');
            $explode = explode(' ', $date);
            $raw_time = $explode[1];

            $raw_date = explode('/', $date_taken);
            $fix_date = $raw_date[2] . '-' . $raw_date[1] . '-' . $raw_date[0];
            $date = human_to_unix($fix_date . ' ' . $raw_time);
        }

        $renamed_file = strtolower($extraData['category']) . '__' . $date . '__' . md5($name . $file_name . now());
        $url = './assets/img/portfolio/';

        $config = [];
        $config[$name]['allowed_types'] = 'jpg|png|jpeg';
        $config[$name]['upload_path'] = $url;
        $config[$name]['file_ext_tolower'] = true;
        $config[$name]['file_name'] = $renamed_file; // rename a file

        $this->upload->initialize($config[$name], true);

        $results = ['success' => false];
        $file_path = $url . $renamed_file . '.' . $file_name_ext;

        $upload = false;
        if (file_exists($file_path)) {
            if (!unlink($file_path)) {
                $results['error'] = "cant_delete";
            } else {
                $upload = true;
            }
        } else {
            $upload = true;
        }

        if ($upload) {
            if (!$this->upload->do_upload($name)) {
                $results['error'] = $this->upload->display_errors();
            } else {
                $results['success'] = true;
                $results['url'] = $renamed_file . '.' . $file_name_ext;
            }
        }

        return $results;
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
        $get_file = $this->User_model->select('gallery', ['id' => $id]);

        if (empty($get_file)) {
            return false;
        }

        $file = "assets/img/portfolio/" . $get_file[0]->image_url;

        if (file_exists($file)) {
            if (!unlink($file)) {
                return false;
            }
        }

        $result = false;
        $delete = $this->User_model->delete('gallery', ['id' => $id]);
        if ($delete) {
            $result = true;
        }

        return $result;

    }
}
