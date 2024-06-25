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
		
		$sm12 = array_unique(array_merge($sm1,$SixMonthArray));
		
		foreach($sm12 as $month)
		{
			$start_date = date("Y-m",strtotime($month))."-01";
			$end_date = date("Y-m",strtotime($month))."-31";

			$curr_date = date("M-Y");
			
			$total_redeem_points = 0;
			$total_lv_points = 0;
			
		//********* Monthly Enrolled Members ****************/
		
			$this->db->select("Enrollement_id");
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('Company_id' =>$company_id, 'User_id' => '1'));
			$this->db->where("joined_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
			$Total_monthly_members = $this->db->count_all_results();
				
			$this->db->select("*");
			$this->db->from("igain_member_enrollment_graph");
			$this->db->where(array("Company_id" => $company_id, "smry_month" =>$month ));
			
			$result20 = $this->db->get();
			
			if($result20->num_rows() > 0 && $Total_monthly_members > 0)
			{
				$data20 = array(
					
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
		
		//********* Monthly Enrolled Members ****************/
		
			
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
					$this->db->select_sum("Loyalty_pts");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id, "Trans_type" => '2', "Loyalty_pts !=" =>'0' ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				
					$result2 = $this->db->get();

					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $row2)
						{
							$Total_loyalty_points = $row2->Loyalty_pts;
						}
					}
					
				//	echo "--the Total_loyalty_points--".$Total_loyalty_points."---<br>";
					
					$this->db->select_sum("Redeem_points");
					$this->db->from("igain_transaction");
					$this->db->where(array("Company_id" => $company_id, "Trans_type IN (2,3)", "Redeem_points !=" =>'0' ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				
					$result3 = $this->db->get();

					if($result3->num_rows() > 0)
					{
						foreach($result3->result() as $row3)
						{
							$Total_redeem_points = $row3->Redeem_points;
						}
					}
					
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
					$this->db->where(array("Company_id" => $company_id, "Trans_type IN (2,3)", "Redeem_points !=" =>'0' ));
					$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
				
					$result5 = $this->db->get();
					
					$Total_redeem_count  = $result5->num_rows();
					
					//echo "--the Total_redeem_count--".$Total_redeem_count."---<br>";
					
					
					$data55 = array(
					
					'Total_redeem_points' => $Total_redeem_points,
					'Total_loyalty_points' => $Total_loyalty_points,
					'Total_redeem_count' => $Total_redeem_count,
					'Total_loyalty_count' => $Total_loyalty_count
					);
					
					$this->db->where(array("Company_id" => $company_id,"smry_month" =>$month ));
					$this->db->update("igain_points_distribution_graph",$data55);
					
				}
				
			}
			else
			{
				$this->db->select_sum("Loyalty_pts");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id, "Trans_type" => '2', "Loyalty_pts !=" =>'0' ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
				$result2 = $this->db->get();

				if($result2->num_rows() > 0)
				{
					foreach($result2->result() as $row2)
					{
						$Total_loyalty_points = $row2->Loyalty_pts;
					}
				}
				
				//echo "--the Total_loyalty_points--".$Total_loyalty_points."---<br>";
				
				$this->db->select_sum("Redeem_points");
				$this->db->from("igain_transaction");
				$this->db->where(array("Company_id" => $company_id, "Trans_type IN (2,3)", "Redeem_points !=" =>'0' ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
				$result3 = $this->db->get();

				if($result3->num_rows() > 0)
				{
					foreach($result3->result() as $row3)
					{
						$Total_redeem_points = $row3->Redeem_points;
					}
				}
				
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
				$this->db->where(array("Company_id" => $company_id, "Trans_type IN (2,3)", "Redeem_points !=" =>'0' ));
				$this->db->where("Trans_date BETWEEN '".$start_date."' AND '".$end_date."' ");
			
				$result5 = $this->db->get();
				
				$Total_redeem_count  = $result5->num_rows();
				
				//echo "--the Total_redeem_count--".$Total_redeem_count."---<br>";
				
				if($Total_loyalty_count > 0 || $Total_redeem_count > 0)
				{
					$data12['smry_month'] = $month;
					$data12['Total_redeem_points'] = $Total_redeem_points;
					$data12['Total_loyalty_points'] = $Total_loyalty_points;
					$data12['Total_redeem_count'] = $Total_redeem_count;
					$data12['Total_loyalty_count'] = $Total_loyalty_count;
					$data12['Company_id'] = $company_id;
					
					$this->db->insert("igain_points_distribution_graph",$data12);
				}
				
			}
			
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
		//********* Active Vs Inactive Members ****************/
		
	}
	
	public function member_status_graph_detail($company_id)
	{
		$this->db->from("igain_member_status_graph");
		$this->db->where(array("Company_id" => $company_id));
		
		$result13 = $this->db->get();
		
		if($result13->num_rows() > 0)
		{	
			return $result13->result();
		}
			
		return 0;
	}
	
	public function six_monthly_enrollment_graph_details($company_id)
	{
		$this->db->limit(6);
		$this->db->from("igain_member_enrollment_graph");
		$this->db->where(array("Company_id" => $company_id));
		$this->db->order_by("smry_id DESC");
		
		$result130 = $this->db->get();
		
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
	
	public function six_months_points_graph_detail($company_id)
	{
		$this->db->limit(6);
		$this->db->from("igain_points_distribution_graph");
		$this->db->where(array("Company_id" => $company_id));
		$this->db->order_by("smry_id DESC");
		$result1 = $this->db->get();

		if($result1->num_rows() > 0)
		{	
			return $result1->result();
		}
			
		return 0;	
	}
	
	public function member_feedback($CompanyId)
	{
		$this->db->like("Question","Are you satisfied which the Products and Services offered?");
		$this->db->select("Question_id");
		$this->db->from("igain_questionaire_master");
		$this->db->where(array("Company_id" => $CompanyId));
		
		$opt11 = $this->db->get();
		
		if($opt11->num_rows() > 0)
		{
			foreach($opt11->result() as $row11)
			{
				$Question_id = $row11->Question_id;
				
				//echo "Question_id---".$Question_id."--<br>";
			}
		}
		
		$this->db->from("igain_response_master");
		$this->db->where(array("Company_id" => $CompanyId, "Response2" =>1, "Question_id" => $Question_id));

		$Total_satisfied = $this->db->count_all_results();

		$this->db->from("igain_response_master");
		$this->db->where(array("Company_id" => $CompanyId, "Response2" =>0, "Question_id" => $Question_id));
		
		$Total_unsatisfied = $this->db->count_all_results();
		
		if($Total_satisfied > 0 || $Total_unsatisfied > 0)
		{
			$opt["Total_satisfied"] = $Total_satisfied;
			$opt["Total_unsatisfied"] = $Total_unsatisfied;

			return $opt;
		}

		return 0;
		
	}
	
	public function get_customers_comment($CompanyID)
	{
		$this->db->like("Question","Any Suggestions /Improvement Areas!");
		$this->db->select("Question_id");
		$this->db->from("igain_questionaire_master");
		$this->db->where(array("Company_id" => $CompanyID));
		
		$opt11 = $this->db->get();
		
		if($opt11->num_rows() > 0)
		{
			foreach($opt11->result() as $row11)
			{
				$Question_id = $row11->Question_id;
				
				//echo "Question_id---".$Question_id."--<br>";
			}
		}
		
		$this->db->limit(5);
		$this->db->select("a.Response1,a.Enrollment_id,b.First_name,b.Last_name");
		$this->db->from("igain_response_master as a");
		$this->db->join("igain_enrollment_master as b","a.Enrollment_id = b.Enrollement_id");
		$this->db->where(array('a.Company_id' => $CompanyID, 'Question_id' => $Question_id));
		
		$query42 = $this->db->get();
		//echo $this->db->last_query();
		if($query42->num_rows() > 0)
		{	
			return $query42->result_array();
		}
			
		return 0;
	}
	
	public function get_happy_customers($Company_id)
	{	
		$this->load->model('igain_model');
		$i = 0;  $custenroll_ids = array();  $cust_array = array();  $Total_Purchase_amount = array();  $Total_Loyalty_pts = array();
		$lastmonth = date("Y-m-d", strtotime("-1 month")); /*** last 3 month ***/
		$thismonth = date("Y-m-d");
		$Trans_type = array('2','3');
		
		$this->db->select('Enrollement_id');
		$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1'));
		$query = $this->db->get('igain_enrollment_master');
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$cust_array[] = $row['Enrollement_id'];
			}
		}
		
		foreach($cust_array as $cust1)
		{
			$this->db->select_sum("A.Purchase_amount");
			$this->db->select_sum("A.Loyalty_pts");
			$this->db->select("B.First_name, B.Last_name, B.User_email_id, B.Phone_no");
			$this->db->from('igain_transaction as A');
			$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.Enrollement_id');			
			$this->db->where(array('A.Enrollement_id' => $cust1));
			$this->db->where("A.Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' ");
			$this->db->where_in('A.Trans_type', $Trans_type);
			$query1 = $this->db->get();
			
			foreach ($query1->result_array() as $row1)
			{
				$Total_Purchase_amount[$i] = $row1['Purchase_amount'];
				$Total_Loyalty_pts[$i] = $row1['Loyalty_pts'];	
				$Customer_name[$i] = $row1['First_name']." ".$row1['Last_name'];
				$Customer_email[$i] = $row1['User_email_id'];
				$Customer_phno[$i] = $row1['Phone_no'];
				$i++;
				
				if($i == 5)
				{
					break;
				}
				
			}
		}
		
		$data['Total_Purchase_amount'] = $Total_Purchase_amount;
		$data['Total_Loyalty_pts'] = $Total_Loyalty_pts;				
		$data['Customer_name'] = $Customer_name;
		$data['Customer_email'] = $Customer_email;
		$data['Customer_phno'] = $Customer_phno;		
		return $data;
	}
	
	public function get_worry_customers($Company_id)
	{	
		$this->load->model('igain_model');
		$i = 0; $j = 0;  $custenroll_ids = array();  $cust_array = array();  $Total_Purchase_amount = array();  $Total_Loyalty_pts = array();
		$lastmonth = date("Y-m-d", strtotime("-1 month")); /*** last 3 month ***/
		$thismonth = date("Y-m-d");
		$Trans_type = array('2','3');
		
		$this->db->select('Enrollement_id');
		$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1'));
		$query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$cust_array1[] = $row['Enrollement_id'];
			}
		}
		
		$this->db->select('A.Enrollement_id');
		$this->db->from('igain_transaction as A');
		$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.Enrollement_id');
		$this->db->where(array('B.User_activated' => '1', 'B.User_id' => '1', 'A.Company_id' => $Company_id));
		$this->db->where("A.Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' ");
		$this->db->where_in('A.Trans_type', $Trans_type);
		$query1 = $this->db->get();
		
		if($query1->num_rows() > 0)
		{
			foreach ($query1->result_array() as $row1)
			{
				$custenroll_ids[$i] = $row1['Enrollement_id'];
				$i++;
			}
		}
		
		$custenroll_ids = array_unique($custenroll_ids);		
		$Worry_cust = array_diff($cust_array1,$custenroll_ids);
		
		foreach($Worry_cust as $cust1)
		{
			$this->db->limit(1);
			$this->db->select("B.First_name, B.Last_name, B.User_email_id, B.Phone_no, A.Trans_date");
			$this->db->from('igain_transaction as A');
			$this->db->join('igain_enrollment_master as B', 'B.Enrollement_id = A.Enrollement_id');			
			$this->db->where(array('A.Enrollement_id' => $cust1, 'A.Company_id' => $Company_id));
			$this->db->order_by("Trans_id DESC");
			$query2 = $this->db->get();
			
			if($query2->num_rows() > 0)
			{
				foreach ($query2->result_array() as $row2)
				{
					$Customer_name[$j] = $row2['First_name']." ".$row2['Last_name'];
					$Customer_last_visit[$j] = $row2['Trans_date'];
					$j++;
				}
			}
			else
			{
				$cust_details = $this->igain_model->get_enrollment_details($cust1);
				$Customer_name[$j] = $cust_details->First_name." ".$cust_details->Last_name;
				// $Customer_last_visit[$j] = $cust_details->last_visit_date;
				$Customer_last_visit[$j] = $cust_details->joined_date;
				$j++;
			}
			
			if($j == 5)
			{
				break;
			}
		}
		
		$data['Worry_Customer_name'] = $Customer_name;
		$data['Customer_last_visit'] = $Customer_last_visit;		
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
}
?>
