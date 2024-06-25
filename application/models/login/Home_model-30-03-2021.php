<?php
class Home_model extends CI_model
{
	public function dashbord($company_id)
	{
		$current_year = date('Y');	//echo "--the current year--".$current_year."---<br>";
		$current_month = date('M-Y');	//echo "--the v current_month--".$current_month."---<br>";
		
		$str = date("Y-m");
			
		$i=0;
		$j=0;
		$e=0;
		$f=0;
			
		//$arr2=array("01","02","03","04","05","06","07","08","09","10","11","12");
	//	$arrmonth=array('Jan '.$login_year,'Feb '.$login_year,'Mar '.$login_year,'Apr '.$login_year,'May '.$login_year,'Jun '.$login_year,'Jul '.$login_year,'Aug '.$login_year,'Sep '.$login_year,'Oct '.$login_year,'Nov '.$login_year,'Dec '.$login_year);	
					
		$sm= array();
		$sm1= array();
		
		for ($i =0; $i < 12; $i++) 
		{	   		   
			$sm1[]= date("M-Y",strtotime("-$i months", strtotime($str)));			   		   
		}
		
		$sm = array_reverse($sm);
		$sm1 = array_reverse($sm1);
		
		$SixMonthArray = array();
		
		$this->db->select("smry_month");
		$this->db->from("igain_points_distribution_graph");
		$this->db->where("Company_id",$company_id);
		
		$Res_WQ12 = $this->db->get();
		
		if($Res_WQ12->num_rows() > 0)
		{
			foreach($Res_WQ12->result() as $roef)
			{
				$monthVal = $roef->smry_month;
				
				
				if(in_array($monthVal,$sm1))
				{
					$SixMonthArray[] =  $roef->smry_month;
				}
				else
				{
					$this->db->where(array("Company_id" => $company_id, "smry_month" =>$monthVal ));
					
					$delete_oldmonth = $this->db->delete("igain_points_distribution_graph");
					
				}
				
			}
			
		}
		//--------------------igain_popular_menugroup_graph
		/* $this->db->select("smry_month");
		$this->db->from("igain_popular_menugroup_graph");
		$this->db->where("Company_id",$company_id);
		
		$Res_WQ12 = $this->db->get();
		
		if($Res_WQ12->num_rows() > 0)
		{
			foreach($Res_WQ12->result() as $roef)
			{
				$monthVal = $roef->smry_month;
				
				
				if(in_array($monthVal,$sm1))
				{
					$SixMonthArray[] =  $roef->smry_month;
				}
				else
				{
					$this->db->where(array("Company_id" => $company_id, "smry_month" =>$monthVal ));
					
					$delete_oldmonth = $this->db->delete("igain_popular_menugroup_graph");
					
				}
				
			}
			
		} */
		
		/*********************************Nilesh Change**********************************/
		$this->db->select("smry_month");
		$this->db->from("igain_quantity_distribution_graph");
		$this->db->where("Company_id",$company_id);
		
		$Res_WQ12 = $this->db->get();
		
		if($Res_WQ12->num_rows() > 0)
		{
			foreach($Res_WQ12->result() as $roef)
			{
				$monthVal1 = $roef->smry_month;
				
				
				if(in_array($monthVal1,$sm1))
				{
					$SixMonthArray[] =  $roef->smry_month;
				}
				else
				{
					$this->db->where(array("Company_id" => $company_id, "smry_month" =>$monthVal1 ));
					
					$delete_oldmonth = $this->db->delete("igain_quantity_distribution_graph");
				}
				
			}
			
		}
		/*********************************Nilesh Change**********************************/
		
		$sm12 = array_unique(array_merge($sm1,$SixMonthArray));
		
		foreach($sm12 as $month)
		{
			$start_date = date("Y-m",strtotime($month))."-01";
			$end_date = date("Y-m",strtotime($month))."-31";

			//echo "---start date is--".$start_date."---<br>";
			$curr_date = date("M-Y");
			
			$total_redeem_points = 0;
			$total_lv_points = 0;
			
		//********* Monthly Enrolled Members ****************/
		
			$this->db->select("Enrollement_id");
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('Company_id' =>$company_id, 'User_id' => '1'));
			$this->db->where("joined_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
			$Total_monthly_members = $this->db->count_all_results();
				//echo $Total_monthly_members; echo "<br>";
			$this->db->select("*");
			$this->db->from("igain_member_enrollment_graph");
			$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
			
			$result20 = $this->db->get();
			
			if($result20->num_rows() > 0 && $Total_monthly_members > 0)
			{
				$data20 = array
						(					
							'Total_enrollments' => $Total_monthly_members
						);
					
				$this->db->where(array("Company_id" => $company_id,"smry_month" =>$month ));
				$this->db->update("igain_member_enrollment_graph",$data20);
			}
			else if($Total_monthly_members > 0)
			{
				$data08['smry_month'] = $month;
				$data08['Total_enrollments'] = $Total_monthly_members;
				$data08['Company_id'] = $company_id;				
				$this->db->insert("igain_member_enrollment_graph",$data08);
			}
			else
			{
				$this->db->from("igain_member_enrollment_graph");
				$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
				$result25 = $this->db->get();
				$blank_data_count = $result25->num_rows();
				
				if($blank_data_count == 0)
				{
					$data08['smry_month'] = $month;
					$data08['Total_enrollments'] = $Total_monthly_members;
					$data08['Company_id'] = $company_id;
					$this->db->insert("igain_member_enrollment_graph",$data08);
				}
			}
		
		/********* popular menu groups ****************
		
			$this->db->select("*");
			$this->db->from("igain_popular_menugroup_graph");
			$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
			
			$result1 = $this->db->get();
			
			if($result1->num_rows() > 0)
			{
				
				if($current_month == $month)
				{
			
					$this->db->select("igain_merchandize_category.Merchandize_category_id,Merchandize_category_name,SUM(Quantity) as Total_qty");
					$this->db->from("igain_transaction");
					$this->db->join('igain_company_merchandise_catalogue', 'igain_company_merchandise_catalogue.Company_merchandize_item_code = igain_transaction.Item_code AND igain_company_merchandise_catalogue.Company_id = igain_transaction.Company_id');	
					$this->db->join('igain_merchandize_category', 'igain_company_merchandise_catalogue.Merchandize_category_id = igain_merchandize_category.Merchandize_category_id AND igain_company_merchandise_catalogue.Company_id = igain_merchandize_category.Company_id');	
					$this->db->where(array("igain_transaction.Company_id" => $company_id));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->group_by("igain_company_merchandise_catalogue.Merchandize_category_id");
					$this->db->order_by("Total_qty","desc");
					
					$result2 = $this->db->get();
				//echo $this->db->last_query(); echo "<br>";
					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $row2)
						{
							$Merchandize_category_name = $row2->Merchandize_category_name;
							$Total_qty = $row2->Total_qty;
						}
						
						$data55 = array(
					
						'Merchandize_category_name' => $Merchandize_category_name,
						'Total_qty' => $Total_qty
						);
						
						$this->db->where(array("Company_id" => $company_id,"smry_month" =>$month ));
						$this->db->update("igain_popular_menugroup_graph",$data55);
						
					}
					
					//echo "--the Total_loyalty_points--".$Total_loyalty_points."---<br>";
					
				
					
					
				}
				
			}
			else
			{
				
				$Merchandize_category_name = '';
				$Total_qty = 0;
							
				$this->db->select("igain_merchandize_category.Merchandize_category_id,Merchandize_category_name,SUM(Quantity) as Total_qty");
					$this->db->from("igain_transaction");
					$this->db->join('igain_company_merchandise_catalogue', 'igain_company_merchandise_catalogue.Company_merchandize_item_code = igain_transaction.Item_code AND igain_company_merchandise_catalogue.Company_id = igain_transaction.Company_id');	
					$this->db->join('igain_merchandize_category', 'igain_company_merchandise_catalogue.Merchandize_category_id = igain_merchandize_category.Merchandize_category_id AND igain_company_merchandise_catalogue.Company_id = igain_merchandize_category.Company_id');	
					$this->db->where(array("igain_transaction.Company_id" => $company_id));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->group_by("igain_company_merchandise_catalogue.Merchandize_category_id");
					$this->db->order_by("Total_qty","desc");
					
					$result2 = $this->db->get();
				// echo $this->db->last_query(); echo "<br>";
					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $row2)
						{
							$Merchandize_category_name = $row2->Merchandize_category_name;
							$Total_qty = $row2->Total_qty;
							
							$data12['smry_month'] = $month;
							$data12['Merchandize_category_name'] = $Merchandize_category_name;
							$data12['Total_qty'] = $Total_qty;
							$data12['Company_id'] = $company_id;
							
							$this->db->insert("igain_popular_menugroup_graph",$data12);
						}
					}
					else
					{
							$Total_qty = $row2->Total_qty;
							
							$data12['smry_month'] = $month;
							$data12['Total_qty'] = 0;
							$data12['Merchandize_category_name'] = '';
							$data12['Company_id'] = $company_id;
							
							$this->db->insert("igain_popular_menugroup_graph",$data12);
					}
					
				
				//echo "--the Total_loyalty_points--".$Total_loyalty_points."---<br>";
				
				
					
				
				
			}
			
			
			//-----------------------------------igain_popular_menugroup_graph----end------------------------*/
			
			$this->db->select("*");
			$this->db->from("igain_points_distribution_graph");
			$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
			
			$result1 = $this->db->get();
			
			if($result1->num_rows() > 0)
			{
				/*
				foreach($result1->result() as $row1)
				{
					$Total_redeem_points = $row1->Total_redeem_points;
					$Total_loyalty_points = $row1->Total_loyalty_points;
					$Total_redeem_count = $row1->Total_redeem_count;
					$Total_loyalty_count = $row1->Total_loyalty_count;
				}
				*/
				if($current_month == $month)
				{
					$Trans_type = array('1','2','7','8','9','12','13','15');
			
					//$this->db->select_sum("Loyalty_pts");
					$this->db->select('sum(Loyalty_pts + Topup_amount) as totalLoyalty_pts');
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in('Trans_type', $Trans_type);
					
					$result2 = $this->db->get();
				//echo $this->db->last_query(); echo "<br>";
					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $row2)
						{
							$Total_loyalty_points = $row2->totalLoyalty_pts;
						}
					}
					
					//echo "--the Total_loyalty_points--".$Total_loyalty_points."---<br>";
					
					$this->db->select_sum("Redeem_points");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id, "Redeem_points !=" =>'0' ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in("Trans_type",array('2','3','12'));
				
					$result3 = $this->db->get();
					
					//echo $this->db->last_query();
					//echo "--<br><br>---";
					
					if($result3->num_rows() > 0)
					{
						foreach($result3->result() as $row3)
						{
							$Total_just_redeem_points = $row3->Redeem_points;
						}
					}
					
					$this->db->select('sum(Redeem_points * Quantity) as RedeemPoints');
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id, "Trans_type" => '10', "Redeem_points !=" =>'0' ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				
					$result31 = $this->db->get();
					
					//echo $this->db->last_query();
					//echo "--<br><br>---";
					
					if($result31->num_rows() > 0)
					{
						foreach($result31->result() as $row31)
						{
							$Total_merchandize_redeem_points = $row31->RedeemPoints;
						}
					}
				
				$Total_redeem_points = $Total_just_redeem_points + $Total_merchandize_redeem_points;
					
					//echo "--the Total_redeem_points--".$Total_redeem_points."---<br>";
					
					$this->db->select("Trans_id");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id, "Trans_type" => '2', "Loyalty_pts !=" =>'0' ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				
					$result4 = $this->db->get();
					
					$Total_loyalty_count  = $result4->num_rows();
					
					//echo "--the Total_loyalty_count--".$Total_loyalty_count."---<br>";
					
					$this->db->select("Trans_id");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id, "Trans_type" => '12'));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				
					$result44 = $this->db->get();
					
					$Total_online_purchase_count  = $result44->num_rows();
					
					
					$this->db->select("Trans_id");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id));//, "Redeem_points !=" =>'0' 
					$this->db->where("(Trans_type = 2 AND Redeem_points!=0 AND Company_id =$company_id )");
					$this->db->or_where("(Trans_type = 3 AND Redeem_points!=0 AND Company_id =$company_id)");
					$this->db->or_where("(Trans_type = 10 AND Company_id =$company_id)");
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				// $this->db->where_in("Trans_type",array('2','3','10'));
					
					$result5 = $this->db->get();
					//echo $this->db->last_query(); die;
					
					$Total_redeem_count  = $result5->num_rows();
					
					//echo "--the Total_redeem_count--".$Total_redeem_count."---<br>";
					
					
					$data55 = array(
					
					'Total_redeem_points' => $Total_redeem_points,
					'Total_loyalty_points' => $Total_loyalty_points,
					'Total_redeem_count' => $Total_redeem_count,
					'Total_loyalty_count' => $Total_loyalty_count,
					'Total_online_purchase_count' => $Total_online_purchase_count
					);
					
					$this->db->where(array("Company_id" => $company_id,"smry_month" =>$month ));
					$this->db->update("igain_points_distribution_graph",$data55);
					
				}
				
			}
			else
			{
				
				$Trans_type = array('1','2','7','8','9','13','15');
				
				//$this->db->select_sum("Loyalty_pts");
				$this->db->select('sum(Loyalty_pts + Topup_amount) as totalLoyalty_pts');
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				$this->db->where_in('Trans_type', $Trans_type);
				
				$result2 = $this->db->get();
				
				//echo $this->db->last_query();
				//echo "--<br><br>---";
				
				if($result2->num_rows() > 0)
				{
					foreach($result2->result() as $row2)
					{
						$Total_loyalty_points = $row2->totalLoyalty_pts;
					}
				}
				
				//echo "--the Total_loyalty_points--".$Total_loyalty_points."---<br>";
				
				$this->db->select_sum("Redeem_points");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id, "Redeem_points !=" =>'0' ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				$this->db->where_in("Trans_type",array('2','3'));
			
				$result3 = $this->db->get();
				
				//echo $this->db->last_query();
				//echo "--<br><br>---";
				
				if($result3->num_rows() > 0)
				{
					foreach($result3->result() as $row3)
					{
						$Total_just_redeem_points = $row3->Redeem_points;
					}
				}
				
				$this->db->select('sum(Redeem_points * Quantity) as RedeemPoints');
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id, "Trans_type" => '10', "Redeem_points !=" =>'0' ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
				$result31 = $this->db->get();
				
				//echo $this->db->last_query();
				//echo "--<br><br>---";
				
				if($result31->num_rows() > 0)
				{
					foreach($result31->result() as $row31)
					{
						$Total_merchandize_redeem_points = $row31->Redeem_points;
					}
				}
				
				$Total_redeem_points = $Total_just_redeem_points + $Total_merchandize_redeem_points;
				
				//echo "--the Total_redeem_points--".$Total_redeem_points."---<br>";
				
				$this->db->select("Trans_id");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id, "Trans_type" => '2', "Loyalty_pts !=" =>'0' ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
				$result4 = $this->db->get();
				
				//echo $this->db->last_query();
				//echo "--<br><br>---";
				
				$Total_loyalty_count  = $result4->num_rows();
				
				$this->db->select("Trans_id");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id, "Trans_type" => '12'));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
				$result46 = $this->db->get();
				
				//echo $this->db->last_query();
				//echo "--<br><br>---";
				
				$Total_online_purchase_count  = $result46->num_rows();
				
				//echo "--the Total_loyalty_count--".$Total_loyalty_count."---<br>";
				
				
				$this->db->select("Trans_id");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id));//, "Redeem_points !=" =>'0' 
				$this->db->where("(Trans_type = 2 AND Redeem_points!=0 AND Company_id =$company_id )");
				$this->db->or_where("(Trans_type = 3 AND Redeem_points!=0 AND Company_id =$company_id)");
				$this->db->or_where("(Trans_type = 10 AND Company_id =$company_id)");
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				// $this->db->where_in("Trans_type",array('2','3','10'));
				$result5 = $this->db->get();
				
				//echo $this->db->last_query(); die;
				//echo "--<br><br>---";
				
				$Total_redeem_count  = $result5->num_rows();
				
				//echo "--the Total_redeem_count--".$Total_redeem_count."---<br>";
				
				if($Total_loyalty_count > 0 || $Total_redeem_count > 0 || $Total_online_purchase_count > 0)
				{
					$data12['smry_month'] = $month;
					$data12['Total_redeem_points'] = $Total_redeem_points;
					$data12['Total_loyalty_points'] = $Total_loyalty_points;
					$data12['Total_redeem_count'] = $Total_redeem_count;
					$data12['Total_loyalty_count'] = $Total_loyalty_count;
					$data12['Total_online_purchase_count'] = $Total_online_purchase_count;
					$data12['Company_id'] = $company_id;
					
					$this->db->insert("igain_points_distribution_graph",$data12);
				}
				else
				{
					$this->db->from("igain_points_distribution_graph");
					$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
					$result26 = $this->db->get();
					$blank_data_count26 = $result26->num_rows();
					
					if($blank_data_count26 == 0)
					{
						$data12['smry_month'] = $month;
						$data12['Total_redeem_points'] = 0;
						$data12['Total_loyalty_points'] = 0;
						$data12['Total_redeem_count'] = $Total_redeem_count;
						$data12['Total_loyalty_count'] = $Total_loyalty_count;
						$data12['Total_online_purchase_count'] = $Total_online_purchase_count;
						$data12['Company_id'] = $company_id;						
						$this->db->insert("igain_points_distribution_graph",$data12);
					}
				}
				
			}
			/**************************************Nilesh Change Quantity distribution graph**********************************/
			$this->db->select("*");
			$this->db->from("igain_quantity_distribution_graph");
			$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
			
			$result6 = $this->db->get();
			
			if($result6->num_rows() > 0)
			{
			
				if($current_month == $month)
				{
					$Trans_type = array('10');
					$this->db->select('sum(Quantity) as Issued_quantity');
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id ));
					//$this->db->where(array("Voucher_status" => 30 ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in('Trans_type', $Trans_type);
					
					$result7 = $this->db->get();
			
					if($result7->num_rows() > 0)
					{
						foreach($result7->result() as $row2)
						{
							$Total_issued_quantity = $row2->Issued_quantity;
						}
					}
					
					$this->db->select("sum(Quantity) as Used_quantity");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id));
					$this->db->where(array("Voucher_status" => 31 ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in("Trans_type",array('10'));
				
					$result3 = $this->db->get();
					
					if($result3->num_rows() > 0)
					{
						foreach($result3->result() as $row3)
						{
							$Total_used_quantity = $row3->Used_quantity;
						}
					}
					
					if($Total_issued_quantity ==NULL)
					{
						$Total_issued_quantity=0;
					}else{
						$Total_issued_quantity=$Total_issued_quantity;
					}
					
					if($Total_used_quantity ==NULL)
					{
						$Total_used_quantity=0;
					}else{
						$Total_used_quantity=$Total_used_quantity;
					}
					
					/****************AMIT 02-06-2019*********************************/
					$this->db->select('sum(Quantity) as Ordered_quantity');
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id ));
					//$this->db->where(array("Voucher_status" => 18 ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in('Trans_type', $Trans_type);
					
					$result81 = $this->db->get();
					//echo $this->db->last_query();
					if($result81->num_rows() > 0)
					{
						foreach($result81->result() as $row4)
						{
							$Ordered_quantity = $row4->Ordered_quantity;
						}
						if($Ordered_quantity==NULL)
						{
							$Ordered_quantity=0;
						}
					}
					$this->db->select('sum(Quantity) as Delivered_quantity');
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id ));
					$this->db->where(array("Voucher_status" => 20 ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in('Trans_type', $Trans_type);
					
					$result81 = $this->db->get();
					//echo $this->db->last_query();
					if($result81->num_rows() > 0)
					{
						foreach($result81->result() as $row4)
						{
							$Delivered_quantity = $row4->Delivered_quantity;
						}
						if($Delivered_quantity==NULL)
						{
							$Delivered_quantity=0;
						}
					}
					
					/****************AMIT 02-06-2019*****xxx****************************/
					
					$data555 = array(
					
						'Total_issued_quantity 	' => $Total_issued_quantity,
						'Total_used_quantity' => $Total_used_quantity,
						'Ordered_quantity' => $Ordered_quantity,
						'Delivered_quantity' => $Delivered_quantity
					);
					
					$this->db->where(array("Company_id" => $company_id,"smry_month" =>$month ));
					$this->db->update("igain_quantity_distribution_graph",$data555);
					
				}			
			}
			else
			{
				$Trans_type = array('10');
			
				$this->db->select('sum(Quantity) as Issued_quantity');
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id ));
				//$this->db->where(array("Voucher_status" => 30 ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				$this->db->where_in('Trans_type', $Trans_type);
				
				$result8 = $this->db->get();
				//echo $this->db->last_query();
				if($result8->num_rows() > 0)
				{
					foreach($result8->result() as $row4)
					{
						$Total_issued_quantity = $row4->Issued_quantity;
					}
					if($Total_issued_quantity==NULL)
					{
						$Total_issued_quantity=0;
					}
				}
				
				$this->db->select("sum(Quantity) as Used_quantity");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id));
				$this->db->where(array("Voucher_status" => 31 ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				$this->db->where_in("Trans_type",array('10'));
			
				$result3 = $this->db->get();
				//echo $this->db->last_query();
				if($result3->num_rows() > 0)
				{
					foreach($result3->result() as $row3)
					{
						$Total_used_quantity = $row3->Used_quantity;
					}
					if($Total_used_quantity==NULL)
					{
						$Total_used_quantity=0;
					}
				}
				
				/****************AMIT 02-06-2019*********************************/
				$this->db->select('sum(Quantity) as Ordered_quantity');
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id ));
				//$this->db->where(array("Voucher_status" => 18 ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				$this->db->where_in('Trans_type', $Trans_type);
				
				$result81 = $this->db->get();
				//echo $this->db->last_query();
				if($result81->num_rows() > 0)
				{
					foreach($result81->result() as $row4)
					{
						$Ordered_quantity = $row4->Ordered_quantity;
					}
					if($Ordered_quantity==NULL)
					{
						$Ordered_quantity=0;
					}
				}
				$this->db->select('sum(Quantity) as Delivered_quantity');
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id ));
				$this->db->where(array("Voucher_status" => 20 ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				$this->db->where_in('Trans_type', $Trans_type);
				
				$result81 = $this->db->get();
				//echo $this->db->last_query();
				if($result81->num_rows() > 0)
				{
					foreach($result81->result() as $row4)
					{
						$Delivered_quantity = $row4->Delivered_quantity;
					}
					if($Delivered_quantity==NULL)
					{
						$Delivered_quantity=0;
					}
				}
				
				/****************AMIT 02-06-2019*****xxx****************************/
				
				
				  //echo "Total_issued_quantity :".$Total_issued_quantity." Total_used_quantity".$Total_used_quantity; 
				if($Total_issued_quantity > 0 || $Total_used_quantity > 0 || $Ordered_quantity > 0 || $Delivered_quantity > 0)
				{
					$data121['smry_month'] = $month;
					$data121['Total_issued_quantity'] = $Total_issued_quantity;
					$data121['Total_used_quantity'] = $Total_used_quantity;
					$data121['Ordered_quantity'] = $Ordered_quantity;
					$data121['Delivered_quantity'] = $Delivered_quantity;
					$data121['Company_id'] = $company_id;
					
					$this->db->insert("igain_quantity_distribution_graph",$data121);
				}
				else
				{
					$this->db->from("igain_quantity_distribution_graph");
					$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
					$result26 = $this->db->get();
					$blank_data_count262 = $result26->num_rows();
					
					if($blank_data_count262 == 0)
					{
						$data122['smry_month'] = $month;
						$data122['Total_issued_quantity'] = 0;
						$data122['Total_used_quantity'] = 0;
						$data122['Ordered_quantity'] = 0;
						$data122['Delivered_quantity'] = 0;
						$data122['Company_id'] = $company_id;						
						$this->db->insert("igain_quantity_distribution_graph",$data122);
					}
				}
				
			}
			/**************************************Nilesh Change Quantity distribution graph**********************************/
			
			/**********************************Nilesh Change Partner Quantity distribution graph**********************************/
			
				$this->db->where("Company_id",$company_id);
				$this->db->delete("igain_partner_quantity_distribution_graph");
				
					$Trans_type = array('10');
					$this->db->select('sum(Quantity) as Issued_quantity,sum(Quantity-Quantity_balance) as Used_quantity,Merchandize_Partner_id');
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id ));
					// $this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
					$this->db->where_in('Trans_type', $Trans_type);
					$this->db->group_by("Merchandize_Partner_id");
					
					$result77 = $this->db->get();
			
					if($result77->num_rows() > 0)
					{
						foreach($result77->result() as $row21)
						{
							$Total_issued_quantity = $row21->Issued_quantity;
							$Total_used_quantity = $row21->Used_quantity;
							$Merchandize_Partner_id = $row21->Merchandize_Partner_id;
							
							
							$data1212['Total_issued_quantity'] = $Total_issued_quantity;
							$data1212['Total_used_quantity'] = $Total_used_quantity;
							$data1212['M_partner_id'] = $Merchandize_Partner_id;
							$data1212['Company_id'] = $company_id;
							
							$this->db->insert("igain_partner_quantity_distribution_graph",$data1212);					
						}
					}
				
			/*********************************Nilesh Change partner Quantity distribution graph*****************************/
			
		}
		
		//********* Active Vs Inactive Members ****************/
		
		$this->db->from("igain_member_status_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result13 = $this->db->get();
		
		if($result13->num_rows() > 0)
		{	
			$this->db->where(array("Company_id" => $company_id));
			$this->db->delete("igain_member_status_graph");
			
		}
		
		$this->db->select("Enrollement_id");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' =>$company_id, 'User_id' => '1' ));
		$Total_members = $this->db->count_all_results();
		
		$last_date = date("Y-m-d",strtotime("-1 month"));
		
		$this->db->distinct();
		$this->db->select("A.Enrollement_id");
		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
		 $this->db->where(array('A.User_activated'=>'1', 'A.Company_id' =>$company_id, 'A.User_id' => '1', 'B.Trans_date >= ' => $last_date));
		$Active_members = $this->db->count_all_results();
		
		$Inactive_members = $Total_members - $Active_members;
		
		if($Total_members > 0)
		{
			$status_data['Company_id'] = $company_id;
			$status_data['Total_members'] = $Total_members;
			$status_data['Total_active_members'] = $Active_members;
			$status_data['Total_inactive_members'] = $Inactive_members;
			
			$this->db->insert("igain_member_status_graph",$status_data);
		}
		
		/*----------AMIT KAMBLE---------------03-1-2020 Transaction  Order Types  Graph --------------------*/
		
		
			/* echo "------sm1------<br>";
			print_r($sm1);
			echo "------sm1--end----<br>"; */
			
			$this->db->select("smry_month");
			$this->db->from("igain_purchase_distribution_graph");
			$this->db->where("Company_id",$company_id);
			
			$Res_WQ12 = $this->db->get();
			
			if($Res_WQ12->num_rows() > 0)
			{
				foreach($Res_WQ12->result() as $roef)
				{
					$monthVal1 = $roef->smry_month;						
					if(in_array($monthVal1,$sm1))
					{
						$SixMonthArray[] =  $roef->smry_month;
					}
					else
					{
						$this->db->where(array("Company_id" => $company_id, "smry_month" =>$monthVal1 ));						
						$delete_oldmonth = $this->db->delete("igain_purchase_distribution_graph");
					}
					
				}
				
			}
			
			/* echo "------SixMonthArray------<br>";
			print_r($SixMonthArray);
			echo "------SixMonthArray--end----<br>"; */
			$sm12 = array_unique(array_merge($sm1,$SixMonthArray));
		
			foreach($sm12 as $month) {
		
				
				
				$start_date = date("Y-m",strtotime($month))."-01";
				$end_date = date("Y-m",strtotime($month))."-31";
				
				$this->db->select("*");
				$this->db->from("igain_purchase_distribution_graph");
				$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));			
				$result1 = $this->db->get();
				//echo "------igain_purchase_distribution_graph-----".$this->db->last_query()."---<br>";
				// echo "------num_rows-----".$result1->num_rows()."---<br>";
				
				if($result1->num_rows() > 0)
				{
					
					// echo "------current_month-----".$current_month."-------month-----".$month."---<br>";
					if($current_month == $month)
					{
						$Trans_type = array('12');				
						// $this->db->select('count(Bill_no) as totalpurchasecount,sum(Purchase_amount) as totalpurchasevalue,Delivery_method');
						
						/* SELECT SUM(Purchase_amount), MONTH(Trans_date) , bill_no, Delivery_method FROM `igain_transaction`group by 3,4 */
						$this->db->select('sum(Purchase_amount) as totalpurchasevalue,Bill_no,Delivery_method');
						$this->db->from("igain_transaction");
						$this->db->where(array("Company_id" => $company_id ));
						$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
						$this->db->where_in('Trans_type', $Trans_type);
						$this->db->group_by('Bill_no');
						$this->db->group_by('Delivery_method');
						
						
						$result2 = $this->db->get();
						
						// echo "-----sql-----". $this->db->last_query()."---<br>---";
						// echo "-----num_rows-----".$result2->num_rows()."---<br>---";
						
						if($result2->num_rows() > 0)
						{
							$Pickup_count=0;
							$Delivery_count=0;
							$Instore_count=0;
							$Pickup_value=array();
							$Delivery_value=array();
							$Instore_value=array();
							foreach($result2->result() as $row2)
							{
								// $Total_purchase_count= $row2->totalpurchasecount;
								$Total_purchase_value= $row2->totalpurchasevalue;
								$Delivery_method= $row2->Delivery_method;

								/* echo "--Total_purchase_count--".$Total_purchase_count."---<br>";
								echo "--Total_purchase_value--".$Total_purchase_value."---<br>";
								echo "--Delivery_method--".$Delivery_method."---<br>"; */	

								if($Delivery_method == 29){
									
									$Delivery_count++;
									$Delivery_value[]=$row2->totalpurchasevalue;
									
								} else if($Delivery_method ==28){
									
									$Pickup_count++;
									$Pickup_value[]=$row2->totalpurchasevalue;
									
								} else if($Delivery_method ==107){
									
									$Instore_count++;
									$Instore_value[]=$row2->totalpurchasevalue;								
								} 
								
							}
								/* echo "--Delivery_count--".$Delivery_count."---<br>";	
								echo "--Delivery_value--".$Delivery_value."---<br>";	
								echo "--Pickup_count--".$Pickup_count."---<br>";	
								echo "--Pickup_value--".array_sum($Pickup_value)."---<br>";	
								echo "--Instore_count--".$Instore_count."---<br>";
								echo "--Instore_value--".$Instore_value."---<br>";  */
							
								$Delivery_value1=array_sum($Delivery_value);
								$Pickup_value1=array_sum($Pickup_value);
								$Instore_value1=array_sum($Instore_value);
							
								$data112['smry_month'] = $month;
								$data112['Delivery_count'] = $Delivery_count;
								$data112['Delivery_value'] = $Delivery_value1;
								$data112['Pickup_count'] = $Pickup_count;
								$data112['Pickup_value'] = $Pickup_value1;
								$data112['Instore_count'] = $Instore_count;
								$data112['Instore_value'] = $Instore_value1;
								$data112['Company_id'] = $company_id;
									
								$this->db->where("smry_month",$month);
								$this->db->update("igain_purchase_distribution_graph",$data112);

								// echo "----update-sql-----". $this->db->last_query()."---<br>---";
						}
						
					}
					
				}
				else
				{
					
					// echo "-----Insert---<br>---";
						$Trans_type = array('12');				
						//$this->db->select_sum("Loyalty_pts");
						$this->db->select('sum(Purchase_amount) as totalpurchasevalue,Bill_no,Delivery_method');
						$this->db->from("igain_transaction");
						$this->db->where(array("Company_id" => $company_id ));
						$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
						$this->db->where_in('Trans_type', $Trans_type);
						$this->db->group_by('Bill_no');
						$this->db->group_by('Delivery_method');
					
					$result122 = $this->db->get();
					
					
								$Pickup_count=0;
								$Delivery_count=0;
								$Instore_count=0;
								$Pickup_value=array();
								$Delivery_value=array();
								$Instore_value=array();
								foreach($result122->result() as $row2)
								{
									// $Total_purchase_count= $row2->totalpurchasecount;
									$Total_purchase_value= $row2->totalpurchasevalue;
									$Delivery_method= $row2->Delivery_method;

									/* echo "--Total_purchase_count--".$Total_purchase_count."---<br>";
									echo "--Total_purchase_value--".$Total_purchase_value."---<br>";
									echo "--Delivery_method--".$Delivery_method."---<br>"; */	

									if($Delivery_method == 29){
										
										$Delivery_count++;
										$Delivery_value[]=$row2->totalpurchasevalue;
										
									} else if($Delivery_method ==28){
										
										$Pickup_count++;
										$Pickup_value[]=$row2->totalpurchasevalue;
										
									} else if($Delivery_method ==107){
										
										$Instore_count++;
										$Instore_value[]=$row2->totalpurchasevalue;								
									} 
									
								}
								/* echo "--Delivery_count--".$Delivery_count."---<br>";	
								echo "--Delivery_value--".$Delivery_value."---<br>";	
								echo "--Pickup_count--".$Pickup_count."---<br>";	
								echo "--Pickup_value--".array_sum($Pickup_value)."---<br>";	
								echo "--Instore_count--".$Instore_count."---<br>";
								echo "--Instore_value--".$Instore_value."---<br>";  */
							
								$Delivery_value1=array_sum($Delivery_value);
								$Pickup_value1=array_sum($Pickup_value);
								$Instore_value1=array_sum($Instore_value);
							
								$data112['smry_month'] = $month;
								$data112['Delivery_count'] = $Delivery_count;
								$data112['Delivery_value'] = $Delivery_value1;
								$data112['Pickup_count'] = $Pickup_count;
								$data112['Pickup_value'] = $Pickup_value1;
								$data112['Instore_count'] = $Instore_count;
								$data112['Instore_value'] = $Instore_value1;
								$data112['Company_id'] = $company_id;
								
								$this->db->insert("igain_purchase_distribution_graph",$data112);

								// echo "----insert-sql-----". $this->db->last_query()."---<br>---";
					
					
					
					
					
				}
			}
		/*-------------------------13-11-2019 Transaction  Order Types  Graph --------------------*/
		/*----------AMIT KAMBLE---------------24-4-2020 POS & Online  Graph --------------------*/
		
		
			$this->db->select("smry_month");
			$this->db->from("igain_pos_online_distribution_graph");
			$this->db->where("Company_id",$company_id);
			
			$Res_WQ12 = $this->db->get();
			
			if($Res_WQ12->num_rows() > 0)
			{
				foreach($Res_WQ12->result() as $roef)
				{
					$monthVal1 = $roef->smry_month;						
					if(in_array($monthVal1,$sm1))
					{
						$SixMonthArray[] =  $roef->smry_month;
					}
					else
					{
						$this->db->where(array("Company_id" => $company_id, "smry_month" =>$monthVal1 ));						
						$delete_oldmonth = $this->db->delete("igain_pos_online_distribution_graph");
					}
					
				}
				
			}
			
			$sm12 = array_unique(array_merge($sm1,$SixMonthArray));
		
			foreach($sm12 as $month) {
		
				
				
				$start_date = date("Y-m",strtotime($month))."-01";
				$end_date = date("Y-m",strtotime($month))."-31";
				
				$this->db->select("*");
				$this->db->from("igain_pos_online_distribution_graph");
				$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));			
				$result1 = $this->db->get();
				// echo "------".$this->db->last_query()."---<br>";
				 // echo "------num_rows-----".$result1->num_rows()."---<br>";
				
				if($result1->num_rows() > 0)
				{
					
					 // echo "------current_month-----".$current_month."-------month-----".$month."---<br>";
					if($current_month == $month)
					{
						$Trans_type = array('2','12','29');				
						
						$this->db->select('COUNT(Trans_type) as Trans_count,SUM(Purchase_amount) as Total_purchase,Bill_no,Trans_type');
						$this->db->from("igain_transaction");
						$this->db->where(array("Company_id" => $company_id ));
						$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
						$this->db->where_in('Trans_type', $Trans_type);
						$this->db->group_by('Bill_no');
						$this->db->group_by('Trans_type');
						
						
						$result2 = $this->db->get();
						
						  // echo $this->db->last_query()."---<br>---";
						 // echo "-----num_rows-----".$result2->num_rows()."---<br>---";
						
						if($result2->num_rows() > 0)
						{
							
							$Trans_count_pos=array();
							$Trans_count_online=array();
							$Trans_count_thirdparty=array();
							$Total_purchase_online=array();
							$Total_purchase_pos=array();
							$Total_purchase_thirdparty=array();
							foreach($result2->result() as $row2)
							{
								$Trans_type= $row2->Trans_type;
								$Trans_count= $row2->Trans_count;
								$Total_purchase= $row2->Total_purchase;
								
								if($Trans_type=='2')
								{
									$Trans_count_pos[]=$Trans_count;
									$Total_purchase_pos[]=$Total_purchase;
								}
								if($Trans_type=='12')
								{
									$Trans_count_online[]=$Trans_count;
									$Total_purchase_online[]=$Total_purchase;
								}
								if($Trans_type=='29')
								{
									$Trans_count_thirdparty[]=$Trans_count;
									$Total_purchase_thirdparty[]=$Total_purchase;
								}
							}
								
								
								$Trans_count_pos=array_sum($Trans_count_pos);
								$Trans_count_online=array_sum($Trans_count_online);
								$Trans_count_thirdparty=array_sum($Trans_count_thirdparty);
								$Total_purchase_pos=array_sum($Total_purchase_pos);
								$Total_purchase_online=array_sum($Total_purchase_online);
								$Total_purchase_thirdparty=array_sum($Total_purchase_thirdparty);
								
								$data1122['smry_month'] = $month;
								$data1122['Trans_count_pos'] = $Trans_count_pos;
								$data1122['Trans_count_online'] = $Trans_count_online;
								$data1122['Total_purchase_pos'] = $Total_purchase_pos;
								$data1122['Total_purchase_online'] = $Total_purchase_online;
								$data1122['Trans_count_thirdparty'] = $Trans_count_thirdparty;
								$data1122['Total_purchase_thirdparty'] = $Total_purchase_thirdparty;
								$data1122['Company_id'] = $company_id;
									
								$this->db->where("smry_month",$month);
								$this->db->update("igain_pos_online_distribution_graph",$data1122);

								// echo "----update-sql-----". $this->db->last_query()."---<br>---";
						}
						
					}
					
				}
				else
				{
					
					  // echo "-----Insert---<br>---";
						$Trans_type = array('2','12','29');				
						$this->db->select('COUNT(Trans_type) as Trans_count,SUM(Purchase_amount) as Total_purchase,Bill_no,Trans_type');
						$this->db->from("igain_transaction");
						$this->db->where(array("Company_id" => $company_id ));
						$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
						$this->db->where_in('Trans_type', $Trans_type);
						$this->db->group_by('Bill_no');
						$this->db->group_by('Trans_type');
					
						$result122 = $this->db->get();
						// echo "<br><br>".$this->db->last_query()."---<br>";//die;
					
							$Trans_count_pos=array();
							$Trans_count_online=array();
							$Trans_count_thirdparty=array();
							$Total_purchase_online=array();
							$Total_purchase_pos=array();
							$Total_purchase_thirdparty=array();
							foreach($result122->result() as $row2)
							{
								$Trans_type= $row2->Trans_type;
								$Trans_count= $row2->Trans_count;
								$Total_purchase= $row2->Total_purchase;
								
								if($Trans_type==2)
								{
									$Trans_count_pos[]=$Trans_count;
									$Total_purchase_pos[]=$Total_purchase;
								}
								if($Trans_type==12)
								{
									$Trans_count_online[]=$Trans_count;
									$Total_purchase_online[]=$Total_purchase;
								}
								if($Trans_type==29)
								{
									$Trans_count_thirdparty[]=$Trans_count;
									$Total_purchase_thirdparty[]=$Total_purchase;
								}
							}
								
								
								$Trans_count_pos=array_sum($Trans_count_pos);
								$Trans_count_online=array_sum($Trans_count_online);
								$Trans_count_thirdparty=array_sum($Trans_count_thirdparty);
								$Total_purchase_pos=array_sum($Total_purchase_pos);
								$Total_purchase_online=array_sum($Total_purchase_online);
								$Total_purchase_thirdparty=array_sum($Total_purchase_thirdparty);
								// echo "<br>".$month."...Total_purchase_online..".$Total_purchase_online;
								$data1121['smry_month'] = $month;
								$data1121['Trans_count_pos'] = $Trans_count_pos;
								$data1121['Trans_count_online'] = $Trans_count_online;
								$data1121['Total_purchase_pos'] = $Total_purchase_pos;
								$data1121['Total_purchase_online'] = $Total_purchase_online;
								$data1121['Trans_count_thirdparty'] = $Trans_count_thirdparty;
								$data1121['Total_purchase_thirdparty'] = $Total_purchase_thirdparty;
								$data1121['Company_id'] = $company_id;
								
								$this->db->insert("igain_pos_online_distribution_graph",$data1121);
				
								  // echo "----insert-sql-----". $this->db->last_query()."---<br>---";
					
					
					
					
					
				}
			}
		
	}
	
	public function member_status_graph_detail($company_id)
	{
		$this->db->from("igain_member_status_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result13 = $this->db->get();
		//echo "<br>---last_query---".$this->db->last_query()."--<br>";
		if($result13->num_rows() > 0)
		{	
			return $result13->result();
		}
			
		return 0;
	}
	
	public function monthly_enrollment_graph_details($company_id)
	{
		//$this->db->limit(6);
		$this->db->from("igain_member_enrollment_graph");
		$this->db->where(array("Company_id" => $company_id));
		//$this->db->order_by("smry_id DESC");
		
		$result130 = $this->db->get();
		 // echo "<br>---last_query---".$this->db->last_query()."--<br>";
		if($result130->num_rows() > 0)
		{	
			return $result130->result();
		}
			
		return 0;
	}
	
	public function twelve_monthly_enrollment_graph_details($company_id)
	{
		$this->db->from("igain_member_enrollment_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result131 = $this->db->get();
		
		if($result131->num_rows() > 0)
		{	
			return $result131->result();
		}
			
		return 0;
	}
	
	
	public function twelve_months_points_graph_detail($company_id)
	{
		$this->db->from("igain_points_distribution_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result1 = $this->db->get();
		
		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	
	public function monthly_points_graph_detail($company_id)
	{
		//$this->db->limit(6);
		$this->db->from("igain_points_distribution_graph");
		$this->db->where(array("Company_id" => $company_id));
		//$this->db->order_by("smry_id DESC");
		$result1 = $this->db->get();

		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	
	public function member_feedback($CompanyId)
	{
		$this->db->distinct('A.Survey_id');
		$this->db->select("A.Survey_id,C.Survey_name");
		$this->db->from("igain_response_master AS A");
		$this->db->where(array("A.Company_id" => $CompanyId));
		$this->db->join('igain_survey_send as B', 'A.Survey_id = B.Survey_id');
		$this->db->join('igain_survey_structure_master as C', 'A.Survey_id = C.Survey_id');
		$this->db->limit(3);
		$opt11 = $this->db->get();
		if($opt11->num_rows() > 0)
		{
			$i=0;
			foreach($opt11->result() as $row11)
			{
				$Survey_name = $row11->Survey_name;
				$Survey_id = $row11->Survey_id;				
				
				$this->db->select("Enrollment_id");
				$this->db->from("igain_response_master");
				$this->db->where(array("Company_id" => $CompanyId,"Survey_id" =>$Survey_id));
				$this->db->distinct();
				$Total_taken = $this->db->count_all_results();
				
				$this->db->select("Enrollment_id");
				$this->db->from("igain_survey_send");
				$this->db->where(array("Company_id" => $CompanyId, "Survey_id" =>$Survey_id));
				$this->db->distinct();
				$Total_send = $this->db->count_all_results();		
				
				$Untaken_survey_member=$Total_send-$Total_taken;	
				//echo "<br>Survey_id:".$Survey_id.' Total_taken:'.$Total_taken.' Total_send:'.$Total_send.' Untaken_survey_member:'.$Untaken_survey_member;	
				if($Untaken_survey_member > 0 || $Total_taken > 0 )
				{
					$opt["Survey_name"] = $Survey_name;
					$opt["Total_send"] = $Total_send;
					$opt["Total_actual_taken_survey"] = $Total_taken;
					$opt["Total_actual_Untaken_survey"] = $Untaken_survey_member;
				}				
				$opt_array[$i] = $opt;				
				$i++;
			}
			return $opt_array;
		}		
	}
	public function Get_company_survey_analysis($CompanyId)
	{
		// echo"<pre>";
		$this->load->dbforge();	
		$temp_table = $CompanyId.'survey_analysis';				
		if( $this->db->table_exists($temp_table) == TRUE )
		{
			$this->dbforge->drop_table($temp_table);
		}	
			$fields = array(
					'Company_id' => array('type' => 'INT','constraint' => '11'),
					'Survey_id' => array('type' => 'INT','constraint' => '11'),
					'NPS_type_id' => array('type' => 'INT','constraint' => '11'),
					'Total_NPS_Count' => array('type' => 'DECIMAL','constraint' => '20,0'),
					'Enrollment_id' => array('type' => 'INT','constraint' => '11'),					
					'Survey_name' => array('type' => 'VARCHAR','constraint' => '50')					
				);
		$this->dbforge->add_field($fields);		
		$this->dbforge->create_table($temp_table);
		
		$data['Company_id'] = $CompanyId;
		
		$this->db->distinct('A.Survey_id');
		$this->db->select("A.Survey_id,A.Enrollment_id,C.Survey_name");
		$this->db->from("igain_response_master AS A");
		$this->db->where(array("A.Company_id" => $CompanyId));
		$this->db->join('igain_survey_structure_master as C', 'A.Survey_id = C.Survey_id');
		$this->db->join('igain_nps_type_master as D', 'A.NPS_type_id = D.NPS_type_id');
		$this->db->group_by('A.Survey_id');
		$opt122 = $this->db->get();
		// echo "<br>---last_query---".$this->db->last_query()."--<br>";
		
		if($opt122->num_rows() > 0)
		{	
			$i=0;
			foreach($opt122->result() as $row22)
			{
				$Survey_name = $row22->Survey_name;
				
				// $Enrolledarray[]=$row22->Enrollment_id;				
				$Survey_id[]=$row22->Survey_id;				
			}
			// $i++;
		}		
		$Unique_suevey=array_unique($Survey_id);
		$pass_member=0;			
		$promo_member=0;			
		$dect_member=0;	
		
		
		// $tot_promo=0;	
		foreach($Unique_suevey as $U_suevey_id)
		{
			$promoter_count =0;
			$passive_count =0;
			$decratctors_count =0;			
			// $this->db->distinct('A.Survey_id');
			$this->db->select("COUNT(NPS_type_id) AS Total_NPS_Count,NPS_type_id,A.Survey_id,A.Enrollment_id,C.Survey_name");
			$this->db->from("igain_response_master AS A");
			$this->db->where(array("A.Company_id" => $CompanyId,"C.Survey_id" => $U_suevey_id));
			$this->db->join('igain_survey_structure_master as C', 'A.Survey_id = C.Survey_id');
			$this->db->group_by('A.Enrollment_id,A.NPS_type_id');
			$this->db->order_by('A.Enrollment_id');
			$opt1222 = $this->db->get();
			// echo "<br>---last_query---".$this->db->last_query()."--<br>";				
			if($opt1222->num_rows() > 0)
			{	
				
				$flag=0;
				$Member_analysis= array();
				$Total_memberby_type= array();
				
				foreach($opt1222->result() as $row242)
				{		
					$Survey_name = $row242->Survey_name;
					
					// echo "<br>-Survey_name--".$row242->Survey_name."--Total_NPS_Count---".$row242->Total_NPS_Count."---NPS_type_id---".$row242->NPS_type_id."--Enrollment_id--".$row242->Enrollment_id."-----<br>";
					
				
						if(in_array($row242->Enrollment_id,$Member_analysis))
						{
							$Member_analysis[$row242->Enrollment_id][$row242->NPS_type_id]=$row242->Total_NPS_Count;
							
							array_push($Member_analysis[$row242->Enrollment_id],$Member_analysis[$row242->Enrollment_id][$row242->NPS_type_id]);
						}
						else
						{
							$Member_analysis[$row242->Enrollment_id][$row242->NPS_type_id]=$row242->Total_NPS_Count;
						}
					
					continue;
					
					
					/* $data['Survey_id'] = $row242->Survey_id;
					$data['Survey_name'] = $row242->Survey_name;
					$data['Total_NPS_Count']= $row242->Total_NPS_Count;
					// $EnrollID_array[]= $row242->Enrollment_id;
					$data['NPS_type_id'] = $row242->NPS_type_id;							
					// $NPS_type_array[] = $row242->NPS_type_id;							
					$data['Enrollment_id'] = $row242->Enrollment_id;											
					$this->db->insert($temp_table, $data); */						
				}	
				// echo"<br>--Member_analysis--<br>";
				// print_r($Member_analysis);
				// echo"<br>--Member_analysis--<br>";
				foreach($Member_analysis as $enroll_key=>$Analysis)
				{
					// echo"---Member-EnrollID--".$enroll_key."---<br>";
					// print_r($Analysis);
					$promoter=0;
					$passive=0;
					$decratctors=0;
					$max=0;
					$next=0;
					foreach($Analysis as $key=>$final)
					{
						// print_r($final);
						
						/* $k=$final;
						echo"---final--".$final."----max--".$max."----k--".$k."---key--".$key."--<br>";
						if($k >= $max)
						{
							if($max != $k)
							{
								$max=$k;
								
								if($key == 1)
								{
									$promoter++;
									$passive = 0;
									$decratctors = 0;
									$final_analysis= $key;
									$promo_member++;
								}
								if($key == 2)
								{
									$passive++;
									$promoter = 0;
									$decratctors = 0;
									$final_analysis= $key;
									$pass_member++;
								}
								if($key == 3)
								{
									$decratctors++;
									$promoter = 0;
									$passive = 0;
									$final_analysis= $key;
									$dect_member++;
								}
							}
							else
							{
								$next=1;
							}
						}					
						echo"<br>---final is--".$final."---key-inside next--".$next."--<br>";
						if($final == 2 && $next==1)
						{							
							echo"<br>---key--".$key."--<br>";
							
							if($key == 1)
							{
								$promoter++;
							}
							if($key == 2)
							{
								$passive++;
							}
							if($key == 3)
							{
								
								$decratctors++;
							}
						} */
						
						
						$k=$final;
						// echo"---final--".$final."----max--".$max."----k--".$k."---key--".$key."--<br>";						
						/* echo"<br>---promoter--".$promoter;
						echo"<br>---passive--".$passive;
						echo"<br>---decratctors--".$decratctors; 	
						echo"<br><br>";  */	
						
						if($key==1){
							
							$promoter=$k;
							
						} if($key==2) {
							
							$passive=$k;
						}
						if($key == 3)
						{
							
							$decratctors=$k;
						}
						
					}					
					/* echo"<br>---promoter--".$promoter;
					echo"<br>---passive--".$passive;
					echo"<br>---decratctors--".$decratctors; 	
					echo"<br><br>";  */		
					
					if($promoter==$decratctors)
					{
						$final_analysis=2;
					} 
					else
					{
						if($promoter > $passive && $promoter > $decratctors)
						{
							$final_analysis=1;
						}					
						else if( ($passive > $decratctors) && ($passive >= $promoter))
						{
							$final_analysis=2;							
						}
						else if($decratctors > $passive && $decratctors > $promoter)
						{
							
							$final_analysis=3;	
						}
					}
					
					//echo"--the Member is---".$final_analysis."---<br><br>";
					
						if($final_analysis == 1)
						{
							$promoter_count++;
						}
						if($final_analysis == 2)
						{
							$passive_count++;
						}
						if($final_analysis == 3)
						{
							
							$decratctors_count++;
						}
					
				//	$Total_memberby_type[] = $final_analysis;
					
				}				
				// echo"--U_suevey_id---".$U_suevey_id."<br><br>";
						
				// $opt["Survey_name"] = $Survey_name;
				/* echo"--Survey_name---".$Survey_name."<br><br>";	
				echo"<br>---TYpe Count promoter_count--".$promoter_count."<br>";
				echo"<br>---TYpe Count passive_count--".$passive_count."<br>";
				echo"<br>---TYpe Count decratctors_count--".$decratctors_count."<br>"; */
			//	print_r($Total_memberby_type);
				
			//	echo "<br>--Total Promoters Count--".array_count_values($Total_memberby_type,1)."<br>";
				$Total_member_type_byservey[$U_suevey_id] = $Total_memberby_type;
				$opt["Survey_name"] = $Survey_name;
				$opt["Total_dectractor"] =$decratctors_count;
				$opt["Total_passive"] = $passive_count;
				$opt["Total_promoters"] =$promoter_count;					
					
					$opt_array[] = $opt;											
						
				
			}			
		}
		return $opt_array;
	}	
	public function get_customers_comment($CompanyID)
	{
		$this->db->limit(5);
		$this->db->select("a.Content_description,a.Enrollment_id,b.First_name,b.Last_name,b.Phone_no,b.Card_id,Photograph,a.Creation_date");
		$this->db->from("igain_contact_us_tbl as a");
		$this->db->join("igain_enrollment_master as b","a.Enrollment_id = b.Enrollement_id");
		$this->db->where(array('a.Company_id' => $CompanyID));
		$this->db->order_by("Contact_us_id DESC");
		
		$query42 = $this->db->get();
		if($query42->num_rows() > 0)
		{	
			return $query42->result_array();
		}
			
		return 0;
	}
	
	public function get_happy_customers($Company_id)
	{	
		$i = 0; 
		$lastmonth = date("Y-m-d", strtotime("-3 month")); /*** last 3 month ***/
		$thismonth = date("Y-m-d",strtotime("+1 day"));
		$Trans_type = array('2','3','7','8','9','10','12','13','15');
		
			$this->db->select_sum("A.Purchase_amount");
			//$this->db->select_sum("A.Loyalty_pts");
			$this->db->select('sum(A.Loyalty_pts + A.Topup_amount) as Loyalty_pts');
			$this->db->select('sum(A.Redeem_points) as Redeem_points');
			$this->db->select("B.First_name, B.Last_name, B.User_email_id, B.Phone_no,B.Card_id,B.joined_date,MAX(A.Trans_date) AS Last_visit,B.Photograph");
			$this->db->from('igain_transaction as A');
			$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.Enrollement_id');			
			$this->db->where(array('A.Company_id' => $Company_id)); //array('A.Enrollement_id' => $cust1)
			$this->db->where("A.Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' ");
			$this->db->where_in('A.Trans_type', $Trans_type);
			$this->db->group_by('A.Enrollement_id');
			$this->db->order_by('Last_visit','desc');
			// $this->db->limit(5);
			$query1 = $this->db->get();
			
			// echo $this->db->last_query();
			foreach ($query1->result_array() as $row1)
			{
				$Total_Purchase_amount[$i] = $row1['Purchase_amount'];
				$Total_Loyalty_pts[$i] = $row1['Loyalty_pts'];	
				$Total_Redeem_points[$i] = $row1['Redeem_points'];	
				$Customer_name[$i] = $row1['First_name']."<br>".$row1['Last_name'];
				$Customer_email[$i] = $row1['User_email_id'];
				$Customer_phno[$i] = $row1['Phone_no'];
				$Card_id[$i] = $row1['Card_id'];
				$Last_visit[$i] = $row1['Last_visit'];
				$Photograph[$i] = $row1['Photograph'];
				$joined_date[$i] = $row1['joined_date'];
				$i++;
				
				
			}
		
		
			$data['Total_Purchase_amount'] = $Total_Purchase_amount;
			$data['Total_Loyalty_pts'] = $Total_Loyalty_pts;				
			$data['Total_Redeem_points'] = $Total_Redeem_points;				
			$data['Customer_name'] = $Customer_name;
			$data['Customer_email'] = $Customer_email;
			$data['Customer_phno'] = $Customer_phno;		
			$data['Card_id'] = $Card_id;		
			$data['Last_visit'] = $Last_visit;		
			$data['Photograph'] = $Photograph;		
			$data['joined_date'] = $joined_date;		
			return $data;
	}
	
	public function get_worry_customers($Company_id)
	{	
		
		$lastmonth = date("Y-m-d", strtotime("-3 month")); /*** last 3 month ***/
		$thismonth = date("Y-m-d",strtotime("+1 day"));
		$Trans_type = array('2','3','7','8','9','10','12','13','15');
		$i=0;
		
		
		$this->db->select('First_name,Last_name,User_email_id,Phone_no,B.Card_id,B.joined_date,Photograph,Trans_date');
		$this->db->from('igain_enrollment_master AS B');
		$this->db->join('igain_transaction as A', 'B.Company_id = A.Company_id');
		$this->db->where(array('User_activated' => '1', 'User_id' => '1', 'B.Company_id' => $Company_id));
		$this->db->where('B.Card_id NOT IN (SELECT Card_id from igain_transaction where Company_id = '.$Company_id.' and Trans_type !=1 AND Trans_date BETWEEN "'.$lastmonth.'" AND "'.$thismonth.'")');
		$this->db->group_by('B.Enrollement_id');
		$this->db->order_by('Trans_date','asc');
		// $this->db->limit(5);
		$query1 = $this->db->get();
		
		// echo $this->db->last_query();
		
		if($query1->num_rows() > 0)
		{
			foreach ($query1->result_array() as $row11)
			{
				$this->db->select('MAX(Trans_date) as Last_visit');
				$this->db->from('igain_transaction');
				$this->db->where('Trans_type !=1');
				$this->db->where(array('Card_id' => $row11['Card_id'],'Company_id' => $Company_id));
				$this->db->group_by('Card_id');
				$query2 = $this->db->get();
				
				if($query2->num_rows() > 0)
				{
					foreach ($query2->result_array() as $row1)
					{
						$Last_visit= $row1['Last_visit'];
					}
				}
				else
				{
					$Last_visit=0;
				}
				//echo "<br>Card_id :: ".$row11['Card_id'].'___Last_visit :: '.$Last_visit;
				$Customer_name[$i] = $row11['First_name']."<br>".$row11['Last_name'];		
				$Card_id[$i] = $row11['Card_id'];		
				$Last_visit2[$i] = $Last_visit;		
				$Photograph[$i] = $row11['Photograph'];	
				$Phone_no[$i] = $row11['Phone_no'];	
				$joined_date[$i] = $row11['joined_date'];	
				$i++;
			}
		}
		
		$data['Customer_name'] = $Customer_name;
		$data['Card_id'] = $Card_id;		
		$data['Last_visit'] = $Last_visit2;		
		$data['Photograph'] = $Photograph;	
		$data['Customer_phno'] = $Phone_no;	
		$data['joined_date'] = $joined_date;	
		
				
		return $data;
	}
	
	public function insert_user_visit($Company_id,$Membership_id)
	{
		$this->db->select('Enrollement_id,First_name,Middle_name,Last_name,Phone_no,User_email_id,Card_id');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id,'Card_id' => $Membership_id,'User_id' =>1));		
		 $sql14 = $this->db->get();
		
		if($sql14->num_rows() > 0)
		{
			foreach($sql14->result_array() as $row14)
			{
				$Enrollement_id = $row14['Enrollement_id'];
				$Name = $row14['First_name'].' '.$row14['Middle_name'].' '.$row14['Last_name'];
				$Phone_no = $row14['Phone_no'];
				$User_email_id = $row14['User_email_id'];
				$Card_id = $row14['Card_id'];
			}
			
			foreach($sql14->result_array() as $row14)
			{
				$insert_data['Enrollement_id'] = $row14['Enrollement_id'];
				$insert_data['Company_id'] = $Company_id;
				$insert_data['Name'] =  $row14['First_name'].' '.$row14['Middle_name'].' '.$row14['Last_name'];
				$insert_data['Phone_no'] =  $row14['Phone_no'];
				$insert_data['User_email_id'] =  $row14['User_email_id'];
				$insert_data['Card_id'] =  $row14['Card_id'];
				$insert_data['Date'] =  date("Y-m-d H:i:s");
			}
			
			$this->db->insert('igain_user_visits',$insert_data);
			
			if($this->db->affected_rows() > 0)
			{
				return $insert_data;
			}
			
		}
	}
	/****************************************Nilesh Change**********************************************/
	public function get_MERCHANDIZING_items_data($company_id)
	{
		$this->db->from("igain_quantity_distribution_graph");
		$this->db->where(array("Company_id" => $company_id));
		$result1 = $this->db->get();
		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	public function twelve_months_quantity_graph_detail($company_id)
	{
		$this->db->from("igain_quantity_distribution_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result1 = $this->db->get();
		
		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	
	public function partner_quantity_graph_detail($company_id)
	{
		// $this->db->limit(6);
		$this->db->from("igain_partner_quantity_distribution_graph");
		$this->db->join('igain_partner_master', 'igain_partner_master.Partner_id = igain_partner_quantity_distribution_graph.M_partner_id','left');	
		$this->db->where(array("igain_partner_quantity_distribution_graph.Company_id" => $company_id));
		$this->db->order_by("smry_id DESC");
		$result1 = $this->db->get();

		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	
	public function get_company_summary_transactions($company_id)
	{
		
		$this->db->select('(SUM(Redeem_points)+SUM(Transfer_points)) AS Total_Used,(SUM(Loyalty_pts)) as Total_Gained_Points,SUM(Topup_amount) as Total_Bonus_Points,SUM(Purchase_amount) as Total_Purchase_Amount,SUM(Paid_amount) as Total_Paid_amount,SUM(Transfer_points) AS Total_Transfer_Points,SUM(Expired_points) AS Total_Expired_points');
		//,IE.Current_balance,Card_id2 as Transfer_to
		$this->db->from('igain_transaction as IT');
		
		$this->db->group_by('IT.Company_id');
		$this->db->where('IT.Company_id' , $company_id);
		
		$sql51 = $this->db->get();
		 // echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				/* if($row->Total_Used==0)
				{
					$row->Total_Used="-";
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
				} */
                $data[] = $row;
            }
			 return $data;
		}
		else
		{
			return false;
		}	
	}
	public function get_popular_category($company_id,$month)
	{
		$this->db->limit(20);
		$start_date = date("Y-m-d", strtotime("-$month month"));
		$end_date = date("Y-m-d");
			
		$this->db->select("igain_merchandize_category.Merchandize_category_id,Merchandize_category_name,SUM(Quantity) as Total_qty");
		$this->db->from("igain_transaction");
		$this->db->join('igain_company_merchandise_catalogue', 'igain_company_merchandise_catalogue.Company_merchandize_item_code = igain_transaction.Item_code AND igain_company_merchandise_catalogue.Company_id = igain_transaction.Company_id');	
		$this->db->join('igain_merchandize_category', 'igain_company_merchandise_catalogue.Merchandize_category_id = igain_merchandize_category.Merchandize_category_id AND igain_company_merchandise_catalogue.Company_id = igain_merchandize_category.Company_id');	
		$this->db->where(array("igain_transaction.Company_id" => $company_id));
		$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
		$this->db->group_by("igain_company_merchandise_catalogue.Merchandize_category_id");
		$this->db->order_by("Total_qty","desc");
		
		$result1 = $this->db->get();
		// echo "<br>".$this->db->last_query();die;
		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	public function Get_popular_category_items($Category,$Company_id,$Menu_group_month)
	{
		$this->db->limit(20);
		$start_date = date("Y-m-d", strtotime("-$Menu_group_month month"));
		$end_date = date("Y-m-d");
		
		$this->db->select("Merchandize_item_name,Merchandize_category_name,SUM(Quantity) as Total_qty");
		$this->db->from("igain_transaction");
		$this->db->join('igain_company_merchandise_catalogue', 'igain_company_merchandise_catalogue.Company_merchandize_item_code = igain_transaction.Item_code AND igain_company_merchandise_catalogue.Company_id = igain_transaction.Company_id');	
		$this->db->join('igain_merchandize_category', 'igain_company_merchandise_catalogue.Merchandize_category_id = igain_merchandize_category.Merchandize_category_id AND igain_company_merchandise_catalogue.Company_id = igain_merchandize_category.Company_id');	
		$this->db->where(array("igain_transaction.Company_id" => $Company_id,"igain_merchandize_category.Merchandize_category_name" => $Category));
		$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
		$this->db->group_by("igain_company_merchandise_catalogue.Company_merchandize_item_code");
		$this->db->order_by("Total_qty","desc");
		
		$result1 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	/****************************************Nilesh Change**********************************************/
	/*----------------------------------13-11-2019 Transaction  Order Types  Graph ------------------------------*/	
	
		public function Purchase_count_graph_detail($company_id)
		{
			$this->db->select("DISTINCT(smry_month) AS smry_month,Delivery_count,Delivery_value,Pickup_count,Pickup_value,Instore_value,Instore_count");
			$this->db->from("igain_purchase_distribution_graph");
			$this->db->where(array("Company_id" => $company_id));
			// $this->db->order_by("smry_id DESC");
			$result1 = $this->db->get();
			
			if($result1->num_rows() > 0)
			{	
				return $result1->result();
			}
				
			return 0;	
		}
		public function POS_online_distribution_graph_detail($company_id)
		{
			$this->db->select("DISTINCT(smry_month) AS smry_month,Trans_count_pos,Trans_count_online,Total_purchase_pos,Total_purchase_online,Trans_count_thirdparty,Total_purchase_thirdparty");
			$this->db->from("igain_pos_online_distribution_graph");
			$this->db->where(array("Company_id" => $company_id));
			// $this->db->order_by("smry_id DESC");
			$result1 = $this->db->get();
			
			if($result1->num_rows() > 0)
			{	
				return $result1->result();
			}
				
			return 0;	
		}
		public function Purchase_value_graph_detail($company_id)
		{
			$this->db->limit(6);
			$this->db->from("igain_purchase_distribution_graph");
			$this->db->where(array("Company_id" => $company_id));
			// $this->db->order_by("smry_id DESC");
			$result1 = $this->db->get();

			if($result1->num_rows() > 0)
			{	
				return $result1->result();
			}
				
			return 0;	
		}
		
	/*----------------------------------13-11-2019 Transaction  Order Types  Graph ------------------------------*/	
	
	/******************AMIT KAMBLE---------- 13-07-2020***************************************/
	public function Count_Percentage_issued_vouchers($company_id)
	{
		$Payment_Type_id = array('99','997','998');
		$this->db->select('g.Card_id');
		$this->db->from("igain_giftcard_tbl as g");
		// $this->db->join('igain_enrollment_master as e', 'e.Card_id = g.Card_id AND e.Company_id = g.Company_id'); 

		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		// $this->db->where('g.Card_balance != "0.00" ');
		$this->db->where('g.Discount_percentage != "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->num_rows();
	}	
	public function Count_Percentage_used_vouchers($company_id)
	{
		$Payment_Type_id = array('99','997','998');
		$this->db->select('g.Card_id');
		$this->db->from("igain_giftcard_tbl as g");
		// $this->db->join('igain_enrollment_master as e', 'e.Card_id = g.Card_id AND e.Company_id = g.Company_id'); 

		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance = "0.00" ');
		$this->db->where('g.Discount_percentage != "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->num_rows();
	}	
	public function Count_Value_issued_vouchers($company_id)
	{
		$Payment_Type_id = array('99','997','998');
		$this->db->select('g.Card_id');
		$this->db->from("igain_giftcard_tbl as g");
		// $this->db->join('igain_enrollment_master as e', 'e.Card_id = g.Card_id AND e.Company_id = g.Company_id'); 

		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		// $this->db->where('g.Card_balance != "0.00" ');
		$this->db->where('g.Discount_percentage = "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->num_rows();
	}	
	public function Count_Value_used_vouchers($company_id)
	{
		$Payment_Type_id = array('99','997','998');
		$this->db->select('g.Card_id');
		$this->db->from("igain_giftcard_tbl as g");
		// $this->db->join('igain_enrollment_master as e', 'e.Card_id = g.Card_id AND e.Company_id = g.Company_id'); 

		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance = "0.00" ');
		$this->db->where('g.Discount_percentage = "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->num_rows();
	}	
	
	
	public function Total_Value_issued_vouchers($company_id)
	{
		$Payment_Type_id = array('99','997','998');
		$this->db->select('SUM(Card_value) as Total_issued_value');
		$this->db->from("igain_giftcard_tbl as g");
		// $this->db->join('igain_enrollment_master as e', 'e.Card_id = g.Card_id AND e.Company_id = g.Company_id'); 

		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		// $this->db->where('g.Card_balance != "0.00" ');
		$this->db->where('g.Discount_percentage = "0.00" ');
		$this->db->group_by('g.Company_id');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->row();
	}	
	public function Total_Value_used_vouchers($company_id)
	{
		$Payment_Type_id = array('99','997','998');
		$this->db->select('SUM(Card_value) as Total_used_value');
		$this->db->from("igain_giftcard_tbl as g");
		// $this->db->join('igain_enrollment_master as e', 'e.Card_id = g.Card_id AND e.Company_id = g.Company_id'); 

		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance = "0.00" ');
		$this->db->where('g.Discount_percentage = "0.00" ');
		$this->db->group_by('g.Company_id');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->row();
	}	
	
		public function Count_issued_giftcard($company_id)
	{
		$Payment_Type_id = array('3','4','5');
		$this->db->select('g.Card_id');
		$this->db->from("igain_giftcard_tbl as g");
		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance != "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->num_rows();
	}
		
		public function Total_issued_giftcard($company_id)
	{
		$Payment_Type_id = array('3','4','5');
		$this->db->select('SUM(g.Card_value) as Total_issued_giftcard');
		$this->db->from("igain_giftcard_tbl as g");
		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance != "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->row();
	}
		public function Total_used_giftcard($company_id)
	{
		$Payment_Type_id = array('3','4','5');
		$this->db->select('SUM(g.Card_value) as Total_used_giftcard');
		$this->db->from("igain_giftcard_tbl as g");
		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance = "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->row();
	}
		public function Count_used_giftcard($company_id)
	{
		$Payment_Type_id = array('3','4','5');
		$this->db->select('g.Card_id');
		$this->db->from("igain_giftcard_tbl as g");
		$this->db->where(array("g.Company_id" => $company_id));
		$this->db->where_in("g.Payment_Type_id", $Payment_Type_id);
		$this->db->where('g.Card_balance = "0.00" ');
		$result2 = $this->db->get();
		// echo $this->db->last_query(); die;
		return $result2->num_rows();
	}
	public function Get_Birthdays_Anniversaries($company_id)
	{
		
		$this->db->select('`Enrollement_id`,`First_name`,`Last_name`,Date_of_birth,joined_date,Wedding_annversary_date,Card_id,Phone_no,Photograph');
		$this->db->from("igain_enrollment_master");
		
		$this->db->where(array("Company_id" => $company_id,"User_id" => 1,"User_activated" => 1));
		$result2 = $this->db->get();
		// echo "<br>".$this->db->last_query(); 
		return $result2->result();
	}
	/* 	public function Get_popular_menu_groups($company_id)
	{
		$this->db->from("igain_popular_menugroup_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result1 = $this->db->get();
		
		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	} */
	/******************AMIT KAMBLE----------XXX********************************/
}
?>
