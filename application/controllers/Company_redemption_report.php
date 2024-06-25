<?php
  if (!defined('BASEPATH'))
    exit('No direct script access allowed');
  class Company_redemption_report extends CI_Controller {

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
      $this->load->model('Report/Company_redemption_report_model');
      $this->load->model('Coal_Report/Coal_Report_model');
      $this->load->library("Excel");
      $this->load->library('m_pdf');
      $this->load->model("login/Home_model");
      $this->load->model('Segment/Segment_model');
      $this->load->model('master/currency_model');
      $this->load->model('CallCenter/CallCenter_model');
    }

    public function Redemption_Report() {
		
      if ($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
		// print_r($session_data);
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
        $data['Loggin_User_id'] = $session_data['userId'];

        $Company_id = $session_data['Company_id'];
        $data["Partner_companys"] = $this->Igain_model->get_partner_companys($data['Loggin_User_id'],$session_data['Company_id']);
		
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

		// var_dump($_POST);

        if ($_REQUEST != NULL) {
          $start_date = $_REQUEST["start_date"];
          $end_date = $_REQUEST["end_date"];
          $Partner_id = $_REQUEST["Partner_id"];
          $partner_clients = $_REQUEST["partner_client"];
          $Voucher_status = $_REQUEST["Voucher_status"];
		  
		 $partner_clients_array=array();
		 if($Partner_id != 0 && $partner_clients ==0){
			 
			 
			$partner_clients=$this->Igain_model->get_partner_clients($Partner_id);
			// print_r($partner_clients); 
			foreach($partner_clients as $pClient){
				// echo "<br>---Company_id----".$pClient['Company_id'];
				
				$partner_clients_array[]=$pClient['Company_id'];
			}
			 
		 } else{
			
			$partner_clients_array[]=$partner_clients;
		 }
		 
          $data["Trans_Records"] = $this->Company_redemption_report_model->get_partner_redemption_details($Company_id, $start_date, $end_date, $Partner_id, $partner_clients_array,$Voucher_status);

        }

        $this->load->view("Company_redemption_reports/company_redemption_report", $data);
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

      $transaction_details = $this->Company_redemption_report_model->get_partener_update_voucher_status($Company_id, $Card_id, $Voucher_no);
      if ($transaction_details) {
        $data['transaction_details'] = $transaction_details;
      }
      $theHTMLResponse = $this->load->view('Company_redemption_reports/Show_partener_redemption_receipt', $data, true);
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
        // $partner_branches = $_REQUEST["partner_branches"];
        $partner_clients = $_REQUEST["partner_client"];
        $Voucher_status = $_REQUEST["Voucher_status"];

        $Today_date = date("Y-m-d");
		
		
		
		
		 $partner_clients_array=array();
		 if($Partner_id != 0 && $partner_clients ==0){
			 
			 
			$partner_clients=$this->Igain_model->get_partner_clients($Partner_id);
			// print_r($partner_clients); 
			foreach($partner_clients as $pClient){
				// echo "<br>---Company_id----".$pClient['Company_id'];
				
				$partner_clients_array[]=$pClient['Company_id'];
			}
			 
		 } else{
			
			$partner_clients_array[]=$partner_clients;
		 }
		 
          $data["Trans_Records"] = $this->Company_redemption_report_model->get_partner_redemption_details_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_clients_array,$Voucher_status);
		
		

        // $data["Trans_Records"] = $this->Company_redemption_report_model->get_partner_redemption_details_exports($Company_id, $start_date, $end_date, $Partner_id, $partner_branches, $Voucher_status);


        $name = 'partner_cmp_redemption_rpt';
        $cmp_name = str_replace(' ', '_', $Company_name);
        // $Export_file_name = $cmp_name . "_" . $start_date . "_To_" . $end_date . "_Redemp_Rpt";
        $Export_file_name = "Company_" . $start_date . "_To_" . $end_date . "_Redempmption_Rpt";
        // $Export_file_name = "Redemp_Rpt";
        $data["Report_date"] = $Today_date;
        $data["Report_type"] = $Report_type;
        $data["report_type"] = $Report_type;
        $data["From_date"] = $start_date;
        $data["end_date"] = $end_date;
        $data["Company_name"] = $Company_name;

        if ($pdf_excel_flag == 1) {
          $this->excel->getActiveSheet()->setTitle('Partner CMP Redemption Report');
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
          $html = $this->load->view('Company_redemption_reports/pdf_partner_redemption_report', $data, true);
          $this->m_pdf->pdf->WriteHTML($html);
          $this->m_pdf->pdf->Output($Export_file_name . ".pdf", "D");
        }
      } else {
        redirect('Login', 'refresh');
      }
    }
  }
?>
