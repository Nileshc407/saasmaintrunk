<?php 
Class Tier_model extends CI_Model
{
	public function Tier_count($Company_id)
	{
		 /* $this->db->where('Company_id',$Company_id);
		$sql= $this->db->count_all("igain_tier_master");
		echo $this->db->last_query();
		return $sql; */ 
		
		$this->db->select('*');
		$this->db->from('igain_tier_master');
		$this->db->where('Company_id',$Company_id);
		// echo $this->db->last_query();
		return $num_results = $this->db->count_all_results();
	}
	
	public function Tier_list($limit,$start,$Company_id)
	{
		//$this->db->limit($limit,$start);
		$this->db->select('*');
		$this->db->order_by('Tier_id','desc');
		$this->db->from('igain_tier_master');
		$this->db->where('Company_id',$Company_id);
		$this->db->where('Active_flag',1);
		
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
	
	public function edit_tier($Company_id,$TierID)
	{
		$this->db->select('*');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Tier_id' =>$TierID));
		
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
	
	public function insert_tier($Company_id)
	{
		$today = date("Y-m-d");
		
		$tier_data = array(
		'Company_id' => $Company_id,
		'Tier_name' => $this->input->post("Tiername"),
		'Tier_level_id' => $this->input->post("Tierlevel"),
		'Tier_criteria' => $this->input->post("Tiercriteria"),
		'Criteria_value' => $this->input->post("Criteriavalue"),
		'Operator_id' => $this->input->post("Operatorid"),
		'Excecution_time' => $this->input->post("ExcecutionTime"),
		'Redeemtion_limit' => $this->input->post("Redeemtion_limit"),
		'Create_date' => $today,
		'Active_flag' => 1
		);
		
		$this->db->insert("igain_tier_master",$tier_data);
		
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	
	}
	
	public function check_tier_name($Company_id,$tierName)
	{
		$this->db->select('Tier_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=>$Company_id,'Tier_name'=>$tierName));
		$query11 = $this->db->get();

        return $query11->num_rows();
	}
	
	public function get_tier_levels($Company_id)
	{
		$this->db->select('Tier_id,Tier_level_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=>$Company_id));
		$query13 = $this->db->get();
		
		if ($query13->num_rows() > 0)
		{
            return $query13->num_rows();
        }
        return 0;
	}
	
	public function update_tier($Company_id)
	{
		$TierID = $this->input->post("Tier_id");
		
		$tier_data = array(
		'Tier_name' => $this->input->post("Tiername"),
		'Tier_criteria' => $this->input->post("Tiercriteria"),
		'Criteria_value' => $this->input->post("Criteriavalue"),
		'Operator_id' => $this->input->post("Operatorid"),
		'Excecution_time' => $this->input->post("ExcecutionTime"),
		'Redeemtion_limit' => $this->input->post("Redeemtion_limit")

		);
		
		$this->db->where(array('Company_id'=>$Company_id, 'Tier_id' =>$TierID));
		$this->db->update("igain_tier_master",$tier_data);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function delete_tier($Company_id,$TierID)
	{
		/*$this->db->select('Enrollement_id');
		$this->db->from("igain_enrollment_master");
		$this->db->where(array('Company_id' => $Company_id,'Tier_id' =>$TierID ));
		$count_query = $this->db->get();
		$num_rows = $count_query->num_rows();
		
		if($num_rows == 0)
		{
			$this->db->where(array('Company_id'=>$Company_id, 'Tier_id' =>$TierID));
			$this->db->delete("igain_tier_master");
			
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		else
		{
			return false;
		}*/
		$this->db->where(array('Company_id'=>$Company_id, 'Tier_id' =>$TierID));
		$this->db->update("igain_tier_master",array('Active_flag'=>0));
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function get_tier_details($Company_id,$TierID)
	{
	  $this->db->select('*');
	  $this->db->from('igain_tier_master');
	  $this->db->where(array('Company_id'=>$Company_id, 'Tier_id'=>$TierID));	  
	  $sql50 = $this->db->get();
	  //echo $this->db->last_query();
	  if($sql50 -> num_rows() > 0)
	  {
	   return $sql50->row();
	  }
	  else
	  {
	   return false;
	  }
	}
	public function Inactivate_members_linked_to_tier($Company_id,$TierID,$enroll)
	{
		$Update_date=date("Y-m-d H:i:s");
		$this->db->where('Company_id', $Company_id);
		$this->db->where('Tier_id', $TierID);
		$this->db->where('User_activated', 1);
		$this->db->update('igain_enrollment_master',array('User_activated'=>0,'Update_user_id'=>$enroll,'Update_date'=>$Update_date,'Label_1_value'=>"Tier ID $TierID deleted hence Member Inactive"));
		// echo "<br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
	public function Inactivate_Loyalty_rule_linked_to_tier($Company_id,$TierID)
	{
		$this->db->where('Company_id', $Company_id);
		$this->db->where('Tier_id', $TierID);
		$this->db->where('Active_flag', 1);
		$this->db->update('igain_loyalty_master',array('Active_flag'=>0));
		// echo "<br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	
}
?>
