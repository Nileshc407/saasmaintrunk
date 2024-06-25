<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Coal_Reportc extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('pagination');
      $this->load->database();
      $this->load->helper('url');
      $this->load->model('login/Login_model');
      $this->load->model('Igain_model');
      $this->load->model('enrollment/Enroll_model');
      $this->load->model('Coal_Report/Coal_Report_model');
      $this->load->model('master/currency_model');
	  $this->load->model('Report/Report_model');
      $this->load->library("Excel");
      $this->load->library('m_pdf');
    }

    /*     * ********************New Alkwarm Report**************************************** */

    public function Alk_merchant_report() {

      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);


        // echo"  condition ----1";


        if ($Sub_seller_admin == 1) {
          $seller_id = $Sub_seller_admin;
        } else {
          $seller_id = $Sub_seller_Enrollement_id;
        }

        if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        }
        if ($Logged_user_id > 2 || $superSellerFlag == 1) {
          $data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'], $data['enroll']);
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {
          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
          // var_dump($data["company_sellers"]);
        } else {
          // $data["company_sellers"] = $this->Igain_model->get_seller_details($data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        $Today_date = date("Y-m-d");
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        if ($_REQUEST == NULL) {
          $data["Seller_report_details"] = NULL;
          $this->load->view("Coal_Reports/Coal_alkwarm_merchant_report", $data);
        } else {

          $report_type = $_REQUEST["report_type"];
          if ($report_type == 1) {
            $temp_table = $data['enroll'] . 'seller_igain_summary_rpt';
          } else {
            $temp_table = $data['enroll'] . 'seller_igain_detail_rpt';
          }


          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Company_id = $data['Company_id'];
          $seller_id = $_REQUEST["seller_id"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];


          $start_date1 = date("Y-m-d", strtotime($start_date));
          $end_date1 = date("Y-m-d", strtotime($end_date));

          $data["Report_type"] = $report_type;
          $data["end_date"] = date("Y-m-d", strtotime($_REQUEST["end_date"]));
          $data["start_date"] = date("Y-m-d", strtotime($_REQUEST["start_date"]));
          $data["seller_id"] = $_REQUEST["seller_id"];
          $data["transaction_type_id"] = $_REQUEST["transaction_type_id"];

          if (!isset($_REQUEST["page_limit"])) {

            $start = 0;
            $limit = 10;
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
          }
          $data["Seller_report_details"] = $this->Coal_Report_model->get_alk_seller_report_details($start_date, $end_date, $seller_id, $Company_id, $report_type, $transaction_type_id, $start, $limit);

          $data["Count_Records"] = $this->Coal_Report_model->get_alk_seller_report_details($start_date, $end_date, $seller_id, $Company_id, $report_type, $transaction_type_id, '', '');

          $this->load->view("Coal_Reports/Coal_alkwarm_merchant_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_Alk_merchant_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Country_id'] = $session_data['Country_id'];
        $Company_name = $session_data['Company_name'];

        $Report_type = $_REQUEST['Report_type'];
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        $Today_date = date("Y-m-d");

        if ($Report_type == 1) {
          $temp_table = $data['enroll'] . 'merchant_igain_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'merchant_igain_detail_rpt';
        }
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $start_date1 = date("Y-m-d", strtotime($start_date));
        $end_date1 = date("Y-m-d", strtotime($end_date));
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date1 . "_To_" . $end_date1 . "_Merchant_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;


        $Company_id = $data['Company_id'];
        $seller_id = $_REQUEST["seller_id"];
        $transaction_type_id = $_REQUEST["transaction_type_id"];




        $data["start_date"] = $start_date1;
        $data["end_date"] = $end_date1;

        //die;
        if ($pdf_excel_flag == 1) {
          $data["Seller_report_details"] = $this->Coal_Report_model->get_alk_seller_report_details_exl($start_date, $end_date, $seller_id, $Company_id, $Report_type, $transaction_type_id, '', '');

          $this->excel->getActiveSheet()->setTitle('Coalition Merchant Reports');
          $this->excel->stream($Export_file_name . '.xls', $data["Seller_report_details"]);
        } else {
          $data["Seller_report_details"] = $this->Coal_Report_model->get_alk_seller_report_details($start_date, $end_date, $seller_id, $Company_id, $Report_type, $transaction_type_id, '', '');

          $html = $this->load->view('Coal_Reports/Coal_pdf_alk_merchant_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Schedule_order_report() {

      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
        // echo"  condition ----1";


        if ($Sub_seller_admin == 1) {
          $seller_id = $Sub_seller_admin;
        } else {
          $seller_id = $Sub_seller_Enrollement_id;
        }

        if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        }
        if ($Logged_user_id > 2 || $superSellerFlag == 1) {
          $data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'], $data['enroll']);
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {
          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
          // var_dump($data["company_sellers"]);
        } else {
          // $data["company_sellers"] = $this->Igain_model->get_seller_details($data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        $Today_date = date("Y-m-d");
        if (isset($_REQUEST["page_limit"])) {
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          if ($_REQUEST["page_limit"] == 0) {//All
            $limit = "";
            $start = "";
          }
        } else {
          $start = 0;
          $limit = 10;
        }


        if ($_REQUEST == NULL) {
          $data["Schedule_order_details"] = NULL;
          $this->load->view("Coal_Reports/Coal_Schedule_order_report", $data);
        } else {


          $status = $_REQUEST["status"];
          $start_date = $_REQUEST["start_date"];
          $data["start_date"] = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];

          $data["Schedule_order_details"] = $this->Coal_Report_model->get_schedule_order_report($start_date, $end_date, $Company_id, $seller_id, $status, $start, $limit);
          $data["Count_Records"] = $this->Coal_Report_model->get_schedule_order_report($start_date, $end_date, $Company_id, $seller_id, $status, $start, $limit);

          $this->load->view("Coal_Reports/Coal_Schedule_order_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Alk_customer_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $data["tier_details"] = $this->Igain_model->get_tier($Company_id);

        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $select_cust = $_REQUEST["select_cust"];
          $report_type = $_REQUEST["report_type"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $Tier_id = $_REQUEST["Tier_id"];
          $Single_cust_membership_id = $_REQUEST["Single_cust_membership_id"];

          /* echo "start_date  ".$start_date;
            echo "end_date  ".$end_date; */
          if (isset($_REQUEST["page_limit"])) {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
          } else {
            $start = 0;
            $limit = 10;
          }
          if ($select_cust == 2) {//SINGLE CUSTOMER

            $data["Records1"] = $this->Igain_model->get_customer_details_Card_id($Single_cust_membership_id, $Company_id);
            //print_r($data["Records1"]);
            if (count($data["Records1"]->Enrollement_id) != 0) {
              $Enrollement_id = $data["Records1"]->Enrollement_id;
              //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary($Enrollement_id);
              if ($report_type == 1) {//details

                $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
              } else {
                $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
              }
            } else {
              $this->session->set_flashdata("error_code_CR", "Membership ID not exist");
              redirect(current_url());
            }
          } else { //ALL CUSTOMERS

            $Single_cust_membership_id = '';
            $Enrollement_id = 0;
            //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary_all($Company_id);
            if ($report_type == 1) {//details

              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
              $data["Count_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
            } else {
              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit);
              $data["Count_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
            }
          }
        }
        $this->load->view("Coal_Reports/Coal_alk_Customer_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_alk_customer_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_id'] = $session_data['Company_id'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $Report_type = $_REQUEST['report_type'];
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];

        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));

        $select_cust = $_REQUEST['select_cust'];
        $transaction_type_id = $_REQUEST['transaction_type_id'];
        $Tier_id = $_REQUEST['Tier_id'];

        $Today_date = date("Y-m-d");

        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        if ($Report_type == 2) {
          $temp_table = $data['enroll'] . 'member_igain_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'member_igain_detail_rpt';
        }





        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_Transaction_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        $data["Tier_id"] = $Tier_id;

        if ($pdf_excel_flag == 1) {
          if ($select_cust == 2) {//SINGLE CUSTOMER
            $Single_cust_membership_id = $_REQUEST['Single_cust_membership_id'];
            $data2["Records1"] = $this->Igain_model->get_customer_details_Card_id($Single_cust_membership_id, $Company_id);
            $Enrollement_id = $data2["Records1"]->Enrollement_id;

            if ($Report_type == 1) {//details
              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details_exl($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id);
            } else {
              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all_exl($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id);
            }
          } else { //ALL CUSTOMERS
            $Single_cust_membership_id = '';
            $Enrollement_id = 0;
            if ($Report_type == 1) {//details
              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details_exl($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id);
            } else {
              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all_exl($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id);
            }
          }


          $this->excel->getActiveSheet()->setTitle('Member Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          if ($select_cust == 2) {//SINGLE CUSTOMER
            $Single_cust_membership_id = $_REQUEST['Single_cust_membership_id'];
            $data["Records1"] = $this->Igain_model->get_customer_details_Card_id($Single_cust_membership_id, $Company_id);
            //print_r($data["Records1"]);
            if (count($data["Records1"]->Enrollement_id) != 0) {
              $Enrollement_id = $data["Records1"]->Enrollement_id;
              //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary($Enrollement_id);
              if ($Report_type == 1) {//details

                $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
              } else {
                $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
              }
            } else {
              $this->session->set_flashdata("error_code_CR", "Membership ID not exist");
              redirect(current_url());
            }
          } else { //ALL CUSTOMERS

            $Single_cust_membership_id = '';
            $Enrollement_id = 0;
            //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary_all($Company_id);
            if ($Report_type == 1) {//details

              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
            } else {
              $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
            }
          }

          $html = $this->load->view('Coal_Reports/Coal_alk_pdf_customer_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Alk_Customer_enrollment_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        if (isset($_REQUEST["page_limit"])) {
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          if ($_REQUEST["page_limit"] == 0) {//All
            $limit = "";
            $start = "";
          }
        } else {
          $start = 0;
          $limit = 10;
        }
        if ($_REQUEST != NULL) {
          $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
          $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));
          $lv_Company_id = $_REQUEST["Company_id"];

          $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_enrollment_report($lv_Company_id, $start_date, $end_date, $start, $limit);
          $data["Count_Records"] = $this->Coal_Report_model->get_alk_cust_enrollment_report($lv_Company_id, $start_date, $end_date, '', '');
        }

        $this->load->view("Coal_Reports/Coal_alk_Customer_enrollment_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_alk_customer_enrollment_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];


        $Today_date = date("Y-m-d");

        $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
        $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));

        $data["Trans_Records"] = $this->Coal_Report_model->get_alk_cust_enrollment_report($Company_id, $start_date, $end_date, '', '');


        $name = 'igain_member_enrollment_report';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_Enrollment_report";

        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Enrollment Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          $html = $this->load->view('Coal_Reports/Coal_alk_pdf_member_enrollment_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * *****Alkwarm Inactive Users Report ************************ */

    public function Alk_inactive_users_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Company_id = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];

        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];

        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Reportc/Alk_inactive_users_report";
        $total_row = $this->Igain_model->get_inactive_users_list($Company_id);
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

        $Users_Records = $this->Igain_model->get_inactive_users($config["per_page"], $page, $Company_id);
        $data["Users_Records"] = $Users_Records;
        $data["pagination"] = $this->pagination->create_links();

        if (count($Users_Records) > 0) {
          $this->session->set_flashdata("Activate_msg", "");

          $this->load->view("Coal_Reports/Coal_alk_inactive_users", $data);
        } else {
          $this->session->set_flashdata("Activate_msg", "There Is No Inactive Users!");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_alk_inactive_user_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $Today_date = date("Y-m-d");

        $Users_Records = $this->Igain_model->get_inactive_users('', '', $Company_id);

        //$userInfo[] = array();
        $i = 0;
        if (count($Users_Records) > 0) {
          foreach ($Users_Records as $user_info) {

            $userInfo[$i]['UserType'] = $user_info->User_type;
            $userInfo[$i]['UserName'] = $user_info->First_name . " " . $user_info->Middle_name . " " . $user_info->Last_name;
            $userInfo[$i]['MembershipId'] = $user_info->Card_id;
            $userInfo[$i]['PhoneNo.'] = $user_info->Phone_no;
            $userInfo[$i]['TotalPurchaseAmount'] = $user_info->total_purchase;
            $userInfo[$i]['TotalReddemPoints'] = $user_info->Total_reddems;

            $i++;
          }
        }


        $data["Seller_report_details"] = $userInfo;

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $Today_date . "_Inactive_Users_report";
        $data["Report_date"] = $Today_date;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('test worksheet');
          $this->excel->stream($Export_file_name . '.xls', $data["Seller_report_details"]);
        } else {
          $html = $this->load->view('Coal_Reports/Coal_alk_pdf_inactive_users_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Alk_activate_user() {

      $enroll_id = $this->input->get("enroll_id");
      $comp_id = $this->input->get("comp_id");

      $activate = $this->Igain_model->activate_user($enroll_id, $comp_id);
      $this->session->set_flashdata("Activate_msg", "User Activated Successfully !!!!");
      redirect('Coal_Reportc/Alk_inactive_users_report');
    }

    /*     * ********************New Alkwarm Report end**************************************** */

    public function customer_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $data["tier_details"] = $this->Igain_model->get_tier($Company_id);
		$currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
		 $data["Enable_company_meal_flag"] =  $data["Company_details"]->Enable_company_meal_flag;
		$currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $select_cust = $_REQUEST["select_cust"];
          $report_type = $_REQUEST["report_type"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $Tier_id = $_REQUEST["Tier_id"];
          $Single_cust_membership_id = $_REQUEST["Single_cust_membership_id"];

          /* echo "start_date  ".$start_date;
            echo "end_date  ".$end_date; */
          if (isset($_REQUEST["page_limit"])) {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
          } else {
            $start = 0;
            $limit = 10;
          }
          if ($select_cust == 2) {//SINGLE CUSTOMER

            $data["Records1"] = $this->Igain_model->get_customer_details_Card_id($Single_cust_membership_id, $Company_id);
            //print_r($data["Records1"]);
            if (count($data["Records1"]->Enrollement_id) != 0) {
              $Enrollement_id = $data["Records1"]->Enrollement_id;
              //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary($Enrollement_id);
              if ($report_type == 1) {//details

                $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Coal_Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
              } else {
                $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit, $data["Enable_company_meal_flag"]);
                $data["Count_Records"] = $this->Coal_Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '', $data["Enable_company_meal_flag"]);
              }
            } else {
              $this->session->set_flashdata("error_code_CR", "Membership ID not exist");
              redirect(current_url());
            }
          } else { //ALL CUSTOMERS

            $Single_cust_membership_id = '';
            $Enrollement_id = 0;
            //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary_all($Company_id);
            if ($report_type == 1) {//details

              $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
              $data["Count_Records"] = $this->Coal_Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
            } else {
              $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit, $data["Enable_company_meal_flag"]);
              $data["Count_Records"] = $this->Coal_Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '' ,$data["Enable_company_meal_flag"]);
            }
          }
        }
        $this->load->view("Coal_Reports/Coal_Customer_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    function MembershipID_validation() {
      $MembershipID = $this->input->post("MembershipID");
      $CompanyId = $this->input->post("Company_id");
      /* echo "<br>MembershipID ".$MembershipID;
        echo "<br>CompanyId ".$CompanyId; */
      $result = $this->Igain_model->validate_Card_id($MembershipID, $CompanyId);
      //echo "Enrollement_id ".count($result->Enrollement_id);//die;
      //print_r($result);
      //echo " result ".$result;
      if ($result->num == 1) {

        $this->output->set_output("Available");
      } else {
        $this->output->set_output("Not Available");
      }
    }

    public function export_customer_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
		$data['Country_id'] = $session_data['Country_id'];
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
		
        $Report_type = $_REQUEST['report_type'];
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $select_cust = $_REQUEST['select_cust'];
        $transaction_type_id = $_REQUEST['transaction_type_id'];
        $Tier_id = $_REQUEST['Tier_id'];
		$Enable_company_meal_flag =  $data["Company_details"]->Enable_company_meal_flag;
		$data["Enable_company_meal_flag"] =  $Enable_company_meal_flag;
        $Today_date = date("Y-m-d");

        if ($Report_type == 2) {
          $temp_table = $data['enroll'] . 'member_igain_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'member_igain_detail_rpt';
        }


        if ($select_cust == 2) {//SINGLE CUSTOMER
          $Single_cust_membership_id = $_REQUEST['Single_cust_membership_id'];
          $data2["Records1"] = $this->Igain_model->get_customer_details_Card_id($Single_cust_membership_id, $Company_id);
          $Enrollement_id = $data2["Records1"]->Enrollement_id;

          if ($Report_type == 1) {//details
            $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_details_reports($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $Enable_company_meal_flag);
          } else {
            $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id,'','', $Enable_company_meal_flag);
          }
        } else { //ALL CUSTOMERS
          $Single_cust_membership_id = '';
          $Enrollement_id = 0;
          if ($Report_type == 1) {//details
            $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_details_reports($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $Enable_company_meal_flag);
          } else {
            $data["Trans_Records"] = $this->Coal_Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '', $Enable_company_meal_flag);
          }
        }


        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_Transaction_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        $data["Tier_id"] = $Tier_id;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Customer Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
			  
			if($key == "Enrollement_id"){
				continue;
			}
			
            $fields[] = $key;
          }
          $col = 0;
          foreach ($fields as $field) {
            // echo"<pre>";
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
          }
          //Fetching the table data
          $row = 2;
		   $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, 'Credit_topup_points');
          foreach ($data["Trans_Records"] as $data1) {
            $col = 0;
            foreach ($fields as $field) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
              $col++;
            }
            $row++;
          }
          // die;
          ob_end_clean();
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header("Content-type: application/x-msexcel");
          header("Pragma: public");
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-Type: application/force-download");
          header("Content-Type: application/octet-stream");
          header("Content-Type: application/download");
          ;
          header("Content-Disposition: attachment; filename=" . $Export_file_name . ".xls ");
          header("Content-Transfer-Encoding: binary ");
          $this->excel->setActiveSheetIndex(0);
          $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
          //force user to download the Excel file without writing it to server's HD
          $objWriter->save('php://output');
          ob_end_clean();
        } else {
          $html = $this->load->view('Coal_Reports/Coal_pdf_customer_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************** Amit Work End ************************************ */

    /*     * **************************** Sandeep Work Start ************************************ */

    /*     * *****Inactive Users Report ************************ */

    public function inactive_users_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Company_id = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];

        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];

        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Reportc/inactive_users_report";
        $total_row = $this->Igain_model->get_inactive_users_list($Company_id);
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

        $Users_Records = $this->Igain_model->get_inactive_users($config["per_page"], $page, $Company_id);
        $data["Users_Records"] = $Users_Records;
        $data["pagination"] = $this->pagination->create_links();

        if (count($Users_Records) > 0) {
          $this->session->set_flashdata("error_code", "");

          $this->load->view("Coal_Reports/Coal_inactive_users", $data);
        } else {
          $this->session->set_flashdata("error_code", "There Is No Inactive Users!");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function activate_user() {
      $session_data = $this->session->userdata('logged_in');
      $data['username'] = $session_data['username'];
      $data['enroll'] = $session_data['enroll'];
      $data['Company_id'] = $session_data['Company_id'];
      $Company_id = $session_data['Company_id'];
      $data['Seller_topup_access'] = $session_data['Seller_topup_access'];

      $data['Country_id'] = $session_data['Country_id'];
      $data['Company_name'] = $session_data['Company_name'];
      $data['LogginUserName'] = $session_data['Full_name'];
      $Company_id = $session_data['Company_id'];

      $EnrollID = $this->input->get("enrollID");
      $CompID = $this->input->get("CompID");

      $activate = $this->Igain_model->activate_user($EnrollID, $CompID);


      /* -----------------------Pagination--------------------- */
      $config = array();
      $config["base_url"] = base_url() . "/index.php/Coal_Reportc/inactive_users_report";
      $total_row = $this->Igain_model->get_inactive_users_list($Company_id);
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
      $Users_Records = $this->Igain_model->get_inactive_users($config["per_page"], $page, $Company_id);
      $data["Users_Records"] = $Users_Records;
      $data["pagination"] = $this->pagination->create_links();



      if ($activate == true) {
        $this->session->set_flashdata("error_code", "User Activated Successfully!");
      } else {
        $this->session->set_flashdata("error_code", "User Not Activated Successfully!");
      }

      $this->load->view("Coal_Reports/Coal_inactive_users", $data);
      //redirect(current_url());	
    }

    public function export_inactive_user_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];

        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $Today_date = date("Y-m-d");

        $Users_Records = $this->Igain_model->get_inactive_users('', '', $Company_id);

        //$userInfo[] = array();
        $i = 0;
        if (count($Users_Records) > 0) {
          foreach ($Users_Records as $user_info) {

            $userInfo[$i]['UserType'] = $user_info->User_type;
            $userInfo[$i]['UserName'] = $user_info->First_name . " " . $user_info->Middle_name . " " . $user_info->Last_name;
            $userInfo[$i]['MembershipId'] = $user_info->Card_id;
            $userInfo[$i]['City'] = $user_info->City;
            $userInfo[$i]['PhoneNo'] = $user_info->Phone_no;
            $userInfo[$i]['TotalLoyaltyPoints'] = $user_info->Current_balance;
            $userInfo[$i]['TotalReddemPoints'] = $user_info->Total_reddems;
            $userInfo[$i]['TotalBonusPoints'] = $user_info->Total_topup_amt;

            $i++;
          }
        }


        $data["Seller_report_details"] = $userInfo;

        $Export_file_name = $Today_date . "_inactive_users_report";
        $data["Report_date"] = $Today_date;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('test worksheet');
          $this->excel->stream($Export_file_name . '.xls', $data["Seller_report_details"]);
        } else {
          $html = $this->load->view('Coal_Reports/Coal_pdf_inactive_users_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * *****Inactive Users Report ************************ */


    /*     * **************************** Sandeep Work End ************************************ */

    /*     * **********************************************Akshay Functions********************************************* */

    public function merchant_report() 
	{
      if ($this->session->userdata('logged_in')) 
	  {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $superSellerFlag = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        //print_r($session_data);
        //echo"  condition ----1";			

        
        if ($Sub_seller_admin == 1) {
          $seller_id = $Sub_seller_admin;
        } else {
          $seller_id = $Sub_seller_Enrollement_id;
        }

        /* if($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        }
         * if($Logged_user_id ==7){
          $superSellerFlag=1;
        } */
        
        
        if ($Logged_user_id > 2 || $superSellerFlag == 1) {

		 if ($superSellerFlag == 1) {
          $data["sub_sellers"] = $this->Igain_model->get_company_sellers_details($data['Company_id']);
		 }
        //  $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($session_data['Company_id']);
		  
          $data["company_sellers"] = $this->Igain_model->get_company_outlet_sellers($data['Company_id']);
          //get_company_sellers_and_staff
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {

         // $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
          $data["company_sellers"] = $this->Igain_model->Get_sub_seller($data['enroll']);
          // var_dump($data["company_sellers"]);
        } else {
           $data["company_sellers"] = $this->Igain_model->get_seller_details($data['enroll']);
         // $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $Today_date = date("Y-m-d");

        if ($_REQUEST == NULL) {
          $data["Seller_report_details"] = NULL;
          $this->load->view("Coal_Reports/Coal_merchant_report", $data);
        } else {

          $report_type = $_REQUEST["report_type"];
          if ($report_type == 1) {
            $temp_table = $data['enroll'] . 'seller_igain_summary_rpt';
          } else {
            $temp_table = $data['enroll'] . 'seller_igain_detail_rpt';
          }
          $data["Report_type"] = $report_type;
          $start_date = $_REQUEST["start_date"];
          $data["start_date"] = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];
          $brand_id = $_REQUEST["brand_id"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $data["start_date"] = $start_date;
          $data["end_date"] = $end_date;
          if (!isset($_REQUEST["page_limit"])) {

			if($seller_id == 0)
			{
				$Outlets = $this->Report_model->get_outlet_by_subadmin($Company_id,$brand_id);
				foreach($Outlets as $Rec)
				{
					$OutletsID[]=$Rec->Enrollement_id;
					
				}
				$seller_id = $OutletsID;
				// print_r($OutletsID);die;
			}
            $result = $this->Coal_Report_model->get_merchant_report($start_date, $end_date, $Company_id, $seller_id, $transaction_type_id, $report_type, $data['enroll']);

            if ($result > 0) {
              $start_date1 = date("Y-m-d", strtotime($start_date));
              $end_date1 = date("Y-m-d", strtotime($end_date));



              $start = 0;
              $limit = 10;

              $data["Seller_report_details"] = $this->Coal_Report_model->get_seller_report_details($temp_table, $report_type, $start, $limit);
              $data["Count_Records"] = $this->Coal_Report_model->get_seller_report_details($temp_table, $report_type, '', '');

              // $data["pagination"] = $this->pagination->create_links();
              // $Export_file_name = $Today_date."_".$temp_table;
              // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);
            } else {
              $data["Seller_report_details"] = NULL;
            }
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) { //All
              $limit = "";
              $start = "";
            }
            $data["Seller_report_details"] = $this->Coal_Report_model->get_seller_report_details($temp_table, $report_type, $start, $limit);
            $data["Count_Records"] = $this->Coal_Report_model->get_seller_report_details($temp_table, $report_type, '', '');
          }
          $this->load->view("Coal_Reports/Coal_merchant_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_merchant_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_name = $session_data['Company_name'];
        $data['Country_id'] = $session_data['Country_id'];

        $Report_type = $_GET['Report_type'];
        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_GET['start_date']));
        $end_date = date("Y-m-d", strtotime($_GET['end_date']));
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        $Today_date = date("Y-m-d");

        if ($Report_type == 1) {
          $temp_table = $data['enroll'] . 'seller_igain_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'seller_igain_detail_rpt';
        }
        $data["Seller_report_details"] = $this->Coal_Report_model->get_seller_excel_report_details($temp_table, $Report_type);
        // $Export_file_name = $Today_date."_".$temp_table;
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Outlet_trans_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Outlet Transaction Reports');
          // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Seller_report_details"][0] as $key => $field) {
			
			if($Report_type == 0)
			{
			$this->excel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('0.00');
			$this->excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('0.00');
			$this->excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00');
			}
			
			if($Report_type == 1)
			{
			$this->excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('0.00');
			$this->excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00');
			}
			
            $fields[] = $key;
          }
          $col = 0;
          foreach ($fields as $field) {
            // echo"<pre>";
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
          }
          //Fetching the table data
          $row = 2;
          foreach ($data["Seller_report_details"] as $data1) {
            $col = 0;
			if($Report_type == 0)
			{
				$data1->Purchase_amt = number_format(round($data1->Purchase_amt),2);
				$data1->Voucher_amount = number_format(round($data1->Voucher_amount),2);
				$data1->balance_to_pay = number_format(round($data1->balance_to_pay),2);
			}
			
			if($Report_type == 1)
			{
				$data1->Purchase_amt = number_format(round($data1->Purchase_amt),2);
				$data1->Voucher_amount = number_format(round($data1->Voucher_amount),2);
			}
			
            foreach ($fields as $field) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
              $col++;
            }
            $row++;
          }
          // die;
          ob_end_clean();
          header('Content-Type: application/vnd.ms-excel'); //mime type
          header("Content-type: application/x-msexcel");
          header("Pragma: public");
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Content-Type: application/force-download");
          header("Content-Type: application/octet-stream");
          header("Content-Type: application/download");
          ;
          header("Content-Disposition: attachment; filename=" . $Export_file_name . ".xls ");
          header("Content-Transfer-Encoding: binary ");
          $this->excel->setActiveSheetIndex(0);
          $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
          //force user to download the Excel file without writing it to server's HD
          $objWriter->save('php://output');
          ob_end_clean();
        } else {
          $html = $this->load->view('Coal_Reports/Coal_pdf_merchant_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **********************************************Akshay Functions********************************************* */



    /*     * ********************************AMIT Functions START 26-05-2016******************************** */

    public function Customer_High_Value_Trans_Report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Value_type = $_REQUEST["Value_type"];
          $Operatorid = $_REQUEST["Operatorid"];
          $Criteria = $_REQUEST["Criteria"];
          $Criteria_value = $_REQUEST["Criteria_value"];
          if (isset($_REQUEST["page_limit"])) {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
          } else {
            $start = 0;
            $limit = 10;
          }

          if ($Operatorid == 1) {
            $Criteria_value2 = 0;
          } else {
            $Criteria_value2 = $_REQUEST["Criteria_value2"];
          }

          $data["Trans_Records"] = $this->Coal_Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, $start, $limit);
          $data["Count_Records"] = $this->Coal_Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, '', '');
        }

        $this->load->view("Coal_Reports/Coal_Customer_high_value_trans_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_customer_high_value_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];


        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $lv_Company_id = $_REQUEST["Company_id"];
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $Value_type = $_REQUEST["Value_type"];
        $Operatorid = $_REQUEST["Operatorid"];
        $Criteria = $_REQUEST["Criteria"];
        $Criteria_value = $_REQUEST["Criteria_value"];
        $Criteria_value2 = $_REQUEST["Criteria_value2"];



        $Today_date = date("Y-m-d");

        $data["Trans_Records"] = $this->Coal_Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, '', '');


        $name = 'igain_member_high_value_report';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_High_value_Transaction_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member High Value Trans. Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          $html = $this->load->view('Coal_Reports/Coal_pdf_member_high_value_trans_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Customer_enrollment_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        if (isset($_REQUEST["page_limit"])) {
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          if ($_REQUEST["page_limit"] == 0) {//All
            $limit = "";
            $start = "";
          }
        } else {
          $start = 0;
          $limit = 10;
        }
        if ($_REQUEST != NULL) {
          $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
          $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));
          $lv_Company_id = $_REQUEST["Company_id"];

          $data["Trans_Records"] = $this->Coal_Report_model->get_cust_enrollment_report($lv_Company_id, $start_date, $end_date, $start, $limit);
          $data["Count_Records"] = $this->Coal_Report_model->get_cust_enrollment_report($lv_Company_id, $start_date, $end_date, '', '');
        }

        $this->load->view("Coal_Reports/Coal_Customer_enrollment_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_customer_enrollment_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];


        $Today_date = date("Y-m-d");

        $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
        $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));

        $data["Trans_Records"] = $this->Coal_Report_model->get_cust_enrollment_report($Company_id, $start_date, $end_date, '', '');


        $name = 'igain_member_enrollment_report';
        // $Export_file_name = $Today_date."_".$name;
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "Member_Enrollment_Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Enrollment Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          $html = $this->load->view('Coal_Reports/Coal_pdf_member_enrollment_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************AMIT Functions END 26-05-2016********************************* */
  }
?>

