<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coal_Catelogue_model extends CI_Model
 {
	 
	 
	 

			/******************************Create Alkwarm Merchandize Items Start******************/
	function Insert_Merchandize_Item_Size($Post_data)
	{
		$this->db->insert('igain_merchandize_item_size_child',$Post_data);
		//echo $this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}	
		
	}
	function Insert_Merchandize_Item_Size_LOG($Post_data)
	{
		$this->db->insert('igain_merchandize_item_size_child_LOG',$Post_data);
		//echo $this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}	
		
	}
	
		function Get_Merchandize_Item_Size_info($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('Item_id,Item_size,A.Company_merchandize_item_code,A.Cost_price,A.Billing_price,A.Billing_price_in_points,A.Cost_payable_to_partner,B.Seller_Redemptionratio,A.Item_weight,A.Item_Dimension,A.Weight_unit_id');
		$this->db->from('igain_merchandize_item_size_child as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Company_merchandize_item_code=B.Company_merchandize_item_code');
		$this->db->where(array('A.Company_merchandize_item_code'=>$Company_merchandize_item_code,'A.Company_id'=>$Company_id,'B.Company_id'=>$Company_id));
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
	function Delete_Merchandize_Item_Size_info($Company_merchandize_item_code,$Company_id)
	{
		$this->db->where(array('Company_merchandize_item_code'=>$Company_merchandize_item_code,'Company_id'=>$Company_id));
		$this->db->delete("igain_merchandize_item_size_child");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
			/******************************Create Merchandize Items Start*************************************/
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
			return true;
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
	
	function Get_Merchandize_Items($limit,$start,$Company_id,$Active_flag,$Super_seller,$Seller_id)
	{
		$this->db->select('Valid_from,Valid_till,show_item,Company_merchandise_item_id,Merchandize_item_name,Company_merchandize_item_code,Merchandize_category_name,Partner_name,,A.Create_user_id,A.Creation_date,Size_flag,A.Seller_Redemptionratio,Merchant_flag,A.Merchandize_category_id');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as B','A.Merchandize_category_id=B.Merchandize_category_id');
		
		$this->db->join('igain_partner_master as C','A.Partner_id=C.Partner_id');
		if($Super_seller==1)
		{
			$this->db->where(array('A.Active_flag'=>$Active_flag,'A.Company_id'=>$Company_id));
		}
		else
		{
			$this->db->join('igain_enrollment_master as IE','IE.Enrollement_id=A.Seller_id');
			$this->db->where(array('A.Active_flag'=>$Active_flag,'A.Company_id'=>$Company_id,'A.Seller_id'=>$Seller_id));
		}
		$this->db->where(array('Billing_price_in_points > '=>0,'Merchandize_item_type != '=>117));
		// $this->db->limit($limit,$start);
		$this->db->order_by('Company_merchandise_item_id','desc');
		$sql=$this->db->get();
		// echo "****".$this->db->last_query();
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
	function Insert_Merchandize_Item_tiers($Post_data)
	{
		$this->load->dbforge();
		/*if( $this->db->table_exists($temp_table) == TRUE )
			{
				$this->dbforge->drop_table($temp_table);
			}*/
			
		$temp_table='igain_merchandize_item_tier_child';
		if( $this->db->table_exists($temp_table) != TRUE )
		{
			$fields = array(
							'ID' => array('type' => 'int','constraint' => '11','auto_increment' => TRUE),
							'Company_id' => array('type' => 'int','constraint' => '11'),
							'Merchandize_item_code' => array('type' => 'VARCHAR','constraint' => '50'),
							'Tier_id' => array('type' => 'int','constraint' => '11'),
						);
			$this->dbforge->add_key('ID', TRUE);			
			$this->dbforge->add_field($fields);		
			$this->dbforge->create_table($temp_table);
		}	
		$this->db->insert($temp_table,$Post_data);
		//echo $this->db->last_query();
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
		$this->db->from('igain_company_merchandise_catalogue as A');
		// $this->db->join('igain_merchandize_item_size_child AS B','B.Company_merchandize_item_code=A.Company_merchandize_item_code AND A.Company_id=B.Company_id');
		$this->db->join('igain_codedecode_master as B','A.Merchandize_item_type=B.Code_decode_id','left');
		$this->db->where(array('A.Company_merchandise_item_id'=>$Company_merchandise_item_id));
		$sql=$this->db->get();
		//echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			return $sql->row();
			/* foreach ($sql->result() as $row)
			{
                $data[] = $row;
            }
            return $data; */
		}
		else
		{
			return false;
		}	
		
	}
	
	function Get_Merchandize_Item_Tiers($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_item_tier_child as A');
		$this->db->join('igain_tier_master as B','A.Tier_id=B.Tier_id');
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
		//echo $this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function Delete_Merchandize_Item_Tiers($Company_merchandize_item_code,$Company_id)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Merchandize_item_code'=>$Company_merchandize_item_code,'Company_id'=>$Company_id));
		$this->db->delete("igain_merchandize_item_tier_child");
		// echo $this->db->last_query();
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
		//$this->db->where(array('Company_id'=>$Company_id));
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
	/*****************Quantity descirption amit 11-1-2018*******/
	function Insert_Merchandize_Item_Quantity_child($Post_data)
	{
		$this->db->insert('igain_merchandize_quantity_child',$Post_data);
		//echo $this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}	
		
	}
		function Get_Quantity_child_details($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_quantity_child');
		$this->db->where(array('Company_id'=>$Company_id,'Merchandize_item_code'=>$Company_merchandize_item_code));
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
	function Update_Merchandize_Item_Quantity_child($Post_data_qty,$Slab_no,$Company_merchandize_item_code,$Company_id)
	{
		$this->db->where("Merchandize_item_code",$Company_merchandize_item_code);
		$this->db->where("Slab_no",$Slab_no);
		$this->db->where("Company_id",$Company_id);
		$this->db->update('igain_merchandize_quantity_child',$Post_data_qty);
		echo "<br>".$this->db->last_query();//die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Delete_Merchandize_Item_Quantity_child($Company_merchandize_item_code,$Company_id)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Merchandize_item_code'=>$Company_merchandize_item_code,'Company_id'=>$Company_id));
		$this->db->delete("igain_merchandize_quantity_child");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	/*****************Quantity descirption amit 11-1-2018* XXX******/
	function Get_Merchandise_items_type($Code_decode_type_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master');
		$this->db->where(array('Code_decode_type_id'=>$Code_decode_type_id));
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
 }
?>
