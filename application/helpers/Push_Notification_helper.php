<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*
	if(!function_exists('sendNotification')){
		function sendNotification($user_id, $title, $body){
			$user_token = get_fcm_token($user_id);
			$SERVER_API_KEY = "AAAA_jgR8ok:APA91bFKkw1dqWcRUNSQxrrASSDRU2XqbZEY7ynEWNgv7N3d-HlvQXbEvHOkY7rO8y-_OJSPCG6vljvmdVeklDtAUB_laBvJHL1qrTqW9FQ6cFv6yYiq-JYxii5NNkCuepvYC9BMIWY8";
			
			$array = [];
			for($i = 0 ; $i < count($user_token) ; $i++){
				$array[$i] = $user_token[$i]->token;
			} 
			$data = [
				"registration_ids" => $array,
				"notification" => [
					"title" => $title,
					"body" => $body,
					'icon'	=> site_url().'assets/images/logo/logo.png', 
					'sound' => 'mySound'
				]
			];
			$dataString = json_encode($data);
		
			$headers = [
				'Authorization: key=' . $SERVER_API_KEY,
				'Content-Type: application/json',
			];
		
			$ch = curl_init();
		  
			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
				   
			$response = curl_exec($ch);
			return $response;
		}
    }
	*/
	if(!function_exists('sendNotificationAdmin')){
		function sendNotificationAdmin($title, $body){
			$ci=& get_instance();
			$ci->load->database();
			$user_token = $ci->db->get("users")->result();
			$SERVER_API_KEY = "AAAA_jgR8ok:APA91bFKkw1dqWcRUNSQxrrASSDRU2XqbZEY7ynEWNgv7N3d-HlvQXbEvHOkY7rO8y-_OJSPCG6vljvmdVeklDtAUB_laBvJHL1qrTqW9FQ6cFv6yYiq-JYxii5NNkCuepvYC9BMIWY8";
			
			$array = [];
			for($i = 0 ; $i < count($user_token) ; $i++){
				$array[$i] = $user_token[$i]->fcm_token;
			} 
			$data = [
				"registration_ids" => $array,
				"notification" => [
					"title" => $title,
					"body" => $body,
					'icon'	=> site_url().'assets/images/logo/logo.png',/*Default Icon*/
					'sound' => 'mySound'/*Default sound*/
				]
			];
			$dataString = json_encode($data);
		
			$headers = [
				'Authorization: key=' . $SERVER_API_KEY,
				'Content-Type: application/json',
			];
		
			$ch = curl_init();
		  
			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
				   
			$response = curl_exec($ch);
			return $response;
		}
    }
	
	/*-----------------------------------------------
	
		sendNotificationStudent
		
	-----------------------------------------------*/
	 
	function get_fcm_token($user_id){ 
		$ci=& get_instance();
		$ci->load->database();
		
		return $ci->db->where("user_id = $user_id")->get("device")->result();
	}

	if(!function_exists('SendEmail')){
		function SendEmail($options = array()){

			//get SMTP Details
			$CI =& get_instance();
			
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'alaa.krunb@gmail.com', // change it to yours
				'smtp_pass' => 'alaa@411918139', // change it to yours
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => TRUE
			); 
			
			$CI->load->library('email', $config);
			//$CI->email->initialize();
			//$CI->email->set_header('Content-Type', 'text/html');
			$CI->email->set_newline("\r\n");
			$CI->email->set_mailtype("html");
			$CI->email->from("info@krunb4it.com", $options["subject"]);
			$CI->email->to($options["to"]);
			$CI->email->subject('ExtaCards | '.$options["subject"]);
			$CI->email->message($options["message"]); 
			if($CI->email->send()) {
				return true;
			} else {
				return show_error($CI->email->print_debugger());
			}
			/*
		    $e = $CI->email->send();
            $CI->email->clear(TRUE);
            return $e;
			*/
		}
	}

	if(!function_exists('sendAlert')){
		function sendAlert($title, $body){
			$CI =& get_instance(); 
			$CI->db
				->set('alert_from', $CI->session->userdata("user_id"))
				->set('alert_title', $title)
				->set('alert_info', $body)
				->insert("user_alert");
		}
	}