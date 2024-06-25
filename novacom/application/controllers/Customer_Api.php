<?php 
	class Customer_Api extends CI_Controller 
	{
		public function __construct()
		{
			parent::__construct();		
			$this->load->library('form_validation');		
			$this->load->database();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('Customer_Api_model');	
			// $this->load->model('Customer_Api_model');	
			// $this->load->model('Customer_Api_model');
			$this->load->helper('string');					
			include('application/libraries/Braintree/Base.php');
            include('application/libraries/Braintree/Modification.php');
            include('application/libraries/Braintree/Instance.php');                
            include('application/libraries/Braintree/OAuthCredentials.php');
            include('application/libraries/Braintree/Address.php');
            include('application/libraries/Braintree/AddressGateway.php');
            include('application/libraries/Braintree/AddOn.php');
            include('application/libraries/Braintree/AddOnGateway.php');
            include('application/libraries/Braintree/AndroidPayCard.php');
            include('application/libraries/Braintree/ApplePayCard.php');
            include('application/libraries/Braintree/ClientToken.php');
            include('application/libraries/Braintree/ClientTokenGateway.php');
            include('application/libraries/Braintree/CoinbaseAccount.php');
            include('application/libraries/Braintree/Collection.php');
            include('application/libraries/Braintree/Configuration.php');
            include('application/libraries/Braintree/CredentialsParser.php');
            include('application/libraries/Braintree/CreditCard.php');
            include('application/libraries/Braintree/CreditCardGateway.php');
            include('application/libraries/Braintree/Customer.php');
            include('application/libraries/Braintree/CustomerGateway.php');
            include('application/libraries/Braintree/CustomerSearch.php');
            include('application/libraries/Braintree/DisbursementDetails.php');
            include('application/libraries/Braintree/Dispute.php');
            include('application/libraries/Braintree/Dispute/TransactionDetails.php');
            include('application/libraries/Braintree/Descriptor.php');
            include('application/libraries/Braintree/Digest.php');
            include('application/libraries/Braintree/Discount.php');
            include('application/libraries/Braintree/DiscountGateway.php');
            include('application/libraries/Braintree/IsNode.php');
            include('application/libraries/Braintree/EuropeBankAccount.php');
            include('application/libraries/Braintree/EqualityNode.php');
            include('application/libraries/Braintree/Exception.php');
            include('application/libraries/Braintree/Gateway.php');
            include('application/libraries/Braintree/Http.php');
            include('application/libraries/Braintree/KeyValueNode.php');
            include('application/libraries/Braintree/Merchant.php');
            include('application/libraries/Braintree/MerchantGateway.php');
            include('application/libraries/Braintree/MerchantAccount.php');
            include('application/libraries/Braintree/MerchantAccountGateway.php');
            include('application/libraries/Braintree/MerchantAccount/BusinessDetails.php');
            include('application/libraries/Braintree/MerchantAccount/FundingDetails.php');
            include('application/libraries/Braintree/MerchantAccount/IndividualDetails.php');
            include('application/libraries/Braintree/MerchantAccount/AddressDetails.php');
            include('application/libraries/Braintree/MultipleValueNode.php');
            include('application/libraries/Braintree/MultipleValueOrTextNode.php');
            include('application/libraries/Braintree/OAuthGateway.php');
            include('application/libraries/Braintree/PartialMatchNode.php');
            include('application/libraries/Braintree/Plan.php');
            include('application/libraries/Braintree/PlanGateway.php');
            include('application/libraries/Braintree/RangeNode.php');
            include('application/libraries/Braintree/ResourceCollection.php');
            include('application/libraries/Braintree/RiskData.php');
            include('application/libraries/Braintree/ThreeDSecureInfo.php');
            include('application/libraries/Braintree/SettlementBatchSummary.php');
            include('application/libraries/Braintree/SettlementBatchSummaryGateway.php');
            include('application/libraries/Braintree/SignatureService.php');
            include('application/libraries/Braintree/Subscription.php');
            include('application/libraries/Braintree/SubscriptionGateway.php');
            include('application/libraries/Braintree/SubscriptionSearch.php');
            include('application/libraries/Braintree/Subscription/StatusDetails.php');
            include('application/libraries/Braintree/TextNode.php');
            include('application/libraries/Braintree/Transaction.php');
            include('application/libraries/Braintree/TransactionGateway.php');
            include('application/libraries/Braintree/Disbursement.php');
            include('application/libraries/Braintree/TransactionSearch.php');
            include('application/libraries/Braintree/TransparentRedirect.php');
            include('application/libraries/Braintree/TransparentRedirectGateway.php');
            include('application/libraries/Braintree/Util.php');
            include('application/libraries/Braintree/Version.php');
            include('application/libraries/Braintree/Xml.php');
            include('application/libraries/Braintree/Error/Codes.php');
            include('application/libraries/Braintree/Error/ErrorCollection.php');
            include('application/libraries/Braintree/Error/Validation.php');
            include('application/libraries/Braintree/Error/ValidationErrorCollection.php');
            include('application/libraries/Braintree/Exception/Authentication.php');
            include('application/libraries/Braintree/Exception/Authorization.php');
            include('application/libraries/Braintree/Exception/Configuration.php');
            include('application/libraries/Braintree/Exception/DownForMaintenance.php');
            include('application/libraries/Braintree/Exception/ForgedQueryString.php');
            include('application/libraries/Braintree/Exception/InvalidChallenge.php');
            include('application/libraries/Braintree/Exception/InvalidSignature.php');
            include('application/libraries/Braintree/Exception/NotFound.php');
            include('application/libraries/Braintree/Exception/ServerError.php');
            include('application/libraries/Braintree/Exception/SSLCertificate.php');
            include('application/libraries/Braintree/Exception/SSLCaFileNotFound.php');
            include('application/libraries/Braintree/Exception/Unexpected.php');
            include('application/libraries/Braintree/Exception/UpgradeRequired.php');
            include('application/libraries/Braintree/Exception/ValidationsFailed.php');
            include('application/libraries/Braintree/Result/CreditCardVerification.php');
            include('application/libraries/Braintree/Result/Error.php');
            include('application/libraries/Braintree/Result/Successful.php');
            include('application/libraries/Braintree/Test/CreditCardNumbers.php');
            include('application/libraries/Braintree/Test/MerchantAccount.php');
            include('application/libraries/Braintree/Test/TransactionAmounts.php');
            include('application/libraries/Braintree/Test/VenmoSdk.php');
            include('application/libraries/Braintree/Test/Nonces.php');
            include('application/libraries/Braintree/Transaction/AddressDetails.php');
            include('application/libraries/Braintree/Transaction/AndroidPayCardDetails.php');
            include('application/libraries/Braintree/Transaction/ApplePayCardDetails.php');
            include('application/libraries/Braintree/Transaction/CoinbaseDetails.php');
            include('application/libraries/Braintree/Transaction/EuropeBankAccountDetails.php');
            include('application/libraries/Braintree/Transaction/CreditCardDetails.php');
            include('application/libraries/Braintree/Transaction/PayPalDetails.php');
            include('application/libraries/Braintree/Transaction/CustomerDetails.php');
            include('application/libraries/Braintree/Transaction/StatusDetails.php');
            include('application/libraries/Braintree/Transaction/SubscriptionDetails.php');
            include('application/libraries/Braintree/WebhookNotification.php');
            include('application/libraries/Braintree/WebhookTesting.php');
            include('application/libraries/Braintree/Xml/Generator.php');
            include('application/libraries/Braintree/Xml/Parser.php');
            include('application/libraries/Braintree/CreditCardVerification.php');
            include('application/libraries/Braintree/CreditCardVerificationGateway.php');
            include('application/libraries/Braintree/CreditCardVerificationSearch.php');
            include('application/libraries/Braintree/PartnerMerchant.php');
            include('application/libraries/Braintree/PayPalAccount.php');
            include('application/libraries/Braintree/PayPalAccountGateway.php');
            include('application/libraries/Braintree/PaymentMethod.php');
            include('application/libraries/Braintree/PaymentMethodGateway.php');
            include('application/libraries/Braintree/PaymentMethodNonce.php');
            include('application/libraries/Braintree/PaymentMethodNonceGateway.php');
            include('application/libraries/Braintree/PaymentInstrumentType.php');
            include('application/libraries/Braintree/UnknownPaymentMethod.php');
            include('application/libraries/Braintree/Exception/TestOperationPerformedInProduction.php');
            include('application/libraries/Braintree/Test/Transaction.php'); 

            /**********************Master Merchant**********************/
                Braintree_Configuration::environment('sandbox');
                Braintree_Configuration::merchantId('dncf7k2zmbv3x3j9');
                Braintree_Configuration::publicKey('2s7h95c6h6xzqzp4');
                Braintree_Configuration::privateKey('c54f58cd42a769912a7902632f60c796');
            /**********************Master Merchant**********************/
			
			
			$this->load->helper('language');
			$session_site_lang = $this->session->userdata('site_lang');		
			$this->lang->load("message","".$session_site_lang."");
			
	}
		
	public function index() 
	{ 	
		$this->load->view('E_Commerce_API'); 
	}		
	public function get_member()
	{ 
		$Company_id = $this->input->get("Company_id");
		$cid = $this->input->get("Membership_id");
		$Country_id = 1; //pass Country_id manual hear
		$dial_code = $this->Customer_Api_model->get_dial_code1($Country_id);	//Get Country Dial code 	
		$phnumber = $dial_code.$this->input->get("Membership_id");
		
		/********* JSON CODE *********/
		$result = $this->Customer_Api_model->get_pos($cid,$Company_id,$phnumber); //Get Customer details
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
	function DoExpressCheckoutPayment()
	{ 
		$input_Company_key = $this->input->post('API_key');
		$Company_id = $this->input->post('Company_id');
		$cardId = $this->input->post('Membership_id');
		$item_name1 = $this->input->post('item_name1');
		$item_id = $this->input->post('item_name1');
		$item_qty1 = $this->input->post('item_qty1'); 
		$item_rate1 = $this->input->post('item_rate1');
		$purchase_amt = $item_qty1 * $item_rate1;
		$Redeem_points = $this->input->post('Redeem_points');
		$Shipping_address = $this->input->post('address');  
		$city = $this->input->post('city');
		$zip = $this->input->post('zip');
		$state = $this->input->post('state');
		$contact = $this->input->post('contact');
		// $email = $this->input->post('email');
		$Payment_option = $this->input->post('Payment_option');
				
		if($_REQUEST['item_name1'] != "")
		{
			$item_1 = $_REQUEST['item_name1'];
			$quantity_1 = $_REQUEST['item_qty1'];
            $Product_details1["Item_code"] = $item_1;
			$Product_details1["Quantity"] = $quantity_1;
			$Product_details1["Total_price"] = $_REQUEST['item_rate1'];
            $Product_details[0] = $Product_details1;
        }
        if($_REQUEST['item_name2'] != "")
        {
			$item_2 = $_REQUEST['item_name2'];
			$quantity_2 = $_REQUEST['item_qty2'];
            $Product_details2["Item_code"] = $item_2;
            $Product_details2["Quantity"] = $quantity_2;
            $Product_details2["Total_price"] = $_REQUEST['item_rate2'];
            $Product_details[1] = $Product_details2;
        }
		if($_REQUEST['item_name3'] != "")
        {
			$item_3 = $_REQUEST['item_name3'];
			$quantity_3 = $_REQUEST['item_qty3'];
            $Product_details3["Item_code"] = $item_3;
            $Product_details3["Quantity"] = $quantity_3; 
            $Product_details3["Total_price"] = $_REQUEST['item_rate3'];
            $Product_details[2] = $Product_details3;
        }
				
			$result1 = $this->Customer_Api_model->check_company_key_valid($Company_id,$input_Company_key); 
			
			$Company_key = $result1-> Company_key;
			
		if($input_Company_key == $Company_key)
		{	
			$Company_details = $this->Customer_Api_model->Fetch_Company_Details($Company_id);
				
			foreach($Company_details as $Company)
			{
				$Country_id = $Company['Country'];
			}
			
			$dial_code = $this->Customer_Api_model->get_dial_code1($Country_id);	//Get Country Dial code 
			$phnumber = $dial_code.$this->input->post("Membership_id");
			
			$result = $this->Customer_Api_model->get_enrollment_details($cardId,$phnumber,$Company_id); //Get Card details
			
			if($result != NULL)
			{
			if(!empty($Product_details))
			{
				$subtotal=0;
				foreach($Product_details as $productinfo)
				{
					$Total_purchase_amt = $productinfo["Quantity"]*$productinfo["Total_price"];
					$subtotal+=$Total_purchase_amt;
				}
				
			if($Product_details != "")
			{
				foreach($Product_details as $productinfo)
				{
						$item_id = $productinfo["Item_code"];
						$item_qty = $productinfo["Quantity"];  
						$item_rate = $productinfo["Total_price"];  
							
						/*******************Get Merchandize item name*******************/
						
						$result878 = $this->Customer_Api_model->Get_merchandize_item($item_id,$Company_id);
				}
			}
				if($result878 != NULL)
				{
				
				if($Shipping_address !="" && $city !="" && $zip !="" && $state !="" && $contact !="")
				{	
				
				$data["Enroll_details"] = $this->Customer_Api_model->get_enrollment_details($cardId,$phnumber,$Company_id);
				// $data["Enroll_details"] = $this->Customer_Api_model->get_enrollment_details($Enrollement_id);
			
				$Company_details = $this->Customer_Api_model->Fetch_Company_Details($Company_id);
				
				foreach($Company_details as $Company)
				{
					$Country = $Company['Country'];
				}
				$Country_details = $this->Customer_Api_model->get_dial_code($Country );
				$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
				$Symbol_of_currency = $Country_details->Symbol_of_currency;	
			
				$Company_details = $this->Customer_Api_model->Fetch_Company_Details($Company_id);
				
					foreach($Company_details as $Company)
					{
						$Company_Redemptionratio = $Company['Redemptionratio'];	
					}
							
				$data['Company_Redemptionratio'] = $Company_Redemptionratio;
				$bal = $data["Enroll_details"] -> Current_balance;	
				$Membership_Id  = $data["Enroll_details"] -> Card_id;	
				$Cust_wish_redeem_point = $Redeem_points;
				
				if($Cust_wish_redeem_point > $bal)
				{
					$Result12[] = array('Error_flag' => 3); //Insufficient Point Balance
					$this->output->set_output(json_encode($Result12));	
				}
				else
				{
					$EquiRedeem = round($Cust_wish_redeem_point/$Company_Redemptionratio);
				
		/***************************Apply Loyalty Rule******************************/		
		if($EquiRedeem > $subtotal)
		{
			$Result121[] = array('Error_flag' => 4); //Equivalent Redeem Amount is More than Total Bill Amount
			$this->output->set_output(json_encode($Result121));		
		}
		else
		{
		if($Payment_option == 1)     
        {	
			$Card_no = $this->input->post('Card_no');
			$card_name = $this->input->post('card_name');
			$Cvv = $this->input->post('Cvv');
			$valid = $this->input->post('valid');
			
			// var_dump($Card_no);
			// var_dump($card_name);
			// var_dump($Cvv);
			// var_dump($valid);
			
		if($Card_no !="" && $card_name !="" && $Cvv !="" && $valid !="")
		{
				$Payment = "BrainTree";
				$grand_total = $subtotal - $EquiRedeem ;
				$amount = $grand_total;
				$card_number = $Card_no;
				$card_name = $card_name;
				$cvv = $Cvv;
				$expirationDate = $valid;
				
				// $card_number = '5105105105105100';
				// $card_name = "nilesh c";
				// $expirationDate = '05/27';
				// $cvv = '123';
				
                $payment_result = Braintree_Transaction::sale(array
                                        (
                                            'amount' => $amount,
                                            'creditCard' => array
                                            (
                                                'number' => $card_number,
                                                'cardholderName' => $card_name,
                                                'expirationDate' => $expirationDate,
                                                'cvv' => $cvv
                                            ),
                                            'options' => 
                                            [
                                                'submitForSettlement' => True
                                            ]
                                        ));  
				
			if($payment_result->success)
			{	
				// $grand_total = $subtotal - $EquiRedeem ;
				$gained_points_fag = 0;
				$trans_lp_id=0;
				
				$cid = $CardId = $data["Enroll_details"] -> Card_id;
				$Company_id = $data["Enroll_details"] ->Company_id;
				$Cust_redeem_point = $Redeem_points;			
				$CardId = $data["Enroll_details"] -> Card_id;
				$User_email_id = $data["Enroll_details"] -> User_email_id;
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
				$Cust_country_id = $data["Enroll_details"] ->Country_id;			
				$Cust_name = $fname.''.$lname; 	
				
				/******************Get Supper Seller Details*********************/		
				
				$Super_seller_flag = 1;
				$result = $this->Customer_Api_model->Get_Seller($Super_seller_flag,$Company_id);
					   
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
						
				$Trans_type = 12;
				$Payment_type_id = 5;
				$Remarks = "E_commerce_API Online Purchase Transaction";
				
		/*************************Get Supper Seller Loyalty Rule******************************/
		
				$loyalty_prog = $this->Customer_Api_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id);
							
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
											
							$lp_details = $this->Customer_Api_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);	
						
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
										   
												
								if($i<count($value)-1 && $value[$i+1] != "") 
								{
									if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
									{
										$loyalty_points = $this->Customer_Api_model->get_discount($transaction_amt,$dis[$i]);
															
										$trans_lp_id = $LoyaltyID_array[$i];
										$Applied_loyalty_id[]=$trans_lp_id;
										$gained_points_fag = 1;
										$points_array[] = $loyalty_points;							
									}
								}
								else if($transaction_amt > $value[$i])
								{
									$loyalty_points = $this->Customer_Api_model->get_discount($transaction_amt,$dis[$i]);
															
									$gained_points_fag = 1;
									$trans_lp_id = $LoyaltyID_array[$i];
									$Applied_loyalty_id[]=$trans_lp_id;					
									$points_array[] = $loyalty_points;						
								}
							}
						}
									
						if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
						{					
							$loyalty_points = $this->Customer_Api_model->get_discount($transaction_amt,$dis[0]);
							$points_array[] = $loyalty_points;
							$gained_points_fag = 1;
							$trans_lp_id = $LoyaltyID_array[0];
							$Applied_loyalty_id[]=$trans_lp_id;
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
				}
				else
				{
					$total_loyalty_points = 0;
				}
							
				$Customer_enroll_id = $cust_enrollment_id;
				
				if ($Product_details != "")
				{
					foreach($Product_details as $productinfo)
					{
						$item_id = $productinfo["Item_code"];
						$item_qty = $productinfo["Quantity"];  
						$item_rate = $productinfo["Total_price"];  
						
						
						/*******************Get Merchandize item name*******************/	
						$result = $this->Customer_Api_model->Get_merchandize_item($item_id,$Company_id);
						$Company_merchandize_item_code = $result->Company_merchandize_item_code;
						$Merchandize_item_name = $result->Merchandize_item_name;
						
						/****************************************************************/
						$characters = 'A123B56C89';
						$string = '';
						$Voucher_no="";
						for ($i = 0; $i < 16; $i++) 
						{
							$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
						}
						/******************************************************************/
						$Voucher_status = 'Ordered';
						$item_total_amount = $item_qty * $item_rate;
						$total_loyalty_points1 = round($total_loyalty_points);
						$Weighted_loyalty_points = round($total_loyalty_points * $item_total_amount) / $subtotal;
						$Weighted_redeem_points = round($Cust_redeem_point * $item_total_amount) / $subtotal;
						$Purchase_amount = $item_qty * $item_rate;
						$Balance_to_pay = round($grand_total * $Purchase_amount ) / $subtotal;
						
						$data123 = array('Company_id' => $Company_id,
									'Trans_type' => $Trans_type,
									'Purchase_amount' => $Purchase_amount,
									'Paid_amount' => $Balance_to_pay,
									'Payment_type_id' => $Payment_type_id,
									'Remarks' => $Remarks,
									'Trans_date' => $lv_date_time,
									'balance_to_pay' => $Balance_to_pay,
									'Enrollement_id' => $cust_enrollment_id,
									'Bill_no' => $bill,
									'Voucher_no' => $Voucher_no,
									'Card_id' => $CardId,
									'Seller' => $seller_id,
									'Seller_name' => $seller_name,
									'Item_code' => $Company_merchandize_item_code,
									'Voucher_status' => $Voucher_status,
									'Merchandize_Partner_id' => 0,
									'Quantity' => $item_qty,
									'Loyalty_pts' => $Weighted_loyalty_points,
									'Online_payment_method' => $Payment,
									'Redeem_points' => $Weighted_redeem_points		
						);	
						$Transaction_detail = $this->Customer_Api_model->Insert_online_purchase_transaction($data123);
						
						// $bill_no = $bill + 1;
						// $billno_withyear = $str.$bill_no;
						// $result4 = $this->Customer_Api_model->update_billno($seller_id,$billno_withyear);
						//$Child_Weighted_loyalty_points = ($Weighted_loyalty_points) / count($Applied_loyalty_id);
						
						$loyalty_prog = $this->Customer_Api_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id);
							
						// $points_array = array();
						
						$lp_count = count($loyalty_prog);
						
						if(count($Applied_loyalty_id) != 0)
						{		
							for($l=0;$l<count($Applied_loyalty_id);$l++)
							{
							
							$Get_loyalty = $this->Customer_Api_model->Get_loyalty_details_for_online_purchase($Applied_loyalty_id[$l]);
							 
								foreach($Get_loyalty as $rec)
								{
									$Loyalty_at_transaction = $rec['Loyalty_at_transaction'];
									$lp_type=substr($rec['Loyalty_name'],0,2);	
									$discount = $rec['discount'];
									 
									if($lp_type == 'PA')
									{		
										if($Loyalty_at_transaction != 0.00)
										{
											$Calc_rewards_points=round(($Purchase_amount*$Loyalty_at_transaction)/100);
										}
										else
										{
											$Calc_rewards_points=round(($Purchase_amount*$discount)/100);
										}
									}		
									if($lp_type == 'BA')
									{	
										if($Loyalty_at_transaction != 0.00)
										{
											$Calc_rewards_points=round(($Balance_to_pay*$Loyalty_at_transaction)/100);
										}
										else
										{
											$Calc_rewards_points=round(($Purchase_amount*$discount)/100);
										}
									}
								}
								$child_data = array(					
										'Company_id' => $Company_id,        
										'Transaction_date' => $lv_date_time,       
										'Seller' => $seller_id,
										'Enrollement_id' => $cust_enrollment_id,
										'Transaction_id' => $Transaction_detail,
										// 'Loyalty_id' => $trans_lp_id,
										'Loyalty_id' => $Applied_loyalty_id[$l], 									
										'Reward_points' => $Calc_rewards_points,
										);
							$child_result = $this->Customer_Api_model->insert_loyalty_transaction_child($child_data);
							}
						}	
							// $cart = $this->session->userdata('shopping_cart');
							// if(empty($cart))

							if(empty($item_id))
							{
								redirect('Customer_Api'); 
							}
							else
							{
								// $this->load->vars('cart', $cart);			
								$Order_date = date('Y-m-d');
								$Cust_country = $this->Customer_Api_model->get_dial_code($Cust_country_id );
								$Cust_country_name = $Cust_country->Country_name;
								$Dial_code = $Cust_country->Dial_code;
								$contact_no = $Dial_code.''.$contact;
								// $Cust_country_name="India";
								
								$shipping_details = array
												(
												'Transaction_date' => $Order_date,
												'Enrollment_id' => $cust_enrollment_id,
												'Cust_name' => $Cust_name,
												'Cust_address' => $Shipping_address,
												'Cust_city' => $city,
												'Cust_zip' => $zip,
												'Cust_state' => $state,
												'Cust_country' => $Cust_country_name,
												'Cust_phnno' => $contact_no,
												'Cust_email' => $User_email_id,
												'Transaction_id' => $Transaction_detail,
												'Company_id' => $Company_id
												);
								$shipping_details = $this->Customer_Api_model->insert_shipping_details($shipping_details);
							}
							
					} //foreach
				} 
			/************************* Update Current Balance ************************************/
														
				$cid = $CardId;				
				$redeem_point = $Cust_redeem_point;
				//$point_redeem = $Current_balance - $redeem_point + $loyalty_pts; 
				$Update_Current_balance = ($bal - $redeem_point + $total_loyalty_points1);
				
				$up = array('Current_balance' => $Update_Current_balance);
				
				$this->Customer_Api_model->update_transaction($up,$cid,$Company_id);
								
					 $bill_no = $bill + 1;
					 $billno_withyear = $str.$bill_no;
					 $result4 = $this->Customer_Api_model->update_billno($seller_id,$billno_withyear);
					
					if($shipping_details > 0)
					{
						$Result223[] = array("Error_flag" => 0, "Membership_id" => $Membership_Id, "Trans_date" => $lv_date_time, "Bill_no" => $bill, "Purchase_amount" => $subtotal, "Redeem_points" => $Redeem_points, "Equivalent_redeem_amount" => $EquiRedeem, "Balance_to_pay" => $grand_total, "Gained_loyalty_Points" => $total_loyalty_points1, "Current_balance" => $Update_Current_balance, "Order_status" => $Voucher_status, "Payment_option" => "BrainTree");
						$this->output->set_output(json_encode($Result223)); 
					}	
					else
					{
						 $Result222[] = array("Error_flag" => 8);
						 $this->output->set_output(json_encode($Result222)); //Transaction Unsuccessful 
					}
			}
			else
			{
				$Result1655[] = array("Error_flag" => 10);
				$this->output->set_output(json_encode($Result1655)); //BrainTree Payment Failed Transaction Unsuccessful  
			}
		}
		else
		{
			$Result1685[] = array("Error_flag" => 9);
			$this->output->set_output(json_encode($Result1685));  // Card details is empty
		}		
		}
		if($Payment_option == 2)
		{
			$Payment = "COD";
			$grand_total = $subtotal - $EquiRedeem ;
			$gained_points_fag = 0;
			$trans_lp_id=0;
				
			$cid = $CardId = $data["Enroll_details"] -> Card_id;
			$Company_id = $data["Enroll_details"] ->Company_id;
			$Cust_redeem_point = $Redeem_points;
			$CardId = $data["Enroll_details"] -> Card_id;
			$User_email_id = $data["Enroll_details"] -> User_email_id;
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
			$Cust_country_id = $data["Enroll_details"] ->Country_id;			
			$Cust_name = $fname.''.$lname; 	
				
				/******************Get Supper Seller Details*********************/		
				
			$Super_seller_flag = 1;
			$result = $this->Customer_Api_model->Get_Seller($Super_seller_flag,$Company_id);
					   
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
						
			$Trans_type = 12;
			$Payment_type_id = 5;
			$Remarks = "E_commerce_API Online Purchase Transaction";
				
		/*************************Get Supper Seller Loyalty Rule******************************/
		
			$loyalty_prog = $this->Customer_Api_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id);
							
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
											
						$lp_details = $this->Customer_Api_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);	
						
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
										   
												
								if($i<count($value)-1 && $value[$i+1] != "") 
								{
									if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
									{
										$loyalty_points = $this->Customer_Api_model->get_discount($transaction_amt,$dis[$i]);
															
										$trans_lp_id = $LoyaltyID_array[$i];
										$Applied_loyalty_id[]=$trans_lp_id;
										$gained_points_fag = 1;
										$points_array[] = $loyalty_points;							
									}
								}
								else if($transaction_amt > $value[$i])
								{
								$loyalty_points = $this->Customer_Api_model->get_discount($transaction_amt,$dis[$i]);
															
									$gained_points_fag = 1;
									$trans_lp_id = $LoyaltyID_array[$i];
									$Applied_loyalty_id[]=$trans_lp_id;					
									$points_array[] = $loyalty_points;						
								}
							}
						}
						if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
						{					
							$loyalty_points = $this->Customer_Api_model->get_discount($transaction_amt,$dis[0]);
												
							$points_array[] = $loyalty_points;
							$gained_points_fag = 1;
							$trans_lp_id = $LoyaltyID_array[0];
							$Applied_loyalty_id[]=$trans_lp_id;
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
				}
				else
				{
					$total_loyalty_points = 0;
				}
							
				$Customer_enroll_id = $cust_enrollment_id;
				
				if ($Product_details != "")
				{
					foreach($Product_details as $productinfo)
					{
						$item_id = $productinfo["Item_code"];
						$item_qty = $productinfo["Quantity"];  
						$item_rate = $productinfo["Total_price"];  
						
						/*******************Get Merchandize item name*******************/	
						$result = $this->Customer_Api_model->Get_merchandize_item($item_id,$Company_id);
						$Company_merchandize_item_code = $result->Company_merchandize_item_code;
						$Merchandize_item_name = $result->Merchandize_item_name;
						
						/****************************************************************/
						$characters = 'A123B56C89';
						$string = '';
						$Voucher_no="";
						for ($i = 0; $i < 16; $i++) 
						{
							$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
						}
						/******************************************************************/
						$Voucher_status = 'Ordered';
						$item_total_amount = $item_qty * $item_rate;
						$total_loyalty_points1 = round($total_loyalty_points);
						$Weighted_loyalty_points = round($total_loyalty_points * $item_total_amount) / $subtotal;
						$Weighted_redeem_points = round($Cust_redeem_point * $item_total_amount) / $subtotal;
						$Purchase_amount = $item_qty * $item_rate;
						$Balance_to_pay = round($grand_total * $Purchase_amount ) / $subtotal;
						
						$data123 = array('Company_id' => $Company_id,
									'Trans_type' => $Trans_type,
									'Purchase_amount' => $Purchase_amount,
									'Paid_amount' => $Balance_to_pay,
									'Payment_type_id' => $Payment_type_id,
									'Remarks' => $Remarks,
									'Trans_date' => $lv_date_time,
									'balance_to_pay' => $Balance_to_pay,
									'Enrollement_id' => $cust_enrollment_id,
									'Bill_no' => $bill,
									'Voucher_no' => $Voucher_no,
									'Card_id' => $CardId,
									'Seller' => $seller_id,
									'Seller_name' => $seller_name,
									'Item_code' => $Company_merchandize_item_code,
									'Voucher_status' => $Voucher_status,
									'Merchandize_Partner_id' => 0,
									'Quantity' => $item_qty,
									'Loyalty_pts' => $Weighted_loyalty_points,
									'Online_payment_method' => $Payment,
									'Redeem_points' => $Weighted_redeem_points		
						);	
						$Transaction_detail = $this->Customer_Api_model->Insert_online_purchase_transaction($data123);
						
						$loyalty_prog = $this->Customer_Api_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id);
							
							// $points_array = array();
						
						$lp_count = count($loyalty_prog);
						
						if(count($Applied_loyalty_id) != 0)
						{		
							for($l=0;$l<count($Applied_loyalty_id);$l++)
							{
							
							$Get_loyalty = $this->Customer_Api_model->Get_loyalty_details_for_online_purchase($Applied_loyalty_id[$l]);
							 
								foreach($Get_loyalty as $rec)
								{
									$Loyalty_at_transaction = $rec['Loyalty_at_transaction'];
									$lp_type=substr($rec['Loyalty_name'],0,2);	
									$discount = $rec['discount'];
									 
									if($lp_type == 'PA')
									{		
										if($Loyalty_at_transaction != 0.00)
										{
											$Calc_rewards_points=round(($Purchase_amount*$Loyalty_at_transaction)/100);
										}
										else
										{
											$Calc_rewards_points=round(($Purchase_amount*$discount)/100);
										}
									}		
									if($lp_type == 'BA')
									{	
										if($Loyalty_at_transaction != 0.00)
										{
											$Calc_rewards_points=round(($Balance_to_pay*$Loyalty_at_transaction)/100);
										}
										else
										{
											$Calc_rewards_points=round(($Purchase_amount*$discount)/100);
										}
									}
								}
								$child_data = array(					
										'Company_id' => $Company_id,        
										'Transaction_date' => $lv_date_time,       
										'Seller' => $seller_id,
										'Enrollement_id' => $cust_enrollment_id,
										'Transaction_id' => $Transaction_detail,
										// 'Loyalty_id' => $trans_lp_id,
										'Loyalty_id' => $Applied_loyalty_id[$l], 							'Reward_points' => $Calc_rewards_points
										);
									
								$child_result = $this->Customer_Api_model->insert_loyalty_transaction_child($child_data);
							}
						}	
							// $cart = $this->session->userdata('shopping_cart');
							// if(empty($cart))

							if(empty($item_id))
							{
								redirect('Customer_Api'); 
							}
							else
							{
								// $this->load->vars('cart', $cart);			
								$Order_date = date('Y-m-d');
								$Cust_country = $this->Customer_Api_model->get_dial_code($Cust_country_id );
								$Cust_country_name = $Cust_country->Country_name;
								$Dial_code = $Cust_country->Dial_code;
								$contact_no = $Dial_code.''.$contact;
								// $Cust_country_name="India";
								
								$shipping_details = array
								(
									'Transaction_date' => $Order_date,
									'Enrollment_id' => $cust_enrollment_id,
									'Cust_name' => $Cust_name,
									'Cust_address' => $Shipping_address,
									'Cust_city' => $city,
									'Cust_zip' => $zip,
									'Cust_state' => $state,
									'Cust_country' => $Cust_country_name,
									'Cust_phnno' => $contact_no,
									'Cust_email' => $User_email_id,
									'Transaction_id' => $Transaction_detail,
									'Company_id' => $Company_id
								);
						      
							$shipping_details = $this->Customer_Api_model->insert_shipping_details($shipping_details);
							}
							
					} //foreach
				} 
			/************************* Update Current Balance ************************************/
														
				$cid = $CardId;				
				$redeem_point = $Cust_redeem_point;
				//$point_redeem = $Current_balance - $redeem_point + $loyalty_pts; 
				$Update_Current_balance = ($bal - $redeem_point + $total_loyalty_points1);
				
				$up = array('Current_balance' => $Update_Current_balance);
				
				$this->Customer_Api_model->update_transaction($up,$cid,$Company_id);
								
					$bill_no = $bill + 1;
					$billno_withyear = $str.$bill_no;
					$result4 = $this->Customer_Api_model->update_billno($seller_id,$billno_withyear);
					
					if($shipping_details > 0)
					{
						$Result223[] = array("Error_flag" => 0, "Membership_id" => $Membership_Id, "Trans_date" =>$lv_date_time, "Bill_no" => $bill, "Purchase_amount" => $subtotal, "Redeem_points" => $Redeem_points, "Equivalent_redeem_amount" => $EquiRedeem, "Balance_to_pay" => $grand_total, "Gained_loyalty_Points" => $total_loyalty_points1, "Current_balance" => $Update_Current_balance, "Order_status" => $Voucher_status);
						$this->output->set_output(json_encode($Result223)); 
					}	
					else
					{
						$Result222[] = array("Error_flag" => 8);
						$this->output->set_output(json_encode($Result222)); //Transaction Unsuccessful 
					}
		   
		}
		}
		}
		}
		else
		{
		    $Result178[] = array("Error_flag" => 6);
			$this->output->set_output(json_encode($Result178));  // Shipping Address is Empty
		}
		}
		else
		{
			$Result187[] = array("Error_flag" => 5);
			$this->output->set_output(json_encode($Result187)); // provide invalid product details
		}
		}
		else
		{
		   $Result1221[] = array("Error_flag" => 7);
			$this->output->set_output(json_encode($Result1221)); // empty product details array
		}
		}
		else    
		{
			$Result1277[] = array("Error_flag" => 2);
			$this->output->set_output(json_encode($Result1277)); // Invalid Card_Id / Membership_id / phone_no
		}
		}
		else
		{
			$Result125[] = array("Error_flag" => 1); 
			$this->output->set_output(json_encode($Result125)); // Invalid Company_Key
		}
	}	
}		 		
?>