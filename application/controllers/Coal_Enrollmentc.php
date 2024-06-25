<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coal_Enrollmentc extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');	
		$this->load->model('Coal_enrollment/Coal_Enroll_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('Igain_model');
		$this->load->model('master/currency_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->library('Send_notification');
	}

	//************* akshay work start *************************************

	function fastenroll()
	{
			$this->load->model('Coal_enrollment/Coal_Enroll_model');
		if($this->session->userdata('logged_in'))
		{
				$session_data = $this->session->userdata('logged_in');
				$data['username'] = $session_data['username'];
				$data['enroll'] = $session_data['enroll'];
				$data['userId']= $session_data['userId'];
				$data['Company_id']= $session_data['Company_id'];
				$Company_id = $session_data['Company_id'];
				$data['timezone_entry'] = $session_data['timezone_entry'];
				$data['Country_id'] = $session_data['Country_id'];
				$data['LogginUserName'] = $session_data['Full_name'];
				$data['Super_seller']= $session_data['Super_seller'];
				$data['next_card_no']= $session_data['next_card_no'];
				$data['card_decsion']= $session_data['card_decsion'];
				$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
				$data['LogginUserName'] = $session_data['Full_name'];
				$SuperSellerFlag = $session_data['Super_seller'];
				$Logged_in_userid = $session_data['enroll'];

				$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
				$Seller_topup_access = $resultis->Seller_topup_access;
				$Partner_company_flag = $resultis->Partner_company_flag;
				$Joining_bonus_flag = $resultis->Joining_bonus;
				$Joining_bonus_points = $resultis->Joining_bonus_points;
				$Coalition = $resultis->Coalition;

				$data["Company_details"] = $resultis;

				$Seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				$data['Refrence'] = $Seller_details->Refrence;

				$referral_rule_count = $this->Coal_Enroll_model->enroll_referralrule_count($Company_id,$data['enroll']);
				$data["referral_rule_count"] = $referral_rule_count;
				
				$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
				
				if($_POST == NULL)
				{
					$this->load->view('Coal_enrollment/fastenroll', $data);
				}
				else
				{
						if($data['userId'] == 3)
						{
								if($Partner_company_flag == 0)
								{
										$top_seller = $this->Transactions_model->get_top_seller($data['Company_id']);
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
								$user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
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

								$logtimezone = $session_data['timezone_entry'];
								$timezone = new DateTimeZone($logtimezone);
								$date = new DateTime();
								$date->setTimezone($timezone);
								$lv_date_time=$date->format('Y-m-d H:i:s');
								$Todays_date = $date->format('Y-m-d');

								$referre_enrollID = $this->input->post("Refree_name");
								$referre_membershipID = substr(strrchr($referre_enrollID, "-"), 1);

								if($referre_membershipID > 0)
								{
										$Referral_rule_for = 1; //*** Referral_rule_for enrollment
										$Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for);

										if($Ref_rule != "")
										{
												foreach($Ref_rule as $rule)
												{
														$ref_start_date = $rule['From_date'];
														$ref_end_date = $rule['Till_date'];
														//$ref_Tier_id = $rule['Tier_id'];

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

										$topup_BillNo = $tp_bill + 1;
										$billno_withyear_ref = $str.$topup_BillNo;
										$Enrolled_Card_id=$this->input->post('cardid');

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


												if($Enrolled_Card_id!="")
												{
																$refree_current_balnce = $ref_card_bal + $ref_topup;
																$refree_topup = $ref_topup_amt + $ref_topup;

																$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);

																$seller_curbal = $seller_curbal - $ref_topup;
																if($Coalition == 1 )
																{
																		$SellerID =0;
																}
																else
																{
																		$SellerID = $seller_id;
																}

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
																
																

																if($Seller_topup_access=='1')
																{
																		$Total_seller_bal = $seller_curbal;

																		$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
																}

																$customer_name = $this->input->post('fname')." ".$this->input->post('lname');

																$Email_content12 = array(
																		'Ref_Topup_amount' => $ref_topup,
																		'Notification_type' => 'Referral Topup',
																		'Template_type' => 'Referral_topup',
																		'Customer_name' => $customer_name,
																		'Todays_date' => $Todays_date
																);


																if($Coalition == 1 )
																{
																		$this->send_notification->Coal_send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
																}
																else
																{
																		$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
																}
															$tp_bill=$tp_bill+1;
															$billno_withyear_ref = $str.$tp_bill;
												}

								}

						/************ Referral Bonus **************/



						$cardid = $this->input->post('cardid');

						if($Joining_bonus_flag == 1 && $cardid != "")
						{
								$Customer_topup12 =($Customer_topup12+$Joining_bonus_points);

						}
						$result = $this->Coal_Enroll_model->fastenroll($Customer_topup12,$ref_Customer_enroll_id);
						$Last_enroll_id=$result;
						$customer_name = $this->input->post('fname')." ".$this->input->post('lname');
								/************ Referee Bonus **************/
								if($referre_membershipID != "" && $Seller_Refrence == 1 && $Customer_topup > 0 && $Enrolled_Card_id!="")
								{


												$seller_curbal = $seller_curbal - $Customer_topup;
												if($Coalition == 1 )
												{
														$SellerID =0;
												}
												else
												{
														$SellerID = $seller_id;
												}
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
												

												if($Seller_topup_access=='1')
												{
														$Total_seller_bal = $seller_curbal;

														$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
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
														$this->send_notification->Coal_send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
												}
												else
												{
														$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
												}
										$tp_bill=$tp_bill+1;
										$billno_withyear_ref = $str.$tp_bill;
								}
								/************ Referee Bonus **************/


						/**************************AMIT**** Joining Bonus start*******************/
						// Joining_bonus_points

								if($Joining_bonus_flag == 1 && $cardid != "")
								{

									

										if($Coalition == 1 )
										{
												$SellerID =0;
										}
										else
										{
												$SellerID = $seller_id;
										}
										$post_Transdata = array(
										'Trans_type' => '1',
										'Company_id' => $Company_id,
										'Topup_amount' => $Joining_bonus_points,
										'Trans_date' => $lv_date_time,
										'Remarks' => 'Joining Bonus',
										'Card_id' => $this->input->post('cardid'),
										'Seller_name' => $Seller_name,
										'Seller' => $SellerID,
										'Enrollement_id' => $Last_enroll_id,
										'Bill_no' => $tp_bill,
										'remark2' => $remark_by,
										'Loyalty_pts' => '0'
										);

										$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);

										

										if($Seller_topup_access=='1')
										{
												$seller_curbal = ($Total_seller_bal - $Joining_bonus_points);
												$Total_seller_bal2 = $seller_curbal;
												$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal2);
										}

								$customer_name = $this->input->post('fname')." ".$this->input->post('lname');

										$Email_content12 = array(
												'Joining_bonus_points' => $Joining_bonus_points,
												'Notification_type' => 'Joining Bonus',
												'Template_type' => 'Joining_Bonus',
												'Customer_name' => $customer_name,
												'Todays_date' => $Todays_date
										);

										$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
										
										$tp_bill=$tp_bill+1;
										$billno_withyear_ref = $str.$tp_bill;	
								}

						/************ Joining Bonus end **************/
						
						/***************Send Freebies Merchandize items************/
						$Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1);
						
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
								$Voucher_status="Issued";
								
								if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
								{
										 $insert_data = array(
									'Company_id' => $Company_id,
									'Trans_type' => 10,
									'Redeem_points' => $Item_details->Billing_price_in_points,
									'Quantity' => 1,
									'Trans_date' => $lv_date_time,
									'Create_user_id' => $data['enroll'],
									'Seller' => $data['enroll'],
									'Seller_name' => $Seller_name,
									'Enrollement_id' => $Last_enroll_id,
									'Card_id' => $this->input->post('cardid'),
									'Item_code' => $Item_details->Company_merchandize_item_code,
									'Voucher_no' => $Voucher_no,
									'Voucher_status' => $Voucher_status,
									'Merchandize_Partner_id' => $Item_details->Partner_id,
									'Remarks' => 'Freebies',
									'Bill_no' => $tp_bill,
									'Merchandize_Partner_branch' => $Branch_code
										);
									 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
									
									  $Voucher_array[]=$Voucher_no;
									  
									  /**********Send freebies notification********/
										$Email_content124 = array(
														'Merchandize_item_name' => $Item_details->Merchandize_item_name,
														'Item_image' => $Item_details->Item_image1,
														'Voucher_no' => $Voucher_no,
														'Voucher_status' => $Voucher_status,
														'Notification_type' => 'Freebies',
														'Template_type' => 'Freebies',
														'Customer_name' => $customer_name,
														'Todays_date' => $Todays_date
												);
									$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content124,$Logged_in_userid,$Company_id);
								}
								
							}	
							$tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill;
							
						}
						$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
						/*********************Merchandize end*************************/
						// if($result == true)
						if($result > 0)
						{
								$Email_content = array(
										'Notification_type' => 'Enrollment Details',
										'Template_type' => 'Enroll'
								);
								$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$data['enroll'],$data['Company_id']);

								$this->session->set_flashdata("fastenroll_error_code","Enrollment Successfull!!");
						}
						else
						{
								$this->session->set_flashdata("fastenroll_error_code","Error Enrollment!!");
						}
					
						
					redirect(current_url());
					//$this->load->view('enrollment/fastenroll', $data);
					
				}
		}
		else
		{
				redirect('Login', 'refresh');
		}
	}
		
	function check_card_id()
	{
		$result = $this->Coal_Enroll_model->check_card_id($this->input->post("cardid"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}
	
	function check_phone_no()
	{
		$result = $this->Coal_Enroll_model->check_phone_no($this->input->post("Phone_no"),$this->input->post("Company_id"),$this->input->post("Country_id"));
		
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}
	
	function check_userEmailId()
	{
		$result = $this->Coal_Enroll_model->check_userEmailId($this->input->post("userEmailId"),$this->input->post("Company_id"),$this->input->post("userId"));
		
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}
	/*************************************Akshay end *******************************/
	
	/*************************************Ravi Start *******************************/	
	
	function get_redemption_ratio()
	{
		$result = $this->Igain_model->get_enrollment_details($this->input->post("Sub_sellerEnrollID"));
		// var_dump($result);
		if($result->Seller_Redemptionratio > 0)
		{
			// echo $data['result12'] = $result->Seller_Redemptionratio;
			// echo $data['result12'] = $result->Merchant_sales_tax;
			
			$this->output->set_output(json_encode(array('Seller_Redemptionratio'=>$result->Seller_Redemptionratio,'Merchant_sales_tax'=>$result->Merchant_sales_tax)));
			// echo json_encode($result->Seller_Redemptionratio);
			 //$this->output->set_output(json_encode($result['Seller_Redemptionratio']));
		}
		else    
		{
			return false;
		}
	}
	function enrollment()
	{
		if($this->session->userdata('logged_in'))
		{
			// $this->output->enable_profiler(true);
			$session_data = $this->session->userdata('logged_in');
			
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$Company_id = $session_data['Company_id'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points;
			$Coalition = $resultis->Coalition;
			$Allow_preorder_services = $resultis->Allow_preorder_services;
			$Allow_redeem_item_enrollment = $resultis->Allow_redeem_item_enrollment;
			
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			
			$data["Tier_list"] = $this->Coal_Enroll_model->get_lowest_tier($Company_id);
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			
			$referral_rule_count = $this->Coal_Enroll_model->enroll_referralrule_count($Company_id,$data['enroll']);
			$data["referral_rule_count"] = $referral_rule_count;			
				if($data['userId'] == 3)
				{
					
					if($Partner_company_flag == 0)
					{
						$top_seller = $this->Transactions_model->get_top_seller($data['Company_id']);
						
						if($top_seller)
						{
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
								$Seller_Country_id = $sellers['Country_id'];
								$Seller_name = $sellers['First_name']." ".$sellers['Middle_name']." ".$sellers['Last_name'];
							}
						}
						else
						{
							$Seller_Refrence = 0;
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
					$user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
					$seller_id = $user_details->Enrollement_id;
					$Purchase_Bill_no = $user_details->Purchase_Bill_no;
					$username = $user_details->User_email_id;
					$remark_by = 'By Seller';
					$seller_curbal = $user_details->Current_balance;
					$Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
					$Seller_Refrence = $user_details->Refrence;
					$Seller_Country_id = $user_details->Country_id;
					$Topup_Bill_no =  $user_details->Topup_Bill_no;
					$Seller_name = $user_details->First_name." ".$user_details->Middle_name." ".$user_details->Last_name;
					
					$top_db = $Topup_Bill_no;
					$len = strlen($top_db);
					$str = substr($top_db,0,5);
					$tp_bill = substr($top_db,5,$len);
					
					$topup_BillNo = $tp_bill + 1;
					$billno_withyear_ref = $str.$topup_BillNo;							
					
					
					if($user_details->Sub_seller_admin == 1)
					{
						$remark_by = 'By SubSeller';
					}
					else
					{
						$remark_by = 'By Seller';
					}					
				}
			
			$data["Seller_Refrence"] = $Seller_Refrence;			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
		
			$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
			
			$Seller_licences_limit=$resultis->Seller_licences_limit;
			$Partner_company_flag=$resultis->Partner_company_flag;

			
			if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
			{
				$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
			}
			else 
			{
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
				
			}	
			if($data['userId'] == '3'  && $session_data['Company_id'] =='1')  // Miraclecartes Admin and Selected Comp is Miraclecartes
			{
				$FetchedUserTypes = $this->Igain_model->FetchUserType();
			}
			else if($data['userId'] == '3' && $session_data['Company_id'] !='1'  && $Partner_company_flag=='1' )  // Miraclecartes Admin and Selected Comp is Partner Company
			{
				$CountTotalSeller = $this->Igain_model->CountTotalSeller($session_data['Company_id']);
				if($Seller_licences_limit >=  $CountTotalSeller)
				{
					$FetchedUserTypes = $this->Igain_model->FetchPartnerAdmin();									
				}
				else
				{
					$FetchedUserTypes = $this->Igain_model->FetchCustomer();
				}
				
			}
			else if($data['userId'] == '3' && $session_data['Company_id'] !='1'  && $Partner_company_flag=='0' )  // Miraclecartes Admin and Selected Comp is Partner Client Company
			{
				$CountTotalSeller = $this->Igain_model->CountTotalSeller($session_data['Company_id']);
				if($Seller_licences_limit >=  $CountTotalSeller)
				{
					$FetchedUserTypes = $this->Igain_model->FetchSellerAndCustomer();
										
				}
				else
				{
					$FetchedUserTypes = $this->Igain_model->FetchCustomer();
				}
				
				
			}			
			else if($data['userId'] == '4' && $data['Super_seller'] == '1'  && $Partner_company_flag =='1') // Partner Admin and Selected Comp is Partner(Self) Company
			{
				$CountTotalSeller = $this->Igain_model->CountTotalSeller($session_data['Company_id']);
				if($Seller_licences_limit >=  $CountTotalSeller)
				{
					$FetchedUserTypes = $this->Igain_model->FetchSellerAndCustomer();
										
				}
				else
				{
					$FetchedUserTypes = $this->Igain_model->FetchCustomer();
				}
			}
			else if($data['userId'] == '4' && $data['Super_seller'] == '1'  && $Partner_company_flag =='0') // Partner Admin and Selected Comp is Partner Client Company
			{
				$CountTotalSeller = $this->Igain_model->CountTotalSeller($session_data['Company_id']);
				if($Seller_licences_limit >=  $CountTotalSeller)
				{
					$FetchedUserTypes = $this->Igain_model->FetchSellerAndCustomer();
										
				}
				else
				{
					$FetchedUserTypes = $this->Igain_model->FetchCustomer();
				}
			}
			else if($data['userId'] == '2' && $data['Super_seller'] == '1'  && $Partner_company_flag =='0') // Company Admin
			{
				$CountTotalSeller = $this->Igain_model->CountTotalSeller($session_data['Company_id']);
				if($Seller_licences_limit >=  $CountTotalSeller)
				{
					$FetchedUserTypes = $this->Igain_model->FetchSellerAndCustomer();
										
				}
				else
				{
					$FetchedUserTypes = $this->Igain_model->FetchCustomer();
				}
			} 
			else
			{
				$FetchedUserTypes = $this->Igain_model->FetchCustomer();
			}			
			$data['Company_array'] = $FetchedCompanys;
			$data['UserType_array'] = $FetchedUserTypes;
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;			
			
			
			/*-----------------------Pagination---------------------*/		
			// $this->output->enable_profiler(true);			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_Enrollmentc/enrollment";
			
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->Coal_Enroll_model->enrollment_count();
				
			}
			else
			{
				$total_row = $this->Coal_Enroll_model->Company_enrollment_count($session_data['Company_id']);
			}
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
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			$data["Total_merchants"] = $this->Coal_Enroll_model->get_total_merchant($session_data['Company_id']);			
			if($_POST == NULL)
			{
				if($data['userId'] == '3' && $session_data['Company_id'] =='1' )
				{			
					
					$data["results"] = $this->Coal_Enroll_model->enrollment_list($config["per_page"], $page);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
				{
					$data["results"] = $this->Coal_Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '0'))
				{
					$enrollID=$data['enroll'];
					$data["results"] = $this->Coal_Enroll_model->Selected_company_enrollment_list_login_seller($config["per_page"], $page,$session_data['Company_id'],$enrollID);
				}
				else
				{
					$data["results"] = $this->Coal_Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
				}				
				$data["pagination"] = $this->pagination->create_links();
				
		
				$this->load->view('Coal_enrollment/Coal_enrollment', $data);
			}
			else
			{
				/****************Merchant Working Hours***********************/
				
				/****************Merchant Working Hours end***********************/
				
				
				$customer_name = $this->input->post('firstName')." ".$this->input->post('middleName')." ".$this->input->post('lastName');  
				/************ Referral Bonus **************/
					$Customer_topup12 = 0;
					$Refree_topup = 0;
					$ref_topup = 0;
					
					$logtimezone = $session_data['timezone_entry'];
					$timezone = new DateTimeZone($logtimezone);
					$date = new DateTime();
					$date->setTimezone($timezone);
					$lv_date_time=$date->format('Y-m-d H:i:s');
					$Todays_date = $date->format('Y-m-d');	
				
				
					$referre_enrollID = $this->input->post("Refree_name");
					$referre_membershipID = substr(strrchr($referre_enrollID, "-"), 1); 
					
					$billno_withyear_ref=$Topup_Bill_no;
					if($referre_membershipID > 0)
					{
						$Referral_rule_for = 1; //*** Referral_rule_for enrollment
						$Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for);
					
						if(count($Ref_rule) > 0)
						{
							foreach($Ref_rule as $rule)
							{
								$ref_start_date = $rule['From_date'];
								$ref_end_date = $rule['Till_date'];
								$ref_Tier_id = $rule['Tier_id'];
								
								if($ref_start_date <= $Todays_date && $ref_end_date >= $Todays_date)
								{
									$Customer_topup = $rule['Customer_topup'];
									$ref_topup = $rule['Refree_topup'];
								}
							}
						}
					}
				
					if($referre_membershipID > 0 && $Seller_Refrence == 1 && $ref_topup > 0 && $Coalition==0)
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
							$ref_member_Tier_id  = $row21['Tier_id'];
							$ref_name = $row21['First_name']." ".$row21['Middle_name']." ".$row21['Last_name'];
						}						
						if($ref_Tier_id == 0)
						{
							$ref_member_Tier_id = $ref_Tier_id;
						}						
						if($ref_member_Tier_id == $ref_Tier_id)
						{
							$refree_current_balnce = $ref_card_bal + $ref_topup;
							$refree_topup = $ref_topup_amt + $ref_topup;
				
							$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
							
							$seller_curbal = $seller_curbal - $ref_topup;
							
							
							/*******************Ravi Change-24-08-2016*********************************/
							if($Coalition == 1 )
							{
								$SellerID =0;
							} 
							else
							{
								$SellerID = $seller_id;
							}
							/*******************Ravi Change-24-08-2016*********************************/
							
							$post_Transdata = array
							(					
								'Trans_type' => '1',
								'Company_id' => $Company_id,
								'Topup_amount' => $ref_topup,        
								'Trans_date' => $lv_date_time,       
								'Remarks' => 'Referral Trans',
								'Card_id' => $referre_membershipID,
								'Seller' => $SellerID,
								'Seller_name' => $Seller_name,								
								'Enrollement_id' => $ref_Customer_enroll_id,
								'Bill_no' => $tp_bill,
								'remark2' => $remark_by,
								'Loyalty_pts' => '0'
							);							
							$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);						
							
							$Total_seller_bal = $seller_curbal;
							if($Seller_topup_access=='1')
							{
								$Total_seller_bal = $seller_curbal;								
								$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
							}							
							$customer_name = $this->input->post('firstName')." ".$this->input->post('middleName')." ".$this->input->post('lastName');  
			
							$Email_content12 = array
							(
								'Ref_Topup_amount' => $ref_topup,
								'Notification_type' => 'Referral Topup',
								'Template_type' => 'Referral_topup',
								'Customer_name' => $customer_name,
								'Todays_date' => $Todays_date
							);							
							if($Coalition == 1 )
							{
								$this->send_notification->Coal_send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
							}
							else
							{
								$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
							}
							$tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill;
						}
						
					}
					else
					{
						$ref_Customer_enroll_id = '0';
					}
					
				
				
				if(!$this->upload->do_upload("file"))
				{			
					$this->session->set_flashdata("enroll_error_code122","You did not select Photograph to Upload");
					$filepath = "images/No_Profile_Image.jpg";
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "uploads/".$data['upload_data']['file_name'];
				}				
				if($Joining_bonus_flag == 1 && $this->input->post('cardid') != "")
				{
					$Customer_topup12 =($Customer_topup12+$Joining_bonus_points);
				}
				$User_type_id = $this->input->post('User_id');
				$result = $this->Coal_Enroll_model->enrollment($filepath,$Customer_topup12,$ref_Customer_enroll_id);
				$Last_enroll_id=$result;
				
				
				/****************Merchant Working Hours***********************/
				if($User_type_id==2 && $this->input->post('Sub_seller_admin')==1 )
				{
					$Days = $this->input->post('Days');
					//echo "Last_enroll_id ".$Last_enroll_id;
					foreach($Days as $Days)
					{	
						//echo "<br>".$Days;
						if($Days==1)
						{
							$Open_time = $this->input->post('Mon_open');
							$Close_time = $this->input->post('Mon_close');
							
						}
						elseif($Days==2)
						{
							$Open_time = $this->input->post('Tues_open');
							$Close_time = $this->input->post('Tues_close');
						}
						elseif($Days==3)
						{
							$Open_time = $this->input->post('Wed_open');
							$Close_time = $this->input->post('Wed_close');
						}
						elseif($Days==4)
						{
							$Open_time = $this->input->post('Thurs_open');
							$Close_time = $this->input->post('Thurs_close');
						}
						elseif($Days==5)
						{
							$Open_time = $this->input->post('Fri_open');
							$Close_time = $this->input->post('Fri_close');
						}
						elseif($Days==6)
						{
							$Open_time = $this->input->post('Sat_open');
							$Close_time = $this->input->post('Sat_close');
						}
						else
						{
							$Open_time = $this->input->post('Sun_open');
							$Close_time = $this->input->post('Sun_close');
						}
						
							$Open_time  = date("H:i", strtotime($Open_time));
							$Close_time  = date("H:i", strtotime($Close_time));
							
						$Post_workdata = array
							(					
								'Seller_id' => $Last_enroll_id,
								'Day' => $Days,        
								'Open_time' => $Open_time,       
								'Close_time' => $Close_time
							
							);							
							$resultPost = $this->Coal_Enroll_model->insert_merchant_working_hours($Post_workdata);
							
							
					}	
					
				}
				//die;
				/****************Merchant Working Hours end***********************/
				
				
				
				
				
				/************ Referee Bonus **************/		
					if($referre_membershipID > 0 && $Seller_Refrence == 1 && $Customer_topup > 0 && $Coalition==0)
					{
					
						/********Ravi Cahnge 24-08-2016****Transaction Entry of Refferal bonus for New Customer**************************/
													
							
							if($Coalition == 1 )
							{
								$SellerID =0;
							}
							else
							{
								$SellerID = $seller_id;
							}
							$Cust_membershipID=$this->input->post('cardid');
							$post_Transdata12 = array
							(					
								'Trans_type' => '1',
								'Company_id' => $Company_id,
								'Topup_amount' => $Customer_topup,        
								'Trans_date' => $lv_date_time,       
								'Remarks' => 'Referral Trans',
								'Card_id' => $Cust_membershipID,
								'Seller' => $SellerID,
								'Seller_name' => $Seller_name,								
								'Enrollement_id' => $Last_enroll_id,
								'Bill_no' => $tp_bill,
								'remark2' => $remark_by,
								'Loyalty_pts' => '0'
							);							
							$result6 = $this->Transactions_model->insert_topup_details($post_Transdata12);						
							
							$seller_curbal12 = $seller_curbal - $Customer_topup;
							if($Seller_topup_access=='1')
							{
								$Total_seller_bal12 = $seller_curbal12;								
								$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal12);
							}

						/***********************Ravi Cahnge 24-08-2016*************************************************/
						
							$Email_content13 = array(
								'Ref_Topup_amount' => $Customer_topup,
								'Notification_type' => 'Referee Topup',
								'Template_type' => 'Referee_topup',
								'Customer_name' => $ref_name,
								'Todays_date' => $Todays_date
							);
							
						if($Coalition == 1 )
						{
							$this->send_notification->Coal_send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
						}
						else
						{
							 $this->send_notification->send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
						}	
						$tp_bill=$tp_bill+1;
						$billno_withyear_ref = $str.$tp_bill;
					}
			/************ Referee Bonus **************/	
			
			
				/**************************AMIT**** Joining Bonus start***********************************************************/
				// Joining_bonus_points 
					if($Joining_bonus_flag == 1 &&  $this->input->post('cardid') != "" && $User_type_id == 1 && $Coalition==0)
					{
						
						
						/*******************Ravi Change-24-08-2016*********************************/
						if($Coalition == 1 )
						{
							$SellerID =0;
						}
						else
						{
							$SellerID = $seller_id;
						}
						/*******************Ravi Change-24-08-2016*********************************/
						$post_Transdata = array(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $Joining_bonus_points,        
						'Trans_date' => $lv_date_time,       
						'Remarks' => 'Joining Bonus',
						'Card_id' => $this->input->post('cardid'),
						'Seller_name' => $Seller_name,
						'Seller' => $SellerID,						
						'Enrollement_id' => $Last_enroll_id,
						'Bill_no' => $tp_bill,
						'remark2' => $remark_by,
						'Loyalty_pts' => '0'
						);
						
						$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);
					
						
						
						if($Seller_topup_access=='1')
						{
							$seller_curbal = ($Total_seller_bal - $Joining_bonus_points);
							$Total_seller_bal = $seller_curbal;
							$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
						}
						
						$customer_name = $this->input->post('firstName')." ".$this->input->post('middleName')." ".$this->input->post('lastName');  
		
						$Email_content12 = array(
							'Joining_bonus_points' => $Joining_bonus_points,
							'Notification_type' => 'Joining Bonus',
							'Template_type' => 'Joining_Bonus',
							'Customer_name' => $customer_name,
							'Todays_date' => $Todays_date
						);
						
						$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
						
						$tp_bill=$tp_bill+1;
						$billno_withyear_ref = $str.$tp_bill;
					}					
				/************ Joining Bonus end **************/				
				
				/************ Insert Mercahnt Category -Ravi-26-08-2016 **************/				
				if($this->input->post('User_id')== 2 && $this->input->post('MercahndizeCategory') != "" && $result > 0)
				{
					$cat_array= array(
								'Company_id'=>$Company_id,
								'Merchant_type'=>'0',
								'Seller'=>$Last_enroll_id,
								'Item_type_code'=>$Last_enroll_id,
								'Item_category_name'=>$this->input->post('MercahndizeCategory'),
								'Item_typedesc'=>$this->input->post('MercahndizeCategory'),
								'Discount'=>'no'
							   );
						$result_cat = $this->Coal_Enroll_model->insert_merchant_category($cat_array);							   
				}
				/************ Insert Mercahnt Category -Ravi-26-08-2016 **************/
				
				
				/************ Insert Auto Menu  -Ravi-26-08-2016 **************/
				$Super_seller = $this->Igain_model->get_enrollment_details($Last_enroll_id);
				
				$Super_seller1 = $Super_seller->Super_seller;
				if($this->input->post('User_id')== 2 && $result > 0 && $Super_seller1 == 0)
				{
														
						// $Menu_array=array(2,6,50,3,4,5,10,11,70,71,72,67);
						$Menu_array=array(2, 6, 50, 4, 5, 14,77,78,21,80,81,79,83,84,87);
						// print_r($Menu_array);
						foreach($Menu_array as $menu )
						{
							$parent_id=0;
							$menu_level=0;
							
							if($menu==2 || $menu ==6 || $menu==14 || $menu==50)
							{
								$menu_level=0;
							}							
							if($menu==4|| $menu==5|| $menu==83 || $menu==84 ||  $menu==79 || $menu==81 || $menu==80|| $menu==21|| $menu==78|| $menu==77 || $menu==87 )
							{
								$menu_level=1;
							}							
							if($menu==87 || $menu==4 || $menu==5)
							{
								$parent_id=2;
							}
							if($menu==77 || $menu==78)
							{
								$parent_id=6;
							}
							if($menu==80 || $menu==81 ||  $menu==21)
							{
								$parent_id=14;
								
							}							
							if($menu==84 ||$menu==83 || $menu==79)
							{
								$parent_id=50;
							}							
							$menu_array=array
							(
								'Company_id'=>$Company_id,
								'User_type_id'=>$this->input->post('User_id'),
								'Enrollment_id'=>$Last_enroll_id,
								'Menu_id'=>$menu,
								'Menu_level'=>$menu_level,
								'Parent_id'=>$parent_id
			
							);
							$insert_menu_assign = $this->Coal_Enroll_model->Insert_menu_assign($menu_array);
						}
				}		

				/***************Send Freebies Merchandize items************/
				$this->load->model('Catalogue/Catelogue_model');
						$Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1);
						
						if($Merchandize_Items_Records != NULL  && $this->input->post('cardid') != "" && $this->input->post('User_id')== 1 && $Allow_redeem_item_enrollment==1)
						{
							$this->load->model('Redemption_catalogue/Redemption_Model');
							foreach($Merchandize_Items_Records as $Item_details)
							{
							
								// $Item_name=$Item_details->Merchandize_item_name;
								/******************Changed AMIT 16-06-2016*************/
									
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
								$Voucher_status="Issued";								
								if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
								{
										 $insert_data = array(
									'Company_id' => $Company_id,
									'Trans_type' => 10,
									'Redeem_points' => $Item_details->Billing_price_in_points,
									'Quantity' => 1,
									'Trans_date' => $lv_date_time,
									'Create_user_id' => $Logged_in_userid,
									'Seller' => $Logged_in_userid,
									'Seller_name' => $Seller_name,
									'Enrollement_id' => $Last_enroll_id,
									'Card_id' => $this->input->post('cardid'),
									'Item_code' => $Item_details->Company_merchandize_item_code,
									'Voucher_no' => $Voucher_no,
									'Voucher_status' => $Voucher_status,
									'Merchandize_Partner_id' => $Item_details->Partner_id,
									'Remarks' => 'Freebies',
									'Bill_no' => $tp_bill,
									'Merchandize_Partner_branch' => $Branch_code
										);
									 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
									
									  $Voucher_array[]=$Voucher_no;
									  
									  /**********Send freebies notification********/
										$Email_content124 = array(
														'Merchandize_item_name' => $Item_details->Merchandize_item_name,
														'Item_image' => $Item_details->Item_image1,
														'Voucher_no' => $Voucher_no,
														'Voucher_status' => $Voucher_status,
														'Notification_type' => 'Freebies',
														'Template_type' => 'Freebies',
														'Customer_name' => $customer_name,
														'Todays_date' => $Todays_date
												);

									$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content124,$Logged_in_userid,$Company_id);
								}								
							}	
							$tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill;
						}
						/*********************Merchandize end*************************/
					$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
				
				/************ Insert Auto Menu -Ravi-26-08-2016 **************/
				if($User_type_id == 1)//customer
				{
					$Enrolled_under_msg="Member Loyalty Program";
				}
				else
				{
					$Enrolled_under_msg="Merchant Outlet";
				}
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => $Enrolled_under_msg
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("enroll_error_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("enroll_error_code","Error Enrollment!!");
				}
				if($session_data['userId'] == '3')
				{			
					$data["results"] = $this->Coal_Enroll_model->enrollment_list($config["per_page"], $page);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
				{
					$data["results"] = $this->Coal_Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
				}
				else
				{
					$data["results"] = $this->Coal_Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
				}
				$data["pagination"] = $this->pagination->create_links();				
				redirect(current_url());	
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function edit_enrollment()
	{	
		// $this->output->enable_profiler(true);
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
		$data['userId']= $session_data['userId'];
		$data['LogginUserName'] = $session_data['Full_name'];
		$data['Company_id'] = $session_data['Company_id'];
		$data['Super_seller'] = $session_data['Super_seller'];
		$Company_id = $session_data['Company_id'];
		$SuperSellerFlag = $session_data['Super_seller'];
		/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_Enrollmentc/enrollment";
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->Coal_Enroll_model->enrollment_count();
			}
			else
			{
				$total_row = $this->Coal_Enroll_model->Company_enrollment_count($session_data['Company_id']);
			}	
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
			
			// var_dump($session_data['Company_id']);
		if($data['userId']=='3' && $session_data['Company_id'] =='1')
		{		
			$data["results12"] = $this->Coal_Enroll_model->enrollment_list($config["per_page"], $page);
		}
		else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
		{
			$data["results12"] = $this->Coal_Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
		}
		else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '0'))
		{
			
			$enrollID=$data['enroll'];
			$data["results12"] = $this->Coal_Enroll_model->Selected_company_enrollment_list_login_seller($config["per_page"], $page,$session_data['Company_id'],$enrollID);
			
		}
		else
		{
			$data["results12"] = $this->Coal_Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
		}
		
		 if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
		{
			$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
		}
		else 
		{
			$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
			
		} 
		// var_dump($FetchedCompanys);
		// $FetchedCompanys = $this->Igain_model->FetchCompany();
		$data['Company_array'] = $FetchedCompanys;
		// var_dump($FetchedCompanys);
		$FetchedUserTypes = $this->Igain_model->FetchUserType();	
		$data['UserType_array'] = $FetchedUserTypes;
		$FetchedCountrys = $this->Igain_model->FetchCountry();	
		$data['Country_array'] = $FetchedCountrys;
		

		$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
		$Enroll_details = $this->Igain_model->get_enrollment_details($_GET['Enrollement_id']);
		
		$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
		
	//	echo "5555---".$Enroll_details->Sub_seller_Enrollement_id."----";
		if($Enroll_details->Sub_seller_Enrollement_id > 0 )
		{
			$data['results50'] = $this->Igain_model->get_enrollment_details($Enroll_details->Sub_seller_Enrollement_id);
		}
		else
		{
			$emptyarry['Sub_seller_admin'] = array();
			
			$data['results50'] = array();
		}
		
		if($_GET['Enrollement_id'])
		{
			// echo"---Enroll_details.....".$Enroll_details->Company_id;
			$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
			$data['Fetched_Companys'] = $FetchedCompanys;
			$Enrollement_id =  $_GET['Enrollement_id'];			
			$data['results'] = $this->Coal_Enroll_model->edit_enrollment($Enrollement_id);
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			$data["Tier_list"] = $this->Coal_Enroll_model->get_lowest_tier($Company_id);
				// var_dump($data['results']);
				$Enrollment_details = $this->Coal_Enroll_model->edit_enrollment($Enrollement_id);
				if($Enrollment_details->User_id == 1)
				{
					$Hobby = array();
					$member_hobbies = $this->Coal_Enroll_model->Fetch_member_hobbies($Company_id,$Enrollement_id);
					if($member_hobbies != NULL)
					{
						foreach($member_hobbies as $hobbies)
						{
							$Hobby[] = $hobbies->Hobbie_id;
						}
						$data['member_hobbies'] = $Hobby;
					}
					else
					{
						$data['member_hobbies'] = $Hobby;
					}
				}			
			/******************Ravi CHANGED 26-08-2016****************************/
			if($Enrollment_details->User_id == 2)
			{
				$Get_merchant_category = $this->Coal_Enroll_model->edit_merchant_category($Company_id,$Enrollement_id);
				$Get_merchant_working_hours = $this->Coal_Enroll_model->Get_merchant_working_hours($Enrollement_id);
				$data['Merchant_category']=$Get_merchant_category;
				$data['Get_merchant_working_hours']=$Get_merchant_working_hours;
			}
			/******************Ravi CHANGED 26-08-2016****************************/
						
			/******************AMIT CHANGED 04-04-2016****************************/
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$data['Company_id']);
			$data["Partner_Branch_Records"] = $this->Catelogue_model->Get_Partners_Branches($data['results']->Merchandize_Partner_ID);
			/******************************************************************/
			$data["pagination"] = $this->pagination->create_links();
			$this->load->view('Coal_enrollment/Coal_edit_enrollment', $data);
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
		
	public function update_enrollment()
	{
		if($this->session->userdata('logged_in'))
		{		
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$data['userId']= $session_data['userId'];
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_Enrollmentc/enrollment";
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->Coal_Enroll_model->enrollment_count();
			}
			else
			{
				$total_row = $this->Coal_Enroll_model->Company_enrollment_count($session_data['Company_id']);
			}	
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
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			if($_POST == NULL)
			{
				
				if($data['userId']=='3')
				{					
					$data["results2"] = $this->Coal_Enroll_model->enrollment_list($config["per_page"], $page);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
				{
					$data["results"] = $this->Coal_Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
				}
				else
				{
					$data["results"] = $this->Coal_Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
				}
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('Coal_enrollment/Coal_enrollment', $data);
			}
			else
			{
				if ( ! $this->upload->do_upload("file"))
				{			
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$filepath = $this->input->post("Enrollment_image");
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "uploads/".$data['upload_data']['file_name'];
				}				
				$Enrollment_id =  $this->input->post('Enrollment_id');
				$User_type_id = $this->input->post('User_id');
				
				
				
				/****************Merchant Working Hours***********************/
				if($User_type_id==2)
				{
					$resultPost2 = $this->Coal_Enroll_model->Delete_merchant_working_hours($Enrollment_id);
					
					$Days = $this->input->post('Days');
					//echo "Last_enroll_id ".$Last_enroll_id;
					foreach($Days as $Days)
					{	
						//echo "<br>".$Days;
						if($Days==1)
						{
							$Open_time = $this->input->post('Mon_open');
							$Close_time = $this->input->post('Mon_close');
							
						}
						elseif($Days==2)
						{
							$Open_time = $this->input->post('Tues_open');
							$Close_time = $this->input->post('Tues_close');
						}
						elseif($Days==3)
						{
							$Open_time = $this->input->post('Wed_open');
							$Close_time = $this->input->post('Wed_close');
						}
						elseif($Days==4)
						{
							$Open_time = $this->input->post('Thurs_open');
							$Close_time = $this->input->post('Thurs_close');
						}
						elseif($Days==5)
						{
							$Open_time = $this->input->post('Fri_open');
							$Close_time = $this->input->post('Fri_close');
						}
						elseif($Days==6)
						{
							$Open_time = $this->input->post('Sat_open');
							$Close_time = $this->input->post('Sat_close');
						}
						else
						{
							$Open_time = $this->input->post('Sun_open');
							$Close_time = $this->input->post('Sun_close');
						}
						
							$Open_time  = date("H:i", strtotime($Open_time));
							$Close_time  = date("H:i", strtotime($Close_time));
							
						$Post_workdata = array
							(					
								'Seller_id' => $Enrollment_id,
								'Day' => $Days,        
								'Open_time' => $Open_time,       
								'Close_time' => $Close_time
							
							);							
							$resultPost = $this->Coal_Enroll_model->insert_merchant_working_hours($Post_workdata);
							
							
					}	
					
				}
				
				
				
				if($User_type_id == 1)
				{
					$TierID = $this->input->post('member_tier_id');
					$Merchant_sales_tax = 0;
					$RefrenceD = 0;
					$Allow_services=0;
				}
				else
				{
					$TierID = 0;
					$RefrenceD = $this->input->post('Refrence');
					$Allow_services = $this->input->post('Allow_services');
					$Merchant_sales_tax = $this->input->post('Merchant_sales_tax');
				}
				
				$post_data = array(					
					'First_name' => $this->input->post('firstName'),
					'Middle_name' => $this->input->post('middleName'),        
					'Last_name' => $this->input->post('lastName'),       
					'Current_address' => $this->input->post('currentAddress'),
					'State' => $this->input->post('state'),
					'District' => $this->input->post('district'),
					'City' => $this->input->post('city'),
					'Zipcode' => $this->input->post('zip'),
					'Country' => $this->input->post('country'),
					'Phone_no' => $this->input->post('phno'),
					'Date_of_birth' => $this->input->post('dob'),
					'Sex' => $this->input->post('sex'),
					'Qualification' => $this->input->post('qualifi'),
					'Photograph' => $filepath,
					'Country_id' => $this->input->post('country'),
					'User_email_id' => $this->input->post('userEmailId'),
					'Company_id' => $Company_id,
					'User_id' => $this->input->post('User_id'),
					'Card_id' => $this->input->post('membership_id'),
					'Purchase_Bill_no' => $this->input->post('Purchase_Bill_no'),
					'Topup_Bill_no' => $this->input->post('Topup_Bill_no'),
					'Seller_Redemptionratio' => $this->input->post('Seller_Redemptionratio'),
					'Website' => $this->input->post('Website'),
					'timezone_entry' => $this->input->post('Time_Zone'),
					'Refrence' => $RefrenceD,
					'Latitude' => $this->input->post('Latitude'),
					'Longitude' => $this->input->post('Longitude'),
					'Sub_seller_Enrollement_id' => $this->input->post('Sub_seller_Enrollement_id'),
					'Tier_id' => $TierID,
					'Allow_services' => $Allow_services,
					'Merchant_sales_tax' => $Merchant_sales_tax,
				);
				
				$result = $this->Coal_Enroll_model->update_enrollment($post_data,$Enrollment_id);
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("enroll_error_code","Enrollment Updated Successfuly!!");
				}
				/* else
				{
					$this->session->set_flashdata("enroll_error_code","Error Updating Enrollment!!");
				} */
				redirect("Coal_Enrollmentc/enrollment");
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function delete_enrollment()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			/*-----------------------Pagination---------------------*/		
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_Enrollmentc/enrollment";
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->Coal_Enroll_model->enrollment_count();
			}
			else
			{
				$total_row = $this->Coal_Enroll_model->Company_enrollment_count($session_data['Company_id']);
			}	
			$config["total_rows"] = $total_row;
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;        
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Previous';
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
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
			
			if($_GET == NULL)
			{
				$data["results"] = $this->Coal_Enroll_model->enrollment_list($config["per_page"], $page);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('Coal_enrollment/Coal_enrollment', $data);
			}
			else
			{	
				$Enrollement_id =  $_GET['Enrollement_id'];
				$result = $this->Coal_Enroll_model->delete_enrollment($Enrollement_id);
				if($result == true)
				{
					$this->session->set_flashdata("enroll_error_code","Enrollment Deleted Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("enroll_error_code","Error Deleting Enrollment!!");
				}
				redirect("Coal_Enrollmentc/enrollment");
			}
		}
	}
	
	public function autocomplete_customer_names()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['Company_id'] = $session_data['Company_id'];
			
			if (isset($_GET['term']))
			{
				$keyword = strtolower($_GET['term']);
				$Company_id = $data['Company_id'];
				// echo $keyword;
				$this->Coal_Enroll_model->get_membername($keyword,$Company_id);
			}
		}
	}
//****************** Ravi work  end ***********************************
//****************** amit work  start ***********************************	
	public function get_long_latt_merchant()
	{
		error_reporting(0);
		$FetchedCountrys = $this->Igain_model->FetchCountry();	
		$Country_array = $FetchedCountrys;
		
		foreach($Country_array as $Countries)
		{
			
			if($Countries['Country_id']==$_REQUEST['country_id'])
			{
				
				$country_name= $Countries['Country_name'];
			}
		}
		 $address =$this->input->post("currentAddress").' '.$this->input->post("city").' '.$this->input->post("district").' '.$this->input->post("state").' '.$this->input->post("zip").' '.$country_name; 
		 
		// echo $address;
		
		$prepAddr = str_replace(' ','+',$address);
		 
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		 
		$output= json_decode($geocode);
		 
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng; 
		$Location=$latitude."*".$longitude;
		$this->output->set_output($Location);
	}
//****************** amit work  end ***********************************

//****************** sandeep work start ***********************************
	public function asign_membership()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Country_id = $session_data['Country_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			if($_POST == NULL)
			{
			
				$this->load->view('Coal_enrollment/asign_membership', $data);
			}
			else
			{
				$Enrollment_id = $this->Coal_Enroll_model->validate_member($Company_id,$Country_id);

				if($Enrollment_id > 0)
				{
					$data['results'] = $this->Coal_Enroll_model->edit_enrollment($Enrollment_id);
					
					$this->load->view('Coal_enrollment/cardassignment', $data);
					//redirect("enrollment/cardassignment");
				}
				else
				{
					$this->session->set_flashdata("asign_membership_error_code","Membership Id Already Assigned Or Member Name/Phone no. Is Invalid!");
					redirect(current_url()); // clear post (form previous) data and redirect to current form
				} 
				
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function asign_membership_card()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Company_id = $session_data['Company_id'];
			$Enrollment_id =  $this->input->post('Enrollment_id');
			$CardID =  $this->input->post('CardID');
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points; 
			$Todays_date=date("Y-m-d");
			if($_POST == NULL)
			{
				$data['results'] = $this->Coal_Enroll_model->edit_enrollment($Enrollment_id);
					
				$this->load->view('Coal_enrollment/cardassignment', $data);
			}
			else
			{
				$seller_id = $data['enroll'];
				$Post_Enrollment_id =  $this->input->post('Enrollment_id');
				$enrollment_details = $this->Igain_model->get_enrollment_details($Post_Enrollment_id);
				$Cust_topup_amt = $enrollment_details->Total_topup_amt;
				
				$post_data = array
				(					
					'Card_id' => $this->input->post('CardID'),
					'Company_id' => $Company_id
				);
				$result = $this->Coal_Enroll_model->update_enrollment($post_data,$Enrollment_id);
				
				$data['results'] = $this->Coal_Enroll_model->edit_enrollment($Enrollment_id);
				$customer_name =$data['results']->First_name." ".$data['results']->Last_name;
				/**************************** Seller info*********************/
					$user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
					
					$seller_id = $user_details->Enrollement_id;
					$Purchase_Bill_no = $user_details->Purchase_Bill_no;
					$username = $user_details->User_email_id;
					$remark_by = 'By Mercahnt';
					$seller_curbal = $user_details->Current_balance;
					$Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
					$Seller_Refrence = $user_details->Refrence;
					$Seller_Country_id = $user_details->Country_id;
					$Topup_Bill_no =  $user_details->Topup_Bill_no;
					$Seller_name = $user_details->First_name." ".$user_details->Middle_name." ".$user_details->Last_name;
					
					$top_db2 = $Topup_Bill_no;
					$len2 = strlen($top_db2);
					$str2 = substr($top_db2,0,5);
					$tp_bill2 = substr($top_db2,5,$len2);
					
					$topup_BillNo2 = $tp_bill2 + 1;
					$billno_withyear_ref2 = $str2.$topup_BillNo2;
				/**************************AMIT**** Joining Bonus start*******20-05-2016*****************/
				// Joining_bonus_points 
				
				if($Joining_bonus_flag == 1)
				{
					
					$Todays_date=date("Y-m-d");
					
					$post_Transdata = array
					(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $Joining_bonus_points,        
						'Trans_date' => $Todays_date,       
						'Remarks' => 'Joining Bonus',
						'Card_id' => $CardID,
						'Seller_name' => $Seller_name,
						'Seller' => $seller_id,
						'Enrollement_id' => $Enrollment_id,
						'Bill_no' => $tp_bill2,
						'remark2' => $remark_by,
						'Loyalty_pts' => '0'
					);
					
					$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);
				
					$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref2);
					
					if($Seller_topup_access=='1')
					{
						$seller_curbal = ($seller_curbal - $Joining_bonus_points);
						$Total_seller_bal2 = $seller_curbal;
						$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal2);
					}
					  
	
					$Email_content12 = array
					(
						'Joining_bonus_points' => $Joining_bonus_points,
						'Notification_type' => 'Joining Bonus',
						'Template_type' => 'Joining_Bonus',
						'Customer_name' => $customer_name,
						'Todays_date' => $Todays_date
					);
					
					$this->send_notification->send_Notification_email($Enrollment_id,$Email_content12,$data['enroll'],$Company_id);
					
					$Cust_topup_amt = $Cust_topup_amt + $Joining_bonus_points;
					$post_data2 = array
					(
						'Current_balance' => $Joining_bonus_points,
						'Total_topup_amt' => $Cust_topup_amt,
						'Company_id' => $Company_id
					);
					$result2 = $this->Coal_Enroll_model->update_enrollment($post_data2,$Enrollment_id);

					$tp_bill2=$tp_bill2+1;
					$billno_withyear_ref2 = $str.$tp_bill2;	
				}
				/************ Joining Bonus end **************/				
				
				
				$Email_content = array(
					'Notification_type' => 'Enrollment Details',
					'Template_type' => 'Assign_membershipid'
				);
				$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$data['enroll'],$Company_id);
				
				
				/***************Send Freebies Merchandize items************/
				$this->load->model('Catalogue/Catelogue_model');
						$Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1);
						
						if($Merchandize_Items_Records != NULL)
						{
							$this->load->model('Redemption_catalogue/Redemption_Model');
							foreach($Merchandize_Items_Records as $Item_details)
							{
								/******************Changed AMIT 16-06-2016*************/
								
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
								$Voucher_status="Issued";
								
								if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
								{
										 $insert_data = array(
									'Company_id' => $Company_id,
									'Trans_type' => 10,
									'Redeem_points' => $Item_details->Billing_price_in_points,
									'Quantity' => 1,
									'Trans_date' => $Todays_date,
									'Create_user_id' => $data['enroll'],
									'Seller' => $data['enroll'],
									'Seller_name' => $data['LogginUserName'],
									'Enrollement_id' => $Post_Enrollment_id,
									'Card_id' => $CardID,
									'Item_code' => $Item_details->Company_merchandize_item_code,
									'Voucher_no' => $Voucher_no,
									'Voucher_status' => $Voucher_status,
									'Merchandize_Partner_id' => $Item_details->Partner_id,
									'Remarks' => 'Freebies',
									'Bill_no' => $tp_bill2,
									'Merchandize_Partner_branch' => $Branch_code
										);
									 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
									
									  $Voucher_array[]=$Voucher_no;
									  
									  /**********Send freebies notification********/
										$Email_content124 = array(
														'Merchandize_item_name' => $Item_details->Merchandize_item_name,
														'Item_image' => $Item_details->Item_image1,
														'Voucher_no' => $Voucher_no,
														'Voucher_status' => $Voucher_status,
														'Notification_type' => 'Freebies',
														'Template_type' => 'Freebies',
														'Customer_name' => $customer_name,
														'Todays_date' => $Todays_date
												);

									$this->send_notification->send_Notification_email($Post_Enrollment_id,$Email_content124,$seller_id,$Company_id);
								}
								
							}	
							
							$tp_bill2=$tp_bill2+1;
							$billno_withyear_ref2 = $str.$tp_bill2;	
						}
						
						$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref2);
						/*********************Merchandize end*************************/	
				if($result == true)
				{
					$this->session->set_flashdata("asign_membership_error_code","Membership Id Assigned Successfuly!!");
				}
				
				$this->load->view('Coal_enrollment/asign_membership', $data);
	
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
//********************** sandeep work end ********************	
	
}
?>

