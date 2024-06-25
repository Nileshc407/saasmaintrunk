<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Redemption_Model extends CI_Model 
{
	public function get_all_items($limit,$start,$Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_item_type) 
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');	
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=> 0,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0,));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag' => 0,'A.Link_to_Member_Enrollment_flag' => 0,'A.Send_once_year' => 0,'A.Send_other_benefits' => 0));
		}
		if($Sort_by_merchant!=0)//ALL merchants
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
		if($Sort_by_item_type != 0)//sort by item type
		{
			$this->db->where(array('A.Merchandize_item_type'=>$Sort_by_item_type));
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
			$this->db->order_by('Company_merchandise_item_id','desc');
		}
		if($limit!=NULL || $start!=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$sql = $this->db->get();
		//echo $this->db->last_query();die;
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
		$this->db->select('A.Branch_code,B.Branch_name,A.Merchandize_item_code,B.Address');
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
	function Get_Merchandize_Items_Count($Company_id,$Merchandize_category_id,$Sort_by,$Sort_by_merchant,$Sort_by_brand,$Sort_by_gender,$Sort_by_item_type)
	{
		$Todays_date=date("Y-m-d");
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue as A');
		
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'Ecommerce_flag'=> 0,'Link_to_Member_Enrollment_flag'=> 0,'Send_once_year'=> 0,'Send_other_benefits'=> 0));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'Ecommerce_flag' => 0,'Link_to_Member_Enrollment_flag' => 0,'Send_once_year' => 0,'Send_other_benefits' => 0));
		}
		if($Sort_by_merchant!=0)//ALL merchants
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
		if($Sort_by_item_type != 0)//sort by item type
		{
			$this->db->where(array('A.Merchandize_item_type'=>$Sort_by_item_type));
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
		
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	function get_total_redeeem_points($enroll)
	{
		$this->db->select('Temp_cart_id,Item_code,Company_merchandise_item_id,Item_image1,Item_image2,Item_image3,Item_image4,Thumbnail_image1,Thumbnail_image2,Thumbnail_image3,Thumbnail_image4,Merchandize_item_name,Points,SUM(Points) AS Total_points,COUNT( A.Item_code ) as Quantity,Billing_price_in_points,Points,A.Size,Branch,B.Partner_id,Branch_name,Address,Merchant_flag,Seller_id,Redemption_method,A.Weight,A.Weight_unit_id,P.State AS Partner_state,P.Country_id as Partner_Country_id,Partner_vat,Cost_price,B.Merchandize_item_type');
		$this->db->from('igain_temp_cart as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Item_code=B.Company_merchandize_item_code AND A.Company_id=B.Company_id');
		$this->db->join('igain_branch_master as C','A.Branch=C.Branch_code AND A.Company_id=C.Company_id');
		$this->db->join('igain_partner_master as P','P.Partner_id=B.Partner_id AND P.Company_id=B.Company_id');
		$this->db->group_by("A.Item_code");
		$this->db->group_by("A.Size");
		$this->db->group_by("A.Branch");
		$this->db->group_by("A.Redemption_method");
		$this->db->where(array('A.Enrollment_id'=>$enroll,'B.Active_flag'=>1));
		$sql=$this->db->get();
		//echo $this->db->last_query();die;
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
		// echo $this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	
	public function delete_item_catalogue($Item_code,$Enrollment_id,$Company_id,$Branch,$Size,$Redemption_method)
	{
		$this->db->delete('igain_temp_cart',array('Item_code'=>$Item_code,'Enrollment_id'=>$Enrollment_id,'Company_id'=>$Company_id,'Branch'=>$Branch,'Size'=>$Size,'Redemption_method'=>$Redemption_method));
		// echo $this->db->last_query();die;
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
		$this->db->where_not_in('A.Merchandize_category_id', array('10','15'));
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
		$this->db->select( 'Company_merchandize_item_code,Merchandize_item_name,Merchandise_item_description,Billing_price_in_points,Item_image1,Item_image2,Item_image3,Item_image4,Thumbnail_image1,Thumbnail_image2,Thumbnail_image3,Thumbnail_image4,Company_id,Delivery_method,Company_merchandise_item_id,Brand_flag,Item_Brand,Colour_flag,Item_Colour,Dimension_flag,Item_Dimension,Weight_flag,Item_Weight,Size_flag,Manufacturer_flag,Item_Manufacturer,Merchant_flag,Seller_id,Size_chart,Size_chart_image,Weight_unit_id,Merchandize_item_type'); 
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'show_item'=>1,'Company_merchandise_item_id'=>$Company_merchandise_item_id));
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
		// echo "<br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	/*********************AMIT 14-06-2016 Changed*********************/
	public function Update_Customer_Balance($Current_balance,$lv_Total_reddems,$Enrollement_id)
	{
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->update('igain_enrollment_master',array('Current_balance'=>$Current_balance,'Total_reddems'=>$lv_Total_reddems));
		// echo "<br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
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
	/***************AMIT 07-07-2017*****************/
	public function Insert_view_item($data)
	{
		$this->db->insert(' igain_viewed_merchandise_items',$data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	public function Get_Cust_Recent_merchandize_items($Company_id,$Enroll_id)
	{
		$this->db->select('*');
		$this->db->from('igain_viewed_merchandise_items');
		$this->db->where(array('Company_id'=>$Company_id, 'Enroll_id' =>$Enroll_id));
		$this->db->order_by('View_id','desc');
		$this->db->limit(10,0);
        $query = $this->db->get();
		 // echo "<br>".$this->db->last_query();
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
	public function Check_Cust_Recent_merchandize_items_exist($Company_id,$Enroll_id,$Company_merchandise_item_id)
	{
		$this->db->select('*');
		$this->db->from('igain_viewed_merchandise_items');
		$this->db->where(array('Company_id'=>$Company_id, 'Enroll_id' =>$Enroll_id, 'Item_id' =>$Company_merchandise_item_id));
		$query = $this->db->get();
		return $query->num_rows();
		
	}
	public function Delete_Cust_Recent_merchandize_items_exist($Company_id,$Enroll_id,$Company_merchandise_item_id)
	{
		$this->db->delete('igain_viewed_merchandise_items',array('Company_id'=>$Company_id, 'Enroll_id' =>$Enroll_id, 'Item_id' =>$Company_merchandise_item_id));
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
	}
	public function get_all_free_items($limit,$start,$Company_id,$Merchandize_category_id,$Sort_by)
	{
		$Todays_date=date("Y-m-d");
		$this->db->from('igain_company_merchandise_catalogue as A');
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'Billing_price_in_points'=> 0));
		}
		else
		{
			$this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'Billing_price_in_points' => 0));
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
		if($limit!=NULL && $start!=NULL)
		{
			$this->db->limit($limit,$start);
		}
		// $this->db->limit($limit,$start);
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
	public function fetch_max_price($Company_id)    
	{
		$this->db->select_max('Billing_price_in_points');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id,'show_item'=>1,'Active_flag'=>1,'Ecommerce_flag'=>0)); 
		
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
	public function fetch_min_price($Company_id)    
	{
		$this->db->select_min('Billing_price_in_points');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id,'show_item'=>1,'Active_flag'=>1,'Ecommerce_flag'=>0));  
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
	public function get_all_products($Company_id)
	{
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id));
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
	function Get_Merchandize_item_type($Company_id)
	{
		$this->db->select('Merchandize_item_type');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		$this->db->group_by("Merchandize_item_type");
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
	public function filter_result($Sort_by,$Sort_category,$PriceFrom,$PriceTo,$Company_id)  
	{
            $Todays_date=date("Y-m-d");
            $this->db->from('igain_company_merchandise_catalogue as A');
            
            if($Sort_category == 0)   //ALL
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=> 0,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            else
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Sort_category,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=> 0,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            
            $this->db->where("Billing_price_in_points Between '".$PriceFrom."'  AND '".$PriceTo."'");
            
            if($Sort_by == 1)//Low to High
            {
                $this->db->order_by('Billing_price_in_points','asc');
            }
            else if($Sort_by == 2)//High to Low
            {
                $this->db->order_by('Billing_price_in_points','desc');
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
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=> 0,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            else
            {
                $this->db->where(array('A.Company_id'=>$Company_id,'A.Merchandize_category_id'=>$Sort_category,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date,'A.show_item'=>1,'A.Active_flag'=>1,'A.Ecommerce_flag'=> 0,'A.Link_to_Member_Enrollment_flag'=> 0,'A.Send_once_year'=> 0,'A.Send_other_benefits'=> 0));
            }
            
            $this->db->where("Billing_price_in_points Between '".$PriceFrom."'  AND '".$PriceTo."'");
            
            if($Sort_by == 1)//Low to High
            {
                $this->db->order_by('Billing_price_in_points','asc');
            }
            else if($Sort_by == 2)//High to Low
            {
                $this->db->order_by('Billing_price_in_points','desc');
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
            // $this->db->limit($limit,$start);
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
	function Get_Merchandize_item_brand($Company_id)
	{
		$this->db->select('Item_Brand');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'Brand_flag'=>1,'Company_id'=>$Company_id));
		$this->db->group_by("Item_Brand");
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
	function Get_Merchandize_item_Gender_flag($Company_id)
	{
		$this->db->select('Gender_flag');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		$this->db->group_by("Gender_flag");
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
	function Get_item_details($Company_id,$Company_merchandize_item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_item_size_child');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandize_item_code'=>$Company_merchandize_item_code));
		
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() >0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
		
	}
	function Get_item_details1($Company_id,$Company_merchandize_item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_item_size_child');
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
	
	/*************************************Nilesh End******************************************/
	/*************************************Ravi Start******************************************/
	public function get_all_offers_items($Company_merchandise_item_id,$Company_id)
	{
		$Todays_date=date('Y-m-d');
		$this->db->select('A.Company_merchandise_item_id,B.Buy_item,B.Free_item');
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
		$this->db->select('B.Company_merchandise_item_id,A.Buy_item,A.Free_item');
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
	
	function get_weight_items_same_location($Partner_state,$enroll)
	{
		$this->db->select('SUM(Weight) as Total_weight_same_location,A.Weight_unit_id');
		$this->db->from('igain_temp_cart as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Item_code=B.Company_merchandize_item_code AND A.Company_id=B.Company_id');
		$this->db->join('igain_branch_master as C','A.Branch=C.Branch_code AND A.Company_id=C.Company_id');
		$this->db->join('igain_partner_master as P','P.Partner_id=B.Partner_id AND P.Company_id=B.Company_id');
		$this->db->group_by('P.State');
		$this->db->group_by('A.Weight_unit_id');
		$this->db->where(array('A.Enrollment_id'=>$enroll,'B.Active_flag'=>1,'A.Redemption_method'=>29,'P.State'=>$Partner_state));
		$sql=$this->db->get();
		 // echo $this->db->last_query();//die;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
		
	}
	
	function Get_item_details_size($Company_id,$Company_merchandize_item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_item_size_child');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandize_item_code'=>$Company_merchandize_item_code));
		
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() >0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
		
	}
	function Get_Company_Partners($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_partner_master');
		$this->db->where(array('Company_id'=>$Company_id));
		$sql=$this->db->get();
		if($sql->num_rows()>0)
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