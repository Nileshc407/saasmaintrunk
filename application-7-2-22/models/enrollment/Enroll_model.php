<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$ci =& get_instance();
$ci->load->helper('encryption_val');

class Enroll_model extends CI_Model {
	
	/*************AMIT Search enrollement 26 dec 2016************/
	function search_enrollement($search_data,$Company_id,$Country_id,$Super_seller,$enroll)
	{
		$Dial_code_sql =  $this->db->select('phonecode')
						  ->from('igain_country_master')
						  ->where('id',$Country_id);
		$phonecode = $this->db->get()->row()->phonecode;
		if($Super_seller==0)
		{
			// $this->db->where(array('Create_user_id'=> $enroll));
			$edit_enroll_query = "SELECT * FROM igain_enrollment_master WHERE 
			(Card_id='".$search_data."' AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1 AND Card_id !='0') OR (Phone_no='".($phonecode.$search_data)."'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1 AND Create_user_id=".$enroll.") OR (User_email_id='".$search_data."'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1 AND Create_user_id=".$enroll.") OR (concat_ws(' ',First_name,Last_name) LIKE '%".$search_data."%'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1 AND Create_user_id=".$enroll.") ";
		}
		else
		{
			$edit_enroll_query = "SELECT * FROM igain_enrollment_master WHERE 
			(Card_id='".$search_data."' AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1 AND Card_id !='0') OR (Phone_no='".($phonecode.$search_data)."'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1) OR (User_email_id='".$search_data."'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1) OR (concat_ws(' ',First_name,Last_name) LIKE '%".$search_data."%'  AND Company_id=".$Company_id." AND User_id=1 AND User_activated=1) ";
		}
		
		$query = $this->db->query($edit_enroll_query);
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
//************* akshay work start *************************************	
   /*************************************Akshay*******************************/
   function fastenroll($Customer_topup,$ref_Customer_enroll_id,$State,$City,$Card_id)
    {
		$session_data = $this->session->userdata('logged_in');
		$data3['enroll'] = $session_data['enroll'];
		$data3['Company_id']= $session_data['Company_id'];
		$data3['card_decsion']= $session_data['card_decsion'];
		$data3['timezone_entry'] = $session_data['timezone_entry'];
		$data3['Country_id'] = $session_data['Country_id'];
		
		$this->load->model('igain_model');		
		$joinat = date('Y-m-d');
		
		$email_flag = $this->input->post('email_validity');
		
		if($email_flag == 1)
		{ 
			$email_id = $this->input->post('userEmailId');
		}
		else if($email_flag == 0)
		{ 
			// $email_id = $this->input->post('userEmailId2');
			$email_id = $this->input->post('userEmailId');
		}
		else
		{ 
			$email_id = $this->input->post('userEmailId');
		}
		
		/*if($Card_id == "")
		{
			$User_pwd = $this->input->post('phno');
		}
		else
		{
			$User_pwd = $Card_id;
		}*/
		
		$User_pwd = $this->input->post('phno');
		
		$compID =$data3['Company_id'];
		
			
		$Dial_code_sql =  $this->db->select('phonecode')
						  ->from('igain_country_master')
						  ->where('id',$data3['Country_id']);
		$phonecode = $this->db->get()->row()->phonecode;
		
		
		$Phone_no = $phonecode."".$this->input->post('phno');
		
		$this->db->select('Tier_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=> $compID,'Tier_level_id' => '1'));
		
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
		
		$pinno = $this->igain_model->getRandomString();
		
		$data['First_name'] = $this->input->post('fname');
		$data['Last_name'] = $this->input->post('lname');        
		$data['Phone_no'] = App_string_encrypt($Phone_no); //$Phone_no;
		$data['User_email_id'] = App_string_encrypt($email_id);   //$email_id;
		$data['User_pwd'] = App_string_encrypt($User_pwd); //$User_pwd;
		$data['Current_address'] = App_string_encrypt($City);
		$data['User_activated'] = '1';
		$data['Company_id'] = $data3['Company_id'];
		$data['User_id'] = '1';
		$data['Card_id'] = $Card_id;
		$data['timezone_entry'] = $data3['timezone_entry'];
		$data['Country_id'] = $data3['Country_id'];
		$data['Country'] = $data3['Country_id'];
		$data['State'] = $State;
		$data['City'] = $City;
		$data['pinno'] = $pinno;
		$data['source'] = 'Website';
		
		$data['joined_date'] = $joinat;
		$data['Create_user_id'] = $data3['enroll'];
		
		
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
		
		/******************31-05-2017*******Ravi***********/
			if($this->input->post('Label_1_value') != "")
			{
				$data['Label_1_value'] = $this->input->post('Label_1_value');
			}
			else
			{
				$data['Label_1_value'] ="";
			}
			if($this->input->post('Label_2_value') != "")
			{
				$data['Label_2_value'] = $this->input->post('Label_2_value');
			}
			else
			{
				$data['Label_2_value'] ="";
			}
			if($this->input->post('Label_3_value') != "")
			{
				$data['Label_3_value'] = $this->input->post('Label_3_value');
			}
			else
			{
				$data['Label_3_value'] ="";
			}
			if($this->input->post('Label_4_value') != "")
			{
				$data['Label_4_value'] = $this->input->post('Label_4_value');
			}
			else
			{ 
				$data['Label_4_value'] ="";
			}
			if($this->input->post('Label_5_value') != "")
			{
				$data['Label_5_value'] = $this->input->post('Label_5_value');
			}
			else
			{
				$data['Label_5_value'] ="";
			}					
		/******************31-05-2017*******Ravi***********/
		
		/******************30-01-2018*******Ravi***********/
		if($Card_id != "")
		{
			$data['Card_id'] = $Card_id;
		}
		else
		{
			$data['Card_id'] ='0';
		}
		$card_decsion = $data3['card_decsion'];		
		if($card_decsion =='1')
		{		
			// $Card_id1=$Card_id+1;
			$Card_id++;
				
			$UpdateCardID = $this->UpdateCompanyMembershipID($Card_id,$compID);			
		}
		/******************30-01-2018*******Ravi***********/
		//print_r($data); die;
		$this->db->insert('igain_enrollment_master', $data);
		
		$enrollID = $this->db->insert_id();
		$hobbies = $this->input->post('hobbies');
		
		if($hobbies != "")
		{
			foreach($hobbies as $hobbi)
			{
				$hb_data = array(
				'Company_id' => $compID,
				'Enrollement_id' => $enrollID,
				'Hobbie_id' => $hobbi
				);
				
				$this->db->insert('igain_hobbies_interest',$hb_data);
			}
		}
		if($this->db->affected_rows() > 0)
		{
			// return true;
			return $enrollID;
		}
		else
		{
			return 0;
		}
    }
	
	
	function get_lowest_tier($compID)
	{
		$this->db->select('Tier_id,Tier_name');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=> $compID));
		$this->db->order_by('Tier_level_id');
		
		$tier_query = $this->db->get();
		
		if($tier_query->num_rows() > 0)
		{
			foreach($tier_query->result() as $rowt)
			{
				$tier_info[] = $rowt;
			}
			
			return $tier_info;
		}
		
		return false;
	}
	
	function check_card_id($cardid,$Company_id)
	{
		$query =  $this->db->select('Card_id')
				   ->from('igain_enrollment_master')
				   ->where(array('Card_id' => $cardid, 'Company_id' => $Company_id))->get();
		return $query->num_rows();
	}
	
	function check_phone_no($Phone_no,$Company_id,$Country_id)
	{
		$this->db->select('phonecode');
		$this->db->from('igain_country_master');
		$this->db->where('id',$Country_id);
		
		$code_data = $this->db->get();
		
		//echo $this->db->last_query(); echo "---<br>";
		
		foreach($code_data->result() as $rowP)
		{
			$phonecode = $rowP->phonecode;
		}
	
		//echo "--phonecode ---".$phonecode ."---<br>";
		//$phonecode = $this->db->get()->row()->phonecode;
		$Phone_no = $phonecode."".$Phone_no;
		
		$query =  $this->db->select('Phone_no')
				   ->from('igain_enrollment_master')
				   ->where(array('Phone_no' => App_string_encrypt($Phone_no), 'Company_id' => $Company_id))->get();
				
		return $query->num_rows();
	}
	
	function check_userEmailId($userEmailId,$Company_id,$UserID)
	{	 
		if($UserID ==  1)
		{  
			$query =  $this->db->select('User_email_id')
			   ->from('igain_enrollment_master')
			->where(array('User_id' => '1','User_email_id' => App_string_encrypt($userEmailId),'User_activated'=>'1','Company_id' => $Company_id))->get();
		}
		else
		{
			$query =  $this->db->select('User_email_id')
			   ->from('igain_enrollment_master')
			->where(array('User_email_id' => App_string_encrypt($userEmailId),'User_activated'=>'1', 'Company_id' => $Company_id, 'User_id !=' => '1'))->get();	
		}
		//echo $this->db->last_query();	   
		return $query->num_rows();
	}
	//************************************* Akshay END *******************************
	//************************************* Ravi Start *******************************
	
	
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
	
	function enrollment($filepath,$Customer_topup,$ref_Customer_enroll_id,$Card_id)
    { 				
		$session_data = $this->session->userdata('logged_in');
		$data3['username'] = $session_data['username'];
		$data3['enroll'] = $session_data['enroll'];
		$data3['Company_id']= $session_data['Company_id'];
		$data3['card_decsion']= $session_data['card_decsion'];
		$data3['timezone_entry'] = $session_data['timezone_entry'];
		
		if( ! ini_get('date.timezone') )
		{
		  $timezone_entry= date_default_timezone_set('GMT');
		}
	
		$this->load->model('igain_model');		
		$joinat = date('Y-m-d');
		
		
		$email_id = $this->input->post('userEmailId');
				
		if($Card_id == "")
		{
			$User_pwd = $this->input->post('phno');
		}
		else
		{
			$User_pwd = $Card_id;
		}		
		$Dial_code_sql =  $this->db->select('phonecode')
						  ->from('igain_country_master')
						  ->where('id',$this->input->post('country'));
		$phonecode = $this->db->get()->row()->phonecode;
		
		$Phone_no = $phonecode."".$this->input->post('phno');
		
		$data['First_name'] = $this->input->post('firstName'); 
		$data['Middle_name'] = $this->input->post('middleName');        
		$data['Last_name'] = $this->input->post('lastName');        
		$data['Current_address'] =  App_string_encrypt($this->input->post('currentAddress')); 
		$data['State'] = $this->input->post('state');
		$data['District'] = $this->input->post('district');
		$data['City'] = $this->input->post('city');
		$data['Zipcode'] = $this->input->post('zip');
		$data['Country'] = $this->input->post('country');
		// $data['Phone_no'] = $this->input->post('phno');
		$data['Phone_no'] = App_string_encrypt($Phone_no); //$Phone_no;
		$data['Date_of_birth'] =date('Y-m-d H:i:s',strtotime($this->input->post('dob')));
		$data['Sex'] = $this->input->post('sex');
		$data['Qualification'] = $this->input->post('qualifi');
		$data['Photograph'] = $filepath;
		$data['Country_id'] = $this->input->post('country');
		// $data['User_email_id'] = $this->input->post('userEmailId');
		$data['User_email_id'] = App_string_encrypt($email_id);//$email_id;
		$data['Company_id'] = $data3['Company_id'];
		$Company_id = $data3['Company_id'];
		$data['User_id'] = $this->input->post('User_id');
		

		$data['joined_date'] = $joinat;
		$data['User_activated'] = '1';
		
		if($this->input->post('User_id') == 1 || $this->input->post('User_id') == 6)
		{
			$data['timezone_entry'] = $data3['timezone_entry'];
		}
		else
		{
			$data['timezone_entry'] = $this->input->post('Time_Zone');
			$data['Allow_services'] = $this->input->post('Allow_services');
			if($data['Allow_services']=="" || $data['Allow_services']==NULL)
			{
				$data['Allow_services'] =0;
			}
		}		
		$data['Create_user_id'] = $data3["enroll"];
		$data['Super_seller'] = $this->input->post('Super_seller');
		$data['Sub_seller_admin'] = $this->input->post('Sub_seller_admin');
		$data['Sub_seller_Enrollement_id'] = $this->input->post('Sub_seller_Enrollement_id');
		$data['Seller_Redemptionratio'] = $this->input->post('Seller_Redemptionratio');
		$data['Seller_Billingratio'] = $this->input->post('Seller_Paymentratio');
		$data['Seller_redemption_limit'] = $this->input->post('Seller_Redemptionlimit');
		$data['Merchant_sales_tax'] = $this->input->post('Seller_sales_tax');
		$data['Seller_api_url'] = $this->input->post('Seller_api_url');
		$data['Seller_api_url2'] = $this->input->post('Seller_api_url2');
		$data['goods_till_number'] = $this->input->post('Seller_goods_till_number');
		$data['Order_preparation_time'] = $this->input->post('Order_preparation_time');
		$data['Table_no_flag'] = $this->input->post('Table_no_flag');
		$refree_val = $this->input->post('Refree_name');
		$EnrollmentId = $this->input->post('EnrollmentId');
		// $Refree_name = $data['Refrence'];
		
		$pos_ = strpos($refree_val,'-') + 1;
		// $data['Refrence'] = substr($refree_val,$pos_);
		$data['Refrence'] = $ref_Customer_enroll_id;
		
		
		$data['Purchase_Bill_no'] = date("Y")."-".$this->input->post('Purchase_Bill_no');
		$data['Topup_Bill_no'] = date("Y")."-".$this->input->post('Topup_Bill_no');
		$data['Seller_Billing_Bill_no'] = date("Y")."-".$this->input->post('RetailersPaymentBill_no');
		// $data['Current_balance'] = $this->input->post('Current_balance');
		$data['source'] = 'Website';
		$data['Website'] = $this->input->post('Website');
		$data['Mpesa_auth_key'] = $this->input->post('Mpesa_auth_key');
		$card_decsion = $data3['card_decsion'];
		
		if($data['Sub_seller_admin']=="" )
		{
			$data['Sub_seller_admin'] ='0';
		}
		if($data['Super_seller']=="" )
		{
			$data['Super_seller'] ='0';
		}		
		$User_type_id = $this->input->post('User_id');	
		$Refrence=$Refrence=$this->input->post('Refrence');
		if($Refrence!="")
		{
			$Refrence=$Refrence=$this->input->post('Refrence');
		}
		else
		{
			$Refrence=0;
		}
		
		if($User_type_id == 1)
		{
			$data['Sub_seller_admin'] ='0';
			$data['Super_seller'] ='0';
			$data['Seller_Redemptionratio'] ='0';
			$data['Seller_Billingratio'] ='0';
			$data['Seller_redemption_limit'] ='0';
			$data['Merchant_sales_tax'] ='0';
			// $data['Total_topup_amt'] = $Customer_topup;
			// $data['Current_balance'] = $Customer_topup;
			$data['Card_id'] = $Card_id;
			
			$TierID = $this->input->post('member_tier_id');
			$data['Tier_id'] = $TierID;
		
			$RefrenceD = 0;
			
			if($card_decsion =='1')
			{
				// $Card_id1=$Card_id+1;
				$Card_id++;
				
				$UpdateCardID = $this->UpdateCompanyMembershipID($Card_id,$Company_id);			
			}
			
			
			/* 08-03-2021 */
				$this->load->model('Igain_model');
				$CMPresultis = $this->Igain_model->get_company_details($Company_id);
				/* echo "---Enable_company_meal_flag----".$CMPresultis->Enable_company_meal_flag."-----<br>";
				echo "---Meal_balance----".$this->input->post('Meal_balance')."-----<br>";
				echo "---Customer_topup----".$Customer_topup."-----<br>"; */
				if($this->input->post('Meal_balance')){
					$Meal_balance = $this->input->post('Meal_balance');
				} else {
					$Meal_balance = 0;
				}
				if($CMPresultis->Enable_company_meal_flag ==1 ){
					
					$data['Current_balance'] = $Customer_topup + $Meal_balance;
					$data['Total_topup_amt'] = $Customer_topup + $Meal_balance;
					// $data['Staff_flag'] =1;
					
				} else {
					
					$data['Current_balance'] = $Customer_topup;
					$data['Total_topup_amt'] = $Customer_topup;
					// $data['Staff_flag'] =0;
					
				}				
			/* 08-03-2021 */
			
			
			
		}
		else
		{
            $data['Card_id'] = 0;
			$data['Latitude'] = $this->input->post('Latitude');
			$data['Longitude'] = $this->input->post('Longitude');
			$data['Refrence'] =$Refrence ;			
			$data['Tier_id'] = 0;
		}
		
		// die;
				/******************18-05-2017*******Ravi***********/
					if($this->input->post('Label_1_value') != "")
					{
						$data['Label_1_value'] = $this->input->post('Label_1_value');
					}
					else
					{
						$data['Label_1_value'] ="";
					}
					if($this->input->post('Label_2_value') != "")
					{
						$data['Label_2_value'] = $this->input->post('Label_2_value');
					}
					else
					{
						$data['Label_2_value'] ="";
					}
					if($this->input->post('Label_3_value') != "")
					{
						$data['Label_3_value'] = $this->input->post('Label_3_value');
					}
					else
					{
						$data['Label_3_value'] ="";
					}
					if($this->input->post('Label_4_value') != "")
					{
						$data['Label_4_value'] = $this->input->post('Label_4_value');
					}
					else
					{
						$data['Label_4_value'] ="";
					}
					if($this->input->post('Label_5_value') != "")
					{
						$data['Label_5_value'] = $this->input->post('Label_5_value');
					}
					else
					{
						$data['Label_5_value'] ="";
					}					
				/******************18-05-2017*******Ravi***********/

				
	
		$data['pinno'] = $this->getRandomString();
		$data['User_activated'] = '1';
		$data['User_pwd'] = App_string_encrypt($data['pinno']); 
		
		if($data['Card_id']=="")
		{
			$data['Card_id']='0';
		}	

		/***************AMIT CHANGED START********************************************************/
			if($User_type_id == 5)//Merchandize Partner
			{
				$data['Merchandize_Partner_ID'] = $this->input->post('Merchandize_Partner_ID');
				$data['Merchandize_Partner_Branch'] = $this->input->post('Merchandize_Partner_Branch');
				$data['Card_id'] ="";
			}	
		/***************AMIT CHANGED END********************************************************/
		
		/***************Ravi CHANGED START****29-08-2017****************************************************/
			if($User_type_id == 6)//Call Center User
			{
				// $data['Call_center_user'] = $this->input->post('Call_center_user');
				$data['Call_center_user'] = 1;
								
			}
			else			
			{
				$data['Call_center_user'] = 0;
				// $data['Sub_seller_Enrollement_id']=0;
				
			}
			if($this->input->post('Supervisor')== 0)
			{
				$data['Sub_seller_Enrollement_id'] = $this->input->post('Supervisor_Enrollement_id');
				$data['Sub_seller_admin']=0;
			}
			// if($this->input->post('Call_center_user')== 0)
			if($data['Call_center_user']== 0)
			{
				$data['Call_center_user'] = 0;
				$data['Sub_seller_Enrollement_id']=0;
			}
		/***************Ravi CHANGED END***29-08-2017*****************************************************/			
			if($this->input->post('Supervisor1')== 0)
			{
				$data['Sub_seller_Enrollement_id'] = $this->input->post('Supervisor_Enrollement_id1');
				$data['Sub_seller_admin']=0;
			}
		
		/***************Ravi CHANGED ***06-02-2018*****************************************************/	
		if($User_type_id == 2)
		{			
			if($data['Sub_seller_admin']== 0)  //Admin Staff or Backend Merchant User
			{
				$data['Sub_seller_Enrollement_id'] = $this->input->post('Sub_seller_Enrollement_id');
			}
		}
		/***************Ravi CHANGED ***06-02-2018*****************************************************/
		
		/* 23-04-2021 for Staff_flag  */
		if($this->input->post('Staff_flag'))
		{
			$data['Staff_flag'] = $this->input->post('Staff_flag');
		}
		else
		{
			$data['Staff_flag']= 0;
		}
		/* 23-04-2021 for Staff_flag  */
		
	
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
			// return true;
			return $enrollID;
		}
		else
		{
			return 0;
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
	function FetchSellerEnrollmentRule($SellerID,$Company_id)
	{
		
		$this->db->select('*');
		$this->db->from('igain_seller_refrencerule');		
		$this->db->where(array('Seller_id' =>$SellerID,'Company_id ' => $Company_id)); 
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
	
	public function enrollment_list($limit,$start)
	{
		
		// $this->db->limit($limit,$start);
		$this->db->order_by('Enrollement_id','desc'); 
		// $this->db->order_by('User_id','asc');
        $query = $this->db->get("igain_enrollment_master");

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
   
	public function enrollment_count()
	{
		return $this->db->count_all("igain_enrollment_master");
		
	}
	public function Company_enrollment_count($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		 $query = $this->db->get('igain_enrollment_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];
		
	}
   
   public function edit_enrollment($Enrollement_id)
   {	   
		$edit_enroll_query = "SELECT * FROM igain_enrollment_master WHERE Enrollement_id=$Enrollement_id LIMIT 1";
		
		$edit_enroll_sql = $this->db->query($edit_enroll_query);
				
		if($edit_enroll_sql -> num_rows() == 1)
		{
			return $edit_enroll_sql->row();
		}
		else
		{
			return false;
		}		
	}
   
	public function update_enrollment($post_data,$Enrollement_id)
	{ 
		/* echo "<pre>";
		var_dump($post_data);
		echo "</pre>";die; */
		
		$this->db->where('Enrollement_id',$Enrollement_id);
		$this->db->delete('igain_hobbies_interest');
		
		$Company_id = $post_data['Company_id'];
		$hobbies = $this->input->post('hobbies');
		
		if($hobbies != "")
		{
			foreach($hobbies as $hobbi)
			{
				$hb_data = array(
				'Company_id' => $Company_id,
				'Enrollement_id' => $Enrollement_id,
				'Hobbie_id' => $hobbi
				);
				
				$this->db->insert('igain_hobbies_interest',$hb_data);
			}
		}
		
		$this->db->where('Enrollement_id', $Enrollement_id);
		$this->db->update('igain_enrollment_master', $post_data); 
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function get_membername($keyword,$Company_id) 
	{        
		$this->db->select("First_name,Last_name,Enrollement_id,Card_id");
        $this->db->order_by('First_name', 'ASC');
        $this->db->like("Card_id", $keyword);
		$this->db->where(array('User_id' => '1','Card_id !=' => '0','User_activated' => '1','Company_id' => $Company_id));
        $query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['First_name']))." ".htmlentities(stripslashes($row['Last_name']."-".$row['Card_id']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
    }
	
	public function delete_enrollment($Enrollement_id)
	{
		$this->db->where('Enrollement_id', $Enrollement_id);
		$this->db->update('igain_enrollment_master',array('User_activated'=>0));
		
		//$this->db->delete('igain_enrollment_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	function duplicate_emailcheck($email_id)
    {
     	$q =  $this->db->select('Email_id')
				   ->from('igain_enrollment_master')
				   ->where(array('Email_id' => $email_id))->get();
		return $q->num_rows();			    
    }
    
    public function Selected_company_enrollment_list($limit,$start,$Company_id)
	{
	  // $this->db->limit($limit,$start);
	  $post_data=$this->db->select('Enrollement_id,First_name,Last_name,Current_address,Card_id,Phone_no,Sex,User_email_id,User_id,Current_balance,Blocked_points');
	  // $this->db->order_by('User_id','asc'); 
	   $this->db->order_by('Enrollement_id','desc'); 
	  $this->db->from('igain_enrollment_master'); 
	  $this->db->where(array('User_id != ' => '3','User_activated' => '1','Company_id' => $Company_id));
	  // $this->db->where('Company_id',$Company_id); 
	  // $this->db->where('User_id !=','3');
	  // $this->db->where('User_activated','1'); 
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
	public function Selected_company_enrollment_list_login_seller($limit,$start,$Company_id,$enrollID)
	{
	  // $this->db->limit($limit,$start);
	  $post_data=$this->db->select('Enrollement_id,First_name,Last_name,Current_address,Card_id,Phone_no,Sex,User_email_id,User_id,Current_balance,Blocked_points');
	  // $this->db->order_by('User_id','asc'); 
	   $this->db->order_by('Enrollement_id','desc'); 
	  $this->db->from('igain_enrollment_master'); 
	  $this->db->where(array('User_id != ' => '3','User_activated' => '1','Company_id' => $Company_id,'Create_user_id' => $enrollID));
	  // $this->db->where('Company_id',$Company_id); 
	  // $this->db->where('User_id !=','3');
	  // $this->db->where('User_activated','1'); 
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
	
	public function get_total_merchant($Company_id)
	{
	  $post_data=$this->db->select('Enrollement_id');
	  $this->db->from('igain_enrollment_master'); 
	  $this->db->where(array('User_id  ' => '2','Sub_seller_admin' => '1','User_activated' => '1','Company_id' => $Company_id));
	  $company_sql= $this->db->get();
	  //echo "number ".$company_sql->num_rows();
		return $company_sql->num_rows();
		
	}
	public function Selected_company_customer_list($limit,$start,$Company_id)
	{
		// $this->db->limit($limit,$start);
		$post_data=$this->db->select('Enrollement_id,First_name,Last_name,Current_address,Card_id,Phone_no,Sex,User_email_id,User_id,Current_balance,Blocked_points');
		// $this->db->order_by('User_id','asc'); 
		$this->db->order_by('Enrollement_id','desc'); 
		$this->db->from('igain_enrollment_master'); 
		$this->db->where(array('User_id ' => '1','User_activated' => '1','Company_id' => $Company_id));
		// $this->db->where('Company_id',$Company_id); 
		// $this->db->where('User_id !=','3');
		// $this->db->where('User_activated','1'); 
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
	
 //******************** Ravi Work end **************************
 
 //******************** Sandeep Work start **************************
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
		$query = "select phonecode from igain_country_master where id='".$Country_id."'";
	
				$sql = $this->db->query($query);
				foreach ($sql->result() as $row)
				{
					$dial_code = $row->phonecode;
				}
		return 	$dial_code;	
	 }
	 
  function validate_member($Company_id,$Country_id)
  {
		$fname_value = $this->input->post('fname');
		
		 if(!is_numeric($fname_value))
		 {
			$pieces = explode(" ",$fname_value);
			$firstname=$pieces[0]; // piece1
					
			$query = "select Enrollement_id from  igain_enrollment_master where igain_enrollment_master.First_name='".$firstname."' AND Company_id='".$Company_id."' AND  User_id='1' and Card_id='0'";	

			$sql = $this->db->query($query);
					
			if($sql -> num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$Enrollement_id = $row->Enrollement_id;
				}
				
				return $Enrollement_id;
			}
			else
			{
				return false;
			}
				
		 }
		 else
		 {
			// $Country_id = $this->get_country($Company_id);
			
			$dial_code = $this->get_dial_code($Country_id);
			
			$phnumber = App_string_encrypt($dial_code.$fname_value);
					
			$query = "select Enrollement_id from  igain_enrollment_master where igain_enrollment_master.Phone_no='".$phnumber."' AND Company_id='".$Company_id."' AND  User_id='1' and Card_id='0'";	
			//echo $query."---"; die;
			$sql = $this->db->query($query);
					
			if($sql -> num_rows() > 0)
			{
				foreach ($sql->result() as $row)
				{
					$Enrollement_id = $row->Enrollement_id;
				}
				
				return $Enrollement_id;
			}
			else
			{
				return false;
			}
		 }
		
  }
  
	public function enroll_referralrule_count($Company_id,$Seller_id)
	{
		$this->db->select('refid');
        $this->db->from('igain_seller_refrencerule as A');
		$this->db->where(array('A.Company_id' => $Company_id, 'A.Seller_id' => $Seller_id, 'A.Referral_rule_for' => '1'));
		
		$querySD = $this->db->get();
		
		return $querySD->num_rows();
	}
        
        public function Fetch_member_hobbies($Company_id,$Enrollement_id)
	{
		$this->db->select('*');
                $this->db->from('igain_hobbies_interest');
		$this->db->where(array('Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id));		
		$query = $this->db->get();
		
                if($query -> num_rows() > 0)
                {
                    return $query->result();
                }
                else
                {
                    return false;
                }
	}
  
 //******************** Sandeep Work end **************************
 //******************** Ravi- for Mercahnt Category-26-08-2016 **************************
 
	function insert_merchant_category($cat_array)
    {			
		$this->db->insert('igain_item_category_master', $cat_array);		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
	
	public function edit_merchant_category($Company_id,$Enrollement_id)
	{	   
		$this->db->where(array('Company_id' => $Company_id, 'Seller' => $Enrollement_id));
		$query = $this->db->get("igain_item_category_master");
				
		if($query -> num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}		
	}
	//******************** Ravi- for Mercahnt Category-26-08-2016 **************************
	function Insert_menu_assign($menu_array)
    {			
		$this->db->insert('igain_menu_assign', $menu_array);
		echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }
 	function Fetch_Finance_user_details($Company_id)
	{
		$this->db->select('Enrollement_id,First_name,Last_name,Phone_no,User_email_id');
		$this->db->from('igain_enrollment_master');		
		$this->db->where(array('User_id '=> '7','Company_id ' => $Company_id,'Sub_seller_admin ' => '1','User_activated ' => '1')); 
		$SubsellerSql= $this->db->get();		
		return $SubsellerSql->result_array();		
	}
	public function get_member_info($Card_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Card_id' => $Card_id,'Company_id' => $Company_id,'User_id' => '1'));
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
	function get_tier_details($member_tier_id,$compID)
	{
		$this->db->select('Redeemtion_limit');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Tier_id'=> $member_tier_id,'Company_id'=> $compID));
		$this->db->order_by('Tier_level_id');
		
		$tier_query = $this->db->get();
		
		if($tier_query->num_rows() > 0)
		{	
			return $tier_query->row();
		}
		else
		{
			return false;
		}
		
		return false;
	}
}
?>