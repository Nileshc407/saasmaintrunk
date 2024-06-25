<?php
class Qr_model extends CI_Model
{
	function Login($Company_id,$Seller_enroll_id)
	{
		$this->db->select('E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name,E.User_email_id,E.User_pwd, E.Top_up_menu, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,
						   E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Seller_topup_access, E.Current_balance,C.Localization_flag ,C.Localization_logo,C.Company_logo,C.Coalition,E.Photograph,C.Parent_company');
		$this->db->from('igain_enrollment_master as E');
		$this->db->join('igain_company_master as C', 'C.Company_id = E.Company_id');
		$this->db->where(array('C.Activated' => '1', 'E.User_activated' => '1', 'E.Company_id' => $Company_id, 'E.Enrollement_id' => $Seller_enroll_id, 'E.User_id !=' => '1'));
		
		$login_sql = $this->db->get();
		
		if($login_sql -> num_rows() == 1)
		{
			$login_result = $login_sql->result_array();		
			
			foreach($login_result as $login_row)
			{
				$enroll = $login_row['Enrollement_id'];
				$userId = $login_row['User_id'];
				$timezone_entry = $login_row['timezone_entry'];
				$Partner_company_flag = $login_row['Partner_company_flag'];
				$Company_id = $login_row['Company_id'];
				$username = $login_row['User_email_id'];
				$password = $login_row['User_pwd'];
			}
			
			$update_data=array('description' => '0');
			$this->db->where('userName', $username);
			$this->db->update("igain_session_tbl", $update_data);			
			date_default_timezone_set($timezone_entry);
			$starttime = date('Y-m-d H:i:s', time());
			$ip = $this->get_ip_address();		
			$desc = '1';	
			
			$insert_data=array('Company_id' => $Company_id,'userName' => $username, 'enrollId' => $enroll, 'userId' => $userId, 'startTime' => $starttime, 
								'clientIp' => $ip, 'description' => $desc, 'notes' => '2');
			$this->db->insert('igain_session_tbl', $insert_data);
			
			/********************Check Company has Client or not*******************************/
			$this->db->select('*');
			$this->db->from('igain_company_master');
			$this->db->where(array('Parent_company' => $Company_id, 'Activated' => '1'));
			$Count_sql = $this->db->get();
		
			$Count_Client_Company = $Count_sql->num_rows();
 
			//echo "Count_Client_Company-->".$Count_Client_Company;
			
			$login_result[0]["Count_Client_Company"] =  $Count_Client_Company;
			/****************************************************************************/
			
			return  $login_result; //$login_sql->result_array();
		}
		else
		{
			return false;
		}		 
	}
	
	function get_ip_address() 
	{
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) 
		{
			if (array_key_exists($key, $_SERVER) === true) 
			{
				foreach (explode(',', $_SERVER[$key]) as $ip) 
				{
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) 
					{
						return $ip;
					}
				}
			}
		}
	}
}
?>
