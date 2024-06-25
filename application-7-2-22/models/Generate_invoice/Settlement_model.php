<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settlement_model extends CI_Model {  
	
	
	public function generated_seller_bill_count($Company_id,$Seller_id,$from_Date,$till_Date)
	{
		/* $query = $this->db->where("Column_Company_id",$Company_id);
		return $this->db->count_all("igain_data_upload_map_tbl"); */
		$this->db->where(array('Company_id' => $Company_id,'Seller_id' => $Seller_id,'Merchant_publisher_type' => 52 ,'Bill_flag' =>1,'Settlement_flag' =>0));
		$this->db->where('Creation_date BETWEEN "'.$from_Date.'" AND  "'.$till_Date.'" ');
		$query = $this->db->from("igain_merchant_billing");
		$query = $this->db->select("*");
		$query = $this->db->get();
		// echo"--generated_seller_bill_count--".$this->db->last_query()."---<br>";
		return $query->num_rows();
	}
	public function generated_seller_debit_bill_count($Company_id,$Seller_id,$from_Date,$till_Date)
	{
		/* $query = $this->db->where("Column_Company_id",$Company_id);
		return $this->db->count_all("igain_data_upload_map_tbl"); */
		$this->db->where(array('Company_id' => $Company_id,'Seller_id' => $Seller_id,'Merchant_publisher_type' => 54,'Bill_flag' =>1,'Settlement_flag' =>0));
		$this->db->where('Creation_date BETWEEN "'.$from_Date.'" AND  "'.$till_Date.'" ');
		$query = $this->db->from("igain_merchant_billing");
		$query = $this->db->select("*");
		$query = $this->db->get();
		// echo"--generated_seller_bill_count--".$this->db->last_query()."---<br>";
		return $query->num_rows();
	}
	public function get_generated_seller_bill_details($limit,$start,$Company_id,$Seller_id,$from_Date,$till_Date)
	{
		$this->db->limit($limit,$start);
		$this->db->select('*');
		$this->db->from('igain_merchant_billing AS B');
		$this->db->join('igain_enrollment_master as E', 'E.Enrollement_id = B.Seller_id');
		// $this->db->where(array('B.Company_id' => $Company_id,'B.Merchant_publisher_type' => 52 ,'B.Bill_flag' =>1));
		$this->db->where(array('B.Company_id' => $Company_id,'B.Seller_id' => $Seller_id,'B.Merchant_publisher_type' => 52 ,'B.Bill_flag' =>1,'B.Settlement_flag' =>0));
		$this->db->where('B.Creation_date BETWEEN "'.$from_Date.'" AND  "'.$till_Date.'" ');
		$this->db->order_by('B.Creation_date','DESC');
		$invoice_sql = $this->db->get();
		// echo"--get_generated_seller_bill_details--".$this->db->last_query()."---<br>";
		if($invoice_sql->num_rows() > 0)		{
			// return $edit_sql->result_array();		
			foreach ($invoice_sql->result() as $row)
			{				
				$data[] = $row;
            }
            return $data;
		}
		else
		{
			return false;
		}			
	}
	public function get_generated_seller_debit_bill_details($limit,$start,$Company_id,$Seller_id,$from_Date,$till_Date)
	{
		$this->db->limit($limit,$start);
		$this->db->select('*');
		$this->db->from('igain_merchant_billing AS B');
		$this->db->join('igain_enrollment_master as E', 'E.Enrollement_id = B.Seller_id');
		// $this->db->where(array('B.Company_id' => $Company_id,'B.Merchant_publisher_type' => 52 ,'B.Bill_flag' =>1));
		$this->db->where(array('B.Company_id' => $Company_id,'B.Seller_id' => $Seller_id,'B.Merchant_publisher_type' => 54 ,'B.Bill_flag' =>1,'B.Settlement_flag' =>0));
		$this->db->where('B.Creation_date BETWEEN "'.$from_Date.'" AND  "'.$till_Date.'" ');
		$this->db->order_by('B.Creation_date','DESC');
		$invoice_sql = $this->db->get();
		// echo"--get_generated_seller_bill_details--".$this->db->last_query()."---<br>";
		if($invoice_sql->num_rows() > 0)		{
			// return $edit_sql->result_array();		
			foreach ($invoice_sql->result() as $row)
			{				
				$data[] = $row;
            }
            return $data;
		}
		else
		{
			return false;
		}			
	}	
	public function Get_generated_bill_detilas($Company_id,$Bill_id,$Seller_id,$Bill_no)
	{		
		$this->db->select('*');
		$this->db->from('igain_merchant_billing');
		$this->db->where(array('Company_id' => $Company_id,'Bill_id' => $Bill_id,'Bill_no' => $Bill_no,'Seller_id' =>$Seller_id));		
		$invoice_sql = $this->db->get();
		//echo"--Get_generated_bill_detilas--".$this->db->last_query()."---<br>";
		if($invoice_sql->num_rows() > 0){
			
			return $invoice_sql->row();	
		}
		else
		{
			return false;
		}
		// echo"--Update_total_generated_bill--".$this->db->last_query()."---<br>";
				
	}
	public function Check_publisher_transaction_details($Company_id,$from_date,$till_Date,$Seller_id,$Bill_no)
	{		
	
		
		$this->db->select('*');
		$this->db->from('igain_transaction');
		$this->db->where("Trans_date BETWEEN '".$from_date."' AND '".$till_Date."'");
		$this->db->where(array('Company_id' => $Company_id,'Trans_type'=>25,'Voucher_status'=>45,'To_Beneficiary_company_id' =>$Seller_id,'Settlement_flag' =>0));		
		$invoice_sql = $this->db->get();
		// echo"--Check_publisher_transaction_details--".$this->db->last_query()."---<br>";
		
		if($invoice_sql->num_rows() > 0)		{
			// return $edit_sql->result_array();		
			foreach ($invoice_sql->result() as $row)
			{				
				$data[] = $row;
            }
            return $data;
		}
		else
		{
			return false;
		}
				
	}
	public function Count_publisher_bill($Company_id,$Bill_no,$Seller_id)
	{		
		$this->db->select('*');
		$this->db->from('igain_merchant_billing');
		$this->db->where(array('Company_id' => $Company_id,'Bill_no' => $Bill_no,'Seller_id' =>$Seller_id,'Merchant_publisher_type' =>53));		
		$invoice_sql = $this->db->get();
		// echo"--Count_publisher_bill--".$this->db->last_query()."---<br>";
		
		return $invoice_sql->num_rows();
				
	}
	public function Get_publisher_bill_detilas($Company_id,$Bill_no,$Seller_id)
	{		
		$this->db->select('*');
		$this->db->from('igain_merchant_billing');
		$this->db->where(array('Company_id' => $Company_id,'Bill_no' => $Bill_no,'Seller_id' =>$Seller_id,'Merchant_publisher_type' =>53));		
		$invoice_sql = $this->db->get();
		//echo"--Get_publisher_bill_detilas--".$this->db->last_query()."---<br>";
		if($invoice_sql->num_rows() > 0){
			
			return $invoice_sql->row();	
		}
		else
		{
			return false;
		}
		// echo"--Update_total_generated_bill--".$this->db->last_query()."---<br>";
				
	}
	public function Update_transaction_bill($Company_id,$Seller_id,$Bill_no,$Logged_user_enrollid,$Today)
	{		
		$this->db->where(array('Company_id' => $Company_id,'Seller_Billing_Bill_no' => $Bill_no,'Seller' =>$Seller_id));
		$this->db->update('igain_transaction', array('Settlement_flag'=>1,'Update_User_id'=>$Logged_user_enrollid,'Update_date'=>$Today));	
			
			// 'Trans_type'=>2,
		// echo"--Update_transaction_bill--".$this->db->last_query()."---<br>";
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
	}
	public function Update_debit_transaction_bill($Company_id,$Seller_id,$Bill_no,$Logged_user_enrollid,$Today)
	{		
		$this->db->where(array('Company_id' => $Company_id,'Seller_Billing_Bill_no' => $Bill_no,'Seller' =>$Seller_id));
		$this->db->update('igain_transaction', array('Settlement_flag'=>1,'Update_User_id'=>$Logged_user_enrollid,'Update_date'=>$Today));	
			
			// 'Trans_type'=>26,
		// echo"--Update_transaction_bill--".$this->db->last_query()."---<br>";
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
	}
	
	public function Update_total_generated_bill($Company_id,$Bill_id,$Seller_id,$Bill_no,$Paid_amount_new,$Logged_user_enrollid,$Today)
	{		
		$this->db->where(array('Company_id' => $Company_id,'Bill_id' => $Bill_id,'Bill_no' => $Bill_no,'Seller_id' =>$Seller_id));
		$this->db->update('igain_merchant_billing', array('Settlement_flag'=>1,'Settlement_amount'=>$Paid_amount_new,'Update_user_id'=>$Logged_user_enrollid,'Update_date'=>$Today));	
		
		//echo"--Update_total_generated_bill--".$this->db->last_query()."---<br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
	}	
	
	public function Update_partial_generated_bill($Company_id,$Bill_id,$Seller_id,$Bill_no,$Paid_amount_new,$Logged_user_enrollid,$Today)
	{		
		$this->db->where(array('Company_id' => $Company_id,'Bill_id' => $Bill_id,'Bill_no' => $Bill_no,'Seller_id' =>$Seller_id));
		$this->db->update('igain_merchant_billing', array('Settlement_amount'=>$Paid_amount_new,'Update_user_id'=>$Logged_user_enrollid,'Update_date'=>$Today));	
		
		// echo"--Update_partial_generated_bill--".$this->db->last_query()."---<br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
	}
	public function check_bill_no($Bill_no,$publisher,$Company_id)
	{		
		$this->db->select('*');
		$this->db->from('igain_merchant_billing');
		$this->db->where(array('Company_id' => $Company_id,'Seller_id' => $publisher,'Bill_no' => $Bill_no,'Merchant_publisher_type' => 53));		
		$bill_sql = $this->db->get();
		//echo"--check_bill_no--".$this->db->last_query()."---<br>";
		if($bill_sql->num_rows() > 0){
			
			return $bill_sql->row();	
		}
		else
		{
			return false;
		}
		
	}
	public function get_bill_details($Bill_no,$publisher,$Company_id)
	{		
		$this->db->select('*');
		$this->db->from('igain_billing_payment_method AS PM');
		$this->db->join('igain_payment_type_master as PT', 'PT.Payment_type_id = PM.Payment_type');
		$this->db->where(array('PM.Company_id' => $Company_id,'PM.Seller_id' => $publisher,'PM.Bill_no' => $Bill_no,'PM.Merchant_publisher_type' => 53));		
		$bill_sql = $this->db->get();
		//echo"--get_bill_details--".$this->db->last_query()."---<br>";
		if($bill_sql->num_rows() > 0) {
			// return $edit_sql->result_array();		
			foreach ($bill_sql->result() as $row)
			{				
				$data[] = $row;
            }
            return $data;
		}
		else
		{
			return false;
		}	
		
	}
	
	public function Insert_publisher_bill_payment($insert_bill_data)
	{
		$this->db->insert("igain_merchant_billing",$insert_bill_data);
		echo"--Insert_publisher_bill_payment--".$this->db->last_query()."---<br>";		
		if($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else{
			
			return false;
			
		}
	}
	
	public function Update_transaction_publisher_bill($Company_id,$Seller_id,$Bill_no,$Logged_user_enrollid,$Today,$from_date,$till_Date)
	{		
		$this->db->where(array('Company_id' => $Company_id,'Trans_type'=>25,'Settlement_flag'=>0,'Voucher_status'=>45,'To_Beneficiary_company_id' =>$Seller_id));
		$this->db->where("Trans_date BETWEEN '".$from_date."' AND '".$till_Date."'");
		$this->db->update('igain_transaction', array('Settlement_flag'=>1,'Billing_Bill_flag'=>1,'Seller_Billing_Bill_no' => $Bill_no,'Update_User_id'=>$Logged_user_enrollid,'Update_date'=>$Today));			
		//echo"--Update_transaction_publisher_bill--".$this->db->last_query()."---<br>";		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
	}
	public function Insert_payment_billing_method($PaymentMethod)
	{
		$this->db->insert("igain_billing_payment_method",$PaymentMethod);
		//echo"--Insert_payment_billing_method--".$this->db->last_query()."---<br>";		
		if($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else{
			
			return false;
			
		}
	}
	public function Get_publisher_details($Company_id,$publisher)
	{		
		$this->db->select('*');
		$this->db->from('igain_register_beneficiary_company');
		
		$this->db->where(array('Register_beneficiary_id' => $publisher,'Activate_flag' =>1));		
		$pub_sql = $this->db->get();
		// echo"--Get_publisher_details--".$this->db->last_query()."---<br>";
		if($pub_sql->num_rows() > 0) {
				
			return $pub_sql->row();	
		}
		else
		{
			return false;
		}
	}
}
?>