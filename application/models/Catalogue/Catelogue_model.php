<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catelogue_model extends CI_Model
 {
	 	/**************************************************Create Merchandize Partners Start*************************************/
	function Insert_Merchandize_Partner($Post_data)
	{
		$this->db->insert('igain_partner_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	function Get_Company_Partners($limit,$start,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_partner_master');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		$this->db->order_by('Partner_id','desc');
		/* if($limit != NULL && $limit != NULL )
		{
			$this->db->limit($limit,$start);
		} */
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
	function Get_Company_Partners_details($Partner_id)
	{
		$this->db->select('*');
		$this->db->from('igain_partner_master');
		$this->db->where(array('Partner_id'=>$Partner_id));
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
	function Get_Company_Partners_Count($Company_id)
	{
		$this->db->select('Partner_id');
		$this->db->from('igain_partner_master');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	function Delete_Merchandize_Partners($Partner_id,$Update_User_id,$Update_date)
	{
		$this->db->where("Partner_id",$Partner_id);
		$this->db->update('igain_partner_master',array('Active_flag'=>0,'Update_user_id'=>$Update_User_id,'Update_date'=>$Update_date));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Update_Merchandize_Partner($Partner_id,$Post_data)
	{
		$this->db->where("Partner_id",$Partner_id);
		$this->db->update('igain_partner_master',$Post_data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
		/**************************************************Create Merchandize Partners End*************************************/
	/**************************************************Create Merchandize Partners Branch Start*************************************/
	function Insert_Merchandize_Partner_Branch($Post_data)
	{
		$this->db->insert('igain_branch_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
		
	function Get_Company_Partners_Branches($limit,$start,$Company_id)
	{
		$this->db->select('Branch_id,Branch_code,Partner_name,B.Branch_name,Address');
		$this->db->from('igain_branch_master as B');
		$this->db->join('igain_partner_master as P','B.Partner_id=P.Partner_id');
		$this->db->where(array('B.Active_flag'=>1,'P.Active_flag'=>1,'B.Company_id'=>$Company_id));
		$this->db->order_by('Branch_id','desc');
		//$this->db->limit($limit,$start);
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
	function Get_Company_Partners_Branch_Count($Company_id)
	{
		$this->db->select('Branch_id');
		$this->db->from('igain_branch_master as B');
		$this->db->join('igain_partner_master as P','B.Partner_id=P.Partner_id');
		$this->db->where(array('B.Active_flag'=>1,'P.Active_flag'=>1,'B.Company_id'=>$Company_id));
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	function Delete_Merchandize_Partners_Branch($Branch_id,$Update_User_id,$Update_date)
	{
		$this->db->where("Branch_id",$Branch_id);
		$this->db->update('igain_branch_master',array('Active_flag'=>0,'Update_User_id'=>$Update_User_id,'Update_date'=>$Update_date));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Get_Company_Partners_Branch_details($lv_Branch_id)
	{
		$this->db->select('*');
		$this->db->from('igain_branch_master');
		$this->db->where(array('Branch_id'=>$lv_Branch_id));
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
	function Update_Merchandize_Partner_Branch($lv_Branch_id,$Post_data)
	{
		$this->db->where("Branch_id",$lv_Branch_id);
		$this->db->update('igain_branch_master',$Post_data);
		//echo $this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
		function Check_Branch_Code($Branch_Code,$Company_id)
	{
		$this->db->select('Branch_id');
		$this->db->from('igain_branch_master');
		$this->db->where(array('Company_id'=>$Company_id,'Branch_Code'=>$Branch_Code));
		$sql=$this->db->get();
		//echo $this->db->last_query();die;
		return $sql->num_rows();
	}
		/**************************************************Create Merchandize Partners Branch End******************************/
	/**************************************************Create Merchandize Category Start*************************************/
	function Insert_Merchandize_Category($Post_data)
	{
		//********27-03-2020********sandeep***********
		$res1 = $this->db->query("select Max(Merchandize_category_id) from igain_merchandize_category");
		 $res2 = $res1->result_array();
        $result = $res2[0]['Max(Merchandize_category_id)'];
		//echo " ---".$result;die;
        $Post_data['Merchandize_category_code'] = ++$result;
		//********27-03-2020********sandeep***********
		
		$this->db->insert('igain_merchandize_category',$Post_data);
		
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	function Get_Merchandize_Category($limit,$start,$Company_id)
	{
		$this->db->select('A.Merchandize_category_id,A.Parent_category_id,A.Merchandize_category_name,A.Seller_id,CONCAT(First_name," ",Last_name) as Full_name,A.Category_order,Merchandize_category_code');
		$this->db->from('igain_merchandize_category as A');
		$this->db->join('igain_enrollment_master as E','A.Seller_id=E.Enrollement_id');
		$this->db->where(array('Active_flag'=>1,'A.Company_id'=>$Company_id));
		/* if($limit != NULL || $start != NULL ){			
			$this->db->limit($limit,$start);
		} */
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

	
	function Get_Merchandize_Category_Count($Company_id)
	{
		$this->db->select('Merchandize_category_id,Merchandize_category_name');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	function Delete_Merchandize_Category($Merchandize_category_id,$Update_user_id,$Update_date)
	{
		$this->db->where("Merchandize_category_id",$Merchandize_category_id);
		$this->db->update('igain_merchandize_category',array('Active_flag'=>0,'Update_user_id'=>$Update_user_id,'Update_date'=>$Update_date));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Get_Merchandize_Category_details($lv_Merchandize_category_id)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Merchandize_category_id'=>$lv_Merchandize_category_id));
		$sql=$this->db->get();
		// echo"<br>----".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
		function Update_Merchandize_Category($lv_Merchandize_category_id,$Post_data)
	{
		$this->db->where("Merchandize_category_id",$lv_Merchandize_category_id);
		$this->db->update('igain_merchandize_category',$Post_data);
		//echo $this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
		/**************************************************Create Merchandize Category End*************************************/
			/**************************************************Create Merchandize Items Start*************************************/
		function Get_Partner_Branches($Partner_id,$Company_id)
		{
			$this->db->select('Branch_code,Branch_name');
			$this->db->from('igain_branch_master');
			$this->db->where(array('Partner_id'=>$Partner_id,'Company_id'=>$Company_id,'Active_flag'=>1));
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
		
		function Insert_Merchandize_Item($Post_data)
	{
		$this->db->insert('igain_company_merchandise_catalogue',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	
		function Insert_Merchandize_Item_log_tbl($Post_data)
	{
		$this->db->insert('igain_company_merchandise_log_tbl',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}	
		
	}
	/***********************AMIT 08-11-2016**************************Delhi*****************/
	function Check_notification_other_benefit_item($Enrollement_id,$Threshold_points_value)
	{
		$this->db->select('Id');
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id'=>$Enrollement_id,'Communication_id'=>$Threshold_points_value));
		$sql=$this->db->get();
		//echo $this->db->last_query();
			return $sql->num_rows();
	}
	function Get_Merchandize_other_benefit_Items($Company_id)
	{
		
		$Todays_date=date("Y-m-d h:i:s");
		$this->db->select('*,A.Create_user_id,A.Creation_date');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as B','A.Merchandize_category_id=B.Merchandize_category_id');
		$this->db->join('igain_partner_master as C','A.Partner_id=C.Partner_id');
		$this->db->where(array('A.Active_flag'=>1,'A.show_item'=>1,'A.Send_other_benefits'=>1,'A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date));
		$sql=$this->db->get();
		//echo $this->db->last_query();
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
	
	function Get_Merchandize_Items_once_year($Company_id)
	{
		
		$Todays_date=date("Y-m-d h:i:s");
		$this->db->select('*,A.Create_user_id,A.Creation_date');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as B','A.Merchandize_category_id=B.Merchandize_category_id');
		$this->db->join('igain_partner_master as C','A.Partner_id=C.Partner_id');
		$this->db->where(array('A.Active_flag'=>1,'A.show_item'=>1,'A.Send_once_year'=>1,'A.Company_id'=>$Company_id,'A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date));
		$sql=$this->db->get();
		//echo $this->db->last_query();
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
	/*******************************************************************/
	function Get_Merchandize_Items($limit,$start,$Company_id,$Active_flag)
	{
		// $this->db->select('*,A.Create_user_id,A.Creation_date,CONCAT(First_name," ",Last_name) as Full_name');
		// $this->db->select('A.Valid_from,A.Valid_till,A.Merchandize_item_type,A.Company_merchandise_item_id,A.Merchandize_item_name,A.Company_merchandize_item_code,B.Merchandize_category_name,A.Billing_price,A.show_item,A.Stamp_item_flag,A.Create_user_id,A.Creation_date,CONCAT(First_name," ",Last_name) as Full_name');
		$this->db->select('A.*,CONCAT(First_name," ",Last_name) as Full_name,Partner_redemption_ratio');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as B','A.Merchandize_category_id=B.Merchandize_category_id');
		$this->db->join('igain_partner_master as C','A.Partner_id=C.Partner_id');
		$this->db->join('igain_enrollment_master as E','A.Seller_id=E.Enrollement_id');
		$this->db->where(array('A.Active_flag'=>$Active_flag,'A.Company_id'=>$Company_id));
		//$this->db->limit($limit,$start);
		$this->db->order_by('Company_merchandise_item_id','desc');

		$sql=$this->db->get();
		// echo $this->db->last_query();
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
	function Get_Merchandize_Items_partner_update($Partner_id,$Company_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->where(array('A.Partner_id'=>$Partner_id,'A.Company_id'=>$Company_id,'A.Active_flag'=>1));

		$sql=$this->db->get();
		// echo $this->db->last_query();
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
		function Get_Merchandize_Items_Count($Company_id,$Active_flag)
	{
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>$Active_flag,'Company_id'=>$Company_id));
		$sql=$this->db->get();
		
			return $sql->num_rows();
	}
	
		function Check_Merchandize_Item_Code($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandize_item_code'=>$Company_merchandize_item_code));
		$sql=$this->db->get();
		//echo $this->db->last_query();die;
		return $sql->num_rows();
	}
	
	function Insert_Merchandize_Item_branches($Post_data)
	{
		$this->db->insert('igain_merchandize_item_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}	
		
	}
		function Get_Partners_Branches($Partner_id)
	{
		$this->db->select('Branch_id,Branch_code,Branch_name');
		$this->db->from('igain_branch_master as B');
		$this->db->where(array('B.Active_flag'=>1,'B.Partner_id'=>$Partner_id));
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
	
	function InActive_Merchandize_Item($Company_merchandise_item_id,$Update_user_id,$Update_date)
	{
		$this->db->where("Company_merchandise_item_id",$Company_merchandise_item_id);
		$this->db->update('igain_company_merchandise_catalogue',array('Active_flag'=>0,' Update_User_id'=>$Update_user_id,'Update_date'=>$Update_date));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	/*
	function Delete_Merchandize_Item($Company_merchandise_item_id)
	{
		$this->db->where("Company_merchandise_item_id",$Company_merchandise_item_id);
		$this->db->delete('igain_company_merchandise_catalogue');
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	*/
	function Get_Merchandize_Item_details($Company_merchandise_item_id)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_merchandise_item_id'=>$Company_merchandise_item_id));
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
	
	function Get_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('A.Branch_code,B.Branch_name');
		$this->db->from('igain_merchandize_item_child as A');
		$this->db->join('igain_branch_master as B','A.Branch_code=B.Branch_code');
		$this->db->where(array('A.Merchandize_item_code'=>$Company_merchandize_item_code,'A.Company_id'=>$Company_id,'B.Company_id'=>$Company_id));
		$sql=$this->db->get();
		//echo $this->db->last_query();
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
	
	function Update_Merchandize_Item($Company_merchandise_item_id,$Post_data)
	{
		$this->db->where("Company_merchandise_item_id",$Company_merchandise_item_id);
		$this->db->update('igain_company_merchandise_catalogue',$Post_data);
		 // echo "<br><br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function Delete_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Merchandize_item_code'=>$Company_merchandize_item_code,'Company_id'=>$Company_id));
		$this->db->delete("igain_merchandize_item_child");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function Get_Product_groups($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_product_group_master');
		$this->db->where(array('Company_id'=>$Company_id ,'Active_flag' => 1));
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
		
	function Get_Product_Brands($Product_group_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_product_brand_master');
		$this->db->where(array('Company_id'=>$Company_id,'Product_group_id'=>$Product_group_id));
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
	
			/**************************************************Create Merchandize Items End*************************************/
			/**************************************************Validate e-voucher start*************************************/
	function validate_evoucher($Membership_id,$Company_id,$evoucher)
	{
		$this->db->select('Card_id,Enrollement_id,Item_code,Voucher_no,Voucher_status,A.Merchandize_Partner_id,A.Merchandize_Partner_branch,A.Quantity,A.Redeem_points,Trans_date,A.Company_id,Merchandize_item_name,C.Branch_name,Address,A.Update_date,A.Seller');
		$this->db->from('igain_transaction as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Item_code=B.Company_merchandize_item_code');
		$this->db->join('igain_branch_master as C','A.Merchandize_Partner_branch=C.Branch_code');
		$this->db->where(array('Card_id' =>$Membership_id,'A.Company_id' => $Company_id,'B.Company_id' => $Company_id,'C.Company_id' => $Company_id,'Voucher_no' => $evoucher));
		//echo "dsdas".$this->db->last_query();
		$sql51 = $this->db->get();
		return $sql51 ->row();
		
	}
	public function redemtion_fulfillment($limit,$start,$Logged_user_id,$Super_seller,$MPartner_id,$Company_id)
	{ 
		$this->db->select('Trans_id,A.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Quantity,Voucher_no,Voucher_status,B.Redeem_points,B.Update_date,Trans_date');

		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
		$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
		$this->db->where(array('C.Company_id' => $Company_id,'B.Update_User_id <>' => 0,'B.Trans_type' => 10));
		if($Logged_user_id == 5)
		{
			$this->db->where(array('A.Company_id' => $Company_id, 'B.Seller' => $MPartner_id));
		}
		else
		{
			$this->db->where(array('A.Company_id' => $Company_id));
		}
		//$this->db->group_by('B.Bill_no');
		
		$this->db->order_by('B.Update_date','DESC');
		//$this->db->limit($limit,$start);
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
	function Update_eVoucher_Status($MembershipID,$CompanyId,$evoucher,$Update_User_id,$Voucher_status)
	{
		$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Voucher_status"=>$Voucher_status,
		"Update_User_id"=>$Update_User_id,
		"Update_date"=>$Update_date
		);
		$this->db->where('Voucher_no',$evoucher);
		 $this->db->where('Card_id',$MembershipID);
		$this->db->where('Company_id' , $CompanyId);
		$this->db->update("igain_transaction",$data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Update_RVoucher_Status($MembershipID,$Company_id,$Voucher_no,$Update_User_id)
	{
		$Update_date=date("Y-m-d H:i:s");
		
		$data=array(
		"Card_balance"=>0,
		"Update_user_id"=>$Update_User_id,
		"Update_date"=>$Update_date
		);
		
		$this->db->where(array('Company_id'=>$Company_id,'Gift_card_id'=>$Voucher_no,'Card_id'=>$MembershipID,'Payment_Type_id'=>998));
		$this->db->update("igain_giftcard_tbl",$data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Update_balance($data,$Enrollement_id,$Company_id)
	{	
		$this->db->where('Enrollement_id', $Enrollement_id, 'Company_id', $Company_id); 
		$this->db->update('igain_enrollment_master', $data); 
		return true;
	}
	function Get_unused_evouchers_details($MembershipID,$CompanyId)
	{
	
		$Country_id = $this->Igain_model->get_country($CompanyId);					
		$dial_code = $this->Igain_model->get_dial_code($Country_id);					
		$phnumber = $dial_code.$MembershipID;
		
		$this->db->select('Trans_id,B.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,Voucher_status,B.Redeem_points,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,D.Branch_name,D.Address AS Branch_Address,CONCAT(First_name," ",Last_name) as Full_name,pinno');
		$this->db->from('igain_transaction as B');
		$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
		$this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id');
		$this->db->join('igain_enrollment_master as E','B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id');
		$this->db->where('(B.Card_id="'.$MembershipID.'" OR E.Phone_no="'.$phnumber.'")');
		$this->db->where(array('B.Company_id'=>$CompanyId,'B.Trans_type'=>10,'B.Voucher_status'=>30,'B.Delivery_method'=>28));
		
		$this->db->order_by('Trans_date','desc');
		$sql=$this->db->get();
		// echo $this->db->last_query();
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
	function Get_unused_Rvouchers_details($MembershipID,$CompanyId,$Partner_id)
	{
		$Country_id = $this->Igain_model->get_country($CompanyId);					
		$dial_code = $this->Igain_model->get_dial_code($Country_id);					
		$phnumber = $dial_code.$MembershipID;	
		
		$today = date("Y-m-d");
	
		$this->db->select("igain_giftcard_tbl.Gift_card_id,igain_giftcard_tbl.Card_value,igain_giftcard_tbl.Card_balance,igain_giftcard_tbl.Valid_till,igain_giftcard_tbl.Discount_percentage,igain_giftcard_tbl.Card_id,B.Cost_price,B.Cost_in_points,B.Voucher_code,B.Enrollement_id,C.Voucher_name,C.Voucher_description");
		$this->db->join('igain_company_send_voucher as B','igain_giftcard_tbl.Gift_card_id = B.Voucher_code');
		$this->db->join('igain_company_voucher_catalogue as C','B.Voucher_id = C.Voucher_id');
		
		// 'igain_giftcard_tbl.Card_id' => $Card_id,
		
		$this->db->where(array('igain_giftcard_tbl.Company_id' => $CompanyId,'igain_giftcard_tbl.Payment_Type_id' => '998','B.Voucher_type' => '1','C.Partner_id' => $Partner_id));		
		
		$this->db->where('(igain_giftcard_tbl.Card_id="'.$MembershipID.'" OR igain_giftcard_tbl.Card_id="'.$phnumber.'")');
		
		$this->db->where(array('igain_giftcard_tbl.Card_balance >' => '0','igain_giftcard_tbl.Valid_till >=' => $today));
		
		$query = $this->db->get('igain_giftcard_tbl');			
		
		if($query -> num_rows() > 0)
		{
			// return $query->result_array();
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
	function check_card_id($cardid,$Company_id)
	{
		$query =  $this->db->select('Enrollement_id,Card_id,First_name,Last_name,User_email_id,Phone_no')
				   ->from('igain_enrollment_master')
				   ->where(array('Card_id' => $cardid, 'User_activated' => '1', 'Company_id' => $Company_id))->get();
		// return $query->num_rows();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
			/**************************************************Validate e-voucher end*************************************/
			/*******************Update_order_status AMIT 22-02-2017************************************/
	function Get_Online_Purchase_orders_details($MembershipID,$CompanyId)
	{
	
		$Country_id = $this->Igain_model->get_country($CompanyId);					
		$dial_code = $this->Igain_model->get_dial_code($Country_id);					
		$phnumber = $dial_code.$MembershipID;
		
		$this->db->select('Trans_id,B.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,Voucher_status,B.Redeem_points,Purchase_amount,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,D.Branch_name,D.Address AS Branch_Address,CONCAT(First_name," ",Last_name) as Full_name,pinno,Current_balance,Loyalty_pts,balance_to_pay');
		$this->db->from('igain_transaction as B');
		$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
		$this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id');
		$this->db->join('igain_enrollment_master as E','B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id');
		$this->db->where('(B.Card_id="'.$MembershipID.'" OR E.Phone_no="'.$phnumber.'")');
		$this->db->where(array('B.Company_id'=>$CompanyId,'Trans_type'=>12,'Voucher_status'=>18));
		
		$this->db->order_by('Trans_date','desc');
		$sql=$this->db->get();
		//echo $this->db->last_query();
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
	function Update_online_purchase_item($Item_id,$Voucher_status,$Update_User_id)
	{
		$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Voucher_status"=>$Voucher_status,
		"Update_date"=>$Update_date,
		"Update_User_id"=>$Update_User_id
		);
		$this->db->where('Trans_id' , $Item_id);
		$this->db->update("igain_transaction",$data);
		echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Update_online_purchase_cancel_item_points($Cust_Enrollement_id,$Credit_points,$Update_User_id)
	{
		$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Current_balance"=>$Credit_points,
		"Update_date"=>$Update_date,
		"Update_User_id"=>$Update_User_id
		);
		$this->db->where('Enrollement_id' , $Cust_Enrollement_id);
		$this->db->update("igain_enrollment_master",$data);
		echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
		function Insert_purchase_return_trans($Post_data)
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
	/*******************Update_order_status AMIT 22-02-2017 end************************************/ 
	/*******************AMIT 18-12-2017 ************************************/ 
	function Get_Bulk_evouchers_details($CompanyId,$Merchandize_Partner_ID)
	{
		$this->db->select('Trans_id,B.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,Voucher_status,B.Redeem_points,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,B.Quantity_balance,First_name,Last_name,Photograph,Merchandise_item_description,Valid_from,Valid_till');
		$this->db->from('igain_transaction as B');
		$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
		// $this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id');
		$this->db->join('igain_enrollment_master as E','B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id');
		$this->db->where(array('B.Company_id'=>$CompanyId,'B.Merchandize_Partner_id'=>$Merchandize_Partner_ID,'Trans_type'=>10));
		
		$this->db->order_by('Trans_date','desc');
		$sql=$this->db->get();
		// echo $this->db->last_query();
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
	function Get_Updated_Bulk_evouchers_details($CompanyId,$Merchandize_Partner_ID,$limit,$start)
	{
		$this->db->select('B.Update_date,B.Updated_quantity,B.Voucher_no,First_name,Last_name,Merchandize_item_name,Thumbnail_image1');
		$this->db->from('igain_update_evoucher_status as B');
		$this->db->join('igain_transaction as T','T.Voucher_no=B.Voucher_no AND T.Company_id=B.CompanyId AND B.MembershipID=T.Card_id');
		$this->db->join('igain_company_merchandise_catalogue as C','T.Item_code=C.Company_merchandize_item_code AND T.Company_id=C.Company_id');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id AND T.Company_id=E.Company_id AND T.Card_id=E.Card_id');
		$this->db->where(array('B.CompanyId'=>$CompanyId,'T.Merchandize_Partner_id'=>$Merchandize_Partner_ID));
		
		//$this->db->limit($limit,$start);
		$this->db->order_by('B.Update_date','desc');
		$sql=$this->db->get();
		 // echo $this->db->last_query();
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
	
		function Update_Bulk_eVoucher_Status($MembershipID,$CompanyId,$evoucher,$Update_User_id,$Quantity_balance,$Trans_id,$Update_QTY)
	{
		$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Quantity_balance"=>$Quantity_balance,
		"Voucher_status"=>31,
		"Update_User_id"=>$Update_User_id,
		"Update_date"=>$Update_date
		);
		$this->db->where('Trans_id' , $Trans_id);
		$this->db->update("igain_transaction",$data);
		
		$Post_data=array(
		"CompanyId"=>$CompanyId,
		"MembershipID"=>$MembershipID,
		"Voucher_no"=>$evoucher,
		"Updated_quantity"=>$Update_QTY,
		"Update_User_id"=>$Update_User_id,
		"Update_date"=>$Update_date
		);
		$this->db->insert('igain_update_evoucher_status',$Post_data);
		
		// echo $this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	/*******************AMIT 18-12-2017 end************************************/ 
	/*******************AMIT 13-02-2018 start************************************/ 
	function Get_Partner_linked_Merchandize_Items($Partner_id,$Super_seller,$Seller_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_partner_master as C','A.Partner_id=C.Partner_id');
		
		if($Super_seller==1)
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Partner_id'=>$Partner_id));
		}
		else
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Partner_id'=>$Partner_id,'A.Seller_id'=>$Seller_id));
		}
		$sql=$this->db->get();
		// echo "<br><br>Get_Partner_linked_Merchandize_Items<br>".$this->db->last_query();//die;
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
	function Get_Merchant_linked_Merchandize_Items($Seller_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_enrollment_master as E','A.Seller_id=E.Enrollement_id');
		$this->db->where(array('A.Active_flag'=>1,'A.Seller_id'=>$Seller_id));
		
		$sql=$this->db->get();
		  // echo "<br><br>Get_Partner_linked_Merchandize_Items<br>".$this->db->last_query();die;
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
	function Get_Category_linked_Merchandize_Items($Merchandize_category_id,$Super_seller,$Seller_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as C','A.Merchandize_category_id=C.Merchandize_category_id');
		if($Super_seller==1)
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Merchandize_category_id'=>$Merchandize_category_id));
		}
		else
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Seller_id'=>$Seller_id));
		}	
		
		$sql=$this->db->get();
		// echo "<br><br>Get_Category_linked_Merchandize_Items<br>".$this->db->last_query();//die;
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
	function Get_Searched_Merchandize_Items($Item,$Company_id,$Super_seller,$Seller_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		
		
		if($Super_seller==1)
		{
			$this->db->where("Company_merchandize_item_code like '%".$Item."%' AND Active_flag=1 AND Company_id=$Company_id");
		}
		else
		{
			$this->db->where("Company_merchandize_item_code like '%".$Item."%' AND Active_flag=1 AND Company_id=$Company_id AND Seller_id=$Seller_id");
		}
		$this->db->or_where("Merchandize_item_name like '%".$Item."%' AND Active_flag=1 AND Company_id=$Company_id");
		$sql=$this->db->get();
		 // echo "<br><br>Get_Searched_Merchandize_Items<br>".$this->db->last_query();//die;
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
	public function delete_linked_Branch_cart_item($Item_code,$Company_id,$Branch_code)
	{
		$this->db->delete('igain_temp_cart',array('Item_code'=>$Item_code,'Company_id'=>$Company_id,'Branch'=>$Branch_code));
		  // echo "<br><br>delete_linked_cart_item<br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
			
	}
	public function delete_linked_cart_item($Item_code,$Company_id)
	{
		$this->db->delete('igain_temp_cart',array('Item_code'=>$Item_code,'Company_id'=>$Company_id));
		  // echo "<br><br>delete_linked_cart_item<br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
			
	}
	
	function Get_Tier_linked_Merchandize_Items($TierID,$Company_id)
	{
		$this->db->select('C.*');
		$this->db->from('igain_merchandize_item_tier_child as A');
		$this->db->join('igain_company_merchandise_catalogue as C','A.Merchandize_item_code=C.Company_merchandize_item_code AND A.Company_id=C.Company_id');
		$this->db->where(array('C.Active_flag'=>1,'A.Tier_id'=>$TierID,'A.Company_id'=>$Company_id));
		
		$sql=$this->db->get();
		   // echo "<br><br>Get_Tier_linked_Merchandize_Items<br>".$this->db->last_query();//die;
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
	function Get_Branch_linked_Merchandize_Items($Branch_code,$Company_id)
	{
		$this->db->select('C.*');
		$this->db->from('igain_merchandize_item_child as A');
		$this->db->join('igain_company_merchandise_catalogue as C','A.Merchandize_item_code=C.Company_merchandize_item_code AND A.Company_id=C.Company_id AND A.Partner_id=C.Partner_id');
		$this->db->where(array('C.Active_flag'=>1,'A.Branch_code'=>$Branch_code,'A.Company_id'=>$Company_id));
		
		$sql=$this->db->get();
		  // echo "<br><br>Get_Branch_linked_Merchandize_Items<br>".$this->db->last_query();//die;
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
	function Delete_Merchandize_Partners_Tier_linked_item($Merchandize_item_code,$Company_id,$Tier_id)
	{
		$this->db->where("Company_id",$Company_id);
		$this->db->where("Merchandize_item_code",$Merchandize_item_code);
		$this->db->where("Tier_id",$Tier_id);
		$this->db->delete('igain_merchandize_item_tier_child');
		 // echo "<br><br>Delete_Merchandize_Partners_Tier_linked_item<br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Delete_Merchandize_Partners_Branch_linked_item($Merchandize_item_code,$Company_id,$Branch_code)
	{
		$this->db->where("Company_id",$Company_id);
		$this->db->where("Merchandize_item_code",$Merchandize_item_code);
		$this->db->where("Branch_code",$Branch_code);
		$this->db->delete('igain_merchandize_item_child');
		// echo "<br><br>Delete_Merchandize_Partners_Branch_linked_item<br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Check_linked_item_branches_count($Merchandize_item_code,$Company_id)
	{
		 $this->db->select("COUNT(*)");
		$this->db->where('Merchandize_item_code',$Merchandize_item_code);
		$this->db->where('Company_id',$Company_id);
		 $query = $this->db->get('igain_merchandize_item_child');
		 $result = $query->row_array();
		  // echo "<br><br>Check_linked_item_branches_count<br>".$this->db->last_query();//die;
		return	$count2 = $result['COUNT(*)']; 
	}
	function Check_linked_item_tiers_count($Merchandize_item_code,$Company_id)
	{
		 $this->db->select("COUNT(*)");
		$this->db->where('Merchandize_item_code',$Merchandize_item_code);
		$this->db->where('Company_id',$Company_id);
		 $query = $this->db->get('igain_merchandize_item_tier_child');
		 $result = $query->row_array();
		  // echo "<br><br>Check_linked_item_tiers_count<br>".$this->db->last_query();//die;
		return	$count2 = $result['COUNT(*)']; 
	}
	
	public function delete_linked_cart_item_branch($Branch_code,$Company_id)
	{
		$this->db->delete('igain_temp_cart',array('Branch'=>$Branch_code,'Company_id'=>$Company_id));
		  // echo "<br><br>delete_linked_cart_item_branch<br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
			
	}
	
	/*******************AMIT 13-02-2018 end************************************/ 
	/*******************Ravi 26-07-2018 Start************************************/ 
	function get_company_parent_category($Company_id)
	{
		$this->db->select('Merchandize_category_id,Merchandize_category_name');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Parent_category_id'=>0,'Active_flag'=>1,'Company_id'=>$Company_id));
		$this->db->order_by('Merchandize_category_id','ASC');
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
	function Get_Merchandize_Parent_Category_details($lv_Merchandize_category_id)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Parent_category_id'=>$lv_Merchandize_category_id));
		$sql=$this->db->get();
		// echo"<br>----".$this->db->last_query();
		/* if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		} */

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
	function Check_merchandize_category($Merchandize_category_name,$Company_id)
	{	 	 
		$query =  $this->db->select('Merchandize_category_name')
	    ->from('igain_merchandize_category')
	    ->where(array('Merchandize_category_name' => $Merchandize_category_name,'Company_id' => $Company_id))->get();
		
		// echo $this->db->last_query();	   
		return $query->num_rows();
	}
	/*******************Ravi 26-07-2018 End************************************/ 
	
	//****************** sandeep 14-08-2019 ******************************
	function check_phone_email($Phone_no,$EmailId,$Company_id)
	{

	   if($Phone_no != "" && $Phone_no > 0 && is_numeric($Phone_no)){
		   $this->db->select('Partner_id')
			->from('igain_partner_master')
			->where(array('Partner_contact_person_phno' => $Phone_no, 'Company_id' => $Company_id));
			$query=$this->db->get();
	   }

		if(is_string($EmailId) && $EmailId != ""){
			$this->db->select('Partner_id')
			->from('igain_partner_master')
			->where(array('Partner_contact_person_email' => $EmailId, 'Company_id' => $Company_id));
			$query=$this->db->get();
		}
		
				
		return $query->num_rows();
	}
	
	//****************** sandeep 14-08-2019 ******************************
	/********************nilesh start 17-01-2020***************************/
	function Get_order_member_info($Order_no,$CompanyId)
	{ 
		$this->db->select('B.Card_id,User_email_id,CONCAT(First_name," ",Last_name) as Full_name,Phone_no,SUM(B.Purchase_amount+Shipping_cost) as Bill_amount,SUM(B.Mpesa_Paid_Amount) as Paid_amount,SUM(B.COD_Amount) as Amount_due');
		$this->db->from('igain_transaction as B');
		$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id AND C.Active_flag = 1','LEFT');
		$this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id','LEFT');
		$this->db->join('igain_enrollment_master as E','B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id','LEFT');
		$this->db->join('igain_codedecode_master as CD','B.Voucher_status=CD.Code_decode_id','LEFT');
		
		$this->db->where('(B.Bill_no="'.$Order_no.'" OR B.Manual_billno="'.$Order_no.'")');
		$this->db->where(array('B.Company_id'=>$CompanyId,'B.Trans_type'=>12));
		$this->db->where("B.Voucher_status IN('18','19')");
		$this->db->order_by('Trans_date','desc');
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
	function Get_order_evouchers_details($Order_no,$CompanyId)
	{ 
		$this->db->select('Trans_id,B.Card_id,Bill_no,Manual_billno,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,CD.Code_decode,Voucher_status,B.Redeem_points,B.Purchase_amount,B.Shipping_cost,B.Loyalty_pts,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,D.Branch_name,D.Address AS Branch_Address,CONCAT(First_name," ",Last_name) as Full_name,pinno,B.remark2 as Condiments_name,B.Delivery_method as Order_type');
		$this->db->from('igain_transaction as B');
		$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id AND C.Active_flag =1','LEFT');
		$this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id','LEFT');
		$this->db->join('igain_enrollment_master as E','B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id','LEFT');
		$this->db->join('igain_codedecode_master as CD','B.Voucher_status=CD.Code_decode_id','LEFT');
		// $this->db->where('(B.Card_id="'.$MembershipID.'" OR E.Phone_no="'.$phnumber.'")');
		$this->db->where('(B.Bill_no="'.$Order_no.'" OR B.Manual_billno="'.$Order_no.'")');
		$this->db->where(array('B.Company_id'=>$CompanyId,'B.Trans_type'=>12));
		$this->db->where("B.Voucher_status IN('18','19')");
		$this->db->order_by('Trans_date','desc');
		$sql=$this->db->get();
		// echo $this->db->last_query();
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
	function Update_Order_Status($data1,$Membership_id,$Company_id,$Trans_id,$Order_no)
	{
		$this->db->where(array('Company_id' => $Company_id, 'Trans_id' => $Trans_id, 'Card_id' => $Membership_id, 'Bill_no' => $Order_no));
		$this->db->update("igain_transaction",$data1);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	/********************nilesh end 17-01-2020***************************/
	
		
	//******* sandeep 26-05-2020 *************
	
	function get_offer_menu_groups($seller_id,$Company_id,$show_item)
	{
	
		$this->db->select('DISTINCT(A.Merchandize_category_id),A.Merchandize_category_name,A.Category_order,A.Icon,B.show_item');
		$this->db->from('igain_merchandize_category as A');
		$this->db->join('igain_company_merchandise_catalogue as B',"A.Merchandize_category_id = B.Merchandize_category_id","LEFT");
		$this->db->where(array("A.Active_flag" => 1, "A.Company_id" => $Company_id ));
		
		
		if($show_item > 0)
		{
			$this->db->where(array("B.show_item" =>$show_item ));
		}
		if($seller_id > 0)
		{
			$this->db->where(array("A.Seller_id" =>$seller_id ));
		}
		
		$sql88 = $this->db->get();
		//echo $this->db->last_query();
		if($sql88 != null)
		{
			return $sql88->result_array();
		}
	}
	
	function set_category_order_icon($Company_id,$SequenceNo,$Item_image,$CategorieID)
	{
	//	echo $Company_id."--".$SequenceNo."--".$Item_image."--".$CategorieID."--";
		
		$update_data20['Category_order'] = $SequenceNo;
		
		if($Item_image != null)
		{
			$update_data20['Icon'] = $Item_image;
		}
		
		$this->db->where(array('Company_id'=>$Company_id,'Merchandize_category_id'=>$CategorieID));
		$this->db->update("igain_merchandize_category",$update_data20);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
	}
	//******* sandeep 26-05-2020 *************
	function get_partner_details($Partner_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_partner_master');
		$this->db->where('Partner_id', $Partner_id,'Company_id', $Company_id);
		
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
 }
?>