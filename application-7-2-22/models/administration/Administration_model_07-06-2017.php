<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration_model extends CI_Model {
	
   /*************************************sandeep Start*******************************/
   
   public function loyalty_rule_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		
			$this->db->select('*');
			$this->db->order_by('Loyalty_id','desc');
			$this->db->from('igain_loyalty_master as lp');
			$this->db->join('igain_enrollment_master as e','e.Enrollement_id = lp.Seller');
			$this->db->where('lp.Company_id',$Company_id);
		
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
		
		if($this->input->post("seller_id") == 0)
		{
			$get_sellers = $this->Igain_model->get_company_sellers($this->input->post("Company_id"));
			
			if($customer_gain == 1) //******Based On Every Transaction 
			{
				$data['Loyalty_at_transaction'] = $this->input->post("gained_points");
				
				foreach($get_sellers as $sellers)
				{
					$data['Seller'] = $sellers->Enrollement_id;
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
				
				foreach($get_sellers as $sellers)
				{
					$data['Seller'] = $sellers->Enrollement_id;
					for($k=0;$k < $total_values;$k++)
					{
						$data['Loyalty_at_value'] = $Purchase_value[$k];
						$data['discount'] = $Issue_points[$k];
						
						$this->db->insert('igain_loyalty_master', $data);
					}
				}
			}
		}
		else
		{
			$data['Seller'] = $this->input->post("seller_id");
			if($customer_gain == 1) //******Based On Every Transaction 
			{
				$data['Loyalty_at_transaction'] = $this->input->post("gained_points");
				
				$this->db->insert('igain_loyalty_master', $data);
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
					
					$this->db->insert('igain_loyalty_master', $data);
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
		$this->db->from("igain_loyalty_master");
		$this->db->where_in('Loyalty_id',$Loyalty_id);
		$this->db->where(array('Company_id' => $Company_id));
		
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
			
			if($total_values > 0)
			{
				$this->db->where(array('Loyalty_id' => $Loyalty_id,'Company_id' => $Company_id));
				$this->db->delete('igain_loyalty_master');
			}
			
			for($k=0;$k < $total_values;$k++)
			{
				$data['Loyalty_at_value'] = $Purchase_value[$k];
				$data['discount'] = $Issue_points[$k];
				
				$this->db->insert('igain_loyalty_master', $data);
			}
		}

		if($this->db->affected_rows() > 0)
		{
			return true;
		}

		
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
		$this->db->select('Loyalty_id');
		$this->db->from('igain_loyalty_master');
		$this->db->where(array('Loyalty_name' => $lpName,'Company_id' => $CompanyId));
		
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
			$this->db->from('igain_promo_campaign as dp');
			$this->db->join('igain_promo_campaign_child as c','dp.Campaign_id = c.Campaign_id');
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
	 
	public function promo_campaign_file_list($Company_id)
	{
			$this->db->select('*');
			$this->db->group_by('File_name');
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
		//echo "filename---".$filename."--<br>";

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
		
		if($sql_out->num_rows() > 0)
		{
			return false; //**** file is already uploaded ****	
		}
		else
		{
			$sql_query = $this->db->query("SELECT Campaign_id FROM  igain_promo_campaign WHERE Pomo_campaign_name like '".$campaign_name."' and Company_id=".$Company_id);
			
			
			if($sql_query->num_rows() == 0)
			{
				$this->db->insert('igain_promo_campaign', $data);
			
				if($this->db->affected_rows() > 0)
				{
					$create_campaign_id = $this->db->insert_id();
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
					if($extension == "csv") 
					{
						//get the csv file
						
						//$filepath = realpath($_FILES["csv"]["tmp_name"]);
						$filenameis = $filename;
						$handle = fopen($filepath,"r");
						for ($lines = 1; $csv_data = fgetcsv($handle,1000,",",'"'); $lines++)
						{		
							// echo "the line no---".$lines."<br>";
							if ($lines == 1) continue;
							if ($csv_data[0]) 
							{
									
									$d1 = $csv_data[0];
									$d2 = $csv_data[1];
										
									$lv_query = $this->db->query("SELECT * FROM igain_promo_campaign_child WHERE Promo_code='".$d2."' and Promo_code_status='0' and Company_id=".$Company_id);
																	
									if($lv_query->num_rows() > 0)
									{
										$checkme = 0;
											
											/* $get_error[] = $d2."-Promo Code Already Exist";
											$error_row[] = $lines; */
											
											continue;	
											// echo "the line no---".$lines."<br>";
									}
									else
									{	
										 $data['File_name']  = $filename;
										 $data['Campaign_id'] = $create_campaign_id; 
										 $data['Points'] = $d1; 
										 $data['Promo_code'] = $d2; 
										 $data['Promo_code_status'] = 0; 
										 
										$this->db->insert('igain_promo_campaign_tmp', $data);
										
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
																	
								if($lv_query->num_rows() > 0)
								{
									$checkme = 0;
										
										// $get_error[] = $d2."-Promo Code Already Exist";
										//$error_row[] = $lines; 
										
										continue;	

								}
								else
								{	
									$data['File_name']  = $filename;
									 $data['Campaign_id'] = $create_campaign_id; 
									 $data['Points'] = $d1; 
									 $data['Promo_code'] = $d2; 
									 $data['Promo_code_status'] = 0; 
									 
									$this->db->insert('igain_promo_campaign_tmp', $data);
									
								}	
							}
					}
			
				if($this->db->affected_rows() > 0)
				{
					return $create_campaign_id;
				}
		}

		
	}
	
	
	function delete_promocampaign($Campaign_id,$CompID,$FileName,$flag)
	{

		if($flag == 1)
		{
			
		
			$this->db->where(array('Campaign_id' => $Campaign_id, 'Company_id' => $CompID, 'File_name' => $FileName));
			$this->db->delete('igain_promo_campaign_tmp');
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		else
		{
		
			$this->db->where(array('Campaign_id' => $Campaign_id, 'Company_id' => $CompID));
			$this->db->delete('igain_promo_campaign');
			
			$this->db->where(array('Campaign_id' => $Campaign_id, 'Company_id' => $CompID, 'File_name' => $FileName));
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
	
	function promo_campaign_details($Company_id,$promo_cmp_id)
	{
		$this->db->from('igain_promo_campaign');
		$this->db->where(array('Company_id'=>$Company_id,'Campaign_id' =>$promo_cmp_id));
	
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
	function insert_communication()
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
			/*****************************insert_communication For All Sellers*****************************/
		}
		else
		{
			$data['seller_id'] = $this->input->post('sellerId');
			$this->db->insert('igain_seller_communication', $data);	
		}		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
	
	public function edit_communication_offer($id,$seller_id)
	{
		$this->db->select('A.*,B.First_name,B.Last_name');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.seller_id');
		$this->db->where(array('id'=>$id,'A.seller_id' =>$seller_id));
		
		$query41 = $this->db->get();
		
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
	
	public function update_communication_offer()
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
		$data['Link_to_lbs'] = $this->input->post('Link_to_lbs');
		$data['Company_id'] = $this->input->post('Company_id');
		
		$this->db->where(array('id'=>$communication_id, 'seller_id'=>$sellerID ));
		$this->db->update('igain_seller_communication', $data);		
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
	
	public function communication_offer_list($limit,$start,$Company_id,$Comm_type)
	{
		$this->db->select('*');
		$this->db->from('igain_seller_communication as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.seller_id');

		$this->db->where(array('B.Company_id' => $Company_id,'A.Comm_type' => $Comm_type));
		
		$this->db->limit($limit,$start);
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
   
	public function delete_communication_offer($id,$seller_id)
	{
		$this->db->where(array('id' => $id, 'seller_id' => $seller_id));
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
		$data['Create_user_id'] = $this->input->post('Create_user_id');
		$data['Creation_date'] = date("Y-m-d H:m:s");
		$data['Company_id'] = $this->input->post('Company_id');
		$data['Prize_image'] = $filepath;
		$data['Active_flag'] = '1';
		
		$this->db->insert('igain_auction_master', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
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
		$this->db->limit($limit,$start);
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
			return true;
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
}

?>
