<?php
Class Segment_model extends CI_Model
{
	/*************Nilesh Start 21-08-2018 Segment Handlers*************/
	public function Segment_handlers($company_id)
	{
		$this->db->where(array("Company_id" => $company_id));
		$this->db->delete("igain_gender_wise_member_segment_graph");

		$this->db->where(array("Company_id" => $company_id));
		$this->db->delete("igain_city_wise_member_gender_segment_graph");

		$this->db->where(array("Company_id" => $company_id));
		$this->db->delete("igain_age_wise_member_profile_segment_graph");

		$this->db->select("Enrollement_id");
		$this->db->from('igain_enrollment_master');
		$this->db->where(array('Company_id' =>$company_id, 'User_id' => '1', 'User_activated'=>'1'));
		$Total_members = $this->db->count_all_results();

		$this->db->distinct();
		$this->db->select("A.Enrollement_id");
		$this->db->from('igain_enrollment_master as A');
		$this->db->where(array('A.User_activated'=>'1', 'A.Company_id' =>$company_id, 'A.User_id' => '1', 'A.Sex' => 'Male'));
		$Male_members = $this->db->count_all_results();

		$this->db->distinct();
		$this->db->select("A.Enrollement_id");
		$this->db->from('igain_enrollment_master as A');
		$this->db->where(array('A.User_activated'=>'1', 'A.Company_id' =>$company_id, 'A.User_id' => '1', 'A.Sex' => 'Female'));
		$Female_members = $this->db->count_all_results();

		$this->db->distinct();
		$this->db->select("A.Enrollement_id");
		$this->db->from('igain_enrollment_master as A');
		$this->db->where(array('A.User_activated'=>'1', 'A.Company_id' =>$company_id, 'A.User_id' => '1', 'A.Sex' => ''));
		$Other_members = $this->db->count_all_results();

		if($Total_members > 0)
		{
			$status_data['Company_id'] = $company_id;
			$status_data['Total_members'] = $Total_members;
			$status_data['Total_male_members'] = $Male_members;
			$status_data['Total_female_members'] = $Female_members;
			$status_data['Total_other_members'] = $Other_members;

			$this->db->insert("igain_gender_wise_member_segment_graph",$status_data);
		}

		$sql1=$this->db->query("select count(*) as Total_enrollments,City as City2,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND Sex='Male' AND City=City2) as Male_count,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND Sex='Female' AND City=City2) as Female_count ,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND Sex='' AND City=City2) as Other_count from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 group by User_id,City");

		if($sql1->num_rows() > 0)
		{
			foreach($sql1->result() as $row)
			{
				$status_data1['Company_id'] = $company_id;
				$status_data1['Total_members'] = $row->Total_enrollments;
				$status_data1['Total_male_members'] = $row->Male_count;
				$status_data1['Total_female_members'] = $row->Female_count;
				$status_data1['Total_other_members'] = $row->Other_count;
				$status_data1['City_id'] = $row->City2;

				$this->db->insert("igain_city_wise_member_gender_segment_graph",$status_data1);
			}
		}

		$sql12=$this->db->query("select count(*) as Total_enrollments,City as City2,DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(),Date_of_birth)), '%Y')+0 AS age,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(),Date_of_birth)), '%Y')+0 between '15' and '30' AND City=City2) as Total_young_count,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(),Date_of_birth)), '%Y')+0 between '31' and '45' AND City=City2) as Total_middle_age_count,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(),Date_of_birth)), '%Y')+0 between '46' and '60' AND City=City2) as Total_senior_count,(select COUNT(*) from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(CURDATE(),Date_of_birth)), '%Y')+0 between '60' and '150' AND City=City2) as Total_old_count from igain_enrollment_master where Company_id='".$company_id."' and User_id=1 and User_activated=1 group by User_id,City");
		// echo $this->db->last_query();
		if($sql12->num_rows() > 0)
		{
			foreach($sql12->result() as $row)
			{
				$status_data12['Company_id'] = $company_id;
				$status_data12['Total_members'] = $row->Total_enrollments;
				$status_data12['Total_young_members'] = $row->Total_young_count;
				$status_data12['Total_middle_age_members'] = $row->Total_middle_age_count;
				$status_data12['Total_senior_members'] = $row->Total_senior_count;
				$status_data12['Total_old_members'] = $row->Total_old_count;
				$status_data12['City_id'] = $row->City2;

				$this->db->insert("igain_age_wise_member_profile_segment_graph",$status_data12);
			}
		}
	}
	public function Gender_wise_member_graph($company_id)
	{
		$this->db->from("igain_gender_wise_member_segment_graph");
		$this->db->where(array("Company_id" => $company_id));

		$result13 = $this->db->get();

		if($result13->num_rows() > 0)
		{
			return $result13->result();
		}

		return 0;
	}
	public function City_wise_member_gender_graph($company_id)
	{
		$this->db->from("igain_city_wise_member_gender_segment_graph");
		$this->db->where(array("Company_id" => $company_id));

		$result14 = $this->db->get();

		if($result14->num_rows() > 0)
		{
			return $result14->result();
		}

		return 0;
	}
	public function Age_wise_member_profile_graph($company_id)
	{
		$this->db->from("igain_age_wise_member_profile_segment_graph");
		$this->db->where(array("Company_id" => $company_id));

		$result14 = $this->db->get();

		if($result14->num_rows() > 0)
		{
			return $result14->result();
		}

		return 0;
	}
	public function Get_city_name($City_id)
	{
		$this->db->select('name');
		$this->db->from('igain_city_master');
		$this->db->where('id',$City_id);
        $query = $this->db->get();
		if($query -> num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	/*************Nilesh Start End 27-08-2018 Segment Handlers*************/
	public function Segment_count($Company_id)
	{
		 /* $this->db->where('Company_id',$Company_id);
		$sql= $this->db->count_all("igain_tier_master");
		echo $this->db->last_query();
		return $sql; */

		$this->db->select('*');
		$this->db->from('igain_segment_master');
		$this->db->where('Company_id',$Company_id);
		$this->db->group_by('Segment_code');
		// echo $this->db->last_query();
		return $num_results = $this->db->count_all_results();
	}
	public function get_segment_type()
	{
		$this->db->select('Segment_type_id,	Segment_type_name ');
		$this->db->from('igain_segment_type_master');
		// $this->db->where(array('Company_id'=>$Company_id));
		$query13 = $this->db->get();
		// echo $this->db->last_query();
		return $query13->result_array();
	}
	public function Segment_list($limit,$start,$Company_id)
	{
   /*  if($limit != "" || $start =! "" )
    {
      $this->db->limit($limit,$start);
    } */


		$this->db->select('*');
		$this->db->from('igain_segment_master');
		$this->db->join('igain_segment_type_master', 'igain_segment_master.Segment_type_id = igain_segment_type_master.Segment_type_id');
		$this->db->where('Company_id',$Company_id);
		$this->db->where('igain_segment_master.Active_flag',1);
		$this->db->group_by('Segment_code');
		$this->db->order_by('Segment_id','desc');
        $query = $this->db->get();
    // echo $this->db->last_query();
        if($query->num_rows() > 0)
		{
        	foreach ($query->result() as $row)
			{
               $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	public function edit_segment($Company_id,$SegmentCode)
	{
		$this->db->select('*');
		$this->db->from('igain_segment_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Segment_code' =>$SegmentCode));
		$this->db->join('igain_segment_type_master', 'igain_segment_master.Segment_type_id = igain_segment_type_master.Segment_type_id');
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
	public function edit_segment_code($Company_id,$SegmentCode)
	{
		$this->db->select('*');
		$this->db->from('igain_segment_master');
		$this->db->where(array('Company_id'=>$Company_id, 'igain_segment_master.Active_flag' =>1));
		$this->db->like("Segment_code", $SegmentCode);
		$this->db->join('igain_segment_type_master', 'igain_segment_master.Segment_type_id = igain_segment_type_master.Segment_type_id');
        $query = $this->db->get();
		 // echo $this->db->last_query();die;
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
	public function Get_segment_code($Segment_id)
	{
		$this->db->select('Segment_code,igain_segment_master.Segment_type_id');
		$this->db->from('igain_segment_master');
		$this->db->where(array('Segment_id' =>$Segment_id));
		$this->db->join('igain_segment_type_master', 'igain_segment_master.Segment_type_id = igain_segment_type_master.Segment_type_id');
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
	public function Get_linked_segment_hobbies($Hobbies)
	{
		$this->db->select('Hobbies');
		$this->db->from('igain_hobbies_master');
		$this->db->where(array('Id' =>$Hobbies));
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
	public function Insert_segment($Company_id,$enroll)
	{
		// $total_values=4;
		$SegmentType_1=array();
		$Operatorid1=array();
		$Operator_Criteria=array();
		$today = date("Y-m-d H:i:s");

		$SegmentType=$this->input->post("SegmentType");
		$Operatorid1=$this->input->post("Operatorid1");
		$Segment_Code=$this->input->post("Segment_Code");
		/*$SegmentType_1=$this->input->post("SegmentType_1");
		 $Operator_Criteria=$this->input->post("Operator_Criteria");
		$Operator_Criteria1=$this->input->post("Operator_Criteria1");
		$Operator_Criteria2=$this->input->post("Operator_Criteria2");
		$Operator_Criteria_sex=$this->input->post("Operator_Criteria_sex"); */

		if($SegmentType==2 || $SegmentType==3 || $SegmentType==4 || $SegmentType==5 || $SegmentType==6 || $SegmentType==7 )
		{
			$Operatorid=$this->input->post("Operatorid2");

		}
		else
		{
			$Operatorid=$this->input->post("Operatorid");
		}

		
		//die;
		if($Operatorid == 'Between')
		{
			$Value = '';
			$Value1 = $this->input->post("Criteria_Value_1");
			$Value2 = $this->input->post("Criteria_Value_2");
		}
		else
		{
			if($SegmentType==3)
			{
				$Value = $this->input->post("Country_Criteriavalue");
				$Value1= '';
				$Value2 ='';
			}
			else if($SegmentType==5)
			{
				$Value = $this->input->post("State_Criteriavalue");
				$Value1= '';
				$Value2 ='';
			}
			else if($SegmentType==6)
			{
				$Value = $this->input->post("City_Criteriavalue");
				$Value1= '';
				$Value2 ='';
			}
			else if($SegmentType==17)//Tier
			{
				$Operatorid='=';
				$Value = $this->input->post("member_tier_id");
				$Value1= '';
				$Value2 ='';
			}	
			else if($SegmentType==15)//Date Range
			{
				$Operatorid='Between';
				$Value = '';
				$Value1 = date('Y-m-d',strtotime($_REQUEST['start_date']));
				$Value2 = date('Y-m-d',strtotime($_REQUEST['end_date']));
			}
			else if($SegmentType==16)//Outlet
			{
				$Operatorid='=';
				$Value = $_REQUEST['Outlet_id'];
				$Value1= '';
				$Value2 ='';
			}
			else
			{
				$Value = $this->input->post("Criteriavalue");
				$Value1= '';
				$Value2 ='';
			}
		}

		
		$hobbies = $this->input->post('Seg_hobbies');
		
			
		
		if($hobbies != "")
		{
			foreach($hobbies as $hobbi)
			{
				$segment_data = array(
				'Company_id' => $Company_id,
				'Segment_type_id' => $this->input->post("SegmentType"),
				'Segment_code' => $this->input->post("Segment_Code"),
				'Segment_name' => $this->input->post("Segment_name"),
				'Operator' => '=',
				'Value' =>$hobbi,
				'Active_flag' => 1,
				'Create_User_id' => $enroll,
				'Creation_date' => $today
				);
				$this->db->insert("igain_segment_master",$segment_data);
			}
		}
		else
		{
			$segment_data = array(
			'Company_id' => $Company_id,
			'Segment_type_id' => $this->input->post("SegmentType"),
			'Segment_code' => $this->input->post("Segment_Code"),
			'Segment_name' => $this->input->post("Segment_name"),
			'Operator' => $Operatorid,
			'Value' =>$Value,
			'Value1' => $Value1,
			'Value2' => $Value2,
			'Active_flag' => 1,
			'Create_User_id' => $enroll,
			'Creation_date' => $today
			);
			$this->db->insert("igain_segment_master",$segment_data);
		}
		$Item_category_flag=0;
		for($i=0;$i<=11;$i++)
		{
			
			if(isset($_REQUEST["SegmentType_".$i]) !='')
			{
				$Combi_SegmentType = $_REQUEST["SegmentType_".$i];
				$Combi_Operator_Criteria1 = 0;
				$Combi_Operator_Criteria2 = 0;
				if($Combi_SegmentType== 13)
				{
					$Item_category_flag=1;
				}
				if($Combi_SegmentType==2 || $Combi_SegmentType==3 || $Combi_SegmentType==4 || $Combi_SegmentType==5 || $Combi_SegmentType==6 || $Combi_SegmentType==7  || $Combi_SegmentType==16  || $Combi_SegmentType==17   || $Combi_SegmentType==15 )//Sex,Country,State,City,Zipcode,Tier
				{
					
					if($Combi_SegmentType==2)//Sex
					{
						$Combi_Operator_Criteria = $_REQUEST["Operator_CriteriaSex_".$i];
					}
					else
					{
						$Combi_Operator_Criteria = $_REQUEST["Operator_Criteria_".$i];
					}
					
					$Combi_Operatorid = $_REQUEST["Operatorid3_".$i];
					// echo "<br>Operatorid3 ".count($Operatorid1);
					if($Combi_SegmentType==17)//Tier
					{
						$Combi_Operatorid='=';
						$Combi_Operator_Criteria =$_REQUEST["Operator_CriteriaTier_".$i];
						
					}	
					if($Combi_SegmentType==16)//Outlet
					{
						$Combi_Operatorid='=';
						$Combi_Operator_Criteria =$_REQUEST["Operator_CriteriaOutlet_".$i];
					}
					if($Combi_SegmentType==15)//Date Range
					{
						$Combi_Operatorid='Between';
						$Combi_Operator_Criteria1 = date('Y-m-d',strtotime($_REQUEST["start_date".$i]));
						$Combi_Operator_Criteria2 = date('Y-m-d',strtotime($_REQUEST["end_date".$i]));
					}
				}
				else
				{
					
					$Combi_Operatorid = $_REQUEST["Operatorid1_".$i];
					if($Combi_Operatorid=='Between')
					{
						$Combi_Operator_Criteria = '';
						$Combi_Operator_Criteria1 = $_REQUEST["Operator_Criteria1_".$i];
						$Combi_Operator_Criteria2 = $_REQUEST["Operator_Criteria2_".$i];
					}
					else
					{
						$Combi_Operator_Criteria = $_REQUEST["Operator_Criteria_".$i];
					}
				}
				
				 if($Combi_SegmentType==14)//Hobbies
				{
					
					$Selected_Hobbies = $_REQUEST["Hobbies_".$i];
					
					foreach($Selected_Hobbies as $hobbi)
					{
						$segment_data = array(
						'Company_id' => $Company_id,
						'Segment_type_id' => $Combi_SegmentType,
						'Segment_code' => $this->input->post("Segment_Code"),
						'Segment_name' => $this->input->post("Segment_name"),
						'Operator' => '=',
						'Value' =>$hobbi,
						'Active_flag' => 1,
						'Create_User_id' => $enroll,
						'Creation_date' => $today
						);
						$this->db->insert("igain_segment_master",$segment_data);
					}
				}
				else
				{
					$segment_data_combination2 = array(
							'Company_id' => $Company_id,
							'Segment_type_id' => $Combi_SegmentType,
							'Segment_code' => $Segment_Code,
							'Segment_name' => $this->input->post("Segment_name"),
							'Operator' => $Combi_Operatorid,
							'Value' =>$Combi_Operator_Criteria,
							'Value1' => $Combi_Operator_Criteria1,
							'Value2' => $Combi_Operator_Criteria2,
							'Active_flag' => 1,
							'Create_User_id' => $enroll,
							'Creation_date' => $today
							);
							$this->db->insert("igain_segment_master",$segment_data_combination2);
				}
				
				//echo $this->db->last_query()."--<br>";			
			}
			
		}			
		
		
		if($SegmentType== 13 || $Item_category_flag == 1)
		{
			$linked_itemcode=$this->input->post("linked_itemcode");
			$linked_Category_id=$this->input->post("linked_Category_id");
			$linked_Quantity=$this->input->post("linked_Quantity");
		
			if($linked_itemcode != "")
			{
				
				$exp_itm = explode(',',$linked_itemcode);
				$exp_Quantity = explode(',',$linked_Quantity);
				// $linked_Category_id = explode(',',$linked_Category_id);
				
				for($i=0;$i<count($exp_itm);$i++)
				{
					$Post_data=array('Company_id'=>$Company_id,
					'Item_code'=>$exp_itm[$i],
					'Quantity'=>$exp_Quantity[$i],
					'Segment_Code'=>$this->input->post("Segment_Code"),
					'Category_id'=>$linked_Category_id
					);
			
					$Insert_items = $this->Segment_model->Insert_items_segment_child($Post_data);
				}
			}
		}
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		return false;
	}

	public function check_segment_code($Company_id,$SegmentCode,$SegmentName)
	{
		$this->db->select('Segment_code,Segment_name');
		$this->db->from('igain_segment_master');
		if($SegmentCode != ""){
		$this->db->where(array('Company_id'=>$Company_id,'Segment_code'=>$SegmentCode));
		}
		if($SegmentName != ""){
		$this->db->where(array('Company_id'=>$Company_id,'Segment_name'=>$SegmentName));
		}
		$query11 = $this->db->get();
        return $query11->num_rows();
	}
	

	public function update_segment($Company_id,$enroll)
	{
	  $today = date("Y-m-d");
	  $SegmentType=$this->input->post("SegmentType");
	  $Operatorid1=$this->input->post("Operatorid1");
	  $Operatorid3=$this->input->post("Operatorid3");
	  $Segment_Code=$this->input->post("Segment_Code");
	  $Segment_name=$this->input->post("Segment_name");
	 /* $SegmentType_1=$this->input->post("SegmentType_1");
	  $Operator_Criteria=$this->input->post("Operator_Criteria");
	  $Operator_Criteria1=$this->input->post("Operator_Criteria1");
	  $Operator_Criteria2=$this->input->post("Operator_Criteria2");*/

	 /*  echo "--SegmentType_1--<br>";
	  print_r($SegmentType_1); 
	  echo "<br>--Operator_Criteria--<br>";
	  print_r($Operator_Criteria);
	  die; exit; */
	  $segment_data = array(
	  'Segment_name' => $this->input->post("Segment_name"),
	  'Update_User_id' => $enroll,
	  'Update_date' => date("Y-m-d H:i:s")
	  );


	  $this->db->where(array('Company_id'=> $Company_id,'Segment_code'=> $this->input->post("Segment_Code")));
	  $this->db->update('igain_segment_master', $segment_data);

	 // $total_values = count($Operatorid1);
		$Item_category_flag=0;
		for($i=0;$i<=11;$i++)
		{
			
			if(isset($_REQUEST["SegmentType_".$i]) !='')
			{
				$Combi_SegmentType = $_REQUEST["SegmentType_".$i];
				$Combi_Operator_Criteria1 = 0;
				$Combi_Operator_Criteria2 = 0;
				$Combi_Operator_Criteria = 0;
				$Combi_Operatorid = '=';
				
				if($Combi_SegmentType== 13)
				{
					$Item_category_flag=1;
				}
				if($Combi_SegmentType==2 || $Combi_SegmentType==3 || $Combi_SegmentType==4 || $Combi_SegmentType==5 || $Combi_SegmentType==6 || $Combi_SegmentType==7  || $Combi_SegmentType== 16  || $Combi_SegmentType==17  || $Combi_SegmentType==15 )//Sex,Country,State,City,Zipcode
				{
					
					$Combi_Operatorid = $_REQUEST["Operatorid3_".$i];
					$Combi_Operator_Criteria = $_REQUEST["Operator_Criteria_".$i];
					if($Combi_SegmentType==2)//Sex
					{
						$Combi_Operatorid='=';
						$Combi_Operator_Criteria = $_REQUEST["Operator_CriteriaSex_".$i];
					}
					
					// echo "<br>Operatorid3 ".count($Operatorid1);
					if($Combi_SegmentType==17)//Tier
					{
						$Combi_Operatorid='=';
						$Combi_Operator_Criteria =$_REQUEST["Operator_CriteriaTier_".$i];
						
					}	
					if($Combi_SegmentType==16)//Outlet
					{
						$Combi_Operatorid='=';
						$Combi_Operator_Criteria =$_REQUEST["Operator_CriteriaOutlet_".$i];
					}
					if($Combi_SegmentType==15)//Date Range
					{
						$Combi_Operatorid='Between';
						$Combi_Operator_Criteria1 = date('Y-m-d',strtotime($_REQUEST["start_date".$i]));
						$Combi_Operator_Criteria2 = date('Y-m-d',strtotime($_REQUEST["end_date".$i]));
					}
				}
				else
				{
					
					$Combi_Operatorid = $_REQUEST["Operatorid1_".$i];
					if($Combi_Operatorid=='Between')
					{
						$Combi_Operator_Criteria = '';
						$Combi_Operator_Criteria1 = $_REQUEST["Operator_Criteria1_".$i];
						$Combi_Operator_Criteria2 = $_REQUEST["Operator_Criteria2_".$i];
					}
					else
					{
						$Combi_Operator_Criteria = $_REQUEST["Operator_Criteria_".$i];
					}
				}
				if($Combi_SegmentType==14)//Hobbies
				{
					
					$Selected_Hobbies = $_REQUEST["Hobbies_".$i];
					
					foreach($Selected_Hobbies as $hobbi)
					{
						$segment_data = array(
						'Company_id' => $Company_id,
						'Segment_type_id' => $Combi_SegmentType,
						'Segment_code' => $Segment_Code,
						'Segment_name' => $this->input->post("Segment_name"),
						'Operator' => '=',
						'Value' =>$hobbi,
						'Active_flag' => 1,
						'Create_User_id' => $enroll,
						'Creation_date' => $today
						);
						$this->db->insert("igain_segment_master",$segment_data);
					}
				}
				else
				{
					
						$segment_data_combination2 = array(
							'Company_id' => $Company_id,
							'Segment_type_id' => $Combi_SegmentType,
							'Segment_code' => $Segment_Code,
							'Segment_name' => $this->input->post("Segment_name"),
							'Operator' => $Combi_Operatorid,
							'Value' =>$Combi_Operator_Criteria,
							'Value1' => $Combi_Operator_Criteria1,
							'Value2' => $Combi_Operator_Criteria2,
							'Active_flag' => 1,
							'Create_User_id' => $enroll,
							'Creation_date' => $today
							);
							$this->db->insert("igain_segment_master",$segment_data_combination2);
					
				}	
				//echo $this->db->last_query()."--<br>";			
			}
			
		}			
		
	  
		if($Item_category_flag == 1)
		{
			$linked_itemcode=$this->input->post("linked_itemcode");
			$linked_Category_id=$this->input->post("linked_Category_id");
			$linked_Quantity=$this->input->post("linked_Quantity");
		
			if($linked_itemcode != "")
			{
				
				$exp_itm = explode(',',$linked_itemcode);
				$exp_Quantity = explode(',',$linked_Quantity);
				// $linked_Category_id = explode(',',$linked_Category_id);
				
				for($i=0;$i<count($exp_itm);$i++)
				{
					$Post_data=array('Company_id'=>$Company_id,
					'Item_code'=>$exp_itm[$i],
					'Quantity'=>$exp_Quantity[$i],
					'Segment_Code'=>$this->input->post("Segment_Code"),
					'Category_id'=>$linked_Category_id
					);
			
					$Insert_items = $this->Segment_model->Insert_items_segment_child($Post_data);
				}
			}
		}
	  if($this->db->affected_rows() > 0)
	  {
	   return true;
	  }
	  return false;
	}
	public function delete_segment_code($Company_id,$segmentcode)
	{
		 $segment_data = array(
		  'Active_flag' => 0
		  );
		
		$this->db->where(array('Company_id'=>$Company_id,'Segment_code' =>$segmentcode));
		$this->db->update('igain_segment_master', $segment_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Check_segment_code_link($Company_id,$segmentcode)
	{
		$this->db->select('Segment_id');
		$this->db->from('igain_loyalty_master');
		$this->db->where(array("Company_id"=>$Company_id,"Segment_id"=>$segmentcode));
		$sql=$this->db->get();
		if($sql->num_rows()>0)
		{
			return false;
		}
		else
		{
			$comm_for=7;
			$this->db->select('Schedule_comm_value');
			$this->db->from('igain_seller_communication');
			$this->db->where(array("Company_id"=>$Company_id,"Schedule_comm_for"=>$comm_for,"Schedule_comm_value"=>$segmentcode));
			$sql1=$this->db->get();
			if($sql1->num_rows()>0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
	public function delete_segment_id($Company_id,$Segmentid)
	{
		 $segment_data = array(
		  'Active_flag' => 0
		  );

		$this->db->where(array('Company_id'=>$Company_id,'Segment_id' =>$Segmentid));
		$this->db->update('igain_segment_master', $segment_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function delete_segment_master_item($Company_id,$Segment_code)
	{
		 $segment_data = array(
		  'Active_flag' => 0
		  );

		$this->db->where(array('Company_id'=>$Company_id,'Segment_code' =>$Segment_code,'Segment_type_id' =>13));
		$this->db->update('igain_segment_master', $segment_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function delete_segment_child($Segment_child_id)
	{
		$this->db->where(array('Segment_child_id' =>$Segment_child_id));
		$this->db->delete("igain_segment_item_child");
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function edit_segment_id($Company_id,$Segment_code)
	{
		$this->db->select('*');
		$this->db->from('igain_segment_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Segment_code' =>$Segment_code));
		$this->db->join('igain_segment_type_master', 'igain_segment_master.Segment_type_id = igain_segment_type_master.Segment_type_id');
        $query = $this->db->get();
		// echo"---seg--SQL---".$this->db->last_query()."--<br>";
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
	/********************Nilesh Start Segment Master Change*********************/
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
	function FetchState($Country_id)
	{
		$States_sql = "Select * from igain_state_master where country_id='".$Country_id."'";

		$sql_result = $this->db->query($States_sql);

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
	function FetchCity($State_id)
	{
		$City_sql = $this->db->query("Select * from igain_city_master where state_id='".$State_id."'");
		// $Country_sql = $this->db->query("Select * from igain_country_timezone_tbl");
		$City_result = $City_sql->result_array();

		if($City_sql->num_rows() > 0)
		{
			return $City_result;
		}
		else
		{
			return 0;
		}
	}
	public function get_countryname($keyword)
	{
		$this->db->select("name");
        $this->db->order_by('name', 'ASC');
        $this->db->like("name", $keyword);
        $query = $this->db->get('igain_country_master');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['name']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
    }
	public function get_statename($keyword)
	{
		$this->db->select("name");
        $this->db->order_by('name', 'ASC');
        $this->db->like("name", $keyword);
        $query = $this->db->get('igain_state_master');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['name']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
    }
	public function get_cityname($keyword)
	{
		$this->db->select("name");
        $this->db->order_by('name', 'ASC');
        $this->db->like("name", $keyword);
        $query = $this->db->get('igain_city_master');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['name']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
    }
	/**************AMIT KAMBLE 04-02-2020 Segment Master*************/
	function Get_Merchandize_Category($Company_id)
	{
		$this->db->select('Merchandize_category_id,Parent_category_id,Merchandize_category_name');
		$this->db->from('igain_merchandize_category');
		$this->db->where(array('Active_flag'=>1,'Company_id'=>$Company_id));
		
		
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
		 function Get_Linked_Items_for_segment($Merchandize_category_id,$Company_id)
	{
		$this->db->select('A.Merchandize_category_id,Company_merchandize_item_code,Merchandize_item_name,C.Merchandize_category_name');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_merchandize_category as C','A.Merchandize_category_id=C.Merchandize_category_id');
		
		$this->db->where(array('A.Active_flag'=>1,'A.Merchandize_category_id'=>$Merchandize_category_id,'A.Company_id'=>$Company_id,'A.Merchandize_item_type <>' => 118));
		
		
		$sql=$this->db->get();
		  // echo "<br><br><br>".$this->db->last_query();//die;
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
	function Delete_segment_items($Company_id,$Segment_Code)
	{
		$this->db->where(array('Segment_Code'=>$Segment_Code,'Company_id'=>$Company_id));
		$this->db->delete("igain_segment_item_child");
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	function Insert_items_segment_child($Post_data)
	{
		$this->db->insert('igain_segment_item_child',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	 
	 function Get_linked_items_segment_child($Company_id,$Segment_Code)
	{
		$this->db->select('Segment_child_id,A.Company_id,A.Segment_code,A.Item_code,Merchandize_item_name,Quantity,Company_merchandize_item_code,D.Merchandize_category_id');
		$this->db->from('igain_segment_item_child as A');
		$this->db->join('igain_company_merchandise_catalogue as D','A.Item_code=D.Company_merchandize_item_code AND A.Company_id=D.Company_id');
		
		$this->db->where(array('A.Segment_Code'=>$Segment_Code,'A.Company_id'=>$Company_id,'D.Active_flag'=>1));
		$this->db->group_by('A.Item_code');
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
	 function Get_linked_items_segment_child2($Company_id,$Segment_Code)
	{
		$this->db->select('Segment_child_id,A.Company_id,A.Segment_code,A.Item_code,Merchandize_item_name,Quantity,Company_merchandize_item_code,D.Merchandize_category_id');
		$this->db->from('igain_segment_item_child as A');
		$this->db->join('igain_company_merchandise_catalogue as D','A.Item_code=D.Company_merchandize_item_code AND A.Company_id=D.Company_id');
		
		$this->db->where(array('A.Segment_Code'=>$Segment_Code,'A.Company_id'=>$Company_id));
		$this->db->order_by('A.Segment_child_id','desc');
		
		$sql=$this->db->get();
		  // echo "<br><br>Get_linked_items_discount_child<br>".$this->db->last_query();//die;
		if($sql->num_rows()>0)
		{
			$lv_Category_id = 0;
			foreach ($sql->result() as $row)
			{
				$Category_id = $row->Merchandize_category_id;
				if($lv_Category_id == $Category_id)
				{
					$Segment_operation[]  = " OR ".$row->Merchandize_item_name.' & Qty: '.$row->Quantity.')';
				}
				else
				{
					if($lv_Category_id==0){$Segment_operation[]  = '('.$row->Merchandize_item_name.' & Qty: '.$row->Quantity;}
					else{$Segment_operation[]  = ' AND ('.$row->Merchandize_item_name.' & Qty: '.$row->Quantity;}
				}
				$lv_Category_id = $Category_id;
                $data[] = $row;
            }
						// print_r($Segment_operation);die;
			$imp = implode('',	$Segment_operation);	
				// echo $imp;die;
            return $imp;
		}
		else
		{
			return false;
		}	
		
	}
	
	function Get_checked_items_segment($Company_id,$Segment_Code,$Item_code)
	{
		$this->db->select('*');
		$this->db->from('igain_segment_item_child as A');
		
		$this->db->where(array('A.Item_code'=>$Item_code,'A.Company_id'=>$Company_id,'A.Segment_Code'=>$Segment_Code));
		
		$sql=$this->db->get();
		// echo "<br><br>".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			
            return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
}
?>
