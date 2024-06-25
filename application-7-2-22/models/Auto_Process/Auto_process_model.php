<?php
class Auto_process_model extends CI_Model
{
	
	function get_cust_last_points_used($Company_id,$Card_id)
	{
		$this->db->select('First_name,Last_name,Trans_id,Trans_type,Redeem_points,Trans_date,T.Enrollement_id,T.Card_id,Current_balance,Blocked_points,Item_code');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->order_by('Trans_id','desc');
		$this->db->where(array('T.Company_id'=>$Company_id,'T.Card_id'=>$Card_id,'Redeem_points!='=>0,'Trans_type IN (2,3,10)'));
		
		$sql=$this->db->get();
		// echo "<br><br>Transcation Query-->".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
			
	}
		public function Tier_list($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' =>1));
		
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
	function Get_Cumulative_spend_transactions($Company_id,$From_date,$Till_date)
	{
		$this->db->select("First_name,Last_name,E.Enrollement_id,SUM(Purchase_amount) AS Total_Spend,TM.Tier_id,Tier_name,Tier_level_id");
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->join('igain_tier_master as TM','E.Tier_id=TM.Tier_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'E.User_activated'=>1));
		//$this->db->where(array('E.Tier_id'=>$Tier_id,'TM.Tier_id'=>$Tier_id));
		$this->db->where("Trans_date BETWEEN '".$From_date."' AND '".$Till_date."'");
		
		$sql=$this->db->get();
		echo "<br><br>Transcation Query-->".$this->db->last_query();
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
		function Get_Cumulative_Points_Accumlated($Company_id,$From_date,$Till_date)
	{
		$this->db->select("First_name,Last_name,E.Enrollement_id,SUM(Loyalty_pts) AS Total_Points,TM.Tier_id,Tier_name,Tier_level_id");
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->join('igain_tier_master as TM','E.Tier_id=TM.Tier_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'E.User_activated'=>1));
		//$this->db->where(array('E.Tier_id'=>$Tier_id,'TM.Tier_id'=>$Tier_id));
		$this->db->where("Trans_date BETWEEN '".$From_date."' AND '".$Till_date."'");
		 
		$sql=$this->db->get();
		echo "<br><br>Points acc Transcation Query-->".$this->db->last_query();
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
	
	function Get_Cumulative_Total_transactions($Company_id,$From_date,$Till_date)
	{
		$this->db->select("First_name,Last_name,E.Enrollement_id,COUNT(*) AS Total_Transactions,TM.Tier_id,Tier_name,Tier_level_id");
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->join('igain_tier_master as TM','E.Tier_id=TM.Tier_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'E.User_activated'=>1));
		$this->db->where('T.Trans_type IN(2,12)');
		//$this->db->where(array('E.Tier_id'=>$Tier_id,'TM.Tier_id'=>$Tier_id));
		$this->db->where("Trans_date BETWEEN '".$From_date."' AND '".$Till_date."'");
		
		$sql=$this->db->get();
		 echo "<br><br>Transcation Query-->".$this->db->last_query();
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
	
	public function Check_operator($Operator_id,$Criteria,$Criteria_value,$Criteria_value2)
	{
		$flag=0;
		if($Operator_id==1)
		{
			echo "<br>if($Criteria==$Criteria_value)";
			if($Criteria==$Criteria_value)
			{
				$flag=1;
			}
		}
		if($Operator_id==2)
		{
			echo "<br>if($Criteria > $Criteria_value)";
			if($Criteria > $Criteria_value)
			{
				$flag=1;
			}
		}
		if($Operator_id==3)
		{
			echo "if($Criteria >= $Criteria_value)";
			if($Criteria >= $Criteria_value)
			{
				$flag=1;
			}
		}
		if($Operator_id==4)
		{
			echo "<br>if($Criteria < $Criteria_value)";
			if($Criteria < $Criteria_value)
			{
				$flag=1;
			}
		}
		if($Operator_id==5)
		{
			echo "<br>if($Criteria <= $Criteria_value)";
			if($Criteria <= $Criteria_value)
			{
				$flag=1;
			}
		}
		
		if($Operator_id==6)
		{
			echo "<br>if($Criteria >= $Criteria_value && $Criteria < $Criteria_value2)";
			if($Criteria >= $Criteria_value && $Criteria < $Criteria_value2)
			{
				$flag=1;
			}
		}
		return $flag;
	}
	public function Update_Customer_Balance($Enrollement_id,$Current_balance)
	{
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->update('igain_enrollment_master',array('Current_balance'=>$Current_balance));
		
		//echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return 0;
		}	
	}
	public function Update_Customer_Tier($Enrollement_id,$Tier_id)
	{
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->update('igain_enrollment_master',array('Tier_id'=>$Tier_id));
		
		//echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return 0;
		}	
	}
	 
		//**************** AMIT work START 01-06-2016 *****************************************************/
	public function Insert_points_expiry_trans($Company_id,$Enrollement_id,$Expired_points,$Card_id)
    {
		$Trans_date=date("Y-m-d");
		$data['Company_id'] = $Company_id;
		$data['Enrollement_id'] = $Enrollement_id;        
		$data['Trans_type'] = 14;        //Points Expiry
		$data['Card_id'] = $Card_id;        
		$data['Expired_points'] = $Expired_points;        
		$data['Trans_date'] = $Trans_date;        
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
//**************** AMIT work end *****************************************************/
	
//**************** amit work end *****************************************************/	

//**************** sandeep work start *****************************************************/	
	
	public function get_tier_customers($Company_id,$Tier_id)
	{
		$this->db->select('a.Enrollement_id,a.First_name,a.Last_name,a.User_email_id,Current_balance');
		$this->db->from('igain_enrollment_master as a');
		$this->db->where(array('a.Company_id' => $Company_id,'User_id' =>1,'a.User_activated' =>1,'Tier_id' =>$Tier_id ));
	
		$query13 = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($query13->num_rows() > 0)
		{
			foreach($query13->result() as $row13)
			{
				$dtaaa13[] = $row13;
			}
			
			return $dtaaa13;
		}
		
		return false;
	}
		
	public function who_not_did_transaction($Company_id)
	{
		$this->db->select('a.Enrollement_id,a.First_name,a.Last_name,a.User_email_id');
		$this->db->from('igain_enrollment_master as a');
		$this->db->join('igain_transaction as b','a.Enrollement_id = b.Enrollement_id','left');
		$this->db->where(array('a.Company_id' => $Company_id,'User_id' =>1,'a.User_activated' =>1));
		// $this->db->where('b.Enrollement_id IS NULL');
		
		$query14 = $this->db->get();
		
		echo "<br>**<b>who_not_did_transaction**</b>".$this->db->last_query();
		
		if($query14->num_rows() > 0)
		{
			foreach($query14->result() as $row14)
			{
				$dtaaa[] = $row14;
			}
			
			return $dtaaa;
		}
		
		return false;
		
	}
	
	public function who_did_transactions($Company_id)
	{	
		$this->db->distinct('b.Enrollement_id');
		$this->db->select('b.Enrollement_id,a.First_name,a.Last_name,a.User_email_id');
		$this->db->from('igain_transaction as b');
		$this->db->join('igain_enrollment_master as a','a.Enrollement_id = b.Enrollement_id');
		$this->db->where(array('b.Company_id' => $Company_id,'a.User_id' =>1,'a.User_activated' =>1));
		
		$query14 = $this->db->get();
		
		echo "<br>**<b>who_did_transactions**</b>".$this->db->last_query();
		
		if($query14->num_rows() > 0)
		{
			foreach($query14->result() as $row14)
			{
				$dtaaa12[] = $row14;
			}
			
			return $dtaaa12;
		}
		
		return false;
	}
	
	public function get_max_transaction_amt($Company_id,$Enroll_id,$From_date,$Till_date)
	{
		$this->db->select_max('Purchase_amount');
		$this->db->where(array('Company_id'=>$Company_id,'Enrollement_id'=> $Enroll_id,'Trans_type'=>2));
		$this->db->where("Trans_date BETWEEN '".$From_date."' AND '".$Till_date."' ");
		
		$query = $this->db->get('igain_transaction');
		
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)
		{
        	// return $query->result_array();
			 $res2 = $query->result_array();
			return $res2[0]['Purchase_amount'];
        }
		else
		{
			return 0;
		}
	}
	
	public function get_auction_participents($Company_id,$Auction_id)
	{
		$this->db->distinct('b.Enrollment_id');
		$this->db->select('b.Enrollment_id,a.First_name,a.Last_name,a.User_email_id,b.Creation_date,b.Bid_value');
		$this->db->from('igain_auction_winner as b');
		$this->db->join('igain_enrollment_master as a','a.Enrollement_id = b.Enrollment_id');
		$this->db->where(array('b.Company_id'=>$Company_id, 'b.Auction_id'=>$Auction_id, 'b.Winner_flag'=>0));
		$this->db->order_by('Id','desc');
		$query15 = $this->db->get();
		
		echo "<br>get_auction_participents-->".$this->db->last_query();
		
		if($query15->num_rows() > 0)
		{
			foreach($query15->result() as $row15)
			{
				$dtaaa15[] = $row15;
			}
			
			return $dtaaa15;
		}
		
		return false;
	}
	
	public function validate_notification($Enroll_id,$Trigger_id,$Company_id)
	{
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id'=>$Enroll_id,'Company_id'=>$Company_id,'Communication_id' =>$Trigger_id,'Offer' =>"Trigger Notification"));
		
		$query16 = $this->db->get();
		 echo "<br>**validate_notification**->".$this->db->last_query();
		if($query16->num_rows() > 0)
		{
			return 0;
		}
		
		return 1;
	}
	
	public function edit_company_game($game_id)
	{
		$this->db->select('a.*,b.Game_name');
		$this->db->from("igain_game_company_master as a");
		$this->db->join("igain_game_master as b","a.Game_id = b.Game_id");
		$this->db->where('a.Company_game_id',$game_id);

		$queryopt1 = $this->db->get();
		
		if ($queryopt1->num_rows() > 0)
		{	
        	foreach ($queryopt1->result() as $row111)
			{
                $data111[] = $row111;
            }
            return $data111;
        }
        return false;
	}
	
	public function get_game_participents($Company_game_id,$Company_id)
	{
		$this->db->distinct('b.Enrollment_id');
		$this->db->select('b.Enrollment_id,a.First_name,a.Last_name,a.User_email_id');
		$this->db->from('igain_game_level_winner as b');
		$this->db->join('igain_enrollment_master as a','a.Enrollement_id = b.Enrollment_id');
		$this->db->where(array('b.Company_id'=>$Company_id, 'b.Company_game_id'=>$Company_game_id, 'b.Game_winner_flag'=>0));
		$query17 = $this->db->get();
		
		if($query17->num_rows() > 0)
		{
			foreach($query17->result() as $row17)
			{
				$data17[] = $row17;
			}
			
			return $data17;
		}
		
		return false;
	}
	
	public function get_hobbies_members($Merchant_type,$Company_id)
	{
		$this->db->distinct('b.Enrollement_id');
		$this->db->select('b.Enrollement_id,a.First_name,a.Last_name,a.User_email_id');
		$this->db->from('igain_hobbies_interest as b');
		$this->db->join('igain_enrollment_master as a','a.Enrollement_id = b.Enrollement_id');
		$this->db->where(array('Hobbie like'=>"%$Merchant_type%",'b.Company_id'=>$Company_id));
		
		$queryL = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($queryL->num_rows() > 0)
		{
			foreach($queryL->result() as $rowL)
			{
				$dataL[] = $rowL;
			}
			
			return $dataL;
		}
		
		return false;
	}
	
	public function get_hobbies_merchants($Merchant_type,$Company_id)
	{
		$this->db->select('Seller');
		$this->db->where(array('Merchant_type like' => "%$Merchant_type%",'Company_id'=>$Company_id));
		
		$queryL1 = $this->db->get('igain_item_category_master');
		
		//echo $this->db->last_query();
		
		if($queryL1->num_rows() > 0)
		{
			foreach($queryL1->result() as $rowL1)
			{
				$dataL1[] = $rowL1;
			}
			
			return $dataL1;
		}
		
		return false;
	}
	
	public function get_merchant_communication_offers($Seller)
	{
		$today = date("Y-m-d");
		
		$this->db->from('igain_seller_communication');			
		$this->db->where(array('seller_id'=>$Seller,'From_date > '=>"$today"));
		$sql1 = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($sql1->num_rows() > 0)
		{
			foreach($sql1->result() as $row41)
			{
				$data41[] = $row41;
			}
			
			return $data41;
		}
		
		return false;
		
	}
//**************** sandeep work end *****************************************************/	
	/******AMIT 19-04-2017***********************/
	public function Insert_Customer_Tier_auto_process($Enrollement_id,$Tier_id,$Process,$Old_Tier_level_id,$New_Tier_level_id,$Old_Tier_name,$Tier_name)
	{
		$data['Enrollement_id'] = $Enrollement_id;  
		$data['Process'] = $Process;	
		$data['Tier_id'] = $Tier_id;        
		$data['New_Tier_level_id'] = $New_Tier_level_id; 
		$data['Tier_name'] = $Tier_name;   		
		$data['Old_Tier_level_id'] = $Old_Tier_level_id;        
		$data['Old_Tier_name'] = $Old_Tier_name;        
		     
		$this->db->insert('igain_customer_tier_auto_process_child', $data);		
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function Insert_Customer_Tier_auto_process_log($Company_id,$Enrollement_id,$Tier_id,$Process,$Old_Tier_level_id,$New_Tier_level_id,$Old_Tier_name,$Tier_name)
	{
		$data['Company_id'] = $Company_id;  
		$data['Enrollement_id'] = $Enrollement_id;  
		$data['Process'] = $Process;	
		$data['Tier_id'] = $Tier_id;        
		$data['New_Tier_level_id'] = $New_Tier_level_id; 
		$data['Tier_name'] = $Tier_name;   		
		$data['Old_Tier_level_id'] = $Old_Tier_level_id;        
		$data['Old_Tier_name'] = $Old_Tier_name;        
		$data['Update_date'] = date("Y-m-d H:i:s");        
		     
		$this->db->insert('igain_customer_tier_auto_process_log', $data);		
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function Create_Customer_Tier_auto_process_child()
	{
		$this->load->dbforge();	
		
		$temp_table ='igain_customer_tier_auto_process_child';		
		$this->dbforge->drop_table($temp_table,TRUE);	
		/* if( $this->db->table_exists($temp_table,TRUE))
		{
			$this->dbforge->drop_table($temp_table,TRUE);
		}*/
		$fields = array(
						'Auto_id' => array('type' => 'INT','constraint' => '11','auto_increment' => TRUE),
						'Enrollement_id' => array('type' => 'INT','constraint' => '11'),
						'Process' => array('type' => 'VARCHAR','constraint' => '50'),
						'Tier_id' => array('type' => 'INT','constraint' => '11'),
						'New_Tier_level_id' => array('type' => 'INT','constraint' => '11'),
						'Tier_name' => array('type' => 'VARCHAR','constraint' => '50'),
						'Old_Tier_level_id' => array('type' => 'INT','constraint' => '11'),
						'Old_Tier_name' => array('type' => 'VARCHAR','constraint' => '50'),
						
					);
		$this->dbforge->add_key('Auto_id', TRUE);			
		$this->dbforge->add_field($fields);		
		$this->dbforge->create_table($temp_table);
		
		
		$temp_table2 ='igain_customer_tier_auto_process_log';		
		
		$fields2 = array(
						'Auto_id' => array('type' => 'INT','constraint' => '11','auto_increment' => TRUE),
						'Company_id' => array('type' => 'INT','constraint' => '11'),
						'Enrollement_id' => array('type' => 'INT','constraint' => '11'),
						'Process' => array('type' => 'VARCHAR','constraint' => '50'),
						'Tier_id' => array('type' => 'INT','constraint' => '11'),
						'New_Tier_level_id' => array('type' => 'INT','constraint' => '11'),
						'Tier_name' => array('type' => 'VARCHAR','constraint' => '50'),
						'Old_Tier_level_id' => array('type' => 'INT','constraint' => '11'),
						'Old_Tier_name' => array('type' => 'VARCHAR','constraint' => '50'),
						'Update_date' => array('type' => 'DATETIME'),
					);
		$this->dbforge->add_key('Auto_id', TRUE);			
		$this->dbforge->add_field($fields2);		
		$this->dbforge->create_table($temp_table2,TRUE);
		
		
	}
	public function Get_Customer_Tier_auto_process()
	{
		// $this->db->from('igain_customer_tier_auto_process_child');			
		$sql1=$this->db->query('select a.`Enrollement_id`,a.`Tier_id`,a.Process,a.Tier_name,a.Old_Tier_name,b.`New_Tier_level_id`,b.`Old_Tier_level_id` FROM `igain_customer_tier_auto_process_child` as a Inner join `igain_customer_tier_auto_process_child` as b ON a.New_Tier_level_id = b.New_Tier_level_id where a.`New_Tier_level_id` IN (SELECT max(`New_Tier_level_id`) FROM `igain_customer_tier_auto_process_child` where `Enrollement_id`=a.`Enrollement_id`) group by `Enrollement_id`');			
		//$sql1 = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($sql1->num_rows() > 0)
		{
			foreach($sql1->result() as $row41)
			{
				$data41[] = $row41;
			}
			
			return $data41;
		}
		
		return false;
		
	}
	public function tier_based_customers($Tier,$Company_id)
	{			
		$this->db->select('*');
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
}

?>
