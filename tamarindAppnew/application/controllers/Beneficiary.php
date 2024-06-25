<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beneficiary extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->model('Beneficiary/Beneficiary_model');
		$this->load->model('shopping/Shopping_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->library("Excel");
		$this->load->library('m_pdf');
		$this->load->library('Send_notification');
		$this->load->model('General_setting_model');
			
		if($this->session->userdata('cust_logged_in'))
		{			
			$session_data = $this->session->userdata('cust_logged_in');
			$Company_id= $session_data['Company_id'];
		}
			
		//-----------------------Frontend Template Settings------------------//                    
			$General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'General', 'value',$Company_id);
			$this->General_details = json_decode($General_data, true);

			$Small_font = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Small_font', 'value',$Company_id);
			$this->Small_font_details = json_decode($Small_font, true);

			$Medium_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Medium_font', 'value',$Company_id);
			$this->Medium_font_details = json_decode($Medium_font_data, true);

			$Large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Large_font', 'value',$Company_id);
			$this->Large_font_details = json_decode($Large_font_data, true);

			$Extra_large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Extra_large_font', 'value',$Company_id);
			$this->Extra_large_font_details = json_decode($Extra_large_font_data, true);

			$Button_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Button_font', 'value',$Company_id);
			$this->Button_font_details = json_decode($Button_font_data, true);

			$Value_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Value_font', 'value',$Company_id);
			$this->Value_font_details = json_decode($Value_font_data, true);			

			$Footer_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Footer_font', 'value',$Company_id);
			$this->Footer_font_details = json_decode($Footer_font_data, true);

			$Placeholder_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Placeholder_font', 'value',$Company_id);
			$this->Placeholder_font_details = json_decode($Placeholder_font_data, true);
		//-------------------------Frontend Template Settings-------------------------//
	}
    function Load_beneficiary()
	{ 
		if($this->session->userdata('cust_logged_in'))
		{			
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['First_name'] = $session_data['First_name'];			
			$data['Last_name'] = $session_data['Last_name'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['timezone_entry']= $session_data['timezone_entry'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);$Company_id=$session_data['Company_id'];			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			//echo "First_name------------".$data['First_name'].' '.$data['Last_name'];
			// ------------------------------Template----CSS------------------------------------ //
			$data['Small_font_details'] = $this->Small_font_details;
			$data['Medium_font_details'] = $this->Medium_font_details;
			$data['Large_font_details'] = $this->Large_font_details;
			$data['Extra_large_font_details'] = $this->Extra_large_font_details;
			$data['Button_font_details'] = $this->Button_font_details;
			$data['General_details'] = $this->General_details;
			$data['Value_font_details'] = $this->Value_font_details;
			$data['Footer_font_details'] = $this->Footer_font_details;
			$data['Placeholder_font_details'] = $this->Placeholder_font_details;
			$data['icon_src']=$this->General_details[0]['Theme_icon_color'];
			// -----------------------------Template-----CSS------------------------------------ //
			
			$Code_decode_type_id=11; // Publishers Category
			$data["Publishers_Category"] = $this->Beneficiary_model->Get_Publishers_Category($Code_decode_type_id);
			
            $this->load->view('front/transferacross/load_beneficiary', $data);
									 
		}
		else
		{
			redirect('login', 'refresh');
		} 
	}
	function Add_publisher_menu()
	{
		if($this->session->userdata('cust_logged_in'))
		{			
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['First_name'] = $session_data['First_name'];			
			$data['Last_name'] = $session_data['Last_name'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['timezone_entry']= $session_data['timezone_entry'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);	$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);			
			
			//echo "First_name------------".$data['First_name'].' '.$data['Last_name'];
			// ------------------------------Template----CSS------------------------------------ //
			$data['Small_font_details'] = $this->Small_font_details;
			$data['Medium_font_details'] = $this->Medium_font_details;
			$data['Large_font_details'] = $this->Large_font_details;
			$data['Extra_large_font_details'] = $this->Extra_large_font_details;
			$data['Button_font_details'] = $this->Button_font_details;
			$data['General_details'] = $this->General_details;
			$data['Value_font_details'] = $this->Value_font_details;
			$data['Footer_font_details'] = $this->Footer_font_details;
			$data['Placeholder_font_details'] = $this->Placeholder_font_details;
			$data['icon_src']=$this->General_details[0]['Theme_icon_color'];
		// -----------------------------Template-----CSS------------------------------------ //
		
				$this->load->view('front/transferacross/Add_publisher_menu', $data);
									 
		}
		else
		{
			redirect('login', 'refresh');
		} 
	}
	public function Add_Beneficiary_Category() 
	{         
		if($this->session->userdata('cust_logged_in')) 
		{	
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;

			$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
			
			// $data["Get_Beneficiary_members"] = $this->Beneficiary_model->Get_Beneficiary_members($data['Company_id'],$Enrollment_id);
			
			
			$Code_decode_type_id=11; // Publishers Category
			$data["Publishers_Category"] = $this->Beneficiary_model->Get_Publishers_Category($Code_decode_type_id);
			
			// -----------------------Template Configuration-------------------------- //

				$data['Small_font_details'] = $this->Small_font_details;
				$data['Medium_font_details'] = $this->Medium_font_details;
				$data['Large_font_details'] = $this->Large_font_details;
				$data['Extra_large_font_details'] = $this->Extra_large_font_details;
				$data['Button_font_details'] = $this->Button_font_details;
				$data['General_details'] = $this->General_details;
				$data['Value_font_details'] = $this->Value_font_details;
				$data['Footer_font_details'] = $this->Footer_font_details;
				$data['Placeholder_font_details'] = $this->Placeholder_font_details;
				$data['icon_src']=$this->General_details[0]['Theme_icon_color'];

			// ----------------Template Configuration-------------------------------- //

			if($_POST == NULL) 
			{
				$this->load->view('front/transferacross/Add_beneficiary_category', $data);
				$this->session->set_flashdata("success","");
			} 		 
		}
		else
		{
				redirect('login');
		}		
	}
	public function Add_Beneficiary() 
	{         
		if($this->session->userdata('cust_logged_in')) 
		{	
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;

			$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
			
			$Publishers_category=$_REQUEST['Publishers_category'];
			
			$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company_Category($data['Company_id'],$Publishers_category,$Enrollment_id);
			//print_r($data["Get_Beneficiary_Company"]);
			
                        
                       // echo"-----<br> <br> <br>";
			$data["Get_Beneficiary_members_linkage"] = $this->Beneficiary_model->Get_Beneficiary_members_linkage($data['Company_id'],$Enrollment_id,$Publishers_category);
			foreach($data["Get_Beneficiary_members_linkage"] as $Likage)
                        {
                            $Beneficiary_link_company_id[]=$Likage->Register_beneficiary_id;
                            $Self_enroll[]=$Likage->Self_enroll;
                            
                            //echo"---Beneficiary_company_id--".$Beneficiary_company_id."--<br><br><br>";
                        }
                        
                        
                       $data['Beneficiary_link_company_id']=$Beneficiary_link_company_id;
                       $data['Self_enroll_array']=$Self_enroll;
			// -----------------------Template Configuration-------------------------- //

				$data['Small_font_details'] = $this->Small_font_details;
				$data['Medium_font_details'] = $this->Medium_font_details;
				$data['Large_font_details'] = $this->Large_font_details;
				$data['Extra_large_font_details'] = $this->Extra_large_font_details;
				$data['Button_font_details'] = $this->Button_font_details;
				$data['General_details'] = $this->General_details;
				$data['Value_font_details'] = $this->Value_font_details;
				$data['Footer_font_details'] = $this->Footer_font_details;
				$data['Placeholder_font_details'] = $this->Placeholder_font_details;
				$data['icon_src']=$this->General_details[0]['Theme_icon_color'];

			// ----------------Template Configuration-------------------------------- //

			if($_POST == NULL) {
				//$this->load->view('home/Add_Beneficiary', $data);	
				$this->load->view('front/transferacross/Add_beneficiary', $data);
				$this->session->set_flashdata("success","");
			} else {
			   
					// echo"-----Add_Beneficiary---<br><pre>";
					//print_r($_POST);
					
					$flag=0;
					$Igain_company_id=$this->input->post('Igain_company_id');
					$lv_Beneficiary_company_id=$this->input->post('Beneficiary_company_id');
					$lv_Beneficiary_name=$this->input->post('Beneficiary_name');
					$lv_Beneficiary_membership_id=$this->input->post('Beneficiary_membership_id');                         
					$Check_Beneficiary_members_exist = $this->Beneficiary_model->Check_Beneficiary_members_exist($data['Company_id'],$Enrollment_id,$lv_Beneficiary_membership_id,$lv_Beneficiary_company_id);
					// var_dump($Check_Beneficiary_members_exist); die;
					if($Check_Beneficiary_members_exist != 0) {
					   
						$Result = array('Error_flag' => 0, 'Error_message' =>'Member already exist.');
						$post_data['Error_message']='Member already exist.';
						$flag=1;        
						
					} else {
					
				   
					/********************Beneficiary Authentication ****************/            
					/*-----------------------Within iGainSpark Company---------------------*/
						if($Igain_company_id!=0) {  

							$Check_user = $this->Beneficiary_model->Check_beneficiary_customer($lv_Beneficiary_membership_id,$Igain_company_id,$lv_Beneficiary_name);
							if($Check_user == 0) {

								$Check_user_membershipID = $this->Beneficiary_model->Check_beneficiary_customer_membershipid($lv_Beneficiary_membership_id,$Igain_company_id,$lv_Beneficiary_name);
								$Check_user_name = $this->Beneficiary_model->Check_beneficiary_customer_name($lv_Beneficiary_membership_id,$Igain_company_id,$lv_Beneficiary_name);
								if($Check_user_name == 0 && $Check_user_membershipID == 0) {
									$Result = array('Error_flag' => 3, 'Error_message' =>'Member Identifier ID Invalid & Member Name not matched hence Member Not Approved.');
									$post_data['Error_message']='Member Identifier ID & Name Invalid.';
									 $flag=0;
								} else if($Check_user_membershipID == 0) {
									$Result = array('Error_flag' => 1, 'Error_message' =>'Member Identifier ID Invalid hence Member Not Approved.');
									$post_data['Error_message']='Member Identifier ID Invalid.';
									$flag=0;
								} else if($Check_user_name == 0) {
									$Result = array('Error_flag' => 2, 'Error_message' =>'Member Name not matched hence Member Not Approved.');
									$post_data['Error_message']='Member Name Invalid.';
									$flag=0;
								}                                        
								$post_data['Beneficiary_status']=2; //Not Approved

							} else {
								if($flag==0) {
									$post_data['Beneficiary_status']=1; 
									$post_data['Error_message']='Member Added & Approved Successfully.';
									$Result = array('Error_flag' => 4, 'Error_message' =>'Member Added & Approved Successfully.');
									$flag=0;
								} else {
								   $Result = array('Error_flag' => 0, 'Error_message' =>'Member already exist.');
									 $post_data['Error_message']='Member already exist.';
									 $flag=1;
								}   
							}
						} else {  
						/*-------------------Outside iGainSpark Company----------------*/

						   // echo"-----Outside iGainSpark Company---<br>";

								$data['Beneficiary_Company_details'] = $this->Beneficiary_model->Get_Beneficiary_Company_2($lv_Beneficiary_company_id);
								 foreach ($data['Beneficiary_Company_details']  as $key => $value) {
								   $Authentication_url= $value->Authentication_url;
								   $Company_username= $value->Company_username;
								   $Company_password= $value->Company_password;
								   $Company_encryptionkey= $value->Company_encryptionkey;
								   $Beneficiary_company_name= $value->Beneficiary_company_name;
								   $Company_logo= $value->Company_logo;
								   $Company_encryptionkey= $value->Company_encryptionkey;
								 }

								$iv = '56666852251557009888889955123458'; 
								$Company_password=  $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);
								$Beneficiary_name=  $this->string_encrypt($lv_Beneficiary_name, $Company_encryptionkey, $iv);
								$lv_Beneficiary_membership_id=  $this->string_encrypt($lv_Beneficiary_membership_id, $Company_encryptionkey, $iv);
								$API_Flag=  $this->string_encrypt(1, $Company_encryptionkey, $iv);


							$fields=array(
									'Company_username' => $Company_username,
									'Company_password' => $Company_password,
									'Beneficiary_name' => $Beneficiary_name,
									'Beneficiary_membership_id' => $lv_Beneficiary_membership_id,
									'flag' =>$API_Flag
								);
								
							$field_string = $fields;							 
							$ch = curl_init();
							$timeout = 0; // Set 0 for no timeout.
							curl_setopt($ch, CURLOPT_URL, $Authentication_url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string));
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
							$result = curl_exec($ch);
							if(curl_errno($ch))
							{
								print "Error: " . curl_error($ch);
							}
							if (!curl_errno($ch)) {
								
							  $info = curl_getinfo($ch);
							  //echo '----error---- ', $info['total_time'], ' seconds to send a request to ', $info['url'], "--<br>";
							}
							curl_close($ch);							
							$return_result = json_decode($result);							
							// print_r($return_result);							
							if($return_result->status==1001)
							{
								
								$lv_Beneficiary_name=$return_result->status_message->First_name.' '.$return_result->status_message->Last_name;
								$lv_Beneficiary_membership_id=$return_result->status_message->Card_id;
								
								$Check_exist = $this->Beneficiary_model->Check_beneficiary_customer_exist($lv_Beneficiary_membership_id,$Company_id,$lv_Beneficiary_name);
								
								if($Check_exist == 0 ) {
									
									$lv_Beneficiary_name=$return_result->status_message->First_name.' '.$return_result->status_message->Last_name;
									$lv_Beneficiary_membership_id=$return_result->status_message->Card_id;
									$Result = array('Error_flag' =>$return_result->status, 'Error_message' =>'Member Added & Approved Successfully.');
									$flag=0;
									
								} else {
									
									$flag=1;
									$Result = array('Error_flag' =>$return_result->status, 'Error_message' =>'Member record already exist.');
									
								}
								
									
								
							} else {
								
								$flag=1;
								$Result = array('Error_flag' =>$return_result->status, 'Error_message' =>$return_result->status_message);
								
							}
							
						}
					}
					
	
					if($flag==0){
						
						$post_data['Company_id']=$data['Company_id'];
						$post_data['Membership_id']=$Membership_id;
						$post_data['Enrollment_id']=$Enrollment_id;
						$post_data['Beneficiary_company_id']=$lv_Beneficiary_company_id;
						$post_data['Beneficiary_name']=$lv_Beneficiary_name;
						$post_data['Beneficiary_membership_id']=$lv_Beneficiary_membership_id;
						$post_data['Create_date']=date('Y-m-d H:i:s');
						$post_data['Active_flag']=1;
						$post_data['Beneficiary_status']=1;

						$insert_Beneficairy = $this->Beneficiary_model->insert_Beneficairy($post_data);

						/*********************AMIT igain Log Table *************************/
							$Enrollment_id = $Enrollment_id; 
							$User_id = 1; 
							$opration = 1;				
							// $userid = $User_id;
							$what="Add Member";
							$where="Add Member";
							$toname="";
							$toenrollid = 0;
							$opval = $post_data['Beneficiary_name'];
							$Todays_date=date("Y-m-d");
							$firstName = $Enroll_details12->First_name;
							$lastName = $Enroll_details12->Last_name;
							$LogginUserName = $Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
							$result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'],$Enrollment_id,$data['username'],$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Enrollment_id);
						/********************** *************************/
					}   
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode($Result));
				   
			}		 
		}
		else
		{
				redirect('login');
		}		
	}
	public function Add_Beneficiary_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{			
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$data['Company_details'] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$Sms_enabled=$data['Company_details']->Sms_enabled;
			$Available_sms=$data['Company_details']->Available_sms;
			$Sms_api_link=$data['Company_details']->Sms_api_link;
			$Sms_api_auth_key=$data['Company_details']->Sms_api_auth_key;
			
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;
			$Phone_no=$Enroll_details12->Phone_no;

			$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
			// $data["Get_Beneficiary_members"] = $this->Beneficiary_model->Get_Beneficiary_members($data['Company_id'],$Enrollment_id);

			// ----------------------Template Configuration------------------- //
					$data['Small_font_details'] = $this->Small_font_details;
					$data['Medium_font_details'] = $this->Medium_font_details;
					$data['Large_font_details'] = $this->Large_font_details;
					$data['Extra_large_font_details'] = $this->Extra_large_font_details;
					$data['Button_font_details'] = $this->Button_font_details;
					$data['General_details'] = $this->General_details;
					$data['Value_font_details'] = $this->Value_font_details;
					$data['Footer_font_details'] = $this->Footer_font_details;
					$data['Placeholder_font_details'] = $this->Placeholder_font_details;
					$data['icon_src']=$this->General_details[0]['Theme_icon_color'];
			// --------------------Template Configuration------------------ //
			
			 /*---------------------SMS Cnfiguration-------------------------*/      
					if($Sms_enabled ==1 ) {
							 
							$data['Sms_enabled'] =  $Sms_enabled;
							$data['Available_sms'] =  $Available_sms;
							$data['Sms_api_link'] =  $Sms_api_link;
							$data['Sms_api_auth_key'] =  $Sms_api_auth_key;
							$data['Mobile'] ='9561970954';
							$data['Password'] ='@Pihu1988';
							$data['Message'] ='Your Joy Coins LLC OTP is:';
							$data['Password'] ='@Pihu1988';
							$data['To'] =$Phone_no;
						} else {
							$data['Sms_enabled'] =0;
						}
			 /*---------------------SMS Cnfiguration-------------------------*/       
			if($_REQUEST == NULL)
			{
				//$this->load->view('home/Add_Beneficiary', $data);	
				$this->load->view('front/transferacross/Add_beneficiary', $data);	
			}
			else
			{

					$Beneficiary_company_id=$_REQUEST['Beneficiary_company_id'];
					$exp=explode("*",$Beneficiary_company_id);
					$lv_Beneficiary_company_id=$exp[0];
					$Igain_company_id=$exp[1];
					
					$data['lv_Beneficiary_company_id'] = $lv_Beneficiary_company_id;
					$data['Igain_company_id'] = $Igain_company_id;
					
				   if($Igain_company_id == 0) {  
					   
					   // $data['lv_Beneficiary_company_id'] = $lv_Beneficiary_company_id;
						//$data['Igain_company_id'] = $Igain_company_id;

					   // $data['Company_details'] = $this->Igain_model->get_company_details($Igain_company_id);

						$data['Beneficiary_Company_details'] = $this->Beneficiary_model->Get_Beneficiary_Company_2($lv_Beneficiary_company_id);
						 foreach ($data['Beneficiary_Company_details']  as $key => $value) {
						   $Authentication_url= $value->Authentication_url;
						   $Company_username= $value->Company_username;
						   $Company_password= $value->Company_password;
						   $Company_encryptionkey= $value->Company_encryptionkey;
						   $Beneficiary_company_name= $value->Beneficiary_company_name;
						   $Company_logo= $value->Company_logo;
						   $Company_encryptionkey= $value->Company_encryptionkey;
						 }

						 $iv = '56666852251557009888889955123458'; 
														  
						 $data['Authentication_url'] =  $Authentication_url;
						 $data['Company_username'] =  $Company_username;
						 $data['Company_name'] =  $Beneficiary_company_name;
						 $data['Company_logo'] =  $Company_logo;
						
						 
						 
						 $data['Company_password'] =  $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);
						//echo"---sms---".$Sms_enabled."---<br>";
						 
					} else {
						
						$data['lv_Beneficiary_company_id'] = $lv_Beneficiary_company_id;
						$data['Company_details'] = $this->Igain_model->get_company_details($Igain_company_id);
						$data['Company_name'] =  $data['Company_details']->Company_name;
						$data['Company_logo'] =  $data['Company_details']->Company_logo;
						$data['Igain_company_id'] =  $data['Company_details']->Company_id;
					   						
					}

					$this->load->view('front/transferacross/beneficiary_detail', $data);
			}				
		}
		else
		{
				redirect('login');
		}			
	}
	public function Send_otp(){
		
		if($this->session->userdata('cust_logged_in'))
		{			
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;
			$Phone_no=$Enroll_details12->Phone_no;
			$new_otp=0;
			if($_POST != NULL) {				
				
			  /* $Igain_company_id= $_REQUEST['Igain_company_id'];
			   $Beneficiary_company_id= $_REQUEST['Beneficiary_company_id'];
			   $Beneficiary_name= $_REQUEST['Beneficiary_name'];
			   $Beneficiary_membership_id= $_REQUEST['Beneficiary_membership_id']; */
			   
			   $Beneficiary_company_id=$this->input->post('Beneficiary_company_id');
							 
				if($this->input->post('Beneficiary_company_id') != "" && $this->input->post('Beneficiary_name') != "" &&  $this->input->post('Beneficiary_membership_id') != "" ) {
					 
					
					$new_otp=$this->randomString();
				   
						$Post_dat=array(
							'Igain_company_id'=>$this->input->post('Igain_company_id'),
							'Beneficiary_company_id'=>$this->input->post('Beneficiary_company_id'),
							'From_membership_id'=>$Membership_id,
							'Phone_no'=>$Phone_no,
							'Beneficiary_name'=>$this->input->post('Beneficiary_name'),
							'Beneficiary_membership_id'=>$this->input->post('Beneficiary_membership_id'),
							'Varifed'=>0,
							'OPT_code'=>$new_otp,
							'Creation_date_time'=> date('Y-m-d H:i:s'),
							'Update_date_time'=>date('Y-m-d H:i:s')
						);
					   
						$Insert_OTP = $this->Beneficiary_model->Insert_sent_otp($Post_dat);                                
						if($Insert_OTP == true) {                                    
								$mobile=$Phone_no;
								$message=" YOUR JOY COINS LLC OTP: ".$new_otp;
							  
									$json = json_decode(file_get_contents("https://smsapi.engineeringtgr.com/send/?Mobile=9561970954&Password=@Pihu1988&Message=".urlencode($message)."&To=".urlencode($mobile)."&Key=ravipj0kqX3DI58TQ6UdamWO"),true);
								  
									if ($json["status"]=="success") {
									   // echo $json["msg"];
										 echo json_encode(array("status" => "2011", "msg" => "OTP Sent your registered mobile"));
										  
								
										//your code when send success
									} else {
									   // echo $json["msg"];
										echo json_encode(array("status" => "2012", "msg" => "Please check registered mobile"));
										//your code when not send
									}
									
							} else {
								   // echo $json["msg"];
									echo json_encode(array("status" => "2013", "msg" => "Please check registered mobile"));
									//your code when not send
							}
				} else {
					 //"Unable send OTP on registered mobile"
					echo json_encode(array("status" => "2014", "msg" =>var_dump($_POST)));
				}
			} else {
				 echo json_encode(array("status" => "2015", "msg" => "Unable send OTP on registered mobile"));
			}                 
		}
		else
		{
				redirect('login');
		}            
    }
    public function Submit_OPT(){

        if($this->session->userdata('cust_logged_in'))
        {			
            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];			
            $data['enroll'] = $session_data['enroll'];
            $data['userId']= $session_data['userId'];
            $data['Card_id']= $session_data['Card_id'];
            $data['Company_id']= $session_data['Company_id'];

            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
            $Company_id=$Enroll_details12->Company_id;
            $Membership_id=$Enroll_details12->Card_id;
            $Enrollment_id=$Enroll_details12->Enrollement_id;
            $Phone_no=$Enroll_details12->Phone_no;
            $new_otp=0;
            if($_POST != NULL) {
                
                if($this->input->post('Beneficiary_company_id') != "" && $this->input->post('Beneficiary_name') != "" &&  $this->input->post('Beneficiary_membership_id') != "" &&  $this->input->post('Enter_OPT') != "" ) {
                    
                  $Beneficiary_company_id= $this->input->post('Beneficiary_company_id');
                  $Beneficiary_membership_id= $this->input->post('Beneficiary_membership_id');
                  $Enter_OPT= $this->input->post('Enter_OPT');                    
                    
                    $Check_OTP = $this->Beneficiary_model->Check_OTP($Membership_id,$Beneficiary_company_id,$Beneficiary_membership_id,$Company_id,$Phone_no,$Enter_OPT);                                
                    if($Check_OTP ==1) {
                        
                            echo json_encode(array("status" => "1001", "msg" => "Valid OTP"));
                            
                        } else {
                               // echo $json["msg"];
                                echo json_encode(array("status" => "2016", "msg" => "Invalid OTP"));
                                //your code when not send
                        }
                } else {
                    echo json_encode(array("status" => "2014", "msg" => "In-valid Data provide"));
                }
            } else {
                  echo json_encode(array("status" => "2014", "msg" => "In-valid Data provide"));
            }                 
        } else {
                redirect('login');
        }            
	}
    function randomString($length = 6) {
        
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
             $rand = mt_rand(0, $max);
             $str .= $characters[$rand];
        }
        return $str;
    }
    public function Added_Beneficiary_accounts()
	{
		if($this->session->userdata('cust_logged_in'))
		{			
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;
			
			// var_dump($Enrollment_id); 
			$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
			
			$data["Get_Beneficiary_members"] = $this->Beneficiary_model->Get_Beneficiary_members_account($data['Company_id'],$Enrollment_id);
			// print_r($data["Get_Beneficiary_members"]);
			// -----------------------Template Configuration------------- //
				$data['Small_font_details'] = $this->Small_font_details;
				$data['Medium_font_details'] = $this->Medium_font_details;
				$data['Large_font_details'] = $this->Large_font_details;
				$data['Extra_large_font_details'] = $this->Extra_large_font_details;
				$data['Button_font_details'] = $this->Button_font_details;
				$data['General_details'] = $this->General_details;
				$data['Value_font_details'] = $this->Value_font_details;
				$data['Footer_font_details'] = $this->Footer_font_details;
				$data['Placeholder_font_details'] = $this->Placeholder_font_details;
				$data['icon_src']=$this->General_details[0]['Theme_icon_color'];
			// ----------------Template Configuration--------------------- //

			if($_POST == NULL)
			{
				//$this->load->view('home/Add_Beneficiary', $data);	
				$this->load->view('front/transferacross/Added_beneficiary', $data);
				$this->session->set_flashdata("success","");
			}
			else
			{
				// var_dump($_POST);
				// die;
					$Beneficiary_company_id=$this->input->post('Beneficiary_company_id');
					$exp=explode("*",$Beneficiary_company_id);
					$lv_Beneficiary_company_id=$exp[0];
					$Igain_company_id=$exp[1];

					$Igain_company_id=$this->input->post('Igain_company_id');
					$Beneficiary_company_id=$this->input->post('Beneficiary_company_id');
					$lv_Beneficiary_name=$this->input->post('Beneficiary_name');
					$lv_Beneficiary_membership_id=$this->input->post('Beneficiary_membership_id');

					/************Check_Beneficiary_members_exist********************/
					$Check_Beneficiary_members_exist = $this->Beneficiary_model->Check_Beneficiary_members_exist($data['Company_id'],$Enrollment_id,$lv_Beneficiary_membership_id);
					if($Check_Beneficiary_members_exist != 0)
					{
							$this->session->set_flashdata("success","Member already exist !!!");
							redirect('Beneficiary/Add_Beneficiary');
					}
					/**************************************/
					
					$this->session->set_flashdata("success","Member Added Successfully !!!");
					/********************Beneficiary Authentication ****************/

					if($Igain_company_id!=0)
					{
							/*$Company_Details= $this->Igain_model->get_company_details($rec->Igain_company_id);
							$Redemptionratio=$Company_Details->Redemptionratio;
							$Points_to_Currency=($Transfer_Points*$Redemptionratio);*/
							$Check_user = $this->Beneficiary_model->Check_beneficiary_customer($lv_Beneficiary_membership_id,$Igain_company_id,$lv_Beneficiary_name);
							if($Check_user == 0)
							{
									// echo "<br><br>Customer Not Found !!!";
									$Check_user_membershipID = $this->Beneficiary_model->Check_beneficiary_customer_membershipid($lv_Beneficiary_membership_id,$Igain_company_id,$lv_Beneficiary_name);
									$Check_user_name = $this->Beneficiary_model->Check_beneficiary_customer_name($lv_Beneficiary_membership_id,$Igain_company_id,$lv_Beneficiary_name);
									if($Check_user_membershipID == 0)
									{
											$this->session->set_flashdata("success","Member Identifier ID Invalid hence Member Not Approved !!!");
									}
									if($Check_user_name == 0)
									{
											$this->session->set_flashdata("success","Member Name not matched hence Member Not Approved !!!");
									}
									if($Check_user_name == 0 && $Check_user_membershipID == 0)
									{
											$this->session->set_flashdata("success","Member Identifier ID Invalid & Member Name not matched hence Member Not Approved !!!");
									}
									$post_data['Beneficiary_status']=2; //Not Approved
							}
							else
							{
									// echo "<br><br>Customer Found !!!"; 
									$post_data['Beneficiary_status']=1; //Approved
									$this->session->set_flashdata("success","Member Added & Approved Successfully !!!");
							}

					}
					 // die;
					/********************Beneficiary Authentication end****************/

					$post_data['Company_id']=$data['Company_id'];
					$post_data['Membership_id']=$Membership_id;
					$post_data['Enrollment_id']=$Enrollment_id;
					$post_data['Beneficiary_company_id']=$lv_Beneficiary_company_id;
					$post_data['Beneficiary_name']=$lv_Beneficiary_name;
					$post_data['Beneficiary_membership_id']=$lv_Beneficiary_membership_id;
					$post_data['Create_date']=date('Y-m-d H:i:s');
					$post_data['Active_flag']=1;

					$insert_Beneficairy = $this->Beneficiary_model->insert_Beneficairy($post_data);

					/*********************AMIT igain Log Table *************************/
						$Enrollment_id = $Enrollment_id; 
						$User_id = 1; 
						$opration = 1;				
						// $userid = $User_id;
						$what="Add Member";
						$where="Add Member";
						$toname="";
						$toenrollid = 0;
						$opval = $post_data['Beneficiary_name'];
						$Todays_date=date("Y-m-d");
						$firstName = $Enroll_details12->First_name;
						$lastName = $Enroll_details12->Last_name;
						$LogginUserName = $Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'],$Enrollment_id,$data['username'],$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/********************** *************************/

					redirect('Beneficiary/Add_Beneficiary');
			}		 
		}
		else
		{
				redirect('login');
		}		
	}
	public function Beneficiary_Points_Transfer()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$Publishers_category=$_REQUEST['Publishers_category'];		
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id= $session_data['Company_id'];
			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');	
			$Trans_date = $date->format('Y-m-d');
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;
			$Login_Total_topup_amt=$Enroll_details12->Total_topup_amt;
			// $Login_Current_balance=$Enroll_details12->Current_balance-$Enroll_details12->Blocked_points;
			
			$Avialable_balance = $Enroll_details12->Current_balance-($Enroll_details12->Blocked_points+$Enroll_details12->Debit_points);
							
			if($Avialable_balance<0)
			{
				$Login_Current_balance=0;
			}
			else
			{
				$Login_Current_balance=$Avialable_balance;
			}
			
			
			
			$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
			$data["Get_Beneficiary_members"] = $this->Beneficiary_model->Get_Beneficiary_members($data['Company_id'],$Enrollment_id,$Publishers_category);
			$data["Beneficiary_Trans_points_history"] = $this->Beneficiary_model->Get_Beneficiary_Trans_points_history($data['Company_id'],$Enrollment_id);
			// var_dump($data["Get_Beneficiary_members"]);
            $Login_Company_Details= $this->Igain_model->get_company_details($data['Company_id']);
			$Login_Redemptionratio=$Login_Company_Details->Redemptionratio;
			$data["Company_name"]=$Login_Company_Details->Company_name;
			$Company_name=$Login_Company_Details->Company_name;

            //Code Decode for Buy Miles Status
            $Get_codedecode_details= $this->Igain_model->Get_codedecode_row(44);

            $Buy_miles_status=$Get_codedecode_details->Code_decode;
                        
            // echo $Buy_miles_status;          
			// ------------------------------------Template Configuration------------------------------------ //
				$data['Small_font_details'] = $this->Small_font_details;
				$data['Medium_font_details'] = $this->Medium_font_details;
				$data['Large_font_details'] = $this->Large_font_details;
				$data['Extra_large_font_details'] = $this->Extra_large_font_details;
				$data['Button_font_details'] = $this->Button_font_details;
				$data['General_details'] = $this->General_details;
				$data['Value_font_details'] = $this->Value_font_details;
				$data['Footer_font_details'] = $this->Footer_font_details;
				$data['Placeholder_font_details'] = $this->Placeholder_font_details;
				$data['icon_src']=$this->General_details[0]['Theme_icon_color'];
			// ------------------------------Template Configuration---------------------- //
					
			if($_POST == NULL)
			{
				//$this->load->view('home/Beneficiary_Points_Transfer', $data);	
				$this->load->view('front/transferacross/from_beneficiary', $data);
			}
			else
			{                                                
				$Purchase_miles=$_REQUEST["Purchase_miles"];
				$Beneficiary_company_id=$_REQUEST["Beneficiary_company_id"];
				$Beneficiary_company_name=$_REQUEST["Beneficiary_company_name"];
				$Beneficiary_name=$_REQUEST["Beneficiary_name"];
				$Beneficiary_membership_id=$_REQUEST["Beneficiary_membership_id"];
				$Igain_company_id=$_REQUEST["Igain_company_id"];
				$Publisher_Redemptionratio=$_REQUEST["Publisher_Redemptionratio"];
				// $Equivalent=$_REQUEST["Equivalent"];
				$Equivalent=round($Purchase_miles*$Publisher_Redemptionratio);
				
				// echo "Purchase_miles---".$Purchase_miles;
				// echo "Equivalent---".$Equivalent;
				// echo "Login_Current_balance---".$Login_Current_balance; die;
				
				if($Purchase_miles > 0 && $Equivalent > 0 && $Login_Current_balance >= $Equivalent )
				{
                    $Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
                    $seller_id=$Super_Seller_details->Enrollement_id;
                    $Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
                    $top_db2 = $Super_Seller_details->Topup_Bill_no;
                    $len2 = strlen($top_db2);
                    $str2 = substr($top_db2,0,5);
                    $tp_bill2 = substr($top_db2,5,$len2);						
                    $topup_BillNo2 = $tp_bill2 + 1;
                    $billno_withyear_ref = $str2.$topup_BillNo2;

                    $Get_Beneficiary_company= $this->Beneficiary_model->Get_Beneficiary_Company_2($Beneficiary_company_id); 
                    
                    $data['Beneficiary_Company_details'] = $this->Beneficiary_model->Get_Beneficiary_Company_2($Beneficiary_company_id);
                    foreach ($data['Beneficiary_Company_details']  as $key => $value) {
                       $Authentication_url= $value->Authentication_url;
                       $Transaction_url= $value->Transaction_url;
                       $Company_username= $value->Company_username;
                       $Company_password= $value->Company_password;
                       $Company_encryptionkey= $value->Company_encryptionkey;
                       $Beneficiary_company_name= $value->Beneficiary_company_name;
                       $Beneficiary_Currency= $value->Currency;
                       $Company_logo= $value->Company_logo;
                     }
                   
                    $data['Get_Beneficiary_members']= $this->Beneficiary_model->Get_Beneficiary_members_2($Beneficiary_company_id,$Beneficiary_membership_id,$Enrollment_id);
                    foreach($data['Get_Beneficiary_members'] as $BeneficiaryMem){
						
                        $Beneficiary_account_id=$BeneficiaryMem['Beneficiary_account_id'];
                    }
                    
                    /*-------------------Buy Miles API----------------------------------*/
                    
                    $iv = '56666852251557009888889955123458'; 
                          
                    $Company_password=  $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);
                   
                    $API_Beneficiary_name=  $this->string_encrypt($Beneficiary_name, $Company_encryptionkey, $iv);
                    $API_Beneficiary_membership_id=  $this->string_encrypt($Beneficiary_membership_id, $Company_encryptionkey, $iv);
                    $API_Purchase_miles=  $this->string_encrypt($Purchase_miles, $Company_encryptionkey, $iv);
                    $API_tp_bill2=  $this->string_encrypt($tp_bill2, $Company_encryptionkey, $iv);
                    $API_Flag=  $this->string_encrypt(3, $Company_encryptionkey, $iv);
                    

                   /*  $purchaseData = http_build_query(
                        array(
                            'Company_username' => $Company_username,
                            'Company_password' => $Company_password,
                            'Beneficiary_name' => $API_Beneficiary_name,
                            'Beneficiary_membership_id' => $API_Beneficiary_membership_id,
                            'Purchase_miles' => $API_Purchase_miles,
                            'Bill_no' => $API_tp_bill2,
                            'flag' =>$API_Flag
                        )
                    );
                   $opts = array('http' =>
                        array(
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded',
                            'content' => $purchaseData
                        )
                    );
                    // print_r($purchaseData);
                    $context  = stream_context_create($opts);
                    $result = file_get_contents($Transaction_url, false, $context);
                    $return_result = json_decode($result); */
					
					$fields= array(
                            'Company_username' => $Company_username,
                            'Company_password' => $Company_password,
                            'Beneficiary_name' => $API_Beneficiary_name,
                            'Beneficiary_membership_id' => $API_Beneficiary_membership_id,
                            'Purchase_miles' => $API_Purchase_miles,
                            'Bill_no' => $API_tp_bill2,
                            'flag' =>$API_Flag
                        );
					
					$field_string = $fields;							 
					$ch = curl_init();
					$timeout = 0; // Set 0 for no timeout.
					curl_setopt($ch, CURLOPT_URL, $Transaction_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string));
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
					$result = curl_exec($ch);
					if(curl_errno($ch))
					{
						print "Error: " . curl_error($ch);
					}
					if (!curl_errno($ch)) {
						
					  $info = curl_getinfo($ch);
					  //echo '----error---- ', $info['total_time'], ' seconds to send a request to ', $info['url'], "--<br>";
					}
					curl_close($ch);							
					$return_result = json_decode($result);
					
                    $Reference_id=0;

                    // print_r($return_result);
                    // print_r($return_result->status);
					// die;
                    if($return_result->status == 1001 && $return_result->status_message > 0 ) {
                       
                       // echo"---Purchase Done--<br>"; 

                        $Reference_id=$return_result->status_message;  //Last Inserted Id from Publisher Database
                        $Remarks='Purchase Miles';
                        

                        $Update_bloack_points=$Enroll_details12->Blocked_points+$Equivalent;
                        $Login_Current_balance=$Enroll_details12->Current_balance;

                        $Post_data_From=array(                                                    
                            'Blocked_points'=>$Update_bloack_points
                                );
                        $result1 = $this->Igain_model->update_cust_balance($Post_data_From,$Membership_id,$Company_id);
                        

                    } else {
                        
                        // echo"---Purchase Not Done--<br>";   
                       
                        $Reference_id=0;
                        $Remarks=$return_result->status_message;                                        
                    }
                     // echo"---Remarks----".$Remarks."--<br>";       
                     // echo"---Reference_id----".$Reference_id."--<br>";       

                     // die;

                        $PurchaseMiles = array(					
                        'Company_id' => $Company_id,
                        'Trans_type' =>25,
                        'Trans_amount' => $Purchase_miles,
                        'Purchase_amount' => $Purchase_miles,        
                        'Redeem_points' => $Equivalent,        
                        'Remarks' =>$Remarks,       
                        'Trans_date' => $lv_date_time,
                        'Enrollement_id' => $Enrollment_id,
                        'Card_id' => $Membership_id,
                        'Seller' => $seller_id,
                        'Seller_name' => $Seller_name,
                        'Voucher_status' =>44,  //$Buy_miles_status, //Pending for Consolation
                        'To_Beneficiary_company_id' => $Beneficiary_company_id,
                        'To_Beneficiary_company_name' => $Beneficiary_company_name,
                        'To_Beneficiary_cust_name' => $Beneficiary_name,
                        'From_Beneficiary_company_id' => $Company_id,
                        'From_Beneficiary_company_name' => $Company_name,
                        'Bill_no' => $tp_bill2,
                        'Manual_billno' => $tp_bill2,
                        'Card_id2' => $Beneficiary_membership_id,
                        'Enrollement_id2' => $Beneficiary_account_id, //From Cust Beneficiary 
                        'Send_miles_flag' => 1,  
                        'Reference_id' => $Reference_id // Last Inserted Id from Publisher Database
                        );					
                        
                        $result = $this->Igain_model->Insert_transfer_transaction($PurchaseMiles);

                        $result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref); 
                    /*-------------------Buy Miles API----------------------------------*/
						$Purchased_Currency=$Beneficiary_Currency;
                        // Purchased Miles Email Template
                        $Email_content_From=array(	 
                                        'Trans_date' => $lv_date_time, 						
                                        'Notification_type' =>'You have purchased '.$Beneficiary_Currency.' from publisher '.$Beneficiary_company_name,
                                        'Purchased_miles' => $Purchase_miles, 
                                        'Purchased_Currency' => $Purchased_Currency, 
                                        'Equivalent_joy_coins' => $Equivalent,
                                        'From_publisher' =>$Beneficiary_company_name,
                                        'Status' =>"Pending",
                                        'From_member' =>$Enroll_details12->First_name.' '.$Enroll_details12->Last_name.' ('.$Membership_id.')',
                                        'Template_type' => 'Purchase_miles'

                                        );	
                        $this->send_notification->send_Notification_email($Enrollment_id,$Email_content_From,'0',$Company_id);
                        
                       
                        /********************* igain Log Table *************************/
                            $Enrollment_id = $Enrollment_id; 
                            $User_id = 1; 
                            $opration = 1;				
                            // $userid = $User_id;
                            $what="Purchase Miles";
                            $where="Purchase Miles";
                            $toname="";
                            $toenrollid = $Beneficiary_account_id;
                            $opval = $Purchase_miles;
                            $Todays_date=date("Y-m-d");
                            $firstName = $Enroll_details12->First_name;
                            $lastName = $Enroll_details12->Last_name;
                            $LogginUserName = $Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
                            $result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'],$Enrollment_id,$data['username'],$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$toenrollid);
                        /********************* igain Log Table *************************/
                    $this->load->view('front/transferacross/transfer_complete', $data);
				}
				else{
                                    
                    $this->load->view('front/transferacross/transfer_failed', $data);
				}	
				
				
			}		 
		}
		else
		{
			redirect('login');
		}			
    }
    public function Beneficiary_Points_Transfer_History()
    {
        if($this->session->userdata('cust_logged_in'))
        {			
            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];			
            $data['enroll'] = $session_data['enroll'];
            $data['userId']= $session_data['userId'];
            $data['Card_id']= $session_data['Card_id'];
            $data['Company_id']= $session_data['Company_id'];
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time=$date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');	
            $Trans_date = $date->format('Y-m-d');
            
            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
            $Company_id=$Enroll_details12->Company_id;
            $Membership_id=$Enroll_details12->Card_id;
            $Enrollment_id=$Enroll_details12->Enrollement_id;
            $Login_Current_balance=$Enroll_details12->Current_balance;

            $data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
            $data["Get_Beneficiary_members"] = $this->Beneficiary_model->Get_Beneficiary_members($data['Company_id'],$Enrollment_id);
            $data["Beneficiary_Trans_points_history"] = $this->Beneficiary_model->Get_Beneficiary_Trans_points_history($data['Company_id'],$Enrollment_id);
            // die;
            $Login_Company_Details= $this->Igain_model->get_company_details($data['Company_id']);
            $Login_Redemptionratio=$Login_Company_Details->Redemptionratio;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            $data["Company_logo"]=$Login_Company_Details->Company_logo;

            $data["Login_Current_balance"]=$Login_Current_balance;
            $data["Membership_id"]=$Membership_id;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            $data["Company_name"]=$Login_Company_Details->Company_name;


            // -------------------------Template Configuration--------------------- //
                $data['Small_font_details'] = $this->Small_font_details;
                $data['Medium_font_details'] = $this->Medium_font_details;
                $data['Large_font_details'] = $this->Large_font_details;
                $data['Extra_large_font_details'] = $this->Extra_large_font_details;
                $data['Button_font_details'] = $this->Button_font_details;
                $data['General_details'] = $this->General_details;
                $data['Value_font_details'] = $this->Value_font_details;
                $data['Footer_font_details'] = $this->Footer_font_details;
                $data['Placeholder_font_details'] = $this->Placeholder_font_details;
                $data['icon_src']=$this->General_details[0]['Theme_icon_color'];
            // -------------------------Template Configuration-------------------------- //
               
             $data["Beneficiary_Trans_points_history"] = $this->Beneficiary_model->Get_Beneficiary_Trans_points_history($data['Company_id'],$Enrollment_id);
            $this->load->view('front/transferacross/transfer_history', $data);
                       					 
        }
        else
        {
                redirect('login');
        }		
    }
    public function Beneficiary_Points_Transfer_Second()
    { 
        if($this->session->userdata('cust_logged_in'))
        {			
            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];			
            $data['enroll'] = $session_data['enroll'];
            $data['userId']= $session_data['userId'];
            $data['Card_id']= $session_data['Card_id'];
            $data['Company_id']= $session_data['Company_id'];
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time=$date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');	
            $Trans_date = $date->format('Y-m-d');
			
            $data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);

            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
            $Company_id=$Enroll_details12->Company_id;
            $Membership_id=$Enroll_details12->Card_id;
            $Enrollment_id=$Enroll_details12->Enrollement_id;
			$Current_balance=$Enroll_details12->Current_balance;
			$Blocked_points=$Enroll_details12->Blocked_points;
			$Debit_points=$Enroll_details12->Debit_points;
			$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
				
			if($Current_point_balance<0)
			{
				$Current_point_balance=0;
			}
			else
			{
				$Current_point_balance=$Current_point_balance;
			}
            
			// $Login_Current_balance=$Enroll_details12->Current_balance-$Enroll_details12->Blocked_points;

            $data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
            $data["Get_Beneficiary_members"] = $this->Beneficiary_model->Get_Beneficiary_members1($data['Company_id'],$Enrollment_id);
            $data["Beneficiary_Trans_points_history"] = $this->Beneficiary_model->Get_Beneficiary_Trans_points_history($data['Company_id'],$Enrollment_id);
            // die;
            $Login_Company_Details= $this->Igain_model->get_company_details($data['Company_id']);
            $Login_Redemptionratio=$Login_Company_Details->Redemptionratio;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            $data["Company_logo"]=$Login_Company_Details->Company_logo;

            $data["Login_Current_balance"]=$Current_point_balance;
            $data["Membership_id"]=$Membership_id;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            $data["Company_name"]=$Login_Company_Details->Company_name;


            // --------------------Template Configuration------------------------- //
                $data['Small_font_details'] = $this->Small_font_details;
                $data['Medium_font_details'] = $this->Medium_font_details;
                $data['Large_font_details'] = $this->Large_font_details;
                $data['Extra_large_font_details'] = $this->Extra_large_font_details;
                $data['Button_font_details'] = $this->Button_font_details;
                $data['General_details'] = $this->General_details;
                $data['Value_font_details'] = $this->Value_font_details;
                $data['Footer_font_details'] = $this->Footer_font_details;
                $data['Placeholder_font_details'] = $this->Placeholder_font_details;
                $data['icon_src']=$this->General_details[0]['Theme_icon_color'];
            // ---------------------------Template Configuration--------------------------- //

            if($_REQUEST['To_Beneficiary_company_id'] == NULL) {
                
               $this->load->view('front/transferacross/from_beneficiary', $data);
               
            } else {
               
                //echo"--To_Beneficiary_company_id---".$_REQUEST['To_Beneficiary_company_id']."--<br>";
               // echo"--Beneficiary_membership_id---".$_REQUEST['Beneficiary_membership_id']."--<br>";
                // $data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company_2($_REQUEST['To_Beneficiary_company_id']); 
				
                $data['Get_Beneficiary_members']= $this->Beneficiary_model->Get_Beneficiary_members_2($_REQUEST['To_Beneficiary_company_id'],$_REQUEST['Beneficiary_membership_id'],$Enrollment_id);
               
				$Get_Beneficiary_Company = $this->Beneficiary_model->Get_Beneficiary_Company_2($_REQUEST['To_Beneficiary_company_id']);
				
				foreach ($Get_Beneficiary_Company as $bcompnay)
				{
					 $Redemptionratio=$bcompnay->Redemptionratio;
					 $data['Publisher_Redemptionratio']=$Redemptionratio;
				}
               
               //$this->load->view('front/transferacross/to_beneficiary', $data);              
               $this->load->view('front/transferacross/across_transferpts_done', $data);
               
            }					 
        }
        else
        {
                redirect('login');
        }		
    }
    public function Beneficiary_Points_Transfer_Third()
    {
        if($this->session->userdata('cust_logged_in'))
        {			
            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];			
            $data['enroll'] = $session_data['enroll'];
            $data['userId']= $session_data['userId'];
            $data['Card_id']= $session_data['Card_id'];
            $data['Company_id']= $session_data['Company_id'];
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time=$date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');	
            $Trans_date = $date->format('Y-m-d');
            $data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
            $data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
            $Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
            $Company_id=$Enroll_details12->Company_id;
            $Membership_id=$Enroll_details12->Card_id;
            $Enrollment_id=$Enroll_details12->Enrollement_id;
            // $Login_Current_balance=$Enroll_details12->Current_balance-$Enroll_details12->Blocked_points;
			$Current_balance=$Enroll_details12->Current_balance;
			$Blocked_points=$Enroll_details12->Blocked_points;
			$Debit_points=$Enroll_details12->Debit_points;
			
			$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
				
			if($Current_point_balance<0)
			{
			 $Current_point_balance=0;
			}
			else
			{
				$Current_point_balance=$Current_point_balance;
			}
            
            $Login_Company_Details= $this->Igain_model->get_company_details($data['Company_id']);
            $Login_Redemptionratio=$Login_Company_Details->Redemptionratio;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            $data["Company_logo"]=$Login_Company_Details->Company_logo;

            $data["Login_Current_balance"]=$Current_point_balance;
            $data["Membership_id"]=$Membership_id;
            $data["Company_id"]=$Login_Company_Details->Company_id;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            

            // ----------------------Template Configuration------------------ //
                $data['Small_font_details'] = $this->Small_font_details;
                $data['Medium_font_details'] = $this->Medium_font_details;
                $data['Large_font_details'] = $this->Large_font_details;
                $data['Extra_large_font_details'] = $this->Extra_large_font_details;
                $data['Button_font_details'] = $this->Button_font_details;
                $data['General_details'] = $this->General_details;
                $data['Value_font_details'] = $this->Value_font_details;
                $data['Footer_font_details'] = $this->Footer_font_details;
                $data['Placeholder_font_details'] = $this->Placeholder_font_details;
                $data['icon_src']=$this->General_details[0]['Theme_icon_color'];
            // ---------------------Template Configuration------------------- //
            if($_REQUEST['Beneficiary_company_id'] == NULL || $_REQUEST['To_Beneficiary_company_id'] == NULL)
            {
                //$this->load->view('home/Beneficiary_Points_Transfer', $data);	
                $this->load->view('front/transferacross/from_beneficiary', $data);
            }
            else
            {               
                if($_REQUEST['To_others']==1)  //others company to others company
                {
                    
                    $To_Beneficiary_company_id = $this->Beneficiary_model->Get_Beneficiary_Company_2($_REQUEST['Beneficiary_company_id']); 
                    $data["Get_Beneficiary_Company"]=$Get_Beneficiary_Company;
                    foreach ($To_Beneficiary_company_id as $bcmp)
                    {
                        $From_igain_company_id=$bcmp->Igain_company_id;
                    }
                   $data['From_igain_company_id']=$From_igain_company_id;
                    
                    $From_company_id= $this->Igain_model->get_company_details($From_igain_company_id);
                    $From_Redemptionratio=$From_company_id->Redemptionratio;
                    $data["From_Company_name"]=$From_company_id->Company_name;
                    $data["From_Company_logo"]=$From_company_id->Company_logo;
                    
                    $Get_Beneficiary_members= $this->Beneficiary_model->Get_Beneficiary_members_2($_REQUEST['Beneficiary_company_id'],$Enrollment_id);
                    
                    foreach($Get_Beneficiary_members as $Membership_id)
                    {
                       $Beneficiary_membership_id =$Membership_id->Beneficiary_membership_id;                   
                    }
                    $Get_Beneficiary_members_details= $this->Igain_model->get_customer_details($Beneficiary_membership_id,$From_igain_company_id);           
                    $data['From_Customer_name']=$Get_Beneficiary_members_details->First_name.' '.$Enroll_details12->Last_name;	
                    $data['From_Company_id']=$Get_Beneficiary_members_details->Company_id;
                    $data['From_Membership_id']=$Get_Beneficiary_members_details->Card_id;
                    $data['From_Enrollment_id']=$Get_Beneficiary_members_details->Enrollement_id;
                    $data['From_Current_balance']=$Get_Beneficiary_members_details->Current_balance-$Get_Beneficiary_members_details->Blocked_points;
                    
                }
                else  //Login company to others company
                {
                    $From_company_id= $this->Igain_model->get_company_details($_REQUEST['Beneficiary_company_id']);
                    $From_Redemptionratio=$From_company_id->Redemptionratio;
                    $data["From_Company_name"]=$From_company_id->Company_name;
                    $data["From_Company_logo"]=$From_company_id->Company_logo;
                    $From_Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);               
                    $Customer_name=$From_Enroll_details->First_name.' '.$Enroll_details12->Last_name;	
                    $data['From_Company_id']=$From_Enroll_details->Company_id;
                    $data['From_Membership_id']=$From_Enroll_details->Card_id;
                    $data['From_Enrollment_id']=$From_Enroll_details->Enrollement_id;
                    $data['From_Current_balance']=$From_Enroll_details->Current_balance-$From_Enroll_details->Blocked_points;
                    $data['From_igain_company_id']= $_REQUEST['Beneficiary_company_id'];
                    
                }                
                $To_Beneficiary_company_id = $this->Beneficiary_model->Get_Beneficiary_Company_2($_REQUEST['To_Beneficiary_company_id']); 
                $Igain_company_id=$To_Beneficiary_company_id->Igain_company_id;
                foreach ($To_Beneficiary_company_id as $bcmp)
                {
                    $To_igain_company_id=$bcmp->Igain_company_id;
                }
                $data['To_igain_company_id']=$To_igain_company_id;
                 $Beneficiary_Company= $this->Igain_model->get_company_details($To_igain_company_id);                
                $Beneficiary_Redemptionratio=$Beneficiary_Company->Redemptionratio;
                $data["Beneficiary_Company_name"]=$Beneficiary_Company->Company_name;
                $data["Beneficiary_Company_logo"]=$Beneficiary_Company->Company_logo;
                $data["Beneficiary_Company_id"]=$Beneficiary_Company->Company_id;
                
                $Get_Beneficiary_members= $this->Beneficiary_model->Get_Beneficiary_members_2($_REQUEST['To_Beneficiary_company_id'],$Enrollment_id);
                
                foreach($Get_Beneficiary_members as $Membership_id)
                {
                   $Beneficiary_membership_id =$Membership_id->Beneficiary_membership_id;                   
                }
                $Get_Beneficiary_members_details= $this->Igain_model->get_customer_details($Beneficiary_membership_id,$To_igain_company_id);
                $data['Beneficiary_member_name']=$Get_Beneficiary_members_details->First_name.' '.$Get_Beneficiary_members_details->Last_name;
                $data['Beneficiary_member_Company_id']=$Get_Beneficiary_members_details->Company_id;
                $data['Beneficiary_member_Membership_id']=$Get_Beneficiary_members_details->Card_id;
                $data['Beneficiary_member_Enrollment_id']=$Get_Beneficiary_members_details->Enrollement_id;
                $data['Beneficiary_member_Current_balance']=$Get_Beneficiary_members_details->Current_balance-$Get_Beneficiary_members_details->Blocked_points;
                
                
                $data['To_others']= $_REQUEST['To_others'];
                $this->load->view('front/transferacross/across_transferpts_done', $data);
                
            }					 
        }
        else
        {
                redirect('login');
        }		
    }
    public function Delete_Beneficiary_account()
    {
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);			
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;	
			$Company_id=$Enroll_details12->Company_id;
			$Membership_id=$Enroll_details12->Card_id;
			$Enrollment_id=$Enroll_details12->Enrollement_id;
			
			$Beneficiary_account_id=$_REQUEST["Beneficiary_account_id"];
			$Delete = $this->Beneficiary_model->Delete_Beneficiary_account($Beneficiary_account_id);
			$this->session->set_flashdata("success","Member Deleted Successfully !!!");
			
			/*********************AMIT igain Log Table *************************/
				$Enrollment_id = $Enrollment_id; 
				$User_id = 1; 
				$opration = 3;				
				// $userid = $User_id;
				$what="Delete Member";
				$where="Add Member";
				$toname="";
				$toenrollid = 0;
				$opval = "Beneficiary_account_id : ".$Beneficiary_account_id;
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details12->First_name;
				$lastName = $Enroll_details12->Last_name;
				$LogginUserName = $Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'],$Enrollment_id,$data['username'],$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/********************** *************************/
			$this->output->set_output($Delete);
			//redirect('Beneficiary/Add_Beneficiary');
		}
	}
	public function Get_Beneficiary_Company_details()
	{
		$result = $this->Beneficiary_model->Get_Beneficiary_Company_details($this->input->post("Beneficiary_company_id"),$this->input->post("Enroll_id"));
		
			if($result != NULL)
			{
				$this->output->set_output($result);
			}
			else    
			{
				$this->output->set_output("0");
			} 		
	}	
	public function Get_Beneficiary_Company_list()
	{
		$data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($this->input->post("Company_id"));
		$data["Beneficiary_company_id"] = $this->input->post("Beneficiary_company_id");
		$this->load->view('home/Beneficiary_company_list', $data);
			
	}	
    public function Get_Equivalent_beneficiary_points()
    {	
        $Transfer_Points=$_REQUEST["Purchase_miles"];
        $From_Beneficiary_company_id=$_REQUEST["Beneficiary_company_id"];
        $Company_id=$_REQUEST["Company_id"];
        $Beneficiary_membership_id=$_REQUEST["Beneficiary_membership_id"];
        $Igain_company_id=$_REQUEST["Igain_company_id"];
        if($Igain_company_id == 0){

            $Get_Beneficiary_Company = $this->Beneficiary_model->Get_Beneficiary_Company_2($From_Beneficiary_company_id);
            foreach ($Get_Beneficiary_Company as $bcompnay)
            {
                 $Redemptionratio=$bcompnay->Redemptionratio;
            }

        } else {

            $Redemptionratio=1;  
            $Login_Company_Details= $this->Igain_model->get_company_details($Company_id);
            $Redemptionratio=$Login_Company_Details->Redemptionratio;
        }

        //echo $Redemptionratio;

        $Points_to_Currency=($Transfer_Points*$Redemptionratio);

        //$Company_Details= $this->Igain_model->get_company_details($Igain_company_id);
        //$Redemptionratio=$Company_Details->Redemptionratio;        
        //$Currency_to_Points=round($Points_to_Currency*$Redemptionratio);

        $this->output->set_output($Points_to_Currency);			
    }
    /*public function string_encrypt($string, $key, $iv)
    {
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $padding = $block - (strlen($string) % $block);
        $string .= str_repeat(chr($padding), $padding);

        $crypted_text = mcrypt_encrypt
                        (
                            MCRYPT_RIJNDAEL_256, 
                            $key, 
                            $string, 
                            MCRYPT_MODE_CBC, $iv
                        );
        return base64_encode($crypted_text);
    }
    public function string_decrypt($encrypted_string, $key, $iv)
    {
        return mcrypt_decrypt
                (
                    MCRYPT_RIJNDAEL_256, 
                    $key, 
                    base64_decode($encrypted_string), 
                    MCRYPT_MODE_CBC, $iv
                );
    }*/	
     public function string_encrypt($string, $key, $iv)  {
        
        $version = phpversion();
        // echo "-------version----".$version."---------------<br>";
        $new_version=  substr($version, 0, 1);
       
        //echo "-------new_version----".$new_version."---------------<br>";
        if($new_version >= 7) {
            
            $first_key = base64_decode($key);
            $second_key = base64_decode($key);    

            $method = "aes-256-cbc";    
            $iv_length = openssl_cipher_iv_length($method);
            $iv = openssl_random_pseudo_bytes($iv_length);

            $first_encrypted = openssl_encrypt($string,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
            $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

            $output = base64_encode($iv.$second_encrypted.$first_encrypted);    
             // echo "--input---output--".$output."------<br><br>";
         
            return $output;
            
        } else {
            
             $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
            $padding = $block - (strlen($string) % $block);
            $string .= str_repeat(chr($padding), $padding);

            $crypted_text = mcrypt_encrypt
                            (
                                MCRYPT_RIJNDAEL_256, 
                                $key, 
                                $string, 
                                MCRYPT_MODE_CBC, $iv
                            );
            return base64_encode($crypted_text); 
        }
        
         
         
        
        
    }
    public function string_decrypt($encrypted_string, $key, $iv)  {
        
         // echo "-------string_decrypt--------------<br>";
        $version = phpversion();
        //echo "-------version----".$version."---------------<br>";
        $new_version=  substr($version, 0, 1);
       
       // echo "-------new_version----".$new_version."---------------<br>";
        if($new_version >= 7) {
            
                   
            $first_key = base64_decode($key);
            $second_key = base64_decode($key);            
            $mix = base64_decode($encrypted_string);

            $method = "aes-256-cbc";    
            $iv_length = openssl_cipher_iv_length($method);

            $iv = substr($mix,0,$iv_length);
            $second_encrypted = substr($mix,$iv_length,64);
            $first_encrypted = substr($mix,$iv_length+64);

            $data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);


             //echo "--Output-data--".$data."------<br><br>";

            return $data;
            
        } else {
             
            return mcrypt_decrypt
            (
                MCRYPT_RIJNDAEL_256, 
                $key, 
                base64_decode($encrypted_string), 
                MCRYPT_MODE_CBC, $iv
            );
            
        }
        
        
    }
}
?>