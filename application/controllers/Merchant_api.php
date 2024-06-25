<?php 
   class Merchant_api extends CI_Controller 
   {
		public function __construct()
		{
				parent::__construct();		
				$this->load->library('form_validation');		
				$this->load->database();
				$this->load->helper('url');
				$this->load->library('session');
				$this->load->model('Merchant_api_model');	
		}
		public function index() 
		{ 	
			$this->load->view('find_pos'); 
		}
		
		/********API Call 1 Get Member Details Name and point Balance************/
		
		public function get_member()
		{ 
			$Company_id = $this->input->get("Company_id");
			$API_key = $this->input->get("API_key");			
			$result = $this->Merchant_api_model->check_company_key_valid($Company_id, $API_key);// Check Company Key validation
			
			$company_key = $result->Company_key;
			
			if($API_key == $company_key)
			{
				$cid = $this->input->get("Membership_id");
				//$phnumber = $this->input->get("Membership_id");
				$Country_id = 1; //pass Country_id manual hear
				$dial_code = $this->Merchant_api_model->get_dial_code($Country_id);	//Get Country Dial code from currancy_master		
				$phnumber = $dial_code.$this->input->get("Membership_id");
			
				/********* JSON CODE *********/
				$result = $this->Merchant_api_model->get_pos($cid,$Company_id,$phnumber); //Get Customer details
			
				if($result != NULL)
				{
					$this->output->set_output($result);
				}
				else    
				{
					$Result127[] = array("Error_flag" => 1);
					$this->output->set_output(json_encode($Result127)); //Invalid Card Id
				}
			}
			else
			{
				$Result128[] = array("Error_flag" => 2);
				$this->output->set_output(json_encode($Result128)); // Invalid Company Key
			}
		}
		
		/*****************API Call 2 Calculate Reedem Amount Conroller****************/
		
		public function cal_redeem_amt_contrl()
		{
			$Current_balance = $this->input->get('Current_balance');
			$Purchase_amount = $this->input->get('Purchase_amount');
			$Redeem_points = $this->input->get('Redeem_points');
			$mechant_emailid =  $this->input->get('Merchant_email_id');
			$company_id =  $this->input->get('Company_id');
			$input_Company_key = $this->input->get('API_key');
			
			$result = $this->Merchant_api_model->check_company_key_valid($company_id,$input_Company_key); //Check Company Key Validation
			
			$Company_key = $result->Company_key;
			
			if($input_Company_key == $Company_key)
			{
			  
			  $result1 = $this->Merchant_api_model->Get_Seller($mechant_emailid,$company_id); //Get Merchant redemption ratio
			  $Seller_Redemptionratio = $result1->Seller_Redemptionratio;
			
				if($Redeem_points <= $Current_balance)
				{
					
					$calculate = $this->Merchant_api_model->cal_redeem_amt_contrl($Redeem_points,$Seller_Redemptionratio,$Purchase_amount);
					
					if($calculate != NULL)
					{
						$this->output->set_output($calculate);
					}
					else    
					{
						$Result21[] = array('Error_flag' => 6); // Invalid input provide
						$this->output->set_output(json_encode($Result21));
					}
				}
				else
				{ 
					$Result12[] = array('Error_flag' => 3); //Insufficient Point Balance
					$this->output->set_output(json_encode($Result12));
					//$this->output->set_output("Error_flag 3"); //Insufficient Point Balance 
				}
			}
			else
			{
				$Result126[] = array("Error_flag" => 2);
				$this->output->set_output(json_encode($Result126)); //Invalid Company Key
				// $this->output->set_output("2"); //Invalid Company Key
			}
		}
		
		/*******API Call 3 Loyalty Purchase Transaction*******/
		
		public function purchase_transaction()
		{
		  $input_Company_key = $this->input->get('API_key');
		  $company_id = $this->input->get('Company_id');
			
			$result1 = $this->Merchant_api_model->check_company_key_valid($company_id,$input_Company_key); //Check Company Key Validation
			
			$Company_key = $result1->Company_key;
			
			if($input_Company_key == $Company_key)
			{
				if($_GET == NULL)
				{
					//redirect('Merchant_api/find_pos');
				}
				else	
				{
					$gained_points_fag = 0;
			
					$Company_id = $this->input->get('Company_id');
				
					$cardId = $this->input->get('Membership_id');
					
					$Country_id = 1;
					$dial_code = $this->Merchant_api_model->get_dial_code($Country_id);//Get Country Dial code 			
					$phnumber = $dial_code.$this->input->get("Membership_id");
			
					$cust_details = $this->Merchant_api_model->cust_details_from_card($Company_id,$cardId,$phnumber);//Get Customer details
				
					foreach($cust_details as $row25)
					{
										$CardId=$row25['Card_id'];
										$fname=$row25['First_name'];
										$midlename=$row25['Middle_name'];
										$lname=$row25['Last_name'];
										$bdate=$row25['Date_of_birth'];
										$address=$row25['Current_address'];
										$bal=$row25['Current_balance'];
										$Blocked_points=$row25['Blocked_points'];
										$phno=$row25['Phone_no'];
										$pinno=$row25['pinno'];
										$companyid=$row25['Company_id'];
										$cust_enrollment_id=$row25['Enrollement_id'];
										$image_path=$row25['Photograph'];				
										$filename_get1=$image_path;	
										$Tier_name = $row25['Tier_name'];
										$lv_member_Tier_id = $row25['Tier_id'];
					}
				
				 $Merchant_email_id = $this->input->get('Merchant_email_id');
				
				 $result = $this->Merchant_api_model->Get_Seller($Merchant_email_id,$Company_id); //Get Merchant Details
			   
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
								$transaction_amt = $this->input->get("Purchase_amount");
							}
							
							if($lp_type == 'BA')
							{
								$transaction_amt = $this->input->get("Balance_to_pay");
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
			
		 	$data = array('Company_id' => $Company_id,
							'Trans_type' => $Trans_type,
							'Payment_type_id' => $Payment_type_id,
							'Manual_billno' => $this->input->get('Manual_bill_no'),
							'Bill_no' => $bill,
							'Enrollement_id' => $cust_enrollment_id,
							//'Card_id' => $this->input->post('CardId'),
							'Card_id' => $CardId,
							'Seller' => $seller_id,
							'Seller_name' => $seller_name,
							'Trans_date' => $lv_date_time,
							'Remarks' => $Remarks,
							'Purchase_amount' => $this->input->get('Purchase_amount'), 
							'Paid_amount' => $this->input->get('Balance_to_pay'),
							'Redeem_points' => $this->input->get('Redeem_points'),
							//'Loyalty_pts' => $loyalty_pts,
							'Loyalty_pts' => $total_loyalty_points,
							'Loyalty_id' => $trans_lp_id, 
							//'balance_to_pay' => $this->input->post('pay_amt')
							'balance_to_pay' => $this->input->get('Balance_to_pay'),
						
						);
							//$Customer_enroll_id = $this->input->post('Enrollement_id');
							$Customer_enroll_id = $this->input->get('Cust_Enrollement_id');
							
						    $insert_transaction_id = $this->Merchant_api_model->purchase_transaction($data);
							
							
							
							$result11 = $this->Merchant_api_model->update_loyalty_transaction_child($Company_id,$lv_date_time,$seller_id,$cust_enrollment_id,$insert_transaction_id);
							
							/********* Update Current Balance *********/
								
							//$cid = $this->input->post('CardId');
							$cid = $this->input->get('Membership_id');
							//$Current_balance = $this->input->post('Current_balance');
							//$redeem_point = $this->input->post('points_redeemed');
							$redeem_point = $this->input->get('Redeem_points');
							//$point_redeem = $Current_balance - $redeem_point + $loyalty_pts; 
							$Update_Current_balance = $bal - $redeem_point + $total_loyalty_points;
							$up = array('Current_balance' => $Update_Current_balance);
							$this->Merchant_api_model->update_transaction($up,$CardId,$Company_id);
							
							$bill_no = $bill + 1;
							$billno_withyear = $str.$bill_no;
							$result4 = $this->Merchant_api_model->update_billno($seller_id,$billno_withyear);
							
						if($insert_transaction_id > 0)
						{  
							//$transaction_flag = 1;
							$Result123[] = array("Error_flag" => 0, "Update_Current_balance" => $Update_Current_balance);
							$this->output->set_output(json_encode($Result123)); //Loyalty Transaction done Successfully
						}
						else    
						{
							$Result124[] = array("Error_flag" => 5);
							$this->output->set_output(json_encode($Result124)); // Loyalty Transaction Failed
							//$transaction_flag = 0;
						}	
				}
			}
			else
			{
				$Result125[] = array("Error_flag" => 2);
				$this->output->set_output(json_encode($Result125)); //Invalid Company Key
			}
		}
		/*****Check Company Key*****/
		public function check_company_key()
		{
			$result = $this->Merchant_api_model->check_company_key($this->input->get("compkey_key"));
		
			if($result > 0)
			{
				$this->output->set_output("Already Exist");
			}
			else    
			{
				$this->output->set_output("Available");
			}
		}
		/*****Check Merchant Key*****/
		public function check_merchant_email()
		{
			$merchant_email = $this->input->get("merchant_email");
			$Company_id = $this->input->get("Company_id");
			
			$result = $this->Merchant_api_model->check_merchant_email($merchant_email, $Company_id );
		
			if($result > 0)
			{
				$this->output->set_output("Already Exist");
			}
			else    
			{
				$this->output->set_output("Available");
			}
		}
		
		/**** Check Existing ManualBill no ****/
		public function check_bill_no()
		{
			
			$merchant_email = $this->input->get("merchant_email");
			$Company_id = $this->input->get("Company_id");
			// $Company_id = 59;
			
			$result123 = $this->Merchant_api_model->Get_Seller($merchant_email,$Company_id);
			
			$seller_id = $result123->Enrollement_id;
			
			$manual_bill_no = $this->input->get("Bill_no");
			
			$result = $this->Merchant_api_model->check_bill_no($manual_bill_no,$seller_id );
		
			if($result > 0)
			{
				$this->output->set_output("Already Exist");
			}
			else    
			{
				$this->output->set_output("Available");
			}
		}
		
	}		 		
?>