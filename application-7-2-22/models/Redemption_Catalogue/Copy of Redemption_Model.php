<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redemption_Model extends CI_Model 
{
	public function get_all_items($limit,$start,$Company_id,$Merchandize_category_id,$Sort_by)
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1));
		}
		if($Sort_by==1)//Low to High
		{
			$this->db->order_by('Billing_price_in_points','asc');
		}
		elseif($Sort_by==2)//High to Low
		{
			$this->db->order_by('Billing_price_in_points','desc');
		}
		elseif($Sort_by==3)//Low to High
		{
			$this->db->order_by('Company_merchandise_item_id','desc');
		}
		else //Default
		{
			$this->db->order_by('Company_merchandise_item_id','asc');
		}
		
		$this->db->limit($limit,$start);
		$sql = $this->db->get();
		//echo $this->db->last_query();DIE;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	public function get_all_items_branches($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('A.Branch_code,B.Branch_name,A.Merchandize_item_code');
		$this->db->from('igain_merchandize_item_child as A');
		$this->db->join('igain_branch_master as B','A.Branch_code=B.Branch_code AND A.Company_id=B.Company_id');
		$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_item_code '=>$Company_merchandize_item_code));
		$sql = $this->db->get();
		//echo $this->db->last_query();//DIE;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	function Get_Merchandize_Items_Count($Company_id)
	{
		$Todays_date=date("Y-m-d");
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'show_item'=>1,'Company_id'=>$Company_id,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date));
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	
	function get_total_redeeem_points($enroll)
	{
		$this->db->select('SUM(Points) AS Total_points,COUNT( A.Item_code ) as Quantity');
		$this->db->from('igain_temp_cart as A');
		// $this->db->join('igain_company_merchandise_catalogue as B','A.Item_code=B.Company_merchandize_item_code AND A.Company_id=B.Company_id');
		// $this->db->join('igain_branch_master as C','A.Branch=C.Branch_code AND A.Company_id=C.Company_id');
		// $this->db->group_by("A.Item_code");
		// $this->db->group_by("A.Branch");
		// $this->db->where(array('A.Enrollment_id'=>$enroll,'B.Active_flag'=>1));
		$this->db->where(array('A.Enrollment_id'=>$enroll));
		$sql=$this->db->get();
		// echo $this->db->last_query();die;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	public function insert_item_catalogue($data)
	{
		$this->db->insert('igain_temp_cart',$data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	
	public function delete_item_catalogue($Item_code,$Enrollment_id,$Company_id,$Branch)
	{
		$this->db->delete('igain_temp_cart',array('Item_code'=>$Item_code,'Enrollment_id'=>$Enrollment_id,'Company_id'=>$Company_id));
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
			
	}	
	function Get_Merchandize_Category($Company_id)
	{
		$this->db->select('A.Merchandize_category_id,A.Merchandize_category_name');
		$this->db->from('igain_merchandize_category AS A');
		$this->db->join('igain_company_merchandise_catalogue as C','A.Merchandize_category_id=C.Merchandize_category_id');
		$this->db->where(array('A.Active_flag'=>1,'A.Company_id'=>$Company_id));
		$this->db->group_by("A.Merchandize_category_id");
		$sql=$this->db->get();
		if($sql->num_rows()>0)
		{
			foreach ($sql->result() as $row)
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
	function Get_Merchandize_Item_details($Company_merchandise_item_id)
	{
		$this->db->select('Company_merchandize_item_code,Merchandize_item_name,Merchandise_item_description,Billing_price_in_points,Item_image1,Item_image2,Item_image3,Item_image4,Thumbnail_image1,Thumbnail_image2,Thumbnail_image3,Thumbnail_image4,Company_id,Delivery_method,Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'Company_merchandise_item_id'=>$Company_merchandise_item_id));
		$sql=$this->db->get();
		
		if($sql->num_rows()>0)
		{
			foreach ($sql->result() as $row)
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
	public function Insert_Redeem_Items_at_Transaction($data)
	{
		$this->db->insert('igain_transaction',$data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	public function Update_Customer_Balance($Current_balance,$Enrollement_id)
	{
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->update('igain_enrollment_master',array('Current_balance'=>$Current_balance));
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return 0;
		}	
	}
	
	function Get_Merchandize_Item_details_fromcode($Company_merchandize_item_code,$Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1, 'Company_merchandize_item_code'=>$Company_merchandize_item_code, 'Company_id' => $Company_id));
		$sql=$this->db->get();
		
		if($sql->num_rows()>0)
		{
            return $sql->result();
		}
		else
		{
			return false;
		}	
		
	}
	
	function get_redeem_bill_info($Bill_no,$Company_id)
	{
		$this->db->select('A.Merchandize_item_name,A.Billing_price_in_points');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B', 'A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => '10', 'B.Bill_no' => $Bill_no, 'B.Company_id' => $Company_id));
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	
/**************************AMIT END*******************************************************************************************/	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function get_products_details($product_id)
	{
		$this->db->where(array('serial' => $product_id));
		$this->db->from('products');
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
	
	public function insert_customer()
	{
		$data['date'] = date('Y-m-d');
		$data["Enrollment_id"] = $this->input->post('Enrollment_id');
		$data["Cust_name"] = $this->input->post('firstname')." ".$this->input->post('lastname');
		$data["Cust_address"] = $this->input->post('address');
		$data["Cust_city"] = $this->input->post('city');
		$data["Cust_zip"] = $this->input->post('zip');
		$data["Cust_state"] = $this->input->post('state');
		$data["Cust_country"] = $this->input->post('country');
		$data["Cust_phnno"] = $this->input->post('phone');
		$data["Cust_email"] = $this->input->post('email');
		$data["Order_total"] = $this->input->post('Order_total');
		// var_dump($data);die;
		$this->db->insert('orders', $data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	
	public function insert_order_detail($data)
	{
		$this->db->insert('order_detail', $data);
	}
}
?>