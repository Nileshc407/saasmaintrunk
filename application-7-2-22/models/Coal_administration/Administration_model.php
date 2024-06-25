<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration_model extends CI_Model {
	
   	/***********************************Ravi Starts******************************/
   	/***********************************Auction Starts******************************/
	function insert_auction($filepath)
    {
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("startDate")));
		$data['To_date'] = date("Y-m-d",strtotime($this->input->post("endDate")));		
		$data['End_time'] = $this->input->post('THH').":".$this->input->post('TMM').":00";		
		$data['Auction_name'] = $this->input->post('auction_name');
		$data['Prize'] = $this->input->post('prize');
		$data['Min_bid_value'] = $this->input->post('minpointstobid');
		$data['Min_increment'] = $this->input->post('minincrement');
		$data['Prize_description'] = $this->input->post('description');
		$data['Create_user_id'] = $this->input->post('Create_user_id');
		$data['Creation_date'] = date("Y-m-d H:m:s");
		$data['Company_id'] = $this->input->post('Company_id');
		$data['Seller_id'] = $this->input->post('seller_id');
		$data['Prize_image'] = $filepath;
		$data['Active_flag'] = '1';
		
		$this->db->insert('igain_auction_master', $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
    }	
	public function auction_count($Company_id)
	{
		$this->db->from('igain_auction_master');
		$this->db->where(array('Company_id' => $Company_id, 'Active_flag' => '1'));
		return $this->db->count_all_results();
	}	
	public function auction_list($limit,$start,$Company_id)
	{
		/* $this->db->from('igain_auction_master');
		$this->db->where(array('Company_id' => $Company_id, 'Active_flag' => '1')); */
		$this->db->select('*');
		$this->db->from('igain_auction_master as A');
		$this->db->where(array('A.Company_id' => $Company_id, 'A.Active_flag' => '1'));	
		$this->db->join('igain_enrollment_master as E','A.Seller_id = E.Enrollement_id','LEFT' );			
		$this->db->limit($limit,$start);
		$this->db->order_by('A.Auction_id','DESC');
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
	function delete_auction($Com_id,$Auction_id)
	{
		$this->db->select('Id');
		$this->db->where(array("Auction_id"=>$Auction_id,"Company_id"=>$Com_id));

		$query46 = $this->db->get("igain_auction_winner");
		
		if ($query46->num_rows() > 0)
		{
			return false;
		}
		else
		{
		$this->db->where("Auction_id",$Auction_id);
		$this->db->delete("igain_auction_master");
		
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
	}	
	function edit_auction($Auction_id)
	{
		/* $this->db->where("Auction_id",$Auction_id);
		$query = $this->db->get("igain_auction_master"); */
				
				
		$this->db->select('*');
		$this->db->from('igain_auction_master as A');
		$this->db->join('igain_enrollment_master as E','A.Seller_id = E.Enrollement_id','LEFT');
		$this->db->where("A.Auction_id",$Auction_id);
		$query = $this->db->get();
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}	
	}	
	public function update_auction($filepath)
	{
		$data['From_date'] = date("Y-m-d",strtotime($this->input->post("startDate")));
		$data['To_date'] = date("Y-m-d",strtotime($this->input->post("endDate")));		
		$data['End_time'] = $this->input->post('THH').":".$this->input->post('TMM').":00";		
		$data['Auction_name'] = $this->input->post('auction_name');
		$data['Prize'] = $this->input->post('prize');
		$data['Min_bid_value'] = $this->input->post('minpointstobid');
		$data['Min_increment'] = $this->input->post('minincrement');
		$data['Prize_description'] = $this->input->post('description');
		$data['Update_user_id'] = $this->input->post('Update_user_id');
		$data['Seller_id'] = $this->input->post('seller_id');
		$data['Update_date'] = date("Y-m-d H:m:s");
		$data['Prize_image'] = $filepath;
		
		$Auction_id = $this->input->post('Auction_id');
		$this->db->where('Auction_id', $Auction_id);
		$this->db->update("igain_auction_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
	public function check_auction_name($Auction_name,$Company_id)
	{		
		$this->db->from('igain_auction_master');
		$this->db->where(array('Auction_name' => $Auction_name, 'Company_id' => $Company_id));
		$query = $this->db->get();
		return $query->num_rows();
	}	
	function get_max_bid_value($Company_id)
	{
		$this->db->select_max('Bid_value');
		$this->db->where(array("Company_id" => $Company_id,"Active_flag" =>'0'));
		$this->db->group_by("Auction_id"); 
		$query = $this->db->get("igain_auction_winner");
		
		//echo $this->db->last_query()."<br><br>";
		
		if ($query->num_rows() > 0)
		{
        	// return $query->result_array();
			foreach ($query->result() as $row)
			{
                $data[] = $row;
            }
            return $data;
        }
		else
		{
			return 0;
		}
	}	
	public function auction_winners_list($Company_id,$Max_Bid_value)
	{
		$today = date("Y-m-d");
		
		$this->db->select('B.Id, B.Creation_date, B.Enrollment_id, B.Auction_id, B.Bid_value, C.First_name, C.Middle_name, C.Last_name, A.Auction_name, A.End_time, A.Prize,  A.To_date,A.Seller_id');
		$this->db->from('igain_auction_master as A');
		$this->db->join('igain_auction_winner as B','B.Auction_id = A.Auction_id');
		$this->db->join('igain_enrollment_master as C','B.Enrollment_id = C.Enrollement_id');
		$this->db->where(array('B.Winner_flag' => '0', 'B.Active_flag' => '0', 'A.Active_flag' => '1', 'A.To_date <' => $today,'B.Company_id' => $Company_id, 'B.Bid_value' => $Max_Bid_value));
		$query = $this->db->get();
		//echo $this->db->last_query()."<br><br>";
		
		if ($query->num_rows() > 0)
		{
			/* foreach ($query->result() as $row)
			{
                $data[] = $row;
            } */
            // return $data;
        	return $query->result_array();
        }
		else
		{
			return 0;
		}
	}
	
	public function approved_auction_list($Company_id)
	{
		$this->db->select('B.Id, B.Creation_date, B.Enrollment_id, B.Auction_id, B.Bid_value, C.First_name, C.Middle_name, C.Last_name, A.Auction_name, A.End_time, A.Prize,  A.To_date');
		$this->db->from('igain_auction_master as A');
		$this->db->join('igain_auction_winner as B','B.Auction_id = A.Auction_id');
		$this->db->join('igain_enrollment_master as C','B.Enrollment_id = C.Enrollement_id');
		$this->db->where(array('B.Winner_flag' => '1', 'B.Active_flag' => '0', 'A.Active_flag' => '0', 'B.Company_id' => $Company_id));
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->result_array();
        }
		else
		{
			return 0;
		}
	}	
	public function get_auction_cust_details($Id,$Auction_id,$Enrollment_id)
	{
		$this->db->where(array('Id' => $Id, 'Auction_id' => $Auction_id, 'Enrollment_id' => $Enrollment_id));
		$query = $this->db->get("igain_auction_winner");
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}	
	public function update_cust_details($Enrollment_id,$data)
	{
		$this->db->where(array('Enrollement_id' => $Enrollment_id));
		$this->db->update("igain_enrollment_master", $data);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
	public function approve_auction_winner($Id,$Auction_id,$Enrollment_id)
	{
		$Todays_date = date("Y-m-d");
		$update_date = array('Winner_flag' => '1', 'Creation_date' => $Todays_date);
		$this->db->where(array('Id' => $Id, 'Auction_id' => $Auction_id, 'Enrollment_id' => $Enrollment_id));
		$this->db->update("igain_auction_winner", $update_date);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
	public function delete_auction_winner($Id,$Auction_id,$Enrollment_id)
	{
		$Todays_date = date("Y-m-d");
		$update_date = array('Active_flag' => '1');
		
		//$this->db->where(array('Id' => $Id, 'Auction_id' => $Auction_id, 'Enrollment_id' => $Enrollment_id));
		$this->db->where(array('Auction_id' => $Auction_id));
		$this->db->update("igain_auction_winner", $update_date);
		
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	
	public function update_auction_master($Auction_id,$Company_id)
	{
		$update_date = array('Active_flag' => '0');
		$this->db->where(array('Auction_id' => $Auction_id, 'Company_id' => $Company_id));
		$this->db->update("igain_auction_master", $update_date);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function Get_cust_prepayment_balance($Company_id,$seller_id,$Cust_enroll_id)
	{
		$this->db->select("*");
		$this->db->from('igain_cust_merchant_trans_summary');
		$this->db->where(array('Company_id' => $Company_id,'Seller_id'=>$seller_id,'Cust_enroll_id' => $Cust_enroll_id));
		
		$sql = $this->db->get();
		// echo $this->db->last_query();
		if($sql -> num_rows() == 1)
		{
			return $sql->row();
		}
		else
		{
			return false;
		}
	}
	function update_cust_prepayment_balance($Company_id,$seller_id,$Cust_enroll_id,$update_data_1)
	{		
		// $data_12=array('Cust_block_amt' => $update_data_1 );
		$this->db->where(array('Company_id' => $Company_id,'Seller_id' => $seller_id,'Cust_enroll_id' => $Cust_enroll_id));
		$this->db->update('igain_cust_merchant_trans_summary',$update_data_1);
		// echo $this->db->last_query();
	}
	//*****************************************Ravi Ends*************************************************

}

?>
