<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Igain_model extends CI_Model
{

	function get_item($Company_id,$Item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_id' => $Company_id,'Company_merchandize_item_code' =>$Item_code));
		
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function Fetch_Company_Details($Company)
	{
		 $this->db->select('*');
		$this->db->from('igain_company_master');
		$this->db->where(array('Activated' => '1','Company_id' => $Company));
		// echo $this->db->last_query();
		$sql = $this->db->get();	
		
		
		
		$company_result = $sql->result_array();		
		if($sql->num_rows() > 0)
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
		// $Country_sql = $this->db->query("Select * from igain_country_timezone_tbl");
		$Country_sql = $this->db->query("Select * from igain_country_master");
		return $Country_result = $Country_sql->result_array();
		
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
		/* $query = "select Dial_code from igain_currency_master where Country_id='".$Country_id."'";

				$sql = $this->db->query($query);
				foreach ($sql->result() as $row)
				{
					$dial_code = $row->Dial_code;
				}
		return 	$dial_code;	 */
		
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
	function get_dial_code1($Country_id)
	{
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
		if($Loggin_User_id == 3)
		{
			$fetch_query = "SELECT Company_id,Company_name from  igain_company_master where Partner_company_flag=1 AND Activated=1";	
		}
		else
		{
			$fetch_query = "SELECT Company_id,Company_name from  igain_company_master where Parent_company='".$Company_id."' AND Activated=1 AND Company_id!=1";	
		}
		
		$run_sql = $this->db->query($fetch_query);
		
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

		if($sql_result->num_rows() > 0)
		{
			return $sql_result->result_array();
		}
		else
		{
			return 0;
		}
	}	
	/*function FetchSellerdetails($Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $Company_id));
		$this->db->order_by('Enrollement_id', 'DESC');
		// $this->db->limit('4');
		$SubsellerSql = $this->db->get();	
		return $SubsellerSql->result_array();
		
	}*/
	
	function FetchSellerdetails($Company_id)
	 {
	  $this->db->select("`Enrollement_id`,`User_id`,`First_name`,`Last_name`,`User_email_id`,`User_pwd`,`pinno`,`Card_id`,`Current_balance`,`Blocked_points`,`total_purchase`,`Total_topup_amt`,`Total_reddems`,`Topup_Bill_no`,`Current_address`,`State`,`City`,`Country`,`Super_seller`,`Sub_seller_admin`,`Sub_seller_Enrollement_id`,`Seller_Redemptionratio`,`Merchandize_Partner_ID`,`Merchandize_Partner_Branch`,timezone_entry");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Super_seller' => '0','Sub_seller_admin' => '0','Sub_seller_Enrollement_id !=' => '0','Company_id' => $Company_id));
	  $this->db->order_by('Enrollement_id', 'ASC');
	  // $this->db->limit('4');
	  $SubsellerSql = $this->db->get(); 
	  // echo $this->db->last_query()."<br>";
	  return $SubsellerSql->result_array();
	  
	 }
 
	function FetchSellerdetails_report($Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $Company_id));
		$this->db->order_by('Enrollement_id', 'DESC');
		$this->db->limit('4');
		$SubsellerSql = $this->db->get();	
		return $SubsellerSql->result_array();
		
	}
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
	function Fetch_All_Merchants($Company_id)
	{
		$this->db->select("*,igain_state_master.name as State_name,igain_city_master.name as City_name,igain_country_master.name as Country_name");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','Sub_seller_Enrollement_id !=' => '0','User_activated' => '1','Company_id' => $Company_id));
		$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id','left');
		$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id','left');
		$this->db->order_by('Enrollement_id', 'asc');
		$SubsellerSql = $this->db->get();		
		return $SubsellerSql->result_array();
	}
	function FetchCompanySeller($Company_id)
	{
		$this->db->select("Enrollement_id");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $Company_id));
		$SubsellerSql = $this->db->get();		
		return $SubsellerSql->result_array();
		
	}
	function FetchCompanySuperSeller($Company_id)
	{
		$this->db->select("Enrollement_id,Photograph");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Super_seller' => '1','Company_id' => $Company_id));
		$SubsellerSql = $this->db->get();		
		// return $SubsellerSql->result_array();
		return $SubsellerSql->row();
		
	}
	public function Company_Seller_Count($Enrollement_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id,'User_activated' => '1'));
		return $this->db->count_all_results();
	}
	function Fetch_Company_Seller($limit,$start,$Company_id)
	{
		$this->db->select("Enrollement_id");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2','User_activated' => '1','Company_id' => $Company_id));
		$this->db->limit($limit,$start);
		$SubsellerSql = $this->db->get();		
		return $SubsellerSql->result_array();
		
	} 
		
	function FetchSellerOffers($seller_id,$Company_id,$enroll)
	{
		/*  $this->db->select("*");
		$this->db->from('igain_seller_communication');
		$this->db->where(array('igain_seller_communication.seller_id' => $seller_id,'igain_enrollment_master.User_activated' => '1','igain_seller_communication.activate' => 'yes'));
		$this->db->join('igain_enrollment_master', 'igain_seller_communication.seller_id = igain_enrollment_master.Enrollement_id');
		$this->db->order_by('igain_seller_communication.id', 'DESC');
		$this->db->limit('1');
		$SubsellerSql = $this->db->get();	 
		
		return $SubsellerSql->result_array(); */
		
		
		$this->db->select("*,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name");
		$this->db->from('igain_cust_notification');
		$this->db->where(array('igain_cust_notification.seller_id' => $seller_id,'igain_cust_notification.Customer_id' =>$enroll ));
		$this->db->join('igain_seller_communication', 'igain_cust_notification.Communication_id = igain_seller_communication.Id');
		$this->db->join('igain_enrollment_master', 'igain_cust_notification.seller_id = igain_enrollment_master.Enrollement_id');
		$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id','left');
		$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id','left');
		$this->db->order_by('igain_cust_notification.Id', 'DESC');
		$this->db->limit('1');
		$SubsellerSql = $this->db->get();
			
		// echo $this->db->last_query();
		
		return $SubsellerSql->result_array(); 
		
	}
	 function Fetch_Seller_Loyalty_Offers($seller_id)
	{
		$this->db->select("igain_loyalty_master.*,igain_enrollment_master.*,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name");
		$this->db->from('igain_loyalty_master');
		$this->db->where(array('Seller' => $seller_id));
		$this->db->join('igain_enrollment_master', 'igain_loyalty_master.Seller = igain_enrollment_master.Enrollement_id');
		$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id');
		$this->db->order_by('igain_loyalty_master.Loyalty_id', 'DESC');
		$this->db->limit('1');
		$SubsellerSql = $this->db->get();	
		
		return $SubsellerSql->result_array();
		
	} 
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
	
	function get_company_details($CompanyId)
	{
		$this->db->select("*");
		$this->db->from('igain_company_master');
		$this->db->where(array('Activated' => '1','Company_id' => $CompanyId));
		
		$sql = $this->db->get();
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
			// return $sql->result_array();
		}
		else
		{
			return false;
		}
	}	
	function get_enrollment_details($Enrollement_id)
	{ 
		$this->db->select("*,(Current_balance-Blocked_points) AS Total_balance");
		$this->db->from('igain_enrollment_master');
		$this->db->where('Enrollement_id', $Enrollement_id);		
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
	function Member_profile_status($Enrollement_id,$Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Enrollement_id'=> $Enrollement_id,'Company_id'=> $Company_id,'User_id'=>1));		
		$sql = $this->db->get();
		// $sql$query->result_array();
		// echo $this->db->last_query();
		if($sql -> num_rows()== 1)
		{
			foreach ($sql->result() as $row)
			{
				if($row->First_name !="")
				{
					$profile_array[]=$row->First_name;
				}
				if($row->Last_name !="")
				{
					$profile_array[]=$row->Last_name;
				}
				if($row->Current_address !="")
				{
					$profile_array[]=$row->Current_address;
				}
				if($row->State !="")
				{
					$profile_array[]=$row->State;
				}
				if($row->District !="")
				{
					$profile_array[]=$row->District;
				}
				if($row->City !="")
				{
					$profile_array[]=$row->City;
				}
				if($row->Zipcode !="")
				{
					$profile_array[]=$row->Zipcode;
				}
				if($row->Country !="" || $row->Country !=0)
				{
					$profile_array[]=$row->Country;
				}
				if($row->Phone_no !="" || $row->Phone_no != 0)
				{
					$profile_array[]=$row->Phone_no;
				}
				if($row->Date_of_birth !="" &&  $row->Date_of_birth!= '01-Jan-1970')
				{
					$profile_array[]=$row->Date_of_birth;
				}
				if($row->Sex !="")
				{
					$profile_array[]=$row->Sex;
				}
				if($row->Qualification !="")
				{
					$profile_array[]=$row->Qualification;
				}
				if($row->Photograph !="")
				{
					$profile_array[]=$row->Photograph;
				}
				if($row->User_email_id !="")
				{
					$profile_array[]=$row->User_email_id;
				}
				if($row->Married !="")
				{
					$profile_array[]=$row->Married;
				}
				if($row->Wedding_annversary_date!=""  && $row->Wedding_annversary_date!= '01-Jan-1970' )
				{ 
					$profile_array[]=$row->Wedding_annversary_date;
				}
				if($row->Sex!="")
				{
					$profile_array[]=$row->Sex;
				}				
				if($row->Experience != '0')
				{
					// echo"---Experience----".$row->Experience."<br>";
					$profile_array[]=$row->Experience;
				}
				// echo"---First_name----".$row->First_name."<br>";
			}
			 
			$get_hobbies=$this->get_hobbies_interest_details($Enrollement_id,$Company_id);
			$count_hobby=count($get_hobbies);
			if($count_hobby > 0)
			{
				$profile_array[]=$get_hobbies;
				 
			}
			$status_count=count($profile_array);
			$total_percentage12=($status_count*100);
			// $total_profile_status=round($total_percentage12/23);
			$total_profile_status=round(($status_count*100)/19);
			return $total_profile_status;
		}
		else
		{
			return $total_profile_status;
		}
	}
	function Update_member_profile_status_flag($Enrollement_id,$Company_id)
	{
		$Profile_complete = array(
					'Profile_complete_flag' => 1
				);
		$this->db->where(array('Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id));
		$this->db->update("igain_enrollment_master", $Profile_complete);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	function Update_member_app_login_flag($Enrollement_id,$Company_id)
	{
		$Profile_complete = array(
					'App_login_flag' => 1
				);
		$this->db->where(array('Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id));
		$this->db->update("igain_enrollment_master", $Profile_complete);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
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
	function get_all_customers($Company_id)
	{
		$this->db->select("Enrollement_id,User_email_id");
		$this->db->where(array('User_id' => '1','User_activated' => '1','Company_id' => $Company_id));
		$this->db->where('Card_id <>','0');	
		$query = $this->db->get('igain_enrollment_master');
		 // echo $this->db->last_query();
		return $query->result_array();
	}
	function FetchTransactionDetails($Enrollement_id,$Card_id)
	{
		$this->db->select("*");
		
		$this->db->where(array('Card_id' => $Card_id,'Enrollement_id' => $Enrollement_id));
		$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
		$this->db->order_by('igain_transaction.Trans_id', 'DESC');
		$this->db->limit('5');
		$query = $this->db->get('igain_transaction');
		return $query->result_array();
	}
	function Fetch_Delivery_Transaction_Details($Enrollement_id,$Card_id)
	{
		$this->db->select("*");		
		$this->db->where(array('Card_id' => $Card_id,'Enrollement_id' => $Enrollement_id));
		$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
		$this->db->where('Voucher_status','20');
		$this->db->order_by('igain_transaction.Trans_id', 'DESC');
		$this->db->limit('5');
		$query = $this->db->get('igain_transaction');
		return $query->result_array();
	}
	function Fetch_statement_trans_details($Enrollement_id,$Card_id)
	{
		$this->db->select("*,SUM(igain_transaction.Loyalty_pts) as Loyalty_pts, SUM(igain_transaction.Topup_amount) as Topup_amount,SUM(igain_transaction.Redeem_points) as Redeem_points, SUM(igain_transaction.Purchase_amount) AS Purchase_amount ");
		
		$this->db->where(array('Card_id' => $Card_id,'Enrollement_id' => $Enrollement_id));
		$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
		
		$this->db->where_in('igain_transaction.Trans_type', array('2','12'));
		$this->db->group_by('igain_transaction.Bill_no');
		$this->db->order_by('igain_transaction.Trans_id', 'DESC');
		$this->db->limit('5');
		$query = $this->db->get('igain_transaction');
		// echo $this->db->last_query();
		// die;
		return $query->result_array();
	}
	public function Open_Notification_Count($Enrollement_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Open_flag' => '0'));
		return $this->db->count_all_results();
	}
	public function Read_Notification_Count($Enrollement_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Open_flag' => '1'));
		return $this->db->count_all_results();
	}
	public function Read_Unread_Notification_Count($Enrollement_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id));
		return $this->db->count_all_results();
	}
	
	public function Fetch_customer_notifications($Enrollement_id,$Company_id)
	{
		$this->db->distinct();
		$this->db->select('Communication_id');
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id));
		$this->db->order_by('Id', 'DESC');
		$this->db->limit('6');
		$sql = $this->db->get();
		// echo $this->db->last_query();

		if($sql -> num_rows() > 1)
		{
			return $sql->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function Fetch_Merchant_offers($seller_id,$Communication_id)
	{
		$this->db->select('A.First_name,A.Last_name,B.communication_plan,B.description,A.Current_address,A.Phone_no,A.Enrollement_id,A.Company_id');
		$this->db->from('igain_seller_communication as B');
		$this->db->join('igain_enrollment_master as A', 'B.seller_id = A.Enrollement_id');	
		$this->db->where(array('B.seller_id' => $seller_id,'A.User_activated' => '1','B.activate' => 'yes','B.id' => $Communication_id));
		$sql = $this->db->get();	
		
		// echo "Query for Seller------".$seller_id."----and Communication id-------".$Communication_id."---------------".$this->db->last_query()."<br>";
		
		return $sql->result_array();		
	}
	
	function Fetch_Merchant_offers2($seller_id,$Communication_id)
	{
		$this->db->select("communication_plan,description");
		$this->db->where(array('seller_id' => $seller_id));
		$this->db->where_in('id', $Communication_id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get('igain_seller_communication');
		// echo $this->db->last_query();
		return $query->result_array();		
	}
	
	function Fetch_Open_Notification_Count($Enrollement_id,$Company_id)
	{
		$this->db->select("*,COUNT(*) AS Open_notify");
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Open_flag' => '0','Active_flag' => '1'));
		$query = $this->db->get('igain_cust_notification');
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	function Fetch_Read_Notification_Count($Enrollement_id,$Company_id)
	{
		$this->db->select("*,COUNT(*) AS Read_noty");
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Open_flag' => '1','Active_flag' => '1'));
		$query = $this->db->get('igain_cust_notification');
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	function Fetch_All_Notification_Count($Enrollement_id,$Company_id)
	{
		$this->db->select("*,COUNT(*) AS All_noty");
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Active_flag' => '1'));
		$query = $this->db->get('igain_cust_notification');
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	function FetchNotificationDetails($Enrollement_id,$Company_id)
	{
		$this->db->select("*");
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Open_flag' => '0','Active_flag' => '1'));		
		$this->db->order_by('igain_cust_notification.id', 'DESC');
		$this->db->limit('5');
		$query = $this->db->get('igain_cust_notification');
		return $query->result_array();
	}
	function Fetch_Open_Notification_Details($limit,$start,$Enrollement_id,$Company_id)
	{
		$this->db->select('igain_cust_notification.Id,igain_cust_notification.Seller_id,igain_cust_notification.Customer_id,igain_cust_notification.User_email_id,igain_cust_notification.Communication_id,igain_cust_notification.Offer,igain_cust_notification.Offer_description,igain_cust_notification.Open_flag,igain_cust_notification.Date,igain_enrollment_master.Enrollement_id,igain_enrollment_master.First_name,igain_enrollment_master.Middle_name,igain_enrollment_master.Last_name,igain_company_master.Company_name');
		$this->db->from('igain_cust_notification');
		$this->db->join('igain_enrollment_master', 'igain_cust_notification.Customer_id = igain_enrollment_master.Enrollement_id');
		// $this->db->join('igain_enrollment_master', 'igain_cust_notification.Seller_id = igain_enrollment_master.Enrollement_id');
		$this->db->join('igain_company_master','igain_cust_notification.Company_id = igain_company_master.Company_id');
		$this->db->where(array('igain_cust_notification.Customer_id' => $Enrollement_id,'igain_cust_notification.Company_id' => $Company_id,'igain_cust_notification.Open_flag' => '0','igain_cust_notification.Active_flag' => '1'));
		$this->db->limit($limit,$start);
		$this->db->order_by('igain_cust_notification.id','DESC');
		$query = $this->db->get();
		return $query->result_array();
	}
	function Fetch_Read_Notifications_Details($limit,$start,$Enrollement_id,$Company_id)
	{
		$this->db->select('igain_cust_notification.Id,igain_cust_notification.Seller_id,igain_cust_notification.Customer_id,igain_cust_notification.User_email_id,igain_cust_notification.Communication_id,igain_cust_notification.Offer,igain_cust_notification.Offer_description,igain_cust_notification.Open_flag,igain_cust_notification.Date,igain_enrollment_master.Enrollement_id,igain_enrollment_master.First_name,igain_enrollment_master.Middle_name,igain_enrollment_master.Last_name,igain_company_master.Company_name');
		$this->db->from('igain_cust_notification');
		$this->db->join('igain_enrollment_master','igain_cust_notification.Customer_id = igain_enrollment_master.Enrollement_id');
		// $this->db->join('igain_enrollment_master','igain_cust_notification.Seller_id = igain_enrollment_master.Enrollement_id');
		$this->db->join('igain_company_master','igain_cust_notification.Company_id = igain_company_master.Company_id');
		$this->db->where(array('igain_cust_notification.Customer_id' => $Enrollement_id,'igain_cust_notification.Company_id' => $Company_id,'igain_cust_notification.Open_flag' => '1','igain_cust_notification.Active_flag' => '1'));
		$this->db->limit($limit,$start);
		$this->db->order_by('igain_cust_notification.id','DESC');		
		$query = $this->db->get();
		return $query->result_array();
	}
	function Fetch_All_Read_NotificationDetails($limit,$start,$Enrollement_id,$Company_id)
	{
		$this->db->select('igain_cust_notification.Id,igain_cust_notification.Seller_id,igain_cust_notification.Customer_id,igain_cust_notification.User_email_id,igain_cust_notification.Communication_id,igain_cust_notification.Offer,igain_cust_notification.Offer_description,igain_cust_notification.Open_flag,igain_cust_notification.Date,igain_enrollment_master.Enrollement_id,igain_enrollment_master.First_name,igain_enrollment_master.Middle_name,igain_enrollment_master.Last_name,igain_company_master.Company_name');
		$this->db->from('igain_cust_notification');
		$this->db->join('igain_enrollment_master', 'igain_cust_notification.Customer_id = igain_enrollment_master.Enrollement_id');
		// $this->db->join('igain_enrollment_master', 'igain_cust_notification.Seller_id = igain_enrollment_master.Enrollement_id');
		$this->db->join('igain_company_master','igain_cust_notification.Company_id = igain_company_master.Company_id');
		$this->db->where(array('igain_cust_notification.Customer_id' => $Enrollement_id,'igain_cust_notification.Company_id' => $Company_id,'igain_cust_notification.Active_flag' => '1'));
		$this->db->limit($limit,$start);
		$this->db->order_by('igain_cust_notification.id','DESC');
		$query = $this->db->get();
		return $query->result_array();
	}	
	function FetchMerchandiseProduct($Company_id)
	{
		$this->db->select("*");
		$this->db->where(array('Company_id' => $Company_id));
		$this->db->order_by('igain_company_merchandise_catalogue.Company_merchandise_item_id', 'DESC');
		$this->db->limit('5');
		$Merchandise = $this->db->get('igain_company_merchandise_catalogue');		
		return $Merchandise->result_array();
		
	}
	function Fetch_Merchandise_Product_Category($Company_id)
	{
		
		$this->db->select("*");
		$this->db->order_by('Merchandize_category_name', 'ASC');
		$query = $this->db->get('igain_merchandize_category');
		return $query->result_array();
		
	}
	public function update_profile($post_data,$Enrollement_id)
	{
		$this->db->trans_start();
		$this->db->where('Enrollement_id', $Enrollement_id);
		$this->db->update('igain_enrollment_master', $post_data);
		$this->db->trans_complete();
		if ($this->db->affected_rows() == '1') {
			return TRUE;
		} else {
			if ($this->db->trans_status() === FALSE) {
				return false;
			}
			return true;
		}
		
	}
	public function update_promocode($post_data,$promo_code,$Company_id,$Enrollment_id,$Current_balance,$membership_id,$lv_date_time)
	{
		
		$Promocode_Details=$this->Igain_model->get_promocode_details($promo_code,$Company_id);
		$Promo_code=$Promocode_Details->Promo_code;					
		$PromocodePoints=$Promocode_Details->Points;					
		$Total_Current_Balance=$Current_balance + $PromocodePoints;
		
		$Enrollment_Details=$this->Igain_model->get_enrollment_details($Enrollment_id);
		$Topup_amt=$Enrollment_Details->Total_topup_amt;
		$Total_Topup_Amount=$Topup_amt+$PromocodePoints;
		
		$this->db->where(array('Company_id' => $Company_id,'Promo_code'=>$promo_code,'Promo_code_status	' => '0','Active_flag	' => '1'));
		$this->db->update('igain_promo_campaign_child', $post_data); 
		if($this->db->affected_rows() > 0)
		{			
			
			$data['Company_id'] = $Company_id;			
			$data['Trans_type'] = '7';
			$data['Topup_amount'] = $PromocodePoints;			
			// $data['Loyalty_pts'] = $PromocodePoints;			
			$data['Trans_date'] = $lv_date_time;			
			$data['Enrollement_id'] = $Enrollment_id;			
			$data['Card_id'] = $membership_id;
			$data['Remarks'] = 'Promo Code Points';			
			$data['remark2'] = 'PromoCode Transaction-('.$promo_code.')';			
			$this->db->insert('igain_transaction', $data);			
			
			$data1=array('Current_balance' => $Total_Current_Balance,'Total_topup_amt' => $Total_Topup_Amount );
			$this->db->where(array('Company_id' => $Company_id,'Enrollement_id' => $Enrollment_id));
			$this->db->update('igain_enrollment_master',$data1);	
			if($this->db->affected_rows() > 0)
			{ 
				return true;
			}
		
		}
	}
		
	function get_promocode_details($promo_code,$Company_id)
	{
		$today=date('Y-m-d');
		
		/* $this->db->select(" PC.*,PM.From_date,PM.From_date,PM.To_date ");
		$this->db->from('igain_promo_campaign_child AS PC');
		$this->db->where(array('PC.Company_id' => $Company_id,'PC.Promo_code'=>$promo_code,'PC.Promo_code_status' => '0','PC.Active_flag' => '1'));
		$this->db->where(" '".$today."' BETWEEN PM.From_date AND PM.To_date ");
		$this->db->join('igain_promo_campaign AS PM', 'PC.Campaign_id = PM.Campaign_id');
		$sql = $this->db->get(); */
		
		$query = "SELECT PC.*,P.From_date,P.From_date,P.To_date FROM igain_promo_campaign_child AS PC JOIN igain_promo_campaign as P ON PC.Campaign_id = P.Campaign_id WHERE PC.Active_flag = '1' AND PC.Company_id = '".$Company_id."' AND BINARY PC.Promo_code = '".$promo_code."'  AND PC.Promo_code_status= '0' AND '".$today."' BETWEEN P.From_date AND P.To_date";	
				// $query = $this->db->query($sql);
		
		// $sql = $this->db->get($sql);
		$sql = $this->db->query($query);
		
		
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
	function get_super_seller_details($Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id,'Super_seller'=>'1','User_id	' => '2','User_activated' => '1'));
		
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
	function FetchCompanyAuction($Company_id,$today)
	{
		$this->db->select(" * ");		
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' =>'1'));	
		$this->db->where("'".$today."' BETWEEN From_date AND To_date");
		
		$this->db->order_by('Auction_id', 'DESC');
		$query = $this->db->get('igain_auction_master');
		$query->result_array();
		$sql_result = $query->result_array();
		 
		
		
		return $query->result_array();
	}
	
	function get_auction_details($Auction_id)
	{
		$this->db->select("*");
		$this->db->from('igain_auction_master');
		$this->db->where('Auction_id', $Auction_id);
		
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
	
	function FetchAuctionBidder($Auction_id,$Company_id)
	{
		$this->db->select("COUNT(Enrollement_id) as TotalBid");
		$this->db->where(array('Company_id' => $Company_id,'Auction_id' => $Auction_id,'igain_auction_winner.Winner_flag' => 0,'igain_auction_winner.Active_flag' => 0));		
		$query = $this->db->get('igain_auction_winner');
		return $query->result_array();
	}
	
	function FetchMerchantOffers($Company_id)
	{
		$this->db->select("igain_loyalty_master.Loyalty_name,Loyalty_at_transaction");		
		$this->db->where(array('igain_loyalty_master.Company_id' => $Company_id));
		$this->db->join('igain_enrollment_master', 'igain_loyalty_master.Seller = igain_enrollment_master.Enrollement_id');
		$this->db->order_by('igain_loyalty_master.Loyalty_id', 'DESC');
		$query = $this->db->get('igain_loyalty_master');
		return $query->result_array();
		
	}
	function Fetch_Merchant_Loyalty_Offers($Enrollment_id,$Company_id)
	{
		$today=date('Y-m-d');
		$this->db->select("a.* , b.Tier_name");
		$this->db->from('igain_loyalty_master as a');
		$this->db->join('igain_tier_master as b', 'a.Tier_id = b.Tier_id','LEFT');
		$this->db->where(array('a.Company_id' => $Company_id,'a.Seller' => $Enrollment_id,'a.Active_flag' => '1'));
		$this->db->where(" '".$today."' BETWEEN From_date AND Till_date ");
		$this->db->order_by('a.Loyalty_id','DESC');
		$queryMe = $this->db->get();	
		
		return $queryMe->result_array(); 
		
	}
	function FetchMerchantCommunicationDetails($Enrollment_id)
	{
		$today=date('Y-m-d');
		$this->db->select("*");
		$this->db->where(array('seller_id'=>$Enrollment_id,'Link_to_lbs	'=>1,'Comm_type'=>0,'activate'=>'yes'));
		$this->db->where(" '".$today."' BETWEEN From_date AND Till_date ");
		$this->db->order_by('id','DESC');
		$query = $this->db->get('igain_seller_communication');
		// echo $this->db->last_query()."<br>";
		return $query->result_array(); 
		
	}
	function Fetch_Merchant_SMS_Communication_Details($Enrollment_id)
	{
		$today=date('Y-m-d');
		$this->db->select("*");
		$this->db->where(array('seller_id'=>$Enrollment_id,'Link_to_lbs'=>1,'Comm_type'=>1,'activate'=>'yes'));
		$this->db->where(" '".$today."' BETWEEN From_date AND Till_date ");
		$this->db->order_by('id','DESC');
		$query = $this->db->get('igain_seller_communication');
		// echo $this->db->last_query()."<br>";
		return $query->result_array(); 
		
	}
	public function Insert_company_SMS_Notification($Insert_data)
	{
		$this->db->insert('igain_cust_sms_notification', $Insert_data);		
		// echo $this->db->last_query()."<br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	function Check_SMS_Notification($gv_log_compid,$Cust_enrollement_id,$Seller_id,$entry_date,$commdtlsid)
	{
		$entry_date1=$entry_date." 23:59:59";
		$q =  $this->db->select(' * ')
				   ->from('igain_cust_sms_notification')
				   ->where("  Sent_Date BETWEEN '".$entry_date."' AND '".$entry_date1."' ")
				   ->where(array('Customer_id' => $Cust_enrollement_id,'Company_id' => $gv_log_compid,'Seller_id' => $Seller_id,'Communication_id' => $commdtlsid))->get();
		return $q->num_rows();	 
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
	function FetchNotifications($Notify)
	{
		$this->db->select("*");
		$this->db->where(array('id' => $Notify));
		$this->db->join('igain_company_master', 'igain_cust_notification.Company_id	 = igain_company_master.Company_id');
		$query = $this->db->get('igain_cust_notification');
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
		
	}
	public function Update_Notification($post_data,$Note_id)
	{
		$this->db->where('Id', $Note_id);
		$this->db->update('igain_cust_notification', $post_data); 
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	
	public function delete_notification($NoteId)
	{
		/* $this->db->where('Id', $NoteId);
		$this->db->delete('igain_cust_notification');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  */
		
		
		 $data = array(
					'Active_flag' => 0
				);
		$this->db->where(array('Id' => $NoteId));
		$this->db->update("igain_cust_notification", $data);
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
	function Fetch_TransactionTypes_details()
	{
		 $this->db->select("*");
		 $this->db->where_not_in('Trans_type_id ',array(5,6,23,16));
		 // $this->db->where_not_in('Trans_type_id ','6');
		$query = $this->db->get('igain_transaction_type');
		return $query->result_array(); 
		
	}
	
	function Fetch_Transaction_Detail_Reports($Company_id,$startDate,$endDate,$Merchant,$Trans_Type,$Report_type,$Enrollment_id,$membership_id,$Redeemption_report,$start,$limit)
	{
		$startDate=date('Y-m-d',strtotime($startDate));
		$endDate=date('Y-m-d',strtotime($endDate));	
			
		if($Redeemption_report==1)
		{
			if($Report_type=='0')
			{ 
				$this->db->select("igain_transaction_type.Trans_type AS TransactionType,igain_transaction.Trans_date AS TransactionDate,igain_transaction.Quantity AS TotalQuantity,(igain_transaction.Redeem_points * igain_transaction.Quantity) AS TotalItemRedeemPoints ,igain_transaction.Voucher_no AS VoucherNo,igain_transaction.Voucher_status AS VoucherStatus,igain_transaction.Item_code AS Item,Merchandize_item_name AS ItemName,Item_size,Shipping_points");
				 $this->db->from('igain_transaction');
				 $this->db->where('igain_transaction.Trans_date >=', $startDate);
				 $this->db->where('igain_transaction.Trans_date <=', $endDate);
				 $this->db->where('igain_transaction.Company_id ', $Company_id);
				 $this->db->where('igain_company_merchandise_catalogue.Company_id ', $Company_id);
				 $this->db->where('igain_transaction.Trans_type=10');
				 $this->db->where('igain_transaction.Enrollement_id', $Enrollment_id);
				 $this->db->where('igain_transaction.Card_id', $membership_id);
				 $this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
				 $this->db->join('igain_company_merchandise_catalogue', 'igain_transaction.Item_code = igain_company_merchandise_catalogue.Company_merchandize_item_code AND igain_transaction.Company_id = igain_company_merchandise_catalogue.Company_id');
				 $this->db->order_by('igain_transaction.Trans_id', 'DESC');
				 $this->db->order_by('igain_transaction.Trans_date', 'DESC');
				 // $this->db->group_by('igain_transaction.Item_code');     
				 // $this->db->group_by('igain_transaction.Voucher_no');
				 if($limit != "" || $start != "" ){
					 
					 $this->db->limit($limit,$start);  
				 }
				   
				 $query = $this->db->get();
				if ($query->num_rows() > 0)
				{
					
					foreach ($query->result() as $row)
					{
						if($row->TransactionType=="" ){$row->TransactionType='-';}else{ $row->TransactionType=$row->TransactionType;}									
						if($row->TransactionDate=="" ){$row->TransactionDate='-';}else{ $row->TransactionDate=$row->TransactionDate;}
						if($row->TotalQuantity==0 ){$row->TotalQuantity='-';}else{ $row->TotalQuantity=$row->TotalQuantity;}
						
						if($row->TotalItemRedeemPoints==0 ){$row->TotalItemRedeemPoints='-';}else{$row->TotalItemRedeemPoints=$row->TotalItemRedeemPoints;}								
						if($row->VoucherNo=="" ){$row->VoucherNo='-';}else{ $row->VoucherNo=$row->VoucherNo;}
						if($row->Item=="" ){$row->Item='-';}else{ $row->Item=$row->Item;}
						if($row->Remarks=="" ){$row->Remarks='-';}else{ $row->Remarks=$row->Remarks;}
						if($row->ItemName=="" ){$row->ItemName='-';}else{ $row->ItemName=$row->ItemName;}
						if($row->VoucherStatus==30 ){$row->VoucherStatus='Issued';}elseif($row->VoucherStatus==31 ){$row->VoucherStatus='Used';}elseif($row->VoucherStatus==18 ){$row->VoucherStatus='Ordered';}elseif($row->VoucherStatus==19 ){$row->VoucherStatus='Shipped';}elseif($row->VoucherStatus==20 ){$row->VoucherStatus='Delivered';}elseif($row->VoucherStatus==21 ){$row->VoucherStatus='Cancel';}elseif($row->VoucherStatus==22 ){$row->VoucherStatus='Return Initiated';}elseif($row->VoucherStatus==23 ){$row->VoucherStatus='Returned';}else{$row->VoucherStatus='Expired';}
						if($row->Shipping_points==0 ){$row->Shipping_points='-';}else{ $row->Shipping_points=$row->Shipping_points;}
						
						if($row->Item_size==0) { $row->Item_size="-"; } elseif($row->Item_size==1) { $row->Item_size="Small"; } elseif($row->Item_size==2) { $row->Item_size="Medium"; } elseif($row->Item_size==3) { $row->Item_size="large"; } elseif($row->Item_size==4) { $row->Item_size="Extra large"; }
						
						$data[] = $row;
						
					}
					return $data;
				}
					
					
				
			}
			else
			{
				// echo "----Redeemption_report-----".$Redeemption_report."--<br>"; 
					$this->db->select("igain_transaction_type.Trans_type  AS TransactionType,SUM(igain_transaction.Redeem_points * igain_transaction.Quantity) AS TotalItemRedeemPoints,SUM(igain_transaction.Shipping_points) AS TotalShippingpoints,SUM(igain_transaction.Quantity) AS TotalQuantity");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					$this->db->where('igain_transaction.Trans_type=10 ');
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					if($limit != "" || $start != "" ){
					 
					 $this->db->limit($limit,$start);  
					}
					$query = $this->db->get();					
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->TransactionType=="" ){$row->TransactionType='-';}else{ $row->TransactionType=$row->TransactionType;}					
							if($row->TotalItemRedeemPoints=="" ){$row->TotalItemRedeemPoints='-';}else{ $row->TotalItemRedeemPoints=$row->TotalItemRedeemPoints;}
							if($row->TotalQuantity==0 ){$row->TotalQuantity='-';}else{ $row->TotalQuantity=$row->TotalQuantity;}
							if($row->TotalShippingpoints==0 ){$row->TotalShippingpoints='-';}else{ $row->TotalShippingpoints=$row->TotalShippingpoints;}
							$data[] = $row;
							
						}
						return $data;
					}
				
			}
		}
		else
		{    
			if($Report_type=='0') //details
			{ 
				if($Merchant == '0' && $Trans_Type == '0' )
				{  
					// echo"here.........";
					$this->db->select("igain_transaction.Trans_date AS TransactionDate,igain_transaction.Bill_no AS BillNo,igain_transaction.Manual_billno AS Manual_billno,igain_transaction_type.Trans_type AS TransactionType,igain_transaction.Item_code as Item_name,Item_size,Quantity,sum(igain_transaction.Purchase_amount) AS PurchaseAmount,sum(igain_transaction.Paid_amount) AS Paid_amount,sum(igain_transaction.Shipping_cost) as Shipping_cost,igain_transaction.Topup_amount AS BounsPoints,SUM(igain_transaction.Redeem_points) AS RedeemPoints,SUM(igain_transaction.Loyalty_pts) AS GainPoints,igain_transaction.Seller_name AS DoneBy,igain_transaction.Transfer_points AS TransferPoints,igain_transaction.Card_id2 as TransferToFrom,igain_transaction.Remarks as Remarks");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					// $this->db->where('igain_transaction.Trans_type != 10 ');
					$this->db->where_not_in('igain_transaction.Trans_type ',array(10,5,6,23,16));
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					$this->db->order_by('igain_transaction.Trans_id', 'DESC');
					$this->db->group_by("igain_transaction.Bill_no");
					if($limit != "" || $start != "" ){
					 
						$this->db->limit($limit,$start);  
					}
					$query = $this->db->get();
					// echo $this->db->last_query(); 
					
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->BillNo==0 ){$row->BillNo='-';}else{ $row->BillNo=$row->BillNo;}									
							if($row->PurchaseAmount==0 ){$row->PurchaseAmount='-';}else{ $row->PurchaseAmount=$row->PurchaseAmount;}
							if($row->BounsPoints==0 ){$row->BounsPoints='-';}else{ $row->BounsPoints=$row->BounsPoints;}
							if($row->RedeemPoints==0 ){$row->RedeemPoints='-';}else{$row->RedeemPoints=$row->RedeemPoints;}								
							if($row->GainPoints==0 ){$row->GainPoints='-';}else{ $row->GainPoints=$row->GainPoints;}
							if($row->DoneBy!="" ){ $row->DoneBy=$row->DoneBy; }else { $row->DoneBy='-';}
							if($row->TransferPoints==0 ){$row->TransferPoints='-';}else{ $row->TransferPoints=$row->TransferPoints;}
							if($row->Remarks=="" ){$row->Remarks='-';}else{ $row->Remarks=$row->Remarks;}
							if($row->TransferToFrom=='0' ){$row->TransferToFrom='-';}else{ $row->TransferToFrom=$row->TransferToFrom;}
							if($row->Shipping_cost==0 ){$row->Shipping_cost='-';}else{ $row->Shipping_cost=$row->Shipping_cost;}
							
							if($row->TransactionType=="Online Purchase")
							{
								$item_details = $this->Igain_model->get_item($Company_id,$row->Item_name);	
									
								$ItemNAME = $item_details->Merchandize_item_name;
								$row->Item_name=$ItemNAME;
							}
							else
							{	
								$row->Item_name="-";
							}
							
							
							if($row->Item_size==0) { $row->Item_size="-"; } elseif($row->Item_size==1) { $row->Item_size="Small"; } elseif($row->Item_size==2) { $row->Item_size="Medium"; } elseif($row->Item_size==3) { $row->Item_size="large"; } elseif($row->Item_size==4) { $row->Item_size="Extra large"; }
							
							if($row->Quantity==0)
							{
								$row->Quantity="-";
							}
							else
							{
								$row->Quantity=$row->Quantity;
							}
							
							$data[] = $row;
							
						}
						return $data;
					}					
				}
				else if( $Merchant != '0' && $Trans_Type == '0' )
				{
					$this->db->select("igain_transaction.Trans_date AS TransactionDate,igain_transaction.Bill_no AS BillNo,igain_transaction.Manual_billno AS Manual_billno,igain_transaction_type.Trans_type AS TransactionType,igain_transaction.Item_code as Item_name,Item_size,Quantity,sum(igain_transaction.Purchase_amount) AS PurchaseAmount,sum(igain_transaction.Paid_amount) AS Paid_amount,sum(igain_transaction.Shipping_cost) as Shipping_cost,igain_transaction.Topup_amount AS BounsPoints,SUM(igain_transaction.Redeem_points) AS RedeemPoints,SUM(igain_transaction.Loyalty_pts) AS GainPoints,igain_transaction.Seller_name AS DoneBy,igain_transaction.Transfer_points AS TransferPoints,igain_transaction.Card_id2 as TransferToFrom,igain_transaction.Remarks as Remarks,igain_transaction.Mpesa_TransID as Mpesa_TransID,igain_transaction.Mpesa_Paid_Amount as Mpesa_Paid_Amount,igain_transaction_type.Trans_type_id AS TransactionTypeID");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					// $this->db->where('igain_transaction.Trans_type != 10 ');
					$this->db->where_not_in('igain_transaction.Trans_type ',array(10,5,6,23,16));
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					$this->db->where('igain_transaction.Seller ', $Merchant);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					$this->db->order_by('igain_transaction.Trans_id', 'DESC');
					$this->db->group_by("igain_transaction.Bill_no");
					if($limit != "" || $start != "" ){
					 
						$this->db->limit($limit,$start);  
					}
					$query = $this->db->get();
					
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->BillNo==0 ){$row->BillNo='-';}else{ $row->BillNo=$row->BillNo;}									
							if($row->PurchaseAmount==0 ){$row->PurchaseAmount='-';}else{ $row->PurchaseAmount=$row->PurchaseAmount;}
							if($row->BounsPoints==0 ){$row->BounsPoints='-';}else{ $row->BounsPoints=$row->BounsPoints;}
							if($row->RedeemPoints==0 ){$row->RedeemPoints='-';}else{$row->RedeemPoints=$row->RedeemPoints;}								
							if($row->GainPoints==0 ){$row->GainPoints='-';}else{ $row->GainPoints=$row->GainPoints;}
							if($row->DoneBy!="" ){ $row->DoneBy=$row->DoneBy; }else { $row->DoneBy='-';}
							if($row->TransferPoints==0 ){$row->TransferPoints='-';}else{ $row->TransferPoints=$row->TransferPoints;}
							if($row->Remarks=="" ){$row->Remarks='-';}else{ $row->Remarks=$row->Remarks;}
							if($row->TransferToFrom=='0' ){$row->TransferToFrom='-';}else{ $row->TransferToFrom=$row->TransferToFrom;}
							if($row->Shipping_cost==0 ){$row->Shipping_cost='-';}else{ $row->Shipping_cost=$row->Shipping_cost;}
							
								if($row->TransactionType=="Online Purchase")
							{
								$item_details = $this->Igain_model->get_item($Company_id,$row->Item_name);	
									
								$ItemNAME = $item_details->Merchandize_item_name;
								$row->Item_name=$ItemNAME;
							}
							else
							{	
								$row->Item_name="-";
							}
							
							if($row->Item_size==0) { $row->Item_size="-"; } elseif($row->Item_size==1) { $row->Item_size="Small"; } elseif($row->Item_size==2) { $row->Item_size="Medium"; } elseif($row->Item_size==3) { $row->Item_size="large"; } elseif($row->Item_size==4) { $row->Item_size="Extra large"; }
							
							if($row->Quantity==0)
							{
								$row->Quantity="-";
							}
							else
							{
								$row->Quantity=$row->Quantity;
							}
							
							$data[] = $row;
							
						}
						return $data;
					}
				}
				else
				{ 
					$this->db->select("igain_transaction.Trans_date AS TransactionDate,igain_transaction.Bill_no AS BillNo,igain_transaction.Manual_billno AS Manual_billno,igain_transaction_type.Trans_type AS TransactionType,igain_transaction.Item_code as Item_name,Item_size,Quantity,sum(igain_transaction.Purchase_amount) AS PurchaseAmount,sum(igain_transaction.Paid_amount) AS Paid_amount,sum(igain_transaction.Shipping_cost) as Shipping_cost,igain_transaction.Topup_amount AS BounsPoints,SUM(igain_transaction.Redeem_points) AS RedeemPoints,SUM(igain_transaction.Loyalty_pts) AS GainPoints,igain_transaction.Seller_name AS DoneBy,igain_transaction.Transfer_points AS TransferPoints,igain_transaction.Card_id2 as TransferToFrom,igain_transaction.Remarks as Remarks,igain_transaction.Mpesa_TransID as Mpesa_TransID,igain_transaction.Mpesa_Paid_Amount as Mpesa_Paid_Amount,igain_transaction_type.Trans_type_id AS TransactionTypeID");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					// $this->db->where('igain_transaction.Trans_type != 10 ');
					$this->db->where_not_in('igain_transaction.Trans_type ',array(10,5,6,23,16));
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					// $this->db->where('igain_transaction.Seller ', $Merchant);
					$this->db->where('igain_transaction.Trans_type ', $Trans_Type);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					$this->db->order_by('igain_transaction.Trans_id', 'DESC');
					$this->db->group_by("igain_transaction.Bill_no");
					if($limit != "" || $start != "" ){
					 
						$this->db->limit($limit,$start);  
					}
					$query = $this->db->get();
					
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->BillNo==0 ){$row->BillNo='-';}else{ $row->BillNo=$row->BillNo;}									
							if($row->PurchaseAmount==0 ){$row->PurchaseAmount='-';}else{ $row->PurchaseAmount=$row->PurchaseAmount;}
							if($row->BounsPoints==0 ){$row->BounsPoints='-';}else{ $row->BounsPoints=$row->BounsPoints;}
							if($row->RedeemPoints==0 ){$row->RedeemPoints='-';}else{$row->RedeemPoints=$row->RedeemPoints;}								
							if($row->GainPoints==0 ){$row->GainPoints='-';}else{ $row->GainPoints=$row->GainPoints;}
							if($row->DoneBy!="" ){ $row->DoneBy=$row->DoneBy; }else { $row->DoneBy='-';}
							if($row->TransferPoints==0 ){$row->TransferPoints='-';}else{ $row->TransferPoints=$row->TransferPoints;}
							if($row->Remarks=="" ){$row->Remarks='-';}else{ $row->Remarks=$row->Remarks;}
							if($row->TransferToFrom=='0' ){$row->TransferToFrom='-';}else{ $row->TransferToFrom=$row->TransferToFrom;}
							if($row->Shipping_cost==0 ){$row->Shipping_cost='-';}else{ $row->Shipping_cost=$row->Shipping_cost;}
							
							if($row->TransactionType=="Online Purchase")
							{
								$item_details = $this->Igain_model->get_item($Company_id,$row->Item_name);	
									
								$ItemNAME = $item_details->Merchandize_item_name;
								$row->Item_name=$ItemNAME;
							}
							else
							{	
								$row->Item_name="-";
							}
							
							if($row->Item_size==0) { $row->Item_size="-"; } elseif($row->Item_size==1) { $row->Item_size="Small"; } elseif($row->Item_size==2) { $row->Item_size="Medium"; } elseif($row->Item_size==3) { $row->Item_size="large"; } elseif($row->Item_size==4) { $row->Item_size="Extra large"; }
							
							if($row->Quantity==0)
							{
								$row->Quantity="-";
							}
							else
							{
								$row->Quantity=$row->Quantity;
							}
							
							$data[] = $row;
							
						}
						return $data;
					}
				}
			}			
			else //summary
			{
				if($Merchant == '0' && $Trans_Type == '0' )
				{
					$this->db->select("igain_transaction_type.Trans_type  AS TransactionType,sum(igain_transaction.Purchase_amount) AS TotalPurchaseAmount,sum(igain_transaction.Topup_amount) AS TotalBonusPoints,sum(igain_transaction.Redeem_points) AS TotalRedeemPoints ,sum(igain_transaction.Loyalty_pts) AS TotalGainPoints,sum(igain_transaction.Transfer_points) AS TotalTransPoints,sum(igain_transaction.Shipping_cost) AS TotalShippingCost,igain_transaction_type.Trans_type_id AS TransactionTypeID");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					// $this->db->where('igain_transaction.Trans_type != 10 ');
					$this->db->where_not_in('igain_transaction.Trans_type ',array(10,5,6,23,16));
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					$this->db->group_by('igain_transaction.Trans_type'); 
					if($limit != "" || $start != "" ){
					 
						$this->db->limit($limit,$start);  
					}
					$query = $this->db->get();
					
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->TransactionType=="" ){$row->TransactionType='-';}else{ $row->TransactionType=$row->TransactionType;}
							if($row->TotalPurchaseAmount==0 ){$row->TotalPurchaseAmount='-';}else{ $row->TotalPurchaseAmount=$row->TotalPurchaseAmount;}
							if($row->TotalBonusPoints==0 ){$row->TotalBonusPoints='-';}else{ $row->TotalBonusPoints=$row->TotalBonusPoints;}
							if($row->TotalRedeemPoints==0 ){$row->TotalRedeemPoints='-';}else{$row->TotalRedeemPoints=$row->TotalRedeemPoints;}	
							if($row->TotalGainPoints==0 ){$row->TotalGainPoints='-';}else{ $row->TotalGainPoints=$row->TotalGainPoints;}
							if($row->TotalTransPoints==0 ){$row->TotalTransPoints='-';}else {$row->TotalTransPoints=$row->TotalTransPoints;}
							// if($row->Shipping_cost==0 ){$row->Shipping_cost='-';}else{ $row->Shipping_cost=$row->Shipping_cost;}
							if($row->TotalShippingCost==0 ){$row->TotalShippingCost='-';}else {$row->TotalShippingCost=$row->TotalShippingCost;}
							
							$data[] = $row;
							
						}
						return $data;
					}
					
					
				}
				else if( $Merchant != '0' && $Trans_Type == '0' )
				{ 
					$this->db->select("igain_transaction_type.Trans_type  AS TransactionType,sum(igain_transaction.Purchase_amount) AS TotalPurchaseAmount,sum(igain_transaction.Topup_amount) AS TotalBonusPoints,sum(igain_transaction.Redeem_points) AS TotalRedeemPoints ,sum(igain_transaction.Loyalty_pts) AS TotalGainPoints,sum(igain_transaction.Transfer_points) AS TotalTransPoints,sum(igain_transaction.Shipping_cost) AS TotalShippingCost,igain_transaction_type.Trans_type_id AS TransactionTypeID");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					// $this->db->where('igain_transaction.Trans_type != 10 ');
					$this->db->where_not_in('igain_transaction.Trans_type ',array(10,5,6,23,16));
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					$this->db->where('igain_transaction.Seller ', $Merchant);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					 $this->db->group_by('igain_transaction.Trans_type'); 
					if($limit != "" || $start != "" ){
					 
					 $this->db->limit($limit,$start);  
					}
					$query = $this->db->get();
					// echo $this->db->last_query();
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->TransactionType=="" ){$row->TransactionType='-';}else{ $row->TransactionType=$row->TransactionType;}
							if($row->TotalPurchaseAmount==0 ){$row->TotalPurchaseAmount='-';}else{ $row->TotalPurchaseAmount=$row->TotalPurchaseAmount;}
							if($row->TotalBonusPoints==0 ){$row->TotalBonusPoints='-';}else{ $row->TotalBonusPoints=$row->TotalBonusPoints;}
							if($row->TotalRedeemPoints==0 ){$row->TotalRedeemPoints='-';}else{$row->TotalRedeemPoints=$row->TotalRedeemPoints;}	
							if($row->TotalGainPoints==0 ){$row->TotalGainPoints='-';}else{ $row->TotalGainPoints=$row->TotalGainPoints;}
							if($row->TotalTransPoints==0 ){$row->TotalTransPoints='-';}else {$row->TotalTransPoints=$row->TotalTransPoints;}
							if($row->TotalShippingCost==0 ){$row->TotalShippingCost='-';}else {$row->TotalShippingCost=$row->TotalShippingCost;}

							$data[] = $row;
							
						}
						return $data;
					}
				}
				else
				{
					$this->db->select("igain_transaction_type.Trans_type  AS TransactionType,sum(igain_transaction.Purchase_amount) AS TotalPurchaseAmount,sum(igain_transaction.Topup_amount) AS TotalBonusPoints,sum(igain_transaction.Redeem_points) AS TotalRedeemPoints ,sum(igain_transaction.Loyalty_pts) AS TotalGainPoints,sum(igain_transaction.Transfer_points) AS TotalTransPoints,sum(igain_transaction.Shipping_cost) AS TotalShippingCost,igain_transaction_type.Trans_type_id AS TransactionTypeID");
					$this->db->from('igain_transaction');
					$this->db->where('igain_transaction.Trans_date >=', $startDate);
					$this->db->where('igain_transaction.Trans_date <=', $endDate);
					// $this->db->where('igain_transaction.Trans_type != 10 ');
					$this->db->where_not_in('igain_transaction.Trans_type ',array(10,5,6,23,16));
					$this->db->where('igain_transaction.Company_id ', $Company_id);
					$this->db->where('igain_transaction.Enrollement_id ', $Enrollment_id);
					$this->db->where('igain_transaction.Card_id ', $membership_id);
					// $this->db->where('igain_transaction.Seller ', $Merchant);
					$this->db->where('igain_transaction.Trans_type ', $Trans_Type);
					$this->db->join('igain_transaction_type', 'igain_transaction.Trans_type = igain_transaction_type.Trans_type_id');
					$this->db->group_by('igain_transaction.Trans_type');
					if($limit != "" || $start != "" ){
					 
						$this->db->limit($limit,$start);  
					}					 
					$query = $this->db->get();
					
					if ($query->num_rows() > 0)
					{
						
						foreach ($query->result() as $row)
						{
							if($row->TransactionType=="" ){$row->TransactionType='-';}else{ $row->TransactionType=$row->TransactionType;}
							if($row->TotalPurchaseAmount==0 ){$row->TotalPurchaseAmount='-';}else{ $row->TotalPurchaseAmount=$row->TotalPurchaseAmount;}
							if($row->TotalBonusPoints==0 ){$row->TotalBonusPoints='-';}else{ $row->TotalBonusPoints=$row->TotalBonusPoints;}
							if($row->TotalRedeemPoints==0 ){$row->TotalRedeemPoints='-';}else{$row->TotalRedeemPoints=$row->TotalRedeemPoints;}	
							if($row->TotalGainPoints==0 ){$row->TotalGainPoints='-';}else{ $row->TotalGainPoints=$row->TotalGainPoints;}
							if($row->TotalTransPoints==0 ){$row->TotalTransPoints='-';}else {$row->TotalTransPoints=$row->TotalTransPoints;}
							if($row->TotalShippingCost==0 ){$row->TotalShippingCost='-';}else {$row->TotalShippingCost=$row->TotalShippingCost;}
							
							
							$data[] = $row;
							
						}
						return $data;
					}
				}
			}
		}
	}
	function Fetch_Game_Master_Details()
	{
		$this->db->select("*");
		$query = $this->db->get('igain_game_master');
		return $query->result_array();
	}
	function Auction_Total_Bidder($Auction_id,$Company_id)
	{
		$this->db->select("Id");
		$this->db->from("igain_auction_winner");
		$this->db->where(array('Company_id' => $Company_id,'Auction_id' => $Auction_id,'igain_auction_winner.Winner_flag' => 0,'igain_auction_winner.Active_flag' => 0));		
		$query = $this->db->get();		
		return $query->num_rows();
	}
	function Fetch_TOP3_Company_Auction($Company_id,$today)
	{
		$this->db->limit('5');
		$this->db->select("*");
		$this->db->from("igain_auction_master");
		// $this->db->where(array('Company_id' => $Company_id,'Active_flag' =>'1'));	
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' =>'1'));	
		$this->db->where("'".$today."' BETWEEN From_date AND To_date");
		$query = $this->db->get();		
		return $query->result_array();
		
		// $this->db->where('order_datetime <','2012-10-03');
		// $this->db->where('order_datetime >','2012-10-01');
	}
	function Get_latest_merchandize_items($Company_id,$today)
	{
		$this->db->limit('8');
		$this->db->select("*");
		$this->db->from("igain_company_merchandise_catalogue");
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' =>'1'));	
		$this->db->where("'".$today."' BETWEEN Valid_from AND Valid_till");
		$this->db->order_by('Company_merchandise_item_id', 'DESC');
		$query = $this->db->get();		
		return $query->result_array();
	}
	function Get_latest_merchandize_items_freebies($Company_id,$today,$enroll)
	{
		// $this->db->limit('8');
		$this->db->select("*");
		$this->db->from("igain_transaction AS TR");
		$this->db->join('igain_company_merchandise_catalogue AS CC', 'TR.Item_code = CC.Company_merchandize_item_code');
		$this->db->where(array('TR.Enrollement_id' => $enroll,'TR.Company_id' => $Company_id,'CC.Active_flag' =>'1','TR.Voucher_status' =>'Issued','CC.Link_to_Member_Enrollment_flag' =>'1'));	
		$this->db->where("'".$today."' BETWEEN CC.Valid_from AND CC.Valid_till");
		$this->db->order_by('CC.Company_merchandise_item_id', 'DESC');
		$query = $this->db->get();
		// echo $this->db->last_query();		
		return $query->result_array();
	}
	function Auction_Top_Bidder($Auction_id,$Company_id)
	{
		$this->db->limit('5');
		$this->db->select("Enrollment_id,Bid_value,First_name,Last_name,Photograph");
		$this->db->from("igain_auction_winner");
		$this->db->join('igain_enrollment_master', 'igain_auction_winner.Enrollment_id = igain_enrollment_master.Enrollement_id');
		$this->db->order_by('igain_auction_winner.Bid_value', 'DESC');
		$this->db->where(array('igain_auction_winner.Company_id' => $Company_id,'Auction_id' => $Auction_id,'igain_auction_winner.Winner_flag' => 0,'igain_auction_winner.Active_flag' => 0));	
		
		$query = $this->db->get();
		
		if( $query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	function Auction_Max_Bid_Value($Auction_id,$Company_id)
	{
		$this->db->select_max('Bid_value');
		$this->db->from("igain_auction_winner");
		$this->db->where(array('Company_id' => $Company_id,'Auction_id' => $Auction_id,'igain_auction_winner.Winner_flag' => 0,'igain_auction_winner.Active_flag' => 0));			
		$query = $this->db->get();
		// echo"------last_query-----".$this->db->last_query();
		if( $query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	function Fetch_Auction_Max_Bid_Value($Auction_id,$Company_id)
	{
		$this->db->select('MAX(Bid_value),Min_increment');
		$this->db->from("igain_auction_winner");		
		$this->db->where(array('igain_auction_winner.Company_id' => $Company_id,'igain_auction_winner.Auction_id' => $Auction_id,'igain_auction_winner.Winner_flag' => 0,'igain_auction_winner.Active_flag' => 0));	
		$this->db->join('igain_auction_master', 'igain_auction_winner.Auction_id = igain_auction_master.Auction_id');
		$query = $this->db->get();
		// echo"------last_query-----".$this->db->last_query();
		if( $query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
	
	function insert_auction_bidding($Super_Seller)
    {
		$this->load->model('Igain_model');	
		$email_flag = $this->input->post('email_validity');		
		
		$data['Auction_id'] = $this->input->post('auctionID');
		$data['Company_id'] = $this->input->post('compid');        
		$data['Enrollment_id'] = $this->input->post('custEnrollId');
		$Member_Enrollment_id = $this->input->post('custEnrollId');
		$data['Prize'] = $this->input->post('Prize');
		$data['Bid_value'] = $this->input->post('bidval');
		$data['Create_user_id'] = $this->input->post('custEnrollId');
		$data['Creation_date'] = date('Y-m-d H:i:s');		
		$this->db->insert('igain_auction_winner', $data);
		
		if($this->db->affected_rows() > 0)
		{
				$this->db->select("*");
				$this->db->order_by("Id", "DESC");
				$query = $this->db->get_where('igain_auction_winner', array('Company_id' => $data['Company_id'],'Auction_id' => $data['Auction_id'],'igain_auction_winner.Winner_flag' => 0,'igain_auction_winner.Active_flag' => 0), 1, 1);
				$num_rows = $query->num_rows();
				$result= $query->result(); 
				if($num_rows > 0)
				{
					foreach($result as $row)
					{
						$ID_1= $row->Id;
						$Auction_id_1= $row->Auction_id;
						$Enrollment_id_1 =$row->Enrollment_id;
						$Bid_value_1= $row->Bid_value;
						$Company_id_1= $row->Company_id;
						
					}				
					
					$Auction_details=$this->Igain_model->get_auction_details($Auction_id_1);
					$Auction_name=$Auction_details->Auction_name;
					$To_date=$Auction_details->To_date;
					$Min_increment=$Auction_details->Min_increment;
					$Min_Bid_Value=$Min_increment + $data['Bid_value'];
					
					
					$Enrollment_Details=$this->Igain_model->get_enrollment_details($Enrollment_id_1);
					$User_email_id_1=$Enrollment_Details->User_email_id;
					$First_name_1=$Enrollment_Details->First_name;
					$Last_name_1=$Enrollment_Details->Last_name;
					$User_email_id_1=$Enrollment_Details->User_email_id;
					$BlockedPoints_1=$Enrollment_Details->Blocked_points;
					$TotalBlockPoints_1=$BlockedPoints_1 - $Bid_value_1;
					
					$data1=array('Blocked_points' => $TotalBlockPoints_1 );
					$this->db->where(array('Company_id' => $data['Company_id'],'Enrollement_id' => $Enrollment_id_1));
					$this->db->update('igain_enrollment_master',$data1);
						
					$Enrollment_Details=$this->Igain_model->get_enrollment_details($data['Enrollment_id']);
					$BlockedPoints=$Enrollment_Details->Blocked_points;					
					$TotalBlockPoints=$BlockedPoints + $data['Bid_value'];
					
					$data1=array('Blocked_points' => $TotalBlockPoints );
					$this->db->where(array('Company_id' => $data['Company_id'],'Enrollement_id' => $data['Enrollment_id']));
					$this->db->update('igain_enrollment_master',$data1);
					
					$entry_date = date('Y-m-d');
					
					if($Member_Enrollment_id != $Enrollment_id_1)
					{
						$Email_content = array(
									// 'Pin_No' => $get_pin->pinno,
									'Notification_type' => 'No Longer Highest Bidder',
									'Auction_name' => $Auction_name,
									'Min_Bid_Value' => $Min_Bid_Value,
									'Bid_value_1' => round($Bid_value_1),
									'Template_type' => 'No_longer_bider'
									);
									// print_r($Email_content);
						// $this->Igain_model->insert_cust_notification($cust_notification,'1');
						$this->send_notification->send_Notification_email($Enrollment_id_1,$Email_content,$Super_Seller,$data['Company_id']);
						return true;
					}					
					/* if($this->db->affected_rows() > 0)
					{
						return true;
					}
					 */
					
				}
				else
				{
					
					$Enrollment_Details=$this->Igain_model->get_enrollment_details($data['Enrollment_id']);
					$BlockedPoints=$Enrollment_Details->Blocked_points;					
					$TotalBlockPoints=$BlockedPoints + $data['Bid_value'];
					
					$data1=array('Blocked_points' => $TotalBlockPoints );
					$this->db->where(array('Company_id' => $data['Company_id'],'Enrollement_id' => $data['Enrollment_id']));
					$this->db->update('igain_enrollment_master',$data1);
					
					if($this->db->affected_rows() > 0)
					{
						return true;
					} 
				
				}
				
			return true;	
		}
		
		return false;
    }
	
	function check_promocode($promocode,$Company_id)
	{
		// $this->db->where("Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' "); igain_promo_campaign
		$today=date('Y-m-d');
		
		/* $query =  $this->db->select('PC.Promo_code');
				  $this->db->from('igain_promo_campaign_child AS PC');
				 $this->db->join('igain_promo_campaign as P', 'PC.Campaign_id = P.Campaign_id');
				   $this->db->where(array('PC.Promo_code' => $promocode,'PC.Company_id' => $Company_id,'PC.Active_flag' =>'1','PC.Promo_code_status' => '0'));
				   $this->db->where(" '".$today."' BETWEEN From_date AND To_date ");
				  $query = $this->db->get(); */
				  
				  
				  
				  $sql = "SELECT PC.Promo_code FROM igain_promo_campaign_child AS PC JOIN igain_promo_campaign as P ON PC.Campaign_id = P.Campaign_id WHERE PC.Active_flag = '1' AND PC.Company_id = '".$Company_id."' AND BINARY PC.Promo_code = '".$promocode."'  AND PC.Promo_code_status= '0' AND '".$today."' BETWEEN P.From_date AND P.To_date";	
				$query = $this->db->query($sql);
				  
				  // echo $this->db->last_query();
				 if($query->num_rows() > 0)
				{  
					return $query->row();
				}
			
			
	}
	function Check_EmailID($emailId,$Company_id)
	{
		
		$query =  $this->db->select('User_email_id')
				   ->from('igain_enrollment_master')
				   ->where(array('User_email_id' => $emailId,'User_id' => 1,'Company_id' => $Company_id))->get();
				   
			return $query->num_rows();
	}
	function CheckPhone_number($phoneNo,$Company_id)
	{
		
		$query =  $this->db->select('Phone_no')
				   ->from('igain_enrollment_master')
				   ->where(array('Phone_no' => $phoneNo ,'User_id' => 1,'Company_id' => $Company_id))->get();
				   // echo $this->db->last_query();
			return $query->num_rows();
	}
	function Check_Old_Password($old_Password,$Company_id,$Enrollment_id)
	{
		
		$query = 'SELECT * FROM igain_enrollment_master WHERE BINARY User_pwd = "'.$old_Password.'"  AND Company_id = "'.$Company_id.'" AND Enrollement_id = "'.$Enrollment_id.'" ';		
		// $login_sql = $this->db->get();
		$login_sql = $this->db->query($query);					
		// echo $this->db->last_query();
		return $login_sql->num_rows();
	}
	function Check_Old_Pin($old_pin,$Company_id,$Enrollment_id)
	{
		
		$query =  $this->db->select('pinno')
				   ->from('igain_enrollment_master')
				   ->where(array('pinno' => $old_pin,'Company_id' => $Company_id,'Enrollement_id' =>$Enrollment_id))->get();
			return $query->num_rows();
	}
	
	public function Change_Old_Pin($Company_id,$Enrollment_id,$new_pin)
	{
		$data11=array('pinno' => $new_pin );
		$this->db->where(array('Company_id' => $Company_id,'Enrollement_id' => $Enrollment_id));
		$this->db->update('igain_enrollment_master',$data11);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	public function get_customer_pin($Company_id,$Enrollment_id)
	{
			$this->db->select('pinno');
			$this->db ->from('igain_enrollment_master');
			$this->db->where(array('Enrollement_id' => $Enrollment_id,'Company_id' => $Company_id,'User_id' => 1,'User_activated' => 1));
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
			  return $query->row();
			}
		
	}
	public function Change_Old_Password($old_Password,$Company_id,$Enrollment_id,$new_Password)
	{
		$data1=array('User_pwd' => $new_Password );
		$this->db->where(array('Company_id' => $Company_id,'Enrollement_id' => $Enrollment_id));
		$this->db->update('igain_enrollment_master',$data1);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	public function merchant_item_count()
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		return $this->db->count_all_results();
	}
	
	public function merchant_selected_item_count($Merchandise_Category)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Merchandize_category_id' => $Merchandise_Category));
		return $this->db->count_all_results();
	}
	public function Merchant_Loyalty_Offers_Count($Enrollment_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_loyalty_master');
		$this->db->where(array('Company_id' => $Company_id,'Seller' => $Enrollment_id,'Active_flag' =>'1'));
		return $this->db->count_all_results(); 
		
	}
	public function merchant_item_list($limit,$start)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->limit($limit,$start);
		$this->db->order_by('Company_merchandise_item_id','ASC');
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
   public function merchant_selected_item_list($MerchandiseCatId,$limit,$start)
  {
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Merchandize_category_id' => $MerchandiseCatId));	
		$this->db->limit($limit,$start);
		$this->db->order_by('Company_merchandise_item_id','ASC');
		$query = $this->db->get();

        if( $query->num_rows() > 0)
		{
			return $query->result_array();
		}
        return false;
   }
   public function forgot_email_notification($email,$Company_id)
	{
		
        $this->db->select('User_pwd,Enrollement_id,User_id');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' => $Company_id,'User_email_id' => $email, 'User_id' =>1));	
		$query = $this->db->get();
		
        if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
   }
   function insert_cust_notification($data,$insert_flag)
    {
		// var_dump( $data);
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
	
	public function Insert_servey_response($Company_id,$Enrollment_id,$Question_id,$Response_type,$response)
	{	
			if($Response_type=='1')
			{	
				$data1=array('Enrollment_id' => $Enrollment_id,'Company_id' => $Company_id,'Question_id' => $Question_id,'Response2' => $response);
			}
			else
			{
				$data1=array('Enrollment_id' => $Enrollment_id,'Company_id' => $Company_id,'Question_id' => $Question_id,'Response1' => $response);
			}
			
			$this->db->insert('igain_response_master', $data1);
			if($this->db->affected_rows() > 0)
			{
				return $this->db->affected_rows();
			}
		
		
	}
	public function Update_servey_response($Company_id,$Enrollment_id,$Question_id,$Response_type,$response,$Responce_id1)
	{	
	
				// echo"---Response_type-----". $Response_type."<br>";
			if($Response_type=='1')
			{	
				// echo"---Responce_id1-----". $Responce_id1."<br>";
				$data1=array('Response2' => $response);
			}
			else
			{
				$data1=array('Response1' => $response);
			}
			$this->db->where(array('Response_id' => $Responce_id1,'Company_id' => $Company_id,'Enrollment_id' => $Enrollment_id,'Question_id' => $Question_id));
			// echo $this->db->last_query();
			$this->db->update('igain_response_master',$data1);		
			
			
			
		
	}
	function Check_survey_dulplicate($Enrollment_id,$Company_id,$Question_id)
	{
		
		$query =  $this->db->select('*')
				   ->from('igain_response_master')
				   ->where(array('Enrollment_id' => $Enrollment_id,'Company_id' => $Company_id,'Question_id' =>$Question_id))->get();
				   
				   // return $query->result_array();
			return $query->num_rows();
			
			
			
			
	}
	function Fetch_response_id($Enrollment_id,$Company_id,$Question_id)
	{
		
		$query =  $this->db->select('*')
				   ->from('igain_response_master')
				   ->where(array('Enrollment_id' => $Enrollment_id,'Company_id' => $Company_id,'Question_id' =>$Question_id))->get();
				   
				  return $query->row();
			// return $query->num_rows();
			
			
			
			
	}
	public function Insert_contactus_message($Company_id,$Enrollment_id,$Membership_id,$contact_subject,$contactus_SMS)
	{	
		$today=date('Y-m-d H:i:s');
		$data1=array('Enrollment_id' => $Enrollment_id,'Company_id' => $Company_id,'Membership_id' => $Membership_id,'Header_type' => $contact_subject,'Content_description' => $contactus_SMS,'Creation_date' => $today);		
			
		$this->db->insert('igain_contact_us_tbl', $data1);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
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
	public function insert_enroll_details($data)
	{
		$this->db->select('Tier_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=> $data['Company_id'],'Tier_level_id' => '1'));
		
		$tier_query = $this->db->get();
		//echo $this->db->last_query();
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
	function fetch_enrollment_details($Company_id,$Membership_id)
	{
		
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => 1,'User_activated' => 1,'Company_id' => $Company_id,'Card_id' => $Membership_id));
		$query = $this->db->get();	
		if($query->num_rows() == 1)
		{			
			foreach ($query->result() as $row)
			{
               $result[] = array("Enrollement_id" => $row->Enrollement_id, "First_name" => $row->First_name,"Last_name" => $row->Last_name, "Phone_no" => $row->Phone_no, "User_email_id" => $row->User_email_id, "Company_id" => $row->Company_id, "Current_balance" => $row->Current_balance, "Card_id" => $row->Card_id);
            }			
			return json_encode($result);
		}
		else
		{
			return 0;
		}
	}
	function fetch_enrollment_details1($Company_id,$Membership_id,$Login_Enrollement_id,$phnumber)
	{
		
		$this->db->from('igain_enrollment_master');
		$where = '(Card_id = "'.$Membership_id.'" OR Phone_no = "'.$phnumber.'")';
		$this->db->where(array('User_id' => 1,'User_activated' => 1,'Company_id' => $Company_id));
		$this->db->where($where);	
		$query = $this->db->get();	
		if($query->num_rows() == 1)
		{			
			foreach ($query->result() as $row)
			{
               $result[] = array("Enrollement_id" => $row->Enrollement_id, "First_name" => $row->First_name,"Last_name" => $row->Last_name, "Phone_no" => App_string_decrypt($row->Phone_no), "User_email_id" => App_string_decrypt($row->User_email_id), "Company_id" => $row->Company_id, "Current_balance" => $row->Current_balance, "Card_id" => $row->Card_id);
            }			
			return json_encode($result);
		}
		else
		{
			return 0;
		}
	}
	public function Insert_transfer_transaction($data)
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
	public function Update_member_balance($Company_id,$Enrollement_id,$New_curr_balance)
	{
		$data=array('Current_balance' => $New_curr_balance);
		$this->db->where(array('Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id));
		$this->db->update('igain_enrollment_master',$data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
	}
	function Fetch_item_details($Item,$Company)
	{
		$this->db->select("Merchandize_item_name");
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_merchandize_item_code' => $Item,'Company_id' => $Company));
		
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
	
	function get_tier_details($Tier_id,$CompanyId)
	{
		$this->db->select(" *,Tier_name");
		$this->db->from('igain_tier_master');
		$this->db->where(array('Tier_id' => $Tier_id,'Active_flag' => 1,'Company_id' => $CompanyId));		
		$sql = $this->db->get();
		if($sql ->num_rows() == 1)
		{
			return $sql->row();			
		}
		else
		{
			return false;
		}
	}
	function get_tier_name($Tier_id)
	{
		$this->db->select("Tier_name");
		$this->db->from('igain_tier_master');
		$this->db->where(array('Tier_id' => $Tier_id,'Active_flag' => 1));		
		$sql = $this->db->get();
		if($sql ->num_rows() == 1)
		{
			return $sql->row();			
		}
		else
		{
			return false;
		}
	}
	function get_cust_trans_summary_all($Company_id,$Enrollement_id)
	{ 
		$this->db->select('IE.First_name,IE.Middle_name,IE.Last_name,IT.Card_id,IE.Enrollement_id,SUM(Redeem_points) AS Total_reddems,SUM(Loyalty_pts) as Total_Loyalty_pts,SUM(Topup_amount) as Total_bonus_ponus,SUM(Transfer_points) as Total_Transfer_points,SUM(Purchase_amount) as Total_purchase_amt,IE.Current_balance,IE.Blocked_points,IE.Company_id');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->where('IT.Enrollement_id' , $Enrollement_id);
		$this->db->where('IT.Company_id' , $Company_id);
		$this->db->where('IT.Trans_type !=4 ');
		$this->db->where("IT.Trans_type NOT IN('4','26')");
		$this->db->group_by('IT.Card_id');
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}
	function insert_customer_notification($data)
    {
		$this->db->insert('igain_cust_notification', $data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
    }	
	function Fetch_Seller_Referral_Offers($seller_id)
	{
		$this->db->select('A.Seller_id,A.Company_id,A.Referral_rule_for,B.First_name,B.Last_name,B.Current_address,B.Photograph,B.State,B.District,B.City,B.Phone_no,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name');
		$this->db->from('igain_seller_refrencerule as A');		
		$this->db->join('igain_enrollment_master as B', 'A.Seller_id = B.Enrollement_id');
		$this->db->join('igain_country_master', 'B.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'B.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'B.City = igain_city_master.id');
		$this->db->where(array('A.Seller_id' => $seller_id));
		$this->db->order_by('A.refid', 'DESC');
		$this->db->limit('1');
		$sql = $this->db->get();
		if($sql -> num_rows() > 0)
		{
			return $sql->result_array();
		}
		else
		{
			return false;
		}		
	}	
	function Fetch_referral_offers($Seller_id,$Company_id)
	{
		$this->db->select("Referral_rule_for,From_date,Till_date,Refree_topup,Customer_topup");
		$this->db->where(array('Company_id' => $Company_id,'Seller_id' => $Seller_id));		
		$this->db->order_by('refid','DESC');
		$query = $this->db->get('igain_seller_refrencerule');		
		return $query->result_array();
	}
	function Fetch_survey_details($Company_id)
	{
		$this->db->select("*");
		$this->db->where(array('Company_id' => $Company_id));
		$query = $this->db->get('igain_questionaire_master');		
		return $query->result_array();
	}
	
	function get_giftcard_details($Card_id,$Company_id)
	{
		$this->db->select("SUM(Card_balance) AS Gift_balance");
		$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id));
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
	function get_hobbies_interest_details($enroll,$Company_id)
	{
		$this->db->select("*");
		$this->db->where(array('HI.Enrollement_id' => $enroll,'HI.Company_id' => $Company_id));
		$this->db->join('igain_hobbies_master as HM', 'HI.Hobbie_id = HM.Id');
		$query = $this->db->get('igain_hobbies_interest AS HI');	
		// echo $this->db->last_query();
		return $query->result_array();
	}
	function get_all_hobbies_details()
	{
		$this->db->select("*");
		$query = $this->db->get('igain_hobbies_master');
		return $query->result_array();
	}	
	public function delete_hobbies($Company_id,$Enrollment_id)
	{
		$this->db->where(array('Company_id' => $Company_id,'Enrollement_id' => $Enrollment_id));
		$this->db->delete('igain_hobbies_interest');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function insert_hobbies($Company_id,$Enrollment_id,$new_hobbies)
	{
		$insert_hobbie = array(
					'Company_id' => $Company_id,
					'Enrollement_id' => $Enrollment_id,
					'Hobbie_id' => $new_hobbies
				);
		$this->db->insert('igain_hobbies_interest',$insert_hobbie);
		if($this->db->affected_rows() > 0)
		{
			return true;
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
	function get_enrollment_details_polling($Cust_email,$gv_log_compid)
	{
		$this->db->select("*");
		$this->db->where(array('User_email_id' => $Cust_email,'Company_id' => $gv_log_compid,'User_activated' => 1));
		$query = $this->db->get('igain_enrollment_master');		
		if($query -> num_rows() == 1 )
		{
			return $query->row();
		}
		else
		{
			return false;
		}	
	}
	function Insert_latitude_longitude($Enrollement_id,$Cust_lat,$Cust_long)
	{
		$data['Enrollement_id'] = $Enrollement_id;
		$data['Latitude'] = $Cust_lat;
		$data['Longitude'] = $Cust_long;
		$this->db->insert('igain_latitude_longitude', $data);	
	}
	function Customer_Notification_polling($gv_log_compid,$Cust_enrollement_id,$entry_date,$commdtlsid)
	{
		$q =  $this->db->select(' * ')
				   ->from('igain_cust_notification')
				   ->where(array('Customer_id' => $Cust_enrollement_id,'Company_id' => $gv_log_compid,'Communication_id' => $commdtlsid,'Date' =>$entry_date))->get();
				  
		return $q->num_rows();	 
		
	}
	function Notification_polling($gv_log_compid,$Cust_enrollement_id)
	{
		$this->db->select("*");
		$this->db->where(array('Open_flag'=> 0,'Customer_id'=> $Cust_enrollement_id,'Company_id' => $gv_log_compid));
		$query = $this->db->get('igain_cust_notification');
		return $query->num_rows();
			
	}
	function insert_online_booking_appointment($post_data)		
	{
		$this->db->insert('igain_online_booking_appointment', $post_data);	
		// echo $this->db->last_query()."<br>";		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}	
	}
	function search_enrollement($search_data,$Company_id,$Country_id)
	{
		$Dial_code_sql =  $this->db->select('Dial_code')
						  ->from('igain_currency_master')
						  ->where('Country_id',$Country_id);
		$Dial_code = $this->db->get()->row()->Dial_code;
		
		$edit_enroll_query = "SELECT * FROM igain_enrollment_master WHERE 
		(Card_id='".$search_data."' AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1 AND Card_id !=0) OR (Phone_no='".($Dial_code.$search_data)."'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1) OR (User_email_id='".$search_data."'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1) OR (concat_ws(' ',First_name,Last_name) LIKE '%".$search_data."%'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1) ";
		
		$query = $this->db->query($edit_enroll_query);
			// echo $this->db->last_query();	 	
		if($query->num_rows() > 0)
		{
        	
			
			foreach ($query->result() as $row)
			{
               $result[] = array("Enrollement_id" => $row->Enrollement_id, "First_name" => $row->First_name,"Last_name" => $row->Last_name, "Phone_no" => $row->Phone_no, "User_email_id" => $row->User_email_id, "Company_id" => $row->Company_id, "Current_balance" => $row->Current_balance, "Card_id" => $row->Card_id);
            }			
			return json_encode($result);
        }
        return false;
	}
	public function update_payment_info($post_data,$Enrollement_id)
	 {
				$this->db->where('Enrollement_id', $Enrollement_id);
				$this->db->update('igain_enrollment_master', $post_data);
				if ($this->db->affected_rows() > 0)
				{
					return true;
				}
				else 
				{
					return true;
				}
	 }	
	 public function update_card_number($post_data,$Enrollement_id)
	 {
	  $this->db->where('Enrollement_id', $Enrollement_id);
	  $this->db->update('igain_enrollment_master', $post_data);

	  if ($this->db->affected_rows() > 0)
	  {
	   return true;
	  }
	  else 
	  {
	   return true;
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
	function Fetch_Notification_Delete($id,$Company_id)
	{
		$this->db->select("*");
		$this->db->where(array('Id' => $id,'Company_id' => $Company_id,'Active_flag' => '1'));
		$query = $this->db->get('igain_cust_notification');
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	function get_query_type($cmp_id)  
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
	function Get_ccquery_user($Query_type_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_querytype_master');
		$this->db->where(array('Query_type_id'=>$Query_type_id,'Company_id'=>$Company_id));
		$sql=$this->db->get();	
		if($sql->num_rows()>0)
		{			
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	function Insert_callcenter_querylog_master($Post_data)
	{	
		$this->db->insert('igain_callcenter_querylog_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}		
	}
	
	function Get_ccquery_userchild($Query_type_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_querytype_child');
		$this->db->where(array('Query_type_id'=>$Query_type_id,'Company_id'=>$Company_id));
		$sql=$this->db->get();	
		if($sql->num_rows()>0)
		{			
			return $sql->result_array();
		}
		else
		{
			return false;
		}		
	}
	function Get_ccquery_userchild1($Query_type_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_querytype_child');
		$this->db->where(array('Query_type_id'=>$Query_type_id,'Company_id'=>$Company_id));
		$sql=$this->db->get();	
		if($sql->num_rows()>0)
		{			
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	function Insert_callcenter_querylog_child($Post_data)
	{	
		$this->db->insert('igain_callcenter_querylog_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}	
		return false;
	}
	function get_query_details($Query_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_querytype_master');
		$this->db->where(array('Query_type_id' => $Query_id, 'Company_id' => $Company_id));		
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
	function Update_company_ticketno_series($Post_data,$Company_id)
    {		
		$this->db->where(array('Company_id' => $Company_id));
		$this->db->update('igain_company_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	function Get_sub_query_name($Query_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_querysetup_master');
		$this->db->where(array('Query_type_id'=>$Query_id,'Company_id'=>$Company_id));
		$sql=$this->db->get();	
		// echo $this->db->last_query();
		// die;
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
		
	function Fetch_seller_gained_points($Company_id,$Enrollment_id)
	{
		$this->db->select("EN.First_name,EN.Last_name,CT.Company_id,CT.Cust_enroll_id,CT.Seller_id,CT.Cust_seller_balance,CT.Seller_total_purchase,CT.Seller_total_redeem,CT.Seller_total_gain_points,CT.Seller_total_topup,CT.Seller_paid_balance");
		$this->db->where(array('CT.Cust_enroll_id' => $Enrollment_id,'CT.Company_id' => $Company_id));
		$this->db->join('igain_enrollment_master as EN', 'CT.Seller_id = EN.Enrollement_id');
		$query = $this->db->get('igain_cust_merchant_trans_summary AS CT');	
		// echo $this->db->last_query();
		if($query -> num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}	
		
	}	
	public function insert_transction($data)
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
		function Get_Merchandize_Category_details($lv_Merchandize_category_id)
	{
		$this->db->select('*');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Merchandize_category_id'=>$lv_Merchandize_category_id));
		$sql=$this->db->get();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
		function Get_codedecode_row($Code_decode_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master');
		$this->db->where(array('Code_decode_id'=>$Code_decode_id));
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
	function Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight,$Weight_unit_id)
	{
		$this->db->select('Delivery_price');
		$this->db->from('igain_delivery_price_master');
		$this->db->where(array('From_country'=>$Partner_Country_id,'To_country'=>$To_Country,'From_state'=>$Partner_state,'To_state'=>$To_State,'Weight_unit_id'=>$Weight_unit_id));
		$this->db->where(" '$Weight' >= From_weight");
		$this->db->where(" '$Weight' <= To_weight ");
		$sql=$this->db->get();
		   // echo "<br><br>".$this->db->last_query()."---<br>";
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	function Get_Company_Partners_details($Partner_id)
	{
		$this->db->select('*');
		$this->db->from('igain_partner_master');
		$this->db->where(array('Partner_id'=>$Partner_id));
		$sql=$this->db->get();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	function Get_Company_Partners_Branch_details($Branch_code,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_branch_master');
		$this->db->where(array('Branch_code'=>$Branch_code,'Company_id'=>$Company_id,));
		$sql=$this->db->get();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	 /*************amit end***********************/
	function Send_password($Company_id,$Email_id)
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
	public function Get_CallCenter_user_contact($Company_id)
	{
		$this->db->select("*");
		$this->db->from("igain_enrollment_master");  
		$this->db->where(array("Company_id" => $Company_id, "Super_seller" => 0, "Sub_seller_admin" => 0, "User_id" => 6));
        $query = $this->db->get();
		
		// echo $this->db->last_query();
		
        if ($query->num_rows() > 0)
		{
        	// return $query->row();
			return $query->result_array();
        }
	}
	function get_partner_branch($Company_id,$Merchandize_item_code)
	{
		$this->db->select("*");
		$this->db->from('igain_merchandize_item_child');
		$this->db->where(array('Company_id' => $Company_id, 'Merchandize_item_code' =>$Merchandize_item_code));		
		$sql = $this->db->get();
		if($sql -> num_rows() > 0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	
	public function first_time_login($Company_id,$userName,$enrollId,$userId)
	{
		$this->db->select('*');
		$this->db->from('igain_session_tbl');
		$this->db->where(array('Company_id' => $Company_id,'userName' => $userName,'enrollId' =>$enrollId,'userId' =>$userId));
		$total_rows=$this->db->count_all_results();		
		// echo $this->db->last_query();
		return $total_rows;
	}
	function Update_eVoucher_Status($MembershipID,$CompanyId,$evoucher,$Update_User_id,$Voucher_status)
	{
		$Update_date=date("Y-m-d H:i:s");
		$data=array(
		"Voucher_status"=>$Voucher_status,
		"Update_User_id"=>$Update_User_id,
		"Update_date"=>$Update_date
		);
		$this->db->where('Voucher_no',$evoucher);
		 $this->db->where('Card_id',$MembershipID);
		$this->db->where('Company_id' , $CompanyId);
		$this->db->update("igain_transaction",$data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function Check_eVoucher_Status($MembershipID,$CompanyId,$evoucher,$Update_User_id,$Voucher_status)
	{
		$this->db->select('*');
		$this->db->from('igain_transaction');
		$this->db->where(array('Company_id' => $CompanyId,'Voucher_no' => $evoucher,'Enrollement_id' =>$Update_User_id,'Card_id' =>$MembershipID,'Voucher_status' =>30));
		// echo $this->db->last_query();
		$total_rows=$this->db->count_all_results();	

		// echo $this->db->last_query();
		
		return $total_rows;	
	}
	/********************************Ravi 08-05-2018 evoucher fullfillment from email*************************************/
	public function update_cust_balance($up,$cid,$company_id)
	{
	  //$this->db->set('point_balance'); 
	  $this->db->where('Card_id', $cid, 'Company_id', $company_id); 
	  $this->db->update('igain_enrollment_master', $up); 
	  return true;
	}
	public function Update_member_TopUpAmt($Company_id,$Enrollement_id,$New_Total_topup)
	{
		$data=array('Total_topup_amt' => $New_Total_topup);
		$this->db->where(array('Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id));
		$this->db->update('igain_enrollment_master',$data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
	}
	function get_cust_total_gain_points($Company_id,$Enrollement_id,$Card_id) 
	{  
		$this->db->select('SUM(Loyalty_pts) as Total_gained_points');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->where(array('IT.Enrollement_id'=>$Enrollement_id,'IT.Company_id'=>$Company_id,'IT.Card_id'=>$Card_id));
		$this->db->where("IT.Trans_type IN('2','12')");
		$this->db->where("IT.Voucher_status NOT IN('18','19','21','22','23')");
		$sql51 = $this->db->get();
		// echo $this->db->last_query(); die;
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
	function get_cust_total_transfer_points($Company_id,$Enrollement_id,$Card_id) 
	{  
		$this->db->select('SUM(Transfer_points) as Total_transfer_points');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->where(array('IT.Enrollement_id'=>$Enrollement_id,'IT.Company_id'=>$Company_id,'IT.Card_id'=>$Card_id,'IT.Trans_type'=>8));
		
		$sql511 = $this->db->get();
		// echo $this->db->last_query(); die;
		if($sql511 -> num_rows() > 0)
		{
			return $sql511->row();
		}
		else
		{
			return false;
		}
	}
	
	/******************28-08-2019***********************/
	function Fetch_customer_address($Enrollement_id)
	{
		$this->db->select('A.Company_id,A.First_name,A.Last_name,A.Current_address,A.Photograph,A.State,A.District,A.City,A.Phone_no,A.Zipcode,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name');
		$this->db->from('igain_enrollment_master as A');
		$this->db->join('igain_country_master', 'A.Country = igain_country_master.id');
		$this->db->join('igain_state_master', 'A.State = igain_state_master.id');
		$this->db->join('igain_city_master', 'A.City = igain_city_master.id');
		$this->db->where(array('A.Enrollement_id' => $Enrollement_id));		
		$this->db->limit('1');
		$sql = $this->db->get();
		if($sql -> num_rows() > 0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	function Fetch_customer_addresses($Enrollement_id,$Address_type)
	{
		$this->db->select('A.Company_id,A.Address_id,A.Contact_person,A.Address_type,A.Address,A.Phone_no,A.Country_id,A.State_id,A.City_id,A.Zipcode,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name');
		$this->db->from('igain_customer_address as A');
		$this->db->join('igain_country_master', 'A.Country_id = igain_country_master.id');
		$this->db->join('igain_state_master', 'A.State_id = igain_state_master.id');
		$this->db->join('igain_city_master', 'A.City_id = igain_city_master.id');
		$this->db->where(array('A.Enrollment_id' => $Enrollement_id,'A.Address_type' =>$Address_type));		
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql -> num_rows() > 0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	public function insert_customer_address($Insert_data)
	{
		$this->db->insert('igain_customer_address', $Insert_data);		
		echo $this->db->last_query()."<br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}  
	}
	public function check_customer_address($Enrollement_id,$Company_id,$Address_type)
	{
		$this->db->select('*');
		$this->db->from('igain_customer_address');
		$this->db->where(array('Enrollment_id' => $Enrollement_id,'Address_type' => $Address_type,'Company_id' => $Company_id,));		
		$sql = $this->db->get();
		//echo $this->db->last_query();
		if($sql -> num_rows() > 0)
		{
			return $sql->num_rows();
		}
		else
		{
			return false;
		}  
	}
	public function update_customer_address($Update_data,$Enrollement_id,$Company_id,$Address_type)
	{	
		$this->db->where(array('Enrollment_id' => $Enrollement_id,'Address_type' => $Address_type,'Company_id' => $Company_id,));
		$this->db->update('igain_customer_address',$Update_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}  
	}
	
	public function Update_customer_delivery_address($Enrollement_id,$Address_type)
	{	
		/**************************************/
		$Update_data1=array('Deliver_flag' => 0);
		$this->db->where(array('Enrollment_id' => $Enrollement_id));
		$this->db->update('igain_customer_address',$Update_data1);
		/**************************************/
		$Update_data2=array('Deliver_flag' => 1);
		$this->db->where(array('Enrollment_id' => $Enrollement_id,'Address_type' => $Address_type));
		$this->db->update('igain_customer_address',$Update_data2);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}  
	}
	function Fetch_selected_customer_addresses($Enrollement_id)
	{
		$this->db->select('A.Company_id,A.Contact_person,A.Address_type,A.Address,A.Phone_no,A.Country_id,A.State_id,A.City_id,A.Zipcode,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name');
		$this->db->from('igain_customer_address as A');
		$this->db->join('igain_country_master', 'A.Country_id = igain_country_master.id');
		$this->db->join('igain_state_master', 'A.State_id = igain_state_master.id');
		$this->db->join('igain_city_master', 'A.City_id = igain_city_master.id');
		$this->db->where(array('A.Enrollment_id' => $Enrollement_id,'A.Deliver_flag' =>1));		
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql -> num_rows() > 0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	public function delete_address($Address_id)
	{
		$this->db->where(array('Address_id' => $Address_id));
		$this->db->delete('igain_customer_address');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Get_delivery_price_master_citywise($Outlet_City_id)
	{
		$this->db->select('Delivery_price');
		$this->db->from('igain_delivery_price_city');
		$this->db->where(array('City_id'=>$Outlet_City_id));
		$sql=$this->db->get();
		   // echo "<br><br>".$this->db->last_query()."---<br>";
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	/******************28-08-2019***********************/
	/*******************11-10-2019 Nilesh Add new func*********************/
	public function Fetch_outlet_cites($Company_id)
	{
		// $this->db->distinct();
		$this->db->select("DISTINCT(City)");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id' => '2', 'Company_id' => $Company_id, 'Super_seller' => '0', 'Sub_seller_admin' => '1','Sub_seller_Enrollement_id' => '0', 'User_activated' => '1'));		
		$sql = $this->db->get();
		// echo $this->db->last_query(); 
		if($sql -> num_rows() > 0)
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
	public function check_bill_number_exist($Bill_no,$Company_id) 
	{		
		$query =  $this->db->select('Bill_no')
			  ->from('igain_transaction')
			  ->where(array('Bill_no' => $Bill_no, 'Company_id'=> $Company_id, 'Trans_type' => 12)) ->get();
			return $query->num_rows();
	}	
	/*******************11-10-2019 Nilesh Add new func*********************/
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
	   return true;
	  }
	}
	/*****************************************************/
	function get_member_discount_vouchers($Card_id,$Company_id)
	{
		$today = date("Y-m-d");
		
		$this->db->select("Gift_card_id,Card_balance,Valid_till,Discount_percentage");
		$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id, 'Payment_Type_id' => '99'));
		/*---25-06-2020---
			// $this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id));
			
			// $this->db->where_in("Payment_Type_id",array('999'99'));
		/*---25-06-2020---*/
		
		$this->db->where(array('Card_balance >' => '0','Valid_till >=' => $today));
		$query = $this->db->get('igain_giftcard_tbl');	
		// echo $this->db->last_query();
		if($query -> num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}	
	}
	function get_member_gift_cards($Card_id,$Company_id)
	{
		$today = date("Y-m-d");
		
		$this->db->select("Gift_card_id,Card_balance,Valid_till");
		$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id));
		$this->db->where_not_in("Payment_Type_id",array('99','997','998'));
		/*---25-06-2020---
			// $this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id));
			
		 
		/*---25-06-2020---*/
		
		$this->db->where(array('Card_balance >' => '0','Valid_till >=' => $today));
		$query = $this->db->get('igain_giftcard_tbl');	
		// echo $this->db->last_query();
		if($query -> num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}	
	}
	function get_member_revenue_vouchers($Card_id,$Company_id)
	{
		$today = date("Y-m-d");
		
		$this->db->select("Gift_card_id,Card_balance,Valid_till,Discount_percentage");
		$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id, 'Payment_Type_id' => '998'));
		/*---25-06-2020---
			$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id));
			
			$this->db->where_in("Payment_Type_id",array('998'));
		/*---25-06-2020---*/
		
		$this->db->where(array('Card_balance >' => '0','Valid_till >=' => $today));
		$query = $this->db->get('igain_giftcard_tbl');	
		// echo $this->db->last_query();

		if($query -> num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}	
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
				$this->session->set_userdata('Payment_Discount_codes',$payment_discountsArray);
			
			} else {
				
				$this->session->set_userdata('Payment_Discount_codes',null);
			}
						
		return floor($discountAmt);
	}
	
	function get_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal,$channel)
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
						$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);

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
	
	function get_category_discount_value($Itemcategory_id,$ItemCode,$Item_price,$Company_id,$delivery_outlet,$cust_enroll,$Tier_id,$grandTotal,$channel)
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
						$discountsArray[] = array("Discount_code"=>$row->Discount_code,"Discount_voucher_code"=>$gift_cardid,"Discount_voucher_amt"=>number_format(floor($discount_Amt),2),"Discount_voucher_percentage" =>$discount_Percentage,"Discount_voucher_validity"=>$validTill);

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
	 function get_giftcard_balance($GiftCard_id,$Company_id)
	{
		$this->db->select("Card_balance,Card_value,Valid_till");
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
	

	function get_member_product_inprecentage_vouchers($Card_id,$Company_id,$item_code,$Quantity)
	{
		$today = date("Y-m-d");
		
		$this->db->select("igain_giftcard_tbl.Gift_card_id,igain_giftcard_tbl.Card_balance,igain_giftcard_tbl.Valid_till,igain_giftcard_tbl.Discount_percentage,B.Company_merchandize_item_code,C.Merchandize_item_name,B.Quantity,(C.Billing_price * B.Quantity) as Reduce_product_amt");
		$this->db->join('igain_company_send_voucher as B','igain_giftcard_tbl.Gift_card_id = B.Voucher_code');
		$this->db->join('igain_company_merchandise_catalogue as C','C.Company_merchandize_item_code = B.Company_merchandize_item_code');
		
		/*---25-06-2020---*/
			$this->db->where(array('igain_giftcard_tbl.Card_id' => $Card_id,'igain_giftcard_tbl.Company_id' => $Company_id,'igain_giftcard_tbl.Payment_Type_id' => '997','B.Company_merchandize_item_code' => $item_code,'B.Quantity <=' => $Quantity));			
			// $this->db->where_in("Payment_Type_id",array('997'));
		/*---25-06-2020---*/
		
		$this->db->where(array('igain_giftcard_tbl.Card_balance >' => '0','igain_giftcard_tbl.Valid_till >=' => $today));
		$this->db->order_by('Payment_Type_id','DESC');
		$query = $this->db->get('igain_giftcard_tbl');			
		 // echo $this->db->last_query()."---<br>"; 
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
	function check_gift_card_id($gift_cardid,$Company_id)
	{
		$query =  $this->db->select('id')
				   ->from('igain_giftcard_tbl')
				   ->where(array('Gift_card_id' => $gift_cardid, 'Company_id' => $Company_id))->get();
				   
		return $query->num_rows();
	}
	function Get_my_discount_vouchers($Enrollment_id,$Company_id,$Card_id)
	{
		$this->db->select("T.*");
		$this->db->from('igain_giftcard_tbl as T');
		$this->db->join('igain_enrollment_master as IE', 'T.Card_id = IE.Card_id','LEFT');
		$this->db->where(array('T.Company_id' => $Company_id, 'T.Card_id' => $Card_id)); // 'T.Card_balance >' => 0
		$this->db->where_in('T.Payment_Type_id', array('99','997','998'));
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
	function Get_my_gift_cards($Enrollment_id,$Company_id,$Card_id)
	{
		$this->db->select("T.*");
		$this->db->where(array('T.Company_id' => $Company_id, 'T.Card_id' => $Card_id, 'T.Payment_Type_id !=' => 99)); // 'T.Card_balance >' => 0
		$this->db->from('igain_giftcard_tbl as T');
		$this->db->join('igain_enrollment_master as IE', 'T.Card_id = IE.Card_id','LEFT');
		
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
	/*****************************************************/
			function fetch_giftcard_email_details($Company_id,$input_email)
	{
		
		 $this->load->helper(array('encryption_val'));
		 
		 
		$this->db->from('igain_enrollment_master');
		$where = '(User_email_id = "'.$input_email.'")';
		$this->db->where(array('User_id' => 1,'User_activated' => 1,'Company_id' => $Company_id,));
		$this->db->where($where);	
		$query = $this->db->get();		
		if($query->num_rows() == 1)
		{			
			foreach ($query->result() as $row)
			{
				$User_email_id = App_string_decrypt($row->User_email_id);
				$Phone_no = App_string_decrypt($row->Phone_no);
				// echo "--User_email_id--".$User_email_id."--<br>";
				$result[] = array("Enrollement_id" => $row->Enrollement_id, "First_name" => $row->First_name,"Last_name" => $row->Last_name, "Phone_no" => $Phone_no, "User_email_id" => $User_email_id, "Company_id" => $row->Company_id, "Card_id" => $row->Card_id);
            }			
			return json_encode($result);
		}
		else
		{
			return 0;
		}
	}
	function Update_giftcard_transaction($Company_id,$input_email,$Gift_card,$lv_date_time,$Login_Enrollement_id,$input_user)
	{
		$data = array(
					'Send_to_giftcard' => $input_email,
					'Send_to_user' => $input_user,
					'Card_balance' => '0.00',
					'Update_user_id' => $Login_Enrollement_id,
					'Update_date' => $lv_date_time
				);
		$this->db->where(array('Gift_card_id' => $Gift_card,'Company_id' => $Company_id));
		$this->db->update("igain_giftcard_tbl", $data);		
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
	 function insert_Giftcard_transction($GiftCard_id,$Company_id,$lv_date_time,$Login_Enrollement_id,$input_email,$Send_member,$Phone_no,$Card_id)
	{
		$this->db->select("*");
		$this->db->where(array('Gift_card_id' => $GiftCard_id,'Company_id' => $Company_id));
		$this->db->limit('1');
		$query = $this->db->get('igain_giftcard_tbl');		
		if($query -> num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data['Company_id'] = $Company_id;
				$data['Gift_card_id'] = $row->Gift_card_id;
				$data['Card_value'] = $row->Card_value;
				$data['Card_balance'] = $row->Card_value;
				$data['Card_id'] = $Card_id;
				$data['User_name'] = $Send_member;
				$data['Email'] = $input_email;
				$data['Phone_no'] = $Phone_no;
				$data['Payment_Type_id'] = $row->Payment_Type_id;
				$data['Seller_id'] = $row->Seller_id;
				$data['Valid_till'] = $row->Valid_till;
				$data['Bank_name'] = $row->Bank_name;
				$data['Bank_Branch_name'] = $row->Bank_Branch_name;
				$data['Cheque_no'] = $row->Cheque_no;
				$data['Create_date'] = $lv_date_time;
				$this->db->insert('igain_giftcard_tbl', $data);
				// echo $this->db->last_query();
			}
		}
		else
		{
			return false;
		}	
	}
	
	
	//*********** 14-12-2021 *********Email Template ******	
	function fetchEmailTemplate($Email_template_id,$Company_id)
	{
		
		 // echo"----fetchEmailTemplate--------<br>";
		 // die;
		 
		$this->db->select("Template_description,Email_Type,Email_subject,Body_structure,Email_body,Footer_notes,Email_header,Body_image,Email_header_image,Email_font_size,Font_family,Email_font_color,Email_background_color,Unsubscribe_flg,Google_play_link,Header_background_color,Footer_background_color,Ios_application_link,Facebook_share_flag,Twitter_share_flag,Linkedin_share_flag,Google_share_flag,Email_Contents_background_color,Footer_font_color");
		  $this->db->from('igain_company_email_template_master');
		  $this->db->where(array('Status' => '1','Template_type_id' =>$Email_template_id,'Company_id' => $Company_id));
		  $sql = $this->db->get();
		  // echo"----fetchEmailTemplate-----".$this->db->last_query()."----<br>";
		  
			if($sql -> num_rows() == 1)
			{
				return $sql->row();
			}
			else
			{
				return false;
			}
		
	}
	public function update_customer_notification($customer_notification,$Company_id,$Enrollement_id,$post_data)
	{
		// $data=array('Current_balance' => $New_curr_balance);
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Id' => $customer_notification));
		$this->db->update('igain_cust_notification',$post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
	}
	//*********** 14-12-2021 *********Email Template ******
		public function Fetch_customer_latest_offer($Enrollement_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_cust_notification');
		$this->db->where(array('Customer_id' => $Enrollement_id,'Company_id' => $Company_id,'Communication_id !=' => 0));
		$this->db->order_by('Id', 'DESC');
		$this->db->limit('1');
		$sql = $this->db->get();
		// echo $this->db->last_query();

		if($sql -> num_rows() > 0)
		{
			return $sql->result_array();
		}
		else
		{
			return false;
		}
	}
		public function Get_saas_company_payment_details($Company_id)
	{	  
		$Status = "captured";
		
		$edit_query = "SELECT Pyament_expiry_date FROM igain_saas_company_billing_payment_details WHERE Company_id='".$Company_id."' AND Payment_status='".$Status."'  AND Payment_type='0'  order by Payment_id desc LIMIT 1";
		
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
		function Get_member_enrollment_count($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where('Company_id', $Company_id);
		$this->db->where('User_id', 1);
		
		$sql51 = $this->db->get();
		return $sql51->num_rows();
		
		
	}
		function Get_saas_license_details()
	{
	  $this->db->select("*");
	  $this->db->from('igain_saas_license_details');
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
	//*********** 11-07-2022 ********* Third Party Configuration ******
	public function Fetch_thirdparty_details($type)
	{
		$this->db->select('*');
		$this->db->from('igain_thirdparty_configuration');
		$this->db->where(array('type' => $type,'active_flag' =>1));
		$sql = $this->db->get();
		// echo $this->db->last_query();

		if($sql -> num_rows() > 0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	public function update_company_giftbalance($updateData,$Company_id)
	{
		$this->db->trans_start();
		$this->db->where('Company_id', $Company_id);
		$this->db->update('igain_company_master', $updateData);
		$this->db->trans_complete();
		if ($this->db->affected_rows() >0 ) {
			return TRUE;
		} else {
			if ($this->db->trans_status() === FALSE) {
				return false;
			}
			return true;
		}
		
	}
}
?>