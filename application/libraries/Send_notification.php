<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	/* PHPMailer Include files */
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;
		include APPPATH . 'third_party/vendor/autoload.php';
	/* PHPMailer Include files */
	
  class Send_notification {

    public function __construct() {
      $this->CI = &get_instance();
      $this->CI->load->helper('url');
      $this->CI->load->model('Igain_model');
      $this->CI->load->model('Coal_transactions/Coal_Transactions_model');
	  $this->CI->load->model('Api/Merchant_api_model');
    }

    public function send_Notification_email($Enrollment_id, $Email_content, $Seller_id, $Company_id) {
		
      error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
      $Template_type = $Email_content['Template_type'];
      $company_details = $this->CI->Igain_model->get_company_details($Company_id);
      $seller_details = $this->CI->Igain_model->get_enrollment_details($Seller_id);
      $customer_details = $this->CI->Igain_model->get_cust_enrollment_details($Enrollment_id);
      $Comapany_Currency = $company_details->Currency_name;
      $Company_Currency = $company_details->Currency_name;
      $Loyalty_enabled = $company_details->Loyalty_enabled;
      $Member_website = $company_details->Cust_website;
      $Website = $company_details->Website;
      $Date = date("Y-m-d H:i:s");
      $Enrollement_id = $customer_details->Enrollement_id;
      $Tier_name = $customer_details->Tier_name;
      $User_email_id = App_string_decrypt($customer_details->User_email_id);
      $customer_notification = false;
      $Cust_apk_link = $company_details->Cust_apk_link;
      $Cust_ios_link = $company_details->Cust_ios_link;
      $Company_name = $company_details->Company_name;
      $App_folder_name = $company_details->App_folder_name;
      $Notification_send_to_email = $company_details->Notification_send_to_email;
	  $Fcm_access_token = $company_details->Fcm_access_token;
      $Base_url = base_url();
      $Gooogle_Play = $Base_url . 'images/Gooogle_Play.png';
      $iOs_app_store = $Base_url . 'images/iOs_app_store.png';

      $User_id = $customer_details->User_id;
      $Phone_no = App_string_decrypt($customer_details->Phone_no);
      $User_pwd = App_string_decrypt($customer_details->User_pwd);
      $pinno = $customer_details->pinno;
      $Membership_ID = $customer_details->Card_id;
      $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
      $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
	  $seller=$seller_details->Enrollement_id;
      $Current_balance = $customer_details->Current_balance;
      $Blocked_points = $customer_details->Blocked_points;
      $Debit_points = $customer_details->Debit_points;
	  $Fcm_token = $customer_details->Fcm_token;
      $Current_point_balance = $Current_balance - ($Blocked_points + $Debit_points);

		

      if ($Current_point_balance < 0) {
        $Current_point_balance = 0;
      } else {
        $Current_point_balance = $Current_point_balance;
      }
      // echo"<br>---53-Current_point_balance-----".$Current_point_balance."---";
      
      $Get_Record1 = $this->CI->Coal_Transactions_model->get_cust_seller_record($Seller_id, $Enrollment_id);
      foreach ($Get_Record1 as $val) {
        
        $Cust_seller_balance= $val["Cust_seller_balance"];
        $Seller_total_purchase= $val["Seller_total_purchase"];
        $Seller_total_redeem= $val["Seller_total_redeem"];
        $Seller_total_gain_points = $val["Seller_total_gain_points"];
        $Seller_total_topup = $val["Seller_total_topup"];
        $Seller_paid_balance= $val["Seller_paid_balance"];
        $Cust_debit_points = $val["Cust_debit_points"];
        $Cust_block_amt= $val["Cust_block_amt"];
        $Cust_block_points = $val["Cust_block_points"];  
        $Cust_block_amt = $val["Cust_block_amt"];
        $Cust_debit_points = $val["Cust_debit_points"];
       $Cust_prepayment_balance = $val["Cust_prepayment_balance"];
      }
      
      $Cust_seller_balance=round(( $Cust_seller_balance )-( $Cust_block_points + $Cust_debit_points ));

		$Email_template_id =0; 

		// echo"---Template_type--".$Template_type."---<br>";	
		// echo"---User_email_id--".$User_email_id."---<br>";	
      if ($Template_type == "Communication") {
		  
		 
        $Sharing_Content = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $Email_content['Offer_description']);
        $Sharing_Content = str_replace("&nbsp;", "", $Sharing_Content);
        $Sharing_Content = trim($Sharing_Content);
        // $Sharing_Title = urlencode($Email_content['Offer']);
        $Sharing_Title = urlencode($Email_content['Share_description']);
        $Sharing_Content = urlencode($Sharing_Content);
        // $Image_path = urlencode(base_url().'images/comm.jpg');
        // $Share_redirection_link = base_url()."Company_".$Company_id;
        $Share_redirection_link = $Member_website;
        $Communication_id = $Email_content['Communication_id'];
        $Offer = $Email_content['Offer'];
        $Start_date = date("d M Y", strtotime($Email_content['Start_date']));
        $End_date = date("d M Y", strtotime($Email_content['End_date']));
		
		$Voucher_array = $Email_content['Voucher_array'];
		$Voucher_type = $Email_content['Voucher_type'];


        $this->CI->load->model('administration/Administration_model');
        $Offer_details = $this->CI->Administration_model->get_offer_details($Communication_id);
        // print_r($Offer_details);

		$User_notification_id = $Offer_details->id;
			$Image_path = $Offer_details->Share_file_path;
			// $Image_path =$company_details->Company_logo;
			// $Image_path = base_url() . $company_details->Company_logo;
			$Company_logo = base_url() . $company_details->Company_logo;

        /* if($Image_path == "")
          {
          $Image_path=base_url().$company_details->Company_logo;
          }
          else
          {
          $Image_path=$Image_path;
          } 
		*/
		  
		  
		
		 
		//print_r($Email_content);


        if ($seller_details->Super_seller == '1') {
          $subject_line = $company_details->Company_name;
        } else {
          $subject_line = $Merchant_name;
        }
        // $subject = "Latest Communication from " . $subject_line;
        $subject = $Email_content['Offer'];

        ob_start();
        $Cust_apk_link = $company_details->Cust_apk_link;
        $Cust_ios_link = $company_details->Cust_ios_link;

        $facebook = $Email_content['facebook'];
        $twitter = $Email_content['twitter'];
        $googleplus = $Email_content['googleplus'];

        // include './application/libraries/Email_templates/Custom_communication.php';
		
		
		 // echo "---App_folder_name---".$App_folder_name."<br>";
		 
		 
		 
		 
		
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		// include "./$App_folder_name/template/Custom_communication.php";
		include './application/libraries/Email_templates/Custom_communication.php';
		
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Offer_description = $Email_content['Offer_description'];
        $Start_date = $Start_date;
        $End_date = $End_date;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Offer_description', '$Start_date', '$End_date', '$Member_website', '$Company_name','$Logo','$User_notification_id'); //
        $inserts_contents = array($Customer_name, $Offer_description, $Start_date, $End_date, $Member_website, $Company_name,$Logo,$User_notification_id);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        $Offer_description = $html;
		// echo $subject."<br>";
        // echo $html;
        // die; 
		
		
      }
	  if($Template_type == "Send_Vouchers")
	{
		$Communication_id = 0;
		$Email_template_id = 0;
		// $Offer = "Congratulations !!! You have received product voucher from ".$company_details->Company_name;
		$subject = "Congratulations !!! You have received VITS voucher from ".$company_details->Company_name;	
		$Offer = "Congratulations !!! You have received VITS voucher from ".$company_details->Company_name;	
		$Tier_id = $Email_content['Tier_id'];
		ob_start();	
		$First_name = ucwords($customer_details->First_name);
		$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
		
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		
		if($Tier_id == 53) // Club Classic
		{
			include './application/libraries/Email_templates/ClubClassicSendVoucher.php';	
		}
		if($Tier_id == 54) // Club Prime
		{
			include './application/libraries/Email_templates/ClubPrimeSendVoucher.php';	
		}
		if($Tier_id == 55) // Club Select
		{
			include './application/libraries/Email_templates/ClubSelectSendVoucher.php';	
		}
		 		
				
		$body = ob_get_contents();
		ob_end_clean();			
				
		
		/************************************Variable Replace Code******************************/
			$search_variables = array('$Logo','$First_name','$Customer_name','$currency','$Company_name','$Gooogle_Play','$iOs_app_store','$User_email_id','$User_pwd');//
			$inserts_contents = array($Logo,$First_name,$Customer_name,$Symbol_of_currency,$Company_name,$Gooogle_Play,$iOs_app_store,$User_email_id,$User_pwd);
			$html = str_replace($search_variables,$inserts_contents,$body);
		/************************************Variable Replace Code******************************/
		// echo $html;
		// die;
	}
      if($Template_type == "Social_Share_Bonus") {
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		$Email_template_id =50; 
		
		
		
      }
      if($Template_type == "Issue_bonus") {
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		$Email_template_id =7; 
		
		$topup_amt=round($Email_content['topup_amt']);
		$Credit_points=round($Email_content['topup_amt']);
        
		/* $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Bonus Issued from " . $company_details->Company_name;

        ob_start();
        $Cust_apk_link = $company_details->Cust_apk_link;
        $Cust_ios_link = $company_details->Cust_ios_link;
        $Base_url = base_url();

        include './application/libraries/Email_templates/Issue_bonus.php';
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** *
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$topup_amt', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, round($Email_content['topup_amt']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
		
      }
      if ($Template_type == "Redeem") {
		  
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		
		$Email_template_id =27; 
		
       /* $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Redeem Transaction at " . $company_details->Company_name;

        ob_start();
        include './application/libraries/Email_templates/Just_Redeem.php';
        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Redeem_points', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, round($Email_content['Redeem_points']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Loyalty_transaction") {
        // echo"---Loyalty_transaction-----";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Today_date']));
        $subject = "Loyalty Transaction with " . $company_details->Company_name;

        ob_start();
        $GiftCardNo = $Email_content['GiftCardNo'];
        $gift_reedem =  number_format($Email_content['gift_reedem'],2);
        $Redeem_points = $Email_content['Redeem_points'];
        $Quantity = $Email_content['Quantity'];
        $Voucher_discount = number_format($Email_content['Voucher_discount'],2);
        $VoucherNumber = $Email_content['VoucherNumber'];
		
		$PMCODE = explode('-',$Email_content['Promo_code']);
		$Promo_code=$PMCODE[0];
		$promo_points=$PMCODE[1];
		
		
		 // print_r($Email_content);
		 
        include './application/libraries/Email_templates/Loyalty_transaction.php';
		$Email_template_id = 26; 
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
		
		
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Manual_bill_no', '$Purchase_amount', '$Symbol_currency', '$Redeem_points', '$GiftCardNo', '$gift_reedem', '$Balance_to_pay', '$Total_loyalty_points', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Quantity', '$Comapany_Currency', '$Voucher_discount', '$VoucherNumber', '$PromoRedeem_amount', '$Promo_code','$promo_points', '$Redeem_amount', '$Discount_amount'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Manual_bill_no'], number_format($Email_content['Purchase_amount'],2), $Email_content['Symbol_currency'], $Email_content['Redeem_points'], $Email_content['GiftCardNo'], $Email_content['gift_reedem'], number_format($Email_content['Balance_to_pay'],2), round($Email_content['Total_loyalty_points']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Quantity, $Comapany_Currency,$Email_content['Voucher_discount'],$Email_content['VoucherNumber'],$Email_content['PromoRedeem_amount'],$Promo_code,$promo_points,number_format($Email_content['Redeem_amount'],2),number_format($Email_content['Discount_amount'],2));
        // $html = str_replace($search_variables, $inserts_contents, $body);
        $PurchaseTable = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $PurchaseTable;
        // die;
      }
      if ($Template_type == "Pos_loyalty_transaction") {

        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Today_date']));
        $subject = "Loyalty Transaction with " . $company_details->Company_name;

        ob_start();
		
        $GiftCardNo = $Email_content['GiftCardNo'];
        $gift_reedem = $Email_content['gift_reedem'];
        $Redeem_points = $Email_content['Redeem_points'];
        $Quantity = $Email_content['Quantity'];
        include './application/libraries/Email_templates/Pos_loyalty_transaction.php';
 
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Symbol_currency', '$Redeem_points', '$GiftCardNo', '$gift_reedem', '$Balance_to_pay', '$Total_loyalty_points', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Quantity', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Symbol_currency'], $Email_content['Redeem_points'], $Email_content['GiftCardNo'], $Email_content['gift_reedem'], $Email_content['Balance_to_pay'], round($Email_content['Total_loyalty_points']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Quantity, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
        // die;
      }
	if($Template_type == "Pos_Purchase_order")
	{  
		$Communication_id = 0;
		$Offer = $Email_content['Notification_type'];
		$Transaction_date = $Email_content['Transaction_date'];
		$Transaction_date =  date('jS M Y', strtotime($Email_content['Transaction_date']));
		$Symbol_of_currency = $Email_content['Symbol_of_currency'];
		$Orderno = $Email_content['Orderno'];
		$Voucher_array = $Email_content['Voucher_array'];
		$Voucher_status1 = $Email_content['Voucher_status'];
		$Outlet_address = $Email_content['Outlet_address'];
		$POS_bill_no = $Email_content['Pos_billno'];
		$Pos_bill_items = $Email_content['Bill_items'];
		// $In_store_table_no = $Email_content['In_store_table_no'];
		
		 ob_start();
		 
		if($Voucher_status1 == 18)
		{
			$Voucher_status = "Ordered";
		}
		else if($Voucher_status1 == 20)
		{
			$Voucher_status = "Collected";
		}
		$vouchers = "";
			
		if(count($Voucher_array) > 0)
		{
			$vouchers = implode(",",$Voucher_array);
		}  
		
		$Cust_wish_redeem_point = $Email_content['Cust_wish_redeem_point'];
		if($Cust_wish_redeem_point=="")
		{
			$Cust_wish_redeem_point=0;
		}
		$EquiRedeem = number_format($Email_content['EquiRedeem'],2);
		$grand_total = number_format($Email_content['grand_total'],2);
		$subtotal = number_format($Email_content['subtotal'],2);
		$total_loyalty_points = $Email_content['total_loyalty_points'];
		$Update_Current_balance = $Email_content['Update_Current_balance'];
		$Blocked_points = $Email_content['Blocked_points'];
		$Delivery_type = $Email_content['Delivery_type'];
		$DeliveryOutlet = $Email_content['DeliveryOutlet'];
		$mpesa_BillAmount = $Email_content['mpesa_BillAmount'];
		$DiscountAmt = number_format($Email_content['DiscountAmt'],2);
		$VoucherDiscountAmt = number_format($Email_content['VoucherDiscountAmt'],2);
		
		if($Delivery_type == 0)
		{
			$Order_type = "Delivery";
		}
		else if($Delivery_type == 1)
		{
			$Order_type = "Pick-Up";
		}
		else if($Delivery_type == 2)
		{
			$Order_type = "In-Store";
		}
		else
		{
			$Order_type="";
		}
		$delivery_outlet_details = $this->CI->Igain_model->get_enrollment_details($DeliveryOutlet);
		$delivery_outlet = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name;
		$Order_preparation_time = $delivery_outlet_details->Order_preparation_time;
		$Outlet_table_no_flag = $delivery_outlet_details->Table_no_flag;
	
		$Outlet_address1 = (explode(",",$Outlet_address)); 
		
		$Outlet_address_line1 = $Outlet_address1['0'];
		$Outlet_address_line2 = $Outlet_address1['1'];
		$Outlet_address_line3 = $Outlet_address1['2'];
		$Outlet_address_line4 = $Outlet_address1['3'];	
		$Outlet_address_line5 = $Outlet_address1['4'];	
		$Outlet_address_line6 = $Outlet_address1['5'];	
		
		$discountVal = number_format($DiscountAmt + $VoucherDiscountAmt,2);
		// $discountVal = $DiscountAmt;
		$Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		
		$banner_image = $Base_url.'images/transaction.png';	
		$subject =$Offer;
		
		include "./$App_folder_name/template/Pos_Purchase_order.php";
		
		$Email_template_id = 4;
        
		$body = ob_get_contents();
        ob_end_clean();
		
		/************************************Variable Replace Code******************************/
        $search_variables = array('$First_name','$Logo', '$Customer_name', '$Transaction_date', '$Order_type', '$delivery_outlet', '$Orderno', '$POS_bill_no', '$Symbol_of_currency', '$subtotal', '$Company_Currency', '$total_loyalty_points', '$grand_total', '$discountVal', '$Cust_wish_redeem_point', '$EquiRedeem', '$Current_point_balance', '$vouchers'); // 
		
        $inserts_contents = array($First_name,$Logo,$Customer_name, $Transaction_date, $Order_type, $delivery_outlet, $Orderno, $POS_bill_no, $Symbol_of_currency, $subtotal, $Company_Currency, $total_loyalty_points, $grand_total, $discountVal, $Cust_wish_redeem_point, $EquiRedeem, $Current_point_balance, $vouchers);
        // $html = str_replace($search_variables, $inserts_contents, $body);
        /************************************Variable Replace Code******************************/
	}
	if($Template_type == "3rd_Party_Purchase_order")
	{  
		$Communication_id = 0;
		$Offer = $Email_content['Notification_type'];
		$Transaction_date = $Email_content['Transaction_date'];
		$Transaction_date =  date('jS M Y', strtotime($Email_content['Transaction_date']));
		$Symbol_of_currency = $Email_content['Symbol_of_currency'];
		$Orderno = $Email_content['Orderno'];
		$Voucher_array = $Email_content['Voucher_array'];
		$Voucher_status1 = $Email_content['Voucher_status'];
		$Outlet_address = $Email_content['Outlet_address'];
		$POS_bill_no = $Email_content['Pos_billno'];
		$Pos_bill_items = $Email_content['Bill_items'];
		// $In_store_table_no = $Email_content['In_store_table_no'];
		
		 ob_start();
		 
		if($Voucher_status1 == 18)
		{
			$Voucher_status = "Ordered";
		}
		else if($Voucher_status1 == 20)
		{
			$Voucher_status = "Collected";
		}
		$vouchers = "";
			
		if(count($Voucher_array) > 0)
		{
			$vouchers = implode(",",$Voucher_array);
		}  
		
		$Cust_wish_redeem_point = $Email_content['Cust_wish_redeem_point'];
		if($Cust_wish_redeem_point=="")
		{
			$Cust_wish_redeem_point=0;
		}
		$EquiRedeem = number_format($Email_content['EquiRedeem'],2);
		$grand_total = number_format($Email_content['grand_total'],2);
		$subtotal = number_format($Email_content['subtotal'],2);
		$total_loyalty_points = $Email_content['total_loyalty_points'];
		$Update_Current_balance = $Email_content['Update_Current_balance'];
		$Blocked_points = $Email_content['Blocked_points'];
		$Delivery_type = $Email_content['Delivery_type'];
		$DeliveryOutlet = $Email_content['DeliveryOutlet'];
		$mpesa_BillAmount = number_format($Email_content['mpesa_BillAmount'],2);
		$DiscountAmt = $Email_content['DiscountAmt'];
		$VoucherDiscountAmt = $Email_content['VoucherDiscountAmt'];
		$discountVal = number_format($DiscountAmt + $VoucherDiscountAmt,2);
		if($Delivery_type == 1)
		{
			$Order_type = "Pick-Up";
		}
		else if($Delivery_type == 2)
		{
			$Order_type = "Take Away";
		}
		else if($Delivery_type == 3)
		{
			$Order_type = "Delivery";
		}
		else
		{
			$Order_type="";
		}
		$delivery_outlet_details = $this->CI->Igain_model->get_enrollment_details($DeliveryOutlet);
		$delivery_outlet = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name;
		$Order_preparation_time = $delivery_outlet_details->Order_preparation_time;
		$Outlet_table_no_flag = $delivery_outlet_details->Table_no_flag;
	
		$Outlet_address1 = (explode(",",$Outlet_address)); 
		
		$Outlet_address_line1 = $Outlet_address1['0'];
		$Outlet_address_line2 = $Outlet_address1['1'];
		$Outlet_address_line3 = $Outlet_address1['2'];
		$Outlet_address_line4 = $Outlet_address1['3'];	
		$Outlet_address_line5 = $Outlet_address1['4'];	
		$Outlet_address_line6 = $Outlet_address1['5'];	
		
		$Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		
		$banner_image = $Base_url.'images/transaction.png';	
		$subject =$Offer;
		
		include "./$App_folder_name/template/3rd_Party_Online_Order.php";

        $body = ob_get_contents();
        ob_end_clean();
		
		/************************************Variable Replace Code******************************/
        $search_variables = array('$First_name','$Logo', '$Customer_name', '$Transaction_date', '$Order_type', '$delivery_outlet', '$Orderno', '$POS_bill_no', '$Symbol_of_currency', '$subtotal', '$Company_Currency', '$total_loyalty_points', '$grand_total', '$discountVal', '$Cust_wish_redeem_point', '$EquiRedeem', '$Current_point_balance', '$vouchers'); // 
		
        $inserts_contents = array($First_name,$Logo,$Customer_name, $Transaction_date, $Order_type, $delivery_outlet, $Orderno, $POS_bill_no, $Symbol_of_currency, $subtotal, $Company_Currency, $total_loyalty_points, $grand_total, $discountVal, $Cust_wish_redeem_point, $EquiRedeem, $Current_point_balance, $vouchers);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /************************************Variable Replace Code******************************/
	}
	/**************18-05-2020 nilesh purchase gift card**********************/
	if($Template_type == "Purchase_gift_card") 
	{   
		$Communication_id = 0;
		// $Offer = $Email_content['Notification_type'];
		$Offer = "Thank you for your gift card purchase on ".$Email_content['Outlet_name'];
		$Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
		// $subject = "Gift Card Purchased from ".$company_details->Company_name;
		$subject = "Thank you for your gift card purchase on ".$Email_content['Outlet_name'];
		
		$Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
		$Merchant_name = $seller_details->First_name ." ".$seller_details->Middle_name." ".$seller_details->Last_name;
		// $Customer_name=$Email_content['Gift_card_user'];
		// $User_email_id = $Email_content['Gift_card_Email'];
		$Gift_card_array = $Email_content['Gift_card_array'];
		ob_start(); 
		// include './application/libraries/Email_templates/Purchase_gift_card.php';
		
		include "./$App_folder_name/template/Purchase_gift_card.php";

		$body = ob_get_contents();
		ob_end_clean(); 

		/************************************Variable Replace Code***************************** */
		$search_variables = array('$First_name','$Customer_name','$Merchant_name','$Membership_ID','$Bill_amount','$Symbol_currency','$Valid_till','$Order_no','$Bill_no','$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play','$iOs_app_store','$Comapany_Currency', '$Customer_Email', '$Outlet_name','$Points_Redeemed','$Points_Amount','$Balance_due','$Gift_card_user'); 
		$inserts_contents = array($First_name,$Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Bill_amount'], $Email_content['Symbol_currency'],$Email_content['Valid_till'],$Email_content['Order_no'],$Email_content['Bill_no'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency,$Email_content['Customer_Email'],$Email_content['Outlet_name'],$Email_content['Points_Redeemed'],$Email_content['Points_Amount'],$Email_content['Balance_due'],$Email_content['Gift_card_user']);
		$html = str_replace($search_variables,$inserts_contents,$body);
		/************************************Variable Replace Code***************************** */
		// echo $html; die;
	}
	if($Template_type == "Purchase_gift_card_walking") 
	{   
		$Communication_id = 0;
		// $Offer = $Email_content['Notification_type'];
		$Offer = "Thank you for your gift card purchase on ".$Email_content['Outlet_name'];
		$Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
		// $subject = "Gift Card Purchased from ".$company_details->Company_name;
		$subject = "Thank you for your gift card purchase on ".$Email_content['Outlet_name'];
		
		$Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
		$Merchant_name = $seller_details->First_name ." ".$seller_details->Middle_name." ".$seller_details->Last_name;
		// $Customer_name=$Email_content['Gift_card_user'];
		$User_email_id = $Email_content['Customer_Email'];
		$Gift_card_array = $Email_content['Gift_card_array'];
		ob_start(); 
		// include './application/libraries/Email_templates/Purchase_gift_card.php';
		
		include "./$App_folder_name/template/Purchase_gift_card.php";

		$body = ob_get_contents();
		ob_end_clean(); 

		/************************************Variable Replace Code***************************** */
		$search_variables = array('$First_name','$Customer_name','$Merchant_name','$Membership_ID','$Bill_amount','$Symbol_currency','$Valid_till','$Order_no','$Bill_no','$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play','$iOs_app_store','$Comapany_Currency', '$Customer_Email', '$Outlet_name','$Points_Redeemed','$Points_Amount','$Balance_due','$Gift_card_user'); 
		$inserts_contents = array($First_name,$Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Bill_amount'], $Email_content['Symbol_currency'],$Email_content['Valid_till'],$Email_content['Order_no'],$Email_content['Bill_no'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency,$Email_content['Customer_Email'],$Email_content['Outlet_name'],$Email_content['Points_Redeemed'],$Email_content['Points_Amount'],$Email_content['Balance_due'],$Email_content['Gift_card_user']);
		$html = str_replace($search_variables,$inserts_contents,$body);
		/************************************Variable Replace Code***************************** */
		// echo $html; die;
	}
	/**************18-05-2020 nilesh purchase gift card**********************/

	if($Template_type == "Discount_voucher")
	{ 
		$Communication_id = 0;
		// $Offer = "Congratulations !!! You have recieved discount voucher from ".$Email_content['Outlet_name'];
		$Offer = "Discount Voucher";
		$Symbol_of_currency = $Email_content['Symbol_of_currency'];
		$Transaction_date = $Email_content['Transaction_date'];
		$Transaction_date = date_format($Transaction_date,"jS M Y");
		// $Valid_till = $Email_content["Voucher_validity"]
		$Valid_till =  date('jS M Y', strtotime($Email_content['Voucher_validity']));
		$subject = "Congratulations !!! You have recieved discount voucher from ".$Email_content['Outlet_name'];			
		
		// $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
		ob_start();	
		$Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
		$Reward_percent=$Email_content["Reward_percent"];
		
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		// include "./$App_folder_name/template/DiscountVoucher.php";
		
		include './application/libraries/Email_templates/DiscountVoucher.php';			
		$Email_template_id = 24;
		
		$body = ob_get_contents();
		ob_end_clean();			
				 
		
		/************************************Variable Replace Code******************************/
			$search_variables = array('$First_name','$Customer_name','$Voucher_no','$currency','$reward_amt','$Reward_percent','$Transaction_date','$Valid_till','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Logo');//
			$inserts_contents = array($First_name,$Customer_name,$Email_content["Voucher_no"],$Symbol_of_currency,$Email_content["Reward_amt"],$Reward_percent,$Transaction_date,$Valid_till,$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Logo);
			// $html = str_replace($search_variables,$inserts_contents,$body);
			$PurchaseTable = str_replace($search_variables, $inserts_contents, $body);
		/************************************Variable Replace Code******************************/
		//echo $html;
	}
	if($Template_type == "Product_voucher")
	{
		$Communication_id = 0;
		// $Offer = "Congratulations !!! You have received product voucher from ".$company_details->Company_name;
		// $subject = "Congratulations !!! You have received product voucher from ".$company_details->Company_name;	
		$Brand_name = $Email_content['Brand_name'];
		$Offer = "$Brand_name Voucher";
		$subject = "$Brand_name Voucher";	
		
		$Symbol_of_currency = $Email_content['Symbol_of_currency'];
		$Transaction_date = date("d M Y",strtotime($Email_content['Transaction_date']));		
		
		// $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
		ob_start();	
		$First_name = ucwords($customer_details->First_name);
		$Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
		
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		include "./$App_folder_name/template/ProductVoucher.php";
		
		// include './application/libraries/Email_templates/ProductVoucher.php';			
				
		$body = ob_get_contents();
		ob_end_clean();			
				
		
		/************************************Variable Replace Code******************************/
			$search_variables = array('$Logo','$First_name','$Customer_name','$Voucher_no','$currency','$Description','$Transaction_date','$Valid_till','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Brand_name');//
			$inserts_contents = array($Logo,$First_name,$Customer_name,$Email_content["Voucher_no"],$Symbol_of_currency,$Email_content["Description"],$Transaction_date,$Email_content["Voucher_validity"],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Email_content['Brand_name']);
			$html = str_replace($search_variables,$inserts_contents,$body);
		/************************************Variable Replace Code******************************/
		// echo $html;
	}
    if ($Template_type == "Purchase_cancel") 
	{
        // echo"---Loyalty_transaction-----";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Today_date']));
        $subject = "Debit Transaction with " . $company_details->Company_name;

        ob_start();

        include './application/libraries/Email_templates/Purchase_cancel.php';
		$Email_template_id = 8;
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Bill_no', '$Bill_date', '$Symbol_currency', '$Cancelle_amount', '$Debit_loyalty_points', '$Debit_redeem_points', '$Current_balance', '$Current_debit_points', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency');
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Bill_no'], $Email_content['Bill_date'], $Email_content['Symbol_currency'], $Email_content['Cancelle_amount'], $Email_content['Debit_loyalty_points'], $Email_content['Debit_redeem_points'], $Current_point_balance, $Debit_points, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        // $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
        // die;
    }
      if ($Template_type == "Coalition_purchase_cancel") {
        // echo"---Loyalty_transaction-----";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Today_date']));
        $subject = "Debit Transaction with " . $company_details->Company_name;

        ob_start();

        include './application/libraries/Email_templates/Coalition_purchase_cancel.php';

        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Bill_no', '$Bill_date', '$Symbol_currency', '$Cancelle_amount', '$Debit_loyalty_points', '$Debit_redeem_points', '$Current_balance', '$Current_debit_points', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency','$Cust_seller_balance');
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Bill_no'], $Email_content['Bill_date'], $Email_content['Symbol_currency'], $Email_content['Cancelle_amount'], $Email_content['Debit_loyalty_points'], $Email_content['Debit_redeem_points'], $Current_point_balance, $Debit_points, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency,$Cust_seller_balance);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
        // die;
      }
      
      if ($Template_type == "Refferal_purchase_cancel") {
        // echo"---Loyalty_transaction-----";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Today_date']));
        $subject = "Debit Transaction with " . $company_details->Company_name;

        ob_start();

        include './application/libraries/Email_templates/Refferal_purchase_cancel.php';

        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Bill_no', '$Bill_date', '$Symbol_currency', '$Cancelle_amount', '$Debit_loyalty_points', '$Debit_redeem_points', '$Current_balance', '$Current_debit_points', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency','$Referee_name','$Cust_seller_balance');
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Bill_no'], $Email_content['Bill_date'], $Email_content['Symbol_currency'], $Email_content['Cancelle_amount'], $Email_content['Debit_loyalty_points'], $Email_content['Debit_redeem_points'], $Current_point_balance, $Debit_points, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency,$Email_content['Referee_name'],$Cust_seller_balance);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
        // die;
      }
      
      if ($Template_type == "Publisher_purchased_miles_File") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Todays_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $Todays_date = date("Y-m-d");
        $subject = $Offer;

        $User_email_id = $Email_content['Contact_email_id'];
        $Company_finance_email_id = $Email_content['Company_finance_email_id'];


        ob_start();
        $Customer_name = $Email_content['Publisher_name'];
        include './application/libraries/Email_templates/Publisher_purchased_miles_File.php';
        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Todays_date', '$Currency', '$filename', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Todays_date, $Email_content['Currency'], $Email_content['filename'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
      }
      if ($Template_type == "Assign_Gift_card") {
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		$Email_template_id=28;
		$Customer_namegift=$Email_content['Gift_card_user'];
		$User_email_idgift = $Email_content['Gift_card_Email'];
		
        /* $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Gift Card Issued from " . $company_details->Company_name;
		
		$Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
		// echo"---Customer_name------".$Customer_name."<br>";
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
		$Customer_name=$Email_content['Gift_card_user'];
		$User_email_id = $Email_content['Gift_card_Email'];
		
		
        ob_start();
        include './application/libraries/Email_templates/Assign_Gift_card.php';

        $body = ob_get_contents();
        ob_end_clean();
       
		// echo"---Gift_card_user------".$Email_content['Gift_card_user']."<br>";
		// echo"---Customer_name------".$Customer_name."<br>";
		

        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Symbol_currency', '$GiftCardNo', '$GiftCard_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Symbol_currency'], $Email_content['GiftCardNo'], $Email_content['GiftCard_balance'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
		// echo $html;
      }
      if ($Template_type == "Gift_card_transaction") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		$Email_template_id=29;
		
       /*  $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Your Transaction Details for the Gift Card with " . $company_details->Company_name;
        ob_start();
        include './application/libraries/Email_templates/Gift_card_transaction.php';
        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name; */

        /*         * **********************************Variable Replace Code***************************** *
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Symbol_currency', '$GiftCardNo', '$Redeem_points', '$BalanceToPay', '$GiftCard_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Symbol_currency'], $Email_content['GiftCardNo'], $Email_content['Redeem_points'], $Email_content['BalanceToPay'], $Email_content['GiftCard_balance'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Referral_rule") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        // $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
        $subject = "Referral Campaign  " . $Email_content['Referral_rule'] . "  from " . $company_details->Company_name;

		$Email_template_id=44;

        $Seller_id = $Seller_id;
        $Referral_rule = $Email_content['Referral_rule'];
        $Topup_new_cust = $Email_content['Topup_new_cust'];

        ob_start();
        // include './application/libraries/Email_templates/Referral_rule.php';

        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
        $Merchant_address = App_string_decrypt($seller_details->Current_address);
		
		if($Email_content['Referral_rule']=='Purchase'){
			$Email_content['Topup_new_cust']=0;
		}

        // die;
        /*         * **********************************Variable Replace Code***************************** *
        $search_variables = array('$Customer_name', '$Merchant_name', '$Merchant_address', '$Start_date', '$End_date', '$Top_u_toRefree', '$Topup_new_cust', '$Membership_ID', '$Referral_rule', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $Merchant_address, date("d, M Y", strtotime($Email_content['Start_date'])), date("d, M Y", strtotime($Email_content['End_date'])), $Email_content['Top_u_toRefree'], $Email_content['Topup_new_cust'], $customer_details->Card_id, $Email_content['Referral_rule'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Referral_topup") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        
		$Email_template_id=20;
		
		
		$Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Referral Bonus Issued from " . $company_details->Company_name;
		$Refferral_Customer_name = $Email_content['Customer_name'];
        /* ob_start();
        include './application/libraries/Email_templates/Referral_topup.php';

        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** *
        $search_variables = array('$Customer_name', '$Refferral_Customer_name', '$Merchant_name', '$Membership_ID', '$Current_balance', '$Ref_Topup_amount', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Email_content['Customer_name'], $Merchant_name, $customer_details->Card_id, $Current_point_balance, $Email_content['Ref_Topup_amount'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Referee_topup") {
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Referral Bonus Issued from " . $company_details->Company_name;


		$Email_template_id=46;

       /*  ob_start();
        include './application/libraries/Email_templates/Referee_topup.php';

        $body = ob_get_contents();
        ob_end_clean(); */
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Refferal_Customer_name', '$Membership_ID', '$Current_balance', '$Ref_Topup_amount', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Email_content['Customer_name'], $customer_details->Card_id, $Current_point_balance, $Email_content['Ref_Topup_amount'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*    * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Joining_Bonus") {
        $Communication_id = 0;
		$Email_template_id =2; 
      } 
	  if ($Template_type == "3rd_Party_Joining_Bonus") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($customer_details->joined_date));
        $subject = "Complimentary Bonus Points Issued from " . $company_details->Company_name;

        ob_start();
        include './application/libraries/Email_templates/3rd_Party_Joining_Bonus.php';

        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;


        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Joining_bonus_points', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Joining_bonus_points'], $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
		// echo $html; die;
      }
      if ($Template_type == "Enroll") {
		  
        $Communication_id = 0;
        $Email_template_id =1; 
        $Offer = $Email_content['Notification_type'];
        $Email_content['New_Tier_name'] = $Tier_name;
		
		$myData = array('Company_id' => $company_details->Company_id, 'Enroll_id' => $customer_details->Enrollement_id, 'User_email_id' => App_string_decrypt($customer_details->User_email_id));
		// var_dump($myData);
		$Pwddata = base64_encode(json_encode($myData));
		$Pwddata_URL = $Base_url. "index.php/Login/Setpassword?Pwd_data=" . $Pwddata;
		$PwddataLink = "<a href='" . $Pwddata_URL . "' target='_blank' style='color:#000;'>Click here to Set Password</a>";
		
		
      }
      if ($Template_type == "User_Enroll") {
		  
        $Communication_id = 0;
        $Email_template_id =19; 
      
		
      }
	  if ($Template_type == "3rd_Party_Enroll") 
	  {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        // $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
        // $subject = "Referral Bonus Issued from ".$company_details->Company_name;			

        ob_start();
        $Customer_name = ucwords($customer_details->First_name). ' ' .ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
        $User_id = $customer_details->User_id;
        $User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        $subject = $Customer_name . ", Welcome to " . $company_details->Company_name . " Loyalty Program";
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		
        // include './application/libraries/Email_templates/3rd_Party_Enroll.php';
		include "./$App_folder_name/template/3rd_Party_Enroll.php";

        $body = ob_get_contents();
        ob_end_clean();
		
		$myData = array('Company_id' => $company_details->Company_id, 'Enroll_id' => $customer_details->Enrollement_id, 'User_email_id' => App_string_decrypt($customer_details->User_email_id));
		// var_dump($myData);
		$Pwddata = base64_encode(json_encode($myData));
		$Pwddata_URL = $Base_url. "index.php/Login/Setpassword?Pwd_data=" . $Pwddata;
		$PwddataLink = "<a href='" . $Pwddata_URL . "' target='_blank' style='color:#000;'>Click here to Set Password</a>";

        /************************************Variable Replace Code***************************** */
        $search_variables = array('$First_name','$Customer_name', '$Merchant_name', '$Membership_ID', '$Enrolled_under', '$User_email_id', '$Phone_no', '$User_pwd','$Pwdlink', '$pinno', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Logo'); //
        $inserts_contents = array($First_name, $Customer_name, $Merchant_name, $Membership_ID, $Company_name, $User_email_id, $Phone_no, $User_pwd,$PwddataLink, $pinno, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Logo);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /************************************Variable Replace Code***************************** */
		
		// echo $html; die;
      }
      if ($Template_type == "Assign_membershipid") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        // $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
        // $subject = "Referral Bonus Issued from ".$company_details->Company_name;			

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $User_id = $customer_details->User_id;
        $User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        $subject = "You have Assigned Membership ID Successfuly in  " . $company_details->Company_name . "'s Loyalty Program.";

        include './application/libraries/Email_templates/Assign_membershipid.php';

        $body = ob_get_contents();
        ob_end_clean();


        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$User_email_id', '$Phone_no', '$User_pwd', '$pinno', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $Membership_ID, $User_email_id, $Phone_no, $User_pwd, $pinno, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Change_pin" || $Template_type == "Send_pin") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        // $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
        // $subject = "Referral Bonus Issued from ".$company_details->Company_name;			

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $User_id = $customer_details->User_id;
        $User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;
        // $Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;			

        $subject = "Your Request for Pin in Loyalty Application";
        include './application/libraries/Email_templates/Change_send_pin.php';

        $body = ob_get_contents();
        ob_end_clean();


        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Membership_ID', '$User_email_id', '$Phone_no', '$User_pwd', '$pinno', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Membership_ID, $User_email_id, $Phone_no, $User_pwd, $pinno, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Change_password") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        // $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
        // $subject = "Referral Bonus Issued from ".$company_details->Company_name;			

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $User_id = $customer_details->User_id;
        $User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;
        // $Merchant_name = $seller_details->First_name." ".$seller_details->Middle_name." ".$seller_details->Last_name;			

        $subject = "Your Login Credentials in " . $company_details->Company_name . " Loyalty Program";
        include './application/libraries/Email_templates/Change_password.php';

        $body = ob_get_contents();
        ob_end_clean();


        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Membership_ID', '$User_email_id', '$Phone_no', '$User_pwd', '$pinno', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Membership_ID, $User_email_id, $Phone_no, $User_pwd, $pinno, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        /* echo $html;
          die; */
      }
      if ($Template_type == "Forgot_password") {
        $Communication_id = 0;
        $Email_template_id = 0;
        $Offer = $Email_content['Notification_type'];

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $User_id = $customer_details->User_id;
        $User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;

        $subject = "Your Login Credentials in " . $company_details->Company_name . " Loyalty Program";
        include './application/libraries/Email_templates/Forgot_password.php';

        $body = ob_get_contents();
        ob_end_clean();

		$myData = array('Company_id' => $company_details->Company_id, 'Enroll_id' => $customer_details->Enrollement_id, 'User_email_id' => App_string_decrypt($customer_details->User_email_id));
		// var_dump($myData);
		$Pwddata = base64_encode(json_encode($myData));
		$Pwddata_URL = $Base_url. "index.php/Login/Setpassword?Pwd_data=" . $Pwddata;
		$PwddataLink = "<a href='" . $Pwddata_URL . "' target='_blank' style='color:#000;'>Click here to Set Password</a>";
		
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Membership_ID', '$User_email_id', '$Phone_no', '$User_pwd','$Pwdlink', '$pinno', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Membership_ID, $User_email_id, $Phone_no, $User_pwd,$PwddataLink, $pinno, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
        // echo $User_email_id;
        // die; 
      }
      if ($Template_type == "Freebies" || $Template_type == "Enroll_Freebies" || $Template_type == "Tier_Freebies") {//Delhi
        $Communication_id = $Email_content["Company_merchandize_item_code"];
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Congratulations !!! You have recieved free voucher from " . $company_details->Company_name;

        // $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;

        $Offer_link = $Email_content["Offer_link"];
        $Company_id = $company_details->Company_id;



        // $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
        include './application/libraries/Email_templates/Freebies.php';


        $body = ob_get_contents();
        ob_end_clean();


        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchandize_item_name', '$Voucher_no', '$Voucher_status', '$Transaction_date', '$Item_image', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Offer_link'); //
        $inserts_contents = array($Customer_name, $Email_content["Merchandize_item_name"], $Email_content["Voucher_no"], $Email_content["Voucher_status"], $Transaction_date, $Email_content["Item_image"], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Offer_link);
        $html = str_replace($search_variables, $inserts_contents, $body);
        // echo $html;
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Auction") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		
		$Email_template_id =35; 
		
		
       /*  $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Auction Campaign " . $Email_content['Auction_name'] . " of  " . $company_details->Company_name;
		
        // $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;

        // $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
        include './application/libraries/Email_templates/Auction.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Auction_name', '$Auction_description', '$Auction_start_date', '$Auction_end_date', '$Minimum_bid', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Email_content["Auction_name"], $Email_content["Auction_description"], date("d M Y", strtotime($Email_content['Auction_start_date'])), date("d M Y", strtotime($Email_content['Auction_end_date'])), $Email_content["Minimum_bid"], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Auction_winner") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		
		
		
		$Email_template_id =36;
		
		/* 
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = " CONGRATULATIONS!...Our Auction " . $Email_content['Auction_name'] . " WINNER!";

        // $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;

        // $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
        include './application/libraries/Email_templates/Auction_winner.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Auction_name', '$Auction_description', '$Auction_start_date', '$Auction_end_date', '$Minimum_bid', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Email_content["Auction_nam
		$Email_template_id =36;
		
		/* 
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = " CONGRATULATIONS!...Our Auction " . $Email_content['Auction_name'] . " WINNER!";

        // $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;

        // $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
        include './application/libraries/Email_templates/Auction_winner.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Auction_name', '$Auction_description', '$Auction_start_date', '$Auction_end_date', '$Minimum_bid', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Email_content["Auction_name"], $Email_content["Auction_description"], date("d M Y", strtotime($Email_content['Auction_start_date'])), date("d M Y", strtotime($Email_content['Auction_end_date'])), $Email_content["Minimum_bid"], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Auction_winner_cancel") {
       	    
        // include './application/libraries/Email_templates/Auction_winner.php';

		$Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
		
		$Email_template_id =37;
		
		
		/* 
        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Auction_name', '$Auction_description', '$Auction_start_date', '$Auction_end_date', '$Minimum_bid', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Email_content["Auction_name"], $Email_content["Auction_description"], date("d M Y", strtotime($Email_content['Auction_start_date'])), date("d M Y", strtotime($Email_content['Auction_end_date'])), $Email_content["Minimum_bid"], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
		
		
		
      }
      if ($Template_type == "Auction_winner_cancel") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        // $Transaction_date = date("d M Y",strtotime($Email_content['Todays_date']));
        $subject = " Cancellation of Auction " . $Email_content['Auction_name'] . " ";

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Auction_winner_cancel.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Auction_name', '$Bid_value', '$Available_Current_balance', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Email_content["Auction_name"], round($Email_content["Bid_value"]), round($Email_content['Available_Current_balance']), $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Survey_send") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Survey_type = $Email_content['Survey_type'];
        $Survey_id = $Email_content['Survey_id'];

        if ($Survey_type == 1) {
          $Survey_type = 'Feedback Survey';
        } else if ($Survey_type == 2) {
          $Survey_type = 'Service Related Survey';
        } else {
          $Survey_type = 'Product Survey';
        }

        $myData = array('Survey_id' => $Survey_id, 'Company_id' => $company_details->Company_id, 'Enroll_id' => $customer_details->Enrollement_id, 'Card_id' => $customer_details->Card_id);
        var_dump($myData);
        $Survey_data = base64_encode(json_encode($myData));
        // $Survey_URL = base_url()."Company_".$company_details->Company_id."/index.php/Cust_home/getsurveyquestion/?Survey_data=".$Survey_data;

        /* -------Use this After Sync Website---------------------------
          $Survey_URL = $Member_website."index.php/Cust_home/getsurveyquestion/?Survey_data=".$Survey_data;
          $Survey_link = "<a href='".$Survey_URL."' target='_blank' style='color:#000;'>Click here to take a Survey</a>";
          /*-------Use this After Sync Website--------------------------- */

        /* -------Temparary Use--------------------------- */

		/* -------23-03-2020--------------------------- */	
			
				
				$Survey_URL = base_url() . "".$company_details->Domain_name."/index.php/Cust_home/getsurveyquestion/?Survey_data=" . $Survey_data;
				$Survey_link = "<a href='" . $Survey_URL . "' target='_blank' style='color:#000;'>Click here to take a Survey</a>";
			
			
		/* -------23-03-2020--------------------------- */		
		
		
        
        /* -------Temparary Use--------------------------- */

		$Email_template_id=12;
		
		
		/* 
        $subject = " Survey From " . $company_details->Company_name;
		
        ob_start();
		$Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Survey_send.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Survey_name', '$Survey_type', '$Start_date', '$End_date', '$Survey_link', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Email_content["Survey_name"], $Survey_type, date('d M Y', strtotime($Email_content['Start_date'])), date('d M Y', strtotime($Email_content['End_date'])), $Survey_link, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Share_bonus") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("Y-m-d");
        $subject = " Social Share Bonus Issued from " . $company_details->Company_name;


		echo"<br>--Template---Current_point_balance-----".$Current_point_balance."---";

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Share_bonus.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Social_share_points', '$Social_media', '$Current_balance', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Email_content['Social_share_points'], $Email_content['Social_media'], $Current_point_balance, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
		
		echo $html;
		
		
      }
      if ($Template_type == "Redemption_Fulfillment") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("Y-m-d");
        $subject = " Redemption Fullfillment  of our " . $company_details->Company_name;
		
		$Email_template_id=40;

        /* ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Redemption_Fulfillment.php';
	
        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** *
        $search_variables = array('$Customer_name', '$Transaction_date', '$Todays_date', '$Merchandize_item_name', '$evoucher', '$Points', '$Total_points', '$Branch_name', '$Branch_Address', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Transaction_date, $Todays_date, $Email_content['Merchandize_item_name'], $Email_content['evoucher'], $Email_content['Points'], $Email_content['Total_points'], $Email_content['Branch_name'], $Email_content['Branch_Address'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
	  if ($Template_type == "Revenue_Voucher_Fulfillment") 
	  {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("Y-m-d");
        $subject = "Revenue Voucher Fullfillment  of our " . $company_details->Company_name;
		
		$Email_template_id=41;
      }
      if ($Template_type == "Seller_threshold") {
        $content1 = "";
        $content2 = "";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Super_Seller_flag = $Email_content['Super_Seller_flag'];

        if ($Super_Seller_flag == 1) {
          $content1 = "The " . $Comapany_Currency . " Balance of the Outlet <strong>" . $Email_content['Seller_name'] . "</strong> has breached the Threshold balance.";
          $content2 = "Please TOP UP Outlet <strong>" . $Email_content['Seller_name'] . "</strong> balance as early as possible.";
        } else {
          $content1 = "Your " . $Comapany_Currency . " Balance has breached the Threshold balance.<br>
							 Your current balance is <strong>" . $Email_content['Seller_balance'] . "</strong> " . $Comapany_Currency;
          $content2 = "Please get your Balance TOPPED UP from the Company as early as possible.<br>
							 Contact <strong>" . $Email_content['Company_admin'] . "</strong> for more details.";
        }
        $subject = " About Threshold Balance Alert";

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Seller_threshold.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$content1', '$content2', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $content1, $content2, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }

      if ($Template_type == "Trigger Notification") {
		  
        $Communication_id = $Email_content['trigger_id'];
        $Offer = $Email_content['Notification_type'];
        $Trigger_notification_type = $Email_content['Trigger_notification_type'];

		$Email_template_id=45;
		$Trigger_contents="";
        if ($Trigger_notification_type == 1) {//Member  Define
          $Tier_criteria = $Email_content['Tier_criteria'];
          $Cust_done_transaction = $Email_content['Cust_done_transaction'];
          $next_Criteria_value2 = $Email_content['next_Criteria_value2'];
          $new_criteria_val = $Email_content['new_criteria_val'];
          $next_Tier_name = $Email_content['next_Tier_name'];
          $Old_Tier_name = $Email_content['Old_Tier_name'];
		  
          $subject = "Opportunity to upgrade to the next Higher Tier ";
		  
          if ($Tier_criteria == 1) {//Cumulative Spend
		  
            $Trigger_contents = "We are privileged to have you as part of the Program. You are currently in <b>$Old_Tier_name</b> Tier and your current total Purchase amount is <b>$Cust_done_transaction</b> amount till date.<br><br>If you do more than amount of <b>$new_criteria_val</b> purchase, you will be upgraded to the next Higher Tier <b>'$next_Tier_name'</b> automatically. <br><br>The next Higher tier promises you much more privileges and benefits.<br><br>So,  hurry and get going!!";

            /* $Contents= 'Your current total transaction amount is '.$Cust_done_transaction.',<br> 
              To upgrade to the next tier you need total transaction amount '.$next_Criteria_value2.', <br>
              So just do more transactions of '.$new_criteria_val.'  and you upgraded to next tier <b>'.$next_Tier_name.'</b>. You will have more previliges and benefits in the next higher tier '; */
          }
          if ($Tier_criteria == 2) {//Cumulative Number of Transactions
            $Trigger_contents = "We are privileged to have you as part of the Program. You are currently in <b>$Old_Tier_name</b> Tier and you have done <b>$Cust_done_transaction</b> Purchase Transactions till date.<br><br>If you do <b>$new_criteria_val</b> more Purchase transactions, you will be upgraded to the next Higher Tier <b>'$next_Tier_name'</b> automatically. <br><br>The next Higher tier promises you much more privileges and benefits.<br><br>So,  hurry and get going!!";

            /* $Contents='You have done '.$Cust_done_transaction.' transactions in our outlets , <br>
              to upgrade to the next tier you need total '.$next_Criteria_value2.' transactions , <br>So just do more '.$new_criteria_val.' transactions
              and you upgraded to next tier  <b>'.$next_Tier_name.'</b>.You will have more previliges and benefits in the next higher tier'; */
          }
          if ($Tier_criteria == 3) { //Cumulative Points Accumlated
            $Trigger_contents = "We are privileged to have you as part of the Program. You are currently in <b>$Old_Tier_name</b> Tier and you have gained total <b>$Cust_done_transaction</b> loyalty " . $Comapany_Currency . " till date.<br><br>If you gain <b>$new_criteria_val</b> more loyalty " . $Comapany_Currency . ", you will be upgraded to the next Higher Tier <b>'$next_Tier_name'</b> automatically. <br><br>The next Higher tier promises you much more privileges and benefits.<br><br>So,  hurry and get going!!";

            /* $Contents='You have gained total '.$Cust_done_transaction.' loyalty points , <br> 
              to upgrade to the next tier you need total '.$next_Criteria_value2.' loyalty points ,<br>
              So just do more transactions to gain  '.$new_criteria_val.' loyalty points and you upgraded to next tier  <b>'.$next_Tier_name.'</b>.You will have more previliges and benefits in the next higher tier'; */
          }
        }

        if ($Trigger_notification_type == 2) { //Loyalty
          $Till_date = $Email_content['Till_date'];
          $Loyalty_rule = $Email_content['Loyalty_rule'];
          $Loyalty_at_transaction = $Email_content['Loyalty_at_transaction'];
          $subject = "THE MORE YOU PURCHASE the MORE YOU GAIN !";

          $Trigger_contents = "This is to let you know that you will get <b>$Loyalty_at_transaction %</b> of " . $Comapany_Currency . " on Every Purchase you do at our outlets. With more " . $Comapany_Currency . " at your disposal you can redeem more " . $Comapany_Currency . " from the exciting catalogue made available to you.<br><br>So reach out to our nearest outlets and happy purchasing .
				<br><br>Rush and grab this offer!! The loyalty program ends at <b>$Till_date</b>. ";

          /* $Contents= "As per our running <b>$Loyalty_rule</b> loyalty program you will get <b>$Loyalty_at_transaction %</b> off on every transaction.<br>so to grab maximum loyalty points do transactions in our outlet.<br>The loyalty program end at <b>$Till_date</b>."; */
        }

        if ($Trigger_notification_type == 3) {//Auction
          $Auction_name = $Email_content['Auction_name'];
          $Difference = $Email_content['Difference'];
          $Auction_Prize = $Email_content['Auction_Prize'];
          $auction_end_date = $Email_content['auction_end_date'];
          $Bid_date = $Email_content['Bid_date'];
          $Highest_Bid_value = $Email_content['Highest_Bid_value'];

          // $subject = "BID MORE...AUCTION CLOSING SOON !";
          $subject = "Bid more for the Auction and get a chance to WIN!";

          $Trigger_contents = "Thanks for bidding for the Auction <b>'$Auction_name'</b> on <b>$Bid_date</b>.<br><br>Well, the auction is getting over on <b>$auction_end_date</b> i.e. Just <b>$Difference</b> days from today!<br><br>The Current highest BID is <b>$Highest_Bid_value</b>. If you need to be the Highest BIDDER and WIN the <b>$Auction_Prize</b>, we encourage you to BID more.<br><br>So Enjoy the Auction Bidding and have Fun!";
          /*
            $Contents= "You bid for the auction <b>'$Auction_name'</b>, There is <b>$Difference</b> days remainig of that auction,so bid more to get <b>'$Auction_Prize'</b>."; */
        }



       /*  ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Auto_process_Trigger_notification.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** *
        $search_variables = array('$Customer_name', '$Contents', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $Contents, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
      //  echo $html;
        /*         * **********************************Variable Replace Code***************************** */
      
	  }

      if ($Template_type == "Redemption") {
        $Communication_id = 0;

        $Offer = $Email_content['Notification_type'];
        $html = $Email_content['Contents'];
        $subject = $Email_content['subject'];


        // echo"----Redemption--Email Template-<br>";
        /* ob_start();	
          $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
          include './application/libraries/Email_templates/Redemption_Fulfillment.php';

          $body = ob_get_contents();
          ob_end_clean(); */

        /*         * **********************************Variable Replace Code*****************************
          $search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Merchandize_item_name','$evoucher','$Points','$Total_points','$Branch_name','$Branch_Address','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store');//
          $inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Email_content['Merchandize_item_name'],$Email_content['evoucher'],$Email_content['Points'],$Email_content['Total_points'],$Email_content['Branch_name'],$Email_content['Branch_Address'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store);
          $html = str_replace($search_variables,$inserts_contents,$body);
          /************************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Partner_payment") {
        $Communication_id = 0;
      
        $Offer = $Email_content['Notification_type'];
        $html = $Email_content['Redemption_details'];
        $subject = $Email_content['subject'];
        $User_email_id = $Email_content['Partner_email'];
        $Company_admin_email_id = App_string_decrypt($seller_details->User_email_id);
        // echo"---Company_admin_email_id-------".$Company_admin_email_id."--<br>";
      }
      /*
        if($Template_type == "e-Voucher Notification")
        {
        $Communication_id = 0;
        $Offer =$Email_content['Notification_type'];
        $Transaction_date = date("d M Y",strtotime($Email_content['Trans_date']));
        $Todays_date=date("d M Y");
        $subject = "e-Voucher Reminder Notification" ;
        $Total_Redeem_Points=($Email_content['Total_Redeem_Points']);
        if($Email_content['Days']>0)
        {
        $Voucher_contents='Your e-Voucher number <b>'.$Email_content['Voucher_no'].'</b> will get expired in next <b>'.$Email_content['Days'].'</b> days. <br><br>		Please Collect your item from Merchant Outlet.Please find below the details of your Redeemed Item.:<br>';
        }
        else
        {
        if($Total_Redeem_Points!=0)
        {
        $Voucher_contents='Your e-Voucher number <b>'.$Email_content['Voucher_no'].'</b> has been expired. <br>Your Total Redeem Points <b>'.$Total_Redeem_Points.'</b> has been credited into your account.<br>Your Total Current Balance is now <b>'.$Email_content['Avaialble_balance'].'</b> Points.<br>Please find below the details of your Redeemed Item.:';
        }
        else
        {
        $Voucher_contents='Your e-Voucher number <b>'.$Email_content['Voucher_no'].'</b> has been expired.<br><br>Please find below the details of your Redeemed Item.:';
        }
        }
        ob_start();
        $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
        include './application/libraries/Email_templates/evoucher_auto_notification.php';

        $body = ob_get_contents();
        ob_end_clean();

        /*********** Redeemed Item.:<br>';
        }
        else
        {
        if($Total_Redeem_Points!=0)
        {
        $Voucher_contents='Your e-Voucher number <b>'.$Email_content['Voucher_no'].'</b> has been expired. <br>Your Total Redeem Points <b>'.$Total_Redeem_Points.'</b> has been credited into your account.<br>Your Total Current Balance is now <b>'.$Email_content['Avaialble_balance'].'</b> Points.<br>Please find below the details of your Redeemed Item.:';
        }
        else
        {
        $Voucher_contents='Your e-Voucher number <b>'.$Email_content['Voucher_no'].'</b> has been expired.<br><br>Please find below the details of your Redeemed Item.:';
        }
        }
        ob_start();
        $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;
        include './application/libraries/Email_templates/evoucher_auto_notification.php';

        $body = ob_get_contents();
        ob_end_clean();

        /************************************Variable Replace Code*****************************
        $search_variables = array('$Customer_name','$Transaction_date','$Todays_date','$Item_name','$Voucher_no','$Total_Redeem_Points','$Quantity','$Voucher_status','$Branch_name','$Branch_Address','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Voucher_contents');//
        $inserts_contents = array($Customer_name,$Transaction_date,$Todays_date,$Email_content['Item_name'],$Email_content['Voucher_no'],$Total_Redeem_Points,$Email_content['Quantity'],$Email_content['Voucher_status'],$Email_content['Branch_name'],$Email_content['Branch_Address'],$Member_website,$Company_name,$Gooogle_Play,$iOs_app_store,$Voucher_contents);
        $html = str_replace($search_variables,$inserts_contents,$body);

        echo "<br>";
        echo $html;
        echo "<br>";
        /************************************Variable Replace Code*****************************
        $Communication_id = 0;

        } */
      if ($Template_type == "e-Voucher Notification") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("d M Y");
        $subject = "e-Voucher Reminder Notification";
        $Total_Redeem_Points = ($Email_content['Total_Redeem_Points']);
        if ($Email_content['Days'] > 0) {
          $Voucher_contents = 'Your e-Voucher number <b>' . $Email_content['Voucher_no'] . '</b> will get expired in next <b>' . $Email_content['Days'] . '</b> days. <br><br>		Please Collect your item from Merchant Outlet.Please find below the details of your Redeemed Item.:<br>';
        } else {
          if ($Total_Redeem_Points != 0) {
            $Voucher_contents = 'Your e-Voucher number <b>' . $Email_content['Voucher_no'] . '</b> has been expired. <br>Your Total Redeem ' . $Comapany_Currency . ' <b>' . $Total_Redeem_Points . '</b> has been credited into your account.<br>Your Total Current Balance is now <b>' . $Email_content['Avaialble_balance'] . '</b> ' . $Comapany_Currency . '.<br>Please find below the details of your Redeemed Item.:';
          } else {
            $Voucher_contents = 'Your e-Voucher number <b>' . $Email_content['Voucher_no'] . '</b> has been expired.<br><br>Please find below the details of your Redeemed Item.:';
          }
        }
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/evoucher_auto_notification.php';

        $body = ob_get_contents();
        ob_end_clean();

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Transaction_date', '$Todays_date', '$Item_name', '$Voucher_no', '$Total_Redeem_Points', '$Quantity', '$Voucher_status', '$Branch_name', '$Branch_Address', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Voucher_contents'); //
        $inserts_contents = array($Customer_name, $Transaction_date, $Todays_date, $Email_content['Item_name'], $Email_content['Voucher_no'], $Total_Redeem_Points, $Email_content['Quantity'], $Email_content['Voucher_status'], $Email_content['Branch_name'], $Email_content['Branch_Address'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Voucher_contents);
        $html = str_replace($search_variables, $inserts_contents, $body);

      /*   echo "<br>";
        echo $html;
        echo "<br>"; */
        /*         * **********************************Variable Replace Code***************************** */
        $Communication_id = 0;
      }
      /*       * ***************AMIT 20-3-2017******************* */
      if ($Template_type == "Birthday_Reminder") {
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Birthday_Communication = $Email_content['Birthday_Communication'];
		
		// echo $Birthday_Communication;die;
        $Todays_date = date("d M Y");
        $subject = "Wish you a very Happy Birthday !!!";
		$Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
		$Membership_id = $customer_details->Card_id;

		if($Birthday_Communication!='0')
		{
			
			$Email_template_id=0;
			/*         * **********************************Variable Replace Code***************************** */
			$search_variables = array('$Customer_name', '$Todays_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Membership_id'); //
			$inserts_contents = array($Customer_name, $Todays_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store,$Membership_id);
			$html = str_replace($search_variables, $inserts_contents, $Birthday_Communication);
			$Offer_description = $html;
			// $html=$Birthday_Communication;
			
			// echo $Birthday_Communication;die;
		}
		else
		{
			
			$Email_template_id=14;
			
			
			/* ob_start();
			include './application/libraries/Email_templates/Auto_birthday_notification.php';
			$body = ob_get_contents();
			ob_end_clean();

			/***********************************Variable Replace Code***************************** 
			$search_variables = array('$Customer_name', '$Todays_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
			$inserts_contents = array($Customer_name, $Todays_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
			$html = str_replace($search_variables, $inserts_contents, $body); */
		}
		

       /*  echo "<br>";
        echo $html;
        echo "<br>";die; */
        /*         * **********************************Variable Replace Code***************************** */
        // $Communication_id = 0;
      }
      if ($Template_type == "Survey_start_end_notification") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Survey_name = $Email_content['Survey_name'];

        $Start_date = date("d M Y", strtotime($Email_content['Start_date']));
        $End_date = date("d M Y", strtotime($Email_content['End_date']));


        $Survey_id = $Email_content['Survey_id'];
        $myData = array('Survey_id' => $Survey_id, 'Company_id' => $company_details->Company_id, 'Enroll_id' => $customer_details->Enrollement_id);
        $Survey_data = base64_encode(json_encode($myData));
        // $Survey_URL = base_url()."Company_".$company_details->Company_id."/index.php/Cust_home/getsurveyquestion/?Survey_data=".$Survey_data;
        $Survey_URL = $Member_website . "index.php/Cust_home/getsurveyquestion/?Survey_data=" . $Survey_data;
        $Survey_link = "<a href='" . $Survey_URL . "' target='_blank' >Click here to take a Survey</a>";
        if ($Email_content['Survey_start_flag'] == 1) {
          $Contents = '<tr>
				<td style="font-size: 12px; color: black; font-family: Helvetica; text-align: left; width: 50%; line-height: 25px; padding: 5px; border: 1px solid #eee;"><b>Survey Start from:</b></td>
				
				<td style="font-size: 12px; color: black; font-family: Helvetica; text-align: left; width: 50%; line-height: 25px; padding: 5px; border: 1px solid #eee;"><b>' . $Email_content['Survey_start'] . ' day(s) before</b></td>
				</tr>';
        }
        if ($Email_content['Survey_end_flag'] == 1) {
          $Contents = '<tr>
				<td style="font-size: 12px; color: black; font-family: Helvetica; text-align: left; width: 50%; line-height: 25px; padding: 5px; border: 1px solid #eee;"><b>Survey end after:</b></td>
				
				<td style="font-size: 12px; color: black; font-family: Helvetica; text-align: left; width: 50%; line-height: 25px; padding: 5px; border: 1px solid #eee;"><b>' . $Email_content['Survey_end'] . ' day(s)</b></td>
				</tr>';
        }
        $subject = "Survey Reminder Notification of " . $company_details->Company_name;

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Auto_Survey_start_end_notification.php';

        $body = ob_get_contents();
        ob_end_clean();

        /************************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name', '$Todays_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Survey_name', '$Survey_start_flag', '$Survey_start', '$Survey_end_flag', '$Survey_end', '$Start_date', '$End_date', '$Survey_link', '$Contents'); //
        $inserts_contents = array($Customer_name, $Todays_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Email_content['Survey_name'], $Email_content['Survey_start_flag'], $Email_content['Survey_start'], $Email_content['Survey_end_flag'], $Email_content['Survey_end'], $Email_content['Start_date'], $Email_content['End_date'], $Survey_link, $Contents);
        $html = str_replace($search_variables, $inserts_contents, $body);

        echo "<br>";
        echo $html;
        echo "<br>";
        /*         * **********************************Variable Replace Code***************************** */
        $Communication_id = 0;
      }

      if ($Template_type == "Tier_notification") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Todays_date = date("d M Y");
        $subject = "Tier " . $Email_content['Process'] . " in " . $Company_name . " Loyalty Programe";
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;

        if ($Email_content['Process'] == "Upgrade") {
	
			$Email_template_id=47;

          /* $Contents = 'Amazing News!!! You have successfully been upgraded to a new tier.
							You have moved from the ' . $Email_content['Old_Tier_name'] . ' Tier to the ' . $Email_content['New_Tier_name'] . ' Tier in our Tier based Loyalty Program.<br><br>Now you have access to earn more benefits in our Tier based Loyalty Program.Please do transactions to earn more benefits in our Tier based Loyalty Program.
							<br><br>Thank you so much for your loyalty and continued patronage, on our part we will continue to bring you the best of services and offers.
							<br><br>Click Member Website Link to login and begin to explore your new ' . $Email_content['New_Tier_name'] . ' Tier.'; */

          /* $Contents = 'Congratulations!  You were originally in the '. $Email_content['Old_Tier_name'].' Tier in our Loyalty Program, 
            now you have been upgrade  to '. $Email_content['New_Tier_name'].' Tier. <br><br>
            Now you have access to earn more benefits in our Tier based Loyalty Programme.

            <br><br>Please do transactions to earn more benefits in our Tier based Loyalty Programme. '; */
        }
        if ($Email_content['Process'] == "Downgrade") {
         
			$Email_template_id=48;

			// $Contents = 'You have not maintained the criteria for being a ' . $Email_content['Old_Tier_name'] . ' member you have therefore been moved to the ' . $Email_content['New_Tier_name'] . ' Tier.<br><br>To enable you move back to your previous tier, Kindly Visit us and spend to accumulate more points.';

          /*
            $Contents = 'We miss You, you have not maintained the criteria for being a  '. $Email_content['Old_Tier_name'].'  member you have therefore been downgraded to '. $Email_content['New_Tier_name'].'
            <br><br>Is there any problem?  You can send any complaint or comment, and questions too by replying this email and someone will be in touch with you. '; */
        }

       /*  include './application/libraries/Email_templates/Auto_Tier_notification.php';

        $body = ob_get_contents();
        ob_end_clean();

        /*         * **********************************Variable Replace Code***************************** 
        $search_variables = array('$Customer_name', '$Todays_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Contents'); //
        $inserts_contents = array($Customer_name, $Todays_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Contents);
        $html = str_replace($search_variables, $inserts_contents, $body);

        echo "<br>";
        echo $html;
        echo "<br>";
        /*         * **********************************Variable Replace Code***************************** */
        
		
		
		
		
      }

      if ($Template_type == "Points_Expiry") {
		  
		  
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("d M Y");
		
		
		$Email_template_id=13;
		
		$Expired_points=$Email_content['Deduct_balance'];
		$Current_point_balance=$Email_content['Availabel_Current_balance'];
		

        /* 
		$Total_Redeem_Points = ($Email_content['Total_Redeem_Points']);
        if ($Email_content['Days'] > 0) {
          $Contents = 'Thank you for your continued patronage, we appreciate and value your business with us.<br><br>Hurry and exchange your ' . $Email_content['Deduct_balance'] . ' ' . $Comapany_Currency . ' at any of our outlets before they expire in ' . $Email_content['Days'] . ' days.  Please hurry to prevent this from happening.';
          $Img = 'reminder.jpg';
          $subject = "Loyalty Points Expiry Reminder Notification From " . $Company_name;
        } else {
          $Contents = 'I am sorry but a portion of your earned points has expired as you have not redeemed any item from us and you are no longer able to redeem the ' . $Email_content['Deduct_balance'] . ' ' . $Comapany_Currency . ' in your account,your current balance is ' . $Email_content['Availabel_Current_balance'] . ' ' . $Comapany_Currency . '.';
          $Img = 'expiry.jpg';
          $subject = "Loyalty Points Expired Notification From " . $Company_name;
        }
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Auto_points_expiry_notification.php';

        $body = ob_get_contents();
        ob_end_clean();

        /*         * **********************************Variable Replace Code*****************************
        $search_variables = array('$Customer_name', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Contents', '$Img'); //
        $inserts_contents = array($Customer_name, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Contents, $Img);
        $html = str_replace($search_variables, $inserts_contents, $body);

        echo "<br>";
        echo $html;
        echo "<br>"; */
        /*         * **********************************Variable Replace Code***************************** */
        // $Communication_id = 0;
      }
	  
	if ($Template_type == "Points_Expiry_Reminder") {
	  
	  
		$Communication_id = 0;
		$Offer = $Email_content['Notification_type'];
		$Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
		$Todays_date = date("d M Y");
	
	
		$Email_template_id=49;
	
		// $Deduct_balance=$Email_content['Deduct_balance'];
		$Current_point_balance=$Email_content['Availabel_Current_balance'];
	}

      /*       * *********08-05-2017***AMIT*********** */
      if ($Template_type == "SMS_threshold_email") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $subject = "SMS Reminder " . " of our " . $Company_name;
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/SMS_threshold_communication.php';

        $body = ob_get_contents();
        ob_end_clean();

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Company_name'); //
        $inserts_contents = array($Customer_name, $Company_name);
        $html = str_replace($search_variables, $inserts_contents, $body);

        echo "<br>";
        // echo $html;
        echo "<br>";
        /*         * **********************************Variable Replace Code***************************** */
        $Communication_id = 0;
      }


      /* -------------------------Call Center Notification----------------------- */
      if ($Template_type == "Call_Center_Query_Log") 
	  {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = $Email_content['Today_date'];
        $Todays_date = date("Y-m-d");
        $subject = " Call Center Query Log  of our " . $company_details->Company_name;


        ob_start();
        $Customer_name = $Email_content['Cust_name'];
        $Excecative_name = $Email_content['Excecative_name'];
        $Querylog_ticket = $Email_content['Querylog_ticket'];
        $Max_resolution_datetime = $Email_content['Max_resolution_datetime'];
        $Excecative_email = $Email_content['Excecative_email'];
        $Priority_name = $Email_content['Priority_name'];
        $Excecative_contact_no = $Email_content['Excecative_contact_no'];
        $Query_detail = $Email_content['Query_detail'];
        // $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
        // include './application/libraries/Email_templates/Call_center_query_log.php';
		
		$Email_template_id=43;
		
        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Transaction_date', '$Todays_date', '$Excecative_name', '$Querylog_ticket', '$Max_resolution_datetime', '$Excecative_email', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store');
        $inserts_contents = array($Customer_name, $Transaction_date, $Todays_date, $Excecative_name, $Querylog_ticket, $Max_resolution_datetime, $Excecative_email, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        // $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Call_Center_Query_close") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Todays_date = date("Y-m-d");
        $subject = " Call Center Query close  of our " . $company_details->Company_name;

        ob_start();
        $Customer_name = $Email_content['Cust_name'];
        $Excecative_name = $Email_content['Excecative_name'];
        $Querylog_ticket = $Email_content['Querylog_ticket'];
        $Query_type = $Email_content['Query_type'];
        $Log_date = $Email_content['Log_date'];
        $Close_datetime = $Email_content['Close_datetime'];
        $Excecative_email = $Email_content['Excecative_email'];
        // $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
        // include './application/libraries/Email_templates/Call_center_query_close.php';
		
		$Email_template_id=42;
		
        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Log_date', '$Excecative_name', '$Querylog_ticket', '$Query_type', '$Close_datetime', '$Excecative_email', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store');
        $inserts_contents = array($Customer_name, $Log_date, $Excecative_name, $Querylog_ticket, $Query_type, $Close_datetime, $Excecative_email, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        // $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      /*       * **********************Call_Center_Query_Escalatione_********************* */
      if ($Template_type == "Call_Center_Query_Escalatione") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Todays_date = date("Y-m-d");
        $subject = "Call Center Query Escalatione  of our " . $company_details->Company_name;

        ob_start();
        $User_name = $Email_content['user_name'];
        $Querylog_ticket = $Email_content['Querylog_ticket'];
        $Membership_id = $Email_content['Membership_id'];
        $Cust_name = $Email_content['Customer_name'];
        $Query_details = $Email_content['Query_details'];
        $escalted_from_user_name = $Email_content['escalted_from_user_name'];

        // $Customer_name = $customer_details->First_name.' '.$customer_details->Last_name;	
        // include './application/libraries/Email_templates/Auto_Call_center_query_escalation.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$User_name', '$Querylog_ticket', '$Membership_id', '$Cust_name', '$Query_details', '$escalted_from_user_name', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store');
        $inserts_contents = array($User_name, $Querylog_ticket, $Membership_id, $Cust_name, $Query_details, $escalted_from_user_name, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */

        $cll_center_notification = array(
            'Company_id' => $Company_id,
            'Seller_id' => $Seller_id,
            'Call_center_user_id' => $Enrollement_id,
            'Communication_id' => $Communication_id,
            'User_email_id' => $User_email_id,
            'Offer' => $Offer,
            'Offer_description' => $html,
            'Open_flag' => '0',
            'Date' => $Date,
            'Active_flag' => 1
        );
        $customer_notification = $this->CI->Igain_model->insert_call_center_notification($cll_center_notification);
      }
      if ($Template_type == "Purchase_item_status") {
        
			$Communication_id = 0;
			$Email_template_id=39;
		
        if ($Email_content['Notification_type'] == 'Shipped') {
          $Notification_type = 'Shipped';
          $subject = " Your " . $company_details->Company_name . " Order #" . $Email_content['Order_no'] . " has been SHIPPED";
        } else if ($Email_content['Notification_type'] == 'Delivered') {
          $Notification_type = 'Delivered';
          $subject = " Your " . $company_details->Company_name . " Order #" . $Email_content['Order_no'] . " has been DELIVERED";
        } else if ($Email_content['Notification_type'] == 'Cancel') {
          $Notification_type = 'Cancel';
          $subject = " Your " . $company_details->Company_name . " Order #" . $Email_content['Order_no'] . " has been CANCELLED";
        } else if ($Email_content['Notification_type'] == 'Return Initiated') {
          $Notification_type = 'Return Initiated';
          $subject = " Your " . $company_details->Company_name . " Order #" . $Email_content['Order_no'] . " RETURN has been initiated ";
        } else if ($Email_content['Notification_type'] == 'Returned') {
          $Notification_type = 'Returned';
          $subject = " Your " . $company_details->Company_name . " Order #" . $Email_content['Order_no'] . " has been RETURNED";
        } else if ($Email_content['Notification_type'] == 'Accepted') {
          $Notification_type = 'Accepted';
          $subject = " Your " . $company_details->Company_name . " Order #" . $Email_content['Order_no'] . " has been ACCEPTED";
        }
        // $Offer =$Notification_type;
        $Offer = $subject;
		
		$Order_status=$Notification_type;
		
		
		// $item_status_subject = $subject;

        $Voucher_status = $Email_content['Voucher_status'];
        if ($Voucher_status == 18) {
          $voucherStatus = 'Ordered';
        } elseif ($Voucher_status == 19) {
          $voucherStatus = 'Shipped';
        } elseif ($Voucher_status == 20) {
          $voucherStatus = 'Delivered';
        } elseif ($Voucher_status == 21) {
          $voucherStatus = 'Cancel';
        } elseif ($Voucher_status == 22) {
          $voucherStatus = 'Return Initiated';
        } elseif ($Voucher_status == 23) {
          $voucherStatus = 'Returned';
        } elseif ($Voucher_status == 23) {
          $voucherStatus = 'Returned';
        } elseif ($Voucher_status == 111) {
          $voucherStatus = 'Accepted';
        }
        // echo"----Credit_points-----".$Email_content['Credit_points']."--<br>";
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("Y-m-d");
        $Todays_date = date("d M Y", strtotime($Todays_date));

		$Email_template_id=39;

       /* ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Purchase_item_status.php';
        
		

        $body = ob_get_contents();
        ob_end_clean();
		
		
        /*         * **********************************Variable Replace Code******************************
			$search_variables = array('$Customer_name', '$Transaction_date', '$Todays_date', '$Merchandize_item_name', '$evoucher', '$Purchase_amount', '$Redeem_points', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Notification_type', '$Voucher_status', '$Symbol_of_currency', '$Order_no', '$Credit_points', '$Current_balance', '$Comapany_Currency'); //
			$inserts_contents = array($Customer_name, $Transaction_date, $Todays_date, $Email_content['Merchandize_item_name'], $Email_content['evoucher'], $Email_content['Purchase_amount'], $Email_content['Redeem_points'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Notification_type, $voucherStatus, $Email_content['Symbol_of_currency'], $Email_content['Order_no'], $Email_content['Credit_points'], $Current_point_balance, $Comapany_Currency);
			$Order_status_tbl = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        
		
		 //Cancel
		if($Voucher_status==21) 
		{ 
			$Order_status_tbl = 'In view of the Order that you have cancelled, '.$Email_content['Credit_points'].' '.$Comapany_Currency.' have been Credited into your account by the Company.<br><br> 
			Your Current Loyalty Account balance is '.$Current_point_balance.' '.$Comapany_Currency.'. Below are the details of the transaction which was cancelled:<br><br>';
		} 
		else if($Voucher_status==22) 
		{
			//'Return Initiated' 
			$Order_status_tbl = 'We are in receipt of your request for Return of the Item(s). Below are the details of the Item(s) you would like to return:<br><br>';
			
		
		} 
		else if($Voucher_status== 23) 
		{ 
	
			//'Returned' 
			$Order_status_tbl = 'Below are the Item(s) that have been Returned.<br><br>';
			
		
		}
		else if($Voucher_status== 19) 
		{ 
			//'Shipped'  
			$Order_status_tbl = 'Thank you for Purchasing from our online Catalogue.<br><br>
			Your item(s) have been Shipped.<br><br>';
		}
		else if($Voucher_status== 20) 
		{ 
			//Delivered
		 
			$Order_status_tbl = ' Thank you for your recent purchase from our online Catalogue.<br><br>
			Your item(s) have been Delivered.<br><br>';
		
		}
		else if($Voucher_status== 111) 
		{ 
			//Delivered
		 
			$Order_status_tbl = ' Thank you for your recent purchase from our online Catalogue.<br><br>
			Your item(s) have been Accepted.<br><br>';
		
		}  
		// echo"<br><br>----Order_status_tbl-------".$Order_status_tbl;
		
        // die;
		
      }
      if ($Template_type == "Purchase_Return_Initiated") {
        $Communication_id = 0;

        if ($Email_content['Notification_type'] == 'Return Initiated') {
          $Notification_type = 'Return Initiated';
        } else if ($Email_content['Notification_type'] == 'Returned') {
          $Notification_type = 'Returned';
        }
        $Offer = $Notification_type;

        $Voucher_status = $Email_content['Voucher_status'];

        // echo"----Credit_points-----".$Email_content['Credit_points']."--<br>";
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("Y-m-d");
        $Todays_date = date("d M Y", strtotime($Todays_date));
        // $subject =" Purchase Items ".$Notification_type." of our ".$company_details->Company_name;	
        $subject = "Order #" . $Email_content['Order_no'] . " RETURN has been initiated ";

        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Partner_name = $Email_content['Partner_name'];
        $User_email_id = $Email_content['Partner_email'];
        $Seller_email = $Email_content['Seller_email'];


        include './application/libraries/Email_templates/Purchase_return_initiated.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Partner_name', '$Transaction_date', '$Todays_date', '$Merchandize_item_name', '$evoucher', '$Purchase_amount', '$Redeem_points', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Notification_type', '$Voucher_status', '$Symbol_of_currency', '$Order_no', '$Credit_points'); //
        $inserts_contents = array($Customer_name, $Partner_name, $Transaction_date, $Todays_date, $Email_content['Merchandize_item_name'], $Email_content['evoucher'], $Email_content['Purchase_amount'], $Email_content['Redeem_points'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Notification_type, $Email_content['Voucher_status'], $Email_content['Symbol_of_currency'], $Email_content['Order_no'], $Email_content['Credit_points']);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
        // die;
      }
      if ($Template_type == "Purchase_loyalty_bonus_points") {
        $Communication_id = 0;
        $Offer = $Email_content['Offer_name'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Transaction_date']));
        $Todays_date = date("d M Y");
        // $subject =$Email_content['Offer_name'];
        $subject = "You have Received " . $Email_content['Loyalty_pts'] . " Points ";


        // var_dump($Email_content);
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Purchase_loyalty_bonus_points.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Transaction_date', '$Todays_date', '$Offer_name', '$Item_name', '$Item_code', '$Orderno', '$Free_qty', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Loyalty_pts', '$Current_balance', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Transaction_date, $Todays_date, $Email_content['Offer_name'], $Email_content['Item_name'], $Email_content['Item_code'], $Email_content['Orderno'], $Email_content['Free_qty'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Email_content['Loyalty_pts'], $Current_point_balance, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo "<br>";
        // echo $html; 
      }
	  if($Template_type == "Update_online_order_status") 
	  {
		$Communication_id = 0;;
		$Offer = $Email_content['Notification_type'];
		$html = $Email_content['Update_details'];
		$subject = $Email_content['Notification_type']; 
      }
	  if($Template_type == "Customer_redeem_request") 
	  {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $subject = $Email_content['Notification_type'];
        $Confirmation_code = $Email_content['Confirmation_code'];
        $Redeem_points = $Email_content['Redeem_points'];
        $Symbol_currency = $Email_content['Symbol_currency'];
        $Equivalent_amount = $Email_content['Equivalent_amount'];
		$Bill_no = $Email_content['Bill_no'];
        $Bill_amount = $Email_content['Bill_amount'];
        $Outlet_name = $Email_content['Outlet_name'];
		
		
		// $Redeem_request_data = array('Enrollement_id' => $Enrollement_id, 'Seller_id' => $seller, 'Company_id' => $Company_id, 'Confirmation_code' => $Confirmation_code);
		 
		$Redeem_request_data = array('Enrollement_id' => $Enrollement_id, 'Seller_id' => $seller, 'Company_id' => $Company_id, 'Confirmation_code' => $Confirmation_code, 'Pos_bill_no' => $Bill_no, 'Pos_bill_amount' => $Bill_amount);
		
        $RedeemRequestData = base64_encode(json_encode($Redeem_request_data));
		
		$Confirmation_URL = base_url().$App_folder_name."/index.php/API/?RequestData=" . $RedeemRequestData;
        $Confirmation_link = "<button style='background-color: #4c4c4c; border: none; color: white; padding: 10px 27px; text-decoration: none; cursor: pointer; text-align:left; font-size: 18px;'><a href='" . $Confirmation_URL . "' target='_blank'  style='color:#ffffff;'><b>Confirm</b></a></button>";
		
		/*$Confirmation_URL = base_url()."index.php/Api/API/?RequestData=" . $RedeemRequestData;
        $Confirmation_link = "<button style='background-color: #fab900; border: none; color: white; padding: 10px 27px; text-decoration: none; cursor: pointer;'><a href='" . $Confirmation_URL . "' target='_blank'  style='color:#000;'> Click to Confirm</a></button>"; */
		
		$Decline_URL = base_url().$App_folder_name."/index.php/API/Decline/?RequestData=" . $RedeemRequestData;
        $Decline_link = "<button style='background-color: #4c4c4c; border: none; color: white; padding: 10px 27px; text-decoration: none; cursor: pointer; text-align:left; font-size: 18px;'><a href='" . $Decline_URL . "' target='_blank'  style='color:#ffffff;'><b>Decline</b></a></button>";
		
        ob_start();
        $Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
        $First_name = ucwords($customer_details->First_name);
        $User_id = $customer_details->User_id;
		$User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		
        // $subject = "Your Request for Pin in Loyalty Application";
        // include './application/libraries/Email_templates/Customer_redeem_request.php';
        // include './application/libraries/Email_templates/3rd_Party_Customer_redeem_request.php';
		include "./$App_folder_name/template/Redeem_request.php";

        $body = ob_get_contents();
        ob_end_clean();


        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name','$Merchant_name','$Membership_ID','$Enrollement_id','$seller','Company_id','$Current_point_balance','$Comapany_Currency','$Base_url','$Confirmation_link','$Decline_link','$Confirmation_code','$Redeem_points','$Symbol_currency','$Equivalent_amount','$Bill_no','$Bill_amount','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Logo','$Outlet_name','$First_name');
        $inserts_contents = array($Customer_name,$Merchant_name,$Membership_ID,$Enrollement_id,$seller,$Company_id,$Current_point_balance,$Comapany_Currency,$Base_url,$Confirmation_link,$Decline_link,$Confirmation_code,$Redeem_points,$Symbol_currency,$Equivalent_amount,$Bill_no,$Bill_amount,$Member_website,$Company_name, $Gooogle_Play, $iOs_app_store, $Logo, $Outlet_name, $First_name);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /***********************************Variable Replace Code******************************/
      } 
	  if($Template_type == "3rd_Party_Customer_redeem_request") 
	  { 
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $subject = $Email_content['Notification_type'];
        $Confirmation_code = $Email_content['Confirmation_code'];
        $Redeem_points = $Email_content['Redeem_points'];
        $Symbol_currency = $Email_content['Symbol_currency'];
        $Equivalent_amount = $Email_content['Equivalent_amount'];
		$Bill_no = $Email_content['Bill_no'];
        $Bill_amount = $Email_content['Bill_amount'];
        $Outlet_name = $Email_content['Outlet_name'];
		
		
		// $Redeem_request_data = array('Enrollement_id' => $Enrollement_id, 'Seller_id' => $seller, 'Company_id' => $Company_id, 'Confirmation_code' => $Confirmation_code);
		 
		$Redeem_request_data = array('Enrollement_id' => $Enrollement_id, 'Seller_id' => $seller, 'Company_id' => $Company_id, 'Confirmation_code' => $Confirmation_code, 'Pos_bill_no' => $Bill_no, 'Pos_bill_amount' => $Bill_amount);
		
        $RedeemRequestData = base64_encode(json_encode($Redeem_request_data));
		
		$Confirmation_URL = base_url().$App_folder_name."/index.php/API/?RequestData=" . $RedeemRequestData;
        $Confirmation_link = "<button style='background-color: #4c4c4c; border: none; color: white; padding: 10px 27px; text-decoration: none; cursor: pointer; text-align:left; font-size: 18px;'><a href='" . $Confirmation_URL . "' target='_blank'  style='color:#ffffff;'><b>Confirm</b></a></button>";
		
		/*$Confirmation_URL = base_url()."index.php/Api/API/?RequestData=" . $RedeemRequestData;
        $Confirmation_link = "<button style='background-color: #fab900; border: none; color: white; padding: 10px 27px; text-decoration: none; cursor: pointer;'><a href='" . $Confirmation_URL . "' target='_blank'  style='color:#000;'> Click to Confirm</a></button>"; */
		
		$Decline_URL = base_url().$App_folder_name."/index.php/API/Decline/?RequestData=" . $RedeemRequestData;
        $Decline_link = "<button style='background-color: #4c4c4c; border: none; color: white; padding: 10px 27px; text-decoration: none; cursor: pointer; text-align:left; font-size: 18px;'><a href='" . $Decline_URL . "' target='_blank'  style='color:#ffffff;'><b>Decline</b></a></button>";
		
        ob_start();
		$Customer_name = ucwords($customer_details->First_name).' '.ucwords($customer_details->Last_name);
		$First_name = ucwords($customer_details->First_name);
        $User_id = $customer_details->User_id;
		$User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
        $pinno = $customer_details->pinno;
        $Membership_ID = $customer_details->Card_id;
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
		
        // $subject = "Your Request for Pin in Loyalty Application";
        // include './application/libraries/Email_templates/3rd_Party_Customer_redeem_request.php';
		include "./$App_folder_name/template/Redeem_request.php";
		
        $body = ob_get_contents();
        ob_end_clean();


        /***********************************Variable Replace Code******************************/
        $search_variables = array('$First_name','$Outlet_name','$Customer_name','$Merchant_name','$Membership_ID','$Enrollement_id','$seller','Company_id','$Current_point_balance','$Comapany_Currency','$Base_url','$Confirmation_link','$Decline_link','$Confirmation_code','$Redeem_points','$Symbol_currency','$Equivalent_amount','$Bill_no','$Bill_amount','$Member_website','$Company_name','$Gooogle_Play','$iOs_app_store','$Logo');
        $inserts_contents = array($First_name,$Outlet_name,$Customer_name,$Merchant_name,$Membership_ID,$Enrollement_id,$seller,$Company_id,$Current_point_balance,$Comapany_Currency,$Base_url,$Confirmation_link,$Decline_link,$Confirmation_code,$Redeem_points,$Symbol_currency,$Equivalent_amount,$Bill_no,$Bill_amount,$Member_website,$Company_name, $Gooogle_Play, $iOs_app_store,$Logo);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /***********************************Variable Replace Code******************************/
		// echo $html; die;
      }
      if ($Template_type == "Online_booking_confirmed") {// Online Service Booking Confirmed
        $Communication_id = 0;
        // echo"----Freebies-----<br>";
        $Offer = $Email_content['Notification_type'];
        $subject = " Your Service Appointment Booked Confirmed. ";
        $User_email_id = $Email_content["Email_Id"];
        // $Item_image= $Base_url.'Merchandize_images/original/'.$Email_content["Item_image"];
        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;


        // $subject = $Customer_name.", Welcome to ".$company_details->Company_name." Loyalty Program";		    
        include './application/libraries/Email_templates/Online_booking_confirmed.php';

        $body = ob_get_contents();
        ob_end_clean();

        $Pickup_flag = $Email_content["Pickup_flag"];
        if ($Pickup_flag == 1) {
          $Pickup_flag = 'Yes';
        } else {
          $Pickup_flag = 'No';
        }
        // echo"------Status----".$Email_content["Status"]."---<br>";
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Service_center', '$Create_date', '$Appointment_time', '$Pickup_flag', '$Membership_ID', '$Vehicle_no', '$Phone_no', '$Email_Id', '$Status', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Email_content['Customer_name'], $Merchant_name, date('d-M-Y', strtotime($Email_content["Date_Appointment"])), $Email_content["Appointment_time"], $Pickup_flag, $Email_content["Membership_id"], $Email_content["Vehicle_number"], $Email_content["Contact_number"], $Email_content["Email_Id"], $Email_content["Status"], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
      }

      if ($Template_type == "Bulk_Evoucher_Update") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Trans_date']));
        $Todays_date = date("Y-m-d");
        $subject = " eVoucher Status Updation of our " . $company_details->Company_name;


        ob_start();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        include './application/libraries/Email_templates/Bulk_Evoucher_Update.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Transaction_date', '$Todays_date', '$Merchandize_item_name', '$evoucher', '$Points', '$Total_points', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Quantity', '$Issued_Quantity', '$Used_Quantity'); //
        $inserts_contents = array($Customer_name, $Transaction_date, $Todays_date, $Email_content['Merchandize_item_name'], $Email_content['evoucher'], $Email_content['Points'], $Email_content['Total_points'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Email_content['Quantity'], $Email_content['Issued_Quantity'], $Email_content['Used_Quantity']);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Reconsolation_Error_File") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today = date("d M Y", strtotime($Email_content['Todays_date']));
        $Todays_date = date("Y-m-d");
        $subject = $Offer;

        $User_email_id = $Email_content['Contact_email_id'];
        $error_file_path = $Email_content['error_file_path'];


        ob_start();
        $Customer_name = $Email_content['Publisher_name'];
        include './application/libraries/Email_templates/Reconsolation_Error_File.php';

        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$today', '$Todays_date', '$filename', '$Total_Number_Rows_Processed', '$Rows_Processed_Successfully', '$Rows_with_Errors', '$error_file_path', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $today, $Todays_date, $Email_content['filename'], $Email_content['Total_Number_Rows_Processed'], $Email_content['Rows_Processed_Successfully'], $Email_content['Rows_with_Errors'], $Email_content['error_file_path'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
      }
      if ($Template_type == "Merchant_Error_Annexure_billing_File") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today = date("d M Y", strtotime($Email_content['Todays_date']));
        // $Todays_date=date("Y-m-d");
        $subject = $Offer;

        $User_email_id = $Email_content['Seller_email_id'];
        $Company_finance_email_id = $Email_content['Company_finance_email_id'];


        ob_start();
        $Customer_name = $Email_content['Seller_name'];

        $billing_bill_no = $Email_content['billing_bill_no'];
        $total_grand_amt = $Email_content['total_grand_amt'];

        // echo"---billing_bill_no---notification--".$billing_bill_no."---<br>";
        // echo"---total_grand_amt--notification---".$total_grand_amt."---<br>";


        include './application/libraries/Email_templates/Merchant_Error_Annexure_billing_File.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name', '$today', '$Todays_date', '$filename', '$billing_bill_no', '$total_grand_amt', '$Symbol_currency', '$Total_Number_Rows_Processed', '$Rows_Processed_Successfully', '$Rows_with_Errors', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $today, $today, $Email_content['filename'], $Email_content['billing_bill_no'], $Email_content['total_grand_amt'], $Email_content['Symbol_currency'], $Email_content['Total_Number_Rows_Processed'], $Email_content['Rows_Processed_Successfully'], $Email_content['Rows_with_Errors'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code******************************/
        // echo $html;
      } 
	  if ($Template_type == "Merchant_Credit_Transaction_Error_File") 
	  {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today = date("d M Y", strtotime($Email_content['Todays_date']));
        // $Todays_date=date("Y-m-d");
        $subject = $Offer;

        $User_email_id = App_string_decrypt($Email_content['Seller_email_id']);
        $Company_finance_email_id = $Email_content['Company_finance_email_id'];


        ob_start();
        $Customer_name = $Email_content['Seller_name'];

        $billing_bill_no = $Email_content['billing_bill_no'];
        $total_grand_amt = $Email_content['total_grand_amt'];

        // echo"---billing_bill_no---notification--".$billing_bill_no."---<br>";
        // echo"---total_grand_amt--notification---".$total_grand_amt."---<br>";


        include './application/libraries/Email_templates/Merchant_Credit_Transaction_Error_File.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name', '$today', '$Todays_date', '$filename', '$billing_bill_no', '$total_grand_amt', '$Symbol_currency', '$Total_Number_Rows_Processed', '$Rows_Processed_Successfully', '$Rows_with_Errors', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $today, $today, $Email_content['filename'], $Email_content['billing_bill_no'], $Email_content['total_grand_amt'], $Email_content['Symbol_currency'], $Email_content['Total_Number_Rows_Processed'], $Email_content['Rows_Processed_Successfully'], $Email_content['Rows_with_Errors'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code******************************/
        // echo $html;
      }
	if ($Template_type == "Saas_company_billing") 
	{
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today = date("d M Y", strtotime($Email_content['Todays_date']));
		$Todays_date=date("Y-m-d");
        $subject = $Offer;

        $User_email_id = $Email_content['Payment_email'];
		
        ob_start();
        $Customer_name = $Email_content['Seller_name'];
        

        include './application/libraries/Email_templates/Saas_company_billing.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name','$Application_name','$License','$Company_name'); //
        $inserts_contents = array($Customer_name,$Email_content['Application_name'],$Email_content['License'],$Email_content['Company_name']);
        $html = str_replace($search_variables, $inserts_contents, $body);
		$Company_name = '';
        /**********************************Variable Replace Code******************************/
        // echo $html;
    }
	if ($Template_type == "E_gifting_catalogue_billing") 
	{
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today = date("d M Y", strtotime($Email_content['Todays_date']));
		$Todays_date=date("Y-m-d");
        $subject = $Offer;

        $User_email_id = $Email_content['Payment_email'];
		
        ob_start();
        $Customer_name = $Email_content['Seller_name'];

        include './application/libraries/Email_templates/E_gifting_catalogue_billing.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name','$Application_name','$Company_name'); //
        $inserts_contents = array($Customer_name,$Email_content['Application_name'],$Email_content['Company_name']);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code******************************/
        // echo $html;
    } 
	if($Template_type == "Debit_transaction_invoice") 
	{ 
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today = date("d M Y", strtotime($Email_content['Todays_date']));
        // $Todays_date=date("Y-m-d");
        $subject = $Offer;

        // $User_email_id = $Email_content['Seller_email_id'];
        $User_email_id = $Email_content['Company_finance_email_id'];
        $Merchant_email_id = $Email_content['Seller_email_id'];


        ob_start();
        // $Customer_name = $Email_content['Seller_name'];
        $Customer_name = $Email_content['Finance_user_name'];

        $billing_bill_no = $Email_content['billing_bill_no'];
        $total_grand_amt = $Email_content['total_grand_amt'];

        include './application/libraries/Email_templates/Debit_transaction_invoice.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name', '$today', '$Todays_date', '$filename', '$billing_bill_no', '$total_grand_amt', '$Symbol_currency', '$Total_Number_Rows_Processed', '$Rows_Processed_Successfully', '$Rows_with_Errors','$From_bill_date', '$To_bill_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store'); //
        $inserts_contents = array($Customer_name, $today, $today, $Email_content['filename'], $Email_content['billing_bill_no'], $Email_content['total_grand_amt'], $Email_content['Symbol_currency'], $Email_content['Total_Number_Rows_Processed'], $Email_content['Rows_Processed_Successfully'], $Email_content['Rows_with_Errors'], $Email_content['From_bill_date'], $Email_content['To_bill_date'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code******************************/
       // echo $html;
    } 
	if($Template_type == "Debit_trans_settlement") 
	{ 
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today=date("Y-m-d H:i:s", strtotime($Email_content['Today_date']));
        $subject = $Offer;
        $User_email_id = $Email_content['Seller_email_id'];
        $Company_finance_email_id = $Email_content['Company_finance_email_id'];
        ob_start();
       
        include './application/libraries/Email_templates/Debit_trans_settlement.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name', '$today', '$Invoice_no', '$Invoice_date','$From_bill_date','$To_bill_date', '$Invoice_amount', '$Settlement_amount', '$Remaining_amount', '$Status', '$Symbol_currency', '$Paid_by', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store','$Till_settlement'); 
        $inserts_contents = array($Customer_name, $today, $Email_content['Invoice_no'], $Email_content['Invoice_date'], $Email_content['From_bill_date'],$Email_content['To_bill_date'], $Email_content['Invoice_amount'],$Email_content['Settlement_amount'],$Email_content['Remaining_amount'],$Email_content['Status'],$Email_content['Symbol_currency'],$Email_content['Paid_by'],$Member_website, $Company_name, $Gooogle_Play, $iOs_app_store,$Email_content['Till_settlement']);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code******************************/
        // echo $html;
    }
	if($Template_type == "Loyalty_transaction_settlement") 
	{ 
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $today=date("Y-m-d H:i:s", strtotime($Email_content['Today_date']));
        $subject = $Offer;
        $User_email_id = $Email_content['Seller_email_id'];
        $Company_finance_email_id = $Email_content['Company_finance_email_id'];
        ob_start();
       
        include './application/libraries/Email_templates/Loyalty_transaction_settlement.php';
        $body = ob_get_contents();
        ob_end_clean();
        /***********************************Variable Replace Code******************************/
        $search_variables = array('$Customer_name', '$today', '$Invoice_no', '$Invoice_date','$From_bill_date','$To_bill_date', '$Invoice_amount', '$Settlement_amount', '$Remaining_amount', '$Status', '$Symbol_currency', '$Paid_by', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store','$Till_settlement'); 
        $inserts_contents = array($Customer_name, $today, $Email_content['Invoice_no'], $Email_content['Invoice_date'], $Email_content['From_bill_date'],$Email_content['To_bill_date'], $Email_content['Invoice_amount'],$Email_content['Settlement_amount'],$Email_content['Remaining_amount'],$Email_content['Status'],$Email_content['Symbol_currency'],$Email_content['Paid_by'],$Member_website, $Company_name, $Gooogle_Play, $iOs_app_store,$Email_content['Till_settlement']);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code******************************/
        // echo $html;
    }
      if ($Template_type == "Reconsolation_customer_update_status") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Todays_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = $Offer;

        // $User_email_id =$Email_content['Seller_email_id']; 
        // $Company_finance_email_id =$Email_content['Company_finance_email_id']; 


        ob_start();


        include './application/libraries/Email_templates/Reconsolation_customer_update_status.php';
        $body = ob_get_contents();
        ob_end_clean();
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Todays_date', '$Publisher_name', '$Currency', '$Status', '$Purchased_miles', '$Current_balance', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Todays_date, $Email_content['Publisher_name'], $Email_content['Currency'], $Email_content['Status'], $Email_content['Purchased_miles'], $Current_point_balance, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
        // echo $html;
      }

		if($Template_type == "Saas_company_registration") 
	{ 
        $Communication_id = 0;
        $subject = $Email_content['Notification_type'];
        $Company_primary_email_id = $Email_content['Company_primary_email_id'];
        $User_email_id = $Email_content['Company_primary_email_id'];
        $Company_primary_contact_person = $Email_content['Company_primary_contact_person'];
        
        $User_pwd = $Email_content['User_pwd'];
		$Domain_name = $Email_content['Domain_name'];
        $Business_name = $Email_content['Company_name'];
        $Company_name = 'iGainspark SaaS Loyalty';
        $Seller_licences_limit = $Email_content['Seller_licences_limit'];
        $Notification_No = $Email_content['Notification_No'];
       $Company_License = $Email_content['Company_License'];
		$company_details->Company_primary_email_id = 'no-reply@igainspark.com';
        ob_start();
        
		if($Notification_No==1)
		{
			 include './application/libraries/Email_templates/Saas_company_registration1.php';
			 
			 
			 $body = ob_get_contents();
			ob_end_clean();
			/***********************************Variable Replace Code******************************/
			$search_variables = array('$Company_primary_contact_person','$Company_primary_email_id','$User_pwd','$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store','Domain_name','Company_name','$Company_License','$Business_name'); //
			$inserts_contents = array($Company_primary_contact_person,  $Company_primary_email_id, $User_pwd,  $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store,$Domain_name,$Company_name,$Company_License,$Business_name);
			$html = str_replace($search_variables, $inserts_contents, $body);
			/**********************************Variable Replace Code******************************/
		}
		else
		{
			$Joining_bonus_points = $Email_content['Joining_bonus_points'];
			$Redemptionratio = $Email_content['Redemptionratio'];
			$Currency_name = $Email_content['Currency_name'];
			$Loyalty_Rule = $Email_content['Loyalty_Rule'];
			$Loyalty_name = $Email_content['Loyalty_name'];
			$Coverted_pts = number_format(($Email_content['Coverted_pts']),2);
			$Refferral_points = $Email_content['Refferral_points'];
			$Loyalty_at_transaction = $Email_content['Loyalty_at_transaction'];
			$Outlet_tbl = $Email_content['Outlet_tbl'];
			
			 include './application/libraries/Email_templates/Saas_company_registration2.php';
			 
			 $body = ob_get_contents();
			ob_end_clean();
			/***********************************Variable Replace Code******************************/
			$search_variables = array('$Company_primary_contact_person','$Company_primary_email_id','$User_pwd','$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store','Domain_name','$Company_name','$Loyalty_name','$Joining_bonus_points','$Redemptionratio','$Currency_name','$Loyalty_Rule','$Coverted_pts','$Refferral_points','$Loyalty_at_transaction','$Outlet_tbl','$Company_License','$Business_name'); //
			$inserts_contents = array($Company_primary_contact_person,  $Company_primary_email_id, $User_pwd,  $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store,$Domain_name,$Company_name,$Loyalty_name,$Joining_bonus_points,$Redemptionratio,$Currency_name,$Loyalty_Rule,$Coverted_pts,$Refferral_points,$Loyalty_at_transaction,$Outlet_tbl,$Company_License,$Business_name);
			$html = str_replace($search_variables, $inserts_contents, $body);
			/**********************************Variable Replace Code******************************/
		}
       
		
        
       // echo $html;
	   // die;
    } 
	
	
		if($Template_type == "Saas_company_email_verification") 
	{ 
        $Communication_id = 0;
        $subject = $Email_content['Notification_type'];
        $User_email_id = $Email_content['email'];
        $Verification_code = $Email_content['Verification_code'];
		$company_details->Company_primary_email_id = 'no-reply@igainspark.com';
        ob_start();
        
			 include './application/libraries/Email_templates/Saas_company_email_verification.php';
			 
			 
			 $body = ob_get_contents();
			ob_end_clean();
			/***********************************Variable Replace Code******************************/
			$search_variables = array('$Company_primary_contact_person','$email','$Verification_code'); //
			$inserts_contents = array($Company_primary_contact_person,  $email,$Verification_code );
			$html = str_replace($search_variables, $inserts_contents, $body);
			/**********************************Variable Replace Code******************************/
		
		
       
		
        
       // echo $html;
	   // die;
    } 
	
	
		if($Template_type == "Reminder_saas_expiry") 
	{ 
        $Communication_id = 0;
        $subject = $Email_content['Notification_type'];
        $Company_primary_email_id = $Email_content['Company_primary_email_id'];
        $User_email_id = $Email_content['Company_primary_email_id'];
        $Company_primary_contact_person = $Email_content['Company_primary_contact_person'];
        
       $Company_name = $Email_content['Company_name'];
        $num_days = $Email_content['num_days'];
		
        ob_start();
        include './application/libraries/Email_templates/Reminder_saas_expiry.php';
		
       
		 $body = ob_get_contents();
			ob_end_clean();
			/*********************Variable Replace Code******************************/
			$search_variables = array('$Company_primary_contact_person','$Company_primary_email_id','$User_pwd','$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store','Domain_name','$Company_name','$Loyalty_name','$Joining_bonus_points','$Redemptionratio','$Currency_name','$Loyalty_Rule','$Coverted_pts','$Refferral_points','$Loyalty_at_transaction','$Outlet_tbl','$Company_License','$num_days'); //
			$inserts_contents = array($Company_primary_contact_person,  $Company_primary_email_id, $User_pwd,  $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store,$Domain_name,$Company_name,$Loyalty_name,$Joining_bonus_points,$Redemptionratio,$Currency_name,$Loyalty_Rule,$Coverted_pts,$Refferral_points,$Loyalty_at_transaction,$Outlet_tbl,$Company_License,$num_days);
			$html = str_replace($search_variables, $inserts_contents, $body);
        
       echo $html;
	   die;
    } 
	
	if ($Template_type == "Meal_Top_Up") 
	{
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Current_Meal_balance = $Email_content['Current_Meal_balance'];
        $MealTopUp = $Email_content['MealTopUp'];
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
        $subject = "You have been issued Meal Topup of ".$MealTopUp." ".$Comapany_Currency."." ;

        ob_start();
        include "./$App_folder_name/template/Meal_Top_Up.php";

        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        


        /********************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Membership_ID', '$MealTopUp', '$Company_name','$Comapany_Currency','$Current_Meal_balance','$Logo'); //
        $inserts_contents = array($Customer_name, $customer_details->Card_id, $MealTopUp,$Company_name, $Comapany_Currency, $Current_Meal_balance, $Logo);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code*****************************/
		//echo $html; //die;
    }
	
	
	if ($Template_type == "Regenerated_tokens") 
	{
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];       
		$Logo = $Base_url.$App_folder_name."/assets/images/logo.png";
        $subject = $Email_content['Notification_type'];

        ob_start();
        include "./application/libraries/Email_templates/Regenerated_tokens.php";

        $body = ob_get_contents();
        ob_end_clean();
		$User_email_id=$Email_content['User_email_id'];
		$Customer_name=$Email_content['Customer_name'];
       
        $Generated_Date=date('Y-m-d H:i:s');
        /********************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Staging_refresh_token', '$Staging_access_token', '$Production_refresh_token','$Production_access_token','$Generated_Date'); //
        $inserts_contents = array($Customer_name, $Email_content['Staging_refresh_token'], $Email_content['Staging_access_token'], $Email_content['Production_refresh_token'], $Email_content['Production_access_token'], $Generated_Date);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /**********************************Variable Replace Code*****************************/
		//echo $html; //die;
    }
       
	if($Template_type == "Survey_rewards")
        {
			$Communication_id=0;
			$Offer = $Email_content['Notification_type'];	

			$Email_template_id=22;	

		}
      /* -------------------------Insert Notification----------------------- */
	  // echo"---Template_type-2-".$Template_type."---<br>";
	  // echo"---Enrollement_id-2-".$Enrollement_id."---<br>";
	  // echo"---User_id-2-".$customer_details->User_id ."---<br>";
	  // echo"---User_email_id-".$User_email_id."---<br>";
	  
	   // echo"---Email_template_id--2490---".$Email_template_id."---<br>";
	   // echo"---Notification_send_to_email---".$Notification_send_to_email."---<br>";
	   // echo"---User_id---".$customer_details->User_id."---<br>";
	   
		if($Email_template_id==0){
	  
			  $Offer_description1="";
			  
			  if($Offer_description){
				  $Offer_description1=$Offer_description;
			  }
			  else{
				  $Offer_description1="";
			  }
			  if ($Enrollement_id != 0 && $customer_details->User_id == 1 && $Template_type != "Enroll_Freebies" && $Template_type != "Purchase_Return_Initiated") {
				  
				   // $User_email_id = App_string_encrypt($customer_details->User_email_id);
				  
				$cust_notification = array(
					'Company_id' => $Company_id,
					'Seller_id' => $Seller_id,
					'Customer_id' => $Enrollement_id,
					'Communication_id' => $Communication_id,
					'User_email_id' => $User_email_id,
					'Offer' => $Offer,
					'Offer_description' => $html,
					'Offer_description1' => $Offer_description1,
					'Open_flag' => '0',
					'Date' => $Date,
					'Active_flag' => 1
				);
				$customer_notification = $this->CI->Igain_model->insert_customer_notification($cust_notification);
				// echo"-Communication--customer_notification---".$this->CI->db->last_query()."---<br>";
				if ($Template_type == "Communication") {
					
					// echo"-Communication--customer_notification---".$customer_notification."---<br>";
					// echo"-Communication--html---".$html."---<br>";
					
					
				  $new_html = str_replace("#User_notification_id", $customer_notification, $html);
				  $post_data = array
					  (
					  // 'Offer_description' => $new_html, 
					  'Offer_description' => $Offer_description1, 
					  'Offer_description1' => $Offer_description1
				  );
				  $Update_customer_notification = $this->CI->Igain_model->update_customer_notification($customer_notification, $Company_id, $Enrollement_id, $post_data);
				  
				  // echo"-Communication--Update_customer_notification---".$this->CI->db->last_query()."---<br>";
				  
				  // $html = $new_html;
				  $html = $Offer_description1;
				}
				
			  }
			  if ($Enrollement_id == 0 && $Template_type == "Assign_Gift_card" && $Email_content['Walkin_customer'] == 1) {
				   // $User_email_id = App_string_encrypt($customer_details->User_email_id);
				$cust_notification = array(
					'Company_id' => $Company_id,
					'Seller_id' => $Seller_id,
					'Customer_id' => 0,
					'Communication_id' => 0,
					'User_email_id' => $User_email_id,
					'Offer' => $Offer,
					'Offer_description' => $html,
					'Offer_description1' => $Offer_description1,
					'Open_flag' => '0',
					'Date' => $Date,
					'Active_flag' => 1
				);
				$customer_notification = $this->CI->Igain_model->insert_customer_notification($cust_notification);      
			  }

			  /* -------------------------Insert Notification----------------------- */

			  //**************************Email Fuction Code*****************************
			  
						if($Fcm_access_token != Null && $Fcm_token != Null)
						{
							$url = "https://fcm.googleapis.com/fcm/send";
							$api_key = $Fcm_access_token;
							$To = $Fcm_token;	
							
							/* $notifData = ['title'=>$Company_name,'body'=>$subject,'click_action'=>$customer_notification];
							
							$notifBody = ['notification'=>$notifData,'to'=> $To];
										
							$notifBodyReq = json_encode($notifBody); */
							
							$input_data = array("id"=>$customer_notification,"redirect_to"=>"ReadNotification");
							$notification_data = array("title"=>$Company_name,"body"=>$subject);

							$input_notification = array("to"=>$Fcm_token,"data"=>$input_data,"notification"=>$notification_data);
							$notifBodyReq = json_encode($input_notification);
							
							$curl = curl_init();
							
							curl_setopt_array($curl, array(
							  CURLOPT_URL => $url,
							  CURLOPT_POST => true,
							  CURLOPT_POSTFIELDS => $notifBodyReq,  
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_HTTPHEADER => array('Authorization:key='.$api_key,'Content-Type: application/json')
							));
							$response =curl_exec($curl);
							$data = json_decode($response,true);
							//echo $data;
							curl_close($curl);
						}
			  
			  /*   PHPMailer start */		
					
						
						//PHPMailer Object
						$mail = new PHPMailer(true); //Argument true in constructor enables exceptions
						// $mail->SMTPDebug = 1;                               // Enable verbose debug output
						$mail->isSMTP();                                      // Set mailer to use SMTP
						// $mail->Host = 'Igainspark-com.mail.protection.outlook.com';  // Specify main and backup SMTP servers smtp.office365.com Igainspark-com.mail.protection.outlook.com
						
						$mail->SMTPAuth = true;                               // Enable SMTP authentication
						// $mail->Username = 'no-reply@igainspark.com';                 // SMTP username
						
						// $mail->Password = 'Gaf70488';                           // SMTP password
						
						$mail->SMTPSecure = 'tls';             // Enable TLS encryption, `ssl` also accepted
						
						
						if($Company_id==47)//VITS
						{
							$mail->Host = 'mail.vitspassport.com';
							$mail->From = 'noreply@vitspassport.com';
							$mail->Username = 'noreply@vitspassport.com';     
							$mail->Password = 'loyalty@stack2023';  
							$mail->Port = 587; 
						}
						else
						{
							$mail->Host = 'mail.miraclecartes.com';
							$mail->From = 'no-reply@miraclecartes.com';
							$mail->Username = 'no-reply@miraclecartes.com';                 // SMTP username
							$mail->Password = '8u8IV)?r?V_U';                           // SMTP password
							$mail->Port = 25; 
						}
						$mail->SMTPOptions = array(					
							'ssl' => array(
								'verify_peer' => false,
								'verify_peer_name' => false,
								'allow_self_signed' => true
							)
						);
						
						// $mail->From = 'no-reply@igainspark.com';
						// $mail->From = 'no-reply@miraclecartes.com';
						// $mail->FromName = 'Mailer';
						
						
						if($Company_name){
							$mail->FromName = $Company_name;
						} else {
							$mail->FromName ='iGainspark SaaS Loyalty';
						}
						
						
						
						
						
						if ($Template_type == "Saas_company_billing" || $Template_type ==  "E_gifting_catalogue_billing") {
							
							  $accounts_email = "accounts@igainspark.com";
							  $mail->From = 'accounts@igainspark.com';
							  $mail->addBCC('rakesh@miraclecartes.com');
							  // $this->CI->email->from($accounts_email);
							  
						  }else{
							  
							// $this->CI->email->from($company_details->Company_primary_email_id);
						  }
						  
						  // $this->CI->email->to($User_email_id);
						  
							$mail->addAddress($User_email_id, $Customer_name);
						  
						  if ($Template_type == "Saas_company_registration") {
							
							$mail->addBCC('rakesh@miraclecartes.com');
							
							
						  }
						  if ($Template_type == "Partner_payment") {
							
							// $this->CI->email->cc(array($Company_admin_email_id));
							
							$mail->addCC(array($Company_admin_email_id));
							
						  }
						  if ($Template_type == "Purchase_Return_Initiated") {
							// $this->CI->email->bcc($Seller_email);
							$mail->addBCC($Seller_email);	
						  }
						  if ($Template_type == "Publisher_purchased_miles_File") {


							// $this->CI->email->cc(array($Company_finance_email_id, $Email_content['Contact_email_id1'], $Email_content['Contact_email_id2']));
							$mail->addCC(array($Company_finance_email_id, $Email_content['Contact_email_id1'], $Email_content['Contact_email_id2']));
							
							
							// $this->CI->email->attach($Email_content['Miles_file_path_pdf']);
							// $this->CI->email->attach($Email_content['Miles_file_path_xls']);
							
							
							$mail->addAttachment($Email_content['Miles_file_path_pdf'], '');
							$mail->addAttachment($Email_content['Miles_file_path_xls'], '');
							
							
							
						  }
						  if ($Template_type == "Merchant_Error_Annexure_billing_File") { 
						  
							// $this->CI->email->cc($Company_finance_email_id);
							$mail->addCC($Company_finance_email_id);
							// $this->CI->email->attach($Email_content['error_file_path']);
							// $this->CI->email->attach($Email_content['Annexure_file_path']);
							// $this->CI->email->attach($Email_content['billing_file_path']);
							
							$mail->addAttachment($Email_content['error_file_path'], '');
							$mail->addAttachment($Email_content['Annexure_file_path'], '');
							$mail->addAttachment($Email_content['billing_file_path'], '');
							
						  }
						  if ($Template_type == "Merchant_Credit_Transaction_Error_File") { 
							// $this->CI->email->cc($Company_finance_email_id);
							$mail->addCC($Company_finance_email_id);
							// $this->CI->email->attach($Email_content['error_file_path']);
							$mail->addAttachment($Email_content['error_file_path'], '');
						  } 
						  if ($Template_type == "Debit_transaction_invoice") {  
							// $this->CI->email->cc($Email_content['Seller_email_id']);
							// $this->CI->email->attach($Email_content['error_file_path']);
							$mail->addCC($Email_content['Seller_email_id']);
							
							// $this->CI->email->attach($Email_content['Annexure_file_path']);
							// $this->CI->email->attach($Email_content['billing_file_path']);
							
							$mail->addAttachment($Email_content['Annexure_file_path'], '');
							$mail->addAttachment($Email_content['billing_file_path'], '');
							
						  } 
						  if ($Template_type == "Debit_trans_settlement") 
						  { 
							// $this->CI->email->cc($Company_finance_email_id);
							$mail->addCC($Company_finance_email_id);
						  } 
						  if ($Template_type == "Loyalty_transaction_settlement") 
						  { 
							// $this->CI->email->cc($Company_finance_email_id);
							$mail->addCC($Company_finance_email_id);
						  }
						  if ($Template_type == "Reconsolation_Error_File") {
							// $this->CI->email->cc($Company_finance_email_id);	
							
							// $this->CI->email->cc(array($company_details->Company_finance_email_id, $Email_content['Contact_email_id1'], $Email_content['Contact_email_id2']));
							$mail->addCC(array($company_details->Company_finance_email_id, $Email_content['Contact_email_id1'], $Email_content['Contact_email_id2']));
							// $this->CI->email->attach($Email_content['error_file_path']);
							$mail->addAttachment($Email_content['error_file_path'], '');
						}
						if ($Template_type == "Saas_company_billing") 
						{ 
							//$this->CI->email->cc($Company_finance_email_id);
							// $this->CI->email->attach($Email_content['Saas_billing_file_path']);
							$mail->addAttachment($Email_content['Saas_billing_file_path'], '');
						}
						if ($Template_type == "E_gifting_catalogue_billing") 
						{ 
							//$this->CI->email->cc($Company_finance_email_id);
							// $this->CI->email->attach($Email_content['Gifting_catalogue_billing_file_path']);
							$mail->addAttachment($Email_content['Gifting_catalogue_billing_file_path'], '');
						}						
						$mail->WordWrap = 50; // Set word wrap to 50 characters
						// $mail->addAttachment('/var/tmp/file.tar.gz');  // Add attachments
						// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   // Optional name
						$mail->isHTML(true);  // Set email format to HTML
						$mail->Subject = $subject;
						$mail->Body = $html;
						if($Notification_send_to_email == 1){
							if(!$mail->send()) {
						
								// echo 'Message could not be sent.';
								// echo 'Mailer Error: ' . $mail->ErrorInfo;
								return $customer_notification;
								
							} else {
								
								// echo 'Message has been sent';
								return $customer_notification;
							}
						}
						
						unset($Email_content);
						unset($Email_content['Miles_file_path_pdf']);
						unset($Email_content['Miles_file_path_xls']);
						
					/*   PHPMailer start END */
			  
			 
			  
			  /*
			  
			  $config['protocol'] = 'smtp';
			  $config['smtp_host'] = 'mail.miraclecartes.com';
			  $config['smtp_user'] = 'rakeshadmin@miraclecartes.com';
			  $config['smtp_pass'] = 'rakeshadmin@123';
			  $config['smtp_port'] = 25; 
			  
			  $config['mailtype'] = 'html';
			  $config['crlf'] = "\r\n";
			  // $config['crlf'] = "\n";
			  $config['newline'] = "\r\n";
			  // $config['charset'] = 'iso-8859-1';
			  $config['charset'] = 'utf-8';
			  $config['wordwrap'] = TRUE;
			  $this->CI->load->library('email', $config);
			  $this->CI->email->initialize($config);
			  $this->CI->email->clear(true);
			  //$this->CI->email->from($company_details->Company_primary_email_id);
			  if ($Template_type == "Saas_company_billing" || $Template_type ==  "E_gifting_catalogue_billing") {
				  $accounts_email = "accounts@igainspark.com";
				  $this->CI->email->from($accounts_email);
			  }else{
				$this->CI->email->from($company_details->Company_primary_email_id);
			  }
			  $this->CI->email->to($User_email_id);
			  
			  if ($Template_type == "Partner_payment") {
				$this->CI->email->cc(array($Company_admin_email_id));
			  }
			  if ($Template_type == "Purchase_Return_Initiated") {
				$this->CI->email->bcc($Seller_email);
			  }
			  if ($Template_type == "Publisher_purchased_miles_File") {


				$this->CI->email->cc(array($Company_finance_email_id, $Email_content['Contact_email_id1'], $Email_content['Contact_email_id2']));
				$this->CI->email->attach($Email_content['Miles_file_path_pdf']);
				$this->CI->email->attach($Email_content['Miles_file_path_xls']);
			  }
			  if ($Template_type == "Merchant_Error_Annexure_billing_File") { 
				$this->CI->email->cc($Company_finance_email_id);
				$this->CI->email->attach($Email_content['error_file_path']);
				$this->CI->email->attach($Email_content['Annexure_file_path']);
				$this->CI->email->attach($Email_content['billing_file_path']);
			  }
			  if ($Template_type == "Merchant_Credit_Transaction_Error_File") { 
				$this->CI->email->cc($Company_finance_email_id);
				$this->CI->email->attach($Email_content['error_file_path']);
			  } 
			  if ($Template_type == "Debit_transaction_invoice") {  
				$this->CI->email->cc($Email_content['Seller_email_id']);
				// $this->CI->email->attach($Email_content['error_file_path']);
				$this->CI->email->attach($Email_content['Annexure_file_path']);
				$this->CI->email->attach($Email_content['billing_file_path']);
			  } 
			  if ($Template_type == "Debit_trans_settlement") 
			  { 
				$this->CI->email->cc($Company_finance_email_id);
			  } 
			  if ($Template_type == "Loyalty_transaction_settlement") 
			  { 
				$this->CI->email->cc($Company_finance_email_id);
			  }
			  if ($Template_type == "Reconsolation_Error_File") {
				// $this->CI->email->cc($Company_finance_email_id);	
				$this->CI->email->cc(array($company_details->Company_finance_email_id, $Email_content['Contact_email_id1'], $Email_content['Contact_email_id2']));
				$this->CI->email->attach($Email_content['error_file_path']);
			  }
			if ($Template_type == "Saas_company_billing") 
			{ 
				//$this->CI->email->cc($Company_finance_email_id);
				$this->CI->email->attach($Email_content['Saas_billing_file_path']);
			}
			if ($Template_type == "E_gifting_catalogue_billing") 
			{ 
				//$this->CI->email->cc($Company_finance_email_id);
				$this->CI->email->attach($Email_content['Gifting_catalogue_billing_file_path']);
			}
			  $this->CI->email->subject($subject);
			  $this->CI->email->message($html);
				
				// if ($Template_type != "Enroll_Freebies") 
				if($Notification_send_to_email == 1)
				{
					//echo "Inside here 1 <br>";
					//print_r($this->CI->email->print_debugger());
					//print_r($this->CI->email->send());
					
					if (!$this->CI->email->send()) 
					{
						//echo "Mail Not Send <br>";
						//print_r($this->CI->email->print_debugger());
					  return $customer_notification;
					} 
					else 
					{
						//echo "Mail Send";
					  return $customer_notification;
					}
				}				
			  $this->CI->email->clear(true);
			  unset($Email_content);
			  unset($Email_content['Miles_file_path_pdf']);
			  unset($Email_content['Miles_file_path_xls']);
			  
			  **************************Email Fuction Code*****************************/
    
	
		} else {
			
				// error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
				$Template_type = $Email_content['Template_type'];
			  
			  
				
			  
				/* $Date = date("Y-m-d H:i:s");
				$Base_url = base_url();
				$Gooogle_Play = $Base_url . 'images/Gooogle_Play.png';
				$iOs_app_store = $Base_url . 'images/iOs_app_store.png'; */
			  
			  
			  $company_details = $this->CI->Igain_model->get_company_details($Company_id);
			  $Comapany_Currency = $company_details->Currency_name;
			  $Loyalty_enabled = $company_details->Loyalty_enabled;
			  $Member_website = $company_details->Cust_website;
			  $Website = $company_details->Website;
			   $Cust_apk_link = $company_details->Cust_apk_link;
			  $Cust_ios_link = $company_details->Cust_ios_link;
			  $Company_name = $company_details->Company_name;
			  $App_folder_name = $company_details->App_folder_name;
			  $Alise_name = $company_details->Alise_name;
			  $Company_address = $company_details->Company_address;
			  $Company_primary_contact_person = $company_details->Company_primary_contact_person;
			  $Company_primary_email_id = $company_details->Company_primary_email_id;
			  $Company_contactus_email_id = $company_details->Company_contactus_email_id;
			  $Facebook_link = $company_details->Facebook_link;
			  $Twitter_link = $company_details->Twitter_link;
			  $Googlplus_link = $company_details->Googlplus_link;
			  $Linkedin_link = $company_details->Linkedin_link;
			  $Company_address = $company_details->Company_address;
			  $Company_address = $company_details->Company_address;
			  $Company_address = $company_details->Company_address;
			  $Company_address = $company_details->Company_address;
			  $Notification_send_to_email = $company_details->Notification_send_to_email;
			  
			  
			  
			  
			  
			// $seller_details = $this->CI->Igain_model->get_enrollment_details($Seller_id);
			$seller_details = $this->CI->Igain_model->Fetch_Super_Seller_details($Company_id);
			$Super_Seller_Name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
			$Super_Seller_id=$seller_details->Enrollement_id;
			$logtimezone=$seller_details->timezone_entry;	  
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$Todays_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('d M Y');
			$Transaction_date = $Todays_date;
			  
			  
			  
			  
			// $customer_details = $this->CI->Igain_model->get_enrollment_details($Enrollment_id);
		  
			$Enrollement_id = $customer_details->Enrollement_id;
			$User_email_id = App_string_decrypt($customer_details->User_email_id);
			$customer_notification = false;  
			$User_id = $customer_details->User_id;
			$Phone_no = App_string_decrypt($customer_details->Phone_no);
			$User_pwd = App_string_decrypt($customer_details->User_pwd);
			$pinno = $customer_details->pinno;
			$Membership_ID = $customer_details->Card_id;
			$Card_id = $customer_details->Card_id;
			$Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;     
			$First_name = $customer_details->First_name;     
			$Last_name =$customer_details->Last_name;     
			$Current_address = $customer_details->Current_address;
			$State = $customer_details->State;
			$City = $customer_details->City;
			$Country = $customer_details->Country;
			$State = $customer_details->State;
			$Tier_id = $customer_details->Tier_id;
			$State = $customer_details->State;
			$total_purchase = $customer_details->total_purchase;
			$Total_topup_amt = $customer_details->Total_topup_amt;
			$Total_reddems = $customer_details->Total_reddems;
			
			$Current_balance = $customer_details->Current_balance;
			$Blocked_points = $customer_details->Blocked_points;
			$Debit_points = $customer_details->Debit_points;
			$Current_point_balance = $Current_balance - ($Blocked_points + $Debit_points);
			
			if ($Current_point_balance < 0) {
				$Current_point_balance = 0;
			} else {
				$Current_point_balance = $Current_point_balance;
			}
			  
			if($Email_template_id==28){
				
				$Customer_name=$Email_content['Gift_card_user'];
				$User_email_id = $Email_content['Gift_card_Email'];
			}
			
			  

				// echo"---Email_template_id--".$Email_template_id."---<br>";	
				// echo"---User_email_id--".$User_email_id."---<br>";	
				
				
				$TemplateDetails=$this->CI->Igain_model->fetchEmailTemplate($Email_template_id,$Company_id);
				// print_r($TemplateDetails);
				// print_r($TemplateDetails->Email_subject);
				
				// die;
				ob_start();	
				
				$Email_header_image = $TemplateDetails->Email_header_image;
				$Template_description = $TemplateDetails->Template_description;
				$Email_subject = $TemplateDetails->Email_subject;
				$Body_structure = $TemplateDetails->Body_structure;
				$Email_body = $TemplateDetails->Email_body;
				$Footer_notes = $TemplateDetails->Footer_notes;
				$Email_header = $TemplateDetails->Email_header;
				$Body_image = $TemplateDetails->Body_image;
				$Email_font_size = $TemplateDetails->Email_font_size;
				$Font_family = $TemplateDetails->Font_family;
				$Email_font_color = $TemplateDetails->Email_font_color;
				$Email_background_color = $TemplateDetails->Email_background_color;
				$Unsubscribe_flg = $TemplateDetails->Unsubscribe_flg;
				
				$Ios_application_link = $TemplateDetails->Ios_application_link;
				$Header_background_color = $TemplateDetails->Header_background_color;
				$Footer_background_color = $TemplateDetails->Footer_background_color;
				$Twitter_share_flag = $TemplateDetails->Twitter_share_flag;
				$Facebook_share_flag = $TemplateDetails->Facebook_share_flag;
				$Linkedin_share_flag = $TemplateDetails->Linkedin_share_flag;
				 
				$Google_share_flag = $TemplateDetails->Google_share_flag;
				$Google_play_link = $TemplateDetails->Google_play_link;
				$Email_Contents_background_color = $TemplateDetails->Email_Contents_background_color;
				$Footer_font_color = $TemplateDetails->Footer_font_color;
				
				
				include'Email_templates/email.php';
					
				$body = ob_get_contents();
				ob_end_clean();	
				
				$today=date("d M Y");
				
				/************************************Email_body Variable Replace Code******************************/
					$search_variables = array(
						'$First_name',
						'$Last_name',
						'$Loyalty_program_name',
						'$Membership_id',
						'$Membership_ID',
						'$Company_name',
						'$User_name',
						'$Password',
						'$Pin_no',
						'$Website',
						'$Outlet_name',
						'$Joining_bonus_points',
						'$Current_balance',
						'$Credit_points',
						'$Purchase_date',
						'$Cancellation_date',
						'$Purchase_amount',
						'$Cancelle_amount',
						'$Debited_points',
						'$Debit_loyalty_points',
						'$Debit_redeem_points',
						'$Bill_no',
						'$End_date',
						'$Start_date',
						'$Voucher_type',
						'$Revenue_voucher',
						'$Product_voucher',
						'$Customer_name',
						'$Discount_voucher',
						'$Discount_percentage',
						'$Discount_value',
						'$User_email_id',
						'$Pwdlink',
						'$Company_Currency',
						'$Transaction_date',
						'$Google_play_link',
						'$Ios_application_link',
						'$Survey_name',
						'$Survey_reward',
						'$Bill_no',
						'$Amount',
						'$Points',
						'$datatable',
						'$Pin',
						'$Transfered_points',
						'$Transferred_to',
						'$Promo_code',
						'$Promo_points',
						'$Transferred_from',
						'$Bill_date',
						'$Topup_amt',
						'$Comapany_Currency',
						'$PurchaseTable',
						'$Redeem_points',
						'$Merchant_name',
						'$Symbol_currency',
						'$GiftCardNo',
						'$GiftCard_balance',
						'$BalanceToPay',
						'$Remark',
						'$Refferral_Customer_name',
						'$Refferal_Customer_name',
						'$Ref_Topup_amount',
						'$Survey_type',
						'$Start_date',
						'$End_date',
						'$Survey_link',
						'$Member_website',
						'$Auction_name',
						'$Auction_description',
						'$Auction_start_date',
						'$Auction_end_date',
						'$Minimum_bid',
						'$Redeem_point',
						'$Merchandize_item_name',
						'$Voucher_no',
						'$Voucher_status',
						'$Symbol_of_currency',
						'$Order_no',
						'$Credit_points',
						'$Order_status_tbl',
						'$Order_status',
						'$Todays_date',
						'$Total_points',
						'$Branch_name',
						'$Branch_Address',
						
						'$Order_type', 
						'$delivery_outlet', 
						'$Orderno', 
						'$POS_bill_no', 
						'$subtotal',
						'$total_loyalty_points', 
						'$grand_total', 
						'$discountVal', 
						'$Cust_wish_redeem_point', 
						'$EquiRedeem', 
						'$Current_point_balance',
						'$vouchers',
						
						'$Excecative_name',
						'$Querylog_ticket',
						'$Max_resolution_datetime',
						'$Excecative_email',
						'$Log_date',
						'$Query_type',
						'$Close_datetime',
						'$Excecative_contact_no',
						'$Priority_name',
						'$Query_detail',
						'$Discount_amount',
						'$Merchant_address',
						'$Top_u_toRefree',
						'$Topup_new_cust',
						'$Referral_rule',
						'$Trigger_contents',
						'$Expired_points',
						'$Old_Tier_name',
						'$New_Tier_name',
						'$Days',
						'$Social_media',
						'$Social_share_points',
						'$Deduct_balance',
						'$SurveyRewardsPoints',
					);
					
					
					 
					
					$inserts_contents = array(
						$First_name,
						$Last_name,
						$Company_name,
						$Card_id,
						$Card_id,
						$Company_name,
						$User_email_id,
						$User_pwd,
						$pinno,
						$Website,
						$Super_Seller_Name,
						$Email_content['Joining_bonus_points'],
						$Current_point_balance,
						$Email_content['topup_amt'],
						$Email_content['Purchase_date'],
						$Email_content['Cancellation_date'],
						$Email_content['Purchase_amount'],
						$Email_content['Cancelle_amount'],
						$Email_content['Debited_points'],
						$Email_content['Debit_loyalty_points'],
						$Email_content['Debit_redeem_points'],
						$Email_content['Bill_no'],
						$Email_content['End_date'],
						$Email_content['Start_date'],
						$Email_content['Voucher_type'],
						$Email_content['Revenue_voucher'],
						$Email_content['Product_voucher'],
						$Customer_name,
						$Email_content['Discount_voucher'],
						$Email_content['Discount_percentage'],
						$Email_content['Discount_value'],
						$User_email_id,
						$PwddataLink,
						$Company_Currency,
						$Transaction_date,
						$Cust_apk_link,
						$Cust_ios_link,
						$Email_content['Survey_name'],
						$Email_content['Survey_reward'],
						$Email_content['Bill_no'],
						$Email_content['Amount'],
						$Email_content['Points'],
						$Email_content['datatable'],
						$pinno,
						$Email_content['Transfered_points'],
						$Email_content['Transferred_to'],
						$Email_content['Promo_code'],
						$Email_content['Promo_points'],
						$Email_content['Transferred_from'],
						$Email_content['Bill_date'],
						$topup_amt,
						$Comapany_Currency,
						$PurchaseTable,
						$Email_content['Redeem_points'],
						$Merchant_name,
						$Email_content['Symbol_currency'],
						$Email_content['GiftCardNo'],
						$Email_content['GiftCard_balance'],
						$Email_content['BalanceToPay'],
						$Email_content['Remark'],
						$Refferral_Customer_name,
						$Email_content['Customer_name'],
						$Email_content['Ref_Topup_amount'],
						$Survey_type,
						$Email_content['Start_date'],
						$Email_content['End_date'],
						$Survey_link,
						$Member_website,
						$Email_content['Auction_name'],
						$Email_content['Auction_description'],
						$Email_content['Auction_start_date'],
						$Email_content['Auction_end_date'],
						$Email_content['Minimum_bid'],
						$Email_content['Redeem_points'],
						$Email_content['Merchandize_item_name'],
						$Email_content['evoucher'],
						$voucherStatus,						
						$Email_content['Symbol_of_currency'],
						$Email_content['Order_no'],
						$Email_content['Credit_points'],
						$Order_status_tbl,
						$Order_status,
						$Todays_date,
						$Email_content['Total_points'],
						$Email_content['Branch_name'],
						$Email_content['Branch_Address'],
						
						$Order_type,
						$delivery_outlet,
						$Orderno,
						$POS_bill_no,
						$subtotal,
						$total_loyalty_points,
						$grand_total,
						$discountVal,
						$Cust_wish_redeem_point,
						$EquiRedeem,
						$Current_point_balance,
						$vouchers,
						
						$Excecative_name,
						$Querylog_ticket,
						$Max_resolution_datetime,
						$Excecative_email,
						$Log_date,
						$Query_type,
						$Close_datetime,
						$Excecative_contact_no,
						$Priority_name,
						$Query_detail,
						$Email_content['Discount_amount'],
						$Merchant_address,
						$Email_content['Top_u_toRefree'],
						$Email_content['Topup_new_cust'],
						$Email_content['Referral_rule'],
						$Trigger_contents,
						$Expired_points,						
						$Email_content['Old_Tier_name'],
						$Email_content['New_Tier_name'],
						$Email_content['Days'],
						$Email_content['Social_media'],
						$Email_content['Social_share_points'],
						$Email_content['Deduct_balance'],
						$Email_content['SurveyRewardsPoints'],
						
					);
					
					
					
					
					
					
					
					/* echo"PurchaseTable--<br><br>--Email_body---";
						print_r($PurchaseTable); */	
					
					
					$email_content = str_replace($search_variables,$inserts_contents,$TemplateDetails->Email_body);
					
					$Email_subject = str_replace($search_variables,$inserts_contents,$TemplateDetails->Email_subject);
					
					$Footer_notes = str_replace($search_variables,$inserts_contents,$TemplateDetails->Footer_notes);
					
					$email_header = str_replace($search_variables,$inserts_contents,$TemplateDetails->Email_header);
					
					
				
				/* Email_header_image *//***************************email_header,	email_content,email_footer Variable Replace Code***********************/
					$search_variables_sub = array('$email_header','$email_content','$email_footer','$Body_image','$Body_structure','$Email_header_image','$Email_font_size','$Font_family','$Email_font_color','$Email_background_color','$Header_background_color','$Footer_background_color','$facebook_link','$twitter_link','$googlplus_link','$linkedin_link','$Email_Contents_background_color','$Footer_font_color');
					
					$inserts_contents_sub = array($email_header,$email_content,$Footer_notes,$TemplateDetails->Body_image,$TemplateDetails->Body_structure,$TemplateDetails->Email_header_image,$TemplateDetails->Email_font_size,$TemplateDetails->Font_family,$TemplateDetails->Email_font_color,$TemplateDetails->Email_background_color,$TemplateDetails->Header_background_color,$TemplateDetails->Footer_background_color,$Facebook_link,$Twitter_link,$Googlplus_link,$Linkedin_link,$Email_Contents_background_color,$Footer_font_color);
					
					$html = str_replace($search_variables_sub,$inserts_contents_sub,$body);
				/************************************Email_subject Variable Replace Code******************************/
				
				
				
					if($Email_template_id==45){
						$Email_subject=$subject;
					}
				
				
					 // $Offer = $Email_content['Notification_type'];
					$Offer = $Email_subject;
					$Offer_description = $html;
				
						$Offer_description1="";
			  
					  if($Offer_description){
						  $Offer_description1=$Offer_description;
					  }
					  else{
						  $Offer_description1="";
					  }
					  
					  
					  
					   
					  
					  if ($Enrollement_id != 0 && $customer_details->User_id == 1 && $Template_type != "Enroll_Freebies" && $Template_type != "Purchase_Return_Initiated") {
						  
						   // $User_email_id = App_string_encrypt($customer_details->User_email_id);
						  
						$cust_notification = array(
							'Company_id' => $Company_id,
							'Seller_id' => $Seller_id,
							'Customer_id' => $Enrollement_id,
							'Communication_id' => $Communication_id,
							'User_email_id' => $User_email_id,
							'Offer' => $Offer,
							'Offer_description' => $html,
							'Offer_description1' => $Offer_description1,
							'Open_flag' => '0',
							'Date' => $Todays_date_time,
							'Active_flag' => 1
						);
						// print_r($cust_notification);
						$customer_notification = $this->CI->Igain_model->insert_customer_notification($cust_notification);
						// print_r($customer_notification);
						if ($Template_type == "Communication") {
						  $new_html = str_replace("#User_notification_id", $customer_notification, $html);
						  $post_data = array
							  (
							  'Offer_description' => $new_html, 
							  'Offer_description1' => $Offer_description1
						  );
						  $Update_customer_notification = $this->CI->Igain_model->update_customer_notification($customer_notification, $Company_id, $Enrollement_id, $post_data);
						  $html = $new_html;
						
						}
						
					  }
				
				

				try {
					
						if($Fcm_access_token != Null && $Fcm_token != Null)
						{		
							$url = "https://fcm.googleapis.com/fcm/send";
							$api_key = $Fcm_access_token;
							$To = $Fcm_token;	
							
							$input_data = array("id"=>$customer_notification,"redirect_to"=>"ReadNotification");
							$notification_data = array("title"=>$Company_name,"body"=>$Email_subject);

							$input_notification = array("to"=>$Fcm_token,"data"=>$input_data,"notification"=>$notification_data);
							$notifBodyReq = json_encode($input_notification);
							
							$curl = curl_init();
							
							curl_setopt_array($curl, array(
							  CURLOPT_URL => $url,
							  CURLOPT_POST => true,
							  CURLOPT_POSTFIELDS => $notifBodyReq,  
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_HTTPHEADER => array('Authorization:key='.$api_key,'Content-Type: application/json')
							));
							$response =curl_exec($curl);
							$data = json_decode($response,true);
							//echo $data;
							curl_close($curl);
						}
					
						/*   PHPMailer start */					
						
							//PHPMailer Object
							$mail = new PHPMailer(true); //Argument true in constructor enables exceptions
							// $mail->SMTPDebug = 1;                               // Enable verbose debug output
							$mail->isSMTP();                                      // Set mailer to use SMTP
						// $mail->Host = 'Igainspark-com.mail.protection.outlook.com';  // Specify main and backup SMTP servers smtp.office365.com Igainspark-com.mail.protection.outlook.com
						$mail->SMTPAuth = true;                               // Enable SMTP authentication
						// $mail->Username = 'no-reply@igainspark.com';                 // SMTP username
						// $mail->Password = 'Gaf70488';                           // SMTP password
						$mail->SMTPSecure = 'tls';             // Enable TLS encryption, `ssl` also accepted
							
							if($Company_id==47)//VITS
						{
							$mail->Host = 'mail.vitspassport.com';
							$mail->From = 'noreply@vitspassport.com';
							$mail->Username = 'noreply@vitspassport.com';     
							$mail->Password = 'loyalty@stack2023';  
							$mail->Port = 587; 
						}
						else
						{
							$mail->Host = 'mail.miraclecartes.com';
							$mail->From = 'no-reply@miraclecartes.com';
							$mail->Username = 'no-reply@miraclecartes.com';                 // SMTP username
							$mail->Password = '8u8IV)?r?V_U';                           // SMTP password
							$mail->Port = 25; 
						}
							$mail->SMTPOptions = array(					
								'ssl' => array(
									'verify_peer' => false,
									'verify_peer_name' => false,
									'allow_self_signed' => true
								)
							);
							
							// $mail->From = 'no-reply@igainspark.com';
							// $mail->From = 'no-reply@miraclecartes.com';
						
							if($Company_name){
								$mail->FromName = $Company_name;
							} else {
								$mail->FromName ='iGainspark SaaS Loyalty';
							}
							// $mail->addAddress($User_email_id, $Customer_name);     // Add a recipient
							// $mail->addReplyTo('ravip@miraclecartes.com', 'Information');
							// $mail->addCC('cc@example.com');
							// $mail->addBCC('bcc@example.com');					
							// $mail->addAddress('ravip@miraclecartes.com', 'Ravi Phad');     // Add a recipient
							
							 if ($Template_type == "Saas_company_billing" || $Template_type ==  "E_gifting_catalogue_billing") {
								  $accounts_email = "accounts@igainspark.com";
								  // $this->CI->email->from($accounts_email);
							  }else{
								// $this->CI->email->from($company_details->Company_primary_email_id);
							  }
							  // $this->CI->email->to($User_email_id);
							  
							$mail->addAddress($User_email_id, $Customer_name);

							 
							
							
							$mail->WordWrap = 50; // Set word wrap to 50 characters
							// $mail->addAttachment('/var/tmp/file.tar.gz');  // Add attachments
							// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   // Optional name
							$mail->isHTML(true);  // Set email format to HTML
							$mail->Subject = $Email_subject;
							$mail->Body = $html;
							
							
							if($Template_type == "Enroll" || $Template_type == "Forgot_password"){
								
								if(!$mail->send()) {						
									// echo 'Message could not be sent.';
									// echo 'Mailer Error: ' . $mail->ErrorInfo;
									return $customer_notification;
									
								} else {
									
									// echo 'Message has been sent';
									return $customer_notification;
								}
							}
							
							if($Notification_send_to_email == 1)
							{
								if(!$mail->send()) {
						
								// echo 'Message could not be sent.';
								// echo 'Mailer Error: ' . $mail->ErrorInfo;
									return $customer_notification;
									
								} else {
									
									// echo 'Message has been sent';
									return $customer_notification;
								}
							}
							
							
							unset($Email_content);
							unset($Email_content['Miles_file_path_pdf']);
							unset($Email_content['Miles_file_path_xls']);
							
						/*   PHPMailer start END */
					
					
					
					
									
					 /* ************************Email Fuction Code*****************************
						
						
						  $config['protocol'] = 'smtp';
							$config['smtp_host'] = 'mail.miraclecartes.com';
							$config['smtp_user'] = 'rakeshadmin@miraclecartes.com';
							$config['smtp_pass'] = 'rakeshadmin@123';
							$config['smtp_port'] = 25; 
						  $config['smtp_timeout'] = '5';	//new entry	
						  $config['smtp_priority'] = '3';	//new entry							  
						  $config['smtp_crypto'] = 'tls';
						  $config['smtp_auth'] = false;
						  $config['starttls'] = true;

						  $config['mailtype'] = 'html';
						  $config['crlf'] = "\r\n";
						  $config['newline'] = "\r\n";
						  $config['charset'] = 'utf-8'; //iso-8859-1
						  $config['wordwrap'] = TRUE;
						  $this->CI->load->library('email', $config);
						  $this->CI->email->initialize($config);

						  //$this->CI->email->from($company_details->Company_primary_email_id);
						  if ($Template_type == "Saas_company_billing" || $Template_type ==  "E_gifting_catalogue_billing") {
							  $accounts_email = "accounts@igainspark.com";
							  $this->CI->email->from($accounts_email);
						  }else{
							$this->CI->email->from($company_details->Company_primary_email_id);
						  }
						  $this->CI->email->to($User_email_id);

						  $this->CI->email->subject($Email_subject);
						  $this->CI->email->message($html);

						  if (!$this->CI->email->send()) {
							//echo"----Send--Email Template-<br>";
							//var_dump($this->CI->email->send());
							return $customer_notification;
						  } else {
							//echo"--Not--Send--Email Template-<br>";
							return $customer_notification;
						  }
						  
						 // echo"---Notification_send_to_email--".$Notification_send_to_email."---<br>";	 
						  if($Notification_send_to_email == 1)
							{
								if (!$this->CI->email->send()) 
								{
								  return $customer_notification;
								} 
								else 
								{
								  return $customer_notification;
								}
							}
							
						  $this->CI->email->clear(true);
						  unset($Email_content);
						  unset($Email_content['Miles_file_path_pdf']);
						  unset($Email_content['Miles_file_path_xls']);
					
					************************************** */
					
					
					
				} catch (Exception $e) {
					
					// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
				// $timezone_entry = $_SESSION["timezone_entry"];
				
				

				
		}
	
	
	
	
	}

    public function Coal_send_Notification_email($Enrollment_id, $Email_content, $Seller_id, $Company_id) {
     // echo"----Coal_send_Notification_email----<br>";
      $Template_type = $Email_content['Template_type'];
      $company_details = $this->CI->Igain_model->get_company_details($Company_id);
      $seller_details = $this->CI->Igain_model->get_enrollment_details($Seller_id);
      $customer_details = $this->CI->Igain_model->get_enrollment_details($Enrollment_id);
      $Member_website = $company_details->Cust_website;
      $Company_name = $company_details->Company_name;
      $Comapany_Currency = $company_details->Currency_name;
	  $Notification_send_to_email = $company_details->Notification_send_to_email;
      $Date = date("Y-m-d");
      $Enrollement_id = $customer_details->Enrollement_id;
      $Current_point_balance = $customer_details->Current_balance;
		$User_email_id = App_string_decrypt($customer_details->User_email_id);
        $Phone_no = App_string_decrypt($customer_details->Phone_no);
        $User_pwd = App_string_decrypt($customer_details->User_pwd);
      $Base_url = base_url();
      $Gooogle_Play = $Base_url . 'images/Gooogle_Play.png';
      $iOs_app_store = $Base_url . 'images/iOs_app_store.png';
      $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
      $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
      
      $Get_Record1 = $this->CI->Coal_Transactions_model->get_cust_seller_record($Seller_id, $Enrollment_id);
      foreach ($Get_Record1 as $val) {
        
        $Cust_seller_balance= $val["Cust_seller_balance"];
        $Seller_total_purchase= $val["Seller_total_purchase"];
        $Seller_total_redeem= $val["Seller_total_redeem"];
        $Seller_total_gain_points = $val["Seller_total_gain_points"];
        $Seller_total_topup = $val["Seller_total_topup"];
        $Seller_paid_balance= $val["Seller_paid_balance"];
        $Cust_debit_points = $val["Cust_debit_points"];
        $Cust_block_amt= $val["Cust_block_amt"];
        $Cust_block_points = $val["Cust_block_points"];  
        $Cust_block_amt = $val["Cust_block_amt"];
        $Cust_debit_points = $val["Cust_debit_points"];
       $Cust_prepayment_balance = $val["Cust_prepayment_balance"];
      }
      
      $Cust_seller_balance=round(( $Cust_seller_balance )-( $Cust_block_points + $Cust_debit_points ));
      $customer_notification = false;

      if ($Template_type == "Issue_bonus") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Bonus Issued from " . $company_details->Company_name;

        ob_start();
        $Cust_apk_link = $company_details->Cust_apk_link;
        $Cust_ios_link = $company_details->Cust_ios_link;
        $Base_url = base_url();

        include'./application/libraries/Email_templates/Coal_issue_bonus.php';
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;


        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$topup_amt', '$Current_balance', '$Cust_seller_balance', '$Coalition_curr_bal', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, round($Email_content['topup_amt']), $Current_point_balance, round($Email_content['Cust_seller_balance']), round($Email_content['Coalition_curr_bal']), $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Referral_topup") {
        // echo"--Template_type---".$Template_type."---<br>";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Bonus Issued from " . $company_details->Company_name;

        ob_start();
        $Cust_apk_link = $company_details->Cust_apk_link;
        $Cust_ios_link = $company_details->Cust_ios_link;
        $Base_url = base_url();

        include './application/libraries/Email_templates/Coal_referral_topup.php';
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Ref_Topup_amount', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$New_customer_name', '$Comapany_Currency','$Cust_seller_balance'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, round($Email_content['Ref_Topup_amount']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Email_content['Customer_name'], $Comapany_Currency,$Cust_seller_balance);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Referee_topup") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Bonus Issued from " . $company_details->Company_name;

        ob_start();
        $Cust_apk_link = $company_details->Cust_apk_link;
        $Cust_ios_link = $company_details->Cust_ios_link;
        $Base_url = base_url();

        include './application/libraries/Email_templates/Coal_referee_topup.php';
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Ref_Topup_amount', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$New_customer_name', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, round($Email_content['Ref_Topup_amount']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Email_content['Customer_name'], $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Place_order") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $Seller_name = $Email_content['Seller_name'];
        $banner_image = $Email_content['banner_image'];
        $Full_name = $Email_content['Full_name'];
        $Trans_Type = $Email_content['Trans_Type'];
        $subject = "Transaction at merchant " . $Seller_name;

        ob_start();
        $Cust_apk_link = $company_details->Cust_apk_link;
        $Cust_ios_link = $company_details->Cust_ios_link;
        $Base_url = base_url();

        include './application/libraries/Email_templates/Coal_Place_order.php';
        $body = ob_get_contents();
        ob_end_clean();

        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$banner_image', '$Trans_Type', '$Trans_date', '$Merchandize_item_name', '$QTY', '$Sub_total', '$Symbol', '$Sales_tax', '$Tax_Grand_total', '$Cust_seller_balance', '$Cust_prepayment_balance', '$Seller_name', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency');
        $inserts_contents = array($Customer_name, $Merchant_name, $Email_content['banner_image'], $Email_content['Trans_Type'], $Email_content['Todays_date'], $Email_content['Merchandize_item_name'], $Email_content['QTY'], $Email_content['Sub_total'], $Email_content['Symbol'], $Email_content['Sales_tax'], $Email_content['Tax_Grand_total'], $Email_content['Cust_seller_balance'], $Email_content['Cust_prepayment_balance'], $Email_content['Seller_name'], $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
      }
      if ($Template_type == "Coalition_loyalty_transaction") {
         //echo"---Loyalty_transaction-----";
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Today_date']));
        $subject = "Loyalty Transaction with " . $company_details->Company_name;

        ob_start();
        $Manual_bill_no = $Email_content['Manual_billno'];
        $GiftCardNo = $Email_content['GiftCardNo'];
        $gift_reedem = $Email_content['gift_reedem'];
        $Redeem_points = $Email_content['Redeem_points'];
        $Purchase_amount = $Email_content['Purchase_amount'];
        $Total_loyalty_points = $Email_content['Total_loyalty_points'];
        $Coalition_Loyalty_pts = $Email_content['Coalition_Loyalty_pts'];
        $Coalition_curr_bal = $Email_content['Coalition_curr_bal'];
        //$Cust_seller_balance = round($Email_content['Cust_seller_balance']);
        $Merchant_name = $Email_content['Merchant_name'];
        $Balance_to_pay = $Email_content['Balance_to_pay'];
        $Payment_by = $Email_content['Payment_by'];
        include './application/libraries/Email_templates/Coal_loyalty_transaction.php';

        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Purchase_amount', '$Symbol_currency', '$Redeem_points', '$GiftCardNo', '$gift_reedem', '$Balance_to_pay', '$Total_loyalty_points', '$Coalition_Loyalty_pts', '$Coalition_curr_bal', '$Current_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency', '$Manual_bill_no','$Cust_seller_balance'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, $Email_content['Purchase_amount'], $Email_content['Symbol_currency'], $Email_content['Redeem_points'], $Email_content['GiftCardNo'], $Email_content['gift_reedem'], $Email_content['Balance_to_pay'], round($Email_content['Total_loyalty_points']), round($Email_content['Coalition_Loyalty_pts']), round($Email_content['Coalition_curr_bal']), $Current_point_balance, $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency, $Manual_bill_no,$Cust_seller_balance);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */
       // echo $html;
      }
     if ($Template_type == "Coal_Redeem") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $Transaction_date = date("d M Y", strtotime($Email_content['Todays_date']));
        $subject = "Redeem Transaction at " . $company_details->Company_name;

        ob_start();
        include './application/libraries/Email_templates/Coal_just_Redeem.php';
        $body = ob_get_contents();
        ob_end_clean();
        $Customer_name = $customer_details->First_name . ' ' . $customer_details->Last_name;
        $Merchant_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;
        /*         * **********************************Variable Replace Code***************************** */
        $search_variables = array('$Customer_name', '$Merchant_name', '$Membership_ID', '$Redeem_points', '$Cust_seller_balance', '$Transaction_date', '$Member_website', '$Company_name', '$Gooogle_Play', '$iOs_app_store', '$Comapany_Currency'); //
        $inserts_contents = array($Customer_name, $Merchant_name, $customer_details->Card_id, round($Email_content['Redeem_points']), round($Email_content['Cust_seller_balance']), $Transaction_date, $Member_website, $Company_name, $Gooogle_Play, $iOs_app_store, $Comapany_Currency);
        $html = str_replace($search_variables, $inserts_contents, $body);
        /*         * **********************************Variable Replace Code***************************** */

        // echo $html;
        // die;
      }

      if ($Template_type == "Coal_Redemption") {
        $Communication_id = 0;
        $Offer = $Email_content['Notification_type'];
        $html = $Email_content['Contents'];
        $subject = $Email_content['subject'];
      }
      /* -------------------------Insert Notification----------------------- */
      if ($Enrollement_id != 0 && $customer_details->User_id == 1) {
        $cust_notification = array(
            'Company_id' => $Company_id,
            'Seller_id' => $Seller_id,
            'Customer_id' => $Enrollement_id,
            'Communication_id' => $Communication_id,
            'User_email_id' => $User_email_id,
            'Offer' => $Offer,
            'Offer_description' => $html,
            'Open_flag' => '0',
            'Date' => $Date,
            'Active_flag' => 1
        );
        $customer_notification = $this->CI->Igain_model->insert_customer_notification($cust_notification);
		// echo"---sql--".$this->db->last_query()."---<br>";
        if ($Template_type == "Communication") {
          $new_html = str_replace("#User_notification_id", $customer_notification, $html);
          $post_data = array
              (
              'Offer_description' => $new_html
          );
          $Update_customer_notification = $this->CI->Igain_model->update_customer_notification($customer_notification, $Company_id, $Enrollement_id, $post_data);
          $html = $new_html;
        }
      }

      /* -------------------------Insert Notification----------------------- */


			/*   PHPMailer start */					
						
							//PHPMailer Object
							$mail = new PHPMailer(true); //Argument true in constructor enables exceptions
							// $mail->SMTPDebug = 1;                               // Enable verbose debug output
							$mail->isSMTP();                                      // Set mailer to use SMTP
						// $mail->Host = 'Igainspark-com.mail.protection.outlook.com';  // Specify main and backup SMTP servers smtp.office365.com Igainspark-com.mail.protection.outlook.com
						
						$mail->SMTPAuth = true;                               // Enable SMTP authentication
						$mail->SMTPSecure = 'tls';             // Enable TLS encryption, `ssl` also accepted
						// $mail->Username = 'no-reply@igainspark.com';                 // SMTP username
						
						// $mail->Password = 'Gaf70488';                           // SMTP password
						if($Company_id==47)//VITS
						{
							$mail->Host = 'mail.vitspassport.com';
							$mail->From = 'noreply@vitspassport.com';
							$mail->Username = 'noreply@vitspassport.com';     
							$mail->Password = 'loyalty@stack2023';  
							$mail->Port = 587; 
						}
						else
						{
							$mail->Host = 'mail.miraclecartes.com';
							$mail->From = 'no-reply@miraclecartes.com';
							$mail->Username = 'no-reply@miraclecartes.com';                 // SMTP username
							$mail->Password = '8u8IV)?r?V_U';                           // SMTP password
							$mail->Port = 25; 
						}
						
							
							$mail->SMTPOptions = array(					
								'ssl' => array(
									'verify_peer' => false,
									'verify_peer_name' => false,
									'allow_self_signed' => true
								)
							);
							
							// $mail->From = 'no-reply@igainspark.com';
							// $mail->From = 'no-reply@miraclecartes.com';
							if($Company_name){
								$mail->FromName = $Company_name;
							} else {
								$mail->FromName ='iGainspark SaaS Loyalty';
							}
							// $mail->addAddress($User_email_id, $Customer_name);     // Add a recipient
							// $mail->addReplyTo('ravip@miraclecartes.com', 'Information');
							// $mail->addCC('cc@example.com');
							// $mail->addBCC('bcc@example.com');					
							// $mail->addAddress('ravip@miraclecartes.com', 'Ravi Phad');     // Add a recipient
							
							 if ($Template_type == "Saas_company_billing" || $Template_type ==  "E_gifting_catalogue_billing") {
								  $accounts_email = "accounts@igainspark.com";
								  // $this->CI->email->from($accounts_email);
							  }else{
								// $this->CI->email->from($company_details->Company_primary_email_id);
							  }
							  // $this->CI->email->to($User_email_id);
							  
							$mail->addAddress($User_email_id, $Customer_name);

							$mail->WordWrap = 50; // Set word wrap to 50 characters
							// $mail->addAttachment('/var/tmp/file.tar.gz');  // Add attachments
							// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   // Optional name
							$mail->isHTML(true);  // Set email format to HTML
							$mail->Subject = $subject;
							$mail->Body = $html;
							
							
							if($Template_type == "Enroll" || $Template_type == "Forgot_password"){
								
								if(!$mail->send()) {						
									// echo 'Message could not be sent.';
									// echo 'Mailer Error: ' . $mail->ErrorInfo;
									return $customer_notification;
									
								} else {
									
									// echo 'Message has been sent';
									return $customer_notification;
								}
							}
							
							if($Notification_send_to_email == 1)
							{
								if(!$mail->send()) {
						
								// echo 'Message could not be sent.';
								// echo 'Mailer Error: ' . $mail->ErrorInfo;
									return $customer_notification;
									
								} else {
									
									// echo 'Message has been sent';
									return $customer_notification;
								}
							}
							
							
							
							
						/*   PHPMailer start END */








      /**************************Email Fuction Code*****************************
      
	  
	  
	  
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'Igainspark-com.mail.protection.outlook.com';
			$config['smtp_user'] = 'admin@igainspark.com';
			$config['smtp_pass'] = '7Ik7bnxAN54dF';
			$config['smtp_port'] = 25; 
			$config['smtp_crypto'] = 'tls';
			$config['smtp_auth'] = false;
			$config['starttls'] = true;

		  $config['mailtype'] = 'html';
		  $config['crlf'] = "\r\n";
		  $config['newline'] = "\r\n";
		  $config['charset'] = 'iso-8859-1';
		  $config['wordwrap'] = TRUE;
		  $this->CI->load->library('email', $config);
		  $this->CI->email->initialize($config);
		
		if ($Template_type == "Saas_company_billing" || $Template_type ==  "E_gifting_catalogue_billing") {
			$accounts_email = "accounts@igainspark.com";
		  $this->CI->email->from($accounts_email);
		}else{
			$this->CI->email->from($company_details->Company_primary_email_id);
		}
		
		  $this->CI->email->to($User_email_id);

		  $this->CI->email->subject($subject);
		  $this->CI->email->message($html);

		  if (!$this->CI->email->send()) {
			// echo"----Send--Email Template-<br>";
			// var_dump($this->CI->email->send());
			return $customer_notification;
		  } else {
			// echo"--Not--Send--Email Template-<br>";
			return $customer_notification;
		  }



      **************************Email Fuction Code*****************************/	
	  
	  
	  
	  
	  
	  
	  
    }

  }
 ?>