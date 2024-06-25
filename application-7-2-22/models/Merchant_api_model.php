<?php 
   // class Stud_Model extends CI_Model 
   class Merchant_api_model extends CI_Model 
   {	
		
		/*********** Pos Transaction ************/	
		public function purchase_transaction($data)
		{
			$this->db->insert('igain_transaction', $data);		
			
			if($this->db->affected_rows() > 0)
			{
				return $this->db->insert_id();
			}
			else
			{
				return 0;
			}
		}
		/***Check Company Key***/
		public function check_company_key($companykey)
		{		
			$query =  $this->db->select('Company_key')
				  ->from('igain_company_master')
				  ->where(array('Company_key' => $companykey)) ->get();
				return $query->num_rows();
		}
		public function check_company_key_valid($Company_id,$companykey)
		{		
			$query =  $this->db->select('Company_key')
				  ->from('igain_company_master')
				  ->where(array('Company_id' => $Company_id));
				  $query = $this->db->get();
				  
				  if($query -> num_rows() == 1)
				{
					return $query->row();
				}
				else
				{
					return false;
				}
				//return $query->num_rows();
		}
	
		/***Check Merchant Key***/
		public function check_merchant_email($merchantemail,$Company_id)
		{		
			$query =  $this->db->select('User_email_id')
				  ->from('igain_enrollment_master')
				  ->where(array('User_email_id' => $merchantemail, 'Company_id' => $Company_id, 'User_id' => 2 )) ->get();
				return $query->num_rows();
		}
		public function Get_Seller($mercht_mail,$Company_id)
		{
		  $this->db->select('Enrollement_id,First_name,Last_name,Purchase_Bill_no,Seller_Redemptionratio');
		  $this->db->from('igain_enrollment_master');
		  $this->db->where(array('User_email_id' => $mercht_mail, 'Company_id' => $Company_id, 'User_id' => 2));
		  $query11 = $this->db->get();
		 
			//echo $this->db->last_query();

		 if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
		}
		/*** Update Seller Bill No***/
		public function update_billno($Seller_id,$Bill_no)
		{
			$data = array(
					'Purchase_Bill_no' => $Bill_no
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
		
		/********* Check Existing ManualBill no ***********/
		public function check_bill_no($Bill_no,$Seller_id)
		{		
			$query =  $this->db->select('Manual_billno')
				  ->from('igain_transaction')
				  ->where(array('Manual_billno' => $Bill_no, 'Seller'=> $Seller_id )) ->get();
				return $query->num_rows();
		}
		
		/******** Update Current Balance *********/
		public function update_transaction($up,$cid,$company_id)
		{
			
			//$this->db->set('point_balance'); 
			// $this->db->where(array('Card_id' => $cid));
			// $this->db->where('Card_id', $cid);
			// $this->db->update('igain_enrollment_master', $up); 
			// $this->db->where('Card_id', $cid); 
			// $where ='(Card_id = "'.$cid.'" OR Phone_no = "'.$phnumber.'")'; 
			
			$this->db->where('Card_id', $cid, 'Company_id', $company_id); 
			$this->db->update('igain_enrollment_master', $up); 
			return true;
		}
		
		/** Get Member Details Name and point Balance **/
		public function get_pos($cid,$compId,$phnumber)
		{	
			//$this->db->select('Tier_id,Enrollement_id,Card_id,First_name,Last_name,Current_balance');
			$this->db->select('Card_id,First_name,Last_name,Current_balance');
			$this->db->from('igain_enrollment_master as a');
			//$this->db->where(array('a.Card_id'=>$cid,'a.User_id' =>1, 'a.Company_id'=>$compId));
			$where = '(a.Card_id = "'.$cid.'" OR a.Phone_no = "'.$phnumber.'")';
			$this->db->where(array('Company_id' => $compId,'User_id' => '1'));
			
			$this->db->where($where);	
			
			$query14 = $this->db->get();
			
			if($query14->num_rows() > 0)
			{			
				foreach ($query14->result() as $row)
				{
					$full_name = $row->First_name.' '.$row->Last_name;
					
					$result[] = array("Error_flag" => 0, "card_id" => $row->Card_id, "Member_name" => $full_name, "Current_balance" => $row->Current_balance);
				}
				return json_encode($result);
			}
			else
			{
				return 0;
			}
		}
		function cust_details_from_card($Company_id,$Membership_id,$phnumber)
		{
			$this->db->select('a.*,b.Tier_name');
			$this->db->from('igain_enrollment_master as a');
			$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
			$where = '(a.Card_id = "'.$Membership_id.'" OR a.Phone_no = "'.$phnumber.'")';
			//$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => '1','a.Card_id' => $Membership_id,'a.User_id' =>1));		
			$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => '1','a.User_id' =>1));
			$this->db->where($where);
			$sql = $this->db->get();
		
		return $sql->result_array();
		}
		
		/** Get Loyalty Rule***/
		function get_tierbased_loyalty($Company_id,$Logged_user_id,$TierID,$Todays_date)
		{
			// $this->db->select('distinct(Loyalty_name),Loyalty_id,Till_date,From_date');
			$this->db->select('distinct(Loyalty_name)');
			$this->db->from('igain_loyalty_master');
			$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			$this->db->where(array('Company_id' => $Company_id,'Seller' => $Logged_user_id, 'Active_flag' => 1, "Tier_id IN ('0','".$TierID."') "));
			 // $this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			$query444 = $this->db->get();
			
		 // echo $this->db->last_query($query444);

			if($query444 -> num_rows() > 0)
			{
			  return $query444->result_array();
			}
			else
			{
				return false;
			}
		}
		
		public function get_loyalty_program_details($Company_id,$seller_id,$Loyalty_names,$Todays_date)
		{
		  // echo $Company_id.'----'."<br>";
			$this->db->Select("*");
			$this->db->from("igain_loyalty_master");
			$this->db->where_in('Loyalty_name',$Loyalty_names);
			$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
			$this->db->where(array('Seller' => $seller_id,'Active_flag' => 1,'Company_id' => $Company_id));
			$this->db->order_by('Loyalty_at_value');
		
			$edit_sql = $this->db->get();
       // echo $this->db->last_query($edit_sql);
	  // die;
			if($edit_sql->num_rows() > 0)
			{
				return $edit_sql->result_array();
			}
			else
			{
				return false;
			}
		}
		public function get_discount($transaction_amt,$discount)
		{
			return ($transaction_amt/100) * $discount;
		}
		public function insert_loyalty_transaction_child($child_data)
		{
			$this->db->insert('igain_transaction_child', $child_data);	
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function update_loyalty_transaction_child($Company_id,$Todays_date,$seller_id,$Customer_enroll_id,$insert_transaction_id)
		{
			$this->db->where(array('Enrollement_id' =>$Customer_enroll_id, 'Seller' =>$seller_id, 'Transaction_date'=> $Todays_date,'Company_id' => $Company_id));
			$this->db->update('igain_transaction_child',array('Transaction_id' => $insert_transaction_id));
		
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function cal_redeem_amt_contrl($How_much_point_reedem,$Seller_reedemtion_ratio,$Total_bill_amount)
		{
					$Redeem_amount = ($How_much_point_reedem/$Seller_reedemtion_ratio);//.toFixed(2);
					//$Balance_to_pay = $Total_bill_amount - $Redeem_amount;
					
					if($Redeem_amount > $Total_bill_amount)
					{
					  $EquiRedeem_Error = 4; //Equivalent Redeem Amount is More than Total Bill Amount
					  
					  $result12[] = array("Error_flag" => $EquiRedeem_Error);
					}
					else
					{
					  $EquiRedeem_Error = 5;  //No Equivalent Redeem Amount Error
					  $result12[] = array("Error_flag" => 0, "Redeem_amount" => $Redeem_amount);
					}
				
				return json_encode($result12);
		
		}
		function get_dial_code($Country_id)
		{
		$query = "select Dial_code from igain_currency_master where Country_id='".$Country_id."'";

				$sql = $this->db->query($query);
				foreach ($sql->result() as $row)
				{
					$dial_code = $row->Dial_code;
				}
		return 	$dial_code;	
		}
	}
	
?>