<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Encrypt_script_address extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->helper(array('form', 'url','encryption_val'));
	}
	
	public function index()
	{
		$this->db->select("*");
		$this->db->from("igain_customer_address");
		$this->db->where("1=1");
		$res = $this->db->get();

		$data = $res->result_array();
		
		foreach($data as $row)
		{
			echo $row["Address"]. PHP_EOL;
			if($row["Address"] != "" || $row["Address"] != NULL)
			{
				$newData["Address"] = App_string_encrypt($row["Address"]);
			}
			if($row["Phone_no"] != "" || $row["Phone_no"] != NULL)
			{
				$newData["Phone_no"] = App_string_encrypt($row["Phone_no"]);
			}
			
			
			$this->db->where(array("Address_id"=>$row["Address_id"],"Company_id"=>$row["Company_id"]));
			$this->db->update("igain_customer_address",$newData);
		}
	}
}
?>