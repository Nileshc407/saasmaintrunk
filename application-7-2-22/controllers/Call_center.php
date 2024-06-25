<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Call_center extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->model('CallCenter/CallCenter_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->library('Send_notification');
		$this->load->library("excel");
		$this->load->library('m_pdf');		
		$this->load->model('master/currency_model');
	}
	/*---------------------------------Nilesh Work Start----------------------------------------*/
	public function Get_user_name()
	{
		$data['Get_User_Names'] = $this->CallCenter_model->Get_user_name($this->input->post("User_id"),$this->input->post("Company_id"));
		$theHTMLResponse = $this->load->view('CallCenter/Get_User_names', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_User_Names1'=> $theHTMLResponse)));
	}
	function Call_center_query_type()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_query_type";
			$total_row = $this->CallCenter_model->Call_center_query_type($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links(); 
			$data["UserType"] = $this->CallCenter_model->get_user_type($data['Company_id']);
			$data["CallCenterQueryType"] = $this->CallCenter_model->Call_center_query_type_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();			
			
			if($_POST == NULL)
			{
				$this->load->view('CallCenter/Call_center_query_type', $data); 
			}
			else
			{		
				$today=date('Y-m-d H:i:s');
				$UserName=$this->input->post('UserName');
				$Post_data=array
						   (
							'Company_id'=>$data['Company_id'],
							'Query_type_name'=>$this->input->post('Query_type_name'),
							'User_type_id'=>$this->input->post('usertype'),
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
				$result = $this->CallCenter_model->insert_callcenter_querytype_master($Post_data);
				
				foreach($UserName as $UserName2)
				{
				
					$Post_data1=array 
					   (
						'Query_type_id'=>$result,
						'Company_id'=>$data['Company_id'],
						'Enrollment_id'=>$UserName2,							
						'Create_User_id'=>$data['enroll'],
						'Creation_date'=>$today
					   );
				$result1 = $this->CallCenter_model->insert_callcenter_querytype_child($Post_data1);
				if($result == true && $result1== true)				
				{
					
					/*******************Insert igain Log Table*********************/
					$get_enrollment =$this->Igain_model->get_enrollment_details($UserName2);
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create Call Center Query Type";
					$where="Create Call Center Query Type";
					$toname="";
					$To_enrollid =$UserName2;
					$firstName = $get_enrollment->First_name;
					$lastName = $get_enrollment->Last_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Query_type_name');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/				
				}
			}
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","Call Center Query Type Inserted Successfully!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Creating Call Center Query Type Master. Please Provide valid data!!");
				}
				redirect("Call_center/Call_center_query_type");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Check_Call_center_query_type()
	{
		$result = $this->CallCenter_model->Check_Call_center_query_type($this->input->post("Query_type_name"),$this->input->post("Company_id"));
		// var_dump($result);
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	function Edit_Call_center_query_type()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();  
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_query_type";
			$total_row = $this->CallCenter_model->Call_center_query_type($data['Company_id']);		
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
			    
			$data["UserType"] = $this->CallCenter_model->get_user_type($data['Company_id']);
			$data["CallCenterQueryType"] = $this->CallCenter_model->Call_center_query_type_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			/******************Change******************************/
			$data["company_cc_user"] = $this->CallCenter_model->company_cc_user_list($data['Company_id']);
			/******************Change******************************/
			
			if($_GET['Query_type_id'])
			{	
				$data["query_type_details"] = $this->CallCenter_model->Get_Call_center_query_type($data['Company_id'],$_GET['Query_type_id']);
				
				/******************Change******************************/
				$data["query_type_details_child"] = $this->CallCenter_model->Get_Call_center_query_type_child($data['Company_id'],$_GET['Query_type_id']);			
				/******************Change******************************/

				// $data['Get_User_Names'] = $this->CallCenter_model->Get_user_name(6,$this->input->post("Company_id"));
			}
			$this->load->view('CallCenter/Edit_Call_center_query_type', $data);
		} 
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Update_Call_center_query_type()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_query_type";
			$total_row = $this->CallCenter_model->Call_center_query_type($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links();
			$data["CallCenterQueryType"] = $this->CallCenter_model->Call_center_query_type_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
					
			if($_POST == NULL)
			{
				$this->load->view('Call_center/Call_center_query_type', $data);
				 
			}
			else
			{	
				// var_dump($_POST);
				// die;
				$today=date('Y-m-d H:i:s');
					
				$Post_data=array 
						   (							
							
							'Query_type_name'=>$this->input->post('Query_type_name'),
							'User_type_id'=>$this->input->post('usertype'),
							// 'Enrollment_id'=>$this->input->post('UserName'),
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today,
							'Update_User_id' =>$data['enroll'],
							'Update_date'=>$today
						   );
						   
				$result = $this->CallCenter_model->Update_Call_center_query_type($Post_data,$this->input->post('QueryType_id'),$data['Company_id']);	
				
				$UserName_child = $this->input->post('UserName'); 
				
				$result2 = $this->CallCenter_model->Delete_Call_center_query_type_child($this->input->post('QueryType_id'),$data['Company_id']);	
						
				foreach($UserName_child as $Child_Enrollment_id)
				{
					$Post_data1=array 
					   (
						'Query_type_id'=>$this->input->post('QueryType_id'),
						'Company_id'=>$data['Company_id'],
						'Enrollment_id'=>$Child_Enrollment_id,
						'Create_User_id'=>$data['enroll'],							
						'Creation_date'=>$today	
					   );
					$result1 = $this->CallCenter_model->Call_center_query_type_child($Post_data1);
				}
			
				if($result == true)				
				{
					/*******************Insert igain Log Table*********************/
					$UserName_child1=$this->input->post('UserName');
					
					foreach($UserName_child1 as $Child_Enrollment_id1)
					{
						$get_enrollment = $this->Igain_model->get_enrollment_details($Child_Enrollment_id1); 
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Call Center Query Type";
						$where="Create Call Center Query Type";
						// $To_enrollid =$this->input->post('UserName');
						$To_enrollid =$Child_Enrollment_id1;
						$firstName = $get_enrollment->First_name;
						$lastName = $get_enrollment->Last_name;
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Query_type_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					}
					$this->session->set_flashdata("success_code","Call Center Query Type Updated Successfuly!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Call Center Query Type. Please Provide valid data!!");
				}
				redirect("Call_center/Call_center_query_type");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Check_Call_center_Sub_query()
	{
		$result = $this->CallCenter_model->Check_Call_center_Sub_query($this->input->post("Sub_Query"),$this->input->post("Company_id"));
		// var_dump($result);
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	function Call_center_sub_queries()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_sub_queries";
			$total_row = $this->CallCenter_model->Call_center_sub_queries_count($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links(); 
			$data["Querytype"] = $this->CallCenter_model->Call_center_queryType($data['Company_id']);
			$data["CallCenterSubQueryType"] = $this->CallCenter_model->Call_center_sub_query_type_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();			
			
			if($_POST == NULL)
			{
				$this->load->view('CallCenter/Call_center_query_setup_master', $data); 
			}
			else
			{		
				$today=date('Y-m-d H:i:s');
				$from_date=date('Y-m-d',strtotime($this->input->post('Valid_from')));
				$to_date=date('Y-m-d',strtotime($this->input->post('Valid_till')));
					
				$Post_data=array
						   (
							'Company_id'=>$data['Company_id'],
							'Query_type_id'=>$this->input->post('Querytype'),
							'Sub_query'=>$this->input->post('Sub_Query'),
							'Query_remarks'=>$this->input->post('subqueryreemark'),
							'Create_User_id'=>$session_data['enroll'],
							'Creation_date'=>$today
						   );
				$result = $this->CallCenter_model->insert_callcenter_querySetup_master($Post_data);	
				if($result == true)				
				{
					
				/*******************Insert igain Log Table*********************/
					$get_enrollment =$this->Igain_model->get_enrollment_details($this->input->post('UserName'));
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create call Center Query Setup";
					$where="Create Call Center Sub Queries ";
					$toname="";
					$To_enrollid ='';
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Sub_Query');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
					
					$this->session->set_flashdata("success_code","Call Center Query Setup Inserted SuccessFully!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Creating Call Center Query Setup Master. Please Provide valid data!!");
				}
				redirect("Call_center/Call_center_sub_queries");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Edit_Call_center_sub_query()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();  
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_sub_queries";
			$total_row = $this->CallCenter_model->Call_center_sub_queries_count($data['Company_id']);		
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
			    
			$data["Querytype"] = $this->CallCenter_model->Call_center_queryType($data['Company_id']);
			$data["CallCenterSubQueryType"] = $this->CallCenter_model->Call_center_sub_query_type_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_GET['Query_id'])
			{
				$data["query_type_details"] = $this->CallCenter_model->Get_sub_query_name1($_GET['Query_id'],$data['Company_id']);	
			}
			$this->load->view('CallCenter/Edit_Call_center_query_setup_master', $data);
		} 
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Update_Call_center_sub_query()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_sub_queries";
			$total_row = $this->CallCenter_model->Call_center_sub_queries_count($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links();
			$data["CallCenterSubQueryType"] = $this->CallCenter_model->Call_center_sub_query_type_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
				
			if($_POST == NULL)
			{
				$this->load->view('Call_center/Call_center_query_setup_master', $data);				 
			}
			else
			{	
				$today=date('Y-m-d H:i:s');
					
				$Post_data=array 
						   (							
							
							'Sub_query'=>$this->input->post('Sub_Query'),
							'Query_remarks'=>$this->input->post('subqueryreemark'),
							'Update_User_id'=>$session_data['enroll'],
							'Update_date'=>$today
						   );
				$result = $this->CallCenter_model->Update_Call_center_sub_query($Post_data,$this->input->post('SubQueryid'),$data['Company_id']);	
				if($result == true)				
				{
					/*******************Insert igain Log Table*********************/	
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Call Center Sub Queries";
					$where="Create Call Center Sub Queries";
					$To_enrollid ='';
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Sub_Query');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					
					$this->session->set_flashdata("success_code","Call Center Query Setup Updated SuccessFully!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Call Center Query Setup. Please Provide valid data!!");
				}
				redirect("Call_center/Call_center_sub_queries");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Resolution_priority_levels()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Resolution_priority_levels";
			$total_row = $this->CallCenter_model->callcenter_resolutionpriority_level($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links(); 
			$data["UserType"] = $this->CallCenter_model->get_user_type($data['Company_id']);
			$data["CallCenterresolutionpriority"] = $this->CallCenter_model->callcenter_resolutionpriority_level_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();			
			
			if($_POST == NULL)
			{
				$this->load->view('CallCenter/callcenter_resolutionpriority_level_master', $data); 
			}
			else
			{		
				$today=date('Y-m-d H:i:s');
				$UserName=$this->input->post('UserName');
				foreach($UserName as $UserName2)
				{	
				$Post_data=array
						   (
							'Company_id'=>$data['Company_id'],
							'Resolution_priority_levels'=>$this->input->post('PriorityLevel'),
							'Level_name'=>$this->input->post('Level_name'),
							'No_of_days_expected_resolve'=>$this->input->post('days_expected_resolve'),
							'User_type_id'=>$this->input->post('usertype'),
							'Enrollment_id'=>$UserName2,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
				$result = $this->CallCenter_model->Insert_Resolution_priority_levels($Post_data);
					if($result == true)				
					{
						/*******************Insert igain Log Table*********************/
						$get_enrollment =$this->Igain_model->get_enrollment_details($UserName2);
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Define Call Center Resolution Priority Levels";
						$where="Define Call Center Resolution Priority Levels";
						$To_enrollid =$UserName2;
						$firstName = $get_enrollment->First_name;
						$lastName = $get_enrollment->Last_name;
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Level_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
					}
				}
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","Call Center Resolution priority levels. Added Successfuly!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Creating Call Center Resolution priority levels. Please Provide valid data!!");
				}
				redirect("Call_center/Resolution_priority_levels");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Edit_Resolution_priority_levels()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();  
			$config["base_url"] = base_url() . "/index.php/Call_center/Resolution_priority_levels";
			$total_row = $this->CallCenter_model->callcenter_resolutionpriority_level($data['Company_id']);		
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
			    
			$data["UserType"] = $this->CallCenter_model->get_user_type($data['Company_id']);
			$data["CallCenterresolutionpriority"] = $this->CallCenter_model->callcenter_resolutionpriority_level_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_GET['Resolution_id'])
			{
				$data["Resolution_levels_details"] = $this->CallCenter_model->Get_Resolution_priority_id($data['Company_id'],$_GET['Resolution_id']);
			}
			$this->load->view('CallCenter/Edit_callcenter_resolutionpriority_level_master', $data);
		} 
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Update_Resolution_priority_levels()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Resolution_priority_levels";
			$total_row = $this->CallCenter_model->callcenter_resolutionpriority_level($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links();
			$data["CallCenterresolutionpriority"] = $this->CallCenter_model->callcenter_resolutionpriority_level_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			
			if($_POST == NULL)
			{
				$this->load->view('Call_center/callcenter_resolutionpriority_level_master', $data);	 
			}
			else
			{	
				$today=date('Y-m-d H:i:s');
					
				$Post_data=array 
					   (							
						'Resolution_priority_levels'=>$this->input->post('PriorityLevel'),
						'Level_name'=>$this->input->post('Level_name'), 
						'No_of_days_expected_resolve'=>$this->input->post('days_expected_resolve'), 
						'User_type_id'=>$this->input->post('usertype'),
						'Enrollment_id'=>$this->input->post('UserName'),
						'Update_User_id' =>$data['enroll'],
						'Update_date'=>$today
					   );
					   
				$result = $this->CallCenter_model->Update_Resolution_priority_levels($Post_data,$this->input->post('Resolution_id'),$session_data['Company_id']);	
				if($result == true)				
				{
					/*******************Insert igain Log Table*********************/
					$get_enrollment = $this->Igain_model->get_enrollment_details($this->input->post('UserName')); 
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Call Center Resolution Priority Levels";
					$where="Define Call Center Resolution Priority Levels";
					$To_enrollid =$this->input->post('UserName');
					$firstName = $get_enrollment->First_name;
					$lastName = $get_enrollment->Last_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Level_name');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					
					$this->session->set_flashdata("success_code","Call Center Resolution priority levels. Updated Successfuly!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Call Center Resolution priority levels. Please Provide valid data!!");
				}
				redirect("Call_center/Resolution_priority_levels");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Check_Resolution_priority_levels()
	{
		$result = $this->CallCenter_model->Check_Resolution_priority_levels($this->input->post("PriorityLevel"),$this->input->post("Company_id"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function Check_Resolution_priority_levels_name()
	{
		$result = $this->CallCenter_model->Check_Resolution_priority_levels_name($this->input->post("Level_name"),$this->input->post("Company_id"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	function Call_center_escalation_levels()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_escalation_levels";
			$total_row = $this->CallCenter_model->Call_center_escalation_count($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links(); 
			$data["UserType"] = $this->CallCenter_model->get_user_type($data['Company_id']);
			$data["CallCenterescalationMatrix"] = $this->CallCenter_model->Call_center_escalation_matrix_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();			
			
			if($_POST == NULL)
			{
				$this->load->view('CallCenter/callcenter_escalation_matrix_master', $data); 
			}
			else
			{		
				$today=date('Y-m-d H:i:s');		
				$UserName=$this->input->post('UserName');
				foreach($UserName as $UserName2)
				{
				$Post_data=array
						   (
							'Company_id'=>$data['Company_id'],
							'No_of_unresolved_days'=>$this->input->post('Unresolved_Days'),
							'User_type_id'=>$this->input->post('usertype'),
							'Enrollment_id'=>$UserName2,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
					$result = $this->CallCenter_model->Insert_escalation_matrix_levels($Post_data);	
					if($result == true)	
					{
						/*******************Insert igain Log Table*********************/
						$get_enrollment =$this->Igain_model->get_enrollment_details($UserName2);
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Define Call Center Escalation Levels";
						$where="Define Call Center Escalation Levels";
						$toname="";
						$To_enrollid =$UserName2;
						$firstName = $get_enrollment->First_name;
						$lastName = $get_enrollment->Last_name;
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Unresolved_Days').' -(Unresolved Days)';
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
					}
				}
				if($result == true)				
				{	
					$this->session->set_flashdata("success_code","Call Center Escalation Matrix levels. Inserted Successfuly!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Creating Call Center Escalation Matrix levels. Please Provide valid data!!");
				}
				redirect("Call_center/Call_center_escalation_levels");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Check_No_of_Unresolved_Days()
	{
		$result = $this->CallCenter_model->Check_No_of_Unresolved_Days_levels($this->input->post("Unresolved_Days"),$this->input->post("Company_id"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	function Edit_Call_center_escalation_levels()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();  
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_escalation_levels";
			$total_row = $this->CallCenter_model->Call_center_escalation_count($data['Company_id']);		
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
			    
			$data["UserType"] = $this->CallCenter_model->get_user_type($data['Company_id']);
			$data["CallCenterescalationMatrix"] = $this->CallCenter_model->Call_center_escalation_matrix_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_GET['Escalation_matrix_id'])
			{
				$data["escalation_matrix"] = $this->CallCenter_model->Get_escalation_levels($data['Company_id'],$_GET['Escalation_matrix_id']);
			}
			$this->load->view('CallCenter/Edit_callcenter_escalation_matrix_master', $data);
		} 
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Update_Call_center_escalation_levels()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/Call_center_escalation_levels";
			$total_row = $this->CallCenter_model->Call_center_escalation_count($data['Company_id']);		
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
			
			$data["pagination"] = $this->pagination->create_links();
			$data["CallCenterescalationMatrix"] = $this->CallCenter_model->Call_center_escalation_matrix_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
				
			if($_POST == NULL)
			{
				$this->load->view('Call_center/callcenter_escalation_matrix_master', $data);
			}
			else
			{	
				$today=date('Y-m-d H:i:s');
					
				$Post_data=array 
					   (							
						'No_of_unresolved_days'=>$this->input->post('Unresolved_Days'),
						'User_type_id'=>$this->input->post('usertype'), 
						'Enrollment_id'=>$this->input->post('UserName'),
						'Update_User_id' =>$data['enroll'],
						'Update_date'=>$today
					   );
					   
				$result = $this->CallCenter_model->Update_escalation_matrix_levels($Post_data,$this->input->post('Escalation_matrix_id'),$session_data['Company_id']);	
				if($result == true)				
				{
					/*******************Insert igain Log Table*********************/
					$get_enrollment = $this->Igain_model->get_enrollment_details($this->input->post('UserName')); 
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Call Center Escalation Matrix Level";
					$where="Define Call Center Escalation Levels";
					$To_enrollid =$this->input->post('UserName');
					$firstName = $get_enrollment->First_name;
					$lastName = $get_enrollment->Last_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Unresolved_Days').' -(Unresolved Days)';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					
					$this->session->set_flashdata("success_code","Call Center Escalation Matrix levels. Updated Successfuly!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Call Center Escalation Matrix levels. Please Provide valid data!!");
				}
				redirect("Call_center/Call_center_escalation_levels");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function handle_member_query()
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
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
						    
			$data["Querytype"] = $this->CallCenter_model->Call_center_queryType($data['Company_id']);
			$data["CallCenterSubQueryType"] = $this->CallCenter_model->Call_center_sub_query_type_list($config["per_page"], $page,$data['Company_id']);
			
			$dial_code = $this->CallCenter_model->get_dial_code($data['Country_id']);
			
			if($_POST == NULL)
			{
				$this->load->view('CallCenter/Handle_member_query', $data); 
			}
			else
			{	
				$first_name=$_REQUEST["first_name"]; 
				$last_name=$_REQUEST["last_name"]; 
				
				$dob=date("Y-m-d",strtotime($_REQUEST["dob"]));
				
				
				$card_id=$_REQUEST["card_id"];
				
				if($_REQUEST["mobile_no"] !="")
				{
					$mobile_no = $dial_code.$_REQUEST["mobile_no"];
				}
				$email_id=$_REQUEST["email_id"];
				
				
				if(isset($_REQUEST["page_limit"]))
				{
					$limit=10;
					$start=$_REQUEST["page_limit"]-10;
					// $start=0;
					if($_REQUEST["page_limit"]==0)//All
					{
						$limit="";
						$start="";
					}
				}
				else
				{
					$start=0;
					$limit=10;
				}
				$data["Member_info"] = $this->CallCenter_model->Handle_member_query($data['Company_id'],$first_name,$last_name,$dob,$card_id,$mobile_no,$email_id,$start,$limit);
				
				$this->load->view('CallCenter/Handle_member_query', $data);				
			}
		} 
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function edit_handle_member()
	{	
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			if($_GET['Enrollement_id'])
			{								
				$this->session->set_userdata('Call_Enrollid1', $_GET['Enrollement_id']);				
				$Call_Enrollid = $this->session->userdata('Call_Enrollid1');	
			
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
						
				$data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
				$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
				$FetchedCountrys = $this->Igain_model->FetchCountry();	
				$data['Country_array'] = $FetchedCountrys;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				if($Enrollment_details->User_id == 1)
				{
					$Hobby = array();
					$member_hobbies = $this->Enroll_model->Fetch_member_hobbies($Company_id,$Call_Enrollid);
					if($member_hobbies != NULL)
					{
						foreach($member_hobbies as $hobbies)
						{
							$Hobby[] = $hobbies->Hobbie_id;
						}
						$data['member_hobbies'] = $Hobby;
					}
					else
					{
						$data['member_hobbies'] = $Hobby;
					}
				}			
				// $this->load->view('CallCenter/Handle_member_home', $data);
				redirect("Call_center/edit_handle_member_home/");				
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function edit_handle_member_home()
	{	
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
						
			$Call_Enrollid = $this->session->userdata('Call_Enrollid1');				
						
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$Coalition_flag=$data["Company_details"]->Coalition;
			$Country_details = $this->CallCenter_model->get_Symbol_of_currency($data['Company_details']->Country);
			$data['Currency_Symbol'] = $Country_details->Symbol_of_currency;
			
			if($Call_Enrollid != NULL)
			{ 
				 
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
							
				$Enrollement_id =  $Call_Enrollid;			
				$data['Enrollement_id'] =  $Call_Enrollid;			
				// $data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data['results'] = $this->CallCenter_model->get_enrollment_details($Call_Enrollid);
				
				$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
				$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
				
				$data['Country_array']= $this->Igain_model->FetchCountry();
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				
				 $data["total_gain_points"] = $this->CallCenter_model->get_cust_total_gain_points($Company_id, $Call_Enrollid,$data['results']->Card_id,$Coalition_flag);
				 $data["Total_transfer"] = $this->CallCenter_model->get_cust_total_transfer($Company_id,$Call_Enrollid,$data['results']->Card_id);
				$data['PointsStatistics'] = $this->CallCenter_model->Get_Member_PointsStatistics($Call_Enrollid,$Company_id);
				$data["MerchantGainedPoints"] = $this->CallCenter_model->Fetch_seller_gained_points($Company_id,$Call_Enrollid);	
			
				if($Enrollment_details->User_id == 1)
				{
					$Hobby = array();
					$member_hobbies = $this->Enroll_model->Fetch_member_hobbies($Company_id,$Call_Enrollid);
					if($member_hobbies != NULL)
					{
						foreach($member_hobbies as $hobbies)
						{
							$Hobby[] = $hobbies->Hobbie_id;
						}
						$data['member_hobbies'] = $Hobby;
					}
					else
					{
						$data['member_hobbies'] = $Hobby;
					}
				}			
				$this->load->view('CallCenter/Handle_member_home', $data);	
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function edit_handle_member_home_update()
	{   	 
		if($this->session->userdata('logged_in'))
		{		
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			
			$Call_Enrollid = $this->session->userdata('Call_Enrollid1');	
			 
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id)
			;
						
			$data['Enrollement_id'] =  $Call_Enrollid;	
				
			$data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			
			if($_POST != "")
			{					
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '1500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
				
				/* if (!$this->upload->do_upload("file"))
				{			
					$filepath = $this->input->post("Enrollment_image");
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "uploads/".$data['upload_data']['file_name'];
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
					$configThumb['source_image'] = './uploads/'.$upload77;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='uploads/'.$data77['file_name'];					
				}
				else
				{				
					$filepath = $this->input->post("Enrollment_image");					
				}
								
				$post_data = array(					
					'First_name' => $this->input->post('firstName'),
					'Middle_name' => $this->input->post('middleName'),        
					'Last_name' => $this->input->post('lastName'),       
					'Current_address' => App_string_encrypt($this->input->post('currentAddress')),
					'State' => $this->input->post('state'),
					'District' => $this->input->post('district'),
					'City' => $this->input->post('city'),
					'Zipcode' => $this->input->post('zip'),
					'Date_of_birth' => date('Y-m-d', strtotime($this->input->post('dob'))), 
					'Wedding_annversary_date' => $this->input->post('Wedding_annversary_date'),
					'Sex' => $this->input->post('sex'),
					'Qualification' => $this->input->post('qualifi'),
					'Photograph' => $filepath,
					'Company_id' => $Company_id
				);
					
				$result = $this->Enroll_model->update_enrollment($post_data,$Call_Enrollid);
				
				if($result == true)
				{						
					/*********************igain Log Table change 14-06-2017*************************/
					$opration = 2;				
					$userid=$session_data['userId'];
					$what="Update Enrollment ";
					$where="Call Center Profile";
					$toname="";
					$toenrollid = 0;
					$opval =$this->input->post('firstName').' '.$this->input->post('lastName').', ( Enrollement Id- '.$Call_Enrollid.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $this->input->post('firstName');
					$lastName = $this->input->post('lastName');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$session_data['Full_name'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Call_Enrollid);
					/**********************igain Log Table change 14-06-2017*************************/
				}	
				
					$error_img= $this->upload->display_errors();
					if(strlen($error_img)!=43)
					{
						$this->session->set_flashdata("error_code",$this->upload->display_errors());
					}
					
					$this->session->set_flashdata("success_code","Profile Updated Successfuly!!");
				
				// $this->load->view('CallCenter/Handle_member_home', $data); 
				
				redirect("Call_center/edit_handle_member_home/");				
			} 
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function edit_handle_member_transaction()
	{	
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
			$Sub_seller_admin= $session_data['Sub_seller_admin'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$login_userId = $data['userId'];
			$login_enrollId = $data['enroll'];
			$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
				
			$results1 = $this->Enroll_model->edit_enrollment($Call_Enrollid);
			$cust_membershipId=$results1->Card_id;

			$data["transaction_types"] = $this->Igain_model->get_transaction_type();
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);
			
			if($get_sellers15 != NULL)
			{
				foreach($get_sellers15 as $seller_val)
				{
					$superSellerFlag = $seller_val->Super_seller;
				}
			}
			else
			{
				$superSellerFlag=0;
			}
	
			if($login_userId > 2 || $superSellerFlag == 1)
			{
				
				$data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'],$data['enroll']);
			}
			else if($Sub_seller_admin==1 &&  $login_userId == 2 )
			{	
				
				$data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'],$data['Company_id']);
			}
			else
			{	
				$data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
			}

			if(isset($_REQUEST["from_date"]) && isset($_REQUEST["to_date"]))
			{
				$from_date=date('Y-m-d',strtotime($_REQUEST["from_date"]));
				$to_date=date('Y-m-d',strtotime($_REQUEST["to_date"]));
			}
			else
			{
				$from_date='1970-01-01 00:00:00';
				$to_date=date('Y-m-d H:i:s',strtotime("+1 days"));
			}
			if(isset($_REQUEST["transaction_type_id"])) 
			{
				$transaction_type = $_REQUEST["transaction_type_id"];
			}
			else
			{
				$transaction_type='0';
			}
			if(isset($_REQUEST["seller_id"])) 
			{
				$seller_id = $_REQUEST["seller_id"];
			}
			else
			{
				$seller_id='0';
			}
			
			if($Call_Enrollid != "")
			{									
				
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				$data["Redeemtion_tran"] = $this->CallCenter_model->Member_transaction($limit,$start,$data['Company_id'],$cust_membershipId,$Call_Enrollid,$login_userId,$login_enrollId,$from_date,$to_date,$transaction_type,$SuperSellerFlag,$seller_id);
				//print_r($data["Redeemtion_tran"]);
				$this->load->view('CallCenter/Handle_member_transaction', $data);	
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function edit_handle_member_query_record()
	{	
		if($this->session->userdata('logged_in'))
		{		
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
			$results1 = $this->Enroll_model->edit_enrollment($Call_Enrollid);
			$cust_membershipId=$results1->Card_id;
			
							
			if($Call_Enrollid != "")
			{
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				// $Enrollement_id =  $_GET['Enrollement_id'];			
				$Enrollement_id =  $Call_Enrollid;			
				$data['Enrollement_id'] =  $Call_Enrollid;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$FetchedCountrys = $this->Igain_model->FetchCountry();	
				$data['Country_array'] = $FetchedCountrys;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				$data["Memberquery"] = $this->CallCenter_model->member_query_record_list($data['Company_id'], $cust_membershipId);
				$data["Memberquerystatus"] = $this->CallCenter_model->Get_member_query_status_list($data['Company_id'], $cust_membershipId);
							
				$this->load->view('CallCenter/Handle_member_query_record', $data);	
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function member_query_record()
	{	
		if($this->session->userdata('logged_in'))
		{	
		
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
			$results1 = $this->Enroll_model->edit_enrollment($Call_Enrollid);
			$cust_membershipId=$results1->Card_id;
			
			if($Call_Enrollid != "")
			{
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				// $Enrollement_id =  $_GET['Enrollement_id'];			
				$Enrollement_id =  $Call_Enrollid;			
				$data['Enrollement_id'] =  $Call_Enrollid;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$FetchedCountrys = $this->Igain_model->FetchCountry();	
				$data['Country_array'] = $FetchedCountrys;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				$data["Memberquery"] = $this->CallCenter_model->member_query_record_list($data['Company_id'], $cust_membershipId);
				$data["Memberquerystatus"] = $this->CallCenter_model->Get_member_query_status_list($data['Company_id'], $cust_membershipId);
							
				$this->load->view('CallCenter/Handle_member_query_record', $data);	
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function edit_handle_member_log_query()
	{	
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
			$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
			if($Call_Enrollid !="")
			{
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				// $Enrollement_id =  $_GET['Enrollement_id'];			
				$Enrollement_id =  $Call_Enrollid;			
				$data['Enrollement_id'] =  $Call_Enrollid;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Call_Enrollid);
				$data["query_type"] = $this->CallCenter_model->get_query_type($Company_id);
				$data["prioritylevel"] = $this->CallCenter_model->get_prioritylevel($Company_id);
				$data['Company_id'] = $session_data['Company_id'];
							
				$this->load->view('CallCenter/Handle_member_log_query', $data);	
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	public function Get_Sub_Query()
	{
		$data['Get_subquery_Names'] = $this->CallCenter_model->Get_sub_query_name($this->input->post("QueryTypeId"),$this->input->post("Company_id"));
		$theHTMLResponse = $this->load->view('CallCenter/Get_sub_query', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_Sub_query_Names1'=> $theHTMLResponse)));
	} 
	public function Get_Sub_Query_Report()
	{
		$data['Get_subquery_Names'] = $this->CallCenter_model->Get_sub_query_name($this->input->post("QueryTypeId"),$this->input->post("Company_id"));
		$theHTMLResponse = $this->load->view('CallCenter/Get_sub_query_report', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_Sub_query_Names1'=> $theHTMLResponse)));
	}
	public function Get_Expected_closure_time() 
	{
		$Expected_closure = $this->CallCenter_model->Expected_closure_time($this->input->post("Query_priority"),$this->input->post("Company_id"));
		$Expected_closure1 = $Expected_closure->No_of_days_expected_resolve;
		$mv_datetime= date("Y-m-d H:i:s A", strtotime ("+".$Expected_closure1." hour"));
		$Result127[] = array("Expected_closure1" => $mv_datetime);
		$this->output->set_output(json_encode($Result127));	
	} 
	public function callcenter_querylog_master()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
					
			if($_POST != NULL)
			{
				$Cust_name=$this->input->post('Cust_name');
				$Cust_membershipId=$this->input->post('membershipId');
				$CallType=$this->input->post('CallType');
				$Comm_type=$this->input->post('Comm_type');
				$Query_Type=$this->input->post('Query_Type');
				$Sub_query_type=$this->input->post('Sub_query_type');
				$Query_detail=$this->input->post('Query_detail');
				$Query_priority=$this->input->post('Query_priority');
				$Query_status=$this->input->post('Query_status');
				$exptime=$this->input->post('exptime');				
								
				$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
				$results= $this->Enroll_model->edit_enrollment($Call_Enrollid);
				
				$Enrollement_id=$results->Enrollement_id;
				$Cust_name=$results->First_name.' '.$results->Last_name;
				$Cust_membershipId=$results->Card_id;							
				// exptime  Query_priority
			
				$Resolution_levels = $this->CallCenter_model->Get_Resolution_priority_levels_name($Company_id,$Query_priority);
				$Resolution_priority_name = $Resolution_levels->Level_name;
				
				$Expected_closure = $this->CallCenter_model->Expected_closure_time($Query_priority,$Company_id);
				$Expected_closure1 = $Expected_closure->No_of_days_expected_resolve;
				$mv_datetime = date("Y-m-d H:i:s", strtotime ("+".$Expected_closure1." hour"));
				
				$exptime=$mv_datetime;	
				
				/********************Ravi--12-02-2018*****************************************/				
				
				if($Query_status == 1) // Closed
				{
					$Qstatus='Closed';
					$Closerremark=$this->input->post('Closerremark');								
					$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
					$Querylog_ticket=$Company_details->Callcenter_query_ticketno_series;
					$Company_primary_email_id=$Company_details->Company_primary_email_id;
					$Company_primary_phone_no=$Company_details->Company_primary_phone_no;
					
					$today=date('Y-m-d H:i:s');					
					$Post_data=array
						   ( 
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$Cust_membershipId,
							'Querylog_ticket'=>$Querylog_ticket,
							'Call_type'=>$CallType,
							'Communication_type'=>$Comm_type,
							'Query_type_id'=>$Query_Type,
							'Sub_query_type_id'=>$Sub_query_type,
							'Query_details'=>$Query_detail,
							'Next_action_date'=>$today, 
							'Closure_date'=>$exptime,
							'Resolution_priority_levels'=>$Query_priority,
							'Query_assign'=>$data['enroll'],
							'Enrollment_id'=>$data['enroll'],
							'Query_status'=>$Qstatus,
							'Create_User_id'=>$data['enroll'],
							'Update_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
						$result = $this->CallCenter_model->Insert_callcenter_querylog_master($Post_data);
						
					$Post_data1=array
						   ( 
							'Query_log_id'=>$result,
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$Cust_membershipId,
							'Querylog_ticket'=>$Querylog_ticket,
							'Query_details'=>$Query_detail,
							'Query_interaction'=>$Closerremark,
							'Enrollment_id'=>$data['enroll'],
							'Call_type'=>$CallType,
							'Communication_type'=>$Comm_type,							
							'Next_action_date'=>$today, 
							'Closure_date'=>$exptime,
							'Query_status'=>$Qstatus,
							'Query_assign'=>$data['enroll'],
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   ); 
						$result1 = $this->CallCenter_model->Insert_callcenter_querylog_child($Post_data1);
					
					if($result == true && $result1 == true)				
					{
						/*******************Insert igain Log Table*********************/
						$get_query_name = $this->CallCenter_model->get_query_details($Query_Type,$Company_id); 
						$Query_name=$get_query_name->Query_type_name;
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Call Center Query Closed";
						$where="Handel Member Query";
						$To_enrollid = $this->session->userdata('Call_Enrollid1');
						$firstName = $results->First_name;
						$lastName = $results->Last_name;
						$Seller_name = $session_data['Full_name'];
						$opval = $Query_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
							
						$Post_data=array 
						   (							
							'Callcenter_query_ticketno_series'=>$Querylog_ticket+1
						   );
					   
						$result = $this->CallCenter_model->Update_company_ticketno_series($Post_data,$session_data['Company_id']);
						
						/***************Send Query Log Notification********************/
						$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
						$Notification_type = "Call center query close";
						
						$Email_content = array(
								'Log_date' => $today,  
								'Cust_name' =>  $Cust_name,
								'Excecative_name' =>  $Company_primary_phone_no,
								'Querylog_ticket' => $Querylog_ticket,
								'Query_type' => $Query_name,
								'Close_datetime' => $today,
								'Excecative_email' => $Company_primary_email_id,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Call_Center_Query_close'
							);	
						$this->send_notification->send_Notification_email($Call_Enrollid,$Email_content,$enroll,$Company_id); 
						/***************Send Query Log Notification********************/
						
						$this->session->set_flashdata("success_code","Call Center Query Log <b> Ticket No :- " .$Querylog_ticket.   "  </b> Closed  Successfuly!!");					
					}
					else
					{					
						$this->session->set_flashdata("error_code","Error Call Center Query Log Closed. Please Provide valid data!!");
					}
				} 
				else if($Query_status == 2) //Forward
				{
					$Qstatus='Forward';
					$Closerremark = '';							
					$User_detail = $this->CallCenter_model->Get_ccquery_user($Query_Type,$Company_id);
					$cc_user_id=$User_detail->Enrollment_id;
					$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
					$Querylog_ticket=$Company_details->Callcenter_query_ticketno_series;
					$today=date('Y-m-d H:i:s');
					$Post_data=array
						   ( 
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$Cust_membershipId,
							'Querylog_ticket'=>$Querylog_ticket,
							'Call_type'=>$CallType,
							'Communication_type'=>$Comm_type,
							'Query_type_id'=>$Query_Type,
							'Sub_query_type_id'=>$Sub_query_type,
							'Query_details'=>$Query_detail,
							'Next_action_date'=>$today, 
							'Closure_date'=>$exptime,
							'Resolution_priority_levels'=>$Query_priority,
							'Query_assign'=>$cc_user_id,
							'Enrollment_id'=>$cc_user_id,
							'Query_status'=>$Qstatus,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
					$result = $this->CallCenter_model->Insert_callcenter_querylog_master($Post_data);
					
					$User_detail = $this->CallCenter_model->Get_ccquery_userchild($Query_Type,$Company_id);
					foreach($User_detail as $user)
					{
					  $cc_user_id=$user['Enrollment_id'];
					  
					  $Post_data1=array
						   ( 
							'Query_log_id'=>$result,
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$Cust_membershipId,
							'Querylog_ticket'=>$Querylog_ticket,
							'Query_details'=>$Query_detail,
							'Query_interaction'=>$Closerremark,
							'Enrollment_id'=>$cc_user_id,
							'Call_type'=>$CallType,
							'Communication_type'=>$Comm_type,							
							'Next_action_date'=>$today, 
							'Closure_date'=>$exptime,
							'Query_status'=>$Qstatus,
							'Query_assign'=>$cc_user_id,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   ); 
						$result1 = $this->CallCenter_model->Insert_callcenter_querylog_child($Post_data1);
					}
					
					if($result == true && $result1 == true)				
					{
						/*******************Insert igain Log Table*********************/
						$get_query_name = $this->CallCenter_model->get_query_details($Query_Type,$Company_id); 
						$Query_name=$get_query_name->Query_type_name;
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Call Center Query Log Added";
						$where="Handel Member Query";
						$To_enrollid = $this->session->userdata('Call_Enrollid1');
						$firstName = $Cust_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Query_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
						
						$Post_data=array 
						   (							
							'Callcenter_query_ticketno_series'=>$Querylog_ticket+1
						   );
					   
						$result = $this->CallCenter_model->Update_company_ticketno_series($Post_data,$session_data['Company_id']);
						
						/***************Send Query Log Notification********************/
						$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
						$Notification_type = "Call center query log";
						
						$Email_content = array(
								'Today_date' => $today,
								'Cust_name' =>  $Cust_name,
								'Excecative_name' =>  $session_data['Full_name'],
								'Querylog_ticket' => $Querylog_ticket,
								'Max_resolution_datetime' => $exptime,
								//'Excecative_email' => $username,
								'Excecative_email' => $Resolution_priority_name,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Call_Center_Query_Log'
							);	
						$this->send_notification->send_Notification_email($Call_Enrollid,$Email_content,$enroll,$Company_id); 
						/***************Send Query Log Notification********************/
						
						$this->session->set_flashdata("success_code","Call Center Query Log <b> Ticket No :- " .$Querylog_ticket.   "  </b> Inserted  Successfuly!!");			
					}
					else
					{					
						$this->session->set_flashdata("error_code","Error Call Center Query Log Inserted. Please Provide valid data!!");
					}
				}			
				redirect("Call_center/edit_handle_member_query_record");				
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_log_query', $data);	
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function search_memeber_query()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Country_id'] = $session_data['Country_id'];
		$data['Company_id'] = $session_data['Company_id'];
		$TicketNo = $this->input->post("TicketNo");
		$Query_status = $this->input->post("Query_status");
		$Enrollment_id = $this->input->post("Enrollment_id");
		$Company_id = $this->input->post("Company_id");
		$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
		$results1 = $this->Enroll_model->edit_enrollment($Call_Enrollid);
		$cust_membershipId=$results1->Card_id;

		$data["Memberquery"] = $this->CallCenter_model->Search_member_query_record($TicketNo,$Company_id,$Query_status,$cust_membershipId);
		$this->load->view('CallCenter/Search_query_record', $data);
	} 
	function search_memeber_transaction()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Country_id'] = $session_data['Country_id'];
		$to_date1 = $this->input->post("to_date");
		$from_date1 = $this->input->post("from_date");   
		$Company_id = $this->input->post("Company_id");
		$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
		$results1 = $this->Enroll_model->edit_enrollment($Call_Enrollid);
		$cust_membershipId=$results1->Card_id;
		$from_date = date("Y-m-d",strtotime($from_date1));
		$to_date = date("Y-m-d",strtotime($to_date1));
		/*-----------------------Pagination redeemtion_tran---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Call_center/edit_handle_member_transaction";
			$total_row = $this->CallCenter_model->count_member_redeemtion_tran_search($from_date,$to_date,$Call_Enrollid,$cust_membershipId,$Company_id);			
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
			/*-----------------------Pagination redeemtion_tran---------------------*/
			$data["pagination"] = $this->pagination->create_links();
			$data["Redeemtion_tran"] = $this->CallCenter_model->Search_Member_redeemtion_transaction($config["per_page"],$page,$Company_id,$cust_membershipId,$Call_Enrollid,$from_date,$to_date);
			$data["transfer_point"] = $this->CallCenter_model->Search_Member_transfer_point_transaction($config["per_page"],$page,$Company_id,$cust_membershipId,$Call_Enrollid,$from_date,$to_date);
			$data["accrual_transaction"] = $this->CallCenter_model->Search_Member_accrual_transaction($config["per_page"],$page,$Company_id,$cust_membershipId,$Call_Enrollid,$from_date,$to_date);
			$data["PointExpir_transaction"] = $this->CallCenter_model->Search_point_expir_transaction($config["per_page"],$page,$Company_id,$cust_membershipId,$Call_Enrollid,$from_date,$to_date);
		
			$this->load->view('CallCenter/Cc_Search_transaction_record', $data);
	}
	function Query_interaction_details()
	{
		$session_data = $this->session->userdata('logged_in');
		$TicketNo = $this->input->post("TicketNo");
		$Company_id = $this->input->post("Company_id");
	
		$data["Memberquery_interaction"] = $this->CallCenter_model->Query_interaction_details1($TicketNo,$Company_id);
		$theHTMLResponse = $this->load->view('CallCenter/Veiw_query_interaction', $data, true);	$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
	} 
	function view_query_log_details()
	{	
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			if($data['enroll'] != "")
			{	
				
				$Log_ticket =$this->input->post("Log_ticket");
				$querypriority =$this->input->post("querypriority");
				$Expected_closure_date =$this->input->post("Expected_closure_date");
				if($Expected_closure_date !=NULL)
				{
					$Closure_date = date("Y-m-d",strtotime($Expected_closure_date));
				}
				else
				{
					$Closure_date = NULL;
				}
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;			
				$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				$data['get_prioritylevel'] = $this->CallCenter_model->get_prioritylevel($Company_id);
				// var_dump($data['get_prioritylevel']);die;
				
				$data["Assign_qry"] = $this->CallCenter_model->Assign_query($data['Company_id'],$data['enroll'],$Log_ticket,$querypriority,$Closure_date);
				
				$data['LoginUserQry1'] = $this->CallCenter_model->Fetch_login_user_queryType($Company_id,$data['enroll']);
				if($data['LoginUserQry1'] != NULL)
				{
					foreach($data['LoginUserQry1'] as $LoginUserQry) 
					{
						$LoginUserQry_id[]=$LoginUserQry->Query_type_id;
					}
				}
				$data["Forward_qury"] = $this->CallCenter_model->Forward_querys($data['Company_id'],$LoginUserQry_id,$data['enroll'],$Log_ticket,$querypriority,$Closure_date);		
				
				$data["closed_qury"] = $this->CallCenter_model->Closed_querys($data['Company_id'],$LoginUserQry_id,$Log_ticket,$querypriority,$Closure_date,$SuperSellerFlag,$data['enroll']);
				
				$this->load->view('CallCenter/View_query_log_details', $data);	
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	public function Get_Qurey_user_name()
	{
		$data['QueryTypeUser'] = $this->CallCenter_model->Fetch_query_user_id($this->input->post("Company_id"),$this->input->post("QueryTypeId"));
			
		foreach($data['QueryTypeUser'] as $QueryTypeUser)
		{
			$QueryUser_id[]=$QueryTypeUser->Enrollment_id;
		}
		$data['Get_User_Names'] = $this->CallCenter_model->Get_query_user_name($this->input->post("User_id"),$QueryUser_id,$this->input->post("Company_id"));
		$theHTMLResponse = $this->load->view('CallCenter/Get_User_names', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_User_Names1'=> $theHTMLResponse)));
	}
	public function Get_SuperSeller_user_name()
	{
		$session_data = $this->session->userdata('logged_in');
		$SuperSellerFlag = $session_data['Super_seller'];
		//if($SuperSellerFlag == 0)	
		{
			$data['Get_User_Names'] = $this->CallCenter_model->Get_SuperSeller_user_name($this->input->post("User_id"),$this->input->post("Company_id"));
		}
		$theHTMLResponse = $this->load->view('CallCenter/Get_SuperSeller_user_name', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_User_Names1'=> $theHTMLResponse)));
	}
	public function Get_SuperSeller_user_name1()
	{
		$session_data = $this->session->userdata('logged_in');
		$SuperSellerFlag = $session_data['Super_seller'];
		
		$data['Get_User_Names'] = $this->CallCenter_model->Get_SuperSeller_user_name($this->input->post("User_id"),$this->input->post("Company_id"));
		
		$theHTMLResponse = $this->load->view('CallCenter/Get_SuperSeller_user_name', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_User_Names1'=> $theHTMLResponse)));
	}
	function Edit_Cc_querylog()
	{	
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Child_query_log_id = $_GET['Child_query_log_id'];
			
			if($_GET['Child_query_log_id'])
			{
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				$Querylog_details = $this->CallCenter_model->edit_Edit_Cc_querylog($_GET['Child_query_log_id'],$Company_id);
				
				$data['Querylog_details'] = $Querylog_details;
				
				$Custdetails = $this->CallCenter_model->get_cust_details($Querylog_details->Membership_id,$Company_id);
				
				$this->session->set_userdata('Call_Enrollid1', $Custdetails->Enrollement_id);			
				$this->session->set_userdata('ChildQuery_LogId', $_GET['Child_query_log_id']);			
				$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
				$Child_query_log_id = $this->session->userdata('ChildQuery_LogId');
			
				
				$this->load->view('CallCenter/Edit_Cc_querylog_master', $data);			
			}
			else
			{
				$this->load->view('CallCenter/Handle_member_query', $data);	
			}			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	public function Update_callcenter_querylog_master()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			if($_POST != NULL)
			{				
				
				$QueryLogId=$this->input->post('QueryLogId'); 
				$Cust_name=$this->input->post('Cust_name');
				$Ticket_number=$this->input->post('Ticket_number');
				$Cust_membershipId=$this->input->post('membershipId');
				$CallType=$this->input->post('CallType');
				$Comm_type=$this->input->post('Comm_type');
				$Query_Type=$this->input->post('querytype');
				$Sub_query_type=$this->input->post('subquery');
				$Query_detail=$this->input->post('Query_detail');
				$Query_priority=$this->input->post('QueryPriority');
				$exptime=$this->input->post('exptime'); 
				$Query_status=$this->input->post('QryStatus');
				
					$Call_Enrollid = $this->session->userdata('Call_Enrollid1');
					$Child_query_log_id = $this->session->userdata('ChildQuery_LogId');
					$results = $this->Enroll_model->edit_enrollment($Call_Enrollid);				
					$Enrollement_id=$results->Enrollement_id;
					$Cust_name=$results->First_name.' '.$results->First_name;
					$Cust_membershipId=$results->Card_id;
					$Querylog_details = $this->CallCenter_model->edit_Edit_Cc_querylog($Child_query_log_id,$Company_id);				
					$QueryLogId=$Querylog_details->Query_log_id;
					$Ticket_number=$Querylog_details->Querylog_ticket;
					$CallType=$Querylog_details->Call_type;
					$Comm_type=$Querylog_details->Communication_type;				
					$GetTicketInfo = $this->CallCenter_model->Get_ticket_info($Querylog_details->Querylog_ticket,$Company_id); 
					$QryType = $GetTicketInfo->Query_type_id;
					$GetQryInfo = $this->CallCenter_model->Get_Call_center_query_type($Company_id,$QryType);
					$Query_Type=$GetQryInfo->Query_type_name;
					$GetSubQryInfo = $this->CallCenter_model->Get_Call_center_sub_query($Company_id,$GetTicketInfo->Sub_query_type_id);
					$Sub_query_type= $GetSubQryInfo->Sub_query;
					$Query_detail=$Querylog_details->Query_details;				
					$GetPriority = $this->CallCenter_model->Get_Resolution_priority_level_name($Company_id,$GetTicketInfo->Resolution_priority_levels); 
					$Query_priority= $GetPriority->Level_name;
					$exptime = $Querylog_details->Closure_date;
					$Qlogdate = $Querylog_details->Creation_date;
									
				
				$Company_details= $this->Igain_model->get_company_details($Company_id);
				$Querylog_ticket=$Company_details->Callcenter_query_ticketno_series;
				$Company_primary_email_id=$Company_details->Company_primary_email_id;
				$Company_primary_phone_no=$Company_details->Company_primary_phone_no;
				
				if($Query_status === "Close") //Close
				{
					$Qstatus='Closed';
					$Closerremark=$this->input->post('Closerremark');								
					
					$today=date('Y-m-d H:i:s A');						
					$Post_data=array 
					   (							
						'Query_status'=>$Qstatus,
						'Update_User_id'=>$data['enroll'],
						'Update_date'=>$today,
					   );
				   
					$result = $this->CallCenter_model->Update_callcenter_querylog($Post_data,$session_data['Company_id'],$Ticket_number,$Cust_membershipId);
								
					$Post_data1=array
						   ( 
							'Query_log_id'=>$QueryLogId,
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$Cust_membershipId,
							'Querylog_ticket'=>$Ticket_number,
							'Query_details'=>$Query_detail,
							'Query_interaction'=>$Closerremark,
							'Enrollment_id'=>$data['enroll'],
							'Call_type'=>$CallType,
							'Communication_type'=>$Comm_type,							
							'Next_action_date'=>$today, 
							'Closure_date'=>$today,
							'Query_status'=>$Qstatus,
							'Query_assign'=>$data['enroll'],
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   ); 
						$result1 = $this->CallCenter_model->Insert_callcenter_querylog_child($Post_data1);	
						
					if($result == true && $result1 == true)				
					{		
						/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid= $session_data['userId'];
						$what= "Call Center Query Log Update";
						$where= "View Query Log Details";
						$To_enrollid = $Enrollement_id;
						$firstName = $Cust_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Query_Type;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/		
						/***************Send Query Log Notification********************/
						// $Call_Enrollid = $CustEnrollId;
						$Notification_type = "Call center query close";
						
						$Email_content = array( 
								'Log_date' => $Qlogdate,
								'Cust_name' => $Cust_name,
								'Excecative_name' => $Company_primary_phone_no,
								'Querylog_ticket' => $Ticket_number,
								'Query_type' => $Query_Type,
								'Close_datetime' => $today,
								'Excecative_email' => $Company_primary_email_id,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Call_Center_Query_close'
							);	
						$this->send_notification->send_Notification_email($Call_Enrollid,$Email_content,$enroll,$Company_id); 
						/***************Send Query Log Notification********************/
						
						$this->session->set_flashdata("handle_member","Call Center Query Log <b> Ticket :- " .$Ticket_number.  "</b> Closed Successfuly!!");	
					}
					else
					{					
						$this->session->set_flashdata("handle_member","Error Call Center Query Log Ticket Closed. Please Provide valid data!!");
					}
				}
				else if($Query_status === "Forward") //Forward
				{
					$today=date('Y-m-d H:i:s');	
					$Query_status = "Forward";
					$Interaction_detail=$this->input->post('Interaction_detail');
					$Forward_user=$this->input->post('UserName'); 
					
					$Post_data1=array
						   ( 
							'Query_log_id'=>$QueryLogId,
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$Cust_membershipId,
							'Querylog_ticket'=>$Ticket_number,
							'Query_details'=>$Query_detail,
							'Query_details'=>$Query_detail,
							'Query_interaction'=>$Interaction_detail,
							'Enrollment_id'=>$Forward_user,
							'Call_type'=>$CallType,
							'Communication_type'=>$Comm_type,							
							'Next_action_date'=>$exptime, 
							'Closure_date'=>$exptime,
							'Query_status'=>$Query_status,
							'Query_assign'=>$Forward_user,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   ); 
					$result1 = $this->CallCenter_model->Insert_callcenter_querylog_child($Post_data1);
						
					if($result1 == true)				
					{		
						/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid= $session_data['userId'];
						$what= "Call Center Query Log escalation"; 
						$where= "View Query Log Details";
						$To_enrollid = $Call_Enrollid;
						$firstName = $Cust_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Query_Type;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
						
						$this->session->set_flashdata("handle_member","Call Center Query Log <b> Ticket :- " .$Ticket_number.  "</b> Forward Successful!!");
					}
					else
					{					
						$this->session->set_flashdata("handle_member","Error Call Center Query Log Ticket Forward. Please Provide valid data!!");
					}					
				}
			}		
				redirect("Call_center/view_query_log_details");						
		}
		else
		{
			// $this->load->view('CallCenter/Edit_Cc_querylog_master', $data);	
			redirect('Login', 'refresh');
		}
	}
	public function Cc_transaction_receipt()
	{
		$this->load->model('master/currency_model');
		$Bill_no = $this->input->post("Bill_no");
		$Seller_id = $this->input->post("Seller_id");
		$Trans_id = $this->input->post("Trans_id");
		$transtype = $this->input->post("Transaction_type");
		$Company_id = $this->input->post("Company_id");
		
		$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

		$Todays_date = date("Y-m-d");
		if($Seller_id !=0)
		{
			$seller_details = $this->Igain_model->get_enrollment_details($Seller_id);		
			$seller_name = $seller_details->First_name.' '.$seller_details->Last_name;
			//echo "---seller_name--".$seller_name."--<br>";

			$address = $seller_details->Current_address;
			$timezone12 = $seller_details->timezone_entry;
			$Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;
			
			$company_details = $this->Igain_model->get_company_details($seller_details->Company_id);
			$compname = $company_details->Company_name;
			$Comp_redemptionratio = $company_details->Redemptionratio;
			
			$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
			$Symbol_currency = $currency_details->Symbol_of_currency;
		
		if($Seller_Redemptionratio != NULL)
		{
			$redemptionratio = $Seller_Redemptionratio;					
		}
		else
		{
			$redemptionratio = $Comp_redemptionratio;
		}
		}
			
		$transaction_details = $this->CallCenter_model->get_bills_info($Bill_no,$Trans_id,$transtype,$Seller_id);
		
		$data['transaction_details'] = $transaction_details;
		// print_r($transaction_details);die;
		foreach($transaction_details as $transaction)
		{
			$data['Trans_id'] = $transaction['Trans_id'];
			
			$enrollid = $transaction['Enrollement_id'];
			$Transaction_type = $transaction['Trans_type'];
			$tra_date = $transaction['Trans_date'];	
			$GiftCardNo = $transaction['GiftCardNo'];
			
			$data['Manual_billno'] = $transaction['Manual_billno'];
			$data['Remark'] = $transaction['Remarks'];
			$data['Remarks2'] = $transaction['remark2'];
			$data['Seller_name'] = $transaction['Seller_name'];
			$data['Recived_point'] = $transaction['Loyalty_pts'];
			$reedem = $transaction['Redeem_points'];
			$Shipping_points = $transaction['Shipping_points'];
			$Shipping_cost = $transaction['Shipping_cost'];
			// $Purchase_amount = $transaction['Purchase_amount'];
			$Delivery_method = $transaction['Delivery_method'];
			/* $redeem_amt =($reedem * $redemptionratio );
			$redeem_amt = (round($redeem_amt,2)); */
			$redeem_amt =$reedem;
			if($transtype == 1)
			{
				$data['Topup_amount'] = $transaction['Topup_amount'];
				$data['Redeem_points'] = 0;
			}
			if($transtype == 8)
			{
				$data['Transfer_points'] = $transaction['Transfer_points'];	
				$Enroll_detaails = $this->CallCenter_model->get_cust_details($transaction['Card_id2'],$Company_id); 
				$data['Card_id2'] = $Enroll_detaails->First_name.' '.$Enroll_detaails->Last_name.' ('.$transaction['Card_id2'].')';
				// $data['Remark'] = $transaction['Remarks'];
				$data['Purchase_amount'] = 0;
				$data['Recived_point'] = 0;
				$data['Redeem_points'] = 0;
				$data['Payment_description'] = '';
			}
			if($transtype == 2)
			{
				$data['Purchase_amount'] = $transaction['Purchase_amount'];
				$data['Item_category_name'] = $transaction['Item_category_name'];
				$data['Redeem_points'] = $redeem_amt;
				 $data['balance_to_pay'] = $transaction['balance_to_pay'];
				$data['Payment_description'] =  $transaction['Payment_description'];
				
				$data['Payment_type_id'] =  $transaction['Payment_type_id'];
				$data['Bank_name'] =  $transaction['Bank_name'];
				$data['Branch_name'] =  $transaction['Branch_name'];
				$data['Credit_Cheque_number'] =  $transaction['Credit_Cheque_number'];
				$data['Voucher_no'] =  $transaction['Voucher_no'];
				
				$data['Loyalty_pts'] = $transaction['Loyalty_pts'];
				$data['Coalition_Loyalty_pts'] = $transaction['Coalition_Loyalty_pts'];
				$data['Loyalty_id'] = $transaction['Loyalty_id']; 
				$data['GiftCardNo'] = $transaction['GiftCardNo'];
				$data['Flatfile_remarks'] = $transaction['Flatfile_remarks'];
				$data['Loyalty_Transaction'] = $this->CallCenter_model->Fetch_Transaction_Loyalty_Details($Trans_id,$seller_details->Company_id,$Seller_id);
				$data['Bill_no']=$data['Loyalty_Transaction']->Bill_no;
			}
			if($transtype == 3)
			{
				$data['Redeem_points'] = $redeem_amt;
			}
			if($transtype == 10)	//****Catalogue Redemption
			{
				$redeem_bill_info = $this->CallCenter_model->get_redeem_bill_info($Bill_no,$Trans_id,$seller_details->Company_id,$transtype);
				$Redeemed_item = "";
				$Total_redeem_points = 0;
				
				foreach($redeem_bill_info as $redeem_info)
				{
					
					if($redeem_info['Billing_price_in_points']==0)
					{
						$lv_Billing_price_in_points="";
					}
					else
					{
						$lv_Billing_price_in_points=" X ".$redeem_info['Redeem_points']." Points";
					}
					$Item_size="<span style='font-size:10px;'>(".$redeem_info['Item_size'].")</span>";
					
					if($redeem_info['Item_size'] =="0")
					{
						$Item_size='-';
					}
					else if($redeem_info['Item_size'] =="1")
					{
						$Item_size='Small';
					}
					else if($redeem_info['Item_size'] =="2")
					{
						$Item_size='Medium';
					}
					else if($redeem_info['Item_size'] =="3")
					{
						$Item_size='Large';
					}
					else if($redeem_info['Item_size'] =="4")
					{
						$Item_size='Extra Large';
					}
						if($redeem_info['Voucher_status'] == 18)
						{
							$Voucher_status="Ordered";
						}
						else if($redeem_info['Voucher_status'] == 19)
						{
							$Voucher_status="Shipped";
						}
						else if($redeem_info['Voucher_status'] == 20)
						{
							$Voucher_status="Delivered";
						}
						else if($redeem_info['Voucher_status'] == 21)
						{
							$Voucher_status="Cancel";
						}
						else if($redeem_info['Voucher_status'] == 22)
						{
							$Voucher_status="Return Initiated";
						}
						else if($redeem_info['Voucher_status'] == 23)
						{
							$Voucher_status="Returned";
						}
						else if($redeem_info['Voucher_status'] == 30)
						{
							$Voucher_status="Issued";
						}
						else if($redeem_info['Voucher_status'] == 31)
						{
							$Voucher_status="Used";
						}
						else if($redeem_info['Voucher_status'] == 32)
						{
							$Voucher_status="Expired";
						}
					if($redeem_info === end($redeem_bill_info))
					{
						
						$Redeemed_item .= $redeem_info['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$redeem_info['Quantity']." ".$lv_Billing_price_in_points."):".$Voucher_status;
					}
					else
					{
						$Redeemed_item .= $redeem_info['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$redeem_info['Quantity']." ".$lv_Billing_price_in_points." ):".$Voucher_status.", <br>";
					}
				
					$Total_redeem_points = $Total_redeem_points + ( $redeem_info['Redeem_points'] * $redeem_info['Quantity'] );
					$Shipping_points = $redeem_info['Shipping_points'];
					$Delivery_method = $redeem_info['Delivery_method'];
				}
				$data['Delivery_method'] = $Delivery_method;
				$data['Redeemed_item'] = $Redeemed_item;
				$data['Total_redeem_points'] = $Total_redeem_points;
				$data['Shipping_points'] = $Shipping_points;
				// $data['Redeemed_item'] = $Merchandize_Item_details->Merchandize_item_name;
				$data['Redeem_points'] = $redeem_amt;
				$data['Voucher_no'] = $transaction['Voucher_no'];
				$data['Voucher_status'] = $transaction['Voucher_status'];
				$data['Bill_no']=$transaction['Bill_no'];
			}
			if($transtype == 12)	//****Purchase Catalogue
			{ 
				$purchase_bill_info = $this->CallCenter_model->get_purchase_bill_info($Bill_no,$Trans_id,$seller_details->Company_id,$transtype);
				$Redeemed_item = "";
				$Total_redeem_points = 0;
				
				foreach($purchase_bill_info as $purchase_info)
				{
					if($purchase_info['Billing_price']==0)
					{
						$lv_Billing_price_in_points="";
					}
					else 
					{
						$lv_Billing_price_in_points=" X ".$purchase_info['Billing_price']." $Symbol_currency";
						
					}
					$Item_size="<span style='font-size:10px;'>(".$purchase_info['Item_size'].")</span>";
					if($purchase_info['Item_size'] =="0")
					{
						$Item_size='-';
					}
					else if($purchase_info['Item_size'] =="1")
					{
						$Item_size='Small';
					}
					else if($purchase_info['Item_size'] =="2")
					{
						$Item_size='Medium';
					}
					else if($purchase_info['Item_size'] =="3")
					{
						$Item_size='Large';
					}
					else if($purchase_info['Item_size'] =="4")
					{
						$Item_size='Extra Large';
					}
						if($purchase_info['Voucher_status'] == 18)
						{
							$Voucher_status="Ordered";
						}
						else if($purchase_info['Voucher_status'] == 19)
						{
							$Voucher_status="Shipped";
						}
						else if($purchase_info['Voucher_status'] == 20)
						{
							$Voucher_status="Delivered";
						}
						else if($purchase_info['Voucher_status'] == 21)
						{
							$Voucher_status="Cancel";
						}
						else if($purchase_info['Voucher_status'] == 22)
						{
							$Voucher_status="Return Initiated";
						}
						else if($purchase_info['Voucher_status'] == 23)
						{
							$Voucher_status="Returned";
						}
						else if($purchase_info['Voucher_status'] == 30)
						{
							$Voucher_status="Issued";
						}
						else if($purchase_info['Voucher_status'] == 31)
						{
							$Voucher_status="Used";
						}
						else if($purchase_info['Voucher_status'] == 32)
						{
							$Voucher_status="Expired";
						}
					if($purchase_info === end($purchase_bill_info))
					{
						$Redeemed_item .= $purchase_info['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$purchase_info['Quantity']." "."):".$Voucher_status;
					}
					else
					{
						$Redeemed_item .= $purchase_info['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$purchase_info['Quantity']." "." ):".$Voucher_status.", <br>";
					}
					
					$Total_redeem_points = $purchase_info['Redeem_points'];
					$Purchase_amount = $purchase_info['Purchase_amount'];
				}
				
				$data['Redeemed_item'] = $Redeemed_item;
				$data['Purchase_amount'] = $Purchase_amount;
				$data['Total_redeem_points'] = $Total_redeem_points;
				$data['Shipping_cost'] = $Shipping_cost;
				// $data['Redeemed_item'] = $Merchandize_Item_details->Merchandize_item_name;
				$data['Redeem_points'] = $redeem_amt;
				$data['Voucher_no'] = $transaction['Voucher_no'];
				$data['Voucher_status'] = $transaction['Voucher_status'];	
			}
			if($transtype == 17)	//****Purchase Cancel
			{ 
				$purchaseCancel_bill_info = $this->CallCenter_model->get_purchase_cancel_bill_info($Bill_no,$Trans_id,$Company_id,$transtype);
				$Redeemed_item = "";
				$Total_redeem_points = 0;
				
				foreach($purchaseCancel_bill_info as $purchase_cancelInfo)
				{
					
					$Item_size="<span style='font-size:10px;'>(".$purchase_cancelInfo['Item_size'].")</span>";
					if($purchase_cancelInfo['Item_size'] =="")
					{
						$Item_size='';
					}
						
					if($purchase_cancelInfo['Voucher_status'] == 21)
					{
						$Voucher_status="Cancel";
					}
					else
					{
						$Voucher_status="";
					}
						
					if($purchase_cancelInfo === end($purchaseCancel_bill_info))
					{
						$Redeemed_item .= $purchase_cancelInfo['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$purchase_cancelInfo['Quantity']." "."):".$Voucher_status;
					}
					else
					{
						$Redeemed_item .= $purchase_cancelInfo['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$purchase_cancelInfo['Quantity']." "." ):".$Voucher_status.", <br>";
					}
					
					$Total_redeem_points = $purchase_cancelInfo['Redeem_points'];
				}
				$data['Bill_no']=$transaction['Bill_no'];
				$data['Redeemed_item'] = $Redeemed_item;
				$data['Purchase_amount'] = $Purchase_amount;
				$data['Total_redeem_points'] = $Total_redeem_points;
				// $data['Redeemed_item'] = $Merchandize_Item_details->Merchandize_item_name;
				$data['Topup_amount'] = $transaction['Topup_amount'];
				$data['Redeem_points'] = $redeem_amt;
				
			}
			if($transtype == 18)
			{
				$EvoucherExpiry_bill_info = $this->CallCenter_model->get_EvoucherExpiry_bill_info($Bill_no,$Trans_id,$Company_id,$transtype);
				$Redeemed_item = "";
				$Total_redeem_points = 0;
				
				foreach($EvoucherExpiry_bill_info as $EvoucherExpiry_Info)
				{
					
					$Item_size="<span style='font-size:10px;'>(".$EvoucherExpiry_Info['Item_size'].")</span>";
					if($EvoucherExpiry_Info['Item_size'] =="")
					{
						$Item_size='';
					}
						
					if($EvoucherExpiry_Info['Voucher_status'] == 32)
					{
						$Voucher_status="Expired";
					}
					else
					{
						$Voucher_status="";
					}
						
					if($EvoucherExpiry_Info === end($EvoucherExpiry_bill_info))
					{
						$Redeemed_item .= $EvoucherExpiry_Info['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$EvoucherExpiry_Info['Quantity']." "."):".$Voucher_status;
					}
					else
					{
						$Redeemed_item .= $EvoucherExpiry_Info['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$EvoucherExpiry_Info['Quantity']." "." ):".$Voucher_status.", <br>";
					}
					
					$Total_redeem_points = $EvoucherExpiry_Info['Redeem_points'];
				}
				
				$data['Redeemed_item'] = $Redeemed_item;
				$data['Topup_amount'] = $transaction['Topup_amount'];
				$data['Voucher_no'] = $transaction['Voucher_no'];
				$data['Redeem_points'] = 0;
			}
			if($transtype == 22)	//****Purchase Returned
			{ 
				$purchaseReturn_bill_info = $this->CallCenter_model->get_purchase_return_bill_info($Bill_no,$Trans_id,$Company_id,$transtype);
				$Redeemed_item = "";
				$Total_redeem_points = 0;
				
				foreach($purchaseReturn_bill_info as $purchase_ReturnInfo)
				{
					
					$Item_size="<span style='font-size:10px;'>(".$purchase_ReturnInfo['Item_size'].")</span>";
					if($purchase_ReturnInfo['Item_size'] =="")
					{
						$Item_size='';
					}
						
					if($purchase_ReturnInfo['Voucher_status'] == 23)
					{
						$Voucher_status="Returned";
					}
					else
					{
						$Voucher_status="";
					}
						
					if($purchase_ReturnInfo === end($purchaseReturn_bill_info))
					{
						$Redeemed_item .= $purchase_ReturnInfo['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$purchase_ReturnInfo['Quantity']." "."):".$Voucher_status;
					}
					else
					{
						$Redeemed_item .= $purchase_ReturnInfo['Merchandize_item_name']." ".$Item_size.""." ( Quantity : ".$purchase_ReturnInfo['Quantity']." "." ):".$Voucher_status.", <br>";
					}
					
					$Total_redeem_points = $purchase_ReturnInfo['Redeem_points'];
				}
				$data['Bill_no']=$transaction['Bill_no'];
				$data['Redeemed_item'] = $Redeemed_item;
				$data['Purchase_amount'] = $Purchase_amount;
				$data['Total_redeem_points'] = $Total_redeem_points;
				// $data['Redeemed_item'] = $Merchandize_Item_details->Merchandize_item_name;
				$data['Topup_amount'] = $transaction['Topup_amount'];
				$data['Redeem_points'] = $redeem_amt;
				
			}
			if($transtype == 4)
			{
				$data['giftcard_purchase'] = $transaction['Purchase_amount'];
				$data['Redeem_points'] =   $transaction['Redeem_points'];
				$data['balance_to_pay'] = $transaction['balance_to_pay'];
				$data['GiftCardNo'] = $transaction['GiftCardNo'];
				$data['gift_pay_type'] = "Gift Card ( ".$transaction['GiftCardNo']." )";
				$data['Payment_description'] =  $transaction['Payment_description'];
			}
			if($transtype == 7)
			{
				$data['Topup_amount'] = $transaction['Topup_amount'];
				$data['remark2'] =   $transaction['remark2'];
			}
			if($transtype == 13)
			{
				$data['Topup_amount'] = $transaction['Topup_amount'];
			}
			if($transtype == 14)
			{
				$data['Expired_points'] = $transaction['Expired_points'];
				$data['Redeem_points'] = 0;
			}
			
			if($enrollid == 0 && $transtype == 4)
			{		
				$giftcard_details = $this->CallCenter_model->get_giftcard_details($GiftCardNo,$seller_details->Company_id);
				foreach($giftcard_details as $giftcard)
				{
					$Card_balance = $giftcard['Card_balance'];
					$name = $giftcard['User_name'];
					$Email = $giftcard['Email'];
					$Phone_no = $giftcard['Phone_no'];
					$Card_id = $giftcard['Card_id'];
				}
				
				$data['Cust_full_name'] = $name;
				$data['Cust_address'] = " - ";
				$data['Cust_phone_no'] = $Phone_no;
				$data['User_email_id'] = $Email;
				// $customer_details = $this->Coal_Transactions_model->cust_details_from_card($seller_details->Company_id,$Card_id);	//cust_details_from_giftcard
			}
			else
			{
				$customer_details = $this->Igain_model->get_enrollment_details($enrollid);
				$data['Cust_full_name'] = $customer_details->First_name." ".$customer_details->Middle_name." ".$customer_details->Last_name;
				$data['Cust_address'] = $customer_details->Current_address;
				$data['Cust_phone_no'] = $customer_details->Phone_no;
				$data['User_email_id'] = $customer_details->User_email_id;
			}
		
			if($Seller_id!=0)
			{
			$data['Company_name'] = $compname;
			$data['Seller_name'] = $seller_name;
			$data['Seller_address'] = $address;
			$data['Bill_no'] = $Bill_no;
			}
			$data['Transaction_type'] = $transtype;
			$data['Payment_type_id'] =  $transaction['Payment_type_id'];
			$data['Transaction_date'] = $tra_date;
			if($Symbol_currency !=NULL)
			{
				$data['Symbol_currency'] = $Symbol_currency;		
			}
			else
			{
				$data['Symbol_currency'] = '';
			}
			if($Seller_id!=0)
			{
				$data['Timezone'] = $timezone12;
			
			
				$timezone = new DateTimeZone($timezone12);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$lv_date_time=$date->format('Y-m-d H:i:s');
				$Todays_date = $date->format('Y-m-d');	
			
			$data['Todays_date'] = $Todays_date;
			}
		}

		
		$theHTMLResponse = $this->load->view('CallCenter/Cc_show_transaction_receipt', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
	}	
	function merchant_gained_loyalty_points()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
				 
			// $Company_id =  $this->input->post("comp_id");
			$Enrollment_id = $this->input->post("enrollId");
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$Country_details = $this->CallCenter_model->get_Symbol_of_currency($data['Company_details']->Country);
			$data['Currency_Symbol'] = $Country_details->Symbol_of_currency;
				
			$data["MerchantGainedPoints"] = $this->CallCenter_model->Fetch_seller_gained_points($Company_id,$Enrollment_id);	
			
			$theHTMLResponse = $this->load->view('CallCenter/merchant_gained_points_details', $data, true);		
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('transactionDetailHtml'=> $theHTMLResponse)));
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	/*---------------------------------Nilesh Work End----------------------------------------*/	
}
?>