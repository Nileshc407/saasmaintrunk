<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_templateModel extends CI_Model 
{
	public function get_Company_emailtemplate_master($Company_id)
		{	
			
			$this->db->select("Company_email_template_id,ce.Email_template_id,Template_type_name,Email_template_name,ce.Template_type_id,ce.Template_description,ce.Status,ce.Company_id");
			  $this->db->from('igain_company_email_template_master as ce');
			  $this->db->join('igain_email_template_master et','ce.Email_template_id=et.Email_template_id');
			  $this->db->join('igain_template_type_master tm','ce.Template_type_id=tm.Template_type_id');
			   $this->db->where(array('ce.Company_id' => $Company_id));
			   $this->db->order_by('Company_email_template_id','desc');
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
	public function get_Specific_Company_emailtemplate_master($Company_email_template_id)
		{	
			
			$this->db->select("Company_email_template_id,ce.Email_template_id,Template_type_name,Email_template_name,ce.Template_type_id,ce.Template_description,ce.Status,ce.Company_id,ce.Email_subject,ce.Email_header,ce.Email_header_image,ce.Body_image,ce.Body_structure,ce.Email_body,ce.Footer_notes,ce.Google_play_link,ce.Ios_application_link,ce.Facebook_share_flag,ce.Twitter_share_flag,ce.Google_share_flag,ce.Unsubscribe_flg,ce.Email_font_color,ce.Email_background_color,ce.Email_font_size,ce.Font_family,ce.Email_Type,ce.Footer_background_color,ce.Header_background_color,ce.Email_Contents_background_color,ce.Footer_font_color");
			  $this->db->from('igain_company_email_template_master as ce');
			  $this->db->join('igain_email_template_master et','ce.Email_template_id=et.Email_template_id');
			  $this->db->join('igain_template_type_master tm','ce.Template_type_id=tm.Template_type_id');
			  $this->db->where(array('Company_email_template_id' => $Company_email_template_id));
			  $sql = $this->db->get();
			  if ($sql->num_rows() > 0)
			{
				return $sql->row();
			}
			  return false;
		}
   
	public function get_template_type()
		{	
			
			$this->db->select("*");
			  $this->db->from('igain_template_type_master');
			  $sql = $this->db->get();
			  if ($sql->num_rows() > 0)
			  {
				 return  $sql->result_array();
			  }
			  return false;
		}
   
	public function get_code_decode_master($Code_decode_type_id)
		{	
			
			$this->db->select("*");
			  $this->db->from('igain_codedecode_master');
			  $this->db->where(array('Code_decode_type_id' => $Code_decode_type_id,'Company_id' => 1));
			  $sql = $this->db->get();
			  if ($sql->num_rows() > 0)
			  {
				 return  $sql->result_array();
			  }
			  return false;
		}
   
	public function get_templates_by_temptypes($Template_type_id)
		{	
			
			$this->db->select("Email_template_id,Template_type_id,Email_template_name");
			  $this->db->from('igain_email_template_master');
			  $this->db->where(array('Template_type_id' => $Template_type_id));
			  $sql = $this->db->get();
			  // echo "<br><br>".$this->db->last_query();
			  if ($sql->num_rows() > 0)
			  {
				 return  $sql->result_array();
			  }
			  return false;
		}
	public function get_linked_templates($Email_template_id)
		{	
			
			$this->db->select("*");
			  $this->db->from('igain_email_template_master');
			  $this->db->where(array('Email_template_id' => $Email_template_id));
			  $sql = $this->db->get();
			
			  if ($sql->num_rows() > 0)
			{
				return $sql->row();
			}
			  return false;
		}
	
	function Insert_company_emailtemp_master($Post_data)
	{
		$this->db->insert('igain_company_email_template_master',$Post_data);
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
   public function Email_template_acivate_deactivate($Company_email_template_id,$Status,$enroll,$Template_type_id,$Company_id)
	{
		$Update_date = date('Y-m-d H:i:s');
		if($Status==1)
		{
			$Status="0";
		}else
		{
			$Status="1";
			$this->db->where(array('Template_type_id'=>$Template_type_id,'Company_id'=>$Company_id));
			$this->db->update('igain_company_email_template_master', array('Status'=>0,'Update_user_id'=>$enroll,'Update_date'=>$Update_date));
		}
		
			$this->db->where(array('Company_email_template_id'=>$Company_email_template_id));
			$this->db->update('igain_company_email_template_master', array('Status'=>$Status,'Update_user_id'=>$enroll,'Update_date'=>$Update_date));
	  
	  // echo $this->db->last_query(); 

	  if ($this->db->affected_rows() > 0)
	  {
	   return true;
	  }
	  else 
	  {
	   return false;
	  }
	}

   public function Update_company_emailtemp_master($Post_data,$Company_email_template_id)
	{
		
		$this->db->where(array('Company_email_template_id'=>$Company_email_template_id));
		$this->db->update('igain_company_email_template_master', $Post_data);
		
	  
	  // echo $this->db->last_query(); 

	  if ($this->db->affected_rows() > 0)
	  {
	   return true;
	  }
	  else 
	  {
	   return false;
	  }
	}
	function Insert_reference_emailtemp_master($Post_data)
	{
		$this->db->insert('igain_email_template_master',$Post_data);
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}			
	}
	public function get_Reference_emailtemplate_master($Company_id)
		{	
			
				$this->db->select("*");
			   $this->db->from('igain_email_template_master as e');
			  $this->db->join('igain_template_type_master tm','e.Template_type_id=tm.Template_type_id');
			   $this->db->order_by('Email_template_id','desc');
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
	
	public function Update_refernce_emailtemp_master($Post_data,$Email_template_id)
	{
		
		$this->db->where(array('Email_template_id'=>$Email_template_id));
		$this->db->update('igain_email_template_master', $Post_data);
		
	  
	  // echo $this->db->last_query(); 

	  if ($this->db->affected_rows() > 0)
	  {
	   return true;
	  }
	  else 
	  {
	   return false;
	  }
	}
	public function get_Specific_Reference_emailtemplate_master($Email_template_id)
		{	
			
			$this->db->select("*");
			  $this->db->from('igain_email_template_master et');
			  $this->db->join('igain_template_type_master tm','et.Template_type_id=tm.Template_type_id');
			  $this->db->where(array('Email_template_id' => $Email_template_id));
			  $sql = $this->db->get();
			  if ($sql->num_rows() > 0)
			{
				return $sql->row();
			}
			  return false;
		}	
		
	
	function delete_reference_template($Email_template_id)
	{
		$this->db->where(array('Email_template_id'=>$Email_template_id));
		$this->db->delete("igain_email_template_master");
		// echo "<br><br>".$this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
}
?>