<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Saas_invoice extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Saas_model');
		$this->load->library('form_validation');	
		$this->load->library('Send_notification');
		$this->load->library('m_pdf');
		$this->load->helper('file');
		$this->load->helper(array('form', 'url','encryption_val'));	
		$this->load->model('Email_templateM/Email_templateModel');
	}
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data['Partner_clients'] = $this->Igain_model->get_partner_clients($enroll_details->Company_id);
			
			$Company_id =$_REQUEST['Company_id'];
			$Payment_type =$_REQUEST['Payment_type'];
			$Invoice_no =$_REQUEST['Invoice_no'];
			$From_date =$_REQUEST['start_date'];
			$Till_date =$_REQUEST['end_date'];
			
			if ($_REQUEST != NULL) 
			{
				$data['Payment_record'] = $this->Saas_model->Get_payment_record($Invoice_no,$Company_id,$From_date,$Till_date,$Payment_type);
			}
			$this->load->view('Saas_company/Saas_billing_invoice_view', $data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Download()
	{		
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Company_License_type = $session_data['Company_License_type'];
			$Create_user_id = $data['enroll'];
			
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['userId'] = $session_data['userId'];
			
			$enroll_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$enroll_country_id = $enroll_details->Country;
			
			$Todays_date = date('Y-m-d');
				
			$Company_id = $_REQUEST['Company_id'];
			$Payment_id = $_REQUEST['Payment_id'];
			
			$data['Payment_details'] = $this->Saas_model->Get_payment_incoice_details($Payment_id,$Company_id);
			if($data['Payment_details'] != Null)
			{	
				if($data['Payment_details']->Payment_status =="captured")
				{
					$Enrollement_id = $data['Payment_details']->Enrollement_id;
					
					$enroll_details = $this->Igain_model->get_enrollment_details($Enrollement_id);
					$data['LogginUserName'] = $enroll_details->First_name.' '.$enroll_details->Last_name;
					
					$Payment_email = $data['Payment_details']->Payment_email;
					$License_type = $data['Payment_details']->License_type;
					$Billing_country_name = $data['Payment_details']->Country_name;
					$Invoice_no = $data['Payment_details']->Bill_no;
					
					$date1=date_create($data['Payment_details']->Bill_date);
					$data['Invoice_date'] = date_format($date1,"d-M-Y");
					
					$date2=date_create($data['Payment_details']->Pyament_expiry_date);
					$data['Valid_till'] = date_format($date2,"d M Y");  
					
					if($Billing_country_name == "India")
					{
						$data["Symbol_currency"] = "INR";
						$Currency_alies = "INDIAN RUPEES";
					}
					else
					{
						$data["Symbol_currency"] = "USD";
						$Currency_alies = "US DOLLAR";
					}
					if($License_type == 120)
					{
						$data['License'] = "Enhance";
					}
					else if($License_type == 121)
					{
						$data['License'] = "Basic";
					}
					else if($License_type == 253)
					{
						$data['License'] = "Standard";
					}
					
					$Bill_amaount_in_word = $this->convert_number($data['Payment_details']->Bill_amount);
					
					$data['Bill_amaount_in_word'] = $Currency_alies.' '.$Bill_amaount_in_word.' only';
					
					$Compnay_details = $this->Igain_model->get_company_details($Company_id);
	
					$data['Company_name'] = $Compnay_details->Company_name;	
					
					$data['Application_name'] = "iGainspark SaaS Loyalty";
					
				/**********************************************************************/
					ob_start();
					$htmlBill = $this->load->view('Saas_company/pdf_saas_billing_invoice', $data, true);
					// echo $htmlBill; 
					
					$Bill_filename = $data['Company_name'].'_'.$Invoice_no.'_'.date('Y_m_d_H_i_s');
					
					$billing_file_path = "";
					
					$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
					 
					$pdf = new mPDF();
					$pdf->SetWatermarkText('DUPLICATE');
					$pdf->showWatermarkText = true;
					$pdf->showImageErrors = true;
					$pdf->WriteHTML($htmlBill);
					$pdf->Output($Bill_filename . '.pdf', 'D');
					  /*unset($pdf);
					  die; */
					// $pdf->setFooter('{PAGENO}');
					$billing_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Saas_company_Duplicate_billing_files/' . $Bill_filename . '.pdf', 'F');
					$pdf->Output($DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf', 'F');
					$billing_file_path = $DOCUMENT_ROOT . '/export/Saas_company_billing_files/' . $Bill_filename . '.pdf';
					unset($pdf);
				/**********************************************************************/
				}
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= " " . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }	
}
?>