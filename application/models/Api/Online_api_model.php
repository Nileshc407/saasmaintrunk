<?php 
/******************Nilesh Start*****************/
   class Online_api_model extends CI_Model 
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
		public function check_company_key_valid($Company_id)
		{		
			$query =  $this->db->select('Company_username,Company_password,Company_encryptionkey')
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
			$merchantemail = App_string_encrypt($merchantemail);		
			$query =  $this->db->select('User_email_id')
				  ->from('igain_enrollment_master')
				  ->where(array('User_email_id' => $merchantemail, 'Company_id' => $Company_id, 'User_id' => 2 )) ->get();
				return $query->row();
		}
		public function Get_Seller($mercht_mail,$Company_id)
		{
		  $mercht_mail = App_string_encrypt($mercht_mail);
		  $this->db->select('*');
		  $this->db->from('igain_enrollment_master');
		  $this->db->where(array('User_email_id' => $mercht_mail, 'Company_id' => $Company_id));
		  $this->db->where('User_id IN(2,3,4,5,6)');
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
		public function Get_outlet_details($Outlet_id,$Company_id)
		{
		  // $mercht_mail = App_string_encrypt($mercht_mail);
		  $this->db->select('*');
		  $this->db->from('igain_enrollment_master');
		  $this->db->where(array('Enrollement_id' => $Outlet_id, 'Company_id' => $Company_id));
		  $this->db->where('User_id IN(2,3,4,5,6)');
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
		public function Fetch_Profile_Details($mercht_mail,$Company_id)
		{
		  $mercht_mail = App_string_encrypt($mercht_mail);
		  $this->db->select('a.*,b.name as StateName,c.name as CityName');
		  $this->db->from('igain_enrollment_master as a');
		  $this->db->join('igain_state_master as b','a.State = b.id');
		  $this->db->join('igain_city_master as c','a.City = c.id');
		  $this->db->where(array('a.User_email_id' => $mercht_mail, 'a.Company_id' => $Company_id));
		  $this->db->where('User_id IN(2,3,4,5,6)');
		  $query11 = $this->db->get();
			
			if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
		}
		public function Get_User($User_email_id,$Company_id)
		{
		  $this->db->select('*');
		  $this->db->from('igain_enrollment_master');
		  $this->db->where(array('User_email_id' => $User_email_id, 'Company_id' => $Company_id));
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
		public function Update_Purchase_Bill_no($Seller_id,$Bill_no)
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
		public function check_manual_bill_no($Bill_no,$Company_id)
		{		
			$query =  $this->db->select('Manual_billno')
				  ->from('igain_transaction')
				  ->where(array('Manual_billno' => $Bill_no, 'Company_id'=> $Company_id )) ->get();
				return $query->num_rows();
		}		
		/******** Update Current Balance *********/
		public function update_transaction($up,$cid,$company_id)
		{	
			$this->db->where('Card_id', $cid, 'Company_id', $company_id); 
			$this->db->update('igain_enrollment_master', $up); 
			return true;
		}		
		/** Get Member Details Name and point Balance **/
		public function get_pos($cid,$compId,$phnumber)
		{
			$company_details = $this->get_company_details($compId);
			$Mobile_number_as_card_id = $company_details->Use_mobile_number_as_card_id;
			$Pin_number_as_card_id = $company_details->Use_pin_number_as_card_id;
			$Pin_number_validity = $company_details->Pin_number_validity;
			$currentTime = date("Y-m-d H:i:s");
			
			$phnumber = App_string_encrypt($phnumber);
			$this->db->select('a.*,b.Tier_name');
			$this->db->from('igain_enrollment_master as a');
			$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
			//$this->db->where(array('a.Card_id'=>$cid,'a.User_id' =>1, 'a.Company_id'=>$compId));
			if($Mobile_number_as_card_id == 1)
			{
				$where = '(a.Card_id = "'.$cid.'" OR a.Phone_no = "'.$phnumber.'")';
			}
			else
			{
				$where = '(a.Card_id = "'.$cid.'")';
			}
			$this->db->where(array('a.Company_id' => $compId,'a.User_activated' => '1','a.User_id' => '1'));
			
			$this->db->where($where);	
			
			$query14 = $this->db->get();
			
			if($query14->num_rows() > 0)
			{	
				 return $query14->row();
			}
			else if($Pin_number_as_card_id == 1)
			{
				$this->db->select('a.*,b.Tier_name');
				$this->db->from('igain_enrollment_master as a');
				$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
				$where = '(a.pinno = "'.$cid.'")';
				$this->db->where(array('a.Company_id' => $compId,'a.User_activated' => '1','a.User_id' => '1'));
			
				$this->db->where($where);
				$query144 = $this->db->get();
			
				if($query144->num_rows() > 0)
				{	
					$result = $query144->row();
					$pinno_expiry_time = $result->pinno_expiry_date_time;
					$pinno_used_flag = $result->pinno_used;
					if($pinno_used_flag == 1)
					{
						$Error_flag = 3111;
						return $Error_flag;
					}
					else if($currentTime > $pinno_expiry_time)
					{
						$Error_flag = 3111;
						return $Error_flag;
						// return false;
					}
					else
					{
						return $query144->row();
					}
				}		
				else
				{
					return false;
				}				
			}
			else
			{
				return false;
			}
		}
		public function Get_Seller_Details($Company_id,$Merchant_email)
		{	
			$this->db->select('*');
			$this->db->from('igain_enrollment_master');
			//$this->db->where(array('a.Card_id'=>$cid,'a.User_id' =>1, 'a.Company_id'=>$compId));
			$this->db->where(array('Company_id' => $Company_id, 'User_email_id' => $Merchant_email));	
			$this->db->where('User_id IN(2,3,4,5,6)');
			$query14 = $this->db->get();
			
			if($query14->num_rows() == 1)
			{	
				 return $query14->row();
			}
			else
			{
				return false;
			}
		}
		function cust_details_from_card($Company_id,$Membership_id,$phnumber)
		{
			$company_details = $this->get_company_details($Company_id);
			$Mobile_number_as_card_id = $company_details->Use_mobile_number_as_card_id;
			$Pin_number_as_card_id = $company_details->Use_pin_number_as_card_id;
			$Pin_number_validity = $company_details->Pin_number_validity;
			$currentTime = date("Y-m-d H:i:s");
	
			$phnumber = App_string_encrypt($phnumber);
			$this->db->select('a.*,b.Tier_name');
			$this->db->from('igain_enrollment_master as a');
			$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
			if($Mobile_number_as_card_id == 1)
			{
				$where = '(a.Card_id = "'.$Membership_id.'" OR a.Phone_no = "'.$phnumber.'")';
			}
			else
			{
				$where = '(a.Card_id = "'.$Membership_id.'")';
			}
			//$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => '1','a.Card_id' => $Membership_id,'a.User_id' =>1));		
			$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => '1','a.User_id' =>1));
			$this->db->where($where);
			$sql = $this->db->get();
			if($sql->num_rows() > 0)
			{	
				return $sql->result_array();
			}
			else if($Pin_number_as_card_id == 1)
			{
				$this->db->select('a.*,b.Tier_name');
				$this->db->from('igain_enrollment_master as a');
				$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');
				$where = '(a.pinno = "'.$Membership_id.'")';
				$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => 1,'a.User_id' => 1));
			
				$this->db->where($where);
				$query144 = $this->db->get();
			
				if($query144->num_rows() > 0)
				{	
					$result = $query144->row();
					// $result = $query144->result_array();
					$pinno_expiry_time = $result->pinno_expiry_date_time;
					$pinno_used_flag = $result->pinno_used;
					if($pinno_used_flag == 1)
					{
						$Error_flag = 3111;
						return $Error_flag;
					}
					else if($currentTime > $pinno_expiry_time)
					{
						$Error_flag = 3111;
						return $Error_flag;
						// return false;
					}
					else
					{
						return $query144->result_array();
					}
				}		
				else
				{
					return false;
				}				
			}
			else
			{
				return false;
			}
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
		public function cal_redeem_amt_contrl($How_much_point_reedem,$Seller_reedemtion_ratio,$Total_bill_amount,$Gift_redeem_by,$Gift_reedem,$balance_to_pay,$Promo_redeem_by,$promo_reedem)
		{
			$Redeem_amount = ($How_much_point_reedem/$Seller_reedemtion_ratio); //.toFixed(2);
			
			$abc = round(1/$Seller_reedemtion_ratio);	// 18-04-2020
			
			if($How_much_point_reedem!="")
			{
				$Redeem_amount = ($How_much_point_reedem/$Seller_reedemtion_ratio);	
			}	
			//*******18-04-2020************//
			$bb = ($Redeem_amount - $Total_bill_amount);  // 18-04-2020
			$Redeem_amount2 = $Total_bill_amount - $Redeem_amount;  // 18-04-2020
			if($bb >= $abc)
			{
				$Error_flag = 2066; //Equivalent Redeem Amount is More than Total Bill Amount
				$result12 =$Error_flag;
			}
			else if($Redeem_amount2 < 0)
			{
				$Redeem_amount = $Total_bill_amount;
				$result12 = $Redeem_amount;   //Adjust 1 point here..allow to redeem 1 point extra
			}
			//*******18-04-2020************//
			else if($Redeem_amount<=$Total_bill_amount)
			{
				$result12 = $Redeem_amount; // Successfull
			}
			else if($Redeem_amount > $Total_bill_amount) 
			{
			  $Error_flag = 2066; //Equivalent Redeem Amount is More than Total Bill Amount
			 
			  $result12 =$Error_flag;
			}
		
			return $result12;
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
		function Check_compnay_by_username($API_Company_username)
		{
			$this->db->select('*');
			$this->db->from('igain_company_master');
			$this->db->where(array('Company_username' => $API_Company_username, 'Activated' => 1));		
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
		function get_giftcard_info($GiftCardNo,$Company_id,$CardId)
		{
			$this->db->from('igain_giftcard_tbl');
			$this->db->where(array('Gift_card_id' => $GiftCardNo, 'Company_id' => $Company_id, 'Card_id' => $CardId));
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{			
				foreach ($query->result() as $row)
				{
				   $result[] = array("User_name" => $row->User_name, "Email" => $row->Email, "Phone_no" => $row->Phone_no, "Card_balance" => $row->Card_balance, "Gift_card_id" => $row->Gift_card_id, "MembershipID" => $row->Card_id);
				}			
				return json_encode($result);
			}
			else
			{
				return 0;
			}
		}
		function get_giftcard_info_transctGift($GiftCardNo,$Company_id)
		{
			$this->db->from('igain_giftcard_tbl');
			$this->db->where(array('Gift_card_id' => $GiftCardNo, 'Company_id' => $Company_id));
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{			
				foreach ($query->result() as $row)
				{
				   $result[] = array("User_name" => $row->User_name, "Email" => $row->Email, "Phone_no" => $row->Phone_no, "Card_balance" => $row->Card_balance, "Gift_card_id" => $row->Gift_card_id, "MembershipID" => $row->Card_id);
				}			
				return json_encode($result);
			}
			else
			{
				return 0;
			}
		}
		/**************Website enrollment API-Nilesh start*****************/
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
			$phoneNo = App_string_encrypt($phoneNo);
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
		/**************website enrollment api Nilesh End***************/
		/**********************Prestashop New Fun*********************/
		function cust_details_from_email($Company_id,$Customer_email)
		{
			$this->db->select('a.*,b.Tier_name');
			$this->db->from('igain_enrollment_master as a');
			$this->db->join('igain_tier_master as b','a.Tier_id = b.Tier_id');		
			$this->db->where(array('a.Company_id' => $Company_id,'a.User_activated' => '1','a.User_email_id' =>$Customer_email));
			$sql = $this->db->get();
			return $sql->result_array();
		}
		
		function FetchTransactionDetails($Company_id,$Enrollement_id,$Card_id)
		{
			$this->db->select("*");
			
			$this->db->where(array('Card_id' => $Card_id,'Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id));	
			$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
			$this->db->where('igain_transaction.Trans_type IN(1,2)');
			$this->db->order_by('igain_transaction.Trans_id', 'DESC');
			// $this->db->limit('1');
			$query = $this->db->get('igain_transaction');
			return $query->result_array();
		}
		public function Cal_PointValuation($How_much_point_reedem,$Seller_reedemtion_ratio,$Total_bill_amount)
		{
					$Redeem_amount = ($How_much_point_reedem/$Seller_reedemtion_ratio);//.toFixed(2);
					//$Balance_to_pay = $Total_bill_amount - $Redeem_amount;
					
					if($Redeem_amount > $Total_bill_amount)
					{
					  $EquiRedeem_Error = 2066; //Equivalent Redeem Amount is More than Total Bill Amount
					  
					  // $result12[] = array("Error_flag" => $EquiRedeem_Error);
					  $result12 = $EquiRedeem_Error;
					}
					else
					{
					  $EquiRedeem_Error = 1001;  //No Equivalent Redeem Amount Error
					  // $result12[] = array("Error_flag" => 0, "Redeem_amount" => $Redeem_amount);
					  $result12 = $Redeem_amount;
					}	
				return json_encode($result12);
		}
		/**********************Prestashop New Fun**********************/
		function fastenroll($Customer_topup,$ref_Customer_enroll_id,$Company_id,$card_decsion,$Logged_user_enrollid,$Country_id,$State,$City,$Card_id,$timezone_entry)
		{
			$this->load->model('igain_model');		
			$joinat = date('Y-m-d');
			
			$email_flag = $this->input->post('email_validity');
			
			if($email_flag == 1)
			{ 
				$email_id = $this->input->post('userEmailId');
			}
			else if($email_flag == 0)
			{ 
				$email_id = $this->input->post('userEmailId2');
			}
			else
			{ 
				$email_id = $this->input->post('userEmailId');
			}
			
			$User_pwd = $this->input->post('phno');
			
			$Dial_code_sql =  $this->db->select('phonecode')
							  ->from('igain_country_master')
							  ->where('id',$Country_id);
			$phonecode = $this->db->get()->row()->phonecode;
			
			
			$Phone_no = $phonecode."".$this->input->post('phno');
			
			$this->db->select('Tier_id');
			$this->db->from('igain_tier_master');
			$this->db->where(array('Company_id'=> $Company_id,'Tier_level_id' => '1'));
			
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
			
			$pinno = $this->igain_model->getRandomString();
			
			$data['First_name'] = $this->input->post('fname');
			$data['Last_name'] = $this->input->post('lname');        
			$data['Phone_no'] = App_string_encrypt($Phone_no);
			$data['User_email_id'] = App_string_encrypt($email_id);
			$data['User_pwd'] = $User_pwd;
			$data['User_activated'] = '1';
			$data['Company_id'] = $Company_id;
			$data['User_id'] = '1';
			$data['Card_id'] = $Card_id;
			$data['timezone_entry'] = $timezone_entry;
			$data['Country_id'] = $Country_id;
			$data['Country'] = $Country_id;
			$data['State'] = $State;
			$data['City'] = $City;
			$data['pinno'] = $pinno;
			
			$data['joined_date'] = $joinat;
			$data['Create_user_id'] = $Logged_user_enrollid;
			
			
			if($ref_Customer_enroll_id != NULL || $ref_Customer_enroll_id != "" || $ref_Customer_enroll_id != 0)
			{
				$data['Refrence'] = $ref_Customer_enroll_id;
			}
			else
			{
				$data['Refrence'] = 0;
			}
			
			if($Card_id != "")
			{
				$data['Total_topup_amt'] = $Customer_topup;
				$data['Current_balance'] = $Customer_topup;
			}
			
			if($Card_id != "")
			{
				$data['Card_id'] = $Card_id;
			}
			else
			{
				$data['Card_id'] ='0';
			}
			$card_decsion = $card_decsion;		
			if($card_decsion =='1')
			{		
				$Card_id++;
					
				$UpdateCardID = $this->UpdateCompanyMembershipID($Card_id,$Company_id);			
			}
			
			$this->db->insert('igain_enrollment_master', $data);
			
			$enrollID = $this->db->insert_id();
			$hobbies = $this->input->post('hobbies');
			
			if($hobbies != "")
			{
				foreach($hobbies as $hobbi)
				{
					$hb_data = array(
					'Company_id' => $Company_id,
					'Enrollement_id' => $enrollID,
					'Hobbie_id' => $hobbi
					);
					
					$this->db->insert('igain_hobbies_interest',$hb_data);
				}
			}
			if($this->db->affected_rows() > 0)
			{
				return $enrollID;
			}
			else
			{
				return 0;
			}
		}
		public function Cust_redeem_request_insert($data)
		{
			$this->db->insert('igain_cust_redeem_request', $data);		
			
			if($this->db->affected_rows() > 0)
			{
				return $this->db->insert_id();
			}
			else
			{
				return 0;
			}
		}
		public function update_cust_old_redeem_request($data1,$Enrollement_id,$Company_id,$Seller_id,$ChannelCompanyId)
		{
			// $this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Seller_id' => $Seller_id, 'Confirmation_flag' => 1)); 
			$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Seller_id' => $Seller_id,'Channel_id' => $ChannelCompanyId)); 
			$this->db->update('igain_cust_redeem_request', $data1); 
			return true;
		}
		public function Approved_cust_redeem_request($data,$Enrollement_id,$Company_id,$Seller_id,$Confirmation_code)
		{	
			$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Seller_id' => $Seller_id, 'Confirmation_code' => $Confirmation_code)); 
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
		public function Get_cust_approved_request($Enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no,$ChannelCompanyId)
		{	
			$approved = 1;			
			$Decline = 3;
			
			$this->db->select('*');
			$this->db->from('igain_cust_redeem_request');
			$where = '(Confirmation_flag = "'.$approved.'" OR Confirmation_flag = "'.$Decline.'")';
			$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Seller_id' => $Seller_id, 'Redeem_points' => $Redeem_points,'Pos_bill_no' => $Pos_bill_no,'Channel_id' => $ChannelCompanyId));
			// $this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Seller_id' => $Seller_id, 'Redeem_points' => $Redeem_points,'Pos_bill_no' => $Pos_bill_no,'Confirmation_flag' => '1'));
			$this->db->where($where);
			$query14 = $this->db->get();
			
			if($query14->num_rows() > 0)
			{	
				 return $query14->row();
			}
			else
			{
				return false;
			}
		}
		public function Check_redeem_request_issent($Enrollement_id,$Company_id,$Seller_id,$Redeem_points,$Pos_bill_no,$ChannelCompanyId)
		{
			$not_approved = 0;
			$approved = 1;			
			$Decline = 3;			
			$this->db->select('*');
			$this->db->from('igain_cust_redeem_request');
			$where = '(Confirmation_flag = "'.$not_approved.'" OR Confirmation_flag = "'.$approved.'" OR Confirmation_flag = "'.$Decline.'")';
			$this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id, 'Seller_id' => $Seller_id, 'Redeem_points' => $Redeem_points, 'Pos_bill_no' => $Pos_bill_no, 'Channel_id' => $ChannelCompanyId));
			$this->db->where($where);	
			
			$query14 = $this->db->get();
			
			if($query14->num_rows() > 0)
			{	
				 return $query14->row();
			}
			else
			{
				return false;
			}
		}
		function Get_order_evouchers_details($Order_no,$Manual_bill_no,$CompanyId,$Card_id,$Pos_outlet_id,$Pos_bill_date_time)
		{ 
			$start_date=date("Y-m-d 00:00:00", strtotime($Pos_bill_date_time)); 
			$end_date=date("Y-m-d 23:59:59", strtotime($Pos_bill_date_time));
			
			$this->db->select('Trans_id,B.Card_id,Bill_no,Manual_billno,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,CD.Code_decode,Voucher_status,B.Redeem_points,B.Purchase_amount,B.Shipping_cost,B.Loyalty_pts,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,CONCAT(First_name," ",Last_name) as Full_name,pinno,B.remark2 as Condiments_name,B.Delivery_method as Order_type');
						
			$this->db->from('igain_transaction as B');
			$this->db->join('igain_company_merchandise_catalogue as C','B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id AND C.Active_flag = 1');
			// $this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id');
			$this->db->join('igain_enrollment_master as E','B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id');
			$this->db->join('igain_codedecode_master as CD','B.Voucher_status=CD.Code_decode_id');
			// $this->db->where('(B.Card_id="'.$MembershipID.'" OR E.Phone_no="'.$phnumber.'")');
			$this->db->where('(B.Bill_no="'.$Order_no.'" OR B.Manual_billno="'.$Manual_bill_no.'")');
			$this->db->where(array('B.Card_id' => $Card_id,'B.Company_id'=>$CompanyId,'B.Trans_type'=>12,'B.Seller' =>$Pos_outlet_id));
			$this->db->where("B.Voucher_status IN('18','19','111')"); // Order,Out for delivery,Accepted
			$this->db->where('B.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->order_by('Trans_date','desc');
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
		function Get_online_order_details($Order_no,$Manual_bill_no,$Company_id,$Card_id,$Outlet_no,$Pos_bill_date_time)
		{ 
			$start_date=date("Y-m-d 00:00:00", strtotime($Pos_bill_date_time)); 
			$end_date=date("Y-m-d 23:59:59", strtotime($Pos_bill_date_time));
			
			$this->db->select('T.Bill_no,T.Manual_billno,T.Card_id,T.Enrollement_id,T.Delivery_method,T.Voucher_status,T.Table_no,T.Seller,T.Seller_name,T.Trans_date');
			$this->db->from('igain_transaction as T');
			$this->db->join('igain_enrollment_master as E','T.Enrollement_id=E.Enrollement_id AND T.Company_id=E.Company_id AND T.Card_id=E.Card_id');
			$this->db->where('(T.Bill_no="'.$Order_no.'" OR T.Manual_billno="'.$Manual_bill_no.'")');
			$this->db->where(array('T.Card_id' => $Card_id,'T.Company_id'=>$Company_id,'T.Trans_type'=>12,'T.Seller'=>$Outlet_no));
			$this->db->where('T.Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->where("T.Voucher_status IN('18','111')"); // Order,Accepted
			$this->db->group_by("T.Bill_no");
			$sql1=$this->db->get();
			// echo $this->db->last_query();
			if($sql1->num_rows()>0)
			{
				return $sql1->row();
			}
			else
			{
				return false;
			}
		}
		function Update_Order_Status($data,$Membership_id,$Company_id,$Order_no,$Manual_bill_no,$Pos_outlet_id,$Pos_bill_date_time)
		{
			$start_date=date("Y-m-d 00:00:00", strtotime($Pos_bill_date_time)); 
			$end_date=date("Y-m-d 23:59:59", strtotime($Pos_bill_date_time));	
			
			// $this->db->where(array('Company_id' => $Company_id, 'Card_id' => $Membership_id, 'Bill_no' => $Order_no, 'Trans_type' => 12));
			$this->db->where(array('Company_id' => $Company_id, 'Card_id' => $Membership_id, 'Trans_type' => 12,'Seller'=>$Pos_outlet_id));
			$this->db->where('(Bill_no="'.$Order_no.'" OR Manual_billno="'.$Manual_bill_no.'")');
			$this->db->where('Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$this->db->update("igain_transaction",$data);
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		function Get_Shipping_partner($Company_id) 
		{
			$this->db->select('*');
			$this->db->from('igain_partner_master');
			$this->db->where(array('Partner_type' => 4, 'Company_id' => $Company_id));
			$sql = $this->db->get();

			if ($sql->num_rows() > 0) 
			{
				return $sql->result_array();
			}
			else 
			{
				return 0;
			}
		}
		/***************************nilesh start new development discount 14-02-2020******************************/
		//***************** discount calculation 27-01-2020 *************************
		function check_gift_card_id($gift_cardid,$Company_id)
		{
			$query =  $this->db->select('id')
					   ->from('igain_giftcard_tbl')
					   ->where(array('Gift_card_id' => $gift_cardid, 'Company_id' => $Company_id))->get();
					   
			return $query->num_rows();
		}
		
		function get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal,$API_flag_call)
		{
			$channel = 2;
			$today = date("Y-m-d");
			$discountAmt = 0;
			$discountVoucherAmt = 0;
			$discount_Amt = 0;

			$this->db->Select("A.*,B.Item_code,B.Discount_percentage_or_value");			
			$this->db->from('igain_new_discount_rule_master as A');
			$this->db->join('igain_new_discount_rule_child as B','A.Discount_code = B.Discount_code','LEFT');
			$this->db->where(array('A.Company_id' => $Company_id,'A.Active_flag' => 1));
			$this->db->where('"'.$today.'" BETWEEN Valid_from AND Valid_till');
			

			$sql = $this->db->get();
			//echo $this->db->last_query();

			if ($sql->num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$step = 0;
					$discount_Percentage = 0;
					/* echo "Discount_id--".$row->Discount_id. PHP_EOL;
					echo "Item_code--".$row->Item_code. PHP_EOL;
					echo "Seller_id--".$row->Seller_id. PHP_EOL;
					echo "Discount_rule_for--".$row->Discount_rule_for. PHP_EOL;
					echo "Criteria_value--".$row->Criteria_value. PHP_EOL;
					echo "Discount_percentage_or_value--".$row->Discount_percentage_or_value. PHP_EOL;
					echo "Category_id--".$row->Category_id. PHP_EOL;
					echo "Discount_rule_set--".$row->Discount_rule_set. PHP_EOL; */
					//echo "--row Tier_id--".$row->Tier_id;
					
					//echo "--member tier id".$Tier_id."<br>";
					

					$validTill = date("Y-m-d",strtotime($row->Valid_till));
					
				//	echo "-- Till Valid_till--".$validTill;
					
					if(in_array($row->Tier_id,array(0,$Tier_id)))
					{
						$step++;	
				//		echo " tier id".$Tier_id."<br>";
					}

					if(in_array($row->Seller_id,array(0,$delivery_outlet)))
					{
						$step++;
				//		echo "in seller ".$step."<br>";
					}
					
					if($row->Discount_rule_for == 4 && $step == 2 && $grandTotal > 0 && $channel > 0 && $channel == $row->Channel_id) // on transaction channel
					{
					
						if($row->Discount_rule_set == 2)
						{
							
							$discount_Amt = (int)$row->Discount_Percentage_Value;
							
				//************** sandeep 7-1-2020 ***************
							if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
							{
								$discount_Amt = $row->Maximum_limit;
							}
				//************** sandeep 7-1-2020 ***************
						}
						
						if($row->Discount_rule_set == 1) // in %
						{
					
				//************** sandeep 7-1-2020 ***************
							if($row->Discount_voucher_applicable == 0 )
							{
								$discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
							}
							
							if($row->Discount_voucher_applicable == 1 ) // send voucher
							{
								$discount_Percentage = (int)$row->Discount_Percentage_Value;
							}
							
							if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
							{
								$discount_Amt = $row->Maximum_limit;
							}
				//************** sandeep 7-1-2020 ***************
						}
					
						$step++;
						
					}
					
					if($row->Discount_rule_for == 1 && $step == 2 && $grandTotal > 0) // on billing amt
					{
					//	echo "Operator--".$row->Operator. PHP_EOL;
						//if($Item_price eval("$row->Operator;") $row->Criteria_value)
						$opretorFlag = operator_validation($row->Operator,$row->Criteria_value,$grandTotal);
					//	echo "in opretorFlag ".$opretorFlag."<br>";
						
						if( $opretorFlag > 0)
						{
							if($row->Discount_rule_set == 2)
							{
								$discount_Amt = (int)$row->Discount_Percentage_Value;
								
								//************** sandeep 7-1-2020 ***************
									if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
									{
										$discount_Amt = $row->Maximum_limit;
									}
								//************** sandeep 7-1-2020 ***************
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								// $discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
								//************** sandeep 7-1-2020 ***************
								if($row->Discount_voucher_applicable == 0 )
								{
									$discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
								}
								
								if($row->Discount_voucher_applicable == 1 ) // send voucher
								{
									$discount_Percentage = (int)$row->Discount_Percentage_Value;
								}
								
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
								//************** sandeep 7-1-2020 ***************
							}
						}
						$step++;
						// echo "in billing ".$step."<br>";
						// echo "--grandTotal--".$grandTotal;
					}
					
					if($row->Discount_rule_for == 3 && $step == 2 && $grandTotal == 0) // item level
					{
					//	echo "in Item_price ".$Item_price."<br>";
						
						if($row->Item_code == $ItemCode)
						{
							if($row->Discount_rule_set == 2)
							{
								/********Ravi-11-04-2020*********
									$DiscountRuleSet=$row->Discount_rule_set;
									$DiscountPercentageValue=$row->Discount_percentage_or_value;
								/********Ravi-11-04-2020*********/
								$discount_Amt = (int)$row->Discount_percentage_or_value;
					//************** sandeep 7-1-2020 ***************
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
					//************** sandeep 7-1-2020 ***************
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								/********Ravi-11-04-2020*********
									$DiscountRuleSet=$row->Discount_rule_set;
									$DiscountPercentageValue=$row->Discount_percentage_or_value;
								/********Ravi-11-04-2020*********/
								//$discount_Amt = ($row->Discount_percentage_or_value*$Item_price)/100;
								//echo "in ItemCode ".$ItemCode."<br>";
								//echo "in ItemCode discount_Amt--".$discount_Amt."<br>";
					//************** sandeep 7-1-2020 ***************
								if($row->Discount_voucher_applicable == 0 )
								{
									$discount_Amt = (int)($row->Discount_Percentage_Value*$Item_price)/100;
								}
								
								if($row->Discount_voucher_applicable == 1 ) // send voucher
								{
									$discount_Percentage = (int)$row->Discount_Percentage_Value;
								}
								
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
					//************** sandeep 7-1-2020 ***************
							}
						}
						$step++;
				//		echo "in item level ".$step."<br>";
					}
					
					/*if($row->Discount_rule_for == 2 && $step == 2 && $grandTotal == 0) // category level
					{
				//		echo "item category--".$Itemcategory_id."--";
						if($row->Category_id == $Itemcategory_id)
						{
							if($row->Discount_rule_set == 2)
							{
								$discount_Amt = (int)$row->Discount_Percentage_Value;
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								$discount_Amt = (int)($row->Discount_Percentage_Value*$Item_price)/100;
							}
						}
						$step++;
				//		echo "in category ".$step."<br>";
					}
					
					if($row->Discount_rule_for == 3 && $step == 2 && $grandTotal == 0) // item level
					{
					//	echo "in Item_price ".$Item_price."<br>";
						
						if($row->Item_code == $ItemCode)
						{
							if($row->Discount_rule_set == 2)
							{
								$discount_Amt = (int)$row->Discount_percentage_or_value;
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								$discount_Amt = ($row->Discount_percentage_or_value*$Item_price)/100;
								//echo "in ItemCode ".$ItemCode."<br>";
								//echo "in ItemCode discount_Amt--".$discount_Amt."<br>";
							}
						}
						$step++;
				//		echo "in item level ".$step."<br>";
					} */
					
			//		echo "for Discount_id  ".$row->Discount_id."for ItemCode  ".$ItemCode."--in discount_Amt  ".$discount_Amt."--<br>";
					
					if($row->Discount_voucher_applicable == 0 )
					{

						$discountAmt = $discountAmt + floor($discount_Amt);
						
						if($discount_Amt > 0)
						{
							//if($API_flag_call == 87) // calculate discount first api call
							//{
								$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_amt"=>number_format(floor($discount_Amt),2));
								
								$discountsArray2[] = array("Discount_code"=>$row->Discount_code,"Discount_amt"=>number_format(floor($discount_Amt),2));
							//}
						}
					}
					
					if($row->Discount_voucher_applicable == 1 ) // send voucher
					{
						$gift_cardid = $this->getGiftCard($Company_id);
						
						// $discountVoucherAmt = $discountVoucherAmt + $discount_Amt;
						
						$discountVoucherAmt = $discountVoucherAmt + floor($discount_Amt);
						
						if($discount_Amt > 0 || $discount_Percentage > 0)
						{
							if($API_flag_call == 90) //Pos Trans fourth api call
							{
								// $discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_validity"=>$validTill);
								
								$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);
							}
						}
					}

					$discount_Amt = 0;  
				}
			
			}
				//	echo "--validTillalid_till--".$validTill;
				/* echo "in total voucherAmt  ".$discountVoucherAmt."--<br>";
				echo "in total DiscountAmt  ".$discountAmt."--<br>"; */
			 
				// return	json_encode(array("DiscountAmt"=>number_format(floor($discountAmt),2),"discountsArray"=>$discountsArray));
				
				return	json_encode(array("DiscountAmt"=>number_format(floor($discountAmt),2),"discountsArray"=>$discountsArray,"discountsArray2"=>$discountsArray2));
				
				//"voucherAmt"=>number_format(floor($discountVoucherAmt),2),
		}
		function get_3rd_party_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal,$API_flag_call)
		{
			$channel = 29;  // 3rd party order
			$today = date("Y-m-d");
			$discountAmt = 0;
			$discountVoucherAmt = 0;
			$discount_Amt = 0;

			$this->db->Select("A.*,B.Item_code,B.Discount_percentage_or_value");			
			$this->db->from('igain_new_discount_rule_master as A');
			$this->db->join('igain_new_discount_rule_child as B','A.Discount_code = B.Discount_code','LEFT');
			$this->db->where(array('A.Company_id' => $Company_id,'A.Active_flag' => 1));
			$this->db->where('"'.$today.'" BETWEEN Valid_from AND Valid_till');
			

			$sql = $this->db->get();
			//echo $this->db->last_query();

			if ($sql->num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$step = 0;
					$discount_Percentage = 0;
					
					$validTill = date("Y-m-d",strtotime($row->Valid_till));
					
				//	echo "-- Till Valid_till--".$validTill;
					
					if(in_array($row->Tier_id,array(0,$Tier_id)))
					{
						$step++;	
				//		echo " tier id".$Tier_id."<br>";
					}

					if(in_array($row->Seller_id,array(0,$delivery_outlet)))
					{
						$step++;
				//		echo "in seller ".$step."<br>";
					}
					
					if($row->Discount_rule_for == 4 && $step == 2 && $grandTotal > 0 && $channel > 0 && $channel == $row->Channel_id) // on transaction channel
					{
						if($row->Discount_rule_set == 2)
						{
							
							$discount_Amt = (int)$row->Discount_Percentage_Value;
							
						//************** sandeep 7-1-2020 ***************
							if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
							{
								$discount_Amt = $row->Maximum_limit;
							}
						//************** sandeep 7-1-2020 ***************
						}
						
						if($row->Discount_rule_set == 1) // in %
						{
					
						//************** sandeep 7-1-2020 ***************
							if($row->Discount_voucher_applicable == 0 )
							{
								$discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
							}
							
							if($row->Discount_voucher_applicable == 1 ) // send voucher
							{
								$discount_Percentage = (int)$row->Discount_Percentage_Value;
							}
							
							if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
							{
								$discount_Amt = $row->Maximum_limit;
							}
						//************** sandeep 7-1-2020 ***************
						}
					
						$step++;
						
					}
					
					if($row->Discount_rule_for == 1 && $step == 2 && $grandTotal > 0) // on billing amt
					{
					//	echo "Operator--".$row->Operator. PHP_EOL;
						//if($Item_price eval("$row->Operator;") $row->Criteria_value)
						$opretorFlag = operator_validation($row->Operator,$row->Criteria_value,$grandTotal);
					//	echo "in opretorFlag ".$opretorFlag."<br>";
						
						if( $opretorFlag > 0)
						{
							if($row->Discount_rule_set == 2)
							{
								$discount_Amt = (int)$row->Discount_Percentage_Value;
								
								//************** sandeep 7-1-2020 ***************
									if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
									{
										$discount_Amt = $row->Maximum_limit;
									}
								//************** sandeep 7-1-2020 ***************
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								// $discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
								//************** sandeep 7-1-2020 ***************
								if($row->Discount_voucher_applicable == 0 )
								{
									$discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
								}
								
								if($row->Discount_voucher_applicable == 1 ) // send voucher
								{
									$discount_Percentage = (int)$row->Discount_Percentage_Value;
								}
								
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
								//************** sandeep 7-1-2020 ***************
							}
						}
						$step++;
						// echo "in billing ".$step."<br>";
						// echo "--grandTotal--".$grandTotal;
					}
					
					if($row->Discount_rule_for == 3 && $step == 2 && $grandTotal == 0) // item level
					{
					//	echo "in Item_price ".$Item_price."<br>";
						
						if($row->Item_code == $ItemCode)
						{
							if($row->Discount_rule_set == 2)
							{
								$discount_Amt = (int)$row->Discount_percentage_or_value;
							//************** sandeep 7-1-2020 ***************
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
							//************** sandeep 7-1-2020 ***************
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								if($row->Discount_voucher_applicable == 0 )
								{
									$discount_Amt = (int)($row->Discount_Percentage_Value*$Item_price)/100;
								}
								
								if($row->Discount_voucher_applicable == 1 ) // send voucher
								{
									$discount_Percentage = (int)$row->Discount_Percentage_Value;
								}
								
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
					//************** sandeep 7-1-2020 ***************
							}
						}
						$step++;
				//		echo "in item level ".$step."<br>";
					}
					
					if($row->Discount_voucher_applicable == 0 )
					{
						$discountAmt = $discountAmt + floor($discount_Amt);
						
						if($discount_Amt > 0)
						{	
							$discountsArray[] = array("Discount_Code"=>$row->Discount_code,"Discount_Amt"=>number_format(floor($discount_Amt),2));
								
							$discountsArray2[] = array("Discount_Code"=>$row->Discount_code,"Discount_Amt"=>number_format(floor($discount_Amt),2));
						}
					}
					
					if($row->Discount_voucher_applicable == 1 ) // send voucher
					{
						$gift_cardid = $this->getGiftCard($Company_id);
						
						// $discountVoucherAmt = $discountVoucherAmt + $discount_Amt;
						
						$discountVoucherAmt = $discountVoucherAmt + floor($discount_Amt);
						
						if($discount_Amt > 0 || $discount_Percentage > 0)
						{
							if($API_flag_call == 94) //3rd party order
							{
								$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);
							}
						}
					}

					$discount_Amt = 0;  
				}
			}
			
			return	json_encode(array("DiscountAmt"=>number_format(floor($discountAmt),2),"discountsArray"=>$discountsArray,"discountsArray2"=>$discountsArray2));
				
			//"voucherAmt"=>number_format(floor($discountVoucherAmt),2),
		}
		function get_category_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal,$channel,$API_flag_call)
		{
			// echo $Itemcategory_id."--".$ItemCode."--".$Item_price."--".$Company_id."--".$delivery_outlet."--".$cust_enroll."--".$Tier_id."--<br>";
			$today = date("Y-m-d");
			$discountAmt = 0;
			$discountVoucherAmt = 0;
			$discount_Amt = 0;
			
			$DiscountPercentageValue=0;
			$DiscountRuleSet=0;

			$this->db->Select("A.*,B.Item_code,B.Discount_percentage_or_value");			
			$this->db->from('igain_new_discount_rule_master as A');
			$this->db->join('igain_new_discount_rule_child as B','A.Discount_code = B.Discount_code','LEFT');
			$this->db->where(array('A.Company_id' => $Company_id,'A.Active_flag' => 1,'A.Discount_rule_for' => 2));
			$this->db->where('"'.$today.'" BETWEEN Valid_from AND Valid_till');
			

			$sql = $this->db->get();
			//echo $this->db->last_query();

			if ($sql->num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$step = 0;
					$discount_Percentage = 0;
					
					$validTill = date("Y-m-d",strtotime($row->Valid_till));
					
				//	echo "-- Till Valid_till--".$validTill;
					
					if(in_array($row->Tier_id,array(0,$Tier_id)))
					{
						$step++;	
				//		echo " tier id".$Tier_id."<br>";
					}

					if(in_array($row->Seller_id,array(0,$delivery_outlet)))
					{
						$step++;
				//		echo "in seller ".$step."<br>";
					}
					
					if($row->Discount_rule_for == 2 && $step == 2 && $grandTotal == 0) // category level
					{
				//		echo "item category--".$Itemcategory_id."--";
						if($row->Category_id == $Itemcategory_id)
						{
							if($row->Discount_rule_set == 2)
							{
								/********Ravi-11-04-2020*********
									$DiscountRuleSet=$row->Discount_rule_set;
									$DiscountPercentageValue=$row->Discount_Percentage_Value;
								/********Ravi-11-04-2020*********/
								
								$discount_Amt = (int)$row->Discount_Percentage_Value;
								
					//************** sandeep 7-1-2020 ***************
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
					//************** sandeep 7-1-2020 ***************
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
								/********Ravi-11-04-2020*********
									$DiscountRuleSet=$row->Discount_rule_set;
									$DiscountPercentageValue=$row->Discount_Percentage_Value;
								/********Ravi-11-04-2020*********/

					//************** sandeep 7-1-2020 ***************
					
								if($row->Discount_voucher_applicable == 0 )
								{
									$discount_Amt = (int)($row->Discount_Percentage_Value*$Item_price)/100;
								}
								
								if($row->Discount_voucher_applicable == 1 ) // send voucher
								{
									$discount_Percentage = (int)$row->Discount_Percentage_Value;
								}
								
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
					//************** sandeep 7-1-2020 ***************
							}
						}
						$step++;
				//		echo "in category ".$step."<br>";
					}
					
					
			//		echo "for Discount_id  ".$row->Discount_id."for ItemCode  ".$ItemCode."--in discount_Amt  ".$discount_Amt."--<br>";
					
					if($row->Discount_voucher_applicable == 0 )
					{

						$discountAmt = $discountAmt + floor($discount_Amt);
						
						if($discount_Amt > 0)
						{
							$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_amt"=>number_format(floor($discount_Amt),2));
							
							$discountsArray2[] = array("Discount_code"=>$row->Discount_code,"Discount_amt"=>number_format(floor($discount_Amt),2));
						}
					}
					
					if($row->Discount_voucher_applicable == 1 ) // send voucher
					{
						$gift_cardid = $this->getGiftCard($Company_id);
						
						$discountVoucherAmt = $discountVoucherAmt + floor($discount_Amt);
						
						if($discount_Amt > 0 || $discount_Percentage > 0)
						{
							if($API_flag_call == 90) 
							{
								
							$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);
							
							}

						}
					}

					$discount_Amt = 0;
				}
			
			}

				
				/********Ravi-11-04-2020*********/
					return	json_encode(array("DiscountAmt"=>number_format(floor($discountAmt),2),"discountsArray"=>$discountsArray,"discountsArray2"=>$discountsArray2));
					
					//"DiscountPercentageValue"=>$DiscountPercentageValue,"DiscountRuleSet"=>$DiscountRuleSet
				/********Ravi-11-04-2020*********/
				
				//"voucherAmt"=>number_format(floor($discountVoucherAmt),2),
			
		}
		function get_3rd_party_category_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal,$channel,$API_flag_call)
		{
			$today = date("Y-m-d");
			$discountAmt = 0;
			$discountVoucherAmt = 0;
			$discount_Amt = 0;
			
			$DiscountPercentageValue=0;
			$DiscountRuleSet=0;

			$this->db->Select("A.*,B.Item_code,B.Discount_percentage_or_value");			
			$this->db->from('igain_new_discount_rule_master as A');
			$this->db->join('igain_new_discount_rule_child as B','A.Discount_code = B.Discount_code','LEFT');
			$this->db->where(array('A.Company_id' => $Company_id,'A.Active_flag' => 1,'A.Discount_rule_for' => 2));
			$this->db->where('"'.$today.'" BETWEEN Valid_from AND Valid_till');
			

			$sql = $this->db->get();
			//echo $this->db->last_query();

			if ($sql->num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$step = 0;
					$discount_Percentage = 0;
					
					$validTill = date("Y-m-d",strtotime($row->Valid_till));
					
				//	echo "-- Till Valid_till--".$validTill;
					
					if(in_array($row->Tier_id,array(0,$Tier_id)))
					{
						$step++;	
				//		echo " tier id".$Tier_id."<br>";
					}

					if(in_array($row->Seller_id,array(0,$delivery_outlet)))
					{
						$step++;
				//		echo "in seller ".$step."<br>";
					}
					
					if($row->Discount_rule_for == 2 && $step == 2 && $grandTotal == 0) // category level
					{
				//		echo "item category--".$Itemcategory_id."--";
						if($row->Category_id == $Itemcategory_id)
						{
							if($row->Discount_rule_set == 2)
							{
								$discount_Amt = (int)$row->Discount_Percentage_Value;
								
							//************** sandeep 7-1-2020 ***************
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
							//************** sandeep 7-1-2020 ***************
							}
							
							if($row->Discount_rule_set == 1) // in %
							{
							//************** sandeep 7-1-2020 ***************
					
								if($row->Discount_voucher_applicable == 0 )
								{
									$discount_Amt = (int)($row->Discount_Percentage_Value*$Item_price)/100;
								}
								
								if($row->Discount_voucher_applicable == 1 ) // send voucher
								{
									$discount_Percentage = (int)$row->Discount_Percentage_Value;
								}
								
								if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
								{
									$discount_Amt = $row->Maximum_limit;
								}
							//************** sandeep 7-1-2020 ***************
							}
						}
						$step++;
				//		echo "in category ".$step."<br>";
					}
						
					if($row->Discount_voucher_applicable == 0 )
					{
						$discountAmt = $discountAmt + floor($discount_Amt);
						
						if($discount_Amt > 0)
						{
							$discountsArray[] = array("Discount_Code"=>$row->Discount_code,"Discount_Amt"=>number_format(floor($discount_Amt),2));
							
							$discountsArray2[] = array("Discount_Code"=>$row->Discount_code,"Discount_Amt"=>number_format(floor($discount_Amt),2));
						}
					}
					
					if($row->Discount_voucher_applicable == 1 ) // send voucher
					{
						$gift_cardid = $this->getGiftCard($Company_id);
						
						$discountVoucherAmt = $discountVoucherAmt + floor($discount_Amt);
						
						if($discount_Amt > 0 || $discount_Percentage > 0)
						{
							if($API_flag_call == 94) 
							{
								$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);
							}
						}
					}

					$discount_Amt = 0;
				}
			}
			return	json_encode(array("DiscountAmt"=>number_format(floor($discountAmt),2),"discountsArray"=>$discountsArray,"discountsArray2"=>$discountsArray2));
		}
		function get_payment_type_discount_value($PaymentType,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal)
		{
			//echo $PaymentType."----".$Company_id."---".$cust_enroll."--".$Tier_id."--".$grandTotal."<br>";
			
			$today = date("Y-m-d");
			
			$discountAmt = 0;
			$discountVoucherAmt = 0;
			$discount_Amt = 0;
			$discount_Percentage = 0;
			$DiscountPercentageValue=0;

			$this->db->Select("A.*");			
			$this->db->from('igain_new_discount_rule_master as A');
			$this->db->where(array('A.Company_id' => $Company_id,'A.Active_flag' => 1,'A.Payment_type_id' => $PaymentType));
			$this->db->where('"'.$today.'" BETWEEN A.Valid_from AND A.Valid_till');
			

			$sql = $this->db->get();
		//	echo $this->db->last_query();

			if ($sql->num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$step = 0;
					
					$validTill = date("Y-m-d",strtotime($row->Valid_till));
					
				//	echo "-- Till Valid_till--".$validTill;
					
					if(in_array($row->Tier_id,array(0,$Tier_id)))
					{
						$step++;	
				//		echo " tier id".$Tier_id."<br>";
					}

					if(in_array($row->Seller_id,array(0,$delivery_outlet)))
					{
						$step++;
				//		echo "in seller ".$step."<br>";
					}
					
					if($row->Discount_rule_for == 5 && $step == 2 && $grandTotal > 0 ) // on payment type
					{
			//	echo "in payment rule <br>";	
						if($row->Discount_rule_set == 2)
						{
							
							$discount_Amt = (int)$row->Discount_Percentage_Value;
							
				//************** sandeep 7-1-2020 ***************
							if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
							{
								$discount_Amt = $row->Maximum_limit;
							}
				//************** sandeep 7-1-2020 ***************
						}
						
						if($row->Discount_rule_set == 1) // in %
						{
					
				//************** sandeep 7-1-2020 ***************
							if($row->Discount_voucher_applicable == 0 )
							{
								$discount_Amt = (int)($row->Discount_Percentage_Value*$grandTotal)/100;
							}
							
							if($row->Discount_voucher_applicable == 1 ) // send voucher
							{
								$discount_Percentage = $row->Discount_Percentage_Value;
							}
							
							if($row->Maximum_limit > 0 && $row->Maximum_limit < $discount_Amt)
							{
								$discount_Amt = $row->Maximum_limit;
							}
				//************** sandeep 7-1-2020 ***************
						}
					
						$step++;
						
					}
					
					
					if($row->Discount_voucher_applicable == 0 )
					{

						$discountAmt = $discountAmt + floor($discount_Amt);
						
						if($discount_Amt > 0)
						{
							$payment_discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_amt"=>number_format(floor($discount_Amt),2));
							
						}
					}
					
					if($row->Discount_voucher_applicable == 1 ) // send voucher
					{
						$gift_cardid = $this->getGiftCard($Company_id);
						
						$discountVoucherAmt = $discountVoucherAmt + floor($discount_Amt);
					
						if($discount_Amt > 0 || $discount_Percentage > 0)
						{
							$payment_discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);

						}
					}

					$discount_Amt = 0;
				}	
			}
			//print_r($payment_discountsArray);
			
				if(count($payment_discountsArray) > 0)
				{
					// return $payment_discountsArray;
					return $payment_discountsArray;
					// $this->session->set_userdata('Payment_Discount_codes',$payment_discountsArray);
				
				} else {
					
					// $this->session->set_userdata('Payment_Discount_codes',null);
					return null;
				}
							
			// return floor($discountAmt);
			
		}
		
		function get_giftcard_balance($GiftCard_id,$Company_id)
		{
			$this->db->select("Card_balance");
			$this->db->where(array('Gift_card_id' => $GiftCard_id,'Company_id' => $Company_id));
			$this->db->limit('1');
			$query = $this->db->get('igain_giftcard_tbl');		
			if($query -> num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return false;
			}	
		}
		
		function get_member_discount_vouchers($Card_id,$Company_id)
		{
			$today = date("Y-m-d");
			
			$this->db->select("Gift_card_id,Card_balance,Valid_till");
			$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id, 'Payment_Type_id' => '99'));
			$this->db->where(array('Card_balance >' => '0','Valid_till >=' => $today));
			$query = $this->db->get('igain_giftcard_tbl');	

			if($query -> num_rows() > 0)
			{
				return $query->result_array();
			}
			else
			{
				return false;
			}	
		}
		
		function getVoucher()
		{
			/********************************/
				$characters = '123456789';
				$string = '';
				$Voucher_no="";
				for ($i = 0; $i < 10; $i++) 
				{
					$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
				}
				
				return $Voucher_no;
			/*************************************/
		}
		
		function getGiftCard($Company_id)
		{
			$gift_cardid = $this->getVoucher();
			$gift_card_exist = $this->check_gift_card_id($gift_cardid,$Company_id);
			
			if($gift_card_exist > 0)
			{
				$this->getGiftCard($Company_id);
			}
			
			return $gift_cardid;
		}
		
		function Get_my_discount_vouchers($limit,$page,$Enrollment_id,$Company_id,$Card_id)
		{
			$this->db->select("T.*");
			$this->db->where(array('T.Company_id' => $Company_id, 'T.Card_id' => $Card_id, 'T.Payment_Type_id' => 99)); // 'T.Card_balance >' => 0
			$this->db->from('igain_giftcard_tbl as T');
			$this->db->join('igain_enrollment_master as IE', 'T.Card_id = IE.Card_id','LEFT');
			if($limit!=NULL || $page!=NULL)
			{
			$this->db->limit($limit,$page);
			}
			$this->db->order_by('T.id','DESC');
			$sql = $this->db->get();
			// echo $this->db->last_query(); die;
			if($sql->num_rows() > 0)
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
		//***************** discount calculation 27-01-2020 *************************
		function Get_item_details($ItemCode,$Company)
		{
			$Todays_date=date("Y-m-d");
			$this->db->select("*");
			$this->db->from('igain_company_merchandise_catalogue');
			$this->db->where(array('Company_merchandize_item_code' => $ItemCode,'Company_id' => $Company,'Active_flag'=>1,'Ecommerce_flag'=>1,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date));
			
			$sql12 = $this->db->get();
			if($sql12 -> num_rows() == 1)
			{
				return $sql12->row();
			}
			else
			{
				return false;
			}
		}
		function Validate_discount_voucher($Card_id,$Company_id,$Discount_voucher_code,$Voucher_amount)
		{
			$today = date("Y-m-d");
			
			$this->db->select("*");
			$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id,"Gift_card_id" => $Discount_voucher_code));
			// $this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id, 'Payment_Type_id' => '99',"Gift_card_id" => $Discount_voucher_code));
			$this->db->where(array('Card_balance >' => '0','Valid_till >=' => $today));
			$query = $this->db->get('igain_giftcard_tbl');	
			
			if($query -> num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}			
		} 
		/****************nilesh start new development discount*****************/
		/***************Pos Transaction with items details********************/
		function Get_merchandize_item($Item_code,$Company_id)
		{
		  $Todays_date=date("Y-m-d");
		  $this->db->select('*');
		  $this->db->from('igain_company_merchandise_catalogue');
		  $this->db->where(array('Company_merchandize_item_code' => $Item_code, 'Company_id' => $Company_id,'Active_flag'=>1,'Ecommerce_flag'=>1,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date));
		  $query11 = $this->db->get();

			if($query11 -> num_rows() == 1)
			{
				return $query11->row();
			}
			else
			{
				return false;
			}
		}
		function get_items_branches($Company_merchandize_item_code,$Merchandize_partner_id,$Company_id)
		{
			$this->db->select('*');
			$this->db->from('igain_merchandize_item_child');
			$this->db->where(array('Partner_id' =>$Merchandize_partner_id, 'Merchandize_item_code '=>$Company_merchandize_item_code,'Company_id'=>$Company_id));
			$sql = $this->db->get();
			//echo $this->db->last_query();//DIE;
			if($sql -> num_rows() > 0)
			{
				return $sql->row();
			}
			else
			{
				return false;
			}
		}
		
		function Insert_log_table($Company_id,$From_enroll_id,$From_username,$LogginUserName,$lv_date_time,$what,$where,$From_userid,$opration,$opval,$firstName,$lastName,$To_enroll_id)
		{
			$data['Company_id'] = $Company_id;
			$data['From_enrollid'] = $From_enroll_id;
			$data['From_emailid'] = $From_username;
			$data['From_userid'] = $From_userid;
			$data['To_enrollid'] = $To_enroll_id;
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
		function Fetch_city_state_country($Company_id,$Customer_enroll_id)
		{
			$this->db->select("*,igain_state_master.name as State_name,igain_city_master.name as City_name,igain_country_master.name as Country_name");
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('User_activated' => '1','User_id' => '1','Company_id' => $Company_id,'Enrollement_id' => $Customer_enroll_id));
			$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id');
			$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id');
			$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id');
			
			$SubsellerSql = $this->db->get();		
			if($SubsellerSql->num_rows() == 1)
			{
				return $SubsellerSql->row();
			}
			else
			{
				return 0;
			}
		}
		/* function check_pos_bill_no($Bill_no,$Pos_outlet_id,$Company_id)
		{		
			$query =  $this->db->select('Manual_billno')
					  ->from('igain_transaction')
					  ->where(array('Manual_billno' => $Bill_no, 'Company_id' => $Company_id, 'Seller' =>$Pos_outlet_id))->get();
			return $query->num_rows();
		} */
		function check_pos_bill_no($Bill_no,$Pos_outlet_id,$Company_id,$Bill_date_time)
		{
			$start_date=date("Y-m-d 00:00:00", strtotime($Bill_date_time)); 
			$end_date=date("Y-m-d 23:59:59", strtotime($Bill_date_time));
			
			$this->db->select('Manual_billno');
			$this->db->from('igain_transaction');
			$this->db->where(array('Manual_billno' => $Bill_no, 'Company_id' => $Company_id, 'Seller' =>$Pos_outlet_id));
			$this->db->where('Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
			$query = $this->db->get();		
			return $query->num_rows();
		}
		/***************Pos Transaction with items details****************/
		/******************************AMIT KAMBLE 20-02-2020 POS ITEM CREATION API******************/
		function insert_product_group($Product_group_data) 
		{ 
			$this->db->insert('igain_product_group_master', $Product_group_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		function Check_product_group($Product_group_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Product_group_id')
			->from('igain_product_group_master')
			->where(array('Product_group_code' => $Product_group_code,'Company_id' => $Company_id))->get();
			 return $query->row();
			// echo $this->db->last_query();	   
			// return $query->num_rows();
		}
		function Check_product_group2($Product_Group_Id)
		{	 	 
			$query =  $this->db->select('Product_group_name')
			->from('igain_product_group_master')
			->where(array('Product_group_id' => $Product_Group_Id))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		public function Update_product_group($post_data, $Product_group_code,$Company_id)
		{
			$this->db->where('Product_group_code', $Product_group_code);
			$this->db->where('Company_id', $Company_id);
			$this->db->update("igain_product_group_master", $post_data);
			// echo $this->db->last_query();	  
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		/***************************Product_subgroup Groups*****************************************/
		function Check_product_subgroup($Product_brand_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Product_brand_id')
			->from('igain_product_brand_master')
			->where(array('Product_brand_code' => $Product_brand_code,'Company_id' => $Company_id))->get();
			return $query->row();
			
			// echo $this->db->last_query();	   
			// return $query->num_rows();
		}
		function Check_product_subgroup2($Product_brand_id)
		{	 	 
			$query =  $this->db->select('Product_brand_name')
			->from('igain_product_brand_master')
			->where(array('Product_brand_id' => $Product_brand_id))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		function insert_product_subgroup($Product_subgroup_data) 
		{ 
			$this->db->insert('igain_product_brand_master', $Product_subgroup_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function update_product_subgroup($post_data, $Product_brand_code,$Company_id)
		{
			$this->db->where('Product_brand_code', $Product_brand_code);
			$this->db->where('Company_id', $Company_id);
			$this->db->update("igain_product_brand_master", $post_data);
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		function Insert_error_pos_api($data) 
		{ 
			$this->db->insert('igain_pos_api_error_tbl', $data);
			 // echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function delete_pos_api_error($Company_id,$Brand_id,$Outlet_id)
		{
			$this->db->where(array('Company_id' => $Company_id,'Brand_id' => $Brand_id,'Outlet_id' => $Outlet_id));
			$this->db->delete('igain_pos_api_error_tbl');
			// echo $this->db->last_query();
			// $this->db->truncate('igain_pos_api_error_tbl');
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		/***************************Menu Groups*****************************************/
		function Check_Menu_Groups($Merchandize_category_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Merchandize_category_id')
			->from('igain_merchandize_category')
			->where(array('Merchandize_category_code' => $Merchandize_category_code,'Company_id' => $Company_id))->get();
			return $query->row();
			// echo $this->db->last_query();	   
			// return $query->num_rows();
		}
		function Check_Menu_Groups2($Merchandize_category_id)
		{	 	 
			$query =  $this->db->select('Merchandize_category_id')
			->from('igain_merchandize_category')
			->where(array('Merchandize_category_id' => $Merchandize_category_id))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		function insert_Menu_Groups($Menu_Groups_data) 
		{ 
			$this->db->insert('igain_merchandize_category', $Menu_Groups_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function update_Menu_Groups($Menu_Groups_data, $Merchandize_category_code,$Company_id)
		{
			$this->db->where('Merchandize_category_code', $Merchandize_category_code);
			$this->db->where('Company_id', $Company_id);
			$this->db->update("igain_merchandize_category", $Menu_Groups_data);
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		/***************************Condiments*****************************************/
		function Check_Condiments($Group_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Group_code')
			->from('igain_pos_item_req_opt_group_child')
			->where(array('Group_code' => $Group_code,'Company_id' => $Company_id,'Active_flag' => 1))->get();
			
			 // echo "<br>".$this->db->last_query();	   
			return $query->num_rows();
		}
		function insert_Condiments($Condiments_data) 
		{ 
			$this->db->insert('igain_company_merchandise_catalogue', $Condiments_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function update_Condiments($Condiments_data, $Company_merchandize_item_code,$Company_id)
		{
			$this->db->where(array('Company_merchandize_item_code' => $Company_merchandize_item_code,'Company_id' => $Company_id));
			$this->db->update("igain_company_merchandise_catalogue", $Condiments_data);
			// echo $this->db->last_query();
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		/***************************Condiment_Groups_data*****************************************/
		function Check_Condiment_Groups($Group_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Group_code')
			->from('igain_pos_item_req_opt_group_child')
			->where(array('Group_code' => $Group_code,'Company_id' => $Company_id))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		function insert_Condiment_Groups($Condiments_data) 
		{ 
			$this->db->insert('igain_pos_item_req_opt_group_child', $Condiments_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function update_Condiment_Groups($Condiments_data, $Group_code)
		{
			$this->db->where(array('Group_code' => $Group_code));
			$this->db->update("igain_pos_item_req_opt_group_child", $Condiments_data);
			// echo $this->db->last_query();
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		public function delete_Condiment_Groups($Group_code,$Company_id)
		{
			$this->db->where(array('Group_code' => $Group_code,'Company_id' => $Company_id));
			$this->db->delete('igain_pos_item_req_opt_group_child');
			// echo $this->db->last_query();
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		/***************************Menu_Items*****************************************/
		function Check_Item_Num($Company_merchandize_item_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Company_merchandize_item_code')
			->from('igain_company_merchandise_catalogue')
			->where(array('Company_merchandize_item_code' => $Company_merchandize_item_code,'Company_id' => $Company_id,'Active_flag' => 1))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		function Get_Category_id_item($Company_merchandize_item_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Merchandize_category_id')
			->from('igain_company_merchandise_catalogue')
			->where(array('Company_merchandize_item_code' => $Company_merchandize_item_code,'Company_id' => $Company_id,'Active_flag' => 1))->get();
			return $query->row();
			// echo $this->db->last_query();	   
		}
		function Check_Item_Num2($Company_merchandize_item_code)
		{	 	 
			$query =  $this->db->select('Company_merchandize_item_code')
			->from('igain_company_merchandise_catalogue')
			->where(array('Company_merchandize_item_code' => $Company_merchandize_item_code))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		function insert_Menu_Items($Menu_Items_data) 
		{ 
			$this->db->insert('igain_company_merchandise_catalogue', $Menu_Items_data);
			 // echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function delete_Menu_condiments_data($Item_code,$Company_id)
		{
			$this->db->where(array('Item_code' => $Item_code,'Company_id' => $Company_id));
			$this->db->delete('igain_item_condiments_tbl');
			// echo $this->db->last_query();
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		function insert_Menu_condiments_data($Menu_condiments_data) 
		{ 
			$this->db->insert('igain_item_condiments_tbl', $Menu_condiments_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		public function update_Menu_Items($Menu_Items_data, $Company_merchandize_item_code,$Company_id)
		{
			$this->db->where(array('Company_merchandize_item_code' => $Company_merchandize_item_code,'Company_id' => $Company_id));
			$this->db->update("igain_company_merchandise_catalogue", $Menu_Items_data);
			// echo $this->db->last_query();
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		function Select_Condiment_item_code($Group_code,$Company_id,$Condiment_type)
		{	 	 
			$query =  $this->db->select('Condiment_item_code')
			->from('igain_pos_item_req_opt_group_child')
			->where(array('Condiment_type' => $Condiment_type,'Group_code' => $Group_code,'Company_id' => $Company_id,'Active_flag' => 1))->get();
			// echo $this->db->last_query();	 
			if($query->num_rows()>0)
			{
				foreach ($query->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}
			else
			{
				return false;
			}
			// echo $this->db->last_query();	   
			
		}
			function Delete_side_group_child($Company_id,$Menu_Item_code)
		{
			//echo "refid ".$refid;die;
			$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Company_id'=>$Company_id));
			$this->db->delete("igain_pos_item_combo_side_child");
			// echo "<br><br>".$this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		function Delete_item_combo_child($Company_id,$Menu_Item_code,$Item_flag)
		{
			//echo "refid ".$refid;die;
			$this->db->where(array('Menu_Item_code'=>$Menu_Item_code,'Item_flag'=>$Item_flag,'Company_id'=>$Company_id));
			$this->db->delete("igain_pos_item_combo_child");
			// echo "<br><br>".$this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		function Select_POS_API_Error_Records($Company_id,$Brand_id,$Outlet_id)
		{	 	 
			$Todaysdate=date('Y-m-d');
			$query =  $this->db->select('ID,Brand_id,Outlet_id,Main_array,Error,Date')
			->from('igain_pos_api_error_tbl')
			->where(array('Company_id' => $Company_id,'Brand_id' => $Brand_id,'Outlet_id' => $Outlet_id))->get();
			// echo $this->db->last_query();	 
			if($query->num_rows()>0)
			{
				foreach ($query->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}
			else
			{
				return false;
			}
			// echo $this->db->last_query();	   
			
		}
		function Check_seller_exist($Enrollement_id,$Company_id)
		{
			$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Super_seller");
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('User_id' => '2','Sub_seller_admin' => '1','User_activated' => '1','Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id));
			$sql = $this->db->get();
			
			if ($sql->num_rows() > 0)
			{
				return $sql->result_array();
				
			}
			return false;
		}
		
		function Get_brand_items($Seller_id,$Company_id)
		{
			$this->db->select('Company_merchandize_item_code');
			$this->db->from('igain_company_merchandise_catalogue as A');
			$this->db->where(array('A.Active_flag'=> 1,'A.Seller_id'=>$Seller_id,'A.Company_id'=>$Company_id));
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
		function Check_item_trans($Item_code,$Company_id)
		{	 	 
			$query =  $this->db->select('Item_code')
			->from('igain_transaction')
			->where(array('Item_code' => $Item_code,'Company_id' => $Company_id))->get();
			
			// echo $this->db->last_query();	   
			return $query->num_rows();
		}
		public function Delete_brand_item($Company_merchandize_item_code,$Company_id)
		{
			$this->db->where(array('Company_merchandize_item_code' => $Company_merchandize_item_code,'Company_id' => $Company_id));
			$this->db->delete('igain_company_merchandise_catalogue');
			// echo $this->db->last_query();
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}
		public function Check_pos_item_linked_outlets($Outlet_id,$Company_id,$Merchandize_item_code)
		{
			$this->db->select("Merchandize_item_code");
			$this->db->from('igain_pos_item_linked_outlets');
			$this->db->where(array('Merchandize_item_code' => $Merchandize_item_code,'Company_id' => $Company_id,'Outlet_id' => $Outlet_id));
			$sql = $this->db->get();
			
			return $sql->num_rows();
		}
		function Check_outlet_exist($Brand_id,$Outlet_id,$Company_id)
		{
			$this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Super_seller");
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('Enrollement_id' => $Outlet_id,'Sub_seller_Enrollement_id' => $Brand_id,'User_activated' => '1','User_id' => '2','Company_id' => $Company_id));
			$sql = $this->db->get();
			
			if ($sql->num_rows() > 0)
			{
				return $sql->result_array();
				
			}
			return false;
		}
		function insert_item_linked_outlet($item_outlet_data) 
		{ 
			$this->db->insert('igain_pos_item_linked_outlets', $item_outlet_data);
			// echo $this->db->last_query();
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	function Check_pos_price_child($Company_id,$Menu_Item_code,$Item_Rate)
	{
		
		$this->db->select("Menu_Item_code");
		$this->db->from('igain_pos_item_price_child');
		$this->db->where(array('Menu_Item_code' => $Menu_Item_code,'Company_id' => $Company_id,'Pos_price' => $Item_Rate,'Price_Active_flag'=>1));
		$sql = $this->db->get();
		
		return $sql->num_rows();	
	}
	/******************************AMIT KAMBLE 20-02-2020 POS ITEM CREATION API**XXXXX****************/
	
	function Get_Member_Tier_Details($TierId,$Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_tier_master');
		$this->db->where(array('Tier_id'=> $TierId,'Company_id'=> $Company_id));		
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
	function Get_Product_Voucher_Details($Gift_card_id,$Cust_enrollement_id,$Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_company_send_voucher');
		$this->db->where(array('Enrollement_id'=> $Cust_enrollement_id,'Company_id'=> $Company_id,'Voucher_code'=> $Gift_card_id));		
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
	function Get_vouchers($Card_id,$Company_id)
	{
		$Todays_date=date("Y-m-d");
		$this->db->select('*');
		$this->db->from('igain_giftcard_tbl');
		$this->db->where(array('Company_id'=> $Company_id,'Card_id'=> $Card_id,'Valid_till >='=>$Todays_date,'Card_balance >'=>0,'Payment_Type_id !=' => 997));
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
	function get_member_product_vouchers($Card_id,$Company_id,$item_code)
	{
		$today = date("Y-m-d");
		
		$this->db->select("igain_giftcard_tbl.Gift_card_id,igain_giftcard_tbl.Card_value,igain_giftcard_tbl.Card_balance,igain_giftcard_tbl.Valid_till,igain_giftcard_tbl.Discount_percentage,B.Company_merchandize_item_code,C.Merchandize_item_name");
		$this->db->join('igain_company_send_voucher as B','igain_giftcard_tbl.Gift_card_id = B.Voucher_code');
		$this->db->join('igain_company_merchandise_catalogue as C','C.Company_merchandize_item_code = B.Company_merchandize_item_code');
	
		$this->db->where(array('igain_giftcard_tbl.Card_id' => $Card_id,'igain_giftcard_tbl.Company_id' => $Company_id,'igain_giftcard_tbl.Payment_Type_id' => '997','B.Company_merchandize_item_code' => $item_code));			
		
		$this->db->where(array('igain_giftcard_tbl.Card_balance >' => '0','igain_giftcard_tbl.Valid_till >=' => $today));
		$this->db->order_by('Payment_Type_id','DESC');
		$query = $this->db->get('igain_giftcard_tbl');			
		
		if($query -> num_rows() > 0)
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
			return false;
		}	
	}
	function get_3rd_party_channel_details($Company_id,$Channel_password)
	{
		$this->db->select("A.Register_beneficiary_id as Channel_Company_Id,A.Beneficiary_company_name as Channel_Company_Name");
		$this->db->from('igain_register_beneficiary_company as A');
		$this->db->join('igain_beneficiary_company As B', 'A.Register_beneficiary_id = B.Register_beneficiary_id');
		$this->db->where(array('A.Company_password' => $Channel_password,'A.Activate_flag' => '1','B.Company_id' => $Company_id));
		$sql = $this->db->get();		
		if($sql->num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	function Check_redeem_details($Enroll_id,$Company_id,$Outlet_id,$Channel_id,$Confirmation_code,$Redeem_points,$Order_no)
	{
		$this->db->select("*");
		$this->db->from('igain_cust_redeem_request');
		$this->db->where(array('Enrollement_id' => $Enroll_id,'Company_id' => $Company_id,'Seller_id' => $Outlet_id,'Channel_id' => $Channel_id,'Confirmation_code' => $Confirmation_code,'Redeem_points' => $Redeem_points,'Pos_bill_no' => $Order_no,'Confirmation_flag !=' => '2'));
		$sql = $this->db->get();		
		if($sql->num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
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
	public function insert_pos_json_log($data)
	{
		$this->db->insert('igain_pos_json_log', $data);		
		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
//*****stamp flag item offers ***********
	public function get_product_offers($product_id,$Merchandize_category_id,$Company_id,$Brand_id)
	{
		$Todays_date=date('Y-m-d');
		// $this->db->select('A.Offer_id,A.Company_merchandise_item_id,A.Buy_item,A.Free_item,A.Free_item_id,From_date,Till_date');
		$this->db->select('A.Offer_id,A.Offer_code,A.Company_merchandise_item_id,A.Buy_item,A.Free_item,A.Free_item_id,From_date,Till_date,Offer_name');
		$this->db->from('igain_offer_master as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Company_merchandise_item_id=B.Company_merchandise_item_id','LEFT');
		$this->db->where(array('A.Active_flag'=>1,'A.Company_id'=>$Company_id,'A.Seller_id'=>$Brand_id,'A.Buy_item_category '=>$Merchandize_category_id));
		
		$this->db->where_in('A.Company_merchandise_item_id',array(0,$product_id));
		
		$this->db->where(" '".$Todays_date."' BETWEEN From_date AND Till_date ");
		$sql = $this->db->get();
		// echo $this->db->last_query();die;
		if($sql->num_rows() > 0)
		{			
			return $sql->result_array();
		}
		else
		{
			return 0;
		}
	}
	public function member_sent_offers($Company_id,$enroll_id,$Offer_code,$Free_item_id)
	{
		$this->db->select('Voucher_send_id,Offer_code');
		$this->db->from('igain_company_send_voucher');
		$this->db->where(array('Company_id'=>$Company_id, 'Enrollement_id'=>$enroll_id, 'Offer_code'=>$Offer_code,'Company_merchandise_item_id'=>$Free_item_id));
		$sql77 = $this->db->get();
		// echo "<br><br>member_sent_offers :: ".$this->db->last_query();//die;
		if($sql77->num_rows() > 0)
		{
			return $sql77->num_rows();
		}
		else
		{
			return 0;
		}
	}
	public function Get_freeVoucher_quantity($Company_id,$Voucher_code)
	{
		$this->db->select('Quantity,Company_merchandize_item_code');
		$this->db->from('igain_company_send_voucher');
		$this->db->where(array('Company_id'=>$Company_id, 'Voucher_code'=>$Voucher_code));
		$sql77 = $this->db->get();
		// echo "<br><br>Get_freeVoucher_quantity :: ".$this->db->last_query();//die;
		if($sql77->num_rows() > 0)
		{
			return $sql77->row();
		}
		else
		{
			return 0;
		}
	}
	public function get_item_purchase_count($ItemCode,$Company_id,$enroll_id,$From_date,$Till_date)
	{
		$Todays_date=date('Y-m-d');
		
		$this->db->select('sum(Quantity),sum(Free_item_quantity),sum(Quantity-Free_item_quantity) as product_qty');
		$this->db->from('igain_transaction');
		$this->db->where(array('Company_id'=>$Company_id, 'Enrollement_id'=>$enroll_id, 'Item_code '=>$ItemCode));
		
		$this->db->where(" Trans_date BETWEEN '".$From_date."' AND '".$Till_date."' ");
		$sql76 = $this->db->get();
		// echo "<br>get_item_purchase_count:: ".$this->db->last_query();
		if($sql76->num_rows() > 0)
		{
			foreach($sql76->result_array() as $row76)
			{
				return $row76['product_qty'];
			}
		}
		else
		{
			return 0;
		}
	}
	public function get_category_purchase_count($Merchandize_category_id,$Company_id,$enroll_id,$From_date,$Till_date)
	{
		$Todays_date=date('Y-m-d');
		$this->db->select('A.Item_code,sum(A.Quantity) as product_qty');
		$this->db->from('igain_transaction as A');
		$this->db->join("igain_company_merchandise_catalogue as B","A.Item_code=B.Company_merchandize_item_code");
		$this->db->where(array('A.Company_id'=>$Company_id, 'Enrollement_id'=>$enroll_id, 'B.Merchandize_category_id'=>$Merchandize_category_id));
		
		$this->db->where(" Trans_date BETWEEN '".$From_date."' AND '".$Till_date."' ");
		$this->db->group_by('A.Item_code');
		$sql76 = $this->db->get();
	//	echo $this->db->last_query();
		$totalQty = 0;
		
		if($sql76->num_rows() > 0)
		{
			foreach($sql76->result_array() as $row76)
			{
				$totalQty = $totalQty + $row76['product_qty'];
			}
			
			return $totalQty;
		}
		else
		{
			return 0;
		}
	}
	
	public function insert_product_voucher($data76)
	{
		$this->db->insert('igain_company_send_voucher', $data76);	
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
	}
	public function insert_voucher_in_gift_card($data77)
	{
		$this->db->insert('igain_giftcard_tbl', $data77);	
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
	}
	public function get_offer_selected_items($Offer_code,$Company_id)
	{
		$this->db->select('A.Company_merchandise_item_id,B.Company_merchandize_item_code');
		$this->db->from('igain_offer_master as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Company_merchandise_item_id=B.Company_merchandise_item_id AND A.Company_id=B.Company_id');
		$this->db->where(array('A.Company_id' =>$Company_id,'Offer_code' =>$Offer_code));	
		$this->db->group_by('B.Company_merchandize_item_code');			
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
	public function get_offer_free_items($Offer_code,$Company_id)
	{
		$this->db->select('A.Company_merchandise_item_id,B.Company_merchandize_item_code,Free_item_id,Merchandize_item_name,Billing_price');
		$this->db->from('igain_offer_master as A');
		$this->db->join('igain_company_merchandise_catalogue as B','A.Free_item_id=B.Company_merchandise_item_id AND A.Company_id=B.Company_id');
		$this->db->where(array('A.Company_id' =>$Company_id,'Offer_code' =>$Offer_code));		
		$this->db->group_by('A.Free_item_id');	
		$sqlqury = $this->db->get();
		// echo "<br><br>get_offer_free_items ::   ".$this->db->last_query();
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
	function Get_Merchandize_Item_details($Company_merchandise_item_id)
	{
		$this->db->select('Company_merchandize_item_code,Merchandize_item_name,Merchandise_item_description,Billing_price,Billing_price_in_points,Item_image1,Item_image2,Item_image3,Item_image4,Thumbnail_image1,Thumbnail_image2,Thumbnail_image3,Thumbnail_image4,Company_id,Delivery_method,Company_merchandise_item_id');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Active_flag'=>1,'Company_merchandise_item_id'=>$Company_merchandise_item_id));
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
	function get_member_product_inprecentage_vouchers($Card_id,$Company_id,$item_code,$Quantity,$Voucher_code)
	{
		$today = date("Y-m-d");
		
		$this->db->select("igain_giftcard_tbl.Gift_card_id,igain_giftcard_tbl.Card_balance,igain_giftcard_tbl.Valid_till,igain_giftcard_tbl.Discount_percentage,B.Company_merchandize_item_code,C.Merchandize_item_name,B.Quantity,(C.Billing_price * B.Quantity) as Reduce_product_amt");
		$this->db->join('igain_company_send_voucher as B','igain_giftcard_tbl.Gift_card_id = B.Voucher_code');
		$this->db->join('igain_company_merchandise_catalogue as C','C.Company_merchandize_item_code = B.Company_merchandize_item_code');
		
		/*---25-06-2020---*/
			$this->db->where(array('igain_giftcard_tbl.Card_id' => $Card_id,'igain_giftcard_tbl.Company_id' => $Company_id,'igain_giftcard_tbl.Payment_Type_id' => '997','B.Company_merchandize_item_code' => $item_code,'B.Voucher_code' => $Voucher_code,'B.Quantity <=' => $Quantity,'B.Voucher_id' =>0,'B.Offer_code !=""'));			
			// $this->db->where_in("Payment_Type_id",array('997'));
		/*---25-06-2020---*/
		
		$this->db->where(array('igain_giftcard_tbl.Card_balance >' => '0','igain_giftcard_tbl.Valid_till >=' => $today));
		// $this->db->order_by('Payment_Type_id','DESC');
		$query = $this->db->get('igain_giftcard_tbl');			
		// echo $this->db->last_query()."---<br>"; 
		if($query -> num_rows() > 0)
		{
			// return $query->result_array();
			return $query->row();
		}
		else
		{
			return false;
		}	
	}
//*****stamp flag item offers ***********
	function Validate_gift_card($Company_id,$Giftcard_No)
	{
		$today = date("Y-m-d");
		
		$this->db->select("*");
		$this->db->where(array('Company_id' => $Company_id,"Gift_card_id" => $Giftcard_No));
		$this->db->where(array('Card_balance >' => '0','Valid_till >=' => $today));
		$this->db->where('Payment_Type_id IN(1,2,3,4,5,6,7)');
		$query = $this->db->get('igain_giftcard_tbl');	
		
		if($query -> num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}			
	}
	function Get_lowest_sent_vouchers($Card_id,$Company_id,$Voucher_code)
	{
		$today = date("Y-m-d");
		
		$this->db->select("igain_giftcard_tbl.Gift_card_id,Voucher_code,igain_giftcard_tbl.Card_balance,igain_giftcard_tbl.Valid_till,igain_giftcard_tbl.Discount_percentage,B.Company_merchandize_item_code,B.Quantity as Voucher_Qty,B.Cost_price as Voucher_Cost_price,Offer_description,Offer_name");
		$this->db->join('igain_company_send_voucher as B','igain_giftcard_tbl.Gift_card_id = B.Voucher_code AND igain_giftcard_tbl.Company_id = B.Company_id');
		// $this->db->join('igain_company_merchandise_catalogue as C','C.Company_merchandize_item_code = B.Company_merchandize_item_code');
		$this->db->join('igain_offer_master as of','of.Offer_code = B.Offer_code and of.Company_id = B.Company_id');
		
		$this->db->where(array('igain_giftcard_tbl.Card_id' => $Card_id,'igain_giftcard_tbl.Company_id' => $Company_id,'igain_giftcard_tbl.Payment_Type_id' => '997','igain_giftcard_tbl.Gift_card_id' => $Voucher_code,'B.Voucher_id' =>0,'B.Offer_code !=' => ''));			
		
		$this->db->where(array('igain_giftcard_tbl.Card_balance >' => '0','igain_giftcard_tbl.Valid_till >=' => $today));
		$this->db->group_by('B.Voucher_code');
		$this->db->group_by('B.Company_merchandize_item_code');
		$this->db->order_by('B.Voucher_code','ASC');
		$this->db->order_by('B.Cost_price','ASC');
		$query = $this->db->get('igain_giftcard_tbl');			
		 // echo "<br<br><br<br>Get_lowest_sent_vouchers   ".$this->db->last_query()."---<br>"; 
		if($query -> num_rows() > 0)
		{
			foreach ($query->result() as $row)
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
	public function insert_item($data76)
	{
		$this->db->insert('igain_pos_temp_cart', $data76);	
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
	}
	function Get_items($Company_id,$Enrollement_id,$Outlet_no,$ChannelCompanyId)
	{
		$this->db->select("*");
		$this->db->from('igain_pos_temp_cart');
		$this->db->where(array('Company_id' => $Company_id,'Enrollment_id' => $Enrollement_id,'Seller_id' => $Outlet_no,'Channel_id' => $ChannelCompanyId));			
		$query = $this->db->get();		
		if($query -> num_rows() > 0)
		{
			foreach ($query->result() as $row)
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
	function GetItemsDetails($Company_id,$Enrollement_id,$Item_code,$Outlet_no,$ChannelCompanyId)
	{
		$this->db->select("*");
		$this->db->where(array('Company_id' => $Company_id,"Enrollment_id" => $Enrollement_id,"Item_code" => $Item_code,"Seller_id" => $Outlet_no,"Channel_id" => $ChannelCompanyId));
		$query = $this->db->get('igain_pos_temp_cart');	
		
		if($query -> num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}			
	}
	public function delete_pos_temp_cart_data($Company_id,$Enrollement_id,$Outlet_no,$ChannelCompanyId)
	{
		$this->db->where(array('Company_id' => $Company_id,"Enrollment_id" => $Enrollement_id,"Seller_id" => $Outlet_no,"Channel_id" => $ChannelCompanyId));
		$this->db->delete('igain_pos_temp_cart');
		// echo $this->db->last_query();
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	function Get_temp_cart_items($Company_id,$Enrollement_id,$Outlet_no,$ChannelCompanyId)
	{
		$this->db->select("Item_code as Item_Num,Item_qty as Item_Qty,Item_price as Item_Rate");
		$this->db->from('igain_pos_temp_cart');
		$this->db->where(array('Company_id' => $Company_id,'Enrollment_id' => $Enrollement_id,'Seller_id' => $Outlet_no,'Channel_id' => $ChannelCompanyId));			
		$query = $this->db->get();		
		if($query -> num_rows() > 0)
		{
			return $query->result_array();
			// foreach ($query->result() as $row)
			// {
				// $data[] = $row;
			// }
			// return $data;
		}
		else
		{
			return false;
		}	
	}
	public function Get_points_consumption_details($enrollement_id,$company_id)
	{	
		$currentTime = date("Y-m-d H:i:s");
		$start_date=date("Y-m-d 00:00:00", strtotime($currentTime)); 
		$end_date=date("Y-m-d 23:59:59", strtotime($currentTime));
		
		$this->db->select('SUM(Redeem_points) AS Total_points_used,SUM(Redeem_amount) AS Total_points_amount,SUM(Loyalty_pts) AS Total_gained_points');
		$this->db->from('igain_transaction');
		$this->db->group_by('Enrollement_id');
		$this->db->where(array("Enrollement_id" => $enrollement_id, "Company_id" =>$company_id,"Trans_type" => 2));
		$this->db->where('Trans_date BETWEEN "'.$start_date.'" AND  "'.$end_date.'" ');
		
		$sql51 = $this->db->get();
		 // echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			 return $sql51->row();
		}
		else
		{
			return false;
		}	
	}
}
?>