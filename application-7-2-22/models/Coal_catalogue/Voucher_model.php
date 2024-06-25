<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voucher_model extends CI_Model
{	 
	 
	function Check_voucher_code($Voucher_code,$Company_id)
	{
		$this->db->select('Voucher_id');
		$this->db->from('igain_company_voucher_catalogue');
		$this->db->where(array('Company_id'=>$Company_id,'Voucher_code'=>$Voucher_code));
		// $this->db->where_in('Voucher_type', array('122','123'));
		$sql=$this->db->get();
		// echo $this->db->last_query();
		return $sql->num_rows();
	}
			
	function Insert_voucher($Post_data)
	{
		$this->db->insert('igain_company_voucher_catalogue',$Post_data);
		 // echo $this->db->last_query();
		 // die;
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	function Insert_voucher_child($Post_child_data)
	{
		$this->db->insert('igain_company_voucher_child',$Post_child_data);
		 // echo"----Insert_voucher_child-------".$this->db->last_query()."----<br>";
		 // die;
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}	
		
	}
	
	
	
	function Get_active_voucher_datails($Company_id,$Active_flag)
	{
		$this->db->select('*');
		$this->db->from('igain_company_voucher_catalogue as A');
		$this->db->join('igain_codedecode_master as B','A.Voucher_type=B.Code_decode_id');
		$this->db->where(array('A.Active_flag'=>$Active_flag,'A.Company_id'=>$Company_id));
		// $this->db->where_in('A.Voucher_type', array('122','123'));
		$this->db->order_by('A.Voucher_id','desc');
		$sql=$this->db->get();
		// echo "****".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			
            return $sql->result_array();
		}
		else
		{
			return false;
		}	
		
	}
	
	function Get_voucher_item_details($Company_id,$Todays_date)
	{
		$this->db->select('Company_merchandise_item_id,Company_merchandize_item_code,Merchandize_item_name,Voucher_item_flag');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->where(array('A.Voucher_item_flag'=>1,'A.Active_flag'=>1,'A.Company_id'=>$Company_id,'A.show_item'=>1,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date));
		$this->db->order_by('Company_merchandise_item_id','desc');
		$sql=$this->db->get();
		// echo "****".$this->db->last_query();
		if($sql->num_rows()>0)
		{			
            return $sql->result_array();
		}
		else
		{
			return false;
		}	
		
	}
		
	
	function Get_voucher_count($Company_id,$Active_flag)
	{
		$this->db->select('Voucher_id');
		$this->db->from('igain_company_voucher_catalogue');
		$this->db->where(array('Active_flag'=>$Active_flag,'Company_id'=>$Company_id));
		$this->db->where_in('Voucher_type', array('122','123'));
		
		$sql=$this->db->get();
		// echo $this->db->last_query();
			return $sql->num_rows();
	}
	
		function Check_Merchandize_Item_Code($Voucher_code,$Company_id)
	{
		$this->db->select('Voucher_id');
		$this->db->from('igain_company_voucher_catalogue');
		$this->db->where(array('Company_id'=>$Company_id,'Voucher_code'=>$Voucher_code));
		$sql=$this->db->get();
		//echo $this->db->last_query();die;
		return $sql->num_rows();
	}
	
	
	function Get_voucher_datails($Voucher_id)
	{
		$this->db->select('*');
		$this->db->from('igain_company_voucher_catalogue as A');
		$this->db->join('igain_codedecode_master as B','A.Voucher_type=B.Code_decode_id');
		$this->db->where(array('A.Voucher_id'=>$Voucher_id));
		$sql=$this->db->get();
		//echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			return $sql->row();
			/* foreach ($sql->result() as $row)
			{
                $data[] = $row;
            }
            return $data; */
		}
		else
		{
			return false;
		}	
		
	}
	function Get_voucher_child_datails($Voucher_id)
	{
		$this->db->select('*');
		$this->db->from('igain_company_voucher_child as A');
		$this->db->join('igain_company_merchandise_catalogue as B','B.Company_merchandise_item_id=A.Company_merchandise_item_id');
		$this->db->where(array('A.Voucher_id'=>$Voucher_id));
		$sql=$this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			 return $sql->result_array();
		}
		else
		{
			return false;
		}	
		
	}
	function update_voucher($Voucher_id,$Update_data)
	{
		$this->db->where("Voucher_id",$Voucher_id);
		$this->db->update('igain_company_voucher_catalogue',$Update_data);
		// echo $this->db->last_query()."--<br>"; //die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function update_voucher_child($Voucher_child_id,$Voucher_id,$Update_data)
	{
		$this->db->where(array("Voucher_child_id"=>$Voucher_child_id,"Voucher_id"=>$Voucher_id));
		$this->db->update('igain_company_voucher_child',$Update_data);
		// echo $this->db->last_query()."--<br>"; //die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function Check_product_voucher_item_child($Company_id,$POS_item_id,$Voucher_id,$Voucher_type,$Voucher_code)
	{
		$this->db->select('*');
		$this->db->from('igain_company_voucher_child');
		$this->db->where(array('Company_id'=>$Company_id,'Company_merchandise_item_id'=>$POS_item_id,'Voucher_id'=>$Voucher_id,'Voucher_type'=>$Voucher_type,'Voucher_code'=>$Voucher_code));
		$sql=$this->db->get();
		// echo"---Check_voucher_item_child------".$this->db->last_query()."-------<br>"; 
		if($sql->num_rows()>0)
		{
			 return $sql->row();
		}
		else
		{
			return false;
		}
	}
	function delete_product_voucher_item_child($Company_id,$POS_item_id,$Voucher_id,$Voucher_type,$Voucher_code)
	{
		$this->db->where_not_in('Company_merchandise_item_id', $POS_item_id);
		// $this->db->where(array(''=>$POS_item_id));
		$this->db->where(array('Company_id'=>$Company_id,'Voucher_id'=>$Voucher_id,'Voucher_type'=>$Voucher_type,'Voucher_code'=>$Voucher_code));
		$this->db->delete("igain_company_voucher_child");
		// echo"---delete_product_voucher_item_child------".$this->db->last_query()."-------<br>"; 
		
	}
	function Check_revenue_voucher_child($Company_id,$Voucher_id,$Voucher_type,$Voucher_code)
	{
		$this->db->select('*');
		$this->db->from('igain_company_voucher_child');
		$this->db->where(array('Company_id'=>$Company_id,'Voucher_id'=>$Voucher_id,'Voucher_type'=>$Voucher_type,'Voucher_code'=>$Voucher_code));
		$sql=$this->db->get();
		// echo"---Check_voucher_item_child------".$this->db->last_query()."-------<br>"; 
		if($sql->num_rows()>0)
		{
			 return $sql->row();
		}
		else
		{
			return false;
		}
	}
	function Get_voucher_type_code_decode_master($Company_id)
	{
		$this->db->select('*');
		$this->db->from('igain_codedecode_master');
		$this->db->where(array('Company_id'=>$Company_id,'Code_decode_type_id'=>21));
		$sql=$this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			
            return $sql->result_array();
		}
		else
		{
			return false;
		}		
	}
	function Get_Merchandize_Item_details($Company_merchandise_item_id,$Todays_date)
	{
		$this->db->select('*');
		$this->db->from('igain_company_merchandise_catalogue');		
		$this->db->where(array('Company_merchandise_item_id'=>$Company_merchandise_item_id,'Active_flag'=>1,'show_item'=>1,'Valid_from <='=>$Todays_date,'Valid_till >='=>$Todays_date));
		$sql=$this->db->get();
		// echo $this->db->last_query();
		if($sql->num_rows()>0)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}	
		
	}
	function InActive_voucher($Voucher_id,$Update_user_id,$Update_date)
	{
		$this->db->where("Voucher_id",$Voucher_id);
		$this->db->update('igain_company_voucher_catalogue',array('Active_flag'=>0,' Update_User_id'=>$Update_user_id,'Update_date'=>$Update_date));		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}	
	function Get_voucher_details($VoucherType,$Company_id,$Todays_date)
	{
		$this->db->select('*');
		$this->db->from('igain_company_voucher_catalogue as A');
		$this->db->join('igain_codedecode_master as B','A.Voucher_type=B.Code_decode_id');
		$this->db->where(array('A.Voucher_type'=>$VoucherType,'A.Active_flag'=>1,'A.Company_id'=>$Company_id));
		$this->db->where(array('A.Valid_from <='=>$Todays_date,'A.Valid_till >='=>$Todays_date));
		$this->db->order_by('A.Voucher_id','desc');
		$sql=$this->db->get();
		// echo "****".$this->db->last_query();
		if($sql->num_rows()>0)
		{
			
            return $sql->result_array();
		}
		else
		{
			return false;
		}	
		
	}
	public function get_voucher_details_child($Company_id,$Voucher_id,$Voucher_type,$Todays_date)
	{
		// echo"---get_voucher_details_child-----------<br>"; 
		$Todays_date1=$Todays_date.' 00:00:00';
		$Todays_date2=$Todays_date.' 23:59:59';
		$this->db->select('*');
		$this->db->from('igain_company_voucher_child');
		$this->db->where(array('Company_id'=>$Company_id,'Voucher_id'=>$Voucher_id,'Voucher_type'=>$Voucher_type,'Active_flag'=>1));
		$this->db->where(array('Valid_from <= '=>$Todays_date,'Valid_till >= '=>$Todays_date));
		// $this->db->where("$Todays_date BETWEEN Valid_from AND Valid_till");
		$sql=$this->db->get();
		// echo"---get_voucher_details_child------".$this->db->last_query()."-------<br>"; 
		if($sql->num_rows()>0)
		{
			return $sql->result_array();
		}
		else
		{
			return false;
		}
	}
	public function insert_send_vouchers($Post_vouchers_data)
	{
		$this->db->insert('igain_company_send_voucher',$Post_vouchers_data);
		 // echo"----Insert_voucher_child-------".$this->db->last_query()."----<br>";
		 // die;
		if($this->db->affected_rows()>0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
 }
?>
