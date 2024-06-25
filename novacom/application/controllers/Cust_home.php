<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// error_reporting(0);
class Cust_home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->model('Game_model');
		$this->load->model('Survey_model');
		$this->load->model('Users_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->library("Excel");
		$this->load->library('m_pdf');
		$this->load->library('Send_notification');
		$this->load->model('survey/Survey_model');
		$this->load->library('cart');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->helper(array('form', 'url','encryption_val'));	


		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$Company_Details= $this->Igain_model->get_company_details($session_data['Company_id']);
			$this->key=$Company_Details->Company_encryptionkey;

		}

		$this->iv = '56666852251557009888889955123458';
	}
	function index()
	{
		$this->load->view('login/login');
	}
	function register()
	{
		$this->load->view('login/register');
	}
	function forgot()
	{
		if($_REQUEST)
		{
			$email = App_string_encrypt($_REQUEST['email']);	
			$Company_id = $_REQUEST['Company_id'];	
			$data['Company_id'] = $Company_id;	
			$flag = 2; 
			
			$Company_Details= $this->Igain_model->get_company_details($Company_id);
			$Cust_website=$Company_Details->Cust_website;
			$Website=$Company_Details->Website;
			
			$result = $this->Igain_model->forgot_email_notification($email,$Company_id);

			if($result != NULL || $result > 0)
			{
				$Email_content = array(
					'Password' => $result->User_pwd,
					'Notification_type' => 'Request to Set Password',
					'Template_type' => 'Forgot_password'
				);

				$this->send_notification->send_Notification_email($result->Enrollement_id,$Email_content,'1',$Company_id);

				if($flag == 2)
				{
					/*********************Nilesh igain Log Table change 27-06-207*************************/
						$Enrollment_id = $result->Enrollement_id;
						$User_id = 1;
						$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
						$opration = 1;
						// $userid = $User_id;
						$what="forgot password";
						$where="Member Login";
						$toname="";
						$toenrollid = 0;
						$opval = 'Member Name:'.$Enroll_details->First_name.' '.$Enroll_details->Last_name.', EnrollID: '.$Enrollment_id.'Password:XXXXXXXX';
						$Todays_date=date("Y-m-d");
						$firstName = $Enroll_details->First_name;
						$lastName = $Enroll_details->Last_name;
						$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$email,$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 27-06-2017 *************************/

					// $result  = array();
					// $result['eml']='1';
					
					$Response_code = array(
											"Error_flag" => 1001 ,
											"Message" => 'Login credentials are sent to your email...please check it' 
										); 
					$this->session->set_flashdata("messege","Login credentials are sent to your email...please check it");			
					//echo json_encode($Response_code); //Status Ok Credentials are sent to email
					//redirect('login');
					if($_REQUEST['Forgot_flag']==2)//Outlet Forgot_flag
					{
						redirect($Website);
					}
					else
					{
						redirect($Cust_website);
					}
					
					//$this->load->view('login/login', $data);
					//exit;
					
					// $this->output->set_output("Login Credentials are sent to your email...please check it");
				}
				else
				{
					// echo '2';
				}
			}
			else
			{
				$Response_code = array(
									"Error_flag" => 2009,
									"Message" => 'Invalid member email id' 
									); //Invalid Member Email
				$this->session->set_flashdata("messege","Invalid member email id");			
					
					if($_REQUEST['Forgot_flag']==2)//Outlet Forgot_flag
					{
						redirect($Website);
					}
					else
					{
						redirect($Cust_website);
					}
			}
		}
		else
		{
			redirect($Cust_website);
		}
	}
	public function home()
	{
		$SellerOffers= array();
		$i=0;
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);

			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["Delivery_Transaction_Details"] = $this->Igain_model->Fetch_Delivery_Transaction_Details($data['enroll'],$data['Card_id']);
			
			$data["My_statement_details"] = $this->Igain_model->Fetch_statement_trans_details($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			// $data["MerchandiseProduct"] = $this->Igain_model->FetchMerchandiseProduct($data['Company_id']);
			$Company_seller = $this->Igain_model->FetchCompanySeller($data['Company_id']);

			$data["Customer_profile_status"] = $this->Igain_model->Member_profile_status($data['enroll'],$session_data['Company_id']);
			$Company_Details= $this->Igain_model->get_company_details($session_data['Company_id']);
			$data['Profile_complete_flag']=$Company_Details->Profile_complete_flag;
			$data['Profile_complete_points']=$Company_Details->Profile_complete_points;



			$today=date('Y-m-d');
			$data['Company_TOP3_Auction']  = $this->Igain_model->Fetch_TOP3_Company_Auction($data['Company_id'],$today);

			$data["Trans_details_summary"] = $this->Igain_model->get_cust_trans_summary_all($data['Company_id'],$data['enroll']);

			$data["total_gain_points"] = $this->Igain_model->get_cust_total_gain_points($data['Company_id'], $data['enroll'], $data['Card_id']);
			
			$data["total_transfer_points"] = $this->Igain_model->get_cust_total_transfer_points($data['Company_id'], $data['enroll'], $data['Card_id']);

			$data["freebies_merchandize_items"] = $this->Igain_model->Get_latest_merchandize_items_freebies($data['Company_id'],$today,$data['enroll']);
			$data["Laest_merchandize_items"] = $this->Igain_model->Get_latest_merchandize_items($data['Company_id'],$today);

			/*************************07-07-2017 AMIT Get Customer Recent Items******************************/
			$data["Cust_Recently_viewed_items"] = $this->Redemption_Model->Get_Cust_Recent_merchandize_items($data['Company_id'],$data['enroll']);

			/*************************************************************************************/
			$data['key']=$this->key;
			$data['iv']=$this->iv;





			$f=0;
			$customer_notifications = $this->Igain_model->Fetch_customer_notifications($data['enroll'],$data['Company_id']);

			if($customer_notifications != NULL || $customer_notifications != "")
			{
				foreach($customer_notifications as $cust_noti)
				{
					if($cust_noti['Communication_id'] != 0)
					{
						foreach($Company_seller as $Seller)
						{
							$SellerOffers132 = $this->Igain_model->Fetch_Merchant_offers($Seller['Enrollement_id'],$cust_noti['Communication_id']);

							if(count($SellerOffers132) > 0)
							{
								$SellerOffers[$f] = $SellerOffers132;
							}
							$f++;
						}
					}
				}
			}
			$data['SellerOffers'] = $SellerOffers;
			$data["All_Merchants_details"] = $this->Igain_model->Fetch_All_Merchants($data['Company_id']);
			/*************************07-07-2017 AMIT Get Customer Recent Items*******************/
			$data["Cust_Recently_viewed_items"] = $this->Redemption_Model->Get_Cust_Recent_merchandize_items($data['Company_id'],$data['enroll']);


			/*************************************************************************************/
			/*****amit 25-07-2017*****Insert item in cart****************/
			/*******Add Items in Cart*******************/
			$Total_items=$this->cart->total_items();
			$Total_items_contents=$this->cart->contents();
			$Total_points=$this->cart->total();
			// print_r($Total_items_contents);die;
			if($Total_items!=0)
			{
				foreach ($Total_items_contents as $items)
				{

					for($i=0;$i<$items['qty'];$i++)
					{

						$insert_data = array(
						'Item_code' => $items['options']['Company_merchandize_item_code'],
						'Redemption_method' => $items['options']['Redemption_method'],
						'Weight' => $items['options']['Item_Weight'],
						'Weight_unit_id' => $items['options']['Weight_unit_id'],
						'Branch' => $items['options']['partner_branch'],
						'Points' => $items['price'],
						'Company_id' => $data['Company_id'],
						'Enrollment_id' => $data['enroll'],
						'Size' => $items['options']['Size']
						);
						if($items['options']['E_commerce_flag']==0)
						{
							$result = $this->Redemption_Model->insert_item_catalogue($insert_data);
							$data24 = array(
							'rowid'      => $items['rowid'],
							'qty'     => 0
								);

							$result24=$this->cart->update($data24);
						}

					}
				}

				if($items['options']['E_commerce_flag']==0)
				{
					 $this->cart->destroy();
					redirect('Redemption_Catalogue/Proceed_Redemption_Catalogue/?Total_Redeem_points='.$Total_points);
				}
			}
			
			$Enroll_details=$data['Enroll_details'];
			$Tier_id=$Enroll_details->Tier_id;
			$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$data['Company_id']);
			
			$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($session_data['Company_id']);
			$seller_Countryid=$Super_Seller_details->Country;
			$data["Country_details"] = $this->Igain_model->Get_Country_master($seller_Countryid);
			
			// Get_Country_master($id)

			/*******************AMIT 25-07-2017--END----------******************/

			$this->load->view('login/Cust_home', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	public function freebies_items()
	{

		$SellerOffers= array();
		$i=0;
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			// $data["All_Merchants_details"] = $this->Igain_model->Fetch_All_Merchants($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Company_Details"] = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			$today=date('Y-m-d');
			// $data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$data["freebies_merchandize_items"] = $this->Igain_model->Get_latest_merchandize_items_freebies($data['Company_id'],$today,$data['enroll']);

			$this->load->view('home/freebiesmerchandizeitems', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	public function merchant_list()
	{
		// $this->output->enable_profiler(TRUE);
		$SellerOffers= array();
		$i=0;
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["All_Merchants_details"] = $this->Igain_model->Fetch_All_Merchants($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);

			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);

			$this->load->view('home/merchant_list', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	function profile()
	{
		$i=0;
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			$data['Country_array']= $this->Igain_model->FetchCountry();
			$data['States_array'] = $this->Igain_model->Get_states($data["Enroll_details"]->Country);
			$data['Outlet_cites'] = $this->Igain_model->Fetch_outlet_cites($data["Company_id"]);
			$data['City_array'] = $this->Igain_model->Get_cities($data["Enroll_details"]->State);
			$CompanyId= $session_data['Company_id'];
			$Enroll_details=$data['Enroll_details'];
			$Tier_id=$Enroll_details->Tier_id;
			$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$CompanyId);
			$data["Gift_card_details"] = $this->Igain_model->get_giftcard_details($data['Card_id'],$session_data['Company_id']);
			$data["Hobbies_interest"] = $this->Igain_model->get_hobbies_interest_details($data['enroll'],$session_data['Company_id']);
			$data["All_hobbies"] = $this->Igain_model->get_all_hobbies_details();
			$data["Customer_profile_status"] = $this->Igain_model->Member_profile_status($data['enroll'],$session_data['Company_id']);

			$dial_code = $this->Igain_model->get_dial_code($Enroll_details->Country);
			
			// $exp=explode($dial_code->phonecode,$Enroll_details->Phone_no);
			$Phone_no = App_string_decrypt($Enroll_details->Phone_no);
			$exp=explode($dial_code->phonecode,$Phone_no);
			$data['phnumber'] = $exp[1];

			$this->load->view('home/profile', $data);
			}
			else
			{
				redirect('login', 'refresh');
			}
	}
	public function updateprofile()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Customer_details= $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data['Country_array']= $this->Igain_model->FetchCountry();
			$data['States_array'] = $this->Igain_model->Get_states($data["Enroll_details"]->Country);
			$data['City_array'] = $this->Igain_model->Get_cities($data["Enroll_details"]->State);

			$Company_Details= $this->Igain_model->get_company_details($session_data['Company_id']);
			$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($session_data['Company_id']);
			$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
			$seller_id=$Super_Seller_details->Enrollement_id;

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

			$config['upload_path'] = '../uploads/'; /* NB! create this dir! */
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
			  $upload = $this->upload->do_upload('image1');
			  $data = $this->upload->data();

			    if($data['is_image'] == 1)
				{
					$configThumb['source_image'] = $data['full_path'];
					$configThumb['source_image'] = '../uploads/'.$upload;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='uploads/'.$data['file_name'];
				}
				else
				{
					$filepath=$Customer_details->Photograph;;
				}
				
			if($_POST != "")
			{	
				/**********AMIT 08-11-2017****************************/
				$phno=$this->input->post("phno");
				$Country=$this->input->post("country");
				$Dial_Code = $this->Igain_model->get_dial_code($Country);
				$dialcode=$Dial_Code->phonecode;
				$phoneNo=$dialcode.''.$phno;
				/************************************************/
				
			/******************Nilesh change 07-11-2019********************/			
				/* $Enrollment_id =  $this->input->post('Enrollment_id');
				$Company_id =  $this->input->post('Company_id');
				$Card_id=$this->input->post('membership_id'); */
				
				$Enrollment_id =  $session_data['enroll'];
				$Company_id = $session_data['Company_id'];
				$Card_id = $session_data['Card_id'];
				
				$Building_name=$_REQUEST['Building_name'];
				$House_no=$_REQUEST['House_no'];
				$Street_road=$_REQUEST['Street_road'];
				$Additional=$_REQUEST['Additional'];
				
				$Building_name = preg_replace('/[^A-Za-z0-9\-]/', ' ', $Building_name);
				$House_no = preg_replace('/[^A-Za-z0-9\-]/', ' ', $House_no);
				$Street_road = preg_replace('/[^A-Za-z0-9\-]/', ' ', $Street_road);
				$Additional = preg_replace('/[^A-Za-z0-9\-]/', ' ', $Additional);
				
				$currentAddress =$Building_name.','.$House_no.','.$Street_road.','.$Additional;
				
				$BirthDate = $this->input->post('dob');
				if($BirthDate != NULL)
				{
					$Date_of_birth = date('Y-m-d H:i:s',strtotime($BirthDate));
				}
				
				$Wedding_annversary= $this->input->post('Wedding_annversary_date');
				if($Wedding_annversary != NULL)
				{
					$WeddingAnnversary = date('Y-m-d H:i:s',strtotime($Wedding_annversary));
				}
			/*********************Nilesh change 07-11-2019*********************/	
				$post_data = array(
						'First_name' => $this->input->post('firstName'),
						'Middle_name' => $this->input->post('middleName'),
						'Last_name' => $this->input->post('lastName'),
						// 'Current_address' => $currentAddress,
						'Current_address' => App_string_encrypt($currentAddress),
						'State' => $this->input->post('state'),
						'District' => $this->input->post('district'),
						'City' => $this->input->post('city'),
						'Zipcode' => $this->input->post('zip'),
						// 'Country' => $this->input->post('country'),
						// 'User_email_id' => $this->input->post('userEmailId'),
						'User_email_id' => App_string_encrypt($this->input->post('userEmailId')),
						// 'Phone_no' => $phoneNo,
						'Phone_no' => App_string_encrypt($phoneNo),
						// 'Date_of_birth' => date('Y-m-d H:i:s',strtotime($this->input->post('dob'))),
						'Date_of_birth' => $Date_of_birth,
						'Qualification' => $this->input->post('Profession'),
						// 'Experience' => $this->input->post('Experience'),
						// 'Wedding_annversary_date' => date('Y-m-d H:i:s',strtotime($this->input->post('Wedding_annversary_date'))),
						'Wedding_annversary_date' => $WeddingAnnversary,
						'Married' => $this->input->post('Marital_status'),
						'Sex' => $this->input->post('Sex'),
						'Photograph' => $filepath
					);
				
				$result = $this->Igain_model->update_profile($post_data,$Enrollment_id);
				
				if($result == true)
				{
					$Customer_profile_status= $this->Igain_model->Member_profile_status($Enrollment_id,$Company_id);
					if($Customer_profile_status =='100' && $Customer_details->Profile_complete_flag=='0' && $Company_Details->Profile_complete_flag=='1')
					{
						$profile_status_flag= $this->Igain_model->Update_member_profile_status_flag($Enrollment_id,$Company_id);
						// echo"--Get Bonus Complete--profile_status---<br>";
						$Current_balance=$Customer_details->Current_balance;
						$new_balance=$Current_balance+round($Company_Details->Profile_complete_points);
						$post_Transdata = array(
									'Trans_type' => '1',
									'Company_id' => $Company_id,
									'Topup_amount' =>round($Company_Details->Profile_complete_points),
									'Trans_date' => $lv_date_time,
									'Remarks' => 'Profile Completion',
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
						$result3 = $this->Igain_model->update_seller_balance($Enrollment_id,$new_balance);

						$Email_content = array(
						'Profile_bonus' => round($Company_Details->Profile_complete_points),
						'Notification_type' => 'Profile Completion Reward '.$Company_Details->Currency_name,
						'Template_type' => 'Profile_completion_bonus'
						);
						$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'',$Company_id);
					}
					/*********************Nilesh igain Log Table change 27-06-207*************************/
						$Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
						$opration = 2;
						$userid = $session_data['userId'];
						$what="Update Profile";
						$where="My Profile";
						$toname="";
						$toenrollid = 0;
						$opval = 'Update My Profile';
						$Todays_date=date("Y-m-d");
						$firstName = $Enroll_details->First_name;
						$lastName = $Enroll_details->Last_name;
						$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 27-06-2017 *************************/

					// $this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("error_code","Profile Updated Successfuly. Your profile ".$Customer_profile_status."% Completed !!");
				}
				redirect('Cust_home/profile');
			}
			else
			{
				$this->load->view('home/profile', $data);
			}
			$this->load->view('home/profile', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	public function update_promocode()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$EnrollId=$Enroll_details12->Enrollement_id;
			$mail_to=$Enroll_details12->User_email_id;
			$EnrollId=$Enroll_details12->Enrollement_id;
			$timezone_entry=$Enroll_details12->timezone_entry;

			$logtimezone = $timezone_entry;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');

			if($_POST == NULL)
			{
				$this->load->view('home/promocode', $data);
			}
			else
			{
				$promo_code =  $this->input->post('promo_code');
				$Company_id =  $this->input->post('Company_id');
				$Enrollment_id =  $this->input->post('Enrollment_id');
				$Current_balance =  $this->input->post('Current_balance');
				$membership_id =  $this->input->post('membership_id');
				$post_data = array('Promo_code_status' =>'1');

				$Promocode_Details=$this->Igain_model->get_promocode_details($promo_code,$Company_id);
				$PromocodePoints=$Promocode_Details->Points;  //echo"---PromocodePoints--".$PromocodePoints."<br>";
				$Promo_code_status=$Promocode_Details->Promo_code_status;  //echo"---Promo_code_status--".$Promo_code_status."<br>";
				$To_date=$Promocode_Details->To_date;    //echo"---To_date--".$To_date."<br>";
				$From_date=$Promocode_Details->From_date;    //echo"---From_date--".$From_date."<br>";

				if($Promo_code_status !="" || $Promo_code_status !=0)
				{
					$result = $this->Igain_model->update_promocode($post_data,$promo_code,$Company_id,$Enrollment_id,$Current_balance,$membership_id,$lv_date_time);
					$Notification=$this->send_Notification_email($data['enroll'],$mail_to,$promo_code,$Company_id);
					$SuperSeller=$this->Igain_model->get_super_seller_details($data['Company_id']);
					$SuperSellerEnrollID=$SuperSeller->Enrollement_id;
					if($result == true)
					{
						$Email_content = array(
							'PromocodePoints' => $PromocodePoints,
							'Promo_code' => $promo_code,
							'Notification_type' => 'Promo Code',
							'Template_type' => 'Promo_code'
						);
						$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$SuperSellerEnrollID,$Company_id);

					/*********************Nilesh igain Log Table change 27-06-207*************************/
						$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
						$opration = 2;
						$userid = $session_data['userId'];
						$what="Promo Code Used";
						$where="Promo Code";
						$toname="";
						$toenrollid = 0;
						$opval ='Promo Code- '.$promo_code. ', '.'('.$PromocodePoints. " Points)";
						$Todays_date=date("Y-m-d");
						$firstName = $Enroll_details->First_name;
						$lastName = $Enroll_details->Last_name;
						$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 27-06-2017 *************************/

						$this->session->set_flashdata("error_promo","Congrats! You have got a extra  ".$PromocodePoints." Points !!");
					}
				}
				else
				{
					$this->session->set_flashdata("error_promo","Your promo code has expired!!");
				}
				$this->load->view('home/promocode', $data);

			}
		}
		else
		{
			redirect('login', 'refresh');
		}

	}
	function promocode()
	{
		$i=0;
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);

			$this->load->view('home/promocode', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	function auctionbidding()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			// $data["MerchandiseProduct"] = $this->Igain_model->FetchMerchandiseProduct($session_data['Company_id']);

			$today=date('Y-m-d');
			$Auction_array = $this->Igain_model->FetchCompanyAuction($data['Company_id'],$today);
			$data['CompanyAuction'] = $Auction_array;

			foreach($Auction_array as $Auction)
			{
					$Total_Auction_Bidder[ $Auction['Auction_id'] ] = $this->Igain_model->Auction_Total_Bidder($Auction['Auction_id'],$data['Company_id']);
					$data["Total_Auction_Bidder"] = $Total_Auction_Bidder;
					$Top5_Auction_Bidder[ $Auction['Auction_id'] ] = $this->Igain_model->Auction_Top_Bidder($Auction['Auction_id'],$data['Company_id']);
					$data["Top5_Auction_Bidder"] = $Top5_Auction_Bidder;

					$Auction_Max_Bid_val[ $Auction['Auction_id'] ] = $this->Igain_model->Auction_Max_Bid_Value($Auction['Auction_id'],$data['Company_id']);
					$data["Auction_Max_Bid_val"] = $Auction_Max_Bid_val;
			}

			$this->load->view('home/auction_bidding', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function merchantoffers()
	{ 
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details=$data['Enroll_details'];
			$Tier_id=$Enroll_details->Tier_id;
			$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$data['Company_id']);
			
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			// $data["MerchantOffers"] = $this->Igain_model->FetchMerchantOffers($session_data['Company_id']);
			$Company_seller = $this->Igain_model->FetchCompanySeller($data['Company_id']);
			$Company_super_seller = $this->Igain_model->FetchCompanySuperSeller($data['Company_id']);
			$f= 0;
			foreach($Company_seller as $Seller)
			{
					$SellerOffers132 = $this->Igain_model->Fetch_Seller_Loyalty_Offers($Seller['Enrollement_id']);
					if(!is_null($SellerOffers132))
					{
						$SellerLoyalty[$f] = $SellerOffers132;
					}
					$f++;
			}
			$data['SellerLoyaltyOffers'] = $SellerLoyalty;
		
			$data["MerchantLoyaltyDetails"] = $this->Igain_model->Fetch_Merchant_Loyalty_Offers($Company_super_seller->Enrollement_id,$data['Company_id']);
			
			$data['Photograph'] = $Company_super_seller->Photograph;
			
			$customer_notifications = $this->Igain_model->Fetch_customer_notifications($data['enroll'],$data['Company_id']);
			
			foreach($customer_notifications as $cust_noti)
			{
				if($cust_noti['Communication_id'] != 0)
				{
					$Communication_id[] = $cust_noti['Communication_id'];
				}
			}
			
			$data['MerchantCommunication'] = $this->Igain_model->Fetch_Merchant_offers2($Company_super_seller->Enrollement_id,$Communication_id);
			
			$k=0;
			foreach($Company_seller as $Seller)
			{
					$SellerOffers132 = $this->Igain_model->FetchSellerOffers($Seller['Enrollement_id'],$data['Company_id'],$data['enroll']);

					if(!is_null($SellerOffers132))
					{
						$SellerOffers[$k] = $SellerOffers132;
					}
					$k++;
			}
			$data['SellerCommunicationOffers'] = $SellerOffers;

			$j=0;
			foreach($Company_seller as $Seller)
			{
				$SellerReferral32 = $this->Igain_model->Fetch_Seller_Referral_Offers($Seller['Enrollement_id'],$data['Company_id']);

				if(!is_null($SellerReferral32))
				{
					$SellerReferral[$j] = $SellerReferral32;
				}
				$j++;
			}
			$data['SellerReferralOffers'] = $SellerReferral;

			if($_POST)
			{
				$data['MerchantCommunication'] = $this->Igain_model->FetchMerchantCommunicationDetails($_POST['enrollId']);
			}
			$this->load->view('home/merchantoffers', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	function merchant_loyalty_offer()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["MerchantLoyaltyDetails"] = $this->Igain_model->Fetch_Merchant_Loyalty_Offers($_POST['enrollId'],$_POST['comp_id']);
			$theHTMLResponse = $this->load->view('home/merchant_loyalty_offer', $data, true);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('transactionDetailHtml'=> $theHTMLResponse)));

		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function show_Communication_offer()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$customer_notifications = $this->Igain_model->Fetch_customer_notifications($data['enroll'],$data['Company_id']);
			foreach($customer_notifications as $cust_noti)
			{
				if($cust_noti['Communication_id'] != 0)
				{
					$Communication_id[] = $cust_noti['Communication_id'];
				}
			}

			// $data['MerchantOfferDetails'] = $this->Igain_model->Fetch_Merchant_Loyalty_Offers($_POST['enrollId'],$_POST['comp_id']);
			// $data['MerchantCommunication'] = $this->Igain_model->FetchMerchantCommunicationDetails($_POST['enrollId']);
			$data['MerchantCommunication'] = $this->Igain_model->Fetch_Merchant_offers2($_POST['enrollId'],$Communication_id);


			// $theHTMLResponse = $this->load->view('home/merchantoffers', $data);
			$theHTMLResponse = $this->load->view('home/merchant_communication_offer', $data, true);

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('transactionDetailHtml'=> $theHTMLResponse)));


		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function show_referral_offers()
	{
		$data["MerchantReferralOffers"] = $this->Igain_model->Fetch_referral_offers($this->input->post('Seller_id'),$this->input->post('Company_id'));
		$theHTMLResponse = $this->load->view('home/merchant_referral_offer', $data, true);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('referralDetailHtml'=> $theHTMLResponse)));
	}
	function logout()
	{
		$session_data = $this->session->userdata('cust_logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Cust_website = $session_data['Cust_website'];
		$this->session->unset_userdata('cust_logged_in');
		$this->session->unset_userdata('delivery_session');
		/**********************Login Masking****************************/
		$_SESSION['Login_masking']=0;
		unset($_SESSION['Login_masking']);
		/**********************Login Masking*****XXX***********************/
		$data['Member_flag'] = 1;
		redirect($Cust_website);
		
	}
	function mailbox()
	{

	
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			// $Company_Details= $this->Igain_model->get_company_details($session_data['Company_id']);

			// $data['key']=$Company_Details->Company_encryptionkey;
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			

			/*-----------------------Pagination---------------------*/
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Cust_home/mailbox";
			$total_row = $this->Igain_model->Open_Notification_Count($data['enroll'],$data['Company_id']);
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

			// $data["results"] = $this->Igain_model->merchant_item_list($config["per_page"], $page);
			$data["AllNotifications"] = $this->Igain_model->Fetch_Open_Notification_Details($config["per_page"],$page,$data['enroll'],$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();



			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["ReadNotificationsCount"] = $this->Igain_model->Fetch_Read_Notification_Count($data['enroll'],$data['Company_id']);
			$data["AllNotificationsCount"] = $this->Igain_model->Fetch_All_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			
			$this->load->view('mailbox/mailbox',$data);


		}
		else
		{
			redirect('login', 'refresh');
		}

	}
	function compose()
	{
		if($this->session->userdata('cust_logged_in'))
		{

			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["ReadNotificationsCount"] = $this->Igain_model->Fetch_Read_Notification_Count($data['enroll'],$session_data['Company_id']);

			$data["AllNotificationsCount"] = $this->Igain_model->Fetch_All_Notification_Count($data['enroll'],$session_data['Company_id']);
			$Company_Details= $this->Igain_model->get_company_details($session_data['Company_id']);

			if($_REQUEST !="")
			{	

					$Id=ltrim(rtrim($_REQUEST['Id']));
					$decryptID1 = $this->string_decrypt($Id,$this->key, $this->iv);	
					$decryptID = preg_replace("/[^(\x20-\x7f)]*/s", "",$decryptID1);							
					// echo "---decryptID---".$decryptID."---<br>";
					if($decryptID == "")
					{
						// redirect('Errors', 'refresh');
						 $this->load->view('err404',$data); 

					} 
					else 
					{

						$data["Notifications"] = $this->Igain_model->FetchNotifications($decryptID);
						$post_data = array(
							'Open_flag' =>'1'
						);
						$result = $this->Igain_model->Update_Notification($post_data,$decryptID);
						$this->load->view('mailbox/compose',$data);
					}

				

					// die;

				

			}

			 
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function getUrls($string)
	{
		$regex = '/https?\:\/\/[^\" ]+/i';
		preg_match_all($regex, $string, $matches);
		return ($matches[0]);
	}
	function readnotifications()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data['key']=$this->key;
			$data['iv']=$this->iv;

			/*-----------------------Pagination---------------------*/
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Cust_home/readnotifications";
			$total_row = $this->Igain_model->Read_Notification_Count($data['enroll'],$data['Company_id']);
			// var_dump($total_row);
			// die;
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

			$data["ReadNotifications"] = $this->Igain_model->Fetch_Read_Notifications_Details($config["per_page"],$page,$data['enroll'],$data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["ReadNotificationsCount"] = $this->Igain_model->Fetch_Read_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["AllNotificationsCount"] = $this->Igain_model->Fetch_All_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$this->load->view('mailbox/read_notiication',$data);
		}
		else
		{
			redirect('login', 'refresh');
		}

	}
	function allnotifications()
	{


		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];


			$data['key']=$this->key;
			$data['iv']=$this->iv;

			/*-----------------------Pagination---------------------*/
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Cust_home/allnotifications";
			$total_row = $this->Igain_model->Read_Unread_Notification_Count($data['enroll'],$data['Company_id']);
			// var_dump($total_row);
			// die;
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

			$data["AllNotifications"] = $this->Igain_model->Fetch_All_Read_NotificationDetails($config["per_page"],$page,$data['enroll'],$session_data['Company_id']);
			$data["pagination"] = $this->pagination->create_links();

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["ReadNotificationsCount"] = $this->Igain_model->Fetch_Read_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["AllNotificationsCount"] = $this->Igain_model->Fetch_All_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);


			$this->load->view('mailbox/all_notification',$data);
		}
		else
		{

			redirect('login', 'refresh');
		}

	}
	function delete_notification()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["ReadNotificationsCount"] = $this->Igain_model->Fetch_Read_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["AllNotificationsCount"] = $this->Igain_model->Fetch_All_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			// $data["AllNotifications"] = $this->Igain_model->Fetch_All_Read_NotificationDetails($data['enroll'],$session_data['Company_id']);

			if($_POST)
			{
				// $NoteId1 =  $_POST['Note_Id'];
				$NoteId1 =  $_POST['NoteID'];
				// echo"---ntr--NoteId1----".$NoteId1."<br>";
				// var_dump($_POST);

				// $NoteId = $this->input->post('NoteID');
				// $arr = $this->post('arr');
				// $result = $this->Igain_model->delete_notification($NoteId1);
				foreach($NoteId1 as $ntr)
				{

					$ntr=ltrim(rtrim($ntr));
					$ntr = $this->string_decrypt($ntr,$this->key, $this->iv);	
					$ntr = preg_replace("/[^(\x20-\x7f)]*/s", "",$ntr);
					
				/**********************Nilesh Igain Log Table change 28-06-2017 *************************/
					$NotificationsDetails_delete = $this->Igain_model->Fetch_Notification_Delete($ntr,$session_data['Company_id']);
					$notification_id = $NotificationsDetails_delete->Id;
					$notification_Offer = $NotificationsDetails_delete->Offer;
					$Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
					$opration = 3;
					$userid = $session_data['userId'];
					$what="Delete Notification";
					$where="Notification";
					$opval = $notification_Offer;
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details->First_name;
					$lastName = $Enroll_details->Last_name;
					$Enrollment_id = $Enroll_details->Enrollement_id;
					$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$session_data['enroll'],$session_data['username'],$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table change 28-06-2017 *************************/
					$result = $this->Igain_model->delete_notification($ntr);
				}
				if($result == true)
				{
					// $this->session->set_flashdata("error_code","Notification Deleted Successfuly!!");
					// $delete_flag=1
				}
				else
				{
					// $this->session->set_flashdata("error_code","Error Deleting Notification !!");
				}
				redirect(current_url());
				// die;
			}
			else
			{
				// $this->load->view('mailbox/mailbox',$data);
			}
		}
		else
		{

			redirect('login', 'refresh');
		}

	}
	function mystatement()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['Country_id'] = $session_data['Country_id'];
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			$currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
			$data["Symbol_currency"] = $currency_details->Symbol_of_currency;

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["AllNotificationsCount"] = $this->Igain_model->Fetch_All_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($session_data['Company_id']);
			$data["TransactionTypes"] = $this->Igain_model->Fetch_TransactionTypes_details();

			if(isset($_REQUEST["page_limit"]))
			{
				$limit=10;
				$start=$_REQUEST["page_limit"]-10;
				if($_REQUEST["page_limit"]==0)//All
				{
					$limit="";
					$start="";
				}
			}
			else
			{
				$start=0;
				$limit=10;
			}
			if($_REQUEST != NULL)
			{
				$data["Transaction_Reports"] = $this->Igain_model->Fetch_Transaction_Detail_Reports($session_data['Company_id'],$_REQUEST['startDate'],$_REQUEST['endDate'],$_REQUEST['Merchant'],$_REQUEST['Trans_Type'],$_REQUEST['Report_type'],$_REQUEST['Enrollment_id'],$_REQUEST['membership_id'],$_REQUEST['Redeemption_report'],$start,$limit);
				$data["Count_Records"] = $this->Igain_model->Fetch_Transaction_Detail_Reports($session_data['Company_id'],$_REQUEST['startDate'],$_REQUEST['endDate'],$_REQUEST['Merchant'],$_REQUEST['Trans_Type'],$_REQUEST['Report_type'],$_REQUEST['Enrollment_id'],$_REQUEST['membership_id'],$_REQUEST['Redeemption_report'],'','');
			}
			$this->load->view('home/my_statement',$data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function selectgametoplay()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			// $data["MerchandiseProduct"] = $this->Igain_model->FetchMerchandiseProduct($session_data['Company_id']);



			$data["GameMasterDetails"] = $this->Igain_model->Fetch_Game_Master_Details();


			$this->load->view('home/select_game_play', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function merchandisecatalog()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);

			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			/*-----------------------Pagination---------------------*/
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Cust_home/merchandisecatalog";
			$total_row = $this->Igain_model->merchant_item_count();
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

			$data["results"] = $this->Igain_model->merchant_item_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			// $data["MerchandiseProduct"] = $this->Igain_model->FetchMerchandiseProduct($session_data['Company_id']);
			$data["MerchandiseProductCategory"] = $this->Igain_model->Fetch_Merchandise_Product_Category($session_data['Company_id']);

			$this->load->view('home/merchandise_catalog', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function getmerchandisemategory()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);

			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			/*-----------------------Pagination---------------------*/
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Cust_home/getmerchandisemategory";
			$total_row = $this->Igain_model->merchant_selected_item_count($_REQUEST['Merchandise_Category']);

			// var_dump($total_row);

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




			$data["results"] = $this->Igain_model->merchant_selected_item_list($_POST['Merchandise_Category'],$config["per_page"], $page);
			/*  var_dump($data["results"]);
			die;  */
			$data["pagination"] = $this->pagination->create_links();

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			// $data["MerchandiseProduct"] = $this->Igain_model->FetchMerchandiseProduct($session_data['Company_id']);
			$data["MerchandiseProductCategory"] = $this->Igain_model->Fetch_Merchandise_Product_Category($session_data['Company_id']);

			$this->load->view('home/selected_merchandisecatalog ', $data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function insertauctionbidding()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');

			/* $data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$data["MerchandiseProduct"] = $this->Igain_model->FetchMerchandiseProduct($session_data['Company_id']);
			$today=date('Y-m-d');
			$Auction_array = $this->Igain_model->FetchCompanyAuction($data['Company_id'],$today);
			$data['CompanyAuction'] = $Auction_array;


			foreach($Auction_array as $Auction)
			{

					$Total_Auction_Bidder[ $Auction['Auction_id'] ] = $this->Igain_model->Auction_Total_Bidder($Auction['Auction_id'],$data['Company_id']);
					$data["Total_Auction_Bidder"] = $Total_Auction_Bidder;
					$Top5_Auction_Bidder[ $Auction['Auction_id'] ] = $this->Igain_model->Auction_Top_Bidder($Auction['Auction_id'],$data['Company_id']);
					$data["Top5_Auction_Bidder"] = $Top5_Auction_Bidder;

					$Auction_Max_Bid_val[ $Auction['Auction_id'] ] = $this->Igain_model->Auction_Max_Bid_Value($Auction['Auction_id'],$data['Company_id']);
					$data["Auction_Max_Bid_val"] = $Auction_Max_Bid_val;
			} */


			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Super_Seller= $this->Igain_model->Fetch_Super_Seller_details($data['Company_id']);
			$Super_Seller_enroll=$Super_Seller->Enrollement_id;

			if($_POST == NULL)
			{
				$this->load->view('home/auction_bidding', $data);
			}
			else
			{


				$Auction_Bid_Value_Validate['Bid_value'] = $this->Igain_model->Fetch_Auction_Max_Bid_Value($_POST['auctionID'],$_POST['compid']);

				foreach($Auction_Bid_Value_Validate['Bid_value']  as $bid_val)
				{
					$Max_bid_val=$bid_val['MAX(Bid_value)'];
					$Min_increment=$bid_val['Min_increment'];
				}
				$auction_val=$Max_bid_val+$Min_increment;

				if($_POST['bidval'] >= round($auction_val))
				{
					$result = $this->Igain_model->insert_auction_bidding($Super_Seller_enroll);
					if($result == true)
					{
						$result  = array();
						$result['res']='1';
					/*********************Nilesh igain Log Table change 27-06-207*************************/
						$Member_Enrollment_id = $this->input->post('custEnrollId');
						$Enroll_details = $this->Igain_model->get_enrollment_details($Member_Enrollment_id);
						$opration = 1;
						$userid = $session_data['userId'];
						$what="Auction Bidding";
						$where="Auction Bidding";
						$opval = $this->input->post('bidval').' Points';
						$Todays_date=date("Y-m-d");
						$firstName = $Enroll_details->First_name;
						$lastName = $Enroll_details->Last_name;
						$Enrollment_id = $Enroll_details->Enrollement_id;
						$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$session_data['enroll'],$session_data['username'],$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 27-06-2017 *************************/

					}
					else
					{
						  $result  = array();
						  $result['res']='0';

					}
				}
				else
				{
					$result  = array();
				    $result['res']='0';
				}
				echo json_encode($result);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function check_promo_code()
	{
		$result = $this->Igain_model->check_promocode($this->input->post("promo_code"),$this->input->post("Company_id"));
		if($result == "")
		{
			$result  = array();
			$result['res']='1';
			$this->output->set_output(0);


		}
		else
		{
			$result  = array();
			$result['res']='0';
			$this->output->set_output("Valid Promo Code");
		}

	}
	public function check_email_id()
	{
		$result = $this->Igain_model->Check_EmailID($this->input->post("userEmailId"),$this->input->post("Company_id"));
		$this->output->set_output($result);
		/* if($result == '1')
		{
			$result  = array();
			$result['email']='1';
			$this->output->set_output(0);
			// $this->output->set_output("0");


		}
		else
		{
			$result  = array();
			$result['email']='0';
			$this->output->set_output(1);
			// $this->output->set_output("1 ");
		} */

	}
	public function check_phone_number()
	{
		$Country=$this->input->post("Country");
		$phno=$this->input->post("phno");
		$Company_id=$this->input->post("Company_id");
		$Dial_Code = $this->Igain_model->get_dial_code($Country);
		$dialcode=$Dial_Code->phonecode;
		$phoneNo=$dialcode.''.$phno;
		$result = $this->Igain_model->CheckPhone_number($phoneNo,$Company_id);
		$this->output->set_output($result);
		/* if($result > '0')
		{
			$result  = array();
			$result['phno']='1';
			$this->output->set_output(0);


		}
		else
		{
			$result  = array();
			$result['phno']='0';
			$this->output->set_output(1);
		} */

	}
	public function checkoldpassword()
	{
		// $result = $this->Igain_model->Check_Old_Password($this->input->post("old_Password"),$this->input->post("Company_id"),$this->input->post("Enrollment_id"));
		$old_Password = App_string_encrypt($this->input->post("old_Password"));
		$result = $this->Igain_model->Check_Old_Password($old_Password,$this->input->post("Company_id"),$this->input->post("Enrollment_id"));
		if($result == "")
		{
			$result  = array();
			$result['res']='1';
			$this->output->set_output(0);
		}
		else
		{
			$result  = array();
			$result['res']='0';
			$this->output->set_output(1);
		}
	}
	public function checkoldpin()
	{
		$result = $this->Igain_model->Check_Old_Pin($this->input->post("old_pin"),$this->input->post("Company_id"),$this->input->post("Enrollment_id"));
		if($result == "")
		{
			$result  = array();
			$result['res']='1';
			$this->session->set_flashdata("error_code","Password Not Changed");

			$this->output->set_output(0);
		}
		else
		{
			$result  = array();
			$result['res']='0';
			$this->session->set_flashdata("error_code","Password Not Changed");

			$this->output->set_output(1);
		}
	}
	public function changepassword()
	{
		$old_Password=$this->input->post('old_Password');
		$Company_id=$this->input->post('Company_id');
		$Enrollment_id=$this->input->post('Enrollment_id');
		$new_Password=$this->input->post('new_Password');
		if($old_Password==$new_Password)
		{
			$this->session->set_flashdata("error_code","Old Password is same with New Password..!!");
			redirect('Cust_home/profile', 'refresh');
		}
		 
		$new_Password=App_string_encrypt($this->input->post('new_Password')); 
		
		$result = $this->Igain_model->Change_Old_Password($old_Password,$Company_id,$Enrollment_id,$new_Password);
		if($result)
		{
			$SuperSeller=$this->Igain_model->get_super_seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			
			 /* $Email_content = array(
				'New_password' => $new_Password,
				'Notification_type' => 'Password Changed',
				'Template_type' => 'Change_password'
			);
			$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);
			*/ 
			$result1  = array();
			$result1['pwd']='1';

			/*********************Nilesh igain Log Table change 27-06-207*************************/
				$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$opration = 2;
				$userid = $Enroll_details->User_id;
				$what="Change Password";
				$where="My Profile";
				$opval = preg_replace("/[\S]/", "X", $new_Password);
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details->First_name;
				$lastName = $Enroll_details->Last_name;
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/**********************igain Log Table change 27-06-2017 *************************/
			$this->session->set_flashdata("error_code","Password has Changed Successfully");
			$this->output->set_output(1);
		}
		else
		{
			$result1  = array();
			$result1['pwd']='0';
			$this->session->set_flashdata("error_code","Password Not Changed");
			$this->output->set_output(0);
		}

	}
	public function changepin()
	{
		$old_Password=$this->input->post('old_pin');
		$Company_id=$this->input->post('Company_id');
		$Enrollment_id=$this->input->post('Enrollment_id');
		$newpin=$this->input->post('new_pin');

		$result_pin = $this->Igain_model->Change_Old_Pin($Company_id,$Enrollment_id,$newpin);
		if($result_pin == true)
		{
			$SuperSeller=$this->Igain_model->get_super_seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			$Email_content = array(
				'Pin_No' => $newpin,
				'Notification_type' => 'Pin Change',
				'Template_type' => 'Change_pin'
			);
			$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);

			/*********************Nilesh igain Log Table change 27-06-207*************************/
				$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$opration = 2;
				$userid = $Enroll_details->User_id;
				$what="Change Pin";
				$where="My Profile";
				$opval = preg_replace("/[\S]/", "X", $newpin);
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details->First_name;
				$lastName = $Enroll_details->Last_name;
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/**********************igain Log Table change 27-06-2017 *************************/
			$result_pin  = array();
			$result_pin['pwd']='1';
			$this->session->set_flashdata("error_code","Pin Changed Successfuly");

			$this->output->set_output(1);
		}
		else
		{
			$result_pin  = array();
			$result_pin['pwd']='0';
			$this->session->set_flashdata("error_code","Pin Not Changed");

			$this->output->set_output(0);
		}

	}
	public function send_pin()
	{
		$Company_id=$this->input->post('Company_id');
		$Enrollment_id=$this->input->post('Enrollment_id');
		$get_pin = $this->Igain_model->get_customer_pin($Company_id,$Enrollment_id);
		if($get_pin->pinno != "" || $get_pin->pinno != 0 )
		{
			$SuperSeller=$this->Igain_model->get_super_seller_details($Company_id);
			$Seller_id=$SuperSeller->Enrollement_id;
			$Email_content = array(
				'Pin_No' => $get_pin->pinno,
				'Notification_type' => 'Pin Send',
				'Template_type' => 'Send_pin'
				);

			$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);
			/*********************Nilesh igain Log Table change 27-06-207*************************/
				$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$opration = 1;
				$userid = $Enroll_details->User_id;
				$what="Pin Send ";
				$where="My Profile";
				$opval = "Re send  Pin";
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details->First_name;
				$lastName = $Enroll_details->Last_name;
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
			/**********************igain Log Table change 27-06-2017 *************************/
			$this->session->set_flashdata("error_code","Your Pin sent on your email ID Successfully");
			$this->output->set_output(1);
		}
		else
		{
				$this->session->set_flashdata("error_code","Send Pin  on your Email is Un-successful...Please Contact Administrator");
			$this->output->set_output(0);
		}

	}

	 public function send_Notification_email($enroll,$mail_to,$offerdetails,$compid)
	{
		$company_details = $this->Igain_model->get_company_details($compid);
		// $seller_details = $this->Igain_model->get_enrollment_details($sellerid);
		$customer_details = $this->Igain_model->get_enrollment_details($enroll);

		$subject = "Your Promo Code Points updated Successfully  ";
		$html  = '<!DOCTYPE HTML PUBLIC ""-//IETF//DTD HTML//EN"">' ;
		$html .= "<html style=\"background-color:#99CCFF\"  bordercolor='#CCCCCC'>" ;
		$html .= "<head>" ;
		$html .= "<meta http-equiv=\"Content-Type\"" ;
		$html .= "content=\"text/html; charset=iso-8859-1\">" ;
		$html .= "</head>";
		$html .= "<body  style=\"background-color:#99CCFF\"  border='0px' bordercolor='#CCFFFF' cellpadding='0' cellspacing='0'>";
		$html = "";
		$html .= "<p>Dear  ".$customer_details->First_name." ".$customer_details->Last_name.",";
		$html .= "<br>";
		$html .= "<br>";
		// $html .="We are pleased to share our offer of - <b>'".$sellerplan."'</b>";
		$html .="<br>";
		$html .="<br>";
		// $html .="<b>Offer Details : </b>".$offerdetails." <br> So rush to our outlet and get your GIFT !";
		$html .="<b>Offer Details : </b><br> So rush to our outlet and get your GIFT !";
		$html .="<br>";
		$html .="<br>";
		// $html .="Please visit us at : ".$seller_details->Current_address.".<br>";
		$html .="<br>";
		$html .="Looking forward to meeting you!";
		$html .="<br>";
		$html .="<br>";
		$html .="Regards,";
		$html .="<br>";
		// $html .= "".$seller_details->First_name." ".$seller_details->Last_name."</p>";
		$html .="<br>";
		$html .="<br>";

		$html .= "<p>You can also download  Android App: <a href='http://".$company_details->Cust_apk_link."' target='_blank'><font color='blue'><img src=\"../images/google_play.png\" id=\"note-img1\"  alt=\"APK\" /></font></a>,  iOS: <a href='http://".$company_details->Cust_ios_link."' target='_blank'><font color='blue'><img src=\"../images/ios_store.png\" id=\"note-img1\"  alt=\"iOS\" /></font></a></p>";
		$html .= "</br>";
		$html .= "</body>";
		$html .= "</html>";

		// return $html;

		/**************************Email Fuction Code****************************
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = 'C:\xampp\sendmail\sendmail.exe';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			// $this->email->initialize($config);

			$this->load->library('email', $config);
			$this->email->from($customer_details->User_email_id);
			$this->email->to($mail_to);
			$this->email->subject($subject);
			$this->email->message($message);
			if ( ! $this->email->send())
			{
				$message = "-1";
			}
			else
			{
				$message = "1";
			}
			// echo $message;
			echo $this->email->print_debugger();
		/**************************Email Fuction Code*****************************/
	}

	public function export_customer_report()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$Company_id = $session_data['Company_id'];
			$Company_name = $session_data['Company_name'];
			$data['Country_id'] = $session_data['Country_id'];
			$Report_type =  $_GET['report_type'];
			$pdf_excel_flag =  $_GET['pdf_excel_flag'];
			$start_date =  $_GET['start_date'];
			$end_date =  $_GET['end_date'];
			$Merchant =  $_GET['Merchant'];
			$Trans_Type =  $_GET['Trans_Type'];
			$Enrollment_id =  $_GET['Enrollment_id'];
			$membership_id =  $_GET['membership_id'];
			$Redeemption_report =  $_GET['Redeemption_report'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);

			
			$currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
			$data["Symbol_currency"] = $currency_details->Symbol_of_currency;
			
			$Today_date = date("Y-m-d");

			if($Report_type == '1')
			{
				$temp_table = $data['enroll'].'customer_summary_rpt';
			}
			else
			{
				$temp_table = $data['enroll'].'customer_detail_rpt';
			}
			$data["Transaction_Reports"] = $this->Igain_model->Fetch_Transaction_Detail_Reports($Company_id,$start_date,$end_date,$Merchant,$Trans_Type,$Report_type,$Enrollment_id,$membership_id,$Redeemption_report,'','');


			$Export_file_name = $Today_date."_".$temp_table;
			$data["Report_date"] = $Today_date;
			$data["Report_type"] = $Report_type;
			$data["From_date"] = $start_date;
			$data["end_date"] = $end_date;
			$data["Company_name"] = $Company_name;
			$data["Redeemption_report"] = $Redeemption_report;
			$data["Company_id"] = $Company_id;
			if($pdf_excel_flag == '1')
			{
				$this->excel->getActiveSheet()->setTitle('Customer Report');
				// $this->excel->stream($Export_file_name.'.xls', $data["Transaction_Reports"]);
				$fields=array();

				//Fetching the column names from return array data
				foreach($data["Transaction_Reports"][0] as $key => $field)
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
				foreach($data["Transaction_Reports"] as $data1)
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
				$html = $this->load->view('Customer_reports/pdf_customer_website_report', $data, true);
				$this->m_pdf->pdf->WriteHTML($html);
				$this->m_pdf->pdf->Output($Export_file_name.".pdf", "D");
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function new_notification_polling()
	{
		$gv_log_compid=$_REQUEST["Company_id"];
		$Cust_email=$_REQUEST["User_email_id"];
		// $Cust_lat=$_REQUEST["latitude"];// Customer lattitude
		// $Cust_long=$_REQUEST["longitude"];// Customer longitude
		$Cust_lat='18.5158311';
		$Cust_long='73.8776374';
		$entry_date=date("Y-m-d");

		//http://localhost/CI_IGAINSPARK_DEMO/Company_3/index.php/Cust_home/new_notification_polling?Company_id=3&User_email_id=ravip@miraclecartes.com&latitude=18.5158311&longitude=73.8776374

		// http://demo1.igainspark.com/Company_3/index.php/Cust_home/new_notification_polling?Company_id=3&User_email_id=ravip@miraclecartes.com&latitude=18.5158311&longitude=73.8776374

		$EnrollementDetails = $this->Igain_model->get_enrollment_details_polling($Cust_email,$gv_log_compid);
		$Company_details = $this->Igain_model->get_company_details($gv_log_compid);
		$Company_seller = $this->Igain_model->FetchSellerdetails($gv_log_compid);
		$Cust_enrollement_id=$EnrollementDetails->Enrollement_id;
		$Cust_Phone_no=$EnrollementDetails->Phone_no;
		$Company_Distance=$Company_details->Distance;
		$Sms_enabled=$Company_details->Sms_enabled;
		$Available_sms	=$Company_details->Available_sms;
		$Sms_api_link	=$Company_details->Sms_api_link;
		$Sms_api_auth_key	=$Company_details->Sms_api_auth_key;

		/* $Auth_Key	=$Company_details->Auth_Key;
		$SenderId	=$Company_details->SenderId;
		$API_URL	=$Company_details->API_URL; */
		//$EnrollementDetails = $this->Igain_model->Insert_latitude_longitude($Cust_enrollement_id,$Cust_lat,$Cust_long);
		/* echo"---Cust_enrollement_id---".$Cust_enrollement_id."<br>";
		echo"---Company_Distance---".$Company_Distance."<br>"; */
		// print_r($Company_details);
		/* echo"---Cust_enrollement_id---".$Cust_enrollement_id."<br>";
		echo"---Cust_Phone_no---".$Cust_Phone_no."<br>";
		echo"---Sms_enabled---".$Sms_enabled."<br>";
		echo"---Available_sms---".$Available_sms."<br>"; */

		foreach($Company_seller as $seller)
		{
			$Seller_latitude=$seller["Latitude"];// Seller lattitude
			$Seller_longitude=$seller["Longitude"];// Seller longitude
			$Seller_Enrollement_id=$seller["Enrollement_id"];
			$Seller_First_name=$seller["First_name"];
			$Seller_Last_name=$seller["Last_name"];
			$Seller_Current_address=$seller["Current_address"];
			$seller_full_name=$Seller_First_name.' '.$Seller_Last_name;
			$theta = ($Seller_longitude - $Cust_long);

			/* echo"---<br><br><br>";
			echo"---Seller Full Name---".$Seller_First_name.' '.$Seller_Last_name."<br>";
			echo"---Seller_Enrollement_id---".$Seller_Enrollement_id."<br>";
			echo"---Seller_latitude---".$Seller_latitude."<br>";
			echo"---Seller_longitude---".$Seller_longitude."<br>";
			echo"---Cust_lat---".$Cust_lat."<br>";
			echo"---Cust_long---".$Cust_long."<br>"; */
			// echo"---Company_Distance---".$Company_Distance."<br>";
			// echo"---theta---".$theta."<br>";

			$dist = sin(deg2rad($Seller_latitude)) * sin(deg2rad($Cust_lat)) +  cos(deg2rad($Seller_latitude)) * cos(deg2rad($Cust_lat)) * cos(deg2rad($theta));
			// echo"---dist---".$dist."<br>";
			// echo"---Distance_diff ------------ Company_Distance---".$Distance_diff."---------------".$Company_Distance."<br>";
			// echo"---Distance_diff12-----".$Distance_diff12."<br>";

			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			$Distance_diff=round(($miles * 1.609344),2);
			// echo"---Distance_diff---".$Distance_diff."<br>";
			// echo"---Distance_diff ------------ Company_Distance---".$Distance_diff."---------------".$Company_Distance."<br>";
			if($Distance_diff <= $Company_Distance)
			{
				// echo"---SMS_Notification-----".$SMS_Notification."<br>";
				// echo"---Distance_diff ------------ Company_Distance--->".$Distance_diff."--------------->".$Company_Distance."<br>";

				/******************Send SMS***with (msg91.com) ***************************/
				$SMS_Comm_Details = $this->Igain_model->Fetch_Merchant_SMS_Communication_Details($Seller_Enrollement_id);
				foreach($SMS_Comm_Details as $SMSdtls)
				{

					$SMS_Notification = $this->Igain_model->Check_SMS_Notification($gv_log_compid,$Cust_enrollement_id,$Seller_Enrollement_id,$entry_date,$SMSdtls['id']);
					// echo"---SMS_Notification-----".$SMS_Notification."<br>";
					if($SMS_Notification == 0)
					{
						if($SMSdtls["description"] != "")
						{
							// echo"---Send SMS----<br>";
							/* echo"---description-----".$SMSdtls["description"]."<br>";
							echo"---communication_plan-----".$SMSdtls["communication_plan"]."<br>";
							echo"---Sms_enabled-----".$Sms_enabled."<br>";
							echo"---Available_sms-----".$Available_sms."<br>"; */

							$SMS_description=$seller_full_name.': '.strip_tags($SMSdtls["description"]);

							// $message = strip_tags($SMSdtls["description"]);
							$message = preg_replace("/&nbsp;/",'',$SMS_description);

							if($Sms_enabled == 1 && $Available_sms > 0 )
							{
								//Your authentication key
								// $authKey ="151097AnRTbhf7S9b590986e3";
								// $authKey ="151344AohxxOrX27w590c3dc1";
								$authKey =$Sms_api_auth_key;

								//Multiple mobiles numbers separated by comma
								//$mobileNumber = "919561970954";
								$mobileNumber = $Cust_Phone_no;

								//Sender ID,While using route4 sender id should be 6 characters long.
								//$senderId = "102234";
								// $senderId = "MSCPLD";
								$senderId = $SMSdtls["communication_plan"];
								//Your message to send, Add URL encoding here.
								// $message = urlencode($SMS_description);
								//Define route
								$route = "4";

								//Prepare you post parameters
								$postData = array(
									'authkey' => $authKey,
									'mobiles' => $mobileNumber,
									'message' => $message,
									'sender' => $senderId,
									'route' => $route
								);

								//API URL
								// $url="https://control.msg91.com/api/sendhttp.php";
								$url=$Sms_api_link;

								// init the resource
								$ch = curl_init();
								curl_setopt_array($ch, array(
									CURLOPT_URL => $url,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_POST => true,
									CURLOPT_POSTFIELDS => $postData
									//,CURLOPT_FOLLOWLOCATION => true
								));
								//Ignore SSL certificate verification
								curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
								//get response
								$output = curl_exec($ch);
								//Print error if any
								if(curl_errno($ch))
								{
									echo 'error:' . curl_error($ch);
								}
								curl_close($ch);
								// echo $output;
								if($output !="")
								{
									$message_counter=strlen($message);
									// $Count_sms=floor($message_counter/160)+1;
									if($message_counter <= 160)
									{
										$Count_sms=1;
									}
									else
									{
										// $Count_sms=round($message_counter/153);
										$Count_sms=floor($message_counter/153)+1;
										$Count_sms=$Count_sms;
									}
									$Company_details12 = $this->Igain_model->get_company_details($gv_log_compid);
									$Available_sms12	=$Company_details12->Available_sms;
									$NEW_SMS_COUNT=	$Available_sms12-$Count_sms;
									$post_data = array(
									'Available_sms' => $NEW_SMS_COUNT
									);
									$Update_SMS_balance = $this->Igain_model->Update_company_SMS_Balance($gv_log_compid,$post_data);
									$Insert_data = array(
									'Company_id' => $gv_log_compid,
									'Seller_id' => $Seller_Enrollement_id,
									'Customer_id' => $Cust_enrollement_id,
									'Phone_no' => $Cust_Phone_no,
									'Communication_id' => $SMSdtls["id"],
									'SMS_name' =>$SMSdtls["communication_plan"],
									'SMS_contents' => $SMSdtls["description"],
									'Sent_Date' => date('Y-m-d H:i:s')
									);
									$Insert_SMS_Details = $this->Igain_model->Insert_company_SMS_Notification($Insert_data);
								}
							}
						}
					}
				}
				/******************Send SMS******************************/

				$CommunicationDetails = $this->Igain_model->FetchMerchantCommunicationDetails($Seller_Enrollement_id);
				// print_r($CommunicationDetails);
				foreach($CommunicationDetails as $commdtls)
				{
					// echo"---commdtls---".$commdtls['id']."<br>";
					$Customer_Notification = $this->Igain_model->Customer_Notification_polling($gv_log_compid,$Cust_enrollement_id,$entry_date,$commdtls['id']);
					// echo"---Customer_Notification---".$Customer_Notification."<br>";
					if($Customer_Notification == 0)
					{
						// echo"---Send Communications---<br>";
						$Email_content = array(
								'Communication_id' => $commdtls["id"],
								'Offer' => $commdtls["communication_plan"],
								'Offer_description' =>$commdtls["description"],
								'Template_type' => 'Polling_ommunication'
							);
						$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_Enrollement_id,$gv_log_compid);
					}
				}
			}
		}
		$Customer_Notification = $this->Igain_model->Notification_polling($gv_log_compid,$Cust_enrollement_id);
		echo $Customer_Notification;
	}
	function survey()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			$data["Survey_details"] = $this->Igain_model->Fetch_survey_details($data['Company_id']);
			$survey=$data["Survey_details"];
			// var_dump($data["Survey_details"]);
			if($_POST == NULL)
			{
				// $this->load->view('home/promocode', $data);
			}
			else
			{

				 foreach($survey as $srr)
				 {
					$response=$this->input->post($srr['Question_id']);
					// $Response_type=$this->input->post($srr['Response_type']);
					$Question_id=$srr['Question_id'];
					$Response_type=$srr['Response_type'];
					$Company_id =  $this->input->post('Company_id');
					$Enrollment_id =  $this->input->post('Enrollment_id');

					$data["survey_dulpicate"]  = $this->Igain_model->Check_survey_dulplicate($Enrollment_id,$Company_id,$Question_id);
					$survey_dulpicate=$data["survey_dulpicate"];
					// var_dump($survey_dulpicate);
					$survey_dul=count($survey_dulpicate);
					if($survey_dulpicate == '0')
					{
						$result = $this->Igain_model->Insert_servey_response($Company_id,$Enrollment_id,$Question_id,$Response_type,$response);
					}
					else
					{
						// echo"---Question_id--upda---". $Question_id."<br>";
						$survey_response_id = $this->Igain_model->Fetch_response_id($Enrollment_id,$Company_id,$Question_id);
						// var_dump($survey_response_id);
						$Responce_id1=$survey_response_id->Response_id;
						if($Responce_id1 != "")
						{
							$result = $this->Igain_model->Update_servey_response($Company_id,$Enrollment_id,$Question_id,$Response_type,$response,$Responce_id1);
						}
						 $this->session->set_flashdata("survey","Survey has been Recorded Successfully!!");
					}

				 }


			}
			$this->load->view('home/survey', $data);
			// redirect(current_url());

		}
		else
		{
			redirect('login', 'refresh');
		}

	}
	/****************************Nilesh Change**************************/
	function contactus()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			$data["query_type"] = $this->Igain_model->get_query_type($data['Company_id']);
			/*********amit 22-09-2017----------------*/
			$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($data["Company_details"] as $cmpdtls)
			{
				$data["Company_contactus_email_id"]=$cmpdtls['Company_contactus_email_id'];
				$data["Call_center_flag"]=$cmpdtls['Call_center_flag'];

			}
			/*******************/
			if($_POST == NULL)
			{
				/**************live chat*************/
				$data['listOfUsers'] = $this->Users_model->getUsers($data['Company_id']);

				/**************live chat*************/
				// $this->load->view('home/livechat', $data);
				 $this->load->view('home/contact_us', $data);
			}
			else
			{
				$Company_id =  $this->input->post('Company_id');
				$Customer_enrollId =  $this->input->post('Enrollment_id');
				$membership_id =  $this->input->post('membership_id');
				$contact_subject =  $this->input->post('contact_subject');
				$contactus_SMS =  $this->input->post('offerdetails');

				if($contact_subject != 4)
				{
					if($contact_subject != "" && $contactus_SMS != "")
					{
						$contactus_message = $this->Igain_model->Insert_contactus_message($Company_id,$Customer_enrollId,$membership_id,$contact_subject,$contactus_SMS);


						$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
						$User_email_id=$Super_Seller->User_email_id;
						$Seller_enroll_id=$Super_Seller->Enrollement_id;
						if($contactus_message > 0)
						{
							$Email_content = array(
									'Communication_id' => '0',
									'Notification_type' => $contact_subject,
									'Notification_description' =>$contactus_SMS,
									'Template_type' => 'Contactus'
								);
							$this->send_notification->send_Notification_email($Customer_enrollId,$Email_content,$Seller_enroll_id,$Company_id);

							$Email_content12 = array(
									'Communication_id' => '0',
									'Notification_type' => $contact_subject,
									'Notification_description' =>$contactus_SMS,
									'Template_type' => 'Contactus_feedback'
								   );
							$this->send_notification->send_Notification_email($Customer_enrollId,$Email_content12,$Seller_enroll_id,$Company_id);


						/*********************Nilesh igain Log Table change 28-06-207*************************/
							if($contact_subject == 1)
							{
								$subject_line = 'Feedback';
							}
							if($contact_subject == 2)
							{
								$subject_line = 'Request';
							}
							if($contact_subject == 3)
							{
								$subject_line = 'Suggestion';
							}
							$Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enrollId);
							$opration = 1;
							$userid = $session_data['userId'];
							$what="Send Contactus Message";
							$where="Contact Us";
							$opval = $subject_line;
							$Todays_date=date("Y-m-d");
							$firstName = $Enroll_details->First_name;
							$lastName = $Enroll_details->Last_name;
							$Enrollment_id = $Enroll_details->Enrollement_id;
							$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
							$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$session_data['enroll'],$session_data['username'],$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
						/**********************igain Log Table change 28-06-2017 *************************/




							$this->session->set_flashdata("Contactus","Message has been Submitted Successfully");
							$this->load->view('home/contact_us', $data);
						}
					}
					else
					{
						$this->session->set_flashdata("Contactus","Subject and Message Details should not be empty");
						$this->load->view('home/contact_us', $data);
					}
				}
				else if($contact_subject == 4 && $contact_subject != "" && $contactus_SMS != "")
				{
					$Query_Type =  $this->input->post('Query_Type');
					$Sub_query_type =  $this->input->post('Sub_query_type');
					$contactus_SMS =  strip_tags($this->input->post('offerdetails'));
					$Qstatus='Forward';
					$Closerremark = '';
					$User_detail = $this->Igain_model->Get_ccquery_user($Query_Type,$Company_id);
					$cc_user_id=$User_detail->Enrollment_id;
					$Company_details= $this->Igain_model->get_company_details($data['Company_id']);
					$Querylog_ticket=$Company_details->Callcenter_query_ticketno_series;
					$today=date('Y-m-d H:i:s');
					$nextday = strftime("%Y-%m-%d", strtotime("$today +1 day"));
					$Post_data=array
						   (
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$membership_id,
							'Querylog_ticket'=>$Querylog_ticket,
							'Call_type'=>'Inbound',
							'Communication_type'=>'Email',
							'Query_type_id'=>$Query_Type,
							'Sub_query_type_id'=>$Sub_query_type,
							'Query_details'=>$contactus_SMS,
							'Next_action_date'=>$today,
							'Closure_date'=>$nextday,
							'Resolution_priority_levels'=>1,
							'Query_assign'=>$cc_user_id,
							'Enrollment_id'=>$cc_user_id,
							'Query_status'=>$Qstatus,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
					$result = $this->Igain_model->Insert_callcenter_querylog_master($Post_data);

					$User_detail = $this->Igain_model->Get_ccquery_userchild($Query_Type,$Company_id);
					foreach($User_detail as $user)
					{
					  $cc_user_id=$user['Enrollment_id'];

					  $Post_data1=array
						   (
							'Query_log_id'=>$result,
							'Company_id'=>$data['Company_id'],
							'Membership_id'=>$membership_id,
							'Querylog_ticket'=>$Querylog_ticket,
							'Query_details'=>$contactus_SMS,
							'Query_interaction'=>$Closerremark,
							'Enrollment_id'=>$cc_user_id,
							'Call_type'=>'Inbound',
							'Communication_type'=>'Email',
							'Next_action_date'=>$today,
							'Closure_date'=>$nextday,
							'Query_status'=>$Qstatus,
							'Query_assign'=>$cc_user_id,
							'Create_User_id'=>$data['enroll'],
							'Creation_date'=>$today
						   );
						$result1 = $this->Igain_model->Insert_callcenter_querylog_child($Post_data1);
					}

					if($result == true && $result1 == true)
					{
						/*******************Insert igain Log Table*********************/
						$Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enrollId);
						$get_query_name = $this->Igain_model->get_query_details($Query_Type,$Company_id);
						$Query_name=$get_query_name->Query_type_name;
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');
						$opration = 1;
						$enroll	= $Customer_enrollId;
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Call Center ticket Raising";
						$where="Contact Us";
						$To_enrollid = $Customer_enrollId;
						$firstName = $Enroll_details->First_name;
						$lastName = $Enroll_details->Last_name;
						$Seller_name = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$opval = $Query_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/

						$Post_data=array
						   (
							'Callcenter_query_ticketno_series'=>$Querylog_ticket+1
						   );

						$result = $this->Igain_model->Update_company_ticketno_series($Post_data,$session_data['Company_id']);

						/***************Send Query Log Notification********************/
						$enroll1=0;
						$Notification_type = "Call center query log";
						$Cust_name=$Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$Enroll_details1 = $this->Igain_model->get_enrollment_details($cc_user_id);
						$Excecative_name=$Enroll_details1->First_name.' '.$Enroll_details1->Last_name;
						$Excecative_email=$Enroll_details1->User_email_id;
						$Email_content = array(
								'Today_date' => $today,
								'Cust_name' => $Cust_name,
								'Excecative_name' => $Excecative_name,
								'Querylog_ticket' => $Querylog_ticket,
								'Max_resolution_datetime' => $nextday,
								'Excecative_email' => $Excecative_email,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Call_Center_Query_Log'
							);
						$this->send_notification->send_Notification_email($Customer_enrollId,$Email_content,$enroll1,$Company_id);
						/***************Send Query Log Notification********************/

						// $this->session->set_flashdata("Contactus","Message has been Submitted Successfully");
						$this->session->set_flashdata("Contactus","Call Center Query <b> Ticket No :- " .$Querylog_ticket.   "  </b> Raise Successfuly!!");
						$this->load->view('home/contact_us', $data);
					}
					else
					{
						// $this->session->set_flashdata("Contactus","Subject and Message Details should not be empty");
						$this->session->set_flashdata("Contactus","Error Call Center Query Ticket Added. Please Provide valid data!!");
						$this->load->view('home/contact_us', $data);
					}

				}
				else
				{
					$this->session->set_flashdata("Contactus","Subject and Message Details should not be empty");
					$this->load->view('home/contact_us', $data);
				}
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	public function Get_Sub_Query()
	{
		$data['Get_subquery_Names'] = $this->Igain_model->Get_sub_query_name($this->input->post("QueryTypeId"),$this->input->post("Company_id"));
		$theHTMLResponse = $this->load->view('home/Get_sub_query', $data, true);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_Sub_query_Names1'=> $theHTMLResponse)));
	}
	/****************************Nilesh Change**************************/
	function transferpoints()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['First_name'] = $session_data['First_name'];
			$data['Last_name'] = $session_data['Last_name'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['timezone_entry']= $session_data['timezone_entry'];

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			$SuperSeller=$this->Igain_model->get_super_seller_details($data['Company_id']);
			$Seller_id=$SuperSeller->Enrollement_id;

			//echo "First_name------------".$data['First_name'].' '.$data['Last_name'];

			$Company_details = $this->Igain_model->get_company_details($data['Company_id']);

			if($_POST != NULL)
			{


				$Company_id =  $this->input->post('Company_id');
				$Login_Enrollement_id =  $this->input->post('Login_Enrollement_id');
				$Login_Current_balance =  $this->input->post('Login_Current_balance');
				$Login_Membership_id =  $this->input->post('Login_Membership_id');
				$Member_Enrollement_id =  $this->input->post('Member_Enrollement_id');
				$Member_Current_balance =  $this->input->post('Member_Current_balance');
				$Member_Membership_id =  $this->input->post('Member_Membership_id');
				$Membership_id =  $this->input->post('Membership_id');
				$Transfer_Points =  $this->input->post('Transfer_Points');


				if($Membership_id == $Enroll_details12->Card_id)
				{
					$this->session->set_flashdata("transfer","Please Enter Valid Membership ID..!!");
					$this->load->view('home/transfer_points', $data);
				}
				else if($Member_Enrollement_id == "" || $Member_Enrollement_id ==0)
				{
					$this->session->set_flashdata("transfer","Please Enter Valid Membership ID..!!");
					$this->load->view('home/transfer_points', $data);
				}
				else
				{
					// echo"timezone_entry------".$session_data['timezone_entry']."--<br>";
					// die;
					$logtimezone = $session_data['timezone_entry'];
				    $timezone = new DateTimeZone($logtimezone);
				    $date = new DateTime();
				    $date->setTimezone($timezone);
				    $lv_date_time=$date->format('Y-m-d H:i:s');
				    $Todays_date = $date->format('Y-m-d');

					$today=date('Y-m-d');

					/* echo"Todays_date------".$Todays_date."--<br>";
					echo"lv_date_time------".$lv_date_time."--<br>";
					echo"today------".$today."--<br>";
					die; */

					$Transfer_PTS = array(
						'Company_id' => $Company_id,
						'Trans_type' => '8',
						'Transfer_points' => $Transfer_Points,
						'Remarks' => 'Transfer '.$Company_details->Currency_name,
						'Trans_date' => $lv_date_time,
						'Enrollement_id' => $Login_Enrollement_id,
						'Card_id' => $Login_Membership_id,
						'Enrollement_id2' => $Member_Enrollement_id,
						'Card_id2' => $Member_Membership_id,
						);
					$New_login_curr_balance=$Login_Current_balance - $Transfer_Points;
					$New_member_curr_balance=$Member_Current_balance + $Transfer_Points;
					 $result = $this->Igain_model->Insert_transfer_transaction($Transfer_PTS);

					 /********************AMIT 16-08-2017**insert transaction of other member**********/
						/**Get Super seller details***/
						$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($data['Company_id']);
						$seller_id=$Super_Seller_details->Enrollement_id;
						$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
						$top_db2 = $Super_Seller_details->Topup_Bill_no;
						$len2 = strlen($top_db2);
						$str2 = substr($top_db2,0,5);
						$tp_bill2 = substr($top_db2,5,$len2);
						$topup_BillNo2 = $tp_bill2 + 1;
						$billno_withyear_ref = $str2.$topup_BillNo2;


						/*****************/

					$post_data = array(
						'Trans_type' => '1',
						'Company_id' => $data['Company_id'],
						'Topup_amount' => $Transfer_Points,
						'Trans_date' => $lv_date_time,
						'Remarks' => 'Get by Transfer '.$Company_details->Currency_name,
						'Card_id' => $Member_Membership_id,
						'Enrollement_id' => $Member_Enrollement_id,
						'Enrollement_id2' => $Login_Enrollement_id,
						'Card_id2' => $Login_Membership_id,
						'Seller' => $seller_id,
						'Seller_name' => $Seller_name,
						'Bill_no' => $tp_bill2
					);
					$result45 = $this->Igain_model->insert_transction($post_data);
					/*****Update Seller Bill no.********/
					$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
					/********************AMIT 16-08-2017**end**********/
					if($result > 0 )
					{
						$result1 = $this->Igain_model->Update_member_balance($Company_id,$Login_Enrollement_id,$New_login_curr_balance);
						$result2 = $this->Igain_model->Update_member_balance($Company_id,$Member_Enrollement_id,$New_member_curr_balance);
						$member_details=$this->Igain_model->get_enrollment_details($Member_Enrollement_id);
						// $member_details=$data["get_member_details"];
						$Blocked_m_points=$member_details->Blocked_points;
						$Member_Total_topup = $member_details->Total_topup_amt;
						// $New_member_curr_balance=$New_member_curr_balance-$Blocked_m_points;


						$Member_New_Total_topup = $Member_Total_topup + $Transfer_Points;

						$result3 = $this->Igain_model->Update_member_TopUpAmt($Company_id,$Member_Enrollement_id, $Member_New_Total_topup);

						$get_member12=$this->Igain_model->get_enrollment_details($Login_Enrollement_id);
						// $get_member12=$data["get_member"];

						 $Blocked_points=$get_member12->Blocked_points;
						 $New_login_curr_balance=$New_login_curr_balance-$Blocked_points;

						/*
							$TransPoints_contents = array(
								'Communication_id' => '0',
								'Notification_type' => ' You have Transferred Points to '.$member_details->First_name.' '.$member_details->Last_name.'',
								'Notification_description' =>'You have Transferred Points to :&nbsp; <b>'.$member_details->First_name.' '.$member_details->Last_name.' </b> Successfully.
								<br><br> No. of Points Transferred  :&nbsp; <b>'.$Transfer_Points.'</b> Points.
								<br>Your Coalition Current Point Balance is:&nbsp;<b>'.$New_login_curr_balance.'</b> Points.
								<br><br>',
								'Template_type' => 'Transfer_points'
							);
							$this->send_notification->send_Notification_email($Login_Enrollement_id,$TransPoints_contents,'0',$Company_id);
						*/

							$Email_content=array(
							'Notification_type' =>'You have Transferred '.$Company_details->Currency_name,
							'Transferred_to' =>$member_details->First_name.' '.$member_details->Last_name.' ('.$member_details->Card_id.')',
							'Transferred_points' =>$Transfer_Points,
							'Template_type' => 'Transfer_points'

							);
							$this->send_notification->send_Notification_email($Login_Enrollement_id,$Email_content,'0',$Company_id);

						/*
							$Get_TransPoints_contents = array(
								'Communication_id' => '0',
								'Notification_type' => 'You have Received Points from '.$get_member12->First_name.' '.$get_member12->Last_name.'Successfully.',
								'Notification_description' =>'You have Received Points from:&nbsp;'.$get_member12->First_name.' '.$get_member12->Last_name.'.
								Successfully.<br><br> Points Received:&nbsp; <b>'.$Transfer_Points.'</b> Points.
								<br>Your Coalition Current Point Balance is:&nbsp; <b>'.$New_member_curr_balance.'</b> Points.
								<br><br>',
								'Template_type' => 'Get_transfer_points'
							);
							$this->send_notification->send_Notification_email($Member_Enrollement_id,$Get_TransPoints_contents,'0',$Company_id);
						*/
						$Email_content12=array(
							'Notification_type' =>'You have Received '.$Company_details->Currency_name.' from ',
							'Received_from' =>$get_member12->First_name.' '.$get_member12->Last_name.' ('.$get_member12->Card_id.')',
							'Received_points' =>$Transfer_Points,
							'Template_type' => 'Get_transfer_points'

							);
							$this->send_notification->send_Notification_email($Member_Enrollement_id,$Email_content12,'0',$Company_id);

					}
					/*********************Nilesh igain Log Table change 28-06-207*************************/
						$Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
						$Member_details2 = $this->Igain_model->get_enrollment_details($Member_Enrollement_id);
						$opration = 1;
						$userid = $session_data['userId'];
						$what="Transfer ".$Company_details->Currency_name;
						$where="Transfer Points";
						$opval = $Transfer_Points.' '.$Company_details->Currency_name;
						$Todays_date=date("Y-m-d");
						$firstName = $Member_details2->First_name;
						$lastName = $Member_details2->Last_name;
						$Enrollment_id = $Enroll_details->Enrollement_id;
						$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$session_data['enroll'],$session_data['username'],$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Member_Enrollement_id);
					/**********************igain Log Table change 28-06-2017 *************************/
					$this->session->set_flashdata("transfer","You have Transfered ".$Company_details->Currency_name." Successfully");
					$this->load->view('home/transfer_points', $data);
				}
			}
			else
			{
				$this->load->view('home/transfer_points', $data);
			}
		}
		else
		{
			redirect('login', 'refresh');
		}

	}
	public function get_member_details()
	{
		$session_data = $this->session->userdata('cust_logged_in');
		$data['Country_id'] = $session_data['Country_id'];

		$enrollment_details = $this->Igain_model->get_enrollment_details($this->input->post("Login_Enrollement_id"));
		// var_dump($enrollment_details);die;

		$Membership_id = $_REQUEST['Membership_id'];

		$dial_code = $this->Igain_model->get_dial_code1($data['Country_id']);

		$phnumber = $dial_code.$Membership_id;
		$phnumber = App_string_encrypt($phnumber);

		if( $this->input->post("Membership_id") == $enrollment_details->Card_id)
		{
			$this->output->set_output("0");
		}
		else
		{
			$result = $this->Igain_model->fetch_enrollment_details1($this->input->post("Company_id"),$this->input->post("Membership_id"),$this->input->post("Login_Enrollement_id"),$phnumber);
			if($result != NULL)
			{
				$this->output->set_output($result);
			}
			else
			{
				$this->output->set_output("0");
			}
		}
	}
	function getsurveyquestion() //from mail or Notification
	{

			// var_dump($_POST);
			// die;
			error_reporting(0);

			$Survey_data = json_decode(base64_decode($_REQUEST['Survey_data']));
			$Survey_data = get_object_vars($Survey_data);
			$survey_id = $Survey_data['Survey_id'];
			$gv_log_compid = $Survey_data['Company_id'];
			$Enrollment_id = $Survey_data['Enroll_id'];
			$Card_id = $Survey_data['Card_id'];


			if($Survey_data !="") //from Email
			{
				// echo"--if--condition---<br>";
				$smartphone_flag = 2;
				$data['From_survey_mail'] = 1;
				$survey_id = $survey_id;
				$gv_log_compid = $gv_log_compid;
				$Enrollment_id = $Enrollment_id;
				$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id,'Card_id'=>$Card_id);
				$data['Survey_data'] = base64_encode(json_encode($myData1));
			}
			else //from application and APK
			{
				// echo"--else--condition---<br>";
				$survey_id = $_REQUEST['Survey_id'];
				$gv_log_compid = $_REQUEST['Company_id'];
				$Enrollment_id = $_REQUEST['Enroll_id'];
				$Card_id = $_REQUEST['Card_id'];
				$smartphone_flag = $_REQUEST['smartphone_flag'];

				$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$gv_log_compid,'Enroll_id'=>$Enrollment_id,'Card_id'=>$Card_id);
				$data['Survey_data'] = base64_encode(json_encode($myData1));
				// $data['Survey_data']=1;
			}
			$data['smartphone_flag']=$smartphone_flag;
			// echo"--survey_id--".$survey_id."---<br>";
			// echo"--gv_log_compid--".$gv_log_compid."---<br>";
			// echo"--Enrollment_id--".$Enrollment_id."---<br>";
			// var_dump($data['Survey_data']);

			$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
			$data['Survey_response_count'] = $this->Survey_model->fetch_survey_count($survey_id,$gv_log_compid,$Enrollment_id);
			$flag=$this->input->post('flag');
			$Company_details= $this->Igain_model->get_company_details($gv_log_compid);
			$SurveyTemplate= $this->Survey_model->get_survey_template($survey_id);
			$Company_survey_analysis=$Company_details->Survey_analysis;
			$Survey_name=$SurveyTemplate->Survey_name;
			// $SurveyTemplate->Survey_template;
			// echo"<pre>";
			// echo"----SurveyTemplate----".$SurveyTemplate->Survey_template."--<br>";
			// echo"----<br><br>";
			//die;
			// var_dump($_POST);
			// die;

			if($_POST == NULL)
			{
				if($SurveyTemplate->Survey_template==1)
				{
					$this->load->view('home/survey_template1/index', $data);
				}
				else if($SurveyTemplate->Survey_template==2)
				{
					$this->load->view('home/survey_template2/index', $data);
				}
				else if($SurveyTemplate->Survey_template==3)
				{
					$this->load->view('home/survey_template3/index', $data);
				}

			}
			else
			{
				// echo"<pre>";
				// print_r($_POST);
				// die;
				$Enrollment_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				$data['Card_id']=$Enrollment_details->Card_id;
				$data['timezone_entry']=$Enrollment_details->timezone_entry;
				$logtimezone = $data['timezone_entry'];
				$timezone = new DateTimeZone($logtimezone);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$lv_date_time=$date->format('Y-m-d H:i:s');
				$Todays_date = $date->format('Y-m-d');
				$data['Survey_details1'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
				foreach($data['Survey_details1'] as $surdtls1)
				{

					$Multiple_selection=$surdtls1['Multiple_selection'];
					$Question=$surdtls1['Question'];
					$Question_id=$surdtls1['Question_id'];
					$Response_type=$surdtls1['Response_type'];
					$Choice_id=$ch_val['Choice_id'];
					$Option_values=$ch_val['Option_values'];

					if($Response_type == 2 ) //Text Based Question
					{
						// echo"<br>--Text Based Question---<br><br>";
						$get_flag=0;
						$response = $this->input->post($Question_id);
						$Cust_response = strtolower($response);
						if($Company_survey_analysis == 1)
						{
							// echo"<br>--<b>Company_survey_analysis-->".$Company_survey_analysis."</b>-----";
							$get_promoters_dictionary_keywords = $this->Survey_model->get_nps_promoters_keywords($gv_log_compid);
							foreach($get_promoters_dictionary_keywords as $NPS_promo)
							{

								$dictionary_keywords=strtolower($NPS_promo['NPS_dictionary_keywords']);
								$Get_promo_keywords=explode(",",$dictionary_keywords);
								$NPS_type_id=$NPS_promo['NPS_type_id'];
								// echo"<br>--Get_promo_keywords--><br>"; print_r($Get_promo_keywords);
								//	echo"<br>---<br>";
								// $response_flag=0;
								for($i=0;$i<count($Get_promo_keywords); $i++)
								{
									// echo"---".$Get_promo_keywords[$i]."---<br>";
									// echo"<br>--Cust_response--".$Cust_response."<br>";
									$pos = strpos($Cust_response, $Get_promo_keywords[$i]);
									// echo "--<br>-<b>-pos--".$pos."---</b>--";
									if(is_int($pos) == true)
									{
										//echo "<br>--------Inserting Records--<br>";
										//echo"<br>---NPS_type_id----->".$NPS_type_id."----<br>";
										$get_flag=1;
										$NPS_type_id=$NPS_promo['NPS_type_id'];
										break;
									}
								}
								// echo"<br>--get_flag----->".$get_flag."----<br>";
								if($get_flag==1)
								{
									// echo"<br>--Inseret into Table---<br>";
									// echo"<br>--Inserting---NPS_type_id----->".$NPS_type_id."----<br>";
									$post_data = array(
									'Enrollment_id' => $Enrollment_id,
									'Company_id' => $gv_log_compid,
									'Survey_id' => $survey_id,
									'Question_id' =>$Question_id,
									'Response1' =>$Cust_response,
									'NPS_type_id' =>$NPS_type_id
									);
									$response_flag=0;
									$insert_response = $this->Survey_model->insert_survey_response($post_data);
									if($insert_response == true)
									{
										$response_flag=1;
									}
									else
									{
										$response_flag=0;
									}
									break;
								}
							}
							if($get_flag==0)
							{
								// echo"<br>--Inseret into Table--witho 0 flag-<br>";
								$NPS_type_id=2;
								$post_data = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $gv_log_compid,
								'Survey_id' => $survey_id,
								'Question_id' =>$Question_id,
								'Response1' =>$Cust_response,
								'NPS_type_id' =>$NPS_type_id
								);
								$response_flag=0;
								$insert_response = $this->Survey_model->insert_survey_response($post_data);
								if($insert_response == true)
								{
									$response_flag=1;
								}
								else
								{
									$response_flag=0;
								}
							}
						}
						else
						{

							// echo"<br>--<b>Company_survey_analysis----2--->".$Company_survey_analysis."</b>-----";
							$post_data = array(
							'Enrollment_id' => $Enrollment_id,
							'Company_id' => $gv_log_compid,
							'Survey_id' => $survey_id,
							'Question_id' =>$Question_id,
							'Response1' =>$this->input->post($Question_id),
							'NPS_type_id' =>'0'
							);
							$response_flag=0;
							$insert_response = $this->Survey_model->insert_survey_response($post_data);
							if($insert_response == true)
							{
								$response_flag=1;

							}
							else
							{
								$response_flag=0;
							}
						}
						// echo"---Text Based Questions---<br><br>";
					}
					else if($Multiple_selection)//Multiple Selection based Question i.e. Check box Based
					{
						//echo"---Multiple_selection--Check box Based---".$Multiple_selection."<br><br>";

						// echo"---<br>";
						//print_r($this->input->post($Question_id));
						//echo"<br><br>";

						$multiple_sel=$this->input->post($Question_id);
						foreach($multiple_sel as $mulsel)
						{
							$array_mul = explode('_',$mulsel);
							$Mul_response2=$array_mul[0];
							$Mul_Choice_id=$array_mul[1];

							//echo"---Check box---Mul_response2---".$Mul_response2."------<br>";
							//echo"---Check box---Mul_Choice_id---".$Mul_Choice_id."------<br>";

							if($Company_survey_analysis == 1)
							{
								$Survey_nps_type_id = $this->Survey_model->get_survey_nps_type($Mul_response2);
								$Survey_nps_type=$Survey_nps_type_id->NPS_type_id;
							}
							//echo"---Check box----Survey_nps_type---".$Survey_nps_type."-----<br>";
							//echo"--<br>*******<br>---";
							if($Survey_nps_type ==1 )
							{
								$Promo_nps[]=$Survey_nps_type;
							}
							else if($Survey_nps_type ==2 )
							{
								$Passive_nps[]=$Survey_nps_type;
							}
							else
							{
								$Dectractive_nps[]=$Survey_nps_type;
							}
						}

						/* echo"-----count---Promo_nps---".count($Promo_nps)."--<br>";
						echo"-----count---Passive_nps---".count($Passive_nps)."--<br>";
						echo"-----count---Dectractive_nps---".count($Dectractive_nps)."--<br>";
						echo"-----<br><br>-----"; */

						// if(count($Promo_nps) > 0 || count($Promo_nps) > 0 || count($Promo_nps) > 0 )
						if(count($Promo_nps) > 0 || count($Passive_nps) > 0 || count($Dectractive_nps) > 0 )
						{
							if(count($Promo_nps) == count($Dectractive_nps))
							{
								//echo"-----<br>-its--Passive--<br>-----";
								$Survey_nps_type=2;
							}
							else if(count($Promo_nps) > count($Dectractive_nps) && count($Promo_nps) > count($Passive_nps))
							{
								//echo"-----<br>-its--Promoters--<br>-----";
								$Survey_nps_type=1;
							}
							else if(count($Passive_nps) >= count($Dectractive_nps))
							{
								//echo"-----<br>-its--Promoters--<br>-----";
								$Survey_nps_type=1;
							}
							else
							{
								//echo"-----<br>-its--Dectractive--<br>-----";
								$Survey_nps_type=3;
							}
						}
						else
						{
							$Survey_nps_type=2;
						}


						if($Survey_nps_type != "")
						{
							$NPS_type_id12 = $Survey_nps_type;
						}
						else
						{
							$NPS_type_id12 =2;
						}
						if($Mul_response2 != "")
						{
							$Mul_response2=$Mul_response2;
						}
						else
						{
							$Mul_response2=0;
						}
						if($Mul_Choice_id != "")
						{
							$Mul_Choice_id=$Mul_Choice_id;
						}
						else
						{
							$Mul_Choice_id=0;
						}

						// echo"--Final---NPS_type_id12---".$NPS_type_id12."--<br>";


						$post_data1 = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $gv_log_compid,
								'Survey_id' => $survey_id,
								'Question_id' =>$Question_id,
								'Response2' => $Mul_response2,
								'Choice_id' => $Mul_Choice_id,
								'NPS_type_id' => $NPS_type_id12
								);
							//print_r($post_data1);
							$response_flag=0;
							$insert_response = $this->Survey_model->insert_survey_response($post_data1);
							if($insert_response == true)
							{
								$response_flag=1;

							}
							else
							{
								$response_flag=0;
							}


							unset($Promo_nps);
							unset($Passive_nps);
							unset($Dectractive_nps);

					}
					else //MCQ based Question i.e. Radio Based
					{
							//echo"--Radio Based---MCQ Based Question--Radio Based---<br><br>";
							$array = explode('_',$this->input->post($Question_id));
							// var_dump($array);
							$Response2=$array[0];
							$Choice_id=$array[1];
							//echo"--Radio Based---MCQ---Response2---".$Response2."--<br>";
							if($Company_survey_analysis == 1)
							{
								$Survey_nps_type_id = $this->Survey_model->get_survey_nps_type($Response2);
								$Survey_nps_type=$Survey_nps_type_id->NPS_type_id;
							}
							//echo"--Radio Based---MCQ---Response2---".$Response2."--<br>";
							if($Survey_nps_type != "")
							{
								$NPS_type_id12 = $Survey_nps_type;
							}
							else
							{
								$NPS_type_id12 = 2;
							}
							if($Response2 != "")
							{
								$Response2=$Response2;
							}
							else
							{
								$Response2=0;
							}
							if($Choice_id != "")
							{
								$Choice_id=$Choice_id;
							}
							else
							{
								$Choice_id=0;
							}
							$post_data = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $gv_log_compid,
								'Survey_id' => $survey_id,
								'Question_id' =>$Question_id,
								'Response2' => $Response2,
								'Choice_id' => $Choice_id,
								'NPS_type_id' => $NPS_type_id12
								);
							//print_r($post_data );
							$response_flag=0;
							$insert_response = $this->Survey_model->insert_survey_response($post_data);
							if($insert_response == true)
							{
								$response_flag=1;

							}
							else
							{
								$response_flag=0;
							}
					}
				}

				//die;
				if($response_flag=1)
				{
					$Survey_details=$this->Survey_model->get_survey_details($survey_id,$gv_log_compid);
					 $Survey_name=$Survey_details->Survey_name;
					 $Start_date=$Survey_details->Start_date;
					 $End_date=$Survey_details->End_date;
					 $Survey_reward_points=$Survey_details->Survey_reward_points;
					 $Survey_rewarded=$Survey_details->Survey_rewarded;

					if(($Survey_rewarded == 1) && ( $Todays_date >= $Start_date && $Todays_date <= $End_date ))
					{
						$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
						$Card_id=$Enroll_details->Card_id;
						$Current_balance=$Enroll_details->Current_balance;
						$Total_topup_amt=$Enroll_details->Total_topup_amt;
						$Blocked_points =$Enroll_details->Blocked_points;

						$post_data1 = array(
							'Company_id' => $gv_log_compid,
							'Trans_type' => 13,
							'Topup_amount' => $Survey_reward_points,
							'Trans_date' => $lv_date_time,
							'Enrollement_id' => $Enrollment_id,
							'Card_id' => $Card_id,
							'Remarks' => 'Survey Reward '.$Company_details->Currency_name
							);
							$insert_survey_rewards=$this->Survey_model->insert_survey_rewards_transaction($post_data1);

						if($insert_survey_rewards == TRUE)
						{
							 $Total_Current_Balance=$Current_balance+$Survey_reward_points;
							 $Total_Topup_Amount=$Total_topup_amt+$Survey_reward_points;
							$data1=array(
							'Current_balance' => $Total_Current_Balance,
							'Total_topup_amt' => $Total_Topup_Amount
							);

							$update_balance=$this->Survey_model->update_member_balance($data1,$Enrollment_id,$gv_log_compid);

							$SuperSeller=$this->Igain_model->get_super_seller_details($gv_log_compid);
							$SuperSellerEnrollID=$SuperSeller->Enrollement_id;
							$member_details=$this->Igain_model->get_enrollment_details($Enrollment_id);

							$Total_Current_Balance =  $Total_Current_Balance - $Blocked_points;
							$Email_content = array(
								'SurveyRewardsPoints' => $Survey_reward_points,
								'Survey_name' => $Survey_name,
								'Notification_type' => 'Survey Reward '.$Company_details->Currency_name,
								'Template_type' => 'Survey_rewards'
								);

							$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$SuperSellerEnrollID,$gv_log_compid);

						}
					}
					/*********************Nilesh igain Log Table change 27-06-207*************************/
					// $Enrollment_id = $result->Enrollement_id;
					$User_id = $result->User_id;
					$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
					$User_id = $Enroll_details->User_id;
					$email = $Enroll_details->User_email_id;
					$opration = 1;
					// $userid = $User_id;
					$what="Survey Response";
					$where="Take Survey";
					$toname="";
					$toenrollid = 0;
					$opval = 'Survey Name: '.$Survey_name;
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details->First_name;
					$lastName = $Enroll_details->Last_name;
					$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($gv_log_compid,$Enrollment_id,$email,$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 27-06-2017 *************************/
					// $this->session->set_flashdata("survey_feed","Survey Feedback Submitted Successfuly!!");

					if($Survey_rewarded == 1)
					{

						if($this->input->post('From_survey_mail')==1)
						{
							?>
							<script>
							var  rewardpts ='<?php echo $Survey_reward_points; ?>';
							var  Currency_name ='<?php echo $Company_details->Currency_name; ?>';
							if(confirm('The Survey Feedback has been submitted successfully. Thank You for the same. You have received '+rewardpts+' Reward Bonus '+Currency_name+' . Please check your email for more details.'))
							{
								window.close();
							}
							</script>
							<?php
						}
						else
						{
							/* ?>
							<script>
							var  rewardpts ='<?php echo $Survey_reward_points; ?>';
							if(confirm('The Survey Feedback has been submitted successfully. Thank You for the same. You have received '+rewardpts+' Reward Bonus Points . Please check your email for more details.'))
							</script>
							<?php */

							$this->session->set_flashdata("survey_feed","The Survey Feedback has been submitted successfully. Thank You for the same. You have received ".$Survey_reward_points." Reward Bonus ".$Company_details->Currency_name." . Please check your email for more details!!");

							redirect('Cust_home/getsurvey');
						}
					}
					else
					{
						if($this->input->post('From_survey_mail')==1)
						{
							?>
							<script>
							if(confirm('The Survey Feedback has been submitted successfully.'))
							{
								window.close();
							}
							</script>
							<?php
						}
						else
						{
							/* ?>
							<script>
							if(confirm('The Survey Feedback has been submitted successfully.'))
							{
								window.close();
							}
							</script>
							<?php */
							$this->session->set_flashdata("survey_feed","The Survey Feedback has been submitted successfully!!");
							redirect('Cust_home/getsurvey');
						}

					}



				}
				else
				{
					// $this->session->set_flashdata("survey_feed","Error Submiting Survey Feedback. Please Provide valid data!!");
					if($this->input->post('From_survey_mail')==1)
					{
						?>
						<script>
						if(confirm('Error Submiting Survey Feedback. Please Provide valid data.'))
						{
							window.close();
						}
						</script>
						<?php
					}
					else
					{
						/* ?>
						<script>
						if(confirm('Error Submiting Survey Feedback. Please Provide valid data.'))
						{
							window.close();
						}
						</script>
						<?php */
						$this->session->set_flashdata("survey_feed","Error Submiting Survey Feedback. Please Provide valid data!!");
						redirect('Cust_home/getsurvey');
					}



				}
				// redirect('Cust_home/getsurveyquestion');

			}
	}
	function getsurvey()
	{

		if($this->session->userdata('cust_logged_in'))
		{

			// var_dump($_POST);
			// die;
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['First_name'] = $session_data['First_name'];
			$data['Last_name'] = $session_data['Last_name'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];

			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');

			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);


			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$data["get_survey_details"] = $this->Survey_model->get_send_survey_details($data['enroll'],$data['Company_id'],$Todays_date);

			if($_POST != NULL)
			{
				echo "----1----";
				$survey_id = $this->input->post('Survey_id');
				$compid = $this->input->post('Company_id');
				$Enrollment_id = $this->input->post('Enrollment_id');

				$myData1 = array('Survey_id'=>$survey_id, 'Company_id'=>$compid,'Enroll_id'=>$Enrollment_id);
				$Survey_data1 = base64_encode(json_encode($myData1));

				$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$compid,$Enrollment_id);
				$data['Survey_response_count'] = $this->Survey_model->fetch_survey_count($survey_id,$compid,$Enrollment_id);
				// $this->load->view('home/take_survey2', $data); redirect('Cust_home/getsurveyquestion');

				$this->load->view('home/take_survey', $data);


				$myData = array('Survey_id'=>$survey_id, 'Company_id'=>$compid,'Enroll_id'=>$Enrollment_id);
				// var_dump($myData);
				$Survey_data = base64_encode(json_encode($myData));
				$Survey_URL = base_url()."Company_".$compid."/index.php/Cust_home/getsurveyquestion/?Survey_data=".$Survey_data;
				$Survey_link = "<a href='".$Survey_URL."' target='_blank' style='color:#000;'>Click here to take a Survey</a>";

				// $this->load->view($Survey_link);

			}
			else
			{
				// echo "----2----";

				$this->load->view('home/get_survey', $data);

			}
		}
		else
		{
			redirect('login', 'refresh');
		}

	}
	function getsurveyquestion2()
	{

		$session_data = $this->session->userdata('cust_logged_in');
		$data['username'] = $session_data['username'];
		$data['First_name'] = $session_data['First_name'];
		$data['Last_name'] = $session_data['Last_name'];
		$data['enroll'] = $session_data['enroll'];
		$data['userId']= $session_data['userId'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];

		$survey_id = $this->input->post('survey_id');
		$gv_log_compid = $this->input->post('Company_id');
		$Enrollment_id = $this->input->post('Enrollment_id');

		$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
		$data['Survey_response_count'] = $this->Survey_model->fetch_survey_count($survey_id,$gv_log_compid,$Enrollment_id);
		$survey_count=count($data['Survey_details']);

		$logtimezone = $session_data['timezone_entry'];
		$timezone = new DateTimeZone($logtimezone);
		$date = new DateTime();
		$date->setTimezone($timezone);
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');

		$Company_details= $this->Igain_model->get_company_details($gv_log_compid);
		$Survey_analysis=$Company_details->Survey_analysis;
		// echo"--Survey_analysis----".$Survey_analysis."--<br>";
		// var_dump($_POST);
		// echo"---<br><br>---";
		if($_POST == NULL)
		{
			$this->load->view('home/get_survey', $data);
		}
		else
		{
			$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
			foreach($data['Survey_details'] as $surdtls)
			{
				$Question=$surdtls['Question'];
				$Question_id=$surdtls['Question_id'];
				$Response_type=$surdtls['Response_type'];
				$Choice_id=$ch_val['Choice_id'];
				$Option_values=$ch_val['Option_values'];
				if($Response_type == 2 )
				{
					$Input_question_id=$this->input->post($Question_id);
					if($Input_question_id == "")
					{
						$this->session->set_flashdata("survey_feed","Please Answer all the Questions!!");
						redirect('Cust_home/getsurvey');
					}
				}
				else
				{
					// $array = explode('_',$this->input->post($Question_id));
					$Input_question_id=$this->input->post($Question_id);
					if($Input_question_id == "")
					{
						$this->session->set_flashdata("survey_feed","Please Answer all the Questions!!");
						redirect('Cust_home/getsurvey');
					}
				}
			}
			$data['Survey_details'] = $this->Survey_model->fetch_survey_questions($survey_id,$gv_log_compid,$Enrollment_id);
			foreach($data['Survey_details'] as $surdtls)
			{
				$Question=$surdtls['Question'];
				$Question_id=$surdtls['Question_id'];
				$Response_type=$surdtls['Response_type'];
				$Choice_id=$ch_val['Choice_id'];
				$Option_values=$ch_val['Option_values'];
				if($Response_type == 2 ) //Text Based Question
				{
					// echo"-----Text--Base--Question----<br>";
					$text_response=$this->input->post($Question_id);
					$get_flag=0;
					$response = $this->input->post($Question_id);
					$Cust_response = strtolower($response);
					 // echo"<br>--<b>Cust_response-->".$Cust_response."</b><br><br>";
					if($Survey_analysis == 1)
					{
						$get_promoters_dictionary_keywords = $this->Survey_model->get_nps_promoters_keywords($gv_log_compid);
						// print_r($get_promoters_dictionary_keywords); echo"<br>---<br>";
						foreach($get_promoters_dictionary_keywords as $NPS_promo)
						{

							$dictionary_keywords=strtolower($NPS_promo['NPS_dictionary_keywords']);
							$Get_promo_keywords=explode(",",$dictionary_keywords);
							$NPS_type_id=$NPS_promo['NPS_type_id'];

							// echo"<br>--Get_promo_keywords--><br>"; print_r($Get_promo_keywords);
							//echo"<br>---<br>";
							// $response_flag=0;
							for($i=0;$i<count($Get_promo_keywords); $i++)
							{
								// echo"---".$Get_promo_keywords[$i]."---<br>";
								// echo"<br>--Cust_response--".$Cust_response."<br>";
								$pos = strpos($Cust_response, $Get_promo_keywords[$i]);
								// echo "--<br>-<b>-pos--".$pos."---</b>--";
								if(is_int($pos) == true)
								{
									//echo "<br>--------Inserting Records--<br>";
									//echo"<br>---NPS_type_id----->".$NPS_type_id."----<br>";
									$get_flag=1;
									$NPS_type_id=$NPS_promo['NPS_type_id'];
									break;
								}
							}
							// echo"<br>--get_flag----->".$get_flag."----<br>";
							if($get_flag==1)
							{
								// echo"<br>--Inseret into Table---<br>";
								// echo"<br>--Inserting---NPS_type_id----->".$NPS_type_id."----<br>";
								$post_data = array(
										'Enrollment_id' => $Enrollment_id,
										'Company_id' => $gv_log_compid,
										'Survey_id' => $survey_id,
										'Question_id' =>$Question_id,
										'Response1' =>$Cust_response,
										'NPS_type_id' =>$NPS_type_id
										);
										$response_flag=0;
										$insert_response = $this->Survey_model->insert_survey_response($post_data);
										if($insert_response == true)
										{
											$response_flag=1;

										}
										else
										{
											$response_flag=0;
										}
										break;
							}
						}
							if($get_flag==0)
							{
								// echo"<br>--Inseret into Table--witho 0 flag-<br>";
								$NPS_type_id=2;
								$post_data = array(
								'Enrollment_id' => $Enrollment_id,
								'Company_id' => $gv_log_compid,
								'Survey_id' => $survey_id,
								'Question_id' =>$Question_id,
								'Response1' =>$Cust_response,
								'NPS_type_id' =>$NPS_type_id
								);
								$response_flag=0;
								$insert_response = $this->Survey_model->insert_survey_response($post_data);
								if($insert_response == true)
								{
									$response_flag=1;
								}
								else
								{
									$response_flag=0;
								}
							}


					}
					else
					{
					  $post_data = array(
						'Enrollment_id' => $Enrollment_id,
						'Company_id' => $gv_log_compid,
						'Survey_id' => $survey_id,
						'Question_id' =>$Question_id,
						'Response1' =>$this->input->post($Question_id),
						'NPS_type_id' =>'0'
						);
						$response_flag=0;
						$insert_response = $this->Survey_model->insert_survey_response($post_data);
						if($insert_response == true)
						{
							$response_flag=1;

						}
						else
						{
							$response_flag=0;
						}
					}

				}
				else //MCQ Based Question
				{
					$array = explode('_',$this->input->post($Question_id));
					$Response2=$array[0];
					$Choice_id=$array[1];
					if($Survey_analysis == 1)
					{
						$Survey_nps_type_id = $this->Survey_model->get_survey_nps_type($Response2);
						$Survey_nps_type=$Survey_nps_type_id->NPS_type_id;
					}
					// echo"--Survey_nps_type----".$Survey_nps_type."--<br>";
					if($Survey_nps_type != "")
					{
						$NPS_type_id = $Survey_nps_type;
					}
					else
					{
						$NPS_type_id = '0';
					}
					// echo"--NPS_type_id----".$NPS_type_id."--<br>";
					$post_data = array(
						'Enrollment_id' => $Enrollment_id,
						'Company_id' => $gv_log_compid,
						'Survey_id' => $survey_id,
						'Question_id' =>$Question_id,
						'Response2' => $Response2,
						'Choice_id' => $Choice_id,
						'NPS_type_id' => $NPS_type_id
						);

						$response_flag=0;
						$insert_response = $this->Survey_model->insert_survey_response($post_data);
						if($insert_response == true)
						{
							$response_flag=1;

						}
						else
						{
							$response_flag=0;
						}
				}
			}
			$today=date('Y-m-d');

			if($response_flag=1)
			{
				$Survey_details=$this->Survey_model->get_survey_details($survey_id,$gv_log_compid);

				 $Survey_name=$Survey_details->Survey_name;
				 $Start_date=$Survey_details->Start_date;
				 $End_date=$Survey_details->End_date;
				 $Survey_reward_points=$Survey_details->Survey_reward_points;
				 $Survey_rewarded=$Survey_details->Survey_rewarded;

				if(($Survey_rewarded == 1) && ( $Todays_date >= $Start_date && $Todays_date <= $End_date ))
				{
					$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);

					$Card_id=$Enroll_details->Card_id;
					$Current_balance=$Enroll_details->Current_balance;
					$Total_topup_amt=$Enroll_details->Total_topup_amt;
					$Blocked_points = $Enroll_details->Blocked_points;

					$post_data1 = array(
						'Company_id' => $gv_log_compid,
						'Trans_type' => 13,
						'Topup_amount' => $Survey_reward_points,
						'Trans_date' => $lv_date_time,
						'Enrollement_id' =>$Enrollment_id,
						'Card_id' => $Card_id,
						'Remarks' => 'Survey Reward '.$Company_details->Currency_name
						);
					$insert_survey_rewards=$this->Survey_model->insert_survey_rewards_transaction($post_data1);
					if($insert_survey_rewards == TRUE)
					{
						 $Total_Current_Balance=$Current_balance+$Survey_reward_points;
						 $Total_Topup_Amount=$Total_topup_amt+$Survey_reward_points;
						 // echo"Total_Current_Balance--".$Total_Current_Balance."----------<br>";
						 // echo"Total_Topup_Amount--".$Total_Topup_Amount."----------<br>";
						$data1=array(
						'Current_balance' => $Total_Current_Balance,
						'Total_topup_amt' => $Total_Topup_Amount
						);
						$update_balance=$this->Survey_model->update_member_balance($data1,$Enrollment_id,$gv_log_compid);

						$SuperSeller=$this->Igain_model->get_super_seller_details($gv_log_compid);
							$SuperSellerEnrollID=$SuperSeller->Enrollement_id;
							$member_details=$this->Igain_model->get_enrollment_details($Enrollment_id);

							 $Total_Current_Balance =  $Total_Current_Balance - $Blocked_points;

							/* $Email_content = array(
								'SurveyRewardsPoints' => $Survey_reward_points,
								'Total_Current_Balance' => $Total_Current_Balance,
								'Notification_type' => 'Survey Reward Points',
								'Template_type' => 'Survey_rewards',
								'Notification_description' => ' Dear <b>'.$member_details->First_name.' '.$member_details->Last_name.',</b> <br><br>You have Successfully Received Survey Reward Points.&nbsp.<br>
									<br>Survey Name :&nbsp <b>'.$Survey_name.'</b>
									<br>Survey Reward Points is:&nbsp<b>'.$Survey_reward_points.'</b><br>
									Your Coalition Current Balance is:&nbsp<b>'.$Total_Current_Balance.'</b><br><br>'); */

							$Email_content = array(
								'SurveyRewardsPoints' => $Survey_reward_points,
								'Survey_name' => $Survey_name,
								'Notification_type' => 'Survey Reward '.$Company_details->Currency_name,
								'Template_type' => 'Survey_rewards'
								);

							$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$SuperSellerEnrollID,$gv_log_compid);
					}
				}
				/*********************Nilesh igain Log Table change 28-06-207*************************/
					$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
					$opration = 1;
					$userid = 1;
					$what="Survey Responded";
					$where="Take Survey";
					$opval ='Survey name-'.$Survey_name;
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details->First_name;
					$lastName = $Enroll_details->Last_name;
					$Enrollment_id = $Enroll_details->Enrollement_id;
					$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($gv_log_compid,$Enrollment_id,$LogginUserName,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table change 28-06-2017 *************************/
				$this->session->set_flashdata("survey_feed","Survey Feedback Submitted Successfuly!!");
			}
			else
			{
				$this->session->set_flashdata("survey_feed","Error Submiting Survey Feedback. Please Provide valid data!!");
			}
			redirect('Cust_home/getsurvey');

		}
	}
	function enroll_new_member_website()
	{
		$first_name=$_REQUEST['first_name'];
		$last_name=$_REQUEST['last_name'];
		// $email=$_REQUEST['email'];
		$email=App_string_encrypt($_REQUEST['email']);
		$Phone_no=$_REQUEST['phno'];	
		$Company_id=$_REQUEST['Company_id'];
		$data['Company_id']=$Company_id;
		
		$Company_Details= $this->Igain_model->get_company_details($Company_id);
		$Cust_website=$Company_Details->Cust_website;
		
		
		if($first_name !="" || $last_name !="" || $email !="" || $Company_id !="" || $Phone_no !="")
		{
			$company_details = $this->Igain_model->get_company_details($Company_id);
			$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
			$Dial_Code = $this->Igain_model->get_dial_code($Super_Seller_details->Country);
			$dialcode=$Dial_Code->phonecode;
			$phoneNo=$dialcode.''.$Phone_no;
			$phoneNo=App_string_encrypt($phoneNo);
			$timezone_entry=$Super_Seller_details->timezone_entry;
			
			$logtimezone = $timezone_entry;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');

			$Check_EmailID=$this->Igain_model->Check_EmailID($email,$Company_id);
			
			if($Check_EmailID == 0)
			{
				$CheckPhone_number=$this->Igain_model->CheckPhone_number($phoneNo,$Company_id);
				if($CheckPhone_number ==0)
				{
					$card_decsion=$company_details->card_decsion;
					$Joining_bonus=$company_details->Joining_bonus;
					$Joining_bonus_points=$company_details->Joining_bonus_points;
					if($card_decsion==1)
					{
						 $Card_id=$company_details->next_card_no;
						// $nestcard1=$Card_id+1;

						$nestcard1=$company_details->next_card_no;
						$nestcard1++;

						if($Joining_bonus==1)
						{
							$Current_balance=$company_details->Joining_bonus_points;
							$Total_topup_amt=$company_details->Joining_bonus_points;
						}
						else
						{
							$Current_balance=0;
							$Total_topup_amt=0;
						}
					}
					else
					{
						$Card_id=0;
						$Current_balance=0;
						$Total_topup_amt=0;
					}
						$pin=$this->Igain_model->getRandomString(4);
						$post_enroll = array(
							'First_name' => $first_name,
							'Last_name' => $last_name,
							'Phone_no' => $phoneNo,
							'Country' => $Super_Seller_details->Country,
							'State' => $Super_Seller_details->State,
							'timezone_entry' => $timezone_entry,
							'Country_id' => $Super_Seller_details->Country,
							'User_email_id' => $email,
							'User_pwd' => $pin,
							'pinno' => $pin,
							'User_activated' => 1,
							'Company_id' => $Company_id,
							'Current_balance' => $Current_balance,
							'Total_topup_amt' => $Total_topup_amt,
							'User_id' => 1,
							'Card_id' => $Card_id,
							'joined_date' => $lv_date_time,
							'source' =>'Website'
						);

						$seller_id=$Super_Seller_details->Enrollement_id;
						$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
						$seller_curbal = $Super_Seller_details->Current_balance;
						$top_db2 = $Super_Seller_details->Topup_Bill_no;
						$len2 = strlen($top_db2);
						$str2 = substr($top_db2,0,5);
						$tp_bill2 = substr($top_db2,5,$len2);
						$topup_BillNo2 = $tp_bill2 + 1;
						$billno_withyear_ref = $str2.$topup_BillNo2;

						$Insert_enrollment=$this->Igain_model->insert_enroll_details($post_enroll);
						$Last_enroll_id=$Insert_enrollment;

					/*********************Nilesh igain Log Table change 29-06-207*************************/
						// $Enroll_details = $this->Igain_model->get_enrollment_details($Last_enroll_id);
						$opration = 1;
						$User_id = 1;
						$what="New Member Sign Up From Website";
						$where="Member Login";
						$opval = $first_name.' '.$last_name;
						$Todays_date=date("Y-m-d");
						$firstName = $first_name;
						$lastName = $last_name;
						$LogginUserName = $first_name.' '.$last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Last_enroll_id,$email,$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
					/**********************igain Log Table change 29-06-2017 *************************/

						if($Last_enroll_id > 0)
						{
							if($card_decsion==1)
							{
								$update_card_series=$this->Igain_model->UpdateCompanyMembershipID($nestcard1,$Company_id);
								if($Joining_bonus==1)
								{
									// $Todays_date = date("Y-m-d");
									$post_Transdata =
										array
											(
												'Trans_type' => '1',
												'Company_id' => $Company_id,
												'Topup_amount' => $Joining_bonus_points,
												'Trans_date' => $lv_date_time,
												'Remarks' => 'Joining Bonus',
												'Card_id' => $Card_id,
												'Seller_name' =>$Seller_name ,
												'Seller' => $seller_id,
												'Enrollement_id' => $Last_enroll_id,
												'Bill_no' => $tp_bill2,
												'remark2' => 'Super Seller',
												'Loyalty_pts' => '0'
											);

									$result6 = $this->Igain_model->insert_topup_details($post_Transdata);
									$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
									$result3 = $this->Igain_model->update_seller_balance($Last_enroll_id,$Current_balance);
									if($company_details->Seller_topup_access=='1')
									{
										$Total_seller_bal = $seller_curbal-$Joining_bonus_points;
										$result3 = $this->Igain_model->update_seller_balance($seller_id,$Total_seller_bal);
									}
									$Email_content12 = array(
										'Joining_bonus_points' => $Joining_bonus_points,
										'Notification_type' => 'Joining Bonus',
										'Template_type' => 'Joining_Bonus',
										'Todays_date' => $Todays_date
									);
									$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$seller_id,$Company_id);
								}

								/***************Send Freebies Merchandize items************/
								$Merchandize_Items_Records = $this->Igain_model->Get_Merchandize_Items('', '',$Company_id,1);
								if($Merchandize_Items_Records != NULL  && $Card_id != "")
								{
									// $this->load->model('Redemption_catalogue/Redemption_Model');
									foreach($Merchandize_Items_Records as $Item_details)
									{
										/******************Changed AMIT 16-06-2016*************/
										// $this->load->model('Catalogue/Catelogue_model');
										$Get_Partner_Branches = $this->Igain_model->Get_Partner_Branches($Item_details->Partner_id,$Company_id);
										foreach($Get_Partner_Branches as $Branch)
										{
											$Branch_code=$Branch->Branch_code;
										}
										/********************************/

										/********************************/
										$characters = 'A123B56C89';
										$string = '';
										$Voucher_no="";
										for ($i = 0; $i < 16; $i++)
										{
											$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
										}
										$Voucher_status="Issued";

										if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
										{
											$insert_data = array(
											'Company_id' => $Company_id,
											'Trans_type' => 10,
											'Redeem_points' => $Item_details->Billing_price_in_points,
											'Quantity' => 1,
											'Trans_date' => $lv_date_time,
											'Create_user_id' => $seller_id,
											'Seller' => $seller_id,
											'Seller_name' => $Seller_name,
											'Enrollement_id' => $Last_enroll_id,
											'Bill_no' => $tp_bill2,
											'Card_id' => $Card_id,
											'Item_code' => $Item_details->Company_merchandize_item_code,
											'Voucher_no' => $Voucher_no,
											'Voucher_status' => $Voucher_status,
											'Merchandize_Partner_id' => $Item_details->Partner_id,
											'Remarks' => 'Freebies',
											'Merchandize_Partner_branch' => $Branch_code
												);
											 $Insert = $this->Igain_model->Insert_Redeem_Items_at_Transaction($insert_data);
											 $result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);

											  $Voucher_array[]=$Voucher_no;

											  /**********Send freebies notification********/
												$Email_content124 = array(
																'Merchandize_item_name' => $Item_details->Merchandize_item_name,
																'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
																'Item_image' => $Item_details->Item_image1,
																'Voucher_no' => $Voucher_no,
																'Voucher_status' => $Voucher_status,
																'Notification_type' => 'Freebies',
																'Template_type' => 'Enroll_Freebies',
																'Customer_name' => $first_name.' '.$last_name,
																'Todays_date' => $Todays_date
														);

											$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content124,$seller_id,$Company_id);
										}

									}

								}
								/*********************Merchandize end*************************/
							}

							$Email_content = array(
							'Notification_type' => 'Enrollment Details',
							'Template_type' => 'Enroll'
							);
							
							$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$seller_id,$Company_id);
							
							
							
							$this->session->set_flashdata("messege","You have been enrolled successfully.<br>Login credentials have been sent to your registered Email ID !!!");
							
							redirect($Cust_website);
							

						}
						else
						{
							
							$this->session->set_flashdata("messege","Entered Mobile No. already exist. Please enter valid Mobile No.");
							
							$data['Member_flag'] = 1;
							redirect($Cust_website);							
							
						}
				}
				else
				{
					
					$this->session->set_flashdata("messege","Entered Mobile No. already exist. <br>Please enter valid Mobile No.");
					$data['Member_flag'] = 1;
					
					redirect($Cust_website);					
					
				}
			}
			else
			{
				
				$this->session->set_flashdata("messege","Entered Email ID already exist. <br>Please enter valid Email ID");
				$data['Member_flag'] = 1;
				
				redirect($Cust_website);	
				

			}
		}	
		else
		{
							
			$this->session->set_flashdata("messege","Please Enter Valid details");
			
			redirect($Cust_website);
			

		}
	}

	//*************** sandeep work start ************************************/
	public function game_to_play()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["games"] = $this->Game_model->get_company_games($Company_id);

			if($_POST == NULL)
			{
				$this->load->view('Game/select_game', $data);
			}
			else
			{
				$game_type = $this->input->post('game_for');
				$comp_game_id = $this->input->post('Game_id');
				$Enrollment_id = $this->input->post('Enrollment_id');
				$User_id = $this->input->post('User_id');
				$membership_id = $this->input->post('membership_id');

				$gm_result = $this->Game_model->play_game($Company_id,$game_type,$comp_game_id,$Enrollment_id);

				$data["gm_result"] = $gm_result;

				if($gm_result == NULL)
				{
					$this->session->set_flashdata("select_game","Sorry, Game is not working!.");

					$this->load->view('Game/games_list', $data);
				}
				else
				{
					if($gm_result['Game_id'] == 1)
					{
						$this->load->view('Game/tetris', $data);
					}

					if($gm_result['Game_id'] == 2)
					{
						$this->load->view('Game/memory_game', $data);
					}

					if($gm_result['Game_id'] == 3)
					{
						$this->load->view('Game/snap_puzzle', $data);
					}
				}
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	public function get_games()
	{
		if($_POST != NULL)
		{
			$gameFlag =  $this->input->post("game_flag");
			$company_ID = $this->input->post("companyID");

			$data["games"] = $this->Game_model->get_games_byflag($company_ID,$gameFlag);

			$this->load->view('Game/games_list', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}

	public function game_level_fail()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);

			$Comp_Game_ID = $_GET['Comp_Game_ID'];
			$GameLevel = $_GET['GameLevel'];
			$MemberID = $_GET['MemberID'];
			$game_type = $_GET['game_type'];

			 $gm_result = $this->Game_model->level_fail($Company_id,$MemberID,$enrollID,$game_type,$Comp_Game_ID,$GameLevel);

			$data["gm_result"] = $gm_result;

			$this->session->set_flashdata("select_game","Game level ".$GameLevel." is Failed to Complete. Please Try Again! ");

			//print_r($data["gm_result"]);
			//die;

				if($gm_result['Game_id'] == 1)
				{
					$this->load->view('Game/tetris', $data);
				}

				if($gm_result['Game_id'] == 2)
				{
					$this->load->view('Game/memory_game', $data);
				}


				if($gm_result['Game_id'] == 3)
				{
					$this->load->view('Game/snap_puzzle', $data);
				}

		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function game_next_level()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);

			$Comp_Game_ID = $_GET['Comp_Game_ID'];
			$GameLevel = $_GET['GameLevel'];
			$MemberID = $_GET['MemberID'];
			$game_type = $_GET['game_type'];
			$game_score = $_GET['score'];

			 $gm_result = $this->Game_model->next_level($Company_id,$MemberID,$enrollID,$game_type,$Comp_Game_ID,$GameLevel,$game_score);

			$data["gm_result"] = $gm_result;

			$cmp_msg = $gm_result['cmp_msg'];

			if($gm_result != NULL)
			{
				$this->session->set_flashdata("select_game","$cmp_msg");
			}

				if($gm_result['Game_id'] == 1)
				{
					$this->load->view('Game/tetris', $data);
				}

				if($gm_result['Game_id'] == 2)
				{
					$this->load->view('Game/memory_game', $data);
				}

				if($gm_result['Game_id'] == 3)
				{
					$this->load->view('Game/snap_puzzle', $data);
				}

		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function get_game_competition_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];

			$gameID = $this->input->post("gameID");
			$Company_gameID = $this->input->post("Company_gameID");


			 $data['gm_details'] = $this->Game_model->game_competition_details($Company_id,$Company_gameID,$gameID);

			 $data['gm_prizes'] = $this->Game_model->game_competition_prizes($Company_id,$Company_gameID,$gameID);

			$theHTMLResponse = $this->load->view('Game/game_competition_details', $data, true);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('competitionHtml'=> $theHTMLResponse)));

		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function transfer_lives()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			// $Company_name= $session_data['Company_name'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $data["Company_details"]->Pin_no_applicable;
			$data['Cust_Pin'] = $data["Enroll_details"]->pinno;

			if($_GET['Comp_Game_ID'] > 0)
			{
				$Comp_Game_ID = $_GET['Comp_Game_ID'];
				$GameLevel = $_GET['GameLevel'];
				$gameID = $_GET['gameID'];
				$game_type = $_GET['game_type'];
				$livesFlag = $_GET['livesFlag'];

				$data["Comp_Game_ID"] = $Comp_Game_ID;
				$data["GameLevel"] = $GameLevel;
				$data["gameID"] = $gameID;
				$data["game_type"] = $game_type;

				if($livesFlag == 1)
				{
					$member_lives = $this->Game_model->get_member_all_lives($Company_id,$Comp_Game_ID,$enrollID);
				}

				$data["member_total_lives"] = $member_lives;

				$this->load->view('Game/transfer_lives', $data);
			}
			else
			{
				$gm_result = $this->Game_model->play_game($Company_id,$game_type,$Comp_Game_ID,$enrollID);

				$data["gm_result"] = $gm_result;

				if($gm_result == NULL)
				{
					$this->session->set_flashdata("select_game","Sorry, Game is not working!.");

					$this->load->view('Game/games_list', $data);
				}
				else
				{
					if($gm_result['Game_id'] == 1)
					{
						$this->load->view('Game/tetris', $data);
					}

					if($gm_result['Game_id'] == 2)
					{
						$this->load->view('Game/memory_game', $data);
					}

					if($gm_result['Game_id'] == 3)
					{
						$this->load->view('Game/snap_puzzle', $data);
					}
				}

			}
		}
		else
		{
			redirect('login', 'refresh');
		}

	}

	public function InsertTransferLives()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

			if($_POST != NULL)
			{
				$gm_opt = $this->Game_model->Transfer_lives($Company_id);

				$member_lives = $this->Game_model->get_member_all_lives($Company_id,$Comp_Game_ID,$enrollID);
				$data["member_total_lives"] = $member_lives;

				if($gm_opt == true)
				{
					$this->session->set_flashdata("select_game21","Congrats! You have Transferred Game Lives Successfully!");

				}
				else
				{
					$this->session->set_flashdata("select_game21","Sorry, You can not Transfer the Game Lives to this Member.");
				}

				$this->load->view('Game/transfer_lives', $data);

			}
			else
			{

				$gm_result = $this->Game_model->play_game($Company_id,$game_type,$Comp_Game_ID,$enrollID);

				$data["gm_result"] = $gm_result;

				if($gm_result == NULL)
				{
					$this->session->set_flashdata("select_game","Sorry, Game is not working!.");

					$this->load->view('Game/games_list', $data);
				}
				else
				{
					if($gm_result['Game_id'] == 1)
					{
						$this->load->view('Game/tetris', $data);
					}

					if($gm_result['Game_id'] == 2)
					{
						$this->load->view('Game/memory_game', $data);
					}

					if($gm_result['Game_id'] == 3)
					{
						$this->load->view('Game/snap_puzzle', $data);
					}
				}

			}

		}
		else
		{
			redirect('login', 'refresh');
		}

	}


	public function purchase_lives()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$data["redemptionratio"] = $data["Company_details"]->Redemptionratio;
			$data['Pin_no_applicable'] = $data["Company_details"]->Pin_no_applicable;
			$data['Cust_Pin'] = $data["Enroll_details"]->pinno;

			if($_GET['Comp_Game_ID'] > 0)
			{
				$Comp_Game_ID = $_GET['Comp_Game_ID'];
				$GameLevel = $_GET['GameLevel'];
				$gameID = $_GET['gameID'];
				$game_type = $_GET['game_type'];
				$livesFlag = $_GET['livesFlag'];

				$data["Comp_Game_ID"] = $Comp_Game_ID;
				$data["GameLevel"] = $GameLevel;
				$data["gameID"] = $gameID;
				$data["game_type"] = $game_type;

				$data["Comp_Game_info"] = $this->Game_model->edit_company_game($Comp_Game_ID);

				if($livesFlag == 1)
				{
					$member_lives = $this->Game_model->get_member_all_lives($Company_id,$Comp_Game_ID,$enrollID);
				}

				$data["member_total_lives"] = $member_lives;

				$this->load->view('Game/purchase_lives', $data);
			}
			else
			{
				$gm_result = $this->Game_model->play_game($Company_id,$game_type,$Comp_Game_ID,$enrollID);

				$data["gm_result"] = $gm_result;

				if($gm_result == NULL)
				{
					$this->session->set_flashdata("select_game","Sorry, Game is not working!.");

					$this->load->view('Game/games_list', $data);
				}
				else
				{
					if($gm_result['Game_id'] == 1)
					{
						$this->load->view('Game/tetris', $data);
					}

					if($gm_result['Game_id'] == 2)
					{
						$this->load->view('Game/memory_game', $data);
					}

					if($gm_result['Game_id'] == 3)
					{
						$this->load->view('Game/snap_puzzle', $data);
					}
				}

			}

		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	public function InsertPurchaseLives()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$enrollID = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$Company_balance	= $data["Company_details"]->Current_bal;

			if($_POST != NULL)
			{
				$gm_opt = $this->Game_model->Purchase_lives($Company_id,$Company_balance);

				$member_lives = $this->Game_model->get_member_all_lives($Company_id,$Comp_Game_ID,$enrollID);
				$data["member_total_lives"] = $member_lives;

				if($gm_opt == true)
				{
					$this->session->set_flashdata("select_game21","Congrats! Your Purchase Game Lives is Updated Successfully!");

				}
				else
				{
					$this->session->set_flashdata("select_game21","Sorry, You can not Purchase the Game Lives.");
				}

				$this->load->view('Game/purchase_lives', $data);

			}
			else
			{

				$gm_result = $this->Game_model->play_game($Company_id,$game_type,$Comp_Game_ID,$enrollID);

				$data["gm_result"] = $gm_result;

				if($gm_result == NULL)
				{
					$this->session->set_flashdata("select_game","Sorry, Game is not working!.");

					$this->load->view('Game/games_list', $data);
				}
				else
				{
					if($gm_result['Game_id'] == 1)
					{
						$this->load->view('Game/tetris', $data);
					}

					if($gm_result['Game_id'] == 2)
					{
						$this->load->view('Game/memory_game', $data);
					}

					if($gm_result['Game_id'] == 3)
					{
						$this->load->view('Game/snap_puzzle', $data);
					}
				}

			}

		}
		else
		{
			redirect('login', 'refresh');
		}
	}

	//*************** sandeep work end ************************************/

	function update_hobbies()
	{

		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			if($_POST)
			{
				$Company_id =  $this->input->post("Company_id");
				$Enrollment_id = $this->input->post("Enrollment_id");
				$new_hobbies = $this->input->post("new_hobbies");
				$result = $this->Igain_model->delete_hobbies($Company_id,$Enrollment_id);
				foreach($new_hobbies as $hobbis)
				{

					$result12 = $this->Igain_model->insert_hobbies($Company_id,$Enrollment_id,$hobbis);
				}
				if($result12 == true)
				{
				/*********************Nilesh igain Log Table change 27-06-207*************************/
					$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
					$opration = 2;
					$userid = $Enroll_details->User_id;
					$what="Update Hobbies";
					$where="My Profile";
					$opval ='Update Hobbies';
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details->First_name;
					$lastName = $Enroll_details->Last_name;
					$User_email_id = $Enroll_details->User_email_id;
					$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table change 27-06-2017 *************************/
					$this->session->set_flashdata("error_code","Hobbies Upadated Successfully!!");
					die;
				}
				else
				{
					$this->session->set_flashdata("error_code","Hobbies Upadated Un-successfully !!");
				}
				redirect(current_url());
			}
			else
			{
				// $this->load->view('mailbox/mailbox',$data);
			}
		}
		else
		{

			redirect('login', 'refresh');
		}

	}
	function merchant_gained_loyalty_points()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$Company_id =  $this->input->post("comp_id");
			$Enrollment_id = $this->input->post("enrollId");
			$data["MerchantGainedPoints"] = $this->Igain_model->Fetch_seller_gained_points($Company_id,$Enrollment_id);

			$theHTMLResponse = $this->load->view('home/merchant_gained_points_details', $data, true);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('transactionDetailHtml'=> $theHTMLResponse)));

		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	//*************** sandeep work end ************************************/
	function termsandconditions()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['Company_id']= $session_data['Company_id'];


			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			$data['Country_array']= $this->Igain_model->FetchCountry();
			$CompanyId= $session_data['Company_id'];
			$Enroll_details=$data['Enroll_details'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$Company_balance	= $data["Company_details"]->Current_bal;


			$this->load->view('home/termsandconditions',$data);

		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	function online_booking_appointment()
	{
		$Loyaltymembers=$this->input->post('Loyalty_members');

		if($this->input->post('Company_id') != "" && $this->input->post('customer_name') != "" && $this->input->post('appointment_date') != "" && $this->input->post('phone_no') != "" )
		{
			$membership_id= $this->input->post('membership_id');
			$post_data['Seller_id']=$this->input->post('Seller_id');
			$post_data['Car_brand']=$this->input->post('Car_brand');
			$Company_id=$this->input->post('Company_id');

			if($membership_id != "")
			{
				$Enroll_details = $this->Igain_model->get_customer_details($membership_id,$Company_id);

			}
			$Create_user_id=$Enroll_details->Enrollement_id;
			$Membership_id=$Enroll_details->Card_id;
			$Phone_no=$Enroll_details->Phone_no;
			$Email_id=$Enroll_details->User_email_id;
			// echo"-------Email_id-----".$Email_id."<br>";
			if($Email_id =="")
			{
				$post_data['Email_id']=$this->input->post('email');

			}
			else
			{
				$post_data['Email_id']=$Email_id;
			}
			if($Phone_no !="")
			{
				$post_data['Phone_no']=$Phone_no;
			}
			else
			{
				$post_data['Phone_no']=$this->input->post('phone_no');
			}
			if($Enroll_details->First_name !="")
			{
				$post_data['Customer_name']=$Enroll_details->First_name.' '.$Enroll_details->Last_name;
			}
			else
			{
				$post_data['Customer_name']=$this->input->post('customer_name');
			}
			if($Create_user_id != "")
			{
				$post_data['Create_user_id']=$Create_user_id;
			}
			else
			{
				$post_data['Create_user_id']="0";
			}
			if($Membership_id != "")
			{
				$post_data['Membership_id']=$Membership_id;
			}
			else
			{
				$post_data['Membership_id']="";
			}

			$post_data['Vehicle_no']=$this->input->post('vehicle_no');
			$post_data['Appointment_date']=date('Y-m-d',strtotime($this->input->post('appointment_date')));
			$post_data['Status']='Pending';
			$post_data['Create_date']=date('Y-m-d H:i:s',strtotime($this->input->post('appointment_date')));

			$insert_online_booking = $this->Igain_model->insert_online_booking_appointment($post_data);
			// var_dump($insert_online_booking);
			if($insert_online_booking > 0)
			{

				$Email_content=array(
				'Notification_type' =>'Online Booking Appointment',
				'Customer_name' =>$post_data['Customer_name'],
				'Vehicle_number' =>$post_data['Vehicle_no'],
				'Date_Appointment' =>$post_data['Create_date'],
				'Contact_number' =>$post_data['Phone_no'],
				'Email_Id' =>$post_data['Email_id'],
				'Membership_id' =>$post_data['Membership_id'],
				'Template_type' => 'Online_booking'
				);
				$this->send_notification->send_Notification_email($post_data['Create_user_id'],$Email_content,$post_data['Seller_id'],$Company_id);

				/*********************Nilesh igain Log Table change 29-06-207*************************/
					$Enrollment_id=$Enroll_details->Enrollement_id;
					$opration = 1;
					$userid = $Enroll_details->User_id;
					$what="online booking appointment";
					$where="Customer Website";
					$opval = $insert_online_booking;
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details->First_name;
					$lastName = $Enroll_details->Last_name;
					$User_email_id = $Enroll_details->User_email_id;
					$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 29-06-2017 *************************/

				$this->session->set_flashdata("login_success","Appointment booked successfully!!");
			}
			else
			{
				$this->session->set_flashdata("login_success","Appointment booked Un-successfully");
			}
			redirect('login', 'refresh');
			$this->load->view('login/login', $data);

		}
		else
		{
			$this->session->set_flashdata("login_success","Please fill required field!!");
			redirect('login', 'refresh');
			$this->load->view('login/login', $data);
		}

	}
	function search_enrollement()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Country_id'] = $session_data['Country_id'];

		$result = $this->Igain_model->search_enrollement($this->input->post("search_data"),$this->input->post("Company_id"),$this->input->post("Country_id"));
		// $data["results"]=$result;
		// var_dump($data["results"]);
		$this->output->set_output($result);
		// $this->load->view('enrollment/Search_enrollement_records', $data);
	}
	function bookappointment()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['Company_id']= $session_data['Company_id'];
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);

			$data["FetchSellerdetails"] = $this->Igain_model->FetchSellerdetails($data['Company_id']);
			$this->load->view('home/book_appointment',$data);
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	public function insert_booking_appointment()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$data['Company_id']);
			$Customer_name=$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
			$Company_id=$Enroll_details12->Company_id;
			if($_POST == NULL)
			{
				$this->load->view('home/book_appointment', $data);
			}
			else
			{
				$post_data['Vehicle_no']=$this->input->post('vehicle_no');
				$post_data['Appointment_date']=date('Y-m-d',strtotime($this->input->post('appointment_date')));
				$post_data['Status']='Pending';
				$post_data['Create_date']=date('Y-m-d H:i:s');
				$post_data['Create_user_id']=$data['enroll'];
				$post_data['Seller_id']=$this->input->post('Seller_id');
				$post_data['Car_brand']=$this->input->post('Car_brand');
				$post_data['Membership_id']=$this->input->post('membership_id');
				$post_data['Phone_no']=$this->input->post('phone_no');
				$post_data['Email_id']=$this->input->post('email');
				$post_data['Customer_name']=$Customer_name;
				$insert_online_booking = $this->Igain_model->insert_online_booking_appointment($post_data);
				if($insert_online_booking > 0)
				{

					$Email_content=array(
					'Notification_type' =>'Online Booking Appointment',
					'Customer_name' =>$post_data['Customer_name'],
					'Vehicle_number' =>$post_data['Vehicle_no'],
					'Date_Appointment' =>$post_data['Create_date'],
					'Contact_number' =>$post_data['Phone_no'],
					'Email_Id' =>$post_data['Email_id'],
					'Membership_id' =>$post_data['Membership_id'],
					'Template_type' => 'Online_booking'
					);
					$this->send_notification->send_Notification_email($post_data['Create_user_id'],$Email_content,$post_data['Seller_id'],$Company_id);

					/*********************Nilesh igain Log Table change 29-06-207*************************/
					$Enrollment_id=$Enroll_details12->Enrollement_id;
					$opration = 1;
					$userid = $Enroll_details12->User_id;
					$what="online booking appointment";
					$where="Customer Website";
					$opval = $insert_online_booking;
					$Todays_date=date("Y-m-d");
					$firstName = $Enroll_details12->First_name;
					$lastName = $Enroll_details12->Last_name;
					$User_email_id = $Enroll_details12->User_email_id;
					$LogginUserName = $Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 29-06-2017 *************************/

					$this->session->set_flashdata("booking_success","Appointment booked successfully!!");
				}
				else
				{
					$this->session->set_flashdata("booking_success","Appointment booked Un-successfully");
				}
				redirect('Cust_home/bookappointment', 'refresh');

			}


		}
		else
		{
			redirect('login', 'refresh');
		}

	}
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
	/********************************Ravi 12-04-2018 *************************************/
	public function first_time_login()
	{
		// $this->output->enable_profiler(TRUE);
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id= $session_data['Company_id'];
			// $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);

			$Company_details = $this->Igain_model->get_company_details($Company_id);
			$Company_details->Partner_company_flag;
			$Parent_company=$Company_details->Parent_company;
			$Company_partner_cmp = $this->Igain_model->Fetch_Company_Details($Parent_company);
			foreach($Company_partner_cmp as $partner)
			{
				$partner_Company_name=$partner['Company_name'];
				$partner_Company_Website=$partner['Website'];
			}
			$data['partner_Company_name']= $partner_Company_name;
			$data['partner_Company_Website']= $partner_Company_Website;

			$Company_id=$Enroll_details->Company_id;
			$Enrollment_id=$Enroll_details->Enrollement_id;
			$User_pwd=$Enroll_details->User_pwd;

			// echo"<pre>";
			$myData = array('Company_id'=>$Company_id,'Enroll_id'=>$Enrollment_id,'old_Password'=>$User_pwd);
			// print_r($myData);
			$data['Login_data'] = base64_encode(json_encode($myData));
			// print_r($Login_data);

			if($_POST == NULL)
			{
				$this->load->view('home/first_time_login', $data);
			}
			else
			{

				$Login_data = json_decode(base64_decode($this->input->post('Login_data')));
				$Survey_data_1 = get_object_vars($Login_data);
				$Company_id = $Survey_data_1['Company_id'];
				$Enrollment_id = $Survey_data_1['Enroll_id'];
				$old_Password = $Survey_data_1['old_Password'];
				$New_Password=$this->input->post('New_Password');
				$Confirm_New_Password=$this->input->post('Confirm_New_Password');

				/* echo"--Company_id--".$Company_id."---<br>";
				echo"--Enrollment_id--".$Enrollment_id."---<br>";
				echo"--old_Password--".$old_Password."---<br>";
				echo"--New_Password--".$New_Password."---<br>";
				echo"--Confirm_New_Password--".$Confirm_New_Password."---<br>";
				die; */

				if($old_Password==$New_Password)
				{
					$this->session->set_flashdata("invalid_error_code","Old Password and New Password should not be same");
					redirect('Cust_home/first_time_login', 'refresh');
				}
				$result = $this->Igain_model->Change_Old_Password($old_Password,$Company_id,$Enrollment_id,$New_Password);
				if($result)
				{
					$SuperSeller=$this->Igain_model->get_super_seller_details($Company_id);
					$Seller_id=$SuperSeller->Enrollement_id;
					$Email_content = array(
						'New_password' => $New_Password,
						'Notification_type' => 'Password Change',
						'Template_type' => 'Change_password'
					);
					$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id);

					$result1  = array();
					$result1['pwd']='1';

					/*********************Nilesh igain Log Table change 27-06-207*************************/
						$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
						$timezone_entry=$Enroll_details->timezone_entry;
						$opration = 2;
						$userid = $Enroll_details->User_id;
						$what="Change Password";
						$where="First Time Change Login password";
						$opval = preg_replace("/[\S]/", "X", $New_Password);
						$Todays_date=date("Y-m-d");
						$firstName = $Enroll_details->First_name;
						$lastName = $Enroll_details->Last_name;
						$User_email_id = $Enroll_details->User_email_id;
						$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Enrollment_id,$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					/**********************igain Log Table change 27-06-2017 *************************/

						$logtimezone = $timezone_entry;
						$timezone = new DateTimeZone($logtimezone);
						$date = new DateTime();
						$date->setTimezone($timezone);
						$lv_date_time=$date->format('Y-m-d H:i:s');
						$Todays_date = $date->format('Y-m-d');

					/**********************Insert_into_session 04-04-2018 *************************/
						$Insert_into_session = $this->Login_model->insert_into_session($Company_id,$User_email_id,$Enrollment_id,$userid,2,$lv_date_time);
					/**********************Insert_into_session 04-04-2018*************************/

					$this->session->set_flashdata("invalid_error_code","Password has Changed Successfully");
					redirect('Cust_home/home', 'refresh');
				}
				else
				{
					$this->session->set_flashdata("invalid_error_code","Password has Changed Un-successfully");
					redirect('Cust_home/first_time_login', 'refresh');
				}
				// redirect('Cust_home/first_time_login', 'refresh');
			}
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	/********************************Ravi 12-04-2018 *************************************/

	/********************************Ravi 19-04-2018 Create Account from App*************************************/

	function Create_Account()
	{

		if($_POST == NULL)
		{
			$this->session->set_flashdata("login_success","");
			$this->load->view('login/register');
		}
		else
		{

			$first_name = $this->input->post('firstName');
			$last_name = $this->input->post('Last_name');
			$email = $this->input->post('userEmailId');
			$Company_id = $this->input->post('Company_id');
			// $Country = $this->input->post('Country');
			// $flag = $this->input->post('flag');
			$Phone_no = $this->input->post('Phone_no');
			// var_dump($_POST);
			// die;
			if($first_name !="" && $last_name !="" && $email !="" && $Company_id !="" )
			{
				$company_details = $this->Igain_model->get_company_details($Company_id);
				$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
				$Dial_Code = $this->Igain_model->get_dial_code($Super_Seller_details->Country);
				$dialcode=$Dial_Code->phonecode;
				$phoneNo=$dialcode.''.$Phone_no;
				$timezone_entry=$Super_Seller_details->timezone_entry;

				$logtimezone = $timezone_entry;
				$timezone = new DateTimeZone($logtimezone);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$lv_date_time=$date->format('Y-m-d H:i:s');
				$Todays_date = $date->format('Y-m-d');

				$Check_EmailID=$this->Igain_model->Check_EmailID($email,$Company_id);
				if($Check_EmailID == 0)
				{
					$CheckPhone_number=$this->Igain_model->CheckPhone_number($phoneNo,$Company_id);
					if($CheckPhone_number ==0)
					{

						$card_decsion=$company_details->card_decsion;
						$Joining_bonus=$company_details->Joining_bonus;
						$Joining_bonus_points=$company_details->Joining_bonus_points;
						if($card_decsion==1)
						{
							 $Card_id=$company_details->next_card_no;
							// $nestcard1=$Card_id+1;

							$nestcard1=$company_details->next_card_no;
							$nestcard1++;

							if($Joining_bonus==1)
							{
								$Current_balance=$company_details->Joining_bonus_points;
								$Total_topup_amt=$company_details->Joining_bonus_points;
							}
							else
							{
								$Current_balance=0;
								$Total_topup_amt=0;
							}
						}
						else
						{
							$Card_id=0;
							$Current_balance=0;
							$Total_topup_amt=0;
						}
							$pin=$this->Igain_model->getRandomString(4);
							$post_enroll = array(
								'First_name' => $first_name,
								'Last_name' => $last_name,
								'Phone_no' => $phoneNo,
								'Country' => $Super_Seller_details->Country,
								'timezone_entry' => $timezone_entry,
								'Country_id' => $Super_Seller_details->Country,
								'User_email_id' => $email,
								'User_pwd' => $Phone_no,
								'pinno' => $pin,
								'User_activated' => 1,
								'Company_id' => $Company_id,
								'Current_balance' => $Current_balance,
								'Total_topup_amt' => $Total_topup_amt,
								'User_id' => 1,
								'Card_id' => $Card_id,
								'joined_date' => $Todays_date,
								'source' =>'Website'
							);

							$seller_id=$Super_Seller_details->Enrollement_id;
							$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
							$seller_curbal = $Super_Seller_details->Current_balance;
							$top_db2 = $Super_Seller_details->Topup_Bill_no;
							$len2 = strlen($top_db2);
							$str2 = substr($top_db2,0,5);
							$tp_bill2 = substr($top_db2,5,$len2);
							$topup_BillNo2 = $tp_bill2 + 1;
							$billno_withyear_ref = $str2.$topup_BillNo2;

							$Insert_enrollment=$this->Igain_model->insert_enroll_details($post_enroll);
							$Last_enroll_id=$Insert_enrollment;

						/*********************Nilesh igain Log Table change 29-06-207*************************/
							// $Enroll_details = $this->Igain_model->get_enrollment_details($Last_enroll_id);
							$opration = 1;
							$User_id = 1;
							$what="New Member Sign Up From App";
							$where="New Member Sign Up From App";
							$opval = $first_name.' '.$last_name;
							$Todays_date=date("Y-m-d");
							$firstName = $first_name;
							$lastName = $last_name;
							$LogginUserName = $first_name.' '.$last_name;
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Last_enroll_id,$email,$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
						/**********************igain Log Table change 29-06-2017 *************************/

							if($Last_enroll_id > 0)
							{
								if($card_decsion==1)
								{
									$update_card_series=$this->Igain_model->UpdateCompanyMembershipID($nestcard1,$Company_id);
									if($Joining_bonus==1)
									{
										// $Todays_date = date("Y-m-d");
										$post_Transdata =
											array
												(
													'Trans_type' => '1',
													'Company_id' => $Company_id,
													'Topup_amount' => $Joining_bonus_points,
													'Trans_date' => $lv_date_time,
													'Remarks' => 'Joining Bonus',
													'Card_id' => $Card_id,
													'Seller_name' =>$Seller_name ,
													'Seller' => $seller_id,
													'Enrollement_id' => $Last_enroll_id,
													'Bill_no' => $tp_bill2,
													'remark2' => 'Super Seller',
													'Loyalty_pts' => '0'
												);

										$result6 = $this->Igain_model->insert_topup_details($post_Transdata);
										$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
										$result3 = $this->Igain_model->update_seller_balance($Last_enroll_id,$Current_balance);
										if($company_details->Seller_topup_access=='1')
										{
											$Total_seller_bal = $seller_curbal-$Joining_bonus_points;
											$result3 = $this->Igain_model->update_seller_balance($seller_id,$Total_seller_bal);
										}
										$Email_content12 = array(
											'Joining_bonus_points' => $Joining_bonus_points,
											'Notification_type' => 'Joining Bonus',
											'Template_type' => 'Joining_Bonus',
											'Todays_date' => $Todays_date
										);
										$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$seller_id,$Company_id);
									}

									/***************Send Freebies Merchandize items************/
									$Merchandize_Items_Records = $this->Igain_model->Get_Merchandize_Items('', '',$Company_id,1);
									if($Merchandize_Items_Records != NULL  && $Card_id != "")
									{
										// $this->load->model('Redemption_catalogue/Redemption_Model');
										foreach($Merchandize_Items_Records as $Item_details)
										{
											/******************Changed AMIT 16-06-2016*************/
											// $this->load->model('Catalogue/Catelogue_model');
											$Get_Partner_Branches = $this->Igain_model->Get_Partner_Branches($Item_details->Partner_id,$Company_id);
											foreach($Get_Partner_Branches as $Branch)
											{
												$Branch_code=$Branch->Branch_code;
											}
											/********************************/

											/********************************/
											$characters = 'A123B56C89';
											$string = '';
											$Voucher_no="";
											for ($i = 0; $i < 16; $i++)
											{
												$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
											}
											$Voucher_status="Issued";

											if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
											{
												$insert_data = array(
												'Company_id' => $Company_id,
												'Trans_type' => 10,
												'Redeem_points' => $Item_details->Billing_price_in_points,
												'Quantity' => 1,
												'Trans_date' => $lv_date_time,
												'Create_user_id' => $seller_id,
												'Seller' => $seller_id,
												'Seller_name' => $Seller_name,
												'Enrollement_id' => $Last_enroll_id,
												'Bill_no' => $tp_bill2,
												'Card_id' => $Card_id,
												'Item_code' => $Item_details->Company_merchandize_item_code,
												'Voucher_no' => $Voucher_no,
												'Voucher_status' => $Voucher_status,
												'Merchandize_Partner_id' => $Item_details->Partner_id,
												'Remarks' => 'Freebies',
												'Merchandize_Partner_branch' => $Branch_code
													);
												 $Insert = $this->Igain_model->Insert_Redeem_Items_at_Transaction($insert_data);
												 $result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);

												  $Voucher_array[]=$Voucher_no;

												  /**********Send freebies notification********/
													$Email_content124 = array(
																	'Merchandize_item_name' => $Item_details->Merchandize_item_name,
																	'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
																	'Item_image' => $Item_details->Item_image1,
																	'Voucher_no' => $Voucher_no,
																	'Voucher_status' => $Voucher_status,
																	'Notification_type' => 'Freebies',
																	'Template_type' => 'Enroll_Freebies',
																	'Customer_name' => $first_name.' '.$last_name,
																	'Todays_date' => $Todays_date
															);

												$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content124,$seller_id,$Company_id);
											}

										}

									}
									/*********************Merchandize end*************************/
								}

								$Email_content = array(
								'Notification_type' => 'Enrollment Details',
								'Template_type' => 'Enroll'
								);
								$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$seller_id,$Company_id);
								$this->session->set_flashdata("login_success","Registration Successful...Login credentials sent on your registered Email Id !!");

							}
							else
							{
								$this->session->set_flashdata("login_success","Some thing went wrong!!");
							}
					}
					else
					{
						$this->session->set_flashdata("login_success","Provided Mobile No is already Exist!!");
					}
				}
				else
				{
					$this->session->set_flashdata("login_success","Provided Email ID is already Exist!!");

				}
				// redirect('login', 'refresh');
				$this->load->view('login/register');
			}
			else
			{
				$this->session->set_flashdata("login_success","Please provide valid data !!");
				$this->load->view('login/register');

			}
		}

	}
	/********************************Ravi 19-04-2018 Create Account from App*************************************/
	/********************************Ravi 08-05-2018 evoucher fullfillment from email*************************************/

	function Update_eVoucher_Status()
	{
		/* $Offer_link = json_decode(base64_decode($_REQUEST['Offer_link']));
		$Offer_data = get_object_vars($Offer_link);
		$Trans_id = $Offer_data['Trans_id'];
		$Company_id = $Offer_data['Company_id'];
		$Enroll_id = $Offer_data['Enroll_id'];
		$Card_id = $Offer_data['Card_id'];
		$evoucher = $Offer_data['evoucher'];
		$Branch_name = $Offer_data['Branch_name'];
		$Merchandize_item_name = $Offer_data['Merchandize_item_name'];
		$Branch_Address = $Offer_data['Branch_Address'];
		$customer_pin = $_REQUEST['customer_pin'];	 */


		// $data['Offer_link'] = json_decode(base64_decode($_REQUEST['Offer_data']));


		$Offer_link = json_decode(base64_decode($_REQUEST['Offer_data']));
		$Offer_data = get_object_vars($Offer_link);

		$Offer_data = get_object_vars($Offer_link);
		$Trans_id = $Offer_data['Trans_id'];
		$Company_id = $Offer_data['Company_id'];
		$Enroll_id = $Offer_data['Enroll_id'];
		$Card_id = $Offer_data['Card_id'];
		$evoucher = $Offer_data['evoucher'];
		$Branch_name = $Offer_data['Branch_name'];
		$Merchandize_item_name = $Offer_data['Merchandize_item_name'];
		$Branch_Address = $Offer_data['Branch_Address'];


		$myData = array('Trans_id'=>$Trans_id, 'Company_id'=>$Company_id,'Enroll_id'=>$Enroll_id,'Card_id'=>$Card_id,'evoucher'=>$evoucher,'Merchandize_item_name'=>$Merchandize_item_name,'Branch_name'=>$Branch_name,'Branch_Address'=>$Branch_Address);
		$Offer_link = base64_encode(json_encode($myData));
		// var_dump($Offer_link);
		$data['Offer_link'] = $Offer_link;
		$data['evoucherNo'] = $evoucher;
		$data['item_name'] = $Merchandize_item_name;

		// echo"----evoucher---".$data['evoucherNo ']."---<br>";
		// echo"----Merchandize_item_name---".$data['item_name']."---<br>";


		$result  = array();


		if($_POST == NULL)
		{
			$this->load->view('home/change_evoucher_status', $data);
		}
		else
		{

			$Offer_link1 = json_decode(base64_decode($this->input->post('Offer_link')));
			$Offer_data_post = get_object_vars($Offer_link1);
			$Trans_id = $Offer_data_post['Trans_id'];
			$Company_id = $Offer_data_post['Company_id'];
			$Enroll_id = $Offer_data_post['Enroll_id'];
			$Card_id = $Offer_data_post['Card_id'];
			$evoucher = $Offer_data_post['evoucher'];
			$Branch_name = $Offer_data_post['Branch_name'];
			$Merchandize_item_name = $Offer_data_post['Merchandize_item_name'];
			$Branch_Address = $Offer_data_post['Branch_Address'];

			$customer_pin =  $this->input->post('customer_pin');
			// var_dump($_POST);
			/* echo"---Trans_id---".$Trans_id."----<br>";
			echo"---Company_id---".$Company_id."----<br>";
			echo"---Enroll_id---".$Enroll_id."----<br>";
			echo"---Card_id---".$Card_id."----<br>";
			echo"---evoucher---".$evoucher."----<br>";
			echo"---Branch_name---".$Branch_name."----<br>";
			echo"---Merchandize_item_name---".$Merchandize_item_name."----<br>";
			echo"---Branch_Address---".$Branch_Address."----<br>"; */
			// die; */
			$Trans_date=date('Y-m-d');
			if($customer_pin != NULL || $Trans_id != NULL || $Company_id != NULL || $Enroll_id != NULL || $Card_id != NULL || $evoucher != NULL || $Branch_name != NULL || $Merchandize_item_name != NULL || $Branch_Address != NULL )
			{

				$result_pin = $this->Igain_model->Check_Old_Pin($customer_pin,$Company_id,$Enroll_id);
				if($result_pin > 0 )
				{

					// echo"---result_pin---".$result_pin."----<br>";

					$Check_eVoucher_Status = $this->Igain_model->Check_eVoucher_Status($Card_id,$Company_id,$evoucher,$Enroll_id,31);
					if($Check_eVoucher_Status > 0 )
					{
						// echo"---Check_eVoucher_Status---".$Check_eVoucher_Status."----<br>";
						$result_update = $this->Igain_model->Update_eVoucher_Status($Card_id,$Company_id,$evoucher,$Enroll_id,31);

						$Email_content = array(
							// 'Contents' => $html,
							// 'subject' => $subject,
							'Trans_date' => $Trans_date,
							'Merchandize_item_name' => $Merchandize_item_name,
							'evoucher' => $evoucher,
							'Points' => 0,
							'Total_points' =>0,
							'Branch_name' => $Branch_name,
							'Branch_Address' => $Branch_Address,
							'Notification_type' => 'Redemption Fulfillment',
							'Template_type' => 'Redemption_Fulfillment'
						);
						$Notification=$this->send_notification->send_Notification_email($Enroll_id,$Email_content,'1',$Company_id);

						$result  = array();
						// $result['res']='Redemption Fulfillment Successful'; // Redemption Fulfillment Successful
						$this->session->set_flashdata("eVoucher_Status","Redemption Fulfillment Successful!!");
						redirect('Cust_home/Update_eVoucher_Status', 'refresh');
					}
					else
					{
						$result  = array();
						// $result['res']='e-Voucher Already Used'; // e-Voucher Already Used
						$this->session->set_flashdata("eVoucher_Status","e-Voucher Already Used!!");
						redirect('Cust_home/Update_eVoucher_Status', 'refresh');
					}
				}
				else
				{
					$result  = array();
					// $result['res']='Invalid Pin Provided'; // Invalid Pin Provided
					$this->session->set_flashdata("eVoucher_Status","Invalid Pin provided!!");
					redirect('Cust_home/Update_eVoucher_Status', 'refresh');

				}
			}
			else
			{
				$result  = array();
				// $result['res']='Invalid Data provided'; //Invalid Data provided
				$this->session->set_flashdata("eVoucher_Status","Invalid Data provided!!");
				redirect('Cust_home/Update_eVoucher_Status', 'refresh');
			}
			// echo json_encode($result);
			// die;

		}
	}
	/********************************Ravi 08-05-2018 evoucher fullfillment from email*************************************/
	/********************************Ravi 15-03-2019 emcryption*************************************/
	function string_decrypt($encrypted_string, $key, $iv)
	{						
		/* 	echo "-------string_decrypt--------------<br>";
		echo "-------encrypted_string----".$encrypted_string."---------------<br>";
		echo "-------key----".$key."---------------<br>";
		echo "-------iv----".$iv."---------------<br>"; */

			$version = phpversion();
		// echo "-------version----".$version."---------------<br>";
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


				// echo "--Output-data--".$data."------<br><br>";

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
	function string_encrypt($string, $key, $iv)
	{
		$version = phpversion();
			//echo "-------version----".$version."---------------<br>";
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
	/********************************Ravi 15-03-2019 emcryption*************************************/
	/********************Nilesh 05-11-2019*************************/
	function Get_outlet_details()
	{
		$Enrollment_id = $_REQUEST['Outlet_id'];
		$Enroll_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
		
		$Outlet_details = array(
								"Error_flag" => 1001,
								"Outlet_name" => $Enroll_details->First_name.' '.$Enroll_details->Last_name,
								"Outlet_address" => App_string_decrypt($Enroll_details->Current_address),
								"Table_no_flag" => $Enroll_details->Table_no_flag
							);
						
		echo json_encode($Outlet_details);
	}
	/********************Nilesh 05-11-2019*************************/
	/********************Nilesh 19-11-2019*************************/
	function Change_communication_flag()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
				
			$New_falg = $_REQUEST['falg'];
			
			$post_data1 = array(
						'Communication_flag' => $New_falg
						);
				
			$result = $this->Igain_model->update_profile($post_data1,$data['enroll']);
			if($result == true)
			{
				$Update_status = array(
									"Error_flag" => 1001
								);
							
				echo json_encode($Update_status); //Successfull
			}
			else
			{
				$Update_status = array(
									"Error_flag" => 2068
								);
							
				echo json_encode($Update_status); //Usuccessfull
			}
		}
		else
		{
			redirect('login', 'refresh');
		}
	}
	/********************Nilesh 19-11-2019*************************/
}
?>