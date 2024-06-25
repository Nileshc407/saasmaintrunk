<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Enrollmentc extends CI_Controller 
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
		$this->load->model('enrollment/Enroll_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('Igain_model');
		$this->load->model('master/currency_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->library('Send_notification');
		$this->load->model('TierM/Tier_model');	
		$this->load->model('Coal_transactions/Coal_Transactions_model');
		
		$this->load->helper('security');
		$this->load->helper(array('form', 'url','encryption_val'));	
	}
	function search_enrollement()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Country_id'] = $session_data['Country_id'];
		$data['enroll'] = $session_data['enroll'];
		$data['userId']= $session_data['userId'];
		$data['Super_seller']= $session_data['Super_seller'];		
		$result = $this->Enroll_model->search_enrollement($this->input->post("search_data"),$this->input->post("Company_id"),$data['Country_id'],$data['Super_seller'],$data['enroll']);
		$data["results"]=$result;
		$this->load->view('enrollment/Search_enrollement_records', $data);
	} 
//************* akshay work start *************************************	

	function fastenroll()
	{
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
			$Logged_user_enrollid = $session_data['enroll'];				
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			
			if($Sub_seller_admin==1)
			{
				$Logged_user_enrollid=$Logged_user_enrollid;
			}
			else
			{
				$Logged_user_enrollid=$Sub_seller_Enrollement_id;
			}
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points;
			$Coalition = $resultis->Coalition;
			$Company_Current_bal = $resultis->Current_bal;

			$data["Company_details"] = $resultis;
			
			
			

			$Seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data['Refrence'] = $Seller_details->Refrence;
			$data['State'] = $Seller_details->State;
			$data['City'] = $Seller_details->City;

			// $referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$data['enroll']);
			$referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$Logged_user_enrollid);
			$data["referral_rule_count"] = $referral_rule_count;
			
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			
			
			if($_POST == NULL)
			{
				// echo "fastenroll------------"; die;
				$this->load->view('enrollment/fastenroll', $data);
			}
			else
			{
				/* $fname= strip_tags($_REQUEST['fname']);
			$fname2= preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['fname']);
			echo "<br>fname $fname";
			echo "<br>fname2 $fname2";
			DIE; */
				$fname = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['fname']);
				$lname = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lname']);
				$phno = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['phno']);
				if($fname == '' || $lname == '' || $phno == '' || $_REQUEST['userEmailId'] == '' ){
					 $this->session->set_flashdata("error_code","Please Enter all Required fields !!!");
					redirect('Enrollmentc/fastenroll', 'refresh');	
				}
					
					
			if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
			  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
				redirect('Enrollmentc/fastenroll', 'refresh');	
			}
			if(strlen($_REQUEST['phno']) != 10) 
			{
				$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
				redirect('Enrollmentc/fastenroll', 'refresh');	
			}
				if( is_numeric($_REQUEST['phno']) != 1 )
				{
					
					$this->session->set_flashdata("error_code","Invalid Phone No.");
					redirect('Enrollmentc/fastenroll', 'refresh');	
				}
				if($data["Company_details"]->card_decsion == '1') 
				{ 
					$Card_id=$data["Company_details"]->next_card_no;
				}
				else
				{
					// $Card_id=$this->input->post('cardid');
					$Card_id = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['cardid']);
				}
				
				$Chk_card=$Card_id;
				
				if( $Chk_card != "")
				{
					$check_card=$this->Enroll_model->check_card_id($Chk_card,$data['Company_id']);
					if($check_card > 0)
					{
						$this->session->set_flashdata("error_code","Membership ID Already Exists..Enrollment  NOT Successful!!");
						redirect(current_url());
					}
				}
	/********** sandeep chng ****email validation **** 10-03-2017 ************/
				$email_flag = $this->input->post('email_validity');		
				if($email_flag == 1)
				{ 
					$email_id = $this->input->post('userEmailId');
				}
				else if($email_flag == 0)
				{ 
					// $email_id = $this->input->post('userEmailId2');
					$email_id = $this->input->post('userEmailId');
				}
				else
				{ 
					$email_id = $this->input->post('userEmailId');
				}
				
				if( $email_id != "")
				{
					$email_result = $this->Enroll_model->check_userEmailId($email_id,$data['Company_id'],'1');
					
					if($email_result > 0)
					{
						$this->session->set_flashdata("error_code","User Email Id Already Exists..Enrollment  NOT Successful!!");
						redirect(current_url());
					}
				}
					
		/********** sandeep chng ****email validation **** 10-03-2017 ************/		
		
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

					$referre_enrollID =  strip_tags($_REQUEST['Refree_name']);
					$referre_membershipID = substr(strrchr($referre_enrollID, "-"), 1);
								
					if($referre_membershipID >'0')
					{
						$Referral_rule_for = 1; //*** Referral_rule_for enrollment
						// $Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for);
						$Ref_rule = $this->Transactions_model->select_seller_refrencerule($Logged_user_enrollid,$Company_id,$Referral_rule_for);

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

					// $topup_BillNo = $tp_bill + 1;
					// $billno_withyear_ref = $str.$topup_BillNo;
					
					$Enrolled_Card_id=$Card_id;
	
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

						/* if($Seller_topup_access == '0')
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
						} */
						
						if($Coalition == 1 ){
							
							$refree_current_balnce = $ref_card_bal;
							$refree_topup = $ref_topup_amt;
							
						} else {
							
							$refree_current_balnce = $ref_card_bal + $ref_topup;
							$refree_topup = $ref_topup_amt + $ref_topup;
						}
						$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
						
						$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
						$Seller_balance = $seller_details2->Current_balance;
						
						// $seller_curbal = $seller_curbal - $ref_topup;
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
						}
								
						$customer_name = $this->input->post('fname')." ".$this->input->post('lname');

						$Email_content12 = array(
								'Ref_Topup_amount' => $ref_topup,
								'Notification_type' => 'Referral Topup',
								'Template_type' => 'Referral_topup',
								'Customer_name' => $customer_name,
								'Todays_date' => $Todays_date
						);				

						
								$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
						
						/* $tp_bill=$tp_bill+1;
						$billno_withyear_ref = $str.$tp_bill; */
					}
				}
				// die;
				/************ Referral Bonus **************/
				if($Joining_bonus_flag == 1 && $Card_id != "")
				{
					/*****************New Change By Ravi 16-11-2017******************
					if($Seller_topup_access=='1')
					{
						// $Customer_topup12 =($Customer_topup12+$Joining_bonus_points);
						$Customer_topup12 =$Joining_bonus_points;
					}
					else
					{
						$Customer_topup12 =($Customer_topup12+$Joining_bonus_points);
					}
					
					/*****************New Change By Ravi 16-11-2017******************/
					
					
					
					if($Joining_bonus_flag == 1 && $Card_id != ""){
					
						$Customer_topup12 = $Joining_bonus_points;
					
					} else {
						
						$Customer_topup12 =0;
					}
					
					/*****************New Change By Ravi 16-11-2017******************/
					

				}
				
				$_REQUEST['fname'] = $fname;
				$_REQUEST['lname'] = $lname;
				$result = $this->Enroll_model->fastenroll($Customer_topup12,$ref_Customer_enroll_id,$data['State'],$data['City'],$Card_id);
				
				$Last_enroll_id=$result;
				/*****************Nilesh change igain Log Table change 14-06-2017******************/
			
				$opration = 1;				
				$userid=$data['userId'];
				$what="Quick Enrollment";
				$where="Quick Enroll";
				$toname="";
				$opval = $fname.' '.$lname.' Enrollement ID- ('.$Last_enroll_id.')';
				$firstName = $fname;
				$lastName = $lname;
				
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
						
				/*****************igain Log Table change 14-06-2017***************/
					$customer_name = $fname." ".$lname;
					/************ Referee Bonus **************/
					if($referre_membershipID != "" && $Seller_Refrence == 1 && $Customer_topup > 0 && $Enrolled_Card_id!="")
					{

							$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
							$Seller_balance = $seller_details2->Current_balance;								
							// $seller_curbal = $seller_curbal - $Customer_topup;
							$seller_curbal = $Seller_balance - $Customer_topup;
							$SellerID = $seller_id;
							$post_Transdata = array(
							'Trans_type' => '1',
							'Company_id' => $Company_id,
							'Topup_amount' => $Customer_topup,
							'Trans_date' => $lv_date_time,
							'Remarks' => 'Referral Trans',
							'Card_id' => $Card_id,
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
							}
								
								
								$Last_customer_record = $this->Igain_model->get_enrollment_details($Last_enroll_id);
								$Last_Card_id=$Last_customer_record->Card_id;
								$Last_Current_balance=$Last_customer_record->Current_balance;
								$Last_Blocked_points=$Last_customer_record->Blocked_points;
								$Last_total_purchase=$Last_customer_record->total_purchase;
								$Last_Total_topup_amt=$Last_customer_record->Total_topup_amt;
								$Last_Total_reddems=$Last_customer_record->Total_reddems;								
								$refree_current_balnce = $Last_Current_balance;
								$refree_topup = $Last_Total_topup_amt + $Customer_topup;
								
								
							if($Coalition == 1 ) {
							
								$refree_topup1 = $Last_Total_topup_amt;
								$refree_current_balnce = $Last_Current_balance;
							
							} else {
								
								$refree_topup1 = $Last_Total_topup_amt + $Customer_topup;
								$refree_current_balnce = $Last_Current_balance + $Customer_topup;
							}							
							
							$result5 = $this->Transactions_model->update_customer_balance($Last_Card_id,$refree_current_balnce,$Company_id,$refree_topup1,$Todays_date,$Last_total_purchase,$Last_Total_reddems);
								
								
													
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
							
							/* $tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill; */
						
					}
					/************ Referee Bonus **************/


					/**************************AMIT**** Joining Bonus start*******************/
						// Joining_bonus_points

					if($Joining_bonus_flag == 1 && $Card_id != "")
					{
							$SellerID = $seller_id;	
							$post_Transdata = array(
							'Trans_type' => '1',
							'Company_id' => $Company_id,
							'Topup_amount' => $Joining_bonus_points,
							'Trans_date' => $lv_date_time,
							'Remarks' => 'Joining Bonus',
							'Card_id' => $Card_id,
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
								// $seller_curbal = ($Total_seller_bal - $Joining_bonus_points);
								$Company_Current_bal =$Company_Current_bal-$Joining_bonus_points;
								// $Total_seller_bal2 = $seller_curbal;
								// $result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal2);
								// $result3 = $this->Igain_model->Update_company_balance($Company_id,'',$Company_Current_bal);
							}

						$customer_name = $fname." ".$lname;

							$Email_content12 = array(
									'Joining_bonus_points' => $Joining_bonus_points,
									'Notification_type' => 'Joining Bonus',
									'Template_type' => 'Joining_Bonus',
									'Customer_name' => $customer_name,
									'Todays_date' => $Todays_date
							);

							$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
							
							
					}

					/************ Joining Bonus end **************/
						
				
				// if($result == true)
				if($result > 0)
				{
						$Email_content = array(
								'Notification_type' => 'Enrollment Details',
								'Template_type' => 'Enroll'
						);
						$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$data['enroll'],$data['Company_id']);

						$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
						$this->session->set_flashdata("error_code","Error Enrollment!!");
				}			
						
				redirect(current_url());
					
					
			}
		}
		else
		{
				redirect('Login', 'refresh');
		}
	}
		
	function check_card_id()
	{
		$result = $this->Enroll_model->check_card_id($this->input->post("cardid"),$this->input->post("Company_id"));
		
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
		$result = $this->Enroll_model->check_phone_no($this->input->post("Phone_no"),$this->input->post("Company_id"),$this->input->post("Country_id"));
		
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
		$result = $this->Enroll_model->check_userEmailId($this->input->post("userEmailId"),$this->input->post("Company_id"),$this->input->post("userId"));
		
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
			echo $data['result12'] = $result->Seller_Redemptionratio;
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
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			
			if($Sub_seller_admin==1)
			{
                $Logged_user_enrollid=$Logged_user_enrollid;
			}
			else
			{
                $Logged_user_enrollid=$Sub_seller_Enrollement_id;
			}			
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
						
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points;
			$Coalition = $resultis->Coalition;
			$Allow_preorder_services = $resultis->Allow_preorder_services;
			$Allow_redeem_item_enrollment = $resultis->Allow_redeem_item_enrollment;
			$Company_Current_bal = $resultis->Current_bal;
			$Company_Country = $resultis->Country;
			
			$Enable_company_meal_flag = $resultis->Enable_company_meal_flag;
			
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);			
			$data["Bussi_Tier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=1);
			
			$data["IndTier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=0);
			$data["AllTier_list"] = array_merge($data["Bussi_Tier_list"],$data["IndTier_list"]);
			if($data["IndTier_list"]==NULL){$data["AllTier_list"] =$data["Bussi_Tier_list"];}
			
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			// print_r($data["AllTier_list"]);
			// $referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$data['enroll']);
			$referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$Logged_user_enrollid);
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
					
					// $topup_BillNo = $tp_bill + 1;
					// $billno_withyear_ref = $str.$topup_BillNo;
					
					if($user_details->Sub_seller_admin == 1)
					{
						$remark_by = 'By SubSeller';
					}
					else
					{
						$remark_by = 'By Seller';
					}
					
				}
			//Logged_user_enrollid;
			$data["Seller_Refrence"] = $Seller_Refrence;			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
			$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
			$data["Call_center_details"] = $this->Igain_model->Fetch_Callcenter_details($session_data['Company_id']);
			
			//$data["Finance_user_details"] = $this->Enroll_model->Fetch_Finance_user_details($session_data['Company_id']);
			
			$data["Finance_user_details"] = $this->Igain_model->get_company_outlet_sellers($session_data['Company_id']);
			
			$data["Dmcc_parent_members"] = $this->Enroll_model->get_company_parent_members($session_data['Company_id']);
			
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
			// $FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
			// $data['Country_array'] = $FetchedCountrys;
			
			
			/*-----------------------Pagination---------------------*/		
			// $this->output->enable_profiler(true);			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Enrollmentc/enrollment";
			
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->Enroll_model->enrollment_count();
				
			}
			else
			{
				$total_row = $this->Enroll_model->Company_enrollment_count($session_data['Company_id']);
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
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			$data["Total_merchants"] = $this->Enroll_model->get_total_merchant($session_data['Company_id']);
			// echo "<br>-----Total_merchants----)".$data["Total_merchants"]."---";
			/* License Limit */
				/* Enhance - 120
				Basic - 121
				Standard - 253 */
				// $linc_limit = $Company_details->Seller_licences_limit;
				$Company_License_type = $resultis->Company_License_type;
				
				if($Company_License_type==120){
					// $linc_limit=15000;
					$Code_decode_type_id=26;
				} else if($Company_License_type==253){
					// $linc_limit=5000;
					$Code_decode_type_id=25;
				} else if($Company_License_type==121){
					// $linc_limit=100;
					$Code_decode_type_id=24;
				}
				
				
				$code_decode_data = $this->Enroll_model->get_code_decode_data($Code_decode_type_id,$session_data['Company_id']);
				$linc_limit=$code_decode_data->Code_decode;

				
				$remain_lic = $linc_limit - $data["Total_merchants"];
				if($remain_lic <0){
					$remain_lic=0;
				}
				/* echo "<br>-----Company_License_type----)".$Company_License_type."---";
				echo "<br>-----linc_limit----)".$linc_limit."---";
				echo "<br>-----Total_merchants----)".$data["Total_merchants"]."---";
				echo "<br>-----remain_lic--0--)".$remain_lic."---";  */
				// $remain_lic=10;
				
				$data["remain_lic"]=$remain_lic;
				$data["linc_limit"]=$linc_limit;
				
			/* License Limit */


			
			if($_POST == NULL)
			{
				if($data['userId'] == '3' && $session_data['Company_id'] =='1' )
				{					
					$data["results"] = $this->Enroll_model->enrollment_list($config["per_page"], $page);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
				{
					$data["results"] = $this->Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '0'))
				{
					$enrollID=$data['enroll'];
					$data["results"] = $this->Enroll_model->Selected_company_enrollment_list_login_seller($config["per_page"], $page,$session_data['Company_id'],$enrollID);
				}
				else
				{
					$data["results"] = $this->Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
				}				
				$data["pagination"] = $this->pagination->create_links();
				
		
				$this->load->view('enrollment/enrollment', $data);
			}
			else
			{
				if($data["Company_details"]->card_decsion == '1') 
				{ 
					$Card_id=$data["Company_details"]->next_card_no;
				}
				else
				{
					$Card_id=$this->input->post('cardid');
				}
			
				$customer_name = $this->input->post('firstName')." ".$this->input->post('middleName')." ".$this->input->post('lastName');  
				
		/********** sandeep chng ****email validation **** 10-03-2017 ************/	
					$User_type_id = $this->input->post('User_id');
					$Chk_card=$Card_id;
					
					if( $Chk_card != "" && $User_type_id == 1)
					{
						$check_card=$this->Enroll_model->check_card_id($Chk_card,$data['Company_id']);
						/* if($check_card > 0)
						{
							$this->session->set_flashdata("error_code","Membership ID Already Exists..Enrollment  NOT Successful!!");
							redirect(current_url());
						} */
					}
					
					$email_id = $this->input->post('userEmailId');

					if( $email_id != "")
					{
						$email_result = $this->Enroll_model->check_userEmailId($email_id,$data['Company_id'],$User_type_id);
						
						/* if($email_result > 0)
						{
							$this->session->set_flashdata("error_code","User Email Id Already Exists..Enrollment  NOT Successful!!");
							redirect(current_url());member_tier_id
						} */
					}
					
					
					
		/********** sandeep chng ****email validation **** 10-03-2017 ************/		
		
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
					if($referre_membershipID > '0')
					{
						$Referral_rule_for = 1; //*** Referral_rule_for enrollment
						// $Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for);
						$Ref_rule = $this->Transactions_model->select_seller_refrencerule($Logged_user_enrollid,$Company_id,$Referral_rule_for);
					
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
				
					if($referre_membershipID > '0' && $Seller_Refrence == 1 && $ref_topup > 0 )//&& $Coalition==0 12-09-2017 AMIT Changed
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
							
							/* $refree_current_balnce = $ref_card_bal + $ref_topup;
							$refree_topup = $ref_topup_amt + $ref_topup;
					
							if($Seller_topup_access=='0')
							{
								$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
							} */
							
							
								if($Coalition == 1 ) {
								
									$refree_current_balnce = $ref_card_bal;
									$refree_topup = $ref_topup_amt;
								
								} else {
									
									$refree_current_balnce = $ref_card_bal + $ref_topup;
									$refree_topup = $ref_topup_amt + $ref_topup;
								}
								
									/* $refree_current_balnce = $ref_card_bal;
									$refree_topup = $ref_topup_amt + $ref_topup; */
								
								$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
							

							/*******************Ravi Change-24-08-2016*********************************/
							$SellerID = $seller_id;
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
							
							$tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill;
							$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
							
							
							

							
							$customer_name = $this->input->post('firstName')." ".$this->input->post('middleName')." ".$this->input->post('lastName');  
			
							$Email_content12 = array
							(
								'Ref_Topup_amount' => $ref_topup,
								'Notification_type' => 'Referral Topup',
								'Template_type' => 'Referral_topup',
								'Customer_name' => $customer_name,
								'Todays_date' => $Todays_date
							);							
							
							$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
							
							
						}
						
					}
					else
					{
						$ref_Customer_enroll_id = '0';
					}
					
				
					/* if(!$this->upload->do_upload("file"))
					{			
						$filepath = "images/No_Profile_Image.jpg";
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = "uploads/".$data['upload_data']['file_name'];
					} */	
				
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/No_Profile_Image.jpg";
						}


				
				/* if($Joining_bonus_flag == 1 && $Card_id != "")
				{
					/********New Change by Ravi***16-11-2017***********
					if($Seller_topup_access=='1')
					{	
						// $Customer_topup12 =($Customer_topup12+$Joining_bonus_points);
						$Customer_topup12 =$Joining_bonus_points;
					}
					else
					{
						$Customer_topup12 =($Customer_topup12+$Joining_bonus_points);
					}
					/********New Change by Ravi***16-11-2017***********
				} */
				
				
				if($Joining_bonus_flag == 1 && $Card_id != ""){
					
					$Customer_topup12 = $Joining_bonus_points;
					
				} else {
					
					$Customer_topup12 =0;
				}
				
				/* echo"---Seller_topup_access----".$Seller_topup_access."----<br>";
				echo"---Joining_bonus_points----".$Joining_bonus_points."----<br>";
				echo"---Customer_topup----".$Customer_topup."----<br>";
				echo"---Customer_topup12----".$Customer_topup12."----<br>";
				die; */
				if($User_type_id == 1)
				{
					if($_REQUEST['Business_flag']==1 && $_REQUEST['Parent_flag']==1 && $_REQUEST['Participating_flag']==1)//Business,Parent,Participating
					{
							$_REQUEST['User_id']='1';
							$_REQUEST['firstName']=$_REQUEST['Business_org_name']; 							
							$result = $this->Enroll_model->enrollment($filepath,$Customer_topup12,$ref_Customer_enroll_id,$Card_id);
							
							$_REQUEST['User_id']='2';
							$outlet = $this->Enroll_model->enrollment($filepath,$Customer_topup12,$ref_Customer_enroll_id,$Card_id);
							
							$post_data2 = array
							(
								'Purchase_Bill_no' => date('Y')."-$outlet"."00000000",
								'Topup_Bill_no' => date('Y')."-$outlet"."10000000"
							);
							$result2 = $this->Enroll_model->update_enrollment($post_data2,$outlet);
							
							
						
					}
					else
					{
						$_REQUEST['User_id']='1';
						if($_REQUEST['Business_flag']==1){$_REQUEST['firstName']=$_REQUEST['Business_org_name'];}else{$_REQUEST['firstName']=$_REQUEST['firstName'];}
							
						$result = $this->Enroll_model->enrollment($filepath,$Customer_topup12,$ref_Customer_enroll_id,$Card_id);
					}
				}
				else
				{
					$result = $this->Enroll_model->enrollment($filepath,$Customer_topup12,$ref_Customer_enroll_id,$Card_id);
					if($_REQUEST['User_id']==2){
					$post_data2 = array
							(
								'Purchase_Bill_no' => date('Y')."-$outlet"."00000000",
								'Topup_Bill_no' => date('Y')."-$outlet"."10000000",
								'Company_id' => $Company_id
								
							);
							$result2 = $this->Enroll_model->update_enrollment($post_data2,$result);
					}
				}
				
				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="Enroll User";
					$toname="";
					$toenrollid = 0;
					$opval = $this->input->post('firstName').' '.$this->input->post('lastName').' Enrollement ID- ('.$result.')';
					$firstName = $this->input->post('firstName');
					$lastName = $this->input->post('lastName');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
				/************ Referee Bonus **************/		
					if($referre_membershipID > '0' && $Seller_Refrence == 1 && $Customer_topup > 0)// && $Coalition==0
					{
					
						/********Ravi Cahnge 24-08-2016****Transaction Entry of Refferal bonus for New Customer**************************/
													
							
							$SellerID = $seller_id;
							$Cust_membershipID=$Card_id;
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
							
							$tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill;
							$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
							
							$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);  
							$Seller_curbal = $seller_details2->Current_balance;
							
							// $seller_curbal12 = $seller_curbal - $Customer_topup;
							$seller_curbal12 = $Seller_curbal - $Customer_topup;
							if($Seller_topup_access=='1')
							{
								$Total_seller_bal12 = $seller_curbal12;								
								// $result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal12);
								$result3 = $this->Transactions_model->update_seller_balance($Logged_user_enrollid,$Total_seller_bal12);
								
							}
							
								
							$Last_customer_record = $this->Igain_model->get_enrollment_details($Last_enroll_id);
							$Last_Card_id=$Last_customer_record->Card_id;
							$Last_Current_balance=$Last_customer_record->Current_balance;
							$Last_Blocked_points=$Last_customer_record->Blocked_points;
							$Last_total_purchase=$Last_customer_record->total_purchase;
							$Last_Total_topup_amt=$Last_customer_record->Total_topup_amt;
							$Last_Total_reddems=$Last_customer_record->Total_reddems;								
							$refree_current_balnce = $Last_Current_balance;
							
							if($Coalition == 1 ) {
								
								$refree_topup1 = $Last_Total_topup_amt;
								$refree_current_balnce = $Last_Current_balance;
								
							} else {
								
								$refree_topup1 = $Last_Total_topup_amt + $Customer_topup;
								$refree_current_balnce = $Last_Current_balance + $Customer_topup;
							}
								
								
								$result5 = $this->Transactions_model->update_customer_balance($Last_Card_id,$refree_current_balnce,$Company_id,$refree_topup1,$Todays_date,$Last_total_purchase,$Last_Total_reddems);
								
								
								
							if($Coalition == 1 ) 
							{
								
								
								/*********New table entry*****16-11-2017***Ravi***Start******************************************/
								$Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id,$Logged_user_enrollid,$Last_enroll_id);	
								// echo "<br>Record_available************ ".$Record_available."----<br>";
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
											$data["Cust_debit_points"]=$val["Cust_debit_points"];
										}									
										/***********************************************************************/
										$lv_Cust_seller_balance=($data["Cust_seller_balance"]+$Customer_topup);
										$lv_Seller_total_purchase=($data["Seller_total_purchase"]);
										$lv_Seller_total_redeem=($data["Seller_total_redeem"]);
										$lv_Seller_total_gain_points=($data["Seller_total_gain_points"]);
										$lv_Seller_paid_balance=($data["Seller_paid_balance"]);
										$lv_Seller_total_topup=($data["Seller_total_topup"]+$Customer_topup);
										$lv_Cust_prepayment_balance=($data["Cust_prepayment_balance"]);
										$lv_Cust_block_amt=($data["Cust_block_amt"]);
										$lv_Cust_block_points=($data["Cust_block_points"]);
										$Cust_debit_points=($data["Cust_debit_points"]);
										/*************Update customer merchant balance*************************/
										$result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Last_enroll_id,round($lv_Cust_seller_balance),$Company_id,$lv_Seller_total_topup,$lv_date_time,$lv_Seller_total_purchase,$lv_Seller_total_redeem,$lv_Seller_paid_balance,$lv_Seller_total_gain_points,$Logged_user_enrollid,$lv_Cust_prepayment_balance,$lv_Cust_block_points,$lv_Cust_block_amt,$Cust_debit_points);										
										/*****************************************************/
									}
								}
								/*********New table entry*****16-11-2017***Ravi***End******************************************/
								
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
							$this->send_notification->Coal_send_Notification_email($Last_enroll_id,$Email_content13,$Logged_user_enrollid,$Company_id);
						}
						else
						{
							 $this->send_notification->send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
						}				
						
					}
				/************ Referee Bonus **************/	
			
			
				/**************************AMIT**** Joining Bonus start***********************************************************/
				// Joining_bonus_points 
					if($Joining_bonus_flag == 1 &&  $Card_id != "" && $User_type_id == 1)// && $Coalition==0
					{
						
						
						/*******************Ravi Change-24-08-2016*********************************/
						/*if($Coalition == 1 )
						{
							$SellerID =0;
						}
						else
						{
							$SellerID = $seller_id;
						}*/
						$SellerID = $seller_id;
						/*******************Ravi Change-24-08-2016*********************************/
						$post_Transdata = array(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $Joining_bonus_points,        
						'Trans_date' => $lv_date_time,       
						'Remarks' => 'Joining Bonus',
						'Card_id' => $Card_id,
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
							// $seller_curbal = ($Total_seller_bal - $Joining_bonus_points);
							$Company_Current_bal =$Company_Current_bal-$Joining_bonus_points;
							$Total_seller_bal = $seller_curbal;
							// $result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
							// $result3 = $this->Igain_model->Update_company_balance($Company_id,'',$Company_Current_bal);
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
						
						
					}					
				/************ Joining Bonus end **************/
				
				
				/**************************Ravi**** MEAL Topup start***********************************************************/
				// Joining_bonus_points 
					if($Enable_company_meal_flag == 1 &&  $Card_id != "" && $User_type_id == 1 && $this->input->post('Meal_balance') >0 )
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
						
						
						
						$SellerID = $seller_id;
						
						
						
						
						$post_Transdata = array(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $this->input->post('Meal_balance'),        
						'Trans_date' => $lv_date_time,       
						'Remarks' => 'Meal Topup',
						'Card_id' => $Card_id,
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
						
						
						
						// echo "<br>Last_enroll_id************ ".$Last_enroll_id."----<br>";
							$Last_customer_record = $this->Igain_model->get_enrollment_details($Last_enroll_id);
							$Last_Card_id=$Last_customer_record->Card_id;
							$Last_Current_balance=(($Last_customer_record->Current_balance) - ($Last_customer_record->Debit_points+$Last_customer_record->Blocked_points));
							$Last_Blocked_points=$Last_customer_record->Blocked_points;
							$Last_total_purchase=$Last_customer_record->total_purchase;
							$Last_Total_topup_amt=$Last_customer_record->Total_topup_amt;
							$Last_Total_reddems=$Last_customer_record->Total_reddems;	
								
						// echo "---Last_Current_balance----".$Last_Current_balance."-----<br>";
						
						$customer_name = $this->input->post('firstName')." ".$this->input->post('middleName')." ".$this->input->post('lastName');  
						
						$Email_content_Meal = array(
							'MealTopUp' => $this->input->post('Meal_balance'),
							'Notification_type' => 'MEAL Topup',
							'Template_type' => 'Meal_Top_Up',
							'Customer_name' => $customer_name,
							'Current_Meal_balance' => $Last_Current_balance,
							'Todays_date' => $Todays_date
						);
						
						$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content_Meal,$Logged_in_userid,$Company_id);
						
						
					}					
				/************ MEAL Topup end **************/
				
				
				
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
						$result_cat = $this->Enroll_model->insert_merchant_category($cat_array);							   
				}
				/************ Insert Mercahnt Category -Ravi-26-08-2016 **************/
				
				
				/************ Insert Auto Menu  -Ravi-26-08-2016 **************/
				$Super_seller = $this->Igain_model->get_enrollment_details($Last_enroll_id);
				
				$Super_seller1 = $Super_seller->Super_seller;
				
				
				 /* if($this->input->post('User_id')== 2 && $result > 0 && $Super_seller1 == 0)
				{
					if($Coalition == 1 )  // for coalition company
					{									
						$Menu_array=array(2, 6, 50, 3, 4, 5, 10, 11, 68, 69, 70, 71);
						foreach($Menu_array as $menu )
						{
							$parent_id=0;
							$menu_level=0;
							
							if($menu==2 || $menu ==6 || $menu==50)
							{
								$menu_level=0;
							}							
							if($menu==3 || $menu==4|| $menu==5|| $menu==10 || $menu==11 ||  $menu==68 || $menu==69 || $menu==70|| $menu==71 )
							{
								$menu_level=1;
							}
							
							if($menu==3 || $menu==4 || $menu==5)
							{
								$parent_id=2;
							}
							if($menu==10 || $menu==11 ||  $menu==68 || $menu==69 || $menu==70 )
							{
								$parent_id=6;
								
							}
							if($menu==71)
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
							$insert_menu_assign = $this->Enroll_model->Insert_menu_assign($menu_array);
						}
					}
					else // for normal company
					{
							$Menu_array1=array(2, 6, 3, 4, 5, 7, 9, 10, 11, 50, 51, 8);					
							foreach($Menu_array1 as $menu )
							{
							   $parent_id=0;
							   $menu_level=0;
							   if($menu==2 || $menu==6 || $menu==50 || $menu==48);
							   {
								$menu_level=0;
							   }       
							   if($menu==3 || $menu==4|| $menu==5|| $menu==7|| $menu==8|| $menu==9 || $menu==10 || $menu==11 || $menu==51 || $menu==48)
							   {
								$menu_level=1;
							   }
							   if($menu==3 || $menu==4 || $menu==5)
							   {
								$parent_id=2;
							   }
							   if($menu == 7|| $menu == 9 || $menu==10 || $menu==11 || $menu==8 )
							   {
									$parent_id=6;
							   }
							   if($menu == 49)
							   {
									$parent_id = 48;
							   }
							   if($menu == 51)
							   {
									$parent_id = 50;
							   }						   
							   $menu_array2=array
							   (
								'Company_id'=>$Company_id,
								'User_type_id'=>$this->input->post('User_id'),
								'Enrollment_id'=>$Last_enroll_id,
								'Menu_id'=>$menu,
								'Menu_level'=>$menu_level,
								'Parent_id'=>$parent_id
								);
							   $insert_menu_assign = $this->Enroll_model->Insert_menu_assign($menu_array2);
							}							
					}
				} */		
				/*************AMIT 14-03-2017************************/
				$Check_flag=0;
				$TierID = $this->input->post('member_tier_id');
				$tier_details = $this->Tier_model->edit_tier($Company_id,$TierID);
				foreach($tier_details as $tier)
				{
					$Tier_id = $tier->Tier_id;
					$Tier_name = $tier->Tier_name;
				}
				
				if($Tier_name=='Affordable' || $Tier_name=='Premium' || $Tier_name=='Luxury')
				{
					$Check_flag=1;
					
				}	
				
				/***************Send Freebies Merchandize items************/
						$this->load->model('Catalogue/Catelogue_model');
						$Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1);
						$insert_flag=0;
						if($Merchandize_Items_Records != NULL  && $Card_id != "" && $this->input->post('User_id')== 1 && $Allow_redeem_item_enrollment==1)
						{
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
									
								/*************AMIT 14-03-2017************************/
									
								// echo '<br><br>(('.$Item_details->Link_to_Member_Enrollment_flag.'==1) && ('.$Todays_date.' >= '.$Item_details->Valid_from.') && ('.$Todays_date.' <= '.$Item_details->Valid_till.') && ('.$Tier_name.'=='.$Item_details->Merchandize_category_name.'))';
								
								if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till) && ($Tier_name==$Item_details->Merchandize_category_name))
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
										'Card_id' => $Card_id,
										'Item_code' => $Item_details->Company_merchandize_item_code,
										'Voucher_no' => $Voucher_no,
										'Voucher_status' => 30,
										'Delivery_method' => 28,
										'Merchandize_Partner_id' => $Item_details->Partner_id,
										'Remarks' => 'Freebies',
										'Source' =>99,
										'Bill_no' => $tp_bill,
										'Merchandize_Partner_branch' => $Branch_code
											);
									 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
									
									  $Voucher_array[]=$Voucher_no;
									  
									  /**********Send freebies notification********/
									
									 $Email_content125 = array(
														'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
														'Merchandize_item_name' => $Item_details->Merchandize_item_name,
														'Item_image' => $Item_details->Item_image1,
														'Voucher_no' => $Voucher_no,
														'Voucher_status' => $Voucher_status,
														'Notification_type' => 'Freebies',
														'Template_type' => 'Tier_Freebies',
														'Customer_name' => $customer_name,
														'Todays_date' => $Todays_date
												);
									$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content125,$Logged_in_userid,$Company_id); 
								}
								/*************AMIT 14-03-2017 END************************/
								if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till) && ($Check_flag==0))
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
										'Card_id' => $Card_id,
										'Item_code' => $Item_details->Company_merchandize_item_code,
										'Voucher_no' => $Voucher_no,
										'Voucher_status' => 30,
										'Delivery_method' => 28,
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
							if($insert_flag=1)
							{
								$tp_bill=$tp_bill+1;
								$billno_withyear_ref = $str.$tp_bill;
								$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
							}
						}
						/*********************Merchandize end*************************/
					
			
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
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
				if($session_data['userId'] == '3')
				{			
					$data["results"] = $this->Enroll_model->enrollment_list($config["per_page"], $page);
				}
				else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
				{
					$data["results"] = $this->Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
				}
				else
				{
					$data["results"] = $this->Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
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
	public function Fetch_member_details()
	{
		$Membership_id=$_REQUEST['Membership_id'];
		$Company_id=$_REQUEST['Company_id'];
		
		$result = $this->Enroll_model->get_member_info($Membership_id,$Company_id); 
		
		if($result!=NULL)
		{
			$member_details = array(
                "Error_flag" => 1001,
                "Cust_enroll_id" => $result->Enrollement_id,
                "card_id" => $result->Card_id,
                "Member_name" => $result->First_name.' '.$result->Last_name,
                "Member_email" => $result->User_email_id,
                "Phone_no" => $result->Phone_no 
            );
			
			echo json_encode($member_details);
		}
		else 
		{
          $Result127 = array("Error_flag" => 2003);
          $this->output->set_output(json_encode($Result127)); //Unable to Locate membership id
        }
	}	
	public function edit_enrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
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
			$config["base_url"] = base_url() . "/index.php/Enrollmentc/enrollment";
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->Enroll_model->enrollment_count();
			}
			else
			{
				$total_row = $this->Enroll_model->Company_enrollment_count($session_data['Company_id']);
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
			$data["results12"] = $this->Enroll_model->enrollment_list($config["per_page"], $page);
		}
		else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '1'))
		{
			$data["results12"] = $this->Enroll_model->Selected_company_enrollment_list($config["per_page"], $page,$session_data['Company_id']);
		}
		else if($data['userId'] == '3' || ($data['userId'] == '2' && $SuperSellerFlag == '0'))
		{
			
			$enrollID=$data['enroll'];
			$data["results12"] = $this->Enroll_model->Selected_company_enrollment_list_login_seller($config["per_page"], $page,$session_data['Company_id'],$enrollID);
			
		}
		else
		{
			$data["results12"] = $this->Enroll_model->Selected_company_customer_list($config["per_page"], $page,$session_data['Company_id']);
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
		/***********decrypt value*******************/
		// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
		$Decrypt_Enrollement_id = $_REQUEST['Enrollement_id'];
		$Enroll_details = $this->Igain_model->get_enrollment_details($Decrypt_Enrollement_id);
		
		$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
		$data["Call_center_details"] = $this->Igain_model->Fetch_Callcenter_details($session_data['Company_id']);
		//$data["Finance_user_details"] = $this->Enroll_model->Fetch_Finance_user_details($session_data['Company_id']);
		
		$data["Finance_user_details"] = $this->Igain_model->get_company_outlet_sellers($session_data['Company_id']);
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
		
		
			// echo"---Enroll_details.....".$Enroll_details->Company_id;
			$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
			$data['Fetched_Companys'] = $FetchedCompanys;
			$Enrollement_id =  $Decrypt_Enrollement_id;			
			$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			$data["Bussi_Tier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=1);
			$data["IndTier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=0);
			$data["AllTier_list"] = array_merge($data["Bussi_Tier_list"],$data["IndTier_list"]);
			if($data["IndTier_list"]==NULL){$data["AllTier_list"] =$data["Bussi_Tier_list"];}
			$data["Dmcc_parent_members"] = $this->Enroll_model->get_company_parent_members($session_data['Company_id']);
			
                // var_dump($data['results']);
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Enrollement_id);
				if($Enrollment_details->User_id == 1)
				{
					$Hobby = array();
					$member_hobbies = $this->Enroll_model->Fetch_member_hobbies($Company_id,$Enrollement_id);
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
				
				// echo"----Refrence----".$Enrollment_details->Refrence;
				$Referre_details = $this->Igain_model->get_enrollment_details($Enrollment_details->Refrence);
				
				if($Referre_details != "")
				{
					$data['Refree_name'] = $Referre_details->First_name.' '.$Referre_details->Last_name;
				}
			
			/******************Ravi CHANGED 26-08-2016****************************/
			if($Enrollment_details->User_id == 2)
			{
				$Get_merchant_category = $this->Enroll_model->edit_merchant_category($Company_id,$Enrollement_id);
				$data['Merchant_category']=$Get_merchant_category;
			}
			/******************Ravi CHANGED 26-08-2016****************************/
						
			/******************AMIT CHANGED 04-04-2016****************************/
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$data['Company_id']);
			$data["Partner_Branch_Records"] = $this->Catelogue_model->Get_Partners_Branches($data['results']->Merchandize_Partner_ID);
		/******************************************************************/
			$data["pagination"] = $this->pagination->create_links();
			/**************AMIT 20-11-2017***********************/
			$data['Cust_trans_records'] = $this->Igain_model->get_cust_trans_summary($Enrollement_id);	
			if($data['Cust_trans_records'] != NULL)
			{
				foreach($data['Cust_trans_records'] as $Cust_trans_records)
				{
					$data['Total_gained_points'] = round($Cust_trans_records->Total_gained_points);
				}
			}
			$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
			$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
			$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
			$phNo = App_string_decrypt($data['results']->Phone_no);
			$exp=explode($dial_code,$phNo);
			$data['phnumber'] = $exp[1];
			/*****************************************************/
			$this->load->view('enrollment/edit_enrollment', $data);
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
			
					/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
				/* Create the config for image library */
				$configThumb = array();
				$configThumb['image_library'] = 'gd2';
				$configThumb['source_image'] = '';
				$configThumb['create_thumb'] = TRUE;
				$configThumb['maintain_ratio'] = TRUE;
		
				$configThumb['width'] = 128;
				$configThumb['height'] = 128;
				/* Load the image library */
				$this->load->library('image_lib');
				
				
				$upload22 = $this->upload->do_upload('file');
				$data22 = $this->upload->data();
				// print_r($upload22);
				// echo 'is_image '.$data22['is_image'];die;	
				if($data22['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './uploads/'.$upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='uploads/'.$data22['file_name'];
				}
				else
				{
					$filepath = $this->input->post("Enrollment_image");
				}
				
				$Enrollment_id =  $_REQUEST['Enrollment_id'];
				$User_type_id = $this->input->post('User_id');
				$Sub_seller_Enrollement_id=$this->input->post('Sub_seller_Enrollement_id');
				if($Sub_seller_Enrollement_id!=NULL)
				{
					$Sub_seller_Enrollement_id=$this->input->post('Sub_seller_Enrollement_id');
				}
				else{
				$Sub_seller_Enrollement_id=0;
				}
				
				if($User_type_id == 1)
				{
					$TierID = $this->input->post('member_tier_id');
					$RefrenceD = 0;
					$Allow_services=0;
				}
				else
				{
					/**********GET Longitude and Lattitude *********************/
					$country_name = $this->Igain_model->Get_Country_master($this->input->post('country'));
					
					$Get_states = $this->Igain_model->Get_states($this->input->post('country'));
					foreach($Get_states as $rec)
					{
						if($rec->id==$this->input->post("state"))
						{
							$State_name=$rec->name;
						}
					}
					
					$Get_cities = $this->Igain_model->Get_cities($this->input->post('state'));
					foreach($Get_cities as $rec2)
					{
						if($rec2->id==$this->input->post("city"))
						{
							$City_name=$rec2->name;
						}
					}
					
					 $address =$this->input->post("currentAddress").' '.$City_name.' '.$this->input->post("district").' '.$State_name.' '.$this->input->post("zip").' '.$country_name->name; 
		 
					 
					$prepAddr = str_replace(' ','+',$address);
					 
					$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					 
					$output= json_decode($geocode);
					 
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng; 
					$Location=$latitude."*".$longitude;
					// echo "Location ".$Location;die;
					/*******************************************/
					$TierID = 0;
					$RefrenceD = $this->input->post('Refrence');
					if($RefrenceD!=NULL)
					{
						$RefrenceD = $this->input->post('Refrence');
					}
					else{
					$RefrenceD = 0;
					}
					$Allow_services = $this->input->post('Allow_services');
					if($Allow_services!=NULL)
					{
						$Allow_services=$this->input->post('Allow_services');
					}else{
						$Allow_services=0;
					}
				} 
				if($User_type_id == 6)
				{
					// $Call_center_user = $this->input->post('Call_center_user');
					$Call_center_user = 1;
					
					if($Call_center_user == 1)
					{
						$Call_center_user=1;
						$Supervisor = $this->input->post('Sub_seller_admin');
						if($Supervisor==1)
						{
							$Sub_seller_Enrollement_id=0;
							$Sub_seller_admin=1;
						}
						else
						{
							$Sub_seller_Enrollement_id=$this->input->post('Sub_seller_Enrollement_id');
							$Sub_seller_admin=0;
						}
					}
					else
					{
						$Call_center_user=0;
						$Sub_seller_Enrollement_id=0;
						$Sub_seller_admin=0;
					}	
				}
				if($User_type_id == 7)
				{	
					$Supervisor = $this->input->post('Sub_seller_admin1');
					if($Supervisor==1)
					{
						$Sub_seller_Enrollement_id=0;
						$Sub_seller_admin=1;
					}
					else
					{
						$Sub_seller_Enrollement_id=$this->input->post('Sub_seller_Enrollement_id1');
						$Sub_seller_admin=0;
					}	
				}
				
				if($User_type_id == 6)
				{
					$post_data1=array(
					'Call_center_user' => $Call_center_user,
					'Sub_seller_admin' => $Sub_seller_admin,
					'Sub_seller_Enrollement_id' => $Sub_seller_Enrollement_id
					);
				}
				if($User_type_id == 7)
				{
					$post_data1=array(
					'Sub_seller_admin' => $Sub_seller_admin,
					'Sub_seller_Enrollement_id' => $Sub_seller_Enrollement_id
					);
				}
				else if($User_type_id == 2)
				{
					$post_data1=array(
					'Sub_seller_Enrollement_id' => $Sub_seller_Enrollement_id
					);
				}
				else	
				{
					$post_data1=array();
				}
				$dial_code = $this->Enroll_model->get_dial_code($this->input->post('country'));
				$phnumber = $dial_code.$this->input->post('phno');
				$Seller_Redemptionlimit=$this->input->post('Seller_Redemptionlimit');
				if($Seller_Redemptionlimit!=NULL)
				{
					$Seller_Redemptionlimit=$this->input->post('Seller_Redemptionlimit');
				}else{
					$Seller_Redemptionlimit=0;
				}
				$Seller_Redemptionratio=$this->input->post('Seller_Redemptionratio');
				if($Seller_Redemptionratio!=NULL)
				{
					$Seller_Redemptionratio=$this->input->post('Seller_Redemptionratio');
				}else{
					$Seller_Redemptionratio=0;
				}
				$Seller_Paymentratio=$this->input->post('Seller_Paymentratio');
				if($Seller_Paymentratio!=NULL)
				{
					$Seller_Paymentratio=$this->input->post('Seller_Paymentratio');
				}else{
					$Seller_Paymentratio=0;
				}
				$Seller_sales_tax=$this->input->post('Seller_sales_tax');
				if($Seller_sales_tax!=NULL)
				{
					$Seller_sales_tax=$this->input->post('Seller_sales_tax');
				}else{
					$Seller_sales_tax=0;
				}
				$Website=$this->input->post('Website');
				if($Website!=NULL)
				{
					$Website=$this->input->post('Website');
				}else{
					$Website="";
				}
				$Label_1_value=$this->input->post('Label_1_value');
				if($Label_1_value!=NULL)
				{
					$Label_1_value=$this->input->post('Label_1_value');
				}else{
					$Label_1_value="";
				}
				$Label_2_value=$this->input->post('Label_2_value');
				if($Label_2_value!=NULL)
				{
					$Label_2_value=$this->input->post('Label_2_value');
				}else{
					$Label_2_value="";
				}
				$Label_3_value=$this->input->post('Label_3_value');
				if($Label_3_value!=NULL)
				{
					$Label_3_value=$this->input->post('Label_3_value');
				}else{
					$Label_3_value="";
				}
				$Label_4_value=$this->input->post('Label_4_value');
				if($Label_4_value!=NULL)
				{
					$Label_4_value=$this->input->post('Label_4_value');
				}else{
					$Label_4_value="";
				}
				$Label_5_value=$this->input->post('Label_5_value');
				if($Label_5_value!=NULL)
				{
					$Label_5_value=$this->input->post('Label_5_value');
				}else{
					$Label_5_value="";
				} 
				
					/* 16-06-2020
						'Latitude' => $latitude, 
						'Longitude' => $longitude,	
					*/
				
				$post_data2 = array( 					
					'First_name' => $this->input->post('firstName'),
					'Middle_name' => $this->input->post('middleName'),        
					'Last_name' => $this->input->post('lastName'),       
					'Current_address' => App_string_encrypt($this->input->post('currentAddress')),
					'State' => $this->input->post('state'),
					'District' => $this->input->post('district'),
					'City' => $this->input->post('city'),
					'Zipcode' => $this->input->post('zip'),
					'Country' => $this->input->post('country'),
					'Phone_no' => App_string_encrypt($phnumber),
					'Date_of_birth' => date('Y-m-d',strtotime($this->input->post('dob'))),
					'Sex' => $this->input->post('sex'),
					'Qualification' => $this->input->post('qualifi'),
					'Photograph' => $filepath,
					'Country_id' => $this->input->post('country'),
					'User_email_id' => App_string_encrypt($this->input->post('userEmailId')),
					'Company_id' => $Company_id,
					'User_id' => $this->input->post('User_id'),
					'Seller_Redemptionratio' => $Seller_Redemptionratio,
					'Seller_redemption_limit' => $Seller_Redemptionlimit,
					'Seller_Billingratio' => $Seller_Paymentratio,
					'Merchant_sales_tax' => $Seller_sales_tax, 
					'Seller_api_url' => $this->input->post('Seller_api_url'),
					'Seller_api_url2' => $this->input->post('Seller_api_url2'), 					
					'goods_till_number' => $this->input->post('Seller_goods_till_number'), 
					'Order_preparation_time' => $this->input->post('Order_preparation_time'), 
					'Table_no_flag' => $this->input->post('Table_no_flag'), 
					'Website' => $this->input->post('Website'),
					'Mpesa_auth_key' => $this->input->post('Mpesa_auth_key'),
					'timezone_entry' => $this->input->post('Time_Zone'),
					'Refrence' => $RefrenceD,				
					'Tier_id' => $TierID,
					'Allow_services' => $Allow_services,
					'Label_1_value' => $Label_1_value,
					'Label_2_value' => $Label_2_value,
					'Label_3_value' => $Label_3_value,
					'Label_4_value' => $Label_4_value,
					'Label_5_value' => $Label_5_value
				);					
				$post_data3=(array_merge($post_data1,$post_data2));
				$result = $this->Enroll_model->update_enrollment($post_data3,$Enrollment_id);
				if($result == true)
				{
					$this->session->set_flashdata("data_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
					
					// var_dump($session_data['enroll']);
					// die;
					/*********************igain Log Table change 14-06-2017*************************/
					$opration = 2;	
					$From_enrollid=$session_data['enroll'];
					$userid=$session_data['userId'];
					$what="Update Enrollment";
					$where="Enroll User";
					$toname="";
					$toenrollid = 0;
					$opval =$this->input->post('firstName').' '.$this->input->post('lastName').', ( Enrollement Id- '.$Enrollment_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $this->input->post('firstName');
					$lastName = $this->input->post('lastName');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$From_enrollid,$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table change 14-06-2017*************************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Enrollment!!");
				} 
				redirect("Enrollmentc/enrollment");
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function delete_member()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
		
				/***********decrypt value*******************/
				// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
					redirect('Enrollmentc/IndividiualEnrollment');
				}
				// $Decrypt_Enrollement_id =$_REQUEST['Enrollement_id'];
				$Enrollement_id =  $Decrypt_Enrollement_id;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$Cust_First_name=$Enrollment_details->First_name;
				$Cust_Last_name=$Enrollment_details->Last_name;
				// $Cust_First_name=$Enrollment_details->First_name;
				
				// var_dump($Decrypt_Enrollement_id);
				// die;
				$result = $this->Enroll_model->delete_enrollment($Enrollement_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Enrollment Deleted Successfuly!!");
					
					
				/***************Nilesh Change igain Log Table change 14-06-2017******************/
					$Company_id=$session_data['Company_id'];
					$opration = 3;				
					$data['userId']= $session_data['userId'];
					$what="Delete Enrollment";
					$where="Member Enrollment";
					$toname="";
					$opval = $Cust_First_name.' '.$Cust_Last_name.', ( Enrollement Id- '.$Enrollement_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $Cust_First_name;
					$lastName = $Cust_Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$data['userId'],$opration,$opval,$firstName,$lastName,$Enrollement_id);
					
					/********************igain Log Table change 14-06-2017*************************/
					// redirect("Enrollmentc/enrollment");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
				}
			//	DIE;
			
				redirect("Enrollmentc/IndividiualEnrollment");
				// redirect(current_url());
			
		}
	}
		
	public function delete_partnerenrollment()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
		
				/***********decrypt value*******************/
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
					redirect('Enrollmentc/PartnerUserEnrollment');
				}
				// echo 'Decrypt_Enrollement_id '.$Decrypt_Enrollement_id;die;
				// $Decrypt_Enrollement_id =$_REQUEST['Enrollement_id'];
				$Enrollement_id =  $Decrypt_Enrollement_id;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$Cust_First_name=$Enrollment_details->First_name;
				$Cust_Last_name=$Enrollment_details->Last_name;
				// $Cust_First_name=$Enrollment_details->First_name;
				
				// var_dump($Decrypt_Enrollement_id);
				// die;
				$result = $this->Enroll_model->delete_enrollment($Enrollement_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Enrollment Deleted Successfuly!!");
				/***************Nilesh Change igain Log Table change 14-06-2017******************/
					$Company_id=$session_data['Company_id'];
					$opration = 3;				
					$data['userId']= $session_data['userId'];
					$what="Delete Partner User Enrollment";
					$where="Partner User Enrollment";
					$toname="";
					$opval = $Cust_First_name.' '.$Cust_Last_name.', ( Enrollement Id- '.$Enrollement_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $Cust_First_name;
					$lastName = $Cust_Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$data['userId'],$opration,$opval,$firstName,$lastName,$Enrollement_id);
					
					/********************igain Log Table change 14-06-2017*************************/
					// redirect("Enrollmentc/enrollment");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
				}
			//	DIE;
			
				redirect("Enrollmentc/PartnerUserEnrollment");
				// redirect(current_url());
			
		}
	}
	public function delete_Outletenrollment()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
		
				/***********decrypt value*******************/
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
					redirect('Enrollmentc/OutletEnrollment');
				}
				// echo 'Decrypt_Enrollement_id '.$Decrypt_Enrollement_id;die;
				// $Decrypt_Enrollement_id =$_REQUEST['Enrollement_id'];
				$Enrollement_id =  $Decrypt_Enrollement_id;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$Cust_First_name=$Enrollment_details->First_name;
				$Cust_Last_name=$Enrollment_details->Last_name;
				// $Cust_First_name=$Enrollment_details->First_name;
				
				// var_dump($Decrypt_Enrollement_id);
				// die;
				$result = $this->Enroll_model->delete_enrollment($Enrollement_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Enrollment Deleted Successfuly!!");
				/***************Nilesh Change igain Log Table change 14-06-2017******************/
					$Company_id=$session_data['Company_id'];
					$opration = 3;				
					$data['userId']= $session_data['userId'];
					$what="Delete Outlet Enrollment";
					$where="Outlet Enrollment";
					$toname="";
					$opval = $Cust_First_name.' '.$Cust_Last_name.', ( Enrollement Id- '.$Enrollement_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $Cust_First_name;
					$lastName = $Cust_Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$data['userId'],$opration,$opval,$firstName,$lastName,$Enrollement_id);
					
					/********************igain Log Table change 14-06-2017*************************/
					// redirect("Enrollmentc/enrollment");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
				}
			//	DIE;
			
				redirect("Enrollmentc/OutletEnrollment");
				// redirect(current_url());
			
		}
	}
	public function delete_staffenrollment()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
		
				/***********decrypt value*******************/
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
					redirect('Enrollmentc/StaffUserEnrollment');
				}
				// echo 'Decrypt_Enrollement_id '.$Decrypt_Enrollement_id;die;
				// $Decrypt_Enrollement_id =$_REQUEST['Enrollement_id'];
				$Enrollement_id =  $Decrypt_Enrollement_id;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$Cust_First_name=$Enrollment_details->First_name;
				$Cust_Last_name=$Enrollment_details->Last_name;
				// $Cust_First_name=$Enrollment_details->First_name;
				
				// var_dump($Decrypt_Enrollement_id);
				// die;
				$result = $this->Enroll_model->delete_enrollment($Enrollement_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Enrollment Deleted Successfuly!!");
				/***************Nilesh Change igain Log Table change 14-06-2017******************/
					$Company_id=$session_data['Company_id'];
					$opration = 3;				
					$data['userId']= $session_data['userId'];
					$what="Delete Staff Enrollment";
					$where="Staff Enrollment";
					$toname="";
					$opval = $Cust_First_name.' '.$Cust_Last_name.', ( Enrollement Id- '.$Enrollement_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $Cust_First_name;
					$lastName = $Cust_Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$data['userId'],$opration,$opval,$firstName,$lastName,$Enrollement_id);
					
					/********************igain Log Table change 14-06-2017*************************/
					// redirect("Enrollmentc/enrollment");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
				}
			//	DIE;
			
				redirect("Enrollmentc/StaffUserEnrollment");
				// redirect(current_url());
			
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
			$data['userId'] = $session_data['userId'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
			if($_REQUEST == NULL)
			{
			
		
				$data["results"] = $this->Enroll_model->enrollment_list('', '');
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('enrollment/enrollment', $data);
			}
			else
			{	
		
				/***********decrypt value*******************/
				// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
				$Decrypt_Enrollement_id = App_string_decrypt($_REQUEST['Enrollement_id']);
				// $Decrypt_Enrollement_id =$_REQUEST['Enrollement_id'];
				$Enrollement_id =  $Decrypt_Enrollement_id;
				$Enrollment_details = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$Cust_First_name=$Enrollment_details->First_name;
				$Cust_Last_name=$Enrollment_details->Last_name;
				// $Cust_First_name=$Enrollment_details->First_name;
				
				// var_dump($Decrypt_Enrollement_id);
				// die;
				$result = $this->Enroll_model->delete_enrollment($Enrollement_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Enrollment Deleted Successfuly!!");
					
					//----------SUBSIDIARY & PARENT INACTIVE---------------
						$Inactivate = $this->Enroll_model->Inactivate_subsidiary_employee($Enrollement_id);
						
					//-------------------XXX--------------------
					
							/*****************Delete Merchandise_item_ linked this enrollment id********************/
					$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Merchant_linked_Merchandize_Items($Enrollement_id);
					if($All_Active_Merchandize_Items_Records!=NULL)
					{
						foreach($All_Active_Merchandize_Items_Records as $Val)
						{
								
								/*********************INSERT Item LOG TABLE************************/
								$Post_data3=array(
								'Company_id'=>$Val->Company_id,
								'Company_merchandise_item_id'=>$Val->Company_merchandise_item_id,
								'Company_merchandize_item_code'=>$Val->Company_merchandize_item_code,
								'Partner_id'=>$Val->Partner_id,
								'Cost_price'=>$Val->Cost_price,
								'Valid_from'=>$Val->Valid_from,
								'Valid_till'=>$Val->Valid_till,
								'Markup_percentage'=>$Val->Markup_percentage,
								'Delivery_method'=>$Val->Delivery_method,
								'Merchandize_category_id'=>$Val->Merchandize_category_id,
								'Merchandize_item_name'=>$Val->Merchandize_item_name,
								'Merchandise_item_description'=>$Val->Merchandise_item_description,
								'Cost_payable_to_partner'=>$Val->Cost_payable_to_partner,
								'Billing_price'=>$Val->Billing_price,
								'VAT'=>$Val->VAT,
								'Item_image1'=>$Val->Item_image1,
								'Item_image2'=>$Val->Item_image2,
								'Item_image3'=>$Val->Item_image3,
								'Item_image4'=>$Val->Item_image4,
								'Thumbnail_image1'=>$Val->Thumbnail_image1,
								'Thumbnail_image2'=>$Val->Thumbnail_image2,
								'Thumbnail_image3'=>$Val->Thumbnail_image3,
								'Thumbnail_image4'=>$Val->Thumbnail_image4,
								'Billing_price_in_points'=>$Val->Billing_price_in_points,
								'show_item'=>$Val->show_item,
								'Ecommerce_flag'=>$Val->Ecommerce_flag,
								'Product_group_id'=>$Val->Product_group_id,
								'Product_brand_id'=>$Val->Product_brand_id,
								'Send_once_year'=>$Val->Send_once_year,
								'Send_other_benefits'=>$Val->Send_other_benefits,
								'Create_User_id'=>$Val->Create_User_id,
								'Creation_date'=>$Val->Creation_date,
								'Update_User_id'=>$data['enroll'],
								'Update_date'=>date("Y-m-d H:i:s"),
								'Active_flag'=>1);
						
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data3);
								/********************/
								/**************Update merchandise table**********/
								$Post_data2 = array
								(
									'Update_user_id'=>$data['enroll'],
									'Update_date'=>date("Y-m-d H:i:s"),
									'Thumbnail_image4'=>'Remarks:Merchant deleted',
									'Active_flag'=>0
								);
								$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
							/**************delete temp cart linked item**********/
								$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item($Val->Company_merchandize_item_code,$Val->Company_id);
							
						}
					}
							
					/*****************Delete Merchandise_item_ linked this partner***XXX*****************/
				/***************Nilesh Change igain Log Table change 14-06-2017******************/
					$Company_id=$session_data['Company_id'];
					$opration = 3;				
					$data['userId']= $session_data['userId'];
					$what="Delete Enrollment";
					$where="Enroll User";
					$toname="";
					$opval = $Cust_First_name.' '.$Cust_Last_name.', ( Enrollement Id- '.$Enrollement_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $Cust_First_name;
					$lastName = $Cust_Last_name;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$data['userId'],$opration,$opval,$firstName,$lastName,$Enrollement_id);
					
					/********************igain Log Table change 14-06-2017*************************/
					// redirect("Enrollmentc/enrollment");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
				}
			//	DIE;
			
				// redirect("Enrollmentc/enrollment");
				redirect(current_url());
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
				$this->Enroll_model->get_membername($keyword,$Company_id);
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
			
			if($Countries['id']==$_REQUEST['country_id'])
			{
				
				$country_name= $Countries['name'];
			}
		}
		 $address =$this->input->post("currentAddress").' '.$this->input->post("city").' '.$this->input->post("district").' '.$this->input->post("state").' '.$this->input->post("zip").' '.$country_name; 
		 
		// echo $address;
		
		$prepAddr = str_replace(' ','+',$address);
		 
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		 
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
				 $this->load->view('enrollment/asign_membership', $data);
			}
			else
			{
				
				$Enrollment_id = $this->Enroll_model->validate_member($Company_id,$Country_id);

				if($Enrollment_id > 0)
				{
					$data['results'] = $this->Enroll_model->edit_enrollment($Enrollment_id);
					
					$this->load->view('enrollment/cardassignment', $data);
					//redirect("enrollment/cardassignment");
				}
				else
				{
					$this->session->set_flashdata("error_code","Membership Id Already Assigned Or Member Name/Phone no. Is Invalid!");
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
			$data['userId'] = $session_data['userId'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Company_id = $session_data['Company_id'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];			
			if($Sub_seller_admin==1)
			{
				$Logged_user_enrollid=$Logged_user_enrollid;
			}
			else
			{
				$Logged_user_enrollid=$Sub_seller_Enrollement_id;
			}
				
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points; 
			$Coalition = $resultis->Coalition; 
			
			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');
			
			if($_POST == NULL)
			{
				// $data['results'] = $this->Enroll_model->edit_enrollment($Enrollment_id);
					
				$this->load->view('enrollment/cardassignment', $data);
			}
			else
			{
				
				
				$Enrollment_id =  $_SESSION["Edit_Enrollement_id"];
				$CardID =  $this->input->post('CardID');
				$CardID = preg_replace('/[^A-Za-z0-9\-]/', '', $CardID);
				if($CardID == '' )
				{
					$this->session->set_flashdata("error_code","Please Enter Membership ID !!!");
					redirect('Enrollmentc/asign_membership', 'refresh');	
				}	
				$seller_id = $data['enroll'];
				$Post_Enrollment_id =  $_SESSION["Edit_Enrollement_id"];
				$enrollment_details = $this->Igain_model->get_enrollment_details($Post_Enrollment_id);
				$Cust_topup_amt = $enrollment_details->Total_topup_amt;
				
				$post_data = array
				(					
					'Card_id' => $CardID,
					'Company_id' => $Company_id
				);
				$result = $this->Enroll_model->update_enrollment($post_data,$Enrollment_id);
				
				/********************Nilesh change igain Log Table change 14-06-2017*********************/
				
					$opration = 2;				
					$userid=$data['userId'];
					$what="Assign Membership";
					$where="Assign Membership";
					$toname="";
					$toenrollid = $Post_Enrollment_id;
					$opval = 'Customer - '.$enrollment_details->First_name.' '.$enrollment_details->Last_name.'( Membership Id- '.$this->input->post('CardID');
					$firstName = $enrollment_details->First_name;
					$lastName = $enrollment_details->Last_name;
					
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
					
				/*********************igain Log Table change 14-06-2017********************/
				
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollment_id);
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
					
					/* $topup_BillNo2 = $tp_bill2 + 1;
					$billno_withyear_ref2 = $str2.$topup_BillNo2; */
					
				/**************************AMIT**** Joining Bonus start*******20-05-2016*****************/
				// Joining_bonus_points 
				
				if($Joining_bonus_flag == 1)
				{
					
					
					
					$post_Transdata = array
					(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $Joining_bonus_points,        
						'Trans_date' => $lv_date_time,       
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
				
					$tp_bill2=$tp_bill2+1;
					$billno_withyear_ref25 = $str2.$tp_bill2;	
					$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref25);
					
					/* if($Seller_topup_access=='1')
					{
						$seller_curbal = ($seller_curbal - $Joining_bonus_points);
						$Total_seller_bal2 = $seller_curbal;
						$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal2);
					} */
					  
	
					$Email_content12 = array
					(
						'Joining_bonus_points' => $Joining_bonus_points,
						'Notification_type' => 'Joining Bonus',
						'Template_type' => 'Joining_Bonus',
						'Customer_name' => $customer_name,
						'Todays_date' => $lv_date_time
					);
					
					$this->send_notification->send_Notification_email($Enrollment_id,$Email_content12,$data['enroll'],$Company_id);
					
					$Cust_topup_amt = $Cust_topup_amt + $Joining_bonus_points;
					
					$post_data2 = array
					(
						'Current_balance' => $Joining_bonus_points,
						'Total_topup_amt' => $Cust_topup_amt,
						'Company_id' => $Company_id
					);
					$result2 = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
					
					$tp_bill2=$tp_bill2+1;
					$billno_withyear_ref2 = $str2.$tp_bill2;	
				}
				// die;
				/************ Joining Bonus end **************/	

				
				/************Referee Bonus for Old Customer Start Ravi 16-11-2017**************/	
					$Customer_topup12 = 0;
					$Refree_topup = 0;
					$ref_topup = 0;
					
						
				
				
					
					$referre_enrollID = $_SESSION["Edit_Refrence_Enrollment_id"];
					$user_details = $this->Igain_model->get_enrollment_details($referre_enrollID);
					$referre_membershipID=$user_details->Card_id;
					$referre_curr_bal=$user_details->Current_balance;
					$referre_topup=$user_details->Total_topup_amt;
					$referre_purchase_amt=$user_details->total_purchase;
					$referre_reddem_amount=$user_details->Total_reddems;
					
					
					
					$billno_withyear_ref=$Topup_Bill_no;
					if($referre_membershipID > '0')
					{
						$Referral_rule_for = 1; //*** Referral_rule_for enrollment
						// $Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for);
						$Ref_rule = $this->Transactions_model->select_seller_refrencerule($Logged_user_enrollid,$Company_id,$Referral_rule_for);
					
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
				
					if($referre_membershipID > '0' && $Seller_Refrence == 1 && $ref_topup > 0 )//&& $Coalition==0 12-09-2017 AMIT Changed
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
							/* $refree_current_balnce = $ref_card_bal + $ref_topup;
							$refree_topup = $ref_topup_amt + $ref_topup;
					
							if($Seller_topup_access=='0')
							{
								$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
							} */
							
							/* if($Seller_topup_access == '0')
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
							} */
							
							
							if($Coalition == 1 )
							{
								$refree_current_balnce = $ref_card_bal;
								$refree_topup = $ref_topup_amt;
							}
							else
							{
								$refree_current_balnce = $ref_card_bal + $ref_topup;
								$refree_topup = $ref_topup_amt + $ref_topup;
							}
							
							$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
							
							
							$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);  
							$Seller_curbal = $seller_details2->Current_balance;
							
							$seller_curbal = $Seller_curbal - $ref_topup;
							
							
							/*******************Ravi Change-24-08-2016*********************************/
							$SellerID = $seller_id;
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
								'Bill_no' => $tp_bill2,
								'remark2' => $remark_by,
								'Loyalty_pts' => '0'
							);							
							$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);						
							
							$tp_bill2=$tp_bill2+1;
							$billno_withyear_ref11 = $str.$tp_bill2;
							$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref11);
							
							
							$Total_seller_bal = $seller_curbal;
							if($Seller_topup_access=='1')
							{
								$Total_seller_bal = $seller_curbal;								
								// $result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal);
								$result3 = $this->Transactions_model->update_seller_balance($Logged_user_enrollid,$Total_seller_bal);
							}	
							
						
							/* else							
							{
								$curr_bal=$referre_curr_bal+$ref_topup;
								$topup=$referre_topup+$ref_topup;
								$purchase_amt=$referre_purchase_amt;
								$reddem_amount=$referre_reddem_amount;
								
								$result2 = $this->Coal_Transactions_model->update_customer_balance($referre_membershipID,$curr_bal,$Company_id,$topup,$Todays_date,$purchase_amt,$reddem_amount);
							} */
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
								$this->send_notification->Coal_send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_user_enrollid,$Company_id);
							}
							else
							{
								$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
							}
							// var_dump($Email_content12);
							// die;
							
						}						
						
					}
				/************Referee Bonus for Existing Customer **************/				
				
				
				/************ Referee Bonus for New Customer  **************/	
					if($referre_membershipID > '0' && $Seller_Refrence == 1 && $Customer_topup > 0)// && $Coalition==0
					{
						
						$data['results'] = $this->Enroll_model->edit_enrollment($Enrollment_id);
						$customer_name =$data['results']->First_name." ".$data['results']->Last_name;
					
							$customer_EnrollID = $data['results']->Enrollement_id;
							$customer_Card = $data['results']->Card_id;
							$cust_Current_balance = $data['results']->Current_balance;
							$cust_Total_topup_amt = $data['results']->Total_topup_amt;
							$cust_total_purchase = $data['results']->total_purchase;
							$cust_Total_reddems = $data['results']->Total_reddems;
							
						/********Ravi Cahnge 24-08-2016****Transaction Entry of Refferal bonus for New Customer**************************/
													
							
							$SellerID = $seller_id;
							// $Cust_membershipID=$this->input->post('cardid');
							$post_Transdata12 = array
							(					
								'Trans_type' => '1',
								'Company_id' => $Company_id,
								'Topup_amount' => $Customer_topup,        
								'Trans_date' => $lv_date_time,       
								'Remarks' => 'Referral Trans',
								'Card_id' => $customer_Card,
								'Seller' => $SellerID,
								'Seller_name' => $Seller_name,								
								'Enrollement_id' => $customer_EnrollID,
								'Bill_no' => $tp_bill2,
								'remark2' => $remark_by,
								'Loyalty_pts' => '0'
							);							
							$result6 = $this->Transactions_model->insert_topup_details($post_Transdata12);						
							
							$tp_bill2=$tp_bill2+1;
							$billno_withyear_ref22 = $str2.$tp_bill2;	
							$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref22);
							
							
							
							$seller_details2 = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);  
							$Seller_curbal = $seller_details2->Current_balance;
							
							// $seller_curbal12 = $seller_curbal - $Customer_topup;
							$seller_curbal12 = $Seller_curbal - $Customer_topup;
							if($Seller_topup_access=='1')
							{
								$Total_seller_bal12 = $seller_curbal12;								
								// $result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal12);
								$result3 = $this->Transactions_model->update_seller_balance($Logged_user_enrollid,$Total_seller_bal12);
								
							}	
								
								$Last_customer_record = $this->Igain_model->get_enrollment_details($customer_EnrollID);
								$Last_Card_id=$Last_customer_record->Card_id;
								$Last_Current_balance=$Last_customer_record->Current_balance;
								$Last_Blocked_points=$Last_customer_record->Blocked_points;
								$Last_total_purchase=$Last_customer_record->total_purchase;
								$Last_Total_topup_amt=$Last_customer_record->Total_topup_amt;
								$Last_Total_reddems=$Last_customer_record->Total_reddems;								
								$refree_current_balnce = $Last_Current_balance;
								$refree_topup = $Last_Total_topup_amt + $Customer_topup;
								
							if($Coalition == 1 ) {
								
								$refree_topup1 = $Last_Total_topup_amt;
								$refree_current_balnce = $Last_Current_balance;
								
							} else {
								
								$refree_topup1 = $Last_Total_topup_amt + $Customer_topup;
								$refree_current_balnce = $Last_Current_balance + $Customer_topup;
							}
								
							$result5 = $this->Transactions_model->update_customer_balance($Last_Card_id,$refree_current_balnce,$Company_id,$refree_topup1,$Todays_date,$Last_total_purchase,$Last_Total_reddems);
							
							/* else
							{
								
								
								$curr_bal=$cust_Current_balance+$Customer_topup;
								$topup=$cust_Total_topup_amt+$Customer_topup;
								$purchase_amt=$cust_total_purchase;
								$reddem_amount=$cust_Total_reddems;
								$result2 = $this->Coal_Transactions_model->update_customer_balance($customer_Card,$curr_bal,$Company_id,$topup,$Todays_date,$purchase_amt,$reddem_amount);
							} */
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
							$this->send_notification->Coal_send_Notification_email($customer_EnrollID,$Email_content13,$Logged_user_enrollid,$Company_id);
						}
						else
						{
							 $this->send_notification->send_Notification_email($customer_EnrollID,$Email_content13,$Logged_in_userid,$Company_id);
						}
						
						/* $tp_bill2=$tp_bill2+1;
						$billno_withyear_ref3 = $str.$tp_bill2;
						
						$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref3); */
					}
				/************ Referee Bonus for New Customer  **************/	
				
				
				$Email_content = array(
					'Notification_type' => 'You have Assigned Membership ID Successfuly',
					'Template_type' => 'Assign_membershipid'
				);
				$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$data['enroll'],$Company_id);
				
				
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Membership Id Assigned Successfuly!!");
				}		
				
				redirect("Enrollmentc/asign_membership");			
				// $this->load->view('enrollment/asign_membership', $data);
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	//********************** sandeep work end ********************		
	//********************** Ravi- Tier Change 04-03-2021********************
	public function fetch_tier_details()
	{
		$member_tier_id=$_POST['tier_id'];
		$Company_id=$_POST['Company_id'];
		// var_dump($_POST);
		$result = $this->Enroll_model->get_tier_details($member_tier_id,$Company_id); 
		// var_dump($result);
		if($result!=NULL)
		{
			/* $tier_details = array(
                "Redeemtion_limit" => $result->Redeemtion_limit 
            ); */
			
			
			
			$member_details = array(
                "Redeemtion_limit" => $result->Redeemtion_limit
            );
			
			echo json_encode($member_details);
		}
		else 
		{
			$member_details = array(
                "Redeemtion_limit" =>0
            );
			
			echo json_encode($member_details);
        }
	}
	//********************** Ravi- Tier Change 04-03-2021********************		
	//********************** AMIT KAMBLE 20-04-2022---ENROLLMENTS********************
	function BusinessEnrollment()
	{
		if($this->session->userdata('logged_in'))
		{
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
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			
			if($Sub_seller_admin==1)
			{
                $Logged_user_enrollid=$Logged_user_enrollid;
			}
			else
			{
                $Logged_user_enrollid=$Sub_seller_Enrollement_id;
			}			
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
						
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points;
			$Company_Current_bal = $resultis->Current_bal;
			$Company_Country = $resultis->Country;
			
						
			$data["Bussi_Tier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=1);
			
			$data["IndTier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=0);
			$data["AllTier_list"] = array_merge($data["Bussi_Tier_list"],$data["IndTier_list"]);
			if($data["IndTier_list"]==NULL){$data["AllTier_list"] =$data["Bussi_Tier_list"];}
			
			$referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$Logged_user_enrollid);
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
					
					$remark_by = 'By Outlet';	
					
				}
			
			//Logged_user_enrollid;
			$data["Seller_Refrence"] = $Seller_Refrence;			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
			
			$data["Dmcc_parent_members"] = $this->Enroll_model->get_company_parent_members($session_data['Company_id']);
			
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
				
			$data['Company_array'] = $FetchedCompanys;
			
			$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
			// $data['Country_array'] = $FetchedCountrys;
			
			
			
			
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			
				$Company_License_type = $resultis->Company_License_type;
				
				if($Company_License_type==120){
					// $linc_limit=15000;
					$Code_decode_type_id=26;
				} else if($Company_License_type==253){
					// $linc_limit=5000;
					$Code_decode_type_id=25;
				} else if($Company_License_type==121){
					// $linc_limit=100;
					$Code_decode_type_id=24;
				}
				
				
				$code_decode_data = $this->Enroll_model->get_code_decode_data($Code_decode_type_id,$session_data['Company_id']);
				$linc_limit=$code_decode_data->Code_decode;

				
				$remain_lic = $linc_limit - $data["Total_merchants"];
				if($remain_lic <0){
					$remain_lic=0;
				}
				/* echo "<br>-----Company_License_type----)".$Company_License_type."---";
				echo "<br>-----linc_limit----)".$linc_limit."---";
				echo "<br>-----Total_merchants----)".$data["Total_merchants"]."---";
				echo "<br>-----remain_lic--0--)".$remain_lic."---";  */
				// $remain_lic=10;
				
				$data["remain_lic"]=$remain_lic;
				$data["linc_limit"]=$linc_limit;
				
			/* License Limit */


			
			if($_POST == NULL)
			{
				/* if($data['userId'] == '3' && $session_data['Company_id'] =='1' )
				{					
					$data["results"] = $this->Enroll_model->Get_member_enrollment_list($config["per_page"], $page);
				} */
				$data["results"] = $this->Enroll_model->Get_member_enrollment_list($User_id=1, $Business_flag=1,$Company_id);
		
				$this->load->view('enrollment/BusinessEnrollment', $data);
			}
			else
			{
				if($data["Company_details"]->card_decsion == '1') 
				{ 
					$Card_id=$data["Company_details"]->next_card_no;
				}
				else
				{
					$Card_id=$this->input->post('cardid');
				}
			
				$customer_name = $_REQUEST['Business_org_name'];  
				
		/********** sandeep chng ****email validation **** 10-03-2017 ************/	
					$User_type_id = 1;//member
					$Chk_card=$Card_id;
					
					
					
		
				/************ Referral Bonus **************/
					$$Customer_topup  = 0;
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
					
				
					if($referre_membershipID > '0' && $Seller_Refrence == 1 )//&& $Coalition==0 12-09-2017 AMIT Changed Referral Trans
					{
						$Referral_rule_for = 1; //*** Referral_rule_for enrollment
						$Ref_rule = $this->Transactions_model->select_seller_refrencerule($Logged_user_enrollid,$Company_id,$Referral_rule_for);
					
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
						// echo 'ref_topup '.$ref_topup;die;
						if($ref_Tier_id == 0)
						{
							$ref_member_Tier_id = $ref_Tier_id;
						}						
						if($ref_member_Tier_id == $ref_Tier_id)
						{
							$refree_current_balnce = $ref_card_bal + $ref_topup;
							$refree_topup = $ref_topup_amt + $ref_topup;
							
								
							$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
							

							/*******************Ravi Change-24-08-2016*********************************/
							$SellerID = $seller_id;
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
							
							$tp_bill=$tp_bill+1;
							$billno_withyear_ref = $str.$tp_bill;
							$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
							
							
							
 
			
							$Email_content12 = array
							(
								'Ref_Topup_amount' => $ref_topup,
								'Notification_type' => 'Referral Topup',
								'Template_type' => 'Referral_topup',
								'Customer_name' => $customer_name,
								'Todays_date' => $Todays_date
							);							
							
							$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
							
							
							
						}
						
						
					}
					else
					{
						$ref_Customer_enroll_id = '0';
					}
					
				
					/* if(!$this->upload->do_upload("file"))
					{			
						$filepath = "images/No_Profile_Image.jpg";
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = "uploads/".$data['upload_data']['file_name'];
					} */	
				
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/No_Profile_Image.jpg";
						}


				
				if($Joining_bonus_flag == 1 && $Card_id != ""){
					
					$Customer_topup = $Customer_topup + $Joining_bonus_points;
					
				} 
				
				/* echo"---Seller_topup_access----".$Seller_topup_access."----<br>";
				echo"---Joining_bonus_points----".$Joining_bonus_points."----<br>";
				echo"---Customer_topup----".$Customer_topup."----<br>";
				echo"---Customer_topup12----".$Customer_topup12."----<br>";
				die; */
				
					
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				$Participating_flag=$_REQUEST['Participating_flag'];
				if($_REQUEST['Parent_flag']==0 ){$Tier_id = $_REQUEST['Parent_tier'];$Participating_flag=0;}else{$Tier_id = $_REQUEST['Bussiness_tier_id'];}
				
				//--------------Enroll Member-------------------------------
				$Insert_enroll_data = array
				(
					'Company_id' => $Company_id,
					'User_id' => 1,
					'Business_flag' => 1,
					'Parent_flag' => $_REQUEST['Parent_flag'],
					'Participating_flag' => $Participating_flag,
					'First_name' => $_REQUEST['Business_org_name'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $_REQUEST['sex'],
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'Current_balance' => $Customer_topup,
					'Total_topup_amt' => $Customer_topup,
					'Refrence' => $ref_Customer_enroll_id,
					'Card_id' => $Card_id,
					'pinno' => $Pin_no,
					'Tier_id' => $Tier_id,
					'User_activated' => 1,
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$result = $this->Enroll_model->Insert_enrollment($Insert_enroll_data);
				//--------------Enroll Sub Suller Admin(Brand)-------------------------------
				$Insert_enroll_data2 = array
				(
					'Company_id' => $Company_id,
					'User_id' => 2,
					'Business_flag' => 1,
					'Parent_flag' => $_REQUEST['Parent_flag'],
					'Participating_flag' => $Participating_flag,
					'First_name' => $_REQUEST['Business_org_name'], 
					'Last_name' => '.', 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $_REQUEST['sex'],
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'Refrence' => 1,
					'pinno' => $Pin_no,
					'User_activated' => 1,
					'Sub_seller_admin' => 1,
					'Seller_Redemptionratio' => $Seller_Redemptionratio,
					'Business_user_linked_id' => $result,
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$outlet_id = $this->Enroll_model->Insert_enrollment($Insert_enroll_data2);
				
				$post_data2 = array
				(
					'Purchase_Bill_no' => date('Y')."-$outlet_id"."00000000",
					'Topup_Bill_no' => date('Y')."-$outlet_id"."10000000"
				);
				$result21 = $this->Enroll_model->update_enrollment($post_data2,$outlet_id);
				//------------------Update Business_user_linked_id of Member----------------------------
				
				$post_data24 = array
				(
					'Business_user_linked_id' => $outlet_id
				);
				$result21 = $this->Enroll_model->update_enrollment($post_data24,$result);
				//-------------------------------------------------------------------
				

				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="Bussiness Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['Business_org_name'].' Enrollement ID- ('.$result.')';
					$firstName = $_REQUEST['Business_org_name'];
					$lastName = '';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
				
				if($referre_membershipID > '0' && $Seller_Refrence == 1 && $Customer_topup12 > 0)// && $Coalition==0
				{
				
					/********Ravi Cahnge 24-08-2016****Transaction Entry of Refferal bonus for New Customer**************************/
												
						
						$SellerID = $seller_id;
						$Cust_membershipID=$Card_id;
						$post_Transdata12 = array
						(					
							'Trans_type' => '1',
							'Company_id' => $Company_id,
							'Topup_amount' => $Customer_topup12,        
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
						
						$tp_bill=$tp_bill+1;
						$billno_withyear_ref = $str.$tp_bill;
						$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
						
						
					/***********************Ravi Cahnge 24-08-2016*************************************************/
					
						$Email_content13 = array(
							// 'Ref_Topup_amount' => $Customer_topup,
							'Ref_Topup_amount' => $Customer_topup12,
							'Notification_type' => 'Referee Topup',
							'Template_type' => 'Referee_topup',
							'Customer_name' => $ref_name,
							'Todays_date' => $Todays_date
						);
						
						
						 $this->send_notification->send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
									
					
				}
			
				/**************************AMIT**** Joining Bonus start**************/
				// Joining_bonus_points 
					if($Joining_bonus_flag == 1)// && $Coalition==0
					{
						
						$SellerID = $seller_id;
						/*******************Ravi Change-24-08-2016*********************************/
						$post_Transdata = array(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $Joining_bonus_points,        
						'Trans_date' => $lv_date_time,       
						'Remarks' => 'Joining Bonus',
						'Card_id' => $Card_id,
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
						
						
						 
		
						$Email_content12 = array(
							'Joining_bonus_points' => $Joining_bonus_points,
							'Notification_type' => 'Joining Bonus',
							'Template_type' => 'Joining_Bonus',
							'Customer_name' => $customer_name,
							'Todays_date' => $Todays_date
						);
						
						$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
						
						
					}					
				/************ Joining Bonus end **************/
				if($data["Company_details"]->card_decsion =='1')
				{
					$Card_id++;
					$UpdateCardID = $this->Enroll_model->UpdateCompanyMembershipID($Card_id,$Company_id);			
				}				
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => "Member Loyalty Program"
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
				
				redirect(current_url());									
			}	
							
		}
		else
		{
			
			redirect('Login', 'refresh');
		}
	}
	public function Edit_BusinessEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
				
			$data["results12"] = $this->Enroll_model->Get_member_enrollment_list($User_id=1, $Business_flag=1,$Company_id);
			
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
			/***********decrypt value*******************/
			// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
			$Decrypt_Enrollement_id = $_REQUEST['Enrollement_id'];
			$Enroll_details = $this->Igain_model->get_enrollment_details($Decrypt_Enrollement_id);
			
		
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				$Enrollement_id =  $Decrypt_Enrollement_id;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$data["Bussi_Tier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=1);
				$data["IndTier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=0);
				$data["AllTier_list"] = array_merge($data["Bussi_Tier_list"],$data["IndTier_list"]);
				if($data["IndTier_list"]==NULL){$data["AllTier_list"] =$data["Bussi_Tier_list"];}
				$data["Dmcc_parent_members"] = $this->Enroll_model->get_company_parent_members($session_data['Company_id']);
				
					// var_dump($data['results']);
					$Enrollment_details = $data['results'];
					
					
					// echo"----Refrence----".$Enrollment_details->Refrence;
					$Referre_details = $this->Igain_model->get_enrollment_details($Enrollment_details->Refrence);
					
					if($Referre_details != "")
					{
						$data['Refree_name'] = $Referre_details->First_name.' '.$Referre_details->Last_name;
					}
				
				
				/**************AMIT 20-11-2017***********************/
				$data['Cust_trans_records'] = $this->Igain_model->get_cust_trans_summary($Enrollement_id);	
				if($data['Cust_trans_records'] != NULL)
				{
					foreach($data['Cust_trans_records'] as $Cust_trans_records)
					{
						$data['Total_gained_points'] = round($Cust_trans_records->Total_gained_points);
					}
				}
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
				$phNo = App_string_decrypt($data['results']->Phone_no);
				$exp=explode($dial_code,$phNo);
				$data['phnumber'] = $exp[1];
				/*****************************************************/
				$this->load->view('enrollment/Edit_BusinessEnrollment', $data);
			}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	public function update_bussiness_enrollment()
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
			
					/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
				/* Create the config for image library */
				$configThumb = array();
				$configThumb['image_library'] = 'gd2';
				$configThumb['source_image'] = '';
				$configThumb['create_thumb'] = TRUE;
				$configThumb['maintain_ratio'] = TRUE;
		
				$configThumb['width'] = 128;
				$configThumb['height'] = 128;
				/* Load the image library */
				$this->load->library('image_lib');
				
				
				$upload22 = $this->upload->do_upload('file');
				$data22 = $this->upload->data();
				// print_r($upload22);
				// echo 'is_image '.$data22['is_image'];die;	
				if($data22['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './uploads/'.$upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='uploads/'.$data22['file_name'];
				}
				else
				{
					$filepath = $this->input->post("Enrollment_image");
				}
				
				$Enrollment_id =  $_REQUEST['Enrollment_id'];
				$Business_user_linked_id =  $_REQUEST['Business_user_linked_id'];
				$TierID = $this->input->post('member_tier_id');
				if($_REQUEST['Parent_flag']==1 ){$TierID = $_REQUEST['Bussiness_tier_id'];}else
				{$TierID = $_REQUEST['Parent_tier'];}
				$RefrenceD = 0;
				$Allow_services=0;
				
				
				$dial_code = $this->Enroll_model->get_dial_code($this->input->post('country'));
				$phnumber = $dial_code.$this->input->post('phno');
				
				
				$post_data2 = array( 					
					'First_name' => $this->input->post('Business_org_name'),
					'Participating_flag' => $this->input->post('Participating_flag'),
					'Current_address' => App_string_encrypt($this->input->post('currentAddress')),
					'State' => $this->input->post('state'),
					'District' => $this->input->post('district'),
					'City' => $this->input->post('city'),
					'Zipcode' => $this->input->post('zip'),
					'Country' => $this->input->post('country'),
					'Phone_no' => App_string_encrypt($phnumber),
					'Date_of_birth' => date('Y-m-d',strtotime($this->input->post('dob'))),
					'Sex' => $this->input->post('sex'),
					'Qualification' => $this->input->post('qualifi'),
					'Photograph' => $filepath,
					'Country_id' => $this->input->post('country'),
					'User_email_id' => App_string_encrypt($this->input->post('userEmailId')),
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s'),
					'Tier_id' => $TierID
				);					
				$result = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
				
				
				
				//-----------------Update Sub Seller ------------------
				$post_data24 = array( 					
					'Participating_flag' => $this->input->post('Participating_flag'),
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s')
				);					
				$result2 = $this->Enroll_model->update_enrollment($post_data24,$Business_user_linked_id);
				///-----------------------
				
				
				if($result == true)
				{
					$this->session->set_flashdata("data_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
					
					// var_dump($session_data['enroll']);
					// die;
					/*********************igain Log Table change 14-06-2017*************************/
					$opration = 2;	
					$From_enrollid=$session_data['enroll'];
					$userid=$session_data['userId'];
					$what="Update Bussiness Enrollment";
					$where="Bussiness Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval =$this->input->post('Business_org_name').' , ( Enrollement Id- '.$Enrollment_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $this->input->post('Business_org_name');
					$lastName = '';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$From_enrollid,$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table change 14-06-2017*************************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Enrollment!!");
				} 
				redirect("Enrollmentc/BusinessEnrollment");
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	
	function IndividiualEnrollment()
	{
		if($this->session->userdata('logged_in'))
		{
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
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			
			if($Sub_seller_admin==1)
			{
                $Logged_user_enrollid=$Logged_user_enrollid;
			}
			else
			{
                $Logged_user_enrollid=$Sub_seller_Enrollement_id;
			}			
			// $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
						
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points;
			$Company_Current_bal = $resultis->Current_bal;
			$Company_Country = $resultis->Country;
			$Seller_licences_limit = $resultis->Seller_licences_limit;
			
						
			// $data["Bussi_Tier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=1);Parent_tier
			
			$data["IndTier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=0);
			// $data["AllTier_list"] = array_merge($data["Bussi_Tier_list"],$data["IndTier_list"]);
			$data["AllTier_list"] = $data["IndTier_list"];
			// if($data["IndTier_list"]==NULL){$data["AllTier_list"] =$data["Bussi_Tier_list"];}
			
						
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
					
					$remark_by = 'By Outlet';	
					
				}
			
			//Logged_user_enrollid;
			$data["Seller_Refrence"] = $Seller_Refrence;			
			
			
			
			// $data["Dmcc_parent_members"] = $this->Enroll_model->get_company_parent_members($session_data['Company_id']);
			
			$Partner_company_flag=$resultis->Partner_company_flag;

			
			
			// $data['Country_array'] = $FetchedCountrys;
			
			
			
			
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
				$Total_merchants = $this->Enroll_model->get_total_merchant($session_data['Company_id']);
				
				$remain_lic = $Seller_licences_limit - $Total_merchants;
				if($remain_lic <0){
					$remain_lic=0;
				}
				/* echo "<br>-----Company_License_type----)".$Company_License_type."---";
				echo "<br>-----linc_limit----)".$linc_limit."---";
				echo "<br>-----Total_merchants----)".$data["Total_merchants"]."---";
				echo "<br>-----remain_lic--0--)".$remain_lic."---";  */
				// $remain_lic=10;
				
				$data["remain_lic"]=$remain_lic;
				// $data["linc_limit"]=$linc_limit;
				
			/* License Limit */


			
			if($_POST == NULL)
			{
				/* if($data['userId'] == '3' && $session_data['Company_id'] =='1' )
				{					
					$data["results"] = $this->Enroll_model->Get_member_enrollment_list($config["per_page"], $page);
				} Refrence Refree_name*/
				$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
				$referral_rule_count = $this->Enroll_model->enroll_referralrule_count($Company_id,$Logged_user_enrollid);
				
				$data["referral_rule_count"] = $referral_rule_count;
				if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
				{
					$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
				}
				else 
				{
					$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
					
				}	
					
				$data['Company_array'] = $FetchedCompanys;
				
				$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
			
				$data["results"] = $this->Enroll_model->Get_member_enrollment_list($User_id=1, $Business_flag=0,$Company_id);
		
				$this->load->view('enrollment/IndividiualEnrollment', $data);
			}
			else
			{
				
				$firstName = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$middleName = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$lastName = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
		
				$currentAddress = strip_tags($_REQUEST['currentAddress']);
				$zip = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$qualifi = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$phno = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['phno']);
				$district = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				
				
				
			if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
			  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			if(strlen($_REQUEST['phno']) != 10)
			{
				$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
			if($sex != '0' && $sex != 'Male' && $sex != 'Female')
			{
				$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
			if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1  || is_numeric($_REQUEST['Indi_tier_id']) != 1 )
			{
				$this->session->set_flashdata("error_code","Invalid data");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
			/* if (!in_array($_REQUEST['Indi_tier_id'],$data["IndTier_list"]))
			{
				$this->session->set_flashdata("error_code","Please Select Valid Tier");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');		
			} */
				
				if($resultis->card_decsion == '1') 
				{ 
					$Card_id=$resultis->next_card_no;
				}
				else
				{
					// $Card_id=$this->input->post('cardid');Business_flag Enrollment_id
					$Card_id = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['cardid']);
				}
			
			
				
			if($firstName== '' || $lastName== '' || $currentAddress== '' || $phno== '' || $Card_id== '' ||  $_REQUEST['country']== '' || $_REQUEST['state']== '' || $_REQUEST['city']== '' || $_REQUEST['Indi_tier_id']== '')
			{
				$this->session->set_flashdata("error_code","Please fill all the required fields !!!");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
				
				$customer_name = $firstName;  
				
		/********** sandeep chng ****email validation **** 10-03-2017 ************/	
					$User_type_id = 1;//member
					$Chk_card=$Card_id;
					
					
					
		
				/************ Referral Bonus **************/
					$Customer_topup  = 0;
					$Customer_topup12 = 0;
					$Refree_topup = 0;
					$ref_topup = 0;
					
					$logtimezone = $session_data['timezone_entry'];
					$timezone = new DateTimeZone($logtimezone);
					$date = new DateTime();
					$date->setTimezone($timezone);
					$lv_date_time=$date->format('Y-m-d H:i:s');
					$Todays_date = $date->format('Y-m-d');	
				
				
					
					
					$billno_withyear_ref=$Topup_Bill_no;
					
				
					// if($referre_membershipID > '0' && $Seller_Refrence == 1 )//&& $Coalition==0 12-09-2017 AMIT Changed Referral Trans
					if($Seller_Refrence == 1 )//&& $Coalition==0 12-09-2017 AMIT Changed Referral Trans
					{
						// $referre_enrollID = $this->input->post("Refree_name");
						$referre_enrollID = strip_tags($_REQUEST['Refree_name']);
						$referre_membershipID = substr(strrchr($referre_enrollID, "-"), 1); 
					
						$Referral_rule_for = 1; //*** Referral_rule_for enrollment
						$Ref_rule = $this->Transactions_model->select_seller_refrencerule($Logged_user_enrollid,$Company_id,$Referral_rule_for);
					
						if($Ref_rule != NULL)
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
							
							
							$Customer_topup12 = $Customer_topup;						
							$ref_cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$referre_membershipID);
							
							if($ref_cust_details != NULL){	
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
							// echo 'ref_topup '.$ref_topup;die;
							if($ref_Tier_id == 0)
							{
								$ref_member_Tier_id = $ref_Tier_id;
							}						
							if($ref_member_Tier_id == $ref_Tier_id)
							{
								$refree_current_balnce = $ref_card_bal + $ref_topup;
								$refree_topup = $ref_topup_amt + $ref_topup;
								
									
								$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
								

								/*******************Ravi Change-24-08-2016*********************************/
								$SellerID = $seller_id;
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
								
								$tp_bill=$tp_bill+1;
								$billno_withyear_ref = $str.$tp_bill;
								$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
								
								
								
	 
				
								$Email_content12 = array
								(
									'Ref_Topup_amount' => $ref_topup,
									'Notification_type' => 'Referral Topup',
									'Template_type' => 'Referral_topup',
									'Customer_name' => $customer_name,
									'Todays_date' => $Todays_date
								);							
								
								$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
								
								}
								
							}
							else
							{
								$this->session->set_flashdata("error_code","Please Enter Valid Reference !!!");
								redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
							}
							
						}
					}
					else
					{
						$ref_Customer_enroll_id = '0';
						
					}
					
				
					/* if(!$this->upload->do_upload("file"))
					{			
						$filepath = "images/No_Profile_Image.jpg";
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = "uploads/".$data['upload_data']['file_name'];
					} */	
				
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/no_image.jpeg";
						}
						if($this->upload->display_errors())
						{
							if($data22['file_name']!='')
							{
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
							}
							
						}


				// echo"---Seller_Refrence----".$Seller_Refrence."----<br>";
				if($Joining_bonus_flag == 1 && $Card_id != ""){
					
					$Customer_topup = $Customer_topup + $Joining_bonus_points;
					
				} 
				// echo"---Customer_topup----".$Customer_topup."----<br>";
				/* echo"---Seller_topup_access----".$Seller_topup_access."----<br>";
				echo"---Joining_bonus_points----".$Joining_bonus_points."----<br>";
				echo"---Customer_topup----".$Customer_topup."----<br>";
				echo"---Customer_topup12----".$Customer_topup12."----<br>";
				die; */
				$email_result = $this->Enroll_model->check_userEmailId($_REQUEST['userEmailId'],$data['Company_id'],'1');
					
					if($email_result > 0)
					{
						$this->session->set_flashdata("error_code","User Email Id Already Exists");
						redirect('Enrollmentc/IndividiualEnrollment');
					}
					
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$_REQUEST['country']);
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$phno;
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				// if($_REQUEST['Employee_flag']==1 ){$Tier_id = $_REQUEST['Parent_tier'];}else{$Tier_id = $_REQUEST['Indi_tier_id'];}
				$Tier_id = $_REQUEST['Indi_tier_id'];
				// die;
				//--------------Enroll Member-------------------------------
				$Insert_enroll_data = array
				(
					'Company_id' => $Company_id,
					'User_id' => 1,
					'Business_flag' => 0,
					'Employee_flag' => 0,
					'First_name' => $firstName, 
					'Middle_name' => $middleName, 
					'Last_name' => $lastName, 
					'Current_address' =>  App_string_encrypt($currentAddress), 
					'State' => $_REQUEST['state'],
					'District' => $district,
					'City' => $_REQUEST['city'],
					'Zipcode' => $zip,
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $sex,
					'Qualification' => $qualifi,
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'Current_balance' => $Customer_topup,
					'Total_topup_amt' => $Customer_topup,
					'Refrence' => $ref_Customer_enroll_id,
					'Card_id' => $Card_id,
					'pinno' => $Pin_no,
					'Tier_id' => $Tier_id,
					'User_activated' => 1,
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$result = $this->Enroll_model->Insert_enrollment($Insert_enroll_data);
				
				//-------------------------------------------------------------------
				

				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="Individiual Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $firstName.' Enrollement ID- ('.$result.')';
					$firstName = $firstName;
					$lastName = $lastName;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
				
				if($referre_membershipID > '0' && $Seller_Refrence == 1 && $Customer_topup12 > 0)// && $Coalition==0
				{
				
					/********Ravi Cahnge 24-08-2016****Transaction Entry of Refferal bonus for New Customer**************************/
												
						
						$SellerID = $seller_id;
						$Cust_membershipID=$Card_id;
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
						
						$tp_bill=$tp_bill+1;
						$billno_withyear_ref = $str.$tp_bill;
						$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
						
						
					/***********************Ravi Cahnge 24-08-2016*************************************************/
					
						$Email_content13 = array(
							'Ref_Topup_amount' => $Customer_topup,
							'Notification_type' => 'Referee Topup',
							'Template_type' => 'Referee_topup',
							'Customer_name' => $ref_name,
							'Todays_date' => $Todays_date
						);
						
					
						 $this->send_notification->send_Notification_email($Last_enroll_id,$Email_content13,$Logged_in_userid,$Company_id);
									
					
				}
			
				/**************************AMIT**** Joining Bonus start**************/
				// Joining_bonus_points 
					if($Joining_bonus_flag == 1)// && $Coalition==0
					{
						
						$SellerID = $seller_id;
						/*******************Ravi Change-24-08-2016*********************************/
						$post_Transdata = array(					
						'Trans_type' => '1',
						'Company_id' => $Company_id,
						'Topup_amount' => $Joining_bonus_points,        
						'Trans_date' => $lv_date_time,       
						'Remarks' => 'Joining Bonus',
						'Card_id' => $Card_id,
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
						
						
						 
		
						$Email_content12 = array(
							'Joining_bonus_points' => $Joining_bonus_points,
							'Notification_type' => 'Joining Bonus',
							'Template_type' => 'Joining_Bonus',
							'Customer_name' => $customer_name,
							'Todays_date' => $Todays_date
						);
						
						$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$Logged_in_userid,$Company_id);
						
						
					}					
				/************ Joining Bonus end **************/
								
				if($data["Company_details"]->card_decsion =='1')
				{
					$Card_id++;
					$UpdateCardID = $this->Enroll_model->UpdateCompanyMembershipID($Card_id,$Company_id);			
				}
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => "Member Loyalty Program"
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
						
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');								
			}	
							
		}
		else
		{
			
			redirect('Login', 'refresh');
		}
	}
		
	public function Edit_IndividiulEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
				
			$data["results12"] = $this->Enroll_model->Get_member_enrollment_list($User_id=1, $Business_flag=0,$Company_id);
			
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;
			

			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			/***********decrypt value*******************/
			// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
			$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
			
			if(!is_numeric($Decrypt_Enrollement_id))
			{
				redirect('Enrollmentc/IndividiualEnrollment');
			}
			$Enroll_details = $this->Igain_model->get_enrollment_details($Decrypt_Enrollement_id);
			
		
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				$Enrollement_id =  $Decrypt_Enrollement_id;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
				$data["IndTier_list"] = $this->Enroll_model->get_company_tiers($Company_id,$Tier_Business_flag=0);
				
					$Enrollment_details = $data['results'];
					
					
					// echo"----Refrence----".$Enrollment_details->Refrence;
					$Referre_details = $this->Igain_model->get_enrollment_details($Enrollment_details->Refrence);
					
					if($Referre_details != "")
					{
						$data['Refree_name'] = $Referre_details->First_name.' '.$Referre_details->Last_name;
					}
				
				
				/**************AMIT 20-11-2017***********************/
				$data['Cust_trans_records'] = $this->Igain_model->get_cust_trans_summary($Enrollement_id);	
				if($data['Cust_trans_records'] != NULL)
				{
					foreach($data['Cust_trans_records'] as $Cust_trans_records)
					{
						$data['Total_gained_points'] = round($Cust_trans_records->Total_gained_points);
					}
				}
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
				$phNo = App_string_decrypt($data['results']->Phone_no);
				$exp=explode($dial_code,$phNo);
				$data['phnumber'] = $exp[1];
				/*****************************************************/
				$this->load->view('enrollment/Edit_IndividiulEnrollment', $data);
			}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function update_individiual_enrollment()
	{  
		if($this->session->userdata('logged_in'))
		{
				$firstName = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$middleName = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$lastName = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
		
				$currentAddress = strip_tags($_REQUEST['currentAddress']);
				$zip = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$qualifi = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$phno = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['phno']);
				$district = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				
				
				
			if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
			  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			if(strlen($phno) != 10)
			{
				$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
			if($sex != '0' && $sex != 'Male' && $sex != 'Female')
			{
				$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
			if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($phno) != 1  || is_numeric($_REQUEST['Indi_tier_id']) != 1 )
			{
				$this->session->set_flashdata("error_code","Invalid data");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
		
				
			if($firstName== '' || $lastName== '' || $currentAddress== '' || $phno== '' || $_REQUEST['country']== '' || $_REQUEST['state']== '' || $_REQUEST['city']== '' || $_REQUEST['Indi_tier_id']== '')
			{
				$this->session->set_flashdata("error_code","Please fill all the required fields !!!");
				redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
			}
			
								
				
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$data['userId']= $session_data['userId'];
			
					/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
				/* Create the config for image library */
				$configThumb = array();
				$configThumb['image_library'] = 'gd2';
				$configThumb['source_image'] = '';
				$configThumb['create_thumb'] = TRUE;
				$configThumb['maintain_ratio'] = TRUE;
				
				$configThumb['width'] = 128;
				$configThumb['height'] = 128;
				/* Load the image library */
				$this->load->library('image_lib');
				
				
				$upload22 = $this->upload->do_upload('file');
				$data22 = $this->upload->data();
				// print_r($upload22);
				// echo 'is_image '.$data22['is_image'];die;Time_Zone	
				if($data22['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './uploads/'.$upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='uploads/'.$data22['file_name'];
				}
				else
				{
					
					$filepath = $_SESSION["Photograph"];
				}
				if($this->upload->display_errors())
				{
					if($data22['file_name']!='')
					{
						$this->session->set_flashdata("error_code",$this->upload->display_errors());
						redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
					}
					
				}
				
					
				$Enrollment_id =  $_SESSION["Edit_Enrollement_id"];
				$TierID = $_REQUEST['Indi_tier_id'];
				// echo $_REQUEST['Employee_flag'];die;
				$RefrenceD = 0;
				$Allow_services=0;
				
				
				$dial_code = $this->Enroll_model->get_dial_code($_REQUEST['country']);
				$phnumber = $dial_code.$phno;
				
				
				$post_data2 = array( 					
					'First_name' => $firstName, 
					'Middle_name' => $middleName, 
					'Last_name' => $lastName,
					'Current_address' => App_string_encrypt($currentAddress),
					'State' => $_REQUEST['state'],
					'District' => $district,
					'City' => $_REQUEST['city'],
					'Zipcode' => $zip,
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($phnumber),
					'Date_of_birth' => date('Y-m-d',strtotime($this->input->post('dob'))),
					'Sex' => $sex,
					'Qualification' => $qualifi,
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($this->input->post('userEmailId')),
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s'),
					'Tier_id' => $TierID
				);			
// print_r($post_data2);die;				
				$result = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
				if($result == true)
				{
					$this->session->set_flashdata("data_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
					
					// var_dump($session_data['enroll']);
					// die;
					/*********************igain Log Table change 14-06-2017*************************/
					$opration = 2;	
					$From_enrollid=$session_data['enroll'];
					$userid=$session_data['userId'];
					$what="Update Individiual Enrollment";
					$where="Individiual Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval =$this->input->post('firstName').' , ( Enrollement Id- '.$Enrollment_id.' )';
					$Todays_date=date("Y-m-d");
					$firstName = $this->input->post('firstName');
					$lastName = '';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$From_enrollid,$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**********************igain Log Table change 14-06-2017*************************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Enrollment!!");
				} 
				redirect("Enrollmentc/IndividiualEnrollment");
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	
	function StaffUserEnrollment()
	{
		if($this->session->userdata('logged_in'))
		{
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
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			$Todays_date = date('Y-m-d H:i:s');
			
			
			
			
			
			// $data['Country_array'] = $FetchedCountrys;
			
			
			

			
			if($_POST == NULL)
			{
				/* if($data['userId'] == '3' && $session_data['Company_id'] =='1' )
				{					
					$data["results"] = $this->Enroll_model->Get_member_enrollment_list($config["per_page"], $page);
				} */
				$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
						
				$data["Finance_user_details"] = $this->Igain_model->get_company_outlet_sellers($session_data[	'Company_id']);
				$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
				$data["results"] = $this->Enroll_model->Get_user_enrollment_list($User_id=7,$Company_id);
				
				if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
				{
					$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
				}
				else 
				{
					$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
					
				}	
					
				$data['Company_array'] = $FetchedCompanys;
				
				$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
			
				$this->load->view('enrollment/StaffUserEnrollment', $data);
			}
			else
			{

					/*-----------------------File Upload---------------------*/
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '1500';
					$config['max_width'] = '1920';
					$config['max_height'] = '1280';
					$config['encrypt_name'] = true;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/No_Profile_Image.jpg";
						}
						if($this->upload->display_errors())
						{
							if($data22['file_name']!='')
							{
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
							}
							
						}
				$Supervisor_Enrollement_id1=0;
				if($_REQUEST['Supervisor1']==0){$Supervisor_Enrollement_id1=$_REQUEST['Supervisor_Enrollement_id1'];}
				
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1   || is_numeric($_REQUEST['Supervisor1']) != 1   || is_numeric($Supervisor_Enrollement_id1) != 1 )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
			
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				
				//--------------Enroll staff-------------------------------
				
				if($_REQUEST['firstName'] == '' || $_REQUEST['lastName'] == '' || $_REQUEST['currentAddress'] == '' || $_REQUEST['country'] == '' || $_REQUEST['state'] == '' ||   $_REQUEST['city'] == '' ||   $_REQUEST['userEmailId'] == '' ||   $_REQUEST['phno'] == ''    )
				{
					$this->session->set_flashdata("error_code","Please Enter all the Required fields !!!");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				$Insert_enroll_data = array
				(
					'Company_id' => $Company_id,
					'User_id' => 7,
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Sub_seller_admin' => $_REQUEST['Supervisor1'],
					'Sub_seller_Enrollement_id' => $Supervisor_Enrollement_id1,
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $sex,
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'pinno' => $Pin_no,
					'User_activated' => 1,
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$result = $this->Enroll_model->Insert_enrollment($Insert_enroll_data);
				
				//-------------------------------------------------------------------
				

				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="Staff User Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$result.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
								
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => "STAFF USER ENROLLMENT"
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
						
				redirect(current_url());									
			}	
							
		}
		else
		{
			
			redirect('Login', 'refresh');
		}
	}
		
	public function Edit_StaffUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			if($_REQUEST)
			{				
		
				$data["results12"] = $this->Enroll_model->Get_user_enrollment_list($User_id=7,$Company_id);
				
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
				

				/***********decrypt value*******************/
				// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					redirect('Enrollmentc/StaffUserEnrollment');
				}
				$Enroll_details = $this->Igain_model->get_enrollment_details($Decrypt_Enrollement_id);
			
		
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				$Enrollement_id =  $Decrypt_Enrollement_id;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
				
								
				/**************AMIT 20-11-2017***********************/
				$data["Finance_user_details"] = $this->Igain_model->get_company_outlet_sellers($session_data['Company_id']);
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
				$phNo = App_string_decrypt($data['results']->Phone_no);
				$exp=explode($dial_code,$phNo);
				$data['phnumber'] = $exp[1];
				/*****************************************************/
				$this->load->view('enrollment/Edit_StaffUserEnrollment', $data);
			}
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	public function Update_StaffUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
				$Sub_seller_Enrollement_id1=0;
				if($_REQUEST['Sub_seller_admin1']==0){$Sub_seller_Enrollement_id1=$_REQUEST['Sub_seller_Enrollement_id1'];}
				$Enrollment_id = $_SESSION["Edit_Enrollement_id"];
				
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1   || is_numeric($_REQUEST['Sub_seller_admin1']) != 1   || is_numeric($Sub_seller_Enrollement_id1) != 1 )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
			
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '1500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						// print_r($upload22);
						// echo 'is_image '.$data22['is_image'];die;	
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = $_SESSION["Photograph"];
						}

						if($this->upload->display_errors())
						{
							if($data22['file_name']!='')
							{
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
							}
							
						}
					
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				
				/*  echo "<br>Sub_seller_admin1 ".$_REQUEST['Sub_seller_admin1'];
				echo "<br>Sub_seller_Enrollement_id1 ".$_REQUEST['Sub_seller_Enrollement_id1'];
				die;  */
				//--------------Enroll staff-------------------------------
				
				
				if($_REQUEST['firstName'] == '' || $_REQUEST['lastName'] == '' || $_REQUEST['currentAddress'] == '' || $_REQUEST['country'] == '' || $_REQUEST['state'] == '' ||   $_REQUEST['city'] == '' ||   $_REQUEST['userEmailId'] == '' ||   $_REQUEST['phno'] == ''    )
				{
					$this->session->set_flashdata("error_code","Please Enter all the Required fields !!!");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				$post_data2 = array
				(
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Sub_seller_admin' => $_REQUEST['Sub_seller_admin1'],
					'Sub_seller_Enrollement_id' => $Sub_seller_Enrollement_id1,
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $_REQUEST['sex'],
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s')
				);
				
				$result = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
				
				//-------------------------------------------------------------------
				
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$Todays_date=date('Y-m-d H:i:s');
					$opration = 2;				
					$userid=$session_data['userId'];
					$what="Update Staff User Enrollment";
					$where="Staff User Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$Enrollment_id.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
				
						
				redirect('Enrollmentc/StaffUserEnrollment');									
				
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function PartnerUserEnrollment()
	{
		if($this->session->userdata('logged_in'))
		{
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
			$data['Domain_name'] = $session_data['Domain_name'];
			$data['Country_id'] = $session_data['Country_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			$Todays_date = date('Y-m-d H:i:s');
			
			

			
			if($_POST == NULL)
			{
				
				if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
				{
					$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
				}
				else 
				{
					$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
					
				}	
					
				$data['Company_array'] = $FetchedCompanys;
				
				$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
				$data["results"] = $this->Enroll_model->Get_user_enrollment_list($User_id=5,$Company_id);
				
				$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$data['Company_id']);
		
				$this->load->view('enrollment/PartnerUserEnrollment', $data);
			}
			else
			{
							/*-----------------------File Upload---------------------*/
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '1500';
					$config['max_width'] = '1920';
					$config['max_height'] = '1280';
					$config['encrypt_name'] = true;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/No_Profile_Image.jpg";
						}

						
						if($this->upload->display_errors())
						{
							if($data22['file_name']!='')
							{
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
							}
						}
					
				
				//--------------Enroll staff-------------------------------
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$_REQUEST['Merchandize_Partner_ID'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Merchandize_Partner_ID']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				$_REQUEST['Merchandize_Partner_Branch'] = strip_tags($_REQUEST['Merchandize_Partner_Branch']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1   || is_numeric($_REQUEST['Merchandize_Partner_ID']) != 1   )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
					
				if($_REQUEST['firstName'] == '' || $_REQUEST['lastName'] == '' || $_REQUEST['currentAddress'] == '' || $_REQUEST['country'] == '' || $_REQUEST['state'] == '' ||   $_REQUEST['city'] == '' ||   $_REQUEST['userEmailId'] == '' ||   $_REQUEST['phno'] == ''    )
				{
					$this->session->set_flashdata("error_code","Please Enter all the Required fields !!!");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				$Insert_enroll_data = array
				(
					'Company_id' => $Company_id,
					'User_id' => 5,
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Merchandize_Partner_ID' => $_REQUEST['Merchandize_Partner_ID'],
					'Merchandize_Partner_Branch' => $_REQUEST['Merchandize_Partner_Branch'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $sex,
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'pinno' => $Pin_no,
					'User_activated' => 1,
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$result = $this->Enroll_model->Insert_enrollment($Insert_enroll_data);
				
				//-------------------------------------------------------------------
				

				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="Partner User Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$result.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
								
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => "Merchant Outlet"
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
						
				redirect(current_url());									
			}	
							
		}
		else
		{
			
			redirect('Login', 'refresh');
		}
	}
		
	public function Edit_PartnerUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			if($_REQUEST)
			{				
		
				$data["results12"] = $this->Enroll_model->Get_user_enrollment_list($User_id=5,$Company_id);
				
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
				
/***********decrypt value*******************/
				
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					$this->session->set_flashdata("error_code","Error Deleting Enrollment!!");
					redirect('Enrollmentc/PartnerUserEnrollment');
				}
				$data['Fetched_Companys'] = $FetchedCompanys;
				$Enrollement_id =  $Decrypt_Enrollement_id;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
				
								
				/**************AMIT 20-11-2017***********************/
				
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
				$phNo = App_string_decrypt($data['results']->Phone_no);
				$exp=explode($dial_code,$phNo);
				$data['phnumber'] = $exp[1];
				$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$data['Company_id']);
				$data["Partner_Branch_Records"] = $this->Catelogue_model->Get_Partners_Branches($data['results']->Merchandize_Partner_ID);
				/*****************************************************/
				$this->load->view('enrollment/Edit_PartnerUserEnrollment', $data);
			}
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function Update_PartnerUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
				
				$Enrollment_id =  $_SESSION["Edit_Enrollement_id"];

					/*-----------------------File Upload---------------------*/
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '1500';
					$config['max_width'] = '1920';
					$config['max_height'] = '1280';
					$config['encrypt_name'] = true;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = $_SESSION["Photograph"];
						}

						
						if($this->upload->display_errors())
						{
							if($data22['file_name']!='')
							{
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
							}
						}
					
				
				//--------------Enroll staff-------------------------------
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$_REQUEST['Merchandize_Partner_ID'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['Merchandize_Partner_ID']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				$_REQUEST['Merchandize_Partner_Branch'] = strip_tags($_REQUEST['Merchandize_Partner_Branch']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1   || is_numeric($_REQUEST['Merchandize_Partner_ID']) != 1   )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
					
				if($_REQUEST['firstName'] == '' || $_REQUEST['lastName'] == '' || $_REQUEST['currentAddress'] == '' || $_REQUEST['country'] == '' || $_REQUEST['state'] == '' ||   $_REQUEST['city'] == '' ||   $_REQUEST['userEmailId'] == '' ||   $_REQUEST['phno'] == ''    )
				{
					$this->session->set_flashdata("error_code","Please Enter all the Required fields !!!");
					redirect('Enrollmentc/PartnerUserEnrollment', 'refresh');	
				}
					
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				//-------Enroll partner-------------------------------
				$post_data2 = array
				(
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Merchandize_Partner_ID' => $_REQUEST['Merchandize_Partner_ID'],
					'Merchandize_Partner_Branch' => $_REQUEST['Merchandize_Partner_Branch'],
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $_REQUEST['sex'],
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s')
				);
				
				$result = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
				
				//-------------------------------------------------------------------
				
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$Todays_date=date('Y-m-d H:i:s');
					$opration = 2;				
					$userid=$session_data['userId'];
					$what="Update Partner User Enrollment";
					$where="Partner User Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$Enrollment_id.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
				
						
				redirect('Enrollmentc/PartnerUserEnrollment');									
				
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function CallCenterUserEnrollment()
	{
		if($this->session->userdata('logged_in'))
		{
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
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			$Todays_date = date('Y-m-d H:i:s');
			
			if($Sub_seller_admin==1)
			{
                $Logged_user_enrollid=$Logged_user_enrollid;
			}
			else
			{
                $Logged_user_enrollid=$Sub_seller_Enrollement_id;
			}			
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
						
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$Seller_topup_access = $resultis->Seller_topup_access;
			$Partner_company_flag = $resultis->Partner_company_flag;
			$Joining_bonus_flag = $resultis->Joining_bonus;
			$Joining_bonus_points = $resultis->Joining_bonus_points;
			$Company_Current_bal = $resultis->Current_bal;
			$Company_Country = $resultis->Country;
			
						
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
					
					$remark_by = 'By Outlet';	
					
				}
	
			//Logged_user_enrollid;
			$data["Seller_Refrence"] = $Seller_Refrence;			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
			
			if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
			{
				$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
			}
			else 
			{
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
				
			}	
				
			$data['Company_array'] = $FetchedCompanys;
			
			$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
			// $data['Country_array'] = $FetchedCountrys;
			
			
			

			
			if($_POST == NULL)
			{
				
				$data["results"] = $this->Enroll_model->Get_user_enrollment_list($User_id=6,$Company_id);
				
				$data["Call_center_details"] = $this->Igain_model->Fetch_Callcenter_details($session_data['Company_id']);
				$this->load->view('enrollment/CallCenterUserEnrollment', $data);
			}
			else
			{
					/*-----------------------File Upload---------------------*/
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '1500';
					$config['max_width'] = '1920';
					$config['max_height'] = '1280';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/No_Profile_Image.jpg";
						}

					if($this->upload->display_errors())
					{
						if($data22['file_name']!='')
						{
							$this->session->set_flashdata("error_code",$this->upload->display_errors());
							redirect('Enrollmentc/CallCenterUserEnrollment', 'refresh');	
						}
					}
					
				
				
				$Supervisor_Enrollement_id = 0;
				$Sub_seller_admin = 1;
				if($_REQUEST['Supervisor']== 0)
				{
					$Supervisor_Enrollement_id = $_REQUEST['Supervisor_Enrollement_id'];
					$Sub_seller_admin = 0;
				}
				//--------------Enroll callcenter-------------------------------
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1   || is_numeric($_REQUEST['Supervisor']) != 1   || is_numeric($Supervisor_Enrollement_id) != 1 )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
			
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				$Insert_enroll_data = array
				(
					'Company_id' => $Company_id,
					'User_id' => 6,
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Call_center_user' => 1,
					'Sub_seller_Enrollement_id' => $Supervisor_Enrollement_id,
					'Sub_seller_admin' => $Sub_seller_admin,
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $sex,
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'pinno' => $Pin_no,
					'User_activated' => 1,
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$result = $this->Enroll_model->Insert_enrollment($Insert_enroll_data);
				
				//-------------------------------------------------------------------
				

				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="CallCenter User Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$result.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
								
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => "Merchant Outlet"
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
						
				redirect(current_url());									
			}	
							
		}
		else
		{
			
			redirect('Login', 'refresh');
		}
	}
		
	public function Edit_CallCenterUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			if($_REQUEST)
			{				
		
				$data["results12"] = $this->Enroll_model->Get_user_enrollment_list($User_id=6,$Company_id);
				
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
				/***********decrypt value*******************/
				// $Decrypt_Enrollement_id = rawurldecode($this->encrypt->decode($_REQUEST['Enrollement_id']));
				$Decrypt_Enrollement_id = $_REQUEST['Enrollement_id'];
				$Enroll_details = $this->Igain_model->get_enrollment_details($Decrypt_Enrollement_id);
			
		
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				$Enrollement_id =  $Decrypt_Enrollement_id;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
				
								
				/**************AMIT 20-11-2017***********************/
				
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
				$phNo = App_string_decrypt($data['results']->Phone_no);
				$exp=explode($dial_code,$phNo);
				$data['phnumber'] = $exp[1];
				$data["Call_center_details"] = $this->Igain_model->Fetch_Callcenter_details($session_data['Company_id']);
				/*****************************************************/
				$this->load->view('enrollment/Edit_CallCenterUserEnrollment', $data);
			}
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	public function Update_CallCenterUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
				$Enrollment_id = $_SESSION["Edit_Enrollement_id"];
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '1500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						// print_r($upload22);
						// echo 'is_image '.$data22['is_image'];die;	
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = $_SESSION["Enrollment_image"];
						}

				
				if($this->upload->display_errors())
				{
					if($data22['file_name']!='')
					{
						$this->session->set_flashdata("error_code",$this->upload->display_errors());
						redirect('Enrollmentc/CallCenterUserEnrollment', 'refresh');	
					}
				}
					
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				//-------Enroll callcenter-------------------------------
				
				$Supervisor_Enrollement_id = 0;
				$Sub_seller_admin = 1;
				if($_REQUEST['Supervisor']== 0)
				{
					$Supervisor_Enrollement_id = $_REQUEST['Sub_seller_Enrollement_id'];
					$Sub_seller_admin = 0;
				}
				//--------------Enroll callcenter-------------------------------
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1   || is_numeric($_REQUEST['Supervisor']) != 1   || is_numeric($Supervisor_Enrollement_id) != 1 )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/IndividiualEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/StaffUserEnrollment', 'refresh');	
				}
				$post_data2 = array
				(
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Sub_seller_Enrollement_id' => $Supervisor_Enrollement_id,
					'Sub_seller_admin' => $Sub_seller_admin,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $_REQUEST['sex'],
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s')
				);
				
				$result = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
				
				//-------------------------------------------------------------------
				
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$Todays_date=date('Y-m-d H:i:s');
					$opration = 2;				
					$userid=$session_data['userId'];
					$what="Update CallCenter User Enrollment";
					$where="CallCenter User Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$Enrollment_id.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
				
						
				redirect('Enrollmentc/CallCenterUserEnrollment');									
				
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	function OutletEnrollment()
	{
		if($this->session->userdata('logged_in'))
		{
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
			$data['Country_id'] = $session_data['Country_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			$Todays_date = date('Y-m-d H:i:s');
				
			
			
			
			

			
			if($_POST == NULL)
			{
				
			
				if($data['userId'] == '3' && $session_data['Company_id'] =='1')  
				{
					$FetchedCompanys = $this->Igain_model->FetchPartnerCompany();
				}
				else 
				{
					$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($session_data['Company_id']);
					
				}	
					
				$data['Company_array'] = $FetchedCompanys;
				
				$data['Country_array']= $this->Igain_model->Company_city_state_country($session_data['Company_id']);	
				// $data['Country_array'] = $FetchedCountrys;
				$data["results"] = $this->Enroll_model->Get_user_enrollment_list($User_id=2,$Company_id);
				$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
				$this->load->view('enrollment/OutletEnrollment', $data);
			}
			else
			{
					/*-----------------------File Upload---------------------*/
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = '1500';
					$config['max_width'] = '1920';
					$config['max_height'] = '1280';
					$config['encrypt_name'] = true;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = "images/No_Profile_Image.jpg";
						}

					
					if($this->upload->display_errors())
					{
						if($data22['file_name']!='')
						{
							$this->session->set_flashdata("error_code",$this->upload->display_errors());
							redirect('Enrollmentc/OutletEnrollment', 'refresh');	
						}
						
					}
					
				
				
				//--------------Enroll outlet-------------------------------
				$Sub_seller_Enrollement_id = 0;
				
				if($_REQUEST['Sub_seller_admin']== 0)
				{
					$Sub_seller_Enrollement_id = $_REQUEST['Sub_seller_Enrollement_id'];
				}
				//--------------Enroll staff-------------------------------
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$_REQUEST['MercahndizeCategory'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['MercahndizeCategory']);
				
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1  || is_numeric($_REQUEST['Seller_Redemptionratio']) != 1   || is_numeric($_REQUEST['Sub_seller_admin']) != 1    || is_numeric($Sub_seller_Enrollement_id) != 1  )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
					
				if($_REQUEST['firstName'] == '' || $_REQUEST['lastName'] == '' || $_REQUEST['currentAddress'] == '' || $_REQUEST['country'] == '' || $_REQUEST['state'] == '' ||   $_REQUEST['city'] == '' ||   $_REQUEST['userEmailId'] == '' ||   $_REQUEST['phno'] == ''    ||   $_REQUEST['Seller_Redemptionratio'] == ''    )
				{
					$this->session->set_flashdata("error_code","Please Enter all the Required fields !!!");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				$Insert_enroll_data = array
				(
					'Company_id' => $Company_id,
					'User_id' => 2,
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $sex,
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'User_pwd' => App_string_encrypt($Pin_no),
					'pinno' => $Pin_no,
					'User_activated' => 1,
					'Refrence' => 1,
					'Sub_seller_admin' => $_REQUEST['Sub_seller_admin'],
					'Sub_seller_Enrollement_id' => $Sub_seller_Enrollement_id,
					'Seller_Redemptionratio' => $_REQUEST['Seller_Redemptionratio'],
					'source' => 'Website',
					'Create_user_id' => $session_data['enroll'],
					'timezone_entry' => $session_data['timezone_entry'],
					'joined_date' => date('Y-m-d')
				);
				
				$result = $this->Enroll_model->Insert_enrollment($Insert_enroll_data);
				$post_data2 = array
				(
					'Purchase_Bill_no' => date('Y')."-$result"."00000000",
					'Topup_Bill_no' => date('Y')."-$result"."10000000"
				);
				$result21 = $this->Enroll_model->update_enrollment($post_data2,$result);
				//---------------------------------------------
				if($_REQUEST['MercahndizeCategory'] != "" && $result > 0)
				{
					$cat_array= array(
								'Company_id'=>$Company_id,
								'Merchant_type'=>'0',
								'Seller'=>$result,
								'Item_type_code'=>$result,
								'Item_category_name'=>$_REQUEST['MercahndizeCategory'],
								'Item_typedesc'=>$_REQUEST['MercahndizeCategory'],
								'Discount'=>'no'
							   );
						$result_cat = $this->Enroll_model->insert_merchant_category($cat_array);							   
				}
				//-------------------------------------------------------------------
				

				$Last_enroll_id=$result;
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$opration = 1;				
					$userid=$session_data['userId'];
					$what=" Enrollment";
					$where="Outlet Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$result.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
				
								
				if($result > 0)
				{
					$Email_content = array(
						'Notification_type' => 'Enrollment Details',
						'Template_type' => 'Enroll',
						'Enrolled_under' => "Merchant Outlet"
					);
					$this->send_notification->send_Notification_email($result,$Email_content,$Logged_in_userid,$Company_id);					
					$this->session->set_flashdata("success_code","Enrollment Successfull!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Enrollment!!");
				}
						
				redirect(current_url());									
			}	
							
		}
		else
		{
			
			redirect('Login', 'refresh');
		}
	}
	public function Edit_OutletUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			if($_REQUEST)
			{				
		
				
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
				
				/***********decrypt value*******************/
				$Decrypt_Enrollement_id = $_SESSION[$_REQUEST['Enrollement_id']];
				if(!is_numeric($Decrypt_Enrollement_id))
				{
					$this->session->set_flashdata("error_code","Invalid Data!!");
					redirect('Enrollmentc/OutletEnrollment');
				}
				$Enroll_details = $this->Igain_model->get_enrollment_details($Decrypt_Enrollement_id);
			
		
				// echo"---Enroll_details.....".$Enroll_details->Company_id;
				$FetchedCompanys = $this->Igain_model->FetchLoginUserCompany($Enroll_details->Company_id);
				$data['Fetched_Companys'] = $FetchedCompanys;
				$Enrollement_id =  $Decrypt_Enrollement_id;			
				$data['results'] = $this->Enroll_model->edit_enrollment($Enrollement_id);
				
								
				/**************AMIT 20-11-2017***********************/
				
				$data['States_array'] = $this->Igain_model->Get_states($data['results']->Country);	
				$data['City_array'] = $this->Igain_model->Get_cities($data['results']->State);
				$dial_code = $this->Enroll_model->get_dial_code($data['results']->Country);
				$phNo = App_string_decrypt($data['results']->Phone_no);
				$exp=explode($dial_code,$phNo);
				$data['phnumber'] = $exp[1];
				$data["results12"] = $this->Enroll_model->Get_user_enrollment_list($User_id=2,$Company_id);
				$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
				if($Enroll_details->Sub_seller_Enrollement_id > 0 )
				{
					$data['results50'] = $this->Igain_model->get_enrollment_details($Enroll_details->Sub_seller_Enrollement_id);
				}
				else
				{
					$emptyarry['Sub_seller_admin'] = array();
					
					$data['results50'] = array();
				}
				/*****************************************************/
				$this->load->view('enrollment/Edit_OutletUserEnrollment', $data);
			}
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function Update_OutletUserEnrollment()
	{	
		// $this->output->enable_profiler(true);
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$SuperSellerFlag = $session_data['Super_seller'];
			
			
				$Enrollment_id =  $_SESSION["Edit_Enrollement_id"];
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '1500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				/*-----------------------File Upload---------------------*/
					/* Create the config for image library */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;
				
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload22 = $this->upload->do_upload('file');
						$data22 = $this->upload->data();
						// print_r($upload22);
						// echo 'is_image '.$data22['is_image'];die;	
						if($data22['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './uploads/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$filepath='uploads/'.$data22['file_name'];
						}
						else
						{
							$filepath = $_SESSION["Photograph"];
						}
					
					if($this->upload->display_errors())
					{
						if($data22['file_name']!='')
						{
							$this->session->set_flashdata("error_code",$this->upload->display_errors());
							redirect('Enrollmentc/OutletEnrollment', 'refresh');	
						}
						
					}
				$Sub_seller_Enrollement_id = 0;
				
				if($_SESSION["Edit_Sub_seller_admin"]== 0)
				{
					$Sub_seller_Enrollement_id = $_REQUEST['Sub_seller_Enrollement_id'];
				}
				
				$_REQUEST['firstName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['firstName']);
				$_REQUEST['middleName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['middleName']);
				$_REQUEST['lastName'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['lastName']);
				$_REQUEST['qualifi'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['qualifi']);
				$_REQUEST['district'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['district']);
				$_REQUEST['zip'] = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['zip']);
				$sex = preg_replace('/[^A-Za-z0-9\-]/', '', $_REQUEST['sex']);
				$_REQUEST['currentAddress'] = strip_tags($_REQUEST['currentAddress']);
				
				if(is_numeric($_REQUEST['country']) != 1 || is_numeric($_REQUEST['state']) != 1  || is_numeric($_REQUEST['city']) != 1  || is_numeric($_REQUEST['phno']) != 1  || is_numeric($_REQUEST['Seller_Redemptionratio']) != 1   || is_numeric($Sub_seller_Enrollement_id) != 1  )
				{
					
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				if(strlen($_REQUEST['phno']) != 10)
				{
					$this->session->set_flashdata("error_code","Please Enter 10 digit Phone No.");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				if (!filter_var($_REQUEST['userEmailId'], FILTER_VALIDATE_EMAIL)) {
				  $this->session->set_flashdata("error_code","Please Enter Valid Email ID");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				
				if($sex != '0' && $sex != 'Male' && $sex != 'Female')
				{
					$this->session->set_flashdata("error_code","Please Select Valid Gender !!!");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
					
				if($_REQUEST['firstName'] == '' || $_REQUEST['lastName'] == '' || $_REQUEST['currentAddress'] == '' || $_REQUEST['country'] == '' || $_REQUEST['state'] == '' ||   $_REQUEST['city'] == '' ||   $_REQUEST['userEmailId'] == '' ||   $_REQUEST['phno'] == ''    ||   $_REQUEST['Seller_Redemptionratio'] == ''    )
				{
					$this->session->set_flashdata("error_code","Please Enter all the Required fields !!!");
					redirect('Enrollmentc/OutletEnrollment', 'refresh');	
				}
				
					// ECHO $_REQUEST['Seller_Redemptionratio'];DIE;
				$Dial_code_sql =  $this->db->select('phonecode')
			  ->from('igain_country_master')
			  ->where('id',$this->input->post('country'));
				$phonecode = $this->db->get()->row()->phonecode;
				
				$Phone_no = $phonecode."".$this->input->post('phno');
				
				$Pin_no = $this->Enroll_model->getRandomString();
				
				//--------------Enroll outlet-------------------------------
				
				$post_data2 = array
				(
					'First_name' => $_REQUEST['firstName'], 
					'Middle_name' => $_REQUEST['middleName'], 
					'Last_name' => $_REQUEST['lastName'], 
					'Current_address' =>  App_string_encrypt($_REQUEST['currentAddress']), 
					'State' => $_REQUEST['state'],
					'District' => $_REQUEST['district'],
					'City' => $_REQUEST['city'],
					'Zipcode' => $_REQUEST['zip'],
					'Country' => $_REQUEST['country'],
					'Phone_no' => App_string_encrypt($Phone_no), //$Phone_no,
					'Date_of_birth' =>date('Y-m-d',strtotime($_REQUEST['dob'])),
					'Sex' => $_REQUEST['sex'],
					'Qualification' => $_REQUEST['qualifi'],
					'Photograph' => $filepath,
					'Country_id' => $_REQUEST['country'],
					'User_email_id' => App_string_encrypt($_REQUEST['userEmailId']),
					'Sub_seller_Enrollement_id' => $Sub_seller_Enrollement_id,
					'Seller_Redemptionratio' => $_REQUEST['Seller_Redemptionratio'],
					'Update_user_id' => $data['enroll'],
					'Update_date' => date('Y-m-d H:i:s')
				);
				
				
				$result = $this->Enroll_model->update_enrollment($post_data2,$Enrollment_id);
				
				//-------------------------------------------------------------------
				
				
				// echo "<br>Last_enroll_id ".$Last_enroll_id;
				// die;
				/******************Nilesh change igain Log Table change 14-06-2017*********************/
					// echo"".."";
					$Todays_date=date('Y-m-d H:i:s');
					$opration = 2;				
					$userid=$session_data['userId'];
					$what="Update Outlet Enrollment";
					$where="Outlet Enrollment";
					$toname="";
					$toenrollid = 0;
					$opval = $_REQUEST['firstName'].' Enrollement ID- ('.$Enrollment_id.')';
					$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$session_data['enroll'],$session_data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
				/**************************igain Log Table change 14-06-2017****************************/
				
					$this->session->set_flashdata("success_code","Enrollment Updated Successfuly!!");
				
						
				redirect('Enrollmentc/OutletEnrollment');									
				
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	//********************** AMIT KAMBLE 20-04-2022---ENROLLMENTS*******XXX*************		
}
?>