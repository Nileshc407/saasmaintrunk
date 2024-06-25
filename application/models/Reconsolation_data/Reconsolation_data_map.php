<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reconsolation_data_map extends CI_Model {

    public function data_map_list($limit,$start,$Company_id,$Super_seller,$Logged_user_enrollid)
    {
            // $this->db->limit($limit,$start);
            $query = $this->db->from("igain_data_upload_map_tbl as dm");
            $query = $this->db->join("igain_register_beneficiary_company as em","dm.Column_Seller_id=em.Register_beneficiary_id");
            if($Super_seller==0)
            {
                $query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"dm.Column_Seller_id"=>$Logged_user_enrollid,"Data_map_for" => 3));
            }
            else
            {   
                $query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"Data_map_for" => 3));
            }			
            //$query = $this->db->where("dm.Column_Company_id",$Company_id);
            $query = $this->db->get();
			
			// echo"---data_map_list------".$this->db->last_query();
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
				// echo "---get_upload_file_data----".$this->db->last_query()."--<br>";
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

        public function upload_data_map_file($filepath,$filename,$Company_id,$Logged_user_enrollid,$publisher)
        {
			// echo"upload_data_map_file----<br>";
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
                        'Status' => array('type' => 'INT', 'constraint' => '11'),
                        'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200')
                        
                    );


                $this->dbforge->add_field($fields);

                $this->dbforge->add_key('upload_id', TRUE);
                       

                $this->dbforge->create_table($temp_tbl, TRUE);


                $this->db->from("igain_data_upload_map_tbl");
                $this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $publisher, "Data_map_for" => 3));

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
					$Column_date_format=$dmap["Column_date_format"];
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


               
                $Total_count = array();

				$TrDate="";
				$CardI=0;
				$BillNo=0;
				$TransactionAmt=0;
				$Remarks="";
				$Status="";

				
				//echo "--extension---".$extension." <br>";
				//echo "--filename---".$filename." <br>";
				
		if($extension == "csv") 
		{
			$filenameis = $filename;
			$handle = fopen($filepath,"r");

			$x=0; $y=0;				
			$Total_error_count=0;
			$Total_row=0;
			$Error_row=0;
			$Success_row=0;			
			$this->db->where(array('Company_id' =>$Company_id, 'File_name' =>$filename ));
			$this->db->delete('igain_flatfile_error_log');		
				
				
					for ($lines = 1; $csv_data = fgetcsv($handle,1000,",",'"'); $lines++)
					{	
						$access = 0;
						$errors_collection = array();
						$values_collection = array();
						$Error_transaction_date ="";
				
						// echo"--access---".$access."---lines---".$lines."--- index --".$x."-<br>";

						if ($lines <= $col_header_rows) continue;
						
						
						$TrDate2 = $csv_data[$col_date];
						// $TransactionDate2 = date("Y-m-d H:i:s",strtotime($TrDate2));

						// echo " ---TrDate2--".$TrDate2."--lines---".$lines."--<br>";
						
						$transDate122=str_replace('/','-',$TrDate2);
						$date_format = $Column_date_format;							
						$temp_trans_date=$transDate122;						
						
						
						if($date_format == "d-m-Y" || $date_format == "dd-mm-YY" ) //OK
						{								
							$date_format = "d-m-Y";
							$chunks = explode('-', $temp_trans_date);
							if($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date))
							{								
								if($temp_trans_date == "")
								{
									$temp_trans_date = "01-01-1970";
								}
								$date = DateTime::createFromFormat($date_format , $temp_trans_date);
								$trans_date= $date->format('Y-m-d');
								
								$year=$date->format("Y");
								$month_date=$date->format("m-d");									
								$Current_year=date("Y");
								$date_year_2digits = substr($year, 2, 2);
								$Current_year_2digits = substr($Current_year, 0, 2);									
								$new_year = $Current_year_2digits.$date_year_2digits; 
								$trans_date=$new_year.'-'.$month_date;
								 
							}
							else {
								
								$trans_date = '1970-01-01';
							}																
						}							
						if($date_format == "m/d/Y" || $date_format == "mm/dd/YY" ) //OK
						{
							$temp_trans_date=str_replace('-','/',$temp_trans_date);								
							$chunks = explode('/', $temp_trans_date);
							if($chunks[0] < 13 && $chunks[1] < 32 && !empty($temp_trans_date))
							{								
								if($temp_trans_date == "")
								{
									$temp_trans_date = "01/01/1970";
								}
								
								$date = DateTime::createFromFormat("m/d/Y" , $temp_trans_date);
								$trans_date= $date->format('Y-m-d');
								$year=$date->format("Y");
								$month_date=$date->format("m-d");									
								$Current_year=date("Y");
								$date_year_2digits = substr($year, 2, 2);
								$Current_year_2digits = substr($Current_year, 0, 2);									
								$new_year = $Current_year_2digits.$date_year_2digits; 
								$trans_date=$new_year.'-'.$month_date;								
							
							}
							else {
								
								$trans_date = '1970-01-01';
							}
						}
						if($date_format == "mm/dd/yyyy") //OK
						{
							$trans_date = date("Y-m-d", strtotime($temp_trans_date));								
						}
						if($date_format == "dd/mm/yyyy")  //OK
						{								
							$chunks = explode('-', $temp_trans_date);								
							if($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date))
							{
								$temp_trans_date = str_replace("-","/",$temp_trans_date);
								
								if($temp_trans_date == "")
								{
									$temp_trans_date = "01/01/1970";
								}
								$dateY = DateTime::createFromFormat('d/m/Y', $temp_trans_date);
								$trans_date=$dateY->format('Y-m-d');
							}
							else {
							
								$trans_date = '1970-01-01';
							}
						}						
						if($date_format == "mm-dd-yyyy") //OK but Date wil wrorng then cant insert into DB
						{
							
							$date12 = str_replace("-","/",$temp_trans_date);
							$trans_date = date("Y-m-d", strtotime($date12));
							
						}
						if($date_format == "dd-mm-yyyy") //OK but Date wil wrorng then cant insert into DB
						{
							
							$date23 = str_replace("/","-",$temp_trans_date);
							$trans_date = date("Y-m-d", strtotime($date23));
						}
						// echo " trans_date-----". $trans_date."<br>"; 
						
						
						
						if($TrDate2 == "" || $TrDate2 == null)
						{
							$errors_collection[$y] = "Transaction date is missing";
							$access = 1;
							
							$Error_transaction_date="";
						}
						else
						{
							if($trans_date == "" || $trans_date == "1970-01-01 00:00:00" || $trans_date == "1970-01-01" || $trans_date == "1970-01-01 01:00:00" ){
									
									 $errors_collection[$y] = "Transaction Date Format is Incorrect";
									$access = 1;
									$Error_transaction_date=$TrDate2;
								
								} else {
									
									$values_collection[$x]["Transaction_date"] = $trans_date;
								}
						}
						
						$y++;
						
						$MembershipID = $csv_data[$col_cust];
						// echo " ---MembershipID--".$MembershipID."----<br>";
						
					
						if($MembershipID == "" || $MembershipID == null)
						{
							$errors_collection[$y] = "Indetifier is missing";
							$access = 1;
							$Error_transaction_date=$TrDate2;
							
						}
						else
						{
							
							
							
							$Qresult = $this->db->query("Select Beneficiary_account_id from igain_cust_beneficiary_account where Company_id='".$Company_id."' AND Beneficiary_membership_id='".$MembershipID."' AND Beneficiary_company_id='".$publisher."' AND Beneficiary_status='1' ");		


							// echo "-----Select Beneficiary_account_id from igain_cust_beneficiary_account where Company_id='".$Company_id."' AND Beneficiary_membership_id='".$MembershipID."' AND Beneficiary_company_id='".$publisher."' AND Beneficiary_status='1'----<br>";
							
							
							if($Qresult->num_rows() > 0)
							{
								$values_collection[$x]["Card_id"] = $MembershipID;
							}
							else
							{
								$errors_collection[$y] = "Invalid Indetifier ID";
								$access = 1;
								$Error_transaction_date=$TrDate2;
							}
						}
						
						$y++;						
						$BillNo = $csv_data[$col_bill];
						
						
						if($BillNo == "" || $BillNo == null)
						{
							$errors_collection[$y] = "Bill No is missing";
							$access = 1;					
							$Error_transaction_date=$TrDate2;
						}
						else
						{	
							$sql_out1 = $this->db->query("select Trans_id,Voucher_status from  igain_transaction where ( Bill_no ='".$BillNo."' OR Manual_billno ='".$BillNo."' ) and Card_id2='".$MembershipID."'  and Company_id='".$Company_id."' and trans_type = 25 ");
							
							
							// echo"-------select Trans_id,Voucher_status from  igain_transaction where ( Bill_no ='".$BillNo."' OR Manual_billno ='".$BillNo."' ) and Card_id2='".$MembershipID."'  and Company_id='".$Company_id."' and trans_type = 25----<br> ";
							
							
							
							if($sql_out1->num_rows() > 0) {
								
								
								$sql_exist = $this->db->query("select Trans_id,Voucher_status from  igain_transaction where ( Bill_no ='".$BillNo."' OR Manual_billno ='".$BillNo."' ) and Card_id2='".$MembershipID."'  and Company_id='".$Company_id."' and Voucher_status = 45 and trans_type=25");
								
								
								// echo "-------select Trans_id,Voucher_status from  igain_transaction where ( Bill_no ='".$BillNo."' OR Manual_billno ='".$BillNo."' ) and Card_id2='".$MembershipID."'  and Company_id='".$Company_id."' and Voucher_status = 45 and trans_type=25-------<br>";
								
																
								if($sql_exist->num_rows() > 0) {
									
									$errors_collection[$y] = "Record already processed";
									$access = 1;
									$Error_transaction_date=$TrDate2;
									
								} else {
									
									$values_collection[$x]["Bill_no"] = $BillNo;									
								}
							
							} else {
								
									$errors_collection[$y] = "Invalid Bill Number";
									$access = 1;
									$Error_transaction_date=$TrDate2;
							}
						}						
						$y++;
						
						$TransactionAmt = $csv_data[$col_amt];
						// echo " ---TransactionAmt--".$TransactionAmt."----<br>";	
						
						if($TransactionAmt == "" || $TransactionAmt == null)
						{
							$errors_collection[$y] = "Purchased Miles is missing";
							$access = 1;
							$Error_transaction_date=$TrDate2;
						}
						else
						{
							$values_collection[$x]["Transaction_amount"] = $TransactionAmt;
						}
						
						$y++;
						
						$TransactionStatus = $csv_data[$col_Status];
						// echo " ---TransactionStatus--".$TransactionStatus."----<br>";
						
							
						if($TransactionStatus == "" || $TransactionStatus == null)
						{
							$errors_collection[$y] = "Transaction Status is missing";
							$access = 1;							
							$Error_transaction_date=$TrDate2;
							
						}
						else
						{
							$values_collection[$x]["Status"] = $TransactionStatus;
						}
						
						$y++;
						
						$Remarks = $csv_data[$col_remarks];
						$values_collection[$x]["Remarks"] = $Remarks;
						
						if($access == 1)
						{
						  
							$m = 0;
							$error_count = count($errors_collection); 
							foreach($errors_collection as $err)
							{							
								$transDate = $values_collection[$m]['Transaction_date']; 
								$Membership_ID = $values_collection[$m]["Card_id"];
								 $BillNo = $values_collection[$m]["Bill_no"];  
								 $TransactionAmount = $values_collection[$m]["Transaction_amount"]; 
								 $Status = $values_collection[$m]["Status"]; 
								 $Remarks = $values_collection[$m]["Remarks"];  

								$error_query = "Insert into igain_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in	,Error_row_no,Card_id,Transaction_date,Error_transaction_date,Bill_no,Transaction_amount,Status,Remarks) Values ('".$Company_id."','".$filename."','".$filepath."',0,'".$transDate."','".$err."','".$lines."','".$Membership_ID."','".$transDate."','".$Error_transaction_date."','".$BillNo."','".$TransactionAmount."','".$Status."','".$Remarks."')";
								
								
								$sql = $this->db->query($error_query);
								// echo " ---last_query--".$this->db->last_query()."----<br>";	
								$Total_error_count++;

							}
						}
						else if($access == 0)
						{
							// echo " Insert Temp Table <br>";
							$m = 0; 
							
								$transDate = $values_collection[$m]['Transaction_date']; //echo " - transDate --".$transDate."<br>";
								$Membership_ID = $values_collection[$m]["Card_id"]; //echo " Membership_ID--".$Membership_ID."<br>";
								$BillNo = $values_collection[$m]["Bill_no"];  //echo " BillNo--".$BillNo."<br>";
								$TransactionAmount = $values_collection[$m]["Transaction_amount"];  //echo " TransactionAmount--".$TransactionAmount."<br>"; 
								$Status = $values_collection[$m]["Status"];  //echo " Status--".$Status."<br>";
								$Remarks = $values_collection[$m]["Remarks"];  //echo " Remarks--".$Remarks."<br>";
								
								if($Status=='Pending'){									
									$Status=44;									
								} else if($Status=='Approved'){									
									$Status=45;									
								} else if($Status=='Cancelled'){									
									$Status=46;									
								} else {									
									$Status=0;									
								}

								$Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Status,Remarks) Values ('".$transDate."','".$Membership_ID."','".$BillNo."','".$TransactionAmount."','".$Status."','".$Remarks."')";
								
								
								
								
								// echo "--Insert_query---".$Insert_query." <br>";
								
								
								$sql = $this->db->query($Insert_query);

                                  $Success_row++;
						}

                        $Total_row++;
						
																
                    }					
					// $error_count = count($errors_collection);

					$Error_row=$Total_row-$Success_row;                    
                    
                }
                else if( $extension == "xlsx" ||  $extension == "xls") 
                {  	
				
                    $Total_error_count=0;
                    $Total_row=0;
                    $Error_row=0;
                    $Success_row=0;
                    $lines=0;

                    $this->db->where(array('Company_id' =>$Company_id, 'File_name' =>$filename ));
                    $this->db->delete('igain_flatfile_error_log'); 
					
					
					require_once(APPPATH.'libraries/excel_reader2.php');

					$data = new Spreadsheet_Excel_Reader();
					$data->read($filepath);
					
					
						$MembershipId11 = $col_cust + 1;
						$transDate11 = $col_date + 1;
						$PaymentType11 = $col_payment + 1;					
						$product_code11 = $col_Column_Item_Code + 1;
						$trans_amount11 = $col_amt + 1;					
						$quantity11 = $col_Quantity + 1;					
						$BillNumber11 = $col_bill + 1;
						$Remarks11 = $col_remarks + 1;
						$Status11 = $col_Status + 1;
					
						// echo "----count-cells----".count($data->sheets[0]["cells"])."---<br><br>";
					
						for($x = 2; $x <= count($data->sheets[0]["cells"]); $x++)
						{		
					
							$transDate121 = $data->sheets[0]["cells"][$x][$transDate11];
							$MembershipId12 = $data->sheets[0]["cells"][$x][$MembershipId11];
							$trans_amount12 = $data->sheets[0]["cells"][$x][$trans_amount11];							
							$BillNumber12 = $data->sheets[0]["cells"][$x][$BillNumber11];
							$Remarks12 = $data->sheets[0]["cells"][$x][$Remarks11];
							$Status12 = $data->sheets[0]["cells"][$x][$Status11];	

							 // echo "----Status12-----".$Status12."---<br><br>";
							 // echo "----transDate121-----".$transDate121."---<br><br>";
							
							$transDate122=str_replace('/','-',$transDate121);	

							// echo "----transDate122-----".$transDate122."---<br><br>";

							
							$date_format = $Column_date_format;							
							$temp_trans_date=$transDate122;
							
							
							// echo "----date_format-----". $date_format."--<br><br>";
							// echo "----temp_trans_date-----".$temp_trans_date."---<br><br>";
							
							
							if($date_format == "d-m-Y" || $date_format == "dd-mm-YY" ) //OK
							{								
								$date_format = "d-m-Y";
								$chunks = explode('-', $temp_trans_date);
								
								// echo " chunks-----". $chunks[0]."---".$chunks[1]."---<br>";
								if($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date))
								{								
									if($temp_trans_date == "")
									{
										$temp_trans_date = "01-01-1970";
									}
									// echo " temp_trans_date-----". $temp_trans_date."<br>";									
									$date = DateTime::createFromFormat($date_format , $temp_trans_date);
									$trans_date= $date->format('Y-m-d');
									
									$year=$date->format("Y");
									$month_date=$date->format("m-d");									
									$Current_year=date("Y");
									$date_year_2digits = substr($year, 2, 2);
									$Current_year_2digits = substr($Current_year, 0, 2);									
									$new_year = $Current_year_2digits.$date_year_2digits; 
									$trans_date=$new_year.'-'.$month_date;
									
								}
								else {
									
									$trans_date = '1970-01-01';
								}																
							}							
							if($date_format == "m/d/Y" || $date_format == "mm/dd/YY" ) //OK
							{
								$temp_trans_date=str_replace('-','/',$temp_trans_date);								
								$chunks = explode('/', $temp_trans_date);
								// echo "---chunk-----". $chunks[0]."---".$chunks[1]."---<br>";
								if(($chunks[0] < 13 && $chunks[1] < 32) && !empty($temp_trans_date) )
								{		

									// echo " temp_trans_date----1111-". $temp_trans_date."<br>";
									if($temp_trans_date == "")
									{
										$temp_trans_date = "01/01/1970";
									}
									
									$date = DateTime::createFromFormat("m/d/Y" , $temp_trans_date);
									$trans_date= $date->format('Y-m-d');
									$year=$date->format("Y");
									$month_date=$date->format("m-d");									
									$Current_year=date("Y");
									$date_year_2digits = substr($year, 2, 2);
									$Current_year_2digits = substr($Current_year, 0, 2);									
									$new_year = $Current_year_2digits.$date_year_2digits; 
									$trans_date=$new_year.'-'.$month_date;								
								
								}
								else {
									
									$trans_date = '1970-01-01';									
									// echo "---trans_date-----". $trans_date."---<br>";
								}
							}
							if($date_format == "mm/dd/yyyy") //OK
							{
								$trans_date = date("Y-m-d", strtotime($temp_trans_date));								
							}
							if($date_format == "dd/mm/yyyy")  //OK
							{								
								$chunks = explode('-', $temp_trans_date);								
								// echo " chunks-----". $chunks[0]."---".$chunks[1]."---<br>";
								if($chunks[0] < 32 && $chunks[1] < 13  && !empty($temp_trans_date))
								{
									$temp_trans_date = str_replace("-","/",$temp_trans_date);									
									if($temp_trans_date == "")
									{
										$temp_trans_date = "01/01/1970";
									}
									// echo " temp_trans_date-----". $temp_trans_date."<br>";
									$dateY = DateTime::createFromFormat('d/m/Y', $temp_trans_date);
									$trans_date=$dateY->format('Y-m-d');
								}
								else {
								
									$trans_date = '1970-01-01';
								}
							}						
							if($date_format == "mm-dd-yyyy") //OK but Date wil wrorng then cant insert into DB
							{
								
								$date12 = str_replace("-","/",$temp_trans_date);
								$trans_date = date("Y-m-d", strtotime($date12));
								
							}
							if($date_format == "dd-mm-yyyy") //OK but Date wil wrorng then cant insert into DB
							{
								// echo " temp_trans_date-----". $temp_trans_date."<br>";
								
								$chunks = explode('-', $temp_trans_date);								
								// echo " chunks-----". $chunks[0]."---".$chunks[1]."--".$chunks[2]."---<br>";
								if($chunks[0] < 32 && $chunks[1] < 13  && !empty($temp_trans_date))
								{
									// $temp_trans_date = str_replace("-","/",$temp_trans_date);									
								
									// echo " temp_trans_date-----". $temp_trans_date."<br>";
									
									$trans_date =$chunks[2]."-".$chunks[1]."-".$chunks[0];
									
								}
								else {
								
									$trans_date = '1970-01-01';
								}
								
								
							}
							// echo " trans_date-----". $trans_date."----<br><br>";
							
							
								/* 
								echo " Transaction Date transDate12-----". $transDate12."<br>";
								echo " Item Code-----". $product_code12."<br>";
								echo " Membership ID----- ". $MembershipId12."<br>";
								echo " Transaction Amount---- ". $trans_amount12."<br>";
								echo " Transaction Channel---- ". $trans_channel_code12."<br>";
								echo " Trans type----- ". $PaymentType."<br>";  
								echo " Quantity---- ". $quantity12."<br>";  
								echo " Bill No.---- ". $BillNumber12."<br>";  
								echo " Remarks--- ". $Remarks12."<br>";  
								echo " Status--- ". $Status12."<br>";  
								echo " <br><br>******************<br><br>";  */ 
							
							
							$access = 0;
							$Error_transaction_date ="";
							
							if($MembershipId12 == "")
							{
								$get_error[] = "Indetifier ID is missing";
								$get_error_row[] =  $x;
								$lines =  $x;
								$access = 1;
								
								$Error_transaction_date=$transDate121;
							} 
							else{
								
								
								
										$Qresult = $this->db->query("Select Beneficiary_account_id from igain_cust_beneficiary_account where Company_id='".$Company_id."' AND Beneficiary_membership_id='".$MembershipId12."' AND Beneficiary_company_id='".$publisher."' AND Beneficiary_status='1' ");	

										if($Qresult->num_rows() > 0)
										{
											// $values_collection[$x]["Card_id"] = $MembershipId12;
										}
										else
										{
											$get_error[]  = "Invalid Indetifier ID";
											$get_error_row[] =  $x;
											$lines =  $x;
											$access = 1;
											$Error_transaction_date=$transDate121;
										}
							}
							if($Status12 == "")
							{
								$get_error[] = "Status is missing";
								$get_error_row[] =  $x;
								$lines =  $x;
								$access = 1;
								$Error_transaction_date=$transDate121;
							}							
							
						if($BillNumber12 == "" || $BillNumber12 == null)
						{
							$get_error[] = "Bill Number is missing";
							$get_error_row[] =  $x;
							$lines =  $x;
							$access = 1;

							$Error_transaction_date=$transDate121;							
							
						}
						else
						{	
							$sql_out1 = $this->db->query("select Trans_id,Voucher_status from  igain_transaction where ( Bill_no ='".$BillNumber12."' OR Manual_billno ='".$BillNumber12."' ) and Card_id2='".$MembershipId12."'  and Company_id='".$Company_id."' and trans_type = 25 ");
							
							
							
							if($sql_out1->num_rows() > 0) {
								
								
								$sql_exist1 = $this->db->query("select Trans_id,Voucher_status from  igain_transaction where ( Bill_no ='".$BillNumber12."' OR Manual_billno ='".$BillNumber12."' ) and Card_id2='".$MembershipId12."'  and Company_id='".$Company_id."' and Voucher_status = 45 and trans_type=25");
								
								
								
								if($sql_exist1->num_rows() > 0) {
									
									$get_error[] = "Record already processed";
									$get_error_row[] =  $x;
									$lines =  $x;
									$access = 1;
									
									$Error_transaction_date=$transDate121;
									
								} else {
									
									$BillNumber12 = $BillNumber12;									
								}
							
							} else {
								
									$get_error[] = "Invalid Bill Number";
									$get_error_row[] =  $x;
									$lines =  $x;
									$access = 1;
									
									$Error_transaction_date=$transDate121;
							}
						}

							if($trans_amount12 == "")
							{
								$get_error[] = "Purchased Miles is missing";
								$get_error_row[] =  $x;
								$lines =  $x;
								$access = 1;
								$Error_transaction_date=$transDate121;
							}							
							if($transDate121 == "" || $transDate121 == null)
							{
								$get_error[] = "Transaction Date is missing";
								$get_error_row[] = $x;
								$lines =  $x;
								$access = 1;
								$Error_transaction_date="";
							}
							else
							{
								if($trans_date == "" || $trans_date == "1970-01-01 00:00:00" || $trans_date == "1970-01-01" || $trans_date == "1970-01-01 01:00:00" ){
										
										$get_error[] = "Transaction Date Format is Incorrect";
										$get_error_row[] = $x;
										$lines =  $x;
										$access = 1;
										
										$Error_transaction_date=$transDate121;
									
									} else {
										
										$trans_date = $trans_date;
									}
							}
							
							
							
							
							if($access == 1 ) 
							{

								$error_count = count($get_error); 
								foreach($get_error as $err)
								{									
								   
									// echo " ------Status12------".$Status12."-----------<br><br>";
									
									/* echo " ------access------".$access."-----------<br><br><br>";
									
									echo " ------Company_id------".$Company_id."-----------<br><br>";
									echo " ------filename------".$filename."-----------<br><br>";
									echo " ------filepath------".$filepath."-----------<br><br>";
									echo " ------trans_date------".$trans_date."-----------<br><br>";
									echo " ------err------".$err."-----------<br><br>";
									echo " ------lines------".$lines."-----------<br><br>";
									echo " ------MembershipId12------".$MembershipId12."-----------<br><br>";
									echo " ------BillNumber12------".$BillNumber12."-----------<br><br>";
									echo " ------trans_amount12------".$trans_amount12."-----------<br><br>";
									echo " ------Status12------".$Status12."-----------<br><br>";
									echo " ------Remarks12------".$Remarks12."-----------<br><br>"; */ 
								   
								  
								  $error_query = "Insert into igain_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in	,Error_row_no,Card_id,Transaction_date,Error_transaction_date,Bill_no,Transaction_amount,Status,Remarks) Values ('".$Company_id."','".$filename."','".$filepath."',0,'".$trans_date."','".$err."','".$lines."','".$MembershipId12."','".$trans_date."','".$Error_transaction_date."','".$BillNumber12."','".$trans_amount12."','".$Status12."','".$Remarks12."')";
								
								
									$sql = $this->db->query($error_query);
									
									// echo "--Insert_error_query---1111---".$this->db->last_query()." ---<br><br>"; 
									
									$Total_error_count++;	

									
								   
								}
                            
							} else if($access == 0 ) {
								
									/* echo " ------access------".$access."-----------<br><br><br>";									
									echo " ------trans_date------".$trans_date."-----------<br><br>";
									echo " ------MembershipId12------".$MembershipId12."-----------<br><br>";
									echo " ------BillNumber12------".$BillNumber12."-----------<br><br>";
									echo " ------trans_amount12------".$trans_amount12."-----------<br><br>";
									echo " ------Remarks12------".$Remarks12."-----------<br><br>";
									echo " ------Status12------".$Status12."-----------<br><br>";  */
									
									
									if($Status12=='Pending'){									
										$Status12=44;									
									} else if($Status12=='Approved'){									
										$Status12=45;									
									} else if($Status12=='Cancelled'){									
										$Status12=46;									
									} else {									
										$Status12=0;									
									}
								
									$Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Status,Remarks) Values ('".$trans_date."','".$MembershipId12."','".$BillNumber12."','".$trans_amount12."','".$Status12."','".$Remarks12."')";
									
									$sql1 = $this->db->query($Insert_query);									
									// echo "----query---".$this->db->last_query()."---<br>";
									
								$Success_row++;
                            
                        }
                        $Total_row++;
						unset($get_error);
					}
					
					
					$Error_row=$Total_row-$Success_row;					
					/* echo " ------Total_row------".$Total_row."-----------<br><br><br>";
					echo " ------Success_row------".$Success_row."-----------<br><br><br>";					
					echo " ------Error_row------".$Error_row."-----------<br><br><br>";  */

				}
				else
				{
					return false;
				}
				
				if($Total_error_count > 0)
				{
					$coln_array = array(
							'Company_id' => $Company_id,
							'File_name' => $filename,
							'File_path' =>$filepath,
							'Upload_status' =>'1',
							'Error_status'=> $Total_error_count,
							'Date' => $Today_Date,
							'Total_row' => $Total_row,
							'Success_row' => $Success_row,
							'Error_row' => $Error_row
					);

					 $Upload_status = 0;

					$this->db->insert('igain_file_upload_status',$coln_array);

					$mv_inserted_id = $this->db->insert_id();

					$Upload_status = $mv_inserted_id;

					$this->db->where(array('File_name'=>$filename,'Company_id'=>$Company_id));
					$this->db->update('igain_flatfile_error_log', array('Status_id'=>$Upload_status));
					
					
				
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
                /* if($Data_not_found_flag==1)
                {
                    $Upload_status = 3;
                } */
                // die;
                  // echo"---Upload_status----".$Upload_status."---<br>";

                
               
                $return_array= array(
                    'Total_error_count' =>$Total_error_count ,
                    'Total_row' =>$Total_row ,
                    'Error_row' =>$Error_row ,
                    'Success_row' =>$Success_row ,
                    'Upload_status' =>$Upload_status
                 );
                    
                return $return_array;

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
                $this->db->select("*, GROUP_CONCAT(Error_in SEPARATOR '; ') AS  Error_in");
                // $this->db->select("File_name,Upload_status,Error_status");
                $this->db->from("igain_file_upload_status");
                $this->db->join("igain_flatfile_error_log", "igain_flatfile_error_log.Status_id =igain_file_upload_status.Status_id");
                $this->db->where(array('igain_file_upload_status.Company_id' => $Company_id, 'igain_file_upload_status.Status_id'=> $file_status));
                $this->db->group_by('Error_row_no');
                $queryOPT = $this->db->get();

                // echo"---SQL---".$this->db->last_query();
                
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
    public function update_reconsolation_voucher_status($Logged_user_id,$Todays_date,$Currency,$Company_id,$Pos_Customerno,$Pos_Billno,$Pos_Billamt,$Status)
    {   
       if($Status == 45 ) { //'Approved'

             $PostData = array(
                            'Voucher_status' =>45,
                            'Update_user_id' =>$Logged_user_id,
                            'Update_date' =>$Todays_date,
                            'Remarks' =>'Purchsed '.$Currency.' Approved'
                        ); 
        }
       if($Status == 46 ){ //'Cancelled'

            $PostData= array(
                            'Voucher_status' =>46,
                            'Update_user_id' =>$Logged_user_id,
                            'Update_date' =>$Todays_date,
                            'Remarks' =>'Purchsed '.$Currency.' Cancelled'
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

        $this->db->select("igain_enrollment_master.Enrollement_id,igain_enrollment_master.First_name,igain_enrollment_master.Last_name,igain_enrollment_master.Current_balance,igain_enrollment_master.Blocked_points,igain_enrollment_master.Card_id,igain_enrollment_master.Company_id,igain_cust_beneficiary_account.Beneficiary_membership_id,igain_cust_beneficiary_account.Beneficiary_company_id,igain_transaction.Trans_amount,igain_transaction.Redeem_points,igain_transaction.Trans_date");
        $this->db->from('igain_transaction');
        $this->db->join("igain_enrollment_master", "igain_enrollment_master.Card_id =igain_transaction.Card_id");
        $this->db->join("igain_cust_beneficiary_account", "igain_cust_beneficiary_account.Membership_id =igain_enrollment_master.Card_id");
         $this->db->where(array('igain_transaction.Company_id' =>$Company_id,'igain_transaction.Card_id2' =>$Pos_Customerno,'igain_transaction.Purchase_amount' =>$Pos_Billamt,'igain_transaction.Manual_billno' =>$Pos_Billno,'igain_transaction.Voucher_status' =>44));
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
		
		 // echo"--update_customer_reconsolation_balance------".$this->db->last_query()."---<br><br>";
		 
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_publisher($Company_id)
    {   
        $this->db->select("*");
        $this->db->from("igain_register_beneficiary_company");
        $this->db->join("igain_beneficiary_company", "igain_register_beneficiary_company.Register_beneficiary_id =igain_beneficiary_company.Register_beneficiary_id");    
        $this->db->where(array('igain_beneficiary_company.Company_id' => $Company_id,'igain_register_beneficiary_company.Activate_flag' =>1));
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
    public function get_publisher_details($publisher)
    {   
        $this->db->select("*");
        $this->db->from("igain_register_beneficiary_company");
       
        $this->db->where(array('Register_beneficiary_id' => $publisher,'Activate_flag' =>1));
        $edit_sql = $this->db->get();
        //echo $this->db->last_query();
        if($edit_sql->num_rows() > 0)
        {
            return $edit_sql->row();
        }
        else
        {
            return false;
        }
    }
	public function get_publisher_purchased_transaction($Company_id,$publisher)
    {   
	
		
			$temp_tbl = $publisher.'purchased_miles';
			$this->load->helper('date');
			$this->load->dbforge();
		   if( $this->db->table_exists($temp_tbl) == TRUE ){
					$this->dbforge->drop_table($temp_tbl);
			}             
			$fields = array(
					'Purchased_id' => array('type' => 'INT','constraint' => '11','auto_increment' => TRUE),
					'Transaction_id' => array('type' => 'INT','constraint' => '11'),
					'Transaction_date' => array('type' => 'datetime'),
					'Publisher_id' => array('type' => 'INT','constraint' => '11'),
					'Publisher_name' => array('type' => 'VARCHAR', 'constraint' => '50'),
					'Customerno' => array('type' => 'VARCHAR', 'constraint' => '50'),
					'Customer_name' => array('type' => 'VARCHAR', 'constraint' => '50'),
					'Purchased_miles' => array('type' => 'DECIMAL', 'constraint' => '25,2'),
					'Pos_Billno' => array('type' => 'VARCHAR', 'constraint' => '50'),
					'Status' => array('type' => 'VARCHAR', 'constraint' => '100'),
					'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200')                        
				);


			$this->dbforge->add_field($fields);
			$this->dbforge->add_key('Purchased_id', TRUE);
			$this->dbforge->create_table($temp_tbl, TRUE);
		
		
		
		
        $this->db->select("*");
        $this->db->from("igain_transaction AS T");       
        $this->db->where(array('T.Company_id' => $Company_id,'T.To_Beneficiary_company_id' => $publisher,'T.Trans_type' =>25,'T.Send_miles_flag' =>0));
		$this->db->join("igain_codedecode_master", "igain_codedecode_master.Code_decode_id =T.Voucher_status");   
		$this->db->join("igain_register_beneficiary_company", "igain_register_beneficiary_company.Register_beneficiary_id =T.To_Beneficiary_company_id");   
        $Miles_sql = $this->db->get();
			// echo"---get_publisher_purchased_transaction-----".$this->db->last_query();
        if($Miles_sql->num_rows() > 0)
		{
			foreach($Miles_sql->result() as $row)
			{
				
							
				 $tbl_data = array(

					'Transaction_id' =>$row->Trans_id,
					'Transaction_date' => $row->Trans_date,
					'Publisher_id' => $row->To_Beneficiary_company_id,
					'Publisher_name' => $row->To_Beneficiary_company_name,
					'Customerno' => $row->Card_id2,
					'Customer_name' => $row->To_Beneficiary_cust_name,
					'Purchased_miles' => $row->Trans_amount,
					'Pos_Billno' => $row->Bill_no,
					'Status' => $row->Code_decode,
					'Remarks' => $row->Remarks    
				);
				$this->db->insert($temp_tbl,$tbl_data);
				
				$data[] = $row;
			}
			return $data;
		}
		else
		{
			
			return false;
		}
			
    }
	public function get_publisher_transaction($Company_id,$publisher)
    {   
	
		$temp_tbl = $publisher.'purchased_miles';
		
		$this->db->select("*");
        $this->db->from($temp_tbl);     
        $Miles_sql = $this->db->get();
        // echo"---get_publisher_transaction-----".$this->db->last_query();
        if($Miles_sql->num_rows() > 0)
		{
			foreach($Miles_sql->result() as $row)
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
	public function update_publisher_transaction($Company_id,$Transaction_id,$Publisher_id,$Customerno,$Purchased_miles)
    {   
	
		$this->db->where(array('Company_id' => $Company_id,'Trans_id' => $Transaction_id,'To_Beneficiary_company_id' => $Publisher_id,'Card_id2' => $Customerno,'Trans_amount' => $Purchased_miles));
        $this->db->update("igain_transaction", array('Send_miles_flag'=>1));    
		 // echo"---update_publisher_transaction-----".$this->db->last_query();
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
			
    }
	public function drop_publisher_temp_table($Publisher_id)
    {   
	
		$temp_tbl = $Publisher_id.'purchased_miles';
		$this->load->helper('date');
		$this->load->dbforge();
		if( $this->db->table_exists($temp_tbl) == TRUE ){
			
				$this->dbforge->drop_table($temp_tbl);
		}
		// echo"---drop_publisher_temp_table-----".$this->db->last_query();
			
    }
	public function Check_data_mapping($Publisher_id,$Company_id)
    {   
	
		
		$this->db->from("igain_data_upload_map_tbl");
		$this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $Publisher_id, "Data_map_for" => 3));

		$data_map_query = $this->db->get();

		return $data_map_query->num_rows();
			
    }

     /*---------------------------------Ravi 24-08-2018------------------------------------------*/

}
?>