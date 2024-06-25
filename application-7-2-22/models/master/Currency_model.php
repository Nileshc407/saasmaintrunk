<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model 
{
	function insert_currency()
    {
		$data['Country_name'] = $this->input->post('Currency_nation');
		$data['Currency_name'] = $this->input->post('Currency_name');        
		$data['Symbol_of_currency'] = $this->input->post('currency_symbol');
		$data['Dial_code'] = $this->input->post('dial_code');
		$this->db->insert('igain_currency_master', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
	
	public function currency_count()
	{
		return $this->db->count_all("igain_currency_master");
	}
	
	public function currency_list($limit,$start)
	{
		// $this->db->limit($limit,$start);
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
	
	public function update_currency($post_data,$Country_id)
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
	}
}
?>