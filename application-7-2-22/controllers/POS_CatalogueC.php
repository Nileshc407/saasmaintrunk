<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class POS_CatalogueC extends CI_Controller
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
		$this->load->model('master/Merchant_model');
		$this->load->model('POS_catlogueM/POS_catalogue_model');
		$this->load->library('image_lib');
		
	}
	
	//********************* sandeep work *****************************
	
	public function Create_Required_Optional_Condiments()
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
			$data['Logged_user_id'] = $session_data['userId'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$totalReqOpt = $this->POS_catalogue_model->get_required_optional_condiments("", "",$Company_id,"");
			
			/*-----------------------Pagination---------------------*/		
				$config = array();
				$config["base_url"] = base_url() . "/index.php/POS_CatalogueC/Create_Required_Optional_Condiments";
				$total_row = 0; //$this->Administration_model->loyalty_rule_count($Company_id,$Logged_user_enrollid,$Logged_user_id);	
				 
				// echo "--total_row---".$total_row."--<br>";	
				$config["total_rows"] = count($totalReqOpt);
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
			
			$data["result_data"] = $this->POS_catalogue_model->get_required_optional_condiments($config["per_page"], $page,$Company_id,"");
			
			$data["pagination"] = $this->pagination->create_links();		
		/*-----------------------Pagination---------------------*/
			if($_GET != NULL || $_POST == NULL)
			{
				$data["Condiment_groupId"] = 0;
				$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
				
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
				
				$data["code_decode_types"] = $this->Merchant_model->Code_decode_type_list("","");
				$data["Merchandize_Category_list"] = $this->Catelogue_model->Get_Merchandize_Category("","",$Company_id);
				
				if($_GET != NULL )
				{
					if($_GET['GroupCode'] != null){

						$resultItems = $this->POS_catalogue_model->get_required_optional_condiments("","",$Company_id,$_GET['GroupCode']);
						
						if($resultItems != NULL)
						{
							foreach($resultItems as $rowx)
							{
								$data["Condiment_groupId"] = $rowx->Id;
								$data["Condiment_type"] = $rowx->Condiment_type;
								$data["Group_code"] = $rowx->Group_code;
								$data["Group_name"] = $rowx->Group_name;
								$data["Label"] = $rowx->Label;
								$data["Menu_group_id"] = $rowx->Menu_group_id;
								$Items[] = $rowx->Condiment_item_code;	
							}
						
						
						$Category_items_list = $this->Catelogue_model->Get_Category_linked_Merchandize_Items($data["Menu_group_id"],1,0);
		
						$data['Category_items_list'] = $Category_items_list;

						$data["linked_items_list"] = $Items;
						}
					}
				}
				
				$this->load->view('POS_Catalogue/Create_Required_Optional_CondimentsV',$data);	
			}
			else // to insert
			{			
				$Condiment_items_code = $this->input->post("Condiment_item_code");
				
				if(count($Condiment_items_code) > 0)
				{
					$opration = $this->input->post("operationFlag");
					
					if($opration == 1){
						$result = $this->POS_catalogue_model->insert_required_optional_condiments();
						$this->session->set_flashdata("success_code","Condiments Group Created Successfully!!");
					}
					
					if($opration == 2 && $this->input->post("Group_code") != NULL){
						$result = $this->POS_catalogue_model->update_required_optional_condiments($this->input->post("Group_code"),$this->input->post("Company_id"));
						
						$this->session->set_flashdata("success_code","Condiments Group Updated Successfully!!");
					}
				
				
					if($result == true)
					{

				/**************Nilesh change igain Log Table change 14-06-2017****************/
					$seller = $this->input->post("seller_id");
					$get_marchent = $this->Igain_model->get_enrollment_details($seller);
					$to_enroll_id = $get_marchent->Enrollement_id;	
					$First_name = $get_marchent->First_name;	
					$Last_name = $get_marchent->Last_name;	
					$Todays_date = date('Y-m-d');	
								
					// $userid=$data['userId'];
					$userid=$Logged_user_id;
					$what="Required Optional Condiment";
					$where="Required/Optional Condiments Group";
					$toname="";
						// $opval = 4; // transaction type
						if($to_enroll_id == 0 || $to_enroll_id == "" )
						{
							$To_enrollid=0;
						}
						else
						{
							$To_enrollid=$to_enroll_id;
						}
					$firstName = $First_name;
					$lastName = $Last_name;  
					// $data['LogginUserName'] = $Seller_name;
					$Seller_name = $session_data['Full_name'];
					$opval = $this->input->post("Group_name");
					
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$data['enroll'],$data['username'],$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					
				/*********************Nilesh change igain Log Table change 14-06-2017***********************/
					}
					else
					{	
						$this->session->set_flashdata("error_code","Error IN Condiment Create/Edit !");
					}
				}
				else
				{							
					$this->session->set_flashdata("error_code","Please Select Items Linked With Menu Group!");
				}
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function delete_required_optional_condiments(){
		$GroupCode = $this->input->get('GroupCode');
		$Company_id = $this->input->get("Company_id");
		
		if($GroupCode != NULL){
			$resultS = $this->POS_catalogue_model->delete_requOptional_condiments($GroupCode,$Company_id);
		}
		
		$this->session->set_flashdata("error_code","Condiments Group Deleted Successfully!!");
			
		$this->Create_Required_Optional_Condiments();
	}
	
	function Get_Category_Merchandize_Items()
	{
		$Merchandize_category_id = $this->input->post('Merchandize_category_id');
		
		$Category_items_list = $this->Catelogue_model->Get_Category_linked_Merchandize_Items($Merchandize_category_id,1,0);
		
		$data['Category_items_list'] = $Category_items_list;
		
		if(count($Category_items_list) > 0)
		{
			$theHTMLResponse = $this->load->view('Show_Category_linked_Items', $data, true);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('ItemsListHtml' => $theHTMLResponse)));
		}
		else
		{
			return false;
		}
	}
	
	function check_required_optional_group()
	{
		$GroupCode = $this->input->post('Group_code');
		$CompanyId = $this->input->post('Group_CompanyId');
		
		$resultItems = $this->POS_catalogue_model->get_required_optional_condiments("","",$CompanyId,$GroupCode);
						
		if($resultItems != NULL)
		{
			$this->output->set_output(1);
		}
		else
		{
			$this->output->set_output(0);
		}
	}
	//********************* sandeep work *****************************
	
	/**************************************************Create Merchandise Items Start*************************************/
	public function Create_POS_items()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			/****************POS CHANGES AMIT KAMBLE 07-11-2019****************/
			$data["Allergies_Code_decode"] = $this->POS_catalogue_model->Get_Code_decode_master(18);
			$data["Req_cond_group"] = $this->POS_catalogue_model->Get_req_opt_cond_group(14,$Company_id);
			$data["Opt_cond_group"] = $this->POS_catalogue_model->Get_req_opt_cond_group(15,$Company_id);
			$Partner_records = $this->POS_catalogue_model->Get_Partner_master($Company_id);
			$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
			$Seller_id=$Super_Seller->Enrollement_id;
			/**********************************************************/
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category('', '',$Company_id);
			
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			
			/*----------------------Active-Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/POS_CatalogueC/Create_POS_items";
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
			$config2["base_url"] = base_url() . "/index.php/POS_CatalogueC/Create_POS_items";
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
				
				$this->load->view('POS_Catalogue/POS_Create_Merchandize_ItemsV', $data);
				
			}
			else
			{	
			
				/*-----------------------------------Image Upload Code-----------------------------*/
				
				/*-----------------------------------Image1-----------------------------*/
				
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
					$upload22 = $this->upload->do_upload('file1');
					$data22 = $this->upload->data();			   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload22;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image1=base_url().'Merchandize_images/original/'.$data22['file_name'];
					}
					else
					{
						$Item_image1 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image1 =$this->input->post("Item_image1");								
						}
					}
					
					$config = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
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
					$upload22 = $this->upload->do_upload('file1');
					$data22 = $this->upload->data();			   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload22;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image1=base_url().'Merchandize_images/thumbs/'.$data22['file_name'];
					}
					else
					{							
						$Thumbnail_image1 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image1 =$this->input->post("Thumbnail_image1");								
						}
					}
				/*-----------------------------------Image1-----------------------------*/	
				
				/*-----------------------------------Image2-----------------------------*/
				
					$config1 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config1);
					$this->upload->initialize($config1);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload23 = $this->upload->do_upload('file2');
					$data23 = $this->upload->data();			   
					if($data23['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data23['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload23;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image2=base_url().'Merchandize_images/original/'.$data23['file_name'];
					}
					else
					{
						$Item_image2 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image2 =$this->input->post("Item_image2");								
						}
					}
					
					$config2 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
					);
					
					$this->load->library('upload', $config2);
					$this->upload->initialize($config2);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload24 = $this->upload->do_upload('file2');
					$data24 = $this->upload->data();			   
					if($data24['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data24['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload24;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image2=base_url().'Merchandize_images/thumbs/'.$data24['file_name'];
					}
					else
					{							
						$Thumbnail_image2 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image2 =$this->input->post("Thumbnail_image2");								
						}
					}
				/*-----------------------------------Image2-----------------------------*/	
				
				/*-----------------------------------Image3-----------------------------*/
				
					$config3 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config3);
					$this->upload->initialize($config3);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload25 = $this->upload->do_upload('file3');
					$data25 = $this->upload->data();			   
					if($data25['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data25['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload25;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image3=base_url().'Merchandize_images/original/'.$data25['file_name'];
					}
					else
					{
						$Item_image3 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image3 =$this->input->post("Item_image3");								
						}
					}
					
					$config4 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
					);
					
					$this->load->library('upload', $config4);
					$this->upload->initialize($config4);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload26 = $this->upload->do_upload('file3');
					$data26 = $this->upload->data();			   
					if($data26['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data26['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload26;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image3=base_url().'Merchandize_images/thumbs/'.$data26['file_name'];
					}
					else
					{							
						$Thumbnail_image3 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image3 =$this->input->post("Thumbnail_image3");								
						}
					}
				/*-----------------------------------Image3-----------------------------*/	
				
				
				/*-----------------------------------Image4-----------------------------*/
				
					$config5 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config5);
					$this->upload->initialize($config5);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload27 = $this->upload->do_upload('file4');
					$data27 = $this->upload->data();			   
					if($data27['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data27['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload27;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image4=base_url().'Merchandize_images/original/'.$data27['file_name'];
					}
					else
					{
						$Item_image4 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image4 =$this->input->post("Item_image4");								
						}
					}
					
					$config6 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
					);
					
					$this->load->library('upload', $config6);
					$this->upload->initialize($config6);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload28 = $this->upload->do_upload('file4');
					$data28 = $this->upload->data();			   
					if($data28['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data28['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload28;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image4=base_url().'Merchandize_images/thumbs/'.$data28['file_name'];
					}
					else
					{							
						$Thumbnail_image4 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image4 =$this->input->post("Thumbnail_image4");								
						}
					}
				
					
					
			
						
						/*****************************Insert Partner Branches*****************************/
						
						$Partner_Branch_Records = $this->Catelogue_model->Get_Partners_Branches($Partner_records->Partner_id);
						
						foreach($Partner_Branch_Records as $Partner_Branch_Records)
						{
							//echo "<br> Branch_code111111 ".$Partner_Branch_Records->Branch_code;
							$Post_data2=array(
							'Company_id'=>$Company_id,
							'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Partner_id'=>$Partner_records->Partner_id,
							'Branch_code'=>$Partner_Branch_Records->Branch_code,
							'Create_user_id'=>$this->input->post('Create_user_id'),
							'Create_date'=>$this->input->post('Create_date'));
							$result2 = $this->Catelogue_model->Insert_Merchandize_Item_branches($Post_data2);
						}
								
					/*****************************Insert POS Price *****************************/
					$Item_price_flag = $_REQUEST['Item_price_flag'];
					$Price_Active_flag1 = 0;
					$Price_Active_flag2 = 0;
					$Price_Active_flag3 = 0;
					if($Item_price_flag==1)
					{
						$Billing_price = $_REQUEST['POS_Price1'];
						$Price_Active_flag1 = 1;
						
						$Valid_from=date("Y-m-d",strtotime($this->input->post('POS_Valid_from1')));
						$Valid_till=date("Y-m-d",strtotime($this->input->post('POS_Valid_till1')));
					}
					else if($Item_price_flag==2)
					{
						$Billing_price = $_REQUEST['POS_Price2'];
						$Price_Active_flag2 = 1;
						
						$Valid_from=date("Y-m-d",strtotime($this->input->post('POS_Valid_from2')));
						$Valid_till=date("Y-m-d",strtotime($this->input->post('POS_Valid_till2')));
					}
					else
					{
						$Billing_price = $_REQUEST['POS_Price3'];
						$Price_Active_flag3 = 1;
						
						$Valid_from=date("Y-m-d",strtotime($this->input->post('POS_Valid_from3')));
						$Valid_till=date("Y-m-d",strtotime($this->input->post('POS_Valid_till3')));
					}
					
					if($_REQUEST['POS_Price1']!="" && $_REQUEST['POS_Valid_from1']!="" && $_REQUEST['POS_Valid_till1']!="")
					{
						$Post_data31=array(
							'Company_id'=>$Company_id,
							'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Pos_price'=>$_REQUEST['POS_Price1'],
							'From_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_from1'))),
							'To_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_till1'))),
							'Old_Price_flag'=>0,
							'Create_user_id'=>$data['enroll'],
							'Create_date'=>date('Y-m-d H:i:s'),
							'Price_Active_flag'=>$Price_Active_flag1);
						$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
					}
					
					if($_REQUEST['POS_Price2']!="" && $_REQUEST['POS_Valid_from2']!="" && $_REQUEST['POS_Valid_till2']!="")
					{
						$Post_data32=array(
							'Company_id'=>$Company_id,
							'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Pos_price'=>$_REQUEST['POS_Price2'],
							'From_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_from2'))),
							'To_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_till2'))),
							'Old_Price_flag'=>0,
							'Create_user_id'=>$data['enroll'],
							'Create_date'=>date('Y-m-d H:i:s'),
							'Price_Active_flag'=>$Price_Active_flag2);
						$Insert_pos_price2 = $this->POS_catalogue_model->Insert_pos_price($Post_data32);
					}
					
					if($_REQUEST['POS_Price3']!="" && $_REQUEST['POS_Valid_from3']!="" && $_REQUEST['POS_Valid_till3']!="")
					{
						$Post_data33=array(
							'Company_id'=>$Company_id,
							'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Pos_price'=>$_REQUEST['POS_Price3'],
							'From_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_from3'))),
							'To_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_till3'))),
							'Old_Price_flag'=>0,
							'Create_user_id'=>$data['enroll'],
							'Create_date'=>date('Y-m-d H:i:s'),
							'Price_Active_flag'=>$Price_Active_flag3);
						$Insert_pos_price3 = $this->POS_catalogue_model->Insert_pos_price($Post_data33);
					}
					
					
		
				/********Insert Allergies ,Required Condiment Group,Optional Condiment Group***********/
				
					if($_REQUEST['Allergies'] != NULL)
					{
						foreach($_REQUEST['Allergies'] as $all)
						{
							$Post_data4=array(
							'Company_id'=>$Company_id,
							'Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Require_optional'=>18,
							'Condiment_item_code'=>$all
							);
							$Insert_pos_cond = $this->POS_catalogue_model->Insert_pos_condiments($Post_data4);
						}
					}
					
					if($_REQUEST['Item_type']==117)//Standard
					{
						/*if($_REQUEST['Required_Condiment_Group'] != NULL)
						{
							foreach($_REQUEST['Required_Condiment_Group'] as $Required)
							{
								$Post_data5=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>14,
								'Condiment_item_code'=>$Required
								);
								$Insert_pos_req = $this->POS_catalogue_model->Insert_pos_condiments($Post_data5);
							}
							
						}*/
						if($_REQUEST['Required_Condiment_Values'] != NULL)
						{
							foreach($_REQUEST['Required_Condiment_Values'] as $Required)
							{
								$val=explode("-",$Required);
								$Post_data6=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>14,
								'Condiment_item_code'=>$val[1],
								'Group_code'=>$val[0]
								);
								$Insert_pos_req = $this->POS_catalogue_model->Insert_pos_condiments($Post_data6);
							}
							
						}
						/*if($_REQUEST['Optional_Condiment_Group'] != NULL)
						{
							foreach($_REQUEST['Optional_Condiment_Group'] as $Opt)
							{
								$Post_data7=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>15,
								'Condiment_item_code'=>$Opt
								);
								$Insert_pos_req = $this->POS_catalogue_model->Insert_pos_condiments($Post_data7);
							}
							
						}*/
						if($_REQUEST['Optional_Condiment_Values'] != NULL)
						{
							foreach($_REQUEST['Optional_Condiment_Values'] as $Optional)
							{
								$val=explode("-",$Optional);
								$Post_data8=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>15,
								'Condiment_item_code'=>$val[1],
								'Group_code'=>$val[0]
								);
								$Insert_pos_opt = $this->POS_catalogue_model->Insert_pos_condiments($Post_data8);
							}
							
						}
						
					}
					
						
						
				/****************************************Combo Item********************************/
				$Combo_meal_no=0;
				$Combo_meal_flag=0;
				if($_REQUEST['Item_type']==118)//Combo
				{
					$Combo_meal_no=$_REQUEST['Combo_meal_no'];
					// $Main_item_code=trim($_REQUEST['Main_item_code']);
					// $Main_Quantity=$_REQUEST['Main_Quantity'];
					// $Main_Price=$_REQUEST['Main_Price'];
					$Combo_meal_flag=1;
					$Main_Side_label=$_REQUEST['Main_Side_label'];
					$Company_merchandize_item_code=$_REQUEST['Company_merchandize_item_code'];
					
					$Update_main_side_label= $this->POS_catalogue_model->Update_main_side_label($Company_id,$Company_merchandize_item_code,$Main_Side_label);
					/**********INSERT Main Item ********************
						
					$Post_data9=array(
								'Company_id'=>$Company_id,
								'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Item_flag'=>'MAIN',
								'Main_or_side_item_code'=>$Main_item_code,
								'Quanity'=>$Main_Quantity,
								'Price'=>$Main_Price,
								);
					$Insert_pos_MAIN= $this->POS_catalogue_model->Insert_pos_main_item($Post_data9);
					/**********INSERT SIDE Item ********************/
					if($_REQUEST['Side_item_check'] != NULL)
					{
							foreach($_REQUEST['Side_item_check'] as $Side_No)
							{
								$Side_label=$_REQUEST["Side_label$Side_No"];
								$Main_or_side_item_code=$_REQUEST["Main_or_side_item_code$Side_No"];
								
								$Post_data10=array(
								'Company_id'=>$Company_id,
								'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Item_flag'=>'SIDE',
								'Main_or_side_item_code'=>$Main_or_side_item_code,
								'Side_label'=>$Side_label
								);
								$Insert_pos_SIDE= $this->POS_catalogue_model->Insert_pos_main_item($Post_data10);
							}
					}
				}						
				
				/****************************************Insert item catalogue********************************/	
				$Post_data=array(
				'Company_id'=>$Company_id,
				'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
				'Merchandize_item_type'=>$_REQUEST['Item_type'],
				'Partner_id'=>$Partner_records->Partner_id,
				'Seller_id'=>$Seller_id,
				'Cost_price'=>$Billing_price,
				'Billing_price'=>$Billing_price,
				'Valid_from'=>$Valid_from,
				'Valid_till'=>$Valid_till,
				'Merchandize_category_id'=>$this->input->post('Menu_group_id'),
				'Merchandize_item_name'=>$this->input->post('Merchandize_item_name'),
				'Merchandise_item_description'=>$this->input->post('Merchandise_item_description'),
				'Markup_percentage'=>$Partner_records->Partner_markup_percentage,
				'VAT'=>$Partner_records->Partner_vat,
				'Item_image1'=>$Item_image1,
				'Item_image2'=>$Item_image2,
				'Item_image3'=>$Item_image3,
				'Item_image4'=>$Item_image4,
				'Thumbnail_image1'=>$Thumbnail_image1,
				'Thumbnail_image2'=>$Thumbnail_image2,
				'Thumbnail_image3'=>$Thumbnail_image3,
				'Thumbnail_image4'=>$Thumbnail_image4,
				'Billing_price_in_points'=>0,
				'Delivery_method'=>0,
				'show_item'=>1,
				'Ecommerce_flag'=>1,
				'Product_group_id'=>$this->input->post('Main_group_id'),
 				'Product_brand_id'=>$this->input->post('Sub_group_id'),
 				'Combo_meal_flag'=>$Combo_meal_flag,
 				'Combo_meal_number'=>$Combo_meal_no,
 				'Stamp_item_flag'=>$this->input->post('Stamp_item_flag'),
 				'Extra_earn_points'=>$this->input->post('Extra_earn_points'),
 				'Voucher_item_flag'=>$this->input->post('Voucher_item_flag'),
				'Create_user_id'=>$session_data['enroll'],
				'Creation_date'=>date('Y-m-d H:i:s'),
				'Active_flag'=>1);
				
				$result = $this->Catelogue_model->Insert_Merchandize_Item($Post_data);
				
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","POS Item  Created Successfuly!!");
					
				/*******************Insert igain Log Table*********************/
					$get_partner_detail = $this->Catelogue_model->Get_Company_Partners_details($Partner_records->Partner_id);
					$Partner_id = $get_partner_detail->Partner_id;
					$Partner_name = $get_partner_detail->Partner_name;
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 1;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Create POS Items";
					$where="Create POS Items";
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
					$this->session->set_flashdata("error_code","POS Item  Error!!");
				}
				redirect("POS_CatalogueC/Create_POS_items");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	public function Edit_POS_Items()
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
			
			$data["Seller_Redemptionratio"] = $this->Igain_model->get_enrollment_details($data['enroll']);
			$Seller_Redemptionratio=$data["Seller_Redemptionratio"]->Seller_Redemptionratio;
			
			//$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category('', '',$Company_id);
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			//$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			
			
			/****************POS CHANGES AMIT KAMBLE 07-11-2019****************/
			$data["Allergies_Code_decode"] = $this->POS_catalogue_model->Get_Code_decode_master(18);
			$data["Req_cond_group"] = $this->POS_catalogue_model->Get_req_opt_cond_group(14,$Company_id);
			$data["Opt_cond_group"] = $this->POS_catalogue_model->Get_req_opt_cond_group(15,$Company_id);
			$Partner_records = $this->POS_catalogue_model->Get_Partner_master($Company_id);
			
			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/POS_CatalogueC/Create_POS_items";
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
			
			//******** sandeep *************
			$seller_id=$data["Merchandize_Item_Row"]->Seller_id;
			$data["Product_group_Records"] = $this->POS_catalogue_model->get_seller_linked_main_groups($seller_id,$Company_id);
			$data["Merchandize_Category_Records"] = $this->POS_catalogue_model->get_seller_linked_menu_groups($seller_id,$Company_id);
			//******** sandeep *************
			
			$data["Merchandize_Item_Branches"] = $this->Catelogue_model->Get_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);	
		
			$data['Get_Product_Brands'] = $this->Catelogue_model->Get_Product_Brands($lv_Product_group_id,$Company_id);
			
			$data["Allergies_selected"] = $this->POS_catalogue_model->Get_Selected_item_condiments($Company_merchandize_item_code,$Company_id,18);
			
			$data["Required_selected"] = $this->POS_catalogue_model->Get_Selected_item_condiments($Company_merchandize_item_code,$Company_id,14);
			
			$data["Optional_selected"] = $this->POS_catalogue_model->Get_Selected_item_condiments($Company_merchandize_item_code,$Company_id,15);
			
			$data["POS_prices"] = $this->POS_catalogue_model->Get_POS_Item_prices($Company_merchandize_item_code,$Company_id);
			
			$data["Combo_Main_item"] = $this->POS_catalogue_model->Get_Combo_Main_item($Company_merchandize_item_code,$Company_id);
			
			$data["Combo_Side_items"] = $this->POS_catalogue_model->Get_Combo_Side_items($Company_merchandize_item_code,$Company_id);
			
			$data['Get_pos_side_groups_items'] = $this->POS_catalogue_model->Get_pos_side_groups_items($Company_id,$Company_merchandize_item_code);
			
			$data['Get_pos_main_items'] = $this->POS_catalogue_model->Get_pos_main_item_combo_child($Company_id,$Company_merchandize_item_code);
			// print_r($data['Get_pos_side_groups_items']);die;
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
				
				$this->load->view('POS_Catalogue/POS_EDIT_Merchandize_ItemsV', $data);
			}
			else
			{
				
				/*-----------------------------------Image Upload Code-----------------------------*/
				
				/*-----------------------------------Image1-----------------------------*/
				
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
					$upload22 = $this->upload->do_upload('file1');
					$data22 = $this->upload->data();			   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload22;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image1=base_url().'Merchandize_images/original/'.$data22['file_name'];
					}
					else
					{
						$Item_image1 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image1 =$this->input->post("Item_image1");								
						}
					}
					
					$config = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
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
					$upload22 = $this->upload->do_upload('file1');
					$data22 = $this->upload->data();			   
					if($data22['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data22['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload22;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image1=base_url().'Merchandize_images/thumbs/'.$data22['file_name'];
					}
					else
					{							
						$Thumbnail_image1 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image1 =$this->input->post("Thumbnail_image1");								
						}
					}
				/*-----------------------------------Image1-----------------------------*/	
				
				/*-----------------------------------Image2-----------------------------*/
				
					$config1 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config1);
					$this->upload->initialize($config1);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload23 = $this->upload->do_upload('file2');
					$data23 = $this->upload->data();			   
					if($data23['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data23['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload23;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image2=base_url().'Merchandize_images/original/'.$data23['file_name'];
					}
					else
					{
						$Item_image2 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image2 =$this->input->post("Item_image2");								
						}
					}
					
					$config2 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
					);
					
					$this->load->library('upload', $config2);
					$this->upload->initialize($config2);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload24 = $this->upload->do_upload('file2');
					$data24 = $this->upload->data();			   
					if($data24['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data24['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload24;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image2=base_url().'Merchandize_images/thumbs/'.$data24['file_name'];
					}
					else
					{							
						$Thumbnail_image2 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image2 =$this->input->post("Thumbnail_image2");								
						}
					}
				/*-----------------------------------Image2-----------------------------*/	
				
				/*-----------------------------------Image3-----------------------------*/
				
					$config3 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config3);
					$this->upload->initialize($config3);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload25 = $this->upload->do_upload('file3');
					$data25 = $this->upload->data();			   
					if($data25['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data25['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload25;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image3=base_url().'Merchandize_images/original/'.$data25['file_name'];
					}
					else
					{
						$Item_image3 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image3 =$this->input->post("Item_image3");								
						}
					}
					
					$config4 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
					);
					
					$this->load->library('upload', $config4);
					$this->upload->initialize($config4);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload26 = $this->upload->do_upload('file3');
					$data26 = $this->upload->data();			   
					if($data26['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data26['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload26;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image3=base_url().'Merchandize_images/thumbs/'.$data26['file_name'];
					}
					else
					{							
						$Thumbnail_image3 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image3 =$this->input->post("Thumbnail_image3");								
						}
					}
				/*-----------------------------------Image3-----------------------------*/	
				
				
				/*-----------------------------------Image4-----------------------------*/
				
					$config5 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/original/' //upload directory
					);
					
					$this->load->library('upload', $config5);
					$this->upload->initialize($config5);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;
			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload27 = $this->upload->do_upload('file4');
					$data27 = $this->upload->data();			   
					if($data27['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data27['full_path'];
						$configThumb['source_image'] = './Merchandize_images/original/'.$upload27;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Item_image4=base_url().'Merchandize_images/original/'.$data27['file_name'];
					}
					else
					{
						$Item_image4 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Item_image4 =$this->input->post("Item_image4");								
						}
					}
					
					$config6 = array
					(
						'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
						'max_size'          => 2048, //2MB max
						'max_width'          => 3000, //2MB max
						'max_height'          => 3000, //2MB max
						'encrypt_name'    => true,
						'upload_path'       => './Merchandize_images/thumbs/' //upload directory
					);
					
					$this->load->library('upload', $config6);
					$this->upload->initialize($config6);
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					/* Load the image library */
					$this->load->library('image_lib');						
					$upload28 = $this->upload->do_upload('file4');
					$data28 = $this->upload->data();			   
					if($data28['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data28['full_path'];
						$configThumb['source_image'] = './Merchandize_images/thumbs/'.$upload28;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$Thumbnail_image4=base_url().'Merchandize_images/thumbs/'.$data28['file_name'];
					}
					else
					{							
						$Thumbnail_image4 = base_url()."images/no_image.jpeg";
						if(isset($_REQUEST["Company_merchandise_item_id"]))
						{
							$Thumbnail_image4 =$this->input->post("Thumbnail_image4");								
						}
					}
				/*-----------------------------------Image4-----------------------------*/		
					
					
								
					/*****************************Insert POS Price *****************************/
					$Item_price_flag = $_REQUEST['Item_price_flag'];
					$Price_Active_flag1 = 0;
					$Price_Active_flag2 = 0;
					$Price_Active_flag3 = 0;
					if($Item_price_flag==1)
					{
						$Billing_price = $_REQUEST['POS_Price1'];
						$Price_Active_flag1 = 1;
						
						$Valid_from=date("Y-m-d",strtotime($this->input->post('POS_Valid_from1')));
						$Valid_till=date("Y-m-d",strtotime($this->input->post('POS_Valid_till1')));
					}
					else if($Item_price_flag==2)
					{
						$Billing_price = $_REQUEST['POS_Price2'];
						$Price_Active_flag2 = 1;
						
						$Valid_from=date("Y-m-d",strtotime($this->input->post('POS_Valid_from2')));
						$Valid_till=date("Y-m-d",strtotime($this->input->post('POS_Valid_till2')));
					}
					else
					{
						$Billing_price = $_REQUEST['POS_Price3'];
						$Price_Active_flag3 = 1;
						
						$Valid_from=date("Y-m-d",strtotime($this->input->post('POS_Valid_from3')));
						$Valid_till=date("Y-m-d",strtotime($this->input->post('POS_Valid_till3')));
					}
					
					$Update1 = $this->POS_catalogue_model->Update_pos_combo_child($Company_id,$this->input->post('Company_merchandize_item_code'));
					if($_REQUEST['POS_Price1']!="" && $_REQUEST['POS_Valid_from1']!="" && $_REQUEST['POS_Valid_till1']!="")
					{
						
						
						$Post_data31=array(
							'Company_id'=>$Company_id,
							'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Pos_price'=>$_REQUEST['POS_Price1'],
							'From_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_from1'))),
							'To_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_till1'))),
							'Old_Price_flag'=>0,
							'Update_user_id'=>$data['enroll'],
							'Update_date'=>date('Y-m-d H:i:s'),
							'Price_Active_flag'=>$Price_Active_flag1);
						$Insert_pos_price1 = $this->POS_catalogue_model->Insert_pos_price($Post_data31);
					}
					
					if($_REQUEST['POS_Price2']!="" && $_REQUEST['POS_Valid_from2']!="" && $_REQUEST['POS_Valid_till2']!="")
					{
						$Post_data32=array(
							'Company_id'=>$Company_id,
							'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Pos_price'=>$_REQUEST['POS_Price2'],
							'From_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_from2'))),
							'To_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_till2'))),
							'Old_Price_flag'=>0,
							'Update_user_id'=>$data['enroll'],
							'Update_date'=>date('Y-m-d H:i:s'),
							'Price_Active_flag'=>$Price_Active_flag2);
						$Insert_pos_price2 = $this->POS_catalogue_model->Insert_pos_price($Post_data32);
					}
					
					if($_REQUEST['POS_Price3']!="" && $_REQUEST['POS_Valid_from3']!="" && $_REQUEST['POS_Valid_till3']!="")
					{
						$Post_data33=array(
							'Company_id'=>$Company_id,
							'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Pos_price'=>$_REQUEST['POS_Price3'],
							'From_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_from3'))),
							'To_date'=>date("Y-m-d",strtotime($this->input->post('POS_Valid_till3'))),
							'Old_Price_flag'=>0,
							'Update_user_id'=>$data['enroll'],
							'Update_date'=>date('Y-m-d H:i:s'),
							'Price_Active_flag'=>$Price_Active_flag3);
						$Insert_pos_price3 = $this->POS_catalogue_model->Insert_pos_price($Post_data33);
					}
					
					
		
				/********Insert Allergies ,Required Condiment Group,Optional Condiment Group***********/
					$delete2 = $this->POS_catalogue_model->Delete_pos_item_cond($Company_id,$this->input->post('Company_merchandize_item_code'),18);
					if($_REQUEST['Allergies'] != NULL)
					{
						
					
						foreach($_REQUEST['Allergies'] as $all)
						{
							$Post_data4=array(
							'Company_id'=>$Company_id,
							'Item_code'=>$this->input->post('Company_merchandize_item_code'),
							'Require_optional'=>18,
							'Condiment_item_code'=>$all
							);
							$Insert_pos_cond = $this->POS_catalogue_model->Insert_pos_condiments($Post_data4);
						}
					}
					
					if($_REQUEST['Item_type']==117)//Standard
					{
						/*if($_REQUEST['Required_Condiment_Group'] != NULL)
						{
							$delete2 = $this->POS_catalogue_model->Delete_pos_item_cond($Company_id,$this->input->post('Company_merchandize_item_code'),14);
							foreach($_REQUEST['Required_Condiment_Group'] as $Required)
							{
								$Post_data5=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>14,
								'Condiment_item_code'=>$Required
								);
								$Insert_pos_req = $this->POS_catalogue_model->Insert_pos_condiments($Post_data5);
							}
							
						}*/
						$delete2 = $this->POS_catalogue_model->Delete_pos_item_cond($Company_id,$this->input->post('Company_merchandize_item_code'),14);
						if($_REQUEST['Required_Condiment_Values'] != NULL)
						{
							
							// print_r($_REQUEST['Required_Condiment_Values']);die;
							foreach($_REQUEST['Required_Condiment_Values'] as $Required)
							{
								$val=explode("-",$Required);
								$Post_data6=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>14,
								'Condiment_item_code'=>$val[1],
								'Group_code'=>$val[0]
								);
								$Insert_pos_req = $this->POS_catalogue_model->Insert_pos_condiments($Post_data6);
							}
							
						}
						/*if($_REQUEST['Optional_Condiment_Group'] != NULL)
						{
							$delete2 = $this->POS_catalogue_model->Delete_pos_item_cond($Company_id,$this->input->post('Company_merchandize_item_code'),15);
							foreach($_REQUEST['Optional_Condiment_Group'] as $Opt)
							{
								$Post_data7=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>15,
								'Condiment_item_code'=>$Opt
								);
								$Insert_pos_req = $this->POS_catalogue_model->Insert_pos_condiments($Post_data7);
							}
							
						}*/
						$delete2 = $this->POS_catalogue_model->Delete_pos_item_cond($Company_id,$this->input->post('Company_merchandize_item_code'),15);
						if($_REQUEST['Optional_Condiment_Values'] != NULL)
						{
							
							foreach($_REQUEST['Optional_Condiment_Values'] as $Optional)
							{
								$val=explode("-",$Optional);
								$Post_data8=array(
								'Company_id'=>$Company_id,
								'Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Require_optional'=>15,
								'Condiment_item_code'=>$val[1],
								'Group_code'=>$val[0]
								);
								$Insert_pos_opt = $this->POS_catalogue_model->Insert_pos_condiments($Post_data8);
							}
							
						}
						
					}
					
						
						
				/****************************************Combo Item********************************/
				$Combo_meal_no=0;
				$Combo_meal_flag=0;
				if($_REQUEST['Item_type']==118)//Combo
				{
					$Combo_meal_no=$_REQUEST['Combo_meal_no'];
					// $Main_item_code=trim($_REQUEST['Main_item_code']);
					// $Main_Quantity=$_REQUEST['Main_Quantity'];
					// $Main_Price=$_REQUEST['Main_Price'];
					$Combo_meal_flag=1;
					$Main_Side_label=$_REQUEST['Main_Side_label'];
					$Company_merchandize_item_code=$_REQUEST['Company_merchandize_item_code'];
					
					$Update_main_side_label= $this->POS_catalogue_model->Update_main_side_label($Company_id,$Company_merchandize_item_code,$Main_Side_label);
					/**********INSERT Main Item ********************
					// $delete3 = $this->POS_catalogue_model->Delete_pos_item_combo_side($Company_id,$this->input->post('Company_merchandize_item_code'));
					
					 $delete4 = $this->POS_catalogue_model->Delete_pos_combo_child($Company_id,$this->input->post('Company_merchandize_item_code'));
						
					$Post_data9=array(
								'Company_id'=>$Company_id,
								'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Item_flag'=>'MAIN',
								'Main_or_side_item_code'=>$Main_item_code,
								'Quanity'=>$Main_Quantity,
								'Price'=>$Main_Price,
								);
					$Insert_pos_MAIN= $this->POS_catalogue_model->Insert_pos_main_item($Post_data9);
					/**********INSERT SIDE Item ********************/
					if($_REQUEST['Side_item_check'] != NULL)
					{
						
							$delete3 = $this->POS_catalogue_model->Delete_pos_combo_child($Company_id,$this->input->post('Company_merchandize_item_code'),'SIDE');
							foreach($_REQUEST['Side_item_check'] as $Side_No)
							{
								$Side_label=$_REQUEST["Side_label$Side_No"];
								$Main_or_side_item_code=$_REQUEST["Main_or_side_item_code$Side_No"];
								
								$Post_data10=array(
								'Company_id'=>$Company_id,
								'Menu_Item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Item_flag'=>'SIDE',
								'Main_or_side_item_code'=>$Main_or_side_item_code,
								'Side_label'=>$Side_label
								);
								$Insert_pos_SIDE= $this->POS_catalogue_model->Insert_pos_main_item($Post_data10);
							}
					}
				}						
				
				/****************************************Insert item catalogue********************************/	
				$Company_merchandise_item_id=$this->input->post('Company_merchandise_item_id');
				$Post_data=array(
				'Company_id'=>$Company_id,
				'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
				'Merchandize_item_type'=>$_REQUEST['Item_type'],
				'Cost_price'=>$Billing_price,
				'Billing_price'=>$Billing_price,
				'Valid_from'=>$Valid_from,
				'Valid_till'=>$Valid_till,
				'Merchandize_category_id'=>$this->input->post('Menu_group_id'),
				'Merchandize_item_name'=>$this->input->post('Merchandize_item_name'),
				'Merchandise_item_description'=>$this->input->post('Merchandise_item_description'),
				'Item_image1'=>$Item_image1,
				'Item_image2'=>$Item_image2,
				'Item_image3'=>$Item_image3,
				'Item_image4'=>$Item_image4,
				'Thumbnail_image1'=>$Thumbnail_image1,
				'Thumbnail_image2'=>$Thumbnail_image2,
				'Thumbnail_image3'=>$Thumbnail_image3,
				'Thumbnail_image4'=>$Thumbnail_image4,
				'Seller_id'=>$this->input->post('seller_id'),
				'Product_group_id'=>$this->input->post('Main_group_id'),
 				'Product_brand_id'=>$this->input->post('Sub_group_id'),
 				'Combo_meal_flag'=>$Combo_meal_flag,
 				'Combo_meal_number'=>$Combo_meal_no,
 				'Stamp_item_flag'=>$this->input->post('Stamp_item_flag'),
 				'Extra_earn_points'=>$this->input->post('Extra_earn_points'),
 				'Voucher_item_flag'=>$this->input->post('Voucher_item_flag'),
				'Update_user_id'=>$data['enroll'],
				'Update_date'=>date("Y-m-d H:i:s")
				);
				
				$result = $this->Catelogue_model->Update_Merchandize_Item($Company_merchandise_item_id,$Post_data);
			
				if($result == true)
				{
					//$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","POS Item  Updated Successfuly!!");
					
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
					$what="Update POS Catalogue Items";
					$where="Create POS Catalogue Items";
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
					$this->session->set_flashdata("error_code","POS Item Updated Error!!");
				}
				redirect("POS_CatalogueC/Create_POS_items");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function InActive_POS_Item()
	{
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$Update_date=date("Y-m-d H:i:s");
		
		$Company_merchandise_item_id=$_REQUEST["Company_merchandise_item_id"];
		 // $Active_flag=$_REQUEST["Active_flag"];
		 $Active_flag=0;
		
		$result = $this->POS_catalogue_model->InActive_Merchandize_Item($Company_merchandise_item_id,$Update_user_id,$Update_date,$Active_flag);
		if($result == true)
		{
			
				$this->session->set_flashdata("success_code","POS Item Deleted Successfuly!!");
			
			
		}
		else
		{
			$this->session->set_flashdata("success_code","Error Deleting POS Item!!");
		}
		redirect("POS_CatalogueC/Create_POS_items");
	}
	function Active_POS_Item()
	{
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$Update_date=date("Y-m-d H:i:s");
		
		$Company_merchandise_item_id=$_REQUEST["Company_merchandise_item_id"];
		 // $Active_flag=$_REQUEST["Active_flag"];
		 $Active_flag=1;
		
		$result = $this->POS_catalogue_model->InActive_Merchandize_Item($Company_merchandise_item_id,$Update_user_id,$Update_date,$Active_flag);
		if($result == true)
		{
			
				$this->session->set_flashdata("success_code","POS Item Activated Successfuly!!");
			
		}
		else
		{
			$this->session->set_flashdata("success_code","Error Deleting POS Item!!");
		}
		redirect("POS_CatalogueC/Create_POS_items");
	}
	public function autocomplete_pos_main_item_name()
	{
		
			$session_data = $this->session->userdata('logged_in');
			$data['Company_id'] = $session_data['Company_id'];
			
			if (isset($_GET['term']))
			{
				$keyword = strtolower($_GET['term']);
				$Company_id = $data['Company_id'];
				$this->POS_catalogue_model->get_pos_main_item_name($keyword,$Company_id);
			}
			
		
	}
	function Check_POS_Item()
	{
		$result = $this->POS_catalogue_model->Check_POS_Item($this->input->post("Company_merchandize_item_code"),$this->input->post("Company_id"),$this->input->post("Main_item_name"));
		
		if($result > 0)
		{
			$this->output->set_output(1);
		}
		else    
		{
			$this->output->set_output(0);
		}
	}
	public function Get_cond_group_values()
	{
		/* print_r($this->input->post("Group_code"));
		echo "<br>".count($this->input->post("Group_code"));
		die; */
		$Group_code=$this->input->post("Group_code");
		for($i=0 ; $i < count($Group_code) ;$i++)
		{
			//echo "<br>".$Group_code[$i];
		
			$Get_POS_group_values = $this->POS_catalogue_model->Get_cond_group_values($Group_code[$i],$this->input->post("Cond_type"),$this->input->post("Company_id"));
			foreach($Get_POS_group_values as $POS_group_val)
			{
				$Condiment_item_code[] = $POS_group_val->Group_code.'-'.$POS_group_val->Condiment_item_code;
				$Merchandize_item_name[] = $POS_group_val->Merchandize_item_name;
				
			}
		}
		
		//die;
		//$theHTMLResponse = $this->load->view('POS_Catalogue/Get_POS_group_values', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Condiment_item_code'=> $Condiment_item_code,'Merchandize_item_name'=> $Merchandize_item_name)));
	}
	public function Get_POS_sub_groups()
	{
		$data['Get_POS_sub_groups'] = $this->Catelogue_model->Get_Product_Brands($this->input->post("Main_group_id"),$this->input->post("Company_id"));
		
		$theHTMLResponse = $this->load->view('POS_Catalogue/Get_POS_sub_groups', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Product_groups'=> $theHTMLResponse)));
	}
	public function Delete_side_group_child()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Menu_Item_code=$this->input->post("Menu_Item_code");
		$Side_option=$this->input->post("Side_option");
								
		
		$delete = $this->POS_catalogue_model->Delete_side_group_child($data['Company_id'],$Menu_Item_code,$Side_option);
		
		
		$data['Get_pos_side_groups_items'] = $this->POS_catalogue_model->Get_pos_side_groups_items($data['Company_id'],$Menu_Item_code);
		$theHTMLResponse = $this->load->view('POS_Catalogue/Linked_side_group_items_child', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Linked_side_group_items'=> $theHTMLResponse)));
		
	}
	public function Save_Main_items()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Sub_item_code=$this->input->post("Sub_item_code");
		$Side_Quantity=$this->input->post("Side_Quantity");
		$Side_Price=$this->input->post("Side_Price");
		$Side_item_code=$this->input->post("Merchandize_category_id");
		$Menu_Item_code=$this->input->post("Company_merchandize_item_code");
		$Side_option=$this->input->post("Side_option");
		$Main_Side_label=$this->input->post("Main_Side_label");
		
			$Delete_MAIN_items = $this->POS_catalogue_model->Delete_main_item_combo_child($data['Company_id'],$Menu_Item_code);
			
			for($i=0; $i<count($Sub_item_code); $i++)
			{
				
				$Post_data=array('Company_id'=>$data['Company_id'],
				'Menu_Item_code'=>$Menu_Item_code,
				'Side_label'=>$Main_Side_label,
				'Item_flag'=>'MAIN',
				'Main_or_side_item_code'=>$Sub_item_code[$i],
				'Quanity'=>$Side_Quantity[$i],
				'Price'=>$Side_Price[$i]
				);
				if($Menu_Item_code != '' && $Side_Quantity[$i]!=0 && $Side_Quantity[$i]!="" )
				{
					$Insert_items = $this->POS_catalogue_model->Insert_pos_main_item_combo_child($Post_data);
				}
				
				// echo "<br><br>Sub_item_code::".$Sub_item_code[$i]." Side_Quantity::".$Side_Quantity[$i]." Side_Price::".$Side_Price[$i];
			}
			//die;
		
		$data['Get_pos_main_items'] = $this->POS_catalogue_model->Get_pos_main_item_combo_child($data['Company_id'],$Menu_Item_code);
		$theHTMLResponse = $this->load->view('POS_Catalogue/Linked_main_item_combo_child', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Linked_Main_items'=> $theHTMLResponse)));
	}
	public function Save_side_group_items()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Sub_item_code=$this->input->post("Sub_item_code");
		$Side_Quantity=$this->input->post("Side_Quantity");
		$Side_Price=$this->input->post("Side_Price");
		$Side_item_code=$this->input->post("Merchandize_category_id");
		$Menu_Item_code=$this->input->post("Company_merchandize_item_code");
		$Side_option=$this->input->post("Side_option");
			
			$Delete_items = $this->POS_catalogue_model->Delete_side_group_child($data['Company_id'],$Menu_Item_code,$Side_option);
			
			for($i=0; $i<count($Sub_item_code); $i++)
			{
				
				$Post_data=array('Company_id'=>$data['Company_id'],
				'Side_option'=>$Side_option,
				'Menu_Item_code'=>$Menu_Item_code,
				'Side_item_id'=>$Side_item_code,
				'Side_group_item_code'=>$Sub_item_code[$i],
				'Quanity'=>$Side_Quantity[$i],
				'Price'=>$Side_Price[$i]
				);
				if($Menu_Item_code != '' && $Side_Quantity[$i]!=0 && $Side_Quantity[$i]!="" )
				{
					$Insert_items = $this->POS_catalogue_model->Insert_pos_side_groups_items($Post_data);
				}
				
				// echo "<br><br>Sub_item_code::".$Sub_item_code[$i]." Side_Quantity::".$Side_Quantity[$i]." Side_Price::".$Side_Price[$i];
			}
			//die;
		
		$data['Get_pos_side_groups_items'] = $this->POS_catalogue_model->Get_pos_side_groups_items($data['Company_id'],$Menu_Item_code);
		$theHTMLResponse = $this->load->view('POS_Catalogue/Linked_side_group_items_child', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Linked_side_group_items'=> $theHTMLResponse,'Count_side_items'=> count($data['Get_pos_side_groups_items']))));
	}
	public function Get_side_groups_items()
	{
		$data['Company_merchandize_item_code']=$this->input->post("Company_merchandize_item_code");
		$data['Side_option']=$this->input->post("Side_option");
		$data['Company_id']=$this->input->post("Company_id");
		$data['Main_Side_label']=$this->input->post("Main_Side_label");
		
		$data['Get_Link_Side_Group_Items'] = $this->POS_catalogue_model->Get_Link_Side_Group_Items($this->input->post("Item"),$this->input->post("Company_id"));
		
		
		
		$theHTMLResponse = $this->load->view('POS_Catalogue/Get_Link_Side_Group_Items', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Side_Group_Items'=> $theHTMLResponse)));
	}
	public function Get_Partner_Branches()
	{
		$data['Get_Partner_Branches'] = $this->Catelogue_model->Get_Partner_Branches($this->input->post("Partner_id"),$this->input->post("Company_id"));
		$lv_Partner_id=$_REQUEST["Partner_id"];
		$data["Partner_Row"] = $this->Catelogue_model->Get_Company_Partners_details($lv_Partner_id);
		$VAT=$data["Partner_Row"]->Partner_vat;
		$margin=$data["Partner_Row"]->Partner_markup_percentage;
		 //var_dump($data);die;
		$theHTMLResponse = $this->load->view('Catalogue/Get_Partner_branches', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Get_Partner_Branches2'=> $theHTMLResponse,'VAT'=> $VAT,'margin'=> $margin)));
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
			$this->session->set_flashdata("success_code","POS Item Deleted Successfuly!!");
			
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
				$what="Inactive POS Items";
				$where="Create POS Items";
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
		redirect("POS_CatalogueC/Create_POS_items");
	}
	public function Get_POS_items()
	{
		
		$search_flag=$this->input->post("search_flag");
		$Menu_group_id=$this->input->post("Menu_group_id");
		$Company_id=$this->input->post("Company_id");
		
		
		if($search_flag==3)//Category
		{
			$data['POS_Items_Records'] = $this->POS_catalogue_model->Get_Category_linked_POS_Items($Menu_group_id);
		}
		if($search_flag==4)//By Item code and name
		{
			$data['POS_Items_Records'] = $this->POS_catalogue_model->Get_Searched_POS_Items($Menu_group_id,$Company_id);
		}
		$theHTMLResponse = $this->load->view('POS_Catalogue/Get_Search_POS_items', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('records'=> $theHTMLResponse)));
	}
	/*****************************Create Merchandise Items End*************************************/
	//*********** sandeep 13-03-2020 ********************
	public function get_seller_main_groups()
	{
		$seller_id = $this->input->post('seller_id');
		$Company_id = $this->input->post('Company_id');
		
		if($seller_id > 0)
		{
			$data['MainGrpArray'] = $this->POS_catalogue_model->get_seller_linked_main_groups($seller_id,$Company_id);
		
			$opText = $this->load->view("POS_Catalogue/get_seller_main_groups",$data, true);
		}
		
		//echo $opText;
		if($opText != null)
		{
			$this->output->set_content_type('text/html');
			$this->output->set_output($opText);
		}
	}
	
	
	public function get_seller_menu_groups()
	{
		$seller_id = $this->input->post('seller_id');
		$Company_id = $this->input->post('Company_id');
		
		if($seller_id > 0)
		{
			$data['MenuGrpArray'] = $this->POS_catalogue_model->get_seller_linked_menu_groups($seller_id,$Company_id);
		
			$opText = $this->load->view("POS_Catalogue/get_seller_menu_groups",$data, true);
		}
		
		//echo $opText;
		if($opText != null)
		{
			$this->output->set_content_type('text/html');
			$this->output->set_output($opText);
		}
	}
	//*********** sandeep 13-03-2020 ********************
}	
	?>
