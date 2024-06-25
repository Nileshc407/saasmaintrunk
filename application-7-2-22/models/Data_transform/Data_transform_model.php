<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_transform_model extends CI_Model {

    public function data_map_list($limit, $start, $Company_id, $Super_seller, $Logged_user_enrollid) {

        if ($limit != "" || $start != "") {
            $this->db->limit($limit, $start);
        }


        $query = $this->db->from("igain_data_upload_map_tbl as dm");
        $query = $this->db->join("igain_enrollment_master as em", "dm.Column_Seller_id=em.Enrollement_id");
        if ($Super_seller == 0) {
            $query = $this->db->where(array("dm.Column_Company_id" => $Company_id, "em.Company_id" => $Company_id, "dm.Column_Seller_id" => $Logged_user_enrollid, "Data_map_for" => 2));
        } else {
            $query = $this->db->where(array("dm.Column_Company_id" => $Company_id, "em.Company_id" => $Company_id, "Data_map_for" => 2));
        }
        //$query = $this->db->where("dm.Column_Company_id",$Company_id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function check_exist_data_map_seller($Seller_id, $Company_id) {

        $query = $this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $Seller_id, "Data_map_for" => 2));
        $query = $this->db->from("igain_data_upload_map_tbl");
        $query = $this->db->select("*");
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function data_map_count($Company_id) {
        /* $query = $this->db->where("Column_Company_id",$Company_id);
          return $this->db->count_all("igain_data_upload_map_tbl"); */
        $query = $this->db->where(array("Column_Company_id" => $Company_id, "Data_map_for" => 2));
        $query = $this->db->from("igain_data_upload_map_tbl");
        $query = $this->db->select("*");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function insert_data_map($post_data) {

        $this->db->insert('igain_data_upload_map_tbl', $post_data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
    }

    function delete_data_mapping($Map_id) {
        $this->db->where('Map_id', $Map_id);
        $this->db->delete('igain_data_upload_map_tbl');

        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    function get_data_mapping($Map_id) {
        $this->db->select("*");
        $this->db->from('igain_data_upload_map_tbl');
        $this->db->where('Map_id', $Map_id);

        $rec = $this->db->get();

        if ($rec->num_rows() == 1) {
            return $rec->row();
        } else {
            return false;
        }
    }

    function update_data_map($post_data, $Map_id) {
        $this->db->where('Map_id', $Map_id);
        $this->db->update('igain_data_upload_map_tbl', $post_data);

        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    /*     * *************************** Amit Work End ******************************* */

    /*     * *************************** Sandeep Work Start ******************************* */

    /*     * *** Data file upload ******* */

    public function get_datamaping_details($Company_id, $Logged_user_id, $Logged_user_enrollid) {
        if ($Logged_user_id == 3) {
            $this->db->select("Column_Customer");
            $this->db->from("igain_data_upload_map_tbl");
            $this->db->where(array("Column_Company_id" => $Company_id));
        } else {
            $this->db->select("Column_Customer");
            $this->db->from("igain_data_upload_map_tbl");
            $this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $Logged_user_enrollid));
        }

        $data_map_query12 = $this->db->get();

        //echo $this->db->last_query();

        return $data_map_query12->num_rows();
    }

    public function get_upload_file_data($Logged_user_enrollid) {
		
		
		// echo"----get_upload_file_data------";
         $temp_tbl = $Logged_user_enrollid . 'uploadtempdatatbl';

        $this->db->from($temp_tbl);
        $this->db->join("igain_payment_type_master", "igain_payment_type_master.Payment_type_id = " . $temp_tbl . ".Pos_Payment_type");
        $this->db->order_by('Pos_Transdate', 'asc');
        $query15 = $this->db->get();

        if ($query15->num_rows() > 0) {
            foreach ($query15->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false; 
    }

    public function get_upload_file_data_for_transaction($seller_id) {
        $temp_tbl = $seller_id . 'uploadtempdatatbl';
        // $this->db->select("*,SUM(Pos_Billamt) AS Total_amount,GROUP_CONCAT(Remarks SEPARATOR ', ') as Flatfile_remarks");
        $this->db->select("*");
        $this->db->order_by('Pos_Transdate', 'asc');
        // $this->db->group_by('Pos_Billno');
        $this->db->from($temp_tbl);
        $this->db->join("igain_payment_type_master", "igain_payment_type_master.Payment_type_id = " . $temp_tbl . ".Pos_Payment_type");

        $query15 = $this->db->get();
        // echo "<br>********<br>".$this->db->last_query()."---<br><br>";
        if ($query15->num_rows() > 0) {
            foreach ($query15->result() as $row) {
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

      } */

    public function upload_data_map_file($filepath, $filename, $Company_id, $Logged_user_enrollid) {
		// echo"----upload_data_map_file----<br>";
		// die;
		
        $temp_tbl = $Logged_user_enrollid . 'uploadtempdatatbl';
        $this->load->helper('date');
        $this->load->dbforge();
        if ($this->db->table_exists($temp_tbl) == TRUE) {
            $this->dbforge->drop_table($temp_tbl);
        }
        error_reporting(0);
        $fields = array(
            'upload_id' => array('type' => 'INT', 'constraint' => '11', 'auto_increment' => TRUE),
            'Pos_Transdate' => array('type' => 'datetime'),
            'Pos_Customerno' => array('type' => 'VARCHAR', 'constraint' => '50'),
            'Pos_Billno' => array('type' => 'VARCHAR', 'constraint' => '50'),
            'Pos_Payment_type' => array('type' => 'VARCHAR', 'constraint' => '50'),
            'Pos_Quantity' => array('type' => 'INT', 'constraint' => '11'),
            'Column_Item_Code' => array('type' => 'VARCHAR', 'constraint' => '200'),
            'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200'),
            'Pos_Billamt' => array('type' => 'DECIMAL', 'constraint' => '25,2'),
            'Status' => array('type' => 'VARCHAR', 'constraint' => '100'),
        );


        $this->dbforge->add_field($fields);

        $this->dbforge->add_key('upload_id', TRUE);
        // gives PRIMARY KEY (upload_id)

        $this->dbforge->create_table($temp_tbl, TRUE);

        // echo $this->db->last_query();
        $this->db->from("igain_data_upload_map_tbl");
        $this->db->where(array("Column_Company_id" => $Company_id, "Column_Seller_id" => $Logged_user_enrollid, "Data_map_for" => 2));

        $data_map_query = $this->db->get();
        // echo "---Query---".$this->db->last_query()."--<br>";
        $data_map = $data_map_query->result_array();

        foreach ($data_map as $dmap) {
            $col_date = $dmap["Column_Date"];
            $col_cust = $dmap["Column_Customer"];
            $col_bill = $dmap["Column_Bill_no"];
            $col_amt = $dmap["Column_Amount"];
            $col_payment = $dmap["Column_Payment_type"];
            $col_Quantity = $dmap["Column_Quantity"];
            $col_Column_Item_Code = $dmap["Column_Item_Code"];
            $col_header_rows = $dmap["Column_header_rows"];
            $col_remarks = $dmap["Column_remarks"];
            $col_Status = $dmap["Column_Status"];
            $Column_date_format = $dmap["Column_date_format"];
        }

        /*  echo "col_date---".$col_date."--<br>";
          echo "col_amt---".$col_amt."--<br>";
          echo "col_cust---".$col_cust."--<br>";
          echo "col_bill---".$col_bill."--<br>";
          echo "col_payment---".$col_payment."--<br>";
          echo "col_header_rows---".$col_header_rows."--<br>";
          echo "col_Column_Item_Code---".$col_Column_Item_Code."--<br>";
          echo "col_Quantity---".$col_Quantity."--<br>";
          echo "col_remarks---".$col_remarks."--<br>";
          echo "col_Status---".$col_Status."--<br>"; */

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

        // echo "extension---".$extension."--<br>";


        $user_details = $this->Igain_model->get_enrollment_details($Logged_user_enrollid);
        $logtimezone = $user_details->timezone_entry;



        $timezone = new DateTimeZone($logtimezone);
        $date = new DateTime();
        $date->setTimezone($timezone);
        $lv_date_time=$date->format('Y-m-d H:i:s');
        $Todays_date = $date->format('Y-m-d');


        if ($extension == "csv") {
			
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
                } else {

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
                }
                $y++;



                $MembershipID = $csv_data[$col_cust];
                //echo"--MembershipID---".$MembershipID."---<br>";
                if ($MembershipID == "" || $MembershipID == null) {
                    $errors_collection[$y] = "Membership ID is missing";
                    $access = 1;
                    $Error_transaction_date = $trans_date;
                } else {

                    $Qresult = $this->db->query("Select Enrollement_id from igain_enrollment_master where Company_id='" . $Company_id . "' AND Card_id='" . $MembershipID . "' AND User_id='1' ");
                    if ($Qresult->num_rows() == 1) {
                        $values_collection[$x]["Card_id"] = $MembershipID;
                    } else {
                        $errors_collection[$y] = "Invalid Membership ID";
                        $access = 1;
                        $Error_transaction_date = $trans_date;
                    }
                }
                $y++;

                $Quantity = $csv_data[$col_Quantity];
                $values_collection[$x]["Quantity"] = $Quantity;
                $Item_Code = $csv_data[$col_Column_Item_Code];
                $values_collection[$x]["Item_Code"] = $Item_Code;


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
                                if ($Item_Code == "") {
                                    if ($row->Pos_Customerno == $MembershipID && $row->Pos_Billamt == $TransactionAmt) {
                                        $values_collection[$x]["Bill_no"] = $BillNo;
                                    } else {

                                        $errors_collection[$y] = "Same Bill No. is already exist";
                                        $access = 1;
                                        $Error_transaction_date = $trans_date;
                                        $values_collection[$x]["Bill_no"] = $BillNo;
                                    }
                                } else {
                                    if ($row->Pos_Customerno == $MembershipID && $Item_Code != $row->Column_Item_Code) {

                                        $values_collection[$x]["Bill_no"] = $BillNo;
                                    } else {

                                        $errors_collection[$y] = "Invalid Item Code";
                                        $access = 1;
                                        $Error_transaction_date = $trans_date;
                                        $values_collection[$x]["Bill_no"] = $BillNo;
                                    }
                                }
                            }
                        } else {

                            $values_collection[$x]["Bill_no"] = $BillNo;
                        }
                    }
                }
                $y++;

                $PaymentType = $csv_data[$col_payment];
                if ($PaymentType == "" || $PaymentType == null) {

                    $PaymentType = 1;
                } else {

                    $PaymentType = $PaymentType;
                }

                $values_collection[$x]["PaymentType"] = $PaymentType;
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
                        $Quantity = $values_collection[$m]["Quantity"]; // echo " Quantity--".$Quantity."<br>";
                        $PaymentType = $values_collection[$m]["PaymentType"]; // echo " PaymentType--".$PaymentType."<br>";

                        $error_query = "Insert into igain_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in,Error_row_no,Card_id,Transaction_date,Error_transaction_date,Bill_no,Transaction_amount,Status,Remarks) Values ('" . $Company_id . "','" . $filename . "','" . $filepath . "',0,'" . $transDate . "','" . $err . "','" . $lines . "','" . $Membership_ID . "','" . $transDate . "','" . $Error_transaction_date . "','" . $BillNo . "','" . $TransactionAmount . "','" . $Status . "','" . $Remarks . "') ";

                        $sql = $this->db->query($error_query);
                        //echo "--Insert_error_query---1111---".$this->db->last_query()." <br>";
                        $Total_error_count++;
                    }
                } else if ($access == 0) {

                    $m = 0;

                    $transDate = $values_collection[$m]['Transaction_date']; //echo " - transDate --".$transDate."<br>";
                    $Membership_ID = $values_collection[$m]["Card_id"]; //echo " Membership_ID--".$Membership_ID."<br>";
                    $BillNo = $values_collection[$m]["Bill_no"];  //echo " BillNo--".$BillNo."<br>";
                    $TransactionAmount = $values_collection[$m]["Transaction_amount"];  //echo " TransactionAmount--".$TransactionAmount."<br>";
                    $Status = $values_collection[$m]["Status"];  //echo " Status--".$Status."<br>";
                    $Remarks = $values_collection[$m]["Remarks"];  //echo " Remarks--".$Remarks."<br>";
                    $Quantity = $values_collection[$m]["Quantity"];  //echo " Quantity--".$Quantity."<br>";
                    $PaymentType = $values_collection[$m]["PaymentType"];  //echo " PaymentType--".$PaymentType."<br>";
                    $Item_Code = $values_collection[$m]["Item_Code"];  //echo " Item_Code--".$Item_Code."<br>";

                    $Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Pos_Payment_type,Pos_Quantity,Column_Item_Code,Remarks,Status) Values" . " ('" . $transDate . "','" . $Membership_ID . "','" . $BillNo . "','" . $TransactionAmount . "','" . $PaymentType . "','" . $Quantity . "','" . $Item_Code . "','" . $Remarks . "','" . $Status . "')";


                    $sql1 = $this->db->query($Insert_query);

                    //echo "--Insert_temp_query---".$this->db->last_query()." <br>";

                    $Success_row++;
                }
                // unset($Error_transaction_date);

                $Total_row++;
            }
            $Error_row = $Total_row - $Success_row;
        } else if ($extension == "xlsx" || $extension == "xls") {



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
            $PaymentType11 = $col_payment + 1;
            $product_code11 = $col_Column_Item_Code + 1;
            $trans_amount11 = $col_amt + 1;
            $quantity11 = $col_Quantity + 1;
            $BillNumber11 = $col_bill + 1;
            $Remarks11 = $col_remarks + 1;
            $Status11 = $col_Status + 1;




            // echo "----count-cells----".count($data->sheets[0]["cells"])."---<br><br>";

            for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {

                $transDate121 = $data->sheets[0]["cells"][$x][$transDate11];
                $MembershipId12 = $data->sheets[0]["cells"][$x][$MembershipId11];
                $PaymentType = $data->sheets[0]["cells"][$x][$PaymentType11];

                $product_code12 = $data->sheets[0]["cells"][$x][$product_code11];
                $trans_amount12 = $data->sheets[0]["cells"][$x][$trans_amount11];

                $quantity12 = $data->sheets[0]["cells"][$x][$quantity11];

                $BillNumber12 = $data->sheets[0]["cells"][$x][$BillNumber11];
                $Remarks12 = $data->sheets[0]["cells"][$x][$Remarks11];
                $Status12 = $data->sheets[0]["cells"][$x][$Status11];


                // echo "----transDate121-----".$transDate121."---<br><br>";

                $transDate122 = str_replace('/', '-', $transDate121);

                // echo "----transDate122-----".$transDate122."---<br><br>";

                $date_format = $Column_date_format;
                $temp_trans_date = $transDate122;


                // echo "----date_format-----". $date_format."--<br><br>";
                // echo "----temp_trans_date-----".$temp_trans_date."---<br><br>";

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


                    // $date_formated = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($temp_trans_date));
                    // echo "----date_formated-----". $date_formated."----<br><br>";
                }

                // echo "----trans_date-----". $trans_date."----<br><br>";


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
                  echo " <br><br>******************<br><br>"; */


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
                } else {


                    // $sql_out1 = $this->db->query("select Trans_id from  igain_transaction where (Bill_no ='".$BillNumber12."' OR Manual_billno ='".$BillNumber12."' ) and Card_id='".$MembershipId12."'  and Company_id='".$Company_id."'");

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
                                } else {
                                    if ($row->Pos_Customerno == $MembershipId12 && $product_code12 != $row->Column_Item_Code) {

                                        $BillNumber12 = $BillNumber12;
                                    } else {

                                        $get_error[] = "Invalid Item Code";
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

                    if ($trans_date == "" || $trans_date == "1970-01-01 00:00:00" || $trans_date == "1970-01-01" || $trans_date == "1970-01-01 01:00:00") {
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
                    }
                }

                if ($PaymentType == "") {
                    $PaymentType = 1;
                }

                if ($quantity12 == "") {
                    $quantity12 = 0;
                }


                if ($access == 1) {

                    $error_count = count($get_error);
                    foreach ($get_error as $err) {


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

                        $error_query = "Insert into igain_flatfile_error_log(Company_id,File_name,File_path,Status_id,Date,Error_in,Error_row_no,Card_id,Transaction_date,Error_transaction_date,Bill_no,Transaction_amount,Status,Remarks) Values ('" . $Company_id . "','" . $filename . "','" . $filepath . "',0,'" . $trans_date . "','" . $err . "','" . $lines . "','" . $MembershipId12 . "','" . $trans_date . "','" . $Error_transaction_date . "','" . $BillNumber12 . "','" . $trans_amount12 . "','" . $Status12 . "','" . $Remarks12 . "') ";


                        $sql = $this->db->query($error_query);
                        // echo "--Insert_error_query---1111---".$this->db->last_query()." ---<br><br>";
                        $Total_error_count++;
                    }
                } else if ($access == 0) {




                    /* echo " ------access------".$access."-----------<br><br><br>";

                      echo " ------trans_date------".$trans_date."-----------<br><br>";
                      echo " ------MembershipId12------".$MembershipId12."-----------<br><br>";
                      echo " ------BillNumber12------".$BillNumber12."-----------<br><br>";
                      echo " ------trans_amount12------".$trans_amount12."-----------<br><br>";
                      echo " ------PaymentType------".$PaymentType."-----------<br><br>";
                      echo " ------quantity12------".$quantity12."-----------<br><br>";
                      echo " ------product_code12------".$product_code12."-----------<br><br>";
                      echo " ------Remarks12------".$Remarks12."-----------<br><br>";
                      echo " ------Status12------".$Status12."-----------<br><br>"; */

                    $Insert_query = "Insert into $temp_tbl (Pos_Transdate,Pos_Customerno,Pos_Billno,Pos_Billamt,Pos_Payment_type,Pos_Quantity,Column_Item_Code,Remarks,Status) Values" . " ('" . $trans_date . "','" . $MembershipId12 . "','" . $BillNumber12 . "','" . $trans_amount12 . "','" . $PaymentType . "','" . $quantity12 . "','" . $product_code12 . "','" . $Remarks12 . "','" . $Status12 . "')";


                    $sql1 = $this->db->query($Insert_query);
                    // echo "----query---".$this->db->last_query()."---<br>";

                    $Success_row++;
                }
                $Total_row++;
                unset($get_error);
            }
            $Error_row = $Total_row - $Success_row;
            /* echo " ------Total_row------".$Total_row."-----------<br><br><br>";
              echo " ------Success_row------".$Success_row."-----------<br><br><br>";
              echo " ------Error_row------".$Error_row."-----------<br><br><br>"; */
        } else {
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
        } else {
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

    /* function get_file_erro_status($file_status,$Company_id)
      {
      $this->db->select("File_name,Upload_status,Error_status");
      $this->db->from("igain_file_upload_status");
      $this->db->where(array('Company_id' => $Company_id, 'Status_id'=> $file_status));

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
      } */

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

    function get_file_error_status_1($file_status, $Company_id) {
        $this->db->select("*");
        // $this->db->select("File_name,Upload_status,Error_status");
        $this->db->from("igain_file_upload_status");
        $this->db->where(array('Company_id' => $Company_id, 'Status_id' => $file_status));
        // $this->db->group_by('Error_row_no');
        $queryOPT = $this->db->get();

        // echo"---get_file_error_status_1---".$this->db->last_query();

        if ($queryOPT->num_rows() > 0) {
            foreach ($queryOPT->result() as $roww) {
                $data[] = $roww;
            }
            return $data;
        }
        return false;
    }

    function Drop_upload_file_data($Logged_user_enrollid) {
        $temp_tbl = $Logged_user_enrollid . 'uploadtempdatatbl';

        $this->db->query("DROP TABLE " . $temp_tbl);
    }

    /*     * *************************** Sandeep Work End ******************************* */

    public function get_loyaltyrule_details($Loyalty_names, $Company_id, $selected_seller) {
        /* $this->db->from("igain_loyalty_master");
          $this->db->where(array('Loyalty_id' => $lp_id));
         */
        $this->db->from("igain_loyalty_master");
        $this->db->where_in('Loyalty_name', $Loyalty_names);
        $this->db->where(array('Company_id' => $Company_id, 'Seller' => $selected_seller, 'Active_flag' => 1));
        $edit_sql = $this->db->get();
        //echo"-------get_loyaltyrule_details----".$this->db->last_query()."---<br><br>";
        if ($edit_sql->num_rows() > 0) {
            return $edit_sql->result_array();
        } else {
            return false;
        }
    }

    function Get_Merchandize_Item_details($Item_Code, $Company_id) {
        $Todays_date = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('igain_company_merchandise_catalogue');
        // $this->db->join('igain_merchandize_item_size_child AS B','B.Company_merchandize_item_code=A.Company_merchandize_item_code AND A.Company_id=B.Company_id');
        $this->db->like('Company_merchandize_item_code', $Item_Code);
        $this->db->where(array('Company_id' => $Company_id, 'Active_flag' => 1, 'Valid_from <=' => $Todays_date, 'Valid_till >=' => $Todays_date,));
        $sql = $this->db->get();
        // echo"----Item SQL-------".$this->db->last_query()."---<sql>";
        if ($sql->num_rows() > 0) {
            return $sql->row();
        } else {
            return false;
        }
    }

    function Insert_billing_customer_records($seller_id, $billing_data) {
        $temp_tbl = $seller_id . 'billing_temp_table';
        $this->load->helper('date');
        $this->load->dbforge();

          /* if( $this->db->table_exists($temp_tbl) == TRUE )
          {
            $this->dbforge->drop_table($temp_tbl);
          } */

        error_reporting(0);
        $fields = array(
            'Bill_id' => array('type' => 'INT', 'constraint' => '11', 'auto_increment' => TRUE),
            'Bill_Transdate' => array('type' => 'datetime'),
            'Bill_Customerno' => array('type' => 'VARCHAR', 'constraint' => '50','null' => TRUE),
            'Billno' => array('type' => 'VARCHAR', 'constraint' => '50'),'null' => TRUE,
            'Bill_Quantity' => array('type' => 'INT', 'constraint' => '11','DEFAULT' => 0),
            'Bill_Item_Code' => array('type' => 'VARCHAR', 'constraint' => '200','null' => TRUE),
            'Bill_purchsed_amount' => array('type' => 'DECIMAL', 'constraint' => '25,2'),
            'Bill_amount' => array('type' => 'DECIMAL', 'constraint' => '25,2','DEFAULT' => 0),
            'Loyalty_pts' => array('type' => 'DECIMAL', 'constraint' => '25,2','DEFAULT' => 0),
            'Remarks' => array('type' => 'VARCHAR', 'constraint' => '200','null' => TRUE),
            'Status' => array('type' => 'VARCHAR', 'constraint' => '100','null' => TRUE),
            'Seller_name' => array('type' => 'VARCHAR', 'constraint' => '100','null' => TRUE),
            'Seller_id' => array('type' => 'INT', 'constraint' => '11','DEFAULT' => 0),
            'Payment_type_id' => array('type' => 'INT', 'constraint' => '11','DEFAULT' => 0),
        );


        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('Bill_id', TRUE);
        // gives PRIMARY KEY (upload_id)
        $this->dbforge->create_table($temp_tbl, TRUE);
        $this->db->insert($temp_tbl, $billing_data);
        $mv_inserted_id = $this->db->insert_id();
    }

    function DropBillingTable($seller_id) {

        $temp_tbl = $seller_id.'billing_temp_table';
		
		if( $this->db->table_exists($temp_tbl) == TRUE )
		{
            // $this->dbforge->drop_table($temp_tbl);
			
			
			$this->load->helper('date');
			$this->load->dbforge();
			$this->dbforge->drop_table($temp_tbl);
			
		}
    }

    function Fetch_billing_customer_records($seller_id) {
        /* $temp_tbl = $seller_id.'billing_temp_table';
          $this->load->helper('date');
          $this->load->dbforge();
          $this->dbforge->drop_table($temp_tbl); */

        $temp_tbl = $seller_id . 'billing_temp_table';
        $this->db->select(" * ");
        $this->db->from($temp_tbl);
        $BillSql = $this->db->get();
        if ($BillSql->num_rows() > 0) {
            foreach ($BillSql->result() as $roww) {
                $data[] = $roww;
            }
            return $data;
        }
        return false;
    }
	function Fetch_billing_customer_records_2($seller_id,$Bill_no_array) {
        /* $temp_tbl = $seller_id.'billing_temp_table';
          $this->load->helper('date');
          $this->load->dbforge();
          $this->dbforge->drop_table($temp_tbl); */

        $temp_tbl = $seller_id . 'billing_temp_table';
        $this->db->select(" * ");
        $this->db->from($temp_tbl);
		// $this->db->where_in('Billno' array($Bill_no_array));
		$this->db->where_in('Billno',$Bill_no_array);
        $BillSql = $this->db->get();
		// echo"---sql----".$this->db->last_query()."---<br>";
        if ($BillSql->num_rows() > 0) {
            foreach ($BillSql->result() as $roww) {
                $data[] = $roww;
            }
            return $data;
        }
        return false;
    }

    public function Insert_merchant_bill_data($insertBill) {
        $this->db->insert('igain_merchant_billing', $insertBill);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>
