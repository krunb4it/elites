<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('student_model');
		$this->load->model('welcome_model');
 
		if($this->session->userdata("my_token") != $this->security->get_csrf_hash()){
			redirect("welcome/login");
		}
		/*
		$permission = $this->welcome_model->have_permission();
		( $permission == 0) ? redirect("welcome/no_auth") : "";
		*/
	}
	
	public function index(){
		$config = array();
        $config["base_url"] 	= base_url() . "student/index";
        $config["total_rows"] 	= $this->student_model->get_count_student();
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 3;
		
		$config['full_tag_open'] = '<ul class="pagination pagination-lg justify-content-center mt-4">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'الصفحة الاولى';
		$config['last_link'] = 'الصفحة الاخيرة';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'السابق';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'التالي';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</span></li>';
		
        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
        $data["links"] = $this->pagination->create_links(); 
		$data["view"] = $this->student_model->get_student($config["per_page"], $page); 
		$data["page"] = "back/student/index";
		$this->load->view('include/temp',$data); 
	} 


	/*
		student
	*/
	
	public function new_student(){
		$data["page"] = "back/student/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_student(){
		$post = $this->input->post(null, true);
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		
		$this->form_validation->set_rules('student_name_ar', 'اسم الطالب بالعربية', 'trim|required|is_unique[student.student_name_ar]');
		$this->form_validation->set_rules('student_name_en', 'اسم الطالب بالانجليزية', 'trim|required|is_unique[student.student_name_en]');
		$this->form_validation->set_rules('student_idno', 'رقم هوية الطالب', 'trim|required|is_unique[student.student_idno]');
		$this->form_validation->set_rules('student_phone', 'رقم الجوال', 'trim|is_unique[student.student_phone]');
		$this->form_validation->set_rules('student_email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[student.student_email]');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/student/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			$student_pic = "";
			
			if($_FILES['student_pic']['name'] != ''){
				if($this->upload->do_upload("student_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$student_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			$student_id = $this->student_model->add_student($post, $student_pic);
			
			if($student_id != false){
				$res = "تم اضافة طالب جديد بنجاح";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function view_student($student_id = null){
		if($student_id != null){ 
			$data["view"] = $this->student_model->get_student_id($student_id);
			$data["page"] = "back/student/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("student");
		}
	}

	public function update_student(){
		$post = $this->input->post(null, true); 
		$id = $post["student_id"];
		
		$this->form_validation->set_rules('student_name', 'اسم الطالب', 'trim|required|edit_unique_student[student.student_name.'. $id .']');
		$this->form_validation->set_rules('student_jawwal', 'رقم الجوال', 'trim|edit_unique_student[student.student_jawwal.'. $id .']'); 
		$this->form_validation->set_rules('student_email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique_student[student.student_email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/student/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$student_pic = $post["last_student_pic"]; 
			
			if($_FILES['student_pic']['name'] != ''){
				if($this->upload->do_upload("student_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$student_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
					//remove old pic
					//unlink($post["last_student_pic"]);
				}
			}

			$res = $this->student_model->update_student($post, $student_pic);
			if($res != false){
				$res = "تم تعديل حساب الطالب". $post['student_name_ar'] ." بنجاح ";
				$status = "success";
				$link = site_url()."student";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	public function update_student_status(){ 
		$student_id = $this->input->post("student_id", true); 
		$student_active = $this->input->post("student_active", true);
		
		$res = $this->student_model->update_student_status($student_active, $student_id);
		if($res != false){
			$res = "تم تغيير حالة الطالب بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function remove_student_id(){ 
		$student_id = $this->input->post("student_id", true);
		
		$res = $this->student_model->remove_student_id($student_id);
		if($res != false){
			$res = " تم حذف الطالب بنجاح.";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
}