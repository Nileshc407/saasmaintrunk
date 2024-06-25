<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
class Auto_process_free_items_onquantity extends CI_Controller 
{
	
	public function __construct()
	{
		
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Coal_catalogue/Catelogue_model');
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->model('Redemption_Catalogue/Redemption_Model');
	}	
	public function index()
	{
		
		/* $Trans_id_array = array();
		$Enrollement_id_array = array();
		$Total_purchase_quantity_array = array();
		$Remaining_purchase_quantity_array = array(); */
	
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("Y-m-d H:i:s");
		$Month_date=date("m-d"); 	
		
		$Company_id=3;	
		
		$Company_Records = $this->Igain_model->get_company_details($Company_id);
				
				$Company_id = $Company_Records->Company_id;
				
				$Cust_apk_link = $Company_Records->Cust_apk_link;
				$Cust_ios_link = $Company_Records->Cust_ios_link;
				$Company_name = $Company_Records->Company_name;
				$Company_website = base_url()."Company_".$Company_id."/index.php"; 							
				$Get_Cust_Records = $this->Igain_model->get_all_customers($Company_id);
				
				if($Get_Cust_Records !=NULL)
				{				
					foreach($Get_Cust_Records as $Cust_Record)
					{
						$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];						
						$Enrollement_id = $Cust_Record["Enrollement_id"];
						// $Enrollement_id = 467;
						$Card_id = $Cust_Record["Card_id"];
						$joined_date = $Cust_Record["joined_date"];
						
						// echo "----Company_id----".$Company_id."----EnrollId----".$Enrollement_id."-----Card_id----".$Card_id."----<br><br>";
						// $Enrollement_id=467;
						$Get_customer_transaction = $this->Igain_model->get_customer_transaction($Enrollement_id,$Card_id,$Company_id);						
						if($Get_customer_transaction != NULL)
						{	
							foreach($Get_customer_transaction as $trans)
							{
								$Remaining_purchase_quantity_array[] = $trans->Quantity_balance;									
								$Enrollement_id_array[]=$trans->Enrollement_id;								
								
								// $Total_purchase_quantity_array[]=$trans->Quantity;
								
								$Total_purchase_quantity_array[]=$trans->Quantity-$trans->Quantity_balance;
								
								$Trans_id_array[]=$trans->Trans_id;
								$Enrollement_id_array[]=$trans->Enrollement_id;
								$Enrollement_id=$trans->Enrollement_id; 
							}	
							
							$Total_purchase_quantity=array_sum($Total_purchase_quantity_array);							
							// echo "----Total_purchase_quantity--".$Total_purchase_quantity."---<br><br>";
							
							$varTotal = $Total_purchase_quantity/20;
							$how_many_send_offers = floor($varTotal);  // Last two parameters are optional
							// echo "----how_many_send_offers--".$how_many_send_offers."---<br><br>";
							
							if($how_many_send_offers > 0 )
							{							
								$Get_items = $this->Catelogue_model->Get_Merchandize_other_benefit_Items($Company_id);
								if($Get_items !=NULL)
								{				
									// echo "----i--".$i."----Company_id---".$Company_id."-<br>";
									foreach($Get_items as $Item_details)
									{		 
										$Get_Partner_Branches = $this->Catelogue_model->Get_Partner_Branches($Item_details->Partner_id,$Company_id);
										foreach($Get_Partner_Branches as $Branch)
										{
											$Branch_code=$Branch->Branch_code;
											$Branch_name=$Branch->Branch_name;
											$Branch_Address=$Branch->Address;
										}	
										for($i=0; $i < $how_many_send_offers;  $i++)
										{
											$Super_Seller_details=$this->Igain_model->Fetch_Super_Seller_details($Company_id);
											$seller_id=$Super_Seller_details->Enrollement_id;
											$Seller_name=$Super_Seller_details->First_name.' '.$Super_Seller_details->Last_name;
											$top_db2 = $Super_Seller_details->Topup_Bill_no;
											
											$len2 = strlen($top_db2);
											$str2 = substr($top_db2,0,5);
											$tp_bill2 = substr($top_db2,5,$len2);						
											$topup_BillNo2 = $tp_bill2 + 1;
											$billno_withyear_ref = $str2.$topup_BillNo2;
											$Voucher_no = $this->ramdom_number();
											
											
											/******************insert*****************************************/
											 $insert_data = array
													 (
													'Company_id' => $Company_id,
													'Trans_type' => 10,
													'Redeem_points' => $Item_details->Billing_price_in_points,
													'Quantity' => 1,
													'Trans_date' => $Todays_date,
													'Enrollement_id' => $Enrollement_id,
													'Card_id' => $Card_id,
													'Item_code' => $Item_details->Company_merchandize_item_code,
													'Voucher_no' => $Voucher_no,
													'Voucher_status' => 30,
													'Bill_no' => $tp_bill2,
													'Seller' => $seller_id,
													'Seller_name' => $Seller_name,
													'Delivery_method' => 28,
													'Merchandize_Partner_id' => $Item_details->Partner_id,
													'Remarks' => 'Other Benefits Freebies On Quantity',
													'Merchandize_Partner_branch' => $Branch_code
													);
											 $Insert = $this->Redemption_Model->Insert_Redeem_Items_at_Transaction($insert_data);
											/***********************************************************/
											
											$myData = array('Trans_id'=>$Insert, 'Company_id'=>$Company_id,'Enroll_id'=>$Enrollement_id,'Card_id'=>$Card_id,'evoucher'=>$Voucher_no,'Merchandize_item_name'=>$Item_details->Merchandize_item_name,'Branch_name'=>$Branch_name,'Branch_Address'=>$Branch_Address);
											
											$Offer_data = base64_encode(json_encode($myData));	
											// $Offer_url = base_url()."/index.php/CatalogueC/Update_eVoucher_Status/?Offer_data=".$Offer_data;
											$Offer_url = base_url()."Company_".$Company_id."/index.php/Cust_home/Update_eVoucher_Status/?Offer_data=".$Offer_data;
											$Offerlink = "<a href='".$Offer_url."' target='_blank' style='color:#fff;text-decoration:none;color: #fff;cursor: pointer; display: inline-block;font-size: 13px; font-weight: 400;margin-bottom: 0;padding-bottom: 6px;padding-left: 8px; padding-right: 8px; padding-top: 6px; text-align: center;vertical-align: middle; white-space: nowrap; background-color: #3c8dbc;border-bottom-color: #367fa9; border-left-color: #367fa9; border-right-color: #367fa9;border-top-color: #367fa9;'>Update Offer Status </a>";
											
											$Email_content =  array(
																'Company_merchandize_item_code' => $Item_details->Company_merchandize_item_code,
																'Merchandize_item_name' => $Item_details->Merchandize_item_name,
																'Item_image' => $Item_details->Item_image1,
																'Voucher_no' => $Voucher_no,
																'Voucher_status' => 28,
																'Notification_type' => 'Freebies',
																'Template_type' => 'Freebies',
																'Offer_link' => $Offerlink,
																'Customer_name' => $Full_name,
																'Todays_date' => $Todays_date
														);
											
											$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id); 
											
											$result7 = $this->Igain_model->update_topup_billno($seller_id,$billno_withyear_ref);
										}
									}
								}								
							}							
						}
						// echo "<br><br>******************************************************<br><br>";
						// print_r($Trans_id_array);
						
						
						$Total_purchase_quantity=array_sum($Total_purchase_quantity_array);
						$varTotal = $Total_purchase_quantity/20;	
						$how_many_send_offers = floor($varTotal); 							
						$to_be_update=$how_many_send_offers*20;
						$Update_quantity = $to_be_update;
						
						
						/* echo "----Total_purchase_quantity--".$Total_purchase_quantity."---<br><br>";
						echo "----varTotal--".$varTotal."---<br><br>";
						echo "----how_many_send_offers--".$how_many_send_offers."---<br><br>";
						echo "----to_be_update--".$to_be_update."---<br><br>"; */
						
						// echo "<br><br>----Total_purchase_quantity--".$Total_purchase_quantity."---<br><br>";
						// echo "----Update_quantity--".$Update_quantity."---<br><br>";
						
					if($Update_quantity >= 20 )
					{			
						for($j=0; $j < count($Total_purchase_quantity_array); $j++)
						{
							
							$TransId=$Trans_id_array[$j];
							$EnrollId=$Enrollement_id_array[$j];
							$PurchaseQuantity=$Total_purchase_quantity_array[$j];
							
							// $EnrollId=637;
							
							// echo "--TransId--".$TransId."----EnrollId--".$EnrollId."----PurchaseQuantity--".$PurchaseQuantity."----<br><br>";
							
							$Last_record = $this->Igain_model->get_last_free_item_onquantity_record($Company_id,$EnrollId,$TransId);
							
							$Quantity_balance=$Last_record->Quantity_balance;										
							$Quantity=$Last_record->Quantity;
							$Trans_id=$Last_record->Trans_id;
							// echo "----Quantity--".$Quantity."---<br><br>";
							// echo "----Quantity_balance--".$Quantity_balance."---<br><br>";
							
							
							$Last_remaining_quantity = $Last_record->Quantity - $Last_record->Quantity_balance;							
							// echo"----Last_remaining_quantity--".$Last_remaining_quantity."---<br><br>";							
							
							// $Update_quantity=$Update_quantity+$Last_remaining_quantity;
							// $Update_quantity=$Update_quantity;
							
							// echo "----Update_quantity---starting--".$Update_quantity."---<br><br>";
							
								if($Last_remaining_quantity > 0)
								{
									// echo "----Last_remaining_quantity--is available--<br><br>";
										
									// echo "----Trans_id--".$Trans_id."---<br><br>";
									
									if($Update_quantity < $PurchaseQuantity )
									{
										// echo "---available---Condition 1111---<br><br>";
										$Free_item_onquantity_flag = 2;
										
										
										$need_to_update = $Update_quantity;
										// echo "---available---Update_quantity--1--".$Update_quantity."--need_to_update--".$need_to_update."---Free_item_onquantity_flag--".$Free_item_onquantity_flag."-<br><br>";						
										
										$result7 = $this->Igain_model->update_free_item_onquantity_flag($TransId,$need_to_update,$Company_id,$Free_item_onquantity_flag);
										
										
										$Update_quantity = $Update_quantity - $need_to_update;
										
										if($Update_quantity <= 0 )
										{
											$Update_quantity=0;
										}
										else
										{
											$Update_quantity = $PurchaseQuantity - $Update_quantity;
										}
																			
										// echo "---available---Update_quantity--111--".$Update_quantity."---<br><br>";
										
									}
									if($Update_quantity >= $PurchaseQuantity )
									{
										// echo "---available---Condition 2222---<br><br>";
										
										$Free_item_onquantity_flag = 1;
										$need_to_update = $PurchaseQuantity+$Quantity_balance;
										
										// echo "---available---need_to_update--2222--".$need_to_update."---Free_item_onquantity_flag--".$Free_item_onquantity_flag."--<br><br>";	
										
											
										// echo "----Update_quantity-----2----".$Update_quantity."---<br><br>";						
										
										$result7 = $this->Igain_model->update_free_item_onquantity_flag($TransId,$need_to_update,$Company_id,$Free_item_onquantity_flag);
										
										// echo "----PurchaseQuantity-----222-----".$PurchaseQuantity."---<br><br>";
										$Update_quantity = $Update_quantity - $PurchaseQuantity;
										if($Update_quantity < 0 )
										{
											$Update_quantity=0;
										}
										// echo "--available--Update_quantity--222--".$Update_quantity."---<br><br>";
										
									}
									
										
										
										
								}
								else
								{
									// echo "----$Update_quantity < $PurchaseQuantity---<br><br>";
									if($Update_quantity < $PurchaseQuantity )
									{
										// echo "----Condition 1111---<br><br>";
										$Free_item_onquantity_flag = 2;
										
										
										$need_to_update = $Update_quantity;
										// echo "----Update_quantity--1--".$Update_quantity."--need_to_update--".$need_to_update."---Free_item_onquantity_flag--".$Free_item_onquantity_flag."-<br><br>";						
										
										$result7 = $this->Igain_model->update_free_item_onquantity_flag($TransId,$need_to_update,$Company_id,$Free_item_onquantity_flag);
										
										$Update_quantity = $Update_quantity - $need_to_update;
										
										if($Update_quantity <= 0 )
										{
											$Update_quantity=0;
										}
										else
										{
											$Update_quantity = $PurchaseQuantity - $Update_quantity;
										}	
												
										// echo "----Update_quantity--111--".$Update_quantity."---<br><br>";
										
									}
									if($Update_quantity >= $PurchaseQuantity )
									{
										// echo "----Condition 2222---<br><br>";
										
										$Free_item_onquantity_flag = 1;
										$need_to_update = $PurchaseQuantity;
										
										// echo "--need_to_update--2222--".$need_to_update."---Free_item_onquantity_flag--".$Free_item_onquantity_flag."--<br><br>";	
										
											
										// echo "----Update_quantity-----2----".$Update_quantity."---<br><br>";						
										
										$result7 = $this->Igain_model->update_free_item_onquantity_flag($TransId,$need_to_update,$Company_id,$Free_item_onquantity_flag);
										
										// echo "----PurchaseQuantity-----222-----".$PurchaseQuantity."---<br><br>";
										$Update_quantity = $Update_quantity - $PurchaseQuantity;
										if($Update_quantity < 0 )
										{
											$Update_quantity=0;
										}
										// echo "----Update_quantity--222--".$Update_quantity."---<br><br>";
										
									}
									
									
								}
							
							
						}
					}	
						unset($Last_remaining_quantity);
						unset($Remaining_purchase_quantity_array);
						unset($Total_purchase_quantity_array);
						unset($Total_purchase_quantity);
						unset($how_many_send_offers);
						unset($Trans_id_array);
						unset($Enrollement_id_array);
					}
					
				}
					
				
				
			
		

	}	
	public function ramdom_number()
	{
		$characters = 'A123B56C89';
		$string = '';
		$Voucher_no="";
		for ($i = 0; $i < 16; $i++) 
		{
			$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
		}
		
		return $Voucher_no;
	}
}	
?>
