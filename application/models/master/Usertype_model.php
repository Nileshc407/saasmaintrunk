<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usertype_model extends CI_Model 
{
	function insert_usertype()
    {
		$data['User_type'] = $this->input->post('User_Type');
		$data['User_description'] = $this->input->post('User_description');        
		$data['Create_user_id'] ='3';
		$data['Update_user_id'] ='3';
		$this->db->insert('igain_user_type_master', $data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		} 		
		
    }
	
	public function usertype_count()
	{
		return $this->db->count_all("igain_user_type_master");
		// if ($result && $result->count() > 0) {...}
	}	
	public function usertype_list($limit,$start)
	{
		// $this->db->limit($limit,$start);
		$this->db->order_by('User_id','ASC');
        $query = $this->db->get("igain_user_type_master");

        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }   
   public function edit_usertype($User_id)
   {	   
		$this->db->where('User_id', $User_id);
		$query = $this->db->get("igain_user_type_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	
	public function update_usertype($post_data,$User_id)
	{
		$this->db->where('User_id', $User_id);
		$this->db->update("igain_user_type_master", $post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function check_usertype($User_Type)
	{
		$query =  $this->db->select('User_Type')
				   ->from('igain_user_type_master')
				   ->where(array('User_Type' => $User_Type))->get();
		return $query->num_rows();
	}
}
?>