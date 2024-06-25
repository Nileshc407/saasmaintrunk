<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Register_saas_company extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Saas_model');
		$this->load->library('form_validation');	
		$this->load->library('Send_notification');
		$this->load->library('m_pdf');
		$this->load->helper('file');
		$this->load->helper(array('form', 'url','encryption_val'));	
		$this->load->model('Email_templateM/Email_templateModel');
	
	}

	public function index()
	{	
		
	
			// echo 'csrf_token_name '.$this->security->get_csrf_token_name();						
		$FetchCountry = $this->Saas_model->FetchCountry();	
		$data['Country_array'] = $FetchCountry;	
		$Timezones = $this->Saas_model->FetchCountryTimezones();	
		$data['Timezones'] = $Timezones;			
		$data['Company_type'] = $this->Saas_model->Get_Code_decode_master(23);		
		$License_details = $this->Saas_model->Get_saas_license_details();
		foreach($License_details as $License_details)	
		{
			if($License_details->License_type_id==121)//Basic
			{
				$data['Basic_limit'] = $License_details->Member_limit;
			}
			if($License_details->License_type_id==253)//Standard
			{
				$data['Standard_limit'] = $License_details->Member_limit;
				$data['Standard_Monthly_price'] = $License_details->Monthly_price;
				$data['Standard_Indian_monthly_price'] = $License_details->Indian_monthly_price;
			}
			
			if($License_details->License_type_id==120)//Enhance
			{
				$data['Enhance_limit'] = $License_details->Member_limit;
				$data['Enhance_Monthly_price'] = $License_details->Monthly_price;
				$data['Enhance_Indian_monthly_price'] = $License_details->Indian_monthly_price;
			}
			
		}
			
		// $this->load->view('Saas_company/Create_Saas_Company2',$data);
		$this->load->view('Saas_company/Register_saas_companyView',$data);
	}
	public function Create_Saas_Company2()
	{		
		

			$FetchCountry = $this->Saas_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;				
			$data['License_type'] = $this->Saas_model->Get_Code_decode_master(20);
		
				
				// $this->load->view('Saas_company/Introduction_Saas_Company',$data);
				// $this->load->view('Saas_company/Create_Saas_Company2',$data);
				// $this->load->view('Saas_company/Create_Saas_Company',$data);
				// $this->load->view('Saas_company/Create_Saas_CompanyCopy',$data);
	}
	public function Create_Saas_Company()
	{		
		

			$FetchCountry = $this->Saas_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;				
			$data['License_type'] = $this->Saas_model->Get_Code_decode_master(20);
			$data['Company_type'] = $this->Saas_model->Get_Code_decode_master(23);
				
				$this->load->view('Saas_company/Create_Saas_Company3',$data);
				// $this->load->view('Saas_company/Create_Saas_Company',$data);
				// $this->load->view('Saas_company/Create_Saas_CompanyCopy',$data);
	}
	public function Complete_Saas_Company()
	{		
		

			$FetchCountry = $this->Saas_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;				
			$data['License_type'] = $this->Saas_model->Get_Code_decode_master(20);
				
				$this->load->view('Saas_company/Complete_Saas_Company',$data);
	}
	
	public function insert_saas_company_master()
	{
	
			if($_SESSION['Input_email'] != $_REQUEST['Company_primary_email_id'])
			{
				
				$this->session->set_flashdata("error_code","Please Verify Email ID !!!");
				redirect('Register_saas_company/', 'refresh');		
			}
			
			if($_REQUEST['VerificationCode']!=App_string_decrypt($_SESSION['Verification_code']))
			{
				$this->session->set_flashdata("error_code","Please Verify Email ID !!!");
				redirect('Register_saas_company/', 'refresh');		
			}
			
			$Company_type = $this->Saas_model->Get_Code_decode_master(23);
			foreach($Company_type as $Company_type)
			{
				$Company_typeArray[]=$Company_type->Code_decode_id;
				
			}
			if (!in_array($_REQUEST['Company_type'], $Company_typeArray))
			{
				$this->session->set_flashdata("error_code","Please Select Valid Business Type");
				redirect('Register_saas_company/', 'refresh');		
			}
			// echo $_REQUEST['Company_type'];
			// print_r($Company_typeArray);die;
			
			
			$Company_License_typeArray = array("120", "121", "253");
			if (!in_array($_REQUEST['Company_License_type'], $Company_License_typeArray))
			{
				$this->session->set_flashdata("error_code","Please Select Valid Company License Type");
				redirect('Register_saas_company/', 'refresh');		
			}
			if(is_numeric($_REQUEST['Company_License_type']) != 1)
			{
				$this->session->set_flashdata("error_code","Please Select Valid Company License Type");
				redirect('Register_saas_company/', 'refresh');	
			}
			
			$Seller_licences_limitArray = array("1", "2", "3", "4", "5");
			if (!in_array($_REQUEST['Seller_licences_limit'], $Seller_licences_limitArray))
			{
				$this->session->set_flashdata("error_code","Please Select Valid Outlets");
				redirect('Register_saas_company/', 'refresh');		
			}
			
			if(is_numeric($_REQUEST['Seller_licences_limit']) != 1)
			{
				$this->session->set_flashdata("error_code","Please Select Valid data");
				redirect('Register_saas_company/', 'refresh');	
			}
			
			if(strlen($_REQUEST['Company_primary_phone_no']) != 10)
			{
				$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
				redirect('Register_saas_company/', 'refresh');	
			}
			
			if(is_numeric($_REQUEST['Company_primary_phone_no']) != 1)
			{
				$this->session->set_flashdata("error_code","Incorrect Phone No.");
				redirect('Register_saas_company/', 'refresh');	
			}
			
			
			
			if(is_numeric($_REQUEST['Redemptionratio']) != 1)
			{
				$this->session->set_flashdata("error_code","Please Enter Correct Redemptionratio !!!");
				redirect('Register_saas_company/', 'refresh');	
			}
			
			if(is_numeric($_REQUEST['Loyalty_at_transaction']) != 1)
			{
				$this->session->set_flashdata("error_code","Please Enter Correct Loyalty Points Issuance Percentage !!!");
				redirect('Register_saas_company/', 'refresh');	
			}
			if($_REQUEST['Loyalty_at_transaction'] > 100)
			{
				$this->session->set_flashdata("error_code","Please Enter Loyalty Points Issuance Percentage < 100 ");
				redirect('Register_saas_company/', 'refresh');	
			}
			
						
			if (!filter_var($_REQUEST['Company_primary_email_id'], FILTER_VALIDATE_EMAIL)) {
			  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
				redirect('Register_saas_company/', 'refresh');	
			}
			

			//************************Company Setup*****************************
			/*-----------------------File Upload---------------------*/
			/* Load the image library */
				$this->load->library('image_lib');
				$config = array(
							'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
							'max_size'          => 2048,
							'max_width'          => 3000, 
							'max_height'          => 3000, 
							'encrypt_name'    => true,
							'upload_path'       => './uploads/' //upload directory
				);
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
				/* Create the config for image library */
		
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
				
				$upload22 = $this->upload->do_upload('Company_logo');
				$data22 = $this->upload->data();
				$ImageError=1;	
				
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
					$filepath_logo = 'uploads/logo-placeholder35.png';
				}
				// echo $data22['file_name'];
				
				if($_REQUEST['Joining_bonus']==1)
				{
					$Joining_bonus_points = $_REQUEST['Joining_bonus_points'];
					if(is_numeric($Joining_bonus_points) != 1)
					{
						$this->session->set_flashdata("error_code","Please Enter Correct Joining Bonus Points !!!");
						redirect('Register_saas_company/', 'refresh');	
					}
					
				}
				else
				{
					$_REQUEST['Joining_bonus']=0;
					$Joining_bonus_points = 0;
				}	
				if($_REQUEST['Refferral_bonus']==1)
				{
					
					if(is_numeric($_REQUEST['Refferral_bonus_points']) != 1)
					{
						$this->session->set_flashdata("error_code","Please Enter Correct Referral Points !!!");
						redirect('Register_saas_company/', 'refresh');	
					}
					
				}
									
			
			
			if($this->upload->display_errors())
			{
				if($data22['file_name']!='')
				{
					$this->session->set_flashdata("error_code",$this->upload->display_errors());
					redirect('Register_saas_company/', 'refresh');	
				}
				
			}
			
		
			$_REQUEST['Country']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Country']);
			$States_array = $this->Igain_model->Get_states($_REQUEST['Country']);
			// print_r($States_array);
			$State_id=0;
			if($States_array != NULL)
			{
				foreach($States_array as $States_array)
				{
					$State_id=$States_array->id;break;
				}
			}
			if($State_id == 0)
			{
				$this->session->set_flashdata("error_code","Please Select Valid Country !!!");
				redirect('Register_saas_company/', 'refresh');	
			}
			// echo '<br>State_id '.$State_id;
			// echo '<br><br><br> ';
			 	
			$City_array = $this->Igain_model->Get_cities($State_id);
			// print_r($City_array);
			foreach($City_array as $City_array)
			{
				
				$City_id=$City_array->id;break;
			}
			// echo '<br>City_id '.$City_id;
			// die;
			$Auction_bidding_applicable = 1;
			$Promo_code_applicable = 1;
			$Points_as_discount_flag = 1;
			$Voucher_as_discount_flag = 1;
			$Survey_analysis = 0;
			$Call_center_flag = 0;
			$Callcenter_query_ticketno_series = 0;
			
			if($_REQUEST['Company_License_type']==121)//Basic
			{
				$Auction_bidding_applicable = 0;
				$Promo_code_applicable = 0;
				$Points_as_discount_flag = 0;
				$Voucher_as_discount_flag = 0;
				
			}
			
			if($_REQUEST['Company_License_type']==120)//Enhance
			{
				$Survey_analysis = 1;
				$Call_center_flag = 1;
				
			}
			
			//Enroll Owner as Super Seller
					/** *************oWNER*pASSWORD GENERATE*************** */
					  $characters = 'A123B5C8';
					  $string = '';
					  $User_pwd = "";
					  for ($i = 0; $i < 8; $i++) {
						$User_pwd .= $characters[mt_rand(0, strlen($characters) - 1)];
					  }
					  //----------------------------------------------------
					/** *************Callcenter_query_ticketno_series GENERATE*************** */
					  $characters = '0123456789';
					  $string = '';
					  $Callcenter_query_ticketno_series = "";
					  for ($i = 0; $i < 8; $i++) {
						$Callcenter_query_ticketno_series .= $characters[mt_rand(0, strlen($characters) - 1)];
					  }
					  //----------------------------------------------------
			if($_REQUEST['Company_License_type']==121){$Company_License='Basic';}
			if($_REQUEST['Company_License_type']==120){$Company_License='Enhance';}
			if($_REQUEST['Company_License_type']==253){$Company_License='Standard';}
			
			
			$_REQUEST['Company_name']= strip_tags($_REQUEST['Company_name']);
			$_REQUEST['Company_type']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Company_type']);
			$_REQUEST['Company_License_type']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Company_License_type']);
			$_REQUEST['First_name']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['First_name']);
			$_REQUEST['Last_name']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Last_name']);
			$_REQUEST['Seller_licences_limit']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Seller_licences_limit']);
			$_REQUEST['Domain_name']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Domain_name']);
			$_REQUEST['Country']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Country']);
			// $_REQUEST['timezone_entry']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['timezone_entry']);
			// $_REQUEST['timezone_entry2']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['timezone_entry2']);
			// $_REQUEST['Company_address']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Company_address']);
			$_REQUEST['Redemptionratio']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Redemptionratio']);
			$_REQUEST['Joining_bonus']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Joining_bonus']);
			$_REQUEST['Joining_bonus_points']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Joining_bonus_points']);
			$_REQUEST['Refferral_bonus_points']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Refferral_bonus_points']);
			$_REQUEST['Loyalty_name']= strip_tags($_REQUEST['Loyalty_name']);
			
			
			if ($_REQUEST['Company_name']=='' || $_REQUEST['Company_type']=='' || $_REQUEST['Company_address']=='' || $_REQUEST['First_name']=='' || $_REQUEST['Last_name']=='' || $_REQUEST['Domain_name']=='' || $_REQUEST['Company_primary_email_id']=='' || $_REQUEST['Company_primary_phone_no']=='' || $_REQUEST['Country']=='' || $_REQUEST['Seller_licences_limit']=='' || $_REQUEST['Redemptionratio']=='' || $_REQUEST['Company_License_type']=='' || $_REQUEST['Loyalty_name']=='' ||  $_REQUEST['Loyalty_at_transaction']=='')
			{
				$this->session->set_flashdata("error_code","Please Enter All Required Fields !!!");
				redirect('Register_saas_company/', 'refresh');		
			}
			
			$Dial_Code = $this->Igain_model->get_dial_code($_REQUEST['Country']);
			// $dialcode=$Dial_Code->phonecode;
			$phoneNo=App_string_encrypt($Dial_Code.''.$_REQUEST['Company_primary_phone_no']);
			// die;
		$Post_data1=array(
						'Company_name'=>$_REQUEST['Company_name'],
						'Company_type'=>$_REQUEST['Company_type'],
						'Company_address'=>$_REQUEST['Company_address'],
						'Company_primary_contact_person'=>$_REQUEST['First_name'].' '.$_REQUEST['Last_name'],
						'Company_primary_email_id'=>'no-reply@'.$_REQUEST['Domain_name'].'.com',
						'Company_contactus_email_id'=>$_REQUEST['Company_primary_email_id'],
						'Company_primary_phone_no'=>$_REQUEST['Company_primary_phone_no'],
						'Website'=> base_url().$_REQUEST['Domain_name'].'/index.php/?User_login',
						'Cust_website'=>base_url().$_REQUEST['Domain_name'].'/index.php',
						'Cust_apk_link'=>base_url().$_REQUEST['Domain_name'].'/index.php/apk/'.$_REQUEST['Domain_name'].'.apk',
						'Domain_name'=>$_REQUEST['Domain_name'],
						'App_folder_name'=>$_REQUEST['Domain_name'],
						'Alise_name'=>$_REQUEST['Domain_name'].'App',
						'Company_username'=>$_REQUEST['Domain_name'],
						'Company_password'=>$User_pwd,
						'Country'=>$_REQUEST['Country'],
						'State'=>$State_id,
						'City'=>$City_id,
						'Seller_licences_limit'=>$_REQUEST['Seller_licences_limit'],
						'Company_logo'=>$filepath_logo,
						'Localization_logo'=>$filepath_logo,
						'Redemptionratio'=>$_REQUEST['Redemptionratio'],
						'Joining_bonus'=>$_REQUEST['Joining_bonus'],
						'Joining_bonus_points'=>$Joining_bonus_points,
						'Company_License_type'=>$_REQUEST['Company_License_type'],
						'Company_Licence_period'=> 365,
						'Gift_card_validity_days'=> 365,
						'Cron_evoucher_expiry_flag'=> 1,
						'Evoucher_expiry_period'=> 30,
						'Label_1'=>$_REQUEST['Sector'],
						'Currency_name'=>'Points',
						'myloyaltyprogram'=>$_REQUEST['Loyalty_name'],
						'Company_encryptionkey'=> '!QAZXSW@#EDCVFR$',
						'Comp_regdate'=> date('Y-m-d H:i:s'),
						'Creation_date_time'=> date('Y-m-d H:i:s'),
						'Saas_company_flag'=> 2,
						'Parent_company'=> 1,
						'Auction_bidding_applicable'=> $Auction_bidding_applicable,
						'Promo_code_applicable'=> $Promo_code_applicable,
						'Points_as_discount_flag'=> $Points_as_discount_flag,
						'Voucher_as_discount_flag'=> $Voucher_as_discount_flag,
						'Survey_analysis'=> $Survey_analysis,
						'Call_center_flag'=> $Call_center_flag,
						'Callcenter_query_ticketno_series'=> $Callcenter_query_ticketno_series,
						'Gift_card_flag'=> 1,
						'Happy_member_flag'=> 1,
						'Worry_member_flag'=> 1,
						'Member_suggestions_flag'=> 1,
						'Cron_communication_flag'=> 1,
						'Total_quantity_issued_Vs_total_quantity_used_graph_flag'=> 1,
						'No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag'=> 1,
						'Total_point_issued_Vs_total_points_redeemed_graph_flag'=> 1,
						'Member_enrollments_graph_flag'=> 1,
						'Active_Vs_inactive_member_graph_flag'=> 1,
						'Notification_send_to_email'=> 1,
						'Activated'=> 1
						);
		$Saas_Company_id = $this->Saas_model->insert_saas_company_master($Post_data1);
		
		$post_dataz = array(
					'card_decsion' => 1,
					'Start_card_series' => $Saas_Company_id.'000000000',
					'next_card_no' => $Saas_Company_id.'000000000'
				);
		$Update = $this->Saas_model->Update_saas_company($Saas_Company_id,$post_dataz);
		
		
				//************************Enrollment Setup*****************************
				//Enroll Owner as Super Seller
				
		$Current_year = date('Y');
		$Post_data112=array(
						'User_email_id'=> App_string_encrypt($_REQUEST['Company_primary_email_id']),
						'User_pwd'=> App_string_encrypt($User_pwd),
						'Seller_Redemptionratio'=>$_REQUEST['Redemptionratio'],
						'joined_date'=> date('Y-m-d H:i:s'),
						'First_name'=>$_REQUEST['First_name'],
						'Last_name'=>$_REQUEST['Last_name'],
						'Current_address'=>App_string_encrypt($_REQUEST['Company_address']),
						'Phone_no'=> $phoneNo,
						'Country'=>$_REQUEST['Country'],
						'Country_id'=>$_REQUEST['Country'],
						'State'=>$State_id,
						'City'=>$City_id,
						'timezone_entry'=>$_REQUEST['timezone_entry2'],
						'User_activated'=> 1,
						'Sub_seller_admin'=> 1,
						'Super_seller'=> 1,
						'Seller_Billingratio'=> 1.00,
						'Purchase_Bill_no'=> "$Current_year-100000",
						'Topup_Bill_no'=> "$Current_year-200000",
						'Seller_Billing_Bill_no'=> "$Current_year-300000",
						'User_id'=> 2,
						'pinno'=> $User_pwd,
						'Company_id'=>$Saas_Company_id,
						);
			$Owner_id = $this->Saas_model->insert_saas_enroll_master($Post_data112);
			
			//************************Loyalty Setup for superseller*****************************
				
				$loyalty_rule_setup = $this->input->post("loyalty_rule_setup");
				$loyalty_rule_setup= strip_tags($loyalty_rule_setup);
				
				$Loyalty_name = $loyalty_rule_setup."-".$this->input->post("Loyalty_name");
				
				$Loyalty_name= strip_tags($Loyalty_name);
				$_REQUEST['Loyalty_at_transaction']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Loyalty_at_transaction']);
				
				$Post_data2=array(
								'Loyalty_name'=>$Loyalty_name,
								'From_date'=> date("Y-m-d H:i:s"),
								'Till_date' => date("Y-m-d",strtotime('+12 month')),
								'Loyalty_at_transaction'=>$_REQUEST['Loyalty_at_transaction'],
								'Company_id'=>$Saas_Company_id,
								'Seller'=>$Owner_id,
								'Active_flag'=> 1,
								);
				$result = $this->Saas_model->insert_saas_loyalty_master($Post_data2);
			
			
		//Enroll Outlet as Brand
		$Bill_no = 1000;
		$Bill_no2 = 2000;
		$Bill_no3 = 3000;
		if($_REQUEST['Seller_licences_limit']>5){$_REQUEST['Seller_licences_limit']=5;}
		for($i=1;$i<=$_REQUEST['Seller_licences_limit'];$i++)
		{
			// echo "<br>$i";
			$PBill_no = "$Current_year-".$Bill_no;
			$TBill_no = "$Current_year-".$Bill_no2;
			$BBill_no = "$Current_year-".$Bill_no3;
			$User_email_id = "Brand$i@".$_REQUEST['Domain_name'].'.com';
			/** **************PASSWORD GENERATE*************** */
					  $characters = 'A123B5C8';
					  $string = '';
					  $User_pwd2 = "";
					  for ($j = 0; $j < 8; $j++) {
						$User_pwd2 .= $characters[mt_rand(0, strlen($characters) - 1)];
					  }
					  //----------------------------------------------------
			$Post_data11=array(
						'First_name'=>'Brand',
						'Last_name'=> "$i",
						'User_email_id'=> App_string_encrypt($User_email_id),
						'User_pwd'=> App_string_encrypt($User_pwd2),
						'pinno'=> $User_pwd2,
						'Seller_Redemptionratio'=>$_REQUEST['Redemptionratio'],
						'joined_date'=> date('Y-m-d H:i:s'),
						'Country'=>$_REQUEST['Country'],
						'Country_id'=>$_REQUEST['Country'],
						'State'=>$State_id,
						'City'=>$City_id,
						'timezone_entry'=>$_REQUEST['timezone_entry2'],
						'User_activated'=> 1,
						'User_id'=> 2,
						// 'Sub_seller_Enrollement_id'=> $Owner_id,
						'Sub_seller_admin'=> 1,
						'Super_seller'=> 0,
						'Seller_Billingratio'=> 1.00,
						'Purchase_Bill_no'=> $PBill_no,
						'Topup_Bill_no'=> $TBill_no,
						'Seller_Billing_Bill_no'=> $BBill_no,
						'Company_id'=>$Saas_Company_id,
						);
			$Brand_id = $this->Saas_model->insert_saas_enroll_master($Post_data11);
			//Enroll Outlet 
			$User_email_id = "outlet$i@".$_REQUEST['Domain_name'].'.com';
			
			/** **************pASSWORD GENERATE*************** */
					  $characters = 'A123B5C8';
					  $string = '';
					  $User_pwd3 = "";
					  for ($k = 0; $k < 8; $k++) {
						$User_pwd3 .= $characters[mt_rand(0, strlen($characters) - 1)];
					  }
					  //----------------------------------------------------
					  
			$Post_data111=array(
						'First_name'=>'Outlet',
						'Last_name'=> "$i",
						'User_email_id'=> App_string_encrypt($User_email_id),
						'User_pwd'=> App_string_encrypt($User_pwd3),
						'pinno'=> $User_pwd3,
						'Seller_Redemptionratio'=>$_REQUEST['Redemptionratio'],
						'joined_date'=> date('Y-m-d H:i:s'),
						'Country'=>$_REQUEST['Country'],
						'Country_id'=>$_REQUEST['Country'],
						'State'=>$State_id,
						'City'=>$City_id,
						'timezone_entry'=>$_REQUEST['timezone_entry2'],
						'User_activated'=> 1,
						'User_id'=> 2,
						'Sub_seller_Enrollement_id'=> $Brand_id,
						'Sub_seller_admin'=> 0,
						'Super_seller'=> 0,
						'Seller_Billingratio'=> 1.00,
						'Purchase_Bill_no'=> $PBill_no,
						'Topup_Bill_no'=> $TBill_no,
						'Seller_Billing_Bill_no'=> $BBill_no,
						'Company_id'=>$Saas_Company_id,
						);
			$Outlet = $this->Saas_model->insert_saas_enroll_master($Post_data111);
			// echo "<br> $Outlet";
			//************************Loyalty Setup*****************************
				
				$loyalty_rule_setup = $this->input->post("loyalty_rule_setup");
				$loyalty_rule_setup= strip_tags($loyalty_rule_setup);
				
				$Loyalty_name = $loyalty_rule_setup."-".$this->input->post("Loyalty_name");
				
				$Loyalty_name= strip_tags($Loyalty_name);
				$_REQUEST['Loyalty_at_transaction']= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Loyalty_at_transaction']);
				
				$Post_data2=array(
								'Loyalty_name'=>$Loyalty_name,
								'From_date'=> date("Y-m-d H:i:s"),
								'Till_date' => date("Y-m-d",strtotime('+12 month')),
								'Loyalty_at_transaction'=>$_REQUEST['Loyalty_at_transaction'],
								'Company_id'=>$Saas_Company_id,
								'Seller'=>$Brand_id,
								'Active_flag'=> 1,
								);
				$result = $this->Saas_model->insert_saas_loyalty_master($Post_data2);
			
			//************************Refferral Setup*****************************
				$Refferral_bonus = $this->input->post("Refferral_bonus_points");
				$Refferral_bonus= preg_replace('/[^A-Za-z0-9\-]/', '', $Refferral_bonus);
				if($Refferral_bonus != NULL && $Refferral_bonus > 0)
				{					
					$Post_data211=array(
								'Customer_topup'=>$Refferral_bonus,
								'Refree_topup'=>$Refferral_bonus,
								'From_date'=> date("Y-m-d H:i:s"),
								'Till_date' => date("Y-m-d",strtotime('+12 month')),
								'Referral_rule_for'=> 1,
								'Company_id'=>$Saas_Company_id,
								'Seller_id'=>$Outlet,
								);
					$result = $this->Saas_model->insert_saas_refferral_master($Post_data211);
					
					$Post_data2111=array(
								'Customer_topup'=>$Refferral_bonus,
								'Refree_topup'=>$Refferral_bonus,
								'From_date'=> date("Y-m-d H:i:s"),
								'Till_date' => date("Y-m-d",strtotime('+12 month')),
								'Referral_rule_for'=> 1,
								'Company_id'=>$Saas_Company_id,
								'Seller_id'=>$Brand_id,
								);
					$result11 = $this->Saas_model->insert_saas_refferral_master($Post_data2111);
				}
		
				/************************Assign Menu to Outlet********************************
				$All_Saas_menus = $this->Saas_model->Get_saas_company_menus($_REQUEST['Company_License_type']);
				if($All_Saas_menus != NULL)
				{
					foreach($All_Saas_menus as $menu)
					{
						/********************************Assign to Outlet**********************
						$Outlet_menu_array = array('1','2','3','4','5','6','7','8','9','12','13','83','89','90');
						if(array_search($menu->Menu_id,$Outlet_menu_array) != NULL)
						{
							$post_data22 = array(					
								'Company_id' => $Saas_Company_id,
								'User_type_id' => 2,
								'Enrollment_id' => $Outlet,
								'Menu_id' => $menu->Menu_id,
								'Menu_level' => $menu->Menu_level,
								'Parent_id' => $menu->Parent_menu_id
							);
							$result22 = $this->Saas_model->assign_menu($post_data22);
							
						}
					}
				}
			*/
			
			$Bill_no = $Bill_no+5000;			
			$Bill_no2 = $Bill_no2+5000;			
			$Bill_no3 = $Bill_no3+5000;			
						
		}
		
// die;
		
		//************************Tier Setup*****************************
					
		$Post_data2=array(
						'Tier_name'=> 'Bronze',
						'Excecution_time'=> 'Yearly',
						'Tier_criteria'=> 1,
						'Tier_level_id'=> 1,
						'Criteria_value'=> 500,
						'Operator_id'=> 5,
						'Redeemtion_limit'=> 0,
						'Tier_redemption_ratio'=> 1,
						'Company_id'=>$Saas_Company_id,
						'Create_date'=> date('Y-m-d'),
						'Active_flag'=> 1,
						);
		$result = $this->Saas_model->insert_saas_tier_master($Post_data2);
		
		//*********************************Link Reference Templates to Company**************
		
		$All_temp = $this->Saas_model->Get_all_refrence_templates();
		if($All_temp != NULL)
		{
			
			foreach($All_temp as $RefTemp)
			{
				$Post_data32=array(
							'Company_id'=>$Saas_Company_id,
							'Template_type_id'=>$RefTemp->Email_Type,
							'Email_template_id'=>$RefTemp->Email_template_id,
							'Template_description'=>$RefTemp->Template_description,
							'Email_Type'=>$RefTemp->Email_template_id,
							'Email_header'=>$RefTemp->Email_header,
							// 'Email_header_image'=>$RefTemp->Email_header_image,
							'Email_header_image'=> base_url().$filepath_logo,
							'Email_subject'=>$RefTemp->Email_subject,
							'Email_body'=>$RefTemp->Email_body,
							'Body_image'=>$RefTemp->Body_image,
							'Email_font_size'=>$RefTemp->Email_font_size,
							'Body_structure'=>$RefTemp->Body_structure,
							'Font_family'=>$RefTemp->Font_family,
							'Email_font_color'=>$RefTemp->Email_font_color,
							'Email_background_color'=>$RefTemp->Email_background_color,
							'Header_background_color'=>$RefTemp->Header_background_color,
							'Footer_background_color'=>$RefTemp->Footer_background_color,
							'Footer_notes'=>$RefTemp->Footer_notes,
							'Email_Contents_background_color'=>$RefTemp->Email_Contents_background_color,
							'Footer_font_color'=>$RefTemp->Footer_font_color,
							'Status'=>1
							);
						$Insert_data = $this->Email_templateModel->Insert_company_emailtemp_master($Post_data32);
			}
		}
		//*********************************Assign Menues to Company**************
		$All_Saas_menus = $this->Saas_model->Get_saas_company_menus($_REQUEST['Company_License_type']);
		if($All_Saas_menus != NULL)
		{
			foreach($All_Saas_menus as $menu)
			{
				// Assign to Saas Company
				$Menu_array = array(
					'Company_id' => $Saas_Company_id,
					'Menu_id' => $menu->Menu_id,
					'Menu_level' => $menu->Menu_level,
					'Menu_name' => $menu->Menu_name,
					'Parent_menu_id' => $menu->Parent_menu_id,
					'Menu_href' => $menu->Menu_href,
					'Active_flag' => $menu->Active_flag
				);
				$insert_saas_company_menus = $this->Saas_model->insert_company_menus($Saas_Company_id,$Menu_array);
				
				//******************************** Assign to Super Seller********************************
				$post_data = array(					
					'Company_id' => $Saas_Company_id,
					'User_type_id' => 2,
					'Enrollment_id' => $Owner_id,
					'Menu_id' => $menu->Menu_id,
					'Menu_level' => $menu->Menu_level,
					'Parent_id' => $menu->Parent_menu_id
				);
				$result2 = $this->Saas_model->assign_menu($post_data);
				
				//******************************** Assign privileges to Super Seller**********************
				$post_data3 = array(					
					'Company_id' => $Saas_Company_id,
					'User_type_id' => 2,
					'Enrollment_id' => $Owner_id,
					'Menu_id' => $menu->Menu_id,
					'Add_flag' => 1,
					'Edit_flag' => 1,
					'View_flag' => 1,
					'Delete_flag' => 1
				);
				$result23 = $this->Saas_model->assign_menu_privileges($post_data3);
				
				/********************************Assign to Outlet********************************
				$Outlet_menu_array = array('1','2','3','4','5','6','7','8','9','12','13','83','89','90');
				if(array_search($menu->Menu_id,$Outlet_menu_array) != NULL)
				{
					$post_data22 = array(					
						'Company_id' => $Saas_Company_id,
						'User_type_id' => 2,
						'Enrollment_id' => $Outlet_id,
						'Menu_id' => $menu->Menu_id,
						'Menu_level' => $menu->Menu_level,
						'Parent_id' => $menu->Parent_menu_id
					);
					$result22 = $this->Saas_model->assign_menu($post_data22);
					*/
			}
		}
		//*********************************Create Partner & branch**************
		$this->load->model('Catalogue/Catelogue_model');
		$Post_partner_data1=array('Partner_type'=>1,
		'Company_id'=>$Saas_Company_id,
		'Partner_name'=>$_REQUEST['Company_name'].' Partner',
		'Partner_address'=>$_REQUEST['Company_address'],
		'Country_id'=>$_REQUEST['Country'],
		'Partner_contact_person_name'=>$_REQUEST['First_name'].' '.$_REQUEST['Last_name'],
		'Partner_contact_person_phno'=>$_REQUEST['Company_primary_phone_no'],
		'Partner_contact_person_email'=>$_REQUEST['Company_primary_email_id'],
		'Partner_redemption_ratio'=>$_REQUEST['Redemptionratio'],
		'Partner_vat'=>0,
		'Partner_markup_percentage'=>0,
		'Active_flag'=>1);
										
		$partner_result1 = $this->Catelogue_model->Insert_Merchandize_Partner($Post_partner_data1);
					
		$Post_branch_data1=array(
		'Company_id'=>$Saas_Company_id,
		'Partner_id'=>$partner_result1,
		'Branch_code'=>'Branch_code_'.$partner_result1,
		'Branch_name'=>$_REQUEST['Company_name'].' Partner Branch',
		'Address'=>$_REQUEST['Company_address'],
		'Country_id'=>$_REQUEST['Country'],
		'Active_flag'=>1);
		$result19 = $this->Catelogue_model->Insert_Merchandize_Partner_Branch($Post_branch_data1);			
		//---------------	e-Gifting Partner--------------------------------		
		
		
		$Post_partner_data=array('Partner_type'=>1,
		'Company_id'=>$Saas_Company_id,
		'Partner_name'=>'e-Gifting Partner',
		'Partner_address'=>$_REQUEST['Company_address'],
		'Country_id'=>$_REQUEST['Country'],
		'Partner_contact_person_name'=>$_REQUEST['First_name'].' '.$_REQUEST['Last_name'],
		'Partner_contact_person_phno'=>$_REQUEST['Company_primary_phone_no'],
		'Partner_contact_person_email'=>$_REQUEST['Company_primary_email_id'],
		'Partner_redemption_ratio'=>$_REQUEST['Redemptionratio'],
		'Partner_vat'=>0,
		'Partner_markup_percentage'=>0,
		'Active_flag'=>1);
										
		$partner_result = $this->Catelogue_model->Insert_Merchandize_Partner($Post_partner_data);
					
		$Post_branch_data=array(
		'Company_id'=>$Saas_Company_id,
		'Partner_id'=>$partner_result,
		'Branch_code'=>'Branch_code_'.$partner_result,
		'Branch_name'=>'e-Gifting Partner Branch',
		'Address'=>$_REQUEST['Company_address'],
		'Country_id'=>$_REQUEST['Country'],
		'Active_flag'=>1);
					
		$result19 = $this->Catelogue_model->Insert_Merchandize_Partner_Branch($Post_branch_data);
		//**********************************************************************************	
			
			$Email_content = array(
				  'Notification_type' => 'Congrats '.$_REQUEST['Company_name'].'. You are registered with us!',
				  'Company_name' => $_REQUEST['Company_name'],
				  'Company_primary_contact_person' => $_REQUEST['First_name'],
				  'Company_primary_email_id' => $_REQUEST['Company_primary_email_id'],
				  'Domain_name' => $_REQUEST['Domain_name'],
				  'User_pwd' => "outlet@".$_REQUEST['Domain_name'],
				   'Seller_licences_limit' => $_REQUEST['Seller_licences_limit'],
				   'Company_License' => $Company_License,
				   'Notification_No' => 1,
				  'Template_type' => 'Saas_company_registration'
			  );
		  
			$this->send_notification->send_Notification_email(0, $Email_content, 0, $Saas_Company_id);
			//**********************************************************************************
		// echo $_REQUEST['Company_License_type'];
		  // die;
	
		// redirect('Register_saas_company/Complete_Saas_Company');
		$this->session->set_flashdata("success_code","Congratulations !! You have been registered successfully! <br> <br>Please check the details at the registered email.<br><br><p  style='font-size: 10px; !important;color:#155724;'>NOTE: Please do check your Spam or Junk folder . Just incase the notification is there and do not forget to mark all input emails as non-junk.</p>");
		redirect('Register_saas_company/');
				
		
	}
		public function Auto_Process_saas_company()
	{
		$this->load->library('user_agent');
		if ($this->agent->is_browser())
		{
				$agent = $this->agent->browser().' '.$this->agent->version();
				echo $agent;
				die;
		}
		
		//****************Create Customer Website Domain instance********************************
		$Company_details = $this->Saas_model->Fetch_Saas_Company_instance();
		foreach($Company_details as $Company_Records)
		{
				$Company_type= $Company_Records['Company_type'];
				// if($Company_type==242){$src = 'saashealthweb';}
				// if($Company_type==240){$src = 'saasfoodweb';}
				$src = 'Cust_Loyalty_Portal';
				
				
				$Company_id= $Company_Records['Company_id'];
				$Country= $Company_Records['Country'];
				$Joining_bonus_points= $Company_Records['Joining_bonus_points'];
				$Redemptionratio= $Company_Records['Redemptionratio'];
				$Company_name= $Company_Records['Domain_name'];
				$Domain_name= $Company_Records['Domain_name'];
				$Company_primary_email_id= $Company_Records['Company_contactus_email_id'];
				$Company_primary_contact_person= $Company_Records['Company_primary_contact_person'];
				$Seller_licences_limit= $Company_Records['Seller_licences_limit'];
				$Company_password= $Company_Records['Company_password'];
				$Company_License_type= $Company_Records['Company_License_type'];
				
				$FetchCountry = $this->Saas_model->Get_Country_master($Country);	
				$Currency_name = $FetchCountry->Symbol_of_currency;
				
				$FetchLoyalty = $this->Saas_model->get_loyalty_detail($Company_id);
				$Loyalty_name = $FetchLoyalty->Loyalty_name;				
				$Loyalty_at_transaction = $FetchLoyalty->Loyalty_at_transaction;	
				
				$lp_type = substr($Loyalty_name, 0, 2);	
				$Loyalty_name = substr($Loyalty_name, 3, 50);	
				if ($lp_type == 'PA') {$Loyalty_Rule = 'Purchase Amount';}
				if ($lp_type == 'BA') {$Loyalty_Rule = 'Paid Amount';}

                 
				$Coverted_AMT = (1/$Redemptionratio);
				
				$FetchRefferral = $this->Saas_model->get_transaction_referral_rule($Company_id);
				$Refferral_points = 0;
				if($FetchRefferral != NULL){$Refferral_points = $FetchRefferral->Refree_topup;}
				
				//******************************************************************************
			 /* echo "<br><br>Company_name :: $Company_name";
			echo "<br><br>Joining_bonus_points :: $Joining_bonus_points";
			echo "<br><br>Redemptionratio :: $Redemptionratio";
			echo "<br><br>Currency_name :: $Currency_name";
			echo "<br><br>Loyalty_Rule :: $Loyalty_Rule";
			echo "<br><br>Loyalty_name :: $Loyalty_name";
			echo "<br><br>Coverted_AMT :: $Coverted_AMT";
			echo "<br><br>Refferral_points :: $Refferral_points";
			echo "<br><br>Loyalty_at_transaction :: $Loyalty_at_transaction";
			die;  */
			
			$FetchOutlets = $this->Saas_model->get_company_outlets($Company_id);
			$Outlet_tbl = '<table  style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center><tr><th style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px">Outlet Name</th><th style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px">User Email ID</th><th style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" >Password</th></tr>';
			foreach($FetchOutlets as $rec)
			{
				$Outlet_tbl .= "<tr>";
				$Outlet_tbl .= "<td style='border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px' align=center>".$rec->First_name." ".$rec->Last_name."</td>";
				$Outlet_tbl .= "<td style='border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px' align=center>".App_string_decrypt($rec->User_email_id)."</td>";
				$Outlet_tbl .= "<td style='border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px' align=center>".App_string_decrypt($rec->User_pwd)."</td>";
				$Outlet_tbl .= "</tr>";
				// echo '<br>Last_name '.$rec->Last_name;
				
			}
			$Outlet_tbl .= "</table>";
			// echo $Outlet_tbl;Company_License_type
			if($Company_License_type==121){$Company_License='Basic';}
			if($Company_License_type==120){$Company_License='Enhance';}
			if($Company_License_type==253){$Company_License='Standard';}
		
		
			//**********************************************************************************	
			
				if(!is_dir("$Company_name")){
				 mkdir("$Company_name",0777,true);
				 chmod("$Company_name",0755);
				  echo "<br>$Company_name web Created";
				}
				else
				{
					 echo "<br>$Company_name Already Created";
				}					
				
				$files1 = scandir($src);
				// echo $src; echo '<br><br>';
				echo '<br>FCPATHAweb :::'.FCPATH;
				$dirPath = "$Company_name";
				
				
				

				
				
				// die;
					  foreach($files1 as $file){
						   // echo "<br>file  ".$file;
						   // echo "<br>";
						  //-------------------------------------------------------------------
						  if(!is_dir("$Company_name/$file")){
							 mkdir("$Company_name/$file",0777,true);
							 chmod("$Company_name/$file",0755);
							}
							$src2 = "$src/$file";
							// $dirPath2 = "$dirPath/$file";
							$files2 = glob("$src/$file/*.*");
							// $files2 = glob("$src/$file/");
							if($files2 != NULL){
							foreach($files2 as $file3){
								$file_to_go = str_replace($src2,$dirPath2,$file3);
								copy($file3, $file_to_go);
							}
								
							}
							// die;
							
							//-----------------------------------------------------------
							
							$files11 = scandir($src2);
							// print_r($files1);
							if($files11 != NULL){
							foreach($files11 as $file2){
							  // echo "<br>".$file2;
								 if(!is_dir("$Company_name/$file/$file2")){
								 mkdir("$Company_name/$file/$file2",0777,true);
								 chmod("$Company_name/$file/$file2",0755);
								}
								$src22 = "$src/$file/$file2";
								$dirPath22 = "$dirPath/$file/$file2";
								$files22 = glob("$src/$file/$file2/*.*");
								if($files22 != NULL){
								foreach($files22 as $file33){
									$file_to_go33 = str_replace($src22,$dirPath22,$file33);
									copy($file33, $file_to_go33);
									// chmod("$Company_name/$file/$file2",0755);
								}
								}
								
								//-----------------------------------------------------------
								$files111 = scandir($src22);
								// print_r($files1);
								if($files111 != NULL){
								foreach($files111 as $file21){
								  // echo "<br>".$file2;
									 if(!is_dir("$Company_name/$file/$file2/$file21")){
									 mkdir("$Company_name/$file/$file2/$file21",0777,true);
									 chmod("$Company_name/$file/$file2/$file21",0755);
									}
									$src221 = "$src/$file/$file2/$file21";
									$dirPath221 = "$dirPath/$file/$file2/$file21";
									$files221 = glob("$src/$file/$file2/$file21/*.*");
									if($files221 != NULL){
									foreach($files221 as $file331){
										$file_to_go331 = str_replace($src221,$dirPath221,$file331);
										copy($file331, $file_to_go331);
										// chmod("$Company_name/$file/$file2",0755);
										}
									}
									
									//-----------------------------------------------------------
									$files1112 = scandir($src221);
									// print_r($files1);
									if($files1112 != NULL){
									foreach($files1112 as $file212){
									  // echo "<br>".$file2;
										 if(!is_dir("$Company_name/$file/$file2/$file21/$file212")){
										 mkdir("$Company_name/$file/$file2/$file21/$file212",0777,true);
										 chmod("$Company_name/$file/$file2/$file21/$file212",0755);
										}
										$src2212 = "$src/$file/$file2/$file21/$file212";
										$dirPath2212 = "$dirPath/$file/$file2/$file21/$file212";
										$files2212 = glob("$src/$file/$file2/$file21/$file212/*.*");
										if($files2212 != NULL){
										foreach($files2212 as $file3312){
											$file_to_go3312 = str_replace($src2212,$dirPath2212,$file3312);
											copy($file3312, $file_to_go3312);
											// chmod("$Company_name/$file/$file2",0755);
											}
										}
										
										
									}
									}
									//---------------------------------------------
									
									//-----------------------------------------------------------
									$files11123 = scandir($src2212);
									// print_r($files1);
									if($files11123 != NULL){
									foreach($files11123 as $file2123){
									  // echo "<br>".$file2;
										 if(!is_dir("$Company_name/$file/$file2/$file21/$file212/$file2123")){
										 mkdir("$Company_name/$file/$file2/$file21/$file212/$file2123",0777,true);
										 chmod("$Company_name/$file/$file2/$file21/$file212/$file2123",0755);
										}
										$src22123 = "$src/$file/$file2/$file21/$file212/$file2123";
										$dirPath22123 = "$dirPath/$file/$file2/$file21/$file212/$file2123";
										$files22123 = glob("$src/$file/$file2/$file21/$file212/$file2123/*.*");
										if($files22123 != NULL){
										foreach($files22123 as $file33123){
											$file_to_go33123 = str_replace($src22123,$dirPath22123,$file33123);
											copy($file33123, $file_to_go33123);
											// chmod("$Company_name/$file/$file2",0755);
												}
											}
										}
									}
									//---------------------------------------------
									//-----------------------------------------------------------
									$files111234 = scandir($src22123);
									// print_r($files1);
									if($files111234 != NULL){
									foreach($files111234 as $file21234){
									  // echo "<br>".$file2;
										 if(!is_dir("$Company_name/$file/$file2/$file21/$file212/$file2123/$file21234")){
										 mkdir("$Company_name/$file/$file2/$file21/$file212/$file2123/$file21234",0777,true);
										 chmod("$Company_name/$file/$file2/$file21/$file212/$file2123/$file21234",0755);
										}
										$src221234 = "$src/$file/$file2/$file21/$file212/$file2123/$file21234";
										$dirPath221234 = "$dirPath/$file/$file2/$file21/$file212/$file2123/$file21234";
										$files221234 = glob("$src/$file/$file2/$file21/$file212/$file2123/$file21234/*.*");
										if($files221234 != NULL){
										foreach($files221234 as $file331234){
											$file_to_go331234 = str_replace($src221234,$dirPath221234,$file331234);
											copy($file331234, $file_to_go331234);
											// chmod("$Company_name/$file/$file2",0755);
												}
											}
										}
									}
									//---------------------------------------------
									
									//---------------------------------------------
								
									
								}
								}
								
							}
							}
					}
					
					//***********************Copy htaccess **************************	
					$Base_url = FCPATH.$Company_name;
					
					
					$srcfile=FCPATH."$src/htaccessFile/.htaccess";
					$dstfile="$Base_url/.htaccess";
					// mkdir(dirname($dstfile), 0777, true);
					copy($srcfile, $dstfile);
					echo "<br><br>srcfile :: ".$srcfile;
					echo "<br><br>dstfile :: ".$dstfile;
					echo '<br><br>Base_url :: '.$Base_url;
					//***********************cHANGE htaccess **************************
				
				
				$str223=file_get_contents($dstfile);
				$str223=str_replace("SAASCOMPANYNAME", "$Company_name",$str223);
				file_put_contents($dstfile, $str223); 
				
					//***********************cHANGE config **************************
				$str=file_get_contents($Base_url.'/application/config/config.php');
				
				$str=str_replace("$src", "$Company_name",$str);
				file_put_contents($Base_url.'/application/config/config.php', $str); 
				//***********************cHANGE Company ID **************************
				$str22=file_get_contents($Base_url.'/application/controllers/Login.php');
				
				$str22=str_replace("SAASCOMPANYID", "$Company_id",$str22);
				file_put_contents($Base_url.'/application/controllers/Login.php', $str22); 
				
				//***********************************************************************
		//**************************CUSTOMER WEBSITE END-----------------------
		/**********************************Create CUSTOMER APP Domain instance***********************/
		
				// if($Company_type==242){$src = 'saashealthApp';}
				// if($Company_type==240){$src = 'saasfoodApp';}
				
				$src = 'Cust_Loyalty_App';
				$Company_name= $Company_Records['Domain_name'].'App';
				if(!is_dir("$Company_name")){
				 mkdir("$Company_name",0777,true);
				 chmod("$Company_name",0755);
				 echo "<br>$Company_name  Created";
				}
				else
				{
					// echo "<br>Already Created";
				}					
				
				$files1 = scandir($src);
				// echo '<br><br>FCPATHApp :::'.FCPATH;
				$dirPath = "$Company_name";
				// die;
					  foreach($files1 as $file){
						   // echo "<br>".$file;
						   // echo "<br>";
						  //-------------------------------------------------------------------
						  if(!is_dir("$Company_name/$file")){
							 mkdir("$Company_name/$file",0777,true);
							 chmod("$Company_name/$file",0755);
							}
							$src2 = "$src/$file";
							$dirPath2 = "$dirPath/$file";
							$files2 = glob("$src/$file/*.*");
							if($files2 != NULL){
							foreach($files2 as $file3){
								$file_to_go = str_replace($src2,$dirPath2,$file3);
								copy($file3, $file_to_go);
							}
							}
							//-----------------------------------------------------------
							$files11 = scandir($src2);
							// print_r($files1);
							if($files11 != NULL){
							foreach($files11 as $file2){
							  // echo "<br>".$file2;
								 if(!is_dir("$Company_name/$file/$file2")){
								 mkdir("$Company_name/$file/$file2",0777,true);
								 chmod("$Company_name/$file/$file2",0755);
								}
								$src22 = "$src/$file/$file2";
								$dirPath22 = "$dirPath/$file/$file2";
								$files22 = glob("$src/$file/$file2/*.*");
								if($files22 != NULL){
								foreach($files22 as $file33){
									$file_to_go33 = str_replace($src22,$dirPath22,$file33);
									copy($file33, $file_to_go33);
									// chmod("$Company_name/$file/$file2",0755);
								}
								}
								
								//-----------------------------------------------------------
								$files111 = scandir($src22);
								// print_r($files1);
								if($files111 != NULL){
								foreach($files111 as $file21){
								  // echo "<br>".$file2;
									 if(!is_dir("$Company_name/$file/$file2/$file21")){
									 mkdir("$Company_name/$file/$file2/$file21",0777,true);
									 chmod("$Company_name/$file/$file2/$file21",0755);
									}
									$src221 = "$src/$file/$file2/$file21";
									$dirPath221 = "$dirPath/$file/$file2/$file21";
									$files221 = glob("$src/$file/$file2/$file21/*.*");
									if($files221 != NULL){
									foreach($files221 as $file331){
										$file_to_go331 = str_replace($src221,$dirPath221,$file331);
										copy($file331, $file_to_go331);
										// chmod("$Company_name/$file/$file2",0755);
									}
									}//chmode('$Company_name/$server1/$server2/$server3')
									
										//-----------------------------------------------------------
									$files1112 = scandir($src221);
									// print_r($files1);
									if($files1112 != NULL){
									foreach($files1112 as $file212){
									  // echo "<br>".$file2;
										 if(!is_dir("$Company_name/$file/$file2/$file21/$file212")){
										 mkdir("$Company_name/$file/$file2/$file21/$file212",0777,true);
										 chmod("$Company_name/$file/$file2/$file21/$file212",0755);
										}
										$src2212 = "$src/$file/$file2/$file21/$file212";
										$dirPath2212 = "$dirPath/$file/$file2/$file21/$file212";
										$files2212 = glob("$src/$file/$file2/$file21/$file212/*.*");
										if($files2212 != NULL){
										foreach($files2212 as $file3312){
											$file_to_go3312 = str_replace($src2212,$dirPath2212,$file3312);
											copy($file3312, $file_to_go3312);
											// chmod("$Company_name/$file/$file2",0755);
										}
										}
										
										
									}
									}
									//-----------------------------------------------------------
									$files11123 = scandir($src2212);
									// print_r($files1);
									if($files11123 != NULL){
									foreach($files11123 as $file2123){
									 
										 if(!is_dir("$Company_name/$file/$file2/$file21/$file212/$file2123")){
											  // echo "<br>file2123 ".$file2123;
										 mkdir("$Company_name/$file/$file2/$file21/$file212/$file2123",0777,true);
										 chmod("$Company_name/$file/$file2/$file21/$file212/$file2123",0755);
										}
										$src22123 = "$src/$file/$file2/$file21/$file212/$file2123";
										$dirPath22123 = "$dirPath/$file/$file2/$file21/$file212/$file2123";
										$files22123 = glob("$src/$file/$file2/$file21/$file212/$file2123/*.*");
										if($files22123 != NULL){
										foreach($files22123 as $file33123){
											$file_to_go33123 = str_replace($src22123,$dirPath22123,$file33123);
											copy($file33123, $file_to_go33123);
											// chmod("$Company_name/$file/$file2",0755);
												}
											}
										}
									}
									//---------------------------------------------
									//-----------------------------------------------------------
									$files111234 = scandir($src22123);
									// print_r($files1);
									if($files111234 != NULL){
									foreach($files111234 as $file21234){
									  // echo "<br>".$file2;
										 if(!is_dir("$Company_name/$file/$file2/$file21/$file212/$file2123/$file21234")){
										 mkdir("$Company_name/$file/$file2/$file21/$file212/$file2123/$file21234",0777,true);
										 chmod("$Company_name/$file/$file2/$file21/$file212/$file2123/$file21234",0755);
										}
										$src221234 = "$src/$file/$file2/$file21/$file212/$file2123/$file21234";
										$dirPath221234 = "$dirPath/$file/$file2/$file21/$file212/$file2123/$file21234";
										$files221234 = glob("$src/$file/$file2/$file21/$file212/$file2123/$file21234/*.*");
										if($files221234 != NULL){
										foreach($files221234 as $file331234){
											$file_to_go331234 = str_replace($src221234,$dirPath221234,$file331234);
											copy($file331234, $file_to_go331234);
											// chmod("$Company_name/$file/$file2",0755);
												}
											}
										}
									}
									
								}
								}
								
							}
							}
					}

				//***********************Copy htaccess **************************	
					$Base_url = FCPATH.$Company_name;
					echo '<br><br>Base_url :: '.$Base_url;
					$srcfile=FCPATH."$src/htaccessFile/.htaccess";
					$dstfile="$Base_url/.htaccess";
					// mkdir(dirname($dstfile), 0777, true);
					copy($srcfile, $dstfile);
					echo "<br><br>srcfile :: ".$srcfile;
					echo "<br><br>dstfile :: ".$dstfile;
					
					//***********************cHANGE htaccess **************************
				
				
				$str223=file_get_contents($dstfile);
				$str223=str_replace("SAASCOMPANYNAME", "$Company_name",$str223);
				file_put_contents($dstfile, $str223); 	
				
				//***********************cHANGE Config Settings**************************
				$str=file_get_contents($Base_url.'/application/config/config.php');
				
				$str=str_replace("$src", "$Company_name",$str);
				file_put_contents($Base_url.'/application/config/config.php', $str); 
				
				//***********************cHANGE htaccess **************************/
				
				
				$post_dataz = array(
					'Saas_company_flag' => 1
				);
				$Update = $this->Saas_model->Update_saas_company($Company_id,$post_dataz);
				if($Update){echo '<br><br>Update_saas_company';}else{echo '<br><br>Not Update_saas_company';}
		//**************************CUSTOMER App END---------------------------	
			//**********************************************************************************	
					// die;
			$Email_content = array(
				  'Notification_type' => 'Welcome '.$Company_Records["Company_name"].'. Be inspired & Lets get started!',
				  'Company_name' => $Company_Records['Company_name'],
				  'Company_primary_contact_person' => $Company_primary_contact_person,
				  'Company_primary_email_id' => $Company_primary_email_id,
				  'Domain_name' => $Domain_name,
				  'User_pwd' => $Company_password,
				   'Seller_licences_limit' => $Seller_licences_limit,
				   'Redemptionratio' => $Redemptionratio,
				   'Joining_bonus_points' => $Joining_bonus_points,
				   'Currency_name' => $Currency_name,
				   'Loyalty_Rule' => $Loyalty_Rule,
				   'Loyalty_name' => $Loyalty_name,
				   'Coverted_pts' => $Coverted_AMT,
				   'Refferral_points' => $Refferral_points,
				   'Loyalty_at_transaction' => $Loyalty_at_transaction,
				   'Outlet_tbl' => $Outlet_tbl,
				   'Company_License' => $Company_License,
				   'Notification_No' => 2,
				  'Template_type' => 'Saas_company_registration'
			  );
		  
			$this->send_notification->send_Notification_email(0, $Email_content, 0, $Company_id);
			//**********************************************************************************
		
		}
	}
	
	function check_userdata()
	{
		$result = $this->Saas_model->check_userdata($this->input->post("inpData"),$this->input->post("flag"));
		
		if($result > 0)
		{
			$this->output->set_output('1');
		}
		else    
		{
			$this->output->set_output('0');
		}
	}

	/********************************AMIT End 17-11-2017*************************************/
	function edit_saas_company()
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
			
			
			$data['License_type'] = $this->Saas_model->Get_Code_decode_master(20);
		
			
			$data['record'] = $this->Saas_model->edit_SAAS_company($Company_id);
			$data['States_array'] = $this->Igain_model->Get_states($data['record']->Country);	
			$data['City_array'] = $this->Igain_model->Get_cities($data['record']->State);	
			$this->load->view('Saas_company/edit_saas_company', $data);
			
				
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function UpgradePlan()
	{	
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Company_License_type = $session_data['Company_License_type'];
			$Create_user_id = $data['enroll'];
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			
			// $data['Company_License_type'] = $_SESSION['Company_License_type'];
			$Compnay_details = $this->Igain_model->get_company_details($Company_id);
			$data['Company_License_type'] = $Compnay_details->Company_License_type;	
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$enroll_country_id = $enroll_details->Country;
			$currency_details = $this->Igain_model->Get_Country_master($enroll_country_id);
            $data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			
			$License_details = $this->Saas_model->Get_saas_license_details();
			foreach($License_details as $License_details)	
			{
				if($License_details->License_type_id==121)//Basic
				{
					$data['Basic_limit'] = $License_details->Member_limit;
				}
				if($License_details->License_type_id==253)//Standard
				{
					$data['Standard_limit'] = $License_details->Member_limit;
					$data['Standard_Monthly_Price'] = $License_details->Monthly_price;
				}
				
				if($License_details->License_type_id==120)//Enhance
				{
					$data['Enhance_limit'] = $License_details->Member_limit;
					$data['Enhance_Monthly_Price'] = $License_details->Monthly_price;
				}
			}
			if($this->session->userdata('Payment_session'))
			{
				$Todays_date = date('Y-m-d');
				
				$session_data2 = $this->session->userdata('Payment_session');
				
				$Razorpay_payment_id = $session_data2['Razorpay_payment_id'];
				
				$Payment_details = $this->Saas_model->Get_payment_details($Razorpay_payment_id,$Company_id);
				if($Payment_details != Null)
				{	
					if($Payment_details->Payment_status =="captured")
					{
						$resultis = $this->Igain_model->get_company_details(1);
						
						$Saas_export_bill_no = $resultis->Saas_export_bill_no;
						$Saas_sgst_bill_no = $resultis->Saas_sgst_bill_no;
						$Saas_igst_bill_no = $resultis->Saas_igst_bill_no;
						
						$Saas_sgst_bill_no++;
						$Saas_igst_bill_no++;
						$Saas_export_bill_no++;
						
						$Payment_country = $Payment_details->Country_name;
						$Payment_state = $Payment_details->State_name;
						$Merchant_order_id = $Payment_details->Merchant_order_id;
						
						if($Payment_country == 'India')
						{
							if($Payment_state == 'Maharashtra')
							{
								$post_dataMaha = array('Bill_no' => $Saas_sgst_bill_no); 
								
								$UpdatePayment = $this->Saas_model->Update_payment_details($Merchant_order_id,$post_dataMaha);
	
								$post_datax = array(
									'Saas_sgst_bill_no' => $Saas_sgst_bill_no,
									'Update_user_id' => $Create_user_id,
									'Update_date_time' => date('Y-m-d H:i:s')
										);
								$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
							}
							else
							{
								$post_dataN = array('Bill_no' => $Saas_igst_bill_no); 
								
								$UpdatePayment = $this->Saas_model->Update_payment_details($Merchant_order_id,$post_dataN);
								
								$post_datax = array(
									'Saas_igst_bill_no' => $Saas_igst_bill_no,
									'Update_user_id' => $Create_user_id,
									'Update_date_time' => date('Y-m-d H:i:s')
										);
								$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
							}
						}
						else
						{
							$post_dataU = array('Bill_no' => $Saas_export_bill_no); 
								
							$UpdatePayment = $this->Saas_model->Update_payment_details($Merchant_order_id,$post_dataU);
								
							$post_datax = array(
								'Saas_export_bill_no' => $Saas_export_bill_no,
								'Update_user_id' => $Create_user_id,
								'Update_date_time' => date('Y-m-d H:i:s')
									);
							$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
						}
						
						$data['Payment_details'] = $this->Saas_model->Get_payment_details($Razorpay_payment_id,$Company_id);
						
						$Enrollement_id = $data['Payment_details']->Enrollement_id;
						$Payment_email = $data['Payment_details']->Payment_email;
						$License_type = $data['Payment_details']->License_type;
						$Billing_country_name = $data['Payment_details']->Country_name;
						$Invoice_no = $data['Payment_details']->Bill_no;
						
						$date1=date_create($data['Payment_details']->Bill_date);
						$data['Invoice_date'] = date_format($date1,"d-M-Y");
						
						$date2=date_create($data['Payment_details']->Pyament_expiry_date);
						$data['Valid_till'] = date_format($date2,"d M Y");  
						
						if($Billing_country_name == "India")
						{
							$data["Symbol_currency"] = "INR";
							$Currency_alies = "INDIAN RUPEES";
						}
						else
						{
							$data["Symbol_currency"] = "USD";
							$Currency_alies = "US DOLLAR";
						}
						if($License_type == 120)
						{
							$data['License'] = "Enhance";
						}
						else if($License_type == 121)
						{
							$data['License'] = "Basic";
						}
						else if($License_type == 253)
						{
							$data['License'] = "Standard";
						}
						
						$Bill_amaount_in_word = $this->convert_number($data['Payment_details']->Bill_amount);
						
						$data['Bill_amaount_in_word'] = $Currency_alies.' '.$Bill_amaount_in_word.' only';
						
						$Compnay_details = $this->Igain_model->get_company_details($Company_id);
		
						$data['Company_name'] = $Compnay_details->Company_name;	
						$data['Company_License_type'] = $Compnay_details->Company_License_type;	
						
						$data['Application_name'] = "iGainspark SaaS Loyalty";
						
					/**********************************************************************/
						ob_start();
						$htmlBill = $this->load->view('Saas_company/pdf_saas_billing_invoice', $data, true);
						// echo $htmlBill; 
						
						$Bill_filename = $data['Company_name'].'_'.$Invoice_no.'_'.date('Y_m_d_H_i_s');
						
						$billing_file_path = "";
						
						$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
						 
						$pdf = new mPDF();
						  //$pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);
						$pdf->showImageErrors = true;
						$pdf->WriteHTML($htmlBill);
						/*$pdf->Output($Bill_filename . '.pdf', 'D');
						  unset($pdf);
						  die; */
						 // $pdf->setFooter('{PAGENO}');
						$billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf', 'F');
						$pdf->Output($DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf', 'F');
						$billing_file_path = $DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf';
						unset($pdf);
					/**********************************************************************/
						 $Email_content = array(
						  'Todays_date' => $Todays_date,
						  'Seller_name' => $data['LogginUserName'],
						  'Payment_email' => $Payment_email,
						  'Company_name' => $data['Company_name'],
						  'Application_name' => $data['Application_name'],
						  'Symbol_currency' => $data['Symbol_currency'],
						  'License' => $data['License'],
						  'Saas_billing_file_path' => $billing_file_path,
						  'Notification_type' => 'Thank you for the payment',
						  'Template_type' => 'Saas_company_billing'
					  );

						$Notification = $this->send_notification->send_Notification_email($Enrollement_id, $Email_content, $data['enroll'], $Company_id);

						$post_dataX = array(
							'Email_sent' => 1
						);
					
						$Update_invoice = $this->Saas_model->Update_invoice_status($Enrollement_id,$Company_id,$Razorpay_payment_id,$post_dataX);
						
						$this->session->set_flashdata("success_code", $data['Payment_details']->Description);
						
					}
					else
					{
						$this->session->set_flashdata("error_code", $Payment_details->Description);
					}
				}
			}			
			//print_r($session_data2);
			$this->session->set_userdata('Payment_session', "");
			
			$this->load->view('Saas_company/UpgradePlan', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function verifyPayment()
	{
		if(empty($this->input->post('razorpay_order_id')) === false)
		{
			$razorpay_order_id = $this->input->post('razorpay_order_id'); 
		}
		else
		{
			foreach($this->input->post() as $key => $values) {
				
				$metadata = json_decode($values['metadata']);
				$razorpay_order_id = $metadata->order_id;
			}
		}
		
		$Payment_details = $this->Saas_model->Get_company_payment_details($razorpay_order_id);
		$Enrollement_id = $Payment_details->Enrollement_id;
		$Company_id = $Payment_details->Company_id;
		$data['New_license_type'] = $Payment_details->License_type;
		$data['Period'] = $Payment_details->Period;
		$data['Enrollement_id'] = $Enrollement_id;
		$data['Company_id'] = $Company_id;
		// echo $Company_id;die;
		$result = $this->Saas_model->Auto_login($Company_id,$Enrollement_id);
		
		if ($result)
		{	
          $sess_array = array();
          $User_id = 0;
          $Super_seller = 0;
          $Sub_seller_admin = 0;
          foreach ($result as $row) {
			$User_id = $row['User_id'];
            $Super_seller = $row['Super_seller'];
            $Sub_seller_admin = $row['Sub_seller_admin'];
				$sess_array = array('enroll' => $row['Enrollement_id'], 'username' => $row['User_email_id'], 'Country_id' => $row['Country_id'], 'userId' => $User_id, 'Super_seller' => $Super_seller, 'Company_name' => $row['Company_name'], 'Company_id' => $row['Company_id'], 'Login_Partner_Company_id' => $row['Company_id'], 'timezone_entry' => $row['timezone_entry'], 'Full_name' => $row['First_name'] . " " . $row['Middle_name'] . " " . $row['Last_name'], 'Count_Client_Company' => $row['Count_Client_Company'], 'card_decsion' => $row['card_decsion'], 'next_card_no' => $row['next_card_no'], 'Seller_licences_limit' => $row['Seller_licences_limit'], 'Seller_topup_access' => $row['Seller_topup_access'], 'Current_balance' => $row['Current_balance'], 'Allow_membershipid_once' => $row['Allow_membershipid_once'], 'Allow_merchant_pin' => $row['Allow_merchant_pin'], 'Sub_seller_admin' => $Sub_seller_admin, 'pinno' => $row['pinno'], 'smartphone_flag' => '2', 'Sub_seller_Enrollement_id' => $row['Sub_seller_Enrollement_id'], 'Membership_redirection_url' => $row['Membership_redirection_url'], 'Localization_flag' => $row['Localization_flag'], 'Localization_logo' => $row['Localization_logo'], 'Company_License_type' => $row['Company_License_type'], 'Comp_regdate' => $row['Comp_regdate']);
				
				$this->session->set_userdata('logged_in', $sess_array);
			}
		}
		
		$resultis = $this->Igain_model->get_company_details($Company_id);
		
		$data['Company_License_type'] = $resultis->Company_License_type;
		
		$data['base_url'] =  base_url();
		
		$data['response'] = $this->input->post();
		
		$this->load->view('rozarpay/verify', $data);
	}
	
	function License_billing()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Company_License_type = $session_data['Company_License_type'];
			$Create_user_id = $data['enroll'];
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			// $_SESSION['Session_Company_License_type'] = $Company_License_type;
			// echo "Company_License_type $Company_License_type";
			$data['Company_License_type'] = $_SESSION['Session_Company_License_type'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$data['Records'] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
			$dial_code = $this->Igain_model->get_dial_code($data['Records']->Country_id);
			$exp=explode($dial_code,App_string_decrypt($data['Records']->Phone_no));
			$data['phnumber'] = $exp[1];
			
			$currency_details = $this->Igain_model->Get_Country_master($data['Records']->Country_id);
			//$data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			$data['Country_name'] = $currency_details->name;
			
			if($_POST != NULL)
			{
				$Required_filed = array(
					array(
							'field' => 'First_name',
							'label' => 'Name',
							'rules' => 'required'
					),
					array(
							'field' => 'Last_name',
							'label' => 'Name',
							'rules' => 'required'
					),
					array(
							'field' => 'Email',
							'label' => 'Email',
							'rules' => 'required'
					),
					array(
							'field' => 'Phone_no',
							'label' => 'Phone_no',
							'rules' => 'required'
					),
					array(
							'field' => 'Country_name',
							'label' => 'Country_name',
							'rules' => 'required'	
					),
					array(
							'field' => 'Business_address',
							'label' => 'Business_address',
							'rules' => 'required'	
					)
				);
				
				$this->form_validation->set_rules($Required_filed);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("error_code","Please Fill Up Required Fileds");
					redirect('Register_saas_company/UpgradePlan', 'refresh');	
				}
				else if($this->form_validation->run() == TRUE)
				{
					$First_name = strip_tags($_REQUEST['First_name']);
					$Last_name = strip_tags($_REQUEST['Last_name']);
					$User_email = strip_tags($_REQUEST['Email']);
					$User_phone = strip_tags($_REQUEST['Phone_no']);
					$Country_name = strip_tags($_REQUEST['Country_name']);
					$Bill_amount = strip_tags($_REQUEST['Bill_amount']);
					$Selected_Period = strip_tags($_REQUEST['Period']);
					$State_name = strip_tags($_REQUEST['State_name']);
					$Business_address = strip_tags($_REQUEST['Business_address']);
					$Business_GST_No = strip_tags($_REQUEST['Business_GST_No']);
					$New_License_type = $_REQUEST['NewCompany_License_type'];
					$NewCompany_License_type = App_string_decrypt($New_License_type);
					
					if (!filter_var($User_email, FILTER_VALIDATE_EMAIL)) {
					  $this->session->set_flashdata("error_code","Please Enter Valid Email Address");
					  redirect('Register_saas_company/UpgradePlan', 'refresh');	
					}
					$checkPhone = is_numeric($User_phone);
					if($checkPhone !=1)
					{
						$this->session->set_flashdata("error_code","Please Enter Valid Phone Number");
						 redirect('Register_saas_company/UpgradePlan', 'refresh');		
					}
					if(strlen($User_phone) != 10)
					{
						$this->session->set_flashdata("error_code","Please Enter 10 digit Mobile No.");
						redirect('Register_saas_company/UpgradePlan', 'refresh');	
					}
					if($data['Country_name']!= $Country_name)
					{
						$this->session->set_flashdata("error_code","Please Select Valid Country");
						redirect('Register_saas_company/UpgradePlan', 'refresh');	
					}
					$Period_array = array('30','90','180','365');
					if (!in_array($Selected_Period, $Period_array))
					{
						$this->session->set_flashdata("error_code","Please Choose Valid Payment Option");
						redirect('Register_saas_company/UpgradePlan', 'refresh');	
					}
					$License_type_array = array('120','121','253');
					if (!in_array($NewCompany_License_type, $License_type_array))
					{
						$this->session->set_flashdata("error_code","Incorrect Company License type");
						redirect('Register_saas_company/UpgradePlan', 'refresh');	
					}
					
					$resultis = $this->Igain_model->get_company_details(1);
					
					$Bill_no = $resultis->Payment_bill_no;
					
					 $Bill_no++;
						
					$License_details = $this->Saas_model->Get_saas_license_details();
					// echo 'NewCompany_License_type '.$_REQUEST['NewCompany_License_type'];
					foreach($License_details as $License_details)	
					{
						if($License_details->License_type_id==$NewCompany_License_type)
						{
							$data['Standard_limit'] = $License_details->Member_limit;
							$data['Standard_Monthly_Price'] = $License_details->Monthly_price;
							$Monthly_price = $License_details->Monthly_price;
							$data['Standard_Annually_discount'] = $License_details->Annually_discount;
							$Annually_discount = $License_details->Annually_discount;
							$data['Standard_Indian_monthly_price'] = $License_details->Indian_monthly_price;
							$Indian_monthly_price = $License_details->Indian_monthly_price;
							$LicenseCGST = $License_details->CGST;
							$LicenseSGST = $License_details->SGST;
							$LicenseIGST = $License_details->IGST;
							$LicenseIndian_monthly_base_price = $License_details->Indian_monthly_base_price;
							// echo $LicenseIndian_monthly_base_price;die;
						}
					}
					
					if($Selected_Period==30)
					{
						$Period=1;
						$Pyament_expiry_date = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+30 day'));
					}
					if($Selected_Period==90)
					{
						$Period=3;
						$Pyament_expiry_date = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+90 day'));
					}
					if($Selected_Period==180)
					{
						$Period=6;
						$Pyament_expiry_date = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+180 day'));
					}
					if($Selected_Period==365)
					{
						$Period=12;
						$Pyament_expiry_date = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+365 day'));
					}
					
					
					$Discount_percentage=0;
					$Discount_value=0;
					
					if($Country_name=='India')
					{
						if($State_name=='Maharashtra')
						{
							$IGST=0;
							$LicenseIGST=0;
							$Base_price=($Indian_monthly_price*$Period)/(1+($LicenseCGST/100)+($LicenseSGST/100));
							
							if($Period==12){
								
								$Discount_percentage=$Annually_discount;
								$Discount_value=(($Indian_monthly_price*$Annually_discount)/100)*$Period;
								
								$Base_price=$Base_price-(($Base_price*$Annually_discount)/100);
								
								
								$Indian_monthly_price=$Indian_monthly_price-(($Indian_monthly_price*$Annually_discount)/100);
								// $Indian_monthly_price = (floor($Indian_monthly_price*100)/100);
							}
							
							// $Base_price=number_format(($Base_price),2);
							$CGST=(($Base_price*$LicenseCGST)/100);
							$SGST=(($Base_price*$LicenseSGST)/100);
							
							$X=	($Indian_monthly_price*$Period);	
							$Y=($Base_price+$CGST+$SGST);
							$Rounding_off=number_format(($X-$Y),2);
						}
						else
						{
							$CGST=0;
							$SGST=0;
							$LicenseCGST=0;
							$SGST_Percenatge=0;
							$LicenseSGST=0;
							$LicenseCGST=0;
							
							// $Base_price=$LicenseIndian_monthly_base_price*$Period;
							$Base_price=($Indian_monthly_price*$Period)/(1+($LicenseIGST/100));
							// $Base_price = (floor($Base_price*100)/100);
							if($Period==12){
								
								$Discount_percentage=$Annually_discount;
								$Discount_value=(($Indian_monthly_price*$Annually_discount)/100)*$Period;
								
								$Base_price=$Base_price-(($Base_price*$Annually_discount)/100);
								
								$Indian_monthly_price=$Indian_monthly_price-(($Indian_monthly_price*$Annually_discount)/100);
								// $Indian_monthly_price = (floor($Indian_monthly_price*100)/100);	
							}
							
							$IGST=(($Base_price*$LicenseIGST)/100);
							// $IGST = (floor($IGST*100)/100);
							
							// $Bill_no=$Saas_igst_bill_no;
							
							$X=	($Indian_monthly_price*$Period);	
							$Y=($Base_price+$IGST);
							$Rounding_off=number_format(($X-$Y),2);
						}
						if(strlen($Business_GST_No) <15 )
						{
							// $Business_GST_No='-';
						}
					}
					else
					{
						//$Bill_no=$Saas_export_bill_no;
							$CGST=0;
							$SGST=0;
							$IGST=0;
							$LicenseSGST=0;
							$LicenseCGST=0;
							$LicenseIGST=0;
							$Rounding_off=0;
							$Discount_percentage=0;
							$Discount_value=0;
							$Base_price=$Monthly_price*$Period;
						if($Period==12){
							$Base_price=(($Monthly_price*12)-(($Monthly_price*12*$Annually_discount)/100));
							$Discount_percentage=$Annually_discount;
							$Discount_value=(($Monthly_price*$Annually_discount)/100)*$Period;
						}
						
						// $State_name='-';
						// $Business_GST_No='-';
					}
					
						if($Period ===12)
						{
							if($Country_name=='India')
							{
								$Bill_amount=$Indian_monthly_price*$Period;
							}
							else
							{
								$Bill_amount=(($Monthly_price*12)-(($Monthly_price*12*$Annually_discount)/100));
							} 
						}
						else
						{  
							if($Country_name=='India')
							{
								$Bill_amount=$Indian_monthly_price*$Period;
							}
							else
							{
								$Bill_amount=$Monthly_price*$Period;
							}
						}
				
					
						$post_dataxBill_no = array(
							'Payment_bill_no' => $Bill_no,
							'Update_user_id' => $Create_user_id,
							'Update_date_time' => date('Y-m-d H:i:s')
								);
							$Update = $this->Saas_model->Update_saas_company(1,$post_dataxBill_no); 
					
					
					
						  // $Bill_amount = $_REQUEST['Bill_amount'];
						  $Bill_amount = str_replace( ',', '', $Bill_amount);
					
					/*******************payment details for razorpay********************/
						$base_url =  base_url();
						$data['name'] = $_REQUEST['First_name'].' '.$_REQUEST['Last_name'];
						$data['email'] = $_REQUEST['Email'];
						$data['contact'] = $_REQUEST['Phone_no'];
						$data['currency'] = $_REQUEST['currency'];
						$data['address'] = $_REQUEST['Business_address'];
						$data['order_no'] = $Bill_no;
						$data['amount'] = $Bill_amount;
						$data['company_id'] = $Company_id;
						$data['enrollement_id'] = $data['enroll']; 
						$data['Period'] = $Selected_Period;
						$data['Pyament_expiry_date'] = $Pyament_expiry_date;
						$data['callback_url'] = $base_url.'index.php/Register_saas_company/verifyPayment';
						
						if($NewCompany_License_type == 121){ 
							$Plan_name = "Basic"; 
						}
						else if($NewCompany_License_type == 120){
							$Plan_name = "Enhance"; 
						}
						else if($NewCompany_License_type == 253){
							$Plan_name = "Standard";
						}
						else{
							$Plan_name = " ";
						}
						$data['Plan_name'] = $Plan_name;
					/*******************payment details for razorpay********************/
					$Bill_amount_INR = $Bill_amount;
					if($Country_name!='India')
					{	
						// $Bill_amount_INR = ($Bill_amount*$_REQUEST['Conversion_INR']);
						$Conversion_INR = $this->Saas_model->convert_currency('INR');
						$Bill_amount_INR = ($Bill_amount*$Conversion_INR);
					}
						$Payment_data = array(
						'Company_id' => $Company_id,
						'Enrollement_id' => $data['enroll'],
						'Merchant_order_id' => $Bill_no,
						'Bill_amount' => $Bill_amount,
						'Bill_amount_INR' => $Bill_amount_INR,
						'License_type' => $NewCompany_License_type,
						'Period' => $Selected_Period,
						'Country_name' => $Country_name,
						'State_name' => $State_name,
						'Business_address' => $Business_address,
						'Business_GST_No' => $Business_GST_No,
						'CGST' => $CGST,
						'SGST' => $SGST,
						'IGST' => $IGST,
						'CGST_Percenatge' => $LicenseCGST,
						'SGST_Percenatge' => $LicenseSGST,
						'IGST_Percenatge' => $LicenseIGST,
						'Base_price' => $Base_price,
						'Discount_percentage' => $Discount_percentage,
						'Discount_value' => $Discount_value,
						'Rounding_off' => $Rounding_off,
						'Bill_date' => date('Y-m-d H:i:s'),
						'Pyament_expiry_date' => $Pyament_expiry_date,
						'Sac_code' => "997331"
					);
					
					$Insert = $this->Saas_model->insert_saas_company_payment($Payment_data);
					
					// $_SESSION["Expiry_license"] = $_REQUEST['Pyament_expiry_date'];
					
					$char = 'upgraded';
					if($_SESSION['Session_Company_License_type'] == $NewCompany_License_type)
					{
						$char = 'renewed';
					}
					if($_SESSION['Session_Company_License_type'] < $NewCompany_License_type)
					{
						$char = 'subscribe';
					}
					
					if($_SESSION['Session_Company_License_type'] == 121)//Basic
					{
						$char = 'upgraded';
					}
					$this->load->view('rozarpay/pay', $data);
				}
			}
			else
			{	
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
				$data['Enrollement_id'] = $session_data['enroll'];
				$Enrollement_id = $data['Enrollement_id'];
				$data['Records'] = $this->Igain_model->get_enrollment_details($Enrollement_id);
				$FetchedCountrys = $this->Igain_model->FetchCountry();	
				$data['Country_array'] = $FetchedCountrys;	
				
				
				$data['States_array'] = $this->Igain_model->Get_states($data['Records']->Country_id);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['Records']->State);
				$currency_details = $this->Igain_model->Get_Country_master($data['Records']->Country_id);
				$data['Symbol_currency'] = $currency_details->Symbol_of_currency;
				 
				$License_details = $this->Saas_model->Get_saas_license_details();
				foreach($License_details as $License_details)	
				{
					if($License_details->License_type_id==121)//Basic
					{
						$data['Basic_limit'] = $License_details->Member_limit;
					}
					if($License_details->License_type_id==253)//Standard
					{
						$data['Standard_limit'] = $License_details->Member_limit;
						$data['Standard_Monthly_Price'] = $License_details->Monthly_price;
						$data['Standard_Annually_discount'] = $License_details->Annually_discount;
						$data['Standard_Indian_monthly_price'] = $License_details->Indian_monthly_price;
					}
					
					if($License_details->License_type_id==120)//Enhance
					{
						$data['Enhance_limit'] = $License_details->Member_limit;
						$data['Enhance_Monthly_Price'] = $License_details->Monthly_price;
						$data['Enhance_Annually_discount'] = $License_details->Annually_discount;
						$data['Enhance_Indian_monthly_price'] = $License_details->Indian_monthly_price;
					}
				}
				if(isset($_REQUEST['Standard']))
				{
					$data['Monthly_Price'] = $data['Standard_Monthly_Price'];
					$data['License_Discount'] =$data['Standard_Annually_discount'];
					$data['Indian_monthly_price'] = $data['Standard_Indian_monthly_price'];
					
					$data['NewCompany_License_type'] = App_string_encrypt(253);
				}			
				else if(isset($_REQUEST['Enhance']))
				{
					$data['Monthly_Price'] = $data['Enhance_Monthly_Price'];
					$data['License_Discount'] =$data['Enhance_Annually_discount'];
					$data['Indian_monthly_price'] = $data['Enhance_Indian_monthly_price'];
					$data['NewCompany_License_type'] = App_string_encrypt(120);
				}
				else
				{
					$this->session->set_flashdata("error_code","Invalid data provided");
					redirect('Register_saas_company/UpgradePlan', 'refresh'); 
				}
				
				$data['Payment_record'] = $this->Saas_model->Get_license_payment_record($Company_id);		
				
				$this->load->view('Saas_company/License_billing', $data);
			}		
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function Verify_email()
	{
		
		
		/** *************oWNER*pASSWORD GENERATE*************** */
								  $characters = '123456';
								  $string = '';
								  $Verification_code = "";
								  for ($i = 0; $i < 6; $i++) {
									$Verification_code .= $characters[mt_rand(0, strlen($characters) - 1)];
								  }
			$_SESSION['Verification_code']=App_string_encrypt($Verification_code);					 
			// echo 'XXXVerification_code  '.$_SESSION['Verification_code'];					  
			$Email_content = array(
				  'Notification_type' => 'Your Verification Code is '.$Verification_code,
				  'email' => $_REQUEST['email'],
				  'Verification_code' => $Verification_code,
				  'Template_type' => 'Saas_company_email_verification'
			  );
		  if($Verification_code!=''){
			$this->send_notification->send_Notification_email(0, $Email_content, 0, 1);
		  }
		
			$_SESSION['Input_email']=$_REQUEST['email'];
			
			$this->output->set_content_type('application/json');
			
			$this->output->set_output(json_encode(array('Verification_code'=> $_SESSION['Verification_code'])));
			
			// $this->output->set_output(json_encode(array('Verification_code'=> $_SESSION['Verification_code'],'Verification_code2'=> $Verification_code)));
			
			//**********************************************************************************	
	}
	
	function Verify_emailCode()
	{
		// echo "<br>INPCODE ".$_REQUEST['INPCODE'];
		// echo "<br>Verification_code ".$_SESSION['Verification_code'];
		$Verified_flag=0;
		$Decrypt_Verification_code = App_string_decrypt($_SESSION['Verification_code']);
		// echo $_SESSION['Verification_code'];
		if($_REQUEST['INPCODE']==$Decrypt_Verification_code)
		{
			$Verified_flag=1;
		}
		
			
			$this->output->set_content_type('application/json');
			
			$this->output->set_output(json_encode(array('Verified_flag'=> $Verified_flag)));
			//**********************************************************************************	
	}
	function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= " " . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }	
	

	
	
}
?>