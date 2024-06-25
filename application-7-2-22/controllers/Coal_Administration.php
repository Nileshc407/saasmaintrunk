<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coal_Administration extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();			
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->model('Coal_administration/Administration_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Send_notification');
		$this->load->model('enrollment/Enroll_model');
	}
	//**************** Ravi Start ***************************************			
	function auction()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Coal_Administration/auction";
			$total_row = $this->Administration_model->auction_count($session_data['Company_id']);	
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
				$data["results"] = $this->Administration_model->auction_list($config["per_page"], $page, $session_data['Company_id']);		
				$data["pagination"] = $this->pagination->create_links();
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
					$get_sellers = $this->Igain_model->get_company_sellers($session_data['Company_id']);
				}
				else
				{	
					$get_sellers = $this->Igain_model->get_seller_details($session_data['enroll']);
				}			
				$data['Seller_array'] = $get_sellers;
				
				
				$this->load->view('Coal_administration/create_auction',$data);
			}
			else
			{
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './Auction_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = TRUE;	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
			
				/* if ( !$this->upload->do_upload("file"))
				{			
					$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
					$filepath = "";
				}
				else
				{
					$data = array('upload_data' => $this->upload->data("file"));
					$filepath = "Auction_images/".$data['upload_data']['file_name'];
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
				
				
				
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();			   
				if($data77['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data77['full_path'];
					$configThumb['source_image'] = './Auction_images/'.$upload77;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='Auction_images/'.$data77['file_name'];							
				}
				else
				{				
					$filepath = $this->input->post('file_exist');
				}
				
				$result = $this->Administration_model->insert_auction($filepath);	
				
				$From_date = date("Y-m-d",strtotime($this->input->post("startDate")));
				$To_date = date("Y-m-d",strtotime($this->input->post("endDate")));	
				$auction_name = $this->input->post("auction_name");
				$minpointstobid = $this->input->post("minpointstobid");
				$description = $this->input->post("description");
				
				$Email_content = array(
					'Auction_start_date' => $From_date,
					'Auction_end_date' => $To_date,
					'Auction_name' => $auction_name,
					'Minimum_bid' => $minpointstobid,
					'Auction_description' => $description,
					'Notification_type' => 'Auction Details',
					'Template_type' => 'Auction'
				);
				$all_customers = $this->Igain_model->get_all_customers($session_data['Company_id']);
				foreach($all_customers as $customers)
				{
					$this->send_notification->send_Notification_email($customers['Enrollement_id'],$Email_content,$Logged_user_enrollid,$session_data['Company_id']);
				}
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Created Successfuly..!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Creating Auction. Please Provide valid data..!!");
				}
				redirect(current_url());
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	public function delete_auction()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$Com_id = $session_data['Company_id'];
			
			if($_GET == NULL)
			{
				redirect("Coal_Administration/auction");
			}
			else
			{	
				$Auction_id =  $_GET['Auction_id'];
				$result = $this->Administration_model->delete_auction($Com_id,$Auction_id);
				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Deleted Successfuly..!!");
				}
				else
				{
					$this->session->set_flashdata("error_code","Auction Not Deleted, Because Members bid for this Auction..!!");
				}
				redirect("Coal_Administration/auction");
			}
		}
	}	
	public function edit_auction()
	{	
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];			
			
			/*-----------------------Pagination---------------------*/			
			$config = array();
			$config["base_url"] = base_url() . "/index.php/Administration/auction";
			$total_row = $this->Administration_model->auction_count($session_data['Company_id']);	
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
			
			if($_GET['Auction_id'])
			{
				$data["results2"] = $this->Administration_model->auction_list($config["per_page"], $page, $session_data['Company_id']);		
				$data["pagination"] = $this->pagination->create_links();
				$Auction_id =  $_GET['Auction_id'];			
				$data['results'] = $this->Administration_model->edit_auction($Auction_id);				
				$this->load->view('Coal_administration/edit_auction',$data);
			}
			else
			{
				redirect("Coal_Administration/auction");
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	public function update_auction()
	{
		if($this->session->userdata('logged_in'))
		{		
			if($_POST == NULL)
			{
				redirect("Coal_Administration/auction");
			}
			else
			{
				/*-----------------------File Upload---------------------*/
				$config['upload_path'] = './Auction_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '1920';
				$config['max_height'] = '1280';
				$config['encrypt_name'] = TRUE;				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				/*-----------------------File Upload---------------------*/
			
				/* if(empty($_FILES['file']['name']))
				{
					$filepath = $this->input->post('Auction_image');
				}
				else
				{
					if ( !$this->upload->do_upload("file"))
					{			
						$this->session->set_flashdata("upload_error_code",$this->upload->display_errors());
						$filepath = $this->input->post('Auction_image');
					}
					else
					{
						$data = array('upload_data' => $this->upload->data("file"));
						$filepath = "Auction_images/".$data['upload_data']['file_name'];						
					}
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
				
				
				
				$upload77 = $this->upload->do_upload('file');
				$data77 = $this->upload->data();			   
				if($data77['is_image'] == 1) 
				{						 
					$configThumb['source_image'] = $data77['full_path'];
					$configThumb['source_image'] = './Auction_images/'.$upload77;
					$this->image_lib->initialize($configThumb);
					$this->image_lib->resize();
					$filepath='Auction_images/'.$data77['file_name'];							
				}
				else
				{				
					$filepath = $this->input->post('file_exist');
				}				
				
				$result = $this->Administration_model->update_auction($filepath);				
				if($result == true)
				{
					$this->session->set_flashdata("error_code","Auction Updated Successfuly..!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error Updating Auction. Please Provide valid data..!!");
				}
				redirect("Coal_Administration/auction");
			}
		}
	}	
	public function check_auction_name()
	{
		$result = $this->Administration_model->check_auction_name($this->input->post("Auction_name"),$this->input->post("Company_id"));
		
		if($result > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
	}	
	function approve_auction()
	{
		if($this->session->userdata('logged_in'))
		{
			// $this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$Logged_user_enrollid = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Logged_user_id = $session_data['userId'];
			$data['LogginUserName'] = $session_data['Full_name'];
			
			if($_POST == NULL)
			{
				$Max_Bid_value = $this->Administration_model->get_max_bid_value($data['Company_id']);				
				if($Max_Bid_value != 0)
				{
					$data["Max_Bid_value"] = $Max_Bid_value;
					
					foreach($data["Max_Bid_value"] as $Max_Bid_value)
					{
						$auction_winners_list[] = $this->Administration_model->auction_winners_list($data['Company_id'],$Max_Bid_value->Bid_value);
					}
					$data["results"] = $auction_winners_list;
				}
				else
				{
					$data["results"] = "";
				}
					
					$data["approved_auction_list"] = $this->Administration_model->approved_auction_list($data['Company_id']);
					
				$this->load->view('Coal_administration/approve_auction',$data);
			}
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	
	function auction_cust_details()
	{
		$data['cust_details'] = $this->Igain_model->get_enrollment_details($this->input->post("Enrollment_id"));
		$theHTMLResponse = $this->load->view('Coal_administration/auction_cust_details', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('auction_cust_details'=> $theHTMLResponse)));
	}
	
	function approve_auction_winner()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$sellerid=$this->input->get("sellerid");
			echo"---sellerid----".$sellerid."---<br>";
			// die;
			$auction_cust_details = $this->Administration_model->get_auction_cust_details($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			$auction_details = $this->Administration_model->edit_auction($this->input->get("Auction_id"));
			$cust_details = $this->Igain_model->get_enrollment_details($this->input->get("Enrollment_id"));
			$Curr_balance = $cust_details->Current_balance;
			$Bid_value=$auction_cust_details->Bid_value;
			$Curr_balance = $Curr_balance - $auction_cust_details->Bid_value;			
			$Blocked_points = $cust_details->Blocked_points;
			$Blocked_points = $Blocked_points - $auction_cust_details->Bid_value;
			
			if($Blocked_points < 0)
			{
				$Blocked_points = 0;
			}			
			$update_data = array(
								'Current_balance' => $Curr_balance ,
								'Blocked_points' => $Blocked_points 
							);
							
							
							
			$result1 = $this->Administration_model->update_cust_details($this->input->get("Enrollment_id"),$update_data);
			
			$result2 = $this->Administration_model->approve_auction_winner($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			$result3 = $this->Administration_model->update_auction_master($this->input->get("Auction_id"),$data['Company_id']);
			
			
			$Cust_prepayment_balance_1 = $this->Administration_model->Get_cust_prepayment_balance($data['Company_id'],$sellerid,$this->input->get("Enrollment_id"));
			
			$Custblockamt= $Cust_prepayment_balance_1->Cust_block_amt;
			$prepayment_balance= $Cust_prepayment_balance_1->Cust_prepayment_balance;
			
			// echo"---Custblockamt----".$Custblockamt."---<br>";
			// echo"---Bid_value----".$Bid_value."---<br>";
			// echo"---prepayment_balance----".$prepayment_balance."---<br>";
			$Custblockamt_1=$Custblockamt-$Bid_value;
			$prepaymentbalance_1=$prepayment_balance-$Bid_value;
			
			// echo"---Custblockamt_1----".$Custblockamt_1."---<br>";
			
			$update_data_1 = array(
								'Cust_block_amt' => $Custblockamt_1 ,
								'Cust_prepayment_balance' => $prepaymentbalance_1
								);
			// var_dump($update_data_1);
								
			$result_3 = $this->Administration_model->update_cust_prepayment_balance($data['Company_id'],$sellerid,$this->input->get("Enrollment_id"),$update_data_1);					
						
			$Email_content = array(
				'Auction_name' => $auction_details->Auction_name,
				'Notification_type' => 'Auction Winner Details',
				'Template_type' => 'Auction_winner'
			);
			
			$this->send_notification->send_Notification_email($auction_cust_details->Enrollment_id,$Email_content,$data['enroll'],$auction_cust_details->Company_id);
			
			// die;
			
			if($result1 == true && $result2 == true && $result3 == true)
			{
				$this->session->set_flashdata("error_code","Auction Winner Approved Successfuly..!!");
			}
			else
			{							
				$this->session->set_flashdata("error_code","Error Approving Auction Winner..!!");
			}
			redirect("Coal_Administration/approve_auction");
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}	
	function delete_auction_winner()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->output->enable_profiler(TRUE);
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['Company_id'] = $session_data['Company_id'];
			$Sellerid=$this->input->get("Sellerid");
			$auction_cust_details = $this->Administration_model->get_auction_cust_details($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));
			
			$cust_details = $this->Igain_model->get_enrollment_details($this->input->get("Enrollment_id"));
			$Curr_balance = $cust_details->Current_balance;	
			$Bid_value=	$auction_cust_details->Bid_value;			
			$Blocked_points = $cust_details->Blocked_points;
			$Blocked_points = $Blocked_points - $auction_cust_details->Bid_value;			
			if($Blocked_points < 0)
			{
				$Blocked_points = 0;
			}			
			$update_data = array(
									'Current_balance' => $Curr_balance ,
									'Blocked_points' => $Blocked_points 
								);
			$result1 = $this->Administration_model->update_cust_details($this->input->get("Enrollment_id"),$update_data);
			
			$result2 = $this->Administration_model->delete_auction_winner($this->input->get("ID"),$this->input->get("Auction_id"),$this->input->get("Enrollment_id"));			
			
			$Available_Current_balance=($Curr_balance-$Blocked_points);
			
			
			
			
			$Cust_prepayment_balance_1 = $this->Administration_model->Get_cust_prepayment_balance($data['Company_id'],$Sellerid,$this->input->get("Enrollment_id"));
			
			$Custblockamt= $Cust_prepayment_balance_1->Cust_block_amt;
			// $prepayment_balance= $Cust_prepayment_balance_1->Cust_prepayment_balance;
			
			$Custblockamt_1=$Custblockamt-$Bid_value;
			// $prepaymentbalance_1=$prepayment_balance-$Bid_value;			
			// echo"---Custblockamt_1----".$Custblockamt_1."---<br>";
			
			$update_data_1 = array(
								'Cust_block_amt' => $Custblockamt_1
								);
			
			$result_3 = $this->Administration_model->update_cust_prepayment_balance($data['Company_id'],$Sellerid,$this->input->get("Enrollment_id"),$update_data_1);
			
			
			$Cust_prepayment_balance_1 = $this->Administration_model->Get_cust_prepayment_balance($data['Company_id'],$Sellerid,$this->input->get("Enrollment_id"));
			
			$Custblockamt= $Cust_prepayment_balance_1->Cust_block_amt;
			$prepayment_balance= $Cust_prepayment_balance_1->Cust_prepayment_balance-$Custblockamt;			
			$auction_details = $this->Administration_model->edit_auction($this->input->get("ID"));
				$Email_content = array(
				'Auction_name' => $auction_details->Auction_name,
				'Bid_value' => $auction_cust_details->Bid_value,
				'Available_Current_balance' => $Available_Current_balance,
				// 'Available_Current_balance' => $prepayment_balance,
				'Coalition' =>1,
				'Notification_type' => 'Cancellation of Auction '.$auction_details->Auction_name.'',
				'Template_type' => 'Auction_winner_cancel'
			);
			$this->send_notification->send_Notification_email($this->input->get("Enrollment_id"),$Email_content,$data['enroll'],$auction_cust_details->Company_id);		

			// die;
			/*************************************************************************/			
			if($result1 == true && $result2 == true)
			{
				$this->session->set_flashdata("error_code","Auction Winner Deleted Successfuly..!!");
			}
			else
			{							
				$this->session->set_flashdata("error_code","Error Deleting Auction Winner..!!");
			}
			redirect("Coal_Administration/approve_auction");
		}
		else
		{		
			redirect('Login', 'refresh');
		}
	}
	/*************************************************Ravi END*****************************************/	
}
?>
