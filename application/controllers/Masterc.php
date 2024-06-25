<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Masterc extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');	
		$this->load->model('master/Currency_model');
		$this->load->model('master/Merchant_model');
		$this->load->model('Igain_model');
		$this->load->model('master/Usertype_model');
		$this->load->model('master/Paymenttype_model');
	}
	
/************************************************************Akshay*****************************************************/

	/*************************************Currency Starts*******************************/
	function currency()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/currency";
			$total_row = $this->Currency_model->currency_count();		
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
				$data["results"] = $this->Currency_model->currency_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('master/currency', $data);
			}
			else
			{			
				$result = $this->Currency_model->insert_currency();
				if($result == true)
				{
					$this->session->set_flashdata("success_code","New Currency Inserted Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Currency";
						$where="Create / Edit Currency";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Currency_name'); ;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Currency. Please Provide valid data!!");
				}
				
				$data["results"] = $this->Currency_model->currency_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function edit_currency()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];	
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/currency";
			$total_row = $this->Currency_model->currency_count();		
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
			
			if($_GET['Country_id'])
			{
				$Country_id =  $_GET['Country_id'];			
				$data['results'] = $this->Currency_model->edit_currency($Country_id);
				$data["results2"] = $this->Currency_model->currency_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('master/edit_currency', $data);
			}
			else
			{		
				redirect('Masterc/currency', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_currency()
	{
		if($this->session->userdata('logged_in'))
		{		
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			
			if($_POST == NULL)
			{
				redirect('Masterc/currency', 'refresh');
			}
			else
			{
				$Country_id =  $this->input->post('Country_id');
				$post_data = array(					
					'Country_name' => $this->input->post('Currency_nation'),
					'Currency_name' => $this->input->post('Currency_name'),        
					'Symbol_of_currency' => $this->input->post('currency_symbol'),       
					'Dial_code' => $this->input->post('dial_code')
				);
				$result = $this->Currency_model->update_currency($post_data,$Country_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Currency Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Currency";
						$where="Create / Edit Currency";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Currency_name'); 
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Currency!!");
				}
				redirect('Masterc/currency');
			}
		}
	}
	/*************************************Currency Starts*******************************/
	
	/*************************************Merchant Category Starts*******************************/
	function merchant_category()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/merchant_category";
			$total_row = $this->Merchant_model->merchant_item_count($Company_id);		
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
				$data["results"] = $this->Merchant_model->merchant_item_list($config["per_page"], $page,$session_data['Company_id']);				
				$data["pagination"] = $this->pagination->create_links();
				
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["company_sellers"] = $this->Igain_model->get_company_sellers($data['Company_id']);
				$this->load->view('master/merchant_category', $data);				
			}
			else
			{			
				/*********************************AMIT*******************************/
				$Seller_id=$this->input->post('sellerId');
				if($Seller_id==0)//Alll
				{
					$data["company_sellers"] = $this->Igain_model->get_company_sellers($data['Company_id']);
					foreach($data["company_sellers"] as $Sellers)
					{
						//echo "<br>Enrollement_id ".$Sellers->Enrollement_id;
						$result = $this->Merchant_model->insert_merchant_category($Sellers->Enrollement_id);
					}	
					/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Merchant Category";
						$where="Create Merchant Category";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval =$this->input->post('item_type_name').' ( '.$this->input->post('item_type_no').' )';
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$result = $this->Merchant_model->insert_merchant_category($Seller_id);
				/***********Insert igain Log table************************/	
					$get_merchant_detail = $this->Igain_model->get_enrollment_details($Seller_id);
					$merchant_Enrollement_id = $get_merchant_detail->Enrollement_id;
					$merchant_First_name = $get_merchant_detail->First_name;
					$merchant_Last_name = $get_merchant_detail->Last_name;
					$merchant_User_email_id = $get_merchant_detail->User_email_id;
					$sellerId = $this->input->post('sellerId');
					$offer = $this->input->post('offer');	
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create Merchant Category";
					$where="Create Merchant Category";
					$toname="";
					$To_enrollid =0;
					$firstName = $merchant_First_name;
					$lastName = $merchant_Last_name;
					$Seller_name = $session_data['Full_name'];
					$opval =$this->input->post('item_type_name').' ( '.$this->input->post('item_type_no').' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$merchant_Enrollement_id);
				/***********Insert igain Log table************************/
				}				
				/*********************************AMIT*******************************/
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Merchant Category Inserted Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Merchant Category. Please Provide valid data!!");
				}
				redirect(current_url());
			}	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function edit_merchant_category()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$Company_id = $session_data['Company_id'];	
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/merchant_category";
			$total_row = $this->Merchant_model->merchant_item_count($Company_id);		
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
			
			if($_GET['Item_category_id'])
			{
				$Item_category_id =  $_GET['Item_category_id'];
				$data["results2"] = $this->Merchant_model->merchant_item_list($config["per_page"], $page,$session_data['Company_id']);				
				$data["pagination"] = $this->pagination->create_links();
				$my_array = $this->Merchant_model->edit_merchant_category($Item_category_id);
				$data["results"]= $this->Merchant_model->edit_merchant_category($Item_category_id);
				
				$data["Company_details"] = $this->Igain_model->get_company_details($my_array->Company_id);
				$data["Seller_details"] = $this->Igain_model->get_enrollment_details($my_array->Seller);				
				$this->load->view('master/edit_merchant_category', $data);
			}
			else
			{		
				redirect('Masterc/merchant_category', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_merchant_category()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');	
			if($_POST == NULL)
			{
				redirect('Masterc/merchant_category', 'refresh');
			}
			else
			{
				$Item_category_id =  $this->input->post('Item_category_id');
				$post_data = array(					
					'Company_id' => $this->input->post('companyId'),
					'Seller' => $this->input->post('sellerId'),        
					'Item_category_name' => $this->input->post('item_type_name'),
					'Item_typedesc' => $this->input->post('item_desc')
				);
				$result = $this->Merchant_model->update_merchant_category($post_data,$Item_category_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Merchant Category Updated Successfuly!!");
					
					/***********Insert igain Log table************************/	
					$get_merchant_detail = $this->Igain_model->get_enrollment_details($this->input->post('sellerId'));
					$merchant_Enrollement_id = $get_merchant_detail->Enrollement_id;
					$merchant_First_name = $get_merchant_detail->First_name;
					$merchant_Last_name = $get_merchant_detail->Last_name;
					$merchant_User_email_id = $get_merchant_detail->User_email_id;
					$sellerId = $this->input->post('sellerId');
					$offer = $this->input->post('offer');	
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Merchant Category";
					$where="Create Merchant Category";
					$toname="";
					$To_enrollid =0;
					$firstName = $merchant_First_name;
					$lastName = $merchant_Last_name;
					$Seller_name = $session_data['Full_name'];
					// $opval = $Item_category_id;
					$opval = $this->input->post('item_type_name').' ( '.$this->input->post('item_type_no').' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$merchant_Enrollement_id);
				/***********Insert igain Log table************************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Merchant Category!!");
				}
				redirect('Masterc/merchant_category');
			}
		}
	}
	
	public function check_item_code()
	{
		$result11 = $this->Merchant_model->check_item_code($this->input->post("Item_category_code"),$this->input->post("Company_id"),$this->input->post("Seller_id"));
		// var_dump($result11);
		if($result11 > 0)
		{
			$res=$result11['1'];
			$this->output->set_output("Category Code Already Exist");
		}
		else    
		{
			$res=$result11['0'];
			$this->output->set_output("Available");
		}
	}
	/*************************************Merchant Category Starts*******************************/
	
/************************************************************Akshay********************************************/



/*************************************************Ravi Code Start******************************************/
	public function usertype()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/			
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/usertype";
			$total_row = $this->Usertype_model->usertype_count();		
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
				 $data["results"] = $this->Usertype_model->usertype_list($config["per_page"], $page);
				 // var_dump($data);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('master/usertype',$data);
			}
			else
			{			
				$result = $this->Usertype_model->insert_usertype();
				if($result == true)
				{
					$this->session->set_flashdata("success_code","New User Type Inserted Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create New User Type";
						$where="Create / Edit User Type";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('User_Type');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting User Type. Please Provide valid data!!");
				}
				
				$data["results"] = $this->Usertype_model->usertype_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	
	}
	public function edit_usertype()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/usertype";
			$total_row = $this->Usertype_model->usertype_count();		
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
			
			if($_GET['usertype'])
			{
				$usertype =  $_GET['usertype'];
				$data["results2"] = $this->Usertype_model->usertype_list($config["per_page"], $page);				
				$data["pagination"] = $this->pagination->create_links();
				$my_array = $this->Usertype_model->edit_usertype($usertype);
				$data["results"]= $this->Usertype_model->edit_usertype($usertype);	
				// var_dump($data["results"]);
				$this->load->view('master/edit_usertype', $data);
			}
			else
			{		
				redirect('Masterc/usertype', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function update_usertype()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');		
			if($_POST == NULL)
			{
				redirect('Masterc/usertype', 'refresh');
			}
			else
			{
				$User_id =  $this->input->post('User_id');
				
				$post_data = array(					
					'User_type' => $this->input->post('User_type'),
					'User_description' => $this->input->post('User_description')        
					
				);
				
				$result = $this->Usertype_model->update_usertype($post_data,$User_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","User Type Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$User_type =  $this->input->post('User_type');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update User Type";
						$where="Create / Edit User Type";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $User_type;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating User Type!!");
				}
				redirect('Masterc/usertype', 'refresh');
			}
		}
	}
	public function check_usertype()
	{
		$result = $this->Usertype_model->check_usertype($this->input->post("User_Type"));
		if($result > 0)
		{
			$this->output->set_output(1);
		}
		else    
		{
			$this->output->set_output(0);
		}
	}
	public function paymenttype()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/			
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/usertype";
			$total_row = $this->Paymenttype_model->paymenttype_count();		
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
				 $data["results"] = $this->Paymenttype_model->paymenttype_list($config["per_page"], $page);
				 // var_dump($data);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('master/paymenttype',$data);
			}
			else
			{			
				$result = $this->Paymenttype_model->insert_paymenttype();
				if($result == true)
				{
					$this->session->set_flashdata("success_code","New Payment Type Inserted Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Payment Type";
						$where="Create / Edit Payment Type";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval =  $this->input->post('Payment_type');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Payment Type. Please Provide valid data!!");
				}
				
				$data["results"] = $this->Paymenttype_model->paymenttype_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	
	}
	public function edit_paymenttype()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/usertype";
			$total_row = $this->Paymenttype_model->paymenttype_count();		
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
			
			if($_GET['Payment_type_id'])
			{
				$Payment_type_id =  $_GET['Payment_type_id'];
				$data["results2"] = $this->Paymenttype_model->paymenttype_list($config["per_page"], $page);				
				$data["pagination"] = $this->pagination->create_links();
				$my_array = $this->Paymenttype_model->edit_paymenttype($Payment_type_id);
				$data["results"]= $this->Paymenttype_model->edit_paymenttype($Payment_type_id);	
				// var_dump($data["results"]);
				$this->load->view('master/edit_paymenttype', $data);
			}
			else
			{		
				redirect('Masterc/paymenttype', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function update_paymenttype()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			if($_POST == NULL)
			{
				redirect('Masterc/paymenttype', 'refresh');
			}
			else
			{
				$Payment_type_id =  $this->input->post('Payment_type_id');
				$post_data = array(					
					'Payment_type' => $this->input->post('Payment_type'),
					'Payment_description' => $this->input->post('Payment_description')        
					
				);
				$result = $this->Paymenttype_model->update_paymenttype($post_data,$Payment_type_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Payment Type Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Payment Type";
						$where="Create / Edit Payment Type";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Payment_type');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Payment Type!!");
				}
				redirect('Masterc/paymenttype', 'refresh');
			}
		}
	}
	public function check_paymenttype()
	{
		$result = $this->Paymenttype_model->check_paymenttype($this->input->post("Payment_type"));
		if($result > 0)
		{
			$this->output->set_output(1);
		}
		else    
		{
			$this->output->set_output(0);
		}
	}
/***********************************************Ravi Code End**********************************************/
/***********************************************AMIT Code 08-09-2017***********************************/
	public function CodeDecodeType()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			/*-----------------------Pagination---------------------*/			
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/CodeDecodeType";
			$total_row = $this->Merchant_model->Code_decode_type_count();		
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
				 $data["results"] = $this->Merchant_model->Code_decode_type_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('master/Create_codedecode_type',$data);
			}
			else
			{			
				$result = $this->Merchant_model->insert_Code_decode_type($this->input->post('Code_decode_type'));
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Code Decode Type Created Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Code Decode Type";
						$where="Create Code Decode Type";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Code_decode_type');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Code_decode_type. Please Provide valid data!!");
				}
				
				$data["results"] = $this->Merchant_model->Code_decode_type_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	
	}
	public function Edit_CodeDecodeType()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/CodeDecodeType";
			$total_row = $this->Merchant_model->Code_decode_count($session_data['Company_id']);		
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
			
			if($_GET['Code_decode_type_id'])
			{
				 $data["results"] = $this->Merchant_model->Code_decode_type_list($config["per_page"], $page);
				$Code_decode_type_id =  $_GET['Code_decode_type_id'];
				$data["results2"]= $this->Merchant_model->Edit_codedecode_type($Code_decode_type_id);	
				$this->load->view('master/Edit_codedecode_type', $data);
			}
			else
			{		
				redirect('Masterc/CodeDecodeType', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Update_CodeDecodeType()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');		
			
				$Code_decode_type_id =  $this->input->post('Code_decode_type_id');
				$post_data = array(					
					'Code_decode_type' => $this->input->post('Code_decode_type'),
				);
				$result = $this->Merchant_model->Update_CodeDecodeType($post_data,$Code_decode_type_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Code Decode Type Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Code_decode_type =  $this->input->post('Code_decode_type');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Code Decode Type";
						$where="Edit Code Decode Type";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Code_decode_type;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Code Decode Type!!");
				}
				redirect('Masterc/CodeDecodeType');
			
		}
	}

	public function CodeDecode()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			/*-----------------------Pagination---------------------*/			
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/CodeDecode";
			$total_row = $this->Merchant_model->Code_decode_count($session_data['Company_id']);		
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
				 $data["results"] = $this->Merchant_model->Code_decode_list($config["per_page"], $page,$session_data['Company_id']);
				 $data["All_codedecode_types"] = $this->Merchant_model->Code_decode_type_list('','');
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('master/Create_codedecode',$data);
			}
			else
			{	
				$Code_decode=$this->input->post('Code_decode');
				$Company_id=$this->input->post('Company_id');
				$Code_decode_type_id=$this->input->post('Code_decode_type_id');
				$result = $this->Merchant_model->insert_Code_decode($Company_id,$Code_decode,$Code_decode_type_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Code Decode Created Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Code Decode";
						$where="Create Code Decode";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Code_decode');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Code_decode. Please Provide valid data!!");
				}
				
				$data["results"] = $this->Merchant_model->Code_decode_list($config["per_page"], $page,$session_data['Company_id']);
				$data["pagination"] = $this->pagination->create_links();
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	
	}
	public function Edit_CodeDecode()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Masterc/CodeDecode";
			$total_row = $this->Merchant_model->Code_decode_count($session_data['Company_id']);		
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
			
			if($_GET['Code_decode_id'])
			{
				$data["All_codedecode_types"] = $this->Merchant_model->Code_decode_type_list('','');
				 $data["results"] = $this->Merchant_model->Code_decode_list($config["per_page"], $page,$session_data['Company_id']);
				$Code_decode_id =  $_GET['Code_decode_id'];
				
				$data["results2"]= $this->Merchant_model->Edit_codedecode($Code_decode_id);	
				$this->load->view('master/Edit_codedecode', $data);
			}
			else
			{		
				redirect('Masterc/CodeDecode', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Update_CodeDecode()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');		
			
				$Company_id =  $this->input->post('Company_id');
				$Code_decode_id =  $this->input->post('Code_decode_id');
				$Code_decode_type_id =  $this->input->post('Code_decode_type_id');
				$Code_decode =  $this->input->post('Code_decode');
				$post_data = array(					
					'Company_id' => $Company_id,
					'Code_decode_type_id' => $Code_decode_type_id,
					'Code_decode' => $Code_decode,
				);
				$result = $this->Merchant_model->Update_CodeDecode($post_data,$Code_decode_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Code Decode Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Code_decode_type =  $Code_decode;
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Code Decode";
						$where="Edit Code Decode";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Code_decode_type;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Code Decode!!");
				}
				redirect('Masterc/CodeDecode');
			
		}
	}

	
	/***********************************************AMIT Code End*************************************/
	//*************************** sandeep *************************************************
		//******************** 23-08-2019 ********************************
		
	public function check_codedecode_type()
	{
		$decode_type = $this->input->post("Code_decode_type");
		$Decode_flag = $this->input->post("Decode_flag");
		$CompanyId = $this->input->post("CompanyId");
		
		$res_decodeType = $this->Igain_model->check_decode_type($decode_type,$Decode_flag,$CompanyId);

		if($res_decodeType > 0)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		}	

	}	
		//******************** 23-08-2019 ********************************
	//*************************** sandeep *************************************************
	
}
?>

