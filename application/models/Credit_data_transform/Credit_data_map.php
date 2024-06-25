<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Credit_data_map extends CI_Model 
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
				$query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"dm.Column_outlet_id"=>$Logged_user_enrollid,"Data_map_for" => 3));
			}
			else //brand
			{
				$query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"dm.Column_Seller_id"=>$Logged_user_enrollid,"Data_map_for" => 3));
			}
			
		}
		else
		{
			$query = $this->db->where(array("dm.Column_Company_id"=>$Company_id,"em.Company_id"=>$Company_id,"Data_map_for" => 3));
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
		
		$query = $this->db->where(array("Column_Company_id" => $Company_id,"Column_outlet_id" => $Seller_id,"Data_map_for" => 3));
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
	public function upload_data_map_file($filepath, $filename, $Company_id, $Logged_user_enrollid)
	{
        $temp_tbl = $Logged_user_enrollid . 'uploadtempdatatbl';
        $this->load->helper('date');
        $this->load->dbforge();
        if ($this->db->table_exists($temp_tbl) == TRUE) {
            $this->dbforge->drop_table($temp_tbl);
        }
        // error_reporting(0);
        $fields = array(
            'upload_id' => array('type' => 'INT', 'constraint' => '11', 'auto_increment' => TRUE),
            'Pos_Transdate' => array('type' => 'datetime'),
            'Pos_Customerno' => array('type' => 'VARCHAR', 'constraint' => '50'),
            'Pos_Billno' => array('type' => 'VARCHAR', 'constraint' => '50'),
			'Pos_Billamt' => array('type' => 'DECIMAL', 'constraint' => '25,2'),
            'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200'),
            'Status' => array('type' => 'VARCHAR', 'constraint' => '100'),
        );


        $this->dbforge->add_field($fields);

        $this->dbforge->add_key('upload_id', TRUE);
        // gives PRIMARY KEY (upload_id)

        $this->dbforge->create_table($temp_tbl, TRUE);

        // echo $this->db->last_query(); exit; die;
        $this->db->from("igain_data_upload_map_tbl");
        $this->db->where(array("Column_Company_id" => $Company_id, "Column_outlet_id" => $Logged_user_enrollid, "Data_map_for" => 3));

        $data_map_query = $this->db->get();
		// echo 'temp_tbl '.$temp_tbl;
        // echo "<br>---Query---".$this->db->last_query()."--<br>";
        $data_map = $data_map_query->result_array();

        foreach ($data_map as $dmap) {
            $col_date = $dmap["Column_Date"];
            $col_cust = $dmap["Column_Customer"];
            $col_bill = $dmap["Column_Bill_no"];
            $col_amt = $dmap["Column_Amount"];
            $col_header_rows = $dmap["Column_header_rows"];
            $col_remarks = $dmap["Column_remarks"];
            $col_Status = $dmap["Column_Status"];
            $Column_date_format = $dmap["Column_date_format"];
        }

        function getExtension($str) {
            $i = strrpos($str, ".");
            if (!$i) {
                return "";
            }
            $l = strlen($str) - $i;
            $ext = substr($str, $i + 1, $l);
            return $ext;
        }

        $extension = getExtension($filename);

        $data['Company_id'] = $Company_id;
        $data['Active_flag'] = 1;

        //$select_date = date("Y-m-d",strtotime($this->input->post("file_date")));
        $from_date = date("Y-m-d H:i:s", strtotime($this->input->post("from_date")));
        $till_date = date("Y-m-d H:i:s", strtotime($this->input->post("till_date")));

        $Today_Date = date("Y-m-d");

        $get_error = array();
        $get_trans_date = array();
        $get_error_row = array();
        $Data_not_found_flag = 0;

        $Total_count = array();

        $TrDate = "";
        $transDate = "";
        $CardI = 0;
        $BillNo = 0;
        $TransactionAmt = 0;
        $Transaction_date = "";
        $Remarks = "";
        $Status = "";

        $user_details = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
        $logtimezone = $user_details->timezone_entry;
		
        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time=$date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');

        if ($extension == "csv") 
		{
            $filenameis = $filename;
            $handle = fopen($filepath, "r");


            // echo " - filename --".$filename."---<br>";
            // echo " - filepath --".$filepath."----<br>";

            $x = 0;
            $y = 0;

            $Total_error_count = 0;
            $Total_row = 0;
            $Error_row = 0;
            $Success_row = 0;

            $this->db->where(array('Company_id' => $Company_id, 'File_name' => $filename));
            $this->db->delete('igain_flatfile_error_log');

            //echo "----delete-----SQL----".$this->db->last_query()."---<br>";

            for ($lines = 1; $csv_data = fgetcsv($handle, 1000, ",", '"'); $lines++) {

                $access = 0;
                $Error_transaction_date = "";
                $errors_collection = array();
                $values_collection = array();

                if ($lines <= $col_header_rows)
                    continue;

                $TrDate2 = $csv_data[$col_date];

                // echo " TrDate2-----". $TrDate2."<br>";
                // $TransactionDate2 = date("Y-m-d H:i:s",strtotime($TrDate2));
                // $TrDate = $csv_data[$col_date];

                $transDate122 = str_replace('/', '-', $TrDate2);

                // echo " transDate122-----". $transDate122."<br>";

                $date_format = $Column_date_format;
                $temp_trans_date = $transDate122;

                // echo " date_format-----". $date_format."<br>";

                if ($date_format == "d-m-Y" || $date_format == "dd-mm-YY") { //OK
                    $date_format = "d-m-Y";
                    $chunks = explode('-', $temp_trans_date);
                    if ($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date)) {
                        if ($temp_trans_date == "") {
                            $temp_trans_date = "01-01-1970";
                        }
                        $date = DateTime::createFromFormat($date_format, $temp_trans_date);
                        $trans_date = $date->format('Y-m-d');

                        $year = $date->format("Y");
                        $month_date = $date->format("m-d");
                        $Current_year = date("Y");
                        $date_year_2digits = substr($year, 2, 2);
                        $Current_year_2digits = substr($Current_year, 0, 2);
                        $new_year = $Current_year_2digits . $date_year_2digits;
                        $trans_date = $new_year . '-' . $month_date;
                    } else {

                        $trans_date = '1970-01-01';
                    }
                }
                if ($date_format == "m/d/Y" || $date_format == "mm/dd/YY") { //OK
                    $temp_trans_date = str_replace('-', '/', $temp_trans_date);
                    $chunks = explode('/', $temp_trans_date);
                    if ($chunks[0] < 13 && $chunks[1] < 32 && !empty($temp_trans_date)) {
                        if ($temp_trans_date == "") {
                            $temp_trans_date = "01/01/1970";
                        }

                        $date = DateTime::createFromFormat("m/d/Y", $temp_trans_date);
                        $trans_date = $date->format('Y-m-d');
                        $year = $date->format("Y");
                        $month_date = $date->format("m-d");
                        $Current_year = date("Y");
                        $date_year_2digits = substr($year, 2, 2);
                        $Current_year_2digits = substr($Current_year, 0, 2);
                        $new_year = $Current_year_2digits . $date_year_2digits;
                        $trans_date = $new_year . '-' . $month_date;
                    } else {

                        $trans_date = '1970-01-01';
                    }
                }
                if ($date_format == "mm/dd/yyyy") { //OK
                    $trans_date = date("Y-m-d", strtotime($temp_trans_date));
                }
                if ($date_format == "dd/mm/yyyy") {  //OK
                    $chunks = explode('-', $temp_trans_date);
                    if ($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date)) {
                        $temp_trans_date = str_replace("-", "/", $temp_trans_date);

                        if ($temp_trans_date == "") {
                            $temp_trans_date = "01/01/1970";
                        }
                        $dateY = DateTime::createFromFormat('d/m/Y', $temp_trans_date);
                        $trans_date = $dateY->format('Y-m-d');
                    } else {

                        $trans_date = '1970-01-01';
                    }
                }
                if ($date_format == "mm-dd-yyyy") { //OK but Date wil wrorng then cant insert into DB

                    $date12 = str_replace("-", "/", $temp_trans_date);
                    $trans_date = date("Y-m-d", strtotime($date12));
                }
                if ($date_format == "dd-mm-yyyy") { //OK but Date wil wrorng then cant insert into DB

                    $date23 = str_replace("/", "-", $temp_trans_date);
                    $trans_date = date("Y-m-d", strtotime($date23));
                }


                //echo " trans_date-----". $trans_date."---<br>";
               // echo " TrDate2-----". $TrDate2."---<br>";


                if ($TrDate2 == "" || $TrDate2 == null) {

                    $errors_collection[$y] = "Transaction date is missing";
                    $access = 1;
                    $Error_transaction_date = "";
                } /* else {

                    if ($trans_date == "" || $trans_date == "1970-01-01 00:00:00" || $trans_date == "1970-01-01" || $trans_date == "1970-01-01 01:00:00") {

                        $errors_collection[$y] = "Transaction Date Format is Incorrect";
                        $access = 1;

                        $Error_transaction_date = $TrDate2;
                    } else if($trans_date > $Todays_date ){

                       $errors_collection[$y] = "Transaction Date is Greater than Today";
                        $access = 1;

                        $Error_transaction_date = $TrDate2;

                    } else {

                        $values_collection[$x]["Transaction_date"] = $trans_date;
                    }
                } */
                $y++;



                $MembershipID = $csv_data[$col_cust];
                //echo"--MembershipID---".$MembershipID."---<br>";
                if ($MembershipID == "" || $MembershipID == null) {
                    $errors_collection[$y] = "Membership ID is missing";
                    $access = 1;
                    $Error_transaction_date = $trans_date;
                } else {

                    $Qresult = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='" . $Company_id . "' AND Card_id='" . $MembershipID . "' AND User_id='1' ");
					
					// echo "<br>---Qresult---".$this->db->last_query()."--<br>";
                    if ($Qresult->num_rows() == 1) {
                        $values_collection[$x]["Card_id"] = $MembershipID;
                    } else {
                        $errors_collection[$y] = "Invalid Membership ID";
                        $access = 1;
                        $Error_transaction_date = $trans_date;
                    }
                }
                $y++;


                $TransactionAmt = $csv_data[$col_amt];
                if ($TransactionAmt == "") {
                    $errors_collection[$y] = "Transaction amount is missing";
                    $access = 1;
                    $Error_transaction_date = $trans_date;
                } else {
                    $values_collection[$x]["Transaction_amount"] = $TransactionAmt;
                }
                $y++;

                $BillNo = $csv_data[$col_bill];
                // echo"--BillNo---".$BillNo."---<br>";
                if ($BillNo == "") {
                    $errors_collection[$y] = "Bill number is missing";
                    $access = 1;
                    $Error_transaction_date = $trans_date;
                } else {

                    // $sql_out1 = $this->db->query("select Trans_id from  igain_transaction where (Bill_no ='".$BillNo."' OR Manual_billno ='".$BillNo."' ) and Card_id='".$MembershipID."'  and Company_id='".$Company_id."'");

                    $sql_out1 = $this->db->query("select Trans_id from  igain_transaction where Manual_billno ='" . $BillNo . "' and Card_id='" . $MembershipID . "'  and Company_id='" . $Company_id . "'");
                    if ($sql_out1->num_rows() > 0) {

                        $errors_collection[$y] = "Transaction is already exist";
                        $access = 1;
                        $Error_transaction_date = $trans_date;
                        $values_collection[$x]["Bill_no"] = $BillNo;
                    } else { 

                        $sql_out1 = $this->db->query("select * from  " . $temp_tbl . " where Pos_Billno ='" . $BillNo . "'  ");
                        //echo "<br> select * from  " . $temp_tbl . " where Pos_Billno ='" . $BillNo . "'  <br>";

                        //echo"--num_rows---".$sql_out1->num_rows()."---<br>";
                        if ($sql_out1->num_rows() > 0) {

                            foreach ($sql_out1->result() as $row) {
                                
                                    if ($row->Pos_Customerno == $MembershipID && $row->Pos_Billamt == $TransactionAmt) {
                                        $values_collection[$x]["Bill_no"] = $BillNo;
                                    } else {

                                        $errors_collection[$y] = "Same Bill No. is already exist";
                                        $access = 1;
                                        $Error_transaction_date = $trans_date;
                                        $values_collection[$x]["Bill_no"] = $BillNo;
                                    }
                                
                            }
                        } else {

                            $values_collection[$x]["Bill_no"] = $BillNo;
                        }
                    }
                }
                $y++;

                $TransactionStatus = $csv_data[$col_Status];
                $values_collection[$x]["Status"] = $TransactionStatus;

                $Remarks = $csv_data[$col_remarks];
                $values_collection[$x]["Remarks"] = $Remarks;

                if ($access == 1) {

                    $m = 0;
                    $error_count = count($errors_collection);
                    foreach ($errors_collection as $err) {


                        $transDate = $trans_date; //echo " - transDate --".$trans_date."<br>";
                       // $transDate = $values_collection[$m]['Transaction_date']; echo " - transDate --".$trans_date."<br>";
                        $Membership_ID = $values_collection[$m]["Card_id"]; //echo " Membership_ID--".$Membership_ID."<br>";
                        $BillNo = $values_collection[$m]["Bill_no"];  //echo " BillNo--".$BillNo."<br>";
                        $TransactionAmount = $values_collection[$m]["Transaction_amount"];  //echo " TransactionAmount--".$TransactionAmount."<br>";
                        $Status = $values_collection[$m]["Status"];  //echo " Status--".$Status."<br>";
                        $Remarks = $values_collection[$m]["Remarks"];  //echo " Remarks--".$Remarks."<br>";
                      

                        $error_query = "Insert into igain_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in,Error_row_no,Card_id,Transaction_date,Error_transaction_date,Bill_no,Transaction_amount,Status,Remarks) Values ('" . $Company_id . "','" . $filename . "','" . $filepath . "',0,'" . $transDate . "','" . $err . "','" . $lines . "','" . $Membership_ID . "','" . $transDate . "','" . $Error_transaction_date . "','" . $BillNo . "','" . $TransactionAmount . "','" . $Status . "','" . $Remarks . "') ";

                        $sql = $this->db->query($error_query);
                        //echo "--Insert_error_query---1111---".$this->db->last_query()." <br>";
                        $Total_error_count++;
                    }
                } else if ($access == 0) {

                    $m = 0;

                    $transDate = strip_tags($values_collection[$m]['Transaction_date']); //echo " - transDate --".$transDate."<br>";
                    $Membership_ID = strip_tags($values_collection[$m]["Card_id"]); //echo " Membership_ID--".$Membership_ID."<br>";
                    $BillNo = strip_tags($values_collection[$m]["Bill_no"]);  //echo " BillNo--".$BillNo."<br>";
                    $TransactionAmount = strip_tags($values_collection[$m]["Transaction_amount"]);  //echo " TransactionAmount--".$TransactionAmount."<br>";
                    $Status = strip_tags($values_collection[$m]["Status"]);  //echo " Status--".$Status."<br>";
                    $Remarks = strip_tags($values_collection[$m]["Remarks"]);  //echo " Remarks--".$Remarks."<br>";
                    
                    $PaymentType = strip_tags($values_collection[$m]["PaymentType"]);  //echo " PaymentType--".$PaymentType."<br>";
                  

                    // $Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Remarks,Status) Values('" . $transDate . "','" . $Membership_ID . "','" . $BillNo . "','" . $TransactionAmount .  $Remarks . "','" . $Status . "')";

					$transDate = date('Y-m-d H:i:s');
                    $Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Remarks,Status) Values('" . $transDate . "','" . $Membership_ID . "','" . $BillNo . "','" . $TransactionAmount ."','" . $Remarks . "','" . $Remarks . "')";
                    $sql1 = $this->db->query($Insert_query);

                    //echo "--Insert_temp_query---".$this->db->last_query()." <br>";

                    $Success_row++;
                }
                // unset($Error_transaction_date);

                $Total_row++;
            }
            $Error_row = $Total_row - $Success_row;
        } 
		else if ($extension == "xlsx" || $extension == "xls") 
		{
            $Total_error_count = 0;
            $Total_row = 0;
            $Error_row = 0;
            $Success_row = 0;
            $lines = 0;

            $this->db->where(array('Company_id' => $Company_id, 'File_name' => $filename));
            $this->db->delete('igain_flatfile_error_log');


            require_once(APPPATH . 'libraries/excel_reader2.php');

            $data = new Spreadsheet_Excel_Reader();
            $data->read($filepath);


            $MembershipId11 = $col_cust + 1;
            $transDate11 = $col_date + 1;
            $trans_amount11 = $col_amt + 1;
            $BillNumber11 = $col_bill + 1;
            $Remarks11 = $col_remarks + 1;
            $Status11 = $col_Status + 1;

            for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) 
			{
                $transDate121 = strip_tags($data->sheets[0]["cells"][$x][$transDate11]);
                $MembershipId12 = strip_tags($data->sheets[0]["cells"][$x][$MembershipId11]);
               
                $trans_amount12 = strip_tags($data->sheets[0]["cells"][$x][$trans_amount11]);

                $BillNumber12 = strip_tags($data->sheets[0]["cells"][$x][$BillNumber11]);
                $Remarks12 = strip_tags($data->sheets[0]["cells"][$x][$Remarks11]);
                $Status12 = strip_tags($data->sheets[0]["cells"][$x][$Status11]);

                $transDate122 = str_replace('/', '-', $transDate121);

                $date_format = $Column_date_format;
                $temp_trans_date = $transDate122;

                if ($date_format == "d-m-Y" || $date_format == "dd-mm-YY") { //OK
                    $date_format = "d-m-Y";
                    $chunks = explode('-', $temp_trans_date);

                    // echo " chunks-----". $chunks[0]."---".$chunks[1]."---<br>";
                    if ($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date)) {
                        if ($temp_trans_date == "") {
                            $temp_trans_date = "01-01-1970";
                        }
                        // echo " temp_trans_date-----". $temp_trans_date."<br>";
                        $date = DateTime::createFromFormat($date_format, $temp_trans_date);
                        $trans_date = $date->format('Y-m-d');

                        $year = $date->format("Y");
                        $month_date = $date->format("m-d");
                        $Current_year = date("Y");
                        $date_year_2digits = substr($year, 2, 2);
                        $Current_year_2digits = substr($Current_year, 0, 2);
                        $new_year = $Current_year_2digits . $date_year_2digits;
                        $trans_date = $new_year . '-' . $month_date;
                    } else {

                        $trans_date = '1970-01-01';
                    }
                }
                if ($date_format == "m/d/Y" || $date_format == "mm/dd/YY") { //OK
                    $temp_trans_date = str_replace('-', '/', $temp_trans_date);
                    $chunks = explode('/', $temp_trans_date);
                    // echo "---chunk-----". $chunks[0]."---".$chunks[1]."---<br>";
                    if (($chunks[0] < 13 && $chunks[1] < 32) && !empty($temp_trans_date)) {

                        //echo " temp_trans_date----1111-". $temp_trans_date."<br>";
                        if ($temp_trans_date == "") {
                            $temp_trans_date = "01/01/1970";
                        }

                        $date = DateTime::createFromFormat("m/d/Y", $temp_trans_date);
                        $trans_date = $date->format('Y-m-d');
                        $year = $date->format("Y");
                        $month_date = $date->format("m-d");
                        $Current_year = date("Y");
                        $date_year_2digits = substr($year, 2, 2);
                        $Current_year_2digits = substr($Current_year, 0, 2);
                        $new_year = $Current_year_2digits . $date_year_2digits;
                        $trans_date = $new_year . '-' . $month_date;
                    } else {

                        $trans_date = '1970-01-01';
                        // echo "---trans_date-----". $trans_date."---<br>";
                    }
                }
                if ($date_format == "mm/dd/yyyy") { //OK
                    $trans_date = date("Y-m-d", strtotime($temp_trans_date));
                }
                if ($date_format == "dd/mm/yyyy") {  //OK
                    $chunks = explode('-', $temp_trans_date);
                    // echo " chunks-----". $chunks[0]."---".$chunks[1]."---<br>";
                    if ($chunks[0] < 32 && $chunks[1] < 13 && !empty($temp_trans_date)) {
                        $temp_trans_date = str_replace("-", "/", $temp_trans_date);
                        if ($temp_trans_date == "") {
                            $temp_trans_date = "01/01/1970";
                        }
                        // echo " temp_trans_date-----". $temp_trans_date."<br>";
                        $dateY = DateTime::createFromFormat('d/m/Y', $temp_trans_date);
                        $trans_date = $dateY->format('Y-m-d');
                    } else {

                        $trans_date = '1970-01-01';
                    }
                }
                if ($date_format == "mm-dd-yyyy") { //OK but Date wil wrorng then cant insert into DB

                    $date12 = str_replace("-", "/", $temp_trans_date);
                    $trans_date = date("Y-m-d", strtotime($date12));
                }
                if ($date_format == "dd-mm-yyyy") { //OK but Date wil wrorng then cant insert into DB

                    // echo " temp_trans_date-----". $temp_trans_date."<br>";
                    $date23 = str_replace("/", "-", $temp_trans_date);
                    // echo " date23-----". $date23."<br>";
                    $trans_date = date("Y-m-d", strtotime($date23));

                }

                $access = 0;
                $Error_transaction_date = "";


                if ($MembershipId12 == "") {
                    $get_error[] = "Membership ID is missing";
                    $get_error_row[] = $x;
                    $lines = $x;
                    $access = 1;
                    $Error_transaction_date = $trans_date;
                } else {

                     $Qresult1 = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='" . $Company_id . "' AND Card_id='" . $MembershipId12 . "' AND User_id='1' ");
                    if ($Qresult1->num_rows() == 1) {
                        $MembershipId12 = $MembershipId12;
                    } else {

                        $get_error[] = "Invalid Membership ID";
                        $get_error_row[] = $x;
                        $lines = $x;
                        $access = 1;
                        $Error_transaction_date = $trans_date;
                    }
                }
                if ($BillNumber12 == "") {
                    $get_error[] = "Bill Number is missing";
                    $get_error_row[] = $x;
                    $lines = $x;
                    $access = 1;

                    $Error_transaction_date = $trans_date;
                } else 
				{
                    $sql_out1 = $this->db->query("select Trans_id from  igain_transaction where Manual_billno ='" . $BillNumber12 . "' and Card_id='" . $MembershipId12 . "'  and Company_id='" . $Company_id . "'");

                    if ($sql_out1->num_rows() > 0) {

                        $get_error[] = "Transaction is already exist";
                        $get_error_row[] = $x;
                        $lines = $x;
                        $access = 1;
                        $Error_transaction_date = $trans_date;
                    } else {

                        $sql_out2 = $this->db->query("select * from  " . $temp_tbl . " where Pos_Billno ='" . $BillNumber12 . "'  ");

                        if ($sql_out2->num_rows() > 0) {

                            foreach ($sql_out2->result() as $row) {
                                if ($product_code12 == "") {
                                    if ($row->Pos_Customerno == $MembershipId12 && $row->Pos_Billamt == $TransactionAmt) {
                                        $BillNumber12 = $BillNumber12;
                                    } else {

                                        $get_error[] = "Same Bill No. is already exist ";
                                        $get_error_row[] = $x;
                                        $lines = $x;
                                        $access = 1;
                                        $Error_transaction_date = $trans_date;
                                    }
                                } 
                            }
                        } else {

                            $BillNumber12 = $BillNumber12;
                        }
                    }
                }

                if ($trans_amount12 == "") {
                    $get_error[] = "Transaction Amount is missing";
                    $get_error_row[] = $x;
                    $lines = $x;
                    $access = 1;
                    $Error_transaction_date = $trans_date;
                }
                if ($transDate121 == "") {
                    $get_error[] = "Transaction Date is missing";
                    $get_error_row[] = $x;
                    $lines = $x;
                    $access = 1;
                    $Error_transaction_date = "";
                } else {

                   /* if ($trans_date == "" || $trans_date == "1970-01-01 00:00:00" || $trans_date == "1970-01-01" || $trans_date == "1970-01-01 01:00:00") {
                        $get_error[] = "Transaction Date Format is Incorrect";
                        $get_error_row[] = $x;
                        $lines = $x;
                        $access = 1;
                        $Error_transaction_date = $transDate121;
                    } else if($trans_date > $Todays_date ){

                       $get_error[] = "Transaction Date is Greater than Today";
                        $get_error_row[] = $x;
                       $lines = $x;
                        $access = 1;

                        $Error_transaction_date = $transDate121;

                    } else {
                        $trans_date = $trans_date;
                    }*/
					 $trans_date = $trans_date;
                }
                if ($access == 1) 
				{
                    $error_count = count($get_error);
                    foreach ($get_error as $err) 
					{
                        $error_query = "Insert into igain_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in,Error_row_no,Card_id,Transaction_date,Error_transaction_date,Bill_no,Transaction_amount,Status,Remarks) Values ('" . $Company_id . "','" . $filename . "','" . $filepath . "',0,'" . $trans_date . "','" . $err . "','" . $lines . "','" . $MembershipId12 . "','" . $trans_date . "','" . $Error_transaction_date . "','" . $BillNumber12 . "','" . $trans_amount12 . "','" . $Remarks12 . "','" . $Remarks12 . "') ";


                        $sql = $this->db->query($error_query);
                        // echo "--Insert_error_query---1111---".$this->db->last_query()." ---<br><br>";
                        $Total_error_count++;
                    }
                } 
				else if ($access == 0) 
				{
					$trans_date = date('Y-m-d H:i:s');
                    $Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Remarks,Status) Values('" . $trans_date . "','" . $MembershipId12 . "','" . $BillNumber12 . "','" . $trans_amount12 ."','" . $Remarks12 . "','" . $Remarks12 . "')";


                    $sql1 = $this->db->query($Insert_query);
                   
                    $Success_row++;
                }
                $Total_row++;
                unset($get_error);
            }
            $Error_row = $Total_row - $Success_row;
        }
		else 
		{
            return false;
        }


        $error_status = count($get_error);
        //if($error_status > 0)
        if ($Total_error_count > 0) {
            $coln_array = array(
                'Company_id' => $Company_id,
                'File_name' => $filename,
                'File_path' => $filepath,
                'Upload_status' => '1',
                'Error_status' => $Total_error_count,
                'Date' => $Today_Date,
                'Total_row' => $Total_row,
                'Success_row' => $Success_row,
                'Error_row' => $Error_row
            );

            $Upload_status = 0;

            $this->db->insert('igain_file_upload_status', $coln_array);

            // echo " ------igain_file_upload_status------".$this->db->last_query()."-----------<br><br><br>";

            $mv_inserted_id = $this->db->insert_id();

            $Upload_status = $mv_inserted_id;

            $this->db->where(array('File_name' => $filename, 'Company_id' => $Company_id));
            $this->db->update('igain_flatfile_error_log', array('Status_id' => $Upload_status));
        } 
		else
		{
            $coln_array = array(
                'Company_id' => $Company_id,
                'File_name' => $filename,
                'File_path' => $filepath,
                'Upload_status' => '0',
                'Error_status' => '0',
                'Date' => $Today_Date,
                'Total_row' => $Total_row,
                'Success_row' => $Success_row,
                'Error_row' => $Error_row
            );


            $this->db->insert('igain_file_upload_status', $coln_array);
            $mv_inserted_id = $this->db->insert_id();

            //$Upload_status = 1;
            $Upload_status = $mv_inserted_id;
        }

        $return_array = array(
            'Total_error_count' => $Total_error_count,
            'Total_row' => $Total_row,
            'Error_row' => $Error_row,
            'Success_row' => $Success_row,
            'Upload_status' => $Upload_status
        );
	
        
		return $return_array;			
        //return $Upload_status;
    }
	Public function get_upload_file_data($outlet_id)
	{
		$temp_tbl = $outlet_id.'uploadtempdatatbl';
		
		$this->db->select('*');
		 $this->db->from($temp_tbl);
		
		$this->db->order_by('upload_id','asc');
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
	function get_upload_errors($filename, $Company_id) {
        $todayDate = date("Y-m-d");
        $this->db->select(' * ');
        $this->db->from('igain_flatfile_error_log');
        //$this->db->where(array('File_name' =>$filename,'Company_id' =>$Company_id,'Date'=>$todayDate));
        $this->db->where(array('File_name' => $filename, 'Company_id' => $Company_id)); //22-8-2016 AMIT

        $error_data = $this->db->get();

        //echo $this->db->last_query();

        if ($error_data->num_rows() > 0) {
            foreach ($error_data->result() as $rower) {
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
	function get_file_error_status($file_status, $Company_id) {
        $this->db->select("*, GROUP_CONCAT(Error_in SEPARATOR '; ') AS  Error_in");
        // $this->db->select("File_name,Upload_status,Error_status");
        $this->db->from("igain_file_upload_status");
        $this->db->join("igain_flatfile_error_log", "igain_flatfile_error_log.Status_id =igain_file_upload_status.Status_id");
        $this->db->where(array('igain_file_upload_status.Company_id' => $Company_id, 'igain_file_upload_status.Status_id' => $file_status));
        $this->db->group_by('Error_row_no');
        $queryOPT = $this->db->get();

        //echo"---SQL---".$this->db->last_query();

        if ($queryOPT->num_rows() > 0) {
            foreach ($queryOPT->result() as $roww) {
                $data[] = $roww;
            }
            return $data;
        }
        return false;
    }
	
}
?>
