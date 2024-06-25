<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//http://demo1.igainspark.com/index.php/QrLogin/?a=50011025&b=4&c=3;
class QrLogin extends CI_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Qrcode/Qr_model');
		$this->load->model('login/Login_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->model('Igain_model');
		$this->load->model('enrollment/Enroll_model');		
		$this->load->model('transactions/Transactions_model');
		$this->load->model('administration/Administration_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Send_notification');
		$this->load->model('master/currency_model');
	}
	
	public function decode5t($str)
	{
	  for($i=0; $i<5;$i++)
	  {
		$str=base64_decode(strrev($str));				
	  }
	  
	  return $str;
	}
			
	public function index()
    {  
		if($_GET != NULL)
		{
			$Card_id = $this->decode5t($_GET['a']);//$_GET['a'];
			$Seller_enroll_id = $this->decode5t($_GET['b']);//$_GET['b'];
			$Company_id = $this->decode5t($_GET['c']);//$_GET['c'];

			
			/*echo "a val Card_id is--".$Card_id;
			echo "a val Seller_enroll_id is--".$Seller_enroll_id;
			echo "a val Company_id is--".$Company_id;
			*/
			
			$result = $this->Qr_model->Login($Company_id,$Seller_enroll_id);
			
			if($result)
			{
				$sess_array = array();
				 //print_r($result);
				foreach($result as $row)
				{
					$sess_array = array('enroll' => $row['Enrollement_id'],'username' => $row['User_email_id'],'Country_id' => $row['Country_id'],'userId'=>$row['User_id'],'Super_seller'=>$row['Super_seller'],'Company_name'=>$row['Company_name'],'Company_id'=>$row['Company_id'],'Login_Partner_Company_id'=>$row['Company_id'],'timezone_entry'=>$row['timezone_entry'],'Full_name'=>$row['First_name']." ".$row['Middle_name']." ".$row['Last_name'],'Count_Client_Company'=>$row['Count_Client_Company'],'card_decsion'=>$row['card_decsion'],'next_card_no'=>$row['next_card_no'],'Seller_licences_limit'=>$row['Seller_licences_limit'],'Seller_topup_access'=>$row['Seller_topup_access'],'Current_balance'=>$row['Current_balance'],'smartphone_flag' => '2');
					
					$this->session->set_userdata('logged_in', $sess_array);
					
					$Partner_company_flag = $row['Partner_company_flag'];
					$Count_Client_Company = $row['Count_Client_Company'];
					$Loggin_User_id = $row['User_id'];
					$Super_seller = $row['Super_seller'];
					$Company_id = $row['Company_id'];
					
					$Company_logo = $row['Company_logo'];
					$Coalition = $row['Coalition'];
					$Photograph = $row['Photograph'];
					$_SESSION['Photograph'] =$Photograph;
					$_SESSION['Company_logo'] =$Company_logo;
					$_SESSION['Coalition'] =$Coalition;
					$data['LogginUserName'] = $row['First_name']." ".$row['Last_name'];
					
					/***********************AMIT 24-05-2016**************************************************/
					$_SESSION['Parent_company'] =$row['Parent_company'];
					$FetchedParentCompany = $this->Igain_model->get_company_details($_SESSION['Parent_company']);
					
					$_SESSION['Localization_logo'] = $FetchedParentCompany->Localization_logo;
					$_SESSION['Localization_flag'] = $FetchedParentCompany->Localization_flag;
					$_SESSION['Company_logo'] = $FetchedParentCompany->Company_logo;
					/*******************************************************************************/
							
				}

				//redirect('Transactionc/loyalty_transaction/?cardId='.$Card_id);						
				redirect('QrLogin/loyalty_transaction/?cardId='.$Card_id);						
			}
			else
			{
				echo "<h4>Sorry, Invalid Qrcode!.</h4>";							
			}
		}
	}
	
	public function loyalty_transaction()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			//$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			
			$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);  
			$data['Current_balance'] = $seller_details->Current_balance;
			$data['refrence'] = $seller_details->Refrence;
			$data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
			$redemptionratio = $seller_details->Seller_Redemptionratio;
			
			
			if($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL)
			{
				$company_details = $this->Igain_model->get_company_details($data['Company_id']);  
				
				$redemptionratio = $company_details->Redemptionratio;
			}
			$data['redemptionratio'] = $redemptionratio;
			
			$company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Seller_topup_access'] = $company_details->Seller_topup_access;
			$data['Threshold_Merchant'] = $company_details->Threshold_Merchant;
			
			$data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/QrLogin/loyalty_transaction";
			$total_row = $this->Transactions_model->loyalty_transaction_count($Logged_user_id,$data['enroll'],$data['Company_id']);		
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
				
			
				
			if($_GET['cardId'] == 0)
			{
				$this->session->unset_userdata('logged_in');   
				redirect('Login', 'refresh');
			}
			else
			{
				$cardis = $_GET['cardId'];
				// $this->output->enable_profiler(TRUE);	
				$Lp_count = $this->Administration_model->loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id);
								
				$categoryexist = $this->Transactions_model->check_seller_item_category($data['Company_id'],$data['enroll']);
		
				if($Lp_count > 0)
				{
					if($categoryexist > 0)
					{

						$get_card = substr($cardis,0,16); //*******read card id from other magnetic card***********///
						
						
						
						$dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);					
						$phnumber = $dial_code.$cardis;
						
						$member_details = $this->Transactions_model->issue_bonus_member_details($data['Company_id'],$get_card,$phnumber);
						foreach($member_details as $rowis)
						{
							$cardId=$rowis['Card_id'];
							$user_activated=$rowis['User_activated'];
							$Phone_no=$rowis['Phone_no'];
						}
						
						
						if($user_activated == 0)
						{
							$this->session->set_flashdata("error_code","Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
							redirect(current_url());
						}
							
						if($cardId != 0 )
						{
								if($cardId == $cardis || $Phone_no == $phnumber)
								{
									
				
									$cust_details = $this->Transactions_model->cust_details_from_card($data['Company_id'],$cardId);
									foreach($cust_details as $row25)
									{
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
										$Member_Tier_id = $row25['Tier_id'];
									}
									
									$tp_count = $this->Transactions_model->get_count_topup($cardId,$cust_enrollment_id,$Logged_user_enrollid);
									$purchase_count = $this->Transactions_model->get_count_purchase($cardId,$cust_enrollment_id,$Logged_user_enrollid);
									$gainedpts_atseller = $this->Transactions_model->gained_points_atseller($cardId,$cust_enrollment_id,$Logged_user_enrollid);
									
									if($gainedpts_atseller == NULL){$gainedpts_atseller=0;}
									
									$data['get_card'] = $get_card;
									$data['Cust_enrollment_id'] = $cust_enrollment_id;
									$data['Full_name'] = $fname." ".$midlename." ".$lname;
									$data['Phone_no'] = $phno;
									$data['Customer_pin'] = $pinno;
									$data['Current_balance'] = ($bal-$Blocked_points);
									$data['Current_balance'] = $bal;
									$data['Topup_count'] = $tp_count;
									$data['Purchase_count'] = $purchase_count;
									$data['Gained_points'] = $gainedpts_atseller;
									$data['Photograph'] = $filename_get1;
									$data['Tier_name'] = $Tier_name;
									$data['MembershipID'] = $cardId;
									
									//$data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
									$lp_array = $this->Transactions_model->get_tierbased_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id,$Member_Tier_id);
									$data['lp_array'] = $lp_array;
									$data['referral_array'] = $this->Igain_model->get_transaction_referral_rule($Company_id,$Logged_user_enrollid,'2');
									
									$Payment = $this->Igain_model->get_payement_type();
									$data['Payment_array'] = $Payment;
										
				
									if($lp_array != "")
									{
										$this->load->view('Qrcode/Qrcode_purchase_transaction',$data);
									}
									else 
									{
										$this->session->set_flashdata("error_code","Sorry, Cannot proceed with the Transaction!!, Please set Loyalty Rule...! !");
										$this->load->view('Qrcode/Qrcode_purchase_transaction',$data);
									}
								}
								else 
								{
									$this->session->set_flashdata("error_code","Sorry, Cannot proceed with the Transaction!! Your Membership ID is not registered with us...! !");
									redirect(current_url());
								}
							
							
						}
						else
						{
							$this->session->set_flashdata("error_code","Please enter valid Membership ID.");
							redirect(current_url());
						}
						// $this->load->view('transactions/loyalty_purchase_transaction', $data);
					}
					else
					{
						$this->session->set_flashdata("error_code","The Merchant has not been Assigned a Category yet!! Please contact the Program Admin to set it to Enable Purchase Transaction");
						redirect(current_url());
					}
				}
				else
				{
					$this->session->set_flashdata("error_code","Sorry, Cannot proceed with the Transaction!! Loyalty rule is not set...! !");
					redirect(current_url());
				}
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function Qrcode_purchase_transaction_ci()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$data['userId'] = $session_data['userId'];
			$data['Current_balance'] = $session_data['Current_balance'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$Country_id = $data['Country_id'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['LogginUserName'] = $session_data['Full_name'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			
			
			if($_POST == NULL)
			{
				$this->session->set_flashdata("error_code","Sorry, Loyalty Points Transaction Failed. Invalid Data Provided!!");
				$this->session->unset_userdata('logged_in');   
				redirect('Login', 'refresh');
			}
			else
			{
				//$this->output->enable_profiler(TRUE);
				
				if($this->input->post("purchase_amt") == "" || $this->input->post("purchase_amt") <= 0 || $this->input->post("purchase_amt") == " ")
				{
					$this->session->set_flashdata("error_code","Sorry, Loyalty Transaction Failed. Please Enter Valid Purchase Amount..!!");
					redirect('Transactionc/loyalty_transaction');
				}
				else
				{
					$loyalty_points  = 0;				
					$bal_pay = $this->input->post("pay_amt");
					$reedem_points = $this->input->post("points_redeemed");
					
					$TotalRedeemPoints = $reedem_points;
					
					$dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);					
					$phnumber = $dial_code.$this->input->post("cardId");
						
					$member_details = $this->Transactions_model->issue_bonus_member_details($Company_id,$this->input->post("cardId"),$phnumber);
					foreach($member_details as $rowis)
					{
						$cardId = $rowis['Card_id'];
					}
					
					$cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$cardId);
					foreach($cust_details as $row25)
					{
						$card_bal = $row25['Current_balance'];
						$Customer_enroll_id = $row25['Enrollement_id'];
						$topup = $row25['Total_topup_amt'];
						$purchase_amt = $row25['total_purchase'];
						$reddem_amt = $row25['Total_reddems'];
						$lv_member_Tier_id = $row25['Tier_id'];
						$Refree_enroll_id = $row25['Refrence'];
						$customer_name = $row25['First_name']." ".$row25['Last_name'];
					}
					
					$redeem_by = $this->input->post("redeem_by");
					
					$go_ahead = 0;
					
					if($redeem_by == 1 && $reedem_points <= $card_bal)
					{
						$go_ahead = 1;
					}
					else if($redeem_by == 1)
					{
						$go_ahead = 0; 
						
						$this->session->set_flashdata("error_code","Sorry, Loyalty Transaction Failed. Please Enter Valid Redeem Points..!!");
						redirect('Transactionc/loyalty_transaction');
					}
					else
					{
						$go_ahead = 1;
					}
					
					if(!(is_null($bal_pay)) && $go_ahead == 1 )
					{
						$Todays_date = date("Y-m-d");	
						$gained_points_fag = 0;
						$manual_bill_no = $this->input->post("manual_bill_no");
						$logtimezone = $data['timezone_entry'];				
						$loyalty_prog = $this->input->post("lp_rules");
						
						$logtimezone = $session_data['timezone_entry'];
						$timezone = new DateTimeZone($logtimezone);
						$date = new DateTime();
						$date->setTimezone($timezone);
						$lv_date_time=$date->format('Y-m-d H:i:s');
						$Todays_date = $date->format('Y-m-d');
						
						$company_details2 = $this->Igain_model->get_company_details($Company_id);
						$Sms_enabled = $company_details2->Sms_enabled;
						$Seller_topup_access = $company_details2->Seller_topup_access;
						$Allow_negative = $company_details2->Allow_negative;
						
						if($data['userId'] == 3)
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
						
						$Seller_category = $this->Igain_model->get_seller_category($seller_id,$Company_id);	
						
						if($Seller_category == 0)
						{
							$this->session->set_flashdata("error_code","The Merchant has not been assigned a Category yet!! Please contact the Program Admin to set it to Enable Loyalty Transaction.!");

							redirect('Transactionc/loyalty_transaction');
						}
						
						$points_array = array();
						//print_r($loyalty_prog);
						foreach($loyalty_prog as $prog)
						{
							$member_Tier_id = $lv_member_Tier_id;
							
							$value = array();
							$dis = array();
							
							$LoyaltyID_array = array();
							$Loyalty_at_flag = 0;
							$lp_type=substr($prog,0,2);				
								
					//***** get loyalty program details ******************/
					
							$lp_details = $this->Transactions_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$Todays_date);	
							
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
							
							/*
							echo '-----LoyaltyID_array-><br>';
							print_r($LoyaltyID_array);
							echo '-----value-><br>';
							print_r($value);
							echo '-----discount-><br>';
							print_r($dis);
							echo '-----<br>';
							*/
							
							
							if($lp_type == 'PA')
							{
								$transaction_amt = $this->input->post("purchase_amt");
							}
							
							if($lp_type == 'BA')
							{
								$transaction_amt = $this->input->post("pay_amt");
							}
							/*
							echo "---loyalty member_Tier_id---".$member_Tier_id."---<br><br>";
							echo "---loyalty lp_Tier_id---".$lp_Tier_id."---<br><br>";
							echo "---loyalty Loyalty_at_flag---".$Loyalty_at_flag."---<br><br>";
							*/
							if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
							{
								
								for($i=0;$i<=count($value)-1;$i++)
								{
									//echo "---i--".$i."---<br>";

										if($value[$i+1] != "")
										{
											if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1] )
											{
												
												$loyalty_points = $this->Transactions_model->get_discount($transaction_amt,$dis[$i]);
												//echo "---loyalty_points--1-0--".$loyalty_points."---<br><br>";
												$trans_lp_id = $LoyaltyID_array[$i];
												$gained_points_fag = 1;
												
												$points_array[] = $loyalty_points;
											}
											
										}
										else if($transaction_amt > $value[$i])
										{
										
											$loyalty_points = $this->Transactions_model->get_discount($transaction_amt,$dis[$i]);
												//echo "---loyalty_points--1-1--".$loyalty_points."---<br><br>";	
											$gained_points_fag = 1;
											$trans_lp_id = $LoyaltyID_array[$i];
											
											$points_array[] = $loyalty_points;
										}

								}
							}
							
							if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
							{
								
								$loyalty_points = $this->Transactions_model->get_discount($transaction_amt,$dis[0]);
									//echo "---loyalty_points--2---".$loyalty_points."---<br><br>";
								$points_array[] = $loyalty_points;
								
								$gained_points_fag = 1;
								$trans_lp_id = $LoyaltyID_array[0];
							}
							
							if($member_Tier_id == $lp_Tier_id  && $loyalty_points > 0)
							{
								//$points_array[] = $loyalty_points;
								
								$child_data = array(					
								'Company_id' => $Company_id,        
								'Transaction_date' => $lv_date_time,       
								'Seller' => $seller_id,
								'Enrollement_id' => $Customer_enroll_id,
								'Transaction_id' => 0,
								'Loyalty_id' => $trans_lp_id,
								'Reward_points' => $loyalty_points,
								
								);
							
								$child_result = $this->Transactions_model->insert_loyalty_transaction_child($child_data);
							}
							
						}
						//print_r($points_array); echo "<br><br>";
						if($gained_points_fag == 1)
						{
							$total_loyalty_points = array_sum($points_array);
						}
						else
						{
							$total_loyalty_points = 0;
						}
						//echo "---total_loyalty_points---".$total_loyalty_points."---<br><br>";die;
						
						$Promo_redeem_by = $this->input->post("Promo_redeem_by");
						
						$tp_db = $Purchase_Bill_no;
							$len = strlen($tp_db);
							$str = substr($tp_db,0,5);
							$bill = substr($tp_db,5,$len);
								
						if($Promo_redeem_by == 1) //******** Promo Code Redeem *********/
						{
						
							$PromoCode = $this->input->post('Promo_code');
							$PointsRedeem = $this->input->post('promo_points_redeemed');
							
							$promo_transaction_data = array(
							
							'Trans_type' => '7',
							'Topup_amount' => $PointsRedeem,
							'Company_id' => $Company_id,
							'Trans_date' => $lv_date_time,  
							'Bill_no' => $bill,  
							'Manual_billno' => $manual_bill_no,  
							'remark2' => 'PromoCode Transaction-('.$PromoCode.')',
							'Card_id' => $cardId,
							'Seller_name' => $Seller_name,
							'Seller' => $seller_id,
							'Enrollement_id' => $Customer_enroll_id,
							);
							
							$insert_promo_transaction_id = $this->Transactions_model->insert_loyalty_transaction($promo_transaction_data);
							
							$post_data21 = array('Promo_code_status' =>'1');
							
							$update_promo_code = $this->Transactions_model->utilize_promo_code($Company_id,$PromoCode,$post_data21);
							
							$TotalRedeemPoints = $TotalRedeemPoints + $PointsRedeem;
							
							$bill = $bill + 1;
						}
						
						$Gift_redeem_by = $this->input->post("Gift_redeem_by");
						
						if($Gift_redeem_by == 1) //******** Gift Card Redeem *********/
						{
	
							$gift_reedem = $this->input->post('gift_points_redeemed');
							
							$GiftCardNo = $this->input->post('GiftCardNo');
							$GiftBal = $this->input->post('Balance');
							$current_gift_balance = $GiftBal - $gift_reedem;
							
							
							$gift_transaction_data = array(
							
							'Trans_type' => '4',
							'Purchase_amount' => $gift_reedem,
							'Redeem_points' => $gift_reedem,
							'Company_id' => $Company_id,
							'Trans_date' => $lv_date_time,  
							'Payment_type_id' => '1',
							'Card_id' => $cardId,
							'GiftCardNo' => $GiftCardNo,
							'Bill_no' => $bill,  
							'Manual_billno' => $manual_bill_no,  
							'Seller_name' => $Seller_name,
							'Seller' => $seller_id,
							'Enrollement_id' => $Customer_enroll_id,
							);
							
							$insert_gift_transaction = $this->Transactions_model->insert_loyalty_transaction($gift_transaction_data);
							
							
							$result32 = $this->Transactions_model->update_giftcard_balance($GiftCardNo,$current_gift_balance,$Company_id);
						
							$TotalRedeemPoints = $TotalRedeemPoints + $gift_reedem;
							
							$bill = $bill + 1;
						}
					
						
						$bill_no = $bill + 1;
					
						
						$post_data = array(					
							'Trans_type' => '2',
							'Company_id' => $Company_id,
							'Purchase_amount' => $this->input->post("purchase_amt"),        
							'Trans_date' => $lv_date_time,       
							'Remarks' => $this->input->post('remark'),
							'Card_id' => $cardId,
							'Seller_name' => $Seller_name,
							'Seller' => $seller_id,
							'Enrollement_id' => $Customer_enroll_id,
							'Bill_no' => $bill,
							'Manual_billno' => $manual_bill_no,
							'remark2' => $remark_by,
							'Remarks' => $this->input->post("remark"),
							'Loyalty_pts' => $total_loyalty_points,
							'Paid_amount' => $this->input->post("pay_amt"),
							'Redeem_points' =>  $this->input->post("redeem_amt"),
							'Payment_type_id' => $this->input->post("Payment_type"),
							'balance_to_pay' => $this->input->post("pay_amt"),
							'purchase_category' => $Seller_category,
							'Source' => 0,
							'GiftCardNo' => $this->input->post('GiftCardNo'),
							'Voucher_no' =>'PromoCode-('.$this->input->post('Promo_code').')',
							'Create_user_id' => $data['enroll']
							
							);
						
							//print_r($post_data); die;
						$insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_data);
						
						$result = $this->Transactions_model->update_loyalty_transaction_child($Company_id,$lv_date_time,$seller_id,$Customer_enroll_id,$insert_transaction_id);
						
						$curr_bal = $card_bal + $total_loyalty_points;
						
						$transaction_redeem_points = $this->input->post("points_redeemed");
						
						$curr_bal = $curr_bal - $transaction_redeem_points;
						
						$topup_amt = $topup;
						
						$transaction_purchase_amt = $this->input->post("purchase_amt");
										
						$purchase_amount = $purchase_amt + $transaction_purchase_amt;	
						
						$transaction_redeem_amt = $this->input->post("redeem_amt");
						
						
						$reddem_amount = $reddem_amt + $transaction_redeem_points;	
									
						$result2 = $this->Transactions_model->update_customer_balance($cardId,$curr_bal,$Company_id,$topup_amt,$lv_date_time,$purchase_amount,$reddem_amount);
						
						$billno_withyear = $str.$bill_no;

						if($Sms_enabled=='1')
						{
							/*********************************Send SMS Code*******************************/
						}
						
						//$referre_setup = $this->input->post("referre_setup");
						 //$this->input->post("referre_membershipID");
					//	echo "--referee enroll---".$Refree_enroll_id."--<br><br>";
						
						if($Refree_enroll_id > 0)
						{
							
						$ref_cust_details = $this->Igain_model->get_enrollment_details($Refree_enroll_id);
						//$ref_cust_details = $this->Transactions_model->cust_details_from_card($Company_id,$referre_membershipID);
								
					
									$referre_membershipID = $ref_cust_details->Card_id;
									$ref_card_bal = $ref_cust_details->Current_balance;
									$ref_Customer_enroll_id = $ref_cust_details->Enrollement_id;
									$ref_topup_amt = $ref_cust_details->Total_topup_amt;
									$ref_purchase_amt = $ref_cust_details->total_purchase;
									$ref_reddem_amt = $ref_cust_details->Total_reddems;
									$member_Tier_id = $ref_cust_details->Tier_id;
									$ref_customer_name = $ref_cust_details->First_name." ".$ref_cust_details->Last_name;
								
						
						//echo "--referee ref_card_bal---".$ref_card_bal."--<br><br>"; die;		
						
							$Refree_topup = 0;
							
							$Referral_rule_for = 2; //*** Referral_rule_for transaction
							$Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for);
							$total_ref_topup = 0;
							
							foreach($Ref_rule as $rule)
							{
								$ref_start_date = $rule['From_date'];
								$ref_end_date = $rule['Till_date'];
								//$ref_Tier_id = $rule['Tier_id'];
								
								if($ref_start_date <= $Todays_date && $ref_end_date >= $Todays_date)
								{

									$ref_topup = $rule['Refree_topup'];
									
								}
								
								$total_ref_topup = $total_ref_topup + $ref_topup;
							}
							
								echo "--referee member total_ref_topup---".$total_ref_topup."--<br><br>";
								echo "--Seller_Refrence---".$Seller_Refrence."--<br><br>";
							//die;
							if($Seller_Refrence == 1 && $total_ref_topup > 0)
							{
							
									$refree_current_balnce = $ref_card_bal + $total_ref_topup;
									$refree_topup = $ref_topup_amt + $total_ref_topup;
						
									$result5 = $this->Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);
									
									$seller_curbal = $seller_curbal - $total_ref_topup;
									
									$top_db = $Topup_Bill_no;
									$len = strlen($top_db);
									$str = substr($top_db,0,5);
									$tp_bill = substr($top_db,5,$len);
									
									$topup_BillNo = $tp_bill + 1;
									$billno_withyear_ref = $str.$topup_BillNo;
									
									$post_Transdata = array(					
									'Trans_type' => '1',
									'Company_id' => $Company_id,
									'Topup_amount' => $total_ref_topup,        
									'Trans_date' => $lv_date_time,       
									'Remarks' => 'Referral Trans',
									'Card_id' => $referre_membershipID,
									'Seller_name' => $Seller_name,
									'Seller' => $seller_id,
									'Enrollement_id' => $ref_Customer_enroll_id,
									'Bill_no' => $tp_bill,
									'Manual_billno' => $manual_bill_no,
									'remark2' => $remark_by,
									'Loyalty_pts' => '0'
									);
									
									$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);
								
									$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
									
									
									$Email_content12 = array(
										'Ref_Topup_amount' => $total_ref_topup,
										'Notification_type' => 'Referral Topup',
										'Template_type' => 'Referral_topup',
										'Customer_name' => $customer_name,
										'Todays_date' => $Todays_date
									);
									
									$this->send_notification->send_Notification_email($ref_Customer_enroll_id,$Email_content12,$Logged_user_enrollid,$Company_id);
								
							}
						}

						if($Seller_topup_access=='1')
						{
							$Total_seller_bal = $seller_curbal - $total_loyalty_points;
							$Total_seller_bal = $Total_seller_bal + $reedem_points;
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
						
						$result4 = $this->Transactions_model->update_billno($seller_id,$billno_withyear);
						
						$Notification_type = "Loyalty Transaction";						
						$purchase_amt = $this->input->post("purchase_amt");
						$reedem =  $this->input->post("redeem_amt"); //$this->input->post("points_redeemed");
						$payment_by = $this->input->post("Payment_type");
						$balance_to_pay = $this->input->post("pay_amt");
						
						$seller_details = $this->Igain_model->get_enrollment_details($seller_id);
						$currency_details = $this->currency_model->edit_currency($seller_details->Country_id);
						$Symbol_currency = $currency_details->Symbol_of_currency;

						
						$Email_content = array(
							'Today_date' => $lv_date,
							'Purchase_amount' => $purchase_amt,
							'Redeem_points' => $reedem,
							'Payment_by' => $payment_by,
							'Balance_to_pay' => $balance_to_pay,
							'Total_loyalty_points' => $total_loyalty_points,
							'Symbol_currency' => $Symbol_currency,
							'GiftCardNo' => $GiftCardNo,
							'gift_reedem' => $gift_reedem,
							'Notification_type' => $Notification_type,
							'Template_type' => 'Loyalty_transaction'
						);
						$this->send_notification->send_Notification_email($Customer_enroll_id,$Email_content,$seller_id,$Company_id);
						//$this->send_loyalty_transaction_mail($Company_id,$Customer_enroll_id,$lv_date,$cardId,$purchase_amt,$reedem,$payment_by,$balance_to_pay,$name,$manual_bill_no,$total_loyalty_points,$curr_bal,$seller_id,$Notification_type);
										
						if( ($insert_transaction_id > 0) && ($result2 == true) && ($result4 == true) )
						{
							$this->session->set_flashdata("error_code","Loyalty Transaction done Successfully!!");
						}
						else
						{							
							$this->session->set_flashdata("error_code","Sorry, Loyalty Transaction Failed!!");
						}
						
						$this->session->unset_userdata('logged_in');   
						redirect('Login', 'refresh');
					}
				}
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}

}
?>
