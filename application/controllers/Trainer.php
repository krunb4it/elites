<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainer extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('trainer_model');
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
        $config["base_url"] 	= base_url() . "trainer/index";
        $config["total_rows"] 	= $this->trainer_model->get_count_trainer();
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
		$data["view"] = $this->trainer_model->get_trainer($config["per_page"], $page); 
		$data["page"] = "back/trainer/index";
		$this->load->view('include/temp',$data); 
	} 


	/*
		trainer
	*/
	
	public function new_trainer(){
		$data["page"] = "back/trainer/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_trainer(){
		$post = $this->input->post(null, true);
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		
		$this->form_validation->set_rules('trainer_name_ar', 'اسم الطالب بالعربية', 'trim|required|is_unique[trainer.trainer_name_ar]');
		$this->form_validation->set_rules('trainer_name_en', 'اسم الطالب بالانجليزية', 'trim|required|is_unique[trainer.trainer_name_en]');
		$this->form_validation->set_rules('trainer_idno', 'رقم هوية الطالب', 'trim|required|is_unique[trainer.trainer_idno]');
		$this->form_validation->set_rules('trainer_phone', 'رقم الجوال', 'trim|is_unique[trainer.trainer_phone]');
		$this->form_validation->set_rules('trainer_email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[trainer.trainer_email]');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/trainer/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			$trainer_pic = "";
			
			if($_FILES['trainer_pic']['name'] != ''){
				if($this->upload->do_upload("trainer_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$trainer_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			$trainer_id = $this->trainer_model->add_trainer($post, $trainer_pic);
			
			if($trainer_id != false){
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
	
	public function view_trainer($trainer_id = null){
		if($trainer_id != null){ 
			$data["view"] = $this->trainer_model->get_trainer_id($trainer_id);
			$data["page"] = "back/trainer/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("trainer");
		}
	}

	public function update_trainer(){
		$post = $this->input->post(null, true); 
		$id = $post["trainer_id"];
		
		$this->form_validation->set_rules('trainer_name', 'اسم الطالب', 'trim|required|edit_unique_trainer[trainer.trainer_name.'. $id .']');
		$this->form_validation->set_rules('trainer_jawwal', 'رقم الجوال', 'trim|edit_unique_trainer[trainer.trainer_jawwal.'. $id .']'); 
		$this->form_validation->set_rules('trainer_email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique_trainer[trainer.trainer_email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/trainer/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$trainer_pic = $post["last_trainer_pic"]; 
			
			if($_FILES['trainer_pic']['name'] != ''){
				if($this->upload->do_upload("trainer_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$trainer_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
					//remove old pic
					//unlink($post["last_trainer_pic"]);
				}
			}

			$res = $this->trainer_model->update_trainer($post, $trainer_pic);
			if($res != false){
				$res = "تم تعديل حساب الطالب". $post['trainer_name_ar'] ." بنجاح ";
				$status = "success";
				$link = site_url()."trainer";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	public function update_trainer_status(){ 
		$trainer_id = $this->input->post("trainer_id", true); 
		$trainer_active = $this->input->post("trainer_active", true);
		
		$res = $this->trainer_model->update_trainer_status($trainer_active, $trainer_id);
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
	
	public function remove_trainer_id(){ 
		$trainer_id = $this->input->post("trainer_id", true);
		
		$res = $this->trainer_model->remove_trainer_id($trainer_id);
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