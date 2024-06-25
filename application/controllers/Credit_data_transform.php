<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  error_reporting(0);
class Credit_data_transform extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->model('Credit_data_transform/Credit_data_map');
		$this->load->model('Coal_transactions/Coal_Transactions_model');
		$this->load->model('Igain_model');
		$this->load->model('Data_transform/Data_transform_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->library("excel");
		$this->load->library('m_pdf');
		$this->load->library('Send_notification');
	}
	public function Credit_data_mapping()
	{
		if($this->session->userdata('logged_in'))
		{			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$data['Company_name'] = $session_data['Company_name'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			// $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);			
			$data['Sub_seller_Enrollement_id'] = $session_data['Sub_seller_Enrollement_id'];
			
			$data['All_brands'] = $this->Igain_model->get_company_sellers($Company_id);
			
			
					
			
				
			$data["results"] = $this->Credit_data_map->data_map_list($Company_id,$data['Super_seller'],$Logged_user_enrollid,$data['Sub_seller_Enrollement_id']);
			
			$this->load->view("Credit_data_transform/Credit_data_mapping",$data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function insert_data_map()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			
			$Outlets = $this->input->post('Column_outlet_id');
			/********************************************************************/
			$exist_merchant_array=array();
			
			
				// $get_seller_name = $this->Igain_model->get_enrollment_details($Column_outlet_id);
				// $Merchant= $get_seller_name->First_name;
				// $result_count = $this->Credit_data_map->check_exist_data_map_seller($Column_outlet_id,$Company_id);
				//echo "count-->".$result_count;die;
				// if($result_count==0)
				// {
				$post_data['Column_Company_id'] = $Company_id;
				$post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id');
				
				$post_data['Column_Date'] = $this->input->post('Column_Date');
				$post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
				$post_data['Column_Membership_ID'] = $this->input->post('Column_Membership_ID');
				$post_data['Column_Bill_no'] = $this->input->post('Column_Bill_no');
				$post_data['Column_Amount'] = $this->input->post('Column_Credit_Points');
				$post_data['Column_remarks'] = $this->input->post('Column_Remarks');
				
				$Seller_id = $this->input->post('Column_Seller_id');
				$Company_id = $this->input->post('Column_Company_id');
				$post_data['Column_date_format'] = 'Y-m-d';
				$post_data['Data_map_for'] = '3';
				$exist_outlet_array = array();	
				
				if(is_numeric($_REQUEST['Column_Seller_id']) != 1  || is_numeric($_REQUEST['Column_header_rows']) != 1  || is_numeric($_REQUEST['Column_Bill_no']) != 1  || is_numeric($_REQUEST['Column_Credit_Points']) != 1  ||  is_numeric($_REQUEST['Column_Date']) != 1   || is_numeric($_REQUEST['Column_Remarks']) != 1  || is_numeric($_REQUEST['Column_Membership_ID']) != 1)
				{
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Credit_data_transform/Credit_data_mapping', 'refresh');	
				}
				
				if($Outlets!=NULL && $Outlets[0] > 0)
				{
					foreach($Outlets as $outlet_id)
					{
						$get_seller_name = $this->Igain_model->get_enrollment_details($outlet_id);
						$MerchantFName = $get_seller_name->First_name.' '.$get_seller_name->Last_name;
						
						$result_count2 = $this->Credit_data_map->check_exist_data_map_seller($outlet_id, $Company_id);
						// echo $result_count2;die;
						if ($result_count2 == 0) {
						  
							$post_data['Column_outlet_id'] = $outlet_id;
							
							
							$result222 = $this->Credit_data_map->insert_data_map($post_data);
						  $flag = 1;
						} else {
							
						  array_push($exist_outlet_array, $MerchantFName);
						  $Join_names = implode(",", $exist_outlet_array);
						}
					
						
					}
					 if (count($exist_outlet_array) == 0)
					{
						
						/*******************Insert igain Log Table*********************/
						$session_data = $this->session->userdata('logged_in');
						$get_seller = $this->Igain_model->get_enrollment_details($data['enroll']);
						$Enrollement_id= $get_seller->Enrollement_id;
						$First_name= $get_seller->First_name;
						$Last_name= $get_seller->Last_name;
						$session_data = $this->session->userdata('logged_in');
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Credit Transaction Data Mapping";
						$where="Credit Transaction Data Mapping";
						$toname="";
						$to_seller = $this->Igain_model->get_enrollment_details($Seller_id);
						$To_enrollid= $to_seller->Enrollement_id;
						$firstName= $to_seller->First_name;
						$lastName= $to_seller->Last_name;
						$Seller_name = $session_data['Full_name'];
						$opval = 'Credit Transaction Data Mapping';
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
						$this->session->set_flashdata("success_code","Credit Transaction data map created Successfuly!!");
					}
					elseif (count($exist_outlet_array) != 0 && $flag == 1) {
					$this->session->set_flashdata("success_code", "Data map created Successfuly!!!<br>Data map already exist for Outlet(s) ($Join_names) !!!");
				  } elseif (count($exist_outlet_array) != 0 && $flag == 0) {
					$this->session->set_flashdata("error_code", "Data map already exist for Outlet(s)  !!!");
				  }else
					{
						$this->session->set_flashdata("error_code","Credit Transaction data map not created Successfuly!!");
					}
				}
				else
				{
					$this->session->set_flashdata("error_code","Error, please select at least one Outlet(s)");
				}
				/* }
				else
				{
					$this->session->set_flashdata("error_code","Enrollment data map already exist for Merchant ($Merchant)!!");
				} */
						 
			redirect('Credit_data_transform/Credit_data_mapping');
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function edit_data_map()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$data['Sub_seller_Enrollement_id'] = $session_data['Sub_seller_Enrollement_id'];
			$data['All_brands'] = $this->Igain_model->get_company_sellers($Company_id);
			$data['All_outlets'] = $this->Igain_model->get_company_sellers_and_staff($Company_id);
			
			$data["results"] = $this->Credit_data_map->data_map_list($Company_id,$data['Super_seller'],$Logged_user_enrollid,$data['Sub_seller_Enrollement_id']);
			
			$Map_id=$_GET['Map_id'];	
			$Map_id = $_SESSION[$Map_id];
			if(is_numeric($Map_id) != 1 )
			{
				
				$this->session->set_flashdata("error_code","Invalid data");
				redirect('Credit_data_transform/Credit_data_mapping', 'refresh');	
			}	
			$data["Records"] = $this->Credit_data_map->get_data_mapping($Map_id);
			
			$this->load->view("Credit_data_transform/edit_credit_data_mapping",$data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function update_data_map()
	{
		if($this->session->userdata('logged_in'))
		{
			
			$post_data['Column_Date'] = $this->input->post('Column_Date');
			$post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
			$post_data['Column_Membership_ID'] = $this->input->post('Column_Membership_ID');
			$post_data['Column_Bill_no'] = $this->input->post('Column_Bill_no');
			$post_data['Column_Amount'] = $this->input->post('Column_Credit_Points');
			$post_data['Column_Remarks'] = $this->input->post('Column_Remarks');
			
			$post_data['Data_map_for'] = '3';
			if( is_numeric($_REQUEST['Column_header_rows']) != 1  || is_numeric($_REQUEST['Column_Bill_no']) != 1  || is_numeric($_REQUEST['Column_Credit_Points']) != 1  ||  is_numeric($_REQUEST['Column_Date']) != 1   || is_numeric($_REQUEST['Column_Remarks']) != 1  || is_numeric($_REQUEST['Column_Membership_ID']) != 1)
				{
					$this->session->set_flashdata("error_code","Invalid data");
					redirect('Credit_data_transform/Credit_data_mapping', 'refresh');	
				}
			/********************************************************************/
			$Map_id = $_SESSION['Map_id'];			
			$result222 = $this->Credit_data_map->update_data_map($post_data,$Map_id);
			
			/*******************Insert igain Log Table*********************/
			$session_data = $this->session->userdata('logged_in');
			$get_seller = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enrollement_id= $get_seller->Enrollement_id;
			$First_name= $get_seller->First_name;
			$Last_name= $get_seller->Last_name;
			$session_data = $this->session->userdata('logged_in');
			$Company_id	= $session_data['Company_id'];
			$Todays_date = date('Y-m-d');	
			$opration = 2;		
			$enroll	= $session_data['enroll'];
			$username = $session_data['username'];
			$userid=$session_data['userId'];
			$what="Update Enrollement Data Mapping";
			$where="Enrollement Data Mapping";
			$toname="";
			$to_seller = $this->Igain_model->get_enrollment_details($this->input->post('Column_Seller_id'));
			$To_enrollid= $to_seller->Enrollement_id;
			$firstName= $to_seller->First_name;
			$lastName= $to_seller->Last_name;
			$Seller_name = $session_data['Full_name'];
			$opval = 'Update Enrollement Data Mapping';
			$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
			/*******************Insert igain Log Table*********************/
			
			$this->session->set_flashdata("success_code","Credit Transaction data map Updated Successfuly!!");
			
			redirect('Credit_data_transform/Credit_data_mapping');
		}
		else
		{
			// redirect('Login', 'refresh');
		}
	}
	public function delete_data_mapping()
	{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$Map_id=$_GET['Map_id'];	
			$Map_id = $_SESSION[$Map_id];
			if(is_numeric($Map_id) != 1 )
			{
				
				$this->session->set_flashdata("error_code","Invalid data");
				redirect('Credit_data_transform/Credit_data_mapping', 'refresh');	
			}	
			$Records= $this->Credit_data_map->get_data_mapping($Map_id);
			$Seller_id=$Records->Column_Seller_id;
			$this->Credit_data_map->delete_data_mapping($Map_id);
			$this->session->set_flashdata("success_code","Data map deleted Successfuly!!");
			
			/*******************Insert igain Log Table*********************/
			$session_data = $this->session->userdata('logged_in');
			$get_seller = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Enrollement_id= $get_seller->Enrollement_id;
			$First_name= $get_seller->First_name;
			$Last_name= $get_seller->Last_name;
			$session_data = $this->session->userdata('logged_in');
			$Company_id	= $session_data['Company_id'];
			$Todays_date = date('Y-m-d');	
			$opration = 3;		
			$enroll	= $session_data['enroll'];
			$username = $session_data['username'];
			$userid=$session_data['userId'];
			$what="Delete Enrollement Data Mapping";
			$where="Enrollement Data Mapping";
			$toname="";
			$to_seller = $this->Igain_model->get_enrollment_details($Seller_id);
			$To_enrollid= $to_seller->Enrollement_id;
			$firstName= $to_seller->First_name;
			$lastName= $to_seller->Last_name;
			$Seller_name = $session_data['Full_name'];
			$opval = 'Delete Enrollement Data Mapping';
			$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
			/*******************Insert igain Log Table*********************/
		redirect('Credit_data_transform/Credit_data_mapping', 'refresh');	
	}
	public function upload_data() 
	{
      if ($this->session->userdata('logged_in')) 
	  {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        //echo "-----Company_id---".$data['Company_id'];
        $data['Super_seller'] = $session_data['Super_seller'];
        $data['userId'] = $session_data['userId'];
        $data['Sub_seller_Enrollement_id'] = $session_data['Sub_seller_Enrollement_id'];

        $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

        if ($_POST == NULL) 
		{
			$data['FinSub_seller_Enrollement_id'] = 0;
			if($Logged_user_id==7)//Finanace
			{
				$user_details = $this->Igain_model->get_enrollment_details($data['Sub_seller_Enrollement_id']);
				$data['FinSub_seller_Enrollement_id'] = $user_details->Sub_seller_Enrollement_id;

			}
			$data['All_brands'] = $this->Igain_model->get_company_sellers($Company_id);
			$this->load->view("Credit_data_transform/upload_data_file", $data);
		  
		} 
		else 
		{	
			$seller_id = $this->input->post('outlet_id');
			$Brand_id = $this->input->post('Column_Seller_id');
			
			if($seller_id !="" || $seller_id !=0)
			{
				$result_count = $this->Credit_data_map->check_exist_data_map_seller($seller_id, $Company_id);
				
				if ($result_count <= 0) {
					$file_status_session = array(
					   'seller_id'          => $seller_id
					 );
					$this->session->set_userdata('file_status_session',$file_status_session);
					
					$this->session->set_flashdata("error_code", "The Merchant has not been created flat file data mapping for Credit transaction ");
					redirect('Credit_data_transform/upload_data');
				} 
				  /* -----------------------File Upload--------------------- */
				  $config['upload_path'] = './Data_uploads/';
				  $config['allowed_types'] = 'xlsx|xls|csv';
				  $config['max_size'] = '1000';
				  $config['max_width'] = '1920';
				  $config['max_height'] = '1280';
				  $config['encrypt_name'] = 'false';
				  $config['overwrite'] = 'true';

				  $this->load->library('upload', $config);
				  $this->upload->initialize($config);

				  $configThumb = array();
				  $configThumb['image_library'] = 'gd2';
				  $configThumb['source_image'] = '';
				  $configThumb['create_thumb'] = TRUE;
				  $configThumb['maintain_ratio'] = TRUE;

				  $configThumb['width'] = 128;
				  $configThumb['height'] = 128;
				/* Load the image library */
				$this->load->library('image_lib');


				$upload22 = $this->upload->do_upload('file');
				$data22 = $this->upload->data();
				if ($data22['is_image'] == 1) 
				{
					$filepath = "";
					$filename = "";
					$block_me = 0;
				}
				else
				{
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './Data_uploads/' . $upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath = 'Data_uploads/' . $data22['file_name'];
					$filename = $data22['file_name'];
					$block_me = 1;
				}
			 
				// echo "block_me--".$block_me."----filename---".$filename."----filepath---".$filepath; die;
				  /* -----------------------File Upload--------------------- */

				  $data['LogginUserName'] = $session_data['Full_name'];

				  $seller_id = $this->input->post('outlet_id');
				$Brand_id = $this->input->post('Column_Seller_id'); 	
				
				  $get_selected_sellers = $this->Igain_model->get_enrollment_details($seller_id);
				  $data['seller_id'] = $get_selected_sellers->Enrollement_id;
				  $data['Selected_seller_name'] =$get_selected_sellers->First_name . ' ' . $get_selected_sellers->Last_name;

				  $file_status = $this->Credit_data_map->upload_data_map_file($filepath, $filename, $Company_id, $seller_id);

					$file_status_session = array(
					   'file_status'       => $file_status['Upload_status'],
					   'Total_error_count' => $file_status['Total_error_count'],
					   'Total_row'         => $file_status['Total_row'],
					   'Error_row'         => $file_status['Error_row'],
					   'Success_row'       => $file_status['Success_row'],
					   'filename'          => $filename,
					   'seller_id'          => $seller_id
					 );
					$this->session->set_userdata('file_status_session',$file_status_session);
					
					
					$file_session_data = $this->session->userdata('file_status_session');	
					

				  $data['file_status'] = $file_status['Upload_status'];
				  $data['Total_error_count'] = $file_status['Total_error_count'];
				  $data['Total_row'] = $file_status['Total_row'];
				  $data['Error_row'] = $file_status['Error_row'];
				  $data['Success_row'] = $file_status['Success_row'];
				  $data['filename'] = $filename;



				  $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);


				  $data['UploadData'] = $this->Credit_data_map->get_upload_file_data($seller_id);
				  $data['UploadData2'] = $this->Credit_data_map->get_upload_file_data_for_transaction($seller_id);
				  $data['Upload_errors'] = $this->Credit_data_map->get_upload_errors($filename, $Company_id);
				  // $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id, $_REQUEST['Column_Seller_id'], $Logged_user_id);
				
				if($this->upload->display_errors())
				{
					$this->session->set_flashdata("error_code",$this->upload->display_errors());
				}
				else
				{
					$this->session->set_flashdata("success_code", "Data File is Uploaded Successfully, Please verify all data given table below..!!");
				}
				
				  $data['Company_id'] = $session_data['Company_id'];
				  $data['Super_seller'] = $session_data['Super_seller'];
				  $data['enroll'] = $session_data['enroll'];
				  $data['outlet_id'] = $seller_id;
				  $data['Brand_id'] = $Brand_id;

				  $this->load->view("Credit_data_transform/verify_data_file", $data);
				  
			}else{
				
				$this->session->set_flashdata("error_code", "The Merchant has not been selected for flat file transaction ");
				redirect('Credit_data_transform/upload_data');
			}
        }
      } else {
        redirect('Login', 'refresh');
      }
    }
	public function verify_data_file() 
	{ 
      if ($this->session->userdata('logged_in')) 
	  {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['enroll'] = $session_data['enroll'];
        $Logged_user_enrollid = $session_data['enroll'];
        $data['Company_id'] = $session_data['Company_id'];
        $Logged_user_id = $session_data['userId'];
        $Company_id = $session_data['Company_id'];
        $data['LogginUserName'] = $session_data['Full_name'];
        $data['timezone_entry'] = $session_data['timezone_entry'];
        $data['userId'] = $session_data['userId'];
        $data['Super_seller'] = $session_data['Super_seller'];
      
        $company_details2 = $this->Igain_model->get_company_details($Company_id);
        $Coalition_points_percentage = $company_details2->Coalition_points_percentage;
        $Company_finance_email_id = $company_details2->Company_finance_email_id;
        $data["Company_details"] = $company_details2;

		$file_session_data = $this->session->userdata('file_status_session');	
			
        if ($_POST == NULL) 
		{
			$filename=$file_session_data['filename'];
			$seller_id=$file_session_data['seller_id'];
			// $seller_id=$_REQUEST['seller_id'];
			$data['filename'] = $filename;
			
			$result_count = $this->Credit_data_map->check_exist_data_map_seller($seller_id, $Company_id);
				
			if ($result_count <= 0) 
			{
				$this->session->set_flashdata("error_code", "The Merchant has not been created flat file data mapping for Credit transaction ");
				redirect('Credit_data_transform/upload_data');
			}
			$data['UploadData'] = $this->Credit_data_map->get_upload_file_data($seller_id);		
		
			$data['Upload_errors'] = $this->Credit_data_map->get_upload_errors($filename, $Company_id);
			
			 $get_selected_sellers = $this->Igain_model->get_enrollment_details($seller_id);
			 
			$data['seller_id'] = $get_selected_sellers->Enrollement_id;
			$data['outlet_id'] = $get_selected_sellers->Enrollement_id;
			$Brand = $get_selected_sellers->Sub_seller_Enrollement_id;
			$data['Brand_id'] = $get_selected_sellers->Sub_seller_Enrollement_id;
			$data['Selected_seller_name'] =$get_selected_sellers->First_name . ' ' . $get_selected_sellers->Last_name;
			  
			$this->load->view("Credit_data_transform/verify_data_file", $data);  
        } 
		else
		{
			$Total_error_count =$file_session_data["Total_error_count"];
			$Total_row = $file_session_data["Total_row"];
			$Error_row = $file_session_data["Error_row"];
			$Success_row = $file_session_data["Success_row"];
			$seller_id = $file_session_data["seller_id"];

			$data["DataMaping"] = $this->Credit_data_map->get_datamaping_details($Company_id, $Logged_user_id, $seller_id);
         
          $get_sellers = $this->Igain_model->get_company_sellers($Company_id);
          $data['Seller_array'] = $get_sellers;
		  
		   /* -------------Billing Bill No------------------- */
				$get_selected_sellers = $this->Igain_model->get_enrollment_details($seller_id); 
				$tp_db_bill = $get_selected_sellers->Seller_Billing_Bill_no;
				$len_bill = strlen($tp_db_bill);
				$str_bill = substr($tp_db_bill, 0, 5);
				$billing_bill = substr($tp_db_bill, 5, $len_bill);
				$billing_bill_no = $billing_bill + 1;
            /* -------------Billing Bill No------------------- */

          $UploadData = $this->Credit_data_map->get_upload_file_data_for_transaction($seller_id); 

			foreach ($UploadData as $row) 
			{
				$cardId = $row->Pos_Customerno;
				$manual_bill_no = $row->Pos_Billno;
				$bal_pay = $row->Pos_Billamt;
				$Pos_Transdate = $row->Pos_Transdate;
				$Flatfile_remarks = $row->Remarks;
				$Remarks = $row->Remarks;
				$Status = $row->Status;
				
				$cust_details = $this->Coal_Transactions_model->cust_details_from_card($Company_id,$cardId);
				// $cust_details = $this->Coal_Transactions_model->cust_details_from_card_active_inactive($Company_id, $cardId);
				foreach ($cust_details as $row25) 
				{
					  $card_bal = $row25['Current_balance'];
					  $Customer_enroll_id = $row25['Enrollement_id'];
					  $topup = $row25['Total_topup_amt'];
					  $purchase_amt = $row25['total_purchase'];
					  $reddem_amt = $row25['Total_reddems'];
					  $member_Tier = $row25['Tier_id'];
					  $Refree_enroll_id = $row25['Refrence'];
					  $City_id = $row25['City'];
					  $State_id = $row25['State'];
					  $Country_id = $row25['Country'];
					  $Date_of_birth = $row25['Date_of_birth'];
					  $Sex = $row25['Sex'];
					  $District = $row25['District'];
					  $Zipcode = $row25['Zipcode'];
					  $total_purchase = $row25['total_purchase'];
					  $Total_reddems = $row25['Total_reddems'];
					  $joined_date = $row25['joined_date'];
				}
				
			    $Todays_date = date("Y-m-d");
			    $lv_date_time = $Todays_date;
				
				$get_selected_sellers = $this->Igain_model->get_enrollment_details($seller_id);
				$tp_db = $get_selected_sellers->Topup_Bill_no;
			   
				$len = strlen($tp_db);
				$str = substr($tp_db, 0, 5);
				$bill = substr($tp_db, 5, $len);
				$bill_no = $bill + 1;

				$curr_bal = $card_bal + $bal_pay;
			   
				$post_data = array(
					'Trans_type' => '1',
					'Company_id' => $Company_id,
					'Topup_amount' => $bal_pay,      
					'Trans_date' => $lv_date_time,
					'Card_id' => $cardId,
					'Seller_name' => $Seller_name,
					'Seller' => $seller_id,
					'Enrollement_id' => $Customer_enroll_id,
					'Bill_no' => $bill,
					'Manual_billno' => $manual_bill_no,
					'Remarks' => "FlatFile", //'FlatFile'
					'Flatfile_remarks' => $Flatfile_remarks,
					'Create_user_id' => $data['enroll'],
					'Source' => 0,
					'Available_balance' => $curr_bal
				);

				$insert_transaction_id = $this->Coal_Transactions_model->insert_loyalty_transaction($post_data);
				
				$curr_bal1 = $curr_bal;

				$topup_amt = $topup+$bal_pay;
				
				$purchase_amount = $purchase_amt;
				$reddem_amount = $reddem_amt;

				$result2 = $this->Coal_Transactions_model->update_customer_balance($cardId, $curr_bal1, $Company_id, $topup_amt, $lv_date, $purchase_amount, $reddem_amount);

				$billno_withyear = $str . $bill_no;

			  
				$result4 = $this->Coal_Transactions_model->update_billno($seller_id, $billno_withyear);


				// $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
				// $Symbol_currency = $currency_details->Symbol_of_currency;

				$Email_content = array(
				'Todays_date' => $lv_date_time,
				'topup_amt' => $bal_pay,
				'manual_bill_no' => $manual_bill_no,
				'Notification_type' => 'Credit ' . $data['Company_details']->Currency_name,
				'Remarks' => $Flatfile_remarks, 
				'Template_type' => 'Issue_bonus'
				);
				$this->send_notification->send_Notification_email($Customer_enroll_id, $Email_content, $seller_id, $Company_id);

				// if (($insert_transaction_id > 0) && ($result2 == true) && ($result4 == true)) {
				if (($insert_transaction_id > 0) ) {
				  $abc_array[] = 1;
				} else {
				  $abc_array[] = 0;
				}
				//-------------------------Insertion---------------------------------/			
			}
		// echo "<br>insert_transaction_id ".$insert_transaction_id;
		// echo "<br>result2 ".$result2;
		// echo "<br>result4 ".$result4;
		// $seller_id = $this->input->post("seller_id");
		$Total_error_count =$file_session_data["Total_error_count"];
		$Total_row = $file_session_data["Total_row"];
		$Error_row = $file_session_data["Error_row"];
		$Success_row = $file_session_data["Success_row"];
		$file_status = $file_session_data["file_status"];
		$filename = $file_session_data["filename"];
		$File_name = $file_session_data["filename"];
		$seller_id = $file_session_data["seller_id"];
		
        $Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
        $Super_Seller_pin = $Super_Seller->pinno;
   /*------------------------------------------------Send Errors File--------------------------------------------------*/
          $seller_details2 = $this->Igain_model->get_enrollment_details($seller_id);
          $Seller_balance = $seller_details2->Current_balance;
          $Seller_name = $seller_details2->First_name . " " . $seller_details2->Last_name;

 
          $data['file_error_details'] = $this->Credit_data_map->get_file_error_status($file_status, $Company_id);

          foreach ($data['file_error_details'] as $status) {

            $Total_row_uploads = $status->Total_row;
            $Total_Success_row = $status->Success_row;
            $Total_Error_row = $status->Error_row;
          }

          $Bill_File_name = $File_name;
          $data['File_name'] = $File_name;
          $Error_File_name = $seller_id . 'ERROR_' . date('Y_m_d_H_i_s');


          $Export_file_name = $seller_id . "Uploaded-Error-File";
          $data['Export_file_name'] = $Seller_name . " Uploaded Error File";

          $data['Seller_name'] = $Seller_name;
          $data['Company_logo'] = base_url() . '/' . $company_details2->Company_logo;

          $htmlErrors = $this->load->view('Credit_data_transform/pdf_uploaded_error_file', $data, true);
          // echo $htmlErrors;
		// print_r($data["DataMaping"]);
		
          /* echo"<br><br>---Error Records---Error_in-".count($data['file_error_details'])."-<br><br>";			
            die; */
          $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
          $error_file_path = "";
          // if(!empty($data['file_error_details']) && $Total_Error_row > 0)
          if ($Total_Error_row > 0) {

            $pdf = new mPDF();
            $pdf->setFooter('{PAGENO}');

            $pdf->setAutoTopMargin = 'pad';


            $pdf->SetHTMLHeader('<header class="clearfix"><h1>File Errors</h1><div id="project"><div>Merchant Name: ' . $Seller_name . '</div><div>Merchant ID:  ' . $seller_id . '</div><div>File Name:  ' . $File_name . '</div><div>Processed Date: ' . date("j, F Y h:i:s A") . '</div></div></header> <br><br>', '', true);

            $pdf->WriteHTML($htmlErrors);
            $error_file_path = $pdf->Output($DOCUMENT_ROOT . '/export/Seller_errors_files/' . $Error_File_name . '.pdf', 'F');
            $pdf->Output($DOCUMENT_ROOT . '/export/Seller_errors_files/' . $Error_File_name . '.pdf', 'F');
            $error_file_path = $DOCUMENT_ROOT . '/export/Seller_errors_files/' . $Error_File_name . '.pdf';
            unset($pdf);
          }
			
          /* ------------------------------------------------Send Errors File-------------------------------------------------- */
          /* ------------------------------------------------Send Annexure File-------------------------------------------------- */

          /* ------------------------------------------------Send Annexure File-------------------------------------------------- */
          /* ------------------------------------------------Send Billing File-------------------------------------------------- */

          /* ------------------------------------------------Send Billing File-------------------------------------------------- */

          /* ------------------------------------------------update_billing_billno-------------------------------------------------- */
         
          /* ------------------------------------------------update_billing_billno-------------------------------------------------- */


          /* ------------------------------------------------Insert Seller Bill Data---------------------------------------- */
          
          /* ------------------------------------------------update_billing_billno-------------------------------------------------- */

          $Todays_date = date('Y-m-d');
         
          // $currency_details = $this->Igain_model->Get_Country_master($Seller_Country_id);
          // $Symbol_currency = $currency_details->Symbol_of_currency;

          $user_details = $this->Igain_model->get_enrollment_details($seller_id);
          $Seller_name = $user_details->First_name . " " . $user_details->Middle_name . " " . $user_details->Last_name;
		  $Seller_pin = $user_details->pinno;
		  $Seller_email_id = $user_details->User_email_id;
          $Seller_Country_id = $user_details->Country_id;
		 /*
          $Email_content = array(
              'Todays_date' => $Todays_date,
              'Seller_name' => $Seller_name,
              'Seller_email_id' => $Seller_email_id,
              'Company_finance_email_id' => $Company_finance_email_id,
              'Total_Number_Rows_Processed' => $Total_row,
              'Rows_Processed_Successfully' => $Success_row,
              'Rows_with_Errors' => $Error_row,
              'filename' => $File_name,
              // 'billing_bill_no' => $billing_bill_no,
              // 'total_grand_amt' => $total_grand_amt,
              // 'Symbol_currency' => $Symbol_currency,
              'error_file_path' => $error_file_path,
              'Notification_type' => 'Credit Transaction Processed on ' . $Todays_date,
              'Template_type' => 'Merchant_Credit_Transaction_Error_File'
          );

          $Notification = $this->send_notification->send_Notification_email('', $Email_content, $seller_id, $Company_id);
			*/

          /********* Send Flat File Error Template *****/
          // $this->send_flatfile_error_template($to_email_id,$username,$Seller_name,$file_status,$Company_id,$file_details->Error_status,$comp_name);

          /********* Send Flat File Error Template *****/
			// print_r($abc_array);die;
          if (in_array(1, $abc_array)) 
		  {
            /*******************Insert igain Log Table*********************/
            $session_data = $this->session->userdata('logged_in');
            $get_seller = $this->Igain_model->get_enrollment_details($data['enroll']);
            $Enrollement_id = $get_seller->Enrollement_id;
            $First_name = $get_seller->First_name;
            $Last_name = $get_seller->Last_name;
            $session_data = $this->session->userdata('logged_in');
            $Company_id = $session_data['Company_id'];
            $Todays_date = date('Y-m-d');
            $opration = 1;
            $enroll = $data['enroll'];
            $username = $session_data['username'];
            $userid = $session_data['userId'];
            $what = "Upload Credit Transaction Data File";
            $where = "Data Upload - Credit Transaction";
            $toname = "";
            $To_enrollid = 0;
            $firstName = '';
            $lastName = '';
            $Seller_name = $session_data['Full_name'];
            $opval = 'Flat File Upload';

            $result_log_table = $this->Igain_model->Insert_log_table($Company_id, $enroll, $username, $Seller_name, $Todays_date, $what, $where, $userid, $opration, $opval, $firstName, $lastName, $To_enrollid);

            /*******************Insert igain Log Table******************** */

            $this->session->set_flashdata("success_code", "Flat File Credit Transactions done Successfully!");
          } else {
            $this->session->set_flashdata("error_code", "Flat File Credit Transactions Unsuccessfull!");
          }

			// $file_status_session="";
			unset($file_status_session);
			$DropUploadData = $this->Credit_data_map->Drop_upload_file_data($seller_id);
          
		  redirect('Credit_data_transform/upload_data');
        }
      } else {
        redirect('Login', 'refresh');
      }
    }
	public function export_flatfile_error_report()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$Company_name = $session_data['Company_name'];			
			$Filename =  $_GET['File_name'];
			$pdf_excel_flag =  $_GET['pdf_excel_flag'];
			$Company_id =  $_GET['Company_id'];
			$data["Company_name"] = $Company_name;			
			$Today_date = date("Y-m-d");	
			$temp_table = $data['enroll'].'_flatfile_error_rpt';			
			$data["Uploaded_Flat_File_Errors"] = $this->Credit_data_map->get_flat_file_upload_errors($Filename,$Company_id);
			$Export_file_name = $Today_date."_".$temp_table.'_'.$Filename;							
			if($pdf_excel_flag == 1)
			{
				$this->excel->getActiveSheet()->setTitle('Uploaded Flat File Errors');
				$this->excel->stream($Export_file_name.'.xls', $data["Uploaded_Flat_File_Errors"]);
			}
			else
			{
				$html = $this->load->view('Reports/Enrollment_uploaded_Flat_File_Errors', $data, true);
				$this->m_pdf->pdf->WriteHTML($html);
				$this->m_pdf->pdf->Output($Export_file_name.".pdf", "D");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
/***************************** Sandeep Work End ********************************/	
}
?>


