<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reconsolation_data_map extends CI_Model {

    public function data_map_list($limit,$start,$Company_id,$Super_seller,$Logged_user_enrollid)
    {
            $this->db->limit($limit,$start);
            $query = $this->db->from("igain_data_upload_map_tbl as dm");
            $query = $this->db->join("igain_enrollment_master as em","dm.Column_Seller_id=em.Enrollement_id");
            if($Super_seller==0)
            {
                $query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"dm.Column_Seller_id"=>$Logged_user_enrollid,"Data_map_for" => 3));
            }
            else
            {   
                $query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"Data_map_for" => 3));
            }			
            //$query = $this->db->where("dm.Column_Company_id",$Company_id);
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

   public function check_exist_data_map_seller($Seller_id,$Company_id)
        {

                $query = $this->db->where(array("Column_Company_id" => $Company_id,"Column_Seller_id" => $Seller_id,"Data_map_for" =>3));
                $query = $this->db->from("igain_data_upload_map_tbl");
                $query = $this->db->select("*");
                $query = $this->db->get();
                return $query->num_rows();
        }

    public function data_map_count($Company_id)
    {
            /* $query = $this->db->where("Column_Company_id",$Company_id);
            return $this->db->count_all("igain_data_upload_map_tbl"); */
            $query = $this->db->where(array("Column_Company_id" => $Company_id,"Data_map_for" =>3));
            $query = $this->db->from("igain_data_upload_map_tbl");
            $query = $this->db->select("*");
            $query = $this->db->get();
            return $query->num_rows();
    }

        function insert_data_map($post_data)
    {		

                $this->db->insert('igain_data_upload_map_tbl', $post_data);
                if($this->db->affected_rows() > 0)
                {
                        return $this->db->insert_id();
                }
        }

        function delete_data_mapping($Map_id)
    {		
                $this->db->where('Map_id',$Map_id);
                $this->db->delete('igain_data_upload_map_tbl');

                if($this->db->affected_rows() > 0)
                {
                        return true;
                }
        }

        function get_data_mapping($Map_id)
    {		
                //$this->db->select("*");
                $this->db->from('igain_data_upload_map_tbl');
                $this->db->where('Map_id',$Map_id);

                $rec = $this->db->get();

                if($rec -> num_rows() == 1)
                {
                        return $rec->row();
                }
                else
                {
                        return false;
                }
        }

        function update_data_map($post_data,$Map_id)
    {		
                $this->db->where('Map_id',$Map_id);
                $this->db->update('igain_data_upload_map_tbl',$post_data);

                if($this->db->affected_rows() > 0)
                {
                        return true;
                }
        }

/***************************** Amit Work End ********************************/	

/***************************** Sandeep Work Start ********************************/	

        /***** Data file upload ********/
        public function get_datamaping_details($Company_id,$Logged_user_id,$Logged_user_enrollid)
        {
                if($Logged_user_id == 3)
                {
                        $this->db->select("Column_Customer");
                        $this->db->from("igain_data_upload_map_tbl");
                        $this->db->where(array("Column_Company_id" => $Company_id));
                }
                else
                {
                        $this->db->select("Column_Customer");
                        $this->db->from("igain_data_upload_map_tbl");
                        $this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $Logged_user_enrollid));
                }

                $data_map_query12 = $this->db->get();

                //echo $this->db->last_query();

                return $data_map_query12->num_rows();
        }

        public function get_upload_file_data($Logged_user_enrollid)
        {
                $temp_tbl = $Logged_user_enrollid.'uploadtempdatatbl';

                $this->db->from($temp_tbl);
                // $this->db->join("igain_payment_type_master", "igain_payment_type_master.Payment_type_id = ".$temp_tbl.".Pos_Payment_type");
                // $this->db->order_by('Pos_Transdate','asc');
                $query15 = $this->db->get();

                if ($query15->num_rows() > 0)
                {
                    foreach ($query15->result() as $row)
                    {
                         $data[] = $row;
                    }
                    return $data;
                }
                return false;

        }

        public function get_upload_file_data_for_transaction($Logged_user_enrollid)
        {
                $temp_tbl = $Logged_user_enrollid.'uploadtempdatatbl';
                 $this->db->select("*,SUM(Pos_Billamt) AS Total_amount,GROUP_CONCAT(Remarks SEPARATOR ', ') as Flatfile_remarks");
                 $this->db->order_by('Pos_Transdate','asc');
                 $this->db->group_by('Pos_Billno');
                 $this->db->from($temp_tbl);
                 $this->db->join("igain_payment_type_master", "igain_payment_type_master.Payment_type_id = ".$temp_tbl.".Pos_Payment_type");

                $query15 = $this->db->get();
        //	echo "<br>********<br>".$this->db->last_query();
                if ($query15->num_rows() > 0)
                {
                foreach ($query15->result() as $row)
                        {
                $data[] = $row;
            }
            return $data;
        }
        return false;

        }

        /*
        public function clear_upload_errors($Company_id,$filename)
        {
                $select_date = date("Y-m-d",strtotime($this->input->post("file_date")));

                $this->db->query("Delete FROM igain_flatfile_error_log where Company_id=".$Company_id." and File_name='".$filename."' and Date='".$select_date."' ");

        }*/

        public function upload_data_map_file($filepath,$filename,$Company_id,$Logged_user_enrollid)
        {
                $temp_tbl = $Logged_user_enrollid.'uploadtempdatatbl';
                $this->load->helper('date');
                $this->load->dbforge();
                if( $this->db->table_exists($temp_tbl) == TRUE ){
                        $this->dbforge->drop_table($temp_tbl);
                }
               
                $fields = array(
                        'upload_id' => array('type' => 'INT','constraint' => '11','auto_increment' => TRUE),
                        'Pos_Transdate' => array('type' => 'datetime'),
                        'Pos_Customerno' => array('type' => 'VARCHAR', 'constraint' => '50'),
                        'Pos_Billno' => array('type' => 'VARCHAR', 'constraint' => '50'),
                        'Pos_Billamt' => array('type' => 'DECIMAL', 'constraint' => '25,2'),
                        'Status' => array('type' => 'VARCHAR', 'constraint' => '100'),
                        'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200')
                        
                    );


                $this->dbforge->add_field($fields);

                $this->dbforge->add_key('upload_id', TRUE);
                       

                $this->dbforge->create_table($temp_tbl, TRUE);


                $this->db->from("igain_data_upload_map_tbl");
                $this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $Logged_user_enrollid, "Data_map_for" => 3));

                $data_map_query = $this->db->get();

                $data_map = $data_map_query->result_array();

                foreach($data_map as $dmap)
                {
                    $col_date = $dmap["Column_Date"];
                    $col_cust=$dmap["Column_Customer"];
                    $col_bill=$dmap["Column_Bill_no"];
                    $col_amt=$dmap["Column_Amount"];
                    $col_Status=$dmap["Column_Status"];
                    $col_header_rows=$dmap["Column_header_rows"];
                    $col_remarks=$dmap["Column_remarks"];
                }

               

                function getExtension($str) 
                {
                         $i = strrpos($str,".");
                         if (!$i) { return ""; }
                         $l = strlen($str) - $i;
                         $ext = substr($str,$i+1,$l);
                         return $ext;
                }

                $extension = getExtension($filename);

                $data['Company_id'] = $Company_id;
                $data['Active_flag'] = 1;

               
                $from_date = date("Y-m-d H:i:s",strtotime($this->input->post("from_date")));
                $till_date = date("Y-m-d H:i:s",strtotime($this->input->post("till_date")));

                $Today_Date = date("Y-m-d");

                $get_error = array();
                $get_trans_date = array();
                $get_error_row = array();
                $Data_not_found_flag=0;


                $get_error_trans_date = array();
                $get_error_account_id = array();
                $get_error_bill_no = array();
                $get_error_purchase_miles = array();
                $get_error_remarks = array();
                $get_error_status = array();

               

				if($extension == "csv") 
				{
					$filenameis = $filename;
					$handle = fopen($filepath,"r");
					$index=0;
					
					for ($lines = 1; $csv_data = fgetcsv($handle,1000,",",'"'); $lines++)
					{	

						$access = 0;
				
						echo"--access---1---".$access."---lines---".$lines."---<br>";
							
						if ($lines <= $col_header_rows) continue;
						$TrDate2 = $csv_data[$col_date];
						$TransactionDate2 = date("Y-m-d H:i:s",strtotime($TrDate2));

						if($csv_data[0]  && ($TransactionDate2 >= $from_date) && ($TransactionDate2 <= $till_date)) 
						{
							
							
							$TrDate = $csv_data[$col_date];
							if($TrDate == "")
							{
								$get_error[$index] = "Transaction Date is missing";
								$get_trans_date[$index] = date("Y-m-d",strtotime($TrDate));
								$access = 1;
								$get_error_row[$index] =  $lines;

								
								$get_error_trans_date[$index] =date("Y-m-d",strtotime($TrDate));
								$get_error_account_id[$index] = $CardID;
								$get_error_bill_no[$index] = $BillNo;
								$get_error_purchase_miles[$index] = $TransactionAmt;
								// $get_error_remarks[] = $Remarks;
								$get_error_status[$index] = $Status;
							}
							
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$CardID = addslashes($csv_data[$col_cust]);
							if($CardID == "")
							{
								$get_error[$index] = "Identifier ID is missing";
								$get_trans_date[$index] = date("Y-m-d",strtotime($TrDate));
								$access = 1;

								$get_error_row[$index] =  $lines;

								
								$get_error_trans_date[$index] =date("Y-m-d",strtotime($TrDate));
								$get_error_account_id[$index] = $CardID;
								$get_error_bill_no[$index] = $BillNo;
								$get_error_purchase_miles[$index] = $TransactionAmt;
								// $get_error_remarks[] = $Remarks;
								$get_error_status[$index] = $Status;
							}
							if($CardID != "") 
							{

								$Qresult = $this->db->query("Select Beneficiary_account_id from igain_cust_beneficiary_account where Company_id='".$Company_id."' AND Beneficiary_membership_id='".$CardID."' AND Beneficiary_status='1' ");	
								if($Qresult->num_rows() == 0)
								{
									$get_error[] = "Invalid Indetifier ID";
									$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								   
									$access = 1;
									
									
									$get_error_row[] =  $lines;
									
									$get_error_trans_date[$index] =date("Y-m-d",strtotime($TrDate));
									$get_error_account_id[$index] = $CardID;
									$get_error_bill_no[$index] = $BillNo;
									$get_error_purchase_miles[$index] = $TransactionAmt;
									// $get_error_remarks[] = $Remarks;
									$get_error_status[$index] = $Status;									

								}
							}
							
							$BillNo = $csv_data[$col_bill];
							if($BillNo == "")
							{
								$get_error[] = "Bill Number is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$access = 1;
								
								$get_error_row[] =  $lines;

								$get_error_trans_date[$index] =date("Y-m-d",strtotime($TrDate));
								$get_error_account_id[$index] = $CardID;
								$get_error_bill_no[$index] = $BillNo;
								$get_error_purchase_miles[$index] = $TransactionAmt;
								// $get_error_remarks[] = $Remarks;
								$get_error_status[$index] = $Status;
								
									 
							} 
							$TransactionAmt = $csv_data[$col_amt];
							if($TransactionAmt == "")
							{
								$get_error[] = "Purchase Miles is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$access = 1;
								$get_error_row[] =  $lines;

								$get_error_trans_date[$index] =date("Y-m-d",strtotime($TrDate));
								$get_error_account_id[$index] = $CardID;
								$get_error_bill_no[$index] = $BillNo;
								$get_error_purchase_miles[$index] = $TransactionAmt;
								// $get_error_remarks[] = $Remarks;
								$get_error_status[$index] = $Status;
								

							}							
							$Status = $csv_data[$col_Status];
							if($Status == "")
							{
							   
								$get_error[$index] = "Status is missing";
								$get_trans_date[$index] = date("Y-m-d",strtotime($TrDate));
								$access = 1;
								$get_error_row[$index] =  $lines;
								
								$get_error_trans_date[$index] =date("Y-m-d",strtotime($TrDate));
								$get_error_account_id[$index] = $CardID;
								$get_error_bill_no[$index] = $BillNo;
								$get_error_purchase_miles[$index] = $TransactionAmt;
								// $get_error_remarks[] = $Remarks;
								$get_error_status[$index] = $Status;
							}           
								
							
							$Remarks = $csv_data[$col_remarks];
							
							
							
							echo"--access----2----".$access."---<br>";
							if($access == 0 )
							{
									$sql_out1 = $this->db->query("select Trans_id,Voucher_status from  igain_transaction where Manual_billno ='".$BillNo."' and Card_id2='".$CardID."'  and Company_id='".$Company_id."'");
									
									foreach($sql_out1->result() as $sql) {
										
										  $Voucher_status=$sql->Voucher_status;
									}

							   if(($sql_out1->num_rows() > 0) && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
								{
									   
									if($CardID != NULL )
									{	
										$tbl_data = array(                                                                            
												'Pos_Transdate' => $TransactionDate,
												'Pos_Customerno' => $CardID,
												'Pos_Billno' => $BillNo,
												'Status' => $Status,
												'Pos_Billamt' => $TransactionAmt,
												'Remarks' => $Remarks
										);								
										$this->db->insert($temp_tbl, $tbl_data);

									}
								}
								else
								{

									$get_error[] = "Invalid Bill Number";
									$get_trans_date[] = date("Y-m-d",strtotime($TrDate));									
									$get_error_row[] =  $lines;

									
									
									
									// $get_error_trans_date[] =date("Y-m-d",strtotime($TrDate));
									
									/* $get_error_account_id[] = $CardID;
									$get_error_bill_no[] = $BillNo;
									$get_error_purchase_miles[] = $TransactionAmt;
									// $get_error_remarks[] = $Remarks;
									$get_error_status[] = $Status; */
									
									
								}
							}                                               
							/* else
							{
								$get_error_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_account_id[] = $CardID;
								$get_error_bill_no[] = $BillNo;
								$get_error_purchase_miles[] = $TransactionAmt;
								// $get_error_remarks[] = $Remarks;
								$get_error_status[] = $Status;
								$get_error_row[] =  $lines ;								

							} */	
						}
						else
						{
							$Data_not_found_flag=1;
							$Upload_status = 3;
						}
						
						echo"--access---3---".$access."---<br>";
						if($access == 1){
							
							
							continue;
							 
						} 

						$index++;
						                                    
                    }
											
                      
                }
				
               /*  else if( $extension == "xlsx" ||  $extension == "xls") 
                {

                            $this->load->library('excel');

                            $objPHPExcel = PHPExcel_IOFactory::load($filepath);

                            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                            $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
                            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
                            $sd = 0;

                            foreach ($cell_collection as $cell) 
                            {
                                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                                if ($row == 1) 
                                {
                                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                                    $header[$row][2] = $data_value;

                                } 
                                else 
                                {
                                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                                    $data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                                    
                                    $points_data[$sd]= $data_value;
                                   

                                    $temp  = strtotime(  PHPExcel_Style_NumberFormat::toFormattedString($points_data[$col_date],'YYYY-MM-DD H:i:s' ));
                                    $TransactionDate = date('Y-m-d H:i:s',$temp) ;	
                                   
                                    $access = 0;
                                  
                                    $sd++;
                                    $lines = $row;
                                   
                                    $TransactionDate2 = date('Y-m-d H:i:s',$temp) ;
                                    if(($sd==$highestColumnIndex))
                                    {
                                        
                                        $sd = 0;
                                        $CardID="";
                                        $TrDate = $points_data[$col_date]; 

                                       
                                        if($TrDate == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                        {
                                            $get_error[] = "Transaction Date is missing";
                                            $get_error_row[] =  $lines ;
                                            $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                            $access = 1;
                                        }

                                        if($Company_id == 3 )
                                        {   	

                                                $Remarks = $points_data[$col_remarks];									
                                                $Customer_name = $Remarks;									
                                               									
                                                if($Customer_name == "")
                                                {
                                                        $get_error[] = "Customer name is missing";
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TrDate));
                                                        $get_error_row[] =  $lines ;
                                                        $access = 1;
                                                }									
                                                $CustomerName = explode(' ',$Customer_name);
                                                $First_name=$CustomerName[0]; 
                                                $Last_name=$CustomerName[1];

                                               

                                                $Get_customer = "Select Enrollement_id,First_name,Last_name,Card_id from igain_enrollment_master where Company_id='".$Company_id."' AND First_name='".$First_name."' AND Last_name='".$Last_name."' AND User_id='1' ";

                                                $sql = $this->db->query($Get_customer);
                                                foreach ($sql->result() as $row)
                                                {
                                                        $Enrollement_id=$row->Enrollement_id;
                                                        $Fname=$row->First_name;
                                                        $Lname=$row->Last_name;
                                                        $CardID=$row->Card_id;
                                                }
                                                if($CardID != NULL )
                                                {	
                                                        $Qresult = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND Card_id='".$CardID."' AND User_id='1' ");							
                                                        if($Qresult->num_rows() == 0)
                                                        {
                                                                $get_error[] = "Invalid Membership ID";
                                                                $get_trans_date[] = date("Y-m-d",strtotime($TrDate));
                                                                $get_error_row[] =  $lines ;
                                                                $access = 1;
                                                        }
                                                }

                                                $Quantity = $points_data[$col_Quantity];
                                                if($Quantity == "")
                                                {
                                                        $get_error[] = "Quantity is missing";
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TrDate));
                                                        $get_error_row[] =  $lines ;
                                                        $access = 1;
                                                }
                                                $Quantity = preg_replace('/[^0-9]+/', '', $Quantity);

                                                $Remarks='Flat File Upload';								
                                                $PaymentBy = 2;
                                        }
                                        else
                                        {	

                                                $CardID = addslashes($points_data[$col_cust]);									
                                                if($CardID == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                                {
                                                        $get_error[] = "Membership Id is missing";
                                                        $get_error_row[] =  $lines ;
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                        $access = 1;
                                                }									
                                                $Qresult = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND Card_id='".$CardID."' AND User_id='1' ");

                                                if($Qresult->num_rows() == 0 && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                                {
                                                        $get_error[] = "Invalid Membership Id";
                                                        $get_error_row[] =  $lines ;
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                        $access = 1;
                                                }								
                                                $PaymentBy = $points_data[$col_payment];									
                                                if($PaymentBy == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                                {
                                                        $get_error[] = "Payment Type is missing";
                                                        $get_error_row[] =  $lines ;
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                        $access = 1;
                                                }
                                                $Remarks = $points_data[$col_remarks];
                                                if($Remarks == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                                {
                                                        $get_error[] = "Remarks is missing2";
                                                        $get_error_row[] =  $lines ;
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                        $access = 1;
                                                }
                                                $Quantity = $points_data[$col_Quantity];
                                              
                                                if($Quantity == "")
                                                {
                                                        $get_error[] = "Quantity is missing";
                                                        $get_trans_date[] = date("Y-m-d",strtotime($TrDate));
                                                        $get_error_row[] =  $lines ;
                                                        $access = 1;
                                                }
                                        }

                                        $TransactionAmt = $points_data[$col_amt];									
                                        if($TransactionAmt == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                        {
                                                $get_error[] = "Transaction Amount is missing";
                                                $get_error_row[] =  $lines ;
                                                $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                $access = 1;
                                        }
                                        $TransactionAmt = $points_data[$col_amt];									
                                        if($TransactionAmt == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                        {
                                                $get_error[] = "Transaction Amount is missing";
                                                $get_error_row[] =  $lines ;
                                                $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                $access = 1;
                                        }
                                        $BillNo = $points_data[$col_bill];
                                        if($BillNo == "" && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                        {
                                                $get_error[] = "Bill Number is missing";
                                                $get_error_row[] =  $lines ;
                                                $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                                $access = 1;
                                        }									
                                       
                                        if($access ==  0 && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))
                                        {
                                            $sql_out1 = $this->db->query("select Trans_id from  igain_transaction where Manual_billno ='".$BillNo."' and Card_id='".$CardID."' and Company_id='".$Company_id."'");

                                            if(($sql_out1->num_rows() == 0) )
                                            {
                                                if($CardID != NULL )
                                                {
                                                    $tbl_data = array(

                                                        'Pos_Transdate' => $TransactionDate,
                                                        'Pos_Customerno' => $CardID,
                                                        'Pos_Billno' => $BillNo,
                                                        'Pos_Payment_type' => $PaymentBy,
                                                        'Pos_Billamt' => $TransactionAmt,
                                                        'Pos_Quantity' => $Quantity,
                                                        'Remarks' => $Remarks
                                                    );

                                                    $this->db->insert($temp_tbl, $tbl_data);
                                                }
                                            }
                                            else
                                            {                                                      

                                                $get_error[] = "Transaction Is Already Exist";
                                                $get_error_row[] =  $lines ;
                                                $get_trans_date[] = date("Y-m-d",strtotime($TransactionDate));
                                            }
                                        }
                                        else
                                        {
                                                $Data_not_found_flag=1;
                                                $Upload_status = 3;
                                        }
                              

                                    }

                                }


                            }                                      


				}
				else
				{
					return false;
				}
				 */


				$this->db->where(array('Company_id' =>$Company_id, 'File_name' =>$filename ));
				$this->db->delete('igain_flatfile_error_log');

				$error_status = count($get_error);	
				if($error_status > 0)
				{
					$coln_array = array(
							'Company_id' => $Company_id,
							'File_name' => $filename,
							'File_path' =>$filepath,
							'Upload_status' =>'1',
							'Error_status'=> $error_status,
							'Date' => $Today_Date
					);

					 $Upload_status = 0;

					$this->db->insert('igain_file_upload_status',$coln_array);

					$mv_inserted_id = $this->db->insert_id();

					$Upload_status = $mv_inserted_id;

					for($pk = 0; $pk < $error_status; $pk++)
					{
						if($get_error[$pk] != "")
						{
							$colm_arr = array(
							'Company_id' => $Company_id,
							'File_name' => addslashes($filename),
							'File_path' => addslashes($filepath),
							'Status_id' => $mv_inserted_id,
							'Date' => $get_trans_date[$pk],
							'Error_in' => $get_error[$pk],
							'Error_row_no' => $get_error_row[$pk],
							
							'Card_id'  => $get_error_account_id[$pk],
							'Transaction_date'  => $get_error_trans_date[$pk],
							'Bill_no'  =>   $get_error_bill_no[$pk],
							'Transaction_amount'  =>  $get_error_purchase_miles[$pk],
							 'Status'  =>   $get_error_status[$pk],
							'Remarks'  =>   $get_error_remarks[$pk]
							);

							$this->db->insert('igain_flatfile_error_log',$colm_arr);
							
							  echo"---SQL----".$this->db->last_query()."---<br>";
							   
							 
						}
					}
				}
				else
				{
					$coln_array = array(
							'Company_id' => $Company_id,
							'File_name' => $filename,
							'File_path' =>$filepath,
							'Upload_status' =>'0',
							'Error_status'=> '0',
							'Date' => $Today_Date
					);

					$this->db->insert('igain_file_upload_status',$coln_array);
					$mv_inserted_id = $this->db->insert_id();

					// $Upload_status = 1;
					$Upload_status = $mv_inserted_id;
				}
                // echo"---Data_not_found_flag----".$Data_not_found_flag."---<br>";
                // echo"---Upload_status----".$Upload_status."---<br>";
                if($Data_not_found_flag==1)
                {
                    $Upload_status = 3;
                }
                
                  echo"---Upload_status----".$Upload_status."---<br>";
                // return $Upload_status;

        }

        function get_upload_errors($filename,$Company_id)
        {
                $todayDate = date("Y-m-d");
                $this->db->select('*');
                $this->db->from('igain_flatfile_error_log');
                //$this->db->where(array('File_name' =>$filename,'Company_id' =>$Company_id,'Date'=>$todayDate));
                $this->db->where(array('File_name' =>$filename,'Company_id' =>$Company_id));//22-8-2016 AMIT

                $error_data = $this->db->get();

                //echo $this->db->last_query();

                if($error_data->num_rows() > 0)
                {
                        foreach($error_data->result() as $rower)
                        {
                                $dataer[] = $rower;
                        }
                        return $dataer;
                }
                 return false;
        }

        function get_file_erro_status($file_status,$Company_id)
        {
                $this->db->select("*");
                // $this->db->select("File_name,Upload_status,Error_status");
                $this->db->from("igain_file_upload_status");
                $this->db->join("igain_flatfile_error_log", "igain_flatfile_error_log.Status_id =igain_file_upload_status.Status_id");
                $this->db->where(array('igain_file_upload_status.Company_id' => $Company_id, 'igain_file_upload_status.Status_id'=> $file_status));
                $queryOPT = $this->db->get();
                if($queryOPT->num_rows() > 0)
                {
                        foreach($queryOPT->result() as $roww)
                        {
                                $data[] = $roww;
                        }
                        return $data;
                }
                 return false;
        }
        function Drop_upload_file_data($Logged_user_enrollid)
        {
                $temp_tbl = $Logged_user_enrollid.'uploadtempdatatbl';

                $this->db->query("DROP TABLE ".$temp_tbl );
        }

        /***************************** Sandeep Work End ********************************/	
    public function get_loyaltyrule_details($Loyalty_names,$Company_id,$selected_seller)
    {   
            /* $this->db->from("igain_loyalty_master");
            $this->db->where(array('Loyalty_id' => $lp_id));
             */
            $this->db->from("igain_loyalty_master");
            $this->db->where_in('Loyalty_name',$Loyalty_names);
            $this->db->where(array('Company_id' => $Company_id,'Seller' => $selected_seller));
            $edit_sql = $this->db->get();
            // echo $this->db->last_query();
            if($edit_sql->num_rows() > 0)
            {
                    return $edit_sql->result_array();

            }
            else
            {
                    return false;
            }
    }
    /*---------------------------------Ravi 24-08-2018------------------------------------------*/
    public function update_reconsolation_voucher_status($Company_id,$Pos_Customerno,$Pos_Billno,$Pos_Billamt,$Status)
    {   
       if($Status=='Approved') {

             $PostData= array(
                            'Voucher_status' =>1
                        ); 
        }
       if($Status=='Cancelled'){

            $PostData= array(
                            'Voucher_status' =>2
                        );         
       }
        
        $this->db->where(array('Company_id' =>$Company_id,'Card_id2' =>$Pos_Customerno,'Purchase_amount' =>$Pos_Billamt,'Manual_billno' =>$Pos_Billno));
       
        $this->db->update('igain_transaction',$PostData);
        if($this->db->affected_rows() > 0)
        {
                return true;
        }
            
    }
    public function Get_customer_details_purchased_miles($Company_id,$Pos_Customerno,$Pos_Billno,$Pos_Billamt)
    {           

        $this->db->select("igain_enrollment_master.Enrollement_id,igain_enrollment_master.First_name,igain_enrollment_master.Last_name,igain_enrollment_master.Current_balance,igain_enrollment_master.Blocked_points,igain_enrollment_master.Card_id,igain_enrollment_master.Company_id,igain_cust_beneficiary_account.Beneficiary_membership_id,igain_cust_beneficiary_account.Beneficiary_company_id,igain_transaction.Trans_amount,igain_transaction.Redeem_points");
        $this->db->from('igain_transaction');
        $this->db->join("igain_enrollment_master", "igain_enrollment_master.Card_id =igain_transaction.Card_id");
        $this->db->join("igain_cust_beneficiary_account", "igain_cust_beneficiary_account.Membership_id =igain_enrollment_master.Card_id");
         $this->db->where(array('igain_transaction.Company_id' =>$Company_id,'igain_transaction.Card_id2' =>$Pos_Customerno,'igain_transaction.Purchase_amount' =>$Pos_Billamt,'igain_transaction.Manual_billno' =>$Pos_Billno,'igain_transaction.Voucher_status' =>0));
       $this->db->group_by('Trans_id');
        $query15 = $this->db->get();

        // echo"--Get Member---Details------".$this->db->last_query()."---<br><br>";
        if($query15->num_rows() > 0)
        {
            return $query15->row();
        }
       
        return false;
            
    }
    public function update_customer_reconsolation_balance($Enrollement_id,$Membership_id,$Company_id,$PostData)
    {
        $this->db->where(array('Enrollement_id' => $Enrollement_id,'Company_id' => $Company_id, 'Card_id' => $Membership_id));
        $this->db->update("igain_enrollment_master", $PostData);        
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


     /*---------------------------------Ravi 24-08-2018------------------------------------------*/

}
?>