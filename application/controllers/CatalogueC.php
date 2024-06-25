<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class CatalogueC extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();	
			
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Send_notification');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('E_commerce/E_commerce_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('Report/Report_model');
		$this->load->library('image_lib');
		
	}
	/**************************Create Merchandise Partners Start********************/
	public function Register_Merchandize_Partners()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;	
			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Register_Merchandize_Partners";
			$total_row = $this->Catelogue_model->Get_Company_Partners_Count($Company_id);
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
			/*-----------------------File Upload---------------------*/
				if(!is_dir('Partners_logo'))
				{
					$result = mkdir('Partners_logo',0777,true);
				}
				$config['upload_path'] = './Partners_logo/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '700';
				$config['max_height'] = '700';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
				
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners($config["per_page"], $page,$Company_id);
			
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Register_Merchandize_PartnersV', $data);
			} 
			else
			{
				/* if(!$this->upload->do_upload("file"))
				{
					$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$Partner_logo = "";
					
				}
				else
				{
					
					$data = array('upload_data' => $this->upload->data("file"));
					$Partner_logo = "Partners_logo/".$data['upload_data']['file_name'];
				} */
				
				/* Create the config for image library */
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
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './Partners_logo/'.$upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$Partner_logo='Partners_logo/'.$data22['file_name'];
				}
				else
				{
					$Partner_logo = "images/no_image.jpg";
				}
				
				$Post_data=array('Partner_type'=>$this->input->post('Partner_type'),
				'Company_id'=>$this->input->post('Company_id'),
				'Partner_name'=>$this->input->post('Partner_name'),
				'Partner_address'=>$this->input->post('Partner_address'),
				'Country_id'=>$this->input->post('country'),
				'State'=>$this->input->post('state'),
				'City'=>$this->input->post('city'),
				'Partner_contact_person_name'=>$this->input->post('Partner_contact_person_name'),
				'Partner_contact_person_phno'=>$this->input->post('Partner_contact_person_phno'),
				'Partner_contact_person_email'=>$this->input->post('Partner_contact_person_email'),
				'Partner_logo'=>$Partner_logo,
				'Partner_website'=>$this->input->post('Partner_website'),
				'Partner_vat'=>$this->input->post('Partner_vat'),
				'Partner_redemption_ratio'=>$this->input->post('Partner_Redemptionratio'),
				'Partner_markup_percentage'=>$this->input->post('Partner_markup_percentage'),
				'Create_user_id'=>$this->input->post('Create_user_id'),
				'Create_date'=>$this->input->post('Create_date'),
				'Active_flag'=>1);
				
				$Phone_no = $this->input->post('Partner_contact_person_phno');
				$EmailId  = $this->input->post('Partner_contact_person_email');
				
				$uvalidate = $this->Catelogue_model->check_phone_email($Phone_no,$EmailId,$this->input->post('Company_id'));
				
				if($uvalidate == 0){
					$result = $this->Catelogue_model->Insert_Merchandize_Partner($Post_data);
				}
				
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Partner Register Successfuly!!");
					
					/*******************Insert igain Log Table*********************/	
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Register Merchandise Partners";
						$where="Register Company Merchandise Partners";
						$toname="";
						$To_enrollid =$result;
						$firstName = $this->input->post('Partner_name');
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval =$this->input->post('Partner_name');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Partner Register Error!!");
				}
				redirect("CatalogueC/Register_Merchandize_Partners");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	public function Edit_Merchandize_Partners()
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
			
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;	
			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Register_Merchandize_Partners";
			$total_row = $this->Catelogue_model->Get_Company_Partners_Count($Company_id);
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
			/*-----------------------File Upload---------------------*/
				if(!is_dir('Partners_logo'))
				{
					$result = mkdir('Partners_logo',0777,true);
				}
				$config['upload_path'] = './Partners_logo/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '5000';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
				
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners($config["per_page"], $page,$Company_id);
			$lv_Partner_id=$_REQUEST["Partner_id"];
			$data["Partner_Row"] = $this->Catelogue_model->Get_Company_Partners_details($lv_Partner_id);
			$data['States_array'] = $this->Igain_model->Get_states($data['Partner_Row']->Country_id);	
			$data['City_array'] = $this->Igain_model->Get_cities($data['Partner_Row']->State);
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Edit_Merchandize_PartnersV', $data);
			}
			else
			{
				$Update_Partner_id=	$this->input->post('Update_Partner_id') ;
					// echo '<br>lv_Partner_id '.$lv_Partner_id;
					// echo '<br>Update_Partner_id '.$Update_Partner_id;die;
				/* if(!$this->upload->do_upload("file"))
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$Partner_logo =$this->input->post('Partner_logo') ;
					
				}
				else
				{
					
					$data = array('upload_data' => $this->upload->data("file"));
					$Partner_logo = "Partners_logo/".$data['upload_data']['file_name'];
				} */
				
				/* Create the config for image library */
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
					$configThumb['source_image'] = $data22['full_path'];
					$configThumb['source_image'] = './Partners_logo/'.$upload22;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$Partner_logo='Partners_logo/'.$data22['file_name'];
				}
				else
				{
					$Partner_logo = $this->input->post("Partner_logo");
				}
				
				/*******Update Billing price points in merchandise table******AMIT 28-07-2017-*/
				/***Get Redemptionratio***
				$Company_details = $this->Igain_model->get_company_details($Company_id);
				$Company_Redemptionratio=$Company_details->Redemptionratio;
				/********/
				
				/*****************AMIT 28-07-2017-- END------------------*/	
				
				$Post_data=array(
				'Partner_type'=>$this->input->post('Partner_type'),
				'Partner_name'=>$this->input->post('Partner_name'),
				'Partner_address'=>$this->input->post('Partner_address'),
				'Country_id'=>$this->input->post('country'),
				'State'=>$this->input->post('state'),
				'City'=>$this->input->post('city'),
				'Partner_redemption_ratio'=>$this->input->post('Partner_Redemptionratio'),
				'Partner_contact_person_name'=>$this->input->post('Partner_contact_person_name'),
				'Partner_contact_person_phno'=>$this->input->post('Partner_contact_person_phno'),
				'Partner_contact_person_email'=>$this->input->post('Partner_contact_person_email'),
				'Partner_logo'=>$Partner_logo,
				'Partner_website'=>$this->input->post('Partner_website'),
				'Partner_vat'=>$this->input->post('Partner_vat'),
				'Partner_markup_percentage'=>$this->input->post('Partner_markup_percentage'),
				'Update_user_id'=>$this->input->post('Update_user_id'),
				'Update_date'=>$this->input->post('Update_date'));
				
				$result = $this->Catelogue_model->Update_Merchandize_Partner($Update_Partner_id,$Post_data);
				if($result == true)
				{
					$Vat_margin_changed_flag=$this->input->post('Vat_margin_changed_flag');
					$Partner_vat=$this->input->post('Partner_vat');
					$Partner_markup_percentage=$this->input->post('Partner_markup_percentage');
					$Partner_Redemptionratio=$this->input->post('Partner_Redemptionratio');
					if($Vat_margin_changed_flag==1)
					{
						$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Merchandize_Items_partner_update($lv_Partner_id,$Company_id);//die;
						// print_r($All_Active_Merchandize_Items_Records);die;
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
								'Create_User_id'=>$data['enroll'],
								'Creation_date'=>date("Y-m-d H:i:s"),
								'Update_User_id'=>$data['enroll'],
								'Update_date'=>date("Y-m-d H:i:s"),
								'Active_flag'=>1);
						
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data3);
								/********************/
								$New_Cost_to_partner=(($Val->Cost_price*$Partner_vat)/100)+$Val->Cost_price;
								$New_Billing_price=(($New_Cost_to_partner*$Partner_markup_percentage)/100)+$New_Cost_to_partner;
								$New_redeem_points=($New_Billing_price*$Partner_Redemptionratio);
								$Post_data2 = array
								(
									'VAT'=>$Partner_vat,
									'Seller_Redemptionratio'=>$Partner_Redemptionratio,
									'Markup_percentage'=>$Partner_markup_percentage,
									'Billing_price'=>$New_Billing_price,
									'Cost_payable_to_partner'=>$New_Cost_to_partner,
									'Billing_price_in_points'=>$New_redeem_points,
									'Update_user_id'=>$data['enroll'],
									'Update_date'=>date("Y-m-d H:i:s")
								);
								
								/**************Update Billing price points in merchandise table**********/
								$Update_new_redeem_points = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
								
							}
						}
						
							
					}
					// die;
				
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Partner Updated Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Merchandise Partners";
					$where="Register Company Merchandise Partners";
					$toname="";
					$To_enrollid =0;
					$firstName = $this->input->post('Partner_name');
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Partner_name');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Update_Partner_id);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Partner Updated Error!!");
				}
				redirect("CatalogueC/Register_Merchandize_Partners");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function Delete_Merchandize_Partners()
	{
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$Seller_id = $session_data['enroll'];
		$Super_seller= $session_data['Super_seller'];
			
			
		$Update_date=date("Y-m-d H:i:s");
		
		$Partner_id=$_REQUEST["Partner_id"];
		
		$result = $this->Catelogue_model->Delete_Merchandize_Partners($Partner_id,$Update_user_id,$Update_date);
		if($result == true)
		{
			$this->session->set_flashdata("success_code","Partner Deleted Successfuly!!");
			
			/*****************Delete Merchandise_item_ linked this partner********************/
			$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Partner_linked_Merchandize_Items($Partner_id,$Super_seller,$Seller_id);
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
							'Thumbnail_image4'=>'Remarks:Merchandise Partner deleted',
							'Active_flag'=>0
						);
						$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
					/**************delete temp cart linked item**********/
						$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item($Val->Company_merchandize_item_code,$Val->Company_id);
					
				}
			}
					
			/*****************Delete Merchandise_item_ linked this partner***XXX*****************/
			
			
			
		/*******************Insert igain Log Table*********************/
			$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($Partner_id);
			$Partner_id = $get_partner_detail->Partner_id;
			$Partner_name = $get_partner_detail->Partner_name;
			
			$Company_id	= $session_data['Company_id'];
			$Todays_date = date('Y-m-d');	
			$opration = 3;		
			$enroll	= $session_data['enroll'];
			$username = $session_data['username'];
			$userid=$session_data['userId'];
			$what="Delete Merchandise Partners";
			$where="Register Company Merchandise Partners";
			$toname="";
			$To_enrollid =0;
			$firstName = $Partner_name;
			$lastName = '';
			$Seller_name = $session_data['Full_name'];
			$opval = $Partner_name;
			$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
		/*******************Insert igain Log Table*********************/
		}
		else
		{
			$this->session->set_flashdata("error_code","Error Deleting Partner!!");
		}
		
		redirect("CatalogueC/Register_Merchandize_Partners");
	}
	
	
	/**************************************************Create Merchandise Partners End*************************************/
	/**************************************************Create Merchandise Partners Branch Start*************************************/
	
	public function Create_Merchandize_Partner_Branch()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;	
			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Register_Merchandize_Partners";
			$total_row = $this->Catelogue_model->Get_Company_Partners_Branch_Count($Company_id);
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
		
				
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			
			$data["Partner_Branch_Records"] = $this->Catelogue_model->Get_Company_Partners_Branches($config["per_page"], $page,$Company_id);
			
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Merchandize_Partner_BranchV', $data);
			}
			else
			{	
				$Post_data=array(
				'Company_id'=>$Company_id,
				'Partner_id'=>$this->input->post('Partner_id'),
				'Branch_code'=>$this->input->post('Branch_code'),
				'Branch_name'=>$this->input->post('Branch_name'),
				'Address'=>$this->input->post('Branch_address'),
				'Country_id'=>$this->input->post('country'),
				'State'=>$this->input->post('state'),
				'City'=>$this->input->post('city'),
				'Zip'=>$this->input->post('zip'),
				// 'Latitude'=>$this->input->post('Latitude'),
				// 'Longitude'=>$this->input->post('Longitude'),
				'Create_User_id'=>$this->input->post('Create_user_id'),
				'Creation_date'=>$this->input->post('Create_date'),
				'Active_flag'=>1);
				
				$result = $this->Catelogue_model->Insert_Merchandize_Partner_Branch($Post_data);
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Partner Branch Created Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
					$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($this->input->post('Partner_id'));
					$Partner_id = $get_partner_detail->Partner_id;
					$Partner_name = $get_partner_detail->Partner_name;
					
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create Merchandise Partners  Branches";
					$where="Create Branches for Merchandise Partners";
					$toname="";
					$To_enrollid =0;
					$firstName = $Partner_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Branch_name').' ( '.$this->input->post('Branch_code').' ) ';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Partner Branch  Error!!");
				}
				redirect("CatalogueC/Create_Merchandize_Partner_Branch");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	public function Edit_Merchandize_Partner_Branch()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;	
			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Register_Merchandize_Partners";
			$total_row = $this->Catelogue_model->Get_Company_Partners_Branch_Count($Company_id);
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
		
				
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			
			$data["Partner_Branch_Records"] = $this->Catelogue_model->Get_Company_Partners_Branches($config["per_page"], $page,$Company_id);
			
			$lv_Branch_id=$_REQUEST["Branch_id"];
			$data["Branch_Row"] = $this->Catelogue_model->Get_Company_Partners_Branch_details($lv_Branch_id);
			
			$data['States_array'] = $this->Igain_model->Get_states($data['Branch_Row']->Country_id);	
			$data['City_array'] = $this->Igain_model->Get_cities($data['Branch_Row']->State);
			
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Edit_Merchandize_Partner_BranchV', $data);
			}
			else
			{	
				/**********GET Longitude and Lattitude *********************
					$country_name = $this->Igain_model->Get_Country_master($this->input->post('country'));
					
					$Get_states = $this->Igain_model->Get_states($this->input->post('country'));
					foreach($Get_states as $rec)
					{
						if($rec->id==$this->input->post("state"))
						{
							$State_name=$rec->name;
						}
					}
					
					$Get_cities = $this->Igain_model->Get_cities($this->input->post('state'));
					foreach($Get_cities as $rec2)
					{
						if($rec2->id==$this->input->post("city"))
						{
							$City_name=$rec2->name;
						}
					}
					
					 $address =$this->input->post("currentAddress").' '.$City_name.' '.$this->input->post("district").' '.$State_name.' '.$this->input->post("zip").' '.$country_name->name; 
		 
					 
					$prepAddr = str_replace(' ','+',$address);
					 
					$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					 
					$output= json_decode($geocode);
					 
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng; 
					$Location=$latitude."*".$longitude;
			// echo "Location ".$Location;die;
						/*******************************************/
						
				$Post_data=array(
				'Company_id'=>$Company_id,
				'Partner_id'=>$this->input->post('Partner_id'),
				'Branch_name'=>$this->input->post('Branch_name'),
				'Address'=>$this->input->post('Branch_address'),
				'Country_id'=>$this->input->post('country'),
				'State'=>$this->input->post('state'),
				'City'=>$this->input->post('city'),
				'Zip'=>$this->input->post('zip'),
				//'Latitude'=>$latitude,
				///'Longitude'=>$longitude,
				'Update_User_id'=>$this->input->post('Update_User_id'),
				'Update_date'=>$this->input->post('Update_date'),
				'Active_flag'=>1);
				
				$result = $this->Catelogue_model->Update_Merchandize_Partner_Branch($lv_Branch_id,$Post_data);
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Partner Branch Updated Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($this->input->post('Partner_id'));
					$Partner_id = $get_partner_detail->Partner_id;
					$Partner_name = $get_partner_detail->Partner_name;
					
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Merchandise Partners  Branches";
					$where="Create Branches for Merchandise Partners";
					$toname="";
					$To_enrollid =0;
					$firstName = $Partner_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Branch_name').' ( '.$this->input->post('Branch_code').' ) ';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Partner Branch  Error!!");
				}
				redirect("CatalogueC/Create_Merchandize_Partner_Branch");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function Delete_Merchandize_Partners_Branch()
	{
		$Branch_id=$_REQUEST["Branch_id"];
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$Update_date=date("Y-m-d H:i:s");
		
		/******************Nilesh Change insert Log Table ******************************/
		$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_Branch_details($Branch_id);
		$Branch_id = $get_partner_detail->Branch_id;
		$Branch_code = $get_partner_detail->Branch_code;
		$Branch_name = $get_partner_detail->Branch_name;
		$Partner_id = $get_partner_detail->Partner_id;
		$Company_id = $get_partner_detail->Company_id;
		/******************Nilesh change insert Log Table ******************************/
		
		 $delte = $this->Catelogue_model->Delete_Merchandize_Partners_Branch($Branch_id,$Update_user_id,$Update_date);
		
		 if($delte == true)
		{
			$this->session->set_flashdata("success_code","Partner Branch Deleted Successfuly!!");
			
			/*****************Delete Merchandise_item_ linked this partner branch********************/
			$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Branch_linked_Merchandize_Items($Branch_code,$Company_id);
			if($All_Active_Merchandize_Items_Records!=NULL)
			{
				foreach($All_Active_Merchandize_Items_Records as $Val)
				{
					
					/*********************Check item has more than 1 branches************************/
					$Check_item_branches_count = $this->Catelogue_model->Check_linked_item_branches_count($Val->Company_merchandize_item_code,$Company_id);
					// echo "<br><br>".$Val->Company_merchandize_item_code."**Count***".$Check_item_branches_count[0];
					if($Check_item_branches_count[0]==1)
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
							'Thumbnail_image4'=>'Remarks:Merchandise Partner Branch deleted',
							'Active_flag'=>0
						);
						$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
						/**************delete temp cart linked item**********/
						$Delete_cart_item = $this->Catelogue_model->delete_linked_Branch_cart_item($Val->Company_merchandize_item_code,$Val->Company_id,$Branch_code);
						
						$delte2 = $this->Catelogue_model->Delete_Merchandize_Partners_Branch_linked_item($Val->Company_merchandize_item_code,$Company_id,$Branch_code);
						
					}
					else
					{
						/**************delete temp cart linked item**********/
						$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item_branch($Branch_code,$Company_id);
						/***********************/
						$delte2 = $this->Catelogue_model->Delete_Merchandize_Partners_Branch_linked_item($Val->Company_merchandize_item_code,$Company_id,$Branch_code);
					}
				}
					
			}
					
			/*****************Delete Merchandise_item_ linked this partner branch***XXX*****************/
			
			/*******************Insert igain Log Table*********************/
				$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($Partner_id);
				$Partner_id = $get_partner_detail->Partner_id;
				$Partner_name = $get_partner_detail->Partner_name;	
				$Company_id	= $session_data['Company_id'];
				$Todays_date = date('Y-m-d');	
				$opration = 3;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				$what="Delete Merchandise Partners  Branches";
				$where="Create Branches for Merchandise Partners";
				$toname="";
				$To_enrollid =0;
				$firstName = $Partner_name;
				$lastName = '';
				$Seller_name = $session_data['Full_name'];
				$opval = $Branch_name.' ( '.$Branch_code.' ) ';;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
			/*******************Insert igain Log Table*********************/
		}
		else
		{
			$this->session->set_flashdata("error_code","Error Deleting Partner Branch!!");
		}
		
		redirect("CatalogueC/Create_Merchandize_Partner_Branch");
	}
	
		function Check_Branch_Code()
	{
		$result = $this->Catelogue_model->Check_Branch_Code($this->input->post("Branch_code"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}
	/**************************************************Create Merchandise Partners Branch End*************************************/
	/**************************************************Create Merchandise Category Start*************************************/
	function Check_merchandize_category_name()
	{
		$result = $this->Catelogue_model->Check_merchandize_category($this->input->post("Merchandize_category_name"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		}
	}
	public function Create_Merchandize_Category()
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
			$data['Logged_user_id'] = $session_data['userId'];
			$Logged_user_id = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			/*******************Ravi 26-07-2018 Start************************************/ 
			$data["Parent_category"] = $this->Catelogue_model->get_company_parent_category($Company_id);
			/*******************Ravi 26-07-2018 End************************************/ 
			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Create_Merchandize_Category";
			$total_row = $this->Catelogue_model->Get_Merchandize_Category_Count($Company_id);
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
		
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category($config["per_page"], $page,$Company_id);
			
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
				
				$this->load->view('Catalogue/Merchandize_CategoryV', $data);
			}
			else
			{	
		
				$seller = $this->input->post('seller_id');
				
				$Post_data=array(
				'Company_id'=>$this->input->post('Company_id'),
				'Merchandize_category_name'=>$this->input->post('Merchandize_category_name'),
				'Parent_category_id'=>$this->input->post('Parent_category_id'),
				'Create_user_id'=>$this->input->post('Create_user_id'),
				'Create_date'=>$this->input->post('Create_date'),
				'Active_flag'=>1);
				
				if($seller > 0){
					
					$Post_data['Seller_id'] = $seller;
					$result = $this->Catelogue_model->Insert_Merchandize_Category($Post_data);
				}
				
				if($seller == 0){
				//	var_dump($AllBrands);exit;
					foreach($AllBrands as $seller_val)
					{
						$Post_data['Seller_id'] = $seller_val;
						$result = $this->Catelogue_model->Insert_Merchandize_Category($Post_data);
					}
				
				}
				
				
				
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","POS Menu Group Created Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create Merchandise Catalogue Category";
					$where="Create Merchandise Catalogue Category";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Merchandize_category_name');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","POS Menu Group Creation Error!!");
				}
				redirect("CatalogueC/Create_Merchandize_Category");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function Delete_Merchandize_Category()
	{
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$data['Super_seller']= $session_data['Super_seller'];
		$Super_seller= $session_data['Super_seller'];
		$Update_date=date("Y-m-d H:i:s");
		
		$Merchandize_category_id=$_REQUEST["Merchandize_category_id"];
		
		$Merchandize_Category_Row = $this->Catelogue_model->Get_Merchandize_Category_details($Merchandize_category_id);
		$category_name=$Merchandize_Category_Row->Merchandize_category_name;
		// echo"<br>-category_name--".$category_name;
		// die;
		$result = $this->Catelogue_model->Delete_Merchandize_Category($Merchandize_category_id,$Update_user_id,$Update_date);
		if($result == true) 
		{
			$this->session->set_flashdata("success_code","Merchandise Category Deleted Successfuly!!");
			/*****************Delete Merchandise_item_ linked this category********************/
			$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Category_linked_Merchandize_Items($Merchandize_category_id,$Super_seller,$Update_user_id);
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
							'Thumbnail_image4'=>'Remarks:Merchandise Category deleted',
							'Active_flag'=>0
						);
						$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
					/**************delete temp cart linked item**********/
						$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item($Val->Company_merchandize_item_code,$Val->Company_id);
					
				}
			}
					
			/*****************Delete Merchandise_item_ linked this partner***XXX*****************/
			/*******************Insert igain Log Table*********************/			
			
				$Company_id	= $session_data['Company_id'];
				$Todays_date = date('Y-m-d');	
				$opration = 3;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				$what="Delete Merchandise Catalogue Category";
				$where="Create Merchandise Catalogue Category";
				$toname="";
				$To_enrollid =0;
				$firstName = '';
				$lastName = '';
				$Seller_name = $session_data['Full_name'];
				$opval = $category_name;
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
			/*******************Insert igain Log Table*********************/
		}
		else
		{
			$this->session->set_flashdata("error_code","Error Deleting Merchandise Category!!");
		}
		redirect("CatalogueC/Create_Merchandize_Category");
	}
	
	public function Edit_Merchandize_Category()
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
			
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$data['Logged_user_id'] = $session_data['userId'];
			$Logged_user_id = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$FetchedCountrys = $this->Igain_model->FetchCountry();	
			$data['Country_array'] = $FetchedCountrys;	
			
			/*******************Ravi 26-07-2018 Start************************************/ 
			$data["Parent_category"] = $this->Catelogue_model->get_company_parent_category($Company_id);
			/*******************Ravi 26-07-2018 End************************************/ 
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Create_Merchandize_Category";
			$total_row = $this->Catelogue_model->Get_Merchandize_Category_Count($Company_id);
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

			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
		
			$lv_Merchandize_category_id=$_REQUEST["Merchandize_category_id"];
			$data["Merchandize_Category_Row"] = $this->Catelogue_model->Get_Merchandize_Category_details($lv_Merchandize_category_id);	
		
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category($config["per_page"], $page,$Company_id);
			
			if($_POST == NULL)
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
					$get_sellers = $get_sellers15;
				}
			
				$data['Seller_array'] = $get_sellers;
				//*********** SANDEEP 13-03-2020 **********
				
				
				$this->load->view('Catalogue/Edit_Merchandize_CategoryV', $data);
			}
			else
			{	
				$Post_data=array(
				'Company_id'=>$this->input->post('Company_id'),
				'Merchandize_category_name'=>$this->input->post('Merchandize_category_name'),
				'Parent_category_id'=>$this->input->post('Parent_category_id'),
				'Update_user_id'=>$this->input->post('Update_user_id'),
				'Update_date'=>$this->input->post('Update_date'));
				
				$result = $this->Catelogue_model->Update_Merchandize_Category($lv_Merchandize_category_id,$Post_data);
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Category  Updated Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Merchandise Catalogue Category";
					$where="Create Merchandise Catalogue Category";
					$toname="";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Merchandize_category_name');
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Category  Error!!");
				}
				redirect("CatalogueC/Create_Merchandize_Category");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	/**************************************************Create Merchandise Category End*************************************/
	/**************************************************Create Merchandise Items Start*************************************/
	public function Create_Merchandize_Items()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category('', '',$Company_id);
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			
			/*----------------------Active-Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Create_Merchandize_Items";
			$total_row = $this->Catelogue_model->Get_Merchandize_Items_Count($Company_id,1);
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
		
			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
			/*----------------------InActive-Pagination---------------------*/			
			$config2 = array();
			$config2["base_url"] = base_url() . "/index.php/CatalogueC/Create_Merchandize_Items";
			$total_row = $this->Catelogue_model->Get_Merchandize_Items_Count($Company_id,0);
			//echo "total_row ".$total_row;
			$config2["total_rows"] = $total_row;
			$config2["per_page"] = 10;
			$config2["uri_segment"] = 3;        
			$config2['next_link'] = 'Next';
			$config2['prev_link'] = 'Previous';
			$config2['full_tag_open'] = '<ul class="pagination">';
			$config2['full_tag_close'] = '</ul>';
			$config2['first_link'] = 'First';
			$config2['last_link'] = 'Last';
			$config2['first_tag_open'] = '<li>';
			$config2['first_tag_close'] = '</li>';
			$config2['prev_link'] = '&laquo';
			$config2['prev_tag_open'] = '<li class="prev">';
			$config2['prev_tag_close'] = '</li>';
			$config2['next_link'] = '&raquo';
			$config2['next_tag_open'] = '<li>';
			$config2['next_tag_close'] = '</li>';
			$config2['last_tag_open'] = '<li>';
			$config2['last_tag_close'] = '</li>';
			$config2['cur_tag_open'] = '<li class="active"><a href="#">';
			$config2['cur_tag_close'] = '</a></li>';
			$config2['num_tag_open'] = '<li>';
			$config2['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config2);
			$page2 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;		
		
			
			$data["pagination2"] = $this->pagination->create_links();
			/*-----------------------Pagination2---------------------*/
			
			/*-----------------------File Upload---------------------*/
			if(!is_dir('Merchandize_images'))
			{
				$result = mkdir('Merchandize_images',0777,true);
			}
				$config['upload_path'] = './Merchandize_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '700';
				$config['max_height'] = '700';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
			$data["Merchandize_Items_Records"] = $this->Catelogue_model->Get_Merchandize_Items($config["per_page"], $page,$Company_id,1);
			$data["InActive_Merchandize_Items_Records"] = $this->Catelogue_model->Get_Merchandize_Items($config2["per_page"], $page2,$Company_id,0);
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Create_Merchandize_ItemsV', $data);
				
			}
			else
			{	
				/* if(!$this->upload->do_upload("file"))
				{
					$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$Item_logo = base_url()."images/no_image.jpeg";					
				}
				else
				{						
					$data = array('upload_data' => $this->upload->data("file"));
					$Item_logo = base_url()."Merchandize_images/".$data['upload_data']['file_name'];
				} */
				
				/*-----------------------------------Image Upload Code-----------------------------*/
				
					$config = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					/*-----------------------Image1-----------------------------*/
						if ( !$this->upload->do_upload("file1") )
						{
							$Item_image1 = base_url()."images/no_image.jpeg";
							$Thumbnail_image1 = base_url()."images/no_image.jpeg";
							if(isset($_REQUEST["Company_merchandise_item_id"]))
							{
								$Item_image1 =$this->input->post("Item_image1");
								$Thumbnail_image1 =$this->input->post("Thumbnail_image1");
								
							}
						}
						else
						{
							$image_data1 = array('upload_data1' => $this->upload->data("file1"));
							
							/****************600 x 600*************/
								$config1 = array
								(
									'source_image'      => $image_data1['upload_data1']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data1['upload_data1']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config1);
								$this->image_lib->resize();
								
								$Item_image1 = base_url().$config1['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config2 = array
								(
									'source_image'      => $image_data1['upload_data1']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data1['upload_data1']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config2);
								$this->image_lib->resize();
								
								$Thumbnail_image1 = base_url().$config2['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image1-----------------------------*/
					
					/*-----------------------Image2-----------------------------*/
						if ( !$this->upload->do_upload("file2") )
						{
							$Item_image2 = base_url()."images/no_image.jpeg";
							$Thumbnail_image2 = base_url()."images/no_image.jpeg";
							if(isset($_REQUEST["Company_merchandise_item_id"]))
							{
								$Item_image2 =$this->input->post("Item_image2");
								$Thumbnail_image2 =$this->input->post("Thumbnail_image2");
								
							}
						}
						else
						{
							$image_data2 = array('upload_data2' => $this->upload->data("file2"));
							
							/****************600 x 600*************/
								$config3 = array
								(
									'source_image'      => $image_data2['upload_data2']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data2['upload_data2']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config3);
								$this->image_lib->resize();
								
								$Item_image2 = base_url().$config3['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config4 = array
								(
									'source_image'      => $image_data2['upload_data2']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data2['upload_data2']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config4);
								$this->image_lib->resize();
								
								$Thumbnail_image2 = base_url().$config4['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image2-----------------------------*/
					
					/*-----------------------Image3-----------------------------*/
						if ( !$this->upload->do_upload("file3") )
						{
							$Item_image3 = base_url()."images/no_image.jpeg";
							$Thumbnail_image3 = base_url()."images/no_image.jpeg";
							if(isset($_REQUEST["Company_merchandise_item_id"]))
							{
								$Item_image3 =$this->input->post("Item_image3");
								$Thumbnail_image3 =$this->input->post("Thumbnail_image3");
								
							}
						}
						else
						{
							$image_data3 = array('upload_data3' => $this->upload->data("file3"));
							
							/****************600 x 600*************/
								$config5 = array
								(
									'source_image'      => $image_data3['upload_data3']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data3['upload_data3']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config5);
								$this->image_lib->resize();
								
								$Item_image3 = base_url().$config5['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config6 = array
								(
									'source_image'      => $image_data3['upload_data3']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data3['upload_data3']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config6);
								$this->image_lib->resize();
								
								$Thumbnail_image3 = base_url().$config6['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image3-----------------------------*/
					
					/*-----------------------Image4-----------------------------*/
						if ( !$this->upload->do_upload("file4") )
						{
							$Item_image4 = base_url()."images/no_image.jpeg";
							$Thumbnail_image4 = base_url()."images/no_image.jpeg";
							if(isset($_REQUEST["Company_merchandise_item_id"]))
							{
								$Item_image4 =$this->input->post("Item_image4");
								$Thumbnail_image4 =$this->input->post("Thumbnail_image4");
							}
						}
						else
						{
							$image_data4 = array('upload_data4' => $this->upload->data("file3"));
							
							/****************600 x 600*************/
								$config7 = array
								(
									'source_image'      => $image_data4['upload_data4']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data4['upload_data4']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config7);
								$this->image_lib->resize();
								
								$Item_image4 = base_url().$config7['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config8 = array
								(
									'source_image'      => $image_data4['upload_data4']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data4['upload_data4']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config8);
								$this->image_lib->resize();
								
								$Thumbnail_image4 = base_url().$config8['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image3-----------------------------*/
				
				/*-----------------------------------Image Upload Code-----------------------------*/
				
					// $Cost_in_points = ($this->input->post('Cost_price') * $Company_Redemptionratio);
					// $Billing_price_in_points = ($this->input->post('Billing_price') / $Redemptionratio);
					$Valid_from=date("Y-m-d",strtotime($this->input->post('Valid_from')));
					$Valid_till=date("Y-m-d",strtotime($this->input->post('Valid_till')));
					$partner_branches=$this->input->post('partner_branches');
						
						/*****************************Insert Partner Branches*****************************/
						//print_r($partner_branches);
						foreach($partner_branches as $partner_branches2)
						{
							//echo "<br> partner_branches2 ".$partner_branches2;
							if($partner_branches2=='0')//All Branches
							{
								$Partner_Branch_Records = $this->Catelogue_model->Get_Partners_Branches($this->input->post('Partner_id'));
								
								foreach($Partner_Branch_Records as $Partner_Branch_Records)
								{
									//echo "<br> Branch_code111111 ".$Partner_Branch_Records->Branch_code;
									$Post_data2=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
									'Partner_id'=>$this->input->post('Partner_id'),
									'Branch_code'=>$Partner_Branch_Records->Branch_code,
									'Create_user_id'=>$this->input->post('Create_user_id'),
									'Create_date'=>$this->input->post('Create_date'));
									$result2 = $this->Catelogue_model->Insert_Merchandize_Item_branches($Post_data2);
								}
							}
							else
							{
								//echo "<br> Branch_code ".$partner_branches2;
								$Post_data12=array(
								'Company_id'=>$this->input->post('Company_id'),
								'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Partner_id'=>$this->input->post('Partner_id'),
								'Branch_code'=>$partner_branches2,
								'Create_user_id'=>$this->input->post('Create_user_id'),
								'Create_date'=>$this->input->post('Create_date'));
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_branches($Post_data12);
							}	
							
						}
				//	die;
					/***********************************************************************************************/
					$LV_Link_to_Member_Enrollment_flag=$this->input->post('Link_to_Member_Enrollment_flag');
					$Send_once_year=$this->input->post('Send_once_year');
					$Send_other_benefits=$this->input->post('Send_other_benefits');
					if($LV_Link_to_Member_Enrollment_flag=="" || $LV_Link_to_Member_Enrollment_flag==NULL)
					{
						$LV_Link_to_Member_Enrollment_flag=0;
						$Send_once_year=0;
						$Send_other_benefits=0;
					}
				$Post_data=array(
				'Company_id'=>$this->input->post('Company_id'),
				'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
				'Partner_id'=>$this->input->post('Partner_id'),
				'Cost_price'=>$this->input->post('Cost_price'),
				'Valid_from'=>$Valid_from,
				'Valid_till'=>$Valid_till,
				'Markup_percentage'=>$this->input->post('margin'),
				'Delivery_method'=>$this->input->post('Delivery_method'),
				'Merchandize_category_id'=>$this->input->post('Merchandize_category_id'),
				'Merchandize_item_name'=>$this->input->post('Merchandize_item_name'),
				'Merchandise_item_description'=>$this->input->post('Merchandise_item_description'),
				'Cost_payable_to_partner'=>$this->input->post('Cost_payable_to_partner'),
				'Billing_price'=>$this->input->post('Billing_price'),
				'VAT'=>$this->input->post('VAT'),
				// 'Item_image'=>$Item_logo,
				'Item_image1'=>$Item_image1,
				'Item_image2'=>$Item_image2,
				'Item_image3'=>$Item_image3,
				'Item_image4'=>$Item_image4,
				'Thumbnail_image1'=>$Thumbnail_image1,
				'Thumbnail_image2'=>$Thumbnail_image2,
				'Thumbnail_image3'=>$Thumbnail_image3,
				'Thumbnail_image4'=>$Thumbnail_image4,
				'Billing_price_in_points'=>$this->input->post('Points'),
				'show_item'=>$this->input->post('show_item'),
				'Ecommerce_flag'=>$this->input->post('Ecommerce_flag'),
				'Product_group_id'=>$this->input->post('Product_group_id'),
 				'Product_brand_id'=>$this->input->post('Product_brand_id'),
 				'Send_once_year'=>$Send_once_year,
 				'Send_other_benefits'=>$Send_other_benefits,
				'Create_user_id'=>$this->input->post('Create_user_id'),
				'Creation_date'=>$this->input->post('Create_date'),
				'Link_to_Member_Enrollment_flag'=>$LV_Link_to_Member_Enrollment_flag,
				'Active_flag'=>1);
				
				$result = $this->Catelogue_model->Insert_Merchandize_Item($Post_data);
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Item  Created Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($this->input->post('Partner_id'));
					$Partner_id = $get_partner_detail->Partner_id;
					$Partner_name = $get_partner_detail->Partner_name;
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create Merchandise Catalogue Items";
					$where="Create Merchandise Catalogue Items";
					$toname="";
					$To_enrollid =0;
					$firstName = $Partner_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Merchandize_item_name').' ( '.$this->input->post('Company_merchandize_item_code').' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Item  Error!!");
				}
				redirect("CatalogueC/Create_Merchandize_Items");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function Edit_Merchandize_Items()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["Seller_Redemptionratio"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Seller_Redemptionratio=$data["Seller_Redemptionratio"]->Seller_Redemptionratio;
			
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category('', '',$Company_id);
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Create_Merchandize_Items";
			$total_row = $this->Catelogue_model->Get_Merchandize_Items_Count($Company_id,1);
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
		
			
			$data["pagination"] = $this->pagination->create_links();
			/*-----------------------Pagination---------------------*/
			
			/*-----------------------File Upload---------------------*/
			if(!is_dir('Merchandize_images'))
			{
				$result = mkdir('Merchandize_images',0777,true);
			}
				$config['upload_path'] = './Merchandize_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '700';
				$config['max_height'] = '700';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
			$data["Merchandize_Items_Records"] = $this->Catelogue_model->Get_Merchandize_Items($config["per_page"], $page,$Company_id,1);
			
			$lv_Company_merchandise_item_id=$_REQUEST["Company_merchandise_item_id"];
			$data["Merchandize_Item_Row"] = $this->Catelogue_model->Get_Merchandize_Item_details($lv_Company_merchandise_item_id);	
			$Company_merchandize_item_code=$data["Merchandize_Item_Row"]->Company_merchandize_item_code;
			$lv_Product_group_id=$data["Merchandize_Item_Row"]->Product_group_id;
			
			$data["Merchandize_Item_Branches"] = $this->Catelogue_model->Get_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);	
		
			$data['Get_Product_Brands'] = $this->Catelogue_model->Get_Product_Brands($lv_Product_group_id,$Company_id);
			
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Edit_Merchandize_ItemsV', $data);
			}
			else
			{
				/* if(!$this->upload->do_upload("file"))
				{
					$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$Item_logo = $this->input->post('Item_image');					
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$Item_logo = base_url()."Merchandize_images/".$data['upload_data']['file_name'];
				} */
				
				/*-----------------------------------Image Upload Code-----------------------------*/
				
					$config = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					/*-----------------------Image1-----------------------------*/
						if ( !$this->upload->do_upload("file1") )
						{
							$Item_image1 = $this->input->post('Item_image1');
							$Thumbnail_image1 = $this->input->post('Thumbnail_image1');
						}
						else
						{
							$image_data1 = array('upload_data1' => $this->upload->data("file1"));
							
							/****************600 x 600*************/
								$config1 = array
								(
									'source_image'      => $image_data1['upload_data1']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data1['upload_data1']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config1);
								$this->image_lib->resize();
								
								$Item_image1 = base_url().$config1['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config2 = array
								(
									'source_image'      => $image_data1['upload_data1']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data1['upload_data1']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config2);
								$this->image_lib->resize();
								
								$Thumbnail_image1 = base_url().$config2['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image1-----------------------------*/
					
					/*-----------------------Image2-----------------------------*/
						if ( !$this->upload->do_upload("file2") )
						{			
							$Item_image2 = $this->input->post('Item_image2');
							$Thumbnail_image2 = $this->input->post('Thumbnail_image2');
						}
						else
						{
							$image_data2 = array('upload_data2' => $this->upload->data("file2"));
							
							/****************600 x 600*************/
								$config3 = array
								(
									'source_image'      => $image_data2['upload_data2']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data2['upload_data2']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config3);
								$this->image_lib->resize();
								
								$Item_image2 = base_url().$config3['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config4 = array
								(
									'source_image'      => $image_data2['upload_data2']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data2['upload_data2']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config4);
								$this->image_lib->resize();
								
								$Thumbnail_image2 = base_url().$config4['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image2-----------------------------*/
					
					/*-----------------------Image3-----------------------------*/
						if ( !$this->upload->do_upload("file3") )
						{			
							$Item_image3 = $this->input->post('Item_image3');
							$Thumbnail_image3 = $this->input->post('Thumbnail_image3');
						}
						else
						{
							$image_data3 = array('upload_data3' => $this->upload->data("file3"));
							
							/****************600 x 600*************/
								$config5 = array
								(
									'source_image'      => $image_data3['upload_data3']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data3['upload_data3']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config5);
								$this->image_lib->resize();
								
								$Item_image3 = base_url().$config5['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config6 = array
								(
									'source_image'      => $image_data3['upload_data3']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data3['upload_data3']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config6);
								$this->image_lib->resize();
								
								$Thumbnail_image3 = base_url().$config6['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image3-----------------------------*/
					
					/*-----------------------Image4-----------------------------*/
						if ( !$this->upload->do_upload("file4") )
						{			
							$Item_image4 = $this->input->post('Item_image4');
							$Thumbnail_image4 = $this->input->post('Thumbnail_image4');
						}
						else
						{
							$image_data4 = array('upload_data4' => $this->upload->data("file3"));
							
							/****************600 x 600*************/
								$config7 = array
								(
									'source_image'      => $image_data4['upload_data4']['full_path'], //path to the uploaded image
									'new_image'         => './Merchandize_images/original/'.$image_data4['upload_data4']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config7);
								$this->image_lib->resize();
								
								$Item_image4 = base_url().$config7['new_image'];
							/****************600 x 600*************/
							
							/****************225 x 225*************/
								$config8 = array
								(
									'source_image'      => $image_data4['upload_data4']['full_path'],
									'new_image'         => './Merchandize_images/thumbs/'.$image_data4['upload_data4']['file_name'],
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 225,
									'height'            => 225
								);
								
								$this->image_lib->initialize($config8);
								$this->image_lib->resize();
								
								$Thumbnail_image4 = base_url().$config8['new_image'];
							/****************225 x 225*************/
						}
					/*-----------------------Image3-----------------------------*/
				
				/*-----------------------------------Image Upload Code-----------------------------*/

				$Valid_from=date("Y-m-d",strtotime($this->input->post('Valid_from')));
				$Valid_till=date("Y-m-d",strtotime($this->input->post('Valid_till')));
				$Company_merchandise_item_id=$this->input->post('Company_merchandise_item_id');
				
				$Ecommerce_flag=$this->input->post('Ecommerce_flag');
				if($Ecommerce_flag==1)
				{
					$Product_group_id=$this->input->post('Product_group_id');
					$Product_brand_id=$this->input->post('Product_brand_id');
				}
				else
				{
					$Product_group_id=0;
					$Product_brand_id=0;
				}
				
				/*****************************Insert Partner Branches*****************************/
				if(isset($_REQUEST["Modify_cost_price"]))
				{
					$Dresult2 = $this->Catelogue_model->Delete_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);
				
				
						//print_r($partner_branches);
						$partner_branches=$this->input->post('partner_branches');
						foreach($partner_branches as $partner_branches2)
						{
							//echo "<br> partner_branches2 ".$partner_branches2;
							if($partner_branches2=='0')//All Branches
							{
								$Partner_Branch_Records = $this->Catelogue_model->Get_Partners_Branches($this->input->post('Partner_id'));
								
								foreach($Partner_Branch_Records as $Partner_Branch_Records)
								{
									//echo "<br> Branch_code111111 ".$Partner_Branch_Records->Branch_code;
									$Post_data2=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
									'Partner_id'=>$this->input->post('Partner_id'),
									'Branch_code'=>$Partner_Branch_Records->Branch_code,
									'Create_user_id'=>$this->input->post('Create_User_id'),
									'Create_date'=>$this->input->post('Creation_date'));
									$result2 = $this->Catelogue_model->Insert_Merchandize_Item_branches($Post_data2);
								}
							}
							else
							{
								//echo "<br> Branch_code ".$partner_branches2;
								$Post_data12=array(
								'Company_id'=>$this->input->post('Company_id'),
								'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Partner_id'=>$this->input->post('Partner_id'),
								'Branch_code'=>$partner_branches2,
								'Create_user_id'=>$this->input->post('Create_User_id'),
								'Create_date'=>$this->input->post('Creation_date'));
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_branches($Post_data12);
							}	
							
						}
					/*********************INSERT LOG TABLE**************************************/
					$Post_data=array(
					'Company_id'=>$data["Merchandize_Item_Row"]->Company_id,
					'Company_merchandise_item_id'=>$data["Merchandize_Item_Row"]->Company_merchandise_item_id,
					'Company_merchandize_item_code'=>$data["Merchandize_Item_Row"]->Company_merchandize_item_code,
					'Partner_id'=>$data["Merchandize_Item_Row"]->Partner_id,
					'Cost_price'=>$data["Merchandize_Item_Row"]->Cost_price,
					'Valid_from'=>$data["Merchandize_Item_Row"]->Valid_from,
					'Valid_till'=>$data["Merchandize_Item_Row"]->Valid_till,
					'Markup_percentage'=>$data["Merchandize_Item_Row"]->Markup_percentage,
					'Delivery_method'=>$data["Merchandize_Item_Row"]->Delivery_method,
					'Merchandize_category_id'=>$data["Merchandize_Item_Row"]->Merchandize_category_id,
					'Merchandize_item_name'=>$data["Merchandize_Item_Row"]->Merchandize_item_name,
					'Merchandise_item_description'=>$data["Merchandize_Item_Row"]->Merchandise_item_description,
					'Cost_payable_to_partner'=>$data["Merchandize_Item_Row"]->Cost_payable_to_partner,
					'Billing_price'=>$data["Merchandize_Item_Row"]->Billing_price,
					'VAT'=>$data["Merchandize_Item_Row"]->VAT,
					'Item_image1'=>$data["Merchandize_Item_Row"]->Item_image1,
					'Item_image2'=>$data["Merchandize_Item_Row"]->Item_image2,
					'Item_image3'=>$data["Merchandize_Item_Row"]->Item_image3,
					'Item_image4'=>$data["Merchandize_Item_Row"]->Item_image4,
					'Thumbnail_image1'=>$data["Merchandize_Item_Row"]->Thumbnail_image1,
					'Thumbnail_image2'=>$data["Merchandize_Item_Row"]->Thumbnail_image2,
					'Thumbnail_image3'=>$data["Merchandize_Item_Row"]->Thumbnail_image3,
					'Thumbnail_image4'=>$data["Merchandize_Item_Row"]->Thumbnail_image4,
					'Billing_price_in_points'=>$data["Merchandize_Item_Row"]->Billing_price_in_points,
					'show_item'=>$data["Merchandize_Item_Row"]->show_item,
					'Ecommerce_flag'=>$data["Merchandize_Item_Row"]->Ecommerce_flag,
					'Product_group_id'=>$data["Merchandize_Item_Row"]->Product_group_id,
					'Product_brand_id'=>$data["Merchandize_Item_Row"]->Product_brand_id,
					'Send_once_year'=>$data["Merchandize_Item_Row"]->Send_once_year,
					'Send_other_benefits'=>$data["Merchandize_Item_Row"]->Send_other_benefits,
					'Create_User_id'=>$data['enroll'],
					'Creation_date'=>date("Y-m-d H:i:s"),
					'Update_User_id'=>$data['enroll'],
					'Update_date'=>date("Y-m-d H:i:s"),
					'Active_flag'=>1);
					
					$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data);
				}	
				//	die;
					/***********************************************************************************************/
				$LV_Link_to_Member_Enrollment_flag=$this->input->post('Link_to_Member_Enrollment_flag');
				$Send_once_year=$this->input->post('Send_once_year');
				$Send_other_benefits=$this->input->post('Send_other_benefits');
					if($LV_Link_to_Member_Enrollment_flag=="" || $LV_Link_to_Member_Enrollment_flag==NULL)
					{
						$LV_Link_to_Member_Enrollment_flag=0;
						$Send_once_year=0;
						$Send_other_benefits=0;
					}	
				
				$data["Merchandize_Item_Row"] = $this->Catelogue_model->Get_Merchandize_Item_details($Company_merchandise_item_id);	
				$Post_data = array
				(
					'Company_merchandise_item_id'=>$this->input->post('Company_merchandise_item_id'),
					'Company_id'=>$this->input->post('Company_id'),
					'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
					'Valid_from'=>$Valid_from,
					'Valid_till'=>$Valid_till,
					'Delivery_method'=>$this->input->post('Ecommerce_flag'),
					'Merchandize_category_id'=>$this->input->post('Merchandize_category_id'),
					'Merchandize_item_name'=>$this->input->post('Merchandize_item_name'),
					'Partner_id'=>$this->input->post('Partner_id'),
					'Cost_price'=>$this->input->post('Cost_price'),
					'Markup_percentage'=>$this->input->post('margin'),
					'Cost_payable_to_partner'=>$this->input->post('Cost_payable_to_partner'),
					'Billing_price'=>$this->input->post('Billing_price'),
					'VAT'=>$this->input->post('VAT'),
					'Billing_price_in_points'=>$this->input->post('Points'),
					'Merchandise_item_description'=>$this->input->post('Merchandise_item_description'),
					// 'Item_image'=>$Item_logo,
					'show_item'=>$this->input->post('show_item'),
					'Ecommerce_flag'=>$Ecommerce_flag,
					'Product_group_id'=>$Product_group_id,
					'Product_brand_id'=>$Product_brand_id,
					'Item_image1'=>$Item_image1,
					'Item_image2'=>$Item_image2,
					'Item_image3'=>$Item_image3,
					'Item_image4'=>$Item_image4,
					'Thumbnail_image1'=>$Thumbnail_image1,
					'Thumbnail_image2'=>$Thumbnail_image2,
					'Thumbnail_image3'=>$Thumbnail_image3,
					'Thumbnail_image4'=>$Thumbnail_image4,	
					'Send_once_year'=>$Send_once_year,
					'Send_other_benefits'=>$Send_other_benefits,	
					'Create_User_id'=>$this->input->post('Create_User_id'),
					'Creation_date'=>$this->input->post('Creation_date'),
					'Update_user_id'=>$this->input->post('Update_user_id'),
					'Link_to_Member_Enrollment_flag'=>$LV_Link_to_Member_Enrollment_flag,
					'Update_date'=>$this->input->post('Update_date')
				);
				
				$result = $this->Catelogue_model->Update_Merchandize_Item($Company_merchandise_item_id,$Post_data);
				
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Item  Updated Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($this->input->post('Partner_id'));
					$Partner_id = $get_partner_detail->Partner_id;
					$Partner_name = $get_partner_detail->Partner_name;
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Update Merchandise Catalogue Items";
					$where="Create Merchandise Catalogue Items";
					$toname="";
					$To_enrollid =0;
					$firstName = $Partner_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post('Merchandize_item_name').' ( '.$this->input->post('Company_merchandize_item_code').' )';
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
				/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Item Updated Error!!");
				}
				redirect("CatalogueC/Create_Merchandize_Items");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function Modify_cost_Price()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["Seller_Redemptionratio"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Seller_Redemptionratio=$data["Seller_Redemptionratio"]->Seller_Redemptionratio;
			
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category('', '',$Company_id);
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			$lv_Company_merchandise_item_id=$_REQUEST["Company_merchandise_item_id"];
			
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			$data["Merchandize_Item_Row"] = $this->Catelogue_model->Get_Merchandize_Item_details($lv_Company_merchandise_item_id);	
			$Company_merchandize_item_code=$data["Merchandize_Item_Row"]->Company_merchandize_item_code;
			
			$data["Merchandize_Item_Branches"] = $this->Catelogue_model->Get_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);	
			
			$lv_Product_group_id=$data["Merchandize_Item_Row"]->Product_group_id;
			$data['Get_Product_Brands'] = $this->Catelogue_model->Get_Product_Brands($lv_Product_group_id,$Company_id);
			
				if($_POST == NULL)
			{
				$this->load->view('Catalogue/Modify_cost_Price', $data);
			}
			
			/********************************Delete Existing Item & its branches*************************************************
			$Update_user_id = $session_data['enroll'];
			$Update_date=date("Y-m-d H:i:s");
		
			$Dresult = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($lv_Company_merchandise_item_id);
			$Dresult2 = $this->Catelogue_model->Delete_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);
			
			/*************************************************************************************************************/
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	
	public function Get_Partner_Branches()
	{
		$data['Get_Partner_Branches'] = $this->Catelogue_model->Get_Partner_Branches($this->input->post("Partner_id"),$this->input->post("Company_id"));
		$lv_Partner_id=$_REQUEST["Partner_id"];
		$data["Partner_Row"] = $this->Catelogue_model->Get_Company_Partners_details($lv_Partner_id);
		$VAT=$data["Partner_Row"]->Partner_vat;
		$margin=$data["Partner_Row"]->Partner_markup_percentage;
		$Partner_redemption_ratio=$data["Partner_Row"]->Partner_redemption_ratio;
		 //var_dump($data);die;
		$theHTMLResponse = $this->load->view('Catalogue/Get_Partner_branches', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_Partner_Branches2'=> $theHTMLResponse,'VAT'=> $VAT,'margin'=> $margin,'Partner_redemption_ratio'=> $Partner_redemption_ratio)));
	}
	
	public function Get_Product_Brands()
	{
		$data['Get_Product_Brands'] = $this->Catelogue_model->Get_Product_Brands($this->input->post("Product_group_id"),$this->input->post("Company_id"));
		
		$theHTMLResponse = $this->load->view('Catalogue/Get_Product_Brands', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Product_groups'=> $theHTMLResponse)));
	}
	
	function Check_Merchandize_Item_Code()
	{
		$result = $this->Catelogue_model->Check_Merchandize_Item_Code($this->input->post("Company_merchandize_item_code"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}
	
  	function InActive_Merchandize_Item()
	{
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$Update_date=date("Y-m-d H:i:s");
		
		$Company_merchandise_item_id=$_REQUEST["Company_merchandise_item_id"];
		
	/**************igain log tacle change****************/
		$get_partner_detail = $this->Igain_model->Get_Company_Partners_details($Company_merchandise_item_id);
		$Partner_id = $get_partner_detail->Partner_id;
	/**************igain log tacle change****************/
	
		$Merchandize_Item_Row = $this->Catelogue_model->Get_Merchandize_Item_details($Company_merchandise_item_id);
		$merchandize_item_code=$Merchandize_Item_Row->Company_merchandize_item_code;
		$Merchandize_item_name=$Merchandize_Item_Row->Merchandize_item_name;
		$result = $this->Catelogue_model->InActive_Merchandize_Item($Company_merchandise_item_id,$Update_user_id,$Update_date);
		if($result == true)
		{
			$this->session->set_flashdata("success_code","Merchandise Item Deleted Successfuly!!");
			
			/*******************Insert igain Log Table*********************/
				$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($Partner_id);
				$Partner_id = $get_partner_detail->Partner_id;
				$Partner_name = $get_partner_detail->Partner_name;
				$Company_id	= $session_data['Company_id'];
				$Todays_date = date('Y-m-d');	
				$opration = 3;		
				$enroll	= $session_data['enroll'];
				$username = $session_data['username'];
				$userid=$session_data['userId'];
				$what="Inactive Merchandise Catalogue Items";
				$where="Create Merchandise Catalogue Items";
				$toname="";
				$To_enrollid =0;
				$firstName = $Partner_name;
				$lastName = '';
				$Seller_name = $session_data['Full_name'];
				$opval = $merchandize_item_code.' ('.$Merchandize_item_name.' )';
				$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Partner_id);
			/*******************Insert igain Log Table*********************/
		}
		else
		{
			$this->session->set_flashdata("error_code","Error Deleting Merchandise Item!!");
		}
		redirect("CatalogueC/Create_Merchandize_Items");
	}
	/**************************************************Create Merchandise Items End*************************************/
	/**************************************************Validate e-voucher start*************************************/
	
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

			$Company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $Company_details->Pin_no_applicable;
			$data['Allow_merchant_pin'] = $Company_details->Allow_merchant_pin;
			$Company_website=$Company_details->Website;
			
			
			if($_POST == NULL)
			{
				
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Validate_EVoucher";
			$data['total_row'] = $this->Catelogue_model->redemtion_fulfillment('','',$Logged_user_id,$Super_seller,$data['enroll'],$data['Company_id']);
			
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
				
				$data["results"] = $this->Catelogue_model->redemtion_fulfillment($config["per_page"],$page,$Logged_user_id,$Super_seller,$data['enroll'],$data['Company_id']);
				$this->load->view('Catalogue/Validate_EVoucher_view', $data);
			}
			else
			{	
				
				
				// $Membership_ID=$this->input->post('Membership_ID');
				// $Voucher_Number=$this->input->post('Voucher_Number');
				// $data["Member_details"] = $this->Igain_model->get_customer_details_Card_id($Membership_ID,$Company_id);
				// $data["Item_details"] = $this->Catelogue_model->validate_evoucher($Membership_ID,$Company_id,$Voucher_Number);
				/*if($data["Item_details"]!=true)
				{
					$this->session->set_flashdata("Items_flash","Invalid MembershipID OR e-Voucher No.!!");
					redirect("CatalogueC/Validate_EVoucher");
				}*/
				// $this->load->view('Catalogue/Validate_EVoucher_process_view', $data);
				
				$Item_id=$this->input->post('Item_id');
				
			if($Item_id !=NULL)
			{
				foreach($Item_id as $Item_id)
				{
					$evoucher=$this->input->post('Voucher_no'.$Item_id);   
					$MembershipID=$this->input->post('MembershipID'.$Item_id);
					$CompanyId=$Company_id;
					$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id'.$Item_id);
					$Branch_name=$this->input->post('Branch_name'.$Item_id);
					$Branch_Address=$this->input->post('Branch_Address'.$Item_id);
					$Total_points=$this->input->post('Total_points'.$Item_id);
					$Points=$this->input->post('Points'.$Item_id);
					$Quantity=$this->input->post('Quantity'.$Item_id);
					$Trans_date=$this->input->post('Trans_date'.$Item_id);
					$Merchandize_item_name=$this->input->post('Merchandize_item_name'.$Item_id);
					$Full_name=$this->input->post('Full_name'.$Item_id);
					
					//$customer_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
					
					$result = $this->Catelogue_model->Update_eVoucher_Status($MembershipID,$CompanyId,$evoucher,$data['enroll'],31);
					
					
					
					$Email_content = array(
						// 'Contents' => $html,
						// 'subject' => $subject,
						'Trans_date' => $Trans_date,
						'Merchandize_item_name' => $Merchandize_item_name,
						'evoucher' => $evoucher,
						'Redeem_points' => round($Points),
						'Total_points' => round($Total_points),
						'Branch_name' => $Branch_name,
						'Branch_Address' => $Branch_Address,
						'Notification_type' => 'Redemption Fulfillment',
						'Template_type' => 'Redemption_Fulfillment'
					);
			
					$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$CompanyId);
					
					$MembershipID=$this->input->post('MembershipID'.$Item_id);   
				/*******************Insert igain Log Table*********************/
					
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Validate e-Voucher";
					$where="Validate e-Voucher (at Partner Branch)";
					$toname="";
					$To_enrollid =0;
					$firstName = $Full_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $evoucher;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
				/*******************Insert igain Log Table*********************/
				}
				$this->session->set_flashdata("success_code","Merchandise Item Issued to Member Successfully!!");
				
				redirect("CatalogueC/Validate_EVoucher");
			}
			else
			{
				$this->session->set_flashdata("error_code","Please Select atleast one evoucher !!!");
				redirect("CatalogueC/Validate_EVoucher");
			}
				
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	public function Validate_RVoucher() 
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

			$Company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $Company_details->Pin_no_applicable;
			$data['Allow_merchant_pin'] = $Company_details->Allow_merchant_pin;
			$Company_website=$Company_details->Website;
			
			$Partner_User_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$data['Partner_id'] = $Partner_User_details->Merchandize_Partner_ID;
			
			if($data['Partner_id'] !=0)
			{
				$Partner_details = $this->Catelogue_model->get_partner_details($data['Partner_id'],$Company_id);
				$Partner_name = $Partner_details->Partner_name;
				$Partner_address = $Partner_details->Partner_address;
			}
			else
			{
				$Partner_name = " ";
				$Partner_address = " ";
			}
			
			if($_POST == NULL)
			{	
				$this->load->view('Catalogue/Validate_RVoucher_view', $data);
			}
			else
			{	
			
				$Item_id=$this->input->post('Item_id');
					
				if($Item_id !=NULL)
				{
					foreach($Item_id as $Item_id)
					{
						$Voucher_no=$this->input->post('Voucher_no'.$Item_id);   
						$MembershipID=$this->input->post('MembershipID'.$Item_id);
						$CompanyId=$Company_id;
						$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id'.$Item_id);
						$Voucher_name=$this->input->post('Voucher_name'.$Item_id);
						
						$Total_points=$this->input->post('Total_points'.$Item_id);
						$Points=$this->input->post('Points'.$Item_id);
						
						$customer_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
						$Company_id = $customer_details->Company_id;
						$Enrollement_id = $customer_details->Enrollement_id;
						$First_name = $customer_details->First_name;
						$Last_name = $customer_details->Last_name;
						$Current_balance = $customer_details->Current_balance;
						$Total_topup_amt = $customer_details->Total_topup_amt;
						
						$result = $this->Catelogue_model->Update_RVoucher_Status($MembershipID,$Company_id,$Voucher_no,$data['enroll']);
						
						$lv_date_time=date("Y-m-d H:i:s");
						
						$Update_topup_amt = $Total_topup_amt+$Points;
						
						$Update_Current_balance = $Current_balance+$Points;
						
						$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
						$Seller_name = $Super_Seller->First_name .' '. $Super_Seller->Last_name;
						$seller_id = $Super_Seller->Enrollement_id;
						$Topup_Bill_no = $Super_Seller->Topup_Bill_no;
						
						$top_db = $Topup_Bill_no;
						$len = strlen($top_db);
						$str = substr($top_db, 0, 5);
						$tp_bill = substr($top_db, 5, $len);

						$topup_BillNo = $tp_bill + 1;
						$billno_withyear_ref = $str . $topup_BillNo;
						
						$post_data = array(
							'Trans_type' => '1',
							'Company_id' => $Company_id,
							'Topup_amount' => $Points,      
							'Trans_date' => $lv_date_time,
							'Card_id' => $MembershipID,
							'Seller_name' => $Seller_name,
							'Seller' => $seller_id,
							'Enrollement_id' => $Enrollement_id,
							'Bill_no' => $tp_bill,
							'Remarks' => " Revenue Voucher Credit Points", 
							'Create_user_id' => $data['enroll'],
							'Available_balance' => $Update_Current_balance
						);

						$insert_transaction_id = $this->Coal_Transactions_model->insert_loyalty_transaction($post_data);
						
						$result77 = $this->Transactions_model->update_topup_billno($seller_id, $billno_withyear_ref);
						
						$Update_data = array('Current_balance' => $Update_Current_balance,'Total_topup_amt' => $Update_topup_amt);
								
						$this->Catelogue_model->Update_balance($Update_data,$Enrollement_id,$Company_id);
						
						$Email_content = array(
							'Trans_date' => $Trans_date,
							'Merchandize_item_name' => $Voucher_name,
							'evoucher' => $Voucher_no,
							'Gained_points' => round($Points),
							'Total_points' => round($Total_points),
							'Branch_name' => $Partner_name,
							'Branch_Address' => $Partner_address,
							'Notification_type' => 'Revenue Voucher Fulfillment',
							'Template_type' => 'Revenue_Voucher_Fulfillment'
						);
				
						$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id);
						  
					/*******************Insert igain Log Table*********************/
						
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Validate Voucher";
						$where="Validate Voucher (at Partner Branch)";
						$toname="";
						$To_enrollid =0;
						$firstName = $Full_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $evoucher;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
					/*******************Insert igain Log Table*********************/
					}
					$this->session->set_flashdata("success_code","Points Issued to Member Successfully!!");
					
					redirect("CatalogueC/Validate_RVoucher");
				}
				else
				{
					$this->session->set_flashdata("error_code","Please Select atleast one voucher !!!");
					redirect("CatalogueC/Validate_RVoucher");
				}
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function Evoucher_validation()
	{
		$evoucher = $this->input->post("evoucher");
		$MembershipID = $this->input->post("MembershipID");
		$CompanyId = $this->input->post("Company_id");
		/* echo "<br>MembershipID ".$MembershipID;
		echo "<br>CompanyId ".$CompanyId; */
		$result = $this->Catelogue_model->validate_evoucher($MembershipID,$CompanyId,$evoucher);
		//echo "Enrollement_id ".count($result->Enrollement_id);//die;
		//print_r($result);
		//echo " result ".$result;
		
		if($result != NULL)
		{
			$this->output->set_output("Available");
		}
		else    
		{
			$this->output->set_output("Not Available");
		}
	}
	function Update_eVoucher_Status()
	{
		/*$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['enroll'] = $session_data['enroll'];
			
		$evoucher = $_REQUEST["Voucher_no"];
		$MembershipID = $_REQUEST["MembershipID"];
		$CompanyId = $_REQUEST["Company_id"];
		$Cust_Enrollement_id = $_REQUEST["Cust_Enrollement_id"];
		$Branch_name = $_REQUEST["Branch_name"];
		$Branch_Address = $_REQUEST["Branch_Address"];
		$Total_points = $_REQUEST["Total_points"];
		$Points = $_REQUEST["Points"];
		$Quantity = $_REQUEST["Quantity"];
		$Trans_date = $_REQUEST["Trans_date"];
		$Merchandize_item_name = $_REQUEST["Merchandize_item_name"];
		$Full_name = $_REQUEST["Full_name"];
		
		/*
		$evoucher = $this->input->post("Voucher_no");
		$MembershipID = $this->input->post("MembershipID");
		$CompanyId = $this->input->post("Company_id");
		$Cust_Enrollement_id = $this->input->post("Cust_Enrollement_id");
		$Branch_name = $this->input->post("Branch_name");
		$Branch_Address = $this->input->post("Address");
		$Total_points = $this->input->post("Total_points");
		$Points = $this->input->post("Points");
		$Quantity = $this->input->post("Quantity");
		
		$Trans_date = date("d M Y",strtotime($this->input->post("Trans_date")));
		$Merchandize_item_name = $this->input->post("Merchandize_item_name");
		$Full_name = $this->input->post("First_name")." ".$this->input->post("Last_name");
		
		
		
			
		
			
			$Email_content = array(
				'Contents' => $html,
				'subject' => $subject,
				'Notification_type' => 'Redemption Fulfillment',
				'Template_type' => 'Redemption Fulfillment'
			);
			
			$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$CompanyId);
			//die;
			if($result==true)
			{
				$this->session->set_flashdata("Items_flash","Merchandise Item Issued to Member Successfully!!");
				redirect("CatalogueC/Validate_EVoucher");
			}*/
		
		
		
	}
	
	
	function Get_unused_evouchers_details()
	{
		$MembershipID = $this->input->post("MembershipID");
		$CompanyId = $this->input->post("Company_id");
		$Pin_no_applicable = $this->input->post("Pin_no_applicable");
		$Allow_merchant_pin = $this->input->post("Allow_merchant_pin");
		
		$data["Company_details"] = $this->Igain_model->get_company_details($CompanyId);

		/* echo "<br>MembershipID ".$MembershipID;
		echo "<br>CompanyId ".$CompanyId; */
		$result = $this->Catelogue_model->Get_unused_evouchers_details($MembershipID,$CompanyId);
		//echo "Enrollement_id ".count($result->Enrollement_id);//die;
		// print_r($result);
		//echo " result ".$result;
		$data["Allow_merchant_pin"]=$Allow_merchant_pin;
		$data["Pin_no_applicable"]=$Pin_no_applicable;
		$data["MembershipID"]=$MembershipID;
		$data["results"]=$result;
		$this->load->view('Catalogue/Show_unused_vouchers', $data);
		/*if($result != NULL)
		{
			$this->output->set_output("Available");
		}
		else    
		{
			$this->output->set_output("Not Available");
		}*/
	}
	function Get_unused_Rvouchers_details()
	{
		$MembershipID = $this->input->post("MembershipID");
		$Partner_id = $this->input->post("Partner_id");
		$CompanyId = $this->input->post("Company_id");
		$Pin_no_applicable = $this->input->post("Pin_no_applicable");
		$Allow_merchant_pin = $this->input->post("Allow_merchant_pin");
		
		$data["Company_details"] = $this->Igain_model->get_company_details($CompanyId);

		$result = $this->Catelogue_model->Get_unused_Rvouchers_details($MembershipID,$CompanyId,$Partner_id);
		
		// print_r($result);
		//echo " result ".$result;
		$data["Allow_merchant_pin"]=$Allow_merchant_pin;
		$data["Pin_no_applicable"]=$Pin_no_applicable;
		$data["MembershipID"]=$MembershipID;
		$data["results"]=$result;
		$this->load->view('Catalogue/Show_unused_rvouchers', $data);
	}
	/**************************************************Validate e-voucher End*************************************/
	/*******************Update_order_status AMIT 22-02-2017*************************************/
	public function Update_order_status()
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
			$Company_Redemptionratio=$Company_details->Redemptionratio;
			
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Update_order_status_view', $data);
			}
			else
			{	
				
				$Item_id=$this->input->post('Item_id');
				$MembershipID=$this->input->post('MembershipID');
				$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id');
				$Full_name=$this->input->post('Full_name');
				$Current_balance=$this->input->post('Current_balance');
				
				if($Item_id !=NULL)
				{
					foreach($Item_id as $Item_id)
					{
						$Order_no=$this->input->post('Order_no'.$Item_id);
						
						$Branch_name=$this->input->post('Branch_name'.$Item_id);
						$Branch_Address=$this->input->post('Branch_Address'.$Item_id);
						$Total_points=$this->input->post('Total_points'.$Item_id);
						$Purchase_amount=$this->input->post('Purchase_amount'.$Item_id);
						$Quantity=$this->input->post('Quantity'.$Item_id);
						$Voucher_status=$this->input->post('Voucher_status'.$Item_id);
						$Trans_date=$this->input->post('Trans_date'.$Item_id);
						$Item_name=$this->input->post('Item_name'.$Item_id);
						$Company_merchandize_item_code=$this->input->post('Company_merchandize_item_code'.$Item_id);
						
						$Redeem_points=$this->input->post('Redeem_points'.$Item_id);
						$Loyalty_pts=$this->input->post('Loyalty_pts'.$Item_id);
						$balance_to_pay=$this->input->post('balance_to_pay'.$Item_id);
						
						
						if($Voucher_status =='21')
						{
							$Update_status = $this->Catelogue_model->Update_online_purchase_item($Item_id,$Voucher_status,$data['enroll']);
							
							$balance_to_pay_in_points=round($balance_to_pay*$Company_Redemptionratio);
							
							$Calc_Credit_points=($Redeem_points+$balance_to_pay_in_points)-$Loyalty_pts;
							$Current_balance=($Current_balance+$Calc_Credit_points);
							
							$Update_balance = $this->Catelogue_model->Update_online_purchase_cancel_item_points($Cust_Enrollement_id,$Current_balance,$data['enroll']);
							
							/**************Insert transaction**********************/
							$Insert_data = array(
								'Trans_type' => 17,//Purchase Return
								'Trans_date' => $Trans_date,
								'Item_code' => $Company_merchandize_item_code,
								'Voucher_no' => $Order_no,
								'Topup_amount' => $Calc_Credit_points,
								'Quantity' => $Quantity,
								'Voucher_status' => $Voucher_status,
								'Enrollement_id' => $Cust_Enrollement_id,
								'Card_id' => $MembershipID,
								'Company_id' => $Company_id,
								'Remarks' => 'Purchase Return',
								'Seller_name' => $data['LogginUserName'],
								'Seller' => $data['enroll']
								);
						
							$InsertCredit=$this->Catelogue_model->Insert_purchase_return_trans($Insert_data);
							
								
							/*********************Send Notification***************/
							$Email_content3 = array(
								'Trans_date' => $Trans_date,
								'Item_name' => $Item_name,
								'Order_no' => $Order_no,
								'Purchase_amount' => $Purchase_amount,
								'Quantity' => $Quantity,
								'Branch_name' => $Branch_name,
								'Branch_Address' => $Branch_Address,
								'Voucher_status' => $Voucher_status,
								'Credit_points' => $Calc_Credit_points,
								'Balance_points' => $Current_balance,
								'Notification_type' => 'Purchase Return',
								'Template_type' => 'Purchase_Return'
							);
						
							$Credit_Notification1=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content3,'1',$Company_id);
							
						/*******************Insert igain Log Table*********************/
							$get_cust_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							$fname=$get_cust_details->First_name;
							$lname=$get_cust_details->Last_name;
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Cancel order";
							$where="Update Order Status";
							$toname="";
							$To_enrollid =0;
							$firstName = $fname;
							$lastName = $lname;
							$Seller_name = $session_data['Full_name'];
							$opval = $Order_no;
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
						/*******************Insert igain Log Table*********************/
						}
						if($Voucher_status =='20')
						{
							$Update_status = $this->Catelogue_model->Update_online_purchase_item($Item_id,$Voucher_status,$data['enroll']);
							
							$Email_content = array(
								'Trans_date' => $Trans_date,
								'Item_name' => $Item_name,
								'Order_no' => $Order_no,
								'Purchase_amount' => $Purchase_amount,
								'Quantity' => $Quantity,
								'Branch_name' => $Branch_name,
								'Branch_Address' => $Branch_Address,
								'Voucher_status' => $Voucher_status,
								'Notification_type' => 'Online Purchase Order Fulfillment',
								'Template_type' => 'Online_Purchase'
							);
						
							$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$Company_id);
							
						/*******************Insert igain Log Table*********************/
							$get_cust_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							$fname=$get_cust_details->First_name;
							$lname=$get_cust_details->Last_name;
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Delivered Order";
							$where="Update Order Status";
							$toname="";
							$To_enrollid =0;
							$firstName = $fname;
							$lastName = $lname;
							$Seller_name = $session_data['Full_name'];
							$opval = $Order_no;
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
						/*******************Insert igain Log Table*********************/

						}
					
					}
					//die;
					$this->session->set_flashdata("success_code","Online Purchase Order Updated Successfully!!");
					redirect("CatalogueC/Update_order_status");
				}
				else
				{
					$this->session->set_flashdata("error_code","Please Select atleast one Order Item !!!");
					redirect("CatalogueC/Update_order_status");
				}
				
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function Get_Online_Purchase_orders_details()
	{
		$MembershipID = $this->input->post("MembershipID");
		$CompanyId = $this->input->post("Company_id");
		$Pin_no_applicable = $this->input->post("Pin_no_applicable");
		$Allow_merchant_pin = $this->input->post("Allow_merchant_pin");
		/* echo "<br>MembershipID ".$MembershipID;
		echo "<br>CompanyId ".$CompanyId; */
		$result = $this->Catelogue_model->Get_Online_Purchase_orders_details($MembershipID,$CompanyId);
		$data["Allow_merchant_pin"]=$Allow_merchant_pin;
		$data["Pin_no_applicable"]=$Pin_no_applicable;
		$data["MembershipID"]=$MembershipID;
		$data["results"]=$result;
		$this->load->view('Catalogue/Show_Online_Purchase_orders_details', $data);
		
	}
	/*******************Update_order_status End*************************************/
	/****************************************AMIT 18-12-2017***************/
	public function Validate_Bulk_EVoucher() 
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
			
			$Get_login_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Merchandize_Partner_ID=$Get_login_details->Merchandize_Partner_ID;
			
			
			if($_POST == NULL)
			{
				
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/CatalogueC/Validate_Bulk_EVoucher";
			$data['total_row'] = $this->Catelogue_model->Get_Updated_Bulk_evouchers_details($Company_id,$Merchandize_Partner_ID,'','');
			
			// echo "total_row ".count($data['total_row']);
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
				
				$data['results'] = $this->Catelogue_model->Get_Bulk_evouchers_details($Company_id,$Merchandize_Partner_ID);
				$data['results2'] = $this->Catelogue_model->Get_Updated_Bulk_evouchers_details($Company_id,$Merchandize_Partner_ID,$config["per_page"],$page);
				$this->load->view('Catalogue/Validate_Bulk_EVoucher_process_view', $data);
			}
			else
			{	
				$Item_id=$this->input->post('Item_id');
				
			if($Item_id !=NULL)
			{
				foreach($Item_id as $Item_id)
				{
					$evoucher=$this->input->post('Voucher_no'.$Item_id);   
					$MembershipID=$this->input->post('MembershipID'.$Item_id);
					$CompanyId=$Company_id;
					$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id'.$Item_id);
					$Branch_name=$this->input->post('Branch_name'.$Item_id);
					$Branch_Address=$this->input->post('Branch_Address'.$Item_id);
					$Total_points=$this->input->post('Total_points'.$Item_id);
					$Points=$this->input->post('Points'.$Item_id);
					$Quantity=$this->input->post('Quantity'.$Item_id);
					$Trans_date=$this->input->post('Trans_date'.$Item_id);
					$Merchandize_item_name=$this->input->post('Merchandize_item_name'.$Item_id);
					$Full_name=$this->input->post('Full_name'.$Item_id);
					$Update_QTY=$this->input->post('Update_evoucher_'.$Item_id);
					$old_Quantity_balance=$this->input->post('Quantity_balance'.$Item_id);
					
					$Quantity_balance=($old_Quantity_balance-$Update_QTY);
					// $Used_Quantity=($Quantity-$Quantity_balance);
					$Used_Quantity=$Update_QTY;
					
					$result = $this->Catelogue_model->Update_Bulk_eVoucher_Status($MembershipID,$CompanyId,$evoucher,$data['enroll'],$Quantity_balance,$Item_id,$Update_QTY);
					
					
					
					$Email_content = array(
						// 'Contents' => $html,
						// 'subject' => $subject,
						'Trans_date' => $Trans_date,
						'Merchandize_item_name' => $Merchandize_item_name,
						'evoucher' => $evoucher,
						'Points' => $Points,
						'Quantity' => $Quantity,
						'Issued_Quantity' => $Quantity_balance,
						'Used_Quantity' => $Used_Quantity,
						'Total_points' => $Total_points,
						'Notification_type' => 'eVoucher Status Updation',
						'Template_type' => 'Bulk_Evoucher_Update'
					);
			
					$Notification=$this->send_notification->send_Notification_email($Cust_Enrollement_id,$Email_content,'1',$CompanyId);
					
					$MembershipID=$this->input->post('MembershipID'.$Item_id);   
				/*******************Insert igain Log Table*********************/
					
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 2;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Validate e-Voucher";
					$where="Validate e-Voucher (at Partner Branch)";
					$toname="";
					$To_enrollid =0;
					$firstName = $Full_name;
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $evoucher;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
				/*******************Insert igain Log Table*********************/
				}
				$this->session->set_flashdata("success_code","Updated Successfully!!");
				
				redirect("CatalogueC/Validate_Bulk_EVoucher");
			}
			else
			{
				$this->session->set_flashdata("error_code","Please Select atleast one Checkbox !!!");
				redirect("CatalogueC/Validate_Bulk_EVoucher");
			}
				
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	/****************************************AMIT 18-12-2017*******XXX********/
	
	//************************************ sandeep 14-08-2019 *******************
	function check_partner_phone_email()
	{
		$result = $this->Catelogue_model->check_phone_email($this->input->post("Phone_no"),$this->input->post("userEmailId"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		}
	}
	
	//************************************ sandeep 14-08-2019 *******************
	//************************nilesh start 17-01-2020*************************/
	function Get_order_details()
	{
		$Order_no = $this->input->post("Order_no");
		$CompanyId = $this->input->post("Company_id");
		$Pin_no_applicable = $this->input->post("Pin_no_applicable");
		$Allow_merchant_pin = $this->input->post("Allow_merchant_pin");
		$data["Company_details"] = $this->Igain_model->get_company_details($CompanyId);
		$result = $this->Catelogue_model->Get_order_evouchers_details($Order_no,$CompanyId);
		$data["Shipping_partner"] = $this->E_commerce_model->Get_partner($CompanyId);
		$data["Allow_merchant_pin"]=$Allow_merchant_pin;
		$data["Pin_no_applicable"]=$Pin_no_applicable;  
		$data["Order_no"]=$Order_no;
		$data["results"]=$result;
		$this->load->view('Catalogue/Show_orders_detail', $data); 
	}
	function Fetch_Member_info()
	{
		$Order_no = $this->input->post("Order_no"); 
		$CompanyId = $this->input->post("Company_id");
		$Pin_no_applicable = $this->input->post("Pin_no_applicable");
		$Allow_merchant_pin = $this->input->post("Allow_merchant_pin");
	
		$result = $this->Catelogue_model->Get_order_member_info($Order_no,$CompanyId);
		if($result!=NULL)	
		{
			$member_details = array(
                "Error_flag" => 1001,
                "Card_id" => $result->Card_id,
                "User_email_id" => App_string_decrypt($result->User_email_id),
                "Full_name" => $result->Full_name,
                "Phone_no" => App_string_decrypt($result->Phone_no),
                "Bill_amount" => number_format(round($result->Bill_amount),2),
                "Paid_amount" => number_format(round($result->Paid_amount),2),
                "Amount_due" => number_format(round($result->Amount_due),2)
				);
				
		
			echo json_encode($member_details);
		}
	}
	public function Update_order() 
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

			$Company_details = $this->Igain_model->get_company_details($Company_id);
			$data['Pin_no_applicable'] = $Company_details->Pin_no_applicable;
			$data['Allow_merchant_pin'] = $Company_details->Allow_merchant_pin;
			$Company_website=$Company_details->Website;
			$Comapany_Currency = $Company_details->Currency_name;
			
			$Country_details = $this->Report_model->get_dial_code($Company_details->Country);
			$Symbol_of_currency = $Country_details->Symbol_of_currency;
			
			$data['Symbol_of_currency']=$Symbol_of_currency;
			
			if($_POST == NULL)
			{
				$this->load->view('Catalogue/Update_order_view', $data);
			}
			else
			{	
				$Item_id=$this->input->post('Item_id');
			
				if($Item_id !=NULL)
				{
					$Item_details_array = array();
					$Loyalty_pts = array();
					foreach($Item_id as $Item_id)
					{ 
						$Trans_id=$this->input->post('Trans_id'.$Item_id);
						$Order_no=$this->input->post('Order_no'.$Item_id);
						$Manual_billno=$this->input->post('Manual_billno'.$Item_id);
						$Seller=$this->input->post('Seller'.$Item_id);
						$Order_type=$this->input->post('Order_type'.$Item_id);
						$Evoucher_no=$this->input->post('Voucher_no'.$Item_id);   
						$Membership_id=$this->input->post('MembershipID'.$Item_id);
						$CompanyId=$Company_id;
						$Cust_Enrollement_id=$this->input->post('Cust_Enrollement_id'.$Item_id);
						$Branch_name=$this->input->post('Branch_name'.$Item_id);
						$Branch_Address=$this->input->post('Branch_Address'.$Item_id);
						$Purchase_amount=$this->input->post('Purchase_amount'.$Item_id);
						$Shipping_cost=$this->input->post('Shipping_cost'.$Item_id);
						$Loyalty_points=$this->input->post('Loyalty_points'.$Item_id);
						$Redeem_points=$this->input->post('Redeem_points'.$Item_id);
						$Points=$this->input->post('Points'.$Item_id);
						$Quantity=$this->input->post('Quantity'.$Item_id);
						$Trans_date=$this->input->post('Trans_date'.$Item_id);
						$Merchandize_item_name=$this->input->post('Merchandize_item_name'.$Item_id);
						$Condiments_name=$this->input->post('Condiments_name'.$Item_id);
						$Full_name=$this->input->post('Full_name'.$Item_id);
						$Voucher_status=$this->input->post('Voucher_status'.$Item_id);
						$Shipping_partner=$this->input->post('Shipping_partner'.$Item_id);
						$Update_date=date("Y-m-d H:i:s");
						
						if($Voucher_status == 19)
						{
							$Order_status="Shipped";
						}
						else if($Voucher_status == 20)
						{
							$Order_status="Delivered";
						}
						
						$Item_details = array("Order_no" => $Order_no, "Item_name" =>$Merchandize_item_name,"Condiments_name" =>$Condiments_name,"Quantity" => $Quantity, "Voucher_no" => $Evoucher_no, "Purchase_amount" => $Purchase_amount, "Shipping_cost" => $Shipping_cost, "Loyalty_points" => $Loyalty_points, "Redeem_points" => $Redeem_points, "Voucher_status" => $Order_status);
						
						$Item_details_array[] =$Item_details;
						
						$Loyalty_pts[]=$Loyalty_points;
						
						if($Voucher_status== 19) //Shipped
						{
							//$customer_details = $this->Igain_model->get_enrollment_details($Cust_Enrollement_id);
							
						/*	$data1=array(
								"Voucher_status"=>$Voucher_status,
								"Shipping_partner_id"=>$Shipping_partner,
								"Update_User_id"=>$data['enroll'],
								"Update_date"=>$Update_date
								);
							
							// $result = $this->Catelogue_model->Update_Order_Status($data1,$Membership_id,$data['Company_id'],$Evoucher_no); */
							  
							/*******************Insert igain Log Table*********************/
							/*	$Company_id	= $data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 2;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								$what="Update Order Status";
								$where="Update Order Status";
								$toname="";
								$To_enrollid =0;
								$firstName = $Full_name;
								$lastName = '';
								$Seller_name = $session_data['Full_name'];
								$opval = $Evoucher_no.' - '.$Voucher_status;
								$result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id); */
							/*******************Insert igain Log Table*********************/
						}
						else if($Voucher_status== 20) //Delivered
						{
							$data2=array(
								"Voucher_status"=>$Voucher_status,
								"Shipping_partner_id"=>$Shipping_partner,
								"Update_User_id"=>$data['enroll'],
								"Update_date"=>$Update_date
								);
							
							$result = $this->Catelogue_model->Update_Order_Status($data2,$Membership_id,$data['Company_id'],$Trans_id,$Order_no);
							
							/*******************Insert igain Log Table*********************/
								$Company_id	= $data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 2;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								$what="Update Order Status";
								$where="Update Online Order";
								$toname="";
								$To_enrollid =0;
								$firstName = $Full_name;
								$lastName = '';
								$Seller_name = $session_data['Full_name'];
								$opval = $Evoucher_no.' - '.$Voucher_status;
								
								$result_log_table = $this->Igain_model->Insert_log_table($data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$Cust_Enrollement_id);
							/*******************Insert igain Log Table*********************/
						}
					}
					
					if($Order_type== 28)
					{
						$Order_type1 = "Pick-Up";
						$OrderStatus = "Collected";
					}
					else if($Order_type== 29)
					{
						$Order_type1 = "Delivery";
						$OrderStatus = "Delivered";
					}
					else
					{
						$Order_type1 = "In-Store";
						$OrderStatus = "Collected";
					}
					
					$POS_bill_no = $Manual_billno;
					
					if($POS_bill_no == NULL)
					{
						$POS_bill_no='-';
					}
					
					$Outlet_details = $this->Igain_model->get_enrollment_details($Seller);
					
					$Outlet_name=$Outlet_details->First_name.' '.$Outlet_details->Last_name;
			
					$Creadited_points = array_sum($Loyalty_pts);
				
					$cust_details = $this->Transactions_model->cust_details_from_card($data['Company_id'], $Membership_id);
					
					if($cust_details!=NULL && $Voucher_status == 20)
					{
						foreach ($cust_details as $row25) 
						{
							$card_bal = $row25['Current_balance'];
							$enroll_id = $row25['Enrollement_id'];
						}
						
						$new_cur_bal=$card_bal+$Creadited_points;			
						
						$result = $this->E_commerce_model->Update_member_balance($data['Company_id'],$enroll_id,$new_cur_bal);
						
						$Enroll_details = $this->Igain_model->get_enrollment_details($enroll_id);
						
						$Current_balance = $Enroll_details->Current_balance;
						$Blocked_points = $Enroll_details->Blocked_points;
						$Debit_points = $Enroll_details->Debit_points;
						$Member_name = $Enroll_details->First_name.' '.$Enroll_details->Middle_name.' '.$Enroll_details->Last_name;
						$Current_point_balance1 = $Current_balance - ($Blocked_points + $Debit_points);

						if ($Current_point_balance1 < 0) 
						{
							$Current_point_balance = 0;
						}
						else 
						{
							$Current_point_balance = $Current_point_balance1;
						}						
					
						// $Order_date=date("F j, Y",strtotime($Trans_date));
						$Order_date=$Trans_date;
						
						/**********************Update Customer Balance*************************/	
						/**********************Send Email Notification to Customer*************************/	
						
						$banner_image=$this->config->item('base_url').'images/fulfillment.jpg';	
						
						
						/* <table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
														<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
															<tr>
																<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																		<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=680 height=200 hspace="0" vspace="0">
																</td>
															</tr>
														</table>
														</td>
													</tr>
												</table> */

						$subject = "Redemption Transaction from Merchandizing Catalogue  of our ".$Company_details->Company_name ;

						$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
						$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
						<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>';

						$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';

						$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
						<tr>
							<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
						<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
						</tr>

						<tr>
							<td vAlign=top>
								<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; border-bottom:1px solid #d2d6de" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
								<tr>
									<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
									<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										<tr style="HEIGHT: 10px">
											<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
												
												 

												<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
												Dear '.$Member_name.' ,
												</P>';
												$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
												
												Thank you for placing your Online Order.<br>';
												if($Order_type== 28 || $Order_type== 107)
												{
													$html.='<br>';
												}
												if($Order_type== 29)
												{
													$html.='Your Order is now out for Delivery <br><br>';
												}
												
												/*Thank you for your recent purchase with us. (Refer , Order No. : <b>'. $Order_no.'</b> on <b>'.$Order_date.'</b>) Your item(s) has been Delivered.<br><br>';
												
												As part of the ongoing Campaign in the Loyalty Program, for your above purchase, you are entitled to earned <b> '.$Creadited_points.'</b> '.$Comapany_Currency.'
												So, now your Current Balance is : <b>'.$Current_point_balance.'</b> '.$Comapany_Currency.'<br><br> 	
												
												$html.='Please see details below :<br> <br> */
												
												$html.='<strong>Order Date &nbsp;&nbsp;:</strong> '.$Order_date. '<br>
												<strong>Order No. &nbsp;&nbsp;&nbsp;&nbsp;:</strong> '.$Order_no. '<br>
												<strong>POS Bill No. :</strong> '.$POS_bill_no. '<br>
												<strong>Order Type &nbsp;&nbsp;:</strong> '.$Order_type1. '<br>
												<strong>Outlet Name :</strong> '.$Outlet_name. '<br><br>
												</P>';
												
												$html.='<div class="table-responsive">				
												<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"  border=0 cellSpacing=0 cellPadding=0 align=center> 
												<thead>
												</thead>
												<tbody>'; 
												
												$html .= '<TR>
													   <TD style="border: #dbdbdb 2px ;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left ><b> Sr.No.</b>
													   </TD>
													   
													   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b>Menu Item</b>
													   </TD> 
													   
													   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left colspan="8"><b> </b>
													   </TD>
														
													   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b> Quantity</b>
													   </TD>

													   <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Total Price ('.$Symbol_of_currency.')</b>
													   </TD>';
													   
													  /*  <TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left><b>Delivery Cost ('.$Symbol_of_currency.')</b>
													   </TD>';
														
														<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left> <b>'.$Comapany_Currency.' Earned </b>
														</TD>*/
													$html .='</TR>'; 
														
													$i=1;
													foreach($Item_details_array as $item_array)
													{
														$html .= '<TR>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=center> '.$i.'
																																																			</TD>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Item_name"].'
																																																			</TD>
																																																			<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left  colspan="8">'.$item_array["Condiments_name"].'
																																																			</TD>
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Quantity"].'
															</TD>
															
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Purchase_amount"].'
															</TD>';
															
															/*<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Shipping_cost"].'
															</TD>';
															
															<TD style="border:#dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>'.$item_array["Loyalty_points"].'
															</TD>*/
														  $html .='</TR>';
														$i++;
													}

													$html .='
													</tbody>
												</TABLE>
												</div>												
												<br>';	
												
								$html .= '<br>
									<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
									Regards,
									<br>'.$Company_details->Company_name.' Team.
									</P></td></tr></table></td></tr>

								<tr style="HEIGHT: 20px">
									<td class="row" style="margin-left:-12px;BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
												
								$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly;text-align:justify;" align="center">
								<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_details->Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
								If you are not the intended recipient or responsible for delivery to the intended recipient,
								you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_details->Company_name.' will not accept any claims for damages arising out of viruses.<br>
								Thank you for your cooperation.</em>
								</P> <br>';
								
								$html.='</td></tr></table></td></tr>';					
																			 
								$html.='</table>
									</td></tr><tr>
										<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
									</tr>
								</table>	
							</table>
							</body>
						</html>
						
						<style>
							td, th{
							font-size: 13px !IMPORTANT;
							}
						</style>';
						
						$Email_content = array(
									'Order_no' => $Order_no,
									'Order_date' => $Trans_date,
									'Update_date'  => $Update_date,
									'Update_details' => $html,
									'Notification_type' => 'Your '.$Company_details->Company_name.' Order #'.$Order_no.' has been '.$OrderStatus,
									'Template_type' => 'Update_online_order_status'
								);
								
						$Notification=$this->send_notification->send_Notification_email($enroll_id,$Email_content,$data['enroll'],$data['Company_id']);
					}	
				/**********************Send Email Notification to Customer*************************/
					
					$this->session->set_flashdata("success_code","Order status updated successfully.!!");
					redirect("CatalogueC/Update_order");
				}
				else
				{
					$this->session->set_flashdata("error_code","Please select atleast one order item.!!");
					redirect("CatalogueC/Update_order");
				}
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	//************************nilesh end 17-01-2020*************************/
	
	//******* sandeep 26-05-2020 *************
	public function get_seller_menu_groups()
	{
	
		$seller_id = $this->input->post('seller_id');
		$show_item = $this->input->post('show_item');
		$flag = $this->input->post('flag');
		$Company_id = $this->input->post('Company_id');
		
		$data['MenuGrpArray'] = $this->Catelogue_model->get_offer_menu_groups($seller_id,$Company_id,$show_item);
		
		if($flag == 1)
		{
			//print_r($data['MenuGrpArray']);
			$opText = $this->load->view("Catalogue/get_seller_menu_groups",$data, true);
			
			
			//echo $opText;
			if($opText != null)
			{
				$this->output->set_content_type('text/html');
				$this->output->set_output($opText);
			}
		}
		else{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('MenuGrpArray'=> $data['MenuGrpArray'])));	
		}
	}
	
	public function Set_Merchandize_Category_Order()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Logged_user_id']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];

			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_id = $session_data['userId'];
			
			if($_POST != NULL)
			{
				/*-----------------------File Upload---------------------*/
			
				$config['upload_path'] = './Merchandize_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '700';
				$config['max_height'] = '700';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
				
					$config = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
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
					
				$Categories = $this->input->post('MenuId');
				$SequenceNo = $this->input->post('SequenceNo');
				
				$SequenceNo_vals = array_count_values($SequenceNo);
				
				foreach($SequenceNo_vals as $k=>$x){
					if($k > 0 && $x > 1)
					{
						$this->session->set_flashdata("error_code","Please enter unique order numbers!!");
					
						redirect("CatalogueC/Create_Merchandize_Category");
						break;
					}
				}
				//$files = $_FILES["files"]["name"];
				$dataInfo = array();
				$files = $_FILES;
				$prev_img = "";
				
				if($Categories != NULL)
				{
					for($z=0;$z < count($Categories);$z++)
					{
						
						$_FILES['files']['name']= $files['files']['name'][$z];
						$_FILES['files']['type']= $files['files']['type'][$z];
						$_FILES['files']['tmp_name']= $files['files']['tmp_name'][$z];
						$_FILES['files']['error']= $files['files']['error'][$z];
						$_FILES['files']['size']= $files['files']['size'][$z];    

					//	echo "cat--".$Categories[$z]."--seq--".$SequenceNo[$z]."--img--".$_FILES['files']['name']."--<br>";
						//continue;
					
						$upload22 = $this->upload->do_upload('files');
						$data22 = $this->upload->data();
						
						if($data22['is_image'] == 1 && $prev_img != $data22['file_name']) 
						{						 
							$configThumb['source_image'] = $data22['full_path'];
							$configThumb['source_image'] = './Merchandize_images/original/'.$upload22;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$Item_image1=base_url().'Merchandize_images/original/'.$data22['file_name'];
							
							$prev_img = $data22['file_name'];
						}
						else
						{
							$Item_image1 = null;
							
						}
						
						$this->Catelogue_model->set_category_order_icon($Company_id,$SequenceNo[$z],$Item_image1,$Categories[$z]);
					}
				}
			}
		//	die;
			$this->session->set_flashdata("success_code","Menu category sequence updated successfully.!!");
					
			redirect("CatalogueC/Create_Merchandize_Category");
		}
	}
	//******* sandeep 26-05-2020 *************
}	
?>
