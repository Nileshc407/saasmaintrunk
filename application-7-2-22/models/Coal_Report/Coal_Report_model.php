<?php 
class Coal_Report_model extends CI_model
{
	/*********** Akshay Work Start ****************************/
	function get_schedule_order_report($start_date,$end_date,$Company_id,$seller_id,$status,$start,$limit)
    {
		$Todays_date=date("Y-m-d");
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
		
		$this->db->select('C.Card_id,A.Id,First_name,Last_name,Merchandize_item_name,QTY,Total_Price_Points,Order_day,Order_date,Order_time,Status,Trans_type,A.Seller_id');
		
		$this->db->from('igain_seller_preorder_list as A');
		$this->db->join('igain_company_merchandise_catalogue as B', 'A.Merchandise_Item_id = B.Company_merchandise_item_id  AND A.Company_id=B.Company_id');
		
		$this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
		$this->db->join('igain_cust_merchant_trans_summary as D', 'A.Cust_enroll_id = D.Cust_enroll_id AND A.Company_id=D.Company_id AND A.Seller_id=D.Seller_id');
	
		$this->db->where(array('A.Company_id' => $Company_id,  'Order_date >=' => $start_date, 'Order_date <=' =>$end_date));
		//,  'From_date <=' => $Todays_date, 'To_date >=' =>$Todays_date)
		if($status!=0)
		{
			if($status==1)
			{
				$this->db->where(array('A.Status IN(0,1)'));
			}
			else
			{
				$this->db->where(array('A.Status' => $status));
			}
			
		}
		if($seller_id!=0)
		{
			$this->db->where(array('A.Seller_id' => $seller_id));
		}
		
		$this->db->order_by('A.Order_time','ASC');
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
        $query = $this->db->get();
		//echo "<br>".$this->db->last_query();
      
		if ($query->num_rows() > 0)
		{
			// return $query->result_array();
			foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
			 return $data; 
        }
        return false;
    }
	public function get_alk_seller_report_details($start_date,$end_date,$seller_id,$Company_id,$Report_type,$transaction_type_id,$start,$limit)	//,$limit,$start
	{
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
		
		if($Report_type == 1)//Summary
		{
			$this->db->select('Trans_id,Trans_type,Trans_date,First_name,Last_name,A.Card_id,Seller,Seller_name,Merchandize_item_name,Quantity,SUM(Purchase_amount) AS Purchase_amount,SUM(Redeem_points) AS Redeem_points,Manual_billno,Bill_no,Remarks');
		
			$this->db->from('igain_transaction as A');
			
			$this->db->join('igain_company_merchandise_catalogue as B', 'A.Item_code = B.Company_merchandize_item_code  AND A.Company_id=B.Company_id');
			$this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
			
			if($seller_id!=0)
			{
				$this->db->where(array('A.Seller' => $seller_id));
			}
			if($transaction_type_id!=0)
			{
				$this->db->where(array('A.Trans_type' => $transaction_type_id));
			}
			$this->db->where(array('A.Company_id' => $Company_id));
			$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->group_by('Trans_type');
			$this->db->group_by('Seller');
			$this->db->order_by('Seller','desc');
		}
		else //Detail
		{
			$this->db->select('Trans_id,Trans_type,Trans_date,First_name,Last_name,A.Card_id,Seller,Seller_name,Merchandize_item_name,Quantity,Purchase_amount,Redeem_points,Manual_billno,Bill_no,Remarks');
			
			$this->db->from('igain_transaction as A');
			$this->db->join('igain_company_merchandise_catalogue as B', 'A.Item_code = B.Company_merchandize_item_code  AND A.Company_id=B.Company_id');
			$this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
			
			if($seller_id!=0)
			{
				$this->db->where(array('A.Seller' => $seller_id));
			}
			if($transaction_type_id!=0)
			{
				$this->db->where(array('A.Trans_type' => $transaction_type_id));
			}
			$this->db->where(array('A.Company_id' => $Company_id));
			$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->order_by('Seller','desc');
			$this->db->order_by('Trans_date','desc');
			
		}
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
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
	public function get_alk_seller_report_details_exl($start_date,$end_date,$seller_id,$Company_id,$Report_type,$transaction_type_id,$start,$limit)	//,$limit,$start
	{
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
		
		if($Report_type == 1)//Summary
		{
			$this->db->select('Seller_name as Merchant_name,Trans_type,SUM(Purchase_amount) AS Purchase_amount,SUM(Redeem_points) AS Redeem_points');
			$this->db->from('igain_transaction as A');
			$this->db->join('igain_company_merchandise_catalogue as B', 'A.Item_code = B.Company_merchandize_item_code  AND A.Company_id=B.Company_id');
			$this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
			
			if($seller_id!=0)
			{
				$this->db->where(array('A.Seller' => $seller_id));
			}
			if($transaction_type_id!=0)
			{
				$this->db->where(array('A.Trans_type' => $transaction_type_id));
			}
			$this->db->where(array('A.Company_id' => $Company_id));
			$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->group_by('Trans_type');
			$this->db->group_by('Seller');
			$this->db->order_by('Seller','desc');
		}
		else //Detail
		{
			$this->db->select('Seller_name as Merchant_name,Trans_date,CONCAT(First_name,Last_name) AS Member_name,A.Card_id as Membership_id,Trans_type,Bill_no,Merchandize_item_name,Quantity,Purchase_amount,Redeem_points,Remarks');
			$this->db->from('igain_transaction as A');
			$this->db->join('igain_company_merchandise_catalogue as B', 'A.Item_code = B.Company_merchandize_item_code  AND A.Company_id=B.Company_id');
			$this->db->join('igain_enrollment_master as C', 'A.Card_id = C.Card_id AND A.Company_id=C.Company_id');
			
			if($seller_id!=0)
			{
				$this->db->where(array('A.Seller' => $seller_id));
			}
			if($transaction_type_id!=0)
			{
				$this->db->where(array('A.Trans_type' => $transaction_type_id));
			}
			$this->db->where(array('A.Company_id' => $Company_id));
			$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->order_by('Trans_date','desc');
			$this->db->order_by('Seller','desc');
		}
	/* 	if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
        $query = $this->db->get();
		// echo "<br>".$this->db->last_query();
        if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
				if($row->Trans_type==2)
				{
					$row->Trans_type="Purchase";
				}
				if($row->Trans_type==10)
				{
					$row->Trans_type="Redemption";
				}
				if($row->Purchase_amount==0 )
				{
					$row->Purchase_amount="-";
				}
				if($row->Redeem_points==0)
				{
					$row->Redeem_points="-";
				}
					
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	/************************ Alkwarm Customer Reports ***************************/
	function get_alk_cust_trans_details($Company_id,$From_date,$To_date,$Enrollement_id,$transaction_type_id,$Tier_id,$start,$limit)
	{	
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Bill_no,Seller,IT.Card_id as Membership_ID,IT.Company_id,Card_id2 as Transfer_to,Transfer_points,TM.Tier_name,IT.Remarks as Remarks,TT.Trans_type,Trans_type_id,Item_code,Quantity ');//Merchandize_item_name
		$this->db->from('igain_transaction as IT');
		
		//$this->db->join('igain_company_merchandise_catalogue as B', 'IT.Item_code = B.Company_merchandize_item_code  AND IT.Company_id=B.Company_id');
		
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
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
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		
		$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			 foreach ($sql51->result() as $row)
			{
				/* if($row->Coalition_Loyalty_pts==0)
				{
					$row->Coalition_Loyalty_pts="-";
				}
				else
				{
					$row->Coalition_Loyalty_pts=round($row->Coalition_Loyalty_pts);
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
	function get_alk_cust_trans_summary_all($Company_id,$Enrollement_id,$start_date,$end_date,$transaction_type_id,$Tier_id,$start,$limit)
	{
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
        
		$this->db->select('IE.First_name,IE.Middle_name,IE.Last_name,IT.Card_id AS Membership_ID,TT.Trans_type,SUM(Redeem_points) AS Total_Redeem,SUM(Purchase_amount) as Total_Purchase_Amount,SUM(Transfer_points) AS Total_Transfer_Points,Tier_name,IT.Enrollement_id,Trans_type_id');
		//,IE.Current_balance,Card_id2 as Transfer_to
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->group_by('IT.Card_id');
		$this->db->group_by('IT.Trans_type');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$start_date."' AND '".$end_date."'");
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		if($Tier_id!=0)//Selected Tier 
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
			
		}
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		
		//echo "<br>".$this->db->last_query();
		$sql51 = $this->db->get();
		
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				if($row->Total_Redeem==0)
				{
					$row->Total_Redeem="-";
				}
				/* if($row->Total_Gained_Points==0)
				{
					$row->Total_Gained_Points="-";
				} */
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
				/* if($row->Total_Coalition_Loyalty_pts==0)
				{
					$row->Total_Coalition_Loyalty_pts="-";
				}
				else
				{
					$row->Total_Coalition_Loyalty_pts=round($row->Total_Coalition_Loyalty_pts);
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
	
	function get_alk_cust_trans_summary_all_exl($Company_id,$Enrollement_id,$start_date,$end_date,$transaction_type_id,$Tier_id,$start,$limit)
	{
		$start_date=date("Y-m-d",strtotime($start_date));
		$end_date=date("Y-m-d",strtotime($end_date));
        
		$this->db->select('CONCAT(IE.First_name,IE.Middle_name,IE.Last_name) AS Member_name,IT.Card_id AS Membership_ID,Tier_name,TT.Trans_type,SUM(Redeem_points) AS Total_Redeem,SUM(Purchase_amount) as Total_Purchase_Amount,SUM(Transfer_points) AS Total_Gift_Amount');
		//,IE.Current_balance,Card_id2 as Transfer_to
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->group_by('IT.Card_id');
		$this->db->group_by('IT.Trans_type');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$start_date."' AND '".$end_date."'");
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		if($Tier_id!=0)//Selected Tier 
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
			
		}
		//$this->db->limit($limit,$start);
		
		//echo "<br>".$this->db->last_query();
		$sql51 = $this->db->get();
		
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				if($row->Total_Redeem==0)
				{
					$row->Total_Redeem="-";
				}
				 if($row->Total_Gift_Amount==0)
				{
					$row->Total_Gift_Amount="-";
				} 
				if($row->Total_Purchase_Amount==0)
				{
					$row->Total_Purchase_Amount="-";
				}
				if($row->Trans_type=="Transfer Points")
				{
					$row->Trans_type="Gift";
				}				
				if($row->Trans_type=="Loyalty Transaction")
				{
					$row->Trans_type="Purchase";
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

	function get_alk_cust_trans_details_exl($Company_id,$From_date,$To_date,$Enrollement_id,$transaction_type_id,$Tier_id)
	{
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		$this->db->select('IT.Trans_date,CONCAT(First_name,Middle_name,Last_name) AS Member_name,TM.Tier_name,IT.Card_id as Membership_ID,TT.Trans_type,Bill_no,Quantity,Purchase_amount,Redeem_points,Card_id2 as Gift_to,Transfer_points as Gift_amount,IT.Remarks as Remarks ');
		$this->db->from('igain_transaction as IT');
		
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
			if($transaction_type_id==2 || $$transaction_type_id==10)
			{
				$this->db->select('Merchandize_item_name');
				$this->db->join('igain_company_merchandise_catalogue as B', 'IT.Item_code = B.Company_merchandize_item_code  AND IT.Company_id=B.Company_id');
			}
			
		}
		else
		{
			$this->db->select('Merchandize_item_name');
			$this->db->join('igain_company_merchandise_catalogue as B', 'IT.Item_code = B.Company_merchandize_item_code  AND IT.Company_id=B.Company_id');
		}
		if($Tier_id!=0)//Selected Tier 
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
	/* 	if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			 foreach ($sql51->result() as $row)
			{
				 if($row->Purchase_amount==0)
				{
					$row->Purchase_amount="-";
				}
				 if($row->Redeem_points==0)
				{
					$row->Redeem_points="-";
				}
				 if($row->Gift_to==0)
				{
					$row->Gift_to="-";
				}
				 if($row->Gift_amount==0)
				{
					$row->Gift_amount="-";
				}
				if($row->Trans_type=="Transfer Points")
				{
					$row->Trans_type="Gift";
				}				
				if($row->Trans_type=="Loyalty Transaction")
				{
					$row->Trans_type="Purchase";
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
	function Get_Merchandize_Item_info($Company_merchandize_item_code,$Company_id)
	{
		$this->db->select('Merchandize_item_name');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandize_item_code'=>$Company_merchandize_item_code));
		$sql51=$this->db->get();
		 // echo $this->db->last_query();	die;
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			/* foreach ($sql51->result() as $row)
			{
				 $data[] = $row;
            }*/
			 return $sql51->row();
		}
		else
		{
			return false;
		}
	}	
	public function get_alk_cust_enrollment_report($Company_id,$start_date,$end_date,$start,$limit)
	{
		$this->db->select('joined_date,IE.Card_id as Membership_ID,First_name,Middle_name,Last_name,User_email_id,total_purchase AS 
		Total_Purchase_Amount,Total_reddems as Total_Redeemed_Points,User_activated');

		$this->db->from('igain_enrollment_master as IE');
		$this->db->join('igain_transaction as IT','IE.Enrollement_id=IT.Enrollement_id','LEFT');
		$this->db->where('IE.Company_id' , $Company_id);
		$this->db->where('IE.User_id' , 1);
		$this->db->where("joined_date BETWEEN '".$start_date."' AND '".$end_date."'");
		$this->db->order_by('IE.Enrollement_id' , 'desc');
		$this->db->group_by('IT.Enrollement_id');
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
		//return $sql51->row();
		foreach ($sql51->result() as $row)
		{
			if($row->User_activated==1)
			{
			 $row->User_activated="Yes";
			}
			else
			{
			 $row->User_activated="No";
			} 
			if($row->Total_Purchase_Amount==0)
			{
			 $row->Total_Purchase_Amount="-";
			}
			if($row->Total_Redeemed_Points==0)
			{
			 $row->Total_Redeemed_Points="-";
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
	
	/************************Alkwarm Customer Reports end***************************/
	
	function get_merchant_report($start_date,$end_date,$Company_id,$seller_id,$transaction_type_id,$report_type,$login_enroll)
    {
		$this->load->dbforge();		
		$start_date=date("Y-m-d", strtotime($start_date));
		$end_date=date("Y-m-d", strtotime($end_date));	
		
		
		if($report_type == 1)
		{
			$temp_table = $login_enroll.'seller_igain_summary_rpt';		
			
			if( $this->db->table_exists($temp_table) == TRUE )
			{
				$this->dbforge->drop_table($temp_table);
			}		
			$fields = array(
						'Trans_type' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'companyName' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'sellerName' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'top_up' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'purchase_amt' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'reedem_pt' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'balance_to_pay' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'loyalty_pts_gain' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'coalition_Loyalty_pts' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'seller_enrollid' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
					);
			$this->dbforge->add_field($fields);		
			$this->dbforge->create_table($temp_table);		
			if($seller_id == 0 && $transaction_type_id == 0)
			{
				$this->db->select('A.Seller_name, SUM(A.Topup_amount) as Topup_amount, SUM(A.Purchase_amount) as Purchase_amount, SUM(A.Redeem_points) as Redeem_points, SUM(A.balance_to_pay) as balance_to_pay, SUM(A.Loyalty_pts) as Loyalty_pts, SUM(A.Coalition_Loyalty_pts) as Coalition_Loyalty_pts, A.Seller, B.Trans_type, C.Company_name,SUM(Redeem_points*Quantity) as Total_Redeem_points');
				$this->db->from('igain_transaction as A');
				$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
				$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Seller');
				$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');		
				$this->db->where(array('C.Company_id' => $Company_id));
				$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$this->db->where('A.Bill_no <> 0');
				$this->db->group_by("A.Trans_type,A.Seller");
				$this->db->order_by('A.Seller','ASC');
				$query = $this->db->get();
			}			
			if($seller_id != 0 && $transaction_type_id == 0)
			{
				$this->db->select('A.Seller_name, SUM(A.Topup_amount) as Topup_amount, SUM(A.Purchase_amount) as Purchase_amount, SUM(A.Redeem_points) as Redeem_points, SUM(A.balance_to_pay) as balance_to_pay, SUM(A.Loyalty_pts) as Loyalty_pts, SUM(A.Coalition_Loyalty_pts) as Coalition_Loyalty_pts, A.Seller, B.Trans_type, C.Company_name,SUM(Redeem_points*Quantity) as Total_Redeem_points');
				$this->db->from('igain_transaction as A');
				$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
				$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Seller');
				$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');		
				$this->db->where(array('C.Company_id' => $Company_id, 'A.Seller' => $seller_id));
				$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$this->db->where('A.Bill_no <> 0');
				$this->db->group_by("A.Trans_type,A.Seller");
				$this->db->order_by('A.Seller','ASC');
				$query = $this->db->get();
			}			
			if($seller_id == 0 && $transaction_type_id != 0)
			{
				$this->db->select('A.Seller_name, SUM(A.Topup_amount) as Topup_amount, SUM(A.Purchase_amount) as Purchase_amount, SUM(A.Redeem_points) as Redeem_points, SUM(A.balance_to_pay) as balance_to_pay, SUM(A.Loyalty_pts) as Loyalty_pts, SUM(A.Coalition_Loyalty_pts) as Coalition_Loyalty_pts, A.Seller, B.Trans_type, C.Company_name,SUM(Redeem_points*Quantity) as Total_Redeem_points');
				$this->db->from('igain_transaction as A');
				$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
				$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Seller');
				$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');		
				$this->db->where(array('C.Company_id' => $Company_id, 'A.Trans_type' => $transaction_type_id));
				$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$this->db->where('A.Bill_no <> 0');
				$this->db->group_by("A.Trans_type,A.Seller");
				$this->db->order_by('A.Seller','ASC');
				$query = $this->db->get();
			}			
			if($seller_id != 0 && $transaction_type_id != 0)
			{
				$this->db->select('A.Seller_name, SUM(A.Topup_amount) as Topup_amount, SUM(A.Purchase_amount) as Purchase_amount, SUM(A.Redeem_points) as Redeem_points, SUM(A.balance_to_pay) as balance_to_pay, SUM(A.Loyalty_pts) as Loyalty_pts,  SUM(A.Coalition_Loyalty_pts) as Coalition_Loyalty_pts, A.Seller, B.Trans_type, C.Company_name,SUM(Redeem_points*Quantity) as Total_Redeem_points');
				$this->db->from('igain_transaction as A');
				$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
				$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Seller');
				$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');		
				$this->db->where(array('C.Company_id' => $Company_id, 'A.Seller' => $seller_id, 'A.Trans_type' => $transaction_type_id));
				$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$this->db->where('A.Bill_no <> 0');
				$this->db->group_by("A.Trans_type,A.Seller");
				$this->db->order_by('A.Seller','ASC');
				
				$query = $this->db->get();
				//echo $this->db->last_query();
			}		
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					if($row->Trans_type=='Redemption')
					{
						$lv_Total_Redeem_points=($row->Total_Redeem_points);
					}
					else
					{
						$lv_Total_Redeem_points=($row->Redeem_points);
					}
					
					$data['Trans_type'] = $row->Trans_type;
					$data['companyName'] = $row->Company_name;
					$data['sellerName'] = $row->Seller_name;
					$data['top_up'] = $row->Topup_amount;
					$data['purchase_amt'] = $row->Purchase_amount;
					$data['reedem_pt'] = $lv_Total_Redeem_points;
					$data['balance_to_pay'] = $row->balance_to_pay;
					$data['loyalty_pts_gain'] = $row->Loyalty_pts;
					$data['coalition_Loyalty_pts'] = $row->Coalition_Loyalty_pts;
					$data['seller_enrollid'] = $row->Seller;
					$this->db->insert($temp_table, $data);
				}          
			}
		}		
		if($report_type == 0)
		{
			$temp_table = $login_enroll.'seller_igain_detail_rpt';		
			if( $this->db->table_exists($temp_table) == TRUE )
			{
				$this->dbforge->drop_table($temp_table);
			}
			
			$fields = array(
						'Trans_id' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
						'Trans_type' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Trans_type_id' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
						'GiftCardNo' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
						'First_name' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Middle_name' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Last_name' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Manual_billno' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'companyName' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'sellerName' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'top_up' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'purchase_amt' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'reedem_pt' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'balance_to_pay' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'payment_type' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'cardId' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Bill_no' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'loyalty_pts_gain' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'coalition_Loyalty_pts' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						'seller_enrollid' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
						'Enrollement_id' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
						'Quantity' => array('type' => 'INT','constraint' => '11','DEFAULT' => 0),
						'Trans_date' => array('type' => 'DATETIME'),
						'Walkin_customer' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Remarks' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
					);
			$this->dbforge->add_field($fields);		
			$this->dbforge->create_table($temp_table);
			$query2_flag = 0;
			
			if($seller_id == 0 && $transaction_type_id == 0)
			{
				$this->db->select('A.Remarks,A.Trans_id, A.Manual_billno, A.Enrollement_id, A.Seller_name, A.Topup_amount, A.GiftCardNo, A.Purchase_amount, A.Redeem_points, A.balance_to_pay, A.Card_id, A.Bill_no, A.Loyalty_pts,A.Coalition_Loyalty_pts, A.Seller, A.Trans_date, B.Trans_type, B.Trans_type_id, C.Company_name, D.First_name, D.Middle_name, D.Last_name,Quantity');//, E.Payment_type
				$this->db->from('igain_transaction as A');
				$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
				$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Enrollement_id');
				$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');
				//$this->db->join('igain_payment_type_master as E', 'E.Payment_type_id = A.Payment_type_id');
				$this->db->where_in('A.Trans_type', array('1','2','3','10'));				
				$this->db->where(array('D.Company_id' => $Company_id));
				$this->db->where('A.Seller <> 0');
				$this->db->where('A.Bill_no <> 0');
				$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				//$this->db->group_by("A.Bill_no");
				$this->db->order_by('A.Trans_date','DESC');
				$query = $this->db->get()->result();
			
				$this->db->select('AA.Trans_id, AA.Manual_billno, AA.Enrollement_id, AA.Seller_name, AA.Topup_amount, AA.GiftCardNo, AA.Purchase_amount, AA.Redeem_points, AA.balance_to_pay, AA.Card_id, AA.Bill_no, AA.Loyalty_pts,AA.Coalition_Loyalty_pts, AA.Seller, AA.Trans_date, BB.Trans_type, BB.Trans_type_id, CC.Company_name,Quantity');
				$this->db->from('igain_transaction as AA');
				$this->db->join('igain_transaction_type as BB', 'BB.Trans_type_id = AA.Trans_type');
				$this->db->join('igain_company_master as CC', 'CC.Company_id = AA.Company_id');
				$this->db->where('AA.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$this->db->where(array('AA.Company_id' => $Company_id, 'AA.Trans_type' => '4'));
				$query2 = $this->db->get()->result();
			}
			
			if($seller_id != 0 && $transaction_type_id == 0)
			{
				$this->db->select('A.Remarks,A.Trans_id, A.Manual_billno, A.Enrollement_id, A.Seller_name, A.Topup_amount, A.GiftCardNo, A.Purchase_amount, A.Redeem_points, A.balance_to_pay, A.Card_id, A.Bill_no, A.Loyalty_pts,A.Coalition_Loyalty_pts, A.Seller, A.Trans_date, B.Trans_type, B.Trans_type_id, C.Company_name, D.First_name, D.Middle_name, D.Last_name,Quantity');
				$this->db->from('igain_transaction as A');
				$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
				$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Enrollement_id');
				$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');
				$this->db->where_in('A.Trans_type', array('1','2','3','10'));
				$this->db->where(array('D.Company_id' => $Company_id, 'A.Seller' => $seller_id));
				$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$this->db->where('A.Bill_no <> 0');
				//$this->db->group_by("A.Bill_no");
				$this->db->order_by('A.Trans_date','DESC');
				$query = $this->db->get()->result();
				
				$this->db->select('AA.Remarks,AA.Trans_id, AA.Manual_billno, AA.Enrollement_id, AA.Seller_name, AA.Topup_amount, AA.GiftCardNo, AA.Purchase_amount, AA.Redeem_points, AA.balance_to_pay, AA.Card_id, AA.Bill_no, AA.Loyalty_pts,AA.Coalition_Loyalty_pts, AA.Seller, AA.Trans_date, BB.Trans_type, BB.Trans_type_id, CC.Company_name,Quantity');
				$this->db->from('igain_transaction as AA');
				$this->db->join('igain_transaction_type as BB', 'BB.Trans_type_id = AA.Trans_type');
				$this->db->join('igain_company_master as CC', 'CC.Company_id = AA.Company_id');
				$this->db->where(array('AA.Company_id' => $Company_id, 'AA.Seller' => $seller_id, 'AA.Trans_type' => '4'));
				$this->db->where('AA.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
				$query2 = $this->db->get()->result();
			}			
			if($seller_id == 0 && $transaction_type_id != 0)
			{
				if($transaction_type_id == 4)
				{
					$this->db->select('AA.Remarks,AA.Trans_id, AA.Manual_billno, AA.Enrollement_id, AA.Seller_name, AA.Topup_amount, AA.GiftCardNo, AA.Purchase_amount, AA.Redeem_points, AA.balance_to_pay, AA.Card_id, AA.Bill_no, AA.Loyalty_pts, AA.Coalition_Loyalty_pts,AA.Seller, AA.Trans_date, BB.Trans_type, BB.Trans_type_id, CC.Company_name,Quantity');
					$this->db->from('igain_transaction as AA');
					$this->db->join('igain_transaction_type as BB', 'BB.Trans_type_id = AA.Trans_type');
					$this->db->join('igain_company_master as CC', 'CC.Company_id = AA.Company_id');
					$this->db->where(array('AA.Company_id' => $Company_id, 'AA.Trans_type' => '4'));
					$this->db->where('AA.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
					$query2 = $this->db->get()->result();
					$query2_flag = 1;
					$query = array();
				}
				else
				{
					$this->db->select('A.Remarks,A.Trans_id, A.Manual_billno, A.Enrollement_id, A.Seller_name, A.Topup_amount, A.GiftCardNo, A.Purchase_amount, A.Redeem_points, A.balance_to_pay, A.Card_id, A.Bill_no, A.Loyalty_pts,A.Coalition_Loyalty_pts, A.Seller, A.Trans_date, B.Trans_type, B.Trans_type_id, C.Company_name, D.First_name, D.Middle_name, D.Last_name,Quantity');
					$this->db->from('igain_transaction as A');
					$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
					$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Enrollement_id');
					$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');
					//$this->db->where_in('A.Trans_type', array('1','2','3','7'));
					$this->db->where(array('D.Company_id' => $Company_id, 'A.Trans_type' => $transaction_type_id));
					$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
					$this->db->where('A.Seller <> 0');
					$this->db->where('A.Bill_no <> 0');
					//$this->db->group_by("A.Bill_no");
					$this->db->order_by('A.Trans_date','DESC');
					$query = $this->db->get()->result();
					$query2 = array();
				}
			}			
			if($seller_id != 0 && $transaction_type_id != 0)
			{
				if($transaction_type_id == 4)
				{
					$this->db->select('AA.Remarks,AA.Trans_id, AA.Manual_billno, AA.Enrollement_id, AA.Seller_name, AA.Topup_amount, AA.GiftCardNo, AA.Purchase_amount, AA.Redeem_points, AA.balance_to_pay, AA.Card_id, AA.Bill_no, AA.Loyalty_pts, AA.Coalition_Loyalty_pts,AA.Seller, AA.Trans_date, BB.Trans_type, BB.Trans_type_id, CC.Company_name,Quantity');
					$this->db->from('igain_transaction as AA');
					$this->db->join('igain_transaction_type as BB', 'BB.Trans_type_id = AA.Trans_type');
					$this->db->join('igain_company_master as CC', 'CC.Company_id = AA.Company_id');
					$this->db->where(array('AA.Company_id' => $Company_id, 'AA.Seller' => $seller_id, 'AA.Trans_type' => '4'));
					$this->db->where('AA.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
					$query2 = $this->db->get()->result();
					$query2_flag = 1;
					$query = array();
				}
				else
				{
					$this->db->select('A.Remarks,A.Trans_id, A.Manual_billno, A.Enrollement_id, A.Seller_name, A.Topup_amount, A.GiftCardNo, A.Purchase_amount, A.Redeem_points, A.balance_to_pay, A.Card_id, A.Bill_no, A.Loyalty_pts,A.Coalition_Loyalty_pts, A.Seller, A.Trans_date, B.Trans_type, B.Trans_type_id, C.Company_name, D.First_name, D.Middle_name, D.Last_name,Quantity');
					$this->db->from('igain_transaction as A');
					$this->db->join('igain_transaction_type as B', 'B.Trans_type_id = A.Trans_type');
					$this->db->join('igain_enrollment_master as D', 'D.Enrollement_id = A.Enrollement_id');
					$this->db->join('igain_company_master as C', 'C.Company_id = D.Company_id');
					//$this->db->where_in('A.Trans_type', array('1','2','3','7'));
					$this->db->where(array('D.Company_id' => $Company_id, 'A.Seller' => $seller_id, 'A.Trans_type' => $transaction_type_id));
					$this->db->where('A.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
					$this->db->where('A.Bill_no <> 0');
					//$this->db->group_by("A.Bill_no");
					$this->db->order_by('A.Trans_date','DESC');
					$query = $this->db->get()->result();
					$query2 = array();
				}
			}
			
			/* if($query2_flag == 0)
			{
				$query3 = $query;
			}
			else
			{
				$query3 = array_merge($query, $query2);					
			} */
			
			$query3 = array_merge($query, $query2);
			
			// print_r($query3);
			// if ($query->num_rows() > 0)
			if ($query3 != NULL)
			{
				// foreach ($query->result() as $row)
				foreach ($query3 as $row)
				{
					$data['Trans_id'] = $row->Trans_id;
					$data['Trans_type'] = $row->Trans_type;
					$data['Trans_type_id'] = $row->Trans_type_id;
					$data['Enrollement_id'] = $row->Enrollement_id;

					if($row->GiftCardNo == NULL)
					{
						$data['GiftCardNo'] = '0';
					}
					else
					{
						$data['GiftCardNo'] = $row->GiftCardNo;					
					}
					$data['Manual_billno'] = $row->Manual_billno;
					$data['companyName'] = $row->Company_name;
					$data['sellerName'] = $row->Seller_name;
					$data['top_up'] = $row->Topup_amount;
					$data['purchase_amt'] = $row->Purchase_amount;
					$data['reedem_pt'] = $row->Redeem_points;
					$data['balance_to_pay'] = $row->balance_to_pay;
					// $data['payment_type'] = $row->Payment_type;
					
					$data['Bill_no'] = $row->Bill_no;
					$data['loyalty_pts_gain'] = $row->Loyalty_pts;
					$data['coalition_Loyalty_pts'] = $row->Coalition_Loyalty_pts;
					$data['seller_enrollid'] = $row->Seller;
					$data['Trans_date'] = $row->Trans_date;
					$data['Quantity'] = $row->Quantity;
					$data['Remarks'] = $row->Remarks;
					
					if($row->Trans_type_id == 4)
					{
						$Gift_card_details = $this->get_giftcard_details($row->GiftCardNo,$Company_id);
						$Customer_name = explode(" ", $Gift_card_details->User_name);
						$data['cardId'] = $Gift_card_details->Gift_card_id;
						$data['First_name'] = $Customer_name[0];
						$data['Middle_name'] = $Customer_name[1];
						if(count($Customer_name) > 2)
						{
							$data['Last_name'] = $Customer_name[2];
						}
					}
					else
					{
						$data['First_name'] = $row->First_name;
						$data['Middle_name'] = $row->Middle_name;
						$data['Last_name'] = $row->Last_name;
						$data['cardId'] = $row->Card_id;
					}
					
						if($row->Enrollement_id == 0)
						{
							$data['Walkin_customer'] = 'Yes';
						}
						else
						{
							$data['Walkin_customer'] = 'No';
						}
					$this->db->insert($temp_table, $data);
				}
			}
		}
		return $this->db->count_all($temp_table);
    }
	public function get_seller_report_details($temp_table,$Report_type,$start,$limit)	//,$limit,$start
	{
		if($Report_type == 1)
		{
			$this->db->order_by('sellerName','DESC');
			
			// $this->db->select('sellerName as Merchant_name,Trans_type,top_up as Bonus_points,purchase_amt,reedem_pt,balance_to_pay,loyalty_pts_gain,coalition_Loyalty_pts,seller_enrollid as Merchant_id');
			
			$this->db->select('sellerName as Merchant_name,Trans_type,top_up as Bonus_points,purchase_amt,reedem_pt,seller_enrollid as Merchant_id');
		}
		else
		{
			$this->db->order_by('Trans_id' , 'desc');
			
			// $this->db->select("Trans_date,sellerName as Merchant_name,CONCAT(First_name, ' ', Last_name) as Member_name,cardId as Membership_ID,Manual_billno,Trans_type,top_up as Bonus_points,purchase_amt,reedem_pt,balance_to_pay, loyalty_pts_gain,coalition_Loyalty_pts,Bill_no,seller_enrollid as Merchant_id,Trans_id,Trans_type_id,Walkin_customer,Quantity,Remarks");
			
			$this->db->select("Trans_date,sellerName as Merchant_name,CONCAT(First_name, ' ', Last_name) as Member_name,cardId as Membership_ID,Manual_billno,Trans_type,top_up as Bonus_points,purchase_amt,reedem_pt,balance_to_pay, loyalty_pts_gain,coalition_Loyalty_pts,Bill_no,seller_enrollid as Merchant_id,Trans_id,Trans_type_id,Walkin_customer,Quantity,Remarks");
		}
		/* if($limit != NULL || $start != NULL)
		{
			$this->db->limit($limit,$start);
		} */
		
        $query = $this->db->get($temp_table);
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
	public function get_seller_excel_report_details($temp_table,$Report_type)	//,$limit,$start
	{
		if($Report_type == 1)
		{
			$this->db->order_by('sellerName','DESC');
			
			// $this->db->select('sellerName as Merchant_name,Trans_type,top_up as Bonus_points,purchase_amt as Purchase_amt,reedem_pt as Reedem_pts,balance_to_pay as Balance_to_pay, loyalty_pts_gain as Loyalty_pts_gain,coalition_Loyalty_pts as Coalition_Points_Gain,seller_enrollid as Merchant_id');
			
			$this->db->select('sellerName as Merchant_name,Trans_type,top_up as Bonus_points,purchase_amt as Purchase_amt,reedem_pt as Reedem_pts,seller_enrollid as Merchant_id');
			//,seller_enrollid as Merchant_id
			$query = $this->db->get($temp_table);
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					if($row->Bonus_points==0)
					{
						$row->Bonus_points="-";
					}
					if($row->Purchase_amt==0)
					{
						$row->Purchase_amt="-";
					}
					if($row->Reedem_pts==0)
					{
						$row->Reedem_pts="-";
					}
					/* if($row->Balance_to_pay==0)
					{
						$row->Balance_to_pay="-";
					}
					if($row->Loyalty_pts_gain==0)
					{
						$row->Loyalty_pts_gain="-";
					}
					if($row->Coalition_Points_Gain==0)
					{
						$row->Coalition_Points_Gain="-";
					} */
					
					$data[] = $row;
				}
				
				
				return $data;
			}
			return false;
		}
		else
		{
			$this->db->order_by('Trans_id' , 'desc');
			
			// $this->db->select("Trans_date,sellerName as Merchant_name,CONCAT(First_name, ' ', Last_name) as Member_name,cardId as Membership_ID,Walkin_customer,Manual_billno,Trans_type,top_up as Bonus_points,purchase_amt as Purchase_amt,reedem_pt as Reedem_pts,Quantity,balance_to_pay as Balance_to_pay, loyalty_pts_gain as Loyalty_pts_gain, coalition_Loyalty_pts as Coalition_Points_Gain,Remarks as Remarks,seller_enrollid as Merchant_id");
		
			$this->db->select("Trans_date,sellerName as Merchant_name,CONCAT(First_name, ' ', Last_name) as Member_name,cardId as Membership_ID,Walkin_customer,Manual_billno,Trans_type,top_up as Bonus_points,purchase_amt as Purchase_amt,reedem_pt as Reedem_pts,Quantity,Remarks as Remarks,seller_enrollid as Merchant_id,Bill_no,seller_enrollid as Merchant_id");
			//,seller_enrollid as Merchant_id
			$query = $this->db->get($temp_table);
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					if($row->Manual_billno=="")
					{
						$row->Manual_billno="-";
					}
					if($row->Bonus_points==0)
					{
						$row->Bonus_points="-";
					}
					if($row->Purchase_amt==0)
					{
						$row->Purchase_amt="-";
					}
					if($row->Reedem_pts==0)
					{
						$row->Reedem_pts="-";
					}
					if($row->Quantity==0)
					{
						$row->Quantity="-";
					}
					
					/* if($row->Balance_to_pay==0)
					{
						$row->Balance_to_pay="-";
					}
					if($row->Loyalty_pts_gain==0)
					{
						$row->Loyalty_pts_gain="-";
					}
					if($row->Coalition_Points_Gain==0)
					{
						$row->Coalition_Points_Gain="-";
					} */
					
					if($row->Remarks=="")
					{
						$row->Remarks="-";
					}
					
					
					$data[] = $row;
				}

				return $data;
			}
			return false;
		}
	}   
	public function get_giftcard_details($Gift_card_id,$Company_id)
	{
		$this->db->from('igain_giftcard_tbl');
		$this->db->where(array('Gift_card_id' => $Gift_card_id, 'Company_id' => $Company_id));
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{			
			return $query->row();
		}
		else
		{
			return 0;
		}
	}
	/*********** Akshay Work end ****************************/
	/*********** Sandeep Work Start ****************************/	
	/************** Deposit Seller Topup Report **************/
	
	public function get_deposit_transactions($limit,$start,$Company_id,$start_date,$end_date,$Trans_type,$seller_id,$enrollID)
	{
		$start_date = date("Y-m-d",strtotime($start_date));
		$end_date = date("Y-m-d",strtotime($end_date));
		$this->load->dbforge();
		
		$temp_table = $enrollID.'deposit_topup_rpt';		
			
			if( $this->db->table_exists($temp_table) == TRUE )
			{
				$this->dbforge->drop_table($temp_table);
			}
		
			$fields20 = array(
						'Transaction_type' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Company_name' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Merchant_name' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
						'Transaction_date' => array('type' => 'DATE'),
						'Exception_transaction' => array('type' => 'VARCHAR','constraint' => '20','null' => TRUE),
						'Topup_amount' => array('type' => 'DECIMAL','constraint' => '25,0','DEFAULT' => 0),
						
					);
					
			$this->dbforge->add_field($fields20);
					
			$this->dbforge->create_table($temp_table);
			
				/* if($limit != NULL || $start != ""){				
					$this->db->limit($limit,$start);
				} */
		
		if($Trans_type == 1 && $seller_id == 0) //**** All Transaction Type and All sellers
		{
			$this->db->select("a.*,b.Company_name,c.Trans_type,d.First_name,d.Last_name");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			$this->db->join("igain_transaction_type as c","a.Trans_type = c.Trans_type_id");
			$this->db->join("igain_enrollment_master as d","d.Enrollement_id= a.Seller_id");
			$this->db->where("a.Company_id",$Company_id);
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();

		}
		else if($Trans_type == 1 && $seller_id > 0) //**** All Transaction Type 
		{
			$this->db->select("a.*,b.Company_name,c.Trans_type,d.First_name,d.Last_name");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			$this->db->join("igain_transaction_type as c","a.Trans_type = c.Trans_type_id");
			$this->db->join("igain_enrollment_master as d","d.Enrollement_id= a.Seller_id");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Seller_id" => $seller_id));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
			
		}
		
		
		if($Trans_type == 5) //**** Company Deposit Transaction Type 
		{
			$this->db->select("a.*,b.Company_name,c.Trans_type,d.First_name,d.Last_name");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			$this->db->join("igain_transaction_type as c","a.Trans_type = c.Trans_type_id");
			$this->db->join("igain_enrollment_master as d","d.Enrollement_id= a.Seller_id");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Trans_type" => $Trans_type));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
			
		}
		
		if($Trans_type == 6 && $seller_id > 0) //**** Seller Deposit Transaction Type 
		{
			$this->db->select("a.*,b.Company_name,c.Trans_type,d.First_name,d.Last_name");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			$this->db->join("igain_transaction_type as c","a.Trans_type = c.Trans_type_id");
			$this->db->join("igain_enrollment_master as d","d.Enrollement_id= a.Seller_id");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Trans_type" => $Trans_type,"a.Seller_id" => $seller_id));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
		
		}
		else if($Trans_type == 6 ) //**** Seller Deposit Transaction Type 
		{
			$this->db->select("a.*,b.Company_name,c.Trans_type,d.First_name,d.Last_name");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			$this->db->join("igain_transaction_type as c","a.Trans_type = c.Trans_type_id");
			$this->db->join("igain_enrollment_master as d","d.Enrollement_id= a.Seller_id");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Trans_type" => $Trans_type));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
			
		}
		
		//echo $this->db->last_query();
		
		if($deposit_rpt->num_rows() > 0)
		{
			foreach($deposit_rpt->result() as $rowp)
			{
				$except = $rowp->Exception_flag;
							
				if($except == 0)
				{
					$except_rpt='No';
				}
				else
				{									
					$except_rpt='Yes';
				}
							
				$values['Transaction_type'] = $rowp->Trans_type;
				$values['Company_name'] = $rowp->Company_name;
				$values['Merchant_name'] = $rowp->First_name." ".$rowp->Last_name;
				$values['Transaction_date']  = date("Y-m-d",strtotime($rowp->Transaction_date));
				$values['Exception_transaction'] = $except_rpt;
				$values['Topup_amount'] = $rowp->Amt_transaction;
					
				$this->db->insert($temp_table,$values);
				
				$data[] = $rowp;
			}
			
			
			return $data;
		}	
		return false;
	}	
	public function get_deposit_transactions_count($Company_id,$start_date,$end_date,$Trans_type,$seller_id)
	{
		$start_date = date("Y-m-d",strtotime($start_date));
		$end_date = date("Y-m-d",strtotime($end_date));
		
		if($Trans_type == 1 && $seller_id == 0) //**** All Transaction Type and All sellers
		{
			$this->db->select("*");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->where("a.Company_id",$Company_id);
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();

		}
		else if($Trans_type == 1 && $seller_id > 0) //**** All Transaction Type 
		{
			$this->db->select("*");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Seller_id" => $seller_id));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
			
		}
		
		
		if($Trans_type == 5) //**** Company Deposit Transaction Type 
		{
			$this->db->select("*");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Trans_type" => $Trans_type));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
			
		}
		
		if($Trans_type == 6 && $seller_id > 0) //**** Seller Deposit Transaction Type 
		{
			$this->db->select("*");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Trans_type" => $Trans_type,"a.Seller_id" => $seller_id));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
		
		}
		else if($Trans_type == 6 ) //**** Seller Deposit Transaction Type 
		{
			$this->db->select("*");
			$this->db->from("igain_compseller_trans_tbl as a");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Trans_type" => $Trans_type));
			$this->db->where("a.Transaction_date Between '$start_date'  AND '$end_date' ");
			
			$deposit_rpt = $this->db->get();
			
		}
		
		return $deposit_rpt->num_rows();
	}	
	public function get_deposit_topup_records($temp_table)	//,$limit,$start
	{

        $query = $this->db->get($temp_table);

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
	/********* Deposit Seller Topup Report **************/	
	/************** Customer Visit Report **************/	
	function get_cust_visit_details($Company_id,$Single_cust_membership_id,$start_date,$end_date)
	{
		$From_date=date("Y-m-d",strtotime($start_date));
		$To_date=date("Y-m-d",strtotime($end_date));
		
		$this->db->from("igain_user_visits");
		$this->db->order_by("Enrollement_id");
		$this->db->where("Company_id",$Company_id);
		$this->db->where("Date BETWEEN '".$From_date."' AND '".$To_date."'");
		
		if($Single_cust_membership_id != 0)
		{
			$this->db->where("Card_id",$Single_cust_membership_id);
		}
		
		$isRes = $this->db->get();
		
		if($isRes->num_rows() > 0)
		{
			foreach($isRes->result() as $isRow)
			{
				$isData[] = $isRow;
			}
			
			return $isData;
		}
		
		return false;
	}
	
	/********* Customer Visit Report **************/
	/*********** Sandeep Work Start ****************************/
	/*************************** AMIT Start ****************************/
	/************************ Customer Reports ***************************/
	
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
		// Trans_type
		
		$From_date=date("Y-m-d 00:00:00",strtotime($From_date));
		$To_date=date("Y-m-d 23:59:59",strtotime($To_date));
		
		/* $this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Bill_no,TT.Trans_type_id,Seller,IT.Coalition_Loyalty_pts,IT.Card_id as Membership_ID,IT.Company_id,Card_id2 as Transfer_to,Transfer_points,TM.Tier_name,IT.Remarks as Remarks,TT.Trans_type '); */
		
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Bill_no,TT.Trans_type_id,Seller,IT.Card_id as Membership_ID,IT.Company_id,Card_id2 as Transfer_to,Transfer_points,TM.Tier_name,IT.Remarks as Remarks,TT.Trans_type ');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
	
		/* $this->db->where('IT.Trans_type !=' , 10);
		$this->db->where('IT.Trans_type !=' , 9);
		$this->db->where('IT.Trans_type !=' , 12);
		$this->db->where('IT.Trans_type !=' , 17);
		$this->db->where('IT.Trans_type !=' , 20);
		$this->db->where('IT.Trans_type !=' , 22); */
		
		$this->db->where_not_in('IT.Trans_type', array('9','10','12','17','20','22','21','24','25','26','27','28'));
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
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		
		$this->db->order_by('IT.Trans_id' , 'desc');
	/* 	if($limit != NULL || $start != NULL)
		{
			$this->db->limit($limit,$start);
		} */
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				/* if($row->Coalition_Loyalty_pts==0)
				{
					$row->Coalition_Loyalty_pts="-";
				}
				else
				{
					$row->Coalition_Loyalty_pts=round($row->Coalition_Loyalty_pts);
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
	function get_cust_trans_summary_all($Company_id,$Enrollement_id,$start_date,$end_date,$transaction_type_id,$Tier_id,$start,$limit)
	{
		$start_date=date("Y-m-d 00:00:00",strtotime($start_date));
		$end_date=date("Y-m-d 23:59:59",strtotime($end_date));
       
		//IE.Enrollement_id,Transfer_points,
		// $this->db->select('IE.First_name,IE.Middle_name,IE.Last_name,IT.Card_id AS Membership_ID,TT.Trans_type,SUM(Redeem_points) AS Total_Redeem,SUM(Loyalty_pts) as Total_Gained_Points,SUM(Coalition_Loyalty_pts) as Total_Coalition_Loyalty_pts,SUM(Topup_amount) as Total_Bonus_Points,SUM(Purchase_amount) as Total_Purchase_Amount,SUM(Transfer_points) AS Total_Transfer_Points,Tier_name,IT.Enrollement_id');
		
		$this->db->select('IE.First_name,IE.Middle_name,IE.Last_name,IT.Card_id AS Membership_ID,TT.Trans_type,SUM(Redeem_points) AS Total_Redeem,SUM(Topup_amount) as Total_Bonus_Points,SUM(Purchase_amount) as Total_Purchase_Amount,SUM(Transfer_points) AS Total_Transfer_Points,Tier_name,IT.Enrollement_id');
		
		//,IE.Current_balance,Card_id2 as Transfer_to
		
		$this->db->from('igain_transaction as IT');
		
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		
		/* $this->db->where('IT.Trans_type !=' , 10);
		$this->db->where('IT.Trans_type !=' , 9); */
		
		$this->db->where_not_in('IT.Trans_type', array('9','10','12','17','20','22','21','24','25','26','27','28'));
		
		$this->db->group_by('IT.Card_id');
		$this->db->group_by('IT.Trans_type');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$start_date."' AND '".$end_date."'");
	
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		if($Tier_id!=0)//Selected Tier 
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
			
		}
		/* if($limit != NULL || $start != NULL)
		{
			$this->db->limit($limit,$start);
		} */
		
		//echo "<br>".$this->db->last_query();
		$sql51 = $this->db->get();
		
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				if($row->Total_Redeem==0)
				{
					$row->Total_Redeem="-";
				}
				/* if($row->Total_Gained_Points==0)
				{
					$row->Total_Gained_Points="-";
				} */
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
				/* if($row->Total_Coalition_Loyalty_pts==0)
				{
					$row->Total_Coalition_Loyalty_pts="-";
				}
				else
				{
					$row->Total_Coalition_Loyalty_pts=round($row->Total_Coalition_Loyalty_pts);
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

	function get_cust_trans_details_reports($Company_id,$From_date,$To_date,$Enrollement_id,$transaction_type_id,$Tier_id)
	{
		$From_date=date("Y-m-d 00:00:00",strtotime($From_date));
		$To_date=date("Y-m-d 23:59:59",strtotime($To_date));
		
		// $this->db->select('IT.Trans_date,First_name,Middle_name,Last_name,IT.Card_id AS Membership_ID,Tier_name,TT.Trans_type,Bill_no,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Coalition_Loyalty_pts,Card_id2 as Transfer_to,Transfer_points,Remarks');
		
		$this->db->select('IT.Trans_date,First_name,Last_name,IT.Card_id AS Membership_ID,Tier_name,TT.Trans_type,Bill_no,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Card_id2 as Transfer_to,Transfer_points,Remarks');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->join('igain_tier_master as TM','IE.Tier_id=TM.Tier_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		
		// $this->db->where('IT.Trans_type !=' , 10);
		// $this->db->where('IT.Trans_type !=' , 9);
		
		$this->db->where_not_in('IT.Trans_type', array('9','10','12','17','20','22','21','24','25','26','27','28'));
				
		if($Enrollement_id!=0)//Single Customers
		{
			$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		}
		if($transaction_type_id!=0)//Single Transaction Type
		{
			$this->db->where('IT.Trans_type' , $transaction_type_id);
		}
		if($Tier_id!=0)//Selected Tier
		{
			$this->db->where('IE.Tier_id' , $Tier_id);
		}
		$this->db->order_by('IT.Trans_id' , 'desc');
		
		//$this->db->limit($limit,$start);
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				// $this->db->select('IT.Trans_date,First_name,Middle_name,Last_name,IT.Card_id AS Membership_ID,Tier_name,TT.Trans_type,Bill_no,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Coalition_Loyalty_pts,Card_id2 as Transfer_to,Transfer_points,Remarks');
			
				$this->db->select('IT.Trans_date,First_name,Middle_name,Last_name,IT.Card_id AS Membership_ID,Tier_name,TT.Trans_type,Bill_no,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Card_id2 as Transfer_to,Transfer_points,Remarks');
				
				if($row->Purchase_amount==0)
				{
					$row->Purchase_amount="-";
				}
				if($row->Redeem_points==0)
				{
					$row->Redeem_points="-";
				}
				if($row->Paid_amount==0)
				{
					$row->Paid_amount="-";
				}
				if($row->Topup_amount==0)
				{
					$row->Topup_amount="-";
				}
				/* if($row->Loyalty_pts==0)
				{
					$row->Loyalty_pts="-";
				} */
				if($row->Transfer_to==0)
				{
					$row->Transfer_to="-";
				}
				if($row->Transfer_points==0)
				{
					$row->Transfer_points="-";
				}
				if($row->Bill_no==0)
				{
					$row->Bill_no="-";
				}
				if($row->Remarks=="")
				{
					$row->Remarks="-";
				}
				/* if($row->Coalition_Loyalty_pts==0)
				{
					$row->Coalition_Loyalty_pts="-";
				}
				else
				{
					$row->Coalition_Loyalty_pts=round($row->Coalition_Loyalty_pts);
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
	/************************ Customer Reports ***************************/
	/************************ Customer Redemption Reports start***************************/
	function get_cust_redemption_details($Company_id,$From_date,$To_date,$transaction_type_id,$Single_cust_membership_id,$Voucher_status,$start,$limit)
	{
		$From_date=date("Y-m-d 00:00:00",strtotime($From_date));
		$To_date=date("Y-m-d 23:59:59",strtotime($To_date));
		
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Redeem_points,IT.Card_id,IT.Company_id,Item_code,Voucher_no,Voucher_status,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch,Merchandize_item_name,Quantity,Redeem_points AS Redeem_points_per_Item,Partner_name,Branch_name,IE.Blocked_points,Address');
		
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
		
		$this->db->join(' igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join(' igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->where('IB.Company_id' , $Company_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('TT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		$this->db->where('IT.Trans_type' , $transaction_type_id);
		$this->db->group_by('Trans_id');
		
		if($Single_cust_membership_id!=0)
		{
			$this->db->where('IT.Card_id' , $Single_cust_membership_id);
		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		$this->db->order_by('IT.Trans_id' , 'desc');
	/* 	if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		
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
	function get_cust_redemption_details_exports($Company_id,$From_date,$To_date,$transaction_type_id,$Single_cust_membership_id,$Voucher_status)
	{
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		
		$this->db->select('First_name,Last_name,IT.Trans_date,IT.Card_id as Membership_ID,Item_code,Merchandize_item_name,Quantity,Redeem_points AS Redeem_points_per_Item,(Redeem_points*Quantity) AS  Total_Redeem_points,Partner_name,Branch_name,Voucher_no,Voucher_status');
		
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
		$this->db->join(' igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join(' igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->where('IB.Company_id' , $Company_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('TT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		$this->db->where('IT.Trans_type' , $transaction_type_id);
		$this->db->group_by('Trans_id');
		
		if($Single_cust_membership_id!=0)
		{
			$this->db->where('IT.Card_id' , $Single_cust_membership_id);
		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		$this->db->order_by('IT.Trans_id' , 'desc');
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		
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
	
	function get_cust_redemption_summary($Company_id,$From_date,$To_date,$transaction_type_id,$Single_cust_membership_id,$report_type,$Voucher_status,$start,$limit)
	{
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,SUM(Redeem_points*Quantity) AS Total_points,IT.Card_id,IE.Blocked_points,Address');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
		$this->db->join(' igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join(' igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->where('IB.Company_id' , $Company_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('TT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		$this->db->where('IT.Trans_type' , $transaction_type_id);
		
		if($Single_cust_membership_id!=0)
		{
			$this->db->where('IT.Card_id' , $Single_cust_membership_id);
		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		$this->db->group_by("DATE(IT.Trans_date)","asc");
		$this->db->group_by("IT.Enrollement_id","asc");
		$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
	/* 	if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		
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
	
	function get_cust_redemption_summary_exports($Company_id,$From_date,$To_date,$transaction_type_id,$Single_cust_membership_id,$report_type,$Voucher_status)
	{
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		
		$this->db->select('DATE(IT.Trans_date) as Trans_date,IT.Card_id AS Membership_ID,First_name,Last_name,SUM(Redeem_points*Quantity) AS Total_Redeem_points');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
		$this->db->join(' igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join(' igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->where('IB.Company_id' , $Company_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('TT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		$this->db->where('IT.Trans_type' , $transaction_type_id);
		
		if($Single_cust_membership_id!=0)
		{
			$this->db->where('IT.Card_id' , $Single_cust_membership_id);
		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		
		$this->db->group_by("DATE(IT.Trans_date)","asc");
		$this->db->group_by("IT.Enrollement_id","asc");
		$this->db->order_by('IT.Enrollement_id,IT.Trans_date' , 'desc');
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		
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
	
	/************************ Customer Redemption Reports end***************************/
	/************************ Partner Redemption Reports start***************************/
	function get_partner_redemption_details($Company_id,$From_date,$To_date,$Partner_id,$partner_branches,$Voucher_status,$start,$limit)
	{
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));
		
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Redeem_points,IT.Card_id,IT.Company_id,Item_code,Voucher_no,Voucher_status,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch,Merchandize_item_name,Quantity,Redeem_points AS Redeem_points_per_Item,Partner_name,Branch_name,Cost_payable_to_partner');
		
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
		$this->db->join(' igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join(' igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->where('IB.Company_id' , $Company_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('TT.Company_id' , $Company_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		
		if($Partner_id!=0)
		{
			$this->db->where('IT.Merchandize_Partner_id' , $Partner_id);
		}
		if($partner_branches!='0')
		{
			$this->db->where('IT.Merchandize_Partner_branch' , $partner_branches);
		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$this->db->group_by('Trans_id');
		//$this->db->order_by('IT.Trans_date,IT.Enrollement_id,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch' , 'desc');
		
		$this->db->order_by('IT.Trans_id' , 'desc');
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		
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
	
	
	function get_partner_redemption_details_exports($Company_id,$From_date,$To_date,$Partner_id,$partner_branches,$Voucher_status)
	{
		  $From_date=date("Y-m-d",strtotime($From_date));
		  $To_date=date("Y-m-d",strtotime($To_date));
		  
		  $this->db->select('IT.Trans_date,IT.Card_id as Membership_ID,First_name,Middle_name,Last_name,Partner_name,Branch_name,Item_code,Merchandize_item_name,Quantity,Redeem_points,Redeem_points AS Redeem_points_per_Item,(Redeem_points*Quantity) as Total_Redeemed_Points,Voucher_no,Voucher_status,(Cost_payable_to_partner*Quantity) as Cost_payable_to_partner');
		 
		  $this->db->from('igain_transaction as IT');
		  $this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		  $this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
		  $this->db->join(' igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		  $this->db->join(' igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		  $this->db->where('IB.Company_id' , $Company_id);
		  $this->db->where('IT.Company_id' , $Company_id);
		  $this->db->where('TT.Company_id' , $Company_id);
		  $this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		 
		 if($Partner_id!=0)
		  {
		   $this->db->where('IT.Merchandize_Partner_id' , $Partner_id);
		  }
		  if($partner_branches!='0')
		  {
		   $this->db->where('IT.Merchandize_Partner_branch' , $partner_branches);
		  }
		  if($Voucher_status!='0')
		  {
		   $this->db->where('IT.Voucher_status' , $Voucher_status);
		  }
		  $this->db->group_by('Trans_id');
		  //$this->db->order_by('IT.Trans_date,IT.Enrollement_id,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch' , 'desc');
		  $this->db->order_by('IT.Trans_id' , 'desc');
		  $sql51 = $this->db->get();
		  //echo "<br>".$this->db->last_query();
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
		
	/************************ Partner Redemption Reports end***************************/
	
	public function get_cust_high_value_trans_report($Company_id,$start_date,$end_date,$Value_type,$Operatorid,$Criteria,$Criteria_value,$Criteria_value2,$start,$limit)
	{
		$From_date=date("Y-m-d",strtotime($start_date));
		$To_date=date("Y-m-d",strtotime($end_date));
		
		if($Value_type==1)//High Value_type
		{
			$this->db->select('IT.Trans_date,IT.Card_id as Membership_ID,First_name,Middle_name,Last_name,TT.Trans_type,Bill_no,`Purchase_amount`,`Redeem_points`,`Loyalty_pts`,balance_to_pay,IT.Enrollement_id');
		}
		else
		{
			$this->db->select('IT.Trans_date,IT.Card_id as Membership_ID,First_name,Middle_name,Last_name,TT.Trans_type,SUM(`Purchase_amount`) AS Total_Purchase_Amount,SUM(`Loyalty_pts`) AS Total_Gained_Points,SUM(Redeem_points) as Total_Redeemed_Points,SUM(balance_to_pay) as Total_balance_to_pay');
			$this->db->group_by('IT.Enrollement_id');
		}
		
		
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('IT.Trans_type' , 2);//Purchase
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		
		if($Value_type==1)//High Value_type
		{
			if($Criteria==1)//Purchase
			{
				if($Operatorid=="Between")
				{
					$this->db->where("IT.Purchase_amount BETWEEN '".$Criteria_value."' AND '".$Criteria_value2."'");
				}
				else
				{
					$this->db->where('IT.Purchase_amount '.$Operatorid , $Criteria_value);
				}
			}
			else //gained points
			{
				if($Operatorid=="Between")
				{
					$this->db->where("IT.Loyalty_pts BETWEEN '".$Criteria_value."' AND '".$Criteria_value2."'");
				}
				else
				{
					$this->db->where('IT.Loyalty_pts '.$Operatorid , $Criteria_value);
				}
			}
		}
		
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$this->db->order_by('IT.Trans_date' , 'desc');
		//$this->db->group_by('IT.Enrollement_id');
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			 foreach ($sql51->result() as $row)
			{
				$Show_member=0;
				if($Value_type==2)//Total High Value_type
				{
					if($Criteria==1)//Purchase
					{
						$Total_value=$row->Total_Purchase_Amount;
					}	
					else //Gained Points
					{
						$Total_value=$row->Total_Gained_Points;
					}
					
					if($Operatorid=="<")
					{
						if($Total_value < $Criteria_value)
						{
							$Show_member=1;
						}
					}
					if($Operatorid=="<=")
					{
						if($Total_value <= $Criteria_value)
						{
							$Show_member=1;
						}
					}
					if($Operatorid==">")
					{
						if($Total_value > $Criteria_value)
						{
							$Show_member=1;
						}
					}
					if($Operatorid==">=")
					{
						if($Total_value >= $Criteria_value)
						{
							$Show_member=1;
						}
					}
					if($Operatorid=="=")
					{
						if($Total_value == $Criteria_value)
						{
							$Show_member=1;
						}
					}
					if($Operatorid=="!=")
					{
						if($Total_value != $Criteria_value)
						{
							$Show_member=1;
						}
					}
					if($Operatorid=="Between")
					{
						if(($Total_value >= $Criteria_value) && ($Total_value <= $Criteria_value2))
						{
							$Show_member=1;
						}
					}
					
					
					if($Show_member==1)
					{
					 $data[] = $row;
					}
				}			
               else
			   {
					 $data[] = $row;
			   }
               
            }
			 return $data; 
		}
		else
		{
			return false;
		}
	}	
	public function get_cust_enrollment_report($Company_id,$start_date,$end_date,$start,$limit)
	{
		$this->db->select('joined_date,IE.Card_id as Membership_ID,First_name,Middle_name,Last_name,(Current_balance-Blocked_points) as Total_coalition_balance,User_email_id,total_purchase AS 
		Total_Purchase_Amount,SUM(`Coalition_Loyalty_pts`+`Loyalty_pts`+`Topup_amount`+`Transfer_points`) AS Total_Gained_Points,Total_reddems as Total_Redeemed_Points,SUM(balance_to_pay) as Total_balance_to_pay,User_activated');

		$this->db->from('igain_enrollment_master as IE');
		$this->db->join('igain_transaction as IT','IE.Enrollement_id=IT.Enrollement_id','LEFT');
		$this->db->where('IE.Company_id' , $Company_id);
		$this->db->where('IE.User_id' , 1);
		$this->db->where("joined_date BETWEEN '".$start_date."' AND '".$end_date."'");
		$this->db->order_by('IE.Enrollement_id' , 'desc');
		$this->db->group_by('IT.Enrollement_id');
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
		//return $sql51->row();
		foreach ($sql51->result() as $row)
		{
			if($row->User_activated==1)
			{
			 $row->User_activated="Yes";
			}
			else
			{
			 $row->User_activated="No";
			} 
			if($row->Total_Purchase_Amount==0)
			{
			 $row->Total_Purchase_Amount="-";
			}
			if($row->Total_Redeemed_Points==0)
			{
			 $row->Total_Redeemed_Points="-";
			}
			if($row->Total_Gained_Points==0)
			{
			 $row->Total_Gained_Points="-";
			}
			if($row->Total_balance_to_pay==0)
			{
			 $row->Total_balance_to_pay="-";
			}
			if($row->Total_coalition_balance==0)
			{
			 $row->Total_coalition_balance="-";
			}
			else
			{
				$row->Total_coalition_balance=round($row->Total_coalition_balance);
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
	
	public function get_cust_expiry_report($Company_id,$start_date,$end_date,$start,$limit)
	{
		$this->db->select('IT.Trans_date as Expired_Date,First_name,Middle_name,Last_name,IT.Card_id  as Membership_ID,Expired_points,User_email_id,(Current_balance-Blocked_points) AS Total_Balance');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('IT.Trans_type' , 14);
		$this->db->where("IT.Trans_date BETWEEN '".$start_date."' AND '".$end_date."'");
		$this->db->order_by('IT.Trans_id' , 'desc');
		/* if($limit != NULL || $start != NULL){				
					$this->db->limit($limit,$start);
				} */
		$sql51 = $this->db->get();
		//echo "<br>".$this->db->last_query();
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
	function get_all_cust_last_points_used($Company_id,$start,$limit)
	{
		$this->db->select('First_name,Last_name,Trans_id,Trans_type,Redeem_points,MAX(Trans_date) as Trans_date ,T.Enrollement_id,T.Card_id as Membership_ID,Current_balance,Blocked_points,User_email_id,(Current_balance-Blocked_points) AS Total_Balance');
	
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->order_by('Trans_id','desc');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'Redeem_points!='=>0,'Trans_type IN (2,3,10)'));
		 /* if($limit != NULL || $start != ""){				
					$this->db->limit($limit,$start);
				} */
		$sql51=$this->db->get();
		//echo "<br><br>Transcation Query-->".$this->db->last_query();
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
/****************************** AMIT END ****************************/
}
?>