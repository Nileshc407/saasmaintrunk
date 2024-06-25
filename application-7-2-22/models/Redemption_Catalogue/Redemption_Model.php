<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redemption_Model extends CI_Model 
{
	public function get_all_items($limit,$start,$Company_id,$Merchandize_category_id,$Sort_by,$Seller)
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Link_to_Member_Enrollment_flag'=>0,'A.Send_once_year'=>0,'A.Send_other_benefits'=>0,'A.Seller_id'=>$Seller));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Link_to_Member_Enrollment_flag'=>0,'A.Send_once_year'=>0,'A.Send_other_benefits'=>0,'A.Seller_id'=>$Seller));
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
		/* if($limit!=NULL || $start!=NULL)
		{
			$this->db->limit($limit,$start);
		} */
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

	function Get_Merchandize_Items_Count($Company_id)
	{
		$Todays_date=date("Y-m-d");
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'show_item'=>1,'Company_id'=>$Company_id,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date,'A.Link_to_Member_Enrollment_flag'=>0,'A.Send_once_year'=>0,'A.Send_other_benefits'=>0));
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	


	function Get_Merchandize_Item_details($Company_merchandise_item_id)
	{
		/* Company_merchandize_item_code,Merchandize_item_name,Merchandise_item_description,Billing_price_in_points,Item_image1,Item_image2,Item_image3,Item_image4,Thumbnail_image1,Thumbnail_image2,Thumbnail_image3,Thumbnail_image4,Company_id,Delivery_method,Company_merchandise_item_id */
		
		$this->db->select('*');
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

	function Get_Merchandize_Item_details_fromcode($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1, 'Company_merchandize_item_code'=>$Company_merchandize_item_code, 'Company_id' => $Company_id));
		$sql=$this->db->get();
		//echo "aaaaaaaa".$this->db->last_query();
		if($sql->num_rows()>0)
		{
            return $sql->result();
		}
		else
		{
			return false;
		}	
		
	}
	
	function get_redeem_bill_info($Bill_no,$Company_id,$transtype)
	{
		$this->db->select('A.Merchandize_item_name,A.Billing_price_in_points,B.Quantity,Voucher_status,Billing_price,balance_to_pay,Loyalty_pts,Redeem_points,Item_size');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => $transtype, 'B.Bill_no' => $Bill_no, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
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
	public function Get_tier_details($Company_id,$TierID)
	{
		$this->db->select('*');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Tier_id' =>$TierID));
	
        $query = $this->db->get();
		//echo "<br>".$this->db->last_query();
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
	
/**************************AMIT END*******************************************************************************************/	
	
}
?>
