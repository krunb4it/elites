<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class AutoLoadFunction{
   function index() {
       $ci =& get_instance();
       $ci->load->model('AutoLoadFunction_model');
       $lang = $ci->session->userdata('lang');
       $main_lang = $ci->db->get_where("config","id = 1")->row()->main_lang;
       if ($lang) {
           $ci->lang->load('information',$lang);
       } else {
           $ci->lang->load('information', $main_lang);
       }
   }
} 