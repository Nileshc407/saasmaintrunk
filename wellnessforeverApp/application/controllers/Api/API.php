<?php 
// Approved cust redeem request File 
error_reporting(0);
class API extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Api/Merchant_api_model');	
	}
	public function index() 
	{	
		$Requesty_data = json_decode(base64_decode($_REQUEST['RequestData']));
		$Requesty_data = get_object_vars($Requesty_data);
		$Enrollement_id = $Requesty_data['Enrollement_id'];
		$Seller_id = $Requesty_data['Seller_id'];
		$Company_id = $Requesty_data['Company_id'];
		$Confirmation_code = $Requesty_data['Confirmation_code'];
		
		$data1 = array(
					'Confirmation_flag' => 1
					);
					
		$Request_approved = $this->Merchant_api_model->Approved_cust_redeem_request($data1,$Enrollement_id,$Company_id,$Seller_id,$Confirmation_code);
		
		if($Request_approved == 1)
		{
			$cust_response = "Confirm Successfully";
		}
		else
		{
			$cust_response = "Already Confirm!";
		}
		echo "<script>
		alert('$cust_response');
		window.close();</script>";
	}		
}		 		
?>