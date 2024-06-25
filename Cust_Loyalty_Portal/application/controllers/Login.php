<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
ini_set("html_errors", 1);

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->model('Users_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library("Excel");
		$this->load->library('m_pdf');
		$this->load->library('Send_notification');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->library('cart');
		$this->load->helper('language');
		$this->load->helper(array('form', 'url','encryption_val'));	
	}
	public function index()
    {
		
			
			$Company_id12 = 35;
			
			$data['Company_id'] = $Company_id12;
			$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id12);
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($Company_id12);
			
			$data["Redemption_Items"] = $this->Redemption_Model->get_all_items('','',$Company_id12,0,0,0,0,0,0);

			if($data["Redemption_Items"] != NULL)
			{
				foreach ($data["Redemption_Items"] as $product)
				{
					$itemCode = $product['Company_merchandize_item_code'];
					$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
					$Get_Mname = $this->Igain_model->Get_Merchandize_Category_details($product['Merchandize_category_id']);
					$Merchandize_category_name[$Get_Mname->Merchandize_category_id]=$Get_Mname->Merchandize_category_name;
					$lv_Merchandize_category_id[]=$Get_Mname->Merchandize_category_id;

				}
				$data["lv_Get_Merchandize_Category_details"]=array_unique($Merchandize_category_name);
				$data["Get_lv_Merchandize_category_id"]=array_unique($lv_Merchandize_category_id);
				$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
				$Item_array=$data['Redemption_Items'];
			}

			
			$data["Cust_Recently_viewed_items"] = $this->Redemption_Model->Get_Cust_Recent_merchandize_items($Company_id12,0);

			/*************************************************/

			foreach($data["Company_details"] as $cmpdtls)
			{
				$Partner_company_flag=$cmpdtls['Partner_company_flag'];
				$data['Company_primary_email_id']=$cmpdtls['Company_primary_email_id'];
				$data['Company_primary_phone_no']=$cmpdtls['Company_primary_phone_no'];
				$data['Company_name']=$cmpdtls['Company_name'];
				$data['Outlet_Website']=$cmpdtls['Website'];
				$data['Company_address']=$cmpdtls['Company_address'];
				$data['Company_logo']=$cmpdtls['Company_logo'];
				$data['Comp_regdate']=$cmpdtls['Comp_regdate'];
				$data['Company_License_type']=$cmpdtls['Company_License_type'];
				$data['Country']=$cmpdtls['Country'];
				$Parent_company=$cmpdtls['Parent_company'];
				$this->session->set_userdata('site_lang', $cmpdtls['Country_language']);
				$this->session->set_userdata('Text_direction', $cmpdtls['Text_direction']);
				/*************************************************/
			}
			$data["Company_partner_cmp"] = $this->Igain_model->Fetch_Company_Details($Parent_company);

			$this->form_validation->set_error_delimiters('<span class="error" style="color:red">', '</span>');
			$this->form_validation->set_rules('email', 'email', 'required|min_length[2]|trim');
			$this->form_validation->set_rules('password', 'password', 'required|min_length[2]');
			/**************live chat*************/
			$data['listOfUsers'] = $this->Users_model->getUsers($Company_id12);
			/**************live chat*************/
			if(!$this->form_validation->run()  && !isset($_REQUEST['email']))
			{
				if(isset($_SESSION["Merchant_login_error"]) )
				{
					unset($_SESSION["Merchant_login_error"]);
					$this->session->set_flashdata("error_code","Invalid username or password..!!"); 
				}
				/*****************Login Masking******************/

				/* if(!isset($_REQUEST['masking_flag']) )
				{
					$this->load->view('login/login_masking', $data);
				}
				else
				{
					$this->load->view('login/login', $data);
				} */
				
				if(isset($_REQUEST['User_login'])){ //User Login Page
				$this->load->view('login/Userlogin', $data);
				}
				else //Member Login Page
				{
					$this->load->view('login/login', $data);
				}
				
				/*****************************************/
			}
			else
			{
				$session_data = $this->session->userdata('cust_logged_in');
				$data['enroll'] = $session_data['enroll'];
				$data['Company_id'] = $session_data['Company_id'];
				$Company_id = $session_data['Company_id'];

				$result = $this->Login_model->login(App_string_encrypt($_REQUEST['email']),App_string_encrypt($_REQUEST['password']),$Company_id12,$_REQUEST['flag']);
			
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
							'Login_Partner_Company_id'=>$row['Company_id'],
							'timezone_entry'=>$row['timezone_entry'],
							'Full_name'=>$row['First_name']."".$row['Middle_name']."".$row['Last_name'],
							'smartphone_flag' => '2'
						);
						$this->session->set_userdata('cust_logged_in', $sess_array);
						$Loggin_User_id = $row['User_id'];
						$Super_seller = $row['Super_seller'];
						$Enrollement_id = $row['Enrollement_id'];
						$userName = $row['User_email_id'];
						$userId = $row['User_id'];
						$Company_id = $row['Company_id'];
						$Current_balance=$row['Current_balance'];
						$Blocked_points=$row['Blocked_points'];
						$Debit_points=$row['Debit_points'];
						$timezone_entry=$row['timezone_entry'];
						
						$_SESSION['Session_Company_License_type'] = $row['Company_License_type'];
					}
					
					
					//--------------License Expiry Check-----------------
		 /* 
				   $FetchedSaasCompany = $this->Login_model->Get_saas_company_payment_details($Company_id);
				   if($FetchedSaasCompany != NULL)
				   {
					   // echo $FetchedSaasCompany->Pyament_expiry_date;die;
						$Expiry_license=$FetchedSaasCompany->Pyament_expiry_date;
						$_SESSION['Expiry_license'] = $Expiry_license;
						if(date('Y-m-d') > $Expiry_license)
						{
							$_SESSION['Expiry_license'] = date('Y-m-d');
						}
				   }
				   else
				   {
					   $Expiry_license = date('Y-m-d');
					   $_SESSION['Expiry_license'] = date('Y-m-d');
				   } */
				   
				   //---------------------------------------------------
					
					$FetchedClientCompanys = $this->Igain_model->get_partner_companys($Loggin_User_id,$Company_id);
					$data['Company_array'] = $FetchedClientCompanys;
					
					if($Loggin_User_id == 1)
					{
						if($this->session->userdata('cust_logged_in'))
						{
							// $Check_first_time_login = $this->Igain_model->first_time_login($Company_id,$userName,$Enrollement_id,$userId);

							/* if($Check_first_time_login == 0)
							{
								redirect('Cust_home/first_time_login');
							}
							else
							{ */
							/* 	 if(date('Y-m-d') > $Expiry_license) 
								{ 
									echo json_encode(array("status" => false,"errorcode" => "1024","message" =>'Sorry,Company has been Inactive, Please Contact Administrator !!!'));
									exit;
								} */
			
								$logtimezone = $timezone_entry;
								$timezone = new DateTimeZone($logtimezone);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');

								/*---------------Insert into Session--Ravi 25-03-2018------------------*/
									$Insert_into_session = $this->Login_model->insert_into_session($Company_id,$userName,$Enrollement_id,$userId,$_REQUEST['flag'],$lv_date_time);
								/*---------------Insert into Session--Ravi 25-03-2018------------------*/

								$session_data = $this->session->userdata('cust_logged_in');
								//$this->login_mail($session_data['enroll'],"Browser");
								$callcenterticket=$_REQUEST['callcenterticket'];
								$redeemflag=$_REQUEST['redeemflag'];
								if($callcenterticket == 1)
								{
									// redirect('Cust_home/contactus');
									echo json_encode(array("status" => true,"errorcode" => "1001","message" =>'success'));
									exit;
								}
								elseif($redeemflag == 1)
								{	
									$data['Total_balance']=($Current_balance -($Blocked_points+$Debit_points));
									
									$this->load->view('testview',$data);
									
									// redirect('Redemption_Catalogue');
									echo json_encode(array("status" => true,"errorcode" => "1001","message" =>'success'));
									exit;
								}
								else
								{
									// redirect('Cust_home/home');
									echo json_encode(array("status" => true,"errorcode" => "1001","message" =>'success'));
									exit;
								}
							/* } */
						}
						else
						{
							// redirect('login');
							echo json_encode(array("status" => false,"errorcode" => "1024","message" =>'The provided credentials are incorrect'));
							exit;
						}
					}
					else
					{
						// redirect('login');
						echo json_encode(array("status" => false,"errorcode" => "1024","message" =>'The provided credentials are incorrect'));
						exit;
					}
				}
				else
				{
				
					$this->session->set_flashdata("error_code","Invalid username or password..!!");
					// redirect('login');
					$lv_date_time=date('Y-m-d H:i:s');
					echo json_encode(array("status" => false,"errorcode" => "1024","message" =>'The provided credentials are incorrect'));
					exit;

					
					/* if(isset($_REQUEST["checkout_flag"]))
					{
						// redirect('Redemption_Catalogue/Checkout_front_page_items/?Company_id='.$Company_id12);
						$data['errr_message'] = "Invalid Email ID or Password..!!";
						$this->load->view('Redemption_Catalogue/Checkout_front_page_items',$data);
					}
					else
					{
						$data['message'] = "<font class='error'>Invalid username or password..!!</font>";
					$this->session->set_flashdata("error_code","Invalid username or password..!!");
						// redirect('login');
						$this->load->view('login/login_masking', $data);
						// $this->load->view('login/login',$data);
					} */

				}
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
		$Date = date("Y-m-d h:i:s a");
		$from = $User_details->User_email_id;
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
								<td>'.$User_details->User_email_id.'</td>
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
	function bc1fadea() 
	{
		// $Pwd_data = json_decode(base64_decode($_REQUEST['Pwd_data']));
		$Pwd_data = json_decode(base64_decode($_REQUEST['vvTFsNBjgNhi']));
		$Pwd_variables = get_object_vars($Pwd_data);
	
		$data["SetCompany_id"]=$Pwd_variables["Company_id"];
		$data["SetEnroll_id"]=$Pwd_variables["Enroll_id"];
		$data["SetUser_email_id"]=$Pwd_variables["User_email_id"]; 
		$data["Pwd_variables"]=$Pwd_variables;
		$data['Pwd_set_code'] = $Pwd_variables["Pwd_set_code"]; 
		
		$Company_Details= $this->Igain_model->get_company_details($Pwd_variables["Company_id"]);
		$Cust_website=$Company_Details->Cust_website;
		$data["Cust_website"]=$Cust_website;
		
		$Enroll_details = $this->Igain_model->get_enrollment_details($Pwd_variables["Enroll_id"]);
		$data['Enroll_Pwd_set_code'] = $Enroll_details->Pwd_set_code;
		
		if($_POST == NULL)
		{
			$this->load->view('login/Set_password', $data);
		} 
		else 
		{	
			$Enroll_id=$this->input->post('SetEnroll_id');
			$Company_id=$this->input->post('SetCompany_id');
			$Pwd_set_code=$this->input->post('Pwd_set_code');
			
			$new_Password = $this->input->post('new_Password');
			$confirm_Password = $this->input->post('confirm_Password');
			
			$Enroll_details = $this->Igain_model->get_enrollment_details($Enroll_id);
			$User_pwd = App_string_decrypt($Enroll_details->User_pwd);
			$Enroll_Pwd_set_code = $Enroll_details->Pwd_set_code;
			
			if($Enroll_Pwd_set_code!=$Pwd_set_code)
			{
				echo '5'; //The link that you are trying to view is already accessed. It can be viewed and used only once and is then destroyed.
				exit;
			}
			if($User_pwd==$new_Password)
			{
				echo '2';  //Old Password is same with New Password.. Please try again
				exit;
			}
			$matchepwd= strcmp($new_Password,$confirm_Password);
			
			if($matchepwd != 0)
			{
				echo '3';  //New Password and Confirm Password don't match..Please try again
				exit;
			}
			$password_len=strlen($new_Password);
			
			$confpassword_len=strlen($confirm_Password);
			
			$password_upper_char =  preg_match('/[A-Z]/', $new_Password);
			
			$password_lower_char =  preg_match('/[a-z]/', $new_Password);
			
			$password_numaric = preg_match('~[0-9]+~', $new_Password);
			
			$password_special_char = preg_match('/[\'^£$%&*.()}{@#~?><>,|=_+¬-]/', $new_Password);
			
			if($password_len < 8)
			{			
				echo '4';  //Password should be minimum of 8 characters with one number, one special, one upper and one lower case letter
				exit;				
			}
			if($password_upper_char != 1 )
			{
				echo '4';  //Password should be minimum of 8 characters with one number, one special, one upper and one lower case letter
				exit;			
			}
			if($password_lower_char != 1 )
			{	
				echo '4';  //Password should be minimum of 8 characters with one number, one special, one upper and one lower case letter
				exit;				
			}
			if($password_special_char != 1 )
			{
				echo '4';  //Password should be minimum of 8 characters with one number, one special, one upper and one lower case letter
				exit;
			}
			if($password_numaric != 1 )
			{
				echo '4';  //Password should be minimum of 8 characters with one number, one special, one upper and one lower case letter
				exit;
			}
			
			$post_data=array(
			
				'User_pwd' => App_string_encrypt($this->input->post('new_Password')),'Pwd_set_code' => "Expired"
			);
			
			$data["UpdatePwd"] = $this->Igain_model->update_password($Company_id,$Enroll_id,$post_data);
			
			if($data["UpdatePwd"])
			{
				echo '1';
				exit;
			} 
			else
			{
				echo '0';
				exit;
			}
		}
    }
}
?>