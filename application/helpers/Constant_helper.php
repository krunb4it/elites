<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	// City  
	if(!function_exists('get_city')){
		function get_city(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_city();
			return $row;
		}
	}
	
	// trainer  
	if(!function_exists('get_trainer')){
		function get_trainer(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_trainer();
			return $row;
		}
	}
	
	// branch  
	if(!function_exists('get_branch')){
		function get_branch(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_branch();
			return $row;
		}
	}
	
	// course  
	if(!function_exists('get_course')){
		function get_course(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_course();
			return $row;
		}
	}
	
	// course ID  
	if(!function_exists('get_course_id')){
		function get_course_id($course_id){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_course_id($course_id);
			return $row;
		}
	}
	
	// course_level
	if(!function_exists('get_course_level')){
		function get_course_level($course_id){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_course_level($course_id);
			return $row;
		}
	}
	
	// course_status
	if(!function_exists('get_course_status')){
		function get_course_status(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_course_status();
			return $row;
		}
	}
	
	// course_status
	if(!function_exists('get_course_available')){
		function get_course_available(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_course_available();
			return $row;
		}
	}
	// course_available_student
	if(!function_exists('get_course_available_student')){
		function get_course_available_student($course_available_id){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_course_available_student($course_available_id);
			return $row;
		}
	}
	
	// get_student
	if(!function_exists('get_student')){
		function get_student(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_student();
			return $row;
		}
	}
	
	// student_status
	if(!function_exists('get_student_status')){
		function get_student_status(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_student_status();
			return $row;
		}
	}
	
	// student_status
	if(!function_exists('get_sutdent_group')){
		function get_sutdent_group($course_group_id){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_sutdent_group($course_group_id);
			return $row;
		}
	}
	
	// currency  
	if(!function_exists('get_currency')){
		function get_currency(){  
			$CI =& get_instance();
			$CI->load->model('constant_model');
			$row = $CI->constant_model->get_currency();
			return $row;
		}
	}
	
	