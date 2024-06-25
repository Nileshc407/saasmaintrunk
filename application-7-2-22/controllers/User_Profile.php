<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Profile extends CI_Controller 
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
		$this->load->model('Igain_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->library('Send_notification');
	}
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
		$session_data = $this->session->userdata('logged_in');
		$data['LogginUserName'] = $session_data['Full_name'];
		if(isset($_REQUEST["LogginUserName"]))
		{
			$data['LogginUserName'] = $_REQUEST['LogginUserName'];
		}		
		$data['Enrollement_id'] = $session_data['enroll'];
		$data['Company_id'] = $session_data['Company_id'];
		$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
		$Enrollement_id = $data['Enrollement_id'];
		$data['Records'] = $this->Igain_model->get_enrollment_details($Enrollement_id);
		$FetchedCountrys = $this->Igain_model->FetchCountry();	
		$data['Country_array'] = $FetchedCountrys;	
		$data['States_array'] = $this->Igain_model->Get_states($data['Records']->Country_id);	
		$data['City_array'] = $this->Igain_model->Get_cities($data['Records']->State);
		$this->load->view("User_Profile/User_Profile",$data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function check_old_password()
	{
		$oldPAss = App_string_encrypt($this->input->post("old_Password"));
		$result = $this->Igain_model->Check_Old_Password($oldPAss,$this->input->post("Company_id"),$this->input->post("Enrollment_id"));
		//echo "result ".$result;
		if($result == 0)
		{
			$result  = array();
			$result['res']='1';
			$text="<font color='red'>Invalid Password</font>";
			$this->output->set_output($text);
			
			
		}
		else    
		{
			$result  = array();
			$result['res']='0';
			$text="<font  color='green'>Valid Password</font>";
			$this->output->set_output($text);
			//$this->output->set_output("Valid Password");
		}
			
	}
	public function check_old_pin()
	{
		
		$result = $this->Igain_model->check_old_pin($this->input->post("old_Pin"),$this->input->post("Company_id"),$this->input->post("Enrollment_id"));
		//echo "result ".$result;
		if($result == 0)
		{
			$result  = array();
			$result['res']='1';
			$text="<font color='red'>Invalid Pin</font>";
			$this->output->set_output($text);
			
			
		}
		else    
		{
			$result  = array();
			$result['res']='0';
			$text="<font  color='green'>Valid Pin</font>";
			$this->output->set_output($text);
			//$this->output->set_output("Valid Password");
		}
			
	}	
	public function change_password()
	{
		//echo "--".$this->input->post('old_Password')."---";
		$old_Password=App_string_encrypt($this->input->post('old_Password'));
		//echo "--".$old_Password."---";die;
		$Company_id=$this->input->post('Company_id');
		$Enrollment_id=$this->input->post('Enrollment_id');
	//	echo "--".$this->input->post('new_Password')."---";
		$new_Password=App_string_encrypt($this->input->post('new_Password'));
	//	echo "--".$new_Password."---";
		$result = $this->Igain_model->Change_Old_Password($old_Password,$Company_id,$Enrollment_id,$new_Password);
		//var_dump($result);
		if($result == true)
		{
			$result1  = array();
			$result1['pwd']='1';
			/*********************Nilesh igain Log Table change *************************/
			$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
			$opration = 2;				
			$userid = $Enroll_details->User_id;
			$what="Change Password";
			$where="Profile";
			$opval = preg_replace("/[\S]/", "X", $this->input->post('new_Password'));
			$Todays_date=date("Y-m-d");
			$firstName = $Enroll_details->First_name;
			$lastName = $Enroll_details->Last_name;
			$User_email_id = $Enroll_details->User_email_id;
			$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
			$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/**********************igain Log Table change*************************/	
			
			$this->output->set_output("Password Changed Successfuly");
		}
		else    
		{
			$result1  = array();
			$result1['pwd']='0';
			$this->output->set_output("Password Not Changed");
		}			
	}
	public function change_pin()
	{
		$old_Pin=$this->input->post('old_Pin');
		$Company_id=$this->input->post('Company_id');
		$Enrollment_id=$this->input->post('Enrollment_id');
		$new_Pin=$this->input->post('New_Pin');		
		$result = $this->Igain_model->Change_Old_Pin($old_Pin,$Company_id,$Enrollment_id,$new_Pin);	
		// var_dump($result);
		if($result == true)
		{
			$Email_content = array(
								
								'Notification_type' => 'Change Pin',
								'Template_type' => 'Change_pin',
								'Pin_No' => $new_Pin
							);
			$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'0',$Company_id);
			// die;
			$result1  = array();
			$result1['pin']='1';
			
			/*********************Nilesh igain Log Table change *************************/
				$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$opration = 2;				
				$userid = $Enroll_details->User_id;
				$what="Change Pin";
				$where="Profile";
				$opval = preg_replace("/[\S]/", "X", $this->input->post('New_Pin')); 
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details->First_name;
				$lastName = $Enroll_details->Last_name;
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/**********************igain Log Table change *************************/
			$this->output->set_output("Pin Changed Successfuly");
		}
		else    
		{
			$result1  = array();
			$result1['pin']='0';
			$this->output->set_output("Pin Not Changed");
		}			
	}
	public function Update_Profile()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			//$data['LogginUserName'] = $session_data['Full_name'];
			$data['Enrollement_id'] = $session_data['enroll'];
			
			$post_data['First_name'] = $this->input->post('First_name');
			// $post_data['Middle_name'] = $this->input->post('Middle_name');
			$post_data['Company_id'] = $session_data['Company_id'];
			// $post_data['Middle_name'] = $this->input->post('Middle_name');
			$post_data['Last_name'] = $this->input->post('Last_name');
			$post_data['Current_address'] = App_string_encrypt($this->input->post('Current_address'));
			$post_data['Country_id'] = $this->input->post('country');
			$post_data['Country'] = $this->input->post('country');
			$post_data['State'] = $this->input->post('state');
			$post_data['City'] = $this->input->post('city');
			$post_data['Phone_no'] = App_string_encrypt($this->input->post('Phone_no'));
			$post_data['Qualification'] = $this->input->post('Qualification');
			// $post_data['User_email_id'] = $this->input->post('User_email_id');
			
			//$post_data['User_pwd'] = $this->input->post('User_pwd');
			
			/*-----------------------File Upload--------------------*/
			$config = array();
			$config["base_url"] = base_url() . "/index.php/User_Profile/User_Profile";
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			$filepath = $this->input->post('file_exist');
			
		//	die;
			/* if (! $this->upload->do_upload("file") && $_FILES["file"]["name"]!="")
			{			
				$this->session->set_flashdata("error_code_UP",$this->upload->display_errors());
				$filepath = $this->input->post('file_exist');
			}
			else
			{
				if($_FILES["file"]["name"]!="")
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "uploads/".$data['upload_data']['file_name'];
				}
				
			} */	
			
			
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
							$filepath='uploads/'.$data22['file_name'];
							
							$post_data['Photograph'] = $filepath; 
						}
						else
						{
							//$filepath = "images/No_Profile_Image.jpg";
						}

			
			$Enrollement_id = $session_data['enroll'];
			$result222 = $this->Enroll_model->update_enrollment($post_data,$Enrollement_id);
			if($result222 == true)
			{
				/*********************Nilesh igain Log Table change*************************/
				$Company_id= $session_data['Company_id'];
				$Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
				$opration = 2;				
				$userid = $Enroll_details->User_id;
				$what="Update Profile";
				$where="Profile";
				$opval = 'Update Profile';
				$Todays_date=date("Y-m-d");
				$firstName = $this->input->post('First_name');
				$lastName = $this->input->post('Last_name');
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollement_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollement_id);
				/**********************igain Log Table change*************************/
				$this->session->set_flashdata("success_code","User Profile Updated Successfuly!!");
			}
			$data['LogginUserName']=$post_data['First_name']." ".$post_data['Middle_name']." ".$post_data['Last_name'];
			$_SESSION['Photograph'] =$filepath;
			$data['Records'] = $this->Igain_model->get_enrollment_details($Enrollement_id);
			$url= base_url()."index.php/User_Profile?LogginUserName=".$data['LogginUserName'];

			 redirect($url);
			//$this->load->view("User_Profile/User_Profile",$data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function send_pin()
	{
		$Company_id=$this->input->post('Company_id');
		$Enrollment_id=$this->input->post('Enrollment_id');
		$get_pin = $this->Igain_model->get_customer_pin($Company_id,$Enrollment_id);
		var_dump($get_pin->pinno);
		if($get_pin->pinno != "" && $get_pin->pinno != 0 )
		{
			$SuperSeller=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			// echo $SuperSeller->pinno;
			$Email_content = array(
				'Pin_No' => $get_pin->pinno,
				'Notification_type' => 'Send Pin',
				'Template_type' => 'Send_pin'
				);			
			$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id); 	
			
			/*********************Nilesh igain Log Table change 27-06-207*************************/
				$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$opration = 1;				
				$userid = $Enroll_details->User_id;
				$what="Resend Pin";
				$where="Profile";
				$opval = $get_pin->pinno;
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details->First_name;
				$lastName = $Enroll_details->Last_name;
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/**********************igain Log Table change 27-06-2017 *************************/
			
			echo 1;
		}
		else    
		{
			echo 0;
		}			
	}	
}
?>

