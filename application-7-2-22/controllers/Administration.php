<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Administration extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();			
		$this->load->database();
		// $this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->model('administration/Administration_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Send_notification');
		$this->load->model('enrollment/Enroll_model');
		$this->load->model('Segment/Segment_model');	
		$this->load->model('master/currency_model');
		$this->load->model('Report/Report_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Coal_catalogue/Voucher_model');
		$this->load->helper(array('form', 'url','encryption_val'));	
		// echo "here...";
		// die;
		
	}
//**************** sandeep work start ***************************************	
	function loyalty_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
			
				
			$data["results2"] = $this->Administration_model->loyalty_rule_list('','',$Company_id);
		
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			$data["get_payement_type"] = $this->Igain_model->get_payement_type();
			
			$data["Merchandize_Category_Records"] = $this->Administration_model->Get_Merchandize_Category1('', '',$Company_id);
			
			if($_POST == NULL)
			{
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;

				$this->load->view('administration/loyalty_rule',$data);	

			}
			else
			{			
			
				$result = $this->Administration_model->insert_loyalty_rule();
				
				if($result == true)
				{
					
					
				/**************Nilesh change igain Log Table change 14-06-2017****************/
					$seller = $this->input->post("seller_id");
					$get_marchent = $this->Igain_model->get_enrollment_details($seller);
					$to_enroll_id = $get_marchent->Enrollement_id;	
					$First_name = $get_marchent->First_name;	
					$Last_name = $get_marchent->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 1;				
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Create Loyalty Rule";
					$where="Create Loyalty Rule";
					$toname="";
					// $opval = 4; // transaction type
					if($to_enroll_id == 0 || $to_enroll_id == "" )
					{
						$To_enrollid=0;
					}
					else
					{
						$To_enrollid=$to_enroll_id;
					}
					$firstName = $First_name;
					$lastName = $Last_name;  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$loyalty_rule_setup = $this->input->post("loyalty_rule_setup");
					$data['Loyalty_name'] = $loyalty_rule_setup."-".$this->input->post("LPName");
					$opval = $data['Loyalty_name'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					
				/*********************Nilesh change igain Log Table change 14-06-2017***********************/
				$this->session->set_flashdata("success_code","Loyalty Rule Created Successfully!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN Loyalty Rule Creation !");
				}
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	public function edit_loyalty_rule()
	{	
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
				
			$data["get_payement_type"] = $this->Igain_model->get_payement_type();
			
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
		
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
					
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
		
			$data['Seller_array'] = $get_sellers;
			
			if($_GET['Loyalty_id'])
			{	
				$Loyalty_id =  $_GET['Loyalty_id'];	
						
				$data['results'] = $this->Administration_model->edit_loyaltyrule($Loyalty_id,$Company_id);				
				$data["results2"] = $this->Administration_model->loyalty_rule_list('','',$Company_id);
				$this->load->view('administration/edit_loyalty_rule', $data);
			}
			else
			{
				$this->load->view('administration/loyalty_rule',$data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	function update_loyalty_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
		
			$result20 = $this->Administration_model->update_loyalty_rule();
				
			if($result20 == true)
			{
				$this->session->set_flashdata("success_code","Loyalty Rule Updated Successfully!!");
				
			/*********************Nilesh change igain Log Table change 14-06-2017*********************/
				$data['results'] = $this->Administration_model->edit_loyaltyrule($this->input->post("Loyalty_id"),$Company_id);	
				foreach($data['results'] as $res)
				{
						$loyalty_name=$res['Loyalty_name'];
				}
				// echo"---loyalty_name----".$loyalty_name;// = $results->Loyalty_name;
				// die;					
				$seller_id = $this->input->post("seller_id");
				$get_marchent = $this->Igain_model->get_enrollment_details($seller_id);
				$To_enrollid = $get_marchent->Enrollement_id;	
				$First_name = $get_marchent->First_name;	
				$Last_name = $get_marchent->Last_name;	
				$Todays_date = date('Y-m-d');	
				$opration = 2;				
				// $userid=$data['userId'];
				$userid=$Logged_user_id;
				$what="Update Loyalty Rule";
				$where="Create Loyalty Rule";
				$toname="";
				// $opval = 4; // transaction type
				// $To_enrollid =0;
				$firstName = $First_name;
				$lastName = $Last_name;  
				// $data['LogginUserName'] = $Seller_name;
				$Seller_name = $session_data['Full_name'];
				$loyalty_rule_setup = $this->input->post("loyalty_rule_setup");
				$data['Loyalty_name'] = $loyalty_rule_setup."-".$this->input->post("LPName");
				$opval =$loyalty_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				
			/******************Nilesh change igain Log Table change 14-06-2017************************/
			}
			else
			{							
				$this->session->set_flashdata("error_code","Error IN Loyalty Rule!");
			}
			redirect("Administration/loyalty_rule");
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	function delete_loyalty_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/loyalty_rule";
				$total_row = $this->Administration_model->loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id);
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
				$data["results2"] = $this->Administration_model->loyalty_rule_list($config["per_page"], $page,$Company_id);
				
				$data["pagination"] = $this->pagination->create_links();
	/*-----------------------Pagination---------------------*/
				
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;
				
			if($_GET != NULL)
			{	
				$Loyalty_id =  $_GET['Loyalty_id'];	
				/* 
				$data['results'] = $this->Administration_model->edit_loyaltyrule($Loyalty_id,$Company_id);	
				foreach($data['results'] as $res)
				{
						$loyalty_name=$res['Loyalty_name'];
				} */
				$get_loyalty_detail = $this->Igain_model->get_loyalty_detail($Loyalty_id); 
				$Seller_id = $get_loyalty_detail->Seller;
				$Loyalty_name = $get_loyalty_detail->Loyalty_name;
				
				$result = $this->Administration_model->delete_loyaltyrule($Loyalty_id,$Company_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Loyalty Rule Deleted Successfuly!!");
					
				/********************Nilesh change igain Log Table change 14-06-2017**********************/		
					
					
					$get_merchant_detail = $this->Igain_model->get_enrollment_details($Seller_id);
					$Seller_Enrollement_id = $get_merchant_detail->Enrollement_id;
					$First_name = $get_merchant_detail->First_name;	
					$Last_name = $get_merchant_detail->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 3;				
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Delete Loyalty Rule";
					$where="Create Loyalty Rule";
					$toname="";
					// $opval = 4; // transaction type
					$To_enrollid =0;
					$firstName = $First_name;
					$lastName = $Last_name;  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $Loyalty_name; // loyalty id
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Seller_Enrollement_id);
					
				/**********************Nilesh change igain Log Table change 14-06-2017*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Loyalty Rule !!");
				}
				
				
				redirect('Administration/loyalty_rule');
			}
			else
			{	
				$this->load->view('administration/loyalty_rule',$data);	
			}
			
	
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function loyalty_program_name_validation()
	{
		$lpName = $this->input->post("lpname");
		$CompanyId = $this->input->post("Company_id");

		$result = $this->Administration_model->loyalty_program_name_validation($lpName,$CompanyId);
		
		
		if($result > 0)
		{
			$this->output->set_output(0);//AMIT 06-06-2019
		}
		else    
		{
			$this->output->set_output(1);//AMIT 06-06-2019
		}
	}
	
		//**** Discount Rule Start *******
		
	function discount_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/discount_rule";
				$total_row = $this->Administration_model->discount_rule_count($Company_id);		
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
			$data["results2"] = $this->Administration_model->discount_rule_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();		
		/*-----------------------Pagination---------------------*/
		
			if($_POST == NULL)
			{
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;

				$this->load->view('administration/discount_rule',$data);	

			}
			else
			{			
			
				$result = $this->Administration_model->insert_discount_rule();
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Discount Rule Created Successfully!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN Discount Rule Creation !");
				}
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	
	public function edit_discount_rule()
	{	
		if($this->session->userdata('logged_in'))
		{
		$session_data = $this->session->userdata('logged_in');
		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
		/*-----------------------Pagination---------------------*/		
		$config = array();
		$config["base_url"] = base_url() . "/index.php/Administration/discount_rule";
		$total_row = $this->Administration_model->discount_rule_count($Company_id);		
		$config["total_rows"] = $total_row;
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;        
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
		
		$data["results2"] = $this->Administration_model->discount_rule_list($config["per_page"], $page,$Company_id);
		$data["pagination"] = $this->pagination->create_links();
						
		/*-----------------------Pagination---------------------*/
		
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
					
			if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
		
			$data['Seller_array'] = $get_sellers;
			
			if($_GET['Discount_master_id'])
			{	
				$Discount_master_id =  $_GET['Discount_master_id'];	
						
				$data['results'] = $this->Administration_model->edit_discountrule($Discount_master_id,$Company_id);	
				$this->load->view('administration/edit_discount_rule', $data);
			}
			else
			{
				$this->load->view('administration/discount_rule',$data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function update_discount_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/discount_rule";
				$total_row = $this->Administration_model->discount_rule_count($Company_id);		
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
			$data["results2"] = $this->Administration_model->discount_rule_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();	
		/*-----------------------Pagination---------------------*/
		
			if($_POST == NULL)
			{
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
						
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;

				$this->load->view('administration/discount_rule',$data);	

			}
			else
			{			
			
				$result20 = $this->Administration_model->update_discount_rule();
				
				if($result20 == true)
				{
					$this->session->set_flashdata("error_code","Discount Rule Updated Successfully!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN Discount Rule!");
				}
				redirect("Administration/discount_rule");
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function delete_discount_rule()
	{
		if($this->session->userdata('logged_in'))
		{
		$session_data = $this->session->userdata('logged_in');
		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
		/*-----------------------Pagination---------------------*/		
		$config = array();
		$config["base_url"] = base_url() . "/index.php/Administration/discount_rule";
		$total_row = $this->Administration_model->discount_rule_count($Company_id);		
		$config["total_rows"] = $total_row;
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;        
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
		
		$data["results2"] = $this->Administration_model->discount_rule_list($config["per_page"], $page,$Company_id);
		$data["pagination"] = $this->pagination->create_links();
						
		/*-----------------------Pagination---------------------*/
		
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
					
					
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
		
			$data['Seller_array'] = $get_sellers;
			
			if($_GET != NULL)
			{	
				$Discount_master_id =  $_GET['Discount_master_id'];	
						
				$result = $this->Administration_model->delete_discountrule($Discount_master_id,$Company_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Discount Rule Deleted Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Discount Rule !!");
				}
				
				
				redirect(current_url());
			}
			else
			{
				$this->load->view('administration/discount_rule',$data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
		//**** Discount Rule *******
		
		
		//****** Promo Campaign ******
		
	function create_promo_campaign()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			
					
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/promo_campaign";
				$total_row = $this->Administration_model->promo_campaign_count($Company_id);		
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
					
		/*-----------------------Pagination---------------------*/
		$promo_cmp_id=0;
			if($_POST == NULL)
			{
				$data["pagination"] = $this->pagination->create_links();
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
				$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				$data["results5"] = "";
				// var_dump($data["results2"]);
				$this->load->view('administration/promo_campaign',$data);	

			}
			
			else if(isset($_POST['Upload']))
			{
				/*-----------------------File Upload---------------------*/
				
				$config['upload_path']   = dirname($_SERVER["SCRIPT_FILENAME"])."/Promo_codes/";
                $config['upload_url']   = base_url()."Promo_codes/";

				$config['allowed_types'] = 'xlsx|xls|csv';
				$config['encrypt_name'] = 'false';
				$config['overwrite'] = 'false';				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if (!$this->upload->do_upload("file"))
				{			
						$this->session->set_flashdata("error_code",'Error, Please Upload Valid File (CSV/XLS)');
						$filepath = "";
						$filename = "";
						$block_me = 0;
						
				}
				else
				{
					
					//$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "Promo_codes/".$_FILES['file']['name'];
					$filename = $_FILES['file']['name'];
					$block_me = 1;
					
					/*-----------------------File Upload---------------------*/
						$data['LogginUserName'] = $session_data['Full_name'];
						
						$promo_cmp_id = $this->Administration_model->upload_promo_campaign_file($filepath,$filename,$Company_id);
						 //echo "promo_cmp_id->".$promo_cmp_id;die;
						if($promo_cmp_id > 0 && $block_me == 1)
						{
							$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
							$this->session->set_flashdata("success_code","Promo Campaign File Uploaded Successfully!!");
							
						/******************* Nilesh Insert log Table ******************/	
							$get_company = $this->Igain_model->get_company_details($Company_id);
							$company_name = $get_company->Company_name;	
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							// $userid=$Logged_user_id;
							$what="Create Promotion Rule";
							$where="Create Promotion Rule";
							$toname="";
							// $opval = 4; // transaction type
							$To_enrollid =0;
							$firstName = $company_name;
							$lastName = '';  
							// $data['LogginUserName'] = $Seller_name;
							$Seller_name = $session_data['Full_name'];
							$opval = $this->input->post("CMPName");
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
							/******************* Nilesh Insert log Table ******************/
							
							$upload22 = $this->upload->do_upload('file');
							$data22 = $this->upload->data();
							//echo "<br>file_name****  ".$_FILES['file']['name'];
							//echo "<br>file_name****  ".$data22['file_name'];
							
							//die;
						}
						else
						{		
							$data["results3"] = "";
							$this->session->set_flashdata("error_code",'Error, Invalid Promo Code or File already exist !!!');
						}
				} 
				
				
							
				
				
			
				$data["pagination"] = $this->pagination->create_links();
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
				

				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				$data["results5"] = $this->Administration_model->promo_campaign_details($promo_cmp_id);
			
				$this->load->view('administration/promo_campaign',$data);	

			}
			else if(isset($_POST['Submit']))
			{			
			
				$result = $this->Administration_model->insert_promo_campaign($Company_id);

				if($result == true)
				{
				
				$this->session->set_flashdata("success_code","Promo Campaign Created Successfully!!");
				
			/******************* Nilesh Insert log Table ******************/
				$get_company = $this->Igain_model->get_company_details($Company_id);
				$company_name = $get_company->Company_name;	
				$Todays_date = date('Y-m-d');	
				$opration = 1;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				// $userid=$Logged_user_id;
				$what="Create Promotion Rule";
				$where="Create Promotion Rule";
				$toname="";
				// $opval = 4; // transaction type
				$To_enrollid =0;
				$firstName = $company_name;
				$lastName = '';  
				// $data['LogginUserName'] = $Seller_name;
				$Seller_name = $session_data['Full_name'];
				$opval = $this->input->post("CMPName");
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
			/******************* Nilesh Insert log Table ******************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN Promo Campaign Creation !");
				}
				$this->session->unset_userdata('error_code');




				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	
	function check_campaign_name()
	{
		$CMPName = $this->input->post('cmp_name');
		$Company_id = $this->input->post('Company_id');
		
		$promo_result = $this->Administration_model->check_campaign_name($CMPName,$Company_id);
		
		if($promo_result > 0)
		{
			$this->output->set_output(0);
		}
		else    
		{
			$this->output->set_output(1);
		}
		
	}
	function delete_promo_campaign()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/promo_campaign";
			$total_row = $this->Administration_model->promo_campaign_count($Company_id);		
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	

			$data["pagination"] = $this->pagination->create_links();
							
			/*-----------------------Pagination---------------------*/
		
			$data["pagination"] = $this->pagination->create_links();
				
			if($_REQUEST != NULL)
			{	
				$Campaign_id =  $_REQUEST['Campaign_id'];	
				// $CompID =  $_REQUEST['CompID'];	
				//$FileName =  $_REQUEST['FileName'];	
				$flag =  2;
				
				 //echo "Campaign_id ---".$Campaign_id ;
				// echo "CompID ---".$CompID ;
				// echo "flag ---".$flag ; 
				$data["results5"] = $this->Administration_model->promo_campaign_details($Campaign_id);
				foreach($data["results5"]  as $results5)
				{
					$campaign_name=$results5->Pomo_campaign_name;
				}				
				$result = $this->Administration_model->delete_promocampaign($Campaign_id,$flag);							
				if($flag == 1)	
				{
					$data["results5"] = $this->Administration_model->promo_campaign_details($Campaign_id);
					//print_r($data["results5"]);
				}
				else
				{
					$data["results5"] = "";
				}				
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);			
				$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Promo Campaign Deleted Successfuly!!");					
					/******************* Nilesh Insert log Table ******************/		
					$get_company = $this->Igain_model->get_company_details($Company_id);
					$company_name = $get_company->Company_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					// $userid=$Logged_user_id;
					$what="Delete Promotion Rule";
					$where="Create Promotion Rule";
					$toname="";
					// $opval = 4; // transaction type
					$To_enrollid =0;
					$firstName = $company_name;
					$lastName = '';  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $campaign_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/******************* Nilesh Insert log Table ******************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Promo Campaign !!");
				}
				//die;
				//$this->load->view('administration/promo_campaign',$data);
				// redirect(current_url());
				redirect('administration/create_promo_campaign');
			}
			else
			{ 
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
				$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				$data["results5"] = "";
				$this->load->view('administration/promo_campaign',$data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function show_promo_file_details()
	{
		if($this->session->userdata('logged_in'))
		{
		$session_data = $this->session->userdata('logged_in');
		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];

				
			if($_POST != NULL)
			{	
				$Campaign_id =  $this->input->post('campaign_id');	
				$CompID =  $this->input->post('comp_id');	
				$FileName = $this->input->post('file_name');	
				$flag =  $this->input->post('flagval');	

				$data['PromoDetails'] = $this->Administration_model->show_promo_file_details($Campaign_id,$CompID,$FileName,$flag);
				$theHTMLResponse = $this->load->view('administration/show_promo_file_details', $data, true);		
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('transactionDetailHtml'=> $theHTMLResponse)));
			}
			else
			{
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
		//****** Promo Campaign ******
		
		
	//******************************************sandeep end ***********************************
	
	//******************************************Akshay start ************************************


	/*************************************Communication Starts*******************************/
	function communication()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['user_id'] = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($data['Company_id']);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/communication";
			$total_row = $this->Administration_model->communication_count($session_data['Company_id'],0);	
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;			
			/*-----------------------Pagination---------------------*/
			// var_dump($_POST);
			if($_POST == NULL)
			{
				$data["results"] = $this->Administration_model->communication_offer_list($config["per_page"], $page, $session_data['Company_id'],0);			
				$data["pagination"] = $this->pagination->create_links();
				
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["company_sellers"] = $this->Igain_model->get_company_sellers($data['Company_id']);
				$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
				
				/********AMIT 24-03-2017************/ 
				$data["Segments_list"] = $this->Segment_model->Segment_list('','',$data['Company_id']);
				/******************************/
				/*************Nilesh Start 21-08-2018 Segment Handlers*************/
				// $opt = $this->Segment_model->Segment_handlers($Company_id); 
				
				
				
				/********Ravi 03-03-2020-Template variables************/ 	
					$Code_decode_type_id=22;
					$data["Template_variables"] = $this->Igain_model->get_template_variables($Code_decode_type_id,$data['Company_id']);					
				/********Ravi 03-03-2020-Template variables************/
				
				/*****************Gender wise member segment Graph******************/	
				$Sex_wise_member = $this->Segment_model->Gender_wise_member_graph($Company_id);				
				if($Sex_wise_member != 0)
				{	
					$prefix = '';
					$html = "[\n";
					
					foreach($Sex_wise_member as $row12)
					{
						$html .= $prefix . " {\n";
						$html .= '  "category": "Male Members",' . "\n";
						$html .= '  "value1": ' . $row12->Total_male_members . '' . "\n";
						$html .= " }";
						$html .= $prefix . ",\n";
						
						$html .= $prefix . " {\n";
						$html .= '  "category": "Female Members",' . "\n";
						$html .= '  "value1": ' . $row12->Total_female_members . '' . "\n";
						$html .= " }";
						$prefix = ",\n";	
						
						$html .= $prefix . " {\n";
						$html .= '  "category": "Not Mentioned Members",' . "\n";
						$html .= '  "value1": ' . $row12->Total_other_members . '' . "\n";
						$html .= " }";
						$prefix = ",\n";
					}
					
					$html .= "\n]";
					$data['Chart_data1'] = $html;				
				}
				/**********************Gender wise member Graph***********************/
				/*********City/Distribution of Customer Profile Gender wise Graph********/

				$City_wise_member = $this->Segment_model->City_wise_member_gender_graph($Company_id);
				
				if($City_wise_member != 0)
				{	
					$prefix = '';
					$html = "[\n";
					
					foreach($City_wise_member as $row13)
					{
						$City_name = $this->Segment_model->Get_city_name($row13->City_id);
						if($City_name!=NULL)
						{
							$CityName=$City_name->name;
						}
						else
						{
							$CityName="-";
						}
							
						$html .= $prefix . " {\n";
						$html .= '  "City": " '.$CityName.' ",' . "\n";
						$html .= '  "MaleMember": ' . $row13->Total_male_members . ',' . "\n";	
						$html .= '  "FemaleMember": ' . $row13->Total_female_members . ',' . "\n";
						$html .= '  "OtherMember": ' . $row13->Total_other_members . '' . "\n";
						$html .= " } ";
						$html .= $prefix . ",\n";
					}
					$html .= "\n]";
					$data['Chart_data2'] = $html;				
				}
				/*********City/Distribution of Customer Profile Gender wise Graph*******/
				/*****************Age_wise_member_profile_segment_graph**************/
				$Age_wise_member = $this->Segment_model->Age_wise_member_profile_graph($Company_id);
				
				if($Age_wise_member != 0)
				{	
					$prefix = '';
					$html = "[\n";
					
					foreach($Age_wise_member as $row14)
					{
						$City_name = $this->Segment_model->Get_city_name($row14->City_id);
						if($City_name!=NULL)
						{
							$CityName=$City_name->name;
						}
						else
						{
							$CityName="-";
						}
						
						$html .= $prefix . " {\n";
						$html .= '  "City": " '.$CityName.' ",' . "\n";
						$html .= '  "YoungMember": ' . $row14->Total_young_members . ',' . "\n";	
						$html .= '  "MiddleAgeMember": ' . $row14->Total_middle_age_members . ',' . "\n";
						$html .= '  "SeniorMember": ' . $row14->Total_senior_members . ',' . "\n";
						$html .= '  "OldMember": ' . $row14->Total_old_members . '' . "\n";
						$html .= " } ";
						$html .= $prefix . ",\n";
					}
					$html .= "\n]";
					$data['Chart_data3'] = $html;				
				}
				/****************Age_wise_member_profile_segment_graph*************/
				/*********Export graph pdf*********/
					/*	$todays2 = date("M");	$todays1 = date("d");	$todays3 = date("Y");
					$Company_details = $this->Igain_model->get_company_details($Company_id);
					$data['Graph_name'] = str_replace(" ", "_", $Company_details->Company_name).'-'.$todays1.'-'.$todays2.'-'.$todays3.'-Segment_Handlers.pdf'; */
					/*********Export graph pdf*********/
				/****************Nilesh End 27-08-2018 Segment Handlers***********************/
				
				$this->load->view('administration/communication', $data);
			}
			else
			{			
				// var_dump($_POST);
				// die;
				
				if( $this->input->post("submit") == "Register" )
				{
					
					/*-----------------------File Upload---------------------*/
					$config['upload_path'] = './Offer_images/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '800';
					$config['max_width'] = '1400';
					$config['max_height'] = '1080';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/*-----------------------File Upload---------------------*/
					
					/* if(!$this->upload->do_upload("file"))
					{			
						// $filepath = base_url()."images/no_image.jpeg";
						$filepath = "";
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = base_url()."Offer_images/".$data['upload_data']['file_name'];
					} */
					
					
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');						
						$upload77 = $this->upload->do_upload('file');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './Offer_images/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath=base_url().'Offer_images/'.$data77['file_name'];
						}
						else
						{	
							$filepath = "";			
						}
					// echo"---offerdetails----".$_REQUEST['offerdetails']."---<br>";
					$result = $this->Administration_model->insert_communication($filepath);
					if($result == true)
					{
						$this->session->set_flashdata("success_code","New Communication  Created Successfully!!");
						
						/************************Nilesh log tbl change**************************/	
							$comm_id = $result;
							$sellerId = $this->input->post('sellerId');
							$Company_id	= $session_data['Company_id'];
							$get_seller_detail = $this->Igain_model->get_enrollment_details($sellerId);
							$Enrollement_id = $get_seller_detail->Enrollement_id;	
							$First_name = $get_seller_detail->First_name;	
							$Last_name = $get_seller_detail->Last_name;	
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Create New Communication";
							$where="Draft and Send Offer";
							$toname="";
							$To_enrollid =0;
							$firstName = $First_name;
							$lastName = $Last_name;  
							$Seller_name = $session_data['Full_name'];
							$opval = $this->input->post('offer');
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$sellerId);
					
						/*******************************Nilesh log tbl change**********************************/
					}
					else
					{							
						$this->session->set_flashdata("communication_error_code","Error Inserting Communication . Please Provide valid data!!");
					}
					redirect(current_url());
					
					// redirect("Administration/communication");
				}				
				if( $this->input->post("submit") == "Send" )
				{
					$radio1 = $this->input->post("r1");			//****send single or multiple offers.	 
					$radio2 = $this->input->post("r2");			//****send to single or all or key or worry customer.	
					$sellerid = $this->input->post("sellerId");
					$compid = $this->input->post("companyId");
					$offerid = $this->input->post("activeoffer");
					$entry_date=date("Y-m-d");	
					$acitvate = '0';
					
					
					
					
					 /* var_dump($_POST);
					echo"<br><br>";
					echo"---radio1--".$radio1."---<br>";
					echo"---radio2--".$radio2."---<br>";
					echo"---sellerid--".$sellerid."---<br>";
					echo"---compid--".$compid."---<br>";
					echo"---offerid--".$offerid."---<br>"; */  
					
					
					// die;
					
					if($radio2 == 1) //**single customer
					{
						$cust_name = $this->input->post("mailtoone");
						$Enrollment_id = $this->input->post("Enrollment_id");						
						$sendto = $Enrollment_id;						
					}
					if($radio2 == 2) //**all customer
					{
						$sendto = $this->input->post("mailtoall");
					}
					if($radio2 == 3) //**key customer
					{
						$sendto = $this->input->post("mailtokey");
					}
					if($radio2 == 4) //**worry customer
					{
						$sendto = $this->input->post("mailtoworry");
					}
					if($radio2 == 5) //**Tier based customer
					{
						$sendto = $this->input->post("mailtotier");
					}
					if($radio2 == 7) //**segments
					{
						$Segment_code = $this->input->post("Segment_code");
						// echo "Segment_code ".$Segment_code;
							
						
						$Customer_array=array();
						
							$all_customers = $this->Igain_model->get_all_customers($compid);	
							foreach ($all_customers as $row)
							{
								$Applicable_array = $this->Igain_model->Segment_applicable_function($compid,$Segment_code,$row["Enrollement_id"],$row["Sex"],$row["Country_id"],$row["District"],$row["State"],$row["City"],$row["Zipcode"],$row["total_purchase"],$row["Date_of_birth"],$row["joined_date"],$row["Tier_id"]);	
								// echo "<br>Applicable_array-----";
								// print_r($Applicable_array);die;
								if(!in_array(0, $Applicable_array, true))
								{
									$Customer_array[]=$row["Enrollement_id"];
									// echo "<br>Access-----".$row["Enrollement_id"];
									if($radio1 == 3)
									{
										$offer_list = $this->input->post("offer_list");
										foreach ($offer_list as $offers)
										{
											$offer_details = $this->Administration_model->get_offer_details($offers);
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
											
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												$Link_to_voucher = $offer_details->Link_to_voucher;										
												$Voucher_array=array();
												$Vouchertype="";
												if($Link_to_voucher ==1){											
													$Voucher_type = $offer_details->Voucher_type;
													$Voucher_id = $offer_details->Voucher_id;
													$Todays_date=date("Y-m-d H:i:s");
													$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
													if($getVoucherDetails){		
														$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
														$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
														$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
														$Discount_value =$getVoucherDetails[0]['Cost_price'];
														
														foreach($getVoucherDetails as $vouchers){
															
															$Voucherid = $vouchers['Voucher_id'];
															$Voucherchildid = $vouchers['Voucher_child_id'];
															$Voucher_type = $vouchers['Voucher_type'];
															$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
															$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
															$Costprice = $vouchers['Cost_price'];
															$Costin_points = $vouchers['Cost_in_points'];
															
															$characters = '1234567890';
															$string = '';
															$Voucher_no="";
															for ($i = 0; $i < 10; $i++) 
															{
																$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
															}
															$Voucher_array[]=$Voucher_no;													
															$Post_vouchers_data=array(
																'Company_id'=>$Company_id,
																'Enrollement_id'=>$row["Enrollement_id"],
																'Voucher_id'=>$vouchers['Voucher_id'],
																'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																'Voucher_type'=>$vouchers['Voucher_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_code'=>$Voucher_no,
																'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																'Valid_from'=>$vouchers['Valid_from'],
																'Valid_till'=>$vouchers['Valid_till'],
																'Cost_price'=>$vouchers['Cost_price'],
																'Cost_in_points'=>$vouchers['Cost_in_points'],
																'Discount_percentage'=>$vouchers['Discount_percentage'],
																'Active_flag'=>$vouchers['Active_flag'],
																'Create_User_id'=>$vouchers['Create_User_id'],
																'Creation_date'=>$vouchers['Creation_date'],
																'Update_User_id'=>$vouchers['Update_User_id'],
																'Update_date'=>$vouchers['Update_date']
															);
															$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
															
															
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
															
															
														}
														if($Voucher_type==1){								
															$Vouchertype='Revenue Voucher';
														}
														if($Voucher_type==2){
															$Vouchertype='Product Voucher';
														} 
														if($Voucher_type==3){	
															$Vouchertype='Discount Voucher';
														}
													}
												}
												if(!empty($Voucher_array)) {
													$Voucher_array=$Voucher_array;
												} else{										
													$Voucher_array="";
												}
												$Code_list = implode(', ', $Voucher_array); 
												$Voucher_codes=$Code_list;
												if(!empty($Voucher_codes)) {
													$Voucher_codes=$Voucher_codes;
												} else{										
													$Voucher_codes="No Code Available";
												}												
												$Customer_name = $row["First_name"].' '.$row["Last_name"];						
												$Membership_id = $row["Card_id"];						
												$Current_balance =$row["Current_balance"] - ($row["Blocked_points"]+$row["Debit_points"]);						
												
												/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); 
												
												$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
												
												
												//24-06-2020
												$search_variables = array(
													'$Customer_name',
													'$Membership_id',
													'$Current_balance',
													'$Product_voucher',
													'$Revenue_voucher',
													'$Discount_voucher',
													'$Discount_percentage',
													'$Discount_value',
													'$Voucher_type',
													'$Start_date',
													'$End_date'
													); 
												$inserts_contents = array(
													$Customer_name,
													$Membership_id,
													$Current_balance,
													$Voucher_codes,
													$Voucher_codes,
													$Voucher_codes,
													$Discount_percentage,
													$Discount_value,
													$Vouchertype,
													$Voucher_Valid_from,
													$Voucher_Valid_till
												);
												
												
												$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											
											
								
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details_description,
												'facebook' => $this->input->post("facebook_social1"),
												'twitter' => $this->input->post("twitter_social1"),
												'googleplus' => $this->input->post("googleplus_social1"),
												'Voucher_array' => $Voucher_array,
												'Voucher_type' => $Vouchertype,
												'Template_type' => 'Communication'
											);
											
											//print_r($offer_details); echo "<br><br>";
											//print_r($Email_content);
																		
											$send_notification = $this->send_notification->send_Notification_email($row["Enrollement_id"],$Email_content,$sellerid,$compid);
											
											/*********************Nilesh log tbl Segment*************************/
												$get_cust_detail = $this->Igain_model->get_enrollment_details($row["Enrollement_id"]);
												$Enrollement_id = $get_cust_detail->Enrollement_id;	
												$First_name = $get_cust_detail->First_name;	
												$Last_name = $get_cust_detail->Last_name;
												$Company_id	= $session_data['Company_id'];
												$Todays_date = date('Y-m-d');	
												$opration = 1;		
												$enroll	= $session_data['enroll'];
												$username = $session_data['username'];
												$userid=$session_data['userId'];
												$what="Send Communication";
												$where="Draft and Send Offer";
												$To_enrollid =$Enrollement_id;
												$firstName = $First_name;
												$lastName = $Last_name;
												$Seller_name = $session_data['Full_name'];
												$opval =$offer_details->communication_plan;
												$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*********************Nilesh log tbl Segment*************************/
										}
										if($send_notification == true)
										{
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
									else
									{															
										$offer_details = $this->Administration_model->get_offer_details($offerid);
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
										
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$row["Enrollement_id"],
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
														
															
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													}
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}												
											$Customer_name = $row["First_name"].' '.$row["Last_name"];						
											$Membership_id = $row["Card_id"];						
											$Current_balance =$row["Current_balance"] - ($row["Blocked_points"]+$row["Debit_points"]);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											
											//24-06-2020
											$search_variables = array(
												'$Customer_name',
												'$Membership_id',
												'$Current_balance',
												'$Product_voucher',
												'$Revenue_voucher',
												'$Discount_voucher',
												'$Discount_percentage',
												'$Discount_value',
												'$Voucher_type',
												'$Start_date',
												'$End_date'
												); 
											$inserts_contents = array(
												$Customer_name,
												$Membership_id,
												$Current_balance,
												$Voucher_codes,
												$Voucher_codes,
												$Voucher_codes,
												$Discount_percentage,
												$Discount_value,
												$Vouchertype,
												$Voucher_Valid_from,
												$Voucher_Valid_till
											);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											

										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details_description,
											'facebook' => $this->input->post("facebook_social"),
											'twitter' => $this->input->post("twitter_social"),
											'googleplus' => $this->input->post("googleplus_social"),
											'Voucher_array' => $Voucher_array,
											'Voucher_type' => $Vouchertype,
											'Template_type' => 'Communication'
										);	
										
																
										$send_notification = $this->send_notification->send_Notification_email($row["Enrollement_id"],$Email_content,$sellerid,$compid);
										
										/*********************Nilesh log tbl Segment*************************/
										$get_cust_detail = $this->Igain_model->get_enrollment_details($row["Enrollement_id"]);
										$Enrollement_id = $get_cust_detail->Enrollement_id;	
										$First_name = $get_cust_detail->First_name;	
										$Last_name = $get_cust_detail->Last_name;
										$Company_id	= $session_data['Company_id'];
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Send Communication";
										$where="Draft and Send Offer";
										$To_enrollid =$Enrollement_id;
										$firstName = $First_name;
										$lastName = $Last_name;
										$Seller_name = $session_data['Full_name'];
										$opval =$offer_details->communication_plan;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
									/*********************Nilesh log tbl Segment*************************/
										
										
										
										
										if($send_notification == true)
										{
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											
										}
										else
										{							
											// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
									}
								}
								
							}
						
							if(count($Customer_array)==0)
							{
								$this->session->set_flashdata("communication_error_code","Error,Members not found in this Segment!!");
							}	
							//echo "count ".count($Customer_array);
							
							 redirect(current_url());
					}
					
					$company_details = $this->Igain_model->get_company_details($compid);
					$seller_details = $this->Igain_model->get_enrollment_details($sellerid);
					
					
					 echo"---radio2--".$radio2."---<br>";
					echo"---sendto--".$sendto."---<br>";
					echo"---radio1--".$radio1."---<br>"; 
					
					
					if($radio2 < 3) //****single or all customer
					{
						if($sendto > 0)   //****single customer
						{
							$customer_details = $this->Igain_model->get_enrollment_details($sendto);
							if($radio1 == 3)
							{
								
								// echo"---single customer--<br>";
								
								
								$offer_list = $this->input->post("offer_list");
								// echo"---offer_list--".print_r($offer_list)."---<br>";
								
								foreach ($offer_list as $offers)
								{
									$offer_details = $this->Administration_model->get_offer_details($offers);	
									
									$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
									$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));	

									/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										$Link_to_voucher = $offer_details->Link_to_voucher;										
										$Voucher_array=array();
										$Vouchertype="";
										if($Link_to_voucher ==1){											
											$Voucher_type = $offer_details->Voucher_type;
											$Voucher_id = $offer_details->Voucher_id;
											$Todays_date=date("Y-m-d H:i:s");
											$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
											if($getVoucherDetails){	

												$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
												$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
												
												$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
												
												$Discount_value =$getVoucherDetails[0]['Cost_price'];
												foreach($getVoucherDetails as $vouchers){
													
													$Voucherid = $vouchers['Voucher_id'];
													$Voucherchildid = $vouchers['Voucher_child_id'];
													$Voucher_type = $vouchers['Voucher_type'];
													$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
													$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
													$Costprice = $vouchers['Cost_price'];
													$Costin_points = $vouchers['Cost_in_points'];
													
													$characters = '1234567890';
													$string = '';
													$Voucher_no="";
													for ($i = 0; $i < 10; $i++) 
													{
														$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
													}
													$Voucher_array[]=$Voucher_no;													
													$Post_vouchers_data=array(
														'Company_id'=>$Company_id,
														'Enrollement_id'=>$customer_details->Enrollement_id,
														'Voucher_id'=>$vouchers['Voucher_id'],
														'Voucher_child_id'=>$vouchers['Voucher_child_id'],
														'Voucher_type'=>$vouchers['Voucher_type'],
														'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
														'Voucher_code'=>$Voucher_no,
														'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
														'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
														'Valid_from'=>$vouchers['Valid_from'],
														'Valid_till'=>$vouchers['Valid_till'],
														'Cost_price'=>$vouchers['Cost_price'],
														'Cost_in_points'=>$vouchers['Cost_in_points'],
														'Discount_percentage'=>$vouchers['Discount_percentage'],
														'Active_flag'=>$vouchers['Active_flag'],
														'Create_User_id'=>$vouchers['Create_User_id'],
														'Creation_date'=>$vouchers['Creation_date'],
														'Update_User_id'=>$vouchers['Update_User_id'],
														'Update_date'=>$vouchers['Update_date']
													);
													$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
													
													$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
													
				
												}
												if($Voucher_type==1){									
													$Vouchertype='Revenue Voucher';
												}
												if($Voucher_type==2){
													$Vouchertype='Product Voucher';
												} 
												if($Voucher_type==3){											
													$Vouchertype='Discount Voucher';
												}
											}
										}
										if(!empty($Voucher_array)) {
											$Voucher_array=$Voucher_array;
										} else{										
											$Voucher_array="";
										}
										$Code_list = implode(', ', $Voucher_array); 
										$Voucher_codes=$Code_list;
										if(!empty($Voucher_codes)) {
											$Voucher_codes=$Voucher_codes;
										} else{										
											$Voucher_codes="No Code Available";
										}
										
										$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;					
										$Membership_id = $customer_details->Card_id;					
										$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
										/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
										$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
										
										//24-06-2020
										$search_variables = array(
											'$Customer_name',
											'$Membership_id',
											'$Current_balance',
											'$Product_voucher',
											'$Revenue_voucher',
											'$Discount_voucher',
											'$Discount_percentage',
											'$Discount_value',
											'$Voucher_type',
											'$Start_date',
											'$End_date'
											); 
										$inserts_contents = array(
											$Customer_name,
											$Membership_id,
											$Current_balance,
											$Voucher_codes,
											$Voucher_codes,
											$Voucher_codes,
											$Discount_percentage,
											$Discount_value,
											$Vouchertype,
											$Voucher_Valid_from,
											$Voucher_Valid_till
										);
										
										$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);

									/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
															
									$Email_content = array(
										'Communication_id' => $offer_details->id,
										'Offer' => $offer_details->communication_plan,
										'Offer_description' => $offer_details_description,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'facebook' => $this->input->post("facebook_social1"),
										'twitter' => $this->input->post("twitter_social1"),
										'googleplus' => $this->input->post("googleplus_social1"),
										'Voucher_array' => $Voucher_array,
										'Voucher_type' => $Vouchertype,
										'Template_type' => 'Communication'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									
									/********************Nilesh log tbl change*********************/
										$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
										$Enrollement_id = $get_cust_detail->Enrollement_id;	
										$First_name = $get_cust_detail->First_name;	
										$Last_name = $get_cust_detail->Last_name;									
										$Company_id	= $session_data['Company_id'];
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Send Communication";
										$where="Draft and Send Offer";
										$To_enrollid =$Enrollement_id;
										$firstName = $First_name;
										$lastName = $Last_name;
										$Seller_name = $session_data['Full_name'];
										$opval =$offer_details->communication_plan;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
										/*******************Nilesh log tbl change************************/
								}
								if($send_notification == true)
								{
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfully!!");
								/******************Nilesh log tbl change**********************/	
									$Company_id	= $session_data['Company_id'];
									$Todays_date = date('Y-m-d');	
									$opration = 1;		
									$enroll	= $session_data['enroll'];
									$username = $session_data['username'];
									$userid=$session_data['userId'];
									$what="Send Communication";
									$where="Draft and Send Offer";
									$toname="";
									$To_enrollid =$customer_details->Enrollement_id;
									$firstName =$customer_details->First_name;
									$lastName = $customer_details->Last_name;
									$Seller_name = $session_data['Full_name'];
									$opval = $offer_details->communication_plan;
									$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
								/*********************Nilesh log tbl change***********************/
								}
								else
								{							
									// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
								
								redirect(current_url());
								
								
							}
							else
							{
								
								// echo"---single customer--2--<br>";
								// echo"---offerid--".$offerid."---<br>";
								
								$offer_details = $this->Administration_model->get_offer_details($offerid);
								
								$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
								$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
								
								/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
									$Link_to_voucher = $offer_details->Link_to_voucher;										
									$Voucher_array=array();
									$Vouchertype="";
									if($Link_to_voucher ==1){
										
										$Voucher_type = $offer_details->Voucher_type;
										$Voucher_id = $offer_details->Voucher_id;
										$Todays_date=date("Y-m-d H:i:s");
										$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
										 // echo"---getVoucherDetails----".$this->db->last_query()."---<br>";
										// var_dump($getVoucherDetails);
										
										if($getVoucherDetails){
											
											$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
											$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
											
											$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
											
											$Discount_value =$getVoucherDetails[0]['Cost_price'];
											
											foreach($getVoucherDetails as $vouchers){
												
												$Voucherid = $vouchers['Voucher_id'];
												$Voucherchildid = $vouchers['Voucher_child_id'];
												$Voucher_type = $vouchers['Voucher_type'];
												$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
												$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
												$Costprice = $vouchers['Cost_price'];
												$Costin_points = $vouchers['Cost_in_points'];
												
												// $characters = 'A123B56C89';
												$characters = '1234567890';
												$string = '';
												$Voucher_no="";
												for ($i = 0; $i < 10; $i++) 
												{
													$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
												}
												$Voucher_array[]=$Voucher_no;													
												$Post_vouchers_data=array(
													'Company_id'=>$Company_id,
													'Enrollement_id'=>$customer_details->Enrollement_id,
													'Voucher_id'=>$vouchers['Voucher_id'],
													'Voucher_child_id'=>$vouchers['Voucher_child_id'],
													'Voucher_type'=>$vouchers['Voucher_type'],
													'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
													'Voucher_code'=>$Voucher_no,
													'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
													'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
													'Valid_from'=>$vouchers['Valid_from'],
													'Valid_till'=>$vouchers['Valid_till'],
													'Cost_price'=>$vouchers['Cost_price'],
													'Cost_in_points'=>$vouchers['Cost_in_points'],
													'Discount_percentage'=>$vouchers['Discount_percentage'],
													'Active_flag'=>$vouchers['Active_flag'],
													'Create_User_id'=>$vouchers['Create_User_id'],
													'Creation_date'=>$vouchers['Creation_date'],
													'Update_User_id'=>$vouchers['Update_User_id'],
													'Update_date'=>$vouchers['Update_date']
												);
												$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);												
												
												$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
												
												
											}
											if($Voucher_type==1){									
												$Vouchertype='Revenue Voucher';
											}
											if($Voucher_type==2){
												$Vouchertype='Product Voucher';
											} 
											if($Voucher_type==3){												
												$Vouchertype='Discount Voucher';
											} 
											
										}
									}
									if(!empty($Voucher_array)) {
										$Voucher_array=$Voucher_array;
									} else{										
										$Voucher_array="";
									}
									$Code_list = implode(', ', $Voucher_array); 
									$Voucher_codes=$Code_list;
									
									if(!empty($Voucher_codes)) {
										$Voucher_codes=$Voucher_codes;
									} else{										
										$Voucher_codes="No Code Available";
									}
									
									$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;					
									$Membership_id = $customer_details->Card_id;					
									$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
									
									//24-06-2020
									$search_variables = array(
										'$Customer_name',
										'$Membership_id',
										'$Current_balance',
										'$Product_voucher',
										'$Revenue_voucher',
										'$Discount_voucher',
										'$Discount_percentage',
										'$Discount_value',
										'$Voucher_type',
										'$Start_date',
										'$End_date'
										); 
									$inserts_contents = array(
										$Customer_name,
										$Membership_id,
										$Current_balance,
										$Voucher_codes,
										$Voucher_codes,
										$Voucher_codes,
										$Discount_percentage,
										$Discount_value,
										$Vouchertype,
										$Voucher_Valid_from,
										$Voucher_Valid_till
									);
									
									$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
									
									// echo $offer_details_description;
									
								/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
								
																
								$Email_content = array(
									'Communication_id' => $offer_details->id,
									'Offer' => $offer_details->communication_plan,
									'Start_date' => $offer_From_date,
									'End_date' => $offer_Till_date,
									'Offer_description' => $offer_details_description,
									'facebook' => $this->input->post("facebook_social"),
									'twitter' => $this->input->post("twitter_social"),
									'googleplus' => $this->input->post("googleplus_social"),
									'Voucher_array' => $Voucher_array,
									'Voucher_type' => $Vouchertype,
									'Template_type' => 'Communication'
								);						
								$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
								
									/********************Nilesh log tbl change*********************/
									$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
									$Enrollement_id = $get_cust_detail->Enrollement_id;	
									$First_name = $get_cust_detail->First_name;	
									$Last_name = $get_cust_detail->Last_name;									
									$Company_id	= $session_data['Company_id'];
									$Todays_date = date('Y-m-d');	
									$opration = 1;		
									$enroll	= $session_data['enroll'];
									$username = $session_data['username'];
									$userid=$session_data['userId'];
									$what="Send Communication";
									$where="Draft and Send Offer";
									$To_enrollid =$Enrollement_id;
									$firstName = $First_name;
									$lastName = $Last_name;
									$Seller_name = $session_data['Full_name'];
									$opval =$offer_details->communication_plan;
									$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
									/*******************Nilesh log tbl change************************/
								if($send_notification == true)
								{
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfully!!");
									
								}
								else
								{							
									// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
								
								// echo"---Administration-2-".$this->db->last_query()."---<br>";
								redirect(current_url());
								
								
							}
							
							
						}
						// die;
						if($sendto == 0)   //****all customer
						{
							$cust_emails = array();
							$i=0;
							$all_customers = $this->Igain_model->get_all_customers($compid);							
							$cust_notification = array();
							
							foreach ($all_customers as $row)
							{
								$cust_emails[$i++] = $row['User_email_id'];
								$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);						
								
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									$offer_count = count($offer_list);
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
										
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));	
										
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$customer_details->Enrollement_id,
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
														
					
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													}
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}
											
											$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;					
											$Membership_id = $customer_details->Card_id;					
											$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											//24-06-2020
											$search_variables = array(
												'$Customer_name',
												'$Membership_id',
												'$Current_balance',
												'$Product_voucher',
												'$Revenue_voucher',
												'$Discount_voucher',
												'$Discount_percentage',
												'$Discount_value',
												'$Voucher_type',
												'$Start_date',
												'$End_date'
												); 
											$inserts_contents = array(
												$Customer_name,
												$Membership_id,
												$Current_balance,
												$Voucher_codes,
												$Voucher_codes,
												$Voucher_codes,
												$Discount_percentage,
												$Discount_value,
												$Vouchertype,
												$Voucher_Valid_from,
												$Voucher_Valid_till
											);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details_description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
											'Voucher_array' => $Voucher_array,
											'Voucher_type' => $Vouchertype,
											'Template_type' => 'Communication'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
										
										/********************Nilesh log tbl change*********************/
										$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
										$Enrollement_id = $get_cust_detail->Enrollement_id;	
										$First_name = $get_cust_detail->First_name;	
										$Last_name = $get_cust_detail->Last_name;									
										$Company_id	= $session_data['Company_id'];
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Send Communication";
										$where="Draft and Send Offer";
										$To_enrollid =$Enrollement_id;
										$firstName = $First_name;
										$lastName = $Last_name;
										$Seller_name = $session_data['Full_name'];
										$opval =$offer_details->communication_plan;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
										/*******************Nilesh log tbl change************************/
								
									}
								}
								else
								{
									$offer_details = $this->Administration_model->get_offer_details($offerid);
									$id = $offer_details->id;
									$communication_plan = $offer_details->communication_plan;
									$description = $offer_details->description;
							
									$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
									$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
									/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										$Link_to_voucher = $offer_details->Link_to_voucher;										
										$Voucher_array=array();
										$Vouchertype="";
										if($Link_to_voucher ==1){											
											$Voucher_type = $offer_details->Voucher_type;
											$Voucher_id = $offer_details->Voucher_id;
											$Todays_date=date("Y-m-d H:i:s");
											$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
											if($getVoucherDetails){	
												$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
												$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
												$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
												$Discount_value =$getVoucherDetails[0]['Cost_price'];
												foreach($getVoucherDetails as $vouchers){
													
													$Voucherid = $vouchers['Voucher_id'];
													$Voucherchildid = $vouchers['Voucher_child_id'];
													$Voucher_type = $vouchers['Voucher_type'];
													$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
													$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
													$Costprice = $vouchers['Cost_price'];
													$Costin_points = $vouchers['Cost_in_points'];
													
													$characters = '1234567890';
													$string = '';
													$Voucher_no="";
													for ($i = 0; $i < 10; $i++) 
													{
														$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
													}
													$Voucher_array[]=$Voucher_no;													
													$Post_vouchers_data=array(
														'Company_id'=>$Company_id,
														'Enrollement_id'=>$customer_details->Enrollement_id,
														'Voucher_id'=>$vouchers['Voucher_id'],
														'Voucher_child_id'=>$vouchers['Voucher_child_id'],
														'Voucher_type'=>$vouchers['Voucher_type'],
														'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
														'Voucher_code'=>$Voucher_no,
														'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
														'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
														'Valid_from'=>$vouchers['Valid_from'],
														'Valid_till'=>$vouchers['Valid_till'],
														'Cost_price'=>$vouchers['Cost_price'],
														'Cost_in_points'=>$vouchers['Cost_in_points'],
														'Discount_percentage'=>$vouchers['Discount_percentage'],
														'Active_flag'=>$vouchers['Active_flag'],
														'Create_User_id'=>$vouchers['Create_User_id'],
														'Creation_date'=>$vouchers['Creation_date'],
														'Update_User_id'=>$vouchers['Update_User_id'],
														'Update_date'=>$vouchers['Update_date']
													);
													$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
													
													
					
														$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
													
													
												}
												if($Voucher_type==1){									
													$Vouchertype='Revenue Voucher';
												}
												if($Voucher_type==2){
													$Vouchertype='Product Voucher';
												} 
												if($Voucher_type==3){												
													$Vouchertype='Discount Voucher';
												}
											}
										}
										if(!empty($Voucher_array)) {
											$Voucher_array=$Voucher_array;
										} else{										
											$Voucher_array="";
										}
										$Code_list = implode(', ', $Voucher_array); 
										$Voucher_codes=$Code_list;
										
										if(!empty($Voucher_codes)) {
											$Voucher_codes=$Voucher_codes;
										} else{										
											$Voucher_codes="No Code Available";
										}
										
										$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;					
										$Membership_id = $customer_details->Card_id;					
										$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
										/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
										$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
										
										//24-06-2020
										$search_variables = array(
											'$Customer_name',
											'$Membership_id',
											'$Current_balance',
											'$Product_voucher',
											'$Revenue_voucher',
											'$Discount_voucher',
											'$Discount_percentage',
											'$Discount_value',
											'$Voucher_type',
											'$Start_date',
											'$End_date'
											); 
										$inserts_contents = array(
											$Customer_name,
											$Membership_id,
											$Current_balance,
											$Voucher_codes,
											$Voucher_codes,
											$Voucher_codes,
											$Discount_percentage,
											$Discount_value,
											$Vouchertype,
											$Voucher_Valid_from,
											$Voucher_Valid_till
										);
										
										$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
									/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
									
									$Email_content = array(
										'Communication_id' => $id,
										'Offer' => $communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $offer_details_description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
										'Voucher_array' => $Voucher_array,
										'Voucher_type' => $Vouchertype,
										'Template_type' => 'Communication'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									
									/********************Nilesh log tbl change*********************/
									$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
									$Enrollement_id = $get_cust_detail->Enrollement_id;	
									$First_name = $get_cust_detail->First_name;	
									$Last_name = $get_cust_detail->Last_name;									
									$Company_id	= $session_data['Company_id'];
									$Todays_date = date('Y-m-d');	
									$opration = 1;		
									$enroll	= $session_data['enroll'];
									$username = $session_data['username'];
									$userid=$session_data['userId'];
									$what="Send Communication";
									$where="Draft and Send Offer";
									$To_enrollid =$Enrollement_id;
									$firstName = $First_name;
									$lastName = $Last_name;
									$Seller_name = $session_data['Full_name'];
									$opval =$offer_details->communication_plan;
									$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
									/*******************Nilesh log tbl change************************/
									
								}
							}
							if($radio1 == 3)
							{
								if($send_notification == true)
								{
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
								else
								{							
									// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
							}
							else
							{
								// if(count($cust_emails) == $send_notification)
								if($send_notification == true)
								{
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
								else
								{							
									// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
							}
							redirect(current_url());	
							
							// redirect("Administration/communication");						
						}
					}					
					if($radio2 == 5) //****for tier based cust
					{
						$selected_tier = $sendto;
						$useremail = array(); 
						$i=0;
						
						$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
						
						if($tier_based_customers != false)
						{
							foreach($tier_based_customers as $cust_regid)
							{
								// echo "<pre>";
								// var_dump($cust_regid);die;
								$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
								if($customer_details != NULL)
								{
									if($radio1 == 3)
									{
										$offer_list = $this->input->post("offer_list");
										foreach ($offer_list as $offers)
										{
											$offer_details = $this->Administration_model->get_offer_details($offers);
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
											
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												$Link_to_voucher = $offer_details->Link_to_voucher;										
												$Voucher_array=array();
												$Vouchertype="";
												if($Link_to_voucher ==1){											
													$Voucher_type = $offer_details->Voucher_type;
													$Voucher_id = $offer_details->Voucher_id;
													$Todays_date=date("Y-m-d H:i:s");
													$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
													if($getVoucherDetails){	
														$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
														$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
														$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
														$Discount_value =$getVoucherDetails[0]['Cost_price'];
														foreach($getVoucherDetails as $vouchers){
															
															$Voucherid = $vouchers['Voucher_id'];
															$Voucherchildid = $vouchers['Voucher_child_id'];
															$Voucher_type = $vouchers['Voucher_type'];
															$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
															$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
															$Costprice = $vouchers['Cost_price'];
															$Costin_points = $vouchers['Cost_in_points'];
															
															$characters = '1234567890';
															$string = '';
															$Voucher_no="";
															for ($i = 0; $i < 10; $i++) 
															{
																$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
															}
															$Voucher_array[]=$Voucher_no;													
															$Post_vouchers_data=array(
																'Company_id'=>$Company_id,
																'Enrollement_id'=>$customer_details->Enrollement_id,
																'Voucher_id'=>$vouchers['Voucher_id'],
																'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																'Voucher_type'=>$vouchers['Voucher_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_code'=>$Voucher_no,
																'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																'Valid_from'=>$vouchers['Valid_from'],
																'Valid_till'=>$vouchers['Valid_till'],
																'Cost_price'=>$vouchers['Cost_price'],
																'Cost_in_points'=>$vouchers['Cost_in_points'],
																'Discount_percentage'=>$vouchers['Discount_percentage'],
																'Active_flag'=>$vouchers['Active_flag'],
																'Create_User_id'=>$vouchers['Create_User_id'],
																'Creation_date'=>$vouchers['Creation_date'],
																'Update_User_id'=>$vouchers['Update_User_id'],
																'Update_date'=>$vouchers['Update_date']
															);
															$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
															
															
					
																$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
															
															
														}
														if($Voucher_type==1){									
															$Vouchertype='Revenue Voucher';
														}
														if($Voucher_type==2){
															$Vouchertype='Product Voucher';
														} 
														if($Voucher_type==3){												
															$Vouchertype='Discount Voucher';
														}
													}
												}
												if(!empty($Voucher_array)) {
													$Voucher_array=$Voucher_array;
												} else{										
													$Voucher_array="";
												}
												$Code_list = implode(', ', $Voucher_array); 
												$Voucher_codes=$Code_list;
												
												if(!empty($Voucher_codes)) {
													$Voucher_codes=$Voucher_codes;
												} else{										
													$Voucher_codes="No Code Available";
												}
												
												$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;					
												$Membership_id = $customer_details->Card_id;					
												$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);	
												
												/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
												$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
												
												//24-06-2020
												$search_variables = array(
													'$Customer_name',
													'$Membership_id',
													'$Current_balance',
													'$Product_voucher',
													'$Revenue_voucher',
													'$Discount_voucher',
													'$Discount_percentage',
													'$Discount_value',
													'$Voucher_type',
													'$Start_date',
													'$End_date'
													); 
												$inserts_contents = array(
													$Customer_name,
													$Membership_id,
													$Current_balance,
													$Voucher_codes,
													$Voucher_codes,
													$Voucher_codes,
													$Discount_percentage,
													$Discount_value,
													$Vouchertype,
													$Voucher_Valid_from,
													$Voucher_Valid_till
												);
												
												$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
								
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details_description,
												'facebook' => $this->input->post("facebook_social1"),
												'twitter' => $this->input->post("twitter_social1"),
												'googleplus' => $this->input->post("googleplus_social1"),
												'Voucher_array' => $Voucher_array,
												'Voucher_type' => $Vouchertype,
												'Template_type' => 'Communication'
											);
											
											//print_r($offer_details); echo "<br><br>";
											//print_r($Email_content);
																		
											$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											
											/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
											
				
										}
										if($send_notification == true)
										{
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
									}
									else
									{															
										$offer_details = $this->Administration_model->get_offer_details($offerid);
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
										
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$customer_details->Enrollement_id,
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
																	
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													} 
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}
											
											$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;					
											$Membership_id = $customer_details->Card_id;					
											$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											//24-06-2020
											$search_variables = array(
												'$Customer_name',
												'$Membership_id',
												'$Current_balance',
												'$Product_voucher',
												'$Revenue_voucher',
												'$Discount_voucher',
												'$Discount_percentage',
												'$Discount_value',
												'$Voucher_type',
												'$Start_date',
												'$End_date'
												); 
											$inserts_contents = array(
												$Customer_name,
												$Membership_id,
												$Current_balance,
												$Voucher_codes,
												$Voucher_codes,
												$Voucher_codes,
												$Discount_percentage,
												$Discount_value,
												$Vouchertype,
												$Voucher_Valid_from,
												$Voucher_Valid_till
											);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/

										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details_description,
											'facebook' => $this->input->post("facebook_social"),
											'twitter' => $this->input->post("twitter_social"),
											'googleplus' => $this->input->post("googleplus_social"),
											'Voucher_array' => $Voucher_array,
											'Voucher_type' => $Vouchertype,
											'Template_type' => 'Communication'
										);	
										
										//print_r($offer_details); echo "<br><br>";
										//print_r($Email_content);
																
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
										
										/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
										
										if($send_notification == true)
										{
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											
											
										}
										else
										{							
											// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
									}
								}
							}
						}
						else
						{
							// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Customers Not Exist Of This Tier!!");
							$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
						}
						redirect(current_url());
					}
					
					if($radio2 == 3) //****for key cust
					{
						$useremail = array(); 
						$i=0;
						
						foreach($this->input->post("key_worry_cust") as $cust_id)
						{
							if($cust_id==0)
							{
								$key_worry_customers = $this->Administration_model->get_key_worry_customers($sellerid,$compid,$this->input->post("r2"),$this->input->post("mailtokey"));
								
								foreach($key_worry_customers as $cust_regid)
								{
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid);
									if($customer_details != NULL)
									{
										if($radio1 == 3)
										{
											$offer_list = $this->input->post("offer_list");
											foreach ($offer_list as $offers)
											{
												$offer_details = $this->Administration_model->get_offer_details($offers);								
												
												$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
												$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
												
												/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
													$Link_to_voucher = $offer_details->Link_to_voucher;										
													$Voucher_array=array();
													$Vouchertype="";
													if($Link_to_voucher ==1){											
														$Voucher_type = $offer_details->Voucher_type;
														$Voucher_id = $offer_details->Voucher_id;
														$Todays_date=date("Y-m-d H:i:s");
														$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
														if($getVoucherDetails){	
															$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
															$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
															
															$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
															
															$Discount_value =$getVoucherDetails[0]['Cost_price'];
															foreach($getVoucherDetails as $vouchers){
																
																$Voucherid = $vouchers['Voucher_id'];
																$Voucherchildid = $vouchers['Voucher_child_id'];
																$Voucher_type = $vouchers['Voucher_type'];
																$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
																$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
																$Costprice = $vouchers['Cost_price'];
																$Costin_points = $vouchers['Cost_in_points'];
																
																$characters = '1234567890';
																$string = '';
																$Voucher_no="";
																for ($i = 0; $i < 10; $i++) 
																{
																	$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
																}
																$Voucher_array[]=$Voucher_no;													
																$Post_vouchers_data=array(
																	'Company_id'=>$Company_id,
																	'Enrollement_id'=>$customer_details->Enrollement_id,
																	'Voucher_id'=>$vouchers['Voucher_id'],
																	'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																	'Voucher_type'=>$vouchers['Voucher_type'],
																	'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																	'Voucher_code'=>$Voucher_no,
																	'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																	'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																	'Valid_from'=>$vouchers['Valid_from'],
																	'Valid_till'=>$vouchers['Valid_till'],
																	'Cost_price'=>$vouchers['Cost_price'],
																	'Cost_in_points'=>$vouchers['Cost_in_points'],
																	'Discount_percentage'=>$vouchers['Discount_percentage'],
																	'Active_flag'=>$vouchers['Active_flag'],
																	'Create_User_id'=>$vouchers['Create_User_id'],
																	'Creation_date'=>$vouchers['Creation_date'],
																	'Update_User_id'=>$vouchers['Update_User_id'],
																	'Update_date'=>$vouchers['Update_date']
																);
																$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
																
																					
																	$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
																
																
															}
															if($Voucher_type==1){							
																$Vouchertype='Revenue Voucher';
															}
															if($Voucher_type==2){
																$Vouchertype='Product Voucher';
															} 
															if($Voucher_type==3){									
																$Vouchertype='Discount Voucher';
															}
														}
													}
													if(!empty($Voucher_array)) {
														$Voucher_array=$Voucher_array;
													} else{										
														$Voucher_array="";
													}
													$Code_list = implode(', ', $Voucher_array); 
													$Voucher_codes=$Code_list;
													
													if(!empty($Voucher_codes)) {
														$Voucher_codes=$Voucher_codes;
													} else{										
														$Voucher_codes="No Code Available";
													}
													
													$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
													$Membership_id = $customer_details->Card_id;					
													$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
													
													/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
													$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
													
													//24-06-2020
													$search_variables = array(
														'$Customer_name',
														'$Membership_id',
														'$Current_balance',
														'$Product_voucher',
														'$Revenue_voucher',
														'$Discount_voucher',
														'$Discount_percentage',
														'$Discount_value',
														'$Voucher_type',
														'$Start_date',
														'$End_date'
														); 
													$inserts_contents = array(
														$Customer_name,
														$Membership_id,
														$Current_balance,
														$Voucher_codes,
														$Voucher_codes,
														$Voucher_codes,
														$Discount_percentage,
														$Discount_value,
														$Vouchertype,
														$Voucher_Valid_from,
														$Voucher_Valid_till
													);
													
													$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
												/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
									
												$Email_content = array(
													'Communication_id' => $offer_details->id,
													'Offer' => $offer_details->communication_plan,
													'Start_date' => $offer_From_date,
													'End_date' => $offer_Till_date,
													'Offer_description' => $offer_details_description,
													'facebook' => $this->input->post("facebook_social1"),
													'twitter' => $this->input->post("twitter_social1"),
													'googleplus' => $this->input->post("googleplus_social1"),
													'Voucher_array' => $Voucher_array,
													'Voucher_type' => $Vouchertype,
													'Template_type' => 'Communication'
												);	
												
																			
												$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
												
												/********************Nilesh log tbl change*********************/
												$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
												$Enrollement_id = $get_cust_detail->Enrollement_id;	
												$First_name = $get_cust_detail->First_name;	
												$Last_name = $get_cust_detail->Last_name;									
												$Company_id	= $session_data['Company_id'];
												$Todays_date = date('Y-m-d');	
												$opration = 1;		
												$enroll	= $session_data['enroll'];
												$username = $session_data['username'];
												$userid=$session_data['userId'];
												$what="Send Communication";
												$where="Draft and Send Offer";
												$To_enrollid =$Enrollement_id;
												$firstName = $First_name;
												$lastName = $Last_name;
												$Seller_name = $session_data['Full_name'];
												$opval =$offer_details->communication_plan;
												$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
												/*******************Nilesh log tbl change************************/
											
												
											}
											if($send_notification == true)
											{
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
												
											}
											else
											{							
												// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											redirect(current_url());
											// redirect("Administration/communication");
										}
										else
										{															
											$offer_details = $this->Administration_model->get_offer_details($offerid);								
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
											
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												$Link_to_voucher = $offer_details->Link_to_voucher;										
												$Voucher_array=array();
												$Vouchertype="";
												if($Link_to_voucher ==1){											
													$Voucher_type = $offer_details->Voucher_type;
													$Voucher_id = $offer_details->Voucher_id;
													$Todays_date=date("Y-m-d H:i:s");
													$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
													if($getVoucherDetails){	
														$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
														$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
														$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
														$Discount_value =$getVoucherDetails[0]['Cost_price'];
														foreach($getVoucherDetails as $vouchers){
															
															$Voucherid = $vouchers['Voucher_id'];
															$Voucherchildid = $vouchers['Voucher_child_id'];
															$Voucher_type = $vouchers['Voucher_type'];
															$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
															$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
															$Costprice = $vouchers['Cost_price'];
															$Costin_points = $vouchers['Cost_in_points'];
															
															$characters = '1234567890';
															$string = '';
															$Voucher_no="";
															for ($i = 0; $i < 10; $i++) 
															{
																$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
															}
															$Voucher_array[]=$Voucher_no;													
															$Post_vouchers_data=array(
																'Company_id'=>$Company_id,
																'Enrollement_id'=>$customer_details->Enrollement_id,
																'Voucher_id'=>$vouchers['Voucher_id'],
																'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																'Voucher_type'=>$vouchers['Voucher_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_code'=>$Voucher_no,
																'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																'Valid_from'=>$vouchers['Valid_from'],
																'Valid_till'=>$vouchers['Valid_till'],
																'Cost_price'=>$vouchers['Cost_price'],
																'Cost_in_points'=>$vouchers['Cost_in_points'],
																'Discount_percentage'=>$vouchers['Discount_percentage'],
																'Active_flag'=>$vouchers['Active_flag'],
																'Create_User_id'=>$vouchers['Create_User_id'],
																'Creation_date'=>$vouchers['Creation_date'],
																'Update_User_id'=>$vouchers['Update_User_id'],
																'Update_date'=>$vouchers['Update_date']
															);
															$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
															
															
					
																$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
															
														}
														if($Voucher_type==1){									
															$Vouchertype='Revenue Voucher';
														}
														if($Voucher_type==2){
															$Vouchertype='Product Voucher';
														} 
														if($Voucher_type==3){												
															$Vouchertype='Discount Voucher';
														}
													}
												}
												if(!empty($Voucher_array)) {
													$Voucher_array=$Voucher_array;
												} else{										
													$Voucher_array="";
												}
												$Code_list = implode(', ', $Voucher_array); 
												$Voucher_codes=$Code_list;
												
												if(!empty($Voucher_codes)) {
													$Voucher_codes=$Voucher_codes;
												} else{										
													$Voucher_codes="No Code Available";
												}
												
												$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
												$Membership_id = $customer_details->Card_id;					
												$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
												
												/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
												$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
												
												//24-06-2020
													$search_variables = array(
														'$Customer_name',
														'$Membership_id',
														'$Current_balance',
														'$Product_voucher',
														'$Revenue_voucher',
														'$Discount_voucher',
														'$Discount_percentage',
														'$Discount_value',
														'$Voucher_type',
														'$Start_date',
														'$End_date'
														); 
													$inserts_contents = array(
														$Customer_name,
														$Membership_id,
														$Current_balance,
														$Voucher_codes,
														$Voucher_codes,
														$Voucher_codes,
														$Discount_percentage,
														$Discount_value,
														$Vouchertype,
														$Voucher_Valid_from,
														$Voucher_Valid_till
													);
												
												$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details_description,
												'facebook' => $this->input->post("facebook_social"),
												'twitter' => $this->input->post("twitter_social"),
												'googleplus' => $this->input->post("googleplus_social"),
												'Voucher_array' => $Voucher_array,
												'Voucher_type' => $Vouchertype,
												'Template_type' => 'Communication'
											);							
											$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											
											/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
											
											if($send_notification == true)
											{
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
												
											}
											else
											{							
												// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											redirect(current_url());
											// redirect("Administration/communication");
										}
									}
								}
								
								redirect(current_url());
								
								// redirect("Administration/communication");
							}
							else
							{
								$customer_details = $this->Igain_model->get_enrollment_details($cust_id);							
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
											
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
											
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												$Link_to_voucher = $offer_details->Link_to_voucher;										
												$Voucher_array=array();
												$Vouchertype="";
												if($Link_to_voucher ==1){											
													$Voucher_type = $offer_details->Voucher_type;
													$Voucher_id = $offer_details->Voucher_id;
													$Todays_date=date("Y-m-d H:i:s");
													$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
													if($getVoucherDetails){
														$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
														$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
														
														$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
														
														$Discount_value =$getVoucherDetails[0]['Cost_price'];
														
														foreach($getVoucherDetails as $vouchers){
															
															$Voucherid = $vouchers['Voucher_id'];
															$Voucherchildid = $vouchers['Voucher_child_id'];
															$Voucher_type = $vouchers['Voucher_type'];
															$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
															$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
															$Costprice = $vouchers['Cost_price'];
															$Costin_points = $vouchers['Cost_in_points'];
															
															$characters = '1234567890';
															$string = '';
															$Voucher_no="";
															for ($i = 0; $i < 10; $i++) 
															{
																$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
															}
															$Voucher_array[]=$Voucher_no;													
															$Post_vouchers_data=array(
																'Company_id'=>$Company_id,
																'Enrollement_id'=>$customer_details->Enrollement_id,
																'Voucher_id'=>$vouchers['Voucher_id'],
																'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																'Voucher_type'=>$vouchers['Voucher_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_code'=>$Voucher_no,
																'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																'Valid_from'=>$vouchers['Valid_from'],
																'Valid_till'=>$vouchers['Valid_till'],
																'Cost_price'=>$vouchers['Cost_price'],
																'Cost_in_points'=>$vouchers['Cost_in_points'],
																'Discount_percentage'=>$vouchers['Discount_percentage'],
																'Active_flag'=>$vouchers['Active_flag'],
																'Create_User_id'=>$vouchers['Create_User_id'],
																'Creation_date'=>$vouchers['Creation_date'],
																'Update_User_id'=>$vouchers['Update_User_id'],
																'Update_date'=>$vouchers['Update_date']
															);
															$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
															
															
					
																$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
															
															
														}
														if($Voucher_type==1){								
															$Vouchertype='Revenue Voucher';
														}
														if($Voucher_type==2){
															$Vouchertype='Product Voucher';
														} 
														if($Voucher_type==3){												
															$Vouchertype='Discount Voucher';
														}
													}
												}
												if(!empty($Voucher_array)) {
													$Voucher_array=$Voucher_array;
												} else{										
													$Voucher_array="";
												}
												
												$Code_list = implode(', ', $Voucher_array); 
												$Voucher_codes=$Code_list;
												
												if(!empty($Voucher_codes)) {
													$Voucher_codes=$Voucher_codes;
												} else{										
													$Voucher_codes="No Code Available";
												}
												
												$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
												$Membership_id = $customer_details->Card_id;					
												$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
												
												/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
												$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
												
												//24-06-2020
												$search_variables = array(
													'$Customer_name',
													'$Membership_id',
													'$Current_balance',
													'$Product_voucher',
													'$Revenue_voucher',
													'$Discount_voucher',
													'$Discount_percentage',
													'$Discount_value',
													'$Voucher_type',
													'$Start_date',
													'$End_date'
													); 
												$inserts_contents = array(
													$Customer_name,
													$Membership_id,
													$Current_balance,
													$Voucher_codes,
													$Voucher_codes,
													$Voucher_codes,
													$Discount_percentage,
													$Discount_value,
													$Vouchertype,
													$Voucher_Valid_from,
													$Voucher_Valid_till
												);
												
												$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details_description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
											'Voucher_array' => $Voucher_array,
											'Voucher_type' => $Vouchertype,
											'Template_type' => 'Communication'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
										
										/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
										
									
									}
									if($send_notification == true)
									{
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{							
										// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									redirect(current_url());
									// redirect("Administration/communication");
								}
								else
								{															
									$offer_details = $this->Administration_model->get_offer_details($offerid);								
										
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$customer_details->Enrollement_id,
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
																			
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													}
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}
											
											$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
											$Membership_id = $customer_details->Card_id;					
											$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											//24-06-2020
											$search_variables = array(
												'$Customer_name',
												'$Membership_id',
												'$Current_balance',
												'$Product_voucher',
												'$Revenue_voucher',
												'$Discount_voucher',
												'$Discount_percentage',
												'$Discount_value',
												'$Voucher_type',
												'$Start_date',
												'$End_date'
												); 
											$inserts_contents = array(
												$Customer_name,
												$Membership_id,
												$Current_balance,
												$Voucher_codes,
												$Voucher_codes,
												$Voucher_codes,
												$Discount_percentage,
												$Discount_value,
												$Vouchertype,
												$Voucher_Valid_from,
												$Voucher_Valid_till
											);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
									
										
										$Email_content = array(
										'Communication_id' => $offer_details->id,
										'Offer' => $offer_details->communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $offer_details_description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
										'Voucher_array' => $Voucher_array,
										'Voucher_type' => $Vouchertype,
										'Template_type' => 'Communication'
									);							
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									
										/********************Nilesh log tbl change*********************/
										$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
										$Enrollement_id = $get_cust_detail->Enrollement_id;	
										$First_name = $get_cust_detail->First_name;	
										$Last_name = $get_cust_detail->Last_name;									
										$Company_id	= $session_data['Company_id'];
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Send Communication";
										$where="Draft and Send Offer";
										$To_enrollid =$Enrollement_id;
										$firstName = $First_name;
										$lastName = $Last_name;
										$Seller_name = $session_data['Full_name'];
										$opval =$offer_details->communication_plan;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
										/*******************Nilesh log tbl change************************/
									
									if($send_notification == true)
									{
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{							
										// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									redirect(current_url());
									// redirect("Administration/communication");
								}
							}
						}
						redirect(current_url());
						// redirect("Administration/communication");
					}					
					if($radio2 == 4) //****for worry cust
					{
						$useremail = array(); 
						$i=0;
						
						foreach($this->input->post("key_worry_cust") as $cust_id)
						{
							if($cust_id==0)
							{
								$key_worry_customers = $this->Administration_model->get_key_worry_customers($sellerid,$compid,$this->input->post("r2"),$this->input->post("mailtoworry"));
								
								foreach($key_worry_customers as $cust_regid)
								{
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid);
									if($customer_details != NULL)
									{
										if($radio1 == 3)
										{
											$offer_list = $this->input->post("offer_list");
											foreach ($offer_list as $offers)
											{
												$offer_details = $this->Administration_model->get_offer_details($offers);								
												$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
												$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
													
												/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
													$Link_to_voucher = $offer_details->Link_to_voucher;										
													$Voucher_array=array();
													$Vouchertype="";
													if($Link_to_voucher ==1){											
														$Voucher_type = $offer_details->Voucher_type;
														$Voucher_id = $offer_details->Voucher_id;
														$Todays_date=date("Y-m-d H:i:s");
														$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
														if($getVoucherDetails){
															$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
															$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
															$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
															$Discount_value =$getVoucherDetails[0]['Cost_price'];
															
															foreach($getVoucherDetails as $vouchers){
																
																$Voucherid = $vouchers['Voucher_id'];
																$Voucherchildid = $vouchers['Voucher_child_id'];
																$Voucher_type = $vouchers['Voucher_type'];
																$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
																$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
																$Costprice = $vouchers['Cost_price'];
																$Costin_points = $vouchers['Cost_in_points'];
																
																$characters = '1234567890';
																$string = '';
																$Voucher_no="";
																for ($i = 0; $i < 10; $i++) 
																{
																	$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
																}
																$Voucher_array[]=$Voucher_no;													
																$Post_vouchers_data=array(
																	'Company_id'=>$Company_id,
																	'Enrollement_id'=>$customer_details->Enrollement_id,
																	'Voucher_id'=>$vouchers['Voucher_id'],
																	'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																	'Voucher_type'=>$vouchers['Voucher_type'],
																	'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																	'Voucher_code'=>$Voucher_no,
																	'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																	'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																	'Valid_from'=>$vouchers['Valid_from'],
																	'Valid_till'=>$vouchers['Valid_till'],
																	'Cost_price'=>$vouchers['Cost_price'],
																	'Cost_in_points'=>$vouchers['Cost_in_points'],
																	'Discount_percentage'=>$vouchers['Discount_percentage'],
																	'Active_flag'=>$vouchers['Active_flag'],
																	'Create_User_id'=>$vouchers['Create_User_id'],
																	'Creation_date'=>$vouchers['Creation_date'],
																	'Update_User_id'=>$vouchers['Update_User_id'],
																	'Update_date'=>$vouchers['Update_date']
																);
																$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
																
																					
																	$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
																
															}
															if($Voucher_type==1){									
																$Vouchertype='Revenue Voucher';
															}
															if($Voucher_type==2){
																$Vouchertype='Product Voucher';
															} 
															if($Voucher_type==3){												
																$Vouchertype='Discount Voucher';
															}
														}
													}
													if(!empty($Voucher_array)) {
														$Voucher_array=$Voucher_array;
													} else{										
														$Voucher_array="";
													}
													$Code_list = implode(', ', $Voucher_array); 
													$Voucher_codes=$Code_list;
													
													if(!empty($Voucher_codes)) {
														$Voucher_codes=$Voucher_codes;
													} else{										
														$Voucher_codes="No Code Available";
													}
													
													$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
													$Membership_id = $customer_details->Card_id;					
													$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
													
													/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
													$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till);
													 */
													//24-06-2020
													$search_variables = array(
														'$Customer_name',
														'$Membership_id',
														'$Current_balance',
														'$Product_voucher',
														'$Revenue_voucher',
														'$Discount_voucher',
														'$Discount_percentage',
														'$Discount_value',
														'$Voucher_type',
														'$Start_date',
														'$End_date'
														); 
													$inserts_contents = array(
														$Customer_name,
														$Membership_id,
														$Current_balance,
														$Voucher_codes,
														$Voucher_codes,
														$Voucher_codes,
														$Discount_percentage,
														$Discount_value,
														$Vouchertype,
														$Voucher_Valid_from,
														$Voucher_Valid_till
													);
													$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
												/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												
												
											$Email_content = array(
													'Communication_id' => $offer_details->id,
													'Offer' => $offer_details->communication_plan,
													'Start_date' => $offer_From_date,
													'End_date' => $offer_Till_date,
													'Offer_description' => $offer_details_description,
													'facebook' => $this->input->post("facebook_social1"),
													'twitter' => $this->input->post("twitter_social1"),
													'googleplus' => $this->input->post("googleplus_social1"),
													'Voucher_array' => $Voucher_array,
													'Voucher_type' => $Vouchertype,
													'Template_type' => 'Communication'
												);								
												$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
												
												/********************Nilesh log tbl change*********************/
												$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
												$Enrollement_id = $get_cust_detail->Enrollement_id;	
												$First_name = $get_cust_detail->First_name;	
												$Last_name = $get_cust_detail->Last_name;									
												$Company_id	= $session_data['Company_id'];
												$Todays_date = date('Y-m-d');	
												$opration = 1;		
												$enroll	= $session_data['enroll'];
												$username = $session_data['username'];
												$userid=$session_data['userId'];
												$what="Send Communication";
												$where="Draft and Send Offer";
												$To_enrollid =$Enrollement_id;
												$firstName = $First_name;
												$lastName = $Last_name;
												$Seller_name = $session_data['Full_name'];
												$opval =$offer_details->communication_plan;
												$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
												/*******************Nilesh log tbl change************************/
												
											}
											if($send_notification == true)
											{
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");												
											
											}
											else
											{							
												// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											redirect(current_url());
											// redirect("Administration/communication");
										}
										else
										{															
											$offer_details = $this->Administration_model->get_offer_details($offerid);								
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
											
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												$Link_to_voucher = $offer_details->Link_to_voucher;										
												$Voucher_array=array();
												$Vouchertype="";
												if($Link_to_voucher ==1){											
													$Voucher_type = $offer_details->Voucher_type;
													$Voucher_id = $offer_details->Voucher_id;
													$Todays_date=date("Y-m-d H:i:s");
													$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
													if($getVoucherDetails){
														$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
														$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
														
														$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
														
														$Discount_value =$getVoucherDetails[0]['Cost_price'];
														
														foreach($getVoucherDetails as $vouchers){
															
															$Voucherid = $vouchers['Voucher_id'];
															$Voucherchildid = $vouchers['Voucher_child_id'];
															$Voucher_type = $vouchers['Voucher_type'];
															$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
															$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
															$Costprice = $vouchers['Cost_price'];
															$Costin_points = $vouchers['Cost_in_points'];
															
															$characters = '1234567890';
															$string = '';
															$Voucher_no="";
															for ($i = 0; $i < 10; $i++) 
															{
																$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
															}
															$Voucher_array[]=$Voucher_no;													
															$Post_vouchers_data=array(
																'Company_id'=>$Company_id,
																'Enrollement_id'=>$customer_details->Enrollement_id,
																'Voucher_id'=>$vouchers['Voucher_id'],
																'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																'Voucher_type'=>$vouchers['Voucher_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_code'=>$Voucher_no,
																'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																'Valid_from'=>$vouchers['Valid_from'],
																'Valid_till'=>$vouchers['Valid_till'],
																'Cost_price'=>$vouchers['Cost_price'],
																'Cost_in_points'=>$vouchers['Cost_in_points'],
																'Discount_percentage'=>$vouchers['Discount_percentage'],
																'Active_flag'=>$vouchers['Active_flag'],
																'Create_User_id'=>$vouchers['Create_User_id'],
																'Creation_date'=>$vouchers['Creation_date'],
																'Update_User_id'=>$vouchers['Update_User_id'],
																'Update_date'=>$vouchers['Update_date']
															);
															$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
															
															
					
																$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
															
														}
														if($Voucher_type==1){									
															$Vouchertype='Revenue Voucher';
														}
														if($Voucher_type==2){
															$Vouchertype='Product Voucher';
														} 
														if($Voucher_type==3){												
															$Vouchertype='Discount Voucher';
														} 
													}
												}
												if(!empty($Voucher_array)) {
													$Voucher_array=$Voucher_array;
												} else{										
													$Voucher_array="";
												}
												$Code_list = implode(', ', $Voucher_array); 
												$Voucher_codes=$Code_list;
												
												if(!empty($Voucher_codes)) {
													$Voucher_codes=$Voucher_codes;
												} else{										
													$Voucher_codes="No Code Available";
												}
												
												$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
												$Membership_id = $customer_details->Card_id;					
												$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
												
												/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
												$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
												
												//24-06-2020
												$search_variables = array(
													'$Customer_name',
													'$Membership_id',
													'$Current_balance',
													'$Product_voucher',
													'$Revenue_voucher',
													'$Discount_voucher',
													'$Discount_percentage',
													'$Discount_value',
													'$Voucher_type',
													'$Start_date',
													'$End_date'
													); 
												$inserts_contents = array(
													$Customer_name,
													$Membership_id,
													$Current_balance,
													$Voucher_codes,
													$Voucher_codes,
													$Voucher_codes,
													$Discount_percentage,
													$Discount_value,
													$Vouchertype,
													$Voucher_Valid_from,
													$Voucher_Valid_till
												);
												
												$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
									
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details_description,
												'facebook' => $this->input->post("facebook_social"),
												'twitter' => $this->input->post("twitter_social"),
												'googleplus' => $this->input->post("googleplus_social"),
												'Voucher_array' => $Voucher_array,
												'Voucher_type' => $Vouchertype,
												'Template_type' => 'Communication'
											);								
											$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											
											/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
											
											if($send_notification == true)
											{
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
												
											
											}
											else
											{							
												// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											redirect(current_url());
											// redirect("Administration/communication");
										}
									}
								}
								
								
								redirect(current_url());
								
								// redirect("Administration/communication");
							}
							else
							{
								$customer_details = $this->Igain_model->get_enrollment_details($cust_id);							
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$customer_details->Enrollement_id,
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
																			
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													} 
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}
											
											$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
											$Membership_id = $customer_details->Card_id;					
											$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											//24-06-2020
												$search_variables = array(
													'$Customer_name',
													'$Membership_id',
													'$Current_balance',
													'$Product_voucher',
													'$Revenue_voucher',
													'$Discount_voucher',
													'$Discount_percentage',
													'$Discount_value',
													'$Voucher_type',
													'$Start_date',
													'$End_date'
													); 
												$inserts_contents = array(
													$Customer_name,
													$Membership_id,
													$Current_balance,
													$Voucher_codes,
													$Voucher_codes,
													$Voucher_codes,
													$Discount_percentage,
													$Discount_value,
													$Vouchertype,
													$Voucher_Valid_from,
													$Voucher_Valid_till
												);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
											$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details_description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
											'Voucher_array' => $Voucher_array,
											'Voucher_type' => $Vouchertype,
											'Template_type' => 'Communication'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
										
											/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
				
									}
									if($send_notification == true)
									{
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										
									}
									else
									{							
										// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									redirect(current_url());
									// redirect("Administration/communication");
								}
								else
								{															
									$offer_details = $this->Administration_model->get_offer_details($offerid);								
									$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
									$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$customer_details->Enrollement_id,
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
														
					
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													} 
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}
											
											$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;		
											$Membership_id = $customer_details->Card_id;					
											$Current_balance = $customer_details->Current_balance-($customer_details->Blocked_points+$customer_details->Debit_points);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											//24-06-2020
												$search_variables = array(
													'$Customer_name',
													'$Membership_id',
													'$Current_balance',
													'$Product_voucher',
													'$Revenue_voucher',
													'$Discount_voucher',
													'$Discount_percentage',
													'$Discount_value',
													'$Voucher_type',
													'$Start_date',
													'$End_date'
													); 
												$inserts_contents = array(
													$Customer_name,
													$Membership_id,
													$Current_balance,
													$Voucher_codes,
													$Voucher_codes,
													$Voucher_codes,
													$Discount_percentage,
													$Discount_value,
													$Vouchertype,
													$Voucher_Valid_from,
													$Voucher_Valid_till
												);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
										$Email_content = array(
										'Communication_id' => $offer_details->id,
										'Offer' => $offer_details->communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $offer_details_description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
										'Voucher_array' => $Voucher_array,
										'Voucher_type' => $Vouchertype,
										'Template_type' => 'Communication'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									
										/********************Nilesh log tbl change*********************/
										$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
										$Enrollement_id = $get_cust_detail->Enrollement_id;	
										$First_name = $get_cust_detail->First_name;	
										$Last_name = $get_cust_detail->Last_name;									
										$Company_id	= $session_data['Company_id'];
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Send Communication";
										$where="Draft and Send Offer";
										$To_enrollid =$Enrollement_id;
										$firstName = $First_name;
										$lastName = $Last_name;
										$Seller_name = $session_data['Full_name'];
										$opval =$offer_details->communication_plan;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
										/*******************Nilesh log tbl change************************/
									
									if($send_notification == true)
									{
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{							
										// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
						// redirect("Administration/communication");
					}
					if($radio2 == 6) //****Hobbies/Intrested Members
					{
						$cust_emails = array();
							$i=0;
							$all_customers = $this->Administration_model->get_all_hobbie_customers($compid);							
							$cust_notification = array();
							
							foreach ($all_customers as $row)
							{
								$cust_emails[$i++] = $row['User_email_id'];
								//$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);							
								
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									$offer_count = count($offer_list);
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
										
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
										$offer_hobbie_id = $offer_details->Hobbie_id;
										
										if($offer_hobbie_id == $row['Hobbie_id'])
										{
											
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
												$Link_to_voucher = $offer_details->Link_to_voucher;										
												$Voucher_array=array();
												$Vouchertype="";
												if($Link_to_voucher ==1){											
													$Voucher_type = $offer_details->Voucher_type;
													$Voucher_id = $offer_details->Voucher_id;
													$Todays_date=date("Y-m-d H:i:s");
													$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
													if($getVoucherDetails){	
														$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
														$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
														$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
														$Discount_value =$getVoucherDetails[0]['Cost_price'];
														foreach($getVoucherDetails as $vouchers){
															
															$Voucherid = $vouchers['Voucher_id'];
															$Voucherchildid = $vouchers['Voucher_child_id'];
															$Voucher_type = $vouchers['Voucher_type'];
															$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
															$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
															$Costprice = $vouchers['Cost_price'];
															$Costin_points = $vouchers['Cost_in_points'];
															
															$characters = '1234567890';
															$string = '';
															$Voucher_no="";
															for ($i = 0; $i < 10; $i++) 
															{
																$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
															}
															$Voucher_array[]=$Voucher_no;													
															$Post_vouchers_data=array(
																'Company_id'=>$Company_id,
																'Enrollement_id'=>$customer_details->Enrollement_id,
																'Voucher_id'=>$vouchers['Voucher_id'],
																'Voucher_child_id'=>$vouchers['Voucher_child_id'],
																'Voucher_type'=>$vouchers['Voucher_type'],
																'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
																'Voucher_code'=>$Voucher_no,
																'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
																'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
																'Valid_from'=>$vouchers['Valid_from'],
																'Valid_till'=>$vouchers['Valid_till'],
																'Cost_price'=>$vouchers['Cost_price'],
																'Cost_in_points'=>$vouchers['Cost_in_points'],
																'Discount_percentage'=>$vouchers['Discount_percentage'],
																'Active_flag'=>$vouchers['Active_flag'],
																'Create_User_id'=>$vouchers['Create_User_id'],
																'Creation_date'=>$vouchers['Creation_date'],
																'Update_User_id'=>$vouchers['Update_User_id'],
																'Update_date'=>$vouchers['Update_date']
															);
															$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
															
															
					
																$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
															
															
														}
														if($Voucher_type==1){									
															$Vouchertype='Revenue Voucher';
														}
														if($Voucher_type==2){
															$Vouchertype='Product Voucher';
														} 
														if($Voucher_type==3){												
															$Vouchertype='Discount Voucher';
														} 
													}
												}
												if(!empty($Voucher_array)) {
													$Voucher_array=$Voucher_array;
												} else{										
													$Voucher_array="";
												}
												$Code_list = implode(', ', $Voucher_array); 
												$Voucher_codes=$Code_list;
												
												if(!empty($Voucher_codes)) {
													$Voucher_codes=$Voucher_codes;
												} else{										
													$Voucher_codes="No Code Available";
												}
												
												$Customer_name = $row['First_name'].' '.$row['Last_name'];		
												$Membership_id = $row['Card_id'];					
												$Current_balance =  $row['Current_balance']-($row['Blocked_points']+$row['Debit_points']);						
												/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
												$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
												
												//24-06-2020
													$search_variables = array(
														'$Customer_name',
														'$Membership_id',
														'$Current_balance',
														'$Product_voucher',
														'$Revenue_voucher',
														'$Discount_voucher',
														'$Discount_percentage',
														'$Discount_value',
														'$Voucher_type',
														'$Start_date',
														'$End_date'
														); 
													$inserts_contents = array(
														$Customer_name,
														$Membership_id,
														$Current_balance,
														$Voucher_codes,
														$Voucher_codes,
														$Voucher_codes,
														$Discount_percentage,
														$Discount_value,
														$Vouchertype,
														$Voucher_Valid_from,
														$Voucher_Valid_till
													);
												
												$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
											/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
										
											$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details_description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
											'Voucher_array' => $Voucher_array,
											'Voucher_type' => $Vouchertype,
											'Template_type' => 'Communication'
											);								
											$send_notification = $this->send_notification->send_Notification_email($row['Enrollement_id'],$Email_content,$sellerid,$compid);
										
											/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
										
										}
									}
								}
								else
								{
									$offer_details = $this->Administration_model->get_offer_details($offerid);
									$id = $offer_details->id;
									$communication_plan = $offer_details->communication_plan;
									$description = $offer_details->description;
							
									$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
									$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									$offer_hobbie_id = $offer_details->Hobbie_id;
									
									if($offer_hobbie_id == $row['Hobbie_id'])
									{
										
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											$Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												$Voucher_type = $offer_details->Voucher_type;
												$Voucher_id = $offer_details->Voucher_id;
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date);
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_id,
															'Enrollement_id'=>$customer_details->Enrollement_id,
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
														
					
															$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
														
													}
													
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													}
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}
											
											$Customer_name = $row['First_name'].' '.$row['Last_name'];		
											$Membership_id = $row['Card_id'];					
											$Current_balance =  $row['Current_balance']-($row['Blocked_points']+$row['Debit_points']);						
										
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											//24-06-2020
											$search_variables = array(
												'$Customer_name',
												'$Membership_id',
												'$Current_balance',
												'$Product_voucher',
												'$Revenue_voucher',
												'$Discount_voucher',
												'$Discount_percentage',
												'$Discount_value',
												'$Voucher_type',
												'$Start_date',
												'$End_date'
												); 
											$inserts_contents = array(
												$Customer_name,
												$Membership_id,
												$Current_balance,
												$Voucher_codes,
												$Voucher_codes,
												$Voucher_codes,
												$Discount_percentage,
												$Discount_value,
												$Vouchertype,
												$Voucher_Valid_from,
												$Voucher_Valid_till
											);
											
											$offer_details_description = str_replace($search_variables, $inserts_contents, $offer_details->description);
										/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
										
										$Email_content = array(
										'Communication_id' => $id,
										'Offer' => $communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $offer_details_description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
										'Voucher_array' => $Voucher_array,
										'Voucher_type' => $Vouchertype,
										'Template_type' => 'Communication'
										);	
																
										$send_notification = $this->send_notification->send_Notification_email($row['Enrollement_id'],$Email_content,$sellerid,$compid);
										
											/********************Nilesh log tbl change*********************/
											$get_cust_detail = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;									
											$Company_id	= $session_data['Company_id'];
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											$what="Send Communication";
											$where="Draft and Send Offer";
											$To_enrollid =$Enrollement_id;
											$firstName = $First_name;
											$lastName = $Last_name;
											$Seller_name = $session_data['Full_name'];
											$opval =$offer_details->communication_plan;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
											/*******************Nilesh log tbl change************************/
									
									}
								}
							}

								if($radio1 == 3)
								{
									if($send_notification == true)
									{
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									
										$Company_id	= $session_data['Company_id'];
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Send Communication";
										$where="Draft and Send Offer";
										$To_enrollid =0;
										$firstName = 'All Customer';
										$lastName = '';
										$Seller_name = $session_data['Full_name'];
										$opval = $offer_details->communication_plan;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
									}
									else
									{							
										// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
								
								}
								else
								{
									if($send_notification == true)
									{
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{							
										// $this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
								}							
						redirect(current_url());
						
						// redirect("Administration/communication");
					}
				}
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function edit_communication_offer()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['user_id'] = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			if(isset($_REQUEST["SMS"]))
			{
				$total_row = $this->Administration_model->communication_count($session_data['Company_id'],1);
			}
			else
			{
				$total_row = $this->Administration_model->communication_count($session_data['Company_id'],0);
			}				
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/communication";
				
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;			
			/*-----------------------Pagination---------------------*/
			if(isset($_REQUEST["SMS"]))
			{
				$data["results"] = $this->Administration_model->communication_offer_list($config["per_page"], $page, $session_data['Company_id'],1);
			}
			else
			{
				$data["results"] = $this->Administration_model->communication_offer_list($config["per_page"], $page, $session_data['Company_id'],0);
			}
						
			$data["pagination"] = $this->pagination->create_links();
				
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["company_sellers"] = $this->Igain_model->get_company_sellers($data['Company_id']);
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			$data["Segments_list"] = $this->Segment_model->Segment_list('','',$data['Company_id']);
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($data['Company_id']);	
			
			/********Ravi 03-03-2020-Template variables************/ 	
					$Code_decode_type_id=22;
					$data["Template_variables"] = $this->Igain_model->get_template_variables($Code_decode_type_id,$data['Company_id']);					
			/********Ravi 03-03-2020-Template variables************/
			
			if($_GET == NULL)
			{
				redirect('Administration/communication');
			}
			else
			{				
				$id =  $_GET['id'];
				$seller_id =  $_GET['seller_id'];
				$data['Offer_details'] = $this->Administration_model->edit_communication_offer($id);				
				foreach($data['Offer_details'] as $offer)
				{
					$Company_id = $offer->Company_id;
					$Membership_id = $offer->Membership_id;
				}
				if($Membership_id > 0)
				{
					$Membership_details = $this->Igain_model->get_customer_details_Card_id($Membership_id,$Company_id);
					$data['member_name']=$Membership_details->First_name.' '.$Membership_details->Last_name;
					$data['member_email']=App_string_decrypt($Membership_details->User_email_id);				
					$data['member_phone']=App_string_decrypt($Membership_details->Phone_no);					
					$data['Enrollment_id']=$Membership_details->Enrollement_id;					
				}
				if(isset($_REQUEST["SMS"]))
				{
					$this->load->view('administration/SMS_edit_communication', $data);
				}
				else
				{
					$this->load->view('administration/edit_communication', $data);
				}
				 
			}
		}
	}	
	function update_communication()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['user_id'] = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			
			/*-----------------------File Upload---------------------*/
				$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/Offer_images/';
				$config['upload_url']   = base_url()."Offer_images/";
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '5000';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = false;	
				//$config['overwrite'] = 'true';	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				 
				if (!$this->upload->do_upload("file"))
				{			
						$filepath = $this->input->post("Share_file_path");	
						
						
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = base_url()."Offer_images/".$_FILES['file']['name'];
					$filename = $_FILES['file']['name'];
					//echo $filepath;die;
				}
				
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();
			
			
			$result = $this->Administration_model->update_communication_offer($filepath);
			$this->session->set_flashdata("communication_error_code","Communication  Updated Successfully!!");
			
			/******************igain log_tbl insert*********************/	
				$communication_id = $this->input->post('communication_id');
				$sellerId = $this->input->post('sellerId');
				$Company_id	= $session_data['Company_id'];
				$get_seller_detail = $this->Igain_model->get_enrollment_details($sellerId);
				$Enrollement_id = $get_seller_detail->Enrollement_id;	
				$First_name = $get_seller_detail->First_name;	
				$Last_name = $get_seller_detail->Last_name;	
				$Todays_date = date('Y-m-d');	
				$opration = 2;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				$what="Update Communication";
				$where="Draft and Send Offer";
				$To_enrollid =0;
				$firstName = $First_name;
				$lastName = $Last_name;  
				$Seller_name = $session_data['Full_name'];
				$opval = $this->input->post('offer');
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
			/******************igain log_tbl insert*********************/		
			
			/* if($result == true)
			{
				$this->session->set_flashdata("communication_error_code","Communication  Updated Successfuly!!");
			}
			else
			{
				$this->session->set_flashdata("communication_error_code","Error Updating Communication !!");
			}
			 */
			if($this->input->post('Comm_type')==1)//SMS Communication
			{
				redirect('Administration/SMS_communication');
			}
			redirect('Administration/communication');

			//redirect(current_url());	
		}
	}
		
	public function delete_communication_offer()
	{
		if($this->session->userdata('logged_in'))
		{	
			
			if($_REQUEST == NULL)
			{
				redirect('Administration/communication');
			}
			else
			{ 
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['enroll'] = $session_data['enroll'];
		
		
		
				$id =  $_REQUEST['id'];
				$path =  $_REQUEST['path'];
				
				
				
				$data['Offer_details'] = $this->Administration_model->edit_communication_offer($id);				
				foreach($data['Offer_details'] as $offer)
				{
					// $Company_id = $offer->Company_id;
					$communication_plan = $offer->communication_plan;
				}
				
				
				$result = $this->Administration_model->delete_communication_offer($id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Communication  Deleted Successfuly!!");
					/******************igain log_tbl insert*********************/
					$id =  $_REQUEST['id'];
					$seller_id =  $data['enroll'];
					$session_data = $this->session->userdata('logged_in');	
					$Company_id	= $session_data['Company_id'];
					$get_seller_detail = $this->Igain_model->get_enrollment_details($seller_id);
					$Enrollement_id = $get_seller_detail->Enrollement_id;	
					$First_name = $get_seller_detail->First_name;	
					$Last_name = $get_seller_detail->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Communication";
					$where="Draft and Send Offer";
					$To_enrollid =0;
					$firstName = $First_name;
					$lastName = $Last_name;  
					$Seller_name = $session_data['Full_name'];
					$opval = $communication_plan;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
					/******************igain log_tbl insert*********************/		
				
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Communication !!");
				}
				
				
					redirect($path);
				
			}
		}
	}
	
	public function communication_acivate_deactivate()
	{
		if($this->session->userdata('logged_in'))
		{
			if($_REQUEST == NULL)
			{
				redirect('Administration/communication', 'refresh');
			}
			else
			{	
				$id =  $_REQUEST['id'];
				$seller_id =  $_REQUEST['seller_id'];
				$activate =  $_REQUEST['activate'];				
				$result = $this->Administration_model->communication_acivate_deactivate($id,$seller_id,$activate);				
				if($result == true)
				{
					$this->session->set_flashdata("communication_error_code","Communication Activated / Deactivated Successfuly!!");
					
					$session_data = $this->session->userdata('logged_in');
					$sellerId = $this->input->post('sellerId');
					$offer = $this->input->post('offer');	
					$Company_id	= $session_data['Company_id'];
					$get_seller_detail = $this->Igain_model->get_enrollment_details($seller_id);
					$Enrollement_id = $get_seller_detail->Enrollement_id;	
					$First_name = $get_seller_detail->First_name;	
					$Last_name = $get_seller_detail->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Active / Inactive";
					$where="Draft and Send Offer";
					$To_enrollid =0;
					$firstName = $First_name;
					$lastName = $Last_name;  
					$Seller_name = $session_data['Full_name'];
					$opval = $activate;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
				}
				else
				{
					$this->session->set_flashdata("communication_error_code","Error Activating / Deactivating Communication !!");
				}
				if(isset($_REQUEST["SMS"]))
				{
					redirect('Administration/SMS_communication');
				}				
				redirect('Administration/communication');
			}
		}
	}
	
	public function check_communication_offer()
	{
		$result = $this->Administration_model->check_communication_offer($this->input->post("communication_plan"),$this->input->post("Seller_id"));
		if($result > 0)
		{
			$this->output->set_output(0);
		}
		else    
		{
			$this->output->set_output(1);
		}
	}
	
	public function get_communication_offers()
	{
		$data['communication_offers_array'] = $this->Administration_model->get_communication_offers($this->input->post("Seller_id"),$this->input->post("Company_id"),$this->input->post("Comm_type"));
		$this->load->view('administration/get_communication_offers',$data);	
	}
	public function get_key_worry_customers()
	{
		$data['key_worry_customers'] = $this->Administration_model->get_key_worry_customers($this->input->post("Seller_id"),$this->input->post("Company_id"),$this->input->post("r2Value"),$this->input->post("mailtokey"));
		// var_dump($data);die;
		$theHTMLResponse = $this->load->view('administration/get_key_worry_customers', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('get_key_worry_customers'=> $theHTMLResponse)));
	}
	
	public function get_offer_details()
	{
		$result = $this->Administration_model->get_offer_details($this->input->post("offerid"));
	//	$this->output->set_output($result->description);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('offer_description'=> $result->description,'offer_hobbie_id' => $result->Hobbie_id)));
	}
	
	public function autocomplete_customer_names()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['Company_id'] = $session_data['Company_id'];
			
			if (isset($_GET['term']))
			{
				$keyword = strtolower($_GET['term']);
				$Company_id = $data['Company_id'];
				$this->Administration_model->get_customer_name($keyword,$Company_id);
			}
		}
	}
	
	public function get_phnno_memberid()
	{
		$result = $this->Administration_model->get_phnno_memberid($this->input->post("Cust_name"),$this->input->post("Company_id"));
		echo json_encode($result);
	}
	/*************************************Communication Ends*******************************/
	
	public function show_multiple_offers()
	{
		$data['communication_offers'] = $this->Administration_model->get_multiple_offers($this->input->post("Seller_id"),$this->input->post("Comm_type"));
		
		$theHTMLResponse = $this->load->view('administration/show_multiple_offers', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('multipleOfferHtml'=> $theHTMLResponse)));
	}
	
	public function upload_offer_images()
	{
		/*-----------------------File Upload---------------------*/
		$config['upload_path'] = './Offer_images/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '1000';
		$config['max_width'] = '1400';
		$config['max_height'] = '1080';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		/*-----------------------File Upload---------------------*/
		
		/* if ( ! $this->upload->do_upload("file"))
		{			
			$message = '-1';
			$filepath = "";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data("file"));
			$message = '1';
			$filepath = "Offer_images/".$data['upload_data']['file_name'];
		} */
		
		
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		$configThumb = array();
		$configThumb['image_library'] = 'gd2';
		$configThumb['source_image'] = '';
		$configThumb['create_thumb'] = TRUE;
		$configThumb['maintain_ratio'] = TRUE;			
		$configThumb['width'] = 128;
		$configThumb['height'] = 128;
		/* Load the image library */
		$this->load->library('image_lib');						
		$upload77 = $this->upload->do_upload('file');
		$data77 = $this->upload->data();			   
		if($data77['is_image'] == 1) 
		{						 
			$configThumb['source_image'] = $data77['full_path'];
			$configThumb['source_image'] = './Offer_images/'.$upload77;
			$this->image_lib->initialize($configThumb);
			$this->image_lib->resize();
			$filepath='Offer_images/'.$data77['file_name'];
			$message = '1';
		}
		else
		{							
			
			$message = '-1';
			$filepath = "";								
			
		}
		
		
		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('image_name'=> base_url().$filepath, 'message' => $message)));
	}	
	function auction()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/auction";
			$total_row = $this->Administration_model->auction_count($session_data['Company_id']);	
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;			
			/*-----------------------Pagination---------------------*/	
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
			if($_POST == NULL)
			{
				$data["results"] = $this->Administration_model->auction_list($config["per_page"], $page, $session_data['Company_id']);			
				$data["pagination"] = $this->pagination->create_links();
				
				$this->load->view('administration/create_auction',$data);
			}
			else
			{
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/Auction_images/';
				$config['upload_url']   = base_url()."Auction_images/";
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '5000';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = false;	
				//$config['overwrite'] = 'true';	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				 
				if (!$this->upload->do_upload("file"))
				{			
						$error_img= $this->upload->display_errors();
						if(strlen($error_img)!=43)
						{
							$this->session->set_flashdata("error_code",$this->upload->display_errors());
						}
						$filepath = "";
						$filename = "";
						
						
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "Auction_images/".$_FILES['file']['name'];
					$filename = $_FILES['file']['name'];
					
				}
				
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();	
				//die;
				$result = $this->Administration_model->insert_auction($filepath);	
				
				$From_date = date("Y-m-d",strtotime($this->input->post("startDate")));
				$To_date = date("Y-m-d",strtotime($this->input->post("endDate")));	
				$auction_name = $this->input->post("auction_name");
				$minpointstobid = $this->input->post("minpointstobid");
				$description = $this->input->post("description");
				
				$Email_content = array(
					'Auction_start_date' => $From_date,
					'Auction_end_date' => $To_date,
					'Auction_name' => $auction_name,
					'Minimum_bid' => $minpointstobid,
					'Auction_description' => $description,
					'Notification_type' => 'Auction Details',
					'Template_type' => 'Auction'
				);
				$all_customers = $this->Igain_model->get_all_customers($session_data['Company_id']);
				foreach($all_customers as $customers)
				{
					$this->send_notification->send_Notification_email($customers['Enrollement_id'],$Email_content,$Logged_user_enrollid,$session_data['Company_id']);
				}
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Auction Created Successfuly..!!");
				/*******************************Nilesh log tbl change**********************************/	
					$Company_id	= $session_data['Company_id'];
					$get_company = $this->Igain_model->get_company_details($session_data['Company_id']);
					$company_name = $get_company->Company_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create Auction";
					$where="Create Auction";
					$To_enrollid =0;
					$firstName = $company_name;
					$lastName = '';  
					$Seller_name = $session_data['Full_name'];
					$opval =  $this->input->post("auction_name");
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Creating Auction. Please Provide valid data..!!");
				}
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function delete_auction()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Com_id = $session_data['Company_id'];
			
			if($_REQUEST == NULL)
			{
				redirect("Administration/auction");
			}
			else
			{	
				$Auction_id =  $_REQUEST['Auction_id'];
				$auction_details = $this->Administration_model->edit_auction($Auction_id);
				$Auction_name=$auction_details->Auction_name;
				$result = $this->Administration_model->delete_auction($Com_id,$Auction_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Auction Deleted Successfuly..!!");
					
				/*******************************Nilesh log tbl change**********************************/	
					$Company_id	= $session_data['Company_id'];
					$get_company = $this->Igain_model->get_company_details($session_data['Company_id']);
					$company_name = $get_company->Company_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Auction";
					$where="Create Auction";
					$To_enrollid =0;
					$firstName = $company_name;
					$lastName = '';  
					$Seller_name = $session_data['Full_name'];
					$opval = $Auction_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				}
				else
				{
					$this->session->set_flashdata("error_code","Auction Not Deleted, Because Members bid for this Auction..!!");
				}
				redirect("Administration/auction");
			}
		}
	}
	
	public function edit_auction()
	{	
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/auction";
			$total_row = $this->Administration_model->auction_count($session_data['Company_id']);	
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;			
			/*-----------------------Pagination---------------------*/
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
			if($_REQUEST['Auction_id'])
			{
				$data["results2"] = $this->Administration_model->auction_list($config["per_page"], $page, $session_data['Company_id']);			
				$data["pagination"] = $this->pagination->create_links();

				$Auction_id =  $_REQUEST['Auction_id'];			
				$data['results'] = $this->Administration_model->edit_auction($Auction_id);
				
				$this->load->view('administration/edit_auction',$data);
			}
			else
			{
				redirect("Administration/auction");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function update_auction()
	{
		if($this->session->userdata('logged_in'))
		{		
			$session_data = $this->session->userdata('logged_in');
			if($_POST == NULL)
			{
				redirect("Administration/auction");
			}
			else
			{
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/Auction_images/';
				$config['upload_url']   = base_url()."Auction_images/";
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '5000';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = false;	
				//$config['overwrite'] = 'true';	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				 
				if (!$this->upload->do_upload("file"))
				{			
						$error_img= $this->upload->display_errors();
						if(strlen($error_img)!=43)
						{
							$this->session->set_flashdata("error_code",$this->upload->display_errors());
						}
						$filepath = $this->input->post('Auction_image');
						$filename = "";
						
						
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "Auction_images/".$_FILES['file']['name'];
					$filename = $_FILES['file']['name'];
					
				}
				
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();
			

				$Auction_id = $this->input->post('Auction_id');
				$auction_details = $this->Administration_model->edit_auction($Auction_id);
				$Auction_name=$auction_details->Auction_name;
				$result = $this->Administration_model->update_auction($filepath);				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Auction Updated Successfuly..!!");
					
				/*******************************Nilesh log tbl change**********************************/	
					$Auction_id = $this->input->post('Auction_id');
					$Company_id	= $session_data['Company_id'];
					$get_company = $this->Igain_model->get_company_details($session_data['Company_id']);
					$company_name = $get_company->Company_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Auction";
					$where="Create Auction";
					$To_enrollid =0;
					$firstName = $company_name;
					$lastName = '';  
					$Seller_name = $session_data['Full_name'];
					$opval = $Auction_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					
				/*******************************Nilesh log tbl change**********************************/	
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Updating Auction. Please Provide valid data..!!");
				}
				redirect("Administration/auction");
			}
		}
	}
	
	public function check_auction_name()
	{
		$result = $this->Administration_model->check_auction_name($this->input->post("Auction_name"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output(0);
		}
		else    
		{
			$this->output->set_output(1);
		}
	}
	
	function approve_auction()
	{
		if($this->session->userdata('logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			if($_POST == NULL)
			{
				$Max_Bid_value = $this->Administration_model->get_max_bid_value($data['Company_id']);
	
				
				if($Max_Bid_value != 0)
				{
					$data["Max_Bid_value"] = $Max_Bid_value;
					
					foreach($data["Max_Bid_value"] as $Max_Bid_value)
					{
						$auction_winners_list[] = $this->Administration_model->auction_winners_list($data['Company_id'],$Max_Bid_value->Bid_value);
					}
					$data["results"] = $auction_winners_list;
				}
				else
				{
					$data["results"] = "";
				}
					
					$data["approved_auction_list"] = $this->Administration_model->approved_auction_list($data['Company_id']);
					
				$this->load->view('administration/approve_auction',$data);
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function auction_cust_details()
	{
		$data['cust_details'] = $this->Igain_model->get_enrollment_details($this->input->post("Enrollment_id"));
		$theHTMLResponse = $this->load->view('administration/auction_cust_details', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('auction_cust_details'=> $theHTMLResponse)));
	}	
	function approve_auction_winner()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			
			$auction_cust_details = $this->Administration_model->get_auction_cust_details($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			$auction_details = $this->Administration_model->edit_auction($this->input->get("Auction_id"));
			$cust_details = $this->Igain_model->get_enrollment_details($this->input->get("Enrollment_id"));
			$Curr_balance = $cust_details->Current_balance;
			$Curr_balance = $Curr_balance - $auction_cust_details->Bid_value;
			
			$Blocked_points = $cust_details->Blocked_points;
			$Blocked_points = $Blocked_points - $auction_cust_details->Bid_value;
			
			if($Blocked_points < 0)
			{
				$Blocked_points = 0;
			}
			
			$update_data = array(
								'Current_balance' => $Curr_balance ,
								'Blocked_points' => $Blocked_points 
							);
			$result1 = $this->Administration_model->update_cust_details($this->input->get("Enrollment_id"),$update_data);
			
			$result2 = $this->Administration_model->approve_auction_winner($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			$result3 = $this->Administration_model->update_auction_master($this->input->get("Auction_id"),$data['Company_id']);
						
			$Email_content = array(
				'Auction_name' => $auction_details->Auction_name,
				'Notification_type' => 'Auction Winner Details', 
				'Template_type' => 'Auction_winner'
			);
			$this->send_notification->send_Notification_email($auction_cust_details->Enrollment_id,$Email_content,$data['enroll'],$auction_cust_details->Company_id);
			
			/********************AMIT 16-08-2017**insert in trasnaction**********/
			$this->load->model('transactions/Transactions_model');
			$post_data = array(					
						'Trans_type' => '19', //Auction
						'Company_id' => $data['Company_id'],
						'Redeem_points' => $auction_cust_details->Bid_value,        
						'Trans_date' => date('Y-m-d H:i:s'),       
						'Remarks' => 'Auction Winner - '.$auction_cust_details->Prize,
						'Card_id' => $cust_details->Card_id,
						'Seller' => $data['enroll'],
						'Enrollement_id' => $this->input->get("Enrollment_id")
					);
			$result55 = $this->Transactions_model->insert_topup_details($post_data);
			
			/********************AMIT 16-08-2017**end**********/
			
			if($result1 == true && $result2 == true && $result3 == true)
			{
				$this->session->set_flashdata("success_code","Auction Winner Approved Successfuly!!");
				
				/*******************************Nilesh log tbl change**********************************/	
					$Auction_cust_id=$auction_cust_details->Enrollment_id;
					$Company_id	= $session_data['Company_id'];
					$get_auction_cust = $this->Igain_model->get_enrollment_details($Auction_cust_id);
					$auction_cust_fname = $get_auction_cust->First_name;	
					$auction_cust_lname = $get_auction_cust->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Approve Auction Winner";
					$where="Approve Auction";
					$To_enrollid =0;
					$firstName = $auction_cust_fname;
					$lastName = $auction_cust_lname;  
					$Seller_name = $session_data['Full_name'];
					$opval = $auction_details->Auction_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Auction_cust_id);	
				/*******************************Nilesh log tbl change**********************************/
			}
			else
			{							
				$this->session->set_flashdata("error_code","Error Approving Auction Winner..!!");
			}
			redirect("Administration/approve_auction");
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function delete_auction_winner()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			
			$auction_cust_details = $this->Administration_model->get_auction_cust_details($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			$cust_details = $this->Igain_model->get_enrollment_details($this->input->get("Enrollment_id"));
			$Curr_balance = $cust_details->Current_balance;			
			$Blocked_points = $cust_details->Blocked_points;
			$Blocked_points = $Blocked_points - $auction_cust_details->Bid_value;
			
			if($Blocked_points < 0)
			{
				$Blocked_points = 0;
			}
			
			$update_data = array(
								'Current_balance' => $Curr_balance ,
								'Blocked_points' => $Blocked_points 
							);
			$result1 = $this->Administration_model->update_cust_details($this->input->get("Enrollment_id"),$update_data);
			
			$result2 = $this->Administration_model->delete_auction_winner($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			/***********************AMIT 30-06-2016****************************************/
			
			$Available_Current_balance=($Curr_balance-$Blocked_points);			
			// $auction_details = $this->Administration_model->edit_auction($this->input->get("ID"));
			$auction_details = $this->Administration_model->edit_auction($this->input->get("Auction_id"));
			$Email_content = array(
				'Auction_name' => $auction_details->Auction_name,
				'Bid_value' => $auction_cust_details->Bid_value,
				'Available_Current_balance' => $Available_Current_balance,
				'Notification_type' => 'Cancellation of Auction '.$auction_details->Auction_name.'',
				'Template_type' => 'Auction_winner_cancel'
			);
			$this->send_notification->send_Notification_email($this->input->get("Enrollment_id"),$Email_content,$data['enroll'],$auction_cust_details->Company_id);
			
			/*************************************************************************/
			

				$this->session->set_flashdata("success_code","Auction Winner Deleted Successfuly!!");
				
				/*******************************Nilesh log tbl change**********************************/	
					$Auction_cust_id=$this->input->get("Enrollment_id");
					$Company_id	= $session_data['Company_id'];
					$get_auction_cust = $this->Igain_model->get_enrollment_details($Auction_cust_id);
					$auction_cust_fname = $get_auction_cust->First_name;	
					$auction_cust_lname = $get_auction_cust->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Auction Winner";
					$where="Approve Auction";
					$To_enrollid =0;
					$firstName = $auction_cust_fname;
					$lastName = $auction_cust_lname;  
					$Seller_name = $session_data['Full_name'];
					$opval = $auction_details->Auction_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Auction_cust_id);	
				/*******************************Nilesh log tbl change**********************************/
			
					
			redirect("Administration/approve_auction");
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
/***********************************Akshay END *********************************************/

	/*******************************************************AMIT STARTUP*****************************************/	
	function referral_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Company_id2 = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/referral_rule";
				$total_row = $this->Administration_model->referral_rule_count($Company_id);	
				
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
			$data["results"] = $this->Administration_model->referral_rule_list($config["per_page"], $page,$Company_id);
			
			$data["pagination"] = $this->pagination->create_links();		
			/*-----------------------Pagination---------------------*/
		
			//$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			
			if($_POST != NULL)//insert rule in table
			{
				$result = $this->Administration_model->insert_referral_rule($Company_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Referral Rule Created Successfully!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Company Referral Rule !!");
				}
			}
			
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);			
			$get_sellers = $this->Igain_model->get_company_sellers($session_data['Company_id']);
			
			$data['Seller_array'] = $get_sellers;
			
			
			$this->load->view('administration/referral_rule',$data);	
		}
	}
	function deposit_topup()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Company_id2 = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/deposit_topup";
				$total_row = $this->Administration_model->deposit_topup_count();		
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
			$data["results"] = $this->Administration_model->deposit_topup_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();		
		/*-----------------------Pagination---------------------*/
		$get_transaction_type2 = $this->Igain_model->get_transaction_type();
			$data['Transaction_type_array'] = $get_transaction_type2;
			
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$get_sellers = $this->Igain_model->get_company_sellers($session_data['Company_id']);
			$data['Seller_array'] = $get_sellers;
			
			$Payment = $this->Igain_model->get_payement_type();
			$data['Payment_array'] = $Payment;
			
			
			
			$this->load->view('administration/deposit_topup',$data);	
		}
	}
	
	function insert_deposit_topup()
	{
		$session_data = $this->session->userdata('logged_in');
		$Company_id = $session_data['Company_id'];
		
			
			$result = $this->Administration_model->insert_deposit_topup($Company_id);
			if($result == true)
			{
				$Amt_transaction = $this->input->post('Amt_transaction');
				$Seller_id = $this->input->post('Seller_id');
				$Trans_type = $this->input->post('Trans_type');
				
				$data2 = $this->Igain_model->get_company_details($session_data['Company_id']);
				$Company_Current_balance=$data2->Current_bal;
				$Total_company_Current_balance=($Company_Current_balance+$Amt_transaction);
				
				
				if($Trans_type==6)//Seller Deposit
				{
					$get_sellers = $this->Igain_model->get_enrollment_details($Seller_id);
					$Seller_Current_balance=$get_sellers->Current_balance;
				
					$Update_Seller_Current_balance = $this->Igain_model->Update_Seller_Current_balance($Seller_id,$Seller_Current_balance,$Amt_transaction);
					$Total_company_Current_balance=($Company_Current_balance-$Amt_transaction);
				}
				$Update_company_balance = $this->Igain_model->Update_company_balance($Company_id,$Company_Current_balance,$Total_company_Current_balance);
				
				
				$this->session->set_flashdata("success_code","Transaction done Successfully!!");
			}
			else
			{
				$this->session->set_flashdata("error_code","Error Transaction !!");
			}
		
			redirect("Administration/deposit_topup");
	}	
	function insert_referral_rule()
	{
		$session_data = $this->session->userdata('logged_in');
		$Company_id = $session_data['Company_id'];
		$enroll = $session_data['enroll'];
		
		$lv_seller_id=$this->input->post('seller_id');
		$referral_rule_for=$this->input->post('referral_rule_for');
		$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
		$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		
		$data['Company_id'] = $Company_id;
		$data['Seller_id'] = $this->input->post('seller_id');
		$data['Referral_rule_for'] = $this->input->post('referral_rule_for');
		$data['From_date'] = $from_date;
		$data['Till_date'] = $to_date;
		$data['Customer_topup'] = $this->input->post('tonewcust');
		$Topup_new_cust = $this->input->post('tonewcust');
		$data['Refree_topup'] = $this->input->post('toRefree');
		//$data['Tier_id'] = $this->input->post('member_tier_id');
		$toRefree = $this->input->post("toRefree");
		/*--------------------------------------------------------------------*/
							
			if($referral_rule_for==1)
			{
				$referral_rule_for2='Enrollment';		
			}
			if($referral_rule_for==2)
			{
				$referral_rule_for2='Purchase';		
			}
			
			$Email_content = array(
				'Referral_rule' => $referral_rule_for2,
				'Topup_new_cust' => $Topup_new_cust,
				'Top_u_toRefree' => $toRefree,
				'Start_date' => $from_date,
				'End_date' => $to_date,
				'Logged_user' => $enroll,
				'Notification_type' => 'Campaign & Offers',
				'Template_type' => 'Referral_rule'
			);
			$all_customers = $this->Igain_model->get_all_customers($Company_id);
		/*--------------------------------------------------------------------*/
		
		$exist_merchant_array=array();
		
			if($lv_seller_id==0)//All
			{
				// $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				$get_sellers = $this->Igain_model->get_company_sellers_and_staff($Company_id);
				$flag=0;
				foreach($get_sellers as $Sellers_id)
				{
					$Seller_id2=$Sellers_id->Enrollement_id;
					
					$check = $this->Administration_model->check_referral_rule($Company_id,$Seller_id2,$referral_rule_for);
					if($check==0)
					{
						$data['Seller_id'] =$Sellers_id->Enrollement_id;
						$fname =$Sellers_id->First_name; 		
						$lname =$Sellers_id->Last_name; 	
						$sname= $fname.' '.$lname;
						
						$result = $this->Administration_model->insert_referral_rule($Company_id,$data);
						$flag=1;
						
					/******************Nilesh change igain Log Table change 14-06-2017*********************/
						$last_id = $result;
						$Todays_date = date('Y-m-d');	
						$opration = 1;			
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Referral Rule";
						$where="Create Referral Rule";
						$toname="";
						$To_enrollid =0;
						$firstName = $fname;
						$lastName = $lname;  
						$Seller_name = $session_data['Full_name'];
						$opval = $referral_rule_for2;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$data['Seller_id']);
		
					/*****************Nilesh change igain Log Table change 14-06-2017******************/
					}
					else
					{
						array_push($exist_merchant_array,$Sellers_id->First_name);
						$Join_names=implode(",",$exist_merchant_array);
					}
				}				
				foreach($all_customers as $customers)
				{
					$send_notification = $this->send_notification->send_Notification_email($customers['Enrollement_id'],$Email_content,$lv_seller_id,$Company_id);
				}				
				if(count($exist_merchant_array)==0)
				{
					$this->session->set_flashdata("success_code","Referral Rule created Successfuly for All Merchant(s)!!!");
				}
				elseif(count($exist_merchant_array)!=0 && $flag==1)
				{
					$this->session->set_flashdata("success_code","Referral Rule created Successfuly!!!");
					$this->session->set_flashdata("error_code","Referral Rule already exist for Merchant(s) ($Join_names) !!!");
				}
				elseif(count($exist_merchant_array)!=0 && $flag==0)
				{
					$this->session->set_flashdata("error_code","Referral Rule already exist for All Merchant(s)  !!!");
				}
			}
			else
			{
				
					
					$count_staff = $this->Igain_model->Get_sub_seller_count($lv_seller_id);	
					if($count_staff > 0 )
					{
						$get_sellers_and_staff = $this->Igain_model->Get_sub_seller($lv_seller_id);	
						$flag=0;
						foreach($get_sellers_and_staff as $Sellers_id)
						{
							
							$Seller_id2=$Sellers_id->Enrollement_id;							
							$Seller_fname=$Sellers_id->First_name;		 		
							$Seller_lname=$Sellers_id->Last_name;	
							$seller_name= $Seller_fname.''.$Seller_lname;
							$check = $this->Administration_model->check_referral_rule($Company_id,$Seller_id2,$referral_rule_for);
							if($check==0)
							{
								$data['Seller_id'] =$Sellers_id->Enrollement_id;
								$Sub_seller_Enrollement_id = $Sellers_id->Sub_seller_Enrollement_id;
								$result = $this->Administration_model->insert_referral_rule($Company_id,$data);
								$flag=1;
							}
							else
							{
								array_push($exist_merchant_array,$Sellers_id->First_name);
								$Join_names=implode(",",$exist_merchant_array);
							}
						}
						$check1 = $this->Administration_model->check_referral_rule($Company_id,$Sub_seller_Enrollement_id,$referral_rule_for);
						if($check1==0)
						{							
							$data['Seller_id'] =$Sellers_id->Sub_seller_Enrollement_id;
							$result = $this->Administration_model->insert_referral_rule($Company_id,$data);					
							$this->session->set_flashdata("success_code","Referral Rule Created Successfully!!");
							$flag=1;
									
					
						/******************Nilesh change igain Log Table change 14-06-2017*********************/
							$last_id=$result;
							$seller_details = $this->Igain_model->get_enrollment_details($lv_seller_id);
							$seller_fname = $seller_details->First_name;
							$seller_mname = $seller_details->Middle_name;
							$seller_lname = $seller_details->Last_name;
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$data['enroll']	= $enroll;	
							$data['username'] = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Create Referral Rule";
							$where="Create Referral Rule";
							$To_enrollid =0;
							$firstName = $seller_fname;
							$lastName = $seller_lname;  
							$Seller_name = $session_data['Full_name'];
							$opval = $referral_rule_for2;
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$lv_seller_id);
						/******************Nilesh change igain Log Table change 14-06-2017*****************/
						}						
						foreach($all_customers as $customers)
						{
							$send_notification = $this->send_notification->send_Notification_email($customers['Enrollement_id'],$Email_content,$lv_seller_id,$Company_id);
						}				
						if(count($exist_merchant_array)==0)
						{
							$this->session->set_flashdata("success_code","Referral Rule created Successfuly for All Merchant(s)!!!");
						}
						elseif(count($exist_merchant_array)!=0 && $flag==1)
						{
							$this->session->set_flashdata("success_code","Referral Rule created Successfuly!!!");
							$this->session->set_flashdata("error_code","Referral Rule already exist for Merchant(s) ($Join_names) !!!");
						}
						elseif(count($exist_merchant_array)!=0 && $flag==0)
						{
							$this->session->set_flashdata("error_code","Referral Rule already exist for All Merchant(s)  !!!");
						}
					}	
					else
					{
						$check = $this->Administration_model->check_referral_rule($Company_id,$lv_seller_id,$referral_rule_for);
						if($check==0)
						{
							$result = $this->Administration_model->insert_referral_rule($Company_id,$data);

					/**************Nilesh change igain Log Table change 14-06-2017********************/
						$last_id=$result;
						$seller_details = $this->Igain_model->get_enrollment_details($lv_seller_id);
						$seller_fname = $seller_details->First_name;
						$seller_mname = $seller_details->Middle_name;
						$seller_lname = $seller_details->Last_name;
						$Transaction_to = $seller_fname.' '.$seller_lname;
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$data['enroll']	= $enroll;	
						$data['username'] = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Referral Rule";
						$where="Create Referral Rule";
						$To_enrollid =0;
						$firstName = $seller_fname;
						$lastName = $seller_lname;  
						$Seller_name = $session_data['Full_name'];
						$opval = $referral_rule_for2;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$lv_seller_id);
					/*************Nilesh change igain Log Table change 14-06-2017***************/							
							foreach($all_customers as $customers)
							{
								$send_notification = $this->send_notification->send_Notification_email($customers['Enrollement_id'],$Email_content,$lv_seller_id,$Company_id);
							}					
							$this->session->set_flashdata("success_code","Referral Rule Created Successfully!!");
							$flag=1;
						
						}
						else
						{
							$this->session->set_flashdata("error_code","Referral Rule already exist for Merchant  !!!");
						}
						
					}
				
			}			
			redirect("Administration/referral_rule");
	}	
	function update_referral_rule()
	{
		$session_data = $this->session->userdata('logged_in');
		$Company_id = $session_data['Company_id'];
		$new_referral_rule_for=$this->input->post('new_referral_rule_for');
		$old_referral_rule_for=$this->input->post('old_referral_rule_for');
		
		$refid = $this->input->post('refid');
		
		$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
		$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		$old_seller_id = $this->input->post('old_seller_id');
		$new_seller_id = $this->input->post('new_seller_id');
		if($new_referral_rule_for==1)
		{
			$Referral_rule_for="Enrollment"; 
		}
		else
		{
			$Referral_rule_for="Transaction";
		}
		if($old_seller_id!=$new_seller_id && $new_referral_rule_for!=$old_referral_rule_for )
		{
			$data['Seller_id'] = $this->input->post('new_seller_id');
			$check = $this->Administration_model->check_referral_rule($Company_id,$new_seller_id,$new_referral_rule_for);
			$msg="Referral Rule already exist for Merchant(s) ".$Referral_rule_for." !!!";
			/**************Igain Log Table Change***************/
			$seller_details = $this->Igain_model->get_enrollment_details($new_seller_id);
			$seller_fname = $seller_details->First_name;
			$seller_mname = $seller_details->Middle_name;
			$seller_lname = $seller_details->Last_name;
			$Transaction_to = $seller_fname.' '.$seller_lname;
			$lv_seller_id = $new_seller_id;
			$referral_rule_for2 = $Referral_rule_for;
			/**************Igain Log Table Change***************/
		}
		elseif($old_seller_id==$new_seller_id && $new_referral_rule_for!=$old_referral_rule_for )
		{
			$check = $this->Administration_model->check_referral_rule($Company_id,$new_seller_id,$new_referral_rule_for);
			$msg="Referral Rule already exist for  Merchant(s)".$Referral_rule_for."  !!!";
			
			/**************Igain Log Table Change***************/
			$seller_details = $this->Igain_model->get_enrollment_details($old_seller_id);
			$seller_fname = $seller_details->First_name;
			$seller_mname = $seller_details->Middle_name;
			$seller_lname = $seller_details->Last_name;
			$Transaction_to = $seller_fname.' '.$seller_lname;
			$lv_seller_id = $old_seller_id;
			$referral_rule_for2 = $Referral_rule_for;
			/**************Igain Log Table Change***************/
		}
		elseif($old_seller_id!=$new_seller_id && $new_referral_rule_for==$old_referral_rule_for )
		{
			$check = $this->Administration_model->check_referral_rule($Company_id,$new_seller_id,$new_referral_rule_for);
			$msg="Referral Rule already exist !!!";
			/**************Igain Log Table Change***************/
			$seller_details = $this->Igain_model->get_enrollment_details($new_seller_id);
			$seller_fname = $seller_details->First_name;
			$seller_mname = $seller_details->Middle_name;
			$seller_lname = $seller_details->Last_name;
			$Transaction_to = $seller_fname.' '.$seller_lname;
			$lv_seller_id = $new_seller_id;
			$referral_rule_for2 = $Referral_rule_for;
			/**************Igain Log Table Change***************/
		}
		else
		{
			$check =0;
			
		}
		$data['Referral_rule_for'] = $this->input->post('new_referral_rule_for');
		$data['From_date'] = $from_date;
		$data['Till_date'] = $to_date;
		$data['Customer_topup'] = $this->input->post('tonewcust');
		$data['Refree_topup'] = $this->input->post('toRefree');
		if($old_seller_id==$new_seller_id && $new_referral_rule_for==$old_referral_rule_for )
		{
			/**************Igain Log Table Change***************/
			$seller_details = $this->Igain_model->get_enrollment_details($old_seller_id);
			$seller_fname = $seller_details->First_name;
			$seller_mname = $seller_details->Middle_name;
			$seller_lname = $seller_details->Last_name;
			$Transaction_to = $seller_fname.' '.$seller_lname;
			$lv_seller_id = $new_seller_id;
			$referral_rule_for2 = $Referral_rule_for;
		  /**************Igain Log Table Change***************/
		}
		
		if($check==0)
		{
			$result = $this->Administration_model->update_referral_rule($Company_id,$refid,$data);
			$this->session->set_flashdata("success_code","Referral Rule Updated Successfully!!");
			$flag=1;
			
						
			/*****************Nilesh change igain Log Table change 14-06-2017********************/
				$Todays_date = date('Y-m-d');	
				$opration = 2;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				$what="Update Referral Rule";
				$where="Create Referral Rule";
				$To_enrollid =0;
				$firstName = $Transaction_to;
				$lastName = '';  
				$Seller_name = $session_data['Full_name'];
				$opval = $Referral_rule_for;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$lv_seller_id);
			/********************Nilesh change igain Log Table change 14-06-2017**********************/
		}
		else
		{
			$this->session->set_flashdata("error_code","$msg");
		}
		
		/* 
		
		$result = $this->Administration_model->update_referral_rule($session_data['Company_id'],$refid);
		if($result == true)
		{
			$this->session->set_flashdata("error_code","Referral Rule Updated Successfully!!");
		} */
		
			redirect("administration/referral_rule");
	}
	
	
	function delete_referral_rule()
	{
			$session_data = $this->session->userdata('logged_in');
			$refid =  $_GET['refid'];	
			$Company_id = $session_data['Company_id'];
			$referral_rule_details = $this->Igain_model->get_referral_rule_details($refid);  
			$Seller_id = $referral_rule_details->Seller_id;
			$Referral_rule_for = $referral_rule_details->Referral_rule_for;
			if($Referral_rule_for == 1)
			{
				$referral_rule_for2 ="Enrollment";
			}
			else
			{
				$referral_rule_for2 ="Transaction";
			}
			$result = $this->Administration_model->delete_referral_rule($refid);
			if($result==true)
			{
				$this->session->set_flashdata("success_code","Referral Rule Deleted Successfully!!");
			
			/**************Igain Log Table Change***************/
				$session_data = $this->session->userdata('logged_in');
				$seller_details = $this->Igain_model->get_enrollment_details($Seller_id);
				$seller_fname = $seller_details->First_name;
				$seller_mname = $seller_details->Middle_name;
				$seller_lname = $seller_details->Last_name;
				$Todays_date = date('Y-m-d');	
				$opration = 3;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				$what="Delete Referral Rule";
				$where="Create Referral Rule";
				$To_enrollid =0;
				$firstName = $seller_fname;
				$lastName = $seller_lname;  
				$Seller_name = $session_data['Full_name'];
				$opval = $referral_rule_for2;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Seller_id);	
			/*********************Nilesh change igain Log Table change 14-06-2017********************/
			}
			else
			{
				$this->session->set_flashdata("error_code","Referral Rule not Deleted!!");
			}
			
			redirect("Administration/referral_rule");
	
	}

	function edit_referral_rule()
	{
		
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
		$Company_id = $session_data['Company_id'];
		$data['LogginUserName'] = $session_data['Full_name'];
		
		/*-----------------------Pagination---------------------*/		
		$config = array();
		$config["base_url"] = base_url() . "/index.php/Administration/referral_rule";
		$total_row = $this->Administration_model->referral_rule_count($Company_id);		
		$config["total_rows"] = $total_row;
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;        
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
		
		$data["results2"] = $this->Administration_model->referral_rule_list($config["per_page"], $page,$Company_id);
		$data["pagination"] = $this->pagination->create_links();		
		/*-----------------------Pagination---------------------*/
		
		$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
		
		$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
		// $get_sellers = $this->Igain_model->get_company_sellers($session_data['Company_id']);
		$get_sellers = $this->Igain_model->get_company_sellers_and_staff($session_data['Company_id']);
		//get_company_sellers_and_staff
			
		$data['Seller_array'] = $get_sellers;
			
		if($_GET['refid'])
		{
			$refid =  $_GET['refid'];			
			$data['results'] = $this->Administration_model->edit_referral_rule($refid);
			$data["pagination"] = $this->pagination->create_links();
			$this->load->view('administration/edit_referral_rule',$data);	
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	/*************************************************AMIT END*******************/	
	/*************************************************AMIT 3-05-2017*******************/
	function SMS_communication()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['user_id'] = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($data['Company_id']);
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Available_sms"]=$data["Company_details"]->Available_sms;
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/SMS_communication";
			$total_row = $this->Administration_model->communication_count($session_data['Company_id'],1);	
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = 'First';
			$config['last_link'] = 'Last';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;			
			/*-----------------------Pagination---------------------*/
			
			if($_POST == NULL)
			{
				$data["results"] = $this->Administration_model->communication_offer_list($config["per_page"], $page, $session_data['Company_id'],1);			
				$data["pagination"] = $this->pagination->create_links();
				
				 
				$data["company_sellers"] = $this->Igain_model->get_company_sellers($data['Company_id']);
				
				$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
				
				/********AMIT 24-03-2017************/ 
				$data["Segments_list"] = $this->Segment_model->Segment_list('','',$data['Company_id']);
				/******************************/
				
				$this->load->view('administration/SMS_communication', $data);
			}
			else
			{				
				if( $this->input->post("submit") == "Register" )
				{
					$result = $this->Administration_model->insert_SMS_communication();
					if($result == true)
					{
						$this->session->set_flashdata("success_code","New SMS Communication  Created Successfuly!!");
					}
					else
					{							
						$this->session->set_flashdata("error_code","Error Inserting Communication . Please Provide valid data!!");
					}
					//redirect(current_url());
					
					redirect("Administration/SMS_communication");
				}
				
				if( $this->input->post("submit") == "Send" )
				{
					$radio1 = $this->input->post("r1");			//****send single or multiple offers.	 
					$radio2 = $this->input->post("r2");			//****send to single or all or key or worry customer.	
					$sellerid = $this->input->post("sellerId");
					$compid = $this->input->post("companyId");
					$offerid = $this->input->post("activeoffer");
					$entry_date=date("Y-m-d");	
					$acitvate = '0';
					
					if($radio2 == 1) //**single customer
					{
						$cust_name = $this->input->post("mailtoone");
						$Enrollment_id = $this->input->post("Enrollment_id");						
						$sendto = $Enrollment_id;						
					}
					if($radio2 == 2) //**all customer
					{
						$sendto = $this->input->post("mailtoall");
					}
					if($radio2 == 3) //**key customer
					{
						$sendto = $this->input->post("mailtokey");
					}
					if($radio2 == 4) //**worry customer
					{
						$sendto = $this->input->post("mailtoworry");
					}
					if($radio2 == 5) //**Tier based customer
					{
						$sendto = $this->input->post("mailtotier");
					}
					if($radio2 == 7) //**segments
					{
						$Segment_code = $this->input->post("Segment_code");
							// echo "Segment_code ".$Segment_code;
							
						
						//
						$Customer_array=array();
						
						$all_customers = $this->Igain_model->get_all_customers($compid);	
							foreach ($all_customers as $row)
							{
								$Applicable_array = $this->Igain_model->Segment_applicable_function($compid,$Segment_code,$row["Enrollement_id"],$row["Sex"],$row["Country_id"],$row["District"],$row["State"],$row["City"],$row["Zipcode"],$row["total_purchase"],$row["Date_of_birth"],$row["joined_date"],$row["Tier_id"]);	
								
								
								if(!in_array(0, $Applicable_array, true))
								{
									$Customer_array[]=$row["Enrollement_id"];
									// echo "<br>Access";
									if($radio1 == 3)
									{
										$offer_list = $this->input->post("offer_list");
										foreach ($offer_list as $offers)
										{
											$offer_details = $this->Administration_model->get_offer_details($offers);
											
											/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($row["Phone_no"],$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
											if($lv_Send_sms == 1)
											{
												$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $row["Enrollement_id"],
												'Phone_no' => $row["Phone_no"],
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
								
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
											}
											
										}
										
									}
									else
									{															
										$offer_details = $this->Administration_model->get_offer_details($offerid);
										
										/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($row["Phone_no"],$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
										if($lv_Send_sms == 1)
										{
											$Sent_Date=date("Y-m-d H:i:s");							
											$SMS_content = array(
											'Company_id' => $compid,
											'Seller_id' => $sellerid,
											'Customer_id' => $row["Enrollement_id"],
											'Phone_no' => $row["Phone_no"],
											'Communication_id' => $offer_details->id,
											'SMS_name' => $offer_details->communication_plan,
											'Sent_Date' => $Sent_Date,
											'SMS_contents' => $offer_details->description
											);
							
											$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
									
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
								}
								
							}
							if(count($Customer_array)==0)
							{
								$this->session->set_flashdata("error_code","Error,Members not found in this Segment!!");
							}	
							//echo "count ".count($Customer_array);
							 redirect(current_url());
					}
					
					
					$company_details = $this->Igain_model->get_company_details($compid);
					$seller_details = $this->Igain_model->get_enrollment_details($sellerid);
					
					if($radio2 < 3) //****single or all customer
					{
						if($sendto > 0)   //****single customer
						{
							$customer_details = $this->Igain_model->get_enrollment_details($sendto);
							if($radio1 == 3)
							{
								$offer_list = $this->input->post("offer_list");
								foreach ($offer_list as $offers)
								{
									$offer_details = $this->Administration_model->get_offer_details($offers);	
									
									/**********SMS Configuration**************/
									$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
								/**********SMS Configuration end**************/
									
									if($lv_Send_sms == 1)
									{
										$Sent_Date=date("Y-m-d H:i:s");							
										$SMS_content = array(
										'Company_id' => $compid,
										'Seller_id' => $sellerid,
										'Customer_id' => $customer_details->Enrollement_id,
										'Phone_no' => $customer_details->Phone_no,
										'Communication_id' => $offer_details->id,
										'SMS_name' => $offer_details->communication_plan,
										'Sent_Date' => $Sent_Date,
										'SMS_contents' => $offer_details->description
										);
									
										$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
										$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
									}
									else
									{
										$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
									}
									
								}
								
								redirect("Administration/SMS_communication");
							}
							else
							{
								$offer_details = $this->Administration_model->get_offer_details($offerid);
								
								/**********SMS Configuration**************/
									$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
								/**********SMS Configuration end**************/
								if($lv_Send_sms == 1)
								{
									$Sent_Date=date("Y-m-d H:i:s");							
									$SMS_content = array(
										'Company_id' => $compid,
										'Seller_id' => $sellerid,
										'Customer_id' => $customer_details->Enrollement_id,
										'Phone_no' => $customer_details->Phone_no,
										'Communication_id' => $offer_details->id,
										'SMS_name' => $offer_details->communication_plan,
										'Sent_Date' => $Sent_Date,
										'SMS_contents' => $offer_details->description
									);
								
														
									$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
								
								
									$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
								}
								else
								{							
									$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
								}

								//redirect(current_url());
								
								redirect("Administration/SMS_communication");
							}
							
						
						}
						
						if($sendto == 0)   //****all customer
						{
							$cust_emails = array();
							$i=0;
							$all_customers = $this->Igain_model->get_all_customers($compid);							
							$cust_notification = array();
							
							foreach ($all_customers as $row)
							{
								$cust_emails[$i++] = $row['User_email_id'];
								$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);							
								
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									$offer_count = count($offer_list);
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
										
										/**********SMS Configuration**************/
									$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
									/**********SMS Configuration end**************/
									if($lv_Send_sms == 1)
										{
											$Sent_Date=date("Y-m-d H:i:s");							
											$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
											);
											
																	
											$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
									

									}
								}
								else
								{
									$offer_details = $this->Administration_model->get_offer_details($offerid);
									$id = $offer_details->id;
									$communication_plan = $offer_details->communication_plan;
									$description = $offer_details->description;
							
									 /**********SMS Configuration**************/
									$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
									/**********SMS Configuration end**************/
									if($lv_Send_sms == 1)
										{
											$Sent_Date=date("Y-m-d H:i:s");							
											$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
											);
											
																	
											$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
									
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
								}
							}

							redirect(current_url());	
							
							//redirect("Administration/communication");						
						}
					}
					
					if($radio2 == 5) //****for tier based cust
					{
						$selected_tier = $sendto;
						$useremail = array(); 
						$i=0;
						
						$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
						
						if($tier_based_customers != false)
						{
							foreach($tier_based_customers as $cust_regid)
							{
								// echo "<pre>";
								// var_dump($cust_regid);die;
								$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
								if($customer_details != NULL)
								{
									if($radio1 == 3)
									{
										$offer_list = $this->input->post("offer_list");
										foreach ($offer_list as $offers)
										{
											$offer_details = $this->Administration_model->get_offer_details($offers);
											
											/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
											/**********SMS Configuration end**************/
											
											if($lv_Send_sms == 1)
											{
												$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
											
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
												$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
											}
										}
									
									}
									else
									{															
										$offer_details = $this->Administration_model->get_offer_details($offerid);
										
										/**********SMS Configuration**************/
										$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
										if($lv_Send_sms == 1)
										{
											$Sent_Date=date("Y-m-d H:i:s");							
											$SMS_content = array(
											'Company_id' => $compid,
											'Seller_id' => $sellerid,
											'Customer_id' => $customer_details->Enrollement_id,
											'Phone_no' => $customer_details->Phone_no,
											'Communication_id' => $offer_details->id,
											'SMS_name' => $offer_details->communication_plan,
											'Sent_Date' => $Sent_Date,
											'SMS_contents' => $offer_details->description
											);
										
											$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
										
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
								}
							}
						}
						else
						{
							$this->session->set_flashdata("error_code","Error Sending Communication . Customers Not Exist Of This Tier!!");
						}
						redirect(current_url());
						//redirect("Administration/communication");
						// die;
					}
					
					if($radio2 == 3) //****for key cust
					{
						$useremail = array(); 
						$i=0;
						
						foreach($this->input->post("key_worry_cust") as $cust_id)
						{
							if($cust_id==0)
							{
								$key_worry_customers = $this->Administration_model->get_key_worry_customers($sellerid,$compid,$this->input->post("r2"),$this->input->post("mailtokey"));
								
								foreach($key_worry_customers as $cust_regid)
								{
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid);
									if($customer_details != NULL)
									{
										if($radio1 == 3)
										{
											$offer_list = $this->input->post("offer_list");
											foreach ($offer_list as $offers)
											{
												$offer_details = $this->Administration_model->get_offer_details($offers);								
												/**********SMS Configuration**************/
												$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
												/**********SMS Configuration end**************/
												if($lv_Send_sms == 1)
												{
													$Sent_Date=date("Y-m-d H:i:s");							
													$SMS_content = array(
													'Company_id' => $compid,
													'Seller_id' => $sellerid,
													'Customer_id' => $customer_details->Enrollement_id,
													'Phone_no' => $customer_details->Phone_no,
													'Communication_id' => $offer_details->id,
													'SMS_name' => $offer_details->communication_plan,
													'Sent_Date' => $Sent_Date,
													'SMS_contents' => $offer_details->description
													);
												
													$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
													$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
												}
												else
												{							
													$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
												}
												
											}
											
											
											// redirect(current_url());
										}
										else
										{															
											$offer_details = $this->Administration_model->get_offer_details($offerid);								
											
											/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
											/**********SMS Configuration end**************/
											if($lv_Send_sms == 1)
											{
												$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
											
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											
											
												$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
											}
											// redirect(current_url());
										}
									}
								}
								redirect(current_url());
								
								//redirect("Administration/communication");
							}
							else
							{
								$customer_details = $this->Igain_model->get_enrollment_details($cust_id);							
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
											
											/**********SMS Configuration**************/
										$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
										if($lv_Send_sms == 1)
										{
											$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
											
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
												$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
									
									
									// redirect(current_url());
								}
								else
								{															
									$offer_details = $this->Administration_model->get_offer_details($offerid);								
										
										/**********SMS Configuration**************/
										$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
										if($lv_Send_sms == 1)
										{
											$Sent_Date=date("Y-m-d H:i:s");							
											$SMS_content = array(
											'Company_id' => $compid,
											'Seller_id' => $sellerid,
											'Customer_id' => $customer_details->Enrollement_id,
											'Phone_no' => $customer_details->Phone_no,
											'Communication_id' => $offer_details->id,
											'SMS_name' => $offer_details->communication_plan,
											'Sent_Date' => $Sent_Date,
											'SMS_contents' => $offer_details->description
											);
											
											$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
									
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
						//redirect("Administration/communication");
					}
					
					if($radio2 == 4) //****for worry cust
					{
						$useremail = array(); 
						$i=0;
						
						foreach($this->input->post("key_worry_cust") as $cust_id)
						{
							if($cust_id==0)
							{
								$key_worry_customers = $this->Administration_model->get_key_worry_customers($sellerid,$compid,$this->input->post("r2"),$this->input->post("mailtoworry"));
								
								foreach($key_worry_customers as $cust_regid)
								{
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid);
									if($customer_details != NULL)
									{
										if($radio1 == 3)
										{
											$offer_list = $this->input->post("offer_list");
											foreach ($offer_list as $offers)
											{
												$offer_details = $this->Administration_model->get_offer_details($offers);

												/**********SMS Configuration**************/
												$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
												/**********SMS Configuration end**************/
												if($lv_Send_sms == 1)
												{		
													$Sent_Date=date("Y-m-d H:i:s");							
													$SMS_content = array(
													'Company_id' => $compid,
													'Seller_id' => $sellerid,
													'Customer_id' => $customer_details->Enrollement_id,
													'Phone_no' => $customer_details->Phone_no,
													'Communication_id' => $offer_details->id,
													'SMS_name' => $offer_details->communication_plan,
													'Sent_Date' => $Sent_Date,
													'SMS_contents' => $offer_details->description
													);
												
													$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
													$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
												}
												else
												{							
													$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
												}
											}
											
											// redirect(current_url());
										}
										else
										{															
											$offer_details = $this->Administration_model->get_offer_details($offerid);								
											
											/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
											/**********SMS Configuration end**************/
											if($lv_Send_sms == 1)
											{
												$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
											
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											
												$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
											}
											// redirect(current_url());
										}
									}
								}
								redirect(current_url());
								
								redirect("Administration/communication");
							}
							else
							{
								$customer_details = $this->Igain_model->get_enrollment_details($cust_id);							
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
										
										/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
										if($lv_Send_sms == 1)
										{	
											$Sent_Date=date("Y-m-d H:i:s");							
											$SMS_content = array(
											'Company_id' => $compid,
											'Seller_id' => $sellerid,
											'Customer_id' => $customer_details->Enrollement_id,
											'Phone_no' => $customer_details->Phone_no,
											'Communication_id' => $offer_details->id,
											'SMS_name' => $offer_details->communication_plan,
											'Sent_Date' => $Sent_Date,
											'SMS_contents' => $offer_details->description
											);
										
											$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
									
									
									// redirect(current_url());
								}
								else
								{															
									$offer_details = $this->Administration_model->get_offer_details($offerid);								
									
									/**********SMS Configuration**************/
									$lv_Send_sms = $this->Administration_model->Send_sms($customer_details->Phone_no,$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
									/**********SMS Configuration end**************/
									if($lv_Send_sms == 1)
									{
											$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $customer_details->Enrollement_id,
												'Phone_no' => $customer_details->Phone_no,
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
											
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
									
										$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
									}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
						
						redirect("Administration/communication");
					}
					
					if($radio2 == 6) //****Hobbies/Intrested Members
					{
						$cust_emails = array();
							$i=0;
							$all_customers = $this->Administration_model->get_all_hobbie_customers($compid);							
							$cust_notification = array();
							
							foreach ($all_customers as $row)
							{
								$cust_emails[$i++] = $row['User_email_id'];
								//$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);							
								
								if($radio1 == 3)
								{
									$offer_list = $this->input->post("offer_list");
									$offer_count = count($offer_list);
									foreach ($offer_list as $offers)
									{
										$offer_details = $this->Administration_model->get_offer_details($offers);								
										
										
										$offer_hobbie_id = $offer_details->Hobbie_id;
										
										if($offer_hobbie_id == $row['Hobbie_id'])
										{
											/**********SMS Configuration**************/
											$lv_Send_sms = $this->Administration_model->Send_sms($row["Phone_no"],$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
											/**********SMS Configuration end**************/
											
											if($lv_Send_sms == 1)
											{
											$Sent_Date=date("Y-m-d H:i:s");							
												$SMS_content = array(
												'Company_id' => $compid,
												'Seller_id' => $sellerid,
												'Customer_id' => $row["Enrollement_id"],
												'Phone_no' => $row["Phone_no"],
												'Communication_id' => $offer_details->id,
												'SMS_name' => $offer_details->communication_plan,
												'Sent_Date' => $Sent_Date,
												'SMS_contents' => $offer_details->description
												);
											
												$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
											$this->session->set_flashdata("success_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
											}
										
										}
									}
								}
								else
								{
									$offer_details = $this->Administration_model->get_offer_details($offerid);
									$id = $offer_details->id;
									$communication_plan = $offer_details->communication_plan;
									$description = $offer_details->description;
							
									$offer_hobbie_id = $offer_details->Hobbie_id;
									
									if($offer_hobbie_id == $row['Hobbie_id'])
									{
										/**********SMS Configuration**************/
										$lv_Send_sms = $this->Administration_model->Send_sms($row["Phone_no"],$offer_details->description,$offer_details->communication_plan,$data['Company_id']);
										/**********SMS Configuration end**************/
										if($lv_Send_sms == 1)
										{
										$Sent_Date=date("Y-m-d H:i:s");							
										$SMS_content = array(
										'Company_id' => $compid,
										'Seller_id' => $sellerid,
										'Customer_id' => $row["Enrollement_id"],
										'Phone_no' => $row["Phone_no"],
										'Communication_id' => $offer_details->id,
										'SMS_name' => $offer_details->communication_plan,
										'Sent_Date' => $Sent_Date,
										'SMS_contents' => $offer_details->description
										);
									
										$Insert = $this->Administration_model->insert_customer_notification_SMS($SMS_content);
										$this->session->set_flashdata("success_code","Communication Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Communication . Please Provide valid data!!");
									}
									}
								}
							}

									
							
							
						redirect(current_url());
						
						redirect("Administration/communication");
					}
				}
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	/*************************************************AMIT 3-05-2017*END******************/
	/*************************************************Ravi 19-09-2017*Start******************/
	/***************Offers Rules******************************/
	function offer_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			
			
			$data["results2"] = $this->Administration_model->offer_rule_list($Company_id);
			$data["pagination"] = $this->pagination->create_links();		
			/*-----------------------Pagination---------------------*/	
			if($_POST == NULL)
			{
				$today_date=date("Y-m-d");		
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				//$data["Offer_item_details"] = $this->Administration_model->get_offer_item_details($Company_id,$today_date);
				
				$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}			
				$data['Seller_array'] = $get_sellers;
				$this->load->view('administration/offer_rule',$data);	

			}
			else
			{			
				
				$Items = $this->input->post("Company_merchandise_item_id"); 
				$Free_Items = $this->input->post("Free_item_id"); 
				$Buy_item = $this->input->post("Buy_item");
				$Free_item=$this->input->post("Free_item");
				$errorExist = 0;
				$Offer_code=  $this->input->post("Offer_code");
				// $Offer_code= preg_replace('/[^A-Za-z0-9\-]/', '', $Offer_code); // Removes special chars.
				// print_r($Items);
				// echo "-------------";
				// print_r($Free_Items); die;
				if($Items != null)
				{
					foreach($Items as $Item_id)
					{
						foreach($Free_Items as $Free_ItemsId)
						{
						$check_item_offer_result = $this->Administration_model->check_item_offers($this->input->post("Offer_name"),$this->input->post("Company_id"),$Item_id,$this->input->post("Buy_item"),$Free_ItemsId,$this->input->post("seller_id"),$this->input->post("Menu_group_id"));
					
						// echo"----check_item_offer_result-------".$check_item_offer_result."---<br>";
						// die;
						if($check_item_offer_result == 0 )
						{

								$insert_data=array
										(
											'Company_id'=>$this->input->post("Company_id"),
											'Company_merchandise_item_id'=>$Item_id,
											'Offer_name'=>$this->input->post("Offer_name"),
											'Offer_description'=>$this->input->post("Offer_description"),
											'Offer_code'=>$Offer_code,
											'Buy_item'=>$this->input->post("Buy_item"),
											'Free_item'=>$this->input->post("Free_item"),
											'From_date'=>date('Y-m-d',strtotime($this->input->post("start_date"))),
											'Till_date'=>date('Y-m-d',strtotime($this->input->post("end_date"))),
											'Active_flag'=>$this->input->post("Offer_status"),
											// 'Free_item_id'=>$this->input->post("Free_item_id"),
											'Free_item_id'=>$Free_ItemsId,
											'Seller_id'=>$this->input->post("seller_id"),
											'Buy_item_category'=>$this->input->post("Menu_group_id"),
											'Free_item_category'=>$this->input->post("Free_Menu_group_id")
										);
							$result = $this->Administration_model->insert_offer_rule($insert_data);
							
							if($result == true)
							{
								
								/*******************************Offer log tbl change**********************************/	
								$Company_id	= $session_data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 1;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								$what="Create Offer Rule";
								$where="Create Offer Rule";
								$To_enrollid =0;
								$firstName ="";
								$lastName ="";  
								$Seller_name = $session_data['Full_name'];
								$opval = $Offer_code.', (  Buy Item Id = '.$Item_id.' )';
								$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
								/*******************************Offer log tbl change**********************************/
							}
					
						}
						else
						{
							$errorExist = 1;
							
						}
					}
					}
				}
				else
				{
					$insert_data=array
						(
							'Company_id'=>$this->input->post("Company_id"),
							'Company_merchandise_item_id'=>0,
							'Offer_code'=>$Offer_code,
							'Offer_name'=>$this->input->post("Offer_name"),
							'Offer_description'=>$this->input->post("Offer_description"),
							'Buy_item'=>$this->input->post("Buy_item"),
							'Free_item'=>$this->input->post("Free_item"),
							'From_date'=>date('Y-m-d',strtotime($this->input->post("start_date"))),
							'Till_date'=>date('Y-m-d',strtotime($this->input->post("end_date"))),
							'Active_flag'=>$this->input->post("Offer_status"),
							// 'Free_item_id'=>$this->input->post("Free_item_id"),
							'Free_item_id'=>0,
							'Seller_id'=>$this->input->post("seller_id"),
							'Buy_item_category'=>$this->input->post("Menu_group_id"),
							'Free_item_category'=>$this->input->post("Free_Menu_group_id")
						);
						$result = $this->Administration_model->insert_offer_rule($insert_data);
							
							if($result == true)
							{
								
								/*******************************Offer log tbl change**********************************/	
								$Company_id	= $session_data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 1;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								$what="Create Offer Rule";
								$where="Create Offer Rule";
								$To_enrollid =0;
								$firstName ="";
								$lastName ="";  
								$Seller_name = $session_data['Full_name'];
								$opval = $Offer_code;
								$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
								/*******************************Offer log tbl change**********************************/
							}
					
				}					
				
											
				if($errorExist > 0)
				{
				
					$this->session->set_flashdata("error_code","Offer rule already exist for few items!!");
					//redirect(current_url());
				}
				else
				{
					$this->session->set_flashdata("success_code","Offer Rule Created Successfully!!");
				}
	
				// die;
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function check_offer_name()
	{
		$Offername = $this->input->post('Offer_name');
		$Company_id = $this->input->post('Company_id');
		
		$offer_result = $this->Administration_model->check_offer_name($Offername,$Company_id);
		
		if($offer_result > 0)
		{
			$this->output->set_output(0);
		}
		else    
		{
			$this->output->set_output(1);
		}
		
	}
	function check_offer_code()
	{
		$Offer_code = $this->input->post('Offer_code');
		$Company_id = $this->input->post('Company_id');
		
		$offer_result = $this->Administration_model->check_offer_code($Offer_code,$Company_id);
		
		if($offer_result > 0)
		{
			$this->output->set_output(0);
		}
		else    
		{
			$this->output->set_output(1);
		}
		
	}
	public function get_offer_item()
	{
		$Company_id = $this->input->post("Company_id");
		$Merchandize_category_id = $this->input->post("Category_id");
		$Stamp_item_flag = $this->input->post("StampFlag");
		$Offer_code = $this->input->post("Offer_code");
		$Selected_items = $this->Administration_model->get_offer_selected_items($Offer_code,$Company_id);
		$Selected_items2 = array();
		if($Selected_items != NULL)
		{
			foreach($Selected_items as $rec)
			{
				$Selected_items2[]=$rec->Company_merchandise_item_id;
			}
		}
		$data["Selected_items"] = $Selected_items2;
		// print_r($Selected_items2)	;die;
		$data["Offer_item_details"] = $this->Administration_model->get_offer_item_details($Company_id,$Merchandize_category_id,$Stamp_item_flag);
		//$data['offers_item_name'] = $this->Administration_model->get_offer_item($this->input->post("item_id"),$this->input->post("Company_id"),$today_date);
		
		$this->load->view('administration/get_offer_item_Name',$data);	
		
	}
	public function edit_offer_rule()
	{	
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			
			$data["results2"] = $this->Administration_model->offer_rule_list($Company_id);
			$data["pagination"] = $this->pagination->create_links();
							
			/*-----------------------Pagination---------------------*/
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
					
			if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
		
			$data['Seller_array'] = $get_sellers;
			
			if($_GET['Offer_code'])
			{	
				$Offer_code =  $_GET['Offer_code'];
				$today_date=date("Y-m-d");
				$Item_result = $this->Administration_model->edit_offer_rule($Offer_code,$Company_id);	
				$data['results']=$Item_result;
				$data['Offer_code']=$Offer_code;
				
				$data['Check_offer_sent'] = $this->Administration_model->Check_offer_sent($Offer_code,$Company_id);
				$data['MenuGrpArray'] = $this->Administration_model->get_offer_menu_groups($Item_result->Seller_id,$Company_id,1);
			//echo "*********---***********----";
			//var_dump($data['MenuGrpArray']);
				
				$data['Buy_item_category'] = $this->Administration_model->Get_Category_Name($Item_result->Buy_item_category,$Company_id);
			//echo "*********---***********----";
				$data["Buy_items_list"] = $this->Administration_model->get_offer_item_details($Company_id,$Item_result->Buy_item_category,1);
			//var_dump($data['Buy_items_list']);	
				$data['FreeMenuGrpArray'] = $this->Administration_model->get_offer_menu_groups($Item_result->Seller_id,$Company_id,0);
				
				$data['Free_item_category'] = $this->Administration_model->Get_Category_Name($Item_result->Free_item_category,$Company_id);
				
				
				$data["Free_items_list"] = $this->Administration_model->get_offer_item_details($Company_id,$Item_result->Free_item_category,0);
				//print_r($data['Free_item_category']);die;
				// echo"---Company_merchandize_item_code------".$Item_result->Company_merchandize_item_code."<br>";
				$data["Check_offer_exist"] = $this->Administration_model->Check_offer_exist_trans($Item_result->Company_merchandize_item_code,$Company_id);	
				// echo"---Check_offer_exist------".$data["Check_offer_exist"]."<br>";
				//$data["Offer_item_details"] = $this->Administration_model->get_offer_item_details($Company_id,$today_date);				
				
				$data['offers_item_name'] = $this->Administration_model->get_offer_item($Item_result->Free_item_id,$Item_result->Company_id,$today_date);	
			/*********************/	
				$Selected_items = $this->Administration_model->get_offer_free_selected_items($Offer_code,$Company_id);
				$Selected_items2 = array();
				if($Selected_items != NULL)
				{
					foreach($Selected_items as $rec)
					{
						$Selected_items2[]=$rec->Free_item_id;
					}
				}
				$data["Selected_items"] = $Selected_items2;
			/*******************/	
				$this->load->view('administration/edit_offer_rule', $data);
			}
			else
			{
				$this->load->view('administration/offer_rule',$data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	function update_offer_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
				/* $check_item_offer_result = $this->Administration_model->check_item_offers($this->input->post("Offer_name"),$this->input->post("Company_id"),$this->input->post("Company_merchandise_item_id"),$this->input->post("Buy_item"),$this->input->post("Free_item"));
				if($check_item_offer_result == 0 )
				{ */
				$Offer_code = $this->input->post("Offer_code");
				$Offer_name = $this->input->post("Offer_name");
				$Check_offer_sent = $this->Administration_model->Check_offer_sent($Offer_code,$Company_id);
				
				if($Check_offer_sent ==1)
				{
					// $result20 = $this->Administration_model->update_offer_rule();
					
					$Item_result = $this->Administration_model->edit_offer_rule($Offer_code,$Company_id);
					$BrandId = $Item_result->Seller_id;
					$BuyItemCategory = $Item_result->Buy_item_category;
					$BuyIem = $Item_result->Buy_item;
					$FreeItem = $Item_result->Free_item;
					$FreeItemCategory = $Item_result->Free_item_category;
					$FromDate = $Item_result->From_date;
					$OfferCode = $Item_result->Offer_code;
					
					$result12 = $this->Administration_model->delete_offer_rule2($Offer_code,$Company_id);		
					$Items = $this->input->post("Company_merchandise_item_id");
					// print_r($Items);
					$Free_Items = $this->input->post("Free_item_id"); 
					if($Items != null)
					{
						foreach($Items as $Item_id)
						{
							foreach($Free_Items as $Free_ItemsId)
							{
							$insert_data=array
										(
											'Company_id'=>$this->input->post("Company_id"),
											'Company_merchandise_item_id'=>$Item_id,
											'Offer_name'=>$Offer_name,
											'Offer_description'=>$this->input->post("Offer_description"),
											'Offer_code'=>$OfferCode,
											'Buy_item'=>$BuyIem,
											'Free_item'=>$FreeItem,
											'From_date'=>date('Y-m-d',strtotime($FromDate)),
											'Till_date'=>date('Y-m-d',strtotime($this->input->post("end_date"))),
											'Active_flag'=>$this->input->post("Offer_status"),
											'Free_item_id'=>$Free_ItemsId,
											'Seller_id'=>$BrandId,
											'Buy_item_category'=>$BuyItemCategory,
											'Free_item_category'=>$FreeItemCategory
										);
							$result20 = $this->Administration_model->insert_offer_rule($insert_data);
							}
						}
					}
				} 
				else
				{
					$result12 = $this->Administration_model->delete_offer_rule2($Offer_code,$Company_id);		
					$Items = $this->input->post("Company_merchandise_item_id");
					// print_r($Items);
					$Free_Items = $this->input->post("Free_item_id"); 
					if($Items != null)
					{
						foreach($Items as $Item_id)
						{
							foreach($Free_Items as $Free_ItemsId)
							{
							$insert_data=array
										(
											'Company_id'=>$this->input->post("Company_id"),
											'Company_merchandise_item_id'=>$Item_id,
											'Offer_name'=>$Offer_name,
											'Offer_description'=>$this->input->post("Offer_description"),
											'Offer_code'=>$this->input->post("Offer_code"),
											'Buy_item'=>$this->input->post("Buy_item"),
											'Free_item'=>$this->input->post("Free_item"),
											'From_date'=>date('Y-m-d',strtotime($this->input->post("start_date"))),
											'Till_date'=>date('Y-m-d',strtotime($this->input->post("end_date"))),
											'Active_flag'=>$this->input->post("Offer_status"),
											'Free_item_id'=>$Free_ItemsId,
											'Seller_id'=>$this->input->post("seller_id"),
											'Buy_item_category'=>$this->input->post("Menu_group_id"),
											'Free_item_category'=>$this->input->post("Free_Menu_group_id")
										);
							$result20 = $this->Administration_model->insert_offer_rule($insert_data);
							}
						}
					}
				}	
				if($result20 == true)
				{
					$this->session->set_flashdata("success_code","Offer Rule Updated Successfully!!");
					$Item_id=$this->input->post("Company_merchandise_item_id");
					$Buy_item=$this->input->post("Buy_item");
					$Free_item=$this->input->post("Free_item");
					/*******************************Offer log tbl change**********************************/	
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Offer Rule";
					$where="Create Offer Rule";
					$To_enrollid =0;
					$firstName ="";
					$lastName ="";  
					$Seller_name = $session_data['Full_name'];
					$opval = "Offer_code:: ".$this->input->post("Offer_code").' Offer_name:: '.$this->input->post("Offer_name");
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
					/*******************************Offer log tbl change**********************************/
				}
				else
				{							
					$this->session->set_flashdata("error_code"," Not any changes for updated!");
				}
				redirect("Administration/offer_rule");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	function delete_offer_rule()
	{
		if($this->session->userdata('logged_in'))
		{
		$session_data = $this->session->userdata('logged_in');
		
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			if($_GET != NULL)
			{	
				$Offer_code =  $_GET['Offer_code'];	
				
				
				$result = $this->Administration_model->delete_offer_rule($Offer_code,$Company_id);				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Offer Rule Deleted Successfuly!!");
					/*******************************Offer log tbl change**********************************/	
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Offer Rule";
					$where="Create Offer Rule";
					$To_enrollid =0;
					$firstName ="";
					$lastName ="";  
					$Seller_name = $session_data['Full_name'];
					$opval =$Offer_code;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
					/*******************************Offer log tbl change**********************************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting offer Rule !!");
				}				
				redirect('Administration/offer_rule');
			}
			else
			{
				$this->load->view('administration/offer_rule',$data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	/***************Offers Rules******************************/
	public function get_seller_balance()
	{
		$result = $this->Administration_model->get_seller_balance($this->input->post("Seller_id"),$this->input->post("Company_id"));
		if($result)
		{
			echo $data['result12'] = $result->Current_balance;
		}		
	}
	/***************************Ravi 19-09-2017*END******************/
	/***********Nilesh 27-07-2018 loyalty rule for category/Segment/Flat File*************/
	function Get_Merchandize_category()
	{	
		$Company_id =  $_REQUEST['Company_id'];	
		
		$data['category_records'] = $this->Administration_model->Get_Merchandize_category($Company_id);
		$theHTMLResponse = $this->load->view('administration/Show_Merchandize_category', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Category_data'=> $theHTMLResponse)));	
	}
	function Get_Segment()
	{	
		$Company_id =  $_REQUEST['Company_id'];	
		
		$data['Segment_records'] = $this->Administration_model->Get_Segment_details($Company_id);
		$theHTMLResponse = $this->load->view('administration/Show_segment_details', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Segment_data'=> $theHTMLResponse)));	
	}
	function Get_Segment_Criteria()
	{	
		$Segment_id =  $_REQUEST['Segment_id'];	
		$Company_id =  $_REQUEST['Company_id'];	
		
		$data['Criteria_records'] = $this->Administration_model->Get_Segment_Criteria($Segment_id,$Company_id);
		$theHTMLResponse = $this->load->view('administration/Show_segment_criteria', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Criteria_data'=> $theHTMLResponse)));	
	}	
	/***********AMIT KAMBLE****Discount Rule New*************/
	function Discount_rule_master()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
			$data["get_payement_type"] = $this->Igain_model->get_payement_type();
		
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			
			$data["Merchandize_Category_Records"] = $this->Administration_model->Get_Merchandize_Category1('', '',$Company_id);
			
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;
				// print_r($data['Seller_array']);die;
				
			if($_POST == NULL)
			{
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				
				$data["results2"] = $this->Administration_model->Fetch_new_discount_rule_master($Company_id);	
				$this->load->view('administration/Discount_rule',$data);	

			}
			else
			{		
				
				$ChannelId = 0;
				$PaymentId = 0;
				
				if($this->input->post("Discount_rule_for")==1)//Overall Bill Level
				{
					$Operator=$this->input->post("Operator");
					$Criteria_value=$this->input->post("Criteria_value");
					$Category_id=0;
				}
				else if($this->input->post("Discount_rule_for")==2)//Category Level
				{
					$Operator=0;
					$Criteria_value=0;
					$Category_id=$this->input->post("Category_id");
				}
				else if($this->input->post("Discount_rule_for")==3)// Item Level
				{
					$Category_id=$this->input->post("linked_Category_id");
					$Operator=0;
					$Criteria_value=0;
				}
				else if($this->input->post("Discount_rule_for")==4)// channel Level
				{
					$Category_id=0;
					$Operator=0;
					$Criteria_value=0;
					
					$ChannelId = $this->input->post("Trans_Channel");
				}
				else if($this->input->post("Discount_rule_for")==5)// payment type Level
				{
					$Category_id=0;
					$Operator=0;
					$Criteria_value=0;
					
			
					$PaymentId = $this->input->post("Payment_Type_id");
				}
				
				$Seller_id = $this->input->post('Seller_id');
				if($this->input->post("Discount_rule_for")==2)//Category
				{
					for($i=0;$i<count($Category_id);$i++)
					{
						$insert_data=array
						(
						'Company_id'=>$Company_id,
						'Seller_id'=>$Seller_id,
						'Discount_code'=>$this->input->post("Discount_code"),
						'Discount_rule_name'=>$this->input->post("Discount_rule_name"),
						'Discount_rule_for'=>$this->input->post("Discount_rule_for"),
						'Discount_rule_set'=>$this->input->post("Discount_rule_set"),
						'Discount_Percentage_Value'=>$this->input->post("Discount_Percentage_Value"),
						'Operator'=>$Operator,
						'Criteria_value'=>$Criteria_value,
						'Category_id'=>$Category_id[$i],
						'Valid_from'=>date('Y-m-d',strtotime($this->input->post("Valid_from"))),
						'Valid_till'=>date('Y-m-d',strtotime($this->input->post("Valid_till"))),
						'Discount_voucher_applicable'=>$this->input->post("Discount_voucher_applicable"),
						'Tier_id'=>$this->input->post("Tier_id"),
						'Create_user_id'=>$data['enroll'],
						'Create_date'=>date('Y-m-d H:i:s'),
						'Active_flag'=>1,
						'Maximum_limit' => $this->input->post("max_discount"),
						'Channel_id' => $ChannelId,
						'Payment_type_id' =>$PaymentId
								
						);
						$result = $this->Administration_model->insert_new_discount_rule_master($insert_data);
					}
				}
				else
				{
					$insert_data=array
					(
						'Company_id'=>$Company_id,
						'Seller_id'=>$Seller_id,
						'Discount_code'=>$this->input->post("Discount_code"),
						'Discount_rule_name'=>$this->input->post("Discount_rule_name"),
						'Discount_rule_for'=>$this->input->post("Discount_rule_for"),
						'Discount_rule_set'=>$this->input->post("Discount_rule_set"),
						'Discount_Percentage_Value'=>$this->input->post("Discount_Percentage_Value"),
						'Operator'=>$Operator,
						'Criteria_value'=>$Criteria_value,
						'Category_id'=>$Category_id,
						'Valid_from'=>date('Y-m-d',strtotime($this->input->post("Valid_from"))),
						'Valid_till'=>date('Y-m-d',strtotime($this->input->post("Valid_till"))),
						'Discount_voucher_applicable'=>$this->input->post("Discount_voucher_applicable"),
						'Tier_id'=>$this->input->post("Tier_id"),
						'Create_user_id'=>$data['enroll'],
						'Create_date'=>date('Y-m-d H:i:s'),
						'Active_flag'=>1,
						'Maximum_limit' => $this->input->post("max_discount"),
						'Channel_id' => $ChannelId,
						'Payment_type_id' =>$PaymentId
								
					);
					$result = $this->Administration_model->insert_new_discount_rule_master($insert_data);
				}
				
								
							
					
				
				/****************Item Level*********************************/
				if($this->input->post("Discount_rule_for")==3)//Item Level
				{
					
					$linked_itemcode=$this->input->post("linked_itemcode");
					$linked_Discount_percentage_or_value=$this->input->post("linked_Discount_percentage_or_value");
					if($linked_itemcode != "")
					{
						$Delete_discount_items = $this->Administration_model->Delete_discount_items($data['Company_id'],$this->input->post("Discount_code"));
						$exp_itm = explode(',',$linked_itemcode);
						$exp_Discount_percentage_or_value = explode(',',$linked_Discount_percentage_or_value);
						
						for($i=0;$i<count($exp_itm);$i++)
						{
							$Post_data=array('Company_id'=>$data['Company_id'],
							'Item_code'=>$exp_itm[$i],
							'Category_id'=>$Category_id,
							'Discount_code'=>$this->input->post("Discount_code"),
							'Discount_percentage_or_value'=>$exp_Discount_percentage_or_value[$i]
							);
					
							$Insert_items = $this->Administration_model->Insert_items_discount_child($Post_data);
						}
					}
				}
				/****************************************************/
				
				if($result == true)
				{
					
					
				/*******************Insert igain Log Table*********************/
					
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create New Discount Rule Master";
					$where="Create Discount Rule Master";
					$toname="";
					$To_enrollid =0;
					$Partner_id =0;
					$firstName = '';
					$lastName = '';
					
					$opval = $this->input->post('Discount_code').' ( '.$this->input->post('Discount_rule_name').' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$username,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				$this->session->set_flashdata("success_code","Discount Rule Created Successfully!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN Discount Rule Creation !");
				}
				//die;
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	
	function edit_new_discount_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Logged_user_id'] = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
			$data["get_payement_type"] = $this->Igain_model->get_payement_type();
		
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			
			$data["Merchandize_Category_Records"] = $this->Administration_model->Get_Merchandize_Category1('', '',$Company_id);
			$Discount_id = $_REQUEST['Discount_id'];
			if($_POST == NULL)
			{
				
				
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				$data["Fetch_discount_rule"] = $this->Administration_model->edit_new_discount_rule($Discount_id,$Company_id);
				
				$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;
				$data["results2"] = $this->Administration_model->Fetch_new_discount_rule_master($Company_id);	
				$this->load->view('administration/edit_new_discount_rule',$data);	

			}
			else
			{	
				$Discount_code=$this->input->post("Discount_code");
				
				$ChannelId = 0;
				$PaymentId = 0;
					
				if($this->input->post("Discount_rule_for")==1)//Overall Bill Level
				{
					$Operator=$this->input->post("Operator");
					$Criteria_value=$this->input->post("Criteria_value");
					$Category_id=0;
					
					
					$Delete_discount_items = $this->Administration_model->Delete_discount_items($Company_id,$Discount_code);
				}
				elseif($this->input->post("Discount_rule_for")==2)//Category Level
				{
					$Operator=0;
					$Criteria_value=0;
					$Category_id=$this->input->post("Category_id");
					
					$Delete_discount_items = $this->Administration_model->Delete_discount_items($Company_id,$Discount_code);
				}
				else if($this->input->post("Discount_rule_for")==3) // item level
				{
					
					$Operator=0;
					$Criteria_value=0;
				}
				else if($this->input->post("Discount_rule_for")==4)// channel Level
				{
					$Category_id=0;
					$Operator=0;
					$Criteria_value=0;
					
					$ChannelId = $this->input->post("Trans_Channel");
				}
				else if($this->input->post("Discount_rule_for")==5)// payment type Level
				{
					$Category_id=0;
					$Operator=0;
					$Criteria_value=0;

					$PaymentId = $this->input->post("Payment_Type_id");
				}
				/****************Item Level*********************************/
				if($this->input->post("Discount_rule_for")==3)//Item Level
				{
					$linked_itemcode=$this->input->post("linked_itemcode");
					$linked_Discount_percentage_or_value=$this->input->post("linked_Discount_percentage_or_value");
					$Category_id=$this->input->post("linked_Category_id");
					if($linked_itemcode != "")
					{
						
						$Delete_discount_items = $this->Administration_model->Delete_discount_items($data['Company_id'],$Discount_code);
						$exp_itm = explode(',',$linked_itemcode);
						$exp_Discount_percentage_or_value = explode(',',$linked_Discount_percentage_or_value);
						
						for($i=0;$i<count($exp_itm);$i++)
						{
							$Post_data=array('Company_id'=>$data['Company_id'],
							'Item_code'=>$exp_itm[$i],
							'Category_id'=>$Category_id,
							'Discount_code'=>$Discount_code,
							'Discount_percentage_or_value'=>$exp_Discount_percentage_or_value[$i]
							);
					
							$Insert_items = $this->Administration_model->Insert_items_discount_child($Post_data);
						}
					}
				}
				/****************************************************/
				$Update_data=array
							(
								'Seller_id'=>$this->input->post("Seller_id"),
								'Discount_rule_name'=>$this->input->post("Discount_rule_name"),
								'Discount_rule_for'=>$this->input->post("Discount_rule_for"),
								'Discount_rule_set'=>$this->input->post("Discount_rule_set"),
								'Discount_Percentage_Value'=>$this->input->post("Discount_Percentage_Value"),
								'Operator'=>$Operator,
								'Criteria_value'=>$Criteria_value,
								'Category_id'=>$Category_id,
								'Valid_from'=>date('Y-m-d',strtotime($this->input->post("Valid_from"))),
								'Valid_till'=>date('Y-m-d',strtotime($this->input->post("Valid_till"))),
								'Discount_voucher_applicable'=>$this->input->post("Discount_voucher_applicable"),
								'Tier_id'=>$this->input->post("Tier_id"),
								'Update_user_id'=>$data['enroll'],
								'Update_date'=>date('Y-m-d H:i:s'),
								'Maximum_limit' => $this->input->post("max_discount"),
								'Channel_id' => $ChannelId,
								'Payment_type_id' =>$PaymentId
							);
				$result = $this->Administration_model->Update_new_discount_rule_master($Update_data,$Discount_id);
				
				if($result == true)
				{
					
					
				/*******************Insert igain Log Table*********************/
					
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update New Discount Rule Master";
					$where="Create Discount Rule Master";
					$toname="";
					$To_enrollid =0;
					$Partner_id =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $this->input->post("Seller_id");
					$opval = $Discount_id;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				$this->session->set_flashdata("success_code","Discount Rule Updated Successfully!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN Discount Rule Update !");
				}
				//die;
				redirect('Administration/Discount_rule_master');
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	
	public function Get_items_for_discount()
	{
		$data['Company_id']=$this->input->post("Company_id");
		$data['Discount_code']=$this->input->post("Discount_code");
		
		$data['Get_Linked_Items_for_discount'] = $this->Administration_model->Get_Linked_Items_for_discount($this->input->post("Item"),$this->input->post("Company_id"));
		
		
		
		$theHTMLResponse = $this->load->view('administration/Get_items_for_discount', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Items_by_category'=> $theHTMLResponse)));
	}
	public function Save_items_for_discount_rule()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Item_code=$this->input->post("Item_code");
		$Merchandize_item_name=$this->input->post("Merchandize_item_name");
		$Discount_code=$this->input->post("Discount_code");
		$Merchandize_category_id=$this->input->post("Merchandize_category_id");
		$Discount_percentage_or_value=$this->input->post("Discount_percentage_or_value");
		$Merchandize_category_name=$this->input->post("Merchandize_category_name");
		
		
		
			// $Delete_discount_items = $this->Administration_model->Delete_discount_items($data['Company_id'],$Discount_code);
			// echo count($Item_code);die;
		
			for($i=0; $i<count($Item_code); $i++)
			{
				
				/* $Post_data=array('Company_id'=>$data['Company_id'],
				'Item_code'=>$Item_code[$i],
				'Category_id'=>$Merchandize_category_id,
				'Discount_code'=>$Discount_code,
				'Discount_percentage_or_value'=>$Discount_percentage_or_value[$i]
				);
				//echo "<br><br>Item_code::".$Item_code[$i]." Category_id::".$Merchandize_category_id[$i]." Discount_percentage_or_value::".$Discount_percentage_or_value[$i];
				if($Item_code[$i] != '' && $Merchandize_category_id!=0 && $Discount_percentage_or_value[$i]!="" )
				{
					$Insert_items = $this->Administration_model->Insert_items_discount_child($Post_data);
				} */
				
				$Item_code2[]= $Item_code[$i];
				$Merchandize_item_name2[]= $Merchandize_item_name[$i];
				$Category_id= $Merchandize_category_id;
				$Discount_code= $Discount_code;
				$Discount_percentage_or_value2[]= $Discount_percentage_or_value[$i];
				$Merchandize_category_name2[]= $Merchandize_category_name[$i];
				
			}
			$data['Item_code3'] = $Item_code2;
			$data['Merchandize_item_name3'] = $Merchandize_item_name2;
			$data['Discount_percentage_or_value3'] = $Discount_percentage_or_value2;
			$data['Merchandize_category_name3'] = $Merchandize_category_name2;
			//die;
		//die;
		// $data['Get_linked_discount__items'] = $this->Administration_model->Get_linked_items_discount_child($data['Company_id'],$Discount_code);
		 $theHTMLResponse = $this->load->view('administration/Get_linked_discount__items', $data, true);		
		$this->output->set_content_type('application/json');
		// $this->output->set_output(json_encode(array('Linked_items'=> $theHTMLResponse)));
		$this->output->set_output(json_encode(array('linked_itemcode'=> $Item_code2,'linked_Discount_percentage_or_value'=> $Discount_percentage_or_value2,'linked_Category_id'=> $Category_id,'Linked_items'=> $theHTMLResponse)));
	}
	
	function Check_Discount_code()
	{
		$result = $this->Administration_model->Check_Discount_code($this->input->post("Discount_code"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output(0);
		}
		else    
		{
			$this->output->set_output(1);
		}
	}	
		
	function delete_new_discount_rule()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			
			if($_GET != NULL)
			{	
				$Discount_id =  $_GET['Discount_id'];	
				
				$result = $this->Administration_model->delete_new_discount_rule($Discount_id,$Company_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Discount Rule Deleted Successfuly!!");
					
					$Todays_date = date('Y-m-d');	
					$opration = 3;				
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Delete Discount Rule";
					$where="Create Discount Rule";
					$toname="";
					// $opval = 4; // transaction type
					$To_enrollid =0;
					$firstName = $session_data['Full_name'];
					$lastName = '';  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $Discount_id; // loyalty id
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$data['enroll']);
					
				/**********************Nilesh change igain Log Table change 14-06-2017*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Discount Rule !!");
				}
				
				
				redirect('Administration/Discount_rule_master');
			}
			else
			{	
				$this->load->view('administration/Discount_rule',$data);	
			}
			
	
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
//******* offer rule sandeep 18-05-2020 *************
	public function get_seller_menu_groups()
	{
	
		$seller_id = $this->input->post('seller_id');
		$StampFlag = $this->input->post('StampFlag');
		$Company_id = $this->input->post('Company_id');
		
		$data['MenuGrpArray'] = $this->Administration_model->get_offer_menu_groups($seller_id,$Company_id,$StampFlag);
		
		$opText = $this->load->view("POS_Catalogue/get_seller_menu_groups",$data, true);
		
		
		//echo $opText;
		if($opText != null)
		{
			$this->output->set_content_type('text/html');
			$this->output->set_output($opText);
		}
	}
	//******* offer rule sandeep 18-05-2020 *************
}
?>