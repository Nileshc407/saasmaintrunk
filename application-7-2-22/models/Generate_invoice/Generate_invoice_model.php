<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Generate_invoice_model extends CI_Model {

    public function get_invoice_data($Company_id, $Seller_id, $from_Date, $till_Date, $Seller_Billingratio,$Super_seller) {


      $temp_tbl = $Seller_id . 'billing_temp_table';
      $this->load->helper('date');
      $this->load->dbforge();


      error_reporting(0);
      $fields = array(
          'Bill_id' => array('type' => 'INT', 'constraint' => '11', 'auto_increment' => TRUE),
          'Bill_Transdate' => array('type' => 'datetime'),
          'Bill_Customerno' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
          'Billno' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
          'Bill_Quantity' => array('type' => 'INT', 'constraint' => '11', 'DEFAULT' => 0),
          'Bill_Item_Code' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => TRUE),
          'Bill_purchsed_amount' => array('type' => 'DECIMAL', 'constraint' => '25,2', 'DEFAULT' => 0),
          'Bill_amount' => array('type' => 'DECIMAL', 'constraint' => '25,2', 'DEFAULT' => 0),
          'Loyalty_pts' => array('type' => 'DECIMAL', 'constraint' => '25,2', 'DEFAULT' => 0),
          'Topup_amount' => array('type' => 'DECIMAL', 'constraint' => '25,2', 'DEFAULT' => 0),
          'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => TRUE),
          'Status' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
          'Seller_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
          'Seller_id' => array('type' => 'INT', 'constraint' => '11', 'DEFAULT' => 0),
          'Payment_type_id' => array('type' => 'INT', 'constraint' => '11', 'DEFAULT' => 0),
      );


      $this->dbforge->add_field($fields);
      $this->dbforge->add_key('Bill_id', TRUE);
      $this->dbforge->create_table($temp_tbl, TRUE);

      // $mv_inserted_id = $this->db->insert_id();







      $this->db->select("*");
      $this->db->from("igain_transaction AS T");
      $this->db->join('igain_enrollment_master as E', 'E.Card_id = T.Card_id');
      if($Seller_id == 0 && $Super_seller==1 ) {
        
        $this->db->where(array('T.Company_id' => $Company_id, 'T.Billing_Bill_flag' => 0, 'E.User_activated' => 1));
        
      } else {
          
        $this->db->where(array('T.Company_id' => $Company_id, 'T.Seller' => $Seller_id, 'T.Billing_Bill_flag' => 0,  'E.User_activated' => 1));
      }
      
      $this->db->where_in('T.Trans_type',array(1,2));
      
     
      $this->db->where('T.Trans_date BETWEEN "' . $from_Date . '" AND  "' . $till_Date . '" ');
      //$this->db->order_by('T.Trans_id', 'DESC');
      $edit_sql = $this->db->get();
      // echo"--get_invoice_data--".$this->db->last_query()."---<br>";
      if ($edit_sql->num_rows() > 0) {
        // return $edit_sql->result_array();
        $total_points=0;
        foreach ($edit_sql->result() as $row) {

          //echo"---Purchase_amount-----".$row->Purchase_amount;
          //echo"---Seller_Billingratio-----".$Seller_Billingratio."---<br>";
          
          if($row->Trans_type==1){
            
             $total_points=$row->Topup_amount;
             $row->Loyalty_pts=$row->Topup_amount;
          }
          if($row->Trans_type==2){
            
             $total_points=$row->Loyalty_pts;
             $row->Loyalty_pts=$row->Loyalty_pts;
          }
          
         // echo"---Loyalty_pts-----".$row->Loyalty_pts."---<br>";
          //echo"---Topup_amount-----".$row->Topup_amount."---<br>";
         
          // echo"---total_points-----".$total_points."---<br>";
          $BillAmount = $total_points * $Seller_Billingratio;
           //echo"---BillAmount-----".$BillAmount."---<br>";
          
          $billing_data = array(
              'Bill_purchsed_amount' => $row->Purchase_amount,
              'Bill_amount' => $BillAmount,
              'Bill_Transdate' => $row->Trans_date,
              'Bill_Customerno' => $row->Card_id,
              'Seller_name' => $row->Seller_name,
              'Seller_id' => $row->Seller,
              'Billno' => $row->Manual_billno,
              'Bill_Quantity' => $row->Quantity,
              'Bill_Item_Code' => $row->Item_code,
              'Loyalty_pts' => $total_points,
              'Topup_amount' => $row->Topup_amount,
              'Payment_type_id' => $row->Payment_type_id,
              'Remarks' => $row->Remarks,
              'Status' => $row->Remarks
          );

          $this->db->insert($temp_tbl, $billing_data);
          
           //echo"--insert--".$this->db->last_query()."---<br>";

          $data[] = $row;
        }
        return $data;
      } else {
        return false;
      }
    }

    public function Update_trasnaction_bill_flag($Company_id, $Trans_id, $seller_id, $billing_bill) {

      $this->db->where(array('Company_id' => $Company_id, 'Trans_id' => $Trans_id, 'Seller' => $seller_id));
      $this->db->update('igain_transaction', array('Billing_Bill_flag' => 1, 'Seller_Billing_Bill_no' => $billing_bill));
    }

    public function generated_bill_count($Company_id,$Super_seller,$seller_id) {
     // $this->db->where(array('Company_id' => $Company_id, 'Merchant_publisher_type' => 52, 'Bill_flag' => 1));
      if($Super_seller ==1 ){
         $this->db->where(array('Company_id' => $Company_id, 'Merchant_publisher_type' => 52, 'Bill_flag' => 1));
      } else {
         $this->db->where(array('Company_id' => $Company_id, 'Merchant_publisher_type' => 52, 'Bill_flag' => 1, 'Seller_id' => $seller_id));
      }
      $query = $this->db->from("igain_merchant_billing");
      $query = $this->db->select("*");
      $query = $this->db->get();
      return $query->num_rows();
    }

    public function get_generated_bill_details($limit, $start, $Company_id,$Super_seller,$seller_id) {
      if($limit != "" || $start != "" )
      {
        $this->db->limit($limit, $start);
      }
      $this->db->select('*');
      $this->db->from('igain_merchant_billing AS B');
      $this->db->join('igain_enrollment_master as E', 'E.Enrollement_id = B.Seller_id');
     // $this->db->where(array('B.Company_id' => $Company_id, 'B.Merchant_publisher_type' => 52, 'B.Bill_flag' => 1));
      if($Super_seller ==1 ){
         $this->db->where(array('B.Company_id' => $Company_id, 'B.Merchant_publisher_type' => 52, 'B.Bill_flag' => 1));
      } else {
         $this->db->where(array('B.Company_id' => $Company_id, 'B.Merchant_publisher_type' => 52, 'B.Bill_flag' => 1, 'B.Seller_id' => $seller_id));
      }
      $this->db->order_by('B.Bill_id', 'DESC');
      $invoice_sql = $this->db->get();
      // echo 
      if ($invoice_sql->num_rows() > 0) {
        // return $edit_sql->result_array();		
        foreach ($invoice_sql->result() as $row) {

          $data[] = $row;
        }
        return $data;
      } else {
        return false;
      }
    }

    public function get_generated_invoice($Bill_id, $seller_id, $Bill_no, $Company_id) {
      $this->db->select('*');
      $this->db->from('igain_merchant_billing AS B');
      $this->db->where(array('B.Company_id' => $Company_id, 'B.Merchant_publisher_type' => 52, 'B.Bill_flag' => 1, 'B.Bill_no' => $Bill_no, 'B.Bill_id' => $Bill_id));
      $this->db->order_by('B.Creation_date', 'DESC');
      $invoice_sql = $this->db->get();
      if ($invoice_sql->num_rows() > 0) {
        return $invoice_sql->row();
        /* foreach ($invoice_sql->result() as $row)
          {

          $data[] = $row;
          }
          return $data; */
      } else {
        return false;
      }
    }

    public function get_annexure_Details($Bill_id, $seller_id, $Bill_no, $Company_id) {
      $this->db->select('*');
      $this->db->from('igain_transaction');
      $this->db->where(array('Company_id' => $Company_id, 'Seller' => $seller_id, 'Seller_Billing_Bill_no' => $Bill_no, 'Billing_Bill_flag' => 1));
       $this->db->where_in('Trans_type',array(1,2));
      $this->db->order_by('Trans_date', 'ASC');
      $invoice_sql = $this->db->get();
      if ($invoice_sql->num_rows() > 0) {
        // return $invoice_sql->row();
        foreach ($invoice_sql->result() as $row) {

          $data[] = $row;
        }
        return $data;
      } else {
        return false;
      }
    }

  }

?>