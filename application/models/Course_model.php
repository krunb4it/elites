<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    } 

	// get course level
	function get_course_level($course_id){ 
		return $this->db->where("course_id", $course_id)->get("course_level")->result();
	}
	
	// get count of course_available
	function get_count_course_available(){ 
		return $this->db->count_all("course_available");
	}
	
	// get list of course_available 
	function get_course_available($limit, $start) {
		return $this->db->limit($limit, $start)
		->order_by("course_available.course_available_create_at", "DESC")
		->join("course","course_available.course_id = course.course_id","left")
		->join("course_level","course_available.level_id = course_level.level_id","left")
		->join("course_status","course_available.course_status_id = course_status.course_status_id","left")
		->join("users","course_available.course_available_create_by = users.user_id","left")
		->get("course_available")->result();
	}

	// get info of course_available
	function get_course_available_id($course_available_id){
		return $this->db
		->where("course_available_id", $course_available_id)
		->join("course","course_available.course_id = course.course_id","left")
		->join("course_level","course_available.level_id = course_level.level_id","left")
		->join("course_status","course_available.course_status_id = course_status.course_status_id","left")
		->join("users","course_available.course_available_create_by = users.user_id","left")
		->get("course_available")->row();
	}
	
	function add_course_available($post){
		$arr = array(
			"course_id"						=> $post["course_id"],
			"level_id"						=> $post["level_id"],
			"course_available_price"		=> $post["course_available_price"],
			"seat_reservation"				=> $post["seat_reservation"],
			"reg_start_date"				=> $post["reg_start_date"],
			"reg_end_date"					=> $post["reg_end_date"],
			"course_available_note"			=> nl2br($post["course_available_note"]),
			"course_status_id"				=> 1,
			"course_available_create_by"	=> $this->session->userdata("user_id"),
		); 
		return $this->db->insert("course_available", $arr);
	}
	 
	function update_course_available($post){
		$arr = array(
			"course_available_price"		=> $post["course_available_price"],
			"seat_reservation"				=> $post["seat_reservation"],
			"reg_start_date"				=> $post["reg_start_date"],
			"reg_end_date"					=> $post["reg_end_date"],
			"course_available_note"			=> nl2br($post["course_available_note"]),
	//		"course_status_id"				=> $post["course_status_id"]
		);
		return $this->db->where("course_available_id", $post['course_available_id'])->update("course_available", $arr);
	}


	/*
		Student
	*/

	function get_course_student($course_available_id){
		return $this->db
		->order_by("course_student.reg_date","DESC")
		->where("course_student.course_available_id", $course_available_id)
		->join("student","student.student_id = course_student.student_id","left")
		->join("course_group","course_group.course_group_id = course_student.group_id","left")
		->join("course_available","course_available.course_available_id = course_student.course_available_id","left")
		->join("users","users.user_id = course_student.reg_by","left")
		->get("course_student")->result();
	}
	 
	function get_course_student_id($course_student_id){
		return $this->db
		->where("course_student.course_student_id", $course_student_id)
		->join("student","student.student_id = course_student.student_id","left")
		->join("course_available","course_available.course_available_id = course_student.course_available_id","left")
		->join("users","users.user_id = course_student.reg_by","left")
		->get("course_student")->row();
	}
	 
	function course_student_check($student_id, $course_available_id){
		return $this->db
		->where("course_available_id", $course_available_id)
		->where("student_id", $student_id)
		->get("course_student")->result();
	}

	function course_student_new($post){
		$arr = array(
			"course_available_id"	=> $post["course_available_id"],
			"student_id"			=> $post["student_id"],
			"pay_seat_reservation"	=> $post["pay_seat_reservation"],
			"voucher_number"		=> $post["voucher_number"],
			"reg_note"				=> nl2br($post["reg_note"]),  
			"reg_by"				=> $this->session->userdata("user_id"),
		); 
		return $this->db->insert("course_student", $arr);
	}
	
	function course_student_update($post){
		$arr = array(
			"pay_seat_reservation"	=> $post["pay_seat_reservation"],
			"voucher_number"		=> $post["voucher_number"],
			"reg_note"				=> nl2br($post["reg_note"]),
		); 
		return $this->db->where("course_student_id", $post['course_student_id'])->update("course_student", $arr);
	}


	/*
		Group
	*/

	function get_course_group($course_available_id){
		return $this->db 
		->where("course_group.course_available_id", $course_available_id)
		->join("branch","branch.branch_id = course_group.branch_id","left")
		->join("trainer","trainer.trainer_id = course_group.trainer_id","left")
		->join("course_available","course_available.course_available_id = course_group.course_available_id","left")
		->join("users","users.user_id = course_group.group_create_by","left")
		->get("course_group")->result();
	} 

	function get_course_group_view($course_group_id){
		return $this->db
		->where("course_group.course_group_id", $course_group_id)
		->get("course_group")->row();
	}
	
	function course_group_new($post){
		$arr = array(
			"course_available_id"	=> $post["course_available_id"],
			"group_name"			=> $post["group_name"],
			"trainer_id"			=> $post["trainer_id"],
			"branch_id"				=> $post["branch_id"], 
			"group_note"			=> nl2br($post["group_note"]), 
			"group_create_by"		=> $this->session->userdata("user_id"),
		); 
		return $this->db->insert("course_group", $arr);
	}

	function course_group_update($post){
		$arr = array(
			"group_name"	=> $post["group_name"],
			"trainer_id"	=> $post["trainer_id"],
			"branch_id"		=> $post["branch_id"], 
			"group_note"	=> nl2br($post["group_note"]), 
		); 
		return $this->db->where("course_group_id", $post['course_group_id'])->update("course_group", $arr);
	}


	/*
		Student Of group
	*/

	function course_group_student($course_group_id){
		return $this->db
		->where("course_student.group_id", $course_group_id)
		->join("student","student.student_id = course_student.student_id","left")
		->get("course_student")->result();
	}
	function course_nogroup_student($course_available_id){
		return $this->db
		->where("course_available_id", $course_available_id)
		->where("course_student.group_id", 0)
		->join("student","student.student_id = course_student.student_id","left")
		->get("course_student")->result();
	}
}