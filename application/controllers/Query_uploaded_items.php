<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
class Query_uploaded_items extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->library('Send_notification');
		$this->load->library('user_agent');
		$this->load->model('Igain_model');

	}
	public function index()
	{
		if(isset($_REQUEST['Company_id'])){
		$this->db->select("First_name,Last_name,`Brand_id`,`Outlet_id`,COUNT(*) AS Total_items,MAX(Create_date) AS Create_date,MAX(c.Update_date) AS Update_date");
		$this->db->from('igain_pos_item_linked_outlets as s');
		$this->db->join('igain_enrollment_master as e','s.Company_id=e.Company_id and s.Brand_id=e.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as c','c.Company_id=e.Company_id and c.Company_merchandize_item_code =s.Merchandize_item_code');
		$this->db->where(array('s.Company_id' => $_REQUEST['Company_id']));
		$this->db->group_by('Brand_id');
		$this->db->group_by('Outlet_id');
		$this->db->order_by('Update_date','desc');
		$sql = $this->db->get();
		// echo $this->db->last_query();
			$html = '<table style="WIDTH: 80%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left border=1>
			
													<tr style="HEIGHT: 20px">
														<td ><P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 20px; mso-line-height-rule: exactly" align=center>Brand</P></td>
														
														<td><P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 20px; mso-line-height-rule: exactly" align=center>Outlet</P></td>
														
														<td><P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 20px; mso-line-height-rule: exactly" align=center>Total Items</P></td>
														
														<td><P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 20px; mso-line-height-rule: exactly" align=center>Last Uploaded</P></td>
														
														
														</tr>';
																
													
													
												
		if ($sql->num_rows() > 0)
		{
        	foreach ($sql->result() as $row)
			{
				$this->db->select("First_name,Last_name");
				$this->db->from('igain_enrollment_master');
				$this->db->where(array('Enrollement_id' => $row->Outlet_id));
				$sql2 = $this->db->get();
				foreach ($sql2->result() as $row2)
				{
					$Outlet = $row2->First_name.' '.$row2->Last_name;
				}
                $Brand = $row->First_name.' '.$row->Last_name;
                $Total_items = $row->Total_items;
				if($row->Create_date > $row->Update_date){$Last_Uploaded_date=$row->Create_date;}else{$Last_Uploaded_date=$row->Update_date;}
				// if($row->Create_date < $row->Update_date){$Last_Uploaded_date=$row->Update_date;}
				$html.='<tr style="HEIGHT: 20px">
														<td >
															 <P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 16px; mso-line-height-rule: exactly" align=center>
																	'.$Brand.' ('.$row->Brand_id.')
																</P></td>
															
														<td>
															 <P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 16px; mso-line-height-rule: exactly" align=center>
																	'.$Outlet.' ('.$row->Outlet_id.')
																</P></td>
															
														<td >
															 <P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 16px; mso-line-height-rule: exactly" align=center>
																	'.$Total_items.'
																</P></td>
																
														<td >
															 <P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 16px; mso-line-height-rule: exactly" align=center>
																	'.$Last_Uploaded_date.'
																</P></td>
																	
														
																
																
																</tr>';
																
													
				
            }
			$html.='</table>';
												echo $html;
            
        }
		}
		else
		{
			echo "Enter right parameters";
		}			
		
		
	}	
}
?>

	
