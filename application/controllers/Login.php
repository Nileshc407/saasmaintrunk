<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Login extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->helper(array('form', 'url','encryption_val'));	
      $this->load->model('login/Login_model');
      $this->load->model('login/Login_track_model');
      $this->load->model('Igain_model');
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('Send_notification');
      $this->load->model('master/currency_model');
    }
 
    public function index() {


      //$this->load->helper(array('form', 'url'));
      ////////// Check Validation Form ////////////////
      $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
      $this->form_validation->set_rules('username', 'username', 'required|min_length[2]|trim');
      $this->form_validation->set_rules('password', 'password', 'required|min_length[2]');

      if (!$this->form_validation->run() && !isset($_REQUEST['username'])) {
		  
        /*         * ********************Login Masking*************************** */
				//redirect($this->config->item('base_url2'));
        /*         * ****************************************************** */
		
		/**************16-01-2020******************/
			$this->load->view('login/loginform');
			$session_data = $this->session->userdata('logged_in');
			$data['Company_id'] = $session_data['Company_id'];
		/**************16-01-2020******************/
		
		
      } else {
		  
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $flag = 4;
        if (isset($_SESSION['Set_Membership_id'])) {
          unset($_SESSION['Set_Membership_id']);
        }
		

        // echo"----username-------".$_REQUEST['username']."---<br>";
        // echo"----password-------".$_REQUEST['password']."---<br>";
        // http://localhost/CI_IGAINSPARK_LIVE_NEW_DESIGN/index.php/Login?username=admin@lipita.com&password=admin123
		
		
        ///////////  Authentication Check Here //////////////////
		$enc_uname = App_string_encrypt($_REQUEST['username']);// echo "--enc uname--".$enc_uname. PHP_EOL;
		$enc_upass = App_string_encrypt($_REQUEST['password']); //echo "--enc upass--".$enc_upass. PHP_EOL;	
		
		
		
		/* 19-05-2022 */
			$lv_date_time=date('Y-m-d H:i:s');
			$total_attempt=5;		
			$resultV = $this->Login_track_model->validate_user($enc_uname);
			// print_r($resultV);
			$User_id12=2;
			$Company_id12=0;
			if($resultV){
				foreach ($resultV as $rowV) {
					
					$User_id12 = $rowV['User_id'];
					$Company_id12 = $rowV['Company_id'];
				}
			}
			// echo "<br>-11-User_id12---)".$User_id12."----<br>";
			// echo "<br>-11-Company_id12---)".$Company_id12."----<br>";
			$login_track = $this->Login_track_model->check_login_track($Company_id12,$enc_uname);
					
			// echo "<br>-11-login_track---)".$login_track."----<br>";
			// echo "<br>-11-total_attempt---)".$total_attempt."----<br>";
			// die;		

			
			if($login_track >= $total_attempt && $Company_id12 !=0){
				
				$_SESSION["Merchant_login_error"] = 1;
				$this->session->set_flashdata("error_code", "Your account is blocked for the day..!!");
				redirect($_SERVER['HTTP_REFERER']);
			}
			// die;
			
		/* 19-05-2022 */
		
		
		$result = $this->Login_model->login($enc_uname,$enc_upass,$flag);		
     //   $result = $this->Login_model->login($_REQUEST['username'], $_REQUEST['password'], $flag);
       // print_r($result);
        // die(); 
        if ($result) {
			
          $sess_array = array();
          // print_r($result);
          $User_id = 0;
          $Super_seller = 0;
          $Sub_seller_admin = 0;
          foreach ($result as $row) {

            /* if ($row['User_id'] == 7) {

              $User_id = 2;
              $Super_seller = 1;
              $Sub_seller_admin = 1;
            } else {

              $User_id = $row['User_id'];
              $Super_seller = $row['Super_seller'];
              $Sub_seller_admin = $row['Sub_seller_admin'];
            } */
			
			$User_id = $row['User_id'];
            $Super_seller = $row['Super_seller'];
            $Sub_seller_admin = $row['Sub_seller_admin'];
			  
            $sess_array = array('enroll' => $row['Enrollement_id'], 'username' => $row['User_email_id'], 'Country_id' => $row['Country_id'], 'userId' => $User_id, 'Super_seller' => $Super_seller, 'Company_name' => $row['Company_name'], 'Company_id' => $row['Company_id'], 'Login_Partner_Company_id' => $row['Company_id'], 'timezone_entry' => $row['timezone_entry'], 'Full_name' => $row['First_name'] . " " . $row['Middle_name'] . " " . $row['Last_name'], 'Count_Client_Company' => $row['Count_Client_Company'], 'card_decsion' => $row['card_decsion'], 'next_card_no' => $row['next_card_no'], 'Seller_licences_limit' => $row['Seller_licences_limit'], 'Seller_topup_access' => $row['Seller_topup_access'], 'Current_balance' => $row['Current_balance'], 'Allow_membershipid_once' => $row['Allow_membershipid_once'], 'Allow_merchant_pin' => $row['Allow_merchant_pin'], 'Sub_seller_admin' => $Sub_seller_admin, 'pinno' => $row['pinno'], 'smartphone_flag' => '2', 'Sub_seller_Enrollement_id' => $row['Sub_seller_Enrollement_id'], 'Membership_redirection_url' => $row['Membership_redirection_url'], 'Localization_flag' => $row['Localization_flag'], 'Localization_logo' => $row['Localization_logo'], 'Company_License_type' => $row['Company_License_type'], 'Comp_regdate' => $row['Comp_regdate']);
			$Comp_regdate = $row['Comp_regdate'];
			$Company_License_type = $row['Company_License_type'];
			
			

            $this->session->set_userdata('logged_in', $sess_array);
            // die;
            $Partner_company_flag = $row['Partner_company_flag'];
            $Count_Client_Company = $row['Count_Client_Company'];
            $Loggin_User_id = $User_id;

            $Super_seller = $Super_seller;
            $Company_id = $row['Company_id'];
            $data['Company_id'] = $Company_id;
            $Company_logo = $row['Company_logo'];
            $Coalition = $row['Coalition'];
            $Photograph = $row['Photograph'];
            $_SESSION['Photograph'] = $Photograph;
            $_SESSION['Company_logo'] = $Company_logo;
            $_SESSION['Coalition'] = $Coalition;
            $data['LogginUserName'] = $row['First_name'] . " " . $row['Last_name'];
            $data['User_id'] = $User_id;

            /*             * *********************AMIT 24-05-2016************************************************* */
            $_SESSION['Parent_company'] = $row['Parent_company'];
            $FetchedParentCompany = $this->Igain_model->get_company_details($_SESSION['Parent_company']);

            $_SESSION['Localization_logo'] = $FetchedParentCompany->Localization_logo;
            $_SESSION['Localization_flag'] = $FetchedParentCompany->Localization_flag;
            $_SESSION['Company_logo'] = $FetchedParentCompany->Company_logo;
            $_SESSION['Company_name'] = $FetchedParentCompany->Company_name;
            $_SESSION['Website'] = $FetchedParentCompany->Website;
            //$_SESSION['Company_name'] = $row['Company_name'];

            /*             * **********************AMIT 08-09-2016****************************************************** */
            $_SESSION['Allow_merchant_pin'] = $FetchedParentCompany->Allow_merchant_pin;
            $_SESSION['Allow_membershipid_once'] = $FetchedParentCompany->Allow_membershipid_once;
            $this->login_mail($row['Enrollement_id'], "Browser");
			
			 $_SESSION['Session_Company_License_type'] = $row['Company_License_type'];
          }
          $FetchedClientCompanys = $this->Igain_model->get_partner_companys($Loggin_User_id, $Company_id);
          $data['Company_array'] = $FetchedClientCompanys;
		  
		  
		  /* 19-05-2022 */
			$update_failed_login = $this->Login_track_model->update_failed_login($Company_id12,$enc_uname,$User_id12);
		  /* 19-05-2022 */
		  
		  // die;
		  
		  

          //--------------License Expiry Check-----------------
		 if($Company_License_type != 121)//not basic
		 {
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
				   $_SESSION['Expiry_license'] ='1970-01-01';
			   }
		 }
		 else
		 {
			 $Expiry_license = date('Y-m-d',strtotime($Comp_regdate.'+365 day'));
			 $_SESSION['Expiry_license'] = $Expiry_license;
			/*  if(date('Y-m-d') > $Expiry_license)
			{
				$_SESSION['Expiry_license'] = date('Y-m-d');
			} */
			 // echo 'Expiry_license '.$Expiry_license;die;
		 }
		   
		  
		   
		   //---------------------------------------------------

         

          if ($Loggin_User_id == 3 || $Loggin_User_id == 4) { //miracle admin or Partner admin
            // echo"<br>----Loggin_User_id---".$Loggin_User_id;
            if ($Count_Client_Company != 0 && $Loggin_User_id == 4) {
              $Client_company_array = $this->Igain_model->get_partner_clients($Company_id);
              // print_r($Client_company_array); die;
              $data['Client_company_array'] = $Client_company_array;

              $Client_company_Trans = $this->Igain_model->get_partner_clients_transaction($Company_id);
              $data['Client_company_Trans'] = $Client_company_Trans;

              $this->load->view('Select_partner_client', $data);
            } else if ($Count_Client_Company != 0 && $Loggin_User_id == 3) {
              $Client_company_Trans = $this->Igain_model->get_partner_clients_transaction_miracleAdmin($Company_id);

              $data['Client_company_Trans'] = $Client_company_Trans;

              $this->load->view('Select_partner_client', $data);
            } else {
				
				if(date('Y-m-d') > $_SESSION['Expiry_license']) { 
					redirect('Register_saas_company/UpgradePlan');
				}
				redirect('Home');
            }
          } else {
			  
				if(date('Y-m-d') > $_SESSION['Expiry_license']) 
				{ 
					// echo 'Expiry_license '.$Expiry_license;die;
					if($Super_seller==1)
					{
						redirect('Register_saas_company/UpgradePlan');
					}
					else
					{
						
						$this->session->set_flashdata("error_code", "Loyalty License has expired. Please contact Company Admin");
						redirect($_SERVER['HTTP_REFERER']);
					}
					
				}
				redirect('Home');
          }
          return TRUE;
		  
        } else {
          /*           * ******************** If Auth. is fail ********************** */
          
			// echo "----in Fails---<br>";
			/* 19-05-2022 */
			$remaining_attempt = $total_attempt;
			if($Company_id12 !=0){
				
				$Insert_failed_login = $this->Login_track_model->Insert_failed_login($Company_id12,$enc_uname,$enc_upass,$User_id12,$lv_date_time,$flag);				
				$login_track = $this->Login_track_model->check_login_track($Company_id12,$enc_uname);						
				// echo "<br>-22-login_track---".$login_track."----<br>";
				$remaining_attempt = $total_attempt-$login_track;
			}
				
							
							
				
			/* 19-05-2022 */
		 
		 
			 if($Company_id12 !=0){
				
				$_SESSION["Merchant_login_error"] = 1;
				$data['message'] = "<font class='error'>Invalid username or password. You are left with ".$remaining_attempt." more attempts.</font>";
				$this->session->set_flashdata("error_code", "Invalid username or password. You are left with ".$remaining_attempt." more attempts.");
				redirect($_SERVER['HTTP_REFERER']);
				
			 } else {
				
				
				$_SESSION["Merchant_login_error"] = 1;
				$data['message'] = "<font class='error'>Invalid username or password.</font>";
				$this->session->set_flashdata("error_code", "Invalid username or password.");
				redirect($_SERVER['HTTP_REFERER']);
				
			}
		 
                  
          
		  
		  
        }
      }
    }

    public function Select_company() {


      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $enroll = $session_data['enroll'];
        $Loggin_User_id = $session_data['userId'];
        $Count_Client_Company = $session_data['Count_Client_Company'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['User_id'] = $session_data['userId'];
        $enrollment_details = $this->Igain_model->get_enrollment_details($enroll);

        $FetchedClientCompanys = $this->Igain_model->get_partner_companys($Loggin_User_id, $enrollment_details->Company_id);
        $data['Company_array'] = $FetchedClientCompanys;

        $partner_clients = $this->Igain_model->get_partner_clients($enrollment_details->Company_id);

        $Client_company_Trans = $this->Igain_model->get_partner_clients_transaction($enrollment_details->Company_id);
        $data['Client_company_Trans'] = $Client_company_Trans;
        if ($Loggin_User_id == 3 || $Loggin_User_id == 4) {
          if ($Count_Client_Company != 0 && $Loggin_User_id == 4) {
            $Client_company_array = $this->Igain_model->get_partner_clients($enrollment_details->Company_id);
            $data['Client_company_array'] = $Client_company_array;
            $this->load->view('Select_partner_client', $data);
          } else if ($Count_Client_Company != 0 && $Loggin_User_id == 3) {
            $Client_company_array = $this->Igain_model->get_partner_clients($enrollment_details->Company_id);
            $data['Client_company_array'] = $Client_company_array;
            $this->load->view('Select_partner_client', $data);
          } else {
            redirect('Home', 'refresh');
          }
        } else {
          redirect('Home', 'refresh');
        }
      }
    }

    public function smartphone_login() {
      //   http://localhost/CI_iGainSpark/index.php/Login/smartphone_login?username=companyadmin@redreward.com&password=12345&flag=1
      if (isset($_SESSION['Set_Membership_id'])) {
        unset($_SESSION['Set_Membership_id']);
      }
      if ($_REQUEST['flag'] == '1') { //APK
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];

        $email = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $flag = $_REQUEST['flag'];

        ///////////  Authentication Check Here //////////////////
        $result = $this->Login_model->login($email, $password, $flag);

        if ($result) {
          $sess_array = array();
          foreach ($result as $row) {
            /* $sess_array = array('enroll' => $row['Enrollement_id'],'username' => $row['User_email_id'],'Country_id' => $row['Country_id'],'userId'=>$row['User_id'],'Super_seller'=>$row['Super_seller'],'Company_name'=>$row['Company_name'],'Company_id'=>$row['Company_id'],'Login_Partner_Company_id'=>$row['Company_id'],'timezone_entry'=>$row['timezone_entry'],'Full_name'=>$row['First_name']." ".$row['Middle_name']." ".$row['Last_name'],'Count_Client_Company'=>$row['Count_Client_Company'],'card_decsion'=>$row['card_decsion'],'next_card_no'=>$row['next_card_no'],'Seller_licences_limit'=>$row['Seller_licences_limit'],'Seller_topup_access'=>$row['Seller_topup_access'],'Current_balance'=>$row['Current_balance'],'smartphone_flag' => '1'); */
            $sess_array = array('enroll' => $row['Enrollement_id'], 'username' => $row['User_email_id'], 'Country_id' => $row['Country_id'], 'userId' => $row['User_id'], 'Super_seller' => $row['Super_seller'], 'Company_name' => $row['Company_name'], 'Company_id' => $row['Company_id'], 'Login_Partner_Company_id' => $row['Company_id'], 'timezone_entry' => $row['timezone_entry'], 'Full_name' => $row['First_name'] . " " . $row['Middle_name'] . " " . $row['Last_name'], 'Count_Client_Company' => $row['Count_Client_Company'], 'card_decsion' => $row['card_decsion'], 'next_card_no' => $row['next_card_no'], 'Seller_licences_limit' => $row['Seller_licences_limit'], 'Seller_topup_access' => $row['Seller_topup_access'], 'Current_balance' => $row['Current_balance'], 'Allow_membershipid_once' => $row['Allow_membershipid_once'], 'Allow_merchant_pin' => $row['Allow_merchant_pin'], 'Sub_seller_admin' => $row['Sub_seller_admin'], 'pinno' => $row['pinno'], 'smartphone_flag' => '2', 'Sub_seller_Enrollement_id' => $row['Sub_seller_Enrollement_id']);
            $this->session->set_userdata('logged_in', $sess_array);

            $Partner_company_flag = $row['Partner_company_flag'];
            $Count_Client_Company = $row['Count_Client_Company'];
            $Loggin_User_id = $row['User_id'];
            $Super_seller = $row['Super_seller'];
            $Company_id = $row['Company_id'];
            $Localization_logo = $row['Localization_logo'];
            $Localization_flag = $row['Localization_flag'];

            $Company_logo = $row['Company_logo'];
            $Coalition = $row['Coalition'];
            $Photograph = $row['Photograph'];
            $_SESSION['Photograph'] = $Photograph;
            $_SESSION['Company_logo'] = $Company_logo;
            $_SESSION['Coalition'] = $Coalition;
            $_SESSION['Localization_logo'] = $Localization_logo;
            $_SESSION['Localization_flag'] = $Localization_flag;
            $data['LogginUserName'] = $row['First_name'] . " " . $row['Last_name'];
            $_SESSION['Parent_company'] = $row['Parent_company'];
            $this->login_mail($row['Enrollement_id'], "Smartphone Application");
          }
          /*           * *********************AMIT 24-05-2016************************************************* */

          $FetchedParentCompany = $this->Igain_model->get_company_details($_SESSION['Parent_company']);

          $_SESSION['Localization_logo'] = $FetchedParentCompany->Localization_logo;
          $_SESSION['Localization_flag'] = $FetchedParentCompany->Localization_flag;
          $_SESSION['Company_logo'] = $FetchedParentCompany->Company_logo;
          /*           * **********************AMIT 08-09-2016****************************************************** */
          $_SESSION['Allow_merchant_pin'] = $FetchedParentCompany->Allow_merchant_pin;
          $_SESSION['Allow_membershipid_once'] = $FetchedParentCompany->Allow_membershipid_once;

          $FetchedClientCompanys = $this->Igain_model->get_partner_companys($Loggin_User_id, $Company_id);
          $data['Company_array'] = $FetchedClientCompanys;

          if ($Loggin_User_id == 3 || $Loggin_User_id == 4) { //miracle admin or Partner admin
            if ($Count_Client_Company != 0) {
              $this->load->view('Select_partner_client', $data);
            } else {
              redirect('Home', 'refresh');
            }
          } else {
            redirect('Home', 'refresh');
          }
        } else {
          $error = 0;
          echo $error;
        }
      }
    }

    /*     * ********************************Forgot Password*********************************************** */

    public function check_email_address() {
      $result = $this->Igain_model->Check_Email_Address($this->input->post("email_id"));
      if ($result == 0) {
        $this->output->set_output("Invalid");
      } else {
        $this->output->set_output("Valid");
      }
    }

    public function Send_password() {
      if ($_REQUEST['flag'] == '1') { //APK
        $Email_id = App_string_encrypt($_REQUEST['username']);
        $result = $this->Igain_model->Send_password($Email_id);
        if ($result != NULL) {
          $Email_content = array(
              'Password' => $result->User_pwd,
              'Notification_type' => 'Request for Forgot Password',
              'Template_type' => 'Forgot_password'
          );
          $this->send_notification->send_Notification_email($result->Enrollement_id, $Email_content, '1', $result->Company_id);

          $response = 2;
          echo $response;
        } else {
          $response = -1;
          echo $response;
        }
      } else {
        $Email_id = App_string_encrypt($this->input->post('Email_id'));
        $result = $this->Igain_model->Send_password($Email_id);
        if ($result != NULL) {
          $Email_content = array(
              'Password' => $result->User_pwd,
              'Notification_type' => 'Request for Forgot Password',
              'Template_type' => 'Forgot_password'
          );
          $this->send_notification->send_Notification_email($result->Enrollement_id, $Email_content, '1', $result->Company_id);

          $this->output->set_output("Password sent Successfuly");
        } else {
          $this->output->set_output("Password Not sent");
        }
      }
    }

    public function Send_password_website() 
	{

      $Email_id = App_string_encrypt($this->input->post('email'));
      $Company_id = $this->input->post('Company_id');
      $result = $this->Igain_model->Send_password_website($Email_id, $Company_id);
	  $Company_details = $this->Igain_model->get_company_details($Company_id);

		if ($result != NULL) 
		{
			$Email_content = array(
				'Password' => $result->User_pwd,
				'Notification_type' => 'Request to set Password',
				'Template_type' => 'Forgot_password'
			);
			$this->send_notification->send_Notification_email($result->Enrollement_id, $Email_content, '1', $result->Company_id);
			$this->session->set_flashdata("messege", "Login Credentials are sent to your email...please check it !!");
			redirect($Company_details->Website);
		} 
		else 
		{
			$this->session->set_flashdata("messege", "Password Not sent !!");
			redirect($Company_details->Website);
			// $this->output->set_output("Password Not sent");
		}
    }

    public function login_mail($Logged_Enrollment_id, $Logged_in_from) {
      $User_details = $this->Igain_model->get_enrollment_details($Logged_Enrollment_id);
      $Company_details = $this->Igain_model->get_company_details($User_details->Company_id);

      $Date = date("Y-m-d h:i:s");
      $from = $User_details->User_email_id;
      $to = "rakesh@miraclecartes.com";
      $subject = "Logged in iGainspark Application.";
      $html = '<html xmlns="http://www.w3.org/1999/xhtml">';
      $html .= '<body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100%!important;">';
      $html .= '<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">';
      $html .= '<tr>
				  <td class="bodycopy" style="color: #153643; font-family: Tahoma;font-size: 12px; line-height: 22px;">								
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; line-height: 22px;">
							<tr>
								<td><b>Email ID :</b></td>
								<td>' . App_string_decrypt($User_details->User_email_id) . '</td>
							</tr>
							
							<tr>
								<td><b>Name :</b></td>
								<td>' . $User_details->First_name . " " . $User_details->Middle_name . " " . $User_details->Last_name . '</td>
							</tr>
							
							<tr>
								<td><b>User Type :</b></td>
								<td>' . $User_details->User_id . '</td>
							</tr>
							<tr>
								<td><b>Company Name:</b></td>
								<td>' . $Company_details->Company_name . '</td>
							</tr>
							
							<tr>
								<td><b>Logged In From :</b></td>
								<td>' . $Logged_in_from . '</td>
							</tr>
							
							<tr>
								<td><b>Logged Time & Date :</b></td>
								<td>' . $Date . '</td>
							</tr>
						</table>
				  </td>
				  </tr>';

      $html .= "</table>";
      $html .= "</body>";
      $html .= "</html>";
      /*       * ************************Email Fuction Code**************************** */
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

      //echo $html;
      if (!$this->email->send()) {
        //echo "Email Sent";
      } else {
        //echo "Email Not Sent";
      }
      /*       * ************************Email Fuction Code**************************** */
    }

    /*     * **********************AMIT 09-09-2016********************************* */

    function Get_member_info() {
      header('Content-Type: application/json');
      $this->load->model('administration/Administration_model');
      $this->load->model('Coal_transactions/Coal_Transactions_model');
      $dial_code = $this->Igain_model->get_dial_code($this->input->post("Country_id"));
      $phnumber = $dial_code . $this->input->post("cardid");
      $Company_id = $this->input->post("Company_id");
      $cardId = $this->input->post("cardid");
      $Seller_id = $this->input->post("Seller_id");
      $Cust_seller_balance = 0;
      $Cust_prepayment_balance = 0;
      //Asia/Kuala_Lumpur
      $session_data = $this->session->userdata('logged_in');
      $logtimezone = $session_data['timezone_entry'];
      $timezone = new DateTimeZone($logtimezone);
      $date = new DateTime();
      $date->setTimezone($timezone);
      //$lv_date_time=$date->format('H:i:s');		
      $time = $date->format("H");
      /* Set the $timezone variable to become the current timezone */
      if ($time < "12") {
        $Greet_msg = "<img src='" . base_url() . "/images/morning.png' width='10%'> Good Morning, ";
      } else
      /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
      if ($time >= "12" && $time < "17") {
        $Greet_msg = "<img src='" . base_url() . "/images/afternoon.png' width='10%'> Good Afternoon, ";
      } else
      /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
      if ($time >= "17" && $time < "24") {
        $Greet_msg = "<img src='" . base_url() . "/images/evening.png' width='10%'> Good Evening, ";
      }


      $Todays_date = $date->format('Y-m-d H:i:s');

      $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($Company_id, $cardId, $phnumber);
      if ($member_details != NULL) {
        foreach ($member_details as $rowis) {
          $Customer_enroll_id = $rowis['Enrollement_id'];
          $User_activated = $rowis['User_activated'];

          $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Seller_id, $Customer_enroll_id);

          if ($Get_Record != NULL) {
            foreach ($Get_Record as $val) {
              $Cust_seller_balance = $val["Cust_seller_balance"];
              $Cust_prepayment_balance = $val["Cust_prepayment_balance"];
            }
          }
        }

        $Get_offers = $this->Administration_model->get_multiple_offers($this->input->post("Seller_id"));

        $Member_info["First_name"] = $Greet_msg . " " . $member_details[0]["First_name"];
        $Member_info["Middle_name"] = $member_details[0]["Middle_name"];
        $Member_info["Last_name"] = $member_details[0]["Last_name"] . " !!!";
        $Member_info["Phone_no"] = $member_details[0]["Phone_no"];
        $Member_info["User_email_id"] = $member_details[0]["User_email_id"];
        $Member_info["Card_id"] = $member_details[0]["Card_id"];
        $Member_info["Current_balance"] = ($member_details[0]["Current_balance"] - $member_details[0]["Blocked_points"]);

        $currency_details = $this->Igain_model->Get_Country_master($this->input->post("Country_id"));
        $data["Symbol_of_currency"] = $currency_details->Symbol_of_currency;
        $Symbol_currency = $currency_details->Symbol_of_currency;

        if ($_SESSION['Coalition'] == 0) {//Non-Coalition
          $Cust_seller_balance = $Member_info["Current_balance"];
        }
        if ($member_details[0]["Photograph"] == "" || $member_details[0]["Photograph"] == NULL) {
          $Member_info["Photograph"] = base_url() . "images/No_Profile_Image.jpg";
        } else {
          $Member_info["Photograph"] = base_url() . $member_details[0]["Photograph"];
        }
        if ($User_activated == 1) {//Active customer
          $Info = array("status" => "1", "Member_info" => $Member_info, "Cust_seller_balance" => $Cust_seller_balance, "Cust_prepayment_balance" => $Cust_prepayment_balance, "Offers" => $Get_offers, "date_time" => $Greet_msg, "Symbol_currency" => $Symbol_currency);
        } else {
          $Info = array("status" => "0");
        }
        echo json_encode($Info);
      } else {
        $Info = array("status" => "0");
        echo json_encode($Info);
      }
    }
	
	function Setpassword() 
	{
		if(isset($_REQUEST['Pwd_data']))
		{
		$Pwd_data = json_decode(base64_decode($_REQUEST['Pwd_data']));
		$Pwd_variables = get_object_vars($Pwd_data);
	
		$data["SetCompany_id"]=$Pwd_variables["Company_id"];
		/*$data["SetEnroll_id"]=$Pwd_variables["Company_id"];
		$data["SetUser_email_id"]=$Pwd_variables["Company_id"]; */
		$data["Pwd_variables"]=$Pwd_variables;
	
		$Company_Details= $this->Igain_model->get_company_details($Pwd_variables["Company_id"]);
		$Website=$Company_Details->Website;
		$data["Website"]=$Website;
		$data["Company_logo"]=$Company_Details->Company_logo;
		}
		if($_POST ==NULL){
			
			$this->load->view('login/Set_password', $data);
			
		} else {
			
			
			$Enroll_id=$this->input->post('SetEnroll_id');
			$Company_id=$this->input->post('SetCompany_id');
			
			$post_data=array(
			
				'User_pwd' => App_string_encrypt($this->input->post('new_Password'))
			);
			
			$data["UpdatePwd"] = $this->Igain_model->update_password($Company_id,$Enroll_id,$post_data);
			
			if($data["UpdatePwd"])
			{
				echo '1';
			} else{
				 echo '0';
			}
		}
    }

  }

?>