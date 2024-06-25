<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Termandconditions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('Send_notification');
		$this->load->helper('language');
		$this->load->helper(array('form', 'url','encryption_val'));	
	}
	public function index()
    {
		$this->load->view('home/termsandconditions');
	}
} 
?>