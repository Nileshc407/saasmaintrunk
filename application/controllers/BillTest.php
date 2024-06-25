<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR |E_PARSE|E_CORE_ERROR);
 
class BillTest extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();	
		$this->load->database();
		
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model("login/Home_model");
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Send_notification');
		$this->load->model('master/currency_model');
		$this->load->library('m_pdf');
		$this->load->helper('file');
	}
	function index()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];
			$data['Country_id'] = $session_data['Country_id'];
			$CompanyID = $session_data['Company_id'];
			/*--------------Live Chat----------------*/
			$data['Company_id'] = $CompanyID;
			/*--------------Live Chat----------------*/
			$data['Logged_user_id'] = $session_data['userId'];
			$data['test'] ='test';
			$data['Super_seller'] = $session_data['Super_seller'];
			$data['Sub_seller_admin'] = $session_data['Sub_seller_admin'];
			
			// $data["enrollment_details"]= $this->Igain_model->get_enrollment_details($data['enroll']);
			
			$data["Company_details"] = $this->Igain_model->get_company_details($CompanyID);
			
			
			$Company_details = $this->Igain_model->get_company_details($CompanyID);
			$Survey_analysis= $Company_details->Survey_analysis;
	
/**********************************************************************/
		ob_start();
		$htmlBill = $this->load->view('Saas_company/pdf_saas_billing_invoice', $data, true);
		// echo $htmlBill; 
		// $Bill_filename = $seller_id . 'INVOICE_' . date('Y_m_d_H_i_s') . '_' . $billing_bill;
		$Bill_filename = 'INVOICE_' . date('Y_m_d_H_i_s');
		
		$billing_file_path = "";
		
		$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
		
		// if (!empty($data1['Seller_billing_records'])) 
		// {
		  $pdf = new mPDF();
		  //$pdf->SetProtection(array(), $Seller_pin, $Super_Seller_pin);
			$pdf->showImageErrors = true;
		  $pdf->WriteHTML($htmlBill);
		  /* $pdf->Output($Bill_filename . '.pdf', 'D');
		  unset($pdf);
		  die; */
		 // $pdf->setFooter('{PAGENO}');
		  $billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf', 'F');
		  $pdf->Output($DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf', 'F');
		  $billing_file_path = $DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf';
		  unset($pdf);
/**********************************************************************/	
		}
	}
}
?>