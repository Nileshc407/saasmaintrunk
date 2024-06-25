<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coal_CatalogueC extends CI_Controller
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
		$this->load->model('Coal_catalogue/Coal_Catelogue_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->library('image_lib');
		$this->load->model('master/currency_model');
		
	}
	
/***************************Create Merchandise Items Start*************************************/
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
			
			/************Get codedecode master*****amit 13-09-2017************/
			$data["Code_decode_Records"] = $this->Igain_model->Get_Code_decode_master($Company_id);
			/***************************/
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);	
			$Code_decode_type_id=9; // Item Category
			$data["Item_Category_type"] = $this->Coal_Catelogue_model->Get_Merchandise_items_type($Code_decode_type_id);
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			
			/***********GET Seller Currency******************************/
			$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
			$Symbol_currency = $currency_details->Symbol_of_currency;
			$data['Symbol_currency'] = $Symbol_currency;
			/***********************************/
			/***********New Added 21-09-2016 amit******************/
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			if( $data['Super_seller']==1)
			{
				$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
			}
			else
			{
				$data["Subseller_details"] =$this->Igain_model->get_seller_details_12($data['enroll']);
			}
			/*******************/
			/*----------------------Active-Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_CatalogueC/Create_Merchandize_Items";
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
			$config2["base_url"] = base_url() . "/index.php/Coal_CatalogueC/Create_Merchandize_Items";
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
			$data["Merchandize_Items_Records"] = $this->Coal_Catelogue_model->Get_Merchandize_Items($config["per_page"], $page,$Company_id,1,$data['Super_seller'],$data['enroll']);
			
			
			$data["InActive_Merchandize_Items_Records"] = $this->Coal_Catelogue_model->Get_Merchandize_Items($config2["per_page"], $page2,$Company_id,0,$data['Super_seller'],$data['enroll']);
			if($_POST == NULL)
			{
				$this->load->view('Coal_catalogue/Coal_Create_Merchandize_ItemsV', $data);
				
			} 
			else
			{	
		
				$Merchant_flag=$this->input->post('Merchant_flag');		
				if($Merchant_flag==1)
				{
					$Seller_id=$this->input->post('Seller_id');
					$seller_details = $this->Igain_model->get_enrollment_details($Seller_id);
					$Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;
				}
				else
				{
					$Seller_Redemptionratio = $data["Company_details"]->Redemptionratio;
				}
				
				
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
					$upload28 = $this->upload->do_upload('file1');
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
				
			
				
					/*-----------------------Image1-----------------------------*/
						/* if ( !$this->upload->do_upload("file1") )
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
							
							/****************600 x 600*************
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
							
							/****************225 x 225*************
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
							/****************225 x 225*************
						} */
					/*-----------------------Image1-----------------------------*/
					
					/*-----------------------Image2-----------------------------
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
							
							/****************600 x 600************
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
							/****************600 x 600************
							
							/****************225 x 225************
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
							/****************225 x 225*************
						}
					/*-----------------------Image2-----------------------------
					
					/*-----------------------Image3-----------------------------
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
							
							/****************600 x 600*************
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
							/****************600 x 600*************
							
							/****************225 x 225*************
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
							/****************225 x 225*************
						}
					/*-----------------------Image3-----------------------------*/
					
					/*-----------------------Image4-----------------------------
					
					
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
							
							/****************600 x 600************
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
							
							/****************225 x 225*************
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
							/****************225 x 225*************
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
					$Tier_id=$this->input->post('Tier_id');
						
						/*****************************Insert Partner Branches*****************************/
						//print_r($partner_branches);
						foreach($Tier_id as $Tier_id)
						{
						
							//echo "<br> partner_branches2 ".$partner_branches2;
							if($Tier_id=='0')//All Branches
							{
								$Company_tiers_Records = $this->Igain_model->get_tier($this->input->post('Company_id'));
								
								foreach($Company_tiers_Records as $rec)
								{
									$Post_data2=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
									'Tier_id'=>$rec["Tier_id"]);
									$result_tier = $this->Coal_Catelogue_model->Insert_Merchandize_Item_tiers($Post_data2);
								}
							}
							else
							{
								//echo "<br> Branch_code ".$partner_branches2;
								$Post_data2=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
									'Tier_id'=>$Tier_id);
								$result_tier = $this->Coal_Catelogue_model->Insert_Merchandize_Item_tiers($Post_data2);
							}	
							
						}
						/*******AMIT 13-09-2017********************/	
					$Gender_flag=$this->input->post('Gender_flag');
					$Colour_flag=$this->input->post('Colour_flag');
					$Brand_flag=$this->input->post('Brand_flag');
					$Dimension_flag=$this->input->post('Dimension_flag');
					$Weight_flag=$this->input->post('Weight_flag');
					$Manufacturer_flag=$this->input->post('Manufacturer_flag');
					
					$Size_flag=$this->input->post('Size_flag');
					$Item_Colour='';
					$Item_Brand='';
					$Item_Dimension='';
					$Item_Weight='';
					$Weight_unit='';
					$Item_Manufacturer='';
					$Seller_id=0;
					if($Colour_flag==1)
					{
						$Item_Colour=$this->input->post('Item_Colour');
					}
					if($Brand_flag==1)
					{
						$Item_Brand=$this->input->post('Item_Brand');
					}
					if($Weight_flag==1)
					{
						if($Size_flag==0)
						{
							$Weight_unit=$this->input->post('Weight_unit');
							$Weight=$this->input->post('Weight');
							$Item_Weight=$Weight;	
						}
						
					}
					if($Dimension_flag==1)
					{
						if($Size_flag==0)
						{
							$Dimension_unit=$this->input->post('Dimension_unit');
							$Length=$this->input->post('Length');
							$Width=$this->input->post('Width');
							$Height=$this->input->post('Height');
							$Item_Dimension='('.$Length.' X '.$Width.' X '.$Height.') '.$Dimension_unit;
						}
						
					}
					if($Manufacturer_flag==1)
					{
						$Item_Manufacturer=$this->input->post('Item_Manufacturer');
					}
					if($Merchant_flag==1)
					{
						$Seller_id=$this->input->post('Seller_id');
					}
					
					/*******AMIT 13-09-2017******END**************/	
						$Partner_Row = $this->Catelogue_model->Get_Company_Partners_details($this->input->post('Partner_id'));
						$VAT=$Partner_Row->Partner_vat;
						$margin=$Partner_Row->Partner_markup_percentage;
						/**************14-10-2016 Alkwar size change*************/
						$Size_flag=$this->input->post('Size_flag');
						if($Size_flag==1)
						{
							
							if($this->input->post('small_Cost_price') != NULL || $this->input->post('small_Cost_price') != 0) {
								
								$small_Cost_price=$this->input->post('small_Cost_price');
								$small_Cost_payable_to_partner=($small_Cost_price*$VAT/100)+$small_Cost_price;
								$small_Billing_price=(($small_Cost_payable_to_partner*$margin)/100)+$small_Cost_payable_to_partner;
								$small_Points=($small_Billing_price*$Seller_Redemptionratio);
							} else {
								
								$small_Cost_price=0;
								$small_Cost_payable_to_partner=0;
								$small_Billing_price=0;
								$small_Points=0;
							}
							
							
							if($this->input->post('medium_Cost_price') != NULL || $this->input->post('medium_Cost_price') != 0) {
							
								$medium_Cost_price=$this->input->post('medium_Cost_price');
								$medium_Cost_payable_to_partner=($medium_Cost_price*$VAT/100)+$medium_Cost_price;
								$medium_Billing_price=(($medium_Cost_payable_to_partner*$margin)/100)+$medium_Cost_payable_to_partner;;
								$medium_Points=($medium_Billing_price*$Seller_Redemptionratio);
							} else {
							
								$medium_Cost_price=0;
								$medium_Cost_payable_to_partner=0;
								$medium_Billing_price=0;
								$medium_Points=0;
							}
							
							if($this->input->post('large_Cost_price') != NULL || $this->input->post('large_Cost_price') != 0) {
								
								$large_Cost_price=$this->input->post('large_Cost_price');
								$large_Cost_payable_to_partner=($large_Cost_price*$VAT/100)+$large_Cost_price;
								$large_Billing_price=(($large_Cost_payable_to_partner*$margin)/100)+$large_Cost_payable_to_partner;;
								$large_Points=($large_Billing_price*$Seller_Redemptionratio);
							} else {	
								$large_Cost_price=0;
								$large_Cost_payable_to_partner=0;
								$large_Billing_price=0;
								$large_Points=0;
							}
							
							if($this->input->post('elarge_Cost_price') != NULL || $this->input->post('elarge_Cost_price') != 0) {
								
								$elarge_Cost_price=$this->input->post('elarge_Cost_price');
								$elarge_Cost_payable_to_partner=($elarge_Cost_price*$VAT/100)+$elarge_Cost_price;
								$elarge_Billing_price=(($elarge_Cost_payable_to_partner*$margin)/100)+$elarge_Cost_payable_to_partner;;
								$elarge_Points=($elarge_Billing_price*$Seller_Redemptionratio);
								
							} else {
								
								$elarge_Cost_price=0;
								$elarge_Cost_payable_to_partner=0;
								$elarge_Billing_price=0;
								$elarge_Points=0;
							}
							$Cost_price=0;
							$Billing_price=0;
							$Points=0;
							$Cost_payable_to_partner=0;
							
							/***************Insert into Merchandise_Size child table************/
							if($small_Cost_price!="" && $small_Billing_price!="" && $small_Points!="")
							{
								$Small_Item_Weight='0';
								$Small_Item_Dimension='0';
								$Small_Weight_unit='0';
								if($Weight_flag==1)
								{
									$Small_Weight_unit=$this->input->post('Small_Weight_unit');
									$Small_Weight=$this->input->post('Small_Weight');
									$Small_Item_Weight=$Small_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Small_Dimension_unit=$this->input->post('Small_Dimension_unit');
									$Small_Length=$this->input->post('Small_Length');
									$Small_Width=$this->input->post('Small_Width');
									$Small_Height=$this->input->post('Small_Height');
									$Small_Item_Dimension='('.$Small_Length.' X '.$Small_Width.' X '.$Small_Height.') '.$Small_Dimension_unit;
								}
								
								
								$Post_data_size=array(
								'Item_size'=>1,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Cost_price'=>$small_Cost_price,
								'Billing_price'=>$small_Billing_price,
								'Cost_payable_to_partner'=>$small_Cost_payable_to_partner,
								'Item_weight'=>$Small_Item_Weight,
								'Weight_unit_id'=>$Small_Weight_unit,
								'Item_Dimension'=>$Small_Item_Dimension,
								'Billing_price_in_points'=>$small_Points);
								$resultsize = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size);
							}
							
							if($medium_Cost_price!="" && $medium_Billing_price!="" && $medium_Points!="")
							{
								$Medium_Item_Weight='0';
								$Medium_Item_Dimension='0';
								$Medium_Weight_unit='0';
								if($Weight_flag==1)
								{
									$Medium_Weight_unit=$this->input->post('Medium_Weight_unit');
									$Medium_Weight=$this->input->post('Medium_Weight');
									$Medium_Item_Weight=$Medium_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Medium_Dimension_unit=$this->input->post('Medium_Dimension_unit');
									$Medium_Length=$this->input->post('Medium_Length');
									$Medium_Width=$this->input->post('Medium_Width');
									$Medium_Height=$this->input->post('Medium_Height');
									$Medium_Item_Dimension='('.$Medium_Length.' X '.$Medium_Width.' X '.$Medium_Height.') '.$Medium_Dimension_unit;
								}
								
								$Post_data_size2=array(
								'Item_size'=>2,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Cost_price'=>$medium_Cost_price,
								'Billing_price'=>$medium_Billing_price,
								'Cost_payable_to_partner'=>$medium_Cost_payable_to_partner,
								'Item_weight'=>$Medium_Item_Weight,
								'Weight_unit_id'=>$Medium_Weight_unit,
								'Item_Dimension'=>$Medium_Item_Dimension,
								'Billing_price_in_points'=>$medium_Points);
								$resultsize2 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size2);
							}
							
							if($large_Cost_price!="" && $large_Billing_price!="" && $large_Points!="")
							{
								$Large_Item_Weight='0';
								$Large_Item_Dimension='0';
								$Large_Weight_unit='0';
								if($Weight_flag==1)
								{
									$Large_Weight_unit=$this->input->post('Large_Weight_unit');
									$Large_Weight=$this->input->post('Large_Weight');
									$Large_Item_Weight=$Large_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Large_Dimension_unit=$this->input->post('Large_Dimension_unit');
									$Large_Length=$this->input->post('Large_Length');
									$Large_Width=$this->input->post('Large_Width');
									$Large_Height=$this->input->post('Large_Height');
									$Large_Item_Dimension='('.$Large_Length.' X '.$Large_Width.' X '.$Large_Height.') '.$Large_Dimension_unit;
								}
								
								$Post_data_size3=array(
								'Item_size'=>3,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Cost_price'=>$large_Cost_price,
								'Billing_price'=>$large_Billing_price,
								'Cost_payable_to_partner'=>$large_Cost_payable_to_partner,
								'Item_weight'=>$Large_Item_Weight,
								'Weight_unit_id'=>$Large_Weight_unit,
								'Item_Dimension'=>$Large_Item_Dimension,
								'Billing_price_in_points'=>$large_Points);
								$resultsize3 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size3);
							}
							
							if($elarge_Cost_price!="" && $elarge_Billing_price!="" && $elarge_Points!="")
							{
								$eLarge_Item_Weight='0';
								$eLarge_Item_Dimension='0';
								$eLarge_Weight_unit='0';
								if($Weight_flag==1)
								{
									$eLarge_Weight_unit=$this->input->post('eLarge_Weight_unit');
									$eLarge_Weight=$this->input->post('eLarge_Weight');
									$eLarge_Item_Weight=$eLarge_Weight;	
								}
								if($Dimension_flag==1)
								{
									$eLarge_Dimension_unit=$this->input->post('eLarge_Dimension_unit');
									$eLarge_Length=$this->input->post('eLarge_Length');
									$eLarge_Width=$this->input->post('eLarge_Width');
									$eLarge_Height=$this->input->post('eLarge_Height');
									$eLarge_Item_Dimension='('.$eLarge_Length.' X '.$eLarge_Width.' X '.$eLarge_Height.') '.$eLarge_Dimension_unit;
								}
								
								$Post_data_size4=array(
								'Item_size'=>4,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
								'Cost_price'=>$elarge_Cost_price,
								'Billing_price'=>$elarge_Billing_price,
								'Cost_payable_to_partner'=>$elarge_Cost_payable_to_partner,
								'Item_weight'=>$eLarge_Item_Weight,
								'Weight_unit_id'=>$eLarge_Weight_unit,
								'Item_Dimension'=>$eLarge_Item_Dimension,
								'Billing_price_in_points'=>$elarge_Points);
								$resultsize4 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size4);
							}
							
						
							/***************amit 25-09-2017**********/
							if($small_Points!="")
							{
								$Points=$small_Points;
								$Cost_price=$small_Cost_price;
								$Cost_payable_to_partner=$small_Cost_payable_to_partner;
								$Billing_price=$small_Billing_price;
								$Item_Dimension=$Small_Item_Dimension;
								$Item_Weight=$Small_Item_Weight;
								$Weight_unit=$Small_Weight_unit;
							}
							elseif($medium_Points!="")
							{
								$Points=$medium_Points;
								$Cost_price=$medium_Cost_price;
								$Cost_payable_to_partner=$medium_Cost_payable_to_partner;
								$Billing_price=$medium_Billing_price;
								$Item_Dimension=$Medium_Item_Dimension;
								$Item_Weight=$Medium_Item_Weight;
								$Weight_unit=$Medium_Weight_unit;
							}
							elseif($large_Points!="")
							{
								$Points=$large_Points;
								$Cost_price=$large_Cost_price;
								$Cost_payable_to_partner=$large_Cost_payable_to_partner;
								$Billing_price=$large_Billing_price;
								$Item_Dimension=$Large_Item_Dimension;
								$Item_Weight=$Large_Item_Weight;
								$Weight_unit=$Large_Weight_unit;
							}
							else
							{
								$Points=$elarge_Points;
								$Cost_price=$elarge_Cost_price;
								$Cost_payable_to_partner=$elarge_Cost_payable_to_partner;
								$Billing_price=$elarge_Billing_price;
								$Item_Dimension=$eLarge_Item_Dimension;
								$Item_Weight=$eLarge_Item_Weight;
								$Weight_unit=$eLarge_Weight_unit;
							}
							
							/***************amit 25-09-2017**********/
						}
						else
						{
							$Cost_price=$this->input->post('Cost_price');
							$Cost_payable_to_partner=($Cost_price*$VAT/100)+$Cost_price;
							$Billing_price=(($Cost_payable_to_partner*$margin)/100)+$Cost_payable_to_partner;;
							$Points=($Billing_price*$Seller_Redemptionratio);
							
						}
						/***********************************************************/
					$Size_Chart=$this->input->post('Size_Chart');
					$Size_chart_image ='';
					if($Size_Chart==1)
					{
						$Size_chart_image=$this->input->post('Size_chart_image');
						if($Size_chart_image==1)//Upload Your Size Chart
						{
							/* if ($this->upload->do_upload("Size_Chart_upload_img") )
							{
								$chart_img = array('upload_chart_img' => $this->upload->data("Size_Chart_upload_img"));
							
								$config17 = array
								(
									'source_image'      => $chart_img['upload_chart_img']['full_path'], //path to the uploaded image
									'new_image'         => 'Size_chart_images/'.$chart_img['upload_chart_img']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config17);
								$this->image_lib->resize();
								
								$Size_chart_image = base_url().$config17['new_image'];
							} */	
							$config77 = array
								(
									'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
									'max_size'          => 2048, //2MB max
									'max_width'          => 3000, //2MB max
									'max_height'          => 3000, //2MB max
									'encrypt_name'    => true,
									'upload_path'       => './Size_chart_images/' //upload directory
								);
								
								$this->load->library('upload', $config77);
								$this->upload->initialize($config77);
								
								$configThumb = array();
								$configThumb['image_library'] = 'gd2';
								$configThumb['source_image'] = '';
								$configThumb['create_thumb'] = TRUE;
								$configThumb['maintain_ratio'] = TRUE;			
								$configThumb['width'] = 128;
								$configThumb['height'] = 128;
								/* Load the image library */
								$this->load->library('image_lib');						
								$upload77 = $this->upload->do_upload('Size_Chart_upload_img');
								$data77 = $this->upload->data();			   
								if($data77['is_image'] == 1) 
								{						 
									$configThumb['source_image'] = $data77['full_path'];
									$configThumb['source_image'] = './Size_chart_images/'.$upload77;
									$this->image_lib->initialize($configThumb);
									$this->image_lib->resize();
									$Size_chart_image=base_url().'Size_chart_images/'.$data77['file_name'];
								}
								else
								{							
									
									$Size_chart_image =$old_Size_chart_image;								
									
								}
								
						}
						else
						{
							$Size_chart_image = base_url().'Size_chart_images/'.$Size_chart_image.'.png';
						}
					}
					
					$LV_Link_to_Member_Enrollment_flag=$this->input->post('Link_to_Member_Enrollment_flag');
					$Send_once_year=$this->input->post('Send_once_year');
					$Send_other_benefits=$this->input->post('Send_other_benefits');
					if($LV_Link_to_Member_Enrollment_flag==0) // || $LV_Link_to_Member_Enrollment_flag==NULL)
					{
						$LV_Link_to_Member_Enrollment_flag=0;
						$Send_once_year=0;
						$Send_other_benefits=0;
					} else {
						$LV_Link_to_Member_Enrollment_flag=$this->input->post('Link_to_Member_Enrollment_flag');
						$Send_once_year=$this->input->post('Send_once_year');
						$Send_other_benefits=$this->input->post('Send_other_benefits');
					}		
							/****************600 x 600*************/
				

				/*****Quantity Description*********************************************/
				$Quantity_flag=$this->input->post('Quantity_flag');
				if($Quantity_flag==1)
				{
					$Stock_quantity=$this->input->post('Stock_quantity');
					
					$Slab1_Quantity=$this->input->post('Slab1_Quantity');
					$Slab1_Offer=$this->input->post('Slab1_Offer');
					
					$Slab2_Quantity=$this->input->post('Slab2_Quantity');
					$Slab2_Offer=$this->input->post('Slab2_Offer');
					
					$Slab3_Quantity=$this->input->post('Slab3_Quantity');
					$Slab3_Offer=$this->input->post('Slab3_Offer');
					
					$Slab4_Quantity=$this->input->post('Slab4_Quantity');
					$Slab4_Offer=$this->input->post('Slab4_Offer');
					
					$Slab5_Quantity=$this->input->post('Slab5_Quantity');
					$Slab5_Offer=$this->input->post('Slab5_Offer');
					
					if($Slab1_Quantity!="")
					{
						
						$Post_data_qty1=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>1,
						'Item_quantity'=>$Slab1_Quantity,
						'Offer'=>$Slab1_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize1 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty1);
					}
					if($Slab2_Quantity!="")
					{
						
						$Post_data_qty2=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>2,
						'Item_quantity'=>$Slab2_Quantity,
						'Offer'=>$Slab2_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize2 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty2);
					}
					if($Slab3_Quantity!="")
					{
						
						$Post_data_qty3=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>3,
						'Item_quantity'=>$Slab3_Quantity,
						'Offer'=>$Slab3_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize3 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty3);
					}
					if($Slab4_Quantity!="")
					{
						
						$Post_data_qty4=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>4,
						'Item_quantity'=>$Slab4_Quantity,
						'Offer'=>$Slab4_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize4 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty4);
					}
					if($Slab5_Quantity!="")
					{
						
						$Post_data_qty5=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>5,
						'Item_quantity'=>$Slab5_Quantity,
						'Offer'=>$Slab5_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize5 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty5);
					}
					
				}
				else
				{
					$Stock_quantity=0;
				}
				/*****Quantity Description*********XXX************************************/
					$Product_group_id=$this->input->post('Product_group_id');	
					if($Product_group_id!=NULL)
					{
						$Product_group_id=$Product_group_id;
					}
					else{
						$Product_group_id=0;
					}
					$Product_brand_id=$this->input->post('Product_brand_id');	
					if($Product_brand_id!=NULL)
					{
						$Product_brand_id=$Product_brand_id;
					}
					else{
						$Product_brand_id=0;
					} 
					$Post_data=array(
					'Company_id'=>$this->input->post('Company_id'),
					'Company_merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
					'Partner_id'=>$this->input->post('Partner_id'),
					'Cost_price'=>$Cost_price,
					'Valid_from'=>$Valid_from,
					'Valid_till'=>$Valid_till,
					'Markup_percentage'=>$margin,
					'Delivery_method'=>$this->input->post('Delivery_method'),
					'Merchandize_category_id'=>$this->input->post('Merchandize_category_id'),
					'Merchandize_item_type'=>$this->input->post('Merchandize_item_type'),
					'Merchandize_item_name'=>$this->input->post('Merchandize_item_name'),
					'Merchandise_item_description'=>$this->input->post('Merchandise_item_description'),
					'Seller_Redemptionratio'=>$Seller_Redemptionratio,
					'Cost_payable_to_partner'=>$Cost_payable_to_partner,
					'Billing_price'=>$Billing_price,
					'VAT'=>$VAT,
					// 'Item_image'=>$Item_logo,
					'Item_image1'=>$Item_image1,
					'Item_image2'=>$Item_image2,
					'Item_image3'=>$Item_image3,
					'Item_image4'=>$Item_image4,
					'Thumbnail_image1'=>$Thumbnail_image1,
					'Thumbnail_image2'=>$Thumbnail_image2,
					'Thumbnail_image3'=>$Thumbnail_image3,
					'Thumbnail_image4'=>$Thumbnail_image4,
					'Billing_price_in_points'=>$Points,
					'show_item'=>$this->input->post('show_item'),
					'Ecommerce_flag'=>$this->input->post('Ecommerce_flag'),
					'Offer_flag'=>$this->input->post('Offer_flag'),
					'Product_group_id'=>$Product_group_id,
					'Product_brand_id'=>$Product_brand_id,
					'Create_user_id'=>$data['enroll'],
					'Creation_date'=>$this->input->post('Create_date'),
					'Tier_id'=>0,
					'Seller_id'=>$Seller_id,
					'Size_flag'=>$this->input->post('Size_flag'),
					'Merchant_flag'=>$Merchant_flag,
					'Gender_flag'=>$Gender_flag,
					'Colour_flag'=>$Colour_flag,
					'Brand_flag'=>$Brand_flag,
					'Dimension_flag'=>$Dimension_flag,
					'Weight_flag'=>$Weight_flag,
					'Manufacturer_flag'=>$Manufacturer_flag,
					'Item_Colour'=>$Item_Colour,
					'Item_Brand'=>$Item_Brand,
					'Item_Dimension'=>$Item_Dimension,
					'Item_Weight'=>$Item_Weight,
					'Weight_unit_id'=>$Weight_unit,
					'Item_Manufacturer'=>$Item_Manufacturer,
					'Item_Manufacturer'=>$Item_Manufacturer,
					'Size_Chart'=>$Size_Chart,
					'Size_chart_image'=>$Size_chart_image,
					'Send_once_year'=>$Send_once_year,
					'Send_other_benefits'=>$Send_other_benefits,
					'Link_to_Member_Enrollment_flag'=>$LV_Link_to_Member_Enrollment_flag,
					'Quantity_flag'=>$Quantity_flag,
					'Stock_quantity'=>$Stock_quantity,
					'Remaining_quantity'=>$Stock_quantity,
					'Active_flag'=>1);
					
					$result = $this->Catelogue_model->Insert_Merchandize_Item($Post_data);
				
			
				if($result == true)
				{
					$this->session->set_flashdata("data_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Item  Created Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Item  Error!!");
				}
			
				redirect("Coal_CatalogueC/Create_Merchandize_Items");
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
			/************Get codedecode master*****amit 13-09-2017************/
			$data["Code_decode_Records"] = $this->Igain_model->Get_Code_decode_master($Company_id);
			/***************************/
			$data["Merchandize_Category_Records"] = $this->Catelogue_model->Get_Merchandize_Category('', '',$Company_id);
			$data["Partner_Records"] = $this->Catelogue_model->Get_Company_Partners('', '',$Company_id);
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			/***********New Added 21-09-2016 amit******************/
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			if( $data['Super_seller']==1)
			{
				$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
			}
			else
			{
				$data["Subseller_details"] =$this->Igain_model->get_seller_details_12($data['enroll']);
			}
			/*******************/
			
			/***********GET Seller Currency******************************/
			$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
			$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
			$Symbol_currency = $currency_details->Symbol_of_currency;
			$data['Symbol_currency'] = $Symbol_currency;	
			/***********************************/
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_CatalogueC/Create_Merchandize_Items";
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
			$data["Merchandize_Items_Records"] = $this->Coal_Catelogue_model->Get_Merchandize_Items($config["per_page"], $page,$Company_id,1,$data['Super_seller'],$data['enroll']);
			
			$lv_Company_merchandise_item_id=$_REQUEST["Company_merchandise_item_id"];
			$data["Merchandize_Item_Row"] = $this->Coal_Catelogue_model->Get_Merchandize_Item_details($lv_Company_merchandise_item_id);	
			$Company_merchandize_item_code=$data["Merchandize_Item_Row"]->Company_merchandize_item_code;
			$lv_Product_group_id=$data["Merchandize_Item_Row"]->Product_group_id;
			$lv_Size_flag=$data["Merchandize_Item_Row"]->Size_flag;
			$data["Item_Dimension"] =$data["Merchandize_Item_Row"]->Item_Dimension;
			$data["Item_Weight"] =$data["Merchandize_Item_Row"]->Item_Weight;
			//echo "Size_flag ".$Size_flag;
			/***********Set Default 0**************/
			$data["small_Cost_price"] ="";
			$data["small_Billing_price"] ="";
			$data["small_Points"] ="";
			$data["small_Item_weight"] ="";
			$data["small_Weight_unit_id"] ="";
			$data["small_Item_Dimension"] ="";
			$data["small_Cost_payable_to_partner"] ="";
			
			$data["medium_Cost_price"] ="";
			$data["medium_Billing_price"] ="";
			$data["medium_Points"] ="";
			$data["medium_Item_weight"] ="";
			$data["medium_Weight_unit_id"] ="";
			$data["medium_Item_Dimension"] ="";
			$data["medium_Cost_payable_to_partner"] ="";
			
			$data["large_Cost_price"] ="";
			$data["large_Billing_price"] ="";
			$data["large_Points"] ="";
			$data["large_Item_weight"] ="";
			$data["large_Weight_unit_id"] ="";
			$data["large_Item_Dimension"] ="";
			$data["large_Cost_payable_to_partner"] ="";
			
			$data["elarge_Cost_price"] ='';
			$data["elarge_Billing_price"] ='';
			$data["elarge_Points"] ='';
			$data["elarge_Item_weight"] ='';
			$data["elarge_Weight_unit_id"] ='';
			$data["elarge_Item_Dimension"] ='';
			$data["elarge_Cost_payable_to_partner"] ='';
			/*************************/
			if($lv_Size_flag==1)
			{
				$Get_item_size_info = $this->Coal_Catelogue_model->Get_Merchandize_Item_Size_info($Company_merchandize_item_code,$Company_id);
				foreach($Get_item_size_info as $Rec)
				{
					// echo "<br>Cost_price ".$Rec->Cost_price;
					$Item_size =$Rec->Item_size;
					if($Item_size==1)//Small
					{
						$data["small_Cost_price"] =$Rec->Cost_price;
						$data["small_Billing_price"] =$Rec->Billing_price;
						$data["small_Points"] =$Rec->Billing_price_in_points;
						$data["small_Item_weight"] =$Rec->Item_weight;
						$data["small_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["small_Item_Dimension"] =$Rec->Item_Dimension;
						$data["small_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					if($Item_size==2)//Medium
					{
						$data["medium_Cost_price"] =$Rec->Cost_price;
						$data["medium_Billing_price"] =$Rec->Billing_price;
						$data["medium_Points"] =$Rec->Billing_price_in_points;
						$data["medium_Item_weight"] =$Rec->Item_weight;
						$data["medium_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["medium_Item_Dimension"] =$Rec->Item_Dimension;
						$data["medium_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					if($Item_size==3)//Large
					{
						$data["large_Cost_price"] =$Rec->Cost_price;
						$data["large_Billing_price"] =$Rec->Billing_price;
						$data["large_Points"] =$Rec->Billing_price_in_points;
						$data["large_Item_weight"] =$Rec->Item_weight;
						$data["large_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["large_Item_Dimension"] =$Rec->Item_Dimension;
						$data["large_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					if($Item_size==4)//Extra Large
					{
						$data["elarge_Cost_price"] =$Rec->Cost_price;
						$data["elarge_Billing_price"] =$Rec->Billing_price;
						$data["elarge_Points"] =$Rec->Billing_price_in_points;
						$data["elarge_Item_weight"] =$Rec->Item_weight;
						$data["elarge_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["elarge_Item_Dimension"] =$Rec->Item_Dimension;
						$data["elarge_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					
				}
			}
			$data["Merchandize_Item_Branches"] = $this->Catelogue_model->Get_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);	
			
			$data["Merchandize_Item_Tiers"] = $this->Coal_Catelogue_model->Get_Merchandize_Item_Tiers($Company_merchandize_item_code,$Company_id);
			
			$data['Get_Product_Brands'] = $this->Catelogue_model->Get_Product_Brands($lv_Product_group_id,$Company_id);
			
			/*************AMIT 11-01-2018 GET Quantity CHILD******************/
			$data['Slab1_Quantity']='';
			$data['Slab1_Offer']='';
			$data['Slab2_Quantity']='';
			$data['Slab2_Offer']='';
			$data['Slab3_Quantity']='';
			$data['Slab3_Offer']='';
			$data['Slab4_Quantity']='';
			$data['Slab4_Offer']='';
			$data['Slab5_Quantity']='';
			$data['Slab5_Offer']='';
						
			$Get_Quantity_child = $this->Coal_Catelogue_model->Get_Quantity_child_details($Company_merchandize_item_code,$Company_id);
			// print_r($data['Get_Quantity_child']);
			if($Get_Quantity_child !=NULL)
			{
				foreach($Get_Quantity_child as $records)
				{
					$Slab_no=$records->Slab_no;
					if($Slab_no==1)
					{
						$data['Slab1_Quantity']=$records->Item_quantity;
						$data['Slab1_Offer']=$records->Offer;
					}
					if($Slab_no==2)
					{
						$data['Slab2_Quantity']=$records->Item_quantity;
						$data['Slab2_Offer']=$records->Offer;
					}
					if($Slab_no==3)
					{
						$data['Slab3_Quantity']=$records->Item_quantity;
						$data['Slab3_Offer']=$records->Offer;
					}
					if($Slab_no==4)
					{
						$data['Slab4_Quantity']=$records->Item_quantity;
						$data['Slab4_Offer']=$records->Offer;
					}
					if($Slab_no==5)
					{
						$data['Slab5_Quantity']=$records->Item_quantity;
						$data['Slab5_Offer']=$records->Offer;
					}
					
				}
			}
			/***********XXX*****************/
			
			if($_POST == NULL)
			{
				$this->load->view('Coal_catalogue/Coal_Edit_Merchandize_ItemsV', $data);
			}
			else
			{
				$Merchant_flag=$this->input->post('Merchant_flag');	
				$Seller_id=0;	
				if($Merchant_flag==1)
				{
					$Seller_id=$this->input->post('Seller_id');
					$seller_details = $this->Igain_model->get_enrollment_details($Seller_id);
					$Seller_Redemptionratio = $seller_details->Seller_Redemptionratio;
				}
				else
				{
					$Seller_Redemptionratio = $data["Company_details"]->Redemptionratio;
				}
				
				$Partner_Row = $this->Catelogue_model->Get_Company_Partners_details($this->input->post('Partner_id'));
				$VAT=$Partner_Row->Partner_vat;
				$margin=$Partner_Row->Partner_markup_percentage;
				
				
				
				
				
				
				
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
					$upload28 = $this->upload->do_upload('file1');
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
			
				/*-----------------------------------Image Upload Code-----------------------------*/
				
				
				
				
				/*-----------------------------------Image Upload Code-----------------------------
				
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
					
					/*-----------------------Image1-----------------------------
						if ( !$this->upload->do_upload("file1") )
						{
							$Item_image1 = $this->input->post('Item_image1');
							$Thumbnail_image1 = $this->input->post('Thumbnail_image1');
						}
						else
						{
							$image_data1 = array('upload_data1' => $this->upload->data("file1"));
							
							/****************600 x 600************
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
							
							/****************225 x 225************
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
							/****************225 x 225*************
						}
					/*-----------------------Image1-----------------------------*
					
					/*-----------------------Image2-----------------------------*
						if ( !$this->upload->do_upload("file2") )
						{			
							$Item_image2 = $this->input->post('Item_image2');
							$Thumbnail_image2 = $this->input->post('Thumbnail_image2');
						}
						else
						{
							$image_data2 = array('upload_data2' => $this->upload->data("file2"));
							
							/****************600 x 600*************
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
							
							/****************225 x 225*************
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
							/****************225 x 225*************
						}
					/*-----------------------Image2-----------------------------*
					
					/*-----------------------Image3-----------------------------*
						if ( !$this->upload->do_upload("file3") )
						{			
							$Item_image3 = $this->input->post('Item_image3');
							$Thumbnail_image3 = $this->input->post('Thumbnail_image3');
						}
						else
						{
							$image_data3 = array('upload_data3' => $this->upload->data("file3"));
							
							/****************600 x 600*************
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
							
							/****************225 x 225*************
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
							/****************225 x 225*************
						}
					/*-----------------------Image3-----------------------------*
					
					/*-----------------------Image4-----------------------------
						if ( !$this->upload->do_upload("file4") )
						{			
							$Item_image4 = $this->input->post('Item_image4');
							$Thumbnail_image4 = $this->input->post('Thumbnail_image4');
						}
						else
						{
							$image_data4 = array('upload_data4' => $this->upload->data("file3"));
							
							/****************600 x 600*************
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
							
							/****************225 x 225*************
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
							/****************225 x 225*************
						}
					/*-----------------------Image3-----------------------------*/
				
				/*-----------------------------------Image Upload Code-----------------------------*/

				$Valid_from=date("Y-m-d",strtotime($this->input->post('Valid_from')));
				$Valid_till=date("Y-m-d",strtotime($this->input->post('Valid_till')));
				$Company_merchandise_item_id=$this->input->post('Company_merchandise_item_id');
				
				$Ecommerce_flag=$this->input->post('Ecommerce_flag');
				$LV_Link_to_Member_Enrollment_flag=$this->input->post('Link_to_Member_Enrollment_flag');
				$Send_once_year=$this->input->post('Send_once_year');
				$Send_other_benefits=$this->input->post('Send_other_benefits');
				$Size_Chart=$this->input->post('Size_Chart');
				$Gender_flag=$this->input->post('Gender_flag');
				$Colour_flag=$this->input->post('Colour_flag');
				$Brand_flag=$this->input->post('Brand_flag');
				
				$Manufacturer_flag=$this->input->post('Manufacturer_flag');
				$Merchant_flag=$this->input->post('Merchant_flag');
				$Tier_id=$this->input->post('Tier_id');
				$Size_flag=$this->input->post('Size_flag');
				
				if($Ecommerce_flag==1)
				{
					$Product_group_id=$this->input->post('Product_group_id');
					$Product_brand_id=$this->input->post('Product_brand_id');
					$Offer_flag=$this->input->post('Offer_flag');
				}
				else
				{
					$Product_group_id=0;
					$Product_brand_id=0;
					$Offer_flag=0;
				}
					
						
						/*****************************Insert Partner Branches*****************************/
						//print_r($Tier_id);
						//echo "count--".count($Tier_id);
						//die;
						$Dresult2 = $this->Coal_Catelogue_model->Delete_Merchandize_Item_Tiers($Company_merchandize_item_code,$Company_id);
						 foreach($Tier_id as $Tier_id)
						{
							//echo "<br>$i";
							/* //echo "<br> partner_branches2 ".$partner_branches2;
							if($Tier_id=='0')//All Branches
							{
								$Company_tiers_Records = $this->Igain_model->get_tier($this->input->post('Company_id'));
								
								foreach($Company_tiers_Records as $rec)
								{
									$Post_data2=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
									'Tier_id'=>$rec["Tier_id"]);
									$result_tier = $this->Coal_Catelogue_model->Insert_Merchandize_Item_tiers($Post_data2);
								}
							}
							else
							{ */
								
								//echo "<br> Branch_code ".$partner_branches2;
								$Post_data2=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Merchandize_item_code'=>$Company_merchandize_item_code,
									'Tier_id'=>$Tier_id);
								$result_tier = $this->Coal_Catelogue_model->Insert_Merchandize_Item_tiers($Post_data2);
							//}	
							
						}
						//die;
				
				$Size_flag=$this->input->post('Size_flag');
				$Partner_id=$this->input->post('Partner_id');
				
				if(isset($_REQUEST["Modify_cost_price"]))
				{
					/* echo"<pre>";
					var_dump($_REQUEST); */
					$Size_flag=$this->input->post('Size_flag');
					$Dimension_flag=$this->input->post('Dimension_flag');
					$Weight_flag=$this->input->post('Weight_flag');	
						
					if($Size_flag == 0 ) {
						
						$Cost_price=$this->input->post('Cost_price');
						$Cost_payable_to_partner=($Cost_price*$VAT/100)+$Cost_price;
						$Billing_price=(($Cost_payable_to_partner*$margin)/100)+$Cost_payable_to_partner;;
						$Points=($Billing_price*$Seller_Redemptionratio);	
						
						
					
					} else {
					
					
						$small_Cost_price=$this->input->post('small_Cost_price');
						$small_Cost_payable_to_partner=($small_Cost_price*$VAT/100)+$small_Cost_price;
						$small_Billing_price=(($small_Cost_payable_to_partner*$margin)/100)+$small_Cost_payable_to_partner;
						$small_Points=($small_Billing_price*$Seller_Redemptionratio);
						
						
						/* echo "<br> ---VAT---- ".$VAT."---<br>";
						echo "<br> ---margin---- ".$margin."---<br>";
						echo "<br> ---small_Cost_price---- ".$small_Cost_price."---<br>";
						echo "<br> ---small_Cost_payable_to_partner---- ".$small_Cost_payable_to_partner."---<br>";
						echo "<br> ---small_Billing_price---- ".$small_Billing_price."---<br>";
						echo "<br> ---Seller_Redemptionratio---- ".$Seller_Redemptionratio."---<br>";
						echo "<br> ---small_Points---- ".$small_Points."---<br>";
						
						die; */
						$medium_Cost_price=$this->input->post('medium_Cost_price');
						if($medium_Cost_price != NULL || $medium_Cost_price != 0 ) {
							
							
							$medium_Cost_payable_to_partner=($medium_Cost_price*$VAT/100)+$medium_Cost_price;
							$medium_Billing_price=(($medium_Cost_payable_to_partner*$margin)/100)+$medium_Cost_payable_to_partner;;
							$medium_Points=($medium_Billing_price*$Seller_Redemptionratio);
							
						} else { 
						
							$medium_Cost_price=0;
							$medium_Cost_payable_to_partner=0;
							$medium_Billing_price=0;
							$medium_Points=0;
						
						}
						
						$large_Cost_price=$this->input->post('large_Cost_price');
						if($large_Cost_price != NULL || $large_Cost_price != 0 ) {
							
							
							$large_Cost_payable_to_partner=($large_Cost_price*$VAT/100)+$large_Cost_price;
							$large_Billing_price=(($large_Cost_payable_to_partner*$margin)/100)+$large_Cost_payable_to_partner;;
							$large_Points=($large_Billing_price*$Seller_Redemptionratio);
						} else {
							
							$large_Cost_price=0;
							$large_Cost_payable_to_partner=0;
							$large_Billing_price=0;
							$large_Points=0;
						}
						
						$elarge_Cost_price=$this->input->post('elarge_Cost_price');
						if($elarge_Cost_price != NULL || $elarge_Cost_price != 0)
						{
							$elarge_Cost_payable_to_partner=($elarge_Cost_price*$VAT/100)+$elarge_Cost_price;
							$elarge_Billing_price=(($elarge_Cost_payable_to_partner*$margin)/100)+$elarge_Cost_payable_to_partner;;
							$elarge_Points=($elarge_Billing_price*$Seller_Redemptionratio);
							
						} else {
							
							$elarge_Cost_price=0;
							$elarge_Cost_payable_to_partner=0;
							$elarge_Billing_price=0;
							$elarge_Points=0;
						}
						
						
						
					
					}
					
						
					$Small_Item_Weight='0';
					$Small_Weight_unit_id='0';
					$Small_Item_Dimension='0';	
					$Medium_Item_Weight='0';
					$Medium_Weight_unit='0';
					$Medium_Item_Dimension='0';	
					$Large_Item_Weight='0';
					$Large_Weight_unit='0';
					$Large_Item_Dimension='0';
					$eLarge_Item_Weight='0';
					$eLarge_Weight_unit='0';
					$eLarge_Item_Dimension='0';
					if($Weight_flag==1)
					{
						if($Size_flag==0)
						{
							$Weight_unit_id=$this->input->post('Weight_unit');
							$Weight=$this->input->post('Weight');
							$Item_Weight=$Weight;
						}
					}
				/**********************************************************/
						if($Size_flag==1)
						{
							
							
							
							if($small_Points!="" && $small_Points!=0  && $small_Points!='NaN'  )
							{
								
								
								if($Weight_flag==1)
								{
									$Small_Weight_unit_id=$this->input->post('Small_Weight_unit');
									$Small_Weight=$this->input->post('Small_Weight');
									$Small_Item_Weight=$Small_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Small_Dimension_unit=$this->input->post('Small_Dimension_unit');
									$Small_Length=$this->input->post('Small_Length');
									$Small_Width=$this->input->post('Small_Width');
									$Small_Height=$this->input->post('Small_Height');
									$Small_Item_Dimension='('.$Small_Length.' X '.$Small_Width.' X '.$Small_Height.') '.$Small_Dimension_unit;
								}
								else
								{							
									$Small_Item_Dimension="";
								}
								$Points=$small_Points;
								$Item_Dimension=$Small_Item_Dimension;
								$Item_Weight=$Small_Item_Weight;
								$Weight_unit_id=$Small_Weight_unit_id;
								$Cost_price=$small_Cost_price;
								$Cost_payable_to_partner=$small_Cost_payable_to_partner;
								$Billing_price=$small_Billing_price;
							}
							elseif($medium_Points!="" && $medium_Points!=0  && $medium_Points!='NaN'  )
							{
								
								if($Weight_flag==1)
								{
									$Medium_Weight_unit=$this->input->post('Medium_Weight_unit');
									$Medium_Weight=$this->input->post('Medium_Weight');
									$Medium_Item_Weight=$Medium_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Medium_Dimension_unit=$this->input->post('Medium_Dimension_unit');
									$Medium_Length=$this->input->post('Medium_Length');
									$Medium_Width=$this->input->post('Medium_Width');
									$Medium_Height=$this->input->post('Medium_Height');
									$Medium_Item_Dimension='('.$Medium_Length.' X '.$Medium_Width.' X '.$Medium_Height.') '.$Medium_Dimension_unit;
								}
								else
								{							
									$Medium_Item_Dimension="";
								}
								$Points=$medium_Points;
								$Item_Dimension=$Medium_Item_Dimension;
								$Item_Weight=$Medium_Item_Weight;
								$Weight_unit_id=$Medium_Weight_unit;
								$Cost_price=$medium_Cost_price;
								$Cost_payable_to_partner=$medium_Cost_payable_to_partner;
								$Billing_price=$medium_Billing_price;
							}
							elseif($large_Points!="" && $large_Points!=0  && $large_Points!='NaN'  )
							{
								
								if($Weight_flag==1)
								{
									$Large_Weight_unit=$this->input->post('Large_Weight_unit');
									$Large_Weight=$this->input->post('Large_Weight');
									$Large_Item_Weight=$Large_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Large_Dimension_unit=$this->input->post('Large_Dimension_unit');
									$Large_Length=$this->input->post('Large_Length');
									$Large_Width=$this->input->post('Large_Width');
									$Large_Height=$this->input->post('Large_Height');
									$Large_Item_Dimension='('.$Large_Length.' X '.$Large_Width.' X '.$Large_Height.') '.$Large_Dimension_unit;
								}
								else
								{							
									$Large_Item_Dimension="";
								}
								$Points=$large_Points;
								$Item_Dimension=$Large_Item_Dimension;
								$Item_Weight=$Large_Item_Weight;
								$Weight_unit_id=$Large_Weight_unit;
								$Cost_price=$large_Cost_price;
								$Cost_payable_to_partner=$large_Cost_payable_to_partner;
								$Billing_price=$large_Billing_price;
							}
							else
							{
								
								if($Weight_flag==1)
								{
									$eLarge_Weight_unit=$this->input->post('eLarge_Weight_unit');
									$eLarge_Weight=$this->input->post('eLarge_Weight');
									$eLarge_Item_Weight=$eLarge_Weight;	
								}
								if($Dimension_flag==1)
								{
									$eLarge_Dimension_unit=$this->input->post('eLarge_Dimension_unit');
									$eLarge_Length=$this->input->post('eLarge_Length');
									$eLarge_Width=$this->input->post('eLarge_Width');
									$eLarge_Height=$this->input->post('eLarge_Height');
									$eLarge_Item_Dimension='('.$eLarge_Length.' X '.$eLarge_Width.' X '.$eLarge_Height.') '.$eLarge_Dimension_unit;
								}
								else
								{							
									$eLarge_Item_Dimension="";
								}
								$Points=$elarge_Points;
								$Item_Dimension=$eLarge_Item_Dimension;
								$Item_Weight=$eLarge_Item_Weight;
								$Weight_unit_id=$eLarge_Weight_unit;
								$Cost_price=$elarge_Cost_price;
								$Cost_payable_to_partner=$elarge_Cost_payable_to_partner;
								$Billing_price=$elarge_Billing_price;
							}
						}
						
					
					
					
					
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
									'Merchandize_item_code'=>$Company_merchandize_item_code,
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
								'Merchandize_item_code'=>$Company_merchandize_item_code,
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
					'Seller_Redemptionratio'=>$data["Merchandize_Item_Row"]->Seller_Redemptionratio,
					'Size_flag'=>$data["Merchandize_Item_Row"]->Size_flag,
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
					// 'Offer_flag'=>$data["Merchandize_Item_Row"]->Offer_flag,
					'Product_group_id'=>$data["Merchandize_Item_Row"]->Product_group_id,
					'Product_brand_id'=>$data["Merchandize_Item_Row"]->Product_brand_id,
					'Create_User_id'=>$data["Merchandize_Item_Row"]->Create_User_id,
					'Creation_date'=>$data["Merchandize_Item_Row"]->Creation_date,
					'Update_User_id'=>$data["Merchandize_Item_Row"]->Update_User_id,
					'Update_date'=>$data["Merchandize_Item_Row"]->Update_date,
					'Tier_id'=>$data["Merchandize_Item_Row"]->Tier_id,
					'Seller_id'=>$data["Merchandize_Item_Row"]->Seller_id,
					'Size_flag'=>$data["Merchandize_Item_Row"]->Size_flag,
					'Merchant_flag'=>$data["Merchandize_Item_Row"]->Merchant_flag,
					'Gender_flag'=>$data["Merchandize_Item_Row"]->Gender_flag,
					'Colour_flag'=>$data["Merchandize_Item_Row"]->Colour_flag,
					'Brand_flag'=>$data["Merchandize_Item_Row"]->Brand_flag,
					'Dimension_flag'=>$data["Merchandize_Item_Row"]->Dimension_flag,
					'Weight_flag'=>$data["Merchandize_Item_Row"]->Weight_flag,
					'Manufacturer_flag'=>$data["Merchandize_Item_Row"]->Manufacturer_flag,
					'Item_Colour'=>$data["Merchandize_Item_Row"]->Item_Colour,
					'Item_Brand'=>$data["Merchandize_Item_Row"]->Item_Brand,
					'Item_Dimension'=>$data["Merchandize_Item_Row"]->Item_Dimension,
					'Item_Weight'=>$data["Merchandize_Item_Row"]->Item_Weight,
					'Item_Manufacturer'=>$data["Merchandize_Item_Row"]->Item_Manufacturer,
					'Active_flag'=>1);
					
					$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data);
					
					
					/**********************Insert into Merchandise_Size child log table***************/
					
					
					$Get_item_size_info = $this->Coal_Catelogue_model->Get_Merchandize_Item_Size_info($Company_merchandize_item_code,$Company_id);
					if($Get_item_size_info != NULL && $data["Merchandize_Item_Row"]->Size_flag==1)
					{	
						
						foreach($Get_item_size_info as $Rec)
						{
							$Post_data_size22=array(
								'Item_size'=>$Rec->Item_size,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$Company_merchandize_item_code,
								'Cost_price'=>$Rec->Cost_price,
								'Billing_price'=>$Rec->Billing_price,
								'Cost_payable_to_partner'=>$Rec->Cost_payable_to_partner,
								'Create_date'=>$this->input->post('Update_date'),
								'Billing_price_in_points'=>$Rec->Billing_price_in_points);
								$resultsize2 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size_LOG($Post_data_size22);
						}
					}
			
					
					/**************14-10-2016 Alkwar size change*************/
						
						if($Size_flag==1)
						{
							$Dresult232 = $this->Coal_Catelogue_model->Delete_Merchandize_Item_Size_info($Company_merchandize_item_code,$Company_id);
							
							
							/***************Insert into Merchandise_Size child table************/
							if($small_Cost_price!="" && $small_Billing_price!="" && $small_Points!="")
							{
								if($Weight_flag==1)
								{
									$Small_Weight_unit=$this->input->post('Small_Weight_unit');
									$Small_Weight=$this->input->post('Small_Weight');
									$Small_Item_Weight=$Small_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Small_Dimension_unit=$this->input->post('Small_Dimension_unit');
									$Small_Length=$this->input->post('Small_Length');
									$Small_Width=$this->input->post('Small_Width');
									$Small_Height=$this->input->post('Small_Height');
									$Small_Item_Dimension='('.$Small_Length.' X '.$Small_Width.' X '.$Small_Height.') '.$Small_Dimension_unit;
								}
								 else {
							
									$Small_Item_Dimension="";
								}
								
								$Post_data_size=array(
								'Item_size'=>1,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$Company_merchandize_item_code,
								'Cost_price'=>$small_Cost_price,
								'Billing_price'=>$small_Billing_price,
								'Cost_payable_to_partner'=>$small_Cost_payable_to_partner,
								'Item_weight'=>$Small_Item_Weight,
								'Weight_unit_id'=>$Small_Weight_unit,
								'Item_Dimension'=>$Small_Item_Dimension,
								'Billing_price_in_points'=>$small_Points);
								$resultsize = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size);
							}
							
							if($medium_Cost_price!="" && $medium_Billing_price!="" && $medium_Points!="")
							{
								if($Weight_flag==1)
								{
									$Medium_Weight_unit=$this->input->post('Medium_Weight_unit');
									$Medium_Weight=$this->input->post('Medium_Weight');
									$Medium_Item_Weight=$Medium_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Medium_Dimension_unit=$this->input->post('Medium_Dimension_unit');
									$Medium_Length=$this->input->post('Medium_Length');
									$Medium_Width=$this->input->post('Medium_Width');
									$Medium_Height=$this->input->post('Medium_Height');
									$Medium_Item_Dimension='('.$Medium_Length.' X '.$Medium_Width.' X '.$Medium_Height.') '.$Medium_Dimension_unit;
								}
								 else {
							
									$Medium_Item_Dimension="";
								}
								$Post_data_size2=array(
								'Item_size'=>2,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$Company_merchandize_item_code,
								'Cost_price'=>$medium_Cost_price,
								'Billing_price'=>$medium_Billing_price,
								'Cost_payable_to_partner'=>$medium_Cost_payable_to_partner,
								'Item_weight'=>$Medium_Item_Weight,
								'Weight_unit_id'=>$Medium_Weight_unit,
								'Item_Dimension'=>$Medium_Item_Dimension,
								'Billing_price_in_points'=>$medium_Points);
								$resultsize2 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size2);
							}
							
							if($large_Cost_price!="" && $large_Billing_price!="" && $large_Points!="")
							{
								if($Weight_flag==1)
								{
									$Large_Weight_unit=$this->input->post('Large_Weight_unit');
									$Large_Weight=$this->input->post('Large_Weight');
									$Large_Item_Weight=$Large_Weight;	
								}
								if($Dimension_flag==1)
								{
									$Large_Dimension_unit=$this->input->post('Large_Dimension_unit');
									$Large_Length=$this->input->post('Large_Length');
									$Large_Width=$this->input->post('Large_Width');
									$Large_Height=$this->input->post('Large_Height');
									$Large_Item_Dimension='('.$Large_Length.' X '.$Large_Width.' X '.$Large_Height.') '.$Large_Dimension_unit;
								}
								 else {
							
									$Large_Dimension_unit="";
								}
								$Post_data_size3=array(
								'Item_size'=>3,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$Company_merchandize_item_code,
								'Cost_price'=>$large_Cost_price,
								'Billing_price'=>$large_Billing_price,
								'Cost_payable_to_partner'=>$large_Cost_payable_to_partner,
								'Item_weight'=>$Large_Item_Weight,
								'Weight_unit_id'=>$Large_Weight_unit,
								'Item_Dimension'=>$Large_Item_Dimension,
								'Billing_price_in_points'=>$large_Points);
								$resultsize3 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size3);
							}
							if($elarge_Cost_price!="" && $elarge_Billing_price!="" && $elarge_Points!="")
							{
								if($Weight_flag==1)
								{
									$eLarge_Weight_unit=$this->input->post('eLarge_Weight_unit');
									$eLarge_Weight=$this->input->post('eLarge_Weight');
									$eLarge_Item_Weight=$eLarge_Weight;	
								}
								if($Dimension_flag==1)
								{
									$eLarge_Dimension_unit=$this->input->post('eLarge_Dimension_unit');
									$eLarge_Length=$this->input->post('eLarge_Length');
									$eLarge_Width=$this->input->post('eLarge_Width');
									$eLarge_Height=$this->input->post('eLarge_Height');
									$eLarge_Item_Dimension='('.$eLarge_Length.' X '.$eLarge_Width.' X '.$eLarge_Height.') '.$eLarge_Dimension_unit;
								} else {
							
									$eLarge_Item_Dimension="";
								}
								$Post_data_size4=array(
								'Item_size'=>4,
								'Company_id'=>$this->input->post('Company_id'),
								'Company_merchandize_item_code'=>$Company_merchandize_item_code,
								'Cost_price'=>$elarge_Cost_price,
								'Billing_price'=>$elarge_Billing_price,
								'Cost_payable_to_partner'=>$elarge_Cost_payable_to_partner,
								'Item_weight'=>$eLarge_Item_Weight,
								'Weight_unit_id'=>$eLarge_Weight_unit,
								'Item_Dimension'=>$eLarge_Item_Dimension,
								'Billing_price_in_points'=>$elarge_Points);
								$resultsize4 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Size($Post_data_size4);
								
							}
							
						}
						if($Dimension_flag==1)
						{
							if($Size_flag==0)
							{
								$Dimension_unit=$this->input->post('Dimension_unit');
								$Length=$this->input->post('Length');
								$Width=$this->input->post('Width');
								$Height=$this->input->post('Height');
								$Item_Dimension='('.$Length.' X '.$Width.' X '.$Height.') '.$Dimension_unit;
							}
						} else {
							
							$Item_Dimension="";
						}
						
					
						$rec1 = $this->Catelogue_model->Get_Company_Partners_details($Partner_id);
						
						$Post_data3 = array
						(
							'Partner_id'=>$Partner_id,
							'Merchant_flag'=>$Merchant_flag,
							'Seller_id'=>$Seller_id,
							'Seller_Redemptionratio'=>$Seller_Redemptionratio,
							'Size_flag'=>$Size_flag,
							'Weight_flag'=>$Weight_flag,
							'Cost_price'=>$Cost_price,
							 'Cost_payable_to_partner'=>$Cost_payable_to_partner,
							 'Billing_price'=>$Billing_price,
							 'Billing_price_in_points'=>$Points,
							 'Item_Weight'=>$Item_Weight,
							 'Weight_unit_id'=>$Weight_unit_id,
							 'Dimension_flag'=>$Dimension_flag,
							 'VAT'=>$rec1->Partner_vat,
							'Markup_percentage'=>$rec1->Partner_markup_percentage,
							'Item_Dimension'=>$Item_Dimension
							 
						);
						$result3 = $this->Catelogue_model->Update_Merchandize_Item($Company_merchandise_item_id,$Post_data3);
						/***********************************************************/
				}	
				//	die;
					/***********************************************************************************************/
				
				
				$data["Merchandize_Item_Row"] = $this->Coal_Catelogue_model->Get_Merchandize_Item_details($Company_merchandise_item_id);	
				
				
				/*******AMIT 13-09-2017********************/	
					
					
					$Item_Colour='';
					$Item_Brand='';
					$Item_Manufacturer='';
					
					if($Colour_flag==1)
					{
						$Item_Colour=$this->input->post('Item_Colour');
					}
					if($Brand_flag==1)
					{
						$Item_Brand=$this->input->post('Item_Brand');
					}
					
					
					if($Manufacturer_flag==1)
					{
						$Item_Manufacturer=$this->input->post('Item_Manufacturer');
					}
					
						
					
						
					
					$Size_chart_image ='';
					if($Size_Chart==1)
					{
						$Size_chart_image=$this->input->post('Size_chart_image');
						$old_Size_chart_image=$this->input->post('old_Size_chart_image');
						if($Size_chart_image==1)//Upload Your Size Chart
						{
							/* if ($this->upload->do_upload("Size_Chart_upload_img") )
							{
								$chart_img = array('upload_chart_img' => $this->upload->data("Size_Chart_upload_img"));
							
								$config17 = array
								(
									'source_image'      => $chart_img['upload_chart_img']['full_path'], //path to the uploaded image
									'new_image'         => 'Size_chart_images/'.$chart_img['upload_chart_img']['file_name'], //path to
									'maintain_ratio'    => true,
									'encrypt_name'    => true,
									'overwrite'    => true,
									'width'             => 600,
									'height'            => 600
								);
								
								$this->image_lib->initialize($config17);
								$this->image_lib->resize();
								
								$Size_chart_image = base_url().$config17['new_image'];
							} */	
								$config77 = array
								(
									'allowed_types'     => 'jpg|jpeg|gif|png', //only accept these file types
									'max_size'          => 2048, //2MB max
									'max_width'          => 3000, //2MB max
									'max_height'          => 3000, //2MB max
									'encrypt_name'    => true,
									'upload_path'       => './Size_chart_images/' //upload directory
								);
								
								$this->load->library('upload', $config77);
								$this->upload->initialize($config77);
								
								$configThumb = array();
								$configThumb['image_library'] = 'gd2';
								$configThumb['source_image'] = '';
								$configThumb['create_thumb'] = TRUE;
								$configThumb['maintain_ratio'] = TRUE;			
								$configThumb['width'] = 128;
								$configThumb['height'] = 128;
								/* Load the image library */
								$this->load->library('image_lib');						
								$upload77 = $this->upload->do_upload('Size_Chart_upload_img');
								$data77 = $this->upload->data();			   
								if($data77['is_image'] == 1) 
								{						 
									$configThumb['source_image'] = $data77['full_path'];
									$configThumb['source_image'] = './Size_chart_images/'.$config77;
									$this->image_lib->initialize($configThumb);
									$this->image_lib->resize();
									$Size_chart_image=base_url().'Size_chart_images/'.$data77['file_name'];
								}
								else
								{							
									
									$Size_chart_image =$old_Size_chart_image;								
									
								}
						}
						else
						{
							if($Size_chart_image=="" || $Size_chart_image== NULL)
							{
								$Size_chart_image = $old_Size_chart_image;
							}
							else
							{
								$Size_chart_image = base_url().'Size_chart_images/'.$Size_chart_image.'.png';
							}
							
							/* echo "<br>Size_chart_image ".$Size_chart_image;
							echo "<br>old_Size_chart_image ".$old_Size_chart_image;							
							die; */
						}
					}
					/*******AMIT 13-09-2017******END**************/	
					
					if($LV_Link_to_Member_Enrollment_flag=="" || $LV_Link_to_Member_Enrollment_flag==NULL)
					{
						$LV_Link_to_Member_Enrollment_flag=0;
						$Send_once_year=0;
						$Send_other_benefits=0;
					}
					
					/*****Quantity Description*********************************************/
				$Quantity_flag=$this->input->post('Quantity_flag');
				if($Quantity_flag==1)
				{
					$Stock_quantity=$this->input->post('Stock_quantity');
					
					$Slab1_Quantity=$this->input->post('Slab1_Quantity');
					$Slab1_Offer=$this->input->post('Slab1_Offer');
					
					$Slab2_Quantity=$this->input->post('Slab2_Quantity');
					$Slab2_Offer=$this->input->post('Slab2_Offer');
					
					$Slab3_Quantity=$this->input->post('Slab3_Quantity');
					$Slab3_Offer=$this->input->post('Slab3_Offer');
					
					$Slab4_Quantity=$this->input->post('Slab4_Quantity');
					$Slab4_Offer=$this->input->post('Slab4_Offer');
					
					$Slab5_Quantity=$this->input->post('Slab5_Quantity');
					$Slab5_Offer=$this->input->post('Slab5_Offer');
					
					
					$resultsize16 = $this->Coal_Catelogue_model->Delete_Merchandize_Item_Quantity_child($Company_merchandize_item_code,$Company_id);
					
					if($Slab1_Quantity!="")
					{
						
						$Post_data_qty1=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>1,
						'Item_quantity'=>$Slab1_Quantity,
						'Offer'=>$Slab1_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize1 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty1);
					}
					if($Slab2_Quantity!="")
					{
						
						$Post_data_qty2=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>2,
						'Item_quantity'=>$Slab2_Quantity,
						'Offer'=>$Slab2_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize2 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty2);
					}
					if($Slab3_Quantity!="")
					{
						
						$Post_data_qty3=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>3,
						'Item_quantity'=>$Slab3_Quantity,
						'Offer'=>$Slab3_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize3 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty3);
					}
					if($Slab4_Quantity!="")
					{
						
						$Post_data_qty4=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>4,
						'Item_quantity'=>$Slab4_Quantity,
						'Offer'=>$Slab4_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize4 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty4);
					}
					if($Slab5_Quantity!="")
					{
						
						$Post_data_qty5=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Merchandize_item_code'=>$this->input->post('Company_merchandize_item_code'),
						'Slab_no'=>5,
						'Item_quantity'=>$Slab5_Quantity,
						'Offer'=>$Slab5_Offer,
						'Item_remaining_quantity'=>0);
						$resultsize5 = $this->Coal_Catelogue_model->Insert_Merchandize_Item_Quantity_child($Post_data_qty5);
					}
					
					
				}
				else
				{
					$Stock_quantity=0;
					$resultsize16 = $this->Coal_Catelogue_model->Delete_Merchandize_Item_Quantity_child($Company_merchandize_item_code,$Company_id);
				}
				/*****Quantity Description*********XXX************************************/
					
					$Post_data = array
					(
						'Valid_from'=>$Valid_from,
						'Valid_till'=>$Valid_till,
						'Merchandize_category_id'=>$this->input->post('Merchandize_category_id'),
						'Merchandize_item_type'=>$this->input->post('Merchandize_item_type'),
						'Merchandize_item_name'=>$this->input->post('Merchandize_item_name'),
						'Merchandise_item_description'=>$this->input->post('Merchandise_item_description'),
						'Delivery_method'=>$this->input->post('Delivery_method'),
						'show_item'=>$this->input->post('show_item'),
						'Ecommerce_flag'=>$Ecommerce_flag,
						'Offer_flag'=>$Offer_flag,
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
						'Update_user_id'=>$data['enroll'],
						'Gender_flag'=>$Gender_flag,
						'Colour_flag'=>$Colour_flag,
						'Brand_flag'=>$Brand_flag,
						'Manufacturer_flag'=>$Manufacturer_flag,
						'Item_Colour'=>$Item_Colour,
						'Item_Brand'=>$Item_Brand,
						'Item_Manufacturer'=>$Item_Manufacturer,
						 'Size_Chart'=>$Size_Chart,
						'Size_chart_image'=>$Size_chart_image,
						'Send_once_year'=>$Send_once_year,
						'Send_other_benefits'=>$Send_other_benefits,
						'Link_to_Member_Enrollment_flag'=>$LV_Link_to_Member_Enrollment_flag,
						'Quantity_flag'=>$Quantity_flag,
						'Stock_quantity'=>$Stock_quantity,
						'Remaining_quantity'=>$Stock_quantity,
						'Update_date'=>$this->input->post('Update_date')
					);
				
				$result = $this->Catelogue_model->Update_Merchandize_Item($Company_merchandise_item_id,$Post_data);
				 //print_r($Post_data);die;
				// echo "Seller_id".$Seller_id;
				
				if($result == true)
				{
					$this->session->set_flashdata("data_code",$this->upload->display_errors());
					$this->session->set_flashdata("success_code","Merchandise Item  Updated Successfuly!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Merchandise Item Updated Error!!");
				}
				redirect("Coal_CatalogueC/Create_Merchandize_Items");
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
			/************Get codedecode master*****amit 13-09-2017************/
			$data["Code_decode_Records"] = $this->Igain_model->Get_Code_decode_master($Company_id);
			/***************************/
			$data["Product_group_Records"] = $this->Catelogue_model->Get_Product_groups($Company_id);
			$data["Merchandize_Item_Row"] = $this->Coal_Catelogue_model->Get_Merchandize_Item_details($lv_Company_merchandise_item_id);	
			$Company_merchandize_item_code=$data["Merchandize_Item_Row"]->Company_merchandize_item_code;
			$data["Item_Dimension"] =$data["Merchandize_Item_Row"]->Item_Dimension;
			$data["Item_Weight"] =$data["Merchandize_Item_Row"]->Item_Weight;
			
			$data["Merchandize_Item_Branches"] = $this->Catelogue_model->Get_Merchandize_Item_Branches($Company_merchandize_item_code,$Company_id);	
			
			$data["Merchandize_Item_Tiers"] = $this->Coal_Catelogue_model->Get_Merchandize_Item_Tiers($Company_merchandize_item_code,$Company_id);
			
			$lv_Product_group_id=$data["Merchandize_Item_Row"]->Product_group_id;
			$data['Get_Product_Brands'] = $this->Catelogue_model->Get_Product_Brands($lv_Product_group_id,$Company_id);
			
			/***********New Added 21-09-2016 amit******************/
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);
			if( $data['Super_seller']==1)
			{
				$data["Subseller_details"] = $this->Igain_model->FetchSubsellerdetails($session_data['Company_id']);
			}
			else
			{
				$data["Subseller_details"] =$this->Igain_model->get_seller_details_12($data['enroll']);
			}
			/*******************/
			
			$Size_flag=$data["Merchandize_Item_Row"]->Size_flag;
			//echo "Size_flag ".$Size_flag;
			/***********Set Default 0**************/
				$data["small_Cost_price"] ="";
			$data["small_Billing_price"] ="";
			$data["small_Points"] ="";
			$data["small_Item_weight"] ="";
			$data["small_Weight_unit_id"] ="";
			$data["small_Item_Dimension"] ="";
			$data["small_Cost_payable_to_partner"] ="";
			
			$data["medium_Cost_price"] ="";
			$data["medium_Billing_price"] ="";
			$data["medium_Points"] ="";
			$data["medium_Item_weight"] ="";
			$data["medium_Weight_unit_id"] ="";
			$data["medium_Item_Dimension"] ="";
			$data["medium_Cost_payable_to_partner"] ="";
			
			$data["large_Cost_price"] ="";
			$data["large_Billing_price"] ="";
			$data["large_Points"] ="";
			$data["large_Item_weight"] ="";
			$data["large_Weight_unit_id"] ="";
			$data["large_Item_Dimension"] ="";
			$data["large_Cost_payable_to_partner"] ="";
			
			$data["elarge_Cost_price"] ='';
			$data["elarge_Billing_price"] ='';
			$data["elarge_Points"] ='';
			$data["elarge_Item_weight"] ='';
			$data["elarge_Weight_unit_id"] ='';
			$data["elarge_Item_Dimension"] ='';
			$data["elarge_Cost_payable_to_partner"] ='';
			/*************************/
			if($Size_flag==1)
			{
				$Get_item_size_info = $this->Coal_Catelogue_model->Get_Merchandize_Item_Size_info($Company_merchandize_item_code,$Company_id);
				foreach($Get_item_size_info as $Rec)
				{
					// echo "<br>Cost_price ".$Rec->Cost_price;
					$Item_size =$Rec->Item_size;
					if($Item_size==1)//Small
					{
						$data["small_Cost_price"] =$Rec->Cost_price;
						$data["small_Billing_price"] =$Rec->Billing_price;
						$data["small_Points"] =$Rec->Billing_price_in_points;
						$data["small_Item_weight"] =$Rec->Item_weight;
						$data["small_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["small_Item_Dimension"] =$Rec->Item_Dimension;
						$data["small_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					if($Item_size==2)//Medium
					{
						$data["medium_Cost_price"] =$Rec->Cost_price;
						$data["medium_Billing_price"] =$Rec->Billing_price;
						$data["medium_Points"] =$Rec->Billing_price_in_points;
						$data["medium_Item_weight"] =$Rec->Item_weight;
						$data["medium_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["medium_Item_Dimension"] =$Rec->Item_Dimension;
						$data["medium_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					if($Item_size==3)//Large
					{
						$data["large_Cost_price"] =$Rec->Cost_price;
						$data["large_Billing_price"] =$Rec->Billing_price;
						$data["large_Points"] =$Rec->Billing_price_in_points;
						$data["large_Item_weight"] =$Rec->Item_weight;
						$data["large_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["large_Item_Dimension"] =$Rec->Item_Dimension;
						$data["large_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					if($Item_size==4)//Extra Large
					{
						$data["elarge_Cost_price"] =$Rec->Cost_price;
						$data["elarge_Billing_price"] =$Rec->Billing_price;
						$data["elarge_Points"] =$Rec->Billing_price_in_points;
						$data["elarge_Item_weight"] =$Rec->Item_weight;
						$data["elarge_Weight_unit_id"] =$Rec->Weight_unit_id;
						$data["elarge_Item_Dimension"] =$Rec->Item_Dimension;
						$data["elarge_Cost_payable_to_partner"] =$Rec->Cost_payable_to_partner;
					}
					
				}
			}
			/*************AMIT 11-01-2018 GET Quantity CHILD******************/
			$data['Slab1_Quantity']='';
			$data['Slab1_Offer']='';
			$data['Slab2_Quantity']='';
			$data['Slab2_Offer']='';
			$data['Slab3_Quantity']='';
			$data['Slab3_Offer']='';
			$data['Slab4_Quantity']='';
			$data['Slab4_Offer']='';
			$data['Slab5_Quantity']='';
			$data['Slab5_Offer']='';
						
			$Get_Quantity_child = $this->Coal_Catelogue_model->Get_Quantity_child_details($Company_merchandize_item_code,$Company_id);
			// print_r($data['Get_Quantity_child']);
			if($Get_Quantity_child !=NULL)
			{
				foreach($Get_Quantity_child as $records)
				{
					$Slab_no=$records->Slab_no;
					if($Slab_no==1)
					{
						$data['Slab1_Quantity']=$records->Item_quantity;
						$data['Slab1_Offer']=$records->Offer;
					}
					if($Slab_no==2)
					{
						$data['Slab2_Quantity']=$records->Item_quantity;
						$data['Slab2_Offer']=$records->Offer;
					}
					if($Slab_no==3)
					{
						$data['Slab3_Quantity']=$records->Item_quantity;
						$data['Slab3_Offer']=$records->Offer;
					}
					if($Slab_no==4)
					{
						$data['Slab4_Quantity']=$records->Item_quantity;
						$data['Slab4_Offer']=$records->Offer;
					}
					if($Slab_no==5)
					{
						$data['Slab5_Quantity']=$records->Item_quantity;
						$data['Slab5_Offer']=$records->Offer;
					}
					
				}
			}
			/***********XXX*****************/
			
				if($_POST == NULL)
			{
				$this->load->view('Coal_catalogue/Coal_Modify_cost_Price', $data);
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
		
		$result = $this->Catelogue_model->InActive_Merchandize_Item($Company_merchandise_item_id,$Update_user_id,$Update_date);
		if($result == true)
		{
			$this->session->set_flashdata("success_code","Merchandise Item Deleted Successfuly");
		}
		else
		{
			$this->session->set_flashdata("error_code","Error Deleting Merchandise Item");
		}
		redirect("Coal_CatalogueC/Create_Merchandize_Items");
	}
	/**************************************************Create Merchandise Items End************************/
	public function Get_Merchandise_items()
	{
		// $data['records'] = $this->Catelogue_model->Get_Search_Merchandise_items($this->input->post("search_flag"),$this->input->post("search_id"),$this->input->post("Company_id"));
		$search_flag=$this->input->post("search_flag");
		$search_id=$this->input->post("search_id");
		$Company_id=$this->input->post("Company_id");
		
		$session_data = $this->session->userdata('logged_in');
		$data['enroll'] = $session_data['enroll'];	
		$data['Super_seller']= $session_data['Super_seller'];
			
		if($search_id=='0')//All
		{
			$data["Merchandize_Items_Records"] = $this->Coal_Catelogue_model->Get_Merchandize_Items('', '',$Company_id,1,$data['Super_seller'],$data['enroll']);
		}
		
		if($search_flag==1 && $search_id!='0')//Partner
		{
			$data['Merchandize_Items_Records'] = $this->Catelogue_model->Get_Partner_linked_Merchandize_Items($this->input->post("search_id"),$data['Super_seller'],$data['enroll']);
		}
		if($search_flag==2 && $search_id!='0')//Merchant
		{
			$data['Merchandize_Items_Records'] = $this->Catelogue_model->Get_Merchant_linked_Merchandize_Items($this->input->post("search_id"));
		}
		if($search_flag==3 && $search_id!='0')//Category
		{
			$data['Merchandize_Items_Records'] = $this->Catelogue_model->Get_Category_linked_Merchandize_Items($this->input->post("search_id"),$data['Super_seller'],$data['enroll']);
		}
		if($search_flag==4 && $search_id!='0')//By Item code and name
		{
			$data['Merchandize_Items_Records'] = $this->Catelogue_model->Get_Searched_Merchandize_Items($this->input->post("search_id"),$Company_id,$data['Super_seller'],$data['enroll']);
		}
		$theHTMLResponse = $this->load->view('Coal_catalogue/Get_Search_Merchandise_items', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('records'=> $theHTMLResponse)));
	}
}	
?>