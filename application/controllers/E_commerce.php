<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class E_commerce extends CI_Controller 
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
		$this->load->model('Igain_model');
		$this->load->model('E_commerce/E_commerce_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->library('Send_notification');
	}
	public function create_product_group()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['Logged_user_id'] = $session_data['userId'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Super_seller'] = $session_data['Super_seller'];
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/E_commerce/create_product_group";
			$total_row = $this->E_commerce_model->product_group_count();		
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
			/*-----------------------Pagination---------------------*/
			
			//*********** SANDEEP 13-03-2020 **********
				
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
				if($get_sellers != NULL){
				foreach($get_sellers as $seller_val)
				{
					$AllBrands[] = $seller_val->Enrollement_id;
					
				}}
				$AllBrands[] = $data['enroll'];
				//*********** SANDEEP 13-03-2020 **********
				
			if($_POST == NULL)
			{
				$data["results"] = $this->E_commerce_model->product_group_list($config["per_page"], $page,$data['Company_id']);
				$data["results1"] = $this->E_commerce_model->Inactive_product_group_list($config["per_page"], $page,$data['Company_id']);
				$data["pagination"] = $this->pagination->create_links();
				
				$this->load->view("E_commerce/create_product_group",$data);
			}
			else
			{		
				$seller = $this->input->post('seller_id');
				
				if($seller > 0){
				$result = $this->E_commerce_model->insert_product_group($data['Company_id'],$seller);
				}
				
				if($seller == 0){
				//	var_dump($AllBrands);exit;
					foreach($AllBrands as $seller_val)
					{
						$result = $this->E_commerce_model->insert_product_group($data['Company_id'],$seller_val);
					}
				
				}
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Group Inserted Successfuly");
					
					/*******************Insert igain Log Table*********************/
						$get_company_detail = $this->Igain_model->get_company_details($this->input->post('Company_id'));
						$Company_name=$get_company_detail->Company_name;
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Product Group";
						$where="Create / Edit Product Group";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('product_group_name');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Product Group. Please Provide valid data");
				}
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	function Check_product_group_name()
	{
		$result = $this->E_commerce_model->Check_product_group($this->input->post("productGroupName"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		}
	}
	function Check_product_brand_name()
	{
		$result = $this->E_commerce_model->Check_product_brand($this->input->post("product_brand_name"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		}
	}
	public function edit_product_group()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id']= $session_data['Company_id'];
			//*********** SANDEEP 13-03-2020 **********
				$Company_id = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['Logged_user_id'] = $session_data['userId'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Super_seller'] = $session_data['Super_seller'];
				
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/E_commerce/create_product_group";
			$total_row = $this->E_commerce_model->product_group_count();		
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
			/*-----------------------Pagination---------------------*/
			
			if($_GET['Product_group_id'])
			{
		//*********** SANDEEP 13-03-2020 **********			
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
				//*********** SANDEEP 13-03-2020 **********
				
				$Product_group_id =  $_GET['Product_group_id'];			
				$data['results'] = $this->E_commerce_model->edit_product_group($Product_group_id);
				$data["results2"] = $this->E_commerce_model->product_group_list($config["per_page"], $page,$data['Company_id']);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('E_commerce/edit_product_group', $data);
			}
			else
			{		
				redirect('E_commerce/create_product_group', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_product_group()
	{
		if($this->session->userdata('logged_in'))
		{
			
			if($_POST == NULL)
			{
				redirect('E_commerce/create_product_group', 'refresh');
			}
			else
			{
				$Product_group_id =  $this->input->post('Product_group_id');
				$post_data = array
				(					
					'product_group_name' => $this->input->post('product_group_name')
				);
				$result = $this->E_commerce_model->update_product_group($post_data,$Product_group_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Group Updated Successfuly");
					/*******************Insert igain Log Table*********************/
						$results = $this->E_commerce_model->edit_product_group($Product_group_id);
						$Product_group_name=$results->Product_group_name;
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Product Group";
						$where="Create / Edit Product Group";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Product_group_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Product Group!!");
				}
				redirect('E_commerce/create_product_group');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Active_product_group()
	{
		if($this->session->userdata('logged_in'))
		{
			
			if($_REQUEST == NULL)
			{
				redirect('E_commerce/create_product_group', 'refresh');
			}
			else
			{
				$Product_group_id =  $_REQUEST['Product_group_id'];
				$post_data = array
				(					
					'Active_flag' => 1
				);
				
				$result = $this->E_commerce_model->update_product_group($post_data,$Product_group_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Group Activeted Successfuly");
					/*******************Insert igain Log Table*********************/
						$results = $this->E_commerce_model->edit_product_group($Product_group_id);
						$Product_group_name=$results->Product_group_name;
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Product Group";
						$where="Create / Edit Product Group";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Product_group_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Product Group!!");
				}
				redirect('E_commerce/create_product_group');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function delete_product_group()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$Update_user_id = $session_data['enroll'];
			$Seller_id = $session_data['enroll'];
			$Super_seller= $session_data['Super_seller'];
			$Company_id= $session_data['Company_id'];
			
			if($_GET == NULL)
			{
				redirect('E_commerce/create_product_group', 'refresh');
			}
			else
			{
				$Product_group_id =  $_GET['Product_group_id'];
				$results = $this->E_commerce_model->edit_product_group($Product_group_id);
				$Product_group_name=$results->Product_group_name;
				$post_data = array
				(					
					'Active_flag' => 0
				);
			
				$result = $this->E_commerce_model->update_product_group($post_data,$Product_group_id);
				// $result = $this->E_commerce_model->delete_product_group($Product_group_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Group Deleted Successfuly!!");
									
					/*****************Delete Merchandise_item_ linked this partner********************/
					$All_Active_Merchandize_Product_Brand = $this->E_commerce_model->Get_product_group_linked_Product_Brand($Product_group_id,$Company_id);	
					
					if($All_Active_Merchandize_Product_Brand!=NULL)
					{
						foreach($All_Active_Merchandize_Product_Brand as $Val_Brand)
						{
							$post_data12 = array
							(					
								'Active_flag' => 0
							);
							
							$result = $this->E_commerce_model->update_product_brand($post_data12,$Val_Brand->Product_brand_id);
						}
					}
					$All_Active_Merchandize_Items_Records = $this->E_commerce_model->Get_product_group_linked_Merchandize_Items($Product_group_id,$Super_seller,$Seller_id);
					if($All_Active_Merchandize_Items_Records!=NULL)
					{
						foreach($All_Active_Merchandize_Items_Records as $Val)
						{
								
								/*********************INSERT Item LOG TABLE************************/
								$Post_data3=array(
								'Company_id'=>$Val->Company_id,
								'Company_merchandise_item_id'=>$Val->Company_merchandise_item_id,
								'Company_merchandize_item_code'=>$Val->Company_merchandize_item_code,
								'Partner_id'=>$Val->Partner_id,
								'Cost_price'=>$Val->Cost_price,
								'Valid_from'=>$Val->Valid_from,
								'Valid_till'=>$Val->Valid_till,
								'Markup_percentage'=>$Val->Markup_percentage,
								'Delivery_method'=>$Val->Delivery_method,
								'Merchandize_category_id'=>$Val->Merchandize_category_id,
								'Merchandize_item_name'=>$Val->Merchandize_item_name,
								'Merchandise_item_description'=>$Val->Merchandise_item_description,
								'Cost_payable_to_partner'=>$Val->Cost_payable_to_partner,
								'Billing_price'=>$Val->Billing_price,
								'VAT'=>$Val->VAT,
								'Item_image1'=>$Val->Item_image1,
								'Item_image2'=>$Val->Item_image2,
								'Item_image3'=>$Val->Item_image3,
								'Item_image4'=>$Val->Item_image4,
								'Thumbnail_image1'=>$Val->Thumbnail_image1,
								'Thumbnail_image2'=>$Val->Thumbnail_image2,
								'Thumbnail_image3'=>$Val->Thumbnail_image3,
								'Thumbnail_image4'=>$Val->Thumbnail_image4,
								'Billing_price_in_points'=>$Val->Billing_price_in_points,
								'show_item'=>$Val->show_item,
								'Ecommerce_flag'=>$Val->Ecommerce_flag,
								'Product_group_id'=>$Val->Product_group_id,
								'Product_brand_id'=>$Val->Product_brand_id,
								'Send_once_year'=>$Val->Send_once_year,
								'Send_other_benefits'=>$Val->Send_other_benefits,
								'Create_User_id'=>$Val->Create_User_id,
								'Creation_date'=>$Val->Creation_date,
								'Update_User_id'=>$Update_user_id,
								'Update_date'=>date("Y-m-d H:i:s"),
								'Active_flag'=>1);
						
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data3);
								/********************/
								/**************Update merchandise table**********/
								$Post_data2 = array
								(
									'Update_user_id'=>$Update_user_id,
									'Update_date'=>date("Y-m-d H:i:s"),
									'Thumbnail_image4'=>'Remarks:Product group deleted',
									'Active_flag'=>0
								);
								
								$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
								
								/**************delete temp cart linked item**********/
							
								$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item($Val->Company_merchandize_item_code,$Val->Company_id);							
						}
					}
							
					/*****************Delete Merchandise_item_ linked this group***XXX*****************/
					
					
					
					/*******************Insert igain Log Table*********************/
						
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 3;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Delete Product Group";
						$where="Create / Edit Product Group";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Product_group_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Product Group!!");
				}
				redirect('E_commerce/create_product_group');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function create_product_brand()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/E_commerce/create_product_brand";
			$total_row = $this->E_commerce_model->product_brand_count($data['Company_id']);		
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
			/*-----------------------Pagination---------------------*/
			
			if($_POST == NULL)
			{
				$data["Product_groups"] = $this->E_commerce_model->fetch_product_group_list($data['Company_id']);
				$data["results"] = $this->E_commerce_model->product_brand_list($config["per_page"], $page, $data['Company_id']);
				$data["results1"] = $this->E_commerce_model->Inactive_product_brand_list($config["per_page"], $page, $data['Company_id']);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view("E_commerce/create_product_brand",$data);
			}
			else
			{			
				$result = $this->E_commerce_model->insert_product_brand();
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Brand Inserted Successfuly");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Product Brand";
						$where="Create / Edit Product Brand";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('product_brand_name');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Product Brand. Please Provide valid data!!");
				}
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function edit_product_brand()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/E_commerce/create_product_brand";
			$total_row = $this->E_commerce_model->product_brand_count($data['Company_id']);		
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
			/*-----------------------Pagination---------------------*/
			
			if($_GET['Product_brand_id'])
			{
				$Product_brand_id =  $_GET['Product_brand_id'];			
				$data['results'] = $this->E_commerce_model->edit_product_brand($Product_brand_id);
				$data["results2"] = $this->E_commerce_model->product_brand_list($config["per_page"], $page, $data['Company_id']);
				$data["pagination"] = $this->pagination->create_links();
				$this->load->view('E_commerce/edit_product_brand', $data);
			}
			else
			{		
				redirect('E_commerce/create_product_brand', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_product_brand()
	{
		if($this->session->userdata('logged_in'))
		{
			
			if($_POST == NULL)
			{
				redirect('E_commerce/create_product_brand', 'refresh');
			}
			else
			{
				$Product_brand_id =  $this->input->post('Product_brand_id');
				$post_data = array
				(					
					'product_brand_name' => $this->input->post('product_brand_name')
				);
				$result = $this->E_commerce_model->update_product_brand($post_data,$Product_brand_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Brand Updated Successfuly");
					/*******************Insert igain Log Table*********************/
						$results = $this->E_commerce_model->edit_product_brand($Product_brand_id);
						$Product_brand_name=$results->Product_brand_name;
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Product Brand";
						$where="Create / Edit Product Brand";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('product_brand_name');
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Product Brand");
				}
				redirect('E_commerce/create_product_brand');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Active_product_brand()
	{
		if($this->session->userdata('logged_in'))
		{
			
			if($_REQUEST == NULL)
			{
				redirect('E_commerce/create_product_brand', 'refresh');
			}
			else
			{
				$Product_brand_id =  $_REQUEST['Product_brand_id'];
				$post_data = array
				(					
					'Active_flag' => 1
				);
				
				$result = $this->E_commerce_model->update_product_brand($post_data,$Product_brand_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Brand Activeted Successfuly");
					/*******************Insert igain Log Table*********************/
						$results = $this->E_commerce_model->edit_product_brand($Product_brand_id);
						$Product_group_name=$results->Product_group_name;
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Product Brand";
						$where="Create / Edit Product Brand";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Product_group_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Product Brand!!");
				}
				redirect('E_commerce/create_product_brand');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function delete_product_brand()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$Update_user_id = $session_data['enroll'];
			$Seller_id = $session_data['enroll'];
			$Super_seller= $session_data['Super_seller'];
			$Company_id= $session_data['Company_id'];
			
			if($_GET == NULL)
			{
				redirect('E_commerce/create_product_brand', 'refresh');
			}
			else
			{
				$Product_brand_id =  $_GET['Product_brand_id'];
				$results = $this->E_commerce_model->edit_product_brand($Product_brand_id);
				$Product_brand_name=$results->Product_brand_name;
				 
				$post_data = array
				(					
					'Active_flag' => 0
				);
			
				$result = $this->E_commerce_model->update_product_brand($post_data,$Product_brand_id);
				// $result = $this->E_commerce_model->delete_product_group($Product_group_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Product Brand Deleted Successfuly!!");
									
					
					$All_Active_Merchandize_Items_Records = $this->E_commerce_model->Get_product_barnd_linked_Merchandize_Items($Product_brand_id,$Super_seller,$Seller_id);
					if($All_Active_Merchandize_Items_Records!=NULL)
					{
						foreach($All_Active_Merchandize_Items_Records as $Val)
						{ 		
								/*********************INSERT Item LOG TABLE************************/
								$Post_data3=array(
								'Company_id'=>$Val->Company_id,
								'Company_merchandise_item_id'=>$Val->Company_merchandise_item_id,
								'Company_merchandize_item_code'=>$Val->Company_merchandize_item_code,
								'Partner_id'=>$Val->Partner_id,
								'Cost_price'=>$Val->Cost_price,
								'Valid_from'=>$Val->Valid_from,
								'Valid_till'=>$Val->Valid_till,
								'Markup_percentage'=>$Val->Markup_percentage,
								'Delivery_method'=>$Val->Delivery_method,
								'Merchandize_category_id'=>$Val->Merchandize_category_id,
								'Merchandize_item_name'=>$Val->Merchandize_item_name,
								'Merchandise_item_description'=>$Val->Merchandise_item_description,
								'Cost_payable_to_partner'=>$Val->Cost_payable_to_partner,
								'Billing_price'=>$Val->Billing_price,
								'VAT'=>$Val->VAT,
								'Item_image1'=>$Val->Item_image1,
								'Item_image2'=>$Val->Item_image2,
								'Item_image3'=>$Val->Item_image3,
								'Item_image4'=>$Val->Item_image4,
								'Thumbnail_image1'=>$Val->Thumbnail_image1,
								'Thumbnail_image2'=>$Val->Thumbnail_image2,
								'Thumbnail_image3'=>$Val->Thumbnail_image3,
								'Thumbnail_image4'=>$Val->Thumbnail_image4,
								'Billing_price_in_points'=>$Val->Billing_price_in_points,
								'show_item'=>$Val->show_item,
								'Ecommerce_flag'=>$Val->Ecommerce_flag,
								'Product_group_id'=>$Val->Product_group_id,
								'Product_brand_id'=>$Val->Product_brand_id,
								'Send_once_year'=>$Val->Send_once_year,
								'Send_other_benefits'=>$Val->Send_other_benefits,
								'Create_User_id'=>$Val->Create_User_id,
								'Creation_date'=>$Val->Creation_date,
								'Update_User_id'=>$Update_user_id,
								'Update_date'=>date("Y-m-d H:i:s"),
								'Active_flag'=>1);
						
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data3);
								
								/**************Update merchandise table**********/
								$Post_data2 = array
								(
									'Update_user_id'=>$Update_user_id,
									'Update_date'=>date("Y-m-d H:i:s"),
									'Thumbnail_image4'=>'Remarks:Product brand deleted',
									'Active_flag'=>0
								);
								
								$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
								
								/**************delete temp cart linked item**********/
							
								$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item($Val->Company_merchandize_item_code,$Val->Company_id);							
						}
					}
							
					/*****************Delete Merchandise_item_ linked this brand**************/					
					/*******************Insert igain Log Table*********************/
						
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 3;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Delete Product Group";
						$where="Create / Edit Product Group";
						$toname="";
						$To_enrollid ='';
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Product_group_name;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Product Brand!!");
				}
				redirect('E_commerce/create_product_brand');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
		
	public function image_upload()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			
			$this->load->view('E_commerce/upload_image', $data);
        }
    }
	
	public function upload_image()
	{
		$this->load->library('image_lib');
				
		$config = array
		(
			'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
			'max_size'          => 2048, //2MB max
			'max_width'          => 3000, //2MB max
			'max_height'          => 3000, //2MB max
			'upload_path'       => './image_uploads/original/' //upload directory
		);
				
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		/*-----------------------Image1-----------------------------*/
			if ( !$this->upload->do_upload("file1") )
			{			
				echo $this->upload->display_errors()."<br>";
			}
			else
			{
				$image_data1 = array('upload_data1' => $this->upload->data("file1"));
				
				/****************600 x 600*************/
					$config = array
					(
						'source_image'      => $image_data1['upload_data1']['full_path'], //path to the uploaded image
						'new_image'         => './image_uploads/original/', //path to
						'maintain_ratio'    => true,
						'overwrite'    => true,
						'width'             => 600,
						'height'            => 600
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				/****************600 x 600*************/
				
				/****************225 x 225*************/
					$config = array
					(
						'source_image'      => $image_data1['upload_data1']['full_path'],
						'new_image'         => './image_uploads/thumbs/',
						'maintain_ratio'    => true,
						'width'             => 225,
						'height'            => 225
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				/****************225 x 225*************/
			}
		/*-----------------------Image1-----------------------------*/
		
		
		/*-----------------------Image2-----------------------------*/
			if ( !$this->upload->do_upload("file2") )
			{			
				echo $this->upload->display_errors()."<br>";
			}
			else
			{
				$image_data2 = array('upload_data2' => $this->upload->data("file2"));
				
				/****************600 x 600*************/
					$config = array
					(
						'source_image'      => $image_data2['upload_data2']['full_path'], //path to the uploaded image
						'new_image'         => './image_uploads/original/', //path to
						'maintain_ratio'    => true,
						'overwrite'    => true,
						'width'             => 600,
						'height'            => 600
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				/****************600 x 600*************/
				
				/****************225 x 225*************/
					$config = array
					(
						'source_image'      => $image_data2['upload_data2']['full_path'],
						'new_image'         => './image_uploads/thumbs/',
						'maintain_ratio'    => true,
						'width'             => 225,
						'height'            => 225
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				/****************225 x 225*************/
			}
		/*-----------------------Image2-----------------------------*/
		
		/*-----------------------Image3-----------------------------*/
			if ( !$this->upload->do_upload("file3") )
			{			
				echo $this->upload->display_errors()."<br>";
			}
			else
			{
				$image_data3 = array('upload_data3' => $this->upload->data("file3"));
				
				/****************600 x 600*************/
					$config = array
					(
						'source_image'      => $image_data3['upload_data3']['full_path'], //path to the uploaded image
						'new_image'         => './image_uploads/original/', //path to
						'maintain_ratio'    => true,
						'overwrite'    => true,
						'width'             => 600,
						'height'            => 600
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				/****************600 x 600*************/
				
				/****************225 x 225*************/
					$config = array
					(
						'source_image'      => $image_data3['upload_data3']['full_path'],
						'new_image'         => './image_uploads/thumbs/',
						'maintain_ratio'    => true,
						'width'             => 225,
						'height'            => 225
					);
					
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				/****************225 x 225*************/
			}
		/*-----------------------Image3-----------------------------*/
	}
	/* public function upload_image()
	{		
		$this->load->library('image_lib');
		
		$config = array
		(
			'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
			'max_size'          => 2048, //2MB max
			'max_width'          => 3000, //2MB max
			'max_height'          => 3000, //2MB max
			'upload_path'       => './image_uploads/original/' //upload directory
		);
				
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( !$this->upload->do_upload("file"))
		{			
			echo $this->upload->display_errors();
		}
		else
		{
			$image_data = array('upload_data' => $this->upload->data("file"));
		}
		
		$config = array
		(
			'source_image'      => $image_data['upload_data']['full_path'], //path to the uploaded image
			'new_image'         => './image_uploads/original/', //path to
			'maintain_ratio'    => true,
			'overwrite'    => true,
			'width'             => 600,
			'height'            => 600
		);
		
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
		$config = array
		(
			'source_image'      => $image_data['upload_data']['full_path'], //path to the uploaded image
			'new_image'         => './image_uploads/resized/', //path to
			'maintain_ratio'    => true,
			'width'             => 450,
			'height'            => 450
		);
		
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
		$config = array
		(
			'source_image'      => $image_data['upload_data']['full_path'],
			'new_image'         => './image_uploads/thumbs/',
			'maintain_ratio'    => true,
			'width'             => 225,
			'height'            => 225
		);
		
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
    } */
	
	/*-----------------------------Ravi Changes-----31-10-2017-----------------------------*/
	
	public function update_order()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Company_id'] = $session_data['Company_id'];
			$data["Merchant_pin"] = $session_data['pinno'];
			$Company_details = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data['Pin_no_applicable'] = $Company_details->Pin_no_applicable;
			$data['Allow_merchant_pin'] = $Company_details->Allow_merchant_pin;
			$Company_website=$Company_details->Website;
			$this->load->view('E_commerce/Update_Order_View', $data);
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Validate_EVoucher() 
	{
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$Super_seller = $session_data['Super_seller'];
			$data["Merchant_pin"] = $session_data['pinno'];
			
			$Company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $Company_details->Pin_no_applicable;
			$data['Allow_merchant_pin'] = $Company_details->Allow_merchant_pin;
			$Company_website=$Company_details->Website;
			$Country=$Company_details->Country;
			$Redemptionratio=$Company_details->Redemptionratio;
			$Seller_details = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
			$currency_details = $this->Igain_model->Get_Country_master($Country);
			$data["Symbol_of_currency"] = $currency_details->Symbol_of_currency;
			$Symbol_of_currency=$data['Symbol_of_currency'];	
			
			$logtimezone = $session_data['timezone_entry'];
			$timezone = new DateTimeZone($logtimezone);
			$date = new DateTime();
			$date->setTimezone($timezone);
			$lv_date_time=$date->format('Y-m-d H:i:s');
			$Todays_date = $date->format('Y-m-d');	
			
			
			if($_POST == NULL)
			{					
				/*-----------------------Pagination---------------------*/			
				$config = array();
				$config["base_url"] = base_url() . "/index.php/E_commerce/Validate_EVoucher";
				$data['total_row'] = $this->E_commerce_model->redemtion_fulfillment('','',$Logged_user_id,$Super_seller,$data['enroll'],$data['Company_id']);
				
				//echo "total_row ".count($data['total_row']);
				$config["total_rows"] = count($data['total_row']);
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

				
				$data["pagination"] = $this->pagination->create_links();
				/*-----------------------Pagination---------------------*/
				
				$data["results"] = $this->E_commerce_model->redemtion_fulfillment($config["per_page"],$page,$Logged_user_id,$Super_seller,$data['enroll'],$data['Company_id']);
				$this->load->view('E_commerce/Update_Order_View', $data);
			}
			else
			{	
				// var_dump($_POST);	
				// die;
				$Item_id=$this->input->post('Item_id');	
				// echo"---Item_id---".$Item_id."--<br>";
				
				// die;
				if($Item_id !=NULL)
				{
					foreach($Item_id as $Item_id)
					{
						$evoucher=$this->input->post('Voucher_no'.$Item_id);   
						$Voucher_status=$this->input->post('Voucher_status'.$Item_id);   
						$MembershipID=$this->input->post('MembershipID'.$Item_id);
						$CompanyId=$Company_id;
						$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id'.$Item_id);
						$Branch_name=$this->input->post('Branch_name'.$Item_id);
						$Branch_Address=$this->input->post('Branch_Address'.$Item_id);
						$Redeem_points=$this->input->post('Redeem_points'.$Item_id);
						$Purchase_amount=$this->input->post('Purchase_amount'.$Item_id);
						$Loyalty_pts=$this->input->post('Loyalty_pts'.$Item_id);
						$Quantity=$this->input->post('Quantity'.$Item_id);
						$Trans_date=$this->input->post('Trans_date'.$Item_id);
						$Merchandize_item_name=$this->input->post('Merchandize_item_name'.$Item_id);
						$Item_code=$this->input->post('Item_code'.$Item_id);
						$Full_name=$this->input->post('Full_name'.$Item_id);
						$Bill_no=$this->input->post('Bill_no'.$Item_id);
						$Paid_amount=$this->input->post('Paid_amount'.$Item_id);
						$Online_payment_method=$this->input->post('Online_payment_method'.$Item_id);
						$Shipping_points=$this->input->post('Shipping_points'.$Item_id);
						$Old_Voucher_status=$this->input->post('Old_Voucher_status'.$Item_id);
						$Shipping_partner=$this->input->post('Shipping_partner'.$Item_id);
						$Trans_type=$this->input->post('Trans_type'.$Item_id);
						
						$result = $this->E_commerce_model->Update_purchase_item_Status($MembershipID,$CompanyId,$evoucher,$data['enroll'],$Voucher_status,$Shipping_partner);
						
						// echo"---Voucher_status---".$Voucher_status."--<br>";
						$Calc_Credit_points=0;
						if($Voucher_status==18) // Ordered
						{
							$this->session->set_flashdata("error_code"," This order already in Ordered Status!!");			
							redirect("E_commerce/update_order");
						}
						if($Voucher_status==20 && $Loyalty_pts > 0) // Delivered
						{
							$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							$CardId = $Enroll_details->Card_id;
                            $Current_balance = $Enroll_details->Current_balance;							
							$new_cur_bal=$Current_balance+$Loyalty_pts;							
							$result = $this->E_commerce_model->Update_member_balance($CompanyId,$Cust_Enrollement_id,$new_cur_bal);	
							
							$Email_content11 = array
							(
								// 'Notification_type' =>$New_offer_name,
								'Transaction_date' => $Trans_date,											
								'Offer_name' =>"Loyalty Points Issued ",
								'Orderno' => $Bill_no,
								'Loyalty_pts' => $Loyalty_pts,
								'Purchase_quantity' =>$Quantity,  
								'Template_type' => 'Purchase_loyalty_bonus_points'
							);	
							$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content11,'1',$CompanyId);								
						}
						if($Voucher_status== 21) //  'Cancel' Customer Cancel order and Get back Reddem Points 
						{
							$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							$CardId = $Enroll_details->Card_id;
                            $Current_balance = $Enroll_details->Current_balance;							
                            $total_purchase = $Enroll_details->total_purchase;							
                            $Total_reddems = $Enroll_details->Total_reddems;							
                            $Total_topup_amt = $Enroll_details->Total_topup_amt;
							$balance_to_pay_in_points = round($Paid_amount*$Redemptionratio);
								
							if($Online_payment_method == 'COD')
							{					
								$Calc_Credit_points=$Redeem_points;//when ordered or shipped
								if($Trans_type==10 && $Old_Voucher_status==18)//Redemption & ordered
								{
									$Calc_Credit_points=($Redeem_points+$Shipping_points);//when ordered
								}
								$New_Total_topup_amt=$Total_topup_amt+$Calc_Credit_points;
								
							}
							else
							{
								$Calc_Credit_points=$Redeem_points+$balance_to_pay_in_points;
								
								if($Trans_type!=10 && $Old_Voucher_status==19)//shipped
								{
									$Calc_Credit_points=$Redeem_points+$balance_to_pay_in_points-$Shipping_points;
								}
								if($Trans_type==10 && $Old_Voucher_status==18)//Redemption & ordered
								{
									$Calc_Credit_points=($Redeem_points+$Shipping_points);//when ordered
								}
								$New_Total_topup_amt=$Total_topup_amt+$Calc_Credit_points;
							}
							$Calc_Credit_points=(abs($Calc_Credit_points));							
							$new_cur_bal=($Current_balance+$Calc_Credit_points);
							$new_purchase_AMT=$total_purchase-$Purchase_amount;
							$New_Total_Redeem_points=$Total_reddems-$Redeem_points;
							$result2 = $this->E_commerce_model->update_customer_balance($CardId,abs($new_cur_bal),$CompanyId,abs($New_Total_topup_amt),$lv_date_time,abs($new_purchase_AMT),abs($New_Total_Redeem_points));
							// die;
							/**************Insert transaction**********************/
							$Insert_data = array(
								'Trans_type' => 17,//Purchase Cancel
								'Trans_date' => $Trans_date,
								'Item_code' => $Item_code,
								'Voucher_no' => $evoucher,
								'Topup_amount' => $Calc_Credit_points,
								'Quantity' => $Quantity,
								'Remarks' => 'Order Cancel',
								'Voucher_status' => $Voucher_status,
								'Enrollement_id' => $Cust_Enrollement_id,
								'Bill_no' => $Bill_no,
								'Card_id' => $CardId,
								'Company_id' => $CompanyId,
								'Online_payment_method' => $Online_payment_method,
								'Seller_name' => $data['LogginUserName'],
								'Update_User_id' => $data['enroll'],
								'Update_date' => date('Y-m-d H:i:s'),
								'Remarks' => 'Order Cancel'    
								);						
							$InsertCredit=$this->E_commerce_model->Insert_purchase_canncel_item($Insert_data);
						}
						
						if($Voucher_status== 23 ) // 'Returned' Customer Cancel order and Get back Reddem Points 
						{							
							$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							$CardId = $Enroll_details->Card_id;
                            $Current_balance = $Enroll_details->Current_balance;							
                            $total_purchase = $Enroll_details->total_purchase;							
                            $Total_reddems = $Enroll_details->Total_reddems;							
                            $Total_topup_amt = $Enroll_details->Total_topup_amt;

							$balance_to_pay_in_points = round($Paid_amount*$Redemptionratio);
							$Calc_Credit_points=($Redeem_points+$balance_to_pay_in_points-$Shipping_points-$Loyalty_pts);
							if($Trans_type==10)//Redemption
							{
								$Calc_Credit_points=($Redeem_points);
							}	
							$Calc_Credit_points=(abs($Calc_Credit_points));		
							
							
							$new_cur_bal=($Current_balance+$Calc_Credit_points);
							$new_purchase_AMT=$total_purchase-$Purchase_amount;
							$New_Total_Redeem_points=$Total_reddems-$Redeem_points;
							$New_Total_topup_amt=$Total_topup_amt+$Calc_Credit_points;
							
							$result2 = $this->E_commerce_model->update_customer_balance($CardId,abs($new_cur_bal),$CompanyId,abs($New_Total_topup_amt),$lv_date_time,abs($new_purchase_AMT),abs($New_Total_Redeem_points));
							
														
							/**************Insert transaction**********************/
							$Insert_data = array(
								'Trans_type' => 22,//Purchase Returned Type
								'Trans_date' => $Trans_date,
								'Item_code' => $Item_code,
								'Voucher_no' => $evoucher, 
								'Topup_amount' => $Calc_Credit_points,
								'Quantity' => $Quantity,
								'Remarks' => 'Order Returned',
								'Voucher_status' => $Voucher_status,
								'Enrollement_id' => $Cust_Enrollement_id,
								'Bill_no' => $Bill_no,
								'Card_id' => $CardId,
								'Company_id' => $CompanyId,
								'Online_payment_method' => $Online_payment_method,
								'Seller_name' => $data['LogginUserName'],
								'Update_User_id' => $data['enroll'],
								'Update_date' => date('Y-m-d H:i:s'),
								'Remarks' => 'Order Returned'    
								);						
							$InsertCredit=$this->E_commerce_model->Insert_purchase_canncel_item($Insert_data);
						}
						if($Voucher_status== 22 ) // 'Return Initiated' Mail goes to Merchandize Partener & Supper Seller 
						{							
							$Item_details = $this->E_commerce_model->Get_Merchandize_Item_details($Item_code,$CompanyId);
							$Partner_id=$Item_details->Partner_id;
							
							$Partner_details = $this->E_commerce_model->Get_Merchandize_Partenr_details($Partner_id,$CompanyId);
							$Partner_email=$Partner_details->Partner_contact_person_email;
							$Partner_name=$Partner_details->Partner_contact_person_name;			
														
							$Seller_email=$Seller_details->User_email_id;
							$Seller_name=$Seller_details->First_name.' '.$Seller_details->Last_name;						
							
							$Email_content = array(
							'Trans_date' => $Trans_date,
							'Merchandize_item_name' => $Merchandize_item_name,
							'evoucher' => $evoucher,
							'Order_no' => $Bill_no,
							'Purchase_amount' => $Purchase_amount,
							'Redeem_points' => $Redeem_points,
							'Branch_name' => $Branch_name,
							'Branch_Address' => $Branch_Address,
							'Notification_type' => $Notification_type,
							'Voucher_status' => $Voucher_status,
							'Symbol_of_currency' => $Symbol_of_currency,
							'Credit_points' => $Calc_Credit_points,
							'Partner_email' => $Partner_email,
							'Partner_name' => $Partner_name,
							'Seller_email' => $Seller_email,
							'Template_type' => 'Purchase_Return_Initiated'
							);			
							$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$CompanyId);
						}						
						if($Voucher_status== 19 ) //'Shipped'
						{
							$Notification_type='Shipped';
						}
						else if($Voucher_status== 20) //'Delivered'
						{
							$Notification_type='Delivered';
						}
						else if($Voucher_status== 21 ) //'Cancel'
						{
							$Notification_type='Cancel';
						}
						else if($Voucher_status== 22 ) //'Return Initiated'
						{
							$Notification_type='Return Initiated';
						}
						else if($Voucher_status== 23 ) //'Returned'
						{
							$Notification_type='Returned';
						}
						else if($Voucher_status== 111 ) //'Accepted'
						{
							$Notification_type='Accepted';
						}
						
						$Email_content = array(
							'Trans_date' => $Trans_date,
							'Merchandize_item_name' => $Merchandize_item_name,
							'evoucher' => $evoucher,
							'Order_no' => $Bill_no,
							'Purchase_amount' => $Purchase_amount,
							'Redeem_points' => $Redeem_points,
							'Branch_name' => $Branch_name,
							'Branch_Address' => $Branch_Address,
							'Notification_type' => $Notification_type,
							'Voucher_status' => $Voucher_status,
							'Symbol_of_currency' => $Symbol_of_currency,
							'Credit_points' => $Calc_Credit_points,
							'Template_type' => 'Purchase_item_status'
						);			
						$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$CompanyId);
						
						
						if($Voucher_status ==18)
						{
							$voucherStatus='Ordered';
						}
						elseif($Voucher_status ==19)
						{
							$voucherStatus='Shipped';
						}
						elseif($Voucher_status ==20)
						{
							$voucherStatus='Delivered';
						}
						elseif($Voucher_status ==21)
						{
							$voucherStatus='Cancel';
						}
						elseif($Voucher_status ==22)
						{
							$voucherStatus='Return Initiated';
						}
						elseif($Voucher_status ==23)
						{
							$voucherStatus='Returned';
						}
						elseif($Voucher_status ==111)
						{
							$voucherStatus='Accepted';
						}						
						/*******************Insert igain Log Table*********************/						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Purcase order Status";
						$where="Update Purcase order Status";
						$toname="";
						$To_enrollid =0;
						$firstName = $Full_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $evoucher.' Status: '.$voucherStatus;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
						/*******************Insert igain Log Table*********************/
					}
					
					$this->session->set_flashdata("success_code","Online Purchase Item ".$voucherStatus." Successfully!!");				
					redirect("E_commerce/update_order");
				}
				else
				{
					$this->session->set_flashdata("error_code","Please Select atleast one evoucher !!!");
					redirect("E_commerce/update_order");
				}
				
			}
		} 
		else
		{		
			redirect('Login', 'refresh');
		}
	
	}
	function Get_evouchers_details()
	{
		$voucher = $this->input->post("voucher");
		$CompanyId = $this->input->post("Company_id");
		$Pin_no_applicable = $this->input->post("Pin_no_applicable");
		$Allow_merchant_pin = $this->input->post("Allow_merchant_pin");
		$result = $this->E_commerce_model->Get_evouchers_details($voucher,$CompanyId);
		$Trans_id=0;
		if($result !="")		
		{
			foreach($result as $res)
			{
				$Trans_id=$res->Trans_id;
			}
		}		
		// echo"---Trans_id--".$Trans_id."--<br>";
		$shipping_result = $this->E_commerce_model->Get_shipping_details($Trans_id,$CompanyId);
		$result_free = $this->E_commerce_model->Get_free_evouchers_details($voucher,$CompanyId);
		$data["Code_decode_Records"] = $this->E_commerce_model->Get_Code_decode_master($CompanyId);
		$data["Shipping_partner"] = $this->E_commerce_model->Get_partner($CompanyId);
		$data["Allow_merchant_pin"]=$Allow_merchant_pin;
		$data["Pin_no_applicable"]=$Pin_no_applicable;
		$data["voucher"]=$voucher;
		$data["results"]=$result;
		$data["free_results"]=$result_free;
		$data["shipping_result"]=$shipping_result;
		$this->load->view('E_commerce/Show_vouchers', $data);		
	}
	function Voucher_validation()
	{
		$voucher = $this->input->post("voucher");
		$CompanyId = $this->input->post("Company_id");
		$result = $this->E_commerce_model->validate_voucher($voucher,$CompanyId);
		
		if(count($result) > 0)
		{
			
			$this->output->set_output(1);
		}
		else    
		{
			$this->output->set_output(0);
		}
	}
	function validate_card_id()
	{
		$Card_id=0;
		$voucher_result= $this->E_commerce_model->Get_evouchers_details($this->input->post("voucher"),$this->input->post("Company_id"));
		
	//	var_dump($voucher_result);
		
		// $Card_id=$voucher_result->Card_id;
		if($voucher_result )
		{
			foreach($voucher_result as $res)
			{
				$Card_id=$res->Card_id;
			}
		}
		if($Card_id != 0)
		{
			$result = $this->Transactions_model->get_member_info($Card_id,$this->input->post("Company_id"),0);
			
			if($result != NULL)
			{
				$result->User_email_id = App_string_decrypt($result->User_email_id);
				$result->Phone_no = App_string_decrypt($result->Phone_no);
				// $this->output->set_output("Valid");
				echo json_encode($result);
			}
		}		
		else    
		{
			// $this->output->set_output("InValid");
			$json_value = array('Card_id' => 0);
			echo json_encode($json_value);
		}
	}
	function return_order()
	{  
		// return_order
		if($this->session->userdata('logged_in'))
		{
			
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			$Super_seller = $session_data['Super_seller'];
			$data["Merchant_pin"] = $session_data['pinno'];
			
			$Company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $Company_details->Pin_no_applicable;
			$data['Allow_merchant_pin'] = $Company_details->Allow_merchant_pin;
			$Company_website=$Company_details->Website;
			$Country=$Company_details->Country;
			$Redemptionratio=$Company_details->Redemptionratio;
			$Seller_details = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
			$currency_details = $this->Igain_model->Get_Country_master($Country);
			$data["Symbol_of_currency"] = $currency_details->Symbol_of_currency;
			$Symbol_of_currency=$data['Symbol_of_currency'];
			$data["Code_decode_Records"] = $this->E_commerce_model->Get_Code_decode_master($Company_id);
			
			if($_POST == NULL)
			{					
				/*-----------------------Pagination---------------------*/			
				$config = array();
				$config["base_url"] = base_url() . "/index.php/E_commerce/return_order";
				$data['total_row'] = $this->E_commerce_model->Get_ecommerce_return_orders_count('','',$data['Company_id']);
				
				//echo "total_row ".$data['total_row'];
				$config["total_rows"] = $data['total_row'];
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

				
				$data["pagination"] = $this->pagination->create_links();
				/*-----------------------Pagination---------------------*/
				
				$data["returnOrders"] = $this->E_commerce_model->Get_ecommerce_return_orders($config["per_page"],$page,$data['Company_id']);
				$this->load->view('E_commerce/return_order', $data);
			}
			else
			{					
				$Item_id=$this->input->post('Item_id');					
				if($Item_id !=NULL)
				{
					foreach($Item_id as $Item_id)
					{
						// echo"---Item_id----".$Item_id."----<br>";
						
						$evoucher=$this->input->post('Voucher_no'.$Item_id);   
						$Voucher_status=$this->input->post('Voucher_status'.$Item_id);   
						$MembershipID=$this->input->post('MembershipID'.$Item_id);
						$CompanyId=$Company_id;
						$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id'.$Item_id);
						$Branch_name=$this->input->post('Branch_name'.$Item_id);
						$Branch_Address=$this->input->post('Branch_Address'.$Item_id);
						$Redeem_points=$this->input->post('Redeem_points'.$Item_id);
						$Purchase_amount=$this->input->post('Purchase_amount'.$Item_id);
						$Loyalty_pts=$this->input->post('Loyalty_pts'.$Item_id);
						$Quantity=$this->input->post('Quantity'.$Item_id);
						$Trans_date=$this->input->post('Trans_date'.$Item_id);
						$Merchandize_item_name=$this->input->post('Merchandize_item_name'.$Item_id);
						$Item_code=$this->input->post('Item_code'.$Item_id);
						$Full_name=$this->input->post('Full_name'.$Item_id);
						$Bill_no=$this->input->post('Bill_no'.$Item_id);
						$Paid_amount=$this->input->post('Paid_amount'.$Item_id);
						$Shipping_points=$this->input->post('Shipping_points'.$Item_id);
						$Online_payment_method=$this->input->post('Online_payment_method'.$Item_id);										
						$Trans_type=$this->input->post('Trans_type'.$Item_id);										
						
						// echo"---Voucher_status----".$Voucher_status."----<br>";
						// die;
						$result = $this->E_commerce_model->Update_purchase_item_Status($MembershipID,$CompanyId,$evoucher,$data['enroll'],$Voucher_status,0);
						
						
						$Calc_Credit_points=0;
						
						if($Voucher_status== 23 ) // 'Returned' Customer Cancel order and Get back Reddem Points 
						{							
							
							$Enroll_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							$CardId = $Enroll_details->Card_id;
                            $Current_balance = $Enroll_details->Current_balance;							
                            $total_purchase = $Enroll_details->total_purchase;							
                            $Total_reddems = $Enroll_details->Total_reddems;							
                            $Total_topup_amt = $Enroll_details->Total_topup_amt;

							$balance_to_pay_in_points = round($Paid_amount*$Redemptionratio);
							
							$Calc_Credit_points=($Redeem_points+$balance_to_pay_in_points-$Shipping_points-$Loyalty_pts);	
							if($Trans_type==10)//Redemption
							{
								$Calc_Credit_points=($Redeem_points);
							}	
							$Calc_Credit_points=(abs($Calc_Credit_points));		
							
							
							$new_cur_bal=($Current_balance+$Calc_Credit_points);
							
							$new_purchase_AMT=$total_purchase-$Purchase_amount;
							$New_Total_Redeem_points=$Redeem_points-$Total_reddems;
							$New_Total_topup_amt=$Total_topup_amt+$balance_to_pay_in_points;
							
							$result2 = $this->E_commerce_model->update_customer_balance($CardId,abs($new_cur_bal),$CompanyId,abs($New_Total_topup_amt),$lv_date_time,abs($new_purchase_AMT),abs($New_Total_Redeem_points));
							
														
							/**************Insert transaction**********************/
							$Insert_data = array(
								'Trans_type' => 22,//Purchase Returned
								'Trans_date' => $Trans_date,
								'Item_code' => $Item_code,
								'Voucher_no' => $evoucher,
								'Topup_amount' => $Calc_Credit_points,
								'Quantity' => $Quantity,
								'Remarks' => 'Order Returned',
								'Voucher_status' => $Voucher_status,
								'Enrollement_id' => $Cust_Enrollement_id,
								'Bill_no' => $Bill_no,
								'Card_id' => $CardId,
								'Company_id' => $CompanyId,
								'Online_payment_method' => $Online_payment_method,
								'Seller_name' => $data['LogginUserName'],
								'Update_User_id' => $data['enroll'],
								'Update_date' => date('Y-m-d H:i:s'),
								'Remarks' => 'Order Returned'    
								);						
							$InsertCredit=$this->E_commerce_model->Insert_purchase_canncel_item($Insert_data);
						}												
						if($Voucher_status== 23 ) //'Returned'
						{
							$Notification_type='Returned';
						}			
							
						$Email_content = array(
							'Trans_date' => $Trans_date,
							'Merchandize_item_name' => $Merchandize_item_name,
							'evoucher' => $evoucher,
							'Order_no' => $Bill_no,
							'Purchase_amount' => $Purchase_amount,
							'Redeem_points' => $Redeem_points,
							'Branch_name' => $Branch_name,
							'Branch_Address' => $Branch_Address,
							'Notification_type' => $Notification_type,
							'Voucher_status' => $Voucher_status,
							'Symbol_of_currency' => $Symbol_of_currency,
							'Credit_points' => $Calc_Credit_points,
							'Template_type' => 'Purchase_item_status'
						);	
						
						$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$CompanyId);
						
						
						if($Voucher_status ==23)
						{
							$voucherStatus='Returned';
						}
						
						/*******************Insert igain Log Table*********************/						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Purcase order Status";
						$where="Update Purcase order Status";
						$toname="";
						$To_enrollid =0;
						$firstName = $Full_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $evoucher.' Status: '.$voucherStatus;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
						/*******************Insert igain Log Table*********************/
					}
					
					$this->session->set_flashdata("success_code","Online Purchase Item ".$voucherStatus." Successfully!!");				
					redirect("E_commerce/return_order");
				}
				else
				{
					$this->session->set_flashdata("error_code","Please Select atleast one evoucher !!!");
					redirect("E_commerce/return_order");
				}
				
			}
		} 
		else
		{		
			redirect('Login', 'refresh');
		}
		
		
		
	}	
	/*-----------------------------Ravi Changes----31-10-2017-----------------------------*/
}
?>

