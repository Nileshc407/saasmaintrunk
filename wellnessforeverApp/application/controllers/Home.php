<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
        parent::__construct();
		
		$this->load->model('General_setting_model');
        $this->system_title = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'General', 'value');
        $cache_time  =  $this->db->get_where('frontend_settings',array('type' => 'cache_time'))->row()->value;
    }
	public function index() {		
		// $page_data['title'] = $this->system_title;
		// $page_data['top'] = APPPATH."..\header\header.php";
		$page_data['page'] = "home";
		// $page_data['title'] = $this->system_title ;
		$page_data['title'] ='Joy Coins' ;
		$this->load->view('front/home/home',$page_data);
	}
	public function dashboard() {
		// echo"dashboard";
		$page_data['page'] = "Dashboard";
		// $page_data['title'] = $this->system_title ;
		$page_data['title'] ='Joy Coins' ;
		$this->load->view('front/dashboard/dashboard',$page_data);
	}	
	
}
