<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();			
		$this->load->database();
		$this->load->helper('url');
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

			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/loyalty_rule";
				$total_row = $this->Administration_model->loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id);	
				 
				// echo "--total_row---".$total_row."--<br>";	
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
		
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
		
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
				$this->session->set_flashdata("error_code","Loyalty Rule Created Successfully!!");
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
			
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/loyalty_rule";
			$total_row = $this->Administration_model->loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id);$total_row = $this->Administration_model->loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id);
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
				$data["results2"] = $this->Administration_model->loyalty_rule_list($config["per_page"], $page,$Company_id);
				$data["pagination"] = $this->pagination->create_links();	
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
			
				$result20 = $this->Administration_model->update_loyalty_rule();
				
				if($result20 == true)
				{
					$this->session->set_flashdata("error_code","Loyalty Rule Updated Successfully!!");
					
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
					$this->session->set_flashdata("error_code","Loyalty Rule Deleted Successfuly!!");
					
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
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
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
		
			if($_POST == NULL)
			{
				$data["pagination"] = $this->pagination->create_links();
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
				$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				$data["results5"] = "";
				$this->load->view('administration/promo_campaign',$data);	

			}
			else if(isset($_POST['Upload']))
			{
				/*-----------------------File Upload---------------------*/
			
				$config['upload_path']   = dirname($_SERVER["SCRIPT_FILENAME"])."/Promo_codes/";
                $config['upload_url']   = base_url()."Promo_codes/";

				$config['allowed_types'] = 'xlsx|xls|csv';
				$config['max_size'] = '1000';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = 'false';
				$config['overwrite'] = 'true';				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if ( ! $this->upload->do_upload("file"))
				{			
					$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$filepath = "";
					$filename = "";
					$block_me = 0;

				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "Promo_codes/".$data['upload_data']['file_name'];
					$filename = $data['upload_data']['file_name'];
					$block_me = 1;
				}
				
			/*-----------------------File Upload---------------------*/
				$data['LogginUserName'] = $session_data['Full_name'];
				
				$promo_cmp_id = $this->Administration_model->upload_promo_campaign_file($filepath,$filename,$Company_id);
				
				if($promo_cmp_id > 0 && $block_me == 1)
				{
					$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
					$this->session->set_flashdata("error_code","Promo Campaign File Upload Successfully!!");
					
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
					$data["results3"] = "";
					$this->session->set_flashdata("error_code","Promo Campaign File Is Not Uploaded !");
				}
				$data["pagination"] = $this->pagination->create_links();
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
				

				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				$data["results5"] = $this->Administration_model->promo_campaign_details($Company_id,$promo_cmp_id);
			
				$this->load->view('administration/promo_campaign',$data);	

			}
			else if(isset($_POST['Submit']))
			{			
			
				$result = $this->Administration_model->insert_promo_campaign($Company_id);

				if($result == true)
				{
				
				$this->session->set_flashdata("error_code","Promo Campaign Created Successfully!!");
				
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
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
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
				
			if($_GET != NULL)
			{	
				$Campaign_id =  $_GET['Campaign_id'];	
				$CompID =  $_GET['CompID'];	
				$FileName =  $_GET['FileName'];	
				$flag =  $_GET['flag'];
				
				// echo "Campaign_id ---".$Campaign_id ;
				// echo "CompID ---".$CompID ;
				// echo "flag ---".$flag ; 
				$data["results5"] = $this->Administration_model->promo_campaign_details($CompID,$Campaign_id);
				foreach($data["results5"]  as $results5)
				{
					$campaign_name=$results5->Pomo_campaign_name;
				}				
				$result = $this->Administration_model->delete_promocampaign($Campaign_id,$CompID,$FileName,$flag);							
				if($flag == 1)	
				{
					$data["results5"] = $this->Administration_model->promo_campaign_details($CompID,$Campaign_id);
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
					$this->session->set_flashdata("error_code","Promo Campaign Deleted Successfuly!!");					
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
				
				$this->load->view('administration/promo_campaign',$data);
				//redirect(current_url());
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
				
				$this->load->view('administration/communication', $data);
			}
			else
			{			
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
					
					if(!$this->upload->do_upload("file"))
					{			
						// $filepath = base_url()."images/no_image.jpeg";
						$filepath = "";
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = base_url()."Offer_images/".$data['upload_data']['file_name'];
					}
					// echo"---filepath----".$filepath."---<br>";
					$result = $this->Administration_model->insert_communication($filepath);
					if($result == true)
					{
						$this->session->set_flashdata("communication_error_code","New Communication  Created Successfully!!");
						
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
					//redirect(current_url());
					
					redirect("Administration/communication");
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
							
						$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
						//
						$Customer_array=array();
						
							$all_customers = $this->Igain_model->get_all_customers($compid);	
							foreach ($all_customers as $row)
							{
								// echo "<b>First_name ".$row["First_name"]."</b>";
								$Applicable_array[]=0;
								
								unset($Applicable_array);
								//print_r($Applicable_array);
								foreach($Get_segments2 as $Get_segments)
								{
									// echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
									// echo "<br>";
									if($Get_segments->Segment_type_id==1)  // 	Age 
									{
										$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
										// echo "****Age--".$lv_Cust_value;
									}
											
									if($Get_segments->Segment_type_id==2)//Sex
									{
										$lv_Cust_value=$row['Sex'];
										// echo "****Sex ".$lv_Cust_value;
									}
									if($Get_segments->Segment_type_id==3)//Country
									{
										$lv_Country_id=$row['Country_id'];
										// echo "****Country_id ".$lv_Country_id;
										$currency_details = $this->currency_model->edit_currency($lv_Country_id);
										$lv_Cust_value = $currency_details->Country_name;
										// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==4)//District
									{
										$lv_Cust_value=$row['District'];
										
										// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==5)//State
									{
										$lv_Cust_value=$row['State'];
										
										// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==6)//city
									{
										$lv_Cust_value=$row['City'];
										
										// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==7)//Zipcode
									{
										$lv_Cust_value=$row['Zipcode'];
										
										// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
									{
										$lv_Cust_value=$row['total_purchase'];
										
										// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
									{
										$lv_Cust_value=$row['Total_reddems'];
										
										// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
									{
										$start_date=$row['joined_date'];
										$end_date=date("Y-m-d");
										$transaction_type_id=2;
										$Tier_id=$row['Tier_id'];
										
										$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
										foreach($Trans_Records as $Trans_Records){
											$lv_Cust_value=$Trans_Records->Total_Gained_Points;
										}
										
										// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
									{
										$start_date=$row['joined_date'];
										$end_date=date("Y-m-d");
										$transaction_type_id=2;
										$Tier_id=$row['Tier_id'];
										
										$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
										foreach($Trans_Records as $Trans_Records){
											$lv_Max_amt[]=$Trans_Records->Purchase_amount;
										}
										$lv_Cust_value=max($lv_Max_amt);
										// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==12)//Membership Tenor
									{
										$tUnixTime = time();
										list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
										$timeStamp = mktime(0, 0, 0, $month, $day, $year);
										$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
										// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
									}
									
									$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
										
									$Applicable_array[]=$Get_segments;
								}
								// print_r($Applicable_array);
								
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
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
								
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details->description,
												'facebook' => $this->input->post("facebook_social1"),
												'twitter' => $this->input->post("twitter_social1"),
												'googleplus' => $this->input->post("googleplus_social1"),
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

										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details->description,
											'facebook' => $this->input->post("facebook_social"),
											'twitter' => $this->input->post("twitter_social"),
											'googleplus' => $this->input->post("googleplus_social"),
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
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
									
									$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
									$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
															
									$Email_content = array(
										'Communication_id' => $offer_details->id,
										'Offer' => $offer_details->communication_plan,
										'Offer_description' => $offer_details->description,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'facebook' => $this->input->post("facebook_social1"),
										'twitter' => $this->input->post("twitter_social1"),
										'googleplus' => $this->input->post("googleplus_social1"),
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
									$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
								}
								//redirect(current_url());
								
								redirect("Administration/communication");
							}
							else
							{
								$offer_details = $this->Administration_model->get_offer_details($offerid);
								
								$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
								$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
				
																
								$Email_content = array(
									'Communication_id' => $offer_details->id,
									'Offer' => $offer_details->communication_plan,
									'Start_date' => $offer_From_date,
									'End_date' => $offer_Till_date,
									'Offer_description' => $offer_details->description,
									'facebook' => $this->input->post("facebook_social"),
									'twitter' => $this->input->post("twitter_social"),
									'googleplus' => $this->input->post("googleplus_social"),
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
									$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
								}

								//redirect(current_url());
								
								redirect("Administration/communication");
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
										
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));								
										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details->description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
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
									
									$Email_content = array(
										'Communication_id' => $id,
										'Offer' => $communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
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
									$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
									$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
								
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details->description,
												'facebook' => $this->input->post("facebook_social1"),
												'twitter' => $this->input->post("twitter_social1"),
												'googleplus' => $this->input->post("googleplus_social1"),
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
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
									else
									{															
										$offer_details = $this->Administration_model->get_offer_details($offerid);
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));

										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details->description,
											'facebook' => $this->input->post("facebook_social"),
											'twitter' => $this->input->post("twitter_social"),
											'googleplus' => $this->input->post("googleplus_social"),
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
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
								}
							}
						}
						else
						{
							$this->session->set_flashdata("communication_error_code","Error Sending Communication . Customers Not Exist Of This Tier!!");
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
									
												$Email_content = array(
													'Communication_id' => $offer_details->id,
													'Offer' => $offer_details->communication_plan,
													'Start_date' => $offer_From_date,
													'End_date' => $offer_Till_date,
													'Offer_description' => $offer_details->description,
													'facebook' => $this->input->post("facebook_social1"),
													'twitter' => $this->input->post("twitter_social1"),
													'googleplus' => $this->input->post("googleplus_social1"),
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
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
											}
											// redirect(current_url());
										}
										else
										{															
											$offer_details = $this->Administration_model->get_offer_details($offerid);								
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));

										
										$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details->description,
												'facebook' => $this->input->post("facebook_social"),
												'twitter' => $this->input->post("twitter_social"),
												'googleplus' => $this->input->post("googleplus_social"),
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
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										
										$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details->description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
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
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									}
									// redirect(current_url());
								}
								else
								{															
									$offer_details = $this->Administration_model->get_offer_details($offerid);								
										
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										
										$Email_content = array(
										'Communication_id' => $offer_details->id,
										'Offer' => $offer_details->communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $offer_details->description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
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
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
												$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
												$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										
											$Email_content = array(
													'Communication_id' => $offer_details->id,
													'Offer' => $offer_details->communication_plan,
													'Start_date' => $offer_From_date,
													'End_date' => $offer_Till_date,
													'Offer_description' => $offer_details->description,
													'facebook' => $this->input->post("facebook_social1"),
													'twitter' => $this->input->post("twitter_social1"),
													'googleplus' => $this->input->post("googleplus_social1"),
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
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
											}
											// redirect(current_url());
										}
										else
										{															
											$offer_details = $this->Administration_model->get_offer_details($offerid);								
											$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
											$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
											$Email_content = array(
												'Communication_id' => $offer_details->id,
												'Offer' => $offer_details->communication_plan,
												'Start_date' => $offer_From_date,
												'End_date' => $offer_Till_date,
												'Offer_description' => $offer_details->description,
												'facebook' => $this->input->post("facebook_social"),
												'twitter' => $this->input->post("twitter_social"),
												'googleplus' => $this->input->post("googleplus_social"),
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
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
										$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
										$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										
											$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details->description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
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
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									}
									// redirect(current_url());
								}
								else
								{															
									$offer_details = $this->Administration_model->get_offer_details($offerid);								
									$offer_From_date = date("d-M-Y",strtotime($offer_details->From_date));
									$offer_Till_date = date("d-M-Y",strtotime($offer_details->Till_date));
									
										
										$Email_content = array(
										'Communication_id' => $offer_details->id,
										'Offer' => $offer_details->communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $offer_details->description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
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
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
						//redirect("Administration/communication");
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
											$Email_content = array(
											'Communication_id' => $offer_details->id,
											'Offer' => $offer_details->communication_plan,
											'Start_date' => $offer_From_date,
											'End_date' => $offer_Till_date,
											'Offer_description' => $offer_details->description,
											'facebook' => $this->input->post("facebook_social1"),
											'twitter' => $this->input->post("twitter_social1"),
											'googleplus' => $this->input->post("googleplus_social1"),
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
										$Email_content = array(
										'Communication_id' => $id,
										'Offer' => $communication_plan,
										'Start_date' => $offer_From_date,
										'End_date' => $offer_Till_date,
										'Offer_description' => $description,
										'facebook' => $this->input->post("facebook_social"),
										'twitter' => $this->input->post("twitter_social"),
										'googleplus' => $this->input->post("googleplus_social"),
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
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									}
								}							
						redirect(current_url());
						
						//redirect("Administration/communication");
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
			if($_GET == NULL)
			{
				redirect('Administration/communication');
			}
			else
			{				
				$id =  $_GET['id'];
				$seller_id =  $_GET['seller_id'];
				$data['Offer_details'] = $this->Administration_model->edit_communication_offer($id,$seller_id);				
				foreach($data['Offer_details'] as $offer)
				{
					$Company_id = $offer->Company_id;
					$Membership_id = $offer->Membership_id;
				}
				if($Membership_id > 0)
				{
					$Membership_details = $this->Igain_model->get_customer_details_Card_id($Membership_id,$Company_id);
					$data['member_name']=$Membership_details->First_name.' '.$Membership_details->Last_name;
					$data['member_email']=$Membership_details->User_email_id;				
					$data['member_phone']=$Membership_details->Phone_no;					
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
			$config['upload_path'] = './Offer_images/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '800';
			$config['max_width'] = '1400';
			$config['max_height'] = '1080';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			
			if(!$this->upload->do_upload("file"))
			{	
				//$filepath = base_url()."images/no_image.jpeg";
				$filepath = $this->input->post("Share_file_path");				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data("file"));
				$filepath = base_url()."Offer_images/".$data['upload_data']['file_name'];
			}
			$result = $this->Administration_model->update_communication_offer($filepath);
			$this->session->set_flashdata("communication_error_code","Communication  Updated Successfuly!!");
			
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
			
			if($_GET == NULL)
			{
				redirect('Administration/communication', 'refresh');
			}
			else
			{ 
		
		
		
		
				$id =  $_GET['id'];
				$seller_id =  $_GET['seller_id'];
				$data['Offer_details'] = $this->Administration_model->edit_communication_offer($id,$seller_id);				
				foreach($data['Offer_details'] as $offer)
				{
					// $Company_id = $offer->Company_id;
					$communication_plan = $offer->communication_plan;
				}
				
				
				$result = $this->Administration_model->delete_communication_offer($id,$seller_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("communication_error_code","Communication  Deleted Successfuly!!");
					/******************igain log_tbl insert*********************/
					$id =  $_GET['id'];
					$seller_id =  $_GET['seller_id'];
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
					$this->session->set_flashdata("communication_error_code","Error Deleting Communication !!");
				}
				redirect('Administration/communication', 'refresh');
			}
		}
	}
	
	public function communication_acivate_deactivate()
	{
		if($this->session->userdata('logged_in'))
		{
			if($_GET == NULL)
			{
				redirect('Administration/communication', 'refresh');
			}
			else
			{	
				$id =  $_GET['id'];
				$seller_id =  $_GET['seller_id'];
				$activate =  $_GET['activate'];				
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
				redirect('Administration/communication', 'refresh');
			}
		}
	}
	
	public function check_communication_offer()
	{
		$result = $this->Administration_model->check_communication_offer($this->input->post("communication_plan"),$this->input->post("Seller_id"));
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
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
		$config['max_size'] = '800';
		$config['max_width'] = '1400';
		$config['max_height'] = '1080';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		/*-----------------------File Upload---------------------*/
		
		if ( ! $this->upload->do_upload("file"))
		{			
			$message = '-1';
			$filepath = "";
		}
		else
		{
			$data = array('upload_data' => $this->upload->data("file"));
			$message = '1';
			$filepath = "Offer_images/".$data['upload_data']['file_name'];
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
			if($_POST == NULL)
			{
				$data["results"] = $this->Administration_model->auction_list($config["per_page"], $page, $session_data['Company_id']);			
				$data["pagination"] = $this->pagination->create_links();
				
				$this->load->view('administration/create_auction',$data);
			}
			else
			{
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './Auction_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = TRUE;	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
			
				if ( !$this->upload->do_upload("file"))
				{			
					$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$filepath = "";
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "Auction_images/".$data['upload_data']['file_name'];
				}
				
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
					$this->session->set_flashdata("error_code","Auction Created Successfuly..!!");
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
			
			if($_GET == NULL)
			{
				redirect("Administration/auction");
			}
			else
			{	
				$Auction_id =  $_GET['Auction_id'];
				$auction_details = $this->Administration_model->edit_auction($Auction_id);
				$Auction_name=$auction_details->Auction_name;
				$result = $this->Administration_model->delete_auction($Com_id,$Auction_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Deleted Successfuly..!!");
					
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
			
			if($_GET['Auction_id'])
			{
				$data["results2"] = $this->Administration_model->auction_list($config["per_page"], $page, $session_data['Company_id']);			
				$data["pagination"] = $this->pagination->create_links();

				$Auction_id =  $_GET['Auction_id'];			
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
				$config['upload_path'] = './Auction_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = TRUE;				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
			
				if(empty($_FILES['file']['name']))
				{
					$filepath = $this->input->post('Auction_image');
				}
				else
				{
					if ( !$this->upload->do_upload("file"))
					{			
						$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
						$filepath = $this->input->post('Auction_image');
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = "Auction_images/".$data['upload_data']['file_name'];						
					}
				}				
				
				$Auction_id = $this->input->post('Auction_id');
				$auction_details = $this->Administration_model->edit_auction($Auction_id);
				$Auction_name=$auction_details->Auction_name;
				$result = $this->Administration_model->update_auction($filepath);				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Updated Successfuly..!!");
					
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
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
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
				$this->session->set_flashdata("error_code","Auction Winner Approved Successfuly..!!");
				
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
			if($result1 == true && $result2 == true)
			{
				$this->session->set_flashdata("error_code","Auction Winner Deleted Successfuly..!!");
				
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
			}
			else
			{							
				$this->session->set_flashdata("error_code","Error Deleting Auction Winner..!!");
			}
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
					$this->session->set_flashdata("error_code","Referral Rule Created Successfully!!");
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
				
				
				$this->session->set_flashdata("error_code","Transaction done Successfully!!");
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
					$this->session->set_flashdata("error_code","Referral Rule created Successfuly for All Merchant(s)!!!");
				}
				elseif(count($exist_merchant_array)!=0 && $flag==1)
				{
					$this->session->set_flashdata("error_code","Referral Rule created Successfuly!!!<br>Referral Rule already exist for Merchant(s) ($Join_names) !!!");
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
							$this->session->set_flashdata("error_code","Referral Rule Created Successfully!!");
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
							$this->session->set_flashdata("error_code","Referral Rule created Successfuly for All Merchant(s)!!!");
						}
						elseif(count($exist_merchant_array)!=0 && $flag==1)
						{
							$this->session->set_flashdata("error_code","Referral Rule created Successfuly!!!<br>Referral Rule already exist for Merchant(s) ($Join_names) !!!");
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
							$this->session->set_flashdata("error_code","Referral Rule Created Successfully!!");
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
			$this->session->set_flashdata("error_code","Referral Rule Updated Successfully!!");
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
				$this->session->set_flashdata("error_code","Referral Rule Deleted Successfully!!");
			
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
						$this->session->set_flashdata("communication_error_code","New SMS Communication  Created Successfuly!!");
					}
					else
					{							
						$this->session->set_flashdata("communication_error_code","Error Inserting Communication . Please Provide valid data!!");
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
							
						$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
						//
						$Customer_array=array();
						
						$all_customers = $this->Igain_model->get_all_customers($compid);	
							foreach ($all_customers as $row)
							{
								// echo "<b>First_name ".$row["First_name"]."</b>";
								$Applicable_array[]=0;
								
								unset($Applicable_array);
								//print_r($Applicable_array);
								foreach($Get_segments2 as $Get_segments)
								{
									// echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
									// echo "<br>";
									if($Get_segments->Segment_type_id==1)  // 	Age 
									{
										$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
										// echo "****Age--".$lv_Cust_value;
									}
											
									if($Get_segments->Segment_type_id==2)//Sex
									{
										$lv_Cust_value=$row['Sex'];
										// echo "****Sex ".$lv_Cust_value;
									}
									if($Get_segments->Segment_type_id==3)//Country
									{
										$lv_Country_id=$row['Country_id'];
										// echo "****Country_id ".$lv_Country_id;
										$currency_details = $this->currency_model->edit_currency($lv_Country_id);
										$lv_Cust_value = $currency_details->Country_name;
										// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==4)//District
									{
										$lv_Cust_value=$row['District'];
										
										// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==5)//State
									{
										$lv_Cust_value=$row['State'];
										
										// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==6)//city
									{
										$lv_Cust_value=$row['City'];
										
										// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
										
										if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
										{
											$Get_segments->Value=$lv_Cust_value;
										}
									}
									if($Get_segments->Segment_type_id==7)//Zipcode
									{
										$lv_Cust_value=$row['Zipcode'];
										
										// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
									{
										$lv_Cust_value=$row['total_purchase'];
										
										// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
									{
										$lv_Cust_value=$row['Total_reddems'];
										
										// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
									{
										$start_date=$row['joined_date'];
										$end_date=date("Y-m-d");
										$transaction_type_id=2;
										$Tier_id=$row['Tier_id'];
										
										$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
										foreach($Trans_Records as $Trans_Records){
											$lv_Cust_value=$Trans_Records->Total_Gained_Points;
										}
										
										// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
									{
										$start_date=$row['joined_date'];
										$end_date=date("Y-m-d");
										$transaction_type_id=2;
										$Tier_id=$row['Tier_id'];
										
										$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
										foreach($Trans_Records as $Trans_Records){
											$lv_Max_amt[]=$Trans_Records->Purchase_amount;
										}
										$lv_Cust_value=max($lv_Max_amt);
										// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
									}
									if($Get_segments->Segment_type_id==12)//Membership Tenor
									{
										$tUnixTime = time();
										list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
										$timeStamp = mktime(0, 0, 0, $month, $day, $year);
										$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
										// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
									}
									
									$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
										
									$Applicable_array[]=$Get_segments;
								}
								// print_r($Applicable_array);
								
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
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
									
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
								
								
									$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
								}
								else
								{							
									$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
										
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
										}
									}
								}
							}
						}
						else
						{
							$this->session->set_flashdata("communication_error_code","Error Sending Communication . Customers Not Exist Of This Tier!!");
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
													$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
												}
												else
												{							
													$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											
											
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
									
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
													$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
												}
												else
												{							
													$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											
												$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
										}
										else
										{							
											$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
									
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
						
						//redirect("Administration/communication");
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
											$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
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
										$this->session->set_flashdata("communication_error_code","Communication  Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("communication_error_code","Error Sending Communication . Please Provide valid data!!");
									}
									}
								}
							}

									
							
							
						redirect(current_url());
						
						//redirect("Administration/communication");
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
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/offer_rule";
				$total_row = $this->Administration_model->offer_rule_count($Company_id);		
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
				
			$data["results2"] = $this->Administration_model->offer_rule_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();		
			/*-----------------------Pagination---------------------*/	
			if($_POST == NULL)
			{
				$today_date=date("Y-m-d");		
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				$data["Offer_item_details"] = $this->Administration_model->get_offer_item_details($Company_id,$today_date);
				
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
				
				$check_item_offer_result = $this->Administration_model->check_item_offers($this->input->post("Offer_name"),$this->input->post("Company_id"),$this->input->post("Company_merchandise_item_id"),$this->input->post("Buy_item"),$this->input->post("Free_item"));
				
				// echo"----check_item_offer_result-------".$check_item_offer_result."---<br>";
				// die;
				if($check_item_offer_result == 0 )
				{
					$Item_id=$this->input->post("Company_merchandise_item_id");
					$Buy_item=$this->input->post("Buy_item");
					$Free_item=$this->input->post("Free_item");
					
					$insert_data=array
									(
										'Company_id'=>$this->input->post("Company_id"),
										'Company_merchandise_item_id'=>$this->input->post("Company_merchandise_item_id"),
										'Offer_name'=>$this->input->post("Offer_name"),
										'Buy_item'=>$this->input->post("Buy_item"),
										'Free_item'=>$this->input->post("Free_item"),
										'From_date'=>date('Y-m-d',strtotime($this->input->post("start_date"))),
										'Till_date'=>date('Y-m-d',strtotime($this->input->post("end_date"))),
										'Active_flag'=>$this->input->post("Offer_status"),
										'Free_item_id'=>$this->input->post("Free_item_id"),
										'Seller_id'=>0
									);
					$result = $this->Administration_model->insert_offer_rule($insert_data);
				}
				else
				{
					$this->session->set_flashdata("error_code","Offer rule already exist!!");
					redirect(current_url());
				}			
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Offer Rule Created Successfully!!");
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
					$opval = $this->input->post("Offer_name").', ( Item_id = '.$Item_id.', Buy Item = '.$Buy_item.', Free Item = '.$Free_item.' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
					/*******************************Offer log tbl change**********************************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error IN offer Rule Creation !");
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
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
		
	}
	public function get_offer_item()
	{
		$today_date=date("Y-m-d");
		$data["Offer_item_details"] = $this->Administration_model->get_offer_item_details($this->input->post("Company_id"),$today_date);
		$data['offers_item_name'] = $this->Administration_model->get_offer_item($this->input->post("item_id"),$this->input->post("Company_id"),$today_date);
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
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/offer_rule";
			$total_row = $this->Administration_model->offer_rule_count($Company_id);		
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
			
			$data["results2"] = $this->Administration_model->offer_rule_list($config["per_page"], $page,$Company_id);
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
			
			if($_GET['offer_id'])
			{	
				$Offer_id =  $_GET['offer_id'];
				$today_date=date("Y-m-d");
				$Item_result = $this->Administration_model->edit_offer_rule($Offer_id,$Company_id);	
				$data['results']=$Item_result;
				// echo"---Company_merchandize_item_code------".$Item_result->Company_merchandize_item_code."<br>";
				$data["Check_offer_exist"] = $this->Administration_model->Check_offer_exist_trans($Item_result->Company_merchandize_item_code,$Company_id);	
				// echo"---Check_offer_exist------".$data["Check_offer_exist"]."<br>";
				$data["Offer_item_details"] = $this->Administration_model->get_offer_item_details($Company_id,$today_date);				
				
				$data['offers_item_name'] = $this->Administration_model->get_offer_item($Item_result->Free_item_id,$Item_result->Company_id,$today_date);	
				
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
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Administration/offer_rule";
				$total_row = $this->Administration_model->offer_rule_count($Company_id);		
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
				
			$data["results2"] = $this->Administration_model->offer_rule_list($config["per_page"], $page,$Company_id);
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

				$this->load->view('administration/offer_rule',$data);	

			}
			else
			{			
			
				/* $check_item_offer_result = $this->Administration_model->check_item_offers($this->input->post("Offer_name"),$this->input->post("Company_id"),$this->input->post("Company_merchandise_item_id"),$this->input->post("Buy_item"),$this->input->post("Free_item"));
				if($check_item_offer_result == 0 )
				{ */
					$result20 = $this->Administration_model->update_offer_rule();
				/* }
				else
				{
					$this->session->set_flashdata("error_code","Offer Rule Already Exist!");
					redirect("Administration/offer_rule");
				} */			
				if($result20 == true)
				{
					$this->session->set_flashdata("error_code","Offer Rule Updated Successfully!!");
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
					$opval = $this->input->post("Offer_name").', ( Item_id = '.$Item_id.', Buy Item = '.$Buy_item.', Free Item = '.$Free_item.' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
					/*******************************Offer log tbl change**********************************/
				}
				else
				{							
					$this->session->set_flashdata("error_code"," Not any changes for updated!");
				}
				redirect("Administration/offer_rule");
			}
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
				$offer_id =  $_GET['offer_id'];	
				$results= $this->Administration_model->edit_offer_rule($offer_id,$Company_id);	
				$Offer_name=$results->Offer_name;
				
				$result = $this->Administration_model->delete_offer_rule($offer_id,$Company_id);				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Offer Rule Deleted Successfuly!!");
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
					$opval =$Offer_name;
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
	/***********Nilesh 27-07-2018 loyalty rule for category/Segment/Flat File*************/
}
?>