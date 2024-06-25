<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller 
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
		$this->load->model('survey/Survey_model');
		$this->load->library('Send_notification');
		$this->load->library("Excel");
		$this->load->library('m_pdf');
		$this->load->library('image_lib');
		
	}	
/********************************************Ravi Coading Start******************************************/
	function survey_multiple_choices()
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
			
			// $Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			$data['Company_details'] = $this->Igain_model->get_company_details($data['Company_id']); 
			$data['Survey_nps_type'] = $this->Survey_model->get_survey_nps_type($data['Company_id']);
		  
			$enrollID=$data['enroll'];
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Survey/survey_multiple_choices";
			$total_row = $this->Survey_model->survey_multiple_choices_count($data['Company_id']);		
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
			$data["results"] = $this->Survey_model->survey_multiple_choices_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			// var_dump($_POST);
			// echo"<pre>";
			// var_dump($_FILES);
			// die;
			
			if($_POST == NULL)
			{
				$this->load->view('survey/surveymultiplechoices', $data);
			}
			else
			{
				
				if($_POST['option_value']!= "")
				{
					$result1 = $this->Survey_model->insert_survey_multiple_choices($data['Company_id'],$data['enroll']);	
					$last_id=$result1;
					
					$option_value = $_POST['option_value'];
					$nps_value = $_POST['nps_value'];					
					$file1 = $_POST['file1'];
					// echo"---file1---".$file1."<br> ";
					// print_r($this->upload->do_upload('file1'));

					$config['upload_path'] = './SurveyImages/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '500';
					$config['max_width'] = '1920';
					$config['max_height'] = '1280';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					$FileArray = array();
					for($i=0;$i<count($option_value);$i++)
					{						
						$file_no = $i +1;
						$file_name = "file_".$file_no;						
						if ( ! $this->upload->do_upload($file_name))
						{
								$error = array('error' => $this->upload->display_errors());
								$FileArray[] = "SurveyImages/survey.png";
						}
						else
						{
								$data = array('upload_data' => $this->upload->data());
								$filepath='SurveyImages/'.$data['upload_data']['file_name'];
								$FileArray[] = $filepath;
						}
						
						
						
						// $result = $this->Survey_model->insert_multiple_choice_values($last_id,$option_value[$i],$nps_value[$i],$filepath[$i],$data['enroll']);
					}
					// echo"---enroll--11--".$enrollID."--<br>";					
					for($j=0;$j<count($option_value);$j++)
					{
						// echo"---FileArray--11--".$FileArray[$j]."--<br>";	
						$result = $this->Survey_model->insert_multiple_choice_values($last_id,$option_value[$j],$nps_value[$j],$FileArray[$j],$enrollID);
					}
					// die;					
					if($result == true)				
					{
						$this->session->set_flashdata("success_code","Survey Multiple Choice Inserted Successfuly!!");	
						/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Survey Multiple Choice Structure";
						$where="Create / Edit Survey Multiple Choice Structure";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('multiple_choice_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					}
					else
					{					
						$this->session->set_flashdata("error_code","Error Inserting Survey Multiple Choice. Please Provide valid data!!");
					}
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Inserting Survey Multiple Choice. Please Provide Survey Multiple Choice Option Values!!");
				}
				redirect("Survey/survey_multiple_choices");
			}
									
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function check_mul_choice_structure()
	{
		$result = $this->Survey_model->check_mul_choice_structure($this->input->post("choice_name"),$this->input->post("Company_id"));
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}
			
	}	
	public function update_survey_multiple_choices()
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
			
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Survey/survey_multiple_choices";
			$total_row = $this->Survey_model->survey_multiple_choices_count($data['Company_id']);		
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
			$data["results"] = $this->Survey_model->survey_multiple_choices_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_POST == NULL)
			{
				$this->load->view('survey/surveymultiplechoices', $data);
				
			}
			else
			{	
				$Choice_id=$this->input->post('Choice_id');
				$data['MultipleChoice_details']= $this->Survey_model->Get_multiple_choices_details($Choice_id);
				foreach($data['MultipleChoice_details'] as $details)
				{
					$Name_of_option=$details['Name_of_option'];
				}				
				$val_id = $_POST['Value_id']; 
				
				
				
				$config['upload_path'] = './SurveyImages/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				$FileArray = array();
				
				for($i=0;$i<count($val_id);$i++)
				{
					$nps_val = $_POST['nps_value'];						
					$val1= $_POST['Option_values_'.$val_id[$i]]; 
					
					// $result = $this->Survey_model->update_survey_multiple_choices($val_id[$i],$val1,$nps_val[$i],$data['enroll']);	
				
				
					$file_no = $i +1;
					$file_name= 'file_'.$val_id[$i];
					
					$file_name1= $_POST['Option_image_'.$val_id[$i]];
					if ( ! $this->upload->do_upload($file_name))
					{
							$error = array('error' => $this->upload->display_errors());
							// $FileArray[] = "images/no_image.jpeg";
							$FileArray[] =$file_name1;
					}
					else
					{
							$data = array('upload_data' => $this->upload->data());
							$filepath='SurveyImages/'.$data['upload_data']['file_name'];
							$FileArray[] = $filepath;
							
					}
				}
				for($j=0;$j<count($val_id);$j++)
				{		
					
					$nps_val = $_POST['nps_value'];
					$val1= $_POST['Option_values_'.$val_id[$j]]; 
					$result=$this->Survey_model->update_survey_multiple_choices($val_id[$j],$val1,$nps_val[$j],$FileArray[$j],$data['enroll']);
				}				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Survey Multiple Choice Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Survey Multiple Choice Structure";
					$where="Create / Edit Survey Multiple Choice Structure";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Name_of_option;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Survey Multiple Choice. Please Provide valid data!!");
				}				
			}
			// $this->load->view('survey/surveymultiplechoices', $data);
			redirect("Survey/survey_multiple_choices");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function edit_multiple_choice()
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
			
			$data['Company_details']= $this->Igain_model->get_company_details($data['Company_id']);
			// var_dump($Company_details);
			// $Company_details= $this->Igain_model->get_company_details($data['Company_id']);
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Survey/survey_multiple_choices";
			$total_row = $this->Survey_model->survey_multiple_choices_count($data['Company_id']);		
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
			if($_GET['Choice_id'])
			{
				$data["results"] = $this->Survey_model->survey_multiple_choices_list($config["per_page"], $page,$data['Company_id']);
				$data['MultipleChoice_details']= $this->Survey_model->Get_multiple_choices_details($_GET['Choice_id']);
				
			}
			else
			{		
				$data["results"] = $this->Survey_model->survey_multiple_choices_list($config["per_page"], $page,$data['Company_id']);				
			}
			$data['Survey_nps_type'] = $this->Survey_model->get_survey_nps_type($data['Company_id']);			
			$this->load->view('survey/edi_multiple_choice', $data);
						
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function delete_multi_choice()
	{
			$session_data = $this->session->userdata('logged_in');
			$Company_id = $session_data['Company_id'];
			$choiceId =  $_GET['choiceId'];
			// $companyID =  $_GET['companyID'];
			$companyID =  $Company_id;
			
			$data['MultipleChoice_details']= $this->Survey_model->Get_multiple_choices_details($choiceId);
			foreach($data['MultipleChoice_details'] as $details)
			{
				$Name_of_option=$details['Name_of_option'];
			}
			
			
			$result = $this->Survey_model->delete_multi_choice_set($choiceId,$companyID);
			if($result==true)
			{
				$this->session->set_flashdata("success_code","Survey Multiple Choice Structure Deleted Successfully!!");
				
				/*******************Insert igain Log Table*********************/
						
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Survey Multiple Choice Structure";
					$where="Create / Edit Survey Multiple Choice Structure";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Name_of_option;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
			}
			else
			{
				$this->session->set_flashdata("error_code","Survey Multiple Choice Structure not Deleted!!");
			}
			
			redirect("Survey/survey_multiple_choices");
	
	}	
	public function check_survey_structure()
	{
		$result = $this->Survey_model->check_survey_structure_available($this->input->post("survey_name"),$this->input->post("Company_id"));
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
	function surveystructure()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveystructure";
			$total_row = $this->Survey_model->survey_structure_count($data['Company_id']);		
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
			$data["Survey_structure"] = $this->Survey_model->survey_structure_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/survey_structure', $data);
				
			}
			else
			{	
				
				$today=date('Y-m-d H:i:s');
				$from_date=date('Y-m-d',strtotime($this->input->post('Valid_from')));
				$to_date=date('Y-m-d',strtotime($this->input->post('Valid_till')));
				
				$Survey_Reward_Points=$this->input->post('Survey_Reward_Points');
				$Survey_rewarded=$this->input->post('r2');
				
				if($Survey_rewarded!=NULL)
				{
					$Survey_Reward_Points=$Survey_Reward_Points;
				}
				else{
					$Survey_Reward_Points=0;
				}
					
				$Post_data=array
						   (
							'Company_id'=>$this->input->post('Company_id'),
							'Survey_name'=>$this->input->post('survey_name'),
							'Survey_type'=>$this->input->post('Type_of_survey'),
							'No_of_questions'=>$this->input->post('no_of_questions'),
							'No_of_multiple_choice'=>$this->input->post('multiple_choice'),
							'No_of_text_based'=>$this->input->post('text_based'),	
							'Start_date'=>$from_date,
							'End_date'=>$to_date,
							'Reminder_days_after'=>$this->input->post('remind_after_validity'),
							'Reminder_days_before'=>$this->input->post('remind_before_validity'),
							'Status'=>1,
							'Send_flag'=>0,
							'Survey_rewarded'=>$this->input->post('r2'),
							'Survey_reward_points'=>$Survey_Reward_Points,
							'Survey_template'=>$this->input->post('Survey_template'),
							'Active_flag'=>1,
							'Create_date'=>$today
						   );
				$result = $this->Survey_model->insert_survey_structure($Post_data);	
				if($result == true)				
				{
					
					$this->session->set_flashdata("success_code","Survey Structure Inserted Successfuly!!");

					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Survey Structure";
						$where="Create / Edit Survey Structure";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('survey_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/					
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Inserting Survey Structure. Please Provide valid data!!");
				}
				redirect("Survey/surveystructure");				
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	function editsurveystructure()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveystructure";
			$total_row = $this->Survey_model->survey_structure_count($data['Company_id']);		
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
			
			$data["Survey_structure"] = $this->Survey_model->survey_structure_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_GET['Survey_id'])
			{
				$data["Survey_details"] = $this->Survey_model->get_survey_structure_details($data['Company_id'],$_GET['Survey_id']);	
			}			
			$this->load->view('survey/edit_survey_structure', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function update_surveystructure()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveystructure";
			$total_row = $this->Survey_model->survey_structure_count($data['Company_id']);		
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
			$data["Survey_structure"] = $this->Survey_model->survey_structure_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/survey_structure', $data);
				
			}
			else
			{	
				// var_dump($_POST);
				// die;
				$Survey_id=$this->input->post('Survey_id');
				$Company_id=$this->input->post('Company_id');
				$today=date('Y-m-d H:i:s');
				$from_date=date('Y-m-d',strtotime($this->input->post('Valid_from')));
				$to_date=date('Y-m-d',strtotime($this->input->post('Valid_till')));
				
				$Survey_rewarded = $this->input->post('Survey_Reward');
							
					if($Survey_rewarded == 1)
					{
						$Survey_reward_points = $this->input->post('Survey_Reward_Points');
					}
					else
					{
						$Survey_reward_points = 0;
					}
					
				$Post_data=array
						   (							
							'Start_date'=>$from_date,
							'End_date'=>$to_date,
							'Reminder_days_after'=>$this->input->post('remind_after_validity'),
							'Reminder_days_before'=>$this->input->post('remind_before_validity'),
							'Survey_rewarded' =>$Survey_rewarded,
							'Survey_reward_points' =>$Survey_reward_points ,							
							'Survey_template' =>$this->input->post('Survey_template'),							
							'Update_date'=>$today
						   );
				$result = $this->Survey_model->update_survey_structure($Post_data,$Survey_id,$Company_id);	
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","Survey Structure Updated Successfuly!!");

					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Survey Structure";
						$where="Create / Edit Survey Structure";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('survey_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Survey Structure. Please Provide valid data!!");
				}
				redirect("Survey/surveystructure");				
			}			
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function delete_survey_structure()
	{
			$session_data = $this->session->userdata('logged_in');
			$Company_id=$session_data['Company_id'];
			$Survey_id =  $_GET['Survey_id'];
			// $companyID =  $_GET['companyID'];
			$companyID = $Company_id;
			$Survey_details = $this->Survey_model->get_survey_structure_details($companyID,$Survey_id);
			$Survey_name=$Survey_details->Survey_name;
			$result = $this->Survey_model->delete_survey_structure($Survey_id,$companyID);
			if($result==true)
			{
				$this->session->set_flashdata("success_code","Survey Survey Structure Deleted Successfully!!");
				
				/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 3;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Delete Survey Structure";
						$where="Create / Edit Survey Structure";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Survey_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/	
			}
			else
			{
				$this->session->set_flashdata("error_code","Survey Structure not Deleted!!");
			}
			
			redirect("Survey/surveystructure");
	
	}
/**************************************Nilesh Work Start**********************************/
	public function check_survey_nps()
	{
		$result = $this->Survey_model->check_survey_nps_available($this->input->post("npstype_name"),$this->input->post("Company_id"));
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
	function surveynpsmaster()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveynpsmaster";
			$total_row = $this->Survey_model->survey_nps_count($data['Company_id']);		
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
			$data["Survey_NPS"] = $this->Survey_model->survey_nps_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/survey_nps_master', $data); 
			}
			else
			{		
				$today=date('Y-m-d H:i:s');
				$from_date=date('Y-m-d',strtotime($this->input->post('Valid_from')));
				$to_date=date('Y-m-d',strtotime($this->input->post('Valid_till')));
					
				$Post_data=array
						   (
							'NPS_company_id'=>$this->input->post('Company_id'),
							'NPS_type_name'=>$this->input->post('nps_type_name'),
							'NPS_type_description'=>$this->input->post('description'),
							'Active_flag'=>1,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
				$result = $this->Survey_model->insert_survey_nps($Post_data);	
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","Survey NPS Master Inserted Successfuly!!");

					/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Survey NPS Master Setup";
						$where="Survey NPS Master Setup";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $result;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					

				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Inserting Survey NPS Master. Please Provide valid data!!");
				}
				redirect("Survey/surveynpsmaster");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function edit_nps_survey()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveynpsmaster";
			$total_row = $this->Survey_model->survey_nps_count($data['Company_id']);		
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
			
			$data["Survey_NPS_details"] = $this->Survey_model->survey_nps_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_GET['NPS_type_id'])
			{
				$data["Survey_NPS"] = $this->Survey_model->get_survey_nps_details($data['Company_id'],$_GET['NPS_type_id']);	
			}
			$this->load->view('survey/edit_survey_nps_master', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	function update_surveynpsmaster()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveynpsmaster";
			$total_row = $this->Survey_model->survey_nps_count($data['Company_id']);		
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
			$data["Survey_structure"] = $this->Survey_model->survey_nps_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/survey_nps_master', $data);
				
			}
			else
			{	
				// var_dump($_POST);
				// die;
				$NPS_type_id=$this->input->post('NPS_type_id');
				$Company_id=$this->input->post('Company_id');
				$NPS_type_name=$this->input->post('nps_type_name');
				$NPS_type_description=$this->input->post('description');
				$today=date('Y-m-d H:i:s');
					
				$Post_data=array
						   (							
							'NPS_type_name'=>$NPS_type_name,
							'NPS_type_description'=>$NPS_type_description,
							'Update_User_id'=>$data['enroll'],
							'Update_date'=>$today
						   );
				$result = $this->Survey_model->update_survey_nps($Post_data,$NPS_type_id,$Company_id);	
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","Survey Nps Master Updated Successfuly!!");	
					
					/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Survey NPS Master Setup";
						$where="Survey NPS Master Setup";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $NPS_type_id;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Survey Nps Master. Please Provide valid data!!");
				}
				redirect("Survey/surveynpsmaster");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function delete_survey_nps_master()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');	
			$Company_id = $session_data['Company_id'];
		
			$Survey_id =  $_GET['Survey_id'];
			// $companyID =  $_GET['companyID'];
			$companyID =  $Company_id;
			$result = $this->Survey_model->delete_survey_nps($Survey_id,$companyID);
			if($result==true)
			{
				$this->session->set_flashdata("success_code","Survey NPS Master Deleted Successfully!!");
				
				/*******************Insert igain Log Table*********************/
					$session_data = $this->session->userdata('logged_in');
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Survey NPS Master Setup";
					$where="Survey NPS Master Setup";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Survey_id;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
			}
			else
			{
				$this->session->set_flashdata("error_code","Survey NPS Master not Deleted!!");
			}
			
			redirect("Survey/surveynpsmaster");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
/******************************************Nilesh Work End*************************************************/
	function surveyquestion()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveystructure";
			$total_row = $this->Survey_model->survey_structure_count($data['Company_id']);		
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
			
			// $data["SurveyDetails"] = $this->Survey_model->Fatech_survey_details($data['Company_id']);
			$data["CompanySurveyDetails"] = $this->Survey_model->Fatech_survey_details($data['Company_id']);
			$data["SurveyQuestion"] = $this->Survey_model->survey_structure_list($config["per_page"], $page,$data['Company_id']);
			$data["MultipleChoiceSetDetails"] = $this->Survey_model->Survey_MultipleChoiceSet_details($data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/survey_question', $data);
				
			}
			else
			{	
				$today=date('Y-m-d H:i:s');
				$from_date=date('Y-m-d',strtotime($this->input->post('Valid_from')));
				$to_date=date('Y-m-d',strtotime($this->input->post('Valid_till')));
				if($this->input->post('ResponseType')==2)
				{
					$MultipleSelect=0;
				}
				else
				{
					$MultipleSelect=$this->input->post('Multiple_selection');
				}
				if($this->input->post('ResponseType')==2)
				{
					$MultipleSelect=0;
				}
				else
				{
					$MultipleSelect=$this->input->post('Multiple_selection');
				}
				if($this->input->post('ResponseType')==2)
				{
					$ChoiceSet=0;
				}
				else
				{
					$ChoiceSet=$this->input->post('MultipleChoiceSet');
				}
				$Post_data=array
						   (
							'Company_id'=>$this->input->post('Company_id'),
							'Survey_id'=>$this->input->post('Survey_name'),
							'Question'=>$this->input->post('surveyquestion'),
							'Response_type'=>$this->input->post('ResponseType'),
							'Choice_id'=>$ChoiceSet,
							'Multiple_selection'=>$MultipleSelect,
							'Active_flag'=>1,
							'Create_user_id'=>$data['enroll'],
							'Create_date'=>$today
						   );
				$result = $this->Survey_model->insert_survey_questions($Post_data);	
				if($result == true)				
				{
					
					
					/*******************Insert igain Log Table*********************/
						$session_data = $this->session->userdata('logged_in');
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Survey Questions";
						$where="Survey Question Master";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('surveyquestion');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					
					
					$this->session->set_flashdata("success_code","Survey Question Inserted Successfuly!!");	
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Inserting Survey Queston. Please Provide valid data!!");
				}
				redirect("Survey/surveyquestion");				
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}		
	public function get_survey_questions_details()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$CompanyID = $this->input->post("Company_id");
			$Logged_user_enroll = $session_data['enroll'];
			// $Logged_user_id = $session_data['userId'];
			$SurveyID = $this->input->post("SurveyID");
			
			$data['Survey_array'] = $this->Survey_model->Fetch_survey_question_details($SurveyID,$CompanyID);
			$this->load->view('survey/survey_question_details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function get_multiple_choice_set()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$CompanyID = $this->input->post("Company_id");
			$Logged_user_enroll = $session_data['enroll'];
			$choiceID = $this->input->post("choiceID");			
			$data['Multiple_choic_array'] = $this->Survey_model->Fetch_multiple_choice_set_details($choiceID);
			$this->load->view('survey/multiple_choice_set',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function show_remaining_questions()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$CompanyID = $this->input->post("Company_id");
			$Logged_user_enroll = $session_data['enroll'];
			$SurveyID = $this->input->post("SurveyID");			
			$data['RemaingQuestionArray'] = $this->Survey_model->Fetch_remaing_question_details($SurveyID,$CompanyID);
			$this->load->view('survey/show_remaing_question',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function check_survey_question()
	{
		$result12 = $this->Survey_model->check_survey_question_set_or_not($this->input->post("Surveyid"),$this->input->post("Company_id"));
		echo json_encode($result12);
	}
	public function get_phnno_memberid()
	{
		$result = $this->Survey_model->get_phnno_memberid($this->input->post("Cust_name"),$this->input->post("Company_id"));
		
		
		$result[0]["Phone_no"] = App_string_decrypt($result[0]["Phone_no"]);
		
		echo json_encode($result);
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
				$this->Survey_model->get_customer_name($keyword,$Company_id);
			}
		}
	}
	function surveysend()
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
			$config["base_url"] = base_url() . "/index.php/Survey/surveystructure";
			$total_row = $this->Survey_model->survey_structure_count($data['Company_id']);		
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
			
			// $data["SurveyDetails"] = $this->Survey_model->Fatech_survey_details($data['Company_id']);
			$data["CompanySurveyDetails"] = $this->Survey_model->Fatech_survey_details($data['Company_id']);
			$data["SurveyQuestion"] = $this->Survey_model->survey_structure_list($config["per_page"], $page,$data['Company_id']);
			$data["MultipleChoiceSetDetails"] = $this->Survey_model->Survey_MultipleChoiceSet_details($data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			//var_dump($data["SurveyQuestion"]);
			if($_POST == NULL)
			{
				$this->load->view('survey/survey_send', $data);
				
			}
			else
			{	
				$today=date('Y-m-d H:i:s');
				if( $this->input->post("submit") == "Send" )
				{
					$radio1 = $this->input->post("r1");			//****send single or multiple offers.	 
					$radio2 = $this->input->post("r2");			//****send to single or all or key or worry customer.	
					$sellerid = $this->input->post("sellerId");	
					$surveyID = $this->input->post("sellerId");
					$compid = $this->input->post("companyId");
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
							
					if($radio2 < 3) //****single or all customer
					{
						
						if($sendto > 0)   //****single customer
						{
						
							$company_details = $this->Igain_model->get_company_details($compid);
							$enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
							$super_seller = $this->Survey_model->get_super_seller_details($compid);
							$survey_details = $this->Survey_model->get_survey_details($surveyID,$compid);	
							
							// $Survey_name=$survey_details->Start_date;
								$post_data = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $compid,
								'Survey_id' => $surveyID,
								'Create_user_id' => $data['enroll'],
								'Create_date' => date('Y-m-d H:i:s')
								);
								
							$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
							
							if($Insert_survey_details == true)
							{
									$Email_content = array(
									'Survey_name' =>$survey_details->Survey_name,
									'Survey_id' =>$survey_details->Survey_id,
									'Survey_type' =>$survey_details->Survey_type,
									'Start_date' => $survey_details->Start_date,
									'End_date' => $survey_details->End_date,
									'Company_name' => $company_details->Company_name,
									'Template_type' => 'Survey_send',
									// 'Notification_type' => 'Send Survey'
									'Notification_type' => 'Survey From '.$company_details->Company_name
									);								
									$send_notification = $this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$super_seller->Enrollement_id,$compid);
																	
									if($send_notification == true)
									{
										$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
										
										
										/*---------------Insert into iGain Log Table for single member-----------*/
											$Company_id	= $session_data['Company_id'];
											$get_cust_detail = $this->Igain_model->get_enrollment_details($Enrollment_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;	
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											// $userid=$Logged_user_id;
											$what="Send Survey to Customer";
											$where="Send Survey to Customer(s)";
											$toname="";
											// $opval = 4; // transaction type
											$To_enrollid =0;
											$firstName = $First_name;
											$lastName = $Last_name;  
											// $data['LogginUserName'] = $Seller_name;
											$Seller_name = $session_data['Full_name'];
											$opval = $survey_details->Survey_name;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
										/*--------Insert into iGain Log Table for single member-----------*/	
										
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Survey. Please Provide valid data!!");
									}
							}
							else
							{
								$this->session->set_flashdata("error_code","Survey sent already!!");
							}
							
							redirect("Survey/surveysend");	
							
							
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
								if($customer_details->Card_id !='0')
								{
									$company_details = $this->Igain_model->get_company_details($compid);
									$super_seller = $this->Survey_model->get_super_seller_details($compid);
									$survey_details = $this->Survey_model->get_survey_details($surveyID,$compid);								
									$Survey_name=$survey_details->Start_date;
										$post_data = array(
										'Enrollment_id' => $customer_details->Enrollement_id,
										'Company_id' => $compid,
										'Survey_id' => $surveyID,
										'Create_user_id' => $data['enroll'],
										'Create_date' => date('Y-m-d H:i:s')
										);
										
									$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
									if($Insert_survey_details == true)
									{
											$Email_content = array(
											'Survey_name' =>$survey_details->Survey_name,
											'Survey_id' =>$survey_details->Survey_id,
											'Survey_type' =>$survey_details->Survey_type,
											'Start_date' => $survey_details->Start_date,
											'End_date' => $survey_details->End_date,
											'Company_name' => $company_details->Company_name,
											'Template_type' => 'Survey_send',
											'Notification_type' => 'Survey From '.$company_details->Company_name
											);								
											 $send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$super_seller->Enrollement_id,$compid);
											if($send_notification == true)
											{
												$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
												
												/*---------------Insert into iGain Log Table for single member-----------*/
												$Company_id	= $session_data['Company_id'];
												$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
												$Enrollement_id = $get_cust_detail->Enrollement_id;	
												$First_name = $get_cust_detail->First_name;	
												$Last_name = $get_cust_detail->Last_name;	
												$Todays_date = date('Y-m-d');	
												$opration = 1;		
												$enroll	= $session_data['enroll'];
												$username = $session_data['username'];
												$userid=$session_data['userId'];
												// $userid=$Logged_user_id;
												$what="Send Survey to Customer";
												$where="Send Survey to Customer(s)";
												$toname="";
												// $opval = 4; // transaction type
												$To_enrollid =0;
												$firstName = $First_name;
												$lastName = $Last_name;  
												// $data['LogginUserName'] = $Seller_name;
												$Seller_name = $session_data['Full_name'];
												$opval = $survey_details->Survey_name;
												$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
												/*--------Insert into iGain Log Table for single member-----------*/
												
												
												
												
												
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Survey. Please Provide valid data!!");
											}
									}
								
								}
								// redirect("Survey/surveysend");
							}
							// die;
													
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
								$key_worry_customers = $this->Survey_model->get_key_worry_customers($compid,$this->input->post("r2"),$this->input->post("mailtokey"),$sellerid);
								foreach($key_worry_customers as $cust_regid)
								{
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid);
									if($customer_details != NULL)
									{
										$company_details = $this->Igain_model->get_company_details($compid);
										$super_seller = $this->Survey_model->get_super_seller_details($compid);
										$survey_details = $this->Survey_model->get_survey_details($surveyID,$compid);								
										$Survey_name=$survey_details->Start_date;
											$post_data = array(
											'Enrollment_id' => $customer_details->Enrollement_id,
											'Company_id' => $compid,
											'Survey_id' => $surveyID,
											'Create_user_id' => $data['enroll'],
											'Create_date' => date('Y-m-d H:i:s')
											);
											
										$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
										if($Insert_survey_details == true)
										{
												$Email_content = array(
												'Survey_name' =>$survey_details->Survey_name,
												'Survey_id' =>$survey_details->Survey_id,
												'Survey_type' =>$survey_details->Survey_type,
												'Start_date' => $survey_details->Start_date,
												'End_date' => $survey_details->End_date,
												'Company_name' => $company_details->Company_name,
												'Template_type' => 'Survey_send',
												'Notification_type' => 'Send Survey'
												);								
												$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$super_seller->Enrollement_id,$compid);
																				
												if($send_notification == true)
												{
													$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
													/*---------------Insert into iGain Log Table for single member-----------*/
													$Company_id	= $session_data['Company_id'];
													$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
													$Enrollement_id = $get_cust_detail->Enrollement_id;	
													$First_name = $get_cust_detail->First_name;	
													$Last_name = $get_cust_detail->Last_name;	
													$Todays_date = date('Y-m-d');	
	nt_id,
											'Company_id' => $compid,
											'Survey_id' => $surveyID,
											'Create_user_id' => $data['enroll'],
											'Create_date' => date('Y-m-d H:i:s')
											);
											
										$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
										if($Insert_survey_details == true)
										{
												$Email_content = array(
												'Survey_name' =>$survey_details->Survey_name,
												'Survey_id' =>$survey_details->Survey_id,
												'Survey_type' =>$survey_details->Survey_type,
												'Start_date' => $survey_details->Start_date,
												'End_date' => $survey_details->End_date,
												'Company_name' => $company_details->Company_name,
												'Template_type' => 'Survey_send',
												'Notification_type' => 'Send Survey'
												);								
												$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$super_seller->Enrollement_id,$compid);
																				
												if($send_notification == true)
												{
													$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
													/*---------------Insert into iGain Log Table for single member-----------*/
													$Company_id	= $session_data['Company_id'];
													$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
													$Enrollement_id = $get_cust_detail->Enrollement_id;	
													$First_name = $get_cust_detail->First_name;	
													$Last_name = $get_cust_detail->Last_name;	
													$Todays_date = date('Y-m-d');	
													$opration = 1;		
													$enroll	= $session_data['enroll'];
													$username = $session_data['username'];
													$userid=$session_data['userId'];
													// $userid=$Logged_user_id;
													$what="Send Survey to Customer";
													$where="Send Survey to Customer(s)";
													$toname="";
													// $opval = 4; // transaction type
													$To_enrollid =0;
													$firstName = $First_name;
													$lastName = $Last_name;  
													// $data['LogginUserName'] = $Seller_name;
													$Seller_name = $session_data['Full_name'];
													$opval = $survey_details->Survey_name;
													$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
													/*--------Insert into iGain Log Table for single member-----------*/
													
												}
												else
												{							
													$this->session->set_flashdata("error_code","Error Sending Survey. Please Provide valid data!!");
												}
										}
									}
								}
								// redirect(current_url());
							}
							else
							{
							
								$customer_details = $this->Igain_model->get_enrollment_details($cust_id);
								$company_details = $this->Igain_model->get_company_details($compid);
								$super_seller = $this->Survey_model->get_super_seller_details($compid);
								$survey_details = $this->Survey_model->get_survey_details($surveyID,$compid);								
								$Survey_name=$survey_details->Start_date;
									$post_data = array(
									'Enrollment_id' => $customer_details->Enrollement_id,
									'Company_id' => $compid,
									'Survey_id' => $surveyID,
									'Create_user_id' => $data['enroll'],
									'Create_date' => date('Y-m-d H:i:s')
									);
									
								$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
								if($Insert_survey_details == true)
								{
									$Email_content = array(
									'Survey_name' =>$survey_details->Survey_name,
									'Survey_id' =>$survey_details->Survey_id,
									'Survey_type' =>$survey_details->Survey_type,
									'Start_date' => $survey_details->Start_date,
									'End_date' => $survey_details->End_date,
									'Company_name' => $company_details->Company_name,
									'Template_type' => 'Survey_send',
									'Notification_type' => 'Send Survey'
									);								
									$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$super_seller->Enrollement_id,$compid);
																	
									if($send_notification == true)
									{
										$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
										/*---------------Insert into iGain Log Table for single member-----------*/
										$Company_id	= $session_data['Company_id'];
										$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
										$Enrollement_id = $get_cust_detail->Enrollement_id;	
										$First_name = $get_cust_detail->First_name;	
										$Last_name = $get_cust_detail->Last_name;	
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $session_data['enroll'];
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										// $userid=$Logged_user_id;
										$what="Send Survey to Customer";
										$where="Send Survey to Customer(s)";
										$toname="";
										// $opval = 4; // transaction type
										$To_enrollid =0;
										$firstName = $First_name;
										$lastName = $Last_name;  
										// $data['LogginUserName'] = $Seller_name;
										$Seller_name = $session_data['Full_name'];
										$opval = $survey_details->Survey_name;
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
										/*--------Insert into iGain Log Table for single member-----------*/
									}
									else
									{							
										$this->session->set_flashdata("error_code","Error Sending Survey. Please Provide valid data!!");
									}
								}
							}
							
						}
						// redirect(current_url());
					}					
					if($radio2 == 4) //****for worry cust
					{
						$worry_cust=$this->input->post("key_worry_cust");
						$useremail = array(); 
						$i=0;
						
						foreach($this->input->post("key_worry_cust") as $cust_id)
						{
							
							if($cust_id==0)
							{
								$key_worry_customers = $this->Survey_model->get_key_worry_customers($compid,$this->input->post("r2"),$this->input->post("mailtoworry"));
								foreach($key_worry_customers as $cust_regid)
								{
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid);
									if($customer_details != NULL)
									{
										$company_details = $this->Igain_model->get_company_details($compid);
										$super_seller = $this->Survey_model->get_super_seller_details($compid);
										$survey_details = $this->Survey_model->get_survey_details($surveyID,$compid);								
										$Survey_name=$survey_details->Start_date;
											$post_data = array(
											'Enrollment_id' => $customer_details->Enrollement_id,
											'Company_id' => $compid,
											'Survey_id' => $surveyID,
											'Create_user_id' => $data['enroll'],
											'Create_date' => date('Y-m-d H:i:s')
											);
											
										$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
										if($Insert_survey_details == true)
										{
											$Email_content = array(
											'Survey_name' =>$survey_details->Survey_name,
											'Survey_id' =>$survey_details->Survey_id,
											'Survey_type' =>$survey_details->Survey_type,
											'Start_date' => $survey_details->Start_date,
											'End_date' => $survey_details->End_date,
											'Company_name' => $company_details->Company_name,
											'Template_type' => 'Survey_send',
											'Notification_type' => 'Send Survey'
											);								
											$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$super_seller->Enrollement_id,$compid);
																			
											if($send_notification == true)
											{
												$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
												/*---------------Insert into iGain Log Table for single member-----------*/
												$Company_id	= $session_data['Company_id'];
												$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
												$Enrollement_id = $get_cust_detail->Enrollement_id;	
												$First_name = $get_cust_detail->First_name;	
												$Last_name = $get_cust_detail->Last_name;	
												$Todays_date = date('Y-m-d');	
												$opration = 1;		
												$enroll	= $session_data['enroll'];
												$username = $session_data['username'];
												$userid=$session_data['userId'];
												// $userid=$Logged_user_id;
												$what="Send Survey to Customer";
												$where="Send Survey to Customer(s)";
												$toname="";
												// $opval = 4; // transaction type
												$To_enrollid =0;
												$firstName = $First_name;
												$lastName = $Last_name;  
												// $data['LogginUserName'] = $Seller_name;
												$Seller_name = $session_data['Full_name'];
												$opval = $survey_details->Survey_name;
												$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
												/*--------Insert into iGain Log Table for single member-----------*/
											}
											else
											{							
												$this->session->set_flashdata("error_code","Error Sending Survey. Please Provide valid data!!");
											}
										}
									}
								}
							}
							else
							{
								$customer_details = $this->Igain_model->get_enrollment_details($cust_id);							
								
								
								$company_details = $this->Igain_model->get_company_details($compid);
								$super_seller = $this->Survey_model->get_super_seller_details($compid);
								$survey_details = $this->Survey_model->get_survey_details($surveyID,$compid);								
								$Survey_name=$survey_details->Start_date;
									$post_data = array(
									'Enrollment_id' => $customer_details->Enrollement_id,
									'Company_id' => $compid,
									'Survey_id' => $surveyID,
									'Create_user_id' => $data['enroll'],
									'Create_date' => date('Y-m-d H:i:s')
									);
									
								$Insert_survey_details=$this->Survey_model->insert_survey_details($post_data);
								if($Insert_survey_details == true)
								{
										$Email_content = array(
										'Survey_name' =>$survey_details->Survey_name,
										'Survey_id' =>$survey_details->Survey_id,
										'Survey_type' =>$survey_details->Survey_type,
										'Start_date' => $survey_details->Start_date,
										'End_date' => $survey_details->End_date,
										'Company_name' => $company_details->Company_name,
										'Template_type' => 'Survey_send',
										'Notification_type' => 'Send Survey'
										);								
										$send_notification = $this->send_notification->send_Notification_email($customer_details->Enrollement_id,$Email_content,$super_seller->Enrollement_id,$compid);
																		
										if($send_notification == true)
										{
											$this->session->set_flashdata("success_code","Survey Send Successfuly!!");
											/*---------------Insert into iGain Log Table for single member-----------*/
											$Company_id	= $session_data['Company_id'];
											$get_cust_detail = $this->Igain_model->get_enrollment_details($customer_details->Enrollement_id);
											$Enrollement_id = $get_cust_detail->Enrollement_id;	
											$First_name = $get_cust_detail->First_name;	
											$Last_name = $get_cust_detail->Last_name;	
											$Todays_date = date('Y-m-d');	
											$opration = 1;		
											$enroll	= $session_data['enroll'];
											$username = $session_data['username'];
											$userid=$session_data['userId'];
											// $userid=$Logged_user_id;
											$what="Send Survey to Customer";
											$where="Send Survey to Customer(s)";
											$toname="";
											// $opval = 4; // transaction type
											$To_enrollid =0;
											$firstName = $First_name;
											$lastName = $Last_name;  
											// $data['LogginUserName'] = $Seller_name;
											$Seller_name = $session_data['Full_name'];
											$opval = $survey_details->Survey_name;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
											/*--------Insert into iGain Log Table for single member-----------*/
										}
										else
										{							
											$this->session->set_flashdata("error_code","Error Sending Survey. Please Provide valid data!!");
										}
								}
							}
						}
						// redirect(current_url());
					}
				}
				redirect("Survey/surveysend");				
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function get_key_worry_customers()
	{
		$data['key_worry_customers'] = $this->Survey_model->get_key_worry_customers($this->input->post("Company_id"),$this->input->post("r2Value"),$this->input->post("mailtokey"));
		 // var_dump($data);
		 // die;
		$theHTMLResponse = $this->load->view('administration/get_key_worry_customers', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('get_key_worry_customers'=> $theHTMLResponse)));
	}	
	public function fetch_survey_details()
	{
		$data["Show_survey"] = $this->Survey_model->Fetch_survey_details($this->input->post('SurveyID'),$this->input->post('Company_id'));$theHTMLResponse = $this->load->view('survey/show_survey_details', $data, true);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('SurveyDetailHtml'=> $theHTMLResponse)));
	}
	public function fetch_survey_template1()
	{
		$tempid=$this->input->post('tempid');		
		$this->load->view('survey/survey_template1/index');
	}
	public function fetch_survey_template2()
	{
		$tempid=$this->input->post('tempid');
		$this->load->view('survey/survey_template2/index');
		
	}
	public function fetch_survey_template3()
	{
		$tempid=$this->input->post('tempid');
		$this->load->view('survey/survey_template3/index');
		
	}
	public function fetch_survey_customer_analysis()
	{
		$data["Show_customer_analysis"] = $this->Survey_model->fetch_survey_customer_analysis($this->input->post('SurveyID'),$this->input->post('Company_id'),$this->input->post('Enrollement_id'));
		$theHTMLResponse = $this->load->view('survey/show_survey_customer_details', $data, true);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('SurveyDetailHtml'=> $theHTMLResponse)));
	}
	public function surveyanalysis()
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
			$data["SurveyAnalysisDetails"] = $this->Survey_model->survey_analysis($data['Company_id']);
			// var_dump($data["SurveyAnalysisDetails"]);
			$this->load->view('survey/survey_analysis',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
		
	}	
	public function get_survey_analysis_details()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$CompanyID = $this->input->post("Company_id");
			$SurveyID = $this->input->post("SurveyID");			
			$data['Surveyanalysis'] = $this->Survey_model->survey_analysis_details($SurveyID,$CompanyID);
			$this->load->view('survey/survey_analysis_details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function get_survey_summary_details()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$CompanyID = $this->input->post("Company_id");
			$SurveyID = $this->input->post("SurveyID");			
			$data['Surveysummary'] = $this->Survey_model->survey_summary_details($SurveyID,$CompanyID);
			$data['Surveyresponder'] = $this->Survey_model->count_survey_responder($SurveyID,$CompanyID);
			$this->load->view('survey/survey_summary_details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function export_survey_analysis_report()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$Company_id = $session_data['Company_id'];
			$Company_name = $session_data['Company_name'];			
			$Report_type =  $_GET['report_type'];
			$pdf_excel_flag =  $_GET['pdf_excel_flag'];
			$Survey_id =  $_GET['Survey_id'];
			$Company_id =  $_GET['Company_id'];			
			$Today_date = date("Y-m-d");			
			if($pdf_excel_flag == 2)
			{
				$temp_table = $Company_id.'customer_surver_analysis_repot';
			}
			else
			{
				$temp_table = $Company_id.'customer_surver_analysis_repot';
			}			
			
			$Export_file_name = $Today_date."_".$temp_table;
			$data["Report_date"] = $Today_date;
			$data["report_type"] = $Report_type;
			$data["From_date"] = $start_date;
			$data["end_date"] = $end_date;
			$data["Company_name"] = $Company_name;
				
			if($pdf_excel_flag == 1)
			{
				$data["Survey_analysis_rpt"] = $this->Survey_model->get_survey_response_details_xls_rpt($Survey_id,$Company_id);
				$data["Survey_enroll_rpt"] = $this->Survey_model->get_survey_response_enroll_rpt($Survey_id,$Company_id);
				
				/* echo"<pre>";
				print_r($data["Survey_analysis_rpt"]);				
				die; */
				
				$this->excel->getActiveSheet()->setTitle('Survey Analysis Report');
				// $this->excel->stream($Export_file_name.'.xls', $data["Survey_analysis_rpt"]);
				
				$fields=array();				
				
				//Fetching the column names from return array data
				foreach($data["Survey_analysis_rpt"][0] as $key => $field)
				{
					$fields[]=$key;
				}				
				$col = 0;
				foreach ($fields as $field)
				{
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
					$col++;
				} 
				//Fetching the table data
				$row = 2;				
				foreach($data["Survey_analysis_rpt"] as $data1)
				{
					$col = 0;
					foreach ($fields as $field)
					{						
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
						$col++;
					} 
					$row++;
					
				}
				// die;
				ob_end_clean();		
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header("Content-type: application/x-msexcel");
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Content-Type: application/force-download");
					header("Content-Type: application/octet-stream");
					header("Content-Type: application/download");;
					header("Content-Disposition: attachment; filename=".$Export_file_name.".xls "); 
					header("Content-Transfer-Encoding: binary ");						
					$this->excel->setActiveSheetIndex(0);
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');
				ob_end_clean();
				
			}
			else
			{
				$data["Survey_analysis_rpt"] = $this->Survey_model->get_survey_response_details_rpt($Survey_id,$Company_id);
				$data["Survey_enroll_rpt"] = $this->Survey_model->get_survey_response_enroll_rpt($Survey_id,$Company_id);
				$html = $this->load->view('Reports/pdf_survey_report', $data, true);
				$this->m_pdf->pdf->WriteHTML($html);
				$this->m_pdf->pdf->Output($Export_file_name.".pdf", "D");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	public function export_survey_analysis_summary_report()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$Company_id = $session_data['Company_id'];
			$Company_name = $session_data['Company_name'];
			
			$Report_type =  $_GET['report_type'];
			$pdf_excel_flag =  $_GET['pdf_excel_flag'];
			$Survey_id =  $_GET['Survey_id'];
			$Company_id =  $_GET['Company_id'];
			
			$Today_date = date("Y-m-d");
			
			if($pdf_excel_flag == 2)
			{
				$temp_table = $Company_id.'Survey_summary_analysis_rpt';
				$data['Surveysummary'] = $this->Survey_model->survey_summary_details($Survey_id,$Company_id);
				$data['Surveyresponder'] = $this->Survey_model->count_survey_responder($Survey_id,$Company_id);
			}
			else
			{
				$temp_table = $Company_id.'Survey_summary_analysis_rpt';
				$data['Surveysummary'] = $this->Survey_model->survey_summary_details_xls($Survey_id,$Company_id);
				$data['Surveyresponder'] = $this->Survey_model->count_survey_responder($Survey_id,$Company_id);
			}			
			// echo"<pre>";
			// print_r($data["Surveysummary"]);
			$Export_file_name = $Today_date."_".$temp_table;
			$data["Report_date"] = $Today_date;
			$data["report_type"] = $Report_type;
			$data["Company_name"] = $Company_name;
			
			if($pdf_excel_flag == 1)
			{
				$this->excel->getActiveSheet()->setTitle('Survey Summary Analysis Report');
				// $this->excel->stream($Export_file_name.'.xls', $data["Surveysummary"]);
				$fields=array();				
				
				//Fetching the column names from return array data
				foreach($data["Surveysummary"][0] as $key => $field)
				{
					$fields[]=$key;
				}				
				$col = 0;
				foreach ($fields as $field)
				{
					// echo"<pre>";
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
					$col++;
				} 
				//Fetching the table data
				$row = 2;				
				foreach($data["Surveysummary"] as $data1)
				{
					$col = 0;
					foreach ($fields as $field)
					{						
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
						$col++;
					} 
					$row++;
					
				}
				// die;
				ob_end_clean();		
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header("Content-type: application/x-msexcel");
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Content-Type: application/force-download");
					header("Content-Type: application/octet-stream");
					header("Content-Type: application/download");;
					header("Content-Disposition: attachment; filename=".$Export_file_name.".xls "); 
					header("Content-Transfer-Encoding: binary ");						
					$this->excel->setActiveSheetIndex(0);
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');
				ob_end_clean();
			}
			else
			{
				$html = $this->load->view('Reports/pdf_survey_summary_analysis_report', $data, true);
				$this->m_pdf->pdf->WriteHTML($html);
				$this->m_pdf->pdf->Output($Export_file_name.".pdf", "D");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	

	
	/**********************************************Survey End**********************************************/
	
/***********************************************Ravi Code End**********************************************/


/***********************************************Nilesh Code Start**********************************************/

	public function check_nps_master()
	{
	 
		$NPS_dictionay_name=$this->input->post("NPS_dictionay_name");
		$Company_id=$this->input->post("Company_id");
		
		$result = $this->Survey_model->check_nps_master_available($NPS_dictionay_name,$Company_id);
		
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	public function check_nps_type()
	{
	 
		$Npstype=$this->input->post("Npstype");
		$Company_id=$this->input->post("Company_id");		
		$result = $this->Survey_model->check_nps_type_available($Npstype,$Company_id);		
		if($result == '0')
		{
			$this->output->set_output("Available");			
		}
		else    
		{
			$this->output->set_output("Already Exist");
		}		
	}
	
	// function Nps_master()
	function nps_master()
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
			$config["base_url"] = base_url() . "/index.php/Survey/Nps_master";
			$total_row = $this->Survey_model->nps_master($data['Company_id']);		
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
			$data["NPS_Type"] = $this->Survey_model->survey_nps();
			$data["NPS_master"] = $this->Survey_model->nps_master_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/Nps_master', $data); 
			}
			else
			{		
				$today=date('Y-m-d H:i:s');
				$from_date=date('Y-m-d',strtotime($this->input->post('Valid_from')));
				$to_date=date('Y-m-d',strtotime($this->input->post('Valid_till')));					
				$Post_data=array
						   (
							'NPS_Company_id'=>$data['Company_id'],
							'NPS_type_id'=>$this->input->post('Npstype'),
							'NPS_dictionay_name'=>$this->input->post('NPS_dictionay_name'),
							'NPS_dictionary_keywords'=>$this->input->post('NPS_dictionary_keywords'),
							'NPS_dictionary_description'=>$this->input->post('description'),
							'Active_flag'=>1,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
							
						   );
				$result = $this->Survey_model->insert_nps_master($Post_data);	
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","NPS Master Inserted Successfuly!!");	
					
					/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create NPS Master";
						$where="NPS Master";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval =$this->input->post('NPS_dictionay_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					

				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Inserting NPS Master. Please Provide valid data!!");
				}
				redirect("Survey/nps_master");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function edit_nps_master()
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
			$config["base_url"] = base_url() . "/index.php/Survey/Nps_master";
			$total_row = $this->Survey_model->nps_master($data['Company_id']);		
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
			$data["NPS_Type"] = $this->Survey_model->survey_nps();
			$data["NPS_master"] = $this->Survey_model->nps_master_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			if($_GET['NPS_id'])
			{
				$data["NPS_master_details"] = $this->Survey_model->get_nps_master_details($data['Company_id'],$_GET['NPS_id']);	
			}
			$this->load->view('survey/edit_Nps_master', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function update_npsmaster()
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
			$config["base_url"] = base_url() . "/index.php/Survey/Nps_master";
			$total_row = $this->Survey_model->nps_master($data['Company_id']);		
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
			$data["NPS_master"] = $this->Survey_model->nps_master_list($config["per_page"], $page,$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();
			
			
			if($_POST == NULL)
			{
				$this->load->view('survey/Nps_master', $data);
				
			}
			else
			{	
				// var_dump($_POST);
				// die;
				$NPS_id=$this->input->post('NPS_id');
				$Company_id=$this->input->post('Company_id');
				$NPS_type_id=$this->input->post('Npstype');
				$NPS_dictionay_name=$this->input->post('NPS_dictionay_name');
				$NPS_dictionary_keywords=$this->input->post('NPS_dictionary_keywords');
				$description=$this->input->post('description');
				$today=date('Y-m-d H:i:s');
					
				$Post_data=array
						   (							
							'NPS_type_id'=>$NPS_type_id,
							'NPS_dictionay_name'=>$NPS_dictionay_name,
							'NPS_dictionary_keywords'=>$NPS_dictionary_keywords,
							'NPS_dictionary_description'=>$description
							
						   );
				$result = $this->Survey_model->update_nps_master($Post_data,$NPS_id,$Company_id);	
				if($result == true)				
				{
					$this->session->set_flashdata("success_code","Nps Master Updated Successfuly!!");	
					
					/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update NPS Master";
						$where="NPS Master";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('NPS_dictionay_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{					
					$this->session->set_flashdata("error_code","Error Updating Nps Master. Please Provide valid data!!");
				}
				redirect("Survey/Nps_master");				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function delete_nps_master()
	{	
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');	
			$Company_id = $session_data['Company_id'];
			$NPS_id =  $_GET['NPS_id'];
			// $companyID =  $_GET['companyID'];
			$companyID =  $Company_id;
			$NPS_master_details = $this->Survey_model->get_nps_master_details($companyID,$NPS_id);	
			$NPS_dictionay_name=$NPS_master_details->NPS_dictionay_name;
			$result11 = $this->Survey_model->delete_nps_master($NPS_id,$companyID);
			if($result11==true)
			{
				$this->session->set_flashdata("success_code","NPS Master Deleted Successfully!!");
				
				/*******************Insert igain Log Table*********************/
					$session_data = $this->session->userdata('logged_in');	
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete NPS Master";
					$where="NPS Master";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $NPS_dictionay_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
			}
			else
			{
				$this->session->set_flashdata("error_code","NPS Master not Deleted!!");
			}
			
			redirect("Survey/nps_master");
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
/***********************************************Nilesh Code End**********************************************/	
}
?>