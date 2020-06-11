<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->helper('main');
    }


	public function index()
	{
		$data = [
			'title' => "Portfolio",
            'navBar' => 'portfolio'
		];
        
		$this->load->view('portfolio', $data);
	}

	public function show()
    {
        $get_data = $this->input->get();
        $category = (isset($get_data['category']) && trim($get_data['category']) != '') ? strtolower(trim($get_data['category'])) : 'all';
        $year = (isset($get_data['year']) && trim($get_data['year']) != '') ? strtolower(trim($get_data['year'])) : 'all';

        // Get Images
        $images = $this->load_images(['category' => $category, 'year' => $year]);

        if (!empty($images)) {
            echo json_encode(['success' => true, 'data' => $images]);
        } else {
            echo json_encode(['success' => false, 'error' => 'empty_gallery']);
        }
    }

    private function load_images($input)
    {
        $images = array();

        // Using category filter
        $category = $input['category'];
        $category_id = 0;
        $code_name = '';
        if ($category != 'all') {
            $filter_categories = $this->User_model->select('categories', ['codename' => $category]);
            if (!empty($filter_categories)) {
                $category_id = (int) $filter_categories[0]->id;
            }
        }

        $image_data = [];
        $fetch_images = ($category_id == 0) ? $this->User_model->find_all('gallery') : $this->User_model->select('gallery', ['category_id' => $category_id]);
        if (!empty($fetch_images)) {
            foreach ($fetch_images as $fetch_image) {
                $image_data[] = [
                    'id' => $fetch_image->id,
                    'url' => $fetch_image->image_url,
                    'title' => $fetch_image->image_title,
                    'descrip'=> ''
                ];
            }
        }

        if (empty($image_data)) {
            return [];
        }

        $get_property = function ($image) {
            $path = 'assets/img/portfolio/' . $image['url'];

            if(!file_exists($path)) return [];
            
            $data = [];
            $explode_date = explode('__', $image['url']);
            if (!isset($explode_date[1])) {
                return [];
            }
            $unix_date = $explode_date[1];
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

        // Filter by year
        $filter_year = $input['year'];
        $clean_data = [];
        if ($filter_year != 'all') {
            $filter_year = (int) $filter_year;
            foreach ($image_info as $filter_image_info) {
                if ($filter_image_info['year'] == $filter_year) {
                    $clean_data[] = $filter_image_info;
                }
            }
        } else {
            $clean_data = $image_info;
        }

        // Arrange Images

        $arranged_images = $this->arrange_images($clean_data);

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

}
