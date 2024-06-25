<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Coal_Data_transform extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->library('session');
      $this->load->library('pagination');
      $this->load->database();
      $this->load->helper('url');
      $this->load->model('login/Login_model');
      $this->load->model('Coal_transactions/Coal_Transactions_model');
      $this->load->model('Igain_model');
      $this->load->library('Send_notification');
      $this->load->model('Data_transform/Data_transform_model');
      $this->load->model('master/currency_model');
      $this->load->model('Segment/Segment_model');
      $this->load->library("excel");
      $this->load->library('m_pdf');
      $this->load->helper('file');
    }

    public function data_map() {
      if ($this->session->userdata('logged_in')) {

        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
        $data['Seller_array'] = $get_sellers;

        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Coal_Data_transform/data_map";
        $total_row = $this->Data_transform_model->data_map_count($Company_id);
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

        $data["results"] = $this->Data_transform_model->data_map_list($config["per_page"], $page, $Company_id, $data['Super_seller'], $Logged_user_enrollid);
        $data["pagination"] = $this->pagination->create_links();

        $this->load->view("Coal_Data_transform/Coal_new_data_mapping", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function insert_data_map() {
      if ($this->session->userdata('logged_in')) {

        $post_data['Column_Company_id'] = $this->input->post('Column_Company_id');
        $post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id');
        $post_data['Column_Date'] = $this->input->post('Column_Date');
        $post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
        $post_data['Column_Bill_no'] = $this->input->post('Column_Bill_no');
        $post_data['Column_Amount'] = $this->input->post('Column_Amount');
        $post_data['Column_Payment_type'] = $this->input->post('Column_Payment_type');
        $post_data['Column_date_format'] = $this->input->post('Column_date_format');
        $post_data['Column_Customer'] = $this->input->post('Column_Customer');
        $post_data['Column_Quantity'] = $this->input->post('Column_Quantity');
        $post_data['Column_Item_Code'] = $this->input->post('Column_Item_Code');
        $post_data['Column_Status'] = $this->input->post('Column_Status');
        $post_data['Column_remarks'] = $this->input->post('Column_remarks');
        $post_data['Data_map_for'] = 2;

        $Seller_id = $this->input->post('Column_Seller_id');
        $Company_id = $this->input->post('Column_Company_id');
        $exist_merchant_array = array();
        if ($Seller_id == 0) {//All
          $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
          $flag = 0;
          foreach ($get_sellers as $Sellers_id) {
            $Seller_id2 = $Sellers_id->Enrollement_id;
            $post_data['Column_Seller_id'] = $Sellers_id->Enrollement_id;
            $result_count2 = $this->Data_transform_model->check_exist_data_map_seller($Seller_id2, $Company_id);
            if ($result_count2 == 0) {
              $result2222 = $this->Data_transform_model->insert_data_map($post_data);
              $flag = 1;
            } else {
              array_push($exist_merchant_array, $Sellers_id->First_name);
              $Join_names = implode(",", $exist_merchant_array);
            }
          }
          if (count($exist_merchant_array) == 0) {
            $this->session->set_flashdata("map_success_message", "Data map created Successfuly for All Merchant(s)!!!");
          } elseif (count($exist_merchant_array) != 0 && $flag == 1) {
            $this->session->set_flashdata("map_success_message", "Data map created Successfuly!!!<br>Data map already exist for Merchant(s) ($Join_names) !!!");
          } elseif (count($exist_merchant_array) != 0 && $flag == 0) {
            $this->session->set_flashdata("map_success_message", "Data map already exist for All Merchant(s)  !!!");
          }
        } else {
          $get_seller_name = $this->Igain_model->get_enrollment_details($Seller_id);
          $Merchant = $get_seller_name->First_name;
          $result_count = $this->Data_transform_model->check_exist_data_map_seller($Seller_id, $Company_id);
          //echo "count-->".$result_count;die;
          if ($result_count == 0) {
            $result222 = $this->Data_transform_model->insert_data_map($post_data);
            if ($result222 == true) {
              $this->session->set_flashdata("map_success_message", "Data map created Successfuly!!");
            } else {
              $this->session->set_flashdata("map_success_message", "Data map not created Successfuly!!");
            }
          } else {
            $this->session->set_flashdata("map_success_message", "Data map already exist for Merchant ($Merchant)!!");
          }
        }

        redirect('Coal_Data_transform/data_map');
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function update_data_map() {
      if ($this->session->userdata('logged_in')) {

        /* $post_data['Column_Company_id'] = $this->input->post('Column_Company_id');
          $post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id'); */
        $post_data['Column_Date'] = $this->input->post('Column_Date');
        $post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
        $post_data['Column_Bill_no'] = $this->input->post('Column_Bill_no');
        $post_data['Column_Amount'] = $this->input->post('Column_Amount');
        $post_data['Column_Payment_type'] = $this->input->post('Column_Payment_type');
        $post_data['Column_date_format'] = $this->input->post('Column_date_format');
        $post_data['Column_Customer'] = $this->input->post('Column_Customer');
        $post_data['Column_Quantity'] = $this->input->post('Column_Quantity');
        $post_data['Column_Item_Code'] = $this->input->post('Column_Item_Code');
        $post_data['Column_Status'] = $this->input->post('Column_Status');
        $post_data['Column_remarks'] = $this->input->post('Column_remarks');
        $post_data['Data_map_for'] = 2;

        $Map_id = $this->input->post('Map_id');

        $result222 = $this->Data_transform_model->update_data_map($post_data, $Map_id);

        $this->session->set_flashdata("map_success_message", "Data map Updated Successfuly!!");


        redirect('Coal_Data_transform/data_map');
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function delete_data_mapping() {
      $Map_id = $_GET['Map_id'];
      $this->Data_transform_model->delete_data_mapping($Map_id);
      $this->session->set_flashdata("map_success_message", "Data map deleted Successfuly!!");
      redirect('Coal_Data_transform/data_map');
    }

    public function edit_data_map() {
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

        $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
        $data['Seller_array'] = $get_sellers;

        /* -----------------------Pagination--------------------- */
        $config = array();
        $config["base_url"] = base_url() . "/index.php/Coal_Data_transform/new_data_mapping";
        $total_row = $this->Data_transform_model->data_map_count($Company_id);
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

        $data["results"] = $this->Data_transform_model->data_map_list($config["per_page"], $page, $Company_id, $data['Super_seller'], $Logged_user_enrollid);
        $data["pagination"] = $this->pagination->create_links();

        $Map_id = $_GET['Map_id'];
        $data["Records"] = $this->Data_transform_model->get_data_mapping($Map_id);

        $this->load->view("Coal_Data_transform/Coal_new_edit_data_mapping", $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    /*     * *************************** Amit Work End ******************************* */

    /*     * *************************** Sandeep Work Start ******************************* */

    /*     * *** Data file upload ******* */

    public function upload_data() {
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
        $data['userId'] = $session_data['userId'];

        //echo "-----Company_id---".$data['Company_id'];
        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        $data["DataMaping"] = $this->Data_transform_model->get_datamaping_details($Company_id, $Logged_user_id, $Logged_user_enrollid);

        $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id);


        /*         * **************Get sellers************************************** */
        $get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
        if ($get_sellers15 != NULL) {
          foreach ($get_sellers15 as $seller_val) {
            $superSellerFlag = $seller_val->Super_seller;
          }
        }
        if ($Logged_user_id > 2 || $superSellerFlag == 1) {
          $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
        } else {
          $get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
        }
        $data['Seller_array'] = $get_sellers;
        /*         * ****************************************************************** */

        $user_details = $this->Igain_model->get_enrollment_details( $data['enroll']);
           $Seller_Country_id = $user_details->Country_id;
          $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
          $data['Symbol_currency'] = $currency_details->Symbol_of_currency;
        

        if ($_POST == NULL) {
          $this->load->view("Coal_Data_transform/Coal_upload_data_file", $data);
        } else {

          /* -----------------------File Upload--------------------- */
          $config['upload_path'] = './Data_uploads/';
          $config['allowed_types'] = 'xlsx|xls|csv';
          $config['max_size'] = '1000';
          $config['max_width'] = '1920';
          $config['max_height'] = '1280';
          $config['encrypt_name'] = 'false';
          $config['overwrite'] = 'true';

          $this->load->library('upload', $config);
          $this->upload->initialize($config);

          /* if (!$this->upload->do_upload("file")) {
            $this->session->set_flashdata("upload_error_code", $this->upload->display_errors());
            $filepath = "";
            $filename = "";
            $block_me = 0;
            } else {
            $data = array('upload_data' => $this->upload->data("file"));
            $filepath = "Data_uploads/" . $data['upload_data']['file_name'];
            $filename = $data['upload_data']['file_name'];
            $block_me = 1;
            }

           */



          $configThumb = array();
          $configThumb['image_library'] = 'gd2';
          $configThumb['source_image'] = '';
          $configThumb['create_thumb'] = TRUE;
          $configThumb['maintain_ratio'] = TRUE;

          $configThumb['width'] = 128;
          $configThumb['height'] = 128;
          /* Load the image library */
          $this->load->library('image_lib');


          $upload22 = $this->upload->do_upload('file');
          $data22 = $this->upload->data();
          if ($data22['is_image'] == 1) {
            $filepath = "";
            $filename = "";
            $block_me = 0;
          } else {
            $configThumb['source_image'] = $data22['full_path'];
            $configThumb['source_image'] = './Data_uploads/' . $upload22;
            $this->image_lib->initialize($configThumb);
            $this->image_lib->resize();
            $filepath = 'Data_uploads/' . $data22['file_name'];
            $filename = $data22['file_name'];
            $block_me = 1;
          }

          // echo " - filename --".$filename."---<br>";
          // echo " - filepath --".$filepath."----<br>";

          /* -----------------------File Upload--------------------- */
          $data['LogginUserName'] = $session_data['Full_name'];

          $seller_id = $this->input->post('seller_id');


          $get_selected_sellers = $this->Igain_model->get_enrollment_details($seller_id);
          $data['seller_id'] = $get_selected_sellers->Enrollement_id;
          $data['Selected_seller_name'] = $get_selected_sellers->First_name . ' ' . $get_selected_sellers->Last_name;
          $file_status = $this->Data_transform_model->upload_data_map_file($filepath, $filename, $Company_id, $Logged_user_enrollid);

          $data['file_status'] = $file_status;

          $data['file_status'] = $file_status['Upload_status'];
          $data['Total_error_count'] = $file_status['Total_error_count'];
          $data['Total_row'] = $file_status['Total_row'];
          $data['Error_row'] = $file_status['Error_row'];
          $data['Success_row'] = $file_status['Success_row'];
          $data['filename'] = $filename;

          $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);



          $data['UploadData'] = $this->Data_transform_model->get_upload_file_data($Logged_user_enrollid);
          $data['UploadData2'] = $this->Data_transform_model->get_upload_file_data_for_transaction($Logged_user_enrollid);

          $data['Upload_errors'] = $this->Data_transform_model->get_upload_errors($filename, $Company_id);

          $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id);
          if ($file_status == 3 && $data['UploadData'] == NULL) {
            $this->session->set_flashdata("data_map_error_code", "Data File is Uploaded Successfully, Transactions not found between from date and till date!!");
          } else {
            $this->session->set_flashdata("data_map_error_code", "Data File is Uploaded Successfully, Please verify all data given table below..!!");
          }


          /* if($file_status > 0 && $block_me == 1)
            {
            $this->session->set_flashdata("data_map_error_code","Data File is Uploaded Successfully, Please Verify All Data table below..!!");
            }
            else
            {
            $this->session->set_flashdata("data_map_error_code","Transactions are already exist!");
            }
           */


          /*           * *************Get sellers************************************** */
          $get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);

          if ($get_sellers15 != NULL) {
            foreach ($get_sellers15 as $seller_val) {
              $superSellerFlag = $seller_val->Super_seller;
            }
          }

          if ($Logged_user_id > 2 || $superSellerFlag == 1) {
            $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
          } else {
            $get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
          }

          $data['Seller_array'] = $get_sellers;
          /*           * ****************************************************************** */
          $data['Company_id'] = $session_data['Company_id'];
          $data['Super_seller'] = $session_data['Super_seller'];
          $data['enroll'] = $session_data['enroll'];
          $this->load->view("Coal_Data_transform/Coal_verify_data_file", $data);
        }
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function get_loyalty_program() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $Company_id = $session_data['Company_id'];
        $seller_id = $this->input->post("seller_id");

        $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id, $seller_id, 2);

        //$data['lp_array'] = $ref_array;

        $this->load->view('Coal_Data_transform/Coal_view_loyalty_program_seller_list', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function get_loyalty_program_details() {
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $Logged_user_enroll = $session_data['enroll'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $Loyalty_names = $this->input->post("Loyalty_names");
        $selected_seller = $this->input->post("selected_seller");

        $data['lp_array'] = $this->Data_transform_model->get_loyaltyrule_details($Loyalty_names, $Company_id, $selected_seller);
        ///print_r($data['lp_array']);
        //$data['lp_array'] = $ref_array;

        $this->load->view('view_loyalty_program_details', $data);
      } else {
        redirect('Login', 'refresh');
      }
    }

    public function verify_data_file() {
      error_reporting(0);

      if ($this->session->userdata('logged_in')) {

        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
        if ($data['Super_seller'] == 1) {
          $seller_id = $_REQUEST["seller_id"];
        } else {
          $seller_id = $data['enroll'];
        }


        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
        $Company_finance_email_id = $company_details2->Company_finance_email_id;
        $data["Company_details"] = $company_details2;

        
        
         $user_details = $this->Igain_model->get_enrollment_details( $data['enroll']);
           $Seller_Country_id = $user_details->Country_id;
          $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
          $data['Symbol_currency'] = $currency_details->Symbol_of_currency;


        if ($_POST == NULL) {
          $data['UploadData'] = $this->Data_transform_model->get_upload_file_data($Logged_user_enrollid);

          $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id);



          $this->load->view("Coal_Data_transform/Coal_verify_data_file", $data);
        } else {


          $seller_id = $this->input->post("seller_id");
          $Total_error_count = $this->input->post("Total_error_count");
          $Total_row = $this->input->post("Total_row");
          $Error_row = $this->input->post("Error_row");
          $Success_row = $this->input->post("Success_row");

          $Loyalty_names = $_REQUEST["lp_rules"];

          $data["DataMaping"] = $this->Data_transform_model->get_datamaping_details($Company_id, $Logged_user_id, $Logged_user_enrollid);


          $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id, $Logged_user_enrollid, $Logged_user_id);


          $company_details2 = $this->Igain_model->get_company_details($Company_id);
          $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
          $data["Company_details"] = $company_details2;

          $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
          $data['Seller_array'] = $get_sellers;

          //$loyalty_rule_id = $this->input->post("lp_rules");

          $UploadData = $this->Data_transform_model->get_upload_file_data_for_transaction($Logged_user_enrollid);

          foreach ($UploadData as $row) {

            $cardId = $row->Pos_Customerno;
            $manual_bill_no = $row->Pos_Billno;
            $bal_pay = $row->Pos_Billamt;
            //$bal_pay = $row->Total_amount;
            //$Todays_date = date("Y-m-d");	
            $Pos_Transdate = $row->Pos_Transdate;
            $PayMentBy = $row->Pos_Payment_type;
            $Flatfile_remarks = $row->Remarks;
            $Quantity = $row->Pos_Quantity;
            $Remarks = $row->Remarks;
            $Item_Code = $row->Column_Item_Code;
            $Status = $row->Status;

            $total_loyalty_points = 0;
            $loyalty_points = 0;

          //  echo"<pre>";
            
           // echo "----cardId---" . $cardId . "----<br>";
            
           /* echo "----PayMentBy---" . $PayMentBy . "--<br>";
            echo "----cardId---" . $cardId . "--<br>";
            echo "----manual_bill_no---" . $manual_bill_no . "--<br>";
            echo "----bal_pay---" . $bal_pay . "--<br>";
            echo "----Pos_Transdate---" . $Pos_Transdate . "--<br>";
            echo "----Flatfile_remarks---" . $Flatfile_remarks . "--<br>";
            echo "----Quantity---" . $Quantity . "--<br>";
            echo "----Remarks---" . $Remarks . "--<br>";
            echo "----Item_Code---" . $Item_Code . "--<br>";
            echo "----Status---" . $Status . "--<br>";
            echo "----total_loyalty_points---" . $total_loyalty_points . "--<br>";
            echo "----loyalty_points---" . $loyalty_points . "--<br>"; */

           // die;
            $reedem_points = 0;

            $cust_details = $this->Coal_Transactions_model->cust_details_from_card($Company_id, $cardId);
            foreach ($cust_details as $row25) {
              
              $card_bal = $row25['Current_balance'];
              $Customer_enroll_id = $row25['Enrollement_id'];
              $topup = $row25['Total_topup_amt'];
              $purchase_amt = $row25['total_purchase'];
              $reddem_amt = $row25['Total_reddems'];
              $member_Tier_id = $row25['Tier_id'];
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
            
            //echo "-----cardId---" . $cardId . "-----card_bal---" . $card_bal . "--<br>";
            
            $get_city_state_country = $this->Igain_model->Fetch_city_state_country($Company_id, $Customer_enroll_id);
            $State_name = $get_city_state_country->State_name;
            $City_name = $get_city_state_country->City_name;
            $Country_name = $get_city_state_country->Country_name;

            if (!(is_null($bal_pay)) && $reedem_points <= $card_bal) {
              
              $gained_points_fag = 0;
              $logtimezone = $data['timezone_entry'];

              $timezone = new DateTimeZone($logtimezone);
              $date = new DateTime();
              $date->setTimezone($timezone);
              $lv_time = $date->format('H:i:s');
              //$lv_date=$Todays_date." ".$lv_time;
              $lv_date = date("Y-m-d H:i:s", strtotime($Pos_Transdate));


              $Sms_enabled = $company_details2->Sms_enabled;
              $Seller_topup_access = $company_details2->Seller_topup_access;
              $Allow_negative = $company_details2->Allow_negative;
              $to_email_id = $company_details2->Company_primary_email_id;
              $comp_name = $company_details2->Company_name;


              $user_details = $this->Igain_model->get_enrollment_details($seller_id);
              $seller_id = $user_details->Enrollement_id;
              $Purchase_Bill_no = $user_details->Purchase_Bill_no;
               $Seller_Billingratio = $user_details->Seller_Billingratio;
              $Seller_Billing_Bill_no = $user_details->Seller_Billing_Bill_no;
              $Seller_Country_id = $user_details->Country_id;
              $username = $user_details->User_email_id;
              $remark_by = 'By Merchant';
              $seller_curbal = $user_details->Current_balance;
              $Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
              $Seller_Refrence = $user_details->Refrence;
              $Topup_Bill_no = $user_details->Topup_Bill_no;
              $Seller_pinno = $user_details->pinno;
              $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
              
              $tp_db_bill = $Seller_Billing_Bill_no;
              $len_bill = strlen($tp_db_bill);
              $str_bill = substr($tp_db_bill, 0, 5);
              $billing_bill = substr($tp_db_bill, 5, $len_bill);

              if ($user_details->Sub_seller_admin == 1) {
                $remark_by = 'By Sub Merchant';
              } else {
                $remark_by = 'By Merchant';
              }

              $Seller_category = $this->Igain_model->get_seller_category($seller_id, $Company_id);

              if ($Seller_category == 0) {
                $this->session->set_flashdata("data_map_error_code", "The Merchant has not been assigned a Category yet!! Please contact the Program Admin to set it to Enable Loyalty Transaction.!");

                redirect('Coal_Data_transform/upload_data');
              }


             


              //***** get loyalty program details ******************/
              $Loyalty_names = $_REQUEST["lp_rules"];
              // var_dump($_POST);
              //echo"----Loyalty_names------<br>";
               // print_r($Loyalty_names);
              //$lp_details = $this->Data_transform_model->get_loyaltyrule_details($Loyalty_names, $Company_id, $seller_id);
              // $lp_count = count($lp_details);
              
              //foreach ($lp_details as $lp_data) {
              foreach ($Loyalty_names as $lpname) {
                
                $value = array();
                $dis = array();

                //echo"<br>----lpname---".$lpname."---<br>";
                $lp_details = $this->Data_transform_model->get_loyaltyrule_details($lpname, $Company_id, $seller_id);

                $lp_count = count($lp_details);

                foreach ($lp_details as $lp_data) {

                 // echo"<br>----Loyalty_id---".$lp_data['Loyalty_id']."---<br>";
                  
                  $LoyaltyID = $lp_data['Loyalty_id'];
                  $lp_name = $lp_data['Loyalty_name'];
                  $lp_From_date = $lp_data['From_date'];
                  $lp_Till_date = $lp_data['Till_date'];
                  $Loyalty_at_value = $lp_data['Loyalty_at_value'];
                  $Loyalty_at_transaction = $lp_data['Loyalty_at_transaction'];
                  $discount = $lp_data['discount'];
                  $lp_Tier_id = $lp_data['Tier_id'];
                  $Flat_file_flag = $lp_data['Flat_file_flag'];
                  $Category_flag = $lp_data['Category_flag'];
                  $Category_id = $lp_data['Category_id'];
                  $Segment_flag = $lp_data['Segment_flag'];
                  $Segment_id = $lp_data['Segment_id'];
                  
                  $Loyalty_at_flag = 0;
                  
                  $lp_type = substr($lp_name, 0, 2);
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
                  
                 // echo"----Loyalty_at_flag---".$Loyalty_at_flag."---<br>";
                }
                



                
                  /* echo '<br>-----LoyaltyID_array-><br>';
                  print_r($LoyaltyID_array);
                  echo '<br>-----value-><br>';
                  print_r($value);
                  echo '<br>-----discount-><br>';
                  print_r($dis);
                  echo '-----<br>'; */
                 

                if ($lp_type == 'PA') {
                  $transaction_amt = $bal_pay;
                }

                if ($lp_type == 'BA') {
                  $transaction_amt = $bal_pay; 
                }
                
                
               /* echo '-----transaction_amt--->'.$transaction_amt.'--<br>';
                echo "---loyalty member_Tier_id---".$member_Tier_id."---<br><br>";
                echo "---loyalty lp_Tier_id---".$lp_Tier_id."---<br><br>";
                echo "---loyalty Loyalty_at_flag---".$Loyalty_at_flag."---<br><br>";*/
                

                if ($Category_flag == 1) {
                  
                  $Item_Code = $Item_Code;
                  $Merchandize_Item_Row = $this->Data_transform_model->Get_Merchandize_Item_details($Item_Code, $Company_id);

                  $Merchandize_category_id = $Merchandize_Item_Row->Merchandize_category_id;

                  // echo "----Category_id---".$Category_id."----LoyaltyID----".$LoyaltyID."------Merchandize_category_id-".$Merchandize_category_id."---Customer_enroll_id---".$Customer_enroll_id."---<br><br>";

                  if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 1 && $Merchandize_category_id == $Category_id) {
                    for ($i = 0; $i < count($value); $i++) {

                      if ($value[$i + 1] != "") {
                        if ($transaction_amt > $value[$i] && $transaction_amt <= $value[$i + 1]) {
                          $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);
                          $points_array[] = $loyalty_points;
                          $trans_lp_id = $LoyaltyID_array[$i];
                          $gained_points_fag = 1;
                        }
                      } else if ($transaction_amt > $value[$i]) {

                        $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);

                        $points_array[] = $loyalty_points;
                        $gained_points_fag = 1;
                        $trans_lp_id = $LoyaltyID_array[$i];
                      }
                    }
                  }
                  if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 2 && $Merchandize_category_id == $Category_id) {
                    $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[0]);
                    $points_array[] = $loyalty_points;
                    $gained_points_fag = 1;
                    $trans_lp_id = $LoyaltyID_array[0];
                  }
                  if ($loyalty_points > 0) {
                    // echo "<br><br>***************---Insert Into Child Table ---***************<br><br>";
                    $child_data = array(
                        'Company_id' => $Company_id,
                        'Transaction_date' => $lv_date,
                        'Seller' => $seller_id,
                        'Enrollement_id' => $Customer_enroll_id,
                        'Transaction_id' => 0,
                        // 'Loyalty_id' => $trans_lp_id,
                        'Loyalty_id' => $LoyaltyID,
                        'Reward_points' => $loyalty_points,
                    );

                    $child_result = $this->Coal_Transactions_model->insert_loyalty_transaction_child($child_data);
                  }
                // echo "<br>---loyalty_points----Category_flag------".$loyalty_points."---<br><br>";
                } else if ($Segment_flag == 1) {
                  //---------------------Get Segment----------------------------------/
                  // echo "----Segment_flag---".$Segment_flag."----Segment_id-----".$Segment_id."-----LoyaltyID--".$LoyaltyID."-----Customer_enroll_id---".$Customer_enroll_id."---<br><br>";
                  // $Segment_code = $this->input->post("Segment_code");
                  // echo "Segment_code ".$Segment_code;

                  $Get_segments2 = $this->Segment_model->edit_segment_id($Company_id, $Segment_id);
                  //
                  $Customer_array = array();

                  /* $all_customers = $this->Igain_model->get_all_customers($Company_id);	
                    foreach ($all_customers as $row)
                    { */
                  // echo "<b>First_name ".$row["First_name"]."</b>";
                  $Applicable_array[] = 0;

                  unset($Applicable_array);
                  //print_r($Applicable_array);
                  foreach ($Get_segments2 as $Get_segments) {
                    // echo "<br>----".$Get_segments->Segment_type_name." ".$Get_segments->Operator." ".$Get_segments->Value." ".$Get_segments->Value1." ".$Get_segments->Value2;
                    // echo "<br>---------------------------<br>";
                    if ($Get_segments->Segment_type_id == 1) {  // 	Age 
                      $lv_Cust_value = date_diff(date_create($Date_of_birth), date_create('today'))->y;
                      // echo "****Age--".$lv_Cust_value;
                    }

                    if ($Get_segments->Segment_type_id == 2) {//Sex
                      $lv_Cust_value = $Sex;
                      // echo "****Sex ".$lv_Cust_value;
                    }
                    if ($Get_segments->Segment_type_id == 3) {//Country
                      $lv_Cust_value = $Country_name;

                      // echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 4) {//District
                      $lv_Cust_value = $District;
                      // echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 5) {//State
                      $lv_Cust_value = $State_name;
                      // echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 6) {//city
                      $lv_Cust_value = $City_name;

                      // echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 

                      if (strcasecmp($lv_Cust_value, $Get_segments->Value) == 0) {
                        $Get_segments->Value = $lv_Cust_value;
                      }
                    }
                    if ($Get_segments->Segment_type_id == 7) {//Zipcode
                      $lv_Cust_value = $Zipcode;

                      // echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 8) {//Cumulative Purchase Amount
                      $lv_Cust_value = $total_purchase;

                      // echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 9) {//Cumulative Points Redeem 
                      $lv_Cust_value = $Total_reddems;

                      // echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 10) {//Cumulative Points Accumulated
                      $start_date = $joined_date;
                      $end_date = date("Y-m-d");
                      $transaction_type_id = 2;
                      $Tier_id = $lp_Tier_id;

                      $Trans_Records = $this->Report_model->get_cust_trans_summary_all($Company_id, $Customer_enroll_id, $start_date, $end_date, $transaction_type_id, $Tier_id, '', '');
                      foreach ($Trans_Records as $Trans_Records) {
                        $lv_Cust_value = $Trans_Records->Total_Gained_Points;
                      }

                      // echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 11) {//Single Transaction  Amount
                      $start_date = $joined_date;
                      $end_date = date("Y-m-d");
                      $transaction_type_id = 2;
                      $Tier_id = $lp_Tier_id;

                      $Trans_Records = $this->Report_model->get_cust_trans_details($Company_id, $start_date, $end_date, $Customer_enroll_id, $transaction_type_id, $Tier_id, '', '');
                      foreach ($Trans_Records as $Trans_Records) {
                        $lv_Max_amt[] = $Trans_Records->Purchase_amount;
                      }
                      $lv_Cust_value = max($lv_Max_amt);

                      // echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
                    }
                    if ($Get_segments->Segment_type_id == 12) {//Membership Tenor
                      $tUnixTime = time();
                      list($year, $month, $day) = EXPLODE('-', $joined_date);
                      $timeStamp = mktime(0, 0, 0, $month, $day, $year);
                      $lv_Cust_value = ceil(abs($timeStamp - $tUnixTime) / 86400);

                      // echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
                    }
                    $Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value, $Get_segments->Operator, $Get_segments->Value, $Get_segments->Value1, $Get_segments->Value2);

                    $Applicable_array[] = $Get_segments;
                  }
                  // print_r($Applicable_array);

                  if (!in_array(0, $Applicable_array, true)) {
                    $Customer_array[] = $Customer_enroll_id;

                    // echo "<br>----------------Access and Give Loyalty Points--------------------<br><br>";
                    
                    if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 1) {
                      for ($i = 0; $i < count($value); $i++) {
                        if ($value[$i + 1] != "") {
                          if ($transaction_amt > $value[$i] && $transaction_amt <= $value[$i + 1]) {
                            $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);
                            $points_array[] = $loyalty_points;
                            $trans_lp_id = $LoyaltyID_array[$i];
                            $gained_points_fag = 1;
                          }
                        } else if ($transaction_amt > $value[$i]) {
                          $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);
                          $points_array[] = $loyalty_points;
                          $gained_points_fag = 1;
                          $trans_lp_id = $LoyaltyID_array[$i];
                        }
                      }
                    }
                    if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 2) {
                      $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[0]);
                      $points_array[] = $loyalty_points;
                      $gained_points_fag = 1;
                      $trans_lp_id = $LoyaltyID_array[0];
                    }

                    if ($loyalty_points > 0) {

                      //echo "<br><br>***************---Insert Into Child Table ---***************<br><br>";


                      $child_data = array(
                          'Company_id' => $Company_id,
                          'Transaction_date' => $lv_date,
                          'Seller' => $seller_id,
                          'Enrollement_id' => $Customer_enroll_id,
                          'Transaction_id' => 0,
                          // 'Loyalty_id' => $trans_lp_id,
                          'Loyalty_id' => $LoyaltyID,
                          'Reward_points' => $loyalty_points,
                      );

                      $child_result = $this->Coal_Transactions_model->insert_loyalty_transaction_child($child_data);
                    }
                   // echo "<br>---loyalty_points---Segment_flag------".$loyalty_points."---<br><br>";
                  }

                  // }
                  // echo "<br>----count------------".count($Customer_array)."--<br>";
                  //---------------------Get Segment----------------------------------/
                  
                } else {
                  
                  if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 1) {
                    for ($i = 0; $i < count($value); $i++) {
                      if ($value[$i + 1] != "") {
                        if ($transaction_amt > $value[$i] && $transaction_amt <= $value[$i + 1]) {

                          $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);

                          $points_array[] = $loyalty_points;

                          $trans_lp_id = $LoyaltyID_array[$i];
                          $gained_points_fag = 1;
                        }
                      } else if ($transaction_amt > $value[$i]) {

                        $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[$i]);

                        $points_array[] = $loyalty_points;
                        $gained_points_fag = 1;
                        $trans_lp_id = $LoyaltyID_array[$i];
                      }
                    }
                  }

                  if ($member_Tier_id == $lp_Tier_id && $Loyalty_at_flag == 2) {

                    $loyalty_points = $this->Coal_Transactions_model->get_discount($transaction_amt, $dis[0]);

                    $points_array[] = $loyalty_points;
                    $gained_points_fag = 1;
                    $trans_lp_id = $LoyaltyID_array[0];
                  }

                  if ($loyalty_points > 0) {
                    $child_data = array(
                        'Company_id' => $Company_id,
                        'Transaction_date' => $lv_date,
                        'Seller' => $seller_id,
                        'Enrollement_id' => $Customer_enroll_id,
                        'Transaction_id' => 0,
                        'Loyalty_id' => $trans_lp_id,
                        'Reward_points' => $loyalty_points,
                    );

                    $child_result = $this->Coal_Transactions_model->insert_loyalty_transaction_child($child_data);
                  }
                 // echo "<br>---loyalty_points---NOrmal------".$loyalty_points."---<br><br>";
                }
                
                  unset($dis);
                 unset($Loyalty_at_flag);
              }
              
             // echo "<br>-------points_array---------<br>";
             // print_r($points_array);
               // echo "<br><br>";

                if ($gained_points_fag == 1) {
                  $total_loyalty_points = array_sum($points_array);

                  unset($points_array);
                } else {
                  $total_loyalty_points = 0;
                }
                unset($trans_lp_id);

                //echo "---total_loyalty_points---" . $total_loyalty_points . "---<br><br>";
                //continue;
                //die;

                 if ($total_loyalty_points == "" || $total_loyalty_points == NULL || $total_loyalty_points == 0) {
                    $total_loyalty_points = 0;
                  }

                $tp_db = $Purchase_Bill_no;
                $len = strlen($tp_db);
                $str = substr($tp_db, 0, 5);
                $bill = substr($tp_db, 5, $len);

                $bill_no = $bill + 1;
                $lv_Coalition_Loyalty_pts = round(($total_loyalty_points * $Coalition_points_percentage) / 100);

               
               // echo "---card_bal---" . $card_bal . "----lv_Coalition_Loyalty_pts---" . $lv_Coalition_Loyalty_pts . "---<br><br>";

                $curr_bal = $card_bal + $lv_Coalition_Loyalty_pts;
                //$curr_bal = $card_bal;
                
                //echo "---curr_bal---" . $curr_bal . "---<br><br>";

                $transaction_redeem_points = $reedem_points; //$this->input->post("points_redeemed");
                //$curr_bal1 = $curr_bal - $transaction_redeem_points;
                $curr_bal1 = $curr_bal;

                $topup_amt = $topup;

                $purchase_amount = $purchase_amt;

                //$transaction_redeem_amt = $this->input->post("redeem_amt");

                $reddem_amount = $reddem_amt;

                $result2 = $this->Coal_Transactions_model->update_customer_balance($cardId, $curr_bal1, $Company_id, $topup_amt, $Pos_Transdate, $purchase_amount, $reddem_amount);
                /*                 * *******New table entry*****17-08-2016*AMIT******************************************** */
                $Record_available = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $Customer_enroll_id);
               // echo "<br>----Record_available ".$Record_available."-----<br>";
                if ($Record_available == 0) {
                  $post_data2 = array(
                      'Company_id' => $Company_id,
                      'Seller_total_purchase' => $bal_pay,
                      'Update_date' => $lv_date,
                      'Seller_id' => $seller_id,
                      'Cust_enroll_id' => $Customer_enroll_id,
                      'Cust_seller_balance' => $total_loyalty_points,
                      'Seller_paid_balance' => $bal_pay,
                      'Seller_total_redeem' => $reedem_points,
                      'Seller_total_gain_points' => $total_loyalty_points,
                      'Seller_total_topup' => 0
                  );
                 // $lv_Cust_seller_balance = $total_loyalty_points;
                  $result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data2);
                } else {

                  /* * ***********Get Customer merchant balance**************** */
                  $Get_Record = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $Customer_enroll_id);

                  foreach ($Get_Record as $val) {
                    $data["Cust_seller_balance"] = $val["Cust_seller_balance"];
                    $data["Seller_total_purchase"] = $val["Seller_total_purchase"];
                    $data["Seller_total_redeem"] = $val["Seller_total_redeem"];
                    $data["Seller_total_gain_points"] = $val["Seller_total_gain_points"];
                    $data["Seller_total_topup"] = $val["Seller_total_topup"];
                    $data["Seller_paid_balance"] = $val["Seller_paid_balance"];
                    $data["Cust_block_points"] = $val["Cust_block_points"];
                    $data["Cust_block_amt"] = $val["Cust_block_amt"];
                    $data["Cust_debit_points"] = $val["Cust_debit_points"];
                    $data["Cust_prepayment_balance"] = $val["Cust_prepayment_balance"];
                  }
                  /* * ******************************************************************** */
                  $lv_Cust_seller_balance = ($data["Cust_seller_balance"] + $total_loyalty_points - $reedem_points);
                  $lv_Seller_total_purchase = ($data["Seller_total_purchase"] + $bal_pay);
                  $lv_Seller_total_redeem = ($data["Seller_total_redeem"] + $reedem_points);
                  $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"] + $total_loyalty_points);
                  $lv_Seller_paid_balance = ($data["Seller_paid_balance"] + $bal_pay);
                  $lv_Seller_total_topup = ($data["Seller_total_topup"] + 0);
                  $lv_Cust_block_amt = ($data["Cust_block_amt"]);
                  $lv_Cust_block_points = ($data["Cust_block_points"]);
                  $lv_Cust_debit_points = ($data["Cust_debit_points"]);
                  $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
                  /*                   * ***********Update customer merchant balance************************ */
                 $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance,$lv_Cust_block_points,$lv_Cust_block_amt,$lv_Cust_debit_points);
                  /*                   * ************************************************** */
                }
                $billno_withyear = $str . $bill_no;
                
                
                
                

                if ($Sms_enabled == '1') {
                  /* * *******************************Send SMS Code****************************** */
                }
                $Todays_date = date("Y-m-d");
                
                // echo "----Refree_enroll_id-----".$Refree_enroll_id."-----<br>";
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


                  //echo "--referee ref_card_bal---".$ref_card_bal."--<br><br>"; die;		

                  $Refree_topup = 0;

                  $Referral_rule_for = 2; //*** Referral_rule_for transaction
                  $Ref_rule = $this->Coal_Transactions_model->select_seller_refrencerule($seller_id, $Company_id, $Referral_rule_for);
                  

                  foreach ($Ref_rule as $rule) {
                    $ref_start_date = $rule['From_date'];
                    $ref_end_date = $rule['Till_date'];
                    //$ref_Tier_id = $rule['Tier_id'];

                    if ($ref_start_date <= $lv_date && $ref_end_date >= $lv_date) {

                      $ref_topup = $rule['Refree_topup'];
                      $total_ref_topup = $total_ref_topup + $ref_topup;
                    }
                  }

                  //echo "--referee member total_ref_topup---".$total_ref_topup."--<br><br>";
                  //echo "--Seller_Refrence---".$Seller_Refrence."--<br><br>";
                  //die;
                  if ($total_ref_topup > 0) { //$Seller_Refrence == 1 && 


                   
                    $Record_available_ref = $this->Coal_Transactions_model->check_cust_seller_record($Company_id, $seller_id, $ref_Customer_enroll_id);
                    //echo "<br><br>---referee member--Record_available_ref--- ".$Record_available_ref."---<br>";
                    if ($Record_available_ref == 0) {
                      $post_data3 = array(
                          'Company_id' => $Company_id,
                          'Seller_total_purchase' => 0,
                          'Update_date' => $lv_date,
                          'Seller_id' => $seller_id,
                          'Cust_enroll_id' => $ref_Customer_enroll_id,
                          'Cust_seller_balance' => $total_ref_topup,
                          'Seller_paid_balance' => 0,
                          'Seller_total_redeem' => 0,
                          'Seller_total_gain_points' => 0,
                          'Seller_total_topup' => $total_ref_topup
                      );
                      //$lv_Cust_seller_balance = $total_loyalty_points;
                     $result21 = $this->Coal_Transactions_model->insert_cust_merchant_trans($post_data3);
                    } else {

                      /*                       * ***********Get Customer merchant balance**************** */
                      $Get_Record1 = $this->Coal_Transactions_model->get_cust_seller_record($seller_id, $ref_Customer_enroll_id);

                      foreach ($Get_Record1 as $val) {
                        $data["Cust_seller_balance"] = $val["Cust_seller_balance"];
                        $data["Seller_total_purchase"] = $val["Seller_total_purchase"];
                        $data["Seller_total_redeem"] = $val["Seller_total_redeem"];
                        $data["Seller_total_gain_points"] = $val["Seller_total_gain_points"];
                        $data["Seller_total_topup"] = $val["Seller_total_topup"];
                        $data["Seller_paid_balance"] = $val["Seller_paid_balance"];
                        $data["Cust_debit_points"] = $val["Cust_debit_points"];
                        $data["Cust_block_amt"] = $val["Cust_block_amt"];
                        $data["Cust_block_points"] = $val["Cust_block_points"];  
                        $data["Cust_block_amt"] = $val["Cust_block_amt"];
                        $data["Cust_debit_points"] = $val["Cust_debit_points"];
                        $data["Cust_prepayment_balance"] = $val["Cust_prepayment_balance"];
                      }
                      /*                       * ******************************************************************** */
                      $lv_Cust_seller_balance = ($data["Cust_seller_balance"] + $total_ref_topup);
                      $lv_Seller_total_purchase = ($data["Seller_total_purchase"]);
                      $lv_Seller_total_redeem = ($data["Seller_total_redeem"]);
                      $lv_Seller_total_gain_points = ($data["Seller_total_gain_points"]);
                      $lv_Seller_paid_balance = ($data["Seller_paid_balance"]);
                      $lv_Seller_total_topup = ($data["Seller_total_topup"] + $total_ref_topup);
                      $lv_Cust_block_amt = ($data["Cust_block_amt"]);
                      $lv_Cust_block_points = ($data["Cust_block_points"]);
                      $lv_Cust_debit_points = ($data["Cust_debit_points"]);
                      $lv_Cust_prepayment_balance = ($data["Cust_prepayment_balance"]);
                      /*                       * ***********Update customer merchant balance************************ */
                          $result21 = $this->Coal_Transactions_model->update_cust_merchant_trans($ref_Customer_enroll_id, round($lv_Cust_seller_balance), $Company_id, $lv_Seller_total_topup, $lv_date, $lv_Seller_total_purchase, $lv_Seller_total_redeem, $lv_Seller_paid_balance, $lv_Seller_total_gain_points, $seller_id, $lv_Cust_prepayment_balance,$lv_Cust_block_points,$lv_Cust_block_amt,$lv_Cust_debit_points);
                      /*                       * ************************************************** */
                    }

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
                        'Trans_date' => $lv_date,
                        'Remarks' => 'Referral Trans',
                        'Card_id' => $referre_membershipID,
                        'Seller_name' => $Seller_name,
                        'Seller' => $seller_id,
                        'Enrollement_id' => $ref_Customer_enroll_id,
                        'Bill_no' => $tp_bill,
                        'Manual_billno' => $manual_bill_no,
                        'remark2' => $remark_by,
                        'Billing_Bill_flag' => 1,
                        'Seller_Billing_Bill_no' =>$billing_bill,
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
                        'Todays_date' => $lv_date
                    );

                 $this->send_notification->Coal_send_Notification_email($ref_Customer_enroll_id, $Email_content12, $Logged_user_enrollid, $Company_id);
                  }
                } else {
                   $total_ref_topup = 0;
                }
                
                
                if (!isset($_POST['Upload_files_errors'])) {
                    $total_billing_loyalty_points=$total_ref_topup+$total_loyalty_points;
                    $BillAmount = $total_billing_loyalty_points * $Seller_Billingratio;

                    $billing_data = array(
                        'Bill_purchsed_amount' => $bal_pay,
                        'Bill_amount' => $BillAmount,
                        'Bill_Transdate' => $lv_date,
                        'Bill_Customerno' => $cardId,
                        'Seller_name' => $Seller_name,
                        'Seller_id' => $seller_id,
                        'Billno' => $manual_bill_no,
                        'Bill_Quantity' => $Quantity,
                        'Bill_Item_Code' => $Item_Code,
                        'Loyalty_pts' => $total_billing_loyalty_points,
                        'Payment_type_id' => $PayMentBy,
                        'Remarks' => $Remarks,
                        'Status' => $Status
                    );
                    $result_insert = $this->Data_transform_model->Insert_billing_customer_records($seller_id, $billing_data);
                  }
                
                
                
                if ($Seller_topup_access == '1') {
                  
                  
                  $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
                  
                  $Seller_balance = $seller_details2->Current_balance;
                  
                  
                  /* echo "--Seller_balance--- ".$Seller_balance."---<br>";
                  echo "--total_loyalty_points--- ".$total_loyalty_points."---<br>";
                  echo "--total_ref_topup--- ".$total_ref_topup."---<br>";
                  echo "--reedem_points--- ".$reedem_points."---<br>"; */
                  
                  
                  
                  $Total_seller_bal = ($Seller_balance - $total_loyalty_points)-$total_ref_topup;
                  $Total_seller_bal = $Total_seller_bal + $reedem_points;
                  
                 // echo "--Total_seller_bal--- ".$Total_seller_bal."---<br>";
                  
                  $result3 = $this->Coal_Transactions_model->update_seller_balance($seller_id, $Total_seller_bal);

                }

                $result4 = $this->Coal_Transactions_model->update_billno($seller_id, $billno_withyear);
              
              
            }
            
            
             
             $post_data = array(
                    'Trans_type' => '2',
                    'Company_id' => $Company_id,
                    'Purchase_amount' => $bal_pay, //$this->input->post("purchase_amt"),        
                    'Trans_date' => $lv_date,
                    'Card_id' => $cardId,
                    'Seller_name' => $Seller_name,
                    'Seller' => $seller_id,
                    'Enrollement_id' => $Customer_enroll_id,
                    'Bill_no' => $bill,
                    'Manual_billno' => $manual_bill_no,
                    'remark2' => $remark_by,
                    'Remarks' => 'FlatFile', //$this->input->post("remark"),
                    'Flatfile_remarks' => $Flatfile_remarks,
                    'Loyalty_pts' => $total_loyalty_points,
                    'Coalition_Loyalty_pts' => $lv_Coalition_Loyalty_pts,
                    'Paid_amount' => $bal_pay, //$this->input->post("pay_amt"),
                    'Redeem_points' => $reedem_points, //$this->input->post("points_redeemed"),
                    'Payment_type_id' => $PayMentBy, //$this->input->post("Payment_type"),
                    'balance_to_pay' => $bal_pay, //$this->input->post("pay_amt"),
                    'purchase_category' => $Seller_category,
                    'Source' => 0,
                    'Billing_Bill_flag' => 1,
                    'Seller_Billing_Bill_no' => $billing_bill,
                    'Create_user_id' => $data['enroll']
                );

                $insert_transaction_id = $this->Coal_Transactions_model->insert_loyalty_transaction($post_data);

                $result = $this->Coal_Transactions_model->update_loyalty_transaction_child($Company_id, $Pos_Transdate, $seller_id, $Customer_enroll_id, $insert_transaction_id);
            
            
                $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
                $Symbol_currency = $currency_details->Symbol_of_currency;
                
                
                $Notification_type = "Loyalty Transaction";

                $purchase_amt = $bal_pay; //$this->input->post("purchase_amt");
                $reedem = $reedem_points; //$this->input->post("points_redeemed");
                $payment_by = $PayMentBy; //$this->input->post("Payment_type");
                $balance_to_pay = $bal_pay; //$this->input->post("pay_amt");


                $Email_content = array(
                    'Today_date' => $lv_date,
                    'Purchase_amount' => $purchase_amt,
                    'Manual_billno' => $manual_bill_no,
                    'Redeem_points' => $reedem,
                    'Payment_by' => $payment_by,
                    'Balance_to_pay' => $balance_to_pay,
                    'Total_loyalty_points' => $total_loyalty_points,
                    'Symbol_currency' => $Symbol_currency,
                    'GiftCardNo' => '-',
                    'gift_reedem' => '-',
                    'Coalition_Loyalty_pts' => $lv_Coalition_Loyalty_pts,
                    'Coalition_curr_bal' => $curr_bal,
                    'Cust_seller_balance' => $lv_Cust_seller_balance,
                    'Merchant_name' => $Seller_name,
                    'Notification_type' => $Notification_type,
                    'Template_type' => 'Coalition_loyalty_transaction');
                    $this->send_notification->Coal_send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);

                if (($insert_transaction_id > 0) && ($result2 == true) && ($result4 == true)) {
                  $abc_array[] = 1;
                } else {
                  $abc_array[] = 0;
                }
            
          }
          /** ******* Send Flat File Error Template **** */

          
              if ($Seller_topup_access == '1') {

                  /* * *******************Send Threshold Mail*************** */
                 
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
                  /*                   * *******************Send Threshold Mail*************** */
                }
          
          
          

          $file_status = $this->input->post("file_status");
          $seller_id = $this->input->post("seller_id");
          $Total_error_count = $this->input->post("Total_error_count");
          $Total_row = $this->input->post("Total_row");
          $Error_row = $this->input->post("Error_row");
          $Success_row = $this->input->post("Success_row");
          $File_name = $this->input->post("filename");

          
          
          
          /* -------------Billing Bill No------------------- */

            $tp_db_bill = $Seller_Billing_Bill_no;
            $len_bill = strlen($tp_db_bill);
            $str_bill = substr($tp_db_bill, 0, 5);
            $billing_bill = substr($tp_db_bill, 5, $len_bill);

            $billing_bill_no = $billing_bill + 1;

            /* -------------Billing Bill No------------------- */
            
            

          
          
           $Seller_pin = $user_details->pinno;
          $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
          $Super_Seller_pin = $Super_Seller->pinno;


          /* ------------------------------------------------Send Errors File-------------------------------------------------- */


          $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
          $Seller_balance = $seller_details2->Current_balance;
          $Seller_name = $seller_details2->First_name . " " . $seller_details2->Last_name;

          //var_dump($_POST);

          $data['file_error_details'] = $this->Data_transform_model->get_file_error_status($file_status, $Company_id);
         // echo "<br>--file_error_details---<br>";
         // var_dump($data['file_error_details']);
          foreach ($data['file_error_details'] as $status) {

            $Total_row_uploads = $status->Total_row;
            $Total_Success_row = $status->Success_row;
            $Total_Error_row = $status->Error_row;
          }

           // echo"<br><br>---Total_row_uploads-----".$Total_row_uploads."-<br><br>";
            //echo"<br><br>---Total_Success_row-----".$Total_Success_row."-<br><br>";
          //  echo"<br><br>---Total_Error_row-----".$Total_Error_row."-<br><br>";

          $Bill_File_name = $File_name;
          $data['File_name'] = $File_name;
          $Error_File_name = $seller_id . 'ERROR_' . date('Y_m_d_H_i_s');


          $Export_file_name = $seller_id . "Uploaded-Error-File";
          $data['Export_file_name'] = $Seller_name . " Uploaded Error File";

          $data['Seller_name'] = $Seller_name;
          $data['Company_logo'] = base_url() . '/' . $company_details2->Company_logo;

          //echo"<br><br>---Company_logo-----".$data['Company_logo']."-<br><br>";		
           //echo"<br><br>---Seller_name-----".$Seller_name."-<br><br>";		

          $htmlErrors = $this->load->view('Data_transform/pdf_uploaded_error_file', $data, true);
         // echo $htmlErrors;

          /* echo"<br><br>---Error Records---Error_in-".count($data['file_error_details'])."-<br><br>";			
            die; */
          $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
          $error_file_path = "";
          // if(!empty($data['file_error_details']) && $Total_Error_row > 0)
          if ($Total_Error_row > 0) {

            $pdf = new mPDF();
            $pdf->setFooter('{PAGENO}');

            $pdf->setAutoTopMargin = 'pad';


            $pdf->SetHTMLHeader('<header class="clearfix"><h1>File Errors</h1><div id="project"><div>Merchant Name: ' . $Seller_name . '</div><div>Merchant ID:  ' . $seller_id . '</div><div>File Name:  ' . $File_name . '</div><div>Processed Date: ' . date("j, F Y h:i:s A") . '</div></div></header> <br><br>', '', true);

            $pdf->WriteHTML($htmlErrors);
            $error_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Seller_errors_files/' . $Error_File_name . '.pdf', 'F');
            $pdf->Output($DOCUMENT_ROOT . '/export/Seller_errors_files/' . $Error_File_name . '.pdf', 'F');
            $error_file_path = $DOCUMENT_ROOT . '/export/Seller_errors_files/' . $Error_File_name . '.pdf';
            unset($pdf);
          }

          /* ------------------------------------------------Send Errors File-------------------------------------------------- */





          /* ------------------------------------------------Send Annexure File-------------------------------------------------- */

          if (!isset($_POST['Upload_files_errors'])) {

            $data1['Seller_billing_records'] = $this->Data_transform_model->Fetch_billing_customer_records($seller_id, $billing_data);

            $data1['billing_bill_no'] = $billing_bill;
            $data1['Company_logo'] = base_url() . $company_details2->Company_logo;

            $data1["Company_details"] = $this->Igain_model->get_company_details($Company_id);

            $city_state_country = $this->Igain_model->Fetch_city_state_country($Company_id, $seller_id);
            $Company_city_state_country = $this->Igain_model->Company_city_state_country($Company_id);



            $data1['Bill_File_name'] = $Bill_File_name;
            $FilenameAnnexure = $seller_id . 'ANNEXURE_' . date('Y_m_d_H_i_s') . '_' . $billing_bill;

            $Export_file_name = $seller_id . "Billing-File";
            $data1['Seller_name'] = $Seller_name;
            $data1['Current_address'] = $user_details->Current_address;
            $data1['City_name'] = $city_state_country->City_name;
            $data1['State_name'] = $city_state_country->State_name;
            $data1['Country_name'] = $city_state_country->Country_name;
            $data1['Company_City_name'] = $Company_city_state_country->City_name;
            $data1['Company_State_name'] = $Company_city_state_country->State_name;
            $data1['Company_Country_name'] = $Company_city_state_country->Country_name;
            $data1['Zipcode'] = $user_details->Zipcode;
            $data1['User_email_id'] = $user_details->User_email_id;
            $data1['Phone_no'] = $user_details->Phone_no;
            $data1['Merchant_sales_tax'] = $user_details->Merchant_sales_tax;
            $data1['seller_id'] = $seller_id;
            $data1['billing_bill_no'] = $billing_bill;
            $data1['Symbol_currency'] = $Symbol_currency;


            $htmlAnnexure = $this->load->view('Data_transform/pdf_seller_Annexure_records', $data1, true);

           // echo $htmlAnnexure;		
            //echo "<br>---------htmlAnnexure--------<br>";	
            //echo"<br><br>---htmlAnnexure---count-".count($data1['Seller_billing_records'])."-<br><br>";		
            $Annexure_file_path = "";
            $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
            if (!empty($data1['Seller_billing_records'])) {

              $pdf = new mPDF();

              $pdf->setFooter('{PAGENO}');

              $pdf->setAutoTopMargin = 'pad';

              $pdf->SetHTMLHeader('<header class="clearfix"><h1>ANNEXURE</h1><div id="project"><div><span>INVOICE: </span> ' . $billing_bill . '</div><div><span>Merchant ID: </span> ' . $seller_id . '</div><div><span>Name: </span> ' . $Seller_name . '</div><div><span>Date: </span>' . date("j, F Y h:i:s A") . '</div></div></header> <br><br>', '', true);
              $pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);
              $pdf->WriteHTML($htmlAnnexure);

              $Annexure_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $FilenameAnnexure . '.pdf', 'F');
              $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $FilenameAnnexure . '.pdf', 'F');
              $Annexure_file_path = $DOCUMENT_ROOT . '/export/Seller_billing_files/' . $FilenameAnnexure . '.pdf';
              unset($pdf);
            }
          }
          /* ------------------------------------------------Send Annexure File-------------------------------------------------- */


          /* ------------------------------------------------Send Billing File-------------------------------------------------- */


          if (!isset($_POST['Upload_files_errors'])) {

            $total_coins_issued_arr = array();
            $Bill_purchased_amount_arr = array();
            $data1['Seller_billing_records'] = $this->Data_transform_model->Fetch_billing_customer_records($seller_id, $billing_data);

            foreach ($data1['Seller_billing_records'] as $bill_record) {

              $total_coins_issued_arr[] = $bill_record->Loyalty_pts;
              $Bill_purchased_amount_arr[] = $bill_record->Bill_purchsed_amount;
            }
            $total_Bill_purchased_amt = array_sum($Bill_purchased_amount_arr);

           // echo"----total_coins_issued-----".$total_coins_issued."---<br>";
            $data1['billing_bill_no'] = $billing_bill;
            $data1['Company_logo'] = base_url() . $company_details2->Company_logo;

            $data1["Company_details"] = $this->Igain_model->get_company_details($Company_id);

            $city_state_country = $this->Igain_model->Fetch_city_state_country($Company_id, $seller_id);
            $Company_city_state_country = $this->Igain_model->Company_city_state_country($Company_id);



            $data1['Bill_File_name'] = $Bill_File_name;
            $Bill_filename = $seller_id . 'INVOICE_' . date('Y_m_d_H_i_s') . '_' . $billing_bill;


            $Export_file_name = $seller_id . "Billing-File";

            $data1['Seller_name'] = $Seller_name;
            $data1['Current_address'] = $user_details->Current_address;

            $data1['City_name'] = $city_state_country->City_name;
            $data1['State_name'] = $city_state_country->State_name;
            $data1['Country_name'] = $city_state_country->Country_name;

            $data1['Company_City_name'] = $Company_city_state_country->City_name;
            $data1['Company_State_name'] = $Company_city_state_country->State_name;
            $data1['Company_Country_name'] = $Company_city_state_country->Country_name;
            $data1['Company_primary_contact_person'] = $company_details2->Company_primary_contact_person;
            $data1['Company_contactus_email_id'] = $company_details2->Company_contactus_email_id;
            $data1['Company_primary_phone_no'] = $company_details2->Company_primary_phone_no;



            $data1['Zipcode'] = $user_details->Zipcode;
            $data1['User_email_id'] = $user_details->User_email_id;
            $data1['Phone_no'] = $user_details->Phone_no;
            $data1['Merchant_sales_tax'] = $user_details->Merchant_sales_tax;

            /* $data1['Total_row']  = $Total_row;
              $data1['Success_row']  = $Success_row; */

            if ($Total_Error_row > 0) {
              $data1['Total_row'] = $Total_row_uploads;
              $data1['Success_row'] = $Total_Success_row;
              $data1['Error_row'] = $Total_Error_row;
            } else {

              $data['file_error_details_1'] = $this->Data_transform_model->get_file_error_status_1($file_status, $Company_id);
              foreach ($data['file_error_details_1'] as $status1) {

                $Total_row_uploads1 = $status1->Total_row;
                $Total_Success_row1 = $status1->Success_row;
                $Total_Error_row1 = $status1->Error_row;
              }
              $data1['Total_row'] = $Total_row_uploads1;
              $data1['Success_row'] = $Total_Success_row1;
              $data1['Error_row'] = $Total_Error_row1;
            }


            $data1['total_coins_issued'] = array_sum($total_coins_issued_arr);
            $data1['Seller_Billingratio'] = $Seller_Billingratio;
            $data1['seller_id'] = $seller_id;
            $data1['Symbol_currency'] = $Symbol_currency;
            // $data1['Seller_Billing_Bill_no ']  = $Seller_Billing_Bill_no;
            // $Seller_Billingratio = $user_details->Seller_Billingratio;
            // $Seller_Billing_Bill_no = $user_details->Seller_Billing_Bill_no;
            // billing_bill_no

            $htmlBill = $this->load->view('Data_transform/pdf_seller_billing_records', $data1, true);


            //echo $htmlBill;
            $billing_file_path = "";
           // echo"<br><br>---Billing---count-".count($data1['Seller_billing_records'])."-<br><br>";	
            $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
            
            //echo"<br><br>---DOCUMENT_ROOT-".$DOCUMENT_ROOT."-<br><br>";	
            
            if (!empty($data1['Seller_billing_records'])) {

              $pdf = new mPDF();
              $pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);

              $pdf->WriteHTML($htmlBill);
              $pdf->setFooter('{PAGENO}');
              $billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $Bill_filename . '.pdf', 'F');
              $pdf->Output($DOCUMENT_ROOT . '/export/Seller_billing_files/' . $Bill_filename . '.pdf', 'F');
              $billing_file_path = $DOCUMENT_ROOT . '/export/Seller_billing_files/' . $Bill_filename . '.pdf';
              unset($pdf);
            }
          }
          // die;
          /* ------------------------------------------------Send Billing File-------------------------------------------------- */
          
          /* ------------------------------------------------update_billing_billno-------------------------------------------------- */
          if (!isset($_POST['Upload_files_errors'])) {
            $billing_billno_withyear = $str_bill . $billing_bill_no;
            $result4 = $this->Coal_Transactions_model->update_billing_billno($seller_id, $billing_billno_withyear);
          }
          /* ------------------------------------------------update_billing_billno-------------------------------------------------- */
          
          
          
           /* ------------------------------------------------Insert Seller Bill Data---------------------------------------- */
          if (!isset($_POST['Upload_files_errors'])) {
            
            $sub_total = 0;
            $tax_amout = 0;
            $total_grand_amt = 0;
            $Bill_tax = $user_details->Merchant_sales_tax;
            $total_coins_issued = array_sum($total_coins_issued_arr);

            $sub_total = ($total_coins_issued * $Seller_Billingratio);
            $tax_amout = ($sub_total * $Bill_tax) / 100;
            $total_grand_amt = $sub_total + $tax_amout;

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
                'Created_user_id' => $seller_id,
                'Creation_date' => date('Y-m-d H:i:s')
            );

            $result4 = $this->Data_transform_model->Insert_merchant_bill_data($insertBill);
          }
          /* ------------------------------------------------update_billing_billno-------------------------------------------------- */


          if (!isset($_POST['Upload_files_errors'])) {

            $DropBillingTable = $this->Data_transform_model->DropBillingTable($seller_id);
          }

          $Todays_date = date('Y-m-d');
          $Seller_email_id = $user_details->User_email_id;
          $Seller_Country_id = $user_details->Country_id;
          $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
          $Symbol_currency = $currency_details->Symbol_of_currency;

          $user_details = $this->Igain_model->get_enrollment_details($seller_id);
          $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;

          $Email_content1 = array(
              'Todays_date' => $Todays_date,
              'Seller_name' => $Seller_name,
              'Seller_email_id' => $Seller_email_id,
              'Company_finance_email_id' => $Company_finance_email_id,
              'Total_Number_Rows_Processed' => $Total_row,
              'Rows_Processed_Successfully' => $Success_row,
              'Rows_with_Errors' => $Error_row,
              'filename' => $File_name,
              'billing_bill_no' => $billing_bill_no,
              'total_grand_amt' => $total_grand_amt,
              'Symbol_currency' => $Symbol_currency,
              'error_file_path' => $error_file_path,
              'Annexure_file_path' => $Annexure_file_path,
              'billing_file_path' => $billing_file_path,
              'Notification_type' => 'Invoice ' . $billing_bill_no . ' Transaction Processed on ' . $Todays_date,
              'Template_type' => 'Merchant_Error_Annexure_billing_File'
          );

          $Notification = $this->send_notification->send_Notification_email('', $Email_content1, $seller_id, $Company_id);

          if (in_array(1, $abc_array)) {
            $this->session->set_flashdata("data_map_error_message", "Flat File Transactions done Successfully!");
          } else {
            $this->session->set_flashdata("data_map_error_message", "Flat File Transactions Unsuccessfull!");
          }
          redirect('Coal_Data_transform/upload_data', 'refresh');
        }
        
      } else {
        redirect('Login', 'refresh');
      }
    }
    /*     * *** Data file upload ******* */
  }
?>


