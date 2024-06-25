<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_setting extends CI_Controller 
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
		$this->load->model('enrollment/Enroll_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('Igain_model');
		$this->load->model('General_setting_model');
		$this->load->model('master/currency_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
		$this->load->library('Send_notification');
		$this->load->model('TierM/Tier_model');	
		$this->load->model('Coal_transactions/Coal_Transactions_model');
	}
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			// $this->output->enable_profiler(true);
			$session_data = $this->session->userdata('logged_in');
			
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$Company_id = $session_data['Company_id'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$data["Sellers_details"] = $this->Igain_model->get_company_sellers($Company_id);
				
			
			/* if($this->input->post('Seller_id')){
				$Seller_id= $this->input->post('Seller_id');
			} else{ 
				$Seller_id=0;
			} */
			$Seller_id=0;
			
			// echo"----Seller_id---".$Seller_id."---<>";
			// die;
			/*-----------------------Pagination---------------------*/		
			// $this->output->enable_profiler(true);			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Enrollmentc/enrollment";
			
			if($data['userId'] == '3' && $session_data['Company_id'] == '1')
			{
				$total_row = $this->General_setting_model->template_count();
				
			}
			else
			{
				$total_row = $this->General_setting_model->Company_template_count($session_data['Company_id'],$Seller_id);
			}
			
			
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
			
			$data["Template_details"] = $this->General_setting_model->Company_template_details($session_data['Company_id'],$config["per_page"], $page);
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/icons/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '1500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			
			$configThumb = array();
			$configThumb['image_library'] = 'gd2';
			$configThumb['source_image'] = '';
			$configThumb['create_thumb'] = TRUE;
			$configThumb['maintain_ratio'] = TRUE;			
			$configThumb['width'] = 128;
			$configThumb['height'] = 128;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/* Load the image library */
			$this->load->library('image_lib');
			
			
			$data["Fontfamily"] = $this->Igain_model->get_font_family($session_data['Company_id']);
			
			if($_POST == NULL)
			{
				$this->load->view('General_setting/General_setting_view', $data);
			}
			else
			{
				
				
				
				$Count_mobile_template = $this->input->post('Count_mobile_template');
				$Seller_id = $this->input->post('Seller_id');
				
				$Count_mobile_template = $this->General_setting_model->Company_template_count($session_data['Company_id'],$Seller_id);
				// echo"---Count_mobile_template----".$Count_mobile_template."----<br>";
				// var_dump($_POST);
				// die;
				// -------------------------------Application Title , Application Color & Header Colour ---------------------------//	
					
					$General[] = array(	'Application_title'  => $this->input->post('Application_title'),
										'Application_image_flag'  => $this->input->post('Application_image_flag'),
										'Theme_color'  => $this->input->post('Theme_color'),
										'Header_color'  => $this->input->post('Header_color'),
										'Header_color_opacity'  => $this->input->post('Header_color_opacity'),
										'Header_transparent'  => $this->input->post('Header_transparent'),
										'Theme_icon_color'  => $this->input->post('Theme_icon_color') 
										);
					$General_details = json_encode($General);
					 
					$General_Setting = array(
											'Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
                                            'type'  	  => 'General', 
                                            'value'       => $General_details
                                            );
					if($Count_mobile_template == 0 ){						
						
						$result = $this->db->insert('frontend_settings', $General_Setting);
					}
					else {
						
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'General'));
						$result = $this->db->update('frontend_settings', $General_Setting);
					}
					
				// ------------------------------------Application Title, Application Color & Header Colour -------------------------------- //
				
				
				// ------------------------------------application------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("application"))
						{			
							// $filepath = "images/No_Profile_Image.jpg";
							$application_filepath = "";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$application_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
											
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');						
						$upload77 = $this->upload->do_upload('application');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$application_filepath='uploads/icons/'.$data77['file_name'];
							
						}
						else
						{				
							$application_filepath = "";				
						}
						
						$application_data = array( 	'Company_id'  => $this->input->post('Company_id'),
													'Seller_id'  => $this->input->post('Seller_id'),
													'type'  	  => 'application', 
													'value'       => $application_filepath );
						$result = $this->db->insert('frontend_settings', $application_data); 
					}
					else 
					{
						
						/* if(!$this->upload->do_upload("application"))
						{			
							$application_filepath = $this->input->post('Theme_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$application_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
							
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('application');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$application_filepath='uploads/icons/'.$data77['file_name'];
							
						}
						else
						{				
							$application_filepath = $this->input->post('Theme_image_hdn');			
						}
						
						$application_data = array( 	'Company_id'  => $this->input->post('Company_id'),
													'Seller_id'  => $this->input->post('Seller_id'),
													'type'  	  => 'application', 
													'value'       => $application_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'application'));
						$result = $this->db->update('frontend_settings', $application_data);
					}
					
				// ------------------------------------application------------------------------------ //
	
				// ------------------------------------dashboard------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("dashboard"))
						{			
							$dashboard_filepath = "images/icon/template_icon/dashboard.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$dashboard_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('dashboard');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$dashboard_filepath='uploads/icons/'.$data77['file_name'];
							
						}
						else
						{				
							$dashboard_filepath = "images/icon/template_icon/dashboard.png";			
						}
						
						
						$dashboard_data = array(	'Company_id'  => $this->input->post('Company_id'),
													'Seller_id'  => $this->input->post('Seller_id'),
													'type'  	  => 'dashboard', 
													'value'       => $dashboard_filepath );
						$result = $this->db->insert('frontend_settings', $dashboard_data);
					}
					else 
					{
						
						/* if(!$this->upload->do_upload("dashboard"))
						{			
							$application_filepath = $this->input->post('dashboard_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$application_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('dashboard');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$dashboard_filepath='uploads/icons/'.$data77['file_name'];
							
						}
						else
						{				
							$dashboard_filepath = $this->input->post('dashboard_image_hdn');			
						}
						
						$application_data = array( 	'Company_id'  => $this->input->post('Company_id'),
													'Seller_id'  => $this->input->post('Seller_id'),
													'type'  	  => 'dashboard', 
													'value'       => $dashboard_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'dashboard'));
						$result = $this->db->update('frontend_settings', $application_data);
						
					}
					
					
				// ------------------------------------dashboard------------------------------------ //
				
				// ------------------------------------profile------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("profile"))
						{			
							$profile_filepath = "images/icon/template_icon/profile.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$profile_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('profile');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$profile_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$profile_filepath = "images/icon/template_icon/profile.png";		
						}
						
						$profile_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'profile', 
												'value'       => $profile_filepath );
						$result = $this->db->insert('frontend_settings', $profile_data);
					}
					else {
						
									
						/* if(!$this->upload->do_upload("profile"))
						{			
							$profile_filepath = $this->input->post('profile_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$profile_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('profile');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$profile_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$profile_filepath = $this->input->post('profile_image_hdn');		
						}
						
						$profile_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'profile', 
												'value'       => $profile_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'profile'));
						$result = $this->db->update('frontend_settings', $profile_data);
						
					}
				// ------------------------------------profile------------------------------------ //
				
				// ------------------------------------shopping------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("shopping"))
						{			
							$shopping_filepath = "images/icon/template_icon/shopping.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$shopping_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('shopping');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$shopping_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$shopping_filepath = $this->input->post('profile_image_hdn');		
						}
						
						$shopping_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'shopping', 
												'value'       => $shopping_filepath );
						$result = $this->db->insert('frontend_settings', $shopping_data);
					}
					else {						
									
						/* if(!$this->upload->do_upload("shopping"))
						{			
							$shopping_filepath =  $this->input->post('shopping_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$shopping_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('shopping');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$shopping_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$shopping_filepath =  $this->input->post('shopping_image_hdn');		
						}
						
						$shopping_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'shopping', 
												'value'       => $shopping_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'shopping'));
						$result = $this->db->update('frontend_settings', $shopping_data);
						
					}
				// ------------------------------------shopping------------------------------------ //
				
				// ------------------------------------redeem------------------------------------ //
					if($Count_mobile_template == 0 ) {
					
						/* if(!$this->upload->do_upload("redeem"))
						{			
							$redeem_filepath = "images/icon/template_icon/redeem.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$redeem_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('redeem');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$redeem_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$redeem_filepath = "images/icon/template_icon/redeem.png";		
						}
						
						$redeem_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'redeem', 
												'value'       => $redeem_filepath );
						$result = $this->db->insert('frontend_settings', $redeem_data);
					}
					else {						
									
						/* if(!$this->upload->do_upload("redeem"))
						{			
							$redeem_filepath = $this->input->post('redeem_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$redeem_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('redeem');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$redeem_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$redeem_filepath = $this->input->post('redeem_image_hdn');		
						}
						
						$redeem_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'redeem', 
												'value'       => $redeem_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'redeem'));
						$result = $this->db->update('frontend_settings', $redeem_data);
						
					}
				// ------------------------------------redeem------------------------------------ //
				
				// ------------------------------------offers------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("offers"))
						{			
							$offers_filepath = "images/icon/template_icon/offers.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$offers_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('offers');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$offers_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$offers_filepath = "images/icon/template_icon/offers.png";	
						}
						
						$offers_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'offers', 
												'value'       => $offers_filepath );
						$result = $this->db->insert('frontend_settings', $offers_data);
					}
					else {						
									
						/* if(!$this->upload->do_upload("offers"))
						{			
							$offers_filepath = $this->input->post('offers_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$offers_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('offers');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$offers_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$offers_filepath = $this->input->post('offers_image_hdn');	
						}
						
						$offers_data = array(	'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'offers', 
												'value'       => $offers_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'offers'));
						$result = $this->db->update('frontend_settings', $offers_data);
						
					}
				// ------------------------------------offers------------------------------------ //
				
				// ------------------------------------transfer_points------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("transfer_points"))
						{			
							$transfer_points_filepath = "images/icon/template_icon/points.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$transfer_points_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('transfer_points');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$transfer_points_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$transfer_points_filepath = "images/icon/template_icon/points.png";	
						}
						
						$transfer_points_data = array(	
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'transfer_points', 
												'value'       => $transfer_points_filepath );
						$result = $this->db->insert('frontend_settings', $transfer_points_data);
					}
					else {
						
						/* if(!$this->upload->do_upload("transfer_points"))
						{			
							$transfer_points_filepath = $this->input->post('points_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$transfer_points_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('transfer_points');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$transfer_points_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$transfer_points_filepath = $this->input->post('points_image_hdn');
						}
						
						$transfer_points_data = array(	
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'transfer_points', 
												'value'       => $transfer_points_filepath );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'transfer_points'));
						$result = $this->db->update('frontend_settings', $transfer_points_data);
						
					}
				// ------------------------------------transfer_points------------------------------------ //
				
				// ------------------------------------transfer_across------------------------------------ //
				if($Count_mobile_template == 0 ) {
					
					/* if(!$this->upload->do_upload("transfer_across"))
					{			
						$transfer_across_filepath = "images/icon/template_icon/across.png";
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$transfer_across_filepath = "uploads/icons/".$data['upload_data']['file_name'];
					} */
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/* Load the image library */
					$this->load->library('image_lib');
					
					
					$upload77 = $this->upload->do_upload('transfer_across');
					$data77 = $this->upload->data();			   
					if($data77['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data77['full_path'];
						$configThumb['source_image'] = './uploads/icons/'.$upload77;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$transfer_across_filepath='uploads/icons/'.$data77['file_name'];							
					}
					else
					{				
						$transfer_across_filepath = "images/icon/template_icon/across.png";
					}
					
					$transfer_across_data = array( 'Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'transfer_across', 
											'value'       => $transfer_across_filepath );
					$result = $this->db->insert('frontend_settings', $transfer_across_data);
				}
				else {
					
					/* if(!$this->upload->do_upload("transfer_across"))
					{			
						$transfer_across_filepath = $this->input->post('transfer_across_image_hdn');
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$transfer_across_filepath = "uploads/icons/".$data['upload_data']['file_name'];
					} */
					
					$configThumb = array();
					$configThumb['image_library'] = 'gd2';
					$configThumb['source_image'] = '';
					$configThumb['create_thumb'] = TRUE;
					$configThumb['maintain_ratio'] = TRUE;			
					$configThumb['width'] = 128;
					$configThumb['height'] = 128;
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					/* Load the image library */
					$this->load->library('image_lib');
					
					$upload77 = $this->upload->do_upload('transfer_across');
					$data77 = $this->upload->data();			   
					if($data77['is_image'] == 1) 
					{						 
						$configThumb['source_image'] = $data77['full_path'];
						$configThumb['source_image'] = './uploads/icons/'.$upload77;
						$this->image_lib->initialize($configThumb);
						$this->image_lib->resize();
						$transfer_across_filepath='uploads/icons/'.$data77['file_name'];							
					}
					else
					{				
						$transfer_across_filepath = $this->input->post('transfer_across_image_hdn');
					}
					
					$transfer_across_data = array( 'Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'transfer_across', 
											'value'       => $transfer_across_filepath );
					$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'transfer_across'));
					$result = $this->db->update('frontend_settings', $transfer_across_data);
					
				}
				// ------------------------------------transfer_across------------------------------------ //
				
				// ------------------------------------games icon------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("games"))
						{			
							$games_filepath = "images/icon/template_icon/games.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$games_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('games');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$games_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$games_filepath = "images/icon/template_icon/games.png";
						}
						$games_data = array( 'Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'games', 
											'value'       => $games_filepath );
						$result = $this->db->insert('frontend_settings', $games_data);
						
					} else {
						
						/* if(!$this->upload->do_upload("games"))
						{			
							$games_filepath = $this->input->post('games_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$games_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('games');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$games_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$games_filepath = $this->input->post('games_image_hdn');
						}
						
						$games_data = array( 'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'games', 
											'value'       => $games_filepath );
						
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'games'));
						$result = $this->db->update('frontend_settings', $games_data);
						
					}
				// ------------------------------------games icon------------------------------------ //
				
				// ------------------------------------survey------------------------------------ //	
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("survey"))
						{			
							$survey_filepath = "images/icon/template_icon/survey.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$survey_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('survey');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$survey_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$survey_filepath = "images/icon/template_icon/survey.png";
						}	
						
						$survey_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'survey', 
											'value'       => $survey_filepath
										   );
						$result = $this->db->insert('frontend_settings', $survey_data);
					
					} else {
						
						/* if(!$this->upload->do_upload("survey"))
						{			
							$survey_filepath = $this->input->post('survey_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$survey_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						$upload77 = $this->upload->do_upload('survey');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$survey_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$survey_filepath = $this->input->post('survey_image_hdn');
						}
						
						$survey_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'survey', 
											'value'       => $survey_filepath
										   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'survey'));
						$result = $this->db->update('frontend_settings', $survey_data);
						
					}
				// ------------------------------------survey------------------------------------ //
				
				// ------------------------------------notification------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("notification"))
						{			
							$notification_filepath = "images/icon/template_icon/notification.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$notification_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('notification');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$notification_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$notification_filepath = "images/icon/template_icon/notification.png";
						}
						
						$notification_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'notification', 
											'value'       => $notification_filepath
										   );
						$result = $this->db->insert('frontend_settings', $notification_data);
					
					} else {
						
						/* if(!$this->upload->do_upload("notification"))
						{			
							$notification_filepath = $this->input->post('notification_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$notification_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('notification');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$notification_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$notification_filepath = $this->input->post('notification_image_hdn');
						}
						
						$notification_data = array('Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'notification', 
											'value'       => $notification_filepath
										   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'notification'));
						$result = $this->db->update('frontend_settings', $notification_data);						
					}
				// ------------------------------------notification------------------------------------ //
				
				// ------------------------------------statement------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("statement"))
						{			
							$statement_filepath = "images/icon/template_icon/statement.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$statement_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('statement');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$statement_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$statement_filepath = "images/icon/template_icon/statement.png";
						}
						
						$statement_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'statement', 
											'value'       => $statement_filepath
										   );
						$result = $this->db->insert('frontend_settings', $statement_data);
						
					} else {
						
						/* if(!$this->upload->do_upload("statement"))
						{			
							$statement_filepath = $this->input->post('statement_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$statement_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('statement');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$statement_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$statement_filepath = $this->input->post('statement_image_hdn');
						}
						$statement_data = array('Company_id'  => $this->input->post('Company_id'),
										'Seller_id'  => $this->input->post('Seller_id'),
										'type'  	  => 'statement', 
										'value'       => $statement_filepath
									   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'statement'));
						$result = $this->db->update('frontend_settings', $statement_data);						
					}
				// ------------------------------------statement------------------------------------ //
				
				// ------------------------------------call_center------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("call_center"))
						{			
							$call_center_filepath = "images/icon/template_icon/call_center.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$call_center_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('call_center');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$call_center_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$call_center_filepath = "images/icon/template_icon/call_center.png";
						}
						
						$call_center_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'call_center', 
											'value'       => $call_center_filepath
										   );
						$result = $this->db->insert('frontend_settings', $call_center_data);
						
					} else {
						
						/* if(!$this->upload->do_upload("call_center"))
						{			
							$call_center_filepath =  $this->input->post('call_center_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$call_center_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('call_center');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$call_center_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$call_center_filepath =  $this->input->post('call_center_image_hdn');
						}
						$call_center_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'call_center', 
											'value'       => $call_center_filepath
										   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'call_center'));
						$result = $this->db->update('frontend_settings', $call_center_data);						
					}					
				// ------------------------------------call_center------------------------------------ //
				
				// ------------------------------------contact------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("contact"))
						{			
							$contact_filepath = "images/icon/template_icon/contact.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$contact_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						
						$upload77 = $this->upload->do_upload('contact');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$contact_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$contact_filepath = "images/icon/template_icon/contact.png";
						}
						$contact_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'contact', 
											'value'       => $contact_filepath
										   );
						$result = $this->db->insert('frontend_settings', $contact_data);
						
					} else {
						
						/* if(!$this->upload->do_upload("contact"))
						{			
							$contact_filepath = $this->input->post('contact_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$contact_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						
						$upload77 = $this->upload->do_upload('contact');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$contact_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$contact_filepath = $this->input->post('contact_image_hdn');
						}
						$contact_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'contact', 
											'value'       => $contact_filepath
										   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'contact'));
						$result = $this->db->update('frontend_settings', $contact_data);						
					}
					//var_dump($contact_data);
				// ------------------------------------contact------------------------------------ //
				
				
				
				// ------------------------------------Add_membership------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("membership"))
						{			
							$membership_filepath = "images/icon/template_icon/membership.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$membership_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
			
			
						$upload77 = $this->upload->do_upload('membership');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$membership_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$membership_filepath = "images/icon/template_icon/membership.png";
						}
						$membership_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'Add_membership', 
											'value'       => $membership_filepath
										   );
						$result = $this->db->insert('frontend_settings', $membership_data);
						
					} else {
						
						/* if(!$this->upload->do_upload("membership"))
						{			
							$membership_filepath = $this->input->post('membership_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$membership_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
			
						$upload77 = $this->upload->do_upload('membership');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$membership_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$membership_filepath = $this->input->post('membership_image_hdn');
						}
						$membership_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'Add_membership', 
											'value'       => $membership_filepath
										   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Add_membership'));
						$result = $this->db->update('frontend_settings', $membership_data);						
					}
					
				// ------------------------------------Add_membership------------------------------------ //
				
				/*------------------------------------Buy_miles------------------------------------*/
					if($Count_mobile_template == 0 ) {
						
						/* if(!$this->upload->do_upload("Buy_miles_image"))
						{			
							$Buy_miles_filepath = "images/icon/template_icon/buywithjoy.png";
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$Buy_miles_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
						
						$upload77 = $this->upload->do_upload('Buy_miles_image');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$Buy_miles_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$Buy_miles_filepath = "images/icon/template_icon/buywithjoy.png";
						}
						
						$Buy_miles_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'Buy_miles', 
											'value'       => $Buy_miles_filepath
										   );
						$result = $this->db->insert('frontend_settings', $Buy_miles_data);
						
					} else {
						
						/* if(!$this->upload->do_upload("Buy_miles_image"))
						{			
							$Buy_miles_filepath = $this->input->post('Buy_miles_image_hdn');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data("file"));
							$Buy_miles_filepath = "uploads/icons/".$data['upload_data']['file_name'];
						} */
						
						$configThumb = array();
						$configThumb['image_library'] = 'gd2';
						$configThumb['source_image'] = '';
						$configThumb['create_thumb'] = TRUE;
						$configThumb['maintain_ratio'] = TRUE;			
						$configThumb['width'] = 128;
						$configThumb['height'] = 128;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						/* Load the image library */
						$this->load->library('image_lib');
			
						$upload77 = $this->upload->do_upload('Buy_miles_image');
						$data77 = $this->upload->data();			   
						if($data77['is_image'] == 1) 
						{						 
							$configThumb['source_image'] = $data77['full_path'];
							$configThumb['source_image'] = './uploads/icons/'.$upload77;
							$this->image_lib->initialize($configThumb);
							$this->image_lib->resize();
							$Buy_miles_filepath='uploads/icons/'.$data77['file_name'];							
						}
						else
						{				
							$Buy_miles_filepath = $this->input->post('Buy_miles_image_hdn');
						}
						$Buy_miles_data = array('Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
											'type'  	  => 'Buy_miles', 
											'value'       => $Buy_miles_filepath
										   );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Buy_miles'));
						$result = $this->db->update('frontend_settings', $Buy_miles_data);						
					}
					
				/*------------------------------------Buy_miles------------------------------------*/
				
			
								
				// ------------------------------------Small Font------------------------------------ //
				
					if($Count_mobile_template == 0 ) {
						
						$Small_font[] = array(	'Small_font_color'  => $this->input->post('Small_font_color'),
												'Small_font_family'  => $this->input->post('Small_font_family'),
												'Small_font_size'  => $this->input->post('Small_font_size')
												);
						$Small_font_details = json_encode($Small_font);
						 
						$Small_Font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Small_font', 
												'value'       => $Small_font_details
												);
						$result = $this->db->insert('frontend_settings', $Small_Font_Setting);
				
					} else {
						
						$Small_font[] = array(	'Small_font_color'  => $this->input->post('Small_font_color'),
												'Small_font_family'  => $this->input->post('Small_font_family'),
												'Small_font_size'  => $this->input->post('Small_font_size')
												);
						$Small_font_details = json_encode($Small_font);
						 
						$Small_Font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Small_font', 
												'value'       => $Small_font_details
												);
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Small_font'));
						$result = $this->db->update('frontend_settings', $Small_Font_Setting);						
					}
				// ------------------------------------Small Font------------------------------------ //
			
				// ------------------------------------Medium Font------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						$Medium_font[] = array(	'Medium_font_color'  => $this->input->post('Medium_font_color'),
												'Medium_font_family'  => $this->input->post('Medium_font_family'),
												'Medium_font_size'  => $this->input->post('Medium_font_size')
												);
						 $Medium_font_details = json_encode($Medium_font);
						 
						$Medium_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Medium_font', 
												'value'       => $Medium_font_details
												);
						$result = $this->db->insert('frontend_settings', $Medium_font_Setting);
					
					} else {
						
						$Medium_font[] = array(	'Medium_font_color'  => $this->input->post('Medium_font_color'),
												'Medium_font_family'  => $this->input->post('Medium_font_family'),
												'Medium_font_size'  => $this->input->post('Medium_font_size')
												);
						 $Medium_font_details = json_encode($Medium_font);
						 
						$Medium_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Medium_font', 
												'value'       => $Medium_font_details
												);
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Medium_font'));
						$result = $this->db->update('frontend_settings', $Medium_font_Setting);						
					}
				// ------------------------------------Medium Font------------------------------------ //				
				
				// ------------------------------------Large Font------------------------------------ //
				
					if($Count_mobile_template == 0 ) {
					
						$Large_font[] = array(	'Large_font_color'  => $this->input->post('Large_font_color'),
												'Large_font_family'  => $this->input->post('Large_font_family'),
												'Large_font_size'  => $this->input->post('Large_font_size')
												);
						 $Large_font_details = json_encode($Large_font);
						 
						$Large_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Large_font', 
												'value'       => $Large_font_details
												);
						$result = $this->db->insert('frontend_settings', $Large_font_Setting);
						
					} else {
							
							$Large_font[] = array(	'Large_font_color'  => $this->input->post('Large_font_color'),
												'Large_font_family'  => $this->input->post('Large_font_family'),
												'Large_font_size'  => $this->input->post('Large_font_size')
												);
							$Large_font_details = json_encode($Large_font);
						 
							$Large_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Large_font', 
												'value'       => $Large_font_details
												);
							$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Large_font'));
							$result = $this->db->update('frontend_settings', $Large_font_Setting);						
					}
				// ------------------------------------Large Font------------------------------------ //
				
				// ------------------------------------Extra large Font------------------------------------ //
				
					if($Count_mobile_template == 0 ) {
					
						$Extra_large_font[] = array('Extra_large_font_color'  => $this->input->post('Extra_large_font_color'),
													'Extra_large_font_family'  => $this->input->post('Extra_large_font_family'),
													'Extra_large_font_size'  => $this->input->post('Extra_large_font_size') );
						$Extra_large_font_details = json_encode($Extra_large_font);
						 
						$Extra_large_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Extra_large_font', 
												'value'       => $Extra_large_font_details
												);
						$result = $this->db->insert('frontend_settings', $Extra_large_font_Setting);
						
					} else {
							
						$Extra_large_font[] = array('Extra_large_font_color'  => $this->input->post('Extra_large_font_color'),
													'Extra_large_font_family'  => $this->input->post('Extra_large_font_family'),
													'Extra_large_font_size'  => $this->input->post('Extra_large_font_size') );
						 $Extra_large_font_details = json_encode($Extra_large_font);
						 
						$Extra_large_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Extra_large_font', 
												'value'       => $Extra_large_font_details
												);
							$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Extra_large_font'));
							$result = $this->db->update('frontend_settings', $Extra_large_font_Setting);						
					}
				// ------------------------------------Extra large Font------------------------------------ //
				
				// ------------------------------------Value Font---------------------------------------- //
					if($Count_mobile_template == 0 ) {
				
						$Value_font[] = array(	'Value_font_color'  => $this->input->post('Value_font_color'),
												'Value_font_family'  => $this->input->post('Value_font_family'),
												'Value_font_size'    => $this->input->post('Value_font_size') );
						$Value_font_details = json_encode($Value_font);
						 
						$Value_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Value_font', 
												'value'       => $Value_font_details
												);
						$result = $this->db->insert('frontend_settings', $Value_font_Setting);
					
					} else {
							
						$Value_font[] = array(	'Value_font_color'  => $this->input->post('Value_font_color'),
												'Value_font_family'  => $this->input->post('Value_font_family'),
												'Value_font_size'    => $this->input->post('Value_font_size') );
						
						$Value_font_details = json_encode($Value_font);
						 
						$Value_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Value_font', 
												'value'       => $Value_font_details
												);
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Value_font'));
						$result = $this->db->update('frontend_settings', $Value_font_Setting);						
					}
				// ------------------------------------Value Font------------------------------------ //
				
				// ------------------------------------Footer Font---------------------------------------- //
				
				if($Count_mobile_template == 0 ) {
					
					$Footer_font[] = array(	'Footer_font_color'  => $this->input->post('Footer_font_color'),
											'Footer_font_family'  => $this->input->post('Footer_font_family'),
											'Footer_font_size'    => $this->input->post('Footer_font_size'),
											'Footer_background_color'    => $this->input->post('Footer_background_color') );
                    $Footer_font_details = json_encode($Footer_font);
					 
					$Footer_font_Setting = array(
											'Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
                                            'type'  	  => 'Footer_font', 
                                            'value'       => $Footer_font_details
                                            );
					$result = $this->db->insert('frontend_settings', $Footer_font_Setting);
					
				} else {
							
						$Footer_font[] = array(	'Footer_font_color'  => $this->input->post('Footer_font_color'),
											'Footer_font_family'  => $this->input->post('Footer_font_family'),
											'Footer_font_size'    => $this->input->post('Footer_font_size'),
											'Footer_background_color'    => $this->input->post('Footer_background_color') );
						$Footer_font_details = json_encode($Footer_font);
					 
						$Footer_font_Setting = array(
											'Company_id'  => $this->input->post('Company_id'),
											'Seller_id'  => $this->input->post('Seller_id'),
                                            'type'  	  => 'Footer_font', 
                                            'value'       => $Footer_font_details
                                            );
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Footer_font'));
						$result = $this->db->update('frontend_settings', $Footer_font_Setting);						
					}
				// ------------------------------------Footer Font------------------------------------ //
				
				
				
				// ------------------------------------Button Font------------------------------------ //
					if($Count_mobile_template == 0 ) {
						
						$Button_font[] = array('Button_font_color'  => $this->input->post('Button_font_color'),
												'Button_background_color'  => $this->input->post('Button_background_color'),
												'Button_border_color'  => $this->input->post('Button_border_color'),
												'Button_font_family'  => $this->input->post('Button_font_family'),
												'Button_font_size'  => $this->input->post('Button_font_size')
												);
						$Button_font_details = json_encode($Button_font);
						 
						$Button_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Button_font', 
												'value'       => $Button_font_details
												);
						$result = $this->db->insert('frontend_settings', $Button_font_Setting);
						
					} else {
							
						$Button_font[] = array('Button_font_color'  => $this->input->post('Button_font_color'),
												'Button_background_color'  => $this->input->post('Button_background_color'),
												'Button_border_color'  => $this->input->post('Button_border_color'),
												'Button_font_family'  => $this->input->post('Button_font_family'),
												'Button_font_size'  => $this->input->post('Button_font_size')
												);
						$Button_font_details = json_encode($Button_font);
						 
						$Button_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Button_font', 
												'value'       => $Button_font_details
												);
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Button_font'));
						$result = $this->db->update('frontend_settings', $Button_font_Setting);						
					}
				// ------------------------------------Button Font--------------------------------------- //
				
				// ------------------------------------Placeholder Font------------------------------------ //
					if($Count_mobile_template == 0 ) {
				
						$Placeholder_font[] = array('Placeholder_font_color'  => $this->input->post('Placeholder_font_color'),
													'Placeholder_font_family'  => $this->input->post('Placeholder_font_family'),
													'Placeholder_font_size'  => $this->input->post('Placeholder_font_size'));
						 $Placeholder_font_details = json_encode($Placeholder_font);
						 
						$Placeholder_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Placeholder_font', 
												'value'       => $Placeholder_font_details
												);
						$result = $this->db->insert('frontend_settings', $Placeholder_font_Setting);
						
					} else {
							
						$Placeholder_font[] = array('Placeholder_font_color'  => $this->input->post('Placeholder_font_color'),
													'Placeholder_font_family'  => $this->input->post('Placeholder_font_family'),
													'Placeholder_font_size'  => $this->input->post('Placeholder_font_size'));
						 $Placeholder_font_details = json_encode($Placeholder_font);
						 
						$Placeholder_font_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Placeholder_font', 
												'value'       => $Placeholder_font_details
												);
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Placeholder_font'));
						$result = $this->db->update('frontend_settings', $Placeholder_font_Setting);						
					}
				// ------------------------------------Placeholder Font------------------------------------ //
				
				// ------------------------------------Menu Access------------------------------------ //
					if($Count_mobile_template == 0 ) {
				
						$Menu_access[] = array(	'Dashboard_flag'  => $this->input->post('Dashboard_flag'),
												'Profile_flag'  => $this->input->post('Profile_flag'),
												'Offer_flag'  => $this->input->post('Offer_flag'),
												'Ecommerce_flag'  => $this->input->post('Ecommerce_flag'),
												'Redeem_flag'  => $this->input->post('Redeem_flag'),
												'Transfer_flag'  => $this->input->post('Transfer_flag'),
												'Transfer_accross_flag'  => $this->input->post('Transfer_accross_flag'),
												'Survey_flag'  => $this->input->post('Survey_flag'),
												'Notification_flag'  => $this->input->post('Notification_flag'),
												'My_statement_flag'  => $this->input->post('My_statement_flag'),
												'Contact_flag'  => $this->input->post('Contact_flag'),
												'Promo_code_applicable'  => $this->input->post('Promo_code_applicable'),
												'Auction_bidding_applicable'  => $this->input->post('Auction_bidding_applicable'),
												'Call_center_flag'  => $this->input->post('Call_center_flag'),
												'Buy_miles_flag'  => $this->input->post('Buy_miles_flag'),
												'Add_membership_flag'  => $this->input->post('Add_membership_flag'));
						 $Menu_access_details = json_encode($Menu_access);
						 
						$Menu_access_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Menu_access', 
												'value'       => $Menu_access_details
												);
						$result = $this->db->insert('frontend_settings', $Menu_access_Setting);
						
					} else {
							
						$Menu_access[] = array(	'Dashboard_flag'  => $this->input->post('Dashboard_flag'),
												'Profile_flag'  => $this->input->post('Profile_flag'),
												'Offer_flag'  => $this->input->post('Offer_flag'),
												'Ecommerce_flag'  => $this->input->post('Ecommerce_flag'),
												'Redeem_flag'  => $this->input->post('Redeem_flag'),
												'Transfer_flag'  => $this->input->post('Transfer_flag'),
												'Transfer_accross_flag'  => $this->input->post('Transfer_accross_flag'),
												'Survey_flag'  => $this->input->post('Survey_flag'),
												'Notification_flag'  => $this->input->post('Notification_flag'),
												'My_statement_flag'  => $this->input->post('My_statement_flag'),
												'Contact_flag'  => $this->input->post('Contact_flag'),
												'Promo_code_applicable'  => $this->input->post('Promo_code_applicable'),
												'Auction_bidding_applicable'  => $this->input->post('Auction_bidding_applicable'),
												'Call_center_flag'  => $this->input->post('Call_center_flag'),
												'Buy_miles_flag'  => $this->input->post('Buy_miles_flag'),
												'Add_membership_flag'  => $this->input->post('Add_membership_flag'));
						$Menu_access_details = json_encode($Menu_access); 
						$Menu_access_Setting = array(
												'Company_id'  => $this->input->post('Company_id'),
												'Seller_id'  => $this->input->post('Seller_id'),
												'type'  	  => 'Menu_access', 
												'value'       => $Menu_access_details
												);
						$this->db->where(array('Company_id'  => $this->input->post('Company_id'),'Seller_id'  => $this->input->post('Seller_id'),'type'=>'Menu_access'));
						$result = $this->db->update('frontend_settings', $Menu_access_Setting);						
					}
					// echo"<pre>";
					// var_dump($Menu_access);
					// die;
				// ------------------------------------Menu Access------------------------------------ //
				$this->session->set_flashdata("success_code","Template setting saved succcessfully!");
				redirect('General_setting');
			}
			
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function edit_general_setting()
	{	
		if($this->session->userdata('logged_in'))
		{
			// $this->output->enable_profiler(true);
			$session_data = $this->session->userdata('logged_in');
			
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$Company_id = $session_data['Company_id'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Logged_user_enrollid = $session_data['enroll'];			
			$Sub_seller_admin = $session_data['Sub_seller_admin'];
			$Sub_seller_Enrollement_id = $session_data['Sub_seller_Enrollement_id'];
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$data["Sellers_details"] = $this->Igain_model->get_company_sellers($Company_id);
				
			
			
			/*-----------------------Pagination---------------------*/		
			// $this->output->enable_profiler(true);	
			
			$data["Fontfamily"] = $this->Igain_model->get_font_family($session_data['Company_id']);
			
			if($_REQUEST == NULL)
			{
				redirect('General_setting', 'refresh');
			}
			else
			{
				// echo"---Seller_id----".$_REQUEST['Seller_id']."----<br>";
				$data["Seller_id"]=$_REQUEST['Seller_id'];
				// die;
				$this->load->view('General_setting/Edit_general_setting_view', $data);
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
		
		
		
			// $data["Template_details"] = $this->General_setting_model->Company_template_details($session_data['Company_id'],$config["per_page"], $page);
	}
	
}
?>