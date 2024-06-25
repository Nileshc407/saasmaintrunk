<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR |E_PARSE|E_CORE_ERROR);
 
class Home extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();	
		$this->load->database();
		
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model("login/Home_model");
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Send_notification');
		$this->load->model('master/currency_model');
	}
	function index()
	{
		// var_dump($this->session->userdata('logged_in'));
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];
			$data['Country_id'] = $session_data['Country_id'];
			$CompanyID = $session_data['Company_id'];
			/*--------------Live Chat----------------*/
			$data['Company_id'] = $CompanyID;
			/*--------------Live Chat----------------*/
			$data['Logged_user_id'] = $session_data['userId'];
			$data['test'] ='test';
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
			
			// $data["enrollment_details"]= $this->Igain_model->get_enrollment_details($data['enroll']);
			
			$data["Company_details"] = $this->Igain_model->get_company_details($CompanyID);
			
			
			$Company_details = $this->Igain_model->get_company_details($CompanyID);
			$Survey_analysis= $Company_details->Survey_analysis;
			$data['Survey_analysis']=$Survey_analysis;
			$data['Currency_name']=$Company_details->Currency_name;
			
			
			$currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
			$data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			
			/*********************************Nilesh Change for Quantity graph********************************/
			$Active_Vs_inactive_member_graph_flag= $Company_details->Active_Vs_inactive_member_graph_flag;
			$Member_enrollments_graph_flag= $Company_details->Member_enrollments_graph_flag;
			$Total_point_issued_Vs_total_points_redeemed_graph_flag= $Company_details->Total_point_issued_Vs_total_points_redeemed_graph_flag;
			$No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag= $Company_details->No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag;
			$Total_quantity_issued_Vs_total_quantity_used_graph_flag= $Company_details->Total_quantity_issued_Vs_total_quantity_used_graph_flag;
			$Member_suggestions_flag= $Company_details->Member_suggestions_flag;
			$Worry_member_flag= $Company_details->Worry_member_flag;
			$Happy_member_flag= $Company_details->Happy_member_flag;
			$Partner_qnty_issued_Vs_partner_qnty_used_graph_flag= $Company_details->Partner_qnty_issued_Vs_partner_qnty_used_graph_flag;
			$Transaction_Order_Types_graph_flag= $Company_details->Transaction_Order_Types_graph_flag;
			$Gift_card_flag= $Company_details->Gift_card_flag;
			$Survey_analysis= $Company_details->Survey_analysis;
			
			$data['Active_Vs_inactive_member_graph_flag']=$Active_Vs_inactive_member_graph_flag;
			$data['Member_enrollments_graph_flag']=$Member_enrollments_graph_flag;
			$data['Total_point_issued_Vs_total_points_redeemed_graph_flag']=$Total_point_issued_Vs_total_points_redeemed_graph_flag;
			$data['No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag']=$No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag;
			$data['Total_quantity_issued_Vs_total_quantity_used_graph_flag']=$Total_quantity_issued_Vs_total_quantity_used_graph_flag;
			$data['Member_suggestions_flag']=$Member_suggestions_flag;
			$data['Happy_member_flag']=$Happy_member_flag;
			$data['Worry_member_flag']=$Worry_member_flag;
			$data['Partner_qnty_issued_Vs_partner_qnty_used_graph_flag']=$Partner_qnty_issued_Vs_partner_qnty_used_graph_flag;
			$data['Transaction_Order_Types_graph_flag']=$Transaction_Order_Types_graph_flag;
			$data['Gift_card_flag']=$Gift_card_flag;
			$data['Survey_analysis']=$Survey_analysis;
			$data['Enable_company_meal_flag']=$Company_details->Enable_company_meal_flag;
			$data['Daily_points_consumption_flag']=$Company_details->Daily_points_consumption_flag;
			
			/*********************************Nilesh Change for Quantity graph*****************************/

			$opt = $this->Home_model->dashbord($CompanyID);
		
	/*----------------------------------tOTAL TRANS RECORDS------------------------------*/			 
			$get_records = $this->Home_model->get_company_summary_transactions($CompanyID);
			
			if($get_records != NULL)
			{	
				foreach($get_records as $row12)
				{
					$data['Total_Used'] = $row12->Total_Used;
					$data['Total_Gained_Points'] = $row12->Total_Gained_Points;
					$data['Total_Purchase_Amount'] = $row12->Total_Purchase_Amount;
					$data['Total_Bonus_Points'] = $row12->Total_Bonus_Points;
					$data['Total_Paid_amount'] = $row12->Total_Paid_amount;
					
				}
						
			}
			else
			{
				$data['Total_Used'] = 0;
				$data['Total_Gained_Points'] = 0;
				$data['Total_Purchase_Amount'] = 0;
				$data['Total_Bonus_Points'] = 0;
				$data['Total_Paid_amount'] = 0;
			}
	/*----------------------------------tOTAL TRANS cancel RECORDS------------------------------*/			 
			$get_records2 = $this->Home_model->get_company_summary_cancel_transactions($CompanyID);
			
			if($get_records2 != NULL)
			{	
				foreach($get_records2 as $row12)
				{
					$data['Total_Credited_Redeem_points'] = $row12->Total_Credited_Redeem_points;
					$data['Total_Debited_Points'] = $row12->Total_Debited_Points;
					$data['Total_Cancellation_Amount'] = $row12->Total_Cancellation_Amount;
					
				}
						
			}
			else
			{
				$data['Total_Credited_Redeem_points'] = 0;
				$data['Total_Debited_Points'] = 0;
				$data['Total_Cancellation_Amount'] = 0;
			}
	/*----------------------------------Active Vs Inactive Graph------------------------------*/			 
			$member_status = $this->Home_model->member_status_graph_detail($CompanyID);
			
			if($member_status != 0)
			{	
				foreach($member_status as $row12)
				{
					$data['Total_members'] = $row12->Total_members;
					$data['Total_inactive_members'] = $row12->Total_inactive_members;
					$data['Total_active_members'] = $row12->Total_active_members;
					
					$data['Active_percentage'] = ($row12->Total_active_members/$row12->Total_members)*100;
					$data['InActive_percentage'] = ($row12->Total_inactive_members/$row12->Total_members)*100;
				}
						
			}
			else
			{
				$data['Total_members'] = 0;
				$data['Total_inactive_members'] = 0;
				$data['Total_active_members'] = 0;
				$data['Active_percentage'] = 0;
				$data['InActive_percentage'] = 0;
			}
	/*----------------------------------Active Vs Inactive Graph-----------------------------*/
		
	/*----------------------------------Monthly Enrollments Graph------------------------------*/			 
			$Enrollment_data = $this->Home_model->monthly_enrollment_graph_details($CompanyID);
			
			if($Enrollment_data != 0)
			{
				$data['Enrollment_data'] = json_encode($Enrollment_data);
			}
			else
			{
				$data['Enrollment_data'] = 0;
			}
			
	/*-----------------------------------Monthly Enrollments Graph-----------------------------*/
		
	/*----------------------------------points issed reddemed Graph------------------------------*/			 
			$Trans_data = $this->Home_model->monthly_points_graph_detail($CompanyID);
			
			if($Trans_data != 0)
			{
				$data['Trans_data'] = json_encode($Trans_data);
			}
			else
			{
				$data['Trans_data'] = 0;
			}
			// print_r($data['Trans_data']);
	/*----------------------------------points issed reddemed Graph-----------------------------*/
	

	/*----------------------------------Quantity issed & used count reddemed Graph-----------------------------*/
	/*--------------------------------AMIT Change-------------------------------------*/
	/*----------------------------------ITEMS ISSUED VS USED Graph------------------------------*/			 
			$Result_data = $this->Home_model->get_MERCHANDIZING_items_data($CompanyID);
			if($Result_data != 0)
			{
				$data['MERCHANDIZING_SNAPSHOT'] = json_encode($Result_data);
			}
			else
			{
				$data['MERCHANDIZING_SNAPSHOT'] = 0;
			}
	/*----------------------------------POPULAR MERCHANDIZING CATEGORY Graph-----------------------------*/
			/* $result_popular_category = $this->Home_model->get_popular_category($CompanyID);
			if($result_popular_category != 0)
			{
				$data['popular_category'] = json_encode($result_popular_category);
			}
			else
			{
				$data['popular_category'] = 0;
			} 
			
			$result_popular_category = $this->Home_model->Get_popular_menu_groups($CompanyID);
			if($result_popular_category != 0)
			{
				$data['popular_category'] = json_encode($result_popular_category);
			}
			else
			{
				$data['popular_category'] = 0;
			}
	
	/*----------------------------------SURVEY RESPONDENTS Graph------------------------------*/			 
			$data['SURVEY_RESPONDENTS'] = $this->Home_model->member_feedback($CompanyID);
			
	/*----------------------------------Survey Analysis Graph------------------------------*/	
			// echo"<br>----Survey_analysis--Controller--->".$Survey_analysis."<br>";
			$Survey_Analysis = $this->Home_model->Get_company_survey_analysis($CompanyID);
			 // print_r($Survey_Analysis);
			if($Survey_Analysis != 0)
			{		

				$i=1;
				foreach($Survey_Analysis as $survey_Ana)
				{
					
					$data['Survey_name_'.$i] = $survey_Ana["Survey_name"];
					$data['Total_promoters_'.$i] = $survey_Ana["Total_promoters"];
					$data['Total_passive_'.$i] = $survey_Ana["Total_passive"];
					$data['Total_dectractor_'.$i] = $survey_Ana["Total_dectractor"];
					$i++;
				}
			}
			else
			{
				$data['Survey_name_'.$i] = 0;
				$data['Total_promoters_'.$i] = 0;
				$data['Total_passive_'.$i] = 0;
				$data['Total_dectractor_'.$i] = 0;
			}
			
	/*----------------------------------Survey Analysis Graph-----------------------------*/
			
	/*----------------AMIT KAMBLE 03-1-2020------------------Transaction  Order Types  Graph--------*/	
			
			$purchase_count = $this->Home_model->Purchase_count_graph_detail($CompanyID);
			 // print_r($purchase_count);
			if($purchase_count != 0)
			{
				$data['purchase_count'] = json_encode($purchase_count);
			}
			else
			{
				$data['purchase_count'] = 0;
			}
			
	/*----------------AMIT KAMBLE 24-4-2020------------------POS&ONline  Graph--------*/	
			
			$POS_online_count = $this->Home_model->POS_online_distribution_graph_detail($CompanyID);
			 // print_r($purchase_count);
			if($POS_online_count != 0)
			{
				$data['POS_online_count'] = json_encode($POS_online_count);
			}
			else
			{
				$data['POS_online_count'] = 0;
			}
			
	/*----------------------------------XXXXXX-----------------------------*/
	
	/*----------------------------------Member Commens -----------------------------*/
		$data['customers_comment'] = $this->Home_model->get_customers_comment($CompanyID);

	/*----------------------------------Member Commens -----------------------------*/
		
		
			$data['happy_customers'] = $this->Home_model->get_happy_customers($CompanyID);
			$data['worry_customers'] = $this->Home_model->get_worry_customers($CompanyID);			
			
			$todays2 = date("M");	$todays1 = date("d");	$todays3 = date("Y");
			$Company_details = $this->Igain_model->get_company_details($CompanyID);
			
	/******************AMIT KAMBLE 13-7-2020 *********************/
		$data['Percentage_Issued_vouchers'] = $this->Home_model->Count_Percentage_issued_vouchers($CompanyID);	
		$data['Percentage_Used_vouchers'] = $this->Home_model->Count_Percentage_used_vouchers($CompanyID);	
		$data['Value_Issued_vouchers'] = $this->Home_model->Count_Value_issued_vouchers($CompanyID);	
		$data['Value_Used_vouchers'] = $this->Home_model->Count_Value_used_vouchers($CompanyID);	
		
		$data['Total_Value_Issued_vouchers'] = $this->Home_model->Total_Value_issued_vouchers($CompanyID);	
		$data['Total_Value_Used_vouchers'] = $this->Home_model->Total_Value_used_vouchers($CompanyID);	
		
		/****************GIFT CARD LIABLITY**********************************************************/
		$data['Count_issued_giftcard'] = $this->Home_model->Count_issued_giftcard($CompanyID);	
		$data['Count_used_giftcard'] = $this->Home_model->Count_used_giftcard($CompanyID);
		$data['Total_issued_giftcard'] = $this->Home_model->Total_issued_giftcard($CompanyID);
		$data['Total_used_giftcard'] = $this->Home_model->Total_used_giftcard($CompanyID);
		
		/****************Birthdays & Anniversaries**********************************************************/
		//-------------------------------------------------------------------------------------------------------
		$TodaysMD = date("m-d"); 
		$TodaysM = date("m"); 
		$Todays = date("Y-m-d"); 
		
		
		$Birthdays_Member_Name = array();
		$Birthdays_Member_Card_id = array();
		$Birthdays_Member_Phone_no = array();
		$Birthdays_Member_Card_idD = array();
		$Birthdays_Member_Card_idM = array();
		
		$Anniversaries_Member_Name = array();
		$Anniversaries_Member_Card_id = array();
		$Anniversaries_Member_Phone_no = array();
		$Anniversaries_Member_Card_idD = array();
		$Anniversaries_Member_Card_idM = array();
		
		
		$Birthdays_Anniversaries = $this->Home_model->Get_Birthdays_Anniversaries($CompanyID);	
		
		$Anniversaries_Count = array();
		$Anniversaries_CountM = array();
		if($Birthdays_Anniversaries != NULL)
		{
			foreach($Birthdays_Anniversaries as $Birthdays_Anniversaries)
			{
				if($Birthdays_Anniversaries->Wedding_annversary_date!='')
				{
					$Wedding_annversary_date = date("m-d", strtotime($Birthdays_Anniversaries->Wedding_annversary_date)); 
					$Wedding_annversary_Month = date("m", strtotime($Birthdays_Anniversaries->Wedding_annversary_date)); 
					if($Wedding_annversary_date == $TodaysMD)
					{
						$Anniversaries_Member_Card_idD[]=$Birthdays_Anniversaries->Card_id;
					}
					
					if($Wedding_annversary_Month == $TodaysM)
					{
						$Anniversaries_Member_Card_idM[]=$Birthdays_Anniversaries->Card_id;
					}
				}
				//------------------------------------------------------------------------
				if($Birthdays_Anniversaries->Date_of_birth!='')
				{
					$Date_of_birth = date("m-d", strtotime($Birthdays_Anniversaries->Date_of_birth)); 
					$Date_of_birthM = date("m", strtotime($Birthdays_Anniversaries->Date_of_birth)); 
					if($Date_of_birth == $TodaysMD)
					{
						$Birthdays_Member_Card_idD[]=$Birthdays_Anniversaries->Card_id;
					}
					
					if($Date_of_birthM == $TodaysM)
					{
						$Birthdays_Member_Card_idM[]=$Birthdays_Anniversaries->Card_id;
					}
				}
				
				
			}
		}
		
		$data['This_Month_Birthdays_Count'] = count($Birthdays_Member_Card_idM);
		$data['This_Month_Anniversaries_Count'] = count($Anniversaries_Member_Card_idM);
		$data['Todays_Anniversaries_Count'] = count($Anniversaries_Member_Card_idD);
		$data['Todays_Birthdays_Count'] = count($Birthdays_Member_Card_idD);
		
		
	/******************XXXX *********************/		
	
			$this->load->view('login/home', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('Login', 'refresh');
		}
	}
		public function Get_popular_category_items()
	{
		$Company_id=$this->input->post("Company_id");
		$Category=$this->input->post("Category");
		$Menu_group_month=$this->input->post("Menu_group_month");
		
		$result_popular_category_items = $this->Home_model->Get_popular_category_items($Category,$Company_id,$Menu_group_month);

		if($result_popular_category_items != 0)
		{
			
			$Popular_category_items = json_encode($result_popular_category_items);
		}
		else
		{
			$Popular_category_items = 0;
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Popular_category_items'=> $Popular_category_items)));
		/* 
		
		$theHTMLResponse = $this->load->view('administration/Get_items_for_discount', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Items_by_category'=> $theHTMLResponse))); */
	}
		public function get_menugroups_bargraph()
	{
		$Company_id=$this->input->post("Company_id");
		$month=$this->input->post("month");
		
			/*----------------------------------POPULAR MERCHANDIZING CATEGORY Graph-----------------------------*/
			$result_popular_category = $this->Home_model->get_popular_category($Company_id,$month);
			 if($result_popular_category != 0)
			{
				$popular_category = json_encode($result_popular_category);
			}
			else
			{
				$popular_category = 0;
			} 
			/* $data['result_popular_category'] = json_encode($result_popular_category);
		$theHTMLResponse = $this->load->view('login/get_popular_category', $data, true);	 */
	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('popular_category'=> $popular_category)));
	}
	function twelve_month_graph()
	{ 
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];
			$CompanyID = $session_data['Company_id'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($CompanyID);

			$graph_flag = $this->input->post('graph_flag');
			$data['graph_flag'] = $graph_flag;
			if($graph_flag == 1)
			{
				/*----------------------------------points issed reddemed Graph------------------------------*/			 
					$twelve_month_points = $this->Home_model->twelve_months_points_graph_detail($CompanyID);					
					if($twelve_month_points != 0)
					{						
						$prefix = '';
						$html = "[\n";
						foreach($twelve_month_points as $row12)
						{
							$html .= $prefix . " {\n";

							$html .= '  "category": "' . $row12->smry_month . '",' . "\n";
							$html .= '  "value1": "' . $row12->Total_loyalty_points . '",' . "\n";
							$html .= '  "value2": "' . $row12->Total_redeem_points . '"' . "\n";
							
							$html .= " }";
							$prefix = ",\n";
						}
						$html .= "\n]";
						$data['Chart_data'] = $html;				
					}
				/*----------------------------------points issed reddemed Graph-----------------------------*/
			}
			else if($graph_flag == 2)
			{
				/*----------------------------------points issed reddemed Graph------------------------------*/			 
					$twelve_month_count = $this->Home_model->twelve_months_points_graph_detail($CompanyID);
					if($twelve_month_count != 0)
					{						
						$prefix = '';
						$html = "[\n";
						foreach($twelve_month_count as $row13)
						{
							$html .= $prefix . " {\n";

							$html .= '  "category": "' . $row13->smry_month . '",' . "\n";
							$html .= '  "value1": "' . $row13->Total_loyalty_count . '",' . "\n";
							$html .= '  "value2": "' . $row13->Total_redeem_count . '",' . "\n";
							$html .= '  "value3": "' . $row13->Total_online_purchase_count . '"' . "\n";
							
							$html .= " }";
							$prefix = ",\n";
						}
						$html .= "\n]";
						$data['Chart_data'] = $html;				
					}
				/*----------------------------------points issed reddemed Graph-----------------------------*/
			}
			else if($graph_flag == 4)
			{
				/*----------------------------------Monthly Enrollments Graph------------------------------*/			 
					$twelve_monthly_enrollments12 = $this->Home_model->twelve_monthly_enrollment_graph_details($CompanyID);
					// $twelve_monthly_enrollments = array_reverse($twelve_monthly_enrollments12);					
					$twelve_monthly_enrollments = $twelve_monthly_enrollments12;					
					
					if($twelve_monthly_enrollments != 0)
					{						
						$prefix = '';
						$html = "[\n";
						foreach($twelve_monthly_enrollments as $row112)
						{
							$html .= $prefix . " {\n";

							$html .= '  "category": "' . $row112->smry_month . '",' . "\n";
							$html .= '  "value1": "' . $row112->Total_enrollments . '",' . "\n";
							
							$html .= " }";
							$prefix = ",\n";
						}
						$html .= "\n]";
						$data['Chart_data'] = $html;				
					}
				/*----------------------------------Monthly Enrollments Graph-----------------------------*/
			}
			/*************************************Nilesh Change for mccia*************************************/
			else if($graph_flag == 5)
			{ 	 
				/*----------------------------------Quantity issed  Graph------------------------------*/			 
					$twelve_month_count2 = $this->Home_model->twelve_months_quantity_graph_detail($CompanyID);
					if($twelve_month_count2 != 0)
					{						
						$prefix = '';
						$html = "[\n";
						foreach($twelve_month_count2 as $row131)
						{
							$html .= $prefix . " {\n";

							$html .= '  "category": "' . $row131->smry_month . '",' . "\n";
							$html .= '  "value1": "' . $row131->Total_issued_quantity . '",' . "\n";
							$html .= '  "value2": "' . $row131->Total_used_quantity . '"' . "\n";
							
							$html .= " }";
							$prefix = ",\n";
						}
						$html .= "\n]";
						$data['Chart_data'] = $html;				
					}
				/*----------------------------------Quantity issed  Graph-----------------------------*/
			}
			else if($graph_flag == 6)
			{
				/*----------------------------------partner Quantity issed & used Graph------------------------------*/			 
					$twelve_month_count3 = $this->Home_model->partner_quantity_graph_detail($CompanyID);					
					if($twelve_month_count3 != 0)
					{						
						$prefix = '';
						$html = "[\n";
						foreach($twelve_month_count3 as $row12)
						{
							$html .= $prefix . " {\n";

							$html .= '  "category": "' . $row12->Partner_name . '",' . "\n";
							$html .= '  "value1": "' . $row12->Total_issued_quantity . '",' . "\n";
							$html .= '  "value2": "' . $row12->Total_used_quantity . '"' . "\n";
							
							$html .= " }";
							$prefix = ",\n";
						}
						$html .= "\n]";
						$data['Chart_data'] = $html;				
					}
				/*----------------------------------partner Quantity issed & used Graph-----------------------------*/
			}
			/*************************************Nilesh Change for mccia*************************************/
			
			$theHTMLResponse = $this->load->view('login/twelve_month_graph', $data, true);		
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('graphHtml'=> $theHTMLResponse)));
		}
	}

	function logout()
	{
		/*----------------Nileh change---------------------*/
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['LogginUserName'] = $session_data['Full_name'];
		$data['enroll'] = $session_data['enroll'];
		$data['Logged_user_id'] = $session_data['userId'];
		$data['Super_seller'] = $session_data['Super_seller'];
		$CompanyID = $session_data['Company_id'];
		$Username = $data['username'];
		$enrollId = $data['enroll'];
		$userId = $session_data['userId'];	
		$Company_details = $this->Igain_model->get_company_details($CompanyID);
		$logout_CcUser = $this->Login_model->logout_cc_user($CompanyID,$Username,$enrollId,$userId);
		/**********************Login Masking****************************/	
		
		 unset($_SESSION["Merchant_login_error"]);
		unset($_SESSION['Login_masking']);	
		//$_SESSION['Login_masking']=0;
		/**********************Login Masking*****XXX***********************/
		/*----------------Nileh chane---------------------*/	
		$Website=$Company_details->Website;
		$Cust_website=$Company_details->Cust_website;
		$this->session->unset_userdata('logged_in');   
		
		// echo'<script>window.location.href="http://novacomonline.ehpdemo.online/novacom/"</script>';
		echo'<script>window.location.href="'.$Website.'";</script>'; 
		
		/* if($data['Logged_user_id']==3 || $data['Logged_user_id']==4)
		{
			// redirect('Login');
			echo'<script>window.location.href="'.$Cust_website.'";</script>';
			// echo'<script>window.location.href="http://localhost/CI_IGAINSPARK_LIVE_NEW_DESIGN/lipita/"</script>';
		}
		
		echo'<script>window.location.href="'.$Cust_website.'";</script>'; */
		// echo'<script>window.location.href="http://localhost/CI_IGAINSPARK_LIVE_NEW_DESIGN/lipita/"</script>';
				
		// redirect(base_url().'Company_'.$CompanyID);
	}	
	function member_visit()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];
			$CompanyID = $session_data['Company_id'];
			$data['Logged_user_id'] = $session_data['userId'];
			$data['Super_seller'] = $session_data['Super_seller'];

			 $cardID = $this->input->post('cardID');
			
			if(substr($cardID,0,1) == "%")
			{
				$get_card = substr($cardID,2); //*******read card id from magnetic card***********///
			}
			else
			{
				$get_card = substr($cardID,0,16); //*******read card id from other magnetic card***********///
			}
					
						
			$data['res14'] = $this->Home_model->insert_user_visit($CompanyID,$get_card);
			
			$theHTMLResponse = $this->load->view('login/show_member_info', $data, true);		
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
			
		}
		else
		{
			//If no session, redirect to login page
			redirect('Login', 'refresh');
		}
	}
	
	function Cust_membership()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];
			$CompanyID = $session_data['Company_id'];
			$data['Logged_user_id'] = $session_data['userId'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$this->load->view('login/Cust_membership', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('Login', 'refresh');
		}
	}
	function Show_more_members()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$CompanyID = $session_data['Company_id'];
			
			/****************Birthdays & Anniversaries**********************************************************/
		
	
		//-------------------------------------------------------------------------------------------------------
		$TodaysMD = date("m-d"); 
		$TodaysM = date("m"); 
		$Todays = date("Y-m-d"); 
		
		
		$Anniversaries_Member_NameD = array();
		$Anniversaries_Member_NameM = array();
		$Birthdays_Member_Card_id = array();
		$Anniversaries_Member_Phone_noM = array();
		$Anniversaries_Member_Phone_noD = array();
		
		$Birthdays_Member_NameD = array();
		$Birthdays_Member_NameM = array();
		$Birthdays_Member_Phone_noD = array();
		$Birthdays_Member_Phone_noM = array();
		
		$Birthdays_Member_Card_idD = array();
		$Birthdays_Member_Card_idM = array();
		
		$Anniversaries_Member_Name = array();
		$Anniversaries_Member_Card_id = array();
		$Anniversaries_Member_Phone_no = array();
		$Anniversaries_Member_Card_idD = array();
		$Anniversaries_Member_Card_idM = array();
		$joined_dateWD = array();
		$joined_dateWM = array();
		$joined_dateD = array();
		$joined_dateM = array();
		$PhotographWD = array();
		$PhotographWM = array();
		$PhotographD = array();
		$PhotographM = array();
		
		
		$Birthdays_Anniversaries = $this->Home_model->Get_Birthdays_Anniversaries($CompanyID);	
		
		$Anniversaries_Count = array();
		$Anniversaries_CountM = array();
		$Date_of_birthDD = array();
		$Date_of_birthMM = array();
		$Wedding_annversary_dateM = array();
		$Wedding_annversary_dateD = array();
		if($Birthdays_Anniversaries != NULL)
		{
			foreach($Birthdays_Anniversaries as $Birthdays_Anniversaries)
			{
				if($Birthdays_Anniversaries->Wedding_annversary_date!='')
				{
					$Wedding_annversary_date = date("m-d", strtotime($Birthdays_Anniversaries->Wedding_annversary_date)); 
					$Wedding_annversary_Month = date("m", strtotime($Birthdays_Anniversaries->Wedding_annversary_date)); 
					if($Wedding_annversary_date == $TodaysMD)
					{
						$Anniversaries_Member_NameD[]=$Birthdays_Anniversaries->First_name.' '.$Birthdays_Anniversaries->Last_name;
						$Anniversaries_Member_Phone_noD[]=$Birthdays_Anniversaries->Phone_no;
						$Anniversaries_Member_Card_idD[]=$Birthdays_Anniversaries->Card_id;
						$PhotographWD[]=$Birthdays_Anniversaries->Photograph;
						$joined_dateWD[]=$Birthdays_Anniversaries->joined_date;
						$Wedding_annversary_dateD[] = date("Y-m-d", strtotime($Birthdays_Anniversaries->Wedding_annversary_date)); 
						
						
						
					}
				
					if($Wedding_annversary_Month == $TodaysM)
					{
						$Anniversaries_Member_NameM[]=$Birthdays_Anniversaries->First_name.' '.$Birthdays_Anniversaries->Last_name;
						$Anniversaries_Member_Card_idM[]=$Birthdays_Anniversaries->Card_id;
						$Anniversaries_Member_Phone_noM[]=$Birthdays_Anniversaries->Phone_no;
						$PhotographWM[]=$Birthdays_Anniversaries->Photograph;
						$joined_dateWM[]=$Birthdays_Anniversaries->joined_date;
						$Wedding_annversary_dateM[] = date("Y-m-d", strtotime($Birthdays_Anniversaries->Wedding_annversary_date)); 
					}
				}
				//------------------------------------------------------------------------
				if($Birthdays_Anniversaries->Date_of_birth!='')
				{
					
					$Date_of_birthD = date("m-d", strtotime($Birthdays_Anniversaries->Date_of_birth)); 
					$Date_of_birthM = date("m", strtotime($Birthdays_Anniversaries->Date_of_birth)); 
					if($Date_of_birthD == $TodaysMD)
					{
						$Birthdays_Member_NameD[]=$Birthdays_Anniversaries->First_name.' '.$Birthdays_Anniversaries->Last_name;
						$Birthdays_Member_Card_idD[]=$Birthdays_Anniversaries->Card_id;
						$Birthdays_Member_Phone_noD[]=$Birthdays_Anniversaries->Phone_no;
						$PhotographD[]=$Birthdays_Anniversaries->Photograph;
						$joined_dateD[]=$Birthdays_Anniversaries->joined_date;
						$Date_of_birthDD[] = date("Y-m-d", strtotime($Birthdays_Anniversaries->Date_of_birth)); 
						
					}
					
					if($Date_of_birthM == $TodaysM)
					{
						$Birthdays_Member_NameM[]=$Birthdays_Anniversaries->First_name.' '.$Birthdays_Anniversaries->Last_name;
						$Birthdays_Member_Phone_noM[]=$Birthdays_Anniversaries->Phone_no;
						$Birthdays_Member_Card_idM[]=$Birthdays_Anniversaries->Card_id;
						$PhotographM[]=$Birthdays_Anniversaries->Photograph;
						$joined_dateM[]=$Birthdays_Anniversaries->joined_date;
						$Date_of_birthMM[] = date("Y-m-d", strtotime($Birthdays_Anniversaries->Date_of_birth)); 
					}
				}
				
				
			}
		}
		
		$data['This_Month_Birthdays_Count'] = count($Birthdays_Member_Card_idM);
		$data['This_Month_Anniversaries_Count'] = count($Anniversaries_Member_Card_idM);
		$data['Todays_Anniversaries_Count'] = count($Anniversaries_Member_Card_idD);
		$data['Todays_Birthdays_Count'] = count($Birthdays_Member_Card_idD);
		
		$data['Birthdays_Member_Card_idD'] = $Birthdays_Member_Card_idD;
		$data['Birthdays_Member_NameD'] = $Birthdays_Member_NameD;
		$data['Birthdays_Member_Phone_noD'] = $Birthdays_Member_Phone_noD;
		$data['PhotographD'] = $PhotographD;
		$data['Date_of_birthD'] = $Date_of_birthDD;
		$data['joined_dateD'] = $joined_dateD;
		
		
		
		$data['Birthdays_Member_Card_idM'] = $Birthdays_Member_Card_idM;
		$data['Birthdays_Member_NameM'] = $Birthdays_Member_NameM;
		$data['Birthdays_Member_Phone_noM'] = $Birthdays_Member_Phone_noM;
		$data['PhotographM'] = $PhotographM;
		$data['Date_of_birthM'] = $Date_of_birthMM;
		$data['joined_dateM'] = $joined_dateM;
		
		$data['Anniversaries_Member_NameD'] = $Anniversaries_Member_NameD;
		$data['Anniversaries_Member_Phone_noD'] = $Anniversaries_Member_Phone_noD;
		$data['Anniversaries_Member_Card_idD'] = $Anniversaries_Member_Card_idD;
		$data['PhotographWD'] = $PhotographWD;
		$data['joined_dateWD'] = $joined_dateWD;
		$data['Wedding_annversary_dateD'] = $Wedding_annversary_dateD;
		
		$data['Anniversaries_Member_NameM'] = $Anniversaries_Member_NameM;
		$data['Anniversaries_Member_Card_idM'] = $Anniversaries_Member_Card_idM;
		$data['Anniversaries_Member_Phone_noM'] = $Anniversaries_Member_Phone_noM;
		$data['PhotographWM'] = $PhotographWM;
		$data['joined_dateWM'] = $joined_dateWM;
		$data['Wedding_annversary_dateM'] = $Wedding_annversary_dateM;
		
		
		
		$data['happy_customers'] = $this->Home_model->get_happy_customers($CompanyID);
		$data['worry_customers'] = $this->Home_model->get_worry_customers($CompanyID);
		
			if($_POST == NULL)
			{
				// echo "fastenroll------------"; die;
				$this->load->view('login/Show_more_members', $data);
			}
			else
			{
			}
		}
		else
		{
				redirect('Login', 'refresh');
		}
	}
	
}
?>

