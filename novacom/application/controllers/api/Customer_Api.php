<?php 
class Customer_Api extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library('session');
		$this->load->library('Api_library');
		$this->load->library('Send_notification');
		$this->load->model('api/Customer_Api_model');
		
			
		
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
	}
		
	public function index() 
	{ 
		$this->load->view('api/igainspark_api');		
	}
	public function iGainSpark_api()
	{
		error_reporting(0);
		$API_Company_username = $_REQUEST['Company_username'];
		$API_Company_password = $_REQUEST['Company_password'];
		$API_flag = $_REQUEST['API_flag']; 
		$iv = '56666852251557009888889955123458';	

		/* echo"-------API_Company_username-------".$API_Company_username."--<br>";
		echo"-------API_Company_password-------".$API_Company_password."--<br>";
		echo"-------API_flag-------".$API_flag."--<br>";  */
		// die;
			
		if($API_Company_username == "" || $API_Company_password == "" || $API_flag == "")
		{
			echo json_encode(array("status" => "404", "status_message" => "Missing Company Username Information"));
		}
		else
		{
			/*------------Check Company Exist------------------*/
				$Check_company_exist = $this->Igain_model->Check_compnay_by_username($API_Company_username);				
			/*------------Check Company Exist------------------*/
			
			if($Check_company_exist > 0)
			{
				
				$Company_id = $Check_company_exist->Company_id;
				$Allow_merchant_pin = $Check_company_exist->Allow_merchant_pin;
				$Allow_member_pin = $Check_company_exist->Pin_no_applicable;
				$Company_encryptionkey = $Check_company_exist->Company_encryptionkey;
				$DB_Company_password = $Check_company_exist->Company_password;
				$key = $Company_encryptionkey;
				$Login_Redemptionratio=$Check_company_exist->Redemptionratio;
				
							
				$Decrypt_Company_password = $this->string_decrypt($_REQUEST['Company_password'], $key, $iv);	
				$Decrypt_Company_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Decrypt_Company_password);
				
				$Password_match = strcmp($DB_Company_password,$Decrypt_Company_password);
				
				// echo"-------Check_company_exist-------".$Check_company_exist."--<br>";
				// echo"-------Company_id-------".$Company_id."--<br>";
				// echo"-------Company_encryptionkey-------".$Company_encryptionkey."--<br>";
				// echo"-------DB_Company_password-------".$DB_Company_password."--<br>";				
				// echo"-------Company_password-------".$_REQUEST['Company_password']."--<br>";
				// echo"-------Decrypt_Company_password-------".$Decrypt_Company_password."--<br>";				
				//echo"-------Password_match-------".$Password_match."--<br>";
				
				if($Password_match == 0)
				{
					
					$API_flag2 = $this->string_decrypt($_REQUEST['API_flag'], $key, $iv);
					$API_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $API_flag2);				
					
					// echo"-------API_flag-------".$API_flag."--<br>";
					
					/************************************Profile Details********************************/
                    if($API_flag == 23)  //***Retrive the profile details of customer
                    {
						 // echo"-------API_flag-------".$API_flag."--<br>";
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
							
							
                           $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);							

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									$Tier_name = $this->api_library->get_tier_name($Check_member_exist->Tier_id);   
									
									$Country_name = $this->api_library->get_dial_code($Check_member_exist->Country_id);                                  
									$Total_gained_points = $this->api_library->Total_gained_points($Company_id,$Check_member_exist->Enrollement_id);   
									
									$Photograph =$this->config->item('base_url2').''.$Check_member_exist->Photograph;
									
									$member_details = array(
											"status" => "1001",
											"First_name" => $this->string_encrypt($Check_member_exist->First_name,$key, $iv),
											"Middle_name" => $this->string_encrypt($Check_member_exist->Middle_name,$key, $iv),
											"Last_name" => $this->string_encrypt($Check_member_exist->Last_name,$key, $iv),
											"Current_address" => $this->string_encrypt($Check_member_exist->Current_address,$key, $iv),
											"Zipcode" => $this->string_encrypt($Check_member_exist->Zipcode,$key, $iv),
											"Country_name" =>$this->string_encrypt($Country_name,$key, $iv),
											"State_name" => $this->string_encrypt($Check_member_exist->State,$key, $iv),
											"District_name" => $this->string_encrypt($Check_member_exist->District,$key, $iv),
											"City_name" => $this->string_encrypt($Check_member_exist->City,$key, $iv),
											"Photograph" => $Photograph,
											"Phone_no" => $this->string_encrypt($Check_member_exist->Phone_no,$key, $iv),
											"Date_of_birth" => $this->string_encrypt($Check_member_exist->Date_of_birth,$key, $iv),
											"Age" => $this->string_encrypt($Check_member_exist->Age,$key, $iv),
											"Sex" => $this->string_encrypt($Check_member_exist->Sex,$key, $iv),
											"User_email_id" => $this->string_encrypt($Check_member_exist->User_email_id,$key, $iv),
											"Current_balance" => $this->string_encrypt($Check_member_exist->Current_balance,$key, $iv),
											"Total_purchase_amount" => $this->string_encrypt($Check_member_exist->total_purchase,$key, $iv),
											"Total_bonus_points" => $this->string_encrypt($Check_member_exist->Total_topup_amt,$key, $iv),
											"Total_gained_points" => $this->string_encrypt($Total_gained_points,$key, $iv),
											"Tier_name" => $this->string_encrypt($Tier_name,$key, $iv),
											"Blocked_points" => $this->string_encrypt($Check_member_exist->Blocked_points,$key, $iv),"Enroll_date" => $this->string_encrypt($Check_member_exist->joined_date,$key, $iv),
											"status_message" => "Success"
										);
										
										echo json_encode($member_details);
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Profile Details********************************/
										
					/************************************Login********************************/
                    if($API_flag == 21)  //***login and return customer details
                    {
						
                        if($_REQUEST['Membership_id'] == "" || $_REQUEST['Cust_password'] == "")
                        {
                            echo json_encode(array("status" => "2007", "status_message" => "Kindly Enter Username or Password"));
                        }
                        else
                        {
							$flag=1;
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
                            
                            $Cust_password = trim($this->string_decrypt($_REQUEST['Cust_password'], $key, $iv));
                            $Cust_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Cust_password);
							
							$Cust_username = trim($this->string_decrypt($_REQUEST['Cust_username'], $key, $iv));
                            $Cust_username = preg_replace("/[^(\x20-\x7f)]*/s", "", $Cust_username);                            
                           
							$member_login_details = $this->api_library->customer_login($Cust_username,$Cust_password,$Company_id,$flag);
							
							if($member_login_details == NULL)
                            {
                                echo json_encode(array("status" => "2005", "status_message" => "Username or Password is Incorrect"));
                            }							
                            else
                            {
								if($Check_member_exist->User_activated==0)
								{
									 echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
								}
                                else
                                {
									$Tier_name = $this->api_library->get_tier_name($Check_member_exist->Tier_id);									
									$member_details = array(
										"status" => "1001",
										"First_name" => ($this->string_encrypt($Check_member_exist->First_name,$key, $iv)),
										"Middle_name" => ($this->string_encrypt($Check_member_exist->Middle_name,$key, $iv)),
										"Last_name" => ($this->string_encrypt($Check_member_exist->Last_name,$key, $iv)),
										"Tier_name" => ($this->string_encrypt($Tier_name,$key, $iv)),
										"Membership_id" => ($this->string_encrypt($Check_member_exist->Card_id,$key, $iv)),
										"Current_balance" => ($this->string_encrypt($Check_member_exist->Current_balance,$key, $iv)),
										"Total_unread_notifications" => ($this->string_encrypt(10,$key, $iv)),
										"status_message" => "Success"
									);
									echo json_encode($member_details);					
                                }
                                
                            }
                        }
                    }
                    /************************************Login********************************/
					
                    /************************************Forgot Password********************************/					
					if($API_flag == 26)                     
					{
						
						if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);

                            $User_email_id = trim($this->string_decrypt($_REQUEST['User_email_id'], $key, $iv));
                            $User_email_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $User_email_id); 
							// echo"-------User_email_id-------".$User_email_id."--<br>";
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
							
                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($Check_member_exist->User_activated==0)
								{
									 echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
								}
                                else
                                {
									
                                    
									$CheckEmailID = $this->api_library->Check_EmailID($User_email_id,$Company_id);
									if($CheckEmailID =="")
									{
										echo json_encode(array("status" => "2009", "status_message" => "Invalid User Email ID"));
									}
									else
									{	
										$ForgotPassword = $this->api_library->forgot_password($User_email_id,$Company_id);
										echo json_encode(array("status" => "1001", "status_message" => "Success"));
										
									}
                                    
                                }
                            }
                        }
                    }
                    /************************************Forgot Password********************************/
					
					/************************************Change Password********************************/
                    if($API_flag == 25)
                    {
						// echo"-------Change Password--<br>";
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else if($_REQUEST['Old_password'] == "" || $_REQUEST['New_password'] == "")
                        {
                            echo json_encode(array("status" => "2010", "status_message" => "Kindly Enter Password"));
                        }
                        else
                        {
							
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $Old_password = trim($this->string_decrypt($_REQUEST['Old_password'], $key, $iv));
                            $Old_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $Old_password);
                            
                            $New_password = trim($this->string_decrypt($_REQUEST['New_password'], $key, $iv));
                            $New_password = preg_replace("/[^(\x20-\x7f)]*/s", "", $New_password);

                           
                            
                            $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }							
                            else
                            {
								/* echo"-------Old_password-------".$Old_password."--<br>";
								echo"-------New_password-------".$New_password."--<br>";
								echo"-------User_pwd-------".$Check_member_exist->User_pwd."--<br>"; */
								
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else if($Check_member_exist->User_pwd != $Old_password)
                                {
                                    echo json_encode(array("status" => "2011", "status_message" => "Passwords Do Not Match"));
                                }
								else if($Check_member_exist->User_pwd == $New_password)
                                {
                                    echo json_encode(array("status" => "3015", "status_message" => "Old Password and New Password are Same"));
                                }
                                else
                                {                                   
																		
                                    $ChangePassword = $this->api_library->change_password($Old_password,$Company_id,$Check_member_exist->Enrollement_id,$New_password);									
									echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Change Password********************************/
										
					/************************************Resend Customer Pin********************************/
                    if($API_flag == 27) 
                    {
						
                       if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {    
									$ResendPin=$this->api_library->Resend_pin($Company_id,$Check_member_exist->Enrollement_id);
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Resend Pin********************************/
					
					/************************************Hobbies Details********************************/
                    if($API_flag == 29)  //***Retrive the Hobbies details of customer
                    {
						 // echo"-------API_flag-------".$API_flag."--<br>";
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									$All_hobbies_details= $this->api_library->get_all_hobbies_details();
									$Hobbies_interest = $this->api_library->Fetch_hobbies($Check_member_exist->Enrollement_id,$Company_id); 
										
									$Hobbie_array= array();
									foreach($Hobbies_interest as $hobbies) 
									{ 
										$Hobbie_array[]=$hobbies['Hobbie_id'];
									}
									foreach($All_hobbies_details as $alhobe )
									{									
											if(in_array( $alhobe['Id'],$Hobbie_array))
											{
												$Hobbies_details[] = array(
																'Hobbie_id' => $this->string_encrypt($alhobe['Id'],$key, $iv),
																// 'Hobbie_id' =>$alhobe['Id'],
																'Hobbies' => $this->string_encrypt($alhobe['Hobbies'],$key, $iv),
																// 'Hobbies' => $alhobe['Hobbies'],
																'Checked' => 1
																);
																
											}
											else
											{
												$Hobbies_details[] = array(
																'Hobbie_id' => $this->string_encrypt($alhobe['Id'],$key, $iv),
																// 'Hobbie_id' =>$alhobe['Id'],
																'Hobbies' => $this->string_encrypt($alhobe['Hobbies'],$key, $iv)
																// 'Hobbies' => $alhobe['Hobbies']
																);
											}
									}
									if($Hobbies_details != NULL)
									{
										$Status_array = array("status" => "1001", "Hobbies_details" => $Hobbies_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Hobbies Details********************************/
					
					/************************************ Update Hobbies********************************/
                    if($API_flag == 30)  //***Update Hobbies of customer
                    {
						 // echo"-------API_flag-------".$API_flag."--<br>";
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
										
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									// print_r($_REQUEST);
									// echo"-------*************-------<br><br>";
									if(empty($_REQUEST['Update_hobbies']))
									{
										 echo json_encode(array("status" => "3042", "status_message" => "Hobbies are Blank")); die;
									}
									else
									{
										$result = $this->api_library->delete_hobbies($Company_id,$Check_member_exist->Enrollement_id);
										foreach($_REQUEST['Update_hobbies'] as $updt_hobbies)
										{
											$updt_hobbies1 = trim($this->string_decrypt($updt_hobbies, $key, $iv));
											$updt_hobbies = preg_replace("/[^(\x20-\x7f)]*/s", "", $updt_hobbies1);
											// echo"---updt_hobbies---".$updt_hobbies."---<br>";
											$Insert_hobbies = $this->api_library->insert_hobbies($Company_id,$Check_member_exist->Enrollement_id,$updt_hobbies);
											
										}										
										if($Insert_hobbies != NULL)
										{
											echo json_encode(array("status" => "1001", "status_message" => "Success"));
										}
										else
										{
											echo json_encode(array("status" => "3042", "status_message" => "Hobbies are Blank"));
										}
									}	
									
									
									
									
									
									
									
									/* $result = $this->Igain_model->delete_hobbies($Company_id,$Enrollment_id);
									foreach($new_hobbies as $hobbis)
									{
											
										$result12 = $this->Igain_model->insert_hobbies($Company_id,$Enrollment_id,$hobbis);
									} */
									
									/* $All_hobbies_details= $this->api_library->get_all_hobbies_details();
									$Hobbies_interest = $this->api_library->Fetch_hobbies($Check_member_exist->Enrollement_id,$Company_id); 
										
									$Hobbie_array= array();
									foreach($Hobbies_interest as $hobbies) 
									{ 
										$Hobbie_array[]=$hobbies['Hobbie_id'];
									}
									foreach($All_hobbies_details as $alhobe )
									{									
											if(in_array( $alhobe['Id'],$Hobbie_array))
											{
												$Hobbies_details[] = array(
																// 'Hobbie_id' => $this->string_encrypt($Hobbies->Hobbie_id,$key, $iv),
																'Hobbie_id' =>$alhobe['Id'],
																// 'Hobbies' => $this->string_encrypt($Hobbies->Hobbies,$key, $iv)
																'Hobbies' => $alhobe['Hobbies'],
																'Checked' => 1
																);
																
											}
											else
											{
												$Hobbies_details[] = array(
																// 'Hobbie_id' => $this->string_encrypt($Hobbies->Hobbie_id,$key, $iv),
																'Hobbie_id' =>$alhobe['Id'],
																// 'Hobbies' => $this->string_encrypt($Hobbies->Hobbies,$key, $iv)
																'Hobbies' => $alhobe['Hobbies']
																);
											}
									}
									if($Hobbies_details != NULL)
									{
										$Status_array = array("status" => "1001", "Hobbies_details" => $Hobbies_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									} */
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Update Hobbies********************************/
										
					/************************************Transfer Points********************************/					
					if($API_flag == 31)  //***validate Transfer to membership id and retrieve the details
                    {
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							
							
                            $Transfer_membershipid = trim($this->string_decrypt($_REQUEST['Transfer_membershipid'], $key, $iv)); $Transfer_membershipid = preg_replace("/[^(\x20-\x7f)]*/s", "", $Transfer_membershipid);
							
							$Check_Transfer_member_exist = $this->Igain_model->get_customer_details($Transfer_membershipid,$Company_id);
							
							$Allow_merchant_pin = $Check_company_exist->Allow_merchant_pin;
							$Allow_member_pin = $Check_company_exist->Pin_no_applicable;
                            
                            if($Check_member_exist == NULL)
                            {
                                 echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Transfer_membershipid == "")
                                    {
                                        echo json_encode(array("status" => "2016", "status_message" => "Kindly Enter the Membership ID you want to Transfer to"));
                                    }
                                    else if($Transfer_membershipid == $Membership_id)
                                    {
                                        echo json_encode(array("status" => "2017-1", "status_message" => "Transfer Membership ID Number Not Found"));
                                    }                                    
                                    else
                                    {
                                        $New_current_bal = $Check_member_exist->Current_balance - $Check_member_exist->Blocked_points;
                                        
										if($Check_Transfer_member_exist > 0)
                                        {
											
											/* 
											echo"-------New_current_bal-------".$New_current_bal."--<br>";
											echo"-------First_name-------".$Check_Transfer_member_exist->First_name."--<br>";
											echo"-------Last_name-------".$Check_Transfer_member_exist->Last_name."--<br>";
											echo"-------Phone_no-------".$Check_Transfer_member_exist->Phone_no."--<br>";
											echo"-------Card_id-------".$Check_Transfer_member_exist->Card_id."--<br>"; */
											 
                                            $Transfer_to_details = array(
                                                            "status" => "1001",
                                                            "First_name" => $this->string_encrypt($Check_Transfer_member_exist->First_name,$key, $iv),
                                                            "Last_name" => $this->string_encrypt($Check_Transfer_member_exist->Last_name,$key, $iv),
                                                            "Phone_no" => $this->string_encrypt($Check_Transfer_member_exist->Phone_no,$key, $iv),
                                                            "Membership_id" => $this->string_encrypt($Check_Transfer_member_exist->Card_id,$key, $iv),
                                                            "Current_balance" => $this->string_encrypt($New_current_bal,$key, $iv),
                                                            "Cust_pin_validation" => $Allow_member_pin,
                                                            "status_message" => "Success"
                                            );
                                            echo json_encode($Transfer_to_details);
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }

					/************************************Get Merchant Capaign********************************/
                    if($API_flag == 33)  //***Merchant Campaign
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									
									
									$SellerCampaign = $this->api_library->Fetch_Seller_Campaign($Company_id);
									foreach($SellerCampaign as $cmpofr)
									{
										$Campaign_details[]= array(
											"status" => "1001",
											"Full_name" =>$cmpofr['First_name'].' '.$cmpofr['Last_name'],
											"Cmpaign_name" =>$cmpofr['Loyalty_name'],
											"From_date" =>$cmpofr['From_date'],
											"Till_date" =>$cmpofr['Till_date'],
											"Loyalty_at_transaction" =>$cmpofr['Loyalty_at_transaction'],
											"Loyalty_at_value" =>$cmpofr['Loyalty_at_value'],
											"discount" =>$cmpofr['discount'],
											
											"status_message" => "Success"
										);
									}									
									// print_r($Campaign_details);									
									if($Campaign_details != NULL)
									{
										$Status_array = array("status" => "1001", "Campaign_details" => $Campaign_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Get Merchant Capaign********************************/
					
					/************************************Get Merchant Refferal Capaign********************************/
                    if($API_flag == 34)  //***Merchant Refferal Campaign
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									
									
									$SellerRefferalCampaign = $this->api_library->Fetch_Seller_referral_Campaign($Company_id);
									// print_r($SellerRefferalCampaign);
									foreach($SellerRefferalCampaign as $cmpreff)
									{
										if($cmpreff['Referral_rule_for'] == 1 )
										{
											$Referral_rule_for='Enrollment';
										}
										if($cmpreff['Referral_rule_for'] == 2 )
										{
											$Referral_rule_for='Transaction';
										}
										$CampaignRefferal_details[]= array(
											"status" => "1001",
											"Full_name" =>$cmpreff['First_name'].' '.$cmpreff['Last_name'],
											"From_date" =>$cmpreff['From_date'],
											"Till_date" =>$cmpreff['Till_date'],
											"Customer_topup" =>$cmpreff['Customer_topup'],
											"Refree_topup" =>$cmpreff['Refree_topup'],
											"Referral_rule_for" =>$Referral_rule_for,
											"status_message" => "Success"
										);
									}									
									// print_r($CampaignRefferal_details);									
									if($CampaignRefferal_details != NULL)
									{
										$Status_array = array("status" => "1001", "CampaignRefferal_details" => $CampaignRefferal_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Get Merchant Refferal Capaign********************************/
					
					/************************************Get Merchant Communication ********************************/
                    if($API_flag == 35)  //***Merchant Communication
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									
									
									$SellerCommunication = $this->api_library->Fetch_seller_communication($Company_id,$Check_member_exist->Enrollement_id);
									//print_r($SellerCommunication);									
									foreach($SellerCommunication as $comm)
									{
										
										$Communication_details[]= array(
											"status" => "1001",
											"Full_name" =>$comm['First_name'].' '.$comm['Last_name'],
											"User_email_id" =>$comm['User_email_id'],
											"Offer" =>$comm['Offer'],
											"Offer_description" =>$comm['Offer_description'],
											"Date" =>$comm['Date'],
											"status_message" => "Success"
										);
									}									
									// print_r($Communication_details);									
									if($Communication_details != NULL)
									{
										$Status_array = array("status" => "1001", "Communication_details" => $Communication_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Get Merchant Communication ********************************/
                    
					/************************************ DO Transfer points********************************/
                    if($API_flag == 36)  //***Transfer points
                    {						
                        if($_REQUEST['Membership_id'] != "")
                        {
							$Today_date = date("Y-m-d H:i:s");
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
                            $Transfer_to_membershipid1 = trim($this->string_decrypt($_REQUEST['Transfer_to_membershipid'], $key, $iv));
							$Transfer_to_membershipid = preg_replace("/[^(\x20-\x7f)]*/s", "", $Transfer_to_membershipid1);
							
                            $points_to_transfer1 = trim($this->string_decrypt($_REQUEST['points_to_transfer'], $key, $iv));
							$points_to_transfer = preg_replace("/[^(\x20-\x7f)]*/s", "", $points_to_transfer1);
                            
							$pin_no1 = trim($this->string_decrypt($_REQUEST['pin_no'], $key, $iv));                           
                            $pin_no = preg_replace("/[^(\x20-\x7f)]*/s", "", $pin_no1);
                            
                            $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
                            $Current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
                            
							
							$Transferto_member_details = $this->Igain_model->get_customer_details($Transfer_to_membershipid,$Company_id);
							$Enrollment_id = $Transferto_member_details->Enrollement_id;
                            $Transferto_Current_balance = $Transferto_member_details->Current_balance-$Transferto_member_details->Blocked_points;
							
							                            
							$Allow_merchant_pin = $Check_company_exist->Allow_merchant_pin;
							$Allow_member_pin = $Check_company_exist->Pin_no_applicable;
							
                            $Cust_pin_validation = $Allow_member_pin;
							
                                                        
                            if($Check_member_exist == NULL)
                            {
                                 echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Transfer_to_membershipid == "")
                                    {
                                        echo json_encode(array("status" => "2016", "status_message" => "Kindly Enter the Membership ID you want to Transfer to"));
                                    }
                                    else if($Transfer_to_membershipid == $Membership_id)
                                    {
                                        echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                    }
                                    else if($points_to_transfer == "" || $points_to_transfer == 0 || $points_to_transfer < 0)
                                    {
										// echo"-------points_to_transfer--1-----".$points_to_transfer."--<br>";
                                        echo json_encode(array("status" => "2018", "status_message" => "Invalid Transfer Points Entered"));die;
                                    }
                                    else if( is_numeric($points_to_transfer) && ( floor($points_to_transfer) != $points_to_transfer ) )
                                    {
										// echo"-------points_to_transfer--2-----".$points_to_transfer."--<br>";
                                        echo json_encode(array("status" => "2018", "status_message" => "Invalid Transfer Points Entered"));die;
                                    }
                                    else if($points_to_transfer > $Current_balance)
                                    {
                                        echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
                                    }
                                    else if( ($Cust_pin_validation == 1) && ($pin_no == "" || $pin_no != $member_details['Pin']) )
                                    {
                                        echo json_encode(array("status" => "2025", "status_message" => "Incorrect PIN"));
                                    }
									else
                                    {
                                                                    
                                        if($Transferto_member_details > 0)
                                        {
											
											
                                            /**************************Apply Promocode********************************/ 
												$result = $this->api_library->transfer_points($Company_id,$Check_member_exist->Enrollement_id,$Check_member_exist->Card_id,$Transferto_member_details->Enrollement_id,$Transferto_member_details->Card_id,$points_to_transfer);
												 
												 
												 
												$Check_member = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
												$Current_balance = $Check_member->Current_balance;
												 
												 
												 $status_message = "Transfer successful ".$points_to_transfer." points transferred";
												echo json_encode(array("status" => "1001", "Current_balance" => $Current_balance, "status_message" => $status_message, "status_message" => "Success"));
												 
											/**************************Apply Promocode********************************/
                                        }
                                        else
                                        {
                                            echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************ DO Transfer points********************************/	
					
					/************************************Update Profile********************************/
                    if($API_flag == 24)  //***Update Customer Profile
                    {
						// echo"---Update Profile---";
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                        else
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
							$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);

                            $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						
							// echo"----Check_member_exist----".$Check_member_exist."----<br>";						
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($Check_member_exist->User_activated==0)
								{
									 echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
								}
                                else
                                {
									
									$Enrollment_id=$Check_member_exist->Enrollement_id;
                                    $Update_profile_array = $_REQUEST['Update_profile'];
                                    $Array_count = COUNT($Update_profile_array);
                                    // var_dump($Update_profile_array);
                                    if($Array_count > 0)
                                    {
                                       
										 // echo"----Enrollment_id----".$Enrollment_id."----<br>";	
										$Company_Details= $this->Igain_model->get_company_details($Company_id);
										$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
										$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
										$seller_id=$Super_Seller_details->Enrollement_id;
										
										$timezone_entry=$Super_Seller_details->timezone_entry;										
										$logtimezone = $timezone_entry;
										$timezone = new DateTimeZone($logtimezone);
										$date = new DateTime();
										$date->setTimezone($timezone);
										$lv_date_time=$date->format('Y-m-d H:i:s');
										$Todays_date = $date->format('Y-m-d');
										
										$top_db2 = $Super_Seller_details->Topup_Bill_no;
										$len2 = strlen($top_db2);
										$str2 = substr($top_db2,0,5);
										$tp_bill2 = substr($top_db2,5,$len2);						
										$topup_BillNo2 = $tp_bill2 + 1;
										$billno_withyear_ref = $str2.$topup_BillNo2;
										
										/* $config['upload_path'] = '../uploads/'; /* NB! create this dir! 
										$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
										$config['max_size'] = '1000';
										$config['max_width'] = '1920';
										$config['max_height'] = '1280';
										  /* Load the upload library 
										$this->load->library('upload', $config);
										$configThumb = array();
										$configThumb['image_library'] = 'gd2';
										$configThumb['source_image'] = '';
										$configThumb['create_thumb'] = TRUE;
										$configThumb['maintain_ratio'] = TRUE;
										
										$configThumb['width'] = 128;
										$configThumb['height'] = 128;
										  /* Load the image library 
										$this->load->library('image_lib');
										$upload = $this->upload->do_upload('image1');
										$data = $this->upload->data();
										   
											if($data['is_image'] == 1) 
											{
												 
												$configThumb['source_image'] = $data['full_path'];
												$configThumb['source_image'] = '../uploads/'.$upload;
												$this->image_lib->initialize($configThumb);
												$this->image_lib->resize();
												$filepath='uploads/'.$data['file_name'];
											}
											else
											{
												$filepath=$Customer_details->Photograph;;
											} */							
										
										/* $post_data = array(					
												'First_name' => $this->input->post('firstName'),
												'Middle_name' => $this->input->post('middleName'),        
												'Last_name' => $this->input->post('lastName'),       
												'Current_address' => $this->input->post('currentAddress'),
												'State' => $this->input->post('state'),
												'District' => $this->input->post('district'),
												'City' => $this->input->post('city'),
												'Zipcode' => $this->input->post('zip'),
												'Country' => $this->input->post('country'),
												'Phone_no' => $phoneNo,
												'Date_of_birth' => $this->input->post('dob'),
												'Qualification' => $this->input->post('Profession'),
												'Experience' => $this->input->post('Experience'),
												'Wedding_annversary_date' => $this->input->post('Wedding_annversary_date'),
												'Married' => $this->input->post('Marital_status'),
												'Sex' => $this->input->post('Sex'),
												'Photograph' => $filepath,						
												'Country_id' => $this->input->post('country'),
												'User_email_id' => $this->input->post('userEmailId'),
												'User_pwd' => $this->input->post('Password')
										); */
										
										foreach ($Update_profile_array as $column => $value)
                                        {
											$value = trim($this->string_decrypt($value, $key, $iv));
                                            $value = preg_replace("/[^(\x20-\x7f)]*/s", "", $value);
                                            
											if($column == "Phone_no")
                                            { 
												$Dial_Code = $this->Igain_model->get_dial_code(1);
												$dialcode=$Dial_Code->Dial_code;
												$phoneNo=$dialcode.''.$value;										
                                                $data_str = "$column = '".$phoneNo."' " ;
												$Update_profile = $this->api_library->update_profile($column,$phoneNo,$Enrollment_id);
											}
											else if($column == "Date_of_birth")
                                            {
                                                $value = str_replace('/', '-', $value);
                                                $DOB = date("Y-m-d", strtotime($value));
                                                $Update_profile = $this->api_library->update_profile($column,$DOB,$Enrollment_id);
                                            }
											else if($column == "Wedding_annversary_date")
                                            {                                       
												$value = str_replace('/', '-', $value);
                                                $annversary_date = date("Y-m-d", strtotime($value));
												$Update_profile = $this->api_library->update_profile($column,$annversary_date,$Enrollment_id);												
                                            }
											else if($column == "last_visit_date")
                                            {                                  
												$value = str_replace('/', '-', $value);
                                                $last_visit_date = date("Y-m-d", strtotime($value));
                                                $Update_profile = $this->api_library->update_profile($column,$last_visit_date,$Enrollment_id);
                                            }											
											else if($column == "joined_date")
                                            {
                                                $value = str_replace('/', '-', $value);
                                                $joined_date = date("Y-m-d", strtotime($value));
                                                $Update_profile = $this->api_library->update_profile($column,$joined_date,$Enrollment_id);
                                            }
											else if($column == "Update_date")
                                            {
                                                $value = str_replace('/', '-', $value);
                                                $Update_date = date("Y-m-d", strtotime($value));
                                                $Update_profile = $this->api_library->update_profile($column,$Update_date,$Enrollment_id);
                                            }
                                            else
                                            {												
												$Update_profile = $this->api_library->update_profile($column,$value,$Enrollment_id);
											}
											
                                        }								
										echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2020", "status_message" => "Please Check Empty Fields"));
                                    }
                                }
                            }
                        }
                    }
                    /************************************Update Profile********************************/
					
					/************************************Promo Code********************************/
					if($API_flag == 37)  //***Insert and Apply Promo Code
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            $Promo_code1 = trim($this->string_decrypt($_REQUEST['Promo_code'], $key, $iv));
                            $Promo_code = preg_replace("/[^(\x20-\x7f)]*/s", "", $Promo_code1);
                            
							
							 $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
                            $Current_balance = $Check_member_exist->Current_balance;
                            
                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                               if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($Promo_code == "" || $Promo_code == "" )
                                    {
                                        echo json_encode(array("status" => "2022", "status_message" => "Kindly Enter Promo Code"));
                                    }
                                    else
                                    {
										$check_code=$this->Igain_model->check_promocode($Promo_code,$Company_id);
										$Promocode_Details=$this->Igain_model->get_promocode_details($promo_code,$Company_id);
										// echo"---check_code---".$check_code->Promo_code."<br>";
										
                                        if($check_code != "" || $check_code != 0 )
                                        {
											
											$result = $this->api_library->update_promocode($Promo_code,$Company_id,$Check_member_exist->Enrollement_id);
											
											echo json_encode(array("status" => "1001","Promo_points" => $result, "status_message" => "Success"));
										}
                                        else
                                        {
											
											$promocode_used=$this->Igain_model->check_promocode_used($Promo_code,$Company_id);
											
											// echo"---promocode_used---".$promocode_used->Promo_code."<br>";
											
                                            if($promocode_used->Promo_code != "")
                                            {
                                               echo json_encode(array("status" => "2028", "status_message" => "Promo Code Already Used"));
                                            }
											else
                                            {
                                                echo json_encode(array("status" => "2023", "status_message" => "Invalid Promo Code"));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Promo Code********************************/
					
					/************************************Contact Us********************************/
					if($API_flag == 32)  //***Contact Us
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
                            // $contact_subject1 = trim($this->string_decrypt($_REQUEST['contact_subject'], $key, $iv));
                            // $contact_subject = preg_replace("/[^(\x20-\x7f)]*/s", "", $contact_subject1);
                            $contact_subject = preg_replace("/[^(\x20-\x7f)]*/s", "",$_REQUEST['contact_subject']);
							
							$Message_details1 = trim($this->string_decrypt($_REQUEST['Message_details'], $key, $iv));
                            $Message_details = preg_replace("/[^(\x20-\x7f)]*/s", "", $Message_details1);      
							
							$call_center_flag1 = trim($this->string_decrypt($_REQUEST['call_center_flag'], $key, $iv));
                            $call_center_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $call_center_flag1);
							
							$Query_type_id1 = trim($this->string_decrypt($_REQUEST['Query_type_id'], $key, $iv));
                            $Query_type_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Query_type_id1);
							
							$Query_id1 = trim($this->string_decrypt($_REQUEST['Query_id'], $key, $iv));
                            $Query_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Query_id1);
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
                            $Current_balance = $Check_member_exist->Current_balance;
                            
                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                               if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    if($contact_subject == "" || $Message_details == "")
                                    {
                                        echo json_encode(array("status" => "3018", "status_message" => "Kindly Enter contact Subject and Message"));
                                    }
                                    else
                                    {										
																				
										$result = $this->api_library->Insert_contactus($Company_id,$Check_member_exist->Enrollement_id,$Membership_id,$contact_subject,$Message_details,$Query_type_id,$Query_id);
										
										if($result > 1)
										{
											echo json_encode(array("status" => "3041", "Ticket_no" => $result,  "status_message" => "Success"));
										}
										else
										{
											echo json_encode(array("status" => "1001","status_message" => "Success"));
										}
										
										
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
                    /************************************Contact Us********************************/
					
					/************************************Fetch All Notification********************************/
                    if($API_flag == 43)  //*** All Notification
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {	
									$All_Notification = $this->api_library->Fetch_All_notification($Check_member_exist->Enrollement_id,$Company_id);
									// print_r($All_Notification);	
									// die;
									foreach($All_Notification as $AllN)
									{
										
										$AllNotification[]= array(
											"status" => "1001",
											"Id" =>$this->string_encrypt($AllN['Id'], $key, $iv),
											"Offer" =>$this->string_encrypt($AllN['Offer'], $key, $iv),
											"Offer_description" =>$this->string_encrypt($AllN['Offer_description'], $key, $iv),
											"Date" =>$this->string_encrypt($AllN['Date'], $key, $iv),
											"status_message" => "Success"
										);
									}									
									// print_r($AllNotification);									
									if($AllNotification != NULL)
									{
										$Status_array = array("status" => "1001", "AllNotification" => $AllNotification, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Fetch All Notification********************************/
					
					/************************************Fetch All Read Notification********************************/
                    if($API_flag == 44)  //*** All Read Notification
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {	
									$AllRead_Notification = $this->api_library->Fetch_AllRead_notification($Check_member_exist->Enrollement_id,$Company_id);
									// print_r($All_Notification);	
									// die;
									foreach($AllRead_Notification as $AllN)
									{
										
										$AllReadNotification[]= array(
											"status" => "1001",
											"Id" =>$this->string_encrypt($AllN['Id'], $key, $iv),
											"Offer" =>$this->string_encrypt($AllN['Offer'], $key, $iv),
											"Offer_description" =>$this->string_encrypt($AllN['Offer_description'], $key, $iv),
											"Date" =>$this->string_encrypt($AllN['Date'], $key, $iv),
											"status_message" => "Success"
										);
									}									
									// print_r($AllNotification);									
									if($AllReadNotification != NULL)
									{
										$Status_array = array("status" => "1001", "AllReadNotification" => $AllReadNotification, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Fetch All Read Notification********************************/
					
					/************************************Fetch All Open Notification********************************/
                    if($API_flag == 45)  //*** All Open Notification
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						

                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {	
									$AllOpen_Notification = $this->api_library->Fetch_AllOpen_notification($Check_member_exist->Enrollement_id,$Company_id);
									// print_r($AllOpen_Notification);	
									// die;
									foreach($AllOpen_Notification as $AllN)
									{
										
										$AllOpenNotification[]= array(
											"status" => "1001",
											"Id" =>$this->string_encrypt($AllN['Id'], $key, $iv),
											"Offer" =>$this->string_encrypt($AllN['Offer'], $key, $iv),
											"Offer_description" =>$this->string_encrypt($AllN['Offer_description'], $key, $iv),
											"Date" =>$this->string_encrypt($AllN['Date'], $key, $iv),
											"status_message" => "Success"
										);
									}									
									// print_r($AllNotification);									
									if($AllOpenNotification != NULL)
									{
										$Status_array = array("status" => "1001", "AllOpenNotification" => $AllOpenNotification, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Fetch All Open Notification********************************/
					
					/************************************Fetch Selected Notification********************************/
                    if($API_flag == 46)  //*** Fetch Selected Notification
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);

							$Notification_id1 = trim($this->string_decrypt($_REQUEST['Notification_id'], $key, $iv));
                            $Notification_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Notification_id1);
														
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						
							
							if($Notification_id == NULL)
                            {
                                echo json_encode(array("status" => "3043", "status_message" => "Notification ID is Blank")); die;
                            }							
                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }							
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {	
									$Notification_details = $this->api_library->FetchNotifications($Notification_id);
									// var_dump();
									$Notification_details = array(
											"status" => "1001",
											"ID" => $this->string_encrypt($Notification_details->Id,$key, $iv),
											"Offer" => $this->string_encrypt($Notification_details->Offer,$key, $iv),
											"Offer_description" => $this->string_encrypt($Notification_details->Offer_description,$key, $iv),											
											"Date" => $this->string_encrypt($Notification_details->Date,$key, $iv),											
											"status_message" => "Success"
										);
										
										echo json_encode($Notification_details);						
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Fetch Selected Notification********************************/
					
					/************************************Delete Selected Notification********************************/
                    if($API_flag == 47)  //*** Delete Selected Notification
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						// die;
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);

							$Notification_id1 = trim($this->string_decrypt($_REQUEST['Notification_id'], $key, $iv));
                            $Notification_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Notification_id1);
									
							// echo"-------Notification_id-------".$Notification_id."--<br>";
							// die;
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						
							
							if($Notification_id == NULL)
                            {
                                echo json_encode(array("status" => "3043", "status_message" => "Notification ID is Blank")); die;
                            }							
                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }							
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {	
									$Notification_details = $this->api_library->DeleteNotifications($Notification_id);
									
									echo json_encode(array("status" => "1001","status_message" => "Success"));						
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************Delete Selected Notification********************************/
					
					/************************************ Add Beneficiary Account ********************************/
                    if($API_flag == 48)  //*** Add Beneficiary Account
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						// die;
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);

							$Beneficiary_Company_id1 = trim($this->string_decrypt($_REQUEST['Beneficiary_Company_id'], $key, $iv));
                            $Beneficiary_Company_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Beneficiary_Company_id1);
							
							$Igain_company_id1 = trim($this->string_decrypt($_REQUEST['Igain_company_id'], $key, $iv));
                            $Igain_company_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Igain_company_id1);
							
							$Beneficiary_Name1 = trim($this->string_decrypt($_REQUEST['Beneficiary_Name'], $key, $iv));
                            $Beneficiary_Name = preg_replace("/[^(\x20-\x7f)]*/s", "", $Beneficiary_Name1);
							
							$Beneficiary_Identifier1 = trim($this->string_decrypt($_REQUEST['Beneficiary_Identifier'], $key, $iv));
                            $Beneficiary_Identifier = preg_replace("/[^(\x20-\x7f)]*/s", "", $Beneficiary_Identifier1);
							
							// echo"-------Beneficiary_Company_id-------".$Beneficiary_Company_id."--<br>";
							// echo"-------Igain_company_id-------".$Igain_company_id."--<br>";
							// echo"-------Beneficiary_Name-------".$Beneficiary_Name."--<br>";
							// echo"-------Beneficiary_Identifier-------".$Beneficiary_Identifier."--<br>";
							// die;
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
							// echo"-------Check_member_exist-------".$Check_member_exist."--<br>";							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }							
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
								else if($Beneficiary_Company_id == ""  || $Beneficiary_Company_id == 0 )
								{
									 echo json_encode(array("status" => "3044", "status_message" => "Beneficiary Company ID is Blank")); die;
								}
								else if($Igain_company_id == ""  || $Igain_company_id == 0 )
								{
									 echo json_encode(array("status" => "3048", "status_message" => "iGainSpark Company ID is Blank")); die;
								}
								else if($Beneficiary_Name == "")
								{
									 echo json_encode(array("status" => "3045", "status_message" => "Beneficiary Name is Blank")); die;
								}
								else if($Beneficiary_Identifier == ""  || $Beneficiary_Identifier == 0 )
								{
									 echo json_encode(array("status" => "3046", "status_message" => "Beneficiary Identifier is Blank")); die;
								}
                                else
                                {	
									
									$Check_Beneficiary_members_exist = $this->api_library->Check_Beneficiary_members_exist($Company_id,$Check_member_exist->Enrollement_id,$Beneficiary_Identifier);
									
								
									if($Check_Beneficiary_members_exist != 0)
									{
										echo json_encode(array("status" => "3047", "status_message" => "Beneficiary Membership already exist")); die;
									}
									else
									{
										$Check_user = $this->api_library->Check_beneficiary_customer($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name);
										// echo"-------Check_user------".$Check_user."--<br>";
										if($Check_user == 1)
										{
											$Check_user_membershipID = $this->api_library->Check_beneficiary_customer_membershipid($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name);
							
											$Check_user_name = $this->api_library->Check_beneficiary_customer_name($Beneficiary_Identifier,$Igain_company_id,$Beneficiary_Name);
											
											if($Check_user_membershipID == 0)
											{
												echo json_encode(array("status" => "3049","status_message" => "Invalid Beneficiary Identifier ID"));
											}
											else if($Check_user_name == 0)
											{
												echo json_encode(array("status" => "3050","status_message" => "Beneficiary Name not matched"));											
												
											}
											else
											{																						
												
												$insert_Beneficairy = $this->api_library->insert_Beneficairy($Company_id,$Check_member_exist->Card_id,$Check_member_exist->Enrollement_id,$Beneficiary_Company_id,$Beneficiary_Name,$Beneficiary_Identifier);
												
												echo json_encode(array("status" => "1001","status_message" => "Success"));
											}
											
										}
										else
										{
											echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
										}										
										
									}
															
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************ Add Beneficiary Account ********************************/
					
					/************************************ Transfer Beneficiary Points ********************************/
                    if($API_flag == 50)  //*** Transfer Beneficiary Points
                    {
						// echo"-------API_flag-------".$API_flag."--<br>";
						// die;
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);

							$Beneficiary_Company_id1 = trim($this->string_decrypt($_REQUEST['Beneficiary_Company_id'], $key, $iv));
                            $Beneficiary_Company_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Beneficiary_Company_id1);
							
							$Igain_company_id1 = trim($this->string_decrypt($_REQUEST['Igain_company_id'], $key, $iv));
                            $Igain_company_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Igain_company_id1);
							
							$Beneficiary_Transfer_Points1 = trim($this->string_decrypt($_REQUEST['Beneficiary_Transfer_Points'], $key, $iv));
                            $Beneficiary_Transfer_Points = preg_replace("/[^(\x20-\x7f)]*/s", "", $Beneficiary_Transfer_Points1);
							
							$Beneficiary_Identifier1 = trim($this->string_decrypt($_REQUEST['Beneficiary_Identifier'], $key, $iv));
                            $Beneficiary_Identifier = preg_replace("/[^(\x20-\x7f)]*/s", "", $Beneficiary_Identifier1);
							
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
							$Customer_name = $Check_member_exist->First_name.' '.$Check_member_exist->Last_name;
							$Card_id = $Check_member_exist->Card_id;
                            $Current_balance = $Check_member_exist->Current_balance;
                            
							
							$Transferto_member_details = $this->Igain_model->get_customer_details($Beneficiary_Identifier,$Igain_company_id);
							$Beneficiary_cust_name = $Transferto_member_details->First_name.' '.$Transferto_member_details->Last_name;
							$Beneficiary_Enrollment_id = $Transferto_member_details->Enrollement_id;
                            $Beneficiary_Current_balance = $Transferto_member_details->Current_balance-$Transferto_member_details->Blocked_points;
							
							
							// echo"-------Beneficiary_Company_id-------".$Beneficiary_Company_id."--<br>";
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);	
							// echo"-------Check_member_exist-------".$Check_member_exist."--<br>";							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }							
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
								else if($Beneficiary_Company_id == ""  || $Beneficiary_Company_id == 0 )
								{
									 echo json_encode(array("status" => "3044", "status_message" => "Beneficiary Company ID is Blank")); die;
								}
								else if($Igain_company_id == ""  || $Igain_company_id == 0 )
								{
									 echo json_encode(array("status" => "3048", "status_message" => "iGainSpark Company ID is Blank")); die;
								}
								else if($Beneficiary_Identifier == ""  || $Beneficiary_Identifier == 0 )
								{
									 echo json_encode(array("status" => "3046", "status_message" => "Beneficiary Identifier is Blank")); die;
								}
								else if($Beneficiary_Identifier == $Membership_id)
								{
									echo json_encode(array("status" => "2017", "status_message" => "Transfer Membership ID Number Not Found"));
								}
								else if($Beneficiary_Transfer_Points == "" || $Beneficiary_Transfer_Points == 0 || $Beneficiary_Transfer_Points < 0)
								{
									// echo"-------points_to_transfer--1-----".$points_to_transfer."--<br>";
									echo json_encode(array("status" => "2018", "status_message" => "Invalid Transfer Points Entered"));die;
								}
								else if($Beneficiary_Transfer_Points > $Current_balance)
								{
									echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));
								}
                                else
                                {	
								
									$Check_user=$this->api_library->get_customer_details($Beneficiary_Identifier,$Igain_company_id);
									// echo"-------Check_user------".$Check_user."--<br>";
									if($Check_user == 1)
									{
										
										/*------------Existing Customer-------------------------------*/
										
										$Beneficiary_Company = $this->api_library->Get_Beneficiary_Company($Beneficiary_Company_id);
										
										$Company_details = $this->api_library->get_company_details($Igain_company_id);
										 
										$Redemptionratio=$Company_details->Redemptionratio;
										 
										$result = $this->api_library->Insert_transfer_transaction($Company_id,$Beneficiary_Transfer_Points,$Enrollment_id,$Card_id,$Beneficiary_Company_id,$Beneficiary_Company->Beneficiary_company_name,$Beneficiary_cust_name,$Beneficiary_Identifier);										
										$New_login_curr_balance=$Current_balance - $Beneficiary_Transfer_Points;
										
										 // echo"-------New_login_curr_balance------".$New_login_curr_balance."--<br>";
										$result1 = $this->api_library->Update_member_balance($Company_id,$Enrollment_id,$New_login_curr_balance);
										
										/*------------Existing Customer-------------------------------*/
										
										$Points_to_Currency=round($Beneficiary_Transfer_Points/$Login_Redemptionratio);
										
										$Redemptionratio=$Company_details->Redemptionratio;
										$Currency_to_Points=($Points_to_Currency*$Redemptionratio);
											
										$Beneficiary_Enrollement_id=$Check_user->Enrollement_id;
										$Member_Current_balance=$Check_user->Current_balance;
										$Blocked_points=$Check_user->Blocked_points;
										
										$Currency_to_Points=round($Currency_to_Points);
										
										$result45 = $this->api_library->insert_transction_benrficiary($Company_id,$Igain_company_id,$Currency_to_Points,$Beneficiary_Identifier,$Beneficiary_Enrollement_id,$Enrollment_id,$Membership_id,$Member_Current_balance,$Customer_name,$Beneficiary_Transfer_Points);
											
										/*------------Beneficiary Customer-------------------------------*/
																						
										echo json_encode(array("status" => "1001","status_message" => "Success"));
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}						
                                }									
                            }                            
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }                    
                    /************************************ Transfer Beneficiary Points ********************************/
					
					
					/************************** Survey Start *********************************************/
					if($API_flag==51) //Fetch All Survey's
					{		
						// echo"-----Fetch All Surveys--<br>";
						 
						if($_REQUEST['Membership_id'] != "")
						{
							// echo"----Membership_id----".$_REQUEST['Membership_id']."----<br>";
							
							$Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
							$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
							// echo"----Membership_id----".$Membership_id."----<br>";
							// die;
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							
							// echo"----Check_member_exist----".$Check_member_exist."----<br>";
							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
							else
							{	
								// echo"----Card_id----".$Check_member_exist->Card_id."----<br>";
								if($Check_member_exist->User_activated==0)
								{
									 echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
								}
								else
								{									
									
									$Enrollement_id=$Check_member_exist->Enrollement_id;									
									$survey_result = $this->api_library->Get_survey($Enrollement_id,$Company_id);
									foreach($survey_result as $survey )
									{									
										$Survey_details[] = array(
																'Survey_id' => $survey['Survey_id'],
																'Survey_name' => $survey['Survey_name']
															);
									}
									// print_r($Survey_details);
									if($Survey_details != NULL)
									{
										$Status_array = array("status" => "1001", "Survey_details" => $Survey_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
								}
							}
						}
						else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
					}
					if($API_flag==52) //Fetch all Questions of selected survey
					{		
						// echo"------Fetch all Questions of selected survey--<br>";
						 
						if($_REQUEST['Membership_id'] != "")
						{
							$Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
							$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							
							$Question_details = array();
							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
							else
							{	
								if($Check_member_exist->User_activated==0)
								{
									 echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
								}
								else
								{								
									
									$Enrollement_id=$Check_member_exist->Enrollement_id;
									$Survey_id = $_REQUEST['Survey_id'];
									// echo"-------Survey_id-------".$Survey_id."--<br>";
									$quetion_count = 1;
									$Survey_details = $this->api_library->Get_survey_question($Survey_id,$Company_id,$Enrollement_id);									
									$Result_count1=count($Survey_details);
									
									foreach($Survey_details as $surdtls)
									{
										
										/* $question_id = $surdtls['Question_id'];
										$Qustion = $surdtls['Question'];
										$response_type = $surdtls['Response_type'];
										$choice_id = $surdtls['Choice_id'];
										$Multiple_selection=$surdtls['Multiple_selection']; */
										$Option_value_string = "";
										$Option_values_details = array();										
										
										if($surdtls['Response_type'] == 2)//Text Box
										{
											
											// echo"-------Response_type-------".$surdtls['Response_type']."--<br>";
												$Question_details[] = array(
													'Question_no' => $quetion_count,
													'Question_id' => $surdtls['Question_id'],
													'Question' => $surdtls['Question'],
													'Response_type' => $surdtls['Response_type'],
													'Multiple_selection' => $surdtls['Multiple_selection'],
													//'Value_id' => $Option_values_details
												);    //'Option_values' => $Option_value_string,
										}
										else if($surdtls['Response_type']==1 ) //For MCQ Values
										{
											// echo"-------Response_type-------".$surdtls['Response_type']."--<br>";
											$Choice_id=$surdtls['Choice_id'];
											$choice_values = $this->api_library->get_MCQ_choice_values($Choice_id);	
											
											foreach($choice_values as $ch_val)
											{
												$Option_image=$ch_val['Option_image'];
												
												$Question_details[] = array(
														'Question_no' => $quetion_count,
														'Question_id' => $surdtls['Question_id'],
														'Question' => $surdtls['Question'],
														'Response_type' => $surdtls['Response_type'],
														'Multiple_selection' => $surdtls['Multiple_selection'],
														'Option_image' => $surdtls['Option_image'],
														$Option_values_details[$ch_val['value_id']] = $ch_val['option_values']
													);
											}
										}											
										$quetion_count++;
									}
									print_r($Question_details);
									
									
									if($Question_details != NULL)
									{
										$Status_array = array("status" => "1001", "Survey_id" => $Survey_id, "Result_count" => $Result_count1, "Question_details" => $Question_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									} 
								}
							}
						}
						else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
					}									
					/**************************Survey End*********************************************/
					
					/************************************Change Member Pin********************************/
                    if($API_flag == 28)
                    {
						// echo"-------Change Member Pin--<br>";
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                        else if($_REQUEST['Current_pin'] == "" || $_REQUEST['New_pin'] == "")
                        {
                            echo json_encode(array("status" => "2047", "status_message" => "PIN Field is empty"));die;
                        }
                        else
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
                            
                            $Current_pin = trim($this->string_decrypt($_REQUEST['Current_pin'], $key, $iv));
                            $Current_pin = preg_replace("/[^(\x20-\x7f)]*/s", "", $Current_pin);
                            
                            $New_pin = trim($this->string_decrypt($_REQUEST['New_pin'], $key, $iv));
                            $New_pin = preg_replace("/[^(\x20-\x7f)]*/s", "", $New_pin);
							
							$Confirm_pin = trim($this->string_decrypt($_REQUEST['Confirm_pin'], $key, $iv));
                            $Confirm_pin = preg_replace("/[^(\x20-\x7f)]*/s", "", $Confirm_pin);
                                             
							

							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								/* echo"-------pinno-------".$Check_member_exist->pinno."--<br>";
								echo"-------Current_pin-------".$Current_pin."--<br>";
								echo"-------New_pin-------".$New_pin."--<br>";
								echo"-------Confirm_pin-------".$Confirm_pin."--<br>";  */
								
								
								
                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }
                                else if($New_pin != $Confirm_pin)
                                {
									echo json_encode(array("status" => "3016", "status_message" => "Your New Pin and New Confirm Pin Not Match"));
                                }
								else if($Check_member_exist->pinno == $Confirm_pin)
                                {
									echo json_encode(array("status" => "3017", "status_message" => "Your Old Pin and New Pin are Same"));
                                }
								else if($Check_member_exist->pinno != $Current_pin)
                                {
									
                                    echo json_encode(array("status" => "2046", "status_message" => "Your Pin Does not Match"));
                                }								
                                else
                                {
                                    $changepin = $this->api_library->Change_pin($Company_id,$Check_member_exist->Enrollement_id,$New_pin);
                                    echo json_encode(array("status" => "1001", "status_message" => "Success"));
                                }
                            }
                        }
                    }
                    /************************************Change Member Pin********************************/
					
					/************************************Get Call Center Query Type********************************/
					if($API_flag == 38)
                    {
						//echo"-------API_flag---".$API_flag."--<br>";
						
                        if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }                       
                        else
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id);
							
							$call_center_flag1 = trim($this->string_decrypt($_REQUEST['call_center_flag'], $key, $iv));
                            $call_center_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $call_center_flag1);
                            
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
							else if($call_center_flag != 1)
                            {
                                echo json_encode(array("status" => "3040", "status_message" => "Disable Call Center")); 
                            }
                            else
                            {
								/* 
								echo"-------pinno-------".$Check_member_exist->pinno."--<br>";
								echo"-------Current_pin-------".$Current_pin."--<br>";
								echo"-------New_pin-------".$New_pin."--<br>";
								echo"-------Confirm_pin-------".$Confirm_pin."--<br>"; */
								
                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }                               								
                                else
                                {
                                    $query_type = $this->api_library->Get_callceter_query_type($Company_id);
										
										/* $Query_type_details = array(
											"status" => "1001",
											"Query_type_id" => $this->string_encrypt($query_type->Query_type_id,$key, $iv),
											"Query_type_name" => $this->string_encrypt($Check_member_exist->Query_type_name,$key, $iv),
											"status_message" => "Success"
										); */
										
										
										foreach($query_type as $query )
										{									
											$Query_details[] = array(
																	'Query_type_id' => $this->string_encrypt($query->Query_type_id,$key, $iv),
																	'Query_type_name' => $this->string_encrypt($query->Query_type_name,$key, $iv)
																	);
										}
										// print_r($Query_details);
										if($Query_details != NULL)
										{
											$Status_array = array("status" => "1001", "Query_type_details" => $Query_details, "status_message" => "Success");
											// echo json_encode($Status_array);
											echo json_encode($Status_array);
										}
										else
										{
											echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
										}	
										
										
                                }
                            }
                        }
                    }
					/************************************Get Call Center Query Type********************************/
					
					
					/************************************Get Call Center Sub Query ********************************/
					if($API_flag == 39)
                    {
						if($_REQUEST['Membership_id'] == "")
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }                       
                        else
                        {
                            $Membership_id = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id); 
							
							$query_type1 = trim($this->string_decrypt($_REQUEST['query_type1'], $key, $iv));
                            $query_type = preg_replace("/[^(\x20-\x7f)]*/s", "", $query_type1);                           
							
							$call_center_flag1 = trim($this->string_decrypt($_REQUEST['call_center_flag'], $key, $iv));
                            $call_center_flag = preg_replace("/[^(\x20-\x7f)]*/s", "", $call_center_flag1);
                            
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
							else if($call_center_flag != 1)
                            {
                                echo json_encode(array("status" => "3040", "status_message" => "Disable Call Center")); 
                            }
							else if($query_type == "" || $query_type == 0)
							{
								echo json_encode(array("status" => "3019", "status_message" => "Query Type id is Blank"));					
							}
                            else
                            {
								/* echo"-------pinno-------".$Check_member_exist->pinno."--<br>";
								echo"-------Current_pin-------".$Current_pin."--<br>";
								echo"-------New_pin-------".$New_pin."--<br>";
								echo"-------Confirm_pin-------".$Confirm_pin."--<br>";  */
								
                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }								
                                else
                                {
									
                                    $sub_query = $this->api_library->Get_sub_query($query_type,$Company_id);
									// echo"--count---sub_query---".count($sub_query)."--<br>";
									
									foreach($sub_query as $squery )
									{									
										$Sub_Query_details[] = array(
											'Query_id' => $this->string_encrypt($squery->Query_id,$key, $iv),
											'Sub_query' => $this->string_encrypt($squery->Sub_query,$key, $iv)
											);
									}
									// print_r($Sub_Query_details);
									if($Sub_Query_details != NULL)
									{
										$Status_array = array("status" => "1001", "Sub_Query_details" => $Sub_Query_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}	
										
										
                                }
                            }
                        }
                    }
					/************************************Get Call Center Sub Query ********************************/
					
					
					
					/************************************Get All Auction  ********************************/
					if($API_flag == 41)
                    {
						if($_REQUEST['Membership_id'] != "")
						{
							$Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
							$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
							$Today_date = date("Y-m-d");
							$current_time = date("H:i:s");
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
							else
							{
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }
								else
								{
									
									$Auction_array = $this->api_library->GetAuction($Company_id,$Today_date);
									$data['CompanyAuction'] = $Auction_array;
									if($Auction_array)
									{
										foreach($Auction_array as $Auction)
										{
											$Total_Auction_Bidder[ $Auction['Auction_id'] ] = $this->api_library->Auction_Total_Bidder($Auction['Auction_id'],$Company_id);
											$data["Total_Auction_Bidder"] = $Total_Auction_Bidder;
											$Top5_Auction_Bidder[ $Auction['Auction_id'] ] = $this->api_library->Auction_Top_Bidder($Auction['Auction_id'],$Company_id);
											$data["Top5_Auction_Bidder"] = $Top5_Auction_Bidder;
											
											$Auction_Max_Bid_val[ $Auction['Auction_id'] ] = $this->api_library->Auction_Max_Bid_Value($Auction['Auction_id'],$Company_id);
											$data["Auction_Max_Bid_val"] = $Auction_Max_Bid_val;
																						
											if($Top5_Auction_Bidder[$Auction['Auction_id']] != "")
											{	
												$j = 0;
												$len = count($Top5_Auction_Bidder[$Auction['Auction_id']]);
												foreach($Top5_Auction_Bidder[$Auction['Auction_id']] as $Top5)
												{										
													if ($j == 0) 
													{										 
														$highest_bidder= $Top5['Enrollment_id'];											
														if($Check_member_exist->Enrollement_id==$highest_bidder)
														{
															$Highest_bid_flag = 1;  //Highest Bidder, You are Highest Bidder
														} 
														else 
														{
															$Highest_bid_flag = 2;  //no longer the Highest Bidder You are No Longer Highest Bidder
														}
													} 
													else if ($j == $len - 1) 
													{
														// $button_flag='1';
													}								
													$j++;
												}
											}
											else
											{
												 $Highest_bid_flag = 0;  //no Bid for Auction Become First Bidder
												
											}
											foreach($Auction_Max_Bid_val[$Auction['Auction_id']] as $bid)
											{
												if($bid['Bid_value']=='')
												{
													$Min_bid_value = $Auction['Min_bid_value'] ; 
												}
												else
												{
													$Min_bid_value = $bid['Bid_value'] + $Auction['Min_increment']; 
												}
											}														
											$Auction_details[] = array(
																"Auction_id" => $Auction['Auction_id'],
																"Prize_image" => $this->config->item('base_url2').$Auction['Prize_image'],"Auction_name" => $Auction['Auction_name'],
																"Start_date" => $Auction['From_date'],
																"End_date" => $Auction['To_date'],
																"End_time" => $Auction['End_time'],
																"Prize" => $Auction['Prize'],
																"Prize_description" => $Auction['Prize_description'],
																"Min_bid_value" => $Min_bid_value,
																"Min_increment" => $Auction['Min_increment'],
																"Highest_bid_flag" => $Highest_bid_flag
															);
										}											
										$Status_array = array("status" => "1001", "Auction_details" => $Auction_details, "status_message" => "Success");
										echo json_encode($Status_array);
									}
									else
									{
										echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
									}
								
								}						
						
							}
						}
						else
						{
							echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
						}
					}					
					/************************************Get All Auction  ********************************/
					
					
					/************************************ Insert Auction Bid ********************************/
					if($API_flag == 42)
                    {
						if($_REQUEST['Membership_id'] != "")
						{
							$Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
							$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
							$Today_date = date("Y-m-d");
							$current_time = date("H:i:s");
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);						
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
							else
							{
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }
								else
								{
									
									$Enrollement_id=$Check_member_exist->Enrollement_id;
									
									$Blocked_points = $Check_member_exist->Blocked_points;
									$Curr_balance = $Check_member_exist->Current_balance;
									$Current_balance = $Curr_balance - $Blocked_points;
									
									$Bid_value = $_REQUEST['Bid_value'];
                                    $Bid_value2 = number_format($Bid_value, 2, '.', '');
                                    $Auction_id = $_REQUEST['Auction_id'];
									
									// echo"------Bid_value------".$Bid_value."---<br>";
									// echo"------Bid_value2------".$Bid_value2."---<br>";
									// echo"------Auction_id------".$Auction_id."---<br>";
									
									// die;
									
									if($Auction_id == "" || $Auction_id == 0)
                                    {
                                        echo json_encode(array("status" => "2015", "status_message" => "Kindly Enter An Auction ID"));die;
                                    }
                                    else
                                    {
										$Auction_details = $this->api_library->Auction_details($Auction_id,$Company_id);
										
										$lv_auction_name = $Auction_details->Auction_name;
                                        $Prize = $Auction_details->Prize;
                                        $Min_increment = $Auction_details->Min_increment;
										
										$MAX_bid_Auction_dtls = $this->api_library->Fetch_Auction_Max_Bid_Value($Auction_id,$Company_id);
										foreach($MAX_bid_Auction_dtls as $mx)
										{
											$MAX_bid_Auction=$mx['MAX(Bid_value)'];
											$Min_increment=$mx['Min_increment'];
										}
										
										
										$Max_bid_for_auction = $MAX_bid_Auction;
                                        $Minimum_points_to_bid = $MAX_bid_Auction + $Min_increment;
										
										if($Bid_value2 <= $Max_bid_for_auction)
                                        {
                                            echo json_encode(array("status" => "2013", "status_message" => "Bid value should be greater or equal to minimum bid Amount"));die;
                                        }
                                        else if($Bid_value < $Minimum_points_to_bid)
                                        {
                                            echo json_encode(array("status" => "2013", "status_message" => "Bid value should be greater or equal to minimum bid Amount"));die;
                                        }
										else if($Bid_value > $Current_balance)
                                        {
                                            echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));die;
                                        }
										else if($Bid_value == "" || $Bid_value == 0 || $Bid_value < 0)
                                        {
                                            echo json_encode(array("status" => "3006", "status_message" => "Bid value is Invalid"));die;
                                        }
										else if( is_numeric($Bid_value) && ( floor($Bid_value) != $Bid_value ) )
                                        {
                                            echo json_encode(array("status" => "3006", "status_message" => "Bid value is Invalid"));die;
                                        }
										else
										{
											$Super_Seller= $this->Igain_model->Fetch_Super_Seller_details($Company_id);	
											$Super_Seller_enroll=$Super_Seller->Enrollement_id;
											
											$MAX_bid_Auction_dtls = $this->api_library->insert_auction_bidding($Super_Seller_enroll,$Auction_id,$Company_id,$Enrollement_id,$Prize,$Bid_value);
											
											echo json_encode(array("status" => "1001", "status_message" => "Success"));die;
										}
										
									}															
								
								}						
						
							}
						}
						else
						{
							echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
						}
					}					
					/************************************ Insert Auction Bid ********************************/
					
					/************************************Merchandize  Catalogue********************************/
					if($API_flag == 56)  //***Fetch all Catalogue items
                    {
						// echo"-----API_flag---------".$API_flag."---<br>";
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
                            $Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
                            $Enrollment_id = $Check_member_exist->Enrollement_id;
                            $Curr_balance = $Check_member_exist->Current_balance;
                            $Current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
                            // $Enrollment_id = $Check_member_exist->Enrollment_id;
                            
                                                        
                            /**********************Calculate Family Days Available Limit*****************************/
                                $todays_date = date("Y-m-d");                                
                            /******************Calculate Family Days Available Limit*****************************/
                            
                            $Cart_count = 0;
                            
							// echo"-----Enrollment_id---------".$Enrollment_id."---<br>";
							$cart_result = $this->api_library->get_cart($Enrollment_id);
                            $cart_quantity = count($cart_result);
							
                            $lv_Total_points = 0;
                            $Cart_count = $cart_quantity;
							// echo"-----Cart_count---------".$Cart_count."---<br>";
							
							// $Redeemtion_details = $this->api_library->get_total_redeeem_points($Enrollment_id);
		
							$Total_Redeem_points=0;
							// print_r($cart_result);
							// echo"-----Cart_count---------".$Cart_count."---<br>";
							if($cart_result)
							{
								foreach($cart_result as $Redeemtion_details)
								{
									//echo "<br>".$Redeemtion_details["Points"];
									//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
									$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
								}
							}
							// echo"-----Total_Redeem_points---------".$Total_Redeem_points."---<br>";
							// die;
							
                            
                            if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
                                }                               
                                else
                                {
									$Merchandize_category_id=0;
									$Sort_by=0;
									$Sort_by_merchant=0;
									$Sort_by_brand=0;
									$Sort_by_gender=0;
									
									if(isset($_REQUEST["Sort_by_category_flag"]))
									{
										$Merchandize_category_id=$_REQUEST["Sort_by_category_flag"];
									}
									if(isset($_REQUEST["Sort_by_points_flag"]))
									{
										$Sort_by=$_REQUEST["Sort_by_points_flag"];
									}
									if(isset($_REQUEST["Sort_by_merchant_flag"]))
									{
										$Sort_by_merchant=$_REQUEST["Sort_by_merchant_flag"];
									}
									if(isset($_REQUEST["Sort_by_brand_flag"]))
									{
										$Sort_by_brand=$_REQUEST["Sort_by_brand_flag"];
									} 
									if(isset($_REQUEST["Sort_by_gender_flag"]))
									{
										$Sort_by_gender=$_REQUEST["Sort_by_gender_flag"];
									}
									
									/************************New Sorting****************************/
									
									
                                        $Redemption_Items = $this->api_library->get_all_items($Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender);
										$data['Redemption_Items'] = $Redemption_Items;
										if($Redemption_Items != NULL)
										{
											foreach ($Redemption_Items as $product)
											{
												$itemCode = $product['Company_merchandize_item_code'];
												$Redemption_Items_branches_array[$itemCode] = $this->api_library->get_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
												
												// $Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];			
												$Branches = $Redemption_Items_branches_array[$product['Company_merchandize_item_code']];
												
												foreach ($Branches as $Branches)
												{
													$Branch_details[$product['Company_merchandize_item_code']] = array
                                                                ( 
                                                                    "Branch_code" => $Branches['Branch_code'],
                                                                    "Branch_name" => $Branches['Branch_name']
                                                                );
												}
												 $Catalogue_details[] = array
													(
														"Company_merchandise_item_id" => $product['Company_merchandise_item_id'],
														"Item_image" => $product['Thumbnail_image1'],
														"Billing_price_in_points" => $product['Billing_price_in_points'],
														"Delivery_method" => $product['Delivery_method'],
														"Merchandize_item_code" => $product['Company_merchandize_item_code'],
														"Merchandize_item_name" => $product['Merchandize_item_name'],
														//"Merchandise_item_description" => mysqli_real_escape_string($conn,$Catalogue['Merchandise_item_description']),
														"Merchandise_item_description" => htmlspecialchars($product['Merchandise_item_description'],ENT_SUBSTITUTE),
														"Branch_details" => $Branch_details
													);
													
													
											
											
											}
											
										}
										// echo"</pre>";
										// print_r($Catalogue_details);
										
                                    
                                    if($Redemption_Items > 0)
                                    {
                                        $Status_array = array("status" => "1001","Current_balance" => $Current_balance,"Total_Redeem_points_incart" => $Total_Redeem_points,"Total_items_incart"=>$Cart_count, "Catalogue_details" => $Catalogue_details, "status_message" => "Success");
                                        echo json_encode($Status_array);
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
					/************************************Merchandize  Catalogue********************************/
					/************************************Insert Item into Cart********************************/
					if($API_flag == 58)     //**Insert Item into cart
					{
						
						if($_REQUEST['Membership_id'] != "")
						{
							$Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
							$Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
							$Curr_balance = $Check_member_exist->Current_balance;
							$Current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
							
							$Redemption_method = trim($_REQUEST['Redemption_method']);
							$Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
							$Branch = trim($_REQUEST['Branch']);
							$Billing_price_in_points = trim($_REQUEST['Billing_price_in_points']);
							
							$Weight_error_flag = array();
							$Weight_array = array();
							
													
							$Cart_count = 0;								
							$cart_result = $this->api_library->get_cart($Enrollment_id);
							$cart_quantity = count($cart_result);								
							// $lv_Total_points = 0;
							$Cart_count = $cart_quantity;	

							$Total_Redeem_points=0;
							// print_r($cart_result);
							// echo"-----Cart_count---------".$Cart_count."---<br>";
							if($cart_result)
							{
								foreach($cart_result as $Redeemtion_details)
								{
									//echo "<br>".$Redeemtion_details["Points"];
									//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
									$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
								}
							}
							//$Total_Redeem_points_incart = $lv_Total_points + $Billing_price_in_points;
							// $Total_Redeem_points_incart = $lv_Total_points;                            
							$new_Total_Redeem_points_incart = $Total_Redeem_points_incart + $Total_Redeem_points;
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
						
								if($Check_member_exist->User_activated==0)
								{
									echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));die;
								}								
								else if($new_Total_Redeem_points_incart > $Current_balance)
								{
									echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance")); die;                                           
								}
								else if($Total_Redeem_points_incart > 0 && $Current_balance <= 0)
								{
									echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance")); die;
								}								
								else if($Total_Redeem_points_incart > $Current_balance)
								{
									echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance")); die;
								}
								else
								{
									
									/*------------------------Item Details-----------------*/
									
									$Item_details = $this->api_library->get_delivery_item($Company_id,$Company_merchandize_item_code,$Redemption_method);
									$Item_valid_count = count($Item_details);								
										
									$Branch_details = $this->api_library->get_item_branch($Company_id,$Company_merchandize_item_code);
									$Branch_valid_count = Count($Branch_details);
									if($Redemption_method == 0 && $Branch == "")
									{
										echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
									}
									else if($Redemption_method == 0 && $Branch_valid_count == 0)
									{
										echo json_encode(array("status" => "2035", "status_message" => "Item cannot be deleted"));
									}
									else
									{
										if($Item_valid_count > 0)
										{
											$Size=1;
											$result = $this->api_library->Insert_into_cart($Company_merchandize_item_code,$Redemption_method,$Branch,$Billing_price_in_points,$Company_id,$Check_member_exist->Enrollement_id,$Size);
											
											$Redeemtion_details = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
												$cart_quantity = count($Redeemtion_details);								
												// $lv_Total_points = 0;
												$Cart_count = $cart_quantity;
											$Cart_quantity87=0;
											if(count($Redeemtion_details)!=0)
											{
												foreach($Redeemtion_details as $Redeemtion_details)
												{
													//echo "<br>".$Redeemtion_details["Points"];
													//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
													$Cart_quantity87=$Cart_quantity87+$Redeemtion_details["Total_points"];
												}
											} 
																							
											echo json_encode(array("status" => "1001","Total_Redeem_points_incart" => $Cart_quantity87,"Total_items_incart"=>$cart_quantity, "status_message" => "Success"));
										}
										else
										{
											echo json_encode(array("status" => "2034", "status_message" => "Please check the items in cart"));
										}
									}                                    
									
								}
							}
						}
						else
						{
							echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
						}
					}				
					/************************************Insert Item into Cart********************************/
					/************************************Show Catlogue********************************/
					
					if($API_flag == 59)     //**Catalogue Checkout
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                           
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
							$Current_balance = $Check_member_exist->Current_balance;
							$Available_current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
							$Current_address = $Check_member_exist->Current_address;
							$Blocked_points = $Check_member_exist->Blocked_points;
							
							
							$Cust_redeem_pin_validation = $Check_company_exist->Allow_merchant_pin;
							$Cust_pin_validation = $Check_company_exist->Pin_no_applicable;
							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
                                    $cart_result = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
                                    
									/* $sql87 = "SELECT TC.Item_code FROM lsl_company_merchandise_catalogue as CM,lsl_temp_cart as TC
                                              WHERE CM.Company_merchandize_item_code = TC.Item_code
                                              AND (CM.Delivery_method = TC.Redemption_method OR CM.Delivery_method = 3)
                                              AND CM.Company_id IN ('".$Company_id."',1)
                                              AND CM.Active_flag='1'
                                              AND TC.Enrollment_id='".$Enrollment_id."' "; */
                                    // $Cart_quantity = mysqli_num_rows(mysqli_query($conn,$sql87));
                                    
                                    $Cart_quantity = count($cart_result);
                                    $lv_Total_points = 0;
                                    $lv_total_shopping_points = 0;
                                    $Redemption_method123 = array();
                                    $item_array = array();
                                    $Remark_item_array = array();
                                    $DeliveryItem = array();

                                    if($Cart_quantity > 0)
                                    {
                                        // while($mv_row99 = mysqli_fetch_array($cart_result))
                                        foreach($cart_result as $Catalogue)
                                        {
											$Seller_id=$Catalogue["Seller_id"];
											
											// echo"----Seller_id----".$Seller_id."<br>";
											
											$lv_Partner_id = $Catalogue["Partner_id"];
											$lv_Partner_Country_id = $Catalogue["Country_id"];
											$lv_Partner_State_id = $Catalogue["State_id"];
											$Partner_contact_person_name = $Catalogue["Partner_contact_person_name"];
											$Partner_address = $Catalogue["Partner_address"];                                            

											$Redemption_method = $Catalogue["Redemption_method"];
											array_push($Redemption_method123,$Redemption_method);
											$Branch = $Catalogue["Branch"];

											// if($Redemption_method == 1)
											if($Redemption_method == 0) // Collect in Person
											{
												$lv_converted_shipping_points = 0;
												$Redemption_method = 0;
												$RedemptionMethod = "Redeemed in Person";
																																				
												if($Catalogue['Item_image'] == "" || $Catalogue['Item_image'] == NULL)
												{
													$Item_image = "https://demo.perxclm2.com/images/no_image.jpeg";
												}
												else
												{
													//$Item_image = "https://demo.perxclm2.com/".$Catalogue['Item_image'];
													$Item_image = $Catalogue['Item_image'];
												} 
												
												$get_enrollment = $this->Igain_model->get_enrollment_details($Seller_id);
												$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
												
												$Size=$Catalogue["Size"];
												
												/* if($Catalogue["Size"]==1)
												{
													$Size='Small';
												}
												elseif($Catalogue["Size"]==2)
												{
													$Size='Medium';
												}
												elseif($Catalogue["Size"]==3)
												{
													$Size='Large';
												}
												else
												{
													$Size='Extra Large';
												} */
												
													$Cart_details[] = array
														(
															"Company_merchandise_item_id" => $Catalogue['Company_merchandise_item_id'],
															"Company_merchandize_item_code" => $Catalogue['Item_code'],
															"Item_image" => $Item_image,
															"Merchandize_item_name" => $Catalogue['Merchandize_item_name'],
															"Quantity" => $Catalogue['Quantity'],
															"RedemptionMethod" => $RedemptionMethod,
															"Delivery_Method" => $Redemption_method,
															"Partner_location" =>$Catalogue["Address"], //$Partner_location,
															"Branch" => $Catalogue["Branch"], //$Branch,
															"Billing_price_in_points" => $Catalogue["Billing_price_in_points"],
															"Total_Redeemable_points" => $Catalogue["Total_points"],
															"Total_shipping_points" =>0,
															"Partner_address" => $Catalogue["Address"],
															// "Partner_id" => $lv_Partner_id,
															// "Remark_label" => $Remark_lable,
															// "Enable_remark" => $Catalogue["Enable_remark"],
															// "Remark" => $mv_row99["Remark"],
															// "Partner_contact_person_name" => $Partner_contact_person_name,
															"Shipping_points" =>$merchant_name,
															"Size" =>$Size,
															
														);
														
														$lv_Total_points = $lv_Total_points + $Catalogue["Total_points"];
														//"Temp_cart_id" => $mv_row99["Temp_cart_id"]
											}
											// array_unshift($item_array,$Catalogue["Merchandize_item_name"]);
                                            
                                        }
                                        
										$Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points;
										$Status_array = array
                                                ("Total_points" => $lv_Total_points,
                                                 // "Total_shipping_points" => $lv_total_shopping_points,
                                                 "Total_shipping_points" => 0,
                                                 "Grand_Total_Points" => $Grand_Total_Points,
                                                 "Cart_quantity" => $Cart_quantity,
                                                 "Current_balance" => $Available_current_balance,
                                                 "Cust_pin_validation" => $Cust_pin_validation,
                                                 // "Merchandize_item_array" => $Merchandize_item_array
                                                ); 
                                        //$Cart_array = array_reverse($Cart_details);
                                        //$Cart_details = array_merge($Cart_array,$Status_array);
                                        //echo json_encode($Cart_details); */
                                        
                                        $Cart_array = array("status" => "1001", "Cart_details" => $Cart_details, "Status_array" => $Status_array, "status_message" => "Success");
                                        echo json_encode($Cart_array);
										
										
										
                                    }
                                    else
                                    {
                                        echo json_encode(array("status" => "2012", "status_message" => "No Data Found"));
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
                        }
                    }
					/************************************Show Catlogue********************************/
					/************************************Update Catlogue Quantity********************************/
					if($API_flag == 60)     //**Update Item Quantity
                    {
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                           
							$Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
                            $Delivery_Method = trim($_REQUEST['Delivery_Method']);
                            $Branch = trim($_REQUEST['Branch']);
                            $Quantity = trim($_REQUEST['Quantity']);
                            $Total_Redeemable_points = trim($_REQUEST['Total_Redeemable_points']);
                            $Company_merchandise_item_id = trim($_REQUEST['Company_merchandise_item_id']);
                            $Size = trim($_REQUEST['Size']);
							
                            $Weight_error_flag = array(); 
							$Weight_array = array();   
							$Weight_error_flag2 = array();
							
							$lv_Total_points=0;
							// Billing_price_in_points
						   
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
							$Current_balance = $Check_member_exist->Current_balance;
							$Available_current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
							$Current_address = $Check_member_exist->Current_address;
							$Blocked_points = $Check_member_exist->Blocked_points;
							
							$cart_result = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
							if($cart_result > 0)
                            {
								foreach($cart_result as $Catalogue)
								{
									$lv_Total_points = $lv_Total_points + $Catalogue["Total_points"];
									
								}
							}							
							// echo"---lv_Total_points--".$lv_Total_points."---<br>";
							$Item_details = $this->api_library->Get_Merchandize_Item_details($Company_merchandise_item_id);
							foreach($Item_details as $item)
							{
								$Merchandize_item_name=$item->Merchandize_item_name;
								$Billing_price_in_points=$item->Billing_price_in_points;
							}
							
							$Total_Redeemable_points = $Quantity * $Billing_price_in_points;
							// echo"---Total_Redeemable_points--".$Total_Redeemable_points."---<br>";
							
							$Total_Redeem_points_incart = $lv_Total_points + $Total_Redeemable_points;
							
							// echo"---Total_Redeem_points_incart--".$Total_Redeem_points_incart."---<br>";
							// echo"---Available_current_balance--".$Available_current_balance."---<br>";
							
							// $Billing_price_in_points = $mv_row22["Billing_price_in_points"];
							// echo"---Total_Redeem_points_incart--".$Total_Redeem_points_incart."---<br>";
							// echo"---Available_current_balance--".$Available_current_balance."---<br>";
							
							$Cust_redeem_pin_validation = $Check_company_exist->Allow_merchant_pin;
							$Cust_pin_validation = $Check_company_exist->Pin_no_applicable;	
							
							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
								else if($Quantity == "")
								{
									echo json_encode(array("status" => "2036", "status_message" => "Please Check item quantity"));
								}
								else if(!is_numeric($Quantity))
								{
									echo json_encode(array("status" => "2036", "status_message" => "Please Check item quantity"));
								}
								else if($Total_Redeem_points_incart > $Available_current_balance)
								{
									echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));                                           
								}
                                else
                                {
									$ItemDelete = $this->api_library->delete_item_catalogue($Company_merchandize_item_code,$Check_member_exist->Enrollement_id,$Company_id,$Branch,$Size);									
									for($i=0;$i<$Quantity;$i++)
									{	
										$Redemption_method=0;
										$result = $this->api_library->Insert_into_cart($Company_merchandize_item_code,$Redemption_method,$Branch,$Billing_price_in_points,$Company_id,$Check_member_exist->Enrollement_id,$Size);
									}						
									
									
									$cart_result = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
                                   
									$Cart_quantity = count($cart_result);
                                    $lv_Total_points = 0;
                                    $lv_total_shopping_points = 0;
                                    $Redemption_method123 = array();
                                    $item_array = array();
                                    $Remark_item_array = array();
                                    $DeliveryItem = array();
									$Redemption_method=0;
                                    if($Cart_quantity > 0)
                                    {
                                        foreach($cart_result as $Catalogue)
                                        {
											$Seller_id=$Catalogue["Seller_id"];
											$lv_Partner_id = $Catalogue["Partner_id"];
											$lv_Partner_Country_id = $Catalogue["Country_id"];
											$lv_Partner_State_id = $Catalogue["State_id"];
											$Partner_contact_person_name = $Catalogue["Partner_contact_person_name"];
											$Partner_address = $Catalogue["Partner_address"];                                            
											$Redemption_method = $Catalogue["Redemption_method"];
											array_push($Redemption_method123,$Redemption_method);
											$Branch = $Catalogue["Branch"];
											
											if($Redemption_method == 0) // Collect in Person
											{
												$lv_converted_shipping_points = 0;
												$Redemption_method = 0;
												$RedemptionMethod = "Redeemed in Person";
																																				
												if($Catalogue['Item_image'] == "" || $Catalogue['Item_image'] == NULL)
												{
													$Item_image = "https://demo.perxclm2.com/images/no_image.jpeg";
												}
												else
												{
													//$Item_image = "https://demo.perxclm2.com/".$Catalogue['Item_image'];
													$Item_image = $Catalogue['Item_image'];
												} 
												
												$get_enrollment = $this->Igain_model->get_enrollment_details($Seller_id);
												$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
												
												$Size=$Catalogue["Size"];
												
												/* if($Catalogue["Size"]==1)
												{
													$Size='Small';
												}
												elseif($Catalogue["Size"]==2)
												{
													$Size='Medium';
												}
												elseif($Catalogue["Size"]==3)
												{
													$Size='Large';
												}
												else
												{
													$Size='Extra Large';
												} */
												
												$Cart_details[] = array
													(
														"Company_merchandise_item_id" => $Catalogue['Company_merchandise_item_id'],
														"Company_merchandize_item_code" => $Catalogue['Item_code'],
														"Item_image" => $Item_image,
														"Merchandize_item_name" => $Catalogue['Merchandize_item_name'],
														"Quantity" => $Catalogue['Quantity'],
														"RedemptionMethod" => $RedemptionMethod,
														"Delivery_Method" => $Redemption_method,
														"Partner_location" =>$Catalogue["Address"], //$Partner_location,
														"Branch" => $Catalogue["Branch"], //$Branch,
														"Billing_price_in_points" => $Catalogue["Billing_price_in_points"],
														"Total_Redeemable_points" => $Catalogue["Total_points"],
														"Total_shipping_points" =>0,
														"Partner_address" => $Catalogue["Address"],
														// "Partner_id" => $lv_Partner_id,
														// "Remark_label" => $Remark_lable,
														// "Enable_remark" => $Catalogue["Enable_remark"],
														// "Remark" => $mv_row99["Remark"],
														// "Partner_contact_person_name" => $Partner_contact_person_name,
														"Shipping_points" =>$merchant_name,
														"Size" =>$Size,
														
													);													
													$lv_Total_points = $lv_Total_points + $Catalogue["Total_points"];
											}
                                            
                                        }                                        
										$Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points;
										$Status_array = array
                                                ("Total_points" => $lv_Total_points,
                                                 // "Total_shipping_points" => $lv_total_shopping_points,
                                                 "Total_shipping_points" => 0,
                                                 "Grand_Total_Points" => $Grand_Total_Points,
                                                 "Cart_quantity" => $Cart_quantity,
                                                 "Current_balance" => $Available_current_balance,
                                                 "Cust_pin_validation" => $Cust_pin_validation,
                                                 "Cust_redeem_pin_validation" => $Cust_redeem_pin_validation,
                                                ); 
                                        //$Cart_array = array_reverse($Cart_details);
                                        //$Cart_details = array_merge($Cart_array,$Status_array);
                                        //echo json_encode($Cart_details); */
                                        
                                        $Cart_array = array("status" => "1001", "Cart_details" => $Cart_details, "Status_array" => $Status_array, "status_message" => "Success");
                                        echo json_encode($Cart_array);									
									}
								}						
							}
						}
						else
						{
							echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
						}
						
					}
					/************************************Update Catlogue Quantity********************************/
					
					/************************************Delete Catlogue Item********************************/
					if($API_flag == 61)     //**Delete Catlogue Item
                    {
						if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                           
							$Company_merchandize_item_code = trim($_REQUEST['Company_merchandize_item_code']);
                            $Delivery_Method = trim($_REQUEST['Delivery_Method']);
                            $Branch = trim($_REQUEST['Branch']);
                            $Quantity = trim($_REQUEST['Quantity']);
                            $Total_Redeemable_points = trim($_REQUEST['Total_Redeemable_points']);
                            $Company_merchandise_item_id = trim($_REQUEST['Company_merchandise_item_id']);
                            $Size = trim($_REQUEST['Size']);
							
                            $Weight_error_flag = array(); 
							$Weight_array = array();   
							$Weight_error_flag2 = array();
							
							$lv_Total_points=0;
							// Billing_price_in_points
						   
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
							$Current_balance = $Check_member_exist->Current_balance;
							$Available_current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
							$Current_address = $Check_member_exist->Current_address;
							$Blocked_points = $Check_member_exist->Blocked_points;
							
							$cart_result = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
							if($cart_result > 0)
                            {
								foreach($cart_result as $Catalogue)
								{
									$lv_Total_points = $lv_Total_points + $Catalogue["Total_points"];
									
								}
							}							
							// echo"---lv_Total_points--".$lv_Total_points."---<br>";
							/* $Item_details = $this->api_library->Get_Merchandize_Item_details($Company_merchandise_item_id);
							foreach($Item_details as $item)
							{
								$Merchandize_item_name=$item->Merchandize_item_name;
								$Billing_price_in_points=$item->Billing_price_in_points;
							}
							
							$Total_Redeemable_points = $Quantity * $Billing_price_in_points;
							// echo"---Total_Redeemable_points--".$Total_Redeemable_points."---<br>"; */
							
							$Total_Redeem_points_incart = $lv_Total_points;  //+ $Total_Redeemable_points;
							
							// echo"---Total_Redeem_points_incart--".$Total_Redeem_points_incart."---<br>";
							// echo"---Available_current_balance--".$Available_current_balance."---<br>";
							
							// $Billing_price_in_points = $mv_row22["Billing_price_in_points"];
							// echo"---Total_Redeem_points_incart--".$Total_Redeem_points_incart."---<br>";
							// echo"---Available_current_balance--".$Available_current_balance."---<br>";
							
							$Cust_redeem_pin_validation = $Check_company_exist->Allow_merchant_pin;
							$Cust_pin_validation = $Check_company_exist->Pin_no_applicable;	
							
							
							if($Check_member_exist == NULL)
                            {
                                echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));
                            }
                            else
                            {
								if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership ID Has been Disabled or Membership ID is Not Active "));
                                }
                                else
                                {
									$ItemDelete = $this->api_library->delete_item_catalogue($Company_merchandize_item_code,$Check_member_exist->Enrollement_id,$Company_id,$Branch,$Size);									
									
									/* for($i=0;$i<$Quantity;$i++)
									{	
										$Redemption_method=0;
										$result = $this->api_library->Insert_into_cart($Company_merchandize_item_code,$Redemption_method,$Branch,$Billing_price_in_points,$Company_id,$Check_member_exist->Enrollement_id,$Size);
									} */						
									
									
									$cart_result = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
                                   
									$Cart_quantity = count($cart_result);
                                    $lv_Total_points = 0;
                                    $lv_total_shopping_points = 0;
                                    $Redemption_method123 = array();
                                    $item_array = array();
                                    $Remark_item_array = array();
                                    $DeliveryItem = array();
									$Redemption_method=0;
                                    if($Cart_quantity > 0)
                                    {
                                        foreach($cart_result as $Catalogue)
                                        {
											$Seller_id=$Catalogue["Seller_id"];
											$lv_Partner_id = $Catalogue["Partner_id"];
											$lv_Partner_Country_id = $Catalogue["Country_id"];
											$lv_Partner_State_id = $Catalogue["State_id"];
											$Partner_contact_person_name = $Catalogue["Partner_contact_person_name"];
											$Partner_address = $Catalogue["Partner_address"];                                            
											$Redemption_method = $Catalogue["Redemption_method"];
											// array_push($Redemption_method123,$Redemption_method);
											$Branch = $Catalogue["Branch"];
											
											if($Redemption_method == 0) // Collect in Person
											{
												$lv_converted_shipping_points = 0;
												$Redemption_method = 0;
												$RedemptionMethod = "Redeemed in Person";
																																				
												if($Catalogue['Item_image'] == "" || $Catalogue['Item_image'] == NULL)
												{
													$Item_image = "https://demo.perxclm2.com/images/no_image.jpeg";
												}
												else
												{
													//$Item_image = "https://demo.perxclm2.com/".$Catalogue['Item_image'];
													$Item_image = $Catalogue['Item_image'];
												} 
												
												$get_enrollment = $this->Igain_model->get_enrollment_details($Seller_id);
												$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
												
												$Size=$Catalogue["Size"];
												
												/* if($Catalogue["Size"]==1)
												{
													$Size='Small';
												}
												elseif($Catalogue["Size"]==2)
												{
													$Size='Medium';
												}
												elseif($Catalogue["Size"]==3)
												{
													$Size='Large';
												}
												else
												{
													$Size='Extra Large';
												} */
												
												$Cart_details[] = array
													(
														"Company_merchandise_item_id" => $Catalogue['Company_merchandise_item_id'],
														"Company_merchandize_item_code" => $Catalogue['Item_code'],
														"Item_image" => $Item_image,
														"Merchandize_item_name" => $Catalogue['Merchandize_item_name'],
														"Quantity" => $Catalogue['Quantity'],
														"RedemptionMethod" => $RedemptionMethod,
														"Delivery_Method" => $Redemption_method,
														"Partner_location" =>$Catalogue["Address"], //$Partner_location,
														"Branch" => $Catalogue["Branch"], //$Branch,
														"Billing_price_in_points" => $Catalogue["Billing_price_in_points"],
														"Total_Redeemable_points" => $Catalogue["Total_points"],
														"Total_shipping_points" =>0,
														"Partner_address" => $Catalogue["Address"],
														// "Partner_id" => $lv_Partner_id,
														// "Remark_label" => $Remark_lable,
														// "Enable_remark" => $Catalogue["Enable_remark"],
														// "Remark" => $mv_row99["Remark"],
														// "Partner_contact_person_name" => $Partner_contact_person_name,
														"Shipping_points" =>$merchant_name,
														"Size" =>$Size,
														
													);													
													$lv_Total_points = $lv_Total_points + $Catalogue["Total_points"];
											}
                                            
                                        }                                        
										// $Grand_Total_Points = $lv_total_shopping_points77 + $lv_Total_points;
										$Grand_Total_Points = $lv_Total_points;
										$Status_array = array
                                                (
													"Total_points" => $lv_Total_points,
													// "Total_shipping_points" => $lv_total_shopping_points,
													"Total_shipping_points" => 0,
													"Grand_Total_Points" => $Grand_Total_Points,
													"Cart_quantity" => $Cart_quantity,
													"Current_balance" => $Available_current_balance,
													"Cust_pin_validation" => $Cust_pin_validation,
													"Cust_redeem_pin_validation" => $Cust_redeem_pin_validation,
													// "Merchandize_item_array" => $Merchandize_item_array
                                                ); 
                                        //$Cart_array = array_reverse($Cart_details);
                                        //$Cart_details = array_merge($Cart_array,$Status_array);
                                        //echo json_encode($Cart_details); */
                                        
                                        $Cart_array = array("status" => "1001", "Cart_details" => $Cart_details, "Status_array" => $Status_array, "status_message" => "Success");
                                        echo json_encode($Cart_array);									
									}
								}						
							}
						}
						else
						{
							echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));
						}
						
					}
					/************************************Delete Catlogue Item********************************/
					/**************************Insert Catlogue Item or Redemption Item ************************/
					if($API_flag == 65)  //***Insert Redeemed Item
                    {
                        if($_REQUEST['Membership_id'] != "")
                        {
                            $Membership_id1 = trim($this->string_decrypt($_REQUEST['Membership_id'], $key, $iv));
                            $Membership_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Membership_id1);
                            
							// $member_details_result = lslDB::getInstance()->get_member_details($Membership_id,$Company_id);
                            // $member_details = mysqli_fetch_array($member_details_result);
							
							
							$Check_member_exist = $this->Igain_model->get_customer_details($Membership_id,$Company_id);
							$Enrollment_id = $Check_member_exist->Enrollement_id;
							$Current_balance = $Check_member_exist->Current_balance;
							$Available_current_balance = $Check_member_exist->Current_balance-$Check_member_exist->Blocked_points;
							$Current_address = $Check_member_exist->Current_address;
							$Blocked_points = $Check_member_exist->Blocked_points;
							$member_pinno = $Check_member_exist->pinno;
							
							
							
                            // $Current_balance = $member_details['Current_balance'];
                            // $Blocked_points = $member_details['Blocked_points'];
                            // $Communication_flag = $member_details['Communication_flag'];
                            // $Communication_type = $member_details['Communication_type'];
                            // $Enrollment_id = $member_details['Enrollment_id'];
                            // $Available_current_balance = $Current_balance - $Blocked_points;
                            // $City_id = $member_details['City_id'];
                            // $Current_address = $member_details['Current_address'];
                            // $ShippingAddress = "";
                           
							$Membership_id_encry =$this->string_encrypt($Membership_id, $key, $iv);
                            $api_error_date = date("Y-m-d H:i:s");
                            $Request_data = json_encode($_REQUEST);
                            // 
							   /*							
								$Company_result = lslDB::getInstance()->get_company_details($Company_id);
								$Company_details = mysqli_fetch_array($Company_result);
								$Order_no_series = $Company_details['Order_no_series'];
								$Evoucher_expiry_period = $Company_details['Evoucher_expiry_period'];
								$Cust_redeem_pin_validation = $Company_details['Cust_redeem_pin_validation'];
								$Cust_pin_validation = $Company_details['Cust_pin_validation'];
								$Pin_no_applicable = $Company_details['Pin_no_applicable'];
								*/
                            
                            
                           
                            $Member_pin1 = trim($this->string_decrypt($_REQUEST['Member_pin'], $key, $iv));
                            $pin_no = preg_replace("/[^(\x20-\x7f)]*/s", "", $Member_pin1);

							$Grand_Total_Points1 = trim($this->string_decrypt($_REQUEST['Grand_Total_Points'], $key, $iv));
                            $Grand_Total_Points = preg_replace("/[^(\x20-\x7f)]*/s", "", $Grand_Total_Points1);
                                                        
                            
							if($Check_member_exist == NULL)
                            {
                               echo json_encode(array("status" => "2003", "status_message" => "Membership ID not found"));die;
                            }                           
                            else if( ($Cust_pin_validation == 1)  && ($pin_no == "") )
                            {
                                echo json_encode(array("status" => "2025","status_message" => "Invalid Customer Pin Entered"));
                            }
                            else if( ($Cust_pin_validation == 1)  && ($pin_no != $member_pinno))
                            {
                                echo json_encode(array("status" => "2025","status_message" => "Invalid Customer Pin Entered"));
                            }
                            else
                            {

                                if($Check_member_exist->User_activated==0)
                                {
                                    echo json_encode(array("status" => "2004", "status_message" => "Membership Disabled / Inactive"));die;
                                }
								else if($Grand_Total_Points > $Available_current_balance)
								{
									echo json_encode(array("status" => "2014", "status_message" => "You Do Not have Enough Points Balance"));die;
								}
                                else
                                {
                                                                        
                                    $cart_result = $this->api_library->get_cart($Check_member_exist->Enrollement_id);
                                   
									$Cart_quantity = count($cart_result);
                                    $lv_Total_points = 0;
                                    $lv_total_shopping_points = 0;
                                    $Redemption_method123 = array();
                                    $item_array = array();
                                    $Remark_item_array = array();
                                    $DeliveryItem = array();
                                    $Notification_array = array();
									$Redemption_method=0;
                                    if($Cart_quantity > 0)
                                    {
                                        foreach($cart_result as $Catalogue)
                                        {
											$Seller_id=$Catalogue["Seller_id"];
											
											$get_enrollment = $this->Igain_model->get_enrollment_details($Seller_id);
											$Seller_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
											
											$Grand_Total_Redeem_points[]=$Catalogue["Total_points"];
												
												
											if($Catalogue["Size"] == 1)
											{
											  $item_size = "Small";
											}
											elseif($Catalogue["Size"] == 2)
											{
												$item_size = "Medium";
											}
											elseif($Catalogue["Size"] == 3)
											{
												$item_size = "Large";
											}
											elseif($Catalogue["Size"] == 4)
											{
												$item_size = "Extra Large";
											}
											elseif($Catalogue["Size"] == 0)
											{
												$item_size = "-";
											}
											$characters = 'A123B56C89';
											$string = '';
											$Voucher_no="";
											for ($i = 0; $i < 16; $i++) 
											{
												$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
											}
											if($Catalogue["Merchant_flag"]==1)
											{
												$Enroll_details = $this->Igain_model->get_enrollment_details($Catalogue['Seller_id']);
												
												$Merchant_name = $Enroll_details->First_name.' '.$Enroll_details->Last_name;		
											}
											else
											{
												$Merchant_name = "-";
											}
											$Notification_array[] = array
												(
													// $Grand_Total_Redeem_points2[]=$Catalogue["Total_points"],
													// "Grand_Total_Redeem_points2"=$Catalogue["Total_points"],
													"itemSize" => $item_size,
													"Merchant_name" => $Merchant_name,
													"Seller_id" => $Catalogue["Seller_id"],
													"Merchandize_item_name" => $Catalogue["Merchandize_item_name"],
													"Total_points" => $Catalogue["Total_points"],
													"Quantity" => $Catalogue["Quantity"],
													// "Total_points" => $Catalogue["Total_points"],
													"Voucher_no" =>$Voucher_no,														
													"Branch_name" => $Catalogue["Branch_name"],
													"Address" => $Catalogue["Address"]
													// "Avialable_balance" => $Available_current_balance
												);
											
											 $Insert = $this->api_library->Insert_Redeem_Items_at_Transaction($Company_id,$Catalogue["Total_points"],$Catalogue["Quantity"],$Seller_id,$Seller_name,$Check_member_exist->Enrollement_id,$Check_member_exist->Card_Id,$Catalogue["Item_code"],$Catalogue["Partner_id"],$Catalogue["Branch"],$Catalogue["Size"],$Voucher_no);				
											 
											$DeleteItem = $this->api_library->delete_item_catalogue($Catalogue["Item_code"],$Check_member_exist->Enrollement_id,$Company_id,$Catalogue["Branch"],$Catalogue["Size"]);
											
										}
										
										// print_r($Notification_array);
										
										$Insert = $this->api_library->Send_redemption_notification($Company_id,$Notification_array,$Check_member_exist->Enrollement_id);
									}									
									/************************Update Current balance & Total Redeems************
									$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
									$lv_Total_reddems=($data['Enroll_details']->Total_reddems+array_sum($Grand_Total_Redeem_points));
									$lv_Blocked_points=$data['Enroll_details']->Blocked_points;
									$Avialable_balance=($Current_balance-$lv_Blocked_points);
									$Update = $this->Redemption_Model->Update_Customer_Balance($Current_balance,$lv_Total_reddems,$data['enroll']);
									/*****************************************************************/
									echo json_encode(array("status" => "1001",  "Current_balance" => $New_Current_balance, "status_message" => "Success"));die;                                  
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(array("status" => "2006", "status_message" => "Kindly Enter your Membership ID"));die;
                        }
                    }
					/************************************Insert Catlogue Item or Redemption Item ********************************/
					
					
					
				}
				else
				{
					echo json_encode(array("status" => "2002", "status_message" => "Wrong Company Password"));
					exit;
				}
			}
			else
			{
				echo json_encode(array("status" => "2001", "status_message" => "Wrong Company Username"));
				exit;
			}
		}
		
		
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