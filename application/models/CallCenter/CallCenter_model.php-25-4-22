<?php
class CallCenter_model extends CI_Model
{
/*-------------------------------Nilesh Work Start 10-07-2017----------------------------------*/
	function get_user_type($user_type)  
	{
		$this->db->select("*");
		$this->db->from('igain_user_type_master');						
		$this->db->where_in('User_id', array('6'));
		// $this->db->where_in('User_id', array('2','3','4','5'));		
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
	public function Call_center_query_type($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		$query = $this->db->get('igain_callcenter_querytype_master');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function Call_center_query_type_list($limit,$start,$Company_id)
	{
		// if($limit!=NULL || $start !=NULL)
		// {
			// $this->db->limit($limit,$start);
		// }
		$post_data=$this->db->select('*');
		$this->db->order_by('Query_type_id','desc'); 
		$this->db->from('igain_callcenter_querytype_master'); 
		$this->db->where(array('Company_id' => $Company_id));
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
	function Get_user_name($User_id,$Company_id)
	{
		$this->db->select('Enrollement_id,First_name,Middle_name,Last_name');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id'=>$User_id,'Company_id'=>$Company_id,'User_activated'=>1,'Call_Center_User'=>1, 'Sub_seller_admin' =>0));
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
	function Get_SuperSeller_user_name($User_id,$Company_id)
	{	
		$this->db->select('Enrollement_id,First_name,Middle_name,Last_name');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('User_id'=>$User_id,'Company_id'=>$Company_id,'User_activated'=>1,'Call_center_user'=>1,'Sub_seller_admin' =>1));
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
	public function Check_Call_center_query_type($Query_type_name,$Company_id)
	{			
		$query =  $this->db->select('Query_type_name')
	   ->from('igain_callcenter_querytype_master')
	   ->where(array('Query_type_name' => $Query_type_name,'Company_id' => $Company_id))->get();	   
		return $query->num_rows();			
	}	
	function insert_callcenter_querytype_master($Post_data)
	{
		$this->db->insert('igain_callcenter_querytype_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	function insert_callcenter_querytype_child($Post_data)
	{
		$this->db->insert('igain_callcenter_querytype_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		
			return false;
					
	}
	public function Get_Call_center_query_type($Company_id,$Query_type_id)
	{		
		$this->db->select("*");
		$this->db->from('igain_callcenter_querytype_master');
		$this->db->where(array('Company_id' => $Company_id,'Query_type_id' => $Query_type_id));		
		$sql50 = $this->db->get();	
		
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else 
		{
			return false;
		}
	}
	public function Get_Call_center_query_type_child($Company_id,$Query_type_id)
	{		
		$this->db->select("*");
		$this->db->from('igain_callcenter_querytype_child');
		$this->db->where(array('Company_id' => $Company_id, 'Query_type_id' => $Query_type_id));		
		$sql50 = $this->db->get();	
		if($sql50 -> num_rows() > 0)
		{
			foreach ($sql50->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
			return false;	
	}
	public function company_cc_user_list($Company_id)
	{
		$query = $this->db->where(array("Company_id" => $Company_id, "User_id" => 6, "Sub_seller_admin" =>0));
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
	function Update_Call_center_query_type($Post_data,$QueryType_id,$Company_id)
    {			
		$this->db->where(array('Query_type_id' => $QueryType_id,'Company_id' => $Company_id));
		$this->db->update('igain_callcenter_querytype_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	function Delete_Call_center_query_type_child($QueryType_id,$Company_id)
	{
		$this->db->where(array("Query_type_id" => $QueryType_id, "Company_id" => $Company_id));
		$this->db->delete("igain_callcenter_querytype_child");
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Call_center_query_type_child($Post_data1) 
	{
		$this->db->insert('igain_callcenter_querytype_child',$Post_data1);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	public function Call_center_sub_queries_count($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		 $query = $this->db->get('igain_callcenter_querysetup_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	function Call_center_queryType($companyId)  
	{
		$this->db->select("*");
		$this->db->from('igain_callcenter_querytype_master');
		$this->db->where('Company_id', $companyId);
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
	public function Call_center_sub_query_type_list($limit,$start,$Company_id)
	{
		// if($limit!=NULL || $start !=NULL)
		// {
			// $this->db->limit($limit,$start);
		// }
		$post_data=$this->db->select('*');
		$this->db->order_by('Query_id','desc'); 
		$this->db->from('igain_callcenter_querysetup_master'); 
		$this->db->where(array('Company_id' => $Company_id));
		$company_sql= $this->db->get();
		// echo $this->db->last_query();
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
	public function Check_Call_center_Sub_query($Sub_Query_name,$Company_id)
	{			
		$query =  $this->db->select('Sub_query')
	   ->from('igain_callcenter_querysetup_master')
	   ->where(array('Sub_query' => $Sub_Query_name,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();				
	}
	function insert_callcenter_querySetup_master($Post_data)
	{
		$this->db->insert('igain_callcenter_querysetup_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}		
	}
	function Call_center_queryTypeName($Query_type_id)  
	{
		$this->db->select("*");
		$this->db->from('igain_callcenter_querytype_master');
		$this->db->where('Query_type_id', $Query_type_id);
		$sql = $this->db->get();
		if ($sql->num_rows() > 0)
		{
        	return $sql->row();
        }
		else
		{
			return false;
		}
	}
	public function Get_Call_center_sub_query($Company_id,$Query_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_querysetup_master');
		$this->db->where(array('Company_id' => $Company_id,'Query_id' => $Query_id));		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	function Update_Call_center_sub_query($Post_data,$Query_id,$Company_id)
    {	
		$this->db->where(array('Query_id' => $Query_id,'Company_id' => $Company_id));
		$this->db->update('igain_callcenter_querysetup_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	public function callcenter_resolutionpriority_level($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		 $query = $this->db->get('igain_callcenter_resolutionpriority_level_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function callcenter_resolutionpriority_level_list($limit,$start,$Company_id)
	{
		// if($limit!=NULL || $start !=NULL)
		// {
			// $this->db->limit($limit,$start);
		// }
		$post_data=$this->db->select('*');
		$this->db->order_by('Resolution_id','desc'); 
		$this->db->from('igain_callcenter_resolutionpriority_level_master'); 
		$this->db->where(array('Company_id' => $Company_id));
		$company_sql= $this->db->get();
		// echo $this->db->last_query();
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
	function Insert_Resolution_priority_levels($Post_data)
	{		
		$this->db->insert('igain_callcenter_resolutionpriority_level_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	public function Check_Resolution_priority_levels($PriorityLevel,$Company_id)
	{			
		$query =  $this->db->select('Resolution_priority_levels')
	   ->from(' igain_callcenter_resolutionpriority_level_master')
	   ->where(array('Resolution_priority_levels' => $PriorityLevel,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();			
	}	
	public function Check_Resolution_priority_levels_name($Level_name,$Company_id)
	{			
		$query =  $this->db->select('Level_name')
	   ->from(' igain_callcenter_resolutionpriority_level_master')
	   ->where(array('Level_name' => $Level_name,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();		
		
	}
	public function Get_Resolution_priority_levels($Company_id,$Resolution_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_resolutionpriority_level_master');
		$this->db->where(array('Company_id' => $Company_id,'Resolution_priority_levels' => $Resolution_id));		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	public function Get_Resolution_priority_id($Company_id,$Resolution_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_resolutionpriority_level_master');
		$this->db->where(array('Company_id' => $Company_id,'Resolution_id' => $Resolution_id));		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	public function Get_Resolution_priority_level_name($Company_id,$Resolution_priority_levels)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_resolutionpriority_level_master');
		$this->db->where(array('Company_id' => $Company_id,'Resolution_priority_levels' => $Resolution_priority_levels));		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	function Update_Resolution_priority_levels($Post_data,$Resolution_id,$Company_id)
    {		
		$this->db->where(array('Resolution_id' => $Resolution_id,'Company_id' => $Company_id));
		$this->db->update('igain_callcenter_resolutionpriority_level_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	public function Call_center_escalation_count($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		 $query = $this->db->get('igain_callcenter_escalation_matrix');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function Call_center_escalation_matrix_list($limit,$start,$Company_id)
	{
		// if($limit!=NULL || $start !=NULL)
		// {
			// $this->db->limit($limit,$start);
		// }
		$post_data=$this->db->select('*');
		$this->db->order_by('Escalation_matrix_id','desc'); 
		$this->db->from('igain_callcenter_escalation_matrix'); 
		$this->db->where(array('Company_id' => $Company_id));
		$company_sql= $this->db->get();
		// echo $this->db->last_query();
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
	function Insert_escalation_matrix_levels($Post_data)
	{	
		$this->db->insert('igain_callcenter_escalation_matrix',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}		
	}
	public function Check_No_of_Unresolved_Days_levels($Unresolved_Days,$Company_id)
	{			
		$query =  $this->db->select('No_of_unresolved_days	')
	   ->from('  igain_callcenter_escalation_matrix')
	   ->where(array('No_of_unresolved_days' => $Unresolved_Days,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();			
	}
	public function Get_escalation_levels($Company_id,$Escalation_matrix_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_escalation_matrix');
		$this->db->where(array('Company_id' => $Company_id,'Escalation_matrix_id' => $Escalation_matrix_id));		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	function Update_escalation_matrix_levels($Post_data,$Escalation_matrix_id,$Company_id)
    {		
		$this->db->where(array('Escalation_matrix_id' => $Escalation_matrix_id,'Company_id' => $Company_id));
		$this->db->update('igain_callcenter_escalation_matrix', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	/*----------------------------------------Ravi WOrk--13-07-2017------------------------------*/	
	public function Handle_member_query($Company_id,$first_name,$last_name,$dob,$card_id,$mobile_no,$email_id,$start,$limit)
	{
		$keyvar =array();
			$values = array();
			
			if($first_name != "")
			{
				$keyvar[] ="First_name";
				$values[] = $first_name;
			}
			
			if($last_name != "")
			{
				$keyvar[] ="Last_name";
				$values[] = $last_name;
			}
			
			if($card_id != "")
			{
				$keyvar[] ="Card_id";
				$values[] = $card_id;
			}
			
			if($mobile_no != "")
			{
				$keyvar[] ="Phone_no";
				$values[] = App_string_encrypt($mobile_no);
			}
			if($email_id != "")
			{
				$keyvar[] ="User_email_id";
				$values[] = App_string_encrypt($email_id);
				
			}
			if($dob != "" && $dob != '1970-01-01')
			{
				
				/* $dob3=date("d",strtotime($dob));
				$dob2=date("M-Y",strtotime($dob));
				$dob=$dob3.'-'.$dob2; */
				$dob2=date("Y-m-d H:i:s",strtotime($dob));				
				// echo"--DOB---".$dob2."--<br>";				
				$keyvar[] ="Date_of_birth";
				// $values[] = $dob;
				$values[] = $dob2;
			}			
			$run_me .= "Select Enrollement_id, First_name, Last_name, Card_id, Phone_no, User_email_id, Date_of_birth FROM  igain_enrollment_master where  Card_id <> 'NULL' AND User_activated=1  AND ";
			// var_dump($keyvar);
			
			for($j = 0;$j < count($values);$j++)
			{
				if($j == count($values) - 1)
				{
					
					if($keyvar[$j] == "First_name" || $keyvar[$j] == "Last_name")
					{
						$run_me .= " ".$keyvar[$j]." like '".$values[$j]."%' AND User_id ='1' AND Company_id=".$Company_id." ;";
					}
					else
					{
						$run_me .= "  ".$keyvar[$j]." = '".$values[$j]."' AND User_id ='1' AND Company_id=".$Company_id." ;";
					}
				}
				else
				{
					
					if($keyvar[$j] == "First_name" || $keyvar[$j] == "Last_name")
					{
						$run_me .= "  ".$keyvar[$j]." like '".$values[$j]."%' AND ";
					}
					else
					{
						$run_me .= "  ".$keyvar[$j]." = '".$values[$j]."' AND ";
					}
				}
			}
			// echo "the run time Sql is---->".$run_me;
			// $company_sql = $this->db->query("Select * from igain_company_master where Activated=1");
			$sql = $this->db->query($run_me);
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
	/*----------------------------------Ravi work end--------------------------------------*/
	/*----------------------------------Nilesh work Start--------------------------------------*/
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
	public function Get_sub_query_name1($Query_id,$Company_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_querysetup_master');
		$this->db->where(array('Company_id' => $Company_id,'Query_id' => $Query_id));		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->row();
		}
		else
		{
			return false;
		}
	}
	function get_prioritylevel($cmp_id)  
	{
		$this->db->select("*");
		$this->db->from('igain_callcenter_resolutionpriority_level_master');		
		$this->db->where('Company_id', $cmp_id);
		$this->db->group_by('Resolution_priority_levels');
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
	function Expected_closure_time($Query_priority,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_resolutionpriority_level_master');
		$this->db->where(array('Resolution_priority_levels'=>$Query_priority,'Company_id'=>$Company_id));
		$this->db->group_by('Resolution_priority_levels');
		$sql=$this->db->get();	
		if($sql->num_rows() == 1)
		{			
			return $sql->row();
		}
		else
		{
			return false;
		}		
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
	public function count_member_query_record($cust_membershipId,$Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where(array('Membership_id' => $cust_membershipId, 'Company_id' =>$Company_id));
		$query = $this->db->get('igain_callcenter_querylog_master');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function member_query_record_list($Company_id,$cust_membershipId)
	{
		
		$this->db->select('*');
		$this->db->from('igain_callcenter_querylog_master'); 
		$this->db->where(array('Membership_id' => $cust_membershipId, 'Company_id' => $Company_id));
		$this->db->order_by('Query_log_id','desc'); 
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
	function Get_Priority_level_detail($Query_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_resolutionpriority_level_master');
		$this->db->where(array('Resolution_priority_levels' => $Query_id, 'Company_id' => $Company_id));	
		$this->db->group_by('Resolution_priority_levels');
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
	public function Get_member_query_status_list($compId,$cust_membershipId)
	{
		
		$post_data=$this->db->select('DISTINCT(Query_status)');
		$this->db->from('igain_callcenter_querylog_master'); 
		$this->db->where(array('Membership_id' => $cust_membershipId, 'Company_id' => $compId));
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
	public function Search_member_query_record($TicketNo,$Company_id,$Query_status,$cust_membershipId)
	{
		$post_data=$this->db->select('*');
		$this->db->from('igain_callcenter_querylog_master');
		if($TicketNo !=NULL)
		{
			$this->db->where(array('Querylog_ticket' => $TicketNo, 'Company_id' => $Company_id, 'Company_id' => $Company_id));
		}		
		if($TicketNo !=NULL && $Query_status != NULL)
		{
			$this->db->where(array('Querylog_ticket' => $TicketNo, 'Company_id' => $Company_id, 'Company_id' => $Company_id,'Query_status' => $Query_status));
		}
		if($TicketNo ==NULL)
		{
			$this->db->where(array('Membership_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Company_id' => $Company_id ,'Query_status' => $Query_status));
		}
		$company_sql= $this->db->get();
		// echo $this->db->last_query();
		// die;
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
	public function count_member_redeemtion_tran($Enrollement_id,$cust_membershipId,$Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where(array('Enrollement_id' =>$Enrollement_id,'Card_id' => $cust_membershipId, 'Trans_type' => 10, 'Company_id' =>$Company_id));
		$query = $this->db->get('igain_transaction');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function count_member_redeemtion_tran_search($from_date,$to_date,$Enrollement_id,$cust_membershipId,$Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where(array('Enrollement_id' =>$Enrollement_id,'Card_id' => $cust_membershipId, 'Trans_type' => 10, 'Company_id' =>$Company_id));
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" ');
		$query = $this->db->get('igain_transaction');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function count_member_transfer_point_tran($Enrollement_id,$cust_membershipId,$Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where(array('Enrollement_id' =>$Enrollement_id,'Card_id' => $cust_membershipId, 'Trans_type' => 8, 'Company_id' =>$Company_id));
		$query = $this->db->get('igain_transaction');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function count_member_accrual_transaction($Enrollement_id,$cust_membershipId,$Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where(array('Enrollement_id' =>$Enrollement_id,'Card_id' => $cust_membershipId, 'Company_id' =>$Company_id));
		$this->db->where_in('Trans_type', array('1','2','3','4','7','12','13'));	
		$query = $this->db->get('igain_transaction');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function count_member_point_expir_transaction($Enrollement_id,$cust_membershipId,$Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where(array('Enrollement_id' =>$Enrollement_id,'Card_id' => $cust_membershipId, 'Company_id' =>$Company_id, 'Trans_type' => 14));	
		$query = $this->db->get('igain_transaction');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function Member_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$login_userId,$login_enrollId,$from_date,$to_date,$transaction_type,$SuperSellerFlag,$seller_id)
	{
		/* if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		} */
		$post_data=$this->db->select('*');
		
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id));
		if($seller_id !='0')
		{
			$this->db->where('Seller' , $seller_id);	
		}
		if($transaction_type !='0')
		{
			$this->db->where('Trans_type' , $transaction_type);	
		}
		else
		{
			$this->db->where_in('Trans_type', array('1','2','3','4','7','8','10','12','13','14','17','18','22'));
		}
		// $this->db->where('Bill_no !=','0');
		
		$this->db->where('Trans_date BETWEEN "'.$from_date.' 00:00:00" AND  "'.$to_date.' 23:59:59" ');
		
		if($login_userId == 2 && $SuperSellerFlag!=1) 
		{
			$this->db->where(array('Seller' => $login_enrollId));
			// $this->db->or_where(array('Seller' =>0));
		}
		$this->db->order_by('Trans_id','desc'); 
		$company_sql= $this->db->get();
		 //echo"---Member_transaction---".$this->db->last_query()."---<br>";
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
	public function Search_Member_redeemtion_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$from_date,$to_date)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id, 'Trans_type' => 10));
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" '); 
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
	function Get_item_name($Item_code,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');
		$this->db->where(array('Company_merchandize_item_code' => $Item_code, 'Company_id' => $Company_id));		
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
	public function Member_transfer_point_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$login_userId,$login_enrollId,$from_date,$to_date)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id, 'Trans_type' => 8));
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" ');
		/* if($login_userId == 2)
		{
			$this->db->where(array('Seller' => $login_enrollId));
		} */
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
	public function Search_Member_transfer_point_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$from_date,$to_date)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id, 'Trans_type' => 8));
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" ');
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
	public function Member_accrual_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$login_userId,$login_enrollId,$from_date,$to_date)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id));
		$this->db->where_in('Trans_type', array('1','2','3','4','7','12','13'));
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" ');
		if($login_userId == 2)
		{
			$this->db->where(array('Seller' => $login_enrollId));
		}
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
	public function Search_Member_accrual_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$from_date,$to_date)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id));
		$this->db->where_in('Trans_type', array('1','2','3','4','7','12','13'));	
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" ');
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
	public function point_expir_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$login_userId,$login_enrollId)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id, 'Trans_type' => 14));
		/* if($login_userId == 2)
		{
			$this->db->where(array('Seller' => $login_enrollId));
		} */
		$company_sql= $this->db->get();
		// echo $this->db->last_query();
		if($company_sql->num_rows()> 0)
		{
			foreach ($company_sql->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
			return false;
	}
	public function Search_point_expir_transaction($limit,$start,$Company_id,$cust_membershipId,$Enrollement_id,$from_date,$to_date)
	{
		if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		}
		$post_data=$this->db->select('*');
		$this->db->order_by('Trans_id','desc'); 
		$this->db->from('igain_transaction'); 
		$this->db->where(array('Card_id' => $cust_membershipId, 'Company_id' => $Company_id, 'Enrollement_id' => $Enrollement_id, 'Trans_type' => 14));
		$this->db->where('Trans_date BETWEEN "'.$from_date.'" AND  "'.$to_date.'" ');
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
	function get_transaction_type($type_id)
	{
		$this->db->select('*');
		$this->db->from('igain_transaction_type');
		$this->db->where('Trans_type_id', $type_id);
		
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
	public function Query_interaction_details1($TicketNo,$Company_id)
	{
		
		$post_data=$this->db->select('*');
		$this->db->from('igain_callcenter_querylog_child'); 
		$this->db->where(array('Querylog_ticket' => $TicketNo, 'Company_id' => $Company_id, 'Company_id' => $Company_id));
		$company_sql= $this->db->get();
		 // echo $this->db->last_query();
		 // die;
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
	public function Assign_query($Company_id,$cc_user,$Log_ticket,$querypriority,$Closure_date)
	{
		$sts = 'Forward';
		
		$post_data=$this->db->select('*');
		$this->db->order_by('Child_query_log_id','ASC'); 
		$this->db->from('igain_callcenter_querylog_child'); 
		$this->db->join('igain_callcenter_querylog_master','igain_callcenter_querylog_master.Query_log_id = igain_callcenter_querylog_child.Query_log_id');	
		$this->db->join('igain_callcenter_resolutionpriority_level_master as crplm','crplm.Company_id=igain_callcenter_querylog_master.Company_id AND igain_callcenter_querylog_master.Resolution_priority_levels=crplm.Resolution_priority_levels');
		$this->db->where(array('igain_callcenter_querylog_child.Company_id' => $Company_id, 'igain_callcenter_querylog_child.Enrollment_id' => $cc_user, 'igain_callcenter_querylog_child.Query_assign' => $cc_user, 'igain_callcenter_querylog_child.Query_status' => $sts, ' igain_callcenter_querylog_master.Query_status' => $sts));
		if($Log_ticket != NULL)
		{
			$this->db->where(array('igain_callcenter_querylog_child.Querylog_ticket' => $Log_ticket));
		}
		if($querypriority != NULL)
		{
			$this->db->where(array('igain_callcenter_querylog_master.Resolution_priority_levels' => $querypriority));
		}
		if($Closure_date != NULL)
		{
			$this->db->where(array('igain_callcenter_querylog_master.Closure_date' => $Closure_date));
		}
		$this->db->order_by("igain_callcenter_querylog_child.Query_log_id", "DESC");
		//$this->db->limit(1);
		$company_sql= $this->db->get(); 
		// echo $this->db->last_query();
		// die;
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
	public function Fetch_login_user_queryType($Company_id,$Enrollement_id)
	{
		$this->db->select('Query_type_id');
        $this->db->from('igain_callcenter_querytype_child');
		$this->db->where(array('Company_id' => $Company_id, 'Enrollment_id' => $Enrollement_id));
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
	public function Forward_querys($Company_id,$Query_type_id,$cc_user,$Log_ticket,$querypriority,$Closure_date)
	{
		
		// if($Query_type_id != NULL)
		// {
		// foreach($Query_type_id as $Query_type_id)
		// {	
			$sts = 'Forward';		
			$post_data=$this->db->select('*');
			$this->db->order_by('Child_query_log_id','DESC'); 
			$this->db->from('igain_callcenter_querylog_child'); 	
			$this->db->join('igain_callcenter_querylog_master', ' igain_callcenter_querylog_master.Querylog_ticket = igain_callcenter_querylog_child.Querylog_ticket');	
			$this->db->join('igain_callcenter_resolutionpriority_level_master as crplm','crplm.Company_id=igain_callcenter_querylog_master.Company_id AND igain_callcenter_querylog_master.Resolution_priority_levels=crplm.Resolution_priority_levels');
			$this->db->where(array('igain_callcenter_querylog_child.Company_id' => $Company_id, 'igain_callcenter_querylog_child.Enrollment_id' => $cc_user, 'igain_callcenter_querylog_child.Query_assign' => $cc_user, 'igain_callcenter_querylog_child.Query_status' => $sts, ' igain_callcenter_querylog_master.Query_status' => $sts));
			if($Log_ticket != NULL)
			{
			$this->db->where(array('igain_callcenter_querylog_child.Querylog_ticket' => $Log_ticket));
			}
			if($querypriority != NULL)
			{
				$this->db->where(array('igain_callcenter_querylog_master.Resolution_priority_levels' => $querypriority));
			}
			if($Closure_date != NULL)
			{
				$this->db->where(array('igain_callcenter_querylog_master.Closure_date' => $Closure_date));
			}			
			$company_sql1= $this->db->get(); 
			if($company_sql1->num_rows() > 0)
			{
				foreach ($company_sql1->result() as $row)
				{
					$data[] = $row;
				}	
			}
		// }
			return $data;
		// }
	}
	public function Closed_querys($Company_id,$Query_type_id,$Log_ticket,$querypriority,$Closure_date,$SuperSellerFlag,$login_userId)
	{
		/* if($limit!=NULL || $start !=NULL)
		{
			$this->db->limit($limit,$start);
		} */
		if($Query_type_id != NULL)
		{
		// foreach($Query_type_id as $Query_type_id)
		// { 
			$sts = 'Closed';	
			$post_data=$this->db->select('*');
			$this->db->order_by('qlmstr.Update_date','DESC');
			$this->db->from('igain_callcenter_querylog_master as qlmstr');	
			$this->db->join('igain_callcenter_querytype_child as qrtyc','qrtyc.Company_id=qlmstr.Company_id AND qrtyc.Query_type_id =qlmstr.Query_type_id');
			$this->db->join('igain_callcenter_resolutionpriority_level_master as crplm','crplm.Company_id=qlmstr.Company_id AND qlmstr.Resolution_priority_levels=crplm.Resolution_priority_levels');
			
			$this->db->where(array('qlmstr.Company_id' => $Company_id, 'qlmstr.Query_status' => $sts));
			//$this->db->where(array('Company_id' => $Company_id, 'Query_status' => $sts, 'Query_type_id' => $Query_type_id));
			
			
			$this->db->where(array('qrtyc.Enrollment_id' => $login_userId));
			
			if($Log_ticket != NULL)
			{
				$this->db->where(array('Querylog_ticket' => $Log_ticket));
			}
			if($querypriority != NULL)
			{
				$this->db->where(array('qlmstr.Resolution_priority_levels' => $querypriority));
			}
			if($Closure_date != NULL)
			{
				$this->db->where(array('Closure_date' => $Closure_date));
			}	
					
			$company_sql1= $this->db->get(); 
			if($company_sql1->num_rows() > 0)
			{
				foreach ($company_sql1->result() as $row)
				{
					$data[] = $row;
				}	
			}
		// }
			return $data;
		}
		if($SuperSellerFlag == 1)
		{
			$sts = 'Closed';
			
			$post_data=$this->db->select('*');
			$this->db->from('igain_callcenter_querylog_master as qlmstr');
			$this->db->join('igain_callcenter_resolutionpriority_level_master as crplm','crplm.Company_id=qlmstr.Company_id AND qlmstr.Resolution_priority_levels=crplm.Resolution_priority_levels');
			$this->db->where(array('qlmstr.Company_id' => $Company_id, 'Query_status' => $sts, 'qlmstr.Update_User_id' => $login_userId));
			
			if($Log_ticket != NULL)
			{
				$this->db->where(array('Querylog_ticket' => $Log_ticket));
			}
			if($querypriority != NULL)
			{
				$this->db->where(array('qlmstr.Resolution_priority_levels' => $querypriority));
			}
			if($Closure_date != NULL)
			{
				$this->db->where(array('Closure_date' => $Closure_date));
			}	
					
			$company_sql1= $this->db->get(); 
			if($company_sql1->num_rows() > 0)
			{
				foreach ($company_sql1->result() as $row)
				{
					$data[] = $row;
				}	
			}
			return $data;
		}
	}
	function Get_query_user_name($User_id,$QueryUser_id,$Company_id)
	{
		foreach($QueryUser_id as $QueryUser_id)
		{
			$this->db->select('Enrollement_id,First_name,Middle_name,Last_name');
			$this->db->from('igain_enrollment_master');
			$this->db->where(array('User_id'=>$User_id,'Company_id'=>$Company_id,'User_activated'=>1,'Call_Center_User'=>1, 'Enrollement_id' => $QueryUser_id));
			$sql=$this->db->get();	
			if($sql->num_rows()>0)
			{
				foreach ($sql->result() as $row)
				{
					$data[] = $row;
				}	
			}
		}
			return $data;
	}
	
	function get_cust_details($card_id,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Card_id' => $card_id, 'Company_id' => $Company_id));
		
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
	public function edit_Edit_Cc_querylog($Child_query_log_id)
	{	   
		$edit_query_log = "SELECT * FROM igain_callcenter_querylog_child WHERE Child_query_log_id=$Child_query_log_id LIMIT 1";
		
		$edit_query_log1 = $this->db->query($edit_query_log);
				// echo $this->db->last_query();
		if($edit_query_log1 -> num_rows() == 1)
		{
			return $edit_query_log1->row();
		}
		else
		{
			return false;
		}		
	}
	function Get_ticket_info($Ticket,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_querylog_master');
		$this->db->where(array('Querylog_ticket' => $Ticket, 'Company_id' => $Company_id));
		
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
	public function Fetch_query_user_id($Company_id,$queryTypeId)
	{
		$this->db->select('Enrollment_id');
        $this->db->from('igain_callcenter_querytype_child');
		$this->db->where(array('Company_id' => $Company_id, 'Query_type_id' => $queryTypeId));
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
	function Update_callcenter_querylog($Post_data,$Company_id,$Ticket_number,$Cust_membershipId)
    {		
		$this->db->where(array('Querylog_ticket' => $Ticket_number, 'Membership_id' => $Cust_membershipId, 'Company_id' => $Company_id));
		$this->db->update('igain_callcenter_querylog_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function Count_query($Company_id,$enroll)
	{
		$sts="Forward";
		$this->db->select("COUNT(*)");
		$this->db->where(array('Company_id' =>$Company_id, 'Query_status' => $sts,'Query_assign' => $enroll));
		$query = $this->db->get('igain_callcenter_querylog_child');
		$result = $query->row_array();
		return	$count = $result['COUNT(*)'];		 		
	}
	/*---------------------------Call Center Work End------------------------------*/
	/*----------------------Call Center Query Escalation Auto Process------------------------*/
	public function get_callcenetr_query_log_details_auto($mv_company_id)
	{	
		$sts = "Forward";
		$this->db->select("  qmstr.Resolution_priority_levels,Query_details,Level_name,No_of_days_expected_resolve,Next_action_date,qmstr.Creation_date, crplm.Enrollment_id,Membership_id,Querylog_ticket,Resolution_id"); 
		
		$this->db->from('igain_callcenter_querylog_master as qmstr');
		$this->db->join('igain_callcenter_resolutionpriority_level_master as crplm','crplm.Company_id=qmstr.Company_id AND qmstr.Resolution_priority_levels=crplm.Resolution_priority_levels');		
		$this->db->where('qmstr.Company_id', $mv_company_id);
		$this->db->where('qmstr.Query_status', $sts);
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		// die;
		return $sql51->result_array();
		
	}
	function Get_user_details($Querylog_ticket,$Company_id)
	{
		$this->db->select('User_group_id,Enrollment_id');
		$this->db->from('igain_callcenter_querylog_child');
		$this->db->where(array('Querylog_ticket' =>$Querylog_ticket, 'Company_id' => $Company_id));
		$this->db->order_by('Child_query_log_id','desc'); 
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
	function Insert_query_escalation_log($Post_data)
	{	
		$this->db->insert('igain_query_escalation_log',$Post_data);    
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}	
		return false;
	}
	public function get_callcenter_esc_matrix_details_auto($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_callcenter_escalation_matrix');
		$this->db->where(array('Company_id' => $Company_id));
		
		$sql5 = $this->db->get();
		return $sql5->result_array();
	}
	/*------------------Call Center Query Escalation Auto Process Work End----------------------*/
	/*------------------------------------Nilesh Work End---------------------------------------*/
	public function Get_Resolution_priority_levels_name($Company_id,$Query_priority)
	{			
		$this->db->select('*');
		$this->db->from('igain_callcenter_resolutionpriority_level_master');
		$this->db->where(array('Company_id' => $Company_id,'Resolution_priority_levels' => $Query_priority));		
		$sql501 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql501 -> num_rows() == 1)
		{
			return $sql501->row();
		}
		else
		{
			return false;
		}
	}
	function get_dial_code($Country_id)
	{
		// $query = "select Dial_code from igain_currency_master where Country_id='".$Country_id."'";
		$query = "select phonecode from igain_country_master where id='".$Country_id."'";

			$sql = $this->db->query($query);
			// echo $this->db->last_query();
			foreach ($sql->result() as $row)
			{
				$dial_code = $row->phonecode;
			}
	return 	$dial_code;	
	}
	/*********************************Transaction Receipt*********************************************/
	function get_bills_info($Bill_no,$Trans_id,$Trans_type,$Seller_id)
	{ 
	  // echo "---Bill_no--".$Bill_no."--<br>";
		 // echo "---Seller_id--".$Seller_id."--<br>";
		 // echo "---Trans_id--".$Trans_id."--<br>";
		// echo "---transtype--".$Trans_type."--<br>";
		// die;
		if($Trans_type == 1)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '1', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}
		if($Trans_type == 2)
		{
			$this->db->select('B.*,A.First_name,A.Middle_name,A.Last_name,A.Phone_no,A.User_email_id,A.Current_address,A.City,C.Trans_type,D.Item_category_name,E.Payment_description');//,E.Payment_description
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->join('igain_transaction_type as C', 'B.Trans_type = C.Trans_type_id');
			$this->db->join('igain_item_category_master as D', 'B.Seller = D.Seller');
			$this->db->join('igain_payment_type_master as E', 'B.Payment_type_id = E.Payment_type_id');
			$this->db->where(array('B.Trans_type' => '2', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
			$this->db->group_by("B.Bill_no"); 
		}	
		if($Trans_type == 3)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '3', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}
		if($Trans_type == 4)
		{
			$this->db->select('B.*,E.Payment_description');//,E.Payment_description
			$this->db->from('igain_giftcard_tbl as A');
			$this->db->join('igain_transaction as B', 'B.GiftCardNo = A.Gift_card_id');
			$this->db->join('igain_payment_type_master as E', 'B.Payment_type_id = E.Payment_type_id');
			$this->db->where(array('B.Trans_type' => '4', 'B.Bill_no' => $Bill_no, 'B.Seller' => $Seller_id));
		}		
		if($Trans_type == 10)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '10', 'B.Trans_id' => $Trans_id, 'B.Seller' => $Seller_id));
		}
		if($Trans_type == 12)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '12', 'B.Trans_id' => $Trans_id, 'B.Seller' => $Seller_id));
		}
		if($Trans_type == 8)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '8', 'B.Trans_id' => $Trans_id));
		}
		if($Trans_type == 17)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '17', 'B.Trans_id' => $Trans_id));
		}
		if($Trans_type == 7)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '7', 'B.Trans_id' => $Trans_id));
		}
		if($Trans_type == 13)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '13', 'B.Trans_id' => $Trans_id));
		}
		if($Trans_type == 18)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '18', 'B.Trans_id' => $Trans_id));
		}
		if($Trans_type == 14)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '14', 'B.Trans_id' => $Trans_id));
		}
		if($Trans_type == 22)
		{
			$this->db->from('igain_enrollment_master as A');
			$this->db->join('igain_transaction as B', 'A.Enrollement_id = B.Enrollement_id');
			$this->db->where(array('B.Trans_type' => '22', 'B.Trans_id' => $Trans_id));
		}
		$query = $this->db->get();
		// echo $this->db->last_query(); die;
		if($query->num_rows() > 0)
		{			
			return $query->result_array();
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
	function get_redeem_bill_info($Bill_no,$Trans_id,$Company_id,$transtype)
	{
		$this->db->select('A.Merchandize_item_name,A.Billing_price_in_points,B.Quantity,Voucher_status,Billing_price,balance_to_pay,Loyalty_pts,Redeem_points,Item_size,Shipping_points,B.Delivery_method');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => $transtype, 'B.Trans_id' => $Trans_id, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	function get_purchase_bill_info($Bill_no,$Trans_id,$Company_id,$transtype)
	{
		$this->db->select('A.Merchandize_item_name,B.Quantity,Voucher_status,A.Billing_price,balance_to_pay,Loyalty_pts,Redeem_points,Item_size,B.Purchase_amount');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => $transtype, 'B.Trans_id' => $Trans_id, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	function get_purchase_cancel_bill_info($Bill_no,$Trans_id,$Company_id,$transtype)
	{
		$this->db->select('A.Merchandize_item_name,B.Quantity,Voucher_status,A.Billing_price,balance_to_pay,Loyalty_pts,Redeem_points,Item_size,Purchase_amount');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => $transtype, 'B.Trans_id' => $Trans_id, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	function get_purchase_return_bill_info($Bill_no,$Trans_id,$Company_id,$transtype)
	{
		$this->db->select('A.Merchandize_item_name,B.Quantity,Voucher_status,A.Billing_price,balance_to_pay,Loyalty_pts,Redeem_points,Item_size,Purchase_amount');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => $transtype, 'B.Trans_id' => $Trans_id, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	function get_EvoucherExpiry_bill_info($Bill_no,$Trans_id,$Company_id,$transtype)
	{
		$this->db->select('A.Merchandize_item_name,B.Quantity,Voucher_status,A.Billing_price,balance_to_pay,Loyalty_pts,Redeem_points,Item_size,Purchase_amount');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_transaction as B','A.Company_merchandize_item_code = B.Item_code');
		$this->db->where(array('B.Trans_type' => $transtype, 'B.Trans_id' => $Trans_id, 'B.Company_id' => $Company_id,'A.Company_id' => $Company_id));
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{			
			return $query->result_array();
		}
		else
		{
			return 0;
		}
	}
	function Get_Member_PointsStatistics($Call_Enrollid,$Company_id)
	{
		$this->db->select("SUM(Loyalty_pts) as Total_lty_points,SUM(Transfer_points) as Total_transfer_pts");
		$this->db->from('igain_transaction');
		$this->db->where(array('Company_id' =>$Company_id, 'Enrollement_id' => $Call_Enrollid));
		$sal=$this->db->get();
		if($sal->num_rows()>0)
		{
			return $sal->row();
		}
		else
		{
			return false;
		}
	}
	function get_cust_total_gain_points($Company_id,$Enrollement_id,$Card_id,$Coalition_flag) 
	{ 
		if($Coalition_flag == 0)
		{
			$this->db->select('SUM(Loyalty_pts) as Total_gained_points');
		}
		else if($Coalition_flag==1)
		{
			$this->db->select('SUM(Coalition_Loyalty_pts) as Total_gained_points');
		}
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
	function get_cust_total_transfer($Company_id,$Enrollement_id,$Card_id) 
	{   
		$this->db->select('SUM(Transfer_points) as Total_Transfer_points');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->where(array('IT.Enrollement_id'=>$Enrollement_id,'IT.Company_id'=>$Company_id,'IT.Card_id'=>$Card_id));
		$this->db->where("IT.Trans_type IN('8')");
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
	/*********************************Transaction Receipt*********************************************/
	function get_Symbol_of_currency($Country_id)
	{
		$query =  $this->db->select('Symbol_of_currency')
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
	function get_enrollment_details($Enrollement_id)
	{
		$this->db->select("*,(Current_balance-Blocked_points) AS Total_balance,igain_state_master.name as state_name,igain_city_master.name as city_name,igain_country_master.name as country_name");
		$this->db->from('igain_enrollment_master');
		$this->db->where('Enrollement_id', $Enrollement_id);	
		$this->db->join('igain_country_master', 'igain_enrollment_master.Country = igain_country_master.id','left');
		$this->db->join('igain_state_master', 'igain_enrollment_master.State = igain_state_master.id','left');	
		$this->db->join('igain_city_master', 'igain_enrollment_master.City = igain_city_master.id','left');		
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
	function Fetch_seller_gained_points($Company_id,$Enrollment_id)
	{
		$this->db->select("EN.First_name,EN.Last_name,CT.Company_id,CT.Cust_enroll_id,CT.Seller_id,CT.Cust_seller_balance,CT.Seller_total_purchase,CT.Seller_total_redeem,CT.Seller_total_gain_points,CT.Seller_total_topup,CT.Seller_paid_balance,CT.Cust_block_points,CT.Cust_debit_points");
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
}
?>