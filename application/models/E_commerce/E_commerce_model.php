<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class E_commerce_model extends CI_Model {

    function insert_product_group($Company_id,$seller_id) {
        $data['Product_group_name'] = $this->input->post('product_group_name');
        $data['Seller_id'] = $seller_id;
        $data['Company_id'] = $Company_id;
		
			//********27-03-2020********sandeep***********
			$res1 = $this->db->query("select Max(Product_group_id) from igain_product_group_master");
			 $res2 = $res1->result_array();
			$result = $res2[0]['Max(Product_group_id)'];
			//echo " ---".$result;die;
			$data['Product_group_code'] = ++$result;
			//********27-03-2020********sandeep***********
			$this->db->insert('igain_product_group_master', $data);
			if ($this->db->affected_rows() > 0) {
				return $this->db->insert_id();
			}
		
    }

    public function product_group_count() {
        return $this->db->count_all('igain_product_group_master');
    }

    public function product_group_list($limit, $start,$Company_id) {
       /*  if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        } */
		$this->db->select('A.*,CONCAT(First_name," ",Last_name) as Full_name');
		$this->db->from('igain_product_group_master as A');
		$this->db->join('igain_enrollment_master as E','A.Seller_id=E.Enrollement_id');
        $this->db->order_by('Product_group_id', 'ASC');
		$this->db->where(array('Active_flag'=>1,'A.Company_id' => $Company_id));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function Inactive_product_group_list($limit, $start,$Company_id) {
       /*  if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        } */
        $this->db->order_by('Product_group_id', 'ASC');
		$this->db->where(array('Active_flag'=>0,'Company_id' => $Company_id));
        $query = $this->db->get("igain_product_group_master");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function edit_product_group($Product_group_id) {
        $this->db->where('Product_group_id', $Product_group_id);
        $query = $this->db->get("igain_product_group_master");

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_product_group($post_data, $Product_group_id)
	{
        $this->db->where('Product_group_id', $Product_group_id);
        $this->db->update("igain_product_group_master", $post_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_product_group($Product_group_id) {
        $this->db->where('Product_group_id', $Product_group_id);
        $this->db->delete('igain_product_group_master');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    /* -----------------------------Product Brand----------------------------- */

    public function fetch_product_group_list($Company_id) {
		$this->db->where('Company_id', $Company_id);
        $this->db->order_by('Product_group_id', 'ASC');
        $query = $this->db->get("igain_product_group_master");

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function insert_product_brand() {
        $data['Company_id'] = $this->input->post('Company_id');
        $data['Product_group_id'] = $this->input->post('product_group');
        $data['Product_brand_name'] = $this->input->post('product_brand_name');
		//********27-03-2020********sandeep***********
		$res1 = $this->db->query("select Max(Product_brand_id) from igain_product_brand_master");
		 $res2 = $res1->result_array();
        $result = $res2[0]['Max(Product_brand_id)'];
		//echo " ---".$result;die;
        $data['Product_brand_code'] = ++$result;
		//********27-03-2020********sandeep***********
        $this->db->insert('igain_product_brand_master', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
    }

    public function product_brand_count($Company_id) {
        $this->db->where('Company_id', $Company_id);
        return $this->db->count_all('igain_product_brand_master');
    }

    public function product_brand_list($limit, $start, $Company_id) {
        $this->db->select('A.Product_brand_id, A.Product_brand_name,A.Product_brand_code, B.Product_group_name');
        $this->db->from('igain_product_brand_master as A');
        $this->db->join('igain_product_group_master as B', 'A.Product_group_id = B.Product_group_id');
		$this->db->where(array('A.Active_flag'=>1,'A.Company_id' => $Company_id));
        $this->db->order_by('A.Product_group_id', 'ASC');
      /*   if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        } */
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function Inactive_product_brand_list($limit, $start, $Company_id) {
        $this->db->select('A.Product_brand_id, A.Product_brand_name, B.Product_group_name');
        $this->db->from('igain_product_brand_master as A');
        $this->db->join('igain_product_group_master as B', 'A.Product_group_id = B.Product_group_id');
       $this->db->where(array('A.Active_flag'=>0,'A.Company_id' => $Company_id));
        $this->db->order_by('A.Product_group_id', 'ASC');
      /*   if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        } */
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function edit_product_brand($Product_brand_id) {
        $this->db->select('A.Product_brand_id, A.Product_brand_name, B.Product_group_name');
        $this->db->from('igain_product_brand_master as A');
        $this->db->join('igain_product_group_master as B', 'A.Product_group_id = B.Product_group_id');
        $this->db->where('A.Product_brand_id', $Product_brand_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_product_brand($post_data, $Product_brand_id) {
        $this->db->where('Product_brand_id', $Product_brand_id);
        $this->db->update("igain_product_brand_master", $post_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_product_brand($Product_brand_id) {
        $this->db->where('Product_brand_id', $Product_brand_id);
        $this->db->delete('igain_product_brand_master');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    /* -----------------------------Product Brand----------------------------- */
    /* -----------------------------Ravi Change--31-10-2017----------------------------- */

    function Get_evouchers_details($voucher, $CompanyId) {

        $this->db->select('Trans_id,B.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,Voucher_status,B.Redeem_points,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,CONCAT(First_name," ",Last_name) as Full_name,pinno,B.Purchase_amount,B.Loyalty_pts,B.Paid_amount,B.Online_payment_method,B.Item_code,B.Shipping_points');
        $this->db->from('igain_transaction as B');
        $this->db->join('igain_company_merchandise_catalogue as C', 'B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
        // $this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id');
        $this->db->join('igain_enrollment_master as E', 'B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id');
        // $this->db->where('(B.Card_id='.$MembershipID.' OR E.Phone_no='.$phnumber.')');
        $this->db->where(array('B.Voucher_no' => $voucher, 'B.Company_id' => $CompanyId));
        $this->db->where_in('B.Trans_type', array('10', '12'));
        $this->db->where_in('B.Delivery_method', array('29'));
        $this->db->order_by('Trans_date', 'desc');
        $sql = $this->db->get();
        // echo $this->db->last_query();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function Get_free_evouchers_details($voucher, $CompanyId) {

        $this->db->select('Trans_id,B.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Company_merchandize_item_code,Quantity,Voucher_no,Voucher_status,B.Redeem_points,B.Update_date,Trans_date,Thumbnail_image1,B.Company_id,B.Enrollement_id,CONCAT(First_name," ",Last_name) as Full_name,pinno,B.Paid_amount,B.Online_payment_method,B.Item_code');
        $this->db->from('igain_transaction as B');
        $this->db->join('igain_company_merchandise_catalogue as C', 'B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
        // $this->db->join('igain_branch_master as D','B.Merchandize_Partner_branch=D.Branch_code AND B.Company_id=D.Company_id');
        $this->db->join('igain_enrollment_master as E', 'B.Enrollement_id=E.Enrollement_id AND B.Company_id=E.Company_id AND B.Card_id=E.Card_id');
        // $this->db->where('(B.Card_id='.$MembershipID.' OR E.Phone_no='.$phnumber.')');
        $this->db->where(array('B.Voucher_no' => $voucher, 'B.Company_id' => $CompanyId, 'B.Trans_type' => 20));

        $this->db->order_by('Trans_date', 'desc');
        $sql = $this->db->get();
        // echo $this->db->last_query();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    function validate_voucher($voucher, $Company_id) {
        $this->db->select('*');
        $this->db->from('igain_transaction');
        $this->db->where(array('Company_id' => $Company_id, 'Voucher_no' => $voucher));
        $this->db->where_in('Voucher_status', array('18', '19'));
        $sql51 = $this->db->get();
       // echo $this->db->last_query();die;
        return $sql51->row();
    }

    public function redemtion_fulfillment($limit, $start, $Logged_user_id, $Super_seller, $MPartner_id, $Company_id) {
        $this->db->select('Trans_id,A.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Quantity,Voucher_no,Voucher_status,B.Redeem_points,B.Update_date,Trans_date');

        $this->db->from('igain_enrollment_master as A');
        $this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
        $this->db->join('igain_company_merchandise_catalogue as C', 'B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
        $this->db->where(array('C.Company_id' => $Company_id, 'B.Update_User_id <>' => 0, 'B.Trans_type' => 12));
        if ($Logged_user_id == 5) {
            $this->db->where(array('A.Company_id' => $Company_id, 'B.Seller' => $MPartner_id));
        } else {
            $this->db->where(array('A.Company_id' => $Company_id));
        }
        //$this->db->group_by('B.Bill_no');

        $this->db->order_by('B.Update_date', 'DESC');
        if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function Update_purchase_item_Status($MembershipID, $CompanyId, $evoucher, $Update_User_id, $Voucher_status, $Shipping_partner) {
        $Update_date = date("Y-m-d H:i:s");
        $data = array(
            "Shipping_partner_id" => $Shipping_partner,
            "Voucher_status" => $Voucher_status,
            "Update_User_id" => $Update_User_id,
            "Update_date" => $Update_date
        );
        $this->db->where('Voucher_no', $evoucher);
        $this->db->where('Card_id', $MembershipID);
        $this->db->where('Company_id', $CompanyId);
        $this->db->update("igain_transaction", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    function get_dial_code($Country_id) {
        $query = $this->db->select('*')
                        ->from('igain_currency_master')
                        ->where(array('Country_id' => $Country_id))->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function Update_member_balance($Company_id, $Enrollement_id, $New_curr_balance) {
        $data = array('Current_balance' => $New_curr_balance);
        $this->db->where(array('Enrollement_id' => $Enrollement_id, 'Company_id' => $Company_id));
        $this->db->update('igain_enrollment_master', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    public function update_customer_balance($Membership_id, $Curent_balance, $Company_id, $Topup_amt, $last_visit_date, $purchase_amount, $reddem_amount) {
        $CustomerData = array(
            'Current_balance' => $Curent_balance,
            'Total_topup_amt' => $Topup_amt,
            // 'last_visit_date' => $last_visit_date,
            'total_purchase' => $purchase_amount,
            'Total_reddems' => $reddem_amount
        );
        $this->db->where(array('Company_id' => $Company_id, 'Card_id' => $Membership_id));


        $this->db->update("igain_enrollment_master", $CustomerData);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Insert_purchase_canncel_item($Post_data) {
        $this->db->insert('igain_transaction', $Post_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Get_Merchandize_Item_details($Item_code, $CompanyId) {
        $this->db->select('*');
        $this->db->from('igain_company_merchandise_catalogue');
        $this->db->where(array('Company_merchandize_item_code' => $Item_code, 'Company_id' => $CompanyId));
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            return $sql->row();
        } else {
            return false;
        }
    }

    function Get_Merchandize_Partenr_details($Partner_id, $CompanyId) {
        $this->db->select('*');
        $this->db->from('igain_partner_master');
        $this->db->where(array('Partner_id' => $Partner_id, 'Company_id' => $CompanyId));
        $sql1 = $this->db->get();
        if ($sql1->num_rows() > 0) {
            return $sql1->row();
        } else {
            return false;
        }
    }

    public function Get_Code_decode_master($Company_id) {
        $this->db->select('*');
        $this->db->from('igain_codedecode_master as A');
        $this->db->join('igain_codedecode_type_master as B', 'A.Code_decode_type_id=B.Code_decode_type_id');

        $this->db->where('Company_id', $Company_id);
        $this->db->or_where('Company_id', 1);
        $this->db->order_by('Code_decode_id', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function Get_ecommerce_return_orders($limit, $start, $Company_id) {

        $this->db->select('Trans_id,A.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Quantity,Voucher_no,Voucher_status,CONCAT(First_name," ",Last_name) as Full_name,B.Redeem_points,B.Update_date,Trans_date,B.Paid_amount,B.Purchase_amount,B.Enrollement_id,B.Loyalty_pts,B.Item_code,B.Online_payment_method,B.Shipping_points');

        $this->db->from('igain_enrollment_master as A');
        $this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
        $this->db->join('igain_company_merchandise_catalogue as C', 'B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
        $this->db->where(array('C.Company_id' => $Company_id, 'B.Trans_type' => 12, 'B.Voucher_status' => 22));
        $this->db->where(array('A.Company_id' => $Company_id));

        //$this->db->group_by('B.Bill_no');

        $this->db->order_by('B.Update_date', 'ASC');
        if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function Get_ecommerce_return_orders_count($limit, $start, $Company_id) {

        $this->db->select('Trans_id,A.Card_id,Bill_no,Seller,Trans_type,Merchandize_item_name,Quantity,Voucher_no,Voucher_status,CONCAT(First_name," ",Last_name) as Full_name,B.Redeem_points,B.Update_date,Trans_date,B.Paid_amount,B.Purchase_amount,B.Enrollement_id,B.Loyalty_pts,B.Item_code,B.Online_payment_method,B.Shipping_points');

        $this->db->from('igain_enrollment_master as A');
        $this->db->join('igain_transaction as B', 'A.Card_id = B.Card_id');
        $this->db->join('igain_company_merchandise_catalogue as C', 'B.Item_code=C.Company_merchandize_item_code AND B.Company_id=C.Company_id');
        $this->db->where(array('C.Company_id' => $Company_id, 'B.Trans_type' => 12, 'B.Voucher_status' => 22));
        $this->db->where(array('A.Company_id' => $Company_id));

        //$this->db->group_by('B.Bill_no');

        $this->db->order_by('B.Update_date', 'ASC');
        if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        }

       // $query = $this->db->get();
       return $this->db->count_all_results();
    }

    public function Get_shipping_details($Trans_id, $Company_id) {
        $this->db->select('Cust_name,Cust_address,Cust_phnno,Cust_email,Cust_zip,S.name AS State_name,C.name AS City_name,Co.name AS Country_name');
        $this->db->from('igain_transaction_child3 as A');
        $this->db->join('igain_transaction as B', 'A.Transaction_id = B.Trans_id');
        $this->db->join('igain_state_master as S', 'A.Cust_state = S.id');
        $this->db->join('igain_city_master as C', 'A.Cust_city = C.id');
        $this->db->join('igain_country_master as Co', 'A.Cust_country = Co.id');
        $this->db->where(array('A.Transaction_id' => $Trans_id, 'A.Company_id' => $Company_id));
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function Get_partner($Company_id) {
        $this->db->select('*');
        $this->db->from('igain_partner_master');
        $this->db->where(array('Partner_type' => 4, 'Company_id' => $Company_id));
        $sql = $this->db->get();

        if ($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return 0;
        }
    }

    /* -----------------------------Ravi Change--31-10-2017----------------------------- */
	
	function Check_product_group($productGroupName,$Company_id)
	{	 	 
		$query =  $this->db->select('Product_group_name')
	    ->from('igain_product_group_master')
	    ->where(array('Product_group_name' => $productGroupName,'Company_id' => $Company_id))->get();
		
		// echo $this->db->last_query();	   
		return $query->num_rows();
	}
	function Check_product_brand($product_brand_name,$Company_id)
	{	 	 
		$query =  $this->db->select('Product_brand_name')
	    ->from('igain_product_brand_master')
	    ->where(array('Product_brand_name' => $product_brand_name,'Company_id' => $Company_id))->get();
		
		// echo $this->db->last_query();	   
		return $query->num_rows();
	}
	function Get_product_group_linked_Merchandize_Items($Product_group_id,$Super_seller,$Seller_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_product_group_master as C','A.Product_group_id=C.Product_group_id');
		
		if($Super_seller==1)
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Product_group_id'=>$Product_group_id));
		}
		else
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Product_group_id'=>$Product_group_id,'A.Seller_id'=>$Seller_id));
		}
		$sql=$this->db->get();
		
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
	function Get_product_barnd_linked_Merchandize_Items($Product_brand_id,$Super_seller,$Seller_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_company_merchandise_catalogue as A');
		$this->db->join('igain_product_brand_master as C','A.Product_brand_id=C.Product_brand_id');
		
		if($Super_seller==1)
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Product_brand_id'=>$Product_brand_id));
		}
		else
		{
			$this->db->where(array('A.Active_flag'=>1,'A.Product_brand_id'=>$Product_brand_id,'A.Seller_id'=>$Seller_id));
		}
		$sql=$this->db->get();
		
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
	function Get_product_group_linked_Product_Brand($Product_group_id,$Company_id)
	{
		$this->db->select('A.*');
		$this->db->from('igain_product_brand_master as A');
		$this->db->join('igain_product_group_master as C','A.Product_group_id=C.Product_group_id');
		
		$this->db->where(array('A.Active_flag'=>1,'A.Product_group_id'=>$Product_group_id));
		
		$sql=$this->db->get();
		
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
}
?>