<?php
class SubMerchantModel extends CI_Model
{
    //*********** Sub Merchant Account For Braintree Functions *******************************************
    
    function Create_SubMerchantAccount($ID,$Company_id)
    {
            $merchantAccountParams = [
                    
                        'Sub_merchant_id' => $this->input->post('submerchant_id'),
                        'Company_id' => $Company_id,
                        'First_name' => $this->input->post('firstName'),
                        'Last_name' => $this->input->post('lastName'),
                        'Email' => $this->input->post('email'),
                        'Phone' => $this->input->post('phone'),
                        'Dob' => date("Y-m-d",strtotime($this->input->post('dateOfBirth'))),
                        'Ssn' => $this->input->post('ssn'),
                        'StreetAddress' => $this->input->post('streetAddress'),
                          'Locality' => $this->input->post('locality'),
                          'Region' => $this->input->post('region'),
                          'PostalCode' => $this->input->post('postalCode'),
                        'LegalName' => $this->input->post('legalName'),
                        'DbaName' => $this->input->post('dbaName'),
                        'TaxId' =>  $this->input->post('taxId'),
                         'BusinessAddress' =>  $this->input->post('bstreetAddress'),
                          'BusinessLocality' =>  $this->input->post('blocality'),
                          'BusinessRegion' => $this->input->post('bregion'),
                          'BusinessPostalCode' =>  $this->input->post('bpostalCode'),
                      
                        'Descriptor' =>  $this->input->post('descriptor'),
                        'Destination' =>  'bank',
                         // 'FundingEmail' => $this->input->post('femail'),
                         // 'FundingPhone' => $this->input->post('mobilePhone'),
                        'AccountNumber' =>  $this->input->post('accountNumber'),
                        'RoutingNumber' =>  $this->input->post('routingNumber') ,
                        'MasterMerchantAccountId' => 'miraclecartes',
                        'Braintree_id' => $ID
                    ];

        $res = $this->db->insert('igain_paypal_submerchant_account',$merchantAccountParams);
        
        if($this->db->affected_rows() > 0)
		{
			return true;
		}
        
         return false;
    }
    
    function Edit_SubMerchantAccount($merchant_id,$Company_id)
    {
        $this->db->from('igain_paypal_submerchant_account');
        $this->db->where(array('M_id'=>$merchant_id,'Company_id'=>$Company_id));
        $resultG1 = $this->db->get();
        
        if($resultG1->num_rows() > 0)
        {
            foreach($resultG1->result() as $rowG1)
            {
                $optG1[] = $rowG1;
            }
            
            
            return $optG1;
        }
        
        return false;
    }
    
    
    function Update_SubMerchantAccount($M_id,$Company_id)
    {
        $merchantAccountParams = [
                    
                      //  'Sub_merchant_id' => $this->input->post('submerchant_id'),
                       // 'Company_id' => $Company_id,
                        'First_name' => $this->input->post('firstName'),
                        'Last_name' => $this->input->post('lastName'),
                        'Email' => $this->input->post('email'),
                        'Phone' => $this->input->post('phone'),
                        'Dob' => date("Y-m-d",strtotime($this->input->post('dateOfBirth'))),
                        'Ssn' => $this->input->post('ssn'),
                        'StreetAddress' => $this->input->post('streetAddress'),
                          'Locality' => $this->input->post('locality'),
                          'Region' => $this->input->post('region'),
                          'PostalCode' => $this->input->post('postalCode'),
                        'LegalName' => $this->input->post('legalName'),
                        'DbaName' => $this->input->post('dbaName'),
                        'TaxId' =>  $this->input->post('taxId'),
                         'BusinessAddress' =>  $this->input->post('bstreetAddress'),
                          'BusinessLocality' =>  $this->input->post('blocality'),
                          'BusinessRegion' => $this->input->post('bregion'),
                          'BusinessPostalCode' =>  $this->input->post('bpostalCode'),
                      
                        'Descriptor' =>  $this->input->post('descriptor'),
                        'Destination' =>  'bank',
                         // 'FundingEmail' => $this->input->post('femail'),
                         // 'FundingPhone' => $this->input->post('mobilePhone'),
                        'AccountNumber' =>  $this->input->post('accountNumber'),
                        'RoutingNumber' =>  $this->input->post('routingNumber') ,
                       // 'MasterMerchantAccountId' => 'miraclecartes',
                      //  'Braintree_id' => $ID
                    ];

            $this->db->where(array('M_id'=>$M_id,'Company_id'=>$Company_id));
            $this->db->update('igain_paypal_submerchant_account',$merchantAccountParams);
        
        if($this->db->affected_rows() > 0)
		{
			return true;
		}
        
         return false;
    }
    
    function get_all_submerchant_account($Company_id)
    {
        $this->db->from('igain_paypal_submerchant_account');
        $this->db->where('Company_id',$Company_id);
        $resultG = $this->db->get();
        
        if($resultG->num_rows() > 0)
        {
            foreach($resultG->result() as $rowG)
            {
                $optG[] = $rowG;
            }
            
            
            return $optG;
        }
        
        return false;
    }
    
    function Get_Company_SubMerchant_Count($Company_id)
    {
         $this->db->from('igain_paypal_submerchant_account');
        $this->db->where('Company_id',$Company_id);
        $resultG = $this->db->get();
        
        return $resultG->num_rows();
    }
    
    function Delete_SubMerchantAccount($merchant_id,$Company_id)
    {
        $this->db->delete('igain_paypal_submerchant_account',array('M_id'=>$merchant_id,'Company_id'=>$Company_id));
        
         if($this->db->affected_rows() > 0)
		{
			return true;
		}
        
         return false;
    }
//*********** Sub Merchant Account For Braintree Functions *******************************************
}
?>