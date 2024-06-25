<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey_model extends CI_Model 
{
	
   
	
	
	//************************************* Ravi Start *******************************	
	
	public function survey_multiple_choices_count($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		 $query = $this->db->get('igain_multiple_choice');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];
		
	}	
	public function insert_survey_multiple_choices($Company_id,$create_user)
	{
		$data['Company_id'] = $Company_id;
		$data['Active_flag'] = '1';
		$data['Name_of_option'] = $this->input->post('multiple_choice_name');
		$data['Number_of_option'] = $this->input->post('no_of_options');
		$data['Create_user_id'] = $create_user;
		$data['Create_date'] = date('Y-m-d H:i:s');		
		$this->db->insert('igain_multiple_choice', $data);
		if($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}		
	}
	public function insert_multiple_choice_values($last_id,$val,$npsval,$Filepath,$create_user)
	{
		if($npsval != "")
		{
			$npsval=$npsval;
		}
		else
		{
			$npsval=0;
		}
		$data['Choice_id'] = $last_id;
		$data['Option_values'] = $val;		
		$data['NPS_type_id'] = $npsval;		
		$data['Option_image'] = $Filepath;		
		$data['Create_user_id'] = $create_user;	
		$data['Create_date'] = date('Y-m-d H:i:s');		
		$this->db->insert('igain_multiple_choice_values', $data);
		// echo $this->db->last_query();
		// die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}		
	}	
    public function survey_multiple_choices_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$post_data=$this->db->select('Choice_id,Name_of_option,Number_of_option,Company_id');
		$this->db->order_by('Choice_id','desc'); 
		$this->db->from('igain_multiple_choice'); 
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' =>'1'));
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
	public function check_mul_choice_structure($choice_name,$Company_id)
	{			
		$query =  $this->db->select('Name_of_option')
	   ->from('igain_multiple_choice')
	   ->where(array('Name_of_option' => $choice_name,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();   
		return $query->num_rows();		
		
	}
	public function Get_multiple_choices_details($Choice_id)
	{			
	
		$this->db->select('*');
		$this->db->from('igain_multiple_choice_values');
		// $this->db->join('igain_multiple_choice as mul','e.Enrollement_id = lp.Seller');
		$this->db->join('igain_multiple_choice','igain_multiple_choice_values.Choice_id = igain_multiple_choice.Choice_id');
		$this->db->join('igain_nps_type_master','igain_multiple_choice_values.NPS_type_id = igain_nps_type_master.NPS_type_id','LEFT');
		$this->db->where('igain_multiple_choice.Choice_id', $Choice_id);		
		$sql50 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql50 -> num_rows() > 0)
		{
			return $sql50->result_array();
		}
		else
		{
			return false;
		}
	}	
	function update_survey_multiple_choices($val_id,$val,$nps_val,$option_file,$update_user)
    {	
		
		$data['Option_values'] = $val;
		$data['NPS_type_id'] = $nps_val;
		$data['Option_image'] = $option_file;
		$data['Update_user_id'] = $update_user;
		$data['Update_date'] = date('Y-m-d H:i:s');
		$this->db->where('Value_id', $val_id);
		// $this->db->where(array('Value_id' => $val_id));
		$this->db->update('igain_multiple_choice_values', $data);
		 // echo $this->db->last_query()."<br>";
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	function check_survey_question_set_or_not($Surveyid,$Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_questionaire_master');
		$this->db->where(array('Company_id' => $Company_id,'Survey_id' =>$Surveyid));
		$sql = $this->db->get();
		// echo $this->db->last_query()."<br>";
		return $sql->num_rows();	
		
	}
	
	public function delete_multi_choice_set($choiceId,$companyID)
	{
		// $this->db->where('Choice_id', $Loyalty_id);
		$this->db->where(array('Choice_id' => $choiceId,'Company_id' => $companyID));
		$this->db->delete('igain_multiple_choice');		
		if($this->db->affected_rows() > 0)
		{
			$this->db->where(array('Choice_id' => $choiceId));
			$this->db->delete('igain_multiple_choice_values');
			if($this->db->affected_rows() > 0)
			{
				return true;
			}		
		}
	}	
	public function survey_structure_count($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('Company_id', $Company_id);
		 $query = $this->db->get('igain_survey_structure_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function survey_structure_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$post_data=$this->db->select('*');
		$this->db->order_by('Survey_id','desc'); 
		$this->db->from('igain_survey_structure_master'); 
		$this->db->where(array('Company_id' => $Company_id,'Active_flag' =>'1'));
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
	public function check_survey_structure_available($survey_name,$Company_id)
	{			
		$query =  $this->db->select('Survey_name')
	   ->from('igain_survey_structure_master')
	   ->where(array('Survey_name' => $survey_name,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();		
		
	}	
	function insert_survey_structure($Post_data)
	{
		// var_dump($Post_data);
		$this->db->insert('igain_survey_structure_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	
/**********************************Nilesh Work Start**********************************/

	function insert_survey_nps($Post_data)
	{
		// var_dump($Post_data);
		$this->db->insert('igain_nps_type_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	public function survey_nps_count($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('NPS_company_id', $Company_id);
		 $query = $this->db->get('igain_nps_type_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	public function survey_nps_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$post_data=$this->db->select('*');
		$this->db->order_by('NPS_type_id','desc'); 
		$this->db->from('igain_nps_type_master'); 
		$this->db->where(array('NPS_company_id' => $Company_id,'Active_flag' =>'1'));
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
	public function get_survey_nps_details($Company_id,$survey_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_nps_type_master');
		$this->db->where(array('NPS_company_id' => $Company_id,'NPS_type_id' => $survey_id));		
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
	function update_survey_nps($Post_data,$Survey_id,$Company_id)
    {	
		
		$this->db->where(array('NPS_type_id' => $Survey_id,'NPS_company_id' => $Company_id));
		$this->db->update('igain_nps_type_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	public function delete_survey_nps($Survey_id,$companyID)
	{
		$this->db->where(array('NPS_type_id' => $Survey_id,'NPS_company_id' => $companyID));
		$this->db->delete('igain_nps_type_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function check_survey_nps_available($survey_name,$Company_id)
	{			
		$query =  $this->db->select('NPS_type_name')
	   ->from('igain_nps_type_master')
	   ->where(array('NPS_type_name' => $survey_name,'NPS_company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();		
		
	}	
/************************Nilesh Work End*************************/

	function insert_survey_questions($Post_data)
	{
		// var_dump($Post_data);
		$this->db->insert('igain_questionaire_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	public function get_survey_structure_details($Company_id,$survey_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_survey_structure_master');
		$this->db->where(array('Company_id' => $Company_id,'Survey_id' => $survey_id));		
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
	function update_survey_structure($Post_data,$Survey_id,$Company_id)
    {	
		
		$this->db->where(array('Survey_id' => $Survey_id,'Company_id' => $Company_id));
		$this->db->update('igain_survey_structure_master', $Post_data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	public function delete_survey_structure($Survey_id,$companyID)
	{
		$this->db->where(array('Survey_id' => $Survey_id,'Company_id' => $companyID));
		$this->db->delete('igain_survey_structure_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function Fatech_survey_details($Company_id)
	{	
		$today=date('Y-m-d');
		$this->db->select('*');
		$this->db->from('igain_survey_structure_master');
		$this->db->where(array('Company_id' => $Company_id,'Active_flag'=>1));	
		$this->db->where(' "'.$today.'" BETWEEN Start_date AND  End_date ');		
		$sql51 = $this->db->get();	
		// $this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}	
	public function Fetch_survey_question_details($SurveyID,$Company_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_questionaire_master');
		$this->db->join('igain_survey_structure_master','igain_questionaire_master.Survey_id = igain_survey_structure_master.Survey_id');	
		$this->db->where(array('igain_questionaire_master.Survey_id' => $SurveyID,'igain_questionaire_master.Company_id' => $Company_id,'igain_questionaire_master.Active_flag'=>1));
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
	
	public function Survey_MultipleChoiceSet_details($Company_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_multiple_choice');
		// $this->db->join('igain_multiple_choice_values','igain_multiple_choice.Choice_id = igain_multiple_choice_values.Choice_id');
		$this->db->where(array('Company_id' => $Company_id,'Active_flag'=>1));		
		$sql51 = $this->db->get();	
		// $this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}
	public function Fetch_multiple_choice_set_details($choiceID)
	{			
		$this->db->select('*');
		$this->db->from('igain_multiple_choice_values');
		// $this->db->join('igain_multiple_choice_values','igain_multiple_choice.Choice_id = igain_multiple_choice_values.Choice_id');
		$this->db->where(array('Choice_id' => $choiceID));		
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
	public function Fetch_remaing_question_details($SurveyID,$CompanyID)
	{			
		$this->db->select('*');
		$this->db->from('igain_survey_structure_master');
		// $this->db->join('igain_questionaire_master','igain_survey_structure_master.Survey_id = igain_questionaire_master.Survey_id');
		$this->db->where(array('Survey_id' => $SurveyID,'Company_id' => $CompanyID,'Active_flag'=>1));		
		$sql51 = $this->db->get();	
		// echo $this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}
	public function count_MCQ_QUESTION_details($SurveyID,$CompanyID)
	{			
		$this->db->select('');
		$this->db->from('igain_questionaire_master');
		$this->db->where(array('Survey_id' => $SurveyID,'Company_id' => $CompanyID,'Response_type' => 1,'Active_flag'=>1));
		// echo $this->db->last_query();
		return $this->db->count_all_results();
	}
	public function count_TEXT_QUESTION_details($SurveyID,$CompanyID)
	{			
		$this->db->select('');
		$this->db->from('igain_questionaire_master');
		$this->db->where(array('Survey_id' => $SurveyID,'Company_id' => $CompanyID,'Response_type' => 2,'Active_flag'=>1));return $this->db->count_all_results();
	}
	public function get_multiple_choice_name($Company_id,$Choice_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_multiple_choice');
		$this->db->where(array('Company_id' => $Company_id,'Choice_id' => $Choice_id));	
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
	function get_key_worry_customers($Company_id,$r2Value,$mailtokey)
	{
		$this->load->model('igain_model');
		// $seller_details = $this->igain_model->get_enrollment_details($Seller_id);
		if($r2Value == 3)
		{
			$key_worry_customers = $this->get_key_customers($r2Value,$mailtokey,$Company_id);
		}
		else
		{
			$key_worry_customers = $this->get_worry_customers($r2Value,$mailtokey,$Company_id);
		}
		return	$key_worry_customers;
	}	
	function get_key_customers($r2Value,$mailtokey,$Company_id)
	{
		$i = 0; 
		$custenroll_ids = array(); 
		$cust_array1 = array();
		$lastmonth = date("Y-m-d", strtotime("-3 month")); /*** last 3 month ***/
		$thismonth = date("Y-m-d");		
		$this->db->select('Enrollement_id');
		$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1'));
		$this->db->where('Card_id <>','0');	
		$query = $this->db->get('igain_enrollment_master');
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$cust_array1[] = $row['Enrollement_id'];
			}
		}
		foreach($cust_array1 as $cust1)
		{
			$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
			$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1));
			$this->db->where("Trans_date BETWEEN '".$lastmonth."' AND '".$thismonth."' ");
			$query1 = $this->db->get('igain_transaction');
			
			foreach ($query1->result_array() as $row1)
			{
				$trn_count = $row1['count(Purchase_amount)'];
				$trn_date = $row1['max(Trans_date)'];
				
				if($mailtokey == 1) //***Purchase more than 2 times*****
				{
					if($trn_count >= 2 && $trn_date > $lastmonth)/*** grt than 2 and less than 3 ***/
					{
						//echo "--working --- ";
						$custenroll_ids[$i] = $row1['Enrollement_id'];
					}
				}
				if($mailtokey == 2) //***Purchase more than 3 times*****
				{
					if($trn_count >= 3 && $trn_date > $lastmonth )/*** grt than 3 and less than 5 ***/	//&& $trn_count < 5 
					{
						$custenroll_ids[$i] = $row1['Enrollement_id'];
					}
				}
				if($mailtokey == 3) //***Purchase more than 5 times*****
				{
					if($trn_count >= 5 && $trn_date > $lastmonth )/*** grt than 5 ***/
					{
					$custenroll_ids[$i] = $row1['Enrollement_id'];
					}
				}									
				$i++;
			}
		}			
		return	$custenroll_ids;
	}	
	function get_worry_customers($r2Value,$mailtokey,$Company_id)
	{
		$i = 0;  
		$custenroll_ids = array();  
		$cust_array1 = array();
		if($mailtokey == 1) //***No Purchase in last 1 month*****
		{
			$lastmonth = date("Y-m-d", strtotime("-1 month")); /*** last 1 month ***/
		}
		if($mailtokey == 2) //***No Purchase in last 2 month*****
		{
			$lastmonth = date("Y-m-d", strtotime("-2 month")); /*** last 2 month ***/
		}
		if($mailtokey == 3) //***No Purchase in last 3 month***
		{
			$lastmonth = date("Y-m-d", strtotime("-3 month")); /*** last 3 month ***/
		}		
		$this->db->select('Enrollement_id');
		$this->db->where(array('User_id' => '1', 'Company_id' => $Company_id, 'User_activated' => '1', 'joined_date <' => $lastmonth));
		$this->db->where('Card_id <>','0');	
		$query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{			
			foreach ($query->result_array() as $row)
			{
				$cust_array1[] = $row['Enrollement_id'];
			}
		}
		foreach($cust_array1 as $cust1)
		{
			$this->db->select('max(Trans_date),Enrollement_id,count(Purchase_amount)');
			$this->db->where(array('Trans_type' => '2', 'Enrollement_id' => $cust1,'Company_id' => $Company_id));
			$query1 = $this->db->get('igain_transaction');
			
			foreach ($query1->result_array() as $row1)
			{
				$trn_count = $row1['count(Purchase_amount)'];
				$trn_date = $row1['max(Trans_date)'];
				
				if($trn_date < $lastmonth || $trn_count == 0)
				{
					$custenroll_ids[$i++] = $row1['Enrollement_id'];
				}
			}
		}		
		return	$custenroll_ids;
	}
	
	public function get_phnno_memberid($Cust_name,$Company_id) 
	{        
		$cust_name = explode(" ",$Cust_name);
		$this->db->select("Enrollement_id,Card_id,Phone_no");
		$this->db->like("First_name", $cust_name[0]);
		$this->db->where(array('User_id' => '1','User_activated' => '1','Company_id' => $Company_id));	//,'Card_id' => '0'	
		$this->db->where('Card_id <>','0');		
        $query = $this->db->get('igain_enrollment_master');
		return $query->result_array();
    }	
	public function get_customer_name($keyword,$Company_id) 
	{        
		$this->db->select("First_name,Last_name");
        $this->db->order_by('First_name', 'ASC');
        $this->db->like("First_name", $keyword);
		$this->db->where(array('User_id' => '1','User_activated' => '1','Company_id' => $Company_id));
		$this->db->where('Card_id <>','0');
        $query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$label = htmlentities(stripslashes($row['First_name']))." ".htmlentities(stripslashes($row['Last_name']));
				$row_set[] = $label;
			}
			echo json_encode($row_set); //format the array into json data
		}
    }
	public function get_survey_details($surveyID,$Company_id) 
	{        
		$this->db->select("*");
       $this->db->where(array('Survey_id' =>$surveyID,'Active_flag' => '1','Company_id' => $Company_id));
        $query = $this->db->get('igain_survey_structure_master');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
    }
	public function get_super_seller_details($Company_id) 
	{        
		$this->db->select("*");
       $this->db->where(array('Super_seller' =>1,'User_activated' => 1,'User_id' => 2,'Company_id' => $Company_id));
        $query = $this->db->get('igain_enrollment_master');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
    }
	public function insert_survey_details($post_data)
	{      
		$this->db->select('Enrollment_id,Company_id,Survey_id');
		$this->db->where(array('Enrollment_id'=>$post_data['Enrollment_id'],'Company_id'=>$post_data['Company_id'],'Survey_id'=>$post_data['Survey_id'],));
		$query = $this->db->get('igain_survey_send');
		if($query->num_rows() > 0){
		
			// the query returned data, so the email already exist.
			return false;
		}
		else
		{	
			// the email not exists, so you can insert it.
			$this->db->insert('igain_survey_send', $post_data);
			if($this->db->affected_rows() > 0)
			{
				$data['Send_flag'] = 1;
				$this->db->where(array('Survey_id' =>$post_data['Survey_id'],'Company_id' =>$post_data['Company_id']));
				$this->db->update('igain_survey_structure_master', $data);
				if($this->db->affected_rows() > 0)
				{
					return true;
				}
				return true;
			}			
			
		}
		
			
    }
	public function get_send_survey_details($Survey_id,$Company_id)
	{			
		$query =  $this->db->select('*')
	   ->from('igain_survey_send')
	   ->where(array('Survey_id' => $Survey_id,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();		
		
	}
	public function fetch_send_survey_details($Survey_id,$Company_id)
	{			
		$query =  $this->db->select('Enrollment_id')
	   ->from('igain_survey_send')
	   ->where(array('Survey_id' => $Survey_id,'Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->result_array();		
		
	}
	public function Fetch_survey_details($SurveyID,$Company_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_questionaire_master');
		$this->db->join('igain_survey_structure_master','igain_questionaire_master.Survey_id = igain_survey_structure_master.Survey_id');	
		$this->db->where(array('igain_questionaire_master.Survey_id' => $SurveyID,'igain_questionaire_master.Company_id' => $Company_id,'igain_questionaire_master.Active_flag'=>1));
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}
	public function fetch_survey_customer_analysis($SurveyID,$Company_id,$Enrollement_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_response_master');
		// $this->db->join('igain_questionaire_master','igain_response_master.Survey_id = igain_questionaire_master.Survey_id');	
		// $this->db->join('igain_survey_structure_master','igain_response_master.Survey_id = igain_survey_structure_master.Survey_id');	
		$this->db->where(array('igain_response_master.Survey_id' => $SurveyID,'igain_response_master.Company_id' => $Company_id,'igain_response_master.Enrollment_id' => $Enrollement_id));
		$sql51 = $this->db->get();
		// echo $this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}	
	function get_MCQ_choice_values($Choice_id)
	{
		$this->db->select('Value_id,Choice_id,Option_values,Option_image');
		$this->db->from('igain_multiple_choice_values');
		$this->db->where(array('Choice_id' =>$Choice_id));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		// die;
		if($sql->num_rows() > 0)
		{
			return $sql->result_array();		
		}
		else
		{
			return 0;
		}
		
	}
	 public function survey_analysis($Company_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_survey_structure_master');
		
		$this->db->where(array('Company_id' => $Company_id,'Active_flag'=>1,'Send_flag'=>1));		
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
	public function survey_analysis_details($SurveyID,$Company_id)
	{			
		$this->db->select('
							igain_survey_structure_master.Survey_id,
							igain_survey_structure_master.Company_id,
							igain_survey_structure_master.Survey_name,
							igain_survey_structure_master.Survey_type,
							igain_survey_structure_master.No_of_questions,
							igain_response_master.Response_id,
							igain_response_master.Enrollment_id,
							igain_response_master.Company_id,
							igain_response_master.Survey_id,
							igain_response_master.Question_id,
							igain_response_master.Response1,
							igain_response_master.Response2,
							igain_response_master.Choice_id,
							igain_enrollment_master.Enrollement_id,
							igain_enrollment_master.First_name,
							igain_enrollment_master.Last_name
							');
		$this->db->from('igain_survey_structure_master');
		$this->db->join('igain_response_master','igain_survey_structure_master.Survey_id = igain_response_master.Survey_id');
		$this->db->join('igain_enrollment_master','igain_response_master.Enrollment_id = igain_enrollment_master.Enrollement_id');
		$this->db->where(array('igain_survey_structure_master.Survey_id' => $SurveyID,'igain_survey_structure_master.Company_id' => $Company_id,'igain_survey_structure_master.Active_flag'=>1,'igain_survey_structure_master.Send_flag'=>1));		
		$this->db->group_by('igain_response_master.Enrollment_id');
		$sql51 = $this->db->get();
			// echo $this->db->last_query();		
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->result_array();
		}
		else
		{
			return false;
		}
	}
	public function survey_summary_details($SurveyID,$Company_id)
	{		

		$this->db->select('igain_questionaire_master.Question, igain_questionaire_master.Question_id, igain_questionaire_master.Survey_id, igain_response_master.Choice_id,igain_response_master.Company_id');
		$this->db->from('igain_response_master');
		$this->db->join('igain_questionaire_master','igain_response_master.Question_id = igain_questionaire_master.Question_id');
		$this->db->where(array('igain_response_master.Survey_id' => $SurveyID,'igain_response_master.Company_id' => $Company_id));		
		$this->db->group_by('igain_response_master.Question_id');
		
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
	public function count_survey_responder($SurveyID,$Company_id)
	{		

		$this->db->select('*');
		$this->db->from('igain_response_master');
		// $this->db->join('igain_questionaire_master','igain_response_master.Question_id = igain_questionaire_master.Question_id');
		$this->db->where(array('Survey_id' => $SurveyID,'Company_id' => $Company_id));		
		$this->db->group_by('Enrollment_id');
		// $this->db->distinct();
		$sql51 = $this->db->get();
			// echo $this->db->last_query();		
		if($sql51 -> num_rows() > 0)
		{
			return $sql51->num_rows();
		}
		else
		{
			return false;
		}
	}
	public function get_question($Question_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_questionaire_master');
		$this->db->where(array('Question_id' => $Question_id,'Active_flag'=>1));
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
	function get_MCQ_choice($Response2)
	{
		$this->db->select('Value_id,Choice_id,Option_values');
		$this->db->from('igain_multiple_choice_values');
		$this->db->where(array('Value_id' =>$Response2));
		
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
	function get_MCQ_All_choice_values($Choice_id)
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
	function get_choice_id($Survey_id,$Question_id,$Company_id)
	{
		$this->db->select('Choice_id');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' =>$Survey_id,'Question_id' =>$Question_id,'Company_id' =>$Company_id));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows() > 0)
		{
			return $sql->row();		
		}
		else
		{
			return 0;
		}
		
	}
	function count_response_id($Choice_id,$Question_id)
	{
		$this->db->select('*');
		$this->db->from('igain_response_master');
		$this->db->where(array('Choice_id' =>$Choice_id,'Question_id' =>$Question_id));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows() > 0)
		{
			return $sql->num_rows();
		}
		else
		{
			return 0;
		}
		
	}
	function count_response2($Question_id,$Value_id)
	{
		$this->db->select('*');
		$this->db->from('igain_response_master');
		$this->db->where(array('Question_id' =>$Question_id,'Response2' =>$Value_id));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows() > 0)
		{
			return $sql->num_rows();
		}
		else
		{
			return 0;
		}
		
	}
	function get_survey_response_details_rpt($Survey_id,$Company_id)
	{
		$this->db->select('*,');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' =>$Survey_id,'Company_id' =>$Company_id));
		$this->db->group_by('Question_id');
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
	
	function get_survey_response_enroll_rpt($Survey_id,$Company_id)
	{
		$this->db->select('Enrollment_id,Survey_id,Company_id,Question_id');
		$this->db->from('igain_response_master');
		// $this->db->join('igain_enrollment_master','igain_response_master.Enrollment_id = igain_enrollment_master.Enrollement_id');
		$this->db->where(array('igain_response_master.Survey_id' =>$Survey_id,'igain_response_master.Company_id' =>$Company_id));
		$this->db->group_by('igain_response_master.Enrollment_id');
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
	function responce_question_id($Survey_id,$Enrollment_id)
	{
		$this->db->select('Question_id');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' =>$Survey_id,'Enrollment_id' =>$Enrollment_id));
		$this->db->order_by('Question_id');
		$this->db->distinct();
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
	function get_response($Survey_id,$Enrollment_id,$Question_id)
	{
		$this->db->select('Response1,Response2,Choice_id');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' =>$Survey_id,'Enrollment_id' =>$Enrollment_id,'Question_id' =>$Question_id));
		$this->db->order_by('Question_id');
		$this->db->distinct();
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
	function check_exist_question($Question,$temp_table)
	{
		$this->db->select('Question');
		$this->db->from($temp_table);
		$this->db->where(array('Question' =>$Question));
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows() > 0)
		{
			return $sql->num_rows();		
		}
		else
		{
			return 0;
		}
		
	}
	public function survey_summary_details_xls($SurveyID,$Company_id)
	{		

		$this->load->dbforge();	
		$temp_table = $Company_id.'survey_summary_analysis_tmp';		
			
			if( $this->db->table_exists($temp_table) == TRUE )
			{
				$this->dbforge->drop_table($temp_table);
			}		
			$fields = array(
								'CompanyName' => array('type' => 'VARCHAR','constraint' => '200'),
								'SurveyName' => array('type' => 'VARCHAR','constraint' => '100'),
								'CustomerName' => array('type' => 'VARCHAR','constraint' => '100'),
								'Question' => array('type' => 'VARCHAR','constraint' => '255'),
								'TextBased' => array('type' => 'VARCHAR','constraint' => '255'),
								'MCQ' => array('type' => 'VARCHAR','constraint' => '100'),
								'Choice' => array('type' => 'VARCHAR','constraint' => '100')
							);
						$this->dbforge->add_field($fields);		
						$this->dbforge->create_table($temp_table);
						
			
		$this->db->select('Response_id,Enrollment_id,Company_id,Survey_id,Question_id,Response1,Response2,Choice_id');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' => $SurveyID,'Company_id' => $Company_id));		
		$sql51 = $this->db->get();
		
		foreach($sql51->result_array() as $response)
		{	
			
			$Enrollment_id=$response['Enrollment_id'];
			$Question=$this->Survey_model->get_question($response['Question_id']);
			$Customer_name = $this->Igain_model->get_enrollment_details($Enrollment_id,$response['Company_id']);
			$SurveyName = $this->Survey_model->get_survey_structure_details($response['Company_id'],$response['Survey_id']);
			// $data['CustomerName']=$Customer_name->First_name.' '.$Customer_name->Last_name;			
			$data['SurveyName']=$SurveyName->Survey_name;			
			$data['Question']=$Question->Question;
			$check_exist_question=$this->check_exist_question($Question->Question,$temp_table);
			if($check_exist_question <= 0)
			{
				$get_choice_id=$this->get_choice_id($response['Survey_id'],$response['Question_id'],$response['Company_id']);
				
				if($get_choice_id->Choice_id > 0)
				{
					$total_response_count = $this->Survey_model->count_response_id($get_choice_id->Choice_id,$response['Question_id']);
					
					$multiple_choice_values=$this->Survey_model->get_MCQ_All_choice_values($get_choice_id->Choice_id);
					foreach($multiple_choice_values as $mulVal)
					{
						$count_option_values1 = $this->Survey_model->count_response2($response['Question_id'],$mulVal['Value_id']);
						$count_option_values = ($count_option_values1 / $total_response_count);
						$count_option_values = round($count_option_values,4) * 100;
						if($count_option_values > 0)
						{
							// $data['MCQ']= $mulVal['Option_values']."( ".$count_option_values." % )";
							$data['MCQ'] = $mulVal['Option_values'].' ('.$count_option_values.' %)';
						}
						else
						{
							// $data['MCQ']= $mulVal['Option_values']."( 0 % )";
							$data['MCQ'] = $mulVal['Option_values'].' ( 0 %)';
						}						
						$this->db->insert($temp_table, $data);						
					}					
				}
			}			
		}
		$this->db->select('SurveyName,Question,MCQ AS Response');
		$this->db->from($temp_table);
		// $this->db->where(array('Question' =>$Question));
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
	
	function get_survey_response_details_xls_rpt($Survey_id,$Company_id)
	{
	
		$this->load->dbforge();	
		$temp_table1 = $Company_id.'survey_detail_analysis_tmp';		
			
			if( $this->db->table_exists($temp_table1) == TRUE )
			{
				$this->dbforge->drop_table($temp_table1);
			}		
			$fields = array(
								'CompanyName' => array('type' => 'VARCHAR','constraint' => '200'),
								'SurveyName' => array('type' => 'VARCHAR','constraint' => '100'),
								'CustomerName' => array('type' => 'VARCHAR','constraint' => '100'),
								'Question' => array('type' => 'VARCHAR','constraint' => '255'),
								'TextBased' => array('type' => 'VARCHAR','constraint' => '255'),
								'MCQ' => array('type' => 'VARCHAR','constraint' => '100'),
								'Choice' => array('type' => 'VARCHAR','constraint' => '100')
							);
						$this->dbforge->add_field($fields);		
						$this->dbforge->create_table($temp_table1);
						
			
		$this->db->select('Response_id,Enrollment_id,Company_id,Survey_id,Question_id,Response1,Response2,Choice_id');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' => $Survey_id,'Company_id' => $Company_id));		
		$sql511 = $this->db->get();
		
		// var_dump($sql511->result_array());
		foreach($sql511->result_array() as $response)
		{
			$Enrollment_id=$response['Enrollment_id'];
			$Question=$this->Survey_model->get_question($response['Question_id']);
			$Customer_name = $this->Igain_model->get_enrollment_details($Enrollment_id,$response['Company_id']);
			$SurveyName = $this->Survey_model->get_survey_structure_details($response['Company_id'],$response['Survey_id']);
			$data['CustomerName']=$Customer_name->First_name.' '.$Customer_name->Last_name;			
			$data['SurveyName']=$SurveyName->Survey_name;			
			$data['Question']=$Question->Question;
			
			// echo"Question------".$response['Question_id']."--<br>";
			// echo"Enrollment_id------".$response['Enrollment_id']."--<br>";
			
			$get_response = $this->Survey_model->get_response12($response['Survey_id'],$Enrollment_id,$response['Question_id']);
			// print_r($get_response);
			foreach($get_response as $recRes)
			{
				if($recRes['Response2'] > 0)
				{
					// echo"Response2------".$recRes['Response2']."--<br>";					
					if($recRes['Choice_id'] != "")
					{
						// echo"Choice_id------".$recRes['Choice_id']."--<br>";
						$choice_values = $this->Survey_model->get_MCQ_choice($recRes['Response2']);
						// print_r($choice_values);
						foreach($choice_values as $ch_val12)
						{
							$data['MCQ']=$ch_val12['Option_values'];
							$data['TextBased']='';
							// echo"Option_values------".$ch_val12['Option_values']."--<br>";						
							$this->db->insert($temp_table1, $data);
						}						
					}					
				}
				else
				{
					// echo"Response1------".$recRes['Response1']."--<br>";
					$data['MCQ']='';
					$data['TextBased']=$response['Response1'];
					// echo"TextBased------".$data['TextBased']."--<br>";
					$this->db->insert($temp_table1, $data);
				}				
			}
		}		
		$this->db->select('SurveyName,CustomerName,Question,TextBased AS TextBasedResponse ,MCQ AS MCQResponse');
		$this->db->from($temp_table1);
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
	function get_response12($Survey_id,$Enrollment_id,$Question_id)
	{
		$this->db->select('Response1,Response2,Choice_id');
		$this->db->from('igain_response_master');
		$this->db->where(array('Survey_id' =>$Survey_id,'Enrollment_id' =>$Enrollment_id,'Question_id' =>$Question_id));
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
	function get_survey_nps_type($company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_nps_type_master');
		// $this->db->where(array('NPS_company_id' =>$company_id,'Active_flag' =>1));
		$this->db->where_in("NPS_type_id",array('1','3'));
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
	//******************** Ravi Work end **************************
	
	//******************** Nilesh Work Start**************************
	

	public function nps_master($Company_id)
	{
		$this->db->select("COUNT(*)");
		$this->db->where('NPS_company_id', $Company_id);
		 $query = $this->db->get('igain_nps_master');
		 $result = $query->row_array();
		return	$count = $result['COUNT(*)'];		
	}
	/* public function nps_master_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$post_data=$this->db->select('*');
		$this->db->order_by('NPS_id','desc'); 
		$this->db->from('igain_nps_master'); 
		$this->db->where(array('NPS_company_id' => $Company_id,'Active_flag' =>'1'));
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
	} */
	public function survey_nps()
	{
		$post_data=$this->db->select('*');
		$this->db->order_by('NPS_type_id','desc'); 
		$this->db->from('igain_nps_type_master'); 
		// $this->db->where(array('NPS_company_id' => $Company_id,'Active_flag' =>'1'));
		$this->db->where_in("NPS_type_id",array('1','3'));
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
public function nps_master_list($limit,$start,$Company_id)
	{
		$this->db->limit($limit,$start);
		$post_data=$this->db->select('*');
		$this->db->order_by('NPS_id','desc'); 
		$this->db->from('igain_nps_master'); 
		$this->db->where(array('NPS_company_id' => $Company_id,'Active_flag' =>'1'));
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
function insert_nps_master($Post_data)
	{
		// var_dump($Post_data);
		$this->db->insert('igain_nps_master',$Post_data);
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}	
	public function get_nps_master_details($Company_id,$NPS_id)
	{			
		$this->db->select('*');
		$this->db->from('igain_nps_master');
		$this->db->where(array('NPS_Company_id' => $Company_id,'NPS_id' => $NPS_id));		
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
	function update_nps_master($Post_data,$NPS_id,$Company_id)
    {	
		
		$this->db->where(array('NPS_id' => $NPS_id,'NPS_Company_id' => $Company_id));
		$this->db->update('igain_nps_master', $Post_data);
		 // echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}			
		return false;
	}
	public function delete_nps_master($NPS_id,$companyID)
	{
		$this->db->where(array('NPS_id' => $NPS_id,'NPS_Company_id' => $companyID));
		$this->db->delete('igain_nps_master');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function check_nps_master_available($NPS_dictionay_name,$Company_id)
	{			
		$query =  $this->db->select('NPS_dictionay_name')
	   ->from('igain_nps_master')
	   ->where(array('NPS_dictionay_name' => $NPS_dictionay_name,'NPS_Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();		
		
	}
	public function check_nps_type_available($Npstype,$Company_id)
	{			
		$query =  $this->db->select('*')
	   ->from('igain_nps_master')
	   ->where(array('NPS_type_id' => $Npstype,'NPS_Company_id' => $Company_id))->get();
		// echo $this->db->last_query();	   
		return $query->num_rows();		
		
	}	
	
	
	
	//******************** Nilesh Work end**************************
}
?>
