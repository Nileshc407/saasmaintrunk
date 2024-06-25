<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration_model extends CI_Model {
	
   /*************************************sandeep Start*******************************/
   
   public function loyalty_rule_list($limit,$start,$Company_id)
	{
		// $this->db->limit($limit,$start);
		
			$this->db->select('*');
			$this->db->order_by('Loyalty_id','desc');
			// $this->db->from('igain_loyalty_master as lp');
			// $this->db->join('igain_enrollment_master as e','e.Enrollement_id = lp.Seller');
			// $this->db->where('lp.Company_id',$Company_id);			
			$this->db->from("igain_loyalty_master as LM");
			$this->db->join('igain_enrollment_master as e','e.Enrollement_id = LM.Seller');
			// $this->db->join('igain_segment_master as SM','LM.Segment_id = SM.Segment_id','left');
			$this->db->join('igain_merchandize_category as MC','LM.Category_id = MC.Merchandize_category_id','Left');
			$this->db->join('igain_tier_master as TM','LM.Tier_id = TM.Tier_id','Left');
			$this->db->where(array('LM.Company_id' => $Company_id));
		
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
   
   public function loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id)
	{		
		//return $this->db->count_all("igain_loyalty_master");
	
		$this->db->select('Loyalty_id');
		// $this->db->group_by('Loyalty_name');
		$this->db->from('igain_loyalty_master');
		$this->db->where(array('Company_id' => $Company_id));		
		
		$CountQuery = $this->db->get();
		
		return $CountQuery->num_rows();
	}
	function Get_Category_Name($category_id,$Company_id)
	{
		$this->db->Select("*");			
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Merchandize_category_id' => $category_id,'Company_id' => $Company_id));
		$sql51 = $this->db->get();
		//echo $this->db->last_query();
		
		if($sql51 -> num_rows() >0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	public function insert_loyalty_rule()
	{
		$this->load->model('Igain_model');
		$Purchase_value = array();
		$Issue_points = array();
		
		$data['Company_id'] = $this->input->post("Company_id");
		$data['Active_flag'] = 1;
		// $data['Seller'] = $this->input->post("seller_id");
		$loyalty_rule_setup = $this->input->post("loyalty_rule_setup");
		$data['Loyalty_name'] = $loyalty_rule_setup."-".$this->input->post("LPName");
		$customer_gain = $this->input->post("customer_gain");
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));
		$data['Tier_id'] = $this->input->post("member_tier_id");
		$Rule_for = $this->input->post("Rule_for");
		
		$Category_id = $this->input->post('Category_id');
		// $Flat_flag = $this->input->post("Flat_file");
		if($Rule_for == 4)
		{
			$data['Channel_flag']=1;
			$data['Trans_Channel']=$this->input->post("Trans_Channel");
		}
		if($Rule_for == 5)
		{
			$data['Payment_flag']=1;
			$data['Payment_Type_id']=$this->input->post("Payment_Type_id");
		}
			
		if($this->input->post("seller_id") == 0)
		{
			$get_sellers = $this->Igain_model->get_company_sellers_details($this->input->post("Company_id"));
			
			if($Rule_for == 1)
			{
				$data['Category_flag']=1;
				$data['Category_id']=$this->input->post("Category_id"); 
			}
			if($Rule_for == 2)
			{
				$data['Segment_flag']=1;
				$data['Segment_id']=$this->input->post("Segment_id");
			}
			
			// $data['Flat_file_flag']=$Flat_flag;
			
		
			if($customer_gain == 1) //******Based On Every Transaction 
			{
				$data['Loyalty_at_transaction'] = $this->input->post("gained_points");
				
				foreach($get_sellers as $sellers)
				{
					$data['Seller'] = $sellers->Enrollement_id;
					
					if($Rule_for ==1)
					{
						foreach($Category_id as $Category)
						{
							$CategoryDetails = $this->Administration_model->Get_Category_Name($Category,$this->input->post("Company_id"));
							$Category_name=$CategoryDetails->Merchandize_category_name;
							
							$data121 = array(
							'Company_id' => $this->input->post("Company_id"),
							'Seller' => $sellers->Enrollement_id,
							'Active_flag' => 1,
							'Loyalty_name' => $loyalty_rule_setup."-".$this->input->post("LPName")."(".$Category_name.")",
							'Tier_id' => $this->input->post("member_tier_id"),
							'From_date' => date("Y-m-d",strtotime($this->input->post("start_date"))),
							'Till_date' => date("Y-m-d",strtotime($this->input->post("end_date"))),
							'Loyalty_at_transaction' => $this->input->post("gained_points"),
							// 'Flat_file_flag' => $Flat_flag,
							'Category_flag' => 1,
							'Category_id' => $Category,
							'Segment_flag' => 0,
							'Segment_id' => 0,
							);
							
							$this->db->insert('igain_loyalty_master',$data121);
						}
						/**************Create multiple category rule*************/
					}
					else
					{
						$this->db->insert('igain_loyalty_master', $data);
					}
				}
			}
			
			if($customer_gain == 2) //******Based On Value of Transaction
			{
				$Purchase_value = $this->input->post("Purchase_value"); 
				$Issue_points = $this->input->post("Issue_points");				
				$total_values = count($Purchase_value);
				
				if($total_values == 0)
				{
					return false;
				}
				
				foreach($get_sellers as $sellers)
				{
					$data['Seller'] = $sellers->Enrollement_id;
					for($k=0;$k < $total_values;$k++)
					{
						$data['Loyalty_at_value'] = $Purchase_value[$k];
						$data['discount'] = $Issue_points[$k];
					
						if($Rule_for ==1)
						{
							foreach($Category_id as $Category)
							{
								$CategoryDetails = $this->Administration_model->Get_Category_Name($Category,$this->input->post("Company_id"));
								$Category_name=$CategoryDetails->Merchandize_category_name;
							
								$data121 = array(
								'Company_id' => $this->input->post("Company_id"),
								'Seller' => $sellers->Enrollement_id,
								'Active_flag' => 1,
								'Loyalty_name' => $loyalty_rule_setup."-".$this->input->post("LPName")."(".$Category_name.")",
								'Tier_id' => $this->input->post("member_tier_id"),
								'From_date' => date("Y-m-d",strtotime($this->input->post("start_date"))),
								'Till_date' => date("Y-m-d",strtotime($this->input->post("end_date"))),
								'Loyalty_at_value' => $Purchase_value[$k],
								'discount' => $Issue_points[$k],
								// 'Flat_file_flag' => $Flat_flag,
								'Category_flag' => 1,
								'Category_id' => $Category,
								'Segment_flag' => 0,
								'Segment_id' => 0,
								);
								
								$this->db->insert('igain_loyalty_master',$data121);
							}						
						}
						else
						{
							$this->db->insert('igain_loyalty_master', $data);
						}
					}
				}
			}
		}
		else
		{			
			$data['Seller'] = $this->input->post("seller_id");
			if($Rule_for == 1)
			{
				$data['Category_flag']=1;
				$data['Category_id']=$this->input->post("Category_id"); 
			}
			if($Rule_for == 2)
			{
				$data['Segment_flag']=1;
				$data['Segment_id']=$this->input->post("Segment_id");
			}
			
			// $data['Flat_file_flag']=$Flat_flag;
		
			if($customer_gain == 1) //******Based On Every Transaction 
			{
				$data['Loyalty_at_transaction'] = $this->input->post("gained_points");
				
			/**************Create multiple category rule*************/
				if($Rule_for ==1)
				{
					foreach($Category_id as $Category)
					{
						$CategoryDetails = $this->Administration_model->Get_Category_Name($Category,$this->input->post("Company_id"));
						$Category_name=$CategoryDetails->Merchandize_category_name;
								
						$data121 = array(
						'Company_id' => $this->input->post("Company_id"),
						'Seller' => $this->input->post("seller_id"),
						'Active_flag' => 1,
						'Loyalty_name' => $loyalty_rule_setup."-".$this->input->post("LPName")."(".$Category_name.")",
						'Tier_id' => $this->input->post("member_tier_id"),
						'From_date' => date("Y-m-d",strtotime($this->input->post("start_date"))),
						'Till_date' => date("Y-m-d",strtotime($this->input->post("end_date"))),
						'Loyalty_at_transaction' => $this->input->post("gained_points"),
						// 'Flat_file_flag' => $Flat_flag,
						'Category_flag' => 1,
						'Category_id' => $Category,
						'Segment_flag' => 0,
						'Segment_id' => 0,
						);
						
						$this->db->insert('igain_loyalty_master',$data121);
					}
					/**************Create multiple category rule*************/
				}
				else
				{	
					$this->db->insert('igain_loyalty_master', $data);
				}
				
			}
			
			if($customer_gain == 2) //******Based On Value of Transaction
			{
				$Purchase_value = $this->input->post("Purchase_value"); 
				$Issue_points = $this->input->post("Issue_points");
				
				$total_values = count($Purchase_value);
				
				if($total_values == 0)
				{
					return false;
				}
				
				for($k=0;$k < $total_values;$k++)
				{
					$data['Loyalty_at_value'] = $Purchase_value[$k];
					$data['discount'] = $Issue_points[$k];
					//echo "total_values ".$Purchase_value[$k];die;
					if($Purchase_value[$k] == 0 || $Issue_points[$k] == 0)
					{
						return false;
					}
					if($Rule_for ==1)
					{
						foreach($Category_id as $Category)
						{
							$CategoryDetails = $this->Administration_model->Get_Category_Name($Category,$this->input->post("Company_id"));
							$Category_name=$CategoryDetails->Merchandize_category_name;
							
							$data121 = array(
							'Company_id' => $this->input->post("Company_id"),
							'Seller' => $this->input->post("seller_id"),
							'Active_flag' => 1,
							'Loyalty_name' => $loyalty_rule_setup."-".$this->input->post("LPName")."(".$Category_name.")",
							'Tier_id' => $this->input->post("member_tier_id"),
							'From_date' => date("Y-m-d",strtotime($this->input->post("start_date"))),
							'Till_date' => date("Y-m-d",strtotime($this->input->post("end_date"))),
							'Loyalty_at_value' => $Purchase_value[$k],
							'discount' => $Issue_points[$k],
							// 'Flat_file_flag' => $Flat_flag,
							'Category_flag' => 1,
							'Category_id' => $Category,
							'Segment_flag' => 0,
							'Segment_id' => 0,
							);
							
							$this->db->insert('igain_loyalty_master',$data121);
						}
						/**************Create multiple category rule*************/
					}
					else
					{	
						$this->db->insert('igain_loyalty_master', $data);
					}	
				}
			}
		}
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
	}
	
	public function edit_loyaltyrule($Loyalty_id,$Company_id)
	{
		//echo "lp id in model--".$Loyalty_id;
		
		$this->db->Select("*");
		$this->db->from("igain_loyalty_master as LM");
		$this->db->join('igain_segment_master as SM','LM.Segment_id = SM.Segment_code','left');
		$this->db->join('igain_merchandize_category as MC','LM.Category_id = MC.Merchandize_category_id','Left');
		$this->db->where_in('LM.Loyalty_id',$Loyalty_id);
		$this->db->where(array('LM.Company_id' => $Company_id));
		
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
	
	public function update_loyalty_rule()
	{
		$Purchase_value = array();
		$Issue_points = array();
		
		$Loyalty_id = $this->input->post("Loyalty_id");
		
		$data['Company_id'] = $this->input->post("Company_id");
		$Company_id = $this->input->post("Company_id");
		$data['Active_flag'] = 1;
		$data['Seller'] = $this->input->post("seller_id");
		$loyalty_rule_setup = $this->input->post("loyalty_rule_setup");
		$data['Loyalty_name'] = $loyalty_rule_setup."-".$this->input->post("LPName");
		$LP_name = $this->input->post("LPName");
		$customer_gain = $this->input->post("customer_gain");
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));
		$data['Tier_id'] = $this->input->post("member_tier_id");
		$Rule_for = $this->input->post("Rule_for");
		// $Flat_flag = $this->input->post("Flat_file");
		if($Rule_for == 1)
		{
			$data['Category_flag']=1;
			$data['Category_id']=$this->input->post("Category_id"); 
		}
		if($Rule_for == 2)
		{
			$data['Segment_flag']=1;
			$data['Segment_id']=$this->input->post("Segment_id");
		}
		if($Rule_for == 4)
		{
			$data['Channel_flag']=1;
			$data['Trans_Channel']=$this->input->post("Trans_Channel");
		}
		if($Rule_for == 5)
		{
			$data['Payment_flag']=1;
			$data['Payment_Type_id']=$this->input->post("Payment_Type_id");
		}
		// $data['Flat_file_flag']=$Flat_flag;
		
		
		if($customer_gain == 1) //******Based On Every Transaction 
		{
			$data['Loyalty_at_transaction'] = $this->input->post("gained_points");
			
			$this->db->where('Loyalty_id ', $Loyalty_id );
			$this->db->update('igain_loyalty_master', $data);
		}
		
		if($customer_gain == 2) //******Based On Value of Transaction
		{
			$Purchase_value = $this->input->post("Purchase_value"); 
			$Issue_points = $this->input->post("Issue_points");
			
			$total_values = count($Purchase_value);
			//echo "total_values :: ".$total_values;
			/* if($total_values > 0)
			{
				$this->db->where(array('Loyalty_id' => $Loyalty_id,'Company_id' => $Company_id));
				$this->db->delete('igain_loyalty_master');
				//echo "--delete--".$this->db->last_query()."--<br>";
			}
			
			for($k=0;$k < $total_values;$k++)
			{
				$data['Loyalty_at_value'] = $Purchase_value[$k];
				$data['discount'] = $Issue_points[$k];
				
				$this->db->insert('igain_loyalty_master', $data);
			} */
			/***************AMIT 06-06-2019 Reason to change: insert extra entry after update*******/
			$data['Loyalty_at_value'] = $Purchase_value;
			$data['discount'] = $Issue_points;
			$this->db->where('Loyalty_id ', $Loyalty_id );
			$this->db->update('igain_loyalty_master', $data);
		}
 //die;
		
			return true;
		

		
	}
	
	public function delete_loyaltyrule($Loyalty_id,$Company_id)
	{
		$this->db->where('Loyalty_id', $Loyalty_id);
		$this->db->delete('igain_loyalty_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function loyalty_program_name_validation($lpName,$CompanyId)
	{
	  $lpName1="PA-".$lpName;
	  $lpName2="BA-".$lpName;
	  
	  $this->db->select('Loyalty_id');
	  $this->db->from('igain_loyalty_master');
	  $this->db->where(array('Loyalty_name' => $lpName1,'Company_id' => $CompanyId));
	  $this->db->or_where_in('Loyalty_name', $lpName2);
	  
	  $sqlOPT = $this->db->get();

			if ($sqlOPT->num_rows() > 0)
	  {
	   return 1;
	  }
	  else
	  {
	   return 0;
	  }
	}
	 public function discount_rule_list($limit,$start,$Company_id)
	{

			$this->db->limit($limit,$start);
			$this->db->select('*');
			$this->db->order_by('Discount_master_id','desc');
			$this->db->from('igain_discount_master as dp');
			$this->db->join('igain_enrollment_master as e','e.Enrollement_id = dp.Seller_id');
			$this->db->where('dp.Company_id',$Company_id);
			
		
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
   
	public function discount_rule_count($Company_id)
	{
		// return $this->db->count_all("igain_discount_master");
		$this->db->from('igain_discount_master as A');
		$this->db->join('igain_enrollment_master as B', 'A.Seller_id = B.Enrollement_id');
		$this->db->where(array('A.Company_id' => $Company_id));
		
		return $this->db->count_all_results();
	}
	
   public function insert_discount_rule()
	{
		$this->load->model('Igain_model');
		$Purchase_value = array();
		$Issue_points = array();
		
		$data['Company_id'] = $this->input->post("Company_id");
		$data['Active_flag'] = 1;
		$data['Seller_id'] = $this->input->post("seller_id");
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));
		$data['Default_discount'] = $this->input->post("DefaultDiscount");
		$Purchase_value = $this->input->post("Purchase_value"); 
		$Issue_points = $this->input->post("Issue_points");
		$total_values = count($Purchase_value);
			
		if($this->input->post("seller_id") == 0)
		{
			$get_sellers = $this->Igain_model->get_company_sellers($this->input->post("Company_id"));
			
			foreach($get_sellers as $sellers)
			{
				$data['Seller_id'] = $sellers->Enrollement_id;
				if($total_values > 0) //******Based On Value of Transaction
				{
					for($k=0;$k < $total_values;$k++)
					{
						$data['Loyalty_points_above'] = $Purchase_value[$k];
						$data['Discount'] = $Issue_points[$k];						
						$this->db->insert('igain_discount_master', $data);
					}
				}
				else
				{
					$this->db->insert('igain_discount_master', $data);
				}
			}
		}
		else
		{
			if($total_values > 0) //******Based On Value of Transaction
			{
				for($k=0;$k < $total_values;$k++)
				{
					$data['Loyalty_points_above'] = $Purchase_value[$k];
					$data['Discount'] = $Issue_points[$k];
					
					$this->db->insert('igain_discount_master', $data);
				}
			}
			else
			{
				//$data['Loyalty_points_above'] = 0;
				//$data['Discount'] = 0;	
				$this->db->insert('igain_discount_master', $data);
			}
		}

		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function edit_discountrule($Discount_master_id,$Company_id)
	{
		$this->db->Select("*");
		$this->db->from("igain_discount_master");
		$this->db->where(array('Discount_master_id' => $Discount_master_id,'Company_id' => $Company_id));
		$edit_sql = $this->db->get();
		
        
		if($edit_sql->num_rows() == 1)
		{
			return $edit_sql->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function update_discount_rule()
	{
		$Purchase_value = array();
		$Issue_points = array();
		
		$data['Company_id'] = $this->input->post("Company_id");
		$data['Active_flag'] = 1;
		$data['Seller_id'] = $this->input->post("seller_id");
		$Discount_master_id = $this->input->post("Discount_master_id");


		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));
		
		
			$data['Default_discount'] = $this->input->post("DefaultDiscount");
			
		
			$Purchase_value = $this->input->post("Purchase_value"); 
			$Issue_points = $this->input->post("Issue_points");
			
			if($Purchase_value[0] > 0)
			{
				$data['Loyalty_points_above'] = $Purchase_value[0];
				$data['Discount'] = $Issue_points[0];
			}
			
			$this->db->where('Discount_master_id ', $Discount_master_id );
			$this->db->update('igain_discount_master', $data);

		if($this->db->affected_rows() > 0)
		{
			return true;
		}

		
	}	
	public function delete_discountrule($Discount_master_id,$Company_id)
	{
		$this->db->where('Discount_master_id', $Discount_master_id);
		$this->db->delete('igain_discount_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function promo_campaign_count($Company_id)
	{
		 $this->db->select('Campaign_id');
		$this->db->from('igain_promo_campaign');
		$this->db->where(array('Company_id' =>$Company_id));
		
		$promosqlquery = $this->db->get();
		
		return $promosqlquery->num_rows() > 0;
		
		//return $this->db->count_all("igain_promo_campaign");
	}
	
	 public function promo_campaign_list($limit,$start,$Company_id)
	{
		
			$this->db->limit($limit,$start);
			$this->db->select('dp.*,c.File_name');
			$this->db->group_by('c.File_name');
			$this->db->order_by('dp.Campaign_id','desc');
			$this->db->from('igain_promo_campaign as dp');
			$this->db->join('igain_promo_campaign_child as c','dp.Campaign_id = c.Campaign_id');
			$this->db->where('dp.Company_id',$Company_id);
		
		
        $query = $this->db->get();
		// echo "--promo_campaign_list--".$this->db->last_query()."--<br>";
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
	 
	public function promo_campaign_file_list($Company_id)
	{
			$this->db->select('*');
			$this->db->group_by('File_name');
			$this->db->from('igain_promo_campaign_tmp as dp_tmp');
			$this->db->where('dp_tmp.Company_id',$Company_id);
		
        $query = $this->db->get();
		//echo "--promo_campaign_file_list--".$this->db->last_query()."--<br>";
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
   
   public function promo_tmp_campaign_details($Company_id)
	{
		$this->db->limit(1,1);
		$this->db->select('*');
		$this->db->from('igain_promo_campaign_tmp as dp_tmp');
		$this->db->where('dp_tmp.Company_id',$Company_id);
		
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
   
   public function check_campaign_name($CMPName,$Company_id)
   {
	    $this->db->select('*');
		$this->db->from('igain_promo_campaign');
		$this->db->where(array('Company_id' =>$Company_id,'Pomo_campaign_name' =>$CMPName));
		
		$promosqlquery = $this->db->get();
		
		if($promosqlquery->num_rows() > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
   }
   
   public function insert_promo_campaign($Company_id)   
	{
		$this->db->select('*');
		$this->db->from('igain_promo_campaign_tmp');
		$this->db->where('Company_id',$Company_id);
		
		$sqlquery = $this->db->get();
		
		if($sqlquery->num_rows() > 0)
		{
			$sql_result = $sqlquery->result_array();
			
			foreach($sql_result as $rowA)
			{
				//echo "--Promo_campaign_id--".$rowA['Promo_campaign_id']."--<br>";
				
				$PromoCode = $rowA['Promo_code'];
				$PromoData['Promo_code'] = $rowA['Promo_code'];
				$PromoData['Campaign_id'] = $rowA['Campaign_id'];
				$Promo_Campaign_id = $rowA['Campaign_id'];
				$PromoData['Points'] = $rowA['Points'];
				$PromoData['File_name'] = $rowA['File_name'];
				$PromoData['Company_id'] = $Company_id;
				$PromoData['Promo_code_status'] = 0;
				$PromoData['Active_flag'] = 1;

				
				$this->db->select('Promo_child_campaign_id');
				$this->db->from('igain_promo_campaign_child');
				$this->db->where(array('Company_id' => $Company_id,'Promo_code' => $PromoCode,'Promo_code_status' =>0));
			
				$sqlqueryopt = $this->db->get();
		
				if($sqlqueryopt->num_rows() == 0)
				{
					$insert_query = $this->db->insert('igain_promo_campaign_child',$PromoData);
				}
				
			}

			$cmp_query = $this->db->query("Select Promo_child_campaign_id from igain_promo_campaign_child where
				Campaign_id='".$Promo_Campaign_id."' AND Company_id='".$Company_id."' ");
			
			if($cmp_query->num_rows() == 0)
			{
				$this->db->query("delete from igain_promo_campaign WHERE Campaign_id='".$Promo_Campaign_id."' AND Company_id='".$Company_id."' ");
			}
			
			$this->db->query("delete from igain_promo_campaign_tmp WHERE Company_id='".$Company_id."' ");
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	 public function upload_promo_campaign_file($filepath,$filename,$Company_id)
	{
		// echo "filename---".$filename."--<br>";
		$create_campaign_id=0;
		function getExtension($str) 
		{
			 $i = strrpos($str,".");
			 if (!$i) { return ""; }
			 $l = strlen($str) - $i;
			 $ext = substr($str,$i+1,$l);
			 return $ext;
		}

		$extension = getExtension($filename);
				
		$data['Company_id'] = $Company_id;
		$data['Active_flag'] = 1;
		$data['Pomo_campaign_name'] = $this->input->post("CMPName");
		$campaign_name = $this->input->post("CMPName");
		$data['Campaign_description']  = trim($this->input->post("CMPdescription"));

		
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['To_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));
		$data['Date'] = date("Y-m-d");
		
		$sql_out = $this->db->query("select Promo_child_campaign_id from igain_promo_campaign_child where File_name like '".$filename."' and Company_id=".$Company_id);
		// echo "----num_rows---".$sql_out->num_rows()."--<br>";
		if($sql_out->num_rows() > 0)
		{
			return false; //**** file is already uploaded ****	
		}
		else
		{
				// echo base_url().''.$filepath;die;
			
			 /*  echo "---extension---".$extension."--<br>";
			 echo "---filepath---".base_url().''.$filepath."--<br>";
			die;  */
					if($extension == "csv") 
					{
						//get the csv file
						
						//$filepath = realpath($_FILES["csv"]["tmp_name"]);
						$filenameis = $filename;
						//echo base_url().''.$filepath;die;
						// $handle = fopen($filepath,"r");
						 $handle = fopen(base_url().''.$filepath,"r");
						 //echo base_url().''.$filepath;die;
						//$handle = fopen('http://localhost/CI_IGAINSPARK_LIVE_NEW_DESIGN/Promo_codes/'.$filename,"r");
						//echo 'http://localhost/CI_IGAINSPARK_LIVE_NEW_DESIGN/Promo_codes/'.$filename;die;
						for ($lines = 1; $csv_data = fgetcsv($handle,1000,",",'"'); $lines++)
						{		
							 //echo "the line no---".$lines."<br>";die;
							if ($lines == 1) continue;
							if ($csv_data[0]) 
							{
									
									$d1 = $csv_data[0];
									$d2 = $csv_data[1];
										
									$lv_query = $this->db->query("SELECT * FROM igain_promo_campaign_child WHERE Promo_code='".$d2."' and Promo_code_status='0' and Company_id=".$Company_id);
															
									if($lv_query->num_rows() > 0 || !is_numeric($d1))
									{
										$checkme = 0;
											
											/* $get_error[] = $d2."-Promo Code Already Exist";
											$error_row[] = $lines; */
											
											continue;	
											// echo "the line no---".$lines."<br>";die;
									}
									else
									{	
										$sql_query = $this->db->query("SELECT Campaign_id FROM  igain_promo_campaign WHERE Pomo_campaign_name like '".$campaign_name."' and Company_id=".$Company_id);
			
											 //echo "--sql_query--num_rows---".$sql_query->num_rows()."--<br>";die;
											if($sql_query->num_rows() == 0)
											{
												$this->db->insert('igain_promo_campaign', $data);
											
												if($this->db->affected_rows() > 0)
												{
													$create_campaign_id = $this->db->insert_id();
													// $create_campaign_id= $this->db->insert_id();
													// return $this->db->insert_id();
												}
											}
											else
											{
												if ($sql_query->num_rows() > 0)
												{
													foreach ($sql_query->result_array() as $row)
													{
														$create_campaign_id = $row['Campaign_id'];
													}
												}
											}
											
										 $data['File_name']  = $filename;
										 $data['Campaign_id'] = $create_campaign_id; 
										 $data['Points'] = $d1; 
										 $data['Promo_code'] = $d2; 
										 $data['Promo_code_status'] = 0; 
										 
										$this->db->insert('igain_promo_campaign_tmp', $data);
										
										// echo "---insert---".$this->db->last_query()."--<br>";
										//die;
									}
									
							}
						}
						 
						
					}
					else if( $extension == "xlsx" ||  $extension == "xls") 
					{

						 $this->load->library('excel');
 
							//read file from path
							$objPHPExcel = PHPExcel_IOFactory::load($filepath);
							 
							//get only the Cell Collection
							$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
							 
							 $sd = 0;
							//extract to a PHP readable array format
							foreach ($cell_collection as $cell) 
							{
								$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
							
								$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
								
								$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
							 
								//header will/should be in row 1 only. of course this can be modified to suit your need.
								if ($row == 1) 
								{
									$header[$row][2] = $data_value;
								} 
								else 
								{
									if($sd == 0)
									{
										$points_data[] = $data_value;
										$sd = 1;
										
									}
									else
									{
										$codes_data[] = $data_value;	
										$sd = 0;
									}
	
								}
							}
							 
							for($kp = 0; $kp < count($points_data);$kp++)
							{
								//echo $kp."--code--".$codes_data[$kp]."--points--".$points_data[$kp]."---<br>";
								
								$d1 = $points_data[$kp];
								$d2 = $codes_data[$kp];
								
								$lv_query = $this->db->query("SELECT * FROM igain_promo_campaign_child WHERE Promo_code='".$d2."' and Promo_code_status='0' and Company_id=".$Company_id);
																	
								if($lv_query->num_rows() > 0 || !is_numeric($d1))
								{
									$checkme = 0;
										
										// $get_error[] = $d2."-Promo Code Already Exist";
										//$error_row[] = $lines; 
										
										continue;	

								}
								else
								{	
									$sql_query = $this->db->query("SELECT Campaign_id FROM  igain_promo_campaign WHERE Pomo_campaign_name like '".$campaign_name."' and Company_id=".$Company_id);
			
									 //echo "--sql_query--num_rows---".$sql_query->num_rows()."--<br>";die;
									if($sql_query->num_rows() == 0)
									{
										$this->db->insert('igain_promo_campaign', $data);
									
										if($this->db->affected_rows() > 0)
										{
											$create_campaign_id = $this->db->insert_id();
											// $create_campaign_id= $this->db->insert_id();
											// return $this->db->insert_id();
										}
									}
									else
									{
										if ($sql_query->num_rows() > 0)
										{
											foreach ($sql_query->result_array() as $row)
											{
												$create_campaign_id = $row['Campaign_id'];
											}
										}
									}
											
									$data['File_name']  = $filename;
									 $data['Campaign_id'] = $create_campaign_id; 
									 $data['Points'] = $d1; 
									 $data['Promo_code'] = $d2; 
									 $data['Promo_code_status'] = 0; 
									 
									$this->db->insert('igain_promo_campaign_tmp', $data);
									// echo"---insert----".$this->db->last_query()."---<br>";
									
								}	
							}
					}
			
				// echo"---create_campaign_id----".$create_campaign_id."---<br>";
				// die;
				if($this->db->affected_rows() > 0)
				{
					return $create_campaign_id;
				}
		}

		
	}
	
	
	function delete_promocampaign($Campaign_id,$flag)
	{

		if($flag == 1)
		{
			
		
			$this->db->where(array('Campaign_id' => $Campaign_id));
			$this->db->delete('igain_promo_campaign_tmp');
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		else
		{
		
			$this->db->where(array('Campaign_id' => $Campaign_id));
			$this->db->delete('igain_promo_campaign');
			
			$this->db->where(array('Campaign_id' => $Campaign_id));
			$this->db->delete('igain_promo_campaign_child');
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		
	}
	
	function show_promo_file_details($Campaign_id,$CompID,$FileName,$flag)
	{

		if($flag == 1) //**** temp table data
		{

			$this->db->select('*');
			$this->db->from('igain_promo_campaign_tmp');
			$this->db->order_by('Promo_campaign_id');
			
			$this->db->where(array('Campaign_id' => $Campaign_id, 'Company_id' => $CompID, 'File_name' => $FileName));
			
			
		}
		else
		{
			$this->db->select('p.Pomo_campaign_name,p.From_date,p.To_date,c.File_name,c.Points,c.Promo_code,c.Promo_code_status');
			$this->db->from('igain_promo_campaign  as p');
			$this->db->order_by('Promo_child_campaign_id');
			$this->db->join('igain_promo_campaign_child as c','p.Campaign_id=c.Campaign_id');
			$this->db->where(array('c.Campaign_id' => $Campaign_id, 'c.Company_id' => $CompID, 'c.File_name' => $FileName));

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

        
	}
	
	function promo_campaign_details($promo_cmp_id)
	{
		$this->db->from('igain_promo_campaign');
		$this->db->where(array('Campaign_id' =>$promo_cmp_id));
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
                $datav[] = $row;
            }
            return $datav;
        }
        return false;
	}	
	function get_all_hobbie_customers($compid)
	{
		$this->db->select('a.Enrollement_id,a.First_name,a.Last_name,a.User_email_id,b.Hobbie_id');
		$this->db->from('igain_enrollment_master as a');
		$this->db->join('igain_hobbies_interest as b','a.Enrollement_id = b.Enrollement_id');
		$this->db->where(array('a.User_activated' =>'1','b.Company_id' =>$compid));
		
		$query5 = $this->db->get();
		
		if($query5->num_rows() > 0)
		{
			foreach($query5->result_array() as $row5)
			{
				$hobbie_members[] = $row5;
			}
			
			return $hobbie_members;
		}
		
		return false;
	}
  /*************************************sandeep END *******************************/
  
  
   
  
//***********************************************Akshay Starts************************************
	function insert_communication($filepath) 
    {  
		$entry_date = date('Y-m-d');
		$sellerID = $this->input->post('sellerId');
		$data['communication_plan'] = $this->input->post('offer');
		$Hobbie_id=$this->input->post('Offer_related_to');
		if($Hobbie_id!=NULL)
		{
			$Hobbie_id=$Hobbie_id;
		}
		else
		{
			$Hobbie_id=0;
		}
		$data['Hobbie_id'] = $Hobbie_id;
		$data['date'] = $entry_date;
		$data['activate'] = 'yes';
		$data['Company_id'] = $this->input->post('Company_id');
		$data['Link_to_lbs'] = $this->input->post('Link_to_lbs');
		$data['description'] = $this->input->post('offerdetails');
		
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));		
		//$data['description'] = $this->input->post('offerdetails');		
		$data['Share_file_path'] = $filepath;	

		/**************Voucher Link Comminucation 26-02-2020--Ravi***************/
			$data['Link_to_voucher'] = $this->input->post('Link_to_voucher');
			if($data['Link_to_voucher'] != 0){
				$data['Voucher_type'] = $this->input->post('Voucher_type');
				$data['Voucher_id']= $this->input->post('Voucher_id');
			} else {
				$data['Voucher_type'] = 0;
				$data['Voucher_id']= 0;
			}
			// 
		/**************Voucher Link Comminucation 26-02-2020--Ravi***************/
		
		
		/**************Birthday Communication 09-03-2020--Ravi***************/
			$data['Birthday_flag'] = $this->input->post('Birthday_flag');
			if($data['Birthday_flag'] != 0){
				$data['Birthday_flag'] = $this->input->post('Birthday_flag');
			} else {
				$data['Birthday_flag'] = 0;
			}
		/**************Birthday Communication 09-03-2020--Ravi***************/

				
		
		/*  print_r($data);
		 die; */
		
		
		
			/**************Schedule Comminucation 31-05-2017--Ravi***************/
			
			if($this->input->post('Schedule_flag')) {
				
				$data['Schedule_flag'] = $this->input->post('Schedule_flag');
				if($this->input->post('Schedule_flag')=='1')
				{
					$data['Link_to_lbs']='0';
				}
				$data['Schedule_criteria'] = $this->input->post('Schedule_criteria');
				if($data['Schedule_criteria'] !="")
				{
					$data['Schedule_criteria']= $this->input->post('Schedule_criteria');
				}
				else
				{
					$data['Schedule_criteria']=0;
				}
				if($this->input->post('Schedule_weekly') !="" )
				{
					$data['Schedule_criteria_value'] = $this->input->post('Schedule_weekly');
				}
				else
				{
					$data['Schedule_criteria_value'] = 0;
				}
				if($this->input->post('r2') != "")
				{
					$data['Schedule_comm_for'] = $this->input->post('r2');
				}
				else
				{
					$data['Schedule_comm_for']='0';
				}
			}
				
				
				if($this->input->post('r2') == 1) // Single Customer
				{
					$data['Schedule_comm_value'] = $this->input->post('mailtoone_memberid');
				}
				if($this->input->post('r2') == 2) // All Customer
				{
					$data['Schedule_comm_value'] = $this->input->post('mailtoall');
				}
				if($this->input->post('r2') == 5) // Tier Based Members
				{
					$data['Schedule_comm_value'] = $this->input->post('mailtotier');
				}
				if($this->input->post('r2') == 7) // Segment Based Members
				{
					$data['Schedule_comm_value'] = $this->input->post('Segment_code');
				}
				
			if($this->input->post('mailtoone_memberid') != "")
			{
				$data['Membership_id'] = $this->input->post('mailtoone_memberid');
			}	
			else
			{
				$data['Membership_id']='0';
			}
			if($data['Schedule_criteria']==2  || $data['Schedule_criteria']==3 )
			{
				$data['Schedule_criteria_value'] = date("m",strtotime($this->input->post("start_date")));
			}
			if($data['Schedule_criteria']==4)
			{
				$data['Custom_date'] = date("Y-m-d",strtotime($this->input->post("Select_day_date")));				
			}
			// else
			// {
				// $data['Custom_date']="0000-00-00";
			// }
			if( $this->input->post("facebook_social1") != "")
			{
				$data['Facebook'] = $this->input->post("facebook_social1");
			}
			else
			{
				$data['Facebook']='0';
			}
			if($this->input->post("twitter_social1") != "")
			{
				$data['Twitter'] = $this->input->post("twitter_social1");
			}
			else
			{
				$data['Twitter']='0';
			}
			if($this->input->post("googleplus_social1") != "")
			{
				$data['Google'] = $this->input->post("googleplus_social1");
			}
			else
			{
				$data['Google'] ='0';
			}
			
			
				$radio1 = $this->input->post("r1");			//****send single or multiple offers.	 
				$radio2 = $this->input->post("r2");			//****send to single or all or key or worry customer.	
				$sellerid = $this->input->post("sellerId");
				$compid = $this->input->post("companyId");
				$offerid = $this->input->post("activeoffer");
				$entry_date=date("Y-m-d");	
				$acitvate = '0';
				
				if($radio2 == 1) //**single customer
				{
					$cust_name = $this->input->post("mailtoone");
					$Enrollment_id = $this->input->post("Enrollment_id");						
					$member_email = $this->input->post("member_email");						
					$sendto = $Enrollment_id;						
				}
				if($radio2 == 2) //**all customer
				{
					$sendto = $this->input->post("mailtoall");
				}
				if($radio2 == 5) //**Tier based customer
				{
					$sendto = $this->input->post("mailtotier");
				}				
				if($sellerID == '0')
				{
					/*****************************insert_communication For All Sellers*****************************/
					$seller_array=array();
					$this->db->select("Enrollement_id");
					$this->db->from('igain_enrollment_master');
					$this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $compid));//, 'Company_id' => $Company_id
					$query = $this->db->get();					
					foreach ($query->result() as $row)
					{
						$data['seller_id'] = $row->Enrollement_id;
						$this->db->insert('igain_seller_communication', $data);
						$comm_id = $this->db->insert_id();
					}
					/*****************************insert_communication For All Sellers*****************************/
				}
				else
				{
					$data['seller_id'] = $this->input->post('sellerId');
					$this->db->insert('igain_seller_communication', $data);	
					$comm_id = $this->db->insert_id();
					
					if($this->db->affected_rows() > 0)
					{
						return $this->db->insert_id();
					}
					else
					{
						return 0;
					}
				}
				
				
				
					$from_date = date("Y-m-d",strtotime($this->input->post("start_date")));
					$to_date = date("Y-m-d",strtotime($this->input->post("end_date")));
					$Schedule_criteria = $this->input->post('Schedule_criteria');
					$Schedule_weekly = $this->input->post('Schedule_weekly');
										
				/**************Schedule Comminucation for Single or All Customer 31-05-2017--Ravi***************/
				// echo"---sendto----".$sendto."<br>";
					if($radio2 < 3) //****single or all customer
					{
						if($sendto > 0)   //****single customer
						{
							$customer_details = $this->Igain_model->get_enrollment_details($sendto);							
							$Enrollement_id=$customer_details->Enrollement_id;
							$User_email_id=$customer_details->User_email_id;						
							if($Schedule_criteria==1) //Weekly
							{
								$counter=0;
								if($Schedule_weekly==1)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==1) //monday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==2)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==2) //Tuesday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==3)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	 
										 if(date("N",strtotime($from_date))==3) //Wedensday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==4)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	
										if(date("N",strtotime($from_date))==4) //Thursday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==5)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==5) //Friday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==6)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==6)  //Saturday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==7)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==7)  // Sunday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}										
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}	
								$schedule_count=count($schedule_date);
								for($i=0;$i<count($schedule_date);$i++)
								{
									$data1['Comm_id']=$comm_id;
									$data1['Company_id']=$compid;
									$data1['Enrollment_id']=$Enrollement_id;
									$data1['User_email_id']=$User_email_id;
									$data1['Schedule_date']=$schedule_date[$i];
									$data1['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data1);
								}							
							}
							if($Schedule_criteria==2) //Mothly
							{
								$startDate=$from_date;
								$endDate=$to_date;
								while(strtotime($startDate) <= strtotime($endDate)) 
								{
									$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
									$startDate = $startDate12."-01";									
									if($startDate <= $endDate)
									{
										$first_day_of_month[]=$startDate;
									}									
								}
								for($j=0;$j<count($first_day_of_month);$j++)
								{
									$data12['Comm_id']=$comm_id;
									$data12['Company_id']=$compid;
									$data12['Enrollment_id']=$Enrollement_id;
									$data12['User_email_id']=$User_email_id;
									$data12['Schedule_date']=$first_day_of_month[$j];
									$data12['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data12);
								}								
							}
							if($Schedule_criteria==3) //Quaterly
							{
								$Quarter_of_year=array();
								$startDate=$from_date;
								$endDate=$to_date;								
								// Specify the start date. This date can be any English textual format  
								$date_from = $from_date;   
								$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
								// Specify the end date. This date can be any English textual format  
								$date_to =$to_date;  
								$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
								// Loop from the start date to end date and output all dates inbetween  
								for ($i=$date_from; $i<=$date_to; $i+=86400) 
								{								
									// echo date("Y-m-d", $i).'<br />'; 									
									$startDate12 = date('m-d', $i);
									$Year = date('Y', $i);
									if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
									{
										// echo"---startDate--mm-".$Year."-".$startDate12."<br>";
										$Quarter_of_year[]=$Year."-".$startDate12;
									}
								}
								for($j=0;$j<count($Quarter_of_year);$j++)
								{
									$data13['Comm_id']=$comm_id;
									$data13['Company_id']=$compid;
									$data13['Enrollment_id']=$Enrollement_id;
									$data13['User_email_id']=$User_email_id;
									$data13['Schedule_date']=$Quarter_of_year[$j];
									$data13['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data13);
								}	
																	
							}
							if($Schedule_criteria==4) //Seleted Date
							{
								$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));
								$data13['Comm_id']=$comm_id;
								$data13['Company_id']=$compid;
								$data13['Enrollment_id']=$Enrollement_id;
								$data13['User_email_id']=$User_email_id;
								$data13['Schedule_date']=$Select_day_date;
								$data13['Sent_flag']='0';
								$this->db->insert('igain_communication_schedule', $data13);
																
							}					
						
						}
						if($sendto == 0)   //****all customer
						{			
							if($Schedule_criteria==1) //Weekly
							{
								$counter=0;
								if($Schedule_weekly==1)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==1) //monday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==2)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==2) //Tuesday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==3)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	 
										 if(date("N",strtotime($from_date))==3) //Wedensday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==4)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	
										if(date("N",strtotime($from_date))==4) //Thursday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==5)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==5) //Friday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==6)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==6)  //Saturday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==7)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==7)  // Sunday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}											
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));
									}
								}	
								for($k=0;$k<count($schedule_date);$k++)
								{					
									$all_customers = $this->Igain_model->get_all_customers($compid);	
									foreach ($all_customers as $row)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;
										$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);			
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$schedule_date[$k];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}
								}
							}									
							if($Schedule_criteria==2) //Mothly
							{
								// $startDate=date('Y-m-d', strtotime($from_date.'- 1 day'));
								$startDate=$from_date;
								$endDate=$to_date;
								while(strtotime($startDate) <= strtotime($endDate)) 
								{
									$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
									$startDate = $startDate12."-01";									
									if($startDate <= $endDate)
									{
										$first_day_of_month[]=$startDate;
									}									
								}									
								for($j=0;$j<count($first_day_of_month);$j++)
								{										
									$all_customers = $this->Igain_model->get_all_customers($compid);	
									foreach ($all_customers as $row)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;
										$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);			
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$first_day_of_month[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}	
								}								
							}
							if($Schedule_criteria==3) //Quaterly
							{
								$Quarter_of_year=array();
								$startDate=$from_date;
								$endDate=$to_date;								
								// Specify the start date. This date can be any English textual format  
								$date_from = $from_date;   
								$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
								// Specify the end date. This date can be any English textual format  
								$date_to =$to_date;  
								$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
								// Loop from the start date to end date and output all dates inbetween  
								for ($i=$date_from; $i<=$date_to; $i+=86400) 
								{								
									// echo date("Y-m-d", $i).'<br />'; 									
									$startDate12 = date('m-d', $i);
									$Year = date('Y', $i);
									if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
									{
										$Quarter_of_year[]=$Year."-".$startDate12;
									}
								}
								// print_r($Quarter_of_year);
								for($j=0;$j<count($Quarter_of_year);$j++)
								{
									$all_customers = $this->Igain_model->get_all_customers($compid);	
									foreach ($all_customers as $row)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;
										$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);			
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$Quarter_of_year[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}
									
								}
							}
							if($Schedule_criteria==4) //Seleted Date
							{
								$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{										
									$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);	
									$data1['Comm_id']=$comm_id;
									$data1['Company_id']=$compid;										
									$data1['Enrollment_id']=$customer_details->Enrollement_id;
									$data1['User_email_id']=$customer_details->User_email_id;
									$data1['Schedule_date']=$Select_day_date;
									$data1['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data1);
								}
																
							}
						}
						
					}
					if($radio2 == 5) //****for tier based cust
					{		
						if($Schedule_criteria==1) //Weekly
						{
							$counter=0;
							if($Schedule_weekly==1)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==1) //monday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==2)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==2) //Tuesday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==3)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	 
									 if(date("N",strtotime($from_date))==3) //Wedensday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==4)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	
									if(date("N",strtotime($from_date))==4) //Thursday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==5)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==5) //Friday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==6)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==6)  //Saturday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==7)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==7)  // Sunday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}											
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));
								}
							}	
							for($k=0;$k<count($schedule_date);$k++)
							{					
								$selected_tier = $sendto; 
								$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
								if($tier_based_customers != false)
								{										
									foreach($tier_based_customers as $cust_regid)
									{										
										$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
										if($customer_details != NULL)
										{
											$data1['Comm_id']=$comm_id;
											$data1['Company_id']=$compid;												
											$data1['Enrollment_id']=$customer_details->Enrollement_id;
											$data1['User_email_id']=$customer_details->User_email_id;
											$data1['Schedule_date']=$schedule_date[$k];
											$data1['Sent_flag']='0';
											$this->db->insert('igain_communication_schedule', $data1);
										}
									}
								}
								
							}
						}
						if($Schedule_criteria==2) //Mothly
						{
							$startDate=$from_date;
							$endDate=$to_date;
							while(strtotime($startDate) <= strtotime($endDate)) 
							{
								$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
								$startDate = $startDate12."-01";									
								if($startDate <= $endDate)
								{
									$first_day_of_month[]=$startDate;
								}									
							}									
							for($j=0;$j<count($first_day_of_month);$j++)
							{	
								$selected_tier = $sendto; 
								$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
								if($tier_based_customers != false)
								{										
									foreach($tier_based_customers as $cust_regid)
									{
										
										$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
										if($customer_details != NULL)
										{
											$data1['Comm_id']=$comm_id;
											$data1['Company_id']=$compid;												
											$data1['Enrollment_id']=$customer_details->Enrollement_id;
											$data1['User_email_id']=$customer_details->User_email_id;
											$data1['Schedule_date']=$first_day_of_month[$j];
											$data1['Sent_flag']='0';
											$this->db->insert('igain_communication_schedule', $data1);
										}
									}
								}
							}								
						}
						if($Schedule_criteria==3) //Quaterly
						{
							$Quarter_of_year=array();
							$startDate=$from_date;
							$endDate=$to_date;								
							// Specify the start date. This date can be any English textual format  
							$date_from = $from_date;   
							$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
							// Specify the end date. This date can be any English textual format  
							$date_to =$to_date;  
							$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
							// Loop from the start date to end date and output all dates inbetween  
							for ($i=$date_from; $i<=$date_to; $i+=86400) 
							{								
								$startDate12 = date('m-d', $i);
								$Year = date('Y', $i);
								if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
								{
									$Quarter_of_year[]=$Year."-".$startDate12;
								}
							}
							for($j=0;$j<count($Quarter_of_year);$j++)
							{
								$selected_tier = $sendto; 
								$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
								if($tier_based_customers != false)
								{										
									foreach($tier_based_customers as $cust_regid)
									{
										
										$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
										if($customer_details != NULL)
										{
											$data1['Comm_id']=$comm_id;
											$data1['Company_id']=$compid;												
											$data1['Enrollment_id']=$customer_details->Enrollement_id;
											$data1['User_email_id']=$customer_details->User_email_id;
											$data1['Schedule_date']=$Quarter_of_year[$j];
											$data1['Sent_flag']='0';
											$this->db->insert('igain_communication_schedule', $data1);
										}
									}
								}
								
							}							
						}
						if($Schedule_criteria==4) //Seleted Date
						{
							$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));
							$selected_tier = $sendto; 
							$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
							if($tier_based_customers != false)
							{										
								foreach($tier_based_customers as $cust_regid)
								{
									
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
									if($customer_details != NULL)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$Select_day_date;
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}
								}
							}
															
						}
					}
					if($radio2 == 7) //**segments
					{
						$Segment_code = $this->input->post("Segment_code");	
						if($Schedule_criteria==1) //Weekly
						{
							$counter=0;
							if($Schedule_weekly==1)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==1) //monday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==2)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==2) //Tuesday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==3)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	 
									 if(date("N",strtotime($from_date))==3) //Wedensday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==4)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	
									if(date("N",strtotime($from_date))==4) //Thursday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==5)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==5) //Friday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==6)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==6)  //Saturday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==7)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==7)  // Sunday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}											
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));
								}
							}	
							for($k=0;$k<count($schedule_date);$k++)
							{					
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{	
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$schedule_date[$k];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);										
									}								
								}
								
							}
						}
						if($Schedule_criteria==2) //Mothly
						{
							$startDate=$from_date;
							$endDate=$to_date;
							while(strtotime($startDate) <= strtotime($endDate)) 
							{
								$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
								$startDate = $startDate12."-01";									
								if($startDate <= $endDate)
								{
									$first_day_of_month[]=$startDate;
								}									
							}									
							for($j=0;$j<count($first_day_of_month);$j++)
							{	
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{	
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$first_day_of_month[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
										
									}								
								}
							}								
						}
						if($Schedule_criteria==3) //Quaterly
						{
							$Quarter_of_year=array();
							$startDate=$from_date;
							$endDate=$to_date;								
							// Specify the start date. This date can be any English textual format  
							$date_from = $from_date;   
							$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
							// Specify the end date. This date can be any English textual format  
							$date_to =$to_date;  
							$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
							// Loop from the start date to end date and output all dates inbetween  
							for ($i=$date_from; $i<=$date_to; $i+=86400) 
							{								
								$startDate12 = date('m-d', $i);
								$Year = date('Y', $i);
								if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
								{
									$Quarter_of_year[]=$Year."-".$startDate12;
								}
							}
							for($j=0;$j<count($Quarter_of_year);$j++)
							{
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{	
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$Quarter_of_year[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
										
									}								
								}
							}								
						}
						if($Schedule_criteria==4) //Selected Date
						{
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{															
										$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));					
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$Select_day_date;
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);										
									}								
								}															
						}
					}					
				/**************Schedule Comminucation for Single or All Customer 31-05-2017--Ravi***************/				
			/**************Schedule Comminucation 31-05-2017--Ravi***************/
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
    }	
	public function edit_communication_offer($id)
	{
		$this->db->select('A.*,B.First_name,B.Last_name,C.Voucher_name');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.seller_id');
		$this->db->join('igain_company_voucher_catalogue as C', 'C.Voucher_id = A.Voucher_id','LEFT');
		$this->db->where(array('id'=>$id));
		
		$query41 = $this->db->get();
		 // echo $this->db->last_query();
		if($query41->num_rows() > 0)
		{
			foreach($query41->result() as $row41)
			{
				$edit_offer[] = $row41;
			}
			
			return $edit_offer;
		}
		else
		{
			return false;
		}
	}
	public function Check_communication_schedule($id)
	{
		$this->db->select('*');
		$this->db->from('igain_communication_schedule');
		$this->db->where(array('Comm_id'=>$id));	
		$CountQuery = $this->db->get();	
		// echo $this->db->last_query();
		return $CountQuery->num_rows();
	}	
	public function update_communication_offer($filepath)
	{

		$sellerID = $this->input->post('sellerId');
		$communication_id = $this->input->post('communication_id');
		
		$data['communication_plan'] = $this->input->post('offer');
		$data['Hobbie_id'] = $this->input->post('Offer_related_to');
		
		$data['activate'] = 'yes';
		$data['description'] = $this->input->post('offerdetails');
		
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));

		$data['seller_id'] = $this->input->post('sellerId');		
		$data['Company_id'] = $this->input->post('Company_id');
		
		$data['Share_file_path'] = $filepath;
		
		

		
		/***************Update Comminucation--05-06-2017-Ravi***************/		
		
			$data['Schedule_flag'] = $this->input->post('Schedule_flag');
			if($this->input->post('Schedule_flag') == 1)
			{
				$data['Link_to_lbs']=0;
				
			}
			else
			{
				$data['Link_to_lbs'] = $this->input->post('Link_to_lbs');
				$data['Custom_date']="";//0000-00-00
			}
			if($this->input->post('Link_to_lbs') == 1 )
			{
				$data['Custom_date']="";//0000-00-00
			}
			if( $this->input->post("facebook_social1") != "")
			{
				$data['Facebook'] = $this->input->post("facebook_social1");
			}
			else
			{
				$data['Facebook']='0';
			}
			if($this->input->post("twitter_social1") != "")
			{
				$data['Twitter'] = $this->input->post("twitter_social1");
			}
			else
			{
				$data['Twitter']='0';
			}
			if($this->input->post("googleplus_social1") != "")
			{
				$data['Google'] = $this->input->post("googleplus_social1");
			}
			else
			{
				$data['Google'] ='0';
			}
			
			if($data['Schedule_flag'] != '0')
			{
				$data['Schedule_criteria'] = $this->input->post('Schedule_criteria');			
				if($this->input->post('Schedule_weekly') !="" )
				{
					$data['Schedule_criteria_value'] = $this->input->post('Schedule_weekly');
				}
				else
				{
					$data['Schedule_criteria_value'] = 0;
				}
				if($this->input->post('r2') != "")
				{
					$data['Schedule_comm_for'] = $this->input->post('r2');
				}
				else
				{
					$data['Schedule_comm_for']='0';
				}
					
					
					if($this->input->post('r2') == 1) // Single Customer
					{
						$data['Schedule_comm_value'] = $this->input->post('mailtoone_memberid');
					}
					if($this->input->post('r2') == 2) // All Customer
					{
						$data['Schedule_comm_value'] = $this->input->post('mailtoall');
					}
					if($this->input->post('r2') == 5) // Tier Based Members
					{
						$data['Schedule_comm_value'] = $this->input->post('mailtotier');
					}
					if($this->input->post('r2') == 7) // Segment Based Members
					{
						$data['Schedule_comm_value'] = $this->input->post('Segment_code');
					}
					
				if($this->input->post('mailtoone_memberid') != "")
				{
					$data['Membership_id'] = $this->input->post('mailtoone_memberid');
				}	
				else
				{
					$data['Membership_id']='0';
				}
				if($data['Schedule_criteria']==2  || $data['Schedule_criteria']==3 )
				{
					$data['Schedule_criteria_value'] = date("m",strtotime($this->input->post("start_date")));;
				}
				if($data['Schedule_criteria']==4)
				{
					$data['Custom_date'] = date("Y-m-d",strtotime($this->input->post("Select_day_date")));;
				}
				else
				{
					$data['Custom_date']="";//0000-00-00
				}
				
					
					// var_dump($_POST);
					$radio1 = $this->input->post("r1");			//****send single or multiple offers.	 
					$radio2 = $this->input->post("r2");			//****send to single or all or key or worry customer.	
					$sellerid = $this->input->post("sellerId");
					$compid = $this->input->post("Company_id");
					$offerid = $this->input->post("activeoffer");
					$comm_id=$this->input->post('communication_id');
					$entry_date=date("Y-m-d");	
					$acitvate = '0';					
					if($radio2 == 1) //**single customer
					{
						// echo"---single----<br>";
						$cust_name = $this->input->post("mailtoone");
						$Enrollment_id = $this->input->post("Enrollment_id");						
						$member_email = $this->input->post("member_email");						
						$sendto = $Enrollment_id;						
					}
					if($radio2 == 2) //**all customer
					{
						$sendto = $this->input->post("mailtoall");
					}
					if($radio2 == 5) //**Tier based customer
					{
						// echo"---Tier based customer----<br>";
						$sendto = $this->input->post("mailtotier");
					} 
					
					
					$this->db->where(array('Comm_id' => $communication_id, 'Company_id' => $data['Company_id']));
					$this->db->delete('igain_communication_schedule');
					
					
					$from_date = date("Y-m-d",strtotime($this->input->post("start_date")));
					$to_date = date("Y-m-d",strtotime($this->input->post("end_date")));
					$Schedule_criteria = $this->input->post('Schedule_criteria');
					$Schedule_weekly = $this->input->post('Schedule_weekly');
					/**************Schedule Comminucation for Single or All Customer 31-05-2017--Ravi***************/
				// echo"---sendto----".$sendto."<br>";
				// echo"---radio2----".$radio2."<br>";
				// echo"---Schedule_criteria----".$Schedule_criteria."<br>";
				// die;
					if($radio2 < 3) //****single or all customer
					{
						if($sendto > 0)   //****single customer
						{
							$customer_details = $this->Igain_model->get_enrollment_details($sendto);							
							$Enrollement_id=$customer_details->Enrollement_id;
							$User_email_id=$customer_details->User_email_id;						
							if($Schedule_criteria==1) //Weekly
							{
								$counter=0;
								if($Schedule_weekly==1)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==1) //monday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==2)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==2) //Tuesday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==3)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	 
										 if(date("N",strtotime($from_date))==3) //Wedensday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==4)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	
										if(date("N",strtotime($from_date))==4) //Thursday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==5)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==5) //Friday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==6)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==6)  //Saturday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}
								if($Schedule_weekly==7)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==7)  // Sunday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}										
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));							
									}
								}	
								$schedule_count=count($schedule_date);
								for($i=0;$i<count($schedule_date);$i++)
								{
									$data1['Comm_id']=$comm_id;
									$data1['Company_id']=$compid;
									$data1['Enrollment_id']=$Enrollement_id;
									$data1['User_email_id']=$User_email_id;
									$data1['Schedule_date']=$schedule_date[$i];
									$data1['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data1);
								}							
							}
							if($Schedule_criteria==2) //Mothly
							{
								$startDate=$from_date;
								$endDate=$to_date;
								while(strtotime($startDate) <= strtotime($endDate)) 
								{
									$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
									$startDate = $startDate12."-01";									
									if($startDate <= $endDate)
									{
										$first_day_of_month[]=$startDate;
									}									
								}
								for($j=0;$j<count($first_day_of_month);$j++)
								{
									$data12['Comm_id']=$comm_id;
									$data12['Company_id']=$compid;
									$data12['Enrollment_id']=$Enrollement_id;
									$data12['User_email_id']=$User_email_id;
									$data12['Schedule_date']=$first_day_of_month[$j];
									$data12['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data12);
								}								
							}
							if($Schedule_criteria==3) //Quaterly
							{
								$Quarter_of_year=array();
								$startDate=$from_date;
								$endDate=$to_date;								
								// Specify the start date. This date can be any English textual format  
								$date_from = $from_date;   
								$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
								// Specify the end date. This date can be any English textual format  
								$date_to =$to_date;  
								$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
								// Loop from the start date to end date and output all dates inbetween  
								for ($i=$date_from; $i<=$date_to; $i+=86400) 
								{								
									// echo date("Y-m-d", $i).'<br />'; 									
									$startDate12 = date('m-d', $i);
									$Year = date('Y', $i);
									if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
									{
										// echo"---startDate--mm-".$Year."-".$startDate12."<br>";
										$Quarter_of_year[]=$Year."-".$startDate12;
									}
								}
								for($j=0;$j<count($Quarter_of_year);$j++)
								{
									$data13['Comm_id']=$comm_id;
									$data13['Company_id']=$compid;
									$data13['Enrollment_id']=$Enrollement_id;
									$data13['User_email_id']=$User_email_id;
									$data13['Schedule_date']=$Quarter_of_year[$j];
									$data13['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data13);
								}	
																	
							}
							if($Schedule_criteria==4) //Seleted Date
							{
								$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));
								$data13['Comm_id']=$comm_id;
								$data13['Company_id']=$compid;
								$data13['Enrollment_id']=$Enrollement_id;
								$data13['User_email_id']=$User_email_id;
								$data13['Schedule_date']=$Select_day_date;
								$data13['Sent_flag']='0';
								$this->db->insert('igain_communication_schedule', $data13);
																
							}					
						
						}
						if($sendto == 0)   //****all customer
						{			
							if($Schedule_criteria==1) //Weekly
							{
								$counter=0;
								if($Schedule_weekly==1)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==1) //monday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==2)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==2) //Tuesday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==3)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	 
										 if(date("N",strtotime($from_date))==3) //Wedensday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==4)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{	
										if(date("N",strtotime($from_date))==4) //Thursday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==5)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==5) //Friday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==6)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==6)  //Saturday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
									}
								}
								if($Schedule_weekly==7)
								{
									while(strtotime($from_date) <= strtotime($to_date))
									{
										if(date("N",strtotime($from_date))==7)  // Sunday
										{
											$counter++;
											$schedule_date[]=$from_date;
										}											
										$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));
									}
								}	
								for($k=0;$k<count($schedule_date);$k++)
								{					
									$all_customers = $this->Igain_model->get_all_customers($compid);	
									foreach ($all_customers as $row)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;
										$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);			
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$schedule_date[$k];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}
								}
							}									
							if($Schedule_criteria==2) //Mothly
							{
								// $startDate=date('Y-m-d', strtotime($from_date.'- 1 day'));
								$startDate=$from_date;
								$endDate=$to_date;
								while(strtotime($startDate) <= strtotime($endDate)) 
								{
									$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
									$startDate = $startDate12."-01";									
									if($startDate <= $endDate)
									{
										$first_day_of_month[]=$startDate;
									}									
								}									
								for($j=0;$j<count($first_day_of_month);$j++)
								{										
									$all_customers = $this->Igain_model->get_all_customers($compid);	
									foreach ($all_customers as $row)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;
										$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);			
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$first_day_of_month[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}	
								}								
							}
							if($Schedule_criteria==3) //Quaterly
							{
								$Quarter_of_year=array();
								$startDate=$from_date;
								$endDate=$to_date;								
								// Specify the start date. This date can be any English textual format  
								$date_from = $from_date;   
								$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
								// Specify the end date. This date can be any English textual format  
								$date_to =$to_date;  
								$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
								// Loop from the start date to end date and output all dates inbetween  
								for ($i=$date_from; $i<=$date_to; $i+=86400) 
								{								
									// echo date("Y-m-d", $i).'<br />'; 									
									$startDate12 = date('m-d', $i);
									$Year = date('Y', $i);
									if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
									{
										$Quarter_of_year[]=$Year."-".$startDate12;
									}
								}
								// print_r($Quarter_of_year);
								for($j=0;$j<count($Quarter_of_year);$j++)
								{
									$all_customers = $this->Igain_model->get_all_customers($compid);	
									foreach ($all_customers as $row)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;
										$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);			
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$Quarter_of_year[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}
									
								}
							}
							if($Schedule_criteria==4) //Seleted Date
							{
								$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{										
									$customer_details = $this->Igain_model->get_enrollment_details($row['Enrollement_id']);	
									$data1['Comm_id']=$comm_id;
									$data1['Company_id']=$compid;										
									$data1['Enrollment_id']=$customer_details->Enrollement_id;
									$data1['User_email_id']=$customer_details->User_email_id;
									$data1['Schedule_date']=$Select_day_date;
									$data1['Sent_flag']='0';
									$this->db->insert('igain_communication_schedule', $data1);
								}
																
							}
						}
						
					}
					if($radio2 == 5) //****for tier based cust
					{		
						if($Schedule_criteria==1) //Weekly
						{
							$counter=0;
							if($Schedule_weekly==1)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==1) //monday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==2)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==2) //Tuesday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==3)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	 
									 if(date("N",strtotime($from_date))==3) //Wedensday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==4)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	
									if(date("N",strtotime($from_date))==4) //Thursday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==5)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==5) //Friday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==6)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==6)  //Saturday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==7)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==7)  // Sunday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}											
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));
								}
							}	
							for($k=0;$k<count($schedule_date);$k++)
							{					
								$selected_tier = $sendto; 
								$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
								if($tier_based_customers != false)
								{										
									foreach($tier_based_customers as $cust_regid)
									{										
										$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
										if($customer_details != NULL)
										{
											$data1['Comm_id']=$comm_id;
											$data1['Company_id']=$compid;												
											$data1['Enrollment_id']=$customer_details->Enrollement_id;
											$data1['User_email_id']=$customer_details->User_email_id;
											$data1['Schedule_date']=$schedule_date[$k];
											$data1['Sent_flag']='0';
											$this->db->insert('igain_communication_schedule', $data1);
										}
									}
								}
								
							}
						}
						if($Schedule_criteria==2) //Mothly
						{
							$startDate=$from_date;
							$endDate=$to_date;
							while(strtotime($startDate) <= strtotime($endDate)) 
							{
								$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
								$startDate = $startDate12."-01";									
								if($startDate <= $endDate)
								{
									$first_day_of_month[]=$startDate;
								}									
							}									
							for($j=0;$j<count($first_day_of_month);$j++)
							{	
								$selected_tier = $sendto; 
								$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
								if($tier_based_customers != false)
								{										
									foreach($tier_based_customers as $cust_regid)
									{
										
										$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
										if($customer_details != NULL)
										{
											$data1['Comm_id']=$comm_id;
											$data1['Company_id']=$compid;												
											$data1['Enrollment_id']=$customer_details->Enrollement_id;
											$data1['User_email_id']=$customer_details->User_email_id;
											$data1['Schedule_date']=$first_day_of_month[$j];
											$data1['Sent_flag']='0';
											$this->db->insert('igain_communication_schedule', $data1);
										}
									}
								}
							}								
						}
						if($Schedule_criteria==3) //Quaterly
						{
							$Quarter_of_year=array();
							$startDate=$from_date;
							$endDate=$to_date;								
							// Specify the start date. This date can be any English textual format  
							$date_from = $from_date;   
							$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
							// Specify the end date. This date can be any English textual format  
							$date_to =$to_date;  
							$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
							// Loop from the start date to end date and output all dates inbetween  
							for ($i=$date_from; $i<=$date_to; $i+=86400) 
							{								
								$startDate12 = date('m-d', $i);
								$Year = date('Y', $i);
								if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
								{
									$Quarter_of_year[]=$Year."-".$startDate12;
								}
							}
							for($j=0;$j<count($Quarter_of_year);$j++)
							{
								$selected_tier = $sendto; 
								$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
								if($tier_based_customers != false)
								{										
									foreach($tier_based_customers as $cust_regid)
									{
										
										$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
										if($customer_details != NULL)
										{
											$data1['Comm_id']=$comm_id;
											$data1['Company_id']=$compid;												
											$data1['Enrollment_id']=$customer_details->Enrollement_id;
											$data1['User_email_id']=$customer_details->User_email_id;
											$data1['Schedule_date']=$Quarter_of_year[$j];
											$data1['Sent_flag']='0';
											$this->db->insert('igain_communication_schedule', $data1);
										}
									}
								}
								
							}							
						}
						if($Schedule_criteria==4) //Seleted Date
						{
							$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));
							$selected_tier = $sendto; 
							$tier_based_customers = $this->Administration_model->tier_based_customers($selected_tier,$compid);
							if($tier_based_customers != false)
							{										
								foreach($tier_based_customers as $cust_regid)
								{
									
									$customer_details = $this->Igain_model->get_enrollment_details($cust_regid->Enrollement_id);
									if($customer_details != NULL)
									{
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$customer_details->Enrollement_id;
										$data1['User_email_id']=$customer_details->User_email_id;
										$data1['Schedule_date']=$Select_day_date;
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
									}
								}
							}
															
						}
					}
					if($radio2 == 7) //**segments
					{
						$Segment_code = $this->input->post("Segment_code");	
						if($Schedule_criteria==1) //Weekly
						{
							$counter=0;
							if($Schedule_weekly==1)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==1) //monday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==2)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==2) //Tuesday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==3)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	 
									 if(date("N",strtotime($from_date))==3) //Wedensday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==4)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{	
									if(date("N",strtotime($from_date))==4) //Thursday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==5)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==5) //Friday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==6)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==6)  //Saturday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));						
								}
							}
							if($Schedule_weekly==7)
							{
								while(strtotime($from_date) <= strtotime($to_date))
								{
									if(date("N",strtotime($from_date))==7)  // Sunday
									{
										$counter++;
										$schedule_date[]=$from_date;
									}											
									$from_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_date)));
								}
							}	
							for($k=0;$k<count($schedule_date);$k++)
							{					
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{	
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$schedule_date[$k];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);										
									}								
								}
								
							}
						}
						if($Schedule_criteria==2) //Mothly
						{
							$startDate=$from_date;
							$endDate=$to_date;
							while(strtotime($startDate) <= strtotime($endDate)) 
							{
								$startDate12 = date('Y-m', strtotime($startDate.'+ 1 month'));									
								$startDate = $startDate12."-01";									
								if($startDate <= $endDate)
								{
									$first_day_of_month[]=$startDate;
								}									
							}									
							for($j=0;$j<count($first_day_of_month);$j++)
							{	
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{	
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$first_day_of_month[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
										
									}								
								}
							}								
						}
						if($Schedule_criteria==3) //Quaterly
						{
							$Quarter_of_year=array();
							$startDate=$from_date;
							$endDate=$to_date;								
							// Specify the start date. This date can be any English textual format  
							$date_from = $from_date;   
							$date_from = strtotime($date_from); // Convert date to a UNIX timestamp								  
							// Specify the end date. This date can be any English textual format  
							$date_to =$to_date;  
							$date_to = strtotime($date_to); // Convert date to a UNIX timestamp								  
							// Loop from the start date to end date and output all dates inbetween  
							for ($i=$date_from; $i<=$date_to; $i+=86400) 
							{								
								$startDate12 = date('m-d', $i);
								$Year = date('Y', $i);
								if($startDate12=='01-01' || $startDate12=='04-01' || $startDate12=='07-01' || $startDate12=='09-01')
								{
									$Quarter_of_year[]=$Year."-".$startDate12;
								}
							}
							for($j=0;$j<count($Quarter_of_year);$j++)
							{
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{	
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$Quarter_of_year[$j];
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);
										
									}								
								}
							}								
						}
						if($Schedule_criteria==4) //Selected Date
						{
								$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
								$Customer_array=array();						
								$all_customers = $this->Igain_model->get_all_customers($compid);	
								foreach ($all_customers as $row)
								{
									$Applicable_array[]=0;
									unset($Applicable_array);
									foreach($Get_segments2 as $Get_segments)
									{
										if($Get_segments->Segment_type_id==1)  // 	Age 
										{
											$lv_Cust_value=date_diff(date_create($row["Date_of_birth"]), date_create('today'))->y;
											// echo "****Age--".$lv_Cust_value;
										}											
										if($Get_segments->Segment_type_id==2)//Sex
										{
											$lv_Cust_value=$row['Sex'];
											// echo "****Sex ".$lv_Cust_value;
										}
										if($Get_segments->Segment_type_id==3)//Country
										{
											$lv_Country_id=$row['Country_id'];
											// echo "****Country_id ".$lv_Country_id;
											$currency_details = $this->currency_model->edit_currency($lv_Country_id);
											$lv_Cust_value = $currency_details->Country_name;
											// echo "****Country_name ".$lv_Cust_value."****input Country_name ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==4)//District
										{
											$lv_Cust_value=$row['District'];
											
											// echo "****District ".$lv_Cust_value."****input District ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==5)//State
										{
											$lv_Cust_value=$row['State'];
											
											// echo "****State ".$lv_Cust_value."****input State ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==6)//city
										{
											$lv_Cust_value=$row['City'];
											
											// echo "****City ".$lv_Cust_value."****input City ".$Get_segments->Value."<br>"; 
											
											if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
											{
												$Get_segments->Value=$lv_Cust_value;
											}
										}
										if($Get_segments->Segment_type_id==7)//Zipcode
										{
											$lv_Cust_value=$row['Zipcode'];
											
											// echo "****Zipcode ".$lv_Cust_value."****input Zipcode ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
										{
											$lv_Cust_value=$row['total_purchase'];
											
											// echo "****total_purchase ".$lv_Cust_value."****input total_purchase ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
										{
											$lv_Cust_value=$row['Total_reddems'];
											
											// echo "****Total_reddems ".$lv_Cust_value."****input Total_reddems ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$row["Enrollement_id"],$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records)
											{
												$lv_Cust_value=$Trans_Records->Total_Gained_Points;
											}
											
											// echo "****Total_Gained_Points ".$lv_Cust_value."****input Total_Gained_Points ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
										{
											$start_date=$row['joined_date'];
											$end_date=date("Y-m-d");
											$transaction_type_id=2;
											$Tier_id=$row['Tier_id'];
											
											$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$row["Enrollement_id"],$transaction_type_id,$Tier_id,'','');
											foreach($Trans_Records as $Trans_Records){
												$lv_Max_amt[]=$Trans_Records->Purchase_amount;
											}
											$lv_Cust_value=max($lv_Max_amt);
											// echo "****Single Transaction Amount ".$lv_Cust_value."****input Single Transaction Amount ".$Get_segments->Value."<br>"; 
										}
										if($Get_segments->Segment_type_id==12)//Membership Tenor
										{
											$tUnixTime = time();
											list($year,$month, $day) = EXPLODE('-', $row["joined_date"]);
											$timeStamp = mktime(0, 0, 0, $month, $day, $year);
											$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
											// echo "****Membership Tenor ".$lv_Cust_value."****input Membership Tenor ".$Get_segments->Value."<br>"; 
										}
										
										$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
											
										$Applicable_array[]=$Get_segments;
									}
									// print_r($Applicable_array);								
									if(!in_array(0, $Applicable_array, true))
									{															
										$Select_day_date = date("Y-m-d",strtotime($this->input->post("Select_day_date")));					
										$data1['Comm_id']=$comm_id;
										$data1['Company_id']=$compid;												
										$data1['Enrollment_id']=$row['Enrollement_id'];
										$data1['User_email_id']=$row['User_email_id'];
										$data1['Schedule_date']=$Select_day_date;
										$data1['Sent_flag']='0';
										$this->db->insert('igain_communication_schedule', $data1);										
									}								
								}															
						}
					}					
				/**************Schedule Comminucation for Single or All Customer 31-05-2017--Ravi***************/				
				/**************Schedule Comminucation 31-05-2017--Ravi***************/
					
			}
			else
			{
				$data['Schedule_criteria'] = 0;
				$data['Schedule_criteria_value'] = 0;
				$data['Schedule_comm_for']=0;
				$data['Schedule_comm_value']="";
				$data['Membership_id']=0;
				
				$this->db->where(array('Comm_id' => $communication_id, 'Company_id' => $data['Company_id']));
				$this->db->delete('igain_communication_schedule');
				
			}
			/***************Update Comminucation--05-06-2017-Ravi***************/
			
			
		/**************Voucher Link Comminucation 26-02-2020--Ravi***************/
			$data['Link_to_voucher'] = $this->input->post('Link_to_voucher');
			if($data['Link_to_voucher'] != 0){
				$data['Voucher_type'] = $this->input->post('Voucher_type');
				$data['Voucher_id']= $this->input->post('Voucher_id');
			} else {
				$data['Voucher_type'] = 0;
				$data['Voucher_id']= 0;
			}
			// 
		/**************Voucher Link Comminucation 26-02-2020--Ravi***************/	
		
		/**************Birthday Communication 09-03-2020--Ravi***************/
			$data['Birthday_flag'] = $this->input->post('Birthday_flag');
			if($data['Birthday_flag'] != 0){
				$data['Birthday_flag'] = $this->input->post('Birthday_flag');
			} else {
				$data['Birthday_flag'] = 0;
			}
		/**************Birthday Communication 09-03-2020--Ravi***************/
		
		$this->db->where(array('id'=>$communication_id));  //, 'seller_id'=>$sellerID 
		$this->db->update('igain_seller_communication', $data);		
		// die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function communication_count($Company_id,$Comm_type)
	{
		$this->db->select('*');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.seller_id');
		$this->db->where(array('B.Company_id' => $Company_id,'A.Comm_type' => $Comm_type));
		return $this->db->count_all_results();
	}		
	public function Fetch_schedule_communications($Company_id)
	{
		$todays=date('Y-m-d');
		$this->db->select('*');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_communication_schedule as B', 'B.Comm_id = A.id');
		$this->db->where(array('B.Company_id' => $Company_id,'B.Schedule_date' => $todays,'B.Sent_flag' => 0,'A.activate' => 'yes'));
		$this->db->order_by('A.id','DESC');
		$query = $this->db->get();
		// echo $this->db->last_query()."<br>";
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
	public function Update_schedule_communications($Schedule_id)
	{
		$update_data=array('Sent_flag' => '1');
		$this->db->where(array('Schedule_id' => $Schedule_id));
		$this->db->update("igain_communication_schedule", $update_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function communication_offer_list($limit,$start,$Company_id,$Comm_type)
	{
		$this->db->select('*');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.seller_id');
		$this->db->join('igain_communication_schedule as C', 'A.id = C.Comm_id','LEFT');
		$this->db->where(array('B.Company_id' => $Company_id,'A.Comm_type' => $Comm_type));
		
		$this->db->limit($limit,$start);
		$this->db->group_by('A.id','DESC');
		$this->db->order_by('A.id','DESC');
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
   
	public function delete_communication_offer($id)
	{
		$this->db->where(array('Comm_id' => $id));
		$this->db->delete('igain_communication_schedule');
		// $this->db->where(array('id' => $id, 'seller_id' => $seller_id));
		$this->db->where(array('id' => $id));
		$this->db->delete('igain_seller_communication');
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	
	public function communication_acivate_deactivate($id,$seller_id,$activate)
	{
		if($activate == 'yes')
		{
			$update_data=array('activate' => 'no');
		}
		else
		{
			$update_data=array('activate' => 'yes');
		}
		$this->db->where(array('id' => $id, 'seller_id' => $seller_id));
		$this->db->update("igain_seller_communication", $update_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function check_communication_offer($communication_plan,$Seller_id)
	{
		$query =  $this->db->select('communication_plan')
				   ->from('igain_seller_communication')
				   ->where(array('communication_plan' => $communication_plan, 'seller_id' => $Seller_id))->get();
		return $query->num_rows();
	}
	
	function get_communication_offers($Seller_id,$Company_id,$Comm_type)
	{
		$dateIS = date("Y-m-d");
		
		if($Seller_id == 0)
		{
			/*****************************For All Sellers*****************************/
				$seller_array=array();
				$this->db->select("Enrollement_id");
				$this->db->from('igain_enrollment_master');
				$this->db->where(array('User_id' => '2','User_activated' => '1'));//, 'Company_id' => $Company_id
				$query = $this->db->get();
				
				foreach ($query->result() as $row)
				{
					$sellers=array_push($seller_array,$row->Enrollement_id);
					$All_sellers = implode(",", $seller_array);
				}
			/*****************************For All Sellers*****************************/
			
			$this->db->select("id,communication_plan");
			$this->db->from('igain_seller_communication');			
			$this->db->where_in('seller_id',$All_sellers);
			$this->db->where(array('activate' => 'yes','Comm_type' => $Comm_type ));
			$this->db->where('Till_date > ',$dateIS);
			$sql = $this->db->get();
		}
		else
		{
			$this->db->select("id,communication_plan");
			$this->db->from('igain_seller_communication');
			$this->db->where(array('seller_id' => $Seller_id,'activate' => 'yes','Comm_type' => $Comm_type));
			$this->db->where('Till_date > ',$dateIS);
			$sql = $this->db->get();
		}
		
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	
	function get_offer_details($offerid)
	{
		$this->db->select("*");
		$this->db->from('igain_seller_communication');			
		$this->db->where('id',$offerid);
		$sql = $this->db->get();
		return $sql->row();//->row('description');
	}
	
	public function get_customer_name($keyword,$Company_id) 
	{        
		$this->db->select("First_name,Last_name");
        $this->db->order_by('First_name', 'ASC');
        $this->db->like("First_name", $keyword);
		$this->db->where(array('User_id' => '1','User_activated' => '1','Company_id' => $Company_id));
        $query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['First_name']))." ".htmlentities(stripslashes($row['Last_name']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
    }
	
	public function get_phnno_memberid($Cust_name,$Company_id) 
	{        
		$cust_name = explode(" ",$Cust_name);
		$this->db->select("Enrollement_id,Card_id,Phone_no");
		$this->db->like("First_name", $cust_name[0]);
		$this->db->where(array('User_id' => '1','User_activated' => '1','Company_id' => $Company_id));	//,'Card_id' => '0'
        $query = $this->db->get('igain_enrollment_master');
		return $query->result_array();
    }
	
	function insert_cust_notification($data,$insert_flag)
    {
		if($insert_flag == "1")
		{
			$this->db->insert('igain_cust_notification', $data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		else
		{
			$this->db->insert_batch('igain_cust_notification', $data);
			if($this->db->affected_rows() > 0)
			{
				return $this->db->affected_rows();
			}
		}		
    }
	
	function get_multiple_offers($Seller_id,$Comm_type)
	{
		$this->db->select('A.id,B.First_name,B.Last_name,A.communication_plan,A.description');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.seller_id');
		$this->db->where(array('A.seller_id' => $Seller_id,'A.Comm_type' => $Comm_type, 'A.activate' => 'yes'));
		$this->db->order_by('A.id','DESC');
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
	
	function get_key_worry_customers($Seller_id,$Company_id,$r2Value,$mailtokey)
	{
		$this->load->model('igain_model');
		$seller_details = $this->igain_model->get_enrollment_details($Seller_id);
		if($r2Value == 3)
		{
			$key_worry_customers = $this->get_key_customers($r2Value,$seller_details->User_id,$Seller_id,$seller_details->Super_seller,$mailtokey,$Company_id);
		}
		else
		{
			$key_worry_customers = $this->get_worry_customers($r2Value,$seller_details->User_id,$Seller_id,$seller_details->Super_seller,$mailtokey,$Company_id);
		}
		return	$key_worry_customers;
	}
	
	function get_key_customers($r2Value,$User_id,$Seller_id,$Super_seller,$mailtokey,$Company_id)
	{
		$i = 0;  $custenroll_ids = array();  $cust_array1 = array();
		$lastmonth = date("Y-m-d", strtotime("-3 month")); /*** last 3 month ***/
		$thismonth = date("Y-m-d");
		
		if($User_id == 2) //*****seller
		{
			if($Super_seller == 1)
			{
				$this->db->select('Enrollement_id');
				$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1'));
				$query = $this->db->get('igain_enrollment_master');
				
				if($query->num_rows() > 0)
				{			
					foreach ($query->result_array() as $row)
					{
						$cust_array1[] = $row['Enrollement_id'];
					}
				}

				foreach($cust_array1 as $cust1)
				{
					$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
					$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1));
					$this->db->where("Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' ");
					$query1 = $this->db->get('igain_transaction');
					
					foreach ($query1->result_array() as $row1)
					{
						$trn_count = $row1['count(Purchase_amount)'];
						$trn_date = $row1['max(Trans_date)'];
						
						if($mailtokey == 1) //***Purchase more than 2 times*****
						{
							if($trn_count >= 2 && $trn_date > $lastmonth)/*** grt than 2 and less than 3 ***/
							{
								//echo "--working --- ";
								$custenroll_ids[$i] = $row1['Enrollement_id'];
							}
						}
						if($mailtokey == 2) //***Purchase more than 3 times*****
						{
							if($trn_count >= 3 && $trn_date > $lastmonth )/*** grt than 3 and less than 5 ***/	//&& $trn_count < 5 
							{
								$custenroll_ids[$i] = $row1['Enrollement_id'];
							}
						}
						if($mailtokey == 3) //***Purchase more than 5 times*****
						{
							if($trn_count >= 5 && $trn_date > $lastmonth )/*** grt than 5 ***/
							{
							$custenroll_ids[$i] = $row1['Enrollement_id'];
							}
						}									
						$i++;
					}
				}
			}
			else
			{
				$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
				$this->db->where(array('Trans_type' => '2', 'Seller' => $Seller_id));
				$this->db->group_by("Enrollement_id"); 
				$query1 = $this->db->get('igain_transaction');
				
				foreach ($query1->result_array() as $row1)
				{
					$trn_count = $row1['count(Purchase_amount)'];
					$trn_date = $row1['max(Trans_date)'];
					
					if($mailtokey == 1) //***Purchase more than 2 times*****
					{
						if($trn_count >= 2 && $trn_date > $lastmonth)/*** grt than 2 and less than 3 ***/
						{
							//echo "--working --- ";
							$custenroll_ids[$i] = $row1['Enrollement_id'];
						}
					}
					if($mailtokey == 2) //***Purchase more than 3 times*****
					{
						if($trn_count >= 3 && $trn_date > $lastmonth )/*** grt than 3 and less than 5 ***/ //&& $trn_count < 5 
						{
							$custenroll_ids[$i] = $row1['Enrollement_id'];
						}
					}
					if($mailtokey == 3) //***Purchase more than 5 times*****
					{
						if($trn_count >= 5 && $trn_date > $lastmonth )/*** grt than 5 ***/
						{
						$custenroll_ids[$i] = $row1['Enrollement_id'];
						}
					}									
					$i++;
				}
			}
		}
		else if($User_id == 3)//******dealer login
		{
			$this->db->select('Enrollement_id');
			$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1'));
			$query = $this->db->get('igain_enrollment_master');
			
			if($query->num_rows() > 0)
			{			
				foreach ($query->result_array() as $row)
				{
					$cust_array1[] = $row['Enrollement_id'];
				}
			}

			foreach($cust_array1 as $cust1)
			{
				$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
				$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1));
				$this->db->where("Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' ");
				$query1 = $this->db->get('igain_transaction');
				
				foreach ($query1->result_array() as $row1)
				{
					$trn_count = $row1['count(Purchase_amount)'];
					$trn_date = $row1['max(Trans_date)'];
					
					if($mailtokey == 1) //***Purchase more than 2 times*****
					{
						if($trn_count >= 2 && $trn_date > $lastmonth)/*** grt than 2 and less than 3 ***/
						{
							//echo "--working --- ";
							$custenroll_ids[$i] = $row1['Enrollement_id'];
						}
					}
					if($mailtokey == 2) //***Purchase more than 3 times*****
					{
						if($trn_count >= 3 && $trn_date > $lastmonth )/*** grt than 3 and less than 5 ***/
						{
							$custenroll_ids[$i] = $row1['Enrollement_id'];
						}
					}
					if($mailtokey == 3) //***Purchase more than 5 times*****
					{
						if($trn_count >= 5 && $trn_date > $lastmonth )/*** grt than 5 ***/
						{
						$custenroll_ids[$i] = $row1['Enrollement_id'];
						}
					}									
					$i++;
				}
			}
		}
		
		return	$custenroll_ids;
	}
	
	
	function get_worry_customers($r2Value,$User_id,$Seller_id,$Super_seller,$mailtokey,$Company_id)
	{
		$i = 0;  $custenroll_ids = array();  $cust_array1 = array();
		if($mailtokey == 1) //***No Purchase in last 1 month*****
		{
			$lastmonth = date("Y-m-d", strtotime("-1 month")); /*** last 1 month ***/
		}
		if($mailtokey == 2) //***No Purchase in last 2 month*****
		{
			$lastmonth = date("Y-m-d", strtotime("-2 month")); /*** last 2 month ***/
		}
		if($mailtokey == 3) //***No Purchase in last 3 month***
		{
			$lastmonth = date("Y-m-d", strtotime("-3 month")); /*** last 3 month ***/
		}
		
		$this->db->select('Enrollement_id');
		$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1', 'joined_date <' => $lastmonth));
		$query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$cust_array1[] = $row['Enrollement_id'];
			}
		}
		
		if($User_id == 3)
		{
			foreach($cust_array1 as $cust1)
			{
				$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
				$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1));
				$query1 = $this->db->get('igain_transaction');
				
				foreach ($query1->result_array() as $row1)
				{
					$trn_count = $row1['count(Purchase_amount)'];
					$trn_date = $row1['max(Trans_date)'];
					
					if($trn_date < $lastmonth || $trn_count == 0)
					{
						$custenroll_ids[$i++] = $row1['Enrollement_id'];
					}
				}
			}
		}
		else if($User_id == 2)
		{
			if($Super_seller == 1)
			{
				foreach($cust_array1 as $cust1)
				{
					$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
					$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1));
					$query1 = $this->db->get('igain_transaction');
					
					foreach ($query1->result_array() as $row1)
					{
						$trn_count = $row1['count(Purchase_amount)'];
						$trn_date = $row1['max(Trans_date)'];
						
						if($trn_date < $lastmonth || $trn_count == 0)
						{
							$custenroll_ids[$i++] = $row1['Enrollement_id'];
						}
					}
				}
			}
			else
			{
				foreach($cust_array1 as $cust1)
				{
					$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
					$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1));
					$query1 = $this->db->get('igain_transaction');
					
					foreach ($query1->result_array() as $row1)
					{
						$trn_count = $row1['count(Purchase_amount)'];
						$trn_date = $row1['max(Trans_date)'];
						
						if($trn_date < $lastmonth || $trn_count == 0)
						{
							$custenroll_ids[$i++] = $cust1;
						}
					}
				}
			}
		}
		
		return	$custenroll_ids;
	}
	
	/***********************************Auction Starts******************************/
	function insert_auction($filepath)
    {
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("startDate")));
		$data['To_date'] = date("Y-m-d",strtotime($this->input->post("endDate")));		
		$data['End_time'] = $this->input->post('THH').":".$this->input->post('TMM').":00";		
		$data['Auction_name'] = $this->input->post('auction_name');
		$data['Prize'] = $this->input->post('prize');
		$data['Min_bid_value'] = $this->input->post('minpointstobid');
		$data['Min_increment'] = $this->input->post('minincrement');
		$data['Prize_description'] = $this->input->post('description');
		$data['Trigger_notification_start_days'] = $this->input->post('Trigger_notification_start_days');
		$data['Trigger_notification_end_days'] = $this->input->post('Trigger_notification_end_days');
		$data['Create_user_id'] = $this->input->post('Create_user_id');
		$data['Creation_date'] = date("Y-m-d H:m:s");
		$data['Company_id'] = $this->input->post('Company_id');
		$data['Prize_image'] = $filepath;
		$data['Active_flag'] = '1';
		
		$this->db->insert('igain_auction_master', $data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		
		
    }
	
	public function auction_count($Company_id)
	{
		$this->db->from('igain_auction_master');
		$this->db->where(array('Company_id' => $Company_id, 'Active_flag' => '1'));
		return $this->db->count_all_results();
	}
	
	public function auction_list($limit,$start,$Company_id)
	{
		$this->db->from('igain_auction_master');
		$this->db->where(array('Company_id' => $Company_id, 'Active_flag' => '1'));
		//$this->db->limit($limit,$start);
		$this->db->order_by('Auction_id','DESC');
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
	
	function delete_auction($Com_id,$Auction_id)
	{
		$this->db->select('Id');
		$this->db->where(array("Auction_id"=>$Auction_id,"Company_id"=>$Com_id));

		$query46 = $this->db->get("igain_auction_winner");
		
		if ($query46->num_rows() > 0)
		{
			return false;
		}
		else
		{
		$this->db->where("Auction_id",$Auction_id);
		$this->db->delete("igain_auction_master");
		
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
	}
	
	function edit_auction($Auction_id)
	{
		$this->db->where("Auction_id",$Auction_id);
		$query = $this->db->get("igain_auction_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}	
	}
	
	public function update_auction($filepath)
	{
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("startDate")));
		$data['To_date'] = date("Y-m-d",strtotime($this->input->post("endDate")));		
		$data['End_time'] = $this->input->post('THH').":".$this->input->post('TMM').":00";		
		$data['Auction_name'] = $this->input->post('auction_name');
		$data['Prize'] = $this->input->post('prize');
		$data['Min_bid_value'] = $this->input->post('minpointstobid');
		$data['Min_increment'] = $this->input->post('minincrement');
		$data['Prize_description'] = $this->input->post('description');
		$data['Trigger_notification_start_days'] = $this->input->post('Trigger_notification_start_days');
		$data['Trigger_notification_end_days'] = $this->input->post('Trigger_notification_end_days');
		$data['Update_user_id'] = $this->input->post('Update_user_id');
		$data['Update_date'] = date("Y-m-d H:m:s");
		$data['Prize_image'] = $filepath;
		
		$Auction_id = $this->input->post('Auction_id');
		$this->db->where('Auction_id', $Auction_id);
		$this->db->update("igain_auction_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function check_auction_name($Auction_name,$Company_id)
	{		
		$this->db->from('igain_auction_master');
		$this->db->where(array('Auction_name' => $Auction_name, 'Company_id' => $Company_id));
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function get_max_bid_value($Company_id)
	{
		$this->db->select_max('Bid_value');
		$this->db->where(array("Company_id" => $Company_id,"Active_flag" =>'0'));
		$this->db->group_by("Auction_id"); 
		$query = $this->db->get("igain_auction_winner");
		
		//echo $this->db->last_query()."<br><br>";
		
		if ($query->num_rows() > 0)
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
			return 0;
		}
	}
	
	public function auction_winners_list($Company_id,$Max_Bid_value)
	{
		$today = date("Y-m-d");
		
		$this->db->select('B.Id, B.Creation_date, B.Enrollment_id, B.Auction_id, B.Bid_value, C.First_name, C.Middle_name, C.Last_name, A.Auction_name, A.End_time, A.Prize,  A.To_date');
		$this->db->from('igain_auction_master as A');
		$this->db->join('igain_auction_winner as B','B.Auction_id = A.Auction_id');
		$this->db->join('igain_enrollment_master as C','B.Enrollment_id = C.Enrollement_id');
		$this->db->where(array('B.Winner_flag' => '0', 'B.Active_flag' => '0', 'A.Active_flag' => '1', 'A.To_date <' => $today,'B.Company_id' => $Company_id, 'B.Bid_value' => $Max_Bid_value));
		$query = $this->db->get();
		//echo $this->db->last_query()."<br><br>";
		
		if ($query->num_rows() > 0)
		{
        	return $query->result_array();
        }
		else
		{
			return 0;
		}
	}
	
	public function approved_auction_list($Company_id)
	{
		$this->db->select('B.Id, B.Creation_date, B.Enrollment_id, B.Auction_id, B.Bid_value, C.First_name, C.Middle_name, C.Last_name, A.Auction_name, A.End_time, A.Prize,  A.To_date');
		$this->db->from('igain_auction_master as A');
		$this->db->join('igain_auction_winner as B','B.Auction_id = A.Auction_id');
		$this->db->join('igain_enrollment_master as C','B.Enrollment_id = C.Enrollement_id');
		$this->db->where(array('B.Winner_flag' => '1', 'B.Active_flag' => '0', 'A.Active_flag' => '0', 'B.Company_id' => $Company_id));
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->result_array();
        }
		else
		{
			return 0;
		}
	}
	
	public function get_auction_cust_details($Id,$Auction_id,$Enrollment_id)
	{
		$this->db->where(array('Id' => $Id, 'Auction_id' => $Auction_id, 'Enrollment_id' => $Enrollment_id));
		$query = $this->db->get("igain_auction_winner");
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	public function update_cust_details($Enrollment_id,$data)
	{
		$this->db->where(array('Enrollement_id' => $Enrollment_id));
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
	
	public function approve_auction_winner($Id,$Auction_id,$Enrollment_id)
	{
		$Todays_date = date("Y-m-d");
		$update_date = array('Winner_flag' => '1', 'Creation_date' => $Todays_date);
		$this->db->where(array('Id' => $Id, 'Auction_id' => $Auction_id, 'Enrollment_id' => $Enrollment_id));
		$this->db->update("igain_auction_winner", $update_date);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function delete_auction_winner($Id,$Auction_id,$Enrollment_id)
	{
		$Todays_date = date("Y-m-d");
		$update_date = array('Active_flag' => '1');
		
		//$this->db->where(array('Id' => $Id, 'Auction_id' => $Auction_id, 'Enrollment_id' => $Enrollment_id));
		$this->db->where(array('Auction_id' => $Auction_id));
		$this->db->update("igain_auction_winner", $update_date);
		
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function update_auction_master($Auction_id,$Company_id)
	{
		$update_date = array('Active_flag' => '0');
		$this->db->where(array('Auction_id' => $Auction_id, 'Company_id' => $Company_id));
		$this->db->update("igain_auction_master", $update_date);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/***********************************Auction Ends******************************/
	
//*****************************************Akshay Ends*************************************************

/************************************************AMIT STARTUP*****************************************/	
   public function referral_rule_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$this->db->select('*');
        $this->db->from('igain_seller_refrencerule as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.Seller_id');
		$this->db->where('A.Company_id', $Company_id);
		
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

   public function referral_rule_count($Company_id)
	{
		$this->db->select('refid');
        $this->db->from('igain_seller_refrencerule as A');
		$this->db->where('A.Company_id', $Company_id);
		
		$querySD = $this->db->get();
		
		return $querySD->num_rows();
	}
	 
   
	function check_referral_rule($Company_id,$seller_id,$referral_rule_for)
	{ 
		
		$query =  $this->db->select('Seller_id')
				   ->from('igain_seller_refrencerule')
				   ->where(array('Seller_id' => $seller_id, 'Company_id' => $Company_id, 'Referral_rule_for' => $referral_rule_for))->get();
		return $query->num_rows();
	}
	function insert_referral_rule($Company_id,$data)
    {		
		$this->db->insert('igain_seller_refrencerule', $data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
	
	function update_referral_rule($Company_id,$refid)
    {		
		$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
		$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		$data['Seller_id'] = $this->input->post('new_seller_id');
		$data['Referral_rule_for'] = $this->input->post('new_referral_rule_for');
		$data['From_date'] = $from_date;
		$data['Till_date'] = $to_date;
		$data['Customer_topup'] = $this->input->post('tonewcust');
		$data['Refree_topup'] = $this->input->post('toRefree');
		//$data['Tier_id'] = $this->input->post('member_tier_id');
		/* echo "<br> Company_id  ".$Company_id;
		echo "<br> refid  ".$refid;
		echo "<br> from_date  ".$from_date;
		die; */
		
		
		$this->db->where('refid', $refid);
		$this->db->update('igain_seller_refrencerule', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function delete_referral_rule($refid)
	{
		//echo "refid ".$refid;die;
		$this->db->where("refid",$refid);
		$this->db->delete("igain_seller_refrencerule");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function edit_referral_rule($refid)
	{
		$edit_query = "SELECT * FROM igain_seller_refrencerule WHERE refid=$refid LIMIT 1";
		
		$edit_sql = $this->db->query($edit_query);
				
		if($edit_sql -> num_rows() == 1)
		{
			return $edit_sql->row();
		}
		else
		{
			return false;
		}	
	}
	
	public function deposit_topup_list($limit,$start,$Company_id)
	{
		$this->db->select('*');
        $this->db->from('igain_compseller_trans_tbl as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.Seller_id');
		$this->db->join('igain_transaction_type as C', 'C.Trans_type_id = A.Trans_type');
		$this->db->where('A.Company_id', $Company_id);
		$this->db->order_by('Trans_id','desc');
		$this->db->limit($limit,$start);
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
   
   	function insert_deposit_topup($Company_id)
    {		
		
		$data['Company_id'] = $Company_id;
		
		$data['Trans_type'] = $this->input->post('Trans_type');
		$data['Seller_id']=1;
		if($data['Trans_type']==6)//Seller Topup
		{
			$data['Seller_id'] = $this->input->post('Seller_id');
		}
		$data['Amt_transaction'] = $this->input->post('Amt_transaction');
		
		$data['Exception_flag'] = $this->input->post('Exception_flag');
		$data['Remarks'] = $this->input->post('Remarks');
		if($data['Exception_flag']==0)//yes
		{
			$data['Payment_type'] = $this->input->post('Payment_type');
			if($data['Payment_type']==2)//cheque
			{
				$data['Bank_name'] = $this->input->post('Bank_name2');
				$data['Branch_name'] = $this->input->post('Branch_name');
				$data['Cheque_no'] = $this->input->post('Cheque_no');
			}
			if($data['Payment_type']==3)//credit
			{
				$data['Bank_name'] = $this->input->post('Bank_name1');
				$data['Card_number'] = $this->input->post('Card_number');
			}
		}
		
		$data['Transaction_date'] = date("Y-m-d");
		
		$this->db->insert('igain_compseller_trans_tbl', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	
	public function deposit_topup_count()
	{
		return $this->db->count_all("igain_compseller_trans_tbl");
	}
	
	public function tier_based_customers($Tier,$Company_id)
	{			
		$this->db->select('Enrollement_id');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id, 'Tier_id' => $Tier, 'User_activated' => '1'));
		$query = $this->db->get();
		// echo $this->db->last_query();
        if ($query->num_rows() > 0)
		{
            return $query->result();
        }
		else
		{
			return false;
		}
	}
/********************************************************AMIT END*******************/	
/********************************************************AMIT 03-05-2017 *******************/	

	function insert_SMS_communication()
    {
		$entry_date = date('Y-m-d');
		$sellerID = $this->input->post('sellerId');
		$data['communication_plan'] = $this->input->post('offer');
		$data['Hobbie_id'] = $this->input->post('Offer_related_to');
		$data['date'] = $entry_date;
		$data['activate'] = 'yes';
		$data['Company_id'] = $this->input->post('Company_id');
		$data['Link_to_lbs'] = $this->input->post('Link_to_lbs');
		$data['description'] = $this->input->post('offerdetails');
		$data['Comm_type'] = 1;
		
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
		$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));
			
		if($sellerID == '0')
		{
			/*****************************insert_communication For All Sellers*****************************/
			$seller_array=array();
			$this->db->select("Enrollement_id");
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('User_id' => '2','User_activated' => '1'));//, 'Company_id' => $Company_id
			$query = $this->db->get();
			
			foreach ($query->result() as $row)
			{
				$data['seller_id'] = $row->Enrollement_id;
				$this->db->insert('igain_seller_communication', $data);
			}
			/*****************************insert_communication For All Sellers*****************/
		}
		else
		{
			$data['seller_id'] = $this->input->post('sellerId');
			$this->db->insert('igain_seller_communication', $data);	
		}		
		// echo $this->db->last_query()."<br><br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }

	function insert_customer_notification_SMS($SMS_content)
        {
            $this->db->insert('igain_cust_sms_notification', $SMS_content);
            $insert_id = $this->db->insert_id();
            
            if($this->db->affected_rows() > 0)
            {
                //return true;
                return $insert_id;
            }		
        }
		
		function Send_sms($mobileNumber,$message,$sender,$gv_log_compid)
        {
			 /************Get Current SMS Available & Sms_api_auth_key****************/
				$data["Company_details"] = $this->Igain_model->get_company_details($gv_log_compid);
				$Available_sms=$data["Company_details"]->Available_sms;
				 $Sms_api_auth_key=$data["Company_details"]->Sms_api_auth_key;
				 $Sms_api_link=$data["Company_details"]->Sms_api_link;
				/********************/
				
			if($Available_sms == 0)
			{
				return 0;
			}				
            /**********SMS Configuration**************/
				// $authKey = "151097AnRTbhf7S9b590986e3";
				// $authKey = "151344AohxxOrX27w590c3dc1";
				$authKey = $Sms_api_auth_key;

			   //Your message to send, Add URL encoding here.
				$message = strip_tags($message);
				$message = preg_replace("/&nbsp;/",'',$message);
			   $route = "4";
			   //Prepare you post parameters
			   $postData = array(
				'authkey' => $authKey,
				'mobiles' => $mobileNumber,
				'message' => $message,
				'sender' => $sender,
				'route' => $route
			   ); 
			   //API URL
			   // $url="https://control.msg91.com/api/sendhttp.php";
			   $url=$Sms_api_link;
			   // init the resource
			   $ch = curl_init();
			   curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postData
				//,CURLOPT_FOLLOWLOCATION => true
			   ));
			   //Ignore SSL certificate verification
			   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			   //get response
			   $output = curl_exec($ch);
			   //Print error if any
			   if(curl_errno($ch))
			   {
				echo 'error:' . curl_error($ch);
			   }
			   curl_close($ch);        
			    // echo $output;
				/**********SMS Configuration end**************/		
				
				$message_counter=strlen($message);
				 // $Count_sms=floor($message_counter/160)+1;
				 if($message_counter <= 160)
				 {  
					$Count_sms=1;
				 }
				 else
				 {
					// $Count_sms=round($message_counter/153);
					$Count_sms=floor($message_counter/153)+1;
					$Count_sms=$Count_sms;
				 }
				
			
				 $NEW_SMS_COUNT= $Available_sms-$Count_sms;         
				 $post_data = array(
				 'Available_sms' => $NEW_SMS_COUNT
				 );
				 $Update_SMS_balance = $this->Update_company_SMS_Balance($gv_log_compid,$post_data);
				 /********Send Threshold SMS to Company Admin*********************/
				 $Super_sellers = $this->Igain_model->Fetch_Super_Seller_details($gv_log_compid);
				 // echo "NEW_SMS_COUNT ".$NEW_SMS_COUNT;
				if($NEW_SMS_COUNT <=10)
				{
					 $Email_content = array(
						'Notification_type' => 'SMS_threshold_email',
						'Template_type' => 'SMS_threshold_email'
					);
					 // foreach($company_Super_sellers as $Super_sellers)
					 {
						 // echo "<br>".$Super_sellers->Enrollement_id;
						$send_notification = $this->send_notification->send_Notification_email($Super_sellers->Enrollement_id,$Email_content,$Super_sellers->Enrollement_id,$gv_log_compid);
					 }
				}
				return 1;
				/*********************************************/
        }
		public function Update_company_SMS_Balance($gv_log_compid,$post_data)
		{
		  $this->db->where('Company_id', $gv_log_compid);
		  $this->db->update('igain_company_master', $post_data); 
		  // echo $this->db->last_query()."<br>";
		  if($this->db->affected_rows() > 0)
		  {
		   return true;
		  }  
		}
		
		/********************************************************AMIT 03-05-2017 END*******************/

		
		/**************************************Ravi 29-30-2017 END************************************/
	/**************************************BUY and Free*******************************************/
		
		public function offer_rule_count($Company_id)
		{
			// return $this->db->count_all("igain_discount_master");
			$this->db->from('igain_offer_master as A');
			// $this->db->join('igain_enrollment_master as B', 'A.Seller_id = B.Enrollement_id');
			$this->db->where(array('A.Company_id' => $Company_id));
			
			return $this->db->count_all_results();
		}
		public function offer_rule_list($Company_id)
		{
			$this->db->select('dp.*,e.Merchandize_item_name, f.Merchandize_category_name');
			$this->db->order_by('Offer_id','desc');
			$this->db->from('igain_offer_master as dp');
			$this->db->join('igain_company_merchandise_catalogue as e','e.Company_merchandise_item_id = dp.Company_merchandise_item_id','LEFT');
			$this->db->join('igain_merchandize_category as f','f.Merchandize_category_id = dp.Buy_item_category');
			$this->db->where('dp.Company_id',$Company_id);			
			$this->db->group_by('Offer_code');
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
		
		public function get_offer_item_details($Company_id,$Merchandize_category_id,$Stamp_item_flag)
		{

			$Todays_date=date("Y-m-d");
			
			$this->db->select('Company_merchandise_item_id,Merchandize_item_name,Merchandize_category_id');
			
			$this->db->from('igain_company_merchandise_catalogue');
			$this->db->where(array('Company_id'=>$Company_id,'Merchandize_category_id'=>$Merchandize_category_id,'Valid_from <= '=>$Todays_date,'Valid_till >= '=>$Todays_date,'show_item'=>1,'Active_flag'=>1));
			
			if($Stamp_item_flag > 0)
			{
				$this->db->where(array('Stamp_item_flag'=>$Stamp_item_flag));
			}
			
			$this->db->order_by('Company_merchandise_item_id','desc');
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
		public function check_offer_name($OfferNM,$Company_id)
		{
			$this->db->select('Offer_code');
			$this->db->from('igain_offer_master');
			$this->db->where(array('Company_id' =>$Company_id,'Offer_name' =>$OfferNM));			
			$sqlqury = $this->db->get();			
			if($sqlqury->num_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function check_offer_code($Offer_code,$Company_id)
		{
			$this->db->select('Offer_code');
			$this->db->from('igain_offer_master');
			$this->db->where(array('Company_id' =>$Company_id,'Offer_code' =>$Offer_code));			
			$sqlqury = $this->db->get();			
			if($sqlqury->num_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function get_offer_item($item_id,$Company_id,$Todays_date)
		{
			$this->db->select('Company_merchandise_item_id,Merchandize_item_name');
			$this->db->order_by('Company_merchandise_item_id','desc');
			$this->db->from('igain_company_merchandise_catalogue');
			$this->db->where(array('Company_merchandise_item_id'=>$item_id,'Company_id'=>$Company_id,'Valid_from <= '=>$Todays_date,'Valid_till >= '=>$Todays_date,'show_item'=>1,'Active_flag'=>1)); //'Offer_flag' => 1
			$query = $this->db->get();
			// echo $this->db->last_query();
			if ($query->num_rows() > 0)
			{
				return $query->row();
			}
			return false;
		}
		public function check_item_offers($Offer_name,$Company_id,$Item_id,$Buy_item,$Free_item,$Seller,$buy_category)
		{
			$this->db->select('Offer_code');
			$this->db->from('igain_offer_master');
			$this->db->where(array('Company_id' =>$Company_id,'Company_merchandise_item_id' =>$Item_id,'Buy_item' =>$Buy_item,'Free_item' =>$Free_item,'Seller_id' => $Seller,'Buy_item_category' =>$buy_category ));			
			$sqlqury = $this->db->get();
			// echo $this->db->last_query();
			if($sqlqury->num_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function delete_offer_rule2($Offer_code,$Company_id)
		{
			$this->db->where('Offer_code', $Offer_code);
			$this->db->delete('igain_offer_master');
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		public function Check_offer_sent($Offer_code,$Company_id)
		{
			$this->db->select('Offer_code');
			$this->db->from('igain_company_send_voucher');
			$this->db->where(array('Company_id' =>$Company_id,'Offer_code' =>$Offer_code));			
			$sqlqury = $this->db->get();
			// echo $this->db->last_query();
			if($sqlqury->num_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function get_offer_selected_items($Offer_code,$Company_id)
		{
			$this->db->select('Company_merchandise_item_id');
			$this->db->from('igain_offer_master');
			$this->db->where(array('Company_id' =>$Company_id,'Offer_code' =>$Offer_code));			
			$sqlqury = $this->db->get();
			// echo $this->db->last_query();
			if($sqlqury->num_rows() > 0)
			{
				foreach ($sqlqury->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}
			else
			{
				return 0;
			}
		}
		public function get_offer_free_selected_items($Offer_code,$Company_id)
		{
			$this->db->select('Free_item_id');
			$this->db->from('igain_offer_master');
			$this->db->where(array('Company_id' =>$Company_id,'Offer_code' =>$Offer_code));			
			$sqlqury = $this->db->get();
			// echo $this->db->last_query();
			if($sqlqury->num_rows() > 0)
			{
				foreach ($sqlqury->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}
			else
			{
				return 0;
			}
		}
		public function insert_offer_rule($data)
		{
			$this->db->insert('igain_offer_master', $data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		public function delete_offer_rule($Offer_code,$Company_id)
		{
			$data['Active_flag'] = 0;
			$this->db->where('Offer_code', $Offer_code );
			
			$this->db->update('igain_offer_master', $data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		public function edit_offer_rule($Offer_code,$Company_id)
		{ 
			$this->db->Select("OM.Offer_code,OM.Company_id,OM.Company_merchandise_item_id,OM.Offer_name,OM.Offer_description,OM.Buy_item,OM.Free_item,OM.Free_item_id,OM.From_date,OM.Till_date,OM.Buy_item_category,OM.Free_item_category,OM.Seller_id,OM.Active_flag,e.Merchandize_item_name,e.Company_merchandize_item_code");			
			$this->db->from('igain_offer_master as OM');
			$this->db->join('igain_company_merchandise_catalogue as e','e.Company_merchandise_item_id = OM.Company_merchandise_item_id','LEFT');
			// $this->db->where('OM.Company_id',$Company_id);
			$this->db->where(array('OM.Offer_code' => $Offer_code,'OM.Company_id' => $Company_id));
			
			
			$edit_sql = $this->db->get();
			// echo $this->db->last_query();
			if($edit_sql->num_rows() >= 1)
			{
				return $edit_sql->row();
				/*foreach ($edit_sql->result() as $row)
				{
					$data[] = $row;
				}
				return $data;*/
			}
			else
			{
				return false;
			}
		}
		public function update_offer_rule()
		{			
			$data['Company_id'] = $this->input->post("Company_id");
			$data['Offer_name'] = $this->input->post("Offer_name");
			$data['Offer_description'] = $this->input->post("Offer_description");
			// $data['Buy_item'] = $this->input->post("Buy_item");
			// $data['Free_item'] = $this->input->post("Free_item");
			// $data['Company_merchandise_item_id'] = $this->input->post("Company_merchandise_item_id");
			$data['Active_flag'] = $this->input->post("Offer_status");
			// $data['Free_item_id'] = $this->input->post("Free_item_id");
			// $data['Seller_id'] =0;
			$Offer_code = $this->input->post("Offer_code");
			// $data['From_date'] = date("Y-m-d",strtotime($this->input->post("start_date")));
			$data['Till_date'] = date("Y-m-d",strtotime($this->input->post("end_date")));			
			$this->db->where('Offer_code ', $Offer_code );
			
			$this->db->update('igain_offer_master', $data);
			// $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}		
		}
		function Check_offer_exist_trans($item_code,$Company_id)
		{			
			$query =  $this->db->select('Trans_id')
					   ->from('igain_transaction')
					   ->where(array('Item_code' => $item_code,'Company_id' => $Company_id,'Trans_type' =>12))->get();
			// echo $this->db->last_query();
			return $query->num_rows();
		}
		public function get_offer_item_name($Company_merchandise_item_id,$Company_id)
		{
			$this->db->Select("*");			
			$this->db->from('igain_company_merchandise_catalogue');
			$this->db->where(array('Company_merchandise_item_id' => $Company_merchandise_item_id,'Company_id' => $Company_id));
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
		
	public function get_seller_balance($Seller_id,$Company_id)
  {
	   $this->db->Select("Enrollement_id,Current_balance");   
	   $this->db->from('igain_enrollment_master');
	   $this->db->where(array('Enrollement_id' => $Seller_id,'Company_id' => $Company_id,'User_id' =>2,'User_activated' =>1));
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
	/****************************Ravi 29-30-2017 END*******************/
	/***********Nilesh 27-07-2018 loyalty rule for category/Segment/Flat File*************/
	function Get_Merchandize_category($Company_id)
	{
		$query = "Select * from  igain_merchandize_category where Company_id='".$Company_id."' AND Active_flag=1";
				
		$sql = $this->db->query($query);
				 
		if ($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
			return false;	
	} 
	function Get_Segment_details($Company_id)
	{
		$this->db->Select("*");			
		$this->db->from('igain_segment_master');
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' => 1));
		$this->db->group_by("Segment_code");
		$sql = $this->db->get();
		if ($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
			return false;	
	} 
	function Get_Segment_Criteria($Segment_id,$Company_id)
	{
		$this->db->Select("*");			
		$this->db->from('igain_segment_master as SM');
		$this->db->join('igain_segment_type_master as ST','ST.Segment_type_id = SM.Segment_type_id');
		$this->db->where(array('SM.Segment_code' => $Segment_id,'SM.Company_id' => $Company_id));
				
		$sql = $this->db->get();
		
		if ($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
			return false;	
	}

	function Get_Segment_Criteria1($Segment_id,$Company_id)
	{
		$this->db->Select("*");			
		$this->db->from('igain_segment_master as SM');
		$this->db->join('igain_segment_type_master as ST','ST.Segment_type_id = SM.Segment_type_id');
		$this->db->where(array('SM.Segment_id' => $Segment_id,'SM.Company_id' => $Company_id));
		$sql51 = $this->db->get();
		// echo $this->db->last_query();die;
		if($sql51 -> num_rows() >0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function Get_Segment_Name($Segment_code,$Company_id)
	{
		$this->db->Select("*");			
		$this->db->from('igain_segment_master');
		$this->db->where(array('Segment_code' => $Segment_code,'Company_id' => $Company_id));
		$this->db->group_by("Segment_code");
		$sql51 = $this->db->get();
		// echo $this->db->last_query();die;
		if($sql51 -> num_rows() >0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function Get_Merchandize_Category1($limit,$start,$Company_id)
	{
		$this->db->select('Merchandize_category_id,Parent_category_id,Merchandize_category_name,Seller_id');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		if($limit != NULL || $start != NULL ){			
			$this->db->limit($limit,$start);
		}
		
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
	/***********Nilesh 27-07-2018 loyalty rule for category/Segment/Flat File*************/
	public function Get_Country($Country_id)
	{	   
		$this->db->where('id', $Country_id);
		$query = $this->db->get("igain_country_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}	
	public function Get_State($State_id)
	{	   
		$this->db->where('id', $State_id);
		$query = $this->db->get("igain_state_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	public function Get_City($City_id)
	{	   
		$this->db->where('id', $City_id);
		$query = $this->db->get("igain_city_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	/**************************************AMIT KAMBLE 21-01-2020*********DISCOUNT MASTER*/
	 function Get_Linked_Items_for_discount($Merchandize_category_id,$Company_id)
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
	public function insert_new_discount_rule_master($data)
	{
		$this->db->insert('igain_new_discount_rule_master', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Fetch_new_discount_rule_master($Company_id)
	{
		$this->db->Select("*");			
		$this->db->from('igain_new_discount_rule_master');
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' => 1));
		$this->db->order_by('Discount_id','desc');
		$sql = $this->db->get();
		if ($sql->num_rows() > 0)
		{
			foreach ($sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
			return false;	
	}
	
	function Delete_discount_items($Company_id,$Discount_code)
	{
		$this->db->where(array('Discount_code'=>$Discount_code,'Company_id'=>$Company_id));
		$this->db->delete("igain_new_discount_rule_child");
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Insert_items_discount_child($Post_data)
	{
		$this->db->insert('igain_new_discount_rule_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	 
	 function Get_linked_items_discount_child($Company_id,$Discount_code)
	{
		$this->db->select('*');
		$this->db->from('igain_new_discount_rule_child as A');
		$this->db->join('igain_company_merchandise_catalogue as D','A.Item_code=D.Company_merchandize_item_code AND A.Company_id=D.Company_id');
		$this->db->join('igain_merchandize_category as C','D.Merchandize_category_id=C.Merchandize_category_id AND D.Company_id=C.Company_id ');

		$this->db->where(array('A.Discount_code'=>$Discount_code,'A.Company_id'=>$Company_id));
		$this->db->order_by('A.Discount_child_id','desc');
		
		$sql=$this->db->get();
		 // echo "<br><br>Get_linked_items_discount_child<br>".$this->db->last_query();//die;
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
	
	function Get_checked_items_discount($Company_id,$Discount_code,$Item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_new_discount_rule_child as A');
		
		$this->db->where(array('A.Item_code'=>$Item_code,'A.Company_id'=>$Company_id,'A.Discount_code'=>$Discount_code));
		
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
	function Check_Discount_code($Discount_code,$Company_id)
	{
		$this->db->select('Discount_code');
		$this->db->from('igain_new_discount_rule_master');
		$this->db->where(array('Company_id'=>$Company_id,'Discount_code'=>$Discount_code));
		$sql=$this->db->get();
		//echo $this->db->last_query();die;
		return $sql->num_rows();
	}
	function Check_dicount_item_level_items_child($Discount_code,$Company_id)
	{
		$this->db->select('Discount_code');
		$this->db->from('igain_new_discount_rule_child');
		$this->db->where(array('Company_id'=>$Company_id,'Discount_code'=>$Discount_code));
		$sql=$this->db->get();
		//echo $this->db->last_query();die;
		return $sql->num_rows();
	}
	public function delete_new_discount_rule($Discount_id,$Company_id)
	{
		$update_data = array('Active_flag' => '0');
		$this->db->where(array('Discount_id' => $Discount_id, 'Company_id' => $Company_id));
		$this->db->update("igain_new_discount_rule_master", $update_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Update_new_discount_rule_master($Update_data,$Discount_id)
	{
		
		$this->db->where(array('Discount_id' => $Discount_id));
		$this->db->update("igain_new_discount_rule_master", $Update_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function edit_new_discount_rule($Discount_id,$Company_id)
	{
		$this->db->Select("*");
		$this->db->from("igain_new_discount_rule_master");
		$this->db->where('Discount_id',$Discount_id);
		$this->db->where('Company_id' , $Company_id);
		
		$edit_sql = $this->db->get();

		if($edit_sql->num_rows()>0)
		{
			
            return $edit_sql->row();
		}
		else
		{
			return false;
		}
	}
	
	//******* offer rule sandeep 18-05-2020 *************
	
	function get_offer_menu_groups($seller_id,$Company_id,$StampFlag)
	{
	
		$this->db->select('DISTINCT(A.Merchandize_category_id),A.Merchandize_category_name');
		$this->db->from('igain_merchandize_category as A');
		$this->db->join('igain_company_merchandise_catalogue as B',"A.Merchandize_category_id = B.Merchandize_category_id");
		$this->db->where(array("A.Active_flag" => 1, "A.Company_id" => $Company_id ));
		
		
		if($StampFlag > 0)
		{
			$this->db->select('B.Stamp_item_flag');
			$this->db->where(array("B.Stamp_item_flag" =>$StampFlag ));
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
	//******* offer rule sandeep 18-05-2020 *************
}
?>