<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    } 

	// get count of student
	function get_count_student(){
		if($this->session->userdata("group_id") == 1){
			return $this->db->count_all("student");
		} else {
			$row = $this->db
				->where("student.branch_id", $this->session->userdata("branch_id"))
				->get("student")->result();
			return count($row);
		}
	}
	
	// get list of student 
	function get_student($limit, $start) {
		if($this->session->userdata("group_id") == 1){
			return $this->db->limit($limit, $start)
			->order_by("student_create_at", "DESC")
			->join("branch","branch.branch_id = student.branch_id","left")
			->get("student")->result();
		} else {
			return $this->db->limit($limit, $start)
			->order_by("student_create_at", "DESC")
			->where("student.branch_id", $this->session->userdata("branch_id"))
			->join("branch","branch.branch_id = student.branch_id","left")
			->get("student")->result();
		}
	}

	// get info of student
	function get_student_id($student_id){
		return $this->db->where("student_id", $student_id)->get("student")->row();
	}
	
	function add_student($post, $student_pic){
		$arr = array(
			"student_pic"				=> $student_pic,
			"student_name_ar"			=> $post["student_name_ar"],
			"student_name_en"			=> $post["student_name_en"],
			"student_idno"				=> $post["student_idno"],
			"student_gender"			=> $post["student_gender"],
			"student_dob"				=> $post["student_dob"],
			"student_email"				=> $post["student_email"],
			"student_phone"				=> $post["student_phone"],
			"student_tel"				=> $post["student_tel"],
			"branch_id"					=> $post["branch_id"],
			"student_address"			=> $post["student_address"],
			"student_password"			=> $this->bcrypt->hash_password($post["student_idno"]),
			"student_create_by"			=> $this->session->userdata("user_id"),
		); 
		$this->db->insert("student", $arr);
		return $this->db->insert_id();
	}
	
	function update_student($post, $student_pic){
		$arr = array( 
			"student_pic"				=> $student_pic,
			"student_name_ar"			=> $post["student_name_ar"],
			"student_name_en"			=> $post["student_name_en"],
			"student_idno"				=> $post["student_idno"],
			"student_gender"			=> $post["student_gender"],
			"student_dob"				=> $post["student_dob"],
			"student_email"				=> $post["student_email"],
			"student_phone"				=> $post["student_phone"],
			"student_tel"				=> $post["student_tel"],
			"branch_id"					=> $post["branch_id"],
			"student_address"			=> $post["student_address"],
		); 
		return $this->db->where("student_id", $post["student_id"])->update("student", $arr);
	}

	function update_student_status($student_active, $student_id){
		return $this->db->set("student_active", $student_active)->where("student_id", $student_id)->update("student");
	}

	function remove_student_id($student_id){
		return $this->db->where("student_id", $student_id)->delete("student");
	}
	
}