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
			
			/*-----------------------Pagination---------------------*/			
                $config = array();
				$config["base_url"] = base_url() . "/index.php/Shopping/index";
				$total_row = $this->Shopping_model->Get_Merchandize_ecommerce_Items_Count($data['Company_id']);
				$config["total_rows"] = $total_row;
				$config["per_page"] = 50;
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
			
			$Redemption_Items = $this->Shopping_model->get_all_items($config["per_page"],$page,$data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender);
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
			
			
			$Redemption_Items1 = $this->Shopping_model->get_all_items(0,0,$Company_id,$Sort_category,$Sort_by,0,0,0);
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
		/* $insert_data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			// 'Size' => $this->input->post('Size'),
			'options' => array('Size'  => $this->input->post('Size')),
			'qty' => 1
		);		
		$result = $this->cart->insert($insert_data); */
		
		
		 $data2 = array(
			 'id'      => $_REQUEST['id'],
			 'qty'     => 1,
			 'price'   =>$_REQUEST['price'],
			 'Item_category_id' => $_REQUEST["Product_category_id"],
			 'options' => array('Company_merchandize_item_code' => $_REQUEST["Company_merchandize_item_code"],'Item_image1' => $_REQUEST["Item_image1"],'E_commerce_flag'  => 1,'Redemption_method'  => 29,'Branch'  => $_REQUEST["Branch"],'Item_size'  => $_REQUEST["Item_size"],'Item_Weight'  => $_REQUEST["Item_Weight"],'Weight_unit_id'  => $_REQUEST["Weight_unit_id"],'Partner_id'  => $_REQUEST["Partner_id"],'Partner_Country_id'  => $_REQUEST["Partner_Country_id"],'Partner_state'  => $_REQUEST["Partner_state"],'Seller_id'  => $_REQUEST["Seller_id"],'Merchant_flag'  => $_REQUEST["Merchant_flag"],'Cost_price'  => $_REQUEST["Cost_price"],'VAT'  => $_REQUEST["VAT"]),
			 'name'  => $_REQUEST['name']
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
			$Enroll_details = $data["Enroll_details"];
			$Country_id = $Enroll_details->Country;
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
						/*
						 $data2 = array(
			 'id'      => $_REQUEST['id'],
			 'qty'     => 1,
			 'price'   =>$_REQUEST['price'],
			 'options' => array('Company_merchandize_item_code' => $_REQUEST["Company_merchandize_item_code"], 'Item_image1' => $_REQUEST["Item_image1"],'E_commerce_flag'  => 1,'Redemption_method'  => $_REQUEST["Delivery_method"],'Branch'  => $_REQUEST["Branch"],'Item_size'  => $_REQUEST["Item_size"],'Item_Weight'  => $_REQUEST["Item_Weight"],'Weight_unit_id'  => $_REQUEST["Weight_unit_id"],'Partner_id'  => $_REQUEST["Partner_id"],'Partner_Country_id'  => $_REQUEST["Partner_Country_id"],'Partner_state'  => $_REQUEST["Partner_state"],'Seller_id'  => $_REQUEST["Seller_id"]),
			 'name'  => $_REQUEST['name']
		   );
						*/
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
			if(isset($_SESSION["To_Country"]))
			{
				$data["To_Country"]=$_SESSION["To_Country"];
				$data["To_State"]=$_SESSION["To_State"];
				$data["city"]=$_SESSION["City_id"];
			}
			
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
				$Country = $Company['Country'];
				$data["Redemptionratio"] = $Company['Redemptionratio'];
				$data["Shipping_charges_flag"] = $Company['Shipping_charges_flag'];
				$data["Standard_charges"] = $Company['Standard_charges'];
				$data["Cost_Threshold_Limit"] = $Company['Cost_Threshold_Limit'];
			}

			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
			
			$data['Company_Redemptionratio'] = $Company_Redemptionratio;
			
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
		
			$this->session->unset_userdata('PayPalResult');
			$this->session->unset_userdata('shopping_cart');
			
			$order_sub_total = 0;	
			$shipping_cost = 99;
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
                        
                        if(!isset($session_data['ShippingType']))
                        {
                            $shipping_address = $this->input->post('shipping_address');
                            $session_data['ShippingType'] = $shipping_address;
                            $this->session->set_userdata("cust_logged_in", $session_data);
							
                            if($shipping_address == 1)
							{
								
								$firstname1 = $data["Enroll_details"]->First_name;
								$lastname1 = $data["Enroll_details"]->Last_name;
								$address1 = $data["Enroll_details"]->Current_address;
								$city1 = $data["Enroll_details"]->City;
								$zip1 = $data["Enroll_details"]->Zipcode;
								$state1 = $data["Enroll_details"]->State;
								$country1 = $data["Enroll_details"]->Country;
								$phone1 = $data["Enroll_details"]->Phone_no;
								$email1 = $data["Enroll_details"]->User_email_id;
								
							}
							else
							{
								
								$firstname1 = $this->input->post('firstname1');
								$lastname1 = $this->input->post('lastname1');
								$address1 = $this->input->post('address1');
								$city1 = $this->input->post('city');
								$zip1 = $this->input->post('zip1');
								$state1 = $this->input->post('state');
								$country1 = $this->input->post('country1');
								$phone1 = $this->input->post('phone1');
								$email1 = $this->input->post('email1');
								
								$data["To_Country"]=$this->input->post('country1');
								$data["To_State"]=$this->input->post('state');
								$data["city"]=$this->input->post('city');
							}
							
                            if(!isset($session_data['New_shipping_details']))
                            {
                                $session_data['New_shipping_details'] = array
                                                                        (
                                                                            "firstname1" => $firstname1,
                                                                            "lastname1" => $lastname1,
                                                                            "address1" => $address1,
                                                                            "city1" => $city1,
                                                                            "zip1" => $zip1,
                                                                            "state1" => $state1,
                                                                            "country1" => $country1,
                                                                            "phone1" => $phone1,
                                                                            "email1" => $email1
                                                                        ); 
                                $this->session->set_userdata("cust_logged_in", $session_data);
                            }
                            else
                            {
                                $session_data['New_shipping_details'] = array
                                                                        (
                                                                            "firstname1" => $firstname1,
                                                                            "lastname1" => $lastname1,
                                                                            "address1" => $address1,
                                                                            "city1" => $city1,
                                                                            "zip1" => $zip1,
                                                                            "state1" => $state1,
                                                                            "country1" => $country1,
                                                                            "phone1" => $phone1,
                                                                            "email1" => $email1
                                                                        ); 
                                $this->session->set_userdata("cust_logged_in", $session_data);
                            }
                        }
                        else
                        {
                            if($this->input->post('shipping_address') != "")
                            {
                                $shipping_address = $this->input->post('shipping_address');
                                $session_data['ShippingType'] = $shipping_address;
                                
                                if($shipping_address == 1)
                                {
                                   $firstname1 = $data["Enroll_details"]->First_name;
									$lastname1 = $data["Enroll_details"]->Last_name;
									$address1 = $data["Enroll_details"]->Current_address;
									$city1 = $data["Enroll_details"]->City;
									$zip1 = $data["Enroll_details"]->Zipcode;
									$state1 = $data["Enroll_details"]->State;
									$country1 = $data["Enroll_details"]->Country;
									$phone1 = $data["Enroll_details"]->Phone_no;
									$email1 = $data["Enroll_details"]->User_email_id;
                                }
                                else
                                {
                                    $firstname1 = $this->input->post('firstname1');
                                    $lastname1 = $this->input->post('lastname1');
                                    $address1 = $this->input->post('address1');
                                    $city1 = $this->input->post('city');
                                    $zip1 = $this->input->post('zip1');
                                    $state1 = $this->input->post('state');
                                    $country1 = $this->input->post('country1');
                                    $phone1 = $this->input->post('phone1');
                                    $email1 = $this->input->post('email1');
									
									$data["To_Country"]=$this->input->post('country1');
									$data["To_State"]=$this->input->post('state');
									$data["city"]=$this->input->post('city');
                                }
								
                                $session_data['New_shipping_details'] = array
								(
									"firstname1" => $firstname1,
									"lastname1" => $lastname1,
									"address1" => $address1,
									"city1" => $city1,
									"zip1" => $zip1,
									"state1" => $state1,
									"country1" => $country1,
									"phone1" => $phone1,
									"email1" => $email1
								);
                                $this->session->set_userdata("cust_logged_in", $session_data);
                            }
                            else
                            {
                                $session_data['ShippingType'] = $session_data['ShippingType'];
                                $session_data['New_shipping_details'] = $session_data['New_shipping_details'];
                            }
                        }

                        $data['ShippingType'] = $session_data['ShippingType'];
                        $data['New_shipping_details'] = $session_data['New_shipping_details'];
			
			$shipping_address = $this->input->post('shipping_address');	
			
			$_SESSION["To_Country"]=$data["To_Country"];						
			$_SESSION["To_State"]=$data["To_State"];
			$_SESSION["City_id"]=$data["city"];
			
			if($shipping_address == 2)
			{
				if($this->input->post('firstname1') !="" && $this->input->post('lastname1') !="" && $this->input->post('address1')!="" && $this->input->post('city') !="" && $this->input->post('zip1') !="" && $this->input->post('state') !="" && $this->input->post('country1') !="" && $this->input->post('phone1') !="" && $this->input->post('email1') !="")
				{
					$this->load->view('Shopping/checkout_cart_details', $data);
				}
				else
				{
				   redirect('Shopping/checkout_cart_details');
				}
			  
			}
			else
			{
				$this->load->view('Shopping/checkout_cart_details', $data);
			}
			
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
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
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
            
			$total_bill_amount = $this->input->post('total_bill_amount');
			$data['total_bill_amount'] = $total_bill_amount;	
				
			$Cust_wish_redeem_point = $session_data['Cart_redeem_point'];
            $EquiRedeem = round( $Cust_wish_redeem_point / $Company_Redemptionratio );			
				
			$grand_total = 0;
			if ($cart = $this->cart->contents()) 
			{								
				foreach ($cart as $item)
				{
					$grand_total = $grand_total + $item['subtotal'];
				}
			}
                
                $data['subtotal'] = $grand_total;
                $data['grand_total'] = $grand_total - $EquiRedeem ;	
				
				
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
                
                $payment_method = $this->input->post('payment_method');
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
                        redirect('Shopping/review');
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
                        $Company_Redemptionratio = $Company['Redemptionratio'];	
                }
                $Country_details = $this->Igain_model->get_dial_code($Country );
                $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
                
                $Cust_wish_redeem_point = $session_data['Cart_redeem_point'];
                $EquiRedeem = round( $Cust_wish_redeem_point / $Company_Redemptionratio );
                $data['Redeem_amount'] = $EquiRedeem;
                
                $grand_total = 0;
				if ($cart = $this->cart->contents()) 
				{								
                    foreach ($cart as $item)
                    {
                        $grand_total = $grand_total + $item['subtotal'];
                    }
				}
                
                $data['subtotal'] = $grand_total;
                $data['grand_total'] = $grand_total - $EquiRedeem ;
                
                $cart = $this->session->userdata('shopping_cart');

                $cart['shopping_cart']['shipping'] = 0.00;
                $cart['shopping_cart']['handling'] = 0;
                $cart['shopping_cart']['tax'] = 0;

                $cart['shopping_cart']['grand_total'] = $cart['shopping_cart']['subtotal'] + $cart['shopping_cart']['shipping']
                                                        + $cart['shopping_cart']['handling'] + $cart['shopping_cart']['tax'];

                $this->session->set_userdata('shopping_cart', $cart);
                $this->load->vars('cart', $cart);
                
                $data['New_shipping_details'] = $session_data['New_shipping_details'];
                $data['PaymentMethod'] = $session_data['PaymentMethod'];
                        
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
                $EquiRedeem = ($Cust_wish_redeem_point / $Company_Redemptionratio);
                $subtotal = $subtotal1;
                // $grand_total = $grand_total - $EquiRedeem ;
				// $grand_total = $_SESSION['Grand_total'] - round($EquiRedeem,1,2);
				$grand_total = $_SESSION["Final_Grand_total"];								
                // var_dump($subtotal); var_dump($grand_total); die;   				  
                $New_shipping_details = $session_data['New_shipping_details'];
                $Payment_option = $session_data['PaymentMethod'];				
				// echo"-------------Payment_option-------------".$Payment_option."---<br>";
                if($Payment_option == "1")
                {
					$grand_total = round($grand_total,1,2);
                    //$amount = bcdiv($grand_total, 1, 2);                
                    $amount = $grand_total;
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
                        /***************************Apply Loyalty Rule*******************/
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
                            $phno = $data["Enroll_details"]->Phone_no;
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
							/*$Super_seller_flag = 1;
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
							$bill = substr($tp_db,5,$len); */
						/******************Get Supper Seller Details*********************/
							
						$date = new DateTime();
						$lv_date_time=$date->format('Y-m-d H:i:s'); 
						$lv_date_time2 = $date->format('Y-m-d'); 

						$Trans_type = 12;
						$Payment_type_id = 5; //Braintree
						$Remarks = "Online Purchase Transaction";
					  
						
                        $Customer_enroll_id = $cust_enrollment_id;

                        if ($cart = $this->cart->contents())
						{
							$Exist_Delivery_method=0;
							
							foreach($cart as $item)
							{
								/**********************************************/
								$characters = 'A123B56C89';
								$string = '';
								$Voucher_no="";
								for ($i = 0; $i < 10; $i++) 
								{
									$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
								}
								$Voucher_array[]=$Voucher_no;
								/********************************************/
								/********Get Merchandize item name***********/					
								$item_id = $item['id'];
								$Item_category_id = $item['Item_category_id'];
								$result = $this->Shopping_model->Get_merchandize_item($item_id,$Company_id);
								
								$sellerID = $result->Seller_id;
								/*
								if($sellerID!=0)
								{
									$Seller_result = $this->Shopping_model->Get_Seller_details($sellerID,$Company_id);	
									$Seller_First_name=$Seller_result->First_name;
									$Seller_Last_name=$Seller_result->Last_name;
									$seller_name=$Seller_First_name.' '.$Seller_Last_name;
									
									$Purchase_Bill_no = $Seller_result->Purchase_Bill_no;

									$tp_db = $Purchase_Bill_no;
									$len = strlen($tp_db);
									$str = substr($tp_db,0,5);
									$bill = substr($tp_db,5,$len);
								}*/
								$Company_merchandize_item_code = $result->Company_merchandize_item_code;
								$Merchandize_item_name = $result->Merchandize_item_name;   
								$Merchandize_category_id = $result->Merchandize_category_id;
								
							/******************New Loyalty Rule Logic********************/ 
								if($sellerID!=0)
								{	
									/************Get Seller Details**********/
									$Seller_result = $this->Shopping_model->Get_Seller_details($sellerID,$Company_id);	
									$Seller_First_name=$Seller_result->First_name;
									$Seller_Last_name=$Seller_result->Last_name;
									$seller_name=$Seller_First_name.' '.$Seller_Last_name;
									
									$Purchase_Bill_no = $Seller_result->Purchase_Bill_no;

									$tp_db = $Purchase_Bill_no;
									$len = strlen($tp_db);
									$str = substr($tp_db,0,5);
									$bill = substr($tp_db,5,$len);
									/************Get Seller Details**********/
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
												$transaction_amt=$item['qty'] * $item['price'];
											}
											if($lp_type == 'BA')
											{	
												$Purchase_amount=$item['qty'] * $item['price'];
												// $transaction_amt = $grand_total;
												$transaction_amt = (($grand_total * $Purchase_amount ) / $subtotal);
												// $transaction_amt = round(($Cust_redeem_point * $Purchase_amount) / $subtotal); 
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
									$total_loyalty_points=round($total_loyalty_points);
								 
								/******************New Category Wise Logic********************/ 
									
								$Voucher_status = 18; //'Ordered'
								$item_total_amount = $item['qty'] * $item['price'];
								// $Weighted_loyalty_points = round(($total_loyalty_points * $item_total_amount) / $subtotal);
								if($sellerID!=0)
								{
									$Weighted_loyalty_points = round($total_loyalty_points);
								}
								else
								{
									$Weighted_loyalty_points=0;
								}
								$Weighted_redeem_points = round(($Cust_redeem_point * $item_total_amount) / $subtotal);
								$Purchase_amount=$item['qty'] * $item['price'];
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
								/****************GET COST PRICE****************************/
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
								//echo "Cost_price ".$Cost_price; die;
								/******************/	
								/******Calculate Weighted Shipping Cost AMIT 12-12-2017*****/
								   
								   $Partner_state=$item["options"]["Partner_state"];
									$Partner_Country_id=$item["options"]["Partner_Country_id"];
									
									if($item["options"]["Redemption_method"]==29)
									{
										$Exist_Delivery_method=1;
										$Weight_in_KG=0;
										$Weight=0;
										foreach($cart as $rec) 
										{
											if(($rec["options"]["Partner_state"]==$Partner_state) && ($rec["options"]["Redemption_method"]==29))
											{
												$Total_weight_same_location=($rec["options"]["Item_Weight"]*$rec["qty"]);
												$lv_Weight_unit_id=$rec["options"]["Weight_unit_id"];
												$kg=1;
												switch ($lv_Weight_unit_id)
												{
													case 2://gram
													$kg=0.001;break;
													case 3://pound
													$kg=0.45359237;break;
												}
												$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
											}
												
										}
										
										/*******Single Weight convert into KG****/

										$kg2=1;
										switch ($item["options"]["Weight_unit_id"])
										{
											case 2://gram
											$kg2=0.001;break;
											case 3://pound
											$kg2=0.45359237;break;
										}
										
										/**************************/
										
										$Single_Item_Weight_in_KG=($item["options"]["Item_Weight"]*$item["qty"]*$kg2);
										
									}
									else
									{
										$Total_Weighted_avg_shipping_cost[]=0;
										$Weighted_avg_shipping_cost="-";
									}
									if($Shipping_charges_flag==2)//Delivery_price
									{
										if($item["options"]["Redemption_method"]==29)
										{
											$Get_shipping_cost = $this->Igain_model->Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight_in_KG,1);
											$Shipping_cost= $Get_shipping_cost->Delivery_price;
											$Weighted_avg_shipping_cost=(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
											$Weighted_avg_shipping_cost=number_format((float)$Weighted_avg_shipping_cost, 2);
											$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
										}
									}
									elseif($Shipping_charges_flag==1)//Standard Charges
									{
										if($item["options"]["Redemption_method"]==29)
										{
											$Cost_Threshold_Limit2=round($Cost_Threshold_Limit);
											if($subtotal >= $Cost_Threshold_Limit2)
											{	
												$Shipping_cost=round($Standard_charges);
												$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
												$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
											}
											else
											{
												$Shipping_cost=0;
												$Weighted_avg_shipping_cost=0;
												$Total_Weighted_avg_shipping_cost[]=0;
											}
										
										}
									} 
									else
									{
										$Shipping_cost=0;
										$Weighted_avg_shipping_cost=0;
									}
								   /**Calculate Weighted Shipping Cost AMIT 12-12-2017***END******/
								/*********Calculate Balance to pay amount New logic*********/
								$RedeemAmt=$Weighted_redeem_points/$Company_Redemptionratio;
								$PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt;
								/*********Calculate Balance to pay amount New logic*********/
									$data123 = array('Company_id' => $Company_id,
									'Trans_type' => $Trans_type,
									'Purchase_amount' => $Purchase_amount,
									'Paid_amount' => $PaidAmount,
									'Payment_type_id' => $Payment_type_id,
									'Remarks' => $Remarks,
									'Trans_date' => $lv_date_time,
									'balance_to_pay' => $PaidAmount,
									'Shipping_cost' => $Weighted_avg_shipping_cost,
									'Shipping_points' => ($Weighted_avg_shipping_cost*$Company_Redemptionratio),
									'Enrollement_id' => $cust_enrollment_id,
									'Bill_no' => $bill,
									'Voucher_no' => $Voucher_no,
									'Card_id' => $CardId,
									'Seller' => $seller_id,
									'Seller_name' => $seller_name,
									'purchase_category'=>$Merchandize_category_id,
									'Item_code' => $Company_merchandize_item_code,
									'Item_size' => $item["options"]["Item_size"],
									'Voucher_status' => $Voucher_status,
									'Delivery_method' => 29,
									'Merchandize_Partner_id' => $item["options"]["Partner_id"],
									'Merchandize_Partner_branch' => $item["options"]["Branch"],
									'Quantity' => $item['qty'],
									'Loyalty_pts' => $Weighted_loyalty_points,
									'Cost_payable_partner' => $Cost_payable_partner,
									'Online_payment_method' => "Braintree",
									'Redeem_points' => $Weighted_redeem_points
									 );	

									$Transaction_detail = $this->Shopping_model->Insert_online_purchase_transaction($data123);
									
									if($Transaction_detail)
									{
										/*******Insert online purchase log tbl entery********/	
										$Company_id	= $Company_id;
										$Todays_date = date('Y-m-d');	
										$opration = 1;		
										$enroll	= $cust_enrollment_id;
										$username = $session_data['username'];
										$userid=$session_data['userId'];
										$what="Online Purchase Item";
										$where="e-Commerce";
										$To_enrollid =0;
										$firstName =$fname ;
										$lastName =$lname; 
										$Seller_name =$fname.' '.$lname;
										$opval = $Merchandize_item_name.', ( Item id = '.$item_id.',Item Code = '.$Company_merchandize_item_code.', Quantity= '.$item['qty'].' )';
										$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);	
									/***********Insert online purchase log tbl entery********/
									}
									
									if($sellerID!=0)
									{
										// $loyalty_prog = $this->Shopping_model->get_tierbased_loyalty($Company_id,$seller_id,$lv_member_Tier_id,$lv_date_time2);
										// $lp_count = count($loyalty_prog);

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
													'Seller' => $seller_id,
													'Enrollement_id' => $cust_enrollment_id,
													'Transaction_id' => $Transaction_detail,
													// 'Loyalty_id' => $trans_lp_id,
													'Loyalty_id' => $Applied_loyalty_id[$l], 									
													'Reward_points' => round($Calc_rewards_points),
													);

												$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data);
												
											}
										}
									}
									
									$Order_date = date('Y-m-d');
									$shipping_details = array
									(
										'Transaction_date' => $Order_date,
										'Enrollment_id' => $data['enroll'],
										'Cust_name' => $New_shipping_details['firstname1'].' '.$New_shipping_details['lastname1'],
										'Cust_address' => $New_shipping_details['address1'],
										'Cust_city' => $New_shipping_details['city1'],
										'Cust_zip' => $New_shipping_details['zip1'],
										'Cust_state' => $New_shipping_details['state1'],
										'Cust_country' => $New_shipping_details['country1'],
										'Cust_phnno' => $New_shipping_details['phone1'],
										'Cust_email' => $New_shipping_details['email1'],
										'Transaction_id' => $Transaction_detail,
										'Company_id' => $data['Company_id']
									);

									$shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);	
									/***********==Buy==and==Get===free===Offer==*****************/										
									$item_id = $item['id'];										
									$result = $this->Shopping_model->Get_merchandize_item($item_id,$Company_id);
									$Offer_flag = $result->Offer_flag;
									$Merchandize_item_name = $result->Merchandize_item_name;
									$Company_merchandize_item_code = $result->Company_merchandize_item_code;
									$Company_merchandise_item_id = $result->Company_merchandise_item_id;
									$free_value_array=array();
									$Buy_value_array=array();
									$Offer_name_array=array();
									$Offer_id_array=array();
									$Total_free_item=0;
									if($Offer_flag==1 )
									{							
										
										/******************************************/
											/* $characters = 'A123B56C89';
											$string = '';
											$Voucher_no="";
											for ($i = 0; $i < 16; $i++) 
											{
												$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
											}
											$Voucher_array[]=$Voucher_no; */
										/************************************************/								
										$data['Offer_result'] = $this->Shopping_model->Get_buy_free_item_offers_details($item_id,$Company_id);
										foreach($data['Offer_result'] as $offres)
										{
											$Offer_id= $offres['Offer_id'];
											$Buy_item = $offres['Buy_item'];
											$Free_item = $offres['Free_item'];							
											$Offer_name = $offres['Offer_name'];							
											$Free_item_id = $offres['Free_item_id'];							
											if($Buy_item > 0)
											{
												$Offer_id_array[] = $Offer_id;	
												$Buy_value_array[] = $Buy_item;	
												$free_value_array[] = $Free_item;													
												$Free_item_id_array[] = $Free_item_id;													
												$Offer_name_array[] = $Offer_name;													
											}

											$cars[] = array
											(
												array($Offer_id,$Buy_item,$Free_item)
											);
											
										}
																				
										$qnt_count = count($cars);
										for($i=0;$i<$qnt_count;$i++)
										{
											// echo"<br>---if(".$item['qty']." >= ".$cars[$i][0][1].")";
											if($item['qty'] >= $cars[$i][0][1])
											{
												$OfferID=$cars[$i][0][0];													
												$Total_free_item=floor($item['qty'] / $cars[$i][0][1]);
												$Total_free_item= $cars[$i][0][2] * $Total_free_item;
											}							
										}	
										if($Total_free_item > 0 )
										{
											$Item_offer_details = $this->Shopping_model->Get_item_offer_details($OfferID,$Company_id);
											$New_offer_name=$Item_offer_details->Offer_name;
											$Free_item_id=$Item_offer_details->Free_item_id;
											// $Offer_name=$Item_offer_details->Offer_name;
											// echo"---New_offer_name---".$New_offer_name."<br>";
											// echo"---Free_item_id---".$Free_item_id."<br>";
											$result12 = $this->Shopping_model->Get_merchandize_item($Free_item_id,$Company_id);
											$Free_item_name = $result12->Merchandize_item_name;
											$Free_item_code = $result12->Company_merchandize_item_code;
											/*************AMIT****************29-11--2017--****/
											$Redemption_Items_branches_array = $this->Redemption_Model->get_all_items_branches($result12->Company_merchandize_item_code,$result12->Company_id);
											foreach($Redemption_Items_branches_array as $rec)
											{
												$Merchandize_Partner_branch=$rec['Branch_code'];
											}
											$Merchandize_Partner_id = $result12->Partner_id;
											/**************************************/
											$data1223 = array('Company_id' => $Company_id,
													'Trans_type' =>20,
													'Payment_type_id' => $Payment_type_id,
													'Remarks' =>'Buy and Get Free',
													'Trans_date' => $lv_date_time,
													'Enrollement_id' => $cust_enrollment_id,
													'Bill_no' => $bill,
													'Voucher_no' => $Voucher_no,
													'Card_id' => $CardId,
													'Seller' => $seller_id,
													'Seller_name' => $seller_name,
													'Item_code' => $Free_item_code,
													'Voucher_status' => $Voucher_status,
													'Delivery_method' => 29,
													'Merchandize_Partner_id' => $item["options"]["Partner_id"],
													'Merchandize_Partner_branch' => $item["options"]["Branch"],
													'Quantity' => $Total_free_item,
													'Online_payment_method' => "Braintree"
												);	
										$Transaction_detail11 = $this->Shopping_model->Insert_online_purchase_transaction($data1223);									
										$child_data_offer = array(					
												'Company_id' => $Company_id,        
												'Transaction_date' => $lv_date_time,       
												'Seller' => $seller_id,
												'Enrollement_id' => $cust_enrollment_id,
												'Transaction_id' => $Transaction_detail11,
												'Loyalty_id' => $OfferID, 									
												'Reward_points' =>0,
												);

										$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data_offer);
									
										$lvp_date_time = date("d M Y");           
										$Email_content11 = array
											(
												'Notification_type' =>$New_offer_name,
												'Transaction_date' => $lvp_date_time,											
												'Offer_name' => $New_offer_name,
												'Orderno' => $bill,
												'Item_name' => $Free_item_name,
												'Item_code' => $Free_item_code,
												'Purchase_quantity' =>$item['qty'],  
												'Free_qty' =>$Total_free_item,  
												'Template_type' => 'Purchase_buyone_freeone'
											);	
											// var_dump($Email_content11);
											$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content11,'0',$Company_id);
										}												
									}		
									/**************==Buy==and==Get===free===Offer==************/
							}
								$total_loyalty_email=array_sum($Email_points);		
						}
							
						/************ Update Current Balance ********************/
							$cid = $CardId;							
							$redeem_point = $Cust_redeem_point;
							/*********************New Change By Ravi**30-10-2017************************/
								// $Update_Current_balance = ($bal - $redeem_point) + $total_loyalty_points;
							$Update_Current_balance = ($bal - $redeem_point);
							/*********************New Change By Ravi**30-10-2017************************/
							$Update_total_purchase = $total_purchase + $subtotal;
							$Update_total_reddems = $Total_reddems + $Cust_wish_redeem_point;
							$up = array('Current_balance' => $Update_Current_balance, 'total_purchase' => $Update_total_purchase, 'Total_reddems' => $Update_total_reddems);			
							$this->Shopping_model->update_cust_balance($up,$cid,$Company_id);							
							$bill_no = $bill + 1;
							$billno_withyear = $str.$bill_no;
							$result4 = $this->Shopping_model->update_billno($seller_id,$billno_withyear);
						/************* Update Current Balance ********************/

                        /***************Apply Loyalty Rule****************/
                        $lvp_date_time = date("d M Y");   							
                        $Email_content = array
									(
										'Notification_type' => 'Thank you for your Purchase on '.$Company_name,
										'Transaction_date' => $lvp_date_time, 
										'Orderno' => $bill,
										'Voucher_array' => $Voucher_array, 
										'Voucher_status' => $Voucher_status, 
										'Cust_wish_redeem_point' => $Cust_wish_redeem_point, 
										'EquiRedeem' => round($EquiRedeem, 2), 
										'subtotal' => $subtotal, 
										'grand_total' => round($grand_total, 2), 
										// 'total_loyalty_points' => $total_loyalty_points, 
										'total_loyalty_points' => round($total_loyalty_email), 
										'Update_Current_balance' => $Update_Current_balance, 
										'Blocked_points' => $Blocked_points, 
										'Standard_charges' => $Standard_charges, 
										'Company_Redemptionratio' => $Company_Redemptionratio, 
										'Cost_Threshold_Limit' => $Cost_Threshold_Limit, 
										'To_Country' => $To_Country, 
										'To_State' => $To_State, 
										'Shipping_charges_flag' => $Shipping_charges_flag, 
										'Symbol_of_currency' => $Country_details->Symbol_of_currency, 
										'Template_type' => 'Purchase_order'
									);			
                        $Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
						
						$session_data['New_shipping_details'] = ""; 
                        $session_data['Cart_redeem_point'] = ""; 
                        $session_data['PaymentMethod'] = ""; 
                        $session_data['ShippingType'] = ""; 
                        $this->session->set_userdata("cust_logged_in", $session_data);

                        $this->cart->destroy();
                        $this->load->view('Shopping/payment_complete',$data);
                    }
                    else
                    {
                        $this->session->set_flashdata("error_code","Error in Purchase. Please Try Again!!");
                        redirect('Shopping/review');
                    }
					// die;
                }
                else  //*** Cash On Delivery
                {					
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
                        $phno = $data["Enroll_details"]->Phone_no;
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
                            $Payment_type_id = 6; //COD
                            $Remarks = "Online Purchase Transaction";
						
                        $Customer_enroll_id = $cust_enrollment_id;

                        if ($cart = $this->cart->contents())
                        {
                            foreach ($cart as $item)
                            {
                                /********************************/
                                    $characters = 'A123B56C89';
                                    $string = '';
                                    $Voucher_no="";
                                    for ($i = 0; $i < 10; $i++) 
                                    {
                                        $Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
                                    }
                                    $Voucher_array[]=$Voucher_no;
                                /*************************************/							
								// $item_id = $item['id'];
                                /********Get Merchandize item name********/					
                                    $item_id = $item['id'];
									$Item_category_id = $item['Item_category_id'];
									
                                    $result = $this->Shopping_model->Get_merchandize_item($item_id,$Company_id);
									
									$sellerID = $result->Seller_id;
									
									/*if($sellerID!=0)
									{
										$Seller_result = $this->Shopping_model->Get_Seller_details($sellerID,$Company_id);	
										$Seller_First_name=$Seller_result->First_name;
										$Seller_Last_name=$Seller_result->Last_name;
										$seller_name=$Seller_First_name.' '.$Seller_Last_name;
										$Purchase_Bill_no = $Seller_result->Purchase_Bill_no;

										$tp_db = $Purchase_Bill_no;
										$len = strlen($tp_db);
										$str = substr($tp_db,0,5);
										$bill = substr($tp_db,5,$len);
									}*/
									
                                    $Company_merchandize_item_code = $result->Company_merchandize_item_code;
									$Merchandize_item_name = $result->Merchandize_item_name;
									$Merchandize_category_id = $result->Merchandize_category_id;
									
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
													$transaction_amt=$item['qty'] * $item['price'];
												}
												if($lp_type == 'BA')
												{	
													$Purchase_amount=$item['qty'] * $item['price'];
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
										$total_loyalty_points=round($total_loyalty_points);
								 
								/******************New Category Wise Logic********************/ 
								
                                    $Voucher_status = 18; //'Ordered'
                                    $item_total_amount = $item['qty'] * $item['price'];
                                    // $Weighted_loyalty_points = round(($total_loyalty_points * $item_total_amount) / $subtotal);
									if($sellerID!=0)
									{
										$Weighted_loyalty_points = round($total_loyalty_points);
									}
									else
									{
										$Weighted_loyalty_points=0;
									}
                                    $Weighted_redeem_points = round(($Cust_redeem_point * $item_total_amount) / $subtotal);
                                    $Purchase_amount=$item['qty'] * $item['price'];
                                    
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
								
									/*****************************************/	
										if($item["options"]["Redemption_method"]==29)
										{
											$Exist_Delivery_method=1;
											$Weight_in_KG=0;
											$Weight=0;
											foreach($cart as $rec) 
											{
												if(($rec["options"]["Partner_state"]==$Partner_state) && ($rec["options"]["Redemption_method"]==29))
												{
													$Total_weight_same_location=($rec["options"]["Item_Weight"]*$rec["qty"]);
													$lv_Weight_unit_id=$rec["options"]["Weight_unit_id"];
													$kg=1;
													switch ($lv_Weight_unit_id)
													{
														case 2://gram
														$kg=0.001;break;
														case 3://pound
														$kg=0.45359237;break;
													}
													$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
												}												
												
											}
											
											/*******Single Weight convert into KG****/

											$kg2=1;
											switch ($item["options"]["Weight_unit_id"])
											{
												case 2://gram
												$kg2=0.001;break;
												case 3://pound
												$kg2=0.45359237;break;
											}
											
											/**************************/
											
											$Single_Item_Weight_in_KG=($item["options"]["Item_Weight"]*$item["qty"]*$kg2);											
										}
										else
										{
											$Total_Weighted_avg_shipping_cost[]=0;
											$Weighted_avg_shipping_cost="-";
										}
										if($Shipping_charges_flag==2)//Delivery_price
										{
											if($item["options"]["Redemption_method"]==29)
											{
												$Get_shipping_cost = $this->Igain_model->Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight_in_KG,1);
												$Shipping_cost= $Get_shipping_cost->Delivery_price;
												$Weighted_avg_shipping_cost=(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
												$Weighted_avg_shipping_cost=number_format((float)$Weighted_avg_shipping_cost, 2);
												$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
											}
										}
										elseif($Shipping_charges_flag==1)//Standard Charges
										{
											if($item["options"]["Redemption_method"]==29)
											{
												$Cost_Threshold_Limit2=round($Cost_Threshold_Limit);
												if($subtotal >= $Cost_Threshold_Limit2)
												{	
													$Shipping_cost=round($Standard_charges);
													$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
													$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
												}
												else
												{
													$Shipping_cost=0;
													$Weighted_avg_shipping_cost=0;
													$Total_Weighted_avg_shipping_cost[]=0;
												}
												
											}
										} 
										else
										{
											$Shipping_cost=0;
											$Weighted_avg_shipping_cost=0;
										}
									  /**Calculate Weighted Shipping Cost AMIT 12-12-2017*/	
								/*********Calculate Balance to pay amount New logic*********/
								$RedeemAmt=$Weighted_redeem_points/$Company_Redemptionratio;
								$PaidAmount=$Purchase_amount+$Weighted_avg_shipping_cost-$RedeemAmt;
								/*********Calculate Balance to pay amount New logic*********/		  
                                    $data123 = array('Company_id' => $Company_id,
                                                        'Trans_type' => $Trans_type,
                                                        'Purchase_amount' => $Purchase_amount,
                                                        'Paid_amount' => $PaidAmount,
                                                        'Payment_type_id' => $Payment_type_id,
                                                        'Remarks' => $Remarks,
                                                        'Trans_date' => $lv_date_time,
                                                        'balance_to_pay' => $PaidAmount,
                                                        'Shipping_cost' => $Weighted_avg_shipping_cost,
														'Shipping_points' => ($Weighted_avg_shipping_cost*$Company_Redemptionratio),
                                                        'Enrollement_id' => $cust_enrollment_id,
                                                        'Bill_no' => $bill,
                                                        'Voucher_no' => $Voucher_no,
                                                        'Card_id' => $CardId,
                                                        'Seller' => $seller_id,
                                                        'Seller_name' => $seller_name,
                                                        'Item_code' => $Company_merchandize_item_code,
                                                        'Item_size' => $item['options']['Item_size'],
                                                        'Voucher_status' => $Voucher_status,
														'Delivery_method' => 29,
                                                        'Merchandize_Partner_id' => $item["options"]["Partner_id"],
                                                        'Merchandize_Partner_branch' => $item["options"]["Branch"],
                                                        'Quantity' => $item['qty'],
                                                        'Loyalty_pts' => $Weighted_loyalty_points,
                                                        'Online_payment_method' => "COD",
														'Cost_payable_partner' => $Cost_payable_partner,
                                                        'Redeem_points' => $Weighted_redeem_points
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
                                                            'Seller' => $seller_id,
                                                            'Enrollement_id' => $cust_enrollment_id,
                                                            'Transaction_id' => $Transaction_detail,
                                                            // 'Loyalty_id' => $trans_lp_id,
                                                            'Loyalty_id' => $Applied_loyalty_id[$l], 									
                                                            'Reward_points' => round($Calc_rewards_points),
                                                            );
                                            $child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data);
                                        }
                                    }
                                    $Order_date = date('Y-m-d');
                                    $shipping_details = array
											(
												'Transaction_date' => $Order_date,
												'Enrollment_id' => $data['enroll'],
												'Cust_name' => $New_shipping_details['firstname1'].' '.$New_shipping_details['lastname1'],
												'Cust_address' => $New_shipping_details['address1'],
												'Cust_city' => $New_shipping_details['city1'],
												'Cust_zip' => $New_shipping_details['zip1'],
												'Cust_state' => $New_shipping_details['state1'],
												'Cust_country' => $New_shipping_details['country1'],
												'Cust_phnno' => $New_shipping_details['phone1'],
												'Cust_email' => $New_shipping_details['email1'],
												'Transaction_id' => $Transaction_detail,
												'Company_id' => $data['Company_id']
											);

                                    $shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);	
								
									/*==Buy==and==Get===free===Offer==*/				
										$item_id = $item['id'];										
										$result = $this->Shopping_model->Get_merchandize_item($item_id,$Company_id);
										$Offer_flag = $result->Offer_flag;
										$Merchandize_item_name = $result->Merchandize_item_name;
										$Company_merchandize_item_code = $result->Company_merchandize_item_code;
										$Company_merchandise_item_id = $result->Company_merchandise_item_id;
										$free_value_array=array();
										$Buy_value_array=array();
										$Offer_name_array=array();
										$Offer_id_array=array();
										$Free_item_id_array=array();
										$Total_free_item=0;
										
										if($Offer_flag==1 )
										{								
											$data['Offer_result'] = $this->Shopping_model->Get_buy_free_item_offers_details($item_id,$Company_id);
											foreach($data['Offer_result'] as $offres)
											{
												$Offer_id= $offres['Offer_id'];
												$Buy_item = $offres['Buy_item'];
												$Free_item = $offres['Free_item'];							
												$Offer_name = $offres['Offer_name'];							
												$Free_item_id = $offres['Free_item_id'];							
												if($Buy_item > 0)
												{
													$Offer_id_array[] = $Offer_id;	
													$Buy_value_array[] = $Buy_item;	
													$free_value_array[] = $Free_item;													
													$Free_item_id_array[] = $Free_item_id;													
													$Offer_name_array[] = $Offer_name;													
												}

												$cars[] = array
												(
													array($Offer_id,$Buy_item,$Free_item)
												);
														
											}
																					
											$qnt_count = count($cars);
											for($i=0;$i<$qnt_count;$i++)
											{
												if($item['qty'] >= $cars[$i][0][1])
												{
													$OfferID=$cars[$i][0][0];													
													$Total_free_item=floor($item['qty'] / $cars[$i][0][1]);
													$Total_free_item= $cars[$i][0][2] * $Total_free_item;
												}							
											}	
											if($Total_free_item > 0 )
											{
												$Item_offer_details = $this->Shopping_model->Get_item_offer_details($OfferID,$Company_id);
												$New_offer_name=$Item_offer_details->Offer_name;
												$Free_item_id=$Item_offer_details->Free_item_id;
												$result12 = $this->Shopping_model->Get_merchandize_item($Free_item_id,$Company_id);
												$Free_item_name = $result12->Merchandize_item_name;
												$Free_item_code = $result12->Company_merchandize_item_code;
												
												$data1223 = array('Company_id' => $Company_id,
														'Trans_type' =>20,
														'Payment_type_id' => $Payment_type_id,
														'Remarks' =>'Buy and Get Free',
														'Trans_date' => $lv_date_time,
														'Enrollement_id' => $cust_enrollment_id,
														'Bill_no' => $bill,
														'Voucher_no' => $Voucher_no,
														'Card_id' => $CardId,
														'Seller' => $seller_id,
														'Seller_name' => $seller_name,
														'Item_code' => $Free_item_code,
														'Voucher_status' => $Voucher_status,
														'Delivery_method' => 29,
														'Merchandize_Partner_id' => $item["options"]["Partner_id"],
														'Merchandize_Partner_branch' => $item["options"]["Branch"],
														'Quantity' => $Total_free_item,
														'Online_payment_method' => "COD"
													);	
											$Transaction_detail11 = $this->Shopping_model->Insert_online_purchase_transaction($data1223);									
											$child_data_offer = array(					
													'Company_id' => $Company_id,        
													'Transaction_date' => $lv_date_time,       
													'Seller' => $seller_id,
													'Enrollement_id' => $cust_enrollment_id,
													'Transaction_id' => $Transaction_detail11,
													'Loyalty_id' => $OfferID, 									
													'Reward_points' =>0,
													);

											$child_result = $this->Shopping_model->insert_loyalty_transaction_child($child_data_offer);
										
											$lvp_date_time = date("d M Y");           
											$Email_content11 = array
												(
													'Notification_type' =>$New_offer_name,
													'Transaction_date' => $lvp_date_time,											
													'Offer_name' => $New_offer_name,
													'Orderno' => $bill,
													'Item_name' => $Free_item_name,
													'Item_code' => $Free_item_code,
													'Purchase_quantity' =>$item['qty'],  
													'Free_qty' =>$Total_free_item,  
													'Template_type' => 'Purchase_buyone_freeone'
												);	
												$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content11,'0',$Company_id);
											}												
										}		
									/*****==Buy==and==Get===free===Offer==***/							
                            }
							$total_loyalty_email=array_sum($Email_points);	
							
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
										'To_Country' => $To_Country, 
										'To_State' => $To_State, 
										'Shipping_charges_flag' => $Shipping_charges_flag,
                                        'Symbol_of_currency' => $Country_details->Symbol_of_currency, 
                                        'Template_type' => 'Purchase_order'
                                    );	
									
                    $Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
                                    
                   $this->cart->destroy();
                    $data['transaction_id'] = "";
                    $session_data['New_shipping_details'] = ""; 
                    $session_data['Cart_redeem_point'] = ""; 
                    $session_data['PaymentMethod'] = ""; 
                    $session_data['ShippingType'] = ""; 
                    $this->session->set_userdata("cust_logged_in", $session_data);

                    $this->load->view('Shopping/payment_complete',$data);
				}
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
					
					$Order_details = $this->Shopping_model->get_order_details2($cust_id);
					$Order_details2 = $this->Shopping_model->get_order_details($cust_id);
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
				// echo"---serial_id----".$_GET['serial_id']."---<br>";
				// die;
				$serial_id = $this->string_decrypt($_GET['serial_id'],$this->key, $this->iv);	
				$Serial_id_decrypt = preg_replace("/[^(\x20-\x7f)]*/s", "",$serial_id);
				// echo"---Serial_id_decrypt------".$Serial_id_decrypt."---<br>";


				if($Serial_id_decrypt == ""){
					
					$this->load->view('err404',$data); 

				} else {

					$data["Order"] = $this->Shopping_model->get_order_details($Serial_id_decrypt);
					$data["Order_details"] = $this->Shopping_model->get_order_details2($Serial_id_decrypt);
					$this->load->view('Shopping/order_details', $data);

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
	}
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
	
}