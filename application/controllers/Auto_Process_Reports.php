<?php 
 
class Auto_Process_Reports extends CI_Controller 
{
	public function __construct()
	{ 
		parent::__construct();		
		$this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('pagination');
      $this->load->database();
      // $this->load->helper('url');
      $this->load->model('login/Login_model');
      $this->load->model('Igain_model');
      $this->load->model('enrollment/Enroll_model');
      $this->load->model('Report/Report_model');
	  
	  $this->load->model('Auto_Process/Auto_process_model');
	  
		
	$this->load->helper(array('form', 'url','encryption_val'));
	}
	
	public function Send_reports_setting()
	{
		if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $Company_id = $session_data['Company_id'];
		$Loggin_User_id = $session_data['userId'];
		$data['Super_seller'] = $session_data['Super_seller'];
        $superSellerFlag = $session_data['Super_seller'];
        $Logged_user_id = $session_data['userId'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

		
		$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
		$data["User_types"] = $this->Auto_process_model->get_user_types();		
		if($get_sellers15 != NULL)
		{
			foreach($get_sellers15 as $seller_val)
			{
				$superSellerFlag = $seller_val->Super_seller;
			}
		}								
		if($Logged_user_id > 2 || $superSellerFlag == 1)
		{
			$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
		}
		else
		{	
			$get_sellers = $get_sellers15;
		}
	
		$data['Seller_array'] = $get_sellers;
		$data['Trans_Records'] = $this->Auto_process_model->Get_schedule_reports($Company_id);
		 if ($_REQUEST == NULL) {
			$this->load->view("Reports/Send_reports_setting_view", $data);
		 }

        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";

			  $report_id = $_REQUEST["report_id"];
			  $Brand_id = $_REQUEST["Brand_id"];
			  $user_type = $_REQUEST["user_type"];
			  $Primary_users = $_REQUEST["Primary_users"];
			  $Schedule = $_REQUEST["Schedule"];
			  
			  $user_type2 = $_REQUEST["user_type2"];
			  if(!isset($_REQUEST["Other_users"])){$_REQUEST["Other_users"]=0;}
			  $Other_users = $_REQUEST["Other_users"];
				
				if($Other_users != NULL)
				{
					foreach($Other_users as $Other_users)
					{
						$Insert = $this->Auto_process_model->Insert_schedule_report($Company_id, $report_id, $Brand_id, $user_type,$Primary_users,$Schedule,$user_type2,$Other_users,$data['enroll']);
					}
				}
				else
				{
					$user_type2=0;
					$Other_users=0;
					$Insert = $this->Auto_process_model->Insert_schedule_report($Company_id, $report_id, $Brand_id, $user_type,$Primary_users,$Schedule,$user_type2,$Other_users,$data['enroll']);
				}
				/************** igain Log Table ****************/
					
					$Todays_date = date('Y-m-d');	
								
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Schedule Report";
					$where="Create Schedule Report";
					$toname="";
					
					$firstName = $Schedule;
					$lastName = '';  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $Schedule;
					$opration=1;
					
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$report_id);
					//**********************************************************
			     redirect('Auto_Process_Reports/Send_reports_setting');
			
        }
		
      } else {
        redirect('Login', 'refresh');
      }
	}
	public function Edit_schedule_report()
	{
		if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $Company_id = $session_data['Company_id'];
		$Loggin_User_id = $session_data['userId'];
		$data['Super_seller'] = $session_data['Super_seller'];
        $superSellerFlag = $session_data['Super_seller'];
        $Logged_user_id = $session_data['userId'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

		
		$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
		$data["User_types"] = $this->Auto_process_model->get_user_types();		
		if($get_sellers15 != NULL)
		{
			foreach($get_sellers15 as $seller_val)
			{
				$superSellerFlag = $seller_val->Super_seller;
			}
		}								
		if($Logged_user_id > 2 || $superSellerFlag == 1)
		{
			$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
		}
		else
		{	
			$get_sellers = $get_sellers15;
		}
	
		$data['Seller_array'] = $get_sellers;
		$data['Trans_Records'] = $this->Auto_process_model->Get_schedule_reports($Company_id);
		 if ($_REQUEST != NULL) {
		$report_id = $_REQUEST["Report_id"];
		$Brand_id = $_REQUEST["Brand_id"];
		$Primary_users_id = $_REQUEST["Primary_users_id"];
		$Primary_user_type = $_REQUEST["Primary_user_type"];
			  
		$data['Edit_Records'] = $this->Auto_process_model->Get_edit_schedule_reports($report_id,$Brand_id,$Primary_users_id,$Primary_user_type,$Company_id);	  
		// print_r($data['Edit_Records']);
			$this->load->view("Reports/Edit_schedule_report", $data);
		 }

			
        
		
      } else {
        redirect('Login', 'refresh');
      }
	}
	public function Update_schedule_report()
	{
		if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Company_id = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];

        if ($_REQUEST != NULL) {

			  $report_id = $_REQUEST["report_id"];
			  $Brand_id = $_REQUEST["Brand_id"];
			  $user_type = $_REQUEST["user_type"];
			  $Primary_users = $_REQUEST["Primary_users"];
			  $Schedule = $_REQUEST["Schedule"];
			  
			  $user_type2 = $_REQUEST["user_type2"];
			  $Other_users = $_REQUEST["Other_users"];
			  $exp = explode('*',$_REQUEST['Old_schedule']);

			  
			$Delete = $this->Auto_process_model->Delete_schedule_report($exp[0],$exp[1],$exp[3],$exp[2]);

				if($Other_users != NULL)
				{
					foreach($Other_users as $Other_users)
					{
						$Insert = $this->Auto_process_model->Insert_schedule_report($Company_id, $report_id, $Brand_id, $user_type,$Primary_users,$Schedule,$user_type2,$Other_users,$data['enroll']);
					}
				}
				else
				{
					$user_type2=0;
					$Other_users=0;
					$Insert = $this->Auto_process_model->Insert_schedule_report($Company_id, $report_id, $Brand_id, $user_type,$Primary_users,$Schedule,$user_type2,$Other_users,$data['enroll']);
				}
				/************** igain Log Table ****************/
					
					$Todays_date = date('Y-m-d');	
								
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Schedule Report";
					$where="Edit Schedule Report";
					$toname="";
					
					$firstName = $Schedule;
					$lastName = '';  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $Schedule;
					$opration=2;
					
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$report_id);
					//**********************************************************
			     redirect('Auto_Process_Reports/Send_reports_setting');
			
        }
		
      } else {
        redirect('Login', 'refresh');
      }
	}
	public function delete_schedule()
	{
		 $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Company_id = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
		
			if ($_REQUEST != NULL) {
				$exp = explode('*',$_REQUEST['id']);

			$Delete = $this->Auto_process_model->Delete_schedule_report($exp[0],$exp[1],$exp[2],$exp[3]);
			/************** igain Log Table ****************/
					
					$Todays_date = date('Y-m-d');	
								
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Schedule Report";
					$where="Schedule Report";
					$toname="";
					
					$firstName = $exp[3];
					$lastName = '';  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $exp[3];
					$opration=3;
					
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$exp[4]);
					//**********************************************************
			redirect('Auto_Process_Reports/Send_reports_setting');	
			}
	}
	public function get_users_by_usertype()
	{
		$user_type = $this->input->post('user_type');
		$Company_id = $this->input->post('Company_id');
		$flag = $this->input->post('flag');
		
		if($user_type > '0')
		{
			$data['Users'] = $this->Auto_process_model->get_users_by_usertype($Company_id,$user_type);
			$data['flag'] = $flag;
		
			$opText4 = $this->load->view("Reports/get_users_by_usertype",$data, true);
				
		}
		
		//echo $opText4;
		if($opText4 != null)
		{
			$this->output->set_content_type('text/html');
			$this->output->set_output($opText4);
		}
	}
	
	public function Generate_auto_reports()
	{
		$this->load->library("Excel");

		$Company_details = $this->Igain_model->FetchCompany();
		foreach($Company_details as $Company_Records)
		{
			$Company_id = $Company_Records["Company_id"];
			$Company_name = $Company_Records['Company_name'];
			$Redemptionratio = $Company_Records['Redemptionratio'];
			// $Company_primary_email_id = App_string_decrypt($Company_Records['Company_primary_email_id']);
			$Company_primary_email_id = $Company_Records['Company_primary_email_id'];
			$Schedule_Records = $this->Auto_process_model->Get_schedule_reports($Company_id);
			
			if($Schedule_Records != NULL)
			{
				$Fetch_Super_Seller_details = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
				$Super_sellerUser = $Fetch_Super_Seller_details->First_name.' '.$Fetch_Super_Seller_details->Last_name;
				$Super_sellerUser_email_id = App_string_decrypt($Fetch_Super_Seller_details->User_email_id);
				$Super_sellerPhone_no = App_string_decrypt($Fetch_Super_Seller_details->Phone_no);
			
				foreach($Schedule_Records as $Schedule_Records)
				{
					// echo "<br>".$Schedule_Records->Report_id;
						$Report_id=$Schedule_Records->Report_id;
						$Brand_id=$Schedule_Records->Brand_id;
						$Schedule=$Schedule_Records->Schedule;
						$Primary_users_id=$Schedule_Records->Primary_users_id;
						$Other_users_id=$Schedule_Records->Other_users_id;
						
						$result = $this->Igain_model->get_enrollment_details($Schedule_Records->Primary_users_id);
						$Primary_users_email = App_string_decrypt($result->User_email_id);
						$Primary_User = $result->First_name.' '.$result->Last_name;

						if($Schedule_Records->Other_users_id != 0)
						{
							$result3 = $this->Igain_model->get_enrollment_details($Schedule_Records->Other_users_id);
							$Other_users_email = App_string_decrypt($result3->User_email_id);
						}
						$get_sellers289 = $this->Igain_model->get_seller_details($Brand_id);
			
						foreach($get_sellers289 as $seller_val289)
						{
							$brand_name = $seller_val289->First_name." ".$seller_val289->Last_name;
						}
			
						$Outlets = $this->Report_model->get_outlet_by_subadmin($Company_id,$Brand_id);
						
						$Outlet_id=array();
						$transaction_from=0;
						// $start_date= '2020-01-01';
						$end_date= date('Y-m-d 23:59:59');
						
						 if($Schedule == 'Daily')
						{
							$start_date= date('Y-m-d',strtotime('-1 day'));
						}
						elseif($Schedule == 'Weekly')
						{
							$start_date= date('Y-m-d',strtotime('-7 day'));
						}
						elseif($Schedule == 'Monthly')
						{
							$start_date= date('Y-m-d',strtotime('-30 day'));
						} 
						if($Outlets != NULL)
						{
							foreach($Outlets as $Outlets)
							{
								$Outlet_id[]=$Outlets->Enrollement_id;
							}
						}
						$Today_date = date("Y-m-d");
						$cmp_name = str_replace(' ', '_', $Company_name);
						
					if($Schedule_Records->Report_id == '1')//Order Report
					{
						$Subject = "Order Report - for ".$Company_name;
						$Voucher_status=0;
						$membership_id='';
						$start='';
						$limit='';
						
						$Export_file_name = $cmp_name . "_Orders_report_" . $Today_date;

						
						$data["Total_Trans_Records"] = $this->Auto_process_model->get_cust_order_transaction_details($Company_id, $start_date, $end_date, $transaction_from, $membership_id, $Voucher_status,$Outlet_id,$start, $limit);
					
						
						$this->excel->getActiveSheet()->setTitle('Member Orders Report');
						$fields2 = array();

						//Fetching the column names from return array data
						if($data["Total_Trans_Records"] != NULL){
							
						foreach ($data["Total_Trans_Records"][0] as $key => $field) {
						 
						if($key == "Seller" || $key == "Item_code" || $key == "Redeem_points" || $key =="Enrollement_id"){
						
							continue;
						}
							 
						$this->excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode();
						$this->excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode();
						$this->excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode();
						$this->excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('0');
						$this->excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('0.00'); 
						// $this->excel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('');
						// $this->excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('');
						// $this->excel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('');
						$this->excel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('0.00');
						$fields2[] = $key;
						}
						// $this->excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
						
						  $col = 0;
						  foreach ($fields2 as $field) {
							  
							// echo"<pre>";
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
							$col++;
						  }

				  
						
						//Fetching the table data
						$row = 2;
						foreach ($data["Total_Trans_Records"] as $data1) {
					  
							if($data1->Order_status == 0)
							{
								$data1->Order_status = "";
							}
				
							if($data1->Order_status == 18)
							{
								$data1->Order_status = "Ordered";
							}
							if($data1->Order_status == 19)
							{
								$data1->Order_status = "Shipped";
							}
							if($data1->Order_status == 20)
							{
								if($data1->Order_type == 28)
								{
									$data1->Order_status = "Collected";
								}
								else if($data1->Order_type == 29)
								{
									$data1->Order_status = "Delivered";
								}
								else
								{
									$data1->Order_status = " ";
								}
								
							}
							if($data1->Order_status == 21)
							{
								$data1->Order_status = "Cancel";
							}
				
							if($data1->Quantity == 0)
							{
								$data1->Quantity = "-";
								//$data1->Menu_name = "-";
							}
							
							

							if($data1->Trans_type == 12)
							{
								$data1->Trans_type = "Online";
							}
							
							if($data1->Trans_type == 2)
							{
								$data1->Trans_type = "POS";
							}
							
							if($data1->Order_type == 28)
							{
								$data1->Order_type = "Pick Up";
							}
							elseif($data1->Order_type == 29)
							{
								$data1->Order_type = "Home Delivery";
							}
							else
							{
								$data1->Order_type = "In-Store";
							}
						
							$col = 0;
							foreach ($fields2 as $field) {
							  $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
							  $col++;
							}
							$row++;
						}
						}
					}
					  						
					if($Schedule_Records->Report_id == '2')//Item Sales Report 
					{

						$Subject = "Item Sales Report - for ".$Company_name;
						$channel='0';
						
						
						$Export_file_name = $cmp_name . "_Item_sales_report_" . $Today_date;


						$data["Trans_Records"] = $this->Report_model->get_item_sales_report($Company_id, $start_date, $end_date, $Outlet_id,$channel);

					// print_r($data["Trans_Records"]);die;

						$this->excel->getActiveSheet()->setTitle('Item Sales Report');
						$fields = array();

						//Fetching the column names from return array data
						if($data["Trans_Records"] != NULL){
							
						 foreach ($data["Trans_Records"][0] as $key => $field) {
					
							$this->excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0.00');

							$fields[] = $key;
						  }
						}
						
						  $col = 0;
						  foreach ($fields as $field) {
							  
							// echo"<pre>";
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
							$col++;
						  }

				  
						
						//Fetching the table data
						$row = 2;
						foreach ($data["Trans_Records"] as $data1) {
					  
							if($data1->Channel == 12)
							{
								$data1->Channel = "Online";
							}
							
							if($data1->Channel == 2)
							{
								$data1->Channel = "POS";
							}
							
							if($channel == 0)
							{
								$data1->Channel = "All";
							}
							$data1->Value_sold = number_format(round($data1->Value_sold),2);
							$data1->Brand = $brand_name;
					
							$col = 0;
							foreach ($fields as $field) {
							  $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
							  $col++;
							}
							$row++;
						}
						
					}
					
					  
					if($Schedule_Records->Report_id == '3')//Loyalty Order Report
					{
						$Subject = "Loyalty Order Report - for ".$Company_name;
						$Export_file_name = $cmp_name . "_Loyalty_Orders_report_" . $Today_date;
						
						$data['Trans_Records3'] = $this->Report_model->Get_loyalty_order_trans_records($Company_id, $start_date, $end_date, $transaction_from,$Outlet_id,$Redemptionratio);
						
						$this->excel->getActiveSheet()->setTitle('Loyalty Orders Report');
						  $fields3 = array();

						  //Fetching the column names from return array data
						  if($data["Trans_Records3"] != NULL){
						  foreach ($data["Trans_Records3"][0] as $key => $field) {
							 
							if($key == "Seller" || $key == "Item_code" || $key =="Enrollement_id"){
								continue;
							}

							$fields3[] = $key;
						  }
						  	// $this->excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('0.00');
							// $this->excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('0.00');
							// $this->excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00');
							// $this->excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('0.00');
						  $col = 0;
						  $Visits=0;
						  $Bill_amount_visit=0;
						  $Online_purchase=0;
						  $Bill_amount_online=0;
						  foreach ($fields3 as $field) {
							// echo"<pre>";
							  
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
							$col++;
						  }
						  //Fetching the table data
						  $row = 2;
						  foreach ($data["Trans_Records3"] as $data1) {
							  
							  if($transaction_from==0 || $transaction_from==2)
								{
									$POS = $this->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 2,$data1->Seller);
									if($POS != NULL)
									{
										foreach($POS as $rec)
										{
											$Visits=$rec->Visits;
											$Bill_amount_visit=$rec->Bill_amount_visit;
										}
									}
									else
									{
										$Visits=0;
										$Bill_amount_visit=0;
									}
								}
								if($transaction_from==0 || $transaction_from==12)
								{
									$ONLINE = $this->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 12,$data1->Seller);
									if($ONLINE != NULL)
									{
										foreach($ONLINE as $rec)
										{
											$Online_purchase=$rec->Online_purchase;
											$Bill_amount_online=$rec->Bill_amount_online;
										}
									}
									else
									{
										$Online_purchase=0;
										$Bill_amount_online=0;
									}
								}	
									  $data1->Channel = "Both";
									  if($data1->Channel == 12)
										{
											$data1->Channel = "Online";
											$data1->Visits = "-";
											$data1->Bill_amount_visit = "-";
										}
										
										if($data1->Channel == 2)
										{
											$data1->Channel = "POS";
											$data1->Online_purchase = "-";
											$data1->Bill_amount_online = "-";
										}
							
							
							
										$data1->Outlet = $data1->Outlet;
										$data1->Channel = $data1->Channel;
										$data1->Visits = $Visits;
										$data1->Online_purchase = $Online_purchase;
										$data1->Bill_amount_visit = number_format(round($Bill_amount_visit),2);
										$data1->Bill_amount_online = number_format(round($Bill_amount_online),2);
										$data1->Total_spend = number_format(round($data1->Total_spend),2);
										$data1->Total_discount_amount = number_format(round($data1->Total_discount_amount),2);
										$data1->Voucher_amount = number_format(round($data1->Voucher_amount),2);
										$data1->Redeem_points = round($data1->Redeem_points);
										$data1->Redeem_amount = number_format(round($data1->Redeem_amount),2);
										$data1->Paid_amount = number_format(round($data1->Paid_amount),2);
										$Earn_points1 = round($data1->Earn_points);
										$Earn_points2 = (int)$Earn_points1;
										$data1->Earn_points = number_format(round($Earn_points2),0);
										$data1->Earned_amt =number_format(round($data1->Earned_amt),2);
								
								
											
							
										$col = 0;
										foreach ($fields3 as $field) {
										 $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
										 $col++;
										}
										$row++;
							}
						  }
						  
						
					}						
					  
					   
					if($Schedule_Records->Report_id == '4')//Points Report
					{
						$transaction_from=0;
						$membership_id='';
						$report_type='1';//details
						
						$Subject = "Member Points Report - for ".$Company_name;
						$Export_file_name = $cmp_name . "_Member_Points_detail_report_" . $Today_date;
						
						$data['Trans_Records'] = $this->Report_model->get_member_order_report($Company_id, $start_date, $end_date, $transaction_from, $membership_id,$Outlet_id,$report_type,$Redemptionratio,0);
						
						$this->excel->getActiveSheet()->setTitle('Member Points Report');
						$fields3 = array();

						//Fetching the column names from return array data
						if($data["Trans_Records"] != NULL){
						foreach ($data["Trans_Records"][0] as $key => $field) {
						 
						if($key == "Sequence_no" ||$key == "Seller" || $key == "Total_mpesa_amount" || $key =="Enrollement_id" || $key == "Total_cash_amount"|| $key == "Order_status"|| $key == "Order_type"){
							continue;
						}
						//$key == "Order_status"|| $key == "Order_type"
						
						
							$this->excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('0.00');
							$this->excel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('0.00');
						
						
						$fields[] = $key;
						}
						  
						foreach ($fields as $field) {
							// echo"<pre>";
							$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
							$col++;
						  }
						  //Fetching the table data
						  $row = 2;
						foreach ($data["Trans_Records"] as $data1) {
							  
						if($data1->Order_status == 0)
						{
							$data1->Order_status = "";
						}
			
						if($data1->Order_status == 18)
						{
							$data1->Order_status = "Ordered";
						}
						if($data1->Order_status == 19)
						{
							$data1->Order_status = "Shipped";
						}
						if($data1->Order_status == 20)
						{
							if($data1->Order_type == 28)
							{
								$data1->Order_status = "Collected";
							}
							else if($data1->Order_type == 29)
							{
								$data1->Order_status = "Delivered";
							}
							else
							{
								$data1->Order_status = " ";
							}
							
						}
						if($data1->Order_status == 21)
						{
							$data1->Order_status = "Cancel";
						}
			
						

						if($data1->Channel == 12)
						{
							$data1->Channel = "Online";
						}
						
						if($data1->Channel == 2)
						{
							$data1->Channel = "POS";
						}
						
						if($data1->Order_type == 28)
						{
							$data1->Order_type = "Pick Up";
						}
						elseif($data1->Order_type == 29)
						{
							$data1->Order_type = "Home Delivery";
						}
						else
						{
							$data1->Order_type = "In-Store";
						}
					
					
							$data1->Online_Bill_amt = number_format(round($data1->Online_Bill_amt),2);
							$data1->POS_Bill_amt = number_format(round($data1->POS_Bill_amt),2);
							$data1->Bill_amt = number_format(round($data1->Bill_amt),2);
							//$data1->Total_shipping_cost = number_format(round($data1->Total_shipping_cost),2);
							$data1->Discount_amt = number_format(round($data1->Discount_amt),2);
							$data1->Voucher_amt = number_format(round($data1->Voucher_amt),2);
							$data1->Redeemed_amt = number_format(round($data1->Redeemed_amt),2);
							$data1->Paid_amt = number_format(round($data1->Paid_amt),2);
							$data1->Earned_amt = number_format(round($data1->Earned_amt),2);
							$data1->Redeemed_pts = round($data1->Redeemed_pts);	
							$data1->Earned_pts = round($data1->Earned_pts);
								
							$col = 0;
							foreach ($fields as $field) {
							  $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
							  $col++;
							}
							$row++;
						}
						}
						  
						
					}						
					  
					 

					$this->excel->setActiveSheetIndex(0);
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
																	

					  $date=date('Y-m-d');
						if($Schedule == 'Daily')
						{
							// $objWriter->save('Reports\Daily\Daily-'.$Export_file_name.'.xls');
							// $file_path=base_url('Reports\Daily\Daily-'.$Export_file_name.'.xls');
							
							$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/Reports/Daily/Daily-'.$Export_file_name.'.xls');
							$file_path=($_SERVER['DOCUMENT_ROOT'].'/Reports/Daily/Daily-'.$Export_file_name.'.xls');
						}elseif($Schedule == 'Weekly')
						{
							// $objWriter->save('Reports\Weekly\Weekly-'.$Export_file_name.'.xls');
							// $file_path=base_url('Reports\Weekly\Weekly-'.$Export_file_name.'.xls');
							
							$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/Reports/Weekly/Weekly-'.$Export_file_name.'.xls');
							$file_path=($_SERVER['DOCUMENT_ROOT'].'/Reports/Weekly/Weekly-'.$Export_file_name.'.xls');
						}elseif($Schedule == 'Monthly')
						{
							// $objWriter->save('Reports\Monthly\Monthly-'.$Export_file_name.'.xls');
							// $file_path=base_url('Reports\Monthly\Monthly-'.$Export_file_name.'.xls');
							
							$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/Reports/Monthly/Monthly-'.$Export_file_name.'.xls');
							$file_path=($_SERVER['DOCUMENT_ROOT'].'/Reports/Monthly/Monthly-'.$Export_file_name.'.xls');
						}
					  
					  
					   //**************************Email Fuction Code*****************************
					  $html = "<p>Dear $Primary_User,</p>

								<p>Kindly find attached the $Export_file_name.xls for your reference.</p>

								<p>Please contact your Program manager $Super_sellerUser  on $Super_sellerPhone_no or $Super_sellerUser_email_id  should you have any questions or comments.</p>

								<p>Regards,
								<br>Novacom System Ltd.</p>"; 
						// echo "<br><br>".$html;	
							$config = array();	
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
						  $this->email->clear(TRUE);

						  $this->email->from($Company_primary_email_id);
						  $this->email->to('amitk@miraclecartes.com');
						  // $this->email->to($Primary_users_email);
						 $this->email->cc(array('rakesh@miraclecartes.com'));
						 // if($Other_users_email){$this->email->cc(array($Other_users_email));}
						// $this->email->subject('Reports for '.$Company_name);
						$this->email->subject($Subject);
						// $this->email->subject('Automated Schedule Report - for '.$Company_name);
						$this->email->message($html);
						$this->email->attach($file_path);
						if (!$this->email->send()) {
							 // echo"---NOT-Send--Email Template-<br>";
							// var_dump($this->CI->email->send());
						} else {
							 // echo"----Send--Email Template-<br>";
						}
					
				}
			}
		}

	}


}	
	?>
