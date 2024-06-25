<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class POS_catalogue_model extends CI_Model
{

	//********************* sandeep work *****************************

	function insert_required_optional_condiments()
	{
		$itemCodes = $this->input->post("Condiment_item_code");
		
		foreach($itemCodes as $v)
		{
			$DataPOST = array(
					"Company_id" => $this->input->post("Company_id"),
					"Seller_id" => $this->input->post("seller_id"),
					"Condiment_type" => $this->input->post("Condiment_type"),
					"Active_flag" => 1,
					"Group_code" => $this->input->post("Group_code"),
					"Group_name" => $this->input->post("Group_name"),
					"Label" => $this->input->post("Label"),
					"Menu_group_id" => $this->input->post("Menu_group_id"),
					"Condiment_item_code" => $v
				);
				
			$this->db->insert("igain_pos_item_req_opt_group_child",$DataPOST);	
		}

		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	

	function delete_requOptional_condiments($groupCode,$Company_id){
		
		$this->db->where(array( 'Group_code' => $groupCode,'Company_id' =>$Company_id )); 
		$this->db->update("igain_pos_item_req_opt_group_child",array("Active_flag"=>0));
	}
	
	function update_required_optional_condiments($groupCode,$Company_id)
	{
		$this->db->delete("igain_pos_item_req_opt_group_child",array( 'Group_code' => $groupCode,'Company_id' =>$Company_id ));

		
		$itemCodes = $this->input->post("Condiment_item_code");
		
		foreach($itemCodes as $v)
		{
			$DataPOST = array(
					"Company_id" => $this->input->post("Company_id"),
					"Seller_id" => $this->input->post("seller_id"),
					"Condiment_type" => $this->input->post("Condiment_type"),
					"Active_flag" => 1,
					"Group_code" => $groupCode,
					"Group_name" => $this->input->post("Group_name"),
					"Label" => $this->input->post("Label"),
					"Menu_group_id" => $this->input->post("Menu_group_id"),
					"Condiment_item_code" => $v
				);
				
			$this->db->insert("igain_pos_item_req_opt_group_child",$DataPOST);	
		}

		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function get_required_optional_condiments($limit,$start,$Company_id,$Group_code)
	{
		$this->db->select("A.*,B.Merchandize_item_name, CONCAT(First_name,' ',Last_name) as Full_name");
		$this->db->from("igain_pos_item_req_opt_group_child as A");
		$this->db->join("igain_company_merchandise_catalogue as B","A.Condiment_item_code = B.Company_merchandize_item_code");
		$this->db->join('igain_enrollment_master as E','A.Seller_id=E.Enrollement_id');
		
		if($Group_code != NULL){ 
			$this->db->where(array( 'A.Active_flag' => 1,'A.Group_code' => $Group_code,'A.Company_id' =>$Company_id )); 
			}else{
			$this->db->where(array( 'A.Company_id' =>$Company_id,'A.Active_flag' => 1 ));
		}
		
		 /* if($limit != NULL || $start != NULL){
			  $this->db->limit($limit,$start);
		  }	 */
		  
		$res11 = $this->db->get();
		//echo $this->db->last_query();
		
		if($res11->num_rows() > 0)
		{
			foreach($res11->result() as $rowsd)
			{
				$data[] = $rowsd;
			}
		   
		   return $data;
		}
		  
		  return false;		
	}
	
	//********************* sandeep work *****************************
	
	/***********************************AMIT KAMBLE 06-11-2019************************/
	public function Get_Code_decode_master($Code_decode_type_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_type_id',$Code_decode_type_id);
		$this->db->order_by('Code_decode_id','DESC');
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
   public function Get_Specific_Code_decode_master($Code_decode_id)
	{
		$this->db->select('Code_decode');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_id',$Code_decode_id);
		
		$query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
        	/* foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; */
			return $query->row();
        }
        return false;
   }
   	function Get_Link_Side_Group_Items($Merchandize_category_id,$Company_id)
	{
		$this->db->select('A.Merchandize_category_id,Company_merchandize_item_code,Merchandize_item_name,C.Merchandize_category_name');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as C','A.Merchandize_category_id=C.Merchandize_category_id');
		
		$this->db->where(array('A.Active_flag'=>1,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Company_id'=>$Company_id,'A.Merchandize_item_type <>' => 118));
		
		
		$sql=$this->db->get();
		 // echo "<br><br><br>".$this->db->last_query();//die;
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
   	function Get_cond_group_values($Group_code,$Condiment_type,$Company_id)
	{
		$this->db->select('Group_code,Group_name,Label,Condiment_item_code,Merchandize_item_name');
		$this->db->from('igain_pos_item_req_opt_group_child as A');
		$this->db->join('igain_company_merchandise_catalogue as C','A.Condiment_item_code=C.Company_merchandize_item_code AND A.Company_id=C.Company_id');
		
		$this->db->where(array('A.Group_code'=>$Group_code,'A.Condiment_type'=>$Condiment_type,'A.Active_flag'=>1,'C.Active_flag'=>1,'A.Company_id'=>$Company_id));
		
		
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
   	function Get_pos_side_groups_items($Company_id,$Menu_Item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_pos_item_combo_side_child as A');
		$this->db->join('igain_merchandize_category as C','A.Side_item_id=C.Merchandize_category_id AND A.Company_id=C.Company_id','left');
		$this->db->join('igain_company_merchandise_catalogue as D','A.Side_group_item_code=D.Company_merchandize_item_code AND A.Company_id=D.Company_id','left');
		
		$this->db->where(array('A.Menu_Item_code'=>$Menu_Item_code,'A.Company_id'=>$Company_id,'A.Company_id'=>$Company_id,'D.Active_flag'=>1));
		$this->db->order_by('A.ID','desc');
		
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
   	function Get_pos_main_item_combo_child($Company_id,$Menu_Item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_pos_item_combo_child as A');
		// $this->db->join('igain_merchandize_category as C','A.Side_item_id=C.Merchandize_category_id AND A.Company_id=C.Company_id','left');
		$this->db->join('igain_company_merchandise_catalogue as D','A.Main_or_side_item_code=D.Company_merchandize_item_code AND A.Company_id=D.Company_id');
		
		$this->db->where(array('A.Menu_Item_code'=>$Menu_Item_code,'A.Company_id'=>$Company_id,'D.Active_flag'=>1));
		$this->db->order_by('A.ID','desc');
		
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
   	function Get_req_opt_cond_group($Condiment_type,$Company_id,$Seller_id)
	{
		$this->db->select('Group_code,Group_name,Label,Condiment_item_code,Seller_id');
		$this->db->from('igain_pos_item_req_opt_group_child as A');
		//$this->db->join('igain_company_merchandise_catalogue as C','A.Condiment_item_code=C.Company_merchandize_item_code AND A.Company_id=C.Company_id');
		
		if($Seller_id > 0)
		{
			$this->db->where(array('A.Condiment_type'=>$Condiment_type,'A.Active_flag'=>1,'A.Company_id'=>$Company_id,'A.Seller_id'=>$Seller_id));
		}
		else{
			$this->db->where(array('A.Condiment_type'=>$Condiment_type,'A.Active_flag'=>1,'A.Company_id'=>$Company_id));
		}
		$this->db->group_by('Group_code');
		
		
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
	public function get_pos_main_item_name($keyword,$Company_id) 
	{        
		$this->db->select("Merchandize_item_name,Company_merchandize_item_code");
        $this->db->order_by('Merchandize_item_name', 'ASC');
        $this->db->like("Merchandize_item_name", $keyword);
        $this->db->or_like("Company_merchandize_item_code", $keyword);
		$this->db->where(array('Active_flag' => '1','Company_id' => $Company_id));
		 $query = $this->db->get('igain_company_merchandise_catalogue');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['Merchandize_item_name']))." : ".htmlentities(stripslashes($row['Company_merchandize_item_code']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
		
		
    }
		function Check_POS_Item($Company_merchandize_item_code,$Company_id,$Main_item_name)
	{
		$this->db->select('Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandize_item_code'=>trim($Company_merchandize_item_code),'Merchandize_item_name'=>trim($Main_item_name)));
		// $this->db->or_where(array('Merchandize_item_name'=>$Main_item_name));
		$sql=$this->db->get();
		// echo $this->db->last_query();die;
		return $sql->num_rows();
	}
	
	function Insert_pos_side_groups_items($Post_data)
	{
		$this->db->insert('igain_pos_item_combo_side_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	
	function Insert_pos_main_item_combo_child($Post_data)
	{
		$this->db->insert('igain_pos_item_combo_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	
	
	function Get_Partner_master($Company_id)
	{
		$this->db->select('Partner_id,Partner_markup_percentage,Partner_vat');
		$this->db->from('igain_partner_master');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		$sql=$this->db->get();
	 // echo "<br><br>Get_Partner_master.....".$this->db->last_query();die;
		
			return $sql->row();
	}
	
	function Insert_pos_price($Post_data)
	{
		$this->db->insert('igain_pos_item_price_child',$Post_data);
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	function Insert_pos_condiments($Post_data)
	{
		$this->db->insert('igain_item_condiments_tbl',$Post_data);
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	function Insert_pos_main_item($Post_data)
	{
		$this->db->insert('igain_pos_item_combo_child',$Post_data);
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	function Delete_side_group_child($Company_id,$Menu_Item_code,$Side_option)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Side_option'=>$Side_option,'Company_id'=>$Company_id));
		$this->db->delete("igain_pos_item_combo_side_child");
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	 
	function Delete_main_item_combo_child($Company_id,$Menu_Item_code)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Item_flag'=>'MAIN','Company_id'=>$Company_id));
		$this->db->delete("igain_pos_item_combo_child");
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	 

	 function Get_checked_pos_main_groups_items($Company_id,$Menu_Item_code,$Side_group_item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_pos_item_combo_child as A');
		
		$this->db->where(array('A.Menu_Item_code'=>$Menu_Item_code,'A.Company_id'=>$Company_id,'A.Main_or_side_item_code'=>$Side_group_item_code));
		
		$sql=$this->db->get();
		// echo "<br><br>".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			
            return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}

	 function Get_checked_pos_side_groups_items($Company_id,$Menu_Item_code,$Side_option,$Side_group_item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_pos_item_combo_side_child as A');
		
		$this->db->where(array('A.Menu_Item_code'=>$Menu_Item_code,'A.Company_id'=>$Company_id,'A.Side_option'=>$Side_option,'A.Side_group_item_code'=>$Side_group_item_code));
		
		$sql=$this->db->get();
		// echo "<br><br>".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			
            return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	public function Get_Selected_item_condiments($Item_code,$Company_id,$Require_optional)
	{
		$this->db->select('Condiment_item_code,Group_code');
		$this->db->from('igain_item_condiments_tbl as A');
		
		$this->db->where(array('A.Item_code'=>$Item_code,'A.Company_id'=>$Company_id,'A.Require_optional'=>$Require_optional));
		$query = $this->db->get();
		// echo "<br><br>".$this->db->last_query();// return $query->result_array();
        if ($query->num_rows() > 0)
		{
        	 foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; 
			// return $query->result_array();
        }
        return false;
   }
	public function Get_POS_Item_prices($Item_code,$Company_id)
	{
		$this->db->select('Pos_price,From_date,To_date,Price_Active_flag');
		$this->db->from('igain_pos_item_price_child as A');
		
		$this->db->where(array('A.Menu_Item_code'=>$Item_code,'A.Company_id'=>$Company_id,'A.Old_Price_flag'=>0));
		$query = $this->db->get();
		// echo "<br><br>".$this->db->last_query();// return $query->result_array();
        if ($query->num_rows() > 0)
		{
        	 foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; 
			// return $query->result_array();
        }
        return false;
   }
	public function Get_Combo_Main_item($Item_code,$Company_id)
	{
		$this->db->select('Item_flag,Main_or_side_item_code,Side_label,Quanity,Price');
		$this->db->from('igain_pos_item_combo_child as A');
		
		$this->db->where(array('A.Menu_Item_code'=>$Item_code,'A.Company_id'=>$Company_id,'A.Item_flag'=>'MAIN'));
		$query = $this->db->get();
		 // echo "<br><br>".$this->db->last_query();// return $query->result_array();
        if ($query->num_rows() > 0)
		{
        	 foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; 
			// return $query->result_array();
        }
        return false;
   }
	public function Get_Combo_Side_items($Item_code,$Company_id)
	{
		$this->db->select('Side_group_item_code,Side_option,Item_flag,Main_or_side_item_code,Side_label,A.Quanity,A.Price,D.Quanity as Side_group_qty,D.Price as Side_group_price');
		$this->db->from('igain_pos_item_combo_side_child as A');
		
		$this->db->join('igain_pos_item_combo_child as D','A.Menu_Item_code=D.Menu_Item_code AND A.Company_id=D.Company_id AND A.Side_item_id=D.Main_or_side_item_code');
		
		$this->db->where(array('A.Menu_Item_code'=>$Item_code,'A.Company_id'=>$Company_id,'D.Item_flag'=>'SIDE'));
		$query = $this->db->get();
		 // echo "<br><br>".$this->db->last_query();// return $query->result_array();
        if ($query->num_rows() > 0)
		{
        	 foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data; 
			// return $query->result_array();
        }
        return false;
   }
   function Delete_pos_item_combo_side($Company_id,$Menu_Item_code)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Company_id'=>$Company_id));
		$this->db->delete("igain_pos_item_combo_side_child");
		
		
		 // echo "<br><br>".$this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
   function Delete_pos_combo_child($Company_id,$Menu_Item_code,$Item_flag)
	{
		//echo "refid ".$refid;die;'Old_Price_flag'=>0,
		 $this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Company_id'=>$Company_id,'Item_flag'=>$Item_flag));
		$this->db->delete("igain_pos_item_combo_child");
		
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		} 
	}
   function Update_pos_combo_child($Company_id,$Menu_Item_code)
	{
		$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Company_id'=>$Company_id));
		$this->db->update('igain_pos_item_price_child',array('Old_Price_flag'=>1,'Price_Active_flag'=>0));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
	}
   function Delete_pos_item_cond($Company_id,$Menu_Item_code,$Require_optional)
	{
		//echo "refid ".$refid;die;
		$this->db->where(array('Item_code'=>$Menu_Item_code,'Company_id'=>$Company_id,'Require_optional'=>$Require_optional));
		$this->db->delete("igain_item_condiments_tbl");
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Get_Category_linked_POS_Items($Merchandize_category_id)
	{
		$this->db->select('Company_merchandise_item_id,Merchandize_item_name,Company_merchandize_item_code,Merchandize_item_type,Valid_from,Valid_till,Merchandize_category_name');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as C','A.Merchandize_category_id=C.Merchandize_category_id');
		
		if($Merchandize_category_id==0)//ALL
		{
			$this->db->where(array('A.Active_flag'=>1));
		}
		else
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Merchandize_category_id'=>$Merchandize_category_id));
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
	function Get_Searched_POS_Items($Item,$Company_id)
	{
		$this->db->select('Company_merchandise_item_id,Merchandize_item_name,Company_merchandize_item_code,Merchandize_item_type,Valid_from,Valid_till,Merchandize_category_name');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as C','A.Merchandize_category_id=C.Merchandize_category_id');
		$this->db->where("Company_merchandize_item_code like '%".$Item."%' AND A.Active_flag=1 AND A.Company_id=$Company_id");
		
		$this->db->or_where("Merchandize_item_name like '%".$Item."%' AND A.Active_flag=1 AND A.Company_id=$Company_id");
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
	function Get_Merchandize_Item_Condiments($Condiment_item_code)
	{
		$this->db->select('Company_merchandize_item_code,Merchandize_item_name,Merchandize_category_id');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->where(array('A.Company_merchandize_item_code'=>$Condiment_item_code));
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
	 function Update_main_side_label($Company_id,$Menu_Item_code,$Main_Side_label)
	{
		$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Company_id'=>$Company_id,'Item_flag'=>'MAIN'));
		$this->db->update('igain_pos_item_combo_child',array('Side_label'=>$Main_Side_label));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
	}
	function InActive_Merchandize_Item($Company_merchandise_item_id,$Update_user_id,$Update_date,$Active_flag)
	{
		$this->db->where("Company_merchandise_item_id",$Company_merchandise_item_id);
		$this->db->update('igain_company_merchandise_catalogue',array('Active_flag'=>$Active_flag,' Update_User_id'=>$Update_user_id,'Update_date'=>$Update_date));
		// echo $this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function get_seller_linked_main_groups($seller_id,$Company_id)
	{
		$this->db->select('Product_group_id,Product_group_name');
		$this->db->from('igain_product_group_master');
		$this->db->where(array("Active_flag" => 1, "Seller_id" =>$seller_id, "Company_id" => $Company_id ));
		
		$sql87 = $this->db->get();
		
		if($sql87 != null)
		{
			return $sql87->result_array();
		}
	}
	
	function get_seller_linked_menu_groups($seller_id,$Company_id)
	{
		$this->db->select('Merchandize_category_id,Merchandize_category_name,Parent_category_id');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array("Active_flag" => 1, "Seller_id" =>$seller_id, "Company_id" => $Company_id ));
		
		$sql88 = $this->db->get();
		
		if($sql88 != null)
		{
			return $sql88->result_array();
		}
	}
	
	
}
?>