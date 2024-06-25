<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller 
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
		$this->load->model('Menu/Menu_model');
		$this->load->model('company/Company_model');
	}
	
/************************************************Akshay Start***********************************************/

	function create_menu()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Menu/create_menu";
			$total_row = $this->Menu_model->menu_count();		
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
			
			$data["results"] = $this->Menu_model->menu_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();
			$data['License_type'] = $this->Menu_model->Get_Code_decode_master(20);			
			if($_POST == NULL)
			{
				$this->load->view('Menu/create_menu', $data);
			}
			else
			{			
				$result = $this->Menu_model->create_menu();
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Menu Created Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Menu";
						$where="Create / Edit Menu";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('menu_name').'-'.$result;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Creating Menu. Please Provide valid data!!");
				}
				redirect(current_url());
			} 		
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function get_parent_menu()
	{
		$data['Parent_menu'] = $this->Menu_model->get_parent_menu($this->input->post("menu_level"));
		$this->load->view('Menu/get_parent_menu',$data);	
	}
	
	public function edit_menu()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];	
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Menu/create_menu";
			$total_row = $this->Menu_model->menu_count();		
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
			
			$data["results"] = $this->Menu_model->menu_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();
			
			if($_GET['Menu_id'])
			{
				$Menu_id =  $_GET['Menu_id'];			
				$data['results2'] = $this->Menu_model->edit_menu($Menu_id);
				$results2 = $this->Menu_model->edit_menu($Menu_id);
				
				$data['Parent_menu'] = $this->Menu_model->edit_menu($results2->Parent_menu_id);
				$data['License_type'] = $this->Menu_model->Get_Code_decode_master(20);
				$this->load->view('Menu/edit_menu', $data);
			}
			else
			{		
				redirect('Menu/create_menu', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_menu()
	{
		if($this->session->userdata('logged_in'))
		{	
			
			if($_POST == NULL)
			{
				redirect('Menu/create_menu', 'refresh');
			}
			else
			{
				$Menu_id =  $this->input->post('Menu_id');
				$post_data = array(					
					'Menu_name' => $this->input->post('menu_name'),
					'Menu_href' => $this->input->post('menu_href')
				);
				
				$result = $this->Menu_model->update_menu($post_data,$Menu_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Menu Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Menu";
						$where="Create / Edit Menu";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('menu_name').'-'.$Menu_id;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Updating Menu..!!");
				}
				redirect('Menu/create_menu');
			}
		}
	}
	
	public function delete_menu()
	{
		if($this->session->userdata('logged_in'))
		{	
			
			if($_GET == NULL)
			{
				redirect('Menu/create_menu', 'refresh');
			}
			else
			{	
				
				$Menu_id =  $_GET['Menu_id'];
				$results2 = $this->Menu_model->edit_menu($Menu_id);
				$menu_name=$results2->Menu_name;
				$result = $this->Menu_model->delete_menu($Menu_id);
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Menu Deleted Successfuly..!!");
					
					/*******************Insert igain Log Table*********************/
						$session_data = $this->session->userdata('logged_in');
						$Todays_date = date('Y-m-d');	
						$opration = 3;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Delete Menu";
						$where="Create / Edit Menu";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $menu_name.'-'.$Menu_id;
						$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{
					$this->session->set_flashdata("error_code","Error Deleting Menu..!!");
				}
				redirect('Menu/create_menu');
			}
		}
	}
	
	function menu_map()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$get_company_detail = $this->Igain_model->get_company_details($data['Company_id']);
			$Company_License_type=$get_company_detail->Company_License_type;
			$data["Level_0_menu"] = $this->Menu_model->get_level_0_menu($Company_License_type);
			// $data["Level_1_menu"] = $this->Menu_model->get_level_1_menu();
						
			$this->load->view('Menu/menu_map', $data); 		
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function assign_menu()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Loggin_User_id = $session_data['userId'];
			
			if($_POST == NULL)
			{
				$data["User_types"] = $this->Menu_model->get_user_types($Loggin_User_id);
				// $data["Level_0_menu"] = $this->Menu_model->get_level_0_menu();
				$data["Level_0_menu"] = $this->Menu_model->get_company_assigned_level_0_menu($data['Company_id']);
				$this->load->view('Menu/assign_menu', $data);
			}
			else
			{
				if( $this->input->post('submit') == "Assign_Menus" )
				{
					
					$Checkbox_level_0 = $this->input->post('Checkbox_level_0');
					$Checkbox_level_1 = $this->input->post('Checkbox_level_1');
					$Checkbox_level_2 = $this->input->post('Checkbox_level_2');					
					
					if( $Checkbox_level_0 != NULL || $Checkbox_level_1 != NULL || $Checkbox_level_2 != NULL)
					{
						
						
						if($this->input->post('user_name') == 0)
						{
							
							$post_data665 = array(					
							'Company_id' => $session_data['Company_id']
							);
							$result665 = $this->Menu_model->delete_assigned_menu($post_data665);
							
							$All_User_names = $this->Menu_model->get_usernames($this->input->post("user_type"),$session_data['Company_id']);
							
							foreach($All_User_names as $User_names)
							{
								$post_data1 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => '1',
												'Menu_level' => '0',
												'Parent_id' => '0'
											);
											$result1 = $this->Menu_model->assign_menu($post_data1);
											
								if($Checkbox_level_0 != NULL)
								{
									
											
									foreach($Checkbox_level_0 as $level0_menu)
									{
										$check_menu = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$level0_menu);
										if($check_menu == 0)
										{
											$post_data = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => $level0_menu,
												'Menu_level' => '0',
												'Parent_id' => '0'
											);
											$result = $this->Menu_model->assign_menu($post_data);
										}
									}
								}								
								if($Checkbox_level_1 != NULL)
								{
									foreach($Checkbox_level_1 as $level1_menu)
									{
										$check_menu2 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$level1_menu);
										if($check_menu2 == 0)
										{
											$results = $this->Menu_model->edit_menu($level1_menu);									
											$check_menu3 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$results->Parent_menu_id);
											if($check_menu3 == 0)
											{
												$post_data3 = array(					
													'Company_id' => $session_data['Company_id'],
													'User_type_id' => $this->input->post('user_type'),
													'Enrollment_id' => $User_names['Enrollement_id'],
													'Menu_id' => $results->Parent_menu_id,
													'Menu_level' => '0',
													'Parent_id' => '0'
												);
												$result3 = $this->Menu_model->assign_menu($post_data3);
											}
											
											$post_data2 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => $level1_menu,
												'Menu_level' => '1',
												'Parent_id' => $results->Parent_menu_id
											);
											$result2 = $this->Menu_model->assign_menu($post_data2);
										}
									}
								}								
								if($Checkbox_level_2 != NULL)
								{
									foreach($Checkbox_level_2 as $level2_menu)
									{
										$check_menu4 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$level2_menu);
										
										if($check_menu4 == 0)
										{
											$results4 = $this->Menu_model->edit_menu($level2_menu);									
											$check_menu5 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$results4->Parent_menu_id);
											
											if($check_menu5 == 0)
											{
												$results5 = $this->Menu_model->edit_menu($results4->Parent_menu_id);
												$check_menu6 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$results5->Parent_menu_id);
												
												if($check_menu6 == 0)
												{
													$post_data6 = array(					
														'Company_id' => $session_data['Company_id'],
														'User_type_id' => $this->input->post('user_type'),
														'Enrollment_id' => $User_names['Enrollement_id'],
														'Menu_id' => $results5->Parent_menu_id,
														'Menu_level' => '0',
														'Parent_id' => '0'
													);
													$result6 = $this->Menu_model->assign_menu($post_data6);
												}
												
												$post_data5 = array(					
													'Company_id' => $session_data['Company_id'],
													'User_type_id' => $this->input->post('user_type'),
													'Enrollment_id' => $User_names['Enrollement_id'],
													'Menu_id' => $results4->Parent_menu_id,
													'Menu_level' => '1',
													'Parent_id' => $results5->Parent_menu_id
												);
												$result3 = $this->Menu_model->assign_menu($post_data5);
											}
											
											$post_data4 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => $level2_menu,
												'Menu_level' => '2',
												'Parent_id' => $results4->Parent_menu_id
											);
											$result2 = $this->Menu_model->assign_menu($post_data4);
										}
									}
								}
							}
							$this->session->set_flashdata("success_code","Menu Assigned Successfuly..!!");
							
							/*******************Insert igain Log Table*********************/
								$offer = $this->input->post('offer');	
								$Company_id	= $session_data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 1;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								$what="Assign Menus";
								$where="Assign Menus to Users";
								$toname="";
								$To_enrollid =0;
								$firstName = '';
								$lastName = '';
								$Seller_name = $session_data['Full_name'];
								// $opval = 'All User';
								$opval = 'Assign Menu';
								$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
							/*******************Insert igain Log Table*********************/
							redirect('Menu/assign_menu');
						}
						else
						{
							
							$post_data56 = array(					
												'Company_id' => $session_data['Company_id'],
												'Enrollment_id' => $this->input->post('user_name')
										);
							
							$result56 = $this->Menu_model->delete_assigned_menu($post_data56);
							
							$post_data1 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $this->input->post('user_name'),
												'Menu_id' => '1',
												'Menu_level' => '0',
												'Parent_id' => '0'
											);
											$result1 = $this->Menu_model->assign_menu($post_data1);
											
							if($Checkbox_level_0 != NULL)
							{
								foreach($Checkbox_level_0 as $level0_menu)
								{
									$check_menu = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$level0_menu);
									
									if($check_menu == 0)
									{
										$post_data = array(					
											'Company_id' => $session_data['Company_id'],
											'User_type_id' => $this->input->post('user_type'),
											'Enrollment_id' => $this->input->post('user_name'),
											'Menu_id' => $level0_menu,
											'Menu_level' => '0',
											'Parent_id' => '0'
										);
										$result = $this->Menu_model->assign_menu($post_data);
									}
								}
							}
							
							if($Checkbox_level_1 != NULL)
							{
								foreach($Checkbox_level_1 as $level1_menu)
								{
									$check_menu2 = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$level1_menu);
									
									if($check_menu2 == 0)
									{
										$results = $this->Menu_model->edit_menu($level1_menu);										
										$check_menu3 = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$results->Parent_menu_id);
										// echo "<br>check_menu $check_menu3";
										
										// echo "<br>Parent_menu_id ".$results->Parent_menu_id;
										// echo "<br>user_name ".$this->input->post('user_name');
										// echo "<br>Company_id ".$session_data['Company_id'];
										if($check_menu3 == 0)
										{
											// echo "<br>hereee $level1_menu";
											// echo "<br>Parent_menu_id ".$results->Parent_menu_id;
											$post_data3 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $this->input->post('user_name'),
												'Menu_id' => $results->Parent_menu_id,
												'Menu_level' => '0',
												'Parent_id' => '0'
											);
											$result3 = $this->Menu_model->assign_menu($post_data3);
										}
										// echo "<br>level1_menu $level1_menu";
										$post_data2 = array(					
											'Company_id' => $session_data['Company_id'],
											'User_type_id' => $this->input->post('user_type'),
											'Enrollment_id' => $this->input->post('user_name'),
											'Menu_id' => $level1_menu,
											'Menu_level' => '1',
											'Parent_id' => $results->Parent_menu_id
										);
										$result2 = $this->Menu_model->assign_menu($post_data2);
									}
								}
							}		
// echo 'here';die;							
							if($Checkbox_level_2 != NULL)
							{
								foreach($Checkbox_level_2 as $level2_menu)
								{
									$check_menu4 = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$level2_menu);
									
									if($check_menu4 == 0)
									{
										$results4 = $this->Menu_model->edit_menu($level2_menu);									
										$check_menu5 = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$results4->Parent_menu_id);
										
										if($check_menu5 == 0)
										{
											$results5 = $this->Menu_model->edit_menu($results4->Parent_menu_id);
											$check_menu6 = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$results5->Parent_menu_id);
											
											if($check_menu6 == 0)
											{
												$post_data6 = array(					
													'Company_id' => $session_data['Company_id'],
													'User_type_id' => $this->input->post('user_type'),
													'Enrollment_id' => $this->input->post('user_name'),
													'Menu_id' => $results5->Parent_menu_id,
													'Menu_level' => '0',
													'Parent_id' => '0'
												);
												$result6 = $this->Menu_model->assign_menu($post_data6);
											}
											
											$post_data5 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $this->input->post('user_name'),
												'Menu_id' => $results4->Parent_menu_id,
												'Menu_level' => '1',
												'Parent_id' => $results5->Parent_menu_id
											);
											$result3 = $this->Menu_model->assign_menu($post_data5);
										}
										
										$post_data4 = array(					
											'Company_id' => $session_data['Company_id'],
											'User_type_id' => $this->input->post('user_type'),
											'Enrollment_id' => $this->input->post('user_name'),
											'Menu_id' => $level2_menu,
											'Menu_level' => '2',
											'Parent_id' => $results4->Parent_menu_id
										);
										$result2 = $this->Menu_model->assign_menu($post_data4);
									}
								}
							}
								
							/*******************Insert igain Log Table********************/							
								$user_type = $this->input->post("user_type");
								$user_name = $this->input->post('user_name');
								$get_merchant_detail = $this->Igain_model->get_enrollment_details($user_name);
								$merchant_Enrollement_id = $get_merchant_detail->Enrollement_id;
								$merchant_First_name = $get_merchant_detail->First_name;
								$merchant_Last_name = $get_merchant_detail->Last_name;
								$merchant_User_email_id = $get_merchant_detail->User_email_id;
								$sellerId = $this->input->post('sellerId');
								$offer = $this->input->post('offer');	
								$Company_id	= $session_data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 1;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								// $userid=$Logged_user_id;
								$what="Assign Menus";
								$where="Assign Menus to Users";
								$toname="";
								// $opval = 4; // transaction type
								$To_enrollid =0;
								$firstName = $merchant_First_name;
								$lastName = $merchant_Last_name;
								// $data['LogginUserName'] = $Seller_name;
								$Seller_name = $session_data['Full_name'];
								// $opval = $user_type;
								$opval ='Assign Menu';
								$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$merchant_Enrollement_id);
							/*******************Insert igain Log Table*********************/
							$this->session->set_flashdata("success_code","Menu Assigned Successfuly..!!");
							redirect('Menu/assign_menu');
						}
					}
					else
					{
						$this->session->set_flashdata("error_code","Error Assigning Menu. Please Select Menus to assign..!!");
						redirect('Menu/assign_menu');
					}
				}
				/*else
				{
					$Checkbox_level_0 = $this->input->post('Checkbox_level_0');
					$Checkbox_level_1 = $this->input->post('Checkbox_level_1');
					$Checkbox_level_2 = $this->input->post('Checkbox_level_2');
					
					if($Checkbox_level_0 != NULL || $Checkbox_level_1 != NULL || $Checkbox_level_2 != NULL)
					{
						if($Checkbox_level_0 != NULL)
						{
							foreach($Checkbox_level_0 as $level0_menu)
							{
								$post_data = array(					
									'Company_id' => $session_data['Company_id'],
									'Enrollment_id' => $this->input->post('user_name'),
									'Menu_id' => $level0_menu
								);								
								
								$post_data3 = array(					
									'Company_id' => $session_data['Company_id'],
									'Enrollment_id' => $this->input->post('user_name'),
									'Parent_id' => $level0_menu
								);								
								
								$get_level_1_menus = $this->Menu_model->get_level_1_assigned_menus($post_data3);
								if($get_level_1_menus != NULL)
								{
									foreach($get_level_1_menus as $menu)
									{
										$check_menu1 = $this->Menu_model->check_menu($this->input->post('user_name'),$session_data['Company_id'],$menu->Menu_id);
										
										if($check_menu1 > 0)
										{
											$post_data4 = array(					
												'Company_id' => $session_data['Company_id'],
												'Enrollment_id' => $this->input->post('user_name'),
												'Parent_id' => $menu->Menu_id
											);									
											$get_level_1_menus2 = $this->Menu_model->get_level_1_assigned_menus($post_data4);
											
											if($get_level_1_menus2 != NULL)
											{

												foreach($get_level_1_menus2 as $menu2)
												{

													$post_data6 = array(					
														'Company_id' => $session_data['Company_id'],
														'Enrollment_id' => $this->input->post('user_name'),
														'Menu_id' => $menu2->Menu_id
													);
													$result6 = $this->Menu_model->delete_assigned_menu($post_data6);
												}
											}
										}
									}
								}
								$result = $this->Menu_model->delete_assigned_menu($post_data);
								$result3 = $this->Menu_model->delete_assigned_menu($post_data3);
							}
						}
						
						if($Checkbox_level_1 != NULL)
						{
							foreach($Checkbox_level_1 as $level1_menu)
							{
								$post_data2 = array(					
									'Company_id' => $session_data['Company_id'],
									'Enrollment_id' => $this->input->post('user_name'),
									'Menu_id' => $level1_menu
								);
								$result2 = $this->Menu_model->delete_assigned_menu($post_data2);
								
								$post_data4 = array(					
									'Company_id' => $session_data['Company_id'],
									'Enrollment_id' => $this->input->post('user_name'),
									'Parent_id' => $level1_menu
								);
								$result4 = $this->Menu_model->delete_assigned_menu($post_data4);
							}
						}
						
						if($Checkbox_level_2 != NULL)
						{
							foreach($Checkbox_level_2 as $level2_menu)
							{
								$post_data5 = array(					
									'Company_id' => $session_data['Company_id'],
									'Enrollment_id' => $this->input->post('user_name'),
									'Menu_id' => $level2_menu
								);
								$result5 = $this->Menu_model->delete_assigned_menu($post_data5);
							}
						}
						
						$this->session->set_flashdata("success_code","Menu Deleted Successfuly..!!");
						//**************Insert igain Log Table****************	
						
							$user_type = $this->input->post("user_type");
							$user_name = $this->input->post('user_name');
							$get_merchant_detail = $this->Igain_model->get_enrollment_details($user_name);
							$merchant_Enrollement_id = $get_merchant_detail->Enrollement_id;
							$merchant_First_name = $get_merchant_detail->First_name;
							$merchant_Last_name = $get_merchant_detail->Last_name;
							$merchant_User_email_id = $get_merchant_detail->User_email_id;
							$sellerId = $this->input->post('sellerId');
							$offer = $this->input->post('offer');	
							$Company_id	= $session_data['Company_id'];
							$Todays_date = date('Y-m-d');	
							$opration = 3;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							// $userid=$Logged_user_id;
							$what="Delete Menus";
							$where="Assign Menus to Users";
							$toname="";
							// $opval = 4; // transaction type
							$To_enrollid =0;
							$firstName = $merchant_First_name;
							$lastName = $merchant_Last_name;
							// $data['LogginUserName'] = $Seller_name;
							$Seller_name = $session_data['Full_name'];
							// $opval = $user_type;
							$opval ='Delete Menu';
							$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$merchant_Enrollement_id);
						//*******************Insert igain Log Table*********************
						redirect('Menu/assign_menu');
					}
					else
					{
						$this->session->set_flashdata("error_code","Error Deleting Menu. Please Select Menus to assign..!!");
						redirect('Menu/assign_menu');
					}
				} */
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function get_usernames()
	{
		$data['User_names'] = $this->Menu_model->get_usernames($this->input->post("User_type"),$this->input->post("Company_id"));
		$this->load->view('Menu/get_usernames',$data);	
	}
	
	public function get_assigned_menus()
	{
		//$data['assigned_level0_menus'] = $this->Menu_model->get_assigned_level_0_menu($this->input->post("user_name"),$this->input->post("Company_id"));
		
	//****** 10-07-2019 *******	
		$data['user_assigned_all_menus'] = $this->Menu_model->get_users_assigned_menus($this->input->post("user_name"),$this->input->post("Company_id"));
			
		$data['Level_0_menu'] = $this->Menu_model->get_company_assigned_level_0_menu($this->input->post("Company_id"));
		
		$data['Company_id'] = $this->input->post("Company_id");
		
		$this->load->view('Menu/get_assigned_menus',$data);	
	}
	
	function assign_additional_menu()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			
			if($_POST == NULL)
			{
				$data["Companys"] = $this->Menu_model->fetch_companys();
				$this->load->view('Menu/assign_additional_menu', $data);
			}
			else
			{
				if($_POST['submit'] == "Assign_Menus")
				{						
				//***** delete all menus ******************
					$Company_id = $this->input->post('Company_id');
					$Checkbox_level_0 = $this->input->post('Checkbox_level_0');	//print_r($Checkbox_level_0); echo "<br>---<br>";
					$Checkbox_level_1 = $this->input->post('Checkbox_level_1'); //print_r($Checkbox_level_1); echo "<br>---<br>";
					$Checkbox_level_2 = $this->input->post('Checkbox_level_2'); //print_r($Checkbox_level_2); echo "<br>---<br>";
				
				//exit; die;
				//***** delete all menus 16-07-2019 ******************
					$delete_company_menus = $this->Menu_model->delete_company_menus($Company_id);
					
					if( $Checkbox_level_0 != NULL || $Checkbox_level_1 != NULL || $Checkbox_level_2 != NULL )
					{
						if($Checkbox_level_0 != NULL)
						{
							foreach($Checkbox_level_0 as $level0_menu)
							{
								$results = $this->Menu_model->edit_menu($level0_menu);
								$Menu_array = array(
									'Company_id' => $Company_id,
									'Menu_id' => $results->Menu_id,
									'Menu_level' => $results->Menu_level,
									'Menu_name' => $results->Menu_name,
									'Parent_menu_id' => $results->Parent_menu_id,
									'Menu_href' => $results->Menu_href,
									'Active_flag' => $results->Active_flag
								);
								$insert_company_menus = $this->Company_model->insert_company_menus($Company_id,$Menu_array);
							}
						}
						
						if($Checkbox_level_1 != NULL)
						{
							foreach($Checkbox_level_1 as $level1_menu)
							{
								$results2 = $this->Menu_model->edit_menu($level1_menu);
								
								$check_menu_parent = $this->Menu_model->check_parent_menu_available($Company_id,$results2->Parent_menu_id);
								if($check_menu_parent == 0)
								{
									$results6 = $this->Menu_model->edit_menu($results2->Parent_menu_id);
									$Parent_Menu_array = array(
										'Company_id' => $Company_id,
										'Menu_id' => $results6->Menu_id,
										'Menu_level' => $results6->Menu_level,
										'Menu_name' => $results6->Menu_name,
										'Parent_menu_id' => $results6->Parent_menu_id,
										'Menu_href' => $results6->Menu_href,
										'Active_flag' => $results6->Active_flag
									);
									$insert_parent_menus = $this->Company_model->insert_company_menus($Company_id,$Parent_Menu_array);
								}								
								
								$Menu_array2 = array(
									'Company_id' => $Company_id,
									'Menu_id' => $results2->Menu_id,
									'Menu_level' => $results2->Menu_level,
									'Menu_name' => $results2->Menu_name,
									'Parent_menu_id' => $results2->Parent_menu_id,
									'Menu_href' => $results2->Menu_href,
									'Active_flag' => $results2->Active_flag
								);
								$insert_company_menus2 = $this->Company_model->insert_company_menus($Company_id,$Menu_array2);
							}
						}
						
						if($Checkbox_level_2 != NULL)
						{
							foreach($Checkbox_level_2 as $level2_menu)
							{
								$results3 = $this->Menu_model->edit_menu($level2_menu);
								$check_menu_parent2 = $this->Menu_model->check_parent_menu_available($Company_id,$results3->Parent_menu_id);
								
								if($check_menu_parent2 == 0)
								{
									$results7 = $this->Menu_model->edit_menu($results3->Parent_menu_id);
									$Parent_Menu_array2 = array(
										'Company_id' => $Company_id,
										'Menu_id' => $results7->Menu_id,
										'Menu_level' => $results7->Menu_level,
										'Menu_name' => $results7->Menu_name,
										'Parent_menu_id' => $results7->Parent_menu_id,
										'Menu_href' => $results7->Menu_href,
										'Active_flag' => $results7->Active_flag
									);
									$insert_parent_menus4 = $this->Company_model->insert_company_menus($Company_id,$Parent_Menu_array2);
								}
								
								$Menu_array3 = array(
									'Company_id' => $Company_id,
									'Menu_id' => $results3->Menu_id,
									'Menu_level' => $results3->Menu_level,
									'Menu_name' => $results3->Menu_name,
									'Parent_menu_id' => $results3->Parent_menu_id,
									'Menu_href' => $results3->Menu_href,
									'Active_flag' => $results3->Active_flag
								);
								$insert_company_menus5 = $this->Company_model->insert_company_menus($Company_id,$Menu_array3);
							}
						}
						
						/*******************Insert igain Log Table*********************/
							$get_company_detail = $this->Igain_model->get_company_details($this->input->post('Company_id'));
							$Company_name=$get_company_detail->Company_name;
							$Todays_date = date('Y-m-d');	
							$opration = 1;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Assign Menus to Company";
							$where="Assign Additional Menus to Company";
							$toname="";
							$To_enrollid =0;
							$firstName = $Company_name;
							$lastName ='';
							$Seller_name =$session_data['Full_name'];
							$opval = $Company_name;
							$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						/*******************Insert igain Log Table*********************/
						
						$this->session->set_flashdata("success_code","Additional Menu Assigned Successfuly..!!");
						redirect('Menu/assign_additional_menu');
					}
					else
					{
						$this->session->set_flashdata("error_code","Error Assigning Additional Menu. Please Select Menus to assign..!!");
						redirect('Menu/assign_additional_menu');
					}
				}	
				/*else {				
					$Company_id = $this->input->post('Company_id');
					$Checkbox_level_0 = $this->input->post('Del_Checkbox_level_0');
					$Checkbox_level_1 = $this->input->post('Del_Checkbox_level_1');
					$Checkbox_level_2 = $this->input->post('Del_Checkbox_level_2');
					
					if($Checkbox_level_0 != NULL || $Checkbox_level_1 != NULL || $Checkbox_level_2 != NULL)
					{
						if($Checkbox_level_0 != NULL)
						{
							foreach($Checkbox_level_0 as $level0_menu)
							{
								$delete_company_menus = $this->Menu_model->delete_company_menus($Company_id,$level0_menu);
								$delete_company_child_menus = $this->Menu_model->delete_company_child_menus($Company_id,$level0_menu);
							}
						}
						
						if($Checkbox_level_1 != NULL)
						{
							foreach($Checkbox_level_1 as $level1_menu)
							{
								$delete_company_menus2 = $this->Menu_model->delete_company_menus($Company_id,$level1_menu);
								$delete_company_child_menus = $this->Menu_model->delete_company_child_menus($Company_id,$level1_menu);
							}
						}
						
						if($Checkbox_level_2 != NULL)
						{
							foreach($Checkbox_level_2 as $level2_menu)
							{
								$delete_company_menus2 = $this->Menu_model->delete_company_menus($Company_id,$level2_menu);
								$delete_company_child_menus = $this->Menu_model->delete_company_child_menus($Company_id,$level2_menu);
							}
						}
						
						$this->session->set_flashdata("success_code","Additional Company Menus Deleted Successfuly..!!");
						
						//*******************Insert igain Log Table*********************
							$get_company_detail = $this->Igain_model->get_company_details($this->input->post('Company_id'));
							$Company_name=$get_company_detail->Company_name;
							$Todays_date = date('Y-m-d');	
							$opration = 3;		
							$enroll	= $session_data['enroll'];
							$username = $session_data['username'];
							$userid=$session_data['userId'];
							$what="Delete Company Menus";
							$where="Assign Additional Menus to Company";
							$toname="";
							$To_enrollid =0;
							$firstName = $Company_name;
							$lastName = '';
							$Seller_name = $session_data['Full_name'];
							$opval = $Company_name;
							$result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
						//*******************Insert igain Log Table*********************
						redirect('Menu/assign_additional_menu');
					}
					else
					{
						$this->session->set_flashdata("error_code","Error Deleting Assigned Company Menus. Please Select Menus to Delete..!!");
						redirect('Menu/assign_additional_menu');
					}
				} */
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function get_company_menus()
	{
		$Company_License_type = $this->input->post("License_type");
		$data["Level_0_menu"] = $this->Menu_model->get_level_0_menu($Company_License_type);
		$data["Company_id"] = $this->input->post("Company_id");
		$this->load->view('Menu/get_company_menus',$data);	
	}
	
	public function get_company_assigned_menus()
	{
		$data["Level_0_company_menu"] = $this->Menu_model->get_company_assigned_level_0_menu($this->input->post("Company_id"));
		$data["Company_id"] = $this->input->post("Company_id");
		$this->load->view('Menu/get_company_assigned_menus',$data);	
	}

/************************************************Akshay Start***********************************************/
//****************** 16-08-2019 ***********************
function check_menu_exist()
{	
	$menuName = $this->input->post("MenuName");
	
	$res = $this->Menu_model->check_menu_name($menuName);

	if($res > 0)
	{
		$this->output->set_output("1");
	}
	else    
	{
		$this->output->set_output("0");
	}	
}	
//****************** Menu Privileges****AMIT KAMBLE 06-04-2022******************	
function assign_menu_privileges()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Loggin_User_id = $session_data['userId'];
			
			if($_POST == NULL)
			{
				$data["User_types"] = $this->Menu_model->get_user_types($Loggin_User_id);
				// $data["Level_0_menu"] = $this->Menu_model->get_level_0_menu();
				$data["Level_0_menu"] = $this->Menu_model->get_company_assigned_level_0_menu($data['Company_id']);
				$this->load->view('Menu/assign_menu_privileges', $data);
			}
			else
			{
				if( $this->input->post('submit') == "Assign_Menus" )
				{
					
					$Checkbox_level_0 = $this->input->post('Checkbox_level_0');
					$Checkbox_level_1 = $this->input->post('Checkbox_level_1');
					$Checkbox_level_2 = $this->input->post('Checkbox_level_2');					
					
					if( $Checkbox_level_0 != NULL || $Checkbox_level_1 != NULL || $Checkbox_level_2 != NULL)
					{
						
						
						if($this->input->post('user_name') == 0)
						{
							
							$post_data665 = array(					
							'Company_id' => $session_data['Company_id']
							);
							$result665 = $this->Menu_model->delete_assigned_menu($post_data665);
							
							$All_User_names = $this->Menu_model->get_usernames($this->input->post("user_type"),$session_data['Company_id']);
							
							foreach($All_User_names as $User_names)
							{
								if($Checkbox_level_0 != NULL)
								{
									foreach($Checkbox_level_0 as $level0_menu)
									{
										$check_menu = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$level0_menu);
										if($check_menu == 0)
										{
											$post_data = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => $level0_menu,
												'Menu_level' => '0',
												'Parent_id' => '0'
											);
											$result = $this->Menu_model->assign_menu($post_data);
										}
									}
								}								
								if($Checkbox_level_1 != NULL)
								{
									foreach($Checkbox_level_1 as $level1_menu)
									{
										$check_menu2 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$level1_menu);
										if($check_menu2 == 0)
										{
											$results = $this->Menu_model->edit_menu($level1_menu);									
											$check_menu3 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$results->Parent_menu_id);
											if($check_menu3 == 0)
											{
												$post_data3 = array(					
													'Company_id' => $session_data['Company_id'],
													'User_type_id' => $this->input->post('user_type'),
													'Enrollment_id' => $User_names['Enrollement_id'],
													'Menu_id' => $results->Parent_menu_id,
													'Menu_level' => '0',
													'Parent_id' => '0'
												);
												$result3 = $this->Menu_model->assign_menu($post_data3);
											}
											
											$post_data2 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => $level1_menu,
												'Menu_level' => '1',
												'Parent_id' => $results->Parent_menu_id
											);
											$result2 = $this->Menu_model->assign_menu($post_data2);
										}
									}
								}								
								if($Checkbox_level_2 != NULL)
								{
									foreach($Checkbox_level_2 as $level2_menu)
									{
										$check_menu4 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$level2_menu);
										
										if($check_menu4 == 0)
										{
											$results4 = $this->Menu_model->edit_menu($level2_menu);									
											$check_menu5 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$results4->Parent_menu_id);
											
											if($check_menu5 == 0)
											{
												$results5 = $this->Menu_model->edit_menu($results4->Parent_menu_id);
												$check_menu6 = $this->Menu_model->check_menu($User_names['Enrollement_id'],$session_data['Company_id'],$results5->Parent_menu_id);
												
												if($check_menu6 == 0)
												{
													$post_data6 = array(					
														'Company_id' => $session_data['Company_id'],
														'User_type_id' => $this->input->post('user_type'),
														'Enrollment_id' => $User_names['Enrollement_id'],
														'Menu_id' => $results5->Parent_menu_id,
														'Menu_level' => '0',
														'Parent_id' => '0'
													);
													$result6 = $this->Menu_model->assign_menu($post_data6);
												}
												
												$post_data5 = array(					
													'Company_id' => $session_data['Company_id'],
													'User_type_id' => $this->input->post('user_type'),
													'Enrollment_id' => $User_names['Enrollement_id'],
													'Menu_id' => $results4->Parent_menu_id,
													'Menu_level' => '1',
													'Parent_id' => $results5->Parent_menu_id
												);
												$result3 = $this->Menu_model->assign_menu($post_data5);
											}
											
											$post_data4 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $User_names['Enrollement_id'],
												'Menu_id' => $level2_menu,
												'Menu_level' => '2',
												'Parent_id' => $results4->Parent_menu_id
											);
											$result2 = $this->Menu_model->assign_menu($post_data4);
										}
									}
								}
							}
							$this->session->set_flashdata("success_code","Menu Assigned Successfuly..!!");
							
							/*******************Insert igain Log Table*********************/
								$offer = $this->input->post('offer');	
								$Company_id	= $session_data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 1;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								$what="Assign Menus";
								$where="Assign Menus to Users";
								$toname="";
								$To_enrollid =0;
								$firstName = '';
								$lastName = '';
								$Seller_name = $session_data['Full_name'];
								// $opval = 'All User';
								$opval = 'Assign Menu';
								$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
							/*******************Insert igain Log Table*********************/
							redirect('Menu/assign_menu');
						}
						else
						{
						
							 $post_data56 = array(					
												'Company_id' => $session_data['Company_id'],
												'Enrollment_id' => $this->input->post('user_name')
										);
							
							$result56 = $this->Menu_model->delete_assigned_menu_privileges($post_data56); 
												
							// print_r($Checkbox_level_1);//die;
							
							if($Checkbox_level_1 != NULL)
							{
								
								foreach($Checkbox_level_1 as $level1_menu)
								{
									$Add_flag=0;
									$Edit_flag=0;
									$View_flag=0;
									$Delete_flag=0;
								
									if(isset($_REQUEST["Add_$level1_menu"]) != NULL)
									{
										$Add_flag=1;
										// echo "<br><br>MenuID $level1_menu  Add_flag ".$_REQUEST["Add_$level1_menu"];
									}
									if(isset($_REQUEST["Edit_$level1_menu"]) != NULL)
									{
										$Edit_flag=1;
										// echo "<br><br>MenuID $level1_menu  Edit_flag ".$_REQUEST["Edit_$level1_menu"];
									}
									if(isset($_REQUEST["View_$level1_menu"]) != NULL)
									{
										$View_flag=1;
										// echo "<br><br>MenuID $level1_menu  View_flag ".$_REQUEST["View_$level1_menu"];
									}
									if(isset($_REQUEST["Delete_$level1_menu"]) != NULL)
									{
										$Delete_flag=1;
										// echo "<br><br>MenuID $level1_menu  Delete_flag ".$_REQUEST["Delete_$level1_menu"];
									}
									
									$post_data3 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $this->input->post('user_name'),
												'Menu_id' => $level1_menu,
												'Add_flag' => $Add_flag,
												'Edit_flag' => $Edit_flag,
												'View_flag' => $View_flag,
												'Delete_flag' => $Delete_flag
											);
											$result3 = $this->Menu_model->assign_menu_privileges($post_data3);
											
									
									
								}
							}		
							// echo '<br><br><br>Checkbox_level_2<br>';		
							// print_r($Checkbox_level_2);	
							if($Checkbox_level_2 != NULL)
							{
								
								foreach($Checkbox_level_2 as $level2_menu)
								{
									$Add_flag2=0;
									$Edit_flag2=0;
									$View_flag2=0;
									$Delete_flag2=0;
									
									if(isset($_REQUEST["Add_$level2_menu"]) != NULL)
									{
										$Add_flag2=1;
										// echo "<br><br>MenuID $level2_menu  Add_flag ".$_REQUEST["Add_$level2_menu"];
									}
									if(isset($_REQUEST["Edit_$level2_menu"]) != NULL)
									{
										$Edit_flag2=1;
										// echo "<br><br>MenuID $level2_menu  Edit_flag ".$_REQUEST["Edit_$level2_menu"];
									}
									if(isset($_REQUEST["View_$level2_menu"]) != NULL)
									{
										$View_flag2=1;
										// echo "<br><br>MenuID $level2_menu  View_flag ".$_REQUEST["View_$level2_menu"];
									}
									if(isset($_REQUEST["Delete_$level2_menu"]) != NULL)
									{
										$Delete_flag2=1;
										// echo "<br><br>MenuID $level2_menu  Delete_flag ".$_REQUEST["Delete_$level2_menu"];
									}
									
									$post_data33 = array(					
												'Company_id' => $session_data['Company_id'],
												'User_type_id' => $this->input->post('user_type'),
												'Enrollment_id' => $this->input->post('user_name'),
												'Menu_id' => $level2_menu,
												'Add_flag' => $Add_flag2,
												'Edit_flag' => $Edit_flag2,
												'View_flag' => $View_flag2,
												'Delete_flag' => $Delete_flag2
											);
											$result3 = $this->Menu_model->assign_menu_privileges($post_data33);
								}
							}
							
								// die;
							/*******************Insert igain Log Table********************/							
								$user_type = $this->input->post("user_type");
								$user_name = $this->input->post('user_name');
								$get_merchant_detail = $this->Igain_model->get_enrollment_details($user_name);
								$merchant_Enrollement_id = $get_merchant_detail->Enrollement_id;
								$merchant_First_name = $get_merchant_detail->First_name;
								$merchant_Last_name = $get_merchant_detail->Last_name;
								$merchant_User_email_id = $get_merchant_detail->User_email_id;
								$Company_id	= $session_data['Company_id'];
								$Todays_date = date('Y-m-d');	
								$opration = 1;		
								$enroll	= $session_data['enroll'];
								$username = $session_data['username'];
								$userid=$session_data['userId'];
								// $userid=$Logged_user_id;
								$what="Assign Menus Privileges";
								$where="Assign Menus Privileges to Users";
								$toname="";
								// $opval = 4; // transaction type
								$To_enrollid =0;
								$firstName = $merchant_First_name;
								$lastName = $merchant_Last_name;
								// $data['LogginUserName'] = $Seller_name;
								$Seller_name = $session_data['Full_name'];
								// $opval = $user_type;
								$opval ='Assign Menu';
								$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$merchant_Enrollement_id);
							/*******************Insert igain Log Table*********************/
							$this->session->set_flashdata("success_code","Menu Privileges Assigned Successfuly..!!");
							redirect('Menu/assign_menu_privileges');
						}
					}
					else
					{
						$this->session->set_flashdata("error_code","Error Assigning Menu Privileges. Please Select Menus Privileges to assign..!!");
						redirect('Menu/assign_menu_privileges');
					}
				}
				
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
		public function get_assigned_menus_privileges()
	{
		//$data['assigned_level0_menus'] = $this->Menu_model->get_assigned_level_0_menu($this->input->post("user_name"),$this->input->post("Company_id"));
		
	//****** 10-07-2019 *******	
		$data['user_assigned_all_menus'] = $this->Menu_model->get_users_assigned_menus($this->input->post("user_name"),$this->input->post("Company_id"));
			
		$data['Level_0_menu'] = $this->Menu_model->get_user_assigned_level_0_menu($this->input->post("Company_id"),$this->input->post("user_name"));
		
		$data['Company_id'] = $this->input->post("Company_id");
		$data['Enrollment_id'] = $this->input->post("user_name");
		
		$this->load->view('Menu/get_assigned_menus_privileges',$data);	
	}
	
}