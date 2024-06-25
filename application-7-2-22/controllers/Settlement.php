<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Settlement extends CI_Controller {

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
      $this->load->model('Generate_invoice/Settlement_model');
      $this->load->model('Generate_invoice/Generate_debit_trans_invoice_model');
      $this->load->model('Coal_transactions/Coal_Transactions_model');
      $this->load->model('Reconsolation_data/Reconsolation_data_map');
      $this->load->library("excel");
      $this->load->library('m_pdf');
      $this->load->helper('file');
    }

    public function Merchant_settlement() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $data['Logged_user_id'] = $Logged_user_id;
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details2 = $data["Company_details"];
        $Company_finance_email_id = $company_details2->Company_finance_email_id;
        $get_sellers = $this->Generate_debit_trans_invoice_model->get_company_sellers($Company_id);
        $data['Seller_array'] = $get_sellers;
        $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
        $Super_Seller_pin = $Super_Seller->pinno;
        $Country_id = $Super_Seller->Country_id;

        $Payment = $this->Igain_model->get_payement_type();
        $data['Payment_array'] = $Payment;


        $currency_details = $this->Igain_model->Get_Country_master($Country_id);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        $logtimezone = $session_data['timezone_entry'];
        ;
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d H:i:s');

        if ($_POST == NULL) {

          $this->load->view("Generate_Invoice/merchant_settlement", $data);
        } else {
          if (isset($_POST['submit'])) {
            $Company_id = $this->input->post('Company_id');
            $Seller_id = $this->input->post('Seller_id');
            $from_Date = date('Y-m-d 00:00:00', strtotime($this->input->post('from_Date')));
            $till_Date = date('Y-m-d 23:59:59', strtotime($this->input->post('till_Date')));
            /* -----------------------Pagination--------------------- */
            $config = array();
            $config["base_url"] = base_url() . "/index.php/Settlement/Merchant_settlement";
            $total_row = $this->Settlement_model->generated_seller_bill_count($Company_id, $Seller_id, $from_Date, $till_Date);
            // echo "total_row ".$total_row;
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

            $data["GeneratedSellerBill"] = $this->Settlement_model->get_generated_seller_bill_details($config["per_page"], $page, $Company_id, $Seller_id, $from_Date, $till_Date);
            $data["pagination"] = $this->pagination->create_links();
            $this->load->view("Generate_Invoice/merchant_settlement", $data);
          }
          if (isset($_POST['Processed_Settlement'])) {
			  
			/* echo"<pre>";  
			print_r($_POST);
			die; */
			
			
			
            $Settlement_amount = 0;
            $BillID = $this->input->post('Bill_id');
            $Payment_type = $this->input->post('Payment_type');
            $Bank_name = $this->input->post('Bank_name');
            $Branch_name = $this->input->post('Branch_name');
            $Credit_Cheque_number = $this->input->post('Credit_Cheque_number');
            $Remarks = $this->input->post('Remarks');
			
			
            $BillIDArray = $this->input->post('BillIDArray');
			print_r($BillIDArray);
			foreach($BillIDArray as $key => $value) {
						
				$TransArray=json_decode($value,true);
				$Trans_id_Count=count($TransArray);
				for($i=0; $i< $Trans_id_Count; $i++) {					
					
					$Bill_id_arry=explode("_",$TransArray[$i]["Details"]);					
					$Bill_id = $Bill_id_arry[0];
					$Seller_id = $Bill_id_arry[1];
					$Bill_no = $Bill_id_arry[2];
					
					$Paid_amount = $TransArray[$i]["PaidAMT"];
					$Bill_amount = $TransArray[$i]["BillAMT"];
					
					// echo"----Bill_id----".$Bill_id."---Seller_id--".$Seller_id."---Bill_no--".$Bill_no."---Bill_amount--".$Bill_amount."---Paid_amount--".$Paid_amount."---<br>";
					
					
					
						$Paid_amount_new =  $Paid_amount;
						$Bill_amount_new =  $Bill_amount;

						$user_details = $this->Igain_model->get_enrollment_details($Seller_id);
						$Seller_email_id = $user_details->User_email_id;
						$Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

						if (!empty($Paid_amount_new)) {

						$get_bill_Details = $this->Settlement_model->Get_generated_bill_detilas($Company_id, $Bill_id, $Seller_id, $Bill_no);

						$Bill_purchased_amount =  $get_bill_Details->Bill_purchased_amount;
						$Existing_Bill_amount =  $get_bill_Details->Bill_amount;
						$Settlement_amount =  $get_bill_Details->Settlement_amount;
						$Bill_tax =  $get_bill_Details->Bill_tax;
						$Bill_rate =  $get_bill_Details->Bill_rate;
						$Invoice_date = $get_bill_Details->Creation_date;
						$From_bill_date = $get_bill_Details->From_bill_date;
						$To_bill_date = $get_bill_Details->To_bill_date;

						$New_paid_amount =$Paid_amount_new + $Settlement_amount;

						/* echo"<pre>--New_paid_amount--".$New_paid_amount."---<br>";
						echo"--Bill_amount_new--".$Bill_amount_new."---<br>";
						echo"--Existing_Bill_amount--1---".$Existing_Bill_amount."---<br>"; */
						
						//die;
						
						if (($New_paid_amount == $Existing_Bill_amount) && ($Bill_amount_new == $Existing_Bill_amount)) { //Full Paymnet
						
						   //echo"--Existing_Bill_amount--2---".$Existing_Bill_amount."---<br>";
						   
						  $update_total_bill = $this->Settlement_model->Update_total_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);


						//  echo"--Full Paymnet--".$this->db->last_query()."---<br>";
						  if ($update_total_bill == true) {

							$update_transaction_bill_data = $this->Settlement_model->Update_transaction_bill($Company_id, $Seller_id, $Bill_no, $Logged_user_enrollid, $Todays_date);

							if ($Bank_name == "") {

							  $Bank_name = "";
							} else {

							  $Bank_name = $Bank_name;
							}

							if ($Branch_name == "") {

							  $Branch_name = "";
							} else {

							  $Branch_name = $Branch_name;
							}

							$PaymentMethod = array(
								'Company_id' => $Company_id,
								'Merchant_publisher_type' => 52,
								'Seller_id' => $Seller_id,
								'Bill_no' => $Bill_no,
								'Bill_purchased_amount' => $Bill_purchased_amount,
								'Bill_tax' => $Bill_tax,
								'Bill_rate' => $Bill_rate,
								'Bill_amount' => $Existing_Bill_amount,
								'Paid_amount' => $Paid_amount_new,
								'Payment_type' => $Payment_type,
								'Bank_name' => $Bank_name,
								'Branch_name' => $Branch_name,
								'Credit_Cheque_number' => $Credit_Cheque_number,
								'Remarks' => $Remarks,
								'Created_user_id' => $Logged_user_enrollid,
								'Creation_date' => $Todays_date
							);

							$Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
							//  echo"--Full payment_method--".$this->db->last_query()."---<br>";
							

							/*                     * *****************Send Settlement Email******************** */
							$Remaining_amount = $Existing_Bill_amount - $New_paid_amount;
							if ($Remaining_amount > 0) {
							  $Status = 'Partial Settlement';
							} else {
							  $Status = 'Settled';
							}
							if ($Payment_type == 1) {
							  $Paid_by = 'Cash';
							} else if ($Payment_type == 2) {
							  $Paid_by = 'Cheque';
							} else if ($Payment_type == 3) {
							  $Paid_by = 'Credit Card';
							} else {
							  $Paid_by = '-';
							}

							$Notification_type = "Merchant Settlement";
							$Till_settlement = $Existing_Bill_amount - $Remaining_amount;
							$Email_content = array(
								'Today_date' => $Todays_date,
								'Seller_name' => $Seller_name,
								'Seller_email_id' => $Seller_email_id,
								'Company_finance_email_id' => $Company_finance_email_id,
								'Invoice_no' => $Bill_no,
								'Invoice_date' => date("d M Y", strtotime($Invoice_date)),
								'From_bill_date' => date("d M Y", strtotime($From_bill_date)),
								'To_bill_date' => date("d M Y", strtotime($To_bill_date)),
								'Invoice_amount' => $Existing_Bill_amount,
								'Till_settlement' => $Till_settlement,
								'Settlement_amount' => $Paid_amount_new,
								'Remaining_amount' => number_format($Remaining_amount),
								'Status' => $Status,
								'Symbol_currency' => $data["Symbol_currency"],
								'Paid_by' => $Paid_by,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Loyalty_transaction_settlement'
							);
							// print_r($Email_content);
							
							$this->send_notification->send_Notification_email($Seller_id, $Email_content, $Seller_id, $Company_id);

							/*                     * *****************Send Settlement Email******************** */
						  }
						} else { // Partiall Payment
						  
						 //  echo"--Existing_Bill_amount--3---".$Existing_Bill_amount."---<br>";
						 $update_total_bill = $this->Settlement_model->Update_partial_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);
						 // echo"--Partiall Paymnet--".$this->db->last_query()."---<br>";

						  if ($update_total_bill == true) {

							if ($Bank_name == "") {

							  $Bank_name = "";
							} else {

							  $Bank_name = $Bank_name;
							}

							if ($Branch_name == "") {

							  $Branch_name = "";
							} else {

							  $Branch_name = $Branch_name;
							}

							$PaymentMethod = array(
								'Company_id' => $Company_id,
								'Merchant_publisher_type' => 52,
								'Seller_id' => $Seller_id,
								'Bill_no' => $Bill_no,
								'Bill_purchased_amount' => $Bill_purchased_amount,
								'Bill_tax' => $Bill_tax,
								'Bill_rate' => $Bill_rate,
								'Bill_amount' => $Existing_Bill_amount,
								'Paid_amount' => $Paid_amount_new,
								'Payment_type' => $Payment_type,
								'Bank_name' => $Bank_name,
								'Branch_name' => $Branch_name,
								'Credit_Cheque_number' => $Credit_Cheque_number,
								'Remarks' => $Remarks,
								'Created_user_id' => $Logged_user_enrollid,
								'Creation_date' => $Todays_date
							);
							$Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
						   // echo"--Partiall payment_method--".$this->db->last_query()."---<br>";

							/*                     * *****************Send Settlement Email******************** */
							$Remaining_amount = $Existing_Bill_amount - $New_paid_amount;
							if ($Remaining_amount > 0) {
							  $Status = 'Partial Settlement';
							} else {
							  $Status = 'Settled';
							}

							if ($Payment_type == 1) {
							  $Paid_by = 'Cash';
							} else if ($Payment_type == 2) {
							  $Paid_by = 'Cheque';
							} else if ($Payment_type == 3) {
							  $Paid_by = 'Credit Card';
							} else {
							  $Paid_by = '-';
							}


							$Notification_type = "Merchant Settlement";
							$Till_settlement = $Existing_Bill_amount - $Remaining_amount;
							$Email_content1 = array(
								'Today_date' => $Todays_date,
								'Seller_name' => $Seller_name,
								'Seller_email_id' => $Seller_email_id,
								'Company_finance_email_id' => $Company_finance_email_id,
								'Invoice_no' => $Bill_no,
								'Invoice_date' => date("d M Y", strtotime($Invoice_date)),
								'From_bill_date' => date("d M Y", strtotime($From_bill_date)),
								'To_bill_date' => date("d M Y", strtotime($To_bill_date)),
								'Invoice_amount' => $Existing_Bill_amount,
								'Till_settlement' => $Till_settlement,
								'Settlement_amount' => $Paid_amount_new,
								'Remaining_amount' => number_format($Remaining_amount),
								'Status' => $Status,
								'Symbol_currency' => $data["Symbol_currency"],
								'Paid_by' => $Paid_by,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Loyalty_transaction_settlement'
							);
							 // print_r($Email_content1);
							$this->send_notification->send_Notification_email($Seller_id, $Email_content1, $Seller_id, $Company_id);

							/*******************Send Settlement Email*********************/
						  }
						}
					  }					
				}				
			}
			
			
            /* foreach ($BillID as $bill) {
				
              $Bill_id_arry = explode("_", $bill);
              $Bill_id = $Bill_id_arry[0];
              $Seller_id = $Bill_id_arry[1];
              $Bill_no = $Bill_id_arry[2];

              $Paid_amount = $this->input->post('Paid_amount_' . $Bill_no);
              $Bill_amount = $this->input->post('Bill_amount_' . $Bill_no);

              $Paid_amount_new =  $Paid_amount;
              $Bill_amount_new =  $Bill_amount;

              $user_details = $this->Igain_model->get_enrollment_details($Seller_id);
              $Seller_email_id = $user_details->User_email_id;
              $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

              if (!empty($Paid_amount_new)) {

                $get_bill_Details = $this->Settlement_model->Get_generated_bill_detilas($Company_id, $Bill_id, $Seller_id, $Bill_no);

                $Bill_purchased_amount =  $get_bill_Details->Bill_purchased_amount;
                $Existing_Bill_amount =  $get_bill_Details->Bill_amount;
                $Settlement_amount =  $get_bill_Details->Settlement_amount;
                $Bill_tax =  $get_bill_Details->Bill_tax;
                $Bill_rate =  $get_bill_Details->Bill_rate;
                $Invoice_date = $get_bill_Details->Creation_date;
                $From_bill_date = $get_bill_Details->From_bill_date;
                $To_bill_date = $get_bill_Details->To_bill_date;

                $New_paid_amount =$Paid_amount_new + $Settlement_amount;

             
                
                //die;
                
                if (($New_paid_amount == $Existing_Bill_amount) && ($Bill_amount_new == $Existing_Bill_amount)) { //Full Paymnet
                
                   //echo"--Existing_Bill_amount--2---".$Existing_Bill_amount."---<br>";
                   
                  $update_total_bill = $this->Settlement_model->Update_total_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);


                //  echo"--Full Paymnet--".$this->db->last_query()."---<br>";
                  if ($update_total_bill == true) {

                    $update_transaction_bill_data = $this->Settlement_model->Update_transaction_bill($Company_id, $Seller_id, $Bill_no, $Logged_user_enrollid, $Todays_date);

                    if ($Bank_name == "") {

                      $Bank_name = "";
                    } else {

                      $Bank_name = $Bank_name;
                    }

                    if ($Branch_name == "") {

                      $Branch_name = "";
                    } else {

                      $Branch_name = $Branch_name;
                    }

                    $PaymentMethod = array(
                        'Company_id' => $Company_id,
                        'Merchant_publisher_type' => 52,
                        'Seller_id' => $Seller_id,
                        'Bill_no' => $Bill_no,
                        'Bill_purchased_amount' => $Bill_purchased_amount,
                        'Bill_tax' => $Bill_tax,
                        'Bill_rate' => $Bill_rate,
                        'Bill_amount' => $Existing_Bill_amount,
                        'Paid_amount' => $Paid_amount_new,
                        'Payment_type' => $Payment_type,
                        'Bank_name' => $Bank_name,
                        'Branch_name' => $Branch_name,
                        'Credit_Cheque_number' => $Credit_Cheque_number,
                        'Remarks' => $Remarks,
                        'Created_user_id' => $Logged_user_enrollid,
                        'Creation_date' => $Todays_date
                    );

                    $Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
                    //  echo"--Full payment_method--".$this->db->last_query()."---<br>";
                    

                    /** *****************Send Settlement Email******************** *
                    $Remaining_amount = $Existing_Bill_amount - $New_paid_amount;
                    if ($Remaining_amount > 0) {
                      $Status = 'Partial Settlement';
                    } else {
                      $Status = 'Settled';
                    }
                    if ($Payment_type == 1) {
                      $Paid_by = 'Cash';
                    } else if ($Payment_type == 2) {
                      $Paid_by = 'Cheque';
                    } else if ($Payment_type == 3) {
                      $Paid_by = 'Credit Card';
                    } else {
                      $Paid_by = '-';
                    }

                    $Notification_type = "Merchant Settlement";
                    $Till_settlement = $Existing_Bill_amount - $Remaining_amount;
                    $Email_content = array(
                        'Today_date' => $Todays_date,
                        'Seller_name' => $Seller_name,
                        'Seller_email_id' => $Seller_email_id,
                        'Company_finance_email_id' => $Company_finance_email_id,
                        'Invoice_no' => $Bill_no,
                        'Invoice_date' => date("d M Y", strtotime($Invoice_date)),
                        'From_bill_date' => date("d M Y", strtotime($From_bill_date)),
                        'To_bill_date' => date("d M Y", strtotime($To_bill_date)),
                        'Invoice_amount' => $Existing_Bill_amount,
                        'Till_settlement' => $Till_settlement,
                        'Settlement_amount' => $Paid_amount_new,
                        'Remaining_amount' => number_format($Remaining_amount),
                        'Status' => $Status,
                        'Symbol_currency' => $data["Symbol_currency"],
                        'Paid_by' => $Paid_by,
                        'Notification_type' => $Notification_type,
                        'Template_type' => 'Loyalty_transaction_settlement'
                    );
                    // print_r($Email_content);
                    
                    $this->send_notification->send_Notification_email($Seller_id, $Email_content, $Seller_id, $Company_id);

                    /******************Send Settlement Email******************** *
                  }
                } else { // Partiall Payment
                  
                 //  echo"--Existing_Bill_amount--3---".$Existing_Bill_amount."---<br>";
                 $update_total_bill = $this->Settlement_model->Update_partial_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);
                 // echo"--Partiall Paymnet--".$this->db->last_query()."---<br>";

                  if ($update_total_bill == true) {

                    if ($Bank_name == "") {

                      $Bank_name = "";
                    } else {

                      $Bank_name = $Bank_name;
                    }

                    if ($Branch_name == "") {

                      $Branch_name = "";
                    } else {

                      $Branch_name = $Branch_name;
                    }

                    $PaymentMethod = array(
                        'Company_id' => $Company_id,
                        'Merchant_publisher_type' => 52,
                        'Seller_id' => $Seller_id,
                        'Bill_no' => $Bill_no,
                        'Bill_purchased_amount' => $Bill_purchased_amount,
                        'Bill_tax' => $Bill_tax,
                        'Bill_rate' => $Bill_rate,
                        'Bill_amount' => $Existing_Bill_amount,
                        'Paid_amount' => $Paid_amount_new,
                        'Payment_type' => $Payment_type,
                        'Bank_name' => $Bank_name,
                        'Branch_name' => $Branch_name,
                        'Credit_Cheque_number' => $Credit_Cheque_number,
                        'Remarks' => $Remarks,
                        'Created_user_id' => $Logged_user_enrollid,
                        'Creation_date' => $Todays_date
                    );
                    $Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
                   // echo"--Partiall payment_method--".$this->db->last_query()."---<br>";

                    /******************Send Settlement Email******************** *
                    $Remaining_amount = $Existing_Bill_amount - $New_paid_amount;
                    if ($Remaining_amount > 0) {
                      $Status = 'Partial Settlement';
                    } else {
                      $Status = 'Settled';
                    }

                    if ($Payment_type == 1) {
                      $Paid_by = 'Cash';
                    } else if ($Payment_type == 2) {
                      $Paid_by = 'Cheque';
                    } else if ($Payment_type == 3) {
                      $Paid_by = 'Credit Card';
                    } else {
                      $Paid_by = '-';
                    }


                    $Notification_type = "Merchant Settlement";
                    $Till_settlement = $Existing_Bill_amount - $Remaining_amount;
                    $Email_content1 = array(
                        'Today_date' => $Todays_date,
                        'Seller_name' => $Seller_name,
                        'Seller_email_id' => $Seller_email_id,
                        'Company_finance_email_id' => $Company_finance_email_id,
                        'Invoice_no' => $Bill_no,
                        'Invoice_date' => date("d M Y", strtotime($Invoice_date)),
                        'From_bill_date' => date("d M Y", strtotime($From_bill_date)),
                        'To_bill_date' => date("d M Y", strtotime($To_bill_date)),
                        'Invoice_amount' => $Existing_Bill_amount,
                        'Till_settlement' => $Till_settlement,
                        'Settlement_amount' => $Paid_amount_new,
                        'Remaining_amount' => number_format($Remaining_amount),
                        'Status' => $Status,
                        'Symbol_currency' => $data["Symbol_currency"],
                        'Paid_by' => $Paid_by,
                        'Notification_type' => $Notification_type,
                        'Template_type' => 'Loyalty_transaction_settlement'
                    );
                     // print_r($Email_content1);
                    $this->send_notification->send_Notification_email($Seller_id, $Email_content1, $Seller_id, $Company_id);

                    /*******************Send Settlement Email*********************
                  }
                }
              }
			} */

            $this->session->set_flashdata("success_code", "Merchant Settlement done Successfuly!!");
            redirect('Settlement/Merchant_settlement');
          }
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Merchant_debit_settlement() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $data['Logged_user_id'] = $Logged_user_id;
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['Sub_seller_Enrollement_id'] = $session_data['Sub_seller_Enrollement_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details2 = $data["Company_details"];
        $Company_finance_email_id = $company_details2->Company_finance_email_id;
        $get_sellers = $this->Generate_debit_trans_invoice_model->get_company_sellers($Company_id);
        $data['Seller_array'] = $get_sellers;
        $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
        $Super_Seller_pin = $Super_Seller->pinno;
        $Country_id = $Super_Seller->Country_id;
        $data['Company_Admin_id'] = $Super_Seller->Enrollement_id;

        $Payment = $this->Igain_model->get_payement_type();
        $data['Payment_array'] = $Payment;


        $currency_details = $this->Igain_model->Get_Country_master($Country_id);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        $logtimezone = $session_data['timezone_entry'];
        ;
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d H:i:s');

        if ($_POST == NULL) {
          $this->load->view("Generate_debit_invoice/merchant_settlement", $data);
        } else {
			
          if (isset($_POST['submit'])) {
			  
            $Company_id = $this->input->post('Company_id');
            $Seller_id = $this->input->post('Seller_id');
            $from_Date = date('Y-m-d 00:00:00', strtotime($this->input->post('from_Date')));
            $till_Date = date('Y-m-d 23:59:59', strtotime($this->input->post('till_Date')));
            /* -----------------------Pagination--------------------- */
            $config = array();
            $config["base_url"] = base_url() . "/index.php/Settlement/Merchant_debit_settlement";
            $total_row = $this->Settlement_model->generated_seller_debit_bill_count($Company_id, $Seller_id, $from_Date, $till_Date);
            // echo "total_row ".$total_row;
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

            $data["GeneratedSellerBill"] = $this->Settlement_model->get_generated_seller_debit_bill_details($config["per_page"], $page, $Company_id, $Seller_id, $from_Date, $till_Date);
            $data["pagination"] = $this->pagination->create_links();
            $this->load->view("Generate_debit_invoice/merchant_settlement", $data);
          }
          if (isset($_POST['Processed_Settlement'])) {
			  
			// echo"<pre>";
			// var_dump($_POST);
            $Settlement_amount = 0;
            // $BillID = $this->input->post('Bill_id');
            $Payment_type = $this->input->post('Payment_type');
            $Bank_name = $this->input->post('Bank_name');
            $Branch_name = $this->input->post('Branch_name');
            $Credit_Cheque_number = $this->input->post('Credit_Cheque_number');
            $Remarks = $this->input->post('Remarks');
			
			
			$BillIDArray = $this->input->post('BillIDArray');
			
			
			// print_r($BillIDArray);
			/* foreach($BillIDArray as $key => $value) {
						
				$TransArray=json_decode($value,true);
				$Trans_id_Count=count($TransArray);
				for($i=0; $i< $Trans_id_Count; $i++) {					
					
					$Bill_id_arry=explode("_",$TransArray[$i]["Details"]);					
					$Bill_id = $Bill_id_arry[0];
					$Seller_id = $Bill_id_arry[1];
					$Bill_no = $Bill_id_arry[2];
					
					$Paid_amount = $TransArray[$i]["PaidAMT"];
					$Bill_amount = $TransArray[$i]["BillAMT"];
					
					echo"----Bill_id----".$Bill_id."--<br>";
					echo"----Seller_id----".$Seller_id."--<br>";
					echo"----Bill_no----".$Bill_no."--<br>";
					echo"----Paid_amount----".$Paid_amount."--<br>";
					echo"----Bill_amount----".$Bill_amount."--<br>";
					echo"---*********************************************************--<br>";
					
				}
			} */

			
			// die;
			
			
					// foreach ($BillID as $bill) {
						
			foreach($BillIDArray as $key => $value) {
						
				$TransArray=json_decode($value,true);
				$Trans_id_Count=count($TransArray);
				for($i=0; $i< $Trans_id_Count; $i++) {					
					
					$Bill_id_arry=explode("_",$TransArray[$i]["Details"]);					
					$Bill_id = $Bill_id_arry[0];
					$Seller_id = $Bill_id_arry[1];
					$Bill_no = $Bill_id_arry[2];
					
					$Paid_amount = $TransArray[$i]["PaidAMT"];
					$Bill_amount = $TransArray[$i]["BillAMT"];
					
					/* echo"----Bill_id----".$Bill_id."--<br>";
					echo"----Seller_id----".$Seller_id."--<br>";
					echo"----Bill_no----".$Bill_no."--<br>";
					echo"----Paid_amount----".$Paid_amount."--<br>";
					echo"----Bill_amount----".$Bill_amount."--<br>";
					echo"---*********************************************************--<br>"; */
						
					  /* $Bill_id_arry = explode("_", $bill);
					  $Bill_id = $Bill_id_arry[0];
					  $Seller_id = $Bill_id_arry[1];
					  $Bill_no = $Bill_id_arry[2];

					  $Paid_amount = $this->input->post('Paid_amount_' . $Bill_no);
					  $Bill_amount = $this->input->post('Bill_amount_' . $Bill_no); */

					  $Paid_amount_new = (float) $Paid_amount;
					  $Bill_amount_new = (float) $Bill_amount;

					  $user_details = $this->Igain_model->get_enrollment_details($Seller_id);
					  $Seller_email_id = $user_details->User_email_id;
					  $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

					  if (!empty($Paid_amount_new)) {
						$get_bill_Details = $this->Settlement_model->Get_generated_bill_detilas($Company_id, $Bill_id, $Seller_id, $Bill_no);

						$Bill_purchased_amount = (float) $get_bill_Details->Bill_purchased_amount;
						$Existing_Bill_amount = (float) $get_bill_Details->Bill_amount;
						$Settlement_amount = (float) $get_bill_Details->Settlement_amount;
						$Bill_tax = (float) $get_bill_Details->Bill_tax;
						$Bill_rate = (float) $get_bill_Details->Bill_rate;
						$Invoice_date = $get_bill_Details->Creation_date;
						$From_bill_date = $get_bill_Details->From_bill_date;
						$To_bill_date = $get_bill_Details->To_bill_date;

						$New_paid_amount = (float) $Paid_amount_new + $Settlement_amount;


						if (abs($New_paid_amount == $Existing_Bill_amount) && abs($Bill_amount_new == $Existing_Bill_amount)) {  //Full Paymnet
						  $update_total_bill = $this->Settlement_model->Update_total_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);

						  if ($update_total_bill == true) {
							$update_transaction_bill_data = $this->Settlement_model->Update_debit_transaction_bill($Company_id, $Seller_id, $Bill_no, $Logged_user_enrollid, $Todays_date);

							if ($Bank_name == "") {

							  $Bank_name = "";
							} else {

							  $Bank_name = $Bank_name;
							}

							if ($Branch_name == "") {

							  $Branch_name = "";
							} else {

							  $Branch_name = $Branch_name;
							}

							$PaymentMethod = array(
								'Company_id' => $Company_id,
								'Merchant_publisher_type' => 54,
								'Seller_id' => $Seller_id,
								'Bill_no' => $Bill_no,
								'Bill_purchased_amount' => $Bill_purchased_amount,
								'Bill_tax' => $Bill_tax,
								'Bill_rate' => $Bill_rate,
								'Bill_amount' => $Existing_Bill_amount,
								'Paid_amount' => $Paid_amount_new,
								'Payment_type' => $Payment_type,
								'Bank_name' => $Bank_name,
								'Branch_name' => $Branch_name,
								'Credit_Cheque_number' => $Credit_Cheque_number,
								'Remarks' => $Remarks,
								'Created_user_id' => $Logged_user_enrollid,
								'Creation_date' => $Todays_date
							);
							$Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);

							/*                     * *****************Send Settlement Email******************** */
							$Remaining_amount = $Existing_Bill_amount - $New_paid_amount;
							if ($Remaining_amount > 0) {
							  $Status = 'Partial Settlement';
							} else {
							  $Status = 'Settled';
							}
							if ($Payment_type == 1) {
							  $Paid_by = 'Cash';
							} else if ($Payment_type == 2) {
							  $Paid_by = 'Cheque';
							} else if ($Payment_type == 3) {
							  $Paid_by = 'Credit Card';
							} else {
							  $Paid_by = '-';
							}

							$Notification_type = "Debit Transaction Settlement";
							$Till_settlement = $Existing_Bill_amount - $Remaining_amount;
							$Email_content = array(
								'Today_date' => $Todays_date,
								'Seller_name' => $Seller_name,
								'Seller_email_id' => $Seller_email_id,
								'Company_finance_email_id' => $Company_finance_email_id,
								'Invoice_no' => $Bill_no,
								'Invoice_date' => date("d M Y", strtotime($Invoice_date)),
								'From_bill_date' => date("d M Y", strtotime($From_bill_date)),
								'To_bill_date' => date("d M Y", strtotime($To_bill_date)),
								'Invoice_amount' => $Existing_Bill_amount,
								'Till_settlement' => $Till_settlement,
								'Settlement_amount' => $Paid_amount_new,
								'Remaining_amount' => $Remaining_amount,
								'Status' => $Status,
								'Symbol_currency' => $data["Symbol_currency"],
								'Paid_by' => $Paid_by,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Debit_trans_settlement'
							);

							$this->send_notification->send_Notification_email($Seller_id, $Email_content, $Seller_id, $Company_id);

							/*                     * *****************Send Settlement Email******************** */
						  }
						} else { // Partiall Payment
						  $update_total_bill = $this->Settlement_model->Update_partial_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);

						  if ($update_total_bill == true) {

							if ($Bank_name == "") {

							  $Bank_name = "";
							} else {

							  $Bank_name = $Bank_name;
							}

							if ($Branch_name == "") {

							  $Branch_name = "";
							} else {

							  $Branch_name = $Branch_name;
							}

							$PaymentMethod = array(
								'Company_id' => $Company_id,
								'Merchant_publisher_type' => 54,
								'Seller_id' => $Seller_id,
								'Bill_no' => $Bill_no,
								'Bill_purchased_amount' => $Bill_purchased_amount,
								'Bill_tax' => $Bill_tax,
								'Bill_rate' => $Bill_rate,
								'Bill_amount' => $Existing_Bill_amount,
								'Paid_amount' => $Paid_amount_new,
								'Payment_type' => $Payment_type,
								'Bank_name' => $Bank_name,
								'Branch_name' => $Branch_name,
								'Credit_Cheque_number' => $Credit_Cheque_number,
								'Remarks' => $Remarks,
								'Created_user_id' => $Logged_user_enrollid,
								'Creation_date' => $Todays_date
							);
							$Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);


							/*                     * *****************Send Settlement Email******************** */
							$Remaining_amount = $Existing_Bill_amount - $New_paid_amount;
							if ($Remaining_amount > 0) {
							  $Status = 'Partial Settlement';
							} else {
							  $Status = 'Settled';
							}

							if ($Payment_type == 1) {
							  $Paid_by = 'Cash';
							} else if ($Payment_type == 2) {
							  $Paid_by = 'Cheque';
							} else if ($Payment_type == 3) {
							  $Paid_by = 'Credit Card';
							} else {
							  $Paid_by = '-';
							}

							$Notification_type = "Debit Transaction Settlement";
							 $Till_settlement = $Existing_Bill_amount - $Remaining_amount;

							$Email_content = array(
								'Today_date' => $Todays_date,
								'Seller_name' => $Seller_name,
								'Seller_email_id' => $Seller_email_id,
								'Company_finance_email_id' => $Company_finance_email_id,
								'Invoice_no' => $Bill_no,
								'Invoice_date' => date("d M Y", strtotime($Invoice_date)),
								'From_bill_date' => date("d M Y", strtotime($From_bill_date)),
								'To_bill_date' => date("d M Y", strtotime($To_bill_date)),
								'Invoice_amount' => $Existing_Bill_amount, 
								'Till_settlement' => $Till_settlement, 
								'Settlement_amount' => $Paid_amount_new,
								'Remaining_amount' => $Remaining_amount, 
								'Status' => $Status,
								'Symbol_currency' => $data["Symbol_currency"],
								'Paid_by' => $Paid_by,
								'Notification_type' => $Notification_type,
								'Template_type' => 'Debit_trans_settlement'
							);
							$this->send_notification->send_Notification_email($Seller_id, $Email_content, $Seller_id, $Company_id);

							/*******************Send Settlement Email******************** */
						  }
						}
					  }
				  }
		  
			}
			
			
            $this->session->set_flashdata("success_code", "Merchant Debit Settlement done Successfuly!!");
            redirect('Settlement/Merchant_debit_settlement');
          }
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Publisher_settlement() {
		
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $data['Logged_user_id'] = $Logged_user_id;
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details2 = $data["Company_details"];
        $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
        $Super_Seller_pin = $Super_Seller->pinno;
        $Country_id = $Super_Seller->Country_id;

        $data['Pubblisher'] = $this->Reconsolation_data_map->get_publisher($Company_id);

        $Payment = $this->Igain_model->get_payement_type();
        $data['Payment_array'] = $Payment;


        $logtimezone = $session_data['timezone_entry'];
        ;
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d H:i:s');


        if ($_POST == NULL) {

          $this->load->view("Generate_Invoice/publisher_settlement", $data);
        } else {



          $Bill_no = $this->input->post('Bill_no');
          $publisher = $this->input->post('publisher');
          $from_date = date('Y-m-d 00:00:00', strtotime($this->input->post('from_date')));
          $till_Date = date('Y-m-d 23:59:59', strtotime($this->input->post('till_Date')));
          $Purchased_Miles = $this->input->post('Purchased_Miles');
          $Bill_purchased_amount = $this->input->post('Bill_purchased_amount');
          $Bill_amount = $this->input->post('Bill_amount');
          $Settlement_amount = $this->input->post('Bill_settlement_amount');
          $Bill_rate = $this->input->post('Bill_rate');
          $Bill_tax = $this->input->post('Bill_tax');
          $Payment_type = $this->input->post('Payment_type');
          $Bank_name = $this->input->post('Bank_name');
          $Branch_name = $this->input->post('Branch_name');
          $Credit_Cheque_number = $this->input->post('Credit_Cheque_number');
          $Remarks = $this->input->post('Remarks');
          $Balance_to_bay = $this->input->post('Balance_to_bay');

          // Balance_to_bay
          if ($Settlement_amount > $Bill_amount) {
            $this->session->set_flashdata("error_code", "Settled Amount is greater than Invoice Amount.<b>" . $Bill_no . " </b>");
            redirect('Settlement/Publisher_settlement');
          }

          $Seller_id = $publisher;
          if ($Bill_no != "" && $publisher != "" && $Purchased_Miles != "" && $Bill_purchased_amount != "" && $Settlement_amount != "") {

            $Count_records = $this->Settlement_model->Count_publisher_bill($Company_id, $Bill_no, $Seller_id);
            //echo "--Count_records---".$Count_records."---<br>";

            $new_balance_to_pay = 0;
            if ($Count_records > 0) {  //Update Records
              // echo "--Update Records--Partail Payment-<br>";
              $get_publisher_data = $this->Settlement_model->Get_publisher_bill_detilas($Company_id, $Bill_no, $Seller_id);



              $exist_Settlement_amount = $get_publisher_data->Settlement_amount;
              $Bill_id = $get_publisher_data->Bill_id;
              $exist_Bill_amount = $get_publisher_data->Bill_amount;
              $exist_Bill_no = $get_publisher_data->Bill_no;
              $exist_Bill_purchased_amount = $get_publisher_data->Bill_purchased_amount;

              $From_bill_date = $get_publisher_data->From_bill_date;
              $To_bill_date = $get_publisher_data->To_bill_date;


              // echo "--exist_Settlement_amount---".$exist_Settlement_amount."---<br>";


              $new_balance_to_pay = $exist_Settlement_amount - $exist_Bill_amount;

              // echo "--new_balance_to_pay---".$new_balance_to_pay."---<br>";
              if (($Bill_no == $exist_Bill_no) && ($exist_Bill_amount != $Bill_amount) && ($new_balance_to_pay != $Balance_to_bay )) {
                // echo "----Please check invoice amount and invoice number----<br>";
                $this->session->set_flashdata("error_code", "Settled Amount is greater than Invoice Amount for Invoice  Number <b>" . $Bill_no . " </b>");
                redirect('Settlement/Publisher_settlement');
              }

              // die;
              // echo "--exist_Settlement_amount---".$exist_Settlement_amount."---<br>";
              // echo "--exist_Bill_amount---".$exist_Bill_amount."---<br>";
              // echo "--exist_Bill_purchased_amount---".$exist_Bill_purchased_amount."---<br>";


              $New_paid_amount = (float) $Settlement_amount + $exist_Settlement_amount;
              $New_Bill_amount = (float) $Bill_amount;
              $New_Bill_purchased_amount = (float) $Bill_purchased_amount;

              // echo "--New_paid_amount---".$New_paid_amount."---<br>";
              // echo "--New_Bill_amount---".$New_Bill_amount."---<br>";
              // echo "--New_Bill_purchased_amount---".$New_Bill_purchased_amount."---<br>";

              if (abs($exist_Bill_amount == $New_paid_amount)) { //full Payment		
                // echo "--Update Records--Full---Payment-<br>";	
                $update_total_bill = $this->Settlement_model->Update_total_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);

                if ($update_total_bill == true) {

                  $update_transaction_bill_data = $this->Settlement_model->Update_transaction_publisher_bill($Company_id, $Seller_id, $Bill_no, $Logged_user_enrollid, $Todays_date, $From_bill_date, $To_bill_date);

                  if ($Bank_name == "") {

                    $Bank_name = "";
                  } else {

                    $Bank_name = $Bank_name;
                  }

                  if ($Branch_name == "") {

                    $Branch_name = "";
                  } else {

                    $Branch_name = $Branch_name;
                  }

                  $PaymentMethod = array(
                      'Company_id' => $Company_id,
                      'Merchant_publisher_type' => 53,
                      'Seller_id' => $Seller_id,
                      'Bill_no' => $Bill_no,
                      'Bill_purchased_amount' => $New_Bill_purchased_amount,
                      'Bill_tax' => $Bill_tax,
                      'Bill_rate' => $Bill_rate,
                      'Bill_amount' => $New_Bill_amount,
                      'Paid_amount' => $Settlement_amount,
                      'Payment_type' => $Payment_type,
                      'Bank_name' => $Bank_name,
                      'Branch_name' => $Branch_name,
                      'Credit_Cheque_number' => $Credit_Cheque_number,
                      'Remarks' => $Remarks,
                      'Created_user_id' => $Logged_user_enrollid,
                      'Creation_date' => $Todays_date
                  );
                  $Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
                }

                $this->session->set_flashdata("success_code", "Settlement done Successfuly!");
              } else {

                //partial payment							
                // echo "--Update Records--partial---Payment-<br>";	

                $update_partial_bill = $this->Settlement_model->Update_partial_generated_bill($Company_id, $Bill_id, $Seller_id, $Bill_no, $New_paid_amount, $Logged_user_enrollid, $Todays_date);

                if ($update_partial_bill == true) {


                  if ($Bank_name == "") {

                    $Bank_name = "";
                  } else {

                    $Bank_name = $Bank_name;
                  }

                  if ($Branch_name == "") {

                    $Branch_name = "";
                  } else {

                    $Branch_name = $Branch_name;
                  }

                  $PaymentMethod = array(
                      'Company_id' => $Company_id,
                      'Merchant_publisher_type' => 53,
                      'Seller_id' => $Seller_id,
                      'Bill_no' => $Bill_no,
                      'Bill_purchased_amount' => $New_Bill_purchased_amount,
                      'Bill_tax' => $Bill_tax,
                      'Bill_rate' => $Bill_rate,
                      'Bill_amount' => $New_Bill_amount,
                      'Paid_amount' => $Settlement_amount,
                      'Payment_type' => $Payment_type,
                      'Bank_name' => $Bank_name,
                      'Branch_name' => $Branch_name,
                      'Credit_Cheque_number' => $Credit_Cheque_number,
                      'Remarks' => $Remarks,
                      'Created_user_id' => $Logged_user_enrollid,
                      'Creation_date' => $Todays_date
                  );

                  $Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
                }

                $this->session->set_flashdata("success_code", " Partiall Publisher Settlement done Successfuly!");
              }
            } else {


              $check_existing_records = $this->Settlement_model->Check_publisher_transaction_details($Company_id, $from_date, $till_Date, $Seller_id, $Bill_no);
              // echo "--check_existing_records---".print_r($check_existing_records)."---<br>";
              // die;
			  
              if (empty($check_existing_records)) {
                $this->session->set_flashdata("error_code", "No Transaction was done Between <b> " . $from_date . "</b> and <b>" . $till_Date . "</b>");
                redirect('Settlement/Publisher_settlement');
              }

              $New_Settlement_amount = (float) $Settlement_amount;
              $New_Bill_amount = (float) $Bill_amount;
              $New_Bill_purchased_amount = (float) $Bill_purchased_amount;

              if (abs($New_Bill_amount == $New_Settlement_amount)) { //full Payment
                $insert_bill_data = array(
                    'Company_id' => $Company_id,
                    'Merchant_publisher_type' => 53,
                    'Seller_id' => $Seller_id,
                    'Bill_no' => $Bill_no,
                    'Bill_purchased_amount' => $New_Bill_purchased_amount,
                    'Bill_tax' => $Bill_tax,
                    'Bill_rate' => $Bill_rate,
                    'Bill_amount' => $New_Bill_amount,
                    'Settlement_amount' => $New_Settlement_amount,
                    'Joy_coins_issued' => $Purchased_Miles,
                    'Bill_flag' => 1,
                    'Settlement_flag' => 1,
                    'From_bill_date' => $from_date,
                    'To_bill_date' => $till_Date,
                    'Created_user_id' => $Logged_user_enrollid,
                    'Creation_date' => $Todays_date,
                    'Update_user_id' => $Logged_user_enrollid,
                    'Update_date' => $Todays_date,
                );




                $Insert_publisher_bill = $this->Settlement_model->Insert_publisher_bill_payment($insert_bill_data);

                if ($Insert_publisher_bill == true) {

                  $update_transaction_bill_data = $this->Settlement_model->Update_transaction_publisher_bill($Company_id, $Seller_id, $Bill_no, $Logged_user_enrollid, $Todays_date, $from_date, $till_Date);

                  if ($Bank_name == "") {

                    $Bank_name = "";
                  } else {

                    $Bank_name = $Bank_name;
                  }

                  if ($Branch_name == "") {

                    $Branch_name = "";
                  } else {

                    $Branch_name = $Branch_name;
                  }

                  $PaymentMethod = array(
                      'Company_id' => $Company_id,
                      'Merchant_publisher_type' => 53,
                      'Seller_id' => $Seller_id,
                      'Bill_no' => $Bill_no,
                      'Bill_purchased_amount' => $New_Bill_purchased_amount,
                      'Bill_tax' => $Bill_tax,
                      'Bill_rate' => $Bill_rate,
                      'Bill_amount' => $New_Bill_amount,
                      'Paid_amount' => $New_Settlement_amount,
                      'Payment_type' => $Payment_type,
                      'Bank_name' => $Bank_name,
                      'Branch_name' => $Branch_name,
                      'Credit_Cheque_number' => $Credit_Cheque_number,
                      'Remarks' => $Remarks,
                      'Created_user_id' => $Logged_user_enrollid,
                      'Creation_date' => $Todays_date
                  );
                  $Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
                }

                $this->session->set_flashdata("success_code", "Publisher Settlement done Successfuly!");
              } else {   //partial Payment
                // echo "--insert Records--first time--partial---Payment---<br><br>";
                $New_Settlement_amount = (float) $Settlement_amount;

                $New_Bill_amount = (float) $Bill_amount;
                $New_Bill_purchased_amount = (float) $Bill_purchased_amount;

                $insert_bill_data = array(
                    'Company_id' => $Company_id,
                    'Merchant_publisher_type' => 53,
                    'Seller_id' => $Seller_id,
                    'Bill_no' => $Bill_no,
                    'Bill_purchased_amount' => $New_Bill_purchased_amount,
                    'Bill_tax' => $Bill_tax,
                    'Bill_rate' => $Bill_rate,
                    'Bill_amount' => $New_Bill_amount,
                    'Settlement_amount' => $New_Settlement_amount,
                    'Joy_coins_issued' => $Purchased_Miles,
                    'Bill_flag' => 1,
                    'Settlement_flag' => 0,
                    'From_bill_date' => $from_date,
                    'To_bill_date' => $till_Date,
                    'Created_user_id' => $Logged_user_enrollid,
                    'Creation_date' => $Todays_date
                );
                $Insert_publisher_bill = $this->Settlement_model->Insert_publisher_bill_payment($insert_bill_data);

                if ($Insert_publisher_bill == true) {

                  if ($Bank_name == "") {

                    $Bank_name = "";
                  } else {

                    $Bank_name = $Bank_name;
                  }

                  if ($Branch_name == "") {

                    $Branch_name = "";
                  } else {

                    $Branch_name = $Branch_name;
                  }

                  $PaymentMethod = array(
                      'Company_id' => $Company_id,
                      'Merchant_publisher_type' => 53,
                      'Seller_id' => $Seller_id,
                      'Bill_no' => $Bill_no,
                      'Bill_purchased_amount' => $New_Bill_purchased_amount,
                      'Bill_tax' => $Bill_tax,
                      'Bill_rate' => $Bill_rate,
                      'Bill_amount' => $New_Bill_amount,
                      'Paid_amount' => $New_Settlement_amount,
                      'Payment_type' => $Payment_type,
                      'Bank_name' => $Bank_name,
                      'Branch_name' => $Branch_name,
                      'Credit_Cheque_number' => $Credit_Cheque_number,
                      'Remarks' => $Remarks,
                      'Created_user_id' => $Logged_user_enrollid,
                      'Creation_date' => $Todays_date
                  );

                  $Insert_payment_method = $this->Settlement_model->Insert_payment_billing_method($PaymentMethod);
                }
                $this->session->set_flashdata("success_code", "Publisher Settlement partial done Successfuly!");
              }
            }
          } else {

            $this->session->set_flashdata("error_code", "Please provide valid data!!");
          }

          redirect('Settlement/Publisher_settlement');
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function check_bill_no() {
      $result = $this->Settlement_model->check_bill_no($this->input->post("Bill_no"), $this->input->post("publisher"), $this->input->post("Company_id"));
      if ($result > 0) {
        $bill_no = array(
            "Error_flag" => 1,
            "Bill_purchased_amount" => $result->Bill_purchased_amount,
            "Bill_tax" => $result->Bill_tax,
            "Bill_rate" => $result->Bill_rate,
            "Bill_amount" => $result->Bill_amount,
            "Settlement_amount" => $result->Settlement_amount,
            "Joy_coins_issued" => $result->Joy_coins_issued,
            "Bill_flag" => $result->Bill_flag,
            "Settlement_flag" => $result->Settlement_flag,
            "From_bill_date" => date('Y-m-d H:i:s', strtotime($result->From_bill_date)),
            "To_bill_date" => date('Y-m-d H:i:s', strtotime($result->To_bill_date))
        );
        echo json_encode($bill_no);
      } else {
        $bill_no = array("Error_flag" => 0);
        $this->output->set_output(json_encode($bill_no)); //Unable to Locate membership id
      }
    }

    public function get_bill_details() {
      $result = $this->Settlement_model->get_bill_details($this->input->post("Bill_no"), $this->input->post("publisher"), $this->input->post("Company_id"));
      // print_r($result);
      if ($result == true) {
        $Total_Paid_amount_arr = array();
        foreach ($result as $res) {


          $Total_Paid_amount_arr[] = $res->Paid_amount;
          $Billamount = $res->Bill_amount;

          $bill_details_array[] = array(
              "Error_flag" => 1,
              "Bill_no" => $res->Bill_no,
              "Bill_purchased_amount" => $res->Bill_purchased_amount,
              "Bill_tax" => $res->Bill_tax,
              "Bill_rate" => $res->Bill_rate,
              "Bill_amount" => $res->Bill_amount,
              "Paid_amount" => $res->Paid_amount,
              "Payment_type" => $res->Payment_type,
              "Bank_name" => $res->Bank_name,
              "Branch_name" => $res->Branch_name,
              "Credit_Cheque_number" => $res->Credit_Cheque_number,
              "Remarks" => $res->Remarks
          );
        }
        $Total_Paid_amount = array_sum($Total_Paid_amount_arr);

        $Billamount = $Billamount;

        $bill_details1 = array("Error_flag" => 1, "bill_details" => $bill_details_array, "Total_Paid_amount" => $Total_Paid_amount, "Billamount" => $Billamount);

        echo json_encode($bill_details1);
      } else {
        $bill_details1 = array("Error_flag" => 0, "Total_Paid_amount" => 0);
        echo json_encode($bill_details1);
      }
    }

    public function Get_publisher_details() {
      $result = $this->Settlement_model->Get_publisher_details($this->input->post("Company_id"), $this->input->post("publisher"));
      // print_r($result);
      if ($result == true) {
        // $publisher_details_array=array();
        $publisher_details_array = array(
            "Error_flag" => 1,
            "Register_beneficiary_id" => $result->Register_beneficiary_id,
            "Beneficiary_company_name" => $result->Beneficiary_company_name,
            "Address" => $result->Address,
            "Redemptionratio" => $result->Redemptionratio,
            "Buy_rate" => $result->Buy_rate,
            "Tax" => $result->Tax,
            "Activate_flag" => $result->Activate_flag
        );

        $publisher_details = $publisher_details_array;
        echo json_encode($publisher_details);
      } else {
        $publisher_details = array("Error_flag" => 0, "publisher_details" => 0);
        echo json_encode($publisher_details);
      }
    }

  }
  