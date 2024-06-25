<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Email_templateC extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Email_templateM/Email_templateModel');
		$this->load->library('form_validation');	
		$this->load->library('Send_notification');
		$this->load->helper(array('form', 'url','encryption_val'));	
		$this->load->library('image_lib');
	}

	public function index()
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
			
			if($_POST == NULL)
			{
				
				
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["Template_type"] = $this->Email_templateModel->get_template_type();
				$data["Template_Records"] = $this->Email_templateModel->get_Company_emailtemplate_master($session_data['Company_id']);
				
					$Code_decode_type_id=22;//Template_variables
					$data["Template_variables"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
					$Code_decode_type_id=8;//Font_family
					$data["Font_family"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
				$this->load->view('Email_templatesV/Email_templatesV', $data);
			}
			else
			{
				$Body_image='';
				$Email_header_image='';
				
				if($_REQUEST['Email_font_color']!=''){$Email_font_color=$_REQUEST['Email_font_color'];}else{$Email_font_color=$_REQUEST['Email_font_colorPallet'];}
				
				if($_REQUEST['Email_background_color']!=''){$Email_background_color=$_REQUEST['Email_background_color'];}else{$Email_background_color=$_REQUEST['Email_background_colorpallet'];}
				
				if($_REQUEST['Header_background_color']!=''){$Header_background_color=$_REQUEST['Header_background_color'];}else{$Header_background_color=$_REQUEST['Header_background_colorpallet'];}
				
				
				
				if($_REQUEST['Email_Contents_background_color']!=''){$Email_Contents_background_color=$_REQUEST['Email_Contents_background_color'];}else{$Email_Contents_background_color=$_REQUEST['Email_background_colorpallet6'];}
				
				if($_REQUEST['Footer_background_color']!=''){$Footer_background_color=$_REQUEST['Footer_background_color'];}else{$Footer_background_color=$_REQUEST['Footer_background_colorpallet'];}
				
				if($_REQUEST['Footer_font_color']!=''){$Footer_font_color=$_REQUEST['Footer_font_color'];}else{$Footer_font_color=$_REQUEST['Footer_font_colorPallet'];}
				// die;
				if($_REQUEST['HeaderImage_flg']== 1){
				/*-----------------------File Upload---------------------*/
					
					$config = array();
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '2000';
					$config['max_width'] = '2000';
					$config['max_height'] = '2000';
					$this->load->library('upload', $config);
					
					$this->upload->initialize($config);
					
					$upload22 = $this->upload->do_upload('Email_header_image');
					$data22 = $this->upload->data();			   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload22;
						$this->image_lib->initialize($configThumb);
						// $this->image_lib->resize();
						$Email_header_image=base_url().''.'uploads/'.$data22['file_name'];
					}
					else
					{
						$Email_header_image=base_url().''.'images/no_image.jpeg';
					}
				}	
				if($_REQUEST['bodyimg_flg']== 1){
					//------------------------------------------------------------
					$config2 = array();
					$config2['upload_path'] = './uploads/';
					$config2['allowed_types'] = 'gif|jpg|jpeg|png';
					$config2['max_size'] = '2000';
					$config2['max_width'] = '2000';
					$config2['max_height'] = '2000';
					$this->load->library('upload', $config2);
					
					$this->upload->initialize($config2);
					
					$upload221 = $this->upload->do_upload('Body_image');
					$data221 = $this->upload->data();			   
					if($data221['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data221['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload221;
						$this->image_lib->initialize($configThumb);
						// $this->image_lib->resize();
						$Body_image= base_url().''.'uploads/'.$data221['file_name'];
						$Email_background_color='';
					}
					else
					{
						$Body_image= base_url().''.'images/no_image.jpeg';
					}
				}
					/*--------------------------------------------------------------------------*/
					if($_REQUEST['Twitter_share_flag']){$Twitter_share_flag=1;}else{$Twitter_share_flag=0;}
					if($_REQUEST['Facebook_share_flag']){$Facebook_share_flag=1;}else{$Facebook_share_flag=0;}
					if($_REQUEST['Google_share_flag']){$Google_share_flag=1;}else{$Google_share_flag=0;}
					if($_REQUEST['Google_play_link']){$Google_play_link=1;}else{$Google_play_link=0;}
					if($_REQUEST['Ios_application_link']){$Ios_application_link=1;}else{$Ios_application_link=0;}
				$Post_data32=array(
							'Company_id'=>$Company_id,
							'Template_type_id'=>$_REQUEST['Template_type_id'],
							'Email_template_id'=>$_REQUEST['Email_template_id'],
							'Template_description'=>$_REQUEST['Template_description'],
							'Email_Type'=>$_REQUEST['Email_template_id'],
							'Email_header'=>$_REQUEST['Email_header'],
							'Email_header_image'=>$Email_header_image,
							'Email_subject'=>$_REQUEST['Email_subject'],
							'Email_body'=>$_REQUEST['Email_body'],
							'Body_image'=>$Body_image,
							'Email_font_size'=>$_REQUEST['Email_font_size'],
							'Body_structure'=>$_REQUEST['Body_structure'],
							'Font_family'=>$_REQUEST['Font_family'],
							'Email_font_color'=>$Email_font_color,
							'Email_background_color'=>$Email_background_color,
							'Email_Contents_background_color'=>$Email_Contents_background_color,
							'Header_background_color'=>$Header_background_color,
							'Footer_background_color'=>$Footer_background_color,
							'Footer_font_color'=>$Footer_font_color,
							'Footer_notes'=>$_REQUEST['Footer_notes'],
							'Unsubscribe_flg'=>$_REQUEST['Unsubscribe_flg'],
							'Google_play_link'=>$Google_play_link,
							'Ios_application_link'=>$Ios_application_link,
							'Status'=>0,
							'Create_user_id'=>$data['enroll'],
							'Create_date'=>date('Y-m-d H:i:s'),
							'Facebook_share_flag'=>$Facebook_share_flag,
							'Twitter_share_flag'=>$Twitter_share_flag,
							'Google_share_flag'=>$Google_share_flag
							);
						$Insert_data = $this->Email_templateModel->Insert_company_emailtemp_master($Post_data32);
						
						//--------------------Insert log tbl----------------
						$session_data = $this->session->userdata('logged_in');
						$Company_id	= $session_data['Company_id'];
						$get_seller_detail = $this->Igain_model->get_enrollment_details($session_data['enroll']);
						$Enrollement_id = $get_seller_detail->Enrollement_id;	
						$First_name = $get_seller_detail->First_name;	
						$Last_name = $get_seller_detail->Last_name;	
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Insert";
						$where="COMPANY EMAIL TEMPLATE MASTER";
						$To_enrollid =0;
						$firstName = $First_name;
						$lastName = $Last_name;  
						$Seller_name = $session_data['Full_name'];
						$opval = $Insert_data;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
						$this->session->set_flashdata("success_code","Company Email Template Created Successfully!!");
						redirect('Email_templateC/');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function Edit_Company_Email_template()
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
			
			if($_POST == NULL)
			{
				
				$Company_email_template_id = $_REQUEST["Company_email_template_id"];
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["Template_type"] = $this->Email_templateModel->get_template_type();
				$data["Template_Records"] = $this->Email_templateModel->get_Company_emailtemplate_master($session_data['Company_id']);
				$data["Specific_Template_Record"] = $this->Email_templateModel->get_Specific_Company_emailtemplate_master($Company_email_template_id);
				// print_r($data["Specific_Template_Record"]);
					$Code_decode_type_id=22;//Template_variables
					$data["Template_variables"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
					$Code_decode_type_id=8;//Font_family
					$data["Font_family"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
				$this->load->view('Email_templatesV/Edit_Email_templatesV', $data);
			}
			else
			{
				$Company_email_template_id=$_REQUEST['Company_email_template_id'];
				if($_REQUEST['Email_font_color']!=''){$Email_font_color=$_REQUEST['Email_font_color'];}else{$Email_font_color=$_REQUEST['Email_font_colorPallet'];}
				
				if($_REQUEST['Email_background_color']!=''){$Email_background_color=$_REQUEST['Email_background_color'];}else{$Email_background_color=$_REQUEST['Email_background_colorpallet'];}
				
				if($_REQUEST['Header_background_color']!=''){$Header_background_color=$_REQUEST['Header_background_color'];}else{$Header_background_color=$_REQUEST['Header_background_colorpallet'];}
				
				if($_REQUEST['Footer_background_color']!=''){$Footer_background_color=$_REQUEST['Footer_background_color'];}else{$Footer_background_color=$_REQUEST['Footer_background_colorpallet'];}
				
				if($_REQUEST['Email_Contents_background_color']!=''){$Email_Contents_background_color=$_REQUEST['Email_Contents_background_color'];}else{$Email_Contents_background_color=$_REQUEST['Email_background_colorpallet6'];}
				
				if($_REQUEST['Footer_font_color']!=''){$Footer_font_color=$_REQUEST['Footer_font_color'];}else{$Footer_font_color=$_REQUEST['Footer_font_colorPallet'];}
				
				// echo '<br>Email_font_color '.$Email_font_color;
				// echo '<br>Email_background_color '.$Email_background_color;
				// echo '<br>Header_background_color '.$Header_background_color;
				// echo '<br>Footer_background_color '.$Footer_background_color;
				/*-----------------------File Upload---------------------*/
					$Email_header_image='';
					$Body_image='';
					if($_REQUEST['HeaderImage_flg']== 1){
						$config = array();
						$config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = '2000';
						$config['max_width'] = '2000';
						$config['max_height'] = '2000';
						$this->load->library('upload', $config);
						
						$this->upload->initialize($config);
						
						$upload22 = $this->upload->do_upload('Email_header_image');
						$data22 = $this->upload->data();			   
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							// $this->image_lib->resize();
							$Email_header_image=base_url().''.'uploads/'.$data22['file_name'];
						}
						else
						{
							$Email_header_image=$_REQUEST['Email_header_image2'];
						}
					}
					//------------------------------------------------------------
					if($_REQUEST['bodyimg_flg']== 1){
						$config2 = array();
						$config2['upload_path'] = './uploads/';
						$config2['allowed_types'] = 'gif|jpg|jpeg|png';
						$config2['max_size'] = '2000';
						$config2['max_width'] = '2000';
						$config2['max_height'] = '2000';
						$this->load->library('upload', $config2);
						
						$this->upload->initialize($config2);
						
						$upload221 = $this->upload->do_upload('Body_image');
						$data221 = $this->upload->data();			   
						if($data221['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data221['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload221;
							$this->image_lib->initialize($configThumb);
							// $this->image_lib->resize();
							$Body_image=base_url().''.'uploads/'.$data221['file_name'];
							$Email_background_color='';
						}
						else
						{
							$Body_image=$_REQUEST['Body_image2'];
						}
					}
					/*--------------------------------------------------------------------------*/
					if($_REQUEST['Twitter_share_flag']){$Twitter_share_flag=1;}else{$Twitter_share_flag=0;}
					if($_REQUEST['Facebook_share_flag']){$Facebook_share_flag=1;}else{$Facebook_share_flag=0;}
					if($_REQUEST['Google_share_flag']){$Google_share_flag=1;}else{$Google_share_flag=0;}
					if($_REQUEST['Google_play_link']){$Google_play_link=1;}else{$Google_play_link=0;}
					if($_REQUEST['Ios_application_link']){$Ios_application_link=1;}else{$Ios_application_link=0;}
				$Post_data32=array(
							'Template_type_id'=>$_REQUEST['Template_type_id'],
							'Email_template_id'=>$_REQUEST['Email_template_id'],
							'Template_description'=>$_REQUEST['Template_description'],
							'Email_Type'=>$_REQUEST['Email_template_id'],
							'Email_header'=>$_REQUEST['Email_header'],
							'Email_header_image'=>$Email_header_image,
							'Email_subject'=>$_REQUEST['Email_subject'],
							'Email_body'=>$_REQUEST['Email_body'],
							'Body_structure'=>$_REQUEST['Body_structure'],
							'Body_image'=>$Body_image,
							'Email_font_size'=>$_REQUEST['Email_font_size'],
							'Font_family'=>$_REQUEST['Font_family'],
							'Email_font_color'=>$Email_font_color,
							'Email_background_color'=>$Email_background_color,
							'Email_Contents_background_color'=>$Email_Contents_background_color,
							'Header_background_color'=>$Header_background_color,
							'Footer_background_color'=>$Footer_background_color,
							'Footer_font_color'=>$Footer_font_color,
							'Footer_notes'=>$_REQUEST['Footer_notes'],
							'Unsubscribe_flg'=>$_REQUEST['Unsubscribe_flg'],
							'Google_play_link'=>$Google_play_link,
							'Ios_application_link'=>$Ios_application_link,
							'Update_user_id'=>$data['enroll'],
							'Update_date'=>date('Y-m-d H:i:s'),
							'Facebook_share_flag'=>$Facebook_share_flag,
							'Twitter_share_flag'=>$Twitter_share_flag,
							'Google_share_flag'=>$Google_share_flag
							);
						$Update_data = $this->Email_templateModel->Update_company_emailtemp_master($Post_data32,$Company_email_template_id);
						
						//--------------------Insert log tbl----------------
						$session_data = $this->session->userdata('logged_in');
						$Company_id	= $session_data['Company_id'];
						$get_seller_detail = $this->Igain_model->get_enrollment_details($session_data['enroll']);
						$Enrollement_id = $get_seller_detail->Enrollement_id;	
						$First_name = $get_seller_detail->First_name;	
						$Last_name = $get_seller_detail->Last_name;	
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update";
						$where="Edit COMPANY EMAIL TEMPLATE MASTER";
						$To_enrollid =0;
						$firstName = $First_name;
						$lastName = $Last_name;  
						$Seller_name = $session_data['Full_name'];
						$opval = $Company_email_template_id;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
						// die;
						$this->session->set_flashdata("success_code","Company Email Template Saved Successfully!!");
						redirect('Email_templateC/');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
		public function get_templates_by_temptypes()
	{
		$Template_type_id = $this->input->post('Template_type_id');
		
		if($Template_type_id > 0)
		{
			$data['Templates'] = $this->Email_templateModel->get_templates_by_temptypes($Template_type_id);
		
			$opText4 = $this->load->view("Email_templatesV/get_templates_by_temptypes",$data, true);
				
		}
		
		// echo $opText4;
		if($opText4 != null)
		{
			$this->output->set_content_type('text/html');
			$this->output->set_output($opText4);
		}
	}
	public function get_linked_templates()
	{
		$Email_template_id = $this->input->post('Email_template_id');
		
		if($Email_template_id > 0)
		{
			$RefTemplate = $this->Email_templateModel->get_linked_templates($Email_template_id);
		}
		$len = strlen($RefTemplate->Email_Contents_background_color);
		$Email_Contents_background_colorPallet = substr($RefTemplate->Email_Contents_background_color, 1, $len);
		
		$len2 = strlen($RefTemplate->Email_background_color);
		$Email_background_colorpallet = substr($RefTemplate->Email_background_color, 1, $len2);
		
		$len3 = strlen($RefTemplate->Email_font_color);
		$Email_font_colorPallet = substr($RefTemplate->Email_font_color, 1, $len3);
		
		$len4 = strlen($RefTemplate->Footer_font_color);
		$Footer_font_colorPallet = substr($RefTemplate->Footer_font_color, 1, $len4);
		
		$len5 = strlen($RefTemplate->Footer_background_color);
		$Footer_background_colorpallet = substr($RefTemplate->Footer_background_color, 1, $len5);
		
		$len6 = strlen($RefTemplate->Header_background_color);
		$Header_background_colorpallet = substr($RefTemplate->Header_background_color, 1, $len6);
				
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Template_description'=> $RefTemplate->Template_description,'Email_subject'=> $RefTemplate->Email_subject,'Email_header'=> $RefTemplate->Email_header,'Email_header_image'=> $RefTemplate->Email_header_image,'Body_structure'=> $RefTemplate->Body_structure,'Body_image'=> $RefTemplate->Body_image,'Footer_notes'=> $RefTemplate->Footer_notes,'Email_font_color'=> $RefTemplate->Email_font_color,'Email_font_colorPallet'=> $Email_font_colorPallet,'Email_background_color'=> $RefTemplate->Email_background_color,'Email_background_colorpallet'=> $Email_background_colorpallet,'Email_font_size'=> $RefTemplate->Email_font_size,'Font_family'=> $RefTemplate->Font_family,'Email_body'=> $RefTemplate->Email_body,'Email_body'=> $RefTemplate->Email_body,'Header_background_color'=> $RefTemplate->Header_background_color,'Header_background_colorpallet'=> $Header_background_colorpallet,'Footer_background_color'=> $RefTemplate->Footer_background_color,'Footer_background_colorpallet'=> $Footer_background_colorpallet,'Email_Contents_background_color'=> $RefTemplate->Email_Contents_background_color,'Email_Contents_background_colorPallet'=> $Email_Contents_background_colorPallet,'Footer_font_color'=> $RefTemplate->Footer_font_color,'Footer_font_colorPallet'=> $Footer_font_colorPallet)));
		
		
		
	}
	public function Email_template_acivate_deactivate()
	{
		if($this->session->userdata('logged_in'))
		{
			if($_REQUEST == NULL)
			{
				redirect('Email_templateC/', 'refresh');
			}
			else
			{	
				$Company_email_template_id =  $_REQUEST['Company_email_template_id'];
				$Status =  $_REQUEST['Status'];
				$Template_type_id =  $_REQUEST['Template_type_id'];
				$Company_id =  $_REQUEST['Company_id'];
				$result = $this->Email_templateModel->Email_template_acivate_deactivate($Company_email_template_id,$Status,$session_data['enroll'],$Template_type_id,$Company_id);				
				
				if($result == true)
				{
					if($Status==1){$Status_name="InActivate";}else{$Status_name="Activate";}
					$this->session->set_flashdata("communication_error_code","Email Template $Status_name Successfuly!!");
					
					$session_data = $this->session->userdata('logged_in');
					
					$Company_id	= $session_data['Company_id'];
					$get_seller_detail = $this->Igain_model->get_enrollment_details($session_data['enroll']);
					$Enrollement_id = $get_seller_detail->Enrollement_id;	
					$First_name = $get_seller_detail->First_name;	
					$Last_name = $get_seller_detail->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Active / Inactive";
					$where="COMPANY EMAIL TEMPLATE MASTER";
					$To_enrollid =0;
					$firstName = $First_name;
					$lastName = $Last_name;  
					$Seller_name = $session_data['Full_name'];
					$opval = $Status_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
				}
				else
				{
					$this->session->set_flashdata("communication_error_code","Error Activating / Deactivating Email Template !!");
				}
								
				redirect('Email_templateC/');
			}
		}
	}
	


	public function Reference_email_templates()
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
			
			if($_POST == NULL)
			{
				
				
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["Template_type"] = $this->Email_templateModel->get_template_type();
				$data["Template_Records"] = $this->Email_templateModel->get_Reference_emailtemplate_master($session_data['Company_id']);
				
					$Code_decode_type_id=22;//Template_variables
					$data["Template_variables"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
					$Code_decode_type_id=8;//Font_family
					$data["Font_family"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
				$this->load->view('Email_templatesV/Reference_email_templateV', $data);
			}
			else
			{
				$Body_image='';
				$Email_header_image='';
				
				if($_REQUEST['Email_font_color']!=''){$Email_font_color=$_REQUEST['Email_font_color'];}else{$Email_font_color=$_REQUEST['Email_font_colorPallet'];}
				
				if($_REQUEST['Email_background_color']!=''){$Email_background_color=$_REQUEST['Email_background_color'];}else{$Email_background_color=$_REQUEST['Email_background_colorpallet'];}
				
				if($_REQUEST['Header_background_color']!=''){$Header_background_color=$_REQUEST['Header_background_color'];}else{$Header_background_color=$_REQUEST['Header_background_colorpallet'];}
				
				
				
				if($_REQUEST['Email_Contents_background_color']!=''){$Email_Contents_background_color=$_REQUEST['Email_Contents_background_color'];}else{$Email_Contents_background_color=$_REQUEST['Email_background_colorpallet6'];}
				
				if($_REQUEST['Footer_background_color']!=''){$Footer_background_color=$_REQUEST['Footer_background_color'];}else{$Footer_background_color=$_REQUEST['Footer_background_colorpallet'];}
				
				if($_REQUEST['Footer_font_color']!=''){$Footer_font_color=$_REQUEST['Footer_font_color'];}else{$Footer_font_color=$_REQUEST['Footer_font_colorPallet'];}
				// die;
				if($_REQUEST['HeaderImage_flg']== 1){
				/*-----------------------File Upload---------------------*/
					
					$config = array();
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '2000';
					$config['max_width'] = '2000';
					$config['max_height'] = '2000';
					$this->load->library('upload', $config);
					
					$this->upload->initialize($config);
					
					$upload22 = $this->upload->do_upload('Email_header_image');
					$data22 = $this->upload->data();			   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload22;
						$this->image_lib->initialize($configThumb);
						// $this->image_lib->resize();
						$Email_header_image=base_url().''.'uploads/'.$data22['file_name'];
					}
					else
					{
						$Email_header_image=base_url().''.'images/no_image.jpeg';
					}
				}	
				if($_REQUEST['bodyimg_flg']== 1){
					//------------------------------------------------------------
					$config2 = array();
					$config2['upload_path'] = './uploads/';
					$config2['allowed_types'] = 'gif|jpg|jpeg|png';
					$config2['max_size'] = '2000';
					$config2['max_width'] = '2000';
					$config2['max_height'] = '2000';
					$this->load->library('upload', $config2);
					
					$this->upload->initialize($config2);
					
					$upload221 = $this->upload->do_upload('Body_image');
					$data221 = $this->upload->data();			   
					if($data221['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data221['full_path'];
						$configThumb['source_image'] = './uploads/'.$upload221;
						$this->image_lib->initialize($configThumb);
						// $this->image_lib->resize();
						$Body_image= base_url().''.'uploads/'.$data221['file_name'];
						$Email_background_color='';
					}
					else
					{
						$Body_image= base_url().''.'images/no_image.jpeg';
					}
				}
					/*--------------------------------------------------------------------------*/
				$Post_data32=array(
							'Template_type_id'=>$_REQUEST['Template_type_id'],
							'Email_template_name'=>$_REQUEST['Email_template_name'],
							'Template_description'=>$_REQUEST['Template_description'],
							'Email_Type'=>$_REQUEST['Template_type_id'],
							'Email_header'=>$_REQUEST['Email_header'],
							'Email_header_image'=>$Email_header_image,
							'Email_subject'=>$_REQUEST['Email_subject'],
							'Email_body'=>$_REQUEST['Email_body'],
							'Body_image'=>$Body_image,
							'Email_font_size'=>$_REQUEST['Email_font_size'],
							'Body_structure'=>$_REQUEST['Body_structure'],
							'Font_family'=>$_REQUEST['Font_family'],
							'Email_font_color'=>$Email_font_color,
							'Email_background_color'=>$Email_background_color,
							'Email_Contents_background_color'=>$Email_Contents_background_color,
							'Header_background_color'=>$Header_background_color,
							'Footer_background_color'=>$Footer_background_color,
							'Footer_font_color'=>$Footer_font_color,
							'Footer_notes'=>$_REQUEST['Footer_notes'],
							'Status'=>1,
							'Create_user_id'=>$data['enroll'],
							'Create_date'=>date('Y-m-d H:i:s')
							);
						$Insert_data = $this->Email_templateModel->Insert_reference_emailtemp_master($Post_data32);
						
						//--------------------Insert log tbl----------------
						$session_data = $this->session->userdata('logged_in');
						$Company_id	= $session_data['Company_id'];
						$get_seller_detail = $this->Igain_model->get_enrollment_details($session_data['enroll']);
						$Enrollement_id = $get_seller_detail->Enrollement_id;	
						$First_name = $get_seller_detail->First_name;	
						$Last_name = $get_seller_detail->Last_name;	
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Insert";
						$where="Reference EMAIL TEMPLATE MASTER";
						$To_enrollid =0;
						$firstName = $First_name;
						$lastName = $Last_name;  
						$Seller_name = $session_data['Full_name'];
						$opval = $Insert_data;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
						$this->session->set_flashdata("success_code","Reference Email Template Created Successfully!!");
						redirect('Email_templateC/Reference_email_templates');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	

	public function Edit_Reference_Email_template()
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
			
			if($_POST == NULL)
			{
				
				$Email_template_id = $_REQUEST["Email_template_id"];
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data["Template_type"] = $this->Email_templateModel->get_template_type();
				$data["Template_Records"] = $this->Email_templateModel->get_Reference_emailtemplate_master($session_data['Company_id']);
				$data["Specific_Template_Record"] = $this->Email_templateModel->get_Specific_Reference_emailtemplate_master($Email_template_id);
				// print_r($data["Specific_Template_Record"]);
					$Code_decode_type_id=22;//Template_variables
					$data["Template_variables"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
					$Code_decode_type_id=8;//Font_family
					$data["Font_family"] = $this->Email_templateModel->get_code_decode_master($Code_decode_type_id);		
				
				$this->load->view('Email_templatesV/Edit_Reference_Email_templateV', $data);
			}
			else
			{
				$Email_template_id=$_REQUEST['Email_template_id'];
				if($_REQUEST['Email_font_color']!=''){$Email_font_color=$_REQUEST['Email_font_color'];}else{$Email_font_color=$_REQUEST['Email_font_colorPallet'];}
				
				if($_REQUEST['Email_background_color']!=''){$Email_background_color=$_REQUEST['Email_background_color'];}else{$Email_background_color=$_REQUEST['Email_background_colorpallet'];}
				
				if($_REQUEST['Header_background_color']!=''){$Header_background_color=$_REQUEST['Header_background_color'];}else{$Header_background_color=$_REQUEST['Header_background_colorpallet'];}
				
				if($_REQUEST['Footer_background_color']!=''){$Footer_background_color=$_REQUEST['Footer_background_color'];}else{$Footer_background_color=$_REQUEST['Footer_background_colorpallet'];}
				
				if($_REQUEST['Email_Contents_background_color']!=''){$Email_Contents_background_color=$_REQUEST['Email_Contents_background_color'];}else{$Email_Contents_background_color=$_REQUEST['Email_background_colorpallet6'];}
				
				if($_REQUEST['Footer_font_color']!=''){$Footer_font_color=$_REQUEST['Footer_font_color'];}else{$Footer_font_color=$_REQUEST['Footer_font_colorPallet'];}
				
				// echo '<br>Email_font_color '.$Email_font_color;
				// echo '<br>Email_background_color '.$Email_background_color;
				// echo '<br>Header_background_color '.$Header_background_color;
				// echo '<br>Footer_background_color '.$Footer_background_color;
				/*-----------------------File Upload---------------------*/
					$Email_header_image='';
					$Body_image='';
					if($_REQUEST['HeaderImage_flg']== 1){
						$config = array();
						$config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = '2000';
						$config['max_width'] = '2000';
						$config['max_height'] = '2000';
						$this->load->library('upload', $config);
						
						$this->upload->initialize($config);
						
						$upload22 = $this->upload->do_upload('Email_header_image');
						$data22 = $this->upload->data();			   
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							// $this->image_lib->resize();
							$Email_header_image=base_url().''.'uploads/'.$data22['file_name'];
						}
						else
						{
							$Email_header_image=$_REQUEST['Email_header_image2'];
						}
					}
					//------------------------------------------------------------
					if($_REQUEST['bodyimg_flg']== 1){
						$config2 = array();
						$config2['upload_path'] = './uploads/';
						$config2['allowed_types'] = 'gif|jpg|jpeg|png';
						$config2['max_size'] = '2000';
						$config2['max_width'] = '2000';
						$config2['max_height'] = '2000';
						$this->load->library('upload', $config2);
						
						$this->upload->initialize($config2);
						
						$upload221 = $this->upload->do_upload('Body_image');
						$data221 = $this->upload->data();			   
						if($data221['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data221['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload221;
							$this->image_lib->initialize($configThumb);
							// $this->image_lib->resize();
							$Body_image=base_url().''.'uploads/'.$data221['file_name'];
							$Email_background_color='';
						}
						else
						{
							$Body_image=$_REQUEST['Body_image2'];
						}
					}
					/*--------------------------------------------------------------------------*/
				
				$Post_data32=array(
							'Template_type_id'=>$_REQUEST['Template_type_id'],
							'Email_template_name'=>$_REQUEST['Email_template_name'],
							'Template_description'=>$_REQUEST['Template_description'],
							'Email_Type'=>$_REQUEST['Template_type_id'],
							'Email_header'=>$_REQUEST['Email_header'],
							'Email_header_image'=>$Email_header_image,
							'Email_subject'=>$_REQUEST['Email_subject'],
							'Email_body'=>$_REQUEST['Email_body'],
							'Body_structure'=>$_REQUEST['Body_structure'],
							'Body_image'=>$Body_image,
							'Email_font_size'=>$_REQUEST['Email_font_size'],
							'Font_family'=>$_REQUEST['Font_family'],
							'Email_font_color'=>$Email_font_color,
							'Email_background_color'=>$Email_background_color,
							'Email_Contents_background_color'=>$Email_Contents_background_color,
							'Header_background_color'=>$Header_background_color,
							'Footer_background_color'=>$Footer_background_color,
							'Footer_font_color'=>$Footer_font_color,
							'Footer_notes'=>$_REQUEST['Footer_notes'],
							'Update_user_id'=>$data['enroll'],
							'Update_date'=>date('Y-m-d H:i:s')
							);
						$Update_data = $this->Email_templateModel->Update_refernce_emailtemp_master($Post_data32,$Email_template_id);
						
						//--------------------Insert log tbl----------------
						$session_data = $this->session->userdata('logged_in');
						$Company_id	= $session_data['Company_id'];
						$get_seller_detail = $this->Igain_model->get_enrollment_details($session_data['enroll']);
						$Enrollement_id = $get_seller_detail->Enrollement_id;	
						$First_name = $get_seller_detail->First_name;	
						$Last_name = $get_seller_detail->Last_name;	
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update";
						$where="Edit Reference EMAIL TEMPLATE MASTER";
						$To_enrollid =0;
						$firstName = $First_name;
						$lastName = $Last_name;  
						$Seller_name = $session_data['Full_name'];
						$opval = $Email_template_id;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
						// die;
						$this->session->set_flashdata("success_code","Reference Email Template Saved Successfully!!");
						redirect('Email_templateC/Reference_email_templates');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
		
	public function delete_reference_template()
	{
		if($this->session->userdata('logged_in'))
		{
			if($_REQUEST == NULL)
			{
				redirect('Email_templateC/Reference_email_templates', 'refresh');
			}
			else
			{	
				$Email_template_id =  $_REQUEST['Email_template_id'];
			
				$result = $this->Email_templateModel->delete_reference_template($Email_template_id);				
				
				if($result == true)
				{
					
					
					$session_data = $this->session->userdata('logged_in');
					
					$Company_id	= $session_data['Company_id'];
					$get_seller_detail = $this->Igain_model->get_enrollment_details($session_data['enroll']);
					$Enrollement_id = $get_seller_detail->Enrollement_id;	
					$First_name = $get_seller_detail->First_name;	
					$Last_name = $get_seller_detail->Last_name;	
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete";
					$where="Reference EMAIL TEMPLATE MASTER";
					$To_enrollid =0;
					$firstName = $First_name;
					$lastName = $Last_name;  
					$Seller_name = $session_data['Full_name'];
					$opval = $Email_template_id;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
					
					$this->session->set_flashdata("success_code","Reference Email Template Deleted Successfully!!");
				}
				else
				{
					$this->session->set_flashdata("communication_error_code","Error Delete Email Template !!");
				}
								
				redirect('Email_templateC/Reference_email_templates');
			}
		}
	}
	
}
?>

	
