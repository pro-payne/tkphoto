<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function index()
	{
		$slides = $this->db->query("SELECT * FROM slideshow ORDER BY created_at DESC")->result();	
		$images = [];
		if(!empty($slides)){
			foreach($slides as $slide){
				if(!file_exists('assets/img/slider/'.$slide->url)) continue;
				$images[] = base_url('assets/img/slider/'.$slide->url);
			}
		}

		if(empty($images)){
			$images[] = base_url('assets/img/slider/tkphotography.jpg');
		}

		$recent = $this->recentWorks();

		$data = [
			'slides' => $images,
			'recent' => $recent,
			'navBar' => 'home'
		];
		$this->load->view('index', $data);
	}

	private function recentWorks(){
		$works = $this->db->query("SELECT * FROM gallery ORDER BY created_at DESC")->result();
		$result = [];
		if(!empty($works)){
			$count = 0;
			foreach($works as $work){

				if($count == 9) break;

				if(!file_exists('assets/img/portfolio/'.$work->image_url)) continue;

				$url = $work->image_url;
				$explode_date = explode('__', $url);

	            if (!isset($explode_date[1])) continue;

	            $unix_date = $explode_date[1];
	            $to_date = unix_to_human($unix_date, true, 'rsa');
	            $temp_year = explode('-', $to_date);
	            $year = (int) $temp_year[0];
				$result[] = [
					'title'=> $work->image_title,
					'url' => $work->image_url,
					'link' => base_url('portfolio?category='.$explode_date[0].'&year='.$year)
				];
				$count++;
			}
		}
		return $result;
	}

	public function about()
	{
		$data = ['title' => "About", 'navBar' => 'about'];
		$this->load->view('about', $data);
	}

	public function contacts()
	{
		$data = ['title' => "Contacts", 'navBar' => 'contacts'];
		$this->load->view('contacts', $data);
	}
}
