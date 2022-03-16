<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainer_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    } 

	// get count of trainer
	function get_count_trainer(){
		if($this->session->userdata("group_id") == 1){
			return $this->db->count_all("trainer");
		} else {
			$row = $this->db
				->where("trainer.branch_id", $this->session->userdata("branch_id"))
				->get("trainer")->result();
			return count($row);
		}
	}
	
	// get list of trainer 
	function get_trainer($limit, $start) {
		if($this->session->userdata("group_id") == 1){
			return $this->db->limit($limit, $start)
			->order_by("trainer_create_at", "DESC")
			->join("branch","branch.branch_id = trainer.branch_id","left")
			->get("trainer")->result();
		} else {
			return $this->db->limit($limit, $start)
			->order_by("trainer_create_at", "DESC")
			->where("trainer.branch_id", $this->session->userdata("branch_id"))
			->join("branch","branch.branch_id = trainer.branch_id","left")
			->get("trainer")->result();
		}
	}

	// get info of trainer
	function get_trainer_id($trainer_id){
		return $this->db->where("trainer_id", $trainer_id)->get("trainer")->row();
	}
	
	function add_trainer($post, $trainer_pic){
		$arr = array(
			"trainer_pic"				=> $trainer_pic,
			"trainer_name_ar"			=> $post["trainer_name_ar"],
			"trainer_name_en"			=> $post["trainer_name_en"],
			"trainer_idno"				=> $post["trainer_idno"],
			"trainer_gender"			=> $post["trainer_gender"],
			"trainer_dob"				=> $post["trainer_dob"],
			"trainer_email"				=> $post["trainer_email"],
			"trainer_phone"				=> $post["trainer_phone"],
			"trainer_tel"				=> $post["trainer_tel"],
			"branch_id"					=> $post["branch_id"],
			"trainer_address"			=> $post["trainer_address"],
			"trainer_password"			=> $this->bcrypt->hash_password($post["trainer_idno"]),
			"trainer_create_by"			=> $this->session->userdata("user_id"),
		); 
		$this->db->insert("trainer", $arr);
		return $this->db->insert_id();
	}
	
	function update_trainer($post, $trainer_pic){
		$arr = array( 
			"trainer_pic"				=> $trainer_pic,
			"trainer_name_ar"			=> $post["trainer_name_ar"],
			"trainer_name_en"			=> $post["trainer_name_en"],
			"trainer_idno"				=> $post["trainer_idno"],
			"trainer_gender"			=> $post["trainer_gender"],
			"trainer_dob"				=> $post["trainer_dob"],
			"trainer_email"				=> $post["trainer_email"],
			"trainer_phone"				=> $post["trainer_phone"],
			"trainer_tel"				=> $post["trainer_tel"],
			"branch_id"					=> $post["branch_id"],
			"trainer_address"			=> $post["trainer_address"],
		); 
		return $this->db->where("trainer_id", $post["trainer_id"])->update("trainer", $arr);
	}

	function update_trainer_status($trainer_active, $trainer_id){
		return $this->db->set("trainer_active", $trainer_active)->where("trainer_id", $trainer_id)->update("trainer");
	}

	function remove_trainer_id($trainer_id){
		return $this->db->where("trainer_id", $trainer_id)->delete("trainer");
	}
	
}