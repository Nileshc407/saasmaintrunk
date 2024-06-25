<?php 
error_reporting(0);
class Online_api extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('Api/Online_api_model'); 
		$this->load->model('Api/Online_model');	
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
		$result = array(
						 "Error_flag" => 404,
						 "Message" => "Invalid Inputs"
				    	);
						
		echo json_encode($result);
		exit;
	}		
	public function ExternalWEB_api()
	{
		$date = new DateTime();
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');
		$iv = '56666852251557009888889955123458'; 		
		
		$API_flag = $_REQUEST['API_flag'];
		$API_Company_username = $_REQUEST['Company_username'];
		$API_Company_password = $_REQUEST['Company_password'];		
		$API_Channel_password = $_REQUEST['Channel_password'];		
		
		$getHeaders = apache_request_headers();
		if($getHeaders!=Null)
		{
			$API_flag = $getHeaders['API_flag'];	
			$API_Company_username = $getHeaders['Company_username'];	
			$API_Company_password = $getHeaders['Company_password'];	
			$API_Channel_password = $getHeaders['Channel_password'];	
		}
		
		$inputArgs = (json_decode(file_get_contents('php://input'),true));
		if($inputArgs !=NULL)
		{
			if($API_flag == Null && $API_Company_username == Null && $API_Company_password == Null)
			{
				$API_flag = $inputArgs['API_flag'];
				$API_Company_username = $inputArgs['Company_username'];
				$API_Company_password = $inputArgs['Company_password'];
				$API_Channel_password = $inputArgs['Channel_password'];
			}
		}	
		
		if($API_Company_username == "" || $API_Company_password == "" || $API_flag == "" || $API_Channel_password == "")
		{
				$result = array(
								"Error_flag" => 404,
								"Message" => "Invalid input Or some input filed missing");			
				echo json_encode($result);	
				exit;
		}
		else
		{
			$Check_company_exist = $this->Online_api_model->Check_compnay_by_username($API_Company_username);							
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
				
				$Use_Voucher_as_discounts = $Check_company_exist->Voucher_as_discount_flag;
				$Company_voucher_discount_code = $Check_company_exist->Voucher_discount_code;
				$Daily_points_consumption_flag = $Check_company_exist->Daily_points_consumption_flag;  
				
				$Password_match = strcmp($DB_Company_password,$Decrypt_Company_password);
				
				if($Password_match == 0)
				{
					$result = $this->Online_api_model->check_company_key_valid($Company_id);// Check Company Key validation
					
					$Company_username = $result->Company_username;
					$Company_password = $result->Company_password;
					$key = $result->Company_encryptionkey;
									
					$Channel_Details = $this->Online_api_model->get_3rd_party_channel_details($Company_id,$API_Channel_password);
					
					if($Channel_Details != Null)
					{
						$ChannelCompanyId = $Channel_Details->Channel_Company_Id;
						$ChannelCompanyName = $Channel_Details->Channel_Company_Name;
							
						$API_flag2 = $this->string_decrypt($API_flag, $key, $iv);
						$API_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $API_flag2);
					/***************************Fetch Member Info**************************/
						if($API_flag == 1)
						{	
							$Membership_id = $inputArgs['Membership_id'];
						
							$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
							$phnumber = $dial_code.$Membership_id;
						
							$result = $this->Online_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details	
							
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
									
								$member_details = array(
										"Error_flag" => 1001,
										"Message" => "Successful",
										"Membership_id" => $result->Card_id,
										"Card_id" => $result->Card_id,
										"Member_name" => $Memeber_name,
										"Current_balance" => $Current_point_balance
									);
								
								echo json_encode($member_details);
								exit;
							}	
							else    
							{
								$Result127 = array("Error_flag" => 2003,
										"Message" => "Invalid or unable to locate membership id",
										"Membership_id" => null,
										"Card_id" => null,
										"Member_name" => null,
										"Current_balance" => 0
								); 
								echo json_encode($Result127); //Unable to Locate membership id
								exit;
							}
						}
						/***************************Fetch Member Info**************************/
						/***************Points Redeem Request*****************/
						if($API_flag == 2)
						{	
							$Membership_id = $inputArgs['Membership_id'];
							$Pos_bill_no = $inputArgs['Order_No'];
							$Purchase_amount = $inputArgs['Order_Total'];
							$Pos_outlet_id = $inputArgs['Outlet_No'];
							$Pos_bill_items = $inputArgs['Order_Items'];
							$Pos_redeem_details = $inputArgs['Redeem_Details'];
							$Redeem_points = $Pos_redeem_details['Points_Redeemed'];
							
							$Purchase_amount = str_replace( ',', '', $Purchase_amount);
							$Redeem_points = str_replace( ',', '', $Redeem_points);
						
							$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code	
							$phnumber = $dial_code.$Membership_id;
													
							$result = $this->Online_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
							if($result!=NULL)
							{
								if($result == 3111)
								{
									$Result1311 = array("Error_flag" => 3111,
														"Message" =>'Customer code expired',
														"Membership_id" => $Card_id,
														"Current_points" => 0,
														"Redeem_points" => 0,
														"Equivalent_redeem_amount" => number_format(0, 2),
														"Balance_points" => 0,
														"Confirmation_code" => null,
														"Confirmation_flag" => 0,
														"Order_no" => $Pos_bill_no,
														"Order_total" => number_format($Purchase_amount,2)
														);
									echo json_encode($Result1311);
									exit;		
								}							
								$Card_id = $result->Card_id;
								$Cust_enrollement_id = $result->Enrollement_id;
								$Current_balance = $result->Current_balance;
								$Blocked_points = $result->Blocked_points;
								$Debit_points = $result->Debit_points;
								
								$lv_member_Tier_id = $result->Tier_id;
								$Total_reddems = $result->Total_reddems;
								
								$Memeber_name = $result->First_name.' '.$result->Last_name;
								
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
													"Message" => "Invalid redeem points.",
													"Membership_id" => $Card_id,
													"Member_name" => $Memeber_name,
													"Current_points" => $Current_point_balance,
													"Redeem_points" => 0,
													"Equivalent_redeem_amount" => number_format(0, 2),
													"Balance_points" => $Current_point_balance,
													"Confirmation_code" => null,
													"Confirmation_flag" => 0,
													"Order_no" => $Pos_bill_no,
													"Order_total" => number_format($Purchase_amount,2)
												);
												
									echo json_encode($Result1271); // Invalid redeem points
									exit;
								}
								if($Company_meal_flag == 0 && $Daily_points_consumption_flag == 0)
								{
									if($Total_reddems == 0)
									{
										$result51 = $this->Online_api_model->Get_Member_Tier_Details($lv_member_Tier_id,$Company_id);
										$Tier_redeemtion_limit = $result51->Redeemtion_limit;
										if($Tier_redeemtion_limit != Null)
										{
											if($Current_point_balance < $Tier_redeemtion_limit)
											{
												$Result31 = array(
															"Error_flag" => 3101,
															"Message" => "Insufficient Points Balance",
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => 0,
															"Equivalent_redeem_amount" => number_format(0, 2),
															"Balance_points" => $Current_point_balance,
															"Confirmation_code" => null,
															"Confirmation_flag" => 0,
															"Order_no" => $Pos_bill_no,
															"Order_total" => number_format($Purchase_amount,2));
														
												echo json_encode($Result31); //Insufficient Point Balance
												exit;
											}
										}
									} 
								}
								if($Daily_points_consumption_flag == 1)
								{
									$result52 = $this->Online_api_model->Get_Member_Tier_Details($lv_member_Tier_id,$Company_id);
									$Tier_consumption_limit = $result52->Redeemtion_limit;
									
									$Consumption_details = $this->Online_api_model->Get_points_consumption_details($Cust_enrollement_id,$Company_id);
									if($Consumption_details !=Null)
									{
										$Total_points_used = $Consumption_details->Total_points_used;
									}
									else
									{
										$Total_points_used = 0;
									}
									
									$Total_points_consumption = $Total_points_used + $Redeem_points;
									
									if($Tier_consumption_limit > 0)
									{
										if($Tier_consumption_limit < $Total_points_consumption)
										{
											$Result3113 = array(
														"Error_flag" => 3113,
														"Message" => "Consumption limit exceeded",
														"Membership_id" => $Card_id,
														"Member_name" => $Memeber_name,
														"Current_points" => $Current_point_balance,
														"Redeem_points" => 0,
														"Equivalent_redeem_amount" => number_format(0, 2),
														"Balance_points" => $Current_point_balance,
														"Confirmation_code" => null,
														"Confirmation_flag" => 0,
														"Order_no" => $Pos_bill_no,
														"Order_total" => number_format($Purchase_amount,2));
													
											echo json_encode($Result3113); //Daily Points Consumption Limit exceeded
											exit;
										}
									}
								}
								$result1 = $this->Online_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
								
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
									/*****************validate items 03-08-2021*****************************/
										if($Pos_bill_items != Null)
										{
											$Bill_total_array = array();
											
											foreach($Pos_bill_items as $item)
											{ 
												$ItemCode = $item['Item_Num']; 
												
												$ItemDetails = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
												
												if($ItemDetails == NULL)
												{
													$Result3103 = array(
															"Error_flag" => 3103,
															"Message" => "Invalid item number or item does not exist.",
															"Item_Num" => $ItemCode,
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format(0, 2),
															"Balance_points" => $Current_point_balance,
															"Confirmation_code" => null,
															"Confirmation_flag" => 0,
															"Order_no" => $Pos_bill_no,
															"Order_total" => number_format($Purchase_amount,2));
														
													echo json_encode($Result3103); // nvalid Item_Num Or Item not exist.
													exit;
												}
												else
												{
												
													$Item_Qty = str_replace( ',', '', $item['Item_Qty']);
													$Item_Rate = str_replace( ',', '', $item['Item_Rate']);
													
													$Item_Amount = $Item_Qty*$Item_Rate;
													$Bill_total_array[]=$Item_Amount;
												}
											}
											$Bill_amount_totat = array_sum($Bill_total_array);
										/*****************check bill amount and item amount 27-09-2021***********************/	
											if($Bill_amount_totat != $Purchase_amount)
											{
												$Result1002 = array(
														"Error_flag" => 1002,
														"Message" => "Item(s) Total Amount Not Matching with Bill Total Amount",
														"Membership_id" => $Card_id,
														"Member_name" => $Memeber_name,
														"Current_points" => $Current_point_balance,
														"Redeem_points" => $Redeem_points,
														"Equivalent_redeem_amount" => number_format(0, 2),
														"Balance_points" => $Current_point_balance,
														"Confirmation_code" => null,
														"Confirmation_flag" => 0,
														"Order_no" => $Pos_bill_no,
														"Order_total" => number_format($Purchase_amount,2));
																
												echo json_encode($Result1002); 
												exit;
											}
										/*****************check bill amount and item amount 27-09-2021***********************/	
										}
										else
										{
											$Result3103 = array(
														"Error_flag" => 3103,
														"Message" => "Invalid Item_Num Or Item Details Missing.",
														"Item_Num" => null,
														"Membership_id" => $Card_id,
														"Member_name" => $Memeber_name,
														"Current_points" => $Current_point_balance,
														"Redeem_points" => $Redeem_points,
														"Equivalent_redeem_amount" => number_format(0, 2),
														"Balance_points" => $Current_point_balance,
														"Confirmation_code" => null,
														"Confirmation_flag" => 0,
														"Order_no" => $Pos_bill_no,
														"Order_total" => number_format($Purchase_amount,2));
													
											echo json_encode($Result3103); // invalid Item_Num Or Item not exist.
											exit;
										}
									/*****************validate items 03-08-2021*****************************/
									
										if($Redeem_points <= $Current_point_balance)
										{	
											$result221 = $this->Online_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no,$ChannelCompanyId);
													
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
																
														$this->Online_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id,$ChannelCompanyId);
													}
												}
											}
											
											$result22 = $this->Online_api_model->Check_redeem_request_issent($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no,$ChannelCompanyId);
											
											if($result22==NULL) 
											{
												$calculate2 = $this->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount);	
												
												$calculate2 = str_replace( ',', '', $calculate2);
												
												if($calculate2 != 0000)
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
																'Channel_id' => $ChannelCompanyId,
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
																
													$this->Online_api_model->update_cust_old_redeem_request($data1,$Cust_enrollement_id,$Company_id,$Seller_id,$ChannelCompanyId);
															
													$Redeem_request = $this->Online_api_model->Cust_redeem_request_insert($data);
												
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
											
											$result2 = $this->Online_api_model->Get_cust_approved_request($Cust_enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no,$ChannelCompanyId);
											
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
											
											$calculate = $this->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount);
											
											$calculate = str_replace( ',', '', $calculate);
											
											if($result2 !=NULL)
											{
												if($calculate != NULL)
												{
													if($calculate== 0000 || $calculate > $Purchase_amount)
													{
														$Equivalent = array(
															"Error_flag" => 2066,
															"Message" => "Equivalent Redeem Amount is More than Order Total",
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format(0, 2),
															"Balance_points" => $Current_point_balance,
															"Confirmation_code" => null,
															"Confirmation_flag" => 0,
															"Order_no" => $Pos_bill_no,
															"Order_total" => number_format($Purchase_amount,2));
													}
													else
													{
														$Equivalent = array(
															"Error_flag" => 1001, 
															"Message" => "Successful", 
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format($calculate, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => $Cust_confirmation_code,
															// "Confirmation_flag" => 1,
															"Confirmation_flag" => $Cust_confirmation_flag,
															"Order_no" => $Pos_bill_no,
															"Order_total" => number_format($Purchase_amount,2));
													}	
													echo json_encode($Equivalent); // successfully
													exit;
												}
												else
												{
													$Error = array(
															"Error_flag" => 1001,
															"Message" => "Successful", 
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" =>  number_format(0, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => $Cust_confirmation_code,
															// "Confirmation_flag" => 1,
															"Confirmation_flag" => $Cust_confirmation_flag,
															"Order_no" => $Pos_bill_no,
															"Order_total" => number_format($Purchase_amount,2));
													
													echo json_encode($Error); // Null result found
													exit;
												}
											}
											else
											{
												if($calculate == 0000 || $calculate > $Purchase_amount) 
												{
													$Equivalent = array(
														"Error_flag" => 2066,
														"Message" =>"Equivalent Redeem Amount is More than Order Total",
														"Membership_id" => $Card_id,
														"Member_name" => $Memeber_name,
														"Current_points" => $Current_point_balance,
														"Redeem_points" => $Redeem_points,
														"Equivalent_redeem_amount" => number_format(0, 2),
														"Balance_points" => $Current_point_balance,
														"Confirmation_code" => null,
														"Confirmation_flag" => 0,
														"Order_no" => $Pos_bill_no,
														"Order_total" => number_format($Purchase_amount,2));
													
													echo json_encode($Equivalent);
													exit;
												}
												else
												{
													$Equivalent = array(
															"Error_flag" => 1001,
															"Message" => "Successful", 															
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Current_points" => $Current_point_balance,
															"Redeem_points" => $Redeem_points,
															"Equivalent_redeem_amount" => number_format($calculate, 2),
															"Balance_points" => $Current_point_balance-$Redeem_points,
															"Confirmation_code" => "",
															"Confirmation_flag" => 0,
															"Order_no" => $Pos_bill_no,
															"Order_total" => number_format($Purchase_amount,2));
													
													echo json_encode($Equivalent); // Cust Not Approved 
													exit;
												}
											}
										}
										else
										{ 
											$Result12 = array(
														"Error_flag" => 3101,
														"Message" => "Insufficient Points Balance",
														"Membership_id" => $Card_id,
														"Member_name" => $Memeber_name,
														"Current_points" => $Current_point_balance,
														"Redeem_points" => 0,
														"Equivalent_redeem_amount" => number_format(0, 2),
														"Balance_points" => $Current_point_balance,
														"Confirmation_code" => null,
														"Confirmation_flag" => 0,
														"Order_no" => $Pos_bill_no,
														"Order_total" => number_format($Purchase_amount,2));
														
												echo json_encode($Result12); //Insufficient Point Balance
												exit;
											}
								}
								else
								{
									$Result3100 = array(
													"Error_flag" => 2009,
													"Message" => "Invalid outlet no.",
													"Membership_id" => $Card_id,
													"Member_name" => $Memeber_name,
													"Current_points" => $Current_point_balance,
													"Redeem_points" => 0,
													"Equivalent_redeem_amount" => number_format(0, 2),
													"Balance_points" => $Current_point_balance,
													"Confirmation_code" => null,
													"Confirmation_flag" => 0,
													"Order_no" => $Pos_bill_no,
													"Order_total" => number_format($Purchase_amount,2));
												
									echo json_encode($Result3100); // Seller Email Not Found
									exit;
								}
							}
							else    
							{
								$Result127 = array("Error_flag" => 2003,
													"Message" => "Invalid or unable to locate membership id",
													"Membership_id" => null,
													"Member_name" => null,
													"Current_points" => 0,
													"Redeem_points" => 0,
													"Equivalent_redeem_amount" => number_format(0, 2),
													"Balance_points" => 0,
													"Confirmation_code" => null,
													"Confirmation_flag" => 0,
													"Order_no" => $Pos_bill_no,
													"Order_total" => number_format($Purchase_amount,2)
													);
								echo json_encode($Result127); // Membership Id Not found
								exit;
							}							
						}
					/**********************Points Redeem Request***********************************/
					/**********************Validate Voucher Request*******************************/
						if($API_flag == 3) 
						{
							$Membership_id = $inputArgs['Membership_id'];
							$Order_no = $inputArgs['Order_No'];
							$Bill_amount = $inputArgs['Order_Total'];
							$Outlet_no = $inputArgs['Outlet_No']; 
							$Item_details = $inputArgs['Order_Items'];
							$Voucher_Details = $inputArgs['Voucher_Details']; 
							$Discount_voucher_code = $Voucher_Details['Voucher_No'];	
							
							$Loyalty_Discount = $inputArgs['Loyalty_Discount']; 
							$POS_Discount = $inputArgs['POS_Discount']; 
							$Loyalty_Discount = 0;
							$POS_Discount = 0;
							
							$Bill_amount = str_replace( ',', '', $Bill_amount);
							$Loyalty_Discount = str_replace( ',', '', $Loyalty_Discount);
							$POS_Discount = str_replace( ',', '', $POS_Discount);
							
								$result1 = $this->Online_api_model->Get_outlet_details($Outlet_no,$Company_id); //Get Outlet Details
									
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
									
									$result = $this->Online_api_model->get_pos($Membership_id,$Company_id,$phnumber); //Get Customer details
									
									if($result!=NULL)
									{	
										if($result == 3111)
										{
											$Result1311 = array("Error_flag" => 3111, 
																"Message" =>'Customer code expired',
																"Membership_id" => null,
																"Member_name" => null,
																"Order_no" => $Order_no,
																"Order_total" => number_format($Bill_amount,2),
																"Voucher_no" => $Discount_voucher_code,
																"Voucher_amount" => number_format(0,2)
																);
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
										$Voucher_result = $this->Online_api_model->Validate_discount_voucher($Card_id,$Company_id,$Discount_voucher_code,$Voucher_amount);
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
												$Product_Voucher_Details = $this->Online_api_model->Get_Product_Voucher_Details($Gift_card_id,$Cust_enrollement_id,$Company_id);
												
												$Product_Voucher_item_code = $Product_Voucher_Details->Company_merchandize_item_code;
												$Product_Voucher_id = $Product_Voucher_Details->Voucher_id;
												$Product_Voucher_Offer_code = $Product_Voucher_Details->Offer_code;
											
												if($Product_Voucher_id ==0) // product voucher in percentage
												{
													$Cust_Item_Num = array();
													foreach($Item_details as $item)
													{ 
														$ItemCode = $item['Item_Num']; 
														
														$ItemDetails = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
														
														if($ItemDetails !=NULL)
														{
															$Merchandize_item_code = $ItemDetails->Company_merchandize_item_code;
															$Item_name = $ItemDetails->Merchandize_item_name;
															
															// $ItemCodeArr[$ItemCode]=$item['Item_Qty'];
															$CheckItemTempCart = $this->Online_api_model->GetItemsDetails($Company_id,$Cust_enrollement_id,$ItemCode,$Outlet_no,$ChannelCompanyId);
															if($CheckItemTempCart != Null)
															{
																$TempQty = $CheckItemTempCart->Item_qty;
																
																$TempCartData["Item_qty"] = $TempQty+$item['Item_Qty'];

																$this->db->where(array("Company_id"=>$Company_id,"Enrollment_id"=>$Cust_enrollement_id,"Item_code"=>$ItemCode,"Seller_id" =>$Outlet_no,"Channel_id"=>$ChannelCompanyId));
																$this->db->update("igain_pos_temp_cart",$TempCartData);
															}
															else
															{
																$data79['Company_id'] = $Company_id;
																$data79['Enrollment_id'] = $Cust_enrollement_id;
																$data79['Seller_id'] = $Outlet_no;
																$data79['Channel_id'] = $ChannelCompanyId;
																$data79['Item_code'] = $ItemCode;
																$data79['Item_qty'] = $item['Item_Qty'];
																$data79['Item_price'] = str_replace( ',', '', $item['Item_Rate']);
																
																$this->Online_api_model->insert_item($data79);
															}
															$Cust_Item_Num[] = $ItemCode;
														}
														else
														{
															$ResponseData = array("Error_flag" => 3103,
																				  "Message" => "Invalid Item_Num Or Item not exist.",
																				  "Item_Num" => $ItemCode,
																				  "Membership_id" => $Card_id,
																				  "Member_name" => $Memeber_name,
																				  "Order_no" => $Order_no,
																				  "Order_total" => number_format($Bill_amount,2),
																				  "Voucher_no" => $Gift_card_id,
																				  "Voucher_amount" => number_format(0,2)
																				); // Item not found or invalid item code
															echo json_encode($ResponseData);
															exit;
														}
													}
													$GetItems= $this->Online_api_model->Get_items($Company_id,$Cust_enrollement_id,$Outlet_no,$ChannelCompanyId);
													if($GetItems != Null)
													{
														foreach($GetItems as $row1)
														{
															$TempItemCode = $row1->Item_code;
															$TempItemQty = $row1->Item_qty;
															
															$ItemCodeArr[$TempItemCode]=$TempItemQty;
														}
													}
												/**********************stamp new logic 02-05-2021**************************/
													$Get_lowest_sent_vouchers= $this->Online_api_model->Get_lowest_sent_vouchers($Card_id,$Company_id,$Gift_card_id);
													// 1 Kenya Tea + 1 Chai latte + 1 Lemon Tea
													if($Get_lowest_sent_vouchers != NULL)
													{
														$RemQTY=0;
														$lv_Voucher_code=0;
														$lowest_flag=1;
														$newpricearr = array();
														foreach($Get_lowest_sent_vouchers as $rec1)
														{
														if(($lowest_flag == 0) && ($lv_Voucher_code == $rec1->Voucher_code))
															{
																$RemQTY=0;
																$lowest_flag=1;
																$newpricearr = array();
																break;
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
												
													$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$Outlet_no,$ChannelCompanyId);
													
												/**********************stamp new logic 02-05-2021**************************/
													if($ReduceDiscountAmt > 0)
													{
														$Reduce_product_amt = $ReduceDiscountAmt;
														
															$Result172 = array("Error_flag" => 1001,
																		"Message" => "Successful",
																		"Membership_id" => $Card_id,
																		"Member_name" => $Memeber_name,
																		"Order_no" => $Order_no,
																		"Order_total" => number_format($Bill_amount,2),
																		"Voucher_no" => $Gift_card_id,
																		"Voucher_amount" => number_format($Reduce_product_amt,2)
																		);
															echo json_encode($Result172);
															exit;
													}
													else
													{
														$Result427 = array("Error_flag" => 2069,
																		"Message" => "Invalid Discount Voucher",
																		"Membership_id" => $Card_id,
																		"Member_name" => $Memeber_name,
																		"Order_no" => $Order_no,
																		"Order_total" => number_format($Bill_amount,2),
																		"Voucher_no" => $Discount_voucher_code,
																		"Voucher_amount" => number_format(0,2)
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
														
														$ItemDetails = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
														
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
																				  "Item_Num" => $ItemCode,
																				  "Membership_id" => $Card_id,
																				  "Member_name" => $Memeber_name,
																				  "Order_no" => $Order_no,
																				  "Order_total" => number_format($Bill_amount,2),
																				  "Voucher_no" => $Gift_card_id,
																				  "Voucher_amount" => number_format(0,2)
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
																		"Message" => "Invalid Discount Voucher",
																		"Membership_id" => $Card_id,
																		"Member_name" => $Memeber_name,
																		"Order_no" => $Order_no,
																		"Order_total" => number_format($Bill_amount,2),
																		"Voucher_no" => $Gift_card_id,
																		"Voucher_amount" => number_format(0,2)
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
																	"Message" => "Successful",
																	"Membership_id" => $Card_id,
																	"Member_name" => $Memeber_name,
																	"Order_no" => $Order_no,
																	"Order_total" => number_format($Bill_amount,2),
																	"Voucher_no" => $Gift_card_id,
																	"Voucher_amount" => number_format($Card_balance,2)
																	);
												echo json_encode($Result172);
												exit;	
											}
											else
											{
												$Result427 = array("Error_flag" => 2069,
																"Message" => "Invalid Discount Voucher",
																"Membership_id" => $Card_id,
																"Member_name" => $Memeber_name,
																"Order_no" => $Order_no,
																"Order_total" => number_format($Bill_amount,2),
																"Voucher_no" => $Gift_card_id,
																"Voucher_amount" => number_format(0,2)
																); //Invalid Gift Card Or No Balance In Gift Card
												echo json_encode($Result427);
												exit;
											}
										}
										else
										{
											$Result427 = array("Error_flag" => 2069,
															"Message" => "Invalid Discount Voucher",
															"Membership_id" => $Card_id,
															"Member_name" => $Memeber_name,
															"Order_no" => $Order_no,
															"Order_total" => number_format($Bill_amount,2),
															"Voucher_no" => $Discount_voucher_code,
															"Voucher_amount" => number_format(0,2)
															); //Invalid Gift Card Or No Balance In Gift Card
											echo json_encode($Result427);
											exit;
										}
										/*******************api logic end********************/      
									}
									else    
									{
										$Result127 = array("Error_flag" => 2003,
															"Message" => "Invalid or unable to locate membership id",
															"Membership_id" => null,
															"Member_name" => null,
															"Order_no" => $Order_no,
															"Order_total" => number_format($Bill_amount,2),
															"Voucher_no" => $Discount_voucher_code,
															"Voucher_amount" => number_format(0,2)
															); //Unable to Locate membership id
										echo json_encode($Result127);
										exit;
									} 
								}
								else
								{
									$Result3100 = array("Error_flag" => 2009,
														"Message" => "Invalid outlet no.",
														"Membership_id" => null,
														"Membership_id" => null,
														"Order_no" => $Order_no,
														"Order_total" => number_format($Bill_amount,2),
														"Voucher_no" => $Gift_card_id,
														"Voucher_amount" => number_format(0,2)
															);
									echo json_encode($Result3100); // Seller Email Not Found/Invalid User Email ID
									exit;
								}
						}
						/**********************Validate Voucher Request*******************************/ 
						/**********************Final Order Confirmation*******************************/ 
						if($API_flag == 4) // 3rd Party Online Ordering
						{ 
							$API_flag_call = 90;
							$gained_points_fag = 0;
							$cardId = $inputArgs['Membership_id'];
							$Pos_order_no = $inputArgs['Order_No'];
							$Pos_bill_no = $inputArgs['Bill_No'];
							$Pos_bill_amount = $inputArgs['Bill_Total'];
							$Pos_bill_amount = $inputArgs['Order_Total'];
							$Pos_outlet_id = $inputArgs['Outlet_No'];
							$Pos_bill_items = $inputArgs['Order_Items'];
							$Pos_voucher_details = $inputArgs['Voucher_Details'];
							$Pos_voucher_no = $Pos_voucher_details['Voucher_No'];
							$Pos_voucher_reference = $Pos_voucher_details['Voucher_Reference'];
							$Pos_voucher_amount = $Pos_voucher_details['Voucher_Amount'];
							$Pos_redeem_details = $inputArgs['Redeem_Details'];
							$Pos_points_redeemed = $Pos_redeem_details['Points_Redeemed'];
							$Pos_points_amount = $Pos_redeem_details['Points_Amount'];
							$RedeemedConfirmationCode = $Pos_redeem_details['Confirmation_Code'];
							
							$Pos_bill_tenders = $inputArgs['Bill_Tenders'];
							$Pos_payment_type = $Pos_bill_tenders['Tender_Type'];
							$Pos_payment_amount = $Pos_bill_tenders['Tender_Amount'];
							$Pos_payment_reference = $Pos_bill_tenders['Tender_Reference'];
							
							// $Pos_discount = $inputArgs['POS_Discount'];
							// $Pos_loyalty_discount = $inputArgs['Loyalty_Discount'];
							$Pos_discount = 0;
							$Pos_loyalty_discount = 0;
							
							$Pos_giftcard_details = $inputArgs['Giftcard_Details'];
							$Pos_giftcard_no = $Pos_giftcard_details['Giftcard_No'];
							$Pos_giftcard_reference = $Pos_giftcard_details['Giftcard_Reference'];
							$Pos_giftcard_amount = $Pos_giftcard_details['Giftcard_Amount'];
							
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
							
							$Pos_bill_date_time = $lv_date_time;
							
							$dial_code = $this->Igain_model->get_dial_code($Country_id); //Get Country Dial code 			
							$phnumber = $dial_code.$inputArgs['Membership_id'];
							
							$cust_details = $this->Online_api_model->cust_details_from_card($Company_id,$cardId,$phnumber); //Get Customer details
							if($cust_details !=NULL)
							{
								if($cust_details == 3111)
								{
									$Result1311 = array("Error_flag" => 3111, 
														"Message" =>'Customer code expired',
														"Membership_id" => null,
														"Member_name" => null,
														"Bill_no" => $Pos_bill_no,
														"Bill_total" => number_format($Pos_bill_amount,2),
														"Points_amount" => number_format(0,2),
														"Voucher_amount" => number_format(0,2),
														// "POS_discount" => number_format(0,2),
														// "Discount_amount" => number_format(0,2),
														"Balance_due" => number_format($Pos_bill_amount,2),
														"Gained_points" => 0,
														"Current_balance" => 0
														);
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
									$Cust_enrollement_id = $Customer_enroll_id;
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
														"Message" => "Insufficient Points Balance",
														"Membership_id" => $CardId,
														"Member_name" => $Memeber_name,
														"Bill_no" => $Pos_bill_no,
														"Bill_total" => number_format($Pos_bill_amount,2),
														// "POS_discount" => number_format(0,2),
														// "Discount_amount" => number_format(0,2),
														"Points_amount" => number_format(0,2),
														"Voucher_amount" => number_format(0,2),
														"Balance_due" => number_format($Pos_bill_amount,2),
														"Gained_points" => 0,
														"Current_balance" => $Current_bal1
													);
									echo json_encode($Result12); //Insufficient Point Balance
									exit;
								}
								if($Pos_points_redeemed > 0)
								{
									$Redeem_details=$this->Online_api_model->Check_redeem_details($Customer_enroll_id,$Company_id,$Pos_outlet_id,$ChannelCompanyId,$RedeemedConfirmationCode,$Pos_points_redeemed,$Pos_order_no);
									
									if($Redeem_details != Null)
									{
										$Confirmation_flag1 = $Redeem_details->Confirmation_flag;
										if($Confirmation_flag1 == 0)
										{
											$Result08 = array(
															"Error_flag" => 3108,
															"Message" => "Redeem Not Confirmed",
															"Membership_id" => $CardId,
															"Member_name" => $Memeber_name,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Pos_bill_amount,2),
															"Points_amount" => number_format(0,2),
															"Voucher_amount" => number_format(0,2),
															"Balance_due" => number_format($Pos_bill_amount,2),
															"Gained_points" => 0,
															"Current_balance" => $Current_bal1
														);
											echo json_encode($Result08); //Redeem Not Confirmed
											exit;
										}
										else if($Confirmation_flag1 == 3)
										{
											$Result09 = array(
															"Error_flag" => 3109,
															"Message" => "Redeem Declined",
															"Membership_id" => $CardId,
															"Member_name" => $Memeber_name,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Pos_bill_amount,2),
															"Points_amount" => number_format(0,2),
															"Voucher_amount" => number_format(0,2),
															"Balance_due" => number_format($Pos_bill_amount,2),
															"Gained_points" => 0,
															"Current_balance" => $Current_bal1
														);
											echo json_encode($Result09); //Redeem Not Confirmed
											exit;
										}	
									}
									else
									{
										$Result10 = array(
															"Error_flag" => 3110,
															"Message" => "Incorrect Redeem details",
															"Membership_id" => $CardId,
															"Member_name" => $Memeber_name,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Pos_bill_amount,2),
															"Points_amount" => number_format(0,2),
															"Voucher_amount" => number_format(0,2),
															"Balance_due" => number_format($Pos_bill_amount,2),
															"Gained_points" => 0,
															"Current_balance" => $Current_bal1
														);
											echo json_encode($Result10); //Redeem Not Confirmed
											exit;
									}
								}
								$result01 = $this->Online_api_model->check_pos_bill_no($Pos_bill_no,$Pos_outlet_id,$Company_id,$Pos_bill_date_time);				
								if ($result01 > 0)
								{
									$Result2067 = array("Error_flag" => 2067,
															"Message" => "POS bill no. already exist.",
															"Membership_id" => $CardId,
															"Member_name" => $Memeber_name,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Pos_bill_amount,2),
															// "POS_discount" => number_format(0,2),
															// "Discount_amount" => number_format(0,2),
															"Points_amount" => number_format(0,2),
															"Voucher_amount" => number_format(0,2),
															"Balance_due" => number_format($Pos_bill_amount,2),
															"Gained_points" => 0,
															"Current_balance" => $Current_bal1
															); 
									echo json_encode($Result2067); //POS bill no. already exist.
									exit;
								}
							/************************************************************/
							if($Pos_bill_items != Null)
							{
								foreach($Pos_bill_items as $item)
								{ 
									$ItemCode = $item['Item_Num']; 
									
									$ItemDetails = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
									
									if($ItemDetails !=NULL)
									{
										$Merchandize_item_code = $ItemDetails->Company_merchandize_item_code;
										$Item_name = $ItemDetails->Merchandize_item_name;
										
										// $ItemCodeArr[$ItemCode]=$item['Item_Qty'];
										$CheckItemTempCart = $this->Online_api_model->GetItemsDetails($Company_id,$Cust_enrollement_id,$ItemCode,$delivery_outlet,$ChannelCompanyId);
										if($CheckItemTempCart != Null)
										{
											$TempQty = $CheckItemTempCart->Item_qty;
											
											$TempCartData["Item_qty"] = $TempQty+$item['Item_Qty'];

											$this->db->where(array("Company_id"=>$Company_id,"Enrollment_id"=>$Cust_enrollement_id,"Item_code"=>$ItemCode,"Seller_id"=>$delivery_outlet,"Channel_id"=>$ChannelCompanyId));
											$this->db->update("igain_pos_temp_cart",$TempCartData);
										}
										else
										{
											$data78['Company_id'] = $Company_id;
											$data78['Enrollment_id'] = $Cust_enrollement_id;
											$data78['Seller_id'] = $delivery_outlet;
											$data78['Channel_id'] = $ChannelCompanyId;
											$data78['Item_code'] = $ItemCode;
											$data78['Item_qty'] = $item['Item_Qty'];
											$data78['Item_price'] = str_replace( ',', '', $item['Item_Rate']);
											
											$this->Online_api_model->insert_item($data78);
										}
									}
									else
									{
										$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
										$ResponseData = array("Error_flag" => 3103,
																"Message" => "Invalid Item_Num Or Item not exist.",
																"Item_Num" => $ItemCode,
																"Membership_id" => $CardId,
																"Member_name" => $Memeber_name,
																"Bill_no" => $Pos_bill_no,
																"Bill_total" => number_format($Pos_bill_amount,2),
																// "POS_discount" => number_format(0,2),
																// "Discount_amount" => number_format(0,2),
																"Points_amount" => number_format(0,2),
																"Voucher_amount" => number_format(0,2),
																"Balance_due" => number_format($Pos_bill_amount,2),
																"Gained_points" => 0,
																"Current_balance" => $Current_bal1
															); // Item not found or invalid item code
										echo json_encode($ResponseData);
										exit;
									}
								}
							}
							else
							{
								$ResponseData = array("Error_flag" => 3103,
														"Message" => "Invalid Item_Num Or Item Details Missing.",
														"Item_Num" => null,
														"Membership_id" => $CardId,
														"Member_name" => $Memeber_name,
														"Bill_no" => $Pos_bill_no,
														"Bill_total" => number_format($Pos_bill_amount,2),
														// "POS_discount" => number_format(0,2),
														// "Discount_amount" => number_format(0,2),
														"Points_amount" => number_format(0,2),
														"Voucher_amount" => number_format(0,2),
														"Balance_due" => number_format($Pos_bill_amount,2),
														"Gained_points" => 0,
														"Current_balance" => $Current_bal1
													); // Item not found or invalid item code
								echo json_encode($ResponseData);
								exit;
							}
								$Pos_bill_items = $this->Online_api_model->Get_temp_cart_items($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
							/*****************check bill amount and item amount 27-09-2021***********************/	
								$Bill_total_array = array();
								
								foreach($Pos_bill_items as $item)
								{ 
									$Item_Amount = $item['Item_Qty']*$item['Item_Rate'];
									$Bill_total_array[] = $Item_Amount;
								}
								$Bill_amount_totat = array_sum($Bill_total_array);
								
								if($Bill_amount_totat != $Pos_bill_amount)
								{
									$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
									
									$Result1002 = array("Error_flag" => 1002,
														"Message" => "Item(s) Total Amount Not Matching with Bill Total Amount",
														"Membership_id" => $CardId,
														"Member_name" => $Memeber_name,
														"Bill_total" => number_format($Pos_bill_amount,2),
														// "POS_discount" => number_format(0,2),
														// "Discount_amount" => number_format(0,2),
														"Points_amount" => number_format(0,2),
														"Voucher_amount" => number_format(0,2),
														"Balance_due" => number_format($Pos_bill_amount,2),
														"Gained_points" => 0,
														"Current_balance" => $Current_bal1
														); 
														
									echo json_encode($Result1002); 
									exit;
								}
							/*****************check bill amount and item amount 27-09-2021***********************/
							/************************************************************/
								if($Pos_voucher_no)
								{
									$Voucher_result = $this->Online_api_model->Validate_discount_voucher($CardId,$Company_id,$Pos_voucher_no,$Pos_voucher_amount);
									if($Voucher_result == Null)
									{
										$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
										
										$Result327 = array("Error_flag" => 2069,
															"Message" => "Invalid discount voucher",
															"Membership_id" => $CardId,
															"Member_name" => $Memeber_name,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Pos_bill_amount,2),
															// "POS_discount" => number_format(0,2),
															// "Discount_amount" => number_format(0,2),
															"Points_amount" => number_format(0,2),
															"Voucher_amount" => number_format(0,2),
															"Balance_due" => number_format($Pos_bill_amount,2),
															"Gained_points" => 0,
															"Current_balance" => $Current_bal1
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
											$Product_Voucher_Details = $this->Online_api_model->Get_Product_Voucher_Details($Pos_voucher_no,$Customer_enroll_id,$Company_id);
											
											$Product_Voucher_item_code = $Product_Voucher_Details->Company_merchandize_item_code;
											$Product_Voucher_id = $Product_Voucher_Details->Voucher_id;
											$Product_Voucher_Offer_code = $Product_Voucher_Details->Offer_code;
											
											if($Product_Voucher_id ==0) // product voucher in percentage
											{
												$Cust_Item_Num = array();
												foreach($Pos_bill_items as $item)
												{ 
													$ItemCode = $item['Item_Num']; 
													
													$ItemDetails = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
													
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
														$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
														
														$ResponseData = array("Error_flag" => 3103,
																				"Message" => "Invalid Item_Num Or Item not exist.",
																				"Item_Num" => $ItemCode,
																				"Membership_id" => $CardId,
																				"Member_name" => $Memeber_name,
																				"Bill_no" => $Pos_bill_no,
																				"Bill_total" => number_format($Pos_bill_amount,2),
																				// "POS_discount" => number_format(0,2),
																				// "Discount_amount" => number_format(0,2),
																				"Points_amount" => number_format(0,2),
																				"Voucher_amount" => number_format(0,2),
																				"Balance_due" => number_format($Pos_bill_amount,2),
																				"Gained_points" => 0,
																				"Current_balance" => $Current_bal1
																			); // Item not found or invalid item code
														echo json_encode($ResponseData);
														exit;
													}
												}
											/**********************stamp new logic 02-05-2021**************************/
												$Get_lowest_sent_vouchers= $this->Online_api_model->Get_lowest_sent_vouchers($CardId,$Company_id,$Pos_voucher_no);
												// 1 Kenya Tea + 1 Chai latte + 1 Lemon Tea
												if($Get_lowest_sent_vouchers != NULL)
												{
													$RemQTY=0;
													$lv_Voucher_code=0;
													$lowest_flag=1;
													$newpricearr = array();
													foreach($Get_lowest_sent_vouchers as $rec1)
													{
														if(array_key_exists($rec1->Company_merchandize_item_code,$ItemCodeArr))
														{
															if(($lowest_flag == 0) && ($lv_Voucher_code == $rec1->Voucher_code))
															{
																$RemQTY=0;
																$lowest_flag=1;
																$newpricearr = array();
																break;
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
															}
															if($Cart_item_QTY < $rec1->Voucher_Qty && $RemQTY==0)//
															{
																$newpricearr[]=($Cart_item_QTY*$rec1->Voucher_Cost_price);//220
																// echo "<br>".$Cart_item_QTY*$rec1->Voucher_Cost_price;
																$RemQTY= ($rec1->Voucher_Qty-$Cart_item_QTY);//1
																if($lowest_flag!=0){$data['Free_item_arr'][$rec1->Company_merchandize_item_code] = $Cart_item_QTY;}
																$lv_Voucher_code=$rec1->Voucher_code;
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
												$data['Unique_Vouchers_list'] = array_unique($ApllicableVoucher_code);
												
												$ReduceDiscountAmt = $data['Vouchers_price']["$Pos_voucher_no"];
												
											/**********************stamp new logic 02-05-2021**************************/
												if($ReduceDiscountAmt > 0)
												{
													$Reduce_product_amt = $ReduceDiscountAmt;
													$Pos_voucher_amount = number_format($Reduce_product_amt,2);
													// echo "Pos_voucher_amount---".$Pos_voucher_amount; exit;
												}
												else
												{
													$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
													
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid discount voucher",
																	"Membership_id" => $CardId,
																	"Member_name" => $Memeber_name,
																	"Bill_no" => $Pos_bill_no,
																	"Bill_total" => number_format($Pos_bill_amount,2),
																	// "POS_discount" => number_format(0,2),
																	// "Discount_amount" => number_format(0,2),
																	"Points_amount" => number_format(0,2),
																	"Voucher_amount" => number_format(0,2),
																	"Balance_due" => number_format($Pos_bill_amount,2),
																	"Gained_points" => 0,
																	"Current_balance" => $Current_bal1
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
													
													$ItemDetails1 = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
													
													if($ItemDetails1 !=NULL)
													{
														$Merchandize_item_code = $ItemDetails1->Company_merchandize_item_code;
														$Item_name = $ItemDetails1->Merchandize_item_name;
														
														$Cust_Item_Num[] = $ItemCode;
													}
													else
													{
														$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
														
														$ResponseData = array("Error_flag" => 3103,
																				"Message" => "Invalid Item_Num Or Item not exist.",
																				"Item_Num" => $ItemCode,
																				"Membership_id" => $CardId,
																				"Member_name" => $Memeber_name,
																				"Bill_no" => $Pos_bill_no,
																				"Bill_total" => number_format($Pos_bill_amount,2),
																				// "POS_discount" => number_format(0,2),
																				// "Discount_amount" => number_format(0,2),
																				"Points_amount" => number_format(0,2),
																				"Voucher_amount" => number_format(0,2),
																				"Balance_due" => number_format($Pos_bill_amount,2),
																				"Gained_points" => 0,
																				"Current_balance" => $Current_bal1
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
													$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
													
													$Result427 = array("Error_flag" => 2069,
																	"Message" => "Invalid discount voucher",
																	"Membership_id" => $CardId,
																	"Member_name" => $Memeber_name,
																	"Bill_no" => $Pos_bill_no,
																	"Bill_total" => number_format($Pos_bill_amount,2),
																	// "POS_discount" => number_format(0,2),
																	// "Discount_amount" => number_format(0,2),
																	"Points_amount" => number_format(0,2),
																	"Voucher_amount" => number_format(0,2),
																	"Balance_due" => number_format($Pos_bill_amount,2),
																	"Gained_points" => 0,
																	"Current_balance" => $Current_bal1
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
							/********************09-04-2021 validate gift card**********************/
								if($Pos_giftcard_no)
								{
									$Giftcard_result = $this->Online_api_model->Validate_gift_card($Company_id,$Pos_giftcard_no);
									if($Giftcard_result != Null)
									{
										$Gift_card_id = $Giftcard_result->Gift_card_id;
										$Card_value = $Giftcard_result->Card_value;
										$GiftCard_balance = $Giftcard_result->Card_balance;
										$Valid_till = $Giftcard_result->Valid_till;
										$Card_Payment_Type_id = $Giftcard_result->Payment_Type_id;
										$Discount_percentage = $Giftcard_result->Discount_percentage;
										
										$GiftCard_balance = str_replace( ',', '', $GiftCard_balance);
										
										if($GiftCard_balance > 0)
										{
											$Pos_giftcard_amount = $GiftCard_balance;										
										}
										else
										{
											$Result427 = array("Error_flag" => 3112,
																"Message" => "Invalid Gift card number. Or No Balance In Gift card."
																); 
											echo json_encode($Result427);
											exit;
										}
									}
									else
									{
										$Result327 = array("Error_flag" => 3112,
															"Message" => "Invalid Gift card number. Or No Balance In Gift card."
															);
										echo json_encode($Result327);
										exit;
									}
								}
								else
								{
									$Pos_giftcard_no = Null;
									$Pos_giftcard_amount = 0.00;
								}
							/********************09-04-2021 validate gift card**********************/
								$get_city_state_country = $this->Online_api_model->Fetch_city_state_country($Company_id,$Customer_enroll_id);
								$State_name=$get_city_state_country->State_name;
								$City_name=$get_city_state_country->City_name;
								$Country_name=$get_city_state_country->Country_name;
					
								$result = $this->Online_api_model->Get_outlet_details($Pos_outlet_id,$Company_id); //Get Outlet Details
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
							
										$Trans_type = 12;
										$Trans_Channel_id = 12;
										$Payment_type_id = $Pos_payment_type;
										if($Payment_type_id == Null)
										{
											$Payment_type_id = 1;
										}
										$Remarks = "3rd Party Online";
										
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
													
												
													$ItemDetails = $this->Online_api_model->Get_item_details($ItemCode,$Company_id);
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
														$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
														
														$ResponseData1 = array("Error_flag" => 3103,
																			"Message" => "Invalid Item_Num Or Item not exist.",
																			"Item_Num" => $ItemCode,
																			"Membership_id" => $CardId,
																			"Member_name" => $Memeber_name,
																			"Bill_no" => $Pos_bill_no,
																			"Bill_total" => number_format($Pos_bill_amount,2),
																			// "POS_discount" => number_format(0,2),
																			// "Discount_amount" => number_format(0,2),
																			"Points_amount" => number_format(0,2),
																			"Voucher_amount" => number_format(0,2),
																			"Balance_due" => number_format($Pos_bill_amount,2),
																			"Gained_points" => 0,
																			"Current_balance" => $Current_bal1
																		); // Item not found or invalid item code
														echo json_encode($ResponseData1);
														exit;
													}
												
													$DiscountResult = $this->Online_api_model->get_discount_value("",$ItemCode,$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,0,$API_flag_call);
													
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
												$Item_price = $Itemcategory_price[$Itemcategory_id];
												
												$CatDiscountResult = $this->Online_api_model->get_category_discount_value($Itemcategory_id,"",$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,0,0,$API_flag_call);
													
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
									
											$DiscountResult12 = $this->Online_api_model->get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,$order_sub_total,$API_flag_call);
											
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
									 
									 $Pos_discount_amount = $Pos_discount+$Pos_loyalty_discount+$Pos_voucher_amount+$Pos_giftcard_amount; //09-04-2021
									
									$grand_total = ($Pos_bill_amount-$Pos_points_amount)-$Pos_discount_amount;
									
									if($grand_total < 0 )
									{
										$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
										
										$Result1327 = array("Error_flag" => 2066,
															"Message" => "Total discount amount and points amount is more than bill amount.",
															"Membership_id" => $CardId,
															"Member_name" => $Memeber_name,
															"Bill_no" => $Pos_bill_no,
															"Bill_total" => number_format($Pos_bill_amount,2),
															// "POS_discount" => number_format(0,2),
															// "Discount_amount" => number_format($Pos_discount_amount,2),
															// "Redeem_amount" => number_format($Pos_points_amount,2),
															"Points_amount" => number_format($Pos_points_amount,2),
															"Voucher_amount" => number_format($Pos_voucher_amount,2),
															"Balance_due" => number_format($Pos_bill_amount,2),
															"Gained_points" => 0,
															"Current_balance" => $Current_bal1
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
													$result = $this->Online_api_model->Get_merchandize_item($Item_code,$Company_id);
													
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
													
													$Item_branch = $this->Online_api_model->get_items_branches($Company_merchandize_item_code,$Merchandize_partner_id,$Company_id);
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
														$Seller_result = $this->Online_model->Get_Seller_details($sellerID,$Company_id);	
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
														
														$loyalty_prog = $this->Online_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
														
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
																
															$lp_details = $this->Online_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);
															
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
																					$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Trans_Channel_id == $Trans_Channel )
																	{
																		$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[0]);
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
																					$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}

																	}
																	
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Lp_Payment_Type_id == $Payment_type_id)
																	{
																		$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[0]);
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
																					$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}
																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Merchandize_category_id == $Category_id )
																	{
																		$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[0]);
																		$points_array[] = $loyalty_points;
																		$gained_points_fag = 1;
																		$trans_lp_id = $LoyaltyID_array[0];
																		$Applied_loyalty_id[]=$trans_lp_id;
																	}						
																// unset($dis);
																}
																else if($Segment_flag==1)
																{											
																	$Get_segments2 = $this->Online_model->edit_segment_id($Company_id,$Segment_id);
																	
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
																		
																		$Get_segments = $this->Online_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
																		
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
																						$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																						$trans_lp_id = $LoyaltyID_array[$i];
																						$Applied_loyalty_id[]=$trans_lp_id;
																						$gained_points_fag = 1;
																						$points_array[] = $loyalty_points;
																					}
																				}
																				else if($transaction_amt > $value[$i])
																				{
																					$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																					$gained_points_fag = 1;
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;					
																					$points_array[] = $loyalty_points;
																				}
																			}
																		}									
																		if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
																		{	
																			$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[0]);
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
																					$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																					$trans_lp_id = $LoyaltyID_array[$i];
																					$Applied_loyalty_id[]=$trans_lp_id;
																					$gained_points_fag = 1;
																					$points_array[] = $loyalty_points;
																				}
																			}
																			else if($transaction_amt > $value[$i])
																			{
																				$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[$i]);
																				$gained_points_fag = 1;
																				$trans_lp_id = $LoyaltyID_array[$i];
																				$Applied_loyalty_id[]=$trans_lp_id;					
																				$points_array[] = $loyalty_points;
																			}
																		}
																	}

																	if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2  && $Trans_Channel == 0 && $Lp_Payment_Type_id == 0)
																	{
																		$loyalty_points = $this->Online_model->get_discount($transaction_amt,$dis[0]);
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
														$result = $this->Online_model->Get_Seller($Super_seller_flag,$Company_id);				   
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
													
													$PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$Weighted_points_amount-$Weighted_discount_amount;
													
												//***********18-04-2020-allow to redeem 1 point extra****************/
													
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
																		'Order_no' => $Pos_order_no,
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
																		'Voucher_discount' => $Pos_voucher_amount,
																		'GiftCardNo' => $Pos_giftcard_no,
																		'Channel_id' => $ChannelCompanyId
																	);	

															$Transaction_detail = $this->Online_model->Insert_online_purchase_transaction($data123);
													
													if($Transaction_detail)
													{
													/******Insert online purchase log tbl entery*******/	
														$Company_id	= $Company_id;
														$Todays_date = date('Y-m-d');	
														$opration = 1;		
														$enroll	= $cust_enrollment_id;
														$username = $User_email_id;
														$userid=1;
														$what="3rd Party Online";
														$where="3rd Party Online Ordering Api";
														$To_enrollid =$cust_enrollment_id;
														$firstName =$fname;
														$lastName =$lname; 
														$Seller_name =$fname.' '.$lname;
														$opval = $Merchandize_item_name.', (Item Code = '.$Company_merchandize_item_code.', Quantity= '.$Pos_item_qty.' )';
														$result_log_table = $this->Online_api_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
													/***Insert online purchase log tbl entery******/
													}
													
													$loyalty_prog = $this->Online_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
													$lp_count = count($loyalty_prog);

													if(count($Applied_loyalty_id) != 0)
													{		
														for($l=0;$l<count($Applied_loyalty_id);$l++)
														{
															$Get_loyalty = $this->Online_model->Get_loyalty_details_for_online_purchase($Applied_loyalty_id[$l]);

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
															$child_result = $this->Online_model->insert_loyalty_transaction_child($child_data);
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
												/***********09-04-2021 update gift card******************/
													$redeemed_giftcard = $Pos_giftcard_no;
													
													if($redeemed_giftcard != Null)
													{
														$giftData1["Card_balance"] = 0;
														$giftData1["Update_user_id"] = $Pos_outlet_id1;
														$giftData1["Update_date"] = date('Y-m-d H:i:s');

														$this->db->where(array("Gift_card_id"=>$redeemed_giftcard,"Company_id"=>$Company_id));
														$this->db->update("igain_giftcard_tbl",$giftData1);		
													}
												/***********09-04-2021 update gift card******************/
												/***************Update gift card and vouchers 23-2-2021********************/
													$Order_date = date('Y-m-d');	
													$lvp_date_time = date("Y-m-d H:i:s");
											/**********************Stamp offer logic 02-02-2021**************************/
												if($Stamp_item_flag == 1)
												{ 
													$Product_offers = $this->Online_api_model->get_product_offers($Merchandise_item_id,$Merchandize_category_id,$Company_id,$seller_id);
													
													if($Product_offers != null)
													{		
														foreach($Product_offers as $offer)
														{	
															$Offers_items = $this->Online_api_model->get_offer_selected_items($offer['Offer_code'],$Company_id);
															// print_r($Offers_items);
															$Total_item_purchase = array();
															if($Offers_items != NULL)
															{
																foreach($Offers_items as $rec)
																{
																	$Total_item_purchase[] = $this->Online_api_model->get_item_purchase_count($rec->Company_merchandize_item_code,$Company_id,$Customer_enroll_id,$offer['From_date'],$offer['Till_date']);
																}
															}
															
															$Total_count_item= array_sum($Total_item_purchase);	
															
															if($Total_count_item >= $offer['Buy_item'])
															{
																$Total_sent_voucher = $this->Online_api_model->member_sent_offers($Company_id,$Customer_enroll_id,$offer['Offer_code'],$offer['Free_item_id']);
																
																$Voucher_count = floor($Total_count_item/$offer['Buy_item']);
																
																$Need_to_Send_Voucher = ($Voucher_count-$Total_sent_voucher);
																
																for($A=1;$A<= $Need_to_Send_Voucher;$A++)
																{
																	$characters = '0123456789';
																	$string = '';
																	$ProductVoucher_no="";
																	for ($i = 0; $i < 10; $i++) 
																	{
																		$ProductVoucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
																	}
																	
																	$FreeItem = $this->Online_api_model->get_offer_free_items($offer['Offer_code'],$Company_id);
																	
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
																		
																		$this->Online_api_model->insert_product_voucher($data76);
																	}
													
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
																	
																	$this->Online_api_model->insert_voucher_in_gift_card($data77);
															//****insert in gift card tbl ***********
															//****now send product voucher notification *****************
																			
																$Email_content76 = array
																	( 
																		'Notification_type' => $seller_name.' Voucher',
																		'Transaction_date' => $lvp_date_time,
																		'Symbol_of_currency' => $Symbol_currency,
																		'Orderno' => $bill,	
																		'Outlet_address' => $Outlet_address,
																		'CustEmail' => App_string_decrypt($User_email_id),
																		'Voucher_no' => $ProductVoucher_no,
																		'Description' => "You have collected ".$offer['Buy_item']." Stamps from ".$seller_name." and recieved voucher for a ".$offer['Offer_name']." on us. <br><br> Present this voucher code to the cashier to redeem your ".$offer['Free_item']." ".$offer['Offer_name']."*",
																		'Voucher_validity' => date("Y-m-d",strtotime("+$Stamp_voucher_validity days")),
																		'Template_type' => 'Product_voucher',
																		'Brand_name' => $seller_name
																	);
																	
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
										/**************new logic with pos items*****************/
										/************* Update Current Balance ******************/
											$cid = $CardId;							
											$redeem_point = $Cust_redeem_point;	
											$Update_Current_balance = ($bal - $redeem_point + $total_loyalty_email);
											
											$Update_total_purchase = $total_purchase + $subtotal;
											$Update_total_reddems = $Total_reddems + $Cust_redeem_point;
											$up = array('Current_balance' => $Update_Current_balance, 'total_purchase' => $Update_total_purchase, 'Total_reddems' => $Update_total_reddems,'pinno_used' => 1);
												
											$this->Online_model->update_cust_balance($up,$cid,$Company_id);	
											
											$bill_no = $bill + 1;
											$billno_withyear = $str.$bill_no;
											$result4 = $this->Online_model->update_billno($seller_id,$billno_withyear);
										/*********** Update Current Balance ***************/
										
										$lvp_date_time = date("Y-m-d H:i:s");    
										
										$Email_content = array
										(
											// 'Notification_type' => 'Thank you for your Pos Purchase on '.$Pos_outlet_name,
											'Notification_type' => 'Online Order',
											'Transaction_date' => $lvp_date_time,
											'Orderno' => $Pos_order_no,
											'Pos_billno' => $Pos_bill_no,
											// 'Voucher_array' => $Voucher_array,  
											'Voucher_array' => $Pos_voucher_no, 
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
											'Delivery_type' => 3, 
											'DeliveryOutlet' => $Pos_outlet_id1, 
											'Outlet_address' => $Outlet_address, 
											'Bill_items' => $Pos_bill_items, 
											// 'DiscountAmt' => $Pos_discount_amount,
											'DiscountAmt' => 0,
											'VoucherDiscountAmt' => $Pos_voucher_amount,  
											'Template_type' => '3rd_Party_Purchase_order' 
										);	
										
									$Notification=$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,'0',$Company_id); 
									
									// $Discount_codes = $this->session->userdata('Discount_codes'); //print_r($Discount_codes);
									
									$DiscountResultVal = $this->Online_api_model->get_payment_type_discount_value($Payment_type_id,$Company_id,$Pos_outlet_id,$Customer_enroll_id,$lv_member_Tier_id,$grand_total);
									
									
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
										$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
										
										$Result123 = array(
													"Error_flag" => 1001,
													"Message" => "Successful",
													"Membership_id" => $CardId,
													"Member_name" => $Memeber_name,
													"Bill_no" => $Pos_bill_no,
													"Bill_total" => number_format($subtotal,2),
													// "POS_discount" => number_format($Pos_discount,2),
													// "Discount_amount" => number_format($Pos_discount_amount,2),
													"Points_amount" => number_format($EquiRedeem,2),
													"Voucher_amount" => number_format($Pos_voucher_amount,2),
													"Balance_due" => number_format($grand_total,2),
													"Gained_points" => $total_loyalty_email,
													"Current_balance" => round($Available_Balance)
													// 'Discount_details' => $Discount_codes  //discount voucher recived
												);
									/******************11-12-2020 insert JSON*****************/
											$inputArgs1 = json_encode($inputArgs);
											$outputArgs1 = json_encode($Result123);
											
											$Json_data = array('Company_id' => $Company_id,
																'Trans_type' => $Trans_type,
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
										$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
										
										$Result124 = array(
													"Error_flag" => 2068,
													"Message" => "POS Loyalty transaction failed",
													"Membership_id" => $CardId,
													"Member_name" => $Memeber_name,
													"Bill_no" => $Pos_bill_no,
													"Bill_total" => number_format($Pos_bill_amount,2),
													// "POS_discount" => number_format(0,2),
													// "Discount_amount" => number_format(0,2),
													"Points_amount" => number_format(0,2),
													"Voucher_amount" => number_format(0,2),
													"Balance_due" => number_format($Pos_bill_amount,2),
													"Gained_points" => 0,
													"Current_balance" => round($Current_bal1)
												);
												
											echo json_encode($Result124);  // Loyalty Transaction Failed
											exit;
									}
								}
								else
								{
									$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
									
									$Result3100 = array(
													"Error_flag" => 2009,
													"Message" => "Invalid outlet no.",
													"Membership_id" => $CardId,
													"Member_name" => $Memeber_name,
													"Bill_no" => $Pos_bill_no,
													"Bill_total" => number_format($Pos_bill_amount,2),
													// "POS_discount" => number_format(0,2),
													// "Discount_amount" => number_format(0,2),
													"Points_amount" => number_format(0,2),
													"Voucher_amount" => number_format(0,2),
													"Balance_due" => number_format($Pos_bill_amount,2),
													"Gained_points" => 0,
													"Current_balance" =>$Current_bal1
												);
												
									echo json_encode($Result3100); //Unable to Locate Merchant Email id 
									exit;
								}
							}
							else
							{
								$delete_temp_cart = $this->Online_api_model->delete_pos_temp_cart_data($Company_id,$Cust_enrollement_id,$delivery_outlet,$ChannelCompanyId);
								
								$Result127 = array(
													"Error_flag" => 2003,
													"Message" => "Invalid or unable to locate membership id",
													"Membership_id" => null,
													"Member_name" => null,
													"Bill_no" => $Pos_bill_no,
													"Bill_total" => number_format($Pos_bill_amount,2),
													// "POS_discount" => number_format($Pos_discount,2),
													// "Discount_amount" => number_format($Pos_loyalty_discount,2),
													"Points_amount" => number_format(0,2),
													"Voucher_amount" => number_format(0,2),
													"Balance_due" => number_format($Pos_bill_amount-$Pos_loyalty_discount-$Pos_discount,2),
													"Gained_points" => 0,
													"Current_balance" => 0
												);
												
								echo json_encode($Result127); //Unable to Locate membership id
								exit;
							}
						}
					}
					else
					{
						$Result3107 = array("Error_flag" => 3107,
						"Message"=>"Invalid Channel password Or Channel does not exist");
						echo json_encode($Result3107);
						exit;
					}
				}
				else
				{
					$Result128 = array("Error_flag" => 2002,
					"Message"=>"Invalid company password");
					echo json_encode($Result128); // Invalid Company Password
					exit;
				}
			}
			else
			{
				$Result129 = array("Error_flag" => 2001);
				$this->output->set_output(json_encode($Result129)); // Invalid Company User Name
			}
		}
	}
	public function cal_redeem_amt_contrl($How_much_point_reedem,$Seller_reedemtion_ratio,$Total_bill_amount)
	{
		$Redeem_amount = ($How_much_point_reedem/$Seller_reedemtion_ratio); //.toFixed(2);
		
		$abc = round(1/$Seller_reedemtion_ratio);	// 18-04-2020
		
		if($How_much_point_reedem!="")
		{
			$Redeem_amount = ($How_much_point_reedem/$Seller_reedemtion_ratio);	
		}	
		//*******18-04-2020************//
		$bb = ($Redeem_amount - $Total_bill_amount);  // 18-04-2020
		$Redeem_amount2 = $Total_bill_amount - $Redeem_amount;  // 18-04-2020
		if($bb >= $abc)
		{
			$Error_flag = 0000; //Equivalent Redeem Amount is More than Total Bill Amount
			$result12 =$Error_flag;
		}
		else if($Redeem_amount2 < 0)
		{
			$Redeem_amount = $Total_bill_amount;
			$result12 = $Redeem_amount;   //Adjust 1 point here..allow to redeem 1 point extra
		}
		//*******18-04-2020************//
		else if($Redeem_amount<=$Total_bill_amount)
		{
			$result12 = $Redeem_amount; // Successfull
		}
		else if($Redeem_amount > $Total_bill_amount) 
		{
		  $Error_flag = 0000; //Equivalent Redeem Amount is More than Total Bill Amount
		 
		  $result12 =$Error_flag;
		}
	
		return $result12;
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
}		 		
?>