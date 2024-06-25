<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
Class SegmentC extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Segment/Segment_model');	
		// $this->load->model('TierM/Segment_model');	
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Igain_model');
	}	
	/***********************************************Sandeep Code Start **********************************************/

	public function Segment()
	{
		if($this->session->userdata('logged_in'))
		{	
			$this->load->model('enrollment/Enroll_model');
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$Logged_user_id= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);	
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
			
			$data["Merchandize_Category_Records"] = $this->Segment_model->Get_Merchandize_Category($Company_id);
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["Segment_type"] = $this->Segment_model->get_segment_type();
			
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			$data["segment_results"] = $this->Segment_model->Segment_list('', '',$Company_id);
			if($_POST == NULL)
			{
				/*************Nilesh Start 21-08-2018 Segment Handlers*************/
				 $opt = $this->Segment_model->Segment_handlers($Company_id); 
				
				/*****************Gender wise member segment Graph******************/	
				$Sex_wise_member = $this->Segment_model->Gender_wise_member_graph($Company_id);				
				if($Sex_wise_member != 0)
				{	
					$prefix = '';
					$html = "[\n";
					
					foreach($Sex_wise_member as $row12)
					{
						$html .= $prefix . " {\n";
						$html .= '  "category": "Male Members",' . "\n";
						$html .= '  "value1": ' . $row12->Total_male_members . '' . "\n";
						$html .= " }";
						$html .= $prefix . ",\n";
						
						$html .= $prefix . " {\n";
						$html .= '  "category": "Female Members",' . "\n";
						$html .= '  "value1": ' . $row12->Total_female_members . '' . "\n";
						$html .= " }";
						$prefix = ",\n";	
						
						$html .= $prefix . " {\n";
						$html .= '  "category": "Not Mentioned Members",' . "\n";
						$html .= '  "value1": ' . $row12->Total_other_members . '' . "\n";
						$html .= " }";
						$prefix = ",\n";
					}
					
					$html .= "\n]";
					$data['Chart_data1'] = $html;				
				}
				/**********************Gender wise member Graph***********************/
				/*********City/Distribution of Customer Profile Gender wise Graph********/

				$City_wise_member = $this->Segment_model->City_wise_member_gender_graph($Company_id);
				
				if($City_wise_member != 0)
				{	
					$prefix = '';
					$html = "[\n";
					
					foreach($City_wise_member as $row13)
					{
						$City_name = $this->Segment_model->Get_city_name($row13->City_id);
						if($City_name!=NULL)
						{
							$CityName=$City_name->name;
						}
						else
						{
							$CityName="-";
						}
							
						$html .= $prefix . " {\n";
						$html .= '  "City": " '.$CityName.' ",' . "\n";
						$html .= '  "MaleMember": ' . $row13->Total_male_members . ',' . "\n";	
						$html .= '  "FemaleMember": ' . $row13->Total_female_members . ',' . "\n";
						$html .= '  "OtherMember": ' . $row13->Total_other_members . '' . "\n";
						$html .= " } ";
						$html .= $prefix . ",\n";
					}
					$html .= "\n]";
					$data['Chart_data2'] = $html;				
				}
				/*********City/Distribution of Customer Profile Gender wise Graph*******/
				/*****************Age_wise_member_profile_segment_graph**************/
				$Age_wise_member = $this->Segment_model->Age_wise_member_profile_graph($Company_id);
				
				if($Age_wise_member != 0)
				{	
					$prefix = '';
					$html = "[\n";
					
					foreach($Age_wise_member as $row14)
					{
						$City_name = $this->Segment_model->Get_city_name($row14->City_id);
						if($City_name!=NULL)
						{
							$CityName=$City_name->name;
						}
						else
						{
							$CityName="-";
						}
						
						$html .= $prefix . " {\n";
						$html .= '  "City": " '.$CityName.' ",' . "\n";
						$html .= '  "YoungMember": ' . $row14->Total_young_members . ',' . "\n";	
						$html .= '  "MiddleAgeMember": ' . $row14->Total_middle_age_members . ',' . "\n";
						$html .= '  "SeniorMember": ' . $row14->Total_senior_members . ',' . "\n";
						$html .= '  "OldMember": ' . $row14->Total_old_members . '' . "\n";
						$html .= " } ";
						$html .= $prefix . ",\n";
					}
					$html .= "\n]";
					$data['Chart_data3'] = $html;				
				}
				/****************Age_wise_member_profile_segment_graph*************/
				/*********Export graph pdf*********/
			/*	$todays2 = date("M");	$todays1 = date("d");	$todays3 = date("Y");
				$Company_details = $this->Igain_model->get_company_details($Company_id);
				$data['Graph_name'] = str_replace(" ", "_", $Company_details->Company_name).'-'.$todays1.'-'.$todays2.'-'.$todays3.'-Segment_Handlers.pdf'; */
				/*********Export graph pdf*********/
				/****************Nilesh End 27-08-2018 Segment Handlers***********************/
				
				$this->load->view('Segment/SegmentV',$data);
			}
			else
			{	
				// print_r($_REQUEST['SegmentType_1']);die;
				$insert_result = $this->Segment_model->Insert_segment($Company_id,$data['enroll']);
				$SegmentType=$this->input->post("SegmentType");
				/****************Item Category*********************************
				if($SegmentType==13)
				{
					$linked_itemcode=$this->input->post("linked_itemcode");
					$linked_Category_id=$this->input->post("linked_Category_id");
					$linked_Quantity=$this->input->post("linked_Quantity");
				
					if($linked_itemcode != "")
					{
						
						$exp_itm = explode(',',$linked_itemcode);
						$exp_Quantity = explode(',',$linked_Quantity);
						// $linked_Category_id = explode(',',$linked_Category_id);
						
						for($i=0;$i<count($exp_itm);$i++)
						{
							$Post_data=array('Company_id'=>$data['Company_id'],
							'Item_code'=>$exp_itm[$i],
							'Quantity'=>$exp_Quantity[$i],
							'Segment_Code'=>$this->input->post("Segment_Code"),
							'Category_id'=>$linked_Category_id
							);
					
							$Insert_items = $this->Segment_model->Insert_items_segment_child($Post_data);
						}
					}
				}
				/****************************************************/
				if($insert_result == true)
				{
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Segment";
						$where="Segment Master";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post("Segment_name");
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					$this->session->set_flashdata("success_code","New Segment Created Successfuly!!");
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Inserting Segment. Please Provide valid data!!");
				}			
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function autocomplete_country_names()
	{	
		if (isset($_GET['term']))
		{
			$keyword = strtolower($_GET['term']);
			$this->Segment_model->get_countryname($keyword);
		}			
	}
	public function autocomplete_state_names()
	{	
		if (isset($_GET['term']))
		{
			$keyword = strtolower($_GET['term']);
			$this->Segment_model->get_statename($keyword);
		}			
	}
	public function autocomplete_city_names()
	{	
		if (isset($_GET['term']))
		{
			$keyword = strtolower($_GET['term']);
			$this->Segment_model->get_cityname($keyword);
		}			
	}
	public function Gender_wise_member_graph()
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
			/*------------------------ Graph------------------------------*/			 
			$member_status = $this->Segment_model->Gender_wise_member_graph($Company_id);
			
			if($member_status != 0)
			{	
				$prefix = '';
				$html = "[\n";
				
				foreach($member_status as $row12)
				{
					$html .= $prefix . " {\n";
					$html .= '  "category": "Male Members",' . "\n";
					$html .= '  "value1": ' . $row12->Total_male_members . '' . "\n";
					$html .= " }";
					$html .= $prefix . ",\n";
					
					$html .= $prefix . " {\n";
					$html .= '  "category": "Female Members",' . "\n";
					$html .= '  "value1": ' . $row12->Total_female_members . '' . "\n";
					$html .= " }";
					$prefix = ",\n";	
					
					$html .= $prefix . " {\n";
					$html .= '  "category": "Other Members",' . "\n";
					$html .= '  "value1": ' . $row12->Total_other_members . '' . "\n";
					$html .= " }";
					$prefix = ",\n";
				}
				
				$html .= "\n]";
				$data['Chart_data3'] = $html;				
			}
				$this->load->view('Segment/show_member_sex_status_graph',$data);
			/*------------------------------Graph-----------------------------*/
		}
		else
		{
			$this->load->view('Segment/SegmentV',$data);
		}
	}
	public function show_member_sex_status_graph_detail1()
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
			/*------------------------ Graph------------------------------*/			 
			$member_status = $this->Segment_model->member_sex_status_graph_detail(3);
			
			if($member_status != 0)
			{	
				$prefix = '';
				$html = "[\n";
				
				foreach($member_status as $row12)
				{
					$html .= $prefix . " {\n";
					$html .= '  "category": "Male Members",' . "\n";
					$html .= '  "value1": ' . $row12->Total_male_members . '' . "\n";
					$html .= " }";
					$html .= $prefix . ",\n";
					
					$html .= $prefix . " {\n";
					$html .= '  "category": "Female Members",' . "\n";
					$html .= '  "value1": ' . $row12->Total_female_members . '' . "\n";
					$html .= " }";
					$prefix = ",\n";	
					
					$html .= $prefix . " {\n";
					$html .= '  "category": "Other Members",' . "\n";
					$html .= '  "value1": ' . $row12->Total_other_members . '' . "\n";
					$html .= " }";
					$prefix = ",\n";
				}
				
				$html .= "\n]";
				$data['Chart_data3'] = $html;	
				$this->output->set_output(json_encode(array('Chart_data3'=> $data['Chart_data3'])));				
			}
			/*------------------------------Graph-----------------------------*/
		}
		else
		{
			$this->load->view('Segment/SegmentV',$data);
		}
	}	
	public function Segment_code_validation()
	{
		
		$SegmentCode = $this->input->post("SegmentCode");
		$SegmentName = $this->input->post("SegmentName");
		$Company_id = $this->input->post("CompanyId");
		
		if($SegmentCode != ""){
			$res = $this->Segment_model->check_segment_code($Company_id,$SegmentCode,"");
		}
		
		if($SegmentName != ""){
			$res = $this->Segment_model->check_segment_code($Company_id,"",$SegmentName);
		}
		
		if($res > 0)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		}
		
	}	
	public function edit_segment()
	{
		if($this->session->userdata('logged_in'))
		{	
			$this->load->model('enrollment/Enroll_model');
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];	
			$data['userId']= $session_data['userId'];
			$Logged_user_id= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller'] = $session_data['Super_seller'];
			$get_sellers15 = $this->Igain_model->get_seller_details($session_data['enroll']);
			$data["Tier_list"] = $this->Enroll_model->get_lowest_tier($Company_id);	
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
			
			
			$data["segment_results"] = $this->Segment_model->Segment_list('', '',$Company_id);
			
			$data["Merchandize_Category_Records"] = $this->Segment_model->Get_Merchandize_Category($Company_id);
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			$data["Hobbies_list"] = $this->Igain_model->get_hobbies_interest();
			$data["Segment_type"] = $this->Segment_model->get_segment_type();			
			if($_GET == NULL)
			{
				//$this->session->set_flashdata("tier_error_code","Error In Edit Tier. Please Provide valid data!!");
				
				$this->load->view('Segment/SegmentV',$data);
			}
			else
			{			
				$SegmentCode = $_GET['SegmentCode'];
				$Company_id = $_GET['CompanyId'];
			
				$data["segment_details"] = $this->Segment_model->edit_segment($Company_id,$SegmentCode);
				$data["segment_edit_results"] = $this->Segment_model->edit_segment_code($Company_id,$SegmentCode);				
				$this->load->view('Segment/edit_segment',$data);
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function update_segment()
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
					
			
				$update_result = $this->Segment_model->update_segment($Company_id,$data['enroll']);	
					/****************Item Category*********************************
				$linked_itemcode=$this->input->post("linked_itemcode");
				$linked_Category_id=$this->input->post("linked_Category_id");
				$linked_Quantity=$this->input->post("linked_Quantity");
				
					
					if($linked_itemcode != "")
					{
						
						$exp_itm = explode(',',$linked_itemcode);
						$exp_Quantity = explode(',',$linked_Quantity);
						// $linked_Category_id = explode(',',$linked_Category_id);
						
						for($i=0;$i<count($exp_itm);$i++)
						{
							$Post_data=array('Company_id'=>$data['Company_id'],
							'Item_code'=>$exp_itm[$i],
							'Quantity'=>$exp_Quantity[$i],
							'Segment_Code'=>$this->input->post("Segment_Code"),
							'Category_id'=>$linked_Category_id
							);
					
							$Insert_items = $this->Segment_model->Insert_items_segment_child($Post_data);
						}
					}
				
				/****************************************************/
				if($update_result == true)
				{
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Segment";
						$where="Segment Master";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post("Segment_name");
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
					$this->session->set_flashdata("success_code","Segment Updated Successfully!!");
				}
				/* else
				{							
					$this->session->set_flashdata("error_code","Error In Update Segment. Please Provide valid data!!");
				}  */				
				// redirect(current_url());
				redirect('SegmentC/Segment');
						
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}	
	public function delete_segment()
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
							
			
					
			$segmentcode = $_GET['segment_code'];
			$segment_details = $this->Segment_model->edit_segment($Company_id,$segmentcode);
			$segementName=$segment_details->Segment_name;
			/*********Delete from child table*************************/	
			
				$delete_child = $this->Segment_model->delete_segment_child($Company_id,$segmentcode);
			
			/*************************************************/	
			$delete_result = $this->Segment_model->delete_segment_code($Company_id,$segmentcode);
		
			if($delete_result == true)
			{
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Segment";
					$where="Segment Master";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $segementName;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				
				$this->session->set_flashdata("success_code","Segment Deleted Successfuly!!");
			}
			else if($delete_result == false)
			{	 						
				$this->session->set_flashdata("error_code","Sorry, Segment deleted error!!");
				
				// $this->session->set_flashdata("segment_error_code","Sorry, You could not delete this segment Becouse you Created Loyalty Rule On This segment!!!");
			}				  
			
			// redirect(current_url());
			redirect('SegmentC/Segment');
						
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function Check_segment_link()
	{
		$segmentcode=$_REQUEST['segmentcode'];
		$Company_id=$_REQUEST['Company_id'];
		
		$result = $this->Segment_model->Check_segment_code_link($Company_id,$segmentcode);
		if($result == NULL)
		{
			$this->output->set_output("1");
		}
		else    
		{
			$this->output->set_output("0");
		} 
	}
	public function delete_segment_id()
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
			
			$Segmentid=$this->input->get("Segmentid");				
				
				
			/*************************************************/	
			$delete_result = $this->Segment_model->delete_segment_id($Company_id,$Segmentid);				
			if($delete_result == true)
			{
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Segment Criteria";
					$where="Edit Segment Master";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Segmentid;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
					
				$this->output->set_output("Segment Deleted Successfuly");
				$this->session->set_flashdata("success_code","Segment Criteria Deleted Successfuly!!");
			}
			
			redirect('SegmentC/Segment');	
						
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	public function delete_segment_child()
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
			
			
			$Segment_child_id=$this->input->get("Segment_child_id");	

			/*********Delete from child table**************************/
			$delete_result = $this->Segment_model->delete_segment_child($Segment_child_id);
				
			/*************************************************/	
			if($delete_result == true)
			{
				/*******************Insert igain Log Table*********************/
					$Company_id	= $session_data['Company_id'];
					$Todays_date = date('Y-m-d');	
					$opration = 3;		
					$enroll	= $session_data['enroll'];
					$username = $session_data['username'];
					$userid=$session_data['userId'];
					$what="Delete Segment Criteria";
					$where="Edit Segment Master";
					$To_enrollid =0;
					$firstName = '';
					$lastName = '';
					$Seller_name = $session_data['Full_name'];
					$opval = $Segment_child_id;
					$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
				/*******************Insert igain Log Table*********************/
				
				$this->output->set_output("Segment Deleted Successfuly");
				$this->session->set_flashdata("success_code","Segment Criteria Deleted Successfuly!!");
			}
				
				redirect('SegmentC/Segment');	
						
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
/*************************AMIT KAMBLE 04-02-2020 **************************/
	public function Get_items_for_segment()
	{
		$data['Company_id']=$this->input->post("Company_id");
		$data['Segment_Code']=$this->input->post("Segment_Code");
		
		$data['Get_Linked_Items_for_segment'] = $this->Segment_model->Get_Linked_Items_for_segment($this->input->post("Merchandize_category_id"),$this->input->post("Company_id"));
		
		
		
		$theHTMLResponse = $this->load->view('Segment/Get_items_for_segment', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Items_by_category'=> $theHTMLResponse)));
	}
	public function Save_items_segment()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Item_code=$this->input->post("Item_code");
		$Segment_Code=$this->input->post("Segment_Code");
		$Merchandize_category_id=$this->input->post("Merchandize_category_id");
		$Seg_Quantity=$this->input->post("Seg_Quantity");
		
		$Merchandize_item_name=$this->input->post("Merchandize_item_name");
		
			 //$Delete_discount_items = $this->Segment_model->Delete_segment_items($data['Company_id'],$Segment_Code);
			// echo count($Item_code);die;
			for($i=0; $i<count($Item_code); $i++)
			{
				/* 
				$Post_data=array('Company_id'=>$data['Company_id'],
				'Item_code'=>$Item_code[$i],
				'Category_id'=>$Merchandize_category_id,
				'Segment_Code'=>$Segment_Code);
				if($Item_code[$i] != '' && $Merchandize_category_id!=0 )
				{
					$Insert_items = $this->Segment_model->Insert_items_segment_child($Post_data);
				}
				 */
				
				$Item_code2[]= $Item_code[$i];
				$Category_id= $Merchandize_category_id;
				$Merchandize_item_name2[]= $Merchandize_item_name[$i];
				$Seg_Quantity2[]= $Seg_Quantity[$i];
				
			}
		$data['Item_code3'] = $Item_code2;
		$data['Merchandize_item_name3'] = $Merchandize_item_name2;
		$data['Seg_Quantity3'] = $Seg_Quantity2;
		
		$data['Get_linked_segment_items'] = $this->Segment_model->Get_linked_items_segment_child($data['Company_id'],$Segment_Code);
		$theHTMLResponse = $this->load->view('Segment/Get_linked_segment_items', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('linked_itemcode'=> $Item_code2,'linked_Quantity'=> $Seg_Quantity2,'linked_Category_id'=> $Category_id,'Linked_items'=> $theHTMLResponse)));
	}
	
	public function Get_segment_linked_items_table()
	{
		$session_data = $this->session->userdata('logged_in');
		$data['Company_id'] = $session_data['Company_id'];
		$Segment_Code=$this->input->post("Segment_Code");
		
		
		
		$data['Get_linked_segment_items'] = $this->Segment_model->Get_linked_items_segment_child($data['Company_id'],$Segment_Code);
		$theHTMLResponse = $this->load->view('Segment/Get_segment_linked_items_table', $data, true);		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Linked_items'=> $theHTMLResponse)));
	}
	
}
?>