<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Enrollement_data_map extends CI_Model 
{

		
	 public function data_map_count($Company_id)
	{
		/* $query = $this->db->where("Column_Company_id",$Company_id);
		return $this->db->count_all("igain_data_upload_map_tbl"); */
		$query = $this->db->where(array("Column_Company_id" => $Company_id,"Data_map_for" => 1));
		$query = $this->db->from("igain_data_upload_map_tbl");
		$query = $this->db->select("*");
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function data_map_list($Company_id,$Super_seller,$Logged_user_enrollid,$Sub_seller_Enrollement_id)
	{
		//$this->db->limit($limit,$start);
		$query = $this->db->from("igain_data_upload_map_tbl as dm");
		$query = $this->db->join("igain_enrollment_master as em","dm.Column_outlet_id=em.Enrollement_id");
		if($Super_seller==0)
		{
			if($Sub_seller_Enrollement_id > 0) //outlet
			{
				$query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"dm.Column_outlet_id"=>$Logged_user_enrollid,"Data_map_for" => 1));
			}
			else //brand
			{
				$query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"dm.Column_Seller_id"=>$Logged_user_enrollid,"Data_map_for" => 1));
			}
			
		}
		else
		{
			$query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"Data_map_for" => 1));
		}
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
	function insert_data_map($post_data)
	{		
		
		$this->db->insert('igain_data_upload_map_tbl', $post_data);
		// echo $this->db->last_query();
		// die;
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
	}
	public function check_exist_data_map_seller($Seller_id,$Company_id)
	{
		
		$query = $this->db->where(array("Column_Company_id" => $Company_id,"Column_outlet_id" => $Seller_id,"Data_map_for" => 1));
		$query = $this->db->from("igain_data_upload_map_tbl");
		$query = $this->db->select("*");
		$query = $this->db->get();//echo $this->db->last_query();
		return $query->num_rows();
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
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{
			return true;
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
			$this->db->where(array("Column_Company_id" => $Company_id, "Column_outlet_id" => $Logged_user_enrollid));
		}

		$data_map_query12 = $this->db->get();
		
		// echo $this->db->last_query();
		
		return $data_map_query12->num_rows();
	}
	 public function get_country($Company_id)
	 {
		$query = "Select Country from  igain_company_master where Company_id='".$Company_id."' ";
				
			$sql = $this->db->query($query);
			foreach ($sql->result() as $row)
			{
				$Country_id = $row->Country;
			}
		return 	$Country_id;	
	 }
	public function upload_data_map_file($filepath,$filename,$Company_id,$outlet_id)
	{
		// echo 'insert';die;
		$temp_tbl = $outlet_id.'uploadtempdatatbl';
		$this->load->helper('date');
		$this->load->dbforge();
		 if( $this->db->table_exists($temp_tbl) == TRUE ){
		$this->dbforge->drop_table($temp_tbl);
		}
		// error_reporting(0);
		$fields = array(
							'upload_id' => array('type' => 'INT','constraint' => '11','auto_increment' => TRUE),
							'First_Name' => array('type' => 'VARCHAR', 'constraint' => '100','null' => TRUE),
							'Last_Name' => array('type' => 'VARCHAR', 'constraint' => '100','null' => TRUE),
							'Address' => array('type' => 'VARCHAR', 'constraint' => '200','null' => TRUE),
							'Phone_No' => array('type' => 'BIGINT', 'constraint' => '15'),                        
							'User_Email_ID' => array('type' => 'VARCHAR', 'constraint' => '100','null' => TRUE),
							'Membership_ID' => array('type' => 'VARCHAR', 'constraint' => '100','null' => TRUE),
							'Date' => array('type' => 'datetime'),
                        );
          
                         
		$this->dbforge->add_field($fields);
		
		$this->dbforge->add_key('upload_id', TRUE);
			// gives PRIMARY KEY (upload_id)
			
		$this->dbforge->create_table($temp_tbl, TRUE);
		
		// echo"Dial_code----".$Dial_code."<br>";
		$Country_id=$this->get_country($Company_id);
		$this->db->select('Dial_code');
		$this->db->from('igain_currency_master');
		$this->db->where('Country_id',$Country_id);		
		$code_data = $this->db->get();		
		foreach($code_data->result() as $rowP)
		{
			$Dial_code = $rowP->Dial_code;
		}

		//$Dial_code = $this->db->get()->row()->Dial_code;
		// $Phone_no = $Dial_code."".$Phone_no;
		
		// echo"Dial_code----".$Dial_code."<br>";
		// die;
		
		
		$this->db->from("igain_data_upload_map_tbl");
		$this->db->where(array("Column_Company_id" => $Company_id, "Column_outlet_id" => $outlet_id,"Data_map_for" => 1));
		
		$data_map_query = $this->db->get();
		// echo $this->db->last_query();
		$data_map = $data_map_query->result_array();	
		
		// if($data_map) {			
			
			foreach($data_map as $dmap)
			{
				$col_date = $dmap["Column_Date"];
				$col_first_name=$dmap["Column_First_Name"];
				$col_last_name=$dmap["Column_Last_Name"];
				$col_address=$dmap["Column_Address"];
				$col_phone_no=$dmap["Column_Phone_No"];
				$col_header_rows=$dmap["Column_header_rows"];
				$col_user_email_id=$dmap["Column_User_Email_ID"];
				$col_membershipid=$dmap["Column_Membership_ID"];			
			}
			
		/* } else {
			
			return false ;
		} */
		
		
			echo "col_date---".$col_date."--<br>";
            echo "col_first_name---".$col_first_name."--<br>";
            echo "col_last_name---".$col_last_name."--<br>";
            echo "col_address---".$col_address."--<br>";
            echo "col_phone_no---".$col_phone_no."--<br>";
            echo "col_header_rows---".$col_header_rows."--<br>";
            echo "col_user_email_id---".$col_user_email_id."--<br>"; 
            echo "col_membershipid---".$col_membershipid."--<br>";  
			
			
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
		//$select_date = date("Y-m-d",strtotime($this->input->post("file_date")));
		$from_date = date("Y-m-d H:i:s",strtotime($this->input->post("from_date")));
		$till_date = date("Y-m-d H:i:s",strtotime($this->input->post("till_date")));
		
		$Today_Date = date("Y-m-d");
		
		$get_error = array();
		$get_trans_date = array();
		$get_error_row = array();
		$Data_not_found_flag=0;
		 echo "extension---".$extension."--<br>";
			if($extension == "csv") 
			{
				//get the csv file
				//$filepath = realpath($_FILES["csv"]["tmp_name"]);
				$filenameis = $filename;
				$handle = fopen($filepath,"r");
				for ($lines = 1; $csv_data = fgetcsv($handle,1000,",",'"'); $lines++)
				{	
					// echo "col_date---".$col_date."--<br>";
					$access = 0;	
					if ($lines <= $col_header_rows) continue;
					$TrDate2 = $csv_data[$col_date];
					$TransactionDate2 = date("Y-m-d H:i:s",strtotime($TrDate2));
					
					 // echo "TrDate2---".$TrDate2."--<br>";print_r($csv_data);continue;
					// echo "TransactionDate2---".$TransactionDate2."--<br>";
					// echo "from_date---".$from_date."--<br>";
					// echo "till_date---".$till_date."--<br>"; 
					// echo "csv_data---".$csv_data[0]."--<br>"; 
					// die;
					// if ($csv_data[0]  && ($TransactionDate2 >= $from_date) && ($TransactionDate2 <= $till_date)) 
					if ($csv_data[0]) 
					{
							echo "lines---".$lines."--<br>";
							$TrDate = $csv_data[$col_date];							
							// echo "<br>TrDate ".$TrDate;
							if($TrDate == "")
							{
								$get_error[] = "Enrollemet Date is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								$access = 1;
								
							}							
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$CardID = addslashes($csv_data[$col_membershipid]);
							//echo "*****************CardID ".$CardID;
							if($CardID == "")
							{
								$get_error[] = "Membership ID is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								$access = 1;								
							}														
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$colfirstname = addslashes($csv_data[$col_first_name]);
							//echo "*****************CardID ".$CardID;
							if($colfirstname == "")
							{
								$get_error[] = "First Name is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								
							}							
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$collastname = addslashes($csv_data[$col_last_name]);
							//echo "*****************CardID ".$CardID;
							if($collastname == "")
							{
								$get_error[] = "Last Name is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;								
							}
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$coladdress = addslashes($csv_data[$col_address]);
							//echo "*****************CardID ".$CardID;
							if($coladdress == "")
							{
								$get_error[] = "Address is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
							}
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$colphoneno = addslashes($csv_data[$col_phone_no]);
							// echo "*****************colphoneno ".$colphoneno;
							if($colphoneno == "")
							{
								$get_error[] = "Phone Number is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								$access = 1;								
							}
							$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
							$coluseremailid = addslashes($csv_data[$col_user_email_id]);
							//echo "*****************CardID ".$CardID;
							if($coluseremailid == "")
							{
								$get_error[] = "User Email ID is missing";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								$access = 1;								
							}							
							$Qresult = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND Card_id='".$CardID."' AND User_id='1'  ");	
							if($Qresult->num_rows() > 0)
							{
								$get_error[] = "Membership ID Already Exist";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								$access = 1;								
							}
							$Phone_no = $Dial_code.''.$colphoneno;
							$Qresult_colphoneno = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND Phone_no='".App_string_encrypt($Phone_no)."' AND User_id='1'  ");	
							if($Qresult_colphoneno->num_rows() > 0)
							{
								$get_error[] = "Phone No Already Exist";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								// $access = 1;
								
							}
							$Qresult_coluseremailid = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND User_email_id='".App_string_encrypt($coluseremailid)."' AND User_id='1'  ");	
							if($Qresult_coluseremailid->num_rows() > 0)
							{
								$get_error[] = "User Email ID Already Exist";
								$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
								$get_error_row[] =  $lines ;
								$access = 1;								
							}							
							
							/********************************************************/
								/*echo "access---".$access."--<br>";
								echo "select_date---".$select_date."--<br>";
								echo "TransactionDate---".$TransactionDate."--<br>";								
								print_r($get_error);
								echo "access---".$access."--<br>";
								*/
								// echo "****access---".$access."--<br>";
							if($access == 0 )
							{
									//echo "accessggggg---".$access."--<br>";
									
								// $sql_out1 = $this->db->query("select Trans_id from  igain_transaction where Card_id='".$CardID."'  and Company_id='".$Company_id."'");
								//echo "<br>select Trans_id from  igain_transaction where Manual_billno ='".$BillNo."' and Card_id='".$CardID."'  and Company_id='".$Company_id."'";
								
								$sql_out2 = $this->db->query("select upload_id from  ".$temp_tbl." where User_Email_ID ='".$coluseremailid."'  ");
								//	echo "<br>select upload_id from  ".$temp_tbl." where Pos_Billno ='".$BillNo."' and Pos_Customerno='".$CardID."' ";
										 
								// if(($sql_out2->num_rows() == 0) && ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date))// && $sql_out2->num_rows() == 0
								// {
									//echo "<br>here";
									$tbl_data = array(
									
										'First_Name' => $colfirstname,
										'Last_Name' => $collastname,
										'Address' => $coladdress,
										'Phone_No' => $Phone_no,
										'User_Email_ID' => $coluseremailid,
										'Membership_ID' => $CardID,
										'Date' => $TransactionDate
										
									);								
									$this->db->insert($temp_tbl, $tbl_data);								
									// echo "----insert----temp_tbl-----".$this->db->last_query()."--<br>";
							}
						
					}
					else
					{
						$Data_not_found_flag=1;
						$Upload_status = 3;
					}
					
					
					//echo "<br><br><br>";
				}
				//die; 
				
			}
			else if( $extension == "xlsx" ||  $extension == "xls") 
			{
				
				 $this->load->library('excel');

					//read file from path
					$objPHPExcel = PHPExcel_IOFactory::load($filepath);
					 
					//get only the Cell Collection
					$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
					 // print_r($cell_collection);
					 $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumm);
					// echo "<br>---highestColumnIndex---".$highestColumnIndex."--<br>";
					 $sd = 0;
					
					//extract to a PHP readable array format
					foreach ($cell_collection as $cell) 
					{
						$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
						$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
						 // echo "<br>---column---".$column."--";
						 // echo "--row---".$row."---";
						
						//header will/should be in row 1 only. of course this can be modified to suit your need.
						if ($row == 1) 
						{
							$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
							$header[$row][2] = $data_value;
							
						} 
						else 
						{
								$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
								 $data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
								 //	echo "<br>data_value ".$data_value;
									$points_data[$sd]= $data_value;
									// print_r($points_data);
								
								$temp  = strtotime(  PHPExcel_Style_NumberFormat::toFormattedString($points_data[$col_date],'Y-m-d H:i:s' ));
							$TransactionDate = date('Y-m-d H:i:s',$temp) ;	
							// $TransactionDate = date("Y-m-d H:i:s",strtotime($temp));
							// echo "<br>actualdate ".$TransactionDate;
							$access = 0;
							//$points_data[] = date("Y-m-d",strtotime($data_value));
							 $sd++;
							$lines = $row;
							//getCellByColumnAndRow($col, $row)->getValue())->format('m/d/Y');
							
								//echo $phpDateTimeObject->format('Y-m-d');
							$TransactionDate2 = date('Y-m-d H:i:s',$temp) ;
							// echo "<br>***sd ".$sd;
							// echo "<br>***TransactionDate2 ".$TransactionDate2;
							// echo "***from_date ".$from_date;
							// echo "***till_date ".$till_date;
							if(($sd==$highestColumnIndex))
							{
							//echo "<br>($TransactionDate2 >= $from_date) && ($TransactionDate2 <= $till_date)";
									$sd = 0;
									$TrDate = $points_data[$col_date]; 
									
									if($TrDate == "")
									{
										$get_error[] = "Enrollemet Date is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										$access = 1;
										
									}							
									$TransactionDate = date("Y-m-d H:i:s",strtotime($TrDate));
									$CardID = addslashes($points_data[$col_membershipid]);
									//echo "*****************CardID ".$CardID;
									if($CardID == "")
									{
										$get_error[] = "Membership ID is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										$access = 1;								
									}														
									
									$colfirstname = addslashes($points_data[$col_first_name]);
									//echo "*****************CardID ".$CardID;
									if($colfirstname == "")
									{
										$get_error[] = "First Name is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										
									}							
									
									$collastname = addslashes($points_data[$col_last_name]);
									//echo "*****************CardID ".$CardID;
									if($collastname == "")
									{
										$get_error[] = "Last Name is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;								
									}
									
									$coladdress = addslashes($points_data[$col_address]);
									//echo "*****************CardID ".$CardID;
									if($coladdress == "")
									{
										$get_error[] = "Address is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
									}
									
									$colphoneno = addslashes($points_data[$col_phone_no]);
									// echo "*****************colphoneno ".$colphoneno;
									if($colphoneno == "")
									{
										$get_error[] = "Phone Number is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										$access = 1;								
									}
			
									$coluseremailid = addslashes($points_data[$col_user_email_id]);
									//echo "*****************CardID ".$CardID;
									if($coluseremailid == "")
									{
										$get_error[] = "User Email ID is missing";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										$access = 1;								
									}							
									$Qresult = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND Card_id='".$CardID."' AND User_id='1'  ");	
									if($Qresult->num_rows() > 0)
									{
										$get_error[] = "Membership ID Already Exist";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										$access = 1;								
									}
									$Phone_no = $Dial_code.''.$colphoneno;
									$Qresult_colphoneno = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND Phone_no='".App_string_encrypt($Phone_no)."' AND User_id='1'  ");	
									if($Qresult_colphoneno->num_rows() > 0)
									{
										$get_error[] = "Phone No Already Exist";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										// $access = 1;
										
									}
									$Qresult_coluseremailid = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='".$Company_id."' AND User_email_id='".App_string_encrypt($coluseremailid)."' AND User_id='1'  ");	
									if($Qresult_coluseremailid->num_rows() > 0)
									{
										$get_error[] = "User Email ID Already Exist";
										$get_trans_date[] = date("Y-m-d",strtotime($TrDate));
										$get_error_row[] =  $lines ;
										$access = 1;								
									}
									// echo "<br>---TransactionDate--".$TransactionDate."--<br>";
									// echo "<br>---TrDate--".$TrDate."--<br>";
									// echo 'access '.$access;
										/********************************************************/
									if($access ==  0)
									{
										//echo "<br>---get_error_row-y--".count($get_error_row)."--<br>";
										
										$sql_out1 = $this->db->query("select Trans_id from  igain_transaction where Manual_billno ='".$BillNo."' and Card_id='".$CardID."' and Company_id='".$Company_id."'");
										// echo "select Trans_id from  igain_transaction where Manual_billno ='".$BillNo."' and Card_id='".$CardID."' and Company_id='".$Company_id."'";
										//$sql_out2 = $this->db->query("select upload_id from  ".$temp_tbl." where Pos_Billno ='".$BillNo."' and Pos_Customerno='".$CardID."' ");
										//&& ($TransactionDate >= $from_date) && ($TransactionDate <= $till_date)
										if(($sql_out1->num_rows() == 0) )//&& $sql_out2->num_rows() == 0
										{
											$tbl_data = array(
											
												'First_Name' => $colfirstname,
												'Last_Name' => $collastname,
												'Address' => $coladdress,
												'Phone_No' => $Phone_no,
												'User_Email_ID' => $coluseremailid,
												'Membership_ID' => $CardID,
												'Date' => $TransactionDate2
											);											
											$this->db->insert($temp_tbl, $tbl_data);
											// print_r($tbl_data);
											// echo"----insert-----".$this->db->last_query()."----<br>";
										}
										else
										{
											// echo "<br>--Transaction Is Already Exist---<br>";
											
											$get_error[] = "Transaction Is Already Exist";
											$get_error_row[] =  $lines ;
											$get_trans_date[] = date("Y-m-d",strtotime($TransactionDate2));
										}
									}
									else
									{
										$Data_not_found_flag=1;
										$Upload_status = 3;
									}
								//unset($points_data);

							}
								
						}

						
					}
					/********************************************************************/
					
				
			}
			else
			{
				return false;
			}
			
			
			//$this->db->query("Delete FROM igain_flatfile_error_log where Company_id=".$Company_id." and File_name='".$filename."' and Date='".$select_date."' ");
		//$this->dbforge->drop_table($temp_tbl);			
			$this->db->where(array('Company_id' =>$Company_id, 'File_name' =>$filename ));
			$this->db->delete('igain_flatfile_error_log');
		
			//echo $this->db->last_query();
				// echo "count".count($get_trans_date);
				// print_r($get_trans_date);
			$error_status = count($get_error);	
			//echo "<br>error_status ".$error_status;
			//echo "<br>Upload_status ".$Upload_status;
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
						'Error_row_no' => $get_error_row[$pk]
						);						
						$this->db->insert('igain_flatfile_error_log',$colm_arr);
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
				
				$Upload_status = 1;
			}
		//	die;
		if($Data_not_found_flag==1)
		{
			$Upload_status = 3;
		}
		return $Upload_status;
		
	}
	Public function get_upload_file_data($outlet_id)
	{
		$temp_tbl = $outlet_id.'uploadtempdatatbl';
		
		$this->db->select('*');
		 $this->db->from($temp_tbl);
		 // $this->db->join("igain_payment_type_master", "igain_payment_type_master.Payment_type_id = ".$temp_tbl.".Pos_Payment_type");
		$this->db->order_by('upload_id','asc');
		$query15 = $this->db->get();
		// echo "----get_upload_file_data----".$this->db->last_query()."---<br>";
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
		 $this->db->select("*");		 
		 $this->db->from($temp_tbl);		
		$query15 = $this->db->get();
		//echo "<br>********<br>".$this->db->last_query();
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
	function get_upload_errors($filename,$Company_id)
	{
		$todayDate = date("Y-m-d");
		$this->db->select('File_name,Error_in,Error_row_no,Date');
		$this->db->from('igain_flatfile_error_log');
		//$this->db->where(array('File_name' =>$filename,'Company_id' =>$Company_id,'Date'=>$todayDate));
		$this->db->where(array('File_name' =>$filename,'Company_id' =>$Company_id));//22-8-2016 AMIT		
		$error_data = $this->db->get();		
		// echo"----get_upload_errors----".$this->db->last_query()."---<br>";		
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
	function insert_enrollement_flatfile($post_data)
	{
		 $this->db->insert('igain_enrollment_master', $post_data);
		 $enrollID = $this->db->insert_id();
		 // echo"----insert_enrollement_flatfile----".$this->db->last_query()."---<br>";		
		 if($this->db->affected_rows() > 0)
		{
			// return true;
			return $enrollID;
		}
		else
		{
			return 0;
		}
	}
	function get_lowest_tier($Company_id)
	{
		$this->db->select('Tier_id');
		$this->db->from('igain_tier_master');
		$this->db->where(array('Company_id'=> $Company_id));
		$this->db->order_by('Tier_id', 'DESC');
		$sql = $this->db->get();
		foreach ($sql->result() as $row)
		{
			$Tier_id = $row->Tier_id;
		}
		return 	$Tier_id;
	}
	function Check_UserEmailID_exist_record($UserEmailID,$Company_id)
	{		
		$this->db->select("*");
		$this->db->from("igain_enrollment_master");
		$this->db->where(array("User_email_id" => $UserEmailID,"Company_id" => $Company_id,"User_id" => 1));
		$data_map_query = $this->db->get();	
		// echo $this->db->last_query();
		return $data_map_query->num_rows();	
	}
	function Check_MembershipID_exist_record($MembershipID,$Company_id)
	{		
		$this->db->select("*");
		$this->db->from("igain_enrollment_master");
		$this->db->where(array("Card_id" => $MembershipID,"Company_id" => $Company_id,"User_id" => 1));
		$data_map_query1 = $this->db->get();
		// echo $this->db->last_query();		
		return $data_map_query1->num_rows();		
	}
	function Check_PhoneNo_exist_record($PhoneNo1,$Company_id)
	{		
		$this->db->select("*");
		$this->db->from("igain_enrollment_master");
		$this->db->where(array("Phone_no" => $PhoneNo1,"Company_id" => $Company_id,"User_id" => 1));
		$data_map_query12 = $this->db->get();	
		// echo $this->db->last_query();
		return $data_map_query12->num_rows();
	
	}
	function get_flat_file_upload_errors($filename,$Company_id)
	{
		$todayDate = date("Y-m-d");
		$this->db->select('Error_in,Error_row_no');
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
	function Drop_upload_file_data($outlet_id) {
        $temp_tbl = $outlet_id . 'uploadtempdatatbl';

        $this->db->query("DROP TABLE " . $temp_tbl);
    }
	
	
}
?>