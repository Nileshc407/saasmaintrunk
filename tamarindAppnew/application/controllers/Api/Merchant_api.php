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
		$this->load->model('Igain_model');	
		$this->load->model('transactions/Transactions_model');	
		$this->load->library('Send_notification');
		$this->load->model('login/Login_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->model('Coal_transactions/Coal_Transactions_model');
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
	public function iGainSpark_api()
	{
		$date = new DateTime();
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');
		$iv = '56666852251557009888889955123458'; 		
		
		$API_flag = $_REQUEST['API_flag'];
		$API_Company_username = $_REQUEST['Company_username'];
		$API_Company_password = $_REQUEST['Company_password'];
	
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
				$Decrypt_Company_password = $this->string_decrypt($API_Company_password, $key, $iv);	
				$Decrypt_Company_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Decrypt_Company_password);
				
				$Password_match = strcmp($DB_Company_password,$Decrypt_Company_password);
				
				if($Password_match == 0)
				{
					$result = $this->Merchant_api_model->check_company_key_valid($Company_id);// Check Company Key validation
					
					$Company_username = $result->Company_username;
					$Company_password = $result->Company_password;
					$key = $result->Company_encryptionkey;
						
					$API_flag2 = $this->string_decrypt($_REQUEST['API_flag'], $key, $iv);
					$API_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $API_flag2);
					
					/***************************Fetch Member Info**************************/
					
					if($API_flag == 20)  //Fetch_Member_info
					{	
						/* $merchant_email = $_REQUEST["Merchant_email"];
													
						$result91 = $this->Merchant_api_model->Get_Seller_Details($Company_id,$merchant_email);	
				
						if($result91 !=NULL)
						{ 
							$Seller_enroll_id  = $result91->Enrollement_id;
							$Outlet_name  = $result91->First_name.' '.$result91->Last_name; */
							
							$Membership_id = $_REQUEST['Membership_id'];
						
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
										"Member_email" => $result->User_email_id, 
										"Phone_no" => $result->Phone_no, 
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
						$mechant_emailid = $_REQUEST['Merchant_email'];
						$Purchase_amount = $_REQUEST['Purchase_amount'];
						$Redeem_points = $_REQUEST['Redeem_points'];
						$Membership_id = $_REQUEST['Membership_id'];	
						
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
							$Cust_enrollement_id = $result->Enrollement_id;
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
							
							
							/* if($Redeem_points <= 0)
							{
								$Error = array(
										"Error_flag" => 1001,
										"Equivalent_redeem_amount" => 0,
										"Balance_points" => $Current_point_balance-$Redeem_points
									);
									
								echo json_encode($Error); // Null result found 
								exit;
							} */
							
							$result1 = $this->Merchant_api_model->Get_Seller($mechant_emailid,$Company_id); //Get Merchant redemption ratio
							
							if($result1!=NULL)
							{
								$Seller_id = $result1->Enrollement_id;
								
								$Seller_Redemptionratio = $result1->Seller_Redemptionratio;
								
								$currency_details = $this->Igain_model->Get_Country_master($result1->Country);
								$Symbol_currency = $currency_details->Symbol_of_currency;
								
								/* $result2 = $this->Merchant_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id);
								
								if($result2!=NULL)
								{
									$Cust_confirmation_code = $result2->Confirmation_code;
								 */
									if($Redeem_points <= $Current_point_balance)
									{	
										$result22 = $this->Merchant_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points);
										
										if($result22==NULL) 
										{
											$calculate2 = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem);
											
											if($calculate2!=2066)
											{
												$Confirmation_code = $this->Igain_model->getRandomString();
					
												$data = array(
															'Enrollement_id' => $Cust_enrollement_id, 
															'Company_id' => $Company_id,
															'Seller_id' => $Seller_id,
															'Confirmation_code' => $Confirmation_code,
															'Confirmation_flag' => 0,
															'Redeem_points' => $Redeem_points
														);
														
												$Redeem_request = $this->Merchant_api_model->Cust_redeem_request_insert($data);
											
												$Notification_type ='Redeem Request with '.$Company_name1;
												
												
												$Email_content = array(
															'Notification_type' => $Notification_type,
															'Confirmation_code' => $Confirmation_code,
															'Redeem_points' => $Redeem_points,
															'Symbol_currency' => $Symbol_currency,
															'Equivalent_amount' => number_format($calculate2, 2),
															'Template_type' => 'Customer_redeem_request'
														);
										
												$this->send_notification->send_Notification_email($Cust_enrollement_id,$Email_content,$Seller_id,$Company_id);
											}
										}
										
										$result2 = $this->Merchant_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points);
										
										$Cust_confirmation_code = $result2->Confirmation_code;
										
										$calculate = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem);
										
										if($result2 !=NULL)
										{
											if($calculate != NULL)
											{
												if($calculate > $Purchase_amount) //Equivalent Redeem Amount is More than Total Bill Amount
												{
													$Equivalent = array(
														"Error_flag" => 2066
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
														"Confirmation_flag" => 1
													);
												}	
												
												$data1 = array(
															'Confirmation_flag' => 2
															);
															
												$this->Merchant_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id);
												
												echo json_encode($Equivalent); // successfully
												exit;
												
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
														"Confirmation_flag" => 1
													);
													
												echo json_encode($Error); // Null result found
												exit;
											}
										}
										else
										{
											if($calculate > $Purchase_amount) //Equivalent Redeem Amount is More than Total Bill Amount
											{
												$Equivalent = array(
													"Error_flag" => 2066
												);
												
												echo json_encode($Equivalent);
												exit;
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
															"Confirmation_flag" => ""
														);
												echo json_encode($Equivalent); // Cust Not Approved 
												exit;
											}
										}
									}
									else
									{ 
										$Result12 = array(
													"Error_flag" => 3101
												);
												
										echo json_encode($Result12); //Insufficient Point Balance
										exit;
									}
								/* }
								else
								{ 
									$Result12 = array(
												"Error_flag" => 3102,
												"Confirmation_flag" => 0
											);
											
									echo json_encode($Result12); //Customer Not Approved redeemprion request
									exit;
								} */
							}
							else
							{
								$Result3100 = array(
												"Error_flag" => 2009
											);
											
								echo json_encode($Result3100); // Seller Email Not Found
								exit;
							}
						}
						else    
						{
							$Result127 = array(
												"Error_flag" => 2003
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
										$Notification_type ='Pos / Loyalty Transation with '.$Company_name1;
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
											
								
									$result_order = $this->Merchant_api_model->Get_order_evouchers_details($Order_no,$Manual_bill_no,$Company_id,$Card_id);
									
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
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no);
										
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
						$Merchant_email = $_REQUEST['Merchant_email'];
						$Membership_id = $_REQUEST['Membership_id'];
						$Order_no = $_REQUEST['Online_order_no'];
						$Manual_bill_no = $_REQUEST['Manual_bill_no'];
						$Order_status_id = $_REQUEST['Order_status'];
						
						/* $headers = getallheaders();  
						$api_key = $headers['api_key'];
						$Authorization = $headers['Authorization'];
						echo "api_key--------".$api_key;
						echo "Authorization--------".$Authorization; die;  */
						
						if($Order_status_id == 20) // For Delivered / Collected
						{ 
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
											
								
									$result_order = $this->Merchant_api_model->Get_order_evouchers_details($Order_no,$Manual_bill_no,$Company_id,$Card_id);
									
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
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no);
										
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
								
									$result_order = $this->Merchant_api_model->Get_online_order_details($Order_no,$Manual_bill_no,$Company_id,$Card_id);
									
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
								
										$result = $this->Merchant_api_model->Update_Order_Status($data2,$Card_id,$Company_id,$Order_no,$Manual_bill_no);
										
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
					/********************Nilesh-API Satrt for prestashop-Nilesh******************/ 
					/****************************Website Enrollment******************************/ 
					if($API_flag == 70)
					{	
						$first_name = $_REQUEST['fname'];
						$last_name = $_REQUEST['lname'];
						$email = $_REQUEST['userEmailId'];
						$Phone_no = $_REQUEST['phno'];		
						
						if($first_name !="" || $last_name !="" || $email !="" || $Company_id !="")
						{
							$company_details = $this->Igain_model->get_company_details($Company_id);
							$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
							$Dial_Code = $this->Igain_model->get_dial_code11($Super_Seller_details->Country);
							
							$dialcode=$Dial_Code->phonecode;
							$phoneNo=$dialcode.''.$Phone_no;	
							$timezone_entry=$Super_Seller_details->timezone_entry;
							$data['Company_details']=$company_details;
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
										
									/**********Nilesh igain Log Table change 29-06-207***************/ 
										$opration = 1;				
										$User_id = 1; 
										$what="New Member Sign Up From Website";
										$where="from Prestashop";
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
													// $Todays_date = date("Y-m-d");
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
											
											$Result1001 = array("Error_flag" => 1001); //Enroll successfully
											$this->output->set_output(json_encode($Result1001));	
										}
										else
										{
											$Result2032 = array("Error_flag" => 2032); //Mobile No is already Exist
											$this->output->set_output(json_encode($Result2032));
										}
								}
								else
								{
									$Result2032 = array("Error_flag" => 2032); //Mobile No is already Exist
									$this->output->set_output(json_encode($Result2032));
								}
							}
							else
							{
								$Result2030 = array("Error_flag" => 2030); //Email ID is already Exist
								$this->output->set_output(json_encode($Result2030));
								
							}
						}
						else
						{
							// redirect('login', 'refresh');
							$Result9999 = array("Error_flag" => 9999);
							$this->output->set_output(json_encode($Result9999));	
						}		
					}
					/****************************Website Enrollment**************************************/ 
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
						$Customer_email = $_REQUEST['Customer_email'];
						
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
					/***********************Nilesh-API End for prestashop-Nilesh**********************/ 	
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
}		 		
?>