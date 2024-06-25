<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();		
		$this->load->helper(array('form', 'url','encryption_val'));
		$this->load->model('login/Login_model');
		$this->load->model('Users_model');
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library("Excel");
		$this->load->library('m_pdf');
		$this->load->library('Send_notification');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->model('shopping/Shopping_model');
		$this->load->library('cart');
		$this->load->model('General_setting_model');
	}	
    public function index()
    {
			
		/*				
			http://localhost/novacomonline_local/artcaffeAppnew/index.php/login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2020&login_logout=0&flag=1			
			http://localhost/novacomonline/artcaffeAppnew/index.php/login?username=raviphad1988@gmail.com&company_id=8&password=Ravi@2020&login_logout=0&flag=1
			http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2020&login_logout=0&flag=1
			
			http://ehpdemo.online/kukitoApp/index.php/login?username=ravip@miraclecartes.com&company_id=3&password=Ravi@2020&login_logout=0&flag=1
					
			http://ehp.online/kukitoApp/index.php/login?username=ravip@miraclecartes.com&company_id=3&password=Ravi@2019&login_logout=0&flag=1
			
			http://ehpdemo.online/artcaffeAppnew/index.php/login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2020&login_logout=0&flag=1
			http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/Cust_home/forgot_password_smart_phone?Company_id=8&flag=1&email=amitk@miraclecartes.com
			
			http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/login?username=amitk@miraclecartes.com&company_id=8&password=Amit@2020&login_logout=0&flag=1 							
			http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2020&login_logout=0&flag=1&Walking_customer=0
			
			http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/login/smart_phone_login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2019&login_logout=0&flag=1&Walking_customer=0					
					
			http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/Cust_home/Create_Account_smart_phone?company_id=8&firstName=NewCustmer&last_name=Phad&userEmailId=ravip@miraclecartes&phone_no=9561970954&dob=2020-01-13&login_logout=0&flag=1			
			
		*/
		
		
		
		
		$Walkingcustomer=0;
		$email=$_REQUEST['username'];
		$CompanyID=$_REQUEST['company_id'];
		$password=$_REQUEST['password'];
		$login_logout =$_REQUEST['login_logout'];
		$flag =$_REQUEST['flag'];		
		
		/*--------------Encripted & Decrypted------------------------------------------*/
			$enc_email = App_string_encrypt($email); //echo "--enc_email--".$enc_email. PHP_EOL;
			$dec_email = App_string_decrypt($enc_email); //echo "--dec_email--".$dec_email. PHP_EOL;
			
			$enc_password = App_string_encrypt($password); //echo "--enc_email--".$enc_email. PHP_EOL;
			$dec_password = App_string_decrypt($enc_password); //echo "--dec_password--".$dec_password. PHP_EOL;		
		/*--------------Encripted & Decrypted------------------------------------------*/
		
		// echo "--enc_email--".$enc_email. PHP_EOL;
		// echo "--enc_password--".$enc_password. PHP_EOL;
		
		
		if($_REQUEST['Walking_customer'] != ""){
			$Walking_customer =$_REQUEST['Walking_customer'];
		} else {
			$Walking_customer =$Walkingcustomer;
		}
		
		$this->cart->destroy();
		if($flag  == 1) //APK
		{	
			
			$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($CompanyID);
			$timezone_entry=$Super_Seller_details->timezone_entry;			
			$logtimezone = $timezone_entry;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
				
			$result = $this->Login_model->customer_login($enc_email,$enc_password,$CompanyID,$flag);	
			// var_dump($result);
			// die;
			if($result)				
			{
				$sess_array = array();
				foreach($result as $row)
				{							
					$sess_array = array(
						'enroll' => $row['Enrollement_id'],
						'username' => $row['User_email_id'],
						'Country_id' => $row['Country_id'],
						'userId'=>$row['User_id'],
						'Company_name'=>$row['Company_name'],
						'Company_id'=>$row['Company_id'],
						'Card_id'=>$row['Card_id'],
						'timezone_entry'=>$row['timezone_entry'],
						'Full_name'=>$row['First_name']."".$row['Middle_name']."".$row['Last_name'],
						'smartphone_flag' => '1',
						'Walking_customer' => $Walking_customer
					);					
					$this->session->set_userdata('cust_logged_in', $sess_array);
					$Loggin_User_id = $row['User_id'];
					$Enrollment_id = $row['Enrollement_id'];
					$Company_id = $row['Company_id'];
					$userId = $row['User_id'];
					$userName = $row['User_email_id'];
					$timezone_entry = $row['timezone_entry'];
				}					
				if($Loggin_User_id == 1) //Customer
				{
					if($this->session->userdata('cust_logged_in'))
					{
						$Customer_details= $this->Igain_model->get_enrollment_details($Enrollment_id);	
						$Company_Details= $this->Igain_model->get_company_details($Company_id);	
						$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
						$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
						$seller_id=$Super_Seller_details->Enrollement_id;
						
						
						/* $Check_first_time_login = $this->Igain_model->first_time_login($Company_id,$userName,$Enrollment_id,$userId);	
								
						// echo"---Check_first_time_login-----".$Check_first_time_login."---<br>";
						// die;
						//$this->login_mail($session_data['enroll'],"APK");	
						if($Check_first_time_login == 0 )
						{						
							redirect('Cust_home/first_time_login');								
						}
						else
						{ */					
						
						
							$logtimezone = $timezone_entry;
							$timezone = new DateTimeZone($logtimezone);
							$date = new DateTime();
							$date->setTimezone($timezone);
							$lv_date_time=$date->format('Y-m-d H:i:s');
							$Todays_date = $date->format('Y-m-d');	
							
							
							/*---------------Insert into Session--Ravi 25-03-2018------------------*/
								$Insert_into_session = $this->Login_model->insert_into_session($Company_id,$userName,$Enrollment_id,$userId,$flag,$lv_date_time);
							/*---------------Insert into Session--Ravi 25-03-2018------------------*/
						
							$timezone_entry=$Super_Seller_details->timezone_entry;			
							$logtimezone = $timezone_entry;
							$timezone = new DateTimeZone($logtimezone);
							$date = new DateTime();
							$date->setTimezone($timezone);
							$lv_date_time=$date->format('Y-m-d H:i:s');
							$Todays_date = $date->format('Y-m-d');
							$top_db2 = $Super_Seller_details->Topup_Bill_no;
							$len2 = strlen($top_db2);
							$str2 = substr($top_db2,0,5);
							$tp_bill2 = substr($top_db2,5,$len2);						
							$topup_BillNo2 = $tp_bill2 + 1;
							$billno_withyear_ref = $str2.$topup_BillNo2;
							
							/*--------------------First time app login----------------------------*/						
							$Customer_profile_status= $this->Igain_model->Member_profile_status($Enrollment_id,$Company_id);
							// echo "--Customer_details->App_login_flag--".$Customer_details->App_login_flag. PHP_EOL;
							 // echo "--Company_Details->App_login_flag--".$Company_Details->App_login_flag. PHP_EOL;
							 // die;
							if($Customer_details->App_login_flag=='0' && $Company_Details->App_login_flag=='1')
							{
								$profile_status_flag= $this->Igain_model->Update_member_app_login_flag($Enrollment_id,$Company_id);
								//echo"--Get Bonus Complete--profile_status---<br>";						
								$Current_balance=$Customer_details->Current_balance;
								$Total_topup_amt=$Customer_details->Total_topup_amt;
								$total_purchase=$Customer_details->total_purchase;
								$Total_reddems=$Customer_details->Total_reddems;
								$Card_id=$Customer_details->Card_id;
                                                                
								$new_balance=$Current_balance+round($Company_Details->App_login_points);
								$New_Total_topup_amt=$Total_topup_amt+round($Company_Details->App_login_points);
								
								$post_Transdata = 
									array
										( 	
											'Trans_type' => '1',
											'Company_id' => $Company_id,
											'Topup_amount' =>round($Company_Details->App_login_points),        
											'Trans_date' => $lv_date_time,       
											'Remarks' => 'App login reward point',
											'Card_id' => $Card_id,
											'Seller_name' =>$Seller_name ,
											'Seller' => $seller_id,
											'Enrollement_id' => $Enrollment_id,
											'Bill_no' => $tp_bill2,
											'remark2' => 'Super Seller',
											'Loyalty_pts' => '0'
										);					
								
                                                                
                                                                
								$result6 = $this->Igain_model->insert_topup_details($post_Transdata);
								$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
								//$result3 = $this->Igain_model->update_seller_balance($Enrollment_id,$new_balance);
                                                                
									$up = array(
												'Current_balance' => $new_balance, 
												'total_purchase' => $total_purchase,
												'Total_topup_amt' => $New_Total_topup_amt,
												'Total_reddems' => $Total_reddems
												);			
								   $result3= $this->Shopping_model->update_cust_balance($up,$Card_id,$Company_id);
								
								
								$Email_content = array(
								'Login_bonus' => round($Company_Details->App_login_points),
								'Notification_type' => 'App login Reward Points',
								'Template_type' => 'App_login_reward'
								);
								$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'',$Company_id); 						
							}							
							/*--------------------First time app login----------------------------*/
							$session_data = $this->session->userdata('cust_logged_in');
							redirect('Cust_home/front_home');
							// redirect('Cust_home/dashboard');
							
							
							
						// }					
						
					}
					else
					{
						
						
						
		
						$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);			
						
						$error=0;
						echo $error;
					}
					
				}				
				else
				{
					
		
					$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
					$error=0;
					echo $error;
				}						
			}
			else
			{
				
						
				$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
				$error=0;
				echo $error;
				
			}			
		}
    }
	public function new_login()
    {      	
		
    	
		// http://localhost/novacomonline/artcaffeAppnew/index.php/login/new_login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2019&login_logout=0&flag=1&Walking_customer=1
		
		// http://localhost/novacomonline/artcaffeAppnew/index.php/login/new_login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2019&login_logout=0&flag=1
		
		
		// http://novacomonline.ehpdemo.online/artcaffeAppnew/index.php/login/new_login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2019&login_logout=0&flag=1&Walking_customer=1
		
		$Walkingcustomer=0;
		$email=$_REQUEST['username'];
		$CompanyID=$_REQUEST['company_id'];
		$password=$_REQUEST['password'];
		$login_logout =$_REQUEST['login_logout'];
		$flag =$_REQUEST['flag'];		
		// $Walking_customer =$_REQUEST['Walking_customer'];
		
		if($_REQUEST['Walking_customer'] != ""){
			$Walking_customer =$_REQUEST['Walking_customer'];
		} else {
			$Walking_customer =$Walkingcustomer;
		}
		
		
		/*--------------Encripted & Decrypted------------------------------------------*/
			$enc_email = App_string_encrypt($email); //echo "--enc_email--".$enc_email. PHP_EOL;
			$dec_email = App_string_decrypt($enc_email); //echo "--dec_email--".$dec_email. PHP_EOL;
			
			$enc_password = App_string_encrypt($password); //echo "--enc_email--".$enc_email. PHP_EOL;
			$dec_password = App_string_decrypt($enc_password); //echo "--dec_password--".$dec_password. PHP_EOL;		
		/*--------------Encripted & Decrypted------------------------------------------*/
		
		$this->cart->destroy();		
		if($flag  == 1) //APK
		{	
			$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($CompanyID);
			$timezone_entry=$Super_Seller_details->timezone_entry;			
			$logtimezone = $timezone_entry;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			
			
			$result = $this->Login_model->customer_login($enc_email,$enc_password,$CompanyID,$flag);
			if($result)				
			{
				$sess_array = array();
				foreach($result as $row)
				{							
					$sess_array = array(
						'enroll' => $row['Enrollement_id'],
						'username' => $row['User_email_id'],
						'Country_id' => $row['Country_id'],
						'userId'=>$row['User_id'],
						'Company_name'=>$row['Company_name'],
						'Company_id'=>$row['Company_id'],
						'Card_id'=>$row['Card_id'],
						'timezone_entry'=>$row['timezone_entry'],
						'Full_name'=>$row['First_name']."".$row['Middle_name']."".$row['Last_name'],
						'smartphone_flag' => '1',
						'Walking_customer' => $Walking_customer
					);					
					$this->session->set_userdata('cust_logged_in', $sess_array);
					$Loggin_User_id = $row['User_id'];
					$Enrollment_id = $row['Enrollement_id'];
					$Company_id = $row['Company_id'];
					$userId = $row['User_id'];
					$userName = $row['User_email_id'];
					$timezone_entry = $row['timezone_entry'];
				}					
				if($Loggin_User_id == 1) //Customer
				{
					if($this->session->userdata('cust_logged_in'))
					{
						$Customer_details= $this->Igain_model->get_enrollment_details($Enrollment_id);	
						$Company_Details= $this->Igain_model->get_company_details($Company_id);	
						$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
						$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
						$seller_id=$Super_Seller_details->Enrollement_id;
						
						
						/* $Check_first_time_login = $this->Igain_model->first_time_login($Company_id,$userName,$Enrollment_id,$userId);	
								
						//$this->login_mail($session_data['enroll'],"Browser");	
						
						if($Check_first_time_login == 0 && $Walking_customer == 0)
						{						
							redirect('Cust_home/first_time_login');								
						}
						else
						{ */				
						
						
							$logtimezone = $timezone_entry;
							$timezone = new DateTimeZone($logtimezone);
							$date = new DateTime();
							$date->setTimezone($timezone);
							$lv_date_time=$date->format('Y-m-d H:i:s');
							$Todays_date = $date->format('Y-m-d');	
							
							
							/*---------------Insert into Session--Ravi 25-03-2018------------------*/
								$Insert_into_session = $this->Login_model->insert_into_session($Company_id,$userName,$Enrollment_id,$userId,$flag,$lv_date_time);
							/*---------------Insert into Session--Ravi 25-03-2018------------------*/
						
							$timezone_entry=$Super_Seller_details->timezone_entry;			
							$logtimezone = $timezone_entry;
							$timezone = new DateTimeZone($logtimezone);
							$date = new DateTime();
							$date->setTimezone($timezone);
							$lv_date_time=$date->format('Y-m-d H:i:s');
							$Todays_date = $date->format('Y-m-d');
							$top_db2 = $Super_Seller_details->Topup_Bill_no;
							$len2 = strlen($top_db2);
							$str2 = substr($top_db2,0,5);
							$tp_bill2 = substr($top_db2,5,$len2);						
							$topup_BillNo2 = $tp_bill2 + 1;
							$billno_withyear_ref = $str2.$topup_BillNo2;
							
							/*--------------------First time app login----------------------------*/						
							$Customer_profile_status= $this->Igain_model->Member_profile_status($Enrollment_id,$Company_id);
							 
							if($Customer_details->App_login_flag=='0' && $Company_Details->App_login_flag=='1')
							{
								$profile_status_flag= $this->Igain_model->Update_member_app_login_flag($Enrollment_id,$Company_id);
								// echo"--Get Bonus Complete--profile_status---<br>";						
								$Current_balance=$Customer_details->Current_balance;
								$Total_topup_amt=$Customer_details->Total_topup_amt;
								$total_purchase=$Customer_details->total_purchase;
								$Total_reddems=$Customer_details->Total_reddems;
								$Card_id=$Customer_details->Card_id;
                                                                
								$new_balance=$Current_balance+round($Company_Details->App_login_points);
								$New_Total_topup_amt=$Total_topup_amt+round($Company_Details->App_login_points);
								
								$post_Transdata = 
									array
										( 	
											'Trans_type' => '1',
											'Company_id' => $Company_id,
											'Topup_amount' =>round($Company_Details->App_login_points),        
											'Trans_date' => $lv_date_time,       
											'Remarks' => 'App login reward point',
											'Card_id' => $Card_id,
											'Seller_name' =>$Seller_name ,
											'Seller' => $seller_id,
											'Enrollement_id' => $Enrollment_id,
											'Bill_no' => $tp_bill2,
											'remark2' => 'Super Seller',
											'Loyalty_pts' => '0'
										);					
								
                                                                
                                                                
								$result6 = $this->Igain_model->insert_topup_details($post_Transdata);
								$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
								//$result3 = $this->Igain_model->update_seller_balance($Enrollment_id,$new_balance);
                                                                
								$up = array(
											'Current_balance' => $new_balance, 
											'total_purchase' => $total_purchase,
											'Total_topup_amt' => $New_Total_topup_amt,
											'Total_reddems' => $Total_reddems
											);			
							   $result3= $this->Shopping_model->update_cust_balance($up,$Card_id,$Company_id);
								
								
								$Email_content = array(
								'Login_bonus' => round($Company_Details->App_login_points),
								'Notification_type' => 'App login Reward Points',
								'Template_type' => 'App_login_reward'
								);
								$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'',$Company_id); 						
							}							
							/*--------------------First time app login----------------------------*/
							$session_data = $this->session->userdata('cust_logged_in');
							// redirect('Cust_home/home');
							if($Walking_customer == 0){
								redirect('Cust_home/front_home');
								// redirect('Cust_home/dashboard');
							} else {
								redirect('shopping');
							}
							
							
						// }					
						
					}
					else
					{
						/* $error=0;
						echo $error; */
						$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
						echo json_encode(array("status" => "1000","Get_member_details" =>'Invalid Data'));
						exit;
					}
				}				
				else
				{
					/* $error=0;
					echo $error; */
					$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
					echo json_encode(array("status" => "1000","Get_member_details" =>'Invalid Data'));
					exit;
				}						
			}
			else
			{
				/* $error=0;
				echo $error; */
				$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
				echo json_encode(array("status" => "1000","Get_member_details" =>'Invalid Data'));
				exit;
				
			}			
		}
		
    }	
    public function smart_phone_login()
    {      	
		$this->cart->destroy();
    	// http://localhost/CI_IGAINSPARK_JOY/Joycoins/index.php/login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2018&login_logout=0&flag=1		
        //https://joy1.igainapp.in/Joycoins/index.php/login?username=ravip@miraclecartes.com&company_id=8&password=Ravi@2018&login_logout=0&flag=1


		
		
		$email=$_REQUEST['username'];
		$CompanyID=$_REQUEST['company_id'];
		$password=$_REQUEST['password'];
		$login_logout =$_REQUEST['login_logout'];
		$flag =$_REQUEST['flag'];
		
		/*--------------Encripted & Decrypted------------------------------------------*/
			$enc_email = App_string_encrypt($email); //echo "--enc_email--".$enc_email. PHP_EOL;
			$dec_email = App_string_decrypt($enc_email); //echo "--dec_email--".$dec_email. PHP_EOL;
			
			$enc_password = App_string_encrypt($password); //echo "--enc_email--".$enc_email. PHP_EOL;
			$dec_password = App_string_decrypt($enc_password); //echo "--dec_password--".$dec_password. PHP_EOL;		
		/*--------------Encripted & Decrypted------------------------------------------*/
		
		if($flag  == 1) //APK
		{	
			// echo"---flag---1--".$flag."---<br>";
			
			// die;
			
			$Walking_customer =0;
			if($_REQUEST['Walking_customer'] != ""){
				$Walking_customer =$_REQUEST['Walking_customer'];
			} else {
				$Walking_customer =$Walkingcustomer;
			}
			
			$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($CompanyID);
			$timezone_entry=$Super_Seller_details->timezone_entry;			
			$logtimezone = $timezone_entry;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			
			$result = $this->Login_model->customer_login($enc_email,$enc_password,$CompanyID,$flag);
			if($result)				
			{
				$sess_array = array();
				foreach($result as $row)
				{							
					$sess_array = array(
						'enroll' => $row['Enrollement_id'],
						'username' => $row['User_email_id'],
						'Country_id' => $row['Country_id'],
						'userId'=>$row['User_id'],
						'Company_name'=>$row['Company_name'],
						'Company_id'=>$row['Company_id'],
						'Card_id'=>$row['Card_id'],
						'timezone_entry'=>$row['timezone_entry'],
						'Full_name'=>$row['First_name']."".$row['Middle_name']."".$row['Last_name'],
						'smartphone_flag' => '1',
						'Walking_customer' => $Walking_customer
					);					
					$this->session->set_userdata('cust_logged_in', $sess_array);
					$Loggin_User_id = $row['User_id'];
					$Enrollment_id = $row['Enrollement_id'];
					$Company_id = $row['Company_id'];
					$userId = $row['User_id'];
					$userName = $row['User_email_id'];
					$timezone_entry = $row['timezone_entry'];
					$Company_name = $row['Company_name'];
					$Card_id = $row['Card_id'];
                    $Full_name = $row['First_name']." ".$row['Middle_name']." ".$row['Last_name'];
				}					
				if($Loggin_User_id == 1) //Customer
				{
					if($this->session->userdata('cust_logged_in'))
					{
						$Customer_details= $this->Igain_model->get_enrollment_details($Enrollment_id);	
						$Company_Details= $this->Igain_model->get_company_details($Company_id);	
						$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
						$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
						$seller_id=$Super_Seller_details->Enrollement_id;
						
						
						/* $Check_first_time_login = $this->Igain_model->first_time_login($Company_id,$userName,$Enrollment_id,$userId);	
								
						if($Check_first_time_login == 0)
						{						
							redirect('Cust_home/first_time_login');								
						}
						else
						{ */
							
						
						
						
						
							$logtimezone = $timezone_entry;
							$timezone = new DateTimeZone($logtimezone);
							$date = new DateTime();
							$date->setTimezone($timezone);
							$lv_date_time=$date->format('Y-m-d H:i:s');
							$Todays_date = $date->format('Y-m-d');	
							
							
							/*---------------Insert into Session--Ravi 25-03-2018------------------*/
								//$Insert_into_session = $this->Login_model->insert_into_session($Company_id,$userName,$Enrollment_id,$userId,$flag,$lv_date_time);
							/*---------------Insert into Session--Ravi 25-03-2018------------------*/
						
							$timezone_entry=$Super_Seller_details->timezone_entry;			
							$logtimezone = $timezone_entry;
							$timezone = new DateTimeZone($logtimezone);
							$date = new DateTime();
							$date->setTimezone($timezone);
							$lv_date_time=$date->format('Y-m-d H:i:s');
							$Todays_date = $date->format('Y-m-d');
							$top_db2 = $Super_Seller_details->Topup_Bill_no;
							$len2 = strlen($top_db2);
							$str2 = substr($top_db2,0,5);
							$tp_bill2 = substr($top_db2,5,$len2);						
							$topup_BillNo2 = $tp_bill2 + 1;
							$billno_withyear_ref = $str2.$topup_BillNo2;
							
							/*--------------------First time app login----------------------------*/						
							$Customer_profile_status= $this->Igain_model->Member_profile_status($Enrollment_id,$Company_id);
							if($Customer_details->App_login_flag=='0' && $Company_Details->App_login_flag=='1')
							{
								$profile_status_flag= $this->Igain_model->Update_member_app_login_flag($Enrollment_id,$Company_id);
								// echo"--Get Bonus Complete--profile_status---<br>";						
								$Current_balance=$Customer_details->Current_balance;
								$Total_topup_amt=$Customer_details->Total_topup_amt;
								$total_purchase=$Customer_details->total_purchase;
								$Total_reddems=$Customer_details->Total_reddems;
								$Enrollement_id=$Customer_details->Enrollement_id;
                                                                
								$new_balance=$Current_balance+round($Company_Details->App_login_points);
								$New_Total_topup_amt=$Total_topup_amt+round($Company_Details->App_login_points);
								
								$post_Transdata = array ( 	
															'Trans_type' => '1',
															'Company_id' => $Company_id,
															'Topup_amount' =>round($Company_Details->App_login_points),        
															'Trans_date' => $lv_date_time,       
															'Remarks' => 'App login reward point',
															'Card_id' => $Card_id,
															'Seller_name' =>$Seller_name ,
															'Seller' => $seller_id,
															'Enrollement_id' => $Enrollment_id,
															'Bill_no' => $tp_bill2,
															'remark2' => 'Super Seller',
															'Loyalty_pts' => '0'
														);
								$result6 = $this->Igain_model->insert_topup_details($post_Transdata);
								$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
								
								$up = array(
											'Current_balance' => $new_balance, 
											'total_purchase' => $total_purchase,
											'Total_topup_amt' => $New_Total_topup_amt,
											'Total_reddems' => $Total_reddems
											);			
							   $result3= $this->Shopping_model->update_cust_balance($up,$Card_id,$Company_id);
								
								
								$Email_content = array(
								'Login_bonus' => round($Company_Details->App_login_points),
								'Notification_type' => 'App login Reward Points',
								'Template_type' => 'App_login_reward'
								);
								$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'',$Company_id); 						
							}							
							/*--------------------First time app login----------------------------*/
							$session_data = $this->session->userdata('cust_logged_in');
							//redirect('Cust_home/home');
                                                        
                               $userName = App_string_decrypt($userName); //echo "--dec_password--".$dec_password. PHP_EOL;                         
								$Return_json_response = array(
									
									'Loggin_User_id' => $Loggin_User_id,
									'Enrollment_id'=> $Enrollment_id,
									'Full_name'=> $Full_name,
									'Company_id'=>$Company_id,
									'Company_name'=>$Company_name,
									'userId'=>$userId,
									'userName' => $userName,
									'timezone_entry' => $timezone_entry
								);
								echo json_encode(array("status" => "1001","Get_member_details" => $Return_json_response));
														
								// redirect('Cust_home/home');
						//}					
						
					}
					else
					{
						$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
                        echo json_encode(array("status" => "1000","Get_member_details" =>'User Not Fount'));
					}
				}				
				else
				{
					$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
                    echo json_encode(array("status" => "1000","Get_member_details" =>'User Not Fount'));
				}						
			}
			else
			{
				$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
				echo json_encode(array("status" => "1000","Get_member_details" =>'Invalid Data'));
				
			}			
		}
		else
		{
			
			$Insert_failed_login = $this->Login_model->Insert_failed_login($CompanyID,$enc_email,$enc_password,$user_type=1,$lv_date_time,$flag);
			echo json_encode(array("status" => "1000","Get_member_details" =>'Invalid Data'));
		}
			
	}	
	public function login_mail($Logged_Enrollment_id,$Logged_in_from)
	{
		$User_details = $this->Igain_model->get_enrollment_details($Logged_Enrollment_id);
		$Company_details = $this->Igain_model->Fetch_Company_Details($User_details->Company_id);
		foreach($Company_details as $cmp)
		{
			$Company_name=$cmp['Company_name'];
		}		
		
		$User_email_id = App_string_decrypt($User_details->User_email_id);
		
		$Date = date("Y-m-d h:i:s a");
		$from = $User_email_id;
		$to = "rakesh@miraclecartes.com";
		$subject = "Logged in iGainSpark Application." ; 		
		$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
		$html .= '<body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100%!important;">';		
		$html .= '<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">';
		
		$html .= '<tr>
				  <td class="bodycopy" style="color: #153643; font-family: Tahoma;font-size: 12px; line-height: 22px;">								
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; line-height: 22px;">
							<tr>
								<td><b>Email ID :</b></td>
								<td>'.$User_email_id.'</td>
							</tr>
							
							<tr>
								<td><b>Name :</b></td>
								<td>'.$User_details->First_name." ".$User_details->Middle_name." ".$User_details->Last_name.'</td>
							</tr>
							
							<tr>
								<td><b>User Type :</b></td>
								<td>'.$User_details->User_id.'</td>
							</tr>
							<tr>
								<td><b>Company Name:</b></td>
								<td>'.$Company_name.'</td>
							</tr>
							
							<tr>
								<td><b>Logged In From :</b></td>
								<td>'.$Logged_in_from.'</td>
							</tr>
							
							<tr>
								<td><b>Logged Time & Date :</b></td>
								<td>'.$Date.'</td>
							</tr>
						</table>
				  </td>
				  </tr>';
		
		$html .= "</table>";		
		$html .= "</body>";
		$html .= "</html>";	
		//**************************Email Fuction Code*****************************
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'mail.miraclecartes.com';
			$config['smtp_user'] = 'rakeshadmin@miraclecartes.com';
			$config['smtp_pass'] = 'rakeshadmin@123';
			$config['smtp_port'] = 25;
			$config['mailtype'] = 'html';
			$config['crlf'] = "\r\n";
			$config['newline'] = "\r\n";
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->load->library('email', $config);
			$this->email->initialize($config);
			
			$this->email->from($from);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($html); 
			// echo $html;
			if ( ! $this->email->send())
			{
				echo "Email Sent";
			}
			else
			{
				echo "Email Not Sent";
			}
		//**************************Email Fuction Code*****************************/
	}
	
	public function live_chat()
	{
		$m_name = $this->input->post("member_name");
		$this->session->set_userdata('Chat_cust_name', $this->input->post("Chat_name"));
		$this->session->set_userdata('Chat_cust_email', $this->input->post("Chat_email"));
		
		$Chat_cust_name = $this->session->userdata('Chat_cust_name');
		$Chat_cust_email = $this->session->userdata('Chat_cust_email');
		redirect('Login');
	}
		
}
?>
