<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saas_model extends CI_Model 
{
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
   //***************************************SAAS MASTER SETUP **AMIT KAMBLE 04-01-2021**************
   public function insert_saas_company_master($Post_data)
	{
		$this->db->insert('igain_company_master', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
	}
   public function insert_saas_loyalty_master($Post_data)
	{
		$this->db->insert('igain_loyalty_master', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
   public function insert_saas_enroll_master($Post_data)
	{
		$this->db->insert('igain_enrollment_master', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
	}
	public function Get_saas_company_menus($License_type)
	{
		if($License_type==253)//Standard
		{
			$query = $this->db->where("License_type IN(121,253)");
		}
		elseif($License_type==120)//Enhance
		{
			$query = $this->db->where("License_type IN(121,253,120)");
		}
		else //bASIC
		{
			$query = $this->db->where("License_type",$License_type);
		}
			
		
		$query = $this->db->get("igain_menu_master");
// echo $this->db->last_query();DIE;
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
	  public function insert_saas_refferral_master($Post_data)
	{
		$this->db->insert('igain_seller_refrencerule', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	  public function insert_saas_tier_master($Post_data)
	{
		$this->db->insert('igain_tier_master', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
		public function Get_Code_decode_master($Code_decode_type_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master as A');
		$this->db->join('igain_codedecode_type_master as B','A.Code_decode_type_id=B.Code_decode_type_id');
		
		$this->db->where('A.Code_decode_type_id',$Code_decode_type_id);
		$this->db->order_by('Code_decode','asc');
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
   	public function insert_company_menus($Company_id,$Menu_array)
	{
		$this->db->insert('igain_company_menu_master', $Menu_array);
		// $this->db->insert('igain_saas_company_menu_master', $Menu_array);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	
	public function assign_menu($post_data)
    {
		$this->db->insert('igain_menu_assign', $post_data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
    }
		function FetchCountry()
	{
		$Country_sql = $this->db->query("Select * from igain_country_master");
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
		function FetchCountryTimezones()
	{
		$Timezone_sql = $this->db->query("Select * from igain_country_timezone_tbl");
		$result = $Timezone_sql->result_array();
		
		if($Timezone_sql->num_rows() > 0)
		{
			return $result;
		}
		else
		{
			return 0;
		}
		
	}
	public function Fetch_Saas_Company()
	{
		$company_sql = $this->db->query("Select Company_id,Company_name,Domain_name,Company_primary_email_id,Company_primary_contact_person,Seller_licences_limit,Company_type,Company_contactus_email_id,Joining_bonus_points,Redemptionratio,Country,Company_password,Company_License_type from igain_company_master where Activated=1 and Saas_company_flag=1");
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
	public function Fetch_Saas_Company_instance()
	{
		$company_sql = $this->db->query("Select Company_id,Company_name,Domain_name,Company_primary_email_id,Company_primary_contact_person,Seller_licences_limit,Company_type,Company_contactus_email_id,Joining_bonus_points,Redemptionratio,Country,Company_password,Company_License_type from igain_company_master where Activated=1 and Saas_company_flag=2");
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
		public function Update_saas_company($Company_id,$post_data)
	{
		
		$this->db->where(array('Company_id' => $Company_id));
		$this->db->update("igain_company_master", $post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function get_company_sellers($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance,Super_seller,User_email_id,User_pwd");
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
	function Get_all_refrence_templates()
	{
	  $this->db->select("*");
	  $this->db->from('igain_email_template_master');
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
	function check_userdata($inpData,$flag)
	{	 
		$this->db->select('Company_id');
		$this->db->from('igain_company_master');
		if($flag==1){$this->db->where('Company_contactus_email_id', $inpData);}
		if($flag==2){$this->db->where('Company_primary_phone_no', $inpData);}
		if($flag==3){$this->db->where('Domain_name', $inpData);}
			
		$query = $this->db->get();
		
		// echo $this->db->last_query();	   
		return $query->num_rows();
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
	function get_loyalty_detail($Company_id) // use log Table entry
	{
		$this->db->select('*');
		$this->db->from('igain_loyalty_master');
		$this->db->where('Company_id', $Company_id);
		
		$sql51 = $this->db->get();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->row();
		}
		else
		{
			return false;
		}
	}
		function get_transaction_referral_rule($Company_id)
	{
		$this->db->select('*');
        $this->db->from('igain_seller_refrencerule');
		$this->db->where(array('Company_id' => $Company_id, 'Referral_rule_for' => 1));

		$query = $this->db->get();
		
        if ($query->num_rows() > 0)
		{
        	return $query->row();
        }
        return false;
	}
	function get_company_outlets($Company_id)
	{
	  $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance,Super_seller,User_email_id,User_pwd");
	  $this->db->from('igain_enrollment_master');
	  $this->db->where(array('User_id' => '2','User_activated' => '1','Sub_seller_Enrollement_id !=' => '0','Sub_seller_admin' => '0','Super_seller' => '0','Company_id' => $Company_id));
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
		public function edit_SAAS_company($Company_id)
	{	   
		$edit_query = "SELECT * FROM igain_company_master WHERE Company_id=$Company_id LIMIT 1";
		
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
	public function insert_saas_company_payment($data)
	{
		$this->db->insert('igain_saas_company_billing_payment_details', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function Get_saas_company_payment_details($Company_id)
	{	  
		$Status = 'captured';	
		
		$edit_query = "SELECT Pyament_expiry_date FROM igain_saas_company_billing_payment_details WHERE Company_id='".$Company_id."' AND Payment_status='".$Status."' AND Payment_type=0 order by Payment_id desc LIMIT 1";
		
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
	function Delete_company_menu_assign($Company_id)
	{
		$this->db->where("Company_id",$Company_id);
		$this->db->delete("igain_company_menu_master");
		
		$this->db->where("Company_id",$Company_id);
		$this->db->delete("igain_menu_assign");
		
		$this->db->where("Company_id",$Company_id);
		$this->db->delete("igain_menu_assign_privileges");
		
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
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
		function Get_member_enrollment_count($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where('Company_id', $Company_id);
		$this->db->where('User_id', 1);
		
		$sql51 = $this->db->get();
		return $sql51->num_rows();
		
		
	}
	   //***************************************SAAS MASTER SETUP **END**************
	public function Update_payment_details($payment_merchant_order_id,$post_dataz)
	{
		$this->db->where(array('Merchant_order_id' => $payment_merchant_order_id));
		$this->db->update("igain_saas_company_billing_payment_details", $post_dataz);
		//echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Update_invoice_status($Enrollement_id,$Company_id,$Razorpay_payment_id,$post_dataz)
	{
		$this->db->where(array('Enrollement_id'=>$Enrollement_id,'Company_id'=>$Company_id,'Razorpay_payment_id' => $Razorpay_payment_id));
		$this->db->update("igain_saas_company_billing_payment_details", $post_dataz);
		//echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Get_company_payment_details($razorpay_order_id)
	{	
		$query = "SELECT * FROM igain_saas_company_billing_payment_details WHERE Razorpay_order_id='".$razorpay_order_id."'";
		
		$edit_sql = $this->db->query($query);
				
		if($edit_sql -> num_rows() == 1)
		{
			return $edit_sql->row();
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
	function Auto_login($Company_id,$Enrollement_id)
    {	
		
		$this->db->select('E.Enrollement_id, E.First_name, E.Middle_name, E.Last_name, E.Top_up_menu, E.Super_seller, E.Sub_seller_admin, E.Sub_seller_Enrollement_id,
						   E.User_email_id, E.User_pwd, E.pinno, E.User_id, E.timezone_entry, E.Country_id, C.Company_name, C.Partner_company_flag, C.Company_id, C.card_decsion, C.next_card_no, C.Seller_licences_limit,C.Seller_topup_access, E.Current_balance,C.Localization_flag ,C.Localization_logo,C.Company_logo,C.Coalition,E.Photograph,C.Parent_company,C.Allow_membershipid_once,C.Allow_merchant_pin,Membership_redirection_url,Company_License_type,Comp_regdate');
		$this->db->from('igain_enrollment_master as E');
		$this->db->join('igain_company_master as C', 'C.Company_id = E.Company_id');
		$this->db->where(array('C.Activated' => '1', 'E.User_activated' => '1', 'E.Company_id' => $Company_id, 'E.Enrollement_id' => $Enrollement_id, 'E.User_id =' => '2'));
		
		$login_sql = $this->db->get();
		
		if($login_sql -> num_rows() == 1)
		{
			$login_result = $login_sql->result_array();	
			
			return  $login_result; 
		}
		else
		{
			return false;
		}
	}
	public function assign_menu_privileges($post_data)
    {
		$this->db->insert('igain_menu_assign_privileges', $post_data);		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->affected_rows();
		}
    }
	public function Get_payment_details($Razorpay_payment_id,$Company_id)
	{	
		$query = "SELECT * FROM igain_saas_company_billing_payment_details WHERE Razorpay_payment_id='".$Razorpay_payment_id."' AND Company_id='".$Company_id."'";
		
		$sql = $this->db->query($query);
				
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	public function Get_payment_record($Invoice_no,$Company_id,$From_date,$Till_date,$Payment_type)
	{	
		$status = "captured";
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($Till_date));
		
		$this->db->select("a.*,b.Company_name");
		$this->db->from("igain_saas_company_billing_payment_details as a");
		$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
		if($Invoice_no != Null)
		{
			$this->db->where(array("a.Company_id" => $Company_id, "a.Bill_no" => $Invoice_no, "a.Payment_status" => $status, "a.Payment_type" => 0, "a.Payment_type" => $Payment_type));
		}
		else
		{
			$this->db->where("a.Bill_date BETWEEN '".$From_date."' AND '".$To_date."'");
			$this->db->where(array("a.Company_id" => $Company_id, "a.Payment_status" => $status, "a.Payment_type" => 0, "a.Payment_type" => $Payment_type));
		}
		$this->db->order_by('a.Payment_id','desc');
		$Res = $this->db->get();
		
		if($Res->num_rows() > 0)
		{
			foreach($Res->result() as $Row)
			{
				$Data[] = $Row;
			}
			
			return $Data;
		}
		
		return false;
	}
	public function Get_payment_incoice_details($Payment_id,$Company_id)
	{	
		$query = "SELECT * FROM igain_saas_company_billing_payment_details WHERE Payment_id='".$Payment_id."' AND Company_id='".$Company_id."'";
		
		$sql = $this->db->query($query);
				
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}		
	}
	public function Get_Gift_payment_record($Company_id)
	{	
		$status = "captured";
		
		$this->db->select("a.*,b.Company_name");
		$this->db->from("igain_saas_company_billing_payment_details as a");
		$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			
		$this->db->where(array("a.Company_id" => $Company_id, "a.Payment_status" => $status, "a.Payment_type" => 1));
		$this->db->order_by('a.Payment_id','desc');
		
		
		$Res = $this->db->get();
		
		if($Res->num_rows() > 0)
		{
			foreach($Res->result() as $Row)
			{
				$Data[] = $Row;
			}
			
			return $Data;
		}
		
		return false;
	}
	public function Get_license_payment_record($Company_id)
	{	
		$status = "captured";
		
		$this->db->select("a.*,b.Company_name");
		$this->db->from("igain_saas_company_billing_payment_details as a");
		$this->db->join("igain_company_master as b","a.Company_id = b.Company_id");
			
		$this->db->where(array("a.Company_id" => $Company_id, "a.Payment_status" => $status, "a.Payment_type" => 0));
		$this->db->order_by('a.Payment_id','desc');
		
		
		$Res = $this->db->get();
		
		if($Res->num_rows() > 0)
		{
			foreach($Res->result() as $Row)
			{
				$Data[] = $Row;
			}
			
			return $Data;
		}
		
		return false;
	}
	public function Get_saas_invoice_report()
	{	
	
		
			$start_date = date('Y-m-d',strtotime($_REQUEST["start_date"]));
			$end_date = date('Y-m-d',strtotime($_REQUEST["end_date"]));
			$Country = $_REQUEST["Country"];
			$PaymentStatus = $_REQUEST["PaymentStatus"];
			$ReportType = $_REQUEST["ReportType"];
			$Saas_Company_id = $_REQUEST["Saas_Company_id"];
			$LicenseType = $_REQUEST["LicenseType"];
			$Payment_type = $_REQUEST["Payment_type"];
			
			if($ReportType==0){$this->db->select("Bill_date,Company_id as Company_name,Business_address as Billing_address,Country_name,Country_name AS Currency,State_name,Payment_type,License_type,Period,Bill_no,Business_GST_No as GSTIN,Base_price as Invoice_amount,SGST,CGST,IGST,Rounding_off, (Base_price+CGST+SGST+IGST) as Total_invoice_amount,Bill_amount as Paid_Amount,Razorpay_payment_id as Payment_Reference_Id,Payment_status,Email_sent");}//detail
			
			// if($ReportType==0){$this->db->select("Business_GST_No as GSTIN,Company_id as Company_name,Bill_no AS Invoice_no,Bill_date as Invoice_date,");}//detail
			
			if($ReportType==1){$this->db->select(" Company_id as Company_name,Business_address as Billing_address,Country_name,Country_name AS Currency,State_name,Payment_type,License_type, sum(Base_price) as Total_invoice, sum(CGST) as Total_CGST, sum(SGST) as Total_SGST, sum(IGST) as Total_IGST, sum(Base_price+SGST+CGST+IGST) as TotalInvoiceAmount,sum(Bill_amount) as TotalPaidAmount,Payment_status,Email_sent");}//summary
			
			$this->db->from('igain_saas_company_billing_payment_details');
			
			if($Saas_Company_id!=0){$this->db->where('Company_id', $Saas_Company_id);}
			
			if($LicenseType!=0){$this->db->where('License_type', $LicenseType);}
			if($Payment_type!=2){$this->db->where('Payment_type', $Payment_type);}
			
			if($Country=='India'){$this->db->where('Country_name', $Country);}elseif($Country=='1'){$this->db->where('Country_name != "India"');}
				
			if($PaymentStatus=='captured'){$this->db->where('Payment_status = "captured" ');}
			if($PaymentStatus=='failed'){$this->db->where('Payment_status = "failed" ');}
			if($PaymentStatus==1){$this->db->where('Payment_status IS NULL');}
			
			$this->db->where("Bill_date BETWEEN '".$start_date." 00:00:00' AND '".$end_date." 23:59:59'");
			
			if($ReportType==1){$this->db->group_by('Company_id,License_type,Payment_status,Email_sent');}
			
			// $this->db->where('Payment_status', $ReportType);
			// $this->db->where('Payment_status', $ReportType);
			// $this->db->where('Payment_status', $ReportType);
			
			$sql = $this->db->get();
			// echo $this->db->last_query();
			//die;
	  
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
	
	function Get_specific_state($id)
	{
		
		$this->db->select('*');
		$this->db->from('igain_state_master');
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
		
	function convert_currency($Currency) 
    {
        $app_id = '16c61d8288c841fcb2e2e3cce34eed73';
		$oxr_url = "https://openexchangerates.org/api/latest.json?app_id=" . $app_id;

		// Open CURL session:
		$ch = curl_init($oxr_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Get the data:
		$json = curl_exec($ch);
		curl_close($ch);

		// Decode JSON response:
		$oxr_latest = json_decode($json);
		
		return $oxr_latest->rates->$Currency;
    }	
}
?>