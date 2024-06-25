<?php  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Encrypt_script extends CI_Controller
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
		$this->db->from("igain_enrollment_master");
		$this->db->where("1=1");
		$res = $this->db->get();

		$data = $res->result_array();
		
		foreach($data as $row)
		{
			echo $row["User_email_id"]. PHP_EOL;
			if($row["Current_address"] != "" || $row["Current_address"] != NULL)
			{
				$newData["Current_address"] = App_string_encrypt($row["Current_address"]);
			}
			if($row["Phone_no"] != "" || $row["Phone_no"] != NULL)
			{
				$newData["Phone_no"] = App_string_encrypt($row["Phone_no"]);
			}
			if($row["User_email_id"] != "" || $row["User_email_id"] != NULL)
			{
				$newData["User_email_id"] = App_string_encrypt($row["User_email_id"]);
			}
			if($row["User_pwd"] != "" || $row["User_pwd"] != NULL)
			{
				$newData["User_pwd"] = App_string_encrypt($row["User_pwd"]);
			}
			
			$this->db->where(array("Enrollement_id"=>$row["Enrollement_id"],"Company_id"=>$row["Company_id"]));
			$this->db->update("igain_enrollment_master",$newData);
		}
	}
}
?>