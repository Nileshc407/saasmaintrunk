<?php 
class Survey_model extends CI_Model
{

//**************** Ravi work start ***********************************	
	function fetch_survey_questions($survey_id,$Company,$Enrollment_id)
	{igain_questionaire_master
		$this->db->select('igain_questionaire_master.Question,igain_questionaire_master.Question_id,igain_questionaire_master.Response_type,igain_questionaire_master.Choice_id,igain_survey_structure_master.Survey_name,igain_survey_structure_master.Company_id,igain_survey_structure_master.Survey_id');
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
		$this->db->select('Value_id,Choice_id,Option_values');
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
		// var_dump($data1);
		// echo"<br>-------Enrollment_id-----".$Enrollment_id;
		// echo"<br>-------Company_id-----".$Company_id;
		$this->db->where(array('Enrollement_id' =>$Enrollment_id,'Company_id' => $Company_id));
		$this->db->update('igain_enrollment_master', $data1);
		
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}	
    }
	public function get_send_survey_details($enroll,$Company_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_survey_send');
		$this->db->join('igain_survey_structure_master','igain_survey_send.Survey_id = igain_survey_structure_master.Survey_id');
		$this->db->where(array('igain_survey_send.Enrollment_id' =>$enroll,'igain_survey_send.Company_id' => $Company_id,'igain_survey_structure_master.Send_flag'=>1));
		
		$sql = $this->db->get();
		if($sql->num_rows() > 0)
		{
			return $sql->result_array();		
		}
		else
		{
			return 0;
		}	
		
	}
/********************************************Ravi Work end*******************************/
}

?>
