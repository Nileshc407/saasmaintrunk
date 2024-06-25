<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_setting_model extends CI_Model
{

	/////////GET NAME BY TABLE NAME AND ID/////////////
   function get_type_name_by_id($type, $type_id = '', $field = 'name',$Company_id)
    {
		/* echo"---type----".$type."----<br>";
		echo"---type_id----".$type_id."----<br>";
		echo"---field----".$field."----<br>";
		 */
        if ($type_id != '') {
            $l = $this->db->get_where($type, array(
                'Company_id' => $Company_id,
                'type' => $type_id
            ));
            $n = $l->num_rows();
			 // echo"---sql----".$this->db->last_query()."----<br>";
            if ($n > 0) {
                return $l->row()->$field;
            }
        }
    }
}
?>