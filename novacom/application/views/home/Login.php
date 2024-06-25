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
			$Company_id12 = '5'; // tamarind
			$flag = 2; // for member user type
			
			$data['Company_id'] = $Company_id12;
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($Company_id12);
			$data["Company_details"] = $Company_details;
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($Company_id12);
			/*******************AMIT 11-07-2017------------******************/
			/* $data["Redemption_Items"] = $this->Redemption_Model->get_all_items('','',$Company_id12,0,0,0,0,0,0);

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
			} */
			
			/*************************26-07-2017 AMIT Get Customer Recent Items*******************/
			//$data["Cust_Recently_viewed_items"] = $this->Redemption_Model->Get_Cust_Recent_merchandize_items($Company_id12,0);

			/*******************************sandeep 20-08-2019 ***************************/
			
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Cust_website = $Company['Cust_website'];
				$Outlet_Website = $Company['Website'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country);
			
			$data['Outlet_Website'] = $Outlet_Website;	
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			$Redemption_Items = $this->Shopping_model->get_all_items(6,0,$Company_id12,0,0,0,0,0,'');
			$data['count4'] = count($Redemption_Items);
            $data['Redemption_Items'] = $Redemption_Items;
			if($Redemption_Items != NULL)
			{
				foreach ($Redemption_Items as $product)
				{
					$itemCode = $product['Company_merchandize_item_code'];
					$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
					
					$itemID= $product['Company_merchandise_item_id'];
					$Redemption_Items_offers_array[$product['Company_merchandise_item_id']] = $this->Shopping_model->get_all_offers_items($itemID,$product['Company_id']);
					
					$data["Redemption_Items_offers_array"] = $Redemption_Items_offers_array;
				}
				// var_dump($data["Redemption_Items_offers_array"]);die;
				$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
				$data['Redemption_Items_offers'] = $Redemption_Items_offers_array;
				$Item_array=$data['Redemption_Items'];
			}
			/*******************************sandeep 20-08-2019 ***************************/
			
			foreach($data["Company_details"] as $cmpdtls)
			{
				$Partner_company_flag=$cmpdtls['Partner_company_flag'];
				$data['Company_primary_email_id']=$cmpdtls['Company_primary_email_id'];
				$data['Company_primary_phone_no']=$cmpdtls['Company_primary_phone_no'];
				$Parent_company=$cmpdtls['Parent_company'];
				$data['Company_address']=$cmpdtls['Company_address'];
				/************AMIT 05-08-2017*************************************/
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
				
				/**********************Login Masking****************************/

				/*  if(!isset($_REQUEST['masking_flag']) )
				{
					$this->load->view('login/login_masking', $data);
				}
				else
				{
					$this->load->view('login/login', $data);
				}  */
				
				$this->load->view('login/login', $data);
				/*********************************************************/
			}
			else
			{
				$session_data = $this->session->userdata('cust_logged_in');
				$data['enroll'] = $session_data['enroll'];
				$data['Company_id'] = $session_data['Company_id'];
				$Company_id = $session_data['Company_id'];
				$data['Member_flag'] = 1;
				
				$enc_uname = App_string_encrypt($_REQUEST['email']); 
				$enc_upass = App_string_encrypt($_REQUEST['password']); 
				
				// $result = $this->Login_model->login($_REQUEST['email'],$_REQUEST['password'],$Company_id12,$flag);
				$result = $this->Login_model->login($enc_uname,$enc_upass,$Company_id12,$flag);
			
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
							'Cust_website'=>$Cust_website,
							'Outlet_Website'=>$Outlet_Website,
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
					}
					
					$FetchedClientCompanys = $this->Igain_model->get_partner_companys($Loggin_User_id,$Company_id);
					$data['Company_array'] = $FetchedClientCompanys;
				
					if($Loggin_User_id == 1)
					{
						if($this->session->userdata('cust_logged_in'))
						{
							/*********************Check first time login**************************/
							/* $Check_first_time_login = $this->Igain_model->first_time_login($Company_id,$userName,$Enrollement_id,$userId);

							$this->login_mail($session_data['enroll'],"Browser");
							
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
									$Insert_into_session = $this->Login_model->insert_into_session($Company_id,$userName,$Enrollement_id,$userId,$flag,$lv_date_time);
								/*---------------Insert into Session--Ravi 25-03-2018------------------*/

								$session_data = $this->session->userdata('cust_logged_in');
								
								/* $callcenterticket=$_REQUEST['callcenterticket'];
								$redeemflag=$_REQUEST['redeemflag']; */
								
								$callcenterticket = 0;
								$redeemflag = 0;
								
								if($callcenterticket == 1)
								{
									redirect('Cust_home/contactus');
								}
								elseif($redeemflag == 1)
								{
									$data['Total_balance']=($Current_balance -($Blocked_points+$Debit_points));
									// $this->load->view('testview',$data);
									// redirect('Redemption_Catalogue');
								}
								else
								{
									redirect('Cust_home/home');
								}
							//}
						}
						else
						{
							$this->session->set_flashdata("messege","Invalid user email id or password");	
							// $this->load->view('login/login', $data);
							redirect($Cust_website);	
						}
					}
					else
					{
						$this->session->set_flashdata("messege","Invalid user email id or password");	
						// $this->load->view('login/login', $data);
						redirect($Cust_website);	
					}
				}
				else
				{
					$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id12);
					$timezone_entry=$Super_Seller_details->timezone_entry;			
					$logtimezone = $timezone_entry;
					$timezone = new DateTimeZone($logtimezone);
					$date = new DateTime();
					$date->setTimezone($timezone);
					$lv_date_time=$date->format('Y-m-d H:i:s');

					$Insert_failed_login = $this->Login_model->Insert_failed_login($Company_id12,$_REQUEST['email'],$_REQUEST['password'],$user_type=1,$lv_date_time);

					$Response_code = array(
								"Error_flag" => 2005,
								"Message" => 'Invalid user email id or password' //Invalid Username or Password
							  );
					$this->session->set_flashdata("messege","Invalid user email id or password");	
					redirect($Cust_website);	
					// $this->load->view('login/login', $data);	
					// echo json_encode($Response_code); 
					// exit;
					// redirect('https://www.figma.com/proto/SaRbjC9oRbFuaaoeJ3csyW/kukito_desk?node-id=3%3A20&scaling=min-zoom');

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
						//$this->load->view('login/login_masking', $data);
						 $this->load->view('login/login',$data);
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
	
		/****************************AMIT START 19-08-2019*************************************************/

	public function track_order()
	{
			$Company_id12 = '5';
			$data['Company_id'] = $Company_id12;
			$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id12);
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($Company_id12);
			
			foreach($data["Company_details"] as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			foreach($data["Company_details"] as $cmpdtls)
			{
				$Partner_company_flag=$cmpdtls['Partner_company_flag'];
				$data['Company_primary_email_id']=$cmpdtls['Company_primary_email_id'];
				$data['Company_primary_phone_no']=$cmpdtls['Company_primary_phone_no'];
				$data['Company_address']=$cmpdtls['Company_address'];
				$Parent_company=$cmpdtls['Parent_company'];
				
				/************AMIT 05-08-2017*************************************/
				$this->session->set_userdata('site_lang', $cmpdtls['Country_language']);
				$this->session->set_userdata('Text_direction', $cmpdtls['Text_direction']);
				/*************************************************/
			}
			
		$this->load->view('login/track-order-on',$data);
	}
	
	public function food_menu()
	{
			$Company_id12 = '5';
			$data['Company_id'] = $Company_id12;
			$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id12);
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($Company_id12);
			
			foreach($data["Company_details"] as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			foreach($data["Company_details"] as $cmpdtls)
			{
				$Partner_company_flag=$cmpdtls['Partner_company_flag'];
				$data['Company_primary_email_id']=$cmpdtls['Company_primary_email_id'];
				$data['Company_primary_phone_no']=$cmpdtls['Company_primary_phone_no'];
				$data['Company_address']=$cmpdtls['Company_address'];
				$Parent_company=$cmpdtls['Parent_company'];
				
				/************AMIT 05-08-2017*************************************/
				$this->session->set_userdata('site_lang', $cmpdtls['Country_language']);
				$this->session->set_userdata('Text_direction', $cmpdtls['Text_direction']);
				/*************************************************/
			}
			
			//Pagination----------------------------------------
				if (isset($_GET['pageno'])) {
				$data['pageno'] = $_GET['pageno'];
				} else {
					$data['pageno'] = 1;
				}
				//echo "<br>pageno :: ".$data['pageno'];
				$no_of_records_per_page = 12;
				$offset = ($data['pageno']-1) * $no_of_records_per_page;
				//echo "<br>offset :: ".$offset;
				// Formula for pagination
				$Count_Redemption_Items = $this->Login_model->get_all_items_nova('','',$Company_id12,0,0);
				$data['total_pages'] = ceil(count($Count_Redemption_Items) / $no_of_records_per_page);
				//echo "<br>Count_Redemption_Items  :: ".count($Count_Redemption_Items);
				//echo "<br>total_pages :: ".$data['total_pages'];
			//Pagination-XXX---------------------------------------
				
			$Redemption_Items = $this->Login_model->get_all_items_nova($no_of_records_per_page,$offset,$Company_id12,0,0);
			if($_REQUEST['item_name'] != '')
			{
				$Redemption_Items = $this->Login_model->get_all_items_nova('','',$Company_id12,0,$_REQUEST['item_name']);
				//print_r($Redemption_Items);
			}
			if($_REQUEST['catid'] != 0)
			{
				$Redemption_Items = $this->Login_model->get_all_items_nova('','',$Company_id12,$_REQUEST['catid'],'');
				//print_r($Redemption_Items);
			}
			
            $data['Redemption_Items'] = $Redemption_Items;
			
			/*******************************sandeep 20-08-2019 ***************************/

			foreach($data["Company_details"] as $cmpdtls)
			{
				$Partner_company_flag=$cmpdtls['Partner_company_flag'];
				$data['Company_primary_email_id']=$cmpdtls['Company_primary_email_id'];
				$data['Company_primary_phone_no']=$cmpdtls['Company_primary_phone_no'];
				$Parent_company=$cmpdtls['Parent_company'];
				/************AMIT 05-08-2017*************************************/
				$this->session->set_userdata('site_lang', $cmpdtls['Country_language']);
				$this->session->set_userdata('Text_direction', $cmpdtls['Text_direction']);
				/*************************************************/
			}

			$data["Company_partner_cmp"] = $this->Igain_model->Fetch_Company_Details($Parent_company);
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($Company_id12);	
		$this->load->view('login/food_menu', $data);
	}
	
	function Voucher_validation() 
	{
        $Order = $this->input->post("Order");
        $Company_id = $this->input->post("Company_id");
		$result = $this->Login_model->validate_voucher($Order,$Company_id);
		
		if(count($result) > 0)
		{
			$data['result']=$result;
			$theHTMLResponse = $this->load->view('login/ordered_items', $data, true);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('ordered_items'=> $theHTMLResponse)));
			//$this->output->set_output(json_encode(array('Voucher_no'=> $result->Voucher_no,'Trans_date'=> $result->Trans_date,'Voucher_status'=> $result->Code_decode,'Item_image'=> $result->Item_image1)));
		}
		else    
		{
			$this->output->set_output(0);
		}
    }
	/****************************AMIT END *********************************************************************/
	function Setpassword() 
	{
		$Pwd_data = json_decode(base64_decode($_REQUEST['Pwd_data']));
		$Pwd_variables = get_object_vars($Pwd_data);
	
		$data["SetCompany_id"]=$Pwd_variables["Company_id"];
		$data["SetEnroll_id"]=$Pwd_variables["Enroll_id"];
		$data["SetUser_email_id"]=$Pwd_variables["User_email_id"]; 
		$data["Pwd_variables"]=$Pwd_variables;
		
		$Company_Details= $this->Igain_model->get_company_details($Pwd_variables["Company_id"]);
		$Cust_website=$Company_Details->Cust_website;
		$data["Cust_website"]=$Cust_website;
		
		if($_POST == NULL)
		{
			$this->load->view('login/Set_password', $data);
		} 
		else 
		{
			$Enroll_id=$this->input->post('SetEnroll_id');
			$Company_id=$this->input->post('SetCompany_id');
		
			$post_data=array(
			
				'User_pwd' => App_string_encrypt($this->input->post('new_Password'))
			);
			
			$data["UpdatePwd"] = $this->Igain_model->update_password($Company_id,$Enroll_id,$post_data);
			
			if($data["UpdatePwd"])
			{
				echo '1';
			} 
			else
			{
				echo '0';
			}
		}
    }
} 
?>