<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Gamec extends CI_Controller 
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
		$this->load->model('master/Game_model');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
	}
	
/************************************* Sandeep start **********************************************/

	public function game_setup()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/game_setup";
			$total_row = $this->Game_model->games_count();		
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
			
			$data["results"] = $this->Game_model->games_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{
				
				$this->load->view('games/game_setup', $data);
			}
			else
			{			
				$result = $this->Game_model->insert_game();
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","New Game Inserted Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
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
						$To_enrollid =$this->input->post('Company_id');
						$firstName = $Company_name;
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $Company_name;
						// $result_log_table = $this->Igain_model->Insert_log_table($session_data['Company_id'],$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$this->input->post('Company_id'));
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Inserting Game. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function game_name_validation()
	{
		$opt = $this->Game_model->check_game_name($this->input->post("gamename"));
		
		if($opt > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else
		{
			$this->output->set_output("Available");
		}
	}
	
	function delete_game()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/game_setup";
			$total_row = $this->Game_model->games_count();		
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
			
			$data["results"] = $this->Game_model->games_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();
			
			if($_GET != NULL)
			{	
				$game_id =  $_GET['game_id'];				
			
				$result = $this->Game_model->delete_game($game_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Game Deleted Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Game Delete. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			else
			{
				$this->load->view('games/game_setup', $data);
			}

		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	public function edit_game()
	{		
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];	
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/game_setup";
			$total_row = $this->Game_model->games_count();		
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
			
			$data["results"] = $this->Game_model->games_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();
			
			if($_GET['Game_id'])
			{
				$Game_id =  $_GET['Game_id'];	
						
				$data['results'] = $this->Game_model->edit_game($Game_id);
				
				$this->load->view('games/edit_game_setup', $data);
			}
			else
			{		
				redirect('Gamec/game_setup', 'refresh');
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	function update_game_setup()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/game_setup";
			$total_row = $this->Game_model->games_count();		
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
			
			$data["results"] = $this->Game_model->games_list($config["per_page"], $page);
			$data["pagination"] = $this->pagination->create_links();
			
			if($_POST == NULL)
			{	
				$this->load->view('games/game_setup', $data);
			}
			else
			{			
				$result = $this->Game_model->update_game();
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Game Updated Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Game Update. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}

		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function set_game_prize()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data15['username'] = $session_data['username'];
			$data15['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data15['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data15['LogginUserName'] = $session_data['Full_name'];
			
			$data15['total_winners'] = $this->input->post("total_winners");
			$data15['prize_flag'] = $this->input->post("prize_flag");
			
			$this->load->view("games/game_prize_list",$data15);
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}

	public function company_game_setup()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_setup";
			$total_row = $this->Game_model->company_games_count($Company_id);		
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
			
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			
			
			/*-----------------------File Upload---------------------*/
			
			
			$data["comp_results"] = $this->Game_model->company_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{
				
				$this->load->view('games/company_game_setup', $data);
			}
			else
			{	
				$Competition_winner_award = $this->input->post("Winner_award");
				$Game_for_competition = $this->input->post("Competition");
	
				if($Competition_winner_award == 2 && $Game_for_competition == 1)
				{
				$prizes_array = $this->input->post("prizes");

				 //print_r($prizes_array); echo "--<br>--";
					$files_array = $_FILES['file'];//$_FILES['file']['name'];
				// print_r($files_array);
					if(!empty($files_array))
					{
						$this->load->library('upload', $config);
						$files = $_FILES['file'];

						for($k = 0; $k < count($files_array);$k++)
						{

							$fileimg = $files['name'][$k];// $files_array[$k];
							
							if($fileimg != "")
							{
								$_FILES['file']['name']= $files['name'][$k];
								$_FILES['file']['type']= $files['type'][$k];
								$_FILES['file']['tmp_name']= $files['tmp_name'][$k];
								$_FILES['file']['error']= $files['error'][$k];
								$_FILES['file']['size']= $files['size'][$k];    
							
							$this->upload->initialize($config);
							  if ($this->upload->do_upload('file'))
							  {
								$this->_uploaded[$k] = $this->upload->data();
								$filepath[] = "uploads/".$fileimg;
							  }
							  else
							  {			  	
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								$filepath[] = "";
							  }
							
							}	

						}
					}
					else
					{
						$filepath = array();
					}
					//print_r($filepath); echo "--filepath<br>--";

				}
				else
				{
					$filepath = array();
				}
				$Company_game_id = $this->Game_model->insert_company_game($filepath);
				
				if($Game_for_competition == 1)
				{
					
					$Email_content = array(
					'Company_game_id' => $Company_game_id,
					'Notification_type' => 'Game Competition Details',
					'Template_type' => 'Game_competition'
					);
					
					/* $all_customers = $this->Igain_model->get_all_customers($session_data['Company_id']);
					
					foreach($all_customers as $customers)
					{
						$this->send_notification->send_Notification_email($customers['Enrollement_id'],$Email_content,$Logged_user_enrollid,$session_data['Company_id']);
					} */
					
				}

				if($Company_game_id > 0)
				{
					$this->session->set_flashdata("success_code","Game Assigned Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error To Assigned Game. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function delete_company_game()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_setup";
			$total_row = $this->Game_model->company_games_count($Company_id);		
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
			
			$data["comp_results"] = $this->Game_model->company_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();
			
			if($_GET != NULL)
			{	
				$game_id =  $_GET['game_id'];				
			
				$result = $this->Game_model->delete_company_game($game_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Game Deleted Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Game Delete. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			else
			{
				$this->load->view('games/company_game_setup', $data);
			}

		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function edit_company_game()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);

			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_setup";
			$total_row = $this->Game_model->company_games_count($Company_id);		
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
			
			
			
			$data["comp_results"] = $this->Game_model->company_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();
						
				if($_GET['company_game_id'])
				{
					$Game_id =  $_GET['company_game_id'];	
							
					$edit_results = $this->Game_model->edit_company_game($Game_id);
	
					$data['edit_results'] = $edit_results;
					
					foreach($edit_results as $row22)
					{
						$Company_game_id = $row22->Company_game_id;
						$lv_Game_id = $row22->Game_id; 
					}
					
					$data['edit_child_results'] = $this->Game_model->edit_child_company_game($Game_id);
					
					$data["games"] = $this->Game_model->edit_game($lv_Game_id);
					
					$this->load->view('games/edit_company_game_setup', $data);
				}
				else
				{		
					redirect('Gamec/company_game_setup', 'refresh');
				}
	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_company_game_setup()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_setup";
			$total_row = $this->Game_model->company_games_count($Company_id);		
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
			
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			
			
			/*-----------------------File Upload---------------------*/
			
			
			$data["comp_results"] = $this->Game_model->company_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{
				
				$this->load->view('games/company_game_setup', $data);
			}
			else
			{	
				$Company_game_id = $this->input->post("Company_game_id");
				$prizes_array = $this->input->post("prizes");
				
				$Competition_winner_award = $this->input->post("Winner_award");
				$Game_for_competition = $this->input->post("Competition");
				
				if($Competition_winner_award == 2 && $Game_for_competition == 1)
				{
				// print_r($prizes_array); echo "--<br>--";
				 $files_array = $_FILES['file']['name'];
				// print_r($files_array); echo "--<br>--";

						
						$this->load->library('upload', $config);
						$files = $_FILES['file'];
						
						for($k = 0; $k < count($files_array);$k++)
						{

							$fileimg = $files_array[$k];
							
							if($fileimg != "")
							{
							
								$_FILES['file']['name']= $files['name'][$k];
								$_FILES['file']['type']= $files['type'][$k];
								$_FILES['file']['tmp_name']= $files['tmp_name'][$k];
								$_FILES['file']['error']= $files['error'][$k];
								$_FILES['file']['size']= $files['size'][$k];    
							
							$this->upload->initialize($config);
							  if ($this->upload->do_upload('file'))
							  {
								$this->_uploaded[$k] = $this->upload->data();
								$filepath[] = "uploads/".$fileimg;
							  }
							  else
							  {			  	
								$this->session->set_flashdata("error_code",$this->upload->display_errors());
								$filepath[] = "";
							  }
							
							}
							else
							{
								$h = $k + 1;
								$filepath[] = $this->input->post("file_".$h);
							}	

						}
					
				}
				else
				{
					unset($filepath);
					$filepath = array();
				}
					
				$result = $this->Game_model->update_company_game($filepath);
	
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Assigned Game Updated Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error To Update Game. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function company_game_configuration()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			//print_r($data["games"] );

			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_configuration";
			$total_row = $this->Game_model->company_configured_games_count($Company_id);	
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
			
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './game_uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			
			$data["config_results"] = $this->Game_model->company_configured_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{
				
				$this->load->view('games/company_game_configuration', $data);
			}
			else
			{	
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
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();			   
				if($data77['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data77['full_path'];
					$configThumb['source_image'] = './uploads/icons/'.$upload77;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='game_uploads/'.$data77['file_name'];							
				}
				else
				{				
					$filepath = "";		
				}
						
				/* if ( !$this->upload->do_upload("file"))
				{			
					$filepath = "";
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "game_uploads/".$data['upload_data']['file_name'];
				} */
				
				$result = $this->Game_model->insert_company_game_configuration($filepath);
				
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Game Configured Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Game Configuration. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
		
	}
	
	public function check_level()
	{
		$GameId = $this->input->post("GameID");
		$GameLevel = $this->input->post("Gamelevel");
		$CompId = $this->input->post("Company_id");
		$Comp_Game_id = $this->input->post("Comp_Game_id");
		
		$resultOPT = $this->Game_model->check_game_level($CompId,$GameId,$Comp_Game_id,$GameLevel);
		
		 if($resultOPT > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}
	
	public function delete_company_game_configuration()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_configuration";
			$total_row = $this->Game_model->company_configured_games_count($Company_id);	
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

			$data["config_results"] = $this->Game_model->company_configured_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();

			if($_GET != NULL)
			{	
				$game_config_id = $_GET['game_config_id'];
				
				$result100 = $this->Game_model->delete_company_game_configuration($game_config_id);
				
				if($result100 == true)
				{
					$this->session->set_flashdata("success_code","Game Configuration Delete Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error To Delete Game Configuration. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			else
			{
				
				$this->load->view('games/company_game_configuration', $data);
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function edit_company_game_configuration()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_configuration";
			$total_row = $this->Game_model->company_configured_games_count($Company_id);	
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

			$data["config_results"] = $this->Game_model->company_configured_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();

			if($_GET != NULL)
			{	
				$game_config_id = $_GET['game_config_id'];
				
				$data['editResult'] = $this->Game_model->edit_company_game_configuration($Company_id,$game_config_id);
			
				$this->load->view('games/edit_company_game_configuration', $data);
			}
			else
			{
				
				$this->load->view('games/company_game_configuration', $data);
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_company_game_configuration()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_company_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_configuration";
			$total_row = $this->Game_model->company_configured_games_count($Company_id);	
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
			
			
			/*-----------------------File Upload---------------------*/
			$config['upload_path'] = './game_uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '500';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			/*-----------------------File Upload---------------------*/
			
			
			$data["config_results"] = $this->Game_model->company_configured_games_list($config["per_page"], $page, $Company_id);
			
			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{
				
				$this->load->view('games/company_game_configuration', $data);
			}
			else
			{	
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
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();			   
				if($data77['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data77['full_path'];
					$configThumb['source_image'] = './uploads/icons/'.$upload77;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='game_uploads/'.$data77['file_name'];							
				}
				else
				{				
					$filepath = "";		
				}
				
				$result = $this->Game_model->update_company_game_configuration($filepath);
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Game Configuration Updated Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Update Game Configuration. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function company_game_campaign()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_configured_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_campaign";
			$total_row = $this->Game_model->games_campaign_count($Company_id);	
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
			
			$data["cmp_results"] = $this->Game_model->company_games_campaign_list($config["per_page"], $page, $Company_id);

			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{	
				$this->load->view('games/company_game_campaign', $data);
			}
			else
			{	

				$result = $this->Game_model->insert_company_game_campaign();
				
				if($result == true)
				{
					$this->session->set_flashdata("success_code","Game Campaign Created Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Create Game Campaign. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function get_game_levels()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data15['username'] = $session_data['username'];
			$data15['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data15['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$Company_id = $session_data['Company_id'];
			$data15['LogginUserName'] = $session_data['Full_name'];
			
			$gameId = $this->input->post("game_id");
			
			$data15['game_levels'] = $this->Game_model->get_game_levels($gameId,$Company_id);
			
			$this->load->view("games/game_levels",$data15);
		}
		else
		{
			redirect('Login', 'refresh');
		}

	}
	
	public function delete_game_campaign()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_configured_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_campaign";
			$total_row = $this->Game_model->games_campaign_count($Company_id);	
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
			
			$data["cmp_results"] = $this->Game_model->company_games_campaign_list($config["per_page"], $page, $Company_id);

			$data["pagination"] = $this->pagination->create_links();
						
			if($_GET != NULL)
			{	
				$game_cmp_id = $_GET["game_cmp_id"];
				$Del_result = $this->Game_model->delete_company_game_campaign($game_cmp_id);
				
				if($Del_result == true)
				{
					$this->session->set_flashdata("success_code","Game Campaign Deleted Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Delete Game Campaign. Please Provide valid data!!");
				}
				
				redirect(current_url());
				
			}
			else
			{	
				$this->load->view('games/company_game_campaign', $data);		
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function validate_campaign_name()
	{
		$cmp_name = $this->input->post("cmp_name");
		$Company_id = $this->input->post("Company_id");
		
		$resultOPT1 = $this->Game_model->check_campaign_name($cmp_name,$Company_id);

		 if($resultOPT1 > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
		
	}
	
	public function edit_company_game_campaign()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_configured_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_campaign";
			$total_row = $this->Game_model->games_campaign_count($Company_id);	
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
			
			$data["cmp_results"] = $this->Game_model->company_games_campaign_list($config["per_page"], $page, $Company_id);

			$data["pagination"] = $this->pagination->create_links();
						
			if($_GET["game_cmp_id"] == NULL)
			{	
				$this->load->view('games/company_game_campaign', $data);
			}
			else
			{	
				$game_cmp_id = $_GET['game_cmp_id'];
				
				$data["result5"] = $this->Game_model->edit_company_campaign($game_cmp_id);
				$data["result6"] = $this->Game_model->edit_company_game_campaign($game_cmp_id);
				
				$this->load->view('games/edit_company_game_campaign', $data);
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_company_game_campaign()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data["games"] = $this->Game_model->get_configured_games($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/company_game_campaign";
			$total_row = $this->Game_model->games_campaign_count($Company_id);	
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
			
			$data["cmp_results"] = $this->Game_model->company_games_campaign_list($config["per_page"], $page, $Company_id);

			$data["pagination"] = $this->pagination->create_links();
						
			if($_POST == NULL)
			{	
				$this->load->view('games/company_game_campaign', $data);
			}
			else
			{	

				$result31 = $this->Game_model->update_company_game_campaign();
				
				if($result31 == true)
				{
					$this->session->set_flashdata("success_code","Game Campaign Updated Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Update Game Campaign. Please Provide valid data!!");
				}
				
				redirect(current_url());
			}
			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function approve_game_winner()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			$data['game_winners'] = $this->Game_model->get_game_winners($Company_id);
			
			$data['approved_game_winners'] = $this->Game_model->get_approved_game_winners($Company_id);
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Gamec/approve_game_winner";
			$total_row = $this->Game_model->game_winners_count($Company_id);	
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
			
			$data["pagination"] = $this->pagination->create_links();
						
	
			$this->load->view('games/game_winners', $data);

		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function declare_game_winner()
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
			
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			
			if($_GET['ID'] > 0)
			{
				$temp_id = 	$_GET['ID'];
				$comp_game_id = $_GET['comp_game_id'];
				$Enrollment_id = $_GET['Enrollment_id'];
				$award_flag = $_GET['award_flag'];
				$prize = $_GET['prize'];
				
				$customer_details = $this->Igain_model->get_enrollment_details($Enrollment_id);
				
				$Current_bal = $customer_details->Current_balance;
				
				$res_opt = $this->Game_model->set_game_winners($temp_id,$comp_game_id,$Enrollment_id,$Current_bal,$award_flag,$prize,$Company_id);
				
				$data['game_winners'] = $this->Game_model->get_game_winners($Company_id);
				
				$data['approved_game_winners'] = $this->Game_model->get_approved_game_winners($Company_id);
				
				$approved_game_winners = $this->Game_model->approved_game_winner_info($Company_id,$temp_id);
				print_r($approved_game_winners);
				
				foreach($approved_game_winners as $gw)
				{
					$Game_Name = $gw->Game_Name;
					$Award_flag = $gw->Award_flag;
					$Points_Prize = $gw->Points_Prize;
					
				}
				
				/*-----------------------Pagination---------------------*/			
				$config = array();
				$config["base_url"] = base_url() . "/index.php/Gamec/approve_game_winner";
				$total_row = $this->Game_model->game_winners_count($Company_id);	
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
				
				$data["pagination"] = $this->pagination->create_links();
							
				if($res_opt == true)
				{
					$Email_content = array(
						'Game_name' => $Game_Name,
						'Award_flag' => $Award_flag,
						'Points_Prize' => $Points_Prize,
						'Notification_type' => 'Game Winner Details',
						'Template_type' => 'Game_winner'
					);
					$this->send_notification->send_Notification_email($Enrollment_id,$Email_content,$data['enroll'],$Company_id);
				
					
					$this->session->set_flashdata("success_code","Game Winner Approved Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Approve Game Winner. Please Provide valid data!!");
				}

				$this->load->view('games/game_winners', $data);
				
			}
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
/************************************* Sandeep end **********************************************/
}
?>
