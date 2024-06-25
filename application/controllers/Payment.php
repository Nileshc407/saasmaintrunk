<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Payment extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Saas_model');
		$this->load->library('form_validation');	
		$this->load->library('Send_notification');
		$this->load->helper(array('form', 'url','encryption_val'));	
		$this->load->model('Email_templateM/Email_templateModel');
		
		
	}

	public function index()
	{
		include('application/libraries/rozarpay/config/config.php');
		include('application/libraries/rozarpay/razorpay-php/Razorpay.php');
		
		use Razorpay\Api\Api;
		
		$api = new Api($keyId, $keySecret);
		$final = 100;
		$currency = 'INR';
		
		$orderData = [
			'receipt'         => rand(1000,9999).'ORD',
			'amount'          => $final,
			'currency'        => $currency,	
			'payment_capture' => 1 ];
			
		$razorpayOrder = $api->order->create($orderData);

		$razorpayOrderId = $razorpayOrder['id'];
		
		echo "razorpayOrderId--------".$razorpayOrderId;	
		//$this->load->view('Saas_company/Create_Saas_Company2',$data);
	}	
}
?>