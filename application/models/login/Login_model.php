<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {   
	
	function login($username,$password,$flag)
    {	
		
		$this->db->select('E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Top_up_menu, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,
						   E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Seller_topup_access, E.Current_balance,C.Localization_flag ,C.Localization_logo,C.Company_logo,C.Coalition,E.Photograph,C.Parent_company,C.Allow_membershipid_once,C.Allow_merchant_pin,Membership_redirection_url,Company_License_type,Comp_regdate');
		$this->db->from('igain_enrollment_master as E');
		$this->db->join('igain_company_master as C', 'C.Company_id = E.Company_id');
		$this->db->where(array('C.Activated' => '1', 'E.User_activated' => '1', 'E.User_email_id' => $username, 'E.User_pwd' => $password, 'E.User_id !=' => '1'));
		
		$login_sql = $this->db->get();
		
		if($login_sql -> num_rows() == 1)
		{
			$login_result = $login_sql->result_array();			
			foreach($login_result as $login_row)
			{
				$enroll = $login_row['Enrollement_id'];
				$userId = $login_row['User_id'];
				/*--------------Live Chat-----------------*/
				$Subselleradmin = $login_row['Sub_seller_admin'];
				/*--------------Live Chat-----------------*/
				$timezone_entry = $login_row['timezone_entry'];
				$Partner_company_flag = $login_row['Partner_company_flag'];
				$Company_id = $login_row['Company_id'];
			}
			
			$update_data=array('description' => '0');
			$this->db->where('userName', $username);
			$this->db->update("igain_session_tbl", $update_data);			
			date_default_timezone_set($timezone_entry);
			// $starttime = date('Y-m-d H:i:s', time());
			
			
			$logtimezone = $timezone_entry;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$starttime=$date->format('Y-m-d H:i:s');
			
			$ip = $this->get_ip_address();		
			$desc = '1';	
			/*-------------------------------Live Chat----------------------------*/
			if($userId == 6 AND $Subselleradmin == 0)
			{
				$insert_data=array('Company_id' => $Company_id,'userName' => $username, 'enrollId' => $enroll, 'userId' => $userId, 'startTime' => $starttime, 
								'clientIp' => $ip, 'description' => $desc, 'notes' => $flag, 'Chat_status' => 1);
				$this->db->insert('igain_session_tbl', $insert_data);
			}
			else
			{
				$insert_data=array('Company_id' => $Company_id,'userName' => $username, 'enrollId' => $enroll, 'userId' => $userId, 'startTime' => $starttime, 
								'clientIp' => $ip, 'description' => $desc, 'notes' => $flag);
				$this->db->insert('igain_session_tbl', $insert_data);
			}
			/* echo $this->db->last_query();
			die;
			 */
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
	/*************************Nilesh Chnage Call center user*******************************/
	function logout_cc_user($CompanyID,$Username,$enrollId,$userId) 
	{
		$update_data=array('description' => '0');
		$this->db->where(array('Company_id' => $CompanyID, 'userName' => $Username, 'enrollId' => $enrollId, 'userId' => $userId, 'description' => 1));
		$this->db->update("igain_session_tbl", $update_data);
	}
	/*************************Nilesh Chnage Call center user*******************************/
	
	public function Get_saas_company_payment_details($Company_id)
	{	  
		$Status = "captured";
		
		$edit_query = "SELECT Pyament_expiry_date FROM igain_saas_company_billing_payment_details WHERE Company_id='".$Company_id."' AND Payment_status='".$Status."' AND Payment_type=0 order by Payment_id desc LIMIT 1";
		
		$edit_sql = $this->db->query($edit_query);
				
		if($edit_sql -> num_rows() == 1)
		{
			return $edit_sql->row();
		}
		else
		{
			return false;
		}		
	}

}
?>
