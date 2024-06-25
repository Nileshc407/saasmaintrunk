<?php

  if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  class Generate_debit_trans_invoice_model extends CI_Model {

    public function get_invoice_data($Company_id, $Seller_id, $from_Date, $till_Date, $Seller_Billingratio) {
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

      /* 'T.Billing_Bill_flag' =>1, 'T.Settlement_flag' =>1, */

      $this->db->select("*");
      $this->db->from("igain_transaction AS T");
      $this->db->join('igain_enrollment_master as E', 'E.Card_id = T.Card_id');
      $this->db->where(array('T.Company_id' => $Company_id, 'T.Seller' => $Seller_id, 'T.Trans_type' => 26, 'E.User_activated' => 1,'T.Billing_Bill_flag' =>0, 'T.Settlement_flag' =>0));
      $this->db->where('T.Trans_date BETWEEN "' . $from_Date . '" AND  "' . $till_Date . '" ');
      $this->db->order_by('T.Trans_id', 'DESC');
      $edit_sql = $this->db->get();
      // echo"---Debit Trasnaction----" . $this->db->last_query() . "--<br>"; // die;
      if ($edit_sql->num_rows() > 0) {
        // return $edit_sql->result_array();
        foreach ($edit_sql->result() as $row) {




          /* --------------Check Bill Settled or Not-------------------------- */

          $this->db->select("*");
          $this->db->from("igain_transaction");

          $this->db->where(array('Company_id' => $row->Company_id, 'Seller' => $row->Seller, 'Card_id' => $row->Card_id, 'Manual_billno' => $row->Manual_billno, 'Bill_no' => $row->Bill_no, 'Billing_Bill_flag' => 1, 'Settlement_flag' => 1));
          $this->db->where_in('Trans_type', array(1, 2));
          $exit_sql = $this->db->get();
		  
          // echo"---exit_sql----" . $this->db->last_query() . "--<br>";
          //echo"---num_rows----" . $exit_sql->num_rows() . "--<br>";

         /* --------------Check Bill Settled or Not-------------------------- */

          if ($exit_sql->num_rows() == 1) {

            $BillAmount = $row->Loyalty_pts * $Seller_Billingratio;

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
                'Loyalty_pts' => $row->Loyalty_pts,
                'Payment_type_id' => $row->Payment_type_id,
                'Remarks' => $row->Remarks,
                'Status' => $row->Remarks
            );
            $this->db->insert($temp_tbl, $billing_data);
            $data[] = $row;
          } else {

          }
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

    public function generated_bill_count($Company_id, $Super_seller_flag, $Seller_id) {
      $this->db->where(array('Company_id' => $Company_id, 'Merchant_publisher_type' => 54, 'Bill_flag' => 1));
      if ($Super_seller_flag == 0) {
        $this->db->where('Seller_id', $Seller_id);
      }
      $query = $this->db->from("igain_merchant_billing");
      $query = $this->db->select("*");
      $query = $this->db->get();
      return $query->num_rows();
    }

    public function get_generated_bill_details($limit, $start, $Company_id, $Super_seller_flag, $Seller_id) {
      if ($limit != NULL || $start != NULL) {
        $this->db->limit($limit, $start);
      }
      $this->db->select('*');
      $this->db->from('igain_merchant_billing AS B');
      $this->db->join('igain_enrollment_master as E', 'E.Enrollement_id = B.Seller_id');
      $this->db->where(array('B.Company_id' => $Company_id, 'B.Merchant_publisher_type' => 54, 'B.Bill_flag' => 1));
      if ($Super_seller_flag == 0) {
        $this->db->where('B.Seller_id', $Seller_id);
      }
      $this->db->order_by('B.Bill_id', 'DESC');
      $invoice_sql = $this->db->get();

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
      $this->db->where(array('B.Company_id' => $Company_id, 'B.Merchant_publisher_type' => 54, 'B.Bill_flag' => 1, 'B.Bill_no' => $Bill_no, 'B.Bill_id' => $Bill_id));
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

    public function Get_finance_user($Company_finance_email_id, $Company_id) {
      $this->db->select('First_name,Middle_name,Last_name');
      $this->db->from('igain_enrollment_master');
      $this->db->where(array('Company_id' => $Company_id, 'User_email_id' => $Company_finance_email_id, 'User_id' => 7));
      $Sql = $this->db->get();
      if ($Sql->num_rows() > 0) {
        return $Sql->row();
      }
    }

    function get_company_sellers($Company_id) {
      $this->db->select("Enrollement_id,First_name,Middle_name,Last_name,Current_balance,Super_seller");
      $this->db->from('igain_enrollment_master');
      $this->db->where(array('User_id' => '2', 'User_activated' => '1', 'Company_id' => $Company_id));
      $sql = $this->db->get();

      if ($sql->num_rows() > 0) {
        foreach ($sql->result() as $row) {
          $data[] = $row;
        }
        return $data;
      }
      return false;
    }

  }

?>
