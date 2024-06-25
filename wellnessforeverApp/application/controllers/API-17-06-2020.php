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
            $Company_id = 25;
        }
   
        $General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'General', 'value', $Company_id);
        $this->General_details = json_decode($General_data, true);
		
      
        $Small_font = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Small_font', 'value', $Company_id);
        $this->Small_font_details = json_decode($Small_font, true);

        $Medium_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Medium_font', 'value', $Company_id);
        $this->Medium_font_details = json_decode($Medium_font_data, true);

        $Large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Large_font', 'value', $Company_id);
		
        $this->Large_font_details = json_decode($Large_font_data, true);

        $Extra_large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Extra_large_font', 'value', $Company_id);
        $this->Extra_large_font_details = json_decode($Extra_large_font_data, true);

        $Button_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Button_font', 'value', $Company_id);
        $this->Button_font_details = json_decode($Button_font_data, true);

        $Value_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Value_font', 'value', $Company_id);
        $this->Value_font_details = json_decode($Value_font_data, true);

        $Footer_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Footer_font', 'value', $Company_id);
        $this->Footer_font_details = json_decode($Footer_font_data, true);

        $Placeholder_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Placeholder_font', 'value', $Company_id);
        $this->Placeholder_font_details = json_decode($Placeholder_font_data, true);

    //--------------------Frontend Template Settings----------------------//
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
		
		 // -------------------Template----CSS--------------------- //
		$data['Company_id'] = $Company_id;
		$data['Small_font_details'] = $this->Small_font_details;
		$data['Medium_font_details'] = $this->Medium_font_details;
		$data['Large_font_details'] = $this->Large_font_details;
		$data['Extra_large_font_details'] = $this->Extra_large_font_details;
		$data['Button_font_details'] = $this->Button_font_details;
		$data['General_details'] = $this->General_details;
		$data['Value_font_details'] = $this->Value_font_details;
		$data['Footer_font_details'] = $this->Footer_font_details;
		$data['Placeholder_font_details'] = $this->Placeholder_font_details;
		$data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
		//-----------------Template-----CSS-------------------- //
		
		$data1 = array(
					'Confirmation_flag' => 1
					);
					
		$Request_approved = $this->Igain_model->Approved_cust_redeem_request($data1,$Enrollement_id,$Company_id,$Seller_id,$Confirmation_code,$Bill_no);
		
		if($Request_approved == 1)
		{
			$cust_response = "Confirmed Successfully";
			 $MColor = "#41ad41";
			$Img = "success";
		}
		else
		{
			$cust_response = "Already Confirmed!";
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