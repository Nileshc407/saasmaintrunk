<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
class Auto_process_publisher_purchased_miles extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Report/Report_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Reconsolation_data/Reconsolation_data_map');
		$this->load->library("excel");
		$this->load->library('m_pdf');
		$this->load->helper('file');
		
		// echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("m-d");
		
		foreach($Company_details as $Company_Records)
		{
			// echo"<pre>";
			// echo "<br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
			
			
			
			
			$Company_city_state_country=$this->Igain_model->Company_city_state_country($Company_Records["Company_id"]);
			
			
		
			$data['Pubblisher'] = $this->Reconsolation_data_map->get_publisher($Company_Records["Company_id"]);
			// $temp_table = $this->Reconsolation_data_map->create_temp_table($Company_Records["Company_id"]);
			// print_r($data['Pubblisher']);			
			// get_publisher
			// $data['purchased_transaction'] = $this->Reconsolation_data_map->get_publisher_purchased_transaction($Company_Records["Company_id"],$publisher['Register_beneficiary_id']);
			
			$send_flag=0;	
			foreach($data['Pubblisher'] as $publisher) {
				
				if($publisher['Cron_purchased_miles_flag']==1) {
					
					
					$Currency="Purchased ".$publisher['Currency'];
					
					// echo "<br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
					// echo "<br><b>publisher Name --->".$publisher['Beneficiary_company_name']."</b>";
					
					$data['purchased_transaction'] = $this->Reconsolation_data_map->get_publisher_purchased_transaction($Company_Records["Company_id"],$publisher['Register_beneficiary_id']);
					
					
					$data['publisher_transaction'] = $this->Reconsolation_data_map->get_publisher_transaction($Company_Records["Company_id"],$publisher['Register_beneficiary_id']);
					
					// print_r($data['publisher_transaction']);
					// die;
					if(!empty($data['publisher_transaction'])) {
						
						$data['Export_file_name'] =$publisher['Beneficiary_company_name']."-Purchased-".$publisher['Currency'];			
						$data['Publisher_name']  = $publisher['Beneficiary_company_name'];	
						$data['Currency']  = $publisher['Currency'];	

						$html = $this->load->view('Reconsolation_data/pdf_send_publisher_purchased_miles', $data, true);
						
						// echo"---publisher_transaction---".$html;
						
						$Filename=$publisher['Register_beneficiary_id'].'Purchased '.$publisher['Currency'].'-'.date('Y_m_d_H_i');
						$pdf = new mPDF();
					
						$pdf->setFooter('{PAGENO}');
						
						$pdf->setAutoTopMargin = 'pad';
						
						$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
						//echo "<br><b>DOCUMENT_ROOT --->".$DOCUMENT_ROOT."</b>";
						
						
						$pdf->SetHTMLHeader('<header class="clearfix"> <h1>Purchased '.$publisher['Currency'].'</h1>
							<div id="company"> <h3>TO</h3> <div>Pubblisher Name:  '.$publisher['Beneficiary_company_name'].'</div>
								<div>Date: </span>'.date("j, F Y h:i:s A").'</div>  </div><div id="project" class="clearfix"> <h3>From</h3> <div>'.$Company_Records["Company_name"].'</div> <div>'.$Company_Records["Company_address"].'</div> <div>'.$Company_city_state_country->City_name.','.$Company_city_state_country->State_name.',<br /> '.$Company_city_state_country->Country_name.'</div>  <div><a href="mailto:'.$Company_Records['Beneficiary_company_name'].'">'.$Company_Records['Company_contactus_email_id'].'</a></div> <div>'.$Company_Records['Company_primary_phone_no'].'</div></div></header> ','',true);
						$pdf->WriteHTML($html);
					
						$pdf->Output($DOCUMENT_ROOT.'/export/Purchased_miles/'.$Filename.'.pdf','F');
						$Miles_file_path=$DOCUMENT_ROOT.'/export/Purchased_miles/'.$Filename.'.pdf';
						$Miles_file_path_PDF=$DOCUMENT_ROOT.'/export/Purchased_miles/'.$Filename.'.pdf';
						
						
						
						/*$filenameXLS =$DOCUMENT_ROOT.'/export/Purchased_miles/'.$Filename.'.xls';
						$Email_content = array(
							'Todays_date' => $Todays_date,
							'Publisher_name' => $publisher['Beneficiary_company_name'],						
							'Contact_email_id' => $publisher['Contact_email_id'],						
							'Contact_email_id1' => $publisher['Contact_email_id1'],						
							'Contact_email_id2' => $publisher['Contact_email_id2'],						
							'Company_finance_email_id' => $Company_Records['Company_finance_email_id'],
							'Currency' => $publisher['Currency'],
							'filename' => $Filename,
							'Miles_file_path_pdf' => $Miles_file_path,
							'Miles_file_path_xls' => $filenameXLS,
							'Notification_type' =>$publisher['Currency'].' Purchased of '.$publisher['Beneficiary_company_name'].' using JOY Application',
							'Template_type' => 'Publisher_purchased_miles_File'
						);			
						$Notification=$this->send_notification->send_Notification_email('',$Email_content,'',$Company_Records["Company_id"]);
						
						print_r($Email_content);
						*/
						
						
						// unset($pdf);					
						
						
						/*-------------------------------------Start Excel----------------------------------------*/
						
						
						$object = new Excel();
						$object->setActiveSheetIndex(0);
						$table_columns = array("Transaction Date","Bill No.","Pubblisher Name", "$Currency" , "Membership ID", "Member Name",  "Status", "Remarks");

						  $column = 0;

						  foreach($table_columns as $field)
						  {
								$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
								$column++;
						  }
						  $excel_row = 2;
						
						  foreach($data['publisher_transaction'] as $pub)
						  {
							   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $pub->Transaction_date);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $pub->Pos_Billno);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $pub->Publisher_name);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $pub->Purchased_miles);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $pub->Customerno);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $pub->Customer_name);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $pub->Status);
							   $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $pub->Remarks);
							   
							   $excel_row++;
							   $i++;
						  }

						$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
						
						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
						header("Content-Transfer-Encoding: binary ");
						$filenameXLS =$DOCUMENT_ROOT.'/export/Purchased_miles/'.$Filename.'.xls';
						$filenameXLS_XLS =$DOCUMENT_ROOT.'/export/Purchased_miles/'.$Filename.'.xls';
						$object_writer->save($filenameXLS); 
					
					
					
						 
						 
						/* echo"-------Beneficiary_company_name-------".$publisher['Beneficiary_company_name']."---<br>";
						echo"-------Contact_email_id-------".$publisher['Contact_email_id']."---<br>";
						echo"-------Contact_email_id1-------".$publisher['Contact_email_id1']."---<br>";
						echo"-------Contact_email_id2-------".$publisher['Contact_email_id2']."---<br>";
						echo"-------Company_finance_email_id-------".$Company_Records['Company_finance_email_id']."---<br>";
						echo"-------Currency-------".$publisher['Currency']."---<br>";
						echo"-------Filename-------".$Filename."---<br>";
						echo"-------Miles_file_path_PDF-------".$Miles_file_path_PDF."---<br>";
						echo"-------filenameXLS_XLS-------".$filenameXLS_XLS."---<br>";
						echo"-------Filename-------".$Filename."---<br>";
						echo"-------Filename-------".$Filename."---<br>"; */
						 
						$data['drop_table'] = $this->Reconsolation_data_map->drop_publisher_temp_table($publisher['Register_beneficiary_id']);
						
						
						foreach($data['publisher_transaction'] as $pub) {
							
							$data['update_transaction'] = $this->Reconsolation_data_map->update_publisher_transaction($Company_Records["Company_id"],$pub->Transaction_id,$pub->Publisher_id,$pub->Customerno,$pub->Purchased_miles);
						}
						// unset($object);
						// unset($object_writer);
						// unset($Email_content);
						// unset($Miles_file_path);
						// unset($filenameXLS);
							
						$send_flag=1;	
						
					} else {
						
						$send_flag=0;
					}	
					
					// echo"-------send_flag-------".$send_flag."---<br>";
					
					if($send_flag==1)
					{
						
						// echo"-----in--send_flag---<br>";
						
						// echo"-------Todays_date-------".$Todays_date."---<br>";
						
						
						
						$Email_content = array(
							'Todays_date' => $Todays_date,
							'Publisher_name' => $publisher['Beneficiary_company_name'],						
							'Contact_email_id' => $publisher['Contact_email_id'],						
							'Contact_email_id1' => $publisher['Contact_email_id1'],						
							'Contact_email_id2' => $publisher['Contact_email_id2'],						
							'Company_finance_email_id' => $Company_Records['Company_finance_email_id'],
							'Currency' => $publisher['Currency'],
							'filename' => $Filename,
							'Miles_file_path_pdf' => $Miles_file_path_PDF,
							'Miles_file_path_xls' => $filenameXLS_XLS,
							'Notification_type' =>$publisher['Currency'].' Purchased of '.$publisher['Beneficiary_company_name'].' using JOY Application',
							'Template_type' => 'Publisher_purchased_miles_File'
						);	
						// print_r($Email_content);
						$Notification=$this->send_notification->send_Notification_email('',$Email_content,'',$Company_Records["Company_id"]);
						
						// unset($Miles_file_path_PDF);
						// unset($filenameXLS_XLS);
					}
					
					
				}
			}
			
			
			
	}
}	
}
?>