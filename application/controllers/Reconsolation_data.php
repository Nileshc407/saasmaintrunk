<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reconsolation_data extends CI_Controller 
{
	public function __construct()
	{ 
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');	
		$this->load->model('Coal_transactions/Coal_Transactions_model');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Reconsolation_data/Reconsolation_data_map');
		$this->load->model('master/currency_model');
		$this->load->library("excel");
		$this->load->library('m_pdf');
		$this->load->helper('file');
	}
	public function Reconsolation_data_mapping()
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
			
			$get_sellers = $this->Igain_model->get_company_sellers_and_staff($Company_id);
			$data['Seller_array'] = $get_sellers;
			
			$data['Pubblisher'] = $this->Reconsolation_data_map->get_publisher($Company_id);
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Reconsolation_data/Reconsolation_data_mapping";
				$total_row = $this->Reconsolation_data_map->data_map_count($Company_id);		
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
				
			$data["results"] = $this->Reconsolation_data_map->data_map_list($config["per_page"], $page,$Company_id,$data['Super_seller'],$Logged_user_enrollid);
			$data["pagination"] = $this->pagination->create_links();
			
			$this->load->view("Reconsolation_data/Reconsolation_data_mapping",$data);
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
			
			$post_data['Column_Company_id'] = $this->input->post('Column_Company_id');
			$post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id');
			$post_data['Column_Date'] = $this->input->post('Column_Date');
			$post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
			$post_data['Column_Bill_no'] = $this->input->post('Column_Bill_no');
			$post_data['Column_Amount'] = $this->input->post('Column_Amount');
			// $post_data['Column_Payment_type'] = $this->input->post('Column_Payment_type');
			$post_data['Column_date_format'] = $this->input->post('Column_date_format');
			$post_data['Column_Customer'] = $this->input->post('Column_Customer');
			$post_data['Column_Status'] = $this->input->post('Column_Status');
			/*******************New added 29-08-2016**AMIT*******************/
			$post_data['Column_remarks'] = $this->input->post('Column_remarks');
			$post_data['Data_map_for'] = $this->input->post('Data_map_for');
			/********************************************************************/
			$Seller_id = $this->input->post('Column_Seller_id');
			$Company_id = $this->input->post('Column_Company_id');
			$exist_merchant_array=array();
			if($Seller_id==0) //All
			{
				$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
				$flag=0;
				foreach($get_sellers as $Sellers_id)
				{
					$Seller_id2=$Sellers_id->Enrollement_id;
					$post_data['Column_Seller_id']=$Sellers_id->Enrollement_id;
					$result_count2 = $this->Reconsolation_data_map->check_exist_data_map_seller($Seller_id2,$Company_id);
					if($result_count2==0)
					{
						$result2222 = $this->Reconsolation_data_map->insert_data_map($post_data);
						$flag=1;
					}
					else
					{
						array_push($exist_merchant_array,$Sellers_id->First_name);
						$Join_names=implode(",",$exist_merchant_array);
					}
				}				
				if(count($exist_merchant_array)==0)
				{
					$this->session->set_flashdata("success_code","Reconciliation Data map created Successfuly for All Publisher(s)!!!");
					
					/*******************Insert igain Log Table*********************/
							$session_data = $this->session->userdata('logged_in');
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Create Data Map";
							$where="Create / Edit Data Map";
							$toname="";
							$To_enrollid =0;
							$firstName = 'All Merchant';
							$lastName = '';
							$Seller_name = $session_data['Full_name'];
							$opval = 'POS Data Mapping';
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}

				elseif(count($exist_merchant_array)!=0 && $flag==1)
				{
					$this->session->set_flashdata("success_code","Reconciliation Data map created Successfuly!!!<br>Data map already exist for Publisher(s) ($Join_names) !!!");
				}
				elseif(count($exist_merchant_array)!=0 && $flag==0)
				{
					$this->session->set_flashdata("error_code","Reconciliation Data map already exist for All Publisher(s)  !!!");
				}
								
					
				
			}
			else
			{
				$get_seller_name = $this->Igain_model->get_enrollment_details($Seller_id);
				$MerchantFName= $get_seller_name->First_name;
				$MerchantLName= $get_seller_name->Last_name;
				$Enrollement_id= $get_seller_name->Enrollement_id;
				$result_count = $this->Reconsolation_data_map->check_exist_data_map_seller($Seller_id,$Company_id);

				$Merchant = $get_seller_name->First_name.' '.$get_seller_name->Last_name;
				
				if($result_count==0)
				{
					$result222 = $this->Reconsolation_data_map->insert_data_map($post_data);
					if($result222 == true)
					{
						$this->session->set_flashdata("success_code","Reconciliation Data map created Successfuly!!");
						
						/*******************Insert igain Log Table*********************/
							$session_data = $this->session->userdata('logged_in');
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="RECONCILIATION DATA MAPPING";
							$where="RECONCILIATION DATA MAPPING";
							$toname="";
							$To_enrollid =$Enrollement_id;
							$firstName = $MerchantFName;
							$lastName =$MerchantLName;
							$Seller_name = $session_data['Full_name'];
							$opval = 'Reconsolation Data Mapping';
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Seller_id);
						/*******************Insert igain Log Table*********************/
					}
					else
					{
						$this->session->set_flashdata("error_code","Reconciliation Data map not created Successfuly!!");
					}
				}
				else
				{
					$this->session->set_flashdata("error_code","Reconciliation Data map already exist for Merchant ($Merchant)!!");
				}
			}
			 
			redirect('Reconsolation_data/Reconsolation_data_mapping');
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
			
			/* $post_data['Column_Company_id'] = $this->input->post('Column_Company_id');
			$post_data['Column_Seller_id'] = $this->input->post('Column_Seller_id'); */
			$post_data['Column_Date'] = $this->input->post('Column_Date');
			$post_data['Column_header_rows'] = $this->input->post('Column_header_rows');
			$post_data['Column_Bill_no'] = $this->input->post('Column_Bill_no');
			$post_data['Column_Amount'] = $this->input->post('Column_Amount');
			//$post_data['Column_Payment_type'] = $this->input->post('Column_Payment_type');
			$post_data['Column_date_format'] = $this->input->post('Column_date_format');
			$post_data['Column_Customer'] = $this->input->post('Column_Customer');
			$post_data['Column_Status'] = $this->input->post('Column_Status');
			/*******************New added 29-08-2016**AMIT*******************/
			$post_data['Column_remarks'] = $this->input->post('Column_remarks');
			$post_data['Data_map_for'] =$this->input->post('Data_map_for');
			/********************************************************************/
			$Map_id = $this->input->post('Map_id');
			
			$result222 = $this->Reconsolation_data_map->update_data_map($post_data,$Map_id);
			 
			$this->session->set_flashdata("success_code","Reconciliation Data map Updated Successfuly!!");
			
			/*******************Insert igain Log Table*********************/
				$session_data = $this->session->userdata('logged_in');
				$get_seller_details = $this->Igain_model->Get_data_map_merchant_details($Map_id);
				$Column_Seller_id= $get_seller_details->Column_Seller_id;
				$get_seller = $this->Igain_model->get_enrollment_details($Column_Seller_id);
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
				$what="Update Data Map";
				$where="Create / Edit Data Map";
				$toname="";
				$To_enrollid =$Enrollement_id;
				$firstName = $First_name;
				$lastName = $Last_name;
				$Seller_name = $session_data['Full_name'];
				$opval ='POS Data Mapping';
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Column_Seller_id);
			/*******************Insert igain Log Table*********************/
			
			
			redirect('Reconsolation_data/Reconsolation_data_mapping');
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function delete_data_mapping()
	{
		$Map_id=$_GET['Map_id'];	
		/************igain log table change***************/
		$get_seller_details = $this->Igain_model->Get_data_map_merchant_details($Map_id);
		$Column_Seller_id= $get_seller_details->Column_Seller_id;
		/************igain log table change***************/
		$this->Reconsolation_data_map->delete_data_mapping($Map_id);
		$this->session->set_flashdata("success_code","Reconsolation Data map deleted Successfuly!!");
		/*******************Insert igain Log Table*********************/
		$session_data = $this->session->userdata('logged_in');
		$get_seller = $this->Igain_model->get_enrollment_details($Column_Seller_id);
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
		$what="Delete Data Map";
		$where="Create / Edit Data Map";
		$toname="";
		$To_enrollid =$Enrollement_id;
		$firstName = $First_name;
		$lastName = $Last_name;
		$Seller_name = $session_data['Full_name'];
		$opval = 'Delete POS Data Mapping';
		$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Column_Seller_id);
	/*******************Insert igain Log Table*********************/
		redirect('Reconsolation_data/Reconsolation_data_mapping');
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
			
			$get_sellers = $this->Igain_model->get_company_sellers_and_staff($Company_id);
			$data['Seller_array'] = $get_sellers;
			
			$data['Pubblisher'] = $this->Reconsolation_data_map->get_publisher($Company_id);
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Reconsolation_data/Reconsolation_data_mapping";
				$total_row = $this->Reconsolation_data_map->data_map_count($Company_id);		
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
				
			$data["results"] = $this->Reconsolation_data_map->data_map_list($config["per_page"], $page,$Company_id,$data['Super_seller'],$Logged_user_enrollid);
			$data["pagination"] = $this->pagination->create_links();
			
			$Map_id=$_GET['Map_id'];		
			$data["Records"] = $this->Reconsolation_data_map->get_data_mapping($Map_id);
			
			$this->load->view("Reconsolation_data/edit_reconsolation_data_mapping",$data);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	/***************************** Amit Work End ********************************/	
	
	/***************************** Sandeep Work Start ********************************/	
	
	/***** Data file upload ********/
	
    public function Reconsolation_upload_data()
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
                // echo "-----Company_id---".$data['Company_id'];
                $data['Super_seller'] = $session_data['Super_seller'];
                $data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

                $data["DataMaping"] = $this->Reconsolation_data_map->get_datamaping_details($Company_id,$Logged_user_id,$Logged_user_enrollid);

                $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);

                $data['Pubblisher'] = $this->Reconsolation_data_map->get_publisher($Company_id);


                /*$get_sellers = $this->Igain_model->get_company_sellers($Company_id);
                $data['Seller_array'] = $get_sellers;*/
				// echo "-----Logged_user_enrollid---".$Logged_user_enrollid;	
                if($_POST == NULL)
                {
                        $this->load->view("Reconsolation_data/upload_reconsolation_data",$data);
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

                    /* if ( ! $this->upload->do_upload("file"))
                    {			
                            $this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
                            $filepath = "";
                            $filename = "";
                            $block_me = 0;

                    }
                    else
                    {
                            $data = array('upload_data' => $this->upload->data("file"));
                            $filepath = "Data_uploads/".$data['upload_data']['file_name'];
                            $filename = $data['upload_data']['file_name'];
                            $block_me = 1;
                    } */
					
					
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

						$publisher=$this->input->post("publisher");
						
						 $Check_data_mapping = $this->Reconsolation_data_map->Check_data_mapping($publisher,$Company_id);
						if($Check_data_mapping <= 0 )
						{
							 $this->session->set_flashdata("data_map_error_message"," File Can not Procceed because Mapping not Set for this Publisher");
							redirect('Reconsolation_data/Reconsolation_upload_data');
						}
					
                        $file_status = $this->Reconsolation_data_map->upload_data_map_file($filepath,$filename,$Company_id,$Logged_user_enrollid,$publisher);
						
						// print_r($file_status);
                        $data['file_status'] = $file_status['Upload_status'];
                        $data['Total_error_count'] = $file_status['Total_error_count'];
                        $data['Total_row'] =$file_status['Total_row'];
                        $data['Error_row'] =$file_status['Error_row'];
                        $data['Success_row'] =$file_status['Success_row'];
                        $data['filename'] =$filename;
						
						
					$file_status_session = array(
					   'file_status'       => $file_status['Upload_status'],
					   'Total_error_count' => $file_status['Total_error_count'],
					   'Total_row'         => $file_status['Total_row'],
					   'Error_row'         => $file_status['Error_row'],
					   'Success_row'       => $file_status['Success_row'],
					   'filename'          => $filename,
					   'publisher'          => $publisher
					 );
					$this->session->set_userdata('file_status_session',$file_status_session);
                        

                        $data['UploadData'] = $this->Reconsolation_data_map->get_upload_file_data($Logged_user_enrollid);
                        // $data['UploadData2'] = $this->Reconsolation_data_map->get_upload_file_data_for_transaction($Logged_user_enrollid);
                            
                        $data['Upload_errors'] = $this->Reconsolation_data_map->get_upload_errors($filename,$Company_id);

                        $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);

                        

                         $data['publisher'] = $this->input->post("publisher");


                       $publisher_details= $this->Reconsolation_data_map->get_publisher_details($data['publisher']);

                        $data['publisher_Currency']=$publisher_details->Currency;
						// die;
                       /*  if($file_status ==3  && $data['UploadData']==NULL)
                        {
                            $this->session->set_flashdata("data_map_error_code","Reconsolation Data File is Uploaded Successfully, Transactions not found between from date and till date!!");

                        }
                        else
                        { */
                            
                            $this->session->set_flashdata("data_map_error_code","Reconsolation Data File is Uploaded Successfully, Please verify all data given table below..!!");
							
                        // }
                        /*if($file_status > 0 && $block_me == 1)
                        {
                                $this->session->set_flashdata("data_map_error_code","Data File is Uploaded Successfully, Please Verify All Data table below..!!");
                        }
                        else
                        {							
                                $this->session->set_flashdata("data_map_error_code","Transactions are already exist!");
                        }
                        */
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
						 
						 // echo"---verify_reconsolation_data_file--load---<br>";
						 
                         $this->load->view("Reconsolation_data/verify_reconsolation_data_file",$data);
                }
        }
        else
        {
                redirect('Login', 'refresh');
        }
    }
	public function get_loyalty_program()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$Company_id = $session_data['Company_id'];
			$seller_id = $this->input->post("seller_id");
			
			$data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$seller_id,2);

			//$data['lp_array'] = $ref_array;

			$this->load->view('Reconsolation_data/view_loyalty_program_seller_list',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function get_loyalty_program_details()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$Logged_user_enroll = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$Loyalty_names = $this->input->post("Loyalty_names");
			$selected_seller = $this->input->post("selected_seller");
			
			$data['lp_array'] = $this->Reconsolation_data_map->get_loyaltyrule_details($Loyalty_names,$Company_id,$selected_seller);
			///print_r($data['lp_array']);
			//$data['lp_array'] = $ref_array;

			$this->load->view('view_loyalty_program_details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Reconsolation_verify_data_file()
	{
		error_reporting(0);

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
			
			
			$logtimezone = $session_data['timezone_entry'];;
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d H:i:s');
			
			
			
			$file_session_data = $this->session->userdata('file_status_session');	
			// echo"----file_status------".print_r($file_session_data);
			
			$filename=$file_session_data['filename'];
			$data['Pubblisher'] = $this->Reconsolation_data_map->get_publisher($Company_id);
			
			if($_POST == NULL)
			{
				// echo "here.......<br>";
				
				$data['UploadData'] = $this->Reconsolation_data_map->get_upload_file_data($Logged_user_enrollid);
				
				// $data['UploadData'] = $this->Reconsolation_data_map->get_upload_file_data($Logged_user_enrollid);
				// $data['UploadData2'] = $this->Reconsolation_data_map->get_upload_file_data_for_transaction($Logged_user_enrollid);
                            
				$data['Upload_errors'] = $this->Reconsolation_data_map->get_upload_errors($filename,$Company_id);
						
				// $data['lp_array'] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
				$this->load->view("Reconsolation_data/verify_reconsolation_data_file",$data);
			}
			else
			{

				//echo "<pre>";	

				// echo "here....not null...<br>";
				
				
				
			$Total_error_count =$file_session_data["Total_error_count"];
			$Total_row = $file_session_data["Total_row"];
			$Error_row = $file_session_data["Error_row"];
			$Success_row = $file_session_data["Success_row"];
			$publisher = $file_session_data["publisher"];
			$Upload_status = $file_session_data["Upload_status"];
			
			
				/* $publisher=$this->input->post("publisher");				
				$Total_error_count=$this->input->post("Total_error_count");
				$Total_row=$this->input->post("Total_row");
				$Error_row=$this->input->post("Error_row");
				$Success_row=$this->input->post("Success_row"); */


				$publisher_details= $this->Reconsolation_data_map->get_publisher_details($publisher);


				$Register_beneficiary_id=$publisher_details->Register_beneficiary_id;
				$Beneficiary_company_name= $publisher_details->Beneficiary_company_name;
				$Contact_email_id=$publisher_details->Contact_email_id;
				$Contact_email_id1=$publisher_details->Contact_email_id1;
				$Contact_email_id2=$publisher_details->Contact_email_id2;
				$Currency=$publisher_details->Currency;

			 	if(isset($_POST['submit'])) {

        			// echo "----submit--<br>";
        			
				$upload_id=$this->input->post("upload_id");
				

				// print_r($upload_id);
				// echo "<br>";
				$array =  explode('_', $upload_id);
				foreach ($upload_id as $item) {

				    // echo "----item----".$item."--<br>";
				    $array =  explode('_', $item);
				    $upload_id=$array[0];
				    $Pos_Customerno=$array[1];
				    $Pos_Billno=$array[2];
				    $Pos_Billamt=$array[3];
				    $Remarks=$array[4];
				    $Status=$array[5];
			   

				    $Get_customer_details = $this->Reconsolation_data_map->Get_customer_details_purchased_miles($Company_id,$Pos_Customerno,$Pos_Billno,$Pos_Billamt);

					if($Get_customer_details != NULL){		
						// echo "----Get_customer_details----".print_r($Get_customer_details)."--<br>";					
				   
				   	/*--------------------Update Voucher Status --------------------*/	
					   $UploadData = $this->Reconsolation_data_map->update_reconsolation_voucher_status($Logged_user_id,$Todays_date,$Currency,$Company_id,$Pos_Customerno,$Pos_Billno,$Pos_Billamt,$Status);
						// echo"---UploadData-----".$this->db->last_query();
	
					 /*--------------------Update Voucher Status --------------------*/
				     /*--------------------Update Member Balance --------------------*/	
					  // echo "----Status----".$Status."--<br>";
						
					    if($Status== 45 )  //'Approved'
						{

					    	$new_current_balance=($Get_customer_details->Current_balance-$Get_customer_details->Redeem_points);
				
					    	$new_block_points=($Get_customer_details->Blocked_points-$Get_customer_details->Redeem_points);

					    	$PostData= array(
					    				'Current_balance' => $new_current_balance, 
					    				'Blocked_points' => $new_block_points 
					    				);
					    	$UpdateCurrentBalance = $this->Reconsolation_data_map->update_customer_reconsolation_balance($Get_customer_details->Enrollement_id,$Get_customer_details->Card_id,$Get_customer_details->Company_id,$PostData);
							
							
							if($UpdateCurrentBalance== true)
							{
								
								$StatusEmail = 'Approved'; 
								
								$Email_content = array(
									'Todays_date' => $Get_customer_details->Trans_date,
									'Publisher_name' => $Beneficiary_company_name,
									'Currency' => $Currency,
									'Status'=>$StatusEmail,
									'Purchased_miles'=>$Pos_Billamt,								
									'Notification_type' =>'Status of Your recent Purchased of '.$Currency.' from '.$Beneficiary_company_name,
									'Template_type' => 'Reconsolation_customer_update_status'
								);
				
								$Notification=$this->send_notification->send_Notification_email($Get_customer_details->Enrollement_id,$Email_content,'1',$Company_id);							
							}
							
					    }
					    if($Status==46) // Cancelled
						{					
							
					    	$new_block_points=($Get_customer_details->Blocked_points-$Get_customer_details->Redeem_points);
							
					    	$PostData= array(
					    				'Blocked_points' => $new_block_points
					    				);
							
							$Update_CurrentBalance = $this->Reconsolation_data_map->update_customer_reconsolation_balance($Get_customer_details->Enrollement_id,$Get_customer_details->Card_id,$Get_customer_details->Company_id,$PostData);
							
							
							
							if($Update_CurrentBalance== true)
							{
								
								$StatusEmail = 'Cancelled';
								
								$Email_content = array(
									'Todays_date' => $Get_customer_details->Trans_date,
									'Publisher_name' => $Beneficiary_company_name,
									'Currency' => $Currency,
									'Status'=>$StatusEmail,
									'Purchased_miles'=>$Pos_Billamt, 									
									'Notification_type' =>'Status of Your recent Purchased of '.$Currency.' from '.$Beneficiary_company_name,
									'Template_type' => 'Reconsolation_customer_update_status'
								);
				
								$Notification=$this->send_notification->send_Notification_email($Get_customer_details->Enrollement_id,$Email_content,'1',$Company_id);
							
							}
							
							
							
						}

					}									   
				    /*--------------------Update Member Balance --------------------*/	

					}
			 	}
			    			
				// die;
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
				/*--------------------Send Flat File Error Template--------------------*/					
					// $file_status = $this->input->post("file_status");	
					$file_status = $file_session_data["Upload_status"];
					
				$data['file_error_details'] = $this->Reconsolation_data_map->get_file_erro_status($file_status,$Company_id);
				
				
					foreach ($data['file_error_details'] as $key => $value) {
						
						$File_name= $value->File_name;
					}

					$data['File_name']=$File_name;


					$Export_file_name = "Reconciliation-Error-File";
					$data['Export_file_name'] = "Reconciliation Error File";
				
					$data['Publisher_name']  = $Beneficiary_company_name;	

					$html = $this->load->view('Reconsolation_data/pdf_reconsolation_error_file', $data, true);					
					$error_file_path="";
					if(!empty($data['file_error_details']))	
					{
						$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT']; 
						$this->m_pdf->pdf->WriteHTML($html);
						$error_file_path = $this->m_pdf->pdf->Output($DOCUMENT_ROOT.'/export/Reconciliation_files/'.$File_name.'.pdf','F');
						$this->m_pdf->pdf->Output($DOCUMENT_ROOT.'/export/Reconciliation_files/'.$File_name.'.pdf','F');
						
						// $this->m_pdf->pdf->Output($Export_file_name.".pdf", "D");		
						$error_file_path=$DOCUMENT_ROOT.'/export/Reconciliation_files/'.$File_name.'.pdf';
					 // echo "---error_file_path-----".$error_file_path."--<br>";
				
				
					}


					$Todays_date=date('Y-m-d');

					$Email_content = array(
						'Todays_date' => $Todays_date,
						'Publisher_name' => $Beneficiary_company_name,						
						'Contact_email_id' => $Contact_email_id,						
						'Contact_email_id1' => $Contact_email_id1,						
						'Contact_email_id2' => $Contact_email_id2,						
						'Total_Number_Rows_Processed' => $Total_row,
						'Rows_Processed_Successfully' => $Success_row,
						'Rows_with_Errors' => $Error_row,
						'filename' => $File_name,
						'error_file_path' => $error_file_path,
						'Notification_type' => 'Reconciliation Error File of '.$Beneficiary_company_name.' processed on '.$Todays_date,
						'Template_type' => 'Reconsolation_Error_File'
					);
			
					$Notification=$this->send_notification->send_Notification_email('',$Email_content,'1',$Company_id);

				

				/*--------------------Send Flat File Error Template--------------------*/	
				
			
					
				/*-----------------------------Insert igain Log Table-----------------------------------*/
					
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
					$what="Reconciliation File Upload";
					$where="Reconciliation File Upload";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName ='';
					$Seller_name = $session_data['Full_name'];
					$opval = 'Reconciliation File Upload';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					
					/*-----------------------------Insert igain Log Table-----------------------------------*/
					
					$this->session->set_flashdata("success_code","Reconciliation File Upload done Successfully.!");
											
					// $this->session->set_flashdata("data_map_error_message","Reconciliation File Upload Unsuccessfull!");
				
				
					//$DropUploadData = $this->Reconsolation_data_map->Drop_upload_file_data($Logged_user_enrollid);
				 
					// $this->load->view("Reconsolation_data/upload_reconsolation_data",$data);
					
					redirect('Reconsolation_data/Reconsolation_upload_data', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
		
	}
	/***** Data file upload ********/
	
	
/***************************** Sandeep Work End ********************************/	
}
?>


