<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Transfer_publisher_model extends CI_Model
{
    public function Get_Beneficiary_members($companyID,$Enrollment_id)
    {
            $this->db->select("*");
            $this->db->from("igain_cust_beneficiary_account as a");
            $this->db->join("igain_register_beneficiary_company as b","a.Beneficiary_company_id = b.Register_beneficiary_id");
            $this->db->where(array("a.Company_id" =>$companyID,"a.Enrollment_id" =>$Enrollment_id,"a.Active_flag" =>1));
            $this->db->order_by('Beneficiary_account_id','desc');
            $query = $this->db->get();
           //  echo $this->db->last_query();

            if ($query->num_rows() > 0)
            {
                       foreach ($query->result() as $row)
                                       {
                       $data[] = $row;
               }
               return $data;
            }
    }
    public function Get_Beneficiary_Company_2($companyID)
    {
        $this->db->select("*");
        $this->db->from("igain_register_beneficiary_company as a");
        $this->db->join("igain_beneficiary_company as b","a.Register_beneficiary_id = b.Register_beneficiary_id");
        //$this->db->join("igain_company_master as c","a.Igain_company_id = c.Company_id");
        $this->db->where(array("a.Register_beneficiary_id" =>$companyID));
        $query = $this->db->get();
        //echo $this->db->last_query()."<br>";		
        if ($query->num_rows() > 0) {
           /* foreach ($query->result() as $row) {                    
                 $data[] = $row;
            }
            return $data; */            
            return $query->row();
        }
    }
}
