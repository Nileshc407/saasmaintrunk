<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Redemption_Catalogue extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->model('login/Login_model');
		$this->load->model('shopping/Shopping_model');
		$this->load->model('Igain_model');
		$this->load->library('cart');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->library('Send_notification');
		$this->load->helper(array('form', 'url','encryption_val'));
		
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
		// echo"---__construct---Company_id---------".$data['Company_id']."----<br>";
		// echo"---__construct---key---------".$this->key."----<br>";
			$this->iv = '56666852251557009888889955123458';
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			
			
			// **PREVENTING SESSION HIJACKING**
				// Prevents javascript XSS attacks aimed to steal the session ID
				ini_set('session.cookie_httponly', 1);

				// **PREVENTING SESSION FIXATION**
				// Session ID cannot be passed through URLs
				ini_set('session.use_only_cookies', 1);

				// Uses a secure connection (HTTPS) if possible
				ini_set('session.cookie_secure', 1);
			
		/* 	
		Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
		Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
		Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
		*/
		
		/*
			Referrer-Policy : no-referrer
		Referrer-Policy : no-referrer-when-downgrade
		Referrer-Policy : origin
		Referrer-Policy : strict-origin
		Referrer-Policy : origin-when-cross-origin
		Referrer-Policy : strict-origin-when-cross-origin
		Referrer-Policy : same-origin
		Referrer-Policy : unsafe-url
		*/
		
		
	}
	
	/******************************************AMIT Start***********************************************/
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
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Tier_id = $data["Enroll_details"]->Tier_id;
			$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$data['Company_id']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($data['Company_id']);
			$Merchandize_category_id=0;
			$Sort_by=0;
			$Sort_by_merchant=0;
			$Sort_by_brand=0;
			$Sort_by_gender=0;
			$Sort_by_item_type=0;
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
			if(isset($_REQUEST["Sort_by_item_type"]))
			{
				$Sort_by_item_type=$_REQUEST["Sort_by_item_type"];
			}
			
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
		
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Redemption_Catalogue/index";
			$total_row = $this->Redemption_Model->Get_Merchandize_Items_Count($data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_item_type);
			
			
		//	echo "------total_row------".$total_row."----<br>";
			$config["total_rows"] = $total_row;
			$config["per_page"] = 50;   //8
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
			
					
			$Redemption_Items = $this->Redemption_Model->get_all_items($config["per_page"],$page,$data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_item_type);		
			$data['Redemption_Items'] = $Redemption_Items;
			if($Redemption_Items != NULL)
			{
				foreach ($Redemption_Items as $product)
				{
					$itemCode = $product['Company_merchandize_item_code'];
					$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
				}
				
				$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
				$Item_array=$data['Redemption_Items'];
			}
			/*************************04-09-2017 AMIT Get merchants*******************/
			$data["Sellers"] =$this->Igain_model->Fetch_All_Merchants($data['Company_id']);
			/********************************Nilesh filter**************************************/
			$data["Sellers1"] =$this->Igain_model->Fetch_All_Merchants($data['Company_id']);
			$data['Max_price'] = $this->Redemption_Model->fetch_max_price($data['Company_id']);
			$data['Min_price'] = $this->Redemption_Model->fetch_min_price($data['Company_id']);
			
			$get_all_products = $this->Redemption_Model->get_all_products($data['Company_id']);
            $data['numitems'] = count($get_all_products);	
			if($Redemption_Items != NULL)
			{
				$data['count4'] = count($Redemption_Items);		
			}
			$data["Item_brand"] = $this->Redemption_Model->Get_Merchandize_item_brand($data['Company_id']);
			$data["Gender_flag"] = $this->Redemption_Model->Get_Merchandize_item_Gender_flag($data['Company_id']);
			$data["Merchandize_item_type"] = $this->Redemption_Model->Get_Merchandize_item_type($data['Company_id']);		
            $data['Sort_by'] = $Sort_by;
            $data['Category_filter'] = $Merchandize_category_id;
            $data['Merchant_filter'] = $Sort_by_merchant;
            $data['brand_filter'] = $Sort_by_brand;			
			
			/*************************************************************************************/
			
			
			$data['token'] = $this->security->get_csrf_hash();
			
			$this->load->view('Redemption_Catalogue/Redemption_Catalogue_View', $data);		
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	/***************************Nilesh Filter***************************************/
	function filter_result()
	{
		
		
		$session_data = $this->session->userdata('cust_logged_in');
		$data['username'] = $session_data['username'];			
		$data['enroll'] = $session_data['enroll'];
		
		$PriceFrom = $this->input->post("PriceFrom");
		$PriceTo = $this->input->post("PriceTo");		
		$Company_id = $this->input->post("Company_id");		
		$Sort_by = $this->input->post("Sort_by");		
		$Sort_category = $this->input->post("Sort_category");
		
		$data['Company_Details']= $this->Igain_model->get_company_details($Company_id);	
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);			
		$Tier_id=$data["Enroll_details"]->Tier_id;			
		
		// echo "--Tier_redemption_ratio---".$Tier_redemption_ratio;
		$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$Company_id);
		
		// print_r($data["Tier_details"]);
		// die;
		
		
		
		if ( $this->input->post("page") != "" || $this->input->post("page") != NULL ) 
		{
			$currentpage = $this->input->post("page");
		}
		$item_per_page = 8;
		$Redemption_Items = $this->Redemption_Model->filter_result($Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);
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
		$data['Filter_result'] = $this->Redemption_Model->filter_result2($item_per_page,$offset,$Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);
		$Company_details = $this->Igain_model->Fetch_Company_Details($this->input->post("Company_id"));
		foreach($Company_details as $Company)
		{
				$Country = $Company['Country'];
		}
		$Country_details = $this->Igain_model->get_dial_code($Country );
		$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
		
		$Filter_result = $this->Redemption_Model->filter_result2($item_per_page,$offset,$Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id);
		
		$data['numitems'] = count($Filter_result);	
		$data['count4'] = count($Redemption_Items);
			
		if($Filter_result != NULL)
		{
			foreach ($Filter_result as $product)
			{
				$itemCode = $product['Company_merchandize_item_code'];
				$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
			}
			
			$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
			
			//$Item_array=$data['Redemption_Items'];
		}
		$data['Company_id'] = $Company_id;
		$theHTMLResponse = $this->load->view('Redemption_Catalogue/filtered_result', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('filtered_result'=> $theHTMLResponse, 'currentpage' => $currentpage, 'totalpages' => $totalpages )));
	}	
/***************************Nilesh Filter***************************************/	
	function Proceed_Redemption_Catalogue()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($data['Company_id']);
			$Merchandize_category_id=0;
			
			$Company_details = $this->Igain_model->get_company_details($data['Company_id']);
			$data["Pin_no_applicable"]=$Company_details->Pin_no_applicable;
			$data["Redemptionratio"]=$Company_details->Redemptionratio;
			$data["Cust_Pin"]=$data["Enroll_details"]->pinno;
			$data["To_Country"]=$data["Enroll_details"]->Country;
			$data["To_State"]=$data["Enroll_details"]->State;
			$data["City_id"]=$data["Enroll_details"]->City;
			$Cust_Tier_id=$data["Enroll_details"]->Tier_id;
			
			$data["Tier_details"] = $this->Redemption_Model->Get_tier_details($data['Company_id'],$Cust_Tier_id);
			foreach($data["Tier_details"] as $Tier_details)
			{
				$data["Redeemtion_limit"]=$Tier_details->Redeemtion_limit;
				$data["Tier_name"]=$Tier_details->Tier_name;
			}
			
			
			$data['token'] = $this->security->get_csrf_hash();	
			//print_r($data['token']);
			
			$data["Redemption_Items"] = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
					
			$Session_TotalRedeempoints="";
			$Total_Redeem_points1="";
			// $_REQUEST['Total_Redeem_points']="";
			
			// $data["Total_Redeem_points"] = 0;
			// echo "---Total_Redeem_points---".$_REQUEST["Total_Redeem_points"]."---<br>";		
		
			// $Total_Redeem_points1=$_GET['Total_Redeem_points'];
				$Total_Redeem_points1=$_REQUEST["Total_Redeem_points"];
			// echo "---Total_Redeem_points1---".$Total_Redeem_points1."---<br>";	
			// die;
			
			$Session_TotalRedeempoints = $this->session->userdata('Session_TotalRedeempoints');
			if($Session_TotalRedeempoints != "")
			{
				// echo "---Session_TotalRedeempoints---".$Session_TotalRedeempoints."---<br>";
			
				$Session_TotalRedeempoints = $this->string_decrypt($Session_TotalRedeempoints,$this->key, $this->iv);	
				$Total_Redeem_decrypt = preg_replace("/[^(\x20-\x7f)]*/s", "",$Session_TotalRedeempoints);
			
				// echo "---Session_TotalRedeempoints_decrypted---".$Total_Redeem_decrypt."---<br>";	
			} 
			if($Total_Redeem_points1 != "") 
			{				
				$Total_Redeem_decrypt = $this->string_decrypt($Total_Redeem_points1,$this->key, $this->iv);	
				$Total_Redeem_decrypt = preg_replace("/[^(\x20-\x7f)]*/s", "",$Total_Redeem_decrypt);							
				// echo "---Total_Redeem_decrypt---".$Total_Redeem_decrypt."---<br>";	
			}
			// echo "---Total_Redeem_decrypt---".$Total_Redeem_decrypt."---<br>";	
			// die;	
			
			
			
			$data['token'] = $this->security->get_csrf_hash();	
			
			if($Total_Redeem_decrypt == "")
			{
				// redirect('Errors', 'refresh');
				 $this->load->view('err404',$data); 
			} else {
				
				$data["Total_Redeem_points"] = $Total_Redeem_decrypt;
				//echo "pinno ".$data["Enroll_details"]->pinno;
				/*******AMIT 30-11-2017 gET Delivery price ***************/
				$data["Shipping_charges_flag"]=$Company_details->Shipping_charges_flag;
				$data["Standard_charges"]=$Company_details->Standard_charges;
				$data["Cost_Threshold_Limit"]=$Company_details->Cost_Threshold_Limit;
				
				/*********************************************/
				$this->load->view('Redemption_Catalogue/Redemption_Checkout', $data);
				
			}
					
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	
	
	function Review_Redemption()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($data['Company_id']);
			$Merchandize_category_id=0;
			
			$Company_details = $this->Igain_model->get_company_details($data['Company_id']);
			$data["Pin_no_applicable"]=$Company_details->Pin_no_applicable;
			$data["Redemptionratio"]=$Company_details->Redemptionratio;
			$data["Cust_Pin"]=$data["Enroll_details"]->pinno;
			$data["To_Country"]=$data["Enroll_details"]->Country;
			$data["To_State"]=$data["Enroll_details"]->State;
			$data["City_id"]=$data["Enroll_details"]->City;
			$Cust_Tier_id=$data["Enroll_details"]->Tier_id;
			
			$data["Tier_details"] = $this->Redemption_Model->Get_tier_details($data['Company_id'],$Cust_Tier_id);
			foreach($data["Tier_details"] as $Tier_details)
			{
				$data["Redeemtion_limit"]=$Tier_details->Redeemtion_limit;
				$data["Tier_name"]=$Tier_details->Tier_name;
			}
			
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			if($_REQUEST != NULL)
			{
				$data["shipping_address"]=$_REQUEST["shipping_address"];
				
				if($data["shipping_address"]==1)//Current Address
				{
					$data["firstname"]=$data["Enroll_details"]->First_name;
					$data["lastname"]=$data["Enroll_details"]->Last_name;
					$data["address"]=$data["Enroll_details"]->Current_address;
					$data["city"]=$data["Enroll_details"]->City;
					$data["state"]=$data["Enroll_details"]->State;
					$data["City_id"]=$data["Enroll_details"]->City;
					$data["country"]=$data["Enroll_details"]->Country;
					$data["zip"]=$data["Enroll_details"]->Zipcode;
					$data["phone"]=$data["Enroll_details"]->Phone_no;
					$data["email"]=$data["Enroll_details"]->User_email_id;
				}
				else
				{
					$data["firstname"]=$_REQUEST["firstname1"];
					$data["lastname"]=$_REQUEST["lastname1"];
					$data["address"]=$_REQUEST["address1"];
					$data["city"]=$_REQUEST["city"];
					$data["state"]=$_REQUEST["state"];
					$data["country"]=$_REQUEST["country1"];
					$data["zip"]=$_REQUEST["zip1"];
					$data["phone"]=$_REQUEST["phone1"];
					$data["email"]=$_REQUEST["email1"];
					
					$data["To_Country"]=$_REQUEST["country1"];
					$data["To_State"]=$_REQUEST["state"];
					$data["City_id"]=$_REQUEST["city"];
				}
				$_SESSION["To_Country"]=$data["To_Country"];						
				$_SESSION["To_State"]=$data["To_State"];
				$_SESSION["City_id"]=$data["City_id"];
				
				$_SESSION["firstname"]=$data["firstname"];						
				$_SESSION["lastname"]=$data["lastname"];
				$_SESSION["zip"]=$data["zip"];						
				$_SESSION["phone"]=$data["phone"];
				$_SESSION["email"]=$data["email"];						
				$_SESSION["address"]=$data["address"];						
				
				
				$data["Redemption_Items"] = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
				
				
				$data["Total_Redeem_points"] =0;
				//echo "pinno ".$data["Enroll_details"]->pinno;
				/*******AMIT 30-11-2017 gET Delivery price ***************/
				$data["Shipping_charges_flag"]=$Company_details->Shipping_charges_flag;
				$data["Standard_charges"]=$Company_details->Standard_charges;
				$data["Cost_Threshold_Limit"]=$Company_details->Cost_Threshold_Limit;
				
				/*********************************************/
				$_SESSION["shipping_address"]=$_REQUEST["shipping_address"];
				
				$this->load->view('Redemption_Catalogue/Review_Redemption_view', $data);
			}
			else
			{
			  redirect('Redemption_Catalogue/Get_Shipping_details');
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	
	
	public function add_to_cart()
	{
		// echo"add_to_cart";
		// var_dump($_POST);
		// die;
		
		$session_data = $this->session->userdata('cust_logged_in');
		$data['username'] = $session_data['username'];			
		$data['enroll'] = $session_data['enroll'];
		$data['userId']= $session_data['userId'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
		$Cust_Tier_id=$data["Enroll_details"]->Tier_id;
			
		$Tier_details = $this->Redemption_Model->Get_tier_details($data['Company_id'],$Cust_Tier_id);
		foreach($Tier_details as $Tier_details)
			{
				$Tier_redemption_ratio = $Tier_details->Tier_redemption_ratio;
			}	
		
		
		$item_id=$this->input->post('item_id');
		// $Points=$this->input->post('Points');
		$data['token'] = $this->security->get_csrf_hash();	
		$itemDetails = $this->Redemption_Model->Get_Merchandize_Item_details($item_id,$session_data['Company_id']);
		
		if($itemDetails){
			
			$Billing_price_in_points=$itemDetails[0]->Billing_price_in_points;	
			$Billing_price_in_points_tier = $Billing_price_in_points * $Tier_redemption_ratio;
			if($Billing_price_in_points != $Billing_price_in_points_tier)
			{
				$Billing_price_in_points = $Billing_price_in_points_tier;
			
			}
			
					$Total_Redeem_points=0;
					// echo "dsfdsfdsf".count($Redeemtion_details);
					 if(count($Redeemtion_details)!=0)
					{
						foreach($Redeemtion_details as $Redeemtion_details)
						{
							//echo "<br>".$Redeemtion_details["Points"];
							//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
							$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
							
							$Billing_price_in_points_tier = $Total_Redeem_points * $Tier_redemption_ratio;
							if($Total_Redeem_points != $Billing_price_in_points_tier)
							{
								$Total_Redeem_points = $Billing_price_in_points_tier;
							
							}
													
						}
					} 
			
			
			
			if($Billing_price_in_points){
				
				
				
				
				
						$Item_code=$this->input->post('Company_merchandize_item_code');
						$Delivery_method=$this->input->post('Delivery_method');
						$location=$this->input->post('location');
						$Current_redeem_points=$Total_Redeem_points;
						$Item_Weight=$this->input->post('Item_Weight');
						$Weight_unit_id=$this->input->post('Weight_unit_id');
						$Size=$this->input->post('Size');
						
						$insert_data = array(
					
							'Item_code' => $Item_code,
							'Redemption_method' => $Delivery_method,
							'Branch' => $location,
							'Points' => $Billing_price_in_points,
							'Weight' => $Item_Weight,
							'Weight_unit_id' => $Weight_unit_id,
							'Company_id' => $data['Company_id'],
							'Enrollment_id' => $data['enroll'],
							'Size' => $Size
						);
				
				
				
				// Redemption_method
				/* $insert_data = array(
				
					'Item_code' => $this->input->post('Company_merchandize_item_code'),
					'Redemption_method' => $this->input->post('Delivery_method'),
					'Branch' => $this->input->post('location'),
					'Points' => $this->input->post('Points'),
					'Weight' => $this->input->post('Item_Weight'),
					'Weight_unit_id' => $this->input->post('Weight_unit_id'),
					'Company_id' => $data['Company_id'],
					'Enrollment_id' => $data['enroll'],
					'Size' => $this->input->post('Size')
				);	 */	
				
				$Total_balance=$this->input->post('Total_balance');
				// $Current_redeem_points=$this->input->post('Current_redeem_points');
				// echo"$Current_redeem_points<=$Total_balance";
				if($Current_redeem_points<=$Total_balance )
				{
					$result = $this->Redemption_Model->insert_item_catalogue($insert_data);
					$Redeemtion_details = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
					// print_r($result);
					$Total_Redeem_points=0;
					// echo "dsfdsfdsf".count($Redeemtion_details);
					 if(count($Redeemtion_details)!=0)
					{
						foreach($Redeemtion_details as $Redeemtion_details)
						{
							//echo "<br>".$Redeemtion_details["Points"];
							//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
							$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
							/* $Billing_price_in_points_tier = $Total_Redeem_points * $Tier_redemption_ratio;
							if($Total_Redeem_points != $Billing_price_in_points_tier)
							{
								$Total_Redeem_points = $Billing_price_in_points_tier;
							
							} */
						}
					} 
					
					$item_list='Loading Page';
					if($result)
					{
						// $this->output->set_output("1");
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
					}
					else    
					{
						// $this->output->set_output("0");
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
					}
				}
				
			} else {
				
				
				
				$Total_Redeem_points=0;
				// echo "dsfdsfdsf".count($Redeemtion_details);
				if(count($Redeemtion_details)!=0)
				{
					foreach($Redeemtion_details as $Redeemtion_details)
					{
						//echo "<br>".$Redeemtion_details["Points"];
						//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
						$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
						/* $Billing_price_in_points_tier = $Total_Redeem_points * $Tier_redemption_ratio;
							if($Total_Redeem_points != $Billing_price_in_points_tier)
							{
								$Total_Redeem_points = $Billing_price_in_points_tier;
							
							} */
					}
				} 
				// $this->output->set_output("0");
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
				
				
			}
			
		} else {
			
			
				$Total_Redeem_points=0;
				// echo "dsfdsfdsf".count($Redeemtion_details);
				 if(count($Redeemtion_details)!=0)
				{
					foreach($Redeemtion_details as $Redeemtion_details)
					{
						//echo "<br>".$Redeemtion_details["Points"];
						//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
						$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
						/* $Billing_price_in_points_tier = $Total_Redeem_points * $Tier_redemption_ratio;
							if($Total_Redeem_points != $Billing_price_in_points_tier)
							{
								$Total_Redeem_points = $Billing_price_in_points_tier;
							
							} */
					}
				} 
				// $this->output->set_output("0");
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
			
		}
			
	}
	public function add_to_cart1()
	{
		/* echo"add_to_cart";
		var_dump($_POST);
		echo"<br><br>"; */
		
		
		$session_data = $this->session->userdata('cust_logged_in');
		$data['username'] = $session_data['username'];			
		$data['enroll'] = $session_data['enroll'];
		$data['userId']= $session_data['userId'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($session_data['enroll']);
		
		
		
		// die;
		$this->form_validation->set_rules('Company_merchandize_item_code', 'Company_merchandize item code', 'required|strip_tags|xss_clean');
		$this->form_validation->set_rules('item_id', 'item id', 'required|integer|strip_tags|xss_clean');
		$this->form_validation->set_rules('Delivery_method', 'Delivery method', 'required|strip_tags|xss_clean');
		$this->form_validation->set_rules('location', 'location', 'required|strip_tags|xss_clean');
		$this->form_validation->set_rules('Points', 'Points', 'required|strip_tags|xss_clean');
		$this->form_validation->set_rules('Current_redeem_points', 'Current redeem points', 'required|strip_tags|xss_clean');
		// $this->form_validation->set_rules('Total_balance', 'Total balance', 'required|integer');
		$this->form_validation->set_rules('Item_Weight', 'Item Weight', 'required|strip_tags|xss_clean');
		$this->form_validation->set_rules('Weight_unit_id', 'Weight unit id', 'required|strip_tags|xss_clean');
		
		// var_dump($this->form_validation->run());
		
		if ($this->form_validation->run() == FALSE)
		{
			// echo"<br> form_validation failed<br>";	
			$Total_Redeem_points=0;
			if(count($Redeemtion_details)!=0)
			{
				foreach($Redeemtion_details as $Redeemtion_details)
				{
					//echo "<br>".$Redeemtion_details["Points"];
					//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
					$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
				}
			}
			$item_list='Loading Page';			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
		}
		else
		{
				// echo"<br> form_validation success <br>";
				
				$Total_balance = ($data["Enroll_details"]->Total_balance-$data["Enroll_details"]->Debit_points);
		
				// echo "----Total_balance--11--".$Total_balance."--<br>";
				
				$item_id=$this->input->post('item_id');
				$Points=$this->input->post('Points');
				
				// echo "----item_id--11--".$item_id."--<br>";
			
				
				// $item_id=$this->security->xss_clean($item_id);
				// echo "----after use_xss_clean--".$item_id."--<br>";

				// $item_id = strip_tags($item_code);
				// echo "----item_code--22--".$item_code."--<br>";
				$itemDetails = $this->Redemption_Model->Get_Merchandize_Item_details($item_id,$session_data['Company_id']);
					
				// var_dump($itemDetails);	
				
				if($itemDetails){
					
					
					
					
					
					$Billing_price_in_points=$itemDetails[0]->Billing_price_in_points;	
					// echo "----Billing_price_in_points--22--".$Billing_price_in_points."--<br>";
					// echo "----Current_redeem_points--22--".$Current_redeem_points."--<br>";
					// echo "----Points--22--".$Points."--<br>";
					// echo "----Total_balance--22--".$Total_balance."--<br>";
					
					if($Billing_price_in_points==$Points)
					{
						
						// echo "---Inside --<br>";
						// die;
						
						$Item_code=$this->input->post('Company_merchandize_item_code');
						$Delivery_method=$this->input->post('Delivery_method');
						$location=$this->input->post('location');
						$Current_redeem_points=$this->input->post('Current_redeem_points');
						$Item_Weight=$this->input->post('Item_Weight');
						$Weight_unit_id=$this->input->post('Weight_unit_id');
						$Size=$this->input->post('Size');
						
						$insert_data = array(
					
							'Item_code' => $Item_code,
							'Redemption_method' => $Delivery_method,
							'Branch' => $location,
							'Points' => $Billing_price_in_points,
							'Weight' => $Item_Weight,
							'Weight_unit_id' => $Weight_unit_id,
							'Company_id' => $data['Company_id'],
							'Enrollment_id' => $data['enroll'],
							'Size' => $Size
						);

									
						// die;
						
						
						// $Total_balance=$this->input->post('Total_balance');
						
						
						
						//echo"$Current_redeem_points<=$Total_balance";
						if($Current_redeem_points<=$Total_balance)
						{
							$result = $this->Redemption_Model->insert_item_catalogue($insert_data);
							$Redeemtion_details = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
							// print_r($result);
							$Total_Redeem_points=0;
							// echo "dsfdsfdsf".count($Redeemtion_details);
							 if(count($Redeemtion_details)!=0)
							{
								foreach($Redeemtion_details as $Redeemtion_details)
								{
									//echo "<br>".$Redeemtion_details["Points"];
									//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
									$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
								}
							} 
							
							$item_list='Loading Page';
							if($result)
							{
								// $this->output->set_output("1");
								$this->output->set_content_type('application/json');
								$this->output->set_output(json_encode(array('cart_success_flag'=> '1', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
							}
							else    
							{
								// $this->output->set_output("0");
								$this->output->set_content_type('application/json');
								$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));
							}
						}
						
					} else {
						
						$Total_Redeem_points=0;
						if(count($Redeemtion_details)!=0)
						{
							foreach($Redeemtion_details as $Redeemtion_details)
							{
								//echo "<br>".$Redeemtion_details["Points"];
								//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
								$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
							}
						}
						$item_list='Loading Page';			
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));						
						// exit;
						
						
					}
					
					
						// Redemption_method
					

							
					
				} else {
					
					$Total_Redeem_points=0;
					if(count($Redeemtion_details)!=0)
					{
						foreach($Redeemtion_details as $Redeemtion_details)
						{
							//echo "<br>".$Redeemtion_details["Points"];
							//$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Points"];
							$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
						}
					}
					$item_list='Loading Page';			
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('cart_success_flag'=> '0', 'cart_total' => $Total_Redeem_points, 'item_list' => $item_list)));					
					// exit;
				}
				
			

				
				
				
				
				
		}
			
	}	
	public function delete_item_catalogue()
	{
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		$Item_code=strip_tags($_REQUEST["Item_code"]);
		$Branch=strip_tags($_REQUEST["Branch"]);
		$Size=strip_tags($_REQUEST["Size"]);
		$Total_Redeem_points=0;
		$Redemption_method=$_REQUEST["Redemption_method"];
	
		$result = $this->Redemption_Model->delete_item_catalogue($Item_code,$data['enroll'],$data['Company_id'],$Branch,$Size,$Redemption_method);
		
		
		$data['token'] = $this->security->get_csrf_hash();
		
		$Redeemtion_details = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
		$Total_Redeem_points=0;
		 if(count($Redeemtion_details)!=0)
		{
			foreach($Redeemtion_details as $Redeemtion_details)
			{
				$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
			}
		}
		// echo"----Total_Redeem_points---".$Total_Redeem_points."--<br>";
		
		$TotalRedeempoints = $this->string_encrypt($Total_Redeem_points, $this->key, $this->iv);	
		$Encrypted_TotalRedeempoints = preg_replace("/[^(\x20-\x7f)]*/s", "", $TotalRedeempoints);		
		$this->session->set_userdata('Session_TotalRedeempoints',$Encrypted_TotalRedeempoints);
		
		
		$data['token'] = $this->security->get_csrf_hash();		
		echo json_encode($data['token']);
		
		// echo"----Encrypted_TotalRedeempoints---".$Encrypted_TotalRedeempoints."--<br>";
		
		// redirect("Redemption_Catalogue/Proceed_Redemption_Catalogue/");
	}
	
	public function view_cart()
	{
				error_reporting(0);
				$session_data = $this->session->userdata('cust_logged_in');
				$Logged_user_enroll = $session_data['enroll'];
				$data['smartphone_flag']= $session_data['smartphone_flag'];
				
				
				$data['Redeemtion_details2'] = $this->Redemption_Model->get_total_redeeem_points($Logged_user_enroll);
				
				//$data['lp_array'] = $ref_array;
				$this->load->view('Redemption_Catalogue/view_item_list', $data);		
	}
	function Update_Merchandize_Cart()
	{
		
		
		// var_dump($_REQUEST);
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
		$Cust_Tier_id=$data["Enroll_details"]->Tier_id;
			
		$Tier_details = $this->Redemption_Model->Get_tier_details($data['Company_id'],$Cust_Tier_id);
		foreach($Tier_details as $Tier_details)
		{
			$Tier_redemption_ratio = $Tier_details->Tier_redemption_ratio;
		}
			
		$Qty = strip_tags($_REQUEST['Qty']);
		$Item_code = strip_tags($_REQUEST['Item_code']);
		$Branch = strip_tags($_REQUEST['Branch']);
		$Points = strip_tags($_REQUEST['Points']);
		$Size = strip_tags($_REQUEST['Size']);
		$Redemption_method = strip_tags($_REQUEST['Redemption_method']);
		$Item_Weight = strip_tags($_REQUEST['Item_Weight']);
		$Weight_unit_id = strip_tags($_REQUEST['Weight_unit_id']);
		$Total_Redeem_points =strip_tags($_REQUEST["Total_Redeem_points"]);
		
		$data['token'] = $this->security->get_csrf_hash();
		
		$itemDetails = $this->Redemption_Model->Get_Merchandize_Item_details_byCode($Item_code,$session_data['Company_id']);
		
		// var_dump($itemDetails);
		// die;
		if($itemDetails){
			
			
			/***************Remove all records of same Item code************************/
				$result1 = $this->Redemption_Model->delete_item_catalogue($Item_code,$data['enroll'],$data['Company_id'],$Branch,$Size,$Redemption_method);
			/****************************************************************/
			
				$Billing_price_in_points=$itemDetails[0]->Billing_price_in_points;	
				
				$Billing_price_in_points_tier = $Billing_price_in_points * $Tier_redemption_ratio;
				if($Billing_price_in_points != $Billing_price_in_points_tier)
				{
					$Billing_price_in_points = $Billing_price_in_points_tier;
				
				}
			
				for($i=0;$i<$Qty;$i++)
				{	
					  $insert_data = array(
					'Item_code' => $Item_code,
					'Redemption_method' => $Redemption_method,
					'Branch' => $Branch,
					'Points' => $Billing_price_in_points,
					'Size' => $Size,
					'Weight' => $Item_Weight,
					'Weight_unit_id' => $Weight_unit_id,
					'Company_id' => $data['Company_id'],
					'Enrollment_id' => $data['enroll']
					
					);   
					
					$result = $this->Redemption_Model->insert_item_catalogue($insert_data);
				}
			
			
			
			
			$Redeemtion_details = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
			$Total_Redeem_points=0;
			 if(count($Redeemtion_details)!=0)
			{
				foreach($Redeemtion_details as $Redeemtion_details)
				{
					$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
				}
			}
			// echo"----Total_Redeem_points---".$Total_Redeem_points."--<br>";
			
			$TotalRedeempoints = $this->string_encrypt($Total_Redeem_points, $this->key, $this->iv);	
			$Encrypted_TotalRedeempoints = preg_replace("/[^(\x20-\x7f)]*/s", "", $TotalRedeempoints);
			
			$this->session->set_userdata('Session_TotalRedeempoints',$Encrypted_TotalRedeempoints);
			// echo"----Encrypted_TotalRedeempoints---".$Encrypted_TotalRedeempoints."--<br>";
		}
		
		
		redirect('Redemption_Catalogue/Proceed_Redemption_Catalogue/');   
	}
	public function Merchandize_Item_details() 
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			$Company_merchandise_item_id=$_GET['Company_merchandise_item_id'];
			
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
			
			
			
			/*************************07-07-2017 AMIT Customer Recent Items count******************************/
			$Item_exist_count = $this->Redemption_Model->Check_Cust_Recent_merchandize_items_exist($data['Company_id'],$data['enroll'],$Company_merchandise_item_id);
			
			/****************Delete Items*******************/
			if($Item_exist_count>0)
			{
				$Item_exist_Delete = $this->Redemption_Model->Delete_Cust_Recent_merchandize_items_exist($data['Company_id'],$data['enroll'],$Company_merchandise_item_id);
			}
			
			/****************Insert Recent/Most View Items*******************/
			
				$insert_data = array(
				'Company_id' => $data['Company_id'],
				'Enroll_id' => $data['enroll'],
				'Item_id' => $Company_merchandise_item_id,
				'Create_date' => date("Y-m-d H:i:s")
				);	
				$Insert_view_item= $this->Redemption_Model->Insert_view_item($insert_data);
			
			/*********************************************************/
				if($_GET['Company_merchandise_item_id'] != "")
				{
					// echo "---Company_merchandise_item_id---".$_GET['Company_merchandise_item_id']."---<br>";
					// echo "---key---".$this->key."---<br>";
					// echo "---iv---".$this->iv."---<br>";
					// $Company_merchandise_item_id1=ltrim(rtrim($_GET['Company_merchandise_item_id']));
					$item_id1=$_GET['Company_merchandise_item_id'];
					// echo "---item_id1---".$item_id1."---<br>";
					// $item_id1='WVWrmO7InUvsLX4KZecj5NbPy8Lov+wuaZ653rXFBkViq/hTgUdmnTqR0/EXv77sSWJvoffc3qYwa7FH7yVyhYsam6+uvUpJupnLGKbTe1zqU7U4SS/+v3C602YkhVL3';
					$decryptID1 = $this->string_decrypt($item_id1,$this->key, $this->iv);	
					$decryptID = preg_replace("/[^(\x20-\x7f)]*/s", "",$decryptID1);							
					// echo "---decryptID---".$decryptID."---<br>";
					// die;
				
					if($decryptID == "")
					{
						// redirect('Errors', 'refresh');
						 $this->load->view('err404',$data); 
					} 
					else 
					{
						$Redemption_Items = $this->Redemption_Model->Get_Merchandize_Item_details($decryptID);
						$data['Redemption_Items'] = $Redemption_Items;
						
						foreach ($Redemption_Items as $product)
						{
							
							$itemCode = $product->Company_merchandize_item_code;
							
							$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product->Company_merchandize_item_code,$product->Company_id);
									
						}						
						$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
						$data["Item_details"] = $this->Redemption_Model->Get_Merchandize_Item_details($decryptID);
						$data["Company_merchandise_item_id"] = $decryptID;
						$this->load->view('Redemption_Catalogue/Merchandize_item_details', $data);
					}
			}
			else
			{
				redirect('Redemption_Catalogue');   
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	
	public function Insert_Redeem_Items()
	{
		if($this->session->userdata('cust_logged_in'))
		{
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$emailid= $session_data['username'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			// var_dump($_POST);
			
			
			
			$Company_website = base_url();
			// $Current_balance=$this->input->post("Current_balance");
			// $Full_name=$this->input->post("Full_name");
			// $Total_Redeem_points=$this->input->post("Total_Redeem_points");
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Current_balance = ($data["Enroll_details"]->Total_balance-$data["Enroll_details"]->Debit_points);
			$Full_name = $data["Enroll_details"]->First_name.' '.$data["Enroll_details"]->Last_name;
			
			$Redeemtion_details = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
			$Total_Redeem_points=0;
			 if(count($Redeemtion_details)!=0)
			{
				foreach($Redeemtion_details as $Redeemtion_details)
				{
					$Total_Redeem_points=$Total_Redeem_points+$Redeemtion_details["Total_points"];
				}
			}
			$Sub_Total=$Total_Redeem_points;
			// echo"Total_Redeem_points--------".$Total_Redeem_points;
			// echo"Sub_Total--------".$Sub_Total;
			// die;
			
		if($Sub_Total <= $Current_balance )	
		{
			
			$Company_details = $this->Igain_model->get_company_details($data['Company_id']);
			$Redemptionratio=$Company_details->Redemptionratio;
			$Evoucher_expiry_period=$Company_details->Evoucher_expiry_period;
			/*******Pin No. Validation*****************/
			$Pin_no_applicable=$Company_details->Pin_no_applicable;
			if($Pin_no_applicable==1)
			{
				$Enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				$pinno=$Enroll_details->pinno;
				if($_REQUEST["input_cust_pin"]!=$pinno)
				{
					$this->session->set_flashdata("Redeem_flash","Redemption failed due to Invalid Pin No.");
					redirect('Redemption_Catalogue'); 
				}
			}
			/**************************/
			/* $Trans_date=date("Y-m-d");
			$Trans_date12=date("d M Y"); */
			
			$_SESSION["shipping_address"]=1;
			$Seller_details = $this->Igain_model->get_super_seller_details($data['Company_id']);
			$Seller_id=$Seller_details->Enrollement_id;
			$Seller_name=$Seller_details->First_name.' '.$Seller_details->Last_name;
			$Purchase_Bill_no = $Seller_details->Purchase_Bill_no;
			$tp_db = $Purchase_Bill_no;
			$len = strlen($tp_db);
			$str = substr($tp_db,0,5);
			$bill = substr($tp_db,5,$len);
			
			$Evoucher_expiry_date=date("Y-m-d",strtotime("+".$Evoucher_expiry_period." days"));
			
			
			//echo"timezone_entry--------".$session_data['timezone_entry'];
			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');			
			$data["Item_details"] = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
			
			foreach($data["Item_details"] as $Item_details)
			{		
				$Temp_cart_id=$Item_details['Temp_cart_id'];
				$Weighted_avg_shipping_pts=$_REQUEST["Hidden_Weighted_avg_shipping_pts_$Temp_cart_id"];
				$Weighted_avg_shipping_cost=($Weighted_avg_shipping_pts/$Redemptionratio);
				$characters = 'A123B56C89';
				$string = '';
				$Voucher_no="";
				for ($i = 0; $i < 16; $i++) 
				{
					$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
				}
								
				//$Merchandize_item_type = $this->Redemption_Model->Get_item_details_by_code($data['Company_id'],$Item_details["Item_code"]);
                                        
				
				if($Item_details["Merchandize_item_type"]==41 || $Item_details["Merchandize_item_type"]==42) {
					
					$Gift_Voucher_no = "";
					$length=10;
					$codeAlphabet.= "0123456789";
						$max = strlen($codeAlphabet); // edited
					   for ($j=0; $j < $length; $j++) {
						   $Gift_Voucher_no .= $codeAlphabet[mt_rand(0, $max-1)];
					   }
					   
				}
												
				if($Item_details["Redemption_method"]==28)
				{
					$Voucher_status="30";
				}
				else
				{
					$Voucher_status="18";
				}
				
				
				if($Item_details["Size"] == 1)
				{
				  $item_size = "Small";
				}
				elseif($Item_details["Size"] == 2)
				{
					$item_size = "Medium";
				}
				elseif($Item_details["Size"] == 3)
				{
					$item_size = "Large";
				}
				elseif($Item_details["Size"] == 4)
				{
					$item_size = "Extra Large";
				}
				elseif($Item_details["Size"] == 0)
				{
					$item_size = "-";
				}
				/****************GET COST PRICE****************************/
				$Cost_price=$Item_details["Cost_price"];
				if($Item_details["Size"] != 0)
				{
					$Get_size_records = $this->Redemption_Model->Get_item_details_size($data['Company_id'],$Item_details["Item_code"]);
					foreach($Get_size_records as $rec2)
					{
						if($rec2["Item_size"]==$Item_details["Size"])
						{
							$Cost_price=$rec2["Cost_price"];
						}
					}
					
				}
				$Cost_payable_partner=$Cost_price+($Cost_price*($Item_details["Partner_vat"]/100));
				$Cost_payable_partner=($Cost_payable_partner*$Item_details["Quantity"]);
				//echo "Cost_price ".$Cost_price; die;
				/*****************************************/
				
				
				if($Item_details["Merchandize_item_type"]==41 || $Item_details["Merchandize_item_type"]==42) {
					
					 $Voucher_status=31;
					 $Voucher_no=$Gift_Voucher_no;
				 }
				
			$insert_data = array(
				'Company_id' => strip_tags($data['Company_id']),
				'Trans_type' => 10,
				'Redeem_points' => strip_tags($Item_details["Points"]),
				//'Paid_amount' => $Cost_payable_partner,
				'Quantity' => strip_tags($Item_details["Quantity"]),
				'Trans_date' => strip_tags($lv_date_time),
				'Remarks' => 'Redeem Merchandize Items by Catalogue',
				'Seller' => strip_tags($Seller_id),
				'Seller_name' => strip_tags($Seller_name),
				'Create_user_id' => strip_tags($data['enroll']),
				'Enrollement_id' => strip_tags($data['enroll']),
				'Card_id' => strip_tags($data['Card_id']),
				'Item_code' => strip_tags($Item_details["Item_code"]),
				'Item_name' => strip_tags($Item_details['Merchandize_item_name']),
				'Voucher_no' => strip_tags($Voucher_no),
				'Delivery_method' => strip_tags($Item_details["Redemption_method"]),
				'Voucher_status' => 30,
				'Shipping_points' => 0,
				'Shipping_cost' => 0,
				'Cost_payable_partner' =>strip_tags($Cost_payable_partner),
				'Merchandize_Partner_id' => strip_tags($Item_details["Partner_id"]),
				'Merchandize_Partner_branch' => strip_tags($Item_details["Branch"]),
				'Bill_no' => strip_tags($bill),
				'Item_size' => strip_tags($Item_details["Size"])
				);
				 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
				 $Calc_Current_balance=($Current_balance-$Total_Redeem_points);
				 $Voucher_array[]=$Voucher_no;
				 /**************insert shipping details*************/
				 if($Item_details["Redemption_method"]==29)
				 { 
					
						$shipping_details = array
						(
							'Transaction_date' => strip_tags($lv_date_time),
							'Enrollment_id' => strip_tags($data['enroll']),
							'Cust_name' => strip_tags($this->input->post("firstname"))." ".strip_tags($this->input->post("lastname")),
							'Cust_address' => strip_tags($this->input->post("address")),
							'Cust_city' => strip_tags($this->input->post("city")),
							'Cust_zip' => strip_tags($this->input->post("zip")),
							'Cust_state' => strip_tags($this->input->post("state")),
							 'Cust_country' =>strip_tags($this->input->post("country")),
							'Cust_phnno' => strip_tags($this->input->post("phone")),
							'Cust_email' => strip_tags($this->input->post("email")),
							'Transaction_id' => strip_tags($Insert),
							'Company_id' => strip_tags($data['Company_id'])
						);						
						$shipping_details = $this->Shopping_model->insert_shipping_details($shipping_details);
					
				 }	
				 /************************/
				 /*********************Nilesh igain Log Table change 28-06-207*************************/
				$Enroll_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
				$opration = 1;				
				$userid = $Enroll_details->User_id;
				$what="Redeemed Merchandize Item";
				$where="Redemption Catalogue";
				$opval = 'Item Code-'.$Item_details["Item_code"].', Points-'.$Item_details["Points"].' & Voucher no-'.$Voucher_no; 
				$Todays_date=date("Y-m-d");
				$firstName = $Enroll_details->First_name;
				$lastName = $Enroll_details->Last_name;
				$User_email_id = $Enroll_details->User_email_id;
				$LogginUserName = $Enroll_details->First_name.' '.$Enroll_details->Last_name;
				$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$session_data['enroll'],$User_email_id,$LogginUserName,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$session_data['enroll']);
			/**********************igain Log Table change 28-06-2017 *************************/
				 
				 
			}
			foreach($data["Item_details"] as $Item_details)
			{
				$Delete = $this->Redemption_Model->delete_item_catalogue($Item_details["Item_code"],$data['enroll'],$data['Company_id'],$Item_details["Branch"],$Item_details["Size"],$Item_details["Redemption_method"]);
			}
			
			/************************Update Seller Bill No.*************/
			$bill_no = $bill + 1;
			$billno_withyear = $str.$bill_no;
			$result4 = $this->Shopping_model->update_billno($Seller_id,$billno_withyear);
			/************************Update Current balance & Total Redeems*************/
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$lv_Total_reddems=($data['Enroll_details']->Total_reddems+$Total_Redeem_points);
			$lv_Current_balance=$data['Enroll_details']->Current_balance;
			$lv_Blocked_points=$data['Enroll_details']->Blocked_points;
			$lv_Debit_points=$data['Enroll_details']->Debit_points;
			
			$Calc_Current_balance=$lv_Current_balance-$Total_Redeem_points;
			
			$Avialable_balance=$Calc_Current_balance-($lv_Blocked_points+$lv_Debit_points);
			
			
		
			$Update = $this->Redemption_Model->Update_Customer_Balance($Calc_Current_balance,$lv_Total_reddems,$data['enroll']);
			/*****************************************************************/
			$banner_image=$this->config->item('base_url2').'images/redemption.jpg';	
			
			$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_details->Company_name ;
			
			
					
		
									
										$html.='<div class="table-responsive"> 
									<TABLE class="table" style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>									
									<!--<thead>							
									<TR>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Sr.No.</b>
														</TH>-->
									<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Item</b>
														</TH>-->
									<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Size</b>
									</TH>-->
										<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Total '.$Company_details->Currency_name.'</b>
														</TH>-->
														
										<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Shipping '.$Company_details->Currency_name.'</b>
														</TH>-->
														
												<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>QTY</b>
														</TH>-->		
										<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Delivery Method</b>
														</TH>-->
										<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Voucher No.</b>
														</TH>	
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
											<b>Partner Branch</b>
										</TH>	
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
											<b>Address</b>
										</TH>-->
										<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Merchant</b>
										</TH>-->														
														
										<!--<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
											<b>Status</b>
										</TH>
										</TR>
										</thead>-->
										<tbody>';
												
											$i=0;	
											$Total_Shipping_Points=$_REQUEST["Total_Shipping_Points"];	
											// $Sub_Total=$_REQUEST["Sub_Total"];	
											$Sub_Total=$Sub_Total;	
											foreach($data["Item_details"] as $item)
											{		 								
												
												
												$lv_Temp_cart_id=$item['Temp_cart_id'];
												$lv_Weighted_avg_shipping_pts=$_REQUEST["Hidden_Weighted_avg_shipping_pts_$lv_Temp_cart_id"];
												if($item["Size"] == 0)
												{
													$itemSize ="";
												}
												elseif($item["Size"] == 1)
												{
													$itemSize ="Small";
												}
												elseif($item["Size"] == 2)
												{
													$itemSize ="Medium";
												}
												elseif($item["Size"] == 3)
												{
													$itemSize ="Large";
												}
												elseif($item["Size"] == 4)
												{
													$itemSize ="Extra Large";
												}
												
												if($item["Merchant_flag"]==1)
												{
													$Enroll_details = $this->Igain_model->get_enrollment_details($item['Seller_id']);
													
													$Merchant_name = $Enroll_details->First_name.' '.$Enroll_details->Last_name;		
												}
												else
												{
													$Merchant_name = "-";
												}
												if($item["Redemption_method"]==28)
												{
													$Voucher_status="Issued";
												}
												else
												{
													$Voucher_status="Ordered";
												}
												
												if($item["Merchandize_item_type"]==41) {
												
													$Voucher_status="Issued";
												}
												if($item["Merchandize_item_type"]==42) {
												
													$Voucher_status="Used";
												}
												
												
												$Get_Code_decode = $this->Igain_model->Get_codedecode_row($item["Redemption_method"]);	
												$Redemption_method=$Get_Code_decode->Code_decode;
										
												$html .= '<TR>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px;width: 32%;" align=left ><b> Sr.No.</b></TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.($i+1).')
															</TD>
														</TR>
														<TR>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Item</b></TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.$item["Merchandize_item_name"].'
															</TD>
														</TR>';
														
														if($itemSize != ""){
															
															$html.='<TR>	
																<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Size</b></TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															   '.$itemSize.'
																</TD>
																
																</TR>';
														}														
														$html.='<TR>	
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b>'.$Company_details->Currency_name.'</b></TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																'.$item["Points"].'
															</TD>
														</TR>';
														if($lv_Weighted_avg_shipping_pts > 0){
															
															$html.='<TR>
																<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Shipping '.$Company_details->Currency_name.'</b></TD>	
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																	'.$lv_Weighted_avg_shipping_pts.'
																</TD>															
															</TR>';		
														}
														$html.='<TR>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> QTY</b></TD>
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Quantity"].'
															</TD>
														</TR>';												
														/*if($item["Merchandize_item_type"]==41 || $item["Merchandize_item_type"]==42) {
															
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															-
															</TD>';
															
														}else{
															
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Redemption_method.'
															</TD>';
														} */
															$html.='
															<TR>
																<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Voucher No.</b></TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Voucher_array[$i].'
															</TD>';
														
															if($item["Merchandize_item_type"]==41 || $item["Merchandize_item_type"]==42) {
															
																/* $html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																-
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																-
																</TD>'; */
															
															} else {
															
															$html.=' <TR>
																	<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Partner Branch</b></TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item["Branch_name"].'
															</TD>
															</TR>
															<TR>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Address</b></TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Address"].'
															</TD>';
														}
														
															$html.='<!--<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Merchant_name.'
															</TD>-->
														
															<TR>
															<TD style="border-bottom: #fd1090 2px solid;border-right:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b>Status</b>
															</TD>
															<TD style="border-bottom: #fd1090 2px solid;border-right: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															'.$Voucher_status.'
															</TD>
														</TR>';
												$i++;
											}
											
												$html .='
												</tbody>
												</TABLE>
												</div>												
												<br>';											
												
												$html .='<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=left>
												
													<!--<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Total Shipping '.$Company_details->Currency_name.'</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Total_Shipping_Points.'
														</TD>
													</TR>-->
													<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Sub Total</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Sub_Total.'
														</TD>
													</TR>
													
													<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Grand Total '.$Company_details->Currency_name.'</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Total_Redeem_points.'
														</TD>
													</TR>
																						
													<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Current Balance</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Avialable_balance.' '.$Company_details->Currency_name.'
														</TD>
													</TR>
													</TABLE><br><br><br><br><br><br>';
													 
			
					
			
							
			
							// echo "<br>".$html;	
						//'Active_flag' =>1
						
					$Email_content = array(
						'datatable' => $html,
						'Order_no' => $bill,
						'Amount' =>0,
						'Redeem_points' =>$Total_Redeem_points,
						'subject' => $subject,
						'Notification_type' => 'Redemption',
						'Template_type' => 'Redemption'
					);
					
		$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,$Seller_id,$data['Company_id']);
			
		
		 
		
			
			// var_dump($Update);
			// die;
			if($Insert == true)
			{
				$this->session->set_flashdata("Redeem_flash","You have redeemed successfully, please check your email for your  voucher number(s). Once received kindly visit the Merchandize Partner Location for your item(s) within ".$Evoucher_expiry_period." days !!");
					
				
				
			}
			else
			{
				$this->session->set_flashdata("Redeem_flash","Redeem  Error!!");
			}
			
		}	
		else
		{
			$this->session->set_flashdata("Redeem_flash","Insufficient Current Balance. To Redeem ");
		}
			
			redirect('Redemption_Catalogue'); 
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	
	public function Get_Shipping_details()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($data['Company_id']);
			$Merchandize_category_id=0;
			
			$Company_details = $this->Igain_model->get_company_details($data['Company_id']);
			$data["Pin_no_applicable"]=$Company_details->Pin_no_applicable;
			$data["Redemptionratio"]=$Company_details->Redemptionratio;
			$data["Cust_Pin"]=$data["Enroll_details"]->pinno;
			$data["To_Country"]=$data["Enroll_details"]->Country;
			$data["To_State"]=$data["Enroll_details"]->State;
			$data["City_id"]=$data["Enroll_details"]->City;
			$Cust_Tier_id=$data["Enroll_details"]->Tier_id;
			
			$data["Tier_details"] = $this->Redemption_Model->Get_tier_details($data['Company_id'],$Cust_Tier_id);
			foreach($data["Tier_details"] as $Tier_details)
			{
				$data["Redeemtion_limit"]=$Tier_details->Redeemtion_limit;
				$data["Tier_name"]=$Tier_details->Tier_name;
			}
			
			
			$data["Redemption_Items"] = $this->Redemption_Model->get_total_redeeem_points($data['enroll']);
			$FetchCountry = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchCountry;
			$data['States_array'] = $this->Igain_model->Get_states($data["Enroll_details"]->Country);	
			$data['City_array'] = $this->Igain_model->Get_cities($data["Enroll_details"]->State);	
				
			$data["Total_Redeem_points"] =0;
			//echo "pinno ".$data["Enroll_details"]->pinno;
			/*******AMIT 30-11-2017 gET Delivery price ***************/
			$data["Shipping_charges_flag"]=$Company_details->Shipping_charges_flag;
			$data["Standard_charges"]=$Company_details->Standard_charges;
			$data["Cost_Threshold_Limit"]=$Company_details->Cost_Threshold_Limit;
			
			/*********************************************/
			
			$this->load->view('Redemption_Catalogue/Redemption_delivery_view', $data);		
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	/***************AMIT Front Page Redemption Catelog Functions Start*******************/
	public function Merchandize_Item_details_front_page()
	{
		
			$Company_merchandise_item_id=$_REQUEST['Company_merchandise_item_id'];
			
			
			$Redemption_Items = $this->Redemption_Model->Get_Merchandize_Item_details($Company_merchandise_item_id);
			$data['Redemption_Items'] = $Redemption_Items;
			
			foreach ($Redemption_Items as $product)
			{
				
				$itemCode = $product->Company_merchandize_item_code;
				
				 $Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product->Company_merchandize_item_code,$product->Company_id);
				$Company_id=$product->Company_id;		
			} 
			
			$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
			/*************************07-07-2017 AMIT Customer Recent Items count**********************/
			$Item_exist_count = $this->Redemption_Model->Check_Cust_Recent_merchandize_items_exist($Company_id,0,$Company_merchandise_item_id);
			
			/****************Delete Items*******************/
			if($Item_exist_count>0)
			{
				$Item_exist_Delete = $this->Redemption_Model->Delete_Cust_Recent_merchandize_items_exist($Company_id,0,$Company_merchandise_item_id);
			}
			
			/****************Insert Recent/Most View Items*******************/
			
				$insert_data = array(
				'Company_id' => $Company_id,
				'Enroll_id' => 0,
				'Item_id' => $Company_merchandise_item_id,
				'Create_date' => date("Y-m-d H:i:s")
				);	
				$Insert_view_item= $this->Redemption_Model->Insert_view_item($insert_data);
			
			/*********************************************************/
			
			if($Company_merchandise_item_id != "")
			{
				
				$data["Item_details"] = $this->Redemption_Model->Get_Merchandize_Item_details($Company_merchandise_item_id);
				$data["Company_merchandise_item_id"] = $Company_merchandise_item_id;
				//$this->load->view('Redemption_Catalogue/Merchandize_item_details_front_page', $data);
				
				$theHTMLResponse = $this->load->view('Redemption_Catalogue/Merchandize_item_details_front_page', $data, true);		
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
			}
			else
			{
				redirect('Redemption_Catalogue');   
			}
		
	}
	public function CI_add_to_cart()
	{
		
		$this->load->library('cart');
			$data2 = array(
					'id'      => $_REQUEST["Company_merchandise_item_id"],
					'qty'     => 1,
					'price'   => $_REQUEST["Points"],
					'options' => array('E_commerce_flag'  => 0,'Company_merchandize_item_code' => $_REQUEST["Company_merchandize_item_code"], 'partner_branch' => $_REQUEST["partner_branch"],'Size'  => $_REQUEST["Size"],'Redemption_method'  => $_REQUEST["Redemption_method"],'Item_Weight'  => $_REQUEST["Item_Weight"],'Weight_unit_id'  => $_REQUEST["Weight_unit_id"],'partner_branch'  => $_REQUEST["partner_branch"], 'Item_image1' => $_REQUEST["Item_image1"]),
					'name'  => $_REQUEST["Merchandize_item_name"]
			);
			$this->cart->insert($data2);
			$Total1[]=0;
			$total_items[]=0;
			foreach ($this->cart->contents() as $items)
			{ 
				if($items['options']['E_commerce_flag']==0)		
				{
					$Total1[]=($items['price']*$items['qty']);
					$total_items[]=1;
				}
			}
			$this->output->set_output(array_sum($total_items));
			
	}
	public function View_all_items()
	{ 
		//$Company_id = $_REQUEST["Company_id"];
		
		/*********************Set Company_id in to session*********************/
		$Company_id = $this->session->userdata('Company_id');
		if($Company_id == NULL)
		{
			$Company_id1 = $_REQUEST["Company_id"];
			$this->session->set_userdata('Company_id', $Company_id1);			
		}
		$Company_id = $this->session->userdata('Company_id');
		/*********************Set Company_id in to session*********************/
		
		$data["Company_id"] = $Company_id; 
		$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id);		
		
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
		/*-----------------------Pagination---------------------*/			
		$config = array();
		$config["base_url"] = base_url() . "/index.php/Redemption_Catalogue/View_all_items/";
		$total_row = $this->Redemption_Model->Get_Merchandize_Items_Count($Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,0);
		// echo "***************************total_row ".$total_row;
		$config["total_rows"] = $total_row;
		$config["per_page"] = 9;
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
		$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($Company_id);
		
			
	
		$data["Redemption_Items"] = $this->Redemption_Model->get_all_items($config["per_page"],$page,$Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,0);	
		$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($Company_id);	
		if($data["Redemption_Items"] != NULL)
		{
			foreach ($data["Redemption_Items"] as $product)
			{
				$itemCode = $product['Company_merchandize_item_code'];
				$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
			}
			
			$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
			$Item_array=$data['Redemption_Items'];
		}
			/*************************04-09-2017 AMIT Get merchants*******************/
			$data["Sellers"] =$this->Igain_model->Fetch_All_Merchants($Company_id);		
		/*************************************************************************************
		//******************************Nilesh Sort by brand*********************************/
			$data["Item_brand"] = $this->Redemption_Model->Get_Merchandize_item_brand($Company_id);
		//******************************Nilesh Item Sory by brand*********************************/
		$this->load->view('Redemption_Catalogue/View_all_Merchandize_items',$data);
	}
	public function Checkout_front_page_items()
	{
		$Company_id = $_REQUEST["Company_id"];
		$data["Company_id"] = $Company_id;
		$data["Company_details"] = $this->Igain_model->Fetch_Company_Details($Company_id);
		
		$data["Seller_details"] = $this->Igain_model->FetchSellerdetails($Company_id);
		$data["Redemption_Items"] = $this->Redemption_Model->get_all_items(100,0,$Company_id,0,0,0,0,0,0);
			
		if($data["Redemption_Items"] != NULL)
		{
			foreach ($data["Redemption_Items"] as $product)
			{
				$itemCode = $product['Company_merchandize_item_code'];
				$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
			}
			
			$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
			$Item_array=$data['Redemption_Items'];
		}
		$this->load->view('Redemption_Catalogue/Checkout_front_page_items',$data);
	}
	public function Update_front_page_item_cart()
	{
		$data2 = array(
					'rowid'      => $_REQUEST["rowid"],
					'qty'     => $_REQUEST["Input_Qty"]
			);
		$result=$this->cart->update($data2);	
		/*if($result)
		{
			echo "<br>Updated";
		}
		else
		{
			echo "<br>Not Updated";
		}*/
		// $this->output->set_content_type('application/json');
		// $this->output->set_output(json_encode(array('result'=>$result)));		
		/* 
		$Total1[]=0;
		$total_items[]=0;
		foreach ($this->cart->contents() as $items)
		{ 
			if($items['options']['E_commerce_flag']==0)		
			{
				$Total1[]=($items['price']*$items['qty']);
				$total_items[]=1;
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('total_items'=>array_sum($total_items),'result'=>'Updated','total'=>array_sum($Total1))));		
			 */
	}
	public function Remove_front_page_item()
	{
		$data2 = array(
					'rowid'      => $_REQUEST["rowid"],
					'qty'     => 0
			);
		$result=$this->cart->update($data2);	
		/*if($result)
		{
			echo "<br>Updated";
		}
		else
		{
			echo "<br>Not Updated";
		}*/
		
		redirect('Redemption_Catalogue/Checkout_front_page_items/?Company_id='.$_REQUEST["Company_id"]); 		
		// redirect('Login'); 		
	}
		
	/************************************************AMIT*****************************************************************/
	/********************************Ravi 02-05-2019 XOXODAY---*************************************/
		
	function eVoucher_catalogue()
	{
		if($this->session->userdata('cust_logged_in'))
		{	
			$session_data = $this->session->userdata('cust_logged_in');
			$data['username'] = $session_data['username'];			
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Card_id']= $session_data['Card_id'];
			$data['Company_id']= $session_data['Company_id'];
			$data['smartphone_flag']= $session_data['smartphone_flag'];
			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);			
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Tier_id = $data["Enroll_details"]->Tier_id;
			$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$data['Company_id']);
			$data["Trans_details"] = $this->Igain_model->FetchTransactionDetails($data['enroll'],$data['Card_id']);
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$data["Merchandize_category"] = $this->Redemption_Model->Get_Merchandize_Category($data['Company_id']);
			// $Merchandize_category_id=0;
			$Merchandize_category_id="";
			$Sort_by=0;
			$Sort_by_merchant=0;
			$Sort_by_brand=0;
			$Sort_by_gender=0;
			$Sort_by_item_type=0;
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
			if(isset($_REQUEST["Sort_by_item_type"]))
			{
				$Sort_by_item_type=$_REQUEST["Sort_by_item_type"];
			}
			
			
			$data['key']=$this->key;
			$data['iv']=$this->iv;
		
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Redemption_Catalogue/index";
			$total_row = $this->Redemption_Model->Get_Merchandize_Items_Count($data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_item_type);
			
			
		//	echo "------total_row------".$total_row."----<br>";
			$config["total_rows"] = $total_row;
			$config["per_page"] = 8;
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
			
					
			$Redemption_Items = $this->Redemption_Model->get_all_items($config["per_page"],$page,$data['Company_id'],$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_item_type);		
			$data['Redemption_Items'] = $Redemption_Items;
			if($Redemption_Items != NULL)
			{
				foreach ($Redemption_Items as $product)
				{
					$itemCode = $product['Company_merchandize_item_code'];
					$Redemption_Items_branches_array[$itemCode] = $this->Redemption_Model->get_all_items_branches($product['Company_merchandize_item_code'],$product['Company_id']);
				}
				
				$data['Redemption_Items_branches'] = $Redemption_Items_branches_array;
				$Item_array=$data['Redemption_Items'];
			}
			/*************************04-09-2017 AMIT Get merchants*******************/
			$data["Sellers"] =$this->Igain_model->Fetch_All_Merchants($data['Company_id']);
			/********************************Nilesh filter**************************************/
			$data["Sellers1"] =$this->Igain_model->Fetch_All_Merchants($data['Company_id']);
			$data['Max_price'] = $this->Redemption_Model->fetch_max_price($data['Company_id']);
			$data['Min_price'] = $this->Redemption_Model->fetch_min_price($data['Company_id']);
			
			$get_all_products = $this->Redemption_Model->get_all_products($data['Company_id']);
            $data['numitems'] = count($get_all_products);	
			if($Redemption_Items != NULL)
			{
				$data['count4'] = count($Redemption_Items);		
			}
			$data["Item_brand"] = $this->Redemption_Model->Get_Merchandize_item_brand($data['Company_id']);
			$data["Gender_flag"] = $this->Redemption_Model->Get_Merchandize_item_Gender_flag($data['Company_id']);
			$data["Merchandize_item_type"] = $this->Redemption_Model->Get_Merchandize_item_type($data['Company_id']);		
            $data['Sort_by'] = $Sort_by;
            $data['Category_filter'] = $Merchandize_category_id;
            $data['Merchant_filter'] = $Sort_by_merchant;
            $data['brand_filter'] = $Sort_by_brand;			
			
			/*************************************************************************************/
			
			
			
			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');
			
			
			/*********************************XOXODAY Configuration*************************************************/
				if($data['Company_Details']->Gifting_enviornment_flag==0){
					$type=1;
				} else if($data['Company_Details']->Gifting_enviornment_flag==1){
					$type=2;
				}
				$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details($type);
				
				$url= $thirdparty_details->url;
				$token= $thirdparty_details->token;
				// echo $token;
				
			/*********************************XOXODAY Configuration*************************************************/
			
			
			
			$data['token'] = $this->security->get_csrf_hash();
			
			
			
			/*********************************XOXODAY****************************************************/
				
				
				$Country=$data["Enroll_details"]->Country;
				
				
				$Country_details = $this->Igain_model->get_dial_code($Country );
				$Symbol_of_currency = $Country_details->Symbol_of_currency;
			// echo"<br>--Symbol_of_currency---".$Symbol_of_currency;
			// echo"<br>--Merchandize_category_id-00--".$Merchandize_category_id;
				
				if($Merchandize_category_id != ""){
					$Merchandize_category_id=$Merchandize_category_id;
				} else {
					$Merchandize_category_id="";
				}
				
				
				
				// echo"<br>--Merchandize_category_id-11-->".$Merchandize_category_id;
				// echo"<pre>";
				$postarray= array(); 
				
				$currencyCodearray = array('key'=>'currencyCode','value'=>$Symbol_of_currency);
				$codearray= array('key'=>'type','value'=>"code");
				$categoryarray= array('key'=>'voucher_category','value'=>$Merchandize_category_id);
				$deliveryarray= array('key'=>'deliveryType','value'=>'realtime');
				
				// $filtersarray= array('key'=>'currencyCode','value'=>$Symbol_of_currency,'key'=>'type','value'=>'code','key'=>'voucher_category','value'=>$Category_filter); 
				
				$filtersarray= array($currencyCodearray,$codearray,$categoryarray,$deliveryarray);  
				$variablesarray["data"]= array('limit'=>'0','page'=>'0','includeProducts'=>'','excludeProducts'=>'','filters'=>$filtersarray);  
				$postarray = array('query' =>'plumProAPI.mutation.getVouchers', 'tag' =>'plumProAPI', 'variables' =>$variablesarray);
				$arr1 = json_encode($postarray);
				// echo"<br>--arr1---";
				// print_r($arr1);				
				// die;
				
				/* 28-06-2022 */
				
				
				
					$curl = curl_init();
						curl_setopt_array($curl, array(
						  // CURLOPT_URL => 'https://stagingaccount.xoxoday.com/chef/v1/oauth/api',
						  CURLOPT_URL =>$url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS =>$arr1,
						  CURLOPT_HTTPHEADER => array(
							'Authorization: Bearer '.$token.'',
							'Content-Type: application/json',
						  ),
						));
						$response = curl_exec($curl);
						curl_close($curl);
						// echo"<br><pre>--response---";
						$data['voucher_result']=json_decode($response, true);
						 
						 
						 /* Filters */
						$data['filter_response']['code']='';
					
						$curl = curl_init();
						curl_setopt_array($curl, array(
						  CURLOPT_URL =>$url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS =>'{
								"query": "plumProAPI.mutation.getFilters",
								"tag": "plumProAPI",
								"variables": {
									"data":{
										"filterGroupCode": "",
										"includeFilters": "",
										"excludeFilters": ""
									}
								}
							}',
						  CURLOPT_HTTPHEADER => array(
							'Authorization: Bearer '.$token.'',
							'Content-Type: application/json'
						  ),
						));

						$response2 = curl_exec($curl);
						curl_close($curl);						 
						$data['filter_response']=json_decode($response2, true);
						/* Filters */						 
						 
				/* 28-06-2022 */
				
			/*********************************XOXODAY****************************************************/
			
			// die;			
			$this->load->view('Redemption_Catalogue/Redemption_eVoucher_View', $data);		
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function oxoidpi(){
		
		if($_POST != null){
			
			$pid=strip_tags($this->input->post('ofgkdfndfhryhdbfdglfdgiujsfnmsdfhjdsfbnfd'));
			$qty=strip_tags($this->input->post('ofgkdfndfhryhdbfdglfdgiujwgfhlkrtiorenmdfhj'));
			$Voucher_price=strip_tags($this->input->post('ofgkdfndfhryhdbfdglfdgiuhrdeshikhgtyzs'));
			$Voucher_price_new=strip_tags($this->input->post('ofgkdfndfhryhdbfdglfdgiujwtyhnjkuiuo'));
			if($pid && $qty && $Voucher_price && $Voucher_price_new){
				
				$_SESSION['pIDXX']=$pid;
				$_SESSION['VoucherPriceXX']=$Voucher_price_new;
				$_SESSION['qtyXX']=$qty;
				
			} else {
				$_SESSION['pIDXX']=0;
				$_SESSION['qtyXX']=0;
				$_SESSION['VoucherPriceXX']=0;
			}
			
		}else{
			$_SESSION['pIDXX']=0;
			$_SESSION['qtyXX']=0;
			$_SESSION['VoucherPriceXX']=0;
		}
		
		
		$data['token'] = $this->security->get_csrf_hash();		
		echo json_encode($data);
		
	}
	public function oxoidpirwesopj(){
		
		if($_POST != null){
			
			$Price_value1=strip_tags($this->input->post('fghyjkuiolbfgerfddscsdswwesxkoplmswerv'));
			
			if($Price_value1){
				
				$_SESSION['PriceValueXX']=$Price_value1;
				
			} else {
				$_SESSION['PriceValueXX']=0;
			}
			
		}else{
			$_SESSION['PriceValueXX']=0;
		}		
		$data['token'] = $this->security->get_csrf_hash();		
		echo json_encode($data);
	}
	public function Redemption_done()
	{
		$session_data = $this->session->userdata('cust_logged_in');
		$data['username'] = $session_data['username'];			
		$data['enroll'] = $session_data['enroll'];
		$data['userId']= $session_data['userId'];
		$data['Card_id']= $session_data['Card_id'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
		$User_email_id=App_string_decrypt($data["Enroll_details"]->User_email_id);
		$contact=App_string_decrypt($data["Enroll_details"]->Phone_no);
		
		$Tier_id = $data["Enroll_details"]->Tier_id;
		$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$session_data['Company_id']);		
		
		
		$Tier_redemption_ratio = $data["Tier_details"]->Tier_redemption_ratio;
		
		
		$data['token'] = $this->security->get_csrf_hash();
		
			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');	
		
			$Company_Partners = $this->Redemption_Model->Get_Company_Partners($data['Company_id']);
			$Partner_id=$Company_Partners->Partner_id;
			$Partner_name=$Company_Partners->Partner_name;
			
			$Partner_Branches = $this->Igain_model->Get_Partner_Branches($Partner_id,$data['Company_id']);
			// var_dump($Partner_Branches);
			foreach ($Partner_Branches as $pBrach)
			{
				$Branch_name = $pBrach->Branch_name;
				$Branch_code = $pBrach->Branch_code;
			}
		
			// echo "-------Branch_name----".$Branch_name."---------------<br>";
			// echo "-------Branch_code----".$Branch_code."---------------<br>";
		
			$Seller_details = $this->Igain_model->get_super_seller_details($data['Company_id']);
			$Seller_id=$Seller_details->Enrollement_id;
			$Seller_name=$Seller_details->First_name.' '.$Seller_details->Last_name;
			$Purchase_Bill_no = $Seller_details->Purchase_Bill_no;
			// echo "-------Purchase_Bill_no----".$Purchase_Bill_no."---------------<br>";
			// echo "-------Seller_id----".$Seller_id."---------------<br>";
			$tp_db = $Purchase_Bill_no;
			$len = strlen($tp_db);
			$str = substr($tp_db,0,5);
			$bill = substr($tp_db,5,$len);
			
			
			$characters = 'A123B56C89';
			$Voucher_no="";
			for ($i = 0; $i < 16; $i++) 
			{
				$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
			}	
			$Gift_payment_balance =0;
			$Gifting_enviornment_flag =0;
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
					$Country = $Company['Country'];
					$Gift_payment_balance = $Company['Gift_payment_balance'];
					$Gift_point_balance = $Company['Gift_point_balance'];
					$Redemptionratio = $Company['Redemptionratio'];
					$Gifting_enviornment_flag = $Company['Gifting_enviornment_flag'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$Symbol_of_currency = $Country_details->Symbol_of_currency;
			
			// $contact1 = '+'.$Country_details->phonecode.'-'.$contact;
			
			// $dailCode='91';
			$cnt=strlen($Country_details->phonecode);
			// echo $cnt."<br>";
			// $phone='919561970954';
			$phone=substr($contact,$cnt);
			// echo $phone."<br>";
			$contact1='+'.$Country_details->phonecode.'-'.$phone;

			// echo $contact1;
			
			// $contact1 = '+'.$contact;
			// $contact1 = '+91-9561970954';
			
			
			/*********************************XOXODAY Configuration*************************************************/
				if($Gifting_enviornment_flag==0){
					$type=1;
				} else if($Gifting_enviornment_flag==1){
					$type=2;
				}
				$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details($type);
				
				$url= $thirdparty_details->url;
				$token= $thirdparty_details->token;
				
			/*********************************XOXODAY Configuration*************************************************/
			
			
			
			
			$voucher_id=strip_tags($this->input->post('pId'));
			$Voucher_name=strip_tags($this->input->post('product_name'));
			// $Total_points=strip_tags($this->input->post('Points'));
			// $Purchase_amount=strip_tags($this->input->post('Voucher_price'));
			// $Quantity=strip_tags($this->input->post('qty'));
			$product_image=strip_tags($this->input->post('product_image'));
			
			
			$characters = 'A123B56C89';
			$Orderid="";
			for ($i = 0; $i <8; $i++) 
			{
				$Orderid .= $characters[mt_rand(0, strlen($characters) - 1)];
			}

			$Quantity=$_SESSION['qtyXX'];

			
			
			$Purchase_amount=$_SESSION['VoucherPriceXX']*$_SESSION['qtyXX'];
			
			/********** Validation Item API ********/
	
					$temp_items_details=false;
					$postarray= array(); 
					
					$currencyCodearray = array('key'=>'currencyCode','value'=>$Symbol_of_currency);
					$codearray= array('key'=>'type','value'=>"code");				
					$deliveryarray= array('key'=>'deliveryType','value'=>'realtime');					
					$filtersarray= array($currencyCodearray,$codearray,$deliveryarray);  
					$variablesarray["data"]= array('limit'=>'1','page'=>'1','includeProducts'=>$voucher_id,'excludeProducts'=>'','filters'=>$filtersarray);  
					$postarray = array('query' =>'plumProAPI.mutation.getVouchers', 'tag' =>'plumProAPI', 'variables' =>$variablesarray);
					$arr1 = json_encode($postarray);				
					
						$curl1 = curl_init();
							curl_setopt_array($curl1, array(
							  CURLOPT_URL =>$url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_POSTFIELDS =>$arr1,
							  CURLOPT_HTTPHEADER => array(
								'Authorization: Bearer '.$token.'',
								'Content-Type: application/json',
							  ),
							));
							$Validateresponse = curl_exec($curl1);
							$Validateresponse=json_decode($Validateresponse, true);	
							curl_close($curl1);
			if($Gifting_enviornment_flag==0){
					$type=1;
				} else if($Gifting_enviornment_flag==1){
					$type=2;
				}
				
				$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details($type);
				
				$url= $thirdparty_details->url;
				$token= $thirdparty_details->token;
				
			/*********************************XOXODAY Configuration*************************************************/
			
			
			
			
			$voucher_id=strip_tags($this->input->post('pId'));
			$Voucher_name=strip_tags($this->input->post('product_name'));
			// $Total_points=strip_tags($this->input->post('Points'));
			// $Purchase_amount=strip_tags($this->input->post('Voucher_price'));
			// $Quantity=strip_tags($this->input->post('qty'));
			$product_image=strip_tags($this->input->post('product_image'));
			
			
			$characters = 'A123B56C89';
			$Orderid="";
			for ($i = 0; $i <8; $i++) 
			{
				$Orderid .= $characters[mt_rand(0, strlen($characters) - 1)];
			}

			$Quantity=$_SESSION['qtyXX'];

			
			
			$Purchase_amount=$_SESSION['VoucherPriceXX']*$_SESSION['qtyXX'];
			
			/********** Validation Item API ********/
	
					$temp_items_details=false;
					$postarray= array(); 
					
					$currencyCodearray = array('key'=>'currencyCode','value'=>$Symbol_of_currency);
					$codearray= array('key'=>'type','value'=>"code");				
					$deliveryarray= array('key'=>'deliveryType','value'=>'realtime');					
					$filtersarray= array($currencyCodearray,$codearray,$deliveryarray);  
					$variablesarray["data"]= array('limit'=>'1','page'=>'1','includeProducts'=>$voucher_id,'excludeProducts'=>'','filters'=>$filtersarray);  
					$postarray = array('query' =>'plumProAPI.mutation.getVouchers', 'tag' =>'plumProAPI', 'variables' =>$variablesarray);
					$arr1 = json_encode($postarray);				
					
						$curl1 = curl_init();
							curl_setopt_array($curl1, array(
							  CURLOPT_URL =>$url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_POSTFIELDS =>$arr1,
							  CURLOPT_HTTPHEADER => array(
								'Authorization: Bearer '.$token.'',
								'Content-Type: application/json',
							  ),
							));
							$Validateresponse = curl_exec($curl1);
							$Validateresponse=json_decode($Validateresponse, true);	
							curl_close($curl1);
				if($Gifting_enviornment_flag==0){		
					$type=1;
				} else if($Gifting_enviornment_flag==1){
					$type=2;
				}
				$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details($type);
				
				$url= $thirdparty_details->url;
				$token= $thirdparty_details->token;
				
			/*********************************XOXODAY Configuration*************************************************/
			
			
			
			
			$voucher_id=strip_tags($this->input->post('pId'));
			$Voucher_name=strip_tags($this->input->post('product_name'));
			// $Total_points=strip_tags($this->input->post('Points'));
			// $Purchase_amount=strip_tags($this->input->post('Voucher_price'));
			// $Quantity=strip_tags($this->input->post('qty'));
			$product_image=strip_tags($this->input->post('product_image'));
			
			
			$characters = 'A123B56C89';
			$Orderid="";
			for ($i = 0; $i <8; $i++) 
			{
				$Orderid .= $characters[mt_rand(0, strlen($characters) - 1)];
			}

			$Quantity=$_SESSION['qtyXX'];

			
			
			$Purchase_amount=$_SESSION['VoucherPriceXX']*$_SESSION['qtyXX'];
			
			/********** Validation Item API ********/
	
					$temp_items_details=false;
					$postarray= array(); 
					
					$currencyCodearray = array('key'=>'currencyCode','value'=>$Symbol_of_currency);
					$codearray= array('key'=>'type','value'=>"code");				
					$deliveryarray= array('key'=>'deliveryType','value'=>'realtime');					
					$filtersarray= array($currencyCodearray,$codearray,$deliveryarray);  
					$variablesarray["data"]= array('limit'=>'1','page'=>'1','includeProducts'=>$voucher_id,'excludeProducts'=>'','filters'=>$filtersarray);  
					$postarray = array('query' =>'plumProAPI.mutation.getVouchers', 'tag' =>'plumProAPI', 'variables' =>$variablesarray);
					$arr1 = json_encode($postarray);				
					
						$curl1 = curl_init();
							curl_setopt_array($curl1, array(
							  CURLOPT_URL =>$url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_POSTFIELDS =>$arr1,
							  CURLOPT_HTTPHEADER => array(
								'Authorization: Bearer '.$token.'',
								'Content-Type: application/json',
							  ),
							));
							$Validateresponse = curl_exec($curl1);
							$Validateresponse=json_decode($Validateresponse, true);	
							curl_close($curl1);
							// echo"<br><pre>--Validateresponse---";
							// print_r($Validateresponse['data']['getVouchers']['data'][0]);	
							$valueDenominations=array();
							
							if($Validateresponse['data']['getVouchers']['data'][0]){
								
								$name=$Validateresponse['data']['getVouchers']['data'][0]['name'];
								$productId=$Validateresponse['data']['getVouchers']['data'][0]['productId'];
								$valueDenominations=explode(",",$Validateresponse['data']['getVouchers']['data'][0]['valueDenominations']);
							} else {
								
								$productId=0;
							}
							
							
							
	
					if(in_array($_SESSION['VoucherPriceXX'],$valueDenominations)){
						
						$temp_items_details=true;
						
					} else {
						
						$temp_items_details=false;
					}
				/********** Validation Item ********/
			
			
			
			
			if($temp_items_details==true){
				
				
				if($_SESSION['pIDXX'] == $productId && $_SESSION['pIDXX'] != 0 && $_SESSION['VoucherPriceXX'] != 0 && $Purchase_amount > 0){
					
					
					
						// echo"<br>---Tier_redemption_ratio---".$Tier_redemption_ratio;
						// echo"<br>---Redemptionratio---".$Redemptionratio;
						/* if($Tier_redemption_ratio > 0){
							$Redemptionratio=$Tier_redemption_ratio;
						} else {
							$Redemptionratio=$Redemptionratio;
						}	 */					
						
						$Total_points =  $Purchase_amount * $Redemptionratio;
						// $Current_redeem_points =  $Purchase_amount * $Redemptionratio;
						$Billing_price_in_points_tier = $Total_points * $Tier_redemption_ratio;
						if($Total_points != $Billing_price_in_points_tier)
						{
							$Total_points = $Billing_price_in_points_tier;
						
						}
						$Current_redeem_points = $Total_points;
					$Total_balance = ($data["Enroll_details"]->Total_balance-$data["Enroll_details"]->Debit_points);
					if(($Current_redeem_points<=$Total_balance) && ($Gift_payment_balance >= $Purchase_amount))
					{
						
						// echo "-----all done for redeem-------------<br>";						
						// die;
						
							
							/* 28-06-2022 */
							
							
							$postarray= array();  
							// $poNumber1=rand(0000,9999);
							$poNumber1=time();
							$poNumber='po'.$poNumber1.'-'.$bill;
							$productId=$voucher_id;
							$quantity=$Quantity;
							// $denomination=$Purchase_amount;
							$denomination=$_SESSION['VoucherPriceXX'];
							$email=$User_email_id;
							
							// echo "-------poNumber----".$poNumber."---------------<br>";
							
							$variablesarray["data"]= array('productId'=>$productId,'quantity'=>$quantity,'denomination'=>$denomination,'email'=>$email,'contact'=>$contact1,'tag'=>"",'referenceID'=>$poNumber,'notifyAdminEmail'=>1);
							
							/* ,'notifyReceiverEmail'=>1 */
							
							$arr1 = array('query' =>'plumProAPI.mutation.placeOrder', 'tag' =>'plumProAPI', 'variables' =>$variablesarray);
							$postarray = json_encode($arr1);
								
								// echo"<pre>";
								// print_r($postarray);
							
							
								$data['voucher_response']['code']='';
								
								$curl = curl_init();
								curl_setopt_array($curl, array(
								  CURLOPT_URL =>$url,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => '',
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 0,
								  CURLOPT_FOLLOWLOCATION => true,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => 'POST',
								  CURLOPT_POSTFIELDS =>$postarray,
								  CURLOPT_HTTPHEADER => array(
									'Authorization: Bearer '.$token.'',
									'Content-Type: application/json'
								  ),
								));

								$response = curl_exec($curl);

								curl_close($curl);
								/* echo"<pre>";
								print_r($response);
								echo"<br>-----&&&&&&&&&&&&&&&&&------<br>";  */
								$voucher_codes=array();
								$pin_codes=array();
								$Gift_pointsArray=array();
								$Gift_paymentArray=array();
								/* 28-06-2022 */
								
								$data['voucher_response']=json_decode($response, true);
				
				
								/* Insert XOXODAY Place Order Response */
								
									$insertPOData=array(
									
										"Company_id"=>$data['Company_id'],
										"Enrollement_id"=>$data['enroll'],
										"Pid"=>$productId,
										"Product_name"=>$Voucher_name,
										"Total_points"=>$Total_points,
										"Purchase_amount"=>$Purchase_amount,
										"Quantity"=>$Quantity,
										"Bill_no"=>$bill,
										"Card_id"=>$data['Card_id'],
										"Response"=>json_encode($response),
										"Creacted_date"=>$lv_date_time,
										"PO_number"=>$poNumber
									
									);
									$resultplaceOrder = $this->Redemption_Model->Insert_eVouchar_placeOrder_response($insertPOData);
								
								/* Insert XOXODAY Place Order Response */
								
								
								
									
								// $data['voucher_response']=$response;	
								// print_r($data['voucher_response']['code']);
								if($data['voucher_response']['code'] != '422' ){
									
									foreach($data['voucher_response'] as $key => $value ){							
									
										// echo"--orderTotal-------".$value['placeOrder']['data']['orderTotal']."------<br>";							
										$orderTotal = $value['placeOrder']['data']['orderTotal']; 
										// print_r($value['placeOrder']['data']);
										
											foreach($value['placeOrder']['data'] as $value1){
												
												if(is_array($value1)){											
														foreach($value1 as $value2){									
															// echo"--voucherCode--".$value2['voucherCode']."------<br>";
															$voucher_codes[] = $value2['voucherCode'];
															$pin_codes[] = $value2['pin'];
									
																 // echo"----voucherCode-----".$value2['voucherCode']."-------amount-----".$orderTotal."---<br>";
																 // echo"----Total_points-----".$Total_points."---<br>";
																// die;
																$Total_points1=$Total_points/$Quantity;
																$Gift_pointsArray[] = $Total_points / $Quantity;
																
																
																// $Billing_price_in_points = $orderTotal * $Company_Details->Redemptionratio;
																
																
																
															/* 	if($Tier_redemption_ratio > 0){
																	$Redemptionratio=$Tier_redemption_ratio;
																} else {
																	$Redemptionratio=$Redemptionratio;
																} */
																
																
																
																$Paid_amount = $Total_points1 / $Redemptionratio;
																$Gift_paymentArray[] = $Total_points1 / $Redemptionratio;
																
																
																
																// $Billing_price_in_points = $orderTotal * $Company_Details->Redemptionratio;
																
																
																 // echo"----Total_points1-----".$Total_points1."---<br>";
																 
																/*  */
																$Insert_trasaction_data = array(
																
																	'Company_id' => $data['Company_id'],
																	'Enrollement_id' => $data['enroll'],			
																	'Trans_type' =>10,
																	// 'Trans_amount' =>$voucher['amount'],
																	// 'Purchase_amount' =>$voucher['amount'],
																	// 'Paid_amount' =>$Paid_amount,
																	// 'Redeem_amount' =>$Paid_amount,
																	'Redeem_points' => $Total_points1,
																	// 'Quantity' => $Quantity,
																	'Quantity' =>1,
																	'Remarks' =>'Gift Voucher Redeem',
																	'Trans_date' =>$lv_date_time,
																	'Bill_no' =>$bill,
																	'Manual_billno' =>$poNumber,
																	'Card_id' =>$data['Card_id'],
																	'Seller' =>$Seller_id,
																	'Seller_name' =>$Seller_name,
																	'Source' =>'e-Gifting Partner',
																	'Create_user_id' =>$data['enroll'],
																	'Voucher_status' =>296,
																	'Delivery_method' =>29,
																	'Item_code' => $this->input->post('Company_merchandize_item_code'),
																	'Item_name' => $Voucher_name,
																	// 'Voucher_no' => $Voucher_no,					
																	'Voucher_no' =>$value2['voucherCode'],					
																	// 'Weight' => $this->input->post('Item_Weight'),
																	// 'Weight_unit_id' => $this->input->post('Weight_unit_id'),			
																	'Cost_payable_partner' =>number_format($Purchase_amount,2),// $orderTotal,			
																	'Merchandize_Partner_id' => $Partner_id,			
																	'Merchandize_Partner_branch' => $Branch_code,			
																	'Item_size' => $this->input->post('Size')
																);
										
											
																$result = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($Insert_trasaction_data);
																
																
																
																
																
														}
												}
																						
											}
									}
									
									
								}
					
					
						$item_list='Loading Page';
						if($result)
						{
							
							
								/* Update XOXODAY Place Order  */
								
									$resultplaceOrder = $this->Redemption_Model->update_eVouchar_placeOrder_response($data['Company_id'],$productId,$poNumber);
								
								/* Update XOXODAY Place Order  */
							
							
							
							$Used_Gift_payment=array_sum($Gift_paymentArray);
							$Used_Gift_points=array_sum($Gift_pointsArray);	
						
							
							$Gift_payment_balance=$Gift_payment_balance-$Used_Gift_payment;
							$Gift_point_balance=$Gift_point_balance-$Used_Gift_points;
							
							
							
							
							$updateData=array(
								'Gift_payment_balance'=> $Gift_payment_balance,
								'Gift_point_balance'=> $Gift_point_balance
							);
							
							$company_giftbalance = $this->Igain_model->update_company_giftbalance($updateData,$data['Company_id']);
							// echo"----company_giftbalance--".$company_giftbalance."----<br>";
							/************************Update Current balance & Total Redeems*************/
						
								$bill_no = $bill + 1;
								$billno_withyear = $str.$bill_no;
								// echo"----Seller_id--".$Seller_id."----<br>";
								$result4 = $this->Shopping_model->update_billno($Seller_id,$billno_withyear);
								// echo"----<br>".$this->db->last_query()."----<br>";
								
								$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
								$lv_Total_reddems=($data['Enroll_details']->Total_reddems+$Total_points);
								$lv_Current_balance=$data['Enroll_details']->Current_balance;
								$lv_Blocked_points=$data['Enroll_details']->Blocked_points;
								$lv_Debit_points=$data['Enroll_details']->Debit_points;
								
								$Calc_Current_balance=$lv_Current_balance-$Total_points;
								
								$Avialable_balance=$Calc_Current_balance-($lv_Blocked_points+$lv_Debit_points);		
							
								$Update = $this->Redemption_Model->Update_Customer_Balance($Calc_Current_balance,$lv_Total_reddems,$data['enroll']);
								
							/************************Update Current balance & Total Redeems*************/
							
							
							$Email_content = array(
							
									'Voucher_name' =>$Voucher_name,
									'Trans_date' =>$Todays_date,
									'Redeem_points' =>$Total_points,
									'Purchase_amount' =>$Purchase_amount,
									'Quantity' =>$Quantity,
									'product_name' =>$product_name,
									'product_image' =>$product_image,
									'Symbol_of_currency' =>$Symbol_of_currency,
									'Voucher_no' => $voucher_codes,
									'Pin_codes' => $pin_codes,
									'Avialable_balance' => $Avialable_balance,
									'Notification_type' => 'Evoucher Redeem',
									'Template_type' => 'Evoucher_redemption'
								);
							$this->send_notification->send_Notification_email($data['enroll'],$Email_content,$Seller_id,$data['Company_id']);
							
							
							
							
							
							// $this->output->set_output("1");
							$this->output->set_content_type('application/json');
							$this->output->set_output(json_encode(array('cart_success_flag'=> '1','response'=>$response)));
						}
						else    
						{
							// $this->output->set_output("0");
							$this->output->set_content_type('application/json');
							$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>$response)));
						}
						
					} else {
						
						$this->output->set_content_type('application/json');
						$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>null)));
					}
					
					
				} else {
					
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>null)));
				}
				
			} else {
				
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>null)));
				
			}
			
		
			
	}
	/********************************Ravi 02-05-2019 XOXODAY---*************************************/
	/********************************Ravi 15-03-2019 emcryption*************************************/	
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
	/********************************Ravi 15-03-2019 emcryption*************************************/
	
}