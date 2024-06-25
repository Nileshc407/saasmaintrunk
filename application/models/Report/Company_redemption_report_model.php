<?php 
class Company_redemption_report_model extends CI_model
{
	
	function get_partner_redemption_details($Company_id,$From_date,$To_date,$Partner_id,$partner_branches,$Voucher_status)
	{		
		
		/* IT.Paid_amount, */
		
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));  
		$this->db->select('First_name,Middle_name,Last_name,IT.Enrollement_id,IT.Trans_id,IT.Trans_date,Redeem_points,IT.Card_id,IT.Company_id,Item_code,Voucher_no,ICM.Code_decode as Voucher_status,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch,Merchandize_item_name,Quantity,Redeem_points AS Redeem_points_per_Item,Partner_name,IB.Branch_name,Cost_payable_partner');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code','LEFT');
		$this->db->join('igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join('igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->join('igain_codedecode_master as ICM','IT.Voucher_status=ICM.Code_decode_id');
		// $this->db->where('IB.Company_id' , $Company_id);
		// $this->db->where('IT.Company_id' , $Company_id);
		// $this->db->where('TT.Company_id' , $Company_id); 
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		if($Partner_id !=0)
		{
			$this->db->where_in('IT.Company_id', $partner_branches);

		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		$this->db->where('IT.Trans_type' , 10);
		// if($limit != NULL || $start != ""){				
			// $this->db->limit($limit,$start);
		// }
		$this->db->group_by('Trans_id');
		//$this->db->order_by('IT.Trans_date,IT.Enrollement_id,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch' , 'desc');
		
		$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
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
	function get_partener_update_voucher_status($Company_id,$Card_id,$Voucher_no)
	{
		$this->db->select('UV.Update_date,UV.Voucher_no,UV.Updated_quantity,EN.First_name,EN.Last_name');
		$this->db->from('igain_update_evoucher_status UV');
		$this->db->where(array('UV.CompanyId'=>$Company_id,'UV.MembershipID'=>$Card_id,'UV.Voucher_no'=>$Voucher_no));
		$this->db->join('igain_enrollment_master as EN','UV.MembershipID=EN.Card_id');
		$sql=$this->db->get();	
		// echo "********".$this->db->last_query();die;
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
	function get_partner_redemption_details_exports($Company_id,$From_date,$To_date,$Partner_id,$partner_branches,$Voucher_status)
	{
		
		
		$From_date=date("Y-m-d",strtotime($From_date));
		$To_date=date("Y-m-d",strtotime($To_date));  
		$this->db->select('CONCAT(First_name," ",Last_name) as Member_name,CM.Company_name,IT.Card_id,IT.Trans_date,Item_code,IT.Item_name,Voucher_no,Quantity,Redeem_points,ICM.Code_decode as Voucher_status,Partner_name,IB.Branch_name,Symbol_of_currency as Currency,IT.Cost_payable_partner');
		$this->db->from('igain_transaction as IT');
		$this->db->join('igain_company_master as CM','CM.Company_id=IT.Company_id');
		$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code','LEFT');
		$this->db->join('igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		$this->db->join('igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		$this->db->join('igain_codedecode_master as ICM','IT.Voucher_status=ICM.Code_decode_id');
		$this->db->join('igain_country_master as cnt','cnt.id=CM.Country');
		// $this->db->where('IB.Company_id' , $Company_id);
		// $this->db->where('IT.Company_id' , $Company_id);
		// $this->db->where('TT.Company_id' , $Company_id); 
		$this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		if($Partner_id !=0)
		{
			$this->db->where_in('IT.Company_id', $partner_branches);

		}
		if($Voucher_status!='0')
		{
			$this->db->where('IT.Voucher_status' , $Voucher_status);
		}
		$this->db->where('IT.Trans_type' , 10);
		// if($limit != NULL || $start != ""){				
			// $this->db->limit($limit,$start);
		// }
		$this->db->group_by('Trans_id');
		//$this->db->order_by('IT.Trans_date,IT.Enrollement_id,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch' , 'desc');
		
		$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
		$sql51 = $this->db->get();
		// echo "<br>".$this->db->last_query();
		if($sql51 -> num_rows() > 0)
		{
			//return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				$row->Cost_payable_partner = number_format($row->Cost_payable_partner,2);
				
                $data[] = $row;
            }
			return $data; 
		}
		else
		{
			return false;
		}
		
		
		/* 
		  $From_date=date("Y-m-d",strtotime($From_date));
		  $To_date=date("Y-m-d",strtotime($To_date));
		  $this->db->select('IT.Trans_date,IT.Card_id as Membership_ID,First_name,Middle_name,Last_name,Partner_name,IB.Branch_name,Item_code,Merchandize_item_name,Item_name,Redeem_points,Redeem_points AS Redeem_points_per_Item,(Redeem_points*Quantity) as Total_Redeemed_Points,Voucher_no,ICM.Code_decode as Voucher_status,(Paid_amount*Quantity) as Cost_payable_to_partner,Quantity,Quantity_balance');
		  $this->db->from('igain_transaction as IT');
		  $this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
		  $this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code','LEFT');
		  $this->db->join('igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
		  $this->db->join('igain_branch_master as IB','IT.Merchandize_Partner_branch=IB.Branch_code');
		  $this->db->join('igain_codedecode_master as ICM','IT.Voucher_status=ICM.Code_decode_id');
		  $this->db->where('IB.Company_id' , $Company_id);
		  $this->db->where('IT.Company_id' , $Company_id);
		  // $this->db->where('TT.Company_id' , $Company_id);
		  $this->db->where("IT.Trans_date BETWEEN '".$From_date."' AND '".$To_date."'");
		  if($Partner_id!=0)
		  {
		   $this->db->where('IT.Merchandize_Partner_id' , $Partner_id);
		  }
		  if($partner_branches!='0')
		  {
		   $this->db->where('IT.Merchandize_Partner_branch' , $partner_branches);
		  }
		  if($Voucher_status!='0')
		  {
		   $this->db->where('IT.Voucher_status' , $Voucher_status);
		  }
		  $this->db->group_by('Trans_id');
		  //$this->db->order_by('IT.Trans_date,IT.Enrollement_id,IT.Merchandize_Partner_id,IT.Merchandize_Partner_branch' , 'desc');
		 
		  $this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
		  $sql51 = $this->db->get();
		  
		  //echo "<br>".$this->db->last_query();
		 
		  if($sql51 -> num_rows() > 0)
		  {
		   //return $sql51->row();
			foreach ($sql51->result() as $row)
			{
				$row->Used_quantity = $row->Quantity - $row->Quantity_balance;
				
				// $row->Cost_payable_to_partner = $row->Cost_payable_partner;
				
				/* if($row->Cost_payable_to_partner>0){
				
										
					$row->Cost_payable_to_partner=$row->Cost_payable_to_partner;
					
				}else{
					
					$row->Cost_payable_to_partner = $row->Cost_payable_partner;
					
				} ****
				
				if($row->Merchandize_item_name != ""){
										
					$row->Merchandize_item_name=$row->Merchandize_item_name;
					
				}else{
					
					$row->Merchandize_item_name = $row->Item_name;
				}
				
				$data[] = $row;
			}
			return $data; 
		  }
		  else
		  {
		   return false;
		  }
		  
		  */
	}	
}
?>