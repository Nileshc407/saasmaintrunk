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
				
				$result = $this->Administration_model->delete_loyaltyrule($Loyalty_id,$Company_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Loyalty Rule Deleted Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Loyalty Rule !!");
				}
				
				
				redirect(current_url());
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
				$total_row = $this->Administration_model->promo_campaign_count();		
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
				
				$result = $this->Administration_model->upload_promo_campaign_file($filepath,$filename,$Company_id);
				
				if($result == true && $block_me == 1)
				{
					$this->session->set_flashdata("error_code","Promo Campaign File Upload Successfully!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Promo Campaign File Is Not Uploaded !");
				}
				$data["pagination"] = $this->pagination->create_links();
				$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
				$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);

				$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
			
				$this->load->view('administration/promo_campaign',$data);	

			}
			else if(isset($_POST['Submit']))
			{			
			
				$result = $this->Administration_model->insert_promo_campaign($Company_id);

				if($result == true)
				{
					$this->session->set_flashdata("error_code","Promo Campaign Created Successfully!!");
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
		$total_row = $this->Administration_model->promo_campaign_count();		
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
			$data["results2"] = $this->Administration_model->promo_campaign_list($config["per_page"], $page,$Company_id);
			$data["results3"] = $this->Administration_model->promo_campaign_file_list($Company_id);
			$data["results4"] = $this->Administration_model->promo_tmp_campaign_details($Company_id);
				
			if($_GET != NULL)
			{	
				$Campaign_id =  $_GET['Campaign_id'];	
				$CompID =  $_GET['CompID'];	
				$FileName =  $_GET['FileName'];	
				$flag =  $_GET['flag'];	
						
				$result = $this->Administration_model->delete_promocampaign($Campaign_id,$CompID,$FileName,$flag);
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Promo Campaign Deleted Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Promo Campaign !!");
				}
				
				
				redirect(current_url());
			}
			else
			{
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
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/communication";
			$total_row = $this->Administration_model->communication_count($session_data['Company_id']);	
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
				$data["results"] = $this->Administration_model->communication_offer_list($config["per_page"], $page, $session_data['Company_id']);			
				$data["pagination"] = $this->pagination->create_links();
				
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["company_sellers"] = $this->Igain_model->get_company_sellers($data['Company_id']);
				$this->load->view('administration/communication', $data);
			}
			else
			{				
				if( $this->input->post("submit") == "Register" )
				{
					$result = $this->Administration_model->insert_communication();
					if($result == true)
					{
						$this->session->set_flashdata("error_code","New Communication Offer Created Successfuly!!");
					}
					else
					{							
						$this->session->set_flashdata("error_code","Error Inserting Communication Offer. Please Provide valid data!!");
					}
					redirect(current_url());
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
										'Template_type' => 'Communication'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
								}
								if($send_notification == true)
								{
									$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
								}
								else
								{							
									$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
								}
								redirect(current_url());
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
								
								if($send_notification == true)
								{
									$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
								}
								else
								{							
									$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
								}

								redirect(current_url());
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
											'Template_type' => 'Communication'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
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
										'Template_type' => 'Communication'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
								}
							}

							if($radio1 == 3)
							{
								if($send_notification == true)
								{
									$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
								}
								else
								{							
									$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
								}
							}
							else
							{
								if(count($cust_emails) == $send_notification)
								{
									$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
								}
								else
								{							
									$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
								}
							}
							redirect(current_url());							
						}
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
													'Template_type' => 'Communication'
												);								
												$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											}
											if($send_notification == true)
											{
												$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
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
												'Template_type' => 'Communication'
											);							
											$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											
											if($send_notification == true)
											{
												$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
											}
											// redirect(current_url());
										}
									}
								}
								redirect(current_url());
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
											'Template_type' => 'Communication'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									}
									if($send_notification == true)
									{
										$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
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
										'Template_type' => 'Communication'
									);							
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									
									if($send_notification == true)
									{
										$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
									}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
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
													'Template_type' => 'Communication'
												);								
												$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											}
											if($send_notification == true)
											{
												$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
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
												'Template_type' => 'Communication'
											);								
											$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
											
											if($send_notification == true)
											{
												$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
											}
											// redirect(current_url());
										}
									}
								}
								redirect(current_url());
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
											'Template_type' => 'Communication'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									}
									if($send_notification == true)
									{
										$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
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
										'Template_type' => 'Communication'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$sellerid,$compid);
									
									if($send_notification == true)
									{
										$this->session->set_flashdata("error_code","Communication Offer Send Successfuly!!");
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Communication Offer. Please Provide valid data!!");
									}
									// redirect(current_url());
								}
							}
						}
						redirect(current_url());
					}
				}
			}
		}
		else
		{
			redirect('Login', 'refresh');
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
				$result = $this->Administration_model->delete_communication_offer($id,$seller_id);
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Communication Offer Deleted Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Communication Offer!!");
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
					$this->session->set_flashdata("error_code","Communication Offer Activated / Deactivated Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Activating / Deactivating Communication Offer!!");
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
		$data['communication_offers_array'] = $this->Administration_model->get_communication_offers($this->input->post("Seller_id"),$this->input->post("Company_id"));
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
		$this->output->set_output($result->description);
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
		$data['communication_offers'] = $this->Administration_model->get_multiple_offers($this->input->post("Seller_id"),$this->input->post("Company_id"));
		
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
		$this->output->set_output(json_encode(array('image_name'=> $filepath, 'message' => $message)));
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
			
			if($_GET == NULL)
			{
				redirect("Administration/auction");
			}
			else
			{	
				$Auction_id =  $_GET['Auction_id'];
				$result = $this->Administration_model->delete_auction($Auction_id);
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Deleted Successfuly..!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Auction..!!");
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
				
				$result = $this->Administration_model->update_auction($filepath);				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Updated Successfuly..!!");
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
			
			if($result1 == true && $result2 == true && $result3 == true)
			{
				$this->session->set_flashdata("error_code","Auction Winner Approved Successfuly..!!");
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
			
			$update_data = array(
								'Current_balance' => $Curr_balance ,
								'Blocked_points' => $Blocked_points 
							);
			$result1 = $this->Administration_model->update_cust_details($this->input->get("Enrollment_id"),$update_data);
			
			$result2 = $this->Administration_model->delete_auction_winner($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			if($result1 == true && $result2 == true)
			{
				$this->session->set_flashdata("error_code","Auction Winner Deleted Successfuly..!!");
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
				$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				$flag=0;
				foreach($get_sellers as $Sellers_id)
				{
					$Seller_id2=$Sellers_id->Enrollement_id;
					$check = $this->Administration_model->check_referral_rule($Company_id,$Seller_id2,$referral_rule_for);
					if($check==0)
					{
						$data['Seller_id'] =$Sellers_id->Enrollement_id;
						$result = $this->Administration_model->insert_referral_rule($Company_id,$data);
						$flag=1;
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
				$check = $this->Administration_model->check_referral_rule($Company_id,$lv_seller_id,$referral_rule_for);
				if($check==0)
				{
					$result = $this->Administration_model->insert_referral_rule($Company_id,$data);
					
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
		}
		elseif($old_seller_id==$new_seller_id && $new_referral_rule_for!=$old_referral_rule_for )
		{
			$check = $this->Administration_model->check_referral_rule($Company_id,$new_seller_id,$new_referral_rule_for);
			$msg="Referral Rule already exist for  Merchant(s)".$Referral_rule_for."  !!!";
		}
		elseif($old_seller_id!=$new_seller_id && $new_referral_rule_for==$old_referral_rule_for )
		{
			$check = $this->Administration_model->check_referral_rule($Company_id,$new_seller_id,$new_referral_rule_for);
			$msg="Referral Rule already exist !!!";
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
		
		
		if($check==0)
		{
			$result = $this->Administration_model->update_referral_rule($Company_id,$refid,$data);
			$this->session->set_flashdata("error_code","Referral Rule Updated Successfully!!");
			$flag=1;
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
			$refid =  $_GET['refid'];
			$result = $this->Administration_model->delete_referral_rule($refid);
			if($result==true)
			{
				$this->session->set_flashdata("error_code","Referral Rule Deleted Successfully!!");
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
		$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
		$get_sellers = $this->Igain_model->get_company_sellers($session_data['Company_id']);
			
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
	/*************************************************AMIT END*****************************************/	
}
?>
