<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Express_checkout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->library('cart');
		$this->load->model('shopping/Shopping_model');
		$this->config->load('paypal');
		$this->load->library('Send_notification');
		$this->load->model('General_setting_model');		

		$config = array(
			'Sandbox' => $this->config->item('Sandbox'),            // Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsername'),    // PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPassword'),    // PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignature'),    // PayPal API signature of the API caller
			'APISubject' => '',                                    // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion'),        // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'),
			'ApplicationID' => $this->config->item('ApplicationID'),
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);
		$this->load->library('paypal/paypal_pro', $config);
		
		// Show Errors
		if ($config['Sandbox']) {
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}
	}

	function index()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			if( isset($session_data['Cart_redeem_point']) )
			{
				$data['Cart_redeem_point'] = $session_data['Cart_redeem_point'];
			}
			else
			{
				$data['Cart_redeem_point'] = 0;
			}
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];
				
			}
			
			$data['Company_Redemptionratio'] = $Company_Redemptionratio;
			
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
		
			$this->session->unset_userdata('PayPalResult');
			$this->session->unset_userdata('shopping_cart');
			
			$order_sub_total = 0;	 $shipping_cost = 99;	 $tax = 0;	 $i = 0;
			if ($cart = $this->cart->contents())
			{
				foreach ($cart as $item)
				{
					$cart['items'][$i] = array(
						'id' => $item['id'],
						'name' => $item['name'],
						'qty' => $item['qty'],
						'price' => $item['price'],
					);	
					$order_sub_total = $order_sub_total + $item['subtotal'];
					$i++;
				}

				$order_total = $order_sub_total + $shipping_cost + $tax;
			

				$cart['shopping_cart'] = array(
					'items' => $cart['items'],
					'subtotal' => $order_sub_total,
					'shipping' => $shipping_cost,
					'handling' => 0,
					'tax' => $tax,
				);
				
				$cart['shopping_cart']['grand_total'] = $order_total;
				$this->load->vars('cart', $cart);
				$this->session->set_userdata('shopping_cart', $cart);
			}
			
			$this->load->view('express_checkout/index', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}

	function SetExpressCheckout()
	{
		$this->session->unset_userdata('PayPalResult');
		$cart = $this->session->userdata('shopping_cart');
		
		$SECFields = array
		(
			// 'maxamt' => round($cart['shopping_cart']['grand_total'] * 2,2),
			'maxamt' => $cart['shopping_cart']['grand_total'],
			// The expected maximum total amount the order will be, including S&H and sales tax.
			
			'returnurl' => site_url('express_checkout/GetExpressCheckoutDetails'),
			// Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
			
			'cancelurl' => site_url('express_checkout/OrderCancelled'),
			// Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
			
			// 'hdrimg' => site_url('images/logo1.png'),
			'hdrimg' => $this->config->item('base_url2').'images/logo1.png',
			// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
			
			// 'logoimg' => site_url('images/logo1.png'),
			'logoimg' => $this->config->item('base_url2').'images/logo1.png',
			// A URL to your logo image.  Formats:  .gif, .jpg, .png.  190x60.  PayPal places your logo image at the top of the cart review area.  This logo needs to be stored on a https:// server.
			
			'brandname' => 'iGainSpark',
			// A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
			
			'customerservicenumber' => '816-555-5555',
			// Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
		);
		 
		if ($cart = $this->cart->contents())
		{
			$sub_total = 0;
			$order_sub_total = 0;
			$shipping_cost = 99;
			$tax = 0;
			$i = 0;
			foreach ($cart as $item)
			{
				$order_sub_total = $order_sub_total + $item['subtotal'];
				$sub_total = $sub_total + $item['subtotal'];
				$i++;
			}
			$order_total = $order_sub_total + $shipping_cost + $tax;
		}
		
		$Payments = array();
		$Payment = array
		(
			'amt' => $order_total,
			// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
		);

		array_push($Payments, $Payment);

		$PayPalRequestData = array
		(
			'SECFields' => $SECFields,
			'Payments' => $Payments,
		);

		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);

		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->vars('errors', $errors);
			$this->load->view('express_checkout/paypal_error');
		}
		else
		{
			$this->session->set_userdata('PayPalResult', $PayPalResult);
			redirect($PayPalResult['REDIRECTURL'], 'Location');
		}
	}
	function GetExpressCheckoutDetails()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			$cart = $this->session->userdata('shopping_cart');
			$SetExpressCheckoutPayPalResult = $this->session->userdata('PayPalResult');
			$PayPal_Token = $SetExpressCheckoutPayPalResult['TOKEN'];
			$PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($PayPal_Token);

			if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
			{
				$errors = array('Errors'=>$PayPalResult['ERRORS']);
				$this->load->vars('errors', $errors);
				$this->load->view('express_checkout/paypal_error');
			}
			else
			{
				/*$cart['paypal_payer_id'] = isset($PayPalResult['PAYERID']) ? $PayPalResult['PAYERID'] : '';
				$cart['phone_number'] = isset($PayPalResult['PHONENUM']) ? $PayPalResult['PHONENUM'] : '';
				$cart['email'] = isset($PayPalResult['EMAIL']) ? $PayPalResult['EMAIL'] : '';
				$cart['first_name'] = isset($PayPalResult['FIRSTNAME']) ? $PayPalResult['FIRSTNAME'] : '';
				$cart['last_name'] = isset($PayPalResult['LASTNAME']) ? $PayPalResult['LASTNAME'] : '';

				foreach($PayPalResult['PAYMENTS'] as $payment) 
				{
					$cart['shipping_name'] = isset($payment['SHIPTONAME']) ? $payment['SHIPTONAME'] : '';
					$cart['shipping_street'] = isset($payment['SHIPTOSTREET']) ? $payment['SHIPTOSTREET'] : '';
					$cart['shipping_city'] = isset($payment['SHIPTOCITY']) ? $payment['SHIPTOCITY'] : '';
					$cart['shipping_state'] = isset($payment['SHIPTOSTATE']) ? $payment['SHIPTOSTATE'] : '';
					$cart['shipping_zip'] = isset($payment['SHIPTOZIP']) ? $payment['SHIPTOZIP'] : '';
					$cart['shipping_country_code'] = isset($payment['SHIPTOCOUNTRYCODE']) ? $payment['SHIPTOCOUNTRYCODE'] : '';
					$cart['shipping_country_name'] = isset($payment['SHIPTOCOUNTRYNAME']) ? $payment['SHIPTOCOUNTRYNAME'] : '';
				}*/
						
				$cart['shopping_cart']['shipping'] = 0.00;
				$cart['shopping_cart']['handling'] = 0;
				$cart['shopping_cart']['tax'] = 0;
					
				$cart['shopping_cart']['grand_total'] = $cart['shopping_cart']['subtotal'] + $cart['shopping_cart']['shipping']
                                                                        + $cart['shopping_cart']['handling'] + $cart['shopping_cart']['tax'];

				$this->session->set_userdata('shopping_cart', $cart);
				$this->load->vars('cart', $cart);
				//$this->load->view('express_checkout/review', $data);
                                redirect('Shopping/review');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
		
	}

	function DoExpressCheckoutPayment()
	{
		error_reporting(0);
		// print_r($_SESSION);
		// die;
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			$Symbol_of_currency = $Country_details->Symbol_of_currency;	
			
			/**********************Update Current point Balance**********************/
			
				// $redeem_point = $this->input->get('Redeem_points');
				//$point_redeem = $Current_balance - $redeem_point + $loyalty_pts; 
				
				// $bal = $data["Enroll_details"] -> Current_balance;
				// $cid = $session_data['Card_id'];
				// $Company_id = $session_data['Company_id'];
				// $Cust_redeem_point = $_SESSION['Redeem_points'];
				
				// $Update_Current_balance = $bal - $Cust_redeem_point;// + $total_loyalty_points;
				// $up = array('Current_balance' => $Update_Current_balance);
				// $this->Shopping_model->update_transaction($up,$cid,$Company_id);
				
	/**********************************************************************/
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			
				foreach($Company_details as $Company)
				{
					$Company_Redemptionratio = $Company['Redemptionratio'];	
				}
						
			$data['Company_Redemptionratio'] = $Company_Redemptionratio;
						
			echo"---Redeem_amount----".$_SESSION["Redeem_amount"]."---<br>";
			echo"---Company_Redemptionratio----".$data['Company_Redemptionratio']."---<br>";
			$Cust_wish_redeem_point = $_SESSION['Redeem_points'];
			echo"---Cust_wish_redeem_point----".$Cust_wish_redeem_point."---<br>";			
			$EquiRedeem = round($Cust_wish_redeem_point/$Company_Redemptionratio);
			echo"---EquiRedeem----".$EquiRedeem."---<br>";		
			
	/***************************Apply Loyalty Rule******************************/
	
			$cart1 = $this->session->userdata('shopping_cart');
			$subtotal = $cart1['shopping_cart']['subtotal'];
			//$grand_total = $cart1['shopping_cart']['grand_total'];
			$grand_total = $subtotal - $EquiRedeem ;
					
			$gained_points_fag = 0;
					
			$bal = $data["Enroll_details"] -> Current_balance;
			$cid = $session_data['Card_id'];
			$Company_id = $session_data['Company_id'];
			$Cust_redeem_point = $_SESSION['Redeem_points'];
						
			$CardId = $data["Enroll_details"] -> Card_id;
			$fname= $data["Enroll_details"] -> First_name;
			$midlename=$data["Enroll_details"] -> Middle_name;
			$lname=$data["Enroll_details"] ->Last_name;
			$bdate=$data["Enroll_details"] ->Date_of_birth;
			$address=$data["Enroll_details"] ->Current_address;
			$bal=$data["Enroll_details"] ->Current_balance;
			$Blocked_points=$data["Enroll_details"] ->Blocked_points;
			$phno=$data["Enroll_details"] ->Phone_no;
			$pinno=$data["Enroll_details"] ->pinno;
			$companyid=$data["Enroll_details"] ->Company_id;
			$cust_enrollment_id=$data["Enroll_details"] ->Enrollement_id;
			$image_path=$data["Enroll_details"] ->Photograph;				
			$filename_get1=$image_path;	
			$lv_member_Tier_id = $data["Enroll_details"] ->Tier_id;
						
				
			/******************Get Supper Seller Details*********************/		
			
			$Super_seller_flag = 1;
			$result = $this->Shopping_model->Get_Seller($Super_seller_flag,$Company_id);
				   
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
					
			$Trans_type = 2;
			$Payment_type_id = 1;
			$Remarks = "Loyalty Transaction";
			
	/*************************Get Supper Seller Loyalty Rule******************************/
			$Todays_date=date('Y-m-d');
			$loyalty_prog = $this->Shopping_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$Todays_date);
						
			$points_array = array();
					
			foreach($loyalty_prog as $prog)
			{
					$member_Tier_id = $lv_member_Tier_id;
									
					$value = array();
					$dis = array();
									
					$LoyaltyID_array = array();
					$Loyalty_at_flag = 0;	
					$lp_type=substr($prog['Loyalty_name'],0,2);											
										
					$Todays_date = $lv_date_time;
									
	$lp_details = $this->Shopping_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);	
			
				// var_dump($lp_details);
				// die;
				
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
							
				if($lp_type == 'PA')
				{		
					$transaction_amt = $subtotal;
				}
								
				if($lp_type == 'BA')
				{	
					$transaction_amt = $grand_total;
				}
						
				if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
				{
					for($i=0;$i<=count($value)-1;$i++)
					{
								   // echo "...i $i....".$value[$i];
								   // echo "...$i ....".$value[$i+1];
								   // die;
										
						if($value[$i+1] != "")
						{
							if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
							{
								$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
													
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
														
								$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data);
								}
							}
						}
						else if($transaction_amt > $value[$i])
						{
							$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
													
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
														
							$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data);
							}
						}
					}
				}
							
				if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
				{
									
					$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[0]);
										
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
								
					$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data);
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
			}
			echo"---Cust_redeem_point----".$Cust_redeem_point."---<br>";
			if($Cust_redeem_point != "")
			{
				$Cust_redeem_point=$Cust_redeem_point;
			}
			else
			{
				$Cust_redeem_point=0;
			}
			echo"---Cust_redeem_point----".$Cust_redeem_point."---<br>";
		$data = array('Company_id' => $Company_id,
						'Trans_type' => $Trans_type,
						'Payment_type_id' => $Payment_type_id,
						'Manual_billno' => 0,
						'Bill_no' => $bill,
						'Enrollement_id' => $cust_enrollment_id,
						'Card_id' => $CardId,
						'Seller' => $seller_id,
						'Seller_name' => $seller_name,
						'Trans_date' => $lv_date_time,
						'Remarks' => $Remarks,
						'Purchase_amount' => $subtotal,
						'Paid_amount' => $grand_total,
						'Redeem_points' => $Cust_redeem_point,
						'Loyalty_pts' => $total_loyalty_points,
						'Loyalty_id' => $trans_lp_id, 
						'balance_to_pay' => $grand_total,
						);
		$Customer_enroll_id = $cust_enrollment_id;
		$insert_transaction_id = $this->Shopping_model->purchase_transaction($data);
										
		$result11 = $this->Shopping_model->update_loyalty_transaction_child($Company_id,$lv_date_time,$seller_id,$cust_enrollment_id,$insert_transaction_id);
							
/************************* Update Current Balance ************************************/
								
							
		$cid = $CardId;
							
			$redeem_point = $Cust_redeem_point;
			//$point_redeem = $Current_balance - $redeem_point + $loyalty_pts; 
			$Update_Current_balance = $bal - $redeem_point + $total_loyalty_points;
			
			$up = array('Current_balance' => $Update_Current_balance);
			// $this->Stud_Model->update_transaction($up,$cid);
			
			$this->Shopping_model->update_transaction($up,$cid,$Company_id);
							
				$bill_no = $bill + 1;
				$billno_withyear = $str.$bill_no;
				$result4 = $this->Shopping_model->update_billno($seller_id,$billno_withyear);
					
/*************************************************************************************/
			
			$cart = $this->session->userdata('shopping_cart');
			$SetExpressCheckoutPayPalResult = $this->session->userdata('PayPalResult');
			$PayPal_Token = $SetExpressCheckoutPayPalResult['TOKEN'];

			$DECPFields = array(
				'token' => $PayPal_Token,
				// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
				
				'payerid' => $cart['paypal_payer_id'],
				// Required.  Unique PayPal customer id of the payer.  Returned by GetExpressCheckoutDetails, or if you used SKIPDETAILS it's returned in the URL back to your RETURNURL.
			);

			$Payments = array();
			$Payment = array(
				'amt' => $cart['shopping_cart']['grand_total'],
				// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
				
				'itemamt' => number_format($cart['shopping_cart']['subtotal'],2),
				// Subtotal of items only.
				
				// 'currencycode' => 'USD',
				'currencycode' => trim($Symbol_of_currency),
				// A three-character currency code.  Default is USD.
				
				'shippingamt' => number_format($cart['shopping_cart']['shipping'],2),
				// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
				
				'handlingamt' => number_format($cart['shopping_cart']['handling'],2),
				// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
				
				'taxamt' => number_format($cart['shopping_cart']['tax'],2),
				// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order.
				
				'shiptoname' => $cart['shipping_name'],
				// Required if shipping is included.  Person's name associated with this address.  32 char max.
				
				'shiptostreet' => $cart['shipping_street'],
				// Required if shipping is included.  First street address.  100 char max.
				
				'shiptocity' => $cart['shipping_city'],
				// Required if shipping is included.  Name of city.  40 char max.
				
				'shiptostate' => $cart['shipping_state'],
				// Required if shipping is included.  Name of state or province.  40 char max.
				
				'shiptozip' => $cart['shipping_zip'],
				// Required if shipping is included.  Postal code of shipping address.  20 char max.
				
				'shiptocountrycode' => $cart['shipping_country_code'],
				// Required if shipping is included.  Country code of shipping address.  2 char max.
				
				'shiptophonenum' => $cart['phone_number'],
				// Phone number for shipping address.  20 char max.
				
				'paymentaction' => 'Sale',
				// How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order.
			);

			array_push($Payments, $Payment);
			$PayPalRequestData = array(
				'DECPFields' => $DECPFields,
				'Payments' => $Payments,
			);

			$PayPalResult = $this->paypal_pro->DoExpressCheckoutPayment($PayPalRequestData);

			if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
			{
				$errors = array('Errors'=>$PayPalResult['ERRORS']);
				$this->load->vars('errors', $errors);
				$this->load->view('express_checkout/paypal_error',$data);
			}
			else
			{
				foreach($PayPalResult['PAYMENTS'] as $payment)
				{
					$cart['paypal_transaction_id'] = isset($payment['TRANSACTIONID']) ? $payment['TRANSACTIONID'] : '';
					$cart['paypal_fee'] = isset($payment['FEEAMT']) ? $payment['FEEAMT'] : '';
				}

				$this->session->set_userdata('shopping_cart', $cart);
				redirect('express_checkout/OrderComplete');
			}	
		}	
	}

	function OrderComplete()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			$cart = $this->session->userdata('shopping_cart');
			// if(empty($cart)) redirect('express_checkout');
			
			if(empty($cart))
			{
				redirect('express_checkout');
			}
			else
			{
				$this->load->vars('cart', $cart);			
				$Order_date = date('Y-m-d');
				
				/* $Cust_order = array
				(
					'date' => $Order_date,
					'Enrollment_id' => $data['enroll'],
					'Cust_name' => $cart['shipping_name'],
					'Cust_address' => $cart['shipping_street'].", ".$cart['shipping_city'].", ".$cart['shipping_state'].", ".$cart['shipping_country_name'],
					'Cust_city' => $cart['shipping_city'],
					'Cust_zip' => $cart['shipping_zip'],
					'Cust_state' => $cart['shipping_state'],
					'Cust_country' => $cart['shipping_country_name'],
					'Cust_phnno' => $cart['phone_number'],
					'Cust_email' => $cart['email'],
					'Shipping_cost' => number_format($cart['shopping_cart']['shipping'],2),
					'Order_total' => $cart['shopping_cart']['grand_total'],
					'Order_id' => $cart['paypal_transaction_id'],
					'Order_status' => 'Received'
				); */
				
				$Cust_order = array
				(
					'Company_id' => $data['Company_id'],
					'Trans_type' => '8',
					'Purchase_amount' => $cart['shopping_cart']['grand_total'],
					'Shipping_cost' => $cart['shopping_cart']['shipping'],
					'Paid_amount' => $cart['shopping_cart']['grand_total'],
					'Payment_type_id' => '5',
					'Trans_date' => $Order_date,
					'balance_to_pay' => $cart['shopping_cart']['grand_total'],
					'Create_user_id' => $data['enroll'],
					'Enrollement_id' => $data['enroll'],
					'Manual_billno' => $cart['paypal_transaction_id'],
					'Card_id' => $data['Card_id'],
					'remark2' => 'Online Shopping',
					'Delivery_status' => 'Received'
				);
						
				$cust_id = $this->Shopping_model->insert_transaction($Cust_order);
				
				$shipping_details = array
				(
					'Transaction_date' => $Order_date,
					'Enrollment_id' => $data['enroll'],
					'Cust_name' => $cart['shipping_name'],
					'Cust_address' => $cart['shipping_street'].", ".$cart['shipping_city'].", ".$cart['shipping_state'].", ".$cart['shipping_country_name'],
					'Cust_city' => $cart['shipping_city'],
					'Cust_zip' => $cart['shipping_zip'],
					'Cust_state' => $cart['shipping_state'],
					'Cust_country' => $cart['shipping_country_name'],
					'Cust_phnno' => $cart['phone_number'],
					'Cust_email' => $cart['email'],
					'Transaction_id' => $cust_id,
					'Company_id' => $data['Company_id']
				);
				
				$shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);
				
				foreach($cart['items'] as $cart_item) 
				{
					/* $order_detail = array(
						'serial_id' => $cust_id,
						'productid' => $cart_item['id'],
						'quantity' => $cart_item['qty'],
						'price' => number_format($cart_item['price'],2),
						'Order_date' => $Order_date
					); */
					
					$order_detail = array
					(
						'Enrollement_id' => $data['enroll'],
						'Transaction_id' => $cust_id,
						'Company_id' => $data['Company_id'],
						'Product_id' => $cart_item['id'],
						'Quantity' => $cart_item['qty'],
						'Unit_price' => $cart_item['price'],
						'Transaction_date' => $Order_date
					);
						
					$ord_id = $this->Shopping_model->insert_transaction_child($order_detail);
				}
				
				$Order_details = $this->Shopping_model->get_order_details2($cust_id);
				$Order_details2 = $this->Shopping_model->get_order_details($cust_id);
				$Email_content = array(
					'Enrollment_id' => $data['enroll'],
					'Notification_type' => 'Your Order confirmation for #'.$cart['paypal_transaction_id'],
					'Template_type' => 'Shopping_order_confirm',
					'Order_no' => $cart['paypal_transaction_id'],
					'Order_date' => $Order_date,
					'Symbol_of_currency' => $data['Symbol_of_currency'],
					'Order_details' => $Order_details,
					'Order_details2' => $Order_details2
				);								
				$send_notification = $this->send_notification->send_Notification_email($data['enroll'],$Email_content,'1',$data['Company_id']);
				
				$this->cart->destroy();
				
				$session_data['Cart_redeem_point'] = 0; 
				$this->session->set_userdata("cust_logged_in", $session_data);
			
				$this->load->view('express_checkout/payment_complete',$data);
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}

	function OrderCancelled()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$this->session->unset_userdata('PayPalResult');
			$this->session->unset_userdata('shopping_cart');
			$this->cart->destroy();
			
			$session_data['Cart_redeem_point'] = 0; 
			$this->session->set_userdata("cust_logged_in", $session_data);
					
			$this->load->view('express_checkout/order_cancelled',$data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	/*************************Calculate Redeem Amount**************************/
	/* public function cal_redeem_amt_contrl()
	{
		// echo"cal_redeem_amt_contrl";
		$Current_balance = $this->input->post('Current_balance');
		$grand_total = $this->input->post('grand_total');
		$Redeem_points = $this->input->post('Redeem_points');
		$ratio_value = $this->input->post('ratio_value');
		$redeemBY = $this->input->post('redeemBY');
			
		if($redeemBY == 0)
		{
			$session_data = $this->session->userdata('cust_logged_in');
			if(!isset($session_data['Cart_redeem_point']))
			{
				$session_data['Cart_redeem_point'] = 0; 
				$this->session->set_userdata("cust_logged_in", $session_data);
			}
			else
			{	
				$session_data['Cart_redeem_point'] = 0; 
				$this->session->set_userdata("cust_logged_in", $session_data);
			}
				$Result21 = array('Error_flag' => 3); // Customer dont want to wish redeem point
		}
		else
		{
			$EquiRedeem = round($Redeem_points/$ratio_value);
			   
			if($EquiRedeem > $grand_total)
			{
				$Result21 = array('Error_flag' => 1); //Redeem Amount is More than Total Bill Amount
					
			}
			else
			{
				if($Current_balance < $Redeem_points)
				{
					$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
				}
				else
				{
					if($this->session->userdata('cust_logged_in'))
					{
						$session_data = $this->session->userdata('cust_logged_in'); 
						if(!isset($session_data['Cart_redeem_point']))
						{
							$session_data['Cart_redeem_point'] = $Redeem_points; 
							$this->session->set_userdata("cust_logged_in", $session_data);
						}
						else
						{	
							$session_data['Cart_redeem_point'] = $Redeem_points; 
							$this->session->set_userdata("cust_logged_in", $session_data);
								
							$_SESSION['Redeem_points'] = $Redeem_points;
						}
					}
						
					$Total_bill = ($grand_total - $EquiRedeem);
					//$Total_bill = ($grand_total - round($EquiRedeem,1,2));
					$Total_bill=round($Total_bill,2);
				$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
				}
			}
		}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($Result21));
	} */

	public function cal_redeem_amt_contrl()
	{	
		
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id= $session_data['Company_id'];
			
			$Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
			$Cust_Tier_id = $Enroll_details ->Tier_id;
			$Cust_Total_reddems = $Enroll_details ->Total_reddems;	

			$Cust_current_bal = $Enroll_details -> Current_balance;			
			
			$Current_point_balance1 = $Cust_current_bal-($Enroll_details->Blocked_points+$Enroll_details->Debit_points);					
			if($Current_point_balance1<0)
			{
				$Current_point_balance1=0;
			} 
			else
			{
				$Current_point_balance1=$Current_point_balance1;
			}
			
			$Tier_details = $this->Igain_model->get_tier_details($Cust_Tier_id,$Company_id);
			$Cust_Redeemtion_limit = $Tier_details->Redeemtion_limit;
			$Cust_Tier_level_id = $Tier_details->Tier_level_id;
			
			/* echo"----Current_point_balance1--".$Current_point_balance1."----<br>";
			echo"----Cust_Redeemtion_limit--".$Cust_Redeemtion_limit."----<br>";
			echo "--Cust_Total_reddems---".$Cust_Total_reddems."---<br>"; */ 	
			
			$Current_balance = $this->input->post('Current_balance');
			$grand_total = $this->input->post('grand_total');
			$Redeem_points = $this->input->post('Redeem_points');
			$ratio_value = $this->input->post('ratio_value');
			$redeemBY = $this->input->post('redeemBY');
			
			$redeem_voucher_amt = $this->input->post('redeem_voucher_amt');
			$grand_total = $grand_total - $redeem_voucher_amt;
			
			
	
			/* echo"----Current_balance--".$Current_balance."----<br>";
			echo"----grand_total--".$grand_total."----<br>";
			echo"----Redeem_points--".$Redeem_points."----<br>";
			echo"----ratio_value--".$ratio_value."----<br>";
			echo"----redeemBY--".$redeemBY."----<br>";			
			echo "--Cust_Tier_id---".$Cust_Tier_id."---<br>";
			echo "--Cust_Total_reddems---".$Cust_Total_reddems."---<br>"; 		
			
			echo "--Cust_Redeemtion_limit---".$Cust_Redeemtion_limit."---<br>";
			echo "--Cust_Tier_level_id---".$Cust_Tier_level_id."---<br>"; */ 
			
			/* $Redeem_points > $Cust_Redeemtion_limit &&  */
			
			if($Cust_Redeemtion_limit != 0 && $Cust_Total_reddems <= 0 ){
				
					if($Current_point_balance1 <= $Cust_Redeemtion_limit ){
					
						
						
						// echo "Your Point balance is less than Limit"; 
						$Result21 = array('Error_flag' => 4,'Redeemtion_limit' => $Cust_Redeemtion_limit);				
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode($Result21));
				
					
					
					} else {
					
						
							/* if($Redeem_points > $Cust_Redeemtion_limit){
							
								// echo "You can not redeem"; 
								
								$Result21 = array('Error_flag' => 5,'Redeemtion_limit' => $Cust_Redeemtion_limit);				
								$this->output->set_content_type('application/json');
								$this->output->set_output(json_encode($Result21));
							
							} else { */
							
								// echo "You can redeem"; 
					
								$EquiRedeem = round($Redeem_points/$ratio_value);
								$abc = round(1/$ratio_value);
							
								
								if($EquiRedeem > $grand_total)
								{
									$bb = ($EquiRedeem - $grand_total);
									
									if($bb >= $abc){
										$Result21 = array('Error_flag' => 1); //Redeem Amount is More than Total Bill Amount
									}
									else{
										if($this->session->userdata('cust_logged_in'))
										{
											$session_data = $this->session->userdata('cust_logged_in'); 
											if(!isset($session_data['Cart_redeem_point']))
											{
												$session_data['Cart_redeem_point'] = $Redeem_points; 
												$this->session->set_userdata("cust_logged_in", $session_data);
											}
											else
											{	
												$session_data['Cart_redeem_point'] = $Redeem_points; 
												$this->session->set_userdata("cust_logged_in", $session_data);
													
												$_SESSION['Redeem_points'] = $Redeem_points;
												$_SESSION['Redeem_amount'] = $EquiRedeem;
											}
										}
											
										$Total_bill = ($grand_total - $EquiRedeem);					
										if($Total_bill < 0){
											$Total_bill = 0;
											$EquiRedeem=$grand_total;
											$_SESSION['Redeem_amount'] = $grand_total;
										}
										// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
										
										
										if($Current_balance < $Redeem_points)
										{
											$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
											
										} else{
											
											$Total_bill=round($Total_bill,2);
											$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
										}
										
										
										
									}
										
								}
								else
								{
									if($Current_balance < $Redeem_points)
									{
										$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
									}
									else
									{
										if($this->session->userdata('cust_logged_in'))
										{
											$session_data = $this->session->userdata('cust_logged_in'); 
											if(!isset($session_data['Cart_redeem_point']))
											{
												$session_data['Cart_redeem_point'] = $Redeem_points; 
												$this->session->set_userdata("cust_logged_in", $session_data);
											}
											else
											{	
												$session_data['Cart_redeem_point'] = $Redeem_points; 
												$this->session->set_userdata("cust_logged_in", $session_data);
													
												$_SESSION['Redeem_points'] = $Redeem_points;
												$_SESSION['Redeem_amount'] = $EquiRedeem;
											}
										}
											
										$Total_bill = ($grand_total - $EquiRedeem);
										// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
										$Total_bill=round($Total_bill,2);
										$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
									}
								}
								
								$this->output->set_content_type('application/json');
								$this->output->set_output(json_encode($Result21));
					
						// }
					
					
					}
				
				
				/* $Result21 = array('Error_flag' => 4,'Redeemtion_limit' => $Cust_Redeemtion_limit);				
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode($Result21));  */	
				
				
			} else {
				
				// echo "--You can redeem --33--".$Redeem_points."---<br>";
				
				
				
				if($redeemBY == 0)
				{
					$session_data = $this->session->userdata('cust_logged_in');
					if(!isset($session_data['Cart_redeem_point']))
					{
						$session_data['Cart_redeem_point'] = 0; 
						$this->session->set_userdata("cust_logged_in", $session_data);
					}
					else
					{	
						$session_data['Cart_redeem_point'] = 0; 
						$this->session->set_userdata("cust_logged_in", $session_data);
					}
						$Result21 = array('Error_flag' => 3); // Customer dont want to wish redeem point
				}
				else
				{
					$EquiRedeem = round($Redeem_points/$ratio_value);
					$abc = round(1/$ratio_value);
				
					
					if($EquiRedeem > $grand_total)
					{
						$bb = ($EquiRedeem - $grand_total);
						
						if($bb >= $abc){
							$Result21 = array('Error_flag' => 1); //Redeem Amount is More than Total Bill Amount
						}
						else{
							if($this->session->userdata('cust_logged_in'))
							{
								$session_data = $this->session->userdata('cust_logged_in'); 
								if(!isset($session_data['Cart_redeem_point']))
								{
									$session_data['Cart_redeem_point'] = $Redeem_points; 
									$this->session->set_userdata("cust_logged_in", $session_data);
								}
								else
								{	
									$session_data['Cart_redeem_point'] = $Redeem_points; 
									$this->session->set_userdata("cust_logged_in", $session_data);
										
									$_SESSION['Redeem_points'] = $Redeem_points;
									$_SESSION['Redeem_amount'] = $EquiRedeem;
								}
							}
								
							$Total_bill = ($grand_total - $EquiRedeem);					
							if($Total_bill < 0){
								$Total_bill = 0;
								$EquiRedeem=$grand_total;
								$_SESSION['Redeem_amount'] = $grand_total;
							}
							// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
							
							
							if($Current_balance < $Redeem_points)
							{
								$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
								
							} else{
								
								$Total_bill=round($Total_bill,2);
								$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
							}
							
							
							
						}
							
					}
					else
					{
						if($Current_balance < $Redeem_points)
						{
							$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
						}
						else
						{
							if($this->session->userdata('cust_logged_in'))
							{
								$session_data = $this->session->userdata('cust_logged_in'); 
								if(!isset($session_data['Cart_redeem_point']))
								{
									$session_data['Cart_redeem_point'] = $Redeem_points; 
									$this->session->set_userdata("cust_logged_in", $session_data);
								}
								else
								{	
									$session_data['Cart_redeem_point'] = $Redeem_points; 
									$this->session->set_userdata("cust_logged_in", $session_data);
										
									$_SESSION['Redeem_points'] = $Redeem_points;
									$_SESSION['Redeem_amount'] = $EquiRedeem;
								}
							}
								
							$Total_bill = ($grand_total - $EquiRedeem);
							// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
							$Total_bill=round($Total_bill,2);
							$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
						}
					}
				}
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode($Result21));	
								
			}			
			/* if($redeemBY == 0)
			{
				$session_data = $this->session->userdata('cust_logged_in');
				if(!isset($session_data['Cart_redeem_point']))
				{
					$session_data['Cart_redeem_point'] = 0; 
					$this->session->set_userdata("cust_logged_in", $session_data);
				}
				else
				{	
					$session_data['Cart_redeem_point'] = 0; 
					$this->session->set_userdata("cust_logged_in", $session_data);
				}
					$Result21 = array('Error_flag' => 3); // Customer dont want to wish redeem point
			}
			else
			{
				$EquiRedeem = round($Redeem_points/$ratio_value);
				$abc = round(1/$ratio_value);
			
				
				if($EquiRedeem > $grand_total)
				{
					$bb = ($EquiRedeem - $grand_total);
					
					if($bb >= $abc){
						$Result21 = array('Error_flag' => 1); //Redeem Amount is More than Total Bill Amount
					}
					else{
						if($this->session->userdata('cust_logged_in'))
						{
							$session_data = $this->session->userdata('cust_logged_in'); 
							if(!isset($session_data['Cart_redeem_point']))
							{
								$session_data['Cart_redeem_point'] = $Redeem_points; 
								$this->session->set_userdata("cust_logged_in", $session_data);
							}
							else
							{	
								$session_data['Cart_redeem_point'] = $Redeem_points; 
								$this->session->set_userdata("cust_logged_in", $session_data);
									
								$_SESSION['Redeem_points'] = $Redeem_points;
								$_SESSION['Redeem_amount'] = $EquiRedeem;
							}
						}
							
						$Total_bill = ($grand_total - $EquiRedeem);					
						if($Total_bill < 0){
							$Total_bill = 0;
							$EquiRedeem=$grand_total;
							$_SESSION['Redeem_amount'] = $grand_total;
						}
						// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
						
						
						if($Current_balance < $Redeem_points)
						{
							$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
							
						} else{
							
							$Total_bill=round($Total_bill,2);
							$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
						}
						
						
						
					}
						
				}
				else
				{
					if($Current_balance < $Redeem_points)
					{
						$Result21 = array('Error_flag' => 2); //Insufficient Point Balance 
					}
					else
					{
						if($this->session->userdata('cust_logged_in'))
						{
							$session_data = $this->session->userdata('cust_logged_in'); 
							if(!isset($session_data['Cart_redeem_point']))
							{
								$session_data['Cart_redeem_point'] = $Redeem_points; 
								$this->session->set_userdata("cust_logged_in", $session_data);
							}
							else
							{	
								$session_data['Cart_redeem_point'] = $Redeem_points; 
								$this->session->set_userdata("cust_logged_in", $session_data);
									
								$_SESSION['Redeem_points'] = $Redeem_points;
								$_SESSION['Redeem_amount'] = $EquiRedeem;
							}
						}
							
						$Total_bill = ($grand_total - $EquiRedeem);
						// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
						$Total_bill=round($Total_bill,2);
						$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
					}
				}
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($Result21));	 */	
			
			
			
		}
		else
		{
			redirect('Login', 'refresh');
		}		
		
	} 
   
/******************************************************************/
}