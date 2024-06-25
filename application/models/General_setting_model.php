<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_setting_model extends CI_Model
{

	function get_type_name_by_id($type, $type_id = '', $field = 'name',$Company_id,$sellerID)
    {
		if ($type_id != '') {
            $l = $this->db->get_where($type, array(
               'Company_id' => $Company_id,
			   'Seller_id' => $sellerID,
                'type' => $type_id
            ));
            $n = $l->num_rows();
			 // echo"---sql----".$this->db->last_query()."----<br>";
            if ($n > 0) {
                return $l->row()->$field;
            }
        }
    }
	public function template_count()
	{
		return $this->db->count_all("frontend_settings");		
	}
	public function Company_template_count($Company_id,$Seller_id)
	{
		
		// echo"---Company_id----".$Company_id."----<br>";
		// echo"---Seller_id----".$Seller_id."----<br>";
		// die;
		$this->db->select("COUNT(*)");
		$this->db->where(array('Company_id'=>$Company_id,'Seller_id'=>$Seller_id));
		// $this->db->group_by('Company_id');
		$query = $this->db->get('frontend_settings');
		// echo"---sql----".$this->db->last_query()."----<br>";
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];
		
	}
	public function Company_template_details($Company_id,$limit,$start)
	{
		$this->db->select('*');
		$this->db->from('frontend_settings');
		$this->db->join('igain_enrollment_master','igain_enrollment_master.Enrollement_id =frontend_settings.Seller_id','LEFT');
		$this->db->where('frontend_settings.Company_id', $Company_id);
		$this->db->group_by('frontend_settings.Seller_id');
		//$this->db->limit($limit,$start);
		$query = $this->db->get();		
		 // echo"---sql----".$this->db->last_query()."----<br>";
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return 0;
		}
		
	}	
}