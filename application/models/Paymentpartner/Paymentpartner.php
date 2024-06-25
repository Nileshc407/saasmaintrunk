<?php
	error_reporting(0);
	class Paymentpartner extends CI_Model
	{
		function Get_partner($partnertype,$Company_id)
		{
			$this->db->select('*');
			$this->db->from('igain_partner_master');
			$this->db->where(array('Partner_type'=>$partnertype,'Company_id'=>$Company_id,'Active_flag'=>1));
			$sql= $this->db->get();
			// echo"---SQL-----".$this->db->last_query()."---<br>";
			if($sql->num_rows() > 0)
			{
				return  $sql->result_array();
			}
			else
			{
				return 0;
			}
		}
		function Paymentpartner_transaction($Partner_Type,$Company_id,$From_date,$To_date,$Partner_id,$return_policy_in_days)
		{
			// $today=date('Y-m-d');

			/* echo"---Partner_Type-----".$Partner_Type."---<br>";
			echo"---Company_id-----".$Company_id."---<br>";
			echo"---From_date-----".$From_date."---<br>";
			echo"---To_date-----".$To_date."---<br>";
			echo"---Partner_id-----".$Partner_id."---<br>";
			echo"---return_policy_in_days-----".$return_policy_in_days."---<br>"; */
				
			$From_date=date("Y-m-d",strtotime($From_date));
			$To_date=date("Y-m-d",strtotime($To_date));
			$this->db->select('IT.Trans_id,IT.Trans_date,,IT.Update_date,IT.Trans_type,IT.Bill_no,IT.Card_id as Membership_ID,First_name,Middle_name,Last_name,Item_code,Merchandize_item_name,Redeem_points,Redeem_points AS Redeem_points_per_Item,(Redeem_points*Quantity) as Total_Redeemed_Points,Voucher_no,Voucher_status,Cost_payable_partner,Shipping_cost,Quantity,Purchase_amount,IT.Delivery_method');
			$this->db->from('igain_transaction as IT');
			$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id');
			$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
			$this->db->join('igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id');
			// $this->db->where('IT.Payment_to_partner_flag',0);
			$this->db->where('IT.Company_id' , $Company_id);
			$this->db->where('IT.Update_date <> ','0000-00-00 00:00:00');
			$this->db->where_in('IT.Trans_type',array(10,12));
			$this->db->where_in('IT.Voucher_status',array(20,31));
			if($From_date != "1970-01-01" && $To_date != "1970-01-01")
			{
				$this->db->where("IT.Update_date BETWEEN '".$From_date."' AND '".$To_date."'");
			}
			if($Partner_Type != 4) //Merchandise Partner
			{
				// $this->db->where('IT.Voucher_status','31');
				// $this->db->where('IT.Delivery_method','28');
				$this->db->where('IT.Payment_to_partner_flag' ,0);
				$this->db->where('IT.Merchandize_Partner_id' , $Partner_id);
			}
			else  //Shipping Partner
			{
				// $this->db->where('IT.Voucher_status','20');
				// $this->db->where('IT.Delivery_method','29');
				$this->db->where('IT.Shipping_payment_flag' , 0);
				$this->db->where('IT.Shipping_partner_id' , $Partner_id);
			}
			$this->db->group_by('Trans_id');
			$this->db->order_by('IT.Enrollement_id,IT.Trans_id' , 'desc');
			$sql51 = $this->db->get();
			// echo "<br>".$this->db->last_query();
			if($sql51 -> num_rows() > 0)
			{
				//return $sql51->row();
				foreach ($sql51->result() as $row)
				{
					// echo"---Update_date-----".$row->Update_date."---<br>";
					$New_update_date=date("Y-m-d",strtotime($row->Update_date.'+ '.$return_policy_in_days.' days'));
					// echo"---New_update_date-----".$New_update_date."---<br>";
					if($From_date != "1970-01-01" && $To_date != "1970-01-01" )
					{
						if($New_update_date < $To_date  )
						{
							$data[] = $row;
						}
					}
					else
					{
						if($New_update_date < $today  )
						{
							$data[] = $row;

						}
					}
				}
				return $data;
			}
			else
			{
			return false;
			}

		}
		function Update_item_payment($Trans_id,$Company_id,$Update_data)
		{

			$this->db->where('Trans_id',$Trans_id);
			$this->db->where('Company_id' , $Company_id);
			$this->db->update("igain_transaction",$Update_data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}
		function Insert_Item_payment($Insert_data)
		{
			$this->db->insert("igain_transaction",$Insert_data);
			if($this->db->affected_rows() > 0)
			{
				return true;
			}
		}

		function Get_item_transaction_details($Trans_id,$Company_id)
		{
			$this->db->select('First_name,Last_name,Merchandize_item_name,Quantity,IT.Update_date,Shipping_cost,Cost_payable_partner');
			$this->db->from('igain_transaction as IT');
			$this->db->join('igain_enrollment_master as En','IT.Enrollement_id=En.Enrollement_id');
			$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');

			$this->db->where(array('IT.Trans_id'=>$Trans_id,'IT.Company_id'=>$Company_id));
			$sql= $this->db->get();
			// echo"---SQL-----".$this->db->last_query()."---<br>";
			if($sql->num_rows() > 0)
			{
				return  $sql->row();
			}
			else
			{
				return 0;
			}
		}
		function Get_partner_details($Partner_id,$Company_id)
		{
			$this->db->select('Partner_name,Partner_contact_person_email');
			$this->db->from('igain_partner_master');
			$this->db->where(array('Partner_id'=>$Partner_id,'Company_id'=>$Company_id,'Active_flag'=>1));
			$sql= $this->db->get();
			// echo"---SQL-----".$this->db->last_query()."---<br>";
			if($sql->num_rows() > 0)
			{
				return  $sql->row();
			}
			else
			{
				return 0;
			}
		}
		function Fetch_partner_payment($trans_id,$Partner_id,$Company_id,$Partner_Type)
		{

			if($Partner_Type ==4)
			{
				$this->db->select('SUM(Shipping_cost) AS CostPayablePartner');
				$this->db->from('igain_transaction');
				$this->db->where(array('Shipping_partner_id'=>$Partner_id,'Company_id'=>$Company_id));
			}
			if($Partner_Type !=4)
			{
				$this->db->select('SUM(Cost_payable_partner) AS CostPayablePartner');
				$this->db->from('igain_transaction');
				$this->db->where(array('Merchandize_Partner_id'=>$Partner_id,'Company_id'=>$Company_id));
			}
			$this->db->where_in('Trans_id', $trans_id);
			// $this->db->where(array('Trans_id'=>$trans_id,'Company_id'=>$Company_id));
			$sql= $this->db->get();
			// echo"---Fetch_partner_payment-----".$this->db->last_query()."---<br>";
			if($sql->num_rows() > 0)
			{
				return  $sql->row();
			}
			else
			{
				return 0;
			}
		}
		function Sattled_partener($Company_id){
			
			// $today=date('Y-m-d');

			/* echo"---Partner_Type-----".$Partner_Type."---<br>";
			echo"---Company_id-----".$Company_id."---<br>";
			echo"---From_date-----".$From_date."---<br>";
			echo"---To_date-----".$To_date."---<br>";
			echo"---Partner_id-----".$Partner_id."---<br>";
			echo"---return_policy_in_days-----".$return_policy_in_days."---<br>"; */
				
			
			$this->db->select('Partner_name,Invoice_no,Partner_type,IT.Trans_id,IT.Trans_date,IT.Update_date,IT.Trans_type,IT.Bill_no,IT.Card_id as Membership_ID,First_name,Middle_name,Last_name,Item_code,Merchandize_item_name,Redeem_points,Redeem_points AS Redeem_points_per_Item,(Redeem_points*Quantity) as Total_Redeemed_Points,Voucher_no,Voucher_status,Cost_payable_partner,Shipping_cost,Quantity,Purchase_amount,IT.Delivery_method');
			$this->db->from('igain_transaction as IT');
			$this->db->join('igain_enrollment_master as IE','IT.Enrollement_id=IE.Enrollement_id','LEFT');
			$this->db->join('igain_company_merchandise_catalogue as TT','IT.Item_code=TT.Company_merchandize_item_code');
			$this->db->join('igain_partner_master as IP','IT.Merchandize_Partner_id=IP.Partner_id','LEFT');
			$this->db->where('IT.Payment_to_partner_flag',1);
			// $this->db->where('IT.Shipping_payment_flag',1);
			$this->db->where('IT.Company_id' , $Company_id);
			$this->db->where_in('IT.Trans_type',array(10,12));
			$this->db->where_in('IT.Voucher_status',array(20,31));
			
			
			$this->db->group_by('Trans_id');
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
	}
?>
