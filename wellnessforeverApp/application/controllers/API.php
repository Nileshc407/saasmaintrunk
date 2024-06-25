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
		 $this->load->library('cart');
		// $this->load->model('Api/Merchant_api_model');	
		$this->load->model('Igain_model');	
		$this->load->model('General_setting_model');
		
	//-------------------Frontend Template Settings--------------------------//
        if ($this->session->userdata('cust_logged_in')) {
            $session_data = $this->session->userdata('cust_logged_in');
            $Company_id = $session_data['Company_id'];
        } else {
            $Company_id = 3;
        }
	}
	public function index() 
	{
		$session_data = $this->session->userdata('cust_logged_in');  
		$Walking_customer = $session_data['Walking_customer'];
		if($Walking_customer == 1)
		{
			redirect('shopping');
		}		
        $data['smartphone_flag'] = $session_data['smartphone_flag'];
		
		$Requesty_data = json_decode(base64_decode($_REQUEST['RequestData']));
		$Requesty_data = get_object_vars($Requesty_data);
		$Enrollement_id = $Requesty_data['Enrollement_id'];
		$Seller_id = $Requesty_data['Seller_id'];
		$Company_id = $Requesty_data['Company_id'];
		$Confirmation_code = $Requesty_data['Confirmation_code'];
		$Bill_no = $Requesty_data['Pos_bill_no'];
		
		$data1 = array(
					'Confirmation_flag' => 1
					);
					
		$Request_approved = $this->Igain_model->Approved_cust_redeem_request($data1,$Enrollement_id,$Company_id,$Seller_id,$Confirmation_code,$Bill_no);
		// echo "Request_approved-------".$Request_approved; die;
		if($Request_approved == 1)
		{
			$cust_response = "Confirmed Successfully";
			 $MColor = "#41ad41";
			$Img = "success";
		}
		else if($Request_approved == 2)
		{
			$cust_response = "Redeem Request Expired, Cannot Confirm/Decline this Request";
			$Img = "Fail";
			$MColor = "#FF0000";
		}
		else
		{
			$cust_response = "Already Confirmed / Declined!";
			$Img = "Fail";
			$MColor = "#FF0000";
		}
		
		if($session_data['smartphone_flag'] == 1)
		{
			$data["MColor"] = $MColor;
			$data["Img"] = $Img;
			$data["Success_Message"] = $cust_response;
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($Enrollement_id);
			$this->load->view('front/mailbox/Confirmation', $data);
		}
		else 
		{
			echo "<script>
			alert('$cust_response');
			window.close();</script>";
		}
	}
	function Decline() 
	{
		$session_data = $this->session->userdata('cust_logged_in');  
		
        $data['smartphone_flag'] = $session_data['smartphone_flag'];
		
		$Requesty_data = json_decode(base64_decode($_REQUEST['RequestData']));
		$Requesty_data = get_object_vars($Requesty_data);
		$Enrollement_id = $Requesty_data['Enrollement_id'];
		$Seller_id = $Requesty_data['Seller_id'];
		$Company_id = $Requesty_data['Company_id'];
		$Confirmation_code = $Requesty_data['Confirmation_code'];
		$Bill_no = $Requesty_data['Pos_bill_no'];
		
		$data1 = array(
					'Confirmation_flag' => 3 // Decline
					);
					
		$Request_approved = $this->Igain_model->Approved_cust_redeem_request($data1,$Enrollement_id,$Company_id,$Seller_id,$Confirmation_code,$Bill_no);
		
		if($Request_approved == 1)
		{
			$cust_response = "Declined Successfully";
			 $MColor = "#41ad41";
			$Img = "success";
		}
		else if($Request_approved == 2)
		{
			$cust_response = "Redeem Request Expired, Cannot Decline/Confirm this Request";
			$Img = "Fail";
			$MColor = "#FF0000";
		}
		else
		{
			$cust_response = "Already Declined / Confirmed!";
			$Img = "Fail";
			$MColor = "#FF0000";
		}
		
		if($session_data['smartphone_flag'] == 1)
		{
			$data["MColor"] = $MColor;
			$data["Img"] = $Img;
			$data["Success_Message"] = $cust_response;
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($Enrollement_id);
			$this->load->view('front/mailbox/Confirmation', $data);
		}
		else 
		{
			echo "<script>
			alert('$cust_response');
			window.close();</script>";
		}
	}		
}		 		
?>