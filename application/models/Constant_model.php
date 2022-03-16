<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Constant_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
		
    }

    function get_city(){
		return $this->db->get("city")->result();
	}
	
    function get_trainer(){
		return $this->db->get("trainer")->result();
	}
	
    function get_branch(){
		return $this->db
		->join("city","city.city_id = branch.city_id","left")
		->get("branch")->result();
	}
	
    function get_course(){
		return $this->db->where("course_active", 1)->get("course")->result();
	}
	
    function get_course_id($course_id){
		return $this->db->where("course_id", $course_id)->get("course")->row();
	}
	
    function get_course_level($course_id){
		return $this->db
		->where("course_level.course_id", $course_id)
		->join("course","course_level.course_id = course.course_id","left")
		->get("course_level")->result();
	}
	
    function get_course_available(){
		return $this->db
		->order_by("course_available.course_available_create_at", "DESC")
		->join("course","course_available.course_id = course.course_id","left")
		->join("course_level","course_available.level_id = course_level.level_id","left")
		->join("course_status","course_available.course_status_id = course_status.course_status_id","left")
		->join("users","course_available.course_available_create_by = users.user_id","left")
		->get("course_available")->result();
	}
	
    function get_course_available_student($course_available_id){
		return $this->db->where("course_available_id", $course_available_id)->get("course_student")->result();
	}
    function get_course_status(){
		return $this->db->get("course_status")->result();
	}
	
    function get_student(){
		return $this->db->get("student")->result();
	}
    function get_student_status($course_id){
		return $this->db->get("student_status")->result();
	}
    function get_sutdent_group($course_group_id){
		return $this->db->where("group_id",$course_group_id)->get("course_student")->result();
	}
	
    function get_currency(){
		return $this->db->get("currency")->result();
	}
}