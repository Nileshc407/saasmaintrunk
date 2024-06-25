<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Reportc extends CI_Controller {

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
      $this->load->model('Report/Report_model');
      $this->load->model('Coal_Report/Coal_Report_model');
      $this->load->library("Excel");
      $this->load->library('m_pdf');
      $this->load->model("login/Home_model");
      $this->load->model('Segment/Segment_model');
      $this->load->model('master/currency_model');
      $this->load->model('CallCenter/CallCenter_model');
    }

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
        /*         * ******AMIT 30-03-2017*********** */
        $data["Segments_list"] = $this->Segment_model->Segment_list('', '', $data['Company_id']);
        /*         * *************************** */
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
          $Segment_code = $_REQUEST["Segment_code"];

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

                $data["Trans_Records"] = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
              } else {
                $data["Trans_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
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
              //echo "Segment_code ".$Segment_code;
              if ($Segment_code != "") {
                $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

                $all_customers = $this->Igain_model->get_all_customers($Company_id);
                foreach ($all_customers as $row) {
                  // echo "<b>First_name ".$row["First_name"]."</b>";
                  $Applicable_array = array();

                  foreach ($Get_segments2 as $Get_segments) {
                    // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                    // echo "<br>";

                    if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                      $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                      // echo "****Age--".$lv_Cust_value;
                    }

                    if ($Get_segments->Segment_type_id == 2) {//Sex
                      $lv_Cust_value = $row['Sex'];
                      // echo "****Sex ".$lv_Cust_value;
                    }
                    if ($Get_segments->Segment_type_id == 3) {//Country
                      $lv_Country_id = $row['Country_id'];
                      // echo "****Country_id ".$lv_Country_id;
                      $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                      $lv_Cust_value = $currency_details->Country_name;
                      // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 4) {//District
                      $lv_Cust_value = $row['District'];

                      // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 5) {//State
                      $lv_Cust_value = $row['State'];

                      // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 6) {//city
                      $lv_Cust_value = $row['City'];

                      // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 7) {//Zipcode
                      $lv_Cust_value = $row['Zipcode'];

                      // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                      $lv_Cust_value = $row['total_purchase'];

                      // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                      $lv_Cust_value = $row['Total_reddems'];

                      // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                      $lv_start_date = $row['joined_date'];
                      $lv_end_date = date("Y-m-d");
                      $lv_transaction_type_id = 2;
                      $lv_Tier_id = $row['Tier_id'];

                      $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                      foreach ($Trans_Records as $Trans_Records) {
                        $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                      }

                      // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                      $lv_start_date = $row['joined_date'];
                      $lv_end_date = date("Y-m-d");
                      $lv_transaction_type_id = 2;
                      $lv_Tier_id = $row['Tier_id'];

                      $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                      foreach ($Trans_Records as $Trans_Records) {
                        $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                      }
                      $lv_Cust_value = max($lv_Max_amt);
                      // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                      $tUnixTime = time();
                      list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                      $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                      $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                      // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                    }

                    $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                    $Applicable_array[] = $Get_segments;
                  }
                  // print_r($Applicable_array);
                  if (!in_array(0, $Applicable_array, true)) {
                    // echo "<br>Access";
                    $Applicable_enroll_array[] = $row["Enrollement_id"];
                    $Customer_array = implode(",", $Applicable_enroll_array);
                  }
                }
                if (count($Customer_array) != 0) {
                  $data["Trans_Records"] = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Customer_array, $transaction_type_id, $Tier_id, $start, $limit);

                  $data["Count_Records"] = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Customer_array, $transaction_type_id, $Tier_id, '', '');
                }
              } else {
                $data["Trans_Records"] = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
              }
            } else {
              //echo "Segment_code ".$Segment_code;
              if ($Segment_code != "") {
                $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);
                //

                $all_customers = $this->Igain_model->get_all_customers($Company_id);
                foreach ($all_customers as $row) {
                  // echo "<b>First_name ".$row["First_name"]."</b>";
                  $Applicable_array[] = 0;

                  unset($Applicable_array);
                  //print_r($Applicable_array);
                  foreach ($Get_segments2 as $Get_segments) {
                    // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                    // echo "<br>";
                    if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                      $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                      // echo "****Age--".$lv_Cust_value;
                    }

                    if ($Get_segments->Segment_type_id == 2) {//Sex
                      $lv_Cust_value = $row['Sex'];
                      // echo "****Sex ".$lv_Cust_value;
                    }
                    if ($Get_segments->Segment_type_id == 3) {//Country
                      $lv_Country_id = $row['Country_id'];
                      // echo "****Country_id ".$lv_Country_id;
                      $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                      $lv_Cust_value = $currency_details->Country_name;
                      // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 4) {//District
                      $lv_Cust_value = $row['District'];

                      // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 5) {//State
                      $lv_Cust_value = $row['State'];

                      // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 6) {//city
                      $lv_Cust_value = $row['City'];

                      // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 7) {//Zipcode
                      $lv_Cust_value = $row['Zipcode'];

                      // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                      $lv_Cust_value = $row['total_purchase'];

                      // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                      $lv_Cust_value = $row['Total_reddems'];

                      // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                      $lv_start_date = $row['joined_date'];
                      $lv_end_date = date("Y-m-d");
                      $lv_transaction_type_id = 2;
                      $lv_Tier_id = $row['Tier_id'];

                      $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                      foreach ($Trans_Records as $Trans_Records) {
                        $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                      }

                      // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                      $lv_start_date = $row['joined_date'];
                      $lv_end_date = date("Y-m-d");
                      $lv_transaction_type_id = 2;
                      $lv_Tier_id = $row['Tier_id'];

                      $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                      foreach ($Trans_Records as $Trans_Records) {
                        $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                      }
                      $lv_Cust_value = max($lv_Max_amt);
                      // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                      $tUnixTime = time();
                      list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                      $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                      $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                      // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                    }

                    $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                    $Applicable_array[] = $Get_segments;
                  }
                  // print_r($Applicable_array);
                  if (!in_array(0, $Applicable_array, true)) {
                    // echo "<br>Access";
                    $Applicable_enroll_array[] = $row["Enrollement_id"];
                    $Customer_array = implode(",", $Applicable_enroll_array);
                  }
                }
                if (count($Customer_array) != 0) {

                  // echo "<br>Access";
                  $data["Trans_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Customer_array, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit);
                  $data["Count_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Customer_array, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
                }
              } else {
                $data["Trans_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit);
                $data["Count_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
              }
            }
          }
        }

        $this->load->view("Reports/Customer_report_view", $data);
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

        $Report_type = $_REQUEST['report_type'];
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $select_cust = $_REQUEST['select_cust'];
        $transaction_type_id = $_REQUEST['transaction_type_id'];
        $Tier_id = $_REQUEST['Tier_id'];
        $Segment_code = $_REQUEST["Segment_code"];

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
            $data["Trans_Records"] = $this->Report_model->get_cust_trans_details_reports($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id);
          } else {
            $data["Trans_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id);
          }
        } else { //ALL CUSTOMERS
          $Single_cust_membership_id = '';
          $Enrollement_id = 0;
          if ($Report_type == 1) {//details

            if ($Segment_code != "") {
              $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

              $all_customers = $this->Igain_model->get_all_customers($Company_id);
              foreach ($all_customers as $row) {
                // echo "<b>First_name ".$row["First_name"]."</b>";
                $Applicable_array[] = 0;

                unset($Applicable_array);
                //print_r($Applicable_array);
                foreach ($Get_segments2 as $Get_segments) {
                  // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                  // echo "<br>";
                  if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                    $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                    // echo "****Age--".$lv_Cust_value;
                  }

                  if ($Get_segments->Segment_type_id == 2) {//Sex
                    $lv_Cust_value = $row['Sex'];
                    // echo "****Sex ".$lv_Cust_value;
                  }
                  if ($Get_segments->Segment_type_id == 3) {//Country
                    $lv_Country_id = $row['Country_id'];
                    // echo "****Country_id ".$lv_Country_id;
                    $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                    $lv_Cust_value = $currency_details->Country_name;
                    // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 4) {//District
                    $lv_Cust_value = $row['District'];

                    // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 5) {//State
                    $lv_Cust_value = $row['State'];

                    // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 6) {//city
                    $lv_Cust_value = $row['City'];

                    // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 7) {//Zipcode
                    $lv_Cust_value = $row['Zipcode'];

                    // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                    $lv_Cust_value = $row['total_purchase'];

                    // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                    $lv_Cust_value = $row['Total_reddems'];

                    // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                    }

                    // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                    }
                    $lv_Cust_value = max($lv_Max_amt);
                    // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                    $tUnixTime = time();
                    list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                    $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                    $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                    // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                  }

                  $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                  $Applicable_array[] = $Get_segments;
                }
                // print_r($Applicable_array);
                if (!in_array(0, $Applicable_array, true)) {
                  // echo "<br>Access";
                  $Applicable_enroll_array[] = $row["Enrollement_id"];
                  $Customer_array = implode(",", $Applicable_enroll_array);
                }
              }
              if (count($Customer_array) != 0) {

                $data["Trans_Records"] = $this->Report_model->get_cust_trans_details_reports($Company_id, $start_date, $end_date, $Customer_array, $transaction_type_id, $Tier_id);
              }
            } else {
              $data["Trans_Records"] = $this->Report_model->get_cust_trans_details_reports($Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id);
            }
          } else {
            if ($Segment_code != "") {
              $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

              $all_customers = $this->Igain_model->get_all_customers($Company_id);
              foreach ($all_customers as $row) {
                // echo "<b>First_name ".$row["First_name"]."</b>";
                $Applicable_array[] = 0;

                unset($Applicable_array);
                //print_r($Applicable_array);
                foreach ($Get_segments2 as $Get_segments) {
                  // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                  // echo "<br>";
                  if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                    $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                    // echo "****Age--".$lv_Cust_value;
                  }

                  if ($Get_segments->Segment_type_id == 2) {//Sex
                    $lv_Cust_value = $row['Sex'];
                    // echo "****Sex ".$lv_Cust_value;
                  }
                  if ($Get_segments->Segment_type_id == 3) {//Country
                    $lv_Country_id = $row['Country_id'];
                    // echo "****Country_id ".$lv_Country_id;
                    $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                    $lv_Cust_value = $currency_details->Country_name;
                    // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 4) {//District
                    $lv_Cust_value = $row['District'];

                    // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 5) {//State
                    $lv_Cust_value = $row['State'];

                    // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 6) {//city
                    $lv_Cust_value = $row['City'];

                    // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 7) {//Zipcode
                    $lv_Cust_value = $row['Zipcode'];

                    // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                    $lv_Cust_value = $row['total_purchase'];

                    // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                    $lv_Cust_value = $row['Total_reddems'];

                    // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                    }

                    // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                    }
                    $lv_Cust_value = max($lv_Max_amt);
                    // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                    $tUnixTime = time();
                    list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                    $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                    $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                    // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                  }

                  $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                  $Applicable_array[] = $Get_segments;
                }
                // print_r($Applicable_array);
                if (!in_array(0, $Applicable_array, true)) {
                  // echo "<br>Access";
                  $Applicable_enroll_array[] = $row["Enrollement_id"];
                  $Customer_array = implode(",", $Applicable_enroll_array);
                }
              }
              if (count($Customer_array) != 0) {

                $data["Trans_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Customer_array, $start_date, $end_date, $transaction_type_id, $Tier_id);
              }
            } else {
              $data["Trans_Records"] = $this->Report_model->get_cust_trans_summary_all($Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id);
            }
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
        $data['Company_id'] = $Company_id;
        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          $html = $this->load->view('Reports/pdf_customer_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Customer_Redemption_Report() {
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
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;
        $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;
        $Sub_seller_admin = $user_details->Sub_seller_admin;
        /*         * ******AMIT 1-04-2017*********** */
        $data["Segments_list"] = $this->Segment_model->Segment_list('', '', $data['Company_id']);
        /*         * *************************** */
        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $select_cust = $_REQUEST["select_cust"];
          $report_type = $_REQUEST["report_type"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $Delivery_method = $_REQUEST["Delivery_method"];
          $Voucher_status = $_REQUEST["Voucher_status"];
          $Segment_code = $_REQUEST["Segment_code"];
          if ($select_cust == 1) {
            $Single_cust_membership_id = 0;
          } else {
            $Single_cust_membership_id = $_REQUEST["Single_cust_membership_id"];
          }
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
          if ($report_type == 1) {//details
            // echo "Segment_code ".$Segment_code;
            if ($Segment_code != "") {
              $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

              $all_customers = $this->Igain_model->get_all_customers($Company_id);
              foreach ($all_customers as $row) {
                // echo "<b>First_name ".$row["First_name"]."</b>";
                $Applicable_array[] = 0;

                unset($Applicable_array);
                //print_r($Applicable_array);
                foreach ($Get_segments2 as $Get_segments) {
                  // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                  // echo "<br>";
                  if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                    $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                    // echo "****Age--".$lv_Cust_value;
                  }

                  if ($Get_segments->Segment_type_id == 2) {//Sex
                    $lv_Cust_value = $row['Sex'];
                    // echo "****Sex ".$lv_Cust_value;
                  }
                  if ($Get_segments->Segment_type_id == 3) {//Country
                    $lv_Country_id = $row['Country_id'];
                    // echo "****Country_id ".$lv_Country_id;
                    $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                    $lv_Cust_value = $currency_details->Country_name;
                    // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 4) {//District
                    $lv_Cust_value = $row['District'];

                    // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 5) {//State
                    $lv_Cust_value = $row['State'];

                    // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 6) {//city
                    $lv_Cust_value = $row['City'];

                    // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 7) {//Zipcode
                    $lv_Cust_value = $row['Zipcode'];

                    // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                    $lv_Cust_value = $row['total_purchase'];

                    // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                    $lv_Cust_value = $row['Total_reddems'];

                    // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                    }

                    // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                    }
                    $lv_Cust_value = max($lv_Max_amt);
                    // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                    $tUnixTime = time();
                    list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                    $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                    $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                    // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                  }

                  $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                  $Applicable_array[] = $Get_segments;
                }
                // print_r($Applicable_array);
                if (!in_array(0, $Applicable_array, true)) {
                  // echo "<br>Access";
                  $Applicable_enroll_array[] = $row["Enrollement_id"];
                  $Applicable_enroll_card_array[] = $row["Card_id"];
                  $Customer_array = implode(",", $Applicable_enroll_array);
                  $Customer_card_array = implode(",", $Applicable_enroll_card_array);
                }
              }
              if (count($Customer_array) != 0) {

                // echo "<br>Access";
                $data["Trans_Records"] = $this->Report_model->get_cust_redemption_details($Company_id, $start_date, $end_date, $transaction_type_id, $Customer_card_array, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin, $start, $limit);
                $data["Count_Records"] = $this->Report_model->get_cust_redemption_details($Company_id, $start_date, $end_date, $transaction_type_id, $Customer_card_array, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin, '', '');
              }
            } else {
              $data["Trans_Records"] = $this->Report_model->get_cust_redemption_details($Company_id, $start_date, $end_date, $transaction_type_id, $Single_cust_membership_id, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin, $start, $limit);
              $data["Count_Records"] = $this->Report_model->get_cust_redemption_details($Company_id, $start_date, $end_date, $transaction_type_id, $Single_cust_membership_id, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin, '', '');
            }
          } else { //summary
            if ($Segment_code != "") {
              $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

              $all_customers = $this->Igain_model->get_all_customers($Company_id);
              foreach ($all_customers as $row) {
                // echo "<b>First_name ".$row["First_name"]."</b>";
                $Applicable_array = array();

                foreach ($Get_segments2 as $Get_segments) {
                  // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                  // echo "<br>";
                  if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                    $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                    // echo "****Age--".$lv_Cust_value;
                  }

                  if ($Get_segments->Segment_type_id == 2) {//Sex
                    $lv_Cust_value = $row['Sex'];
                    // echo "****Sex ".$lv_Cust_value;
                  }
                  if ($Get_segments->Segment_type_id == 3) {//Country
                    $lv_Country_id = $row['Country_id'];
                    // echo "****Country_id ".$lv_Country_id;
                    $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                    $lv_Cust_value = $currency_details->Country_name;
                    // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 4) {//District
                    $lv_Cust_value = $row['District'];

                    // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 5) {//State
                    $lv_Cust_value = $row['State'];

                    // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 6) {//city
                    $lv_Cust_value = $row['City'];

                    // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                    if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                      $Get_segments->Value = $lv_Cust_value;
                    }
                  }
                  if ($Get_segments->Segment_type_id == 7) {//Zipcode
                    $lv_Cust_value = $row['Zipcode'];

                    // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                    $lv_Cust_value = $row['total_purchase'];

                    // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                    $lv_Cust_value = $row['Total_reddems'];

                    // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                    }

                    // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                    $lv_start_date = $row['joined_date'];
                    $lv_end_date = date("Y-m-d");
                    $lv_transaction_type_id = 2;
                    $lv_Tier_id = $row['Tier_id'];

                    $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                    foreach ($Trans_Records as $Trans_Records) {
                      $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                    }
                    $lv_Cust_value = max($lv_Max_amt);
                    // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                  }
                  if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                    $tUnixTime = time();
                    list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                    $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                    $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                    // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                  }

                  $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                  $Applicable_array[] = $Get_segments;
                }
                // print_r($Applicable_array);
                if (!in_array(0, $Applicable_array, true)) {
                  // echo "<br>Access";
                  $Applicable_enroll_array[] = $row["Enrollement_id"];
                  $Applicable_enroll_card_array[] = $row["Card_id"];
                  $Customer_array = implode(",", $Applicable_enroll_array);
                  $Customer_card_array = implode(",", $Applicable_enroll_card_array);
                }
              }
              if (count($Customer_array) != 0) {

                // echo "<br>Access";
                $data["Trans_Records"] = $this->Report_model->get_cust_redemption_summary($Company_id, $start_date, $end_date, $transaction_type_id, $Customer_card_array, $report_type, $Delivery_method, $Voucher_status, $Customer_array, $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin, $start, $limit);

              }
            } else {
              $data["Trans_Records"] = $this->Report_model->get_cust_redemption_summary($Company_id, $start_date, $end_date, $transaction_type_id, $Single_cust_membership_id, $report_type, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin, $start, $limit);

            }
          }
        }

        $this->load->view("Reports/Customer_Redemption_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_customer_redempion_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $Report_type = $_REQUEST['report_type'];
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_REQUEST['start_date']));
        $end_date = date("Y-m-d", strtotime($_REQUEST['end_date']));
        $select_cust = $_REQUEST['select_cust'];
        $transaction_type_id = $_REQUEST['transaction_type_id'];
        $Delivery_method = $_REQUEST["Delivery_method"];
        $Voucher_status = $_REQUEST["Voucher_status"];
        $Segment_code = $_REQUEST["Segment_code"];
        $Today_date = date("Y-m-d");

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;
        $Sub_seller_Enrollement_id = $user_details->Sub_seller_Enrollement_id;
        $Sub_seller_admin = $user_details->Sub_seller_admin;

        if ($Report_type == 2) {
          $name = 'igain_customer_catalogue_summary_rpt';
        } else {
          $name = 'igain_customer_catalogue_detail_rpt';
        }

        if ($select_cust == 1) {
          $Single_cust_membership_id = 0;
        } else {
          $Single_cust_membership_id = $_REQUEST["Single_cust_membership_id"];
        }

        if ($Report_type == 1) {//details
          // $data["Trans_Records"] = $this->Report_model->get_cust_redemption_details_exports($Company_id,$start_date,$end_date,$transaction_type_id,$Single_cust_membership_id,$Voucher_status);	
          if ($Segment_code != "") {
            $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

            $all_customers = $this->Igain_model->get_all_customers($Company_id);
            foreach ($all_customers as $row) {
              // echo "<b>First_name ".$row["First_name"]."</b>";
              $Applicable_array = array();

              foreach ($Get_segments2 as $Get_segments) {
                // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                // echo "<br>";
                if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                  $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                  // echo "****Age--".$lv_Cust_value;
                }

                if ($Get_segments->Segment_type_id == 2) {//Sex
                  $lv_Cust_value = $row['Sex'];
                  // echo "****Sex ".$lv_Cust_value;
                }
                if ($Get_segments->Segment_type_id == 3) {//Country
                  $lv_Country_id = $row['Country_id'];
                  // echo "****Country_id ".$lv_Country_id;
                  $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                  $lv_Cust_value = $currency_details->Country_name;
                  // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 4) {//District
                  $lv_Cust_value = $row['District'];

                  // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 5) {//State
                  $lv_Cust_value = $row['State'];

                  // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 6) {//city
                  $lv_Cust_value = $row['City'];

                  // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 7) {//Zipcode
                  $lv_Cust_value = $row['Zipcode'];

                  // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                  $lv_Cust_value = $row['total_purchase'];

                  // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                  $lv_Cust_value = $row['Total_reddems'];

                  // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                  $lv_start_date = $row['joined_date'];
                  $lv_end_date = date("Y-m-d");
                  $lv_transaction_type_id = 2;
                  $lv_Tier_id = $row['Tier_id'];

                  $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                  foreach ($Trans_Records as $Trans_Records) {
                    $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                  }

                  // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                  $lv_start_date = $row['joined_date'];
                  $lv_end_date = date("Y-m-d");
                  $lv_transaction_type_id = 2;
                  $lv_Tier_id = $row['Tier_id'];

                  $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                  foreach ($Trans_Records as $Trans_Records) {
                    $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                  }
                  $lv_Cust_value = max($lv_Max_amt);
                  // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                  $tUnixTime = time();
                  list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                  $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                  $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                  // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                }

                $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                $Applicable_array[] = $Get_segments;
              }
              // print_r($Applicable_array);
              if (!in_array(0, $Applicable_array, true)) {
                // echo "<br>Access";
                $Applicable_enroll_array[] = $row["Enrollement_id"];
                $Applicable_enroll_card_array[] = $row["Card_id"];
                $Customer_array = implode(",", $Applicable_enroll_array);
                $Customer_card_array = implode(",", $Applicable_enroll_card_array);
              }
            }
            if (count($Customer_array) != 0) {
              // echo "<br>Access";
              $data["Trans_Records"] = $this->Report_model->get_cust_redemption_details_exports($Company_id, $start_date, $end_date, $transaction_type_id, $Customer_card_array, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin);
            }
          } else {
            $data["Trans_Records"] = $this->Report_model->get_cust_redemption_details_exports($Company_id, $start_date, $end_date, $transaction_type_id, $Single_cust_membership_id, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin);
          }
        } else {
          if ($Segment_code != "") {
            $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);

            $all_customers = $this->Igain_model->get_all_customers($Company_id);
            foreach ($all_customers as $row) {
              // echo "<b>First_name ".$row["First_name"]."</b>";
              $Applicable_array = array();

              foreach ($Get_segments2 as $Get_segments) {
                // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                // echo "<br>";
                if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                  $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                  // echo "****Age--".$lv_Cust_value;
                }

                if ($Get_segments->Segment_type_id == 2) {//Sex
                  $lv_Cust_value = $row['Sex'];
                  // echo "****Sex ".$lv_Cust_value;
                }
                if ($Get_segments->Segment_type_id == 3) {//Country
                  $lv_Country_id = $row['Country_id'];
                  // echo "****Country_id ".$lv_Country_id;
                  $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                  $lv_Cust_value = $currency_details->Country_name;
                  // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 4) {//District
                  $lv_Cust_value = $row['District'];

                  // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 5) {//State
                  $lv_Cust_value = $row['State'];

                  // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 6) {//city
                  $lv_Cust_value = $row['City'];

                  // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 7) {//Zipcode
                  $lv_Cust_value = $row['Zipcode'];

                  // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                  $lv_Cust_value = $row['total_purchase'];

                  // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                  $lv_Cust_value = $row['Total_reddems'];

                  // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                  $lv_start_date = $row['joined_date'];
                  $lv_end_date = date("Y-m-d");
                  $lv_transaction_type_id = 2;
                  $lv_Tier_id = $row['Tier_id'];

                  $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                  foreach ($Trans_Records as $Trans_Records) {
                    $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                  }

                  // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                  $lv_start_date = $row['joined_date'];
                  $lv_end_date = date("Y-m-d");
                  $lv_transaction_type_id = 2;
                  $lv_Tier_id = $row['Tier_id'];

                  $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                  foreach ($Trans_Records as $Trans_Records) {
                    $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                  }
                  $lv_Cust_value = max($lv_Max_amt);
                  // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                  $tUnixTime = time();
                  list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                  $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                  $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                  // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                }

                $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                $Applicable_array[] = $Get_segments;
              }
              // print_r($Applicable_array);
              if (!in_array(0, $Applicable_array, true)) {
                // echo "<br>Access";
                $Applicable_enroll_array[] = $row["Enrollement_id"];
                $Applicable_enroll_card_array[] = $row["Card_id"];
                $Customer_array = implode(",", $Applicable_enroll_array);
                $Customer_card_array = implode(",", $Applicable_enroll_card_array);
              }
            }
            if (count($Customer_array) != 0) {

              // echo "<br>Access";
              $data["Trans_Records"] = $this->Report_model->get_cust_redemption_summary_exports($Company_id, $start_date, $end_date, $transaction_type_id, $Customer_card_array, $report_type, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin);
            }
          } else {
            $data["Trans_Records"] = $this->Report_model->get_cust_redemption_summary_exports($Company_id, $start_date, $end_date, $transaction_type_id, $Single_cust_membership_id, $report_type, $Delivery_method, $Voucher_status, $data['enroll'], $Super_seller, $Sub_seller_Enrollement_id, $Sub_seller_admin);
          }
        }

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_Catalogue_Report";

        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Catalogue Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
			  
			if($key == "Issued_Enrollment" || $key == "Updated_Enrollment")
			{
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
          $html = $this->load->view('Reports/pdf_customer_redemption_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Partner_Redemption_Report() {
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
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['Super_seller'] = $session_data['Super_seller'];

        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();

        $this->load->model('Catalogue/Catelogue_model');
        $data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '', $Company_id);

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;
        $Merchandize_Partner_ID = $user_details->Merchandize_Partner_ID;
        $data['Merchandize_Partner_ID'] = $Merchandize_Partner_ID;
        // $data['Super_seller']=$Super_seller;



        if ($_REQUEST != NULL) {
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Partner_id = $_REQUEST["Partner_id"];
          $partner_branches = $_REQUEST["partner_branches"];
          $Voucher_status = $_REQUEST["Voucher_status"];
         
          $data["Trans_Records"] = $this->Report_model->get_partner_redemption_details($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status);

        }

        $this->load->view("Reports/Partner_Redemption_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Partner_redemption_receipt() {
      $this->load->model('master/currency_model');
      $Company_id = $this->input->post("Company_id");
      $Card_id = $this->input->post("Card_id");
      $Voucher_no = $this->input->post("Voucher_no");

      // echo "---Company_id--".$Company_id."--<br>";
      // echo "---Card_id--".$Card_id."--<br>";
      // echo "---Voucher_no--".$Voucher_no."--<br>";
      // die;

      $transaction_details = $this->Report_model->get_partener_update_voucher_status($Company_id, $Card_id, $Voucher_no);
      if ($transaction_details) {
        $data['transaction_details'] = $transaction_details;
      }
      $theHTMLResponse = $this->load->view('Reports/Show_partener_redemption_receipt', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('transactionReceiptHtml' => $theHTMLResponse)));
    }

    public function export_partner_redempion_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);


        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $Partner_id = $_REQUEST["Partner_id"];
        $partner_branches = $_REQUEST["partner_branches"];
        $Voucher_status = $_REQUEST["Voucher_status"];

        $Today_date = date("Y-m-d");

        $data["Trans_Records"] = $this->Report_model->get_partner_redemption_details_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status);


        $name = 'igain_partner_redemption_detail_rpt';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "Partner_Redemption_Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Partner Redemption Report');
          //$this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_partner_redemption_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************** Amit Work End *************************************** */

    /*     * **************************** Nilesh Work start ************************************ */

    public function Partner_Merchandzie_Catalogue_Report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['User_id'] = $session_data['userId'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        // $data['Current_balance'] = $session_data['Current_balance'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $Super_seller = $session_data['Super_seller'];
        $User_Id = $session_data['userId'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;

        $Country_details = $this->Report_model->get_dial_code($Country);

        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();

        $this->load->model('Catalogue/Catelogue_model');

        $data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '', $Company_id);

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        //$Super_seller = $user_details->Super_seller;
        $Merchandize_Partner_ID = $user_details->Merchandize_Partner_ID;
        $data['Merchandize_Partner_ID'] = $Merchandize_Partner_ID;
        $data['Super_seller'] = $Super_seller;

        if ($_REQUEST != NULL) {
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Partner_id = $_REQUEST["Partner_id"];
          $partner_branches = $_REQUEST["partner_branches"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $Delivery_method = $_REQUEST["Delivery_method"];
          $Voucher_status = $_REQUEST["Voucher_status"];
          // var_dump($Voucher_status);die;
          $report_type = $_REQUEST["report_type"];

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
          if ($report_type == 1) { //Details
            $data["Trans_Records"] = $this->Report_model->get_partner_merchandzie_catalogue_details($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $transaction_type_id, $Delivery_method, $start, $limit);

            $data["Count_Records"] = $this->Report_model->get_partner_merchandzie_catalogue_details($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $transaction_type_id, $Delivery_method, '', '');
          } else {
            $data["Trans_Records"] = $this->Report_model->get_partner_merchandzie_catalogue_summary($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $transaction_type_id, $Delivery_method, $start, $limit);

            $data["Count_Records"] = $this->Report_model->get_partner_merchandzie_catalogue_summary($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $transaction_type_id, $Delivery_method, '', '');
          }
        }
        $this->load->view("Reports/Partner_Merchandzie_Catalogue_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_partner_merchandzie_catalogue_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $Partner_id = $_REQUEST["Partner_id"];
        $partner_branches = $_REQUEST["partner_branches"];
        $transaction_type_id = $_REQUEST["transaction_type_id"];
        $Delivery_method = $_REQUEST["Delivery_method"];
        $Voucher_status = $_REQUEST["Voucher_status"];
        $Report_type = $_REQUEST["report_type"];

        // var_dump($report_type);die;

        $Today_date = date("Y-m-d");
        if ($Report_type == 1) { // Details
          $data["Trans_Records"] = $this->Report_model->get_partner_merchandzie_catalogue_details_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $transaction_type_id, $Delivery_method);
        } else {
          $data["Trans_Records"] = $this->Report_model->get_partner_merchandzie_catalogue_summary_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $transaction_type_id, $Delivery_method);
        }
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "Partner_Merchandzie_Catalogue_Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        // $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Partner Catalogue Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_partner_merchandzie_catalogue_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************** Nilesh Work End ************************************ */
    /*     * *********************** Nilesh Work Start partner shipping report *********************** */

    public function Partner_Shipping_Catalogue_Report() {
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
        $Super_seller = $session_data['Super_seller'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;

        $Country_details = $this->Report_model->get_dial_code($Country);

        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();

        $this->load->model('Catalogue/Catelogue_model');

        $data["Partner_Records"] = $this->Report_model->Get_Company_Shipping_Partners('', '', $Company_id);

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        //$Super_seller = $user_details->Super_seller;
        $Merchandize_Partner_ID = $user_details->Merchandize_Partner_ID;
        $data['Merchandize_Partner_ID'] = $Merchandize_Partner_ID;
        $data['Super_seller'] = $Super_seller;

        if ($_REQUEST != NULL) {
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Partner_id = $_REQUEST["Partner_id"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $report_type = $_REQUEST["report_type"];

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
          if ($report_type == 1) { //Details
            $data["Trans_Records"] = $this->Report_model->get_partner_shipping_catalogue_details($Company_id, $start_date, $end_date, $Partner_id, $transaction_type_id, $start, $limit);

            $data["Count_Records"] = $this->Report_model->get_partner_shipping_catalogue_details($Company_id, $start_date, $end_date, $Partner_id, $transaction_type_id, '', '');
          } else { //Summary
            $data["Trans_Records"] = $this->Report_model->get_partner_shipping_catalogue_summary($Company_id, $start_date, $end_date, $Partner_id, $transaction_type_id, $start, $limit);

            $data["Count_Records"] = $this->Report_model->get_partner_shipping_catalogue_summary($Company_id, $start_date, $end_date, $Partner_id, $transaction_type_id, '', '');
          }
        }
        $this->load->view("Reports/Partner_shipping_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_partner_shipping_catalogue_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $Partner_id = $_REQUEST["Partner_id"];
        $transaction_type_id = $_REQUEST["transaction_type_id"];
        $Report_type = $_REQUEST["report_type"];

        // var_dump($report_type);die;

        $Today_date = date("Y-m-d");
        if ($Report_type == 1) { // Details
          $data["Trans_Records"] = $this->Report_model->get_partner_shipping_catalogue_details_exports($Company_id, $start_date, $end_date, $Partner_id, $transaction_type_id);
        } else {
          $data["Trans_Records"] = $this->Report_model->get_partner_shipping_catalogue_summary_exports($Company_id, $start_date, $end_date, $Partner_id, $transaction_type_id);
        }
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "Partner_Shipping_Catalogue_Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        // $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Partner Shipping Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_partenr_shipping_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * *********************** Nilesh Work End shipping report******************************* */
    /*     * ****************************Sandeep Work Start************************************ */

    /*     * *****Inactive Users Report************************ */

    public function inactive_users_report() 
	{
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

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

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
        $data['worry_customers'] = $this->Report_model->get_worry_customers($Company_id);
        $data["Users_Records"] = $Users_Records;
        $data["pagination"] = $this->pagination->create_links();
        if (count($Users_Records) > 0) {
          $this->session->set_flashdata("error_code", "");

          $this->load->view("Reports/inactive_users", $data);
        } else {
          $this->session->set_flashdata("error_code", "There Is No Inactive Users!");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function activate_user() 
	{
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
      // $CompID = $this->input->get("CompID");
      $CompID = $Company_id;
      $Usertype = $this->input->get("Usertype");
      
      if ($Usertype == 'Merchant') 
	  {
        $Usertype = 2;
      }
	  else if ($Usertype == 'Member') 
	  {
        $Usertype = 1;
      }
      if ($Usertype == 2) 
	  {
        $Total_merchants = $this->Enroll_model->get_total_merchant($CompID);
        $company_details = $this->Igain_model->get_company_details($CompID);
      }
      // echo"Total_merchants---".$Total_merchants."---company_details---".$company_details->Seller_licences_limit;
      if ($Usertype == 2) 
	  {
        if ($Total_merchants >= $company_details->Seller_licences_limit && $Usertype == 2) 
		{
          $activate = false;
          // $Result101 = array("Error_flag" => 101);
          // $this->output->set_output(json_encode($Result101));
		  $this->session->set_flashdata("error_code","You Can not Activate this Merchant because you have been Max no. of Merchant(s) Enrolled");
		  redirect("Reportc/inactive_users_report");
        }
		else
		{
          $activate = $this->Igain_model->activate_user($EnrollID, $CompID);
          if ($activate == true) 
		  {
            // $Result127 = array("Error_flag" => 1001);
            // $this->output->set_output(json_encode($Result127));			
			$this->session->set_flashdata("success_code","User Activated Successfully");
		    redirect("Reportc/inactive_users_report");
          }
		  else 
		  {
            // $Result99 = array("Error_flag" => 99);
            // $this->output->set_output(json_encode($Result99));
			$this->session->set_flashdata("error_code","User Could not Activated Successfully");
		    redirect("Reportc/inactive_users_report");
          }
        }
      } 
	  else if ($Usertype == 1) 
	  {
        $activate = $this->Igain_model->activate_user($EnrollID, $CompID);
        if ($activate == true) 
		{
          // $Result1278 = array("Error_flag" => 1001);
          // $this->output->set_output(json_encode($Result1278));
		  $this->session->set_flashdata("success_code","User Activated Successfully");
		  redirect("Reportc/inactive_users_report");
        }
		else 
		{
          // $Result991 = array("Error_flag" => 99);
          // $this->output->set_output(json_encode($Result991));
		  $this->session->set_flashdata("error_code","User Could not Activated Successfully");
		  redirect("Reportc/inactive_users_report");
        }
      }

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
      $data['worry_customers'] = $this->Report_model->get_worry_customers($Company_id);
      $data["pagination"] = $this->pagination->create_links();

      /* if($activate == true)	
        {
        $this->session->set_flashdata("error_code","User Activated Successfully!");

        }
        else
        {
        $this->session->set_flashdata("error_code","You Can not Activate this Merchant because you have been Max no. of Merchant(s) Enrolled!");
        }

        $this->load->view("Reports/inactive_users",$data);
        redirect(current_url()); */
    }

    public function export_inactive_user_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $Today_date = date("Y-m-d");

        // $Users_Records =  $this->Igain_model->get_inactive_users('','',$Company_id);
        $data["Users_Records"] = $this->Igain_model->get_inactive_users('', '', $Company_id);
        $Users_Records = $data["Users_Records"];
        //$userInfo[] = array();
        $i = 0;
        if (count($Users_Records) > 0) {
          foreach ($Users_Records as $user_info) {

            $userInfo[$i]['UserType'] = $user_info->User_type;
            $userInfo[$i]['UserName'] = $user_info->First_name . " " . $user_info->Middle_name . " " . $user_info->Last_name;
            $userInfo[$i]['MembershipId'] = $user_info->Card_id;
            $userInfo[$i]['City'] = $user_info->City;
            $userInfo[$i]['PhoneNo'] = App_string_decrypt($user_info->Phone_no);
            $userInfo[$i]['TotalLoyaltyPoints'] = $user_info->Current_balance;
            $userInfo[$i]['TotalReddemPoints'] = $user_info->Total_reddems;
            $userInfo[$i]['TotalBonusPoints'] = $user_info->Total_topup_amt;

            $i++;
          }
        }

        $data["Seller_report_details"] = $userInfo;
        $cmp_name = str_replace(' ', '_', $Company_name);
        // $Export_file_name = $Today_date."_inactive_users_report";
        $Export_file_name = $cmp_name . "_" . $Today_date . "_Inactive_Users_report";

        $data["Report_date"] = $Today_date;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Inactive_Users_report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Users_Records"][0] as $key => $field) {
            $fields[] = $key;
          }
          $col = 0;
          foreach ($fields as $field) {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
          }
          //Fetching the table data
          $row = 2;
          foreach ($data["Users_Records"] as $data1) {
            $col = 0;
            foreach ($fields as $field) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
              $col++;
            }
            $row++;
          }
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
          $html = $this->load->view('Reports/pdf_inactive_users_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_worry_user_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];

        $data['Company_name'] = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $Today_date = date("Y-m-d");

        // $Users_Records =  $this->Igain_model->get_inactive_users('','',$Company_id);
        $data['worry_customers'] = $this->Report_model->get_worry_customers($Company_id);
        $data['temp_worry_customers'] = $this->Report_model->get_temptable_worry_customers($Company_id);
        // $Export_file_name = $Today_date."_inactive_worry_members_report";
        $cmp_name = str_replace(' ', '_', $data['Company_name']);
        $Export_file_name = $cmp_name . "_Member_Worry_report";

        $data["Report_date"] = $Today_date;
        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Worry Members');
          // $this->excel->stream($Export_file_name.'.xls', $data["temp_worry_customers"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["temp_worry_customers"][0] as $key => $field) {
            $fields[] = $key;
          }
          $col = 0;
          foreach ($fields as $field) {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
          }
          //Fetching the table data
          $row = 2;
          foreach ($data["temp_worry_customers"] as $data1) {
            $col = 0;
            foreach ($fields as $field) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
              $col++;
            }
            $row++;
          }
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
          $html = $this->load->view('Reports/pdf_inactive_worry_users_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * *****Inactive Users Report ************************ */

    /*     * ***** Deposit Topup Report ************************ */

    public function deposite_topup_report() {
      $session_data = $this->session->userdata('logged_in');
      $data['username'] = $session_data['username'];
      $data['enroll'] = $session_data['enroll'];
      $data['Company_id'] = $session_data['Company_id'];
      $Company_id = $session_data['Company_id'];
      $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
      $Logged_user_id = $session_data['userId'];
      $data['Country_id'] = $session_data['Country_id'];
      $data['Company_name'] = $session_data['Company_name'];
      $data['LogginUserName'] = $session_data['Full_name'];
      $Company_id = $session_data['Company_id'];

      $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

      $get_transaction_type2 = $this->Igain_model->get_transaction_type();
      $data['Transaction_type_array'] = $get_transaction_type2;

      $get_sellers = $this->Igain_model->get_company_sellers($session_data['Company_id']);
      $data['Seller_array'] = $get_sellers;

      if ($_POST == NULL) {
        $data['start_date'] = "";
        $data['end_date'] = "";



        $data['results2'] = "";

        //$this->load->view("Reports/deposit_topup_report",$data);
      } else {

        //$Company_id = $this->input->post("Company_id");
        $Trans_type = $this->input->post("Trans_type");
        $seller_id = $this->input->post("seller_id");
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");
        /*
          echo "---start_date--".$start_date."---<br>";

          echo "---end_date--".$end_date."---<br>";
          echo "---Company_id20--".$Company_id20."---<br>";
          echo "---Trans_type--".$Trans_type."---<br>";
          echo "---seller_id--".$seller_id."---<br>";

          $get_transaction_type2 = $this->Igain_model->get_transaction_type_details($Trans_type);
          $data['Transaction_type_array'] = $get_transaction_type2;

          $get_sellers = $this->Igain_model->get_enrollment_details($seller_id);
          $data['Seller_array'] = $get_sellers;
         */
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Reportc/deposite_topup_report";
        $total_row = $this->Report_model->get_deposit_transactions_count($Company_id, $start_date, $end_date, $Trans_type, $seller_id);
        $config["total_rows"] = $total_row;
        $config["per_page"] = 10;
        $config["uri_segment"] = 10;
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
        /* -----------------------Pagination--------------------- */

        $data['results2'] = $this->Report_model->get_deposit_transactions($config["per_page"], $page, $Company_id, $start_date, $end_date, $Trans_type, $seller_id, $data['enroll']);
      }

      $this->load->view("Reports/deposit_topup_report", $data);
    }

    public function export_deposit_topup_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];

        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $Today_date = date("Y-m-d");


        $temp_table = $data['enroll'] . 'deposit_topup_rpt';

        $data["Seller_report_details"] = $this->Report_model->get_deposit_topup_records($temp_table);
        $Export_file_name = $Today_date . "_" . $temp_table;
        $data["Report_date"] = $Today_date;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('test worksheet');
          $this->excel->stream($Export_file_name . '.xls', $data["Seller_report_details"]);
        } else {
          $html = $this->load->view('Reports/pdf_deposit_topup_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * ***** Deposit Topup Report ************************ */

    /*     * ***** Customer Visit Report ************************ */

    public function customer_visits_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $select_cust = $_REQUEST["select_cust"];
          /* echo "start_date  ".$start_date;
            echo "end_date  ".$end_date; */

          if ($select_cust == 2) {//SINGLE CUSTOMER
            $Single_cust_membership_id = $this->input->post("Single_cust_membership_id");
          } else {
            $Single_cust_membership_id = 0;
          }

          $data["visit_records"] = $this->Report_model->get_cust_visit_details($Company_id, $Single_cust_membership_id, $start_date, $end_date);
        }
        //print_r($data["Company_details"]);
        $this->load->view("Reports/Customer_visits_report", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * ***** Customer Visit Report ************************ */

    /*     * **************************** Sandeep Work End ************************************ */

    /*     * **********************************************Akshay Functions********************************************* */

    public function merchant_report() {

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

        $data["Company_details"] = $this->Igain_model->get_company_details($data['Company_id']);

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

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

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $Today_date = date("Y-m-d");

        if ($_REQUEST == NULL) {
          $data["Seller_report_details"] = NULL;
          $this->load->view("Reports/merchant_report", $data);
        } else {

          $report_type = $_REQUEST["report_type"];
          if ($report_type == 1) {
            $temp_table = $data['enroll'] . 'seller_igain_summary_rpt';
          } else {
            $temp_table = $data['enroll'] . 'seller_igain_detail_rpt';
          }
          $data["Report_type"] = $report_type;
          if (!isset($_REQUEST["page_limit"])) {
            $start_date = $_REQUEST["start_date"];
            $data["start_date"] = $_REQUEST["start_date"];
            $end_date = $_REQUEST["end_date"];
            $data["end_date"] = $_REQUEST["end_date"];
            $Company_id = $_REQUEST["Company_id"];
            $seller_id = $_REQUEST["seller_id"];
            $transaction_type_id = $_REQUEST["transaction_type_id"];

            // $result = $this->Report_model->get_merchant_report($start_date,$end_date,$Company_id,$seller_id,$transaction_type_id,$report_type,$data['enroll']);
            /*             * **********Change AMIT 18-02-2017*********** */
            if ($Sub_seller_admin == 1 && $Logged_user_id == 2 && $seller_id == 0 && $superSellerFlag != 1) {
              $flag = 0;
              foreach ($data["company_sellers"] as $sellers) {
                $result = $this->Report_model->get_merchant_report($start_date, $end_date, $Company_id, $sellers['Enrollement_id'], $transaction_type_id, $report_type, $data['enroll'], $flag);
                $flag++;
              }
            } else {
              $flag = 0;
              $result = $this->Report_model->get_merchant_report($start_date, $end_date, $Company_id, $seller_id, $transaction_type_id, $report_type, $data['enroll'], $flag);
            }
            /*             * ************************************* */

            if ($result > 0) {
              $start_date1 = date("Y-m-d", strtotime($start_date));
              $end_date1 = date("Y-m-d", strtotime($end_date));



              $start = 0;
              $limit = 10;

              $data["Seller_report_details"] = $this->Report_model->get_seller_report_details($temp_table, $report_type, $start, $limit);
              $data["Count_Records"] = $this->Report_model->get_seller_report_details($temp_table, $report_type, '', '');
              // $data["pagination"] = $this->pagination->create_links();
              // $Export_file_name = $Today_date."_".$temp_table;
              // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);
            } else {
              $data["Seller_report_details"] = NULL;
            }
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
            $data["Seller_report_details"] = $this->Report_model->get_seller_report_details($temp_table, $report_type, $start, $limit);
            $data["Count_Records"] = $this->Report_model->get_seller_report_details($temp_table, $report_type, '', '');
          }
          $this->load->view("Reports/merchant_report", $data);
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

        $Report_type = $_GET['Report_type'];
        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_GET['start_date']));
        $end_date = date("Y-m-d", strtotime($_GET['end_date']));
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Today_date = date("Y-m-d");
        if ($Report_type == 1) {
          $temp_table = $data['enroll'] . 'seller_igain_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'seller_igain_detail_rpt';
        }
        $data["Seller_report_details"] = $this->Report_model->get_seller_excel_report_details($temp_table, $Report_type);
        // $Export_file_name = $Today_date."_".$temp_table;
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Merchant_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Merchant Reports');
          // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);


          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Seller_report_details"][0] as $key => $field) {
            $fields[] = $key;
          }
          $col = 0;
          foreach ($fields as $field) {
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
          }
          //Fetching the table data
          $row = 2;
          foreach ($data["Seller_report_details"] as $data1) {
            $col = 0;
            foreach ($fields as $field) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
              $col++;
            }
            $row++;
          }
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
          $html = $this->load->view('Reports/pdf_merchant_report', $data, true);
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
		$Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
		
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        /*         * ******AMIT 3-04-2017*********** */
        $data["Segments_list"] = $this->Segment_model->Segment_list('', '', $data['Company_id']);
        /*         * *************************** */
        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Value_type = $_REQUEST["Value_type"];
          $Operatorid = $_REQUEST["Operatorid"];
          $Criteria = $_REQUEST["Criteria"];
          $Criteria_value = $_REQUEST["Criteria_value"];
          $Segment_code = $_REQUEST["Segment_code"];
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
          //echo "Segment_code ".$Segment_code;
          if ($Segment_code != "") {
            $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);
            //

            $all_customers = $this->Igain_model->get_all_customers($Company_id);
            foreach ($all_customers as $row) {
              // echo "<b>First_name ".$row["First_name"]."</b>";
              $Applicable_array[] = 0;

              unset($Applicable_array);
              //print_r($Applicable_array);
              foreach ($Get_segments2 as $Get_segments) {
                // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                // echo "<br>";

                if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                  $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                  // echo "****Age--".$lv_Cust_value;
                }

                if ($Get_segments->Segment_type_id == 2) {//Sex
                  $lv_Cust_value = $row['Sex'];
                  // echo "****Sex ".$lv_Cust_value;
                }
                if ($Get_segments->Segment_type_id == 3) {//Country
                  $lv_Country_id = $row['Country_id'];
                  // echo "****Country_id ".$lv_Country_id;
                  $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                  $lv_Cust_value = $currency_details->Country_name;
                  // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 4) {//District
                  $lv_Cust_value = $row['District'];

                  // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 5) {//State
                  $lv_Cust_value = $row['State'];

                  // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 6) {//city
                  $lv_Cust_value = $row['City'];

                  // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                  if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                    $Get_segments->Value = $lv_Cust_value;
                  }
                }
                if ($Get_segments->Segment_type_id == 7) {//Zipcode
                  $lv_Cust_value = $row['Zipcode'];

                  // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                  $lv_Cust_value = $row['total_purchase'];

                  // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                  $lv_Cust_value = $row['Total_reddems'];

                  // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                  $lv_start_date = $row['joined_date'];
                  $lv_end_date = date("Y-m-d");
                  $lv_transaction_type_id = 2;
                  $lv_Tier_id = $row['Tier_id'];

                  $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                  foreach ($Trans_Records as $Trans_Records) {
                    $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                  }

                  // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                  $lv_start_date = $row['joined_date'];
                  $lv_end_date = date("Y-m-d");
                  $lv_transaction_type_id = 2;
                  $lv_Tier_id = $row['Tier_id'];

                  $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                  foreach ($Trans_Records as $Trans_Records) {
                    $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                  }
                  $lv_Cust_value = max($lv_Max_amt);
                  // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                }
                if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                  $tUnixTime = time();
                  list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                  $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                  $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                  // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                }

                $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                $Applicable_array[] = $Get_segments;
              }
              // print_r($Applicable_array);
              if (!in_array(0, $Applicable_array, true)) {
                // echo "<br>Access";
                $Applicable_enroll_array[] = $row["Enrollement_id"];
                $Applicable_enroll_card_array[] = $row["Card_id"];
                $Customer_array = implode(",", $Applicable_enroll_array);
                $Customer_card_array = implode(",", $Applicable_enroll_card_array);
              }
            }
            if (count($Customer_array) != 0) {

              // echo "<br>Access";
              $data["Trans_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, $start, $limit, $Customer_array);

              $data["Count_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, '', '', $Customer_array);
            }
          } else {
            $data["Trans_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, $start, $limit, 0);

            $data["Count_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, '', '', 0);
          }
        }

        $this->load->view("Reports/Customer_high_value_trans_report_view", $data);
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

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
		$Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
		
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $lv_Company_id = $_REQUEST["Company_id"];
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $Value_type = $_REQUEST["Value_type"];
        $Operatorid = $_REQUEST["Operatorid"];
        $Criteria = $_REQUEST["Criteria"];
        $Criteria_value = $_REQUEST["Criteria_value"];
        $Criteria_value2 = $_REQUEST["Criteria_value2"];
        $Segment_code = $_REQUEST["Segment_code"];



        $Today_date = date("Y-m-d");

        // $data["Trans_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id,$start_date,$end_date,$Value_type,$Operatorid,$Criteria,$Criteria_value,$Criteria_value2,'','');	
        if ($Segment_code != "") {
          $Get_segments2 = $this->Segment_model->edit_segment_code($Company_id, $Segment_code);
          //

          $all_customers = $this->Igain_model->get_all_customers($Company_id);
          foreach ($all_customers as $row) {
            // echo "<b>First_name ".$row["First_name"]."</b>";
            $Applicable_array = array();
            foreach ($Get_segments2 as $Get_segments) {
              // echo "<br>".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
              // echo "<br>";

              if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                $lv_Cust_value = date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
                // echo "****Age--".$lv_Cust_value;
              }

              if ($Get_segments->Segment_type_id == 2) {//Sex
                $lv_Cust_value = $row['Sex'];
                // echo "****Sex ".$lv_Cust_value;
              }
              if ($Get_segments->Segment_type_id == 3) {//Country
                $lv_Country_id = $row['Country_id'];
                // echo "****Country_id ".$lv_Country_id;
                $currency_details = $this->currency_model->edit_currency($lv_Country_id);
                $lv_Cust_value = $currency_details->Country_name;
                // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                  $Get_segments->Value = $lv_Cust_value;
                }
              }
              if ($Get_segments->Segment_type_id == 4) {//District
                $lv_Cust_value = $row['District'];

                // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                  $Get_segments->Value = $lv_Cust_value;
                }
              }
              if ($Get_segments->Segment_type_id == 5) {//State
                $lv_Cust_value = $row['State'];

                // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                  $Get_segments->Value = $lv_Cust_value;
                }
              }
              if ($Get_segments->Segment_type_id == 6) {//city
                $lv_Cust_value = $row['City'];

                // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                  $Get_segments->Value = $lv_Cust_value;
                }
              }
              if ($Get_segments->Segment_type_id == 7) {//Zipcode
                $lv_Cust_value = $row['Zipcode'];

                // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
              }
              if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                $lv_Cust_value = $row['total_purchase'];

                // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
              }
              if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                $lv_Cust_value = $row['Total_reddems'];

                // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
              }
              if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                $lv_start_date = $row['joined_date'];
                $lv_end_date = date("Y-m-d");
                $lv_transaction_type_id = 2;
                $lv_Tier_id = $row['Tier_id'];

                $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $row["Enrollement_id"], $lv_start_date, $lv_end_date, $lv_transaction_type_id, $lv_Tier_id, '', '');
                foreach ($Trans_Records as $Trans_Records) {
                  $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                }

                // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
              }
              if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                $lv_start_date = $row['joined_date'];
                $lv_end_date = date("Y-m-d");
                $lv_transaction_type_id = 2;
                $lv_Tier_id = $row['Tier_id'];

                $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $lv_start_date, $lv_end_date, $row["Enrollement_id"], $lv_transaction_type_id, $lv_Tier_id, '', '');
                foreach ($Trans_Records as $Trans_Records) {
                  $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                }
                $lv_Cust_value = max($lv_Max_amt);
                // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
              }
              if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                $tUnixTime = time();
                list($year, $month, $day) = EXPLODE('-', $row["joined_date"]);
                $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);
                // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
              }

              $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

              $Applicable_array[] = $Get_segments;
            }
            // print_r($Applicable_array);

            if (!in_array(0, $Applicable_array, true)) {

              // echo "<br>Access";
              $Applicable_enroll_array[] = $row["Enrollement_id"];
              $Customer_array = implode(",", $Applicable_enroll_array);
            }
          }
          if (count($Customer_array) != 0) {
            $data["Trans_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, '', '', $Customer_array);
          }
        } else {
          $data["Trans_Records"] = $this->Report_model->get_cust_high_value_trans_report($Company_id, $start_date, $end_date, $Value_type, $Operatorid, $Criteria, $Criteria_value, $Criteria_value2, '', '', 0);
        }


        $name = 'igain_member_high_value_report';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_High_Value_Trans_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member High Value Trans. Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
			  
			if($key == "Enrollement_id") {
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
          $html = $this->load->view('Reports/pdf_member_high_value_trans_report', $data, true);
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
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $superSellerFlag = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        

        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
		$data['Country_id'] = $session_data['Country_id'];
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
		
        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        /* if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        } */
        if ($Logged_user_id > 2 || $superSellerFlag == 1) {

          // $data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'],$data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($session_data['Company_id']);
          //get_company_sellers_and_staff
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {

          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
          // var_dump($data["company_sellers"]);
        } else {
          // $data["company_sellers"] = $this->Igain_model->get_seller_details($data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }
        if (isset($_REQUEST["page_limit"])) {
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          // $start=0;
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
          $seller_id = $_REQUEST["seller_id"];
          $lv_Company_id = $_REQUEST["Company_id"];

          $data["Trans_Records"] = $this->Report_model->get_cust_enrollment_report($lv_Company_id, $start_date, $end_date, $seller_id, $start, $limit);
          $data["Count_Records"] = $this->Report_model->get_cust_enrollment_report($lv_Company_id, $start_date, $end_date, $seller_id, '', '');
        }

        $this->load->view("Reports/Customer_enrollment_report_view", $data);
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


        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $seller_id = $_REQUEST['seller_id'];

        $Today_date = date("Y-m-d");

        $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
        $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));

        $data["Trans_Records"] = $this->Report_model->get_cust_enrollment_report($Company_id, $start_date, $end_date, $seller_id, '', '');

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
		$data['Country_id'] = $session_data['Country_id'];
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
		
        $name = 'igain_member_enrollment_report';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_Enrollment_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        $data["Company_id"] = $Company_id;


        $reportHeader = array();
        $reportHeader[] = "Enrollment Date";
        $reportHeader[] = "Membership ID";
        $reportHeader[] = "First_name";
        $reportHeader[] = "Middle_name";
        $reportHeader[] = "Last_name";
        $reportHeader[] = "Current_address";
        $reportHeader[] = "City";
        $reportHeader[] = "District";
        $reportHeader[] = "State";
        $reportHeader[] = "Phone_no";
        $reportHeader[] = "User_email_id";
        $reportHeader[] = "Total_current_balance";
        $reportHeader[] = "Total_Purchase_Amount";
        $reportHeader[] = "Total_Gained_Points";
        $reportHeader[] = "Total_Redeemed_Points";
        $reportHeader[] = "Total_balance_to_pay";
        $reportHeader[] = "User_activated";
        $reportHeader[] = "Enrolled_by";

        if ($data["Company_details"]->Label_1 != NULL) {
          $reportHeader[] = $data["Company_details"]->Label_1;
        }
        if ($data["Company_details"]->Label_2 != NULL) {
          $reportHeader[] = $data["Company_details"]->Label_2;
        }
        if ($data["Company_details"]->Label_3 != NULL) {
          $reportHeader[] = $data["Company_details"]->Label_3;
        }
        if ($data["Company_details"]->Label_4 != NULL) {
          $reportHeader[] = $data["Company_details"]->Label_4;
        }
        if ($data["Company_details"]->Label_5 != NULL) {
          $reportHeader[] = $data["Company_details"]->Label_5;
        }

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Enrollment Report');
          // $this->excel->SetHeader($reportHeader);
          // $this->excel->stream10($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_member_enrollment_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Customer_points_expiry() {
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
          $Expiry_flag = $_REQUEST["Expiry_flag"];
          $days = $_REQUEST["days"];
          $lv_Company_id = $_REQUEST["Company_id"];
          if ($Expiry_flag == 1) {//Points Expiry
            $data["Trans_Records"] = $this->Report_model->get_cust_expiry_report($lv_Company_id, $start_date, $end_date, $start, $limit);
          //  $data["Count_Records"] = $this->Report_model->get_cust_expiry_report($lv_Company_id, $start_date, $end_date, '', '');
          } else {
            $data["Trans_Records"] = $this->Report_model->get_all_cust_last_points_used($lv_Company_id, $start, $limit);
          //  $data["Count_Records"] = $this->Report_model->get_all_cust_last_points_used($lv_Company_id, '', '');
          }
        }

        $this->load->view("Reports/Customer_points_expiry_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_Customer_points_expiry() {
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
        $Expiry_flag = $_REQUEST["Expiry_flag"];
        $days = $_REQUEST["days"];
        $lv_Company_id = $_REQUEST["Company_id"];
        $Points_expiry_period = $_REQUEST["Points_expiry_period"];
        $Deduct_points_expiry = $_REQUEST["Deduct_points_expiry"];

        if ($Expiry_flag == 1) {//Points Expiry
          $data["Trans_Records"] = $this->Report_model->get_cust_expiry_report($lv_Company_id, $start_date, $end_date, '', '');
        } else {
          $data["Trans_Records"] = $this->Report_model->get_all_cust_last_points_used($lv_Company_id, '', '');
        }

        $name = 'igain_members_points_expiry_report';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Member_Points_Expiry_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Enrollment Report');
          // $this->excel->SetHeader($reportHeader);
          // $this->excel->stream10($Export_file_name.'.xls', $data["Trans_Records"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_members_points_expiry_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************AMIT Functions END 26-05-2016********************************* */
    /*     * **************************AMIT Functions Start 11-05-2017********************************* */

    public function Booking_appointment_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $lv_Company_id = $session_data['Company_id'];
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

          $To_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));
          $From_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
          $data["Trans_Records"] = $this->Report_model->get_all_cust_booking_appointments($From_date, $To_date, $start, $limit);
          $data["Count_Records"] = $this->Report_model->get_all_cust_booking_appointments($From_date, $To_date, '', '');
        }

        $this->load->view("Reports/Booking_appointment_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_Booking_appointment_report() {
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


        $data["Trans_Records"] = $this->Report_model->get_all_cust_booking_appointments($start_date, $end_date, '', '');

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_booking_appointment_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Booking Appointment Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          $html = $this->load->view('Reports/pdf_booking_appointment_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /****************************AMIT Functions END 11-05-2017********************************* */
    /*********************Nilesh change Log Table audit tracking report 26-06-2017********************** */

    public function Audit_Tracking_Report() 
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
        $Company_id = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        if ($data['userId'] == 3)
		{
          $data["Transaction_from"] = $this->Igain_model->get_transaction_from(0);
        } 
		else 
		{
          $data["Transaction_from"] = $this->Igain_model->get_transaction_from($Company_id);
        }
        if($data['userId'] == 3) 
		{
          $data["User_type"] = $this->Igain_model->get_user_type(0);
        } 
		else 
		{
          $user_type = 2;
          $data["User_type"] = $this->Igain_model->get_user_type($user_type);
        }
        if (isset($_REQUEST["page_limit"])) 
		{
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          // $start=0;
          if ($_REQUEST["page_limit"] == 0) 
		  {//All
            $limit = "";
            $start = "";
          }
        } 
		else 
		{
          $start = 0;
          $limit = 10;
        }
        if($_REQUEST != NULL)
		{
          $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
          $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));
          $Transaction_from = $_REQUEST["Transaction_from"];
          $enter_user = $_REQUEST["enter_user"];
          $User_type = $_REQUEST["User_type"];
          $Mode = $_REQUEST["Mode"];
          $lv_Company_id = $_REQUEST["Company_id"];

          $data["Audit_Tracking"] = $this->Report_model->Audit_Tracking_Report($data['Company_id'], $start_date, $end_date, $Transaction_from, $enter_user, $User_type, $Mode, $start, $limit);
		  
          $data["Count_Records"] = $this->Report_model->Audit_Tracking_Report($data['Company_id'], $start_date, $end_date, $Transaction_from, $enter_user, $User_type, $Mode, '', '');
		 
          $this->load->view("Reports/Audit_Tracking_Report", $data);
        } 
		else 
		{
          $this->load->view("Reports/Audit_Tracking_Report", $data);
        }
      } 
	  else 
	  {
        redirect('Login', 'refresh');
      }
    }

    public function export_audit_tracking_report() 
	{
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $Today_date = date("Y-m-d");
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
        $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));
        $Transaction_from = $_REQUEST["Transaction_from"];
        $enter_user = $_REQUEST["enter_user"];
        $User_type = $_REQUEST["User_type"];
        $Mode = $_REQUEST["Mode"];
        $lv_Company_id = $_REQUEST["Company_id"];

        $data["Audit_Tracking"] = $this->Report_model->Audit_Tracking_Report($lv_Company_id, $start_date, $end_date, $Transaction_from, $enter_user, $User_type, $Mode, '', '');

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Audit_Tracking_report";
        $data["Report_date"] = $Today_date;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        $data["Company_id"] = $lv_Company_id;
        $data["Transaction_from"] = $Transaction_from;
        $data["User_type"] = $User_type;
        $data["Mode"] = $Mode;

        $reportHeader = array();
        $reportHeader[] = "Transction Date";
        $reportHeader[] = "Who did";
        $reportHeader[] = "User Type";
        $reportHeader[] = "What was Done";
        $reportHeader[] = "Menu Option";
        $reportHeader[] = "To Whom";
        $reportHeader[] = "Type of Operation";
        $reportHeader[] = "Operation Value";

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Audit Tracking Report');
          // $this->excel->SetHeader($reportHeader);
          // $this->excel->stream10($Export_file_name.'.xls', $data["Audit_Tracking"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Audit_Tracking"][0] as $key => $field) {
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
          foreach ($data["Audit_Tracking"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_audit_tracking_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /************************Nilesh Audit Tracking report 26-06-2017**************************** */
    /***************************Call Center Report********************************* */

    public function Cc_query_status_reports() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $data["query_type"] = $this->Igain_model->get_query_type($Company_id);

        if (isset($_REQUEST["page_limit"])) {
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          // $start=0;
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
          $Query_Type = $_REQUEST["Query_Type"];
          $Membership = $_REQUEST["Membership"];
          $Query_status = $_REQUEST["Query_status"];

          $data["Query_status"] = $this->Report_model->Cc_query_status_reports($data['Company_id'], $start_date, $end_date, $Query_Type, $Membership, $Query_status, $start, $limit);
          $data["Count_Records"] = $this->Report_model->Cc_query_status_reports($data['Company_id'], $start_date, $end_date, $Query_Type, $Membership, $Query_status, '', '');

          $this->load->view("Reports/Callcenter_query_status_report", $data);
        } else {
          $this->load->view("Reports/Callcenter_query_status_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_Cc_query_status_reports() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $Today_date = date("Y-m-d");
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_REQUEST["start_date"]));
        $end_date = date("Y-m-d", strtotime($_REQUEST["end_date"]));
        $Query_Type = $_REQUEST["Query_Type"];
        $Membership = $_REQUEST["Membership"];
        $Query_status1 = $_REQUEST["Query_status1"];
        $lv_Company_id = $_REQUEST["Company_id"];

        if ($Query_Type != "") {
          $QueryDetails = $this->CallCenter_model->get_query_details($Query_Type, $Company_id);
        }

        $data["Query_status"] = $this->Report_model->Cc_query_status_reports($Company_id, $start_date, $end_date, $Query_Type, $Membership, $Query_status1, '', '');

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Call_Center_Query_status_report";
        $data["Report_date"] = $Today_date;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        $data["Company_id"] = $lv_Company_id;
        if ($Query_status1 != NULL) {
          $data["Query_status1"] = $Query_status1;
        } else {
          $data["Query_status1"] = "Forward,Closed";
        }
        if ($Query_Type != NULL) {
          $data["Query_Type"] = $QueryDetails->Query_type_name;
        } else {
          $data["Query_Type"] = "All Query Type ";
        }

        $reportHeader = array();
        $reportHeader[] = "Querylog Ticket";
        $reportHeader[] = "Membership Id";
        $reportHeader[] = "Customer Name";
        $reportHeader[] = "Assign / Forwarded Query";
        $reportHeader[] = "Query Type";
        $reportHeader[] = "Sub Query";
        $reportHeader[] = "Query Details";
        $reportHeader[] = "Query Interaction";
        $reportHeader[] = "Call Type";
        $reportHeader[] = "Communication Type";
        $reportHeader[] = "Query Status";
        $reportHeader[] = "Query Registered Date";
        $reportHeader[] = "Close Date";

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Call Center Query Status Report');
          // $this->excel->SetHeader($reportHeader);
          // $this->excel->stream10($Export_file_name.'.xls', $data["Query_status"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Query_status"][0] as $key => $field) {
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
          foreach ($data["Query_status"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_callcenter_query_status', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Cc_member_interaction_reports() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $data['Seller_topup_access'] = $session_data['Seller_topup_access'];
        $data['Country_id'] = $session_data['Country_id'];
        $data['Company_name'] = $session_data['Company_name'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $Company_id = $session_data['Company_id'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data["query_type"] = $this->Igain_model->get_query_type($Company_id);

        if (isset($_REQUEST["page_limit"])) {
          $limit = 10;
          $start = $_REQUEST["page_limit"] - 10;
          // $start=0;
          if ($_REQUEST["page_limit"] == 0) {//All
            $limit = "";
            $start = "";
          }
        } else {
          $start = 0;
          $limit = 10;
        }
        if ($_REQUEST != NULL) {
          $Query_Type = $_REQUEST["Query_Type"];
          $Membership = $_REQUEST["Membership"];
          $Sub_query_type = $_REQUEST["Sub_query_type"];

          $data["Member_interaction"] = $this->Report_model->Cc_member_interaction_reports($data['Company_id'], $Query_Type, $Membership, $Sub_query_type, $start, $limit);

          $data["Count_Records"] = $this->Report_model->Cc_member_interaction_reports($data['Company_id'], $Query_Type, $Membership, $Sub_query_type, '', '');

          $this->load->view("Reports/Callcenter_member_interaction_report", $data);
        } else {
          $this->load->view("Reports/Callcenter_member_interaction_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_Cc_member_interaction_reports() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $Today_date = date("Y-m-d");
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $Query_Type = $_REQUEST["Query_Type"];
        $Membership = $_REQUEST["Membership"];
        $Sub_query_type = $_REQUEST["Sub_query_type"];
        $lv_Company_id = $_REQUEST["Company_id"];

        if ($Query_Type != "") {
          $QueryDetails = $this->CallCenter_model->get_query_details($Query_Type, $Company_id);
        }
        $member_details = $this->CallCenter_model->get_cust_details($Membership, $Company_id);
        $Fullname = $member_details->First_name . ' ' . $member_details->Last_name;

        $data["Member_interaction"] = $this->Report_model->Cc_member_interaction_reports($Company_id, $Query_Type, $Membership, $Sub_query_type, '', '');

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $Today_date . "_Call_Center_Query _Interaction_report";
        $data["Report_date"] = $Today_date;
        $data["Company_name"] = $Company_name;
        $data["Company_id"] = $lv_Company_id;
        $data["Membership"] = $Membership;
        $data["membername"] = $Fullname;

        if ($Query_Type != NULL) {
          $data["Query_Type"] = $QueryDetails->Query_type_name;
        } else {
          $data["Query_Type"] = "All Query Type ";
        }


        $reportHeader = array();
        $reportHeader[] = "Querylog Ticket";
        $reportHeader[] = "Membership Id";
        $reportHeader[] = "Customer Name";
        $reportHeader[] = "Assign / Forwarded Query";
        $reportHeader[] = "Query Type";
        $reportHeader[] = "Sub Query";
        $reportHeader[] = "Query Details";
        $reportHeader[] = "Query Interaction";
        $reportHeader[] = "Call Type";
        $reportHeader[] = "Communication Type";
        $reportHeader[] = "Query Status";
        $reportHeader[] = "Query Registered Date";
        $reportHeader[] = "Close Date";

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Member Interaction Report');
          // $this->excel->SetHeader($reportHeader);
          // $this->excel->stream10($Export_file_name.'.xls', $data["Member_interaction"]);


          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Member_interaction"][0] as $key => $field) {
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
          foreach ($data["Member_interaction"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_callcenter_member_interaction', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * ************************Call Center Report*********************** */

    /*     * **************************Nilesh End******************************* */

    /*     * **************************RAVI SATRT******************************* */

    public function Get_Voucher_status() {
      $data['Voucher_status'] = $this->Report_model->Get_Voucher_status($this->input->post("Delivery_method"), $this->input->post("Company_id"));
      // var_dump($data['Voucher_status'] );die;
      $theHTMLResponse = $this->load->view('Catalogue/Get_Voucher_status', $data, true);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode(array('Get_Voucher_ststus2' => $theHTMLResponse)));
    }

    public function export_partner_update_voucher_status() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];


        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $Partner_id = $_REQUEST["Partner_id"];
        $partner_branches = $_REQUEST["partner_branches"];
        $Voucher_status = $_REQUEST["Voucher_status"];

        $Today_date = date("Y-m-d");

        $data["Trans_Records"] = $this->Report_model->get_partner_update_breakup_evoucher_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status);

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "Partner_Update_e_Voucher_Breakup_Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Update e-Voucher Breakup Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_partenr_update_evoucher_breakup_details', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************RAVI End******************************* */
    /*     * **************************Nilesh Start  MCCIA******************************* */

    public function Mccia_Partner_Redemption_Report() {
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
        $data['LogginUserName'] = $session_data['Full_name'];

        $Company_id = $session_data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data["transaction_types"] = $this->Igain_model->get_transaction_type();

        $this->load->model('Catalogue/Catelogue_model');
        $data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '', $Company_id);

        $user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
        $Enrollement_id = $user_details->Enrollement_id;
        $Super_seller = $user_details->Super_seller;
        $Merchandize_Partner_ID = $user_details->Merchandize_Partner_ID;
        $data['Merchandize_Partner_ID'] = $Merchandize_Partner_ID;
        $data['Super_seller'] = $Super_seller;



        if ($_REQUEST != NULL) {
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Partner_id = $_REQUEST["Partner_id"];
          $partner_branches = $_REQUEST["partner_branches"];
          $Voucher_status = $_REQUEST["Voucher_status"];
          $report_type = $_REQUEST["report_type"];
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

          if ($report_type == 1) { //Details
            $data["Trans_Records"] = $this->Report_model->get_mccia_partner_redemption_details($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $start, $limit);

            $data["Count_Records"] = $this->Report_model->get_mccia_partner_redemption_details($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, '', '');
          } else {
            $data["Trans_Records"] = $this->Report_model->get_mccia_partner_redemption_summary($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, $start, $limit);

            $data["Count_Records"] = $this->Report_model->get_mccia_partner_redemption_summary($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status, '', '');
          }
        }

        $this->load->view("Reports/Mccia_Partner_Redemption_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_mccia_partner_redempion_report_details() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];


        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $Partner_id = $_REQUEST["Partner_id"];
        $partner_branches = $_REQUEST["partner_branches"];
        $Voucher_status = $_REQUEST["Voucher_status"];
        $report_type = $_REQUEST["report_type"];

        $Today_date = date("Y-m-d");
        if ($report_type == 1) {
          $data["Trans_Records"] = $this->Report_model->get_mccia_partner_redemption_details_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status);
        } else {
          $data["Trans_Records"] = $this->Report_model->get_mccia_partner_redemption_summary_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status);
        }
        $name = 'igain_partner_redemption_detail_rpt';
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "Mccia Partner_Redemption_Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Mccia Partner Redemption Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]);
        } else {
          $html = $this->load->view('Reports/pdf_mccia_partner_redemption_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************************NILESH End MCCIA******************************* */
    /*     * *******************Nilesh Start for Beneficiary Transfer Point report********************* */

    public function Beneficiary_transfer_point_report() {
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
        // $data["Get_Beneficiary_Company"] = $this->Report_model->Get_Beneficiary_Company_Details();
        $data["Get_Beneficiary_Company1"] = $this->Report_model->Get_Beneficiary_Company_Details1($data['Company_id']);

        /* 	foreach($data["Get_Beneficiary_Company1"] as $Get_Beneficiary_C)
          {
          // $Reference_company_id = $Get_Beneficiary_C->Reference_company_id;
          echo 'Reference_company_id'.$Reference_company_id;
          $data["Get_Beneficiary_Company"] = $this->Report_model->Get_Beneficiary_Company_Details($Reference_company_id);
          foreach($data["Get_Beneficiary_Company"] as $Get_Beneficiary)
          {
          echo $Get_Beneficiary->E_Company_name;
          }
          } */
        $data["tier_details"] = $this->Igain_model->get_tier($Company_id);

        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";
          $lv_Company_id = $_REQUEST["Company_id"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          // $select_cust = $_REQUEST["select_cust"];
          $report_type = $_REQUEST["report_type"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          // $Tier_id = $_REQUEST["Tier_id"];
          // $Single_cust_membership_id = $_REQUEST["Single_cust_membership_id"];

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

          $Single_cust_membership_id = '';
          $Enrollement_id = 0;
          //$data["Trans_Records"] = $this->Igain_model->get_cust_trans_summary_all($Company_id);
          if ($report_type == 1) {//details

            $data["Trans_Records"] = $this->Report_model->get_Cust_beneficiary_transfer_point_details($lv_Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, $start, $limit);
            $data["Count_Records"] = $this->Report_model->get_Cust_beneficiary_transfer_point_details($lv_Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id, '', '');
          } else {
            $data["Trans_Records"] = $this->Report_model->get_cust_beneficiary_transfer_points_summary_all($lv_Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, $start, $limit);
            $data["Count_Records"] = $this->Report_model->get_cust_beneficiary_transfer_points_summary_all($lv_Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
          }
        }
        $this->load->view("Reports/Beneficiary_transfer_report_view", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_customer_Beneficiary_transfer_point_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_id = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $lv_Company_id = $_REQUEST["Company_id"];
        $Report_type = $_REQUEST['report_type'];
        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        // $select_cust =  $_REQUEST['select_cust'];
        $transaction_type_id = $_REQUEST['transaction_type_id'];
        // $Tier_id =  $_REQUEST['Tier_id'];

        $Today_date = date("Y-m-d");


        $Single_cust_membership_id = '';
        $Enrollement_id = 0;
		
        if ($Report_type == 1) {//details
		
          $data["Trans_Records"] = $this->Report_model->get_cust_beneficiary_transfer_points_details_reports($lv_Company_id, $start_date, $end_date, $Enrollement_id, $transaction_type_id, $Tier_id);
		  
        } else {
			
          $data["Trans_Records"] = $this->Report_model->get_cust_beneficiary_transfer_points_summary_all($lv_Company_id, $Enrollement_id, $start_date, $end_date, $transaction_type_id, $Tier_id,'','');
		  
        }

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Beneficiary Company Liability Report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;
        $data["Tier_id"] = $Tier_id;

        if ($pdf_excel_flag == 1) {
			
         /*  $this->excel->getActiveSheet()->setTitle('Beneficiary transfer Report');
          $this->excel->stream($Export_file_name . '.xls', $data["Trans_Records"]); */
		  
		  
		  
		  $this->excel->getActiveSheet()->setTitle('Update e-Voucher Breakup Report');
          // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Trans_Records"][0] as $key => $field) {
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
          foreach ($data["Trans_Records"] as $data1) {
            $col = 0;
            foreach ($fields as $field) {
              $this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data1->$field);
              $col++;
            }
            $row++;
          }
		  
		  
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
			
          $html = $this->load->view('Reports/pdf_Beneficiary_transfer_report_view', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");

        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * **************Nilesh End for Beneficiary Transfer Point report************** */

    /*     * *******************Nilesh Start 12-09-2018 Joy Report*********************** */

    public function Points_issuance_report() {
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
        $superSellerFlag = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);
        $data['Country_id'] = $session_data['Country_id'];
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        if ($Sub_seller_admin == 1) {
          $seller_id = $Sub_seller_admin;
        } else {
          $seller_id = $Sub_seller_Enrollement_id;
        }

       /* if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        } */
        
        if ($Logged_user_id > 2 || $superSellerFlag == 1) {
         // $data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'], $data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($data['Company_id']);
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {
          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
        } else {
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $Today_date = date("Y-m-d");

        if ($_REQUEST == NULL) {
          $data["Seller_report_details"] = NULL;
          $this->load->view("Reports/Points_issuanace_report", $data);
        } else {
          $report_type = $_REQUEST["report_type"];
          if ($report_type == 1) {
            $temp_table = $data['enroll'] . 'retailer_igain_points_issuance_summary_rpt';
          } else {
            $temp_table = $data['enroll'] . 'retailer_igain_points_issuance_detail_rpt';
          }
          $data["Report_type"] = $report_type;
          $start_date = $_REQUEST["start_date"];
          $data["start_date"] = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $data["start_date"] = $start_date;
          $data["end_date"] = $end_date;
          if (!isset($_REQUEST["page_limit"])) {
            $result = $this->Report_model->get_points_issuance_report($start_date, $end_date, $Company_id, $seller_id, $transaction_type_id, $report_type, $data['enroll']);

            if ($result > 0) {
              $start_date1 = date("Y-m-d", strtotime($start_date));
              $end_date1 = date("Y-m-d", strtotime($end_date));
              $start = 0;
              $limit = 10;

              $data["Seller_report_details"] = $this->Report_model->get_points_issuance_report_details($temp_table, $report_type, $start, $limit);

              $data["Count_Records"] = $this->Report_model->get_points_issuance_report_details($temp_table, $report_type, '', '');
            } else {
              $data["Seller_report_details"] = NULL;
            }
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
            $data["Seller_report_details"] = $this->Report_model->get_points_issuance_report_details($temp_table, $report_type, $start, $limit);
            $data["Count_Records"] = $this->Report_model->get_points_issuance_report_details($temp_table, $report_type, '', '');
          }
          $this->load->view("Reports/Points_issuanace_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_Points_issuance_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_name = $session_data['Company_name'];

        $Report_type = $_GET['Report_type'];
        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_GET['start_date']));
        $end_date = date("Y-m-d", strtotime($_GET['end_date']));
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        $data['Country_id'] = $session_data['Country_id'];
        $currency_details = $this->Igain_model->Get_Country_master($data['Country_id']);
        $data["Symbol_currency"] = $currency_details->Symbol_of_currency;
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Today_date = date("Y-m-d");
        if ($Report_type == 1) {
          $temp_table = $data['enroll'] . 'retailer_igain_points_issuance_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'retailer_igain_points_issuance_detail_rpt';
        }
        $data["Seller_report_details"] = $this->Report_model->Export_retailer_Coins_issuance_report($temp_table, $Report_type);
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Coins_issuanace_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Coins Issuance Reports');
          // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Seller_report_details"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_points_issuance_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Points_usage_report() {
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

        $data["loyalty_publishers"] = $this->Report_model->get_loyalty_publishers($data['Company_id']);

        $data["transaction_types"] = $this->Igain_model->get_transaction_type();
        $Today_date = date("Y-m-d");

        $Code_decode_type_id = 10; // Buy Miles Status
        $data["Buy_Miles_Status"] = $this->Report_model->Get_Buy_Miles_Status($Code_decode_type_id);

        if ($_REQUEST == NULL) {
			
          $data["Seller_report_details"] = NULL;
          $this->load->view("Reports/Points_usage_report", $data);
		  
        } else {
				// echo"---Points_usage_report-----".print_r($_REQUEST)."---<br>";
          $report_type = $_REQUEST["report_type"];
          if ($report_type == 1) {
            $temp_table = $data['enroll'] . 'publishers_igain_points_usage_summary_rpt';
          } else {
            $temp_table = $data['enroll'] . 'publishers_igain_points_usage_detail_rpt';
          }
          $data["Report_type"] = $report_type;
          $start_date = $_REQUEST["start_date"];
          $data["start_date"] = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];
          $transaction_type_id = $_REQUEST["transaction_type_id"];
          $Usage_status = $_REQUEST["Usage_status"];
          $data["start_date"] = $start_date;
          $data["end_date"] = $end_date;
          if (!isset($_REQUEST["page_limit"])) {
			  // echo "---Request----<br>";
            $result = $this->Report_model->get_points_usage_report($start_date, $end_date, $Company_id, $seller_id, $transaction_type_id, $Usage_status, $report_type, $data['enroll']);

            if ($result > 0) {
				
              $start_date1 = date("Y-m-d", strtotime($start_date));
              $end_date1 = date("Y-m-d", strtotime($end_date));
              $start = 0;
              $limit = 10;

              $data["Seller_report_details"] = $this->Report_model->get_points_usage_report_details($temp_table, $report_type, $start, $limit);

              $data["Count_Records"] = $this->Report_model->get_points_usage_report_details($temp_table, $report_type, '', '');
			  
            } else {
				
              $data["Seller_report_details"] = NULL;
			  
            }
			
          } else {
			  echo "---No Request----<br>";
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }
            $data["Seller_report_details"] = $this->Report_model->get_points_usage_report_details($temp_table, $report_type, $start, $limit);
            $data["Count_Records"] = $this->Report_model->get_points_usage_report_details($temp_table, $report_type, '', '');
			
          }
		  
          $this->load->view("Reports/Points_usage_report", $data);
		  
        }
		
      } else {
		  
        redirect('Login', 'refresh');
		
      }
    }

    public function export_Points_usage_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Company_name = $session_data['Company_name'];

        $Report_type = $_GET['Report_type'];
        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_GET['start_date']));
        $end_date = date("Y-m-d", strtotime($_GET['end_date']));
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Today_date = date("Y-m-d");
        if ($Report_type == 1) {
          $temp_table = $data['enroll'] . 'publishers_igain_points_usage_summary_rpt';
        } else {
          $temp_table = $data['enroll'] . 'publishers_igain_points_usage_detail_rpt';
        }
        $data["Seller_report_details"] = $this->Report_model->Export_points_usage_report($temp_table, $Report_type);
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Coins_usage_report";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Coins issuanace Reports');
          // $this->excel->stream($Export_file_name.'.xls', $data["Seller_report_details"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Seller_report_details"][0] as $key => $field) {
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
          $html = $this->load->view('Reports/pdf_points_usage_report', $data, true);
		  // echo"--html".$html;
		  // die;
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Company_points_liability_report() {
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

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        }
        if ($_REQUEST == NULL) {
          $data["points_liability_report"] = NULL;
          $this->load->view("Reports/Company_points_liability_report", $data);
        } else {
          $data['From_date'] = date("d-M-Y", strtotime($_REQUEST['start_date']));
          $data['To_date'] = date("d-M-Y", strtotime($_REQUEST['end_date']));
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $data["start_date"] = $_REQUEST["start_date"];
          $data["end_date"] = $_REQUEST["end_date"];

          $data['liability_report'] = $this->Report_model->get_points_liability_report($start_date, $end_date, $data['Company_id'], $data['enroll']);

          $data['liability_report1'] = $this->Report_model->get_points_liability_report1($start_date, $end_date, $data['Company_id'], $data['enroll']);

          $data['liability_report2'] = $this->Report_model->get_points_liability_report2($start_date, $end_date, $data['Company_id'], $data['enroll']);

          $data['liability_report3'] = $this->Report_model->get_points_liability_report3($start_date, $end_date, $data['Company_id'], $data['enroll']);

          $data['liability_report4'] = $this->Report_model->get_points_liability_report4($start_date, $end_date, $data['Company_id'], $data['enroll']);


          $this->load->view("Reports/Company_points_liability_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function export_company_points_liability_report() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Company_name = $session_data['Company_name'];

        $pdf_excel_flag = $_GET['pdf_excel_flag'];
        $start_date = date("Y-m-d", strtotime($_GET['start_date']));
        $end_date = date("Y-m-d", strtotime($_GET['end_date']));
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        $data["Company_details"] = $this->Igain_model->get_company_details($data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $Today_date = date("Y-m-d");

        $data['liability_report'] = $this->Report_model->get_points_liability_report($start_date, $end_date, $data['Company_id'], $data['enroll']);

        $data['liability_report1'] = $this->Report_model->get_points_liability_report1($start_date, $end_date, $data['Company_id'], $data['enroll']);

        $data['liability_report2'] = $this->Report_model->get_points_liability_report2($start_date, $end_date, $data['Company_id'], $data['enroll']);

        $data['liability_report3'] = $this->Report_model->get_points_liability_report3($start_date, $end_date, $data['Company_id'], $data['enroll']);

        $data['liability_report4'] = $this->Report_model->get_points_liability_report4($start_date, $end_date, $data['Company_id'], $data['enroll']);

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Points_liability_report";
        $data["Report_date"] = $Today_date;

        //Export Pdf
        $html = $this->load->view('Reports/pdf_company_liability_report', $data, true);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Merchant_billing_Settlement_report()
	{
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
        $superSellerFlag = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        /* if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        } */

        if ($Logged_user_id > 2 || $superSellerFlag == 1) {

          //$data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'], $data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($data['Company_id'], $data['enroll']);
          
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {

          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
        } else {
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        if ($_REQUEST == NULL) {
          $this->load->view("Reports/Merchant_billing_settelement_report", $data);
        } else {
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];
          $Billing_status = $_REQUEST["Billing_status"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $report_type = $_REQUEST["report_type"];

          $data['seller_id'] = $_REQUEST["seller_id"];
          $data["Billing_status"] = $_REQUEST["Billing_status"];
          $data["start_date"] = $_REQUEST["start_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $data["Report_type"] = $report_type;

          if (!isset($_REQUEST["page_limit"])) {
            $start = 0;
            $limit = 10;

            $data["Seller_billing_details"] = $this->Report_model->Get_merchant_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);

            $data["Count_Records"] = $this->Report_model->Count_records_merchant_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }

            $data["Seller_billing_details"] = $this->Report_model->Get_merchant_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);

            $data["Count_Records"] = $this->Report_model->Count_records_merchant_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
          }
          // print_r($data["Seller_billing_details"]);
          $this->load->view("Reports/Merchant_billing_settelement_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Export_merchant_billing_report() 
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
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $seller_id = $_REQUEST["seller_id"];
        $Billing_status = $_REQUEST["Billing_status"];
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $report_type = $_REQUEST["Report_type"];

        $data['From_date'] = $_REQUEST["start_date"];
        $data['seller_id'] = $_REQUEST["seller_id"];
        $data["Billing_status"] = $_REQUEST["Billing_status"];
        $data["start_date"] = $_REQUEST["start_date"];
        $data["end_date"] = $_REQUEST["end_date"];
        $data["Report_type"] = $report_type;


        $Today_date = date("Y-m-d");
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Merchant_billing_report";

        $data["Report_date"] = $Today_date;

        $data["Seller_billing_details"] = $this->Report_model->Get_merchant_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Merchant Billing Report');
          // $this->excel->stream('Merchant_billing_report.xls', $data["Seller_billing_details"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Seller_billing_details"][0] as $key => $field) {
            // $Column_Name = str_replace('_', ' ', $key);
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
          foreach ($data["Seller_billing_details"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_merchant_billing_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    } 
	public function Merchant_debit_billing_Settlement_report()
	{ 
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
        $superSellerFlag = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

        /* if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        } */

        if ($Logged_user_id > 2 || $superSellerFlag == 1) {

          //$data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'], $data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($data['Company_id'], $data['enroll']);
          
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {

          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
        } else {
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        if ($_REQUEST == NULL) 
		{
          $this->load->view("Reports/Merchant_debit_billing_settelement_report", $data);
        } 
		else
		{
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];
          $Billing_status = $_REQUEST["Billing_status"];
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $report_type = $_REQUEST["report_type"];

          $data['seller_id'] = $_REQUEST["seller_id"];
          $data["Billing_status"] = $_REQUEST["Billing_status"];
          $data["start_date"] = $_REQUEST["start_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $data["Report_type"] = $report_type;

          if (!isset($_REQUEST["page_limit"])) {
            $start = 0;
            $limit = 10;

            $data["Seller_billing_details"] = $this->Report_model->Get_merchant_debit_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);

            $data["Count_Records"] = $this->Report_model->Count_records_debit_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) {//All
              $limit = "";
              $start = "";
            }

            $data["Seller_billing_details"] = $this->Report_model->Get_merchant_debit_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);

            $data["Count_Records"] = $this->Report_model->Count_records_debit_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
          }
          // print_r($data["Seller_billing_details"]);
          $this->load->view("Reports/Merchant_debit_billing_settelement_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      } 
    }
    public function Export_merchant_debit_billing_report() 
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
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $seller_id = $_REQUEST["seller_id"];
        $Billing_status = $_REQUEST["Billing_status"];
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $report_type = $_REQUEST["Report_type"];

        $data['From_date'] = $_REQUEST["start_date"];
        $data['seller_id'] = $_REQUEST["seller_id"];
        $data["Billing_status"] = $_REQUEST["Billing_status"];
        $data["start_date"] = $_REQUEST["start_date"];
        $data["end_date"] = $_REQUEST["end_date"];
        $data["Report_type"] = $report_type;


        $Today_date = date("Y-m-d");
        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Merchant_debit_billing_report";

        $data["Report_date"] = $Today_date;

        $data["Seller_billing_details"] = $this->Report_model->Get_merchant_debit_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Merchant Debit Billing Report');
          // $this->excel->stream('Merchant_billing_report.xls', $data["Seller_billing_details"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Seller_billing_details"][0] as $key => $field) {
            // $Column_Name = str_replace('_', ' ', $key);
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
          foreach ($data["Seller_billing_details"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_merchant_debit_billing_report.php', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }
    public function Publisher_billing_Settlement_report() {
		
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

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $data["loyalty_publishers"] = $this->Report_model->get_loyalty_publishers($data['Company_id']);

        if ($_REQUEST == NULL) {
			
          $this->load->view("Reports/Publisher_billing_Settlement_report", $data);
		  
        } else {
			
			//echo"Publisher_billing_Settlement_report";
			// $Company_id = $_REQUEST["Company_id"];
			$Company_id = $session_data["Company_id"];
			$seller_id = $_REQUEST["seller_id"];
			$Billing_status = $_REQUEST["Billing_status"];
			$start_date = $_REQUEST["start_date"];
			$end_date = $_REQUEST["end_date"];
			$report_type = $_REQUEST["report_type"];

			$data['seller_id'] = $_REQUEST["seller_id"];
			$data["Billing_status"] = $_REQUEST["Billing_status"];
			$data["start_date"] = $_REQUEST["start_date"];
			$data["end_date"] = $_REQUEST["end_date"];
			$data["Report_type"] = $report_type;

			/* if(!isset($_REQUEST["page_limit"])) {
				$start = 0;
				$limit = 10;

				$data["Publisher_billing_details"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);

				$data["Count_Records"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
			
			} else {
			  
				$limit = 10;
				$start = $_REQUEST["page_limit"] - 10;
				if ($_REQUEST["page_limit"] == 0) {//All
					$limit = "";
					$start = "";
				}
			
				$data["Publisher_billing_details"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);
				$data["Count_Records"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
			} */


				$data["Publisher_billing_details"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, $start, $limit);
				// $data["Count_Records"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');
          $this->load->view("Reports/Publisher_billing_Settlement_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }	
    public function Export_publisher_billing_report() {
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
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $seller_id = $_REQUEST["seller_id"];
        $Billing_status = $_REQUEST["Billing_status"];
        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $report_type = $_REQUEST["Report_type"];

        $data['From_date'] = $_REQUEST["start_date"];
        $data['seller_id'] = $_REQUEST["seller_id"];
        $data["Billing_status"] = $_REQUEST["Billing_status"];
        $data["start_date"] = $_REQUEST["start_date"];
        $data["end_date"] = $_REQUEST["end_date"];
        $data["Report_type"] = $report_type;


        $Today_date = date("Y-m-d");

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Publisher_billing_report";

        $data["Report_date"] = $Today_date;

        $data["Publisher_billing_details"] = $this->Report_model->Get_Publisher_billing_settlement_report($data['Company_id'], $seller_id, $Billing_status, $start_date, $end_date, $report_type, '', '');

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Publisher Billing Report');
          // $this->excel->stream('Publisher_billing_report.xls', $data["Publisher_billing_details"]);
          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Publisher_billing_details"][0] as $key => $field) {
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
          foreach ($data["Publisher_billing_details"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_publisher_billing_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Debit_transaction_report() {
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
        $superSellerFlag= $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
        $Logged_user_id = $session_data['userId'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $get_sellers15 = $this->Igain_model->get_seller_details($data['enroll']);

       /* if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        } */

        if ($Logged_user_id > 2 || $superSellerFlag == 1) {

          //$data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'], $data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($data['Company_id']);
          
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {

          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
        } else {
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

        if ($_REQUEST == NULL) {
          $this->load->view("Reports/Debit_transaction_report", $data);
        } else {
          $Company_id = $_REQUEST["Company_id"];
          $seller_id = $_REQUEST["seller_id"];

          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $report_type = $_REQUEST["report_type"];

          $data['seller_id'] = $_REQUEST["seller_id"];

          $data["start_date"] = $_REQUEST["start_date"];
          $data["end_date"] = $_REQUEST["end_date"];
          $data["Report_type"] = $report_type;

          if (!isset($_REQUEST["page_limit"])) {
            $start = 0;
            $limit = 10;

            $data["Debit_trans_details"] = $this->Report_model->Get_debit_transaction_report($data['Company_id'], $seller_id, $start_date, $end_date, $report_type, $start, $limit);

            $data["Count_Records"] = $this->Report_model->Get_debit_transaction_report($data['Company_id'], $seller_id, $start_date, $end_date, $report_type, '', '');
          } else {
            $limit = 10;
            $start = $_REQUEST["page_limit"] - 10;
            if ($_REQUEST["page_limit"] == 0) { //All
              $limit = "";
              $start = "";
            }

            $data["Debit_trans_details"] = $this->Report_model->Get_debit_transaction_report($data['Company_id'], $seller_id, $start_date, $end_date, $report_type, $start, $limit);

            $data["Count_Records"] = $this->Report_model->Get_debit_transaction_report($data['Company_id'], $seller_id, $start_date, $end_date, $report_type, '', '');
          }

          $this->load->view("Reports/Debit_transaction_report", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function Export_debit_transaction_report() {
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
        $Company_name = $session_data['Company_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;

        $pdf_excel_flag = $_REQUEST['pdf_excel_flag'];
        $seller_id = $_REQUEST["seller_id"];

        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $report_type = $_REQUEST["Report_type"];

        $data['From_date'] = $_REQUEST["start_date"];
        $data['seller_id'] = $_REQUEST["seller_id"];

        $data["start_date"] = $_REQUEST["start_date"];
        $data["end_date"] = $_REQUEST["end_date"];
        $data["Report_type"] = $report_type;


        $Today_date = date("Y-m-d");

        $cmp_name = str_replace(' ', '_', $Company_name);
        $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Debit_transaction_report";

        $data["Report_date"] = $Today_date;

        $data["Debit_trans_details"] = $this->Report_model->Get_debit_transaction_report($data['Company_id'], $seller_id, $start_date, $end_date, $report_type, '', '');


        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Debit Transaction Report');
          // $this->excel->stream('Debit_transaction_report.xls', $data["Debit_trans_details"]);

          $fields = array();

          //Fetching the column names from return array data
          foreach ($data["Debit_trans_details"][0] as $key => $field) {
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
          foreach ($data["Debit_trans_details"] as $data1) {
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
          $html = $this->load->view('Reports/pdf_debit_transaction_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

	//**************** order transaction report 06-01-2020 AMIT KAMBLE**********************
	public function Customer_Order_Transactions_Report()
	{
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
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $Company_id = $session_data['Company_id'];
		
		$data['Super_seller'] = $session_data['Super_seller'];
        $superSellerFlag = $session_data['Super_seller'];
        $data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
        $Sub_seller_admin = $session_data['Sub_seller_admin'];
        $Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];

        $Logged_user_id = $session_data['userId'];
        $data["Company_details"] = $this->Igain_model->get_company_details($session_data['Company_id']);

        $Country = $data["Company_details"]->Country;
		$data["Redemptionratio"] = $data["Company_details"]->Redemptionratio;
        $Country_details = $this->Report_model->get_dial_code($Country);
        $data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;
		
		 if ($Logged_user_id > 2 || $superSellerFlag == 1) {

          // $data["company_sellers"] = $this->Igain_model->get_company_sellers_12($data['Company_id'],$data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_sellers_and_staff12($session_data['Company_id']);
          //get_company_sellers_and_staff
        } else if ($Sub_seller_admin == 1 && $Logged_user_id == 2) {

          $data["company_sellers"] = $this->Igain_model->get_sub_seller_admin_details($data['enroll'], $data['Company_id']);
          // var_dump($data["company_sellers"]);
        } else {
          // $data["company_sellers"] = $this->Igain_model->get_seller_details($data['enroll']);
          $data["company_sellers"] = $this->Igain_model->get_seller_details_12($data['enroll']);
        }

		 if ($_REQUEST == NULL) {
			$this->load->view("Reports/Online_transactions_report_view", $data);
		 }
		 
        if ($_REQUEST != NULL) {
          //echo "dssfsdfsd";

			  $start_date = $_REQUEST["start_date"];
			  $end_date = $_REQUEST["end_date"];
			  $report_type = $_REQUEST["report_type"];
			  $Outlet_id = $_REQUEST["Outlet_id"];
			  $transaction_from = $_REQUEST["transaction_from"];
			  $Voucher_status = $_REQUEST["Voucher_status"];
			  $membership_id = $_REQUEST["membership_id"];
			  $pdf_excel_flag = $_REQUEST["pdf_excel_flag"];
	 
				$data['start_date'] = $_REQUEST["start_date"];
				$data['end_date'] = $_REQUEST["end_date"];
				$data['report_type'] = $_REQUEST["report_type"];
				$data['Outlet_id'] = $_REQUEST["Outlet_id"];
				$data['transaction_from'] = $_REQUEST["transaction_from"];
				$data['Voucher_status'] = $_REQUEST["Voucher_status"];
				$data['membership_id'] = $_REQUEST["membership_id"];
			
			if($transaction_from == 2){
				$Voucher_status = 0;
				$data['Voucher_status'] = 0;
			}	
			  
		
			
			 /*  if (isset($_REQUEST["page_limit"])) {
				$limit = 10;
				$start = $_REQUEST["page_limit"] - 10;
				
			  } else { 
				$start = 0;
				$limit = 10;
			  } */
			  $start = '';
				$limit = '';

			  if ($report_type == 1) {//details
			  
				  $Trans_Records = $this->Report_model->get_cust_order_transaction_details($Company_id, $start_date, $end_date, $transaction_from, $membership_id, $Voucher_status,$Outlet_id,$start, $limit);
				  
			  } else { //summary

				  $Trans_Records = $this->Report_model->get_cust_order_transaction_summary($Company_id, $start_date, $end_date, $transaction_from, $membership_id, $Voucher_status,$Outlet_id,$start, $limit);
	 
			  }

			  $data["Total_Trans_Records"] = $Trans_Records;
				
				/* if (isset($_REQUEST["page_limit"]) && $_REQUEST["page_limit"] < 1) {//All

				  $data["Trans_Records"] = $Trans_Records;
				}
				else{
					$data["Trans_Records"] = array_slice($Trans_Records,$start,$limit);		
				}	 */
			$data["Trans_Records"] = $Trans_Records;
			if($pdf_excel_flag > 0)
			{
	
				$Today_date = date("Y-m-d");

				if ($report_type == 2) {
				  $name = 'orders_summary_rpt';
				} else {
				  $name = 'orders_detail_rpt';
				}


				$cmp_name = str_replace(' ', '_', $Company_name);
				$Export_file_name = $cmp_name . "_Orders_report_" . $Today_date;

				$data["Report_date"] = $Today_date;
				$data["Report_type"] = $report_type;
				$data["report_type"] = $report_type;
				$data["Company_name"] = $Company_name;

				if ($pdf_excel_flag == 1) {
				  $this->excel->getActiveSheet()->setTitle('Member Orders Report');
				  // $this->excel->stream($Export_file_name.'.xls', $data["Trans_Records"]);
				  $fields = array();

				  //Fetching the column names from return array data
				  foreach ($data["Total_Trans_Records"][0] as $key => $field) {
					 
					if($key == "Seller" || $key == "Item_code" || $key == "Redeem_points" || $key =="Enrollement_id"){
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
				  foreach ($data["Total_Trans_Records"] as $data1) {
					  
					  if($data1->Order_status == 0)
						{
							$data1->Order_status = "";
						}
			
						if($data1->Order_status == 18)
						{
							$data1->Order_status = "Ordered";
						}
						if($data1->Order_status == 19)
						{
							$data1->Order_status = "Shipped";
						}
						if($data1->Order_status == 20)
						{
							if($data1->Order_type == 28)
							{
								$data1->Order_status = "Collected";
							}
							else if($data1->Order_type == 29)
							{
								$data1->Order_status = "Delivered";
							}
							else
							{
								$data1->Order_status = " ";
							}
							
						}
						if($data1->Order_status == 21)
						{
							$data1->Order_status = "Cancel";
						}
			
						if($data1->Quantity == 0)
						{
							$data1->Quantity = "-";
							$data1->Menu_name = "-";
						}
						
						if($data1->condiments == ""){
							$condiments = "-";
						}else{
							$condiments = $data1->condiments;
						}

						if($data1->Trans_type == 12)
						{
							$data1->Trans_type = "Online";
						}
						
						if($data1->Trans_type == 2)
						{
							$data1->Trans_type = "POS";
						}
						
						if($data1->Order_type == 28)
						{
							$data1->Order_type = "Pick Up";
						}
						elseif($data1->Order_type == 29)
						{
							$data1->Order_type = "Home Delivery";
						}
						else
						{
							$data1->Order_type = "In-Store";
						}
					
						$data1->Total_purchase_amount = number_format(round($data1->Total_purchase_amount),2);
						$data1->Total_shipping_cost = number_format(round($data1->Total_shipping_cost),2);
						$data1->Total_redeem_amount = number_format(round($data1->Total_redeem_amount),2);
						$data1->Total_mpesa_amount = number_format(round($data1->Total_mpesa_amount),2);
						$data1->Total_cash_amount = number_format(round($data1->Total_cash_amount),2);
						$data1->Total_paid_amount = number_format(round($data1->Total_paid_amount),2);
						$data1->Total_gained_pts = round($data1->Total_gained_pts);
									
					
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
				  $html = $this->load->view('Reports/pdf_online_transactions_report', $data, true);
				  $this->m_pdf->pdf->WriteHTML($html);
				  $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
				}
			}
			else{
				$this->load->view("Reports/Online_transactions_report_view", $data);	
			}
        }
		
      } else {
        redirect('Login', 'refresh');
      }
    }
	
	//**************** order transaction report 18-09-2019 ***********************
	public function Show_order_details()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			
			$Country = $data["Company_details"]->Country;
			$Country_details = $this->Report_model->get_dial_code($Country );
			$data['Symbol_of_currency'] = $Country_details->Symbol_of_currency;	
				
			if($_REQUEST['Bill_no'] != "")
			{	
				$data["Order"] = $this->Report_model->get_order_details($_REQUEST['Bill_no'],$_REQUEST['Enrollement_id'],$Company_id);
				$data["Order_details"] = $this->Report_model->get_order_details2($_REQUEST['Bill_no'],$_REQUEST['Enrollement_id'],$Company_id);
					
				$theHTMLResponse = $this->load->view('Reports/Cc_show_order_details', $data, true);		
				$this->output->set_content_type('application/json');
				$this->output->set_output(json_encode(array('transactionReceiptHtml'=> $theHTMLResponse)));
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
  }

?>