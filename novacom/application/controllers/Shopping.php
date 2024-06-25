<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Shopping extends CI_Controller 
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
		$this->load->model('Igain_model');
		$this->load->library('cart');
		$this->load->model('shopping/Shopping_model');
		$this->load->library('Multicart/udp_cart');
		$this->wishlist = new Udp_cart("wishlist");
		$this->load->helper('string');
		$this->load->library('Send_notification');
        $this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->helper(array('form', 'url','encryption_val'));	
         
		/**********************Master Merchant**********************	 
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
                Braintree_Configuration::merchantId('dncf7k2zmbv3x3j9');
                Braintree_Configuration::publicKey('2s7h95c6h6xzqzp4');
                Braintree_Configuration::privateKey('c54f58cd42a769912a7902632f60c796');
			/**********************Master Merchant**********************/
			


			if($this->session->userdata('cust_logged_in'))
			{
				$session_data = $this->session->userdata('cust_logged_in');
				$data['username'] = $session_data['username'];
				$data['enroll'] = $session_data['enroll'];
				$data['userId']= $session_data['userId'];
				$data['Card_id']= $session_data['Card_id'];
				$data['Company_id']= $session_data['Company_id'];
	
				$Company_Details= $this->Igain_model->get_company_details($session_data['Company_id']);
				$this->key=$Company_Details->Company_encryptionkey;
				$this->API_key = $Company_Details->Company_api_encryptionkey;
				$this->OnlineOrderAPI_key = $Company_Details->Company_orderapi_encryptionkey;
				
			}	
			
			//echo"---__construct---Company_id---------".$data['Company_id']."----<br>";
			//echo"---__construct---key---------".$this->key."----<br>";
	
				$this->iv = '56666852251557009888889955123458';
				
				$data['key']=$this->key;
				$data['iv']=$this->iv;
			// die;

	}	
	/************************************************Akshay Start***********************************************/
	function index()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$data['shopping_products'] = $this->Shopping_model->get_all_products($data['Company_id']);
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );			
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
			
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($data['Company_id']);
			
			$Merchandize_category_id=0;
			$Sort_by=0;
			$Sort_by_merchant=0;
			$Sort_by_brand=0;
			$Sort_by_gender=0;
			$Sort_by_name='';
			
			if(isset($_REQUEST["Sort_by_points_flag"]))
			{
				$Sort_by=$_REQUEST["Sort_by_points_flag"];
			}
			if(isset($_REQUEST["Sort_by_category_flag"]))  
			{
				$Merchandize_category_id=$_REQUEST["Sort_by_category_flag"];
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
			if(isset($_REQUEST["Sort_by_item_name"]))
			{
				$Sort_by_name=$_REQUEST["Sort_by_item_name"];
			} 
			
			/*-----------------------Pagination---------------------*/			
                $config = array();
				$config["base_url"] = base_url() . "/index.php/Shopping/index";
				$total_row = $this->Shopping_model->Get_Merchandize_ecommerce_Items_Count($data['Company_id']);
				$config["total_rows"] = $total_row;
				$config["per_page"] = 12;
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
			
			$Redemption_Items = $this->Shopping_model->get_all_items($config["per_page"],$page,$data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_name);
			$data['count4'] = count($Redemption_Items);
            $data['Redemption_Items'] = $Redemption_Items;
			if($Redemption_Items != NULL)
			{
				foreach ($Redemption_Items as $product)
				{
					$itemCode = $product['Company_merchandize_item_code'];
					$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
					
					$itemID= $product['Company_merchandise_item_id'];
					$Redemption_Items_offers_array[$product['Company_merchandise_item_id']] = $this->Shopping_model->get_all_offers_items($itemID,$product['Company_id']);
					
					$data["Redemption_Items_offers_array"] = $Redemption_Items_offers_array;
				}
				// var_dump($data["Redemption_Items_offers_array"]);die;
				$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
				$data['Redemption_Items_offers'] = $Redemption_Items_offers_array;
				$Item_array=$data['Redemption_Items'];
			}
                        
                $data['Product_brands'] = $this->Shopping_model->fetch_product_brands($data['Company_id']);
				$data['Max_price'] = $this->Shopping_model->fetch_max_price($data['Company_id']);
				$data['Min_price'] = $this->Shopping_model->fetch_min_price($data['Company_id']);
                        
				$get_all_products = $this->Shopping_model->get_all_products($data['Company_id']);
                $data['numitems'] = count($get_all_products);
                        
                        foreach ($data["Merchandize_category"] as $MerchandizeCat)
                        {
                            $MerchandizeCatId[] = $MerchandizeCat->Merchandize_category_id;
                        }                        
                        $data['MerchandizeCatId'] = json_encode($MerchandizeCatId);                        
			
                       
			$data["Sellers"] =$this->Igain_model->Fetch_All_Merchants($data['Company_id']);
			$data["Item_brand"] = $this->Redemption_Model->Get_Merchandize_item_brand($data['Company_id']);
			
			$data['Sort_by'] = $Sort_by;
            $data['Category_filter'] = $Merchandize_category_id;
            $data['Merchant_filter'] = $Sort_by_merchant;
            $data['brand_filter'] = $Sort_by_brand;
			
		/********** check api availability 16-09-2019 sandeep ************
			$input_args01 = json_encode(array("HandShakeFlag" => 1));
			
			$url = ""; //$Seller_api_url;

			$ch = curl_init();
			$timeout = 0; // Set 0 for no timeout.
			curl_setopt($ch, CURLOPT_URL, $url);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$input_args01);
			//set the content type to application/json
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Flag '.$this->OnlineOrderAPI_key,'Content-Type:application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$result01 = curl_exec($ch);
			curl_close($ch);
			// echo "key response--".$this->OnlineOrderAPI_key."<br>";
		//	 echo "POS response--".$result."<br>";

			$response01 = json_decode($result01, true);
		//	print_r($response01);		
		********** check api availability 16-09-2019 sandeep ************/	

			$this->load->view('Shopping/shopping', $data);		
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
        
        function load_more()
        {
            $Company_id = $this->input->post("Company_id");
            $PriceFrom = $this->input->post("PriceFrom");
            $PriceTo = $this->input->post("PriceTo");	
            $Sort_by = $this->input->post("Sort_by");		
            $Sort_category = $this->input->post("Sort_category");
            
            if($this->input->post("Sort_by") == "")
            {
                $Sort_by=0;
            }
            
            if($this->input->post("Sort_category") == "")
            {
                $Sort_by=0;
            }
            
            $Company_details = $this->Igain_model->Fetch_Company_Details($this->input->post("Company_id"));
            foreach($Company_details as $Company)
            {
                    $Country = $Company['Country'];
            }
            $Country_details = $this->Igain_model->get_dial_code($Country );
            $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
            
            if ( $this->input->post("page") != "" || $this->input->post("page") != NULL ) 
            {
                $currentpage = $this->input->post("page");
            }
            
            $item_per_page = 3;
            
            $Redemption_Items2 = $this->Shopping_model->filter_result($Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);
            $numrows = count($Redemption_Items2);
            
            $totalpages = ceil($numrows / $item_per_page);
            
            if($this->input->post("page") != "")
            {
                $currentpage = (int) $this->input->post("page");
            }
            else
            {
                $currentpage = 1;
            }
            
            if ($currentpage > $totalpages) 
            {
                $currentpage = $totalpages;
            }
            
            if ($currentpage < 1) 
            {
                $currentpage = 1;
            }
            
            $offset = ($currentpage - 1) * $item_per_page;
            
            $Redemption_Items = $this->Shopping_model->filter_result2($item_per_page,$offset,$Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);
            $count4 = count($Redemption_Items);
            
            //if($Redemption_Items != NULL)
            if($count4 > 0)
            {
                $data['Filter_result'] = $Redemption_Items;
                $theHTMLResponse = $this->load->view('Shopping/load_more', $data, true);		
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('load_more_result'=> $theHTMLResponse, 'currentpage' => $currentpage, 'totalpages' => $totalpages )));
            }
            else
            {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('load_more_result'=> '', 'currentpage' => $currentpage, 'totalpages' => $totalpages )));
            }
        }
                
    function filter_result()
	{
            $PriceFrom = $this->input->post("PriceFrom");
            $PriceTo = $this->input->post("PriceTo");		
            $Company_id = $this->input->post("Company_id");		
            $Sort_by = $this->input->post("Sort_by");		
            $Sort_category = $this->input->post("Sort_category");

            if ( $this->input->post("page") != "" || $this->input->post("page") != NULL ) 
            {
                $currentpage = $this->input->post("page");
            }

            $item_per_page = 8;

            $Redemption_Items = $this->Shopping_model->filter_result($Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);
            $numrows = count($Redemption_Items);

            $totalpages = ceil($numrows / $item_per_page);

            if($this->input->post("page") != "")
            {
                $currentpage = (int) $this->input->post("page");
            }
            else
            {
                $currentpage = 1;
            }

            if ($currentpage > $totalpages) 
            {
                $currentpage = $totalpages;
            }

            if ($currentpage == $totalpages) 
            {
                $currentpage = 1;
            }

            if ($currentpage < 1) 
            {
                $currentpage = 1;
            }
            
            if ($currentpage == $totalpages) 
            {
                $offset = 0;
                $item_per_page = $currentpage - 1;
            }
            else
            {
                $offset = ($currentpage - 1) * $item_per_page;
            }

            $data['Filter_result'] = $this->Shopping_model->filter_result2($item_per_page,$offset,$Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);

            $Company_details = $this->Igain_model->Fetch_Company_Details($this->input->post("Company_id"));
            foreach($Company_details as $Company)
            {
                    $Country = $Company['Country'];
            }
            $Country_details = $this->Igain_model->get_dial_code($Country );
            $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
			
			/*****************ravi*******************/
			// get_all_items($config["per_page"],$page,$data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender);
			
			
			$Redemption_Items1 = $this->Shopping_model->get_all_items(0,0,$Company_id,$Sort_category,$Sort_by,0,0,0,'');
			   $data['count4'] = count($Redemption_Items1);
						$data['Redemption_Items'] = $Redemption_Items1;
			if($Redemption_Items1 != NULL)
			{
				foreach ($Redemption_Items1 as $product)
				{
				 $itemCode = $product['Company_merchandize_item_code'];
				 $Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
				 
				 $itemID= $product['Company_merchandise_item_id'];
				 $Redemption_Items_offers_array[$product['Company_merchandise_item_id']] = $this->Shopping_model->get_all_offers_items($itemID,$product['Company_id']);
				 
				 $data["Redemption_Items_offers_array"] = $Redemption_Items_offers_array;
				}    
				$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
				$data['Redemption_Items_offers'] = $Redemption_Items_offers_array;
				$Item_array=$data['Redemption_Items'];
			}
			/*****************ravi*******************/

            $theHTMLResponse = $this->load->view('Shopping/filtered_result', $data, true);		
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('filtered_result'=> $theHTMLResponse, 'currentpage' => $currentpage, 'totalpages' => $totalpages )));
	}
	
	function Shopping_category_products()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
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
			
			$Product_group = $_GET['Product_group'];
			
			$data['Product_groups'] = $this->Shopping_model->fetch_product_group();
			$data['Product_brands'] = $this->Shopping_model->fetch_product_brands($data['Company_id'],$Product_group);
			// $data['Product_colors'] = $this->Shopping_model->fetch_product_colors($Product_group);
			
			$data['Product_group_details'] = $this->Shopping_model->fetch_product_group_details($Product_group);
			$data['Shopping_category_products'] = $this->Shopping_model->fetch_shopping_category_products($Product_group,$data['Company_id']);
			$data['Max_price'] = $this->Shopping_model->fetch_max_price($Product_group,$data['Company_id']);
			$data['Min_price'] = $this->Shopping_model->fetch_min_price($Product_group,$data['Company_id']);

			$this->load->view('Shopping/Shopping_category_products', $data);		
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function add_to_cart()
	{ 
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];
		$Company_id = $session_data['Company_id'];
		
		
		$data['Merchandise_item_id']=$_REQUEST['id'];
		$data['Merchandize_item_name']=$_REQUEST['Item_name'];
		$data['price']=$_REQUEST['price'];
		$data['Delivery_method']=$_REQUEST['Delivery_method'];
		$data['Branch']=$_REQUEST['Branch'];
		$data['Item_size']=$_REQUEST['Item_size'];
		$data['Item_Weight']=$_REQUEST['Item_Weight'];
		$data['Weight_unit_id']=$_REQUEST['Weight_unit_id'];
		$data['Partner_id']=$_REQUEST['Partner_id'];
		$data['Partner_state']=$_REQUEST['Partner_state'];
		$data['Partner_Country_id']=$_REQUEST['Partner_Country_id'];
		$data['Seller_id']=$_REQUEST['Seller_id'];
		$data['Merchant_flag']=$_REQUEST['Merchant_flag'];
		$data['Cost_price']=$_REQUEST['Cost_price'];
		$data['VAT']=$_REQUEST['VAT'];
		$data['Product_category_id']=$_REQUEST['Product_category_id'];
		$data['Item_code']=$_REQUEST['Item_code'];  
		
		$Item_code = $_REQUEST['Item_code']; //echo $data['Item_code']."<br>";
		
		//************** sandeep ********************************
		
		$optional_condimentType = 15;
		$required_condimentType = 14;
		
		
		$required_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($data['Item_code'],$Company_id,$required_condimentType);
		
		//print_r($required_condiments);

		if($required_condiments != NULL && count($required_condiments) > 0)
		{
			$grpCode = NULL;
			
			foreach($required_condiments as $opt)
			{
				if($grpCode != $opt->Group_code)
				{
					$values = [];
					
					$Grp_questionss = $this->Shopping_model->get_req_optional_condiment_que($opt->Group_code,$required_condimentType,$Company_id);
					
					foreach($Grp_questionss as $b10)
					{
						$Grp_question = $b10['Label'];
					}
			//	echo "--que--".$Grp_question."--<br>";
					foreach($required_condiments as $opt66)
					{
						if($opt->Group_code == $opt66->Group_code && $opt66->Condiment_item_code != "")
						{
					//		echo " grp Condiment_item_code code--".$opt66->Condiment_item_code."<br>";
							
							$RrsValues = $this->Shopping_model->Get_merchandize_item12($opt66->Condiment_item_code,$Company_id);
							
							$values[] = $RrsValues;
						}
					}
				
					$prepare_req_condiments[$Item_code][$Grp_question] = $values;
				
				}
				
				$grpCode = $opt->Group_code;
			}
			
		//	$prepare_req_condiments[$Item_code]["question"] = $Grp_question;
			//$prepare_req_condiments[$Item_code]["ans"] = $values;
		}
		
		$optional_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($data['Item_code'],$Company_id,$optional_condimentType);

		if($optional_condiments != NULL && count($optional_condiments) > 0)
		{
			$grpCode = NULL;
			
			foreach($optional_condiments as $opt)
			{
	
				if($grpCode != $opt->Group_code)
				{
					$values = [];
					
					$Grp_questionss = $this->Shopping_model->get_req_optional_condiment_que($opt->Group_code,$optional_condimentType,$Company_id);
					
					foreach($Grp_questionss as $b10)
					{
						$Grp_question = $b10['Label'];
					}

					foreach($optional_condiments as $opt66)
					{
						if($opt->Group_code == $opt66->Group_code && $opt66->Condiment_item_code != "")
						{
					//		echo " grp Condiment_item_code code--".$opt66->Condiment_item_code."<br>";
							
							$RrsValues = $this->Shopping_model->Get_merchandize_item12($opt66->Condiment_item_code,$Company_id);
							
							$values[] = $RrsValues;
						}
					}
				
					$prepare_opt_condiments[$Item_code][$Grp_question] = $values;
				
				}
				
				$grpCode = $opt->Group_code;
			}

		}
		
		$SideItemsResult = $this->Shopping_model->get_side_items($Item_code,$Company_id);
		
			foreach($SideItemsResult as $b3)
			{
				$SideCategoryID = $b3["Main_or_side_item_code"];
				$SideCategoryName = $b3["Merchandize_category_name"];
				$SideQuestion = $b3["Side_label"];
				$Side_values = [];
				//echo $SideCategoryName."--que--".$SideQuestion;
				
				$SideItemOptions = $this->Shopping_model->get_side_item_options($Item_code,$Company_id,$SideCategoryID);
				
				if($SideItemOptions != NULL)
				{	
					foreach($SideItemOptions as $v)
					{
						$Side_values[] = array("Item_code" => $v['Side_group_item_code'], "Item_name" => $v['Merchandize_item_name'],"Item_qty" => $v["Quanity"],"Item_rate" => $v["Price"]);
					}
					
					$SideCondiments[$Item_code][$SideQuestion] = $Side_values;
				
					foreach($SideItemOptions as $v)
					{
					$side_required_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($v['Side_group_item_code'],$Company_id,$required_condimentType);
		
					//print_r($required_condiments);

						if($side_required_condiments != NULL && count($side_required_condiments) > 0)
						{
							$values1 = [];
							$p = 0;
							
							foreach($side_required_condiments as $opt)
							{
								if($p == 0)
								{
									$SideQuestionArr = $this->Shopping_model->get_req_optional_condiment_que($opt->Group_code,$required_condimentType,$Company_id);
									
									foreach($SideQuestionArr as $b4)
									{
										$SideQuestion = $b4['Label'];
									}
								}
								
								if($opt->Group_code != "" && $opt->Condiment_item_code != "")
								{
									$RrsValues1 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
									
									$values1[] =   array("Item_code" => $RrsValues1->Company_merchandize_item_code, "Item_name" => $RrsValues1->Merchandize_item_name,"Item_qty" => 1,"Item_rate" => 0);
								}
								
								$p++;
							}
							
					/* 		echo "<br>side item--".$v['Side_group_item_code']."<br>";
							echo "side item que--".$SideQuestion."<br>";
							echo "side item ans--<br>";print_r($values1); */
							
							$SideCondiments[$Item_code][$SideQuestion] = $values1;
							
							if($SideQuestion != NULL)
							{
								break;
							}
						}
						
						
					}
				
					foreach($SideItemOptions as $v)
					{	
						$side_optional_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($v['Side_group_item_code'],$Company_id,$optional_condimentType);
						
						if($side_optional_condiments != NULL && count($side_optional_condiments) > 0)
						{
							$values3 = [];
							$q = 0;
							
							foreach($side_optional_condiments as $opt)
							{
								if($q == 0)
								{
									$SideQuestionArr2 = $this->Shopping_model->get_req_optional_condiment_que($opt->Group_code,$optional_condimentType,$Company_id);
									
									foreach($SideQuestionArr2 as $b5)
									{
										$SideQuestion = $b5['Label'];
									}
								}
								
								if($opt->Group_code != "" && $opt->Condiment_item_code != "")
								{
									$RrsValues3 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
									
									$values3[] = array("Item_code" => $RrsValues3->Company_merchandize_item_code, "Item_name" => $RrsValues3->Merchandize_item_name,"Item_qty" => 1,"Item_rate" => 0);
								}
								
								$q++;
							}
							
							$SideCondiments[$Item_code][$SideQuestion] = $values3;
							
							if($SideQuestion != NULL)
							{
								break;
							}
						}
					}
				}
			}
			
		
		//**** main item condiments **************
		$grpCode = NULL;
		
		$MainItemInfoData = $this->Shopping_model->get_main_item($data["Item_code"],$Company_id);
		foreach($MainItemInfoData as $MainItemInfo)
		{
	//		echo "Main_or_side_item_code--". $MainItemInfo['Main_or_side_item_code'];

			$Main_item_code = $MainItemInfo['Main_or_side_item_code'];

			$main_required_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($Main_item_code,$Company_id,$required_condimentType);
			
		///	print_r($main_required_condiments);

			if($main_required_condiments != NULL && count($main_required_condiments) > 0)
			{
				$values = [];
				$p = 0;

				foreach($main_required_condiments as $opt)
				{
					if($p == 0 && $grpCode != $opt->Group_code)
					{
						$Grp_questionsAre = $this->Shopping_model->get_req_optional_condiment_que($opt->Group_code,$required_condimentType,$Company_id);
					
							foreach($Grp_questionsAre as $b10)
							{
								$Grp_question = $b10['Label'];
							}
					}
					
					if($opt->Group_code != "" && $opt->Condiment_item_code != "")
					{
						$RrsValues = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
						
						$values[] = $RrsValues;
					}
					
					$p++;
					$grpCode = $opt->Group_code;
				}
		//		echo "Grp_question--". $Grp_question . PHP_EOL;
			//	print_r($values);
				
				$main_prepare_req_condiments[$Main_item_code][$Grp_question] = $values;
				//$main_prepare_req_condiments[$Main_item_code]["question"] = $Grp_question;
				//$main_prepare_req_condiments[$Main_item_code]["ans"] = $values;
			}
			
			$main_optional_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($Main_item_code,$Company_id,$optional_condimentType);
			
			if($main_optional_condiments != NULL && count($main_optional_condiments) > 0)
			{
				$values45 = [];
				$q = 0;
				
				foreach($main_optional_condiments as $opt)
				{
					if($q == 0 && $grpCode != $opt->Group_code)
					{
						$Grp_questionsAre = $this->Shopping_model->get_req_optional_condiment_que($opt->Group_code,$optional_condimentType,$Company_id);
						
						foreach($Grp_questionsAre as $b11)
							{
								$Grp_question = $b11['Label'];
							}
					}
					
					if($opt->Group_code != "" && $opt->Condiment_item_code != "" )
					{
						$RrsValues = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
						
						$values45[] = $RrsValues;
					}
					
					$q++;
					$grpCode = $opt->Group_code;
				}
				
				$main_prepare_opt_condiments[$Main_item_code][$Grp_question] = $values45;
			//	$main_prepare_opt_condiments[$Main_item_code]["question"] = $Grp_question;
			//	$main_prepare_opt_condiments[$Main_item_code]["ans"] = $values;
			}
			
			if($grpCode != NULL)
			{
				break;
			}
		}
		$Mainvalues = [];
		foreach($MainItemInfoData as $MainItemInfo)
		{
		//echo "Main_or_side_item_code--". $MainItemInfo['Main_or_side_item_code'];

			$Main_item_code = $MainItemInfo['Main_or_side_item_code'];
			
			$RrsValuesMain = $this->Shopping_model->Get_merchandize_item12($Main_item_code,$Company_id);
			$MainItmQuestion = $MainItemInfo['Side_label'];	
			$RrsValuesMain->Billing_price = $MainItemInfo['Price'];	
			$Mainvalues[] = $RrsValuesMain;
		}
			if(count($Mainvalues) > 0)
			{
				$MainItemQuestions[$MainItmQuestion] = $Mainvalues;
			}
		//**** main item condiments **************
		
	 //	echo "<br>main item req condi array--<br>";
	//	print_r($main_prepare_req_condiments);
		/*
		echo "<br>main item optional condi array--<br>";
		print_r($main_prepare_opt_condiments); */
		//die;
 	// 	echo "<br>req condi array--<br>";
	//	print_r($prepare_req_condiments);
		
	//	echo "<br>optional condi array--<br>";
	//	print_r($prepare_opt_condiments);
	 
 	/* echo "<br>sides condi array--<br>";
		print_r($SideCondiments);
		die;
		 */
		if($prepare_req_condiments !=NULL || $prepare_opt_condiments != NULL || $SideCondiments != NULL)
		{
			$data["prepare_opt_condiments"] = $prepare_opt_condiments;
			$data["prepare_req_condiments"] = $prepare_req_condiments;
			
			$data["MainItemQuestions"] = $MainItemQuestions;
			$data["main_prepare_opt_condiments"] = $main_prepare_opt_condiments;
			$data["main_prepare_req_condiments"] = $main_prepare_req_condiments;
			
			$data["Prepare_side_condiments"] = $SideCondiments;
			$data["Prepare_sideItems_condiments"] = $SideChildCondiments;
		
			$theHTMLResponse = $this->load->view('Shopping/Show_condiments_details', $data, true);		
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
		}
		else
		{	
			$data2 = array(
				 'id' => $_REQUEST['id'],
				 'qty' => 1,
				 'price' =>$_REQUEST['price'],
				 'Item_category_id' => $_REQUEST["Product_category_id"],
				 'options' => array('Company_merchandize_item_code' => $_REQUEST["Item_code"],'Item_image1' => $_REQUEST["Item_image1"],'E_commerce_flag' => 1,'Redemption_method' => 29,'Branch' => $_REQUEST["Branch"],'Item_size' => $_REQUEST["Item_size"],'Item_Weight' => $_REQUEST["Item_Weight"],'Weight_unit_id' => $_REQUEST["Weight_unit_id"],'Partner_id' => $_REQUEST["Partner_id"],'Partner_Country_id' => $_REQUEST["Partner_Country_id"],'Partner_state' => $_REQUEST["Partner_state"],'Seller_id'  => $_REQUEST["Seller_id"],'Merchant_flag' => $_REQUEST["Merchant_flag"],'Cost_price' => $_REQUEST["Cost_price"],'VAT' => $_REQUEST["VAT"]),
				 'name' => $_REQUEST['name']
			   );
			   
			$result = $this->cart->insert($data2);
			// echo $this->db->last_query();
			$cart_check = $this->cart->contents();
			$grand_total = 0;
			if ($cart = $this->cart->contents()) 
			{								
				foreach ($cart as $item)
				{
					$grand_total = $grand_total + $item['subtotal'];
				}
			}
					
			if($result)
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => number_format($grand_total, 2))));
			}
			else    
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => number_format($grand_total, 2))));
			}
		}
	}
	
	public function add_to_cart_with_condiments()
	{ 
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];
		$Company_id = $data['Company_id'];
		
		$Required_Condiments_set = $_REQUEST['Required_Condiments_set'];
		$Condiments_set6_optional = $_REQUEST['Condiments_set6_optional'];
		$Condiments_Sides_set = $_REQUEST['Condiments_Sides_set'];
		$Selected_Main_Item = $_REQUEST['Selected_Main_Item'];
		$MainCondiments_set_optional = $_REQUEST['MainCondiments_set_optional'];
		$MainRequired_Condiments_set = $_REQUEST['MainRequired_Condiments_set'];
		
		$itemCondiments_name = "";
		$itemCondiments_code = "";
	/* 	echo "<br>Required_Condiments_set--".$Required_Condiments_set;
		echo "<br>Condiments_set6_optional--".$Condiments_set6_optional;
		echo "<br>Condiments_Sides_set--<br>"; print_r($Condiments_Sides_set);
	MainCondiments_set_optional,MainRequired_Condiments_set
	 */
	 
		
		if($Required_Condiments_set != NULL)
		{
			foreach($Required_Condiments_set as $Condiments_code7)
			{
			//	$Condiments_set = $this->Shopping_model->get_condiments_item_name($Condiments_code6,$data['Company_id']);
			//	$Condiments_name6 = $Condiments_set->condiments_name;

				$set7 = explode(":",$Condiments_code7);
				$code7 = $set7[0];
				$name7 = $set7[1];

				$reqCondiments = array("Item_code"=>$code7,"Item_qty"=>1,"Item_rate"=>0,"ParentItem_code"=>$_REQUEST["Item_code"]); //"Item_name"=>$name7,
				$Required_CondimentsCode[] = $reqCondiments;
				
				if($itemCondiments_name == "")
				{
					$itemCondiments_name = $name7;
				}
				else{
				$itemCondiments_name .= "+".$name7;
				}
				
				if($itemCondiments_code == "")
				{
					$itemCondiments_code = $code7;
				}
				else{
				$itemCondiments_code .= "+".$code7;
				}
			}

		}
		else
		{
			$Required_CondimentsCode = [];
		}
	//	print_r($Required_CondimentsCode); echo "<br>";
		$Condiments_code6="";
		$Condiments_name6="";
		
		if($Condiments_set6_optional != NULL)
		{
			foreach($Condiments_set6_optional as $Condiments_code6)
			{
			//	$Condiments_set = $this->Shopping_model->get_condiments_item_name($Condiments_code6,$data['Company_id']);
			//	$Condiments_name6 = $Condiments_set->condiments_name;

				$set6 = explode(":",$Condiments_code6);
				$code6 = $set6[0];
				$name6 = $set6[1];
		
				$OptionalCondiments = array("Item_code"=>$code6,"Item_qty"=>1,"Item_rate"=>0,"ParentItem_code"=>$_REQUEST["Item_code"]); //"Item_name"=>$name6,
				$Optional_CondimentsCode[] = $OptionalCondiments;
				
				if($itemCondiments_name == "")
				{
					$itemCondiments_name = $name6;
				}
				else{
				$itemCondiments_name .= "+".$name6;
				}
				
				if($itemCondiments_code == "")
				{
					$itemCondiments_code = $code6;
				}
				else{
				$itemCondiments_code .= "+".$code6;
				}
			}

		}
		else
		{
			$Optional_CondimentsCode = [];
		}
	
	//	print_r($Optional_CondimentsCode); echo "<br>";
	
		$SideCondiments_TotalPrice = 0;
		$mySideCondis = [];
		
		if($Condiments_Sides_set != NULL)
		{
			foreach($Condiments_Sides_set as $Condiments_code44)
			{
				$set44 = explode(":",$Condiments_code44);
				$side_item_codes[] = $set44[0];
			}
		//	print_r($Condiments_Sides_set); echo "<br>";
		
			foreach($Condiments_Sides_set as $Condiments_code4)
			{
				$set4 = explode(":",$Condiments_code4);
				$code4 = $set4[0];
				$name4 = $set4[1];
				//if($set4[2] == 0){ $qty4 = 1; }else{ $qty4 = $set4[2]; }
				$qty4 = ($set4[2] == 0) ? 1 : $set4[2];
				$price4 = $set4[3];
				if(!in_array($code4,$mySideCondis))
				{	
					if($itemCondiments_name == "")
					{
						$itemCondiments_name = $name4;
					}
					else{
					$itemCondiments_name .= "+".$name4;
					}
					
					if($itemCondiments_code == "")
					{
						$itemCondiments_code = $code4;
					}
					else{
					$itemCondiments_code .= "+".$code4;
					}
					
					$Sides_ItemCondiments = [];
					
					$side_items_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($code4,$Company_id,0);
			
					if($side_items_condiments != NULL && count($side_items_condiments) > 0)
					{
						foreach($side_items_condiments as $opt)
						{
							if($opt->Condiment_item_code != "")
							{
								if(in_array($opt->Condiment_item_code,$side_item_codes))
								{
					//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
									
									$RrsValues11 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
									
									$Sides_ItemCondiments[] = array("Item_code"=>$opt->Condiment_item_code,"Item_qty"=>1,"Item_rate"=>$RrsValues11->Billing_price,"ParentItem_code"=>$code4); //"Item_name"=>$RrsValues11->Merchandize_item_name,
									
									if($itemCondiments_name == "")
									{
										$itemCondiments_name = $RrsValues11->Merchandize_item_name;
									}
									else{
									$itemCondiments_name .= "+".$RrsValues11->Merchandize_item_name;
									}
									
									if($itemCondiments_code == "")
									{
										$itemCondiments_code = $opt->Condiment_item_code;
									}
									else{
									$itemCondiments_code .= "+".$opt->Condiment_item_code;
									}
					
									$mySideCondis[] = $opt->Condiment_item_code;
									$indx = array_search($opt->Condiment_item_code,$side_item_codes);
									array_splice($side_item_codes,$indx,1);
								}
							}
						}

					}
					
					$Sides_CondimentsCode[] = array("Item_code"=>$code4,"Item_qty"=>$qty4,"Item_rate"=>$price4,"Condiments" => $Sides_ItemCondiments,"ParentItem_code"=>$_REQUEST["Item_code"]); //"Item_type" => "SIDE","Item_name"=>$name4,
					
					if( $price4 > 0)
					{
						$SideCondiments_TotalPrice = $SideCondiments_TotalPrice + $price4;
					}
					
				}
			}

		}
		else
		{
			$Sides_CondimentsCode = [];
		}
	
	//	print_r($Sides_CondimentsCode); echo "<br>";
		
		//******** Main item requireds ***********
	//	print_r($MainRequired_Condiments_set); echo "<br>";
	 $Main_ReqOptional_CondimentsCode = [];

	 if($MainRequired_Condiments_set != NULL)
		{
			
				$set3 = explode(":",$MainRequired_Condiments_set);
				$code3 = $set3[0];
				$name3 = $set3[1];

				$Main_ReqOptional_CondimentsCode[] = array("Item_code"=>$code3,"Item_qty"=>1,"Item_rate"=>0,"ParentItem_code"=>$Selected_Main_Item); //"Item_name"=>$name3,
			//	$Main_ReqOptional_CondimentsCode[] = $Main_ReqOptional_info;
				
					if($itemCondiments_name == "")
					{
						$itemCondiments_name = $name3;
					}
					else{
					$itemCondiments_name .= "+".$name3;
					}
					
					if($itemCondiments_code == "")
					{
						$itemCondiments_code = $code3;
					}
					else{
					$itemCondiments_code .= "+".$code3;
					}
						

		}
		
		if($MainCondiments_set_optional != NULL)
		{
			foreach($MainCondiments_set_optional as $Condiments_code2)
			{
				$set2 = explode(":",$Condiments_code2);
				$code2 = $set2[0];
				$name2 = $set2[1];
			
				$Main_ReqOptional_CondimentsCode[] = array("Item_code"=>$code2,"Item_qty"=>1,"Item_rate"=>0,"ParentItem_code"=>$Selected_Main_Item); //"Item_name"=>$name2,
			//	$Main_ReqOptional_CondimentsCode[] = $Main_ReqOptional_info2;
	
				
				if($itemCondiments_name == "")
				{
					$itemCondiments_name = $name2;
				}
				else{
				$itemCondiments_name .= "+".$name2;
				}
				
				if($itemCondiments_code == "")
				{
					$itemCondiments_code = $code2;
				}
				else{
				$itemCondiments_code .= "+".$code2;
				}
			}

		}
	//print_r($Main_ReqOptional_CondimentsCode); echo "<br>";
	//******** Main item requireds ***********
	
		/* if(count($Main_ReqOptional_CondimentsCode) == 0)
		{
			$Main_ReqOptional_CondimentsCode[] = array();
		} */
		
		$MainItemTotal_Price = 0;
 		$MainItemInfo13 = $this->Shopping_model->get_main_item($_REQUEST["Item_code"],$data['Company_id']);
		
		
		foreach($MainItemInfo13 as $MainItemInfoData)
		{
			if($Selected_Main_Item == $MainItemInfoData["Main_or_side_item_code"])
			{
				$MainItemTotal_Price = $MainItemTotal_Price + $MainItemInfoData["Price"];
				$MainItemInfo[] = $MainItemInfoData;
				
				/* if($itemCondiments_name == "")
				{
					$itemCondiments_name = $MainItemInfoData["Merchandize_item_name"];
				}
				else{
				$itemCondiments_name .= "+".$MainItemInfoData["Merchandize_item_name"];
				}
				
				if($itemCondiments_code == "")
				{
					$itemCondiments_code = $MainItemInfoData["Main_or_side_item_code"];
				}
				else{
				$itemCondiments_code .= "+".$MainItemInfoData["Main_or_side_item_code"];
				} */
					
			}
		}
		//echo "main item---".$Selected_Main_Item . PHP_EOL;
		$MainItemInfo[0]['Condiments'] = $Main_ReqOptional_CondimentsCode;
	//	print_r($MainItemInfo); echo "<br>";
			//$Mainvalues[] = $RrsValuesMain;
		//	$MainItemInfo['Condiments'] = $Main_ReqOptional_CondimentsCode;
		/*print_r($MainItemInfo); echo "<br>";
		
		if($MainItemInfo != NULL)
		{
			foreach($MainItemInfo as $main)
			{			
			
				$ComboMealMainItemIs = array( 'Item_code' =>$main["Main_or_side_item_code"] ,'Item_qty' => $main["Quanity"],'Item_rate' => number_format($main["Price"],2) , 'Voucher_no' =>$Voucher_no,"Item_type" => "MAIN",'Condiments' => $main["Condiments"]);
				
				print_r($ComboMealMainItemIs); echo "<br>";
			}
		}
									
		die; */
		
		$data2 = array(
			 'id' => $_REQUEST['id'],
			 'qty' => 1,
			 'price' => $_REQUEST['price'],
			 'Item_category_id' => $_REQUEST["Product_category_id"],
			 'options' => array('Company_merchandize_item_code' => $_REQUEST["Item_code"],'Item_image1' => $_REQUEST["Item_image1"],'E_commerce_flag' => 1,'Redemption_method' => 29,'Branch' => $_REQUEST["Branch"],'Item_size' => $_REQUEST["Item_size"],'Item_Weight' => $_REQUEST["Item_Weight"],'Weight_unit_id' => $_REQUEST["Weight_unit_id"],'Partner_id'  => $_REQUEST["Partner_id"],'Partner_Country_id' => $_REQUEST["Partner_Country_id"],'Partner_state' => $_REQUEST["Partner_state"],'Seller_id' => $_REQUEST["Seller_id"],'Merchant_flag' => $_REQUEST["Merchant_flag"],'Cost_price' => $_REQUEST["Cost_price"],'VAT' => $_REQUEST["VAT"], 'RequiredCondiments' => $Required_CondimentsCode,
				 'OptionalCondiments' => $Optional_CondimentsCode, 
				 'SidesCondiments' => $Sides_CondimentsCode,
				 'remark2' => $itemCondiments_name,
				 'remark3' => $itemCondiments_code,
			 ),
			 'name' => $_REQUEST['name'],
			 'Main_item' => $MainItemInfo,
			 'MainItem_TotalPrice' => $MainItemTotal_Price,
			 'SideCondiments_TotalPrice' => $SideCondiments_TotalPrice,	
		   ); 
		
	//	print_r($data2); echo "<br>";
	
		$result = $this->cart->insert($data2);
		// echo $this->db->last_query();
		$cart_check = $this->cart->contents();
		$grand_total = 0;
		
		if ($cart = $this->cart->contents()) 
		{								
			foreach ($cart as $item)
			{
				$grand_total = $grand_total + $item['subtotal'];
			}
		}
				
		if($result)
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => number_format($grand_total, 2))));
		}
		else    
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => number_format($grand_total, 2))));
		}
	}
	public function Reorder_add_to_cart()
	{ 
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];
		$Company_id = $session_data['Company_id'];
		$mySideCondis = [];

		$getCondiment = $this->Shopping_model->get_transaction_item_condiments($_REQUEST['Bill'],$_REQUEST["Company_merchandize_item_code"],$data['Company_id']);
		
		$SideCondiments_TotalPrice = 0;
		
		foreach($getCondiment as $n)
		{
			$side_item_codes[] = $n["Condiment_Item_code"];
		}
		
		if($_REQUEST['Combo_meal_flag'] == 0)
		{
			foreach($getCondiment as $n)
			{
				//$RrsValues13 = $this->Shopping_model->Get_merchandize_item12($n["Condiment_Item_code"],$Company_id);

				$Required_CondimentsCode[] = array("Item_code"=>$n['Condiment_Item_code'],"Item_qty"=>$n['Quantity'],"Item_rate"=>$n['Price'],"ParentItem_code"=>$_REQUEST["Company_merchandize_item_code"]);	//"Item_name"=>$RrsValues13->Merchandize_item_name,
			}
		}

		$MainItemTotal_Price = 0;
		if($_REQUEST['Combo_meal_flag'] == 1)
		{	
			$MainItemInfo18 = $this->Shopping_model->get_main_item($_REQUEST["Company_merchandize_item_code"],$data['Company_id']);
			
			foreach($MainItemInfo18 as $MainItemInfoData)
			{
				if(in_array($MainItemInfoData["Main_or_side_item_code"],$side_item_codes))
				{
				$Main_ItemCondiments = [];
				$MainItemTotal_Price = $MainItemTotal_Price + $MainItemInfoData['Price'];
	
				/* $main_items_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($MainItemInfoData["Main_or_side_item_code"],$data['Company_id'],0);
					
					if($main_items_condiments != NULL && count($main_items_condiments) > 0)
					{
						foreach($main_items_condiments as $opt)
						{
							if($opt->Condiment_item_code != "")
							{
								if(in_array($opt->Condiment_item_code,$side_item_codes))
								{
					//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
									
									$RrsValues10 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);

									$Main_ItemCondiments[] = array("Item_code"=>$opt->Condiment_item_code,"Item_qty"=>1,"Item_rate"=>$RrsValues10->Billing_price);
									//"Item_name"=>$RrsValues10->Merchandize_item_name,
									$mySideCondis[] = $opt->Condiment_item_code;
									$indx = array_search($opt->Condiment_item_code,$side_item_codes);
									array_splice($side_item_codes,$indx,1);
								}
							}
						}

					} */
					
					
					$main_items_condiments = $this->Shopping_model->get_transaction_item_condiments($_REQUEST['Bill'],$MainItemInfoData["Main_or_side_item_code"],$data['Company_id']);
					
					if($main_items_condiments != NULL && count($main_items_condiments) > 0)
					{
						foreach($main_items_condiments as $opt)
						{
							if($opt["Condiment_Item_code"] != "")
							{

					//	echo $opt["Condiment_Item_code"]." this is condiment of ".$MainItemInfoData["Main_or_side_item_code"]."<br>";
									
							//		$RrsValues10 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_Item_code,$Company_id);

									$Main_ItemCondiments[] = array("Item_code"=>$opt["Condiment_Item_code"],"Item_qty"=>$opt["Quantity"],"Item_rate"=>$opt["Price"],"ParentItem_code"=>$MainItemInfoData["Main_or_side_item_code"]);
									//"Item_name"=>$RrsValues10->Merchandize_item_name,
									$mySideCondis[] = $opt["Condiment_Item_code"];
								//	$indx = array_search($opt->Condiment_Item_code,$side_item_codes);
								//	array_splice($side_item_codes,$indx,1);
								
							}
						}

					}
					$MainItemInfo[] = $MainItemInfoData;
				}
				
			}
			
			/* if(count($Main_ItemCondiments) == 0)
			{
				$Main_ItemCondiments[] = array();
			} */
		
			$MainItemInfo[0]['Condiments'] = $Main_ItemCondiments;
			/* echo "main item info--<br>";	
			print_r($MainItemInfo);
			echo "<br><br>"; */
			 
			foreach($getCondiment as $n)
			{
				if($n["Condiment_Item_code"] == $MainItemInfo[0]["Main_or_side_item_code"])
				{
					continue;
				}
							
				/* if(in_array($n["Condiment_Item_code"],$newArr12))
				{
					continue;
				} */
				
				if(!in_array($n["Condiment_Item_code"],$mySideCondis))
				{
				/* $side_items_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($n["Condiment_Item_code"],$data['Company_id'],0);
				
				$Sides_ItemCondiments = [];
				
					if($side_items_condiments != NULL && count($side_items_condiments) > 0)
					{
						foreach($side_items_condiments as $opt)
						{
							if($opt->Condiment_item_code != "")
							{
								if(in_array($opt->Condiment_item_code,$side_item_codes))
								{
					//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
									
									$RrsValues11 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
					
									$Sides_ItemCondiments[] = array("Item_code"=>$opt->Condiment_item_code,"Item_qty"=>1,"Item_rate"=>$RrsValues11->Billing_price);
									//"Item_name"=>$RrsValues11->Merchandize_item_name,
									$mySideCondis[] = $opt->Condiment_item_code;
									
									$indx = array_search($opt->Condiment_item_code,$side_item_codes);
									array_splice($side_item_codes,$indx,1);
								}
							}
						}

					} */
					
					$side_items_condiments = $this->Shopping_model->get_transaction_item_condiments($_REQUEST['Bill'],$n["Condiment_Item_code"],$data['Company_id']);
				
					$Sides_ItemCondiments = [];
				
					if($side_items_condiments != NULL && count($side_items_condiments) > 0)
					{
						foreach($side_items_condiments as $opt)
						{
							if($opt["Condiment_Item_code"] != "")
							{
					//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
									
							//		$RrsValues11 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_Item_code,$Company_id);
					
									$Sides_ItemCondiments[] = array("Item_code"=>$opt["Condiment_Item_code"],"Item_qty"=>(int)$opt["Quantity"],"Item_rate"=>$opt["Price"],"ParentItem_code"=>$n["Condiment_Item_code"]);
									//"Item_name"=>$RrsValues11->Merchandize_item_name,
									$mySideCondis[] = $opt["Condiment_Item_code"];
									
								//	$indx = array_search($opt->Condiment_Item_code,$side_item_codes);
								//	array_splice($side_item_codes,$indx,1);
								
							}
						}

					}
				$Sides_CondimentsCode[] = array("Item_code"=>$n["Condiment_Item_code"],"Item_qty"=>$n["Quantity"],"Item_rate"=>$n["Price"],"Condiments" => $Sides_ItemCondiments,"ParentItem_code"=>$_REQUEST["Company_merchandize_item_code"]); //"Item_type" => "SIDE",
				//"Item_name"=>$n["Merchandize_item_name"],
				$SideCondiments_TotalPrice = $SideCondiments_TotalPrice + $n["Price"];
				}
			}
		}
	
		/* echo "side item info--<br>";	
		print_r($Sides_CondimentsCode);
		echo "<br><br>"; */
		
		$data2 = array(
			 'id'      => $_REQUEST['id'],
			 'qty'     => 1,
			 'price'   =>$_REQUEST['price'],
			 'Item_category_id' => $_REQUEST["Product_category_id"],
			 'options' => array('Company_merchandize_item_code' => $_REQUEST["Company_merchandize_item_code"],'Item_image1' => $_REQUEST["Item_image1"],'E_commerce_flag' => 1,'Redemption_method' => 29,'Branch' => $_REQUEST["Branch"],'Item_size' => $_REQUEST["Item_size"],'Item_Weight' => $_REQUEST["Item_Weight"],'Weight_unit_id' => $_REQUEST["Weight_unit_id"],'Partner_id' => $_REQUEST["Partner_id"],'Partner_Country_id' => $_REQUEST["Partner_Country_id"],'Partner_state' => $_REQUEST["Partner_state"],'Seller_id' => $_REQUEST["Seller_id"],'Merchant_flag' => $_REQUEST["Merchant_flag"],'Cost_price' => $_REQUEST["Cost_price"],'VAT' => $_REQUEST["VAT"],'RequiredCondiments' => $Required_CondimentsCode,
				 'OptionalCondiments' => "", 
				 'SidesCondiments' => $Sides_CondimentsCode,
				'remark2' => $_REQUEST['Condiments_name'],
				 'remark3' => $_REQUEST['Condiments_code'],
			),
			 'name' => $_REQUEST['name'],
			 'Main_item' => $MainItemInfo,
			 'MainItem_TotalPrice' => $MainItemTotal_Price,
			 'SideCondiments_TotalPrice' => $SideCondiments_TotalPrice,	
		   );
		   
		$result = $this->cart->insert($data2);
		// echo $this->db->last_query();
		$cart_check = $this->cart->contents();
		$grand_total = 0;
		if ($cart = $this->cart->contents()) 
		{								
			foreach ($cart as $item)
			{
				$grand_total = $grand_total + $item['subtotal'];
			}
		}
				
		if($result)
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => number_format($grand_total, 2))));
			
		}
		else    
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => number_format($grand_total, 2))));
		}
	}
	public function Reorder()
	{ 
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId'] = $session_data['userId'];
			$data['Card_id'] = $session_data['Card_id'];
			$data['Company_id'] = $session_data['Company_id'];	
			$Company_id = $session_data['Company_id'];
			$Order_no=$_REQUEST['Order_no'];			
			
			$data["Order_details"] = $this->Shopping_model->get_order_details2($Order_no,$data['enroll'],$data['Company_id']);
			
			if($data["Order_details"] != NULL)
			{	
				foreach($data["Order_details"] as $Order_det)
				{

					$mySideCondis = [];
					$side_item_codes = [];
					$Sides_CondimentsCode = [];
					$Required_CondimentsCode = [];
					$MainItemInfo = NULL;
					
				//	echo "item --".$Order_det["Item_code"]."<br>";
						
					$getCondiment = $this->Shopping_model->get_transaction_item_condiments($Order_no,$Order_det["Item_code"],$Company_id);
					
					$SideCondiments_TotalPrice = 0;
					
					foreach($getCondiment as $n)
					{
						$side_item_codes[] = $n["Condiment_Item_code"];
					}
					//print_r($side_item_codes);
				//		echo "<br>side_item_codes<br>";
					$newArr12 = [];
					$MainItemTotal_Price = 0;
					
					if($Order_det['Combo_meal_flag'] == 1)
					{
					$MainItemInfo17 = $this->Shopping_model->get_main_item($Order_det["Item_code"],$Company_id);
					
						if($MainItemInfo17 != NULL)
						{
							foreach($MainItemInfo17 as $MainItemInfoData)
							{
								$Main_ItemCondiments = [];
								if(in_array($MainItemInfoData["Main_or_side_item_code"],$side_item_codes))
								{
	
								$MainItemTotal_Price = $MainItemTotal_Price + $MainItemInfoData['Price'];							
								/* $main_items_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($MainItemInfoData["Main_or_side_item_code"],$Company_id,0);
									
									if($main_items_condiments != NULL && count($main_items_condiments) > 0)
									{
										foreach($main_items_condiments as $opt)
										{
											if($opt->Condiment_item_code != "")
											{
												if(in_array($opt->Condiment_item_code,$side_item_codes))
												{
									//	echo $opt->Condiment_item_code." this is condiment of ".$MainItemInfoData["Main_or_side_item_code"]."<br>";
													
													$RrsValues10 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);

													$Main_ItemCondiments[] = array("Item_code"=>$opt->Condiment_item_code,"Item_qty"=>1,"Item_rate"=>$RrsValues10->Billing_price);
													//"Item_name"=>$RrsValues10->Merchandize_item_name,
													$mySideCondis[] = $opt->Condiment_item_code;
													
													$indx = array_search($opt->Condiment_item_code,$side_item_codes);
													array_splice($side_item_codes,$indx,1);
												}
											}
										}

									} */
									
									$main_items_condiments = $this->Shopping_model->get_transaction_item_condiments($Order_no,$MainItemInfoData["Main_or_side_item_code"],$data['Company_id']);
					
									if($main_items_condiments != NULL && count($main_items_condiments) > 0)
									{
										foreach($main_items_condiments as $opt)
										{
											if($opt["Condiment_Item_code"] != "")
											{

									//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
													
											//		$RrsValues10 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_Item_code,$Company_id);

													$Main_ItemCondiments[] = array("Item_code"=>$opt["Condiment_Item_code"],"Item_qty"=>$opt["Quantity"],"Item_rate"=>$opt["Price"],"ParentItem_code"=>$MainItemInfoData["Main_or_side_item_code"]);
													//"Item_name"=>$RrsValues10->Merchandize_item_name,
													$mySideCondis[] = $opt["Condiment_Item_code"];
												//	$indx = array_search($opt["Condiment_Item_code"],$side_item_codes);
												//	array_splice($side_item_codes,$indx,1);
												
											}
										}

									}
									
									$MainItemInfo[] = $MainItemInfoData;
								}
							}
							
								/* if(count($Main_ItemCondiments) == 0)
								{
									$Main_ItemCondiments[] = array();
								} */
			
							$MainItemInfo[0]['Condiments'] = $Main_ItemCondiments;
						}
					}
				 	/*  echo "main item info--<br>";	
						print_r($MainItemInfo);
						echo "<br><br>"; */
				
					
					
					foreach($getCondiment as $n)
					{
				//		$RrsValues13 = $this->Shopping_model->Get_merchandize_item12($n["Condiment_Item_code"],$Company_id);
				//		echo "--processing item---".$n["Condiment_Item_code"]."---and its type is-".$RrsValues13->Merchandize_item_type."<br>";
						if($Order_det['Combo_meal_flag'] == 0)
						{
				//			$Required_CondimentsCode[] = 	array("Item_code"=>$RrsValues13->Company_merchandize_item_code,"Item_qty"=>1,"Item_rate"=>$RrsValues13->Billing_price,"ParentItem_code"=>$Order_det["Item_code"]);	//"Item_name"=>$RrsValues13->Merchandize_item_name,
							$Required_CondimentsCode[] = array("Item_code"=>$n['Condiment_Item_code'],"Item_qty"=>$n['Quantity'],"Item_rate"=>$n['Price'],"ParentItem_code"=>$Order_det["Item_code"]);	
						}
				//		echo "--Combo_meal_flag---".$Order_det["Combo_meal_flag"]."<br>";
						if($Order_det['Combo_meal_flag'] == 1 ) //&& $RrsValues13->Merchandize_item_type != 119
						{
							$Sides_ItemCondiments = [];
				//			echo "-type is-".$RrsValues13->Merchandize_item_type."<br>";
							/* if(in_array($n["Condiment_Item_code"],$newArr12))
							{
								continue;
							} */
							if($n["Condiment_Item_code"] == $MainItemInfo[0]["Main_or_side_item_code"])
							{
								continue;
							}
							
							if(!in_array($n["Condiment_Item_code"],$mySideCondis))
							{
							/* $side_items_condiments = $this->Shopping_model->Get_Selected_item_condiments_details($n["Condiment_Item_code"],$data['Company_id'],0);
							
								if($side_items_condiments != NULL && count($side_items_condiments) > 0)
								{
									foreach($side_items_condiments as $opt)
									{
										if($opt->Condiment_item_code != "")
										{
											if(in_array($opt->Condiment_item_code,$side_item_codes))
											{
					//				echo $opt->Condiment_item_code." this is condiment of ".$n["Condiment_Item_code"]."<br>";
												
												$RrsValues11 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_item_code,$Company_id);
								
												$Sides_ItemCondiments[] = array("Item_code"=>$opt->Condiment_item_code,"Item_qty"=>1,"Item_rate"=>$RrsValues11->Billing_price);
												//"Item_name"=>$RrsValues11->Merchandize_item_name,
												$mySideCondis[] = $opt->Condiment_item_code;
												
												$indx = array_search($opt->Condiment_item_code,$side_item_codes);
												array_splice($side_item_codes,$indx,1);
											}
										}
									}

								} */
								
								$side_items_condiments = $this->Shopping_model->get_transaction_item_condiments($Order_no,$n["Condiment_Item_code"],$data['Company_id']);
				
								$Sides_ItemCondiments = [];
							
								if($side_items_condiments != NULL && count($side_items_condiments) > 0)
								{
									foreach($side_items_condiments as $opt)
									{
										if($opt["Condiment_Item_code"] != "")
										{
								//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
												
										//		$RrsValues11 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_Item_code,$Company_id);
								
												$Sides_ItemCondiments[] = array("Item_code"=>$opt["Condiment_Item_code"],"Item_qty"=>(int)$opt["Quantity"],"Item_rate"=>$opt["Price"],"ParentItem_code"=>$n["Condiment_Item_code"]);
												//"Item_name"=>$RrsValues11->Merchandize_item_name,
												$mySideCondis[] = $opt["Condiment_Item_code"];
												
											//	$indx = array_search($opt["Condiment_Item_code"],$side_item_codes);
											//	array_splice($side_item_codes,$indx,1);
											
										}
									}

								}
							$Sides_CondimentsCode[] = array("Item_code"=>$n["Condiment_Item_code"],"Item_qty"=>$n["Quantity"],"Item_rate"=>$n["Price"],"Condiments" => $Sides_ItemCondiments,"ParentItem_code"=>$Order_det["Item_code"]); //"Item_type" => "SIDE",
							//"Item_name"=>$n["Merchandize_item_name"],
							$SideCondiments_TotalPrice = $SideCondiments_TotalPrice + $n["Price"];
							}
						}
					}
		
		/*	  echo "side item info--<br>";	
			print_r($Sides_CondimentsCode);
			echo "<br><br>"; */
			/*print_r($Required_CondimentsCode);
			echo "<br><br>";*/
		 
		 
			
					$Merchandize_item_name=preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Order_det['Merchandize_item_name']); 
					
					$data2 = array(
					 'id' => $Order_det['Company_merchandise_item_id'],
					 'qty' => 1,
					 'price' =>$Order_det['Billing_price'],
					 'Item_category_id' => $Order_det['Merchandize_category_id'],
					 'options' => array('Company_merchandize_item_code' => $Order_det['Item_code'],'Item_image1' => $Order_det['Item_image1'],'E_commerce_flag' => 1,'Redemption_method' => 29,'Branch' => $Order_det['Merchandize_Partner_branch'],'Item_size' => $Order_det['Item_size'],'Item_Weight' => $Order_det['Item_Weight'],'Weight_unit_id' => $Order_det['Weight_unit_id'],'Partner_id'  => $Order_det['Merchandize_Partner_id'],'Partner_Country_id' => $Order_det['Partner_Country'],'Partner_state'  => $Order_det['Partner_state'],'Seller_id' => $Order_det['Seller_id'],'Merchant_flag' => $Order_det['Merchant_flag'],'Cost_price' => $Order_det['Cost_price'],'VAT' => $Order_det['VAT'],'Condiments_code' => $Order_det['remark3'],'Condiments_name' => $Order_det['remark2'],'RequiredCondiments' => 		$Required_CondimentsCode,
							 'OptionalCondiments' => "", 
							 'SidesCondiments' => $Sides_CondimentsCode,
							'remark2' => $Order_det['remark2'],
							 'remark3' => $Order_det['remark3'],
						),
						 'name' => $Merchandize_item_name,
						 'Main_item' => $MainItemInfo,
						 'MainItem_TotalPrice' => $MainItemTotal_Price,
						 'SideCondiments_TotalPrice' => $SideCondiments_TotalPrice,	
				   );

					$result = $this->cart->insert($data2);
				}	
			}
			
			$cart_check = $this->cart->contents();
			$grand_total = 0;
			if ($cart = $this->cart->contents()) 
			{								
				foreach ($cart as $item)
				{
					$grand_total = $grand_total + $item['subtotal'];
				}
			}
					
			if($result)
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => number_format($grand_total, 2))));
			}
			else    
			{
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => number_format($grand_total, 2))));
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function view_cart()
	{ 
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["To_Country"]=$data["Enroll_details"]->Country;
			$data["To_State"]=$data["Enroll_details"]->State;
			$data["To_City"]=$data["Enroll_details"]->City;
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$data["Shipping_charges_flag"] = $Company['Shipping_charges_flag'];
				$data["Standard_charges"] = $Company['Standard_charges'];
				$data["Cost_Threshold_Limit"] = $Company['Cost_Threshold_Limit'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			$data['Sellerdetails'] = $this->Igain_model->FetchSellerdetails($data['Company_id']);
			$delivery_session_data = $this->session->userdata('delivery_session');	
			// unset($_SESSION['customer_delivery_details']);
			
			$this->load->view('Shopping/view_cart', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function remove() 
	{
		$session_data['Cart_redeem_point'] = 0;
		$rowid = $_GET['rowid'];
		if ($rowid==="all")
		{
            $this->cart->destroy();
		}
		else
		{
            $data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
            $this->cart->update($data);
		}
		
		
		redirect('Shopping/view_cart');
	}
	
	function update_cart()
	{
		$cart_info = $_POST['cart'];
 		foreach( $cart_info as $id => $cart )
		{	
			$rowid = $cart['rowid'];
			$price = $cart['price'];
			$amount = $price * $cart['qty'];
			$qty = $cart['qty'];
                    
			$data = array(
				'rowid'   => $rowid,
				'price'   => $price,
				'amount' =>  $amount,
				'qty'     => $qty
			);             
			$this->cart->update($data);
		}
		redirect('Shopping/view_cart');   
	}
	
	public function product_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
				
			

			if($_GET['product_id'] != "")
			{

				// echo"---product_id------".$_GET['product_id']."---<br>";
				$product_id = $this->string_decrypt($_GET['product_id'],$this->key, $this->iv);	
				$Product_id_decrypt = preg_replace("/[^(\x20-\x7f)]*/s", "",$product_id);
				// echo"---Product_id_decrypt------".$Product_id_decrypt."---<br>";
				// die;

				if($Product_id_decrypt == ""){
					
					$this->load->view('err404',$data); 

				} else{

					$data["Product_details"] = $this->Shopping_model->get_products_details($Product_id_decrypt);
					$data["Product_offers"]=$this->Shopping_model->get_product_offers($Product_id_decrypt,$session_data['Company_id']);
					$this->load->view('Shopping/product_details', $data);

				}

			}
			else
			{
				redirect('Shopping');   
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
     public function Show_product_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			if($_REQUEST['Company_merchandise_item_id'] != "")
			{
				// echo"---product_id------".$_GET['product_id']."---<br>";
				// $product_id = $this->string_decrypt($_GET['product_id'],$this->key, $this->iv);	
				// $Product_id_decrypt = preg_replace("/[^(\x20-\x7f)]*/s", "",$product_id);
				// echo"---Product_id_decrypt------".$Product_id_decrypt."---<br>";
				// die;
				$Product_id_decrypt = $_REQUEST['Company_merchandise_item_id'];
				if($Product_id_decrypt == ""){
					
					$this->load->view('err404',$data); 

				} else{

					$data["Product_details"] = $this->Shopping_model->Show_product_details($Product_id_decrypt);
					$data["Product_offers"]=$this->Shopping_model->get_product_offers($Product_id_decrypt,$session_data['Company_id']);
					
					$theHTMLResponse = $this->load->view('Shopping/Show_product_details', $data, true);		
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
				}
			}
			else
			{
				redirect('Shopping');   
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}    
	public function Get_itemDetails()
	{
		$Company_merchandise_item_id = $this->input->post('Company_merchandise_item_id');
		$Product_details = $this->Shopping_model->get_products_details($Company_merchandise_item_id);
		
		if($Product_details->Thumbnail_image2 == ""){$Thumbnail_image2 = $Product_details->Thumbnail_image1;}else{$Thumbnail_image2 = $Product_details->Thumbnail_image2;}
		if($Product_details->Thumbnail_image3 == ""){$Thumbnail_image3 = $Product_details->Thumbnail_image1;}else{$Thumbnail_image3 = $Product_details->Thumbnail_image3;}
		if($Product_details->Thumbnail_image4 == ""){$Thumbnail_image4 = $Product_details->Thumbnail_image2;}else{$Thumbnail_image4 = $Product_details->Thumbnail_image4;}
		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Item_image1'=> $Product_details->Thumbnail_image1, 'Item_image2'=> $Thumbnail_image2, 'Item_image3'=> $Thumbnail_image3, 'Item_image4'=> $Thumbnail_image4, 'Merchandize_item_name' => $Product_details->Merchandize_item_name, 'Billing_price' => $Product_details->Billing_price, 'Merchandise_item_description' => $Product_details->Merchandise_item_description )));
	}

    public function checkout()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
				
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enroll_details = $data["Enroll_details"];
			$Country_id = $Enroll_details->Country;
			//******* 24-09-2019 sandeep *******************
			if($Enroll_details->City != NULL){
				$City = $Enroll_details->City;
			}
			else{
				$City = 0;
			}
			
			if($Enroll_details->State != NULL){
				$State = $Enroll_details->State;
			}
			else{
				$State = 0;
			}
	//******* 24-09-2019 sandeep *******************
			$Address = $Enroll_details->Current_address;
			$Phone_no = $Enroll_details->Phone_no;
			$Zipcode = $Enroll_details->Zipcode;
			$Contact_person = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
			
			$data["cust_Country_id"] = $Country_id;
			$data["cust_State"] = $State;
			$data["cust_City"] = $City;
			
			/*----------------27-08-2019------------------*/
				$delivery_type = $this->input->post('delivery_type');
				$delivery_outlet= $this->input->post('delivery_outlet');
				if($_REQUEST["delivery_type"] || $_REQUEST["delivery_outlet"] )
				{
					$sess_array1 = array(
							'delivery_type' => $delivery_type,
							'delivery_outlet' => $delivery_outlet
						);
					$this->session->set_userdata('delivery_session', $sess_array1);	
				}		
				
				/* $delivery_type = $_SESSION['delivery_type'];	 // or:
				$delivery_type = $this->session->delivery_type; */

				$delivery_session_data = $this->session->userdata('delivery_session');
				$delivery_type=$delivery_session_data['delivery_type'];
				$delivery_outlet=$delivery_session_data['delivery_outlet'];
					
				$data['delivery_type'] = $delivery_type;	
				$data['delivery_outlet'] = $delivery_outlet;	
				
				if($delivery_type==2)
				{
					$Table_number = $_REQUEST['Table_no'];
					
					$sess_array2 = array(
							'Table_no' => $Table_number
						);
					$this->session->set_userdata('table_no_session', $sess_array2);	
				}
				
				if($delivery_type==1 || $delivery_type==2)
				{
					/* if($delivery_outlet == "" ){			
						
						redirect('Shopping/view_cart');					
						
					} else {
						
						redirect('Shopping/checkout_cart_details');
					} */
					
					redirect('Shopping/checkout_cart_details');
				}
			/*----------------27-08-2019------------------*/
			
			// $data['Customer_current_address']=$this->Igain_model->Fetch_customer_address($data['enroll']);
			
			$data['Customer_current_address']=$this->Igain_model->Fetch_customer_addresses($data['enroll'],$Address_type=0);			
			$data['Customer_work_address']=$this->Igain_model->Fetch_customer_addresses($data['enroll'],$Address_type=1);
			$data['Customer_other_address']=$this->Igain_model->Fetch_customer_addresses($data['enroll'],$Address_type=2);
			
			if($data['Customer_current_address'] == "" ) {
				$Insert_data=array(					
							'Address_type'=>0,
							'Company_id'=>$data['Company_id'],
							'Enrollment_id'=>$data['enroll'],
							'Contact_person'=>$Contact_person,
							'Phone_no'=>$Phone_no,
							'Address'=>$Address,
							'Country_id'=>$Country_id,
							'State_id'=>$State,
							'City_id'=>$City,
							'Zipcode'=>$Zipcode,
							'Create_date'=>date('Y-m-d'),
							'Update_date'=>date('Y-m-d')					
						);		
							
				$insert_address = $this->Igain_model->insert_customer_address($Insert_data);
			}
			
			$data['Customer_current_address']=$this->Igain_model->Fetch_customer_addresses($data['enroll'],$Address_type=0);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$Symbol_of_currency = $Country_details->Symbol_of_currency;
			$this->session->set_userdata('Symbol_of_currency', $Symbol_of_currency);
			
			
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$data["Country_details"] = $this->Igain_model->get_dial_code($Country_id);
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
                        
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
						 'options' => array('Company_merchandize_item_code' => $item["Company_merchandize_item_code"], 'Item_image1' => $item["Item_image1"],'E_commerce_flag'  => 1,'Redemption_method'  => $item["Delivery_method"],'Branch'  => $item["Branch"],'Item_size'  => $item["Item_size"],'Item_Weight'  => $item["Item_Weight"],'Weight_unit_id'  => $item["Weight_unit_id"],'Partner_id'  => $item["Partner_id"],'Partner_Country_id'  => $item["Partner_Country_id"],'Partner_state'  => $item["Partner_state"],'Seller_id'  => $item["Seller_id"])
					);	
					$order_sub_total = $order_sub_total + $item['subtotal'];
					$i++;
				}

				$order_total = $order_sub_total + $shipping_cost + $tax;
			
// 'shipping' => $_SESSION['Total_Shipping_Cost'],
				$cart['shopping_cart'] = array(
					'items' => $cart['items'],
					'subtotal' => $_SESSION['Sub_total'],
					 'shipping' => $_SESSION['Total_Shipping_Cost'],
					'handling' => 0,
					'tax' => $tax,
				);
				
				$cart['shopping_cart']['grand_total'] = $_SESSION['Grand_total'];
				$this->load->vars('cart', $cart);
				$this->session->set_userdata('shopping_cart', $cart);
			}
                        
				//echo "ShippingType----------".$session_data['ShippingType'];die;
				
				if(!isset($session_data['ShippingType']) || $session_data['ShippingType'] == "")
				{
					$data['ShippingType'] = 1;
					$data['New_shipping_details'] = "";
				}
				else
				{
					$data['ShippingType'] = $session_data['ShippingType'];
					$data['New_shipping_details'] = $session_data['New_shipping_details'];
				}
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			$data['States_array'] = $this->Igain_model->Get_states($data["Enroll_details"]->Country);	
			$data['City_array'] = $this->Igain_model->Get_cities($data["Enroll_details"]->State);	
			
			$this->load->view('Shopping/checkout', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
        
    function checkout_cart_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			if(isset($session_data['Cart_redeem_point']))
			{
				$data['Cart_redeem_point'] = $session_data['Cart_redeem_point'];
				
			}
			else
			{
				$data['Cart_redeem_point'] = 0;
				$session_data['Cart_redeem_point'] = 0;
			}
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["To_Country"]=$data["Enroll_details"]->Country;
			$data["To_State"]=$data["Enroll_details"]->State;
			$data["city"]=$data["Enroll_details"]->City;
			$Tier_id = $data["Enroll_details"]->Tier_id;
			//echo "Tier_id--".$Tier_id;
			
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
		//	$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			$data['Company_details'] = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			
				
			$delivery_session_data = $this->session->userdata('delivery_session');
			$delivery_type=$delivery_session_data['delivery_type'];
			$delivery_outlet=$delivery_session_data['delivery_outlet'];
			
			
			$delivery_address_type =$_REQUEST['address_flag'];
			$data['delivery_address_type'] =$delivery_address_type;
			
			
			$data['delivery_type']=$delivery_type;
			$data['delivery_outlet']=$delivery_outlet;
			$data['delivery_address_type']=$delivery_address_type;
			// die;
			$data['customer_delivery_details']=$this->Igain_model->Fetch_customer_addresses($data['enroll'],$delivery_address_type);
			$Update_customer_delivery_flag=$this->Igain_model->Update_customer_delivery_address($data['enroll'],$delivery_address_type);
			$data["delivery_outlet_details"] = $this->Igain_model->get_enrollment_details($delivery_outlet);
			
			///*************** sandeep discount logic 27-01-2020 **************************
			$DiscountVouchers = $this->Igain_model->get_member_discount_vouchers($data['Card_id'],$data['Company_id']);
			$data['DiscountVouchers'] = $DiscountVouchers;
			///*************** sandeep discount logic 27-01-2020 **************************
			
			
			foreach($data['Company_details'] as $Company)
			{
				$Country = $Company['Country'];
				$data["Redemptionratio"] = $Company['Redemptionratio'];
				$data["Shipping_charges_flag"] = $Company['Shipping_charges_flag'];
				$data["Standard_charges"] = $Company['Standard_charges'];
				$data["Cost_Threshold_Limit"] = $Company['Cost_Threshold_Limit'];
				$data["Loyalty_enabled"] = $Company['Loyalty_enabled'];
				$Currency_name= $Company['Currency_name'];
			}
			$data["Currency_name"]=$Currency_name;
			// die;
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			$data['Company_Redemptionratio'] = $Company_Redemptionratio;
			
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
		
			$this->session->unset_userdata('PayPalResult');
			$this->session->unset_userdata('shopping_cart');
			
			$order_sub_total = 0;	
			$shipping_cost = 99;
			$data["DiscountAmt"] = 0;
			$TotalvoucherAmt = 0;
			$TotalDiscountAmt = 0;
					
			$tax = 0;	
			$i = 0;
			if ($cart = $this->cart->contents())
			{
				foreach ($cart as $item)
				{
					$cart['items'][$i] = array(
						'id' => $item['id'],
						'name' => $item['name'],
						'qty' => $item['qty'],
						'price' => $item['price'],
						'Size' => $item['Size'],
					);	
					$order_sub_total = $order_sub_total + $item['subtotal'];
					$i++;
					
	///**************** sandeep discount logic 27-01-2020 ***************************
					$ItemCode = $item['options']['Company_merchandize_item_code'];

					$Itemcategory_id = $item['Item_category_id'];
					$Item_price = $item['price'] * $item['qty'];
					
					//$ItemCode,$data['Company_id'],$delivery_outlet,$data['enroll'],$Tier_id
					
					$DiscountResult = $this->Igain_model->get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$data['Company_id'],$delivery_outlet,$data['enroll'],$Tier_id,0);
					
					$DisOpt = json_decode($DiscountResult,true);
					
					/* if($DisOpt["voucherAmt"] > 0)
					{
						$TotalvoucherAmt = floor($TotalvoucherAmt + $DisOpt["voucherAmt"]);	
					} */
					
					if($DisOpt["DiscountAmt"] > 0)
					{
						$TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt["DiscountAmt"]);
					}
					
					if(!empty($DisOpt["discountsArray"]) && is_array($DisOpt["discountsArray"]))
					{
						//$Discount_codes[] = $DisOpt["discountsArray"];
							foreach($DisOpt["discountsArray"] as $k1)
							{
								$Discount_codes[] = $k1;
							}
					}
	///**************** sandeep discount logic 27-01-2020 ***************************				
				}
		///**************** sandeep discount logic 27-01-2020 ***************************		
				
				$DiscountResult12 = $this->Igain_model->get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$data['Company_id'],$delivery_outlet,$data['enroll'],$Tier_id,$order_sub_total);
				
				$DisOpt12 = json_decode($DiscountResult12,true);
					
						/* if($DisOpt12["voucherAmt"] > 0)
						{
							$TotalvoucherAmt = floor($TotalvoucherAmt + $DisOpt12["voucherAmt"]);	
						} */
						
						if($DisOpt12["DiscountAmt"] > 0)
						{
							$TotalDiscountAmt = floor($TotalDiscountAmt + $DisOpt12["DiscountAmt"]);
						}
						
						if(!empty($DisOpt12["discountsArray"]) && is_array($DisOpt12["discountsArray"]))
						{
							foreach($DisOpt12["discountsArray"] as $k)
							{
								$Discount_codes[] = $k;
							}
						}
					
						//$this->session->set_userdata('voucherAmt',$TotalvoucherAmt);
						//$voucherAmt = $this->session->userdata('voucherAmt');
						// echo "voucherAmt--".$voucherAmt;
						
						if($DisOpt12["voucherValidity"] != null)
						{
							$this->session->set_userdata('voucherValidity',$DisOpt12["voucherValidity"]);
						}
						
							$voucherValidity = $this->session->userdata('voucherValidity');
						// echo "voucherValidity--".$voucherValidity;

						$data["DiscountAmt"] = $TotalDiscountAmt;
						// echo "DiscountAmt--".$data["DiscountAmt"];
						
						
						if(count($Discount_codes) > 0)
						{
							// print_r($Discount_codes);
							$this->session->set_userdata('Discount_codes',$Discount_codes);
						}
						
		///**************** sandeep discount logic 27-01-2020 ***************************		
				$order_total = ($order_sub_total + $shipping_cost + $tax) - $data["DiscountAmt"];
				
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
              
			$this->load->view('Shopping/checkout_cart_details', $data);
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
        
    public function checkout2()
	{
		
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];	
			}
			$Country_details = $this->Igain_model->get_dial_code($Country);
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
            
			/**********AMIT KAMBLE 11-09-2019********************************/
				$delivery_session_data = $this->session->userdata('delivery_session');
				$delivery_type=$delivery_session_data['delivery_type'];
				$delivery_outlet=$delivery_session_data['delivery_outlet'];
				$Enroll_details = $this->Igain_model->get_enrollment_details($delivery_outlet);
				$data['goods_till_number'] = $Enroll_details->goods_till_number;
				$data['Seller_api_url2'] = $Enroll_details->Seller_api_url2;
				
                /*********************************************************/
			
			/************AMIT KAMBLE 18-09-2019*****************************/
			if($_REQUEST['redeem_by']==1)//YES
			{
				$redeem_amt = $this->input->post('redeem_amt');
				
				$Redeem_points = $this->input->post('point_redeem');
				$hidden_Equi_Redeem = $this->input->post('hidden_Equi_Redeem');
				
				//$redeem_amt = round($Redeem_points/$Company_Redemptionratio);
				/* if($hidden_Equi_Redeem < $Redeem_points)
				{
					redirect('Shopping/checkout_cart_details');
				} */
				
				$session_data['Cart_redeem_point'] = $Redeem_points; 
				$this->session->set_userdata("cust_logged_in", $session_data);
				$_SESSION['Redeem_points'] = $Redeem_points;
					
				
			}
			else if($_REQUEST['redeem_by']==2)//NO
			{
				$redeem_amt = 0;
				$Redeem_points = 0;
						
				$session_data['Cart_redeem_point'] = $Redeem_points; 
				$this->session->set_userdata("cust_logged_in", $session_data);
				$_SESSION['Redeem_points'] = $Redeem_points;
				
			}
			else
			{
				$redeem_amt = $_SESSION["Redeem_amount"];
				
				$Redeem_points = $session_data['Cart_redeem_point'];
						
				$session_data['Cart_redeem_point'] = $Redeem_points; 
				$this->session->set_userdata("cust_logged_in", $session_data);
				$_SESSION['Redeem_points'] = $Redeem_points;

			}
			$_SESSION["Redeem_amount"] = $redeem_amt;	
			
			/************sandeep redeem discount voucher****************************/	
			$redeem_voucher_amt = 0;
			if(isset($_POST['redeem_voucher_amt']))
			{
				$redeem_voucher_amt = $this->input->post('redeem_voucher_amt');
				$redeem_voucher = $this->input->post('redeem_voucher');
				
				$_SESSION['VoucherDiscountAmt'] = $redeem_voucher_amt;
				$_SESSION['Redeemed_discount_voucher'] = $redeem_voucher;
				
				// echo "-set sessions--".$_SESSION['Redeemed_discount_voucher']."---".$_SESSION['VoucherDiscountAmt'];
			}
			/************redeem discount voucher****************************/
			
			$total_bill_amount=($_SESSION["Grand_total"]-$redeem_amt) - $redeem_voucher_amt;
			
			$data['total_bill_amount'] = $total_bill_amount;	
			$_SESSION["Final_Grand_total"] = $total_bill_amount;
			/******************************************************************/
			
			$data['Address_type']=$this->input->post('Address_type');
			$data['DeliveryType']=$this->input->post('DeliveryType');
			$data['DeliveryOutlet']=$this->input->post('DeliveryOutlet');
			
			
			
			$delivery_address_type =$_REQUEST['address_flag'];
			$data['delivery_address_type'] =$delivery_address_type;
			
			if($total_bill_amount <= 0)
			{
				redirect('Shopping/review', 'refresh');
			}
			
			$this->load->view('Shopping/checkout2', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
        
    function Card_details()
	{
            if($this->session->userdata('cust_logged_in'))
            {
                $session_data = $this->session->userdata('cust_logged_in');
                $data['username'] = $session_data['username'];			
                $data['enroll'] = $session_data['enroll'];
                $data['userId']= $session_data['userId'];
                $data['Card_id']= $session_data['Card_id'];
                $data['Company_id']= $session_data['Company_id'];

                $Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
                foreach($Company_details as $Company)
                {
                        $Country = $Company['Country'];
                }
                $Country_details = $this->Igain_model->get_dial_code($Country );
                $Symbol_of_currency = $Country_details->Symbol_of_currency;
                $this->session->set_userdata('Symbol_of_currency', $Symbol_of_currency);

                $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
                $data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
                $data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);

                $Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
                foreach($Company_details as $Company)
                {
                        $Country = $Company['Country'];
                }
                $Country_details = $this->Igain_model->get_dial_code($Country );
                $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
                
				$data['Address_type']=$this->input->post('Address_type');
				$data['DeliveryType']=$this->input->post('DeliveryType');
				$data['DeliveryOutlet']=$this->input->post('DeliveryOutlet');
				$_SESSION['Address_type']=$data['Address_type'];
				$_SESSION['DeliveryType']=$data['DeliveryType'];
				$_SESSION['DeliveryOutlet']=$data['DeliveryOutlet'];
                $payment_method = $this->input->post('payment_method');
				// echo"---payment_method---".$data['Address_type']."---<br>";
				// echo"---payment_method---".$payment_method."---<br>";
				// die;
				$delivery_address_type =$_REQUEST['address_flag'];
				$data['delivery_address_type'] =$delivery_address_type;	
					
				/***************AMIT KAMBLE 18-09-2019**********************/	
				if($payment_method==2)//COD
				{
					$mpesa_BillAmount =0;
					$Mpesa_TransID =0;
					$_SESSION["mpesa_BillAmount"]=$mpesa_BillAmount;
					$_SESSION["Mpesa_TransID"]=$Mpesa_TransID;
				}					
				else if($payment_method==6)//MPESA
				{
					$mpesa_BillAmount =$_REQUEST['BillAmount'];
					$Mpesa_TransID =$_REQUEST['Mpesa_TransID'];
					$_SESSION["mpesa_BillAmount"]=$mpesa_BillAmount;
					$_SESSION["Mpesa_TransID"]=$Mpesa_TransID;
					
				}
				else
				{
					$mpesa_BillAmount = $_SESSION["mpesa_BillAmount"];
					$Mpesa_TransID = $_SESSION["Mpesa_TransID"];
				}
				/*********************************************************************/

                if($payment_method != "")
                {
                    if(!isset($session_data['ShippingType']))
                    {
                        $session_data['PaymentMethod'] = $payment_method;
                        $this->session->set_userdata("cust_logged_in", $session_data);
                    }
                    else
                    {
                        $session_data['PaymentMethod'] = $payment_method;
                        $this->session->set_userdata("cust_logged_in", $session_data);
                    }
                        
                    if($payment_method == 1)
                    {
                        $this->load->view('Shopping/Card_details', $data);
                    }
                    else if($payment_method == 3)
                    {
                        redirect('Express_checkout/SetExpressCheckout');
                    }
                    else
                    {
                         redirect('Shopping/review/?address_flag='.$delivery_address_type);
						
                    }
                }
                else
                {
                    $this->session->set_flashdata("error_code","Please Select at least One Payment Method");
                    //redirect('Shopping/checkout2');
					
                    $this->load->view('Shopping/checkout2', $data);
                }
            }
            else
            {
                redirect('login', 'refresh');
            }
	}
        
    function UpdatepaymentInfo()
	{
            if($this->session->userdata('cust_logged_in'))
            {
                $session_data = $this->session->userdata('cust_logged_in');
                $data['enroll'] = $session_data['enroll'];
                $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
                $Enroll_details = $data['Enroll_details'];
                $Payment_card_no = $Enroll_details->Payment_card_no;

                if($_POST != "")
                {
                    $month = $this->input->post('card_ending_month');
                    $year = $this->input->post('card_ending_year');

                    $Enrollment_id =  $data['enroll'];
                    $post_data = array(					
                                    'Payment_card_name' => $this->input->post('Payment_card_name'),
                                    'Payment_card_no' => trim($Payment_card_no),        
                                    'Card_end_month' => $month,							     
                                    'Card_end_year' => $year,							     
                                    'Card_CVV' => $this->input->post('Card_CVV')
                                    );

                    $result = $this->Igain_model->update_payment_info($post_data,$Enrollment_id);
                    if($result == true)
                    {
                        redirect('Shopping/review');
                    }
                    else
                    {
                        $this->load->view('Shopping/Card_details', $data);
                    }
                }
                else
                {
                    $this->load->view('Shopping/Card_details', $data);
                }
            }
            else
            {
                    redirect('login', 'refresh');
            }
	}
        
    function UpdateCardNo()
	{
            if($this->input->post('Payment_card_no'))
            {
                $session_data = $this->session->userdata('cust_logged_in');
                $data['enroll'] = $session_data['enroll'];
                $data['Company_id']= $session_data['Company_id'];
                $Enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);

                $Payment_card_no = $this->input->post('Payment_card_no');

                $Enrollment_id =  $data['enroll'];
                $post_data = array
                            (
                                'Payment_card_no' => trim($Payment_card_no)
                            );

                $result = $this->Igain_model->update_card_number($post_data,$Enrollment_id);
                if($result == true)
                {
                    $len = strlen($Payment_card_no);
                    if($len==16)
                    {
                        $result = substr($Payment_card_no, 0, 12);
                    }
                    else if($len >  16)
                    {
                        $result = substr($Payment_card_no, 0, 16);
                    }
                    else
                    {
                        $result = substr($Payment_card_no, 0, 8);
                    }

                    $converted = preg_replace("/[\S]/", "X", $result);
                    if($len==16)
                    {
                        $remaining = substr($Payment_card_no,12,$len);
                    }
                    else if($len >  16)
                    {
                        $remaining = substr($Payment_card_no,16,$len);
                    }
                    else
                    {
                        $remaining = substr($Payment_card_no,8,$len);
                    }

                    $Payment_card_no = $converted.''.$remaining;
    
                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode(array('card_update_flag'=> '1', 'Payment_card_no' => $Payment_card_no )));
                }
                else
                {
                    $this->output->set_content_type('application/json');
                    $this->output->set_output(json_encode(array('card_update_flag'=> '0', 'Payment_card_no' => $Enroll_details->Payment_card_no )));
                }
            }
            else
            {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode(array('card_update_flag'=> '0', 'Payment_card_no' => $Enroll_details->Payment_card_no )));
            }
	}
        
    function GetCardNo()
	{
            $session_data = $this->session->userdata('cust_logged_in');
            $data['enroll'] = $session_data['enroll'];
            $data['Company_id']= $session_data['Company_id'];
            $Enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);

            $Payment_card_no = $Enroll_details->Payment_card_no;

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array('Payment_card_no' => $Payment_card_no )));
	}        
    function review()
	{
            if($this->session->userdata('cust_logged_in'))
            {
                $session_data = $this->session->userdata('cust_logged_in');
                $data['username'] = $session_data['username'];			
                $data['enroll'] = $session_data['enroll'];
                $data['userId']= $session_data['userId'];
                $data['Card_id']= $session_data['Card_id'];
                $data['Company_id']= $session_data['Company_id'];

             /*    $Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
                foreach($Company_details as $Company)
                {
                        $Country = $Company['Country'];
                }
                $Country_details = $this->Igain_model->get_dial_code($Country );
                $Symbol_of_currency = $Country_details->Symbol_of_currency;
                $this->session->set_userdata('Symbol_of_currency', $Symbol_of_currency);
 */
                $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
                $data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
                $data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);

                $Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
                foreach($Company_details as $Company)
                {
                        $Country = $Company['Country'];
                        $Company_Redemptionratio = $Company['Redemptionratio'];	
                        $Loyalty_enabled = $Company['Loyalty_enabled'];	
                }
				$data['Loyalty_enabled'] = $Loyalty_enabled;
                $Country_details = $this->Igain_model->get_dial_code($Country );
                $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
				
				$this->session->set_userdata('Symbol_of_currency', $data['Symbol_of_currency']);
				
                $data['Redeem_amount'] = $_SESSION["Redeem_amount"];
                $data['Sub_total'] = $_SESSION['Sub_total'];
                $data['DiscountAmt'] = $_SESSION['DiscountAmt'];
                $data['mpesa_BillAmount'] = $_SESSION['mpesa_BillAmount'];
                $data['Final_Grand_total'] = $_SESSION['Final_Grand_total'];
                //echo $_SESSION["Final_Grand_total"];die;
               
                $data['New_shipping_details'] = $session_data['New_shipping_details'];
                $data['PaymentMethod'] = $session_data['PaymentMethod'];
                      
						// $_SESSION['delivery_type']=$delivery_type;
							// $_SESSION['delivery_outlet']=$delivery_outlet;
						
						// $data['Address_type']=$this->input->post('Address_type');
						// var_dump($_SESSION['Address_type']);
						// var_dump($_SESSION['delivery_type1']);
						// var_dump($_SESSION['Total_Shipping_Cost']);
						// die;
				$delivery_address_type =$_REQUEST['address_flag'];
				$data['delivery_address_type'] =$delivery_address_type;	
				
				$data['Address_type_details']=$this->Igain_model->Fetch_selected_customer_addresses($data['enroll']);
				
				$delivery_session_data = $this->session->userdata('delivery_session');
				$delivery_type=$delivery_session_data['delivery_type'];
				$delivery_outlet=$delivery_session_data['delivery_outlet'];
				$data["delivery_outlet_details"] = $this->Igain_model->get_enrollment_details($delivery_outlet);
				
                $this->load->view('Shopping/review', $data);
            }
            else
            {
                redirect('login', 'refresh');
            }
	}	
	public function shipping_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
				
			$this->load->view('Shopping/shipping_details', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}  
	public function CheckoutPayment()
	{
		if($this->session->userdata('cust_logged_in'))
		{						
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];

			$delivery_session_data = $this->session->userdata('delivery_session');
			$delivery_type=$delivery_session_data['delivery_type'];
			$delivery_type1=$delivery_session_data['delivery_type'];
			$delivery_outlet=$delivery_session_data['delivery_outlet'];
			$delivery_outlet_details = $this->Igain_model->get_enrollment_details($delivery_outlet);
	//******** 05-09-2019 sandeep **********************			
			$Seller_api_url = $delivery_outlet_details->Seller_api_url;
			$Seller_api_url2 = $delivery_outlet_details->Seller_api_url2;
	//******** 05-09-2019 sandeep **********************				
			$Outlet_name = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name;
			
			$Outlet_address = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name.",".App_string_decrypt($delivery_outlet_details->Current_address)."<br>".App_string_decrypt($delivery_outlet_details->Phone_no)."<br>";
			
			$Address_type_details=$this->Igain_model->Fetch_selected_customer_addresses($data['enroll']);
			$Cust_selected_address =  $Address_type_details->Contact_person.", ".App_string_decrypt($Address_type_details->Address).", ".$Address_type_details->city_name.", ".$Address_type_details->country_name.", ".App_string_decrypt($Address_type_details->Phone_no)."<br>";
								
			if($delivery_type==1) 
			{
				$Delivery_method = 28;  //Take Away
			}
			else if($delivery_type==2) 
			{
				$Delivery_method = 107;  // In-Store
				
				$table_no_session_data = $this->session->userdata('table_no_session');
				$Session_table_no=$table_no_session_data['Table_no'];
			}
			else if($delivery_type == 0)
			{
				$Delivery_method = 29; //Home Delivery
			}
			else
			{
				$Delivery_method = 0; 
			}
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			/* $To_Country=$data["Enroll_details"]->Country;
			$To_State=$data["Enroll_details"]->State; */
			$To_Country=$_SESSION["To_Country"];
			$To_State=$_SESSION["To_State"];
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);

			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];	
				$Company_name = $Company['Company_name'];	
				$Shipping_charges_flag = $Company['Shipping_charges_flag'];	
				$Standard_charges = $Company['Standard_charges'];
				$Cost_Threshold_Limit = $Company['Cost_Threshold_Limit'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;                
			$Cust_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$card_number = trim($Cust_details->Payment_card_no);
			$card_name = $Cust_details->Payment_card_name;
			$expiry_month = trim($Cust_details->Card_end_month);
			$expiry_year = trim($Cust_details->Card_end_year);
			$cvv = trim($Cust_details->Card_CVV);                
			$expirationDate = $expiry_month.'/'.$expiry_year;
			
			$subtotal1 = 0;
			if ($cart = $this->cart->contents()) 
			{								
				foreach ($cart as $item)
				{
					$subtotal1 = $subtotal1 + $item['subtotal'];
				}
			}
					   
			$Cust_wish_redeem_point = $session_data['Cart_redeem_point'];
			$EquiRedeem = $_SESSION["Redeem_amount"];
			$subtotal = $subtotal1;
			// $grand_total = $grand_total - $EquiRedeem ;
			// $grand_total = $_SESSION['Grand_total'] - round($EquiRedeem,1,2);
			$grand_total = $_SESSION["Final_Grand_total"];								
			// var_dump($subtotal); var_dump($grand_total); die;   				  
			$New_shipping_details = $session_data['New_shipping_details'];
			$Payment_option = $session_data['PaymentMethod'];				
			
			// echo"-------------Payment_option-------------".$Payment_option."---<br>";
				//*** Cash On Delivery
								
				/*******************Apply Loyalty Rule****************/
					$gained_points_fag = 0;
					$trans_lp_id=0;
					$cid = $session_data['Card_id'];
					$Company_id = $session_data['Company_id'];
					$Cust_redeem_point = $session_data['Cart_redeem_point'];

					$CardId = $data["Enroll_details"]->Card_id;
					$fname = $data["Enroll_details"]->First_name;
					$midlename = $data["Enroll_details"]->Middle_name;
					$lname = $data["Enroll_details"]->Last_name;					
					$bdate = $data["Enroll_details"]->Date_of_birth;
					$address = $data["Enroll_details"]->Current_address;
					$bal = $data["Enroll_details"]->Current_balance;
					$total_purchase = $data["Enroll_details"]->total_purchase;
					$Total_reddems = $data["Enroll_details"]->Total_reddems;
					$Total_topup_amt = $data["Enroll_details"]->Total_topup_amt;
					$Blocked_points = $data["Enroll_details"]->Blocked_points;
					$phno = App_string_decrypt($data["Enroll_details"]->Phone_no);
					$CustomerEmail = App_string_decrypt($data["Enroll_details"]->User_email_id);
					$pinno = $data["Enroll_details"]->pinno;
					$companyid = $data["Enroll_details"]->Company_id;
					$cust_enrollment_id = $data["Enroll_details"]->Enrollement_id;
					$image_path = $data["Enroll_details"]->Photograph;				
					$filename_get1 = $image_path;	
					$lv_member_Tier_id = $data["Enroll_details"]->Tier_id;
											
					$Customer_enroll_id = $data["Enroll_details"]->Enrollement_id;
					$topup = $data["Enroll_details"]->Total_topup_amt;
					$purchase_amt = $data["Enroll_details"]->total_purchase;
			
					$City_id = $data["Enroll_details"]->City;
					$State_id = $data["Enroll_details"]->State;
					$Country_id = $data["Enroll_details"]->Country;
					$Date_of_birth = $data["Enroll_details"]->Date_of_birth;
					$Sex = $data["Enroll_details"]->Sex;
					$District = $data["Enroll_details"]->District;
					$Zipcode = $data["Enroll_details"]->Zipcode;
					$total_purchase = $data["Enroll_details"]->total_purchase;
					$Total_reddems = $data["Enroll_details"]->Total_reddems;
					$joined_date = $data["Enroll_details"]->joined_date;
				
					$get_city_state_country = $this->Shopping_model->Fetch_city_state_country($Company_id,$Customer_enroll_id);
					$State_name=$get_city_state_country->State_name;
					$City_name=$get_city_state_country->City_name;
					$Country_name=$get_city_state_country->Country_name;
					
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
						$lv_date_time2 = $date->format('Y-m-d'); 

						$Trans_type = 12;
						$Payment_type_id = 4; //COD
						$Paid_by = "Cash on Delivery";
						if($Payment_option==6)//mpesa
						{
							if($grand_total==0)
							{
								$Payment_type_id = 6; //mpesa
								$Paid_by = "M-PESA";
							}
							else
							{
								$Payment_type_id = 7; //mpesa & cash
								$Paid_by = "M-PESA & COD";
							}
							
						}
						
					$Remarks = "Online Purchase Transaction";
					
					$Customer_enroll_id = $cust_enrollment_id;

					$Delivery_type=$_SESSION["DeliveryType"];
					$DeliveryOutlet=$_SESSION["DeliveryOutlet"];
					$Address_type=$_SESSION["Address_type"];
					
					$Mpesa_TransID=$_SESSION["Mpesa_TransID"];
					$Bill_Amount_Due = ($grand_total - $_SESSION['mpesa_BillAmount']);
					$Mpesa_Total_Paid_Amount = $_SESSION['mpesa_BillAmount'];
							
					if($Mpesa_Total_Paid_Amount <= 0)
					{
						$Mpesa_TransID = "0";
					}						
//********** mpesa trans_id confirmation 05-10-2019 ***********************
					if($Mpesa_Total_Paid_Amount > 0 && ($Seller_api_url2 != "" || $Seller_api_url2 != NULL))
					{
						$input_args3 = Array ('TransID' => $Mpesa_TransID ,'BalanceDue' => number_format($Bill_Amount_Due,2),'MpesaPaidAmount' => number_format($Mpesa_Total_Paid_Amount,2),'BillRefNumber' => $bill);
						
						$input_args3 = json_encode($input_args3);
				//		print_r($input_args3);
						$url = $Seller_api_url2."ConfirmB2BPayment";
						//$url = 'http://localhost/amit/OnlineOrder.php';
						//$url = 'http://196.207.24.118:7070/onlineordering/novaonlineordering';
						//$url = 'http://localhost/CI_IGAINSPARK_LIVE_NEW/Api_call/OnlineOrder.php';
							
							$newHash = hash("sha256",$this->API_key,false);

							$ch = curl_init();
							$timeout = 0; // Set 0 for no timeout.
							curl_setopt($ch, CURLOPT_URL, $url);

							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS,$input_args3);
							//set the content type to application/json
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$newHash,'Content-Type:application/json'));
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
							$result3 = curl_exec($ch);
							curl_close($ch);
					//	echo "ConfirmB2BPayment---".$result3;

							$response3 = json_decode($result3, true);
							
							
					//print_r($response3);

					//$response = json_decode($result, true);
					//die;
						if($result3 == null || $result3 == "" || $response3['ResultCode'] != "0000")
						{ 
							$this->session->set_flashdata("mpesa_code","Invalid mpesa transaction id, please try again");
							
							redirect('Shopping/checkout2');
						}
				
							//echo json_encode($response)."<br>";
					}
			
		//********** mpesa trans_id confirmation 05-10-2019 ***********************
		//************** sandeep discount voucher 30-01-2020 ********************************
					$gift_cardid = 0;
				//	$voucherAmt = $this->session->userdata('voucherAmt'); 
					$Discount_codes = $this->session->userdata('Discount_codes'); //print_r($Discount_codes);
					
					if($Discount_codes != null)
					{
						foreach($Discount_codes as $y)
						{
						//	echo "Discount_voucher_code--".$y['Discount_voucher_code']; continue;
							if($y['Discount_voucher_code'] != "")
							{
								$giftData["Company_id"] = $Company_id;
								$giftData["Gift_card_id"] = $y['Discount_voucher_code'];
								$giftData["Card_balance"] = $y['Discount_voucher_amt'];
								$giftData["Card_id"] = $CardId;
								$giftData["User_name"] = trim($CustomerName);
								$giftData["Email"] = App_string_encrypt($CustomerEmail);
								$giftData["Phone_no"] = App_string_encrypt($phno);
								$giftData["Payment_Type_id"] = 99;
								$giftData["Seller_id"] = $delivery_outlet;
								$giftData["Valid_till"] = date("Y-m-d",strtotime($y['Discount_voucher_validity']));
								$giftData["Card_value"] = $y['Discount_voucher_amt'];
								
								$this->db->insert("igain_giftcard_tbl",$giftData);	
							
							//************** sandeep discount voucher 30-01-2020 ********************************
									
								$Email_content = array
									( 
										'Notification_type' => 'Thank you for your Purchase on '.$Company_name,
										'Transaction_date' => $lvp_date_time,
										'Symbol_of_currency' => $Country_details->Symbol_of_currency,
										'Orderno' => $bill,	
										'Outlet_address' => $Outlet_address,
										'CustEmail' => $CustomerEmail,
										'Voucher_no' => $y['Discount_voucher_code'],
										'Reward_amt' => $y['Discount_voucher_amt'],
										'Voucher_validity' => $y['Discount_Voucher_validity'],
										'Template_type' => 'Discount_voucher'
									);
									
							$GiftNotification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
							}
				//************** sandeep discount voucher 30-01-2020 ********************************
						}

					}
					
		//************** sandeep discount voucher 30-01-2020 ********************************
		
					$order_total_loyalty_points = 0;
					$count_item = count($this->cart->contents());					
					if ($cart = $this->cart->contents())
					{
						foreach ($cart as $item)
						{

							/********************************
								$characters = 'A123B56C89';
								$string = '';
								$Voucher_no="";
								for ($i = 0; $i < 10; $i++) 
								{
									$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
								}
								$Voucher_array[]=$Voucher_no;
							*************************************/							
							// $item_id = $item['id'];
							/********Get Merchandize item name********/					
								$item_id = $item['id'];
								$Item_category_id = $item['Item_category_id'];
								
								$result = $this->Shopping_model->Get_merchandize_item($item_id,$Company_id);
								
								$sellerID = $result->Seller_id;
								
								$Company_merchandize_item_code = $result->Company_merchandize_item_code;
								$Merchandize_item_name = $result->Merchandize_item_name;
								$Merchandize_category_id = $result->Merchandize_category_id;
							//******** 03-10-2019 sandeep **************************			
								$Combo_meal_flag = $result->Combo_meal_flag;
								$Combo_meal_number = $result->Combo_meal_number;
								$Extra_earn_points = 0;
								$Stamp_item_flag = $result->Stamp_item_flag;
								if($Stamp_item_flag == 1)
								{
									$Extra_earn_points = $result->Extra_earn_points;
								}
								
								$CondimentChildQuery = [];
								$CondimentChildQuery1 = [];
								$MainItemQty = $item["qty"];
					//	echo "req RequiredCondiments---"; print_r($item["options"]["RequiredCondiments"]);		
						
								if($item["options"]["RequiredCondiments"] != NULL)
								{
									$OReqItems = $item["options"]["RequiredCondiments"];
									
									foreach($OReqItems as $v0)
									{
										/* if($v0 != NULL)
										{
											$v0["Item_qty"] = $MainItemQty;
										} */
										$CondimentChildQuery[] = $v0;
										
										array_pop($v0); // to remove parent item code
										
										
										for($d = 0; $d < $MainItemQty; $d++)
										{
											$CondimentChildQuery1[] = $v0;
										}
									}

								}
						
					
								if($item["options"]["OptionalCondiments"] != NULL)
								{
									$OptionalItems = $item["options"]["OptionalCondiments"];
									foreach($OptionalItems as $v1)
									{
										/* if($v1 != NULL)
										{
											$v1["Item_qty"] = $MainItemQty;
										} */
										$CondimentChildQuery[] = $v1;
										array_pop($v1); // to remove parent item code
										
										for($d = 0; $d < $MainItemQty; $d++)
										{
											$CondimentChildQuery1[] = $v1;
										}
										
									//	$CondimentChildQuery1[] = $v1;
									}
								}
									
								if($Combo_meal_flag == 1)
								{
									$ComboMealMainItem = [];
									$MainCondimentsSet = [];
									
									$ComboMealMenuItem = array( 'Item_code' =>$item["options"]["Company_merchandize_item_code"] ,'Item_qty' => 1,'Item_rate' => number_format($item['price'],2) ,'Condiments' => array()); //$item["qty"]
									
									if($item['Main_item'] != NULL)
									{
										foreach($item['Main_item'] as $main)
										{			
											/* if($main["Condiments"] != NULL && $main["Condiments"][0]["Item_qty"] > 0)
											{
												$main["Condiments"][0]["Item_qty"] = $MainItemQty;
											} */
									//	print_r($main["Condiments"]);	

											$ComboMealMainItem1 = array( 'Item_code' =>$main["Main_or_side_item_code"] ,'Item_qty' => $main['Quanity'],'Item_rate' => number_format($main["Price"],2) , 'Condiments' => $main["Condiments"],"ParentItem_code"=>$item["options"]["Company_merchandize_item_code"]);
											
											$CondimentChildQuery[] = $ComboMealMainItem1;
											
											if($main["Condiments"] != NULL)
											{
												array_pop($main["Condiments"][0]);
											}
											
											/* foreach($main["Condiments"] as $condis)
											{
												for($d = 0; $d < $MainItemQty; $d++)
												{
													$MainCondimentsSet[] = $condis;
												}
											} */
											
											$ComboMealMainItem = array( 'Item_code' =>$main["Main_or_side_item_code"] ,'Item_qty' => $main["Quanity"],'Item_rate' => number_format($main["Price"],2) , 'Condiments' => $main["Condiments"]);
											//"Item_type" => "MAIN", $main["Quanity"]
											
										
											break;
										}
									}
									
									$sideItems = $item["options"]["SidesCondiments"];

									if($sideItems != NULL)
									{
										foreach($sideItems as $key10=>$v)
										{

											if($v != NULL)
											{
												$CondimentChildQuery[] = $v;
												
												if($sideItems[$key10]["Item_qty"] > 0)
												{
											//		$sideItems[$key10]["Item_qty"] = $MainItemQty;
											//		print_r($sideItems[$key10]["Condiments"]);
													array_pop($sideItems[$key10]); // to remove parent item code
													foreach($sideItems[$key10]["Condiments"] as $key100=>$v100)
													{
													//	$sideItems[$key10]["Condiments"][$key100]["Item_qty"] = $MainItemQty;
														array_pop($sideItems[$key10]["Condiments"][$key100]);
														/* array_pop($v100);
														for($d = 0; $d < $MainItemQty; $d++)
														{	
															$SideCondimentSet[] = $v100;
														} */
													}
													
													//$sideItems[$key10]["Condiments"] = $SideCondimentSet;
													/* if($sideItems[$key10]["Condiments"]["Item_qty"] > 0)
													{
														$sideItems[$key10]["Condiments"]["Item_qty"] = $MainItemQty;
													} */
												}
											//	$v["Item_qty"] = $MainItemQty;
												
											}
										}
									}
					
									for($m = 0; $m < $MainItemQty; $m++)
									{
										$combo_meals[] =  array("ComboMealMenuItem" => $ComboMealMenuItem,"ComboMealObjectNum"=>$Combo_meal_number,"ComboMealMainItem"=>$ComboMealMainItem,"SideItems" => json_decode(json_encode($sideItems)));
									}
								}
							
							//print_r($CondimentChildQuery);
							//die;
								$total_loyalty_points = 0;
							//******** 03-10-2019 sandeep **************************	
								/******************New Loyalty Rule Logic********************/ 
								
								if($sellerID!=0)
								{
								/**********Get Seller Details**********/
									$Seller_result = $this->Shopping_model->Get_Seller_details($sellerID,$Company_id);	
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
									
									$loyalty_prog = $this->Shopping_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
									
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
											
										$lp_details = $this->Shopping_model->get_loyalty_program_details($Company_id,$seller_id,$prog,$lv_date_time);
										
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
				// sandeep 25/11/2019			$transaction_amt=$item['qty'] * $item['price'];
												$transaction_amt=  $item['subtotal'];
											}
											if($lp_type == 'BA')
											{	
		//		sandeep 25/11/2019				$Purchase_amount=$item['qty'] * $item['price'];
												$Purchase_amount=  $item['subtotal'];
												// $transaction_amt = $grand_total;
												 $transaction_amt = (($grand_total * $Purchase_amount ) / $subtotal);
											}
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
																$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
																$trans_lp_id = $LoyaltyID_array[$i];
																$Applied_loyalty_id[]=$trans_lp_id;
																$gained_points_fag = 1;
																$points_array[] = $loyalty_points;
															}
														}
														else if($transaction_amt > $value[$i])
														{
															$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
															$gained_points_fag = 1;
															$trans_lp_id = $LoyaltyID_array[$i];
															$Applied_loyalty_id[]=$trans_lp_id;					
															$points_array[] = $loyalty_points;
														}
													}
												}
												if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 && $Merchandize_category_id == $Category_id )
												{
													$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[0]);
													$points_array[] = $loyalty_points;
													$gained_points_fag = 1;
													$trans_lp_id = $LoyaltyID_array[0];
													$Applied_loyalty_id[]=$trans_lp_id;
												}						
											// unset($dis);
											}
											else if($Segment_flag==1)
											{											
												$Get_segments2 = $this->Shopping_model->edit_segment_id($Company_id,$Segment_id);
												
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
													
													$Get_segments = $this->Shopping_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
													
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
																	$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
																	$trans_lp_id = $LoyaltyID_array[$i];
																	$Applied_loyalty_id[]=$trans_lp_id;
																	$gained_points_fag = 1;
																	$points_array[] = $loyalty_points;
																}
															}
															else if($transaction_amt > $value[$i])
															{
																$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
																$gained_points_fag = 1;
																$trans_lp_id = $LoyaltyID_array[$i];
																$Applied_loyalty_id[]=$trans_lp_id;					
																$points_array[] = $loyalty_points;
															}
														}
													}									
													if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2 )
													{	
														$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[0]);
														$points_array[] = $loyalty_points;
														$gained_points_fag = 1;
														$trans_lp_id = $LoyaltyID_array[0];
														$Applied_loyalty_id[]=$trans_lp_id;	
													}
												} 
											}
											else
											{
												if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 1)
												{
													for($i=0;$i<=count($value)-1;$i++)
													{
														if($i<count($value)-1 && $value[$i+1] != "")
														{
															if($transaction_amt > $value[$i] && $transaction_amt <= $value[$i+1])
															{
																$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
																$trans_lp_id = $LoyaltyID_array[$i];
																$Applied_loyalty_id[]=$trans_lp_id;
																$gained_points_fag = 1;
																$points_array[] = $loyalty_points;
															}
														}
														else if($transaction_amt > $value[$i])
														{
															$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[$i]);
															$gained_points_fag = 1;
															$trans_lp_id = $LoyaltyID_array[$i];
															$Applied_loyalty_id[]=$trans_lp_id;					
															$points_array[] = $loyalty_points;
														}
													}
												}

												if($member_Tier_id == $lp_Tier_id  && $Loyalty_at_flag == 2)
												{
													$loyalty_points = $this->Shopping_model->get_discount($transaction_amt,$dis[0]);
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
								/******************Get Supper Seller Details*********************/
									$total_loyalty_points=0;
									$Email_points[]=$total_loyalty_points;
								}
									$total_loyalty_points=round($total_loyalty_points + $Extra_earn_points); //	sandeep 
							 
							/******************New Category Wise Logic********************/ 
							
								$Voucher_status = 18; //'Ordered'
		//	sandeep 25/11/2019	$item_total_amount = $item['qty'] * $item['price'];
								$item_total_amount = $item['subtotal'];
								// $Weighted_loyalty_points = round(($total_loyalty_points * $item_total_amount) / $subtotal);
								if($sellerID!=0)
								{
									$Weighted_loyalty_points = round($total_loyalty_points);
								}
								else
								{
									$Weighted_loyalty_points = $Extra_earn_points; //	sandeep 
								}
					//	echo "--loyalty_points --".$Weighted_loyalty_points."<br>";	
								$order_total_loyalty_points = $order_total_loyalty_points + $Weighted_loyalty_points;
								
		//	sandeep 25/11/2019	$Purchase_amount=$item['qty'] * $item['price'];
								$Purchase_amount = $item['subtotal'];
								
								$Balance_to_pay = (($grand_total * $Purchase_amount ) / $subtotal);
								
								if($item['options']['Item_size'] == 1)
								{
								  $size = "Small";
								}
								elseif($item['options']['Item_size'] == 2)
								{	
									$size = "Medium";
								}
								elseif($item['options']['Item_size'] == 3)
								{
									$size = "Large";
								}
								elseif($item['options']['Item_size'] == 4)
								{
									$size = "Extra Large";
								}
								else
								{
									$size = "-";
								}										
								/****Calculate Weighted Shipping Cost AMIT 12-12-2017***/
								   $Partner_state=$item["options"]["Partner_state"];
									$Partner_Country_id=$item["options"]["Partner_Country_id"];
								/****************GET COST PRICE*********************/
								$Cost_price=$item['options']["Cost_price"];
								if($item['options']['Item_size'] != 0)
								{
									$Get_size_records = $this->Redemption_Model->Get_item_details_size($data['Company_id'],$Company_merchandize_item_code);
									foreach($Get_size_records as $rec2)
									{
										if($rec2["Item_size"]==$item['options']['Item_size'])
										{
											$Cost_price=$rec2["Cost_price"];
										}
									}
									
								}
								$Cost_payable_partner=$Cost_price+($Cost_price*($item['options']["VAT"]/100));
								$Cost_payable_partner=($Cost_payable_partner*$item["qty"]);
							
								/**Calculate Weighted Shipping Cost AMIT 16-09-2019*/	
							
							$Weighted_redeem_points = (($Cust_redeem_point * $item_total_amount) / $subtotal);
							$Bal_due=($grand_total-$_SESSION['mpesa_BillAmount']);
							$COD_Amount=(($Purchase_amount/$subtotal)*$Bal_due);
							$Mpesa_Paid_Amount=(($Purchase_amount/$subtotal)*$_SESSION['mpesa_BillAmount']);
							$Split_Shipping_cost=(($Purchase_amount/$subtotal)*$_SESSION['Total_Shipping_Cost']);
							$Weighted_Redeem_amount=(($Purchase_amount/$subtotal)*$_SESSION['Redeem_amount']);

							/*********Calculate Balance to pay amount New logic*********/
							
							$RedeemAmt=$Weighted_redeem_points/$Company_Redemptionratio;
							$PaidAmount=$Purchase_amount+$Split_Shipping_cost-$RedeemAmt;
							
							if($PaidAmount <= 0)
							{
								$PaidAmount = 0;
							}
							if($_SESSION['mpesa_BillAmount']==0) //only Cod
							{
								$COD_Amount=$PaidAmount;
							}
									
							/*********Calculate Balance to pay amount New logic*********/		  
								$data123 = array('Company_id' => $Company_id,
													'Trans_type' => $Trans_type,
													'Purchase_amount' => $Purchase_amount,
													'Paid_amount' => $PaidAmount,
													'Mpesa_Paid_Amount' => $Mpesa_Paid_Amount,
													'COD_Amount' => $COD_Amount,
													'Mpesa_TransID' => $Mpesa_TransID,
													'Payment_type_id' => $Payment_type_id,
													'Remarks' => $Remarks,
													'Trans_date' => $lv_date_time,
													'balance_to_pay' => $PaidAmount,
													'Shipping_cost' => $Split_Shipping_cost,
													'Shipping_points' => ($Split_Shipping_cost*$Company_Redemptionratio),
													'Enrollement_id' => $cust_enrollment_id,
													'Bill_no' => $bill,
													'Voucher_no' => $Voucher_no,
													'Card_id' => $CardId,
													'Seller' => $delivery_outlet,
													'Seller_name' => $Outlet_name,
													'Item_code' => $Company_merchandize_item_code,
													'Item_size' => $item['options']['Item_size'],
													'Voucher_status' => $Voucher_status,
													'Delivery_method' => $Delivery_method,
													'Merchandize_Partner_id' => $item["options"]["Partner_id"],
													'Merchandize_Partner_branch' => $item["options"]["Branch"],
													'Quantity' => $item['qty'],
													'Loyalty_pts' => $Weighted_loyalty_points,
													'Online_payment_method' => $Paid_by,
													'Cost_payable_partner' => $Cost_payable_partner,
													'Redeem_points' => $Weighted_redeem_points,
													'Redeem_amount' => $Weighted_Redeem_amount,
													'remark2' => $item["options"]['remark2'],
													'remark3' => $item["options"]['remark3'],
													'Table_no' => $Session_table_no
												);	

										$Transaction_detail = $this->Shopping_model->Insert_online_purchase_transaction($data123);
								
								if($Transaction_detail)
								{
								/******Insert online purchase log tbl entery*******/	
									$Company_id	= $Company_id;
									$Todays_date = date('Y-m-d');	
									$opration = 1;		
									$enroll	= $cust_enrollment_id;
									$username = $session_data['username'];
									$userid=$session_data['userId'];
									$what="Online Purchase Item";
									$where="e-Commerce";
									$To_enrollid =0;
									$firstName =$fname;
									$lastName =$lname; 
									$Seller_name =$fname.' '.$lname;
									$opval = $Merchandize_item_name.', ( Item id = '.$item_id.',Item Code = '.$Company_merchandize_item_code.', Quantity= '.$item['qty'].' )';
									$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
								/***Insert online purchase log tbl entery******/
								}
			//****************** 28-08-2019 sandeep ***********************************

							$Item_condiments = explode("+",$item["options"]['Condiments_code']);
					if(count($Item_condiments) > 0)
					{	
						$Condiments_details = array();
					
						foreach($Item_condiments as $condiment)
						{
							if($condiment != "")
							{
								for($p = 1; $p <= $item['qty']; $p++){
								
									$Condiments_details[] = array( 'Item_code' =>$condiment,'Item_rate' => '0.00');
								}
							}
						}
					}
					else
					{
						$Condiments_details = "";
					}
					
					if($Combo_meal_flag == 0)
					{
						$Item_details[] =  json_decode(json_encode(array( 'Item_code' =>$Company_merchandize_item_code , 'Item_qty' => $item['qty'], 'Item_rate' => number_format($item['price'],2),
						'Condiments' => $CondimentChildQuery1 )));
						
						//$combo_meals = "";
					}
					
					$sideItems = array();
					$main_itm_condiments = array();
					$sideItemsCondiments  = array();
						
		//print_r($Item_details);
			//****************** 28-08-2019 sandeep ***********************************				
								
								$loyalty_prog = $this->Shopping_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
								$lp_count = count($loyalty_prog);

								if(count($Applied_loyalty_id) != 0)
								{		
									for($l=0;$l<count($Applied_loyalty_id);$l++)
									{
										$Get_loyalty = $this->Shopping_model->Get_loyalty_details_for_online_purchase($Applied_loyalty_id[$l]);

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
														'Seller' => $delivery_outlet,
														'Enrollement_id' => $cust_enrollment_id,
														'Transaction_id' => $Transaction_detail,
														// 'Loyalty_id' => $trans_lp_id,
														'Loyalty_id' => $Applied_loyalty_id[$l], 									
														'Reward_points' => round($Calc_rewards_points),
														);
										$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data);
									}
								}
				//********* sandeep ***********		
							if($Transaction_detail > 0)
							{
								$result541 = $this->Shopping_model->insert_item_condiments($CondimentChildQuery,$data['Company_id'],$bill,$Transaction_detail,$Company_merchandize_item_code);
							}
				//********* sandeep ***********										
						}
						$total_loyalty_email=(array_sum($Email_points) + $Extra_earn_points);	
						
		//************** sandeep discount voucher 30-01-2020 ********************************
						//*****  redeemed discount voucher **************
							
							
							$redeemed_discount_voucher = 0; 
							
							if($_SESSION['Redeemed_discount_voucher'] != "")
							{
								$redeemed_discount_voucher = $_SESSION['Redeemed_discount_voucher'];
								// echo "fff redeemed_discount_voucher--".$redeemed_discount_voucher;
								$giftData1["Card_balance"] = 0;

								$this->db->where(array("Gift_card_id"=>$redeemed_discount_voucher,"Company_id"=>$Company_id));
								$this->db->update("igain_giftcard_tbl",$giftData1);	
								
								$Voucher_array[] = $redeemed_discount_voucher;
							}
							//*****  redeemed discount voucher **************
					}
						$Order_date = date('Y-m-d');
						if($delivery_type ==0)//Delivery
						{
							$customer_delivery_details=$this->Igain_model->Fetch_selected_customer_addresses($data['enroll']);
			
								$shipping_details = array
										(
											'Transaction_date' => $Order_date,
											'Enrollment_id' => $data['enroll'],
											'Cust_name' => $customer_delivery_details->Contact_person,
											'Cust_address' => $customer_delivery_details->Address,
											'Cust_city' => $customer_delivery_details->City_id,
											'Cust_zip' => $customer_delivery_details->Zipcode,
											'Cust_state' => $customer_delivery_details->State_id,
											'Cust_country' => $customer_delivery_details->Country_id,
											'Cust_phnno' => $customer_delivery_details->Phone_no,
											'Cust_email' => $session_data['username'],
											'Transaction_id' =>$bill,
											'Company_id' => $data['Company_id']
										);

								$shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);
						}
					
						/************* Update Current Balance ******************/
							$cid = $CardId;							
							$redeem_point = $Cust_redeem_point;	
							$Update_Current_balance = ($bal - $redeem_point);
						/************New Change By Ravi**30-10-2017***************/
							$Update_total_purchase = $total_purchase + $subtotal;
							$Update_total_reddems = $Total_reddems + $Cust_wish_redeem_point;
							$up = array('Current_balance' => $Update_Current_balance, 'total_purchase' => $Update_total_purchase, 'Total_reddems' => $Update_total_reddems);
							//$up = array('Current_balance' => $Update_Current_balance);			
							$this->Shopping_model->update_cust_balance($up,$cid,$Company_id);							
							$bill_no = $bill + 1;
							$billno_withyear = $str.$bill_no;
							$result4 = $this->Shopping_model->update_billno($seller_id,$billno_withyear);
						/*********** Update Current Balance ***************/

					/*****************Apply Loyalty Rule**********************/
					$lvp_date_time = date("Y-m-d H:i:s");  
//************* online order api call 28-08-2019 sandeep *********************

			//	echo "Seller_api_url --".$Seller_api_url."<br>";	
			// $Delivery_type '0' delivery and '1' for take away, and  '2' for in store
			
				if($Seller_api_url != "" || $Seller_api_url != NULL)
				{
					$phno = substr($phno,3); 
					
					if($delivery_type == 0){
						$Cust_selected_address22 = $Address_type_details->Address;
					}else{
						$Cust_selected_address22 = "";
					}
					
					if($Mpesa_Total_Paid_Amount <= 0 || $Mpesa_Total_Paid_Amount =="")
					{ 
						$Mpesa_TransID = ""; 
					}
					
					/*if($delivery_type == 0){
						$Newdelivery_type = 1;
					}
					else
					{
						$Newdelivery_type = 2;
					} */
					
					if($delivery_type == 0) // Delivery
					{
						$Newdelivery_type = 1;
					}
					else if($delivery_type == 1) // Take Away
					{
						$Newdelivery_type = 2;
					}
					else if($delivery_type == 2) // In-Store
					{
						$Newdelivery_type = 3;
					}
					else
					{
						$Newdelivery_type = 0; 
					}

					$Cust_selected_address22 = trim(preg_replace('/\s\s+/', ' ', $Cust_selected_address22));
					
					$Address_lines = explode(",",$Cust_selected_address22);
					
					$CustomerName = $fname.' '.$lname;	
					
					$input_args = Array ( 
					'Membership_id' => $CardId,'Member_name' => trim($CustomerName),'Phone_no' => $phno,'Transaction_date' => $lvp_date_time,'Orderno' => $bill,'Item_details' => $Item_details,'Combo_meals'=>$combo_meals, 'Sub_total' => number_format($subtotal,2) ,'Total_delivery_cost'=>number_format($_SESSION['Total_Shipping_Cost'], 2) , 'Redeem_points' => round($Cust_wish_redeem_point) ,'Redeem_amount' => number_format($EquiRedeem, 2) ,"Balance_Due" => number_format($Bill_Amount_Due, 2),"Mpesa_Paid_Amount" =>  number_format($Mpesa_Total_Paid_Amount, 2),"Mpesa_TransID" => $Mpesa_TransID,'Gained_points' => round($order_total_loyalty_points),'Balance_points' => $Update_Current_balance ,'Paid_by' => $Paid_by,
					"Discount_voucher_codeused" =>$_SESSION['Redeemed_discount_voucher'], "Discount_voucher_amountused" =>number_format($_SESSION['VoucherDiscountAmt'],2),
					'Symbol_of_currency' => $Country_details->Symbol_of_currency, 'Address_line1' => trim($Address_lines[0]),'Address_line2' => trim($Address_lines[1]),'Address_line3' => trim($Address_lines[2]),'Address_line4' => trim($Address_lines[3]),'Delivery_type' => $Newdelivery_type,'Outlet_id' => $delivery_outlet,'Outlet_name' => $Outlet_name,'Discount_details' => $Discount_codes );
 
					$input_args = json_encode($input_args);
					
					  echo "<pre>";	
					  echo $input_args;
					// die;
					
					$url = $Seller_api_url;
					
					//$url = 'http://196.207.24.118:7070/onlineordering/novaonlineordering';
					//$url = 'http://localhost/CI_IGAINSPARK_LIVE_NEW/Api_call/OnlineOrder.php';
				//echo "url --".$url."<br>";	

						$ch = curl_init();
						$timeout = 0; // Set 0 for no timeout.
						curl_setopt($ch, CURLOPT_URL, $url);

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS,$input_args);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
						//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
						//curl_setopt($ch, CURLOPT_CAINFO, "/etc/php/7.1/apache2/cacert.pem");
						//set the content type to application/json
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Flag '.$this->OnlineOrderAPI_key,'Content-Type:application/json'));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
						$result = curl_exec($ch);
						$err = curl_error($ch);
						curl_close($ch);
				
				//	echo "key response--".$this->OnlineOrderAPI_key."<br>";
				//	echo "POS response--".$result."<br>";
			
						if ($err) {
						  echo "cURL Error #:" . $err;
						} else {
						   // echo $result;
						}
						
						$response = json_decode(json_decode($result, true),true);
						//print_r($response);

						//$response = json_decode($result, true);
					
						if($result == null || $result == "" || $response['Status'] != "0000")
						{

						//echo "failed notification sent<br>";
							$Email_content = array
								(
									'Notification_type' => 'Thank you for your Purchase on '.$Company_name,
									'Transaction_date' => $lvp_date_time,
									'Orderno' => $bill,
									'Voucher_array' => $Voucher_array, 
									'Voucher_status' => $Voucher_status, 
									'Cust_wish_redeem_point' => round($Cust_wish_redeem_point), 
									'EquiRedeem' =>  round($EquiRedeem, 2),
									'subtotal' => $subtotal, 
									'grand_total' => round($grand_total, 2),
									// 'total_loyalty_points' => $total_loyalty_points, 
									'total_loyalty_points' => round($total_loyalty_email), 
									'Update_Current_balance' => $Update_Current_balance, 
									'Blocked_points' => $Blocked_points, 
									'Standard_charges' => $Standard_charges, 
									'Company_Redemptionratio' => $Company_Redemptionratio, 
									'Cost_Threshold_Limit' => $Cost_Threshold_Limit, 
									'To_Country' => $customer_delivery_details->Country_id, 
									'To_State' => $customer_delivery_details->State_id, 
									'Shipping_charges_flag' => $Shipping_charges_flag,
									'Symbol_of_currency' => $Country_details->Symbol_of_currency, 
									'Delivery_type' => $delivery_type1, 
									'DeliveryOutlet' => $delivery_outlet, 
									'Outlet_address' => $Outlet_address, 
									'Cust_selected_address' => $Cust_selected_address,
									'mpesa_BillAmount' => $_SESSION['mpesa_BillAmount'],
									'address_flag' => $_REQUEST['address_flag'], 
									'POS_bill_no' => $response['POS_Bill_No'], 
									'Mpesa_TransID' => $Mpesa_TransID, 
									'In_store_table_no' => $Session_table_no, 
									'DiscountAmt' => $_SESSION['DiscountAmt'],
									'VoucherDiscountAmt' => $_SESSION['VoucherDiscountAmt'],
									'Template_type' => 'Purchase_order_to_company'
								); 
								
							$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
						}
						//echo json_encode($response)."<br>";	
						$Order_manual_billno = "";
						if($response['Status'] == "0000")
						{
							$Order_manual_billno = $response['POS_Bill_No'];
							
							if($Order_manual_billno != "")
							{
							
							$updateData = array('Manual_billno' => $Order_manual_billno);
							
								$this->db->where(array('Bill_no' => $bill,'Card_id' => $CardId,'Company_id' => $Company_id));
								$this->db->update("igain_transaction",$updateData);
							}
						}
						
					/*************************Nilesh change-04-10-2019-Customer order notification************************/	
							$Email_content = array
									( 
										'Notification_type' => 'Thank you for your Purchase on '.$Company_name,
										'Transaction_date' => $lvp_date_time,
										'Orderno' => $bill,
										'Voucher_array' => $Voucher_array, 
										'Voucher_status' => $Voucher_status, 
										'Cust_wish_redeem_point' => round($Cust_wish_redeem_point), 
										'EquiRedeem' =>  round($EquiRedeem, 2),
										'subtotal' => $subtotal, 
										'grand_total' => round($grand_total, 2),
										// 'total_loyalty_points' => $total_loyalty_points, 
										'total_loyalty_points' => round($total_loyalty_email), 
										'Update_Current_balance' => $Update_Current_balance, 
										'Blocked_points' => $Blocked_points, 
										'Standard_charges' => $Standard_charges, 
										'Company_Redemptionratio' => $Company_Redemptionratio, 
										'Cost_Threshold_Limit' => $Cost_Threshold_Limit, 
										'To_Country' => $customer_delivery_details->Country_id, 
										'To_State' => $customer_delivery_details->State_id, 
										'Shipping_charges_flag' => $Shipping_charges_flag,
										'Symbol_of_currency' => $Country_details->Symbol_of_currency, 
										'Delivery_type' => $delivery_type1, 
										'DeliveryOutlet' => $delivery_outlet, 
										'Outlet_address' => $Outlet_address, 
										'Cust_selected_address' => $Cust_selected_address, 
										'mpesa_BillAmount' => $_SESSION['mpesa_BillAmount'], 
										'address_flag' => $_REQUEST['address_flag'], 
										'POS_bill_no' => $Order_manual_billno, 
										'Mpesa_TransID' => $Mpesa_TransID, 
										'In_store_table_no' => $Session_table_no, 
										'DiscountAmt' => $_SESSION['DiscountAmt'],
										'VoucherDiscountAmt' => $_SESSION['VoucherDiscountAmt'],
										'Template_type' => 'Purchase_order'
									);
									
					$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']); 
				/************** sandeep discount voucher 30-01-2020 ********************************
							if($gift_cardid != "")
							{		
								$Email_content = array
									( 
										'Notification_type' => 'Thank you for your Purchase on '.$Company_name,
										'Transaction_date' => $lvp_date_time,
										'Symbol_of_currency' => $Country_details->Symbol_of_currency,
										'Orderno' => $bill,	
										'Outlet_address' => $Outlet_address,
										'CustEmail' => $CustomerEmail,
										'Voucher_no' => $gift_cardid,
										'Reward_amt' => $voucherAmt,
										'Voucher_validity' => $voucherValidity,
										'Template_type' => 'Discount_voucher'
									);
									
							$GiftNotification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
							}
				************** sandeep discount voucher 30-01-2020 ********************************/
					
				/*****************************Nilesh change-04-10-2019-Customer order notification******************************/
				}
				else
				{
						$Email_content = array
									( 
										'Notification_type' => 'Thank you for your Purchase on '.$Company_name,
										'Transaction_date' => $lvp_date_time,
										'Orderno' => $bill,
										'Voucher_array' => $Voucher_array, 
										'Voucher_status' => $Voucher_status, 
										'Cust_wish_redeem_point' => round($Cust_wish_redeem_point), 
										'EquiRedeem' =>  round($EquiRedeem, 2),
										'subtotal' => $subtotal, 
										'grand_total' => round($grand_total, 2),
										// 'total_loyalty_points' => $total_loyalty_points, 
										'total_loyalty_points' => round($total_loyalty_email), 
										'Update_Current_balance' => $Update_Current_balance, 
										'Blocked_points' => $Blocked_points, 
										'Standard_charges' => $Standard_charges, 
										'Company_Redemptionratio' => $Company_Redemptionratio, 
										'Cost_Threshold_Limit' => $Cost_Threshold_Limit, 
										'To_Country' => $customer_delivery_details->Country_id, 
										'To_State' => $customer_delivery_details->State_id, 
										'Shipping_charges_flag' => $Shipping_charges_flag,
										'Symbol_of_currency' => $Country_details->Symbol_of_currency, 
										'Delivery_type' => $delivery_type1, 
										'DeliveryOutlet' => $delivery_outlet, 
										'Outlet_address' => $Outlet_address, 
										'Cust_selected_address' => $Cust_selected_address, 
										'mpesa_BillAmount' => $_SESSION['mpesa_BillAmount'], 
										'address_flag' => $_REQUEST['address_flag'], 
										'POS_bill_no' => $Order_manual_billno, 
										'Mpesa_TransID' => $Mpesa_TransID, 
										'In_store_table_no' => $Session_table_no, 
										'Template_type' => 'Purchase_order'
									);
									
						$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
				}
				
	//************* online order api call 28-08-2019 sandeep*********************
			
				$this->cart->destroy();
				
				$data['transaction_id'] = "";
				$data['Bill_no'] = $bill;
				$data['Manual_billno'] = $Order_manual_billno;
				
				$session_data['New_shipping_details'] = ""; 
				$session_data['Cart_redeem_point'] = ""; 
				$session_data['PaymentMethod'] = ""; 
				$session_data['ShippingType'] = ""; 
				
				$_SESSION["DeliveryType"]="";
				$_SESSION["DeliveryOutlet"]="";
				$_SESSION["Address_type"]="";
				$_SESSION["DiscountAmt"]="";
				$_SESSION["voucherAmt"]="";
		
				$this->session->set_userdata("cust_logged_in", $session_data);
				
			/*********************set table no session null************************/		
				// $session_data_table_no['Table_no'] = ""; 
				// $this->session->set_userdata("table_no_session", $session_data_table_no);
				$sess_array4 = array(
							'Table_no' => ""
						);
				$this->session->set_userdata('table_no_session', $sess_array4);	
			/*********************set table no session null************************/	
			
			/*********************set delivery outlet session null************************/	
				$sess_array3 = array(
							'delivery_type' => "",
							'delivery_outlet' => ""
						);
					$this->session->set_userdata('delivery_session', $sess_array3);	
			/*********************set delivery outlet session null************************/		
			die;
			$this->load->view('Shopping/payment_complete',$data);
		} 
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function place_order()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			// echo"---------place_order-------";
			// die;
			$session_data = $this->session->userdata('cust_logged_in');
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
				$Company_Redemptionratio = $Company['Redemptionratio'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			$Order_date = date('Y-m-d');
			$cart = $this->session->userdata('shopping_cart');
			
			if($_POST == NULL)
			{
				redirect('Shopping');
			}
			else
			{
				// echo "<pre>"; var_dump($_POST);die;
				$order_sub_total = 0;	 $shipping_cost = 99;	 $tax = 0;	 $i = 0;
				if ($cart1 = $this->cart->contents())
				{
					foreach ($cart1 as $item)
					{
						$order_sub_total = $order_sub_total + $item['subtotal'];
					}

					$order_total = $order_sub_total + $shipping_cost + $tax;
					
					$Order_id = random_string('alnum', 16);
					
					if( $this->input->post("shipping_address") == 1 )
					{
						$Cust_order = array
						(
							'Company_id' => $data['Company_id'],
							'Trans_type' => '8',
							'Purchase_amount' => $order_total,
							'Shipping_cost' => $shipping_cost,
							'Shipping_points' => ($shipping_cost*$Company_Redemptionratio),
							'Paid_amount' => $order_total,
							'Payment_type_id' => '5',
							'Trans_date' => $Order_date,
							'balance_to_pay' => $order_total,
							'Create_user_id' => $data['enroll'],
							'Enrollement_id' => $data['enroll'],
							'Manual_billno' => $Order_id,
							'Card_id' => $data['Card_id'],
							'remark2' => 'Online Shopping',
							'Delivery_status' => 'Received'
						);
						
						$cart['email'] = $this->input->post("email");
					}
					else
					{						
						$Cust_order = array
						(
							'Company_id' => $data['Company_id'],
							'Trans_type' => '8',
							'Purchase_amount' => $order_total,
							'Shipping_cost' => $shipping_cost,
							'Shipping_points' => ($shipping_cost*$Company_Redemptionratio),
							'Paid_amount' => $order_total,
							'Payment_type_id' => '5',
							'Trans_date' => $Order_date,
							'balance_to_pay' => $order_total,
							'Create_user_id' => $data['enroll'],
							'Enrollement_id' => $data['enroll'],
							'Manual_billno' => $Order_id,
							'Card_id' => $data['Card_id'],
							'remark2' => 'Online Shopping',
							'Delivery_status' => 'Received'
						);
						
						$cart['email'] = $this->input->post("email1");
					}
					
					$cust_id = $this->Shopping_model->insert_transaction($Cust_order);		
					
					if( $this->input->post("shipping_address") == 2 )
					{
						$shipping_details = array
						(
							'Transaction_date' => $Order_date,
							'Enrollment_id' => $data['enroll'],
							'Cust_name' => $this->input->post("firstname1")." ".$this->input->post("lastname1"),
							'Cust_address' => $this->input->post("address1"),
							'Cust_city' => $this->input->post("city1"),
							'Cust_zip' => $this->input->post("zip1"),
							'Cust_state' => $this->input->post("state1"),
							// 'Cust_country' => $this->input->post("country1"),
							'Cust_phnno' => $this->input->post("phone1"),
							'Cust_email' => $this->input->post("email1"),
							'Transaction_id' => $cust_id,
							'Company_id' => $data['Company_id']
						);						
						$shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);
					}
					else
					{
						$shipping_details = array
						(
							'Transaction_date' => $Order_date,
							'Enrollment_id' => $data['enroll'],
							'Cust_name' => $this->input->post("firstname")." ".$this->input->post("lastname"),
							'Cust_address' => $this->input->post("address"),
							'Cust_city' => $this->input->post("city"),
							'Cust_zip' => $this->input->post("zip"),
							'Cust_state' => $this->input->post("state"),
							// 'Cust_country' => $this->input->post("country"),
							'Cust_phnno' => $this->input->post("phone"),
							'Cust_email' => $this->input->post("email"),
							'Transaction_id' => $cust_id,
							'Company_id' => $data['Company_id']
						);						
						$shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);
					}
					
					foreach ($cart1 as $item)
					{
						$order_detail = array(
							'Enrollement_id' => $data['enroll'],
							'Transaction_id' => $cust_id,
							'Company_id' => $data['Company_id'],
							'Product_id' => $item['id'],
							'Quantity' => $item['qty'],
							'Unit_price' => $item['price'],
							'Transaction_date' => $Order_date
						);

						$ord_id = $this->Shopping_model->insert_transaction_child($order_detail);
					}
					
					// $cart['paypal_transaction_id'] = $cust_id;
					$cart['paypal_transaction_id'] = $Order_id;
					$this->load->vars('cart', $cart);
					$this->session->set_userdata('shopping_cart', $cart);
					
					$Order_details = $this->Shopping_model->get_order_details2($cust_id,$data['enroll'],$data['Company_id']);
					$Order_details2 = $this->Shopping_model->get_order_details($cust_id,$data['enroll']);
					$Email_content = array(
						'Enrollment_id' => $data['enroll'],
						'Notification_type' => 'Your Order confirmation for #'.$Order_id,
						'Template_type' => 'Shopping_order_confirm',
						'Order_no' => $Order_id,
						'Order_date' => $Order_date,
						'Symbol_of_currency' => $data['Symbol_of_currency'],
						'Order_details' => $Order_details,
						'Order_details2' => $Order_details2
					);								
					$send_notification = $this->send_notification->send_Notification_email($data['enroll'],$Email_content,'1',$data['Company_id']);
						
					$this->cart->destroy();					
					// $this->load->view('express_checkout/payment_complete',$data);
				}
				else
				{
					redirect('Shopping');
				}
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function add_to_wishlist()
    {
		$insert_data = array
		(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'Size' => $this->input->post('Size'),
			'qty' => 1
		);
		$result = $this->wishlist->insert($insert_data);
        if($result)
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '1')));
		}
		else    
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '0')));
		}
    }
	
	public function view_wishlist()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
				
			$this->load->view('Shopping/view_wishlist', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function remove_wishlist() 
	{
		$rowid = $_GET['rowid'];

		if( $rowid )
		{
            $this->wishlist->remove_item($rowid);
		}
		redirect('Shopping/view_wishlist');
	}
	
	public function move_to_cart()
	{ 
		/*$insert_data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'qty' => 1
		);		
		$result = $this->cart->insert($insert_data);*/
		
		$this->wishlist->remove_item($this->input->post('rowid'));
		
		/*$cart_check = $this->cart->contents();
		$grand_total = 0;
		if ($cart = $this->cart->contents()) 
		{								
			foreach ($cart as $item)
			{
				$grand_total = $grand_total + $item['subtotal'];
			}
		}
			*/	
		if($result)
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => number_format($grand_total, 2))));
		}
		else    
		{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => number_format($grand_total, 2))));
		}
	}
	
	public function my_orders()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			/*-----------------------Pagination---------------------*/				
			$config = array();
			$config["base_url"] = base_url() . "//index.php/Shopping/my_orders";
			$total_row = $this->Shopping_model->get_orders('','',$data['enroll'],$data['Company_id']);
			//echo "total_row ".$total_row;
			$config["total_rows"] = count($total_row);
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
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$return_policy_in_days = $Company['Ecommerce_return_policy_in_days'];
			}
			$data['Return_policy_in_days'] = $return_policy_in_days;
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
				
			$data["Orders"] = $this->Shopping_model->get_orders($config["per_page"],$page,$data['enroll'],$data['Company_id']);
			
			$this->load->view('Shopping/my_orders', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function order_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				 $Company_Redemptionratio = $Company['Redemptionratio'];	
			}
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;

			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			$data['Redemptionratio'] = $Company_Redemptionratio;
				
			if($_GET['serial_id'] != "")
			{	
				
				$serial_id = $this->string_decrypt($_GET['serial_id'],$this->key, $this->iv);	
				$Serial_id_decrypt = preg_replace("/[^(\x20-\x7f)]*/s", "",$serial_id);
				
				/*if($Serial_id_decrypt == ""){
					
					$this->load->view('err404',$data); 

				} else {

					$data["Order"] = $this->Shopping_model->get_order_details($_GET['serial_id']);
					$data["Order_details"] = $this->Shopping_model->get_order_details2($_GET['serial_id']);
					$this->load->view('Shopping/order_details', $data);

				} */
				
				$data["Order"] = $this->Shopping_model->get_order_details($_GET['serial_id'],$data['enroll']);
				$data["Order_details"] = $this->Shopping_model->get_order_details2($_GET['serial_id'],$data['enroll'],$data['Company_id']);
				
				$this->load->view('Shopping/order_details', $data);
			}
			else
			{
				redirect('Shopping');   
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
        
    function Update_item_quantity()
	{
            $Quantity = $this->input->post('Quantity');
            $rowid = $this->input->post('RowId');
            
            if($Quantity > 0)
            {
                $data = array('rowid' => $rowid, 'qty' => $Quantity);
                $update_return = $this->cart->update($data);

                if($update_return == true)
                {
                    $grand_total = 0;
                    if ($cart = $this->cart->contents()) 
                    {								
                        foreach ($cart as $item)
                        {
                            if($item['rowid'] == $rowid)
                            {
                                $Item_subtotal = $item['subtotal'];
                                $Item_unitprice = $item['price'];
                            }
                            $grand_total = $grand_total + $item['subtotal'];
                        }
                    }

                    // echo "Item Subtotal-------".$Item_subtotal."<br>";
                    // echo "grand_total-------".$grand_total."<br>";
                    $Result = array('Error_flag' => 0, 'grand_total' => number_format((float)$grand_total, 2), "Item_subtotal" => number_format((float)$Item_subtotal, 2), "Item_unitprice" => number_format((float)$Item_unitprice, 2) );
                }
                else
                {
                    $grand_total = 0;
                    if ($cart = $this->cart->contents()) 
                    {								
                        foreach ($cart as $item)
                        {
                            if($item['rowid'] == $rowid)
                            {
                                $Item_subtotal = $item['subtotal'];
                                $Item_unitprice = $item['price'];
                            }
                            $grand_total = $grand_total + $item['subtotal'];
                        }
                    }

                    $Result = array('Error_flag' => -1, 'grand_total' => $grand_total, "Item_subtotal" => number_format((float)$Item_subtotal, 2), "Item_unitprice" => number_format((float)$Item_unitprice, 2) );
                }
            }
            else
            {
                $Result = array('Error_flag' => -2);
            }
            
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($Result));
            
            /*foreach( $cart_info as $id => $cart )
            {	
                $rowid = $cart['rowid'];
                $price = $cart['price'];
                $amount = $price * $cart['qty'];
                $qty = $cart['qty'];

                $data = array(
                        'rowid'   => $rowid,
                        'price'   => $price,
                        'amount' =>  $amount,
                        'qty'     => $qty
                );             
                    $this->cart->update($data);
            }
            redirect('Shopping/view_cart');   */
	}
/************************************************Akshay Start***********************************************/
    
	 public function cal_redeem_amt_contrl()
	{
		// echo"cal_redeem_amt_contrl";
		$Current_balance = $this->input->post('Current_balance');
		$grand_total = $this->input->post('grand_total');
		$Redeem_points = $this->input->post('Redeem_points');
		$ratio_value = $this->input->post('ratio_value');
		$redeemBY = $this->input->post('redeemBY');
		
		if($redeemBY == 0)
		{
			/*$session_data = $this->session->userdata('cust_logged_in');
			if(!isset($session_data['Cart_redeem_point']))
			{
				$session_data['Cart_redeem_point'] = 0; 
				$this->session->set_userdata("cust_logged_in", $session_data);
			}
			else
			{	
				$session_data['Cart_redeem_point'] = 0; 
				$this->session->set_userdata("cust_logged_in", $session_data);
			}*/
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
					/*if($this->session->userdata('cust_logged_in'))
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
					}*/
						
					$Total_bill = ($grand_total - $EquiRedeem);					
					if($Total_bill < 0){
						$Total_bill = 0;
						$EquiRedeem=$grand_total;
					}
					// $Total_bill = ($grand_total - round($EquiRedeem,1,2));
					$Total_bill=round($Total_bill,2);
					$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
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
					/*if($this->session->userdata('cust_logged_in'))
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
					}*/
						
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
	/*    
    public function cal_redeem_amt_contrl()
	{
		$Current_balance = $this->input->post('Current_balance');
		$grand_total = $this->input->post('grand_total');
		$Redeem_points = $this->input->post('Redeem_points');
		$ratio_value = $this->input->post('ratio_value');
		$redeemBY = $this->input->post('redeemBY');	   
	
		if($redeemBY == 0)
		{ 
			$_SESSION['Redeem_points'] = 0;
			
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
			$Result21 = array('Error_flag' => 3 ); // Customer dont want to wish redeem point
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

							// $_SESSION['Cart_redeem_point'] = $Redeem_points;
						}
					}

					$Total_bill = ($grand_total - $EquiRedeem);
					// $Total_bill = number_format($Total_bill,2);
					$Result21 = array('Error_flag' => 0, 'Grand_total' => $Total_bill, 'EquiRedeem' => $EquiRedeem);
					$_SESSION['Redeem_points'] = $Redeem_points;
				}
			} 
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($Result21));
	}*/
	public function Update_order_status()
	{	
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($Company_id);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];
				$Company_name = $Company['Company_name'];
			}
			
			
			$Country_details = $this->Igain_model->get_dial_code($Country );
			
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			$Symbol_of_currency = $Country_details->Symbol_of_currency;	
			
			
				$Item_id=$_REQUEST["serial_id"];
				$Bill_no=$_REQUEST["Bill_no"];
				$Voucher_no=$_REQUEST["Voucher_no"];
				
				$Cust_Enrollement_id = $data['enroll'];
				
				$Current_balance = $data["Enroll_details"] -> Current_balance;
				$Blocked_points = $data["Enroll_details"] -> Blocked_points;
				$Debit_points = $data["Enroll_details"] -> Debit_points;
				$total_purchase = $data["Enroll_details"] -> total_purchase;
				$Total_topup_amt = $data["Enroll_details"] -> Total_topup_amt;
				$Total_reddems = $data["Enroll_details"] -> Total_reddems;
				$MembershipID = $data["Enroll_details"] -> Card_id;
				//echo "Item_id ".$Item_id;die;
				if($Item_id != NULL)
				{
						
						$data["Order"] = $this->Shopping_model->get_order_details1($Item_id,$Bill_no,$Voucher_no);
						
						$balance_to_pay = $data["Order"] ->Paid_amount;
						$Redeem_points = $data["Order"] ->Redeem_points;
						$Loyalty_pts = $data["Order"] ->Loyalty_pts;
						$Voucher_status1 = $data["Order"] ->Voucher_status;
						$Purchase_amount = $data["Order"] ->Purchase_amount;
						$Quantity = $data["Order"] ->Quantity;
						$Trans_date = $data["Order"] ->Trans_date;
						$Item_code = $data["Order"] ->Item_code;
						$Order_no = $data["Order"] -> Voucher_no;
						$Shipping_points = $data["Order"] -> Shipping_points;
						$Company_merchandize_item_code = $data["Order"] -> Item_code;
						$Merchandize_Partner_id = $data["Order"] -> Merchandize_Partner_id;
						$Merchandize_Partner_branch = $data["Order"] -> Merchandize_Partner_branch;
						$Online_payment_method = $data["Order"] -> Online_payment_method;
						$lv_Voucher_status = $data["Order"] -> Voucher_status;
					
						$result = $this->Shopping_model->Get_merchandize_item12($Item_code,$data['Company_id']);
						
							$Item_name = $result->Merchandize_item_name;
						
							$Voucher_status = 21; //Cancel
						
							$Update_status = $this->Shopping_model->Update_online_purchase_item($Voucher_status,$data['enroll'],$Bill_no,$Voucher_no);
							
							$balance_to_pay_in_points = round($balance_to_pay*$Company_Redemptionratio);
							
							if($Online_payment_method == 'COD')
							{
								
								// $Calc_Credit_points=($Redeem_points)-$Loyalty_pts;
								
								$Calc_Credit_points1= $Redeem_points;
								$Calc_Credit_points=(abs($Calc_Credit_points1));
								
								$Update_Current_balance=($Current_balance+$Calc_Credit_points);
								$Update_total_reddems = $Total_reddems - $Calc_Credit_points;
								$Update_total_purchase = $total_purchase - $Purchase_amount;
								// $Update_total_topup = $Total_topup_amt + $Calc_Credit_points;
								$Update_total_topup = $Total_topup_amt;
								
								$update_enroll = array('Current_balance' => $Update_Current_balance,'Total_reddems' => $Update_total_reddems, 'total_purchase' => $Update_total_purchase, 'Total_topup_amt' => $Update_total_topup);
                            		
                                $this->Shopping_model->Update_online_purchase_cancel_item_points($update_enroll,$Cust_Enrollement_id,$Company_id);
							}
							else
							{
								if($lv_Voucher_status==18)
								{
									$Calc_Credit_points1=($Redeem_points+$balance_to_pay_in_points);
								}
								else
								{
									$Calc_Credit_points1=($Redeem_points+$balance_to_pay_in_points-$Shipping_points);
								}
								
								$Calc_Credit_points=abs($Calc_Credit_points1);
								
								$Update_Current_balance=($Current_balance+$Calc_Credit_points);
								$Update_total_reddems = $Total_reddems - $Redeem_points;
								$Update_total_purchase = $total_purchase - $Purchase_amount;
								$Update_total_topup = $Total_topup_amt + $Calc_Credit_points;
								
								$update_enroll = array('Current_balance' => $Update_Current_balance,'Total_reddems' => $Update_total_reddems, 'total_purchase' => $Update_total_purchase, 'Total_topup_amt' => $Update_total_topup);
								
								$this->Shopping_model->Update_online_purchase_cancel_item_points($update_enroll,$Cust_Enrollement_id,$Company_id);
							}
							
							/*$Calc_Credit_points=(abs($Calc_Credit_points));
							
							$Current_balance=($Current_balance+$Calc_Credit_points);
							$Update_balance = $this->Shopping_model->Update_online_purchase_cancel_item_points($Cust_Enrollement_id,$Current_balance,$data['enroll']);
							
							$Current_balance_block = $Current_balance - $Blocked_points;*/
							
							$Current_balance_block = $Update_Current_balance - ($Blocked_points+$Debit_points);
							
							
							/*********************Send Notification***************/
							$Email_content3 = array(
								'Trans_date' => $Trans_date,
								'Item_name' => $Item_name,
								'Order_no' => $Bill_no,
								'Voucher_no' => $Order_no, 
								'Symbol_of_currency' => $Symbol_of_currency, 
								'Purchase_amount' => $Purchase_amount,
								'Quantity' => $Quantity,
								// 'Branch_name' => $Branch_name,
								// 'Branch_Address' => $Branch_Address,
								'Voucher_status' => $Voucher_status,
								'Credit_points' => $Calc_Credit_points,
								'Balance_points' => $Current_balance_block,
								'Notification_type' => 'Your '.$Company_name.' Order # '.$Bill_no.' has been CANCELLED',
								'Template_type' => 'Purchase_Cancel'
							);
						
						$Credit_Notification1=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content3,'1',$Company_id);
							/******************Get Supper Seller Details*********************/
                            $Super_seller_flag = 1;
                            $result = $this->Shopping_model->Get_Seller($Super_seller_flag,$Company_id);				   
                            $seller_id = $result->Enrollement_id;
                            $seller_fname = $result->First_name;
                            $seller_lname = $result->Last_name;
                            $seller_name = $seller_fname .' '. $seller_lname;
                            $Seller_Redemptionratio = $result->Seller_Redemptionratio;
                            $Purchase_Bill_no = $result->Purchase_Bill_no;	
						/**************Insert transaction**********************/
							$Insert_data = array(
								'Trans_type' => 17,//Purchase Return
								'Trans_date' => $Trans_date,
								'Item_code' => $Company_merchandize_item_code,
								'Bill_no' => $Bill_no,
								'Voucher_no' => $Order_no,
								'Topup_amount' => $Calc_Credit_points,
								'Quantity' => $Quantity,
								'Voucher_status' => $Voucher_status,
								'Delivery_method' => 29,
								'Merchandize_Partner_id' => $Merchandize_Partner_id,
								'Merchandize_Partner_branch' => $Merchandize_Partner_branch,
								'Enrollement_id' => $Cust_Enrollement_id,
								'Card_id' => $MembershipID,
								'Company_id' => $Company_id,
								'Seller' => $seller_id,
								'Seller_name' => $seller_name,
								'Remarks' => 'Order Cancel'
								);
							$InsertCredit=$this->Shopping_model->Insert_purchase_cancel_trans($Insert_data);										
					/*******************************Insert return initiated log tbl entery**********************************/	
						
						$Company_id	= $Company_id;
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Order Cancel";
						$where="Purchase Order";
						$To_enrollid =0;
						$firstName =$data["Enroll_details"]->First_name;
						$lastName =$data["Enroll_details"]->Last_name; 
						$Seller_name =$data["Enroll_details"]->First_name.' '.$data["Enroll_details"]->Last_name;
						$opval = $Order_no;
						$opval ='Voucher No.: '.$Order_no.', Item Name: '.$Item_name.', Quantity: '.$Quantity;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
					/*******************************Insert return initiated log tbl entery**********************************/	
				}
				// die;
				if($InsertCredit != NULL)
				{
					$this->session->set_flashdata("Items_flash","Order Cancel Successfully!!");
					redirect("Shopping/my_orders");
				}
				else
				{	
					$this->session->set_flashdata("Items_flash","Order Cancel Unsuccessful!!");
					redirect("Shopping/my_orders");
				}
			
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	public function Update_order_status_return()
	{	
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($Company_id);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];
				$Company_name = $Company['Company_name'];
			}
			
			
			$Country_details = $this->Igain_model->get_dial_code($Country );
			
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			$Symbol_of_currency = $Country_details->Symbol_of_currency;	
			
			
				$Item_id=$_REQUEST["serial_id"];
				$Bill_no=$_REQUEST["Bill_no"];
				$Voucher_no=$_REQUEST["Voucher_no"];
				
				$Cust_Enrollement_id = $data['enroll'];
				
				$Current_balance = $data["Enroll_details"] -> Current_balance;
				$Blocked_points = $data["Enroll_details"] -> Blocked_points;
				$MembershipID = $data["Enroll_details"] -> Card_id;
				//echo "Item_id ".$Item_id;die;
				if($Item_id != NULL)
				{
						
						$data["Order"] = $this->Shopping_model->get_order_details1($Item_id,$Bill_no,$Voucher_no);
						
						$balance_to_pay = $data["Order"] ->Paid_amount;
						$Redeem_points = $data["Order"] ->Redeem_points;
						$Loyalty_pts = $data["Order"] ->Loyalty_pts;
						$Voucher_status1 = $data["Order"] ->Voucher_status;
						$Purchase_amount = $data["Order"] ->Purchase_amount;
						$Quantity = $data["Order"] ->Quantity;
						$Trans_date = $data["Order"] ->Trans_date;
						$Item_code = $data["Order"] ->Item_code;
						$Order_no = $data["Order"] -> Voucher_no;
						$Company_merchandize_item_code = $data["Order"] -> Item_code;
						$Online_payment_method = $data["Order"] -> Online_payment_method;
					
						$result = $this->Shopping_model->Get_merchandize_item12($Item_code,$data['Company_id']);
						
						$Item_name = $result->Merchandize_item_name;
						$Partner_id = $result->Partner_id;
						// var_dump($Partner_id);die;
						$Voucher_status = 22; //'Return Initiated';
					
						$Update_status = $this->Shopping_model->Update_online_purchase_item($Voucher_status,$data['enroll'],$Bill_no,$Voucher_no);
							
						$data["Partner"] = $this->Shopping_model->get_parner_details($Partner_id,$Company_id);
						// var_dump($data["Partner"]);die;
						$Partner_id = $data["Partner"] ->Partner_id;	
						$Partner_name = $data["Partner"] ->Partner_name;	
						$Partner_contact_person_name = $data["Partner"] ->Partner_contact_person_name;	
						$Partner_contact_person_email = $data["Partner"] ->Partner_contact_person_email;	
						
						$Super_seller_flag = 1;
                        $result1 = $this->Shopping_model->Get_Seller($Super_seller_flag,$Company_id);
						$User_email_id =$result1->User_email_id;
						$seller_fname = $result1->First_name;
                        $seller_lname = $result1->Last_name;
                        $seller_name = $seller_fname .' '. $seller_lname;
						/*********************Send Notification***************/
							$Email_content3 = array(
								'Trans_date' => $Trans_date,
								'Item_name' => $Item_name,
								'Order_no' => $Bill_no,
								'Voucher_no' => $Voucher_no,
								'Symbol_of_currency' => $Symbol_of_currency,
								'Purchase_amount' => $Purchase_amount,
								'Redeem_points' => $Redeem_points,
								'Quantity' => $Quantity, 
								'Voucher_status' => $Voucher_status,
								'Notification_type' => 'Your '.$Company_name.' Order #'.$Bill_no.' has been RETURNED initiated',
								'Template_type' => 'Purchase_item_return_initiated'
							);
						
						$Credit_Notification1=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content3,'1',$Company_id);
						
						/*********************Send Notification to admin and partner ***************/
							$Email_content4 = array(
								'Trans_date' => $Trans_date, 
								'Item_name' => $Item_name,
								'Order_no' => $Bill_no,
								'Voucher_no' => $Voucher_no,
								'Symbol_of_currency' => $Symbol_of_currency,
								'Purchase_amount' => $Purchase_amount,
								'Redeem_points' => $Redeem_points,
								'Quantity' => $Quantity, 
								'Voucher_status' => $Voucher_status,
								'admin_email' => $User_email_id,
								'Partner_contact_person_name' => $Partner_contact_person_name,
								'Partner_contact_person_email' => $Partner_contact_person_email,
								'Notification_type' => 'Order #'.$Bill_no.' has been return initiated',
								'Template_type' => 'Purchase_item_return_initiated_to_admin'
							);
						
						$Credit_Notification2=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content4,'1',$Company_id);
						
						/*******************************Insert return initiated log tbl entery**********************************/	
							$Company_id	= $Company_id;
							$Todays_date = date('Y-m-d');	
							$opration = 2;		
							$enroll	= $data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Order Return Initiated";
							$where="Purchase Order";
							$To_enrollid =0;
							$firstName =$data["Enroll_details"]->First_name;
							$lastName =$data["Enroll_details"]->Last_name; 
							$Seller_name =$data["Enroll_details"]->First_name.' '.$data["Enroll_details"]->Last_name;
							$opval ='Voucher No.: '.$Voucher_no.', Item Name: '.$Item_name.', Quantity: '.$Quantity;
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
					/*******************************Insert return initiated log tbl entery**********************************/
							
				}
				if($Update_status != NULL)
				{
				$this->session->set_flashdata("Items_flash","Order Return Initiated Successfully!!");
				redirect("Shopping/my_orders");	
				}
				else
				{
					$this->session->set_flashdata("Items_flash","Order Return Initiated Unsuccessful!!");
					redirect("Shopping/my_orders");	
				}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	/********************************Ravi 26-03-2019 emcryption*************************************/
	
	/********************************Ravi 28-08-2019 address*************************************/
	/*public function customer_address()
	{	
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($Company_id);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];
				$Company_name = $Company['Company_name'];
			}
			
				// var_dump($_POST);
				// die;
				if($_POST != "")
				{
				
					
					
					$Contact_person=$this->input->post('Contact_person');
					$Address=$this->input->post('Address');
					$Zipcode=$this->input->post('Zipcode');
					$Phone_no=$this->input->post('Phone_no');
					$country1=$this->input->post('country1');
					$state=$this->input->post('state');
					$city=$this->input->post('city');
					$Address_type=$this->input->post('Address_type');
					
					
					
					$check_address = $this->Igain_model->check_customer_address($data['enroll'],$Company_id,$Address_type);
					// echo"---check_address----".$check_address."---<br>";
					if($check_address ){
						
						// echo"---Update--<br>";
						
						$Update_data=array(				

							'Contact_person'=>$this->input->post('Contact_person'),
							'Phone_no'=>$this->input->post('Phone_no'),
							'Address'=>$this->input->post('Address'),
							'Country_id'=>$this->input->post('country'),
							'State_id'=>$this->input->post('state'),
							'City_id'=>$this->input->post('city'),
							'Zipcode'=>$this->input->post('Zipcode'),
							'Update_date'=>date('Y-m-d')
					
						);
						
						$update_address = $this->Igain_model->update_customer_address($Update_data,$data['enroll'],$Company_id,$Address_type);
						
						if($update_address)
						{
							$this->session->set_flashdata("error_code","Address update successfully.");
							redirect("Shopping/checkout");	
						}
						else
						{
							$this->session->set_flashdata("error_code","Address update unsuccessful.");
							redirect("Shopping/checkout");	
						}
						
					} else {
						
						// echo"---Insert--<br>";
						
						
						$Insert_data=array(					
							'Address_type'=>$Address_type,
							'Company_id'=>$Company_id,
							'Enrollment_id'=>$data['enroll'],
							'Contact_person'=>$this->input->post('Contact_person'),
							'Phone_no'=>$this->input->post('Phone_no'),
							'Address'=>$this->input->post('Address'),
							'Country_id'=>$this->input->post('country'),
							'State_id'=>$this->input->post('state'),
							'City_id'=>$this->input->post('city'),
							'Zipcode'=>$this->input->post('Zipcode'),
							'Create_date'=>date('Y-m-d'),
							'Update_date'=>date('Y-m-d')					
						);		
							
						$insert_address = $this->Igain_model->insert_customer_address($Insert_data);
						if($insert_address)
						{
							// $this->session->set_flashdata("error_code","Address inserted successfully.");
							redirect("Shopping/checkout");	
						}
						else
						{
							// $this->session->set_flashdata("error_code","Address inserted unsuccessful.");
							redirect("Shopping/checkout");	
						}
					}
				}
				else{
					
					// $this->session->set_flashdata("error_code","Please provide valid data.");
					redirect("Shopping/checkout");	
				}
				
				die;
				
				
				
				
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	*/
	
	/************************01-10-2019 Nilesh cahnge address***************************/
	public function customer_address()
	{	
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $data['Company_id'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
				
			$Company_details = $this->Igain_model->Fetch_Company_Details($Company_id);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$Company_Redemptionratio = $Company['Redemptionratio'];
				$Company_name = $Company['Company_name'];
			}
			
			if($_POST != "")
			{
				$Contact_person=$this->input->post('Contact_person');
				$Address=$this->input->post('Address');
				$Zipcode=$this->input->post('Zipcode');
				$Phone_no=$this->input->post('Phone_no');
				$country1=$this->input->post('country1');
				$state=$this->input->post('state');
				$city=$this->input->post('city');
				$Address_type=$this->input->post('Address_type');
				
				$check_address = $this->Igain_model->check_customer_address($data['enroll'],$Company_id,$Address_type);
				
				if($check_address )
				{
					$Building_name=$_REQUEST['Building_name'];
					$House_no=$_REQUEST['House_no'];
					$Street_road=$_REQUEST['Street_road'];
					$Additional=$_REQUEST['Additional'];
					$currentAddress =$Building_name.','.$House_no.','.$Street_road.','.$Additional;
					
					$Update_data=array(				

						'Contact_person'=>$this->input->post('Contact_person'),
						'Phone_no'=>App_string_encrypt($this->input->post('Phone_no')),
						// 'Address'=>$this->input->post('Address'),
						'Address'=>App_string_encrypt($currentAddress),
						'Country_id'=>$this->input->post('country'),
						'State_id'=>$this->input->post('state'),
						'City_id'=>$this->input->post('city'),
						'Zipcode'=>$this->input->post('Zipcode'),
						'Update_date'=>date('Y-m-d')
				
					);
					
					$update_address = $this->Igain_model->update_customer_address($Update_data,$data['enroll'],$Company_id,$Address_type);
					
					if($update_address)
					{
						$this->session->set_flashdata("error_code","Address update successfully.");
						redirect("Shopping/checkout");	
					}
					else
					{
						$this->session->set_flashdata("error_code","Address update unsuccessful.");
						redirect("Shopping/checkout");	
					}
					
				} else {
					
					$Building_name=$_REQUEST['Building_name'];
					$House_no=$_REQUEST['House_no'];
					$Street_road=$_REQUEST['Street_road'];
					$Additional=$_REQUEST['Additional'];
					$currentAddress =$Building_name.','.$House_no.','.$Street_road.','.$Additional;
					
					$Insert_data=array(					
						'Address_type'=>$Address_type,
						'Company_id'=>$Company_id,
						'Enrollment_id'=>$data['enroll'],
						'Contact_person'=>$this->input->post('Contact_person'),
						'Phone_no'=>App_string_encrypt($this->input->post('Phone_no')),
						// 'Address'=>$this->input->post('Address'),
						'Address'=>App_string_encrypt($currentAddress),
						'Country_id'=>$this->input->post('country'),
						'State_id'=>$this->input->post('state'),
						'City_id'=>$this->input->post('city'),
						'Zipcode'=>$this->input->post('Zipcode'),
						'Create_date'=>date('Y-m-d'),
						'Update_date'=>date('Y-m-d')					
					);		
						
					$insert_address = $this->Igain_model->insert_customer_address($Insert_data);
					if($insert_address)
					{
						// $this->session->set_flashdata("error_code","Address inserted successfully.");
						redirect("Shopping/checkout");	
					}
					else
					{
						// $this->session->set_flashdata("error_code","Address inserted unsuccessful.");
						redirect("Shopping/checkout");	
					}
				}
			}
			else{
				
				// $this->session->set_flashdata("error_code","Please provide valid data.");
				redirect("Shopping/checkout");	
			}	
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
/************************01-10-2019 Nilesh cahnge address***************************/

	public function delete_address()
	{
		$delete_address = $this->Igain_model->delete_address($_REQUEST['Address_id']);
		redirect("Shopping/checkout");	
	}
	
	public function Verify_mpesa()
	{
		$Final_Grand_total=$_REQUEST['Final_Grand_total'];
		$goods_till_number=$_REQUEST['goods_till_number'];
		$Trans_id=$_REQUEST['Trans_id'];
		$outlet_url=$_REQUEST['Seller_api_url2'];
		//echo "ffCompany_api_encryptionkey--".$this->API_key;
		/**************************************************************************/
		$input_args = Array ('TransID' => $Trans_id ,'BalanceDue' => $Final_Grand_total);
					
					$input_args = json_encode($input_args);
					//print_r($input_args);
					$url = $outlet_url;
					//$url = 'http://localhost/amit/OnlineOrder.php';
					//$url = 'http://196.207.24.118:7070/onlineordering/novaonlineordering';
					//$url = 'http://localhost/CI_IGAINSPARK_LIVE_NEW/Api_call/OnlineOrder.php';
						
						$newHash = hash("sha256",$this->API_key,false);
						//$newHash = hash("sha256","Novacom909",false);

						$ch = curl_init();
						$timeout = 30; // Set 0 for no timeout.
						curl_setopt($ch, CURLOPT_URL, $url);

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS,$input_args);
						//set the content type to application/json
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$newHash,'Content-Type:application/json'));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						
						$result = curl_exec($ch);
						curl_close($ch);
						//echo $result;
//{"ResultCode":0,"ResultDesc":"John D","BillAmount":"450","TransAmount":"450","TransID":"TEST123401"}
						$response = json_decode($result, true);
						//echo json_encode($response)."<br>";die;
		/**************************************************************************/
						
		$this->output->set_content_type('application/json');
		 $this->output->set_output(json_encode(array('response' => $result)));
		//$this->output->set_output($result);
	}
	
	/********************************Ravi 28-08-2019 address*************************************/
	
	function string_decrypt($encrypted_string, $key, $iv)
	{											
			// echo "-------encrypted_string----".$encrypted_string."---------------<br>";
			// echo "-------key----".$key."---------------<br>";
			// echo "-------iv----".$iv."---------------<br>"; 

			$version = phpversion();
			// echo "-------version----".$version."---------------<br>";
			$new_version=  substr($version, 0, 1);
			
			// echo "-------new_version----".$new_version."---------------<br>";
			if($new_version >= 7) {
						
									
				$first_key = base64_decode($key);
				$second_key = base64_decode($key);            
				$mix = base64_decode($encrypted_string);

				$method = "aes-256-cbc";    
				$iv_length = openssl_cipher_iv_length($method);

				$iv = substr($mix,0,$iv_length);
				$second_encrypted = substr($mix,$iv_length,64);
				$first_encrypted = substr($mix,$iv_length+64);

				$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);

				//echo "--Output-data--".$data."------<br><br>";
				return $data;
				
			} else {
				
						return mcrypt_decrypt
							(
								MCRYPT_RIJNDAEL_256, 
								$key, 
								base64_decode($encrypted_string), 
								MCRYPT_MODE_CBC, $iv
							);
				
			}
	}
	function string_encrypt($string, $key, $iv)
	{		
		$version = phpversion();
		//echo "-------version----".$version."---------------<br>";
		$new_version=  substr($version, 0, 1);	
		//echo "-------new_version----".$new_version."---------------<br>";
		if($new_version >= 7) {
				
				$first_key = base64_decode($key);
				$second_key = base64_decode($key);    

				$method = "aes-256-cbc";    
				$iv_length = openssl_cipher_iv_length($method);
				$iv = openssl_random_pseudo_bytes($iv_length);

				$first_encrypted = openssl_encrypt($string,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
				$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

				$output = base64_encode($iv.$second_encrypted.$first_encrypted);    
				// echo "--input---output--".$output."------<br><br>";
		
				return $output;
				
		} else {
				
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
	}	
	/********************************Ravi 26-03-2019 emcryption*************************************/	
	/********************************AMIT KAMBLE 02-10-2019*************************************/	
	function Get_outlet_working_hours()
	{
		$Enroll_id = $_REQUEST["Enroll_id"];
		$Current_time = date("H:i:s");
		$Current_day = date("l");
		$day_of_week = date('N', strtotime($Current_day));
		
			$Get_outlet_working_hours = $this->Shopping_model->Get_merchant_working_hours($Enroll_id,$day_of_week);
			
			if($Get_outlet_working_hours != NULL)
			{
				if(!($Current_time >= $Get_outlet_working_hours->Open_time && $Current_time <= $Get_outlet_working_hours->Close_time))
				{
					$Outlet_status = 0;
				}
				else
				{
					$Outlet_status = 1;
					
			//******** 03-10-2019 sandeep*********************						
				$delivery_outlet_details = $this->Igain_model->get_enrollment_details($Enroll_id);

				$Seller_api_url = $delivery_outlet_details->Seller_api_url;
				$Seller_api_url2 = $delivery_outlet_details->Seller_api_url2;

				$input_args = [];
				
					if($Seller_api_url != "")
					{
						$Seller_api_url = $Seller_api_url.'?Authorization='.$this->OnlineOrderAPI_key;
				//echo "Seller_api_url --".$Seller_api_url."<br>";		
						$ch = curl_init();
						$timeout = 60; // Set 0 for no timeout.
						curl_setopt($ch, CURLOPT_URL, $Seller_api_url);

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				//		curl_setopt($ch, CURLOPT_POSTFIELDS,$input_args);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
						$result = curl_exec($ch);
						$err = curl_error($ch);
						curl_close($ch);
						
						if ($err) 
						{
							// echo "cURL Error #:" . $err;
							$Outlet_status = 2;
						} 
						else 
						{
							//	  echo $result;
						}
						
						// $response = json_decode(json_decode($result, true),true); // for live
						$response = json_decode($result, true); // for demo
						
						if($result == null || $result == "" || $response['Status'] != "0000")
						{
							$Outlet_status = 2;
						}
					}
		
	//******** 03-10-2019 sandeep **********************
				}
			}
			
		$this->output->set_content_type('application/json');
		$this->output->set_output($Outlet_status);
		
		// $Outlet_status = array(
								// "Outlet_status" => $Outlet_status
								// );
						
		// echo json_encode($Outlet_status);
	}
	
	
	/********************************AMIT KAMBLE 02-10-2019*********XXX****************************/	
	/********************************sandeep discount voucher 31-01-2020**************************/	
	public function get_gift_voucher_amt()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id'] = $session_data['Company_id'];
			//echo "gift id--".$_REQUEST["GiftCardId"];
			$giftCardId = $_REQUEST["GiftCardId"];
			$Grand_total = $_REQUEST["Grand_total"];
			
			$giftBal = $this->Igain_model->get_giftcard_balance($giftCardId,$data['Company_id']);
			
			if($giftBal[0]->Card_balance > 0 && $Grand_total >= $giftBal[0]->Card_balance)
			{
				echo $giftBal[0]->Card_balance;
			}
			else{
				echo 0;
			}
		}
		
	}
	/********************************sandeep discount voucher 31-01-2020**************************/	
	/********************************nilesh discount voucher 31-01-2020**************************/	
	public function MyDiscountVouchers()
	{
		if($this->session->userdata('cust_logged_in'))
		{
		$session_data = $this->session->userdata('cust_logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
		$data['userId'] = $session_data['userId'];
		$data['Card_id'] = $session_data['Card_id'];
		$data['Company_id'] = $session_data['Company_id'];
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
		$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
		$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);

		/*-----------------------Pagination---------------------*/
		$config = array();
		$config["base_url"] = base_url() . "//index.php/Shopping/MyDiscountVouchers";
		$total_row = $this->Igain_model->Get_my_discount_vouchers('','',$data['enroll'],$data['Company_id'],$data['Card_id']);
		// echo "total_row ".count($total_row); die;
		$config["total_rows"] = count($total_row);
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

		$data['key']=$this->key;
		$data['iv']=$this->iv;

		$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
		foreach($Company_details as $Company)
		{
		$Country = $Company['Country'];
		}

		$Country_details = $this->Igain_model->get_dial_code($Country );
		$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

		$data["MyDiscountVouchers"] = $this->Igain_model->Get_my_discount_vouchers($config["per_page"],$page,$data['enroll'],$data['Company_id'],$data['Card_id']);

		$this->load->view('Shopping/My_discount_vouchers', $data);
		}
		else
		{
		redirect('Login', 'refresh');
		}
	}
	/********************************nilesh discount voucher 31-01-2020**************************/	
}