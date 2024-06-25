<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Api_model extends CI_Model 
{
	public function get_all_products($Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}	
	public function get_products_details($Company_merchandise_item_id)
	{
		$this->db->where(array('Company_merchandise_item_id' => $Company_merchandise_item_id));
		$this->db->from('igain_company_merchandise_catalogue');
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	
	public function insert_transaction($Cust_order)
	{	
		$this->db->insert('igain_transaction', $Cust_order);	
		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	
	public function insert_transaction_child($data)
	{
		$this->db->insert('igain_transaction_child2', $data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function insert_shipping_details($shipping_details)
	{	
		$this->db->insert('igain_transaction_child3', $shipping_details);	
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
	}
	
	public function get_orders($Enrollment_id,$Company_id)
	{
		/* $this->db->select('serial_id,date,Order_total,Order_id,Order_status');
		$this->db->where(array('Enrollment_id' => $Enrollment_id));
		$this->db->from('orders');
		$this->db->order_by('serial_id','DESC'); */
		
		$this->db->select('Trans_id,Trans_date,Purchase_amount,Manual_billno,Delivery_status');
		$this->db->where(array('Enrollement_id' => $Enrollment_id, 'Company_id' => $Company_id, 'Trans_type' => '8'));
		$this->db->from('igain_transaction');
		$this->db->order_by('Trans_id','DESC');
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_order_details($Trans_id)
	{
		$this->db->select('TC3.Cust_name,TC3.Cust_address,TC3.Cust_city,TC3.Cust_zip,TC3.Cust_state,TC3.Cust_country,TC3.Cust_phnno,TC3.Cust_email, T.Manual_billno,T.Trans_date,T.Delivery_status,T.Shipping_cost,T.Purchase_amount');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_transaction_child3 as TC3', 'T.Trans_id = TC3.Transaction_id');
		$this->db->where(array('Trans_id' => $Trans_id));
		
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_order_details2($serial_id)
	{		
		$this->db->select('P.Company_merchandise_item_id,P.Merchandize_item_name,P.Thumbnail_image1,TC2.Quantity,TC2.Unit_price');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_transaction_child2 as TC2', 'T.Trans_id = TC2.Transaction_id');
		$this->db->join('igain_company_merchandise_catalogue as P', 'P.Company_merchandise_item_id = TC2.Product_id');		
		$this->db->where(array('T.Trans_id' => $serial_id));
		
		/* $this->db->select('P.serial,P.name,P.picture,OD.quantity,OD.price');
		$this->db->from('orders as O');
		$this->db->join('order_detail as OD', 'O.serial_id = OD.serial_id');
		$this->db->join('products as P', 'P.serial = OD.productid');		
		$this->db->where(array('O.serial_id' => $serial_id)); */
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function update_order_id($Order_id)
	{
		$data = array(
		   'Order_id' => $Order_id
		);
		$this->db->where('serial_id', $Order_id);
		$this->db->update('orders', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	
	public function fetch_product_group()
	{
		$this->db->select('Product_group_id,Product_group_name');
		$this->db->from('igain_product_group_master');
		$this->db->limit(10);
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function fetch_product_brands($Company_id,$Product_group_id)
	{
		$this->db->select('Product_brand_id,Product_brand_name');
		$this->db->where(array('Company_id' => $Company_id, 'Product_group_id' => $Product_group_id));
		$this->db->from('igain_product_brand_master');
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function fetch_product_colors($Product_group_id)
	{
		$this->db->distinct();
		$this->db->select('Color');
		$this->db->from('products');
		$this->db->where(array('Product_group' => $Product_group_id));
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_electronic_products($Limit_start,$Limit_end,$Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Product_group_id' => '1', 'Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$this->db->limit($Limit_end,$Limit_start);
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_books_products($Limit_start,$Limit_end,$Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Product_group_id' => '4', 'Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$this->db->limit($Limit_end,$Limit_start);
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function get_cloths_products($Limit_start,$Limit_end,$Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Product_group_id' => '2', 'Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$this->db->limit($Limit_end,$Limit_start);
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function fetch_shopping_category_products($Product_group,$Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Product_group_id' => $Product_group, 'Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function fetch_product_group_details($Product_group)
	{
		$this->db->select('Product_group_id,Product_group_name');
		$this->db->where(array('Product_group_id' => $Product_group));
		$this->db->from('igain_product_group_master');
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	
	public function fetch_max_price($Product_group_id,$Company_id)
	{
		$this->db->select_max('Billing_price');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Product_group_id' => $Product_group_id, 'Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	
	public function fetch_min_price($Product_group_id,$Company_id)
	{
		$this->db->select_min('Billing_price');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Product_group_id' => $Product_group_id, 'Company_id' => $Company_id, 'Ecommerce_flag' => '1'));
		$sql = $this->db->get();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	
	public function filter_result($Where,$Where_in,$Where_in2,$PriceFrom,$PriceTo,$Sort)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where($Where);
		
		if($Where_in != NULL || $Where_in != "")
		{
			$this->db->where_in('Product_brand_id', $Where_in);
		}
		
		/* if($Where_in2 != NULL || $Where_in2 != "")
		{
			$this->db->where_in('Color', $Where_in2);
		} */
		
		$this->db->where("Billing_price Between '$PriceFrom'  AND '$PriceTo'");
		
		if($Sort == 1)
		{
			$this->db->order_by('Company_merchandise_item_id', 'DESC');
		}
		if($Sort == 2)
		{
			$this->db->order_by('Billing_price', 'ASC');
		}
		if($Sort == 3)
		{
			$this->db->order_by('Billing_price', 'DESC');
		}		
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function update_transaction($up,$cid,$company_id)
	{
		//$this->db->set('point_balance'); 
		$this->db->where('Card_id', $cid, 'Company_id', $company_id); 
		$this->db->update('igain_enrollment_master', $up); 
		return true;
	}
	
	public function update_billno($Seller_id,$Bill_no)
	{
		$data = array(
			'Purchase_Bill_no' => $Bill_no
		);
		$this->db->where(array('Enrollement_id' => $Seller_id));
		$this->db->update("igain_enrollment_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function update_loyalty_transaction_child($Company_id,$Todays_date,$seller_id,$Customer_enroll_id,$insert_transaction_id)
	{
		$this->db->where(array('Enrollement_id' =>$Customer_enroll_id, 'Seller' =>$seller_id, 'Transaction_date'=> $Todays_date,'Company_id' => $Company_id));
		$this->db->update('igain_transaction_child',array('Transaction_id' => $insert_transaction_id));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function purchase_transaction($data)
	{
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
	
	public function Insert_online_purchase_transaction($data)
	{
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
		
	public function insert_loyalty_transaction_child($child_data)
	{
		$this->db->insert('igain_transaction_child', $child_data);	
			
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_discount($transaction_amt,$discount)
	{
		return ($transaction_amt/100) * $discount;
	}
	
	public function get_loyalty_program_details($Company_id,$seller_id,$Loyalty_names,$Todays_date)
	{
			$this->db->Select("*");
			$this->db->from("igain_loyalty_master");
			$this->db->where_in('Loyalty_name',$Loyalty_names);
			$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			$this->db->where(array('Seller' => $seller_id,'Active_flag' => 1,'Company_id' => $Company_id));
			$this->db->order_by('Loyalty_at_value');
		
			$edit_sql = $this->db->get();
			//echo $this->db->last_query();
			if($edit_sql->num_rows() > 0)
			{
				return $edit_sql->result_array();
			}
			else
			{
				return false;
			}
	}
	
	function get_tierbased_loyalty($Company_id,$Logged_user_id,$TierID)
	{
		//$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
		$Todays_date=date("Y-m-d");
		$this->db->select('distinct(Loyalty_name)');
		$this->db->from('igain_loyalty_master');
		$this->db->where(array('Company_id' => $Company_id,'Seller' => $Logged_user_id, 'Active_flag' => 1, "Tier_id IN ('0','".$TierID."') "));
		 $this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
		$query444 = $this->db->get();
			
		// echo $this->db->last_query();

		if($query444 -> num_rows() > 0)
		{
			return $query444->result_array();
		}
		else
		{
			return false;
		}
	}
		
	public function Get_Seller($seller_flag,$Company_id)
	{
		  $this->db->select('Enrollement_id,First_name,Last_name,Purchase_Bill_no,Seller_Redemptionratio');
		  $this->db->from('igain_enrollment_master');
		  $this->db->where(array('Super_seller' => $seller_flag, 'Company_id' => $Company_id));
		  $query11 = $this->db->get();
		 
			//echo $this->db->last_query();

		 if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
	}
	
	public function Get_merchandize_item($item_id,$Company_id)
	{
		  $this->db->select('Company_merchandize_item_code,Merchandize_item_name,');
		  $this->db->from('igain_company_merchandise_catalogue');
		  $this->db->where(array('Company_merchandise_item_id' => $item_id, 'Company_id' => $Company_id));
		  $query11 = $this->db->get();
		 
			//echo $this->db->last_query();

		 if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
	}
	
	function Get_loyalty_details_for_online_purchase($Loyalty_id)
	{
		//$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
		
		$this->db->select('Loyalty_at_transaction,discount,Loyalty_name');
		$this->db->from('igain_loyalty_master');
		$this->db->where(array('Loyalty_id' => $Loyalty_id));
		$query444 = $this->db->get();
			
		// echo $this->db->last_query();

		if($query444 -> num_rows() > 0)
		{
			return $query444->result_array();
		}
		else
		{
			return false;
		}
	}
	function Get_order($bill_no)
	{
		//$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
		
		$this->db->select('Item_code,Quantity,Purchase_amount,Voucher_no,Voucher_status');
		$this->db->from('igain_transaction');
		$this->db->where(array('Bill_no' => $bill_no));
		$query555 = $this->db->get();
			
		// echo $this->db->last_query();

		if($query555 -> num_rows() > 0)
		{
			return $query555->result_array();
		}
		else
		{
			return false;
		}
	}
	public function check_company_key_valid($Company_id,$companykey)
	{		
		$query =  $this->db->select('Company_key')
			  ->from('igain_company_master')
			  ->where(array('Company_id' => $Company_id));
			  $query = $this->db->get();
			  
			  if($query -> num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
			//return $query->num_rows();
	}
	function get_dial_code1($Country_id)
	{
	$query = "select Dial_code from igain_currency_master where Country_id='".$Country_id."'";

			$sql = $this->db->query($query);
			foreach ($sql->result() as $row)
			{
				$dial_code = $row->Dial_code;
			}
	return 	$dial_code;	
	}
	 function get_dial_code($Country_id)
	 {
		$query =  $this->db->select('*')
				   ->from('igain_currency_master')
				   ->where(array('Country_id' => $Country_id))->get();
				   if($query->num_rows() > 0)
				   {
						return $query->row();
				   }
				   else
				   {
						return false;
				   }
		
			
	 }
	public function get_pos($cid,$compId,$phnumber)
		{	
			//$this->db->select('Tier_id,Enrollement_id,Card_id,First_name,Last_name,Current_balance');
			$this->db->select('Enrollement_id,Card_id,First_name,Last_name,Current_balance,Current_address,State,City,Zipcode,User_email_id,Phone_no');
			$this->db->from('igain_enrollment_master as a');
			//$this->db->where(array('a.Card_id'=>$cid,'a.User_id' =>1, 'a.Company_id'=>$compId));
			$where = '(a.Card_id = "'.$cid.'" OR a.Phone_no = "'.$phnumber.'")';
			$this->db->where(array('Company_id' => $compId,'User_id' => '1'));
			
			$this->db->where($where);	
			
			$query14 = $this->db->get();
			
			if($query14->num_rows() > 0)
			{			
				foreach ($query14->result() as $row)
				{
					$full_name = $row->First_name.' '.$row->Last_name;
					
					$result[] = array("Error_flag" => 0, "card_id" => $row->Card_id, "Member_name" => $full_name, "Current_balance" => $row->Current_balance, "Current_address" => $row->Current_address, "State" => $row->State, "City" => $row->City, "Zipcode" => $row->Zipcode, "User_email_id" => $row->User_email_id, "Phone_no" => $row->Phone_no);
				}
				return json_encode($result);
			}
			else
			{
				return 0;
			}
		}
	function Fetch_Company_Details($Company)
	{
		 $this->db->select('*');
		$this->db->from('igain_company_master');
		$this->db->where(array('Activated' => '1','Company_id' => $Company));
		// echo $this->db->last_query();
		$sql = $this->db->get();	
		
		
		
		$company_result = $sql->result_array();		
		if($sql->num_rows() > 0)
		{
			return $company_result;
		}
		else
		{
			return 0;
		}
		
	}
	function get_enrollment_details($membership_id,$phnumber,$Company_id)
	{
		$this->db->select("*,(Current_balance-Blocked_points) AS Total_balance");
		$this->db->from('igain_enrollment_master');
		// $this->db->where(array('Card_id' => $Enrollement_id, 'Company_id' => $Company_id, 'User_id' => '1'));
		$where = '(Card_id = "'.$membership_id.'" OR Phone_no = "'.$phnumber.'")';
		$this->db->where(array('Company_id' => $Company_id,'User_id' => '1'));
		
		$this->db->where($where);
		$sql = $this->db->get();
		
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
}
?>