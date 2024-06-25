<?php
Class Trigger_model extends CI_Model
{
	public function Trigger_count($Company_id)
	{
		$this->db->where('Company_id',$Company_id);
		return $this->db->count_all("igain_trigger_notification");
	}
	
	public function Triggers_list($limit,$start,$Company_id)
	{
		//$this->db->limit($limit,$start);
		$this->db->select('*');
		$this->db->order_by('Trigger_notification_id','desc');
		$this->db->from('igain_trigger_notification');
		$this->db->where('Company_id',$Company_id);
		//$this->db->where('Trigger_notification_type',5);
		
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
	
	public function check_trigger_name($Company_id,$triggername)
	{
		$this->db->select('Trigger_notification_id');
		$this->db->from('igain_trigger_notification');
		$this->db->where(array('Company_id'=>$Company_id,'Trigger_notification_name'=>$triggername));
		$query11 = $this->db->get();

        return $query11->num_rows();
	}
	
	public function insert_trigger($CompID)
	{
		$today = date("Y-m-d");
		
		$lpName = $this->input->post('lp_rules');
		
		$insertData = array(
		'Company_id' => $CompID,
		'Trigger_notification_name' => $this->input->post('Triggername'),
		'Trigger_notification_type' => $this->input->post('Criteria'),
		//'Merchant_type' => $this->input->post('merchant_type'),
		'Tier_id' => $this->input->post('Tierid'),
		'Auction_id' => $this->input->post('Auctionid'),
		'Company_game_id' => $this->input->post('Gameid'),
		'Loyalty_rule' => $lpName[0],
		'Threshold_value' => $this->input->post('Thresholdvalue'),
		//'Threshold_value2' => $this->input->post('Thresholdvalue2'),
		//'Operator_id' => $this->input->post('Operatorid'),
		'Creation_date' => $today
		);
		
		$this->db->insert("igain_trigger_notification",$insertData);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		
		return false;
		
	}
	
	public function edit_trigger($Company_id,$triggerID)
	{
		$this->db->select('*');
		$this->db->from('igain_trigger_notification');
		$this->db->where(array('Company_id' => $Company_id, 'Trigger_notification_id' => $triggerID));
		
        $query10 = $this->db->get();

        if ($query10->num_rows() > 0)
		{
        	foreach ($query10->result() as $row10)
			{
                $data10[] = $row10;
            }
            return $data10;
        }
        return false;
	}
	
	public function Update_trigger($Company_id)
	{
		$triggerid = $this->input->post('triggerid');
		$lpName = $this->input->post('lp_rules');
		
		$triggerData = array(
		'Trigger_notification_name' => $this->input->post('Triggername'),
		'Trigger_notification_type' => $this->input->post('Criteria'),
		'Tier_id' => $this->input->post('Tierid'),
		'Auction_id' => $this->input->post('Auctionid'),
		'Company_game_id' => $this->input->post('Gameid'),
		'Loyalty_rule' => $lpName[0],
		'Threshold_value' => $this->input->post('Thresholdvalue'),
		//'Threshold_value2' => $this->input->post('Thresholdvalue2'),
		//'Operator_id' => $this->input->post('Operatorid'),
		);
				
				
		$this->db->where(array('Company_id'=>$Company_id, 'Trigger_notification_id' =>$triggerid));
		$this->db->update("igain_trigger_notification",$triggerData);
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		return false;
	}
	
	public function delete_trigger_notification($Company_id,$TriggerId)
	{
		$this->db->where(array('Company_id'=>$Company_id, 'Trigger_notification_id' =>$TriggerId));
		$this->db->delete("igain_trigger_notification");
		
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		return false;
	}
	
	public function get_next_tier_details($Tier_id,$Company_id)
	{
				
		$this->db->select('Tier_level_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Tier_id' =>$Tier_id,'Active_flag' =>1));
		
		$resA = $this->db->get();
		//echo $this->db->last_query();
		
		$resB = $resA->result_array();
		

			foreach($resB as $rowA)
			{
				$tier_level = $rowA['Tier_level_id'];
			}
		
		$tier_level = $tier_level + 1;
		
		$this->db->select('*');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=>$Company_id, 'Tier_level_id' =>$tier_level,'Active_flag' =>1));
		
		$resc = $this->db->get();
		
		if($resc->num_rows() > 0)
		{
			foreach($resc->result() as $rowC)
			{
				$dataC[] = $rowC;
			}
			
			return $dataC;
		}
		else
		{
			return false;
		}

	}
	
	function get_merchants_types($Company_id)
	{
		$this->db->distinct('Merchant_type');
		$this->db->select('Merchant_type');
		$this->db->from('igain_item_category_master');
		$this->db->where(array('Company_id' => $Company_id, 'Merchant_type <>' => NULL));
		
		$resD = $this->db->get();
		
		if($resD->num_rows() > 0)
		{
			foreach($resD->result() as $rowD)
			{
				$dataD[] = $rowD;
			}
			
			return $dataD;
		}
		else
		{
			return false;
		}
	}
	function get_auction($Auction_id)
	{
		$this->db->where("Auction_id",$Auction_id);
		$query = $this->db->get("igain_auction_master");
				
		if($query -> num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}	
	}
	
}
?>
