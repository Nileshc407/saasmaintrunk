<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

Class TierC extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('TierM/Tier_model');	
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Igain_model');
	}
	
	/***********************************************Sandeep Code Start **********************************************/

	public function tier_masterc()
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
		
			
			$data["tier_results"] = $this->Tier_model->Tier_list('', '',$Company_id);
							
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["Tier_levelB"] = $this->Tier_model->get_tier_levels($Company_id,$Tier_Business_flag=1);
			$data["Tier_levelI"] = $this->Tier_model->get_tier_levels($Company_id,$Tier_Business_flag=0);
			
			if($_POST == NULL)
			{
				$this->load->view('TierV/tier',$data);
			}
			else
			{			
				$insert_result = $this->Tier_model->insert_tier($Company_id);
				
				if($insert_result == true)
				{
					$this->session->set_flashdata("success_code","New Tier Created Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 1;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Create Tier";
						$where="Create / Edit Tier";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post("Tiername");
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Inserting Tier. Please Provide valid data!!");
				}
				
				
				redirect(current_url());
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function tier_name_validation()
	{
		
		$tierName = $this->input->post("tiername");
		$Company_id = $this->input->post("CompanyId");
		
		$res = $this->Tier_model->check_tier_name($Company_id,$tierName);

		if($res > 0)
		{
			$this->output->set_output("Already Exist");
		}
		else    
		{
			$this->output->set_output("Available");
		}
		
	}

	
	public function edit_tier()
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
			
			
			$data["tier_results"] = $this->Tier_model->Tier_list('', '',$Company_id);
								
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			$data["Tier_levelB"] = $this->Tier_model->get_tier_levels($Company_id,$Tier_Business_flag=1);
			$data["Tier_levelI"] = $this->Tier_model->get_tier_levels($Company_id,$Tier_Business_flag=0);
			
			if($_GET == NULL)
			{
				//$this->session->set_flashdata("tier_error_code","Error In Edit Tier. Please Provide valid data!!");
				
				$this->load->view('TierV/tier',$data);
			}
			else
			{			
				$TierID = $_GET['Tier_id'];
			
				$data["tier_details"] = $this->Tier_model->edit_tier($Company_id,$TierID);
				
				$this->load->view('TierV/edit_tier',$data);
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function update_tier()
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
			
			
			if($_POST == NULL)
			{
				//$this->session->set_flashdata("tier_error_code","Error In Update Tier. Please Provide valid data!!");
				
				$this->load->view('TierV/tier',$data);
			}
			else
			{			
				$TierID = $this->input->post("Tier_id");
				$update_result = $this->Tier_model->update_tier($Company_id);
				
				if($update_result == true)
				{
					$this->session->set_flashdata("success_code","Tier Updated Successfuly!!");
					
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 2;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Update Tier";
						$where="Create / Edit Tier";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $this->input->post('Tiername');
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else
				{							
					$this->session->set_flashdata("error_code","Error In Update Tier. Please Provide valid data!!");
				}
				
				
				redirect('TierC/tier_masterc');
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	
	public function delete_tier()
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
			
			
			$data["tier_results"] = $this->Tier_model->Tier_list('', '',$Company_id);
						
			
			$resultis = $this->Igain_model->get_company_details($session_data['Company_id']);
			$data["Company_details"] = $resultis;
			
			// $data["Tier_level"] = $this->Tier_model->get_tier_levels($Company_id);
			
			if($_GET == NULL)
			{
				//$this->session->set_flashdata("tier_error_code","Error In Delte Tier. Please Provide valid data!!");
				
				$this->load->view('TierV/tier',$data);
			}
			else
			{			
				$TierID = $_GET['Tier_id'];
				
				$tier_details =$this->Tier_model->get_tier_details($Company_id,$_GET['Tier_id']);
		
				$tierName=$tier_details->Tier_name;
				
				$delete_result = $this->Tier_model->delete_tier($Company_id,$TierID);
			
				 if($delete_result == true)
				{
					$this->session->set_flashdata("success_code","Tier Deleted Successfuly!!");
					/*****************Inactivate memebrs linked to this Tier********************/
					$Inactivate_members = $this->Tier_model->Inactivate_members_linked_to_tier($Company_id,$TierID,$data['enroll']);
					/*****************Inactivate memebrs linked to this Tier XXX********************/
					
					/*****************Inactivate Loyalty Rule linked to this Tier********************/
					$delete_rule = $this->Tier_model->Inactivate_Loyalty_rule_linked_to_tier($Company_id,$TierID);
					/*****************Inactivate Loyalty Rule linked to this Tier XXX********************/
					
					/*****************Delete Merchandise_item_ linked this Tier********************/
					$All_Active_Merchandize_Items_Records = $this->Catelogue_model->Get_Tier_linked_Merchandize_Items($TierID,$Company_id);
					if($All_Active_Merchandize_Items_Records!=NULL)
					{
						foreach($All_Active_Merchandize_Items_Records as $Val)
						{
							
							/*********************Check item has more than 1 branches************************/
							$Check_item_Tiers_count = $this->Catelogue_model->Check_linked_item_tiers_count($Val->Company_merchandize_item_code,$Company_id);
							 // echo "<br><br>".$Val->Company_merchandize_item_code."**Count***".$Check_item_Tiers_count[0];
							if($Check_item_Tiers_count[0]==1)
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
								'Update_User_id'=>$data['enroll'],
								'Update_date'=>date("Y-m-d H:i:s"),
								'Active_flag'=>1);
						
								$result12 = $this->Catelogue_model->Insert_Merchandize_Item_log_tbl($Post_data3);
								/********************/
								/**************Update merchandise table**********/
								$Post_data2 = array
								(
									'Update_user_id'=>$data['enroll'],
									'Update_date'=>date("Y-m-d H:i:s"),
									'Thumbnail_image4'=>"Remarks:Tier ID $TierID deleted",
									'Active_flag'=>0
								);
								$Update_item = $this->Catelogue_model->Update_Merchandize_Item($Val->Company_merchandise_item_id,$Post_data2);
								
								$delte2 = $this->Catelogue_model->Delete_Merchandize_Partners_Tier_linked_item($Val->Company_merchandize_item_code,$Company_id,$TierID);
								
								/**************delete temp cart linked item**********/
								$Delete_cart_item = $this->Catelogue_model->delete_linked_cart_item($Val->Company_merchandize_item_code,$Val->Company_id);
								
							}
							else
							{
								$delte2 = $this->Catelogue_model->Delete_Merchandize_Partners_Tier_linked_item($Val->Company_merchandize_item_code,$Company_id,$TierID);
							}
						}
							
					}
							
					/*****************Delete Merchandise_item_ linked this partner branch***XXX***********/
					/*******************Insert igain Log Table*********************/
						$Company_id	= $session_data['Company_id'];
						$Todays_date = date('Y-m-d');	
						$opration = 3;		
						$enroll	= $session_data['enroll'];
						$username = $session_data['username'];
						$userid=$session_data['userId'];
						$what="Delete Tier";
						$where="Create / Edit Tier";
						$toname="";
						$To_enrollid =0;
						$firstName = '';
						$lastName = '';
						$Seller_name = $session_data['Full_name'];
						$opval = $tierName;
						$result_log_table = $this->Igain_model->Insert_log_table($Company_id,$enroll,$username,$Seller_name,$Todays_date,$what,$where,$userid,$opration,$opval,$firstName,$lastName,$To_enrollid);
					/*******************Insert igain Log Table*********************/
				}
				else if($delete_result == false)
				{	 						
					$this->session->set_flashdata("error_code","Sorry, Tier not deleted because it has members!!");
				}
				
				
				redirect('TierC/tier_masterc');
			}			
		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
/***********************************************Sandeep Code End **********************************************/

}
?>
