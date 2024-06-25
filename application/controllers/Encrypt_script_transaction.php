<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Encrypt_script_transaction extends CI_Controller
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
		$this->db->from("igain_transaction_child3");
		$this->db->where("1=1");
		$res = $this->db->get();

		$data = $res->result_array();
		
		foreach($data as $row)
		{
			echo $row["Cust_address"]. PHP_EOL;
			if($row["Cust_address"] != "" || $row["Cust_address"] != NULL)
			{
				$newData["Cust_address"] = App_string_encrypt($row["Cust_address"]);
			}
			if($row["Cust_phnno"] != "" || $row["Cust_phnno"] != NULL)
			{
				$newData["Cust_phnno"] = App_string_encrypt($row["Cust_phnno"]);
			}
			if($row["Cust_email"] != "" || $row["Cust_email"] != NULL)
			{
				$newData["Cust_email"] = App_string_encrypt($row["Cust_email"]);
			}
			
			
			$this->db->where(array("Transaction_child_id3"=>$row["Transaction_child_id3"],"Company_id"=>$row["Company_id"]));
			$this->db->update("igain_transaction_child3",$newData);
		}
	}
}
?>