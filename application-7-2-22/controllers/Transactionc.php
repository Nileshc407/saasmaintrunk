<?php
error_reporting(0);
  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Transactionc extends CI_Controller {

    public function __construct() {
      parent::__construct();

      $this->load->database();
      $this->load->helper('url');
      $this->load->model('login/Login_model');
      $this->load->model('Redemption_Catalogue/Redemption_Model');
      $this->load->model('Igain_model');
      $this->load->model('enrollment/Enroll_model');
      $this->load->model('transactions/Transactions_model');
      $this->load->model('administration/Administration_model');
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('pagination');
      $this->load->library('Send_notification');
      $this->load->model('master/currency_model');
      $this->load->model('Report/Report_model');
      $this->load->model('Segment/Segment_model');
      $this->load->model('Coal_transactions/Coal_Transactions_model');
    }

    /** *********************************Akshay Start ******************************************** */

    public function issue_bonus() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Logged_user_enrollid = $session_data['enroll'];
        //$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;
        $data['Daily_points_consumption_flag'] = $company_details->Daily_points_consumption_flag;
        $data['Enable_company_meal_flag'] = $company_details->Enable_company_meal_flag;
        $data['Currency_name'] = $company_details->Currency_name;

        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Seller_balance'] = $seller_details->Current_balance;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $data['Sub_seller_Enrollement_id'] = $seller_details->Sub_seller_Enrollement_id;

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $data['enroll'];
        } else {
          $Logged_user_enrollid = $data['Sub_seller_Enrollement_id'];
        }

        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/issue_bonus";
        $total_row = $this->Transactions_model->issue_bonus_trans_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
        /* -----------------------Pagination--------------------- */

        if ($_POST == NULL) {
          $data["results"] = $this->Transactions_model->issue_bonus_trans_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('transactions/issue_bonus', $data);
        } else {
          // $this->output->enable_profiler(TRUE);
          // $categoryexist = $this->Transactions_model->check_seller_item_category($data['Company_id'], $data['enroll']);

          // if ($categoryexist > 0) {
            $cardis = $this->input->post("cardId");
            if (substr($cardis, 0, 1) == "%") {
              $get_card = substr($cardis, 2); //*******read card id from magnetic card***********///
            } else {
              $get_card = substr($cardis, 0, 16); //*******read card id from other magnetic card***********///
            }


            $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
            $phnumber = $dial_code . $this->input->post("cardId");

            $member_details = $this->Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
              $user_activated = $rowis['User_activated'];
              $Phone_no = App_string_decrypt($rowis['Phone_no']);
            }

            if ($user_activated == 0 || $cardId == '0') {
              $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
              redirect(current_url());
            }

            if (strlen($cardis) != '0') {
              if ($cardis != '0') {
                if ($cardId == $cardis || $Phone_no == $phnumber) {
                  $cust_details = $this->Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                  foreach ($cust_details as $row25) {
                    $fname = $row25['First_name'];
                    $midlename = $row25['Middle_name'];
                    $lname = $row25['Last_name'];
                    $bdate = $row25['Date_of_birth'];
                    $address = App_string_decrypt($row25['Current_address']);
                    $bal = $row25['Current_balance'];
                    $phno = App_string_decrypt($row25['Phone_no']);
                    $Blocked_points = $row25['Blocked_points'];
                    $Debit_points = $row25['Debit_points'];
                    $companyid = $row25['Company_id'];
                    $cust_enrollment_id = $row25['Enrollement_id'];
                    $image_path = $row25['Photograph'];
                    $filename_get1 = $image_path;
                    $pinno = $row25['pinno'];
                    $Tier_name = $row25['Tier_name'];
                    $MembershipID = $row25['Card_id'];

                    $Current_point_balance = $bal - ($Blocked_points + $Debit_points);

                    if ($Current_point_balance < 0) {
                      $Current_point_balance = 0;
                    } else {
                      $Current_point_balance = $Current_point_balance;
                    }
                  }
                  $data['fix_bonus_points'] = $this->Transactions_model->get_fix_bonus_points($data['Company_id']);
                  $tp_count = $this->Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                  $purchase_count = $this->Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                  $gainedpts_atseller = $this->Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                  if ($gainedpts_atseller == NULL) {
                    $gainedpts_atseller = 0;
                  }

                  $data['get_card'] = $get_card;
                  $data['Cust_enrollment_id'] = $cust_enrollment_id;
                  $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                  $data['Phone_no'] = $phno;
                  // $data['Current_balance'] = ($bal-$Blocked_points);
                  $data['Current_balance'] = $Current_point_balance;
                  // $data['Current_balance'] = $bal;
                  $data['Topup_count'] = $tp_count;
                  $data['Purchase_count'] = $purchase_count;
                  $data['Gained_points'] = $gainedpts_atseller;
                  $data['Photograph'] = $filename_get1;
                  $data['Customer_pin'] = $pinno;
                  $data['Tier_name'] = $Tier_name;
                  $data['MembershipID'] = $MembershipID;

                  $this->load->view('transactions/issue_bonus_transaction', $data);
                } else {
                  $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Your Membership ID is not registered with us...! !");
                  redirect(current_url());
                }
              } else {
                $this->session->set_flashdata("error_code", "The Customer has not been Assigned a Membership ID yet! Please go to Assign Membership ID option.");
                redirect(current_url());
              }
            } else {
              $this->session->set_flashdata("error_code", "Please enter valid Membership ID.");
              redirect(current_url());
            }
            // $this->load->view('transactions/issue_bonus_transaction', $data);
          /* } else {
            $this->session->set_flashdata("error_code", "The Merchant has not been Assigned a Category yet!! Please contact the Program Admin to set it to Enable TOPUP");
            redirect(current_url());
          } */
        }
      }
    }

    public function issue_bonus_transaction() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $Company_id = $session_data['Company_id'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
		 $Daily_points_consumption_flag = $data["Company_details"]->Daily_points_consumption_flag;
        $Enable_company_meal_flag = $data["Company_details"]->Enable_company_meal_flag;
        $Currency_name = $data["Company_details"]->Currency_name;
		
        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $data['enroll'];
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }


        if ($_POST == NULL) {

			if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){ $this->session->set_flashdata("error_code", "Sorry, Meal Topup Failed. Invalid Data Provided!!");}else{ $this->session->set_flashdata("error_code", "Sorry, Issue Bonus Transaction Failed. Invalid Data Provided!!");}
         
          redirect('transactions/issue_bonus');
        } else {
          if ($this->input->post("topup_amt") == "" || $this->input->post("topup_amt") <= 0 || $this->input->post("topup_amt") == " ") {
           if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){ $this->session->set_flashdata("error_code", "Sorry, Meal Topup Failed. Invalid Data Provided!!");}else{ $this->session->set_flashdata("error_code", "Sorry, Issue Bonus Transaction Failed. Invalid Data Provided!!");}
            redirect('Transactionc/issue_bonus');
          } else {
			  
			  /*------Manual_bill_no Checking---12-08-2019--*/
				$result = $this->Transactions_model->check_bill_no($this->input->post("manual_bill_no"),$Company_id);				
				if ($result > 0) {
					
					$this->session->set_flashdata("error_code", "Transaction failed due to Invalid Bill No.");
					redirect('Transactionc/issue_bonus');
				
				}
			/*------Manual_bill_no Checking-----*/
			
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time = $date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');

            $compid = $data['Country_id'];
            $manual_bill_no = $this->input->post("manual_bill_no");
            $logtimezone = $data['timezone_entry'];

            $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
            $phnumber = $dial_code . $this->input->post("cardId");

            $member_details = $this->Transactions_model->issue_bonus_member_details($data['Company_id'], $this->input->post("cardId"), $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
            }

            if ($data['userId'] == 3) {
              $top_seller = $this->Transactions_model->get_top_seller($data['Company_id']);
              foreach ($top_seller as $sellers) {
                $seller_id = $sellers['Enrollement_id'];
                $bill = $sellers['Topup_Bill_no'];
                $username = $sellers['User_email_id'];
                $remark_by = 'By Admin';
                $seller_curbal = $sellers['Current_balance'];
                $Seller_Redemptionratio = $sellers['Seller_Redemptionratio'];
              }
            } else {
              $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
              $seller_id = $user_details->Enrollement_id;
              $bill = $user_details->Topup_Bill_no;
              $username = $user_details->User_email_id;
              $remark_by = 'By Seller';
              $seller_curbal = $user_details->Current_balance;
              $Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
              $Sub_seller_admin = $user_details->Sub_seller_admin;
              $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;

              if ($Sub_seller_admin == 1) {
                $seller_id = $seller_id;
              } else {
                $seller_id = $Sub_seller_Enrollement_id;
              }
            }
            $cust_details = $this->Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
            foreach ($cust_details as $row25) {
              $card_bal = $row25['Current_balance'];
              $enroll_id = $row25['Enrollement_id'];
              $topup = $row25['Total_topup_amt'];
              $purchase_amt = $row25['total_purchase'];
              $reddem_amt = $row25['Total_reddems'];
            }

            $logged_user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
            $tp_db = $logged_user_details->Topup_Bill_no;
            $len = strlen($tp_db);
            $str = substr($tp_db, 0, 5);
            $bill = substr($tp_db, 5, $len);
            $Seller_name = $logged_user_details->First_name . " " . $logged_user_details->Middle_name . " " . $logged_user_details->Last_name;
            $bill_no = $bill + 1;

            if ($Seller_Redemptionratio != NULL) {
              $redemptionratio = $Seller_Redemptionratio;
            } else {
              $company_details = $this->Igain_model->get_company_details($data['Company_id']);
              $redemptionratio = $company_details->Redemptionratio;
            }
			
			$curr_bal = $card_bal + $this->input->post("topup_amt");
			
            $post_data = array(
                'Trans_type' => '1',
                'Company_id' => $data['Company_id'],
                'Topup_amount' => $this->input->post("topup_amt"),
                'Trans_date' => $lv_date_time,
                'Remarks' => $this->input->post('remark'),
                'Card_id' => $cardId,
                'Seller_name' => $Seller_name,
                'Seller' => $data['enroll'],
                'Enrollement_id' => $enroll_id,
                'Bill_no' => $bill,
                'Manual_billno' => $this->input->post('manual_bill_no'),
                'remark2' => $remark_by,
                'Loyalty_pts' => '0',
				'Available_balance' => $curr_bal
            );
            $result = $this->Transactions_model->insert_topup_details($post_data);

            $curr_bal = $card_bal + $this->input->post("topup_amt");
            $topup_amt = $topup + $this->input->post("topup_amt");
            $purchase_amount = $purchase_amt;
            $reddem_amount = $reddem_amt;

            $result2 = $this->Transactions_model->update_customer_balance($cardId, $curr_bal, $data['Company_id'], $topup_amt, $Todays_date, $purchase_amount, $reddem_amount);

            $billno_withyear = $str . $bill_no;
            $company_details2 = $this->Igain_model->get_company_details($data['Company_id']);
            $Sms_enabled = $company_details2->Sms_enabled;
            $Seller_topup_access = $company_details2->Seller_topup_access;

            /*             * **********Nilesh change igain Log Table change 14-06-2017************** */

            $get_cust_detail = $this->Igain_model->get_enrollment_details($enroll_id);
            $Enrollement_id = $get_cust_detail->Enrollement_id;
            $First_name = $get_cust_detail->First_name;
            $Last_name = $get_cust_detail->Last_name;
            $opration = 1;
            $userid = $data['userId'];
            $what = "Manual Credit";
            $where = "Issue / Credit Points";
            $toname = "";
            $opval = 'Bill No.:'.$this->input->post('manual_bill_no').', Remarks:'.$this->input->post('remark').','.$this->input->post("topup_amt") . ' Points.'; // topup_amt
            $firstName = $First_name;
            $lastName = $Last_name;

            $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $enroll_id);

            /*             * ****************igain Log Table change 14-06-2017*************** */

            if ($Sms_enabled == '1') {
              /*               * *******************************Send SMS Code****************************** */
            }

            if ($Seller_topup_access == '1') {
              $Total_seller_bal = $seller_curbal - $this->input->post("topup_amt");
              $result3 = $this->Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

              /*               * *******************Send Threshold Mail*************** */
              $company_details = $this->Igain_model->get_company_details($Company_id);
              $Threshold_Merchant = $company_details->Threshold_Merchant;

              $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
              $Seller_balance = $seller_details2->Current_balance;
              $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;

              if ($Threshold_Merchant >= $Seller_balance) {
                //****mail to super seller
                $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                $Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
                $Admin_Email_content = array(
                    'Seller_name' => $Seller_full_name,
                    'Seller_balance' => $Seller_balance,
                    'Super_Seller_flag' => 1,
                    'Notification_type' => "Seller Threshold Balance",
                    'Template_type' => 'Seller_threshold'
                );
                $this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
                //****mail to super seller
                //****mail to seller
                $Seller_Email_content = array(
                    'Seller_name' => $Seller_full_name,
                    'Seller_balance' => $Seller_balance,
                    'Company_admin' => $Company_admin,
                    'Super_Seller_flag' => 0,
                    'Notification_type' => "Seller Threshold Balance",
                    'Template_type' => 'Seller_threshold'
                );
                $this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
                //****mail to seller
              }
              /*               * *******************Send Threshold Mail*************** */
            }
            $result4 = $this->Transactions_model->update_topup_billno($data['enroll'], $billno_withyear);
			
			$details51 = $this->Igain_model->get_enrollment_details($data['enroll']);
			$currency_details = $this->Igain_model->Get_Country_master($details51->Country);
            $Symbol_currency = $currency_details->Symbol_of_currency;
			  
            $Email_content = array(
                'Todays_date' => $lv_date_time,
                'topup_amt' => $this->input->post("topup_amt"),
                'manual_bill_no' => $this->input->post("manual_bill_no"),
                'Symbol_currency' => $Symbol_currency,
                // 'Notification_type' => 'Bonus ' . $data['Company_details']->Currency_name,
                'Notification_type' => 'Add Balance',
                'Template_type' => 'Issue_bonus'
            );
            $this->send_notification->send_Notification_email($enroll_id, $Email_content, $seller_id, $data['Company_id']);
            if (($result == true) && ($result2 == true) && ($result4 == true)) {
				if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){ $this->session->set_flashdata("success_code", "Meal Topup Transaction done Successfully!!");}else{ $this->session->set_flashdata("success_code", "Bonus Topup Transaction done Successfully!!");}
              
            } else {
					if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){ $this->session->set_flashdata("error_code", "Sorry, Meal Topup Transaction Failed!!");}else{ $this->session->set_flashdata("error_code", "Sorry, Issue Bonus Transaction Failed!!");}
              
            }
            redirect('Transactionc/issue_bonus');
          }
        }
      }
    }

    public function show_transaction_details() {
      $seller_details = $this->Igain_model->get_enrollment_details($this->input->post("Seller_id"));
      //print_r($seller_details);
      $Seller_Enrollment_id = $seller_details->Enrollement_id;
      $Sub_seller_admin = $seller_details->Sub_seller_admin;
      $Sub_seller_Enrollment_id = $seller_details->Sub_seller_Enrollement_id;

      if ($Sub_seller_admin == 1) {
        $Sub_Seller_id[] = $Seller_Enrollment_id;
        $data['Sub_sellers'] = $this->Igain_model->Get_sub_seller($Seller_Enrollment_id);
        if ($data['Sub_sellers'] != NULL) {
          foreach ($data['Sub_sellers'] as $Sub_sellers) {
            $Sub_Seller_id[] = $Sub_sellers->Enrollement_id;
          }
        }
        $data['transaction_details'] = $this->Transactions_model->get_transaction_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));

        $data['transaction_sum_details'] = $this->Transactions_model->get_transaction_sum_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));
        //var_dump($data['Sub_sellers']);
      } else {
        $Sub_Seller_id[] = $Sub_seller_Enrollment_id;
        $data['Sub_sellers'] = $this->Igain_model->Get_sub_seller($Sub_seller_Enrollment_id);
        if ($data['Sub_sellers'] != NULL) {
          foreach ($data['Sub_sellers'] as $Sub_sellers) {
            $Sub_Seller_id[] = $Sub_sellers->Enrollement_id;
          }
        }
        $data['transaction_details'] = $this->Transactions_model->get_transaction_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));

        $data['transaction_sum_details'] = $this->Transactions_model->get_transaction_sum_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));
      }
      $theHTMLResponse = $this->load->view('transactions/show_transaction_details', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionDetailHtml' => $theHTMLResponse)));
      /* $data['transaction_details'] = $this->Transactions_model->get_transaction_details($this->input->post("Seller_id"),$this->input->post("Enrollment_id"),$this->input->post("Membership_id"));
        $data['transaction_sum_details'] = $this->Transactions_model->get_transaction_sum_details($this->input->post("Seller_id"),$this->input->post("Enrollment_id"),$this->input->post("Membership_id"));

        $theHTMLResponse = $this->load->view('transactions/show_transaction_details', $data, true);
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('transactionDetailHtml'=> $theHTMLResponse))); */
    }

    public function transaction_receipt() {
      $this->load->model('master/currency_model');
      $Bill_no = $this->input->post("Bill_no");
      $Seller_id = $this->input->post("Seller_id");
      $Trans_id = $this->input->post("Trans_id");
      $transtype = $this->input->post("Transaction_type");

      /* echo "---Bill_no--".$Bill_no."--<br>";
        echo "---Seller_id--".$Seller_id."--<br>";
        echo "---Trans_id--".$Trans_id."--<br>";
        echo "---transtype--".$transtype."--<br>";
        die; */

      $Todays_date = date("Y-m-d");
      $seller_details = $this->Igain_model->get_enrollment_details($Seller_id);
      $seller_name = $seller_details->First_name . ' ' . $seller_details->Last_name;
      //echo "---seller_name--".$seller_name."--<br>";

      $address = App_string_decrypt($seller_details->Current_address);
      $timezone12 = $seller_details->timezone_entry;
      $Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;
      $data["Company_details"] = $this->Igain_model->get_company_details($seller_details->Company_id);
      $company_details = $this->Igain_model->get_company_details($seller_details->Company_id);
      $compname = $company_details->Company_name;
      $Comp_redemptionratio = $company_details->Redemptionratio;
      $Comp_Currency_name = $company_details->Currency_name;
	  
	  if($Comp_Currency_name==""){
		  $Comp_Currency_name="Points";
	  } else{
		  $Comp_Currency_name=$Comp_Currency_name;
	  }

      //echo "---compname--".$compname."--<br>";
      $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
      $Symbol_currency = $currency_details->Symbol_of_currency;

      if ($Seller_Redemptionratio != NULL) {
        $redemptionratio = $Seller_Redemptionratio;
      } else {
        $redemptionratio = $Comp_redemptionratio;
      }


      $transaction_details = $this->Transactions_model->get_bills_info($Bill_no, $transtype, $Seller_id);

      $data['Symbol_currency'] = $Symbol_currency;
      $data['transaction_details'] = $transaction_details;
      //print_r($transaction_details);//die;
      foreach ($transaction_details as $transaction) {
        $data['Trans_id'] = $transaction['Trans_id'];

        $enrollid = $transaction['Enrollement_id'];
        $Transaction_type = $transaction['Trans_type'];
        $tra_date = $transaction['Trans_date'];
        $GiftCardNo = $transaction['GiftCardNo'];

        $data['Manual_billno'] = $transaction['Manual_billno'];
        $data['Remark'] = $transaction['Remarks'];
        $data['Remarks2'] = $transaction['remark2'];
        $data['Seller_name'] = $transaction['Seller_name'];
        $reedem = $transaction['Redeem_points'];

        /* $redeem_amt =($reedem * $redemptionratio );
          $redeem_amt = (round($redeem_amt,2)); */
        $redeem_amt = $reedem;
        if ($transtype == 1) {
          $data['Topup_amount'] = $transaction['Topup_amount'];
        }

        if ($transtype == 2) {
          $data['Purchase_amount'] = $transaction['Purchase_amount'];
          $data['Item_category_name'] = $transaction['Item_category_name'];
          $data['Redeem_points'] = $redeem_amt;
          $data['Payment_description'] = $transaction['Payment_description'];
          $data['Loyalty_pts'] = $transaction['Loyalty_pts'];
          $data['balance_to_pay'] = $transaction['balance_to_pay'];
          $data['Loyalty_id'] = $transaction['Loyalty_id'];
          $data['GiftCardNo'] = $transaction['GiftCardNo'];
          /*           * **********amit 16-09-2016***** */
          $data['Payment_type_id'] = $transaction['Payment_type_id'];
          $data['Bank_name'] = $transaction['Bank_name'];
          $data['Branch_name'] = $transaction['Branch_name'];
          $data['Credit_Cheque_number'] = $transaction['Credit_Cheque_number'];
          $data['Voucher_no'] = $transaction['Voucher_no'];
          /*           * *********** */
          $data['Loyalty_Transaction'] = $this->Igain_model->Fetch_Transaction_Loyalty_Details($Trans_id, $seller_details->Company_id, $Seller_id);
        }


        if ($transtype == 3) {
          $data['Redeem_points'] = $redeem_amt;
        }

        if ($transtype == 10) { //****Catalogue Redemption
          $redeem_bill_info = $this->Redemption_Model->get_redeem_bill_info($Bill_no, $seller_details->Company_id, $transtype);
          $Redeemed_item = "";
          $Total_redeem_points = 0;

          foreach ($redeem_bill_info as $redeem_info) {
            /* if ($redeem_info === end($redeem_bill_info))
              {
              $Redeemed_item .= $redeem_info['Merchandize_item_name']." ( Quantity - ".$redeem_info['Quantity']." X ".$redeem_info['Billing_price_in_points']." Points)";
              }
              else
              {
              $Redeemed_item .= $redeem_info['Merchandize_item_name']." ( Quantity - ".$redeem_info['Quantity']." X ".$redeem_info['Billing_price_in_points']." Points), <br>";
              }
             */
            if ($redeem_info['Voucher_status'] == '30') {
              $redeem_info['Voucher_status'] = "Issued";
            } else {
              $redeem_info['Voucher_status'] = "Used";
            }
            /*             * *********Change AMIT 18-2-2017*************************** */
            if ($redeem_info['Billing_price_in_points'] == 0) {
              $lv_Billing_price_in_points = "";
            } else {
              $lv_Billing_price_in_points = " X " . $redeem_info['Billing_price_in_points'] ." ". $Comp_Currency_name;
            }
            if ($redeem_info === end($redeem_bill_info)) {

              $Redeemed_item .= $redeem_info['Merchandize_item_name'] . " ( QTY - " . $redeem_info['Quantity'] . " " . $lv_Billing_price_in_points . "):" . $redeem_info['Voucher_status'];
            } else {
              $Redeemed_item .= $redeem_info['Merchandize_item_name'] . " ( QTY - " . $redeem_info['Quantity'] . " " . $lv_Billing_price_in_points . " ):" . $redeem_info['Voucher_status'] . ", <br>";
            }
            /*             * *********Change AMIT 18-2-2017 END*************************** */
            $Total_redeem_points = $Total_redeem_points + ( $redeem_info['Billing_price_in_points'] * $redeem_info['Quantity'] );
          }

          $data['Redeemed_item'] = $Redeemed_item;
          $data['Total_redeem_points'] = $Total_redeem_points;
          // $data['Redeemed_item'] = $Merchandize_Item_details->Merchandize_item_name;
          $data['Redeem_points'] = $redeem_amt;
          $data['Voucher_no'] = $transaction['Voucher_no'];
          $data['Voucher_status'] = $transaction['Voucher_status'];
        }
        /*         * ********AMIT 03-03-2017************* */
        if ($transtype == 12) { //****Catalogue Redemption
          $purchase_bill_info = $this->Redemption_Model->get_redeem_bill_info($Bill_no, $seller_details->Company_id, $transtype);
          $Purchase_item = "";
          $Total_purchase = 0;
          $balance_to_pay = 0;
          $Redeem_points = 0;
          $Loyalty_pts = 0;

          foreach ($purchase_bill_info as $purchase_info) {
            /*             * *********Change AMIT 18-2-2017*************************** */
            if ($purchase_info['Billing_price'] == 0) {
              $lv_Billing_price = "";
            } else {
              $lv_Billing_price = " X " . $purchase_info['Billing_price'] . " ";
            }
            if ($purchase_info === end($purchase_bill_info)) {

              $Purchase_item .= $purchase_info['Merchandize_item_name'] . " ( QTY - " . $purchase_info['Quantity'] . " " . $lv_Billing_price . "):" . $purchase_info['Voucher_status'];
            } else {
              $Purchase_item .= $purchase_info['Merchandize_item_name'] . " ( QTY - " . $purchase_info['Quantity'] . " " . $lv_Billing_price . " ):" . $purchase_info['Voucher_status'] . ", <br>";
            }
            /*             * *********************************** */
            $Total_purchase = $Total_purchase + ( $purchase_info['Billing_price'] * $purchase_info['Quantity'] );
            $balance_to_pay = $balance_to_pay + $purchase_info['balance_to_pay'];
            $Redeem_points = $Redeem_points + $purchase_info['Redeem_points'];
            $Loyalty_pts = $Loyalty_pts + $purchase_info['Loyalty_pts'];
          }

          $data['Purchase_item'] = $Purchase_item;
          $data['balance_to_pay'] = $balance_to_pay;
          $data['Total_purchase'] = $Total_purchase;
          $data['Redeem_points'] = $Redeem_points;
          $data['Loyalty_pts'] = $Loyalty_pts;
          $data['Voucher_no'] = $transaction['Voucher_no'];
          $data['Voucher_status'] = $transaction['Voucher_status'];
        }
        /*         * ************************************ */
        if ($transtype == 4) {
          $data['giftcard_purchase'] = $transaction['Purchase_amount'];
          $data['Redeem_points'] = $transaction['Redeem_points'];
          $data['balance_to_pay'] = $transaction['balance_to_pay'];
          $data['GiftCardNo'] = $transaction['GiftCardNo'];
          $data['gift_pay_type'] = "Gift Card ( " . $transaction['GiftCardNo'] . " )";
          $data['Payment_description'] = $transaction['Payment_description'];
        }

        if ($enrollid == 0 && $transtype == 4) {
          $giftcard_details = $this->Transactions_model->get_giftcard_details($GiftCardNo, $seller_details->Company_id);
          foreach ($giftcard_details as $giftcard) {
            $Card_balance = $giftcard['Card_balance'];
            $name = $giftcard['User_name'];
            $Email = $giftcard['Email'];
            $Phone_no = $giftcard['Phone_no'];
            $Card_id = $giftcard['Card_id'];
          }

          $data['Cust_full_name'] = $name;
          $data['Cust_address'] = " - ";
          $data['Cust_phone_no'] = App_string_decrypt($Phone_no);
          $data['User_email_id'] = App_string_decrypt($Email);
		   $data['Cust_card_id'] = $Card_id;
          // $customer_details = $this->Transactions_model->cust_details_from_card($seller_details->Company_id,$Card_id);	//cust_details_from_giftcard
        } else {
          $customer_details = $this->Igain_model->get_enrollment_details($enrollid);
          $data['Cust_full_name'] = $customer_details->First_name . " " . $customer_details->Middle_name . " " . $customer_details->Last_name;
          $data['Cust_address'] = App_string_decrypt($customer_details->Current_address);
          $data['Cust_phone_no'] = App_string_decrypt($customer_details->Phone_no);
          $data['Cust_card_id'] = $customer_details->Card_id;
          $data['User_email_id'] = App_string_decrypt($customer_details->User_email_id);
        }

        $data['Transaction_type'] = $transtype;
        $data['Company_name'] = $compname;
        $data['Seller_name'] = $seller_name;
        $data['Seller_address'] = $address;
        $data['Bill_no'] = $Bill_no;

        $data['Transaction_date'] = $tra_date;

        $data['Symbol_currency'] = $Symbol_currency;

        $data['Timezone'] = $timezone12;
        $data['Payment_type_id'] = $transaction['Payment_type_id'];

        $timezone = new DateTimeZone($timezone12);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');

        $data['Todays_date'] = $Todays_date;
      }


      $theHTMLResponse = $this->load->view('transactions/show_transaction_receipt', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionReceiptHtml' => $theHTMLResponse)));
    }

    public function check_bill_no() {
      $result = $this->Transactions_model->check_bill_no($this->input->post("Bill_no"), $this->input->post("Company_id"));

      if ($result > 0) {
        $this->output->set_output("1");
	
      } else {
        $this->output->set_output("0");
		
      }
    }

    public function validate_seller_pin() {
      $result20 = $this->Transactions_model->check_seller_pin($this->input->post("seller_pin"), $this->input->post("Company_id"));

      if ($result20 > 0) {
        $this->output->set_output("Available");
      } else {
        $this->output->set_output("Already Exist");
      }
    }

    /*     * **********************************Gift Card Transaction***************************** */

    public function transact_giftcard() {
		
      if ($this->session->userdata('logged_in')) {
		  
        $this->load->model('master/currency_model');
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $sellerID = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $companyid = $session_data['Company_id'];
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/transact_giftcard";
        $total_row = $this->Transactions_model->giftcard_trans_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
        /* -----------------------Pagination--------------------- */

        /* if($_POST == NULL)
          {
          $data["results"] = $this->Transactions_model->giftcard_trans_list($config["per_page"],$page,$data['enroll'],$data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('transactions/issue_bonus',$data);
          } */

        if ($_POST == NULL) {
          //$data["PaymentType"] = $this->Igain_model->FetchPaymentType();
          $Payment = $this->Igain_model->get_payement_type();
          $data['PaymentType'] = $Payment;
          $data["results"] = $this->Transactions_model->giftcard_trans_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('transactions/transact_giftcard', $data);
		  
        } else {
			
		 /*  print_r($_POST);
		  die; */
		  
		  /*------Manual_bill_no Checking---12-08-2019--*/
				$result = $this->Transactions_model->check_bill_no($this->input->post("Billno"),$Company_id);				
				if ($result > 0) {
					
					$this->session->set_flashdata("error_code", "Transaction failed due to Invalid Bill No.");
					redirect('Transactionc/transact_giftcard');
				
				}
			/*------Manual_bill_no Checking-----*/
		  
          $manualbillno = $this->input->post("Billno");
          $Purchase = $this->input->post("Purchase");
          $GiftCardNo = $this->input->post("GiftCardNo");
          $Balance = $this->input->post("Balance");
          $Redeem = $this->input->post("Redeem");
          $current_balance = $Balance - $Redeem;
          $BalanceToPay = ($Purchase - $Redeem);
          $payment_by = $this->input->post("payment_by");
          // $companyid = $this->input->post("Company_id");
          $remark = $this->input->post("Cheque");
          // $Transaction_type = $this->input->post("Transaction_type");
          // $sellerID = $this->input->post("Seller_id");
          $seller_details = $this->Igain_model->get_enrollment_details($sellerID);
          $lv_timezone = $seller_details->timezone_entry;
          $lv_timezone = $seller_details->timezone_entry;
          $seller_name = $seller_details->First_name . ' ' . $seller_details->Middle_name . ' ' . $seller_details->Last_name;
          $bill_db = $seller_details->Purchase_Bill_no;
          $lv_User_id = $seller_details->User_id;

          if ($lv_User_id == '2') {
            $remarks2 = 'By Seller';
          } else {
            $remarks2 = '';
          }

          $len = strlen($bill_db);
          $str = substr($bill_db, 0, 5);
          $bill = substr($bill_db, 5, $len);
          $bill_no = $bill + 1;
          $billno_withyear = $str . $bill_no;

          /* $lv_date1 = date("Y-m-d");
            $timezone = new DateTimeZone($lv_timezone);
            $date = new DateTime();
            $date->setTimezone($timezone );
            $lv_time = $date->format('H:i:s');
            $lv_date = $lv_date1." ".$lv_time;
           */

          $logtimezone = $session_data['timezone_entry'];
          $timezone = new DateTimeZone($logtimezone);
          $date = new DateTime();
          $date->setTimezone($timezone);
          $lv_date_time = $date->format('Y-m-d H:i:s');
          $Todays_date = $date->format('Y-m-d');

          if ($GiftCardNo != '' && $Purchase != '') {
            $giftcard_details = $this->Transactions_model->get_giftcard_details($GiftCardNo, $companyid);
            $giftcard_details_count = count($giftcard_details);

            if ($giftcard_details_count > 0) {
              foreach ($giftcard_details as $giftcard) {
                $Card_balance = $giftcard['Card_balance'];
                $name = $giftcard['User_name'];
                $Email = $giftcard['Email'];
                $Phone_no = $giftcard['Phone_no'];
                $Membership_id = $giftcard['Card_id'];
              }

              if ($Membership_id == '0') {
                $giftcard_transaction['Enrollement_id'] = 0;
                $giftcard_transaction['Card_id'] = 0;
                $enrollment_id = 0;
              } else {
                /* $customer_details = $this->Transactions_model->enrollment_details_frmemail_phn_card($Email,$Membership_id,$Phone_no,$companyid);

                  $enrollment_id = $customer_details->Enrollement_id;
                  $Card_id = $customer_details->Card_id;
                 */
                $cust_details = $this->Transactions_model->cust_details_from_card($companyid, $Membership_id);
                foreach ($cust_details as $row25) {
                  $Card_id = $row25['Card_id'];
                  $enrollment_id = $row25['Enrollement_id'];
                }

                $giftcard_transaction['Enrollement_id'] = $enrollment_id;
                $giftcard_transaction['Card_id'] = $Card_id;
              }

              $giftcard_transaction['Trans_type'] = 4;
              $giftcard_transaction['Company_id'] = $companyid;
              $giftcard_transaction['Purchase_amount'] = $Purchase;
              $giftcard_transaction['Trans_date'] = $lv_date_time;
              $giftcard_transaction['Remarks'] = $remark;
              $giftcard_transaction['GiftCardNo'] = $GiftCardNo;
              $giftcard_transaction['Redeem_points'] = $Redeem;
              $giftcard_transaction['Payment_type_id'] = $payment_by;
              $giftcard_transaction['Paid_amount'] = $BalanceToPay;
              $giftcard_transaction['balance_to_pay'] = $BalanceToPay;
              $giftcard_transaction['Manual_billno'] = $manualbillno;
              $giftcard_transaction['Seller'] = $sellerID;
              $giftcard_transaction['Seller_name'] = $seller_name;
              $giftcard_transaction['Bill_no'] = $bill;

              $giftcard_transaction['remark2'] = $remarks2;
			  
			  var_dump($giftcard_transaction);

              $result = $this->Transactions_model->insert_giftcard_transaction($giftcard_transaction);
              $result2 = $this->Transactions_model->update_giftcard_balance($GiftCardNo, $current_balance, $companyid);
              $result3 = $this->Transactions_model->update_billno($sellerID, $billno_withyear);

              $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
              $Symbol_currency = $currency_details->Symbol_of_currency;
              $Email_content = array(
                  'Purchase_amount' => $Purchase,
                  'Redeem_points' => $Redeem,
                  'BalanceToPay' => $BalanceToPay,
                  'GiftCardNo' => $GiftCardNo,
                  'GiftCard_balance' => $current_balance,
                  'Enrollment_id' => $enrollment_id,
                  'Symbol_currency' => $Symbol_currency,
                  'Gift_card_user' => $name,
                  'Gift_card_Email' => $Email,
                  'Todays_date' => $lv_date_time,
                  'Notification_type' => 'Gift Card Transaction',
                  'Template_type' => 'Gift_card_transaction'
              );

              $this->send_notification->send_Notification_email($enrollment_id, $Email_content, $sellerID, $companyid);

              if (($result == true) && ($result2 == true) && ($result3 == true)) {
                $this->session->set_flashdata("success_code", "Gift Card Transaction Done Successfuly..!!!");

                /*                 * ************Nilesh change igain Log Table change 14-06-2017*************** */
                $get_cust_detail = $this->Igain_model->get_enrollment_details($enrollment_id);
                $Enrollement_id = $get_cust_detail->Enrollement_id;
                $First_name = $get_cust_detail->First_name;
                $Last_name = $get_cust_detail->Last_name;
                $opration = 1;
                $userid = $Logged_user_id;
                $what = "Gift Card Transaction";
                $where = "Transact With Gift Card";
                $toname = "";
                $opval = 'Gift Purchase Amount-' . $Purchase . ' Gift Card Used Balance -' . $Redeem; //
                $firstName = $name;
                $lastName = '';
                $Company_id = $data['Company_id'];
                $Seller_name = $seller_name;

                $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $enrollment_id);

                /*                 * ************Nilesh change igain Log Table change 14-06-2017**************** */
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Gift Card Transaction Failed..!!");
              }
              redirect('Transactionc/transact_giftcard');
            } else {
              $this->session->set_flashdata("error_code", "Gift Card is not Valid..!!");
              redirect('Transactionc/transact_giftcard');
            }
          } else {
            $this->session->set_flashdata("error_code", "Gift Card Transaction Failed..!!");
            redirect('Transactionc/transact_giftcard');
          }
        }
      }
    }

    public function get_giftcard_info() {
      $result = $this->Transactions_model->get_giftcard_info($this->input->post("GiftCardNo"), $this->input->post("Company_id"));

      if ($result != NULL) {
        // $this->output->set_content_type('application/json');
        $this->output->set_output($result);
      } else {
        $this->output->set_output("0");
      }
    }

    /*     * **********************************Gift Card Transaction***************************** */

    /*     * *********************************Akshay END ******************************************** */


    /*     * *********************************Sandeep Work Start ******************************************** */

    function validate_card_id() {
      $result = $this->Transactions_model->check_card_id($this->input->post("cardid"), $this->input->post("Company_id"));

      if ($result != NULL) {
        // $this->output->set_output("Valid");

		$result->User_email_id = App_string_decrypt($result->User_email_id);
		$result->Phone_no = App_string_decrypt($result->Phone_no);
			
        echo json_encode($result);
      } else {
        // $this->output->set_output("InValid");
        $json_value = array('Card_id' => 0);
        echo json_encode($json_value);
      }
    }

    function validate_gift_card_id() {
      $result = $this->Transactions_model->check_gift_card_id($this->input->post("gift_card"), $this->input->post("Company_id"));
      if ($result > 0) {
        $this->output->set_output("InValid");
      } else {
        $this->output->set_output("Valid");
      }
    }

    public function assign_giftcard() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/assign_giftcard";
        $total_row = $this->Transactions_model->assigned_giftcard_count($Company_id);
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

        $data["results"] = $this->Transactions_model->assigned_giftcard_list($config["per_page"], $page, $Company_id);
        $data["pagination"] = $this->pagination->create_links();
        /* -----------------------Pagination--------------------- */

        $Payment = $this->Igain_model->get_payement_type();
        $data['Payment_array'] = $Payment;

        $seller_details = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
        $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
        $Symbol_currency = $currency_details->Symbol_of_currency;
		
		$company_details = $this->Igain_model->get_company_details($Company_id);
		

        if ($_POST == NULL) {

          $this->load->view('transactions/assign_giftcard', $data);
        } else {
			/* print_r($_POST);
			die; */
          $logtimezone = $session_data['timezone_entry'];
          $timezone = new DateTimeZone($logtimezone);
          $date = new DateTime();
          $date->setTimezone($timezone);
          $lv_date_time = $date->format('Y-m-d H:i:s');
          $Todays_date = $date->format('Y-m-d');
		  
		  
		  $result = $this->Transactions_model->check_gift_card_id($this->input->post("gif_number"), $Company_id);
		  if ($result > 0) {
			  
				$this->session->set_flashdata("error_code", "Gift Card Number Already Exist");
				redirect(current_url());
		  }


          // $result = $this->Transactions_model->insert_giftcard($Company_id,$Logged_user_id);
          $result = $this->Transactions_model->insert_giftcard($Company_id,$company_details->Gift_card_validity_days, $data['enroll']);

          $Gift_card_id = $this->input->post("gif_number");

          $giftcard_details = $this->Transactions_model->get_giftcard_details($Gift_card_id, $Company_id);
		  
          foreach ($giftcard_details as $giftcard) {
            $Card_balance = $giftcard['Card_balance'];
            $User_name = $giftcard['User_name'];
            $Email = App_string_decrypt($giftcard['Email']);
            $Phone_no = App_string_decrypt($giftcard['Phone_no']);
            $Membership_id = $giftcard['Card_id'];
          }
          if ($Membership_id == '0') {
            $Enrollment_id = 0;
            $Walkin_customer = 1;
          } else {
            $customer_details = $this->Transactions_model->enrollment_details_frmemail_phn_card($Email, $Membership_id, $Phone_no, $Company_id);
            $Enrollment_id = $customer_details->Enrollement_id;
            $Walkin_customer = 0;
          }
          $Email_content = array(
              'Todays_date' => $lv_date_time,
              'GiftCardNo' => $Gift_card_id,
              'GiftCard_balance' => $Card_balance,
              'Enrollment_id' => $Enrollment_id,
              'Gift_card_user' => $User_name,
              'Gift_card_Email' => $Email,
              'Symbol_currency' => $Symbol_currency,
              'Walkin_customer' => $Walkin_customer,
              'Notification_type' => 'Gift Card',
              'Template_type' => 'Assign_Gift_card'
          );
		  // print_r($Email_content);
          $this->send_notification->send_Notification_email($Enrollment_id, $Email_content, $data['enroll'], $Company_id);

          if ($result == true) {
            $this->session->set_flashdata("success_code", "Gift Card Assigned Successfully!!");

            /*             * **************Nilesh change igain Log Table change 14-06-2017****************** */
            if ($Membership_id == '0') {
              $Enrollment_id = 0;
              $User_name = $this->input->post("user_name");
              $lastName = $this->input->post("user_name");
            } else {
              $get_cust_detail = $this->Igain_model->get_enrollment_details($Enrollment_id);
              $Enrollment_id = $get_cust_detail->Enrollement_id;
              $User_name = $get_cust_detail->First_name;
              $lastName = $get_cust_detail->Last_name;
            }
            $opration = 1;
            $userid = $session_data['userId'];
            $what = "Assign Gift Card";
            $where = "Assign Gift Card";
            $toname = "";
            $opval = 'GIft Card No-' . $Gift_card_id . ' (Card Balance - ' . $Card_balance . ' ) ';
            $firstName = $User_name;
            $lastName = '';

            // $result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$data['LogginUserName'],$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Enrollment_id);
            $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $session_data['enroll'], $session_data['username'], $session_data['Full_name'], $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Enrollment_id);

            /*****************Nilesh change igain Log Table change 14-06-2017********************* */
          } else {
            $this->session->set_flashdata("error_code", "Gift Card Not Assigned Successfully!");
          }
          redirect(current_url());
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    //******** Loyalty Transaction ********

    public function loyalty_transaction() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        //$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        if ($Sub_seller_admin == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;

        $company_details = $this->Igain_model->get_company_details($Company_id);
		
		 if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
 
          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;

        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Promo_code_applicable'] = $company_details->Promo_code_applicable;
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/loyalty_transaction";
        $total_row = $this->Transactions_model->loyalty_transaction_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
        /* -----------------------Pagination--------------------- */

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        if ($_POST == NULL) {
          $data["results"] = $this->Transactions_model->loyalty_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('transactions/loyalty_transaction', $data);
        } else {
          // $this->output->enable_profiler(TRUE);
          $Lp_count = $this->Administration_model->loyalty_rule_count($Company_id, $Logged_user_enrollid, $Logged_user_id);

          $categoryexist = $this->Transactions_model->check_seller_item_category($data['Company_id'], $data['enroll']);
          if ($Lp_count > 0) {
            if ($categoryexist > 0) {
              $cardis = $this->input->post("cardId");
              $_SESSION["cardId"] = $this->input->post("cardId");
              if (substr($cardis, 0, 1) == "%") {
                $get_card = substr($cardis, 2); //*******read card id from magnetic card***********///
              } else {
                $get_card = substr($cardis, 0, 16); //*******read card id from other magnetic card***********///
              }


              $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
              $phnumber = $dial_code.$this->input->post("cardId");

              $member_details = $this->Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
             //  print_r($member_details);die;
              foreach ($member_details as $rowis) {
                $cardId = $rowis['Card_id'];
                $user_activated = $rowis['User_activated'];
                $Phone_no = App_string_decrypt($rowis['Phone_no']);
              }


              if ($user_activated == 0 || $cardId == '0') {
                $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
                redirect(current_url());
              }

              if (strlen($cardis) != 0) {
                if ($cardis != '0') {
                  if ($cardId == $cardis || $Phone_no == $phnumber) {
                    $cust_details = $this->Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                    foreach ($cust_details as $row25) {
                      $fname = $row25['First_name'];
                      $midlename = $row25['Middle_name'];
                      $lname = $row25['Last_name'];
                      $bdate = $row25['Date_of_birth'];
                      $address = App_string_decrypt($row25['Current_address']);
                      $bal = $row25['Current_balance'];
                      $Blocked_points = $row25['Blocked_points'];
                      $Debit_points = $row25['Debit_points'];
                      $phno = App_string_decrypt($row25['Phone_no']);
                      $pinno = $row25['pinno'];
                      $companyid = $row25['Company_id'];
                      $cust_enrollment_id = $row25['Enrollement_id'];
                      $image_path = $row25['Photograph'];
                      $filename_get1 = $image_path;
                      $Tier_name = $row25['Tier_name'];
                      $Member_Tier_id = $row25['Tier_id'];
                    }

                    $tp_count = $this->Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                    $purchase_count = $this->Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                    $gainedpts_atseller = $this->Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $data['enroll']);
                    if ($gainedpts_atseller == NULL) {
                      $gainedpts_atseller = 0;
                    }

                    $Current_point_balance = $bal - ($Blocked_points + $Debit_points);

                    if ($Current_point_balance < 0) {
                      $Current_point_balance = 0;
                    } else {
                      $Current_point_balance = $Current_point_balance;
                    }
                    $data['get_card'] = $get_card;
                    $data['Cust_enrollment_id'] = $cust_enrollment_id;
                    $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                    $data['Phone_no'] = $phno;
                    $data['Customer_pin'] = $pinno;
                    $data['Current_balance'] = $Current_point_balance;
                    $data['Debit_points'] = $Debit_points;
                    // $data['Current_balance'] = $bal;
                    $data['Topup_count'] = $tp_count;
                    $data['Purchase_count'] = $purchase_count;
                    $data['Gained_points'] = $gainedpts_atseller;
                    $data['Photograph'] = $filename_get1;
                    $data['Tier_name'] = $Tier_name;
                    $data['MembershipID'] = $cardId;

                    //$data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);

                    $lp_array = $this->Transactions_model->get_tierbased_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, $Member_Tier_id);
                    $data['lp_array'] = $lp_array;
                    $data['referral_array'] = $this->Igain_model->get_transaction_referral_rule($Company_id, $Logged_user_enrollid, '2');

                    $Payment = $this->Igain_model->get_payement_type();
                    $data['Payment_array'] = $Payment;

                    if ($lp_array != "") {
                      $this->load->view('transactions/loyalty_purchase_transaction', $data);
                    } else {
                      $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!!, Please set Loyalty Rule...! !");
                      redirect(current_url());
                    }
                  } else {
                    $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Your Membership ID is not registered with us...! !");
                    redirect(current_url());
                  }
                } else {
                  $this->session->set_flashdata("error_code", "The Customer has not been Assigned a Membership ID yet! Please go to Assign Membership ID option.");
                  redirect(current_url());
                }
              } else {
                $this->session->set_flashdata("error_code", "Please enter valid Membership ID.");
                redirect(current_url());
              }
              // $this->load->view('transactions/loyalty_purchase_transaction', $data);
            } else {
              $this->session->set_flashdata("error_code", "The Merchant has not been Assigned a Category yet!! Please contact the Program Admin to set it to Enable Purchase Transaction");
              redirect(current_url());
            }
          } else {
            $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Loyalty rule is not set...! !");
            redirect(current_url());
          }
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function loyalty_purchase_transaction_ci() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $Country_id = $data['Country_id'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];

        $seller_details2 = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Seller_balance = $seller_details2->Current_balance;
        $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;
        $redemptionratio = $seller_details2->Seller_Redemptionratio;

        /*         * **********Get Company Details************************* */
        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $Sms_enabled = $company_details2->Sms_enabled;
        $Seller_topup_access = $company_details2->Seller_topup_access;
        $Allow_negative = $company_details2->Allow_negative;
        $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
        $Pin_no_applicable = $company_details2->Pin_no_applicable;
        $Allow_merchant_pin = $company_details2->Allow_merchant_pin;
        /*         * ******************************************************* */

        if ($_POST == NULL) {
          $this->session->set_flashdata("error_code", "Sorry, Loyalty Points Transaction Failed. Invalid Data Provided!!");
          redirect('Transactionc/loyalty_transaction');
        } else {
          if ($this->input->post("purchase_amt") == "" || $this->input->post("purchase_amt") <= 0 || $this->input->post("purchase_amt") == " ") {
            $this->session->set_flashdata("error_code", "Sorry, Loyalty Transaction Failed. Please Enter Valid Purchase Amount..!!");
            redirect('Transactionc/loyalty_transaction');
          } else {
			 
            $loyalty_points = 0;

            $reedem_points = $this->input->post("points_redeemed");
            $redeem_amount = ($reedem_points / $redemptionratio);
            $bal_pay = ($this->input->post("purchase_amt") - $redeem_amount);
            $TotalRedeemPoints = $reedem_points;

            $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
            $phnumber = $dial_code . $_SESSION["cardId"];

            $member_details = $this->Transactions_model->issue_bonus_member_details($Company_id, $_SESSION["cardId"], $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
            }

            $cust_details = $this->Transactions_model->cust_details_from_card($Company_id, $cardId);
            foreach ($cust_details as $row25) {
              $card_bal = $row25['Current_balance'];
              $Blocked_points = $row25['Blocked_points'];
              $Debit_points = $row25['Debit_points'];
              $Customer_enroll_id = $row25['Enrollement_id'];
              $topup = $row25['Total_topup_amt'];
              $purchase_amt = $row25['total_purchase'];
              $reddem_amt = $row25['Total_reddems'];
              $lv_member_Tier_id = $row25['Tier_id'];
              $Refree_enroll_id = $row25['Refrence'];
              $customer_name = $row25['First_name'] . " " . $row25['Last_name'];
              $City_id = $row25['City'];
              $State_id = $row25['State'];
              $Country_id = $row25['Country'];
              $Date_of_birth = $row25['Date_of_birth'];
              $Sex = $row25['Sex'];
              $District = $row25['District'];
              $Zipcode = $row25['Zipcode'];
              $total_purchase = $row25['total_purchase'];
              $Total_reddems = $row25['Total_reddems'];
              $joined_date = $row25['joined_date'];

              $Current_point_balance = $card_bal - ($Blocked_points + $Debit_points);

              if ($Current_point_balance < 0) {
                $Current_point_balance = 0;
              } else {
                $Current_point_balance = $Current_point_balance;
              }
            }

            $get_city_state_country = $this->Igain_model->Fetch_city_state_country($Company_id, $Customer_enroll_id);
            $State_name = $get_city_state_country->State_name;
            $City_name = $get_city_state_country->City_name;
            $Country_name = $get_city_state_country->Country_name;

            /*             * *****Pin No. Validation**************** */
            if ($Pin_no_applicable == 1) {
              $Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
              $pinno = $Enroll_details->pinno;
              if ($_REQUEST["cust_pin"] != $pinno) {
                $this->session->set_flashdata("error_code", "Transaction failed due to Invalid Pin No.");
                redirect('Transactionc/loyalty_transaction');
              }
            }
            /*             * *********************** */
			
			/*------Manual_bill_no Checking---12-08-2019--*/
				$result = $this->Transactions_model->check_bill_no($this->input->post("manual_bill_no"),$Company_id);				
				if ($result > 0) {
					
					$this->session->set_flashdata("error_code", "Transaction failed due to Invalid Bill No.");
					redirect('Transactionc/loyalty_transaction');
				
				}
			/*------Manual_bill_no Checking-----*/
            $redeem_by = $this->input->post("redeem_by");
			// echo"---reedem_points---".$reedem_points."----<br>";
			// echo"---Current_point_balance---".$Current_point_balance."----<br>";
			
            $go_ahead = 0;
			if ($reedem_points <= $Current_point_balance) {				
              $go_ahead = 1;			  
            } else {				
              $go_ahead = 0;
              $this->session->set_flashdata("error_code", "Sorry, Loyalty Transaction Failed. Please Enter Valid Redeem Points..!!");
              redirect('Transactionc/loyalty_transaction');
            }
            if (!(is_null($bal_pay)) && $go_ahead == 1) {
              $gained_points_fag = 0;
              $manual_bill_no = $this->input->post("manual_bill_no");
              $logtimezone = $data['timezone_entry'];
              $loyalty_prog = $this->input->post("lp_rules");

              $logtimezone = $session_data['timezone_entry'];
              $timezone = new DateTimeZone($logtimezone);
              $date = new DateTime();
              $date->setTimezone($timezone);
              $lv_date_time = $date->format('Y-m-d H:i:s');
              $Todays_date = $date->format('Y-m-d');

              $company_details2 = $this->Igain_model->get_company_details($Company_id);
              $Sms_enabled = $company_details2->Sms_enabled;
              $Seller_topup_access = $company_details2->Seller_topup_access;
              $Allow_negative = $company_details2->Allow_negative;

              if ($data['userId'] == 3) {
                $top_seller = $this->Transactions_model->get_top_seller($data['Company_id']);
                foreach ($top_seller as $sellers) {
                  $seller_id = $sellers['Enrollement_id'];
                  $Purchase_Bill_no = $sellers['Purchase_Bill_no'];
                  $Topup_Bill_no = $sellers['Topup_Bill_no'];
                  $username = $sellers['User_email_id'];
                  $remark_by = 'By Admin';
                  $seller_curbal = $sellers['Current_balance'];
                  $Seller_Redemptionratio = $sellers['Seller_Redemptionratio'];
                  $Seller_Refrence = $sellers['Refrence'];
                  $Seller_name = $sellers['First_name'] . " " . $sellers['Middle_name'] . " " . $sellers['Last_name'];
                  $Sub_seller_admin = $sellers['Sub_seller_admin'];
                  $Sub_seller_Enrollement_id = $sellers['Sub_seller_Enrollement_id'];
                }

                $remark_by = 'By Admin';
              } else {
                $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
                $seller_id = $user_details->Enrollement_id;
                $Purchase_Bill_no = $user_details->Purchase_Bill_no;
                $username = $user_details->User_email_id;
                $remark_by = 'By Seller';
                $seller_curbal = $user_details->Current_balance;
                $Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
                $Seller_Refrence = $user_details->Refrence;
                $Topup_Bill_no = $user_details->Topup_Bill_no;
                $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
                $Sub_seller_admin = $user_details->Sub_seller_admin;
                $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;

                if ($user_details->Sub_seller_admin == 1) {
                  $remark_by = 'By SubSeller';
                } else {
                  $remark_by = 'By Seller';
                }
              }

              $Seller_category = $this->Igain_model->get_seller_category($seller_id, $Company_id);

              if ($Seller_category == 0) {
                $this->session->set_flashdata("error_code", "The Merchant has not been assigned a Category yet!! Please contact the Program Admin to set it to Enable Loyalty Transaction.!");

                redirect('Transactionc/loyalty_transaction');
              }

              $points_array = array();

              foreach ($loyalty_prog as $prog) {
                $member_Tier_id = $lv_member_Tier_id;

                $value = array();
                $dis = array();

                $LoyaltyID_array = array();
                $Loyalty_at_flag = 0;
                $lp_type = substr($prog, 0, 2);

                //***** get loyalty program details ******************/

                if ($Sub_seller_admin == 1) {
                  $seller_id = $seller_id;
                } else {
                  $seller_id = $Sub_seller_Enrollement_id;
                }

                $lp_details = $this->Transactions_model->get_loyalty_program_details($Company_id, $seller_id, $prog, $Todays_date);

                $lp_count = count($lp_details);

                foreach ($lp_details as $lp_data) {
                  $LoyaltyID = $lp_data['Loyalty_id'];
                  $lp_name = $lp_data['Loyalty_name'];
                  $lp_From_date = $lp_data['From_date'];
                  $lp_Till_date = $lp_data['Till_date'];
                  $Loyalty_at_value = $lp_data['Loyalty_at_value'];
                  $Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
                  $discount = $lp_data['discount'];
                  $lp_Tier_id = $lp_data['Tier_id'];

                  if ($lp_Tier_id == 0) {
                    $member_Tier_id = $lp_Tier_id;
                  }

                  if ($Loyalty_at_value > 0) {
                    $value[] = $Loyalty_at_value;
                    $dis[] = $discount;
                    $LoyaltyID_array[] = $LoyaltyID;

                    $Loyalty_at_flag = 1;
                  }

                  if ($Loyalty_at_transaction > 0) {
                    $value[] = $Loyalty_at_transaction;
                    $dis[] = $Loyalty_at_transaction;
                    $LoyaltyID_array[] = $LoyaltyID;

                    $Loyalty_at_flag = 2;
                  }
                }


                if ($lp_type == 'PA') {
                  $transaction_amt = $this->input->post("purchase_amt");
                }

                if ($lp_type == 'BA') {
                  $transaction_amt = $bal_pay;
                }

                if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 1) {
                  for ($i = 0; $i <= count($value) - 1; $i++) {
                    if ($value[$i + 1] != "") {
                      if ($transaction_amt > $value[$i] && $transaction_amt <= $value[$i + 1]) {

                        $loyalty_points = $this->Transactions_model->get_discount($transaction_amt, $dis[$i]);

                        $trans_lp_id = $LoyaltyID_array[$i];
                        $gained_points_fag = 1;

                        $points_array[] = $loyalty_points;
                      }
                    } else if ($transaction_amt > $value[$i]) {

                      $loyalty_points = $this->Transactions_model->get_discount($transaction_amt, $dis[$i]);

                      $gained_points_fag = 1;
                      $trans_lp_id = $LoyaltyID_array[$i];

                      $points_array[] = $loyalty_points;
                    }
                  }
                }
                if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 2) {
                  $loyalty_points = $this->Transactions_model->get_discount($transaction_amt, $dis[0]);

                  $points_array[] = $loyalty_points;

                  $gained_points_fag = 1;
                  $trans_lp_id = $LoyaltyID_array[0];
                }
                if ($member_Tier_id == $lp_Tier_id && $loyalty_points > 0) {
                  $child_data = array(
                      'Company_id' => $Company_id,
                      'Transaction_date' => $lv_date_time,
                      // 'Seller' => $seller_id,
                      'Seller' => $data['enroll'],
                      'Enrollement_id' => $Customer_enroll_id,
                      'Transaction_id' => 0,
                      'Loyalty_id' => $trans_lp_id,
                      'Reward_points' => $loyalty_points,
                  );

                  $child_result = $this->Transactions_model->insert_loyalty_transaction_child($child_data);
                }
              }

              $total_loyalty_points = array_sum($points_array);

              /* ----------------Apply Rule for Segmanet base------------- */
              /* ----------------Get Seller segment based Rule------------ */
              $Get_segment_rule = $this->Transactions_model->get_segment_seller_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, $Todays_date);

              if ($Get_segment_rule != NULL) {
                foreach ($Get_segment_rule as $segrule) {

                  $member_Tier_id = $lv_member_Tier_id;

                  $LoyaltyID = $segrule['Loyalty_id'];
                  $seg_lp_name = $segrule['Loyalty_name'];
                  $lp_From_date = $segrule['From_date'];
                  $lp_Till_date = $segrule['Till_date'];
                  $Loyalty_at_value = $segrule['Loyalty_at_value'];
                  $Loyalty_at_transaction = $segrule['Loyalty_at_transaction'];
                  $discount = $segrule['discount'];
                  $seg_lp_Tier_id = $segrule['Tier_id'];
                  $Flat_file_flag = $segrule['Flat_file_flag'];
                  $Category_flag = $segrule['Category_flag'];
                  $Category_id = $segrule['Category_id'];
                  $Segment_flag = $segrule['Segment_flag'];
                  $Segment_code = $segrule['Segment_id'];

                  $Loyalty_at_flag = 0;
                  $lp_type = substr($seg_lp_name, 0, 2);
                  if ($seg_lp_Tier_id == 0) {
                    $member_Tier_id = $seg_lp_Tier_id;
                  } else {
                    $member_Tier_id = $member_Tier_id;
                  }

                  if ($Loyalty_at_value > 0) {
                    $value1[] = $Loyalty_at_value;
                    $dis1[] = $discount;
                    $LoyaltyID_array[] = $LoyaltyID;
                    $Loyalty_at_flag = 1;
                  }
                  if ($Loyalty_at_transaction > 0) {
                    $value1[] = $Loyalty_at_transaction;
                    $dis1[] = $Loyalty_at_transaction;
                    $LoyaltyID_array[] = $LoyaltyID;
                    $Loyalty_at_flag = 2;
                  }
                  if ($lp_type == 'PA') {
                    $transaction_amt = $this->input->post("purchase_amt");
                  }

                  if ($lp_type == 'BA') {
                    $transaction_amt = $bal_pay;
                  }

                  if ($Segment_flag == 1) {

                    $Get_segments2 = $this->Segment_model->edit_segment_id($Company_id, $Segment_code);

                    $Customer_array = array();
                    $Applicable_array[] = 0;
                    unset($Applicable_array);
                    print_r($Get_segments2);
                    foreach ($Get_segments2 as $Get_segments) {

                      /* -----------------Age--------------- */
                      if ($Get_segments->Segment_type_id == 1) {
                        $lv_Cust_value = date_diff(date_create($Date_of_birth), date_create('today'))->y;
                      }
                      /* -----------------Sex--------------- */
                      if ($Get_segments->Segment_type_id == 2) {
                        $lv_Cust_value = $Sex;
                        // echo "****Sex ".$lv_Cust_value;
                      }
                      /* -----------------Country--------------- */
                      if ($Get_segments->Segment_type_id == 3) {
                        $lv_Cust_value = $Country_name;

                        if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                          $Get_segments->Value = $lv_Cust_value;
                        }
                      }
                      /* -----------------District--------------- */
                      if ($Get_segments->Segment_type_id == 4) {

                        $lv_Cust_value = $District;
                        if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                          $Get_segments->Value = $lv_Cust_value;
                        }
                      }
                      /* -----------------State--------------- */
                      if ($Get_segments->Segment_type_id == 5) {
                        $lv_Cust_value = $State_name;

                        if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                          $Get_segments->Value = $lv_Cust_value;
                        }
                      }
                      /* -----------------city--------------- */
                      if ($Get_segments->Segment_type_id == 6) {

                        $lv_Cust_value = $City_name;

                        if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                          $Get_segments->Value = $lv_Cust_value;
                        }
                      }
                      /* -----------------Zipcode--------------- */
                      if ($Get_segments->Segment_type_id == 7) {

                        $lv_Cust_value = $Zipcode;
                      }
                      /* -----------------Cumulative Purchase Amount--------------- */
                      if ($Get_segments->Segment_type_id == 8) {
                        $lv_Cust_value = $total_purchase;
                      }
                      /* -----------------Cumulative Points Redeem--------------- */
                      if ($Get_segments->Segment_type_id == 9) {

                        $lv_Cust_value = $Total_reddems;
                      }
                      /* -----------------Cumulative Points Accumulated--------------- */
                      if ($Get_segments->Segment_type_id == 10) {

                        $start_date = $joined_date;
                        $end_date = date("Y-m-d");
                        $transaction_type_id = 2;
                        $Tier_id = $lp_Tier_id;
                        $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $Customer_enroll_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
                        foreach ($Trans_Records as $Trans_Records) {
                          $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                        }
                      }
                      /* -----------------Single Transaction  Amount--------------- */
                      if ($Get_segments->Segment_type_id == 11) {

                        $start_date = $joined_date;
                        $end_date = date("Y-m-d");
                        $transaction_type_id = 2;
                        $Tier_id = $seg_lp_Tier_id;
                        $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Customer_enroll_id, $transaction_type_id, $Tier_id, '', '');
                        foreach ($Trans_Records as $Trans_Records) {
                          $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                        }
                        $lv_Cust_value = max($lv_Max_amt);
                      }

                      /* -----------------Membership Tenor--------------- */
                      if ($Get_segments->Segment_type_id == 12) {

                        $tUnixTime = time();
                        list($year, $month, $day) = EXPLODE('-', $joined_date);
                        $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                        $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                      }
                      $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                      $Applicable_array[] = $Get_segments;
                    }

                    $gained_points_fag1 = 0;
                    if (!in_array(0, $Applicable_array, true)) {

                      $Customer_array[] = $Customer_enroll_id;

                      if ($member_Tier_id == $seg_lp_Tier_id && $Loyalty_at_flag == 1) {

                        for ($i = 0; $i < count($value1); $i++) {

                          if ($value1[$i + 1] != "") {

                            if ($transaction_amt > $value1[$i] && $transaction_amt <= $value1[$i + 1]) {
                              // echo "----dis1--11---".$dis1[$i]."---<br>";
                              $loyalty_points1 = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis1[$i]);
                              $points_array1[] = $loyalty_points1;
                              $trans_lp_id = $LoyaltyID_array[$i];
                              $gained_points_fag1 = 1;
                            }
                          } else if ($transaction_amt > $value1[$i]) {
                            // echo "----dis1--22---".$dis1[$i]."---<br>";
                            $loyalty_points1 = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis1[$i]);
                            $points_array1[] = $loyalty_points1;
                            $gained_points_fag1 = 1;
                            $trans_lp_id = $LoyaltyID_array[$i];
                          }
                        }
                      }
                      if ($member_Tier_id == $seg_lp_Tier_id && $Loyalty_at_flag == 2) {

                        $loyalty_points1 = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis1[0]);
                        $points_array1[] = $loyalty_points1;
                        $gained_points_fag1 = 1;
                        $trans_lp_id = $LoyaltyID_array[0];
                      }
                      if ($loyalty_points1 > 0) {

                        /* ---Insert Into Child Table --- */;
                        $child_data = array(
                            'Company_id' => $Company_id,
                            'Transaction_date' => $lv_date_time,
                            'Seller' => $seller_id,
                            'Enrollement_id' => $Customer_enroll_id,
                            'Transaction_id' => 0,
                            // 'Loyalty_id' => $trans_lp_id,
                            'Loyalty_id' => $LoyaltyID,
                            'Reward_points' => $loyalty_points1,
                        );

                        $child_result = $this->Coal_Transactions_model->insert_loyalty_transaction_child($child_data);
                      }
                    }
                  }
                  unset($dis1);
                  unset($value1);

                  if ($gained_points_fag1 == 1) {
                    $total_loyalty_points1 = array_sum($points_array1);
                  } else {
                    $total_loyalty_points1 = 0;
                  }

                  unset($trans_lp_id);
                }
              } else {
                $total_loyalty_points1 = 0;
              }

              /* ----------------Get Seller segment based Rule--------------------------- */

              $total_loyalty_points = $total_loyalty_points + $total_loyalty_points1;

              /* ----------------Apply Rule for Segmanet base-13-08-2018--------------- */

              $Promo_redeem_by = $this->input->post("Promo_redeem_by");

              $tp_db = $Purchase_Bill_no;
              $len = strlen($tp_db);
              $str = substr($tp_db, 0, 5);
              $bill = substr($tp_db, 5, $len);

              if ($Promo_redeem_by == 1) { //******** Promo Code Redeem *********/

                $PromoCode = $this->input->post('Promo_code');
                $PointsRedeem = $this->input->post('promo_points_redeemed');

                $promo_transaction_data = array(
                    'Trans_type' => '7',
                    'Topup_amount' => $PointsRedeem,
                    'Company_id' => $Company_id,
                    'Trans_date' => $lv_date_time,
                    'Bill_no' => $bill,
                    'Manual_billno' => $manual_bill_no,
                    'remark2' => 'PromoCode Transaction-(' . $PromoCode . ')',
                    'Card_id' => $cardId,
                    'Seller_name' => $Seller_name,
                    // 'Seller' => $seller_id,
                    'Seller' => $data['enroll'],
                    'Enrollement_id' => $Customer_enroll_id,
                );

                $insert_promo_transaction_id = $this->Transactions_model->insert_loyalty_transaction($promo_transaction_data);

                $post_data21 = array('Promo_code_status' => '1');

                $update_promo_code = $this->Transactions_model->utilize_promo_code($Company_id, $PromoCode, $post_data21);

                $TotalRedeemPoints = $TotalRedeemPoints + $PointsRedeem;

                $bill = $bill + 1;
              }

              $Gift_redeem_by = $this->input->post("Gift_redeem_by");

              if ($Gift_redeem_by == 1) { //******** Gift Card Redeem *********/

                $gift_reedem = $this->input->post('gift_points_redeemed');

                $GiftCardNo = $this->input->post('GiftCardNo');
                $GiftBal = $this->input->post('Balance');
                $current_gift_balance = $GiftBal - $gift_reedem;
				
				if($current_gift_balance > 0 )
				{
					$current_gift_balance=$current_gift_balance;
				} else {
					$current_gift_balance=0;
				} 
				
				/* echo"--GiftCardNo----".$GiftCardNo."---<br>";
				echo"--GiftBal----".$GiftBal."---<br>";
				echo"--gift_reedem----".$gift_reedem."---<br>";
				echo"--current_gift_balance----".$current_gift_balance."---<br>";
				die; */

                $gift_transaction_data = array(
                    'Trans_type' => '4',
                    'Purchase_amount' => $gift_reedem,
                    'Redeem_points' => $gift_reedem,
                    'Company_id' => $Company_id,
                    'Trans_date' => $lv_date_time,
                    'Payment_type_id' => '1',
                    'Card_id' => $cardId,
                    'GiftCardNo' => $GiftCardNo,
                    'Bill_no' => $bill,
                    'Manual_billno' => $manual_bill_no,
                    'Seller_name' => $Seller_name,
                    // 'Seller' => $seller_id,
                    'Seller' => $data['enroll'],
                    'Enrollement_id' => $Customer_enroll_id,
                );

                $insert_gift_transaction = $this->Transactions_model->insert_loyalty_transaction($gift_transaction_data);


                $result32 = $this->Transactions_model->update_giftcard_balance($GiftCardNo, $current_gift_balance, $Company_id);

                $TotalRedeemPoints = $TotalRedeemPoints + $gift_reedem;

                $bill = $bill + 1;
      
              }

              $Gift_redeem_by = $this->input->post("Gift_redeem_by");

              if ($Gift_redeem_by == 1) { //******** Gift Card Redeem *********/

                $gift_reedem = $this->input->post('gift_points_redeemed');

                $GiftCardNo = $this->input->post('GiftCardNo');
                $GiftBal = $this->input->post('Balance');
                $current_gift_balance = $GiftBal - $gift_reedem;
				
				if($current_gift_balance > 0 )
				{
					$current_gift_balance=$current_gift_balance;
				} else {
					$current_gift_balance=0;
				} 
				
				/* echo"--GiftCardNo----".$GiftCardNo."---<br>";
				echo"--GiftBal----".$GiftBal."---<br>";
				echo"--gift_reedem----".$gift_reedem."---<br>";
				echo"--current_gift_balance----".$current_gift_balance."---<br>";
				die; */

                $gift_transaction_data = array(
                    'Trans_type' => '4',
                    'Purchase_amount' => $gift_reedem,
                    'Redeem_points' => $gift_reedem,
                    'Company_id' => $Company_id,
                    'Trans_date' => $lv_date_time,
                    'Payment_type_id' => '1',
                    'Card_id' => $cardId,
                    'GiftCardNo' => $GiftCardNo,
                    'Bill_no' => $bill,
                    'Manual_billno' => $manual_bill_no,
                    'Seller_name' => $Seller_name,
                    // 'Seller' => $seller_id,
                    'Seller' => $data['enroll'],
                    'Enrollement_id' => $Customer_enroll_id,
                );

                $insert_gift_transaction = $this->Transactions_model->insert_loyalty_transaction($gift_transaction_data);


                $result32 = $this->Transactions_model->update_giftcard_balance($GiftCardNo, $current_gift_balance, $Company_id);

                $TotalRedeemPoints = $TotalRedeemPoints + $gift_reedem;

                $bill = $bill + 1;
              }
              $bill_no = $bill + 1;
              if ($this->input->post('Promo_code') != "") {
                $Promo_code = 'PromoCode-(' . $this->input->post('Promo_code') . ')';
              } else {
                $Promo_code = "";
              }
              if ($this->input->post('GiftCardNo') != "") {
                $GiftCardNo = $this->input->post("GiftCardNo");
              } else {
                $GiftCardNo = 0;
              }
              if ($this->input->post('points_redeemed') != "") {
                $Redeem_points = $this->input->post("points_redeemed");
              } else {
                $Redeem_points = 0;
              }

              $post_data = array(
                  'Trans_type' => '2',
                  'Company_id' => $Company_id,
                  'Purchase_amount' => $this->input->post("purchase_amt"),
                  'Trans_date' => $lv_date_time,
                  'Remarks' => $this->input->post('remark'),
                  'Card_id' => $cardId,
                  'Seller_name' => $Seller_name,
                  // 'Seller' => $seller_id,
                  'Seller' => $data['enroll'],
                  'Enrollement_id' => $Customer_enroll_id,
                  'Bill_no' => $bill,
                  'Manual_billno' => $manual_bill_no,
                  'remark2' => $remark_by,
                  'Remarks' => $this->input->post("remark"),
                  'Loyalty_pts' => $total_loyalty_points,
                  'Paid_amount' => $bal_pay,
                  'Redeem_points' => $Redeem_points,
                  'Payment_type_id' => $this->input->post("Payment_type"),
                  'balance_to_pay' => $bal_pay,
                  'Bank_name' => $this->input->post("Bank_name"),
                  'Branch_name' => $this->input->post("Branch_name"),
                  'Credit_Cheque_number' => $this->input->post("Credit_Cheque_number"),
                  'purchase_category' => $Seller_category,
                  'Source' => 0,
                  'GiftCardNo' => $GiftCardNo,
                  'Voucher_no' => $Promo_code,
                  'Create_user_id' => $data['enroll']
              );

              $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_data);

              /*               * ************Nilesh change igain Log Table change 14-06-2017********************* */
              $get_cust_detail = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
              $Enrollement_id = $get_cust_detail->Enrollement_id;
              $First_name = $get_cust_detail->First_name;
              $Last_name = $get_cust_detail->Last_name;
              $opration = 1;
              $userid = $data['userId'];
              $what = "Loyalty Purchase Transaction";
              $where = "Perform Transaction";
              $toname = "";
              $opval = $this->input->post("purchase_amt") . ' Amount.';  // Transaction amt
              $firstName = $First_name;
              $lastName = $Last_name;

              $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);
              /*               * *****************igain Log Table change 14-06-2017****************** */

              $result = $this->Transactions_model->update_loyalty_transaction_child($Company_id, $lv_date_time, $data['enroll'], $Customer_enroll_id, $insert_transaction_id);

              $curr_bal = $card_bal + $total_loyalty_points;

              $curr_bal = $curr_bal - $Redeem_points;

              $topup_amt = $topup;

              $transaction_purchase_amt = $this->input->post("purchase_amt");

              $purchase_amount = $purchase_amt + $transaction_purchase_amt;

              $transaction_redeem_amt = $this->input->post("redeem_amt");


              $reddem_amount = $reddem_amt + $Redeem_points;

              $result2 = $this->Transactions_model->update_customer_balance($cardId, $curr_bal, $Company_id, $topup_amt, $lv_date_time, $purchase_amount, $reddem_amount);

              $billno_withyear = $str . $bill_no;

              if ($Sms_enabled == '1') {
                /*                 * *******************************Send SMS Code****************************** */
              }

              if ($Refree_enroll_id > 0) {
                $ref_cust_details = $this->Igain_model->get_enrollment_details($Refree_enroll_id);

                $referre_membershipID = $ref_cust_details->Card_id;
                $ref_card_bal = $ref_cust_details->Current_balance;
                $ref_Customer_enroll_id = $ref_cust_details->Enrollement_id;
                $ref_topup_amt = $ref_cust_details->Total_topup_amt;
                $ref_purchase_amt = $ref_cust_details->total_purchase;
                $ref_reddem_amt = $ref_cust_details->Total_reddems;
                $member_Tier_id = $ref_cust_details->Tier_id;
                $ref_customer_name = $ref_cust_details->First_name . " " . $ref_cust_details->Last_name;

                $Refree_topup = 0;

                $Referral_rule_for = 2; //*** Referral_rule_for transaction
                $Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id, $Company_id, $Referral_rule_for);
                $total_ref_topup = 0;

                foreach ($Ref_rule as $rule) {
                  $ref_start_date = $rule['From_date'];
                  $ref_end_date = $rule['Till_date'];
                  //$ref_Tier_id = $rule['Tier_id'];

                  if ($ref_start_date <= $Todays_date && $ref_end_date >= $Todays_date) {
                    $ref_topup = $rule['Refree_topup'];
                  }

                  $total_ref_topup = $total_ref_topup + $ref_topup;
                }

                if ($Seller_Refrence == 1 && $total_ref_topup > 0) {
                  $refree_current_balnce = $ref_card_bal + $total_ref_topup;
                  $refree_topup = $ref_topup_amt + $total_ref_topup;

                  $result5 = $this->Transactions_model->update_customer_balance($referre_membershipID, $refree_current_balnce, $Company_id, $refree_topup, $Todays_date, $ref_purchase_amt, $ref_reddem_amt);

                  $seller_curbal = $seller_curbal - $total_ref_topup;

                  $top_db = $Topup_Bill_no;
                  $len = strlen($top_db);
                  $str = substr($top_db, 0, 5);
                  $tp_bill = substr($top_db, 5, $len);

                  $topup_BillNo = $tp_bill + 1;
                  $billno_withyear_ref = $str . $topup_BillNo;

                  $post_Transdata = array(
                      'Trans_type' => '1',
                      'Company_id' => $Company_id,
                      'Topup_amount' => $total_ref_topup,
                      'Trans_date' => $lv_date_time,
                      'Remarks' => 'Referral Trans',
                      'Card_id' => $referre_membershipID,
                      'Seller_name' => $Seller_name,
                      'Seller' => $seller_id,
                      'Create_user_id' => $data['enroll'],
                      //'Seller' =>$data['enroll'],
                      'Enrollement_id' => $ref_Customer_enroll_id,
                      'Bill_no' => $tp_bill,
                      'Manual_billno' => $manual_bill_no,
                      'remark2' => $remark_by,
                      'Loyalty_pts' => '0'
                  );

                  $result6 = $this->Transactions_model->insert_topup_details($post_Transdata);

                  $result7 = $this->Transactions_model->update_topup_billno($data['enroll'], $billno_withyear_ref);

                  //$Todays_date = date("Y-m-d");

                  $Email_content12 = array(
                      'Ref_Topup_amount' => $total_ref_topup,
                      'Notification_type' => 'Referral Topup',
                      'Template_type' => 'Referral_topup',
                      'Customer_name' => $customer_name,
                      'Todays_date' => $lv_date_time
                  );

                  $this->send_notification->send_Notification_email($ref_Customer_enroll_id, $Email_content12, $seller_id, $Company_id);
                }
              }

              if ($Seller_topup_access == '1') {
                $Total_seller_bal = $seller_curbal - $total_loyalty_points;
                $Total_seller_bal = $Total_seller_bal + $reedem_points;
                $result3 = $this->Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

                /*                 * *******************Send Threshold Mail*************** */
                $company_details = $this->Igain_model->get_company_details($Company_id);
                $Threshold_Merchant = $company_details->Threshold_Merchant;

                $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                $Seller_balance = $seller_details2->Current_balance;
                $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;

                if ($Threshold_Merchant >= $Seller_balance) {
                  //****mail to super seller
                  $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                  $Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
                  $Admin_Email_content = array(
                      'Seller_name' => $Seller_full_name,
                      'Seller_balance' => $Seller_balance,
                      'Super_Seller_flag' => 1,
                      'Notification_type' => "Seller Threshold Balance",
                      'Template_type' => 'Seller_threshold'
                  );
                  $this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
                  //****mail to super seller
                  //****mail to seller
                  $Seller_Email_content = array(
                      'Seller_name' => $Seller_full_name,
                      'Seller_balance' => $Seller_balance,
                      'Company_admin' => $Company_admin,
                      'Super_Seller_flag' => 0,
                      'Notification_type' => "Seller Threshold Balance",
                      'Template_type' => 'Seller_threshold'
                  );
                  $this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
                  //****mail to seller
                }
                /*                 * *******************Send Threshold Mail*************** */
              }


              $result4 = $this->Transactions_model->update_billno($data['enroll'], $billno_withyear);

              $Notification_type = "Loyalty Transaction";
              $purchase_amt = $this->input->post("purchase_amt");
              $reedem = $this->input->post("points_redeemed"); //$this->input->post("points_redeemed");
              $payment_by = $this->input->post("Payment_type");
              $balance_to_pay = $bal_pay;

              $seller_details = $this->Igain_model->get_enrollment_details($seller_id);
              $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
              $Symbol_currency = $currency_details->Symbol_of_currency;


              $Email_content = array(
                  'Today_date' => $lv_date_time,
                  'Manual_bill_no' => $manual_bill_no,
                  'Purchase_amount' => $purchase_amt,
                  'Redeem_points' => $reedem,
                  'Payment_by' => $payment_by,
                  'Balance_to_pay' => $balance_to_pay,
                  'Total_loyalty_points' => $total_loyalty_points,
                  'Symbol_currency' => $Symbol_currency,
                  'GiftCardNo' => $GiftCardNo,
                  'gift_reedem' => $gift_reedem,
                  'Notification_type' => $Notification_type,
                  'Template_type' => 'Loyalty_transaction'
              );
              $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);

              if (($insert_transaction_id > 0) && ($result2 == true) && ($result4 == true)) {
                $this->session->set_flashdata("success_code", "Loyalty Transaction done Successfully!!");
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Loyalty Transaction Failed!!");
              }
              redirect('Transactionc/loyalty_transaction');
            }
          }
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Joy_transaction() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        //$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($data['Company_id']);

        if ($Sub_seller_admin == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }

        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;

        if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
          $company_details = $this->Igain_model->get_company_details($data['Company_id']);

          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;

        $company_details = $this->Igain_model->get_company_details($Company_id);
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;

        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Promo_code_applicable'] = $company_details->Promo_code_applicable;
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/Joy_transaction";
        $total_row = $this->Transactions_model->loyalty_transaction_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
        /* -----------------------Pagination--------------------- */

        $data["results"] = $this->Transactions_model->loyalty_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);

        $data["pagination"] = $this->pagination->create_links();

        $Lp_count = $this->Administration_model->loyalty_rule_count($Company_id, $Logged_user_enrollid, $Logged_user_id);

        $Payment = $this->Igain_model->get_payement_type();
        $data['Payment_array'] = $Payment;

        if ($Lp_count > 0) {
          $lp_array = $this->Transactions_model->get_tierbased_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, 0); //$Member_Tier_id

          $data['lp_array'] = $lp_array;

          $this->load->view('transactions/Joy_transaction', $data);
        } else {
          $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Loyalty rule is not set...! !");

          $this->load->view('transactions/Joy_transaction', $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Fetch_member_details() { //Fetch_Member_info
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $Country_id = $data['Country_id'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];

        $Company_details = $this->Igain_model->get_company_details($Company_id);

        $Coalition = $Company_details->Coalition;
        //echo"---Coalition-----".$Coalition."---<br>";
        $Membership_id = $_REQUEST['Membership_id'];

        $dial_code = $this->Enroll_model->get_dial_code($Country_id);
        $_SESSION["cardId"] = $_REQUEST['Membership_id'];
        $phnumber = $dial_code . $Membership_id;

        if ($Coalition == 1) {


          $result = $this->Transactions_model->get_member_info($Membership_id, $Company_id, $phnumber); //Get Customer details
          if ($result != NULL) {
            $tp_count = $this->Transactions_model->get_count_topup($result->Card_id, $result->Enrollement_id, $data['enroll']);

            $purchase_count = $this->Transactions_model->get_count_purchase($result->Card_id, $result->Enrollement_id, $data['enroll']);

            $gainedpts_atseller = $this->Transactions_model->gained_points_atseller($result->Card_id, $result->Enrollement_id, $data['enroll']);


            /*             * ***********Get Customer merchant balance**************** */
            $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($data['enroll'], $result->Enrollement_id);

            foreach ($Get_Record as $val) {
              $Cust_seller_balance[] = $val["Cust_seller_balance"];
              $Seller_total_purchase[] = $val["Seller_total_purchase"];
              $Seller_total_redeem[] = $val["Seller_total_redeem"];
              $Seller_total_gain_points[] = $val["Seller_total_gain_points"];
              $Seller_total_topup[] = $val["Seller_total_topup"];
              $Seller_paid_balance[] = $val["Seller_paid_balance"];
              $Cust_prepayment_balance[] = $val["Cust_prepayment_balance"];
              $Cust_block_amt[] = $val["Cust_block_amt"];
              $Cust_block_points[] = $val["Cust_block_points"];
              $Cust_debit_points[] = $val["Cust_debit_points"];
            }

            $Current_balance = array_sum($Cust_seller_balance);
            $Blocked_points = array_sum($Cust_block_points);
            $Debit_points = array_sum($Cust_debit_points);

            /*             * ******************************************************************** */

            /* echo"----Current_balance-----".$Current_balance."----<br>";
              echo"----Blocked_points-----".$Blocked_points."----<br>";
              echo"----Debit_points-----".$Debit_points."----<br>"; */

            /* $Current_balance = $result->Current_balance;
              $Blocked_points = $result->Blocked_points;
              $Debit_points = $result->Debit_points; */

            $Current_point_balance = $Current_balance - ($Blocked_points + $Debit_points);

            if ($Current_point_balance < 0) {
              $Current_point_balance = 0;
            } else {
              $Current_point_balance = $Current_point_balance;
            }

            $Tier_id = $result->Tier_id;
            $First_name = $result->First_name;
            $Last_name = $result->Last_name;
            $Memeber_name = $First_name . ' ' . $Last_name;

            $lp_array = $this->Transactions_model->get_tierbased_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, $Tier_id); //$Member_Tier_id
            $data['lp_array'] = $lp_array;

            $today = date("Y-m-d");

            if ($lp_array != NULL) {
              foreach ($lp_array as $lp) {
                if ($today >= $lp->From_date && $today <= $lp->Till_date) {
                  $Loyalty_details[] = array
                      (
                      "Loyalty_id" => $lp->Loyalty_id,
                      "Loyalty_name" => $lp->Loyalty_name
                  );
                } else {
                  $Loyalty_details = array();
                }
              }
            } else {
              $Loyalty_details = array();
            }

            $member_details = array(
                "Error_flag" => 1001,
                "Seller_id" => $Logged_user_enrollid,
                "Cust_enroll_id" => $result->Enrollement_id,
                "card_id" => $result->Card_id,
                "pinno" => $result->pinno,
                "Member_name" => $Memeber_name,
                "Member_email" => App_string_decrypt($result->User_email_id),
                "Phone_no" => App_string_decrypt($result->Phone_no),
                "Tier_name" => $result->Tier_name,
                "Current_balance" => $Current_point_balance,
                "Debit_points" => $Debit_points,
                "Topup_count" => $tp_count,
                "Purchase_count" => $purchase_count,
                "GainPointAt_Seller" => $gainedpts_atseller,
                "Photograph" => $result->Photograph,
                "Loyalty_details" => $Loyalty_details
            );
          }
        } else {

          $result = $this->Transactions_model->get_member_info($Membership_id, $Company_id, $phnumber); //Get Customer details
          if ($result != NULL) {
            $tp_count = $this->Transactions_model->get_count_topup($result->Card_id, $result->Enrollement_id, $data['enroll']);

            $purchase_count = $this->Transactions_model->get_count_purchase($result->Card_id, $result->Enrollement_id, $data['enroll']);

            $gainedpts_atseller = $this->Transactions_model->gained_points_atseller($result->Card_id, $result->Enrollement_id, $data['enroll']);
            $Current_balance = $result->Current_balance;
            $Blocked_points = $result->Blocked_points;
            $Debit_points = $result->Debit_points;

            $Current_point_balance = $Current_balance - ($Blocked_points + $Debit_points);

            if ($Current_point_balance < 0) {
              $Current_point_balance = 0;
            } else {
              $Current_point_balance = $Current_point_balance;
            }

            $Tier_id = $result->Tier_id;
            $First_name = $result->First_name;
            $Last_name = $result->Last_name;
            $Memeber_name = $First_name . ' ' . $Last_name;

            $lp_array = $this->Transactions_model->get_tierbased_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, $Tier_id); //$Member_Tier_id
            $data['lp_array'] = $lp_array;

            $today = date("Y-m-d");

            if ($lp_array != NULL) {
              foreach ($lp_array as $lp) {
                if ($today >= $lp->From_date && $today <= $lp->Till_date) {
                  $Loyalty_details[] = array
                      (
                      "Loyalty_id" => $lp->Loyalty_id,
                      "Loyalty_name" => $lp->Loyalty_name
                  );
                } else {
                  $Loyalty_details = array();
                }
              }
            } else {
              $Loyalty_details = array();
            }

            $member_details = array(
                "Error_flag" => 1001,
                "Seller_id" => $Logged_user_enrollid,
                "Cust_enroll_id" => $result->Enrollement_id,
                "card_id" => $result->Card_id,
                "pinno" => $result->pinno,
                "Member_name" => $Memeber_name,
                "Member_email" => App_string_decrypt($result->User_email_id),
                "Phone_no" => App_string_decrypt($result->Phone_no),
                "Tier_name" => $result->Tier_name,
                "Current_balance" => $Current_point_balance,
                "Debit_points" => $result->Debit_points,
                "Topup_count" => $tp_count,
                "Purchase_count" => $purchase_count,
                "GainPointAt_Seller" => $gainedpts_atseller,
                "Photograph" => $result->Photograph,
                "Loyalty_details" => $Loyalty_details
            );
          }
        }





        if ($result != NULL) {
          echo json_encode($member_details);
        } else {
          $Result127 = array("Error_flag" => 2003);
          $this->output->set_output(json_encode($Result127)); //Unable to Locate membership id
        }
      }
    }

    public function Fetch_trans_details() { //Fetch_trans_info
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $Country_id = $data['Country_id'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;

        $Bill_no = $_REQUEST['Bill_no'];
        $Membership_id = $_REQUEST['Membership_id'];
        $dial_code = $this->Enroll_model->get_dial_code($Country_id);
        // $phnumber = $dial_code.$Membership_id;

        $result = $this->Transactions_model->get_member_trans_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid, $Membership_id); //Get Customer Trans details
		// echo $this->db->last_query();
		
        if ($result != NULL) {
          $PurchaseAmount = array();
          $LoyaltyPts = array();
          $RedeemPts = array();

          foreach ($result as $row) {
            $PurchaseAmount[] = $row['Purchase_amount'];
            $LoyaltyPts[] = $row['Loyalty_pts'];
            $RedeemPts[] = $row['Redeem_points'];

            $Trans_date = $row['Trans_date'];
            $Seller = $row['Seller'];
            // $Purchase_amount=$row['Purchase_amount'];
            // $Loyalty_pts=$row['Loyalty_pts'];
            // $Redeem_pts=$row['Redeem_pts'];
          }

          $Sum_PurchaseAmount = array_sum($PurchaseAmount);
          $Sum_LoyaltyPts = array_sum($LoyaltyPts);
          $Sum_RedeemPts = array_sum($RedeemPts);
        }

        if ($result != NULL) {
          $Trans_details = array(
              "Error_flag" => 1001,
              "Trans_date" => $Trans_date,
              "Purchase_amount" => $Sum_PurchaseAmount,
              "Loyalty_pts" => $Sum_LoyaltyPts,
              "Redeem_pts" => $Sum_RedeemPts,
              "Seller" => $Seller
          );
        }
        if ($result != NULL) {
          echo json_encode($Trans_details);
        } else {
          $Result1278 = array("Error_flag" => 2003);
          $this->output->set_output(json_encode($Result1278)); //Unable to Locate membership id
        }
      }
    }

    public function Fetch_transaction_details() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $Bill_no = $_REQUEST['Bill_no'];
        $Membership_id = $_REQUEST['Membership_id'];

        //echo "Sub_seller_admin---".$Sub_seller_admin;
        // $data['lp_array'] = $this->Transactions_model->Fetch_transaction_details($Loyalty_names,$CompanyID,$Logged_user_enroll,$Logged_user_id);

        $data['result'] = $this->Transactions_model->Fetch_transaction_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid, $Membership_id); //Get Customer Trans details
        //var_dump($data['result']);
        //$data['lp_array'] = $ref_array;


        $this->load->view('transactions/view_transactions_details', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Fetch_reference_transaction_details() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $Bill_no = $_REQUEST['Billno'];
        //var_dump($_REQUEST);
        //echo"--Bill_no--".$Bill_no."---<br>";
        $data['result_reference'] = $this->Transactions_model->Fetch_reference_transaction_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid);
        if ($data['result_reference'] != NULL) {

          $this->load->view('transactions/reference_transaction_details', $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Joy_purchase_transaction_ci() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $Country_id = $data['Country_id'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];

        $seller_details2 = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Seller_balance = $seller_details2->Current_balance;
        $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;
        $redemptionratio = $seller_details2->Seller_Redemptionratio;

        /*         * **********Get Company Details************************* */
        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $Sms_enabled = $company_details2->Sms_enabled;
        $Seller_topup_access = $company_details2->Seller_topup_access;
        $Allow_negative = $company_details2->Allow_negative;
        $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
        $Pin_no_applicable = $company_details2->Pin_no_applicable;
        /*         * ******************************************************* */

        if ($_POST == NULL) {
          $this->session->set_flashdata("error_code", "Sorry, Transaction Failed. Invalid Data Provided!!");
          redirect('Transactionc/Joy_transaction');
        } else {
          //$this->output->enable_profiler(TRUE);

          if ($this->input->post("purchase_amt") == "" || $this->input->post("purchase_amt") <= 0 || $this->input->post("purchase_amt") == " ") {
            $this->session->set_flashdata("error_code", "Sorry, Transaction Failed. Please Enter Valid Purchase Amount..!!");
            redirect('Transactionc/Joy_transaction');
          } else {
            $loyalty_points = 0;

            // $reedem_points = $this->input->post("points_redeemed");
            // $redeem_amount =($reedem_points/$redemptionratio);
            $bal_pay = $this->input->post("purchase_amt");
            // $TotalRedeemPoints = $reedem_points;

            $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
            $phnumber = $dial_code . $_SESSION["cardId"];

            $member_details = $this->Transactions_model->issue_bonus_member_details($Company_id, $_SESSION["cardId"], $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
            }

            $cust_details = $this->Transactions_model->cust_details_from_card($Company_id, $cardId);
            if ($cust_details != NULL) {
              foreach ($cust_details as $row25) {
                $card_bal = $row25['Current_balance'];
                $Customer_enroll_id = $row25['Enrollement_id'];
                $topup = $row25['Total_topup_amt'];
                $purchase_amt = $row25['total_purchase'];
                $reddem_amt = $row25['Total_reddems'];
                $lv_member_Tier_id = $row25['Tier_id'];
                $Refree_enroll_id = $row25['Refrence'];
                $customer_name = $row25['First_name'] . " " . $row25['Last_name'];
              }
            } else {
              $this->session->set_flashdata("Redeem_flash", "Transaction failed due to Invalid Membership ID/Phone No.");
              redirect('Transactionc/Joy_transaction');
            }

            /*             * *****************Pin No. Validation**************** */
            if ($Pin_no_applicable == 1) {
              $Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
              $pinno = $Enroll_details->pinno;
              if ($_REQUEST["cust_pin"] != $pinno) {
                $this->session->set_flashdata("Redeem_flash", "Transaction failed due to Invalid Pin No.");
                redirect('Transactionc/Joy_transaction');
              }
            }
            /*             * *****************Pin No. Validation**************** */
			
			
			/*------Manual_bill_no Checking---12-08-2019--*/
				$result = $this->Transactions_model->check_bill_no($this->input->post("manual_bill_no"),$Company_id);				
				if ($result > 0) {
					
					$this->session->set_flashdata("error_code", "Transaction failed due to Invalid Bill No.");
					redirect('Transactionc/Joy_transaction');
				
				}
			/*------Manual_bill_no Checking-----*/

            if (!(is_null($bal_pay))) {
              $gained_points_fag = 0;
              $manual_bill_no = $this->input->post("manual_bill_no");
              $logtimezone = $data['timezone_entry'];
              $loyalty_prog = $this->input->post("lp_rules");

              $logtimezone = $session_data['timezone_entry'];
              $timezone = new DateTimeZone($logtimezone);
              $date = new DateTime();
              $date->setTimezone($timezone);
              $lv_date_time = $date->format('Y-m-d H:i:s');
              $Todays_date = $date->format('Y-m-d');

              $company_details2 = $this->Igain_model->get_company_details($Company_id);
              $Sms_enabled = $company_details2->Sms_enabled;
              $Seller_topup_access = $company_details2->Seller_topup_access;
              $Allow_negative = $company_details2->Allow_negative;

              if ($data['userId'] == 3) {
                $top_seller = $this->Transactions_model->get_top_seller($data['Company_id']);
                foreach ($top_seller as $sellers) {
                  $seller_id = $sellers['Enrollement_id'];
                  $Purchase_Bill_no = $sellers['Purchase_Bill_no'];
                  $Topup_Bill_no = $sellers['Topup_Bill_no'];
                  $username = $sellers['User_email_id'];
                  $remark_by = 'By Admin';
                  $seller_curbal = $sellers['Current_balance'];
                  $Seller_Redemptionratio = $sellers['Seller_Redemptionratio'];
                  $Seller_Refrence = $sellers['Refrence'];
                  $Seller_name = $sellers['First_name'] . " " . $sellers['Middle_name'] . " " . $sellers['Last_name'];
                  $Sub_seller_admin = $sellers['Sub_seller_admin'];
                  $Sub_seller_Enrollement_id = $sellers['Sub_seller_Enrollement_id'];
                }

                $remark_by = 'By Admin';
              } else {
                $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
                $seller_id = $user_details->Enrollement_id;
                $Purchase_Bill_no = $user_details->Purchase_Bill_no;
                $username = $user_details->User_email_id;
                $remark_by = 'By Seller';
                $seller_curbal = $user_details->Current_balance;
                $Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
                $Seller_Refrence = $user_details->Refrence;
                $Topup_Bill_no = $user_details->Topup_Bill_no;
                $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
                $Sub_seller_admin = $user_details->Sub_seller_admin;
                $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;

                if ($user_details->Sub_seller_admin == 1) {
                  $remark_by = 'By SubSeller';
                } else {
                  $remark_by = 'By Seller';
                }
              }

              $Seller_category = $this->Igain_model->get_seller_category($seller_id, $Company_id);

              if ($Seller_category == 0) {
                $this->session->set_flashdata("error_code", "The Merchant has not been assigned a Category yet!! Please contact the Program Admin to set it to Enable Loyalty Transaction.!");

                redirect('Transactionc/Joy_transaction');
              }

              $points_array = array();

              foreach ($loyalty_prog as $prog) {
                $member_Tier_id = $lv_member_Tier_id;

                $value = array();
                $dis = array();

                $LoyaltyID_array = array();
                $Loyalty_at_flag = 0;
                $lp_type = substr($prog, 0, 2);

                //***** get loyalty program details ******************/

                if ($Sub_seller_admin == 1) {
                  $seller_id = $seller_id;
                } else {
                  $seller_id = $Sub_seller_Enrollement_id;
                }

                $lp_details = $this->Transactions_model->get_loyalty_program_details($Company_id, $seller_id, $prog, $Todays_date);

                $lp_count = count($lp_details);

                foreach ($lp_details as $lp_data) {
                  $LoyaltyID = $lp_data['Loyalty_id'];
                  $lp_name = $lp_data['Loyalty_name'];
                  $lp_From_date = $lp_data['From_date'];
                  $lp_Till_date = $lp_data['Till_date'];
                  $Loyalty_at_value = $lp_data['Loyalty_at_value'];
                  $Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
                  $discount = $lp_data['discount'];
                  $lp_Tier_id = $lp_data['Tier_id'];

                  if ($lp_Tier_id == 0) {
                    $member_Tier_id = $lp_Tier_id;
                  }

                  if ($Loyalty_at_value > 0) {
                    $value[] = $Loyalty_at_value;
                    $dis[] = $discount;
                    $LoyaltyID_array[] = $LoyaltyID;

                    $Loyalty_at_flag = 1;
                  }

                  if ($Loyalty_at_transaction > 0) {
                    $value[] = $Loyalty_at_transaction;
                    $dis[] = $Loyalty_at_transaction;
                    $LoyaltyID_array[] = $LoyaltyID;

                    $Loyalty_at_flag = 2;
                  }
                }

                if ($lp_type == 'PA') {
                  $transaction_amt = $this->input->post("purchase_amt");
                }

                if ($lp_type == 'BA') {
                  $transaction_amt = $bal_pay;
                }

                if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 1) {
                  for ($i = 0; $i <= count($value) - 1; $i++) {
                    if ($value[$i + 1] != "") {
                      if ($transaction_amt > $value[$i] && $transaction_amt <= $value[$i + 1]) {

                        $loyalty_points = $this->Transactions_model->get_discount($transaction_amt, $dis[$i]);
                        $trans_lp_id = $LoyaltyID_array[$i];
                        $gained_points_fag = 1;

                        $points_array[] = $loyalty_points;
                      }
                    } else if ($transaction_amt > $value[$i]) {
                      $loyalty_points = $this->Transactions_model->get_discount($transaction_amt, $dis[$i]);
                      $gained_points_fag = 1;
                      $trans_lp_id = $LoyaltyID_array[$i];

                      $points_array[] = $loyalty_points;
                    }
                  }
                }

                if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 2) {

                  $loyalty_points = $this->Transactions_model->get_discount($transaction_amt, $dis[0]);

                  $points_array[] = $loyalty_points;

                  $gained_points_fag = 1;
                  $trans_lp_id = $LoyaltyID_array[0];
                }
                if ($member_Tier_id == $lp_Tier_id && $loyalty_points > 0) {

                  $child_data = array(
                      'Company_id' => $Company_id,
                      'Transaction_date' => $lv_date_time,
                      'Seller' => $data['enroll'],
                      'Enrollement_id' => $Customer_enroll_id,
                      'Transaction_id' => 0,
                      'Loyalty_id' => $trans_lp_id,
                      'Reward_points' => $loyalty_points,
                  );

                  $child_result = $this->Transactions_model->insert_loyalty_transaction_child($child_data);
                }
              }

              if ($gained_points_fag == 1) {
                $total_loyalty_points = array_sum($points_array);
              } else {
                $total_loyalty_points = 0;
              }

              $tp_db = $Purchase_Bill_no;
              $len = strlen($tp_db);
              $str = substr($tp_db, 0, 5);
              $bill = substr($tp_db, 5, $len);
              $bill_no = $bill + 1;

              $post_data = array(
                  'Trans_type' => '2',
                  'Company_id' => $Company_id,
                  'Purchase_amount' => $this->input->post("purchase_amt"),
                  'Trans_date' => $lv_date_time,
                  'Remarks' => $this->input->post('remark'),
                  'Card_id' => $cardId,
                  'Seller_name' => $Seller_name,
                  'Seller' => $data['enroll'],
                  'Enrollement_id' => $Customer_enroll_id,
                  'Bill_no' => $bill,
                  'Manual_billno' => $manual_bill_no,
                  'remark2' => $remark_by,
                  'Remarks' => $this->input->post("remark"),
                  'Loyalty_pts' => $total_loyalty_points,
                  'Paid_amount' => $bal_pay,
                  'Payment_type_id' => $this->input->post("Payment_type"),
                  'balance_to_pay' => $bal_pay,
                  'Bank_name' => $this->input->post("Bank_name"),
                  'Branch_name' => $this->input->post("Branch_name"),
                  'Credit_Cheque_number' => $this->input->post("Credit_Cheque_number"),
                  'purchase_category' => $Seller_category,
                  'Source' => 0,
                  'Create_user_id' => $data['enroll']
              );

              //print_r($post_data); die;
              $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_data);

              /*               * ************Nilesh change igain Log Table change 14-06-2017********** */
              $get_cust_detail = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
              $Enrollement_id = $get_cust_detail->Enrollement_id;
              $First_name = $get_cust_detail->First_name;
              $Last_name = $get_cust_detail->Last_name;
              $opration = 1;
              $userid = $data['userId'];
              $what = "Loyalty Purchase Transaction";
              $where = "Perform Transaction";
              $toname = "";
              $opval = $this->input->post("purchase_amt") . ' Amount.';  // Transaction amt
              $firstName = $First_name;
              $lastName = $Last_name;

              $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);
              /*               * *****************igain Log Table change 14-06-2017****************** */

              $result = $this->Transactions_model->update_loyalty_transaction_child($Company_id, $lv_date_time, $data['enroll'], $Customer_enroll_id, $insert_transaction_id);

              $curr_bal = $card_bal + $total_loyalty_points;

              $topup_amt = $topup;

              $transaction_purchase_amt = $this->input->post("purchase_amt");

              $purchase_amount = $purchase_amt + $transaction_purchase_amt;

              $reddem_amount = $reddem_amt;

              $result2 = $this->Transactions_model->update_customer_balance($cardId, $curr_bal, $Company_id, $topup_amt, $lv_date_time, $purchase_amount, $reddem_amount);

              $billno_withyear = $str . $bill_no;

              if ($Sms_enabled == '1') {
                /*                 * ******************Send SMS Code************************ */
              }

              if ($Refree_enroll_id > 0) {

                $ref_cust_details = $this->Igain_model->get_enrollment_details($Refree_enroll_id);

                $referre_membershipID = $ref_cust_details->Card_id;
                $ref_card_bal = $ref_cust_details->Current_balance;
                $ref_Customer_enroll_id = $ref_cust_details->Enrollement_id;
                $ref_topup_amt = $ref_cust_details->Total_topup_amt;
                $ref_purchase_amt = $ref_cust_details->total_purchase;
                $ref_reddem_amt = $ref_cust_details->Total_reddems;
                $member_Tier_id = $ref_cust_details->Tier_id;
                $ref_customer_name = $ref_cust_details->First_name . " " . $ref_cust_details->Last_name;

                $Refree_topup = 0;

                $Referral_rule_for = 2; //*** Referral_rule_for transaction
                $Ref_rule = $this->Transactions_model->select_seller_refrencerule($seller_id, $Company_id, $Referral_rule_for);
                $total_ref_topup = 0;

                foreach ($Ref_rule as $rule) {
                  $ref_start_date = $rule['From_date'];
                  $ref_end_date = $rule['Till_date'];

                  if ($ref_start_date <= $Todays_date && $ref_end_date >= $Todays_date) {
                    $ref_topup = $rule['Refree_topup'];
                  }

                  $total_ref_topup = $total_ref_topup + $ref_topup;
                }

                if ($Seller_Refrence == 1 && $total_ref_topup > 0) {

                  $refree_current_balnce = $ref_card_bal + $total_ref_topup;
                  $refree_topup = $ref_topup_amt + $total_ref_topup;

                  $result5 = $this->Transactions_model->update_customer_balance($referre_membershipID, $refree_current_balnce, $Company_id, $refree_topup, $Todays_date, $ref_purchase_amt, $ref_reddem_amt);

                  $seller_curbal = $seller_curbal - $total_ref_topup;

                  $top_db = $Topup_Bill_no;
                  $len = strlen($top_db);
                  $str = substr($top_db, 0, 5);
                  $tp_bill = substr($top_db, 5, $len);

                  $topup_BillNo = $tp_bill + 1;
                  $billno_withyear_ref = $str . $topup_BillNo;

                  $post_Transdata = array(
                      'Trans_type' => '1',
                      'Company_id' => $Company_id,
                      'Topup_amount' => $total_ref_topup,
                      'Trans_date' => $lv_date_time,
                      'Remarks' => 'Referral Trans',
                      'Card_id' => $referre_membershipID,
                      'Seller_name' => $Seller_name,
                      'Seller' => $seller_id,
                      'Create_user_id' => $data['enroll'],
                      // 'Seller' =>$data['enroll'],
                      'Enrollement_id' => $ref_Customer_enroll_id,
                      'Bill_no' => $tp_bill,
                      'Manual_billno' => $manual_bill_no,
                      'remark2' => $remark_by,
                      'Loyalty_pts' => '0'
                  );

                  $result6 = $this->Transactions_model->insert_topup_details($post_Transdata);

                  $result7 = $this->Transactions_model->update_topup_billno($data['enroll'], $billno_withyear_ref);

                  //$Todays_date = date("Y-m-d");

                  $Email_content12 = array(
                      'Ref_Topup_amount' => $total_ref_topup,
                      'Notification_type' => 'Referral Topup',
                      'Template_type' => 'Referral_topup',
                      'Customer_name' => $customer_name,
                      'Todays_date' => $lv_date_time
                  );

                  $this->send_notification->send_Notification_email($ref_Customer_enroll_id, $Email_content12, $seller_id, $Company_id);
                }
              }

              if ($Seller_topup_access == '1') {
                $Total_seller_bal = $seller_curbal - $total_loyalty_points;
                $Total_seller_bal = $Total_seller_bal + $reedem_points;
                $result3 = $this->Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

                /*                 * *******************Send Threshold Mail*************** */
                $company_details = $this->Igain_model->get_company_details($Company_id);
                $Threshold_Merchant = $company_details->Threshold_Merchant;

                $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                $Seller_balance = $seller_details2->Current_balance;
                $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;

                if ($Threshold_Merchant >= $Seller_balance) {
                  //****mail to super seller
                  $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                  $Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
                  $Admin_Email_content = array(
                      'Seller_name' => $Seller_full_name,
                      'Seller_balance' => $Seller_balance,
                      'Super_Seller_flag' => 1,
                      'Notification_type' => "Seller Threshold Balance",
                      'Template_type' => 'Seller_threshold'
                  );
                  $this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
                  //****mail to super seller
                  //****mail to seller
                  $Seller_Email_content = array(
                      'Seller_name' => $Seller_full_name,
                      'Seller_balance' => $Seller_balance,
                      'Company_admin' => $Company_admin,
                      'Super_Seller_flag' => 0,
                      'Notification_type' => "Seller Threshold Balance",
                      'Template_type' => 'Seller_threshold'
                  );
                  $this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
                  //****mail to seller
                }
                /*                 * *******************Send Threshold Mail*************** */
              }
              $result4 = $this->Transactions_model->update_billno($data['enroll'], $billno_withyear);

              $Notification_type = "Loyalty Transaction";
              $purchase_amt = $this->input->post("purchase_amt");
              // $reedem =  $this->input->post("points_redeemed"); //$this->input->post("points_redeemed");
              $payment_by = $this->input->post("Payment_type");
              $balance_to_pay = $bal_pay;

              $seller_details = $this->Igain_model->get_enrollment_details($seller_id);
              $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
              $Symbol_currency = $currency_details->Symbol_of_currency;


              $Email_content = array(
                  'Today_date' => $lv_date_time,
                  'Manual_bill_no' => $manual_bill_no,
                  'Purchase_amount' => $purchase_amt,
                  'Redeem_points' => 0,
                  'Payment_by' => $payment_by,
                  'Balance_to_pay' => $balance_to_pay,
                  'Total_loyalty_points' => $total_loyalty_points,
                  'Symbol_currency' => $Symbol_currency,
                  'GiftCardNo' => 0,
                  'gift_reedem' => 0,
                  'Notification_type' => $Notification_type,
                  'Template_type' => 'Loyalty_transaction'
              );
              $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);

              if (($insert_transaction_id > 0) && ($result2 == true) && ($result4 == true)) {
                $this->session->set_flashdata("success_code", "Transaction done Successfully!!");
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Transaction Failed!!");
              }
            }
          }
        }
        redirect('Transactionc/Joy_transaction');
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Debit_transaction() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        //$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        $data["Company_details"] = $this->Igain_model->get_company_details($data['Company_id']);

        if ($Sub_seller_admin == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;

        if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
          $company_details = $this->Igain_model->get_company_details($data['Company_id']);

          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;

        $company_details = $this->Igain_model->get_company_details($Company_id);
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;

        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Promo_code_applicable'] = $company_details->Promo_code_applicable;
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/Joy_transaction";
        $total_row = $this->Transactions_model->loyalty_transaction_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
        /* -----------------------Pagination--------------------- */

        $data["results"] = $this->Transactions_model->loyalty_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
        $data["pagination"] = $this->pagination->create_links();

        $this->load->view('transactions/Debit_transaction', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Debit_transaction_ci() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $Country_id = $data['Country_id'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];

        $seller_details2 = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Seller_balance = $seller_details2->Current_balance;
        $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;
        $redemptionratio = $seller_details2->Seller_Redemptionratio;
        $Super_seller = $seller_details2->Super_seller;

        /*         * **********Get Company Details************************* */
        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $Sms_enabled = $company_details2->Sms_enabled;
        $Seller_topup_access = $company_details2->Seller_topup_access;
        $Allow_negative = $company_details2->Allow_negative;
        $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
        $Pin_no_applicable = $company_details2->Pin_no_applicable;
        $Coalition = $company_details2->Coalition;
        /*         * ******************************************************* */

        /* $user_details = $this->Igain_model->get_enrollment_details($this->input->post("Seller_id1"));

          $seller_id = $user_details->Enrollement_id;
          $Seller_name = $user_details->First_name." ".$user_details->Middle_name." ".$user_details->Last_name;
         */

        if ($_POST == NULL) {
          $this->session->set_flashdata("error_code", "Sorry, Debit Transaction Failed. Invalid Data Provided!!");
          redirect('Transactionc/Debit_transaction');
        } else {
			
			/* print_r($_POST);
			die; */
			
          if ($this->input->post("Cancelle_amt") == "" || $this->input->post("Cancelle_amt") <= 0 || $this->input->post("Cancelle_amt") == " " || $this->input->post("purchase_amt") < $this->input->post("Cancelle_amt")) {
            $this->session->set_flashdata("error_code", "Sorry, Debit Transaction Failed. Please Enter Valid Cancel Amount..!!");
            redirect('Transactionc/Debit_transaction');
          } else {
			  
            if ($Coalition == 0) {
				
              $cardId = $this->input->post("cardId");
              $Bill_no = $this->input->post("bill_no");
              $Cancelle_amt = $this->input->post("Cancelle_amt");
              $Remark = $this->input->post("remark");

              $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
              $phnumber = $dial_code . $cardId;

              $cust_details = $this->Transactions_model->cust_details_from_card_debit_trans($Company_id, $cardId, $phnumber);

              foreach ($cust_details as $row25) {
                $card_bal = $row25['Current_balance'];
                $Debit_points = $row25['Debit_points'];
                $Customer_enroll_id = $row25['Enrollement_id'];
                $topup = $row25['Total_topup_amt'];
                $purchase_amt = $row25['total_purchase'];
                $reddem_amt = $row25['Total_reddems'];
                $lv_member_Tier_id = $row25['Tier_id'];
                $Refree_enroll_id = $row25['Refrence'];
                $Card_id = $row25['Card_id'];
                $customer_name = $row25['First_name'] . " " . $row25['Last_name'];
              }

              $total_cancelle_amt = 0;
              $new_total_cancelle_amt = 0;
              $Cancel_amount = array();
              $Purchase_amount = array();

              $data['result'] = $this->Transactions_model->Fetch_transaction_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid, $Card_id); //Get Customer Trans details

              if ($data['result'] != NULL) {
                foreach ($data['result'] as $row) {
                  $Purchase_amt = $row['Purchase_amount'];
                  $Loyalty_pts = $row['Loyalty_pts'];
                  $Redeem_pts = $row['Redeem_points'];
                  $Bill_date = $row['Trans_date'];
                  $Trans_Bill_no = $row['Bill_no'];
                  $seller_id = $row['Seller'];
                  $Seller_name = $row['Seller_name'];
                  if ($row['Trans_type'] == 26) {
                    $Cancel_amount[] = $row['Purchase_amount'];
                  }
                  if ($row['Trans_type'] == 2) {
                    $Purchase_amount[] = $row['Purchase_amount'];
                  }
                }
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Debit Transaction Failed. Please Enter Valid Membership ID and Bill No.");
                redirect('Transactionc/Debit_transaction');
              }

              $Debit_loyalty_pts = round(($Cancelle_amt * $Loyalty_pts) / $Purchase_amt);
              $Debit_redeem_pts = round(($Cancelle_amt * $Redeem_pts) / $Purchase_amt);

              $total_cancelle_amt = array_sum($Cancel_amount);
              $total_Purchase_amount = array_sum($Purchase_amount);


              $new_total_cancelle_amt = $total_cancelle_amt + $Cancelle_amt;
              if ($new_total_cancelle_amt > $total_Purchase_amount) {
                $this->session->set_flashdata("error_code", "Cancellation amount is greater than Remaining amount");
                redirect('Transactionc/Debit_transaction');
              }
			  

              /*               * *****************Pin No. Validation**************** */
              if ($Pin_no_applicable == 1) {
                $Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
                $pinno = $Enroll_details->pinno;
                if ($_REQUEST["cust_pin"] != $pinno) {
                  $this->session->set_flashdata("error_code", "Transaction failed due to Invalid Pin No.");
                  // redirect('Transactionc/Joy_transaction');
				  redirect('Transactionc/Debit_transaction');
                }
              }
              /*               * *****************Pin No. Validation**************** */
              if (!(is_null($Cancelle_amt))) {
                $logtimezone = $data['timezone_entry'];


                $logtimezone = $session_data['timezone_entry'];
                $timezone = new DateTimeZone($logtimezone);
                $date = new DateTime();
                $date->setTimezone($timezone);
                $lv_date_time = $date->format('Y-m-d H:i:s');
                $Todays_date = $date->format('Y-m-d');

                if($this->input->post("remark") == "" ){
                  $remark="Debit Transaction";
                } else {
                  $remark=$this->input->post("remark");
                }
                $post_data = array(
                    'Trans_type' => '26',
                    'Company_id' => $Company_id,
                    'Purchase_amount' => $this->input->post("Cancelle_amt"),
                    'Trans_date' => $lv_date_time,
                    'Remarks' => $this->input->post('remark'),
                    'Card_id' => $Card_id,
                    'Seller_name' => $Seller_name,
                    'Seller' => $seller_id,
                    'Enrollement_id' => $Customer_enroll_id,
                    'Manual_billno' => $Bill_no,
                    'Bill_no' => $Trans_Bill_no,
                    'Loyalty_pts' => $Debit_loyalty_pts,
                    'Redeem_points' => $Debit_redeem_pts,
                    'Remarks' => $remark,
                    'Create_user_id' => $data['enroll']
                );


                $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_data);

                /*                 * ************Nilesh change igain Log Table change 14-06-2017********** */
                $get_cust_detail = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
                $Enrollement_id = $get_cust_detail->Enrollement_id;
                $First_name = $get_cust_detail->First_name;
                $Last_name = $get_cust_detail->Last_name;
                $opration = 1;
                $userid = $data['userId'];
                $what = "Debit Transaction";
                $where = "Debit Transaction";
                $toname = "";
                $opval = $this->input->post("Cancelle_amt") . ' Amount.';  // Transaction amt
                $firstName = $First_name;
                $lastName = $Last_name;

                $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);
                /*                 * *****************igain Log Table change 14-06-2017****************** */

                $Update_debit = round($Debit_points + $Debit_loyalty_pts) - $Debit_redeem_pts;
                $Notifiaction_debit_pts = $Debit_loyalty_pts;


                $Curent_balance = $card_bal;
                $Topup_amt = $topup;
                $new_purchase_amount = $purchase_amt - $Cancelle_amt;
                $reddem_amount = $reddem_amt + $Debit_redeem_pts;

                $CustomerData = array(
                    'total_purchase' => $new_purchase_amount,
                    'Current_balance' => $Curent_balance,
                    'Total_reddems' => $reddem_amt,
                    'Debit_points' => $Update_debit
                );


                $result2 = $this->Transactions_model->update_customer_debit($Customer_enroll_id, $Card_id, $Company_id, $CustomerData);



                $Notification_type = "Debit Transaction";


                $payment_by = $this->input->post("Payment_type");

                $seller_details = $this->Igain_model->get_enrollment_details($seller_id);
                $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
                $Symbol_currency = $currency_details->Symbol_of_currency;

                $Email_content = array(
                    'Today_date' => $lv_date_time,
                    'Bill_no' => $Bill_no,
                    'Bill_date' => date("d M Y", strtotime($Bill_date)),
                    'Purchase_amount' => $total_Purchase_amount,
                    'Cancelle_amount' => number_format($Cancelle_amt, 2),
                    'Debit_loyalty_points' => $Debit_loyalty_pts,
                    'Debit_redeem_points' => $Debit_redeem_pts,
                    'Symbol_currency' => $Symbol_currency,
                    'Notification_type' => $Notification_type,
                    'Template_type' => 'Purchase_cancel'
                );
                $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);



                /* -----------------Update Referral Transaction----------------------------------------- */


                $result_reference = $this->Transactions_model->Fetch_reference_transaction_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid);
                if ($result_reference != NULL) {
                  foreach ($result_reference as $row) {
                    $refree_card_id = $row['Card_id'];
                    $refree_topup_amount = $row['Topup_amount'];
                    $refree_Enrollement_id = $row['Enrollement_id'];
                    $Trans_referal_Bill_no = $row['Bill_no'];
                  }

                  $Debit_refree_loyalty_pts = round(($Cancelle_amt * $refree_topup_amount) / $Purchase_amt);




                  $refree_Details = $this->Igain_model->get_enrollment_details($refree_Enrollement_id);
                  $refree_current_balance = $refree_Details->Current_balance;
                  $refree_Debit_points = $refree_Details->Debit_points + $Debit_refree_loyalty_pts;
                  $refree_Total_topup_amt = $refree_Details->Total_topup_amt - $Debit_refree_loyalty_pts;
                  $refreeData = array(
                      'Total_topup_amt' => $refree_Total_topup_amt,
                      'Debit_points' => $refree_Debit_points
                  );


                  $result2 = $this->Transactions_model->update_customer_debit($refree_Enrollement_id, $refree_card_id, $Company_id, $refreeData);

                  if ($Seller_topup_access == '1' && $Debit_refree_loyalty_pts > 0) {

                    $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                    $Seller_balance = $seller_details2->Current_balance;
                    $Seller_full_name = $seller_details2->First_name . ' ' . $seller_details2->Last_name;
                    $Total_seller_bal = round($Seller_balance + $Debit_refree_loyalty_pts);

                    $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

                    /*                     * *******************Send Threshold Mail*************** */
                    $company_details = $this->Igain_model->get_company_details($Company_id);
                    $Threshold_Merchant = $company_details->Threshold_Merchant;


                    if ($Threshold_Merchant >= $Seller_balance) {
                      //****mail to super seller
                      $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                      $Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
                      $Admin_Email_content = array(
                          'Seller_name' => $Seller_full_name,
                          'Seller_balance' => $Seller_balance,
                          'Super_Seller_flag' => 1,
                          'Notification_type' => "Seller Threshold Balance",
                          'Template_type' => 'Seller_threshold'
                      );
                      $this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
                      //****mail to super seller
                      //****mail to seller
                      $Seller_Email_content = array(
                          'Seller_name' => $Seller_full_name,
                          'Seller_balance' => $Seller_balance,
                          'Company_admin' => $Company_admin,
                          'Super_Seller_flag' => 0,
                          'Notification_type' => "Seller Threshold Balance",
                          'Template_type' => 'Seller_threshold'
                      );
                      $this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
                      //****mail to seller
                    }
                    /*                     * *******************Send Threshold Mail*************** */
                  }

                  $post_refree_data = array(
                      'Trans_type' => '26',
                      'Company_id' => $Company_id,
                      'Trans_date' => $lv_date_time,
                      'Remarks' => 'Referral Debit Points',
                      'Card_id' => $refree_card_id,
                      'Seller_name' => $Seller_name,
                      'Seller' => $seller_id,
                      'Enrollement_id' => $refree_Enrollement_id,
                      'Manual_billno' => $Bill_no,
                      'Bill_no' => $Trans_referal_Bill_no,
                      'Loyalty_pts' => $Debit_refree_loyalty_pts,
                      'Remarks' => 'Referral Debit Points',
                      'Create_user_id' => $data['enroll']
                  );

                  $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_refree_data);


                  $Notification_type = "Debit Transaction";
                  $Email_content33 = array(
                      'Today_date' => $lv_date_time,
                      'Bill_no' => $Bill_no,
                      'Bill_date' => date("d M Y", strtotime($Bill_date)),
                      'Purchase_amount' => 0,
                      'Cancelle_amount' => 0,
                      'Debit_loyalty_points' => $Debit_refree_loyalty_pts,
                      'Debit_redeem_points' => 0,
                      'Symbol_currency' => $Symbol_currency,
                      'Notification_type' => $Notification_type,
                      'Template_type' => 'Purchase_cancel'
                  );
                  $this->send_notification->send_Notification_email($refree_Enrollement_id, $Email_content33, $seller_id, $Company_id);
                }
                /* -----------------Update Referral Transaction----------------------------------------- */
                if (($insert_transaction_id > 0) && ($result2 == true)) {
                  $this->session->set_flashdata("success_code", "Debit Transaction done Successfully!!");
                } else {
                  $this->session->set_flashdata("error_code", "Sorry, Debit Transaction Failed!!");
                }
              }
            } else {



              $cardId = $this->input->post("cardId");
              $Bill_no = $this->input->post("bill_no");
              $Cancelle_amt = $this->input->post("Cancelle_amt");
              $Remark = $this->input->post("remark");




              $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
              $phnumber = $dial_code . $cardId;

              $cust_details = $this->Transactions_model->cust_details_from_card_debit_trans($Company_id, $cardId, $phnumber);

              foreach ($cust_details as $row25) {
                $card_bal = $row25['Current_balance'];
                $Debit_points = $row25['Debit_points'];
                $Customer_enroll_id = $row25['Enrollement_id'];
                $topup = $row25['Total_topup_amt'];
                $total_purchase_amt = $row25['total_purchase'];
                $reddem_amt = $row25['Total_reddems'];
                $Blocked_points = $row25['Blocked_points'];
                $lv_member_Tier_id = $row25['Tier_id'];
                $Refree_enroll_id = $row25['Refrence'];
                $Card_id = $row25['Card_id'];
                $customer_name = $row25['First_name'] . " " . $row25['Last_name'];
              }
              $total_cancelle_amt = 0;
              $new_total_cancelle_amt = 0;
              $Cancel_amount = array();
              $Purchase_amount = array();


              $data['result'] = $this->Coal_Transactions_model->Fetch_coalition_transaction_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid, $Card_id); //Get Customer Trans details
              if ($data['result'] != NULL) {
                foreach ($data['result'] as $row) {

                  $Purchase_amt = $row['Purchase_amount'];
                  $Loyalty_pts = $row['Loyalty_pts'];
                  $Paid_amount = $row['Paid_amount'];
                  $Coalition_Loyalty_pts = $row['Coalition_Loyalty_pts'];
                  $Redeem_pts = $row['Redeem_points'];
                  $Bill_date = $row['Trans_date'];
                  $Trans_Bill_no = $row['Bill_no'];
                  $seller_id = $row['Seller'];
                  $Seller_name = $row['Seller_name'];
                  if ($row['Trans_type'] == 26) {
                    $Cancel_amount[] = $row['Purchase_amount'];
                  }
                  if ($row['Trans_type'] == 2) {
                    $Purchase_amount[] = $row['Purchase_amount'];
                  }
                }
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Debit Transaction Failed. Please Enter Valid Membership ID and Bill No.");
                redirect('Transactionc/Debit_transaction');
              }

              $Debit_loyalty_pts = round(($Cancelle_amt * $Loyalty_pts) / $Purchase_amt);
              $Debit_Coalition_Loyalty_pts = round(($Cancelle_amt * $Coalition_Loyalty_pts) / $Purchase_amt);
              $Debit_redeem_pts = round(($Cancelle_amt * $Redeem_pts) / $Purchase_amt);
              $Debit_Paid_amount = round(($Cancelle_amt * $Paid_amount) / $Purchase_amt);


              $Update_debit = round($Debit_loyalty_pts) - $Debit_redeem_pts;

              $total_cancelle_amt = array_sum($Cancel_amount);
              $total_Purchase_amount = array_sum($Purchase_amount);
              $new_total_cancelle_amt = $total_cancelle_amt + $Cancelle_amt;
              if ($new_total_cancelle_amt > $total_Purchase_amount) {
                $this->session->set_flashdata("error_code", "Cancellation amount is greater than Remaining amount");
                redirect('Transactionc/Debit_transaction');
              }

              /*               * *****************Pin No. Validation**************** */
              if ($Pin_no_applicable == 1) {
                $Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
                $pinno = $Enroll_details->pinno;
                if ($_REQUEST["cust_pin"] != $pinno) {
                  $this->session->set_flashdata("error_code", "Transaction failed due to Invalid Pin No.");
                  // redirect('Transactionc/Joy_transaction');
				  redirect('Transactionc/Debit_transaction');
                }
              }
              /*               * *****************Pin No. Validation**************** */
              if (!(is_null($Cancelle_amt))) {
                $logtimezone = $data['timezone_entry'];


                $logtimezone = $session_data['timezone_entry'];
                $timezone = new DateTimeZone($logtimezone);
                $date = new DateTime();
                $date->setTimezone($timezone);
                $lv_date_time = $date->format('Y-m-d H:i:s');
                $Todays_date = $date->format('Y-m-d');

                if($this->input->post("remark") == "" ){
                  $remark="Purchase Debit Points";
                } else {
                  $remark=$this->input->post("remark");
                }

                $post_data = array(
                    'Trans_type' => '26',
                    'Company_id' => $Company_id,
                    'Purchase_amount' => $this->input->post("Cancelle_amt"),
                    'Trans_date' => $lv_date_time,
                    'Remarks' => $this->input->post('remark'),
                    'Card_id' => $Card_id,
                    'Seller_name' => $Seller_name,
                    'Seller' => $seller_id,
                    'Enrollement_id' => $Customer_enroll_id,
                    'Manual_billno' => $Bill_no,
                    'Bill_no' => $Trans_Bill_no,
                    'Loyalty_pts' => $Update_debit,
                    'Coalition_Loyalty_pts' => $Debit_Coalition_Loyalty_pts,
                    'Redeem_points' => $Debit_redeem_pts,
                    'Remarks' => $remark,
                    'Create_user_id' => $data['enroll']
                );


                $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_data);

                /*                 * ************Nilesh change igain Log Table change 14-06-2017********** */
                $get_cust_detail = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
                $Enrollement_id = $get_cust_detail->Enrollement_id;
                $First_name = $get_cust_detail->First_name;
                $Last_name = $get_cust_detail->Last_name;
                $opration = 1;
                $userid = $data['userId'];
                $what = "Debit Transaction (Coalition)";
                $where = "Debit Transaction (Coalition)";
                $toname = "";
                $opval = $this->input->post("Cancelle_amt") . ' Amount.';  // Transaction amt
                $firstName = $First_name;
                $lastName = $Last_name;

                $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);
                /*                 * *****************igain Log Table change 14-06-2017****************** */

                /*                 * **********22-01-2019*Ravi******************************************** */
                $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $Customer_enroll_id);
                // echo "<br><br>Record_available ".$Record_available;
                if ($Record_available == 0) {
                  $post_data2 = array(
                      'Company_id' => $Company_id,
                      'Seller_total_purchase' => $Purchase_amt,
                      'Update_date' => $lv_date_time,
                      'Seller_id' => $seller_id,
                      'Cust_enroll_id' => $Customer_enroll_id,
                      'Cust_seller_balance' => $Loyalty_pts,
                      'Seller_paid_balance' => $Debit_Paid_amount,
                      'Seller_total_redeem' => $Redeem_pts,
                      'Seller_total_gain_points' => $Loyalty_pts,
                      'Cust_debit_points' => $Update_debit,
                      'Seller_total_topup' => 0
                  );
                  $lv_Cust_seller_balance = $Loyalty_pts;
                  $result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data2);
                } else {
                  /*                   * ***********Get Customer merchant balance**************** */
                  $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $Customer_enroll_id);

                  foreach ($Get_Record as $val) {
                    $data["Cust_seller_balance"] = $val["Cust_seller_balance"];
                    $data["Seller_total_purchase"] = $val["Seller_total_purchase"];
                    $data["Seller_total_redeem"] = $val["Seller_total_redeem"];
                    $data["Seller_total_gain_points"] = $val["Seller_total_gain_points"];
                    $data["Seller_total_topup"] = $val["Seller_total_topup"];
                    $data["Seller_paid_balance"] = $val["Seller_paid_balance"];
                    $data["Cust_prepayment_balance"] = $val["Cust_prepayment_balance"];
                    $data["Cust_block_amt"] = $val["Cust_block_amt"];
                    $data["Cust_block_points"] = $val["Cust_block_points"];
                    $data["Cust_debit_points"] = $val["Cust_debit_points"];
                  }

                  /*                   * ******************************************************************** */



                  $lv_Cust_seller_balance = ($data["Cust_seller_balance"]);
                  $lv_Seller_total_purchase = ($data["Seller_total_purchase"] - $Cancelle_amt);
                  $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);
                  $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
                  $lv_Seller_paid_balance = ($data["Seller_paid_balance"] - $Debit_Paid_amount);
                  $lv_Seller_total_topup = ($data["Seller_total_topup"] + 0);
                  $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
                  $lv_Cust_block_amt = ($data["Cust_block_amt"]);
                  $lv_Cust_block_points = ($data["Cust_block_points"]);
                  $lv_Cust_debit_points = ($data["Cust_debit_points"] + $Update_debit);

                  /*                   * ***********Update customer merchant balance************************ */
                  $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $lv_Cust_debit_points);
                  /*                   * ************************************************** */
                }

                /*                 * **********22-01-2019*Ravi******************************************** */


                if ($Seller_topup_access == '1') {

                  $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                  $Seller_balance = $seller_details2->Current_balance;
                  $Seller_full_name = $seller_details2->First_name . ' ' . $seller_details2->Last_name;
                  // echo"------Seller_balance--------".$Seller_balance."--<br>";
                  // $Total_seller_bal = $Seller_balance + $Debit_loyalty_pts;
                  $Total_seller_bal = round($Seller_balance + $Debit_loyalty_pts) - $Debit_redeem_pts;
                  //$Total_seller_bal = $Total_seller_bal + $Debit_redeem_pts;
                  // echo"------Total_seller_bal--------".$Total_seller_bal."--<br>";

                  $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

                  /*                   * *******************Send Threshold Mail*************** */
                  $company_details = $this->Igain_model->get_company_details($Company_id);
                  $Threshold_Merchant = $company_details->Threshold_Merchant;


                  if ($Threshold_Merchant >= $Seller_balance) {
                    //****mail to super seller
                    $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                    $Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
                    $Admin_Email_content = array(
                        'Seller_name' => $Seller_full_name,
                        'Seller_balance' => $Seller_balance,
                        'Super_Seller_flag' => 1,
                        'Notification_type' => "Seller Threshold Balance",
                        'Template_type' => 'Seller_threshold'
                    );
                    $this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
                    //****mail to super seller
                    //****mail to seller
                    $Seller_Email_content = array(
                        'Seller_name' => $Seller_full_name,
                        'Seller_balance' => $Seller_balance,
                        'Company_admin' => $Company_admin,
                        'Super_Seller_flag' => 0,
                        'Notification_type' => "Seller Threshold Balance",
                        'Template_type' => 'Seller_threshold'
                    );
                    $this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
                    //****mail to seller
                  }
                  /*                   * *******************Send Threshold Mail*************** */
                }




                /* -----------------Update Enrollment Master----------------------------------------- */




                $Update_debit = round($Debit_points + $Debit_Coalition_Loyalty_pts);

                $reddem_amount = $reddem_amt + $Debit_redeem_pts;
                //$new_purchase_amount = $total_purchase_amt - $Cancelle_amt;
                $new_purchase_amount = $total_purchase_amt;
                $Curent_balance = round($card_bal - $Debit_Coalition_Loyalty_pts);
                $Topup_amt = $topup;
                $Blocked_points = $Blocked_points;

                $CustomerData1 = array(
                    'total_purchase' => $new_purchase_amount,
                    'Current_balance' => $card_bal,
                    'Debit_points' => $Update_debit
                );


                $result2 = $this->Transactions_model->update_customer_debit($Customer_enroll_id, $Card_id, $Company_id, $CustomerData1);

                /* -----------------Update Enrollment Master----------------------------------------- */


                /* -----------------Update Referral Transaction----------------------------------------- */


                $result_reference = $this->Transactions_model->Fetch_reference_transaction_details($Bill_no, $Company_id, $Super_seller, $Logged_user_enrollid);
                if ($result_reference != NULL) {

                  foreach ($result_reference as $row) {
                    $refree_card_id = $row['Card_id'];
                    $refree_topup_amount = $row['Topup_amount'];
                    $refree_Enrollement_id = $row['Enrollement_id'];
                    $Trans_referal_Bill_no = $row['Bill_no'];


                  }

                  $Debit_refree_loyalty_pts = round(($Cancelle_amt * $refree_topup_amount) / $Purchase_amt);



                  if ($Seller_topup_access == '1' && $Debit_refree_loyalty_pts > 0) {

                    $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                    $Seller_balance = $seller_details2->Current_balance;
                    $Seller_full_name = $seller_details2->First_name . ' ' . $seller_details2->Last_name;
                    $Total_seller_bal = round($Seller_balance + $Debit_refree_loyalty_pts);

                    $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

                    /* * *******************Send Threshold Mail*************** */
                    $company_details = $this->Igain_model->get_company_details($Company_id);
                    $Threshold_Merchant = $company_details->Threshold_Merchant;


                    if ($Threshold_Merchant >= $Seller_balance) {
                      //****mail to super seller
                      $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                      $Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
                      $Admin_Email_content = array(
                          'Seller_name' => $Seller_full_name,
                          'Seller_balance' => $Seller_balance,
                          'Super_Seller_flag' => 1,
                          'Notification_type' => "Seller Threshold Balance",
                          'Template_type' => 'Seller_threshold'
                      );
                      $this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
                      //****mail to super seller
                      //****mail to seller
                      $Seller_Email_content = array(
                          'Seller_name' => $Seller_full_name,
                          'Seller_balance' => $Seller_balance,
                          'Company_admin' => $Company_admin,
                          'Super_Seller_flag' => 0,
                          'Notification_type' => "Seller Threshold Balance",
                          'Template_type' => 'Seller_threshold'
                      );
                      $this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
                      //****mail to seller
                    }
                    /*                     * *******************Send Threshold Mail*************** */
                  }


                  $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $refree_Enrollement_id);
                  if ($Record_available == 0) {
                    $post_refree_data2 = array(
                        'Company_id' => $Company_id,
                        'Seller_total_purchase' => 0,
                        'Update_date' => $lv_date_time,
                        'Seller_id' => $seller_id,
                        'Cust_enroll_id' => $refree_Enrollement_id,
                        'Cust_seller_balance' => 0,
                        'Seller_paid_balance' => 0,
                        'Seller_total_redeem' => 0,
                        'Seller_total_gain_points' => 0,
                        'Cust_debit_points' => $Debit_refree_loyalty_pts,
                        'Seller_total_topup' => 0
                    );
                    $result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_refree_data2);
                  } else {
                    /*                     * ***********Get Customer merchant balance**************** */
                    $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $refree_Enrollement_id);

                    foreach ($Get_Record as $val) {
                      $data["Cust_seller_balance"] = $val["Cust_seller_balance"];
                      $data["Seller_total_purchase"] = $val["Seller_total_purchase"];
                      $data["Seller_total_redeem"] = $val["Seller_total_redeem"];
                      $data["Seller_total_gain_points"] = $val["Seller_total_gain_points"];
                      $data["Seller_total_topup"] = $val["Seller_total_topup"];
                      $data["Seller_paid_balance"] = $val["Seller_paid_balance"];
                      $data["Cust_prepayment_balance"] = $val["Cust_prepayment_balance"];
                      $data["Cust_block_amt"] = $val["Cust_block_amt"];
                      $data["Cust_block_points"] = $val["Cust_block_points"];
                      $data["Cust_debit_points"] = $val["Cust_debit_points"];
                    }

                    /*                     * ******************************************************************** */
                    $lv_Cust_seller_balance = ($data["Cust_seller_balance"]);
                    $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
                    $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);
                    $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
                    $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
                    $lv_Seller_total_topup = ($data["Seller_total_topup"] - $Debit_refree_loyalty_pts);
                    $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
                    $lv_Cust_block_amt = ($data["Cust_block_amt"]);
                    $lv_Cust_block_points = ($data["Cust_block_points"]);
                    $lv_Cust_debit_points = ($data["Cust_debit_points"] + $Debit_refree_loyalty_pts);

                    /*                     * ***********Update customer merchant balance************************ */
                    $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($refree_Enrollement_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $lv_Cust_debit_points);
                    /*                     * ************************************************** */
                  }


                  $post_refree_data = array(
                      'Trans_type' => '26',
                      'Company_id' => $Company_id,
                      'Trans_date' => $lv_date_time,
                      'Remarks' => 'Referral Debit Points',
                      'Card_id' => $refree_card_id,
                      'Seller_name' => $Seller_name,
                      'Seller' => $seller_id,
                      'Enrollement_id' => $refree_Enrollement_id,
                      'Manual_billno' => $Bill_no,
                      'Bill_no' => $Trans_referal_Bill_no,
                      'Loyalty_pts' => $Debit_refree_loyalty_pts,
                      'Remarks' => 'Referral Debit Points',
                      'Create_user_id' => $data['enroll']
                  );

                  $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_refree_data);


                  $Notification_type = "Debit Transaction";
                  $Email_content33 = array(
                      'Today_date' => $lv_date_time,
                      'Bill_no' => $Bill_no,
                      'Bill_date' => date("d M Y", strtotime($Bill_date)),
                      'Purchase_amount' => 0,
                      'Cancelle_amount' => 0,
                      'Debit_loyalty_points' => $Debit_refree_loyalty_pts,
                      'Debit_redeem_points' => 0,
                      'Symbol_currency' => $Symbol_currency,
                      'Referee_name' => $customer_name,
                      'Notification_type' => $Notification_type,
                      'Template_type' => 'Refferal_purchase_cancel'
                  );
                  $this->send_notification->send_Notification_email($refree_Enrollement_id, $Email_content33, $seller_id, $Company_id);
                }
                /* -----------------Update Referral Transaction----------------------------------------- */

                $Notification_type = "Debit Transaction";


                $payment_by = $this->input->post("Payment_type");
                // $balance_to_pay = $bal_pay;

                $seller_details = $this->Igain_model->get_enrollment_details($seller_id);
                $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
                $Symbol_currency = $currency_details->Symbol_of_currency;

                $Email_content = array(
                    'Today_date' => $lv_date_time,
                    'Bill_no' => $Bill_no,
                    'Bill_date' => date("d M Y", strtotime($Bill_date)),
                    'Purchase_amount' => $Purchase_amt,
                    'Cancelle_amount' => number_format($Cancelle_amt, 2),
                    'Debit_loyalty_points' => $Debit_loyalty_pts,
                    'Debit_redeem_points' => $Debit_redeem_pts,
                    'Symbol_currency' => $Symbol_currency,
                    'Notification_type' => $Notification_type,
                    'Template_type' => 'Coalition_purchase_cancel'
                );
                $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
                if (($insert_transaction_id > 0) && ($result2 == true)) {
                  $this->session->set_flashdata("success_code", "Debit Transaction done Successfully!!");
                } else {
                  $this->session->set_flashdata("error_code", "Sorry, Debit Transaction Failed!!");
                }
              }
            }
          }
        }
        redirect('Transactionc/Debit_transaction');
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function check_referee_details() {
      if ($this->session->userdata('logged_in')) {
        $CompanyID = $this->input->post("Company_id");
        $ref_cardid = $this->input->post("ref_cardid");

        $ref_array = $this->Igain_model->get_referre_details($CompanyID, $ref_cardid);

        //print_r($Client_company_array); die;
        $data['ref_array'] = $ref_array;

        $this->load->view('transactions/view_referre_details', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function get_loyalty_program_details() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        // $CompanyID = $this->input->post("Company_id");
        $CompanyID = $session_data['Company_id'];
        $Logged_user_enroll = $session_data['enroll'];
        $Logged_user_id = $session_data['userId'];
        $Loyalty_names = $this->input->post("lp_id");
        $seller_id = $this->input->post("seller_id");

        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        $data["Company_details"] = $this->Igain_model->get_company_details($CompanyID);
		// $data['Company_details']=$data['Company_details']->Currency_name;

        if ($Sub_seller_admin == 1) {
          $Logged_user_enroll = $Logged_user_enroll;
        } else {
          $Logged_user_enroll = $Sub_seller_Enrollement_id;
        }
		// $Logged_user_enroll = $seller_id;
		

        // echo "Sub_seller_admin---".$Sub_seller_admin;
        $data['lp_array'] = $this->Transactions_model->get_loyaltyrule_details($Loyalty_names, $CompanyID, $Logged_user_enroll, $Logged_user_id);
		// echo "sql---".$this->db->last_query();
		// var_dump($data['lp_array']);
        // $data['lp_array'] = $ref_array;

        $this->load->view('view_loyalty_program_details', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    function get_promo_points() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $CompanyID = $this->input->post("CompID");
        $Logged_user_enroll = $session_data['enroll'];
        $Logged_user_id = $session_data['userId'];
        $PromoCode = $this->input->post("PromoCode");

        $promo_points = $this->Transactions_model->get_promo_code_details($PromoCode, $CompanyID);


        if ($promo_points > 0) {
          $this->output->set_output($promo_points);
        } else {
          $this->output->set_output('0');
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    //******** Loyalty Transaction ********

    /*     * *********************************Sandeep Work END ******************************************** */


    /*     * *********************************AMIT START ******************************************** */

    /*     * *********************************AMIT START ******************************************** */
    public function redeem() {
      
      //$this->load->model('Redemption_catalogue/Redemption_Model');
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        //$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $Seller_topup_access = $session_data['Seller_topup_access'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $seller_curbal = $data['Current_balance'];
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;
        $Sub_seller_Enrollement_id = $seller_details->Sub_seller_Enrollement_id;
        $data['Seller_redemption_limit'] = $seller_details->Seller_redemption_limit;

        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details2->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details2->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details2->Threshold_Merchant;
		
		$data['Daily_points_consumption_flag'] = $company_details2->Daily_points_consumption_flag;
        $data['Enable_company_meal_flag'] = $company_details2->Enable_company_meal_flag;
		
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }

        if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
          $company_details = $this->Igain_model->get_company_details($data['Company_id']);

          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Transactionc/redeem";
        $total_row = $this->Transactions_model->redeem_transaction_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
        /* -----------------------Pagination--------------------- */

        $logtimezone = $session_data['timezone_entry'];
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');

        //echo "cardId".$_REQUEST["cardId"];

        if ($_REQUEST == NULL) {
          $data["results"] = $this->Transactions_model->redeem_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('transactions/redeem_view', $data);
        } else {
          /*           * **********Changed AMIT 17-*06-2016************************ */
          $start = 0;
          $limit = 10;
          $cardis = $this->input->post("cardId");
          if (isset($_REQUEST["Page_cardId"])) {
            $cardis = $_REQUEST["Page_cardId"];
            $limit = $_REQUEST["limit"];
          }

          $Redemption_Items = $this->Redemption_Model->get_all_items($limit, $start, $data['Company_id'], 0, 0, $data['enroll']);
          $data['Redemption_Items'] = $Redemption_Items;
          /*           * ******************************************************************************** */
          if (substr($cardis, 0, 1) == "%") {
            $get_card = substr($cardis, 2); //*******read card id from magnetic card***********///
          } else {
            $get_card = substr($cardis, 0, 16); //*******read card id from other magnetic card***********///
          }


          $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
          $phnumber = $dial_code . $this->input->post("cardId");

          $member_details = $this->Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
          foreach ($member_details as $rowis) {
            $cardId = $rowis['Card_id'];
            $user_activated = $rowis['User_activated'];
            $Phone_no = App_string_decrypt($rowis['Phone_no']);
          }

          if ($user_activated == 0 || $cardId == '0') {
            $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
            redirect(current_url());
          }


          if (strlen($cardis) != '0') {
            if ($cardis != '0') {
              if ($cardId == $cardis || $Phone_no == $phnumber) {
                $cust_details = $this->Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                foreach ($cust_details as $row25) {
                  $fname = $row25['First_name'];
                  $midlename = $row25['Middle_name'];
                  $lname = $row25['Last_name'];
                  $bdate = $row25['Date_of_birth'];
                  $address = App_string_decrypt($row25['Current_address']);
                  $bal = $row25['Current_balance'];
                  $Blocked_points = $row25['Blocked_points'];
                  $Debit_points = $row25['Debit_points'];
                  $phno = App_string_decrypt($row25['Phone_no']);
                  $companyid = $row25['Company_id'];
                  $cust_enrollment_id = $row25['Enrollement_id'];
                  $image_path = $row25['Photograph'];
                  $filename_get1 = $image_path;
                  $Cust_Current_balance = $row25['Current_balance'];
                  $pinno = $row25['pinno'];
                  $Cust_Tier_id = $row25['Tier_id'];
                  $MembershipID = $row25['Card_id'];

                  $Current_point_balance = $bal - ($Blocked_points + $Debit_points);

                  if ($Current_point_balance < 0) {
                    $Current_point_balance = 0;
                  } else {
                    $Current_point_balance = $Current_point_balance;
                  }
                }

                $tp_count = $this->Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                $purchase_count = $this->Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                $gainedpts_atseller = $this->Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $data['enroll']);
                if ($gainedpts_atseller == NULL) {
                  $gainedpts_atseller = 0;
                }

                $data['get_card'] = $get_card;
                $data['Cust_enrollment_id'] = $cust_enrollment_id;
                $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                $data['Phone_no'] = $phno;
                // $data['Current_balance'] = ($bal-$Blocked_points);
                $data['Current_balance'] = $Current_point_balance;
                $data['Topup_count'] = $tp_count;
                $data['Purchase_count'] = $purchase_count;
                $data['Gained_points'] = $gainedpts_atseller;
                $data['Photograph'] = $filename_get1;
                $data['Customer_pin'] = $pinno;
                $data['MembershipID'] = $MembershipID;

                $Loyalty_names = "PA-ONLY REDEEM";


                $data['loyalty_rec'] = $this->Transactions_model->get_loyalty_program_details($Company_id, $data['enroll'], $Loyalty_names, $Todays_date);
                //var_dump($data['loyalty_rec']);

                /*                 * ***************************DISCOUNT RULE************************************* */

                $data["Discount_Applicable"] = 0;
                // $Discount_rule_details = $this->Transactions_model->get_merchant_discount_rule($Todays_date,$data['enroll'],$Company_id);
                $Discount_rule_details = $this->Transactions_model->get_merchant_discount_rule($Todays_date, $Logged_user_enrollid, $Company_id);

                // if($Discount_rule_details["Loyalty_points_above"]!="" || count($Discount_rule_details)!=0)
                if ($Discount_rule_details != NULL) {
                  foreach ($Discount_rule_details as $rowis) {
                    $Loyalty_points_above[] = $rowis['Loyalty_points_above'];
                    $Discount[] = $rowis['Discount'];
                    $Default_discount[] = $rowis['Default_discount'];
                  }
                  $Loyalty_points_array = array();
                  for ($i = 0; $i < count($Discount_rule_details); $i++) {
                    if ($Loyalty_points_above[$i] <= $Cust_Current_balance) {
                      $Loyalty_points_array[] = $Loyalty_points_above[$i];
                    }
                  }

                  if (count($Loyalty_points_array) == 0) {
                    $data["Discount_Applicable"] = max($Default_discount);
                  } else {
                    $max_loyalty = max($Loyalty_points_array);
                    // $Discount_applicable_rule = $this->Transactions_model->get_merchant_applicable_discount_rule($Todays_date,$data['enroll'],$Company_id,$max_loyalty);
                    $Discount_applicable_rule = $this->Transactions_model->get_merchant_applicable_discount_rule($Todays_date, $Logged_user_enrollid, $Company_id, $max_loyalty);
                    foreach ($Discount_applicable_rule as $val) {
                      $data["Discount_Applicable"] = $val["Discount"];
                    }
                  }
                }
                /*                 * ***************************DISCOUNT RULE************************************** */
                /*                 * ***************AMIT 14-06-2016 Changed************* */

                $data["Tier_details"] = $this->Redemption_Model->Get_tier_details($data['Company_id'], $Cust_Tier_id);
                foreach ($data["Tier_details"] as $Tier_details) {
                  $data["Redeemtion_limit"] = $Tier_details->Redeemtion_limit;
                  $data["Tier_name"] = $Tier_details->Tier_name;
                }
                /*                 * ***************************************************** */
                $this->load->view('transactions/redeem_transaction', $data);
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Your Membership ID is not registered with us...! !");
                redirect(current_url());
              }
            } else {
              $this->session->set_flashdata("error_code", "The Customer has not been Assigned a Membership ID yet! Please go to Assign Membership ID option.");
              redirect(current_url());
            }
          } else {
            $this->session->set_flashdata("error_code", "Please enter valid Membership ID.");
            redirect(current_url());
          }
          // $this->load->view('transactions/loyalty_purchase_transaction', $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function redeem_done() {

		if ($this->session->userdata('logged_in')) {
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$seller_id = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
			$Seller_topup_access = $session_data['Seller_topup_access'];
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$logtimezone = $session_data['timezone_entry'];
			
			  if ($_POST == NULL) {
				$this->session->set_flashdata("error_code", "Sorry, Redeem Transaction Failed. Invalid Data Provided!!");
				redirect('transactions/redeem');
			  } else {
			   
				// echo"<pre>";
					// print_r($_POST);
				// die;
				
				$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				$data['Current_balance'] = $seller_details->Current_balance;
				$data['refrence'] = $seller_details->Refrence;
				$data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
				$redemptionratio = $seller_details->Seller_Redemptionratio;
				$Sub_seller_Enrollement_id = $seller_details->Sub_seller_Enrollement_id;

				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				$Daily_points_consumption_flag = $data["Company_details"]->Daily_points_consumption_flag;
				$Enable_company_meal_flag = $data["Company_details"]->Enable_company_meal_flag;
				
				if ($data['Sub_seller_admin'] == 1) {
				  $Logged_user_enrollid = $Logged_user_enrollid;
				} else {
				  $Logged_user_enrollid = $Sub_seller_Enrollement_id;
				}

				
				$timezone = new DateTimeZone($logtimezone);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$lv_date_time = $date->format('Y-m-d H:i:s');
				$Todays_date = $date->format('Y-m-d');
				$Trans_date = $date->format('Y-m-d');

				$Company_details = $this->Igain_model->get_company_details($data['Company_id']);
				if ($data['userId'] == 3) {
				  $top_seller = $this->Transactions_model->get_top_seller($data['Company_id']);
				  foreach ($top_seller as $sellers) {
					$seller_id = $sellers['Enrollement_id'];
					$Purchase_Bill_no = $sellers['Purchase_Bill_no'];
					$Topup_Bill_no = $sellers['Topup_Bill_no'];
					$username = $sellers['User_email_id'];
					$remark_by = 'By Admin';
					$seller_curbal = $sellers['Current_balance'];
					$Seller_Redemptionratio = $sellers['Seller_Redemptionratio'];
					$Seller_Refrence = $sellers['Refrence'];
					$Seller_name = $sellers['First_name'] . " " . $sellers['Middle_name'] . " " . $sellers['Last_name'];
				  }

				  $remark_by = 'By Admin';
				} else {
				  $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				  $seller_id = $user_details->Enrollement_id;
				  $Purchase_Bill_no = $user_details->Purchase_Bill_no;
				  $username = $user_details->User_email_id;
				  $remark_by = 'By Seller';
				  $seller_curbal = $user_details->Current_balance;
				  $Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
				  $Seller_Refrence = $user_details->Refrence;
				  $Topup_Bill_no = $user_details->Topup_Bill_no;
				  $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
				  $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;
				  $Sub_seller_admin = $user_details->Sub_seller_admin;

				  if ($user_details->Sub_seller_admin == 1) {
					$remark_by = 'By SubSeller';
				  } else {
					$remark_by = 'By Seller';
				  }
				}
				if ($Sub_seller_admin == 1) {
				  $seller_id = $seller_id;
				} else {
				  $seller_id = $Sub_seller_Enrollement_id;
				}
				$dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
				$phnumber = $dial_code . $this->input->post("cardId");

				$member_details = $this->Transactions_model->issue_bonus_member_details($Company_id, $this->input->post("cardId"), $phnumber);
				if ($member_details != NULL) {
				  foreach ($member_details as $rowis) {
					$cardId = $rowis['Card_id'];
				  }
				} else {
				  $this->session->set_flashdata("error_code", "Inavalid Membership ID or Phone Number !!!");
				  redirect('Transactionc/redeem');
				}


				$cust_details = $this->Transactions_model->cust_details_from_card($Company_id, $cardId);
				//print_r($cust_details);
				foreach ($cust_details as $row25) {
					$card_bal = $row25['Current_balance'];
					$Blocked_points = $row25['Blocked_points'];
					$Debit_points = $row25['Debit_points'];
					$Customer_enroll_id = $row25['Enrollement_id'];
					//echo $Customer_enroll_id;die;
					$topup = $row25['Total_topup_amt'];
					$purchase_amt = $row25['total_purchase'];
					$reddem_amt = $row25['Total_reddems'];
					$Full_name = $row25['First_name'] . " " . $row25['Last_name'];
				}

				$top_db = $Topup_Bill_no;
				$len = strlen($top_db);
				$str = substr($top_db, 0, 5);
				$tp_bill = substr($top_db, 5, $len);

				$topup_BillNo = $tp_bill + 1;
				$billno_withyear_ref = $str . $topup_BillNo;
				$total_cust_balance = 0;
				
				$Redeem_type = $this->input->post("Redeem_type");
				
				$Current_point_balance = $card_bal - ($Blocked_points + $Debit_points);
				if ($Current_point_balance < 0) {
				  $Current_point_balance = 0;
				} else {
				  $Current_point_balance = $Current_point_balance;
				}




				if ($Redeem_type == 1) { //Normal
				
				  $Redeem_points = $this->input->post("Redeem_points");
				  $lv_Grand_total = $Redeem_points;
				 /* if ($Redeem_points > $Current_point_balance) {
					$this->session->set_flashdata("error_code", "Insufficient Current Balance !!!");
					redirect('Transactionc/redeem');
				  }*/


				  $post_data = array(
					  'Trans_type' => '3',
					  'Company_id' => $Company_id,
					  'Redeem_points' => $this->input->post("Redeem_points"),
					  'Trans_date' => $lv_date_time,
					  'Remarks' => $this->input->post('Remarks'),
					  'Card_id' => $cardId,
					  'Seller_name' => $Seller_name,
					  'Seller' => $data['enroll'],
					  'Payment_type_id' => '4',
					  'Enrollement_id' => $Customer_enroll_id,
					  'Create_user_id' => $data['enroll'],
					  'Bill_no' => $tp_bill
				  );

				  $insert_transaction_id = $this->Transactions_model->insert_loyalty_transaction($post_data);

				  /*************Nilesh change igain Log Table ***************** */
				  $get_cust_detail = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
				  $Enrollement_id = $get_cust_detail->Enrollement_id;
				  $First_name = $get_cust_detail->First_name;
				  $Last_name = $get_cust_detail->Last_name;
				  $opration = 1;
				  $userid = $data['userId'];
				  $what = "Only Redeem";
				  $where = "Just Redeem";
				  $toname = "";
				  $opval = $this->input->post("Redeem_points") . ' Points.';  // Redeem_points
				  $firstName = $First_name;
				  $lastName = $Last_name;

				  $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);

				  /*           * ************************igain Log Table change **************** */
				} else { //Merchandize Gift

				  /* $Redemption_Items = $this->Redemption_Model->get_all_items('', '', $Company_id, 0, 0, $data['enroll']);

				  foreach ($Redemption_Items as $item) {

					$lv_Company_merchandise_item_id = $this->input->post($item['Company_merchandise_item_id']);
					
					if ($lv_Company_merchandise_item_id == $item['Company_merchandise_item_id']) {
					  $lv_Quantity = $this->input->post('Quantity_' . $item['Company_merchandise_item_id']);
					  $lv_Redeem_points = $item['Billing_price_in_points'];
					  $lv_Total_Redeem_points[] = ($lv_Redeem_points * $lv_Quantity);					  
					  
					}
				  } */	

					
					// print_r($this->input->post('RedeemItemArray'));
					$RedeemItemArray=$this->input->post('RedeemItemArray');					
					foreach($RedeemItemArray as $key => $value) {						
						$newvalue=json_decode($value,true);	
						foreach($newvalue as $val){
							
							// echo"--Item_id-----".$val['Item_id']."<br>";
							// echo"--QTY-----".$val['QTY']."<br>";
								
							$lv_Quantity = $val['QTY'];
							$Item_details=$this->Redemption_Model->Get_Merchandize_Item_details($val['Item_id']);
							
							// print_r($Item_details);
							
							
							$lv_Redeem_points=$Item_details[0]->Billing_price_in_points;
							
							// echo"--lv_Redeem_points-----".$lv_Redeem_points."<br>";							
							$lv_Total_Redeem_points[] = ($lv_Redeem_points * $lv_Quantity);
							
						}
						
					}
				
					$lv_Grand_total = array_sum($lv_Total_Redeem_points);
					// echo"--lv_Grand_total-----".$lv_Grand_total."<br>";
					// echo"--Current_point_balance-----".$Current_point_balance."<br>";
				  // die;

				  $lv_Grand_total = array_sum($lv_Total_Redeem_points);
				  if ($lv_Grand_total > $Current_point_balance) {
					$this->session->set_flashdata("error_code", "Insufficient Current Balance.");
					redirect('Transactionc/redeem');
				  }
				  if ($lv_Grand_total <= 0) {
					$this->session->set_flashdata("error_code", "Please Enter Valid Item Quantity.");
					redirect('Transactionc/redeem');
				  }
				}



				if ($Seller_topup_access == '1') {

				  $Total_seller_bal = ($seller_curbal + $lv_Grand_total);
				  $result3 = $this->Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

				  /*           * *******************Send Threshold Mail*************** */
				  $company_details = $this->Igain_model->get_company_details($Company_id);
				  $Threshold_Merchant = $company_details->Threshold_Merchant;

				  $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
				  $Seller_balance = $seller_details2->Current_balance;
				  $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;

				  if ($Threshold_Merchant >= $Seller_balance) {
					//****mail to super seller
					$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
					$Company_admin = $Super_Seller->First_name . " " . $Super_Seller->Last_name;
					$Admin_Email_content = array(
						'Seller_name' => $Seller_full_name,
						'Seller_balance' => $Seller_balance,
						'Super_Seller_flag' => 1,
						'Notification_type' => "Seller Threshold Balance",
						'Template_type' => 'Seller_threshold'
					);
					$this->send_notification->send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
					//****mail to super seller
					//****mail to seller
					$Seller_Email_content = array(
						'Seller_name' => $Seller_full_name,
						'Seller_balance' => $Seller_balance,
						'Company_admin' => $Company_admin,
						'Super_Seller_flag' => 0,
						'Notification_type' => "Seller Threshold Balance",
						'Template_type' => 'Seller_threshold'
					);
					$this->send_notification->send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
					//****mail to seller
				  }
				  /*           * *******************Send Threshold Mail*************** */
				}



				/*         * ******************* Update Seller Bill No.****************************************** */
				// $result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
				$result7 = $this->Transactions_model->update_topup_billno($data['enroll'], $billno_withyear_ref);
				/****************************Update Block Points*********************************************************** */
				$curr_bal = ($card_bal - $lv_Grand_total);
				if($Redeem_points > $Current_point_balance)
				{
					$curr_bal = 0;
					$block_value= ($Redeem_points-$Current_point_balance);
					$Blocked_points = ($Blocked_points + $block_value);
					$result290 = $this->Transactions_model->update_customer_blockpoints($cardId, $Company_id,$Blocked_points);
				}
				/*****************************************************************************************************/
				

				$reddem_amount = $reddem_amt + $lv_Grand_total;

				$result2 = $this->Transactions_model->update_customer_balance($cardId, $curr_bal, $Company_id, $topup, $Todays_date, $purchase_amt, $reddem_amount);
				$Avialable_balance = ($curr_bal - ($Blocked_points + $Debit_points));
				if ($Avialable_balance < 0) {
				  $Avialable_balance = 0;
				} else {
				  $Avialable_balance = $Avialable_balance;
				}
				if ($Redeem_type == 1) {//Normal
				  $Email_content = array(
					  'Todays_date' => $Todays_date,
					  'Redeem_points' => $this->input->post("Redeem_points"),
					  'Notification_type' => 'Just Redeem',
					  'Template_type' => 'Redeem'
				  );
				  $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
				} else {

				  $subject = "Redemption Transaction from Merchandizing Catalogue  of our " . $Company_details->Company_name;

				  $html = '<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							</head>
							<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">
							<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
								<tr>
									<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
									<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
								</tr>
								<tr>
								<td Align=top>
									<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
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
																					<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="' . base_url() . 'images/redemption.jpg" width=580 height=200 hspace="0" vspace="0">
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
															<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
																Dear ' . $Full_name . ',
															</P>
															<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>

															Thank You for Redeeming  Item(s)  from our Merchandize Catalogue. Please find below the details of your transaction. <br><br>
															<strong>Redemption Date:</strong> ' . date("d M Y", strtotime($Trans_date)) . '<br><br></P>';
				  $html.='<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>';
				  $i = 0;
				  
				  
				  
				$RedeemItemArray=$this->input->post('RedeemItemArray');	
				
				foreach($RedeemItemArray as $key => $value) {
					
					$newvalue=json_decode($value,true);
					
					foreach($newvalue as $val){
						
						
						
						
						// echo"--Item_id-----".$val['Item_id']."<br>";
						// echo"--QTY-----".$val['QTY']."<br>";
							
						$lv_Quantity = $val['QTY'];
						$Item_details=$this->Redemption_Model->Get_Merchandize_Item_details($val['Item_id']);
						
						// print_r($Item_details);
						
						
						$lv_Item_code = $Item_details[0]->Company_merchandize_item_code;
						$lv_Partner_id = $Item_details[0]->Partner_id;						
						$lv_Redeem_points=$Item_details[0]->Billing_price_in_points;
					
						if($val['Item_id']=$Item_details[0]->Company_merchandise_item_id) {
							
							$lv_Total_Redeem_points= ($lv_Redeem_points * $lv_Quantity);
							
							echo"--lv_Total_Redeem_points-----".$lv_Total_Redeem_points."--lv_Partner_id-----".$lv_Partner_id." ----lv_Redeem_points-----".$lv_Redeem_points."----lv_Item_code-----".$lv_Item_code."---<br>";	
						
						
						
						/* }
						
					}
					
				} */
				
				
				
				  
				  
				  
				 /*  $Redemption_Items = $this->Redemption_Model->get_all_items('', '', $Company_id, 0, 0, $data['enroll']);
				  foreach ($Redemption_Items as $Item_details) {
					  
					  
					$lv_Company_merchandise_item_id = $this->input->post($Item_details['Company_merchandise_item_id']);
					//$lv_Grand_total=$this->input->post('Grand_total');
					$Redeem_points = $lv_Grand_total;
					$lv_Quantity = $this->input->post('Quantity_' . $Item_details['Company_merchandise_item_id']);
					$lv_Redeem_points = $Item_details['Billing_price_in_points'];
					$lv_Item_code = $Item_details['Company_merchandize_item_code'];
					$lv_Partner_id = $Item_details['Partner_id']; 
					if ($lv_Company_merchandise_item_id == $Item_details['Company_merchandise_item_id']) { 
					
				*/
						
						
					  $lv_Total_Redeem_points = ($lv_Quantity * $lv_Redeem_points);

					  /*               * ********************************** */

					  //$lv_Item_code=$item['Company_merchandize_item_code'];
					  //$lv_Partner_id=$item['Partner_id'];

					  /*               * ****************Changed AMIT 16-06-2016************ */
					  $this->load->model('Catalogue/Catelogue_model');
					  $Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($lv_Partner_id, $Company_id);
					  foreach ($Get_Partner_Branches as $Branch) {
						$Branch_code = $Branch->Branch_code;
					  }
					  /*               * ***************************** */
					  $characters = 'A123B56C89';
					  $string = '';
					  $Voucher_no = "";
					  for ($i = 0; $i < 16; $i++) {
						$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
					  }
					  $Voucher_status = "31";
					  $Remarks = $this->input->post('Remarks1');
					  if ($Remarks != "") {
						$Remarks = $this->input->post('Remarks1');
					  } else {
						$Remarks = "Redeem Merchandize Gift";
					  }
					  $insert_data = array(
						  'Company_id' => $Company_id,
						  'Trans_type' => 10,
						  'Redeem_points' => $lv_Redeem_points,
						  'Quantity' => $lv_Quantity,
						  'Trans_date' => $lv_date_time,
						  'Create_user_id' => $data['enroll'],
						  'Seller' => $data['enroll'],
						  'Seller_name' => $Seller_name,
						  'Enrollement_id' => $Customer_enroll_id,
						  'Card_id' => $cardId,
						  'Item_code' => $lv_Item_code,
						  'Voucher_no' => $Voucher_no,
						  'Voucher_status' => $Voucher_status,
						  'Delivery_method' => 28,
						  'Merchandize_Partner_id' => $lv_Partner_id,
						  'Remarks' => $Remarks,
						  'Merchandize_Partner_branch' => $Branch_code,
						  'Update_date' => $lv_date_time,
						  'Update_User_id' => $data['enroll'],
						  'Bill_no' => $tp_bill
					  );
					  $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);

					  $Voucher_array[] = $Voucher_no;


					  /*               * ***********Nilesh change igain Log Table change 14-06-2017******************* */
					  //$get_cust_detail = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
					  //$Enrollement_id = $get_cust_detail->Enrollement_id;
					  //$First_name = $get_cust_detail->First_name;
					  //$Last_name = $get_cust_detail->Last_name;
					  $opration = 1;
					  $userid = $data['userId'];
					  $what = "Merchandize Item Redemption at Branch";
					  $where = "Just Redeem";
					  $toname = "";
					  $opval = 'Item Code-' . $lv_Item_code . ', Points-' . $lv_Redeem_points . '& Voucher no-' . $Voucher_no;  // redeem point amt
					  $firstName = $Full_name;
					  $lastName = $Full_name;

					  $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $data['enroll'], $data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);

					  /*               * ****************igain Log Table change 14-06-2017********************* */




					  /*               * ******************************** */
					  $html.= '<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				<b>Merchandize Item</b>
																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				' . $Item_details[0]->Merchandize_item_name. '
																			</TD>
																		</TR>
																		<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				<b>Voucher No.</b>
																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				' . $Voucher_no . '
																			</TD>
																		</TR>
																		<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				<b>Quantity</b>
																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				' . $lv_Quantity . '
																			</TD>
																		</TR>
																		<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				<b>Redeem ' . $Company_details->Currency_name . '</b>
																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				' . $lv_Redeem_points . '
																			</TD>
																		</TR>
																		<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				<b>Total Redeem ' . $Company_details->Currency_name . ' </b>
																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				' . $lv_Total_Redeem_points . '
																			</TD>
																		</TR>
																		<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				<b>Status</b>
																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																				Used
																			</TD>
																		</TR>
																		<TR>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px;background-color: #98b7b7;" align=left>

																			</TD>
																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px;background-color: #98b7b7;" align=left>

																			</TD>
																		</TR>

																		';
					  $i++;
					}
				  }
				}
				
				  $html.='<TR>
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			<b>Grand Total ' . $Company_details->Currency_name . ' </b>
																		</TD>
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			' . $lv_Grand_total . '
																		</TD>
																	</TR>
																	<TR>
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			<b>Available Balance</b>
																		</TD>
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			' . $Avialable_balance . '
																		</TD>
																	</TR>';
				  $html.='</TABLE>

															<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
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
															 <P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=center>
																	<STRONG>You can also visit the below link using your login credentials and check details.</STRONG> Visit
																	<span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
																	<a style="color:#C7702E" title="Member Website" href="' . $Company_details->Website . '" target="_blank">Member Website</a>
																	</span>
																</P>';
				  if ($Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "") {

					$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 0; COLOR: #333333; FONT-SIZE: 25px; mso-line-height-rule: exactly" align=center>
																You can also download Android & iOS App
																</P>';
				  }

				  $html.='</td>
													</tr>
												</table>
											</td>
										</tr>';
				  if ($Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "") {
					$html.='<tr>
											<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
											<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
											<tr style="HEIGHT: 10px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
					if ($Company_details->Cust_apk_link != "" && $Company_details->Cust_ios_link != "") {
					  $app_table_width = "WIDTH: 49%;";
					} else {
					  $app_table_width = "WIDTH: 100%;";
					}
					if ($Company_details->Cust_apk_link != "") {

					  $html.='<table style="BORDER-BOTTOM: transparent 1px solid; BORDER-LEFT: transparent 1px solid; <?php echo $app_table_width; ?> BORDER-TOP: transparent 1px solid; BORDER-RIGHT: transparent 1px solid;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
															<tr>
																<td style="PADDING-BOTTOM: 4px; PADDING-LEFT: 40px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=middle>
																		<DIV style="mso-table-lspace: 0; mso-table-rspace: 0">
																		<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																		<tr>
																		<td style="PADDING-BOTTOM: 10px; PADDING-LEFT: 100px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																			<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																			<tr>
																					<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																					<a href="' . $Company_details->Cust_apk_link . '" title="Google Play" target="_blank">
																						<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="' . base_url() . 'images/Gooogle_Play.png" width=64 height=64 hspace="0" vspace="0">
																					</a>
																					</td>
																				</tr>
																			</table>
																		</td>
																		</tr>
																		</table>
																		</DIV>
																</td>
															</tr>
													</table> ';
					}
					if ($Company_details->Cust_ios_link != "") {

					  $html.='<table style="BORDER-BOTTOM: transparent 1px solid; BORDER-LEFT: transparent 1px solid; <?php echo $app_table_width; ?> BORDER-TOP: transparent 1px solid; BORDER-RIGHT: transparent 1px solid;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
																<tr>
																<td style="PADDING-BOTTOM: 4px; PADDING-LEFT: 120px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=middle>
																<DIV style="mso-table-lspace: 0; mso-table-rspace: 0">
																<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																	<tr>
																	<td style="PADDING-BOTTOM: 10px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																			<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																					<tr>
																						<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																							<a href="' . $Company_details->Cust_ios_link . '" title="iOS App" target="_blank">
																								<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="' . base_url() . 'images/iOs_app_store.png" width=64 height=64 hspace="0" vspace="0">
																							</a>
																						</td>
																					</tr>
																			</table>
																	</td>
																	</tr>
																</table>
																</DIV>
																</td>
																</tr>
														</table>';
					}
					$html.='</td>
											</tr>
										</table>
									</td>
									</tr>';
				  }
				  $html.='<tr>
											<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
												<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
													<tr style="HEIGHT: 20px">
														<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
															<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly" align=left>
																<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to ' . $Company_details->Company_name . ' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law.
																If you are not the intended recipient or responsible for delivery to the intended recipient,
																you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. ' . $Company_details->Company_name . ' will not accept any claims for damages arising out of viruses.<br>
																Thank you for your cooperation.</em>
															</P>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								</tr>
								<tr>
									<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
								</tr>
							</table>
							</body>
							</html>';




				  // echo "<br>".$html;
				  // echo $html;
				  // die;

				  $Email_content = array(
					  'Contents' => $html,
					  'subject' => $subject,
					  'Notification_type' => 'Redemption',
					  'Template_type' => 'Redemption'
				  );

				  $Notification = $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
				}
				if($Daily_points_consumption_flag==1 || $Enable_company_meal_flag==1){
				$this->session->set_flashdata("success_code", " Adjustment transaction done successfully !!!");
				}else{
					$this->session->set_flashdata("success_code", " Redeem transaction done successfully !!!");
				}
				// var_dump($Email_content);
				//die;
				redirect('Transactionc/redeem');
			  }
	  
		} else {
			
			redirect('Login', 'refresh');
			
		}
    }

    /*     * *********************************AMIT END ******************************************** */

    /*     * *********************************Ravi END ******************************************** */

    function get_bonus_points_for() {
      $result = $this->Transactions_model->get_bonus_points_for($this->input->post("bonus_points_for"), $this->input->post("Company_id"));
      // var_dump($result);
      if ($result->Bonus_points > 0) {
        $this->output->set_output(json_encode(array('Bonus_points' => $result->Bonus_points, 'Bonus_points_for' => $result->Bonus_points_for)));
        // echo json_encode($result->Seller_Redemptionratio);
        //$this->output->set_output(json_encode($result['Seller_Redemptionratio']));
      } else {
        $this->output->set_output(json_encode(array('Bonus_points' => 0)));
      }
    }

    /*     * *********************************Ravi END ******************************************** */
    /*     * ******************AMIT 12-05-2017******************* */

    public function Update_booking_appointment() {
      error_reporting(0);
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Logged_user_enrollid = $session_data['enroll'];
        //$data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];

        $company_details = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;

        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Seller_name = $seller_details->First_name . " " . $seller_details->Middle_name . " " . $seller_details->Last_name;

        $From_date = date("Y-m-d");
        $To_date = date("Y-m-d");
        $data["Appointment_date"] = "Todays Bookings";
        $data["Appointment_date2"] = "List of Updated Bookings Today";
        if (isset($_REQUEST["submit"])) {

          $From_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
          $data["Appointment_date"] = "List of Bookings on " . $From_date;
          $data["Appointment_date2"] = "List of Updated Bookings of " . $From_date;
          if ($_REQUEST["start_date"] == "") {
            $data["Appointment_date"] = "Todays Bookings";
            $From_date = date("Y-m-d");
          }
          $To_date = $From_date;
        }
        if (isset($_REQUEST["Update"])) {
          $data["Appointment_date"] = "Todays Bookings";
          $data["All_Trans_Records2"] = $this->Report_model->get_all_cust_booking_appointments('', '', '', '');

          foreach ($data["All_Trans_Records2"] as $rec) {
            if (isset($_REQUEST[$rec->Booking_id])) {
              if ($_REQUEST[$rec->Booking_id] == $rec->Booking_id) {
                $this->session->set_flashdata("msg_flash", "Booking Status Updated Successfully !!!");


                $Appointment_date = date('Y-m-d', strtotime($_REQUEST["Appointment_date_" . $rec->Booking_id]));
                $Hours = $_REQUEST["THH_" . $rec->Booking_id];
                $Minutes = $_REQUEST["TMM_" . $rec->Booking_id];

                // echo"---Appointment_date----".$Appointment_date."---<br>";
                // echo"---Hours----".$Hours."---<br>";
                // echo"---Minutes----".$Minutes."---<br>";
                $Appointment_time = $Hours . ':' . $Minutes . ':' . '00';
                // echo"---Appointment_time----".$Appointment_time."---<br>";
                $Update_booking_appointment = $this->Report_model->Update_booing_appointment($rec->Booking_id, $_REQUEST["status_" . $rec->Booking_id], $Appointment_date, $Appointment_time, $data['enroll']);



                $status = $_REQUEST["status_" . $rec->Booking_id];
                if ($status == 'Confirmed' || $status == 'Cancel') {

                  if ($rec->Membership_id != "") {
                    $Enroll_details = $this->Igain_model->get_customer_details($rec->Membership_id, $Company_id);
                    $Create_user_id = $Enroll_details->Enrollement_id;
                    $Membership_id = $Enroll_details->Card_id;
                    $Phone_no = $Enroll_details->Phone_no;
                    $Email_id = $Enroll_details->User_email_id;
                  }


                  if ($Create_user_id != "") {
                    $Create_user_id = $Create_user_id;
                  } else {
                    $Create_user_id = "0";
                  }

                  $Email_content = array(
                      'Notification_type' => 'Online Booking Appointment Confirmed',
                      'Customer_name' => $rec->Customer_name,
                      'Vehicle_number' => $rec->Vehicle_no,
                      'Date_Appointment' => $Appointment_date,
                      'Appointment_time' => $Appointment_time,
                      'Contact_number' => $rec->Phone_no,
                      'Email_Id' => $rec->Email_id,
                      'Membership_id' => $rec->Membership_id,
                      'Pickup_flag' => $rec->Pickup_flag,
                      'Status' => $status,
                      'Template_type' => 'Online_booking_confirmed'
                  );
                  $this->send_notification->send_Notification_email($Create_user_id, $Email_content, $session_data['enroll'], $Company_id);





                  /*                   * **********Nilesh change igain Log Table change 14-06-2017************** */
                  // $get_cust_detail = $this->Igain_model->get_enrollment_details($enroll_id);
                  $Enrollement_id = $Create_user_id;
                  $First_name = $rec->Customer_name;
                  $Last_name = $rec->Customer_name;
                  $opration = 2;
                  $userid = $session_data['userId'];
                  $what = "Online Booking Appointment Confirmed";
                  $where = "Update booking appointment";
                  $toname = "";
                  $opval = 'Appointment Confirmed'; //
                  $firstName = $First_name;
                  $lastName = $Last_name;
                  $Todays_date = date('Y-m-d');
                  $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $session_data['enroll'], $session_data['username'], $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Create_user_id);

                  /*                   * ****************igain Log Table change 14-06-2017*************** */
                }
                // echo"---status----".$status."---<br>";
              }
            }
          }
          // die;
        }

        $data["Trans_Records"] = $this->Report_model->get_all_cust_booking_appointments($From_date, $To_date, '', '');

        $data["All_Trans_Records"] = $this->Report_model->get_all_cust_booking_appointments($From_date, $To_date, '', '');

        $this->load->view('transactions/Update_booking_appointment_view', $data);
      }
    }
	public function Push_orders() 
	{ 
		if ($this->session->userdata('logged_in')) 
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Logged_user_enrollid = $session_data['enroll'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Company_id = $session_data['Company_id'];
			
			/**************Get current date time***************/
				$logtimezone = $session_data['timezone_entry'];
				$timezone = new DateTimeZone($logtimezone);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$Current_date_time = $date->format('Y-m-d H:i:s');
				$lvp_date_time = $date->format('Y-m-d H:i:s');
			/**************Get current date time***************/
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
			$data['Seller_topup_access'] = $company_details->Seller_topup_access;
			$data['Threshold_Merchant'] = $company_details->Threshold_Merchant;
			$this->OnlineOrderAPI_key = $company_details->Company_orderapi_encryptionkey;
			$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data['Seller_balance'] = $seller_details->Current_balance;
			$data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
			$data['Sub_seller_Enrollement_id'] = $seller_details->Sub_seller_Enrollement_id;
			
            $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
            $data['Symbol_of_currency'] = $currency_details->Symbol_of_currency;
			
			if ($data['Sub_seller_admin'] == 1) 
			{
			  $Logged_user_enrollid = $data['enroll'];
			} 
			else 
			{
			  $Logged_user_enrollid = $data['Sub_seller_Enrollement_id'];
			} 

			if ($_POST == NULL) 
			{
			  $data['result'] = $this->Transactions_model->Get_failed_order_details($Company_id,$Current_date_time); 
			 
			  $this->load->view('transactions/Push_trans_to_pos', $data);
			} 
			else 
			{
				$Bill_no1 = $this->input->post('Bill_no');
			
				if($Bill_no1 !=NULL)
				{
					// $combo_meals = array();
					$Sides_ItemCondiments = array();
					$Item_details = array();
					foreach($Bill_no1 as $Bill_no2)
					{ 
						/********************sandeep**********************/
						$data["Order_details"] = $this->Transactions_model->get_order_details2($Bill_no2,$Company_id);
						
						if($data["Order_details"] != NULL)
						{	
							/************nilesh define array**************/
								$order_total_loyalty_points = array();
								$Mpesa_Total_Paid_Amount = array();
								$Bill_Amount_Due = array();
								$EquiRedeem = array();
								$Cust_wish_redeem_point = array();
								$Total_Shipping_Cost = array();
								$subtotal = array();
							/***********nilesh define array****************/	
							
							foreach($data["Order_details"] as $Order_det)
							{
								$mySideCondis = [];
								$side_item_codes = [];
								$Sides_CondimentsCode = [];
								$Required_CondimentsCode = [];  
								$MainItemInfo = NULL; 
														
								$getCondiment = $this->Transactions_model->get_transaction_item_condiments($Bill_no2,$Order_det["Item_code"],$Company_id);
								
								$SideCondiments_TotalPrice = 0;
								
								foreach($getCondiment as $n)
								{
									$side_item_codes[] = $n["Condiment_Item_code"];
								}
								
								$newArr12 = [];
								$MainItemTotal_Price = 0;
								
								if($Order_det['Combo_meal_flag'] == 1)
								{
									// $MainItemInfo = $this->Transactions_model->get_main_item($Order_det["Item_code"],$Company_id);
									$MainItemInfo17 = $this->Transactions_model->get_main_item($Order_det["Item_code"],$Company_id);
								
									if($MainItemInfo17 != NULL)
									{
										foreach($MainItemInfo17 as $MainItemInfoData)
										{
											$Main_ItemCondiments = [];
											if(in_array($MainItemInfoData["Main_or_side_item_code"],$side_item_codes))
											{
												$MainItemTotal_Price = $MainItemTotal_Price + $MainItemInfoData['Price'];							
											
												$main_items_condiments = $this->Transactions_model->get_transaction_item_condiments($Bill_no2,$MainItemInfoData["Main_or_side_item_code"],$data['Company_id']);
								
												if($main_items_condiments != NULL && count($main_items_condiments) > 0)
												{
													foreach($main_items_condiments as $opt)
													{
														if($opt["Condiment_Item_code"] != "")
														{
												//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
																
														//	$RrsValues10 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_Item_code,$Company_id);

															$Main_ItemCondiments[] = array("Item_code"=>$opt["Condiment_Item_code"],"Item_qty"=>$opt["Quantity"],"Item_rate"=>$opt["Price"]); //,"ParentItem_code"=>$MainItemInfoData["Main_or_side_item_code"]
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
									
								foreach($getCondiment as $n)
								{
									// $RrsValues13 = $this->Transactions_model->Get_merchandize_item12($n["Condiment_Item_code"],$Company_id);
									if($Order_det['Combo_meal_flag'] == 0)
									{
										// $Required_CondimentsCode[] = array("Item_code"=>$RrsValues13->Company_merchandize_item_code,"Item_name"=>$RrsValues13->Merchandize_item_name,"Item_qty"=>1,"Item_price"=>$RrsValues13->Billing_price);	
										
										$Required_CondimentsCode[] = array("Item_code"=>$n['Condiment_Item_code'],"Item_qty"=>$n['Quantity'],"Item_rate"=>$n['Price']); //,"ParentItem_code"=>$Order_det["Item_code"]	
									}
									if($Order_det['Combo_meal_flag'] == 1 ) //&& $RrsValues13->Merchandize_item_type != 119
									{
										$Sides_ItemCondiments = [];
										
										if($n["Condiment_Item_code"] == $MainItemInfo[0]["Main_or_side_item_code"])
										{
											continue;
										}
										
										if(!in_array($n["Condiment_Item_code"],$mySideCondis))
										{
											$side_items_condiments = $this->Transactions_model->get_transaction_item_condiments($Bill_no2,$n["Condiment_Item_code"],$data['Company_id']);
				
											$Sides_ItemCondiments = [];
										
											if($side_items_condiments != NULL && count($side_items_condiments) > 0)
											{
												foreach($side_items_condiments as $opt)
												{
													if($opt["Condiment_Item_code"] != "")
													{
												//	echo $opt->Condiment_item_code." this is condiment of ".$code4."<br>";
													//	$RrsValues11 = $this->Shopping_model->Get_merchandize_item12($opt->Condiment_Item_code,$Company_id);
											
														$Sides_ItemCondiments[] = array("Item_code"=>$opt["Condiment_Item_code"],"Item_qty"=>(int)$opt["Quantity"],"Item_rate"=>$opt["Price"]); //,"ParentItem_code"=>$n["Condiment_Item_code"]
														//"Item_name"=>$RrsValues11->Merchandize_item_name,
														$mySideCondis[] = $opt["Condiment_Item_code"];
															
														//	$indx = array_search($opt["Condiment_Item_code"],$side_item_codes);
														//	array_splice($side_item_codes,$indx,1);
													}
												}

											}

											$Sides_CondimentsCode[] = array("Item_code"=>$n["Condiment_Item_code"],"Item_qty"=>$n["Quantity"],"Item_rate"=>$n["Price"],"Condiments" => $Sides_ItemCondiments); //"Item_type" => "SIDE", //,"ParentItem_code"=>$Order_det["Item_code"]
											//"Item_name"=>$n["Merchandize_item_name"],
											$SideCondiments_TotalPrice = $SideCondiments_TotalPrice + $n["Price"];
											
											/* $Sides_CondimentsCode[] = array("Item_code"=>$n["Condiment_Item_code"],"Item_name"=>$n["Merchandize_item_name"],"Item_qty"=>$n["Quantity"],"Item_price"=>$n["Price"],"Item_type" => "SIDE","Condiments" => $Sides_ItemCondiments);
										
											$SideCondiments_TotalPrice = $SideCondiments_TotalPrice + $n["Price"]; */
										}
									}
								}
								// $subtotal = $Order_det['Billing_price'] + $MainItemInfo[0]['Price'] + $SideCondiments_TotalPrice;
								
							/***************Get Merchandize item name********/					
								$item_id = $Order_det['Company_merchandise_item_id'];
								$result = $this->Transactions_model->Get_merchandize_item($item_id,$Company_id);
								$sellerID = $result->Seller_id;
								$Company_merchandize_item_code = $result->Company_merchandize_item_code;
								$Merchandize_item_name = $result->Merchandize_item_name;
								$Merchandize_category_id = $result->Merchandize_category_id;
								$Combo_meal_flag = $result->Combo_meal_flag;
								$Combo_meal_number = $result->Combo_meal_number;
								$Stamp_item_flag = $result->Stamp_item_flag;
								$Extra_earn_points = 0;
								$Extra_earn_points = $result->Extra_earn_points;
							/***************Get Merchandize item name**************/	
							
								$CondimentChildQuery = [];
								$CondimentChildQuery1 = [];
								$MainItemQty = $Order_det["Quantity"];
								
								if($Required_CondimentsCode != NULL)
								{
									$OReqItems = $Required_CondimentsCode;
									
									foreach($OReqItems as $v0)
									{
										$CondimentChildQuery[] = $v0;
										
										array_pop($v0); // to remove parent item code
										
										for($d = 0; $d < $MainItemQty; $d++)
										{
											$CondimentChildQuery1[] = $v0;
										}
									}
								}
								
								if($Combo_meal_flag == 1)
								{
									$ComboMealMainItem = [];
									$MainCondimentsSet = [];
									
									$ComboMealMenuItem = array('Item_code' =>$Company_merchandize_item_code,'Item_qty' =>1,'Item_rate' => number_format($Order_det['Billing_price'],2),'Condiments' => array());   //$Order_det['price'] $Order_det["Quantity"]
									
									if($MainItemInfo != NULL)
									{
										foreach($MainItemInfo as $main)
										{	
											$ComboMealMainItem = array( 'Item_code' =>$main["Main_or_side_item_code"] ,'Item_qty' => $main["Quanity"],'Item_rate' => number_format($main["Price"],2), 'Condiments' => $main["Condiments"]); //,"ParentItem_code"=>$Company_merchandize_item_code
											
											$CondimentChildQuery[] = $ComboMealMainItem;
											
											if($main["Condiments"] != NULL)
											{
												array_pop($main["Condiments"][0]);
											}
											
											break;
										}
									}
									
									$sideItems = $Sides_CondimentsCode;
									
									foreach($sideItems as $v)
									{
										$CondimentChildQuery[] = $v;
									} 
									
									for($m = 0; $m < $MainItemQty; $m++)
									{
										$combo_meals[] =  array("ComboMealMenuItem" => $ComboMealMenuItem,"ComboMealObjectNum"=>$Combo_meal_number,"ComboMealMainItem"=>$ComboMealMainItem,"SideItems" => json_decode(json_encode($sideItems)));
									}
								}
									$Item_condiments = explode("+",$Order_det['remark3']);
									if(count($Item_condiments) > 0)
									{	
										$Condiments_details = array();
									
										foreach($Item_condiments as $condiment)
										{
											if($condiment != "")
											{
												for($p = 1; $p <= $Order_det["Quantity"]; $p++)
												{
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
										$Item_details[] =  json_decode(json_encode(array( 'Item_code' =>$Company_merchandize_item_code , 'Item_qty' => $Order_det["Quantity"], 'Item_rate' => number_format($Order_det['Billing_price'],2),
										'Condiments' => $CondimentChildQuery )));
									}
									
								/********************get order basic details*********************/	
									$delivery_outlet = $Order_det['Seller'];
									$delivery_type = $Order_det['Delivery_method'];
									$Table_no = $Order_det['Table_no'];
									$Cust_enrollement_id = $Order_det['Enrollement_id'];
									$Mpesa_Total_Paid_Amount1 = $Order_det['Mpesa_Paid_Amount'];
									$Mpesa_TransID = $Order_det['Mpesa_TransID'];
									$order_total_loyalty_points1 = $Order_det['Loyalty_pts'];
									$Cust_wish_redeem_point1 = $Order_det['Redeem_points'];
									$EquiRedeem1 = $Order_det['Redeem_amount'];
									$Bill_Amount_Due1 = $Order_det['COD_Amount'];
									$Total_Shipping_Cost1 = $Order_det['Shipping_cost'];
									$Payment_type_id = $Order_det['Payment_type_id'];
									$Trans_date_time = $Order_det['Trans_date'];
									$subtotal1 = $Order_det['Purchase_amount'];
								/*********************get order basic details*********************/
								
								$subtotal[] = $subtotal1;
								$order_total_loyalty_points[] = $order_total_loyalty_points1;
								$Mpesa_Total_Paid_Amount[] = $Mpesa_Total_Paid_Amount1;
								$Bill_Amount_Due[] = $Bill_Amount_Due1;
								$EquiRedeem[] = $EquiRedeem1;
								$Cust_wish_redeem_point[] = $Cust_wish_redeem_point1;
								$Total_Shipping_Cost[] = $Total_Shipping_Cost1;
							} //order foreach 
							
							$subtotal = array_sum($subtotal);
							$order_total_loyalty_points = array_sum($order_total_loyalty_points);
							$Mpesa_Total_Paid_Amount = array_sum($Mpesa_Total_Paid_Amount);
							$Bill_Amount_Due = array_sum($Bill_Amount_Due);
							$EquiRedeem = array_sum($EquiRedeem);
							$Cust_wish_redeem_point = array_sum($Cust_wish_redeem_point);
							$Total_Shipping_Cost = array_sum($Total_Shipping_Cost);
							
						/**************get delivery outlet details****************/
							$delivery_outlet_details = $this->Igain_model->get_enrollment_details($delivery_outlet);
							$Seller_api_url = $delivery_outlet_details->Seller_api_url;
							$Seller_api_url2 = $delivery_outlet_details->Seller_api_url2;
							$Outlet_name = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name;
							$Outlet_address = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name.",".$delivery_outlet_details->Current_address."<br>".$delivery_outlet_details->Phone_no."<br>";
						/***************get delivery outlet details*******************/
						
						/****************get customer details**********************/
							$Member_details = $this->Igain_model->get_enrollment_details($Cust_enrollement_id);	
							$CustomerName = $Member_details->First_name.' '.$Member_details->Last_name;
							$Cust_phno = App_string_decrypt($Member_details->Phone_no);
							$phno = substr($Cust_phno,3); 
							$Update_Current_balance = $Member_details->Current_balance;
							$CardId = $Member_details->Card_id;
						/****************get customer details********************/	
						
						/*************get customer selected address**************/			
							$Address_type_details=$this->Transactions_model->Fetch_selected_customer_addresses($Cust_enrollement_id);
							// $Cust_selected_address =  $Address_type_details->Contact_person.", ".$Address_type_details->Address.", ".$Address_type_details->city_name.", ".$Address_type_details->country_name.", ".$Address_type_details->Phone_no."<br>";
						/************get customer selected address***************/
						
							if($Seller_api_url != "" || $Seller_api_url != NULL){
								if($delivery_type == 29){ //Delivery
									$Cust_selected_address22 = $Address_type_details->Address;
								}else{
									$Cust_selected_address22 = "";
								}
								if($Mpesa_Total_Paid_Amount <= 0 || $Mpesa_Total_Paid_Amount =="")
								{ 
									$Mpesa_TransID = ""; 
								}
								if($delivery_type == 29) // Delivery
								{
									$Newdelivery_type = 1;
								}
								else if($delivery_type == 28) // //Pick-Up
								{
									$Newdelivery_type = 2;
								}
								else if($delivery_type == 107) // In-Store
								{
									$Newdelivery_type = 3;
								}
								else
								{
									$Newdelivery_type = 0; 
								}
								 
								if($Payment_type_id ==7 ) //M-PESA
								{	
									$Paid_by = "M-PESA & COD";
								}
								else //COD
								{
									$Paid_by = "COD";
								}

								$Cust_selected_address22 = trim(preg_replace('/\s\s+/', ' ', $Cust_selected_address22));
								
								$Address_lines = explode(",",$Cust_selected_address22);
								
								$input_args = Array ( 
								'Membership_id' => $CardId,'Member_name' => trim($CustomerName),'Phone_no' => $phno,'Transaction_date' => $lvp_date_time,'Orderno' => $Bill_no2,'Item_details' => $Item_details,'Combo_meals'=>$combo_meals, 'Sub_total' => number_format($subtotal,2) ,'Total_delivery_cost'=>number_format($Total_Shipping_Cost, 2) , 'Redeem_points' => round($Cust_wish_redeem_point) ,'Redeem_amount' => number_format($EquiRedeem, 2) ,"Balance_Due" => number_format($Bill_Amount_Due, 2),"Mpesa_Paid_Amount" =>  number_format($Mpesa_Total_Paid_Amount, 2),"Mpesa_TransID" => $Mpesa_TransID,'Gained_points' => round($order_total_loyalty_points),'Balance_points' => $Update_Current_balance ,'Paid_by' => $Paid_by,'Symbol_of_currency' => $currency_details->Symbol_of_currency, 'Address_line1' => trim($Address_lines[0]),'Address_line2' => trim($Address_lines[1]),'Address_line3' => trim($Address_lines[2]),'Address_line4' => trim($Address_lines[3]),'Delivery_type' => $Newdelivery_type,'Outlet_id' => $delivery_outlet,'Outlet_name' => $Outlet_name);
								
								$input_args = json_encode($input_args);
								
								// echo "<pre>";	
								// echo $input_args; 
								// die;
								
								$url = $Seller_api_url; // order api url
								$ch = curl_init();
								$timeout = 0; // Set 0 for no timeout.
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_POSTFIELDS,$input_args);
								curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Flag '.$this->OnlineOrderAPI_key,'Content-Type:application/json'));
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
								$result = curl_exec($ch);
								$err = curl_error($ch);
								curl_close($ch);
						
								if ($err) {
								  // echo "cURL Error #:" . $err;
								} else { }
								
								$response = json_decode(json_decode($result, true),true);
								
								//$response = json_decode($result, true);
								// if($result == null || $result == "" || $response['Status'] != "0000"){ }
								// echo "Middleware response---------".$response['Status']."<br/>";   die;
								
								$Order_manual_billno = "";
								if($response['Status'] == "0000")
								{
									$Order_manual_billno = $response['POS_Bill_No']; // pos bill no.
									
									if($Order_manual_billno != "")  //update manual bill no.
									{
										$updateData = array('Manual_billno' => $Order_manual_billno);
										$this->db->where(array('Bill_no' => $Bill_no2,'Card_id' => $CardId,'Company_id' => $Company_id));
										$this->db->update("igain_transaction",$updateData);
										
										$error_flag = '1001'; // order pushed successfully
									}
								}
								else
								{
									$error_flag = '2068'; // order fail
								}
							}
						}
						/*******************sandeep****************/
					} //get order details foreach 
				}
				if($error_flag == '1001'){
					$this->session->set_flashdata("success_code", "Order pushed successfully");
				}
				else{
					$this->session->set_flashdata("error_code", "Order not pushed.!!");
				}
					redirect(current_url());
			}
		}
    }

  }

?>
