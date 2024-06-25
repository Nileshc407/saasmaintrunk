<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paymenttype_model extends CI_Model 
{
	function insert_paymenttype()
    {
		$data['Payment_type'] = $this->input->post('Payment_type');
		$data['Payment_description'] = $this->input->post('Payment_description');    
		$this->db->insert('igain_payment_type_master', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		} 		
		
    }	
	public function paymenttype_count()
	{
		return $this->db->count_all("igain_payment_type_master");
		// if ($result && $result->count() > 0) {...}
	}	
	public function paymenttype_list($limit,$start)
	{
		// $this->db->limit($limit,$start);
		$this->db->order_by('Payment_type_id','ASC');
        $query = $this->db->get("igain_payment_type_master");

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
   public function edit_paymenttype($Payment_type_id)
   {	   
		$this->db->where('Payment_type_id', $Payment_type_id);
		$query = $this->db->get("igain_payment_type_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	
	public function update_paymenttype($post_data,$Payment_type_id)
	{
		$this->db->where('Payment_type_id', $Payment_type_id);
		$this->db->update("igain_payment_type_master", $post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function check_paymenttype($Payment_type)
	{
		$query =  $this->db->select('Payment_type')
				   ->from('igain_payment_type_master')
				   ->where(array('Payment_type' => $Payment_type))->get();
		return $query->num_rows();
	}
}
?>