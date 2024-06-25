<?php
class Users_model extends CI_Model 
{  
	function __Construct()
    {
        parent::__Construct();
    }
	/*---------Get Login user----------------*/
	function getUsers($Company_id)
	{	 	
		$this->db->select('*');
		$this->db->from('igain_session_tbl');
		// $this->db->where(array('Company_id' => $Company_id,'userId' => '6','description' => '1'));
		$this->db->where(array('Company_id' => $Company_id,'userId' => '6','description' => '1','Chat_status' => 1));
		//$this->db->limit('1');
		$sql = $this->db->get();	
		// echo $this->db->last_query();
		$user_result = $sql->result_array();		
		if($sql->num_rows() > 0)
		{
			return $user_result;
		}
		else
		{
			return 0;
		}
    }
	/*---------Get Login user----------------*/ 
	function insert_chat_message($Post_data)
	{
		$this->db->insert('igain_call_center_live_chat',$Post_data);
		
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	function getchats($user)
	{
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where(array('From_name' => $user, 'To_name'=>'ravi'));
		$result = $this->db->get();
		return $result->result_array(); 
			
	}
	function getchatsnew($Cust_email_id,$user)
	{
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where("(To_email_id = '".$Cust_email_id."' AND read=0)");
		// $this->db->limit(0,1);
		$this->db->order_by('Id','ASC');
		$result = $this->db->get();
		
		return $result->result_array(); 
				
	}
	function checkchatsnew($Cust_email_id,$user)
	{
		$this->db->where(array('To_email_id' => $Cust_email_id, 'read'=>0));
		$this->db->update('igain_call_center_live_chat', array('read' => 1)); 
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	function getchatsall($Cust_email_id,$user)
	{
		$Todays=date("Y-m-d");//2017-08-23 05:47:00
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where("(read=1 AND Sent_date ='".$Todays."') AND (To_email_id = '".$Cust_email_id."' OR From_email_id = '".$Cust_email_id."' )");
		$this->db->order_by('Id','ASC');
		$result = $this->db->get();
		return $result->result_array(); 
	}
	function Chack_online_satus($User_email_id,$login_userName)
	{
		$Todays=date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where("(To_email_id ='".$User_email_id."')");
		$this->db->limit(1);
		$this->db->order_by('Id','DESC');
		$result = $this->db->get();
		return $result->result_array();	
	}
 }
 ?>