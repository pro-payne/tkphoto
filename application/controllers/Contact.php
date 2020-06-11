<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	private function validateEmail($value)
	{
		$regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';

		if($value == '') { 
			return false;
		} else {
			$string = preg_replace($regex, '', $value);
		}

		return empty($string) ? true : false;
	}

	public function send(){
		$post = $this->input->post();
		
		if(empty($post)){
			echo json_encode(['success'=> false, 'error'=> ['empty']]);
			return false;
		}

		$name = stripslashes($post['name']);
		$email = strtolower(trim($post['email']));
		$subject = stripslashes($post['subject']);
		$message = stripslashes($post['message']);

		$error = [];

		// Check name

		if($name == ""){
			$error[] = 'Please enter your name';
		}

		// Check email

		if($email == ""){
			$error[] = 'Please enter an e-mail address';
		}

		if($email && !$this->validateEmail($email)){
			$error[] = 'Please enter a valid e-mail address';
		}

		// Check message (length)

		if(!$message || strlen($message) < 10){
			$error[] = "Please enter your message. It should have at least 10 characters";
		}

		if(!empty($error)){
			echo json_encode([
				'success' => false,
				'error' => $error
			]);
			return false;
		}

		// Save to Database

		$enquiry = [
			'name' => $name,
			'email' => $email,
			'message' => $message,
			'subject' => $subject
		];

		$save = $this->User_model->submit('enquiries', $enquiry);
		$saved = false;
		if($save){
			$saved = true;
		}

		echo json_encode(['success'=> $saved]);
		
	}
}
