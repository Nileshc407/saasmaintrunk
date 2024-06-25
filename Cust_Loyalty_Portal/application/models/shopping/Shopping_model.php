<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shopping_model extends CI_Model 
{
    public function get_all_items($limit,$start,$Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender)
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
		}
		if($Sort_by_merchant!='0')//ALL merchants
		{
			$this->db->where(array('A.Seller_id'=>$Sort_by_merchant));
		}
		if($Sort_by_brand!='0')//sort by brand
		{
			$this->db->where(array('A.Item_Brand'=>$Sort_by_brand));
		}
		if($Sort_by_gender!='0')//sort by brand
		{
			$this->db->where(array('A.Gender_flag'=>$Sort_by_gender));
		}
		if($Sort_by==1)//Low to High
		{
			$this->db->order_by('Billing_price','asc');
		}
		elseif($Sort_by==2)//High to Low
		{
			$this->db->order_by('Billing_price','desc');
		}
		elseif($Sort_by==3)//Recently Added
		{
			$this->db->order_by('Company_merchandise_item_id','desc');
		}
		else //Default
		{
			$this->db->order_by('Company_merchandise_item_id','desc');
		}
		if($limit!=NULL || $start!=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$sql = $this->db->get();
		// echo $this->db->last_query();
		// die;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
        
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
	public function get_orders($limit,$page,$Enrollment_id,$Company_id)
	{
		/* $this->db->select('serial_id,date,Order_total,Order_id,Order_status');
		$this->db->where(array('Enrollment_id' => $Enrollment_id));
		$this->db->from('orders');
		$this->db->order_by('serial_id','DESC'); */
		
		$this->db->select('Trans_id,Trans_date,Purchase_amount,Voucher_no,Voucher_status,Bill_no,Update_date,Item_code,Item_size,Quantity');
		$this->db->where(array('Enrollement_id' => $Enrollment_id, 'Company_id' => $Company_id, 'Trans_type' => '12'));
		$this->db->from('igain_transaction');
		if($limit!=NULL && $page!=NULL)
		{
			$this->db->limit($limit,$page);
		}
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
		$this->db->select('T.*,TC3.Cust_name,TC3.Cust_address,TC3.Cust_city,TC3.Cust_zip,TC3.Cust_state,TC3.Cust_country,TC3.Cust_phnno,TC3.Cust_email, T.Voucher_no,T.Trans_date,T.Delivery_status,T.Shipping_cost,T.Purchase_amount,ICM.name as Country_name,ISM.name as State_name,IC.name as City_name');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_transaction_child3 as TC3', 'T.Trans_id = TC3.Transaction_id');
		$this->db->join('igain_country_master as ICM', 'TC3.Cust_country = ICM.id');
		$this->db->join('igain_state_master as ISM', 'TC3.Cust_state = ISM.id');
		$this->db->join('igain_city_master as IC', 'TC3.Cust_city = IC.id');
		$this->db->where(array('Trans_id' => $Trans_id));
		//$this->db->limit(0,1);
		
		$sql = $this->db->get();
		//echo"<br>--------get_order_details------------".$this->db->last_query()."---<br>---";//die;
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	public function get_order_details1($Trans_id,$Bill_no,$Voucher_no) 
	{
		$this->db->select('T.*,TC3.Cust_name,TC3.Cust_address,TC3.Cust_city,TC3.Cust_zip,TC3.Cust_state,TC3.Cust_country,TC3.Cust_phnno,TC3.Cust_email, T.Voucher_no,T.Trans_date,T.Delivery_status,T.Shipping_cost,T.Purchase_amount');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_transaction_child3 as TC3', 'T.Trans_id = TC3.Transaction_id');
		$this->db->where(array('Trans_id' => $Trans_id, 'Bill_no' => $Bill_no, 'Voucher_no'=> $Voucher_no));
		
		$sql = $this->db->get();
		//echo"<br>--------get_order_details1------------".$this->db->last_query()."---<br>---";//die;
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	
	function Update_online_purchase_cancel_item_points($update_enroll,$Cust_Enrollement_id,$Company_id)
	{
	
		//$this->db->set('point_balance'); 
		$this->db->where('Enrollement_id', $Cust_Enrollement_id, 'Company_id', $company_id); 
		$this->db->update('igain_enrollment_master', $update_enroll); 
		return true;
		
		/*$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Current_balance"=>$Credit_points,
		"Update_date"=>$Update_date,
		"Update_User_id"=>$Update_User_id
		);
		$this->db->where('Enrollement_id' , $Cust_Enrollement_id);
		$this->db->update("igain_enrollment_master",$data);
		// echo "<br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}*/
	}	
	public function get_order_details2($serial_id)
	{		
		$this->db->select('P.Company_merchandise_item_id,P.Merchandize_item_name,P.Thumbnail_image1,T.Quantity,T.Purchase_amount,T.Redeem_points,T.Company_id,T.Bill_no,T.Quantity,T.Voucher_no,T.Voucher_status,T.Item_size,Shipping_cost');
		$this->db->from('igain_transaction as T');
		// $this->db->join('igain_transaction_child2 as TC2', 'T.Trans_id = TC2.Transaction_id');
		$this->db->join('igain_company_merchandise_catalogue as P', 'T.Item_code = P.Company_merchandize_item_code ');		
		$this->db->where(array('T.Trans_id' => $serial_id));
		
		/* $this->db->select('P.serial,P.name,P.picture,OD.quantity,OD.price');
		$this->db->from('orders as O');
		$this->db->join('order_detail as OD', 'O.serial_id = OD.serial_id');
		$this->db->join('products as P', 'P.serial = OD.productid');		
		$this->db->where(array('O.serial_id' => $serial_id)); */
		$this->db->limit(1);
		$sql = $this->db->get();
		
		
		//echo"<br>--------get_order_details2------------".$this->db->last_query()."---<br>---";//die;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	public function Get_merchandize_item12($item_code,$Company_id)
	{
		  $this->db->select('Company_merchandize_item_code,Merchandize_item_name,Partner_id');
		  $this->db->from('igain_company_merchandise_catalogue');
		  $this->db->where(array('Company_merchandize_item_code' => $item_code, 'Company_id' => $Company_id));
		  $query11 = $this->db->get();
		 
			// echo $this->db->last_query();

		 if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
	}
	function Update_online_purchase_item($Voucher_status,$Update_User_id,$Bill_no,$Voucher_no)
	{
		$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Voucher_status"=>$Voucher_status,
		"Update_date"=>$Update_date,
		"Update_User_id"=>$Update_User_id
		);
		$this->db->where(array('Bill_no' => $Bill_no, ' Voucher_no'=> $Voucher_no));
		$this->db->update("igain_transaction",$data);
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Insert_purchase_cancel_trans($Post_data)
	{
		$this->db->insert('igain_transaction',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
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
	
	public function fetch_product_brands($Company_id)   //,$Product_group_id
	{
		$this->db->select('Product_brand_id,Product_brand_name');
		$this->db->where(array('Company_id' => $Company_id));   //, 'Product_group_id' => $Product_group_id
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
		if($Limit_start!=NULL && $Limit_end!=NULL)
		{
			$this->db->limit($Limit_end,$Limit_start);
		}
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
		// $this->db->limit($Limit_end,$Limit_start);
		if($Limit_start!=NULL && $Limit_end!=NULL)
		{
			$this->db->limit($Limit_end,$Limit_start);
		}
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
		// $this->db->limit($Limit_end,$Limit_start);
		if($Limit_start!=NULL && $Limit_end!=NULL)
		{
			$this->db->limit($Limit_end,$Limit_start);
		}
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
	
	public function fetch_max_price($Company_id)    //$Product_group_id,
	{
		$this->db->select_max('Billing_price');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id, 'Ecommerce_flag' => '1'));  //'Product_group_id' => $Product_group_id, 
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
	
	public function fetch_min_price($Company_id)    //$Product_group_id,
	{
		$this->db->select_min('Billing_price');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id, 'Ecommerce_flag' => '1'));  //'Product_group_id' => $Product_group_id, 
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
	
        /*$Todays_date=date("Y-m-d");
        $this->db->from('igain_company_merchandise_catalogue as A');
        if($Merchandize_category_id==0)//ALL
        {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1));
        }
        else
        {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1));
        }
        if($Sort_by==1)//Low to High
        {
                $this->db->order_by('Billing_price','asc');
        }
        elseif($Sort_by==2)//High to Low
        {
                $this->db->order_by('Billing_price','desc');
        }
        elseif($Sort_by==3)//Recently Added
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
        }*/
        
	public function filter_result($Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id)  //$limit,$start,
	{
            $Todays_date=date("Y-m-d");
            $this->db->from('igain_company_merchandise_catalogue as A');
            
            if($Sort_category == 0)   //ALL
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            else
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Sort_category,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            
            $this->db->where("Billing_price Between '".$PriceFrom."'  AND '".$PriceTo."'");
            
            if($Sort_by == 1)//Low to High
            {
                $this->db->order_by('Billing_price','asc');
            }
            else if($Sort_by == 2)//High to Low
            {
                $this->db->order_by('Billing_price','desc');
            }
            else if($Sort_by == 3)//Recently Added
            {
                $this->db->order_by('Company_merchandise_item_id','desc');
            }
            else //Default
            {
                $this->db->order_by('Company_merchandise_item_id','asc');
            }

            //$this->db->limit($limit,$start);
            $sql = $this->db->get();
            //echo $this->db->last_query();
            
            if($sql->num_rows() > 0)
            {			
                return $sql->result_array();
            }
            else
            {
                return 0;
            }
	}
        
    public function filter_result2($limit,$start,$Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id)
	{
            $Todays_date=date("Y-m-d");
            $this->db->from('igain_company_merchandise_catalogue as A');
            
            if($Sort_category == 0)   //ALL
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            else
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Sort_category,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=>1,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            
            $this->db->where("Billing_price Between '".$PriceFrom."'  AND '".$PriceTo."'");
            
            if($Sort_by == 1)//Low to High
            {
                $this->db->order_by('Billing_price','asc');
            }
            else if($Sort_by == 2)//High to Low
            {
                $this->db->order_by('Billing_price','desc');
            }
            else if($Sort_by == 3)//Recently Added
            {
                $this->db->order_by('Company_merchandise_item_id','desc');
            }
            else //Default
            {
                $this->db->order_by('Company_merchandise_item_id','asc');
            }
			if($limit!=NULL && $start!=NULL)
			{
				 $this->db->limit($limit,$start);
			}
           
            $sql = $this->db->get();
            //echo $this->db->last_query();
            
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

			if($edit_sql->num_rows() > 0)
			{
				return $edit_sql->result_array();
			}
			else
			{
				return false;
			}
	}
	/*public function get_loyalty_program_details($Company_id,$seller_id,$TierID,$Todays_date)
	{
			$this->db->Select("*");
			$this->db->from("igain_loyalty_master");
			// $this->db->where_in('Loyalty_name',$Loyalty_names);
			$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			// $this->db->where(array('Seller' => $seller_id,'Active_flag' => 1,'Company_id' => $Company_id));
			$this->db->where(array('Company_id' => $Company_id,'Seller' => $Seller_id, 'Active_flag' => 1, "Tier_id IN ('0','".$TierID."') "));
			// $this->db->order_by('Loyalty_at_value');
                        
			$edit_sql = $this->db->get();

			if($edit_sql->num_rows() > 0)
			{
				return $edit_sql->result_array();
			}
			else
			{
				return false;
			}
	}*/
	
	function get_tierbased_loyalty($Company_id,$Seller_id,$TierID,$Todays_date)
	{
		//$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
		$this->db->select('distinct(Loyalty_name)');
		$this->db->from('igain_loyalty_master');
		$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
		$this->db->where(array('Company_id' => $Company_id,'Seller' => $Seller_id, 'Active_flag' => 1, "Tier_id IN ('0','".$TierID."') "));
		$query444 = $this->db->get();

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
		  $this->db->select('Enrollement_id,First_name,Last_name,Purchase_Bill_no,Seller_Redemptionratio,User_email_id');
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
		  $this->db->select('*');
		  $this->db->from('igain_company_merchandise_catalogue');
		  $this->db->where(array('Company_merchandise_item_id' => $item_id, 'Company_id' => $Company_id));
		  $query11 = $this->db->get();
		 
			// echo $this->db->last_query();

		 if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
	} 
	public function Get_Seller_details($Seller_id,$Company_id)
	{
		  $this->db->select('*');
		  $this->db->from('igain_enrollment_master');
		  $this->db->where(array('Enrollement_id' => $Seller_id, 'Company_id' => $Company_id));
		  $query11 = $this->db->get();
		 
			// echo $this->db->last_query();

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
    public function update_cust_balance($up,$cid,$company_id)
	{
		//$this->db->set('point_balance'); 
		$this->db->where('Card_id', $cid, 'Company_id', $company_id); 
		$this->db->update('igain_enrollment_master', $up); 
		return true;
	}
	function Get_Merchandize_ecommerce_Items_Count($Company_id)
	{
		$Todays_date=date("Y-m-d");
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Ecommerce_flag'=>1,'Active_flag'=>1,'show_item'=>1,'Company_id'=>$Company_id,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date));
		$sql=$this->db->get();		
		return $sql->num_rows();
	}
	/**************Ravi---22-09-2017***************/
	public function Get_buy_free_item_offers_details($item_id,$Company_id)
	{
			$Todays_date=date('Y-m-d');
			$this->db->Select("*");
			$this->db->from("igain_offer_master");
			$this->db->where(array('Company_merchandise_item_id' => $item_id,'Active_flag' => 1,'Company_id' => $Company_id));
			$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			$this->db->order_by('Offer_id');                        
			$edit_sql = $this->db->get();
			// echo $this->db->last_query();
			if($edit_sql->num_rows() > 0)
			{
				return $edit_sql->result_array();
			}
			else
			{
				return false;
			}
	}
	public function get_count_item_offers($item_id,$Company_id)
	{
			$Todays_date=date('Y-m-d');
			$this->db->Select("*");
			$this->db->from("igain_offer_master");
			$this->db->where(array('Company_merchandise_item_id' => $item_id,'Active_flag' => 1,'Company_id' => $Company_id));
			$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			$this->db->order_by('Offer_id');                        
			$edit_sql = $this->db->get();
			// echo $this->db->last_query();
			return $edit_sql->num_rows();
	}
	function Get_Merchandize_Item_details($Company_merchandise_item_id)
	{
		$this->db->select('Company_merchandize_item_code,Merchandize_item_name,Merchandise_item_description,Billing_price_in_points,Item_image1,Item_image2,Item_image3,Item_image4,Thumbnail_image1,Thumbnail_image2,Thumbnail_image3,Thumbnail_image4,Company_id,Delivery_method,Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'Company_merchandise_item_id'=>$Company_merchandise_item_id));
		$sql=$this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	function Get_item_offer_details($offer_id,$Company_id)
	{
		$this->db->Select("OM.Offer_id,OM.Company_id,OM.Company_merchandise_item_id,OM.Offer_name,OM.Buy_item,OM.Free_item,OM.Free_item_id,OM.From_date,OM.Till_date,OM.Active_flag,e.Merchandize_item_name");			
			$this->db->from('igain_offer_master as OM');
			$this->db->join('igain_company_merchandise_catalogue as e','e.Company_merchandise_item_id = OM.Company_merchandise_item_id');
			// $this->db->where('OM.Company_id',$Company_id);
			$this->db->where(array('OM.Offer_id' => $offer_id,'OM.Company_id' => $Company_id));
			
			
			$edit_sql = $this->db->get();
			// echo $this->db->last_query();
			if($edit_sql->num_rows() == 1)
			{
				return $edit_sql->row();
			}
			else
			{
				return false;
			}	
		
	}
	public function get_all_offers_items($Company_merchandise_item_id,$Company_id)
	{
		$Todays_date=date('Y-m-d');
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_offer_master as B','A.Company_merchandise_item_id=B.Company_merchandise_item_id','LEFT');
		$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
		$this->db->where(array('B.Active_flag'=>1,'A.Company_id'=>$Company_id,'A.Company_merchandise_item_id '=>$Company_merchandise_item_id,'A.Ecommerce_flag '=>1));
		$sql = $this->db->get();
		// echo $this->db->last_query();
		//DIE;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	public function get_product_offers($product_id,$Company_id)
	{
		$Todays_date=date('Y-m-d');
		$this->db->select('B.Company_merchandise_item_id,A.Buy_item,A.Free_item,A.Free_item_id');
		$this->db->from('igain_offer_master as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Company_merchandise_item_id=B.Company_merchandise_item_id');
		$this->db->where(array('A.Active_flag'=>1,'A.Company_id'=>$Company_id,'A.Company_merchandise_item_id '=>$product_id));
		$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
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
	public function get_purchased_item_offers_details($Voucher_no,$Bill_no,$Company_id)
	{
			// $Todays_date=date('Y-m-d');
			$this->db->Select("CM.Company_merchandise_item_id,CM.Merchandize_item_name,CM.Company_merchandize_item_code,CM.Company_merchandize_item_code,CM.Thumbnail_image1,T.Quantity,T.Bill_no,T.Voucher_no");
			$this->db->from("igain_transaction AS T");
			$this->db->join('igain_company_merchandise_catalogue as CM','T.Item_code=CM.Company_merchandize_item_code');
			$this->db->where(array('T.Voucher_no' => $Voucher_no,'T.Bill_no' => $Bill_no,'T.Trans_type' => 20,'T.Company_id' => $Company_id));
			$this->db->order_by('Trans_id');                        
			$edit_sql = $this->db->get();
			//echo $this->db->last_query();
			return $edit_sql->result_array();
	}
	
	/**************Ravi---22-09-2017***************/
	
	public function get_parner_details($Partner_id,$Company_id) 
	{
		$this->db->select('*');
		$this->db->from('igain_partner_master');		
		$this->db->where(array('Partner_id' => $Partner_id, 'Company_id' => $Company_id, 'Active_flag'=> 1));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();die;
		if($sql->num_rows() > 0)
		{			
			return $sql->row();
		}
		else
		{
			return 0;
		}
	}
	function Get_item_details($Company_id,$Company_merchandize_item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandize_item_code'=>$Company_merchandize_item_code));
		
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() >0)
		{
			foreach ($sql51->result() as $row)
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
	//////////////////////////////////////////////////////
	public function edit_segment_id($Company_id,$Segment_code)
	{
		$this->db->select('*');
		$this->db->from('igain_segment_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Segment_code' =>$Segment_code));
		$this->db->join('igain_segment_type_master', 'igain_segment_master.Segment_type_id = igain_segment_type_master.Segment_type_id');
        $query = $this->db->get();
		// echo"---seg--SQL---".$this->db->last_query()."--<br>";		
		if($query -> num_rows() > 0)
		{
			foreach ($query->result() as $row)
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
	function Fetch_city_state_country($Company_id,$Customer_enroll_id)
	{
		$this->db->select("*,igain_state_master.name as State_name,igain_city_master.name as City_name,igain_country_master.name as Country_name");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_activated' => '1','User_id' => '1','Company_id' => $Company_id,'Enrollement_id' => $Customer_enroll_id));
		$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id');
		
		$SubsellerSql = $this->db->get();		
		if($SubsellerSql->num_rows() == 1)
		{
			return $SubsellerSql->row();
		}
		else
		{
			return 0;
		}
	}
	function get_cust_trans_summary_all($Company_id,$Enrollement_id,$start_date,$end_date,$transaction_type_id,$Tier_id,$start,$limit)
	{
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
                //IE.Enrollement_id,Transfer_points,
		$this->db->select('IE.First_name,IE.Middle_name,IE.Last_name,IT.Card_id AS Membership_ID,TT.Trans_type,SUM(Redeem_points) AS Total_Redeem,SUM(Loyalty_pts) as Total_Gained_Points,SUM(Topup_amount) as Total_Bonus_Points,SUM(Purchase_amount) as Total_Purchase_Amount,SUM(Transfer_points) AS Total_Transfer_Points,SUM(Expired_points) AS Total_Expired_points,Tier_name,IT.Enrollement_id');
		//,IE.Current_balance,Card_id2 as Transfer_to
		$this->db->from('igain_transaction as IT');
		
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->where('IT.Trans_type !=' , 10);
		$this->db->where('IT.Trans_type !=' , 9);
		$this->db->group_by('IT.Card_id');
		$this->db->group_by('IT.Trans_type');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$start_date."' AND '".$end_date."'");
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id IN('.$Enrollement_id.')');
		}
		if($Tier_id!=0)//Selected Tier 
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
			
		}
		// $this->db->limit($limit,$start);
		if($limit!=NULL && $start!=NULL)
		{
			 $this->db->limit($limit,$start);
		}
		
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				if($row->Total_Redeem==0)
				{
					$row->Total_Redeem="-";
				}
				if($row->Total_Gained_Points==0)
				{
					$row->Total_Gained_Points="-";
				}
				if($row->Total_Purchase_Amount==0)
				{
					$row->Total_Purchase_Amount="-";
				}
				if($row->Total_Transfer_Points==0)
				{
					$row->Total_Transfer_Points="-";
				}
				if($row->Total_Bonus_Points==0)
				{
					$row->Total_Bonus_Points="-";
				}
                $data[] = $row;
            }
			 return $data;
		}
		else
		{
			return false;
		}
	}
	function get_cust_trans_details($Company_id,$From_date,$To_date,$Enrollement_id,$transaction_type_id,$Tier_id,$start,$limit)
	{
	/*
		echo"From_date----".$From_date ."<br>";
		echo"To_date----".$To_date ."<br>";
		echo"Company_id----".$Company_id ."<br>";
		echo"Enrollement_id----".$Enrollement_id ."<br>";
		echo"transaction_type_id----".$transaction_type_id ."<br>";
		echo"Tier_id----".$Tier_id ."<br>";
		*/
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Bill_no,TT.Trans_type_id,Seller,TT.Trans_type,IT.Card_id as Membership_ID,IT.Company_id,Card_id2 as Transfer_to,Transfer_points,TM.Tier_name,IT.Remarks as Remarks,balance_to_pay,Item_code,Quantity,Voucher_no,Voucher_status,Expired_points');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		$this->db->where('IT.Trans_type !=' , 10);
		$this->db->where('IT.Trans_type !=' , 9);
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
		}
		if($Tier_id!=0)//Selected Tier 
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id IN('.$Enrollement_id.')');
		}
		$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
		if($limit!=NULL && $start!=NULL)
		{
			 $this->db->limit($limit,$start);
		}
		// $this->db->limit($limit,$start);
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			 foreach ($sql51->result() as $row)
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
	function Get_segment_based_customers($lv_Cust_value,$Operator,$Value,$Value1,$Value2)
	{
		$access=0;
		if($Operator=="<")
		{
			if($lv_Cust_value<$Value)
			{
				$access=1;
			}
			
		}
		if($Operator=="=")
		{
			if($lv_Cust_value==$Value)
			{
				$access=1;
			}
		}
		if($Operator=="<=")
		{
			if($lv_Cust_value<=$Value)
			{
				$access=1;
			}
		}
		
		
		if($Operator==">")
		{
			if($lv_Cust_value>$Value)
			{
				$access=1;
			}
		}
		if($Operator==">=")
		{
			if($lv_Cust_value>=$Value)
			{
				$access=1;
			}
		}
		if($Operator=="!=")
		{
			if($lv_Cust_value!=$Value)
			{
				$access=1;
			}
		}
		
		if($Operator=="Between")
		{
			if($lv_Cust_value>=$Value1 && $lv_Cust_value<=$Value2)
			{
				$access=1;
			}
		}
		
		return $access;
	}
	//////////////////////////////////////////////////////
}
?>