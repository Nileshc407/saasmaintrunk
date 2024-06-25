<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Gift_Catalogue extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->model('shopping/Shopping_model');
		$this->load->model('Igain_model');
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
	
		$this->iv = '56666852251557009888889955123458';
		
		$data['key']=$this->key;
		$data['iv']=$this->iv;
		
		ini_set('session.cookie_httponly', 1);

		ini_set('session.use_only_cookies', 1);

		
		ini_set('session.cookie_secure', 1);
	}
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
		
			$data["NotificationsCount"] = $this->Igain_model->Fetch_Open_Notification_Count($data['enroll'],$session_data['Company_id']);
			$data["NotificationsDetails"] = $this->Igain_model->FetchNotificationDetails($data['enroll'],$session_data['Company_id']);
			
			$Gifting_enviornment_flag = 0;
			$Gifting_enviornment_flag = $data['Company_Details']->Gifting_enviornment_flag;
			
			if($Gifting_enviornment_flag==0){
				$type=1;
			} else if($Gifting_enviornment_flag==1){
				$type=2;
			}
		
			$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details($type);
			
			if($thirdparty_details != Null)
			{
				$base_url = $thirdparty_details->base_url;
				$client_key = $thirdparty_details->client_key;
				$client_secret1 = $thirdparty_details->client_secret1;
				
				$Authorization1 = $client_key.':'.$client_secret1;
				
				$Api_url = $base_url.'products';
				$Authorization = base64_encode($Authorization1);
				
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => $Api_url,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				  CURLOPT_HTTPHEADER => array("Authorization:Basic $Authorization","Content-Type: application/json"),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				
				$data["voucher_result"] = json_decode($response, true);
			}
			else
			{
				$data["voucher_result"] = Null;
			}
			
			$this->load->view('Gift_Catalogue/Gift_Catalogue_View', $data);		
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
		
		$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
		$User_email_id=App_string_decrypt($data["Enroll_details"]->User_email_id);
		$contact=App_string_decrypt($data["Enroll_details"]->Phone_no);
		
		$Tier_id = $data["Enroll_details"]->Tier_id;
		$data["Tier_details"] = $this->Igain_model->get_tier_details($Tier_id,$session_data['Company_id']);		
		
		$Tier_redemption_ratio = $data["Tier_details"]->Tier_redemption_ratio;
		
		$logtimezone = $session_data['timezone_entry'];
		$timezone = new DateTimeZone($logtimezone);
		$date = new DateTime();
		$date->setTimezone($timezone);
		$lv_date_time=$date->format('Y-m-d H:i:s');
		$Todays_date = $date->format('Y-m-d');	
	
		$Company_Partners = $this->Redemption_Model->Get_Company_evoucherPartner($data['Company_id']);
		$Partner_id=$Company_Partners->Partner_id;
		$Partner_name=$Company_Partners->Partner_name;
		
		$Partner_Branches = $this->Igain_model->Get_Partner_Branches($Partner_id,$data['Company_id']);
		
		foreach ($Partner_Branches as $pBrach)
		{
			$Branch_name = $pBrach->Branch_name;
			$Branch_code = $pBrach->Branch_code;
		}
	
		$Seller_details = $this->Igain_model->get_super_seller_details($data['Company_id']);
		$Seller_id=$Seller_details->Enrollement_id;
		$Seller_name=$Seller_details->First_name.' '.$Seller_details->Last_name;
		$Purchase_Bill_no = $Seller_details->Purchase_Bill_no;
		
		$tp_db = $Purchase_Bill_no;
		$len = strlen($tp_db);
		$str = substr($tp_db,0,5);
		$bill = substr($tp_db,5,$len);	
		
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
		
		$cnt=strlen($Country_details->phonecode);
		
		$phone=substr($contact,$cnt);
		
		$contact1='+'.$Country_details->phonecode.'-'.$phone;

		/*******************Configuration**********************/
		if($Gifting_enviornment_flag==0){
			$type=1;
		} else if($Gifting_enviornment_flag==1){
			$type=2;
		}
		
		$thirdparty_details = $this->Igain_model->Fetch_thirdparty_details($type);
		
		$base_url = $thirdparty_details->base_url;
		$client_key = $thirdparty_details->client_key;
		$client_secret1 = $thirdparty_details->client_secret1;
		
		$Authorization1 = $client_key.':'.$client_secret1;
		
		$Api_url = $base_url.'orders';
		$Authorization = base64_encode($Authorization1);
		/*****************Configuration************************/
		
		$productId=strip_tags($this->input->post('pId'));
		$Voucher_name=strip_tags($this->input->post('product_name'));
		$product_image=strip_tags($this->input->post('product_image'));
		$Voucher_price=strip_tags($this->input->post('Voucher_price'));
		$qty=strip_tags($this->input->post('qty'));
		$voucher_currency=strip_tags($this->input->post('currency'));

		$Quantity=$qty;

		$Purchase_amount=$Voucher_price*$qty;
	
		if($Purchase_amount > 0)
		{
			$Total_points =  $Purchase_amount * $Redemptionratio;
		    $Redemptionratio = $Redemptionratio;
			
			$Billing_price_in_points_tier = $Total_points * $Tier_redemption_ratio;
			if($Total_points != $Billing_price_in_points_tier)
			{
				$Total_points = $Billing_price_in_points_tier;
				$Redemptionratio = $Tier_redemption_ratio;
			}
			$Current_redeem_points = $Total_points;
			
			$Total_balance = ($data["Enroll_details"]->Total_balance-$data["Enroll_details"]->Debit_points);
			
			if(($Current_redeem_points<=$Total_balance) && ($Gift_payment_balance >= $Purchase_amount))
			{
				$order_input = array("product_id"=>$productId,"denomination"=>$Voucher_price,"quantity"=>$Quantity,"id"=>$bill);
				$post_field = json_encode($order_input);
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL =>$Api_url,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_POSTFIELDS =>$post_field,
				 CURLOPT_HTTPHEADER => array("Authorization:Basic $Authorization","Content-Type: application/json"),
				));
				$response = curl_exec($curl);

				curl_close($curl);
			
				$voucher_codes=array();
				$pin_codes=array();
				$claimUrl=array();
				$expires_at=array();
				
				$place_order_response  = json_decode($response,true);
				
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
					"Response"=>$response,
					"Creacted_date"=>$lv_date_time,
					"PO_number"=>$place_order_response['reference_number'],
					"source"=>"TheReward"
				);
				
				$poNumber = $place_order_response['reference_number'];
				$Order_no = $place_order_response['id'];
				
				$resultplaceOrder = $this->Redemption_Model->Insert_eVouchar_placeOrder_response($insertPOData);
				
				$order_amount = $place_order_response['amount'];
				$order_discount = $place_order_response['discount'];
				
				if($place_order_response['status'] == 'DELIVERED')
				{									
					foreach($place_order_response['vouchers'] as $value2)
					{										
						//$voucher_codes[] = $value2['code'];
						$pin_codes[] = $value2['pin_code'];
						$claimUrl[] = $value2['claim_url'];
						$expires_at[] = $value2['expires_at'];

						$Total_points1=$Total_points/$Quantity;
						$Gift_pointsArray[] = $Total_points / $Quantity;
						
						$Paid_amount = $Total_points1 / $Redemptionratio;
						
						$Gift_paymentArray[] = $Total_points1 / $Redemptionratio;
						if($value2['card_number'] == "undefined" || $value2['card_number'] =="")
						{
							$Vcode = $value2['claim_url'];
							$voucher_codes[] = $value2['claim_url'];
						}
						else
						{
							$Vcode = $value2['card_number'];
							$voucher_codes[] = $value2['card_number'];
						}
						$Insert_trasaction_data = array(
						
							'Company_id' => $data['Company_id'],
							'Enrollement_id' => $data['enroll'],			
							'Trans_type' =>10,
							'Purchase_amount' => $Voucher_price,
							'Redeem_points' => $Total_points1,
							'Redeem_amount' => $Paid_amount,
							'Quantity' =>1,
							'Remarks' =>'Gift Voucher Redeem',
							'remark2' =>'TheReward Gift Catalogue',
							'Trans_date' =>$lv_date_time,
							'Bill_no' =>$bill,
							'Manual_billno' =>$poNumber,
							'Order_no' =>$Order_no,
							'Card_id' =>$data['Card_id'],
							'Seller' =>$Seller_id,
							'Seller_name' =>$Seller_name,
							'Create_user_id' =>$data['enroll'],
							'Voucher_status' =>296,
							'Delivery_method' =>29,
							'Item_code' => $productId,
							'Item_name' => $Voucher_name,				
							'Voucher_no' =>$Vcode,								
							'Cost_payable_partner' =>number_format($Purchase_amount,2),
							'Merchandize_Partner_id' => $Partner_id,			
							'Merchandize_Partner_branch' => $Branch_code,
							'Payment_type_id' => 4,
							'Delivery_status' => 'Delivered'
						);

						$result = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($Insert_trasaction_data);	
					}
				}
				if($result)
				{
					$Used_Gift_payment=$order_amount;
					$Used_Gift_points=$Current_redeem_points;	
				
					$Gift_payment_balance=$Gift_payment_balance-$Used_Gift_payment;
					$Gift_point_balance=$Gift_point_balance-$Used_Gift_points;
					
					$updateData=array(
						'Gift_payment_balance'=> $Gift_payment_balance,
						'Gift_point_balance'=> $Gift_point_balance
					);
					
					$company_giftbalance = $this->Igain_model->update_company_giftbalance($updateData,$data['Company_id']);
					
					/************************Update Current balance & Total Redeems*************/
				
						$bill_no = $bill + 1;
						$billno_withyear = $str.$bill_no;
						
						$result4 = $this->Shopping_model->update_billno($Seller_id,$billno_withyear);
						
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
							'product_name' =>$Voucher_name,
							'product_image' =>$product_image,
							'Symbol_of_currency' =>$voucher_currency,
							'Voucher_no' => $voucher_codes,
							'Pin_codes' => $pin_codes,
							'Avialable_balance' => $Avialable_balance,
							'Notification_type' => 'Evoucher Redeem',
							'Template_type' => 'Evoucher_redemption'
						);
					$this->send_notification->send_Notification_email($data['enroll'],$Email_content,$Seller_id,$data['Company_id']);
					
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('cart_success_flag'=> '1','response'=>$response)));
				}
				else    
				{
					$this->output->set_content_type('application/json');
					$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>$response)));
				}
			}
			else 
			{	
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>null)));
			}
		} 
		else 
		{	
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('cart_success_flag'=> '0','response'=>null)));
		}	
	}	
}