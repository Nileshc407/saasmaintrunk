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
		$this->load->model('login/Login_model');
		$this->load->model('shopping/Shopping_model');
		$this->load->model('Igain_model');
		$this->load->library('cart');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->library('Send_notification');
		
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


	}
	
/************************************************AMIT Start***********************************************/

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
		$PriceFrom = $this->input->post("PriceFrom");
		$PriceTo = $this->input->post("PriceTo");		
		$Company_id = $this->input->post("Company_id");		
		$Sort_by = $this->input->post("Sort_by");		
		$Sort_category = $this->input->post("Sort_category");
		
		$data['Company_Details']= $this->Igain_model->get_company_details($Company_id);	
		
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
		
		// Redemption_method
		$insert_data = array(
		
			'Item_code' => $this->input->post('Company_merchandize_item_code'),
			'Redemption_method' => $this->input->post('Delivery_method'),
			'Branch' => $this->input->post('location'),
			'Points' => $this->input->post('Points'),
			'Weight' => $this->input->post('Item_Weight'),
			'Weight_unit_id' => $this->input->post('Weight_unit_id'),
			'Company_id' => $data['Company_id'],
			'Enrollment_id' => $data['enroll'],
			'Size' => $this->input->post('Size')
		);		
		$Total_balance=$this->input->post('Total_balance');
		$Current_redeem_points=$this->input->post('Current_redeem_points');
		// echo"$Current_redeem_points<=$Total_balance";
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
	}	
	public function delete_item_catalogue()
	{
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		$Item_code=$_REQUEST["Item_code"];
		$Branch=$_REQUEST["Branch"];
		$Size=$_REQUEST["Size"];
		$Total_Redeem_points=0;
		$Redemption_method=$_REQUEST["Redemption_method"];
	
		$result = $this->Redemption_Model->delete_item_catalogue($Item_code,$data['enroll'],$data['Company_id'],$Branch,$Size,$Redemption_method);
		
		
		
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
		
		redirect("Redemption_Catalogue/Proceed_Redemption_Catalogue/");
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
		$session_data = $this->session->userdata('cust_logged_in');
		$data['enroll'] = $session_data['enroll'];
		$data['Company_id']= $session_data['Company_id'];
		$data['smartphone_flag']= $session_data['smartphone_flag'];
		
		$Qty = $_REQUEST['Qty'];
		$Item_code = $_REQUEST['Item_code'];
		$Branch = $_REQUEST['Branch'];
		$Points = $_REQUEST['Points'];
		$Size = $_REQUEST['Size'];
		$Redemption_method = $_REQUEST['Redemption_method'];
		$Item_Weight = $_REQUEST['Item_Weight'];
		$Weight_unit_id = $_REQUEST['Weight_unit_id'];
		$Total_Redeem_points =$_REQUEST["Total_Redeem_points"];
		
		
		
		
 		/***************Remove all records of same Item code************************/
			$result1 = $this->Redemption_Model->delete_item_catalogue($Item_code,$data['enroll'],$data['Company_id'],$Branch,$Size,$Redemption_method);
		/****************************************************************/
 		for($i=0;$i<$Qty;$i++)
		{	
			  $insert_data = array(
			'Item_code' => $Item_code,
			'Redemption_method' => $Redemption_method,
			'Branch' => $Branch,
			'Points' => $Points,
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
			
			$Company_website = base_url();
			$Current_balance=$this->input->post("Current_balance");
			$Full_name=$this->input->post("Full_name");
			$Total_Redeem_points=$this->input->post("Total_Redeem_points");
			
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
				'Company_id' => $data['Company_id'],
				'Trans_type' => 10,
				'Redeem_points' => $Item_details["Points"],
				'Quantity' => $Item_details["Quantity"],
				'Trans_date' => $lv_date_time,
				'Remarks' => 'Redeem Merchandize Items by Catalogue',
				'Seller' => $Seller_id,
				'Seller_name' => $Seller_name,
				'Create_user_id' => $data['enroll'],
				'Enrollement_id' => $data['enroll'],
				'Card_id' => $data['Card_id'],
				'Item_code' => $Item_details["Item_code"],
				'Voucher_no' => $Voucher_no,
				'Delivery_method' => $Item_details["Redemption_method"],
				'Voucher_status' => $Voucher_status,
				'Shipping_points' => $Weighted_avg_shipping_pts,
				'Shipping_cost' => $Weighted_avg_shipping_cost,
				'Cost_payable_partner' => $Cost_payable_partner,
				'Merchandize_Partner_id' => $Item_details["Partner_id"],
				'Merchandize_Partner_branch' => $Item_details["Branch"],
				'Bill_no' => $bill,
				'Item_size' => $Item_details["Size"]
				);
				 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
				 $Calc_Current_balance=($Current_balance-$Total_Redeem_points);
				 $Voucher_array[]=$Voucher_no;
				 /**************insert shipping details*************/
				 if($Item_details["Redemption_method"]==29)
				 { 
					
						$shipping_details = array
						(
							'Transaction_date' => $lv_date_time,
							'Enrollment_id' => $data['enroll'],
							'Cust_name' => $this->input->post("firstname")." ".$this->input->post("lastname"),
							'Cust_address' => $this->input->post("address"),
							'Cust_city' => $this->input->post("city"),
							'Cust_zip' => $this->input->post("zip"),
							'Cust_state' => $this->input->post("state"),
							 'Cust_country' => $this->input->post("country"),
							'Cust_phnno' => $this->input->post("phone"),
							'Cust_email' => $this->input->post("email"),
							'Transaction_id' => $Insert,
							'Company_id' => $data['Company_id']
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
			
			$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
			$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			</head>';

			$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';
					
			$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
				<tr>
					<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
					<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
				</tr>
				
				<tr>
					<td vAlign=top>
						<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px solid #d2d6de" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
							<tr>
								<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
									<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										<tr style="HEIGHT: 10px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
												<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
															<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																<tr>
																	<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																		<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=680 height=200 hspace="0" vspace="0">
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table> 
												
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
													Dear '.$Full_name.' ,
												</P>';

												$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													 Thank You for Redeeming  Item(s)  from our Rewards Catalogue. Please find below the details of your transaction. <br><br>
													 <strong>Redemption Date:</strong> '.$lv_date_time. '<br><br>
													  <strong>Order No.:</strong> '.$bill. '<br><br>
												</P>';
									 
									 
									 
									
									$html.='<div class="table-responsive"> 
									<TABLE class="table" style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>
									
									<thead>
							
									<TR>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Sr.No.</b>
														</TH>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Item</b>
														</TH>
									<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Size</b>
									</TH>
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Total '.$Company_details->Currency_name.'</b>
														</TH>
														
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Shipping '.$Company_details->Currency_name.'</b>
														</TH>
														
												<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>QTY</b>
														</TH>		
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Delivery Method</b>
														</TH>	
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Voucher No.</b>
														</TH>	
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
											<b>Partner Branch</b>
										</TH>	
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
											<b>Address</b>
										</TH>
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
										<b>Merchant</b>
										</TH>														
														
										<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
											<b>Status</b>
										</TH>
										</TR>
										</thead>
										<tbody>';
												
											$i=0;	
											$Total_Shipping_Points=$_REQUEST["Total_Shipping_Points"];	
											$Sub_Total=$_REQUEST["Sub_Total"];	
											foreach($data["Item_details"] as $item)
											{										
												
												
												$lv_Temp_cart_id=$item['Temp_cart_id'];
												$lv_Weighted_avg_shipping_pts=$_REQUEST["Hidden_Weighted_avg_shipping_pts_$lv_Temp_cart_id"];
												if($item["Size"] == 0)
												{
													$itemSize ="-";
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
												if($item["Merchandize_item_type"]==41 || $item["Merchandize_item_type"]==42) {
												
													$Voucher_status="Used";
												}
												
												
												$Get_Code_decode = $this->Igain_model->Get_codedecode_row($item["Redemption_method"]);	
												$Redemption_method=$Get_Code_decode->Code_decode;
										
												$html .= '<TR>
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.($i+1).')
															</TD>
													
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.$item["Merchandize_item_name"].'
															</TD>
															
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
														   '.$itemSize.'
															</TD>
															
													
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																'.$item["Total_points"].'
															</TD>
															
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																'.$lv_Weighted_avg_shipping_pts.'
															</TD>
															
													
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Quantity"].'
															</TD>';												
														if($item["Merchandize_item_type"]==41 || $item["Merchandize_item_type"]==42) {
															
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															-
															</TD>';
															
														}else{
															
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Redemption_method.'
															</TD>';
														}
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Voucher_array[$i].'
															</TD>';
														
															if($item["Merchandize_item_type"]==41 || $item["Merchandize_item_type"]==42) {
															
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															-
															</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															-
															</TD>';
															
														}else{
															
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Branch_name"].'
															</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$item["Address"].'
															</TD>';
														}
														
															$html.='<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Merchant_name.'
															</TD>
														
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
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
												
												$html .='<TABLE style="border: #dbdbdb 1px solid; WIDTH: 40%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=left>
												
													<TR>
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															<b>Total Shipping '.$Company_details->Currency_name.'</b>
														</TD>
															<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
															'.$Total_Shipping_Points.'
														</TD>
													</TR>
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
													</TABLE>';
													
													
													
												$html .= '<br><br><br><br><br><br><br>
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													Regards,
													<br>Loyalty Team.
												</P>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
							<tr>
								<td style="BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
									<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										
										<tr style="HEIGHT: 20px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
													<STRONG>You can also visit the below link using your login credentials and check details.</STRONG> Visit
													<span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
														<a style="color:#C7702E" title="Member Website" href='. $Company_details->Website .' target="_blank">Member Website</a>
													</span>
												</P>
											</td>
										</tr>
										
										<tr style="HEIGHT: 20px">
											<td class="row" style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
											
															$html.=' <div class="table-responsive">';
															if( $Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "") 
															{ 
																$html .= '<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 0; COLOR: #333333; FONT-SIZE: 20px; mso-line-height-rule: exactly" align="center">
																		You can also download Android & iOS App
																</P>';					
															
															  $html.='	<table class="table" align="center" style="background-color: #fff;">
																		<tbody align="center">
																  <tr>';
																	if($Company_details->Cust_apk_link != "") 
																	{ 
																		$html.='<td>
																		<p align="center">APK</p> <br>
																		<a href="'.$Company_details->Cust_apk_link.'" title="Google Play" target="_blank">
																		<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.$this->config->item('base_url2').'images/Gooogle_Play.png" width=64 height=64 hspace="0" vspace="0">
																		</a>
																		</td>';
																	}
																	if($Company_details->Cust_ios_link != "") 
																	{
																		$html.='<td>
																			<p align="center">iOS</p> <br>
																			<a href="'.$Company_details->Cust_ios_link.'" title="iOS App" target="_blank">
																			<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.$this->config->item('base_url2').'images/iOs_app_store.png" width=64 height=64 hspace="0" vspace="0">
																			</a>
																			</td>';
																	}
																	
															}	
															$html.='</tr>
															</tbody>
															</table>
															</div>';
														  
														  
														  $html.='
																	<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly;text-align:justify;" align="center">
																			<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_details->Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
																			If you are not the intended recipient or responsible for delivery to the intended recipient,
																			you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_details->Company_name.' will not accept any claims for damages arising out of viruses.<br>
																			Thank you for your cooperation.</em>
																	</P>
																<br>';
													
											$html.='</td>
										</tr>
										
										
									</table>
								</td>
							</tr>';					
										 
						$html.='</table>
					</td>
				</tr>			
				<tr>
					<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
				</tr>
			</table>	
			</table>
			</body>
			</html>
			<style>
			td, th{
			font-size: 13px !IMPORTANT;
			}
			</style>'; 
			
					
			
							
			
							// echo "<br>".$html;	
						//'Active_flag' =>1
						
					$Email_content = array(
						'Redemption_details' => $html,
						'subject' => $subject,
						'Notification_type' => 'Redemption',
						'Template_type' => 'Redemption'
					);
					
		$Notification=$this->send_notification->send_Notification_email($data['enroll'],$Email_content,'0',$data['Company_id']);
			
		
		 
		// die;
			
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
			
			
			
			/*********************************XOXODAY****************************************************/
				

				$curl = curl_init();

				curl_setopt_array($curl, array(
				
				  CURLOPT_URL => "http://corp.xoxoday.com/index.php?route=clientapp/voucherlist/products",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => false,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => array('product_id' => '','country_name' => 'India','currency_code' => 'INR','limit' => '0','offset' => '0','username' => '','password' => '','categories' => ''),
				  
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
				  // $response=$response;
				  // echo $response;
				} 
				// echo"<pre>";
				// print_r($response);
				// $value_array=array();
				$data['voucher_result']=json_decode($response, true);
				// $i=0;
				/* foreach($result as $key => $value){
					// echo "key ==> ".$key." value===> ".$value."<br>";					
					if(is_array($value)){
						
						echo"product_id==>".$value[0]['product_id']."<br>";
						echo"product_name==>".$value[0]['product_name']."<br>";
						echo"product_description==>".$value[0]['product_description']."<br>";
						echo"currency_code==>".$value[0]['currency_code']."<br>";				
						echo"min_price==>".$value[0]['min_price']."<br>";				
						echo"max_price==>".$value[0]['max_price']."<br>";				
						echo"product_image==>".$value[0]['product_image']."<br>";				
						echo"product_denminations==>".$value[0]['product_denminations']."<br>";				
						echo"product_categories==>".$value[0]['product_categories']."<br>";				
						
					}
					
				} */	
				
				
				

			/*********************************XOXODAY****************************************************/
			
			// die;			
			$this->load->view('Redemption_Catalogue/Redemption_eVoucher_View', $data);		
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
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
			
			$Company_details = $this->Igain_model->Fetch_Company_Details($data['Company_id']);
			foreach($Company_details as $Company)
			{
					$Country = $Company['Country'];
			}
			$Country_details = $this->Igain_model->get_dial_code($Country );
			$Symbol_of_currency = $Country_details->Symbol_of_currency;
			
			
			
			
			$voucher_id=$this->input->post('pId');
			$Voucher_name=$this->input->post('product_name');
			$Total_points=$this->input->post('Points');
			$Purchase_amount=$this->input->post('Voucher_price');
			$Quantity=$this->input->post('qty');
			$product_image=$this->input->post('product_image');
			
			
			$characters = 'A123B56C89';
			$Orderid="";
			for ($i = 0; $i <8; $i++) 
			{
				$Orderid .= $characters[mt_rand(0, strlen($characters) - 1)];
			}
			
			$Total_balance=$this->input->post('Total_balance');
			$Current_redeem_points=$this->input->post('Current_redeem_points');
			
			if($Current_redeem_points<=$Total_balance)
			{
			
			
				$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://corp.xoxoday.com/index.php?route=clientapp/egv_test/getvoucher&key=12hjk3208dsf7823hj",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 0,
					  CURLOPT_FOLLOWLOCATION => false,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => array('username' => 'test@abc.com','password' => 'Qt26dghd','externalorderid' => $Orderid,'denomination' =>$Purchase_amount,'voucher_id' =>$voucher_id,'quantity' =>$Quantity),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);
					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					  // echo $response;
					}
		
			
				$voucher_codes=array();
				$data['voucher_response']=json_decode($response, true);			
				$value_array=array();
				foreach($data['voucher_response'] as $key => $value){
					
					
					if($key == 'vouchers'){					
						
						foreach($value as $voucher){
							
							
							$voucher_codes[] = $voucher['code'];
							
							 // echo"----code-----".$voucher['code']."-------amount-----".$voucher['amount']."---<br>";
							 // echo"----Total_points-----".$Total_points."---<br>";
							 
							$Total_points1=$Total_points/$Quantity;
							
							 // echo"----Total_points1-----".$Total_points1."---<br>";
							 
							 
							$Insert_trasaction_data = array(
							
								'Company_id' => $data['Company_id'],
								'Enrollement_id' => $data['enroll'],			
								'Trans_type' =>10,
								'Trans_amount' =>$voucher['amount'],
								'Purchase_amount' =>$voucher['amount'],
								'Paid_amount' =>$voucher['amount'],
								'Redeem_points' => $Total_points1,
								// 'Quantity' => $Quantity,
								'Quantity' =>1,
								'Remarks' =>'Gift Voucher Redeem',
								'Trans_date' =>$lv_date_time,
								'Bill_no' =>$bill,
								'Manual_billno' =>$bill,
								'Card_id' =>$data['Card_id'],
								'Seller' =>$Seller_id,
								'Seller_name' =>$Seller_name,
								'Source' =>'XOXODAY API',
								'Create_user_id' =>$data['enroll'],
								'Voucher_status' =>31,
								'Delivery_method' =>29,
								'Item_code' => $this->input->post('Company_merchandize_item_code'),
								// 'Voucher_no' => $Voucher_no,					
								'Voucher_no' =>$voucher['code'],					
								// 'Weight' => $this->input->post('Item_Weight'),
								// 'Weight_unit_id' => $this->input->post('Weight_unit_id'),			
								'Merchandize_Partner_id' => $Partner_id,			
								'Merchandize_Partner_branch' => $Branch_code,			
								'Item_size' => $this->input->post('Size')
							);
	
		
							$result = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($Insert_trasaction_data);
							 
							 
							 
							 
						}
						
						
					}
				}
		
			
			 // echo"----voucher_codes-----".$voucher_codes."---<br>";
			
			
			
			// die;
			
			
			
		
				
			
			$bill_no = $bill + 1;
			$billno_withyear = $str.$bill_no;
			$result4 = $this->Shopping_model->update_billno($Seller_id,$billno_withyear);
			
			
			/************************Update Current balance & Total Redeems*************/
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$lv_Total_reddems=($data['Enroll_details']->Total_reddems+$Total_points);
			$lv_Current_balance=$data['Enroll_details']->Current_balance;
			$lv_Blocked_points=$data['Enroll_details']->Blocked_points;
			$lv_Debit_points=$data['Enroll_details']->Debit_points;
			
			$Calc_Current_balance=$lv_Current_balance-$Total_points;
			
			$Avialable_balance=$Calc_Current_balance-($lv_Blocked_points+$lv_Debit_points);		
		
			$Update = $this->Redemption_Model->Update_Customer_Balance($Calc_Current_balance,$lv_Total_reddems,$data['enroll']);
			
			
			
			$Email_content = array(
			
					'Voucher_name' =>$Voucher_name,
					'Trans_date' =>$Todays_date,
					'Total_points' =>$Total_points,
					'Purchase_amount' =>$Purchase_amount,
					'Quantity' =>$Quantity,
					'product_name' =>$product_name,
					'product_image' =>$product_image,
					'Symbol_of_currency' =>$Symbol_of_currency,
					'Voucher_no' => $voucher_codes,
					'Avialable_balance' => $Avialable_balance,
					'Notification_type' => 'Evoucher Redeem',
					'Template_type' => 'Evoucher_redemption'
				);

			$this->send_notification->send_Notification_email($data['enroll'],$Email_content,$Seller_id,$data['Company_id']);
					
			
			$item_list='Loading Page';
			if($result)
			{
				// $this->output->set_output("1");
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '1')));
			}
			else    
			{
				// $this->output->set_output("0");
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0')));
			}
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