<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Generate_Invoice extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('pagination');
      $this->load->database();
      $this->load->helper('url');
      $this->load->model('Data_transform/Data_transform_model');
      $this->load->model('Igain_model');
      $this->load->library('Send_notification');
      $this->load->model('Generate_invoice/Generate_invoice_model');
	  $this->load->model('Generate_invoice/Generate_debit_trans_invoice_model');
      $this->load->model('Coal_transactions/Coal_Transactions_model');
      $this->load->library("excel");
      $this->load->library('m_pdf');
      $this->load->helper('file');
    }

    public function index() {
		
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $data['Logged_user_id'] = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details2 = $data["Company_details"];
        $get_sellers = $this->Generate_debit_trans_invoice_model->get_company_sellers($Company_id);
        $data['Seller_array'] = $get_sellers;
        $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
        $Super_Seller_pin = $Super_Seller->pinno;
        $Country_id = $Super_Seller->Country_id;

        $currency_details = $this->Igain_model->Get_Country_master($Country_id);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;



        // if($data['Super_seller'] == 1 )
        // {
          // $data["Seller_array"] =$get_sellers;
        // }
        // else
        // {
          // $data["Seller_array"] = $this->Igain_model->get_seller_details($data['enroll']);
        // }



        if ($_POST == NULL) {
          /* -----------------------Pagination--------------------- */
          $config = array();
          $config["base_url"] = base_url() . "/index.php/Generate_Invoice/index";
          $total_row = $this->Generate_invoice_model->generated_bill_count($Company_id,$data['Super_seller'],$data['enroll']);
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

          $data["InvoiceDetails"] = $this->Generate_invoice_model->get_generated_bill_details($config["per_page"], $page, $Company_id,$data['Super_seller'],$data['enroll']);

          $data["pagination"] = $this->pagination->create_links();

          $this->load->view("Generate_Invoice/Generate_Invoice", $data);
		  
        } else {
			
			// print_r($_POST);
			
          if (isset($_POST['submit'])) {

		
            // echo"---Invoice_details----";
            $Company_id = $this->input->post('Company_id');
            $Seller_id = $this->input->post('Seller_id');
            $from_Date = date('Y-m-d H:i:s', strtotime($this->input->post('from_Date')));
            $till_Date = date('Y-m-d H:i:s', strtotime($this->input->post('till_Date')));

			$DropBillingTable = $this->Data_transform_model->DropBillingTable($Seller_id);
			
			
			
            $user_details = $this->Igain_model->get_enrollment_details($Seller_id);
            $Seller_id = $user_details->Enrollement_id;
            $Seller_Billingratio = $user_details->Seller_Billingratio;

            $data['Invoice_details'] = $this->Generate_invoice_model->get_invoice_data($Company_id, $Seller_id, $from_Date, $till_Date, $Seller_Billingratio,$data['Super_seller']);

				// echo"---Invoice_details----";
				// print_r($data['Invoice_details']);

            $this->load->view("Generate_Invoice/Generate_Invoice", $data);
          }
          if (isset($_POST['Generate_Invoice'])) {
				// echo"<pre>";
				// echo"---Generate_Invoice----";

			 // $Trans_id = $this->input->post('Trans_id');
			 
			 
			$TransIDArray = $this->input->post('TransIDArray');
			$Loyalty_pts_array=array();
			$Purchase_amount_array=array();
			$Bill_no_array=array();
			// print_r($TransIDArray);
			
			foreach($TransIDArray as $key => $value) {
						
				$TransArray=json_decode($value,true);
				$Trans_id_Count=count($TransArray);
				$Success_row=count($TransArray);
				$Total_row=count($TransArray);
				//echo"---Trans_id_Count----".$Trans_id_Count."--<br>";
				for($i=0; $i< $Trans_id_Count; $i++) {
					
					$Trans_id_array=explode("_",$TransArray[$i]["Details"]);
					//print_r($TransIDArray);
					$Trans_id = $Trans_id_array[0];
					$seller_id = $Trans_id_array[1];
					$Card_id = $Trans_id_array[2];
					$Purchase_amount_array[] = $Trans_id_array[3];
					$Loyalty_pts = $Trans_id_array[4];
					$Loyalty_pts_array[] = $Trans_id_array[4];
					$Bill_no_array[] = $Trans_id_array[5];	
					
					// echo"---seller_id----".$seller_id."--<br>";
					
					$user_details = $this->Igain_model->get_enrollment_details($seller_id);
					$seller_id = $user_details->Enrollement_id;
					$Purchase_Bill_no = $user_details->Purchase_Bill_no;
					$Seller_Billingratio = $user_details->Seller_Billingratio;
					$Seller_Billing_Bill_no = $user_details->Seller_Billing_Bill_no;
					$Bill_tax = $user_details->Merchant_sales_tax;
					$Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
					$Seller_pin = $user_details->pinno;
					$Seller_email_id = App_string_decrypt($user_details->User_email_id);
					$Seller_Country_id = $user_details->Country_id;


					$logtimezone = $user_details->timezone_entry;
					$timezone = new DateTimeZone($logtimezone);
					$date = new DateTime();
					$date->setTimezone($timezone);
					$lv_date_time = $date->format('Y-m-d H:i:s');
					$Todays_date = $date->format('Y-m-d H:i:s');


					$tp_db_bill = $Seller_Billing_Bill_no;
					$len_bill = strlen($tp_db_bill);
					$str_bill = substr($tp_db_bill, 0, 5);
					$billing_bill = substr($tp_db_bill, 5, $len_bill);
					$Transaction_details = $this->Generate_invoice_model->Update_trasnaction_bill_flag($Company_id, $Trans_id, $seller_id, $billing_bill);
				}				
			}
			
			// echo"---Success_row----".$Success_row."--<br>";
			// echo"---Total_row----".$Total_row."--<br>";			
			// die;
            
			/*  foreach ($Trans_id as $Transid) {
			   
              $TransID = $Transid;
              //echo"---TransID----".$TransID."--<br>";
              $Trans_id_array = explode("_", $TransID);
              $Trans_id = $Trans_id_array[0];
              $seller_id = $Trans_id_array[1];
              $Card_id = $Trans_id_array[2];
              $Purchase_amount_array[] = $Trans_id_array[3];
              $Loyalty_pts = $Trans_id_array[4];
              $Loyalty_pts_array[] = $Trans_id_array[4];
              // $Loyalty_topup_array[] = $Trans_id_array[5];
              $Bill_no_array[] = $Trans_id_array[5];

              $user_details = $this->Igain_model->get_enrollment_details($seller_id);
              $seller_id = $user_details->Enrollement_id;
              $Purchase_Bill_no = $user_details->Purchase_Bill_no;
              $Seller_Billingratio = $user_details->Seller_Billingratio;
              $Seller_Billing_Bill_no = $user_details->Seller_Billing_Bill_no;
              $Bill_tax = $user_details->Merchant_sales_tax;
              $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
              $Seller_pin = $user_details->pinno;
              $Seller_email_id = $user_details->User_email_id;
              $Seller_Country_id = $user_details->Country_id;
              $logtimezone = $user_details->timezone_entry;
              $timezone = new DateTimeZone($logtimezone);
              $date = new DateTime();
              $date->setTimezone($timezone);
              $lv_date_time = $date->format('Y-m-d H:i:s');
              $Todays_date = $date->format('Y-m-d H:i:s');
              $tp_db_bill = $Seller_Billing_Bill_no;
              $len_bill = strlen($tp_db_bill);
              $str_bill = substr($tp_db_bill, 0, 5);
              $billing_bill = substr($tp_db_bill, 5, $len_bill);
              $Transaction_details = $this->Generate_invoice_model->Update_trasnaction_bill_flag($Company_id, $Trans_id, $seller_id, $billing_bill);
                /* // $get_trasnaction_byID->
                echo"---Trans_id----".$Trans_id."--<br>";
                echo"---seller_id----".$seller_id."--<br>";
                echo"---Card_id----".$Card_id."--<br>";
                // echo"---Purchase_amount----".$Purchase_amount."--<br>";
                // echo"---Loyalty_pts----".$Loyalty_pts."--<br>";
                echo"<br>----***********************--<br>"; 
            }			
			die; */

            $billing_bill_no = $billing_bill + 1;
            $billing_billno_withyear = $str_bill . $billing_bill_no;
            $result4 = $this->Coal_Transactions_model->update_billing_billno($seller_id, $billing_billno_withyear);

            $total_coins_issued1 = array_sum($Loyalty_pts_array);
            // $total_coins_issued2 = array_sum($Loyalty_topup_array);
            $total_Bill_purchased_amt=array_sum($Purchase_amount_array);
            // $total_coins_issued= $total_coins_issued1 +$total_coins_issued2;
            $total_coins_issued = $total_coins_issued1;
            $sub_total = ($total_coins_issued * $Seller_Billingratio);
            $tax_amout = ($sub_total * $Bill_tax) / 100;
            $total_grand_amt = $sub_total + $tax_amout;

			/* print_r($Bill_no_array);
			echo"--Seller_Billingratio---".$Seller_Billingratio."---<br>";
            echo"--Bill_tax---".$Bill_tax."---<br>";
            echo"--Loyalty_pts_array---".$total_coins_issued1."---<br>";
            echo"--Loyalty_topup_array---".$total_coins_issued2."---<br>";
            echo"--total_coins_issued---".$total_coins_issued."---<br>";
            echo"--sub_total---".$sub_total."---<br>";
            echo"--tax_amout---".$tax_amout."---<br>";
            echo"--total_grand_amt---".$total_grand_amt."---<br>"; */ 

            $city_state_country = $this->Igain_model->Fetch_city_state_country($Company_id, $seller_id);
            $Company_city_state_country = $this->Igain_model->Company_city_state_country($Company_id);

            $Bill_File_name = 'GenerateInvoice';

            $data['Bill_File_name'] = $Bill_File_name;
            $FilenameAnnexure = $seller_id . 'ANNEXURE_' . date('Y_m_d_H_i_s') . '_' . $billing_bill;
            $Export_file_name = $seller_id . "Billing-File";
            $data['Seller_name'] = $Seller_name;
            $data['Current_address'] = $user_details->Current_address;
            $data['City_name'] = $city_state_country->City_name;
            $data['State_name'] = $city_state_country->State_name;
            $data['Country_name'] = $city_state_country->Country_name;
            $data['Company_City_name'] = $Company_city_state_country->City_name;
            $data['Company_State_name'] = $Company_city_state_country->State_name;
            $data['Company_Country_name'] = $Company_city_state_country->Country_name;
            $data['Zipcode'] = $user_details->Zipcode;
            $data['User_email_id'] = App_string_decrypt($user_details->User_email_id);
            $data['Phone_no'] = App_string_decrypt($user_details->Phone_no);
            $data['Merchant_sales_tax'] = $user_details->Merchant_sales_tax;
            $data['seller_id'] = $seller_id;
            $data['billing_bill_no'] = $billing_bill;



            $data['billing_bill_no'] = $billing_bill;
            $data['Company_logo'] = base_url() . $company_details2->Company_logo;


            $data['Seller_billing_records'] = $this->Data_transform_model->Fetch_billing_customer_records_2($seller_id, $Bill_no_array);

            $Annexure_file_path = "";

            $htmlAnnexure = $this->load->view('Data_transform/pdf_seller_Annexure_records', $data, true);


            // echo $htmlAnnexure;

            $pdf = new mPDF();

            $pdf->setFooter('{PAGENO}');

            $pdf->setAutoTopMargin = 'pad';

            $pdf->SetHTMLHeader('<header class="clearfix"><h1>ANNEXURE</h1><div id="project"><div><span>INVOICE: </span> ' . $billing_bill . '</div><div><span>Merchant ID: </span> ' . $seller_id . '</div><div><span>Name: </span> ' . $Seller_name . '</div><div><span>Date: </span>' . date("j, F Y h:i:s A") . '</div></div></header> <br><br>', '', true);

            $pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);

            $pdf->WriteHTML($htmlAnnexure);



            $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->config->item('APP_NAME');
			//base_url()
            $Annexure_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $FilenameAnnexure . '.pdf', 'F');
            $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $FilenameAnnexure . '.pdf', 'F');
            $Annexure_file_path = $DOCUMENT_ROOT . '/export/Seller_billing_files/' . $FilenameAnnexure . '.pdf';
            unset($pdf);

            /*------------------------------------------Send Billing File---------------------------------------------- */

            $total_coins_issued_arr = array();
            $Topup_amount_arr = array();
            $Bill_purchased_amount_arr = array();
            $data['Seller_billing_records12'] = $this->Data_transform_model->Fetch_billing_customer_records_2($seller_id, $Bill_no_array);

            foreach ($data['Seller_billing_records12'] as $bill_record) {

              $total_coins_issued_arr[] = $bill_record->Loyalty_pts;
              // $Topup_amount_arr[] = $bill_record->Topup_amount;
              $Bill_purchased_amount_arr[] = $bill_record->Bill_purchsed_amount;
            }

          //  $total_Bill_purchased_amt = array_sum($Bill_purchased_amount_arr);



              // echo"----total_coins_issued-----".$total_coins_issued."---<br>";
            $data['billing_bill_no'] = $billing_bill;
            $data['Company_logo'] = base_url() . $company_details2->Company_logo;

            $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
            $Symbol_currency = $currency_details->Symbol_of_currency;

            $data['Seller_name'] = $Seller_name;
            $data['Current_address'] = $user_details->Current_address;

            $data['City_name'] = $city_state_country->City_name;
            $data['State_name'] = $city_state_country->State_name;
            $data['Country_name'] = $city_state_country->Country_name;

            $data['Company_City_name'] = $Company_city_state_country->City_name;
            $data['Company_State_name'] = $Company_city_state_country->State_name;
            $data['Company_Country_name'] = $Company_city_state_country->Country_name;
            $data['Company_primary_contact_person'] = $company_details2->Company_primary_contact_person;
            $data['Company_contactus_email_id'] = $company_details2->Company_contactus_email_id;
            $data['Company_primary_phone_no'] = $company_details2->Company_primary_phone_no;

            $data['Zipcode'] = $user_details->Zipcode;
            $data['User_email_id'] = $user_details->User_email_id;
            $data['Phone_no'] = $user_details->Phone_no;
            $data['Merchant_sales_tax'] = $user_details->Merchant_sales_tax;
			$data['Error_row']= 0;
            $data['Total_row'] = $Total_row;
            $data['Success_row'] = $Success_row;
            $data['Error_row'] = $Total_row-$Success_row;
            // $data['total_coins_issued'] = round(array_sum($total_coins_issued_arr)) + round( array_sum($Topup_amount_arr));
            // $data['total_coins_issued'] = round(array_sum($total_coins_issued_arr));
            $data['total_coins_issued'] = round($total_coins_issued);
            $data['Seller_Billingratio'] = $Seller_Billingratio;
            $data['seller_id'] = $seller_id;
            $data['Symbol_currency'] = $Symbol_currency;

            $Bill_File_name = 'GenerateInvoice';
            $billing_file_path = "";
            $data['Bill_File_name'] = $Bill_File_name;
            $Bill_filename = $seller_id . 'INVOICE_' . date('Y_m_d_H_i_s') . '_' . $billing_bill;
            $Export_file_name = $seller_id . "Billing-File";

            $htmlBill = $this->load->view('Data_transform/pdf_seller_billing_records', $data, true);

            // echo $htmlBill;

            $pdf = new mPDF();
            $pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);

            $pdf->WriteHTML($htmlBill);

            $pdf->setFooter('{PAGENO}');

            $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->config->item('APP_NAME');


            $billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $Bill_filename . '.pdf', 'F');
            $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $Bill_filename . '.pdf', 'F');
            $billing_file_path = $DOCUMENT_ROOT . '/export/Seller_billing_files/' . $Bill_filename . '.pdf';
            unset($pdf);

            /* ------------------------------------------Send Billing File---------------------------------------------- */

            $insertBill = array(
                'Company_id' => $Company_id,
                'Seller_id' => $seller_id,
                'Bill_no' => $billing_bill,
                'Bill_purchased_amount' => $total_Bill_purchased_amt,
                'Bill_tax' => $Bill_tax,
                'Bill_rate' => $Seller_Billingratio,
                'Bill_amount' => $total_grand_amt,
                'Rows_Processed' => $Success_row,
                'Joy_coins_issued' => $total_coins_issued,
                'Merchant_publisher_type' => 52,
                'Bill_flag' => 1,
                'Settlement_flag' => 0,
                'Created_user_id' => $Logged_user_enrollid,
                'Creation_date' => $Todays_date
            );
            //print_r($insertBill);
            $result4 = $this->Data_transform_model->Insert_merchant_bill_data($insertBill);
            // $Todays_date=date('Y-m-d');


            $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
            $Company_finance_email_id = $company_details2->Company_finance_email_id;
            $Error_row = 0;
            $error_file_path = "";

            $Email_content = array(
                'Todays_date' => $Todays_date,
                'Seller_name' => $Seller_name,
                'Seller_email_id' => $Seller_email_id,
                'Company_finance_email_id' => $Company_finance_email_id,
                'Total_Number_Rows_Processed' => $Total_row,
                'Rows_Processed_Successfully' => $Success_row,
                'Rows_with_Errors' => $Error_row,
                'filename' => $File_name,
                'billing_bill_no' => $billing_bill,
                'total_grand_amt' => $total_grand_amt,
                'Symbol_currency' => $Symbol_currency,
                'error_file_path' => $error_file_path,
                'Annexure_file_path' => $Annexure_file_path,
                'billing_file_path' => $billing_file_path,
                // 'Notification_type' => 'Error Annexure and Bill File of '.$Seller_name.' processed on '.$Todays_date,
                'Notification_type' => 'Invoice ' . $billing_bill . ' Transaction Processed on ' . $Todays_date,
                'Template_type' => 'Merchant_Error_Annexure_billing_File'
            );

            $Notification = $this->send_notification->send_Notification_email('', $Email_content, $seller_id, $Company_id);

            $DropBillingTable = $this->Data_transform_model->DropBillingTable($seller_id);

            /*******************Insert igain Log Table*********************/
            $session_data = $this->session->userdata('logged_in');
            $get_seller = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Enrollement_id = $get_seller->Enrollement_id;
            $First_name = $get_seller->First_name;
            $Last_name = $get_seller->Last_name;
            $session_data = $this->session->userdata('logged_in');
            $Company_id = $session_data['Company_id'];
            $Todays_date = $Todays_date;
            $opration = 1;
            $enroll = $data['enroll'];
            $username = $session_data['username'];
            $userid = $session_data['userId'];
            $what = "Generate Invoice";
            $where = "Master - Generate Invoice";
            $toname = "";
            $To_enrollid = $seller_id;
            $firstName = $user_details->First_name;
            $lastName = $user_details->Last_name;
            $Seller_name = $session_data['Full_name'];
            $opval = 'Generate Invoice';

            $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $enroll, $username, $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $To_enrollid);

            /*******************Insert igain Log Table*********************/

            $this->session->set_flashdata("success_code", "Generate Invoice Successfuly!!");
			redirect('Generate_Invoice/index', 'refresh');
          }
        }
      } else {
        redirect('Login', 'refresh');
      }
    }
    public function DownloadInvoice() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details2 = $data["Company_details"];
        $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
        $Super_Seller_pin = $Super_Seller->pinno;
        $Country_id = $Super_Seller->Country_id;

        $data["InvoiceDetails"] = $this->Generate_invoice_model->get_generated_bill_details('', '', $Company_id,$data['Super_seller'],$data['enroll']);
        $currency_details = $this->Igain_model->Get_Country_master($Country_id);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
        $Symbol_currency = $currency_details->Symbol_of_currency;

        $Bill_id = $_GET['Bill_id'];
        $Bill_no = $_GET['Bill_no'];
        $flag = $_GET['flag'];
        $seller_id = $_GET['Seller_id'];
        if ($Bill_id != "" && $Bill_no != "" && $flag != "" && $seller_id != "") {

          // echo"GenerateInvoiceCopy";
          $data['Company_logo'] = base_url() . $company_details2->Company_logo;

          $user_details = $this->Igain_model->get_enrollment_details($seller_id);
          $seller_id = $user_details->Enrollement_id;
          $Purchase_Bill_no = $user_details->Purchase_Bill_no;
          $Seller_Billingratio = $user_details->Seller_Billingratio;
          $Seller_Billing_Bill_no = $user_details->Seller_Billing_Bill_no;
          $Bill_tax = $user_details->Merchant_sales_tax;
          $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
          $Seller_pin = $user_details->pinno;
          $Seller_email_id = $user_details->User_email_id;
          $Seller_Country_id = $user_details->Country_id;


          $city_state_country = $this->Igain_model->Fetch_city_state_country($Company_id, $seller_id);
          $Company_city_state_country = $this->Igain_model->Company_city_state_country($Company_id);


          if ($flag == 0) { //Invoice

            /* ------------------------------------------Send Billing File---------------------------------------------- */



            $Generated_invoice = $this->Generate_invoice_model->get_generated_invoice($Bill_id, $seller_id, $Bill_no, $Company_id);

            $total_coins_issued_arr = $Generated_invoice->Loyalty_pts;
            $Bill_purchased_amount_arr = $Generated_invoice->Bill_purchsed_amount;
            $total_coins_issued = $Generated_invoice->Joy_coins_issued;

            $Bill_flag = $Generated_invoice->Bill_flag;
            $Settlement_flag = $Generated_invoice->Settlement_flag;


            // echo"----Settlement_flag-----".$Settlement_flag."---<br>";
            // echo"----Rows_Processed-----". $Generated_invoice->Rows_Processed."---<br>";

            $data['Settlement_flag'] = $Settlement_flag;
            $data['total_coins_issued'] = $total_coins_issued;
            $data['Seller_Billingratio'] = $Seller_Billingratio;
            $data['Total_row'] = $Generated_invoice->Rows_Processed;
            // $data['Success_row'] = $Generated_invoice->Rows_Processed;
            $data['billing_bill_no'] = $Bill_no;
            $data['Seller_name'] = $Seller_name;
            $data['Current_address'] = $user_details->Current_address;
            $data['City_name'] = $city_state_country->City_name;
            $data['State_name'] = $city_state_country->State_name;
            $data['Country_name'] = $city_state_country->Country_name;
            $data['Company_City_name'] = $Company_city_state_country->City_name;
            $data['Company_State_name'] = $Company_city_state_country->State_name;
            $data['Company_Country_name'] = $Company_city_state_country->Country_name;
            $data['Company_primary_contact_person'] = $company_details2->Company_primary_contact_person;
            $data['Company_contactus_email_id'] = $company_details2->Company_contactus_email_id;
            $data['Company_primary_phone_no'] = $company_details2->Company_primary_phone_no;
            $data['Zipcode'] = $user_details->Zipcode;
            $data['User_email_id'] = $user_details->User_email_id;
            $data['Phone_no'] = $user_details->Phone_no;
            $data['Merchant_sales_tax'] = $user_details->Merchant_sales_tax;
            $data['seller_id'] = $seller_id;
            $data['Symbol_currency'] = $Symbol_currency;




            $billing_file_path = "";

            $Bill_filename = $seller_id . '-billing-Duplicate-' . date('Y_m_d_H_i_s');
            $Export_file_name = $seller_id . "Billing-File";

            $htmlBill = $this->load->view('Data_transform/pdf_seller_billing_records_true_copy', $data, true);

            // echo $htmlBill;

            $pdf = new mPDF();
            $pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);



            $pdf->SetWatermarkText('DUPLICATE');
            $pdf->showWatermarkText = true;

            $pdf->setFooter('{PAGENO}');



            $pdf->WriteHTML($htmlBill);
            $pdf->Output($Bill_filename . '.pdf', 'D');
            unset($pdf);

            /* ------------------------------------------Send Billing File---------------------------------------------- */
          } else {  //Annexure
            $data['Annexure_Data'] = $this->Generate_invoice_model->get_annexure_Details($Bill_id, $seller_id, $Bill_no, $Company_id);



            $FilenameAnnexure = $seller_id . 'ANNEXURE_' . date('Y_m_d_H_i_s') . '_' . $Bill_no;

            $Annexure_file_path = "";

            $htmlAnnexure = $this->load->view('Data_transform/pdf_seller_Annexure_records_duplicate', $data, true);


            // echo $htmlAnnexure;

            $pdf = new mPDF();

            $pdf->setFooter('{PAGENO}');
            $pdf->SetWatermarkText('DUPLICATE');
            $pdf->showWatermarkText = true;

            $pdf->setAutoTopMargin = 'pad';

            $pdf->SetHTMLHeader('<header class="clearfix"><h1>ANNEXURE</h1><div id="project"><div><span>INVOICE: </span> ' . $Bill_no . '</div><div><span>Merchant ID: </span> ' . $seller_id . '</div><div><span>Name: </span> ' . $Seller_name . '</div><div><span>Date: </span>' . date("j, F Y h:i:s A") . '</div></div></header> <br><br>', '', true);
            $pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);
            $pdf->WriteHTML($htmlAnnexure);
            $pdf->Output($FilenameAnnexure . '.pdf', 'D');
            unset($pdf);
          }
        } else {

          $this->load->view("Generate_Invoice/Generate_Invoice", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

  }
