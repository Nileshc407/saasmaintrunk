<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Enrollement_data_transform extends CI_Controller 
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
		$this->load->model('Enrollement_data_transform/Enrollement_data_map');
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
	public function Enrollement_data_mapping()
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
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);			
			$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
			$data['Seller_array'] = $get_sellers;			
			$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
			$data['Seller_array'] = $get_sellers;		
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Data_transform/data_map";
				$total_row = $this->Enrollement_data_map->data_map_count($Company_id);		
				//echo "total_row ".$total_row;
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
			$data["results"] = $this->Enrollement_data_map->data_map_list($config["per_page"], $page,$Company_id,$data['Super_seller'],$Logged_user_enrollid);
			$data["pagination"] = $this->pagination->create_links();
			
			$this->load->view("Enrollement_data_transform/Enrollement_data_mapping",$data);
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
			
			$post_data['Column_Company_id'] = $this->input->post('Column_Company_id');
			$post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id');
			$post_data['Column_Date'] = $this->input->post('Column_Date');
			$post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
			$post_data['Column_First_Name'] = $this->input->post('Column_First_Name');
			$post_data['Column_Last_Name'] = $this->input->post('Column_Last_Name');
			$post_data['Column_Address'] = $this->input->post('Column_Address');
			$post_data['Column_Phone_No'] = $this->input->post('Column_Phone_No');
			$post_data['Column_date_format'] = $this->input->post('Column_date_format');
			$post_data['Column_User_Email_ID'] = $this->input->post('Column_User_Email_ID');
			$post_data['Column_Membership_ID'] = $this->input->post('Column_Membership_ID');
			$Seller_id = $this->input->post('Column_Seller_id');
			$Company_id = $this->input->post('Column_Company_id');
			$post_data['Column_date_format'] = 'Y-m-d';
			$post_data['Data_map_for'] = '1';
			/********************************************************************/
			$exist_merchant_array=array();
			if($Seller_id==0)//All
			{
				$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				$flag=0;
				foreach($get_sellers as $Sellers_id)
				{
					$Seller_id2=$Sellers_id->Enrollement_id;
					$post_data['Column_Seller_id']=$Sellers_id->Enrollement_id;
					$result_count2 = $this->Enrollement_data_map->check_exist_data_map_seller($Seller_id2,$Company_id);
					if($result_count2==0)
					{
						$result2222 = $this->Enrollement_data_map->insert_data_map($post_data);
						$flag=1;
						
						/*******************Insert igain Log Table*********************/
						// $session_data = $this->session->userdata('logged_in');
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
						$what="Enrollement Data Mapping";
						$where="Enrollement Data Mapping";
						$toname="";
						
						
						$to_seller = $this->Igain_model->get_enrollment_details($Seller_id2);
						$To_enrollid= $to_seller->Enrollement_id;
						$firstName= $to_seller->First_name;
						$lastName= $to_seller->Last_name;
						
						/* $To_enrollid =0;
						$firstName = '';
						$lastName =''; */
						$Seller_name = $session_data['Full_name'];
						$opval = 'Enrollement Data Mapping';
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
						
						
						
						
						
						
					}
					else
					{
						array_push($exist_merchant_array,$Sellers_id->First_name);
						$Join_names=implode(",",$exist_merchant_array);
					}
				}
				if(count($exist_merchant_array)==0)
				{
					$this->session->set_flashdata("success_code","Enrollment data map created Successfuly for All Merchant(s)!!!");
				}
				elseif(count($exist_merchant_array)!=0 && $flag==1)
				{
					$this->session->set_flashdata("error_code","Enrollment data map created Successfuly!!!<br>Data map already exist for Merchant(s) ($Join_names) !!!");
				}
				elseif(count($exist_merchant_array)!=0 && $flag==0)
				{
					$this->session->set_flashdata("error_code","Enrollment data map already exist for All Merchant(s)  !!!");
				}			
			}
			else
			{
				$get_seller_name = $this->Igain_model->get_enrollment_details($Seller_id);
				$Merchant= $get_seller_name->First_name;
				$result_count = $this->Enrollement_data_map->check_exist_data_map_seller($Seller_id,$Company_id);
				//echo "count-->".$result_count;die;
				if($result_count==0)
				{
					$result222 = $this->Enrollement_data_map->insert_data_map($post_data);
					if($result222 == true)
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
						$what="Enrollement Data Mapping";
						$where="Enrollement Data Mapping";
						$toname="";
						$to_seller = $this->Igain_model->get_enrollment_details($Seller_id);
						$To_enrollid= $to_seller->Enrollement_id;
						$firstName= $to_seller->First_name;
						$lastName= $to_seller->Last_name;
						$Seller_name = $session_data['Full_name'];
						$opval = 'Enrollement Data Mapping';
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
						$this->session->set_flashdata("success_code","Enrollment data map created Successfuly!!");
					}
					else
					{
						$this->session->set_flashdata("error_code","Enrollment data map not created Successfuly!!");
					}
				}
				else
				{
					$this->session->set_flashdata("error_code","Enrollment data map already exist for Merchant ($Merchant)!!");
				}
			}			 
			redirect('Enrollement_data_transform/Enrollement_data_mapping');
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
			
			$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
			$data['Seller_array'] = $get_sellers;
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Enrollement_data_transform/Enrollement_data_mapping";
				$total_row = $this->Enrollement_data_map->data_map_count($Company_id);		
				$config["total_rows"] = $total_row;
				$config["per_page"] = 10;
				$config["uri_segment"] = 3;        
				$config['next_link'] = 'Next';
				$config['prev_link'] = 'Previous';
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = 'First';
				$config['last_link'] = 'Last';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&laquo';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '&raquo';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
				
			$data["results"] = $this->Enrollement_data_map->data_map_list($config["per_page"], $page,$Company_id,$data['Super_seller'],$Logged_user_enrollid);
			$data["pagination"] = $this->pagination->create_links();
			
			$Map_id=$_GET['Map_id'];		
			$data["Records"] = $this->Enrollement_data_map->get_data_mapping($Map_id);
			
			$this->load->view("Enrollement_data_transform/edit_enrollement_data_mapping",$data);
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
			
			$post_data['Column_Company_id'] = $this->input->post('Column_Company_id');
			$post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id'); 
			$post_data['Column_Date'] = $this->input->post('Column_Date');
			$post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
			$post_data['Column_First_Name'] = $this->input->post('Column_First_Name');
			$post_data['Column_Last_Name'] = $this->input->post('Column_Last_Name');
			$post_data['Column_Address'] = $this->input->post('Column_Address');
			$post_data['Column_Phone_No'] = $this->input->post('Column_Phone_No');
			$post_data['Column_User_Email_ID'] = $this->input->post('Column_User_Email_ID');
			$post_data['Column_Membership_ID'] = $this->input->post('Column_Membership_ID');
			$post_data['Data_map_for'] = '1';
			
			/********************************************************************/
			$Map_id = $this->input->post('Map_id');			
			$result222 = $this->Enrollement_data_map->update_data_map($post_data,$Map_id);
			
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
			
			$this->session->set_flashdata("success_code","Enrollement data map Updated Successfuly!!");
			
			redirect('Enrollement_data_transform/Enrollement_data_mapping');
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
			$Records= $this->Enrollement_data_map->get_data_mapping($Map_id);
			$Seller_id=$Records->Column_Seller_id;
			$this->Enrollement_data_map->delete_data_mapping($Map_id);
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
		redirect('Enrollement_data_transform/Enrollement_data_mapping');
	}
	public function upload_data()
	{
		
		// echo"here....upload_data---<br>";
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
			//echo "-----Company_id---".$data['Company_id'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["DataMaping"] = $this->Enrollement_data_map->get_datamaping_details($Company_id,$Logged_user_id,$Logged_user_enrollid);
			
			// $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);			
				
			/*$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
			$data['Seller_array'] = $get_sellers;*/
			// unset($file_status_session);
			// print_r($_POST);
			if($_POST == NULL)
			{
				// echo"here....upload_data--_POST == NULL-<br>";
				$this->load->view("Enrollement_data_transform/upload_enrollement_data",$data);
			}
			else
			{
				
				/*-----------------------File Upload---------------------*/
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
				if($data22['is_image'] == 1) 
				{						 
					$filepath = "";
					$filename = "";
					$block_me = 0;
				}
				else
				{	
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './Data_uploads/'.$upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='Data_uploads/'.$data22['file_name'];
					$filename=$data22['file_name'];
					$block_me = 1;
				}
				
				/*-----------------------File Upload---------------------*/
				$data['LogginUserName'] = $session_data['Full_name'];
				
				$file_status = $this->Enrollement_data_map->upload_data_map_file($filepath,$filename,$Company_id,$Logged_user_enrollid);
				
				// echo"---file_status----".print_r($file_status)."---outside---<br>";
				
				// die
				/* if($file_status){
					
					// echo"---file_status---inside--".$file_status."-<br>";
					
					$this->session->set_flashdata("error_code","Data mapping not done yet for this merchant.");
					redirect('Enrollement_data_transform/upload_data');
				} */		
				
				/* echo"---file_status--".$file_status."--<br>";
				echo"---filename--".$filename."--<br>";
				echo"---filepath--".$filepath."--<br>"; */
				
				$enrollsession = array(
					   'file_status'       => $file_status,
					   'filename'          => $filename,
					   'filepath'          => $filepath
				 );
				
				$this->session->set_userdata('fileEnrollSession',$enrollsession);
				$file_enroll_session = $this->session->userdata('fileEnrollSession');	
				// print_r($file_enroll_session);
				$data['file_status'] = $file_enroll_session['file_status'];
				$filename = $file_enroll_session['filename'];
				
				
				
				$data['UploadData'] = $this->Enrollement_data_map->get_upload_file_data($Logged_user_enrollid);
				// $data['UploadData2'] = $this->Enrollement_data_map->get_upload_file_data_for_transaction($Logged_user_enrollid);
				// echo"-----file_status-----".$file_status."<br>";
				$data['Upload_errors'] = $this->Enrollement_data_map->get_upload_errors($filename,$Company_id);
				
				// $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
				
				if($file_status ==3  && $data['UploadData']==NULL)
				{
					$this->session->set_flashdata("error_code","Data File is Uploaded Successfully, Enrollement not records found");
					
				}
				else
				{
					$this->session->set_flashdata("success_code","Data File is Uploaded Successfully, Please verify all data given table below..!!");
				}
				/****************Get sellers***************************************/
				$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);				
				if($get_sellers15 != NULL)
				{
					foreach($get_sellers15 as $seller_val)
					{
						$superSellerFlag = $seller_val->Super_seller;
					}
				}
								
				if($Logged_user_id > 2 || $superSellerFlag == 1)
				{
					$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}
			
				$data['Seller_array'] = $get_sellers;	
				/*********************************************************************/	
				 $data['Company_id'] = $session_data['Company_id'];
				 $data['Super_seller'] = $session_data['Super_seller'];
				 $data['enroll'] = $session_data['enroll'];	
				// echo"--Data_uploads-----";
				// $this->load->view("Enrollement_data_transform/verify_enrollement_data_file",$data);
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function verify_data_file()
	{
		// error_reporting(0);		

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
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['userId'] = $session_data['userId'];
			$data['Super_seller'] = $session_data['Super_seller'];
			if($data['Super_seller']==1)
			{
				$seller_id=$_REQUEST["seller_id"];
			}
			else
			{
				$seller_id=$data['enroll'];   
			}
			
			if($_POST == NULL)
			{
				// echo"hrer......";
				$file_enroll_session = $this->session->userdata('fileEnrollSession');
				// echo"----file_enroll_session----".print_r($file_enroll_session)."---<br>";
				$filename=$file_enroll_session['filename'];
				$data['file_status']=$file_enroll_session['file_status'];
				// echo"----filename----".$filename."---<br>";
				$data['Upload_errors'] = $this->Enrollement_data_map->get_upload_errors($filename,$Company_id);
				$data['UploadData'] = $this->Enrollement_data_map->get_upload_file_data($Logged_user_enrollid);					
				$this->load->view("Enrollement_data_transform/verify_enrollement_data_file",$data);
			}
			else
			{
				
				$data["DataMaping"] = $this->Enrollement_data_map->get_datamaping_details($Company_id,$Logged_user_id,$Logged_user_enrollid);				
				$company_details2 = $this->Igain_model->get_company_details($Company_id);
				$Coalition_points_percentage = $company_details2->Coalition_points_percentage;
				$data["Company_details"] = $company_details2;
				$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				$data['Seller_array'] = $get_sellers;				
				
				$UploadData = $this->Enrollement_data_map->get_upload_file_data_for_transaction($Logged_user_enrollid);		
				
				$logtimezone = $session_data['timezone_entry'];
				$timezone = new DateTimeZone($logtimezone);
				$date = new DateTime();
				$date->setTimezone($timezone);
				$lv_date_time=$date->format('Y-m-d H:i:s');
				$Todays_date = $date->format('Y-m-d');
				
				
				$enroll_flag=0;
				$get_country = $this->Enroll_model->get_country($Company_id);
				$dial_code = $this->Enroll_model->get_dial_code($get_country);
				$lowest_tier = $this->Enrollement_data_map->get_lowest_tier($Company_id);
				// print_r($UploadData);
				foreach($UploadData as $row)
				{
						$FirstName = $row->First_Name;
						$LastName = $row->Last_Name;
						$Address = $row->Address;
						$PhoneNo =$row->Phone_No;
						$UserEmailID = $row->User_Email_ID;
						$MembershipID = $row->Membership_ID;
						// $RefreeMembershipID = $row->Refree_Membership_ID;
						$JoiningDate  = $row->Date;
						
						
					if($PhoneNo != 0 && $UserEmailID !="" && $MembershipID != 0 )
					{
						$PhoneNo1=$dial_code.''.$PhoneNo;
						$check_UserEmailID_exists=$this->Enrollement_data_map->Check_UserEmailID_exist_record($UserEmailID,$Company_id);	
						echo"check_UserEmailID_exists------".$check_UserEmailID_exists."<br><br>";
						if($check_UserEmailID_exists == 0 )
						{	
							
							
							$check_PhoneNo_exists=$this->Enrollement_data_map->Check_PhoneNo_exist_record($PhoneNo1,$Company_id);	
							echo"check_PhoneNo_exists------".$check_PhoneNo_exists."<br><br>";
							
							if($check_PhoneNo_exists == 0)
							{
								// echo"Heree...<br><br>";
								$check_MembershipID_exists=$this->Enrollement_data_map->Check_MembershipID_exist_record($MembershipID,$Company_id);	
								echo"check_MembershipID_exists------".$check_MembershipID_exists."<br><br>";
								
								if($check_MembershipID_exists == 0)
								{
														
										$resultis = $this->Igain_model->get_company_details($Company_id);
										$Seller_topup_access = $resultis->Seller_topup_access;
										$Partner_company_flag = $resultis->Partner_company_flag;
										$Joining_bonus_flag = $resultis->Joining_bonus;
										$Joining_bonus_points = $resultis->Joining_bonus_points;
										$Coalition = $resultis->Coalition;						
										
										$user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
										$seller_id = $user_details->Enrollement_id;
										$Purchase_Bill_no = $user_details->Purchase_Bill_no;
										$username = $user_details->User_email_id;
										$remark_by = 'By Seller';
										$seller_curbal = $user_details->Current_balance;
										$Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
										$Seller_Refrence = $user_details->Refrence;
										$Topup_Bill_no =  $user_details->Topup_Bill_no;
										$Seller_name = $user_details->First_name." ".$user_details->Middle_name." ".$user_details->Last_name;
										if($user_details->Sub_seller_admin == 1)
										{
												$remark_by = 'By SubSeller';
										}
										else
										{
												$remark_by = 'By Seller';
										}
										$data["Company_details"] = $resultis;
										$Seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
										$data['Refrence'] = $Seller_details->Refrence;						
										$cardid = $MembershipID;
										if($Joining_bonus_flag == 1 && $cardid != "")
										{
											$Customer_topup12 =$Joining_bonus_points;
										}
										else
										{
											$Customer_topup12=0;
										}
										$pinno = $this->Igain_model->getRandomString();									
										$insert_enroll=array(
											'First_name'=>$FirstName,
											'Last_Name'=>$LastName,
											'Current_address'=>App_string_encrypt($Address),
											'timezone_entry'=>$logtimezone,
											'Country'=>$get_country,
											'Country_id'=>$get_country,
											'Phone_no'=> App_string_encrypt($dial_code.''.$PhoneNo),
											'User_email_id'=>App_string_encrypt($UserEmailID),
											'User_pwd'=>App_string_encrypt($PhoneNo),
											'Card_id'=>$MembershipID,
											'joined_date'=>$JoiningDate,
											'Company_id'=>$Company_id,
											'Current_balance'=>$Customer_topup12,
											'Total_topup_amt'=>$Customer_topup12,
											'Tier_id'=>$lowest_tier,
											'User_id'=>1,
											'pinno'=>$pinno,
											'User_activated'=>1,
											'Create_user_id'=>$seller_id,
											'source'=>'Flat File'					
										);
										$result = $this->Enrollement_data_map->insert_enrollement_flatfile($insert_enroll);
										$Last_enroll_id=$result;
										$customer_name = $FirstName.' '.$LastName;					
										/**************************Ravi**** Joining Bonus start*******************/						
										$user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
										$seller_id = $user_details->Enrollement_id;
										$Purchase_Bill_no = $user_details->Purchase_Bill_no;
										$username = $user_details->User_email_id;
										$remark_by = 'By Seller';
										$seller_curbal = $user_details->Current_balance;
										$Seller_Redemptionratio = $user_details->Seller_Redemptionratio;
										$Seller_Refrence = $user_details->Refrence;
										$Topup_Bill_no =  $user_details->Topup_Bill_no;
										$Seller_name = $user_details->First_name." ".$user_details->Middle_name." ".$user_details->Last_name;

										if($user_details->Sub_seller_admin == 1)
										{
												$remark_by = 'By SubSeller';
										}
										else
										{
												$remark_by = 'By Seller';
										}
										$top_db = $Topup_Bill_no;
										$len = strlen($top_db);
										$str = substr($top_db,0,5);
										$tp_bill = substr($top_db,5,$len);
										$topup_BillNo = $tp_bill + 1;
										$billno_withyear_ref = $str.$topup_BillNo;
										
										$Enrolled_Card_id=$cardid;
											// Joining_bonus_points
										if($Joining_bonus_flag == 1 && $cardid != "")
										{								

											if($Coalition == 1 )
											{
													$SellerID =0;
											}
											else
											{
													$SellerID = $seller_id;
											}
											$post_Transdata = array(
											'Trans_type' => '1',
											'Company_id' => $Company_id,
											'Topup_amount' => $Joining_bonus_points,
											'Trans_date' => $lv_date_time,
											'Remarks' => 'Joining Bonus',
											'Card_id' => $cardid ,
											'Seller_name' => $Seller_name,
											'Seller' => $SellerID,
											'Enrollement_id' => $Last_enroll_id,
											'Bill_no' => $tp_bill,
											'remark2' => $remark_by,
											'Loyalty_pts' => '0'
											);
											$result6 = $this->Transactions_model->insert_topup_details($post_Transdata);
											if($Seller_topup_access=='1')
											{
													$seller_curbal = ($Total_seller_bal - $Joining_bonus_points);
													$Total_seller_bal2 = $seller_curbal;
													$result3 = $this->Transactions_model->update_seller_balance($seller_id,$Total_seller_bal2);
											}								
											$Email_content12 = array(
													'Joining_bonus_points' => $Joining_bonus_points,
													'Notification_type' => 'Joining Bonus',
													'Template_type' => 'Joining_Bonus',
													'Customer_name' => $customer_name,
													'Todays_date' => $Todays_date
											);

											$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content12,$seller_id,$Company_id);		
											$tp_bill=$tp_bill+1;
											$billno_withyear_ref1 = $str.$tp_bill;	
										}						
										$result8 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref1);
										/************ Joining Bonus end **************/		
										
										/***************Send Freebies Merchandize items************/
										$Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1);
									
										if($Merchandize_Items_Records != NULL  && $cardid != "")
										{									
											
											$this->load->model('Redemption_catalogue/Redemption_Model');							
											foreach($Merchandize_Items_Records as $Item_details)
											{
												/******************Changed AMIT 16-06-2016*************/
												$this->load->model('Catalogue/Catelogue_model');
												$Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($Item_details->Partner_id,$Company_id);
												foreach($Get_Partner_Branches as $Branch)
												{
													$Branch_code=$Branch->Branch_code;
												}
												/********************************/						
												/********************************/
												$characters = 'A123B56C89';
												$string = '';
												$Voucher_no="";
												for ($i = 0; $i < 16; $i++) 
												{
													$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
												}
												$Voucher_status="Issued";	
												if(($Item_details->Link_to_Member_Enrollment_flag==1) && ($Todays_date >= $Item_details->Valid_from) && ($Todays_date <= $Item_details->Valid_till))
												{
												
												
													$user_details = $this->Igain_model->get_enrollment_details($data['enroll']);
													$seller_id = $user_details->Enrollement_id;
													$Topup_Bill_no =  $user_details->Topup_Bill_no;
													$top_db = $Topup_Bill_no;
													$len = strlen($top_db);
													$str = substr($top_db,0,5);
													$tp_bill = substr($top_db,5,$len);
													$topup_BillNo = $tp_bill + 1;
													$billno_withyear_ref = $str.$topup_BillNo;											
													$insert_data = array(
														'Company_id' => $Company_id,
														'Trans_type' => 10,
														'Redeem_points' => $Item_details->Billing_price_in_points,
														'Quantity' => 1,
														'Trans_date' => $lv_date_time,
														'Create_user_id' => $data['enroll'],
														'Seller' => $data['enroll'],
														'Seller_name' => $Seller_name,
														'Enrollement_id' => $Last_enroll_id,
														'Card_id' => $cardid,
														'Item_code' => $Item_details->Company_merchandize_item_code,
														'Voucher_no' => $Voucher_no,
														'Voucher_status' => $Voucher_status,
														'Merchandize_Partner_id' => $Item_details->Partner_id,
														'Remarks' => 'Freebies',
														'Source' =>99,
														'Bill_no' => $tp_bill,
														'Merchandize_Partner_branch' => $Branch_code
														);
													 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
													
													 $Voucher_array[]=$Voucher_no;
													  
													  /**********Send freebies notification********/
														$Email_content124 = array(
																		'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
																		'Merchandize_item_name' => $Item_details->Merchandize_item_name,
																		'Item_image' => $Item_details->Item_image1,
																		'Voucher_no' => $Voucher_no,
																		'Voucher_status' => $Voucher_status,
																		'Notification_type' => 'Freebies',
																		'Template_type' => 'Enroll_Freebies',
																		'Customer_name' => $customer_name,
																		'Todays_date' => $Todays_date
																);
													$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content124,$seller_id,$Company_id);
												}
												
											}	
											$tp_bill=$tp_bill+1;
											$billno_withyear_ref = $str.$tp_bill;
											$result7 = $this->Transactions_model->update_topup_billno($seller_id,$billno_withyear_ref);
											
										}									
										/*********************Merchandize end*************************/
										if($result > 0)
										{
											$Email_content = array(
													'Notification_type' => 'Enrollment Details',
													'Template_type' => 'Enroll'
											);
											$this->send_notification->send_Notification_email($Last_enroll_id,$Email_content,$seller_id,$Company_id);
											$enroll_flag=1;
											
										}
										else
										{
											$enroll_flag=0;
										}
								}
								else
								{
									$enroll_flag=0;
								}
							}
							else
							{
								$enroll_flag=0;
							}
						}
						
					}
					else
					{
						$enroll_flag=0;
					}					
				}
				// echo"enroll_flag---------".$enroll_flag."<br>";
				// die;			
				/********* Send Flat File Error Template *****/
					
					// $file_status = $this->input->post("file_status");					
					// $file_details = $this->Data_transform_model->get_file_erro_status($file_status,$Company_id);
					
					//$this->send_flatfile_error_template($to_email_id,$username,$Seller_name,$file_status,$Company_id,$file_details->Error_status,$comp_name);
					
				/********* Send Flat File Error Template *****/
				
				if($enroll_flag == 1)
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
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Upload Enrollement Flat File";
					$where="Data Upload - Enrollement ";
					$toname="";
					$To_enrollid =0;
					$firstName ='';
					$lastName ='';
					$Seller_name = $session_data['Full_name'];
					$opval = 'Upload Enrollement Flat File';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					
					
					$this->session->set_flashdata("success_code","Flat File Enrollment done Successfully!");
				}
				else
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
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Upload Enrollement Flat File";
					$where="Data Upload - Enrollement ";
					$toname="";
					$To_enrollid =0;
					$firstName ='';
					$lastName ='';
					$Seller_name = $session_data['Full_name'];
					$opval = 'Upload Enrollement Flat File';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					$this->session->set_flashdata("success_code","Records Uploaded Successfully. However, few records were not uploaded due to errors. Please rectify them and Upload again");
				} 
				// $this->load->view("Enrollement_data_transform/upload_enrollement_data",$data);
				
				
				redirect('Enrollement_data_transform/upload_data');
			}
			
			unset($enrollsession);
			
		}
		else
		{
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
			$data["Uploaded_Flat_File_Errors"] = $this->Enrollement_data_map->get_flat_file_upload_errors($Filename,$Company_id);
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


