<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {   
	
	function login($username,$password,$Company_id,$flag)
    {	

		/* $this->db->select('E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Card_id, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,
						   E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Country_language');
		$this->db->from('igain_enrollment_master as E');
		$this->db->join('igain_company_master as C', 'C.Company_id = E.Company_id');
		$this->db->where(array('C.Activated' => '1', 'E.User_activated' => '1', 'E.User_email_id' => $username,'E.Company_id' => $Company_id));
		// $this->db->where('E.User_pwd like binary ',$password);
		 $this->db->where("BINARY  E.User_pwd = ",$password); */
		 
		 $query = 'SELECT E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Card_id, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id,E.Current_balance,E.Blocked_points,E.Debit_points, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Country_language FROM igain_enrollment_master as E JOIN igain_company_master as C ON C.Company_id = E.Company_id WHERE C.Activated = 1 AND E.User_activated = 1 AND E.User_email_id = "'.$username.'" AND E.Company_id = "'.$Company_id.'" AND BINARY E.User_pwd = "'.$password.'" ';		
		// $login_sql = $this->db->get();
		$login_sql = $this->db->query($query);
		// echo $this->db->last_query();
		// die;
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
			}			
			$update_data=array('description' => '0');
			$this->db->where('userName', $username);
			$this->db->update("igain_session_tbl", $update_data);
			
			$starttime = date('Y-m-d H:i:s', time());
			$ip = $this->get_ip_address();		
			$desc = '1';	
			
			/* $insert_data=array('Company_id' => $Company_id,'userName' => $username, 'enrollId' => $enroll, 'userId' => $userId, 'startTime' => $starttime,'clientIp' => $ip, 'description' => $desc, 'notes' => $flag);
			$this->db->insert('igain_session_tbl', $insert_data); */
			
			/********************Check Company has Client or not*******************************/
			$this->db->select('*');
			$this->db->from('igain_company_master');
			$this->db->where(array('Parent_company' => $Company_id, 'Activated' => '1'));
			$Count_sql = $this->db->get();
		
			$Count_Client_Company = $Count_sql->num_rows(); 
			$login_result[0]["Count_Client_Company"] =  $Count_Client_Company;
			/****************************************************************************/
		
			return  $login_result; //$login_sql->result_array();
		}
		else
		{
			return false;
		}		    
    } 
	public function insert_into_session($Company_id,$username,$enroll,$userId,$flag,$starttime)
	{
		$ip = $this->get_ip_address();
		// $starttime = date('Y-m-d H:i:s', time());
		$desc = '1';
		$insert_data=array('Company_id' => $Company_id,'userName' => $username, 'enrollId' => $enroll, 'userId' => $userId, 'startTime' => $starttime,'clientIp' => $ip, 'description' => $desc, 'notes' => $flag);
		$this->db->insert('igain_session_tbl', $insert_data);
	}
	public function Insert_failed_login($CompanyID,$email,$password,$User_id,$starttime)
	{
		$ip = $this->get_ip_address();
		// $starttime = date('Y-m-d H:i:s', time());		
		$insert_data=array('Company_id' => $CompanyID,'User_email_id' => $email, 'Password' => $password, 'Login_date' => $starttime, 'User_id' => $User_id);
		$this->db->insert('igain_failed_login', $insert_data);
	}
	function customer_login($username,$password,$Company_id,$flag)
    {	
		/* $this->db->select('E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Card_id,
						   E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name,  C.Company_id ');
		$this->db->from('igain_enrollment_master as E');
		$this->db->join('igain_company_master as C', 'C.Company_id = E.Company_id');
		$this->db->where(array('C.Activated' => '1', 'E.User_id' => '1','E.User_activated' => '1', 'E.User_email_id' => $username,'E.User_pwd' => $password,'E.Company_id' => $Company_id));		
		$login_sql = $this->db->get(); */
		// echo $this->db->last_query();
		
		
		$query = 'SELECT E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Card_id, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Country_language FROM igain_enrollment_master as E JOIN igain_company_master as C ON C.Company_id = E.Company_id WHERE C.Activated = 1 AND E.User_activated = 1 AND E.User_email_id = "'.$username.'" AND E.Company_id = "'.$Company_id.'" AND BINARY E.User_pwd = "'.$password.'" ';		
		// $login_sql = $this->db->get();
		$login_sql = $this->db->query($query);
		
		
		if($login_sql -> num_rows() == 1)
		{
			$login_result = $login_sql->result_array();			
			foreach($login_result as $login_row)
			{
				$enroll = $login_row['Enrollement_id'];
				$userId = $login_row['User_id'];
				$timezone_entry = $login_row['timezone_entry'];
				$Company_id = $login_row['Company_id'];
			}			
			$update_data=array('description' => '0');
			$this->db->where('userName', $username);
			$this->db->update("igain_session_tbl", $update_data);
			
			$starttime = date('Y-m-d H:i:s', time());
			$ip = $this->get_ip_address();		
			$desc = '1';	
			
			
			/* $insert_data=array('Company_id' => $Company_id,'userName' => $username, 'enrollId' => $enroll, 'userId' => $userId, 'startTime' => $starttime,'clientIp' => $ip, 'description' => $desc, 'notes' => $flag);			
			$this->db->insert('igain_session_tbl', $insert_data); */			
			// http://localhost/CI_iGainSpark/Company_59/index.php/login?username=ravip@miraclecartes.com&password=1234&company_id=59&flag=1
			
			
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
	 function validate_voucher($Order,$Company_id)
	 {
        $this->db->select('Voucher_no,Trans_date,Voucher_status,Code_decode,Item_image1');
        $this->db->from('igain_transaction as t');
		$this->db->join('igain_codedecode_master as c','t.Voucher_status=c.Code_decode_id');
		$this->db->join('igain_company_merchandise_catalogue as cm','t.Item_code=cm.Company_merchandize_item_code  AND t.Company_id=cm.Company_id ');
        $this->db->where(array('Bill_no' => $Order,'t.Company_id' => $Company_id,'Trans_type' => 12));
        $sql51 = $this->db->get();
       // echo $this->db->last_query();die;
        return $sql51->result_array();
    }
	  public function get_all_items_nova($limit,$start,$Company_id,$Merchandize_category_id,$Search_by_name)
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
		}
	
		
		if($Search_by_name!='')
		{
			//$this->db->where("Merchandize_item_name like '%$Search_by_name%'");
			$this->db->like('Merchandize_item_name', $Search_by_name);
		}
		
		if($limit!=NULL || $start!=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$sql = $this->db->get();
		 //echo "<br><br>************<br>".$this->db->last_query();
		// die;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
     
}
?>
