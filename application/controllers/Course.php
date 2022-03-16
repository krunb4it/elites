<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('course_model');
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
        $config["base_url"] 	= base_url() . "course/index";
        $config["total_rows"] 	= $this->course_model->get_count_course_available();
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
		$data["view"] = $this->course_model->get_course_available($config["per_page"], $page); 
		$data["page"] = "back/course/info/index";
		$this->load->view('include/temp',$data); 
	} 
	
	
	public function get_course_level(){
		$course_id = $this->input->post("course_id"); 
		$res = 0;
		if($course_id > 0 and $course_id != ""){
			//$row = $this->course_model->get_course_level($course_id);
			$row = get_course_level($course_id);
			if(!empty($row)){
				$res = '<select class="form-control form-select" name="level_id" required><option value="" selected disabled> الرجاء اختيار المستوى</option>';
				foreach($row as $r){
					$res .= '<option value="'.$r->level_id.'">'.$r->level_name.'</option>';
				}
				$res .="</select>";
			}
		}
		echo $res;
	}
	
	public function new_course_available(){
		$data["page"] = "back/course/info/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_course_available(){
		$post = $this->input->post(null, true);
		
		$this->form_validation->set_rules('course_id', 'اسم الدورة', 'trim|required');
		$this->form_validation->set_rules('course_available_price', 'سعر الدورة', 'trim|required');
		$this->form_validation->set_rules('reg_start_date', 'تاريخ بداية التسجيل للدورة', 'trim|required');
		$this->form_validation->set_rules('reg_end_date', 'تاريخ انتهاء التسجيل للدورة', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else { 
			$row = $this->course_model->add_course_available($post);
			if($row != false){
				$res = "تم الاعلان عن دورة جديدة بنجاح";
				$status = "success";
				$link = "";
				$title = "تم الاعلان عن دورة جديدة";
				$body = "ارجو متابعة الدورة ، وتسجيل الطلاب";
				sendNotificationAdmin($title, $body);
				sendAlert($title, $body);
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function update_course_available(){
		$post = $this->input->post(null, true);
		
		$this->form_validation->set_rules('course_available_price', 'سعر الدورة', 'trim|required');
		$this->form_validation->set_rules('reg_start_date', 'تاريخ بداية التسجيل للدورة', 'trim|required');
		$this->form_validation->set_rules('reg_end_date', 'تاريخ انتهاء التسجيل للدورة', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else { 
			$row = $this->course_model->update_course_available($post);
			if($row != false){
				$res = "تم حفظ التغيرات بنجاح";
				$status = "success";
				$link = "";
				
				$title = "تم تعديل بيانات الدورة ". $post["course_name"];
				$body = "نرجو مراجعة التعديلات التي حدثت على الدورة.";
				sendNotificationAdmin($title, $body);
				sendAlert($title, $body);
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function view_course_available($course_available_id = null){
		if($course_available_id != null){ 
			$data["view"] = $this->course_model->get_course_available_id($course_available_id);
			$data["page"] = "back/course/info/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("course");
		}
	}

	/*
		course_student
	*/
	
	function course_student($course_available_id){
		if($course_available_id != "" and $course_available_id > 0){
			$data["info"] =  $this->course_model->get_course_available_id($course_available_id); 
			$data["view"] =  $this->course_model->get_course_student($course_available_id); 
			$data["page"] = "back/course/student/index";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("course");
		}
	}

	function course_student_add($course_available_id){
		if($course_available_id != null){
			$data["info"] =  $this->course_model->get_course_available_id($course_available_id);
			$data["page"] = "back/course/student/add";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("course/course_student/".$course_available_id);
		}
	}

	public function course_student_new(){
		$post = $this->input->post(null, true);
		$this->form_validation->set_rules('student_id', 'اسم الطالب', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">','</div>');
			$status = "error";
			$link = "";
		} else {
			$check = $this->course_model->course_student_check($post['student_id'], $post['course_available_id']);
			if(empty($check)){
				$row = $this->course_model->course_student_new($post);
				if($row != false){
					$res = "تم تسجيل الطالب في الدورة بنجاح";
					$status = "success";
					$link = "";
				} else {
					$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
					$status = "error";
					$link = "";
				}
			} else {
				$res = "هذا الطالب مسجل في الدورة من قبل";
				$status = "error";
				$link = "";
			}
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	function course_student_view($course_student_id, $course_available_id){
		if($course_student_id != null){ 
			$data["info"] =  $this->course_model->get_course_available_id($course_available_id);
			$data["view"] =  $this->course_model->get_course_student_id($course_student_id);
			$data["page"] = "back/course/student/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("course/course_student/".$course_student_id);
		}
	}
	
	public function course_student_update(){
		$post = $this->input->post(null, true); 
		$row = $this->course_model->course_student_update($post);
		if($row != false){
			$res = "تم تعديل بيانات الطالب في الدورة بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 

	/*
		course_group
	*/

	function course_group($course_available_id){
		if($course_available_id != "" and $course_available_id > 0){
			$data["info"] =  $this->course_model->get_course_available_id($course_available_id); 
			$data["view"] =  $this->course_model->get_course_group($course_available_id); 
			$data["page"] = "back/course/group/index";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("course");
		}
	}

	function course_group_view($course_group_id, $course_available_id){ 
		$data["info"] =  $this->course_model->get_course_available_id($course_available_id); 
		$data["view"] =  $this->course_model->get_course_group_view($course_available_id); 
		$data["page"] = "back/course/group/view";
		$this->load->view('include/temp',$data);  
	}

	function course_group_add($course_available_id){ 
		$data["info"] =  $this->course_model->get_course_available_id($course_available_id);
		$data["page"] = "back/course/group/add";
		$this->load->view('include/temp',$data);  
	}
	
	public function course_group_new(){
		$post = $this->input->post(null, true);
		$this->form_validation->set_rules('branch_id', 'الفرع', 'trim|required');
		$this->form_validation->set_rules('trainer_id', 'المدرب', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">','</div>');
			$status = "error";
			$link = "";
		} else { 
			$row = $this->course_model->course_group_new($post);
			if($row != false){
				$res = "تم انشاء المجموعة بنجاح";
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
	public function course_group_update(){
		$post = $this->input->post(null, true); 
		$row = $this->course_model->course_group_update($post);
		if($row != false){
			$res = "تم حفظ التغيرات بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
 
	/*
		course_group_student
	*/
	function course_group_student($course_group_id, $course_available_id){
		$data["view"] = $this->course_model->course_group_student($course_group_id);
		$data["student"] = $this->course_model->course_nogroup_student($course_available_id);
		$data["info"] =  $this->course_model->get_course_available_id($course_available_id);
		$data["page"] = "back/course/group/student";
		$this->load->view('include/temp',$data);
	}
}