<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Merchant_model extends CI_Model {

    function insert_merchant_category($Seller) {
        $data['Company_id'] = $this->input->post('companyId');
        $data['Merchant_type'] = '0'; //$this->input->post('merchant_type');
        $data['Seller'] = $Seller;
        $data['Item_type_code'] = $this->input->post('item_type_no');
        $data['Item_category_name'] = $this->input->post('item_type_name');
        $data['Item_typedesc'] = $this->input->post('item_desc');
        $this->db->insert('igain_item_category_master', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    public function merchant_item_count($company_id) {
        /* $this->db->select('*');
          $this->db->from('igain_item_category_master as A');
          $this->db->join('igain_company_master as B', 'B.Company_id = A.Company_id');
          $this->db->join('igain_enrollment_master as C', 'C.Enrollement_id = A.Seller');
         */
        $this->db->select('*');
        $this->db->from('igain_item_category_master as A');
        $this->db->where('Company_id', $company_id);

        return $this->db->count_all_results(); //count_all_results---Queries will accept Active Record restrictors such as where(), or_where(), like(), or_like()
    }

    public function merchant_item_list($limit, $start, $company_id) {
        /* if($limit != "" || $start != "" ) 
       {
         $this->db->limit($limit, $start);
       } */
        $this->db->select('*');
        $this->db->from('igain_item_category_master as A');
        $this->db->join('igain_company_master as B', 'B.Company_id = A.Company_id');
        $this->db->join('igain_enrollment_master as C', 'C.Enrollement_id = A.Seller');
        $this->db->where('A.Company_id', $company_id);
        $this->db->order_by('A.Item_category_id', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function edit_merchant_category($Item_category_id) {
        $this->db->where('Item_category_id', $Item_category_id);
        $query = $this->db->get("igain_item_category_master");

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function update_merchant_category($post_data, $Item_category_id) {
        $this->db->where('Item_category_id', $Item_category_id);
        $this->db->update("igain_item_category_master", $post_data);

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_item_code($Item_category_code, $Company_id, $Seller_id) {
        $query = $this->db->select('Item_type_code')
                        ->from('igain_item_category_master')
                        ->where(array('Item_type_code' => $Item_category_code, 'Company_id' => $Company_id, 'Seller' => $Seller_id))->get();
        return $query->num_rows();
    }

    /*     * *********AMIT 08-09-2017**************************** */

    function insert_Code_decode_type($Code_decode_type) {
        $data['Code_decode_type'] = $Code_decode_type;
        $this->db->insert('igain_codedecode_type_master', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    public function Code_decode_type_list($limit, $start) {
       /* if($limit != "" || $start != "" ) 
       {
         $this->db->limit($limit, $start);
       } */
        $this->db->select('*');
        $this->db->from('igain_codedecode_type_master');
        $this->db->order_by('Code_decode_type_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function Code_decode_type_count() {
        $this->db->select('*');
        $this->db->from('igain_codedecode_type_master');
        $this->db->order_by('Code_decode_type_id', 'DESC');
        $query = $this->db->get();


        return $query->num_rows();
    }

    public function Edit_codedecode_type($Code_decode_type_id) {
        $this->db->select('*');
        $this->db->from('igain_codedecode_type_master');
        $this->db->where('Code_decode_type_id', $Code_decode_type_id);
        $this->db->order_by('Code_decode_type_id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function Update_CodeDecodeType($post_data, $Code_decode_type_id) {
        $this->db->where('Code_decode_type_id', $Code_decode_type_id);
        $this->db->update("igain_codedecode_type_master", $post_data);

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function insert_Code_decode($Company_id, $Code_decode, $Code_decode_type_id) {
        $data['Code_decode'] = $Code_decode;
        $data['Company_id'] = $Company_id;
        $data['Code_decode_type_id'] = $Code_decode_type_id;
        $this->db->insert('igain_codedecode_master', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    public function Code_decode_list($limit, $start, $Company_id) {
      /*   if($limit != "" || $start != "" ) 
       {
         $this->db->limit($limit, $start);
       } */
        $this->db->select('*');
        $this->db->from('igain_codedecode_master as A');
        $this->db->join('igain_codedecode_type_master as B', 'A.Code_decode_type_id=B.Code_decode_type_id');

        $this->db->where('Company_id', $Company_id);
        $this->db->order_by('A.Code_decode_type_id', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function Code_decode_count($Company_id) {
        $this->db->select('*');
        $this->db->from('igain_codedecode_master');
        $this->db->where('Company_id', $Company_id);
        $this->db->order_by('Code_decode_id', 'DESC');
        $query = $this->db->get();


        return $query->num_rows();
    }

    public function Edit_codedecode($Code_decode_id) {
        $this->db->select('*');
        $this->db->from('igain_codedecode_master');
        $this->db->where('Code_decode_id', $Code_decode_id);
        $this->db->order_by('Code_decode_id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function Update_CodeDecode($post_data, $Code_decode_id) {
        $this->db->where('Code_decode_id', $Code_decode_id);
        $this->db->update("igain_codedecode_master", $post_data);

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /*     * *********AMIT 08-09-2017**END************************** */
}

?>
