<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coal_Transactions_model extends CI_Model 
{
	/***********************Alkwarm 27-09-2016 amit*************************/
	public function get_all_Purchase_redeem_items($limit,$start,$Company_id,$Merchandize_category_id,$Sort_by,$Cust_Tier_id,$Seller_id)
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_item_tier_child as B','A.Company_merchandize_item_code=B.Merchandize_item_code');
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Seller_id'=>$Seller_id,'B.Tier_id'=>$Cust_Tier_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Seller_id'=>$Seller_id,'B.Tier_id'=>$Cust_Tier_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1));
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

	public function Get_Price_Points_by_size($Size_flag,$Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('Billing_price,Billing_price_in_points,Item_size');
		$this->db->from('igain_merchandize_item_size_child');
		if($Size_flag==0)
		{
			$this->db->where(array('Company_id' => $Company_id,'Company_merchandize_item_code' => $Company_merchandize_item_code));
		}
		else
		{
			$this->db->where(array('Company_id' => $Company_id,'Company_merchandize_item_code' => $Company_merchandize_item_code,'Item_size' => $Size_flag));
		}
		
		$sql = $this->db->get();
		// echo $this->db->last_query();//DIE;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
  public function Purchase_redeem_transactions_list($limit,$start,$Logged_user_id,$Seller_id,$Company_id)
	{
		/*********Changed Amit 27-06-2016*************/
		$this->db->select('*,SUM(Redeem_points+Item_sales_tax) as Total_Redeem_Points,SUM(Purchase_amount+Item_sales_tax) as Total_Purchase_amount');
		/****************************************/
		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id  AND A.Company_id=B.Company_id');
		
		if($Logged_user_id == 2)
		{
			// $this->db->where(array('B.Trans_type' => '3', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
			$this->db->where(array('A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
		}
		else
		{
			// $this->db->where(array('B.Trans_type' => '3', 'A.Company_id' => $Company_id));
			$this->db->where(array('A.Company_id' => $Company_id));
		}
		
		$Trans_type_array = array('10', '2');
		$this->db->where_in('B.Trans_type', $Trans_type_array);
		//$this->db->group_by('B.Bill_no');
		
		$this->db->order_by('B.Trans_id','DESC');
		if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}
		
        $query = $this->db->get();
		// echo $this->db->last_query();
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
	function get_purchase_redeem_bills_info($Bill_no,$Trans_type,$Seller_id)
	{
			$this->db->select('*');
			$this->db->from('igain_transaction as B');
			$this->db->join('igain_company_merchandise_catalogue as A','B.Item_code=A.Company_merchandize_item_code  AND A.Company_id=B.Company_id');
			$this->db->join('igain_enrollment_master as E', 'E.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id, 'B.Trans_type' => $Trans_type));
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	function get_redeem_bill_info($Bill_no,$Company_id)
	{
		$this->db->select('A.Merchandize_item_name,A.Billing_price_in_points,B.Quantity');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code  AND A.Company_id=B.Company_id');
		$this->db->where(array('B.Trans_type' => '10', 'B.Bill_no' => $Bill_no, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
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
	  public function Preorder_item_list_count($Seller_id,$Company_id)
	{
		/*********Changed Amit 27-06-2016*************/
		$this->db->select('*');
		/****************************************/
	/*	$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_seller_preorder_list as B', 'A.Card_id = B.Card_id');*/
		$this->db->from('igain_seller_preorder_list as A');
		$this->db->join('igain_company_merchandise_catalogue as B', 'A.Merchandise_Item_id = B.Company_merchandise_item_id');
		$this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
		//$this->db->join('igain_transaction_type as D', 'A.Trans_type = D.Trans_type_id');
		$this->db->where(array('A.Company_id' => $Company_id, 'A.Seller_id' => $Seller_id, 'A.Status' => 0));
		
		//$this->db->order_by('B.Trans_id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
        
			return $query->num_rows();
       
   }

	 public function Preorder_item_done_list($limit,$start,$Seller_id,$Company_id)
	{
		  $Todays_date=date("Y-m-d");
		  $this->db->select('*,A.Id,A.Update_date');
		  $this->db->from('igain_seller_preorder_list as A');
		  $this->db->join('igain_company_merchandise_catalogue as B', 'A.Merchandise_Item_id = B.Company_merchandise_item_id');
		  $this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
		  $this->db->join('igain_cust_merchant_trans_summary as D', 'A.Cust_enroll_id = D.Cust_enroll_id AND A.Company_id=D.Company_id AND  A.Seller_id = D.Seller_id ');
		  $this->db->where(array('A.Company_id' => $Company_id, 'A.Seller_id' => $Seller_id, 'A.Status !=' => 0));
		  
		  $this->db->order_by('A.Order_time','ASC');
		  if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}
        $query = $this->db->get();
  //echo $this->db->last_query();
        if ($query->num_rows() > 0)
		{
			return $query->result_array();
        }
        return false;
   }
   
 public function Preorder_item_list($limit,$start,$Seller_id,$Company_id)
 {
		  $Todays_date=date("Y-m-d");
		  $this->db->select('*,A.Id');
		  $this->db->from('igain_seller_preorder_list as A');
		  $this->db->join('igain_company_merchandise_catalogue as B', 'A.Merchandise_Item_id = B.Company_merchandise_item_id');
		  $this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
		  $this->db->join('igain_cust_merchant_trans_summary as D', 'A.Cust_enroll_id = D.Cust_enroll_id AND A.Company_id=D.Company_id  AND  A.Seller_id = D.Seller_id ');
		  $this->db->where(array('A.Company_id' => $Company_id, 'A.Seller_id' => $Seller_id, 'D.Seller_id' => $Seller_id, 'A.Status' => 0, 'Order_date <=' => $Todays_date));
		  
		  $this->db->order_by('A.Order_date','ASC');
		  $this->db->order_by('A.Order_time','ASC');
		  if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}
				$query = $this->db->get();
		  //echo $this->db->last_query();
			if ($query->num_rows() > 0)
			{
				return $query->result_array();
			}
        return false;
   }
   
	public function update_preorder($Preorder_id,$status,$Update_date)
	{
		$data = array(
					'Status' => $status,
					'Update_date' => $Update_date
				);
		$this->db->where(array('Id' => $Preorder_id));
		$this->db->update("igain_seller_preorder_list", $data);
		//echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
      public function Search_merchandize_item_name($Item_name,$Company_id,$Logged_user_enroll,$Tier_id)
	{	
		$Todays_date=date("Y-m-d");
		$this->db->from("igain_company_merchandise_catalogue as A");
		$this->db->join("igain_merchandize_item_tier_child as B","A.Company_id=B.Company_id AND A.Company_merchandize_item_code=B.Merchandize_item_code");
		$this->db->like('Merchandize_item_name',$Item_name);
		$this->db->where(array('A.Company_id' => $Company_id, 'Seller_id' => $Logged_user_enroll,'B.Tier_id' => $Tier_id, 'show_item' => 1, 'Active_flag' => 1, 'Valid_from <=' => $Todays_date, 'Valid_till >=' =>$Todays_date));
		
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
		public function update_purchase_billno($Seller_id,$Purchase_Bill_no)
	{
		$data = array(
					'Purchase_Bill_no' => $Purchase_Bill_no
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
//***********************************************Akshay Starts************************************
	
	public function issue_bonus_trans_count($Logged_user_id,$Seller_id,$Company_id)
	{
		if($Logged_user_id == 2)
		{
			$this->db->select('');
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
			$this->db->where(array('B.Trans_type' => '1', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));	
		}
		else
		{
			$this->db->select('');
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
			$this->db->where(array('B.Trans_type' => '1', 'A.Company_id' => $Company_id));	
		}

		return $this->db->count_all_results();
	}
	
	public function issue_bonus_trans_list($limit,$start,$Logged_user_id,$Seller_id,$Company_id)
	{
		/* if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}*/
		
		if($Logged_user_id == 2)
		{
			$this->db->select('*');
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
			$this->db->where(array('B.Trans_type' => '1', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
			$this->db->order_by('B.Trans_id','DESC');
		}
		else
		{
			$this->db->select('*');
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
			$this->db->where(array('B.Trans_type' => '1', 'A.Company_id' => $Company_id));
			$this->db->order_by('B.Trans_id','DESC');
		}
	
        $query = $this->db->get();
		
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

	public function check_seller_item_category($Company_id,$Seller_id)
	{
		$this->db->from('igain_item_category_master');
		$this->db->where(array('Company_id' => $Company_id, 'Seller' => $Seller_id));
		return $this->db->count_all_results();
	}
	
	public function issue_bonus_member_details($Company_id,$get_card,$phnumber)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id,'User_id' => '1'));
		$where = '(Card_id = "'.$get_card.'" OR Phone_no = "'.$phnumber.'")';
		$this->db->where($where);		
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
	
	function cust_details_from_card($Company_id,$Membership_id)
	{
		$this->db->select('a.*,b.Tier_name');
		$this->db->from('igain_enrollment_master as a');
		$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
		$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => '1','a.Card_id' => $Membership_id,'a.User_id' =>1));		
		$sql = $this->db->get();
		
		//echo $this->db->last_query();
		return $sql->result_array();
	}
	
	public function get_count_topup($Membership_id,$Enroll_id,$Logged_user_enrollid)
	{
		$this->db->from('igain_transaction');
		$this->db->where(array('Enrollement_id' => $Enroll_id,'Card_id' => $Membership_id,'Seller' =>$Logged_user_enrollid, 'Trans_type' => '1'));
		
		return $this->db->count_all_results();
	}
	
	public function get_count_purchase($Membership_id,$Enroll_id,$Logged_user_enrollid)
	{
		$this->db->from('igain_transaction');
		$this->db->where(array('Enrollement_id' => $Enroll_id,'Card_id' => $Membership_id,'Seller' =>$Logged_user_enrollid, 'Trans_type' => '2'));
		return $this->db->count_all_results();
	}
	
	public function get_top_seller($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','Super_seller' => '0', 'Sub_seller_admin' => '1', 'Company_id' => $Company_id));
		$this->db->limit(1);
		$sql = $this->db->get();
		return $sql->result_array();
	}
	
	public function check_bill_no($Bill_no,$Company_id)
	{		
		$query =  $this->db->select('Manual_billno')
				  ->from('igain_transaction')
				  ->where(array('Manual_billno' => $Bill_no, 'Company_id' => $Company_id))->get();
		return $query->num_rows();
	}
	
	public function gained_points_atseller($Membership_id,$Enroll_id,$Seller_id)
	{
		//$this->db->select_sum('Loyalty_pts');
		$this->db->select('sum(Loyalty_pts + Topup_amount) as totalLoyalty_pts');
		$this->db->from('igain_transaction');
		$this->db->where(array('Enrollement_id' => $Enroll_id,'Card_id' => $Membership_id, 'Seller' => $Seller_id));
		$sql = $this->db->get();
		$result = $sql->result();
		// return $sql->result_array();
		return $result[0]->totalLoyalty_pts;
	}
	

	
	function get_transaction_receipt($Bill_no,$Seller_id,$Trans_id)
	{
		$this->db->from('igain_transaction');
		$this->db->where(array('Bill_no' => $Bill_no, 'Seller' => $Seller_id, 'Trans_id' => $Trans_id));
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
	
	function get_bills_info($Bill_no,$Trans_type,$Seller_id)
	{
		if($Trans_type == 1)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '1', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}
		
		if($Trans_type == 2)
		{
			$this->db->select('B.*,A.First_name,A.Middle_name,A.Last_name,A.Phone_no,A.User_email_id,A.Current_address,A.City,C.Trans_type,D.Item_category_name,E.Payment_description');//,E.Payment_description
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->join('igain_transaction_type as C', 'B.Trans_type = C.Trans_type_id');
			$this->db->join('igain_item_category_master as D', 'B.Seller = D.Seller');
			$this->db->join('igain_payment_type_master as E', 'B.Payment_type_id = E.Payment_type_id');
			$this->db->where(array('B.Trans_type' => '2', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
			$this->db->group_by("B.Bill_no"); 
		}
		
		if($Trans_type == 3)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '3', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}
		
		if($Trans_type == 4)
		{
			$this->db->select('B.*,E.Payment_description');//,E.Payment_description
			$this->db->from('igain_giftcard_tbl as A');
			$this->db->join('igain_transaction as B', 'B.GiftCardNo = A.Gift_card_id');
			$this->db->join('igain_payment_type_master as E', 'B.Payment_type_id = E.Payment_type_id');
			$this->db->where(array('B.Trans_type' => '4', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}
		
		if($Trans_type == 10)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '10', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}
		
		$query = $this->db->get();
 // eadminchocho $this->db->last_query();
		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	function get_giftcard_details($Gift_card_id,$Company_id)
	{
		$this->db->from('igain_giftcard_tbl');
		$this->db->where(array('Gift_card_id' => $Gift_card_id, 'Company_id' => $Company_id));
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
		function get_transaction_details($Seller_id,$Enrollment_id,$Membership_id)
	{
		$this->db->select( 'Trans_date,B.Trans_type,Purchase_amount,Redeem_points,balance_to_pay,Topup_amount,Loyalty_pts,Seller_name,Quantity,B.Trans_type_id');
		$this->db->from('igain_transaction as A');
		$this->db->join('igain_transaction_type as B', 'A.Trans_type = B.Trans_type_id');
		
		foreach($Seller_id as $Seller_id2)
		{
			$this->db->or_where(array('A.Enrollement_id' => $Enrollment_id));	
			$this->db->where('A.Seller',$Seller_id2);
		}
		$this->db->order_by('A.Trans_date','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	function get_transaction_sum_details($Seller_id,$Enrollment_id,$Membership_id)
	{
		$this->db->select_sum('Purchase_amount');
		$this->db->select_sum('Redeem_points');
		$this->db->select_sum('balance_to_pay');
		$this->db->select_sum('Topup_amount');
		$this->db->select_sum('Loyalty_pts');
		$this->db->from('igain_transaction');
		// $this->db->where(array('Seller' => $Seller_id, 'Enrollement_id' => $Enrollment_id, 'Card_id' => $Membership_id));
			foreach($Seller_id as $Seller_id2)
		{
			$this->db->or_where(array('Enrollement_id' => $Enrollment_id));	
			$this->db->where('Seller',$Seller_id2);
		}
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
	
	public function insert_topup_details($data)
	{
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update_customer_balance($Membership_id,$Curent_balance,$Company_id,$Topup_amt,$last_visit_date,$purchase_amount,$reddem_amount)
	{
		$CustomerData = array(
					'Current_balance' => $Curent_balance,
					'Total_topup_amt' => $Topup_amt,
					'last_visit_date' => $last_visit_date,
					'total_purchase' => $purchase_amount,
					'Total_reddems' => $reddem_amount
				);
		$this->db->where(array('Company_id' => $Company_id, 'Card_id' => $Membership_id));
		$this->db->update("igain_enrollment_master", $CustomerData);
		//echo "<br><br>----update_customer_balance-- ".$this->db->last_query()."----<br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function update_seller_balance($Seller_id,$Total_seller_bal)
	{
		$Sellerdata20 = array(
					'Current_balance' => $Total_seller_bal
				);
		$this->db->where(array('Enrollement_id' => $Seller_id));
		$this->db->update("igain_enrollment_master", $Sellerdata20);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function update_topup_billno($Seller_id,$Topup_Bill_no)
	{
		$data = array(
					'Topup_Bill_no' => $Topup_Bill_no
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
	
	/************************************Gift Card Transaction******************************/
	function get_giftcard_info($GiftCardNo,$Company_id)
	{
		$this->db->from('igain_giftcard_tbl');
		$this->db->where(array('Gift_card_id' => $GiftCardNo, 'Company_id' => $Company_id));
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result() as $row)
			{
               $result[] = array("User_name" => $row->User_name, "Email" => $row->Email, "Phone_no" => $row->Phone_no, "Card_balance" => $row->Card_balance, "Gift_card_id" => $row->Gift_card_id, "MembershipID" => $row->Card_id);
            }			
			return json_encode($result);
		}
		else
		{
			return 0;
		}
	}
	
	public function giftcard_trans_count($Logged_user_id,$Seller_id,$Company_id)
	{
		if($Logged_user_id == 2)
		{
			$this->db->from('igain_giftcard_tbl as A');
			$this->db->join('igain_transaction as B', 'A.Gift_card_id = B.GiftCardNo');
			$this->db->where(array('B.Trans_type' => '4', 'A.Company_id' => $Company_id, 'A.Card_id !=' => '0', 'B.Seller' => $Seller_id));
		}
		else
		{
			$this->db->from('igain_giftcard_tbl as A');
			$this->db->join('igain_transaction as B', 'A.Gift_card_id = B.GiftCardNo');
			$this->db->where(array('B.Trans_type' => '4', 'A.Company_id' => $Company_id, 'A.Card_id !=' => '0'));
		}
		
		return $this->db->count_all_results();
	}
	
	public function giftcard_trans_list($limit,$start,$Logged_user_id,$Seller_id,$Company_id)
	{
		$this->db->distinct();
		$this->db->from('igain_giftcard_tbl as A');
		$this->db->join('igain_transaction as B', 'A.Gift_card_id = B.GiftCardNo');
		
		if($Logged_user_id == 2)
		{
			$this->db->where(array('B.Trans_type' => '4', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));	//, 'A.Card_id !=' => '0'	
		}
		else
		{
			$this->db->where(array('B.Trans_type' => '4', 'A.Company_id' => $Company_id));
		}
		
		$this->db->order_by('B.Trans_id','DESC');
		if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}
        $query = $this->db->get();

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
   
   function enrollment_details_frmemail_phn_card($Email,$Card_id,$Phone_no,$Company_id)
	{
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_email_id' => $Email, 'Company_id' => $Company_id, 'Card_id' => $Card_id, 'Phone_no' => $Phone_no));	
		$sql = $this->db->get();
		//echo $this->db->last_query();
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	
	public function insert_giftcard_transaction($data)
	{
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function update_giftcard_balance($Gift_card_id,$Card_balance,$Company_id)
	{
		$data = array(
					'Card_balance' => $Card_balance
				);
		$this->db->where(array('Gift_card_id' => $Gift_card_id, 'Company_id' => $Company_id));
		$this->db->update("igain_giftcard_tbl", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
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
	public function update_billing_billno($Seller_id,$Billing_Bill_no)
	{
		$data = array(
					'Seller_Billing_Bill_no' => $Billing_Bill_no
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
	/************************************Gift Card Transaction******************************/
	
//*****************************************Akshay Ends*************************************************

//*****************************************Sandeep Work Starts *************************************************
	public function check_seller_pin($sellerPin,$Company_id)
	{		
		$query =  $this->db->select('User_email_id')
				  ->from('igain_enrollment_master')
				  ->where(array('pinno' => $sellerPin, 'Company_id' => $Company_id))->get();
		return $query->num_rows();
	}
	
	function check_card_id($cardid,$Company_id)
	{
		$query =  $this->db->select('Enrollement_id,Card_id,First_name,Last_name,User_email_id,Phone_no')
				   ->from('igain_enrollment_master')
				   ->where(array('Card_id' => $cardid, 'User_activated' => '1', 'Company_id' => $Company_id))->get();
		// return $query->num_rows();
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	function check_gift_card_id($gift_cardid,$Company_id)
	{
		$query =  $this->db->select('id')
				   ->from('igain_giftcard_tbl')
				   ->where(array('Gift_card_id' => $gift_cardid, 'Company_id' => $Company_id))->get();
				   
		return $query->num_rows();
	}
	
	public function assigned_giftcard_count($Company_id)
	{
		$this->db->select('id');
		$this->db->from('igain_giftcard_tbl');
		$this->db->where(array('Company_id' => $Company_id));
		return $this->db->count_all_results();
	}
	
	public function assigned_giftcard_list($limit,$start,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_giftcard_tbl');
		$this->db->where(array('Company_id' => $Company_id));
		$this->db->order_by('id','DESC');
		if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}
        $query = $this->db->get();

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
   
   public function insert_giftcard($Company_id,$Logged_user_id)
   {
	   $data["Gift_card_id"] = $this->input->post("gif_number");
	   $data["Card_balance"] = $this->input->post("gif_balance");
	   $data["Company_id"] = $Company_id;
	   $data["Seller_id"] = $Logged_user_id;

	   $Enroll_flag = $this->input->post("Enroll_flag");
	   
		if($Enroll_flag == 1)
		{ 
			$data["Card_id"] = $this->input->post("CardID");
			$da_Card_id = $this->input->post("CardID");
			
			$res = $this->db->query("Select Enrollement_id,First_name,Middle_name,Last_name,Phone_no,User_email_id from igain_enrollment_master 
						where Company_id='".$Company_id."' AND Card_id='".$da_Card_id."' AND User_activated='1' ");
				
				$sql_result = $res->result_array();
				
				foreach($sql_result  as $row)
				{
					$data["User_name"] = $row['First_name'].' '.$row['Middle_name'].' '.$row['Last_name'];
					$data["Email"] = $row['User_email_id']; 
					$data["Phone_no"] = $row['Phone_no'];
				}
				
		}
		else
		{
		   $data["User_name"] = $this->input->post("user_name");
		   $data["Email"] = $this->input->post("user_email");
		   $data["Phone_no"] = $this->input->post("user_phno");
		}
	   $data["Payment_Type_id"] = $this->input->post("Payment_type");
	   $data["Cheque_no"] = $this->input->post("Cheque_no");
	   $data["Bank_name"] = $this->input->post("Bank_name");
	   $data["Bank_Branch_name"] = $this->input->post("Branch_name");
	   
	  
	   
	   $this->db->insert("igain_giftcard_tbl",$data);
	   
	   if($this->db->affected_rows() > 0)
		{
			return true;
		}
   }
   
 	//******** Loyalty Transaction ********  
 	
   public function loyalty_transaction_count($Logged_user_id,$Seller_id,$Company_id)
	{
		
		$this->db->select('');
		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
		
		if($Logged_user_id == 2)
		{
			$this->db->where(array('B.Trans_type' => '2', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
		}
		else
		{
			$this->db->where(array('B.Trans_type' => '2', 'A.Company_id' => $Company_id));
		}
		
		return $this->db->count_all_results();
	}
	
	public function loyalty_transactions_list($limit,$start,$Logged_user_id,$Seller_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_transaction as B');
		$this->db->join('igain_enrollment_master as A', 'A.Card_id = B.Card_id');
		
		if($Logged_user_id == 2)
		{
			$this->db->where(array('B.Trans_type' => '2', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
		}
		else
		{
			$this->db->where(array('B.Trans_type' => '2', 'A.Company_id' => $Company_id));
		}
		
		$this->db->order_by('B.Trans_id','DESC');
		if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		}
        $query = $this->db->get();

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
   
   
   public function get_loyaltyrule_details($Loyalty_names,$Company_id,$Logged_user_enroll,$Logged_user_id)
	{	
		if($Logged_user_id == 3 || $Logged_user_id == 4)
		{
			$this->db->from("igain_loyalty_master");
			$this->db->where_in('Loyalty_name',$Loyalty_names);
			$this->db->where(array('Company_id' => $Company_id));
		}
		else
		{
			$this->db->from("igain_loyalty_master");
			$this->db->where_in('Loyalty_name',$Loyalty_names);
			$this->db->where(array('Company_id' => $Company_id, 'Seller' => $Logged_user_enroll));
		}
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
   
   public function get_discount($transaction_amt,$discount)
   {
        //echo "<br>------get_discount---------".$transaction_amt."------discount---------".$discount."----<br><br>";
        return ($transaction_amt/100) * $discount;
   }
   
   public function insert_loyalty_transaction($data)
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
	
	public function select_seller_refrencerule($seller_id,$Company_id,$Referral_rule_for)
	{
		$today = date("Y-m-d");
		
		$this->db->select("*");
		$this->db->from("igain_seller_refrencerule");
		$this->db->where(array('Referral_rule_for' =>$Referral_rule_for , 'Seller_id' =>$seller_id, 'Company_id' =>$Company_id,'Till_date >=' => $today));
		
		$sql_opt = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($sql_opt->num_rows() > 0)
		{
			return $sql_opt->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function get_promo_code_details($PromoCode,$CompanyID)
	{
		$todayD  = date("Y-m-d");
		
		$this->db->select('a.Points');
		$this->db->from('igain_promo_campaign_child as a');
		$this->db->join('igain_promo_campaign as b','a.Campaign_id = b.Campaign_id');
		$this->db->where(array('a.Promo_code'=> $PromoCode,'a.Company_id' => $CompanyID, 'a.Active_flag' => '1', 'a.Promo_code_status' => '0' ));
		$this->db->where(" '".$todayD."' BETWEEN b.From_date AND b.To_date ");
		$sql_promo = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($sql_promo->num_rows() > 0)
		{
			foreach($sql_promo->result()  as $rowp)
			{
				return $rowp->Points;
			}
		}
		else
		{
			return 0;
		}
	}
	
	public function utilize_promo_code($Company_id,$PromoCode,$post_data21)
	{
		$this->db->where(array('Company_id' => $Company_id,'Promo_code'=>$PromoCode,'Promo_code_status' => '0','Active_flag' => '1'));
		$this->db->update('igain_promo_campaign_child', $post_data21); 
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	//******** Loyalty Transaction ********
		
		
	//**** 22-06-2016--------
	
	function get_tierbased_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id,$TierID)
	{

		if($Logged_user_id == 3 || $Logged_user_id == 4)
		{
			$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
			$this->db->from('igain_loyalty_master as lp');
			//$this->db->join('igain_enrollment_master as e','e.Enrollement_id = lp.Seller');
			// $this->db->not_like('lp.Loyalty_name', '%ONLY REDEEM');
			//$this->db->group_by('1');
			// $this->db->where(array('lp.Company_id'=>$Company_id, 'lp.Active_flag' => 1));
			$this->db->where(array('lp.Company_id'=>$Company_id, 'lp.Active_flag' => 1, 'lp.Flat_file_flag' => 0, 'lp.Category_flag' => 0, 'lp.Segment_flag' => 0));
			$this->db->where("lp.Tier_id IN ('0','".$TierID."') ");
		}
		else
		{
			$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
			$this->db->from('igain_loyalty_master');
			$this->db->not_like('Loyalty_name', '%ONLY REDEEM');
			$this->db->group_by('1');
			// $this->db->where(array('Company_id' => $Company_id,'Seller' => $Logged_user_enrollid, 'Active_flag' => 1));
			// $this->db->group_by('1');
			$this->db->where(array('Company_id' => $Company_id,'Seller' => $Logged_user_enrollid, 'Active_flag' => 1, 'Category_flag' =>0, 'Flat_file_flag' => 0, 'Segment_flag' =>0));
			$this->db->where("Tier_id IN ('0','".$TierID."') ");
		}
		
        $query = $this->db->get();
		
		//echo $this->db->last_query();
		
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
	//**** 22-06-2016--------
	
		
//*****************************************Sandeep Work Ends *************************************************


//*****************************************AMIT Work START *************************************************
	public function get_loyalty_for_redeem($enrollid,$logcompid)
	{

		$this->db->select("*");
		$this->db->from("igain_loyalty_master");
		$this->db->where(array('Seller' =>$enrollid , 'Company_id' =>$logcompid, 'Active_flag' =>'1'));
		
		$sql_opt = $this->db->get();
		//echo $sql_opt->num_rows();
		if($sql_opt->num_rows() > 0)
		{
			return $sql_opt->result_array();
		}
		else
		{
			return false;
		}
		
	}
	
	public function redeem_transactions_list($limit,$start,$Logged_user_id,$Seller_id,$Company_id)
	{
		/*********Changed Amit 27-06-2016*************/
		$this->db->select('*,SUM(Redeem_points*Quantity) as Total_Redeem_Points');
		/****************************************/
		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
		
		if($Logged_user_id == 2)
		{
			// $this->db->where(array('B.Trans_type' => '3', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
			$this->db->where(array('A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
		}
		else
		{
			// $this->db->where(array('B.Trans_type' => '3', 'A.Company_id' => $Company_id));
			$this->db->where(array('A.Company_id' => $Company_id));
		}
		
		$Trans_type_array = array('3', '10');
		$this->db->where_in('B.Trans_type', $Trans_type_array);
		$this->db->group_by('B.Bill_no');
		
		$this->db->order_by('B.Trans_id','DESC');
		/* if($limit != NULL || $start != NULL )
		{	
			$this->db->limit($limit,$start);
		} */
        $query = $this->db->get();

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

	public function redeem_transaction_count($Logged_user_id,$Seller_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
		
		if($Logged_user_id == 2)
		{
			//$this->db->where(array('B.Trans_type' => '3', 'A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
			$this->db->where(array('A.Company_id' => $Company_id, 'B.Seller' => $Seller_id));
		}
		else
		{
			//$this->db->where(array('B.Trans_type' => '3', 'A.Company_id' => $Company_id));
			$this->db->where(array('A.Company_id' => $Company_id));
		}
		
		$Trans_type_array = array('3', '10');
		$this->db->where_in('B.Trans_type', $Trans_type_array);
		//$this->db->group_by('B.Bill_no');
		return $this->db->count_all_results();
	}
	
	public function get_merchant_discount_rule($Todays_date,$enrollid,$logcompid)
	{

		$this->db->select("*");
		$this->db->from("igain_discount_master");
		$this->db->where(array('Seller_id' =>$enrollid , 'Company_id' =>$logcompid, 'Active_flag' =>'1'));
		$this->db->where("'".$Todays_date."' BETWEEN From_date AND Till_date");
		$sql_opt = $this->db->get();
		//echo $sql_opt->num_rows();
		// echo $this->db->last_query();
		if($sql_opt->num_rows() > 0)
		{
			return $sql_opt->result_array();
		}
		else
		{
			return 0;
		}
		
	}
	public function get_merchant_applicable_discount_rule($Todays_date,$enrollid,$logcompid,$max_loyalty)
	{

		$this->db->select("Discount");
		$this->db->from("igain_discount_master");
		$this->db->where(array('Seller_id' =>$enrollid , 'Company_id' =>$logcompid, 'Loyalty_points_above' =>$max_loyalty, 'Active_flag' =>'1'));
		$this->db->where("'".$Todays_date."' BETWEEN From_date AND Till_date");
		$sql_opt = $this->db->get();
		//echo $sql_opt->num_rows();
		// echo "<br><br>".$this->db->last_query();
		if($sql_opt->num_rows() > 0)
		{
			return $sql_opt->result_array();
		}
		else
		{
			return false;
		}
		
	}
//*****************************************AMIT Work Ends *************************************************
//*****************************************AMIT Coalition Work **************************************
	public function insert_cust_merchant_trans($data)
	{
		$this->db->insert('igain_cust_merchant_trans_summary', $data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
	
	public function check_cust_seller_record($Company_id,$Seller_id,$Cust_enroll_id)
	{
		$this->db->from('igain_cust_merchant_trans_summary');
		$this->db->where(array('Company_id' => $Company_id, 'Seller_id' => $Seller_id, 'Cust_enroll_id' => $Cust_enroll_id));
		return $this->db->count_all_results();
	}
	
	public function get_cust_seller_record($Seller_id,$Cust_enroll_id)
	{

		$this->db->select("*");
		$this->db->from("igain_cust_merchant_trans_summary");
		$this->db->where(array('Seller_id' =>$Seller_id , 'Cust_enroll_id' =>$Cust_enroll_id));
		
		$sql_opt = $this->db->get();
		//echo $sql_opt->num_rows();
		if($sql_opt->num_rows() > 0)
		{
			return $sql_opt->result_array();
		}
		else
		{
			return false;
		}
		
	}
	
	public function update_cust_merchant_trans($Customer_enroll_id,$lv_Cust_seller_balance,$Company_id,$lv_Seller_total_topup,$lv_date_time,$lv_Seller_total_purchase,$lv_Seller_total_redeem,$lv_Seller_paid_balance,$lv_Seller_total_gain_points,$Seller_id,$lv_Cust_prepayment_balance,$lv_Cust_block_points,$lv_Cust_block_amt,$lv_Cust_debit_points)
	{
		
		if($lv_Cust_seller_balance > 0){
			$lv_Cust_seller_balance=$lv_Cust_seller_balance;
		} else { 
			$lv_Cust_seller_balance=0;
		}		
		if($lv_Seller_total_topup > 0){
			$lv_Seller_total_topup=$lv_Seller_total_topup;
		} else { 
			$lv_Seller_total_topup=0;
		}		
		if($lv_Seller_total_redeem > 0){
			$lv_Seller_total_redeem=$lv_Seller_total_redeem;
		} else { 
			$lv_Seller_total_redeem=0;
		}		
		if($lv_Seller_paid_balance > 0){
			$lv_Seller_paid_balance=$lv_Seller_paid_balance;
		} else { 
			$lv_Seller_paid_balance=0;
		}		
		if($lv_Seller_total_gain_points > 0){
			$lv_Seller_total_gain_points=$lv_Seller_total_gain_points;
		} else { 
			$lv_Seller_total_gain_points=0;
		}		
		if($lv_Cust_prepayment_balance > 0){
			$lv_Cust_prepayment_balance=$lv_Cust_prepayment_balance;
		} else { 
			$lv_Cust_prepayment_balance=0;
		}		
		if($lv_Cust_block_points > 0){
			$lv_Cust_block_points=$lv_Cust_block_points;
		} else { 
			$lv_Cust_block_points=0;
		}		
		if($lv_Cust_block_amt > 0){
			$lv_Cust_block_amt=$lv_Cust_block_amt;
		} else { 
			$lv_Cust_block_amt=0;
		}
		
		if($lv_Cust_debit_points > 0){
			$lv_Cust_debit_points=$lv_Cust_debit_points;
		} else { 
			$lv_Cust_debit_points=0;
		}
		
		
		$CustomerData = array(
					'Cust_seller_balance' => $lv_Cust_seller_balance,
					'Seller_total_topup' => $lv_Seller_total_topup,
					'Seller_total_purchase' => $lv_Seller_total_purchase,
					'Seller_total_redeem' => $lv_Seller_total_redeem,
					'Seller_paid_balance' => $lv_Seller_paid_balance,
					'Seller_total_gain_points' => $lv_Seller_total_gain_points,
					'Cust_prepayment_balance' => $lv_Cust_prepayment_balance,
					'Cust_block_points' => $lv_Cust_block_points,
					'Cust_block_amt' => $lv_Cust_block_amt,
					'Cust_debit_points' => $lv_Cust_debit_points,
					'Update_date' => $lv_date_time);
					
					
		$this->db->where(array('Cust_enroll_id' => $Customer_enroll_id, 'Seller_id' => $Seller_id));
		$this->db->update("igain_cust_merchant_trans_summary", $CustomerData);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function cust_details_from_card_active_inactive($Company_id,$Membership_id)
	{
		$this->db->select('a.*,b.Tier_name');
		$this->db->from('igain_enrollment_master as a');
		$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
		$this->db->where(array('a.Company_id' => $Company_id,'a.Card_id' => $Membership_id,'a.User_id' =>1));		
		$sql = $this->db->get();
		
		//echo $this->db->last_query();
		return $sql->result_array();
	}
	public function Fetch_coalition_transaction_details($Bill_no,$Company_id,$Super_seller,$Logged_user_enrollid,$Membership_id)
	{
		$this->db->select("B.*,A.First_name as First_name,A.Last_name as Last_name,C.Trans_type as TransType");
		$this->db->from("igain_transaction as B");
		$this->db->join('igain_enrollment_master as A', 'A.Card_id = B.Card_id');
		$this->db->join('igain_transaction_type as C', 'C.Trans_type_id = B.Trans_type');
		$this->db->where(array('B.Company_id' => $Company_id,'B.Manual_billno' => $Bill_no,'B.Card_id' =>$Membership_id));
		$this->db->where('B.Trans_type IN(2)');
		if($Super_seller!=1)
		{
			$this->db->where('B.Seller',$Logged_user_enrollid);
		}
	
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
}

?>
