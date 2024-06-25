<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller 
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
		$this->load->model('company/Company_model');
		$this->load->model('Igain_model'); 
		$this->load->model('Catalogue/Catelogue_model');
	}
	
	function create_company()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId'] = $session_data['userId'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Create_user_id = $data['enroll'];
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$enroll_country_id = $enroll_details->Country;
			$currency_details = $this->Igain_model->Get_Country_master($enroll_country_id);
            $data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Company/create_company";
			$total_row = $this->Company_model->company_active_count();
			//echo "total_row ".$total_row;
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
			
			$data['License_type'] = $this->Company_model->Get_Code_decode_master(20);
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
			if($data['userId']=='3')
			{
				if($session_data['Company_id'] =='1')
				{		
					$data["results"] = $this->Company_model->company_active_list($config["per_page"], $page);	
				}
				else
				{
					$Activated=1;
					$data["results"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id);	
				}
			}
		
			/*-----------------------Pagination2---------------------*/			
			$config2 = array();
			$config2["base_url"] = base_url() . "/index.php/Company/create_company";
			$total_row2 = $this->Company_model->company_inactive_count();
			//echo "total_row2  ".$total_row2;
			$config2["total_rows"] = $total_row2;
			$config2["per_page"] = 10;
			$config2["uri_segment"] = 3;        
			$config2['next_link'] = 'Next';
			$config2['prev_link'] = 'Previous';
			$config2['full_tag_open'] = '<ul class="pagination">';
			$config2['full_tag_close'] = '</ul>';
			$config2['first_link'] = 'First';
			$config2['last_link'] = 'Last';
			$config2['first_tag_open'] = '<li>';
			$config2['first_tag_close'] = '</li>';
			$config2['prev_link'] = '&laquo';
			$config2['prev_tag_open'] = '<li class="prev">';
			$config2['prev_tag_close'] = '</li>';
			$config2['next_link'] = '&raquo';
			$config2['next_tag_open'] = '<li>';
			$config2['next_tag_close'] = '</li>';
			$config2['last_tag_open'] = '<li>';
			$config2['last_tag_close'] = '</li>';
			$config2['cur_tag_open'] = '<li class="active"><a href="#">';
			$config2['cur_tag_close'] = '</a></li>';
			$config2['num_tag_open'] = '<li>';
			$config2['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config2);
			$page2 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
  
			//print_r($data["pagination"]);die;
			
			$data["pagination2"] = $this->pagination->create_links();			
			/*-----------------------Pagination2---------------------*/
			
			// var_dump($session_data['Company_id']);
			if($data['userId']=='3' && $session_data['Company_id'] =='1')
			{		
				$data["results2"] = $this->Company_model->company_inactive_list($config2["per_page"], $page2);	
			}
			else
			{
				$Activated=0;
				$data["results2"] = "";
				//$data["results2"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id,$Activated);	
			}
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			/**************************Nilesh 04-10-2017****************************/
			$data["beneficiary_company"] = $this->Company_model->beneficiary_company_list();
			/**************************Nilesh 04-10-2017****************************/
			
			if($_POST == NULL)
			{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['enroll'] = $session_data['enroll'];
				$data['Company_id'] = $session_data['Company_id'];
				$data['userId'] = $session_data['userId'];
				$Company_id = $session_data['Company_id'];
				$Create_user_id = $data['enroll'];
				$data['LogginUserName'] = $session_data['Full_name'];
				$FetchCountry = $this->Igain_model->FetchCountry();	
				$data['Country_array'] = $FetchCountry;
			
				$this->load->view('company/create_company', $data);
			}
			else
			{
				if ( (! $this->upload->do_upload("file")))
				{			
					$this->session->set_flashdata("data_code",$this->upload->display_errors());
					$filepath_logo = "";
					$filepath_white_label = "";
				}
				else
				{	
					/* if($this->upload->do_upload("file"))
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath_logo = "uploads/".$data['upload_data']['file_name'];
					}
					else
					{
						$filepath_logo = '';
					}
					if($this->upload->do_upload("white_label"))
					{
						$data = array('upload_data' => $this->upload->data("white_label"));
						$filepath_white_label = "uploads/".$data['upload_data']['file_name'];
					}
					else
					{
						$filepath_white_label = '';
					} */
					
					
					/* Create the config for image library */
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');
					
					
					$upload22 = $this->upload->do_upload('file');
					$data22 = $this->upload->data();
				   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload22;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$filepath_logo='uploads/'.$data22['file_name'];
					}
					else
					{
						$filepath_logo = '';
					}
					
					$upload23 = $this->upload->do_upload('white_label');
					$data23 = $this->upload->data();
				   
					if($data23['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data23['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload23;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$filepath_white_label='uploads/'.$data23['file_name'];
					}
					else
					{
						$filepath_white_label = '';
					}
				}
				
				if(($Company_id==1) && ($session_data['userId']==3))
				{
					$Partner_company_flag=1;
					$Parent_company=$Company_id;
				}
				else
				{
					$Partner_company_flag=0;
					$Parent_company=$Company_id;
				}
				
				$result = $this->Company_model->insert_company($filepath_logo,$filepath_white_label,$Partner_company_flag,$Parent_company,$Create_user_id);
				
				/**************************Nilesh start 04-10-2017****************************/

				$Beneficiary_flag = $this->input->post('Beneficiary_flag');
				
				if($Beneficiary_flag == 1)
				{
					$Beneficiary_company = $this->input->post('Beneficiary_company');
					//print_r($Beneficiary_company); die;
					foreach($Beneficiary_company as $beneficiarycompany)
					{
					 
						$resultis = $this->Company_model->get_beneficiary_company_details($beneficiarycompany);
						$Contact_name = $resultis->Contact_name;
						$Contact_email_id = $resultis->Contact_email_id;
						
						$Post_data=array 
						   (
							'Company_id'=>$result,
							'Register_beneficiary_id'=>$beneficiarycompany,
							'Contact_name'=>$Contact_name,							
							'Contact_email_id'=>$Contact_email_id	
						   );
						$result1 = $this->Company_model->igain_beneficiary_company($Post_data);
					}
				}
				/**************************Nilesh End 04-10-2017****************************/
				if($result == true)
				{
					$Post_partner_data=array('Partner_type'=>1,
										'Company_id'=>$result,
										'Partner_name'=>$this->input->post('cname'),
										'Partner_address'=>$this->input->post('caddress'),
										'Country_id'=>$this->input->post('country'),
										'State'=>$this->input->post('state'),
										'City'=>$this->input->post('city'),
										'Partner_contact_person_name'=>$this->input->post('primarycnt'),
										'Partner_contact_person_phno'=>$this->input->post('primaryphoneno'),
										'Partner_contact_person_email'=>$this->input->post('Company_contactus_email_id'),
										'Partner_vat'=>0,
										'Partner_markup_percentage'=>0,
										'Active_flag'=>1);
										
					$partner_result = $this->Catelogue_model->Insert_Merchandize_Partner($Post_partner_data);
					
					$Post_branch_data=array(
									'Company_id'=>$result,
									'Partner_id'=>$partner_result,
									'Branch_code'=>$result.'_'.$partner_result,
									'Branch_name'=>$this->input->post('cname'),
									'Address'=>$this->input->post('caddress'),
									'Country_id'=>$this->input->post('country'),
									'State'=>$this->input->post('state'),
									'City'=>$this->input->post('city'),
									// 'Zip'=>$this->input->post('zip'),
									// 'Latitude'=>$this->input->post('Latitude'),
									// 'Longitude'=>$this->input->post('Longitude'),
									// 'Create_User_id'=>$this->input->post('Create_user_id'),
									// 'Creation_date'=>$this->input->post('Create_date'),
									'Active_flag'=>1);
					
					$result = $this->Catelogue_model->Insert_Merchandize_Partner_Branch($Post_branch_data);
					
					$this->session->set_flashdata("success_code","Company Created Successfully!!");
					
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Company";
						$where="Company Master";
						$toname="";
						$To_enrollid =0;
						$firstName = $this->input->post('cname');
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('cname');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Company Enrollment!!");
				}
				
				redirect(current_url());
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	function edit_company()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Create_user_id = $data['enroll'];
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$enroll_country_id = $enroll_details->Country;
			$currency_details = $this->Igain_model->Get_Country_master($enroll_country_id);
            $data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Company/create_company";
			$total_row = $this->Company_model->company_active_count();
			//echo "total_row ".$total_row;
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
			$data['License_type'] = $this->Company_model->Get_Code_decode_master(20);
			if($data['userId']=='3' && $session_data['Company_id'] =='1')
			{		
				$data["results"] = $this->Company_model->company_active_list($config["per_page"], $page);	
			}
			else
			{
				$Activated=1;
				$data["results"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id);	
			}
		
			/*-----------------------Pagination2---------------------*/			
			$config2 = array();
			$config2["base_url"] = base_url() . "/index.php/Company/create_company";
			$total_row2 = $this->Company_model->company_inactive_count();
			//echo "total_row2  ".$total_row2;
			$config2["total_rows"] = $total_row2;
			$config2["per_page"] = 10;
			$config2["uri_segment"] = 3;        
			$config2['next_link'] = 'Next';
			$config2['prev_link'] = 'Previous';
			$config2['full_tag_open'] = '<ul class="pagination">';
			$config2['full_tag_close'] = '</ul>';
			$config2['first_link'] = 'First';
			$config2['last_link'] = 'Last';
			$config2['first_tag_open'] = '<li>';
			$config2['first_tag_close'] = '</li>';
			$config2['prev_link'] = '&laquo';
			$config2['prev_tag_open'] = '<li class="prev">';
			$config2['prev_tag_close'] = '</li>';
			$config2['next_link'] = '&raquo';
			$config2['next_tag_open'] = '<li>';
			$config2['next_tag_close'] = '</li>';
			$config2['last_tag_open'] = '<li>';
			$config2['last_tag_close'] = '</li>';
			$config2['cur_tag_open'] = '<li class="active"><a href="#">';
			$config2['cur_tag_close'] = '</a></li>';
			$config2['num_tag_open'] = '<li>';
			$config2['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config2);
			$page2 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
  
			//print_r($data["pagination"]);die;
				
			$data["pagination2"] = $this->pagination->create_links();			
			/*-----------------------Pagination2---------------------*/
			
			if($data['userId']=='3' && $session_data['Company_id'] =='1')
			{		
				$data["results2"] = $this->Company_model->company_inactive_list($config2["per_page"], $page2);	
			}
			else
			{
				$Activated=0;
				$data["results2"] = "";
				//$data["results2"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id,$Activated);	
			}
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			/**************************Nilesh 04-10-2017****************************/
			$data["beneficiary_company"] = $this->Company_model->beneficiary_company_list();
			/**************************Nilesh 04-10-2017****************************/

			if($_GET['Company_id'])
			{
				$Company_id =  $_GET['Company_id'];		
			
			/**************************Nilesh 04-10-2017****************************/
				$data["company_beneficiary"] = $this->Company_model->company_beneficiary_list($_GET['Company_id']);	
			/**************************Nilesh 04-10-2017****************************/
				$data['record'] = $this->Company_model->edit_company($Company_id);
				$data['States_array'] = $this->Igain_model->Get_states($data['record']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['record']->State);	
				$this->load->view('company/edit_company', $data);
			}
			else
			{
				redirect('Login', 'refresh');
			}	
		}
	}
	public function inactive_company()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id'] = $session_data['Company_id'];
		$Company_id = $session_data['Company_id'];
		$Create_user_id = $data['enroll'];
		$data['LogginUserName'] = $session_data['Full_name'];
		
		if($this->session->userdata('logged_in'))
		{
			$Company_id =  $_GET['Company_id'];
			
				$post_data = array(					
					'Activated' => 0);
				$result = $this->Company_model->inactive_company($post_data,$Company_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Company In-Activated Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$get_company_detail = $this->Igain_model->get_company_details($Company_id);
					$Company_name=$get_company_detail->Company_name;
					// $Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="In-Activate Company";
					$where="Company Master";
					$toname="";
					$To_enrollid =0;
					$firstName = $Company_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Company_name;
					$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error In-Activated Company!!");
				}
			
			redirect("Company/create_company");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Active_company()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id'] = $session_data['Company_id'];
		$Company_id = $session_data['Company_id'];
		$Create_user_id = $data['enroll'];
		$data['LogginUserName'] = $session_data['Full_name'];
		if($this->session->userdata('logged_in'))
		{
			$Company_id =  $_GET['Company_id'];
			
				$post_data = array(					
					'Activated' => 1);
				$result = $this->Company_model->inactive_company($post_data,$Company_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Company Activated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
					$get_company_detail = $this->Igain_model->get_company_details($Company_id);
					$Company_name=$get_company_detail->Company_name;
					// $Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Activate Company";
					$where="Company Master";
					$toname="";
					$To_enrollid =0;
					$firstName = $Company_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Company_name;
					$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Activated Company!!");
				}
			
			redirect("Company/create_company");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function update_company()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Create_user_id = $data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			/* /*-----------------------File Upload---------------------
			$config = array();
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------
			
					if(!$this->upload->do_upload("file"))
					{
						$filepath_logo = $this->input->post('Company_logo2');
						//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					}
					else
					{
						
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath_logo = "uploads/".$data['upload_data']['file_name'];
					}					
					if(!$this->upload->do_upload("white_label"))
					{
						$filepath_white_label = $this->input->post('Localization_logo2');
						
						//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					}
					else
					{
						
						$data = array('upload_data' => $this->upload->data("white_label"));
						$filepath_white_label = "uploads/".$data['upload_data']['file_name'];
					} 
					
				*/
					
				$config['upload_path'] = './uploads/'; /* NB! create this dir! */
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['max_size'] = '1000';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				  /* Load the upload library */
				  $this->load->library('upload', $config);

				  /* Create the config for image library */
				  /* (pretty self-explanatory) */
				  $configThumb = array();
				  $configThumb['image_library'] = 'gd2';
				  $configThumb['source_image'] = '';
				  $configThumb['create_thumb'] = TRUE;
				  $configThumb['maintain_ratio'] = TRUE;
				
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');
					$upload = $this->upload->do_upload('file');
					$data1 = $this->upload->data();
				   
					if($data1['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data1['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$filepath_logo='uploads/'.$data1['file_name'];
					}
					else
					{
						$filepath_logo=$this->input->post('Company_logo2');
					}
				
				// echo"----filepath_logo------".$filepath_logo."---<br>";
				// die;
				 /*****************GET COMPANY DETAILS******************************/
				if($this->input->post('white_labels')==0)
				{
					 $filepath_white_label="";
				}
				else
				{
					/* Create the config for image library */
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');
					$upload = $this->upload->do_upload('white_label');
					$data2 = $this->upload->data();
				   
					if($data2['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data2['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$filepath_white_label='uploads/'.$data2['file_name'];
					}
					else
					{
						$filepath_white_label=$this->input->post('Localization_logo2');
					}	
				}
				 
				 
				$_SESSION['Localization_logo'] =$filepath_white_label;
				$_SESSION['Localization_flag'] =$this->input->post('white_labels');
				$_SESSION['Company_logo'] = $filepath_logo;
				/*****************GET COMPANY DETAILS******************************/
					
			 	if(($Company_id==1) && ($session_data['userId']==3))
				{
					$Partner_company_flag=1;
					$Parent_company=$Company_id;
				}
				else
				{
					$Partner_company_flag=0;
					$Parent_company=$Company_id;
				} 
				$Edit_Company_id =  $this->input->post('Company_id');
				
					/*******Update Billing price points in merchandise table******AMIT 28-07-2017-*/
				$ratio_changed_flag=$this->input->post('ratio_changed_flag');
				$redemptionratio=$this->input->post('redemptionratio');
				if($ratio_changed_flag==1)
				{
					$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Edit_Company_id,1);
					foreach($All_Active_Merchandize_Items_Records as $Val)
					{
						if($Val->Merchant_flag==0)//Link to only Company
						{
							$New_redeem_points=($Val->Billing_price*$redemptionratio);
							$Post_data2 = array
							(
								'Update_user_id'=>$data['enroll'],
								'Update_date'=>date("Y-m-d H:i:s"),
								'Billing_price_in_points'=>$New_redeem_points
							);
							/**************Update Billing price points in merchandise table**********/
							$Update_new_redeem_points = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
						}
					}	
				}
				/*****************AMIT 28-07-2017-- END------------------*/
				/*********************Nilesh start for Beneficiary 04-10-2017*********************/
				$Beneficiary_flag = $this->input->post('Beneficiary_flag');
				
				if($Beneficiary_flag == 1)
				{
					$Beneficiary_company = $this->input->post('Beneficiary_company'); 
						
					$Dresult2 = $this->Company_model->Delete_company_beneficiary($Edit_Company_id);
				
					foreach($Beneficiary_company as $beneficiarycompany)
					{
						$resultis = $this->Company_model->get_beneficiary_company_details($beneficiarycompany);
						$Contact_name = $resultis->Contact_name;
						$Contact_email_id = $resultis->Contact_email_id;
						
						$Post_data=array 
						   (
							'Company_id'=>$Edit_Company_id,
							'Register_beneficiary_id'=>$beneficiarycompany,
							'Contact_name'=>$Contact_name,							
							'Contact_email_id'=>$Contact_email_id	
						   );
						$result1 = $this->Company_model->igain_beneficiary_company($Post_data);
					}
				}
				else
				{
					$Dresult3 = $this->Company_model->Delete_company_beneficiary($Edit_Company_id);
				}
				/***********************Nilesh end Beneficiary 04-10-2017************************/
	
				$result = $this->Company_model->update_company($filepath_logo,$filepath_white_label,$Create_user_id,$Edit_Company_id);
				
				if($result == true || $result1 == true)
				{
					$this->session->set_flashdata("success_code","Company Updated Successfully!!");
					
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Company";
						$where="Company Master";
						$toname="";
						$To_enrollid =0;
						$firstName = $this->input->post('cname');
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('cname');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error in Company Update!!");
				}
				
				if($Edit_Company_id == $data['Company_id'] && $Logged_user_id == 4)
				{
					redirect('Company/edit_company/?Company_id='.$Edit_Company_id.'', 'refresh');
				}
				
				/* else
				{
					$this->session->set_flashdata("error_code","Error in Company Update!!");
				} */
			
			//redirect(current_url());
			
			redirect("Company/create_company");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	/***********************************Nilesh Start 29-09-2017***********************************/
	function Create_beneficiary_company()
	{ 
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId'] = $session_data['userId'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Create_user_id = $data['enroll'];
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			$data['LogginUserName'] = $session_data['Full_name'];
			$get_company_detail = $this->Igain_model->get_company_details($Company_id);
			$Company_name=$get_company_detail->Company_name;
			$data['Company_name']=$Company_name;
			/*-----------------------Pagination---------------------*/			
			$config = array();
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			$Code_decode_type_id=11; // Publishers Category
			$data["Publishers_Category"] = $this->Company_model->Get_Publishers_Category($Code_decode_type_id,$Company_id);
			
			if($data['userId']=='3')
			{
				if($session_data['Company_id'] =='1')
				{		
					$data["results"] = $this->Company_model->beneficiary_company_active_list();	
				}
				else
				{
					$Activated=0;
					$data["results"] = "";					
					/*$Activated=1;
					$data["results"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id);	*/
				}
			}		
			
			if($data['userId']=='3' && $session_data['Company_id'] =='1')
			{		
				$data["results2"] = $this->Company_model->beneficiary_company_inactive_list();	
			}
			else
			{
				$Activated=0;
				$data["results2"] = "";
				//$data["results2"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id,$Activated);	
			}	
			$data["igainresults"] = $this->Company_model->igain_company_active_list();
			if($_POST == NULL)
			{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['enroll'] = $session_data['enroll'];
				$data['Company_id'] = $session_data['Company_id'];
				$data['userId'] = $session_data['userId'];
				$Company_id = $session_data['Company_id'];
				$Create_user_id = $data['enroll'];
				$data['LogginUserName'] = $session_data['Full_name'];
				$FetchCountry = $this->Igain_model->FetchCountry();	
				$data['Country_array'] = $FetchCountry;
			
				$this->load->view('company/Create_beneficiary_company', $data);
			}
			else
			{
				$link_flag = $this->input->post('link_flag');
				if($link_flag == 1)
				{
					$Igain_link_flag = 1;
					$Igain_company_id = $this->input->post('Beneficiary_company');
					$Authentication_url = "";
					$Transaction_url = "";				
					$filepath_logo = $this->input->post('Company_logo1');	
				}
				else
				{
					$Igain_link_flag = 0;
					$Igain_company_id = 0;
					
					/*if ( (! $this->upload->do_upload("file")))
					{			
						$this->session->set_flashdata("data_code",$this->upload->display_errors());
						$filepath_logo = "";
						$filepath_white_label = "";
					}
					else
					{			
						if($this->upload->do_upload("file"))
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$filepath_logo = "uploads/".$data['upload_data']['file_name'];
						}
						else
						{
							$filepath_logo = '';
						}
					}*/
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
			
					if ($this->upload->do_upload('file'))
					{
						$data77 = $this->upload->data();
						$filepath_logo = "uploads/".$data77['file_name'];
					}
					else
					{			  	
						$filepath_logo = "";
					}					
				}
				$today=date('Y-m-d H:i:s');

				$result121 = $this->Company_model->Check_beneficiary_company($this->input->post("bcname"));
				
				if($result121 == '0')
				{
					$Post_data=array
							   (
								'Igain_link_flag'=>$Igain_link_flag,
								'Igain_company_id'=>$Igain_company_id,
								'Authentication_url'=>$Authentication_url,
								'Transaction_url'=>$Transaction_url,
								'Company_logo'=>$filepath_logo,
								'Publishers_category'=>$this->input->post('Publishers_Category'),
								'Beneficiary_company_name'=>$this->input->post('bcname'),
								'Company_username'=>$this->input->post('Company_user_name'),
								'Company_password'=>$this->input->post('Company_password'),
								'Company_encryptionkey'=>$this->input->post('Company_encryptionkey'),
								'Address'=>$this->input->post('bcaddress'),
								'City'=>$this->input->post('city'),
								'State'=>$this->input->post('state'),
								'Country'=>$this->input->post('country'),
								'Contact_name'=>$this->input->post('beneficiarycnt'),
								'Currency'=>$this->input->post('Currency'),
								'Contact_email_id'=>$this->input->post('beneficiaryemailId'),
								'Contact_email_id1'=>$this->input->post('beneficiaryemailId1'),
								'Contact_email_id2'=>$this->input->post('beneficiaryemailId2'),
								'Contact_phone_no'=>$this->input->post('beneficiaryphoneno'),
								'Activate_flag'=>1,
								'Creation_date_time'=>$today,
								'Create_user_id'=>$Create_user_id
							   );
					
					$result = $this->Company_model->insert_beneficiary_company($Post_data);
					if($result == true)
					{
						$this->session->set_flashdata("success_code","Channel Partner Company Created Successfully!!");
						
						/*******************Insert igain Log Table*********************/
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Create Channel Partner Company";
							$where="Register Channel Partner Company";
							$toname="";
							$To_enrollid =$result;
							$firstName = $this->input->post('bcname');
							$lastName = '';
							$Seller_name = $session_data['Full_name'];
							$opval = $this->input->post('bcname');
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
					}
					else
					{
						$this->session->set_flashdata("error_code","Error Channel Partner Company Creation!!");
					}
				}
				else    
				{
					$this->session->set_flashdata("error_code","Channel Partner Company Already Exist!");
				}
				
				redirect(current_url());		
			}	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Check_beneficiary_company ()
	{
		$result = $this->Company_model->Check_beneficiary_company($this->input->post("bcname"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function Check_Authentication_url ()
	{
		$result = $this->Company_model->Check_Authentication_url($this->input->post("Authentication_url"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function Check_Transaction_url ()
	{
		$result = $this->Company_model->Check_Transaction_url($this->input->post("Transaction_url"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function Check_contatct_email ()
	{
		$result = $this->Company_model->Check_contatct_email($this->input->post("beneficiaryemailId"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function Check_contatct_email1 ()
	{
		$result = $this->Company_model->Check_contatct_email1($this->input->post("beneficiaryemailId"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function Check_contatct_email2 ()
	{
		$result = $this->Company_model->Check_contatct_email2($this->input->post("beneficiaryemailId"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	} 
	public function Check_contatct_phoneno ()
	{
		$result = $this->Company_model->Check_contatct_phoneno($this->input->post("beneficiaryphoneno"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	} 
	function edit_beneficiary_company()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Create_user_id = $data['enroll'];
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			$get_company_detail = $this->Igain_model->get_company_details($Company_id);
			$Company_name=$get_company_detail->Company_name;
			$data['Company_name']=$Company_name;
			
		
			
			if($data['userId']=='3' && $session_data['Company_id'] =='1')
			{		
				$data["results"] = $this->Company_model->beneficiary_company_active_list();	
			}
			else
			{
				$Activated=0;
				$data["results"] = "";
				/*$Activated=1;
				$data["results"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id);	*/
			}
		
			
			
			if($data['userId']=='3' && $session_data['Company_id'] =='1')
			{		
				$data["results2"] = $this->Company_model->beneficiary_company_inactive_list();	
			}
			else
			{
				$Activated=0;
				$data["results2"] = "";
				//$data["results2"] = $this->Company_model->selected_company_list($config["per_page"], $page,$Company_id,$Activated);	
			}
			
			if($_GET['Beneficiary_Company_id'])
			{
				$Company_id =  $_GET['Beneficiary_Company_id'];			
				$data['record'] = $this->Company_model->edit_beneficiary_company($Company_id);
				$data['States_array'] = $this->Igain_model->Get_states($data['record']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['record']->State);
				$this->load->view('company/Edit_beneficiary_company', $data);
			}
			else
			{
				redirect('Login', 'refresh');
			}
		}
	}
	public function inactive_beneficiary_company()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id'] = $session_data['Company_id'];
		$Company_id = $session_data['Company_id'];
		$Create_user_id = $data['enroll'];
		$data['LogginUserName'] = $session_data['Full_name'];
		if($this->session->userdata('logged_in'))
		{	
			$Beneficiary_Company_id =  $_GET['Company_id'];
			$company_flag =  $_GET['company_flag'];
			if($company_flag==1)//for inactivate company
			{
				$post_data = array(					
					'Activate_flag' => 0);
				$result = $this->Company_model->inactive_beneficiary_company($post_data,$Beneficiary_Company_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Channel Partner Company In-Activated Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$get_company_detail = $this->Company_model->get_beneficiary_company_details($Beneficiary_Company_id);
					$BCompany_name=$get_company_detail->Beneficiary_company_name;
					// $Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="In-Activate Loyalty Publishers Company";
					$where="Register Loyalty Publishers Company";
					$toname="";
					$To_enrollid =0;
					$firstName = $BCompany_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $BCompany_name;
					$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error In-Activated Channel Partner Company!!");
				}
			}
			else //for activate company
			{
				$post_data = array(					
					'Activate_flag' => 1);
				$result = $this->Company_model->inactive_beneficiary_company($post_data,$Beneficiary_Company_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Channel Partner Company Activated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
					$get_company_detail = $this->Company_model->get_beneficiary_company_details($Beneficiary_Company_id);
					$BCompany_name=$get_company_detail->Beneficiary_company_name;
					// $Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Activate Channel Partner Company";
					$where="Register Channel Partner Company";
					$toname="";
					$To_enrollid =0;
					$firstName = $BCompany_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $BCompany_name;
					$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Activated Channel Partner Company!!");
				}
			}
			redirect("Company/Create_beneficiary_company");	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function update_beneficiary_company()
	{
		if($this->session->userdata('logged_in'))
		{		
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Create_user_id = $data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			
				if ($this->upload->do_upload('file'))
				{
					$data77 = $this->upload->data();
					$filepath_logo = "uploads/".$data77['file_name'];
				}
				else
				{			  	
					$filepath_logo = "";
				}	
			/*-----------------------File Upload---------------------*/
			$Edit_Company_id =  $this->input->post('BCompany_id');
			$Igain_link_flag =  $this->input->post('Igain_link_flag');
			if($Igain_link_flag == 0)
			{
				$Authentication_url = $this->input->post('Authentication_url');
				$Transaction_url = $this->input->post('Transaction_url');
			}
			else
			{
				$Authentication_url = "";
				$Transaction_url = "";
			}
			$today=date('Y-m-d H:i:s');
			
			
			$Post_data=array 
						   (							
							
							'Publishers_category'=>$this->input->post('Publishers_Category'),
							'Beneficiary_company_name'=>$this->input->post('bcname'),
							'Company_logo'=>$filepath_logo,
							'Company_username'=>$this->input->post('Company_user_name'),
							'Company_password'=>$this->input->post('Company_password'),
							'Company_encryptionkey'=>$this->input->post('Company_encryptionkey'),
							'Address'=>$this->input->post('bcaddress'),
							'City'=>$this->input->post('city'),
							'State'=>$this->input->post('state'),
							'Country'=>$this->input->post('country'),
							'Contact_name'=>$this->input->post('beneficiarycnt'),
							'Currency'=>$this->input->post('Currency'),
							'Cron_purchased_miles_flag'=>$this->input->post('Cron_purchased_miles_flag'),
							'Contact_email_id'=>$this->input->post('beneficiaryemailId'),
							'Contact_email_id1'=>$this->input->post('beneficiaryemailId1'),
							'Contact_email_id2'=>$this->input->post('beneficiaryemailId2'),
							'Contact_phone_no'=>$this->input->post('beneficiaryphoneno'),
							'Update_date_time'=>$today,
							'Update_User_id' =>$data['enroll']		
						   );
						   
			$result = $this->Company_model->Update_beneficiary_company($Post_data,$Edit_Company_id);
			if($result == true)
			{
				$this->session->set_flashdata("success_code","Channel Partner Company Updated Successfully!!");
				
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Channel Partner Company";
					$where="Register Channel Partner";
					$toname="";
					$To_enrollid =0;
					$firstName = $this->input->post('bcname');
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('bcname');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error in Channel Partner Company Update!!");
				} 
				
				if($Edit_Company_id == $data['Company_id'] && $Logged_user_id == 4)
				{
					redirect('Company/edit_company/?Company_id='.$Edit_Company_id.'', 'refresh');
				}
			redirect("Company/Create_beneficiary_company");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function get_company()
	{ 
		$Company_id = $this->input->get("Company_id");
	
		$result = $this->Company_model->get_company_details($Company_id); //Get Company details
	
		if($result != NULL)
		{
			$this->output->set_output($result);
		}
		else    
		{
			$Result127[] = array("Error_flag" => 1); // Company Record Not Found
			$this->output->set_output(json_encode($Result127)); 
		}	
	}
	/********************************Nilesh End 04-10-2017*************************************/
	/********************************AMIT START 17-11-2017*************************************/
	function Get_states()
	{	
		$Country_id =  $this->input->post('Country_id');	
		
		$data['State_records'] = $this->Igain_model->Get_states($Country_id);
		$theHTMLResponse = $this->load->view('Show_States', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('States_data'=> $theHTMLResponse)));
	}
	function Get_cities()
	{		
		$State_id =  $this->input->post('State_id');	
		
		$data['City_records'] = $this->Igain_model->Get_cities($State_id);
		$theHTMLResponse = $this->load->view('Show_Cities', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('City_data'=> $theHTMLResponse)));
	}
	/********************************AMIT End 17-11-2017*************************************/
}
?>