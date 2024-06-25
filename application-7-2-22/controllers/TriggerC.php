<?php

Class TriggerC extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('TriggerM/Trigger_model');	
		$this->load->model('Igain_model');
		$this->load->model('TierM/Tier_model');	
		$this->load->model('administration/Administration_model');
		$this->load->model('master/Game_model');
	}
	
	function trigger_notification()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$Logged_user_id = $session_data['userId'];
			
			/*-----------------------Pagination---------------------*/		
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/TriggerC/trigger_notification";
			$total_row = $this->Trigger_model->Trigger_count($Company_id);	
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
			
			$data["trigger_results"] = $this->Trigger_model->Triggers_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();
					
			/*-----------------------Pagination---------------------*/						
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["tier_results"] = $this->Tier_model->Tier_list(0,90000,$Company_id);
			
			$data["auction_results"] = $this->Administration_model->auction_list(0,90000,$Company_id);
			
			$data["loyalty_results"] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
			
			$data["game_results"] = $this->Game_model->company_games_list(0,90000,$Company_id);
			
			if($_POST == NULL)
			{
				$this->load->view('TriggerV/trigger_notification',$data);
			}
			else
			{
				/********Check Threshold value with next tier criteria*******************/
				if($this->input->post('Criteria')==1)//Member Defined
				{
					$CompanyID = $this->input->post("Company_id");
					$Tier_id = $this->input->post("Tierid");
					$Threshold_val = $this->input->post("Thresholdvalue");
					
					$data['tier_array'] = $this->Trigger_model->get_next_tier_details($Tier_id,$CompanyID);
					if($data['tier_array']!=NULL)
					{
						$this->session->unset_userdata('name');
						foreach($data['tier_array'] as $val)
						{
							$Criteria_value=$val->Criteria_value;
							
						}
					}
					if($Threshold_val >= $Criteria_value)
					{
						$this->session->set_flashdata("error_code","Threshold Value($Threshold_val) should be less than Upgrade Tier Value($Criteria_value) !!!");
						redirect(current_url());
					}
				}
				/**********************************************************/
			
				$insert_result = $this->Trigger_model->insert_trigger($Company_id);
				
				if($insert_result == true)
				{
					$this->session->set_flashdata("success_code","New Trigger Notification Created Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Inserting Trigger Notification. Please Provide valid data!!");
				}
				
				
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function trigger_name_validation()
	{
		
		$triggername = $this->input->post("triggername");
		$Company_id = $this->input->post("CompanyId");
		
		$res = $this->Trigger_model->check_trigger_name($Company_id,$triggername);

		if($res > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
		
	}
	
	
	public function delete_trigger()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$Logged_user_id = $session_data['userId'];
			
			/*-----------------------Pagination---------------------*/		
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/TriggerC/trigger_notification";
			$total_row = $this->Trigger_model->Trigger_count($Company_id);	
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
			
			$data["trigger_results"] = $this->Trigger_model->Triggers_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();
					
			/*-----------------------Pagination---------------------*/						
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["tier_results"] = $this->Tier_model->Tier_list(0,90000,$Company_id);
			
			$data["auction_results"] = $this->Administration_model->auction_list(0,90000,$Company_id);
			
			$data["loyalty_results"] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
			
			$data["game_results"] = $this->Game_model->company_games_list(0,90000,$Company_id);
			
			if($_GET == NULL)
			{
				//$this->session->set_flashdata("trigger_error_code","Error In Delte Trigger Notification. Please Provide valid data!!");
				
				$this->load->view('TriggerV/trigger_notification',$data);
			}
			else
			{			
				$TriggerId = $_GET['Trigger_id'];
			
				$delete_result = $this->Trigger_model->delete_trigger_notification($Company_id,$TriggerId);
				
				if($delete_result == true)
				{
					$this->session->set_flashdata("success_code","Trigger Notification Deleted Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Delete Trigger Notification. Please Provide valid data!!");
				}
				
				
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function edit_trigger_notification()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$Logged_user_id = $session_data['userId'];
			
			/*-----------------------Pagination---------------------*/		
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/TriggerC/trigger_notification";
			$total_row = $this->Trigger_model->Trigger_count($Company_id);	
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
			
			$data["trigger_results"] = $this->Trigger_model->Triggers_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();
					
			/*-----------------------Pagination---------------------*/						
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["tier_results"] = $this->Tier_model->Tier_list(0,90000,$Company_id);
			
			$data["auction_results"] = $this->Administration_model->auction_list(0,90000,$Company_id);
			
			$data["loyalty_results"] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
			
			$data["game_results"] = $this->Game_model->company_games_list(0,90000,$Company_id);
			
			if($_GET['Trigger_id'] == NULL)
			{
				$this->load->view('TriggerV/trigger_notification',$data);
			}
			else
			{		
				$triggerID = $_GET['Trigger_id'];
					
				$trigger_info = $this->Trigger_model->edit_trigger($Company_id,$triggerID);
				
				$data["trigger_info"] = $trigger_info;
				
				if($trigger_info == true)
				{
					$this->load->view('TriggerV/edit_trigger_notification',$data);
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Edit Trigger Notification. Please Provide valid data!!");
					
					$this->load->view('TriggerV/trigger_notification',$data);
				}
				
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	function update_trigger_notification()
	{
		if($this->session->userdata('logged_in'))
		{	
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Logged_user_enrollid = $session_data['enroll'];	
			$Logged_user_id = $session_data['userId'];
			
			/*-----------------------Pagination---------------------*/		
			 $config = array();
			$config["base_url"] = base_url() . "/index.php/TriggerC/trigger_notification";
			$total_row = $this->Trigger_model->Trigger_count($Company_id);	
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
			
			$data["trigger_results"] = $this->Trigger_model->Triggers_list($config["per_page"], $page,$Company_id);
			$data["pagination"] = $this->pagination->create_links();
					
			/*-----------------------Pagination---------------------*/						
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["tier_results"] = $this->Tier_model->Tier_list(0,90000,$Company_id);
			
			$data["auction_results"] = $this->Administration_model->auction_list(0,90000,$Company_id);
			
			$data["loyalty_results"] = $this->Igain_model->get_loyalty_rule($Company_id,$Logged_user_enrollid,$Logged_user_id);
			
			$data["game_results"] = $this->Game_model->company_games_list(0,90000,$Company_id);
			
			if($_POST == NULL)
			{
				$this->load->view('TriggerV/trigger_notification',$data);
			}
			else
			{		
				/********Check Threshold value with next tier criteria*******************/
				if($this->input->post('Criteria')==1)//Member Defined
				{
					$CompanyID = $this->input->post("Company_id");
					$Tier_id = $this->input->post("Tierid");
					$Threshold_val = $this->input->post("Thresholdvalue");
					
					$data['tier_array'] = $this->Trigger_model->get_next_tier_details($Tier_id,$CompanyID);
					if($data['tier_array']!=NULL)
					{
						$this->session->unset_userdata('name');
						foreach($data['tier_array'] as $val)
						{
							$Criteria_value=$val->Criteria_value;
							
						}
					}
					if($Threshold_val >= $Criteria_value)
					{
						$this->session->set_flashdata("error_code","Threshold Value($Threshold_val) should be less than Upgrade Tier Value($Criteria_value) !!!");
						redirect(current_url());
					}
				}
				/**********************************************************/
				$update_result = $this->Trigger_model->Update_trigger($Company_id);
				
				if($update_result == true)
				{
					$this->session->set_flashdata("success_code","Trigger Notification Updated Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Update Trigger Notification. Please Provide valid data!!");
				}
				
				
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	
	public function check_threshold_value_with_criteria()
	{
		
			$CompanyID = $this->input->post("Company_id");

			$Tier_id = $this->input->post("Tier_id");
			$Threshold_val = $this->input->post("Threshold_val");
			
			$data['tier_array'] = $this->Trigger_model->get_next_tier_details($Tier_id,$CompanyID);
			if($data['tier_array']!=NULL)
			{
				foreach($data['tier_array'] as $val)
				{
					$Criteria_value=$val->Criteria_value;
					
				}
				if($Threshold_val >= $Criteria_value)
				{
					$this->output->set_output("Threshold Value($Threshold_val) should be less than Upgrade Tier Value($Criteria_value) !!!");
				}
				else
				{
					$this->output->set_output(1);
				}
			}
			else
			{
				$this->output->set_output(1);
			}
			
			
		
	}
	
	public function get_next_tier()
	{
		if($this->session->userdata('logged_in'))
		{
			$CompanyID = $this->input->post("Company_id");

			$Tier_id = $this->input->post("Tier_id");
			
			$data['tier_array'] = $this->Trigger_model->get_next_tier_details($Tier_id,$CompanyID);
			
			$this->load->view('view_next_tier_details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function get_auction_info()
	{
		if($this->session->userdata('logged_in'))
		{
			$CompanyID = $this->input->post("Company_id");

			$Auctionid = $this->input->post("Auctionid");
			
			$data["auction_results"] = $this->Trigger_model->get_auction($Auctionid);
			$this->load->view('view_auction_details',$data);	
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
}

?>
