<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Gift_payment extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Saas_model');
		$this->load->library('form_validation');	
		$this->load->library('Send_notification');
		$this->load->library('m_pdf');
		$this->load->helper('file');
		$this->load->helper(array('form', 'url','encryption_val'));	
		$this->load->model('Email_templateM/Email_templateModel');
	}
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$Create_user_id = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$data['Records'] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;	
			
			$dial_code = $this->Igain_model->get_dial_code($data['Records']->Country_id);
			$exp=explode($dial_code,App_string_decrypt($data['Records']->Phone_no));
			$data['phnumber'] = $exp[1];
			
			$data['States_array'] = $this->Igain_model->Get_states($data['Records']->Country_id);	
			$data['City_array'] = $this->Igain_model->Get_cities($data['Records']->State);
			$currency_details = $this->Igain_model->Get_Country_master($data['Records']->Country_id);
			$data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			
			$data['Cunverted_currency'] = $this->convert_currency($currency_details->Symbol_of_currency);
			
			$resultis = $this->Igain_model->get_company_details($Company_id);
			// $data['Gift_account_balance'] = $resultis->Gift_payment_balance;
			// $data['Gift_account_point_balance'] = $resultis->Gift_point_balance;
			$Redemptionratio = $resultis->Redemptionratio;
			$Company_gift_catalogue_balance = $resultis->Gift_payment_balance;
			$Company_gift_point_balance = $resultis->Gift_point_balance;
			
			if($this->session->userdata('Gift_payment_session'))
			{
				$Todays_date = date('Y-m-d');
				
				$session_data2 = $this->session->userdata('Gift_payment_session');
				
				$Razorpay_payment_id = $session_data2['Razorpay_payment_id'];
				
				//$data['Payment_details'] = $this->Saas_model->Get_payment_details($Razorpay_payment_id,$Company_id);
				
				$Payment_details = $this->Saas_model->Get_payment_details($Razorpay_payment_id,$Company_id);
				
				if($Payment_details != Null)
				{	
					if($Payment_details->Payment_status =="captured")
					{
						$resultis = $this->Igain_model->get_company_details(1);
						
						$Saas_export_bill_no = $resultis->Saas_export_bill_no;
						$Saas_sgst_bill_no = $resultis->Saas_sgst_bill_no;
						$Saas_igst_bill_no = $resultis->Saas_igst_bill_no;
						
						$Saas_sgst_bill_no++;
						$Saas_igst_bill_no++;
						$Saas_export_bill_no++;
						
						$Payment_country = $Payment_details->Country_name;
						$Payment_state = $Payment_details->State_name;
						$Merchant_order_id = $Payment_details->Merchant_order_id;
						
						if($Payment_country == 'India')
						{
							if($Payment_state == 'Maharashtra')
							{
								$post_dataMaha = array('Bill_no' => $Saas_sgst_bill_no); 
								
								$UpdatePayment = $this->Saas_model->Update_payment_details($Merchant_order_id,$post_dataMaha);
	
								$post_datax = array(
									'Saas_sgst_bill_no' => $Saas_sgst_bill_no,
									'Update_user_id' => $Create_user_id,
									'Update_date_time' => date('Y-m-d H:i:s')
										);
								$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
							}
							else
							{
								$post_dataN = array('Bill_no' => $Saas_igst_bill_no); 
								
								$UpdatePayment = $this->Saas_model->Update_payment_details($Merchant_order_id,$post_dataN);
								
								$post_datax = array(
									'Saas_igst_bill_no' => $Saas_igst_bill_no,
									'Update_user_id' => $Create_user_id,
									'Update_date_time' => date('Y-m-d H:i:s')
										);
								$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
							}
						}
						else
						{
							$post_dataU = array('Bill_no' => $Saas_export_bill_no); 
								
							$UpdatePayment = $this->Saas_model->Update_payment_details($Merchant_order_id,$post_dataU);
								
							$post_datax = array(
								'Saas_export_bill_no' => $Saas_export_bill_no,
								'Update_user_id' => $Create_user_id,
								'Update_date_time' => date('Y-m-d H:i:s')
									);
							$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
						}
						
						$data['Payment_details'] = $this->Saas_model->Get_payment_details($Razorpay_payment_id,$Company_id);
						
						$Bill_amount = $data['Payment_details']->Bill_amount_local_currency;
						
						$Bill_amount_in_points = $Bill_amount*$Redemptionratio;
						
						$New_gift_catalogue_balance = $Company_gift_catalogue_balance+$Bill_amount;
						
						$New_gift_catalogue_Points_balance = $Company_gift_point_balance+$Bill_amount_in_points;
						
						$post_dataXX = array(
							'Gift_payment_balance' => $New_gift_catalogue_balance,
							'Gift_point_balance' => $New_gift_catalogue_Points_balance
						);
						
						$Update = $this->Saas_model->Update_saas_company($Company_id,$post_dataXX);
						
						$Enrollement_id = $data['Payment_details']->Enrollement_id;
						$Payment_email = $data['Payment_details']->Payment_email;
						$License_type = $data['Payment_details']->License_type;
						$Billing_country_name = $data['Payment_details']->Country_name;
						$Invoice_no = $data['Payment_details']->Bill_no;
						
						
						$date1=date_create($data['Payment_details']->Bill_date);
						$data['Invoice_date'] = date_format($date1,"d-M-Y");	
						
						if($Billing_country_name == "India")
						{
							$data["Symbol_currency"] = "INR";
							$Currency_alies = "INDIAN RUPEES";
						}
						else
						{
							$data["Symbol_currency"] = "USD";
							$Currency_alies = "US DOLLAR";
						}
						
						
						$Bill_amaount_in_word = $this->convert_number($data['Payment_details']->Bill_amount);
						
						$data['Bill_amaount_in_word'] = $Currency_alies.' '.$Bill_amaount_in_word.' only';
						
						$Compnay_details = $this->Igain_model->get_company_details($Company_id);
		
						$data['Company_name'] = $Compnay_details->Company_name;	
						
						$data['Application_name'] = "E-Gifting Catalogue Account TopUp";
						
					/**********************************************************************/
						ob_start();
						$htmlBill = $this->load->view('Gift_payment/pdf_gifting_invoice', $data, true);
						
						$Bill_filename = $data['Company_name'].'_'.$Invoice_no.'_'.date('Y_m_d_H_i_s');
						
						$billing_file_path = "";
						
						$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
						 
						$pdf = new mPDF();
						$pdf->showImageErrors = true;
						$pdf->WriteHTML($htmlBill);
						$billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Gifting_Catalogue_billing_files/' . $Bill_filename . '.pdf', 'F');
						$pdf->Output($DOCUMENT_ROOT . '/export/Gifting_Catalogue_billing_files/' . $Bill_filename . '.pdf', 'F');
						$billing_file_path = $DOCUMENT_ROOT . '/export/Gifting_Catalogue_billing_files/' . $Bill_filename . '.pdf';
						unset($pdf);
					/**********************************************************************/
						 $Email_content = array(
						  'Todays_date' => $Todays_date,
						  'Seller_name' => $data['LogginUserName'],
						  'Payment_email' => $Payment_email,
						  'Company_name' => $data['Company_name'],
						  'Application_name' => $data['Application_name'],
						  'Symbol_currency' => $data['Symbol_currency'],
						  'Gifting_catalogue_billing_file_path' => $billing_file_path,
						  'Notification_type' => 'Thank you for the E-Gifting Catalogue payment',
						  'Template_type' => 'E_gifting_catalogue_billing'
					  );

						$Notification = $this->send_notification->send_Notification_email($Enrollement_id, $Email_content, $data['enroll'], $Company_id);

						$post_dataX = array(
							'Email_sent' => 1
						);
					
						$Update_invoice = $this->Saas_model->Update_invoice_status($Enrollement_id,$Company_id,$Razorpay_payment_id,$post_dataX);
						
						$this->session->set_flashdata("success_code", $data['Payment_details']->Description);
						
					}
					else
					{
						$this->session->set_flashdata("error_code", $Payment_details->Description);
					}
				}
			}			
			
			$this->session->set_userdata('Gift_payment_session', "");
			
			$data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			
			$data['Payment_record'] = $this->Saas_model->Get_Gift_payment_record($Company_id);
			
			$resultis = $this->Igain_model->get_company_details($Company_id);
			$data['Gift_account_balance'] = $resultis->Gift_payment_balance;
			$data['Gift_account_point_balance'] = $resultis->Gift_point_balance;
			 
			$this->load->view('Gift_payment/Gift_payment', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Create_order()
	{		
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Gift_account_balance"] = $data["Company_details"]->Gift_payment_balance;
			$data["Gift_account_point_balance"] = $data["Company_details"]->Gift_point_balance;
			$data["Redemptionratio"] = $data["Company_details"]->Redemptionratio;
			
			$data['Records'] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
			$currency_details = $this->Igain_model->Get_Country_master($data['Records']->Country_id);
			$data['Symbol_currency'] = $currency_details->Symbol_of_currency;
			$data['Country_name'] = $currency_details->name;
			
			$data['Cunverted_currency'] = $this->convert_currency($currency_details->Symbol_of_currency);
			
			if($_POST != NULL) 
			{
				$Required_filed = array(
					array(
							'field' => 'Name',
							'label' => 'Name',
							'rules' => 'required'
					),
					array(
							'field' => 'Email',
							'label' => 'Email',
							'rules' => 'required'
							
					),
					array(
							'field' => 'Phone_no',
							'label' => 'Phone_no',
							'rules' => 'required'
							
					),
					array(
							'field' => 'Country_name',
							'label' => 'Country_name',
							'rules' => 'required'
							
					),
					array(
							'field' => 'Business_address',
							'label' => 'Business_address',
							'rules' => 'required'
							
					)
				);
				
				$this->form_validation->set_rules($Required_filed);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("error_code","Please Fill Up Required Fileds");
					redirect('Gift_payment');
				}
				else if($this->form_validation->run() == TRUE)
				{
					$User_name = strip_tags($_REQUEST['Name']);
					$User_email = strip_tags($_REQUEST['Email']);
					$User_phone = strip_tags($_REQUEST['Phone_no']);
					$Country_name = strip_tags($_REQUEST['Country_name']);
					$Bill_amount = strip_tags($_REQUEST['Bill_amount']);
					
					if (!filter_var($User_email, FILTER_VALIDATE_EMAIL)) {
					  $this->session->set_flashdata("error_code","Please Enter Valid Email Address");
					  redirect('Gift_payment/', 'refresh');	
					}
					$checkPhone = is_numeric($User_phone);
					if($checkPhone !=1)
					{
						$this->session->set_flashdata("error_code","Please Enter Valid Phone Number");
						redirect('Gift_payment/', 'refresh');	
					}
					/* if(strlen($User_phone) != 10)
					{
						$this->session->set_flashdata("error_code","Please Enter 10 digit Mobile No.");
						redirect('Gift_payment/', 'refresh');	
					} */
					if($data['Country_name']!= $Country_name)
					{
						$this->session->set_flashdata("error_code","Please Select Valid Country");
						redirect('Gift_payment/', 'refresh');
					}
					
					$resultis = $this->Igain_model->get_company_details(1);
					$Gift_payment_bill_no = $resultis->Payment_bill_no;
					
					$Gift_payment_bill_no++;	
					$Bill_no = $Gift_payment_bill_no;
					
					$Bill_amount_INR = $Bill_amount;
					
					if($data['Records']->Country_id == 101)
					{ 
						$currency="INR"; 
						$Bill_amt_inr = array('1000','5000','10000','15000');
						
						if (!in_array($Bill_amount, $Bill_amt_inr)){
							$this->session->set_flashdata("error_code","Please Select Valid TopuUp Amount");
							redirect('Gift_payment/', 'refresh');
						}
					} 
					else 
					{
						$currency="USD"; 
						$Bill_amt_usd = array('100','500','1000','5000');
						if (!in_array($Bill_amount, $Bill_amt_usd)){
							$this->session->set_flashdata("error_code","Please Select Valid TopuUp Amount");
							redirect('Gift_payment/', 'refresh');
						}	
						$INR_value = $this->convert_currency("INR");
						$Bill_amount_INR = ($Bill_amount*$INR_value);
					}
					if($data['Symbol_currency']!= $currency)
					{
						$Local_currency_amount = $Bill_amount*$data['Cunverted_currency'];
						$Local_amount = $Local_currency_amount;
					}
					else
					{
						$Local_currency_amount = $Bill_amount;
						$Local_amount = $Local_currency_amount;
					}
					$post_datax = array(
								'Payment_bill_no' => $Bill_no,
								'Update_user_id' => $data['enroll'],
								'Update_date_time' => date('Y-m-d H:i:s')
									);
					$Update = $this->Saas_model->Update_saas_company(1,$post_datax);
					
					$Payment_data = array(
							'Payment_type' => 1,
							'Company_id' => $Company_id,
							'Enrollement_id' => $data['enroll'],
							'Merchant_order_id' => $Bill_no,
							'Bill_amount' => $Bill_amount,
							'Bill_amount_INR' => $Bill_amount_INR,
							'Bill_amount_local_currency' => $Local_amount,
							'Sac_code' => "998599",
							'Country_name' => $Country_name,
							'State_name' => strip_tags($_REQUEST['State_name']),
							'Business_address' => strip_tags($_REQUEST['Business_address']),
							'Bill_date' => date('Y-m-d H:i:s')
						);
						
					$Insert = $this->Saas_model->insert_saas_company_payment($Payment_data);
					
					$base_url =  base_url();
					$data['name'] = $User_name;
					$data['email'] = $User_email;
					$data['contact'] = $User_phone;
					$data['currency'] = $currency;
					$data['address'] = strip_tags($_REQUEST['Business_address']);
					$data['order_no'] = $Bill_no;
					$data['amount'] = $Bill_amount;
					$data['company_id'] = $Company_id;
					$data['enrollement_id'] = $data['enroll'];
					$data['callback_url'] = $base_url.'index.php/Gift_payment/verifyPayment';
					
					$data['Local_currency_amount'] = $Local_amount;
					$data['Equivalent_points'] = $Local_amount * $data["Redemptionratio"];
					$data['New_balance'] = $data["Gift_account_balance"] + $Local_amount;
					$data['New_equivalent_points'] = $data["Gift_account_point_balance"] + $data['Equivalent_points'];
			
					$this->load->view('rozarpay/pay_gift', $data);
				}
			}
			else
			{
				redirect('Gift_payment');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function verifyPayment()
	{
		if(empty($this->input->post('razorpay_order_id')) === false)
		{
			$razorpay_order_id = $this->input->post('razorpay_order_id'); 
		}
		else
		{
			foreach($this->input->post() as $key => $values) {
				
				$metadata = json_decode($values['metadata']);
				$razorpay_order_id = $metadata->order_id;
			}
		}
		
		$Payment_details = $this->Saas_model->Get_company_payment_details($razorpay_order_id);
		$Enrollement_id = $Payment_details->Enrollement_id;
		$Company_id = $Payment_details->Company_id;
		
		$data['Enrollement_id'] = $Enrollement_id;
		$data['Company_id'] = $Company_id;
		
		$result = $this->Saas_model->Auto_login($Company_id,$Enrollement_id);
		
		if ($result)
		{	
          $sess_array = array();
          $User_id = 0;
          $Super_seller = 0;
          $Sub_seller_admin = 0;
          foreach ($result as $row) {
			$User_id = $row['User_id'];
            $Super_seller = $row['Super_seller'];
            $Sub_seller_admin = $row['Sub_seller_admin'];
				$sess_array = array('enroll' => $row['Enrollement_id'], 'username' => $row['User_email_id'], 'Country_id' => $row['Country_id'], 'userId' => $User_id, 'Super_seller' => $Super_seller, 'Company_name' => $row['Company_name'], 'Company_id' => $row['Company_id'], 'Login_Partner_Company_id' => $row['Company_id'], 'timezone_entry' => $row['timezone_entry'], 'Full_name' => $row['First_name'] . " " . $row['Middle_name'] . " " . $row['Last_name'], 'Count_Client_Company' => $row['Count_Client_Company'], 'card_decsion' => $row['card_decsion'], 'next_card_no' => $row['next_card_no'], 'Seller_licences_limit' => $row['Seller_licences_limit'], 'Seller_topup_access' => $row['Seller_topup_access'], 'Current_balance' => $row['Current_balance'], 'Allow_membershipid_once' => $row['Allow_membershipid_once'], 'Allow_merchant_pin' => $row['Allow_merchant_pin'], 'Sub_seller_admin' => $Sub_seller_admin, 'pinno' => $row['pinno'], 'smartphone_flag' => '2', 'Sub_seller_Enrollement_id' => $row['Sub_seller_Enrollement_id'], 'Membership_redirection_url' => $row['Membership_redirection_url'], 'Localization_flag' => $row['Localization_flag'], 'Localization_logo' => $row['Localization_logo'], 'Company_License_type' => $row['Company_License_type'], 'Comp_regdate' => $row['Comp_regdate']);
				
				$this->session->set_userdata('logged_in', $sess_array);
			}
		}
		
		$data['base_url'] =  base_url();
		
		$data['response'] = $this->input->post();
		
		$this->load->view('rozarpay/verify_gift', $data);
	}
	public function Download()
	{		
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Company_License_type = $session_data['Company_License_type'];
			$Create_user_id = $data['enroll'];
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$enroll_country_id = $enroll_details->Country;
			
			$Todays_date = date('Y-m-d');
				
			$Company_id = $_REQUEST['Company_id'];
			$Payment_id = $_REQUEST['Payment_id'];
			
			$data['Payment_details'] = $this->Saas_model->Get_payment_incoice_details($Payment_id,$Company_id);
			if($data['Payment_details'] != Null)
			{	
				if($data['Payment_details']->Payment_status =="captured")
				{
					$Enrollement_id = $data['Payment_details']->Enrollement_id;
					
					$enroll_details = $this->Igain_model->get_enrollment_details($Enrollement_id);
					$data['LogginUserName'] = $enroll_details->First_name.' '.$enroll_details->Last_name;
					
					$Payment_email = $data['Payment_details']->Payment_email;
					
					$Billing_country_name = $data['Payment_details']->Country_name;
					$Invoice_no = $data['Payment_details']->Bill_no;
					
					$date1=date_create($data['Payment_details']->Bill_date);
					$data['Invoice_date'] = date_format($date1,"d-M-Y");
					
					if($Billing_country_name == "India")
					{
						$data["Symbol_currency"] = "INR";
						$Currency_alies = "INDIAN RUPEES";
					}
					else
					{
						$data["Symbol_currency"] = "USD";
						$Currency_alies = "US DOLLAR";
					}
					
					
					$Bill_amaount_in_word = $this->convert_number($data['Payment_details']->Bill_amount);
					
					$data['Bill_amaount_in_word'] = $Currency_alies.' '.$Bill_amaount_in_word.' only';
					
					$Compnay_details = $this->Igain_model->get_company_details($Company_id);
	
					$data['Company_name'] = $Compnay_details->Company_name;	
					
					$data['Application_name'] = "E-Gifting Catalogue Account TopUp";
					
				/**********************************************************************/
					ob_start();
					$htmlBill = $this->load->view('Gift_payment/pdf_gifting_invoice', $data, true);
					// echo $htmlBill; 
					
					$Bill_filename = $data['Company_name'].'_'.$Invoice_no.'_'.date('Y_m_d_H_i_s');
					
					$billing_file_path = "";
					
					$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
					 
					$pdf = new mPDF();
					$pdf->SetWatermarkText('DUPLICATE');
					$pdf->showWatermarkText = true;
					$pdf->showImageErrors = true;
					$pdf->WriteHTML($htmlBill);
					$pdf->Output($Bill_filename . '.pdf', 'D');
					  /*unset($pdf);
					  die; */
					// $pdf->setFooter('{PAGENO}');
					$billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Gifting_Catalogue_Duplicate_billing_files/' . $Bill_filename . '.pdf', 'F');
					$pdf->Output($DOCUMENT_ROOT . '/export/Gifting_Catalogue_Duplicate_billing_files/' . $Bill_filename . '.pdf', 'F');
					$billing_file_path = $DOCUMENT_ROOT . '/export/Gifting_Catalogue_Duplicate_billing_files/' . $Bill_filename . '.pdf';
					unset($pdf);
				/**********************************************************************/
				}
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= " " . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }
	function convert_currency($Currency) 
    {
        $app_id = '16c61d8288c841fcb2e2e3cce34eed73';
		$oxr_url = "https://openexchangerates.org/api/latest.json?app_id=" . $app_id;

		// Open CURL session:
		$ch = curl_init($oxr_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Get the data:
		$json = curl_exec($ch);
		curl_close($ch);

		// Decode JSON response:
		$oxr_latest = json_decode($json);
		
		return $oxr_latest->rates->$Currency;
    }	
}
?>