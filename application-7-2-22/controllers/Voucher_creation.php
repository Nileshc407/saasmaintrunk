<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voucher_creation extends CI_Controller
{
	public function __construct()
	{
		
		parent::__construct();			
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('pagination');
		
		$this->load->model('Coal_catalogue/Voucher_model');
		
		// die;
		// $this->load->model('Coal_catalogue/Voucher_model');
		
	}
	/***************************Create Voucher creation Start*************************************/
	function index(){
		
		// echo"Voucher_creation---index--";
		// die;	 
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
			$data["Redemptionratio"] =$data["Company_details"]->Redemptionratio;
			$Company_Redemptionratio=$data["Company_details"]->Redemptionratio;
			
			/************Get codedecode master*****amit 13-09-2017************/
			$data["Voucher_type_code_decode"] = $this->Voucher_model->Get_voucher_type_code_decode_master($Company_id);
			// var_dump($data["Voucher_type_code_decode"]);
			/***************************/
			
			/************Get codedecode master*****amit 13-09-2017************/
			$today=date("Y-m-d H:i:s");
			$data["Voucher_item"] = $this->Voucher_model->Get_voucher_item_details($Company_id,$today);
			// var_dump($data["Voucher_item"]);
			/***************************/
			// echo"Voucher_creation";
			
			/***********GET Seller Currency******************************/
				$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
				$Symbol_currency = $currency_details->Symbol_of_currency;
				$data['Symbol_currency'] = $Symbol_currency;
			/***********************************/
			
			$data["ActiveVoucher_Records"] = $this->Voucher_model->Get_active_voucher_datails($Company_id,1);
			// var_dump($data["ActiveVoucher_Records"]);
			
			$data["InActiveVoucher_Records"] = $this->Voucher_model->Get_active_voucher_datails($Company_id,0);
			// var_dump($data["InActiveVoucher_Records"]);
			
			if($_POST == NULL)
			{
				$this->load->view('Voucher_creation/Create_voucher_creation', $data);
				
			} 
			else
			{	
				// var_dump($_POST);
				// die;
				
				/*-----------------------Check Voucher_code---------------------*/
					$Voucher_code=$this->input->post('Voucher_code');
					$Validate_voucher_code = $this->Voucher_model->Check_voucher_code($Voucher_code,$Company_id);
					if($Validate_voucher_code > 0 ){
						
						$this->session->set_flashdata("error_code","Provided voucher code already exist");
						redirect("Voucher_creation");
				
					}
				/*-----------------------Check Voucher_code---------------------*/
					
				
				
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
				
			
			
				
				
					// echo"---Company_Redemptionratio-----".$Company_Redemptionratio."---<br>";
					
					if($this->input->post('Cost_price')){
						$Cost_price=$this->input->post('Cost_price');
					} else {
						$Cost_price=0;
					}
					if($this->input->post('Points')){
						$Points=$this->input->post('Points');
					} else {
						$Points=0;
					}
					
					$Cost_in_points = ($Cost_price * $Company_Redemptionratio);		
					if($Cost_in_points > 0){
						$Cost_in_points=$Cost_in_points;
					} else {
						$Cost_in_points=0;
					}
					
					/* echo"---Cost_price-----".$Cost_price."---<br>";
					echo"---Points-----".$Points."---<br>";
					echo"---Cost_in_points-----".$Cost_in_points."---<br>"; */
					
				
					
					
					$Valid_from=date("Y-m-d",strtotime($this->input->post('Valid_from')));
					$Valid_till=date("Y-m-d",strtotime($this->input->post('Valid_till')));
					
					$Valid_from = $Valid_from." 00:00:00";
					$Valid_till = $Valid_till." 23:59:59";
					
					/*****Quantity Description*********XXX************************************/
					
					$Post_data=array(
						'Company_id'=>$this->input->post('Company_id'),
						'Voucher_code'=>$this->input->post('Voucher_code'),
						'Valid_from'=>$Valid_from,
						'Valid_till'=>$Valid_till,
						'Voucher_type'=>$this->input->post('Voucher_type'),
						'Voucher_name'=>$this->input->post('Voucher_name'),
						'Voucher_description'=>$this->input->post('Voucher_description'),						
						'Item_image1'=>$Item_image1,
						'Item_image2'=>$Item_image2,
						'Item_image3'=>$Item_image3,
						'Item_image4'=>$Item_image4,
						'Thumbnail_image1'=>$Thumbnail_image1,
						'Thumbnail_image2'=>$Thumbnail_image2,
						'Thumbnail_image3'=>$Thumbnail_image3,
						'Thumbnail_image4'=>$Thumbnail_image4,
						'Cost_price'=>$Cost_price,
						'Cost_in_points'=>$Cost_in_points,
						'Billing_price'=>$Cost_price,
						'Billing_price_in_points'=>$Cost_in_points,						
						'Create_User_id'=>$data['enroll'],
						'Creation_date'=>date("Y-m-d H:i:s"),
						'Active_flag'=>$this->input->post('show_item')
					);
					// var_dump($Post_data);
					// die;
					
					$result = $this->Voucher_model->Insert_voucher($Post_data);
					// var_dump($result);
					// die;
			
					if($result)
					{
						
						$POS_item=$this->input->post('POS_item');
						if($POS_item) {
							
							for($i=0; $i<count($POS_item); $i++){
								
								$today=date("Y-m-d H:i:s");
								$Merchandize_Item_details = $this->Voucher_model->Get_Merchandize_Item_details($POS_item[$i],$today);
								$Post_child_data=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Voucher_id'=>$result,
									'Voucher_type'=>$this->input->post('Voucher_type'),
									'Voucher_code'=>$this->input->post('Voucher_code'),									
									'Company_merchandise_item_id'=>$Merchandize_Item_details->Company_merchandise_item_id,
									'Company_merchandize_item_code'=>$Merchandize_Item_details->Company_merchandize_item_code,
									'Valid_from'=>$Valid_from,
									'Valid_till'=>$Valid_till,
									'Active_flag'=>$this->input->post('show_item'),							
									'Create_User_id'=>$data['enroll'],
									'Creation_date'=>date("Y-m-d H:i:s")
									
								);								
								$result_child = $this->Voucher_model->Insert_voucher_child($Post_child_data);
							} 
						} else {
							
								
								$Post_child_data=array(
									'Company_id'=>$this->input->post('Company_id'),
									'Voucher_id'=>$result,
									'Voucher_type'=>$this->input->post('Voucher_type'),
									'Voucher_code'=>$this->input->post('Voucher_code'),									
									'Cost_price'=>$Cost_price,
									'Cost_in_points'=>$Cost_in_points,
									'Valid_from'=>$Valid_from,
									'Valid_till'=>$Valid_till,
									'Active_flag'=>$this->input->post('show_item'),							
									'Create_User_id'=>$data['enroll'],
									'Creation_date'=>date("Y-m-d H:i:s")
									
								);								
								$result_child = $this->Voucher_model->Insert_voucher_child($Post_child_data);
						}							
						
						/*******************Insert igain Log Table*********************/
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Create Voucher";
							$where="Create Voucher";
							$toname="";
							$To_enrollid =0;
							$firstName = '';
							$lastName = '';
							$Seller_name = $session_data['Full_name'];
							$opval = $this->input->post('Voucher_name').' ( '.$this->input->post('Voucher_code').' )';
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$enroll);
						/*******************Insert igain Log Table*********************/
						
						$this->session->set_flashdata("data_code",$this->upload->display_errors());
						$this->session->set_flashdata("success_code"," ".$this->input->post('Voucher_name')." Voucher Created Successfuly!!");
					}
					else
					{
						$this->session->set_flashdata("error_code","Error creating ".$this->input->post('Voucher_name')." voucher");
					}			
					redirect("Voucher_creation");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function Edit_voucher(){
		
		// echo"Voucher_creation---index--";
		// die;	 
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
			$data["Redemptionratio"] =$data["Company_details"]->Redemptionratio;
			$Company_Redemptionratio=$data["Company_details"]->Redemptionratio;
			
			/************Get codedecode master*****amit 13-09-2017************/
			$data["Voucher_type_code_decode"] = $this->Voucher_model->Get_voucher_type_code_decode_master($Company_id);
			// var_dump($data["Voucher_type_code_decode"]);
			/***************************/
			
			/************Get codedecode master*****amit 13-09-2017************/
			$today=date("Y-m-d H:i:s");
			$data["Voucher_item"] = $this->Voucher_model->Get_voucher_item_details($Company_id,$today);
			// var_dump($data["Voucher_item"]);
			/***************************/
			// echo"Voucher_creation"; Voucher_item
			
			/***********GET Seller Currency******************************/
				$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
				$Symbol_currency = $currency_details->Symbol_of_currency;
				$data['Symbol_currency'] = $Symbol_currency;
			/***********************************/
			
			$data["ActiveVoucher_Records"] = $this->Voucher_model->Get_active_voucher_datails($Company_id,1);
			// var_dump($data["ActiveVoucher_Records"]);
			
			$data["InActiveVoucher_Records"] = $this->Voucher_model->Get_active_voucher_datails($Company_id,0);
			// var_dump($data["InActiveVoucher_Records"]);
			
			if($_GET == NULL)
			{
				$this->load->view('Voucher_creation/Create_voucher_creation', $data);
				
			} 
			else
			{	
				// var_dump($_GET);
				// die;
				$Voucher_id=$_REQUEST["Voucher_id"];
				$data["VoucherDetails"] = $this->Voucher_model->Get_voucher_datails($Voucher_id);
				if($data["VoucherDetails"]){
					
					
					$Voucher_id=$data["VoucherDetails"]->Voucher_id;
					
					 $data["VoucherChildItemDetails"] = $this->Voucher_model->Get_voucher_child_datails($Voucher_id);
					  // var_dump($data["VoucherChildItemDetails"]);
					$this->load->view('Voucher_creation/Edit_create_voucher_creation', $data);
					
				} else {
					
					$this->session->set_flashdata("error_code","Invalid voucher");
					redirect("Voucher_creation");
				}
					// var_dump($data["VoucherDetails"]);
				// 
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function update_voucher(){
		
		// echo"Voucher_creation---index--";
		// die;	 
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
			$data["Redemptionratio"] =$data["Company_details"]->Redemptionratio;
			$Company_Redemptionratio=$data["Company_details"]->Redemptionratio;
			
			/************Get codedecode master*****amit 13-09-2017************/
			$data["Voucher_type_code_decode"] = $this->Voucher_model->Get_voucher_type_code_decode_master($Company_id);
			// var_dump($data["Voucher_type_code_decode"]);
			/***************************/
			
			/************Get codedecode master*****amit 13-09-2017************/
			$today=date("Y-m-d H:i:s");
			$data["Voucher_item"] = $this->Voucher_model->Get_voucher_item_details($Company_id,$today);
			// var_dump($data["Voucher_item"]);
			/***************************/
			// echo"Voucher_creation";
			
			/***********GET Seller Currency******************************/
				$seller_details = $this->Igain_model->get_enrollment_details($data['enroll']);
				$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
				$Symbol_currency = $currency_details->Symbol_of_currency;
				$data['Symbol_currency'] = $Symbol_currency;
			/***********************************/
			
			$data["ActiveVoucher_Records"] = $this->Voucher_model->Get_active_voucher_datails($Company_id,1);
			// var_dump($data["ActiveVoucher_Records"]);
			
			$data["InActiveVoucher_Records"] = $this->Voucher_model->Get_active_voucher_datails($Company_id,0);
			// var_dump($data["InActiveVoucher_Records"]);
			
			if($_POST == NULL)
			{
				$this->load->view('Voucher_creation/Create_voucher_creation', $data);
				
			} 
			else
			{	
				// var_dump($_POST);
				// die;
				
				
				/*-----------------------Check Voucher_code---------------------
					$Voucher_code=$this->input->post('Voucher_code');
					$Validate_voucher_code = $this->Voucher_model->Check_voucher_code($Voucher_code,$Company_id);
					if($Validate_voucher_code > 0 ){
						
						$this->session->set_flashdata("error_code","Provided voucher code already exist");
						redirect("Voucher_creation");
				
					}
				/*-----------------------Check Voucher_code---------------------*/
					
				
				
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
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
						if(isset($_REQUEST["Voucher_id"]))
						{
							$Thumbnail_image4 =$this->input->post("Thumbnail_image4");								
						}
					}
				/*-----------------------------------Image4-----------------------------*/					
			
				/*-----------------------------------Image Upload Code-----------------------------*/
			
			
				
				
					// echo"---Company_Redemptionratio-----".$Company_Redemptionratio."---<br>";
					
					if($this->input->post('Cost_price')){
						$Cost_price=$this->input->post('Cost_price');
					} else {
						$Cost_price=0;
					}
					if($this->input->post('Points')){
						$Points=$this->input->post('Points');
					} else {
						$Points=0;
					}
					
					$Cost_in_points = ($Cost_price * $Company_Redemptionratio);		
					if($Cost_in_points > 0){
						$Cost_in_points=$Cost_in_points;
					} else {
						$Cost_in_points=0;
					}
					
					/* echo"---Cost_price-----".$Cost_price."---<br>";
					echo"---Points-----".$Points."---<br>";
					echo"---Cost_in_points-----".$Cost_in_points."---<br>"; */
					
				// var_dump($_POST);
					
					// echo"---Valid_from-----".$this->input->post('Valid_from')."---<br>";
					// echo"---Valid_till-----".$this->input->post('Valid_till')."---<br>";
					
					$Valid_from=date("Y-m-d",strtotime($this->input->post('Valid_from')));
					$Valid_till=date("Y-m-d",strtotime($this->input->post('Valid_till')));


					$Valid_from = $Valid_from." 00:00:00";
					$Valid_till = $Valid_till." 23:59:59";
					
					// echo"---Valid_from-----".$Valid_from."---<br>";
					// echo"---Valid_till-----".$Valid_till."---<br>";
					/* 	
					
						'Voucher_code'=>$this->input->post('Voucher_code'),
						'Voucher_type'=>$this->input->post('Voucher_type'),	
						'Company_id'=>$this->input->post('Company_id'),
						
					*/
					
					$Voucher_id=$this->input->post('Voucher_id');
					$Update_data=array(
						
						'Valid_from'=>$Valid_from,
						'Valid_till'=>$Valid_till,						
						'Voucher_name'=>$this->input->post('Voucher_name'),
						'Voucher_description'=>$this->input->post('Voucher_description'),						
						'Item_image1'=>$Item_image1,
						'Item_image2'=>$Item_image2,
						'Item_image3'=>$Item_image3,
						'Item_image4'=>$Item_image4,
						'Thumbnail_image1'=>$Thumbnail_image1,
						'Thumbnail_image2'=>$Thumbnail_image2,
						'Thumbnail_image3'=>$Thumbnail_image3,
						'Thumbnail_image4'=>$Thumbnail_image4,
						'Cost_price'=>$Cost_price,
						'Cost_in_points'=>$Cost_in_points,
						'Billing_price'=>$Cost_price,
						'Billing_price_in_points'=>$Cost_in_points,						
						'Update_User_id'=>$data['enroll'],
						'Update_date'=>date("Y-m-d H:i:s"),
						'Active_flag'=>$this->input->post('show_item')
					);
					
					$result = $this->Voucher_model->update_voucher($Voucher_id,$Update_data);
					// var_dump($result);
					// die;
			
					if($result)
					{						
						$POS_item=$this->input->post('POS_item');
							
							/* echo"------<br><br>";
							var_dump($POS_item);
							echo"------<br><br>"; */
						
						if($POS_item){
							
							$DeleteProductVoucherItemChild = $this->Voucher_model->delete_product_voucher_item_child($Company_id,$POS_item,$Voucher_id,$this->input->post('Voucher_type'),$this->input->post('Voucher_code'));
							// die;
							for($i=0; $i<count($POS_item); $i++){
								
								// echo"----POS_item-----".$POS_item[$i]."---<br>";
								$today=date("Y-m-d H:i:s");
								
								$Merchandize_Item_details = $this->Voucher_model->Get_Merchandize_Item_details($POS_item[$i],$today);
								$CheckProductVoucherItemChild = $this->Voucher_model->Check_product_voucher_item_child($Company_id,$POS_item[$i],$Voucher_id,$this->input->post('Voucher_type'),$this->input->post('Voucher_code'));
								
								// echo"----CheckVoucherItemChild-----".$CheckProductVoucherItemChild."---<br>";
								$Voucher_child_id=$CheckProductVoucherItemChild->Voucher_child_id;
								// echo"----Voucher_child_id-----".$CheckProductVoucherItemChild->Voucher_child_id."---<br>";
								// var_dump($CheckProductVoucherItemChild);
								if($CheckProductVoucherItemChild){									
									
									// echo"----Update--<br>";
									
									$update_child_data=array(
									
										'Voucher_type'=>$this->input->post('Voucher_type'),
										'Voucher_code'=>$this->input->post('Voucher_code'),									
										'Company_merchandise_item_id'=>$Merchandize_Item_details->Company_merchandise_item_id,
										'Company_merchandize_item_code'=>$Merchandize_Item_details->Company_merchandize_item_code,
										'Valid_from'=>$Valid_from,
										'Valid_till'=>$Valid_till,	
										'Active_flag'=>$this->input->post('show_item'),
										'Update_User_id'=>$data['enroll'],
										'Update_date'=>date("Y-m-d H:i:s")
									
									);								
									$result_child = $this->Voucher_model->update_voucher_child($Voucher_child_id,$Voucher_id,$update_child_data);
									
									
								} else {
									
									
									
									// echo"----Insert---<br>";
									
									// echo"----CheckVoucherItemChild-----".$CheckVoucherItemChild."---<br>";
									
									$Post_child_data=array(
										'Company_id'=>$Company_id,
										'Voucher_id'=>$Voucher_id,
										'Voucher_type'=>$this->input->post('Voucher_type'),
										'Voucher_code'=>$this->input->post('Voucher_code'),
										'Company_merchandise_item_id'=>$Merchandize_Item_details->Company_merchandise_item_id,
										'Company_merchandize_item_code'=>$Merchandize_Item_details->Company_merchandize_item_code,
										'Valid_from'=>$Valid_from,
										'Valid_till'=>$Valid_till,
										'Active_flag'=>$this->input->post('show_item'),						
										'Create_User_id'=>$data['enroll'],
										'Creation_date'=>date("Y-m-d H:i:s"),
										'Update_User_id'=>$data['enroll'],
										'Update_date'=>date("Y-m-d H:i:s")


											
									);	
									// var_dump($Post_child_data);
									$result_child = $this->Voucher_model->Insert_voucher_child($Post_child_data);
									
									
									
									
								}
								
								
							} 
							
						} else {
							
								
								$CheckRevenueVoucher= $this->Voucher_model->Check_revenue_voucher_child($Company_id,$Voucher_id,$this->input->post('Voucher_type'),$this->input->post('Voucher_code'));
								// var_dump($CheckRevenueVoucher);
								$update_child_data=array(
									'Cost_price'=>$Cost_price,
									'Cost_in_points'=>$Cost_in_points,
									'Valid_from'=>$Valid_from,
									'Valid_till'=>$Valid_till,
									'Active_flag'=>$this->input->post('show_item'),
									'Update_User_id'=>$data['enroll'],
									'Update_date'=>date("Y-m-d H:i:s")
									
								);								
								$result_child = $this->Voucher_model->update_voucher_child($CheckRevenueVoucher->Voucher_child_id,$Voucher_id,$update_child_data);
						}	
							
						
						/*******************Insert igain Log Table*********************/
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 2;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Update Voucher";
							$where="Update Voucher";
							$toname="";
							$To_enrollid =0;
							$firstName = '';
							$lastName = '';
							$Seller_name = $session_data['Full_name'];
							$opval = $this->input->post('Voucher_name');
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$enroll);
						/*******************Insert igain Log Table*********************/
						
						$this->session->set_flashdata("data_code",$this->upload->display_errors());
						$this->session->set_flashdata("success_code"," ".$this->input->post('Voucher_name')." Voucher Updated Successfuly!!");
					}
					else
					{
						$this->session->set_flashdata("error_code","Error updating ".$this->input->post('Voucher_name')." voucher");
					}			
					redirect("Voucher_creation");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	function Check_voucher_code()
	{
		$result = $this->Voucher_model->Check_voucher_code($this->input->post("Voucher_code"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			echo "1";
		}
		else    
		{
			echo "0";
		}
	}
	function InActive_voucher()
	{
		$session_data = $this->session->userdata('logged_in');
		$Update_user_id = $session_data['enroll'];
		$Update_date=date("Y-m-d H:i:s");
		
		$Voucher_id=$_REQUEST["Voucher_id"];
		
		$result = $this->Voucher_model->InActive_voucher($Voucher_id,$Update_user_id,$Update_date);
		if($result == true)
		{
			$this->session->set_flashdata("success_code","Voucher Deleted Successfuly");
		}
		else
		{
			$this->session->set_flashdata("error_code","Error Deleting Voucher");
		}
		redirect("Voucher_creation");
	}
	function Get_voucher_details()
	{	
		$VoucherType =  $_REQUEST['VoucherType'];	
		$Company_id =  $_REQUEST['Company_id'];	
		$Todays_date=date("Y-m-d H:i:s");
		
		$data['VoucherDetails'] = $this->Voucher_model->Get_voucher_details($VoucherType,$Company_id,$Todays_date);
		if($data['VoucherDetails']){
			echo json_encode($data['VoucherDetails']);
		} else {
			echo json_encode(0);
		}
		
		
		/* $this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('VoucherDetails'=>$data['VoucherDetails']))); */	
		
		/* 	$theHTMLResponse = $this->load->view('administration/Show_segment_criteria', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Criteria_data'=> $theHTMLResponse)));	 */
	}
	
}	
?>