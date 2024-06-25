<?php 
error_reporting(0);
class Merchant_api extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Api/Merchant_api_model'); 
		$this->load->model('Api/Pos_model');	
		$this->load->model('Igain_model');	
		$this->load->model('transactions/Transactions_model');	
		$this->load->library('Send_notification');
		$this->load->model('login/Login_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->model('Coal_transactions/Coal_Transactions_model');
		$this->load->model('POS_catlogueM/POS_catalogue_model');
	}
	public function index() 
	{ 	
		// $this->load->view('Api/igainspark_api');
		// $this->load->view('Api/find_pos'); 
		$result = array(
						 "Error_flag" => 404,
						 "status_message" => "Invalid Inputs"
				    	);
						
		echo json_encode($result);
	}		
	public function Novacom_api()
	{
		$date = new DateTime();
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');
		$iv = '56666852251557009888889955123458'; 		
		
		$API_flag = $_REQUEST['API_flag'];
		$API_Company_username = $_REQUEST['Company_username'];
		$API_Company_password = $_REQUEST['Company_password'];		
		
		$getHeaders = apache_request_headers();
		if($getHeaders!=Null)
		{
			$API_flag = $getHeaders['API_flag'];	
			$API_Company_username = $getHeaders['Company_username'];	
			$API_Company_password = $getHeaders['Company_password'];	
		}
		
		$inputArgs = (json_decode(file_get_contents('php://input'),true));
		if($inputArgs !=NULL)
		{
			if($API_flag == Null && $API_Company_username == Null && $API_Company_password == Null)
			{
				$API_flag = $inputArgs['API_flag'];
				$API_Company_username = $inputArgs['Company_username'];
				$API_Company_password = $inputArgs['Company_password'];
			}
		}	
		
		if($API_Company_username == "" || $API_Company_password == "" || $API_flag == "")
		{
				$result = array(
								"Error_flag" => 404,
								"status_message" => "Invalid Inputs"
							);
								
				echo json_encode($result);	
				
			// echo json_encode(array("status" => "404", "status_message" => "Missing Company Username Information"));
		}
		else
		{
			$Check_company_exist = $this->Merchant_api_model->Check_compnay_by_username($API_Company_username);							
			if($Check_company_exist !=NULL)
			{
				$Company_id = $Check_company_exist->Company_id;
				$Allow_merchant_pin = $Check_company_exist->Allow_merchant_pin;
				$Allow_member_pin = $Check_company_exist->Pin_no_applicable;
				$Company_encryptionkey = $Check_company_exist->Company_encryptionkey;
				$DB_Company_password = $Check_company_exist->Company_password;
				$key = $Company_encryptionkey;
				$Login_Redemptionratio=$Check_company_exist->Redemptionratio;
				$Country_id=$Check_company_exist->Country;
				$Company_name1=$Check_company_exist->Company_name;
				$Comapany_Currency = $Check_company_exist->Currency_name;
				$Company_Redemptionratio = $Check_company_exist->Redemptionratio;					
				$Decrypt_Company_password = $this->string_decrypt($API_Company_password, $key, $iv);	
				$Decrypt_Company_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Decrypt_Company_password);
				
				$Gift_card_flag=$Check_company_exist->Gift_card_flag;
				$Gift_card_validity_days=$Check_company_exist->Gift_card_validity_days;
				$Company_redeem_request_validity = $Check_company_exist->Redeem_request_validity; 
				$Stamp_voucher_validity = $Check_company_exist->Stamp_voucher_validity;
				
				$Company_meal_flag = $Check_company_exist->Enable_company_meal_flag;
				$Redeem_auto_confirm = $Check_company_exist->Redeem_auto_confirm_flag;
				$Use_points_as_discounts = $Check_company_exist->Points_as_discount_flag;
				$Company_discount_code = $Check_company_exist->Discount_code;
				
				$Password_match = strcmp($DB_Company_password,$Decrypt_Company_password);
				// $Password_match = 0;
				if($Password_match == 0)
				{
					$result = $this->Merchant_api_model->check_company_key_valid($Company_id);// Check Company Key validation
					
					$Company_username = $result->Company_username;
					$Company_password = $result->Company_password;
					$key = $result->Company_encryptionkey;
						
					$API_flag2 = $this->string_decrypt($API_flag, $key, $iv);
					$API_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $API_flag2);
					/***************************Fetch Member Info**************************/
					// $API_flag =  88;
					if($API_flag == 20)  //Fetch_Member_info
					{	
						/* $merchant_email = $_REQUEST["Merchant_email"];
													
						$result91 = $this->Merchant_api_model->Get_Seller_Details($Company_id,$merchant_email);	
				
						if($result91 !=NULL)
						{ 
							$Seller_enroll_id  = $result91->Enrollement_id;
							$Outlet_name  = $result91->First_name.' '.$result91->Last_name; */
							
							// $Membership_id = $_REQUEST['Membership_id'];
							$Membership_id = $inputArgs['Membership_id'];
						
							$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
							$phnumber = $dial_code.$Membership_id;
						
							$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details	
							
							if($result!=NULL)
							{
								$Cust_Enrollement_id = $result->Enrollement_id;
								$Current_balance = $result->Current_balance;
								$Blocked_points = $result->Blocked_points;
								$Debit_points = $result->Debit_points;
								$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
								if($Current_point_balance < 0)
								{
									$Current_point_balance=0;
								}
								else 
								{
									$Current_point_balance=$Current_point_balance;
								}
								
								$First_name=$result->First_name;
								$Middle_name=$result->Middle_name;
								$Last_name=$result->Last_name;
								$Memeber_name = $First_name.' '.$Middle_name.' '.$Last_name;
								
								/* $Confirmation_code = $this->Igain_model->getRandomString();
								
								$data = array(
											'Enrollement_id' => $Cust_Enrollement_id,
											'Company_id' => $Company_id,
											'Seller_id' => $Seller_enroll_id,
											'Confirmation_code' => $Confirmation_code,
											'Confirmation_flag' => 0
										);
										
								$Redeem_request = $this->Merchant_api_model->Cust_redeem_request_insert($data);
								
									$data1 = array(
											'Confirmation_flag' => 2
											);
											
								$this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_Enrollement_id,$Company_id,$Seller_enroll_id);
								
								$Notification_type ='Redeem Request with '.$Company_name1;
								
								$Email_content = array(
										'Notification_type' => $Notification_type,
										'Confirmation_code' => $Confirmation_code,
										'Template_type' => 'Customer_redeem_request'
									);
								
								$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,$Seller_enroll_id,$Company_id); */
										
								$member_details = array(
										"Error_flag" => 1001,
										"Membership_id" => $result->Card_id,
										"Member_name" => $Memeber_name, 
										"Member_email" => App_string_decrypt($result->User_email_id), 
										"Phone_no" => App_string_decrypt($result->Phone_no), 
										"Tier_name" => $result->Tier_name,
										"Balance_points" => $Current_point_balance
									);
								
								echo json_encode($member_details);
								exit;
							}	
							else    
							{
								$Result127 = array("Error_flag" => 2003); //Unable to Locate membership id
								echo json_encode($Result127);
								exit;
							}
						/* }
						else
						{
							$Result3100 = array("Error_flag" => 2009);  //Unable to Locate merchant 
							echo json_encode($Result3100);
							exit;
						} */
					}
					/***************************Fetch Member Info**************************/
					/***************************Check Merchant Info**************************/
					if($API_flag == 75)
					{
						$merchant_email = $_REQUEST["merchant_email"];
						
						$result1 = $this->Merchant_api_model->check_merchant_email($merchant_email, $Company_id );
					
						if($result1!=NULL)
						{
							$Result1001 = array("Error_flag" => 1001); // Status OK
							$this->output->set_output(json_encode($Result1001));
						}
						else    
						{
							$Result3100 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result3100)); //Unable to Locate Merchant Email id
						}
					}
					/***************************Check Merchant Info**************************/
					/*******************Check Merchant Existing Manual Bill No.Info*****************/
					if($API_flag == 76)
					{	
						$merchant_email = $_REQUEST["merchant_email"];
						$manual_bill_no = $_REQUEST["Manual_Bill_No"];
						
						$result123 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);
						if($result123!=NULL)
						{
							$seller_id = $result123->Enrollement_id;
						
							$result = $this->Transactions_model->check_bill_no($manual_bill_no,$Company_id );
						
							if($result > 0)
							{
								// $this->output->set_output("Already Exist"); Bill number already exist
								$Result2067 = array("Error_flag" => 2067);
								$this->output->set_output(json_encode($Result2067)); 
							}
							else    
							{
								$Result1001 = array("Error_flag" => 1001); // Status OK
								$this->output->set_output(json_encode($Result1001));
							}
						}
						else
						{
							$Result3100 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result3100));
						}
					}
					/******************Check Merchant Manual Bill No.Info*********************/
					/***************Point Evaluation API *****************/
					if($API_flag == 17)
					{	 
						// $mechant_emailid = $_REQUEST['Merchant_email'];
						// $Purchase_amount = $_REQUEST['Purchase_amount'];
						// $Redeem_points = $_REQUEST['Redeem_points'];
						// $Membership_id = $_REQUEST['Membership_id'];
						
						$Membership_id = $inputArgs['Membership_id'];
						$Pos_bill_no = $inputArgs['Bill_No'];
						$Pos_bill_status = $inputArgs['Bill_Status'];
						$Purchase_amount = $inputArgs['Bill_Total'];
						$Pos_bill_date_time = $inputArgs['Bill_Date_Time'];
						$Pos_outlet_id = $inputArgs['Outlet_No'];
						$Pos_outlet_name = $inputArgs['Outlet_Name'];
						$Pos_bill_items = $inputArgs['Bill_Items'];
						$Pos_redeem_details = $inputArgs['Redeem_Details'];
						$Redeem_points = $Pos_redeem_details['Points_Redeemed'];
						
						$Purchase_amount = str_replace( ',', '', $Purchase_amount);
						$Redeem_points = str_replace( ',', '', $Redeem_points);
						
						// $Current_balance = $_REQUEST['Current_balance'];
						// $balance_to_pay = $_REQUEST['balance_to_pay'];
						// $Promo_redeem_by = $_REQUEST['Promo_redeem_by'];
						// $Gift_redeem_by = $_REQUEST['Gift_redeem_by'];
						// $promo_reedem = $_REQUEST['promo_reedem'];
						// $Gift_reedem = $_REQUEST['Gift_reedem'];
						
						$promo_reedem = '';
						$Gift_reedem = '';
						$Promo_redeem_by = 0;
						$Gift_redeem_by = 0;
						$balance_to_pay = '';	
						
						$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
						$phnumber = $dial_code.$Membership_id;
												
						$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
						if($result!=NULL)
						{
							if($result == 3111)
							{
								$Result1311 = array("Error_flag" => 3111, "Message" =>'Customer code expired');
								echo json_encode($Result1311);
								exit;		
							}							
							$Cust_enrollement_id = $result->Enrollement_id;
							$Current_balance = $result->Current_balance;
							$Blocked_points = $result->Blocked_points;
							$Debit_points = $result->Debit_points;
							
							$lv_member_Tier_id = $result->Tier_id;
							$Total_reddems = $result->Total_reddems;
							
							$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
							if($Current_point_balance < 0)
							{
								$Current_point_balance=0;
							}
							else 
							{
								$Current_point_balance=$Current_point_balance;
							}
							
							if($Redeem_points <=0 || $Redeem_points == null)
							{
								$Result1271 = array(
												"Error_flag" => 3104,
												"Message" => "Invalid redeem points."
											);
											
								echo json_encode($Result1271); // Membership Id Not found
								exit;
							}
							if($Total_reddems == 0)
							{
								$result51 = $this->Merchant_api_model->Get_Member_Tier_Details($lv_member_Tier_id,$Company_id);
								$Tier_redeemtion_limit = $result51->Redeemtion_limit;
								if($Tier_redeemtion_limit != Null)
								{
									if($Current_point_balance < $Tier_redeemtion_limit)
									{
										$Result31 = array(
														"Error_flag" => 3101,
														"Message" => "Insufficient Point Balance.!!"
													);
													
										echo json_encode($Result31); //Insufficient Point Balance
										exit;
									}
								}
							}
							$result1 = $this->Merchant_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
							
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Outlet_name = $result1->First_name. ' '.$result1->Last_name;
								
								$Seller_Redemptionratio = $result1->Seller_Redemptionratio;
								if($Seller_Redemptionratio == Null)
								{
									$Seller_Redemptionratio = $Company_Redemptionratio;
								}
									
								$currency_details = $this->Igain_model->Get_Country_master($result1->Country);
								$Symbol_currency = $currency_details->Symbol_of_currency;
								
								/*$result2 = $this->Merchant_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points);
								
								if($result2!=NULL)
								{
									$Cust_confirmation_code = $result2->Confirmation_code;*/
								
									if($Redeem_points <= $Current_point_balance)
									{	
										$result221 = $this->Merchant_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no);
												
										if($result221 != Null)
										{
											$Earlier_request_flag = $result221->Confirmation_flag;
											if($Earlier_request_flag == 0)
											{
												$Earlier_request_time = $result221->Creation_date;
												$Validity = explode(":",$Company_redeem_request_validity);
	
												$H = $Validity[0];
												$M = $Validity[1];
												$S = $Validity[2];
												
												$cenvertedTime = date("Y-m-d H:i:s",strtotime("+$H hour +$M minutes",strtotime($Earlier_request_time)));
												
												$currentTime = date("Y-m-d H:i:s");
												
												if($currentTime > $cenvertedTime)
												{
													$data1 = array(
															'Confirmation_flag' => 2
															);
															
													$this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
												}
											}
										}
										
										$result22 = $this->Merchant_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no);
										
										if($result22==NULL) 
										{
											$calculate2 = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem);
											
											$calculate2 = str_replace( ',', '', $calculate2);
											
											if($calculate2!=2066)
											{
												$Confirmation_code = $this->Igain_model->getRandomString();
											/*****************11-3-2021*******************/
												$Redeem_request_confirm = 0;
												if($Redeem_auto_confirm == 1)
												{
													$Redeem_request_confirm = 1;
												}
											/*****************11-3-2021*******************/
												$data = array(
															'Enrollement_id' => $Cust_enrollement_id, 
															'Company_id' => $Company_id,
															'Seller_id' => $Seller_id,
															'Confirmation_code' => $Confirmation_code,
															// 'Confirmation_flag' => 0,
															'Confirmation_flag' => $Redeem_request_confirm,
															'Redeem_points' => $Redeem_points,
															'Pos_bill_no' => $Pos_bill_no,
															'Bill_amount' => $Purchase_amount,
															'Creation_date' => date("Y-m-d H:i:s")
														);
														
												$data1 = array(
															'Confirmation_flag' => 2
															);
															
												$this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
														
												$Redeem_request = $this->Merchant_api_model->Cust_redeem_request_insert($data);
											
												// $Notification_type ='Redeem Request with '.$Outlet_name;
												$Notification_type ='Redeem Points Confirmation';
												
												if($Redeem_auto_confirm !=1)
												{
												$Email_content = array(
															'Notification_type' => $Notification_type,
															'Confirmation_code' => $Confirmation_code,
															'Redeem_points' => $Redeem_points,
															'Bill_no' => $Pos_bill_no,
															'Bill_amount' => number_format($Purchase_amount, 2),
															'Symbol_currency' => $Symbol_currency,
															'Equivalent_amount' => number_format($calculate2, 2),
															'Template_type' => 'Customer_redeem_request',
															'Outlet_name' => $Outlet_name
														);
										
												$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id);
												}												
											}
										}
										
										$result2 = $this->Merchant_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no);
										
										$Cust_confirmation_flag = $result2->Confirmation_flag;
										$Cust_confirmation_code = $result2->Confirmation_code;
										if($Cust_confirmation_flag == 1)
										{
											$Cust_confirmation_code = $Cust_confirmation_code;
										}
										else if($Cust_confirmation_flag == 3)
										{
											$Cust_confirmation_code = "";
										}
										$calculate = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem);
										
										$calculate = str_replace( ',', '', $calculate);
										
										if($result2 !=NULL)
										{
											if($calculate != NULL)
											{
											if($calculate== 2066 || $calculate > $Purchase_amount) //Equivalent Redeem Amount is More than Total Bill Amount
												{
													$Equivalent = array(
														"Error_flag" => 2066,
														"Message" => "Equivalent Redeem Amount is More than Total Bill Amount"
													);
												}
												else
												{
													if($Use_points_as_discounts == 1)
													{
														$Equivalent = array(
														"Error_flag" => 1001, 
														"Current_points" => $Current_point_balance,
														"Redeem_points" => $Redeem_points,
														"Equivalent_redeem_amount" => number_format($calculate, 2),
														"Balance_points" => $Current_point_balance-$Redeem_points,
														"Confirmation_code" => $Cust_confirmation_code,
														// "Confirmation_flag" => 1,
														"Confirmation_flag" => $Cust_confirmation_flag,
														"Bill_no" => $Pos_bill_no,
														"Bill_total" => number_format($Purchase_amount,2),
														"Redeem_type" => "D",
														"Discount_code" => $Company_discount_code,
														"Discount_amt" => number_format($calculate, 2)
														);
													}
													else
													{
														$Equivalent = array(
															"Error_flag" => 1001, 
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format($calculate, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => $Cust_confirmation_code,
															// "Confirmation_flag" => 1,
															"Confirmation_flag" => $Cust_confirmation_flag,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Purchase_amount,2),
															"Redeem_type" => "P",
															"Discount_code" => "",
															"Discount_amt" => number_format(0, 2)
														);
													}
												}	
												
												// $data1 = array(
															// 'Confirmation_flag' => 2
															// );
															
												// $this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
												
												echo json_encode($Equivalent); // successfully
												exit;
												
											}
											else
											{ 
												if($Use_points_as_discounts == 1)
												{
													$Error = array(
															"Error_flag" => 1001,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" =>  number_format(0, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => $Cust_confirmation_code,
															// "Confirmation_flag" => 1,
															"Confirmation_flag" => $Cust_confirmation_flag,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Purchase_amount,2),
															"Redeem_type" => "D",
															"Discount_code" => $Company_discount_code,
															"Discount_amt" => number_format(0, 2)
														);
												}
												else
												{
													$Error = array(
															"Error_flag" => 1001,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" =>  number_format(0, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => $Cust_confirmation_code,
															// "Confirmation_flag" => 1,
															"Confirmation_flag" => $Cust_confirmation_flag,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Purchase_amount,2),
															"Redeem_type" => "P",
															"Discount_code" => "",
															"Discount_amt" => number_format(0, 2)
														);
												}
												echo json_encode($Error); // Null result found
												exit;
											}
										}
										else
										{
											if($calculate == 2066 || $calculate > $Purchase_amount) //Equivalent Redeem Amount is More than Total Bill Amount
											{
												$Equivalent = array(
													"Error_flag" => 2066,
													"Message" =>"Equivalent Redeem Amount is More than Total Bill Amount"
												);
												
												echo json_encode($Equivalent);
												exit;
											}
											else
											{
												if($Use_points_as_discounts == 1)
												{
													$Equivalent = array(
															"Error_flag" => 1001, 
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format($calculate, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => "",
															"Confirmation_flag" => 0,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Purchase_amount,2),
															"Redeem_type" => "D",
															"Discount_code" => $Company_discount_code,
															"Discount_amt" => number_format($calculate, 2)
														);
												}
												else
												{
													$Equivalent = array(
															"Error_flag" => 1001, 
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format($calculate, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => "",
															"Confirmation_flag" => 0,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Purchase_amount,2),
															"Redeem_type" => "P",
															"Discount_code" => "",
															"Discount_amt" => number_format(0, 2)
														);
												}
												echo json_encode($Equivalent); // Cust Not Approved 
												exit;
											}
										}
									}
									else
									{ 
										$Result12 = array(
													"Error_flag" => 3101,
													"Message" => "Insufficient Point Balance."
												);
												
										echo json_encode($Result12); //Insufficient Point Balance
										exit;
									}
								/*}
								else
								{ 
									$Result12 = array(
												"Error_flag" => 3108,
												"Confirmation_flag" => 0
											);
											
									echo json_encode($Result12); //Customer Not Approved redeemprion request
									exit;
								} */
							}
							else
							{
								$Result3100 = array(
												"Error_flag" => 2009,
												"Message" => "Outlet id not found."
											);
											
								echo json_encode($Result3100); // Seller Email Not Found
								exit;
							}
						}
						else    
						{
							$Result127 = array(
												"Error_flag" => 2003,
												"Message" => "Membership Id Not found."
											);
											
							echo json_encode($Result127); // Membership Id Not found
							exit;
						}							
					}
					/**********************Point Evaluation API ***********************************/
					/**********************Pos_Purchase_Transaction_API ***************************/
					if($API_flag == 19)
					{ 
						$Api_type = $_REQUEST["Trans_Type"];
														
						if($Api_type == 1) // POS Transaction
						{
							$gained_points_fag = 0;
							$cardId = $_REQUEST["Membership_id"];
							$dial_code = $this->Igain_model->get_dial_code($Country_id);//Get Country Dial code 			
							$phnumber = $dial_code.$_REQUEST["Membership_id"];  
							
							
							if($_REQUEST["Purchase_amount"] <= 0)
							{
								$Error = array(
										"Error_flag" => 1002,
									);
									
								echo json_encode($Error); // Null result found 
								exit;
							}	
							
							$Balance_to_pay=$_REQUEST["Purchase_amount"]-$_REQUEST['Redeem_amount'];
							
							$cust_details = $this->Merchant_api_model->cust_details_from_card($Company_id,$cardId,$phnumber); //Get Customer details
							if($cust_details !=NULL)
							{
								foreach($cust_details as $row25)
								{
									$Customer_enroll_id=$row25['Enrollement_id'];
									$CardId=$row25['Card_id'];
									$fname=$row25['First_name'];
									$midlename=$row25['Middle_name'];
									$lname=$row25['Last_name'];
									$bdate=$row25['Date_of_birth'];
									$address=$row25['Current_address'];
									$bal=$row25['Current_balance'];
									$Blocked_points=$row25['Blocked_points'];
									$Debit_points=$row25['Debit_points'];
									$phno=$row25['Phone_no'];
									$pinno=$row25['pinno'];
									$companyid=$row25['Company_id'];
									$cust_enrollment_id=$row25['Enrollement_id'];
									$image_path=$row25['Photograph'];				
									$filename_get1=$image_path;	
									$Tier_name = $row25['Tier_name'];
									$lv_member_Tier_id = $row25['Tier_id'];
									$Total_reddems1 = $row25['Total_reddems'];
									
								}
								$Total_reddems = $Total_reddems1;
								$Current_balance = $bal;
					
								$Merchant_email_id = $_REQUEST["Merchant_email"];
						
								$result = $this->Merchant_api_model->Get_Seller($Merchant_email_id,$Company_id); //Get Merchant Details
								if($result!=NULL)
								{
									$seller_id = $result->Enrollement_id;
									$seller_fname = $result->First_name;
									$seller_lname = $result->Last_name;
									$seller_name = $seller_fname .' '. $seller_lname;
									$Seller_Redemptionratio = $result->Seller_Redemptionratio;
									$Purchase_Bill_no = $result->Purchase_Bill_no;
									$Sub_seller_admin = $result->Sub_seller_admin;
									$Sub_seller_Enrollement_id = $result->Sub_seller_Enrollement_id;
					   
										$tp_db = $Purchase_Bill_no;
										$len = strlen($tp_db);
										$str = substr($tp_db,0,5);
										$bill = substr($tp_db,5,$len);
						   
										$date = new DateTime();
										$lv_date_time=$date->format('Y-m-d H:i:s'); 
							  
										$lv_date_time2 = $date->format('Y-m-d'); 
							
										$Trans_type = 2;
										$Payment_type_id = 1;
										$Remarks = "Pos / Loyalty Transaction";
										
										if($Sub_seller_admin == 1) 
										{
										  $seller_id = $seller_id;
										}
										else 
										{
										  $seller_id = $Sub_seller_Enrollement_id;
										}
										/*** Get Loyalty Rule ****/
										$loyalty_prog = $this->Merchant_api_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
										// var_dump($loyalty_prog);
									
										$points_array = array();
										if($loyalty_prog != NULL )
										{
											foreach($loyalty_prog as $prog)
											{
												$member_Tier_id = $lv_member_Tier_id;
												
												$value = array();
												$dis = array();
												
												$LoyaltyID_array = array();
												$Loyalty_at_flag = 0;	
												$lp_type=substr($prog['Loyalty_name'],0,2);											
													
												$Todays_date = $lv_date_time;
												
												$lp_details = $this->Merchant_api_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);	
											
											
												$lp_count = count($lp_details);
												// if($lp_details != NULL)
												// {

												foreach($lp_details as $lp_data)
												{
													$LoyaltyID = $lp_data['Loyalty_id'];
													$lp_name = $lp_data['Loyalty_name'];
													$lp_From_date = $lp_data['From_date'];
													$lp_Till_date = $lp_data['Till_date'];
													$Loyalty_at_value = $lp_data['Loyalty_at_value'];
													$Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
													$discount = $lp_data['discount'];
													$lp_Tier_id = $lp_data['Tier_id'];
													
													 // echo 'loyalty_id----'.$LoyaltyID;
													 // die;
													if($lp_Tier_id == 0)
													{
														$member_Tier_id = $lp_Tier_id;
													}
													
													if($Loyalty_at_value > 0)
													{
														$value[] = $Loyalty_at_value;	
														$dis[] = $discount;
														$LoyaltyID_array[] = $LoyaltyID;
														
														$Loyalty_at_flag = 1;
													}
													
													if($Loyalty_at_transaction > 0)
													{
														$value[] = $Loyalty_at_transaction;	
														$dis[] = $Loyalty_at_transaction;
														$LoyaltyID_array[] = $LoyaltyID;
														
														$Loyalty_at_flag = 2;
													}
												}
												if($lp_type == 'PA')
												{
													$transaction_amt = $_REQUEST["Purchase_amount"];
												}
												
												if($lp_type == 'BA')
												{
													// $transaction_amt = $_REQUEST["Balance_to_pay"];
													$transaction_amt = $Balance_to_pay;
												}
										
												if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
												{
													
													for($i=0;$i<=count($value)-1;$i++)
													{
													   
														if($i<count($value)-1 && $value[$i+1] != "")
														{
															if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
															{
																$loyalty_points = $this->Merchant_api_model->get_discount($transaction_amt,$dis[$i]);
																
																$trans_lp_id = $LoyaltyID_array[$i];
																
																$gained_points_fag = 1;
																
																$points_array[] = $loyalty_points;
																
																if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
																{
																	
																	$child_data = array(					
																	'Company_id' => $Company_id,        
																	'Transaction_date' => $lv_date_time,       
																	'Seller' => $seller_id,
																	'Enrollement_id' => $cust_enrollment_id,
																	'Transaction_id' => 0,
																	'Loyalty_id' => $trans_lp_id, 
																	//'Loyalty_id' => 0,
																	'Reward_points' => $loyalty_points,
																	);
																	
																	$child_result = $this->Merchant_api_model->insert_loyalty_transaction_child($child_data);
																}
															}
														}
														else if($transaction_amt > $value[$i])
														{
														
															$loyalty_points = $this->Merchant_api_model->get_discount($transaction_amt,$dis[$i]);
																
															$gained_points_fag = 1;
															
															$trans_lp_id = $LoyaltyID_array[$i];
															
															$points_array[] = $loyalty_points;
															
															if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
																{
																	
																	$child_data = array(					
																	'Company_id' => $Company_id,        
																	'Transaction_date' => $lv_date_time,       
																	'Seller' => $seller_id,
																	'Enrollement_id' => $cust_enrollment_id,
																	'Transaction_id' => 0,
																	'Loyalty_id' => $trans_lp_id, 
																	'Reward_points' => $loyalty_points,
																	);
																	
																	$child_result = $this->Merchant_api_model->insert_loyalty_transaction_child($child_data);
																}
														}
													}
												}
												if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
												{	
													$loyalty_points = $this->Merchant_api_model->get_discount($transaction_amt,$dis[0]);
														
													$points_array[] = $loyalty_points;
													
													$gained_points_fag = 1;
													
													$trans_lp_id = $LoyaltyID_array[0];
													
													if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
													{
														
														$child_data = array(					
														'Company_id' => $Company_id,        
														'Transaction_date' => $lv_date_time,       
														'Seller' => $seller_id,
														'Enrollement_id' => $cust_enrollment_id,
														'Transaction_id' => 0,
														'Loyalty_id' => $trans_lp_id, 
														'Reward_points' => $loyalty_points,
														);
												
														$child_result = $this->Merchant_api_model->insert_loyalty_transaction_child($child_data);
													}
												}
												
											}
										}
									if($gained_points_fag == 1)
									{
										$total_loyalty_points1 = array_sum($points_array);
										$total_loyalty_points = round($total_loyalty_points1);
									}
									else
									{
										$total_loyalty_points = 0;
										$trans_lp_id = 0;
									}
										// $Promo_redeem_by = $_REQUEST['Promo_redeem_by'];
										$Promo_redeem_by = 0;
										
										if($Promo_redeem_by == 1) //******** Promo Code Redeem *********/
										{
										
											// $PromoCode = $_REQUEST['Promo_code'];
											// $PointsRedeem = $_REQUEST['promo_points_redeemed'];
											
											$PromoCode = 0;
											$PointsRedeem = 0;
											
											$promo_transaction_data = array(
											
											'Trans_type' => '7',
											'Topup_amount' => $PointsRedeem,
											'Company_id' => $Company_id,
											'Trans_date' => $lv_date_time,  
											'Bill_no' => $bill,  
											'Manual_billno' => $_REQUEST["Manual_bill_no"],   
											'remark2' => 'PromoCode Transaction-('.$PromoCode.')',
											'Card_id' => $CardId,
											'Seller_name' => $seller_name,
											// 'Seller' => $seller_id,
											'Seller' =>$seller_id,
											'Remarks' => $Remarks,
											'Enrollement_id' => $Customer_enroll_id
											);
											
											$insert_promo_transaction_id = $this->Transactions_model->insert_loyalty_transaction($promo_transaction_data);
											
											$post_data21 = array('Promo_code_status' =>'1');
											
											$update_promo_code = $this->Transactions_model->utilize_promo_code($Company_id,$PromoCode,$post_data21);
											
											// $TotalRedeemPoints = $TotalRedeemPoints + $PointsRedeem;
											
											$bill = $bill + 1;
										}
										//$Customer_enroll_id = $this->input->post('Enrollement_id');
										// $Gift_redeem_by = $_REQUEST["Gift_redeem_by"]; 
										$Gift_redeem_by = 0; 
										if($Gift_redeem_by == 1) //******** Gift Card Redeem *********/
										{  
					
											// $gift_reedem = $_REQUEST['gift_reedem'];
											// $GiftCardNo = $_REQUEST['GiftCardNo'];
											// $GiftBal = $_REQUEST['Balance'];
											$gift_reedem = 0;
											$GiftCardNo = 0;
											$GiftBal = 0;
											$current_gift_balance = $GiftBal - $gift_reedem;
											
											
											$gift_transaction_data = array(
											
											'Trans_type' => '4',
											'Purchase_amount' => $gift_reedem,
											'Redeem_points' => $gift_reedem,
											'Company_id' => $Company_id,
											'Trans_date' => $lv_date_time,  
											'Payment_type_id' => '1',
											'Card_id' => $CardId,
											// 'GiftCardNo' => $_REQUEST['GiftCardNo'],
											'GiftCardNo' => 0,
											'Bill_no' => $bill,  
											'Manual_billno' => $_REQUEST["Manual_bill_no"],
											'Seller_name' => $seller_name,
											'Seller' => $seller_id,
											'Remarks' => $Remarks,
											'Enrollement_id' => $Customer_enroll_id
											);
											
											$insert_gift_transaction = $this->Transactions_model->insert_loyalty_transaction($gift_transaction_data);
											
											
											$result32 = $this->Transactions_model->update_giftcard_balance($GiftCardNo,$current_gift_balance,$Company_id);
										
											// $TotalRedeemPoints = $TotalRedeemPoints + $gift_reedem;
											
											$bill = $bill + 1;
										}
											$data = array('Company_id' => $Company_id,
											'Trans_type' => '2',
											'Payment_type_id' => $Payment_type_id,
											'Manual_billno' => $_REQUEST["Manual_bill_no"],
											'Bill_no' => $bill,
											'Enrollement_id' => $cust_enrollment_id,
											'Card_id' => $CardId,
											'Seller' => $seller_id,
											'Seller_name' => $seller_name,
											'Trans_date' => $lv_date_time,
											'Remarks' => $Remarks,
											'Purchase_amount' => $_REQUEST["Purchase_amount"], 
											'Paid_amount' => $Balance_to_pay,
											'Redeem_points' => $_REQUEST["Redeem_points"],
											// 'GiftCardNo' => $_REQUEST['GiftCardNo'],
											'GiftCardNo' => 0,
											'Loyalty_pts' => $total_loyalty_points,
											'Loyalty_id' => $trans_lp_id, 
											'balance_to_pay' => $Balance_to_pay,	
										);
										
										$insert_transaction_id = $this->Merchant_api_model->purchase_transaction($data);
										
										$result11 = $this->Merchant_api_model->update_loyalty_transaction_child($Company_id,$lv_date_time,$seller_id,$cust_enrollment_id,$insert_transaction_id);
										
										/*********Update Current Balance*********/										
										
										$cid = $_REQUEST["Membership_id"];
										$redeem_point = $_REQUEST["Redeem_points"];
										$Update_Current_balance = round($Current_balance-$redeem_point+$total_loyalty_points);
										
										$Update_total_reddems = $Total_reddems + $redeem_point;
										
										$up = array('Current_balance' => $Update_Current_balance, 'Total_reddems' => $Update_total_reddems);
										
										$this->Merchant_api_model->update_transaction($up,$CardId,$Company_id);
										
										$bill_no = $bill + 1;
										$billno_withyear = $str.$bill_no;
										$result4 = $this->Transactions_model->update_billno($seller_id,$billno_withyear);
									
									$currency_details = $this->Igain_model->Get_Country_master($result->Country);
									$Symbol_currency = $currency_details->Symbol_of_currency;	
									
									if($insert_transaction_id > 0)
									{  
										// $Notification_type ='Pos / Loyalty Transation with '.$Company_name1;
										$Notification_type ='Pos Purchase';
										$Email_content = array(
												'Today_date' => $lv_date_time,
												'Manual_bill_no' => $_REQUEST["Manual_bill_no"],
												'Purchase_amount' => number_format($_REQUEST["Purchase_amount"], 2),
												'Redeem_points' => $_REQUEST["Redeem_points"],
												'Payment_by' => 1,
												'Balance_to_pay' => number_format($Balance_to_pay, 2),
												'Total_loyalty_points' => $total_loyalty_points,
												'Symbol_currency' => $Symbol_currency,
												// 'GiftCardNo' => $_REQUEST['GiftCardNo'],
												// 'gift_reedem' => $_REQUEST['gift_reedem'],
												'GiftCardNo' => 0,
												'gift_reedem' => 0,
												'Notification_type' => $Notification_type,
												'Template_type' => 'Loyalty_transaction'
											);
										
										$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,$seller_id,$Company_id);
										
										$Updateed_Balance=$Update_Current_balance-($Blocked_points+$Debit_points);	
									
										if($Updateed_Balance<0)
										{
											$Available_Balance=0; 
										}
										else
										{
											$Available_Balance=$Updateed_Balance;
										}
										$Current_points = round($Current_balance-$redeem_point);
										
										$Update_Current_balance = round($Current_balance-$redeem_point + $total_loyalty_points);
										$Result123 = array(
													"Error_flag" => 1001,
													"Current_points" => $Current_points,
													"Gained_points" => $total_loyalty_points,
													"Balance_points" => $Available_Balance 
												);
												
											echo json_encode($Result123); //Pos Loyalty Transaction done Successfully.
											exit;
									}
									else    
									{
										$Result124 = array(
													"Error_flag" => 2068
												);
												
											echo json_encode($Result124);  // Loyalty Transaction Failed
											exit;
									}
								}
								else
								{
									$Result3100 = array(
													"Error_flag" => 2009
												);
												
									echo json_encode($Result3100); //Unable to Locate Merchant Email id 
									exit;
								}
							}
							else
							{
								$Result127 = array(
													"Error_flag" => 2003
												);
												
								echo json_encode($Result127); //Unable to Locate membership id
								exit;
							}
						}
						else if($Api_type == 2) // Update Order Status
						{  					
							$Merchant_email = $_REQUEST['Merchant_email'];
							$Membership_id = $_REQUEST['Membership_id'];
							$Order_no = $_REQUEST['Online_Order_no'];
							$Manual_bill_no = $_REQUEST['Manual_bill_no'];
							$Pos_outlet_id = $_REQUEST["Outlet_id"];
							$Pos_bill_date_time = $_REQUEST["Bill_date_time"];
							
							$result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Seller_name = $result1->First_name.' '.$result1->Last_name;
								$Seller_email = $result1->User_email_id;
								$timezone_entry=$result1->timezone_entry; 
								
								$timezone = new DateTimeZone($timezone_entry);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
								
								$currency_details = $this->Igain_model->Get_Country_master($result1->Country);
								$Symbol_of_currency = $currency_details->Symbol_of_currency;	
								
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
								
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								
								if($result!=NULL)
								{							
									$Cust_enrollement_id = $result->Enrollement_id;
									$Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}else {
										$Current_point_balance=$Current_point_balance;
									}
									
									$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
											
								
									$result_order = $this->Merchant_api_model->Get_order_evouchers_details($Order_no,$Manual_bill_no,$Company_id,$Card_id,$Pos_outlet_id,$Pos_bill_date_time);
									
									if($result_order!=NULL)
									{
										$Shipping_partner = $this->Merchant_api_model->Get_Shipping_partner($Company_id);
										if($Shipping_partner!=NULL)
										{
											foreach($Shipping_partner as $spart)
											{									
												$Shipping_Partner_id = $spart['Partner_id'];
												$Shipping_Partner_name = $spart['Partner_name'];
											}
										}
										
										$Item_details_array = array();
										$Loyalty_pts = array();
										foreach($result_order as $row)
										{ 
											$Item_name=$row->Merchandize_item_name;
											$Item_quantity=$row->Quantity;
											$Item_voucher_no=$row->Voucher_no;
											$Item_purchase_amount=$row->Purchase_amount;
											$Item_loyalty_pts=$row->Loyalty_pts;
											$Trans_date=$row->Trans_date;
											$Bill_no=$row->Bill_no;
											$Shipping_cost=$row->Shipping_cost;
											$Condiments_name=$row->Condiments_name;
											$Manual_billno=$row->Manual_billno;
											$Seller1=$row->Seller;
											$Order_type=$row->Order_type;
											
											$Item_details = array("Order_no" => $Order_no, "Item_name" =>$Item_name,"Quantity" => $Item_quantity, "Voucher_no" => $Item_voucher_no, "Purchase_amount" => $Item_purchase_amount, "Loyalty_points" => $Item_loyalty_pts, "Condiments_name" =>$Condiments_name, "Shipping_cost" => $Shipping_cost);
											
											$Item_details_array[] =$Item_details;
											$Loyalty_pts[]=$Item_loyalty_pts;
										}
										
										$Update_date=date("Y-m-d H:i:s");
										// $Order_date=date("F j, Y",strtotime($Trans_date));
										$Order_date=$Trans_date;
										$Update_date1=date("F j, Y, g:i A",strtotime($Update_date));
										
										$data2=array(
														"Voucher_status"=>20, // Delivered
														"Shipping_partner_id"=>$Shipping_Partner_id,
														"Update_User_id"=>$Seller_id,
														// "Manual_billno"=>$Manual_bill_no,
														"Update_date"=>$lv_date_time
													);
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no,$Pos_outlet_id,$Pos_bill_date_time);
										
										$Creadited_points1 = array_sum($Loyalty_pts);
										
										$Creadited_points = round($Creadited_points1);
										
										$Update_Current_balance= $Current_balance+$Creadited_points;
										
										$up = array('Current_balance' => $Update_Current_balance);
										
										$this->Merchant_api_model->update_transaction($up,$Card_id,$Company_id);
								
										$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_enrollement_id);
							
										$Current_balance1 = $Enroll_details->Current_balance;
										$Blocked_points1 = $Enroll_details->Blocked_points;
										$Debit_points1 = $Enroll_details->Debit_points;
										$Member_name = $Enroll_details->First_name.' '.$Enroll_details->Middle_name.' '.$Enroll_details->Last_name;
										$Current_point_balance1 = $Current_balance1 - ($Blocked_points1 + $Debit_points1);

										if ($Current_point_balance1 < 0) 
										{
											$Current_point_balance = 0;
										}
										else 
										{
											$Current_point_balance = $Current_point_balance1;
										}
										if($Order_type== 28)
										{
											$Order_type1 = "Pick-Up";
											$OrderStatus = "Collected";
										}
										else if($Order_type== 29)
										{
											$Order_type1 = "Delivery";
											$OrderStatus = "Delivered";
										}
										else if($Order_type== 107)
										{
											$Order_type1 = "In-Store";
											$OrderStatus = "Collected";
										}
										else
										{
											$Order_type1 = "";
											$OrderStatus = "";
										}
										
										$POS_bill_no = $Manual_billno;
					
										if($POS_bill_no == NULL)
										{
											$POS_bill_no='-';
										}
										
										$Outlet_details = $this->Igain_model->get_enrollment_details($Seller1);
					
										$Outlet_name=$Outlet_details->First_name.' '.$Outlet_details->Last_name;
										
										/**********************Send Email Notification to Customer*************************/
									
										$banner_image=$this->config->item('base_url').'/images/fulfillment.jpg';	

										$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_name1;

										$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
										$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
										<head>
												<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										</head>';

										$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';

										$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
										<tr>
											<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
										<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
										</tr>

										<tr>
											<td vAlign=top>
												<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px solid #d2d6de" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
												<tr>
													<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
													<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
														<tr style="HEIGHT: 10px">
															<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
																<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																	<tr>
																		<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																		<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																			<tr>
																				<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																						<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=680 height=200 hspace="0" vspace="0">
																				</td>
																			</tr>
																		</table>
																		</td>
																	</tr>
																</table> 

																<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
																Dear '.$Member_name.' ,
																</P>';
																$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
																
																Thank you for placing your Online Order.<br>';
																if($Order_type== 28)
																{
																	$html.='<br>';
																}
																if($Order_type== 107)
																{
																	$html.='<br>';
																}
																if($Order_type== 29)
																{
																	$html.='Your Order is now out for Delivery <br><br>';
																}
																/*Thank you for your recent purchase with us. (Refer , Order No. : <b>'. $Order_no.'</b> on <b>'.$Order_date.'</b>) Your item(s) has been Delivered.<br><br>';
																
																/*As part of the ongoing Campaign in the Loyalty Program, for your above purchase, you are entitled to earned <b> '.$Creadited_points.'</b> '.$Comapany_Currency.'
																So, now your Current Balance is : <b>'.$Current_point_balance.'</b> '.$Comapany_Currency.'<br><br>	
																
																$html.='Please see details below :<br> <br> */
																
																$html.='<strong>Order Date &nbsp;&nbsp;:</strong> '.$Order_date. '<br>
																<strong>Order No. &nbsp;&nbsp;&nbsp;&nbsp;:</strong> '.$Order_no. '<br>
																<strong>POS Bill No. :</strong> '.$POS_bill_no. '<br>
																<strong>Order Type &nbsp;&nbsp;:</strong> '.$Order_type1. '<br>
																<strong>Outlet Name :</strong> '.$Outlet_name. '<br><br>
																</P>';
												
																
																$html.='<div class="table-responsive">				
																<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"  border=0 cellSpacing=0 cellPadding=0 align=center> 
																<thead>
																</thead>
																<tbody>'; 
																
																$html .= '<TR>
																	   <TD style="border: #dbdbdb 2px ;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Sr.No.</b>
																	   </TD>
																	   
																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b>Menu Item</b>
																	   </TD>
																	   
																	    <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b> </b>
																		</TD>
																		
																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Quantity</b>
																	   </TD>

																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Total Price ('.$Symbol_of_currency.')</b> 
																	   </TD>';
																	   
																	  /* <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Delivery Cost ('.$Symbol_of_currency.')</b>
																		</TD>';
																		
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>'.$Comapany_Currency.' Earned </b>
																		</TD>*/
																	$html .= '</TR>';
																		
																	$i=1;
																	foreach($Item_details_array as $item_array)
																	{
																		$html .= '<TR>
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=center> '.$i.'
																																																							</TD>
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Item_name"].'
																																																							</TD>
																																																							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Condiments_name"].'
																																																							
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Quantity"].'
																			</TD>
																			
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Purchase_amount"].'
																			</TD>';
																			
																			/*<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Shipping_cost"].'
																			</TD>';
																			
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Loyalty_points"].'
																			</TD>*/
																		 $html .='</TR>';
																		$i++;
																	}

																	$html .='
																	</tbody>
																</TABLE>
																</div>												
																<br>';	
																
												$html .= '<br>
													<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													Regards,
													<br>'.$Company_name1.' Team.
													</P></td></tr></table></td></tr>

												<tr style="HEIGHT: 20px">
													<td class="row" style="margin-left:-12px;BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
																
												$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly;text-align:justify;" align="center">
												<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_name1.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
												If you are not the intended recipient or responsible for delivery to the intended recipient,
												you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_name1.' will not accept any claims for damages arising out of viruses.<br>
												Thank you for your cooperation.</em>
												</P> <br>';
												
												$html.='</td></tr></table></td></tr>';					
																							 
												$html.='</table>
													</td></tr><tr>
														<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
													</tr>
												</table>	
											</table>
											</body>
										</html>
										
										<style>
											td, th{
											font-size: 13px !IMPORTANT;
											}
										</style>';
										
										$Email_content = array(
													'Order_no' => $Bill_no,
													'Order_date' => $Order_date,
													'Update_date'  => $lv_date_time,
													'Update_details' => $html,
													'Notification_type' => 'Your '.$Company_name1.' Order #'.$Order_no.' has been '.$OrderStatus,
													'Template_type' => 'Update_online_order_status'
												);
												
										$Notification=$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id);
							
										/**********************Send Email Notification to Customer*************************/
										$Update_status = array(
												"Error_flag" => 1001,
												"Order_status" => 'Delivered',
												"Online_order_no" => $Bill_no, 
												"POS_bill_no" => $Manual_bill_no, 
												"Membership_id" => $Card_id,
												"Gained_points" => $Creadited_points, 
												"Balance_points" => $Current_point_balance
											);
										
										echo json_encode($Update_status);  // Order Successfully Delivered
										exit;
									}
									else
									{
										$Result11 = array("Error_flag" => 3011); //Invalid Order no. / Order not found
										echo json_encode($Result11);
										exit;
									}
								}
								else    
								{
									$Result127 = array("Error_flag" => 2003); //Unable to Locate membership id
									echo json_encode($Result127);
									exit;
								}
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009);
								echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
								exit;
							}
						}
					}
					/*************Pos_Purchase_Transaction_API **********************/
					/*********************Update Order Status*********************/
					if($API_flag == 86)
					{ 
						// $Merchant_email = $_REQUEST['Merchant_email'];
						// $Membership_id = $_REQUEST['Membership_id'];
						// $Order_no = $_REQUEST['Online_order_no'];
						// $Manual_bill_no = $_REQUEST['Manual_bill_no'];
						// $Order_status_id = $_REQUEST['Order_status'];
						
						$Outlet_no = $inputArgs['Outlet_no'];
						$Membership_id = $inputArgs['Membership_id'];
						$Order_no = $inputArgs['Online_order_no'];
						$Manual_bill_no = $inputArgs['Bill_no'];
						$Order_status_id = $inputArgs['Order_status'];
						$Pos_bill_date_time = $inputArgs['Bill_date_time'];
						
						/* $headers = getallheaders();  
						$api_key = $headers['api_key'];
						$Authorization = $headers['Authorization'];
						echo "api_key--------".$api_key;
						echo "Authorization--------".$Authorization; die;  */
						
						if($Order_status_id == 20) // For Delivered / Collected
						{ 
							// $result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							
							$result1 = $this->Merchant_api_model->Get_outlet_details($Outlet_no,$Company_id); //Get Outlet Details
								
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Seller_name = $result1->First_name.' '.$result1->Last_name;
								$Seller_email = $result1->User_email_id;
								$timezone_entry=$result1->timezone_entry; 
								
								$timezone = new DateTimeZone($timezone_entry);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
								
								$currency_details = $this->Igain_model->Get_Country_master($result1->Country);
								$Symbol_of_currency = $currency_details->Symbol_of_currency;	
								
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
								
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								
								if($result!=NULL)
								{							
									$Cust_enrollement_id = $result->Enrollement_id;
									$Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}else {
										$Current_point_balance=$Current_point_balance;
									}
									
									$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
											
								
									$result_order = $this->Merchant_api_model->Get_order_evouchers_details($Order_no,$Manual_bill_no,$Company_id,$Card_id,$Outlet_no,$Pos_bill_date_time);
									
									if($result_order!=NULL)
									{
										$Shipping_partner = $this->Merchant_api_model->Get_Shipping_partner($Company_id);
										if($Shipping_partner!=NULL)
										{
											foreach($Shipping_partner as $spart)
											{									
												$Shipping_Partner_id = $spart['Partner_id'];
												$Shipping_Partner_name = $spart['Partner_name'];
											}
										}
										
										$Item_details_array = array();
										$Loyalty_pts = array();
										foreach($result_order as $row)
										{ 
											$Item_name=$row->Merchandize_item_name;
											$Item_quantity=$row->Quantity;
											$Item_voucher_no=$row->Voucher_no;
											$Item_purchase_amount=$row->Purchase_amount;
											$Item_loyalty_pts=$row->Loyalty_pts;
											$Trans_date=$row->Trans_date;
											$Bill_no=$row->Bill_no;
											$Shipping_cost=$row->Shipping_cost;
											$Condiments_name=$row->Condiments_name;
											$Manual_billno=$row->Manual_billno;
											$Seller1=$row->Seller;
											$Order_type=$row->Order_type;
											
											$Item_details = array("Order_no" => $Order_no, "Item_name" =>$Item_name,"Quantity" => $Item_quantity, "Voucher_no" => $Item_voucher_no, "Purchase_amount" => $Item_purchase_amount, "Loyalty_points" => $Item_loyalty_pts, "Condiments_name" =>$Condiments_name, "Shipping_cost" => $Shipping_cost);
											
											$Item_details_array[] =$Item_details;
											$Loyalty_pts[]=$Item_loyalty_pts;
										}
										
										$Update_date=date("Y-m-d H:i:s");
										// $Order_date=date("F j, Y",strtotime($Trans_date));
										$Order_date=$Trans_date;
										$Update_date1=date("F j, Y, g:i A",strtotime($Update_date));
										
										$data2=array(
														"Voucher_status"=>20, // Delivered
														"Shipping_partner_id"=>$Shipping_Partner_id,
														"Update_User_id"=>$Seller_id,
														// "Manual_billno"=>$Manual_bill_no,
														"Update_date"=>$lv_date_time
													);
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no,$Outlet_no,$Pos_bill_date_time);
										
										$Creadited_points1 = array_sum($Loyalty_pts);
										
										$Creadited_points = round($Creadited_points1);
										
										$Update_Current_balance= $Current_balance+$Creadited_points;
										
										$up = array('Current_balance' => $Update_Current_balance);
										
										$this->Merchant_api_model->update_transaction($up,$Card_id,$Company_id);
								
										$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_enrollement_id);
							
										$Current_balance1 = $Enroll_details->Current_balance;
										$Blocked_points1 = $Enroll_details->Blocked_points;
										$Debit_points1 = $Enroll_details->Debit_points;
										$Member_name = $Enroll_details->First_name.' '.$Enroll_details->Middle_name.' '.$Enroll_details->Last_name;
										$Current_point_balance1 = $Current_balance1 - ($Blocked_points1 + $Debit_points1);

										if ($Current_point_balance1 < 0) 
										{
											$Current_point_balance = 0;
										}
										else 
										{
											$Current_point_balance = $Current_point_balance1;
										}
										if($Order_type== 28)
										{
											$Order_type1 = "Pick-Up";
											$OrderStatus = "Collected";
										}
										else if($Order_type== 29)
										{
											$Order_type1 = "Delivery";
											$OrderStatus = "Delivered";
										}
										else if($Order_type == 107)
										{
											$Order_type1 = "In-Store";
											$OrderStatus = "Collected";
										}
										else
										{
											$Order_type1 = "";
											$OrderStatus = "";
										}
										
										$POS_bill_no = $Manual_billno;
					
										if($POS_bill_no == NULL)
										{
											$POS_bill_no='-';
										}
										
										$Outlet_details = $this->Igain_model->get_enrollment_details($Seller1);
					
										$Outlet_name=$Outlet_details->First_name.' '.$Outlet_details->Last_name;
										
										/**********************Send Email Notification to Customer*************************/
									
										$banner_image=$this->config->item('base_url').'/images/fulfillment.jpg';	

										$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_name1 ;

										$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
										$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
										<head>
												<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										</head>';

										$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';

										$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
										<tr>
											<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
										<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
										</tr>

										<tr>
											<td vAlign=top>
												<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px solid #d2d6de" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
												<tr>
													<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
													<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
														<tr style="HEIGHT: 10px">
															<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
																<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																	<tr>
																		<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																		<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																			<tr>
																				<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																						<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=680 height=200 hspace="0" vspace="0">
																				</td>
																			</tr>
																		</table>
																		</td>
																	</tr>
																</table> 

																<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
																Dear '.$Member_name.' ,
																</P>';
																$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>';
																
																/*Thank you for placing your Online Order.<br>';*/
																if($Order_type== 28)
																{
																	$html.='<br>';
																}
																if($Order_type== 107)
																{
																	$html.='<br>';
																}
																if($Order_type== 29)
																{
																	//$html.='Your Order is now out for Delivery <br><br>';
																}
																$html.='Thank you for your recent purchase with us. (Refer , Order No. : <b>'. $Bill_no.'</b> on <b>'.$Order_date.'</b>) Your item(s) has been '.$OrderStatus.'.<br><br>
																
																As part of the ongoing Campaign in the Loyalty Program, for your above purchase, you are entitled to earned <b> '.$Creadited_points.'</b> '.$Comapany_Currency.'
																So, now your Current Balance is : <b>'.$Current_point_balance.'</b> '.$Comapany_Currency.'<br><br>';	
																
																$html.='Please see details below :<br> <br>';
																
																$html.='<strong>Order Date &nbsp;&nbsp;:</strong> '.$Order_date. '<br>
																<strong>Order No. &nbsp;&nbsp;&nbsp;&nbsp;:</strong> '.$Bill_no. '<br>
																<strong>POS Bill No. :</strong> '.$POS_bill_no. '<br>
																<strong>Order Type &nbsp;&nbsp;:</strong> '.$Order_type1. '<br>
																<strong>Outlet Name :</strong> '.$Outlet_name. '<br><br>
																</P>';
												
																
																$html.='<div class="table-responsive">				
																<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"  border=0 cellSpacing=0 cellPadding=0 align=center> 
																<thead>
																</thead>
																<tbody>'; 
																
																$html .= '<TR>
																	   <TD style="border: #dbdbdb 2px ;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Sr.No.</b>
																	   </TD>
																	   
																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b>Menu Item</b>
																	   </TD>
																	   
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b> </b>
																		</TD>
																		
																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Quantity</b>
																	   </TD>

																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Total Price ('.$Symbol_of_currency.')</b> 
																	   </TD>';
																	   
																	  /* <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Delivery Cost ('.$Symbol_of_currency.')</b>
																		</TD>
																		
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>'.$Comapany_Currency.' Earned </b>
																		</TD>';*/
																	$html .= '</TR>';
																		
																	$i=1;
																	foreach($Item_details_array as $item_array)
																	{
																		$html .= '<TR>
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=center> '.$i.'
																																																							</TD>
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Item_name"].'
																																																							</TD>
																																																							<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Condiments_name"].'
																																																							
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Quantity"].'
																			</TD>
																			
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Purchase_amount"].'
																			</TD>';
																			
																			/*<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Shipping_cost"].'
																			</TD>
																			
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Loyalty_points"].'
																			</TD>';*/
																		 $html .='</TR>';
																		$i++;
																	}

																	$html .='
																	</tbody>
																</TABLE>
																</div>												
																<br>';	
																
												$html .= '<br>
													<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													Regards,
													<br>'.$Company_name1.' Team.
													</P></td></tr></table></td></tr>

												<tr style="HEIGHT: 20px">
													<td class="row" style="margin-left:-12px;BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
																
												$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly;text-align:justify;" align="center">
												<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_name1.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
												If you are not the intended recipient or responsible for delivery to the intended recipient,
												you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_name1.' will not accept any claims for damages arising out of viruses.<br>
												Thank you for your cooperation.</em>
												</P> <br>';
												
												$html.='</td></tr></table></td></tr>';					
																							 
												$html.='</table>
													</td></tr><tr>
														<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
													</tr>
												</table>	
											</table>
											</body>
										</html>
										
										<style>
											td, th{
											font-size: 13px !IMPORTANT;
											}
										</style>';

										
										$Email_content = array(
													'Order_no' => $Bill_no,
													'Order_date' => $Order_date,
													'Update_date'  => $lv_date_time,
													'Update_details' => $html,
													'Notification_type' => 'Your '.$Company_name1.' Order #'.$Order_no.' has been '.$OrderStatus,
													'Template_type' => 'Update_online_order_status'
												);
												
										$Notification=$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id);
							
										/**********************Send Email Notification to Customer*************************/
										$Update_status = array(
												"Error_flag" => 1001,
												"Order_status" => $OrderStatus,
												"Online_order_no" => $Bill_no, 
												"POS_bill_no" => $Manual_bill_no, 
												"Membership_id" => $Card_id,
												"Gained_points" => $Creadited_points, 
												"Balance_points" => $Current_point_balance
											);
										
										echo json_encode($Update_status);  // Order Successfully Delivered
										exit;
									}
									else
									{
										$Result11 = array("Error_flag" => 3011); //Invalid Order no. / Order not found
										echo json_encode($Result11);
										exit;
									}
								}
								else    
								{
									$Result127 = array("Error_flag" => 2003); //Unable to Locate membership id
									echo json_encode($Result127);
									exit;
								}
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009);
								echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
								exit;
							}
						}
						else // For Accepted-111,Out for Delivery-19
						{
							// $result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							$result1 = $this->Merchant_api_model->Get_outlet_details($Outlet_no,$Company_id); //Get Outlet Details
								
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Seller_name = $result1->First_name.' '.$result1->Last_name;
								$Seller_email = $result1->User_email_id;
								$timezone_entry=$result1->timezone_entry; 
								
								$timezone = new DateTimeZone($timezone_entry);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
								
								// $currency_details = $this->Igain_model->Get_Country_master($result1->Country);
								// $Symbol_of_currency = $currency_details->Symbol_of_currency;	
								
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
								
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								
								if($result!=NULL)
								{							
									$Cust_enrollement_id = $result->Enrollement_id;
									$Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}else {
										$Current_point_balance=$Current_point_balance;
									}	
								
									$result_order = $this->Merchant_api_model->Get_online_order_details($Order_no,$Manual_bill_no,$Company_id,$Card_id,$Outlet_no,$Pos_bill_date_time);
									
									if($result_order!=NULL)
									{
										$Trans_date = $result_order->Trans_date;
										$Shipping_partner = $this->Merchant_api_model->Get_Shipping_partner($Company_id);
										if($Shipping_partner!=NULL)
										{
											foreach($Shipping_partner as $spart)
											{									
												$Shipping_Partner_id = $spart['Partner_id'];
												$Shipping_Partner_name = $spart['Partner_name'];
											}
										}
										// $Order_date=date("F j, Y",strtotime($Trans_date));
										$Order_date=$Trans_date;
										
										$data2=array(
														"Voucher_status"=>$Order_status_id,
														"Shipping_partner_id"=>$Shipping_Partner_id,
														"Update_User_id"=>$Seller_id,
														"Update_date"=>$lv_date_time
													);
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no,$Outlet_no,$Pos_bill_date_time);
										
										if($Order_status_id == 111) // Accepted
										{
											$Order_status1="Accepted"; // Kichen Accepted Order
										}
										else if($Order_status_id == 19)
										{
											$Order_status1="Out for Delivery"; // Order Out For Delivery
										}
										else
										{
											$Order_status1=" 	";	
										}
										
										if($result == true)
										{
											$Update_status = array(
													"Error_flag" => 1001,
													"Order_status" => $Order_status1,
													"Online_order_no" => $Order_no, 
													"POS_bill_no" => $Manual_bill_no, 
													"Membership_id" => $Card_id,
													"Gained_points" => 0, 
													"Balance_points" => $Current_point_balance
												);
											
											echo json_encode($Update_status);  // Order Successfully Updated
											exit;
										}
										else
										{
											$Update_status = array(
													"Error_flag" => 2068,
													"Order_status" => '',
													"Online_order_no" => $Order_no, 
													"POS_bill_no" => $Manual_bill_no, 
													"Membership_id" => $Card_id,
													"Gained_points" => 0, 
													"Balance_points" => $Current_point_balance
												);
											
											echo json_encode($Update_status);  // Order not updated
											exit;
										}
									}
									else
									{
										$Result11 = array("Error_flag" => 3011); //Invalid Order no. / Order not found
										echo json_encode($Result11);
										exit;
									}
								}
								else    
								{
									$Result127 = array("Error_flag" => 2003); //Unable to Locate membership id
									echo json_encode($Result127);
									exit;
								}
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009);
								echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
								exit;
							}
						}
						
					}
					if($API_flag == 87) // new development apply discount rule for artcaffe
					{
						$API_flag_call = 87;
						// $Merchant_email = $inputArgs['Merchant_email'];
						$Membership_id = $inputArgs['Membership_id'];
						$Item_details = $inputArgs['Bill_Items'];
						$Outlet_no = $inputArgs['Outlet_No']; //POS Outlet
						$Pos_discount = $inputArgs['POS_Discount']; //POS Outlet
							
						$Pos_discount = str_replace( ',', '', $Pos_discount);
						
							// $result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							$result1 = $this->Merchant_api_model->Get_outlet_details($Outlet_no,$Company_id); //Get Outlet Details
								
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Seller_name = $result1->First_name.' '.$result1->Last_name;
								$Seller_email = $result1->User_email_id;
								$timezone_entry=$result1->timezone_entry; 
								$Sub_seller_admin = $result1->Sub_seller_admin;
								$Sub_seller_Enrollement_id = $result1->Sub_seller_Enrollement_id;
								
								if($Sub_seller_admin == 1) 
								{
									$delivery_outlet = $Seller_id;
								}
								else 
								{
									$delivery_outlet = $Sub_seller_Enrollement_id;
								}
								
								$timezone = new DateTimeZone($timezone_entry);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
								
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
								
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								
								if($result!=NULL)
								{
									if($result == 3111)
									{
										$Result1311 = array("Error_flag" => 3111, "Message" =>'Customer code expired'); 
										echo json_encode($Result1311);
										exit;		
									}									
									$Cust_enrollement_id = $result->Enrollement_id;
									$Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									$Tier_id = $result->Tier_id;
									$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
								
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}
									else 
									{
										$Current_point_balance=$Current_point_balance;
									}
								/*******************sandeep declare variable*******************/
									$order_sub_total = 0;	
									$shipping_cost = 0;
									$DiscountAmt = 0;
									$TotalvoucherAmt = 0;
									$TotalDiscountAmt = 0;
									$tax = 0;	
									$i = 0;
								/*******************sandeep declare variable*******************/
									foreach($Item_details as $item)
									{ 
										$ItemCode = $item['Item_Num']; 
										$ItemQty = $item['Item_Qty']; 
										$Item_price = $item['Item_Rate'];
										
										$Item_price = str_replace( ',', '', $Item_price);
										
										// $Item_details1 = array("ItemCode" => $ItemCode, "ItemQty" =>$ItemQty,"ItemRate" => $Item_price);
										// $Item_details_array[] = $Item_details1;
									
										/****************sandeep discount logic 27-01-2020******************/
											$Item_price = $Item_price * $ItemQty;
											$order_sub_total = $order_sub_total + $Item_price;
											$i++;
											
										/*******************get item details*******************/
											$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
											if($ItemDetails !=NULL)
											{
												$Itemcategory_id = $ItemDetails->Merchandize_category_id;
												/***************11-7-2020*************/
												$Itemcategory_ids[] = $ItemDetails->Merchandize_category_id;
												$Itemcategory_price[$Itemcategory_id] = $item['Item_Rate'] * $item['Item_Qty'];
												/***************11-7-2020*************/
											}
											else
											{
												$ResponseData = array("Error_flag" => 3103,
																	  "Message" => "Invalid Item_Num Or Item not exist.",
																	  "Item_Num" => $ItemCode
																	); // Item not found or invalid item code
												echo json_encode($ResponseData);
												exit;
											}
										/*******************get item details*******************/
										
											// $DiscountResult = $this->Merchant_api_model->get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,0,$API_flag_call);
											/************11-7-2020***********/
											$DiscountResult = $this->Merchant_api_model->get_discount_value("",$ItemCode,$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,0,$API_flag_call);
											
											/************11-7-2020***********/
											$DisOpt = json_decode($DiscountResult,true);
					
											/* if($DisOpt["voucherAmt"] > 0)
											{
												$TotalvoucherAmt = floor($TotalvoucherAmt + $DisOpt["voucherAmt"]);	
											} */
											
											if($DisOpt["DiscountAmt"] > 0)
											{
												// $TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt["DiscountAmt"]);
												$TotalDiscountAmt = floor($TotalDiscountAmt + str_replace( ',', '', $DisOpt["DiscountAmt"]));
												
												/************11-7-2020***********/
													$ItemDiscounts[$ItemCode] = $DisOpt["DiscountAmt"];
												/************11-7-2020***********/
											}
											
											if(!empty($DisOpt["discountsArray"]) && is_array($DisOpt["discountsArray"]))
											{
												// $Discount_codes[] = $DisOpt["discountsArray"];
												foreach($DisOpt["discountsArray"] as $k1)
												{
													$Discount_codes[] = $k1;
												}
											}
											if(!empty($DisOpt["discountsArray2"]) && is_array($DisOpt["discountsArray2"]))
											{
												foreach($DisOpt["discountsArray2"] as $k2)
												{
													$Discount_codes_2[] = $k2;
												}
											}
										///****************sandeep discount logic 27-01-2020*********************
									}
									/********************11-7-2020******************/
									$Itemcategory_ids = array_unique($Itemcategory_ids);
									
									foreach($Itemcategory_ids as $Itemcategory_id)
									{
										// $CatDiscountResult = $this->Merchant_api_model->get_category_discount_value($Itemcategory_id,"",$Item_price,$data['Company_id'],$BrandOutlet_Id,$data['enroll'],$Tier_id,0,0);
										
										$Item_price = $Itemcategory_price[$Itemcategory_id];
										
										$CatDiscountResult = $this->Merchant_api_model->get_category_discount_value($Itemcategory_id,"",$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,0,0,$API_flag_call);
											
											$DisOpt22 = json_decode($CatDiscountResult,true);
											// print_r($DisOpt22);
											
											if($DisOpt22["DiscountAmt"] > 0)
											{
												$TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt22["DiscountAmt"]);
												//***** 18-03-2020 ************
											}
											
											if(!empty($DisOpt22["discountsArray"]) && is_array($DisOpt22["discountsArray"]))
											{
												//$Discount_codes[] = $DisOpt["discountsArray"];
													foreach($DisOpt22["discountsArray"] as $k1)
													{
														$Discount_codes[] = $k1;
													}
											}
											// print_r($Discount_codes);
											
											if(!empty($DisOpt22["discountsArray2"]) && is_array($DisOpt22["discountsArray2"]))
											{
												foreach($DisOpt22["discountsArray2"] as $k2)
												{
													$Discount_codes_2[] = $k2;
												}
											}
									}
									///**************** sandeep category discount logic 27-01-2020 ***************************
									/********************11-7-2020******************/
									
									$DiscountResult12 = $this->Merchant_api_model->get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,$order_sub_total,$API_flag_call);
									
									$DisOpt12 = json_decode($DiscountResult12,true);
									
									/* if($DisOpt12["voucherAmt"] > 0)
									{
										$TotalvoucherAmt = floor($TotalvoucherAmt + $DisOpt12["voucherAmt"]);	
									} */
									
									if($DisOpt12["DiscountAmt"] > 0)
									{
										// $TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt12["DiscountAmt"]);
										// $TotalDiscountAmt = floor($TotalDiscountAmt + str_replace( ',', '', $DisOpt12["DiscountAmt"]));
										
										/***************11-7-2020****************/
										$number2 = filter_var($DisOpt12["DiscountAmt"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);//1989.34
										// $TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt12["DiscountAmt"]);
										// $TotalDiscountAmt = ($TotalDiscountAmt + $number2);
										$TotalDiscountAmt = ($TotalDiscountAmt + str_replace( ',', '', $number2));
										
										//***** 18-03-2020 ************	
										
										$_SESSION['BillDiscount'] = $DisOpt12["DiscountAmt"];
										/***************11-7-2020****************/
									}
									
									if(!empty($DisOpt12["discountsArray"]) && is_array($DisOpt12["discountsArray"]))
									{
										// $Discount_codes[] = $DisOpt12["discountsArray"];
										foreach($DisOpt12["discountsArray"] as $k)
										{
											$Discount_codes[] = $k;
										}
									}
									
									/******************11-7-2020****************/
									if(!empty($DisOpt12["discountsArray2"]) && is_array($DisOpt12["discountsArray2"]))
									{
										foreach($DisOpt12["discountsArray2"] as $k2)
										{
											$Discount_codes_2[] = $k2;
										}
									}
									/******************11-7-2020****************/
								
									// $this->session->set_userdata('voucherAmt',$TotalvoucherAmt);
									
									if($DisOpt12["voucherValidity"] != null)
									{ 
										// $this->session->set_userdata('voucherValidity',$DisOpt12["voucherValidity"]);
									}
									// $voucherValidity = $this->session->userdata('voucherValidity');
									
									$voucherAmt = $this->session->userdata('voucherAmt');
									// echo "voucherAmt--".$voucherAmt;
										
									// echo "voucherValidity--".$voucherValidity;
									$TotalDiscountAmt = str_replace( ',', '', $TotalDiscountAmt);
									$DiscountAmt = $TotalDiscountAmt;
									// echo "DiscountAmt--".$data["DiscountAmt"];
									
									
									if(count($Discount_codes) > 0)
									{
										// print_r($Discount_codes);
										// $this->session->set_userdata('Discount_codes',$Discount_codes);
									}
								
									if($order_sub_total < $DiscountAmt)
									{
										$DiscountAmt = $order_sub_total;
									}
									$DiscountAmt = str_replace( ',', '', $DiscountAmt);
								///**************** sandeep discount logic 27-01-2020 ***************************		
									$order_total = ($order_sub_total + $shipping_cost + $tax) - $DiscountAmt;
									$order_total = $order_total - $Pos_discount;
									// $cart['shopping_cart']['grand_total'] = $order_total;
									
									
								/************************sandeep code end************************/
									$ResponseData = array("Error_flag" => 1001,
															"Card_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Bill_total" => number_format($order_sub_total,2),
															"POS_discount" => number_format($Pos_discount,2),
															"Discount_Amount" => number_format($DiscountAmt,2),
															"Balance_due" => number_format($order_total,2),
															'Discount_details' => $Discount_codes
														);
														
									echo json_encode($ResponseData);
									exit;									
								}
								else    
								{
									$Result127 = array("Error_flag" => 2003,"Message" => "Membership Id Not found."); //Unable to Locate membership id
									echo json_encode($Result127);
									exit;
								} 
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009);
								echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
								exit;
							}
					} 
					if($API_flag == 89) // Discount Voucher Used by Customer 
					{
						// $Merchant_email = $inputArgs['Merchant_email'];
						$Outlet_no = $inputArgs['Outlet_No']; //POS Outlet
						$Membership_id = $inputArgs['Membership_id'];
						$Bill_amount = $inputArgs['Bill_Total'];
						$Item_details = $inputArgs['Bill_Items'];
						$Voucher_Details = $inputArgs['Voucher_Details']; 
						$Discount_voucher_type = $Voucher_Details['Discount_voucher_type'];
						$Discount_voucher_code = $Voucher_Details['Voucher_No'];
						$Voucher_amount = $Voucher_Details['Voucher_Amount'];						
						$Voucher_Reference = $Voucher_Details['Voucher_Reference'];						
						$Loyalty_Discount = $inputArgs['Loyalty_Discount']; 
						$POS_Discount = $inputArgs['POS_Discount']; 
						
						$Bill_amount = str_replace( ',', '', $Bill_amount);
						$Voucher_amount = str_replace( ',', '', $Voucher_amount);
						$Loyalty_Discount = str_replace( ',', '', $Loyalty_Discount);
						$POS_Discount = str_replace( ',', '', $POS_Discount);
						
							// $result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							$result1 = $this->Merchant_api_model->Get_outlet_details($Outlet_no,$Company_id); //Get Outlet Details
								
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Seller_name = $result1->First_name.' '.$result1->Last_name;
								$Seller_email = $result1->User_email_id;
								$timezone_entry=$result1->timezone_entry; 
								$Sub_seller_admin = $result1->Sub_seller_admin;
								$Sub_seller_Enrollement_id = $result1->Sub_seller_Enrollement_id;
								
								if($Sub_seller_admin == 1) 
								{
									$Seller_id = $Seller_id;
								}
								else 
								{
									$Seller_id = $Sub_seller_Enrollement_id;
								}
								
								$timezone = new DateTimeZone($timezone_entry);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
								
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
								
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								
								if($result!=NULL)
								{	
									if($result == 3111)
									{
										$Result1311 = array("Error_flag" => 3111, "Message" =>'Customer code expired');
										echo json_encode($Result1311);
										exit;		
									}
									$Cust_enrollement_id = $result->Enrollement_id;
									$Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									$Tier_id = $result->Tier_id;
									$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
								
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}
									else 
									{
										$Current_point_balance=$Current_point_balance;
									}	
									/*******************api logic start********************/
									$Voucher_result = $this->Merchant_api_model->Validate_discount_voucher($Card_id,$Company_id,$Discount_voucher_code,$Voucher_amount);
									if($Voucher_result != Null)
									{
										$Gift_card_id = $Voucher_result->Gift_card_id;
										$Card_value = $Voucher_result->Card_value;
										$Card_balance = $Voucher_result->Card_balance;
										$Valid_till = $Voucher_result->Valid_till;
										$Card_Payment_Type_id = $Voucher_result->Payment_Type_id;
										$Discount_percentage = $Voucher_result->Discount_percentage;
										
										$Card_balance = str_replace( ',', '', $Card_balance);
										if($Card_Payment_Type_id == 997) //product voucher
										{	
											$Product_Voucher_Details = $this->Merchant_api_model->Get_Product_Voucher_Details($Gift_card_id,$Cust_enrollement_id,$Company_id);
											
											$Product_Voucher_item_code = $Product_Voucher_Details->Company_merchandize_item_code;
											$Product_Voucher_id = $Product_Voucher_Details->Voucher_id;
											$Product_Voucher_Offer_code = $Product_Voucher_Details->Offer_code;
										
											if($Product_Voucher_id ==0) // product voucher in percentage
											{
												$Cust_Item_Num = array();
												foreach($Item_details as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													
													$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
													
													if($ItemDetails !=NULL)
													{
														$Merchandize_item_code = $ItemDetails->Company_merchandize_item_code;
														$Item_name = $ItemDetails->Merchandize_item_name;
														
														$ItemCodeArr[$ItemCode]=$item['Item_Qty'];
														
														$Cust_Item_Num[] = $ItemCode;
														
														// $Pos_Item_details = array("Item_Num" => $ItemCode, "Item_Name" =>$Item_name,"Quantity" => $item['Item_Qty'], "Item_Rate" => $item['Item_Rate']);
												
														// $Pos_Item_details_array[] =$Pos_Item_details;
													}
													else
													{
														$ResponseData = array("Error_flag" => 3103,
																			  "Message" => "Invalid Item_Num Or Item not exist.",
																			  "Item_Num" => $ItemCode
																			); // Item not found or invalid item code
														echo json_encode($ResponseData);
														exit;
													}
												}
											/**********************stamp new logic 02-05-2021**************************/
												$Get_lowest_sent_vouchers= $this->Merchant_api_model->Get_lowest_sent_vouchers($Card_id,$Company_id,$Gift_card_id);
												// 1 Kenya Tea + 1 Chai latte + 1 Lemon Tea
												if($Get_lowest_sent_vouchers != NULL)
												{
													$RemQTY=0;
													$lv_Voucher_code=0;
													$lowest_flag=1;
													$newpricearr = array();
													foreach($Get_lowest_sent_vouchers as $rec1)
													{
														if($lowest_flag == 0 && $lv_Voucher_code != $rec1->Voucher_code)
														{
															$RemQTY=0;
															$lowest_flag=1;
															$newpricearr = array();
														}
														// echo "<br>Gift_card_id:: ".$rec1->Gift_card_id;
														$Cart_item_QTY=$ItemCodeArr[$rec1->Company_merchandize_item_code];
														
														// echo "<br>Cart_item_QTY:: ".$Cart_item_QTY;
														// echo "<br>Company_merchandize_item_code:: ".$rec1->Company_merchandize_item_code;
														// echo "<br>Cart_item_QTY:: ".$Cart_item_QTY;
														if(array_key_exists($rec1->Company_merchandize_item_code,$ItemCodeArr))
														{
															if($RemQTY!=0)//
															{
																if($Cart_item_QTY >= $RemQTY )
																{
																	$newpricearr[]=($RemQTY * $rec1->Voucher_Cost_price);//1*260=260
																	$Reduce_product_amt=array_sum($newpricearr);//220+260=480
																	$ApllicableVoucher_code[]=$rec1->Voucher_code;
																	
																	$data['Vouchers_price'][$rec1->Voucher_code] = $Reduce_product_amt;
																	$data['Discount_percentage'][$rec1->Voucher_code] = $rec1->Discount_percentage;
																	$data['Offer_name'][$rec1->Voucher_code] = $rec1->Offer_name;
																	$data['Voucher_Qty'][$rec1->Voucher_code] = $rec1->Voucher_Qty;
																	// echo "<br>".$Reduce_product_amt;
																	$lowest_flag=0;
																	$lv_Voucher_code=$rec1->Voucher_code;
																}
																/* if($Cart_item_QTY < $RemQTY  && $lowest_flag==1)
																{
																	$newpricearr[]=($Cart_item_QTY*$rec1->Voucher_Cost_price);//260
																	$RemQTY= ($rec1->Voucher_Qty-$Cart_item_QTY);//1
																} */
															}
															if($Cart_item_QTY < $rec1->Voucher_Qty && $RemQTY==0)//
															{
																$newpricearr[]=($Cart_item_QTY*$rec1->Voucher_Cost_price);//220
																// echo "<br>".$Cart_item_QTY*$rec1->Voucher_Cost_price;
																$RemQTY= ($rec1->Voucher_Qty-$Cart_item_QTY);//1
																// echo "<br>RemQTY ".$RemQTY;
																// echo "<br>lowest_flag ".$lowest_flag;
															}
															if($Cart_item_QTY >= $rec1->Voucher_Qty && $lowest_flag==1)
															{
																$Reduce_product_amt=($rec1->Voucher_Qty*$rec1->Voucher_Cost_price);//660
																$lowest_flag=0;
																$lv_Voucher_code=$rec1->Voucher_code;
																$ApllicableVoucher_code[]=$rec1->Voucher_code;
												
																$data['Vouchers_price'][$rec1->Voucher_code] = $Reduce_product_amt;
																$data['Discount_percentage'][$rec1->Voucher_code] = $rec1->Discount_percentage;
																$data['Offer_name'][$rec1->Voucher_code] = $rec1->Offer_name;
																$data['Voucher_Qty'][$rec1->Voucher_code] = $rec1->Voucher_Qty;
															}
															// $Vouchers_min_price[$rec1->Voucher_code] = $Reduce_product_amt;
														}
													}
												}
												// echo "<br>".print_r($data['Vouchers_price']);
												// $data['Gift_card_id']=$ApllicableVoucher_code;8368473630
												$data['Unique_Vouchers_list'] = array_unique($ApllicableVoucher_code);
												
												$ReduceDiscountAmt = $data['Vouchers_price']["$Gift_card_id"];
												// print_r($data['Vouchers_price']);
												// echo "Reduce discount amt---".$ReduceDiscountAmt;
												// exit;
									
											/**********************stamp new logic 02-05-2021**************************/
												if($ReduceDiscountAmt > 0)
												{
													$Reduce_product_amt = $ReduceDiscountAmt;
													
													$Result172 = array("Error_flag" => 1001,
																"Bill_total" => number_format($Bill_amount,2),
																"Voucher_no" => $Gift_card_id,
																"Voucher_amount" => number_format($Reduce_product_amt,2),
																"Balance_due" => number_format($Bill_amount - $Reduce_product_amt,2)
																);
													echo json_encode($Result172);
													exit;
												}
												else
												{
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid Voucher no. Or No Balance In Voucher."
																	); //Invalid Gift Card Or No Balance In Gift Card
													echo json_encode($Result427);
													exit;
												}
											}
											else // sent product voucher 
											{
												$Cust_Item_Num = array();
												foreach($Item_details as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													
													$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
													
													if($ItemDetails !=NULL)
													{
														$Merchandize_item_code = $ItemDetails->Company_merchandize_item_code;
														$Item_name = $ItemDetails->Merchandize_item_name;
														
														$Cust_Item_Num[] = $ItemCode;
													}
													else
													{
														$ResponseData = array("Error_flag" => 3103,
																			  "Message" => "Invalid Item_Num Or Item not exist.",
																			  "Item_Num" => $ItemCode
																			); // Item not found or invalid item code
														echo json_encode($ResponseData);
														exit;
													}
												}
												if(in_array($Product_Voucher_item_code, $Cust_Item_Num))
												{
												  // echo "Item found";
												}
												else
												{
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid Voucher no."
																	); //Invalid Gift Card Or No Balance In Gift Card
													echo json_encode($Result427);
													exit;
												}
											}
										}
										if($Card_balance > 0)
										{
											/****************12-7-2020****************/
											if($Discount_percentage > 0)
											{
												$Card_balance = (($Bill_amount * $Discount_percentage)/100);
												$Card_balance = floor($Card_balance);
											}
											$Card_balance = str_replace( ',', '', $Card_balance);
											/****************12-7-2020****************/
											$Balance_due = $Bill_amount - $Card_balance;
											if($Balance_due < 0)
											{
												$Balance_due = 0.00;
											}
											
											$Result172 = array("Error_flag" => 1001,
																"Bill_total" => number_format($Bill_amount,2),
																"Voucher_no" => $Gift_card_id,
																"Voucher_amount" => number_format($Card_balance,2),
																"Balance_due" => number_format($Balance_due,2)
																);
											echo json_encode($Result172);
											exit;	
										}
										else
										{
											$Result427 = array("Error_flag" => 2069,
																"Message" => "Invalid Voucher no. Or No Balance In Voucher."
																); //Invalid Gift Card Or No Balance In Gift Card
											echo json_encode($Result427);
											exit;
										}
									}
									else
									{
										$Result327 = array("Error_flag" => 2069,
															"Message" => "Invalid Voucher no. Or No Balance In Voucher."
															); //Invalid Gift Card Or No Balance In Gift Card
										echo json_encode($Result327);
										exit;
									}
									/*******************api logic end********************/      
								}
								else    
								{
									$Result127 = array("Error_flag" => 2003,"Message" => "Membership Id Not found."); //Unable to Locate membership id
									echo json_encode($Result127);
									exit;
								} 
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009);
								echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
								exit;
							}
					}
					if($API_flag == 90) // POS Transaction with items detail
					{ 
						$Pos_trans_type = $inputArgs['Trans_type'];
						if($Pos_trans_type ==1)
						{
							$API_flag_call = 90;
							$gained_points_fag = 0;
							$cardId = $inputArgs['Membership_id'];
							$Pos_bill_no = $inputArgs['Bill_No'];
							$Pos_bill_status = $inputArgs['Bill_Status'];
							$Pos_bill_amount = $inputArgs['Bill_Total'];
							$Pos_discount = $inputArgs['POS_Discount'];
							$Pos_loyalty_discount = $inputArgs['Loyalty_Discount'];
							$Pos_bill_date_time = $inputArgs['Bill_Date_Time'];
							$Pos_outlet_id = $inputArgs['Outlet_No'];
							$Pos_outlet_name = $inputArgs['Outlet_Name'];
							$Pos_bill_items = $inputArgs['Bill_Items'];
							$Pos_voucher_details = $inputArgs['Voucher_Details'];
							$Pos_voucher_no = $Pos_voucher_details['Voucher_No'];
							$Pos_voucher_reference = $Pos_voucher_details['Voucher_Reference'];
							$Pos_voucher_amount = $Pos_voucher_details['Voucher_Amount'];
							$Pos_redeem_details = $inputArgs['Redeem_Details'];
							$Pos_points_redeemed = $Pos_redeem_details['Points_Redeemed'];
							$Pos_points_amount = $Pos_redeem_details['Points_Amount'];
							$Pos_bill_tenders = $inputArgs['Bill_Tenders'];
							$Pos_payment_type = $inputArgs['Payment_Type_Id'];
							
							$Pos_bill_amount = str_replace( ',', '', $Pos_bill_amount);
							$Pos_discount = str_replace( ',', '', $Pos_discount);
							$Pos_loyalty_discount = str_replace( ',', '', $Pos_loyalty_discount);
							$Pos_voucher_amount = str_replace( ',', '', $Pos_voucher_amount);
							$Pos_points_redeemed = str_replace( ',', '', $Pos_points_redeemed);
							$Pos_points_amount = str_replace( ',', '', $Pos_points_amount);
							
							
							
							$delivery_outlet = $Pos_outlet_id;
							$Cust_redeem_point = $Pos_points_redeemed;
							$EquiRedeem = $Pos_points_amount;
							$subtotal = $Pos_bill_amount;
							
							
							
							// $Pos_discount_amount = $Pos_discount_amount+$Pos_voucher_amount;
							
							// $grand_total = ($Pos_bill_amount-$Pos_points_amount)-$Pos_discount_amount;
							
							$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code 			
							$phnumber = $dial_code.$inputArgs['Membership_id'];
							
							$cust_details = $this->Merchant_api_model->cust_details_from_card($Company_id,$cardId,$phnumber); //Get Customer details
							if($cust_details !=NULL)
							{
								if($cust_details == 3111)
								{
									$Result1311 = array("Error_flag" => 3111, "Message" =>'Customer code expired');
									echo json_encode($Result1311);
									exit;		
								}
								foreach($cust_details as $row25)
								{
									$Customer_enroll_id=$row25['Enrollement_id'];
									$CardId=$row25['Card_id'];
									$fname=$row25['First_name'];
									$midlename=$row25['Middle_name'];
									$lname=$row25['Last_name'];
									$User_email_id=$row25['User_email_id'];
									$Date_of_birth=$row25['Date_of_birth'];
									$address=$row25['Current_address'];
									$bal=$row25['Current_balance'];
									$Blocked_points=$row25['Blocked_points'];
									$Debit_points=$row25['Debit_points'];
									$phno=$row25['Phone_no'];
									$pinno=$row25['pinno'];
									$companyid=$row25['Company_id'];
									$cust_enrollment_id=$row25['Enrollement_id'];
									$image_path=$row25['Photograph'];				
									$filename_get1=$image_path;	
									$Tier_name = $row25['Tier_name'];
									$lv_member_Tier_id = $row25['Tier_id'];
									$Sex = $row25['Sex'];
									$District = $row25['District'];
									$Zipcode = $row25['Zipcode'];
									$total_purchase = $row25['total_purchase'];
									$Total_reddems = $row25['Total_reddems'];
									$Memeber_name = $fname.' '.$midlename.' '.$lname;
								}
							
								$Current_balance = $bal;
								$Current_bal1 = $bal-($Blocked_points+$Debit_points);
						
								if($Current_bal1<0)
								{
									$Current_bal1=0;
								}
								else
								{
									$Current_bal1=$Current_bal1;
								}
								
								if($Current_bal1 <$Pos_points_redeemed)
								{
									$Result12 = array(
														"Error_flag" => 3101,
														"Message" => "Insufficient Current Balance",
														"Current_balance" => $Current_bal1
													);
									echo json_encode($Result12); //Insufficient Point Balance
									exit;
								}
								$result01 = $this->Merchant_api_model->check_pos_bill_no($Pos_bill_no,$Pos_outlet_id,$Company_id,$Pos_bill_date_time);				
								if ($result01 > 0)
								{
									$Result2067 = array("Error_flag" => 2067,
															"Message" => "POS bill no. already exist."
															); 
									echo json_encode($Result2067); //Invalid Gift Card Or No Balance In Gift Card
									exit;
								}
								if($Pos_voucher_no)
								{
									$Voucher_result = $this->Merchant_api_model->Validate_discount_voucher($CardId,$Company_id,$Pos_voucher_no,$Pos_voucher_amount);
									if($Voucher_result == Null)
									{
										$Result327 = array("Error_flag" => 2069,
															"Message" => "Invalid Voucher no. Or No Balance In Voucher."
															); 
										echo json_encode($Result327); //Invalid Gift Card Or No Balance In Gift Card
										exit;
									}
									else
									{
										$Pos_voucher_no = $Pos_voucher_no;
										$Pos_voucher_amount = $Voucher_result->Card_value;
										$Card_Payment_Type_id = $Voucher_result->Payment_Type_id;
										$Discount_percentage = $Voucher_result->Discount_percentage;
										
										$Pos_voucher_amount = str_replace( ',', '', $Pos_voucher_amount);
										if($Card_Payment_Type_id == 997) //product voucher
										{	
											$Product_Voucher_Details = $this->Merchant_api_model->Get_Product_Voucher_Details($Pos_voucher_no,$Customer_enroll_id,$Company_id);
											
											$Product_Voucher_item_code = $Product_Voucher_Details->Company_merchandize_item_code;
											$Product_Voucher_id = $Product_Voucher_Details->Voucher_id;
											$Product_Voucher_Offer_code = $Product_Voucher_Details->Offer_code;
											
											if($Product_Voucher_id ==0) // product voucher in percentage
											{
												$Cust_Item_Num = array();
												foreach($Pos_bill_items as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													
													$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
													
													if($ItemDetails !=NULL)
													{
														$Merchandize_item_code = $ItemDetails->Company_merchandize_item_code;
														$Item_name = $ItemDetails->Merchandize_item_name;
														
														$ItemCodeArr[$ItemCode]=$item['Item_Qty'];
														
														$Cust_Item_Num[] = $ItemCode;
														
														$Pos_Item_details = array("Item_Num" => $ItemCode, "Item_Name" =>$Item_name,"Quantity" => $item['Item_Qty'], "Item_Rate" => $item['Item_Rate']);
												
														$Pos_Item_details_array[] =$Pos_Item_details;
													}
													else
													{
														$ResponseData = array("Error_flag" => 3103,
																			  "Message" => "Invalid Item_Num Or Item not exist.",
																			  "Item_Num" => $ItemCode
																			); // Item not found or invalid item code
														echo json_encode($ResponseData);
														exit;
													}
												}
											/**********************stamp new logic 02-05-2021**************************/
												$Get_lowest_sent_vouchers= $this->Merchant_api_model->Get_lowest_sent_vouchers($CardId,$Company_id,$Pos_voucher_no);
												// 1 Kenya Tea + 1 Chai latte + 1 Lemon Tea
												if($Get_lowest_sent_vouchers != NULL)
												{
													$RemQTY=0;
													$lv_Voucher_code=0;
													$lowest_flag=1;
													$newpricearr = array();
													foreach($Get_lowest_sent_vouchers as $rec1)
													{
														
														// echo "<br>Cart_item_QTY:: ".$Cart_item_QTY;
														// echo "<br>Company_merchandize_item_code:: ".$rec1->Company_merchandize_item_code;
														// echo "<br>Cart_item_QTY:: ".$Cart_item_QTY;
														if(array_key_exists($rec1->Company_merchandize_item_code,$ItemCodeArr))
														{
															if($lowest_flag == 0 && $lv_Voucher_code != $rec1->Voucher_code)
															{
																$RemQTY=0;
																$lowest_flag=1;
																$newpricearr = array();
															}
															// echo "<br>Gift_card_id:: ".$rec1->Gift_card_id;
															$Cart_item_QTY=$ItemCodeArr[$rec1->Company_merchandize_item_code];
															
															if($RemQTY!=0)//
															{
																if($Cart_item_QTY >= $RemQTY )
																{
																	$newpricearr[]=($RemQTY * $rec1->Voucher_Cost_price);//1*260=260
																	$Reduce_product_amt=array_sum($newpricearr);//220+260=480
																	$ApllicableVoucher_code[]=$rec1->Voucher_code;
																	
																	$data['Vouchers_price'][$rec1->Voucher_code] = $Reduce_product_amt;
																	if($lowest_flag!=0)
																	{
																		// $data['Free_item_arr'][$rec1->Company_merchandize_item_code] = $Cart_item_QTY;
																		$data['Free_item_arr'][$rec1->Company_merchandize_item_code] = $RemQTY;
																	}
																	$data['Discount_percentage'][$rec1->Voucher_code] = $rec1->Discount_percentage;
																	$data['Offer_name'][$rec1->Voucher_code] = $rec1->Offer_name;
																	$data['Voucher_Qty'][$rec1->Voucher_code] = $rec1->Voucher_Qty;
																	// echo "<br>".$Reduce_product_amt;
																	$lowest_flag=0;
																	$lv_Voucher_code=$rec1->Voucher_code;
																}
																/* if($Cart_item_QTY < $RemQTY  && $lowest_flag==1)
																{
																	$newpricearr[]=($Cart_item_QTY*$rec1->Voucher_Cost_price);//260
																	$RemQTY= ($rec1->Voucher_Qty-$Cart_item_QTY);//1
																} */
															}
															if($Cart_item_QTY < $rec1->Voucher_Qty && $RemQTY==0)//
															{
																$newpricearr[]=($Cart_item_QTY*$rec1->Voucher_Cost_price);//220
																// echo "<br>".$Cart_item_QTY*$rec1->Voucher_Cost_price;
																$RemQTY= ($rec1->Voucher_Qty-$Cart_item_QTY);//1
																if($lowest_flag!=0){$data['Free_item_arr'][$rec1->Company_merchandize_item_code] = $Cart_item_QTY;}
																$lv_Voucher_code=$rec1->Voucher_code;
																// echo "<br>RemQTY ".$RemQTY;
																// echo "<br>lowest_flag ".$lowest_flag;
															}
															if($Cart_item_QTY >= $rec1->Voucher_Qty && $lowest_flag==1)
															{
																$Reduce_product_amt=($rec1->Voucher_Qty*$rec1->Voucher_Cost_price);//660
																$lowest_flag=0;
																$lv_Voucher_code=$rec1->Voucher_code;
																$ApllicableVoucher_code[]=$rec1->Voucher_code;
												
																$data['Free_item_arr'][$rec1->Company_merchandize_item_code] = $rec1->Voucher_Qty;
																$data['Vouchers_price'][$rec1->Voucher_code] = $Reduce_product_amt;
																$data['Discount_percentage'][$rec1->Voucher_code] = $rec1->Discount_percentage;
																$data['Offer_name'][$rec1->Voucher_code] = $rec1->Offer_name;
																$data['Voucher_Qty'][$rec1->Voucher_code] = $rec1->Voucher_Qty;
															}
															// $Vouchers_min_price[$rec1->Voucher_code] = $Reduce_product_amt;
														}
													}
												}
												// echo "<br>".print_r($data['Vouchers_price']);
												// $data['Gift_card_id']=$ApllicableVoucher_code;8368473630
												$data['Unique_Vouchers_list'] = array_unique($ApllicableVoucher_code);
												
												$ReduceDiscountAmt = $data['Vouchers_price']["$Pos_voucher_no"];
												// print_r($data['Vouchers_price']);
												// echo "Reduce discount amt---".$ReduceDiscountAmt;
												// exit;
									
											/**********************stamp new logic 02-05-2021**************************/
												if($ReduceDiscountAmt > 0)
												{
													$Reduce_product_amt = $ReduceDiscountAmt;
													$Pos_voucher_amount = number_format($Reduce_product_amt,2);
													// echo "Pos_voucher_amount---".$Pos_voucher_amount; exit;
												}
												else
												{
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid Voucher no. Or No Balance In Voucher."
																	); //Invalid Gift Card Or No Balance In Gift Card
													echo json_encode($Result427);
													exit;
												}
											}
											else
											{	
												$Cust_Item_Num = array();
												foreach($Pos_bill_items as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													
													$ItemDetails1 = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
													
													if($ItemDetails1 !=NULL)
													{
														$Merchandize_item_code = $ItemDetails1->Company_merchandize_item_code;
														$Item_name = $ItemDetails1->Merchandize_item_name;
														
														$Cust_Item_Num[] = $ItemCode;
													}
													else
													{
														$ResponseData = array("Error_flag" => 3103,
																			  "Message" => "Invalid Item_Num Or Item not exist.",
																			  "Item_Num" => $ItemCode
																			); // Item not found or invalid item code
														echo json_encode($ResponseData);
														exit;
													}
												}
												if(in_array($Product_Voucher_item_code, $Cust_Item_Num))
												{
												  // echo "Item found";
												}
												else
												{
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid Voucher no."
																	); //Invalid Gift Card Or No Balance In Gift Card
													echo json_encode($Result427);
													exit;
												}
											}
										}
										if($Discount_percentage > 0 && $Card_Payment_Type_id !=997)
										{
											$Bill_amount11 = $Pos_bill_amount - $Pos_discount - $Pos_loyalty_discount;
											$Pos_voucher_amount = (($Bill_amount11 * $Discount_percentage)/100);
											$Pos_voucher_amount = floor($Pos_voucher_amount);
										}
									}
								}
								else
								{
									$Pos_voucher_no = Null;
									$Pos_voucher_amount = 0.00;
								}
								
								$get_city_state_country = $this->Merchant_api_model->Fetch_city_state_country($Company_id,$Customer_enroll_id);
								$State_name=$get_city_state_country->State_name;
								$City_name=$get_city_state_country->City_name;
								$Country_name=$get_city_state_country->Country_name;
					
								$result = $this->Merchant_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
								if($result!=NULL)
								{
									$seller_id = $result->Enrollement_id;
									$seller_fname = $result->First_name;
									$seller_lname = $result->Last_name;
									$Pos_outlet_name = $seller_fname .' '. $seller_lname;
									$Seller_Redemptionratio = $result->Seller_Redemptionratio;
									$Purchase_Bill_no = $result->Purchase_Bill_no;
									$Sub_seller_admin = $result->Sub_seller_admin;
									$Sub_seller_Enrollement_id = $result->Sub_seller_Enrollement_id;
									$Outlet_address = App_string_decrypt($result->Current_address);
									$currency_details = $this->Igain_model->Get_Country_master($result->Country);
									$Symbol_currency = $currency_details->Symbol_of_currency;
									$Pos_outlet_id1 = $seller_id;
									
									if($Sub_seller_admin == 1) 
									{
										$Pos_outlet_id = $seller_id;
									}
									else 
									{
										$Pos_outlet_id = $Sub_seller_Enrollement_id;
									}
									
									if($Seller_Redemptionratio !=Null)
									{
										$Company_Redemptionratio = $Seller_Redemptionratio;
									}
									else
									{
										$Company_Redemptionratio =$Company_Redemptionratio;
									}
										$tp_db = $Purchase_Bill_no;
										$len = strlen($tp_db);
										$str = substr($tp_db,0,5);
										$bill = substr($tp_db,5,$len);
						   
										$date = new DateTime();
										$lv_date_time=$date->format('Y-m-d H:i:s'); 
							  
										$lv_date_time2 = $date->format('Y-m-d'); 
							
										$Trans_type = 2;
										$Trans_Channel_id = 2;
										$Payment_type_id = $Pos_payment_type;
										if($Payment_type_id == Null)
										{
											$Payment_type_id = 1;
										}
										$Remarks = "Pos Transaction";
										
										if($Sub_seller_admin == 1) 
										{
										  $seller_id = $seller_id;
										}
										else 
										{
										  $seller_id = $Sub_seller_Enrollement_id;
										}
									
										$order_total_loyalty_points = 0;
										
										/**************new logic with pos items********************/
										if($Pos_bill_items != Null)
										{
											$order_sub_total = 0;	
											$shipping_cost = 0;
											$DiscountAmt = 0;
											$TotalvoucherAmt = 0;
											$TotalDiscountAmt = 0;
											$ItemDiscounts = [];
											$tax = 0;	
											$i = 0;
									// if($Pos_loyalty_discount > 0) // 19-06-2020
									// {
											foreach($Pos_bill_items as $item)
											{ 
												$ItemCode = $item['Item_Num']; 
												$ItemQty = $item['Item_Qty']; 
												$Item_price = $item['Item_Rate'];
												
												$Item_price = str_replace( ',', '', $Item_price);
												
													$Item_price = $Item_price * $ItemQty;
													$order_sub_total = $order_sub_total + $Item_price;
													$i++;
													
												
													$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
													if($ItemDetails !=NULL)
													{
														$Itemcategory_id = $ItemDetails->Merchandize_category_id;
														
														/***************11-7-2020*************/
														$Itemcategory_ids[] = $ItemDetails->Merchandize_category_id;
														$Itemcategory_price[$Itemcategory_id] = $item['Item_Rate'] * $item['Item_Qty'];
														/***************11-7-2020*************/
													}
													else
													{
														$ResponseData1 = array("Error_flag" => 3103,
																		  "Message" => "Invalid Item_Num Or Item not exist.",
																		  "Item_Num" => $ItemCode
																		); // Item not found or invalid item code
														echo json_encode($ResponseData1);
														exit;
													}
												
													$DiscountResult = $this->Merchant_api_model->get_discount_value("",$ItemCode,$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,0,$API_flag_call);
													
													$DisOpt = json_decode($DiscountResult,true);
							
													if($DisOpt["DiscountAmt"] > 0)
													{
														// $TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt["DiscountAmt"]);
														
														$TotalDiscountAmt = floor($TotalDiscountAmt + str_replace( ',', '', $DisOpt["DiscountAmt"]));
														
														$ItemDiscounts[$ItemCode] = $DisOpt["DiscountAmt"];
													}
													
													if(!empty($DisOpt["discountsArray"]) && is_array($DisOpt["discountsArray"]))
													{
														foreach($DisOpt["discountsArray"] as $k1)
														{
															$Discount_codes[] = $k1;
														}
													}
													if(!empty($DisOpt["discountsArray2"]) && is_array($DisOpt["discountsArray2"]))
													{
														foreach($DisOpt["discountsArray2"] as $k2)
														{
															$Discount_codes_2[] = $k2;
														}
													}
												///****************sandeep discount logic 27-01-2020*********************
											}
											/********************11-7-2020******************/
											$Itemcategory_ids = array_unique($Itemcategory_ids);
											foreach($Itemcategory_ids as $Itemcategory_id)
											{
												// $CatDiscountResult = $this->Merchant_api_model->get_category_discount_value($Itemcategory_id,"",$Item_price,$data['Company_id'],$BrandOutlet_Id,$data['enroll'],$Tier_id,0,0);
												$Item_price = $Itemcategory_price[$Itemcategory_id];
												
												$CatDiscountResult = $this->Merchant_api_model->get_category_discount_value($Itemcategory_id,"",$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,0,0,$API_flag_call);
													
													$DisOpt22 = json_decode($CatDiscountResult,true);
													// print_r($DisOpt22);
													
													if($DisOpt22["DiscountAmt"] > 0)
													{
														$TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt22["DiscountAmt"]);
														//***** 18-03-2020 ************
													}
													
													if(!empty($DisOpt22["discountsArray"]) && is_array($DisOpt22["discountsArray"]))
													{
														//$Discount_codes[] = $DisOpt["discountsArray"];
															foreach($DisOpt22["discountsArray"] as $k1)
															{
																$Discount_codes[] = $k1;
															}
													}
													// print_r($Discount_codes);
													
													if(!empty($DisOpt22["discountsArray2"]) && is_array($DisOpt22["discountsArray2"]))
													{
														foreach($DisOpt22["discountsArray2"] as $k2)
														{
															$Discount_codes_2[] = $k2;
														}
													}
											}
										///**************** sandeep category discount logic 27-01-2020 ***************************
									
											$DiscountResult12 = $this->Merchant_api_model->get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,$order_sub_total,$API_flag_call);
											
											$DisOpt12 = json_decode($DiscountResult12,true);
											
											if($DisOpt12["DiscountAmt"] > 0)
											{
												// $TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt12["DiscountAmt"]);
												
												$number2 = filter_var($DisOpt12["DiscountAmt"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
												$TotalDiscountAmt = ($TotalDiscountAmt + str_replace( ',', '', $number2));
												
												$_SESSION['BillDiscount'] = $DisOpt12["DiscountAmt"];
											}
											
											if(!empty($DisOpt12["discountsArray"]) && is_array($DisOpt12["discountsArray"]))
											{
												foreach($DisOpt12["discountsArray"] as $k)
												{
													$Discount_codes[] = $k;
												}
											}
										/******************11-7-2020****************/
											if(!empty($DisOpt12["discountsArray2"]) && is_array($DisOpt12["discountsArray2"]))
											{
												foreach($DisOpt12["discountsArray2"] as $k2)
												{
													$Discount_codes_2[] = $k2;
												}
											}
										/******************11-7-2020****************/
										
											
											if($DisOpt12["voucherValidity"] != null)
											{ 
												$this->session->set_userdata('voucherValidity',$DisOpt12["voucherValidity"]);
											}
											$voucherValidity = $this->session->userdata('voucherValidity');
											
											$voucherAmt = $this->session->userdata('voucherAmt');
											
											// $DiscountAmt = $TotalDiscountAmt;
											
											$TotalDiscountAmt = str_replace( ',', '', $TotalDiscountAmt);
											$DiscountAmt = $TotalDiscountAmt;
											
											$_SESSION['DiscountAmt']= $TotalDiscountAmt;
											
											if(count($Discount_codes) > 0)
											{}
												
											if(count($ItemDiscounts) > 0)
											{
											
												$this->session->set_userdata('ItemDiscounts',$ItemDiscounts);
											}
									
											if($order_sub_total < $DiscountAmt)
											{
												$DiscountAmt = $order_sub_total;
											}
											
											$order_total = ($order_sub_total + $shipping_cost + $tax) - $DiscountAmt;
									// } // 19-06-2020
										
									 // $Pos_discount_amount = $Pos_discount+$Pos_loyalty_discount+$Pos_voucher_amount;
									 
									$Pos_discount_amount = $Pos_discount+$Pos_loyalty_discount+$Pos_voucher_amount;
									
									$grand_total = ($Pos_bill_amount-$Pos_points_amount)-$Pos_discount_amount;
									
								/*	
									$Pos_bill_amount1 = $Pos_bill_amount - $Pos_discount_amount;
									$RedeemAmtCheck = $this->Merchant_api_model->cal_redeem_amt_contrl($Pos_points_redeemed,$Company_Redemptionratio,$Pos_bill_amount1,0,0,0,0,0);
								
									$grand_total = ($Pos_bill_amount-$RedeemAmtCheck)-$Pos_discount_amount;
							
									$EquiRedeem = $RedeemAmtCheck;
									
									$grand_totalCheck = ($Pos_bill_amount-$RedeemAmtCheck)-$Pos_discount_amount;*/
									
									// if($grand_totalCheck < 0 || $RedeemAmtCheck == 2066)
									if($grand_total < 0 )
									{
										// $RedeemAmtCheck=$Pos_points_redeemed/$Company_Redemptionratio;
										
										$Result1327 = array("Error_flag" => 2066,
															"Bill_total" => number_format($Pos_bill_amount,2),
															"Discount_amount" => number_format($Pos_discount_amount,2),
															"Redeem_amount" => number_format($Pos_points_amount,2),
															"Message" => "Total discount amount and redeem amount is more than total bill amount."
															); 
										echo json_encode($Result1327); 
										exit;
									}
									
										
										// $ItemDiscounts = $this->session->userdata('ItemDiscounts');
										$Extra_earn_points_Loyalty_pts = array();
											foreach ($Pos_bill_items as $item)
											{
												/********************************/
													$characters = 'A123B56C89';
													$string = '';
													$Voucher_no="";
													for ($i = 0; $i < 10; $i++) 
													{
														$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
													}
													$Voucher_array1[]=$Voucher_no;
												/*************************************/
													$Item_code = $item['Item_Num'];
													$Menu_Group_Id = $item['Menu_Group_Id'];
													$Pos_item_rate = $item['Item_Rate'];
													$Pos_item_rate = str_replace( ',', '', $Pos_item_rate);
													$Pos_item_qty = $item['Item_Qty'];
												/********Get Merchandize item name********/
													$result = $this->Merchant_api_model->Get_merchandize_item($Item_code,$Company_id);
													
													$sellerID = $result->Seller_id;
													if($sellerID !=NULL || $sellerID !='0')
													{
														$sellerID = $sellerID; // apply item outlet rule
													}
													else
													{
														$sellerID = $seller_id; // apply POS outlet rule
													}
													
													$sellerID = $seller_id; // apply POS outlet rule
													
													$Merchandise_item_id = $result->Company_merchandise_item_id;
													$Company_merchandize_item_code = $result->Company_merchandize_item_code;
													$Merchandize_item_name = $result->Merchandize_item_name;
													$Merchandize_category_id = $result->Merchandize_category_id;
													$Stamp_item_flag = $result->Stamp_item_flag;
													$Merchandize_partner_id = $result->Partner_id;
													// $Item_cost_price = $result->Cost_price*$Pos_item_qty;
													$Item_cost_price = $Pos_item_rate*$Pos_item_qty;
													
													$Item_branch = $this->Merchant_api_model->get_items_branches($Company_merchandize_item_code,$Merchandize_partner_id,$Company_id);
													$Item_branch_code = $Item_branch->Branch_code;
													
													if(count($ItemDiscounts) > 0)
													{
														$thisItemDiscount = $ItemDiscounts[$Company_merchandize_item_code];
														
													}
													/******************New Loyalty Rule Logic********************/ 
													$Extra_earn_points = 0;
													
													if($Stamp_item_flag == 1)
													{
														$Extra_earn_points = $result->Extra_earn_points;
														$Extra_earn_points_Loyalty_pts[]=$Extra_earn_points;
													}
													if($sellerID!=0)
													{
													/**********Get Seller Details**********/
														$Seller_result = $this->Pos_model->Get_Seller_details($sellerID,$Company_id);	
														$Seller_First_name=$Seller_result->First_name;
														$Seller_Last_name=$Seller_result->Last_name;
														$seller_name=$Seller_First_name.' '.$Seller_Last_name;
														$Purchase_Bill_no = $Seller_result->Purchase_Bill_no;

														$tp_db = $Purchase_Bill_no;
														$len = strlen($tp_db);
														$str = substr($tp_db,0,5);
														$bill = substr($tp_db,5,$len);
													/**********Get Seller Details**********/
													
														$seller_id=$sellerID;
														
														$loyalty_prog = $this->Pos_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
														
														$points_array = array();

														$Applied_loyalty_id = array();
														if($loyalty_prog != NULL )
														{
															foreach($loyalty_prog as $prog)
															{
																$member_Tier_id = $lv_member_Tier_id;
																$value = array();
																$dis = array();
																$LoyaltyID_array = array();
																$Loyalty_at_flag = 0;	
																$lp_type=substr($prog['Loyalty_name'],0,2);
																$Todays_date = $lv_date_time;
																
															$lp_details = $this->Pos_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);
															
																$lp_count = count($lp_details);

																foreach($lp_details as $lp_data)
																{
																	$LoyaltyID = $lp_data['Loyalty_id'];
																	$lp_name = $lp_data['Loyalty_name'];
																	$lp_From_date = $lp_data['From_date'];
																	$lp_Till_date = $lp_data['Till_date'];
																	$Loyalty_at_value = $lp_data['Loyalty_at_value'];
																	$Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
																	$discount = $lp_data['discount'];
																	$lp_Tier_id = $lp_data['Tier_id'];
																	$Category_flag = $lp_data['Category_flag'];
																	$Category_id = $lp_data['Category_id'];
																	$Segment_flag = $lp_data['Segment_flag'];
																	$Segment_id	= $lp_data['Segment_id'];
																
															//********* 10-7-2020- nilesh ****channel and payment ***************
																$Trans_Channel_flag	= $lp_data['Channel_flag'];
																$Trans_Payment_flag	= $lp_data['Payment_flag'];
																$Trans_Channel_flag	= $lp_data['Channel_flag'];
																$Trans_Channel	= $lp_data['Trans_Channel'];
																$Lp_Payment_Type_id	= $lp_data['Payment_Type_id'];
																
															//********* 10-7-2020- nilesh ****channel and payment ***************
															
																	if($lp_Tier_id == 0)
																	{
																		$member_Tier_id = $lp_Tier_id;
																	}
																	if($Loyalty_at_value > 0)
																	{
																		$value[] = $Loyalty_at_value;	
																		$dis[] = $discount;
																		$LoyaltyID_array[] = $LoyaltyID;
																		$Loyalty_at_flag = 1;
																	}
																	if($Loyalty_at_transaction > 0)
																	{
																		$value[] = $Loyalty_at_transaction;	
																		$dis[] = $Loyalty_at_transaction;
																		$LoyaltyID_array[] = $LoyaltyID;
																		$Loyalty_at_flag = 2;
																	}
																}
															
																if($lp_type == 'PA')
																{		
																	// $transaction_amt = $subtotal;
																	$transaction_amt1=$Pos_item_qty * $Pos_item_rate;
																	
																	$transaction_amtNew = $this->cheque_format($transaction_amt1); // 25/11/2020
																	$transaction_amt = str_replace( ',', '', $transaction_amtNew);
																}
																if($lp_type == 'BA')
																{	
																	$grand_totalNew = $this->cheque_format($grand_total);
																	$grand_totalNew = str_replace( ',', '', $grand_totalNew);
																	$Purchase_amount=$Pos_item_qty * $Pos_item_rate;
																	// $transaction_amt = $grand_total;
																	 // $transaction_amt = (($grand_total * $Purchase_amount ) / $subtotal); // 25/11/2020
																	 $transaction_amt = (($grand_totalNew * $Purchase_amount ) / $subtotal);
																}
																
																
															//********* 10-7-2020- nilesh ****channel and payment ***************
																if($Trans_Channel_flag==1)
																{
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1 && $Trans_Channel_id == $Trans_Channel )
																	{
																		for($i=0;$i<=count($value)-1;$i++)
																		{
																			if($i<count($value)-1 && $value[$i+1] != "")
																			{
																				if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Trans_Channel_id == $Trans_Channel )
																	{
																		$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																		$points_array[] = $loyalty_points;
																		$gained_points_fag = 1;
																		$trans_lp_id = $LoyaltyID_array[0];
																		$Applied_loyalty_id[]=$trans_lp_id;
																	}						
																// unset($dis);
																}	
																if($Trans_Payment_flag == 1)
																{
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1 && $Lp_Payment_Type_id == $Payment_type_id )
																	{
																		for($i=0;$i<=count($value)-1;$i++)
																		{
																			if($i<count($value)-1 && $value[$i+1] != "")
																			{
																				if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}
																	
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Lp_Payment_Type_id == $Payment_type_id)
																	{
																		$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																		$points_array[] = $loyalty_points;
																		$gained_points_fag = 1;
																		$trans_lp_id = $LoyaltyID_array[0];
																		$Applied_loyalty_id[]=$trans_lp_id;
																	}	
																}
															//********* 10-7-2020- nilesh ****channel and payment ***************
																if($Category_flag==1)
																{
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1 && $Merchandize_category_id == $Category_id )
																	{
																		for($i=0;$i<=count($value)-1;$i++)
																		{
																			if($i<count($value)-1 && $value[$i+1] != "")
																			{
																				if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Merchandize_category_id == $Category_id )
																	{
																		$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																		$points_array[] = $loyalty_points;
																		$gained_points_fag = 1;
																		$trans_lp_id = $LoyaltyID_array[0];
																		$Applied_loyalty_id[]=$trans_lp_id;
																	}						
																// unset($dis);
																}
																else if($Segment_flag==1)
																{											
																	$Get_segments2 = $this->Pos_model->edit_segment_id($Company_id,$Segment_id);
																	
																	$Customer_array=array();
																	$Applicable_array[]=0;
																	unset($Applicable_array);
																	
																	foreach($Get_segments2 as $Get_segments)
																	{
																		if($Get_segments->Segment_type_id==1)  // 	Age 
																		{
																			$lv_Cust_value=date_diff(date_create($Date_of_birth), date_create('today'))->y;
																		}												
																		if($Get_segments->Segment_type_id==2)//Sex
																		{
																			$lv_Cust_value=$Sex;
																		}
																		if($Get_segments->Segment_type_id==3)//Country
																		{
																			$lv_Cust_value = $Country_name;
																			if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																			{
																				$Get_segments->Value=$lv_Cust_value;
																			}
																		}
																		if($Get_segments->Segment_type_id==4)//District
																		{
																			$lv_Cust_value=$District;
																			
																			if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																			{
																				$Get_segments->Value=$lv_Cust_value;
																			}
																		}
																		if($Get_segments->Segment_type_id==5)//State
																		{
																			$lv_Cust_value=$State_name;	
																			if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																			{
																				$Get_segments->Value=$lv_Cust_value;
																			}
																		}
																		if($Get_segments->Segment_type_id==6)//city
																		{
																			$lv_Cust_value=$City_name;
																			
																			if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																			{
																				$Get_segments->Value=$lv_Cust_value;
																			}
																		}
																		if($Get_segments->Segment_type_id==7)//Zipcode
																		{
																			$lv_Cust_value=$Zipcode;
																			
																		}
																		if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
																		{
																			$lv_Cust_value=$total_purchase;	
																		}
																		if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
																		{
																			$lv_Cust_value=$Total_reddems;
																		}
																		if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
																		{
																			$start_date=$joined_date;
																			$end_date=date("Y-m-d");
																			$transaction_type_id=2;
																			$Tier_id=$lp_Tier_id;
																			
																			$Trans_Records = $this->Shipping_model->get_cust_trans_summary_all($Company_id,$Customer_enroll_id,$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
																			foreach($Trans_Records as $Trans_Records)
																			{
																				$lv_Cust_value=$Trans_Records->Total_Gained_Points;
																			}											
																		}
																		if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
																		{
																			$start_date=$joined_date;
																			$end_date=date("Y-m-d");
																			$transaction_type_id=2;
																			$Tier_id=$lp_Tier_id;
																			
																			$Trans_Records = $this->Shipping_model->get_cust_trans_details($Company_id,$start_date,$end_date,$Customer_enroll_id,$transaction_type_id,$Tier_id,'','');
																			foreach($Trans_Records as $Trans_Records)
																			{
																				$lv_Max_amt[]=$Trans_Records->Purchase_amount;
																			}
																			$lv_Cust_value=max($lv_Max_amt);				
																		}
																		if($Get_segments->Segment_type_id==12)//Membership Tenor
																		{
																			$tUnixTime = time();
																			list($year,$month, $day) = EXPLODE('-', $joined_date);
																			$timeStamp = mktime(0, 0, 0, $month, $day, $year);
																			$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
																		}
																		
																		$Get_segments = $this->Pos_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
																		
																		$Applicable_array[]=$Get_segments;
																		
																	}
																	// print_r($Applicable_array);
																	
																	if(!in_array(0, $Applicable_array, true))
																	{
																		$Customer_array[]=$Customer_enroll_id;
																		
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
																		{
																			for($i=0;$i<=count($value)-1;$i++)
																			{
																				if($i<count($value)-1 && $value[$i+1] != "")
																				{
																					if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																					{
																						$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;
																						$gained_points_fag = 1;
																						$points_array[] = $loyalty_points;
																					}
																				}
																				else if($transaction_amt > $value[$i])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$gained_points_fag = 1;
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;					
																					$points_array[] = $loyalty_points;
																				}
																			}
																		}									
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
																		{	
																			$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																			$points_array[] = $loyalty_points;
																			$gained_points_fag = 1;
																			$trans_lp_id = $LoyaltyID_array[0];
																			$Applied_loyalty_id[]=$trans_lp_id;	
																		}
																	} 
																}
																else
																{
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1  && $Trans_Channel == 0 && $Lp_Payment_Type_id == 0)
																	{
																		for($i=0;$i<=count($value)-1;$i++)
																		{
																			if($i<count($value)-1 && $value[$i+1] != "")
																			{
																				if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}

																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2  && $Trans_Channel == 0 && $Lp_Payment_Type_id == 0)
																	{
																		$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																		$points_array[] = $loyalty_points;
																		$gained_points_fag = 1;
																		$trans_lp_id = $LoyaltyID_array[0];
																		$Applied_loyalty_id[]=$trans_lp_id;
																	}
																}
															}
															if(count($Applied_loyalty_id) == 0)
															{
																$trans_lp_id=0;
															}											
														}
														if($gained_points_fag == 1)
														{
															$total_loyalty_points = array_sum($points_array);	
														
															$Email_points[]=$total_loyalty_points;
														}
														else
														{
															$total_loyalty_points = 0;
														}
													}
													else
													{
													/******************Get Supper Seller Details*********************/
														$Super_seller_flag = 1;
														$result = $this->Pos_model->Get_Seller($Super_seller_flag,$Company_id);				   
														$seller_id = $result->Enrollement_id;
														$seller_fname = $result->First_name;
														$seller_lname = $result->Last_name;
														$seller_name = $seller_fname .' '. $seller_lname;
														$Seller_Redemptionratio = $result->Seller_Redemptionratio;
														$Purchase_Bill_no = $result->Purchase_Bill_no;

														$tp_db = $Purchase_Bill_no;
														$len = strlen($tp_db);
														$str = substr($tp_db,0,5);
														$bill = substr($tp_db,5,$len);
													/******************Get Supper Seller Details*********************/
														$total_loyalty_points=0;
														$Email_points[]=$total_loyalty_points;
													}
													
													// $total_loyalty_points=round($total_loyalty_points + $Extra_earn_points);
													$total_loyalty_points=$total_loyalty_points + $Extra_earn_points;
												
													$Voucher_status = 20; //'collected'
													$item_total_amount = $Pos_item_qty * $Pos_item_rate;
													// $Weighted_loyalty_points = round(($total_loyalty_points * $item_total_amount) / $subtotal);
													if($sellerID!=0)
													{
														// $Weighted_loyalty_points = round($total_loyalty_points);
														$Weighted_loyalty_points = $total_loyalty_points;
													}
													else
													{
														$Weighted_loyalty_points = $Extra_earn_points; //	sandeep 
													}
													$Weighted_redeem_points1 = ($Cust_redeem_point * $item_total_amount) / $subtotal;
													
													$Weighted_points_amount1 = ($Pos_points_amount * $item_total_amount) / $subtotal;
													
													$Weighted_redeem_points = round(($Cust_redeem_point * $item_total_amount) / $subtotal);
													
													$Weighted_points_amount = round(($Pos_points_amount * $item_total_amount) / $subtotal);
													
													$Weighted_discount_amount = round(($Pos_discount_amount * $item_total_amount) / $subtotal);
												//***********18-04-2020-allow to redeem 1 point extra****************/
													$Weighted_discount_amount1 = ($Pos_discount_amount * $item_total_amount) / $subtotal;
												//***********18-04-2020-allow to redeem 1 point extra****************/	
													$Purchase_amount=$Pos_item_qty * $Pos_item_rate;
													
													$Balance_to_pay = (($grand_total * $Purchase_amount ) / $subtotal);
														
													$Total_Weighted_avg_shipping_cost[]=0;
													$Weighted_avg_shipping_cost="-";
													
													$Shipping_cost=0;
													$Weighted_avg_shipping_cost=0;
											
													$RedeemAmt=$Weighted_redeem_points/$Company_Redemptionratio;
													$RedeemAmt1=$Weighted_redeem_points1/$Company_Redemptionratio;
													
													// $PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt-$Weighted_discount_amount;
													
													$PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$Weighted_points_amount-$Weighted_discount_amount;
													
												//***********18-04-2020-allow to redeem 1 point extra****************/
													// $PaidAmount1=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt1-$Weighted_discount_amount;
													
													// $PaidAmount1=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt1-$Weighted_discount_amount1;
													
													$PaidAmount1=$Purchase_amount+$Weighted_avg_shipping_cost-$Weighted_points_amount1-$Weighted_discount_amount1;
												
													$Weighted_Redeem_amount=(($Purchase_amount/$Pos_bill_amount)*$EquiRedeem);
													if($PaidAmount1 <= 0)
													{
														$PaidAmount1 = 0;
													}
												//***********18-04-2020-allow to redeem 1 point extra****************/
													$Total_discount1 = $Pos_loyalty_discount + $Pos_discount + $Pos_voucher_amount;
													
													$data123 = array('Company_id' => $Company_id,
																		'Trans_type' => $Trans_type,
																		'Purchase_amount' => $Purchase_amount, 
																		'Paid_amount' => $PaidAmount1,
																		'Mpesa_Paid_Amount' => 0.00,
																		'COD_Amount' => $PaidAmount1,
																		'Mpesa_TransID' => 0,
																		'Redeem_points' => $Weighted_redeem_points1,
																		// 'Redeem_amount' => $RedeemAmt1,
																		'Redeem_amount' => $Weighted_Redeem_amount,
																		'Payment_type_id' => $Payment_type_id,
																		'Remarks' => $Remarks,
																		'Trans_date' => $lv_date_time,
																		'balance_to_pay' => $PaidAmount1,
																		'Shipping_cost' => $Weighted_avg_shipping_cost,
																		'Shipping_points' => ($Weighted_avg_shipping_cost*$Company_Redemptionratio),
																		'Enrollement_id' => $cust_enrollment_id,
																		'Bill_no' => $bill,
																		'Manual_billno' => $Pos_bill_no,
																		// 'Voucher_no' => $Voucher_no,
																		'Voucher_no' => $Pos_voucher_no,
																		'Card_id' => $CardId,
																		'Seller' => $Pos_outlet_id1,
																		'Seller_name' => $Pos_outlet_name,
																		'Item_code' => $Company_merchandize_item_code, 
																		'Item_size' => 0,
																		'Voucher_status' => $Voucher_status,
																		'Delivery_method' => 28, // Pick Up
																		'Merchandize_Partner_id' => $Merchandize_partner_id,
																		'Merchandize_Partner_branch' => $Item_branch_code,
																		'Quantity' => $Pos_item_qty,
																		'Loyalty_pts' => $Weighted_loyalty_points, 
																		'Online_payment_method' => "COD",
																		'Cost_payable_partner' => $Item_cost_price,
																		'Bill_discount' => $Pos_loyalty_discount,	
																		'Pos_discount' => $Pos_discount,
																		'Total_discount' => $Total_discount1,
																		'Voucher_discount' => $Pos_voucher_amount
																	);	

															$Transaction_detail = $this->Pos_model->Insert_online_purchase_transaction($data123);
													
													if($Transaction_detail)
													{
													/******Insert online purchase log tbl entery*******/	
														$Company_id	= $Company_id;
														$Todays_date = date('Y-m-d');	
														$opration = 1;		
														$enroll	= $cust_enrollment_id;
														$username = $User_email_id;
														$userid=1;
														$what="POS Transaction";
														$where="POS";
														$To_enrollid =$cust_enrollment_id;
														$firstName =$fname;
														$lastName =$lname; 
														$Seller_name =$fname.' '.$lname;
														$opval = $Merchandize_item_name.', (Item Code = '.$Company_merchandize_item_code.', Quantity= '.$Pos_item_qty.' )';
														$result_log_table = $this->Merchant_api_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
													/***Insert online purchase log tbl entery******/
													}
													
													$loyalty_prog = $this->Pos_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
													$lp_count = count($loyalty_prog);

													if(count($Applied_loyalty_id) != 0)
													{		
														for($l=0;$l<count($Applied_loyalty_id);$l++)
														{
															$Get_loyalty = $this->Pos_model->Get_loyalty_details_for_online_purchase($Applied_loyalty_id[$l]);

															foreach($Get_loyalty as $rec)
															{
																$Loyalty_at_transaction = $rec['Loyalty_at_transaction'];
																$lp_type=substr($rec['Loyalty_name'],0,2);	
																$discount = $rec['discount'];

																if($lp_type == 'PA')
																{		
																	if($Loyalty_at_transaction != 0.00)
																	{
																		$Calc_rewards_points=(($Purchase_amount*$Loyalty_at_transaction)/100);
																	}
																	else
																	{
																		$Calc_rewards_points=(($Purchase_amount*$discount)/100);
																	}
																}

																if($lp_type == 'BA')
																{	
																	if($Loyalty_at_transaction != 0.00)
																	{
																		$Calc_rewards_points=(($Balance_to_pay*$Loyalty_at_transaction)/100);
																	}
																	else
																	{
																		$Calc_rewards_points=(($Purchase_amount*$discount)/100);
																	}
																}
															}
															
														   $child_data = array(					
																			'Company_id' => $Company_id,        
																			'Transaction_date' => $lv_date_time,       
																			'Seller' => $Pos_outlet_id1,
																			'Enrollement_id' => $cust_enrollment_id,
																			'Transaction_id' => $Transaction_detail,
																			// 'Loyalty_id' => $trans_lp_id,
																			'Loyalty_id' => $Applied_loyalty_id[$l],
																			// 'Reward_points' => round($Calc_rewards_points)
																			'Reward_points' => $Calc_rewards_points
																			);
															$child_result = $this->Pos_model->insert_loyalty_transaction_child($child_data);
														}
													}
												/***************Update gift card and vouchers 23-2-2021********************/
													$redeemed_discount_voucher = $Pos_voucher_no; 
								
													if($redeemed_discount_voucher != Null)
													{
														$giftData1["Card_balance"] = 0;
														$giftData1["Update_user_id"] = $Pos_outlet_id1;
														$giftData1["Update_date"] = date('Y-m-d H:i:s');

														$this->db->where(array("Gift_card_id"=>$redeemed_discount_voucher,"Company_id"=>$Company_id,"Card_id"=>$CardId));
														$this->db->update("igain_giftcard_tbl",$giftData1);	
														
														$Voucher_array[] = $redeemed_discount_voucher;
													
													//*******************Update Trans table Free_item_quantity*****************************/
													/*	$Free_quantity = $this->Merchant_api_model->Get_freeVoucher_quantity($Company_id,$redeemed_discount_voucher);
														$updateData1 = array('Free_item_quantity' => $Free_quantity->Quantity);
											
														$this->db->where(array('Trans_id' => $Transaction_detail,'Item_code' => $Free_quantity->Company_merchandize_item_code));
														$this->db->update("igain_transaction",$updateData1);*/
														// echo "<br><br>update-->".$this->db->last_query();
														// print_r($data['Free_item_arr']); 
														
														if($data['Free_item_arr'] != NULL)
														{
															foreach ($data['Free_item_arr'] as $key => $value) 
															{
																$FreeItemCode = $key;
																$Free_item_qty = $value;
																// echo "FreeItemCode--".$FreeItemCode;
																// echo "Free_item_qty--".$Free_item_qty;
																// echo "Trans_id--".$Transaction_detail; exit;
																
																$updateData1 = array('Free_item_quantity' => $Free_item_qty);
											
																$this->db->where(array('Trans_id' => $Transaction_detail,'Item_code' => $FreeItemCode));
																$this->db->update("igain_transaction",$updateData1);
															}
														}
														
														
													//*******************Update Trans table Free_item_quantity*****************************/
													}
												/***************Update gift card and vouchers 23-2-2021********************/
													$Order_date = date('Y-m-d');	
													$lvp_date_time = date("Y-m-d H:i:s");
											/**********************Stamp offer logic 02-02-2021**************************/
												if($Stamp_item_flag == 1)
												{ 
													$Product_offers = $this->Merchant_api_model->get_product_offers($Merchandise_item_id,$Merchandize_category_id,$Company_id,$seller_id);
													// echo "brand id".$seller_id;
													// print_r($Product_offers);
													// exit;
													if($Product_offers != null)
													{		
														foreach($Product_offers as $offer)
														{	
															$Offers_items = $this->Merchant_api_model->get_offer_selected_items($offer['Offer_code'],$Company_id);
															// print_r($Offers_items);
															$Total_item_purchase = array();
															if($Offers_items != NULL)
															{
																foreach($Offers_items as $rec)
																{
																	$Total_item_purchase[] = $this->Merchant_api_model->get_item_purchase_count($rec->Company_merchandize_item_code,$Company_id,$Customer_enroll_id,$offer['From_date'],$offer['Till_date']);
																}
															}
															
															$Total_count_item= array_sum($Total_item_purchase);	
															// print_r($Total_item_purchase);
															// echo "--------Total_count_item-------".$Total_count_item."-----Buy_item-----".$offer['Buy_item']; exit;
															if($Total_count_item >= $offer['Buy_item'])
															{
																$Total_sent_voucher = $this->Merchant_api_model->member_sent_offers($Company_id,$Customer_enroll_id,$offer['Offer_code'],$offer['Free_item_id']);
																
																$Voucher_count = floor($Total_count_item/$offer['Buy_item']);
																
																$Need_to_Send_Voucher = ($Voucher_count-$Total_sent_voucher);
																
																// echo "<br><br>Total_sent_voucher :: ".$Total_sent_voucher;	
																// echo "<br><br>Voucher_count :: ".$Voucher_count;	
																// echo "<br><br>Need_to_Send_Voucher :: ".$Need_to_Send_Voucher;	
																
																for($A=1;$A<= $Need_to_Send_Voucher;$A++)
																{
																	// echo "<br><br>A::$A";
																	// $FreeItem = $this->Merchant_api_model->Get_Merchandize_Item_details($offer['Free_item_id']);
															
																	$characters = '0123456789';
																	$string = '';
																	$ProductVoucher_no="";
																	for ($i = 0; $i < 10; $i++) 
																	{
																		$ProductVoucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
																	}
																	
																	$FreeItem = $this->Merchant_api_model->get_offer_free_items($offer['Offer_code'],$Company_id);
																	
																	foreach($FreeItem as $FreeItem)
																	{
																		$data76['Company_id'] = $Company_id;
																		$data76['Enrollement_id'] = $Customer_enroll_id;
																		 
																		$data76['Offer_code'] = $offer['Offer_code'];
																		$data76['Voucher_type'] = 123;
																		$data76['Voucher_code'] = $ProductVoucher_no;
																		$data76['Quantity'] = $offer['Free_item'];
																		$data76['Company_merchandise_item_id'] = $FreeItem->Free_item_id;
																		$data76['Company_merchandize_item_code'] = $FreeItem->Company_merchandize_item_code;
																		$data76['Item_name'] = $FreeItem->Merchandize_item_name;
																		$data76['Cost_price'] = $FreeItem->Billing_price;
																		
																		$data76['Valid_from'] = date("Y-m-d");
																		$data76['Valid_till'] = date("Y-m-d",strtotime("+$Stamp_voucher_validity days")); 
																		$data76['Active_flag'] = 1;
																		$data76['Creation_date'] = date("Y-m-d H:i:s");
																		
																		$this->Merchant_api_model->insert_product_voucher($data76);
																	}
																	/* $data76['Company_id'] = $Company_id;
																	$data76['Enrollement_id'] = $Customer_enroll_id;
																	 
																	$data76['Offer_code'] = $offer['Offer_code'];
																	$data76['Voucher_type'] = 123;
																	$data76['Voucher_code'] = $ProductVoucher_no;
																	$data76['Quantity'] = $offer['Free_item'];
																	$data76['Company_merchandise_item_id'] = $offer['Free_item_id'];
																	$data76['Company_merchandize_item_code'] = $FreeItem->Company_merchandize_item_code;
																	$data76['Item_name'] = $FreeItem->Merchandize_item_name;
																	$data76['Cost_price'] = ($FreeItem->Billing_price * $offer['Free_item']);
																	
																	$data76['Valid_from'] = date("Y-m-d");
																	$data76['Valid_till'] = date("Y-m-d",strtotime("+$Stamp_voucher_validity days")); 
																	$data76['Active_flag'] = 1;
																	$data76['Creation_date'] = date("Y-m-d H:i:s");
																	
																	$this->Merchant_api_model->insert_product_voucher($data76); */
													
															//****insert in gift card tbl ***********
																	$data77['Company_id'] = $Company_id;
																	$data77['Gift_card_id'] = $ProductVoucher_no;
																	
																	$data77['Valid_till'] = date("Y-m-d",strtotime("+$Stamp_voucher_validity days"));
																	$data77['Card_balance'] = 100;
																	$data77['Discount_percentage'] = 100;
															
																	$data77['Card_id'] = $CardId;
																	$data77['Email'] = App_string_encrypt($User_email_id);
																	$data77['Phone_no'] = App_string_encrypt($phno);
																	$data77['Payment_Type_id'] = 997;
																	$data77['Seller_id'] = $delivery_outlet;
																	$data77['Create_date'] = date("Y-m-d");
																	
																	$this->Merchant_api_model->insert_voucher_in_gift_card($data77);
															//****insert in gift card tbl ***********
															//****now send product voucher notification *****************
																			
																$Email_content76 = array
																	( 
																		'Notification_type' => ' product voucher from '.$Company_name,
																		'Transaction_date' => $lvp_date_time,
																		'Symbol_of_currency' => $Symbol_currency,
																		'Orderno' => $bill,	
																		'Outlet_address' => $Outlet_address,
																		'CustEmail' => App_string_decrypt($User_email_id),
																		'Voucher_no' => $ProductVoucher_no,
																		'Description' => "You have collected ".$offer['Free_item']." Stamps from ".$seller_name." and recieved ".$offer['Offer_name']." on us. <br><br> Present this voucher code to the cashier to redeem your ".$offer['Free_item']." ".$offer['Offer_name']."*",
																		'Voucher_validity' => date("Y-m-d",strtotime("+$Stamp_voucher_validity days")),
																		'Template_type' => 'Product_voucher'
																	);
																			
																//print_r($Email_content76);
																	$PVoucherNotification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content76,'0',$Company_id);
																}
															}
														}
													}
												}
											/**********************Stamp offer logic 02-02-2021**************************/
											}
											$Extra_earn_points = array_sum($Extra_earn_points_Loyalty_pts);
											$total_loyalty_email=(array_sum($Email_points)+ $Extra_earn_points);	
											
											// $total_loyalty_email = floor($total_loyalty_email); // 25/11/2020
											$total_loyalty_email = round($total_loyalty_email);
										}
										/*$redeemed_discount_voucher = $Pos_voucher_no; 
								
										if($redeemed_discount_voucher != Null)
										{
											$giftData1["Card_balance"] = 0;
											$giftData1["Update_user_id"] = $Pos_outlet_id1;
											$giftData1["Update_date"] = date('Y-m-d H:i:s');

											$this->db->where(array("Gift_card_id"=>$redeemed_discount_voucher,"Company_id"=>$Company_id,"Card_id"=>$CardId));
											$this->db->update("igain_giftcard_tbl",$giftData1);	
											
											$Voucher_array[] = $redeemed_discount_voucher;
										
										//*******************Update Trans table Free_item_quantity*****************************
											$Free_quantity = $this->Merchant_api_model->Get_freeVoucher_quantity($Company_id,$redeemed_discount_voucher);
											$updateData1 = array('Free_item_quantity' => $Free_quantity->Quantity);
								
											$this->db->where(array('Trans_id' => $Transaction_detail,'Item_code' => $Free_quantity->Company_merchandize_item_code));
											$this->db->update("igain_transaction",$updateData1);
											// echo "<br><br>update-->".$this->db->last_query();
										//*******************Update Trans table Free_item_quantity*****************************
										}*/
										/**************new logic with pos items*****************/
										/************* Update Current Balance ******************/
											$cid = $CardId;							
											$redeem_point = $Cust_redeem_point;	
											$Update_Current_balance = ($bal - $redeem_point + $total_loyalty_email);
											
											$Update_total_purchase = $total_purchase + $subtotal;
											$Update_total_reddems = $Total_reddems + $Cust_redeem_point;
											$up = array('Current_balance' => $Update_Current_balance, 'total_purchase' => $Update_total_purchase, 'Total_reddems' => $Update_total_reddems,'pinno_used' => 1);
												
											$this->Pos_model->update_cust_balance($up,$cid,$Company_id);	
											
											$bill_no = $bill + 1;
											$billno_withyear = $str.$bill_no;
											$result4 = $this->Pos_model->update_billno($seller_id,$billno_withyear);
										/*********** Update Current Balance ***************/
										
										$lvp_date_time = date("Y-m-d H:i:s");    
										
										$Email_content = array
										(
											// 'Notification_type' => 'Thank you for your Pos Purchase on '.$Pos_outlet_name,
											'Notification_type' => 'Store Purchase',
											'Transaction_date' => $lvp_date_time,
											'Orderno' => $bill,
											'Pos_billno' => $Pos_bill_no,
											'Voucher_array' => $Voucher_array, 
											'Voucher_status' => $Voucher_status, 
											'Cust_wish_redeem_point' => round($Cust_redeem_point), 
											'EquiRedeem' =>  round($EquiRedeem, 2),
											'subtotal' => $subtotal, 
											'grand_total' => round($grand_total, 2), 
											'total_loyalty_points' => $total_loyalty_email, 
											'Update_Current_balance' => $Update_Current_balance, 
											'Blocked_points' => $Blocked_points, 
											'Standard_charges' => 0, 
											'Shipping_charges_flag' => $Shipping_charges_flag,
											'Symbol_of_currency' => $Symbol_currency, 
											'Delivery_type' => 2, 
											'DeliveryOutlet' => $Pos_outlet_id1, 
											'Outlet_address' => $Outlet_address, 
											'Bill_items' => $Pos_bill_items, 
											'DiscountAmt' => $Pos_discount_amount,
											'VoucherDiscountAmt' => $Pos_voucher_amount,  
											'Template_type' => 'Pos_Purchase_order' 
										);	
										
									$Notification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,'0',$Company_id); 
									
									// $Discount_codes = $this->session->userdata('Discount_codes'); //print_r($Discount_codes);
									
									$DiscountResultVal = $this->Merchant_api_model->get_payment_type_discount_value($Payment_type_id,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,$grand_total);
									
									
									if($DiscountResultVal != Null) {
									foreach($DiscountResultVal as $f)
									{
										$Discount_codes[] = $f;
									} }
									
									if($Discount_codes != null)
									{
										foreach($Discount_codes as $y)
										{
											//	echo "Discount_voucher_code--".$y['Discount_voucher_code']; continue;
											if($y['Discount_voucher_code'] != "")
											{
												if($y['Discount_voucher_percentage'] > 0)
												{
													$giftData["Card_balance"] = $y['Discount_voucher_percentage'];
													$giftData["Discount_percentage"] = $y['Discount_voucher_percentage'];
												}
												else if($y['Discount_voucher_amt'] > 0)
												{
													$giftData["Card_balance"] = $y['Discount_voucher_amt'];
													$giftData["Card_value"] = $y['Discount_voucher_amt'];
													$giftData["Discount_percentage"] = 0.00;
												}
												$giftData["Company_id"] = $Company_id;
												$giftData["Gift_card_id"] = $y['Discount_voucher_code'];
												// $giftData["Card_balance"] = $y['Discount_voucher_amt'];
												$giftData["Card_id"] = $CardId;
												$giftData["User_name"] = $fname.' '.$lname;
												$giftData["Email"] = $User_email_id;
												$giftData["Phone_no"] = $phno;
												$giftData["Payment_Type_id"] = 99;
												$giftData["Seller_id"] = $Pos_outlet_id1;
												$giftData["Valid_till"] = date("Y-m-d",strtotime($y['Discount_voucher_validity']));
												// $giftData["Card_value"] = $y['Discount_voucher_amt'];
												
												$this->db->insert("igain_giftcard_tbl",$giftData);	
											
											//**************sandeep discount voucher 30-01-2020****************
												$Email_content = array
													( 
														// 'Notification_type' => 'Thank you for your Purchase on '.$Pos_outlet_name,
														'Notification_type' => 'Discount Voucher',
														'Transaction_date' => $lvp_date_time,
														'Symbol_of_currency' => $Symbol_currency,
														'Orderno' => $bill,	
														'Outlet_address' => $Outlet_address,
														'CustEmail' => $User_email_id,
														'Voucher_no' => $y['Discount_voucher_code'],
														'Reward_amt' => $y['Discount_voucher_amt'],
														'Reward_percent' => $giftData["Discount_percentage"],
														'Voucher_validity' => date("Y-m-d",strtotime($y['Discount_voucher_validity'])),
														'Outlet_name' => $Pos_outlet_name,
														'Template_type' => 'Discount_voucher'
													); 
													
											$GiftNotification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,'0',$Company_id);
											}
										//**************sandeep discount voucher 30-01-2020*****************
										}
									}
										
									$insert_transaction_id = 1 ;
									if($insert_transaction_id > 0)
									{  
										$Updateed_Balance=$Update_Current_balance-($Blocked_points+$Debit_points);	
									
										if($Updateed_Balance<0)
										{
											$Available_Balance=0; 
										}
										else
										{
											$Available_Balance=$Updateed_Balance;
										}
									//***** 18-03-2020 ************
										$_SESSION['DiscountAmt'] = "";
										$_SESSION['BillDiscount'] = "";
										$_SESSION['ItemDiscounts'] = "";
										
									//***** 18-03-2020 ************
									
										$Pos_discount_amount = $Pos_discount_amount - $Pos_discount;
										
										$Result123 = array(
													"Error_flag" => 1001,
													"Member_name" => $Memeber_name,
													"Bill_total" => number_format($subtotal,2),
													"POS_discount" => number_format($Pos_discount,2),
													"Discount_amount" => number_format($Pos_discount_amount,2),
													"Points_amount" => number_format($EquiRedeem,2),
													"Balance_due" => number_format($grand_total,2),
													"Gained_points" => $total_loyalty_email,
													"Current_balance" => round($Available_Balance)
													// 'Discount_details' => $Discount_codes  //discount voucher recived
												);
									/******************11-12-2020 insert JSON*****************/
											$inputArgs1 = json_encode($inputArgs);
											$outputArgs1 = json_encode($Result123);
											
											$Json_data = array('Company_id' => $Company_id,
																'Outlet_id' => $inputArgs['Outlet_No'],
																'Bill_no' => $inputArgs['Bill_No'],
																'Card_id' => $CardId,
																'Json_input' => $inputArgs1,
																'Json_output' => $outputArgs1);

											$this->db->insert('igain_pos_json_log', $Json_data);	
									/******************11-12-2020 insert JSON*****************/	
									
											echo json_encode($Result123); //Pos Loyalty Transaction done Successfully.
											exit;
									}
									else    
									{
										$Result124 = array(
													"Error_flag" => 2068
												);
												
											echo json_encode($Result124);  // Loyalty Transaction Failed
											exit;
									}
								}
								else
								{
									$Result3100 = array(
													"Error_flag" => 2009
												);
												
									echo json_encode($Result3100); //Unable to Locate Merchant Email id 
									exit;
								}
							}
							else
							{
								$Result127 = array(
													"Error_flag" => 2003,
													"Message" => "Membership Id Not found."
												);
												
								echo json_encode($Result127); //Unable to Locate membership id
								exit;
							}
						}
						else if($Pos_trans_type == 2)
						{	  					
							// $Merchant_email = $_REQUEST['Merchant_email'];
							// $Membership_id = $_REQUEST['Membership_id'];
							// $Order_no = $_REQUEST['Online_Order_no'];
							// $Manual_bill_no = $_REQUEST['Manual_bill_no'];
							
							$Pos_outlet_id = $inputArgs['Outlet_No'];
							$Membership_id = $inputArgs['Membership_id'];
							$Manual_bill_no = $inputArgs['Bill_No'];
							$Pos_bill_date_time = $inputArgs['Bill_Date_Time'];
							
							// $result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							$result1 = $this->Merchant_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
							
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								$Seller_name = $result1->First_name.' '.$result1->Last_name;
								$Seller_email = $result1->User_email_id;
								$timezone_entry=$result1->timezone_entry; 
								
								$timezone = new DateTimeZone($timezone_entry);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
								
								$currency_details = $this->Igain_model->Get_Country_master($result1->Country);
								$Symbol_of_currency = $currency_details->Symbol_of_currency;	
								
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
								
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								
								if($result!=NULL)
								{	
									if($result == 3111)
									{
										$Result1311 = array("Error_flag" => 3111, "Message" =>'Customer code expired'); 
										echo json_encode($Result1311);
										exit;		
									}							
									$Cust_enrollement_id = $result->Enrollement_id;
									$Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}else {
										$Current_point_balance=$Current_point_balance;
									}
									
									$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
											
								
									$result_order = $this->Merchant_api_model->Get_order_evouchers_details($Order_no,$Manual_bill_no,$Company_id,$Card_id,$Pos_outlet_id,$Pos_bill_date_time);
									
									if($result_order!=NULL) 
									{
										$Shipping_partner = $this->Merchant_api_model->Get_Shipping_partner($Company_id);
										if($Shipping_partner!=NULL)
										{
											foreach($Shipping_partner as $spart)
											{									
												$Shipping_Partner_id = $spart['Partner_id'];
												$Shipping_Partner_name = $spart['Partner_name'];
											}
										}
										
										$Item_details_array = array();
										$Loyalty_pts = array();
										foreach($result_order as $row)
										{ 
											$Item_name=$row->Merchandize_item_name;
											$Item_quantity=$row->Quantity;
											$Item_voucher_no=$row->Voucher_no;
											$Item_purchase_amount=$row->Purchase_amount;
											$Item_loyalty_pts=$row->Loyalty_pts;
											$Trans_date=$row->Trans_date;
											$Bill_no=$row->Bill_no;
											$Shipping_cost=$row->Shipping_cost;
											$Condiments_name=$row->Condiments_name;
											$Manual_billno=$row->Manual_billno;
											$Seller1=$row->Seller;
											$Order_type=$row->Order_type;
											
											$Item_details = array("Order_no" => $Order_no, "Item_name" =>$Item_name,"Quantity" => $Item_quantity, "Voucher_no" => $Item_voucher_no, "Purchase_amount" => $Item_purchase_amount, "Loyalty_points" => $Item_loyalty_pts, "Condiments_name" =>$Condiments_name, "Shipping_cost" => $Shipping_cost);
											
											$Item_details_array[] =$Item_details;
											$Loyalty_pts[]=$Item_loyalty_pts;
										}
										
										$Update_date=date("Y-m-d H:i:s");
										// $Order_date=date("F j, Y",strtotime($Trans_date));
										$Order_date=$Trans_date;
										$Update_date1=date("F j, Y, g:i A",strtotime($Update_date));
										
										$data2=array(
														"Voucher_status"=>20, // Delivered
														"Shipping_partner_id"=>$Shipping_Partner_id,
														"Update_User_id"=>$Seller_id,
														// "Manual_billno"=>$Manual_bill_no,
														"Update_date"=>$lv_date_time
													);
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no,$Pos_outlet_id,$Pos_bill_date_time);
										
										$Creadited_points1 = array_sum($Loyalty_pts);
										
										$Creadited_points = floor($Creadited_points1);
										
										$Update_Current_balance= $Current_balance+$Creadited_points;
										
										$up = array('Current_balance' => $Update_Current_balance);
										
										$this->Merchant_api_model->update_transaction($up,$Card_id,$Company_id);
								
										$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_enrollement_id);
							
										$Current_balance1 = $Enroll_details->Current_balance;
										$Blocked_points1 = $Enroll_details->Blocked_points;
										$Debit_points1 = $Enroll_details->Debit_points;
										$Member_name = $Enroll_details->First_name.' '.$Enroll_details->Middle_name.' '.$Enroll_details->Last_name;
										$Current_point_balance1 = $Current_balance1 - ($Blocked_points1 + $Debit_points1);

										if ($Current_point_balance1 < 0) 
										{
											$Current_point_balance = 0;
										}
										else 
										{
											$Current_point_balance = $Current_point_balance1;
										}
										if($Order_type== 28)
										{
											$Order_type1 = "Pick-Up";
											$OrderStatus = "Collected";
										}
										else if($Order_type== 29)
										{
											$Order_type1 = "Delivery";
											$OrderStatus = "Delivered";
										}
										else if($Order_type== 107)
										{
											$Order_type1 = "In-Store";
											$OrderStatus = "Collected";
										}
										else
										{
											$Order_type1 = "";
											$OrderStatus = "";
										}
										
										$POS_bill_no = $Manual_billno;
					
										if($POS_bill_no == NULL)
										{
											$POS_bill_no='-';
										}
										
										$Outlet_details = $this->Igain_model->get_enrollment_details($Seller1);
					
										$Outlet_name=$Outlet_details->First_name.' '.$Outlet_details->Last_name;
										
										/**********************Send Email Notification to Customer*************************/
									
										$banner_image=$this->config->item('base_url').'/images/fulfillment.jpg';	

										$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_name1;

										$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
										$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
										<head>
												<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
										</head>';

										$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';

										$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
										<tr>
											<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
										<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
										</tr>

										<tr>
											<td vAlign=top>
												<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
												<tr>
													<td style="PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px">
													<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
														<tr style="HEIGHT: 10px">
															<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
																
																<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #000000; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
																Dear '.$Member_name.',
																</P>';
																$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #000000; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>';
																
																/*Thank you for placing your Online Order.<br>';*/
																if($Order_type== 28)
																{
																	$html.='<br>';
																}
																if($Order_type== 107)
																{
																	$html.='<br>';
																}
																if($Order_type== 29)
																{
																	//$html.='Your Order is now out for Delivery <br><br>';
																}
																$html.='Thank you for your recent purchase with us. (Refer , Order No. : <b>'. $Bill_no.'</b> on <b>'.$Order_date.'</b>) Your item(s) has been '.$OrderStatus.'.<br><br>
																
																As part of the ongoing Campaign in the Loyalty Program, for your above purchase, you are entitled to earned <b> '.$Creadited_points.'</b> '.$Comapany_Currency.'
																So, now your Current Balance is : <b>'.$Current_point_balance.'</b> '.$Comapany_Currency.'<br><br>';	
																
																$html.='Please see details below :<br> <br>';
																
																$html.='<strong>Date: </strong> '.$Order_date. '<br><br>
																<strong>Order Type: </strong> '.$Order_type1. '<br><br>
																<strong>Outlet: </strong> '.$Outlet_name. '<br><br>
																<strong>Order No: </strong> '.$Bill_no. '<br><br>
																<strong>Bill No: </strong> '.$POS_bill_no. '<br>
																
																<br>
																</P>';
												
																
																$html.='<div class="table-responsive">				
																<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"  border=0 cellSpacing=0 cellPadding=0 align=center> 
																<thead>
																</thead>
																<tbody>'; 
																
																$html .= '<TR>
																	   
																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b>Menu Item</b>
																	   </TD>';
																	   
																	   /* <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b> </b>
																		</TD>*/
																		
																	   $html .= '<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Qty</b>
																	   </TD>

																	   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Amount('.$Symbol_of_currency.')</b> 
																	   </TD>';
																	   
																	$html .= '</TR>';
																		
																	$i=1;
																	foreach($Item_details_array as $item_array)
																	{
																		$html .= '<TR>
																			
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Item_name"].'
																																																									</TD>';
																																																							/*<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Condiments_name"].'</TD>*/
																																																							
																			$html .= '<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Quantity"].'
																			</TD>
																			
																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Purchase_amount"].'
																			</TD>';
																			
																		 $html .='</TR>';
																		$i++;
																	}

																	$html .='</tbody>
																</TABLE>
																</div>												
																<br>';	
																
												$html .= '</td></tr></table></td></tr>';
												
												$html.='</table></td></tr>';					
																							 
												$html.='</table>
													</td></tr>
												</table>	
											</table>
											</body>
										</html>
										
										<style>
											td, th{
											font-size: 13px !IMPORTANT;
											}
										</style>';
										
										$Email_content = array(
													'Order_no' => $Bill_no,
													'Order_date' => $Order_date,
													'Update_date'  => $lv_date_time,
													'Update_details' => $html,
													'Notification_type' => 'Your '.$Outlet_name.' Order has been '.$OrderStatus,
													'Template_type' => 'Update_online_order_status'
												);
												
										$Notification=$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id);
							
										/**********************Send Email Notification to Customer*************************/
										$Update_status = array(
												"Error_flag" => 1001,
												"Member_name" => $Member_name,
												"Order_status" => $OrderStatus,
												"Online_order_no" => $Bill_no, 
												"POS_bill_no" => $Manual_bill_no, 
												"Membership_id" => $Card_id,
												"Gained_points" => $Creadited_points, 
												// "Balance_points" => $Current_point_balance, // 15-6-2020
												"Current_balance" => $Current_point_balance
											);
										
										echo json_encode($Update_status);  // Order Successfully Delivered
										exit;
									}
									else
									{
										$Result11 = array("Error_flag" => 3011,
															"Message" =>'Invalid Order no. or Order not found'); //Invalid Order no. / Order not found
										echo json_encode($Result11);
										exit;
									}
								}
								else    
								{
									$Result127 = array("Error_flag" => 2003,
														"Message" =>'Unable to Locate membership id'); //Unable to Locate membership id
									echo json_encode($Result127);
									exit;
								}
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009,
													"Message" => 'Outlet id not found');
								echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
								exit;
							}
						}
					}
					if($API_flag == 91) // Purchase Gift Card 
					{ 
						$cardId = $inputArgs['Membership_id'];
						$Pos_outlet_id = $inputArgs['Outlet_No'];
						$Pos_bill_no = $inputArgs['Bill_No'];
						$Pos_bill_date_time = $inputArgs['Bill_Date_Time'];
						$Gift_card_amount = $inputArgs['Gift_Card_Amount'];
						
						$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code 			
						$phnumber = $dial_code.$inputArgs['Membership_id'];
						
						$cust_details = $this->Merchant_api_model->cust_details_from_card($Company_id,$cardId,$phnumber); //Get Customer details
						if($cust_details !=NULL)
						{
							foreach($cust_details as $row25)
							{
								$Customer_enroll_id=$row25['Enrollement_id'];
								$CardId=$row25['Card_id'];
								$fname=$row25['First_name'];
								$midlename=$row25['Middle_name'];
								$lname=$row25['Last_name'];
								$User_email_id=$row25['User_email_id'];
								$Date_of_birth=$row25['Date_of_birth'];
								$address=$row25['Current_address'];
								$bal=$row25['Current_balance'];
								$Blocked_points=$row25['Blocked_points'];
								$Debit_points=$row25['Debit_points'];
								$phno=$row25['Phone_no'];
								$pinno=$row25['pinno'];
								$companyid=$row25['Company_id'];
								$cust_enrollment_id=$row25['Enrollement_id'];
								$image_path=$row25['Photograph'];				
								$filename_get1=$image_path;	
								$Tier_name = $row25['Tier_name'];
								$lv_member_Tier_id = $row25['Tier_id'];
								$Sex = $row25['Sex'];
								$District = $row25['District'];
								$Zipcode = $row25['Zipcode'];
								$total_purchase = $row25['total_purchase'];
								$Total_reddems = $row25['Total_reddems'];
							}
						
							$Current_balance = $bal;
							$Current_bal1 = $bal-($Blocked_points+$Debit_points);
					
							if($Current_bal1<0)
							{
								$Current_bal1=0;
							}
							else
							{
								$Current_bal1=$Current_bal1;
							}
							
							$result01 = $this->Merchant_api_model->check_pos_bill_no($Pos_bill_no,$Pos_outlet_id,$Company_id,$Pos_bill_date_time);				
							if ($result01 > 0)
							{
								$Result2067 = array("Error_flag" => 2067,
														"Message" => "POS bill no. already exist."
														); 
								echo json_encode($Result2067); //POS bill no. already exist
								exit;
							}
							
							$result = $this->Merchant_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
							if($result!=NULL)
							{
								$seller_id = $result->Enrollement_id;
								$seller_fname = $result->First_name;
								$seller_lname = $result->Last_name;
								$Pos_outlet_name = $seller_fname.' '.$seller_lname;
								$Seller_Redemptionratio = $result->Seller_Redemptionratio;
								$Purchase_Bill_no = $result->Purchase_Bill_no;
								$Sub_seller_admin = $result->Sub_seller_admin;
								$Sub_seller_Enrollement_id = $result->Sub_seller_Enrollement_id;
								$Outlet_address = App_string_decrypt($result->Current_address);
								$currency_details = $this->Igain_model->Get_Country_master($result->Country);
								$Symbol_currency = $currency_details->Symbol_of_currency;
								$Pos_outlet_id1 = $seller_id;
									
								if($Sub_seller_admin == 1) 
								{
								  $seller_id = $seller_id;
								}
								else 
								{
								  $seller_id = $Sub_seller_Enrollement_id;
								}
								$result17 = $this->Merchant_api_model->Get_outlet_details($seller_id,$Company_id); 
								$Purchase_Bill_no = $result17->Purchase_Bill_no;
								
								$tp_db = $Purchase_Bill_no;
								$len = strlen($tp_db);
								$str = substr($tp_db,0,5);
								$bill = substr($tp_db,5,$len);
								
								$date = new DateTime();
								$lv_date_time=$date->format('Y-m-d H:i:s'); 
								$lv_date_time2 = $date->format('Y-m-d'); 
					
								$Trans_type = 4;  // purchase gift card
								$Payment_type_id = 1;  //by cash
								$Remarks = "Purchase gift card from POS";
								$Paid_by = "Cash";  
								
								$Date = date("Y-m-d");
								$validity = $Gift_card_validity_days;
								$Valid_till = date("Y-m-d", strtotime($Date. " + $validity days"));
								
								$CustomerName = $fname.' '.$midlename.' '.$lname;
								$CustomerEmail = $User_email_id;
								$phno = $phno;
								
								$gift_cardid = $this->Merchant_api_model->getVoucher();
								
								$giftData["Company_id"] = $Company_id;
								$giftData["Gift_card_id"] = $gift_cardid;
								$giftData["Card_balance"] = $Gift_card_amount;
								$giftData["Card_value"] = $Gift_card_amount;
								$giftData["Card_id"] = $CardId;
								$giftData["User_name"] = trim($CustomerName);
								$giftData["Email"] = $CustomerEmail;
								$giftData["Phone_no"] = $phno;
								$giftData["Payment_Type_id"] = $Payment_type_id; 
								$giftData["Seller_id"] = $Pos_outlet_id;
								$giftData["Valid_till"] = $Valid_till;
								
								$this->db->insert("igain_giftcard_tbl",$giftData);	
								
								$data123 = array('Company_id' => $Company_id,
									'Trans_type' => $Trans_type, 
									'Purchase_amount' => $Gift_card_amount,
									'Paid_amount' => $Gift_card_amount,
									'COD_Amount' => $Gift_card_amount,
									'balance_to_pay' => $Gift_card_amount,
									'Payment_type_id' => $Payment_type_id,
									'Remarks' => $Remarks,
									'Trans_date' => $lv_date_time,
									'Enrollement_id' => $Customer_enroll_id,
									'Bill_no' => $bill,
									'Manual_billno' => $Pos_bill_no,
									'Card_id' => $CardId,
									'Seller' => $Pos_outlet_id,
									'Seller_name' => $Pos_outlet_name,
									'Online_payment_method' => $Paid_by,
									'Item_code' => $gift_cardid,
									'GiftCardNo' => $gift_cardid
								);	

								$Transaction_detail = $this->Pos_model->Insert_online_purchase_transaction($data123);	
				
								$Email_content = array(
									  'Todays_date' => $lv_date_time,
									  'GiftCardNo' => $gift_cardid,
									  'GiftCard_balance' => number_format($Gift_card_amount,2),
									  'Enrollment_id' => $Customer_enroll_id,
									  'Gift_card_user' => $CustomerName,
									  'Gift_card_Email' => $CustomerEmail,
									  'Valid_till' =>  date("d M Y", strtotime($Valid_till)),
									  'Order_no' => $bill,
									  'Bill_no' => $Pos_bill_no,
									  'Symbol_currency' => $Symbol_currency,
									  'Outlet_name' => $Pos_outlet_name,
									  'Notification_type' => 'Gift Card',
									  'Template_type' => 'Purchase_gift_card'
								  );
								
								$GiftNotification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,$Pos_outlet_id,$Company_id); 
								
								$bill_no = $bill + 1;
								$billno_withyear = $str.$bill_no;
								$result4 = $this->Pos_model->update_billno($seller_id,$billno_withyear);
							
								$GiftCardDetails = array(
												"Error_flag" => 1001,
												"Membership_id" => $CardId,
												"Member_name" => $CustomerName,
												"Order_no" => $bill, 
												"POS_bill_no" => $Pos_bill_no, 
												"Gift_card_number" => $gift_cardid, 
												"Gift_card_amount" => number_format($Gift_card_amount,2),
												"Valid_till" => date("d M Y", strtotime($Valid_till))
											);
										
								echo json_encode($GiftCardDetails);  // Gift card trans Successfully done
								exit;
							}
							else
							{
								$Result3100 = array(
													"Error_flag" => 2009,
													"Message" => "Unable to Locate Outlet id or invalid Outlet id"
												);
												
								echo json_encode($Result3100); //Unable to Locate Outlet id 
								exit;
							}			
						}
						else
						{
							$Result127 = array(
												"Error_flag" => 2003,
												"Message" => "Unable to Locate membership id or invalid membership id"
											);
											
							echo json_encode($Result127); //Unable to Locate membership id
							exit;
						}
					}
					/* if($API_flag == 86) 
					{ 					
						$Merchant_email = $_REQUEST['Merchant_email'];
						$Membership_id = $_REQUEST['Membership_id'];
						// $Order_no = $_REQUEST['Bill_no'];
						$Order_no = $_REQUEST['Online_Order_no'];
						$Manual_bill_no = $_REQUEST['Manual_bill_no'];
						
						$result1 = $this->Merchant_api_model->Get_Seller($Merchant_email,$Company_id); //Get Merchant Details
							
						if($result1!=NULL)
						{
							$Seller_id = $result1->Enrollement_id;
							$Seller_name = $result1->First_name.' '.$result1->Last_name;
							$Seller_email = $result1->User_email_id;
							
							/*  $Seller_details = array(
										"Error_flag" => 1001,
										"Seller_id" => $Seller_id,
										"Seller_name" => $Seller_name, 
										"Seller_email" => $Seller_email
									);
									
							echo json_encode($Seller_details);
							exit;	 */ 
							
						/*	$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
							$phnumber = $dial_code.$Membership_id;
							
							$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
							
							if($result!=NULL)
							{							
								$Cust_enrollement_id = $result->Enrollement_id;
								$Card_id = $result->Card_id;
								$Current_balance = $result->Current_balance;
								$Blocked_points = $result->Blocked_points;
								$Debit_points = $result->Debit_points;
								
								$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
								if($Current_point_balance < 0)
								{
									$Current_point_balance=0;
								}else {
									$Current_point_balance=$Current_point_balance;
								}
								
								$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
										
							/*  $member_details = array(
										"Error_flag" => 1001,
										"Membership_id" => $result->Card_id,
										"Member_name" => $Memeber_name, 
										"Member_email" => $result->User_email_id, 
										"Phone_no" => $result->Phone_no, 
										"Tier_name" => $result->Tier_name,
										"Balance_points" => $Current_point_balance
									);
								
								echo json_encode($member_details); 
								exit; */
							/*	$result_order = $this->Merchant_api_model->Get_order_evouchers_details($Order_no,$Manual_bill_no,$Company_id,$Card_id);
								
								if($result_order!=NULL)
								{
									$Shipping_partner = $this->Merchant_api_model->Get_Shipping_partner($Company_id);
									if($Shipping_partner!=NULL)
									{
										foreach($Shipping_partner as $spart)
										{									
											$Shipping_Partner_id = $spart['Partner_id'];
											$Shipping_Partner_name = $spart['Partner_name'];
										}
									}
									
									$Item_details_array = array();
									$Loyalty_pts = array();
									foreach($result_order as $row)
									{
										$Item_name=$row->Merchandize_item_name;
										$Item_quantity=$row->Quantity;
										$Item_voucher_no=$row->Voucher_no;
										$Item_purchase_amount=$row->Purchase_amount;
										$Item_loyalty_pts=$row->Loyalty_pts;
										$Trans_date=$row->Trans_date;
										$Bill_no=$row->Bill_no;
										
										$Item_details = array("Order_no" => $Order_no, "Item_name" =>$Item_name,"Quantity" => $Item_quantity, "Voucher_no" => $Item_voucher_no, "Purchase_amount" => $Item_purchase_amount, "Loyalty_points" => $Item_loyalty_pts);
										
										$Item_details_array[] =$Item_details;
										$Loyalty_pts[]=$Item_loyalty_pts;
									}
									
									$Update_date=date("Y-m-d H:i:s");
									$Order_date=date("F j, Y, g:i A",strtotime($Trans_date));
									$Update_date1=date("F j, Y, g:i A",strtotime($Update_date));
									
									$data2=array(
													"Voucher_status"=>20, // Delivered
													"Shipping_partner_id"=>$Shipping_Partner_id,
													"Update_User_id"=>$Seller_id,
													// "Manual_billno"=>$Manual_bill_no,
													"Update_date"=>$Update_date
												);
							
									$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no);
									
									$Creadited_points = array_sum($Loyalty_pts);
									
									$Update_Current_balance= $Current_balance+$Creadited_points;
									
									$up = array('Current_balance' => $Update_Current_balance);
									
									$this->Merchant_api_model->update_transaction($up,$Card_id,$Company_id);
							
									$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_enrollement_id);
						
									$Current_balance1 = $Enroll_details->Current_balance;
									$Blocked_points1 = $Enroll_details->Blocked_points;
									$Debit_points1 = $Enroll_details->Debit_points;
									$Member_name = $Enroll_details->First_name.' '.$Enroll_details->Middle_name.' '.$Enroll_details->Last_name;
									$Current_point_balance1 = $Current_balance1 - ($Blocked_points1 + $Debit_points1);

									if ($Current_point_balance1 < 0) 
									{
										$Current_point_balance = 0;
									}
									else 
									{
										$Current_point_balance = $Current_point_balance1;
									}
									
									/**********************Send Email Notification to Customer*************************/	
						
							/*		$banner_image=$this->config->item('base_url').'images/reward.jpg';	

									$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_name1 ;

									$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
									$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
									<head>
											<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
									</head>';

									$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';

									$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
									<tr>
										<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
									<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
									</tr>

									<tr>
										<td vAlign=top>
											<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px solid #d2d6de" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
											<tr>
												<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
												<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
													<tr style="HEIGHT: 10px">
														<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
															<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																<tr>
																	<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																	<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																		<tr>
																			<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																					<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=680 height=200 hspace="0" vspace="0">
																			</td>
																		</tr>
																	</table>
																	</td>
																</tr>
															</table> 

															<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
															Dear '.$Member_name.' ,
															</P>';
															$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
															
															Thank you for your recent purchase with us. (Refer , Order No. : <b>'. $Order_no.'</b> on <b>'.$Order_date.'</b>) Your item(s) has been Delivered.<br><br>
															
															As part of the ongoing Campaign in the Loyalty Program, for your above purchase, you are entitled to earned <b> '.$Creadited_points.'</b> '.$Comapany_Currency.'
															So, now your Current Balance is : <b>'.$Current_point_balance.'</b> '.$Comapany_Currency.'<br><br>	
															
															Please see details below :<br> <br> 
															
															<strong>Delivery Date :</strong> '.$Update_date1. '<br>
															<strong>Order No. :</strong> '.$Order_no. '<br><br>
															</P>';
															
															$html.='<div class="table-responsive">				
															<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"  border=0 cellSpacing=0 cellPadding=0 align=center> 
															<thead>
															</thead>
															<tbody>'; 
															
															$html .= '<TR>
																   <TD style="border: #dbdbdb 2px ;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Sr.No.</b>
																   </TD>
																   
																   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b>Item Name</b>
																   </TD>
																	
																   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Quantity</b>
																   </TD>

																   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Total Price ('.$Symbol_of_currency.')</b> 
																   </TD>
																	
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>'.$Comapany_Currency.' Earned </b>
																	</TD>
																</TR>';
																	
																$i=1;
																foreach($Item_details_array as $item_array)
																{
																	$html .= '<TR>
																		<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=center> '.$i.')
																																																						</TD>
																		<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Item_name"].'
																																																						</TD>
																		<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Quantity"].'
																		</TD>
																		
																		<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Purchase_amount"].'
																		</TD>
																		
																		<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Loyalty_points"].'
																		</TD>
																	  </TR>';
																	$i++;
																}

																$html .='
																</tbody>
															</TABLE>
															</div>												
															<br>';	
															
											$html .= '<br>
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
												Regards,
												<br>Loyalty Team.
												</P></td></tr></table></td></tr>

											<tr style="HEIGHT: 20px">
												<td class="row" style="margin-left:-12px;BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
															
											$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly;text-align:justify;" align="center">
											<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_name1.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
											If you are not the intended recipient or responsible for delivery to the intended recipient,
											you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_name1.' will not accept any claims for damages arising out of viruses.<br>
											Thank you for your cooperation.</em>
											</P> <br>';
											
											$html.='</td></tr></table></td></tr>';					
																						 
											$html.='</table>
												</td></tr><tr>
													<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
												</tr>
											</table>	
										</table>
										</body>
									</html>
									
									<style>
										td, th{
										font-size: 13px !IMPORTANT;
										}
									</style>';
									
									$Email_content = array(
												'Order_no' => $Bill_no,
												'Order_date' => $Order_date,
												'Update_date'  => $Update_date,
												'Update_details' => $html,
												'Notification_type' => 'Your '.$Company_name1.' Order #'.$Order_no.' has been DELIVERED',
												'Template_type' => 'Update_online_order_status'
											);
											
									$Notification=$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id);
						
									/**********************Send Email Notification to Customer*************************/
								/*	$Update_status = array(
											"Error_flag" => 1001,
											"Order_status" => 'Delivered',
											"Order_no" => $Bill_no, 
											"Manual_bill_no" => $Manual_bill_no, 
											"Membership_id" => $Card_id,
											"Gained_points" => $Creadited_points, 
											"Balance_points" => $Current_point_balance
										);
									
									echo json_encode($Update_status);  // Order Successfully Delivered
									exit;
								}
								else
								{
									$Result11 = array("Error_flag" => 3011); //Invalid Order no. / Order not found
									echo json_encode($Result11);
									exit;
								}
							}
							else    
							{
								$Result127 = array("Error_flag" => 2003); //Unable to Locate membership id
								echo json_encode($Result127);
								exit;
							}
						}
						else
						{
							$Result3100 = array("Error_flag" => 2009);
							echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
							exit;
						}
					} */
					/*********************Update Order Status*********************/
					/***********Issue Bonus Point Transaction API ****************/
					if($API_flag == 8)
					{
						$dial_code = $this->Igain_model->get_dial_code($Country_id);	
						$phnumber = $dial_code.$_REQUEST["Membership_id"];
						$cardId = $_REQUEST["Membership_id"];
						$Merchant_email_id = $_REQUEST["Merchant_email_id"];
						$Bonus_Points_Issued = $_REQUEST['Bonus_Points_Issued'];
						
						
						$Member_details = $this->Merchant_api_model->cust_details_from_card($Company_id,$cardId,$phnumber);//Get Customer details
						if($Member_details !=NULL)
						{
						  foreach($Member_details as $row52)
						  {
							$Card_details=$row52['Card_id'];
						  }
						
						$cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$Card_details);
						if($cust_details !=NULL)
						{
							foreach($cust_details as $row25)
							{
								$CardId=$row25['Card_id'];
								$fname=$row25['First_name'];
								$midlename=$row25['Middle_name'];
								$lname=$row25['Last_name'];
								$bdate=$row25['Date_of_birth'];
								$address=$row25['Current_address'];
								$card_bal=$row25['Current_balance'];
								$Blocked_points=$row25['Blocked_points'];
								$phno=$row25['Phone_no'];
								$pinno=$row25['pinno'];
								$companyid=$row25['Company_id'];
								$cust_enrollment_id=$row25['Enrollement_id'];
								$image_path=$row25['Photograph'];				
								$filename_get1=$image_path;	
								$Tier_name = $row25['Tier_name'];
								$lv_member_Tier_id = $row25['Tier_id'];
								$topup = $row25['Total_topup_amt'];
								$purchase_amt = $row25['total_purchase'];
								$reddem_amt = $row25['Total_reddems'];
								
							}
							$result = $this->Merchant_api_model->Get_Seller($Merchant_email_id,$Company_id); //Get Merchant Details
							
							if($result!=NULL)
							{
								$seller_User_id = $result->User_id;
								$Merchant_id = $result->Enrollement_id;
								$seller_fname = $result->First_name;
								$seller_lname = $result->Last_name;
								$seller_name = $seller_fname .' '. $seller_lname;
								$Seller_Redemptionratio = $result->Seller_Redemptionratio;
								$Purchase_Bill_no = $result->Purchase_Bill_no;
								
								if($seller_User_id == 3)
								{
									$top_seller = $this->Transactions_model->get_top_seller($Company_id);
									foreach($top_seller as $sellers)
									{
										$seller_id = $sellers['Enrollement_id'];
										$bill = $sellers['Topup_Bill_no'];
										$username = $sellers['User_email_id'];
										$remark_by = 'By Admin';
										$seller_curbal = $sellers['Current_balance'];
										$Seller_Redemptionratio = $sellers['Seller_Redemptionratio'];
									}
								}
								else
								{
									$user_details = $this->Igain_model->get_enrollment_details($Merchant_id);
									$seller_id = $user_details->Enrollement_id;
									$bill = $user_details->Topup_Bill_no;
									$username = $user_details->User_email_id;
									$remark_by = 'By Seller';
									$seller_curbal = $user_details->Current_balance;
									$Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
									$Sub_seller_admin = $user_details->Sub_seller_admin;
									$Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;
									
									if($Sub_seller_admin==1)
									{
										$seller_id=$seller_id;
									}
									else
									{
										$seller_id=$Sub_seller_Enrollement_id;
									}
								}
									$logged_user_details = $this->Igain_model->get_enrollment_details($Merchant_id);
									
									$tp_db = $logged_user_details->Topup_Bill_no;
									$len = strlen($tp_db);
									$str = substr($tp_db,0,5);
									$bill = substr($tp_db,5,$len);
									$Seller_name = $logged_user_details->First_name." ".$logged_user_details->Middle_name." ".$logged_user_details->Last_name;
									$bill_no = $bill + 1;
									
									if ($Seller_Redemptionratio != NULL)
									{
										$redemptionratio = $Seller_Redemptionratio;					
									}
									else
									{
										$company_details = $this->Igain_model->get_company_details($Company_id);
										$redemptionratio = $company_details->Redemptionratio;
									}
									
									$post_data = array(					
												'Trans_type' => '1',
												'Company_id' => $Company_id,
												'Topup_amount' => $_REQUEST['Bonus_Points_Issued'],        
												'Trans_date' => $lv_date_time,       
												'Remarks' => $_REQUEST['Remarks'],
												'Card_id' => $CardId,
												'Seller_name' => $Seller_name,
												'Seller' => $seller_id,
												'Enrollement_id' => $cust_enrollment_id,
												'Bill_no' => $bill,
												'Manual_billno' => $_REQUEST['Manual_bill_no'],
												'remark2' => $remark_by,
												'Loyalty_pts' => ''
											);
									$result = $this->Transactions_model->insert_topup_details($post_data);
									
									$curr_bal = $card_bal + $_REQUEST['Bonus_Points_Issued'];
									$topup_amt = $topup + $_REQUEST['Bonus_Points_Issued'];
									$purchase_amount = $purchase_amt;	
									$reddem_amount = $reddem_amt;	
									 
								$result2 = $this->Transactions_model->update_customer_balance($CardId,$curr_bal,$Company_id,$topup_amt,$Todays_date,$purchase_amount,$reddem_amount);
					
								$billno_withyear = $str.$bill_no;
								$company_details2 = $this->Igain_model->get_company_details($Company_id);
								$Sms_enabled = $company_details2->Sms_enabled;
								$Seller_topup_access = $company_details2->Seller_topup_access;
								
								if($Seller_topup_access == '1')
								{
									$Total_seller_bal = $seller_curbal - $_REQUEST['Bonus_Points_Issued'];
									$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
							
									/*********************Send Threshold Mail****************/
									$company_details = $this->Igain_model->get_company_details($Company_id);
									$Threshold_Merchant = $company_details->Threshold_Merchant;
									
									$seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
									$Seller_balance = $seller_details2->Current_balance;
									$Seller_full_name = $seller_details2->First_name." ".$seller_details2->Last_name;
							
									if($Threshold_Merchant >= $Seller_balance)
									{
										//****mail to super seller
										$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);	
										$Company_admin = $Super_Seller->First_name." ".$Super_Seller->Last_name;
										$Admin_Email_content = array(
											'Seller_name' => $Seller_full_name,
											'Seller_balance' => $Seller_balance,
											'Super_Seller_flag' => 1,
											'Notification_type' => "Seller Threshold Balance",
											'Template_type' => 'Seller_threshold'
										);
										$this->send_notification->send_Notification_email($Super_Seller->Enrollement_id,$Admin_Email_content,$seller_id,$Company_id);
										//****mail to super seller										
										//****mail to seller
										$Seller_Email_content = array(
											'Seller_name' => $Seller_full_name,
											'Seller_balance' => $Seller_balance,									
											'Company_admin' => $Company_admin,									
											'Super_Seller_flag' => 0,
											'Notification_type' => "Seller Threshold Balance",
											'Template_type' => 'Seller_threshold'
										);
										$this->send_notification->send_Notification_email($seller_id,$Seller_Email_content,$seller_id,$Company_id);
										//****mail to seller
									}
									/*********************Send Threshold Mail****************/
								}
								
								$result4 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear);
								
								$Email_content = array(									
									'Todays_date' => $lv_date_time,
									'topup_amt' => $_REQUEST['Bonus_Points_Issued'],
									'manual_bill_no' => $_REQUEST['Manual_bill_no'],
									'Notification_type' => 'Bonus Point',
									'Template_type' => 'Issue_bonus'
								);
								
								$this->send_notification->send_Notification_email($cust_enrollment_id,$Email_content,$seller_id,$Company_id);				
								
								if($result2 > 0)
								{  
									$Result123[] = array("Error_flag" => 1001, "Bonus_Points_Issued" => $Bonus_Points_Issued, "Update_Current_balance" => $curr_bal-$Blocked_points);
									$this->output->set_output(json_encode($Result123)); //Bonus Point Transaction done Successfully
								}
								else    
								{
									$Result124[] = array("Error_flag" => 2068);  
									$this->output->set_output(json_encode($Result124)); // Bonus Point Transaction Failed
								}
							}
							else
							{
								$Result3100[] = array("Error_flag" => 2009);
								$this->output->set_output(json_encode($Result3100)); //Unable to Locate Merchant Email id 
							}
						}
						else
						{
							$Result127[] = array("Error_flag" => 2003);
							$this->output->set_output(json_encode($Result127)); //Unable to Locate membership id
						}
						}
						else
						{
							$Result1278[] = array("Error_flag" => 2003);
							$this->output->set_output(json_encode($Result1278)); //Unable to Locate membership id
						}
					}
					/**********************Issue Bonus Point Transaction API *************************/
					/**********************Validate Gift Card API ***********************************/
					if($API_flag == 77)
					{
						$merchant_email = $_REQUEST["merchant_email"];
						$gift_card = $_REQUEST["gift_card_number"]; 
						
						$result123 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);
						if($result123!=NULL)
						{
							$seller_id = $result123->Enrollement_id;
						
							$result = $this->Transactions_model->check_gift_card_id($gift_card,$Company_id);
							if($result > 0)
							{
								// $this->output->set_output("InValid"); 
								$Result2072 = array("Error_flag" => 2072);
								$this->output->set_output(json_encode($Result2072)); //already exist
							}
							else    
							{
								// $this->output->set_output("Valid");
								$Result1001 = array("Error_flag" => 1001); // Status OK
								$this->output->set_output(json_encode($Result1001));
							}
						}
						else
						{
							$Result3100 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result3100));
						}
					 
					}
					/****************Validate Gift Card API ************************/
					/****************Assign Gift Card API ************************/
					if($API_flag == 10)
					{
						$Merchant_email_id = $_REQUEST["Merchant_email_id"];
						// $Membership_id = $_REQUEST["CardID"];
						
						$result = $this->Merchant_api_model->Get_Seller($Merchant_email_id,$Company_id); //Get Merchant Details
							
							if($result!=NULL)
							{
								$seller_User_id = $result->User_id;
								$Merchant_id = $result->Enrollement_id;
								$seller_fname = $result->First_name;
								$seller_lname = $result->Last_name;
								$seller_name = $seller_fname .' '. $seller_lname;
								$currency_details = $this->Igain_model->Get_Country_master($result->Country);
								$Symbol_currency = $currency_details->Symbol_of_currency;
								
								// $cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$Membership_id);
								// if($cust_details !=NULL)
								// {
									// foreach($cust_details as $row25)
									// {
										// $Customer_enroll_id=$row25['Enrollement_id'];
										// $CardId=$row25['Card_id'];
										// $fname=$row25['First_name'];
										// $midlename=$row25['Middle_name'];
										// $lname=$row25['Last_name'];
									// }
									$result1 = $this->Transactions_model->insert_giftcard($Company_id,$Merchant_id);
										
									$Gift_card_id = $this->input->post("gif_number");
									
									$giftcard_details = $this->Transactions_model->get_giftcard_details($Gift_card_id,$Company_id);
									foreach($giftcard_details as $giftcard)
									{
										$Card_balance = $giftcard['Card_balance'];
										$User_name = $giftcard['User_name'];
										$Email = $giftcard['Email'];
										$Phone_no = $giftcard['Phone_no'];
										$Membership_id = $giftcard['Card_id'];
									}
									if($Membership_id == 0)
									{
										$Enrollment_id = 0;
									}
									else
									{
										$customer_details = $this->Transactions_model->enrollment_details_frmemail_phn_card($Email,$Membership_id,$Phone_no,$Company_id);
										$Enrollment_id = $customer_details->Enrollement_id;
									}
											
									$Email_content = array(									
										'Todays_date' => $lv_date_time,
										'GiftCardNo' => $Gift_card_id,
										'GiftCard_balance' => $Card_balance,
										'Enrollment_id' => $Enrollment_id,
										'Gift_card_user' => $User_name,
										'Gift_card_Email' => $Email,
										'Symbol_currency' => $Symbol_currency,
										'Notification_type' => 'Gift Card',
										'Template_type' => 'Assign_Gift_card'
									);
									$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Merchant_id,$Company_id);
									
									if($result1 != NULL)
									{
										$Result1001[] = array("Error_flag" => 1001);
										$this->output->set_output(json_encode($Result1001)); //Succsessfully
									}
									else
									{
										$Result124[] = array("Error_flag" => 2068);  
										$this->output->set_output(json_encode($Result124)); // Bonus Point Transaction Failed
									}
							}
							else
							{
								$Result3100[] = array("Error_flag" => 2009);
								$this->output->set_output(json_encode($Result3100));
							}
					
					}
					/**********************Assign Gift Card API ***********************************/
					/**********************Fetch_giftcard_info***********************************/
					if($API_flag == 78)
					{
						$Merchant_email_id = $_REQUEST["Merchant_email_id"];
						$GiftCardNo = $_REQUEST["GiftCardNo"];
						$CardId = $_REQUEST["CardId"];
						// $Membership_id = $_REQUEST["CardID"];
						
						$result = $this->Merchant_api_model->Get_Seller($Merchant_email_id,$Company_id); //Get Merchant Details
						
						if($result!=NULL)
						{
							$seller_User_id = $result->User_id;
							$Merchant_id = $result->Enrollement_id;
							$seller_fname = $result->First_name;
							$seller_lname = $result->Last_name;
							
							if($CardId!='')
							{
								$resultG = $this->Merchant_api_model->get_giftcard_info($GiftCardNo,$Company_id,$CardId);
							}
							else
							{
								$resultG = $this->Merchant_api_model->get_giftcard_info_transctGift($GiftCardNo,$Company_id);
							}
							if($resultG != NULL)
							{
								$this->output->set_output($resultG);
							}
							else    
							{
								$this->output->set_output("2069");
							}
						}
						else
						{
							// $Result3100[] = array("Error_flag" => 2009);
							// $this->output->set_output(json_encode($Result3100));
							$this->output->set_output("2009");
						}
					}
					/**********************Fetch_giftcard_info***********************************/
					/**********************Transact Gift Card***********************************/
					if($API_flag ==11)
					{
						$manualbillno = $_REQUEST["Billno"];
						$Purchase = $_REQUEST["Purchase"];
						$GiftCardNo = $_REQUEST["GiftCardNo"];
						$Balance = $_REQUEST["Balance"];
						$Redeem = $_REQUEST["Redeem"];
						$current_balance = $Balance - $Redeem;
						$BalanceToPay = ($Purchase-$Redeem);
						$payment_by = $_REQUEST["payment_by"];
						$remark = $_REQUEST["Cheque"];
						$Transaction_type = 4;
						$merchant_email= $_REQUEST["merchant_email"];
						
						$result123 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);
						if($result123!=NULL)
						{
							$seller_id = $result123->Enrollement_id;

							$seller_details = $this->Igain_model->get_enrollment_details($seller_id);
							$lv_timezone = $seller_details->timezone_entry;
							$seller_name = $seller_details->First_name.' '.$seller_details->Middle_name.' '.$seller_details->Last_name;
							$bill_db = $seller_details->Purchase_Bill_no;
							$lv_User_id = $seller_details->User_id;
							
							if($lv_User_id =='2')
							{
								$remarks2 = 'By Seller';
							}
							else
							{
								$remarks2 = '';
							}
							
							$len = strlen($bill_db);
							$str = substr($bill_db,0,5);
							$bill = substr($bill_db,5,$len);				
							$bill_no = $bill+1;									
							$billno_withyear = $str.$bill_no;
							
							// $logtimezone = $session_data['timezone_entry'];
								// $timezone = new DateTimeZone($logtimezone);
								$date = new DateTime();
								// $date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');	
							
							if($GiftCardNo !='' && $Purchase!='')
							{
								$giftcard_details = $this->Transactions_model->get_giftcard_details($GiftCardNo,$Company_id);
								$giftcard_details_count = count($giftcard_details);
								
								if($giftcard_details_count > 0)
								{
									foreach($giftcard_details as $giftcard)
									{
										$Card_balance = $giftcard['Card_balance'];
										$name = $giftcard['User_name'];
										$Email = $giftcard['Email'];
										$Phone_no = $giftcard['Phone_no'];
										$Membership_id = $giftcard['Card_id'];
									}
									
									if($Membership_id == 0)
									{
										$giftcard_transaction['Enrollement_id'] = 0;
										$giftcard_transaction['Card_id'] = 0;
										$enrollment_id = 0;
									}
									else
									{
										$cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$Membership_id);
										foreach($cust_details as $row25)
										{
											$Card_id = $row25['Card_id'];
											$enrollment_id = $row25['Enrollement_id'];
										}
										
										$giftcard_transaction['Enrollement_id'] = $enrollment_id;
										$giftcard_transaction['Card_id'] = $Card_id;
									}
									
									$giftcard_transaction['Trans_type'] = $Transaction_type;
									$giftcard_transaction['Company_id'] = $Company_id;
									$giftcard_transaction['Purchase_amount'] = $Purchase;
									$giftcard_transaction['Trans_date'] = $lv_date_time;
									$giftcard_transaction['Remarks'] = $remark;
									$giftcard_transaction['GiftCardNo'] = $GiftCardNo;
									$giftcard_transaction['Redeem_points'] = $Redeem;
									$giftcard_transaction['Payment_type_id'] = $payment_by;
									$giftcard_transaction['Paid_amount'] = $BalanceToPay;
									$giftcard_transaction['balance_to_pay'] = $BalanceToPay;
									$giftcard_transaction['Manual_billno'] = $manualbillno;
									$giftcard_transaction['Seller'] = $seller_id;
									$giftcard_transaction['Seller_name'] = $seller_name;
									$giftcard_transaction['Bill_no'] = $bill;
									
									$giftcard_transaction['remark2'] = $remarks2;
									
									$result = $this->Transactions_model->insert_giftcard_transaction($giftcard_transaction);
									$result2 = $this->Transactions_model->update_giftcard_balance($GiftCardNo,$current_balance,$Company_id);
									$result3 = $this->Transactions_model->update_billno($seller_id,$billno_withyear);
									
									$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
									$Symbol_currency = $currency_details->Symbol_of_currency;
									$Email_content = array(									
										'Purchase_amount' => $Purchase,
										'Redeem_points' => $Redeem,
										'BalanceToPay' => $BalanceToPay,
										'GiftCardNo' => $GiftCardNo,
										'GiftCard_balance' => $current_balance,
										'Enrollment_id' => $enrollment_id,
										'Symbol_currency' => $Symbol_currency,
										'Gift_card_user' => $name,
										'Gift_card_Email' => $Email,
										'Todays_date' => $lv_date_time,
										'Notification_type' => 'Gift Card Transaction',
										'Template_type' => 'Gift_card_transaction'
									);
									
									$this->send_notification->send_Notification_email($enrollment_id,$Email_content,$seller_id,$Company_id);						
									if( ($result == true) && ($result2 == true) && ($result3 == true) )
									{
										$Result1001 = array("Error_flag" => 1001);
										$this->output->set_output(json_encode($Result1001)); // transactio done
									}
									else
									{							
										$Result2068 = array("Error_flag" => 2068);
										$this->output->set_output(json_encode($Result2068)); // Transaction Fail
									}
								}
								else
								{
									$Result2069 = array("Error_flag" => 2069);
									$this->output->set_output(json_encode($Result2069)); // invalid gift card
								}
							}
							else
							{
								$Result2068 = array("Error_flag" => 2068);
								$this->output->set_output(json_encode($Result2068)); // Transaction Fail
							}
						}
						else
						{
							$Result3100 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result3100)); // INVALID MERCHANT
						}
					}
					/**********************Transact Gift Card********************/
					/************************Login*******************************/
					if($API_flag ==1)
					{	
						$username = $_REQUEST["username"];
						$password = $_REQUEST["password"];
						$flag=2;
						$result = $this->Login_model->login($_REQUEST['username'],$_REQUEST['password'],$flag);
						if($result)
						{
							$sess_array = array();
							 //print_r($result);
							foreach($result as $row)
							{
								$sess_array = array('enroll' => $row['Enrollement_id'],'username' => $row['User_email_id'],'Country_id' => $row['Country_id'],'userId'=>$row['User_id'],'Super_seller'=>$row['Super_seller'],'Company_name'=>$row['Company_name'],'Company_id'=>$row['Company_id'],'Login_Partner_Company_id'=>$row['Company_id'],'timezone_entry'=>$row['timezone_entry'],'Full_name'=>$row['First_name']." ".$row['Middle_name']." ".$row['Last_name'],'Count_Client_Company'=>$row['Count_Client_Company'],'card_decsion'=>$row['card_decsion'],'next_card_no'=>$row['next_card_no'],'Seller_licences_limit'=>$row['Seller_licences_limit'],'Seller_topup_access'=>$row['Seller_topup_access'],'Current_balance'=>$row['Current_balance'],'Allow_membershipid_once'=>$row['Allow_membershipid_once'],'Allow_merchant_pin'=>$row['Allow_merchant_pin'],'Sub_seller_admin'=>$row['Sub_seller_admin'],'pinno'=>$row['pinno'],'smartphone_flag' => '2','Sub_seller_Enrollement_id'=>$row['Sub_seller_Enrollement_id'],'Membership_redirection_url'=>$row['Membership_redirection_url']);
								
								$this->session->set_userdata('logged_in', $sess_array);
								
								$Partner_company_flag = $row['Partner_company_flag'];
								$Count_Client_Company = $row['Count_Client_Company'];
								$Loggin_User_id = $row['User_id'];
								
								$Super_seller = $row['Super_seller'];
								$Company_id = $row['Company_id'];
								$data['Company_id']=$Company_id;
								$Company_logo = $row['Company_logo'];
								$Coalition = $row['Coalition'];
								$Photograph = $row['Photograph'];
								$_SESSION['Photograph'] =$Photograph;
								$_SESSION['Company_logo'] =$Company_logo;
								$_SESSION['Coalition'] =$Coalition;
								$data['LogginUserName'] = $row['First_name']." ".$row['Last_name'];
								$data['User_id'] = $row['User_id'];
								
								/***********************AMIT 24-05-2016**************************************************/
								$_SESSION['Parent_company'] =$row['Parent_company'];
								$FetchedParentCompany = $this->Igain_model->get_company_details($_SESSION['Parent_company']);
								
								$_SESSION['Localization_logo'] = $FetchedParentCompany->Localization_logo;
								$_SESSION['Localization_flag'] = $FetchedParentCompany->Localization_flag;
								$_SESSION['Company_logo'] = $FetchedParentCompany->Company_logo;
								
								/************************AMIT 08-09-2016*******************************************************/
								$_SESSION['Allow_merchant_pin'] = $FetchedParentCompany->Allow_merchant_pin;
								$_SESSION['Allow_membershipid_once'] = $FetchedParentCompany->Allow_membershipid_once;
								// $this->login_mail($row['Enrollement_id'],"Browser");					
							}	
							$FetchedClientCompanys = $this->Igain_model->get_partner_companys($Loggin_User_id,$Company_id);	
							$data['Company_array'] = $FetchedClientCompanys;
							
							if($Loggin_User_id == 3 || $Loggin_User_id == 4) //miracle admin or Partner admin
							{
								// echo"<br>----Loggin_User_id---".$Loggin_User_id;
								if($Count_Client_Company!=0 && $Loggin_User_id == 4)
								{
									$Client_company_array = $this->Igain_model->get_partner_clients($Company_id);		
									// print_r($Client_company_array); die;
									$data['Client_company_array'] = $Client_company_array;
									
									$Client_company_Trans = $this->Igain_model->get_partner_clients_transaction($Company_id);
									$data['Client_company_Trans'] = $Client_company_Trans;
							
									$this->load->view('Select_partner_client',$data);
									
								}					
								else if($Count_Client_Company!=0 && $Loggin_User_id == 3 )
								{
									$Client_company_Trans = $this->Igain_model->get_partner_clients_transaction_miracleAdmin($Company_id);
									
									$data['Client_company_Trans'] = $Client_company_Trans;
									
									$this->load->view('Select_partner_client',$data);
								}
								else
								{
									// redirect('Home');
									$Result101 = array("Error_flag" => 1001);
									$this->output->set_output(json_encode($Result101));
								}
							}
							else
							{
								// redirect('Home');
								$Result101 = array("Error_flag" => 1001);
								$this->output->set_output(json_encode($Result101));
							}	
							return TRUE;							
						}
						else
						{							
							$Result1285 = array("Error_flag" => 2005);
							$this->output->set_output(json_encode($Result1285)); // Invalid Company User or Password			
						}
					}
					/*****************Login*********************/
					/*************forgot Password******************/
					if($API_flag ==79)
					{
						$Email_id = $_REQUEST['Email_id'];
						$result = $this->Igain_model->Send_password($Email_id);
						if($result != NULL)
						{
							$Email_content = array(
								'Password' => $result->User_pwd,
								'Notification_type' => 'Request for Forgot Password',
								'Template_type' => 'Forgot_password'
							);
							$this->send_notification->send_Notification_email($result->Enrollement_id,$Email_content,'1',$result->Company_id);
									
							$Result11 = array("Error_flag" => 1001, "Password" => $result->User_pwd);
							$this->output->set_output(json_encode($Result11)); 
							// $this->output->set_output("Password sent Successfuly");
						}
						else    
						{
							// $this->output->set_output("Password Not sent");
							$Result119 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result119));
						}	  
					}
					/*****************************forgot Password*******************************/
					/*****************************Change Password*******************************/
					if($API_flag ==2)
					{
						$User_email_id = $_REQUEST['User_email_id'];
						$Old_password = $_REQUEST['Old_password'];
						$New_password = $_REQUEST['New_password'];
						$confirm_Password = $_REQUEST['confirm_Password'];
						
						$result123 = $this->Merchant_api_model->Get_User($User_email_id,$Company_id);
						if($result123!=NULL)
						{
							$Enrollment_id = $result123->Enrollement_id;
							
						
							$result = $this->Igain_model->Change_Old_Password($Old_password,$Company_id,$Enrollment_id,$New_password);
							
							if($result == true)
							{
								// $result1  = array();
								// $result1['pwd']='1';
								$Result1001 = array("Error_flag" => 1001);
								$this->output->set_output(json_encode($Result1001));
								// $this->output->set_output("Password Changed Successfuly");
							}
							else    
							{
								// $result1  = array();
								// $result1['pwd']='0';
								$Result2068 = array("Error_flag" => 2068);
								$this->output->set_output(json_encode($Result2068));
								// $this->output->set_output("Password Not Changed");
							}
						}
						else
						{
							$Result2009 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result2009)); // INVALID MERCHANT						 
						}
						
					}
					/************************Change Password***************************/
					/************************ReSend Pin***************************/
					if($API_flag ==4)
					{	
						$User_email_id=$_REQUEST['User_email_id'];
						$result123 = $this->Merchant_api_model->Get_Seller($User_email_id,$Company_id);
						if($result123!=NULL)
						{
							$Enrollment_id = $result123->Enrollement_id;
							$get_pin = $this->Igain_model->get_customer_pin($Company_id,$Enrollment_id);
						
							if($get_pin->pinno != "" && $get_pin->pinno != 0 )
							{
								$SuperSeller=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
								$Seller_id=$SuperSeller->Enrollement_id;
								
								$Email_content = array(
									'Pin_No' => $get_pin->pinno,
									'Notification_type' => 'Send Pin',
									'Template_type' => 'Send_pin'
									);			
							
							$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$Seller_id,$Company_id); 						
								
								$Result101 = array("Error_flag" => 1001 , 'pinno' => $get_pin->pinno);
								$this->output->set_output(json_encode($Result101));
							}
							else    
							{
								$Result2068 = array("Error_flag" => 2068);
								$this->output->set_output(json_encode($Result2068));
							}
						}
						else
						{
							$Result2009 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result2009)); // INVALID MERCHANT						
						}
					}
					/*****************************ReSend Pin*******************************/
					/*****************************Change Pin*******************************/
					if($API_flag ==3)
					{    
						$old_Pin=$_REQUEST['old_Pin'];
						$new_Pin=$_REQUEST['New_Pin'];
						$confirm_Pin=$_REQUEST['confirm_Pin'];
						$User_email_id=$_REQUEST['User_email_id'];
						
						$result123 = $this->Merchant_api_model->Get_Seller($User_email_id,$Company_id);
						if($result123!=NULL)
						{
							$Enrollment_id = $result123->Enrollement_id;
							
								
							$result = $this->Igain_model->Change_Old_Pin($old_Pin,$Company_id,$Enrollment_id,$new_Pin);	
							// var_dump($result);
							if($result == true)
							{
								$Email_content = array(													
												'Notification_type' => 'Change Pin',
												'Template_type' => 'Change_pin',
												'Pin_No' => $new_Pin
											);
								$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'0',$Company_id);
								// die;
								// $result1  = array();
								// $result1['pin']='1';
								
								// $this->output->set_output("Pin Changed Successfuly");
								
								$Result101 = array("Error_flag" => 1001);
								$this->output->set_output(json_encode($Result101));
							}
							else    
							{
								// $result1  = array();
								// $result1['pin']='0';
								// $this->output->set_output("Pin Not Changed");
								$Result2068 = array("Error_flag" => 2068);
								$this->output->set_output(json_encode($Result2068));
							}
						}
						else
						{
							$Result2009 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result2009)); // INVALID MERCHANT	
						}
					}
					/**********************Change Pin*******************************/
					/***************Fetch Merchant Profile******************/
					if($API_flag == 80)  //Fetch_Merchant_Profile info
					{							
						$merchant_email = $_REQUEST["merchant_email"];
										
						$result91 = $this->Merchant_api_model->Fetch_Profile_Details($merchant_email,$Company_id);	
						if($result91 !=NULL)
						{	
							$Merchant_profile = array(
									"Error_flag" => 1001,
									"Enrollement_id" => $result91->Enrollement_id,
									"First_name" => $result91->First_name,
									"Last_name" => $result91->Last_name, 
									"Current_address" => $result91->Current_address, 
									"Phone_no" => $result91->Phone_no, 
									"State" => $result91->State,
									"StateName" => $result91->StateName,
									"CityName" => $result91->CityName,
									"City" => $result91->City,
									"Qualification" => $result91->Qualification,
									"Photograph" => base_url().''.$result91->Photograph,
									"User_email_id" => $result91->User_email_id,
									"Current_balance" => $result91->Current_balance
								);
						}
						if($result91 != NULL)
						{
							// $this->output->set_output($member_details);
							echo json_encode($Merchant_profile);
						}
						else    
						{
							$Result127 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result127)); //Unable to Locate Merchant email id
						}	
					}
					/*******************Fetch Merchant Profile***********************/
					/*********************Update Profile****************************/
					if($API_flag == 5)
					{	
						$merchant_email = $_REQUEST["merchant_email"];
										
						$result91 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);	
						if($result91 !=NULL)
						{	
							$Enrollement_id = $result91->Enrollement_id;
							$data['Enrollement_id'] = $Enrollement_id;
							$post_data['First_name'] = $_REQUEST["First_name"];
							$post_data['Last_name'] = $_REQUEST["Last_name"];
							$post_data['Current_address'] = $_REQUEST["Current_address"];
							// $post_data['State'] = $_REQUEST["State"];
							// $post_data['City'] = $_REQUEST["City"];
							$post_data['Company_id'] = $Company_id;
							// $post_data['Phone_no'] = $_REQUEST["Phone_no"];
							$post_data['Qualification'] = $_REQUEST["Qualification"];	
								
							/*-----------------------File Upload---------------------*/
							/*$config = array();
							$config["base_url"] = base_url() . "/index.php/Merchant_api/Merchant_api";
							$config['upload_path'] = './uploads/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size'] = '1000';
							$config['max_width'] = '1920';
							$config['max_height'] = '1280';
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							
							$filepath = $_REQUEST['file_exist'];
								
							
							if (! $this->upload->do_upload("file") && $_REQUEST["file"]="")
							{			
								$this->session->set_flashdata("error_code_UP",$this->upload->display_errors());
								$filepath = $_REQUEST['file_exist'];
							}
							else
							{
								if($_REQUEST["file"]="")
								{
									$data = array('upload_data' => $this->upload->data("file"));
									$filepath = "uploads/".$data['upload_data']['file_name'];
								}
								
							}	
							$post_data['Photograph'] = $filepath; */
							
							$result222 = $this->Enroll_model->update_enrollment($post_data,$Enrollement_id);
							if($result222 == true)
							{
								$Result1001 = array("Error_flag" => 1001);
								$this->output->set_output(json_encode($Result1001));
								// $this->session->set_flashdata("error_code_UP","User Profile Updated Successfuly!!");
							}
							else
							{
								$Result2068 = array("Error_flag" => 2068);
								$this->output->set_output(json_encode($Result2068));
							}	
						}
						else
						{
							$Result127 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result127)); 
						}
					}
					/****************************Update Profile*****************************************/
					/****************************Fetch Company info********************************************/
					if($API_flag == 81)  //Fetch_Company_info
					{	
						$resultis = $this->Igain_model->get_company_details($Company_id);
						
						if($resultis!=NULL)
						{	
							$Company_id = $resultis->Company_id;
							$Company_name = $resultis->Company_name;
							$Start_card_series = $resultis->Start_card_series;
							$next_card_no = $resultis->next_card_no;
							$Coalition = $resultis->Coalition;
							$Company_Current_bal = $resultis->Current_bal;
							$Joining_bonus = $resultis->Joining_bonus;
							$Joining_bonus_points = $resultis->Joining_bonus_points;
							$card_decsion = $resultis->card_decsion;
							$Seller_licences_limit = $resultis->Seller_licences_limit;
							$Domain_name = $resultis->Domain_name;
							
									
							$Company_Details = array(
											"Error_flag" => 1001,
											"Company_id" => $Company_id,
											"Company_name" => $Company_name, 
											"card_decsion" => $card_decsion, 
											"Start_card_series" => $Start_card_series, 
											"next_card_no" => $next_card_no,
											"Joining_bonus" => $Joining_bonus,
											"Joining_bonus_points" => $Joining_bonus_points,
											"Company_Current_bal" => $Company_Current_bal,
											"Coalition" => $Coalition,
											"Domain_name" => $Domain_name,
											"Seller_licences_limit" => $Seller_licences_limit
							);
								
							echo json_encode($Company_Details);
						}
						else    
						{
							$Result127 = array("Error_flag" => 2012);
							$this->output->set_output(json_encode($Result127)); //No Data Found
						}	
					}
					/**********************Fetch Company info***********************/
					/**********************Fetch Merchant info*********************/ 
					if($API_flag == 82)  //Fetch_Merchant_info
					{	
						$merchant_email = $_REQUEST['merchant_email'];
					
						$result123 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);
						
						if($result123!=NULL)
						{
							$seller_id = $result123->Enrollement_id;
							$First_name = $result123->First_name;
							$Last_name = $result123->Last_name;
							$SellerName = $First_name.' '.$Last_name;
							$Refrence = $result123->Refrence;
							$timezone_entry = $result123->timezone_entry;
							$Country_id = $result123->Country_id;
							$City = $result123->City;
							$State = $result123->State;
							$referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$seller_id);
							$referral_rule_count = $referral_rule_count;
							
							$merchant_Details = array(
									"Error_flag" => 1001,
									"Company_id" => $Company_id,
									"seller_id" => $seller_id, 
									"Refrence" => $Refrence, 
									"referral_rule_count" => $referral_rule_count, 
									"timezone_entry" => $timezone_entry, 
									"Country_id" => $Country_id, 
									"City" => $City, 
									"State" => $State, 
									"SellerName" => $SellerName 
								);
								
							echo json_encode($merchant_Details);						
						}
						else
						{
							$Result3100 = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result3100));
						}
					}
					/***********************Fetch Merchant info*********************/ 
					/*********************Quick Enrollment***************************/ 
					if($API_flag == 6) // Fast Enrollment
					{  
						$merchant_email = $_REQUEST['merchant_email'];
						$Chk_card = $_REQUEST['cardid'];
						$email_flag = $_REQUEST['email_validity'];	
						
						$resultis = $this->Igain_model->get_company_details($Company_id);
						
						if($resultis!=NULL)
						{	
							$Company_id = $resultis->Company_id;
							$Company_name = $resultis->Company_name;
							$Start_card_series = $resultis->Start_card_series;
							$next_card_no = $resultis->next_card_no;
							$Coalition = $resultis->Coalition;
							$Company_Current_bal = $resultis->Current_bal;
							$Joining_bonus = $resultis->Joining_bonus;
							$Joining_bonus_points = $resultis->Joining_bonus_points;
							$card_decsion = $resultis->card_decsion;
							$Seller_licences_limit = $resultis->Seller_licences_limit;							
							$Seller_topup_access = $resultis->Seller_topup_access;
							$Partner_company_flag = $resultis->Partner_company_flag;
							$Joining_bonus_flag = $resultis->Joining_bonus;
							if($card_decsion==1)
							{
								$next_card_no=$next_card_no;
							}
							else{
								$next_card_no=0;
							}
							$result123 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);
						
							if($result123!=NULL)
							{	
								$Logged_user_enrollid = $result123->Enrollement_id;
								$Logged_in_userid = $result123->Enrollement_id;
								$Sub_seller_Enrollement_id = $result123->Sub_seller_Enrollement_id;
								$Sub_seller_admin = $result123->Sub_seller_admin;
								$Super_seller = $result123->Super_seller;
								$First_name = $result123->First_name;
								$Last_name = $result123->Last_name;
								$SellerName = $First_name.' '.$Last_name;
								$Refrence = $result123->Refrence;
								$Country_id = $result123->Country_id;
								$State = $result123->State;
								$City = $result123->City;
								$User_id = $result123->User_id;
								$timezone_entry = $result123->timezone_entry;
							
								$Dial_Code = $this->Igain_model->get_dial_code11($result123->Country);
								$dialcode=$Dial_Code->phonecode;
								$phoneNo=$dialcode.''.$this->input->post('phno');
								
								$CheckPhone_number=$this->Igain_model->CheckPhone_number($phoneNo,$Company_id);
								if($CheckPhone_number ==0)
								{
									$email_flag = $this->input->post('email_validity');
			
									if($email_flag == 1)
									{ 
										$email_id = $this->input->post('userEmailId');
									}
									else if($email_flag == 0)
									{ 
										$email_id = $this->input->post('userEmailId2');
									}
									else
									{ 
										$email_id = $this->input->post('userEmailId');
									}
									$Check_EmailID=$this->Igain_model->Check_EmailID($email_id,$Company_id);
									if($Check_EmailID == 0)
									{
										if($Sub_seller_admin==1)
										{
											$Logged_user_enrollid=$Logged_user_enrollid;
										}
										else
										{
											$Logged_user_enrollid=$Sub_seller_Enrollement_id;
										}
										if( $Chk_card != "")
										{
											$check_card=$this->Enroll_model->check_card_id($Chk_card,$Company_id);
											if($check_card > 0)
											{ 
												$Result2029 = array("Error_flag" => 2029);
												$this->output->set_output(json_encode($Result2029));
											}
										}
											
										if($email_flag == 1)
										{ 
											$email_id = $_REQUEST['userEmailId'];	
										}
										else if($email_flag == 0)
										{ 									
											$email_id = $_REQUEST['userEmailId2'];	
										}
										else
										{ 
											$email_id = $_REQUEST['userEmailId'];	
										}
										if($email_id != "")
										{
											$UserID=1;
											$email_result = $this->Enroll_model->check_userEmailId($email_id,$Company_id,$UserID);
											
											if($email_result > 0)
											{ 
												$Result2030 = array("Error_flag" => 2030);
												$this->output->set_output(json_encode($Result2030));
											}
										}
										if($User_id == 3)
										{
											if($Partner_company_flag == 0)
											{
												$top_seller = $this->Transactions_model->get_top_seller($Company_id);
												foreach($top_seller as $sellers)
												{
													$seller_id = $sellers['Enrollement_id'];
													$Purchase_Bill_no = $sellers['Purchase_Bill_no'];
													$Topup_Bill_no = $sellers['Topup_Bill_no'];
													$username = $sellers['User_email_id'];
													$remark_by = 'By Admin';
													$seller_curbal = $sellers['Current_balance'];
													$Seller_Redemptionratio = $sellers['Seller_Redemptionratio'];
													$Seller_Refrence = $sellers['Refrence'];
													$Seller_name = $sellers['First_name']." ".$sellers['Middle_name']." ".$sellers['Last_name'];
												}
											}
											else
											{
												$Seller_Refrence = 0;
											}
												$remark_by = 'By Admin';
										}
										else
										{
											$user_details = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
											$seller_id = $user_details->Enrollement_id;
											$Purchase_Bill_no = $user_details->Purchase_Bill_no;
											$username = $user_details->User_email_id;
											$remark_by = 'By Seller';
											$seller_curbal = $user_details->Current_balance;
											$Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
											$Seller_Refrence = $user_details->Refrence;
											$Topup_Bill_no =  $user_details->Topup_Bill_no;
											$Seller_name = $user_details->First_name." ".$user_details->Middle_name." ".$user_details->Last_name;

											if($user_details->Sub_seller_admin == 1)
											{
												$remark_by = 'By SubSeller';
											}
											else
											{
												$remark_by = 'By Seller';
											}
										}
										/************ Referral Bonus **************/
										$Customer_topup12 = 0;
										$Refree_topup = 0;
										$ref_topup = 0;
										$ref_Customer_enroll_id = 0;
										
										$date = new DateTime();
										$lv_date_time=$date->format('Y-m-d H:i:s');
										$Todays_date = $date->format('Y-m-d');

										$referre_enrollID = $_REQUEST['Refree_name'];
										// $referre_membershipID = substr(strrchr($referre_enrollID, "-"), 1);
										$referre_membershipID = $referre_enrollID;
										
										if($referre_membershipID > '0')
										{
											$Referral_rule_for = 1; //*** Referral_rule_for enrollment
											
											$Ref_rule = $this->Transactions_model->select_seller_refrencerule($Logged_user_enrollid,$Company_id,$Referral_rule_for);

											if($Ref_rule != "")
											{
												foreach($Ref_rule as $rule)
												{
													$ref_start_date = $rule['From_date'];
													$ref_end_date = $rule['Till_date'];
													
													if($ref_start_date <= $Todays_date && $ref_end_date >= $Todays_date)
													{
														$Customer_topup = $rule['Customer_topup'];
														$ref_topup = $rule['Refree_topup'];
													}
												}
											}
										}
										$top_db = $Topup_Bill_no;
										$len = strlen($top_db);
										$str = substr($top_db,0,5);
										$tp_bill = substr($top_db,5,$len);

										$Enrolled_Card_id=$_REQUEST['cardid'];
										if($referre_membershipID != "" && $Seller_Refrence == 1 && $ref_topup > 0 )
										{
											$Customer_topup12 = $Customer_topup;
									   
											$ref_cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$referre_membershipID);
											
											foreach($ref_cust_details as $row21)
											{
												$ref_card_bal = $row21['Current_balance'];
												$ref_Customer_enroll_id = $row21['Enrollement_id'];
												$ref_topup_amt = $row21['Total_topup_amt'];
												$ref_purchase_amt = $row21['total_purchase'];
												$ref_reddem_amt = $row21['Total_reddems'];
												$ref_member_Tier_id = $row21['Tier_id'];
												$ref_name = $row21['First_name']." ".$row21['Middle_name']." ".$row21['Last_name'];
											}
											if($ref_Customer_enroll_id !="")
											{
											if($Enrolled_Card_id!="")
											{						

												if($Seller_topup_access == '0')
												{
													$refree_current_balnce = $ref_card_bal + $ref_topup;
													$refree_topup = $ref_topup_amt + $ref_topup;
												
													$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
												}
												else
												{
													$refree_current_balnce = $ref_card_bal;
													$refree_topup = $ref_topup_amt + $ref_topup;
													
													$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
												}
												
												$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
												$Seller_balance = $seller_details2->Current_balance;
												
												$seller_curbal = $Seller_balance - $ref_topup;
												
												$SellerID = $seller_id;
													$post_Transdata = array(
													'Trans_type' => '1',
													'Company_id' => $Company_id,
													'Topup_amount' => $ref_topup,
													'Trans_date' => $lv_date_time,
													'Remarks' => 'Referral Trans',
													'Card_id' => $referre_membershipID,
													'Seller_name' => $Seller_name,
													'Seller' => $SellerID,
													'Enrollement_id' => $ref_Customer_enroll_id,
													'Bill_no' => $tp_bill,
													'remark2' => $remark_by,
													'Loyalty_pts' => '0'
													);

												$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);
												
												$tp_bill=$tp_bill+1;
												$billno_withyear_ref = $str.$tp_bill;
												$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
																						
												if($Seller_topup_access=='1')
												{
													$Total_seller_bal = $seller_curbal;

													$result3 = $this->Transactions_model->update_seller_balance($Logged_user_enrollid,$Total_seller_bal);
													
													$Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id,$Logged_user_enrollid,$ref_Customer_enroll_id);	
													
													if($Record_available==0)
													{
														$post_data2 = array(					
															'Company_id' => $Company_id,
															'Seller_total_purchase' =>0,        
															'Update_date' => $lv_date_time,       
															'Seller_id' => $Logged_user_enrollid,
															'Cust_enroll_id' => $ref_Customer_enroll_id,
															'Cust_seller_balance' => $ref_topup,
															'Seller_paid_balance' =>0,
															'Seller_total_redeem' => 0,
															'Seller_total_gain_points' =>0,
															'Seller_total_topup' =>  $ref_topup
															);
														$lv_Cust_seller_balance=$ref_topup;	
														$result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data2);
													}
													else
													{
														/*************Get Customer merchant balance*****************/
														$Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Logged_user_enrollid,$ref_Customer_enroll_id);	
														if($Get_Record)
														{
															foreach($Get_Record as $val)
															{
																$data["Cust_seller_balance"]=$val["Cust_seller_balance"];
																$data["Seller_total_purchase"]=$val["Seller_total_purchase"];
																$data["Seller_total_redeem"]=$val["Seller_total_redeem"];
																$data["Seller_total_gain_points"]=$val["Seller_total_gain_points"];
																$data["Seller_total_topup"]=$val["Seller_total_topup"];
																$data["Seller_paid_balance"]=$val["Seller_paid_balance"];
																$data["Cust_prepayment_balance"]=$val["Cust_prepayment_balance"];
																$data["Cust_block_amt"]=$val["Cust_block_amt"];
																$data["Cust_block_points"]=$val["Cust_block_points"];
															}									
															/*****************************************/
															$lv_Cust_seller_balance=($data["Cust_seller_balance"]+$ref_topup);
															$lv_Seller_total_purchase=($data["Seller_total_purchase"]);
															$lv_Seller_total_redeem=($data["Seller_total_redeem"]);
															$lv_Seller_total_gain_points=($data["Seller_total_gain_points"]);
															$lv_Seller_paid_balance=($data["Seller_paid_balance"]);
															$lv_Seller_total_topup=($data["Seller_total_topup"]+$ref_topup);
															$lv_Cust_prepayment_balance=($data["Cust_prepayment_balance"]);
															$lv_Cust_block_amt=($data["Cust_block_amt"]);
															$lv_Cust_block_points=($data["Cust_block_points"]);
															
															/*************Update customer merchant balance***************/
															$result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($ref_Customer_enroll_id,round($lv_Cust_seller_balance),$Company_id,$lv_Seller_total_topup,$lv_date_time,$lv_Seller_total_purchase,$lv_Seller_total_redeem,$lv_Seller_paid_balance,$lv_Seller_total_gain_points,$Logged_user_enrollid,$lv_Cust_prepayment_balance,$lv_Cust_block_points,$lv_Cust_block_amt);										
															/*****************************************************/
														}
													}												
												}
															
												$customer_name = $_REQUEST['fname']." ".$_REQUEST['lname'];

												$Email_content12 = array(
														'Ref_Topup_amount' => $ref_topup,
														'Notification_type' => 'Referral Topup',
														'Template_type' => 'Referral_topup',
														'Customer_name' => $customer_name,
														'Todays_date' => $Todays_date
												);				

												if($Coalition == 1 )
												{
													$this->send_notification->Coal_send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_user_enrollid,$Company_id);
												}
												else
												{
													$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
												}
											}
											}
											else
											{
												$Result2060 = array("Error_flag" => 2060);
												$this->output->set_output(json_encode($Result2060));
												die;
											}
										}
											$cardid = $_REQUEST['cardid'];
											if($Joining_bonus_flag == 1 && $cardid != "")
											{									
												if($Seller_topup_access=='1')
												{
													$Customer_topup12 =$Joining_bonus_points;
												}
												else
												{
													$Customer_topup12 =($Customer_topup12+$Joining_bonus_points);
												}									
											}
											
											$result = $this->Merchant_api_model->fastenroll($Customer_topup12,$ref_Customer_enroll_id,$Company_id,$card_decsion,$Logged_user_enrollid,$Country_id,$State,$City,$next_card_no,$timezone_entry);
											$Last_enroll_id=$result;
											
											$customer_name = $_REQUEST['fname']." ".$_REQUEST['lname'];
											if($referre_membershipID != "" && $Seller_Refrence == 1 && $Customer_topup > 0 && $Enrolled_Card_id!="")
											{

												$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
												$Seller_balance = $seller_details2->Current_balance;
												$seller_curbal = $Seller_balance - $Customer_topup;
												$SellerID = $seller_id;
												
												$post_Transdata = array(
													'Trans_type' => '1',
													'Company_id' => $Company_id,
													'Topup_amount' => $Customer_topup,
													'Trans_date' => $lv_date_time,
													'Remarks' => 'Referral Trans',
													'Card_id' => $cardid,
													'Seller_name' => $Seller_name,
													'Seller' => $SellerID,
													'Enrollement_id' => $Last_enroll_id,
													'Bill_no' => $tp_bill,
													'remark2' => $remark_by,
													'Loyalty_pts' => '0'
												);

												$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);
													
												$tp_bill=$tp_bill+1;
												$billno_withyear_ref = $str.$tp_bill;
												$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
																			
												if($Seller_topup_access=='1')
												{											
													$Total_seller_bal = $seller_curbal;
													$result3 = $this->Transactions_model->update_seller_balance($Logged_user_enrollid,$Total_seller_bal);
													
													$Last_customer_record = $this->Igain_model->get_enrollment_details($Last_enroll_id);
													$Last_Card_id=$Last_customer_record->Card_id;
													$Last_Current_balance=$Last_customer_record->Current_balance;
													$Last_Blocked_points=$Last_customer_record->Blocked_points;
													$Last_total_purchase=$Last_customer_record->total_purchase;
													$Last_Total_topup_amt=$Last_customer_record->Total_topup_amt;
													$Last_Total_reddems=$Last_customer_record->Total_reddems;								
													$refree_current_balnce = $Last_Current_balance;
													$refree_topup = $Last_Total_topup_amt + $Customer_topup;
													
													$result5 = $this->Transactions_model->update_customer_balance($Last_Card_id,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$Last_total_purchase,$Last_Total_reddems);
													
													$Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id,$Logged_user_enrollid,$Last_enroll_id);	
													// echo "<br>Record_available**".$Record_available."----<br>";
													if($Record_available==0)
													{
														$post_data2 = array(					
															'Company_id' => $Company_id,
															'Seller_total_purchase' =>0,        
															'Update_date' => $lv_date_time,       
															'Seller_id' => $Logged_user_enrollid,
															'Cust_enroll_id' => $Last_enroll_id,
															'Cust_seller_balance' => $Customer_topup,
															'Seller_paid_balance' =>0,
															'Seller_total_redeem' => 0,
															'Seller_total_gain_points' =>0,
															'Seller_total_topup' =>  $Customer_topup
															);
														$lv_Cust_seller_balance=$Customer_topup;	
														$result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data2);
													}
													else
													{
														/*************Get Customer merchant balance*****************/
														$Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Logged_user_enrollid,$Last_enroll_id);	
														if($Get_Record)
														{
															foreach($Get_Record as $val)
															{
																$data["Cust_seller_balance"]=$val["Cust_seller_balance"];
																$data["Seller_total_purchase"]=$val["Seller_total_purchase"];
																$data["Seller_total_redeem"]=$val["Seller_total_redeem"];
																$data["Seller_total_gain_points"]=$val["Seller_total_gain_points"];
																$data["Seller_total_topup"]=$val["Seller_total_topup"];
																$data["Seller_paid_balance"]=$val["Seller_paid_balance"];
																$data["Cust_prepayment_balance"]=$val["Cust_prepayment_balance"];
																$data["Cust_block_amt"]=$val["Cust_block_amt"];
																$data["Cust_block_points"]=$val["Cust_block_points"];
															}									
															/*******************************************************/
															$lv_Cust_seller_balance=($data["Cust_seller_balance"]+$Customer_topup);
															$lv_Seller_total_purchase=($data["Seller_total_purchase"]);
															$lv_Seller_total_redeem=($data["Seller_total_redeem"]);
															$lv_Seller_total_gain_points=($data["Seller_total_gain_points"]);
															$lv_Seller_paid_balance=($data["Seller_paid_balance"]);
															$lv_Seller_total_topup=($data["Seller_total_topup"]+$Customer_topup);
															$lv_Cust_prepayment_balance=($data["Cust_prepayment_balance"]);
															$lv_Cust_block_amt=($data["Cust_block_amt"]);
															$lv_Cust_block_points=($data["Cust_block_points"]);
															
															/*************Update customer merchant balance**************/
															$result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Last_enroll_id,round($lv_Cust_seller_balance),$Company_id,$lv_Seller_total_topup,$lv_date_time,$lv_Seller_total_purchase,$lv_Seller_total_redeem,$lv_Seller_paid_balance,$lv_Seller_total_gain_points,$Logged_user_enrollid,$lv_Cust_prepayment_balance,$lv_Cust_block_points,$lv_Cust_block_amt);		
															/*****************************************************/
														}
													}												
												}							
												$Email_content13 = array(
														'Ref_Topup_amount' => $Customer_topup,
														'Notification_type' => 'Referee Topup',
														'Template_type' => 'Referee_topup',
														'Customer_name' => $ref_name,
														'Todays_date' => $Todays_date
												);
												
												if($Coalition == 1 )
												{
													$this->send_notification->Coal_send_Notification_email($Last_enroll_id,$Email_content13,$Logged_user_enrollid,$Company_id);
												}
												else
												{
													$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
												}
												
											}
											/************ Referee Bonus **************/
											if($Joining_bonus_flag == 1 && $cardid != "")
											{
													$SellerID = $seller_id;	
													$post_Transdata = array(
													'Trans_type' => '1',
													'Company_id' => $Company_id,
													'Topup_amount' => $Joining_bonus_points,
													'Trans_date' => $lv_date_time,
													'Remarks' => 'Joining Bonus',
													'Card_id' => $_REQUEST['cardid'],
													'Seller_name' => $Seller_name,
													'Seller' => $SellerID,
													'Enrollement_id' => $Last_enroll_id,
													'Bill_no' => $tp_bill,
													'remark2' => $remark_by,
													'Loyalty_pts' => '0'
													);

													$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);

													$tp_bill=$tp_bill+1;
													$billno_withyear_ref = $str.$tp_bill;
													$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);

													if($Seller_topup_access=='1')
													{
														$Company_Current_bal =$Company_Current_bal-$Joining_bonus_points;
													}

												$customer_name = $_REQUEST['fname']." ".$_REQUEST['lname'];

													$Email_content12 = array(
															'Joining_bonus_points' => $Joining_bonus_points,
															'Notification_type' => 'Joining Bonus',
															'Template_type' => 'Joining_Bonus',
															'Customer_name' => $customer_name,
															'Todays_date' => $Todays_date
													);

													$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);		
											}
											/**************** Joining Bonus end **************/						
											/***************Send Freebies Merchandize items************/
											$Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1);
											$insert_flag=0;
											if($Merchandize_Items_Records != NULL  && $cardid != "")
											{
												$this->load->model('Redemption_catalogue/Redemption_Model');
												
												foreach($Merchandize_Items_Records as $Item_details)
												{
													/******************Changed AMIT 16-06-2016*************/
													$this->load->model('Catalogue/Catelogue_model');
													$Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($Item_details->Partner_id,$Company_id);
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
													$Voucher_status="30";
													
													if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
													{
													$insert_data = array(
															'Company_id' => $Company_id,
															'Trans_type' => 10,
															'Redeem_points' => $Item_details->Billing_price_in_points,
															'Quantity' => 1,
															'Trans_date' => $lv_date_time,
															'Create_user_id' => $Logged_user_enrollid,
															'Seller' => $Logged_user_enrollid,
															'Seller_name' => $Seller_name,
															'Enrollement_id' => $Last_enroll_id,
															'Card_id' => $this->input->post('cardid'),
															'Item_code' => $Item_details->Company_merchandize_item_code,
															'Voucher_no' => $Voucher_no,
															'Voucher_status' => $Voucher_status,
															'Merchandize_Partner_id' => $Item_details->Partner_id,
															'Remarks' => 'Freebies',
															'Source' =>99,
															'Bill_no' => $tp_bill,
															'Merchandize_Partner_branch' => $Branch_code
															);
														 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
														
														  $Voucher_array[]=$Voucher_no;
														  
														  /**********Send freebies notification********/
															 $Email_content124 = array(
																		'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
																		'Merchandize_item_name' => $Item_details->Merchandize_item_name,
																		'Item_image' => $Item_details->Item_image1,
																		'Voucher_no' => $Voucher_no,
																		'Voucher_status' => $Voucher_status,
																		'Notification_type' => 'Freebies',
																		'Template_type' => 'Enroll_Freebies',
																		'Customer_name' => $customer_name,
																		'Todays_date' => $Todays_date
																	); 
														$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content124,$Logged_in_userid,$Company_id);
														
														$insert_flag=1;
													}											
												}
												if($insert_flag==1)					
												{
													$tp_bill=$tp_bill+1;
													$billno_withyear_ref = $str.$tp_bill;
													$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
												}
											}
											if($result > 0)
											{
													$Email_content = array(
															'Notification_type' => 'Enrollment Details',
															'Template_type' => 'Enroll'
													);
													$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$Logged_user_enrollid,$Company_id);

													$Result1001 = array("Error_flag" => 1001);
													$this->output->set_output(json_encode($Result1001));
											}
											else
											{
													$Result2068 = array("Error_flag" => 2068);
													$this->output->set_output(json_encode($Result2068));
											}
									}
									else
									{
										$Result2068 = array("Error_flag" => 2030);
										$this->output->set_output(json_encode($Result2068));
									}
								}
								else
								{
									$Result2032 = array("Error_flag" => 2032);
									$this->output->set_output(json_encode($Result2032));
								}
							}
							else
							{
								$Result3100 = array("Error_flag" => 2009);
								$this->output->set_output(json_encode($Result3100));
							}
						}
						else    
						{
							$Result127 = array("Error_flag" => 2012);
							$this->output->set_output(json_encode($Result127)); //No Data Found
						}
					}
					/*********************Quick Enrollment***********************/					
					/******************Customer Email Validate*********************/
					if($API_flag == 84)
					{
						$email_id=$_REQUEST['userEmailId'];
						if($email_id != "")
						{
							$email_result = $this->Enroll_model->check_userEmailId($email_id,$Company_id,'1');
							
							if($email_result > 0)
							{ 
								$Result2030 = array("Error_flag" => 2030);
								$this->output->set_output(json_encode($Result2030));
							}
						}
						else
						{
							$Result1001 = array("Error_flag" => 1001);
							$this->output->set_output(json_encode($Result1001));
						}
					}
					/***********************Customer Email Validate*********************************/			//********************Fetch Promo code Point Details****************************/
					if($API_flag == 85)
					{
						$PromoCode = $_REQUEST['promoc'];
						$promo_points = $this->Transactions_model->get_promo_code_details($PromoCode,$Company_id);
			
						if($promo_points > 0)
						{
							// $this->output->set_output($promo_points);
							$Result1001 = array("Error_flag" => 1001, "promo_points" => $promo_points);
							$this->output->set_output(json_encode($Result1001));
						}
						else    
						{
							// $this->output->set_output('2023');
							$Result2023 = array("Error_flag" => 2023);
							$this->output->set_output(json_encode($Result2023));
						}					 
					}
					/*******************Fetch Promo code point Details***********************/				
					if($API_flag == 83)
					{
						$GiftBalance = $_REQUEST['GiftBalance'];
						$GiftRedeem = $_REQUEST['GiftRedeem'];
						$balance_to_pay = $_REQUEST['balance_to_pay'];
						$purchase_amt = $_REQUEST['purchase_amt'];
						$redeem_amt = $_REQUEST['redeem_amt'];
						
						if($GiftRedeem<=$GiftBalance)
						{
							$balance_to_pay1=$purchase_amt-$redeem_amt;
							if($balance_to_pay1>=$GiftRedeem)
							{
								$ReturnBalToPay =$purchase_amt-$GiftRedeem-$redeem_amt;
								$Result1001 = array("Error_flag" => 1001, "ReturnBalToPay" => $ReturnBalToPay);
								$this->output->set_output(json_encode($Result1001));
							}
							else
							{
								$ReturnBalToPay =$purchase_amt-$redeem_amt;
								$Result1001 = array("Error_flag" => 2066, "ReturnBalToPay" => $ReturnBalToPay);
								$this->output->set_output(json_encode($Result1001));
							}							
						}
						else
						{ 
							$ReturnBalToPay =$purchase_amt-$redeem_amt;
							$Result2069 = array("Error_flag" => 2069, "ReturnBalToPay" => $ReturnBalToPay);
							$this->output->set_output(json_encode($Result2069));
						}					 
					}
				/**********************3rd Party Loyalty API-Nilesh start22-07-2020********************/
					if($API_flag == 70)  //API 2.0 – NEW LOYALTY CUSTOMER REGISTRATION
					{	
						$ChannelPassword = $inputArgs['Channel_password'];
						$first_name = $inputArgs['Membership_First_Name'];
						$last_name = $inputArgs['Membership_Last_Name'];
						$email = $inputArgs['Membership_Email'];
						$Phone_no = $inputArgs['Membership_Mobile'];	 
						
						if($first_name !="" && $last_name !="" && $email !="" && $Phone_no !="" && $ChannelPassword !="")
						{	
							$ChannelDetails=$this->Merchant_api_model->get_3rd_party_channel_details($Company_id,$ChannelPassword);
							if($ChannelDetails != Null)
							{
								$ChannelCompanyId = $ChannelDetails->Channel_Company_Id;
								$ChannelCompanyName = $ChannelDetails->Channel_Company_Name;
								
								$company_details = $this->Igain_model->get_company_details($Company_id);
								$data['Company_details']=$company_details;
								
								$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
								
								$timezone_entry=$Super_Seller_details->timezone_entry;
								$logtimezone = $timezone_entry;
								$timezone = new DateTimeZone($logtimezone);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');
									
								$Dial_Code = $this->Igain_model->get_dial_code11($Super_Seller_details->Country);
								
								$dialcode=$Dial_Code->phonecode;
								$phoneNo=$dialcode.''.$Phone_no;	
								
								$Customer_email = App_string_encrypt($inputArgs['Membership_Email']);
								
								$Check_EmailID=$this->Igain_model->Check_EmailID($Customer_email,$Company_id);
								if($Check_EmailID == 0)
								{
									$Customer_phoneNo = App_string_encrypt($phoneNo);		
									
									$CheckPhone_number=$this->Igain_model->CheckPhone_number($Customer_phoneNo,$Company_id);
									if($CheckPhone_number ==0)
									{	
										$card_decsion=$company_details->card_decsion;
										$Joining_bonus=$company_details->Joining_bonus;
										$Joining_bonus_points=$company_details->Joining_bonus_points;	
										
										if($card_decsion==1)
										{						
											 $Card_id=$company_details->next_card_no;
											
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
												'Phone_no' => $Customer_phoneNo,
												'Country' => $Super_Seller_details->Country,
												'timezone_entry' => $timezone_entry,
												'Country_id' => $Super_Seller_details->Country,
												'User_email_id' => $Customer_email,
												'User_pwd' => $Customer_phoneNo,
												'pinno' => $pin,
												'User_activated' => 1,
												'Company_id' => $Company_id,
												'Current_balance' => $Current_balance,
												'Total_topup_amt' => $Total_topup_amt,
												'User_id' => 1,
												'Card_id' => $Card_id,
												'joined_date' => $Todays_date,
												'Channel_id' => $ChannelCompanyId,
												'source' =>'3rd Party API'
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
											
										/**********Nilesh igain Log Table change 29-06-207***************/ 
											$opration = 1;				
											$User_id = 1; 
											$what="New Loyalty Customer Registration";
											$where="from 3rd Party API";
											$opval = $first_name.' '.$last_name;
											$Todays_date=date("Y-m-d");
											$firstName = $first_name;
											$lastName = $last_name; 
											$LogginUserName = $first_name.' '.$last_name;
											$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$Last_enroll_id,$email,$LogginUserName,$Todays_date,$what,$where,$User_id,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
										/*****************igain Log Table change 29-06-2017 ****************/
											
											if($Last_enroll_id > 0)
											{
												if($card_decsion==1)
												{
													$update_card_series=$this->Igain_model->UpdateCompanyMembershipID($nestcard1,$Company_id);	
													
													if($Joining_bonus==1)
													{
														$post_Transdata = array( 	
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
																	'Channel_id' => $ChannelCompanyId,
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
															'Template_type' => '3rd_Party_Joining_Bonus',
															'Todays_date' => $Todays_date
														);
														
														$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$seller_id,$Company_id);
													}						
												}
												
												$Email_content = array(
												'Notification_type' => 'Enrollment Details',
												'Template_type' => '3rd_Party_Enroll'
												);
												
												$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$seller_id,$Company_id);
												
												$Result1001 = array("Error_flag" => 1001,
																	"Membership_id" => $Card_id,
																	"Member_name" => $first_name.' '.$last_name,
																	);
												echo json_encode($Result1001);	   //Enroll successfully
											}
											else
											{
												$Result2032 = array("Error_flag" => 9999,
																	"Message" => "Registration Failed"
																	); 
												echo json_encode($Result2032);  //Mobile No is already Exist
												exit;
											}
									}
									else
									{
										$Result2032 = array("Error_flag" => 2032,
															"Message"=>"Membership Mobile is Already Exist"
															); //Mobile No is already Exist
										echo json_encode($Result2032);
										exit;
									}
								}
								else
								{
									$Result2030 = array("Error_flag" => 2030,
														"Message"=>"Membership Email is Already Exist"
														); //Email ID is already Exist
									echo json_encode($Result2030);
									exit;
								}
							}
							else
							{
								$Result3107 = array("Error_flag" => 3107,
												"Message"=>"Invalid Channel password Or Channel not exist"
												);
								echo json_encode($Result3107);  // Invalid input
								exit;
							}
						}
						else
						{
							$Result9999 = array("Error_flag" => 404,
												"Message"=>"Invalid input"
												);
							echo json_encode($Result9999);  // Invalid input
							exit;
						}		
					}
					if($API_flag == 92) // API 2.1 – LOYALTY CUSTOMER DETAILS
					{ 
						$API_flag_call = 92;
						$ChannelPassword = $inputArgs['Channel_password'];
						$Membership_id = $inputArgs['Membership_id'];
						$Item_details = $inputArgs['Bill_Items'];
						$Outlet_no = $inputArgs['Outlet_No']; //POS Outlet
						$Pos_discount = $inputArgs['POS_Discount']; //POS Outlet
						$Order_Total = $inputArgs['Order_Total']; 
						$Order_No = $inputArgs['Order_No']; 
							
						$Pos_discount = str_replace( ',', '', $Pos_discount);
						
						if($Membership_id !="" && $Item_details !="" && $Outlet_no !="" && $Order_No !="" && $Order_Total !="" && $ChannelPassword !="")
						{
							$ChannelDetails=$this->Merchant_api_model->get_3rd_party_channel_details($Company_id,$ChannelPassword);
							if($ChannelDetails != Null)
							{
								$ChannelCompanyId = $ChannelDetails->Channel_Company_Id;
								$ChannelCompanyName = $ChannelDetails->Channel_Company_Name;
								
								// $Voucher_Details1 = array();
								$result1 = $this->Merchant_api_model->Get_outlet_details($Outlet_no,$Company_id); //Get Outlet Details
									
								if($result1!=NULL)
								{
									$Seller_id = $result1->Enrollement_id;
									$Seller_name = $result1->First_name.' '.$result1->Last_name;
									$Seller_email = $result1->User_email_id;
									$timezone_entry=$result1->timezone_entry; 
									$Sub_seller_admin = $result1->Sub_seller_admin;
									$Sub_seller_Enrollement_id = $result1->Sub_seller_Enrollement_id;
									
									$Seller_Redemptionratio = $result1->Seller_Redemptionratio;
									if($Seller_Redemptionratio == Null)
									{
										$Seller_Redemptionratio = $Company_Redemptionratio;
									}
									
									if($Sub_seller_admin == 1) 
									{
										$delivery_outlet = $Seller_id;
									}
									else 
									{
										$delivery_outlet = $Sub_seller_Enrollement_id;
									}
									
									$timezone = new DateTimeZone($timezone_entry);
									$date = new DateTime();
									$date->setTimezone($timezone);
									$lv_date_time=$date->format('Y-m-d H:i:s');
									$Todays_date = $date->format('Y-m-d');
									
									$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
									$phnumber = $dial_code.$Membership_id;
									
									$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
									
									if($result!=NULL)
									{							
										$Cust_enrollement_id = $result->Enrollement_id;
										$Card_id = $result->Card_id;
										$Current_balance = $result->Current_balance;
										$Blocked_points = $result->Blocked_points;
										$Debit_points = $result->Debit_points;
										$Tier_id = $result->Tier_id;
										$Memeber_name = $result->First_name.' '.$result->Middle_name.' '.$result->Last_name;
										
										$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
									
										if($Current_point_balance < 0)
										{
											$Current_point_balance=0;
										}
										else 
										{
											$Current_point_balance=$Current_point_balance;
										}
										
										$Points_Amount1 = $Current_point_balance/$Seller_Redemptionratio;	
										
										$Redeem_Details1 = array("Points_Available" => $Current_point_balance,
																"Points_Amount" => number_format($Points_Amount1,2)
																);
									/*******************sandeep declare variable*******************/
										$order_sub_total = 0;	
										$shipping_cost = 0;
										$DiscountAmt = 0;
										$TotalvoucherAmt = 0;
										$TotalDiscountAmt = 0;
										$tax = 0;	
										$i = 0;
									/*******************sandeep declare variable*******************/
										foreach($Item_details as $item)
										{ 
											$ItemCode = $item['Item_Num']; 
											$ItemQty = $item['Item_Qty']; 
											$Item_price = $item['Item_Rate'];
											
											$Item_price = str_replace( ',', '', $Item_price);
										
											/****************sandeep discount logic 27-01-2020******************/
												$Item_price = $Item_price * $ItemQty;
												$order_sub_total = $order_sub_total + $Item_price;
												$i++;
												
											/*******************get item details*******************/
												$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
												if($ItemDetails !=NULL)
												{
													$Itemcategory_id = $ItemDetails->Merchandize_category_id;
													/***************11-7-2020*************/
													$Itemcategory_ids[] = $ItemDetails->Merchandize_category_id;
													$Itemcategory_price[$Itemcategory_id] = $item['Item_Rate'] * $item['Item_Qty'];
													/***************11-7-2020*************/
												}
												else
												{
													$ResponseData = array("Error_flag" => 3103,
																		  "Message" => "Invalid Item_Num Or Item not exist.",
																		  "Item_Num" => $ItemCode
																		); // Item not found or invalid item code
													echo json_encode($ResponseData);
													exit;
												}
											/*******************get item details*******************/
												/************11-7-2020***********/
												$DiscountResult = $this->Merchant_api_model->get_3rd_party_discount_value("",$ItemCode,$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,0,$API_flag_call);
												
												/************11-7-2020***********/
												$DisOpt = json_decode($DiscountResult,true);
						
												if($DisOpt["DiscountAmt"] > 0)
												{
													$TotalDiscountAmt = floor($TotalDiscountAmt + str_replace( ',', '', $DisOpt["DiscountAmt"]));
													
													/************11-7-2020***********/
														$ItemDiscounts[$ItemCode] = $DisOpt["DiscountAmt"];
													/************11-7-2020***********/
												}
												
												if(!empty($DisOpt["discountsArray"]) && is_array($DisOpt["discountsArray"]))
												{
													foreach($DisOpt["discountsArray"] as $k1)
													{
														$Discount_codes[] = $k1;
													}
												}
												if(!empty($DisOpt["discountsArray2"]) && is_array($DisOpt["discountsArray2"]))
												{
													foreach($DisOpt["discountsArray2"] as $k2)
													{
														$Discount_codes_2[] = $k2;
													}
												}
											///****************sandeep discount logic 27-01-2020*********************
											
											$ProductVouchers = $this->Merchant_api_model->get_member_product_vouchers($Card_id,$Company_id,$ItemCode);
											if($ProductVouchers != Null)
											{
												foreach($ProductVouchers as $row1)
												{
													if($row1->Card_value > 0)
													{
														$Voucher_Amount1 = $row1->Card_value;
														$Voucher_Type1 ="V";
													}
													else if($row1->Discount_percentage > 0)
													{
														$Voucher_Amount1 = $row1->Discount_percentage;
														$Voucher_Type1 ="P";
													}
													
													$Voucher_Details11[] = array("Voucher_No"=>$row1->Gift_card_id,"Voucher_Reference"=>null,"Voucher_Type"=>$Voucher_Type1,"Voucher_Amount"=>number_format($Voucher_Amount1,2));
													
																									
												}
												$Voucher_Details1[] = $Voucher_Details11;
											}
										}
										
										/********************11-7-2020******************/
										$Itemcategory_ids = array_unique($Itemcategory_ids);
										
										foreach($Itemcategory_ids as $Itemcategory_id)
										{
											$Item_price = $Itemcategory_price[$Itemcategory_id];
											
											$CatDiscountResult = $this->Merchant_api_model->get_3rd_party_category_discount_value($Itemcategory_id,"",$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,0,0,$API_flag_call);
												
												$DisOpt22 = json_decode($CatDiscountResult,true);
												
												if($DisOpt22["DiscountAmt"] > 0)
												{
													$TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt22["DiscountAmt"]);
													//***** 18-03-2020 ************
												}
												
												if(!empty($DisOpt22["discountsArray"]) && is_array($DisOpt22["discountsArray"]))
												{
													//$Discount_codes[] = $DisOpt["discountsArray"];
														foreach($DisOpt22["discountsArray"] as $k1)
														{
															$Discount_codes[] = $k1;
														}
												}
												
												if(!empty($DisOpt22["discountsArray2"]) && is_array($DisOpt22["discountsArray2"]))
												{
													foreach($DisOpt22["discountsArray2"] as $k2)
													{
														$Discount_codes_2[] = $k2;
													}
												}
										}
										///**************** sandeep category discount logic 27-01-2020 ***************************
										/********************11-7-2020******************/
										
										$DiscountResult12 = $this->Merchant_api_model->get_3rd_party_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$Cust_enrollement_id,$Tier_id,$order_sub_total,$API_flag_call);
										
										$DisOpt12 = json_decode($DiscountResult12,true);
										
										if($DisOpt12["DiscountAmt"] > 0)
										{
											/***************11-7-2020****************/
											$number2 = filter_var($DisOpt12["DiscountAmt"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);//1989.34
											
											$TotalDiscountAmt = ($TotalDiscountAmt + str_replace( ',', '', $number2));
											
											//***** 18-03-2020 ************	
											
											$_SESSION['BillDiscount'] = $DisOpt12["DiscountAmt"];
											/***************11-7-2020****************/
										}
										
										if(!empty($DisOpt12["discountsArray"]) && is_array($DisOpt12["discountsArray"]))
										{
											// $Discount_codes[] = $DisOpt12["discountsArray"];
											foreach($DisOpt12["discountsArray"] as $k)
											{
												$Discount_codes[] = $k;
											}
										}
										
										/******************11-7-2020****************/
										if(!empty($DisOpt12["discountsArray2"]) && is_array($DisOpt12["discountsArray2"]))
										{
											foreach($DisOpt12["discountsArray2"] as $k2)
											{
												$Discount_codes_2[] = $k2;
											}
										}
										/******************11-7-2020****************/
									
										if($DisOpt12["voucherValidity"] != null)
										{ 
											// $this->session->set_userdata('voucherValidity',$DisOpt12["voucherValidity"]);
										}
										
										$voucherAmt = $this->session->userdata('voucherAmt');
										
										$TotalDiscountAmt = str_replace( ',', '', $TotalDiscountAmt);
										$DiscountAmt = $TotalDiscountAmt;
										
										if(count($Discount_codes) > 0)
										{
											// print_r($Discount_codes);
											// $this->session->set_userdata('Discount_codes',$Discount_codes);
										}
									
										if($order_sub_total < $DiscountAmt)
										{
											$DiscountAmt = $order_sub_total;
										}
										$DiscountAmt = str_replace( ',', '', $DiscountAmt);
									///**************** sandeep discount logic 27-01-2020 ***************************		
										$order_total = ($order_sub_total + $shipping_cost + $tax) - $DiscountAmt;
										$order_total = $order_total - $Pos_discount;
										// $cart['shopping_cart']['grand_total'] = $order_total;
									/************************sandeep code end************************/
									
										$GetVouchers = $this->Merchant_api_model->Get_vouchers($Card_id,$Company_id);
										if($GetVouchers != Null)
										{
											foreach($GetVouchers as $row) 
											{	
												if($row->Card_value > 0)
												{
													$Voucher_Amount1 = $row->Card_value;
													$Voucher_Type1 ="V";
												}
												else if($row->Discount_percentage > 0)
												{
													$Voucher_Amount1 = $row->Discount_percentage;
													$Voucher_Type1 ="P";
												}
												
												$Voucher_Details1[] = array("Voucher_No"=>$row->Gift_card_id,"Voucher_Reference"=>null,"Voucher_Type"=>$Voucher_Type1,"Voucher_Amount"=>number_format($Voucher_Amount1,2));		
											}
										}
										
										$ResponseData = array("Error_flag" => 1001,
																"Membership_id" => $Card_id,
																"Member_name" => $Memeber_name,
																"Order_No" => $Order_No,
																"Order_Total" => number_format($order_sub_total,2),
																"Loyalty_Discount" => number_format($DiscountAmt,2),
																"Balance_Due" => number_format($order_total,2),
																'Redeem_Details' => $Redeem_Details1,
																// "POS_discount" => number_format($Pos_discount,2),
																'Discount_Details' => $Discount_codes,
																'Voucher_Details' => $Voucher_Details1
															);
															
										echo json_encode($ResponseData);
										exit;									
									}
									else    
									{
										$Result127 = array("Error_flag" => 2003,
															"Message" => "Invalid or unable to locate membership id"
															); 
										echo json_encode($Result127); //Unable to Locate membership id
										exit;
									} 
								}
								else
								{
									$Result3100 = array("Error_flag" => 2009,
														"Message" => "Invalid outlet no"
														);
									echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
									exit;
								}
							}
							else
							{
								$Result3107 = array("Error_flag" => 3107,
												"Message"=>"Invalid Channel password Or Channel not exist"
												);
								echo json_encode($Result3107);  // Invalid input
								exit;
							}
						}
						else
						{
							$Result9999 = array("Error_flag" => 404,
												"Message"=>"Invalid input"
												);
							echo json_encode($Result9999);  // Invalid input
							exit;
						}
					}  
					if($API_flag == 93)  //API 2.2 – LOYALTY REDEEM POINTS 
					{	
						$ChannelPassword = $inputArgs['Channel_password'];
						$Membership_id = $inputArgs['Membership_id'];
						$Pos_bill_no = $inputArgs['Order_No'];
						$Pos_bill_status = $inputArgs['Bill_Status'];
						$Purchase_amount = $inputArgs['Order_Total'];
						$Pos_bill_date_time = $inputArgs['Order_Date_Time'];
						$Pos_order_type = $inputArgs['Order_Type'];
						$Pos_trans_type = $inputArgs['Trans_Type'];
						$Pos_outlet_id = $inputArgs['Outlet_No'];
						$Pos_outlet_name = $inputArgs['Outlet_Name'];
						$Pos_bill_items = $inputArgs['Bill_Items'];
						$Pos_redeem_details = $inputArgs['Redeem_Details'];
						$Redeem_points = $Pos_redeem_details['Points_Redeemed'];
						
						$Purchase_amount = str_replace( ',', '', $Purchase_amount);
						$Redeem_points = str_replace( ',', '', $Redeem_points);
						
						$promo_reedem = '';
						$Gift_reedem = '';
						$Promo_redeem_by = 0;
						$Gift_redeem_by = 0;
						$balance_to_pay = '';	
						
						if($Membership_id !="" && $Pos_bill_no !="" && $Purchase_amount !="" && $Redeem_points !="" && $Pos_outlet_id !="" && $ChannelPassword !="")
						{
							$ChannelDetails=$this->Merchant_api_model->get_3rd_party_channel_details($Company_id,$ChannelPassword);
							if($ChannelDetails != Null)
							{
								$ChannelCompanyId = $ChannelDetails->Channel_Company_Id;
								$ChannelCompanyName = $ChannelDetails->Channel_Company_Name;
									
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
								$phnumber = $dial_code.$Membership_id;
														
								$result = $this->Merchant_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
								if($result!=NULL)
								{							
									$Cust_enrollement_id = $result->Enrollement_id;
									$Cust_Card_id = $result->Card_id;
									$Current_balance = $result->Current_balance;
									$Blocked_points = $result->Blocked_points;
									$Debit_points = $result->Debit_points;
									
									$lv_member_Tier_id = $result->Tier_id;
									$Total_reddems = $result->Total_reddems;
									
									$Current_point_balance = $Current_balance-($Blocked_points+$Debit_points);
									if($Current_point_balance < 0)
									{
										$Current_point_balance=0;
									}
									else 
									{
										$Current_point_balance=$Current_point_balance;
									}
									
									if($Redeem_points <=0 || $Redeem_points == null)
									{
										$Result1271 = array(
														"Error_flag" => 3104,
														"Message" => "Invalid redeem points."
													);
													
										echo json_encode($Result1271); // Membership Id Not found
										exit;
									}
									if($Total_reddems == 0)
									{
										$result51 = $this->Merchant_api_model->Get_Member_Tier_Details($lv_member_Tier_id,$Company_id);
										$Tier_redeemtion_limit = $result51->Redeemtion_limit;
										if($Tier_redeemtion_limit != Null)
										{
											if($Current_point_balance < $Tier_redeemtion_limit)
											{
												$Result31 = array(
																"Error_flag" => 3101,
																"Message" => "Insufficient Point Balance.!!"
															);
															
												echo json_encode($Result31); //Insufficient Point Balance
												exit;
											}
										}
									}
									$result1 = $this->Merchant_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
									
									if($result1!=NULL)
									{
										$Seller_id = $result1->Enrollement_id;
										$Outlet_name = $result1->First_name. ' '.$result1->Last_name;
										
										$Seller_Redemptionratio = $result1->Seller_Redemptionratio;
										if($Seller_Redemptionratio == Null)
										{
											$Seller_Redemptionratio = $Company_Redemptionratio;
										}
											
										$currency_details = $this->Igain_model->Get_Country_master($result1->Country);
										$Symbol_currency = $currency_details->Symbol_of_currency;
										
										/*$result2 = $this->Merchant_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points);
										
										if($result2!=NULL)
										{
											$Cust_confirmation_code = $result2->Confirmation_code;*/
										
											if($Redeem_points <= $Current_point_balance)
											{
												$result221 = $this->Merchant_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no);
												
												if($result221 != Null)
												{
													$Earlier_request_flag = $result221->Confirmation_flag;
													if($Earlier_request_flag == 0)
													{
														$Earlier_request_time = $result221->Creation_date;
														$Validity = explode(":",$Company_redeem_request_validity);
			
														$H = $Validity[0];
														$M = $Validity[1];
														$S = $Validity[2];
														
														$cenvertedTime = date("Y-m-d H:i:s",strtotime("+$H hour +$M minutes",strtotime($Earlier_request_time)));
														
														$currentTime = date("Y-m-d H:i:s");
														
														if($currentTime > $cenvertedTime)
														{
															$data1 = array(
																	'Confirmation_flag' => 2
																	);
																	
															$this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
														}
													}
												}
												$result22 = $this->Merchant_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no);
												
												if($result22==NULL) 
												{
													$calculate2 = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem);
													
													$calculate2 = str_replace( ',', '', $calculate2);
													
													if($calculate2!=2066)
													{
														$Confirmation_code = $this->Igain_model->getRandomString();
							
														$data = array(
																	'Enrollement_id' => $Cust_enrollement_id, 
																	'Company_id' => $Company_id,
																	'Seller_id' => $Seller_id,
																	'Channel_id' => $ChannelCompanyId,
																	'Confirmation_code' => $Confirmation_code,
																	'Confirmation_flag' => 0,
																	'Redeem_points' => $Redeem_points,
																	'Pos_bill_no' => $Pos_bill_no,
																	'Bill_amount' => $Purchase_amount,
																	'Creation_date' => date("Y-m-d H:i:s")
																);
																
														$data1 = array(
																	'Confirmation_flag' => 2
																	);
																	
														$this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
																
														$Redeem_request = $this->Merchant_api_model->Cust_redeem_request_insert($data);
													
														// $Notification_type ='Redeem Request with '.$Outlet_name;
														$Notification_type ='Redeem Points Confirmation';
														
														$Email_content = array(
																	'Notification_type' => $Notification_type,
																	'Confirmation_code' => $Confirmation_code,
																	'Redeem_points' => $Redeem_points,
																	'Bill_no' => $Pos_bill_no,
																	'Bill_amount' => number_format($Purchase_amount, 2),
																	'Symbol_currency' => $Symbol_currency,
																	'Equivalent_amount' => number_format($calculate2, 2),
																	'Template_type' => '3rd_Party_Customer_redeem_request',
																	'Outlet_name' => $Outlet_name
																);
												
														$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id); 
														
														$Error_code = "1001"; // sent request
													}
												}
												else
												{
													$Error_code = "3108"; // already sent but not confirm
												}
												
												$result2 = $this->Merchant_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no);
												
												$Cust_confirmation_flag = $result2->Confirmation_flag;
												$Cust_confirmation_code = $result2->Confirmation_code;
												if($Cust_confirmation_flag == 1)
												{
													$Error_code = "1001"; // confirm
													$Cust_confirmation_code = $Cust_confirmation_code;
												}
												else if($Cust_confirmation_flag == 3)
												{
													$Error_code = "3109";  // Decline
													$Cust_confirmation_code = $Cust_confirmation_code;
												}
												$calculate = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem);
												
												$calculate = str_replace( ',', '', $calculate);
												
												if($result2 !=NULL)
												{
													if($calculate != NULL)
													{
														if($calculate== 2066 || $calculate > $Purchase_amount) //Equivalent Redeem Amount is More than Total Bill Amount
														{
															$Equivalent = array(
																"Error_flag" => 2066,
																"Message" => "Equivalent Redeem Amount is More than Total Bill Amount"
															);
														}
														else
														{
															$Equivalent = array(
																// "Error_flag" => 1001, 
																"Error_flag" => $Error_code, 
																"Membership_id" => $Cust_Card_id,
																"Current_Points" => $Current_point_balance,
																"Redeem_Points" => $Redeem_points,
																"Equivalent_Redeem_Amount" => number_format($calculate, 2),
																"Balance_Points" => $Current_point_balance-$Redeem_points,
																"Confirmation_Code" => $Cust_confirmation_code,
																// "Confirmation_flag" => 1,
																"Confirmation_Flag" => $Cust_confirmation_flag,
																"Order_No" => $Pos_bill_no,
																"Order_Total" => number_format($Purchase_amount,2)
															);
														}	
														
														// $data1 = array(
																	// 'Confirmation_flag' => 2
																	// );
																	
														// $this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
														
														echo json_encode($Equivalent); // successfully
														exit;	
													}
													else
													{ 
														$Error = array(
																// "Error_flag" => 1001,
																"Error_flag" => $Error_code, 
																"Membership_id" => $Cust_Card_id,
																"Current_Points" => $Current_point_balance,
																"Redeem_Points" => $Redeem_points,
																"Equivalent_Redeem_Amount" =>  number_format(0, 2),
																"Balance_Points" => $Current_point_balance-$Redeem_points,
																"Confirmation_Code" => $Cust_confirmation_code,
																// "Confirmation_flag" => 1,
																"Confirmation_Flag" => $Cust_confirmation_flag,
																"Order_No" => $Pos_bill_no,
																"Order_Total" => number_format($Purchase_amount,2)
															);
															
														echo json_encode($Error); // Null result found
														exit;
													}
												}
												else
												{
													if($calculate == 2066 || $calculate > $Purchase_amount) //Equivalent Redeem Amount is More than Total Bill Amount
													{
														$Equivalent = array(
															"Error_flag" => 2066,
															"Message" =>"Equivalent Redeem Amount is More than Total Bill Amount"
														);
														
														echo json_encode($Equivalent);
														exit;
													}
													else
													{
														$Equivalent = array(
																	// "Error_flag" => 1001, 
																	"Error_flag" => $Error_code,
																	"Membership_id" => $Cust_Card_id,
																	"Current_Points" => $Current_point_balance,
																	"Redeem_Points" => $Redeem_points,
																	"Equivalent_Redeem_Amount" => number_format($calculate, 2),
																	"Balance_Points" => $Current_point_balance-$Redeem_points,
																	"Confirmation_Code" => null,
																	"Confirmation_Flag" => 0,
																	"Order_No" => $Pos_bill_no,
																	"Order_Total" => number_format($Purchase_amount,2)
																);
														echo json_encode($Equivalent); // Cust Not Approved 
														exit;
													}
												}
											}
											else
											{ 
												$Result12 = array(
															"Error_flag" => 3101,
															"Message" => "Insufficient Point Balance."
														);
														
												echo json_encode($Result12); //Insufficient Point Balance
												exit;
											}
										/*}
										else
										{ 
											$Result12 = array(
														"Error_flag" => 3108,
														"Confirmation_flag" => 0
													);
													
											echo json_encode($Result12); //Customer Not Approved redeemprion request
											exit;
										} */
									}
									else
									{
										$Result3100 = array(
														"Error_flag" => 2009,
														"Message" => "Invalid outlet no"
													);
													
										echo json_encode($Result3100); // Invalid outlet no
										exit;
									}
								}
								else    
								{
									$Result127 = array(
														"Error_flag" => 2003,
														"Message" => "Invalid or unable to locate membership id"
													);
													
									echo json_encode($Result127); // Membership Id Not found
									exit;
								}
							}
							else
							{
								$Result3107 = array("Error_flag" => 3107,
												"Message"=>"Invalid Channel password Or Channel not exist"
												);
								echo json_encode($Result3107);  // Invalid input
								exit;
							}
						}
						else
						{	
							$Result9999 = array("Error_flag" => 404,
												"Message"=>"Invalid input"
												);
							echo json_encode($Result9999);  // Invalid input
							exit;
						}
					}
					if($API_flag == 94) // API 2.3 – FINAL ORDER CONFIRMATION 
					{ 
						$API_flag_call = 94;
						$gained_points_fag = 0;
						
						$ChannelPassword = $inputArgs['Channel_password'];
						$cardId = $inputArgs['Membership_id'];
						$Pos_Order_No = $inputArgs['Order_No'];
						$Pos_Order_Status = $inputArgs['Order_Status'];
						$Pos_Order_Type = $inputArgs['Order_Type'];
						$Pos_Trans_Type = $inputArgs['Trans_Type'];
						$Pos_bill_no = $inputArgs['Bill_No'];
						$Pos_bill_status = $inputArgs['Bill_Status'];
						$Pos_bill_amount = $inputArgs['Order_Total'];
						$Pos_discount = $inputArgs['POS_Discount'];
						$Pos_loyalty_discount = $inputArgs['Loyalty_Discount'];
						$Pos_bill_date_time = $inputArgs['Order_Date_Time'];
						$Pos_outlet_id = $inputArgs['Outlet_No'];
						$Pos_outlet_name = $inputArgs['Outlet_Name'];
						$Pos_bill_items = $inputArgs['Bill_Items'];  
						$Pos_voucher_details = $inputArgs['Voucher_Details'];
						$Pos_voucher_no = $Pos_voucher_details['Voucher_No'];
						$Pos_voucher_reference = $Pos_voucher_details['Voucher_Reference'];
						$Pos_voucher_amount = $Pos_voucher_details['Voucher_Amount'];
						$Pos_redeem_details = $inputArgs['Redeem_Details'];
						$Pos_points_redeemed = $Pos_redeem_details['Points_Redeemed'];
						$Pos_points_amount = $Pos_redeem_details['Points_Amount'];
						$RedeemedConfirmationCode = $Pos_redeem_details['Confirmation_Code'];
						
						$Pos_bill_tenders = $inputArgs['Bill_Tenders'];
						if($Pos_bill_tenders !=Null){
							foreach($Pos_bill_tenders as $bill_tenders)
							{ 
								$Tender_Type = $bill_tenders['Tender_Type'];
								$Tender_Amount = $bill_tenders['Tender_Amount'];
								$Tender_Reference = $bill_tenders['Tender_Reference'];
							}
						}
						$Pos_outlet_id2 = $Pos_outlet_id;
						$Pos_payment_type = $Tender_Type;
						
						$Pos_bill_amount = str_replace( ',', '', $Pos_bill_amount);
						$Pos_discount = str_replace( ',', '', $Pos_discount);
						$Pos_loyalty_discount = str_replace( ',', '', $Pos_loyalty_discount);
						$Pos_voucher_amount = str_replace( ',', '', $Pos_voucher_amount);
						$Pos_points_redeemed = str_replace( ',', '', $Pos_points_redeemed);
						$Pos_points_amount = str_replace( ',', '', $Pos_points_amount);
						
						
						$delivery_outlet = $Pos_outlet_id;
						$Cust_redeem_point = $Pos_points_redeemed;
						$EquiRedeem = $Pos_points_amount;
						$subtotal = $Pos_bill_amount;
						
						if($cardId !="" && $Pos_Order_No !="" && $Pos_Order_Type !="" && $Pos_Trans_Type !="" && $Pos_bill_amount !="" && $Pos_outlet_id !=""&& $Pos_bill_items !="" && $Pos_bill_tenders !="" && $Pos_Order_Status !="" && $ChannelPassword !="")
						{
							$ChannelDetails=$this->Merchant_api_model->get_3rd_party_channel_details($Company_id,$ChannelPassword);
							if($ChannelDetails != Null)
							{
								$ChannelCompanyId = $ChannelDetails->Channel_Company_Id;
								$ChannelCompanyName = $ChannelDetails->Channel_Company_Name;
									
								$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code 			
								$phnumber = $dial_code.$inputArgs['Membership_id'];
								
								$cust_details = $this->Merchant_api_model->cust_details_from_card($Company_id,$cardId,$phnumber); //Get Customer details
								if($cust_details !=NULL)
								{
									foreach($cust_details as $row25)
									{
										$Customer_enroll_id=$row25['Enrollement_id'];
										$CardId=$row25['Card_id'];
										$fname=$row25['First_name'];
										$midlename=$row25['Middle_name'];
										$lname=$row25['Last_name'];
										$User_email_id=$row25['User_email_id'];
										$Date_of_birth=$row25['Date_of_birth'];
										$address=$row25['Current_address'];
										$bal=$row25['Current_balance'];
										$Blocked_points=$row25['Blocked_points'];
										$Debit_points=$row25['Debit_points'];
										$phno=$row25['Phone_no'];
										$pinno=$row25['pinno'];
										$companyid=$row25['Company_id'];
										$cust_enrollment_id=$row25['Enrollement_id'];
										$image_path=$row25['Photograph'];				
										$filename_get1=$image_path;	
										$Tier_name = $row25['Tier_name'];
										$lv_member_Tier_id = $row25['Tier_id'];
										$Sex = $row25['Sex'];
										$District = $row25['District'];
										$Zipcode = $row25['Zipcode'];
										$total_purchase = $row25['total_purchase'];
										$Total_reddems = $row25['Total_reddems'];
										$Memeber_name = $fname.' '.$midlename.' '.$lname;
									}
								
									$Current_balance = $bal;
									$Current_bal1 = $bal-($Blocked_points+$Debit_points);
							
									if($Current_bal1<0)
									{
										$Current_bal1=0;
									}
									else
									{
										$Current_bal1=$Current_bal1;
									}
									
									if($Current_bal1 <$Pos_points_redeemed)
									{
										$Result12 = array(
															"Error_flag" => 3101,
															"Message" => "Insufficient Current Balance",
															"Current_balance" => $Current_bal1
														);
										echo json_encode($Result12); //Insufficient Point Balance
										exit;
									}
									$result01 = $this->Merchant_api_model->check_pos_bill_no($Pos_bill_no,$Pos_outlet_id,$Company_id,$Pos_bill_date_time);				
									if ($result01 > 0)
									{
										$Result2067 = array("Error_flag" => 2067,
																"Message" => "Bill_No already exist."
																); 
										echo json_encode($Result2067); //Invalid Gift Card Or No Balance In Gift Card
										exit;
									}
									if($Pos_voucher_no)
									{
										$Voucher_result = $this->Merchant_api_model->Validate_discount_voucher($CardId,$Company_id,$Pos_voucher_no,$Pos_voucher_amount);
										if($Voucher_result == Null)
										{
											$Result327 = array("Error_flag" => 2069,
																"Message" => "Invalid Voucher no. Or No Balance In Voucher."
																); 
											echo json_encode($Result327); //Invalid Gift Card Or No Balance In Gift Card
											exit;
										}
										else
										{
											$Pos_voucher_no = $Pos_voucher_no;
											$Pos_voucher_amount = $Voucher_result->Card_value;
											$Card_Payment_Type_id = $Voucher_result->Payment_Type_id;
											$Discount_percentage = $Voucher_result->Discount_percentage;
											
											$Pos_voucher_amount = str_replace( ',', '', $Pos_voucher_amount);
											if($Card_Payment_Type_id == 997) //product voucher
											{
												$Product_Voucher_Details = $this->Merchant_api_model->Get_Product_Voucher_Details($Pos_voucher_no,$Customer_enroll_id,$Company_id);
												
												$Product_Voucher_item_code = $Product_Voucher_Details->Company_merchandize_item_code;
												
												$Cust_Item_Num = array();
												foreach($Pos_bill_items as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													
													$ItemDetails1 = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
													
													if($ItemDetails1 !=NULL)
													{
														$Merchandize_item_code = $ItemDetails1->Company_merchandize_item_code;
														$Item_name = $ItemDetails1->Merchandize_item_name;
														
														$Cust_Item_Num[] = $ItemCode;
													}
													else
													{
														$ResponseData = array("Error_flag" => 3103,
																			  "Message" => "Invalid Item_Num Or Item not exist.",
																			  "Item_Num" => $ItemCode
																			); // Item not found or invalid item code
														echo json_encode($ResponseData);
														exit;
													}
												}
												if(in_array($Product_Voucher_item_code, $Cust_Item_Num))
												{
												  // echo "Item found";
												}
												else{
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid Voucher no."
																	); //Invalid Gift Card Or No Balance In Gift Card
													echo json_encode($Result427);
													exit;
												}
											}
										
											if($Discount_percentage > 0)
											{
												$Bill_amount11 = $Pos_bill_amount - $Pos_discount - $Pos_loyalty_discount;
												$Pos_voucher_amount = (($Bill_amount11 * $Discount_percentage)/100);
												$Pos_voucher_amount = floor($Pos_voucher_amount);
											}
										}
									}
									else
									{
										$Pos_voucher_no = Null;
										$Pos_voucher_amount = 0.00;
									}
									
									$get_city_state_country = $this->Merchant_api_model->Fetch_city_state_country($Company_id,$Customer_enroll_id);
									$State_name=$get_city_state_country->State_name;
									$City_name=$get_city_state_country->City_name;
									$Country_name=$get_city_state_country->Country_name;
						
									$result = $this->Merchant_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
									if($result!=NULL)
									{
										$seller_id = $result->Enrollement_id;
										$seller_fname = $result->First_name;
										$seller_lname = $result->Last_name;
										$Pos_outlet_name = $seller_fname .' '. $seller_lname;
										$Seller_Redemptionratio = $result->Seller_Redemptionratio;
										$Purchase_Bill_no = $result->Purchase_Bill_no;
										$Sub_seller_admin = $result->Sub_seller_admin;
										$Sub_seller_Enrollement_id = $result->Sub_seller_Enrollement_id;
										$Outlet_address = App_string_decrypt($result->Current_address);
										$currency_details = $this->Igain_model->Get_Country_master($result->Country);
										$Symbol_currency = $currency_details->Symbol_of_currency;
										$Pos_outlet_id1 = $seller_id;
										
										if($Pos_points_redeemed > 0)
										{
											$Redeem_details=$this->Merchant_api_model->Check_redeem_details($Customer_enroll_id,$Company_id,$Pos_outlet_id,$ChannelCompanyId,$RedeemedConfirmationCode,$Pos_points_redeemed,$Pos_Order_No);
											
											if($Redeem_details != Null)
											{
												$Confirmation_flag1 = $Redeem_details->Confirmation_flag;
												if($Confirmation_flag1 == 0)
												{
													$Result08 = array(
																	"Error_flag" => 3108,
																	"Message" => "Redeem Not Confirmed"
																);
													echo json_encode($Result08); //Redeem Not Confirmed
													exit;
												}
												else if($Confirmation_flag1 == 3)
												{
													$Result09 = array(
																	"Error_flag" => 3109,
																	"Message" => "Redeem Declined"
																);
													echo json_encode($Result09); //Redeem Not Confirmed
													exit;
												}	
											}
											else
											{
												$Result10 = array(
																	"Error_flag" => 3110,
																	"Message" => "Incorrect Redeem details"
																);
													echo json_encode($Result10); //Redeem Not Confirmed
													exit;
											}
										}
										if($Sub_seller_admin == 1) 
										{
											$Pos_outlet_id = $seller_id;
										}
										else 
										{
											$Pos_outlet_id = $Sub_seller_Enrollement_id;
										}
										
										if($Seller_Redemptionratio !=Null)
										{
											$Company_Redemptionratio = $Seller_Redemptionratio;
										}
										else
										{
											$Company_Redemptionratio =$Company_Redemptionratio;
										}
											$tp_db = $Purchase_Bill_no;
											$len = strlen($tp_db);
											$str = substr($tp_db,0,5);
											$bill = substr($tp_db,5,$len);
							   
											$date = new DateTime();
											$lv_date_time=$date->format('Y-m-d H:i:s'); 
								  
											$lv_date_time2 = $date->format('Y-m-d'); 
								
											$Trans_type = 29;  //3rd part order
											$Trans_Channel_id = 29;  //3rd part order
											
											$Payment_type_id = 1; //default cash
											$Online_payment_method1 = "Cash";
											
											if($Pos_payment_type == Null)
											{
												$Payment_type_id = 4; 
												$Online_payment_method1 = "Points";
											}
											else if($Pos_payment_type == 1)
											{
												$Payment_type_id = 1;  
												$Online_payment_method1 = "Cash";
											}
											else if($Pos_payment_type == 2)
											{
												$Payment_type_id = 3; 
												$Online_payment_method1 = "Credit Card";
											}
											else if($Pos_payment_type == 3)
											{
												$Payment_type_id = 5; 
												$Online_payment_method1 = "Mobile Money";
											}
											else if($Pos_payment_type == 4)
											{
												$Payment_type_id = 6; 
												$Online_payment_method1 = "Prepaid";
											}
											else if($Pos_payment_type == 6)
											{
												$Payment_type_id = 7; 
												$Online_payment_method1 = "Other";
											}
											
											$Remarks = "3rd Party order";
											
											if($Sub_seller_admin == 1) 
											{
											  $seller_id = $seller_id;
											}
											else 
											{
											  $seller_id = $Sub_seller_Enrollement_id;
											}
										
											$order_total_loyalty_points = 0;
											
											/**************new logic with pos items********************/
											if($Pos_bill_items != Null)
											{
												$order_sub_total = 0;	
												$shipping_cost = 0;
												$DiscountAmt = 0;
												$TotalvoucherAmt = 0;
												$TotalDiscountAmt = 0;
												$ItemDiscounts = [];
												$tax = 0;	
												$i = 0;
										// if($Pos_loyalty_discount > 0) // 19-06-2020
										// {
												foreach($Pos_bill_items as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													$ItemQty = $item['Item_Qty']; 
													$Item_price = $item['Item_Rate'];
													
													$Item_price = str_replace( ',', '', $Item_price);
													
														$Item_price = $Item_price * $ItemQty;
														$order_sub_total = $order_sub_total + $Item_price;
														$i++;
														
													
														$ItemDetails = $this->Merchant_api_model->Get_item_details($ItemCode,$Company_id);
														if($ItemDetails !=NULL)
														{
															$Itemcategory_id = $ItemDetails->Merchandize_category_id;
															
															/***************11-7-2020*************/
															$Itemcategory_ids[] = $ItemDetails->Merchandize_category_id;
															$Itemcategory_price[$Itemcategory_id] = $item['Item_Rate'] * $item['Item_Qty'];
															/***************11-7-2020*************/
														}
														else
														{
															$ResponseData1 = array("Error_flag" => 3103,
																			  "Message" => "Invalid Item_Num Or Item not exist.",
																			  "Item_Num" => $ItemCode
																			); // Item not found or invalid item code
															echo json_encode($ResponseData1);
															exit;
														}
													
														$DiscountResult = $this->Merchant_api_model->get_3rd_party_discount_value("",$ItemCode,$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,0,$API_flag_call);
														
														$DisOpt = json_decode($DiscountResult,true);
								
														if($DisOpt["DiscountAmt"] > 0)
														{
															$TotalDiscountAmt = floor($TotalDiscountAmt + str_replace( ',', '', $DisOpt["DiscountAmt"]));
															
															$ItemDiscounts[$ItemCode] = $DisOpt["DiscountAmt"];
														}
														
														if(!empty($DisOpt["discountsArray"]) && is_array($DisOpt["discountsArray"]))
														{
															foreach($DisOpt["discountsArray"] as $k1)
															{
																$Discount_codes[] = $k1;
															}
														}
														if(!empty($DisOpt["discountsArray2"]) && is_array($DisOpt["discountsArray2"]))
														{
															foreach($DisOpt["discountsArray2"] as $k2)
															{
																$Discount_codes_2[] = $k2;
															}
														}
													///****************sandeep discount logic 27-01-2020*********************
												}
												/********************11-7-2020******************/
												$Itemcategory_ids = array_unique($Itemcategory_ids);
												foreach($Itemcategory_ids as $Itemcategory_id)
												{
													$Item_price = $Itemcategory_price[$Itemcategory_id];
													
													$CatDiscountResult = $this->Merchant_api_model->get_3rd_party_category_discount_value($Itemcategory_id,"",$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,0,0,$API_flag_call);
														
														$DisOpt22 = json_decode($CatDiscountResult,true);
														
														if($DisOpt22["DiscountAmt"] > 0)
														{
															$TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt22["DiscountAmt"]);
															//***** 18-03-2020 ************
														}
														
														if(!empty($DisOpt22["discountsArray"]) && is_array($DisOpt22["discountsArray"]))
														{
															foreach($DisOpt22["discountsArray"] as $k1)
															{
																$Discount_codes[] = $k1;
															}
														}
														if(!empty($DisOpt22["discountsArray2"]) && is_array($DisOpt22["discountsArray2"]))
														{
															foreach($DisOpt22["discountsArray2"] as $k2)
															{
																$Discount_codes_2[] = $k2;
															}
														}
												}
											///**************** sandeep category discount logic 27-01-2020 ***************************
										
												$DiscountResult12 = $this->Merchant_api_model->get_3rd_party_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,$order_sub_total,$API_flag_call);
												
												$DisOpt12 = json_decode($DiscountResult12,true);
												
												if($DisOpt12["DiscountAmt"] > 0)
												{
													$number2 = filter_var($DisOpt12["DiscountAmt"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
													$TotalDiscountAmt = ($TotalDiscountAmt + str_replace( ',', '', $number2));
													
													$_SESSION['BillDiscount'] = $DisOpt12["DiscountAmt"];
												}
												
												if(!empty($DisOpt12["discountsArray"]) && is_array($DisOpt12["discountsArray"]))
												{
													foreach($DisOpt12["discountsArray"] as $k)
													{
														$Discount_codes[] = $k;
													}
												}
											/******************11-7-2020****************/
												if(!empty($DisOpt12["discountsArray2"]) && is_array($DisOpt12["discountsArray2"]))
												{
													foreach($DisOpt12["discountsArray2"] as $k2)
													{
														$Discount_codes_2[] = $k2;
													}
												}
											/******************11-7-2020****************/
											
												
												if($DisOpt12["voucherValidity"] != null)
												{ 
													$this->session->set_userdata('voucherValidity',$DisOpt12["voucherValidity"]);
												}
												$voucherValidity = $this->session->userdata('voucherValidity');
												
												$voucherAmt = $this->session->userdata('voucherAmt');
												
												// $DiscountAmt = $TotalDiscountAmt;
												
												$TotalDiscountAmt = str_replace( ',', '', $TotalDiscountAmt);
												$DiscountAmt = $TotalDiscountAmt;
												
												$_SESSION['DiscountAmt']= $TotalDiscountAmt;
												
												if(count($Discount_codes) > 0)
												{}
													
												if(count($ItemDiscounts) > 0)
												{
												
													$this->session->set_userdata('ItemDiscounts',$ItemDiscounts);
												}
										
												if($order_sub_total < $DiscountAmt)
												{
													$DiscountAmt = $order_sub_total;
												}
												
												$order_total = ($order_sub_total + $shipping_cost + $tax) - $DiscountAmt;
										// } // 19-06-2020
											
										 // $Pos_discount_amount = $Pos_discount+$Pos_loyalty_discount+$Pos_voucher_amount;
										 
										$Pos_discount_amount = $Pos_discount+$Pos_loyalty_discount+$Pos_voucher_amount;
										
										$grand_total = ($Pos_bill_amount-$Pos_points_amount)-$Pos_discount_amount;
										
									/*	
										$Pos_bill_amount1 = $Pos_bill_amount - $Pos_discount_amount;
										$RedeemAmtCheck = $this->Merchant_api_model->cal_redeem_amt_contrl($Pos_points_redeemed,$Company_Redemptionratio,$Pos_bill_amount1,0,0,0,0,0);
									
										$grand_total = ($Pos_bill_amount-$RedeemAmtCheck)-$Pos_discount_amount;
								
										$EquiRedeem = $RedeemAmtCheck;
										
										$grand_totalCheck = ($Pos_bill_amount-$RedeemAmtCheck)-$Pos_discount_amount;*/
										
										// if($grand_totalCheck < 0 || $RedeemAmtCheck == 2066)
										if($grand_total < 0 )
										{
											// $RedeemAmtCheck=$Pos_points_redeemed/$Company_Redemptionratio;
											
											$Result1327 = array("Error_flag" => 2066,
																"Bill_total" => number_format($Pos_bill_amount,2),
																"Discount_amount" => number_format($Pos_discount_amount,2),
																"Redeem_amount" => number_format($Pos_points_amount,2),
																"Message" => "Total discount amount and redeem amount is more than total bill amount."
																); 
											echo json_encode($Result1327); 
											exit;
										}
										
											
											// $ItemDiscounts = $this->session->userdata('ItemDiscounts');
											$Extra_earn_points_Loyalty_pts = array();
												foreach ($Pos_bill_items as $item)
												{
													/********************************/
														$characters = 'A123B56C89';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array1[]=$Voucher_no;
													/*************************************/
														$Item_code = $item['Item_Num'];
														$Menu_Group_Id = $item['Menu_Group_Id'];
														$Pos_item_rate = $item['Item_Rate'];
														$Pos_item_rate = str_replace( ',', '', $Pos_item_rate);
														$Pos_item_qty = $item['Item_Qty'];
													/********Get Merchandize item name********/
														$result = $this->Merchant_api_model->Get_merchandize_item($Item_code,$Company_id);
														
														$sellerID = $result->Seller_id;
														if($sellerID !=NULL || $sellerID !='0')
														{
															$sellerID = $sellerID; // apply item outlet rule
														}
														else
														{
															$sellerID = $seller_id; // apply POS outlet rule
														}
														
														$sellerID = $seller_id; // apply POS outlet rule
														
														$Company_merchandize_item_code = $result->Company_merchandize_item_code;
														$Merchandize_item_name = $result->Merchandize_item_name;
														$Merchandize_category_id = $result->Merchandize_category_id;
														$Stamp_item_flag = $result->Stamp_item_flag;
														$Merchandize_partner_id = $result->Partner_id;
														// $Item_cost_price = $result->Cost_price*$Pos_item_qty;
														$Item_cost_price = $Pos_item_rate*$Pos_item_qty;
														
														$Item_branch = $this->Merchant_api_model->get_items_branches($Company_merchandize_item_code,$Merchandize_partner_id,$Company_id);
														$Item_branch_code = $Item_branch->Branch_code;
														
														if(count($ItemDiscounts) > 0)
														{
															$thisItemDiscount = $ItemDiscounts[$Company_merchandize_item_code];
															
														}
														/******************New Loyalty Rule Logic********************/ 
														$Extra_earn_points = 0;
														
														if($Stamp_item_flag == 1)
														{
															$Extra_earn_points = $result->Extra_earn_points;
															$Extra_earn_points_Loyalty_pts[]=$Extra_earn_points;
														}
														if($sellerID!=0)
														{
														/**********Get Seller Details**********/
															$Seller_result = $this->Pos_model->Get_Seller_details($sellerID,$Company_id);	
															$Seller_First_name=$Seller_result->First_name;
															$Seller_Last_name=$Seller_result->Last_name;
															$seller_name=$Seller_First_name.' '.$Seller_Last_name;
															$Purchase_Bill_no = $Seller_result->Purchase_Bill_no;

															$tp_db = $Purchase_Bill_no;
															$len = strlen($tp_db);
															$str = substr($tp_db,0,5);
															$bill = substr($tp_db,5,$len);
														/**********Get Seller Details**********/
														
															$seller_id=$sellerID;
															
															$loyalty_prog = $this->Pos_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
															
															$points_array = array();

															$Applied_loyalty_id = array();
															if($loyalty_prog != NULL )
															{
																foreach($loyalty_prog as $prog)
																{
																	$member_Tier_id = $lv_member_Tier_id;
																	$value = array();
																	$dis = array();
																	$LoyaltyID_array = array();
																	$Loyalty_at_flag = 0;	
																	$lp_type=substr($prog['Loyalty_name'],0,2);
																	$Todays_date = $lv_date_time;
																	
																$lp_details = $this->Pos_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);
																
																	$lp_count = count($lp_details);

																	foreach($lp_details as $lp_data)
																	{
																		$LoyaltyID = $lp_data['Loyalty_id'];
																		$lp_name = $lp_data['Loyalty_name'];
																		$lp_From_date = $lp_data['From_date'];
																		$lp_Till_date = $lp_data['Till_date'];
																		$Loyalty_at_value = $lp_data['Loyalty_at_value'];
																		$Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
																		$discount = $lp_data['discount'];
																		$lp_Tier_id = $lp_data['Tier_id'];
																		$Category_flag = $lp_data['Category_flag'];
																		$Category_id = $lp_data['Category_id'];
																		$Segment_flag = $lp_data['Segment_flag'];
																		$Segment_id	= $lp_data['Segment_id'];
																	
																//********* 10-7-2020- nilesh ****channel and payment ***************
																	$Trans_Channel_flag	= $lp_data['Channel_flag'];
																	$Trans_Payment_flag	= $lp_data['Payment_flag'];
																	$Trans_Channel_flag	= $lp_data['Channel_flag'];
																	$Trans_Channel	= $lp_data['Trans_Channel'];
																	$Lp_Payment_Type_id	= $lp_data['Payment_Type_id'];
																	
																//********* 10-7-2020- nilesh ****channel and payment ***************
																
																		if($lp_Tier_id == 0)
																		{
																			$member_Tier_id = $lp_Tier_id;
																		}
																		if($Loyalty_at_value > 0)
																		{
																			$value[] = $Loyalty_at_value;	
																			$dis[] = $discount;
																			$LoyaltyID_array[] = $LoyaltyID;
																			$Loyalty_at_flag = 1;
																		}
																		if($Loyalty_at_transaction > 0)
																		{
																			$value[] = $Loyalty_at_transaction;	
																			$dis[] = $Loyalty_at_transaction;
																			$LoyaltyID_array[] = $LoyaltyID;
																			$Loyalty_at_flag = 2;
																		}
																	}
																
																	if($lp_type == 'PA')
																	{		
																		// $transaction_amt = $subtotal;
																		$transaction_amt1=$Pos_item_qty * $Pos_item_rate;
																		
																		$transaction_amtNew = $this->cheque_format($transaction_amt1); // 25/11/2020
																		$transaction_amt = str_replace( ',', '', $transaction_amtNew);
																	}
																	if($lp_type == 'BA')
																	{	
																		$grand_totalNew = $this->cheque_format($grand_total);
																		$grand_totalNew = str_replace( ',', '', $grand_totalNew);
																		$Purchase_amount=$Pos_item_qty * $Pos_item_rate;
																		
																		// $transaction_amt = $grand_total;
																		 // $transaction_amt = (($grand_total * $Purchase_amount ) / $subtotal); // 25/11/2020
																		$transaction_amt = (($grand_totalNew * $Purchase_amount ) / $subtotal);
																	}
																	
																//********* 10-7-2020- nilesh ****channel and payment ***************
																	if($Trans_Channel_flag==1)
																	{
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1 && $Trans_Channel_id == $Trans_Channel )
																		{
																			for($i=0;$i<=count($value)-1;$i++)
																			{
																				if($i<count($value)-1 && $value[$i+1] != "")
																				{
																					if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																					{
																						$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;
																						$gained_points_fag = 1;
																						$points_array[] = $loyalty_points;
																					}
																				}
																				else if($transaction_amt > $value[$i])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$gained_points_fag = 1;
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;					
																					$points_array[] = $loyalty_points;
																				}
																			}
																		}
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Trans_Channel_id == $Trans_Channel )
																		{
																			$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																			$points_array[] = $loyalty_points;
																			$gained_points_fag = 1;
																			$trans_lp_id = $LoyaltyID_array[0];
																			$Applied_loyalty_id[]=$trans_lp_id;
																		}						
																	// unset($dis);
																	}	
																	if($Trans_Payment_flag == 1)
																	{
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1 && $Lp_Payment_Type_id == $Payment_type_id )
																		{
																			for($i=0;$i<=count($value)-1;$i++)
																			{
																				if($i<count($value)-1 && $value[$i+1] != "")
																				{
																					if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																					{
																						$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;
																						$gained_points_fag = 1;
																						$points_array[] = $loyalty_points;
																					}
																				}
																				else if($transaction_amt > $value[$i])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$gained_points_fag = 1;
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;					
																					$points_array[] = $loyalty_points;
																				}
																			}
																		}
																		
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Lp_Payment_Type_id == $Payment_type_id)
																		{
																			$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																			$points_array[] = $loyalty_points;
																			$gained_points_fag = 1;
																			$trans_lp_id = $LoyaltyID_array[0];
																			$Applied_loyalty_id[]=$trans_lp_id;
																		}	
																	}
																//********* 10-7-2020- nilesh ****channel and payment ***************
																	if($Category_flag==1)
																	{
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1 && $Merchandize_category_id == $Category_id )
																		{
																			for($i=0;$i<=count($value)-1;$i++)
																			{
																				if($i<count($value)-1 && $value[$i+1] != "")
																				{
																					if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																					{
																						$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;
																						$gained_points_fag = 1;
																						$points_array[] = $loyalty_points;
																					}
																				}
																				else if($transaction_amt > $value[$i])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$gained_points_fag = 1;
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;					
																					$points_array[] = $loyalty_points;
																				}
																			}
																		}
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Merchandize_category_id == $Category_id )
																		{
																			$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																			$points_array[] = $loyalty_points;
																			$gained_points_fag = 1;
																			$trans_lp_id = $LoyaltyID_array[0];
																			$Applied_loyalty_id[]=$trans_lp_id;
																		}						
																	// unset($dis);
																	}
																	else if($Segment_flag==1)
																	{											
																		$Get_segments2 = $this->Pos_model->edit_segment_id($Company_id,$Segment_id);
																		
																		$Customer_array=array();
																		$Applicable_array[]=0;
																		unset($Applicable_array);
																		
																		foreach($Get_segments2 as $Get_segments)
																		{
																			if($Get_segments->Segment_type_id==1)  // 	Age 
																			{
																				$lv_Cust_value=date_diff(date_create($Date_of_birth), date_create('today'))->y;
																			}												
																			if($Get_segments->Segment_type_id==2)//Sex
																			{
																				$lv_Cust_value=$Sex;
																			}
																			if($Get_segments->Segment_type_id==3)//Country
																			{
																				$lv_Cust_value = $Country_name;
																				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																				{
																					$Get_segments->Value=$lv_Cust_value;
																				}
																			}
																			if($Get_segments->Segment_type_id==4)//District
																			{
																				$lv_Cust_value=$District;
																				
																				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																				{
																					$Get_segments->Value=$lv_Cust_value;
																				}
																			}
																			if($Get_segments->Segment_type_id==5)//State
																			{
																				$lv_Cust_value=$State_name;	
																				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																				{
																					$Get_segments->Value=$lv_Cust_value;
																				}
																			}
																			if($Get_segments->Segment_type_id==6)//city
																			{
																				$lv_Cust_value=$City_name;
																				
																				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
																				{
																					$Get_segments->Value=$lv_Cust_value;
																				}
																			}
																			if($Get_segments->Segment_type_id==7)//Zipcode
																			{
																				$lv_Cust_value=$Zipcode;
																				
																			}
																			if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
																			{
																				$lv_Cust_value=$total_purchase;	
																			}
																			if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
																			{
																				$lv_Cust_value=$Total_reddems;
																			}
																			if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
																			{
																				$start_date=$joined_date;
																				$end_date=date("Y-m-d");
																				$transaction_type_id=2;
																				$Tier_id=$lp_Tier_id;
																				
																				$Trans_Records = $this->Shipping_model->get_cust_trans_summary_all($Company_id,$Customer_enroll_id,$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
																				foreach($Trans_Records as $Trans_Records)
																				{
																					$lv_Cust_value=$Trans_Records->Total_Gained_Points;
																				}											
																			}
																			if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
																			{
																				$start_date=$joined_date;
																				$end_date=date("Y-m-d");
																				$transaction_type_id=2;
																				$Tier_id=$lp_Tier_id;
																				
																				$Trans_Records = $this->Shipping_model->get_cust_trans_details($Company_id,$start_date,$end_date,$Customer_enroll_id,$transaction_type_id,$Tier_id,'','');
																				foreach($Trans_Records as $Trans_Records)
																				{
																					$lv_Max_amt[]=$Trans_Records->Purchase_amount;
																				}
																				$lv_Cust_value=max($lv_Max_amt);				
																			}
																			if($Get_segments->Segment_type_id==12)//Membership Tenor
																			{
																				$tUnixTime = time();
																				list($year,$month, $day) = EXPLODE('-', $joined_date);
																				$timeStamp = mktime(0, 0, 0, $month, $day, $year);
																				$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
																			}
																			
																			$Get_segments = $this->Pos_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
																			
																			$Applicable_array[]=$Get_segments;
																			
																		}
																		// print_r($Applicable_array);
																		
																		if(!in_array(0, $Applicable_array, true))
																		{
																			$Customer_array[]=$Customer_enroll_id;
																			
																			if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
																			{
																				for($i=0;$i<=count($value)-1;$i++)
																				{
																					if($i<count($value)-1 && $value[$i+1] != "")
																					{
																						if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																						{
																							$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																							$trans_lp_id = $LoyaltyID_array[$i];
																							$Applied_loyalty_id[]=$trans_lp_id;
																							$gained_points_fag = 1;
																							$points_array[] = $loyalty_points;
																						}
																					}
																					else if($transaction_amt > $value[$i])
																					{
																						$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																						$gained_points_fag = 1;
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;					
																						$points_array[] = $loyalty_points;
																					}
																				}
																			}									
																			if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
																			{	
																				$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																				$points_array[] = $loyalty_points;
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[0];
																				$Applied_loyalty_id[]=$trans_lp_id;	
																			}
																		} 
																	}
																	else
																	{
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1  && $Trans_Channel == 0 && $Lp_Payment_Type_id == 0)
																		{
																			for($i=0;$i<=count($value)-1;$i++)
																			{
																				if($i<count($value)-1 && $value[$i+1] != "")
																				{
																					if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
																					{
																						$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;
																						$gained_points_fag = 1;
																						$points_array[] = $loyalty_points;
																					}
																				}
																				else if($transaction_amt > $value[$i])
																				{
																					$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[$i]);
																					$gained_points_fag = 1;
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;					
																					$points_array[] = $loyalty_points;
																				}
																			}
																		}

																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2  && $Trans_Channel == 0 && $Lp_Payment_Type_id == 0)
																		{
																			$loyalty_points = $this->Pos_model->get_discount($transaction_amt,$dis[0]);
																			$points_array[] = $loyalty_points;
																			$gained_points_fag = 1;
																			$trans_lp_id = $LoyaltyID_array[0];
																			$Applied_loyalty_id[]=$trans_lp_id;
																		}
																	}
																}
																if(count($Applied_loyalty_id) == 0)
																{
																	$trans_lp_id=0;
																}											
															}
															if($gained_points_fag == 1)
															{
																$total_loyalty_points = array_sum($points_array);	
															
																$Email_points[]=$total_loyalty_points;
															}
															else
															{
																$total_loyalty_points = 0;
															}
														}
														else
														{
														/******************Get Supper Seller Details*********************/
															$Super_seller_flag = 1;
															$result = $this->Pos_model->Get_Seller($Super_seller_flag,$Company_id);				   
															$seller_id = $result->Enrollement_id;
															$seller_fname = $result->First_name;
															$seller_lname = $result->Last_name;
															$seller_name = $seller_fname .' '. $seller_lname;
															$Seller_Redemptionratio = $result->Seller_Redemptionratio;
															$Purchase_Bill_no = $result->Purchase_Bill_no;

															$tp_db = $Purchase_Bill_no;
															$len = strlen($tp_db);
															$str = substr($tp_db,0,5);
															$bill = substr($tp_db,5,$len);
														/******************Get Supper Seller Details*********************/
															$total_loyalty_points=0;
															$Email_points[]=$total_loyalty_points;
														}
														
														// $total_loyalty_points=round($total_loyalty_points + $Extra_earn_points);
														$total_loyalty_points=$total_loyalty_points + $Extra_earn_points;
													
														$Voucher_status = 20; //'collected'
														$item_total_amount = $Pos_item_qty * $Pos_item_rate;
														// $Weighted_loyalty_points = round(($total_loyalty_points * $item_total_amount) / $subtotal);
														if($sellerID!=0)
														{
															// $Weighted_loyalty_points = round($total_loyalty_points);
															$Weighted_loyalty_points = $total_loyalty_points;
														}
														else
														{
															$Weighted_loyalty_points = $Extra_earn_points; //	sandeep 
														}
														$Weighted_redeem_points1 = ($Cust_redeem_point * $item_total_amount) / $subtotal;
														
														$Weighted_points_amount1 = ($Pos_points_amount * $item_total_amount) / $subtotal;
														
														$Weighted_redeem_points = round(($Cust_redeem_point * $item_total_amount) / $subtotal);
														
														$Weighted_points_amount = round(($Pos_points_amount * $item_total_amount) / $subtotal);
														
														$Weighted_discount_amount = round(($Pos_discount_amount * $item_total_amount) / $subtotal);
													//***********18-04-2020-allow to redeem 1 point extra****************/
														$Weighted_discount_amount1 = ($Pos_discount_amount * $item_total_amount) / $subtotal;
													//***********18-04-2020-allow to redeem 1 point extra****************/	
														$Purchase_amount=$Pos_item_qty * $Pos_item_rate;
														
														$Balance_to_pay = (($grand_total * $Purchase_amount ) / $subtotal);
															
														$Total_Weighted_avg_shipping_cost[]=0;
														$Weighted_avg_shipping_cost="-";
														
														$Shipping_cost=0;
														$Weighted_avg_shipping_cost=0;
												
														$RedeemAmt=$Weighted_redeem_points/$Company_Redemptionratio;
														$RedeemAmt1=$Weighted_redeem_points1/$Company_Redemptionratio;
														
														// $PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt-$Weighted_discount_amount;
														
														$PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$Weighted_points_amount-$Weighted_discount_amount;
														
													//***********18-04-2020-allow to redeem 1 point extra****************/
														// $PaidAmount1=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt1-$Weighted_discount_amount;
														
														// $PaidAmount1=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt1-$Weighted_discount_amount1;
														
														$PaidAmount1=$Purchase_amount+$Weighted_avg_shipping_cost-$Weighted_points_amount1-$Weighted_discount_amount1;
													
														$Weighted_Redeem_amount=(($Purchase_amount/$Pos_bill_amount)*$EquiRedeem);
														if($PaidAmount1 <= 0)
														{
															$PaidAmount1 = 0;
														}
													//***********18-04-2020-allow to redeem 1 point extra****************/
														$Trans_type = 29; //3rd party api 
														if($Pos_Order_Type == 3)  // Delivery
														{
															$Delivery_method1 = 29;  
														}
														else if($Pos_Order_Type == 2) // Take Away
														{	
															$Delivery_method1 = 28; 
														}
														else 
														{
															$Delivery_method1 = 107; // In-Store
														}
														
														$Total_discount1 = 	$Pos_loyalty_discount + $Pos_voucher_amount;
														
														$data123 = array('Company_id' => $Company_id,
																			'Trans_type' => $Trans_type,
																			'Purchase_amount' => $Purchase_amount, 
																			'Paid_amount' => $PaidAmount1,
																			'Mpesa_Paid_Amount' => 0.00,
																			// 'COD_Amount' => $PaidAmount1,
																			'Mpesa_TransID' => 0,
																			'Redeem_points' => $Weighted_redeem_points1,
																			'Redeem_amount' => $Weighted_Redeem_amount,
																			'Payment_type_id' => $Payment_type_id,
																			'Remarks' => $Remarks,
																			'Trans_date' => $lv_date_time,
																			'balance_to_pay' => $PaidAmount1,
																			'Shipping_cost' => $Weighted_avg_shipping_cost,
																			'Shipping_points' => ($Weighted_avg_shipping_cost*$Company_Redemptionratio),
																			'Enrollement_id' => $cust_enrollment_id,
																			'Bill_no' => $bill,
																			'Manual_billno' => $Pos_bill_no,
																			'Order_no' => $Pos_Order_No,
																			'Voucher_no' => $Pos_voucher_no,
																			'Card_id' => $CardId,
																			'Seller' => $Pos_outlet_id1,
																			'Channel_id' => $ChannelCompanyId,
																			'Seller_name' => $Pos_outlet_name,
																			'Item_code' => $Company_merchandize_item_code, 
																			'Voucher_status' => $Voucher_status,
																			'Delivery_method' => $Delivery_method1, 
																			'Merchandize_Partner_id' => $Merchandize_partner_id,
																			'Merchandize_Partner_branch' => $Item_branch_code,
																			'Quantity' => $Pos_item_qty,
																			'Loyalty_pts' => $Weighted_loyalty_points, 
																			'Online_payment_method' => $Online_payment_method1,
																			'Cost_payable_partner' => $Item_cost_price,
																			'Bill_discount' => $Pos_loyalty_discount,
																			// 'Item_category_discount' => $thisItemDiscount,
																			'Total_discount' => $Total_discount1,
																			'Voucher_discount' => $Pos_voucher_amount,
																			// 'Pos_discount' => $Pos_discount,
																			'Credit_Cheque_number' => $Tender_Reference
																		);	
																	

																$Transaction_detail = $this->Pos_model->Insert_online_purchase_transaction($data123);
														
														if($Transaction_detail)
														{
														/******Insert online purchase log tbl entery*******/	
															$Company_id	= $Company_id;
															$Todays_date = date('Y-m-d');	
															$opration = 1;		
															$enroll	= $cust_enrollment_id;
															$username = $User_email_id;
															$userid=1;
															$what="3rd Party Transaction";
															$where="3rd Party API";
															$To_enrollid =$cust_enrollment_id;
															$firstName =$fname;
															$lastName =$lname; 
															$Seller_name =$fname.' '.$lname;
															$opval = $Merchandize_item_name.', (Item Code = '.$Company_merchandize_item_code.', Quantity= '.$Pos_item_qty.' )';
															$result_log_table = $this->Merchant_api_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
														/***Insert online purchase log tbl entery******/
														}
														
														$loyalty_prog = $this->Pos_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
														$lp_count = count($loyalty_prog);

														if(count($Applied_loyalty_id) != 0)
														{		
															for($l=0;$l<count($Applied_loyalty_id);$l++)
															{
																$Get_loyalty = $this->Pos_model->Get_loyalty_details_for_online_purchase($Applied_loyalty_id[$l]);

																foreach($Get_loyalty as $rec)
																{
																	$Loyalty_at_transaction = $rec['Loyalty_at_transaction'];
																	$lp_type=substr($rec['Loyalty_name'],0,2);	
																	$discount = $rec['discount'];

																	if($lp_type == 'PA')
																	{		
																		if($Loyalty_at_transaction != 0.00)
																		{
																			$Calc_rewards_points=(($Purchase_amount*$Loyalty_at_transaction)/100);
																		}
																		else
																		{
																			$Calc_rewards_points=(($Purchase_amount*$discount)/100);
																		}
																	}

																	if($lp_type == 'BA')
																	{	
																		if($Loyalty_at_transaction != 0.00)
																		{
																			$Calc_rewards_points=(($Balance_to_pay*$Loyalty_at_transaction)/100);
																		}
																		else
																		{
																			$Calc_rewards_points=(($Purchase_amount*$discount)/100);
																		}
																	}
																}
																
															   $child_data = array(					
																				'Company_id' => $Company_id,        
																				'Transaction_date' => $lv_date_time,       
																				'Seller' => $Pos_outlet_id1,
																				'Enrollement_id' => $cust_enrollment_id,
																				'Transaction_id' => $Transaction_detail,
																				// 'Loyalty_id' => $trans_lp_id,
																				'Loyalty_id' => $Applied_loyalty_id[$l],
																				// 'Reward_points' => round($Calc_rewards_points)
																				'Reward_points' => $Calc_rewards_points
																				);
																$child_result = $this->Pos_model->insert_loyalty_transaction_child($child_data);
															}
														}
														$Order_date = date('Y-m-d');						
												}
												$Extra_earn_points = array_sum($Extra_earn_points_Loyalty_pts);
												$total_loyalty_email=(array_sum($Email_points)+ $Extra_earn_points);	
												
												// $total_loyalty_email = floor($total_loyalty_email); // 28-11-2020
												$total_loyalty_email = round($total_loyalty_email);
											}
											$redeemed_discount_voucher = $Pos_voucher_no; 
									
											if($redeemed_discount_voucher != Null)
											{
												$giftData1["Card_balance"] = 0;
												$giftData1["Update_user_id"] = $Pos_outlet_id1;
												$giftData1["Update_date"] = date('Y-m-d H:i:s');

												$this->db->where(array("Gift_card_id"=>$redeemed_discount_voucher,"Company_id"=>$Company_id,"Card_id"=>$CardId));
												$this->db->update("igain_giftcard_tbl",$giftData1);	
												
												$Voucher_array[] = $redeemed_discount_voucher;
											}
											/**************new logic with pos items*****************/
											/************* Update Current Balance ******************/
												$cid = $CardId;							
												$redeem_point = $Cust_redeem_point;	
												$Update_Current_balance = ($bal - $redeem_point + $total_loyalty_email);
												
												$Update_total_purchase = $total_purchase + $subtotal;
												$Update_total_reddems = $Total_reddems + $Cust_redeem_point;
												$up = array('Current_balance' => $Update_Current_balance, 'total_purchase' => $Update_total_purchase, 'Total_reddems' => $Update_total_reddems);
													
												$this->Pos_model->update_cust_balance($up,$cid,$Company_id);	
												
												$bill_no = $bill + 1;
												$billno_withyear = $str.$bill_no;
												$result4 = $this->Pos_model->update_billno($seller_id,$billno_withyear);
											/*********** Update Current Balance ***************/
											
											$lvp_date_time = date("Y-m-d H:i:s");    
											
											$Email_content = array
											(
												// 'Notification_type' => 'Thank you for your Online Purchase on '.$Pos_outlet_name,
												'Notification_type' => 'Online Purchase',
												'Transaction_date' => $lvp_date_time,
												// 'Orderno' => $bill,
												'Orderno' => $Pos_Order_No,
												'Pos_billno' => $Pos_bill_no,
												'Voucher_array' => $Voucher_array, 
												'Voucher_status' => $Voucher_status, 
												'Cust_wish_redeem_point' => round($Cust_redeem_point), 
												'EquiRedeem' =>  round($EquiRedeem, 2),
												'subtotal' => $subtotal, 
												'grand_total' => round($grand_total, 2), 
												'total_loyalty_points' => $total_loyalty_email, 
												'Update_Current_balance' => $Update_Current_balance, 
												'Blocked_points' => $Blocked_points, 
												'Standard_charges' => 0, 
												'Shipping_charges_flag' => $Shipping_charges_flag,
												'Symbol_of_currency' => $Symbol_currency, 
												'Delivery_type' => $Pos_Order_Type,  
												'DeliveryOutlet' => $Pos_outlet_id1, 
												'Outlet_address' => $Outlet_address, 
												'Bill_items' => $Pos_bill_items,  
												'DiscountAmt' => $Pos_discount_amount,
												'VoucherDiscountAmt' => $Pos_voucher_amount,   
												'Template_type' => '3rd_Party_Purchase_order' 
											);	
											
										$Notification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,'0',$Company_id); 
										
										// $Discount_codes = $this->session->userdata('Discount_codes'); //print_r($Discount_codes);
										
										$DiscountResultVal = $this->Merchant_api_model->get_payment_type_discount_value($Payment_type_id,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,$grand_total);
										
										
										if($DiscountResultVal != Null) {
										foreach($DiscountResultVal as $f)
										{
											$Discount_codes[] = $f;
										} }
										
										if($Discount_codes != null)
										{
											foreach($Discount_codes as $y)
											{
												//	echo "Discount_voucher_code--".$y['Discount_voucher_code']; continue;
												if($y['Discount_voucher_code'] != "")
												{
													if($y['Discount_voucher_percentage'] > 0)
													{
														$giftData["Card_balance"] = $y['Discount_voucher_percentage'];
														$giftData["Discount_percentage"] = $y['Discount_voucher_percentage'];
													}
													else if($y['Discount_voucher_amt'] > 0)
													{
														$giftData["Card_balance"] = $y['Discount_voucher_amt'];
														$giftData["Card_value"] = $y['Discount_voucher_amt'];
														$giftData["Discount_percentage"] = 0.00;
													}
													$giftData["Company_id"] = $Company_id;
													$giftData["Gift_card_id"] = $y['Discount_voucher_code'];
													// $giftData["Card_balance"] = $y['Discount_voucher_amt'];
													$giftData["Card_id"] = $CardId;
													$giftData["User_name"] = $fname.' '.$lname;
													$giftData["Email"] = $User_email_id;
													$giftData["Phone_no"] = $phno;
													$giftData["Payment_Type_id"] = 99;
													$giftData["Seller_id"] = $Pos_outlet_id1;
													$giftData["Valid_till"] = date("Y-m-d",strtotime($y['Discount_voucher_validity']));
													// $giftData["Card_value"] = $y['Discount_voucher_amt'];
													
													$this->db->insert("igain_giftcard_tbl",$giftData);	
												
												//**************sandeep discount voucher 30-01-2020****************
													$Email_content = array
														( 
															// 'Notification_type' => 'Thank you for your Purchase on '.$Pos_outlet_name,
															'Notification_type' => 'Discount Voucher',
															'Transaction_date' => $lvp_date_time,
															'Symbol_of_currency' => $Symbol_currency,
															'Orderno' => $bill,	
															'Outlet_address' => $Outlet_address,
															'CustEmail' => $User_email_id,
															'Voucher_no' => $y['Discount_voucher_code'],
															'Reward_amt' => $y['Discount_voucher_amt'],
															'Reward_percent' => $giftData["Discount_percentage"],
															'Voucher_validity' => date("Y-m-d",strtotime($y['Discount_voucher_validity'])),
															'Outlet_name' => $Pos_outlet_name,
															'Template_type' => 'Discount_voucher'
														); 
														
												$GiftNotification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,'0',$Company_id);
												}
											//**************sandeep discount voucher 30-01-2020*****************
											}
										}
											
										$insert_transaction_id = 1 ;
										if($insert_transaction_id > 0)
										{  
											$Updateed_Balance=$Update_Current_balance-($Blocked_points+$Debit_points);	
										
											if($Updateed_Balance<0)
											{
												$Available_Balance=0; 
											}
											else
											{
												$Available_Balance=$Updateed_Balance;
											}
										//***** 18-03-2020 ************
											$_SESSION['DiscountAmt'] = "";
											$_SESSION['BillDiscount'] = "";
											$_SESSION['ItemDiscounts'] = "";
											
										//***** 18-03-2020 ************
										$Pos_discount_amount = $Pos_discount_amount - $Pos_discount;
											$Result123 = array(
														"Error_flag" => 1001,
														"Membership_id" => $CardId,
														"Member_name" => $Memeber_name,
														"Order_No" => $Pos_Order_No,
														"Order_Status" => $Pos_Order_Status,
														"Order_Total" => number_format($subtotal,2),
														"Order_Date_Time" => $lv_date_time,
														"Bill_No" => $Pos_bill_no,
														"Trans_Type" => $Pos_Trans_Type,
														"Outlet_No" => $Pos_outlet_id2,
														"Outlet_Name" => $Pos_outlet_name
														/* "POS_discount" => number_format($Pos_discount,2),
														"Discount_amount" => number_format($Pos_discount_amount,2),
														"Points_amount" => number_format($EquiRedeem,2),
														"Balance_due" => number_format($grand_total,2),
														"Gained_points" => $total_loyalty_email,
														"Current_balance" => round($Available_Balance) */
														// 'Discount_details' => $Discount_codes  //discount voucher recived
													);
													
												echo json_encode($Result123); // Transaction done Successfully.
												exit;
										}
										else    
										{
											$Result124 = array(
														"Error_flag" => 2068,
														"Message" => "Transaction Failed"
													);
													
												echo json_encode($Result124);  // Transaction Failed
												exit;
										}
									}
									else
									{
										$Result3100 = array(
														"Error_flag" => 2009,
														"Message" => "Invalid outlet no"
													);
													
										echo json_encode($Result3100); //Invalid outlet no
										exit;
									}
								}
								else
								{
									$Result127 = array(
														"Error_flag" => 2003,
														"Message" => "Invalid or unable to locate membership id"
													);
													
									echo json_encode($Result127); //Unable to Locate membership id
									exit;
								}
							}
							else
							{
								$Result3107 = array("Error_flag" => 3107,
												"Message"=>"Invalid Channel password Or Channel not exist"
												);
								echo json_encode($Result3107);  // Invalid input
								exit;
							}
						}
						else
						{
							$Result9999 = array("Error_flag" => 404,
												"Message"=>"Invalid input"
												);
							echo json_encode($Result9999);  // Invalid input
							exit;
						}
					}
				/**********************3rd Party Loyalty API-Nilesh start22-07-2020********************/
				/********************Nilesh-API Satrt for prestashop-Nilesh******************/
				/****************************Prestashop purchase api*********************************/ 
					if($API_flag == 7)
					{ 
						$gained_points_fag = 0;
						$Promo_redeem_by =0;
						$Gift_redeem_by =0;
						// $cardId = $_REQUEST["Membership_id"];
						$Customer_email = $_REQUEST["Customer_email"];
						
						// $dial_code = $this->Igain_model->get_dial_code($Country_id);//Get Country Dial 
						
						$cust_details = $this->Merchant_api_model->cust_details_from_email($Company_id,$Customer_email);//Get Customer details
						
						if($cust_details !=NULL)
						{
							foreach($cust_details as $row25)
							{
								$Customer_enroll_id=$row25['Enrollement_id'];
								$CardId=$row25['Card_id'];
								$fname=$row25['First_name'];
								$midlename=$row25['Middle_name'];
								$lname=$row25['Last_name'];
								$bdate=$row25['Date_of_birth'];
								$address=$row25['Current_address'];
								$bal=$row25['Current_balance'];
								$Blocked_points=$row25['Blocked_points'];
								$total_purchase=$row25['total_purchase'];
								$Total_reddems=$row25['Total_reddems'];
								$phno=$row25['Phone_no'];
								$pinno=$row25['pinno'];
								$companyid=$row25['Company_id'];
								$cust_enrollment_id=$row25['Enrollement_id'];
								$image_path=$row25['Photograph'];				
								$filename_get1=$image_path;	
								$Tier_name = $row25['Tier_name'];
								$lv_member_Tier_id = $row25['Tier_id'];
								
							}
							$Current_balance = $bal;
							
							
							// $Merchant_email_id = $_REQUEST["Merchant_email_id"];
							
							$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
							
							$Merchant_email_id=$Super_Seller_details->User_email_id;
							
							$result = $this->Merchant_api_model->Get_Seller($Merchant_email_id,$Company_id); //Get Merchant Details
							if($result!=NULL)
							{
								$seller_id = $result->Enrollement_id;
								$seller_fname = $result->First_name;
								$seller_lname = $result->Last_name;
								$seller_name = $seller_fname .' '. $seller_lname;
								$Seller_Redemptionratio = $result->Seller_Redemptionratio;
								$Purchase_Bill_no = $result->Purchase_Bill_no;
							
				   
									$tp_db = $Purchase_Bill_no;
									$len = strlen($tp_db);
									$str = substr($tp_db,0,5);
									$bill = substr($tp_db,5,$len);
					   
									$date = new DateTime();
									$lv_date_time=$date->format('Y-m-d H:i:s'); 
						  
									$lv_date_time2 = $date->format('Y-m-d'); 
						
									$Trans_type = 2;
									$Payment_type_id = 1;
									$Remarks = "POS_API_Loyalty Transaction";
					
									/*** Get Loyalty Rule ****/
									$loyalty_prog = $this->Merchant_api_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
									// var_dump($loyalty_prog);
								
									$points_array = array();
									if($loyalty_prog != NULL )
									{
										foreach($loyalty_prog as $prog)
										{
											$member_Tier_id = $lv_member_Tier_id;
											
											$value = array();
											$dis = array();
											
											$LoyaltyID_array = array();
											$Loyalty_at_flag = 0;	
											$lp_type=substr($prog['Loyalty_name'],0,2);											
												
											$Todays_date = $lv_date_time;
											
											$lp_details = $this->Merchant_api_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);	
										
										
											$lp_count = count($lp_details);
											// if($lp_details != NULL)
											// {

											foreach($lp_details as $lp_data)
											{
												$LoyaltyID = $lp_data['Loyalty_id'];
												$lp_name = $lp_data['Loyalty_name'];
												$lp_From_date = $lp_data['From_date'];
												$lp_Till_date = $lp_data['Till_date'];
												$Loyalty_at_value = $lp_data['Loyalty_at_value'];
												$Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
												$discount = $lp_data['discount'];
												$lp_Tier_id = $lp_data['Tier_id'];
												
												 // echo 'loyalty_id----'.$LoyaltyID;
												 // die;
												if($lp_Tier_id == 0)
												{
													$member_Tier_id = $lp_Tier_id;
												}
												
												if($Loyalty_at_value > 0)
												{
													$value[] = $Loyalty_at_value;	
													$dis[] = $discount;
													$LoyaltyID_array[] = $LoyaltyID;
													
													$Loyalty_at_flag = 1;
												}
												
												if($Loyalty_at_transaction > 0)
												{
													$value[] = $Loyalty_at_transaction;	
													$dis[] = $Loyalty_at_transaction;
													$LoyaltyID_array[] = $LoyaltyID;
													
													$Loyalty_at_flag = 2;
												}
											}
											if($lp_type == 'PA')
											{
												$transaction_amt = $_REQUEST["Purchase_amount"];
											}
											
											if($lp_type == 'BA')
											{
												$transaction_amt = $_REQUEST["Balance_to_pay"];
											}
									
											if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
											{
												
												for($i=0;$i<=count($value)-1;$i++)
												{
												   // echo "...i $i....".$value[$i];
												   // echo "...$i ....".$value[$i+1];
												   // die;
												   
													if($i<count($value)-1 && $value[$i+1] != "")
													{
														if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
														{
															$loyalty_points = $this->Merchant_api_model->get_discount($transaction_amt,$dis[$i]);
															
															$trans_lp_id = $LoyaltyID_array[$i];
															
															$gained_points_fag = 1;
															

															$points_array[] = $loyalty_points;
															
															if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
															{
																
																$child_data = array(					
																'Company_id' => $Company_id,        
																'Transaction_date' => $lv_date_time,       
																'Seller' => $seller_id,
																'Enrollement_id' => $cust_enrollment_id,
																'Transaction_id' => 0,
																'Loyalty_id' => $trans_lp_id, 
																//'Loyalty_id' => 0,
																'Reward_points' => $loyalty_points,
																);
																
																$child_result = $this->Merchant_api_model->insert_loyalty_transaction_child($child_data);
															}
														}
													}
													else if($transaction_amt > $value[$i])
													{
													
														$loyalty_points = $this->Merchant_api_model->get_discount($transaction_amt,$dis[$i]);
															
														$gained_points_fag = 1;
														
														$trans_lp_id = $LoyaltyID_array[$i];
														
														$points_array[] = $loyalty_points;
														
														if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
															{
																
																$child_data = array(					
																'Company_id' => $Company_id,        
																'Transaction_date' => $lv_date_time,       
																'Seller' => $seller_id,
																'Enrollement_id' => $cust_enrollment_id,
																'Transaction_id' => 0,
																'Loyalty_id' => $trans_lp_id, 
																'Reward_points' => $loyalty_points,
																);
																
																$child_result = $this->Merchant_api_model->insert_loyalty_transaction_child($child_data);
															}
													}
												}
											}
											if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
											{	
												$loyalty_points = $this->Merchant_api_model->get_discount($transaction_amt,$dis[0]);
													
												$points_array[] = $loyalty_points;
												
												$gained_points_fag = 1;
												
												$trans_lp_id = $LoyaltyID_array[0];
												
												if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
												{
													
													$child_data = array(					
													'Company_id' => $Company_id,        
													'Transaction_date' => $lv_date_time,       
													'Seller' => $seller_id,
													'Enrollement_id' => $cust_enrollment_id,
													'Transaction_id' => 0,
													'Loyalty_id' => $trans_lp_id, 
													'Reward_points' => $loyalty_points,
													);
											
													$child_result = $this->Merchant_api_model->insert_loyalty_transaction_child($child_data);
												}
											}
											
										}
									}
								if($gained_points_fag == 1)
								{
									$total_loyalty_points = array_sum($points_array);
								}
								else
								{
									$total_loyalty_points = 0;
									$trans_lp_id = 0;
								}
									// $Promo_redeem_by = $_REQUEST['Promo_redeem_by'];
									
									if($Promo_redeem_by == 1) //******** Promo Code Redeem *********/
									{
										$PromoCode = $_REQUEST['Promo_code'];
										$PointsRedeem = $_REQUEST['promo_points_redeemed'];
										
										$promo_transaction_data = array(
										
										'Trans_type' => '7',
										'Topup_amount' => $PointsRedeem,
										'Company_id' => $Company_id,
										'Trans_date' => $lv_date_time,  
										'Bill_no' => $bill,  
										'Manual_billno' => $bill,  
										'remark2' => 'PromoCode Transaction-('.$PromoCode.')',
										'Card_id' => $CardId,
										'Seller_name' => $seller_name,
										// 'Seller' => $seller_id,
										'Seller' =>$seller_id,
										'Remarks' => $Remarks,
										'Enrollement_id' => $Customer_enroll_id
										);
										
										$insert_promo_transaction_id = $this->Transactions_model->insert_loyalty_transaction($promo_transaction_data);
										
										$post_data21 = array('Promo_code_status' =>'1');
										
										$update_promo_code = $this->Transactions_model->utilize_promo_code($Company_id,$PromoCode,$post_data21);
										
										// $TotalRedeemPoints = $TotalRedeemPoints + $PointsRedeem;
										
										$bill = $bill + 1;
									}
									//$Customer_enroll_id = $this->input->post('Enrollement_id');
									// $Gift_redeem_by = $_REQUEST["Gift_redeem_by"];
									if($Gift_redeem_by == 1) //******** Gift Card Redeem *********/
									{  

										$gift_reedem = $_REQUEST['gift_reedem'];
										
										$GiftCardNo = $_REQUEST['GiftCardNo'];
										$GiftBal = $_REQUEST['Balance'];
										$current_gift_balance = $GiftBal - $gift_reedem;
										
										
										$gift_transaction_data = array(
										
										'Trans_type' => '4',
										'Purchase_amount' => $gift_reedem,
										'Redeem_points' => $gift_reedem,
										'Company_id' => $Company_id,
										'Trans_date' => $lv_date_time,  
										'Payment_type_id' => '1',
										'Card_id' => $CardId,
										'GiftCardNo' => $_REQUEST['GiftCardNo'],
										'Bill_no' => $bill,  
										'Manual_billno' => $bill,
										'Seller_name' => $seller_name,
										'Seller' => $seller_id,
										'Remarks' => $Remarks,
										'Enrollement_id' => $Customer_enroll_id
										);
										
										$insert_gift_transaction = $this->Transactions_model->insert_loyalty_transaction($gift_transaction_data);
										
										
										$result32 = $this->Transactions_model->update_giftcard_balance($GiftCardNo,$current_gift_balance,$Company_id);
									
										// $TotalRedeemPoints = $TotalRedeemPoints + $gift_reedem;
										
										$bill = $bill + 1;
									}
										$data = array('Company_id' => $Company_id,
										'Trans_type' => '2',
										'Payment_type_id' => $Payment_type_id,
										'Bill_no' => $bill,
										'Manual_billno' => $bill,  
										'Enrollement_id' => $cust_enrollment_id,
										'Card_id' => $CardId,
										'Seller' => $seller_id,
										'Seller_name' => $seller_name,
										'Trans_date' => $lv_date_time,
										'Remarks' => $Remarks,
										'Purchase_amount' => $_REQUEST["Purchase_amount"], 
										'Paid_amount' => $_REQUEST["Balance_to_pay"],
										'Redeem_points' => $_REQUEST["Redeem_points"],
										//'Loyalty_pts' => $loyalty_pts,
										'Loyalty_pts' => $total_loyalty_points,
										'Loyalty_id' => $trans_lp_id, 
										'balance_to_pay' => $_REQUEST["Balance_to_pay"]
									);
									
									$insert_transaction_id = $this->Merchant_api_model->purchase_transaction($data);
									
									$result11 = $this->Merchant_api_model->update_loyalty_transaction_child($Company_id,$lv_date_time,$seller_id,$cust_enrollment_id,$insert_transaction_id);
									
									/********* Update Current Balance *********/
										
									//$cid = $this->input->post('CardId');
									// $cid = $_REQUEST["Membership_id"];
									//$Current_balance = $this->input->post('Current_balance');
									//$redeem_point = $this->input->post('points_redeemed');
									$redeem_point = $_REQUEST["Redeem_points"];
									//$point_redeem = $Current_balance - $redeem_point + $loyalty_pts; 
									$new_total_purchase=$total_purchase + $_REQUEST["Purchase_amount"];
									$new_total_redeem_pts=$Total_reddems + $_REQUEST["Redeem_points"];
									
									
									$Update_Current_balance = round($Current_balance - $redeem_point + $total_loyalty_points);
									$up_data = array(
												'Current_balance' => $Update_Current_balance,
												'total_purchase' => $new_total_purchase,
												'Total_reddems' => $new_total_redeem_pts
												);
									$this->Merchant_api_model->update_transaction($up_data,$CardId,$Company_id);
									
									$bill_no = $bill + 1;
									$billno_withyear = $str.$bill_no;
									$result4 = $this->Transactions_model->update_billno($seller_id,$billno_withyear);
								
								$currency_details = $this->Igain_model->Get_Country_master($result->Country);
								$Symbol_currency = $currency_details->Symbol_of_currency;	
								
								if($insert_transaction_id > 0)
								{  
									$Notification_type ='Loyalty Transation';
									$Email_content = array(
											'Today_date' => $lv_date_time,
											'Purchase_amount' => $_REQUEST["Purchase_amount"],
											'Redeem_points' => $_REQUEST["Redeem_points"],
											'Payment_by' => 1,
											'Balance_to_pay' => $_REQUEST["Balance_to_pay"],
											'Total_loyalty_points' => $total_loyalty_points,
											'Symbol_currency' => $Symbol_currency,
											'GiftCardNo' => $_REQUEST['GiftCardNo'],
											'gift_reedem' => $_REQUEST['gift_reedem'],
											'Notification_type' => $Notification_type,
											'Template_type' => 'Pos_loyalty_transaction'
										);
									$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,$seller_id,$Company_id);
						
									//$transaction_flag = 1
									$Result123[] = array("Error_flag" => 1001, "Update_Current_balance" => $Update_Current_balance-$Blocked_points);
									$this->output->set_output(json_encode($Result123)); //Loyalty Transaction done Successfully
								}
								else    
								{
									$Result124[] = array("Error_flag" => 2068);  
									$this->output->set_output(json_encode($Result124)); // Loyalty Transaction Failed
									//$transaction_flag = 0;
								}
							}
							else
							{
								$Result3100[] = array("Error_flag" => 2009);
								$this->output->set_output(json_encode($Result3100)); //Unable to Locate Merchant Email id 
							}
						}
						else
						{
							$Result127[] = array("Error_flag" => 2003);
							$this->output->set_output(json_encode($Result127)); //Unable to Locate membership id
						}
					}

					/****************************prestashop purchase api******************************/
					/****************************Customer phone no Validate***************************/
					if($API_flag == 16)
					{
						$Phone_no = $_REQUEST['Phoneno'];	
						
						$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
						$Dial_Code = $this->Igain_model->get_dial_code11($Super_Seller_details->Country);
						$dialcode=$Dial_Code->phonecode;
						$phoneNo=$dialcode.''.$Phone_no;	
							
						$CheckPhone_number=$this->Igain_model->CheckPhone_number($phoneNo,$Company_id);
						if($CheckPhone_number ==0)
						{
							$Result1001 = array("Error_flag" => 1001);
							$this->output->set_output(json_encode($Result1001));
						}
						else
						{
							$Result2032 = array("Error_flag" => 2032);
							$this->output->set_output(json_encode($Result2032));
						}
					}
					/***********************Customer Phone no Validate*********************************/
					/*******************Fetch Member current Balance using EmailId********************/
					if($API_flag == 15)  //Fetch_Balance_info
					{	
						$Customer_email = $_REQUEST['Customer_email'];
						
						$cust_details = $this->Merchant_api_model->cust_details_from_email($Company_id,$Customer_email);//Get Customer details
						
						if($cust_details !=NULL)
						{
							foreach($cust_details as $row25)
							{
								$Customer_enroll_id=$row25['Enrollement_id'];
								$CardId=$row25['Card_id'];
								$Phone_no=$row25['Phone_no'];
								$bal=$row25['Current_balance'];
								$Blocked_points=$row25['Blocked_points'];	
								$Debit_points=$row25['Debit_points'];	
								$Current_bal =$bal-$Blocked_points;
							}
							$Current_bal1 = $bal-($Blocked_points+$Debit_points);
					
							if($Current_bal1<0)
							{
								$Current_bal1=0;
							}
							else
							{
								$Current_bal1=$Current_bal1;
							}
							
							// $Result1001 = array("Error_flag" => 1001, "Membership_id" =>$CardId, "Current_bal" =>$Current_bal, "Phone_no" => $Phone_no);
							$this->output->set_output(json_encode($Current_bal1));
						}
						else    
						{
							$Result127 = array("Error_flag" => 2003);
							$this->output->set_output(json_encode($Result127)); //Unable to Locate membership id
						}
					}
					/**************Fetch Member current  balance using EmailId*******************/				
					/***********************Fetch Member transaction details**********************/ 	
					if($API_flag == 12)  //Fetch Member transaction
					{	
						$Customer_email = App_string_encrypt($_REQUEST['Customer_email']);
						
						$cust_details = $this->Merchant_api_model->cust_details_from_email($Company_id,$Customer_email);//Fetch_Member_info
						
						if($cust_details !=NULL)
						{
							foreach($cust_details as $row25)
							{
								$Customer_enroll_id=$row25['Enrollement_id'];
								$CardId=$row25['Card_id'];
								$Phone_no=$row25['Phone_no'];
								$bal=$row25['Current_balance'];
								$Blocked_points=$row25['Blocked_points'];	
								$Current_bal =$bal-$Blocked_points;
							}
							
							// $Result1001 = array("Error_flag" => 1001, "Membership_id" =>$CardId, "Current_bal" =>$Current_bal, "Phone_no" => $Phone_no);
							// $this->output->set_output(json_encode($Result1001));
							
							$Trans_details = $this->Merchant_api_model->FetchTransactionDetails($Company_id,$Customer_enroll_id,$CardId);
							foreach ($Trans_details as $Trans)
							{
								$Trans_type= $Trans['Trans_type_id'];
								$Merchant_name= $Trans['Seller_name'];
								$Bill_no= $Trans['Bill_no'];
								$Purchase_amount= $Trans['Purchase_amount'];
								$Paid_amount= $Trans['Paid_amount'];
								$Loyalty_pts= $Trans['Loyalty_pts'];
								$Redeem_points= $Trans['Redeem_points'];
								$Bonus_points= $Trans['Topup_amount'];
								$Transfer_points= $Trans['Transfer_points'];
								$Quantity= $Trans['Quantity'];
								if($Merchant_name=="")
								{
									$Merchant_name='-';
								}
								if($Bill_no=="" || $Bill_no=="0")
								{
									$Bill_no='-';
								}
								// if($Purchase_amount=="0")
								// {
									// $Purchase_amount='-';
								// }
								if($Loyalty_pts=="0")
								{
									$Loyalty_pts='-';
								}
								if($Redeem_points=="0")
								{
									$Redeem_points='-';
								}
								if($Bonus_points=="0")
								{
									$Bonus_points='-';
								}
								if($Transfer_points=="0")
								{
									$Transfer_points='-';
								}
								$Used_point = $Redeem_points+$Transfer_points;
								
								if($Used_point==0)	
								{
									$Used_point="-";
								}
								$Gained_point = $Loyalty_pts+$Bonus_points;
								
								if($Gained_point==0)
								{
									$Gained_point="-";
								}
								
								if($Trans_type==1)
								{
									$Remark="Registration Bonus";
								}
								else if($Trans_type==2)
								{
									$Remark="On Purchase";
								}
								
								$LastTransaction_array[]=array
										(
											'TransactionDate' => date('d-M-y', strtotime($Trans['Trans_date'])),
											'Purchase_Amount' => $Purchase_amount,
											'Paid_amount' => number_format($Paid_amount,2),
											'Points_Used' => $Used_point,
											'Points_Gained' => $Gained_point,
											'Remark' => $Remark
										);
							}
							$Status_array = array("Error_flag" => "1001", "LastTransaction_array" => $LastTransaction_array);
							// echo json_encode($Status_array);
							echo json_encode($LastTransaction_array);
						}
						else    
						{
							$Result127 = array("Error_flag" => 2003);
							$this->output->set_output(json_encode($Result127)); //Unable to Locate membership id
						}
					}
 
					/***********************Fetch Member transaction details**********************/
					/**********************Point Valuation API - Prestashop ************************/
					if($API_flag == 9)
					{ 					
						$Current_balance = $_REQUEST['Current_balance'];
						$Purchase_amount = $_REQUEST['Purchase_amount'];
						$Redeem_points = $_REQUEST['Redeem_points'];
						
						$result1 = $this->Igain_model->Fetch_Super_Seller_details($Company_id); //Get admin redemption ratio
						if($result1!=NULL)
						{
							$Seller_Redemptionratio = $result1->Seller_Redemptionratio;
						
							if($Redeem_points <= $Current_balance)
							{
								$calculate = $this->Merchant_api_model->Cal_PointValuation($Redeem_points,$Seller_Redemptionratio,$Purchase_amount);
								
								if($calculate != NULL)
								{
									$calculate1=round($calculate);
									$this->output->set_output($calculate1);
								}
								else    
								{
									$Result21[] = array('Error_flag' => 6); // Invalid input provide
									$this->output->set_output(json_encode($Result21));
								}
							}
							else
							{ 
								// $Result12[] = array('Error_flag' => 3101); //Insufficient Point Balance
								$Result12=3101;
								$this->output->set_output(	($Result12));
							}
						}
						else
						{
							$Result3100[] = array("Error_flag" => 2009);
							$this->output->set_output(json_encode($Result3100));
						}
					}
					/********************Point Valuation API- prestashop ****************************/
					/********************AMIT KAMBLE POS Item Creation API****************************/
					if($API_flag == 88)//
					{ 					
						 	
							$Partner_id=0;
							
							$Delete_pos_api_err = $this->Merchant_api_model->delete_pos_api_error($Company_id);
							/*
							$SuperSeller=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
							if($SuperSeller != NULL )	
							{
								$Seller_id=$SuperSeller->Enrollement_id;
							}*/
							
							
							
							$Seller_id = $getHeaders['Brand_id'];
							//$Seller_id= $_REQUEST['Brand_id'];

							$Validate_seller=$this->Merchant_api_model->Check_seller_exist($Seller_id,$Company_id);
							if($Validate_seller == NULL )	
							{
								$Result3100 = array("Error_flag" => 2009 );
								echo json_encode($Result3100); //invalid outlet id/outlet id not exist. 
								exit;
							}
							else
							{
								//***************Check outlet exist****************************
								$Outlet_id = $getHeaders['Outlet_id'];
								$Validate_Outlet=$this->Merchant_api_model->Check_outlet_exist($Seller_id,$Outlet_id,$Company_id);
								if($Validate_Outlet == NULL )	
								{
									$Result3100 = array("Error_flag" => 2009 );
									echo json_encode($Result3100); //invalid outlet id/outlet id not exist. 
									exit;
								}
								//***********************************************************
								//*********************Check Items of Brand_id*************
								
								/* $Get_brand_items=$this->Merchant_api_model->Get_brand_items($Seller_id,$Company_id);
								if($Get_brand_items != NULL )	
								{
									foreach($Get_brand_items as $row)
									{
										$Check_itm_trans=$this->Merchant_api_model->Check_item_trans($row->Company_merchandize_item_code,$Company_id);
										if($Check_itm_trans > '0')
										{
											$data = array(					
												'Active_flag' => 0,
												'Update_User_id' => $Seller_id,       
												'Update_date' => date('Y-m-d H:i:s')       
												); 
												
											$Update_Menu_Items = $this->Merchant_api_model->update_Menu_Items($data,$row->Company_merchandize_item_code,$Company_id);
										}
										
										else
										{
											$Delete_Items = $this->Merchant_api_model->Delete_brand_item($row->Company_merchandize_item_code,$Company_id);
										}
									}
								} */
								
							}
							
							$Partner_records = $this->POS_catalogue_model->Get_Partner_master($Company_id);
							if($Partner_records != NULL )	
							{
								$Partner_id=$Partner_records->Partner_id;
							}
													
							//$POS_array = $_REQUEST['POS_array'];
							// $obj = $inputArgs['POS_array'];
							// $obj = json_decode($POS_array);
							
							/**************************Product Group **************************************/
							// if(isset($obj->Product_Groups))
							if(isset($inputArgs['Product_Groups']))
							{
								
								 foreach($inputArgs['Product_Groups'] as $val)
								 {
									$Check_product_group = $this->Merchant_api_model->Check_product_group($val['Product_Group_Id'],$Company_id);
									 
									$Product_group_data = array(					
												'Company_id' => $Company_id,        
												'Product_group_code' => $val['Product_Group_Id'],       
												'Product_group_name' => $val['Product_Group_Name'],       
												'Seller_id' => $Seller_id,       
												'Active_flag' => 1       
												);
												
									if($Check_product_group == NULL)
									{
										/* $Check_product_group2 = $this->Merchant_api_model->Check_product_group2($val->Product_Group_Id);
										if($Check_product_group2 == 0)
										{ */
											 $Insert_product_group = $this->Merchant_api_model->insert_product_group($Product_group_data);
										//}
										/* else
										{
											$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Product_Groups',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_Group_Id : '.$val->Product_Group_Id.' already Exist'    
													);
											$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										} */
									}
									else
									{
										$Update_product_group = $this->Merchant_api_model->Update_product_group($Product_group_data,$val['Product_Group_Id'],$Company_id);
									}
									 
								 }
							 }
							 
							 /**************************Product Sub Group **************************************/
							if(isset($inputArgs['Product_SubGroups']))
							{
								 foreach($inputArgs['Product_SubGroups'] as $val)
								 {
									 $Check_product_group = $this->Merchant_api_model->Check_product_group($val['Product_Group_Id'],$Company_id);
									
									 if($Check_product_group != NULL)
									{
										$Product_group_id=$Check_product_group->Product_group_id;
										$Product_subgroup_data = array(					
													'Company_id' => $Company_id,        
													'Product_group_id' => $Product_group_id,       
													'Product_brand_code' => $val['Product_SubGroup_Id'],       
													'Product_brand_name' => $val['Product_SubGroup_Name'],       
													'Active_flag' => 1       
													);
													
										 $Check_product_subgroup = $this->Merchant_api_model->Check_product_subgroup($val['Product_SubGroup_Id'],$Company_id);
										 
										
										if($Check_product_subgroup == NULL)
										{
											/* $Check_product_subgroup2 = $this->Merchant_api_model->Check_product_subgroup2($val->Product_SubGroup_Id);
											
											if($Check_product_subgroup2 == 0)
											{ */
												$Insert_product_subgroup = $this->Merchant_api_model->insert_product_subgroup($Product_subgroup_data);
												 
											/* }
											else
											{
												$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Product_SubGroups',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_SubGroups : '.$val->Product_SubGroup_Id.' already Exist'    
													);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											} */
											 
											 
										}
										else
										{
											$Update_product_subgroup = $this->Merchant_api_model->update_product_subgroup($Product_subgroup_data,$val['Product_SubGroup_Id'],$Company_id);
										}
									}
									else
									{
										$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Product_SubGroups',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_Group_Id : '.$val['Product_Group_Id'].' does not exist'    
													);
										$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										
										
									}
									 
								 }
							}
							/**************************Menu_Groups **************************************/
							if(isset($inputArgs['Menu_Groups']))
							{
								 foreach($inputArgs['Menu_Groups'] as $val)
								 {
									 $Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($val['Menu_Group_Id'],$Company_id);
									
										 if($Check_Menu_Groups == NULL)
										{
										
											/* $Check_Menu_Groups2 = $this->Merchant_api_model->Check_Menu_Groups2($val->Menu_Group_Id);
											if($Check_Menu_Groups2 == 0)
											{ */
												$Menu_Groups_data = array(					
													'Company_id' => $Company_id,        
													'Merchandize_category_code' => $val['Menu_Group_Id'],       
													'Merchandize_category_name' => $val['Menu_Group_Name'],
													'Seller_id' => $Seller_id, 	
													'Create_user_id' => $Seller_id,       
													'Create_date' => date('Y-m-d H:i:s'),       
													'Active_flag' => 1       
													);
													
												$Insert_Menu_Groups = $this->Merchant_api_model->insert_Menu_Groups($Menu_Groups_data);
											/* }
											else
											{
												$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Menu_Groups',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Menu_Groups : '.$val->Menu_Group_Id.' already Exist'    
													);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											}
											 */
											 
										}
										else
										{
											$Menu_Groups_data = array(					
													'Merchandize_category_name' => $val['Menu_Group_Name'],       
													'Seller_id' => $Seller_id,       
													'Update_user_id' => $Seller_id,       
													'Update_date' => date('Y-m-d H:i:s')      
													);
													
											$Update_Menu_Groups = $this->Merchant_api_model->update_Menu_Groups($Menu_Groups_data,$val['Menu_Group_Id'],$Company_id);
										}
									
									 
								 }
							}
							
							/**************************Condiments**************************************/
							if(isset($inputArgs['Condiments']))
							{
								foreach($inputArgs['Condiments'] as $val)
								{
									$Check_product_group = $this->Merchant_api_model->Check_product_group($val['Product_Group_Id'],$Company_id);
										
									if($Check_product_group != NULL)
									{
										$Product_group_id=$Check_product_group->Product_group_id;
										
										$Check_product_subgroup = $this->Merchant_api_model->Check_product_subgroup($val['Product_SubGroup_Id'],$Company_id);
											 
										if($Check_product_subgroup != NULL)
										{
											$Product_brand_id=$Check_product_subgroup->Product_brand_id;
											
											$Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($val['Menu_Group_Id'],$Company_id);
										
											if($Check_Menu_Groups != NULL)
											{
												$Merchandize_category_id=$Check_Menu_Groups->Merchandize_category_id;
												
													$Check_Condiments = $this->Merchant_api_model->Check_Item_Num($val['Item_Num'],$Company_id);
													
													/*******************check item linked outlets*********/
														$Check_linkedItems = $this->Merchant_api_model->Check_pos_item_linked_outlets($Outlet_id,$Company_id,$val['Item_Num']);
														
														if($Check_linkedItems == 0)
														{
															//***************Items linked to outlet
															$item_outlet_data = array(					
																	'Company_id' => $Company_id,        
																	'Merchandize_item_code' => $val['Item_Num'],        
																	'Outlet_id' => $Outlet_id,        
																	'Brand_id' => $Seller_id,        
																	'Create_user_id' => $Seller_id,       
																	'Create_date' => date('Y-m-d H:i:s')
																	);
																	
															 $insert_item_outlet = $this->Merchant_api_model->insert_item_linked_outlet($item_outlet_data);
															
															//**********************************
														}
													if($Check_Condiments == 0)
													{
														
														$Condiments_data = array(					
																'Company_id' => $Company_id,        
																'Company_merchandize_item_code' => $val['Item_Num'],       
																'Merchandize_item_name' => $val['Item_Name'],       
																//'Merchandise_item_description' => $val['Item_Description'],
																'Cost_price' => $val['Item_Rate'],       
																'Billing_price' => $val['Item_Rate'],       
																'Valid_from' => date('Y-m-d'),       
																'Valid_till' => '2030-12-31',       
																'Tier_id' => 0,       
																'Merchant_flag' => 1,       
																'Seller_id' => $Seller_id,    
																'Partner_id' => $Partner_id,   	
																'Product_group_id' => $Product_group_id,       
																'Product_brand_id' => $Product_brand_id,'Merchandize_category_id' => $Merchandize_category_id,'Merchandize_item_type' => 119,       
																'show_item' => $val['Show_Item'],       
																'Ecommerce_flag' => 1,       
																'Delivery_method' => 0,       
																'Create_User_id' => $Seller_id,       
																'Creation_date' => date('Y-m-d H:i:s'),       
																'Active_flag' => 1       
																);
																
														 $insert_Condiments = $this->Merchant_api_model->insert_Condiments($Condiments_data);
														 
														 
														 
														 $Post_data31=array(
																	'Company_id'=>$Company_id,
																	'Menu_Item_code'=>$val['Item_Num'],
																	'Pos_price'=>$val['Item_Rate'],
																	'From_date'=>date('Y-m-d'),
																	'To_date'=>'2030-12-31',
																	'Old_Price_flag'=>0,
																	'Create_user_id'=>$Seller_id,
																	'Create_date'=>date('Y-m-d H:i:s'),
																	'Price_Active_flag'=>1);
																$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
														 
													}
													else
													{
														
														$Check_price = $this->Merchant_api_model->Check_pos_price_child($Company_id,$val['Item_Num'],$val['Item_Rate']);
														
														if($Check_price == 0)
														{
															$Update1 = $this->POS_catalogue_model->Update_pos_combo_child($Company_id,$val['Item_Num']);
															$Post_data31=array(
																	'Company_id'=>$Company_id,
																	'Menu_Item_code'=>$val['Item_Num'],
																	'Pos_price'=>$val['Item_Rate'],
																	'From_date'=>date('Y-m-d'),
																	'To_date'=>'2030-12-31',
																	'Old_Price_flag'=>0,
																	'Create_user_id'=>$Seller_id,
																	'Create_date'=>date('Y-m-d H:i:s'),
																	'Price_Active_flag'=>1);
																$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
														}	 
														$Condiments_data = array(		
																'Merchandize_item_type' => 119,  	
																'Company_id' => $Company_id,        
																'Merchandize_item_name' => $val['Item_Name'],       
																//'Merchandise_item_description' => $val['Item_Description'], 'Product_group_id' => $Product_group_id,       
																'Product_brand_id' => $Product_brand_id,
																'Merchandize_category_id' => $Merchandize_category_id,      
																'Cost_price' => $val['Item_Rate'],       
																'Billing_price' => $val['Item_Rate'],
																'show_item' => $val['Show_Item'],
																'Seller_id' => $Seller_id,
																'Update_User_id' => $Seller_id,       
																'Update_date' => date('Y-m-d H:i:s')  
																);
																
														$update_Condiments = $this->Merchant_api_model->update_Condiments($Condiments_data,$val['Item_Num'],$Company_id);
													}
													
													 
												
											}
											else
											{
												$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Condiments',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Menu_Group_Id : '.$val['Menu_Group_Id'].' does not exist'    
													);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											}
										}
										else
										{
											$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Condiments',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_SubGroup_Id : '.$val['Product_SubGroup_Id'].' does not exist'    
													);
											$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										}
									}
									 else
									{
										$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Condiments',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_Group_Id : '.$val['Product_Group_Id'].' does not exist'    
													);
										$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										
										
									}
								}
							}
							/**************************Condiment_Groups**************************************/
							if(isset($inputArgs['Condiment_Groups']))
							{
								foreach($inputArgs['Condiment_Groups'] as $val)
								{
									$delete_Condiment_Groups = $this->Merchant_api_model->delete_Condiment_Groups($val['Condiment_Group_Num'],$Company_id);
									 
									if(isset($val['Condiment_Nums']))
									{
										foreach($val['Condiment_Nums'] as $val2)
										{
											 $Check_Condiments = $this->Merchant_api_model->Check_Item_Num($val2,$Company_id);
											 
										
											 if($Check_Condiments > 0)
											{
												$Menu_group_id = $this->Merchant_api_model->Get_Category_id_item($val2,$Company_id);
												$Merchandize_category_id = $Menu_group_id->Merchandize_category_id;
												
												//Required Condiments
												$Condiment_Groups_data = array(					
												'Company_id' => $Company_id,        
												'Menu_group_id' => $Merchandize_category_id, 
												'Seller_id' => $Seller_id, 
												'Condiment_type' => 14,        
												'Group_code' => $val['Condiment_Group_Num'],       
												'Group_name' => $val['Condiment_Group_Name'],       
												'Label' => 'Select Option for '.$val['Condiment_Group_Name'].' ?',       
												'Condiment_item_code' => $val2,       
												'Active_flag' => 1       
													 
												);
												$insert_Condiment_Groups = $this->Merchant_api_model->insert_Condiment_Groups($Condiment_Groups_data);
												
												//Allowed Condiments
												$Condiment_Groups_data2 = array(					
												'Company_id' => $Company_id,        
												'Menu_group_id' => $Merchandize_category_id, 
												'Seller_id' => $Seller_id, 
												'Condiment_type' => 15,        
												'Group_code' => $val['Condiment_Group_Num'],       
												'Group_name' => $val['Condiment_Group_Name'],       
												'Label' => 'Select Option for '.$val['Condiment_Group_Name'].' ?',       
												'Condiment_item_code' => $val2,       
												'Active_flag' => 1       
													 
												);
												
												$insert_Condiment_Groups = $this->Merchant_api_model->insert_Condiment_Groups($Condiment_Groups_data2);
											
											}
											else
											{
												$error_pos_api = array(					
														'Company_id' => $Company_id,        
														'Main_array' => 'Condiment_Groups',       
														'Date' => date('Y-m-d H:i:s'),      
														'Error' => 'Condiment_Nums : '.$val2.' does not exist'    
														);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($error_pos_api);
											}
										}
									}
									 
								}
							}
							
							/**************************Menu_Items**************************************/
							if(isset($inputArgs['Menu_Items']))
							{
								 foreach($inputArgs['Menu_Items'] as $val)
								 {
									 
									 $Error_flag=0;
									 /*******************1.Check Valid Product_Group_Id****/
									 $Check_product_group = $this->Merchant_api_model->Check_product_group($val['Product_Group_Id'],$Company_id);
									
									 if($Check_product_group == NULL)
									{
										$Error_flag = 1;
										$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Menu_Items',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_Group_Id : '.$val['Product_Group_Id'].' does not exist'    
													);
										$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
									}
									/******************* 2.Check Valid Product_SubGroup_Id****/	
									$Check_product_subgroup = $this->Merchant_api_model->Check_product_subgroup($val['Product_SubGroup_Id'],$Company_id);
									
									if($Check_product_subgroup == NULL)
									{
										$Error_flag = 1;
										$Error_data = array(					
												'Company_id' => $Company_id,        
												'Main_array' => 'Menu_Items',       
												'Date' => date('Y-m-d H:i:s'),      
												'Error' => 'Product_SubGroup_Id : '.$val['Product_SubGroup_Id'].' does not exist'    
												);
										$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
									}
									/******************* 3.Check Valid Menu_Group_Id****/	
									$Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($val['Menu_Group_Id'],$Company_id);
							
									if($Check_Menu_Groups == NULL)
									{
										$Error_flag = 1;
										$Error_data = array(					
											'Company_id' => $Company_id,        
											'Main_array' => 'Menu_Items',       
											'Date' => date('Y-m-d H:i:s'),      
											'Error' => 'Menu_Group_Id : '.$val['Menu_Group_Id'].' does not exist'    
											);
										$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
									}
									/******************* 4.Check Valid Required_Condiment****/				
									if(isset($val['Required_Condiment']))
									{
										//print_r($val->Required_Condiment);
										//$abc=json_decode($val->Required_Condiment,true);
										$Required_Condiment=json_decode(json_encode($val['Required_Condiment']),true);
										// print_r($abc);
										 foreach($Required_Condiment['Condiment_Group_Nums'] as $val2)
										{
											$Check_Condiments = $this->Merchant_api_model->Check_Condiments($val2,$Company_id);
						
											 if($Check_Condiments == 0)
											{
												$Error_flag=1;
												
												$error_pos_api = array(					
												'Company_id' => $Company_id,        
												'Main_array' => 'Menu_Items',       
												'Date' => date('Y-m-d H:i:s'),      
												'Error' => 'Required_Condiment : '.$val2.' does not exist'    
												);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($error_pos_api);
											}
										}	 									 
									}
									/******************* 5.Check Valid Allowed_Condiment****/				
									if(isset($val['Allowed_Condiment']))
									{
										$Allowed_Condiment=json_decode(json_encode($val['Allowed_Condiment']),true);
										foreach($Allowed_Condiment['Condiment_Group_Nums'] as $val2)
										{
									
											 $Check_Condiments = $this->Merchant_api_model->Check_Condiments($val2,$Company_id);
										
											if($Check_Condiments == 0)
											{
												$Error_flag=1;
												$error_pos_api = array(					
												'Company_id' => $Company_id,        
												'Main_array' => 'Menu_Items',       
												'Date' => date('Y-m-d H:i:s'),      
												'Error' => 'Allowed_Condiment : '.$val2.' does not exist'    
												);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($error_pos_api);
											}
											
										}	 									 
									}
												
									/******************* 6.Check Valid Item_Num for company****/			
									$Check_Item_Num = $this->Merchant_api_model->Check_Item_Num($val['Item_Num'],$Company_id);
									$delete_cond = $this->Merchant_api_model->delete_Menu_condiments_data($val['Item_Num'],$Company_id);
									
									/******************* 7.Insert Required_Condiment****/	
									if(isset($val['Required_Condiment']))
									{
										$Required_Condiment=json_decode(json_encode($val['Required_Condiment']),true);
										
										foreach($Required_Condiment['Condiment_Group_Nums'] as $val2)
										{
											
											if($val2!='0')
											{
												$Condiment_item_code = $this->Merchant_api_model->Select_Condiment_item_code($val2,$Company_id,'14');
												
												if($Condiment_item_code!=NULL)
												{
													foreach($Condiment_item_code as $val3)
													{
														$Menu_condiments_data = array(					
														'Company_id' => $Company_id,        
														'Item_code' => $val['Item_Num'],       
														'Require_optional' => 14,       
														'Condiment_item_code' => $val3->Condiment_item_code,
														'Group_code' => $val2      
															
														); 
														
														$insert_Menu_condiments_data = $this->Merchant_api_model->insert_Menu_condiments_data($Menu_condiments_data);
													}
												}
											}
											
										}	 									 
										
									}
									/******************* 8.Insert Allowed_Condiment****/	
									if(isset($val['Allowed_Condiment']))
									{
										$Allowed_Condiment=json_decode(json_encode($val['Allowed_Condiment']),true);
										foreach($Allowed_Condiment['Condiment_Group_Nums'] as $val2)
										{
											$Condiment_item_code = $this->Merchant_api_model->Select_Condiment_item_code($val2,$Company_id,'15');
											if($Condiment_item_code!=NULL)
											{
												foreach($Condiment_item_code as $val3)
												{
													$Menu_condiments_data = array(					
													'Company_id' => $Company_id,        
													'Item_code' => $val['Item_Num'],       
													'Require_optional' => 15,       
													'Condiment_item_code' => $val3->Condiment_item_code,
													'Group_code' => $val2      
														
													); 
									
													$insert_Menu_condiments_data = $this->Merchant_api_model->insert_Menu_condiments_data($Menu_condiments_data);
												}
											} 
										}	 									 
										
									}
									
									
									
									if($Check_Item_Num == 0 )
									{
										/******************* 7.Check Valid Item_Num for overall****/	
										/* $Check_Item_Num2 = $this->Merchant_api_model->Check_Item_Num2($val->Item_Num);
										if($Check_Item_Num2 == 0)
										{ */
											if($Error_flag == 0)
											{	
												/*******************check item linked outlets*********/
												$Check_linkedItems = $this->Merchant_api_model->Check_pos_item_linked_outlets($Outlet_id,$Company_id,$val['Item_Num']);
												if($Check_linkedItems == 0)
												{
													//***************Items linked to outlet
													$item_outlet_data = array(					
															'Company_id' => $Company_id,        
															'Merchandize_item_code' => $val['Item_Num'],        
															'Outlet_id' => $Outlet_id,        
															'Brand_id' => $Seller_id,        
															'Create_user_id' => $Seller_id,       
															'Create_date' => date('Y-m-d H:i:s')
															);
															
													 $insert_item_outlet = $this->Merchant_api_model->insert_item_linked_outlet($item_outlet_data);
													
													//**********************************
												}		
										
												
												/******************* 9.Insert Menu_Items_data****/
												$Product_group_id=$Check_product_group->Product_group_id;
												$Product_brand_id=$Check_product_subgroup->Product_brand_id;
												$Merchandize_category_id=$Check_Menu_Groups->Merchandize_category_id;
	
												$Menu_Items_data = array(					
												'Company_id' => $Company_id,        
												'Company_merchandize_item_code' => $val['Item_Num'],       
												'Merchandize_item_name' => $val['Item_Name'],       
												//'Merchandise_item_description' => $val['Item_Description'],       
												'Cost_price' => $val['Item_Rate'],       
												'Billing_price' => $val['Item_Rate'],       
												'Valid_from' => date('Y-m-d'),       
												'Valid_till' => '2030-12-31',       
												'Tier_id' => 0,       
												'Merchant_flag' => 1,       
												'Seller_id' => $Seller_id,       
												'Partner_id' => $Partner_id,       
												'Product_group_id' => $Product_group_id,       
												'Product_brand_id' => $Product_brand_id,
												'Merchandize_category_id' => $Merchandize_category_id,  
												'Merchandize_item_type' => 117,       
												'show_item' => $val['Show_Item'],       
												'Ecommerce_flag' => 1,       
												'Delivery_method' => 0,       
												'Create_User_id' => $Seller_id,       
												'Creation_date' => date('Y-m-d H:i:s'),       
												'Active_flag' => 1       
												); 
												$Insert_Menu_Items = $this->Merchant_api_model->insert_Menu_Items($Menu_Items_data);
												/******************* 10.Insert Price_data child****/

												
												$Post_data31=array(
													'Company_id'=>$Company_id,
													'Menu_Item_code'=>$val['Item_Num'],
													'Pos_price'=>$val['Item_Rate'],
													'From_date'=>date('Y-m-d'),
													'To_date'=>'2030-12-31',
													'Old_Price_flag'=>0,
													'Create_user_id'=>$Seller_id,
													'Create_date'=>date('Y-m-d H:i:s'),
													'Price_Active_flag'=>1);
												$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
												/*************************************************/
											}
										/* }
										else
										{
											$Error_flag = 1;
											$Error_data = array(					
												'Company_id' => $Company_id,        
												'Main_array' => 'Menu_Items',       
												'Date' => date('Y-m-d H:i:s'),      
												'Error' => 'Item_Num : '.$val->Item_Num.' already Exist'    
												);
											$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										} */
										
									}
									else
									{
										if($Error_flag == 0)
										{
											/*******************check item linked outlets*********/
											$Check_linkedItems = $this->Merchant_api_model->Check_pos_item_linked_outlets($Outlet_id,$Company_id,$val['Item_Num']);
											if($Check_linkedItems == 0)
											{
												//***************Items linked to outlet
												$item_outlet_data = array(					
														'Company_id' => $Company_id,        
														'Merchandize_item_code' => $val['Item_Num'],        
														'Outlet_id' => $Outlet_id,        
														'Brand_id' => $Seller_id,        
														'Create_user_id' => $Seller_id,       
														'Create_date' => date('Y-m-d H:i:s')
														);
														
												 $insert_item_outlet = $this->Merchant_api_model->insert_item_linked_outlet($item_outlet_data);
												
												//**********************************
											}		
										
											$Product_group_id=$Check_product_group->Product_group_id;
											$Product_brand_id=$Check_product_subgroup->Product_brand_id;
											$Merchandize_category_id=$Check_Menu_Groups->Merchandize_category_id;
											
											$Check_price = $this->Merchant_api_model->Check_pos_price_child($Company_id,$val['Item_Num'],$val['Item_Rate']);
														
											if($Check_price == 0)
											{
												$Update1 = $this->POS_catalogue_model->Update_pos_combo_child($Company_id,$val['Item_Num']);
												$Post_data31=array(
												'Company_id'=>$Company_id,
												'Menu_Item_code'=>$val['Item_Num'],
												'Pos_price'=>$val['Item_Rate'],
												'From_date'=>date('Y-m-d'),
												'To_date'=>'2030-12-31',
												'Old_Price_flag'=>0,
												'Create_user_id'=>$Seller_id,
												'Create_date'=>date('Y-m-d H:i:s'),
												'Price_Active_flag'=>1);
												$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
											}	
											$Menu_Items_data = array(					
											'Merchandize_item_type' => 117,       
											'Merchandize_item_name' => $val['Item_Name'],       
											//'Merchandise_item_description' => $val['Item_Description'],       
											'Cost_price' => $val['Item_Rate'],       
											'Billing_price' => $val['Item_Rate'],   
											'show_item' => $val['Show_Item'],		
											'Product_group_id' => $Product_group_id,       
											'Product_brand_id' => $Product_brand_id,
											'Merchandize_category_id' => $Merchandize_category_id, 
											'Seller_id' => $Seller_id,	
											'Update_User_id' => $Seller_id,       
											'Update_date' => date('Y-m-d H:i:s')       
											); 
											
											$Update_Menu_Items = $this->Merchant_api_model->update_Menu_Items($Menu_Items_data,$val['Item_Num'],$Company_id);
										}
									}
											
										
									
									 
								 }
							} 
							
							/**************************Combo_Meals**************************************/
							if(isset($inputArgs['Combo_Meals']))
							{
								
								foreach($inputArgs['Combo_Meals'] as $val)
								{
									 $Error_flag=0;
									 /*****************1.Check Valid Combo_Meal_Main_Items*********************/
									if(isset($val['Combo_Meal_Main_Items']))
									{
									
										/* foreach($val->Combo_Meal_Main_Items as $val3)
										{
											// echo "<br><br>Item_Num :: ".$val3->Item_Num;
											$Check_Item_Num = $this->Merchant_api_model->Check_Item_Num($val3->Item_Num,$Company_id);
											if($Check_Item_Num==0)
											{
											
												$Error_flag=1;
												$Error_data = array(					
												'Company_id' => $Company_id,        
												'Main_array' => 'Combo_Meal_Main_Items',       
												'Date' => date('Y-m-d H:i:s'),      
												'Error' => 'Item_Num : '.$val3->Item_Num.' does not exist'    
												);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											}
											
											
										} */
						
										$this->process_items($val['Combo_Meal_Main_Items'],$Company_id,$Seller_id,$Partner_id,$Outlet_id);
						
									}
									
									/*****************2. Check Valid Combo_Meal_Side_Groups**********************/
									if(isset($val['Combo_Meal_Side_Groups']))
									{
										foreach($val['Combo_Meal_Side_Groups'] as $val4)
										{
											// echo "<br><br>Item_Num :: ".$val3->Item_Num;
											/****sandeep**
											$Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($val4->Side_Group_Id,$Company_id);
													
											if($Check_Menu_Groups == 0)
											{
												$Error_flag=1;
												$Error_data = array(					
												'Company_id' => $Company_id,        
												'Main_array' => 'Combo_Meal_Side_Groups',       
												'Date' => date('Y-m-d H:i:s'),      
												'Error' => 'Side_Group_Id : '.$val4->Side_Group_Id.' does not exist'    
												);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											}*/
											
											if(isset($val4['Combo_Meal_Sides']))
											{
					
										$this->process_items($val4['Combo_Meal_Sides'],$Company_id,$Seller_id,$Partner_id,$Outlet_id);
						
												/* foreach($val4->Combo_Meal_Sides as $val5)
												{
													$Check_Item_Num = $this->Merchant_api_model->Check_Item_Num($val5->Item_Num,$Company_id);
													if($Check_Item_Num == 0)
													{
														
														$Error_flag=1;
														$Error_data = array(					
														'Company_id' => $Company_id,        
														'Main_array' => 'Combo_Meal_Side_Groups',       
														'Date' => date('Y-m-d H:i:s'),      
														'Error' => 'Item_Num : '.$val5->Item_Num.' does not exist'    
														);
														$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
													}
												} */
											}
										}
									}
									/*******************************************************/
									
									$Product_group_id = 0;
									$Product_brand_id = 0;
									$Merchandize_category_id = 0;
									$Combo_Meal_Item=json_decode(json_encode($val['Combo_Meal_Item']),true);
									// echo "<br>Combo_Meal_Item::";
									// print_r($Combo_Meal_Item['Item_Num']);
									 //foreach($Combo_Meal_Item['Item_Num'] as $val2)
									//{
										//echo "<br>val2::";
										// print_r($Combo_Meal_Item['Item_Num']);
										$Menu_Item_code=$Combo_Meal_Item['Item_Num'];
										
										/**********3.Check Valid Product_Group_Id**************/	
										$Check_product_group = $this->Merchant_api_model->Check_product_group($Combo_Meal_Item['Product_Group_Id'],$Company_id);
									
										if($Check_product_group == NULL)
										{
											$Error_flag=1;
											$Error_data = array(					
														'Company_id' => $Company_id,        
														'Main_array' => 'Combo_Meals',       
														'Date' => date('Y-m-d H:i:s'),      
														'Error' => 'Product_Group_Id : '.$Combo_Meal_Item['Product_Group_Id'].' does not exist'    
														);
											$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										}
										else
										{	$Product_group_id=$Check_product_group->Product_group_id;}
										/**********4.Check Valid Product_SubGroup_Id**************/											
										$Check_product_subgroup = $this->Merchant_api_model->Check_product_subgroup($Combo_Meal_Item['Product_SubGroup_Id'],$Company_id);
										 
										if($Check_product_subgroup == NULL)
										{
											$Error_flag=1;
											$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Combo_Meals',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Product_SubGroup_Id : '.$Combo_Meal_Item['Product_SubGroup_Id'].' does not exist'    
													);
											$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
										}
										
										else {	$Product_brand_id=$Check_product_subgroup->Product_brand_id;}
										/**********5.Check Valid Menu_Group_Id**************/
											$Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($Combo_Meal_Item['Menu_Group_Id'],$Company_id);
											
											if($Check_Menu_Groups == NULL)
											{
												
												$Error_flag=1;
												$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Combo_Meals',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Menu_Group_Id : '.$Combo_Meal_Item['Menu_Group_Id'].' does not exist'    
													);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											}
											
											else
											{	$Merchandize_category_id=$Check_Menu_Groups->Merchandize_category_id;}
										/**********6.Check Valid Menu_Item_code FOR COMPANY**************/
										$Check_Item_Num = $this->Merchant_api_model->Check_Item_Num($Menu_Item_code,$Company_id);
										
										
										/*******************check item linked outlets*********/
										$Check_linkedItems = $this->Merchant_api_model->Check_pos_item_linked_outlets($Outlet_id,$Company_id,$Menu_Item_code);
										if($Check_linkedItems == 0)
										{	
											//***************Items linked to outlet
											$item_outlet_data = array(					
													'Company_id' => $Company_id,        
													'Merchandize_item_code' => $Menu_Item_code,        
													'Outlet_id' => $Outlet_id,        
													'Brand_id' => $Seller_id,        
													'Create_user_id' => $Seller_id,       
													'Create_date' => date('Y-m-d H:i:s')
													);
													
											 $insert_item_outlet = $this->Merchant_api_model->insert_item_linked_outlet($item_outlet_data);
											
											//**********************************	
										}		
												
										// echo '<br><br>Menu_Item_code:'.$Menu_Item_code.'--Check_Item_Num'.$Check_Item_Num;		
										if($Check_Item_Num == 0)
										{
											$Combo_Items_data = array(					
											'Company_id' => $Company_id,        
											'Company_merchandize_item_code' => $Menu_Item_code,       
											'Merchandize_item_name' => $Combo_Meal_Item['Item_Name'],       
											//'Merchandise_item_description' => $Combo_Meal_Item['Item_Name'],       
											'Cost_price' => $Combo_Meal_Item['Item_Rate'],       
											'Billing_price' => $Combo_Meal_Item['Item_Rate'],       
											'Valid_from' => date('Y-m-d'),       
											'Valid_till' => '2030-12-31',       
											'Tier_id' => 0,       
											'Merchant_flag' => 1,       
											'Seller_id' => $Seller_id, 
											'Partner_id' => $Partner_id,     	
											'Product_group_id' => $Product_group_id,       
											'Product_brand_id' => $Product_brand_id,
											'Merchandize_category_id' => $Merchandize_category_id,  
											'Combo_meal_number' => $val['Combo_Meal_Num'],  
											'Merchandize_item_type' => 118,       
											'show_item' => $Combo_Meal_Item['Show_Item'],       
											'Ecommerce_flag' => 1,       
											'Delivery_method' => 0,       
											'Create_User_id' => $Seller_id,       
											'Creation_date' => date('Y-m-d H:i:s'),       
											'Active_flag' => 1       
											); 
											/**********7.Check Valid Menu_Item_code FOR Overall**************/
											/* $Check_Item_Num2 = $this->Merchant_api_model->Check_Item_Num2($Menu_Item_code);
											
											if($Check_Item_Num2 == 0)
											{ */
											
														
												if($Error_flag==0)
												{

													/**************POS iTEM Price Child*********/
													
														
														$Post_data31=array(
																'Company_id'=>$Company_id,
																'Menu_Item_code'=>$Menu_Item_code,
																'Pos_price'=>$Combo_Meal_Item['Item_Rate'],
																'From_date'=>date('Y-m-d'),
																'To_date'=>'2030-12-31',
																'Old_Price_flag'=>0,
																'Create_user_id'=>$Seller_id,
																'Create_date'=>date('Y-m-d H:i:s'),
																'Price_Active_flag'=>1);
															$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
													/**********************************/
													
													$Insert_Menu_Items = $this->Merchant_api_model->insert_Menu_Items($Combo_Items_data);
												}
											/* 	
											}
											else
											{
												$Error_flag=1;
												$Error_data = array(					
													'Company_id' => $Company_id,        
													'Main_array' => 'Combo_Meals',       
													'Date' => date('Y-m-d H:i:s'),      
													'Error' => 'Item_Num : '.$Menu_Item_code.' already Exist'    
													);
												$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
											} */
											
										}
										else
										{
											
											if($Error_flag==0)
											{
												$Check_price = $this->Merchant_api_model->Check_pos_price_child($Company_id,$Menu_Item_code,$Combo_Meal_Item['Item_Rate']);
														
												if($Check_price == 0)
												{
													$Update1 = $this->POS_catalogue_model->Update_pos_combo_child($Company_id,$Menu_Item_code);
													/**************POS iTEM Price Child*********/
												
													
													$Post_data31=array(
															'Company_id'=>$Company_id,
															'Menu_Item_code'=>$Menu_Item_code,
															'Pos_price'=>$Combo_Meal_Item['Item_Rate'],
															'From_date'=>date('Y-m-d'),
															'To_date'=>'2030-12-31',
															'Old_Price_flag'=>0,
															'Create_user_id'=>$Seller_id,
															'Create_date'=>date('Y-m-d H:i:s'),
															'Price_Active_flag'=>1);
														$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
												/**********************************/
												}
												$Combo_Items_data = array(	
												'Merchandize_item_type' => 118,  	
												'Merchandize_item_name' => $Combo_Meal_Item['Item_Name'],       
												//'Merchandise_item_description' => $Combo_Meal_Item['Item_Name'],       
												'Cost_price' => $Combo_Meal_Item['Item_Rate'],       
												'Billing_price' => $Combo_Meal_Item['Item_Rate'], 
												'show_item' => $Combo_Meal_Item['Show_Item'], 	
												'Product_group_id' => $Product_group_id,       
												'Product_brand_id' => $Product_brand_id,
												'Merchandize_category_id' => $Merchandize_category_id,  
												'Seller_id' => $Seller_id,
												'Update_User_id' => $Seller_id,       
												'Update_date' => date('Y-m-d H:i:s')       
												); 
												
												$Update_Menu_Items = $this->Merchant_api_model->update_Menu_Items($Combo_Items_data,$Menu_Item_code,$Company_id);
											}
											
										}
									//}
												
											
										
										
								
									/*****************Insert Combo_Meal_Main_Items*****************************/
									
									if($Error_flag==0)
									{
										$Delete_combo_child = $this->Merchant_api_model->Delete_item_combo_child($Company_id,$Menu_Item_code,'MAIN');
										if(isset($val['Combo_Meal_Main_Items']))
										{
											foreach($val['Combo_Meal_Main_Items'] as $val3)
											{
												$Post_data=array(
													'Company_id'=>$Company_id,
													'Menu_Item_code'=>$Menu_Item_code,
													'Side_label'=>'Select Main Item below?',
													'Item_flag'=>'MAIN',
													'Main_or_side_item_code'=>$val3['Item_Num'],
													'Quanity'=>$val3['Quantity'],
													'Price'=>$val3['Item_Rate']
													);
													
													$Insert_items = $this->POS_catalogue_model->Insert_pos_main_item_combo_child($Post_data);
												
											}

										}
										
									}
									/*****************Insert Combo_Meal_Side_Groups*****************************/
										
								if($Error_flag==0)
								{
									
									
									$Delete_combo_child = $this->Merchant_api_model->Delete_item_combo_child($Company_id,$Menu_Item_code,'SIDE');
									// echo "<br><br><br>Combo_Meal_Side_Groups<br>";
									// print_r($val->Combo_Meal_Side_Groups);
									
										if(isset($val['Combo_Meal_Side_Groups']))
										{
											$Side_option=1;
											$Delete_side_items = $this->Merchant_api_model->Delete_side_group_child($Company_id,$Menu_Item_code);
											foreach($val['Combo_Meal_Side_Groups'] as $val4)
											{
												
												// echo "<br><br><br>Combo_Meal_Sides<br>";
												// print_r($val4->Combo_Meal_Sides);
												// echo "<br><br>Item_Num :: ".$val3->Item_Num;
												if(isset($val4['Combo_Meal_Sides']))
												{
													$Acount = count($val4['Combo_Meal_Sides']);
												
													$go_flag = 0; $Side_Group_Id = 0;
													
													foreach($val4['Combo_Meal_Sides'] as $val5)
													{
														
														/* $Check_Menu_Groups2 = $this->Merchant_api_model->Check_Menu_Groups2($val5->Menu_Group_Id);
														
														if($Check_Menu_Groups2 > 0)
														{ */
														$Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($val5['Menu_Group_Id'],$Company_id);
														
														$Side_Group_Id = $Check_Menu_Groups->Merchandize_category_id; 
															
														
															$Post_data=array(
															'Company_id'=>$Company_id,
															'Side_option'=>$Side_option,
															'Menu_Item_code'=>$Menu_Item_code,
														//	'Side_item_id'=>$val4->Side_Group_Id,
															'Side_item_id'=>$Side_Group_Id,
															'Side_group_item_code'=>$val5['Item_Num'],
															'Quanity'=>$val5['Quantity'],
															'Price'=>$val5['Item_Rate']
															);
															
														$Insert_items = $this->POS_catalogue_model->Insert_pos_side_groups_items($Post_data);
														//}
														
													}
												}
												$Post_data1=array(
												'Company_id'=>$Company_id,
												'Menu_Item_code'=>$Menu_Item_code,
												'Side_label'=>'Select Side Item below?',
												'Item_flag'=>'SIDE',
												'Main_or_side_item_code'=>$Side_Group_Id,
												'Quanity'=>0,
												'Price'=>0
												);
												
												$Insert_items = $this->POS_catalogue_model->Insert_pos_main_item_combo_child($Post_data1);
												$Side_option++;
											}
										}
									
									
								}
									
									
									 
								}
        
							}
							
							/********************************************************************************/
									$fields = array();
								  
									//Fetching the column names from return array data
								  
									$Error_Records= $this->Merchant_api_model->Select_POS_API_Error_Records($Company_id);
									 if($Error_Records==NULL)
									{
										$Result1001 = array("Error_flag" => 1001); // Status OK
										$this->output->set_output(json_encode($Result1001));
									}
									if($Error_Records != NULL)
									{
										$Result3105 = array("Error_flag" => 3105 );
										echo json_encode($Result3105); //Invalid POS json data
										
									  $this->load->library("Excel");
									  foreach ($Error_Records[0] as $key => $field) {
										 
										$fields[] = $key;
									  }
									  $col = 0;
									  foreach ($fields as $field) {
										// echo"<pre>";
										$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
										$col++;
									  }
									  //Fetching the table data
									  $row = 2;
									  foreach ($Error_Records as $data1) {
										$col = 0;
										foreach ($fields as $field) {
										  $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
										  $col++;
										}
										$row++;
									  }
									
									  $this->excel->setActiveSheetIndex(0);
									  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
									  // $objWriter = new PHPExcel_Writer_Excel2007($this->excel); 
									  //force user to download the Excel file without writing it to server's HD
									  // $objWriter->save('php://output');
									  $date=date('Y-m-d');
									  $abc=$Check_company_exist->Company_name.'-'.$date;
									  //$objWriter->save('POS_API_ERROR\POS_API_ERROR-'.$abc.'.xls');
									  //$file_path=base_url('POS_API_ERROR\POS_API_ERROR-'.$abc.'.xls');
									  $objWriter->save($_SERVER['DOCUMENT_ROOT'].'/POS_API_ERROR/POS_API_ERROR-'.$abc.'.xls');
									  $file_path=($_SERVER['DOCUMENT_ROOT'].'/POS_API_ERROR/POS_API_ERROR-'.$abc.'.xls');
									   //**************************Email Fuction Code*****************************
									  $pos_html = "<p>Hello,</p>

												<p>Please find attached the PoS API Error details which was created while uploading the JSON format of POS Item while creating /updating Items from PoS for Company ".$Check_company_exist->Company_name."</p>

												<p>Please rectify the JSON file and upload again.</p>

												<p>Regards,
												<br>Novacom System Ltd.</p>"; 
												
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

										  $this->email->from($Check_company_exist->Company_primary_email_id);
										  $this->email->to('amit@novacom.co.ke');
										 $this->email->bcc(array('rakesh@miraclecartes.com','amit@novacom.co.ke','demoloyalty@novacom.co.ke'));
										$this->email->subject('PoS API Error file for '.$Check_company_exist->Company_name);
										$this->email->message($pos_html);
										$this->email->attach($file_path);
										if (!$this->email->send()) {
											 //echo"---NOT-Send--Email Template-<br>";
											// var_dump($this->CI->email->send());
										} else {
											 //echo"----Send--Email Template-<br>";
										}
									}


								  //**************************Email Fuction Code*****************************/	
						
						
						
					}
				}
				else
				{
					$Result128 = array("Error_flag" => 2002);
					$this->output->set_output(json_encode($Result128)); // Invalid Company Password
				}
			}
			else
			{
				$Result129 = array("Error_flag" => 2001);
				$this->output->set_output(json_encode($Result129)); // Invalid Company User Name
			}
		}
	}
	public function cheque_format($amount, $decimals = true, $decimal_seperator = '.')
	{
		$levels = array(1000000,100000, 10000, 1000, 100, 10, 5, 1);
		$decimal_levels = array(50, 20, 10, 5, 1);
		preg_match('/(?:\\' . $decimal_seperator . '(\d+))?(?:[eE]([+-]?\d+))?$/', (string)$amount, $match);
		$d = isset($match[1]) ? $match[1] : 0;

		foreach ( $levels as $level )
		{
			$level = (float)$level;
			$results[(string)$level] = $div = (int)(floor($amount) / $level);
			if ($div) $amount -= $level * $div;
		}

		if ( $decimals ) {
			$amount = $d;
			foreach ( $decimal_levels as $level )
			{
				$level = (float)$level;
				$results[$level < 10 ? '0.0'.(string)$level : '0.'.(string)$level] = $div = (int)(floor($amount) / $level);
				if ($div) $amount -= $level * $div;
			}
		}	
		if($results['1000000']>0){
		$num=$results['1000000'];
		} else {
			$num=0;
		}
		if($results['100000']>0){
			$num1=$results['100000'];	
		} else {
			$num1=0;
		}
		if($results['10000']>0){
			$num2=$results['10000'];
		} else {
			$num2=0;
		}
		if($results['1000']>0){
			$num3=$results['1000'];
		} else {
			$num3=0;
		}
		if($results['100']>0){
			$num4=$results['100'];
		} else {
			$num4=0;
		}
		$FnalAmt=$num.''.$num1.''.$num2.''.$num3.''.$num4.''.'00';
		$FnalAmt1=number_format($FnalAmt,2);
		return $FnalAmt1;
		//print_r($results);
	}
	public function string_encrypt($string, $key, $iv)
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
	} 	
	public function login_mail($Logged_Enrollment_id,$Logged_in_from)
	{
		$User_details = $this->Igain_model->get_enrollment_details($Logged_Enrollment_id);
		$Company_details = $this->Igain_model->get_company_details($User_details->Company_id);
		
		$Date = date("Y-m-d h:i:s");
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
								<td>'.$Company_details->Company_name.'</td>
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
		/**************************Email Fuction Code*****************************/
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
			if ( ! $this->email->send())
			{
				//echo "Email Sent";
			}
			else
			{
				//echo "Email Not Sent";
			}
		/**************************Email Fuction Code*****************************/
	}
	// AMIT KAMBLE POS ITEM CREATION
	public function process_items($ItemsArray,$Company_id,$Seller_id,$Partner_id,$Outlet_id)
	{
		if(isset($ItemsArray))
		{
			foreach($ItemsArray as $val3)
			{
				$Error_flag = 0;
				// echo "<br><br>Item_Num :: ".$val3->Item_Num;
				$Check_Item_Num = $this->Merchant_api_model->Check_Item_Num($val3['Item_Num'],$Company_id);
				if($Check_Item_Num==0)
				{
				
					/* $Error_flag=1;
					$Error_data = array(					
					'Company_id' => $Company_id,        
					'Main_array' => 'Combo_Meal_Main_Items',       
					'Date' => date('Y-m-d H:i:s'),      
					'Error' => 'Item_Num : '.$val3->Item_Num.' does not exist'    
					);
					$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data); */
					
//*** sandeep **** 
					/**********3.Check Valid Product_Group_Id**************/	
					$Check_product_group = $this->Merchant_api_model->Check_product_group($val3['Product_Group_Id'],$Company_id);
				
					if($Check_product_group == NULL)
					{
						$Error_flag=1;
						$Error_data = array(					
									'Company_id' => $Company_id,        
									'Main_array' => 'Combo_Meals',       
									'Date' => date('Y-m-d H:i:s'),      
									'Error' => 'Product_Group_Id : '.$val3['Product_Group_Id'].' does not exist'    
									);
						$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
					}
					else
					{	$Product_group_id=$Check_product_group->Product_group_id;}
										
					/**********4.Check Valid Product_SubGroup_Id**************/											
					$Check_product_subgroup = $this->Merchant_api_model->Check_product_subgroup($val3['Product_SubGroup_Id'],$Company_id);
					 
					if($Check_product_subgroup == NULL)
					{
						$Error_flag=1;
						$Error_data = array(					
								'Company_id' => $Company_id,        
								'Main_array' => 'Combo_Meals',       
								'Date' => date('Y-m-d H:i:s'),      
								'Error' => 'Product_SubGroup_Id : '.$val3['Product_SubGroup_Id'].' does not exist'    
								);
						$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
					}
					else {	$Product_brand_id=$Check_product_subgroup->Product_brand_id;}
											
					/**********5.Check Valid Menu_Group_Id**************/
						$Check_Menu_Groups = $this->Merchant_api_model->Check_Menu_Groups($val3['Menu_Group_Id'],$Company_id);
						
						if($Check_Menu_Groups == NULL)
						{
							
							$Error_flag=1;
							$Error_data = array(					
								'Company_id' => $Company_id,        
								'Main_array' => 'Combo_Meals',       
								'Date' => date('Y-m-d H:i:s'),      
								'Error' => 'Menu_Group_Id : '.$val3['Menu_Group_Id'].' does not exist'    
								);
							$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($Error_data);
						}
						else
						{	$Merchandize_category_id=$Check_Menu_Groups->Merchandize_category_id;}
						/******************* 4.Check Valid Required_Condiment****/				
						if(isset($val3['Required_Condiment']))
						{
							//print_r($val->Required_Condiment);
							//$abc=json_decode($val->Required_Condiment,true);
							$Required_Condiment=json_decode(json_encode($val3['Required_Condiment']),true);
							// print_r($abc);
							 foreach($Required_Condiment['Condiment_Group_Nums'] as $val2)
							{
								$Check_Condiments = $this->Merchant_api_model->Check_Condiments($val2,$Company_id);
			
								 if($Check_Condiments == 0)
								{
									$Error_flag=1;
									
									$error_pos_api = array(					
									'Company_id' => $Company_id,        
									'Main_array' => 'Combo_Meals',       
									'Date' => date('Y-m-d H:i:s'),      
									'Error' => 'Required_Condiment : '.$val2.' does not exist'    
									);
									$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($error_pos_api);
								}
							}	 									 
						}
						/******************* 5.Check Valid Allowed_Condiment****/				
						if(isset($val3['Allowed_Condiment']))
						{
							$Allowed_Condiment=json_decode(json_encode($val3['Allowed_Condiment']),true);
							foreach($Allowed_Condiment['Condiment_Group_Nums'] as $val2)
							{
						
								 $Check_Condiments = $this->Merchant_api_model->Check_Condiments($val2,$Company_id);
							
								if($Check_Condiments == 0)
								{
									$Error_flag=1;
									$error_pos_api = array(					
									'Company_id' => $Company_id,        
									'Main_array' => 'Combo_Meals',       
									'Date' => date('Y-m-d H:i:s'),      
									'Error' => 'Allowed_Condiment : '.$val2.' does not exist'    
									);
									$Insert_error_pos_api = $this->Merchant_api_model->Insert_error_pos_api($error_pos_api);
								}
								
							}	 									 
						}
						
						if($Error_flag == 0)
						{	
							/*******************Delete item linked outlets*********/
							$Check_linkedItems = $this->Merchant_api_model->Check_pos_item_linked_outlets($Outlet_id,$Company_id,$val3['Item_Num']);
							if($Check_linkedItems == 0)
							{
							//***************Items linked to outlet
								$item_outlet_data = array(					
										'Company_id' => $Company_id,        
										'Merchandize_item_code' => $val3['Item_Num'],        
										'Outlet_id' => $Outlet_id,        
										'Brand_id' => $Seller_id,        
										'Create_user_id' => $Seller_id,       
										'Create_date' => date('Y-m-d H:i:s')
										);
										
								 $insert_item_outlet = $this->Merchant_api_model->insert_item_linked_outlet($item_outlet_data);
								
								//**********************************	
							}	
							/******************* 9.Insert Menu_Items_data****/
							$Menu_Items_data = array(					
							'Company_id' => $Company_id,        
							'Company_merchandize_item_code' => $val3['Item_Num'],       
							'Merchandize_item_name' => $val3['Item_Name'],       
							//'Merchandise_item_description' => $val3['Item_Description'],       
							'Cost_price' => $val3['Item_Rate'],       
							'Billing_price' => $val3['Item_Rate'],       
							'Valid_from' => date('Y-m-d'),       
							'Valid_till' => '2030-12-31',       
							'Tier_id' => 0,       
							'Merchant_flag' => 1,       
							'Seller_id' => $Seller_id,       
							'Partner_id' => $Partner_id,       
							'Product_group_id' => $Product_group_id,       
							'Product_brand_id' => $Product_brand_id,
							'Merchandize_category_id' => $Merchandize_category_id,  
							'Merchandize_item_type' => 117,       
							'show_item' => 1,       
							'Ecommerce_flag' => 1,       
							'Delivery_method' => 0,       
							'Create_User_id' => $Seller_id,       
							'Creation_date' => date('Y-m-d H:i:s'),       
							'Active_flag' => 1       
							); 
							$Insert_Menu_Items = $this->Merchant_api_model->insert_Menu_Items($Menu_Items_data);
							/******************* 10.Insert Price_data child****/
							$Update1 = $this->POS_catalogue_model->Update_pos_combo_child($Company_id,$val3['Item_Num']);
							$Post_data311=array(
								'Company_id' =>$Company_id,
								'Menu_Item_code' =>$val3['Item_Num'],
								'Pos_price' =>$val3['Item_Rate'],
								'From_date' => date('Y-m-d'),
								'To_date' => '2030-12-31',
								'Old_Price_flag' => 0,
								'Create_user_id' => $Seller_id,
								'Create_date' => date('Y-m-d H:i:s'),
								'Price_Active_flag' =>1);
							$Insert_pos_price11 = $this->POS_catalogue_model->Insert_pos_price($Post_data311);
							/*************************************************/
						}
				}
				
				
			}
		}
	}
	
}		 		
?>