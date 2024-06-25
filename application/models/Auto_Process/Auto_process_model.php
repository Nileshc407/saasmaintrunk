<?php
class Auto_process_model extends CI_Model
{
	
	function get_cust_last_points_used($Company_id)
	{
		$this->db->select('First_name,Last_name,Trans_id,Trans_type,Redeem_points,MAX(Trans_date) AS Trans_date,T.Enrollement_id,T.Card_id,Current_balance,Blocked_points,Item_code');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->order_by('Trans_id','desc');
		$this->db->where(array('T.Company_id'=>$Company_id));
		// $this->db->where('Redeem_points!= 0');
		$this->db->where('Trans_type IN (1,2,3,7,8,10,12,13,15,19,29)');
		
		$sql=$this->db->get();
		echo "<br><br>Transcation Query-->".$this->db->last_query();//die;
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
	function Get_Cumulative_spend_transactions($Company_id,$From_date,$Till_date,$Business_flag)
	{
		$this->db->select("First_name,Last_name,E.Enrollement_id,SUM(Purchase_amount) AS Total_Spend,TM.Tier_id,Tier_name,Tier_level_id");
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->join('igain_tier_master as TM','E.Tier_id=TM.Tier_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'E.User_activated'=>1,'E.Employee_flag'=>0,'E.Business_flag'=>$Business_flag));
		$this->db->where('T.Trans_type IN(2,12)');
		//$this->db->where(array('E.Tier_id'=>$Tier_id,'TM.Tier_id'=>$Tier_id));
		$this->db->where("Trans_date BETWEEN '".$From_date."' AND '".$Till_date."'");
		
		$sql=$this->db->get();
		// echo "<br><br>Spend_transactions Query-->".$this->db->last_query();die;
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
		function Get_Cumulative_Points_Accumlated($Company_id,$From_date,$Till_date,$Business_flag)
	{
	
		$this->db->select("First_name,Last_name,E.Enrollement_id,SUM(Loyalty_pts) AS Total_Points,TM.Tier_id,Tier_name,Tier_level_id");
				
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->join('igain_tier_master as TM','E.Tier_id=TM.Tier_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'E.User_activated'=>1,'E.Employee_flag'=>0,'E.Business_flag'=>$Business_flag));
		$this->db->where('T.Trans_type IN(2,12)');
		//$this->db->where(array('E.Tier_id'=>$Tier_id,'TM.Tier_id'=>$Tier_id));
		$this->db->where("Trans_date BETWEEN '".$From_date."' AND '".$Till_date."'");
		 
		$sql=$this->db->get();
		echo "<br><br>Points acc Transation Query-->".$this->db->last_query();
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
	
	function Get_Cumulative_Total_transactions($Company_id,$From_date,$Till_date,$Business_flag)
	{
		$this->db->select("First_name,Last_name,E.Enrollement_id,COUNT(*) AS Total_Transactions,TM.Tier_id,Tier_name,Tier_level_id");
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->join('igain_tier_master as TM','E.Tier_id=TM.Tier_id');
		$this->db->group_by('T.Enrollement_id');
		$this->db->where(array('T.Company_id'=>$Company_id,'E.User_activated'=>1,'E.Employee_flag'=>0,'E.Business_flag'=>$Business_flag));
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
		
		$today=date('Y-m-d');
		// $today='2022-05-12';
		$this->db->from('igain_cust_notification');
		//$this->db->where(array('Customer_id'=>$Enroll_id,'Company_id'=>$Company_id,'Communication_id' =>$Trigger_id,'Offer' =>"Trigger Notification"));
		
		// $this->db->where(array('Customer_id'=>$Enroll_id,'Company_id'=>$Company_id,'Communication_id' =>$Trigger_id));
		$this->db->where(array('Customer_id'=>$Enroll_id,'Company_id'=>$Company_id,'Communication_id' =>$Trigger_id,'DATE(Date)' =>$today));
		
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
		
		// echo $this->db->last_query();DIE;
		
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
	//****************** AMIT KAMBLE 6-5-2020******************************
		function get_user_types()
	{
		$this->db->select("User_id,User_type");
		$this->db->from('igain_user_type_master');
		
		
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
		function get_users_by_usertype($Company_id,$user_type)
	{
		$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Super_seller");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => $user_type,'Company_id' => $Company_id,'User_activated' => '1'));
		$sql = $this->db->get();
		// echo $this->db->last_query();die;
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
		public function Insert_schedule_report($Company_id, $report_id, $Brand_id, $user_type,$Primary_users,$Schedule,$user_type2,$Other_users,$enroll)
	{
		$data['Company_id'] = $Company_id;  
		$data['Report_id'] = $report_id;  
		$data['Brand_id'] = $Brand_id;	
		$data['Primary_user_type'] = $user_type;        
		$data['Primary_users_id'] = $Primary_users; 
		$data['Schedule'] = $Schedule;   		
		$data['Other_user_type'] = $user_type2;        
		$data['Other_users_id'] = $Other_users;        
		$data['Create_user_id'] = $enroll;        
		$data['Creation_date'] = date("Y-m-d H:i:s");        
		     
		$this->db->insert('igain_schedule_reports', $data);		
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Get_schedule_reports($Company_id)
	{
		$this->db->select("id,Brand_id,Report_id,First_name,Last_name,Schedule,Primary_users_id,Primary_user_type,User_type,Other_user_type,Other_users_id");
		$this->db->from('igain_schedule_reports as s');
		$this->db->join('igain_enrollment_master as e','s.Company_id=e.Company_id and s.Brand_id=e.Enrollement_id');
		$this->db->join('igain_user_type_master as u','s.Primary_user_type=u.User_id');
		$this->db->where(array('s.Company_id' => $Company_id));
		$this->db->group_by('Report_id');
		$this->db->group_by('Primary_users_id');
		$this->db->group_by('Primary_user_type');
		$this->db->group_by('Brand_id');
		$this->db->group_by('Schedule');
		$this->db->order_by('s.id','desc');
		$sql = $this->db->get();
		// echo $this->db->last_query();die;
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
	function Get_edit_schedule_reports($report_id,$Brand_id,$Primary_users_id,$Primary_user_type,$Company_id)
	{
		$this->db->select("id,Brand_id,Report_id,Schedule,Primary_users_id,Primary_user_type,Other_user_type,Other_users_id");
		$this->db->from('igain_schedule_reports as s');
		$this->db->where(array('s.Report_id' => $report_id,'s.Brand_id' => $Brand_id,'s.Primary_users_id' => $Primary_users_id,'s.Primary_user_type' => $Primary_user_type,'s.Company_id' => $Company_id));
		// $this->db->join('igain_enrollment_master as e','s.Company_id=e.Company_id and s.Other_users_id=e.Enrollement_id');

		$sql = $this->db->get();
		 // echo $this->db->last_query();die;
		if ($sql->num_rows() > 0)
		{
        	// return $sql->row();
			foreach ($sql->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	function get_user_type($user_type)   
	{
		$this->db->select("*");
		$this->db->from('igain_user_type_master');
		$this->db->where(array('User_id' => $user_type));
		
		$sql = $this->db->get();
		if ($sql->num_rows() > 0)
		{
			
        	return $sql->row();
        }
        return false;
	
	}
	 function Delete_schedule_report($Report_id,$Brand_id,$Primary_user_type,$Schedule)
	{
		$this->db->where(array('Brand_id'=>$Brand_id,'Report_id'=>$Report_id,'Primary_user_type'=>$Primary_user_type,'Schedule'=>$Schedule));
		$this->db->delete("igain_schedule_reports");
		
		 // echo "<br><br>".$this->db->last_query();die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		} 
	}
	function get_cust_order_transaction_details($Company_id, $start_date, $end_date, $transaction_from, $membership_id, $Voucher_status,$Outlet_id,$start, $limit)
	{
		$start_date=date("Y-m-d 00:00:00", strtotime($start_date)); 
		$end_date=date("Y-m-d 23:59:59", strtotime($end_date));
		
		$this->db->select("t.Card_id as Membership_ID,CONCAT(e.First_name,' ',e.Last_name) as Member_name,t.Seller_name as Outlet,t.Trans_date as Order_date,t.Bill_no as Order_no,t.Manual_billno as Pos_billno,t.Trans_type,t.Item_code,t.Quantity,t.Purchase_amount,t.Enrollement_id,t.Delivery_method as Order_type,t.Voucher_status as Order_status");
		
		$this->db->from('igain_transaction as t'); 
		$this->db->join('igain_enrollment_master as e', 'e.Enrollement_id = t.Enrollement_id');
		//$this->db->join('igain_company_merchandise_catalogue as m','t.Item_code=m.Company_merchandize_item_code','LEFT');
		$this->db->where(array('t.Company_id' => $Company_id));
		if($transaction_from > 0){
			$this->db->where(array('t.Trans_type' => $transaction_from));
		}
		else
		{
			$this->db->where_in('t.Trans_type',array(2,12));
		}
		
		if($membership_id != ""){
			$this->db->where(array('t.Card_id' => $membership_id));
		}
		
		if($Voucher_status > 0){
			$this->db->where(array('t.Voucher_status' => $Voucher_status));
		}
		
		if(count($Outlet_id) > 0 && $Outlet_id[0] > 0){
				$this->db->where_in('t.Seller',$Outlet_id);
			}
		
		$this->db->where('t.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');

		/* if($limit != NULL || $start != ""){
				
				$this->db->limit($limit,$start);
			} */
		$this->db->order_by('t.Trans_id','DESC');
			$query58 = $this->db->get()->result();
		// echo $this->db->last_query(); die;
		
		if($query58 != NULL){
			foreach($query58 as $row58)
			{
				$this->db->select("DISTINCT(Merchandize_item_name),c.Merchandize_category_id,Merchandize_category_name");
				$this->db->from("igain_company_merchandise_catalogue as c");
				$this->db->join("igain_merchandize_category as m",'c.Company_id=m.Company_id AND c.Merchandize_category_id=m.Merchandize_category_id');

				$this->db->where(array('Company_merchandize_item_code'=>$row58->Item_code,'c.Company_id'=>$Company_id));

				$this->db->limit(1,0);
				$sql62 = $this->db->get();
			//	echo $this->db->last_query(); die;
				foreach ($sql62->result() as $row62)
				{
					$row58->Menu_name = $row62->Merchandize_item_name;
					$row58->Category = $row62->Merchandize_category_name;
				
				}
				
				$data58[] = $row58;
			}
			return $data58;
		}
		else
		{
			return false;
		}
		
			
			
	}
	//**XXXX**************** AMIT KAMBLE 6-5-2020******************************
	
/****************Nilesh 20-08-2020************************/
	function Fetch_active_redeem_request($Company_id,$Todays_date)
	{
		$start_date=date("Y-m-d 00:00:00", strtotime($Todays_date)); 
		$end_date=date("Y-m-d 23:59:59", strtotime($Todays_date));
		
		$this->db->select("*");
		$this->db->from("igain_cust_redeem_request");
		$this->db->where(array('Company_id'=>$Company_id,'Confirmation_flag'=>0));
		$this->db->where('Creation_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
		$Sql=$this->db->get();
		
		if ($Sql->num_rows() > 0)
		{
			foreach($Sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	public function Update_redeem_request($Company_id,$requestid,$data)
	{		
		$this->db->where(array('Company_id'=>$Company_id,'id'=>$requestid)); 
		$this->db->update('igain_cust_redeem_request', $data); 
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
/****************Nilesh 20-08-2020************************/
//*********** 04-03-2021 ********* AMIT KAMBLE ******
	function Get_Company_Tier_meal_topup($Tier_id,$Company_id)
	{
	  $this->db->select("Tier_id,Redeemtion_limit");
	  $this->db->from('igain_tier_master');
	  $this->db->where(array('Tier_id' => $Tier_id,'Company_id' => $Company_id));
	  $sql = $this->db->get();
	  
		if ($sql->num_rows() > 0)
		{
        	foreach ($sql->result() as $row)
			{
                $Topup = $row->Redeemtion_limit;
            }
            return $Topup;
        }
        return 0;
	}
	public function insert_topup_details($data)
	{
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Update_Customer_details($Enrollement_id,$Current_balance,$Total_topup_amt)
	{
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->update('igain_enrollment_master',array('Current_balance'=>$Current_balance,'Total_topup_amt'=>$Total_topup_amt));
		
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
	function Fetch_Super_Seller_details($Company_id)
	{
		
		$this->db->select("Topup_Bill_no");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','Super_seller ' => '1','User_activated' => '1','Company_id' => $Company_id));
		// echo $this->db->last_query();
		$sql = $this->db->get();		
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
		
	}
	public function update_topup_billno($Seller_id,$Topup_Bill_no)
	{
		$data = array(
					'Topup_Bill_no' => $Topup_Bill_no
				);
		$this->db->where(array('Enrollement_id' => $Seller_id));
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
	function Fetch_Meal_Company()
	{
		$company_sql = $this->db->query("Select Company_id,Company_name,Notification_send_to_email from igain_company_master where Activated=1 and Enable_company_meal_flag=1");
		$company_result = $company_sql->result_array();
		// echo $this->db->last_query();
		if($company_sql->num_rows() > 0)
		{
			return $company_result;
		}
		else
		{
			return 0;
		}
		
	}
	//----------------------------------------Daily Consumptions-----------------------------------
	function Fetch_daily_consumption_Company()
	{
		$company_sql = $this->db->query("Select Company_id,Company_name,Notification_send_to_email from igain_company_master where Activated=1 and Daily_points_consumption_flag=1");
		$company_result = $company_sql->result_array();
		// echo $this->db->last_query();
		if($company_sql->num_rows() > 0)
		{
			return $company_result;
		}
		else
		{
			return 0;
		}
		
	}
		function Get_Company_Tier_daily_limit($Tier_id,$Company_id)
	{
	  $this->db->select("Tier_id,Redeemtion_limit");
	  $this->db->from('igain_tier_master');
	  $this->db->where(array('Tier_id' => $Tier_id,'Company_id' => $Company_id));
	  $sql = $this->db->get();
	  
		if ($sql->num_rows() > 0)
		{
        	foreach ($sql->result() as $row)
			{
                $Consumption_limit = $row->Redeemtion_limit;
            }
            return $Consumption_limit;
        }
        return 0;
	}
	function Get_TierCust_expiry_points($Company_id,$Enrollement_id)
	{
		$last_date = date("Y-m-d",strtotime("-1 day"));
		
		
		$this->db->select('SUM(Redeem_points) as Total_redeems');
		$this->db->from('igain_transaction as T');
		$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id');
		$this->db->where("Trans_date BETWEEN '".$last_date." 00:00:00' AND '".$last_date." 23:59:59'");
		$this->db->where("Trans_type IN (2,3,10)");
		$this->db->where(array('T.Company_id'=>$Company_id,'T.Enrollement_id'=>$Enrollement_id));//,'Redeem_points!='=>0
		$this->db->group_by('T.Enrollement_id');
		
		
		
		$sql=$this->db->get();
		echo "<br><br>Transcation Query-->".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			foreach ($sql->result() as $row)
			{
                $Total_redeems = $row->Total_redeems;
            }
            return $Total_redeems;
		}
		else
		{
			return 0;
		}	
		
			
	}
	
	public function insert_expired_points($data)
	{
		$this->db->insert('igain_transaction', $data);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		public function Update_Cust_trans_details($Enrollement_id,$Current_balance,$Total_reddems)
	{
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->update('igain_enrollment_master',array('Current_balance'=>$Current_balance,'Total_reddems'=>$Total_reddems));
		
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
}
?>
