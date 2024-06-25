<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Coal_Transactionc extends CI_Controller {

    public function __construct() {
      parent::__construct();

      $this->load->database();
      $this->load->helper('url');
      $this->load->model('login/Login_model');
      $this->load->model('Redemption_Catalogue/Redemption_Model');
      $this->load->model('Igain_model');
      $this->load->model('enrollment/Enroll_model');
      $this->load->model('Coal_transactions/Coal_Transactions_model');
      $this->load->model('administration/Administration_model');
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('pagination');
      //$this->load->library('Coal_Send_notification');
      $this->load->library('Send_notification');
      $this->load->model('master/currency_model');
      $this->load->model('Report/Report_model');
      $this->load->model('Segment/Segment_model');
      $this->load->model('Catalogue/Catelogue_model');
      $this->load->model('transactions/Transactions_model');
    }

    /*     * **********AMIT New Menu 26-09-2016************************ */

    public function Purchase_Redeem() {
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
        $data['Sub_seller_Enrollement_id'] = $seller_details->Sub_seller_Enrollement_id;
        $data['Merchant_sales_tax'] = $seller_details->Merchant_sales_tax;

        /*         * *********GET Seller Currency***************************** */
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance_enroll'] = $seller_details->Current_balance;
        $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
        $Symbol_currency = $currency_details->Symbol_of_currency;
        $data['Symbol_currency'] = $Symbol_currency;
        
        
        /*         * ******************************** */

        $redemptionratio = $seller_details->Seller_Redemptionratio;

        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details2->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details2->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details2->Threshold_Merchant;

        if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
          $company_details = $this->Igain_model->get_company_details($data['Company_id']);

          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $data['Sub_seller_Enrollement_id'];
        }
        
        
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Coal_Transactionc/Purchase_Redeem";
        $total_row = $this->Coal_Transactions_model->Purchase_redeem_transactions_list('', '', $Logged_user_id, $data['enroll'], $data['Company_id']);
        //echo "count".count($total_row);
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
        /* -----------------------Pagination--------------------- */

        $logtimezone = $session_data['timezone_entry'];
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');

        //echo "cardId".$_REQUEST["cardId"];		

        if ($_POST == NULL && (!isset($_REQUEST["Page_cardId"]))) {
          $data["results"] = $this->Coal_Transactions_model->Purchase_redeem_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('Coal_transactions/Coal_purchase_redeem_view', $data);
        } else {
          /*           * **********Changed AMIT 17-*06-2016************************ */
          $start = 0;
          $limit = 10;
          $cardis = $this->input->post("cardId");
          if (isset($_REQUEST["Page_cardId"])) {
            $cardis = $_REQUEST["Page_cardId"];
            $limit = $_REQUEST["limit"];
          }


          /*           * ******************************************************************************** */
          if (substr($cardis, 0, 1) == "%") {
            $get_card = substr($cardis, 2); //*******read card id from magnetic card***********///
          } else {
            $get_card = substr($cardis, 0, 16); //*******read card id from other magnetic card***********///
          }


          $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
          $phnumber = $dial_code . $this->input->post("cardId");

          $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
          foreach ($member_details as $rowis) {
            $cardId = $rowis['Card_id'];
            $user_activated = $rowis['User_activated'];
            $Phone_no = $rowis['Phone_no'];
          }

          if ($user_activated == 0) {
            $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
            redirect(current_url());
          }


          if (strlen($cardis) != 0) {
            if ($cardis != '0') {
              if ($cardId == $cardis || $Phone_no == $phnumber) {
                $cust_details = $this->Coal_Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                foreach ($cust_details as $row25) {
                  $fname = $row25['First_name'];
                  $midlename = $row25['Middle_name'];
                  $lname = $row25['Last_name'];
                  $bdate = $row25['Date_of_birth'];
                  $address = $row25['Current_address'];
                  $bal = $row25['Current_balance'];
                  $Blocked_points = $row25['Blocked_points'];
                  $phno = $row25['Phone_no'];
                  $companyid = $row25['Company_id'];
                  $cust_enrollment_id = $row25['Enrollement_id'];
                  $image_path = $row25['Photograph'];
                  $filename_get1 = $image_path;
                  $Cust_Current_balance = $row25['Current_balance'];
                  $pinno = $row25['pinno'];
                  $Cust_Tier_id = $row25['Tier_id'];
                }

                $tp_count = $this->Coal_Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                $purchase_count = $this->Coal_Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                $gainedpts_atseller = $this->Coal_Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $data['enroll']);
                if ($gainedpts_atseller == NULL) {
                  $gainedpts_atseller = 0;
                }

                $data['get_card'] = $cardId;
                $data['Cust_enrollment_id'] = $cust_enrollment_id;
                $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                $data['Phone_no'] = $phno;
                //$data['Current_balance'] = ($bal-$Blocked_points);
                $data['Topup_count'] = $tp_count;
                $data['Purchase_count'] = $purchase_count;
                $data['Gained_points'] = $gainedpts_atseller;
                $data['Photograph'] = $filename_get1;
                $data['Customer_pin'] = $pinno;

                $Loyalty_names = "PA-ONLY REDEEM";
                /*                 * ***********Get Customer merchant balance 19-8-2016 AMIT**************** */
                // $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($data['enroll'],$cust_enrollment_id);	
                $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Logged_user_enrollid, $cust_enrollment_id);
                $data["Current_balance"] = 0;
                $data["Cust_prepayment_balance"] = 0;
                $data["Seller_total_redeem"] = 0;
                if ($Get_Record != NULL) {
                  foreach ($Get_Record as $val) {
                    $data["Current_balance"] = ($val["Cust_seller_balance"]-($val["Cust_block_points"] + $val["Cust_debit_points"]));
                    $data["Seller_total_purchase"] = $val["Seller_total_purchase"];
                    $data["Seller_total_redeem"] = $val["Seller_total_redeem"];
                    $data["Seller_total_gain_points"] = $val["Seller_total_gain_points"];
                    $data["Seller_total_topup"] = $val["Seller_total_topup"];
                    $data["Seller_paid_balance"] = $val["Seller_paid_balance"];
                    $data["Cust_prepayment_balance"] = $val["Cust_prepayment_balance"];
                  }
                }

                /*                 * ***************AMIT 14-06-2016 Changed************* */

                $data["Tier_id"] = $Cust_Tier_id;
                $data["Tier_details"] = $this->Redemption_Model->Get_tier_details($data['Company_id'], $Cust_Tier_id);
                foreach ($data["Tier_details"] as $Tier_details) {
                  $data["Redeemtion_limit"] = $Tier_details->Redeemtion_limit;
                  $data["Tier_name"] = $Tier_details->Tier_name;
                }
                $Redemption_Items = $this->Coal_Transactions_model->get_all_Purchase_redeem_items($limit, $start, $data['Company_id'], 0, 0, $Cust_Tier_id, $Logged_user_enrollid);
                $data['Redemption_Items'] = $Redemption_Items;
                /*                 * ***************************************************** */
                $this->load->view('Coal_transactions/Coal_purchase_redeem_transaction', $data);
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
          // $this->load->view('Coal_transactions/loyalty_purchase_transaction', $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Purchase_redeem_done() {

      if ($_POST == NULL) {
        $this->session->set_flashdata("error_code", "Sorry, Redeem Transaction Failed. Invalid Data Provided!!");
        redirect('Coal_transactions/redeem');
      } else {

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
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;
        $Company_id = $session_data['Company_id'];

        $Sub_seller_Enrollement_id = $seller_details->Sub_seller_Enrollement_id;

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }

        $logtimezone = $session_data['timezone_entry'];
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');
        $Trans_date = $date->format('Y-m-d');

        $Company_details = $this->Igain_model->get_company_details($data['Company_id']);
        if ($data['userId'] == 3) {
          $top_seller = $this->Coal_Transactions_model->get_top_seller($data['Company_id']);
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
          $Sub_seller_admin = $user_details->Sub_seller_admin;
          $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;
          $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

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

        $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($Company_id, $this->input->post("cardId"), $phnumber);
        foreach ($member_details as $rowis) {
          $cardId = $rowis['Card_id'];
        }



        $cust_details = $this->Coal_Transactions_model->cust_details_from_card($Company_id, $cardId);
        //print_r($cust_details);
        foreach ($cust_details as $row25) {
          $card_bal = $row25['Current_balance'];
          $Blocked_points = $row25['Blocked_points'];
          $Customer_enroll_id = $row25['Enrollement_id'];
          //echo $Customer_enroll_id;die;
          $topup = $row25['Total_topup_amt'];
          $purchase_amt = $row25['total_purchase'];
          $Cust_Tier_id = $row25['Tier_id'];
          $reddem_amt = $row25['Total_reddems'];
          $Communication_flag = $row25['Communication_flag'];
          $Full_name = $row25['First_name'] . " " . $row25['Last_name'];
        }

        $top_db = $Purchase_Bill_no;
        $len = strlen($top_db);
        $str = substr($top_db, 0, 5);
        $tp_bill = substr($top_db, 5, $len);

        $Purchase_Bill_no = $tp_bill + 1;
        $Purchase_Bill_no_withyear_ref = $str . $Purchase_Bill_no;


        $Redemption_Items = $this->Coal_Transactions_model->get_all_Purchase_redeem_items('', '', $Company_id, 0, 0, $Cust_Tier_id, $seller_id);

        $lv_Grand_total = $this->input->post('Tax_Grand_total');
        $Redeem_points = $lv_Grand_total;
        $lv_Total_Redeem_points = $this->input->post('Tax_Grand_total');
        $Remarks = $this->input->post('Remarks');
        $Trans_type = $this->input->post("Trans_type");
        if ($Remarks == "") {
          $Remarks = "-";
        }
        $lv_Calc_Sales_tax = $this->input->post('Merchant_sales_tax2');
        $lv_Sub_total = $this->input->post('Grand_total');
        foreach ($Redemption_Items as $item) {

          $lv_Company_merchandise_item_id = $this->input->post($item['Company_merchandise_item_id']);

          if ($lv_Company_merchandise_item_id == $item['Company_merchandise_item_id']) {

            $lv_Quantity = $this->input->post('Quantity_' . $item['Company_merchandise_item_id']);

            $lv_Item_code = $item['Company_merchandize_item_code'];
            $lv_Partner_id = $item['Partner_id'];

            /*             * ****************Changed AMIT 16-06-2016************ */

            $Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($lv_Partner_id, $Company_id);
            foreach ($Get_Partner_Branches as $Branch) {
              $Branch_code = $Branch->Branch_code;
            }
            /*             * ***************************** */
            $characters = 'A123B56C89';
            $string = '';
            $Voucher_no = "";
            for ($i = 0; $i < 16; $i++) {
              $Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
            }
            $Voucher_status = "Used";

            if ($item["Size_flag"] == 1) {
              $Size_flag = $this->input->post('Size_flag_' . $item['Company_merchandise_item_id']);
              //echo "Size_flag ".$Size_flag;
              $Get_item_size_info = $this->Coal_Transactions_model->Get_Price_Points_by_size($Size_flag, $item["Company_merchandize_item_code"], $item["Company_id"]);
              foreach ($Get_item_size_info as $Rec) {
                $Billing_price = $Rec["Billing_price"];
                $Billing_price_in_points = $Rec["Billing_price_in_points"];

                if ($Trans_type == 2) {//Purchase
                  $lv_Redeem_points = 0;
                  $lv_Billing_price = ($Billing_price * $lv_Quantity);
                  $Item_sales_tax = (($lv_Billing_price * $lv_Calc_Sales_tax) / $lv_Sub_total);
                } else { //Redeemtion
                  $lv_Redeem_points = round($Billing_price_in_points * $lv_Quantity);
                  $lv_Billing_price = 0;
                  $Item_sales_tax = (($lv_Redeem_points * $lv_Calc_Sales_tax) / $lv_Sub_total);
                }
                $insert_data = array(
                    'Company_id' => $Company_id,
                    'Trans_type' => $Trans_type,
                    'Redeem_points' => $lv_Redeem_points,
                    'Purchase_amount' => $lv_Billing_price,
                    'Item_sales_tax' => $Item_sales_tax,
                    'Quantity' => $lv_Quantity,
                    'Trans_date' => $lv_date_time,
                    'Create_user_id' => $data['enroll'],
                    'Seller' => $data['enroll'],
                    'Seller_name' => $Seller_name,
                    'Enrollement_id' => $Customer_enroll_id,
                    'Card_id' => $cardId,
                    'Item_code' => $lv_Item_code,
                    //'Voucher_no' => $Voucher_no,
                    //'Voucher_status' => $Voucher_status,
                    'Merchandize_Partner_id' => $lv_Partner_id,
                    'Remarks' => $Remarks,
                    'Merchandize_Partner_branch' => $Branch_code,
                    'Bill_no' => $tp_bill
                );
                $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);

                $Voucher_array[] = $Voucher_no;
              }
            } else {
              if ($Trans_type == 2) {//Purchase
                $lv_Redeem_points = 0;
                $lv_Billing_price = ($item['Billing_price'] * $lv_Quantity);
                $Item_sales_tax = (($lv_Billing_price * $lv_Calc_Sales_tax) / $lv_Sub_total);
              } else { //Redeemtion
                $lv_Redeem_points = round($item['Billing_price_in_points'] * $lv_Quantity);
                $Item_sales_tax = (($lv_Redeem_points * $lv_Calc_Sales_tax) / $lv_Sub_total);
                $lv_Billing_price = 0;
              }
              $insert_data = array(
                  'Company_id' => $Company_id,
                  'Trans_type' => $Trans_type,
                  'Redeem_points' => $lv_Redeem_points,
                  'Purchase_amount' => $lv_Billing_price,
                  'Item_sales_tax' => $Item_sales_tax,
                  'Quantity' => $lv_Quantity,
                  'Trans_date' => $lv_date_time,
                  'Create_user_id' => $data['enroll'],
                  'Seller' => $data['enroll'],
                  'Seller_name' => $Seller_name,
                  'Enrollement_id' => $Customer_enroll_id,
                  'Card_id' => $cardId,
                  'Item_code' => $lv_Item_code,
                  //'Voucher_no' => $Voucher_no,
                  //'Voucher_status' => $Voucher_status,
                  'Merchandize_Partner_id' => $lv_Partner_id,
                  'Remarks' => $Remarks,
                  'Merchandize_Partner_branch' => $Branch_code,
                  'Bill_no' => $tp_bill
              );
              $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);

              $Voucher_array[] = $Voucher_no;
            }
          }
        }
        //}


        /*         * **********************Update Bill No.******************* */

        $result7 = $this->Coal_Transactions_model->update_purchase_billno($seller_id, $Purchase_Bill_no_withyear_ref);
        /*         * ***************************************** */

        /*         * ***********Get Customer merchant balance**************** */
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
        /*         * ******************************************************************** */
        $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
        $Symbol_currency = $currency_details->Symbol_of_currency;

        if ($Trans_type == 2) {//Purchase
          $lv_Cust_seller_balance = $data["Cust_seller_balance"];
          $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"] - $lv_Grand_total);
          $curr_bal = ($card_bal);
          $reddem_amount = $reddem_amt;
          $purchase_amt = ($purchase_amt + $lv_Grand_total);
          $lv_Seller_total_purchase = ($data["Seller_total_purchase"] + $lv_Grand_total);
          $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);

          $Type1 = "Purchase";
          $Type2 = "Purchase Amount";
          $Type3 = "Total Purchase Amount";
          $Type4 = $Symbol_currency;

          $banner_image = base_url() . 'images/transaction.jpg';
        } else {
          $lv_Cust_seller_balance = ($data["Cust_seller_balance"] - $lv_Grand_total);
          $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
          $curr_bal = ($card_bal - $lv_Grand_total);
          $reddem_amount = ($reddem_amt + $lv_Grand_total);
          $purchase_amt = $purchase_amt;
          $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
          $lv_Seller_total_redeem = ($data["Seller_total_redeem"] + $lv_Grand_total);

          $Type1 = "Redeem";
          $Type2 = "Redeem Points";
          $Type3 = "Total Redeem Points";
          $Type4 = "Points";

          $banner_image = base_url() . 'images/redemption.jpg';
        }



        $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
        $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
        $lv_Seller_total_topup = ($data["Seller_total_topup"]);
        $lv_Cust_block_amt = ($data["Cust_block_amt"]);
        $lv_Cust_block_points = ($data["Cust_block_points"]);
        $lv_Cust_debit_points = ($data["Cust_debit_points"]);
        /*         * ***********Update customer merchant balance************************ */
        $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $lv_Cust_debit_points);
        /*         * ************************************************** */



        $result2 = $this->Coal_Transactions_model->update_customer_balance($cardId, $curr_bal, $Company_id, $topup, $Todays_date, $purchase_amt, $reddem_amount);
        $Avialable_balance = ($curr_bal - $Blocked_points);


        if ($Communication_flag == 0) {
          $this->session->set_flashdata("error_code", "Transaction done successfully !!!");
          redirect('Coal_Transactionc/Purchase_Redeem');
        }
        /*         * ******************EMAIL TEMPLATE******************************************** */
        /* $subject = "Transaction at merchant ".$Seller_name ;
          $html = '<html xmlns="http://www.w3.org/1999/xhtml">';
          $html .= '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><meta http-equiv="X-UA-Compatible" content="IE=edge"><link href="'.base_url().'assets/css/email_template.css" rel="stylesheet" /></head>';

          $html .= '<body style="width: 100% !important;min-width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100% !important;margin: 0;padding: 0;background-color: #FFFFFF">
          <table class="body" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;height: 100%;width: 100%;table-layout: fixed" cellpadding="0" cellspacing="0" width="100%" border="0">
          <tbody>
          <tr style="vertical-align: top">
          <td class="center" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;background-color: #FFFFFF" align="center" valign="top">

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
          <tbody>
          <tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
          <table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #000000;background-color: transparent" cellpadding="0" cellspacing="0" width="100%" bgcolor="transparent"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent">
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center">
          <div style="font-size:12px" align="center">
          <a href="#" target="_blank">
          <img class="center fullwidth" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;margin: 0 auto;float: none;width: 100% !important;max-width: 500px" align="center" border="0" src="'.$banner_image.'" alt="Image" title="Image" width="500">
          </a>
          </div></td></tr></tbody></table>
          </td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
          </td>
          </tr>
          </tbody></table>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
          <table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #61626F" cellpadding="0" cellspacing="0" width="100%" bgcolor="#61626F"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 30px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px">
          <div style="color:#ffffff;line-height:120%;font-family:Helvetica;">
          <div style="font-size:12px;line-height:14px;color:#ffffff;font-family:Helvetica;text-align:left;"><p style="margin: 0;font-size: 18px;line-height: 22px;text-align: left"><span style="font-size: 18px; line-height: 28px;"><strong>
          Dear  '.$Full_name.',
          </strong></span></p></div>
          </div>
          </td></tr></tbody></table>
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 0px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px">
          <div style="color:#B8B8C0;line-height:150%;font-family:Helvetica;">
          <div style="font-size:14px;line-height:18px;color:#B8B8C0;font-family:Helvetica;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 21px;text-align: left"><span style="font-size: 14px; line-height: 21px;">

          Thank You for '.$Type1.'  Item(s)  from our Merchandize Catalogue. Please find below the details of your transaction. <br><br>
          <strong>Transaction Date:</strong> '.$Trans_date. '<br><br>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" width="100%">';

          $i=0;
          $Redemption_Items = $this->Coal_Transactions_model->get_all_Purchase_redeem_items('','',$Company_id,0,0,$Cust_Tier_id,$seller_id);
          foreach ($Redemption_Items as $Item_details)
          {
          $lv_Company_merchandise_item_id=$this->input->post($Item_details['Company_merchandise_item_id']);
          $lv_Sub_total=$this->input->post('Grand_total');
          $lv_Tax_Grand_total=$this->input->post('Tax_Grand_total');
          $lv_Quantity=$this->input->post('Quantity_'.$Item_details['Company_merchandise_item_id']);
          $lv_Item_code=$Item_details['Company_merchandize_item_code'];
          $lv_Partner_id=$Item_details['Partner_id'];

          if($lv_Company_merchandise_item_id==$Item_details['Company_merchandise_item_id'])
          {

          if($Item_details["Size_flag"]==1)
          {
          $Size_flag=$this->input->post('Size_flag_'.$Item_details['Company_merchandise_item_id']);
          //echo "Size_flag ".$Size_flag;
          $Get_item_size_info = $this->Coal_Transactions_model->Get_Price_Points_by_size($Size_flag,$Item_details["Company_merchandize_item_code"],$Item_details["Company_id"]);
          foreach($Get_item_size_info as $Rec)
          {
          $Billing_price=$Rec["Billing_price"];
          $Billing_price_in_points=$Rec["Billing_price_in_points"];
          if($Trans_type==2)//Purchase
          {
          $lv_Item_price_points=$Rec["Billing_price"];
          $lv_Total_Price_points=($Billing_price*$lv_Quantity);
          }
          else //Redeemtion
          {
          $lv_Total_Price_points=round($Billing_price_in_points*$lv_Quantity);
          $lv_Item_price_points=$Rec["Billing_price_in_points"];
          }


          }

          }
          else
          {
          if($Trans_type==2)//Purchase
          {
          $lv_Item_price_points=$Item_details["Billing_price"];
          $lv_Total_Price_points=($Item_details['Billing_price']*$lv_Quantity);
          }
          else //Redeemtion
          {
          $lv_Total_Price_points=round($Item_details['Billing_price_in_points']*$lv_Quantity);
          $lv_Item_price_points=$Item_details["Billing_price_in_points"];
          }

          }


          $html .='<tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0">
          <table width="100%" align="center" bgcolor="transparent" cellpadding="0" cellspacing="0" border="0">
          <tr>
          <td valign="top" width="250">
          <div class="col num6" style="display: inline-block; vertical-align: top; text-align: center; width: 100%; margin-right: 10px; margin-bottom: 10px;">
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
          <tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding: 5px;border: 2px solid #EEE;">
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
          <tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-bottom: 5px;">
          <div style="color:#555555;line-height:120%;font-family:Helvetica;">
          <div style="font-size:14px;line-height:17px;color:#fff;font-family:Helvetica; text-align:left;">
          <p style="margin: 0;font-size: 14px;line-height: 17px"><strong>'.$Item_details["Merchandize_item_name"].'</strong></p>
          </div>
          </div>
          </td>
          </tr>
          </tbody>
          </table>


          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
          <tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-bottom: 5px;">
          <div style="color:#555555;line-height:120%;font-family:Helvetica;">
          <div style="font-size:14px;line-height:17px;color:#fff;font-family:Helvetica; text-align:left;">
          <p style="margin: 0;font-size: 14px;line-height: 17px"><strong>Quantity : </strong>'.$lv_Quantity.'</p>
          </div>
          </div>
          </td>
          </tr>
          </tbody>
          </table>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
          <tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-bottom: 5px;">
          <div style="color:#555555;line-height:120%;font-family:Helvetica;">
          <div style="font-size:14px;line-height:17px;color:#fff;font-family:Helvetica; text-align:left;">
          <p style="margin: 0;font-size: 14px;line-height: 17px"><strong>'.$Type2.' : </strong>'.$lv_Item_price_points.'  '.$Type4.'</p>
          </div>
          </div>
          </td>
          </tr>
          </tbody>
          </table>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" cellspacing="0" cellpadding="0">
          <tbody>
          <tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-bottom: 5px;">
          <div style="color:#555555;line-height:120%;font-family:Helvetica;">
          <div style="font-size:14px;line-height:17px;color:#fff;font-family:Helvetica; text-align:left;">
          <p style="margin: 0;font-size: 14px;line-height: 17px"><strong>'.$Type3.'  : </strong>'.$lv_Total_Price_points.' '.$Type4.'</p>
          </div>
          </div>
          </td>
          </tr>
          </tbody>
          </table>



          </td>
          </tr>
          </tbody>
          </table>
          </div>
          </td>
          </tr>
          </table>
          </td>
          </tr>';
          $i++;
          }
          }
          if($Trans_type==2)//Purchase
          {
          $html .='</table>
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" width="100%">
          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Sub Total</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Sub_total.' '.$Type4.'
          </td>
          <tr><tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Sales Tax</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Calc_Sales_tax.'
          </td>
          <tr>
          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Grand Total</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Tax_Grand_total.' '.$Type4.'
          </td>
          <tr>

          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Available Loyalty Balance</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Cust_seller_balance.' Points
          </td>
          <tr>

          <tr>

          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Available Prepayment Balance</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Cust_prepayment_balance.' '.$Symbol_currency.'
          </td>
          <tr>

          <tr>

          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Transaction by</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$Seller_name.'
          </td>
          <tr>

          </tbody>

          </table>

          </td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
          </td></tr></tbody></table>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">';
          }
          else
          {
          $html .='</table>
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" width="100%">

          <tr>
          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Grand Total</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Tax_Grand_total.' '.$Type4.'
          </td>
          <tr>
          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Available Loyalty Balance</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Cust_seller_balance.' Points
          </td>
          <tr>
          <tr>
          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Available Prepayment Balance</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$lv_Cust_prepayment_balance.' '.$Symbol_currency.'
          </td>
          <tr>
          <tr>
          <tr style="vertical-align: top">
          <td style="color: #fff; font-family: Helvetica; text-align: right; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          <strong>Transaction by</strong>
          </td>
          <td colspan="5" style="color: #fff; font-family: Helvetica; border: 1px solid #eee; font-size: 14px; line-height: 20px; text-align: left; padding: 5px;">
          &nbsp;&nbsp;&nbsp;'.$Seller_name.'
          </td>
          <tr>
          </tbody>
          </table>
          </td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
          </td></tr></tbody></table>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">';
          }
          $html .='<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #F0F0F0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F0F0F0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 0px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent">';

          $html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 15px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px">
          <div style="color:#959595;line-height:150%;font-family:Helvetica;">
          <div style="font-size:12px;line-height:18px;color:#959595;font-family:Helvetica;text-align:left;">
          <div class="txtTinyMce-wrapper" style="font-size:12px; line-height:18px;">
          <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">You can also visit the below link using your login credentials and check details.</strong> Visit <span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
          <a style="color:#C7702E" title="Member Website" href="'.$Company_details->Website.'" target="_blank">Member Website</a></span>
          </p>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px" align="center">
          <div style="height: 1px;">
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;border-top: 1px solid #DADADA;width: 100%" align="center" border="0" cellspacing="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="center"></td>
          </tr>
          </tbody></table>
          </div>
          </td>
          </tr></tbody>
          </table>';

          if( $Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "")
          {
          $html .='<p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><strong><span style="font-size: 18px; line-height: 28px;">You can also download Android & iOS App</span></strong></p>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="center" valign="top">
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;max-width: 156px" align="center" valign="top">
          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="left" valign="middle">';
          if($Company_details->Cust_apk_link != "")
          {
          $html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;padding: 0 5px 5px 0" align="left" border="0" cellspacing="0" cellpadding="0" height="37">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="37" align="left" valign="middle">
          <a href="'.$Company_details->Cust_apk_link.'" title="Google Play" target="_blank">
          <img style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;max-width: 32px !important" src="'.base_url().'images/Gooogle_Play.png" alt="Google Play" title="Google Play" width="32">
          </a>
          </td>
          </tr>
          </tbody></table>';
          }
          if($Company_details->Cust_ios_link != "")
          {
          $html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;padding: 0 5px 5px 0" align="left" border="0" cellspacing="0" cellpadding="0" height="37">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="37" align="left" valign="middle">
          <a href="'.$Company_details->Cust_ios_link.'" title="App Store" target="_blank">
          <img style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;max-width: 32px !important" src="'.base_url().'images/iOs_app_store.png" alt="App Store" title="App Store" width="32">
          </a>
          </td>
          </tr>
          </tbody></table>';
          }

          $html .='</td>
          </tr></tbody>
          </table></td></tr></tbody>
          </table></td></tr></tbody>
          </table>';
          }

          $html .='</div>
          </div>
          </div>
          </td>
          </tr></tbody>
          </table>

          </td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody>
          </table>

          <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: #ffffff" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
          <table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #2C2D37" cellpadding="0" cellspacing="0" width="100%" bgcolor="#2C2D37"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 15px;padding-right: 0px;padding-bottom: 15px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr style="vertical-align: top">
          <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 0px;padding-right: 15px;padding-bottom: 0px;padding-left: 15px">
          <div style="color:#959595;line-height:150%;font-family:Helvetica;">
          <div style="font-size:12px;line-height:18px;color:#959595;font-family:Helvetica;text-align:left;"><div class="txtTinyMce-wrapper" style="font-size:12px; line-height:18px;"><p style="margin: 0;font-size: 14px;line-height: 21px;text-align: left"><span style="font-size: 12px; line-height: 18px;"><em>
          <strong>DISCLAIMER:</strong> This e-mail message is proprietary to '.$Company_details->Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law.
          If you are not the intended recipient or responsible for delivery to the intended recipient,
          you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_details->Company_name.' will not accept any claims for damages arising out of viruses.<br>
          Thank you for your cooperation.
          </em></span></p></div></div>
          </div>
          </td>
          </tr></tbody></table>
          </td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></table></td></tr></tbody>
          </table>
          </td>
          </tr>
          </tbody>
          </table>
          </body>
          </html>'; */

        $subject = "Transaction at merchant " . $Seller_name;
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
																				<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src=' . $banner_image . ' width=580 height=200 hspace="0" vspace="0">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table> 
														
														<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
															Dear ' . $Full_name . ' ,
														</P>';

        $html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
															Thank You for ' . $Type1 . '  Item(s)  from our Merchandize Catalogue. Please find below the details of your transaction. <br><br>
															<strong>Transaction Date:</strong> ' . $Trans_date . '<br><br>
														</P>									
											<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>
											';

        $i = 0;
        $Redemption_Items = $this->Coal_Transactions_model->get_all_Purchase_redeem_items('', '', $Company_id, 0, 0, $Cust_Tier_id, $seller_id);
        foreach ($Redemption_Items as $Item_details) {
          $lv_Company_merchandise_item_id = $this->input->post($Item_details['Company_merchandise_item_id']);
          $lv_Sub_total = $this->input->post('Grand_total');
          $lv_Tax_Grand_total = $this->input->post('Tax_Grand_total');
          $lv_Quantity = $this->input->post('Quantity_' . $Item_details['Company_merchandise_item_id']);
          $lv_Item_code = $Item_details['Company_merchandize_item_code'];
          $lv_Partner_id = $Item_details['Partner_id'];

          if ($lv_Company_merchandise_item_id == $Item_details['Company_merchandise_item_id']) {

            if ($Item_details["Size_flag"] == 1) {
              $Size_flag = $this->input->post('Size_flag_' . $Item_details['Company_merchandise_item_id']);
              //echo "Size_flag ".$Size_flag;
              $Get_item_size_info = $this->Coal_Transactions_model->Get_Price_Points_by_size($Size_flag, $Item_details["Company_merchandize_item_code"], $Item_details["Company_id"]);
              foreach ($Get_item_size_info as $Rec) {
                $Billing_price = $Rec["Billing_price"];
                $Billing_price_in_points = $Rec["Billing_price_in_points"];
                if ($Trans_type == 2) {//Purchase
                  $lv_Item_price_points = $Rec["Billing_price"];
                  $lv_Total_Price_points = ($Billing_price * $lv_Quantity);
                } else { //Redeemtion
                  $lv_Total_Price_points = round($Billing_price_in_points * $lv_Quantity);
                  $lv_Item_price_points = $Rec["Billing_price_in_points"];
                }
              }
            } else {
              if ($Trans_type == 2) {//Purchase
                $lv_Item_price_points = $Item_details["Billing_price"];
                $lv_Total_Price_points = ($Item_details['Billing_price'] * $lv_Quantity);
              } else { //Redeemtion
                $lv_Total_Price_points = round($Item_details['Billing_price_in_points'] * $lv_Quantity);
                $lv_Item_price_points = $Item_details["Billing_price_in_points"];
              }
            }

            $html .= '<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Merchandize item name</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																   ' . $Item_details["Merchandize_item_name"] . '
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
																	<b>' . $Type2 . ' </b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Item_price_points . '  ' . $Type4 . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>' . $Type3 . '</b>
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																	' . $lv_Total_Price_points . ' ' . $Type4 . '
																</TD>
															</TR>';
            $i++;
          }
        }
        if ($Trans_type == 2) {//Purchase
          $html .='
															<TR  style="border:#2f3131 2px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px">
																<TD colspan="2" align=left> 
																	
																</TD>
																	
															</TR>
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Sub Total</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Sub_total . ' ' . $Type4 . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Sales Tax</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Calc_Sales_tax . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Grand Total</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Tax_Grand_total . ' ' . $Type4 . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Available Loyalty Balance</b>
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																	' . $lv_Cust_seller_balance . '
																</TD>
															</TR>
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Available Prepayment Balance</b>
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																	' . $lv_Cust_prepayment_balance . ' ' . $Symbol_currency . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Transaction by</b>
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $Seller_name . '
																</TD>
															</TR>';
        } else {
          $html .= '
														<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Grand Total</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Tax_Grand_total . ' ' . $Type4 . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Available Loyalty Balance</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Cust_seller_balance . ' Points
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Available Prepayment Balance</b>
																</TD>
																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																   ' . $lv_Cust_prepayment_balance . ' ' . $Symbol_currency . '
																</TD>
															</TR>
																								
															<TR>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	<b>Transaction by</b>
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																	' . $Seller_name . '
																</TD>
															</TR>';
        }
        $html .='</td>
												</tr>
											</table>';
        $html .= '<br>
														<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
															Regards,
															<br>Loyalty Team.
														</P>';
        $html .= '</td>
									</tr>									
									<tr>
										<td style="BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
											<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
												<tr style="HEIGHT: 20px">
													<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
														<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=center>
															<STRONG>You can also visit the below link using your login credentials and check details.</STRONG> Visit
															<span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
																<a style="color:#C7702E" title="Member Website" href=' . $Company_details->Website . ' target="_blank">Member Website</a>
															</span>
														</P>';

        if ($Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "") {
          $html .= '<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 0; COLOR: #333333; FONT-SIZE: 25px; mso-line-height-rule: exactly" align=center>
																	You can also download Android & iOS App
															</P>';
        }
        $html .= '</td>
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
        $html .= '<tr>
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
					
					</table>

					</body>
					</html>

					<style>
					td, th{
					font-size: 13px !IMPORTANT;
					}
					</style>';
        $Email_content = array(
            'Contents' => $html,
            'subject' => $subject,
            'Notification_type' => 'Redemption',
            'Template_type' => 'Redemption'
        );
        $Notification = $this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
        $this->session->set_flashdata("error_code", "Transaction done successfully !!!");
        redirect('Coal_Transactionc/Purchase_Redeem');
      }
    }

    Public function Get_Price_Points_by_size() {
      $Size_flag = $this->input->post("Size_flag");
      $Company_merchandize_item_code = $this->input->post("Company_merchandize_item_code");
      $Company_id = $this->input->post("Company_id");
      $Result = $this->Coal_Transactions_model->Get_Price_Points_by_size($Size_flag, $Company_merchandize_item_code, $Company_id);

      foreach ($Result as $Rec) {
        $Billing_price = $Rec["Billing_price"];
        $Billing_price_in_points = $Rec["Billing_price_in_points"];
      }

      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('Billing_price' => $Billing_price, 'Billing_price_in_points' => $Billing_price_in_points)));
    }

    public function Purchase_redeem_transaction_receipt() {
      $this->load->model('master/currency_model');
      $Bill_no = $this->input->post("Bill_no");
      $Seller_id = $this->input->post("Seller_id");
      $Trans_id = $this->input->post("Trans_id");
      $transtype = $this->input->post("Transaction_type");
      $Sub_seller_Enrollement_id = $this->input->post("Sub_seller_Enrollement_id");

      /* echo "---Bill_no--".$Bill_no."--<br>";
        echo "---Seller_id--".$Seller_id."--<br>";
        echo "---Trans_id--".$Trans_id."--<br>";
        echo "---transtype--".$transtype."--<br>";
        die; */

      $Todays_date = date("Y-m-d");
      $seller_details = $this->Igain_model->get_enrollment_details($Seller_id);
      $seller_name = $seller_details->First_name . ' ' . $seller_details->Last_name;
      //echo "---seller_name--".$seller_name."--<br>";

      $address = $seller_details->Current_address;
      $timezone12 = $seller_details->timezone_entry;
      $Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;

      $company_details = $this->Igain_model->get_company_details($seller_details->Company_id);
      $compname = $company_details->Company_name;
      $Comp_redemptionratio = $company_details->Redemptionratio;

      //echo "---compname--".$compname."--<br>";
      $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
      $Symbol_currency = $currency_details->Symbol_of_currency;
      if ($transtype == 10) {
        $Symbol_currency = "Points";
      }
      if ($Seller_Redemptionratio != NULL) {
        $redemptionratio = $Seller_Redemptionratio;
      } else {
        $redemptionratio = $Comp_redemptionratio;
      }


      $transaction_details = $this->Coal_Transactions_model->get_purchase_redeem_bills_info($Bill_no, $transtype, $Seller_id);

      $data['transaction_details'] = $transaction_details;
      // print_r($transaction_details);
      // die;
      $Redeemed_item = "";
      //$Total_redeem_points = 0;
      foreach ($transaction_details as $transaction) {
        $data['Trans_id'] = $transaction['Trans_id'];

        $enrollid = $transaction['Enrollement_id'];
        $Transaction_type = $transaction['Trans_type'];
        $tra_date = $transaction['Trans_date'];

        $data['Manual_billno'] = $transaction['Manual_billno'];
        $data['Remark'] = $transaction['Remarks'];
        $data['Seller_name'] = $transaction['Seller_name'];
        $reedem = $transaction['Redeem_points'];

        $redeem_amt = $reedem;

        if ($Transaction_type == 2) {
          if ($transaction['Billing_price'] == 0.00) {
            $transaction['Billing_price'] = ($transaction['Purchase_amount'] / $transaction['Quantity']);
          }

          if ($transaction === end($transaction_details)) {
            $Redeemed_item .= $transaction['Merchandize_item_name'] . " ( Quantity - " . $transaction['Quantity'] . " X " . $transaction['Billing_price'] . '&nbsp;<font color="red" size="1em">' . $Symbol_currency . '</font>)';
          } else {
            $Redeemed_item .= $transaction['Merchandize_item_name'] . " ( Quantity - " . $transaction['Quantity'] . " X " . $transaction['Billing_price'] . '&nbsp;<font color="red" size="1em">' . $Symbol_currency . '</font>) <br>';
          }
        } else {
          if ($transaction['Billing_price_in_points'] == 0) {
            $transaction['Billing_price_in_points'] = ($transaction['Redeem_points'] / $transaction['Quantity']);
          }
          if ($transaction === end($transaction_details)) {
            $Redeemed_item .= $transaction['Merchandize_item_name'] . " ( Quantity - " . $transaction['Quantity'] . " X " . $transaction['Billing_price_in_points'] . " $Symbol_currency)";
          } else {
            $Redeemed_item .= $transaction['Merchandize_item_name'] . " ( Quantity - " . $transaction['Quantity'] . " X " . $transaction['Billing_price_in_points'] . " $Symbol_currency) <br>";
          }
        }
        //$Total_redeem_points = $Total_redeem_points + ( $transaction['Billing_price_in_points'] * $transaction['Quantity'] );
        $lv_Total_Purchase_amount[] = $transaction['Purchase_amount'];
        $lv_Total_redeem_points[] = $transaction['Redeem_points'];
        $lv_Item_sales_tax[] = $transaction['Item_sales_tax'];

        $data['Redeemed_item'] = $Redeemed_item;
        $data['Redeem_points'] = $redeem_amt;


        $customer_details = $this->Igain_model->get_enrollment_details($enrollid);
        $data['Cust_full_name'] = $customer_details->First_name . " " . $customer_details->Middle_name . " " . $customer_details->Last_name;
        $data['Cust_address'] = $customer_details->Current_address;
        $data['Cust_phone_no'] = $customer_details->Phone_no;
        $data['User_email_id'] = $customer_details->User_email_id;


        $data['Transaction_type'] = $transtype;
        $data['Company_name'] = $compname;
        $data['Seller_name'] = $seller_name;
        $data['Seller_address'] = $address;
        $data['Bill_no'] = $Bill_no;
        $data['Transaction_date'] = $tra_date;

        $data['Symbol_currency'] = $Symbol_currency;

        $data['Timezone'] = $timezone12;


        $timezone = new DateTimeZone($timezone12);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');

        $data['Todays_date'] = $Todays_date;
      }

      $data['Total_Purchase_amount'] = array_sum($lv_Total_Purchase_amount);
      $data['Total_redeem_points'] = array_sum($lv_Total_redeem_points);
      $data['Total_sales_tax'] = array_sum($lv_Item_sales_tax);

      $theHTMLResponse = $this->load->view('Coal_transactions/Coal_show_purchase_redeem_transaction_receipt', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionReceiptHtml' => $theHTMLResponse)));
    }

    public function Coal_show_purchase_redeem_transaction_details() {
      $seller_details = $this->Igain_model->get_enrollment_details($this->input->post("Seller_id"));
      //print_r($seller_details);
      $Seller_Enrollment_id = $seller_details->Enrollement_id;
      $Sub_seller_admin = $seller_details->Sub_seller_admin;
      $Sub_seller_Enrollment_id = $seller_details->Sub_seller_Enrollement_id;
      $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
      $Symbol_currency = $currency_details->Symbol_of_currency;
      $data['Symbol_currency'] = $Symbol_currency;
      if ($Sub_seller_admin == 1) {
        $Sub_Seller_id[] = $Seller_Enrollment_id;
        $data['Sub_sellers'] = $this->Igain_model->Get_sub_seller($Seller_Enrollment_id);
        if ($data['Sub_sellers'] != NULL) {
          foreach ($data['Sub_sellers'] as $Sub_sellers) {
            $Sub_Seller_id[] = $Sub_sellers->Enrollement_id;
          }
        }
        $data['transaction_details'] = $this->Coal_Transactions_model->get_transaction_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));

        $data['transaction_sum_details'] = $this->Coal_Transactions_model->get_transaction_sum_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));
        //var_dump($data['Sub_sellers']);
      } else {
        $Sub_Seller_id[] = $Sub_seller_Enrollment_id;
        $data['Sub_sellers'] = $this->Igain_model->Get_sub_seller($Sub_seller_Enrollment_id);
        if ($data['Sub_sellers'] != NULL) {
          foreach ($data['Sub_sellers'] as $Sub_sellers) {
            $Sub_Seller_id[] = $Sub_sellers->Enrollement_id;
          }
        }
        $data['transaction_details'] = $this->Coal_Transactions_model->get_transaction_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));

        $data['transaction_sum_details'] = $this->Coal_Transactions_model->get_transaction_sum_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));
      }


      $theHTMLResponse = $this->load->view('Coal_transactions/Coal_show_purchase_redeem_transaction_details', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionDetailHtml' => $theHTMLResponse)));
    }

    public function Preorder_item_list() {

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
        $data['Sub_seller_Enrollement_id'] = $seller_details->Sub_seller_Enrollement_id;

        $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
        $Symbol_currency = $currency_details->Symbol_of_currency;
        $data['Symbol_currency'] = $Symbol_currency;
        $data["Merchant_sales_tax"] = $seller_details->Merchant_sales_tax;
        $redemptionratio = $seller_details->Seller_Redemptionratio;
        $timezone12 = $seller_details->timezone_entry;

        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details2->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details2->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details2->Threshold_Merchant;
        $data['Timezone'] = $timezone12;


        $timezone = new DateTimeZone($timezone12);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $data['Current_date_time'] = $date->format('Y-m-d H:i:s');
        $data['Current_time'] = $date->format('H:i:s');

        if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
          $company_details = $this->Igain_model->get_company_details($data['Company_id']);

          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $data['Sub_seller_Enrollement_id'];
        }
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Coal_Transactionc/Preorder_item_list";
        $total_row = $this->Coal_Transactions_model->Preorder_item_list_count($Logged_user_enrollid, $data['Company_id']);
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
          $data["Preorder_items_done"] = $this->Coal_Transactions_model->Preorder_item_done_list($config["per_page"], $page, $Logged_user_enrollid, $data['Company_id']);

          $data["Preorder_items_not_done"] = $this->Coal_Transactions_model->Preorder_item_list($config["per_page"], $page, $Logged_user_enrollid, $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('Coal_transactions/Coal_preorder_items_list_view', $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Fulfill_preorder() {
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

      $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
      $seller_id = $user_details->Enrollement_id;
      $Topup_Bill_no = $user_details->Topup_Bill_no;
      $Purchase_Bill_no = $user_details->Purchase_Bill_no;
      $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

      $logtimezone = $session_data['timezone_entry'];
      $timezone = new DateTimeZone($logtimezone);
      $date = new DateTime();
      $date->setTimezone($timezone);
      $lv_date_time = $date->format('Y-m-d H:i:s');
      $Todays_date = $date->format('Y-m-d');


      $Preorder_id = $_REQUEST["Preorder_id"];
      $Card_id = $_REQUEST["Card_id"];
      $QTY = $_REQUEST["QTY"];
      $Trans_type = $_REQUEST["Trans_type"];
      $Sub_Total = $_REQUEST["Total_Price_Points"];
      $Preorder_id = $_REQUEST["Preorder_id"];
      $status = $_REQUEST["status"];
      $Customer_enroll_id = $_REQUEST["Customer_enroll_id"];
      $Company_merchandize_item_code = $_REQUEST["Company_merchandize_item_code"];
      $Merchandize_item_name = $_REQUEST["Merchandize_item_name"];
      $Partner_id = $_REQUEST["Partner_id"];
      $Full_name = $_REQUEST["Full_name"];
      $Symbol = $_REQUEST["Symbol"];
      $Sales_tax = $_REQUEST["Sales_tax"];
      $Grand_total = $_REQUEST["Grand_total"];

      /*       * ************Get Partner Branch******************************* */
      $Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($Partner_id, $Company_id);
      foreach ($Get_Partner_Branches as $Branch) {
        $Branch_code = $Branch->Branch_code;
      }
      /*       * ************************************************* */

      /*
        echo " Preorder_id ".$Preorder_id;
        echo " Card_id ".$Card_id;
        echo " QTY ".$QTY;
        echo " Trans_type ".$Trans_type;
        echo " Total_Price_Points ".$Total_Price_Points;
        echo " status ".$status;
        echo " Customer_enroll_id ".$Customer_enroll_id;
        echo " Company_merchandize_item_code ".$Company_merchandize_item_code;
        echo " Partner_id ".$Partner_id;
        echo " Branch_code ".$Branch_code; */

      /*       * ***************Get Customer details********************** */
      $cust_details = $this->Coal_Transactions_model->cust_details_from_card($Company_id, $Card_id);
      foreach ($cust_details as $row25) {
        $card_bal = $row25['Current_balance'];
        $Blocked_points = $row25['Blocked_points'];
        $Customer_enroll_id = $row25['Enrollement_id'];
        //echo $Customer_enroll_id;die;
        $topup = $row25['Total_topup_amt'];
        $purchase_amt = $row25['total_purchase'];
        $Cust_Tier_id = $row25['Tier_id'];
        $reddem_amt = $row25['Total_reddems'];
        $Communication_flag = $row25['Communication_flag'];
        $Full_name = $row25['First_name'] . " " . $row25['Last_name'];
      }

      if ($Trans_type == 2) {//Purchase
        $Purchase_amount = $Sub_Total;
        $Redeem_points = 0;
        $Trans_Type_name = "Purchase";
        $banner_image = base_url() . 'images/transaction.jpg';
        $Transaction = "Total Purchase Amount";
      } else { //Redeem
        $Redeem_points = $Sub_Total;
        $Purchase_amount = 0;
        $Trans_Type_name = "Redeem";
        $Transaction = "Total Redeem Points";
        $banner_image = base_url() . 'images/redemption.jpg';
      }
      $Item_per_price_points = ($Sub_Total / $QTY);

      $Update_date = $lv_date_time;
      /*       * ****************************Update Preorder***************************** */
      $result79 = $this->Coal_Transactions_model->update_preorder($Preorder_id, $status, $Update_date);
      /*       * **************************************************************************** */

      /*       * ***********Get Customer merchant balance**************** */
      $data["Cust_seller_balance"] = 0;
      $data["Seller_total_purchase"] = 0;
      $data["Seller_total_redeem"] = 0;
      $data["Seller_total_gain_points"] = 0;
      $data["Seller_total_topup"] = 0;
      $data["Seller_paid_balance"] = 0;
      $data["Cust_prepayment_balance"] = 0;

      $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $Customer_enroll_id);
      if ($Get_Record != NULL) {
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
      }
      /*       * ******************************************************************** */

      if ($status == 2) {//Complete

        /*         * **********************Update Bill No.******************* */
        $top_db = $Purchase_Bill_no;
        $len = strlen($top_db);
        $str = substr($top_db, 0, 5);
        $tp_bill = substr($top_db, 5, $len);

        $Purchase_Bill_no = $tp_bill + 1;
        $Purchase_Bill_no_withyear_ref = $str . $Purchase_Bill_no;

        $result7 = $this->Coal_Transactions_model->update_purchase_billno($seller_id, $Purchase_Bill_no_withyear_ref);
        /*         * ***************************************** */
        $Item_sales_tax = $Sales_tax;

        /*         * ****************************Insert transaction***************************** */
        $insert_data = array(
            'Company_id' => $Company_id,
            'Trans_type' => $Trans_type,
            'Redeem_points' => $Redeem_points,
            'Purchase_amount' => $Purchase_amount,
            'Item_sales_tax' => $Item_sales_tax,
            'Quantity' => $QTY,
            'Trans_date' => $lv_date_time,
            'Create_user_id' => $data['enroll'],
            'Seller' => $data['enroll'],
            'Seller_name' => $Seller_name,
            'Enrollement_id' => $Customer_enroll_id,
            'Card_id' => $Card_id,
            'Item_code' => $Company_merchandize_item_code,
            'Merchandize_Partner_id' => $Partner_id,
            'Remarks' => 'Schedule Order',
            'Merchandize_Partner_branch' => $Branch_code,
            'Bill_no' => $tp_bill
        );
        $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
        /*         * **************************************************************************** */

        if ($Trans_type == 2) {//Purchase
          $lv_Cust_seller_balance = $data["Cust_seller_balance"];
          $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"] - $Grand_total);
          $lv_Cust_block_amt = ($data["Cust_block_amt"] - $Grand_total);
          $lv_Cust_block_points = ($data["Cust_block_points"]);
          $curr_bal = ($card_bal);
          $reddem_amount = $reddem_amt;
          $purchase_amt = ($purchase_amt + $Grand_total);
          $lv_Seller_total_purchase = ($data["Seller_total_purchase"] + $Grand_total);
          $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);
        } else {
          $lv_Cust_seller_balance = ($data["Cust_seller_balance"] - $Grand_total);
          $lv_Cust_block_points = ($data["Cust_block_points"] - $Grand_total);
          $lv_Cust_block_amt = ($data["Cust_block_amt"]);
          $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
          $curr_bal = ($card_bal - $Grand_total);
          $reddem_amount = ($reddem_amt + $Grand_total);
          $purchase_amt = $purchase_amt;
          $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
          $lv_Seller_total_redeem = ($data["Seller_total_redeem"] + $Grand_total);
        }



        $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
        $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
        $lv_Seller_total_topup = ($data["Seller_total_topup"]);
        $Cust_debit_points = ($data["Cust_debit_points"]);

        /*         * ***********Update customer merchant balance************************ */
        $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $Cust_debit_points);
        /*         * ************************************************** */


        /*         * ***************Update Customer balance****************** */
        $result2 = $this->Coal_Transactions_model->update_customer_balance($Card_id, $curr_bal, $Company_id, $topup, $Todays_date, $purchase_amt, $reddem_amount);


        if ($Communication_flag == 0) {
          $this->session->set_flashdata("success_code", "Transaction done successfully !!!");
          redirect('Coal_Transactionc/Preorder_item_list');
        }

        /*         * ****************************Send Notification**************************** */
        $Email_content = array(
            'Notification_type' => 'Place_order',
            'Template_type' => 'Place_order',
            'Todays_date' => $lv_date_time,
            'banner_image' => $banner_image,
            'Full_name' => $Full_name,
            'Trans_Type' => $Trans_Type_name,
            'Transaction' => $Transaction,
            'Sub_total' => $Sub_Total,
            'Tax_Grand_total' => $Grand_total,
            'Sales_tax' => $Sales_tax,
            'Merchandize_item_name' => $Merchandize_item_name,
            'Cust_seller_balance' => $lv_Cust_seller_balance,
            'Cust_prepayment_balance' => $lv_Cust_prepayment_balance,
            'Symbol' => $Symbol,
            'QTY' => $QTY,
            'Seller_name' => $Seller_name
        );

        $Notification = $this->send_notification->Coal_send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
        /*         * **************************************************************************** */
      } else {
        $lv_Cust_seller_balance = $data["Cust_seller_balance"];
        $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
        $reddem_amount = $reddem_amt;
        $purchase_amt = ($purchase_amt);
        $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
        $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);

        if ($Trans_type == 2) {//Purchase
          $lv_Cust_block_amt = ($data["Cust_block_amt"] - $Grand_total);
          $lv_Cust_block_points = ($data["Cust_block_points"]);
        } else {
          $lv_Cust_block_points = ($data["Cust_block_points"] - $Grand_total);
          $lv_Cust_block_amt = ($data["Cust_block_amt"]);
        }



        $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
        $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
        $lv_Seller_total_topup = ($data["Seller_total_topup"]);
        $Cust_debit_points = ($data["Cust_debit_points"]);

        /*         * ***********Update customer merchant balance************************ */
        $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $Cust_debit_points);
        /*         * ************************************************** */
      }
      $this->session->set_flashdata("success_code", "Transaction done successfully !!!");
      redirect('Coal_Transactionc/Preorder_item_list');
    }

    public function get_Seller_Redemptionratio() {
      $Seller_id = $this->input->post("Seller_id");
      $seller_details = $this->Igain_model->get_enrollment_details($Seller_id);
      $Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('Seller_Redemptionratio' => $Seller_Redemptionratio)));
    }

    public function Search_merchandize_item_name() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $CompanyID = $this->input->post("Company_id");
        $Logged_user_enroll = $session_data['enroll'];
        $Logged_user_id = $session_data['userId'];
        $Item_name = $this->input->post("Item_name");
        $data["Symbol_currency"] = $this->input->post("Symbol_currency");
        $data["Merchant_sales_tax"] = $this->input->post("Merchant_sales_tax");
        $Tier_id = $this->input->post("Tier_id");

        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        if ($Sub_seller_admin == 1) {
          $Logged_user_enroll = $Logged_user_enroll;
        } else {
          $Logged_user_enroll = $Sub_seller_Enrollement_id;
        }

        $data['Redemption_Items2'] = $this->Coal_Transactions_model->Search_merchandize_item_name($Item_name, $CompanyID, $Logged_user_enroll, $Tier_id);
        if (isset($_SESSION["Redemption_Items"])) {
          unset($_SESSION["Redemption_Items"]);
        }
        $this->session->set_userdata('Redemption_Items', $data['Redemption_Items2']);
        $session_data3 = $this->session->userdata('Redemption_Items');
        // print_r($_SESSION["Redemption_Items"]);
        //echo "Redemption_Items ".count($_SESSION["Redemption_Items"]);
        $this->load->view('Coal_transactions/Coal_show_search_item_details', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * *********************************Akshay Start ******************************************** */

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

        $company_details = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;

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
        $config["base_url"] = base_url() . "/index.php/Coal_Transactionc/issue_bonus";
        $total_row = $this->Coal_Transactions_model->issue_bonus_trans_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
          $data["results"] = $this->Coal_Transactions_model->issue_bonus_trans_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('Coal_transactions/Coal_issue_bonus', $data);
        } else {
          // $this->output->enable_profiler(TRUE);								
          $categoryexist = $this->Coal_Transactions_model->check_seller_item_category($data['Company_id'], $data['enroll']);

          if ($categoryexist > 0) {
            $cardis = $this->input->post("cardId");
            if (substr($cardis, 0, 1) == "%") {
              $get_card = substr($cardis, 2); //*******read card id from magnetic card***********///
            } else {
              $get_card = substr($cardis, 0, 16); //*******read card id from other magnetic card***********///
            }


            $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
            $phnumber = $dial_code . $this->input->post("cardId");

            $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
              $user_activated = $rowis['User_activated'];
              $Phone_no = $rowis['Phone_no'];
            }

            if ($user_activated == 0) {
              $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
              redirect(current_url());
            }

            if (strlen($cardis) != '0') {
              if ($cardis != '0') {
                if ($cardId == $cardis || $Phone_no == $phnumber) {
                  $cust_details = $this->Coal_Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                  foreach ($cust_details as $row25) {
                    $fname = $row25['First_name'];
                    $midlename = $row25['Middle_name'];
                    $lname = $row25['Last_name'];
                    $bdate = $row25['Date_of_birth'];
                    $address = $row25['Current_address'];
                    $bal = $row25['Current_balance'];
                    $phno = $row25['Phone_no'];
                    $Blocked_points = $row25['Blocked_points'];
                    $companyid = $row25['Company_id'];
                    $cust_enrollment_id = $row25['Enrollement_id'];
                    $image_path = $row25['Photograph'];
                    $filename_get1 = $image_path;
                    $pinno = $row25['pinno'];
                    $Tier_name = $row25['Tier_name'];
					 $Card_id = $rowis['Card_id'];
                  }

                  $tp_count = $this->Coal_Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                  $purchase_count = $this->Coal_Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                  $gainedpts_atseller = $this->Coal_Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                  if ($gainedpts_atseller == NULL) {
                    $gainedpts_atseller = 0;
                  }

                  $data['get_card'] = $get_card;
                  $data['Cust_enrollment_id'] = $cust_enrollment_id;
                  $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                  $data['Phone_no'] = $phno;
                  /* $data['Current_balance'] = ($bal-$Blocked_points);
                    $data['Current_balance'] = $bal; */
                  $data['Topup_count'] = $tp_count;
                  $data['Purchase_count'] = $purchase_count;
                  $data['Gained_points'] = $gainedpts_atseller;
                  $data['Photograph'] = $filename_get1;
                  $data['Customer_pin'] = $pinno;
                  $data['Tier_name'] = $Tier_name;
                  $data['MembershipID'] = $Card_id;
                  /*                   * ***********Get Customer merchant balance**************** */
                  $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Logged_user_enrollid, $cust_enrollment_id);
                  // $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($data['enroll'],$cust_enrollment_id);	
                  $data["Current_balance"] = 0;
                  if ($Get_Record != NULL) {
                    foreach ($Get_Record as $val) {
                      $data["Current_balance"] = ($val["Cust_seller_balance"] - ($val["Cust_block_points"] + $val["Cust_debit_points"]));
                    }
                  }
                  /*                   * ******************************************************************** */
                  $this->load->view('Coal_transactions/Coal_issue_bonus_transaction', $data);
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
            // $this->load->view('Coal_transactions/issue_bonus_transaction', $data);
          } else {
            $this->session->set_flashdata("error_code", "The Merchant has not been Assigned a Category yet!! Please contact the Program Admin to set it to Enable TOPUP");
            redirect(current_url());
          }
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

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Sub_seller_admin;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }


        if ($_POST == NULL) {
          $this->session->set_flashdata("error_code", "Sorry, Issue Bonus Transaction Failed. Invalid Data Provided!!");
          redirect('Coal_transactions/Coal_issue_bonus');
        } else {
          if ($this->input->post("topup_amt") == "" || $this->input->post("topup_amt") <= 0 || $this->input->post("topup_amt") == " ") {
            $this->session->set_flashdata("error_code", "Sorry, Issue Bonus Transaction Failed. Please Enter Valis Bonus Points...!!!");
            redirect('Coal_Transactionc/Coal_issue_bonus');
          } else {
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

            $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($data['Company_id'], $this->input->post("cardId"), $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
            }

            if ($data['userId'] == 3) {
              $top_seller = $this->Coal_Transactions_model->get_top_seller($data['Company_id']);
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
            }
            if ($Sub_seller_admin == 1) {
              $seller_id = $seller_id;
            } else {
              $seller_id = $Sub_seller_Enrollement_id;
            }

            $cust_details = $this->Coal_Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
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

            $post_data = array(
                'Trans_type' => '1',
                'Company_id' => $data['Company_id'],
                'Topup_amount' => $this->input->post("topup_amt"),
                'Trans_date' => $lv_date_time,
                'Remarks' => $this->input->post('remark'),
                'Card_id' => $cardId,
                'Seller_name' => $Seller_name,
                // 'Seller' => $seller_id,
                'Seller' => $data['enroll'],
                'Create_user_id' => $data['enroll'],
                'Enrollement_id' => $enroll_id,
                'Bill_no' => $bill,
                'Manual_billno' => $this->input->post('manual_bill_no'),
                'remark2' => $remark_by,
                'Loyalty_pts' => ''
            );
            $result = $this->Coal_Transactions_model->insert_topup_details($post_data);

            $curr_bal = $card_bal;
            /*             * *******New table entry*****17-08-2016*AMIT******************************************** */
            $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $enroll_id);
            //echo "<br><br>Record_available ".$Record_available;
            if ($Record_available == 0) {
              $post_data2 = array(
                  'Company_id' => $Company_id,
                  'Seller_total_purchase' => 0,
                  'Update_date' => $lv_date_time,
                  'Seller_id' => $seller_id,
                  'Cust_enroll_id' => $enroll_id,
                  'Cust_seller_balance' => $this->input->post("topup_amt"),
                  'Seller_paid_balance' => 0,
                  'Seller_total_redeem' => 0,
                  'Seller_total_gain_points' => $this->input->post("topup_amt"),
                  'Seller_total_topup' => $this->input->post("topup_amt")
              );
              $lv_Cust_seller_balance = $this->input->post("topup_amt");
              $result2 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data2);
            } else {
              /*               * ***********Get Customer merchant balance**************** */
              $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $enroll_id);

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
              /*               * ******************************************************************** */
              $lv_Cust_seller_balance = ($data["Cust_seller_balance"] + $this->input->post("topup_amt"));
              $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
              $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);
              $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
              $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
              $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
              $lv_Seller_total_topup = ($data["Seller_total_topup"] + $this->input->post("topup_amt"));
              $lv_Cust_block_amt = ($data["Cust_block_amt"]);
              $lv_Cust_block_points = ($data["Cust_block_points"]);
              $Cust_debit_points = ($data["Cust_debit_points"]);
              /*               * ***********Update customer merchant balance************************ */
              $result2 = $this->Coal_Transactions_model->update_cust_merchant_trans($enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $Cust_debit_points);
              /*               * ************************************************** */
            }
            /*             * ******************************************************************** */
            $topup_amt = $topup + $this->input->post("topup_amt");
            $purchase_amount = $purchase_amt;
            $reddem_amount = $reddem_amt;


            //$result2 = $this->Coal_Transactions_model->update_customer_balance($cardId,$curr_bal,$data['Company_id'],$topup_amt,$Todays_date,$purchase_amount,$reddem_amount);

            $billno_withyear = $str . $bill_no;
            $company_details2 = $this->Igain_model->get_company_details($data['Company_id']);
            $Sms_enabled = $company_details2->Sms_enabled;
            $Seller_topup_access = $company_details2->Seller_topup_access;

            if ($Sms_enabled == '1') {
              /*               * *******************************Send SMS Code****************************** */
            }

            if ($Seller_topup_access == '1') {
              $Total_seller_bal = $seller_curbal - $this->input->post("topup_amt");
              $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

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

            // $result4 = $this->Coal_Transactions_model->update_topup_billno($seller_id,$billno_withyear);
            $result4 = $this->Coal_Transactions_model->update_topup_billno($data['enroll'], $billno_withyear);

            $Email_content = array(
                'Todays_date' => $lv_date_time,
                'topup_amt' => $this->input->post("topup_amt"),
                'manual_bill_no' => $this->input->post("manual_bill_no"),
                'Notification_type' => 'Bonus ' . $data['Company_details']->Currency_name,
                'Coalition_curr_bal' => $curr_bal,
                'Cust_seller_balance' => $lv_Cust_seller_balance,
                'Template_type' => 'Issue_bonus'
            );
            $this->send_notification->Coal_send_Notification_email($enroll_id, $Email_content, $seller_id, $data['Company_id']);

            if (($result == true) && ($result2 == true) && ($result4 == true)) {
              $this->session->set_flashdata("success_code", "Bonus Topup Transaction done Successfully!!");
            } else {
              $this->session->set_flashdata("error_code", "Sorry, Issue Bonus Transaction Failed!!");
            }
            redirect('Coal_Transactionc/issue_bonus');
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
        $data['transaction_details'] = $this->Coal_Transactions_model->get_transaction_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));

        $data['transaction_sum_details'] = $this->Coal_Transactions_model->get_transaction_sum_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));
        //var_dump($data['Sub_sellers']);
      } else {
        $Sub_Seller_id[] = $Sub_seller_Enrollment_id;
        $data['Sub_sellers'] = $this->Igain_model->Get_sub_seller($Sub_seller_Enrollment_id);
        if ($data['Sub_sellers'] != NULL) {
          foreach ($data['Sub_sellers'] as $Sub_sellers) {
            $Sub_Seller_id[] = $Sub_sellers->Enrollement_id;
          }
        }
        $data['transaction_details'] = $this->Coal_Transactions_model->get_transaction_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));

        $data['transaction_sum_details'] = $this->Coal_Transactions_model->get_transaction_sum_details($Sub_Seller_id, $this->input->post("Enrollment_id"), $this->input->post("Membership_id"));
      }


      $theHTMLResponse = $this->load->view('Coal_transactions/Coal_show_transaction_details', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionDetailHtml' => $theHTMLResponse)));
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

      $address = $seller_details->Current_address;
      $timezone12 = $seller_details->timezone_entry;
      $Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;

      $data["Company_details"] = $this->Igain_model->get_company_details($seller_details->Company_id);

      $company_details = $this->Igain_model->get_company_details($seller_details->Company_id);
      $compname = $company_details->Company_name;
      $data['Coalition'] = $company_details->Coalition;
      $Comp_redemptionratio = $company_details->Redemptionratio;

      //echo "---compname--".$compname."--<br>";
      $currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
      $Symbol_currency = $currency_details->Symbol_of_currency;

      if ($Seller_Redemptionratio != NULL) {
        $redemptionratio = $Seller_Redemptionratio;
      } else {
        $redemptionratio = $Comp_redemptionratio;
      }


      $transaction_details = $this->Coal_Transactions_model->get_bills_info($Bill_no, $transtype, $Seller_id);

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
          $data['balance_to_pay'] = $transaction['balance_to_pay'];
          $data['Payment_description'] = $transaction['Payment_description'];
          /*           * **********amit 16-09-2016***** */
          $data['Payment_type_id'] = $transaction['Payment_type_id'];
          $data['Bank_name'] = $transaction['Bank_name'];
          $data['Branch_name'] = $transaction['Branch_name'];
          $data['Credit_Cheque_number'] = $transaction['Credit_Cheque_number'];
          $data['Voucher_no'] = $transaction['Voucher_no'];
          /*           * *********** */
          $data['Loyalty_pts'] = $transaction['Loyalty_pts'];
          $data['Coalition_Loyalty_pts'] = $transaction['Coalition_Loyalty_pts'];
          $data['Loyalty_id'] = $transaction['Loyalty_id'];
          $data['GiftCardNo'] = $transaction['GiftCardNo'];
          $data['Flatfile_remarks'] = $transaction['Flatfile_remarks'];
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
            if ($redeem_info['Voucher_status'] == '31') {
              $redeem_info['Voucher_status'] = "Issued";
            } else {
              $redeem_info['Voucher_status'] = "Used";
            }
            /*             * *********Change AMIT 18-2-2017*************************** */
            if ($redeem_info['Billing_price_in_points'] == 0) {
              $lv_Billing_price_in_points = "";
            } else {
              $lv_Billing_price_in_points = " X " . $redeem_info['Redeem_points'] . " Points";
            }
            $Item_size = "<span style='font-size:10px;'>(" . $redeem_info['Item_size'] . ")</span>";
            if ($redeem_info['Item_size'] == "") {
              $Item_size = '';
            }
            if ($redeem_info === end($redeem_bill_info)) {

              $Redeemed_item .= $redeem_info['Merchandize_item_name'] . " " . $Item_size . "" . " ( Quantity : " . $redeem_info['Quantity'] . " " . $lv_Billing_price_in_points . "):" . $redeem_info['Voucher_status'];
            } else {
              $Redeemed_item .= $redeem_info['Merchandize_item_name'] . " " . $Item_size . "" . " ( Quantity : " . $redeem_info['Quantity'] . " " . $lv_Billing_price_in_points . " ):" . $redeem_info['Voucher_status'] . ", <br>";
            }
            /*             * *********Change AMIT 18-2-2017 END*************************** */
            $Total_redeem_points = $Total_redeem_points + ( $redeem_info['Redeem_points'] * $redeem_info['Quantity'] );
          }

          $data['Redeemed_item'] = $Redeemed_item;
          $data['Total_redeem_points'] = $Total_redeem_points;
          // $data['Redeemed_item'] = $Merchandize_Item_details->Merchandize_item_name;
          $data['Redeem_points'] = $redeem_amt;
          $data['Voucher_no'] = $transaction['Voucher_no'];
          $data['Voucher_status'] = $transaction['Voucher_status'];
        }

        if ($transtype == 4) {
          $data['giftcard_purchase'] = $transaction['Purchase_amount'];
          $data['Redeem_points'] = $transaction['Redeem_points'];
          $data['balance_to_pay'] = $transaction['balance_to_pay'];
          $data['GiftCardNo'] = $transaction['GiftCardNo'];
          $data['gift_pay_type'] = "Gift Card ( " . $transaction['GiftCardNo'] . " )";
          $data['Payment_description'] = $transaction['Payment_description'];
        }

        if ($enrollid == 0 && $transtype == 4) {
          $giftcard_details = $this->Coal_Transactions_model->get_giftcard_details($GiftCardNo, $seller_details->Company_id);
          foreach ($giftcard_details as $giftcard) {
            $Card_balance = $giftcard['Card_balance'];
            $name = $giftcard['User_name'];
            $Email = $giftcard['Email'];
            $Phone_no = $giftcard['Phone_no'];
            $Card_id = $giftcard['Card_id'];
          }

          $data['Cust_full_name'] = $name;
          $data['Cust_address'] = " - ";
          $data['Cust_phone_no'] = $Phone_no;
          $data['User_email_id'] = $Email;
		   $data['Cust_card_id'] = $Card_id;
          // $customer_details = $this->Coal_Transactions_model->cust_details_from_card($seller_details->Company_id,$Card_id);	//cust_details_from_giftcard
        } else {
          $customer_details = $this->Igain_model->get_enrollment_details($enrollid);
          $data['Cust_full_name'] = $customer_details->First_name . " " . $customer_details->Middle_name . " " . $customer_details->Last_name;
          $data['Cust_address'] = $customer_details->Current_address;
          $data['Cust_phone_no'] = $customer_details->Phone_no;
          $data['User_email_id'] = $customer_details->User_email_id;
          $data['Cust_card_id'] = $customer_details->Card_id;
        }

        $data['Transaction_type'] = $transtype;
        $data['Company_name'] = $compname;
        $data['Seller_name'] = $seller_name;
        $data['Seller_address'] = $address;
        $data['Bill_no'] = $Bill_no;
        $data['Payment_type_id'] = $transaction['Payment_type_id'];
        $data['Transaction_date'] = $tra_date;

        $data['Symbol_currency'] = $Symbol_currency;

        $data['Timezone'] = $timezone12;


        $timezone = new DateTimeZone($timezone12);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');

        $data['Todays_date'] = $Todays_date;
      }


      $theHTMLResponse = $this->load->view('Coal_transactions/Coal_show_transaction_receipt', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionReceiptHtml' => $theHTMLResponse)));
    }

    public function check_bill_no() {
      $result = $this->Coal_Transactions_model->check_bill_no($this->input->post("Bill_no"), $this->input->post("Company_id"));

      if ($result > 0) {
        $this->output->set_output("Already Exist");
      } else {
        $this->output->set_output("Available");
      }
    }

    public function validate_seller_pin() {
      $result20 = $this->Coal_Transactions_model->check_seller_pin($this->input->post("seller_pin"), $this->input->post("Company_id"));

      if ($result20 > 0) {
        $this->output->set_output("Available");
      } else {
        $this->output->set_output("Already Exist");
      }
    }

    /*     * *********************************Akshay END ******************************************** */


    /*     * *********************************Sandeep Work Start ******************************************** */

    function validate_card_id() {
      $result = $this->Coal_Transactions_model->check_card_id($this->input->post("cardid"), $this->input->post("Company_id"));
      if ($result != NULL) {
        // $this->output->set_output("Valid");
        echo json_encode($result);
      } else {
        // $this->output->set_output("InValid");
        $json_value = array('Card_id' => 0);
        echo json_encode($json_value);
      }
    }

    function validate_gift_card_id() {
      $result = $this->Coal_Transactions_model->check_gift_card_id($this->input->post("gift_card"), $this->input->post("Company_id"));
      if ($result > 0) {
        $this->output->set_output("InValid");
      } else {
        $this->output->set_output("Valid");
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
        $Loggedenrollid = $session_data['enroll'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        if ($Sub_seller_admin == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }


        // $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);  
        $seller_details = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
        $data['Current_balance_enroll'] = $seller_details->Current_balance;
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
        $config["base_url"] = base_url() . "/index.php/Coal_Transactionc/loyalty_transaction";
        $total_row = $this->Coal_Transactions_model->loyalty_transaction_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
          $data["results"] = $this->Coal_Transactions_model->loyalty_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('Coal_transactions/Coal_loyalty_transaction', $data);
        } else {
          // $this->output->enable_profiler(TRUE);	
          $Lp_count = $this->Administration_model->loyalty_rule_count($Company_id, $Logged_user_enrollid, $Logged_user_id);

          $categoryexist = $this->Coal_Transactions_model->check_seller_item_category($data['Company_id'], $data['enroll']);

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
              $phnumber = $dial_code . $this->input->post("cardId");
              $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
              foreach ($member_details as $rowis) {
                $cardId = $rowis['Card_id'];
                $user_activated = $rowis['User_activated'];
                $Phone_no = $rowis['Phone_no'];
              }

              if ($user_activated == 0 || $cardId == '0') {

                $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");

                redirect(current_url());
              }

              if (strlen($cardis) != 0) {
                if ($cardis != '0') {
                  if ($cardId == $cardis || $Phone_no == $phnumber) {
                    $cust_details = $this->Coal_Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                    foreach ($cust_details as $row25) {
                      $fname = $row25['First_name'];
                      $midlename = $row25['Middle_name'];
                      $lname = $row25['Last_name'];
                      $bdate = $row25['Date_of_birth'];
                      $address = $row25['Current_address'];
                      $bal = $row25['Current_balance'];
                      $Blocked_points = $row25['Blocked_points'];
                      $phno = $row25['Phone_no'];
                      $pinno = $row25['pinno'];
                      $companyid = $row25['Company_id'];
                      $cust_enrollment_id = $row25['Enrollement_id'];
                      $image_path = $row25['Photograph'];
                      $filename_get1 = $image_path;
                      $Tier_name = $row25['Tier_name'];
                      $Member_Tier_id = $row25['Tier_id'];
                    }

                    $tp_count = $this->Coal_Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                    $purchase_count = $this->Coal_Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                    $gainedpts_atseller = $this->Coal_Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $data['enroll']);
                    if ($gainedpts_atseller == NULL) {
                      $gainedpts_atseller = 0;
                    }

                    $data['get_card'] = $get_card;
                    $data['Cust_enrollment_id'] = $cust_enrollment_id;
                    $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                    $data['Phone_no'] = $phno;
                    $data['Customer_pin'] = $pinno;
                    /* $data['Current_balance'] = ($bal-$Blocked_points);
                      $data['Current_balance'] = $bal; */

                    $data['Topup_count'] = $tp_count;
                    $data['Purchase_count'] = $purchase_count;
                    $data['Gained_points'] = $gainedpts_atseller;
                    $data['Photograph'] = $filename_get1;
                    $data['Tier_name'] = $Tier_name;
                    $data['MembershipID'] = $cardId;

                    //$data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
                    $lp_array = $this->Coal_Transactions_model->get_tierbased_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, $Member_Tier_id);
                    $data['lp_array'] = $lp_array;
                    $data['referral_array'] = $this->Igain_model->get_transaction_referral_rule($Company_id, $Logged_user_enrollid, '2');

                    $Payment = $this->Igain_model->get_payement_type();
                    $data['Payment_array'] = $Payment;

                    /*                     * ***********Get Customer merchant balance**************** */
                    // $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($data['enroll'],$cust_enrollment_id);	
                    $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Logged_user_enrollid, $cust_enrollment_id);
                    $data["Current_balance"] = 0;
                    if ($Get_Record != NULL) {
                      foreach ($Get_Record as $val) {
                        $data["Current_balance"] = ($val["Cust_seller_balance"] - ($val["Cust_block_points"] + $val["Cust_debit_points"]));
                      }
                    }
                    /*                     * ******************************************************************** */
                    if ($lp_array != "") {
                      $this->load->view('Coal_transactions/Coal_loyalty_purchase_transaction', $data);
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
              // $this->load->view('Coal_transactions/loyalty_purchase_transaction', $data);
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


        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        $seller_details2 = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Seller_balance = $seller_details2->Current_balance;
        $Seller_full_name = $seller_details2->First_name . " " . $seller_details2->Last_name;
        $redemptionratio = $seller_details2->Seller_Redemptionratio;

        if ($Sub_seller_admin == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }
        /*         * **********Get Company Details************************* */
        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $Sms_enabled = $company_details2->Sms_enabled;
        $Seller_topup_access = $company_details2->Seller_topup_access;
        $Allow_negative = $company_details2->Allow_negative;
        $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
        $Pin_no_applicable = $company_details2->Pin_no_applicable;
        /*         * ******************************************************* */


        if ($_POST == NULL) {
          $this->session->set_flashdata("error_code", "Sorry, Loyalty Points Transaction Failed. Invalid Data Provided!!");
          redirect('Coal_Transactionc/Coal_loyalty_transaction');
        } else {
          //$this->output->enable_profiler(TRUE);




          if ($this->input->post("purchase_amt") == "" || $this->input->post("purchase_amt") <= 0 || $this->input->post("purchase_amt") == " " || $this->input->post("manual_bill_no") == "" || $this->input->post("manual_bill_no") == "") {
            $this->session->set_flashdata("error_code", "Sorry, Loyalty Transaction Failed. Please Enter Valid Purchase Amount..!!");
            redirect('Coal_Transactionc/loyalty_transaction');
          } else {
            $loyalty_points = 0;
            // $bal_pay = $this->input->post("pay_amt");
            $reedem_points = $this->input->post("points_redeemed");
            $redeem_amount = ($reedem_points / $redemptionratio);
            $bal_pay = ($this->input->post("purchase_amt") - $redeem_amount);
            $TotalRedeemPoints = $reedem_points;

            $TotalRedeemPoints = $reedem_points;

            $dial_code = $this->Enroll_model->get_dial_code($data['Country_id']);
            $phnumber = $dial_code . $_SESSION["cardId"];

            $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($Company_id, $_SESSION["cardId"], $phnumber);
            foreach ($member_details as $rowis) {
              $cardId = $rowis['Card_id'];
            }

            $cust_details = $this->Coal_Transactions_model->cust_details_from_card($Company_id, $cardId);
            foreach ($cust_details as $row25) {
              $card_bal = $row25['Current_balance'];
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
            }
            /*             * *****Pin No. Validation**************** */
            if ($Pin_no_applicable == 1) {
              $Enroll_details = $this->Igain_model->get_enrollment_details($Customer_enroll_id);
              $pinno = $Enroll_details->pinno;
              if ($_REQUEST["cust_pin"] != $pinno) {
                $this->session->set_flashdata("error_code", "Transaction failed due to Invalid Pin No.");
                redirect('Coal_Transactionc/loyalty_transaction');
              }
            }
            /*             * *********************** */
            $redeem_by = $this->input->post("redeem_by");
            $go_ahead = 0;
            if ($redeem_by == 1 && $reedem_points <= $card_bal) {
              $go_ahead = 1;
            } else if ($redeem_by == 1) {
              $go_ahead = 0;

              $this->session->set_flashdata("error_code", "Sorry, Loyalty Transaction Failed. Please Enter Valid Redeem Points..!!");
              redirect('Coal_Transactionc/Coal_loyalty_transaction');
            } else {
              $go_ahead = 1;
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

              if ($data['userId'] == 3) {
                $top_seller = $this->Coal_Transactions_model->get_top_seller($data['Company_id']);
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




                if ($user_details->Sub_seller_admin == 1) {
                  $remark_by = 'By SubSeller';
                } else {
                  $remark_by = 'By Seller';
                }
              }

              $Seller_category = $this->Igain_model->get_seller_category($seller_id, $Company_id);
              if ($Seller_category == 0) {
                $this->session->set_flashdata("error_code", "The Merchant has not been assigned a Category yet!! Please contact the Program Admin to set it to Enable Loyalty Transaction.!");

                redirect('Coal_Transactionc/Coal_loyalty_transaction');
              }

              $points_array = array();
              //print_r($loyalty_prog);
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



                $lp_details = $this->Coal_Transactions_model->get_loyalty_program_details($Company_id, $seller_id, $prog, $Todays_date);

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

                /*
                  echo '-----LoyaltyID_array-><br>';
                  print_r($LoyaltyID_array);
                  echo '-----value-><br>';
                  print_r($value);
                  echo '-----discount-><br>';
                  print_r($dis);
                  echo '-----<br>';
                 */


                if ($lp_type == 'PA') {
                  $transaction_amt = $this->input->post("purchase_amt");
                }

                if ($lp_type == 'BA') {
                  $transaction_amt = $bal_pay;
                }
                /*
                  echo "---loyalty member_Tier_id---".$member_Tier_id."---<br><br>";
                  echo "---loyalty lp_Tier_id---".$lp_Tier_id."---<br><br>";
                  echo "---loyalty Loyalty_at_flag---".$Loyalty_at_flag."---<br><br>";
                 */
                if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 1) {

                  for ($i = 0; $i <= count($value) - 1; $i++) {
                    //echo "---i--".$i."---<br>";

                    if ($value[$i + 1] != "") {
                      if ($transaction_amt > $value[$i] && $transaction_amt <= $value[$i + 1]) {

                        $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);
                        //echo "---loyalty_points--1-0--".$loyalty_points."---<br><br>";
                        $trans_lp_id = $LoyaltyID_array[$i];
                        $gained_points_fag = 1;

                        $points_array[] = $loyalty_points;
                      }
                    } else if ($transaction_amt > $value[$i]) {

                      $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);
                      //echo "---loyalty_points--1-1--".$loyalty_points."---<br><br>";	
                      $gained_points_fag = 1;
                      $trans_lp_id = $LoyaltyID_array[$i];

                      $points_array[] = $loyalty_points;
                    }
                  }
                }

                if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 2) {

                  $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[0]);
                  //echo "---loyalty_points--2---".$loyalty_points."---<br><br>";
                  $points_array[] = $loyalty_points;

                  $gained_points_fag = 1;
                  $trans_lp_id = $LoyaltyID_array[0];
                }

                if ($member_Tier_id == $lp_Tier_id && $loyalty_points > 0) {
                  //$points_array[] = $loyalty_points;

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
                  $child_result = $this->Coal_Transactions_model->insert_loyalty_transaction_child($child_data);
                }
              }
              //print_r($points_array); echo "<br><br>";


              if ($gained_points_fag == 1) {
                $total_loyalty_points = array_sum($points_array);
              } else {
                $total_loyalty_points = 0;
              }
              $total_loyalty_points = round($total_loyalty_points);

              //echo "---total_loyalty_points---".$total_loyalty_points."---<br><br>";die;

              /* ----------------Apply Rule for Segmanet base------------- */
              /* ----------------Get Seller segment based Rule------------ */
              $Get_segment_rule = $this->Transactions_model->get_segment_seller_rule($Company_id, $Logged_user_enrollid, $Logged_user_id, $Todays_date);
              
              // echo "---Get_segment_rule---".print_r($Get_segment_rule)."---<br><br>";
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

                  // echo "---Segment_flag---".$Segment_flag."---<br><br>";

                  if ($Segment_flag == 1) {

                    $Get_segments2 = $this->Segment_model->edit_segment_id($Company_id, $Segment_code);

                    $Customer_array = array();
                    $Applicable_array[] = 0;
                    unset($Applicable_array);
                    // print_r($Get_segments2 );
                    foreach ($Get_segments2 as $Get_segments) {


                      // echo "---Segment_type_id---".$Get_segments->Segment_type_id."---<br><br>";

                      /* -----------------Age--------------- */
                      if ($Get_segments->Segment_type_id == 1) {
                        $lv_Cust_value = date_diff(date_create($Date_of_birth), date_create('today'))->y;
                      }
                      /* -----------------Sex--------------- */
                      if ($Get_segments->Segment_type_id == 2) {
                        $lv_Cust_value = $Sex;
                        // echo "----Sex---".$lv_Cust_value."---<br>";
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

                      // echo "---lv_Cust_value---".$lv_Cust_value."---<br><br>";
                      $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                      $Applicable_array[] = $Get_segments;
                    }

                    $gained_points_fag1 = 0;

                    // echo "---Applicable_array---".Print_r($Applicable_array)."---<br><br>";
                    if (!in_array(0, $Applicable_array, true)) {

                      // echo "-------<br>";
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

                  // echo "---gained_points_fag1---".$gained_points_fag1."---<br><br>";
                  if ($gained_points_fag1 == 1) {
                    $total_loyalty_points1 = array_sum($points_array1);
                  } else {
                    $total_loyalty_points1 = 0;
                  }
                  // echo "---total_loyalty_points1---".$total_loyalty_points1."---<br><br>";

                  unset($trans_lp_id);
                }
              } else {
                $total_loyalty_points1 = 0;
              }

              // echo "--total_loyalty_points---before---".$total_loyalty_points."--<br><br>";

              /* ----------------Get Seller segment based Rule--------------------------- */

              $total_loyalty_points = $total_loyalty_points + $total_loyalty_points1;

              /* ----------------Apply Rule for Segmanet base-13-08-2018--------------- */
              // echo "--total_loyalty_points---after---".$total_loyalty_points."--<br><br>";








              $Promo_redeem_by = $this->input->post("Promo_redeem_by");

              $tp_db = $Purchase_Bill_no;
              $len = strlen($tp_db);
              $str = substr($tp_db, 0, 5);
              $bill = substr($tp_db, 5, $len);

              if ($Promo_redeem_by == 1) { //******** Promo Code Redeem *********/

                $PromoCode = $this->input->post('Promo_code');
                $PointsRedeem = $_SESSION["promo_points"];

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

                $insert_promo_transaction_id = $this->Coal_Transactions_model->insert_loyalty_transaction($promo_transaction_data);

                $post_data21 = array('Promo_code_status' => '1');

                $update_promo_code = $this->Coal_Transactions_model->utilize_promo_code($Company_id, $PromoCode, $post_data21);

                $TotalRedeemPoints = $TotalRedeemPoints + $PointsRedeem;

                $bill = $bill + 1;
              }

              $Gift_redeem_by = $this->input->post("Gift_redeem_by");
              $gift_reedem = 0;
              $GiftCardNo = 0;
              if ($Gift_redeem_by == 1) { //******** Gift Card Redeem *********/

                $gift_reedem = $this->input->post('gift_points_redeemed');

                $GiftCardNo = $this->input->post('GiftCardNo');
                $GiftBal = $this->input->post('Balance');
                $current_gift_balance = $GiftBal - $gift_reedem;


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

                $insert_gift_transaction = $this->Coal_Transactions_model->insert_loyalty_transaction($gift_transaction_data);


                $result32 = $this->Coal_Transactions_model->update_giftcard_balance($GiftCardNo, $current_gift_balance, $Company_id);

                $TotalRedeemPoints = $TotalRedeemPoints + $gift_reedem;

                $bill = $bill + 1;
              }

              $bill_no = $bill + 1;

              //echo "--total_loyalty_points--".$total_loyalty_points."--<br><br>";

              $lv_Coalition_Loyalty_pts = round(($total_loyalty_points * $Coalition_points_percentage) / 100);


              //echo "--lv_Coalition_Loyalty_pts--".$lv_Coalition_Loyalty_pts."--<br><br>";


              if ($this->input->post('Promo_code') != "") {
                $Promo_code = "Promo Code-(" . $this->input->post('Promo_code') . ")";
              } else {
                $Promo_code = "";
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
                  'Coalition_Loyalty_pts' => $lv_Coalition_Loyalty_pts,
                  'Paid_amount' => $bal_pay,
                  'Redeem_points' => $this->input->post("points_redeemed"),
                  'Payment_type_id' => $this->input->post("Payment_type"),
                  'balance_to_pay' => $bal_pay,
                  'Bank_name' => $this->input->post("Bank_name"),
                  'Branch_name' => $this->input->post("Branch_name"),
                  'Credit_Cheque_number' => $this->input->post("Credit_Cheque_number"),
                  'purchase_category' => $Seller_category,
                  'Source' => 0,
                  'GiftCardNo' => $this->input->post('GiftCardNo'),
                  'Voucher_no' => $Promo_code,
                  'Create_user_id' => $data['enroll']
              );

              //print_r($post_data); die;
              $insert_transaction_id = $this->Coal_Transactions_model->insert_loyalty_transaction($post_data);

              $result = $this->Coal_Transactions_model->update_loyalty_transaction_child($Company_id, $lv_date_time, $data['enroll'], $Customer_enroll_id, $insert_transaction_id);

              $curr_bal = $card_bal + $lv_Coalition_Loyalty_pts;

              $transaction_redeem_points = $this->input->post("points_redeemed");

              //$curr_bal = $curr_bal - $transaction_redeem_points;

              $topup_amt = $topup;

              $transaction_purchase_amt = $this->input->post("purchase_amt");

              $purchase_amount = $purchase_amt; // + $transaction_purchase_amt;

              $transaction_redeem_amt = $this->input->post("redeem_amt");


              // $Total_redeem_points = $reddem_amt + $transaction_redeem_points;	
              $Total_redeem_points = $reddem_amt;

              /*               * *******New table entry*****17-08-2016*AMIT******************************************** */
              // $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id,$data['enroll'],$Customer_enroll_id);	
              $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $Customer_enroll_id);
              // echo "<br><br>Record_available ".$Record_available;
              if ($Record_available == 0) {
                $post_data2 = array(
                    'Company_id' => $Company_id,
                    'Seller_total_purchase' => $this->input->post("purchase_amt"),
                    'Update_date' => $lv_date_time,
                    'Seller_id' => $seller_id,
                    'Cust_enroll_id' => $Customer_enroll_id,
                    'Cust_seller_balance' => $total_loyalty_points,
                    'Seller_paid_balance' => $bal_pay,
                    'Seller_total_redeem' => $this->input->post("points_redeemed"),
                    'Seller_total_gain_points' => $total_loyalty_points,
                    'Seller_total_topup' => 0
                );
                $lv_Cust_seller_balance = $total_loyalty_points;
                $result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data2);
              } else {
                /*                 * ***********Get Customer merchant balance**************** */
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

                /*                 * ******************************************************************** */
                $lv_Cust_seller_balance = ($data["Cust_seller_balance"] + $total_loyalty_points - $this->input->post("points_redeemed"));
                $lv_Seller_total_purchase = ($data["Seller_total_purchase"] + $this->input->post("purchase_amt"));
                $lv_Seller_total_redeem = ($data["Seller_total_redeem"] + $this->input->post("points_redeemed"));
                $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"] + $total_loyalty_points);
                $lv_Seller_paid_balance = ($data["Seller_paid_balance"] + $bal_pay);
                $lv_Seller_total_topup = ($data["Seller_total_topup"] + 0);
                $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"] - $this->input->post("purchase_amt"));
                $lv_Cust_block_amt = ($data["Cust_block_amt"]);
                $lv_Cust_block_points = ($data["Cust_block_points"]);
                $Cust_debit_points = ($data["Cust_debit_points"]);
                /*                 * ***********Update customer merchant balance************************ */
                $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $Cust_debit_points);
                /*                 * ************************************************** */
              }
              // die;	


              /*

                $Update_debit=round($Debit_points+$Debit_Coalition_Loyalty_pts-$Debit_redeem_pts);

                $reddem_amount=$reddem_amt+$Debit_redeem_pts;
                $new_purchase_amount=$total_purchase_amt-$Cancelle_amt;
                $Curent_balance=round($card_bal-$Debit_Coalition_Loyalty_pts);
                $Topup_amt=$topup;
                $Blocked_points=$Blocked_points;
                $CustomerData = array(
                'Current_balance' => $Curent_balance,
                'total_purchase' => $new_purchase_amount,
                'Total_topup_amt' => $Topup_amt,
                'Total_reddems' => $reddem_amount,
                'Blocked_points' => $Blocked_points,
                'Debit_points' => $Update_debit
                );

                $result2 = $this->Transactions_model->update_customer_debit($Customer_enroll_id,$Card_id,$Company_id,$CustomerData);

               */

              $result2 = $this->Coal_Transactions_model->update_customer_balance($cardId, $curr_bal, $Company_id, $topup_amt, $lv_date_time, $purchase_amount, $Total_redeem_points);
              /*               * **************************************************************** */
              $billno_withyear = $str . $bill_no;


              //$referre_setup = $this->input->post("referre_setup");
              //$this->input->post("referre_membershipID");
              //	echo "--referee enroll---".$Refree_enroll_id."--<br><br>";
              $total_ref_topup = 0;
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
                $Ref_rule = $this->Coal_Transactions_model->select_seller_refrencerule($seller_id, $Company_id, $Referral_rule_for);
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

                // echo "--referee member total_ref_topup---".$total_ref_topup."--<br><br>";
                // echo "--Seller_Refrence---".$Seller_Refrence."--<br><br>";
                //die;
                if ($total_ref_topup > 0) { //$Seller_Refrence == 1 && 

                  $refree_current_balnce = $ref_card_bal + $total_ref_topup;
                  $refree_topup = $ref_topup_amt + $total_ref_topup;

                  //$result5 = $this->Coal_Transactions_model->update_customer_balance($referre_membershipID,$refree_current_balnce,$Company_id,$refree_topup,$Todays_date,$ref_purchase_amt,$ref_reddem_amt);







                  /* -------------------------28-01-2019---------------------------------------------------- */

                  $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $ref_Customer_enroll_id);
                  // echo "<br><br>Record_available ".$Record_available;
                  if ($Record_available == 0) {
                    $post_refree_data2 = array(
                        'Company_id' => $Company_id,
                        'Seller_total_purchase' => 0,
                        'Update_date' => $lv_date_time,
                        'Seller_id' => $seller_id,
                        'Cust_enroll_id' => $ref_Customer_enroll_id,
                        'Cust_seller_balance' => $refree_topup,
                        'Seller_paid_balance' => 0,
                        'Seller_total_redeem' => 0,
                        'Seller_total_gain_points' => 0,
                        'Seller_total_topup' => $refree_topup
                    );
                    $result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_refree_data2);
                  } else {
                    /*                     * ***********Get Customer merchant balance**************** */
                    $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $ref_Customer_enroll_id);

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
                    $lv_Cust_seller_balance = ($data["Cust_seller_balance"] + $refree_topup);
                    $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
                    $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);
                    $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
                    $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
                    $lv_Seller_total_topup = ($data["Seller_total_topup"] + $refree_topup);
                    $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
                    $lv_Cust_block_amt = ($data["Cust_block_amt"]);
                    $lv_Cust_block_points = ($data["Cust_block_points"]);
                    $Cust_debit_points = ($data["Cust_debit_points"]);
                    /*                     * ***********Update customer merchant balance************************ */
                    $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($ref_Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $Cust_debit_points);
                    /*                     * ************************************************** */
                  }


                  /* -------------------------28-01-2019---------------------------------------------------- */


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
                      'Enrollement_id' => $ref_Customer_enroll_id,
                      'Bill_no' => $tp_bill,
                      'Manual_billno' => $manual_bill_no,
                      'remark2' => $remark_by,
                      'Loyalty_pts' => '0'
                  );

                  $result6 = $this->Coal_Transactions_model->insert_topup_details($post_Transdata);

                  $result7 = $this->Coal_Transactions_model->update_topup_billno($seller_id, $billno_withyear_ref);

                  //$Todays_date = date("Y-m-d");

                  $Email_content12 = array(
                      'Ref_Topup_amount' => $total_ref_topup,
                      'Notification_type' => 'Referral Topup',
                      'Template_type' => 'Referral_topup',
                      'Customer_name' => $customer_name,
                      'Todays_date' => $lv_date_time
                  );

                  $this->send_notification->send_Notification_email($ref_Customer_enroll_id, $Email_content12, $Logged_user_enrollid, $Company_id);
                }
              }
              if ($Seller_topup_access == '1') {

                

                $Total_seller_bal = ($Seller_balance - $total_loyalty_points) - $total_ref_topup;
                $Total_seller_bal = $Total_seller_bal + $reedem_points;



                $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);
                
                
                $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                $Seller_balance = $seller_details2->Current_balance;

                /*                 * *******************Send Threshold Mail*************** */
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
                /*                 * *******************Send Threshold Mail*************** */
              }

              if ($Sub_seller_admin == 1) { //for Merchant Admin
                $result4 = $this->Coal_Transactions_model->update_billno($seller_id, $billno_withyear);
              } else { //for Merchant Admin Employee
                $result4 = $this->Coal_Transactions_model->update_billno($data['enroll'], $billno_withyear);
              }


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
                  'Manual_billno' => $manual_bill_no,
                  'Purchase_amount' => $purchase_amt,
                  'Redeem_points' => $reedem,
                  'Payment_by' => $payment_by,
                  'Balance_to_pay' => $balance_to_pay,
                  'Total_loyalty_points' => $total_loyalty_points,
                  'Symbol_currency' => $Symbol_currency,
                  'GiftCardNo' => $GiftCardNo,
                  'gift_reedem' => $gift_reedem,
                  'Coalition_Loyalty_pts' => $lv_Coalition_Loyalty_pts,
                  'Coalition_curr_bal' => $curr_bal,
                  'Cust_seller_balance' => $lv_Cust_seller_balance,
                  'Merchant_name' => $Seller_name,
                  'Notification_type' => $Notification_type,
                  'Template_type' => 'Coalition_loyalty_transaction');
              // var_dump($Email_content);
              $this->send_notification->Coal_send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);


              if (($insert_transaction_id > 0) && ($result2 == true) && ($result4 == true)) {

                /*                 * *******************igain Log Table change 15-11-2017************************ */
                $opration = 1;
                $From_enrollid = $session_data['enroll'];
                $userid = $session_data['userId'];
                $what = "Coal Purchase Transaction";
                $where = "Perform Transaction(c)";
                $toname = $customer_name;
                $toenrollid = $Customer_enroll_id;
                $opval = $customer_name . ', Purchase Amount:' . $this->input->post("purchase_amt");
                $Todays_date = date("Y-m-d");
                $firstName = $customer_name;
                $lastName = '';
                $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $From_enrollid, $session_data['username'], $session_data['Full_name'], $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $Customer_enroll_id);
                /*                 * ********************igain Log Table change 15-11-2017************************ */


                $this->session->set_flashdata("success_code", "Loyalty Transaction done Successfully!!");
              } else {
                $this->session->set_flashdata("error_code", "Sorry, Loyalty Transaction Failed!!");
              }
              redirect('Coal_Transactionc/loyalty_transaction');
            }
          }
        }
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

        $this->load->view('Coal_transactions/Coal_view_referre_details', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function get_loyalty_program_details() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $CompanyID = $this->input->post("Company_id");
        $Logged_user_enroll = $session_data['enroll'];
        $Logged_user_id = $session_data['userId'];
        $Loyalty_names = $this->input->post("lp_id");

        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        if ($Sub_seller_admin == 1) {
          $Logged_user_enroll = $Logged_user_enroll;
        } else {
          $Logged_user_enroll = $Sub_seller_Enrollement_id;
        }

        $data['lp_array'] = $this->Coal_Transactions_model->get_loyaltyrule_details($Loyalty_names, $CompanyID, $Logged_user_enroll, $Logged_user_id);

        //$data['lp_array'] = $ref_array;

        $this->load->view('Coal_transactions/Coal_view_loyalty_program_details', $data);
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

        $promo_points = $this->Coal_Transactions_model->get_promo_code_details($PromoCode, $CompanyID);


        if ($promo_points > 0) {
          $_SESSION["promo_points"] = $promo_points;
          $this->output->set_output($promo_points);
        } else {
          $this->output->set_output('0');
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function get_giftcard_info() {
      $result = $this->Coal_Transactions_model->get_giftcard_info($this->input->post("GiftCardNo"), $this->input->post("Company_id"));

      if ($result != NULL) {
        // $this->output->set_content_type('application/json');
        $this->output->set_output($result);
      } else {
        $this->output->set_output("0");
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
		 $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
        $company_details = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details->Threshold_Merchant;
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $seller_curbal = $data['Current_balance'];
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $data['Sub_seller_Enrollement_id'] = $seller_details->Sub_seller_Enrollement_id;
		 $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;
        $Sub_seller_Enrollement_id = $seller_details->Sub_seller_Enrollement_id;
        $data['Seller_redemption_limit'] = $seller_details->Seller_redemption_limit;


        $redemptionratio = $seller_details->Seller_Redemptionratio;

        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $data['Pin_no_applicable'] = $company_details2->Pin_no_applicable;
        $data['Seller_topup_access'] = $company_details2->Seller_topup_access;
        $data['Threshold_Merchant'] = $company_details2->Threshold_Merchant;

        if ($redemptionratio == 0 || $redemptionratio == "" || $redemptionratio == NULL) {
          $company_details = $this->Igain_model->get_company_details($data['Company_id']);

          $redemptionratio = $company_details->Redemptionratio;
        }
        $data['redemptionratio'] = $redemptionratio;

        if ($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $data['Sub_seller_Enrollement_id'];
        }
        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Coal_Transactionc/redeem";
        $total_row = $this->Coal_Transactions_model->redeem_transaction_count($Logged_user_id, $data['enroll'], $data['Company_id']);
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
          $data["results"] = $this->Coal_Transactions_model->redeem_transactions_list($config["per_page"], $page, $Logged_user_id, $data['enroll'], $data['Company_id']);
          $data["pagination"] = $this->pagination->create_links();
          $this->load->view('Coal_transactions/Coal_redeem_view', $data);
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

          $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($data['Company_id'], $get_card, $phnumber);
          foreach ($member_details as $rowis) {
            $cardId = $rowis['Card_id'];
            $user_activated = $rowis['User_activated'];
            $Phone_no = $rowis['Phone_no'];
          }

          if ($user_activated == 0) {
            $this->session->set_flashdata("error_code", "Sorry, Cannot proceed with the Transaction!! Membership ID is not Active or Registerd with us..! !");
            redirect(current_url());
          }


          if (strlen($cardis) != 0) {
            if ($cardis != '0') {
              if ($cardId == $cardis || $Phone_no == $phnumber) {
                $cust_details = $this->Coal_Transactions_model->cust_details_from_card($data['Company_id'], $cardId);
                foreach ($cust_details as $row25) {
                  $fname = $row25['First_name'];
                  $midlename = $row25['Middle_name'];
                  $lname = $row25['Last_name'];
                  $bdate = $row25['Date_of_birth'];
                  $address = $row25['Current_address'];
                  $bal = $row25['Current_balance'];
                  $Blocked_points = $row25['Blocked_points'];
                  $phno = $row25['Phone_no'];
                  $companyid = $row25['Company_id'];
                  $cust_enrollment_id = $row25['Enrollement_id'];
                  $image_path = $row25['Photograph'];
                  $filename_get1 = $image_path;
                  $Cust_Current_balance = $row25['Current_balance'];
                  $pinno = $row25['pinno'];
                  $Cust_Tier_id = $row25['Tier_id'];
                  $MembershipID = $row25['Card_id'];
                }

                $tp_count = $this->Coal_Transactions_model->get_count_topup($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                $purchase_count = $this->Coal_Transactions_model->get_count_purchase($cardId, $cust_enrollment_id, $Logged_user_enrollid);
                $gainedpts_atseller = $this->Coal_Transactions_model->gained_points_atseller($cardId, $cust_enrollment_id, $data['enroll']);
                if ($gainedpts_atseller == NULL) {
                  $gainedpts_atseller = 0;
                }

                $data['get_card'] = $cardId;
                $data['Cust_enrollment_id'] = $cust_enrollment_id;
                $data['Full_name'] = $fname . " " . $midlename . " " . $lname;
                $data['Phone_no'] = $phno;
                //$data['Current_balance'] = ($bal-$Blocked_points);
                $data['Topup_count'] = $tp_count;
                $data['Purchase_count'] = $purchase_count;
                $data['Gained_points'] = $gainedpts_atseller;
                $data['Photograph'] = $filename_get1;
                $data['Customer_pin'] = $pinno;
                $data['MembershipID'] = $MembershipID;

                $Loyalty_names = "PA-ONLY REDEEM";
                /** ***********Get Customer merchant balance 19-8-2016 AMIT**************** */
                // $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($data['enroll'],$cust_enrollment_id);	
                $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($Logged_user_enrollid, $cust_enrollment_id);
				// echo "-----sql----".$this->db->last_query()."---<br>";	
                $data["Current_balance"] = 0;
                $data["Seller_total_redeem"] = 0;
                if ($Get_Record != NULL) {
                  foreach ($Get_Record as $val) {
                    $data["Current_balance"] = ($val["Cust_seller_balance"] - ($val["Cust_block_points"] + $val["Cust_debit_points"]));
                    $data["Seller_total_purchase"] = $val["Seller_total_purchase"];
                    $data["Seller_total_redeem"] = $val["Seller_total_redeem"];
                    $data["Seller_total_gain_points"] = $val["Seller_total_gain_points"];
                    $data["Seller_total_topup"] = $val["Seller_total_topup"];
                    $data["Seller_paid_balance"] = $val["Seller_paid_balance"];
                  }
                }
				
				 // echo "-----Current_balance----".$data["Current_balance"]."---<br>";	
                /*                 * ******************************************************************** */

                // $data['loyalty_rec'] = $this->Coal_Transactions_model->get_loyalty_program_details($Company_id,$data['enroll'],$Loyalty_names,$Todays_date);
                $data['loyalty_rec'] = $this->Coal_Transactions_model->get_loyalty_program_details($Company_id, $Logged_user_enrollid, $Loyalty_names, $Todays_date);
                //var_dump($data['loyalty_rec']);

                /*                 * ***************************DISCOUNT RULE************************************* */

                $data["Discount_Applicable"] = 0;
                // $Discount_rule_details = $this->Coal_Transactions_model->get_merchant_discount_rule($Todays_date,$data['enroll'],$Company_id);
                $Discount_rule_details = $this->Coal_Transactions_model->get_merchant_discount_rule($Todays_date, $Logged_user_enrollid, $Company_id);

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
                    // $Discount_applicable_rule = $this->Coal_Transactions_model->get_merchant_applicable_discount_rule($Todays_date,$data['enroll'],$Company_id,$max_loyalty);
                    $Discount_applicable_rule = $this->Coal_Transactions_model->get_merchant_applicable_discount_rule($Todays_date, $Logged_user_enrollid, $Company_id, $max_loyalty);
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
                $this->load->view('Coal_transactions/Coal_redeem_transaction', $data);
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
          // $this->load->view('Coal_transactions/loyalty_purchase_transaction', $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function redeem_done() {
		error_reporting(0);

      if ($_POST == NULL) {
        $this->session->set_flashdata("error_code", "Sorry, Redeem Transaction Failed. Invalid Data Provided!!");
        redirect('Coal_transactions/redeem');
      } else {

		// print_r($_POST);
		
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
        $seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $data['Current_balance'] = $seller_details->Current_balance;
        $data['refrence'] = $seller_details->Refrence;
        $data['Sub_seller_admin'] = $seller_details->Sub_seller_admin;
        $redemptionratio = $seller_details->Seller_Redemptionratio;
        $Company_id = $session_data['Company_id'];

        $Sub_seller_Enrollement_id = $seller_details->Sub_seller_Enrollement_id;

        if($data['Sub_seller_admin'] == 1) {
          $Logged_user_enrollid = $Logged_user_enrollid;
        } else {
          $Logged_user_enrollid = $Sub_seller_Enrollement_id;
        }

        $logtimezone = $session_data['timezone_entry'];
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time = $date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');
        $Trans_date = $date->format('Y-m-d');

        $Company_details = $this->Igain_model->get_company_details($data['Company_id']);
        if ($data['userId'] == 3) {
          $top_seller = $this->Coal_Transactions_model->get_top_seller($data['Company_id']);
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
          $Sub_seller_admin = $user_details->Sub_seller_admin;
          $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;
          $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

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

        $member_details = $this->Coal_Transactions_model->issue_bonus_member_details($Company_id, $this->input->post("cardId"), $phnumber);
        foreach ($member_details as $rowis) {
          $cardId = $rowis['Card_id'];
        }
        $cust_details = $this->Coal_Transactions_model->cust_details_from_card($Company_id, $cardId);
        //print_r($cust_details);
        foreach ($cust_details as $row25) {
          $card_bal = $row25['Current_balance'];
          $Blocked_points = $row25['Blocked_points'];
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

        $Redeem_type = $this->input->post("Redeem_type");
        if ($Redeem_type == 1) { //Normal
		
		
          $Redeem_points = $this->input->post("Redeem_points");

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
          $lv_Total_Redeem_points = $this->input->post("Redeem_points");
          $insert_transaction_id = $this->Coal_Transactions_model->insert_loyalty_transaction($post_data);
		  
			$lv_Grand_total = $this->input->post("Redeem_points");
		  
		  
        } else {
			
			// echo"-----Merchandize--Gift---<br>";
			
			// print_r($this->input->post('RedeemItemArray'));
			$RedeemItemArray=$this->input->post('RedeemItemArray');					
			foreach($RedeemItemArray as $key => $value) {						
				$newvalue=json_decode($value,true);	
				foreach($newvalue as $val){
					
					/* echo"--Item_id-----".$val['Item_id']."<br>";
					echo"--QTY-----".$val['QTY']."<br>";
					echo"--Size_flag-----".$val['Size_flag']."<br>"; */
					
					$lv_Quantity = $val['QTY'];
					$Item_details=$this->Redemption_Model->Get_Merchandize_Item_details($val['Item_id']);
					 // print_r($Item_details);
					$Company_merchandize_item_code=$Item_details[0]->Company_merchandize_item_code;
					$lv_Redeem_points=$Item_details[0]->Billing_price_in_points;
					$Billing_price_in_points=$Item_details[0]->Billing_price_in_points;
					$Billing_price=$Item_details[0]->Billing_price;
					$Partner_id=$Item_details[0]->Partner_id;
					
					
					
					// echo"--lv_Redeem_points-----".$lv_Redeem_points."<br>";
						
					
					if ($val["Size_flag"] > 0) {
						
						$Company_merchandise_item_id = $val['Item_id'];
						$Selected_Size_flag = $val["Size_flag"];
						if($Selected_Size_flag == 1) {
						  $Item_size = "Small";
						} elseif ($Selected_Size_flag == 2) {
						  $Item_size = "Medium";
						} else {
						  $Item_size = "Large";
						}
						echo"--Item_size-----".$Item_size."<br>";
						$Get_item_size_info = $this->Coal_Transactions_model->Get_Price_Points_by_size($Selected_Size_flag, $Company_merchandize_item_code, $Company_id);

						if ($Get_item_size_info != NULL) {
						  foreach ($Get_item_size_info as $Rec) {
							$Billing_price = $Rec["Billing_price"];
							$Billing_price_in_points = $Rec["Billing_price_in_points"];
						  }
						}
					  } else {
						  
						$Item_size = "No";
						$Billing_price = $Billing_price;
						$Billing_price_in_points = $Billing_price_in_points;
					  }	
					  
					  
					  
					  
					  $lv_Quantity = $val['QTY'];
					  $lv_Redeem_points = $Billing_price_in_points;
					  $lv_Item_code = $Company_merchandize_item_code;
					  $lv_Partner_id = $Partner_id;
					  
					  
					  
					  
					  /*               * ****************Changed AMIT 16-06-2016************ */

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
					  $Voucher_status = "Used";

					  $insert_data = array(
						  'Company_id' => $Company_id,
						  'Trans_type' => 10,
						  'Redeem_points' => $lv_Redeem_points,
						  'Item_size' => $Item_size,
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
						  'Merchandize_Partner_id' => $lv_Partner_id,
						  'Remarks' => "Redeem Merchandize Gift",
						  'Merchandize_Partner_branch' => $Branch_code,
						  'Update_date' => $lv_date_time,
						  'Update_User_id' => $data['enroll'],
						  'Bill_no' => $tp_bill
					  );
					  $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
					  $Voucher_array[] = $Voucher_no;
					  
					  
					$lv_Total_Redeem_points[] = ($lv_Redeem_points * $lv_Quantity);
					
				}				
			}
		
			$lv_Grand_total = array_sum($lv_Total_Redeem_points);
			// echo"--lv_Grand_total-----".$lv_Grand_total."<br>";
			// die;
		}

        if ($Seller_topup_access == '1') {

          $Total_seller_bal = ($seller_curbal + $lv_Grand_total);
          $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

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
            $this->send_notification->Coal_send_Notification_email($Super_Seller->Enrollement_id, $Admin_Email_content, $seller_id, $Company_id);
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
            $this->send_notification->Coal_send_Notification_email($seller_id, $Seller_Email_content, $seller_id, $Company_id);
            //****mail to seller
          }
          /*           * *******************Send Threshold Mail*************** */
        }

        /*         * ******************* Update Seller Bill No.****************************************** */
        // $result7 = $this->Coal_Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
        $result7 = $this->Coal_Transactions_model->update_topup_billno($data['enroll'], $billno_withyear_ref);
        /*         * ************************************************************************************** */
        /*         * ***********Get Customer merchant balance**************** */
		
		
		$curr_bal = ($card_bal - $lv_Grand_total);

		$reddem_amount = $reddem_amt + $lv_Grand_total;
		
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
        /*         * ******************************************************************** */
        $lv_Cust_seller_balance = ($data["Cust_seller_balance"] - $lv_Grand_total);
        $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
        $lv_Seller_total_redeem = ($data["Seller_total_redeem"] + $lv_Grand_total);
        $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
        $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
        $lv_Seller_total_topup = ($data["Seller_total_topup"]);
        $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
        $lv_Cust_block_amt = ($data["Cust_block_amt"]);
        $lv_Cust_block_points = ($data["Cust_block_points"]);
        $Cust_debit_points = ($data["Cust_debit_points"]);
        /*         * ***********Update customer merchant balance************************ */
        $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date_time, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance, $lv_Cust_block_points, $lv_Cust_block_amt, $Cust_debit_points);
        /*         * ************************************************** */
        //$curr_bal = ($card_bal - $Redeem_points);//20-8-2016 changed AMIT
        $curr_bal = ($card_bal);

        // $reddem_amount = $reddem_amt + $Redeem_points;	
        $reddem_amount = $reddem_amt;

        $result2 = $this->Coal_Transactions_model->update_customer_balance($cardId, $curr_bal, $Company_id, $topup, $Todays_date, $purchase_amt, $reddem_amount);
        $Avialable_balance = ($curr_bal - $Blocked_points);
        if ($Redeem_type == 1) {//Normal
          $Email_content = array(
              'Todays_date' => $Todays_date,
              'Cust_seller_balance' => $lv_Cust_seller_balance,
              'Redeem_points' => $this->input->post("Redeem_points"),
              'Notification_type' => 'Just Redeem',
              'Template_type' => 'Coal_Redeem'
          );
          $this->send_notification->Coal_send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
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
		  
		  // $RedeemItemArray=$this->input->post('RedeemItemArray');					
			foreach($RedeemItemArray as $key => $value) {						
				$newvalue=json_decode($value,true);	
				foreach($newvalue as $val){
					
					/* echo"--Item_id-----".$val['Item_id']."<br>";
					echo"--QTY-----".$val['QTY']."<br>";
					echo"--Size_flag-----".$val['Size_flag']."<br>"; */
					
					$lv_Quantity = $val['QTY'];
					$Item_details=$this->Redemption_Model->Get_Merchandize_Item_details($val['Item_id']);
					 // print_r($Item_details);
					$Company_merchandize_item_code=$Item_details[0]->Company_merchandize_item_code;
					$lv_Redeem_points=$Item_details[0]->Billing_price_in_points;
					$Billing_price_in_points=$Item_details[0]->Billing_price_in_points;
					$Billing_price=$Item_details[0]->Billing_price;
					$Partner_id=$Item_details[0]->Partner_id;
					$Merchandize_item_name=$Item_details[0]->Merchandize_item_name;
					
					
					
					// echo"--lv_Redeem_points-----".$lv_Redeem_points."<br>";
						
					
					if ($val["Size_flag"] > 0) {
						
						$Company_merchandise_item_id = $val['Item_id'];
						$Selected_Size_flag = $val["Size_flag"];
						if($Selected_Size_flag == 1) {
						  $Item_size = "Small";
						} elseif ($Selected_Size_flag == 2) {
						  $Item_size = "Medium";
						} else {
						  $Item_size = "Large";
						}
						// echo"--Item_size-----".$Item_size."<br>";
						$Get_item_size_info = $this->Coal_Transactions_model->Get_Price_Points_by_size($Selected_Size_flag, $Company_merchandize_item_code, $Company_id);

						if ($Get_item_size_info != NULL) {
						  foreach ($Get_item_size_info as $Rec) {
							$Billing_price = $Rec["Billing_price"];
							$Billing_price_in_points = $Rec["Billing_price_in_points"];
						  }
						}
					  } else {
						  
						$Item_size = "No";
						$Billing_price = $Billing_price;
						$Billing_price_in_points = $Billing_price_in_points;
					  }	
					  $lv_Quantity = $val['QTY'];
					  $lv_Redeem_points = $Billing_price_in_points;
					  $lv_Item_code = $Company_merchandize_item_code;
					  $lv_Partner_id = $Partner_id;
					  
					$lv_Total_Redeem_points = ($lv_Redeem_points * $lv_Quantity);

              $html.= '<TR>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
							<b>Merchandize Item</b>
						</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
							' . $Merchandize_item_name . '
						</TD>
					</TR>
					<TR>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
							<b>Voucher No.</b>
						</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
							' . $Voucher_array[$i] . '
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
							<b>Size</b>
						</TD>
						<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
							' . $Item_size . '
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
																	<b>Current ' . $Company_details->Currency_name . ' Balance at Merchant</b>
																</TD>
																<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> 
																	' . $lv_Cust_seller_balance . '
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
															<a style="color:#C7702E" title="Member Website" href="' . $Company_details->Cust_website . '" target="_blank">Member Website</a>
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

          $Email_content = array(
              'Contents' => $html,
              'subject' => $subject,
              'Notification_type' => 'Redemption',
              'Template_type' => 'Coal_Redemption'
          );

          $Notification = $this->send_notification->Coal_send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);
        }

        $this->session->set_flashdata("success_code", "Redeem transaction done successfully !!!");
        redirect('Coal_Transactionc/redeem');
      }
    }
   
  }
?>