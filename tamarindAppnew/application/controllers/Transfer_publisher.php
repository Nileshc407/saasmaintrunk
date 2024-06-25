<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Transfer_publisher extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Igain_model');
        $this->load->model('Beneficiary/Beneficiary_model');
        $this->load->model('Beneficiary/Transfer_publisher_model');
        $this->load->model('shopping/Shopping_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->load->library("Excel");
        $this->load->library('m_pdf');
        $this->load->library('Send_notification');
		$this->load->model('General_setting_model');

        if ($this->session->userdata('cust_logged_in')) {
            $session_data = $this->session->userdata('cust_logged_in');
            $Company_id = $session_data['Company_id'];
        }
        //-----------------------Frontend Template Settings------------------//                    
        $General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'General', 'value', $Company_id);
        $this->General_details = json_decode($General_data, true);

        $Small_font = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Small_font', 'value', $Company_id);
        $this->Small_font_details = json_decode($Small_font, true);

        $Medium_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Medium_font', 'value', $Company_id);
        $this->Medium_font_details = json_decode($Medium_font_data, true);

        $Large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Large_font', 'value', $Company_id);
        $this->Large_font_details = json_decode($Large_font_data, true);

        $Extra_large_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Extra_large_font', 'value', $Company_id);
        $this->Extra_large_font_details = json_decode($Extra_large_font_data, true);

        $Button_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Button_font', 'value', $Company_id);
        $this->Button_font_details = json_decode($Button_font_data, true);

        $Value_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Value_font', 'value', $Company_id);
        $this->Value_font_details = json_decode($Value_font_data, true);

        $Footer_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Footer_font', 'value', $Company_id);
        $this->Footer_font_details = json_decode($Footer_font_data, true);

        $Placeholder_font_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Placeholder_font', 'value', $Company_id);
        $this->Placeholder_font_details = json_decode($Placeholder_font_data, true);
        //-------------------------Frontend Template Settings-------------------------//
    }

    function From_publisher() {
        if ($this->session->userdata('cust_logged_in')) {
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];
            $data['First_name'] = $session_data['First_name'];
            $data['Last_name'] = $session_data['Last_name'];
            $data['enroll'] = $session_data['enroll'];
            $Enrollment_id = $session_data['enroll'];
            $data['userId'] = $session_data['userId'];
            $data['Card_id'] = $session_data['Card_id'];
            $data['Company_id'] = $session_data['Company_id'];
            $data['timezone_entry'] = $session_data['timezone_entry'];
            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Company_id=$session_data['Company_id'];			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
            // -----------------------------Template-----CSS------------------------------------ //
            $data['Small_font_details'] = $this->Small_font_details;
            $data['Medium_font_details'] = $this->Medium_font_details;
            $data['Large_font_details'] = $this->Large_font_details;
            $data['Extra_large_font_details'] = $this->Extra_large_font_details;
            $data['Button_font_details'] = $this->Button_font_details;
            $data['General_details'] = $this->General_details;
            $data['Value_font_details'] = $this->Value_font_details;
            $data['Footer_font_details'] = $this->Footer_font_details;
            $data['Placeholder_font_details'] = $this->Placeholder_font_details;
            $data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
            // -----------------------------Template-----CSS------------------------------------ //
            //echo "-----Load_publisher--------".print_r($session_data)."--<br>";

            $data["Get_Beneficiary_members"] = $this->Transfer_publisher_model->Get_Beneficiary_members($data['Company_id'], $Enrollment_id);
            //var_dump($data["Get_Beneficiary_members"]);

            $this->load->view('front/transferpublisher/from_publisher', $data);
        } else {
            redirect('login', 'refresh');
        }
    }

    function To_publisher() {
        if ($this->session->userdata('cust_logged_in')) {
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];
            $data['First_name'] = $session_data['First_name'];
            $data['Last_name'] = $session_data['Last_name'];
            $data['enroll'] = $session_data['enroll'];
            $Enrollment_id = $session_data['enroll'];
            $data['userId']= $session_data['userId'];
            $data['Card_id']= $session_data['Card_id'];
            $data['Company_id']= $session_data['Company_id'];
            $data['timezone_entry']= $session_data['timezone_entry'];
            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);$Company_id=$session_data['Company_id'];			
			$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
            // -----------------------------Template-----CSS------------------------------------ //
            $data['Small_font_details'] = $this->Small_font_details;
            $data['Medium_font_details'] = $this->Medium_font_details;
            $data['Large_font_details'] = $this->Large_font_details;
            $data['Extra_large_font_details'] = $this->Extra_large_font_details;
            $data['Button_font_details'] = $this->Button_font_details;
            $data['General_details'] = $this->General_details;
            $data['Value_font_details'] = $this->Value_font_details;
            $data['Footer_font_details'] = $this->Footer_font_details;
            $data['Placeholder_font_details'] = $this->Placeholder_font_details;
            $data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
            // -----------------------------Template-----CSS------------------------------------ //
            //echo "-----Load_publisher--------".print_r($session_data)."--<br>";

            $data["Get_Beneficiary_members"] = $this->Transfer_publisher_model->Get_Beneficiary_members($data['Company_id'], $Enrollment_id);
            //var_dump($data["Get_Beneficiary_members"]);

            if ($_REQUEST['From_publisher'] == NULL && $_REQUEST['From_beneficiary_id'] == NULL) {

                $this->load->view('front/transferpublisher/from_publisher', $data);
            } else {

                $data['From_publisher'] = $_REQUEST['From_publisher'];
                $data['From_beneficiary_id'] = $_REQUEST['From_beneficiary_id'];

                /*
                  echo "-----From_publisher-----".$data['From_publisher']."--<br>";
                  echo "-----From_beneficiary_id-----".$data['From_beneficiary_id']."--<br>";
                  die;
                 */

                $this->load->view('front/transferpublisher/to_publisher', $data);
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    public function Transfer_publisher_points() {

        if ($this->session->userdata('cust_logged_in')) {
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];
            $data['First_name'] = $session_data['First_name'];
            $data['Last_name'] = $session_data['Last_name'];
            $data['enroll'] = $session_data['enroll'];
            $Enrollment_id = $session_data['enroll'];
            $data['userId'] = $session_data['userId'];
            $data['Card_id'] = $session_data['Card_id'];
            $data['Company_id'] = $session_data['Company_id'];
            $data['timezone_entry'] = $session_data['timezone_entry'];
            $Company_id = $session_data['Company_id'];
            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Enroll_details12=$data["Enroll_details"];
            $data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
            $Login_Company_Details= $this->Igain_model->get_company_details($Company_id);
            $data['Login_Redemptionratio']=$Login_Company_Details->Redemptionratio;
            $data["Company_name"]=$Login_Company_Details->Company_name;
            $data["Company_logo"]=$Login_Company_Details->Company_logo;
            
            $Current_point_balance=0;
            $Current_balance= $Enroll_details12->Current_balance;
            $Blocked_points= $Enroll_details12->Blocked_points;
            $Debit_points= $Enroll_details12->Debit_points;

            /*
              echo "-----Current_balance--------".$Current_balance."--<br>";
              echo "-----Blocked_points--------".$Blocked_points."--<br>";
              echo "-----Debit_points--------".$Debit_points."--<br>"; */

            $Current_point_balance = $Current_balance - ($Blocked_points + $Debit_points);

            if ($Current_point_balance < 0) {
                $Current_point_balance = 0;
            } else {
                $Current_point_balance = $Current_point_balance;
            }
            $data['Login_Current_balance'] = $Current_point_balance;
            // -----------------------------Template-----CSS------------------------------------ //
            $data['Small_font_details'] = $this->Small_font_details;
            $data['Medium_font_details'] = $this->Medium_font_details;
            $data['Large_font_details'] = $this->Large_font_details;
            $data['Extra_large_font_details'] = $this->Extra_large_font_details;
            $data['Button_font_details'] = $this->Button_font_details;
            $data['General_details'] = $this->General_details;
            $data['Value_font_details'] = $this->Value_font_details;
            $data['Footer_font_details'] = $this->Footer_font_details;
            $data['Placeholder_font_details'] = $this->Placeholder_font_details;
            $data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
            // -----------------------------Template-----CSS------------------------------------ //
            //echo "-----Load_publisher--------".print_r($session_data)."--<br>";

            $data["Get_Beneficiary_members"] = $this->Transfer_publisher_model->Get_Beneficiary_members($data['Company_id'], $Enrollment_id);
            //var_dump($data["Get_Beneficiary_members"]);

            if ($_REQUEST['From_publisher'] == NULL && $_REQUEST['From_beneficiary_id'] == NULL && $_REQUEST['To_publisher'] == NULL && $_REQUEST['To_beneficiary_id'] == NULL) {

                $this->load->view('front/transferpublisher/from_publisher', $data);
            } else {

                $data['From_publisher'] = $_REQUEST['From_publisher'];
                $data['From_beneficiary_id'] = $_REQUEST['From_beneficiary_id'];
                $data['To_publisher'] = $_REQUEST['To_publisher'];
                $data['To_beneficiary_id'] = $_REQUEST['To_beneficiary_id'];

                $data['From_publisher_details'] = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($_REQUEST['From_publisher']);
                $data['To_publisher_details'] = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($_REQUEST['To_publisher']);

                /*
                  echo "-----From_publisher-----".$_REQUEST['From_publisher']."--<br>";
                  echo "-----From_beneficiary_id-----".$_REQUEST['From_beneficiary_id']."--<br>";
                  echo "-----To_publisher-----".$_REQUEST['To_publisher']."--<br>";
                  echo "-----To_beneficiary_id-----".$_REQUEST['To_beneficiary_id']."--<br>";
                 */




                $Beneficiary_company_id = $_REQUEST['From_publisher'];
                $FromBeneficiaryID = $_REQUEST['From_beneficiary_id'];

                // echo "-----Beneficiary_company_id-----".$Beneficiary_company_id."--<br>";  
                //  echo "-----FromBeneficiaryID-----".$FromBeneficiaryID."--<br>";

                /* -------------------------------Fetch From Publisher Details---------------------------------------------- */

                if ($FromBeneficiaryID != "" && $Beneficiary_company_id != "") {

                    $Beneficiary_Company_details = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($Beneficiary_company_id);
                    $Authentication_url = $Beneficiary_Company_details->Authentication_url;
                    $Transaction_url = $Beneficiary_Company_details->Transaction_url;
                    $Company_username = $Beneficiary_Company_details->Company_username;
                    $Company_password = $Beneficiary_Company_details->Company_password;
                    $Company_encryptionkey = $Beneficiary_Company_details->Company_encryptionkey;
                    $Beneficiary_company_name = $Beneficiary_Company_details->Beneficiary_company_name;
                    $Beneficiary_Currency = $Beneficiary_Company_details->Currency;
                    $Company_logo = $Beneficiary_Company_details->Company_logo;
                    $From_Redemptionratio = $Beneficiary_Company_details->Redemptionratio;

                    //  echo "-----Beneficiary_company_name-----".$Beneficiary_company_name."--<br>";  
                    $data['Get_Beneficiary_members'] = $this->Beneficiary_model->Get_Beneficiary_members_2($Beneficiary_company_id, $FromBeneficiaryID, $Enrollment_id);


                    $Beneficiary_account_id = $data['Get_Beneficiary_members']->Beneficiary_account_id;
                    $Beneficiary_membership_id = $data['Get_Beneficiary_members']->Beneficiary_membership_id;
                    $Beneficiary_name = $data['Get_Beneficiary_members']->Beneficiary_name;

                    //echo "-----Authentication_url-----".$Authentication_url."---<br>";
                    //echo "-----------Transfer_publisher_points---------------<pre><br>";

                    if (strcmp($Beneficiary_membership_id, $FromBeneficiaryID) == 0) {

                        $iv = '56666852251557009888889955123458';
                        $Company_password = $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);
                        //$Company_password=  $this->string_decrypt($Company_password, $Company_encryptionkey, $iv);

                        $API_Beneficiary_name = $this->string_encrypt($Beneficiary_name, $Company_encryptionkey, $iv);
                        //$API_Beneficiary_name=  $this->string_decrypt($API_Beneficiary_name, $Company_encryptionkey, $iv);


                        $API_Beneficiary_membership_id = $this->string_encrypt($Beneficiary_membership_id, $Company_encryptionkey, $iv);
                        $API_Purchase_miles = $this->string_encrypt($Purchase_miles, $Company_encryptionkey, $iv);
                        $API_tp_bill2 = $this->string_encrypt($tp_bill2, $Company_encryptionkey, $iv);
                        $API_Flag = $this->string_encrypt(4, $Company_encryptionkey, $iv);


                        $fields = array(
                            'Company_username' => $Company_username,
                            'Company_password' => $Company_password,
                            'Beneficiary_name' => $API_Beneficiary_name,
                            'Beneficiary_membership_id' => $API_Beneficiary_membership_id,
                            'flag' => $API_Flag
                        );
                        // print_r($fields);
                        $field_string = $fields;
                        $ch = curl_init();
                        $timeout = 0; // Set 0 for no timeout.
                        curl_setopt($ch, CURLOPT_URL, $Authentication_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string));
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {

                            print "Error: " . curl_error($ch);
                        }
                        if (!curl_errno($ch)) {

                            $info = curl_getinfo($ch);
                        }
                        curl_close($ch);
                        //echo"---Response---";
                        //print_r($result);
                        $return_result = json_decode($result);

                        if ($return_result->status == 1001 && $return_result->status_message > 0) {

                            $data['Publisher_current_balance'] = $return_result->status_message->Current_balance;
                            $data['From_user_email_address'] = $return_result->status_message->User_email_id;
                        } else {

                            $data['Publisher_current_balance'] = 0;
                        }



                        /* ---------------------------To Publisher Get Details API-------------------------------------------------------------- */

                        $To_publisher_details = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($_REQUEST['To_publisher']);
                        $To_Authentication_url = $To_publisher_details->Authentication_url;
                        $To_Transaction_url = $To_publisher_details->Transaction_url;
                        $To_Company_username = $To_publisher_details->Company_username;
                        $To_Company_password = $To_publisher_details->Company_password;
                        $To_Company_encryptionkey = $To_publisher_details->Company_encryptionkey;
                        $To_Beneficiary_company_name = $To_publisher_details->Beneficiary_company_name;
                        $To_Beneficiary_Currency = $To_publisher_details->Currency;
                        $To_Company_logo = $To_publisher_details->Company_logo;
                        $To_Redemptionratio = $To_publisher_details->Redemptionratio;



                        $To_get_Beneficiary_members = $this->Beneficiary_model->Get_Beneficiary_members_2($_REQUEST['To_publisher'], $_REQUEST['To_beneficiary_id'], $Enrollment_id);
                        $To_Beneficiary_account_id = $To_get_Beneficiary_members->Beneficiary_account_id;
                        $To_Beneficiary_membership_id = $To_get_Beneficiary_members->Beneficiary_membership_id;
                        $To_Beneficiary_name = $To_get_Beneficiary_members->Beneficiary_name;


                        $iv = '56666852251557009888889955123458';
                        $TO_Company_password = $this->string_encrypt($To_Company_password, $To_Company_encryptionkey, $iv);
                        $API_TO_Beneficiary_name = $this->string_encrypt($To_Beneficiary_name, $To_Company_encryptionkey, $iv);
                        $API_TO_Beneficiary_membership_id = $this->string_encrypt($To_Beneficiary_membership_id, $To_Company_encryptionkey, $iv);
                        $API_TO_Flag = $this->string_encrypt(4, $To_Company_encryptionkey, $iv);




                        $fields1 = array(
                            'Company_username' => $To_Company_username,
                            'Company_password' => $TO_Company_password,
                            'Beneficiary_name' => $API_TO_Beneficiary_name,
                            'Beneficiary_membership_id' => $API_TO_Beneficiary_membership_id,
                            'flag' => $API_TO_Flag
                        );

                        // print_r($fields);
                        $field_string1 = $fields1;
                        $ch1 = curl_init();
                        $timeout1 = 0; //Set 0 for no timeout.
                        curl_setopt($ch1, CURLOPT_URL, $To_Authentication_url);
                        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($field_string1));
                        curl_setopt($ch1, CURLOPT_POST, true);
                        curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout1);
                        $result1 = curl_exec($ch1);
                        if (curl_errno($ch1)) {
                            print "Error: " . curl_error($ch1);
                        }
                        if (!curl_errno($ch1)) {

                            $info = curl_getinfo($ch1);
                            //echo '----error---- ', $info['total_time'], ' seconds to send a request to ', $info['url'], "--<br>";
                        }
                        curl_close($ch1);
                        // print_r($result1);
                        $return_result1 = json_decode($result1);

                        if ($return_result1->status == 1001 && $return_result1->status_message > 0) {

                            $data['TO_Publisher_current_balance'] = $return_result1->status_message->Current_balance;
                            $data['To_user_email_address'] = $return_result1->status_message->User_email_id;
                        } else {

                            $data['TO_Publisher_current_balance'] = 0;
                            $data['To_user_email_address'] = "";
                        }

                        /* ---------------------------To Publisher Get Details API-------------------------------------------------------------- */
                    }
                }
                /* -------------------------------Fetch From Publisher Details---------------------------------------------- */

                $this->load->view('front/transferpublisher/transfer_publisher_points', $data);
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    public function Transfer_publisher_topublisher_points() {
        if ($this->session->userdata('cust_logged_in')) {
            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];
            $data['enroll'] = $session_data['enroll'];
            $Enrollment_id = $session_data['enroll'];
            $data['userId'] = $session_data['userId'];
            $data['Card_id'] = $session_data['Card_id'];
            $data['Company_id'] = $session_data['Company_id'];
            $Company_id = $session_data['Company_id'];
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time = $date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');
            $Trans_date = $date->format('Y-m-d');
           
		   	$data['Company_Details']= $this->Igain_model->get_company_details($session_data['Company_id']);
			
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);

            $data["Get_Beneficiary_Company"] = $this->Beneficiary_model->Get_Beneficiary_Company($data['Company_id']);
            $data["Get_Beneficiary_members"] = $this->Transfer_publisher_model->Get_Beneficiary_members($data['Company_id'], $Enrollment_id);



            $Login_Company_Details = $this->Igain_model->get_company_details($data['Company_id']);
            $Login_Redemptionratio = $Login_Company_Details->Redemptionratio;
            $data["Company_name"] = $Login_Company_Details->Company_name;
            $Company_name = $Login_Company_Details->Company_name;

            //Code Decode for Buy Miles Status

            $Get_codedecode_details = $this->Igain_model->Get_codedecode_row(44);
            $Buy_miles_status = $Get_codedecode_details->Code_decode;

            // echo $Buy_miles_status;          
            // ------------------------------------Template Configuration------------------------------------ //
            $data['Small_font_details'] = $this->Small_font_details;
            $data['Medium_font_details'] = $this->Medium_font_details;
            $data['Large_font_details'] = $this->Large_font_details;
            $data['Extra_large_font_details'] = $this->Extra_large_font_details;
            $data['Button_font_details'] = $this->Button_font_details;
            $data['General_details'] = $this->General_details;
            $data['Value_font_details'] = $this->Value_font_details;
            $data['Footer_font_details'] = $this->Footer_font_details;
            $data['Placeholder_font_details'] = $this->Placeholder_font_details;
            $data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
            // ------------------------------Template Configuration---------------------- //

            if ($_POST == NULL) {

                $this->load->view('front/transferpublisher/from_publisher', $data);
            } else {


                $Transfer_miles = $_REQUEST["Transfer_miles"];
                $From_publisher = $_REQUEST["From_publisher"];
                $From_beneficiary_id = $_REQUEST["From_beneficiary_id"];
                $To_publisher = $_REQUEST["To_publisher"];
                $To_beneficiary_id = $_REQUEST["To_beneficiary_id"];
                $Equivalent = $_REQUEST["Equivalent"];
                $Publisher_current_balance = $_REQUEST["Publisher_current_balance"];
                $Publisher_current_balance = $_REQUEST["Publisher_current_balance"];
                $From_user_email_address = $_REQUEST["From_user_email_address"];
                $To_user_email_address = $_REQUEST["To_user_email_address"];

                $TransferFlag = 0;

                if ($Transfer_miles > 0 && $Equivalent > 0 && $Publisher_current_balance >= $Transfer_miles) {
                    $Super_Seller_details = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                    $seller_id = $Super_Seller_details->Enrollement_id;
                    $Seller_name = $Super_Seller_details->First_name . ' ' . $Super_Seller_details->Last_name;
                    $top_db2 = $Super_Seller_details->Topup_Bill_no;
                    $len2 = strlen($top_db2);
                    $str2 = substr($top_db2, 0, 5);
                    $tp_bill2 = substr($top_db2, 5, $len2);
                    $topup_BillNo2 = $tp_bill2 + 1;
                    $billno_withyear_ref = $str2 . $topup_BillNo2;

                    //$Get_Beneficiary_company= $this->Beneficiary_model->Get_Beneficiary_Company_2($Beneficiary_company_id); 



                    /* -----------------From Member Member Details--------------------------------- */


                    $From_publisher_details = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($_REQUEST['From_publisher']);
                    $Authentication_url = $From_publisher_details->Authentication_url;
                    $Transaction_url = $From_publisher_details->Transaction_url;
                    $Company_username = $From_publisher_details->Company_username;
                    $Company_password = $From_publisher_details->Company_password;
                    $Company_encryptionkey = $From_publisher_details->Company_encryptionkey;
                    $Beneficiary_company_name = $From_publisher_details->Beneficiary_company_name;
                    $Beneficiary_Currency = $From_publisher_details->Currency;
                    $Company_logo = $From_publisher_details->Company_logo;
                    $From_Redemptionratio = $From_publisher_details->Redemptionratio;


                    $Get_From_Beneficiary_members = $this->Beneficiary_model->Get_Beneficiary_members_2($From_publisher, $From_beneficiary_id, $Enrollment_id);
                    $Beneficiary_account_id = $Get_From_Beneficiary_members->Beneficiary_account_id;
                    $Beneficiary_membership_id = $Get_From_Beneficiary_members->Beneficiary_membership_id;
                    $Beneficiary_name = $Get_From_Beneficiary_members->Beneficiary_name;
                    /*
                      echo "----Beneficiary_account_id---- ".$Beneficiary_account_id."--<br>";
                      echo "---Beneficiary_membership_id---- ".$Beneficiary_membership_id."--<br>";
                      echo "----Beneficiary_name---- ".$Beneficiary_name."--<br>";
                     */

                    /* -----------------From Member Member Details--------------------------------- */

                    /* -------------------From Publisher Transfer Miles API---------------------------------- */




                    /* -----------------To Member Details--------------------------------- */
                    $To_publisher_details = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($_REQUEST['To_publisher']);
                    $To_Authentication_url = $To_publisher_details->Authentication_url;
                    $To_Transaction_url = $To_publisher_details->Transaction_url;
                    $To_Company_username = $To_publisher_details->Company_username;
                    $To_Company_password = $To_publisher_details->Company_password;
                    $To_Company_encryptionkey = $To_publisher_details->Company_encryptionkey;
                    $To_Beneficiary_company_name = $To_publisher_details->Beneficiary_company_name;
                    $To_Beneficiary_Currency = $To_publisher_details->Currency;
                    $To_Company_logo = $To_publisher_details->Company_logo;
                    $To_Redemptionratio = $To_publisher_details->Redemptionratio;



                    $To_get_Beneficiary_members = $this->Beneficiary_model->Get_Beneficiary_members_2($To_publisher, $To_beneficiary_id, $Enrollment_id);
                    $To_Beneficiary_account_id = $To_get_Beneficiary_members->Beneficiary_account_id;
                    $To_Beneficiary_membership_id = $To_get_Beneficiary_members->Beneficiary_membership_id;
                    $To_Beneficiary_name = $To_get_Beneficiary_members->Beneficiary_name;

                    /* echo "----To_Beneficiary_account_id---- ".$To_Beneficiary_account_id."--<br>";
                      echo "----To_Beneficiary_membership_id---- ".$To_Beneficiary_membership_id."--<br>";
                      echo "----To_Beneficiary_name---- ".$To_Beneficiary_name."--<br>"; */

                    /* -----------------To Member Details--------------------------------- */



                    $iv = '56666852251557009888889955123458';

                    $Company_password = $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);

                    $API_Beneficiary_name = $this->string_encrypt($Beneficiary_name, $Company_encryptionkey, $iv);
                    $API_Beneficiary_membership_id = $this->string_encrypt($Beneficiary_membership_id, $Company_encryptionkey, $iv);
                    $API_Transfer_miles = $this->string_encrypt($Transfer_miles, $Company_encryptionkey, $iv);
                    $API_tp_bill2 = $this->string_encrypt($tp_bill2, $Company_encryptionkey, $iv);
                    $API_Flag = $this->string_encrypt(5, $Company_encryptionkey, $iv);



                    $fields = array(
                        'Company_username' => $Company_username,
                        'Company_password' => $Company_password,
                        'Beneficiary_name' => $API_Beneficiary_name,
                        'Beneficiary_membership_id' => $API_Beneficiary_membership_id,
                        'Transfer_miles' => $API_Transfer_miles,
                        'Bill_no' => $API_tp_bill2,
                        'flag' => $API_Flag
                    );
                    // print_r($fields);
                    $field_string = $fields;
                    $ch = curl_init();
                    $timeout = 0; // Set 0 for no timeout.
                    curl_setopt($ch, CURLOPT_URL, $Transaction_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string));
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        print "Error: " . curl_error($ch);
                    }
                    if (!curl_errno($ch)) {

                        $info = curl_getinfo($ch);
                        //echo '----error---- ', $info['total_time'], ' seconds to send a request to ', $info['url'], "--<br>";
                    }
                    curl_close($ch);
                    $return_result = json_decode($result);
                    $Reference_id = 0;

                    // print_r($return_result);
                    // print_r($return_result->status);
                    //die;
                    $Voucher_status = 44;
                    if ($return_result->status == 1001 && $return_result->status_message > 0) {

                        //echo"---Transfer Done--<br>";
                        $Reference_id = $return_result->status_message;  //Last Inserted Id from Publisher Database
                        $Remarks = 'Transfer Miles';
                        $Voucher_status = 45;
                        $TransferFlag = 0;
                    } else {

                        //echo"---Transfer Not Done--<br>";
                        $Reference_id = 0;
                        $Voucher_status = 46;
                        $Remarks = $return_result->status_message;
                        $TransferFlag = 1;
                    }

                    /* -------------------From Publisher Transfer Miles API---------------------------------- */




                    //'Enrollement_id' => $Beneficiary_account_id,
                    //'Card_id' => $From_beneficiary_id,

                    /* -----------------Transfer Publisher Miles--------------------------------- */
                    $TransferMiles = array(
                        'Company_id' => $Company_id,
                        'Trans_type' => 27,
                        'Transfer_points' => $Transfer_miles,
                        'Remarks' => $Remarks,
                        'Trans_date' => $lv_date_time,
                        'Enrollement_id' => $Enroll_details12->Enrollement_id,
                        'Card_id' => $Enroll_details12->Card_id,
                        'Seller' => $seller_id,
                        'Seller_name' => $Seller_name,
                        'Voucher_status' => $Voucher_status, // Transfer Milres 
                        'To_Beneficiary_company_id' => $To_publisher,
                        'To_Beneficiary_company_name' => $To_Beneficiary_company_name,
                        'To_Beneficiary_cust_name' => $To_Beneficiary_name,
                        'From_Beneficiary_company_id' => $From_publisher,
                        'From_Beneficiary_company_name' => $Beneficiary_company_name,
                        'From_Beneficiary_cust_name' => $Beneficiary_name,
                        'Bill_no' => $tp_bill2,
                        'Manual_billno' => $tp_bill2,
                        'Card_id2' => $To_Beneficiary_membership_id,
                        'Enrollement_id2' => $To_Beneficiary_account_id, //From Cust Beneficiary 
                        'Send_miles_flag' => 1,
                        'Reference_id' => $Reference_id // Last Inserted Id from Publisher Database
                    );

                    $result = $this->Igain_model->Insert_transfer_transaction($TransferMiles);

                    //$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref); 






                    if ($Voucher_status == 44) {
                        $VoucherStatus = "Pending";
                    } else if ($Voucher_status == 45) {

                        $VoucherStatus = "Approved";
                    } else {

                        $VoucherStatus = "Cancelled";
                    }

                    /* -----------------From Notification--------------------------------- */
                    /*

                      $new_transferMIles=round($Transfer_miles/$From_Redemptionratio);
                      //$From_Redemptionratio;
                      //$To_Redemptionratio;
                      $new_transfer_miles=round($To_Redemptionratio*$new_transferMIles);

                     */


                    $new_transferMIles = round($Transfer_miles * $From_Redemptionratio);
                    $new_transfer_miles = round($new_transferMIles / $To_Redemptionratio);


                    $Email_content_From = array(
                        'Trans_date' => $lv_date_time,
                        'Notification_type' => 'You have Transferred ' . $Beneficiary_Currency . ' from ' . $Beneficiary_company_name . ' to ' . $To_Beneficiary_company_name,
                        'Transfer_miles' => $Transfer_miles,
                        'Purchased_Currency' => $Beneficiary_Currency,
                        'To_Beneficiary_Currency' => $To_Beneficiary_Currency,
                        'To_Equivalent' => $new_transfer_miles,
                        'From_user_email_address' => $From_user_email_address,
                        'From_Beneficiary_name' => $Beneficiary_name,
                        'From_beneficiary_id' => $From_beneficiary_id,
                        'To_Beneficiary_name' => $To_Beneficiary_name,
                        'To_Beneficiary_id' => $To_Beneficiary_membership_id,
                        'From_publisher' => $Beneficiary_company_name,
                        'To_publisher' => $To_Beneficiary_company_name,
                        'Status' => $VoucherStatus,
                        'Template_type' => 'From_transfer_miles'
                    );
                    $this->send_notification->send_Notification_email($Enrollment_id, $Email_content_From, '0', $Company_id);

                    /* -----------------From Notification--------------------------------- */


                    /* -----------------To Notification--and API------------------------------- */

                    if ($Voucher_status == 45) {


                        $To_publisher_details = $this->Transfer_publisher_model->Get_Beneficiary_Company_2($_REQUEST['To_publisher']);
                        $To_Authentication_url = $To_publisher_details->Authentication_url;
                        $To_Transaction_url = $To_publisher_details->Transaction_url;
                        $To_Company_username = $To_publisher_details->Company_username;
                        $To_Company_password = $To_publisher_details->Company_password;
                        $To_Company_encryptionkey = $To_publisher_details->Company_encryptionkey;
                        $To_Beneficiary_company_name = $To_publisher_details->Beneficiary_company_name;
                        $To_Beneficiary_Currency = $To_publisher_details->Currency;
                        $To_Company_logo = $To_publisher_details->Company_logo;
                        $To_Redemptionratio = $To_publisher_details->Redemptionratio;



                        $To_get_Beneficiary_members = $this->Beneficiary_model->Get_Beneficiary_members_2($To_publisher, $To_beneficiary_id, $Enrollment_id);
                        $To_Beneficiary_account_id = $To_get_Beneficiary_members->Beneficiary_account_id;
                        $To_Beneficiary_membership_id = $To_get_Beneficiary_members->Beneficiary_membership_id;
                        $To_Beneficiary_name = $To_get_Beneficiary_members->Beneficiary_name;



                        $iv = '56666852251557009888889955123458';

                        $TO_Company_password = $this->string_encrypt($To_Company_password, $To_Company_encryptionkey, $iv);

                        $API_TO_Beneficiary_name = $this->string_encrypt($To_Beneficiary_name, $To_Company_encryptionkey, $iv);
                        $API_TO_Beneficiary_membership_id = $this->string_encrypt($To_Beneficiary_membership_id, $To_Company_encryptionkey, $iv);
                        $API_TO_Transfer_miles = $this->string_encrypt($new_transfer_miles, $To_Company_encryptionkey, $iv);
                        $API_tp_bill2 = $this->string_encrypt($tp_bill2, $To_Company_encryptionkey, $iv);
                        $API_TO_Flag = $this->string_encrypt(6, $To_Company_encryptionkey, $iv);




                        $fields1 = array(
                            'Company_username' => $To_Company_username,
                            'Company_password' => $TO_Company_password,
                            'Beneficiary_name' => $API_TO_Beneficiary_name,
                            'Beneficiary_membership_id' => $API_TO_Beneficiary_membership_id,
                            'Transfer_miles' => $API_TO_Transfer_miles,
                            'Bill_no' => $API_tp_bill2,
                            'flag' => $API_TO_Flag
                        );

                        // print_r($fields);
                        $field_string1 = $fields1;
                        $ch1 = curl_init();
                        $timeout1 = 0; //Set 0 for no timeout.
                        curl_setopt($ch1, CURLOPT_URL, $To_Transaction_url);
                        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query($field_string1));
                        curl_setopt($ch1, CURLOPT_POST, true);
                        curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, $timeout1);
                        $result1 = curl_exec($ch1);
                        if (curl_errno($ch1)) {
                            print "Error: " . curl_error($ch1);
                        }
                        if (!curl_errno($ch1)) {

                            $info = curl_getinfo($ch1);
                            //echo '----error---- ', $info['total_time'], ' seconds to send a request to ', $info['url'], "--<br>";
                        }
                        curl_close($ch1);
                        $return_result1 = json_decode($result1);
                        $Reference_id1 = 0;

                        //print_r($return_result1);
                        // print_r($return_result->status);
                        //die;
                        $Voucher_status = 44;
                        if ($return_result1->status == 1001 && $return_result1->status_message > 0) {

                            //echo"---Transfer Done--<br>";
                            $Reference_id1 = $return_result1->status_message;  //Last Inserted Id from Publisher Database
                            $Remarks1 = 'Transfer Miles';
                            $Voucher_status = 45;
                            $TransferFlag = 0;

                            /* -----------------Transfer Publisher Miles--------------------------------- */


                            $new_transferMIles = round($Transfer_miles * $From_Redemptionratio);
                            $new_transfer_miles = round($new_transferMIles / $To_Redemptionratio);

                            /* -----------------Transfer Publisher Bonus Miles--------------------------------- */



                            //'Enrollement_id' => $Beneficiary_account_id,
                            //'Card_id' => $From_beneficiary_id,

                            $TransferBonusMiles = array(
                                'Company_id' => $Company_id,
                                'Trans_type' => 28,
                                'Transfer_points' => $new_transfer_miles,
                                'Remarks' => $Remarks,
                                'Trans_date' => $lv_date_time,
                                'Enrollement_id' => $Enroll_details12->Enrollement_id,
                                'Card_id' => $Enroll_details12->Card_id,
                                'Seller' => $seller_id,
                                'Seller_name' => $Seller_name,
                                'Voucher_status' => $Voucher_status, //$Buy_miles_status, //Pending for Consolation
                                'To_Beneficiary_company_id' => $To_publisher,
                                'To_Beneficiary_company_name' => $To_Beneficiary_company_name,
                                'To_Beneficiary_cust_name' => $To_Beneficiary_name,
                                'From_Beneficiary_company_id' => $From_publisher,
                                'From_Beneficiary_company_name' => $Beneficiary_company_name,
                                'From_Beneficiary_cust_name' => $Beneficiary_name,
                                'Bill_no' => $tp_bill2,
                                'Manual_billno' => $tp_bill2,
                                'Card_id2' => $To_Beneficiary_membership_id,
                                'Enrollement_id2' => $To_Beneficiary_account_id, //From Cust Beneficiary 
                                'Send_miles_flag' => 1,
                                'Reference_id' => $Reference_id1 // Last Inserted Id from Publisher Database
                            );
                            $result = $this->Igain_model->Insert_transfer_transaction($TransferBonusMiles);
                            /* -----------------Transfer Publisher Bonus Miles--------------------------------- */



                            if ($Voucher_status == 44) {
                                $VoucherStatus = "Pending";
                            } else if ($Voucher_status == 45) {

                                $VoucherStatus = "Approved";
                            } else {

                                $VoucherStatus = "Cancelled";
                            }



                            $Email_content_From1 = array(
                                'Trans_date' => $lv_date_time,
                                'Notification_type' => 'You have Received ' . $To_Beneficiary_Currency . ' from ' . $Beneficiary_company_name,
                                'Transfer_miles' => $Transfer_miles,
                                'Purchased_Currency' => $Beneficiary_Currency,
                                'To_Beneficiary_Currency' => $To_Beneficiary_Currency,
                                'To_Equivalent' => $new_transfer_miles,
                                'From_user_email_address' => $To_user_email_address,
                                'From_Beneficiary_name' => $Beneficiary_name,
                                'From_beneficiary_id' => $From_beneficiary_id,
                                'To_Beneficiary_name' => $To_Beneficiary_name,
                                'To_Beneficiary_id' => $To_Beneficiary_membership_id,
                                'From_publisher' => $Beneficiary_company_name,
                                'To_publisher' => $To_Beneficiary_company_name,
                                'Status' => $VoucherStatus,
                                'Template_type' => 'To_transfer_miles'
                            );
                            $this->send_notification->send_Notification_email($Enrollment_id, $Email_content_From1, '0', $Company_id);


                            /* ---------------------Publisher Transfer Facilitation------------------------------ */


                            /* 'To_Beneficiary_company_id' => $To_publisher,
                              'To_Beneficiary_company_name' => $To_Beneficiary_company_name,
                              'To_Beneficiary_cust_name' => $To_Beneficiary_name,
                              'From_Beneficiary_company_id' => $From_publisher,
                              'From_Beneficiary_company_name' => $Beneficiary_company_name, */



                            // $Enroll_details12 = $this->Igain_model->get_enrollment_details($Enrollment_id);
                            // $Enroll_details12->Enrollement_id;
                            $Transfer_Facilition = array(
                                'Company_id' => $Company_id,
                                'Trans_type' => 24,
                                'Topup_amount' => $new_transfer_miles,
                                'Transfer_points' => $Transfer_miles,
                                'Remarks' => 'Publisher Transfer Facilitation',
                                'Trans_date' => $lv_date_time,
                                'Enrollement_id' => $Enroll_details12->Enrollement_id,
                                'Card_id' => $Enroll_details12->Card_id,
                                'Seller' => $seller_id,
                                'Seller_name' => $Seller_name,
                                'Voucher_status' => $Voucher_status, //$Buy_miles_status, //Pending for Consolation
                                'To_Beneficiary_company_id' => $To_publisher,
                                'To_Beneficiary_company_name' => $To_Beneficiary_company_name,
                                'To_Beneficiary_cust_name' => $To_Beneficiary_name,
                                'From_Beneficiary_company_id' => $From_publisher,
                                'From_Beneficiary_company_name' => $Beneficiary_company_name,
                                'From_Beneficiary_cust_name' => $Beneficiary_name,
                                'Bill_no' => $tp_bill2,
                                'Manual_billno' => $tp_bill2,
                                'Card_id2' => $To_Beneficiary_membership_id,
                                'Enrollement_id2' => $To_Beneficiary_account_id,
                                'Send_miles_flag' => 1
                            );

                            $result = $this->Igain_model->Insert_transfer_transaction($Transfer_Facilition);

                            if ($result == TRUE) {
                                $Email_content_Facilition = array(
                                    'Trans_date' => $lv_date_time,
                                    'Notification_type' => 'You have Transferred '.$Beneficiary_Currency. ' from ' . $Beneficiary_company_name . ' to ' . $To_Beneficiary_company_name,
                                    'Transfer_miles' => $Transfer_miles,
                                    'Purchased_Currency' => $Beneficiary_Currency,
                                    'To_Beneficiary_Currency' => $To_Beneficiary_Currency,
                                    'To_Equivalent' => $new_transfer_miles,
                                    'From_user_email_address' => $To_user_email_address,
                                    'From_Beneficiary_name' => $Beneficiary_name,
                                    'From_beneficiary_id' => $From_beneficiary_id,
                                    'To_Beneficiary_name' => $To_Beneficiary_name,
                                    'To_Beneficiary_id' => $To_Beneficiary_membership_id,
                                    'From_publisher' => $Beneficiary_company_name,
                                    'To_publisher' => $To_Beneficiary_company_name,
                                    'Status' => $VoucherStatus,
                                    'Template_type' => 'Transfer_miles_facilition'
                                );
                                $this->send_notification->send_Notification_email($Enrollment_id, $Email_content_Facilition, '0', $Company_id);
                            }

                            /* ---------------------Publisher Transfer Facilitation------------------------------ */
                        } else {

                            //echo"---Transfer Not Done--<br>";
                            $Reference_id1 = 0;
                            $Voucher_status = 46;
                            $Remarks1 = $return_result->status_message;
                            $TransferFlag = 1;
                        }
                    }

                    /* -----------------To Notification--------------------------------- */

                    $result7 = $this->Igain_model->update_topup_billno($seller_id, $billno_withyear_ref);
                    $To_Beneficiary_name = $To_get_Beneficiary_members->Beneficiary_name;
                    $Beneficiary_name = $Get_From_Beneficiary_members->Beneficiary_name;


                    $explode_to = explode(" ", $Beneficiary_name);
                    $to_first = $explode_to[0];
                    $to_last = $explode_to[1];
                    /*                     * ******************* igain Log Table ************************ */
                    $Enrollment_id = $Enrollment_id;
                    $User_id = 1;
                    $opration = 1;
                    // $userid = $User_id;
                    $what = "Transfer Miles";
                    $where = "Transfer Miles";
                    $toname = "";
                    $toenrollid = $Beneficiary_account_id;
                    $opval = $Transfer_miles;
                    $Todays_date = date("Y-m-d");
                    $firstName = $to_first; // $Enroll_details12->First_name;
                    $lastName = $to_last; //$Enroll_details12->Last_name;
                    $LogginUserName = $Beneficiary_name; //$Enroll_details12->First_name.' '.$Enroll_details12->Last_name;
                    $result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'], $Enrollment_id, $data['username'], $LogginUserName, $Todays_date, $what, $where, $User_id, $opration, $opval, $firstName, $lastName, $toenrollid);
                    /*                     * ******************* igain Log Table ************************ */

                    if ($TransferFlag == 0) {

                        $this->load->view('front/transferpublisher/transfer_complete', $data);
                    } else {

                        $this->load->view('front/transferpublisher/transfer_failed', $data);
                    }
                } else {

                    $this->load->view('front/transferpublisher/transfer_failed', $data);
                }
            }
        } else {
            redirect('login');
        }
    }

    public function Get_publisher_current_balance() {


        if ($this->session->userdata('cust_logged_in')) {

            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];
            $data['enroll'] = $session_data['enroll'];
            $data['userId'] = $session_data['userId'];
            $data['Card_id'] = $session_data['Card_id'];
            $data['Company_id'] = $session_data['Company_id'];
            $Company_id = $session_data['Company_id'];
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time = $date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');
            $Trans_date = $date->format('Y-m-d');

            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Customer_name = $Enroll_details12->First_name . ' ' . $Enroll_details12->Last_name;
            $Company_id = $Enroll_details12->Company_id;
            $Membership_id = $Enroll_details12->Card_id;
            $Enrollment_id = $Enroll_details12->Enrollement_id;
            $Login_Current_balance = $Enroll_details12->Current_balance - $Enroll_details12->Blocked_points;
            $Login_Total_topup_amt = $Enroll_details12->Total_topup_amt;

            $Login_Company_Details = $this->Igain_model->get_company_details($data['Company_id']);
            $Login_Redemptionratio = $Login_Company_Details->Redemptionratio;
            $data["Company_name"] = $Login_Company_Details->Company_name;
            $Company_name = $Login_Company_Details->Company_name;

            $data["Get_Beneficiary_members"] = $this->Transfer_publisher_model->Get_Beneficiary_members($data['Company_id'], $Enrollment_id);

            // ------------------------------------Template Configuration------------------------------------ //
            $data['Small_font_details'] = $this->Small_font_details;
            $data['Medium_font_details'] = $this->Medium_font_details;
            $data['Large_font_details'] = $this->Large_font_details;
            $data['Extra_large_font_details'] = $this->Extra_large_font_details;
            $data['Button_font_details'] = $this->Button_font_details;
            $data['General_details'] = $this->General_details;
            $data['Value_font_details'] = $this->Value_font_details;
            $data['Footer_font_details'] = $this->Footer_font_details;
            $data['Placeholder_font_details'] = $this->Placeholder_font_details;
            $data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
            // ------------------------------Template Configuration---------------------- //

            if ($_POST == NULL) {
                $this->load->view('front/transferpublisher/from_publisher', $data);
            } else {
                $FromBeneficiaryID = $_REQUEST["FromBeneficiaryID"];
                $Beneficiary_company_id = $_REQUEST["PublisherID"];

                if ($FromBeneficiaryID != "" && $Beneficiary_company_id != "") {

                    $Super_Seller_details = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                    $seller_id = $Super_Seller_details->Enrollement_id;
                    $Seller_name = $Super_Seller_details->First_name . ' ' . $Super_Seller_details->Last_name;
                    $top_db2 = $Super_Seller_details->Topup_Bill_no;
                    $len2 = strlen($top_db2);
                    $str2 = substr($top_db2, 0, 5);
                    $tp_bill2 = substr($top_db2, 5, $len2);
                    $topup_BillNo2 = $tp_bill2 + 1;
                    $billno_withyear_ref = $str2 . $topup_BillNo2;

                    $data['Beneficiary_Company_details'] = $this->Beneficiary_model->Get_Beneficiary_Company_2($Beneficiary_company_id);
                    foreach ($data['Beneficiary_Company_details'] as $key => $value) {
                        $Authentication_url = $value->Authentication_url;
                        $Transaction_url = $value->Transaction_url;
                        $Company_username = $value->Company_username;
                        $Company_password = $value->Company_password;
                        $Company_encryptionkey = $value->Company_encryptionkey;
                        $Beneficiary_company_name = $value->Beneficiary_company_name;
                        $Beneficiary_Currency = $value->Currency;
                        $Company_logo = $value->Company_logo;
                    }

                    $data['Get_Beneficiary_members'] = $this->Beneficiary_model->Get_Beneficiary_members_2($Beneficiary_company_id, $FromBeneficiaryID, $Enrollment_id);


                    $Beneficiary_account_id = $data['Get_Beneficiary_members']->Beneficiary_account_id;
                    $Beneficiary_membership_id = $data['Get_Beneficiary_members']->Beneficiary_membership_id;
                    $Beneficiary_name = $data['Get_Beneficiary_members']->Beneficiary_name;


                    if (strcmp($Beneficiary_membership_id, $FromBeneficiaryID) == 0) {

                        $iv = '56666852251557009888889955123458';
                        $Company_password = $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);
                        $API_Beneficiary_name = $this->string_encrypt($Beneficiary_name, $Company_encryptionkey, $iv);
                        $API_Beneficiary_membership_id = $this->string_encrypt($Beneficiary_membership_id, $Company_encryptionkey, $iv);
                        $API_Purchase_miles = $this->string_encrypt($Purchase_miles, $Company_encryptionkey, $iv);
                        $API_tp_bill2 = $this->string_encrypt($tp_bill2, $Company_encryptionkey, $iv);
                        $API_Flag = $this->string_encrypt(4, $Company_encryptionkey, $iv);


                        $fields = array(
                            'Company_username' => $Company_username,
                            'Company_password' => $Company_password,
                            'Beneficiary_name' => $API_Beneficiary_name,
                            'Beneficiary_membership_id' => $API_Beneficiary_membership_id,
                            'flag' => $API_Flag
                        );

                        $field_string = $fields;
                        $ch = curl_init();
                        $timeout = 0; // Set 0 for no timeout.
                        curl_setopt($ch, CURLOPT_URL, $Transaction_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string));
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {

                            print "Error: " . curl_error($ch);
                        }
                        if (!curl_errno($ch)) {

                            $info = curl_getinfo($ch);
                        }
                        curl_close($ch);
                        $return_result = json_decode($result);
                        // print_r($return_result);
                        // print_r($return_result->status);
                        // die;
                        if ($return_result->status == 1001 && $return_result->status_message > 0) {

                            // echo"---Purchase Done--<br>"; 
                            //$Result=$return_result->status_message->Current_balance;  //Last Inserted Id from Publisher Database
                            $Result = array('status' => $return_result->status, 'status_message' => $return_result->status_message->Current_balance);
                        } else {

                            $Result = array('status' => $return_result->status, 'status_message' => $return_result->status_message->Current_balance);
                        }

                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($Result));
                    } else {

                        echo json_encode(array("status" => '2001', "message" => 'Invalid Identifier'));
                    }
                } else {

                    $this->load->view('front/transferacross/transfer_failed', $data);
                }
            }
        } else {

            redirect('login');
        }
    }

    public function create_publisher_new_account() {


        if ($this->session->userdata('cust_logged_in')) {

            // $this->output->enable_profiler(TRUE);
            $session_data = $this->session->userdata('cust_logged_in');
			$Walking_customer = $session_data['Walking_customer'];
			if($Walking_customer == 1)
			{
				redirect('shopping');
			}
            $data['username'] = $session_data['username'];
            $data['enroll'] = $session_data['enroll'];
            $data['userId'] = $session_data['userId'];
            $data['Card_id'] = $session_data['Card_id'];
            $data['Company_id'] = $session_data['Company_id'];
            $Company_id = $session_data['Company_id'];
            $logtimezone = $session_data['timezone_entry'];
            $timezone = new DateTimeZone($logtimezone);
            $date = new DateTime();
            $date->setTimezone($timezone);
            $lv_date_time = $date->format('Y-m-d H:i:s');
            $Todays_date = $date->format('Y-m-d');
            $Trans_date = $date->format('Y-m-d');

            $data["Enroll_details"] = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Enroll_details12 = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Customer_name = $Enroll_details12->First_name . ' ' . $Enroll_details12->Last_name;
            $Company_id = $Enroll_details12->Company_id;
            $Membership_id = $Enroll_details12->Card_id;
            $Enrollment_id = $Enroll_details12->Enrollement_id;
            $Login_Current_balance = $Enroll_details12->Current_balance - $Enroll_details12->Blocked_points;
            $Login_Total_topup_amt = $Enroll_details12->Total_topup_amt;

            $Login_Company_Details = $this->Igain_model->get_company_details($data['Company_id']);
            $Login_Redemptionratio = $Login_Company_Details->Redemptionratio;
            $data["Company_name"] = $Login_Company_Details->Company_name;
            $Company_name = $Login_Company_Details->Company_name;

            $data["Get_Beneficiary_members"] = $this->Transfer_publisher_model->Get_Beneficiary_members($data['Company_id'], $Enrollment_id);

            // ------------------------------------Template Configuration------------------------------------ //
            $data['Small_font_details'] = $this->Small_font_details;
            $data['Medium_font_details'] = $this->Medium_font_details;
            $data['Large_font_details'] = $this->Large_font_details;
            $data['Extra_large_font_details'] = $this->Extra_large_font_details;
            $data['Button_font_details'] = $this->Button_font_details;
            $data['General_details'] = $this->General_details;
            $data['Value_font_details'] = $this->Value_font_details;
            $data['Footer_font_details'] = $this->Footer_font_details;
            $data['Placeholder_font_details'] = $this->Placeholder_font_details;
            $data['icon_src'] = $this->General_details[0]['Theme_icon_color'];
            // ------------------------------Template Configuration---------------------- //

            if ($_POST == NULL) {

                $this->load->view('front/transferacross/Add_beneficiary', $data);
            } else {

                $FromBeneficiaryID = $_REQUEST["PublisherID"];
                $enrollID = $_REQUEST["enrollID"];
                //echo"--FromBeneficiaryID--".$FromBeneficiaryID."---<br>";
                //echo"--enrollID--".$enrollID."---<br>";
                if ($FromBeneficiaryID != "" && $enrollID != "") {

                    $Super_Seller_details = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
                    $seller_id = $Super_Seller_details->Enrollement_id;
                    $Seller_name = $Super_Seller_details->First_name . ' ' . $Super_Seller_details->Last_name;
                    $top_db2 = $Super_Seller_details->Topup_Bill_no;
                    $len2 = strlen($top_db2);
                    $str2 = substr($top_db2, 0, 5);
                    $tp_bill2 = substr($top_db2, 5, $len2);
                    $topup_BillNo2 = $tp_bill2 + 1;
                    $billno_withyear_ref = $str2 . $topup_BillNo2;

                    $data['Beneficiary_Company_details'] = $this->Beneficiary_model->Get_Beneficiary_Company_2($FromBeneficiaryID);
                    foreach ($data['Beneficiary_Company_details'] as $key => $value) {
                        $Authentication_url = $value->Authentication_url;
                        $Transaction_url = $value->Transaction_url;
                        $Company_username = $value->Company_username;
                        $Company_password = $value->Company_password;
                        $Company_encryptionkey = $value->Company_encryptionkey;
                        $Beneficiary_company_name = $value->Beneficiary_company_name;
                        $Beneficiary_Currency = $value->Currency;
                        $Company_logo = $value->Company_logo;
                        $Register_beneficiary_id = $value->Register_beneficiary_id;
                    }

                    // echo"--Beneficiary_Company_details--".print_r($data['Beneficiary_Company_details'])."---<br>";



                    /* $data['Get_Beneficiary_members']= $this->Beneficiary_model->Get_Beneficiary_members_2($Beneficiary_company_id,$FromBeneficiaryID,$Enrollment_id);

                      $Result = array('status' =>1, 'status_message' =>$data['Get_Beneficiary_members']);
                      $Beneficiary_account_id=$data['Get_Beneficiary_members']->Beneficiary_account_id;
                      $Beneficiary_membership_id=$data['Get_Beneficiary_members']->Beneficiary_membership_id;
                      $Beneficiary_name=$data['Get_Beneficiary_members']->Beneficiary_name;

                      echo"--Register_beneficiary_id--".$Register_beneficiary_id."---<br>"; */



                    if ($FromBeneficiaryID == $Register_beneficiary_id) {

                        // echo"--$FromBeneficiaryID == $Register_beneficiary_id--<br>";
                        //echo"--Register_beneficiary_id--".$Register_beneficiary_id."---<br>";
                        //echo"--FromBeneficiaryID--".$FromBeneficiaryID."---<br>";


                        $Enroll_details12 = $this->Igain_model->get_enrollment_details($enrollID);
                        $Customer_First_name = $Enroll_details12->First_name;
                        $Customer_Last_name = $Enroll_details12->Last_name;
                        $Company_id = $Enroll_details12->Company_id;
                        $Membership_id = $Enroll_details12->Card_id;
                        $Enrollment_id = $Enroll_details12->Enrollement_id;
                        $Customer_Current_address = $Enroll_details12->Current_address;
                        $Customer_User_email_id = $Enroll_details12->User_email_id;
                        $Customer_State = $Enroll_details12->State;
                        $Customer_District = $Enroll_details12->District;
                        $Customer_City = $Enroll_details12->City;
                        $Customer_Zipcode = $Enroll_details12->Zipcode;
                        $Customer_Country = $Enroll_details12->Country;
                        $Customer_timezone_entry = $Enroll_details12->timezone_entry;
                        $Customer_Phone_no = $Enroll_details12->Phone_no;
                        $Customer_Date_of_birth = $Enroll_details12->Date_of_birth;
                        $Customer_Sex = $Enroll_details12->Sex;
                        $Customer_Married = $Enroll_details12->Married;
                        $Customer_Wedding_annversary_date = $Enroll_details12->Wedding_annversary_date;
                        $Customer_state_name = $Enroll_details12->state_name;
                        $Customer_city_name = $Enroll_details12->city_name;
                        $Customer_country_name = $Enroll_details12->country_name;





                        $iv = '56666852251557009888889955123458';
                        $Company_password = $this->string_encrypt($Company_password, $Company_encryptionkey, $iv);
                        $API_Beneficiary_name = $this->string_encrypt($Beneficiary_name, $Company_encryptionkey, $iv);

                        $Customer_First_name = $this->string_encrypt($Customer_First_name, $Company_encryptionkey, $iv);
                        $Customer_Last_name = $this->string_encrypt($Customer_Last_name, $Company_encryptionkey, $iv);
                        $Customer_Current_address = $this->string_encrypt($Customer_Current_address, $Company_encryptionkey, $iv);
                        $Customer_User_email_id = $this->string_encrypt($Customer_User_email_id, $Company_encryptionkey, $iv);
                        $Customer_State = $this->string_encrypt($Customer_State, $Company_encryptionkey, $iv);
                        $Customer_District = $this->string_encrypt($Customer_District, $Company_encryptionkey, $iv);
                        $Customer_City = $this->string_encrypt($Customer_City, $Company_encryptionkey, $iv);
                        $Customer_Zipcode = $this->string_encrypt($Customer_Zipcode, $Company_encryptionkey, $iv);
                        $Customer_Country = $this->string_encrypt($Customer_Country, $Company_encryptionkey, $iv);
                        $Customer_timezone_entry = $this->string_encrypt($Customer_timezone_entry, $Company_encryptionkey, $iv);
                        $Customer_Phone_no = $this->string_encrypt($Customer_Phone_no, $Company_encryptionkey, $iv);
                        $Customer_Date_of_birth = $this->string_encrypt($Customer_Date_of_birth, $Company_encryptionkey, $iv);
                        $Customer_Sex = $this->string_encrypt($Customer_Sex, $Company_encryptionkey, $iv);
                        $Customer_Married = $this->string_encrypt($Customer_Married, $Company_encryptionkey, $iv);
                        $Customer_Wedding_annversary_date = $this->string_encrypt($Customer_Wedding_annversary_date, $Company_encryptionkey, $iv);
                        $Customer_state_name = $this->string_encrypt($Customer_state_name, $Company_encryptionkey, $iv);
                        $Customer_city_name = $this->string_encrypt($Customer_city_name, $Company_encryptionkey, $iv);
                        $Customer_country_name = $this->string_encrypt($Customer_country_name, $Company_encryptionkey, $iv);
                        $API_Flag = $this->string_encrypt(7, $Company_encryptionkey, $iv);



                        /*

                         * 
                          'Customer_State' => $Customer_State,
                          'Customer_District' => $Customer_District,
                          'Customer_City' => $Customer_City,
                          'Customer_Zipcode' => $Customer_Zipcode,
                          'Customer_Country' => $Customer_Country,
                          'Customer_timezone_entry' => $Customer_timezone_entry,
                          'Customer_Date_of_birth' => $Customer_Date_of_birth,
                          'Customer_Sex' => $Customer_Sex,
                          'Customer_Married' => $Customer_Married,
                          'Customer_Wedding_annversary_date' => $Customer_Wedding_annversary_date,
                          'Customer_state_name' => $Customer_state_name,
                          'Customer_city_name' => $Customer_city_name,
                          'Customer_country_name' => $Customer_country_name,
                          'Customer_Current_address' => $Customer_Current_address, */

                        $cust_fields = array(
                            'Company_username' => $Company_username,
                            'Company_password' => $Company_password,
                            'Customer_First_name' => $Customer_First_name,
                            'Customer_Last_name' => $Customer_Last_name,
                            'Customer_User_email_id' => $Customer_User_email_id,
                            'Customer_Phone_no' => $Customer_Phone_no,
                            'flag' => $API_Flag
                        );

                        $field_string12 = $cust_fields;
                        $ch = curl_init();
                        $timeout = 0; // Set 0 for no timeout.
                        curl_setopt($ch, CURLOPT_URL, $Authentication_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field_string12));
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {

                            print "Error: " . curl_error($ch);
                        }
                        if (!curl_errno($ch)) {

                            $info = curl_getinfo($ch);
                        }
                        curl_close($ch);
                        $return_result = json_decode($result);

                        //print_r($return_result);
                        //print_r($return_result->status);
                        //die;

                        $VoucherStatus = "Pending";
                        if ($return_result->status == 1001 && $return_result->status_message > 0) {

                            // echo"---Purchase Done--<br>"; 
                            //$Result=$return_result->status_message->Current_balance;  //Last Inserted Id from Publisher Database
                            $Result = array('status' => $return_result->status, 'status_message' => $return_result->status_message);
                            $VoucherStatus = "Active";
                        } else {

                            $Result = array('status' => $return_result->status, 'status_message' => $return_result->status_message);
                            $VoucherStatus = "Pending";
                        }

                        if ($return_result->status == 1001) {




                            $$lv_Beneficiary_company_id = $return_result->status_message->Company_id;
                            $lv_Beneficiary_name = $return_result->status_message->First_name . ' ' . $return_result->status_message->Last_name;
                            $lv_Beneficiary_membership_id = $return_result->status_message->Card_id;


                            $post_data['Company_id'] = $Company_id;
                            $post_data['Membership_id'] = $Enroll_details12->Card_id;
                            $post_data['Enrollment_id'] = $Enrollment_id;
                            $post_data['Beneficiary_company_id'] = $Register_beneficiary_id;
                            $post_data['Beneficiary_name'] = $lv_Beneficiary_name;
                            $post_data['Beneficiary_membership_id'] = $lv_Beneficiary_membership_id;
                            $post_data['Create_date'] = $lv_date_time;
                            $post_data['Self_enroll'] = 1;
                            $post_data['Active_flag'] = 1;
                            $post_data['Beneficiary_status'] = 1;

                            $insert_Beneficairy = $this->Beneficiary_model->insert_Beneficairy($post_data);





                            $Email_new_account = array(
                                'Trans_date' => $lv_date_time,
                                'Notification_type' => 'Regarding your new Enrollment Request with ' . $Beneficiary_company_name,
                                'From_user_email_address' => $Enroll_details12->User_email_id,
                                'From_user_phone_no' => $Enroll_details12->Phone_no,
                                'From_publisher' => $Beneficiary_company_name,
                                'Status' => $VoucherStatus,
                                'Template_type' => 'Publisher_new_account'
                            );
                            $this->send_notification->send_Notification_email($Enrollment_id, $Email_new_account, '0', $Company_id);
                        }


                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($Result));
                    } else {

                        echo json_encode(array("status" => '2001', "message" => 'Invalid Identifier'));
                    }
                } else {

                    $this->load->view('front/transferacross/transfer_failed', $data);
                }
            }
        } else {

            redirect('login');
        }
    }

    public function string_encrypt($string, $key, $iv) {

        $version = phpversion();
        // echo "-------version----".$version."---------------<br>";
        $new_version = substr($version, 0, 1);

        //echo "-------new_version----".$new_version."---------------<br>";
        if ($new_version >= 7) {

            $first_key = base64_decode($key);
            $second_key = base64_decode($key);

            $method = "aes-256-cbc";
            $iv_length = openssl_cipher_iv_length($method);
            $iv = openssl_random_pseudo_bytes($iv_length);

            $first_encrypted = openssl_encrypt($string, $method, $first_key, OPENSSL_RAW_DATA, $iv);
            $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);

            $output = base64_encode($iv . $second_encrypted . $first_encrypted);
            // echo "--input---output--".$output."------<br><br>";

            return $output;
        } else {

            $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
            $padding = $block - (strlen($string) % $block);
            $string .= str_repeat(chr($padding), $padding);

            $crypted_text = mcrypt_encrypt
                    (
                    MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC, $iv
            );
            return base64_encode($crypted_text);
        }
    }

    public function string_decrypt($encrypted_string, $key, $iv) {

        // echo "-------string_decrypt--------------<br>";
        $version = phpversion();
        //echo "-------version----".$version."---------------<br>";
        $new_version = substr($version, 0, 1);

        // echo "-------new_version----".$new_version."---------------<br>";
        if ($new_version >= 7) {


            $first_key = base64_decode($key);
            $second_key = base64_decode($key);
            $mix = base64_decode($encrypted_string);

            $method = "aes-256-cbc";
            $iv_length = openssl_cipher_iv_length($method);

            $iv = substr($mix, 0, $iv_length);
            $second_encrypted = substr($mix, $iv_length, 64);
            $first_encrypted = substr($mix, $iv_length + 64);

            $data = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);


            //echo "--Output-data--".$data."------<br><br>";

            return $data;
        } else {

            return mcrypt_decrypt
                    (
                    MCRYPT_RIJNDAEL_256, $key, base64_decode($encrypted_string), MCRYPT_MODE_CBC, $iv
            );
        }
    }

}
