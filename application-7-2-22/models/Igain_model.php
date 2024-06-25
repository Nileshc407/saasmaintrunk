<?php
class Igain_model extends CI_Model
{
//**************** sandeep work start ***********************************	
	function FetchCompany()
	{
		$company_sql = $this->db->query("Select * from igain_company_master where Activated=1");
		$company_result = $company_sql->result_array();
		
		if($company_sql->num_rows() > 0)
		{
			return $company_result;
		}
		else
		{
			return 0;
		}
		
	}
	
	function FetchUserType()
	{
		$UserType_sql = $this->db->query("Select * from igain_user_type_master");
		$UserType_result = $UserType_sql->result_array();		
		if($UserType_sql->num_rows() > 0)
		{
			return $UserType_result;
		}
		else
		{
			return 0;
		}
		
	}
	 
	function FetchCountry()
	{
		$Country_sql = $this->db->query("Select * from igain_country_master");
		// $Country_sql = $this->db->query("Select * from igain_country_timezone_tbl");
		$Country_result = $Country_sql->result_array();
		
		if($Country_sql->num_rows() > 0)
		{
			return $Country_result;
		}
		else
		{
			return 0;
		}
		
	}
	

	 function get_country($Company_id)
	 {
		$query = "Select Country from  igain_company_master where Company_id='".$Company_id."' ";
				
				$sql = $this->db->query($query);
				foreach ($sql->result() as $row)
				{
					$Country_id = $row->Country;
				}
		return 	$Country_id;	
	 }
	 
	 function get_dial_code($Country_id)
	 {
		// $query = "select Dial_code from igain_currency_master where Country_id='".$Country_id."'";
		$query = "select phonecode from igain_country_master where id='".$Country_id."'";

				$sql = $this->db->query($query);
				foreach ($sql->result() as $row)
				{
					$dial_code = $row->phonecode;
				}
		return 	$dial_code;	
	 }
	 
 
	function get_partner_companys($Loggin_User_id,$Company_id)
	{
		if($Loggin_User_id == 3 && $Company_id == 1)
		{
			$fetch_query = "SELECT Company_id,Company_name from  igain_company_master where Partner_company_flag=1 AND Activated=1";	
		}
		else
		{
			$fetch_query = "SELECT Company_id,Company_name from  igain_company_master where Company_id='".$Company_id."' AND Activated=1 ";	
		}
		
		$run_sql = $this->db->query($fetch_query);
		// echo $this->db->last_query();
		if($run_sql->num_rows() > 0)
		{
			return $run_sql->result_array();
		}
		else
		{
			return 0;
		}
	}	
	function get_partner_clients($CompanyID)
	{
		
		$partner_clients_query = "SELECT Company_id,Company_name from  igain_company_master where Parent_company=".$CompanyID." AND Activated=1";
			
		$sql_result = $this->db->query($partner_clients_query);
		
		// echo $this->db->last_query();
		if($sql_result->num_rows() > 0)
		{
			return $sql_result->result_array();
		}
		else
		{
			return 0;
		}
	}	
	function get_company_sellers($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance,Super_seller");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '1','Super_seller' => '0','Company_id' => $Company_id));
	  $sql = $this->db->get();
	  // echo $this->db->last_query();
	  
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
	function get_company_sellers_and_staff($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $Company_id));
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
	function Get_sub_seller_count($sellerid)
	{ 
		
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '0','Sub_seller_Enrollement_id'=>$sellerid));
		$sql = $this->db->get();
		// echo $this->db->last_query();
		return $sql->num_rows();
	}
	function Get_sub_seller($Seller_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '0','Sub_seller_Enrollement_id'=>$Seller_id));
		$sql = $this->db->get();
		// echo $this->db->last_query();
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
	function get_seller_details($Enrollement_id)
	{
		$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Super_seller,Sub_seller_admin,Sub_seller_Enrollement_id");
		$this->db->from('igain_enrollment_master');
		// $this->db->where(array('User_id' => '2','User_activated' => '1','Enrollement_id' => $Enrollement_id));
		$this->db->where(array('User_activated' => '1','Enrollement_id' => $Enrollement_id));
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
	
	function get_seller_category($seller_id,$Company_id)
	{
		$this->db->limit(1);
		$this->db->select("Item_category_id");
		$this->db->from("igain_item_category_master");
		$this->db->where(array('Seller'=> $seller_id,'Company_id' =>$Company_id));
		
		$sql_res = $this->db->get();

		if ($sql_res->num_rows() > 0)
		{
			$queryOPT = $sql_res->result_array();
			
			foreach ($queryOPT as $row)
			{
                $Item_category_id = $row['Item_category_id'];
            }
            
            return $Item_category_id;
        }
        return 0;
	}
	
	function get_transaction_referral_rule($Company_id,$seller_id,$referral_rule_for)
	{
		$this->db->select('*');
        $this->db->from('igain_seller_refrencerule');
		$this->db->where(array('Seller_id' => $seller_id, 'Company_id' => $Company_id, 'Referral_rule_for' => $referral_rule_for));

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
	
	function get_referre_details($CompanyID,$ref_cardid)
	{
		$this->db->select('Enrollement_id,Phone_no,First_name,Middle_name,Last_name,User_email_id,Current_balance');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_activated' => 1,'User_id' =>1, 'Company_id' =>$CompanyID, 'Card_id' => $ref_cardid));
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
	//************** get company loyalty rules ******************/
	 function get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id)
	{

		if($Logged_user_id == 3 || $Logged_user_id == 4)
		{
			$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date,Flat_file_flag');
			$this->db->from('igain_loyalty_master as lp');
			//$this->db->join('igain_enrollment_master as e','e.Enrollement_id = lp.Seller');
			$this->db->not_like('lp.Loyalty_name', '%ONLY REDEEM');
			//$this->db->group_by('1');
			$this->db->where(array('lp.Company_id'=>$Company_id, 'lp.Active_flag' => 1));
		}
		else
		{
			$this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date,Flat_file_flag');
			$this->db->from('igain_loyalty_master');
			$this->db->not_like('Loyalty_name', '%ONLY REDEEM');
			$this->db->group_by('1');
			$this->db->where(array('Company_id' => $Company_id,'Seller' => $Logged_user_enrollid, 'Active_flag' => 1));
		}
		
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
   /************************ Inactive User Reports ***************************/
	function get_inactive_users($limit,$start,$Company_id)
	{
		$this->db->select('User_type,Company_id,Enrollement_id,First_name,Middle_name,Last_name,name as City,Phone_no,User_email_id,(Current_balance-Blocked_points) as Current_balance,total_purchase,Total_topup_amt,Total_reddems,Card_id');
		  $this->db->from('igain_enrollment_master');
		  $this->db->join('igain_user_type_master','igain_enrollment_master.User_id = igain_user_type_master.User_id');
		  $this->db->join('igain_city_master','igain_enrollment_master.City = igain_city_master.id','LEFT');
		  $this->db->where(array('User_activated'=>'0', 'Company_id' =>$Company_id ));
		  // if($limit != NULL && $start != NULL){
			  
			  // $this->db->limit($limit,$start);
		  // }		  
		  $inactive_users = $this->db->get();	
			// echo $this->db->last_query();		  
		  if($inactive_users->num_rows() > 0)
		  {
			foreach($inactive_users->result() as $rowsd)
			{
				if($rowsd->Card_id=='0')
				{
				 $rowsd->Card_id="-";
				}
				if($rowsd->total_purchase==0)
				{
				 $rowsd->total_purchase="-";
				}
				if($rowsd->Total_topup_amt==0)
				{
				 $rowsd->Total_topup_amt="-";
				}
				if($rowsd->Total_reddems==0)
				{
				 $rowsd->Total_reddems="-";
				}
				if($rowsd->Current_balance==0)
				{
				 $rowsd->Current_balance="-";
				}
				if($rowsd->User_type=="Customer")
				{
				 $rowsd->User_type="Member";
				}

				$data[] = $rowsd;
			}
		   
		   return $data;
		  }
		  
		  return false;
	}	
	function get_inactive_users_list($Company_id)
	{
		$this->db->select('Company_id,Enrollement_id,Card_id');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_activated'=>'0', 'Company_id' =>$Company_id ));
		
		return $this->db->count_all_results();
			
	}	
	function activate_user($EnrollID,$CompID)
	{
		$this->db->where(array('Enrollement_id'=>$EnrollID,'Company_id'=>$CompID));
		$this->db->update('igain_enrollment_master', array('User_activated'=>'1'));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
			
		return false;
	}
	/************************ Inactive User Reports ***************************/
	
	function get_company_game_info($Comp_game_id,$CompID)
	{
		$this->db->select('*');
		$this->db->from('igain_game_company_master');
		$this->db->where(array('Company_game_id' =>$Comp_game_id, 'Company_id' => $CompID ));
		
		$sql31 = $this->db->get();
		
		if($sql31 -> num_rows() == 1)
		{
			return $sql31->row();
		}
		else
		{
			return false;
		}
	}
	
	function get_company_game_prizes($Comp_game_id,$CompID)
	{
		$this->db->select('*');
		$this->db->from('igain_game_company_child');
		$this->db->where(array('Company_game_id' =>$Comp_game_id, 'Company_id' => $CompID ));
		
		$sql32 = $this->db->get();

		if($sql32->num_rows()  > 0)
		{
			foreach($sql32->result() as $row32)
			{
				$data_child[] = $row32;
			}
			
			return $data_child;
		}
		else
		{
			return false;
		}
	}

	function get_hobbies_interest()
	{	
		$this->db->from('igain_hobbies_master');
        $query40 = $this->db->get();

        if ($query40->num_rows() > 0)
		{
        	foreach ($query40->result() as $row40)
			{
                $datav40[] = $row40;
            }
            return $datav40;
        }
        return false;
	}
//**************** sandeep work end ***********************************	

/********************************************Akshay start *******************************/
	function getRandomString($length = 4) 
	{
		$characters = '0123456789';
		$string = '';
		for ($i = 0; $i < $length; $i++) 
		{
			$string .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		return $string;
	}	
	function get_company_details($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_company_master');
		$this->db->where('Company_id', $Company_id);
		
		$sql50 = $this->db->get();
	
		if($sql50 -> num_rows() == 1)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}	
	//**********Get seller details or Get Customer details or user details***
	function get_enrollment_details($Enrollement_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where('Enrollement_id', $Enrollement_id);
		
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
	function get_all_customers($Company_id)
	{
		$this->db->select("*");
		$this->db->where(array('User_id' => '1','User_activated' => '1','Company_id' => $Company_id));
		$query = $this->db->get('igain_enrollment_master');
		return $query->result_array();
	}
	
	function insert_customer_notification($data)
        {
            $this->db->insert('igain_cust_notification', $data);
            $insert_id = $this->db->insert_id();
            // echo"---insert_customer_notification-2-".$this->db->last_query()."---<br>";
            if($this->db->affected_rows() > 0)
            {
                //return true;
                return $insert_id;
            }		
        }
    
        function update_customer_notification($customer_notification_id,$Company_id,$Enrollement_id,$post_data)
        {
            $this->db->where(array('Id' => $customer_notification_id, 'Company_id' => $Company_id, 'Customer_id' => $Enrollement_id));
            $this->db->update("igain_cust_notification", $post_data);	
        }
	
/********************************************Akshay end*******************************/

//******************** Ravi Work start **************************
 
	function CountTotalSeller($Company_id)
	{
		$q =  $this->db->select('COUNT(Enrollement_id)')
				   ->from('igain_enrollment_master')
				   ->where(array('User_id' =>'2','Company_id' => $Company_id))->get();
		return $q->num_rows();		
	}	
	function FetchLoginUserCompany($Company_id)
	{		
		$this->db->select('*');
		$this->db->from('igain_company_master');		
		$this->db->where('Company_id',$Company_id); 
		$company_sql= $this->db->get();
		$company_result = $company_sql->result_array();
		if($company_sql->num_rows() > 0)
		{
			return $company_result;
		}
		else
		{
			return 0;
		}
	}
	function FetchPartnerCompany()
	{		
		$this->db->select('*');
		$this->db->from('igain_company_master');		
		$this->db->where('Partner_company_flag=','1'); 
		$company_sql= $this->db->get();
		$company_result = $company_sql->result_array();
		if($company_sql->num_rows() > 0)
		{
			return $company_result;
		}
		else
		{
			return 0;
		}
	}	
	public function Selected_company_enrollment_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$post_data=$this->db->select('Enrollement_id,First_name,Last_name,Current_address,Card_id,Phone_no,Sex,User_email_id');
		$this->db->from('igain_enrollment_master');	
		$this->db->where(array('Company_id'=> $Company_id,'User_id !=' => '3','User_activated' => '1')); 
		$company_sql= $this->db->get();
		if($company_sql->num_rows() > 0)
		{
			foreach ($company_sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;
	} 
	function FetchPartnerAdmin()
	{
		$this->db->select('User_id,User_type');
		$this->db->from('igain_user_type_master');		
		$this->db->where(array('User_id ' => '4')); 
		$userType_sql= $this->db->get();
		$userType = $userType_sql->result_array();
		if($userType_sql->num_rows() > 0)
		{
			return $userType;
		}
		else
		{
			return 0;
		}
		
	}
	function FetchSellerAndCustomer()
	{
		$this->db->select('User_id,User_type');
		$this->db->from('igain_user_type_master');		
		$this->db->where(array('User_id <> '=> '4','User_id <>' => '3')); 
		$userType_sql= $this->db->get();
		$userType = $userType_sql->result_array();
		if($userType_sql->num_rows() > 0)
		{
			return $userType;
		}
		else
		{
			return 0;
		}
		
	}
	function FetchSubsellerdetails($Company_id)
	{
		// echo"-----FetchSubsellerdetails-----";
		$this->db->select('Enrollement_id,First_name,Last_name,Phone_no,User_email_id');
		$this->db->from('igain_enrollment_master');		
		$this->db->where(array('User_id  '=> '2','Company_id ' => $Company_id,'Sub_seller_admin ' => '1','User_activated ' => '1')); 
		$SubsellerSql= $this->db->get();
		
		return $SubsellerSql->result_array();
		
	}
	function Fetch_Callcenter_details($Company_id)
	{
		// echo"-----FetchSubsellerdetails-----";
		$this->db->select('Enrollement_id,First_name,Last_name,Phone_no,User_email_id');
		$this->db->from('igain_enrollment_master');		
		$this->db->where(array('User_id '=> '6','Company_id ' => $Company_id,'Sub_seller_admin ' => '1','Call_center_user ' => '1','User_activated ' => '1')); 
		$SubsellerSql= $this->db->get();		
		return $SubsellerSql->result_array();		
	}
	function FetchCustomer()
	{
		$this->db->select('User_id,User_type');
		$this->db->from('igain_user_type_master');		
		// $this->db->where(array('User_id !=' =>'3','User_id !=' => '2','User_id !=' => '4')); 
		$this->db->where('User_id =','1'); 
		$userType_sql= $this->db->get();
		$userType = $userType_sql->result_array();
		if($userType_sql->num_rows() > 0)
		{
			return $userType;
		}
		else
		{
			return 0;
		}
		
	}	
	function Fetch_Transaction_Loyalty_Details($Trans_id,$Company_id,$enrollID)
	{
		/* echo"-----Trans_id-----".$Trans_id."--<br>";
		echo"-----Company_id-----".$Company_id."--<br>";
		echo"-----enrollID-----".$enrollID."--<br>"; */
		$this->db->select('*');
		$this->db->from('igain_transaction_child');	
		$this->db->join('igain_loyalty_master', 'igain_transaction_child.Loyalty_id = igain_loyalty_master.Loyalty_id');		
		$this->db->where(array('igain_transaction_child.Transaction_id'=> $Trans_id,'igain_transaction_child.Company_id' => $Company_id,'igain_transaction_child.Seller' =>$enrollID)); 
		
		$SubsellerSql = $this->db->get();		
		//return  $this->db->last_query();
		return $SubsellerSql->result_array();		
	}
	function get_tier($Company_id)
	{
		$this->db->select('Tier_id,Tier_name');
		$this->db->from('igain_tier_master');		
		$this->db->where(array('Company_id' =>$Company_id,'Active_flag' => '1')); 
		$Tier_sql= $this->db->get();
		// echo $this->db->last_query();
		if($Tier_sql->num_rows() > 0)
		{
			return $Tier_sql->result_array();
		}
		else
		{
			return 0;
		}
		
	}	
	function get_sub_seller_admin_details($seller_id,$Company_id)
	{
		$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance");
		$this->db->from("igain_enrollment_master");
		$this->db->where(array('Company_id' =>$Company_id,'Sub_seller_Enrollement_id'=> $seller_id));
		$this->db->or_where(array('Enrollement_id'=> $seller_id));
		$sql_res = $this->db->get();
		// echo $this->db->last_query();
		if ($sql_res->num_rows() > 0)
		{
			$queryOPT = $sql_res->result_array();
			
			/* foreach ($queryOPT as $row)
			{
                $Enrollement_id = $row['Enrollement_id'];
                $First_name = $row['First_name'];
                $Last_name = $row['Last_name'];
            }
             */
            return $queryOPT;
        }
        return 0;
	}	
	function get_seller_details_12($Enrollement_id)
	{
		$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Super_seller");
		$this->db->from('igain_enrollment_master');
		//$this->db->where(array('User_id' => '2','User_activated' => '1','Enrollement_id' => $Enrollement_id));
		$this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_Enrollement_id' => $Enrollement_id));
		$sql = $this->db->get();
		
		if ($sql->num_rows() > 0)
		{
        	return $sql->result_array();
            
        }
        return false;
	}
	function get_company_sellers_12($Company_id,$seller_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '1','Super_seller' => '0','Company_id' => $Company_id));
	  $this->db->or_where(array('Sub_seller_Enrollement_id'=> $seller_id));
	  $sql = $this->db->get();
	  
			if ($sql->num_rows() > 0)
			{         
				return  $sql->result_array();
			}
			return false;
	}
	function get_sellers_12($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Super_seller' => '0','Company_id' => $Company_id));
	  $sql = $this->db->get();
	  
			if ($sql->num_rows() > 0)
			{         
				return  $sql->result_array();
			}
			return false;
	} 
	public function get_customer_pin($Company_id,$Enrollment_id)
	{
			$this->db->select('pinno');
			$this->db ->from('igain_enrollment_master');
			$this->db->where(array('Enrollement_id' => $Enrollment_id,'Company_id' => $Company_id,'User_id' => 2,'User_activated' => 1));
			$query = $this->db->get();
			// echo $this->db->last_query();
			if($query->num_rows() > 0)
			{
			  return $query->row();
			}
		
	}
	
//******************** Ravi Work end **************************

//********************************************Amit Start*******************************
	function get_transaction_type()
	{
		$this->db->select("*");
		$this->db->from('igain_transaction_type');
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
	
	function get_transaction_type_details($TransType)
	{
		$this->db->select("*");
		$this->db->from('igain_transaction_type');
		$this->db->where('Trans_type_id',$TransType);
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
	
	function get_payement_type()
	{
		$this->db->select("Payment_type_id ,Payment_type");
		$this->db->from('igain_payment_type_master');
		$this->db->order_by('Payment_type','ASC');
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
	 function Update_company_balance($Company_id,$Current_balance,$Total_Current_balance)
	{
		$data['Current_bal'] = $Total_Current_balance;
		$this->db->where("Company_id",$Company_id);
		$this->db->update("igain_company_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Update_Seller_Current_balance($Enrollement_id,$Seller_Current_balance,$Amt_transaction)
	{
		$data['Current_balance'] = ($Seller_Current_balance+$Amt_transaction);
		$this->db->where("Enrollement_id",$Enrollement_id);
		$this->db->update("igain_enrollment_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	
	/************************ Customer Reports ***************************/
	function get_customer_details_Card_id($Membership_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id,'Card_id' => $Membership_id,'User_activated' => 1));
		
		$sql51 = $this->db->get();
		
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}	
	function validate_Card_id($Input_data,$Company_id)
	{
		$Country_id = $this->get_country($Company_id);					
		$dial_code = $this->get_dial_code($Country_id);					
		$phnumber = $dial_code.$Input_data;
				
		$this->db->select('COUNT(*) as num');
		$this->db->from('igain_enrollment_master');
		$this->db->where('(Phone_no = "'.$phnumber.'" OR Card_id ="'.$Input_data.'")');
		$this->db->where(array('Company_id' => $Company_id,'User_id' => 1,'User_activated' => 1));
		
		
		$sql51 = $this->db->get();
		//echo $this->db->last_query();
		return $sql51 ->row();
		
	}
	
	
	function get_cust_trans_summary($Enrollement_id)
	{
		$this->db->select('IT.Card_id,SUM(Redeem_points) AS Total_reddems,SUM(Loyalty_pts) as Total_gained_points,SUM(Topup_amount) as Total_bonus_ponus,SUM(Purchase_amount) as Total_purchase_amt,IE.Current_balance,IE.First_name,IE.Middle_name,IE.Last_name,IE.Enrollement_id');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->group_by('IT.Enrollement_id');
		$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		
		$sql51 = $this->db->get();
		
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

	function get_cust_trans_details($Enrollement_id,$From_date,$To_date)
	{
		$this->db->select('First_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Bill_no,TT.Trans_type_id,Seller,TT.Trans_type,IT.Card_id');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		$this->db->order_by('IT.Trans_id' , 'desc');
		$sql51 = $this->db->get();
		//echo $this->db->last_query();
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

	function get_cust_trans_summary_all($Company_id)
	{
		$this->db->select('IT.Card_id,SUM(Redeem_points) AS Total_reddems,SUM(Loyalty_pts) as Total_gained_points,SUM(Topup_amount) as Total_bonus_ponus,SUM(Purchase_amount) as Total_purchase_amt,IE.Current_balance,IE.First_name,IE.Middle_name,IE.Last_name,IE.Enrollement_id');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->group_by('IT.Card_id');
		$this->db->where('IT.Company_id' , $Company_id);
		
		$sql51 = $this->db->get();
		
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
	/************************ Customer Reports ***************************/
	
	/************************ Forget PAssword ***************************/
	function Check_Old_Password($old_Password,$Company_id,$Enrollment_id)
	{
		
		$query =  $this->db->select('User_pwd')
				   ->from('igain_enrollment_master')
				   ->where(array('User_pwd' => $old_Password,'Company_id' => $Company_id,'Enrollement_id' =>$Enrollment_id))->get();
			return $query->num_rows();
	}
	function check_old_pin($old_Pin,$Company_id,$Enrollment_id)
	{
		
		$query =  $this->db->select('pinno')
				   ->from('igain_enrollment_master')
				   ->where(array('pinno' => $old_Pin,'Company_id' => $Company_id,'Enrollement_id' =>$Enrollment_id))->get();
			return $query->num_rows();
	}
	
	function Change_Old_Password($old_Password,$Company_id,$Enrollment_id,$new_Password)
	{
		
		$data1=array('User_pwd' => $new_Password );
		$this->db->where(array('Company_id' => $Company_id,'Enrollement_id' => $Enrollment_id));
		$this->db->update('igain_enrollment_master',$data1);

		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	function Change_Old_Pin($old_Pin,$Company_id,$Enrollment_id,$New_Pin)
	{
		
		$data1=array('pinno' => $New_Pin );
		$this->db->where(array('Company_id' => $Company_id,'Enrollement_id' => $Enrollment_id));
		$this->db->update('igain_enrollment_master',$data1);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	
	
	function Send_password($Email_id)
	{
		/*Email function*/
		$query =  $this->db->select('User_pwd,Enrollement_id,Company_id')
				   ->from('igain_enrollment_master')
				   ->where(array('User_email_id' => $Email_id,'User_activated' => '1','User_id !=' => '1'))->get();
		if($query -> num_rows() > 0)
		{
			 return $query->row();
		}
		else
		{
			return false;
		}
	}
	function Send_password_website($Email_id,$Company_id)
	{
		/*Email function*/
		$query =  $this->db->select('User_pwd,Enrollement_id,Company_id')
				   ->from('igain_enrollment_master')
				   ->where(array('Company_id' => $Company_id,'User_email_id' => $Email_id,'User_activated' => '1','User_id !=' => '1'))->get();
		if($query -> num_rows() > 0)
		{
			 return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	function Check_Email_Address($email_id)
	{
		
		$query =  $this->db->select('User_pwd')
				   ->from('igain_enrollment_master')
				   ->where(array('User_email_id' => $email_id,'User_activated' => '1','User_id !=' => '1'))->get();
			//echo $this->db->last_query();	   
			return $query->num_rows();
	}
	
	//********************************************Amit end*******************************
	function Fetch_Super_Seller_details($Company_id)
	{
		
		$this->db->select("*");
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
	function Get_sub_seller_list($Seller_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '0','Sub_seller_Enrollement_id'=>$Seller_id));
		$this->db->or_where('Enrollement_id',$Seller_id);
		$sql = $this->db->get();
		// echo $this->db->last_query();
		// die;
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
	function Get_segment_based_customers($lv_Cust_value,$Operator,$Value,$Value1,$Value2)
	{
		
		/* echo "---lv_Cust_value---".$lv_Cust_value."---<br><br>";
		echo "---Operator---".$Operator."---<br><br>";
		echo "---Value---".$Value."---<br><br>";
		echo "---Value1---".$Value1."---<br><br>";
		echo "---Value2---".$Value2."---<br><br>"; */
		
		
		
		
		$access=0;
		if($Operator=="<")
		{
			if($lv_Cust_value<$Value)
			{
				$access=1;
			}
			
		}
		if($Operator=="=")
		{
			if($lv_Cust_value==$Value)
			{
				$access=1;
			}
		}
		if($Operator=="<=")
		{
			if($lv_Cust_value<=$Value)
			{
				$access=1;
			}
		}
		
		
		if($Operator==">")
		{
			if($lv_Cust_value>$Value)
			{
				$access=1;
			}
		}
		if($Operator==">=")
		{
			if($lv_Cust_value>=$Value)
			{
				$access=1;
			}
		}
		if($Operator=="!=")
		{
			if($lv_Cust_value!=$Value)
			{
				$access=1;
			}
		}
		
		if($Operator=="Between")
		{
			if($lv_Cust_value>=$Value1 && $lv_Cust_value<=$Value2)
			{
				$access=1;
			}
		}
		
		
		// echo "---access---".$access."---<br><br>";
		
		return $access;
	}
	function get_partner_clients_transaction($Company_id)
	{
		
		$this->db->select("igain_company_master.Parent_company,igain_company_master.Company_id,igain_company_master.Company_name,SUM(igain_transaction.Purchase_amount) as Purchase_amount, SUM(igain_transaction.Topup_amount) as Topup_amount,SUM(Redeem_points*Quantity) as Total_Redeem_points,SUM(igain_transaction.Loyalty_pts) as Loyalty_pts,Redeem_points,Quantity,Trans_type");
		$this->db->from('igain_company_master');
		$this->db->join('igain_transaction', 'igain_company_master.Company_id = igain_transaction.Company_id','LEFT');	
		$this->db->where(array('igain_company_master.Parent_company' =>$Company_id,'igain_company_master.Activated' => '1'));
		$this->db->group_by("igain_company_master.Company_name");
		$sql_result = $this->db->get();
		// echo $this->db->last_query();
		if($sql_result->num_rows() > 0)
		{
			return $sql_result->result_array();
		}
		else
		{
			return 0;
		}
	}
	/************************Nilesh Start***************************/
	
	function get_partner_clients_transaction_miracleAdmin()
	{
		
		$this->db->select("igain_company_master.Parent_company,igain_company_master.Company_id,igain_company_master.Company_name,SUM(igain_transaction.Purchase_amount) as Purchase_amount, SUM(igain_transaction.Topup_amount) as Topup_amount,SUM(Redeem_points*Quantity) as Total_Redeem_points,SUM(igain_transaction.Loyalty_pts) as Loyalty_pts,Redeem_points,Quantity,Trans_type");
		$this->db->from('igain_company_master');
		$this->db->join('igain_transaction', 'igain_company_master.Company_id = igain_transaction.Company_id','LEFT');	
		$this->db->where(array('igain_company_master.Activated' => '1', 'igain_company_master.Partner_company_flag' =>'0'));
		$this->db->group_by("igain_company_master.Company_name");
		$this->db->order_by('igain_company_master.Parent_company' , 'asc');
		$sql_result = $this->db->get();
		// echo $this->db->last_query();
		if($sql_result->num_rows() > 0)
		{
			return $sql_result->result_array();
		}
		else
		{
			return 0;
		}
	}
	function get_total_redeem_point($Company_id)
	{
		$this->db->select('SUM(Total_reddems) as sum_reddemPoints');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' =>$Company_id, 'User_activated' => 1));
		
		$sql50 = $this->db->get();
	
		if($sql50 -> num_rows() >0 )
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	/*************************Nilesh End**************************/
	function Get_total_enrollment($Company_id)
	{
		$q =  $this->db->select('COUNT(Enrollement_id) AS Total_enrollment')
				   ->from('igain_enrollment_master')
				   ->where(array('User_id' =>'1','User_activated' =>'1','Company_id' => $Company_id))->get();
				   // echo $this->db->last_query();
		return $q->result_array();
	}
	function Get_total_outlets($Company_id)
	{
		$q =  $this->db->select('COUNT(Enrollement_id) AS Total_enrollment')
				   ->from('igain_enrollment_master')
				   ->where(array('User_id' =>'2','User_activated' =>'1','Sub_seller_admin' => '1','Super_seller' => '0','Sub_seller_Enrollement_id' => '0','Company_id' => $Company_id))->get();
				   // echo $this->db->last_query()."<br>";
		return $q->result_array();
	}
	/*************************Nilesh Change for Igain Log Table Insert************************/
	function Insert_log_table($Company_id,$enroll,$username,$LogginUserName,$lv_date_time,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Last_enroll_id)
	{
		$data['Company_id'] = $Company_id;
		$data['From_enrollid'] = $enroll;
		$data['From_emailid'] = $username;
		$data['From_userid'] = $userid;
		if($Last_enroll_id!=NULL)
		{
			$data['To_enrollid'] = $Last_enroll_id;
		}
		$data['Transaction_by'] = $LogginUserName;
		$data['Transaction_to'] =  $firstName.' '.$lastName;  
		$data['Transaction_type'] = $what;
		$data['Transaction_from'] = $where;
		$data['Operation_type'] = $opration;
		$data['Operation_value'] = $opval;
		$data['Date'] = $lv_date_time;
		$this->db->insert('igain_log_tbl', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function get_transaction_from($Company_id)   // Audit tracking Report
	{
		$this->db->select("distinct(Transaction_from)");
		$this->db->from('igain_log_tbl');
		if($Company_id !=0 )
		{
			$this->db->where('Company_id', $Company_id);
		}
		$sql = $this->db->get();
		// echo $this->db->last_query();
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
	function get_user_type($user_type)  // Audit Tracking report 
	{
		$this->db->select("*");
		$this->db->from('igain_user_type_master');
		if($user_type !=0 )
		{
			$this->db->where_in('User_id', array('1','2','5'));
		}
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
	function get_referral_rule_details($refid) // use log Table entry
	{
		$this->db->select('*');
		$this->db->from('igain_seller_refrencerule');
		$this->db->where('refid', $refid);
		
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function get_loyalty_detail($Loyalty_id) // use log Table entry
	{
		$this->db->select('*');
		$this->db->from('igain_loyalty_master');
		$this->db->where('Loyalty_id', $Loyalty_id);
		
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function get_tier_detail($selected_tier) // use log Table entry
	{
		$this->db->select('*');
		$this->db->from('igain_tier_master');
		$this->db->where('Tier_id', $selected_tier);
		
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function Get_Company_Partners_details($Company_merchandise_item_id) // use log Table entry
	{
		$this->db->select('*');
		$this->db->from(' igain_company_merchandise_catalogue');
		$this->db->where('Company_merchandise_item_id', $Company_merchandise_item_id);
		
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}	
	function Get_data_map_merchant_details($Seller_id) // use log Table entry
	{
		$this->db->select('*');
		$this->db->from('igain_data_upload_map_tbl'); 
		$this->db->where('Map_id', $Seller_id);
		
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() == 1)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function get_query_type($cmp_id)  // Call Center Report
	{
		$this->db->select("*");
		$this->db->from('igain_callcenter_querytype_master');		
		$this->db->where('Company_id', $cmp_id);
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
/**********************Nilesh Change Igain Log Table**********************/
/*************amit get code decode master 13-09-2017****************/
	public function Get_Code_decode_master($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('Company_id',$Company_id);
		$this->db->or_where('Company_id',1);
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
/*************amit get code decode master 13-09-2017*********end*******/
	/*************Ravi Get Only Seller not Staff 15-11-2017****************/
	function get_company_sellers_details($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance,Super_seller");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '1','Sub_seller_Enrollement_id' => '0','Company_id' => $Company_id));
	  $sql = $this->db->get();
	  // echo $this->db->last_query();
	  
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
		/*************Ravi Get Only Seller not Staff 15-11-2017****************/
	function get_customer_details($MembershipID,$Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		// $this->db->where('Card_id', $MembershipID,'Company_id', $Company_id);
		$this->db->where(array('Card_id' => $MembershipID,'Company_id' => $Company_id));		
		$sql = $this->db->get();
		// echo $this->db->last_query();		
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	/*************Ravi Get Only Seller not Staff 15-11-2017****************/
	/***********AMIT 17-11-2017*************************/
	 function Get_states($Country_id)
	 {
		$query = "Select * from  igain_state_master where country_id='".$Country_id."' ";
				
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
	  function Get_cities($State_id)
	 {
		$query = "Select * from  igain_city_master where state_id='".$State_id."' ";
				
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
	 function Get_Country_master($id)
	{
		
		$this->db->select('*');
		$this->db->from('igain_country_master');
		$this->db->where('id', $id);
		
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
	 /*************amit end***********************/
	 
	 /*************Nilesh Start***********************/
	function export_active_vs_inactive_member_graph($Company_id)
	{  	 
		$this->db->select('IC.Company_name,IMSG.Total_members,IMSG.Total_active_members,IMSG.Total_inactive_members');
		  
		$this->db->from('igain_member_status_graph as IMSG');
		
		$this->db->join('igain_company_master as IC','IMSG.Company_id=IC.Company_id');
		  
		$this->db->where('IMSG.Company_id' , $Company_id);
		  
		$sql51 = $this->db->get();
		  
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
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
	/***********************Nilesh End*********************************/
	/***********************Website enrollment API-Nilesh start*********************************/
	function Check_EmailID($emailId,$Company_id)
	{
		
		$query =  $this->db->select('User_email_id')
				   ->from('igain_enrollment_master')
				   ->where(array('User_email_id' => $emailId,'User_id=1','Company_id' => $Company_id))->get();
				   // echo $this->db->last_query();
			return $query->num_rows();
	}
	function CheckPhone_number($phoneNo,$Company_id)
	{
		
		$query =  $this->db->select('Phone_no')
				   ->from('igain_enrollment_master')
				   ->where(array('Phone_no' => $phoneNo ,'User_id = 1 ','Company_id' => $Company_id))->get();
			return $query->num_rows();
	}
	public function insert_enroll_details($data)
	{
		$this->db->select('Tier_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=> $data['Company_id'],'Tier_level_id' => '1'));
		
		$tier_query = $this->db->get();
		if($tier_query->num_rows() > 0)
		{
			$tier_info = $tier_query->row();
			
			$TierID = $tier_info->Tier_id;
		}
		else
		{
			$TierID = 0;
		}
		$data['Tier_id'] = $TierID;
		
		$this->db->insert('igain_enrollment_master', $data);		
		if($this->db->affected_rows() > 0)
		{
			// return true;
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
		else
		{
			return false;
		}
	}
	public function UpdateCompanyMembershipID($Card_id1,$Company_id)
	{
		$data=array('next_card_no' => $Card_id1);
		$this->db->where('Company_id',$Company_id);
		$this->db->update('igain_company_master',$data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
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
	public function update_seller_balance($Seller_id,$Total_seller_bal)
	{
		$Sellerdata20 = array(
					'Current_balance' => $Total_seller_bal
				);
		$this->db->where(array('Enrollement_id' => $Seller_id));
		$this->db->update("igain_enrollment_master", $Sellerdata20);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function Get_Merchandize_Items($limit,$start,$Company_id,$Active_flag)
	{
		$this->db->select('*,A.Create_user_id,A.Creation_date');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as B','A.Merchandize_category_id=B.Merchandize_category_id');
		$this->db->join('igain_partner_master as C','A.Partner_id=C.Partner_id');
		$this->db->where(array('A.Active_flag'=>$Active_flag,'A.Company_id'=>$Company_id));
		$this->db->limit($limit,$start);
		$this->db->order_by('Company_merchandise_item_id','desc');
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
	function Get_Partner_Branches($Partner_id,$Company_id)
	{
		$this->db->select('Branch_code,Branch_name,Address');
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
	public function Insert_Redeem_Items_at_Transaction($data)
	{
		$this->db->insert('igain_transaction',$data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	function get_dial_code11($Country_id)
	{	
		$query =  $this->db->select('*')
				   ->from('igain_country_master')
				   ->where(array('id' => $Country_id))->get();
				   if($query->num_rows() > 0)
				   {
						return $query->row();
				   }
				   else
				   {
						return false;
				   }	
	}
	/***********************website enrollment api Nilesh End*********************************/
	
	/***********************DAta Map Upload Ravi-04-05-2018--*********************************/
	function get_customer_transaction($Enrollement_id,$Card_id,$Company_id)
	{
		$this->db->select('IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Bill_no,Seller,IT.Card_id,Quantity,Quantity_balance');
		$this->db->from('igain_transaction as IT');
		// $this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		// $this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		// $this->db->where('IT.Free_item_onquantity_flag' , 0);
		$this->db->where_in('IT.Free_item_onquantity_flag', array('0','2'));
		$this->db->where('IT.Trans_type' , 2);
		$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('IT.Card_id' , $Card_id);
		$this->db->order_by('IT.Trans_id' , 'ASC');
		// $this->db->group_by('IT.Enrollement_id' , 'desc');
		$sql51 = $this->db->get();
		// echo $this->db->last_query()."<br>";
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
	function update_free_item_onquantity_flag($transid,$Total_purchase_quantity,$Company_id,$Free_item_onquantity_flag)
	{
		$this->db->where(array('Trans_id'=>$transid,'Company_id'=>$Company_id));
		$this->db->update('igain_transaction', array('Free_item_onquantity_flag'=>$Free_item_onquantity_flag,'Quantity_balance'=>$Total_purchase_quantity));
		// echo $this->db->last_query()."<br><br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
			
		return false;
	}
	function get_last_free_item_onquantity_record($Company_id,$Enrollement_id)
	{
		$this->db->select('IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Purchase_amount,Redeem_points,Paid_amount,Topup_amount,Loyalty_pts,Bill_no,Seller,IT.Card_id,Quantity,Quantity_balance');
		$this->db->from('igain_transaction as IT');
		// $this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		// $this->db->join('igain_transaction_type as TT','IT.Trans_type=TT.Trans_type_id');
		$this->db->where('IT.Free_item_onquantity_flag' , 2);
		$this->db->where('IT.Trans_type' , 2);
		$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		$this->db->where('IT.Company_id' , $Company_id);
		// $this->db->order_by('IT.Trans_id' , 'ASC');
		// $this->db->group_by('IT.Enrollement_id' , 'desc');
		$sql512 = $this->db->get();
		// echo $this->db->last_query();
		if($sql512 -> num_rows() > 0)
		{
			return $sql512->row();
			 /* foreach ($sql512->result() as $row)
			{
                $data[] = $row;
            }
			 return $data;  */
		}
		else
		{
			return false;
		}
	}
	/***********************DAta Map Upload Ravi-04-05-2018--*********************************/
	
	
	/***********************General Template Setting Ravi-22-05-2018--*********************************/
	function get_font_family($CompanyID)
	{
		
		$this->db->select('Code_decode_id,Code_decode');
		$this->db->from('igain_codedecode_master');
		$this->db->where(array('Company_id'=> $CompanyID,'Code_decode_type_id'=> 8));
		$sql_result = $this->db->get();
		// echo $this->db->last_query();
		if($sql_result->num_rows() > 0)
		{
			return $sql_result->result_array();
		}
		else
		{
			return 0;
		}
	}
	/***********************General Template Setting Ravi-22-05-2018--*********************************/
	
	function Fetch_city_state_country($Company_id,$Customer_enroll_id)
	{
		$this->db->select("*,igain_state_master.name as State_name,igain_city_master.name as City_name,igain_country_master.name as Country_name");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_activated' => '1','Company_id' => $Company_id,'Enrollement_id' => $Customer_enroll_id));
		$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id');
		
		$SubsellerSql = $this->db->get();		
		// echo"-------Fetch_city_state_country--------".$this->db->last_query()."---<br>";
		if($SubsellerSql->num_rows() == 1)
		{
			return $SubsellerSql->row();
		}
		else
		{
			return 0;
		}
	}
	
	function Company_city_state_country($Company_id)
	{
		$this->db->select("*,igain_state_master.name as State_name,igain_city_master.name as City_name,igain_country_master.name as Country_name,igain_country_master.id as Country_id");
		$this->db->from('igain_company_master');	
		$this->db->where(array('Activated' => '1','Company_id' => $Company_id));
		$this->db->join('igain_country_master', 'igain_company_master.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'igain_company_master.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'igain_company_master.City = igain_city_master.id');
		
		$SubsellerSql = $this->db->get();		
		// echo"-------Fetch_city_state_country--------".$this->db->last_query()."---<br>";
		if($SubsellerSql->num_rows() == 1)
		{
			return $SubsellerSql->row();
		}
		else
		{
			return 0;
		}
	}
	/*---------------------------------New Excel Changes Ravi--08-01-2019---------------------------------------------------------*/
	function get_inactive_users_excel($Company_id)
	{
		  $this->db->select('User_type,Company_id,Enrollement_id,First_name,Middle_name,Last_name,name as City,Phone_no,User_email_id,(Current_balance-Blocked_points) as Current_balance,total_purchase,Total_topup_amt,Total_reddems,Card_id');
		  $this->db->from('igain_enrollment_master');
		  $this->db->join('igain_user_type_master','igain_enrollment_master.User_id = igain_user_type_master.User_id');
		  $this->db->join('igain_city_master','igain_enrollment_master.City = igain_city_master.id','LEFT');
		  $this->db->where(array('User_activated'=>'0', 'Company_id' =>$Company_id ));		 
		  $inactive_users = $this->db->get();	
			// echo $this->db->last_query();		  
		  if($inactive_users->num_rows() > 0)
		  {
		   foreach($inactive_users->result() as $rowsd)
		   {
			if($rowsd->Card_id=='0')
			{
			 $rowsd->Card_id="-";
			}
			if($rowsd->total_purchase==0)
			{
			 $rowsd->total_purchase="-";
			}
			if($rowsd->Total_topup_amt==0)
			{
			 $rowsd->Total_topup_amt="-";
			}
			if($rowsd->Total_reddems==0)
			{
			 $rowsd->Total_reddems="-";
			}
			if($rowsd->Current_balance==0)
			{
			 $rowsd->Current_balance="-";
			}
			if($rowsd->User_type=="Customer")
			{
			 $rowsd->User_type="Member";
			}
			$data[] = $rowsd;
		   }
		   
		   return $data;
		  }
		  
		  return false;
	}
	/*---------------------------------New Excel Changes Ravi-08-01-2019--------------------------------------------------------*/
                    
                    
    function get_sellers_and_staff12($Company_id)
    {
      $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance,Sub_seller_Enrollement_id");
      $this->db->from('igain_enrollment_master');
      //$this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $Company_id));
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Super_seller' => '0', 'Sub_seller_admin' => '1','Company_id' => $Company_id));
      $sql = $this->db->get();
      if ($sql->num_rows() > 0)
      {
         return  $sql->result_array();
      }
      return false;
    }
	
	//****************** 23-08-2019 *************************************
	function check_decode_type($decode_type,$Decode_flag,$CompanyId)
	{
		if($Decode_flag == 1)
		{
			$this->db->select('Code_decode_type_id')
			->from('igain_codedecode_type_master')
			->where(array('Code_decode_type' => $decode_type));
			$query = $this->db->get();
		
			return $query->num_rows();
		}
		
		if($Decode_flag == 2)
		{
			$this->db->select('Code_decode_id')
			->from('igain_codedecode_master')
			->where(array('Code_decode' => $decode_type,'Company_id' => $CompanyId));
			$query = $this->db->get();
		
			return $query->num_rows();
		}
	}
	//****************** 23-08-2019 *************************************
	public function update_password($Company_id,$Enroll_id,$post_data)
	{
	  $this->db->where(array('Company_id'=>$Company_id,'Enrollement_id'=>$Enroll_id));
	  $this->db->update('igain_enrollment_master', $post_data);
		// echo $this->db->last_query(); 

	  if ($this->db->affected_rows() > 0)
	  {
	   return true;
	  }
	  else 
	  {
	   return false;
	  }
	}	
	//****************** Ravi 03-03-2020-Template variables *************************************/
		public function get_template_variables($Code_decode_type_id,$Company_id)
		{	
			// $this->db->select('*');
			// $this->db->from('igain_codedecode_master');
			// $this->db->where(array('Company_id'=>$Company_id,'Code_decode_type_id'=>$Code_decode_type_id));
			// $this->db->order_by('Code_decode_id','DESC');
			// $query = $this->db->get();
			// if($this->db->num_rows() > 0)
			// {
				// return  $query->result_array();
			// }
			// else 
			// {
			   // return false;
			// }
			
			$this->db->select("*");
			  $this->db->from('igain_codedecode_master');
			  $this->db->where(array('Code_decode_type_id' => $Code_decode_type_id,'Company_id' => $Company_id));
			  $sql = $this->db->get();
			  if ($sql->num_rows() > 0)
			  {
				 return  $sql->result_array();
			  }
			  return false;
		}
	//****************** 27-02-2020 AMIT KAMBLE **Communication Segment*************************************
	    public function Get_Hobbies_intrested_cust($Enrollement_id,$Hobbie_id)
	{
		$this->db->select('Hobbie_id');
        $this->db->from('igain_hobbies_interest');
		$this->db->where(array('Hobbie_id' => $Hobbie_id, 'Enrollement_id' => $Enrollement_id));		
		$query = $this->db->get();
		// echo $this->db->last_query();	
        return $query->num_rows();
    
	} 
	public function Segment_applicable_function($compid,$Segment_code,$Enrollement_id,$Sex,$Country_id,$District,$State,$City,$Zipcode,$total_purchase,$Date_of_birth,$joined_date,$Tier_id)
	{
		
		$Get_linked_segment_items = $this->Igain_model->Get_linked_items_segment_child($compid,$Segment_code);
		
		$Get_segments2 = $this->Segment_model->edit_segment_code($compid,$Segment_code);
		
		
		$Date_range = $this->Igain_model->Get_segment_type_values($compid,$Segment_code,15);//Date Range
		if($Date_range != NULL)
		{
			$From_date=$Date_range->Value1;
			$Till_date=$Date_range->Value2;
		}
		else
		{
			$From_date='';
			$Till_date='';
		}	
		
		$Get_outlet_id = $this->Igain_model->Get_segment_type_values($compid,$Segment_code,16);//Outlet
		if($Get_outlet_id != NULL)
		{
			$Outlet=$Get_outlet_id->Value;
		}
		else
		{
			$Outlet= '0';
		}
	
								
		unset($Applicable_array);
		unset($Item_access);
		$Applicable_array = array();
		//print_r($Applicable_array);
		$Hobbies_access = array();
		
		$Item_access = array();
		$flag=0;
		foreach($Get_segments2 as $Get_segments)
		{
			
			
			if($Get_segments->Segment_type_id==15 || $Get_segments->Segment_type_id==16)  // 	Date Range ,Outlet
			{
				continue;
			}
			if($Get_segments->Segment_type_id==1)  // 	Age 
			{
				$lv_Cust_value=date_diff(date_create($Date_of_birth), date_create('today'))->y;
			}
					
			if($Get_segments->Segment_type_id==2)//Sex
			{
				$lv_Cust_value=$Sex;
			}
			if($Get_segments->Segment_type_id==3)//Country
			{
				$lv_Country_id=$Country_id;
				
				$Country_details = $this->Administration_model->Get_Country($lv_Country_id);
				
				$lv_Cust_value = $Country_details->name;
				
				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
				{
					$Get_segments->Value=$lv_Cust_value;
				}
			}
			if($Get_segments->Segment_type_id==4)//District
			{
				$lv_Cust_value=$District;
				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
				{
					$Get_segments->Value=$lv_Cust_value;
				}
			}
			if($Get_segments->Segment_type_id==5)//State
			{
				$State_details = $this->Administration_model->Get_State($State);
				$lv_Cust_value = $State_details->name;
				
				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
				{
					$Get_segments->Value=$lv_Cust_value;
				}
			}
			if($Get_segments->Segment_type_id==6)//city
			{
				$City_details = $this->Administration_model->Get_City($City);
				
				$lv_Cust_value = $City_details->name;
				if(strcasecmp($lv_Cust_value,$Get_segments->Value)==0)
				{
					$Get_segments->Value=$lv_Cust_value;
				}
			}
			
			if($Get_segments->Segment_type_id==7)//Zipcode
			{
				$lv_Cust_value=$Zipcode;
			}
			
			if($Get_segments->Segment_type_id==8)//Cumulative Purchase Amount
			{
				$lv_Cust_value=$total_purchase;
			}
			
			if($Get_segments->Segment_type_id==9)//Cumulative Points Redeem 
			{
				$lv_Cust_value=$Total_reddems;
			}
			if($Get_segments->Segment_type_id==10)//Cumulative Points Accumulated
			{
				$start_date=$joined_date;
				$end_date=date("Y-m-d");
				$transaction_type_id=0;
				
				$Trans_Records = $this->Report_model->get_cust_trans_summary_all($compid,$Enrollement_id,$start_date,$end_date,$transaction_type_id,$Tier_id,'','');
				if($Trans_Records != NULL){
				foreach($Trans_Records as $Trans_Records){
					$lv_Cust_value=$Trans_Records->Total_Gained_Points;
				}
				}
				else
				{
					$lv_Cust_value=0;
				}
			}
			if($Get_segments->Segment_type_id==11)//Single Transaction  Amount
			{
				$start_date=$joined_date;
				$end_date=date("Y-m-d");
				$transaction_type_id=0;
				
				$Trans_Records = $this->Report_model->get_cust_trans_details($compid,$start_date,$end_date,$Enrollement_id,$transaction_type_id,$Tier_id,'','');
				if($Trans_Records != NULL){
				foreach($Trans_Records as $Trans_Records){
					$lv_Max_amt[]=$Trans_Records->Purchase_amount;
				}
				}
				else
				{
					$lv_Cust_value=0;
				}
				$lv_Cust_value=max($lv_Max_amt);
			}
			if($Get_segments->Segment_type_id==12)//Membership Tenor
			{
				$tUnixTime = time();
				list($year,$month, $day) = EXPLODE('-', $joined_date);
				$timeStamp = mktime(0, 0, 0, $month, $day, $year);
				$lv_Cust_value= ceil(abs($timeStamp - $tUnixTime) / 86400);
			}
			
			if($Get_segments->Segment_type_id==13 && $flag==0)//Item Category
			{
				
				if($Get_linked_segment_items != NULL)
				{
					foreach($Get_linked_segment_items as $row)
					{
						$count_purchase = $this->Igain_model->Check_cust_trans_segment($compid,$Enrollement_id,$row->Item_code,$row->Quantity,$From_date,$Till_date,$Outlet);
						// echo "<br>count_purchase ".$count_purchase." Enrollement_id ".$Enrollement_id;
						if($count_purchase > 0)
						{
							$Item_access[] = 1;
						}
						else{
							$Item_access[] = 0;
						}
						$flag=1;
					}
					 // echo "<br><br>Item_access:::";
					  // print_r($Item_access);
				}
				
			}
			
			
			
			if($Get_segments->Segment_type_id==14)//Hobbies
			{
				$Hobbies_applicable = $this->Igain_model->Get_Hobbies_intrested_cust($Enrollement_id,$Get_segments->Value);
				
				$Hobbies_access []= $Hobbies_applicable;
			}
			
			if($Get_segments->Segment_type_id==17)//tIER
			{
				$lv_Cust_value=$Tier_id;
			}
			
			if($Get_segments->Segment_type_id!=13 && $Get_segments->Segment_type_id!=14)//Excepts Hobbies & Item Category
			{
				$Get_segments = $this->Igain_model->Get_segment_based_customers($lv_Cust_value,$Get_segments->Operator,$Get_segments->Value,$Get_segments->Value1,$Get_segments->Value2);
				
				$Applicable_array[]=$Get_segments;
			}
			
			
			
		}
		
		if(in_array(0, $Hobbies_access, true))
		{
			$Applicable_array[]=0;
		}
		if($flag==1){
		if(in_array(1, $Item_access, true))
		{
			$Applicable_array[]=1;
		}
		else
		{
			$Applicable_array[]=0;
		}
		}
		// echo "<br>Applicable_array:";
		 // print_r($Applicable_array);
		return $Applicable_array;
    
	}
		public function Get_segment_type_values($Company_id,$SegmentCode,$Segment_type_id)
	{
		$this->db->select('Value,Value1,Value2');
		$this->db->from('igain_segment_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Segment_code' =>$SegmentCode, 'Segment_type_id' =>$Segment_type_id,'Active_flag' =>1));
        $query = $this->db->get();
		// echo $this->db->last_query();
		if($query -> num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	 function Get_linked_items_segment_child($Company_id,$Segment_Code)
	{
		$this->db->select('*');
		$this->db->from('igain_segment_item_child as A');
		// $this->db->join('igain_company_merchandise_catalogue as D','A.Item_code=D.Company_merchandize_item_code AND A.Company_id=D.Company_id');
		
		$this->db->where(array('A.Segment_Code'=>$Segment_Code,'A.Company_id'=>$Company_id));
		$this->db->order_by('A.Segment_child_id','desc');
		
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
	 function Check_cust_trans_segment($Company_id,$Enrollement_id,$Item_code,$Quantity,$From_date,$Till_date,$Outlet)
	{
		$this->db->select('Enrollement_id');
		$this->db->from('igain_transaction as A');
		
		$this->db->where(array('A.Enrollement_id'=>$Enrollement_id,'A.Company_id'=>$Company_id,'A.Item_code'=>$Item_code));
		$this->db->where("A.Quantity >= '$Quantity'");
		if($Outlet != '0' ){$this->db->where("A.Seller"  , $Outlet);}
		if($From_date != '' && $Till_date != '' ){$this->db->where("A.Trans_date BETWEEN '$From_date' AND '$Till_date' ");}
		
		$sql=$this->db->get();
		    // echo "<br><br><br>".$this->db->last_query();//die;
		
		return $sql->num_rows();
			
		
	}
	function Get_birthday_communication($Company_id)
	{
		$Todays_date = date('Y-m-d');
		$this->db->select('description');
		$this->db->from('igain_seller_communication as A');
		
		$this->db->where(array('A.Company_id'=>$Company_id,'A.activate'=>'yes','A.Birthday_flag'=>'1'));
		$this->db->where("'$Todays_date' >= A.From_date AND '$Todays_date' <= Till_date");
		
		$sql=$this->db->get();
		 // echo "<br><br>Get_birthday_communication::<br>".$this->db->last_query();//die;
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
	//****************** 27-02-2020 AMIT KAMBLE **Communication Segment*********XXXXX****************************	
	
	//*********** 02-05-2020 ********* sandeep ******
	function get_company_outlet_sellers($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_admin' => '0','Super_seller' => '0','Company_id' => $Company_id));
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
	//*********** 02-05-2020 ********* sandeep ******
}
?>
