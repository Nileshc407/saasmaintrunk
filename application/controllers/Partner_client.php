<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Partner_client extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	public function set_session_companyid()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['enroll'] = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$data['User_id'] = $session_data['userId'];
			$CompanyID = $this->input->post("compid");
			
		$Client_company_array = $this->Igain_model->get_partner_clients($CompanyID);
		
		//print_r($Client_company_array); die;
		$data['Client_company_array'] = $Client_company_array;

		$this->load->view('view_partner_client',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	/******************Nilesh Chnage***********************/
	public function Client_Companies_Details()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['enroll'] = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$data['User_id'] = $session_data['userId'];
			$CompanyID = $this->input->post("compid");
			
			 
			if($CompanyID == 0)
			{
				$Client_company_Trans = $this->Igain_model->get_partner_clients_transaction_miracleAdmin();	
				$data['Client_company_Trans'] = $Client_company_Trans;
			}
			else
			{
				$Client_company_Trans = $this->Igain_model->get_partner_clients_transaction($CompanyID);
				$data['Client_company_Trans'] = $Client_company_Trans;
			}
			//$Client_company_array = $this->Igain_model->get_partner_clients($CompanyID);
			//print_r($Client_company_array); die;
			//$data['Client_company_array'] = $Client_company_array;

		$this->load->view('Client_Companies_Details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	/******************Nilesh end***********************/
	
	public function reset_session()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$partner = $this->input->post("partner");
			$partner_client = $this->input->post("partner_client");
			$Company_id = $session_data['Company_id'];
			$logged_in_enroll = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			// $session_data = $this->session->userdata('logged_in');
			
			//echo "logged_in_enroll--".$logged_in_enroll; die;
			/***********************AMIT 24-05-2016***********************************/
			$_SESSION['Logged_user_id'] = $Logged_user_id;
			if($partner == 1)
			{
				$lv_company=$partner_client;
			}
			else
			{
				$lv_company=$partner;
			}				
			$FetchedParentCompany = $this->Igain_model->get_company_details($lv_company);
			$_SESSION['Localization_logo'] = $FetchedParentCompany->Localization_logo;
			$_SESSION['Localization_flag'] = $FetchedParentCompany->Localization_flag;
			$_SESSION['Company_logo'] = $FetchedParentCompany->Company_logo;
			/*******************************************************************************/	
			if($partner > 0)
			{
				if($partner_client > 0)
				{
					$session_data['Company_id'] = $partner_client;
					$this->session->set_userdata('logged_in', $session_data);
				}
				else
				{
					$session_data['Company_id'] = $partner;
					$this->session->set_userdata('logged_in', $session_data);
					$results = $this->Enroll_model->edit_enrollment($logged_in_enroll);
					
					$Partner_company_id = $results->Company_id;
					
					if($Partner_company_id == $partner && $Logged_user_id == 4)
					{
						//echo "partner--".$partner; die;
						redirect('Company/edit_company/?Company_id='.$partner.'', 'refresh');
					}
				}
			}
			
			redirect('Home', 'refresh');
		}
		else
		{
			redirect('Login', 'refresh');
		}
		
		
	}
	
}
?>
