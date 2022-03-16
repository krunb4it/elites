<?php

class MY_Form_validation extends CI_Form_validation{

    public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'user_id !=' => $id))->num_rows() === 0)
            : FALSE;
    }
	
	/*----------------------------------
		student
	----------------------------------*/
	
	public function edit_unique_student($str, $field){
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'student_id !=' => $id))->num_rows() === 0)
            : FALSE;
    }
	
	/*----------------------------------
		tranier
	----------------------------------*/
	
	public function edit_unique_tranier($str, $field){
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'tranier_id !=' => $id))->num_rows() === 0)
            : FALSE;
    }

	/*----------------------------------
		course
	----------------------------------*/
	
	public function edit_unique_course($str, $field){
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'course_id !=' => $id))->num_rows() === 0)
            : FALSE;
    }

}