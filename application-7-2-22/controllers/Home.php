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
					
				}
						
			}
			else
			{
				$data['Total_Used'] = 0;
				$data['Total_Gained_Points'] = 0;
				$data['Total_Purchase_Amount'] = 0;
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
			$result_popular_category = $this->Home_model->get_popular_category($CompanyID);
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
			
	/*----------------------------------XXXXXX-----------------------------*/
	
	/*----------------------------------Member Commens -----------------------------*/
		$data['customers_comment'] = $this->Home_model->get_customers_comment($CompanyID);

	/*----------------------------------Member Commens -----------------------------*/
		
		
			$data['happy_customers'] = $this->Home_model->get_happy_customers($CompanyID);
			$data['worry_customers'] = $this->Home_model->get_worry_customers($CompanyID);			
			
			$todays2 = date("M");	$todays1 = date("d");	$todays3 = date("Y");
			$Company_details = $this->Igain_model->get_company_details($CompanyID);
			
			
			$this->load->view('login/home', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('Login', 'refresh');
		}
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
}
?>

