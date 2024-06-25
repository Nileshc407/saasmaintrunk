<?php

class SubMerchantAccount extends CI_Controller
{
    public function __construct()
    {
    
        parent::__construct();
        
        $this->load->database();
        $this->load->helper('url');

        $this->load->model('Igain_model');
        $this->load->model('SubMerchantModel');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Send_notification');
        //include('http://localhost/CI_iGainSpark_Demo/braintree/Braintree.php');
        
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
                
            Braintree_Configuration::environment('sandbox');
            Braintree_Configuration::merchantId('jmh9kzqd8bvs5fwr');
            Braintree_Configuration::publicKey('khpp56hx3r4v4rdx');
            Braintree_Configuration::privateKey('f2a5e1885866d5e8d20d70adee331c3d');
    }
    
    public function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			
			$Logged_in_userid = $session_data['enroll'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
            
            $data['AllRows'] = $this->SubMerchantModel->get_all_submerchant_account($Company_id);
            
            $data['SubSellerList'] = $this->Igain_model->get_company_sellers($Company_id);
            
            /*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/SubMerchantAccount/";
			$total_row = $this->SubMerchantModel->Get_Company_SubMerchant_Count($Company_id);
			//echo "total_row ".$total_row;
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
            
            if($_POST == NULL)
			{
				$this->load->view('SubmerchantAccount/merchantAccount.php', $data);
			}
			else
			{
                $characters = '0123456789';
                $aNo = '';
                for ($i = 0; $i < 4; $i++) 
                {
                    $aNo .= $characters[mt_rand(0, strlen($characters) - 1)];
                }

                $ID = preg_replace('/\s+/', '',$this->input->post('legalName'))."_".$aNo;
                
                // echo "ID is-----------".$ID."<br>";
                
                $merchantAccountParams = [
                                          'individual' => [
                                            'firstName' => $this->input->post('firstName'),
                                            'lastName' => $this->input->post('lastName'),
                                            'email' => $this->input->post('email'),
                                            'phone' => $this->input->post('phone'),
                                            'dateOfBirth' => date("Y-m-d",strtotime($this->input->post('dateOfBirth'))),
                                            'ssn' => $this->input->post('ssn'),
                                            'address' => [
                                              'streetAddress' => $this->input->post('streetAddress'),
                                              'locality' => $this->input->post('locality'),
                                              'region' => $this->input->post('region'),
                                              'postalCode' => $this->input->post('postalCode')
                                            ]
                                          ],
                                          'business' => [
                                            'legalName' => $this->input->post('legalName'),
                                            'dbaName' => $this->input->post('dbaName'),
                                            'taxId' =>  $this->input->post('taxId'),
                                            'address' => [
                                              'streetAddress' =>  $this->input->post('bstreetAddress'),
                                              'locality' =>  $this->input->post('blocality'),
                                              'region' => $this->input->post('bregion'),
                                              'postalCode' =>  $this->input->post('bpostalCode')
                                            ]
                                          ],
                                          'funding' => [
                                            'descriptor' =>  $this->input->post('descriptor'),
                                            'destination' =>  'bank',
                                             // 'email' => $this->input->post('femail'),
                                            //  'mobilePhone' => $this->input->post('mobilePhone'),
                                            'accountNumber' =>  $this->input->post('accountNumber'),
                                            'routingNumber' =>  $this->input->post('routingNumber')
                                          ],
                                          'tosAccepted' =>  $this->input->post('tosAccepted'),
                                          'masterMerchantAccountId' => 'miraclecartes',
                                          'id' => $ID
                                        ];
                
                      //  print_r($merchantAccountParams);
                        
                        //$success = true;
                        
                                    $result = Braintree_MerchantAccount::create($merchantAccountParams);
                                    $success = $result->success;
                                    // true
                                    echo "success-----------".$success."<br>";
                
                                    $merchantAccount_status = $result->merchantAccount->status;
                                    // "pending"
                                    echo "merchantAccount_status-----------".$merchantAccount_status."<br>";

                                    $merchantAccount_id = $result->merchantAccount->id;
                                    // "blue_ladders_store"
                                    echo "merchantAccount_id-----------".$merchantAccount_id."<br>";

                                    $masterMerchantAccount_id = $result->merchantAccount->masterMerchantAccount->id;
                                    // "14ladders_marketplace"
                                    echo "masterMerchantAccount_id-----------".$masterMerchantAccount_id."<br>";

                                    $masterMerchantAccount_status = $result->merchantAccount->masterMerchantAccount->status;
                                    echo "masterMerchantAccount_status-----------".$masterMerchantAccount_status."<br>";
                
                        
                
                    if($success == true || $success == 1)
                    {
                        $insertMerchant = $this->SubMerchantModel->Create_SubMerchantAccount($ID,$Company_id);
                        
                        if($insertMerchant == true)
                        {
                            $this->session->set_flashdata("merchant_error_code","Sub Merchant Created Successfully!!");
                        }
                        else
                        {							
                            $this->session->set_flashdata("merchant_error_code","Error IN Sub Merchant Registration !");
                        }
                       
                       
                    }
                    else
                    {
                            $errors = '';
	
                            foreach($result->errors->deepAll() AS $error) 
                            {
                                //print_r($error->code . ": " . $error->message . ",");

                                    $errors .= $error->message.", ";

                            }
	
	                      $this->session->set_flashdata("merchant_error_code",$errors);
                    }
                
               // die;
                 redirect(current_url());
                
            }
			
        }
        
    }
    
    
    public function edit_submerchant_account()
    {
        if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			
			$Logged_in_userid = $session_data['enroll'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
            
            $data['AllRows'] = $this->SubMerchantModel->get_all_submerchant_account($Company_id);
            
            $data['SubSellerList'] = $this->Igain_model->get_company_sellers($Company_id);
            
            
            /*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/SubMerchantAccount/";
			$total_row = $this->SubMerchantModel->Get_Company_SubMerchant_Count($Company_id);
			//echo "total_row ".$total_row;
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
            
            if($_REQUEST == NULL)
			{
				$this->load->view('SubmerchantAccount/merchantAccount.php', $data);
			}
			else if($_REQUEST['merchant_id'] > 0)
			{
                   
                 $data['SubMerchant'] = $this->SubMerchantModel->Edit_SubMerchantAccount($_GET['merchant_id'],$Company_id);

                if($data['SubMerchant'] != false)
                {
                  
                    $this->load->view('SubmerchantAccount/EditmerchantAccount.php', $data);
                }
                else
                {							
                    $this->session->set_flashdata("merchant_error_code","Error IN Edit Sub Merchant Details!");
                    
                    $this->load->view('SubmerchantAccount/merchantAccount.php', $data);
                }
  
            }
            else if($_REQUEST['M_id'] > 0)
            {
                
                 $merchantAccountParams = [ $ID,[
                                          'individual' => [
                                            'firstName' => $this->input->post('firstName'),
                                            'lastName' => $this->input->post('lastName'),
                                            'email' => $this->input->post('email'),
                                            'phone' => $this->input->post('phone'),
                                            'dateOfBirth' => $this->input->post('dateOfBirth'),
                                            'ssn' => $this->input->post('ssn'),
                                            'address' => [
                                              'streetAddress' => $this->input->post('streetAddress'),
                                              'locality' => $this->input->post('locality'),
                                              'region' => $this->input->post('region'),
                                              'postalCode' => $this->input->post('postalCode')
                                            ]
                                          ],
                                          'business' => [
                                            'legalName' => $this->input->post('legalName'),
                                            'dbaName' => $this->input->post('dbaName'),
                                            'taxId' =>  $this->input->post('taxId'),
                                            'address' => [
                                              'streetAddress' =>  $this->input->post('bstreetAddress'),
                                              'locality' =>  $this->input->post('blocality'),
                                              'region' => $this->input->post('bregion'),
                                              'postalCode' =>  $this->input->post('bpostalCode')
                                            ]
                                          ],
                                          'funding' => [
                                            'descriptor' =>  $this->input->post('descriptor'),
                                            'destination' =>  'bank',
                                             // 'email' => $this->input->post('femail'),
                                            //  'mobilePhone' => $this->input->post('mobilePhone'),
                                            'accountNumber' =>  $this->input->post('accountNumber'),
                                            'routingNumber' =>  $this->input->post('routingNumber')
                                          ],
                                          'tosAccepted' =>  $this->input->post('tosAccepted'),
                                          'masterMerchantAccountId' => 'miraclecartes',
                                    
                                        ]
                                    ];
                
                       // print_r($merchantAccountParams);
                
                $result = Braintree_MerchantAccount::update($merchantAccountParams);
                
                $success = $result->success;
                
               // $success = true;
                   // if ($result->success)
                    if ($success == true)
                    {
                        $updateMerchant = $this->SubMerchantModel->Update_SubMerchantAccount($_REQUEST['M_id'],$Company_id);
                        

                        if($updateMerchant == true)
                        {
                            $this->session->set_flashdata("merchant_error_code","Sub Merchant Updated Successfully!!");
                        }
                        else
                        {							
                            $this->session->set_flashdata("merchant_error_code","Error IN Sub Merchant Edit !");
                        }
                    }
                    else 
                    {
                      $this->session->set_flashdata("merchant_error_code",$result->errors);
                    }
                
                  redirect(current_url());
            }
			
        }
        
    }
    
    public function delete_submerchant_account()
    {
        if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			
			$Logged_in_userid = $session_data['enroll'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
            
            
            $data['SubSellerList'] = $this->Igain_model->get_company_sellers($Company_id);
            
            
            /*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/SubMerchantAccount/";
			$total_row = $this->SubMerchantModel->Get_Company_SubMerchant_Count($Company_id);
			//echo "total_row ".$total_row;
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
            
            if($_GET == NULL)
			{
                    $data['AllRows'] = $this->SubMerchantModel->get_all_submerchant_account($Company_id);
                
				$this->load->view('SubmerchantAccount/merchantAccount.php', $data);
			}
			else
			{
                    if($_GET['merchant_id'] > 0)
                    {
                         $deleteMerchant = $this->SubMerchantModel->Delete_SubMerchantAccount($_GET['merchant_id'],$Company_id);
                        
                        $data['AllRows'] = $this->SubMerchantModel->get_all_submerchant_account($Company_id);

                        if($deleteMerchant == true)
                        {
                            $this->session->set_flashdata("merchant_error_code","Sub Merchant Deleted Successfully!!");
                        }
                        else
                        {							
                            $this->session->set_flashdata("merchant_error_code","Error IN Sub Merchant Delete !");
                        }


                    }
                
                 redirect(current_url());
                
            }
			
        }
        
    }
    
    

}

?>