<?php 
class Survey_model extends CI_Model
{

//**************** Ravi work start ***********************************	
	function fetch_survey_questions($survey_id,$Company,$Enrollment_id)
	{
		$this->db->select('igain_questionaire_master.Multiple_selection,igain_questionaire_master.Question,igain_questionaire_master.Question_id,igain_questionaire_master.Response_type,igain_questionaire_master.Choice_id,igain_survey_structure_master.Survey_name,igain_survey_structure_master.Company_id,igain_survey_structure_master.Survey_id');
		$this->db->from('igain_survey_send');
		$this->db->join('igain_questionaire_master','igain_survey_send.Survey_id = igain_questionaire_master.Survey_id');
		$this->db->join('igain_survey_structure_master','igain_questionaire_master.Survey_id = igain_survey_structure_master.Survey_id');
		$this->db->where(array('igain_survey_send.Enrollment_id' =>$Enrollment_id,'igain_survey_send.Survey_id' => $survey_id,'igain_survey_send.Company_id' => $Company));		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows() > 0)
		{
			return $sql->result_array();		
		}
		else
		{
			return 0;
		}
		
	}	
	function get_MCQ_choice_values($Choice_id)
	{
		$this->db->select('Value_id,Choice_id,Option_values,Option_image');
		$this->db->from('igain_multiple_choice_values');
		$this->db->where(array('Choice_id' =>$Choice_id));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows() > 0)
		{
			return $sql->result_array();		
		}
		else
		{
			return 0;
		}
		
	} 
	public function insert_survey_response($post_data)
	{        
		$this->db->insert('igain_response_master', $post_data);
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
    }	
	function fetch_survey_count($survey_id,$gv_log_compid,$Enrollment_id)
	{
		$this->db->select('*');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' =>$survey_id,'Company_id' =>$gv_log_compid,'Enrollment_id' =>$Enrollment_id));
		$sql = $this->db->get();
		return $sql->num_rows();
		
	}
	function Check_inserted_survey_question($Enrollment_id,$Question_id,$gv_log_compid)
	{
		$this->db->select('*');
		$this->db->from('igain_response_master');
		$this->db->where(array('Question_id' =>$Question_id,'Company_id' =>$gv_log_compid,'Enrollment_id' =>$Enrollment_id));
		$sql = $this->db->get();
		echo $this->db->last_query();
		return $sql->num_rows();
		
	}
	public function get_survey_details($Survey_id,$Company_id)
	{			
		$this->db->select("*");
       $this->db->where(array('Survey_id' =>$Survey_id,'Company_id' => $Company_id));
        $query = $this->db->get('igain_survey_structure_master');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
	}
	public function insert_survey_rewards_transaction($post_data1)
	{        
		$this->db->insert('igain_transaction', $post_data1);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
    }
	public function update_member_balance($data1,$Enrollment_id,$Company_id)
	{        	
		$this->db->where(array('Enrollement_id' =>$Enrollment_id,'Company_id' => $Company_id));
		$this->db->update('igain_enrollment_master', $data1);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
    }
	public function get_send_survey_details($enroll,$Company_id,$Todays_date)
	{			
		$this->db->select('*');
		$this->db->from('igain_survey_send');
		$this->db->join('igain_survey_structure_master','igain_survey_send.Survey_id = igain_survey_structure_master.Survey_id');
		$this->db->where(array('igain_survey_send.Enrollment_id' =>$enroll,'igain_survey_send.Company_id' => $Company_id,'igain_survey_structure_master.Send_flag'=>1));
		$this->db->where(" '".$Todays_date."' BETWEEN igain_survey_structure_master.Start_date AND igain_survey_structure_master.End_date ");
		$query = $this->db->get();
		return $query->result_array();
		
		
	}
	function get_survey_nps_type($Response2)
	{
		$this->db->select("*");
		$this->db->from('igain_multiple_choice_values');
		$this->db->where(array('Value_id' => $Response2));		
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
	function get_nps_promoters_keywords($Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_nps_master');
		// $this->db->join('igain_nps_type_master','igain_nps_master.NPS_type_id = igain_nps_type_master.NPS_type_id');
		$this->db->where(array('igain_nps_master.NPS_Company_id' => $Company_id));		
		$this->db->order_by('NPS_type_id','DESC');
		// $this->db->where(array('igain_nps_type_master.NPS_type_id' => 1));		
		$sql = $this->db->get();
		// echo "--->".$this->db->last_query()."---<br>";
		return $sql->result_array();
		/* if($sql ->num_rows() == 1)
		{
			return $sql->row();			
		}
		else
		{
			return false;
		} */
	}
	function get_nps_dectractor_keywords($Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_nps_master');
		$this->db->join('igain_nps_type_master','igain_nps_master.NPS_type_id = igain_nps_type_master.NPS_type_id');
		$this->db->where(array('igain_nps_master.NPS_Company_id' => $Company_id));		
		$this->db->where(array('igain_nps_type_master.NPS_type_id' => 3));		
		$sql = $this->db->get();
		// echo "--->".$this->db->last_query()."---<br>";
		return $sql->result_array();
		/* if($sql ->num_rows() == 1)
		{
			return $sql->row();			
		}
		else
		{
			return false;
		} */
	}
	function get_nps_passive_keywords($Company_id)
	{
		$this->db->select("*");
		$this->db->from('igain_nps_master');
		$this->db->join('igain_nps_type_master','igain_nps_master.NPS_type_id = igain_nps_type_master.NPS_type_id');
		$this->db->where(array('igain_nps_master.NPS_Company_id' => $Company_id));		
		$this->db->where(array('igain_nps_type_master.NPS_type_id' => 2));		
		$sql = $this->db->get();
		// echo "--->".$this->db->last_query()."---<br>";
		return $sql->result_array();
		/* if($sql ->num_rows() == 1)
		{
			return $sql->row();			
		}
		else
		{
			return false;
		} */
	}
	function get_survey_template($Survey_id)
	{
		$this->db->select('*');
		$this->db->from('igain_survey_structure_master');
		$this->db->where('Survey_id', $Survey_id);		
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
	function Check_survey_response($Company_id,$Enrollement_id,$Survey_id)
	{
		$this->db->select('*');
		$this->db->from('igain_response_master');
		// $this->db->join('igain_nps_type_master','igain_nps_master.NPS_type_id = igain_nps_type_master.NPS_type_id');
		$this->db->where(array('Company_id'=> $Company_id,'Enrollment_id'=> $Enrollement_id,'Survey_id'=> $Survey_id));	
		
		$sql50 = $this->db->get();
		// echo  $this->db->last_query();
		return $sql50->num_rows();
		
	}
	function Check_survey_question($Company_id,$Survey_id)
	{
		$this->db->select('*');
		$this->db->from('igain_questionaire_master');
		$this->db->where(array('Company_id'=>$Company_id,'Survey_id'=> $Survey_id));	
		
		$sql50 = $this->db->get();
		// echo  $this->db->last_query();
		return $sql50->num_rows();
		
	}
	function Check_total_survey_response($Company_id,$Enrollement_id,$Survey_id)
	{
		$this->db->select('*');
		$this->db->from('igain_response_master');
		$this->db->where(array('Company_id'=> $Company_id,'Enrollment_id'=> $Enrollement_id,'Survey_id'=> $Survey_id));		
		$sql51 = $this->db->get();
		// echo  $this->db->last_query();
		return $sql51->row();
		
	}		
/********************************************Ravi Work end*******************************/
}

?>