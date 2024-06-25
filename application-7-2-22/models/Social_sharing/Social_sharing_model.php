<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social_sharing_model extends CI_Model 
{
	function insert_share_notification_details($Share_insert_array)
    {
		$this->db->insert('igain_share_notification_details', $Share_insert_array);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
	
	public function check_social_shared($Enrollement_id,$Company_id,$Social_icon_flag)
	{
		$this->db->from('igain_share_notification_details');
		$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Social_media' => $Social_icon_flag));
		return $this->db->count_all_results();
	}
	
	public function check_social_shared2($Enrollement_id,$Company_id,$Social_icon_flag,$User_notification_id)
	{
		$this->db->from('igain_share_notification_details');
		$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'User_notification_id' => $User_notification_id, 'Social_media' => $Social_icon_flag));
		return $this->db->count_all_results();
	}
	
	public function get_share_notification_details($Enrollement_id,$Company_id,$Social_icon_flag)
	{
		$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Social_media' => $Social_icon_flag));
		$query = $this->db->get("igain_share_notification_details");
		if ($query->num_rows() > 0)
		{
            return $query->row();
        }
		else
		{
			return false;
		}
	}
	
	public function update_member_balance($Enrollement_id,$New_Current_balance)
	{
		$data = array(
               'Current_balance' => $New_Current_balance
			);
		$this->db->where('Enrollement_id', $Enrollement_id);
		$this->db->update("igain_enrollment_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function insert_share_transaction($Share_transaction_array)
    {
		$this->db->insert('igain_transaction', $Share_transaction_array);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
	
	/* public function currency_list($limit,$start)
	{
		$this->db->limit($limit,$start);
		$this->db->order_by('Country_id','ASC');
        $query = $this->db->get("igain_currency_master");

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
   
   public function edit_currency($Country_id)
   {	   
		$this->db->where('Country_id', $Country_id);
		$query = $this->db->get("igain_currency_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	
	public function update_member_balance($post_data,$Country_id)
	{
		$this->db->where('Country_id', $Country_id);
		$this->db->update("igain_currency_master", $post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	} */
}
?>