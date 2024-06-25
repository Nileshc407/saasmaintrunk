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
		$this->db->where(array('Company_id' => $Company_id,'userId' => '6','description' => '1'));
		$this->db->limit('1');
		$sql = $this->db->get();	
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
	function getchatUsers($Company_id,$email_id)
	{	
		$Todays=date("Y-m-d");//2017-08-23 05:47:00 
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where(array('Company_id' => $Company_id, 'To_email_id' => $email_id));
		// $this->db->where("Sent_date >='".$Todays."'"); 
		$this->db->order_by('Id','desc');
		$this->db->limit('1');
		$sql = $this->db->get();	
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
	function getchatsnew($Company_id,$To_email_id,$user)
	{
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where("(To_email_id = '".$To_email_id."'  AND read=0)");
		$this->db->where("(Company_id = '".$Company_id."')");
		$this->db->order_by('Id','ASC');
		$result = $this->db->get();
		return $result->result_array(); 		
	}
	function getchatsall($Company_id,$user,$from_email_id)
	{
		$Todays=date("Y-m-d");//2017-08-23 05:47:00
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where("(read=1 AND Sent_date >='".$Todays."') AND (To_email_id = '".$from_email_id."' OR From_email_id = '".$from_email_id."' ) AND (Company_id = '".$Company_id."')");
		$this->db->order_by('Id','ASC');
		$result = $this->db->get();
		return $result->result_array(); 	
	}	
	function checkchatsnew($Company_id,$user,$To_email_id)
	{
		$this->db->where(array('To_email_id' => $To_email_id, 'read'=>0, 'Company_id'=> $Company_id));
		$this->db->update('igain_call_center_live_chat', array('read' => 1)); 	
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
		return false;
	}
	function Update_chat_status_session_tbl($Post_data,$enroll_id,$Company_id)
    {		
		$this->db->where(array('enrollId' => $enroll_id,'Company_id' => $Company_id,'userId' => 6,'description' => 1));
		$this->db->update('igain_session_tbl', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	function Chack_online_satus($Company_id,$User_email_id,$login_userName)
	{
		$Todays=date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('igain_call_center_live_chat');
		$this->db->where(array('Company_id'=>$Company_id, To_email_id => $User_email_id));
		// $this->db->where(array('Company_id'=>$Company_id,'To_email_id'=>$User_email_id,'To_name'=>$login_userName));
		$this->db->limit(1);
		$this->db->order_by('Id','DESC');
		$result = $this->db->get();
		return $result->result_array();	
		// echo $this->db->last_query(); die;
	}
 }
 ?>