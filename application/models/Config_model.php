<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	/* setting */
	function get_setting(){
		return $this->db->get_where("config","config_id = 1")->row();
	}
	
	/* language */
	function get_language(){
		return $this->db->get("language")->result();
	}
	
	/* users */
	function get_users(){
		return $this->db
		->join("admin_group","admin_group.admin_group_id = users.group_id","left")
		->get("users")->result();
	}
	function get_user_id($user_id){
		return $this->db->where("user_id", $user_id)->get("users")->row();
	}
	
	/* page */
	function get_page(){
		return $this->db->order_by("page_order", "ASC")->get("page")->result();
	}
	function get_page_id($page_id){
		return $this->db->where("page_id", $page_id)->get("page")->row();
	}

	/* slider */
	function get_slider(){
		return $this->db->order_by("slider_order", "ASC")->get("slider")->result();
	}
	function get_slider_id($slider_id){
		return $this->db->where("slider_id", $slider_id)->get("slider")->row();
	}
	
	/* currency */
	function get_currency(){
		return $this->db->get("currency")->result();
	}
	function get_currency_id($currency_id){
		return $this->db->where("currency_id", $currency_id)->get("currency")->row();
	}
	
	/*  payment way */
	function get_payment_way(){
		return $this->db->order_by("payment_way_order", "ASC")->get("payment_way")->result();
	}
	function get_payment_way_id($payment_way_id){
		return $this->db->where("payment_way_id", $payment_way_id)->get("payment_way")->row();
	}
	
	/* activites */
	function get_activites(){
		return $this->db->get("activites")->result();
	}
	
	/* Group */
	function get_admin_group(){
		return $this->db->get("admin_group")->result();
	}
	
	/* course */
	function get_course(){
		return $this->db->order_by("course_order", "ASC")->get("course")->result();
	}
	function get_course_id($course_id){
		return $this->db->where("course_id", $course_id)->get("course")->row();
	}
	
	/* --------------------------------------------------------- */
	
	function update_setting($post){
		$arr = array(
			"website_name" 			=> json_encode($post["website_name"]),
			"website_description" 	=> json_encode($post["website_description"]),
			"website_keyword" 		=> json_encode($post["website_keyword"]),
			"website_google_code"	=> $post["website_google_code"],
			"app_ios_link"			=> $post["app_ios_link"],
			"app_andorid_link" 		=> $post["app_andorid_link"]
		); 
		return $this->db->where("config_id", 1)->update("config", $arr);
	}
	
	function update_contact($post){
		$arr = array( 
			"email"		=> $post["email"],
			"jawwal"	=> $post["jawwal"],
			"phone"		=> $post["phone"]
		); 
		return $this->db->where("config_id", 1)->update("config", $arr);
	}
	
	function update_social_media($post){
		$arr = array( 
			"facebook_link"		=> $post["facebook_link"],
			"twitter_link"		=> $post["twitter_link"],
			"instagram_link"	=> $post["instagram_link"],
			"youtube_link"		=> $post["youtube_link"],
			"whatsapp_link"		=> $post["whatsapp_link"]
		); 
		return $this->db->where("config_id", 1)->update("config", $arr);
	}
	
	function update_language($lang_active, $lang_id){
		return $this->db->set("lang_active", $lang_active)->where("lang_id", $lang_id)->update("language");
	}
	
	function update_page($post, $page_cover){
		$arr = array(
			"page_cover"		=> $page_cover,
			"page_title"		=> json_encode($post["page_title"]),
			"page_sub_title"	=> json_encode($post["page_sub_title"]),
			"page_details"		=> json_encode($post["page_details"]),
			"page_tags"			=> json_encode($post["page_tags"]),
			"page_update_by"	=> $this->session->userdata("user_id")
		); 
		return $this->db->where("page_id", $post["page_id"])->update("page", $arr);
	}
	
	function update_page_status($page_active, $page_id){
		return $this->db->set("page_active", $page_active)->where("page_id", $page_id)->update("page");
	}
	
	/*
		slider
	*/
	
	function add_slider($post, $slider_cover){
		$arr = array(
			"slider_cover"		=> $slider_cover,
			"slider_title"		=> json_encode($post["slider_title"]),
			"slider_sub_title"	=> json_encode($post["slider_sub_title"]),
			"slider_details"	=> json_encode($post["slider_details"]),
			"slider_tags"		=> json_encode($post["slider_tags"]),
			"slider_add_by"		=> $this->session->userdata("user_id"),
			"slider_link"		=> $post["slider_link"],
		); 
		return $this->db->insert("slider", $arr);
	}
	
	function update_slider($post, $slider_cover){
		
		$arr = array(
			"slider_cover"		=> $slider_cover,
			"slider_title"		=> json_encode($post["slider_title"]),
			"slider_sub_title"	=> json_encode($post["slider_sub_title"]),
			"slider_details"	=> json_encode($post["slider_details"]),
			"slider_tags"		=> json_encode($post["slider_tags"]), 
			"slider_update_by"	=> $this->session->userdata("user_id"),
			"slider_link"		=> $post["slider_link"],
		); 
		return $this->db->where("slider_id", $post["slider_id"])->update("slider", $arr);
	}
	
	function update_slider_status($slider_active, $slider_id){
		return $this->db->set("slider_active", $slider_active)->where("slider_id", $slider_id)->update("slider");
	}
	function remove_slider_id($slider_id){
		return $this->db->where("slider_id", $slider_id)->delete("slider");
	} 
	
	/*
		payment_way
	*/
	
	function add_payment_way($post, $payment_way_pic){
		$arr = array(
			"payment_way_pic"		=> $payment_way_pic,
			"payment_way_name"		=> json_encode($post["payment_way_name"]),
			"payment_way_details"	=> json_encode($post["payment_way_details"]),
			"payment_way_create_at"	=> $this->session->userdata("user_id")
		); 
		return $this->db->insert("payment_way", $arr);
	}
	
	function update_payment_way($post, $payment_way_pic){
		$arr = array(
			"payment_way_pic"		=> $payment_way_pic,
			"payment_way_name"		=> json_encode($post["payment_way_name"]),
			"payment_way_details"	=> json_encode($post["payment_way_details"]),
			"payment_way_update_by"	=> $this->session->userdata("user_id")
		); 
		return $this->db->where("payment_way_id", $post["payment_way_id"])->update("payment_way", $arr);
	}
	
	function update_payment_way_status($payment_way_active, $payment_way_id){
		return $this->db->set("payment_way_active", $payment_way_active)->where("payment_way_id", $payment_way_id)->update("payment_way");
	}
	function remove_payment_way_id($payment_way_id){
		return $this->db->where("payment_way_id", $payment_way_id)->delete("payment_way");
	}
	
	/*
		Users
	*/
	
	function add_user($post, $user_pic){
		$arr = array(
			"user_pic"      => $user_pic,
			"user_name"		=> $post["user_name"],
			"email"         => $post["email"],
			"jawwal"        => $post["jawwal"],
			"password"		=> $this->bcrypt->hash_password($post['password']),
			"group_id"		=> $post["group_id"],
			"user_status"   => 0, 
		); 
		return $this->db->insert("users", $arr);
	}
	
	function update_user($post, $user_pic){
		$arr = array(
			"user_pic"      => $user_pic,
			"user_name"		=> $post["user_name"],
			"email"         => $post["email"],
			"jawwal"        => $post["jawwal"],
			"group_id"		=> $post["group_id"]
		); 
		return $this->db->where("user_id", $post["user_id"])->update("users", $arr);
	}
	function update_user_status($user_active, $user_id){
		return $this->db->set("user_status", $user_active)->where("user_id", $user_id)->update("users");
	}
	function remove_user_id($user_id){
		return $this->db->where("user_id", $user_id)->delete("users");
	}
	
	/*
		Profile ..
	*/
	function update_profile($post, $user_pic){
		$arr = array(
			"user_pic"	=> $user_pic,
			"email"		=> $post["email"],
			"jawwal"	=> $post["jawwal"]
		); 
		return $this->db->where("user_id", $this->session->userdata("user_id"))->update("users", $arr);
	}
	
	function update_password($post){
		$arr = array(
			"password"	=> $this->bcrypt->hash_password($post['password_new'])
		); 
		return $this->db->where("user_id", $this->session->userdata("user_id"))->update("users", $arr);
	}
	function update_token($user_id, $token= null, $fcm_token){
		if($token == null){
			$token = openssl_random_pseudo_bytes(16); 
			$token = bin2hex($token);
		}
		$arr = array(
			"token"		=> $token,
			"fcm_token" => $fcm_token
		); 
		$res = $this->db->where("user_id", $user_id)->update("users", $arr);
		if($res != false){
			return $token;
		}
	}
	function inactive_user($user_id){
		$arr = array(
			"user_status"	=> 0
		); 
		return $this->db->where("user_id", $user_id)->update("users", $arr);
	}


	
	function add_currency($post){
		$arr = array( 
			"currency_name"    => json_encode($post["currency_name"]),
			"currency_short"	=> json_encode($post["currency_short"])
		); 
		return $this->db->insert("currency", $arr);
	}
	
	function update_currency($post){ 
		$arr = array(
			"currency_name"    => json_encode($post["currency_name"]),
			"currency_short"	=> json_encode($post["currency_short"])
		); 
		return $this->db->where("currency_id", $post["currency_id"])->update("currency", $arr);
	}
	
	function update_currency_status($currency_active, $currency_id){
		return $this->db->set("currency_active", $currency_active)->where("currency_id", $currency_id)->update("currency");
	}
	function remove_currency_id($currency_id){
		return $this->db->where("currency_id", $currency_id)->delete("currency");
	}

	/*
		course
	*/
	
	function add_course($post){
		$arr = array(
			"course_title"		=> json_encode($post["course_title"]),
			"course_details"	=> json_encode($post["course_details"]),
			"course_tags"		=> json_encode($post["course_tags"]),
			"course_hours"		=> $post["course_hours"],
			"course_capacity"	=> $post["course_capacity"],
			"course_price"		=> $post["course_price"],
			"currency_id"		=> $post["currency_id"]
		);
		return $this->db->insert("course", $arr);
	}
	
	function update_course($post){
		$arr = array(
			"course_title"		=> json_encode($post["course_title"]),
			"course_details"	=> json_encode($post["course_details"]),
			"course_tags"		=> json_encode($post["course_tags"]),
			"course_hours"		=> $post["course_hours"],
			"course_capacity"	=> $post["course_capacity"],
			"course_price"		=> $post["course_price"],
			"currency_id"		=> $post["currency_id"]
		);
		return $this->db->where("course_id", $post["course_id"])->update("course", $arr);
	} 
	function update_course_status($course_active, $course_id){
		return $this->db->set("course_active", $course_active)->where("course_id", $course_id)->update("course");
	}


	function get_course_level($course_id){
		return $this->db
		->where('course_id',$course_id)
		->get('course_level')->result();
	}
	function get_course_level_id($level_id){
		return $this->db
		->where('level_id',$level_id)
		->get('course_level')->row();
	}
	function add_level($post){
		$arr = array(
			"course_id"		=> $post["course_id"],
			"level_name"		=> $post["level_name"],
			"level_hours"		=> $post["level_hours"],
			"level_price"		=> $post["level_price"],
		);
		return $this->db->insert("course_level", $arr);
	}
	function update_level($post){
		$arr = array(
			"level_name"		=> $post["level_name"],
			"level_hours"		=> $post["level_hours"],
			"level_price"		=> $post["level_price"],
		);
		return $this->db->where("level_id", $post["level_id"])->update("course_level", $arr);
	}
}