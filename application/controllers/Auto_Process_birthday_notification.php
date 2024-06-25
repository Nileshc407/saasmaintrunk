<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auto_Process_birthday_notification extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Report/Report_model');
		$this->load->model('Catalogue/Catelogue_model');
		$this->load->model('Coal_catalogue/Voucher_model');
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
		$Todays_date=date("m-d");
		
		foreach($Company_details as $Company_Records)
		{
			// echo "<br><br><br><b>Cron_birthday_flag --->".$Company_Records["Cron_birthday_flag"]."</b>";
			if($Company_Records["Cron_birthday_flag"]==1) 
			{
				// echo "<br><br><br><b>Company Name --->".$Company_Records["Company_name"]."</b>";
				$Communication = $this->Igain_model->Get_birthday_communication($Company_Records["Company_id"]);
				$Trans_Records = $this->Igain_model->get_all_customers($Company_Records["Company_id"]);
				$Birthday_Communication=0;
				$Link_to_voucher=0;
				$communication_plan=0;
				if($Communication !=NULL)
				{				
					foreach($Communication as $comm)
					{
						$Birthday_Communication= $comm->description;
						$communication_plan= $comm->communication_plan;
						$Link_to_voucher = $comm->Link_to_voucher;
						$Voucher_type = $comm->Voucher_type;
						$Voucher_id = $comm->Voucher_id;
					}
				}
				/* echo "<br>---Birthday_Communication --->".$Birthday_Communication."---</b>";
				echo "<br>---Link_to_voucher --->".$Link_to_voucher."---</b>";
				echo "<br>---Voucher_type --->".$Voucher_type."---</b>";
				echo "<br>---Voucher_id --->".$Voucher_id."---</b>"; */
				
										
				
				
				
				if($Trans_Records !=NULL)
				{				
					foreach($Trans_Records as $Cust_Record)
					{
						$Birth_date = date("m-d",strtotime($Cust_Record["Date_of_birth"]));
						$Date_of_birth = date("Y-m-d",strtotime($Cust_Record["Date_of_birth"]));
						
						// echo "<br><br>Membership ID-->".$Cust_Record["Card_id"]."<-->Date_of_birth -->".$Date_of_birth."<-->Birth_date -->".$Birth_date;
							
						if(($Date_of_birth!=NULL) && ($Date_of_birth!="") && ($Date_of_birth!="1970-01-01") && ($Date_of_birth!="0000-00-00") && ($Date_of_birth!="0000-00-00") && ($Birth_date==$Todays_date))
						{
							
							// echo "<br><br>Membership ID-->".$Cust_Record["Card_id"]."<-->Date_of_birth -->".$Date_of_birth."<-->Birth_date -->".$Birth_date;
							
							$Full_name = $Cust_Record["First_name"]." ".$Cust_Record["Last_name"];						
							$Company_id = $Company_Records["Company_id"];
							$Enrollement_id = $Cust_Record["Enrollement_id"];
							
							
							
							/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
											// $Link_to_voucher = $offer_details->Link_to_voucher;										
											$Voucher_array=array();
											$Vouchertype="";
											if($Link_to_voucher ==1){											
												// $Voucher_type = $offer_details->Voucher_type;
												// $Voucher_id = $offer_details->Voucher_id;
												
												$Todays_date=date("Y-m-d H:i:s");
												$getVoucherDetails=$this->Voucher_model->get_voucher_details_child($Company_Records["Company_id"],$Voucher_id,$Voucher_type,$Todays_date);
												
												// print_r($getVoucherDetails);
												
												if($getVoucherDetails){	
													$Voucher_Valid_from = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_from']));
													$Voucher_Valid_till = date("d M, Y",strtotime($getVoucherDetails[0]['Valid_till']));
													$Discount_percentage =$getVoucherDetails[0]['Discount_percentage'];
													$Discount_value =$getVoucherDetails[0]['Cost_price'];
													foreach($getVoucherDetails as $vouchers){
														
														$Voucherid = $vouchers['Voucher_id'];
														$Voucherchildid = $vouchers['Voucher_child_id'];
														$Voucher_type = $vouchers['Voucher_type'];
														
														$Company_merchandiseitemid = $vouchers['Company_merchandise_item_id'];
														$Company_merchandizeitemcode = $vouchers['Company_merchandize_item_code'];
														$Costprice = $vouchers['Cost_price'];
														$Costin_points = $vouchers['Cost_in_points'];
														
														$characters = '1234567890';
														$string = '';
														$Voucher_no="";
														for ($i = 0; $i < 10; $i++) 
														{
															$Voucher_no .= $characters[mt_rand(0, strlen($characters) - 1)];
														}
														$Voucher_array[]=$Voucher_no;													
														$Post_vouchers_data=array(
															'Company_id'=>$Company_Records["Company_id"],
															'Enrollement_id'=>$Cust_Record["Enrollement_id"],
															'Voucher_id'=>$vouchers['Voucher_id'],
															'Voucher_child_id'=>$vouchers['Voucher_child_id'],
															'Voucher_type'=>$vouchers['Voucher_type'],
															'Voucher_issuance_type'=>$vouchers['Voucher_issuance_type'],
															'Voucher_code'=>$Voucher_no,
															'Company_merchandise_item_id'=>$vouchers['Company_merchandise_item_id'],
															'Company_merchandize_item_code'=>$vouchers['Company_merchandize_item_code'],
															'Valid_from'=>$vouchers['Valid_from'],
															'Valid_till'=>$vouchers['Valid_till'],
															'Cost_price'=>$vouchers['Cost_price'],
															'Cost_in_points'=>$vouchers['Cost_in_points'],
															'Discount_percentage'=>$vouchers['Discount_percentage'],
															'Active_flag'=>$vouchers['Active_flag'],
															'Create_User_id'=>$vouchers['Create_User_id'],
															'Creation_date'=>$vouchers['Creation_date'],
															'Update_User_id'=>$vouchers['Update_User_id'],
															'Update_date'=>$vouchers['Update_date']
														);
														$insert_vouchers=$this->Voucher_model->insert_send_vouchers($Post_vouchers_data);
														
														$insert_vouchers_gift=$this->Voucher_model->insert_send_giftcard_vouchers($Post_vouchers_data);
														
													}
													if($Voucher_type==1){									
														$Vouchertype='Revenue Voucher';
													}
													if($Voucher_type==2){
														$Vouchertype='Product Voucher';
													} 
													if($Voucher_type==3){												
														$Vouchertype='Discount Voucher';
													}
												}
											}
											if(!empty($Voucher_array)) {
												$Voucher_array=$Voucher_array;
											} else{										
												$Voucher_array="";
											}
											$Code_list = implode(', ', $Voucher_array); 
											$Voucher_codes=$Code_list;
											if(!empty($Voucher_codes)) {
												$Voucher_codes=$Voucher_codes;
											} else{										
												$Voucher_codes="No Code Available";
											}												
											$Customer_name = $Cust_Record["First_name"].' '.$Cust_Record["Last_name"];						
											$Membership_id = $Cust_Record["Card_id"];						
											$Current_balance =$Cust_Record["Current_balance"] - ($Cust_Record["Blocked_points"]+$Cust_Record["Debit_points"]);						
											
											/* $search_variables = array('$Customer_name','$Membership_id','$Current_balance','$Product_voucher', '$Revenue_voucher','$Voucher_type','$Start_date','$End_date'); //
											$inserts_contents = array($Customer_name,$Membership_id,$Current_balance,$Voucher_codes, $Voucher_codes,$Vouchertype,$Voucher_Valid_from,$Voucher_Valid_till); */
											
											
											
											
											//24-06-2020
											$search_variables = array(
												'$Customer_name',
												'$Membership_id',
												'$Current_balance',
												'$Product_voucher',
												'$Revenue_voucher',
												'$Discount_voucher',
												'$Discount_percentage',
												'$Discount_value',
												'$Voucher_type',
												'$Start_date',
												'$End_date'
												); 
												
												// echo "<br>---Customer_name --->".$Customer_name."---</b>";
												// echo "<br>---Membership_id --->".$Membership_id."---</b>";
												
											$inserts_contents = array(
												$Customer_name,
												$Membership_id,
												$Current_balance,
												$Voucher_codes,
												$Voucher_codes,
												$Voucher_codes,
												$Discount_percentage,
												$Discount_value,
												$Vouchertype,
												$Voucher_Valid_from,
												$Voucher_Valid_till
											);											
											$Birthday_Communication = str_replace($search_variables, $inserts_contents, $Birthday_Communication);
											
						/*----------------------Product & Revenue Voucher-02-03-2020-------------------*/
				
						// echo "<br>---offer_details_description --->".$offer_details_description."---</b>";
							
							
							
							
							
							 
							$Email_content = array(
								'Notification_type' => 'Wish you a very Happy Birthday !!!',
								'Birthday_Communication' => $Birthday_Communication,
								// 'subject' => $communication_plan,
								'Template_type' => 'Birthday_Reminder'
							);
								
							$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id);
							
						
						}
					}
				}
			}
	}
}	
}
?>
<style>

</style>
	
