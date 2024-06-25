<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auto_Process_Trigger_Notification extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();		
		$this->load->library('form_validation');		
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Igain_model');
		$this->load->library('Send_notification');
		$this->load->model('Auto_Process/Auto_process_model');
		$this->load->model('TierM/Tier_model');
		$this->load->model('TriggerM/Trigger_model');
		$this->load->model('transactions/Transactions_model');
		$this->load->model('administration/Administration_model');
		//$this->load->model('master/Game_model');
	}
	public function index()
	{
		$Company_details = $this->Igain_model->FetchCompany();
			
		$Todays_date=date("Y-m-d");
		
		$Logged_user_enroll = 0;
		$Logged_user_id = 3;
		//echo "Logged_user_id---".$Logged_user_id;
		foreach($Company_details as $Company_Records)
		{
			$Company_id = $Company_Records["Company_id"];
			$Cust_apk_link = $Company_Records["Cust_apk_link"];
			$Cust_ios_link = $Company_Records["Cust_ios_link"];
			$Company_name = $Company_Records["Company_name"];
			$Company_website = base_url()."Company_".$Company_id."/index.php";
			$trigger_results = $this->Trigger_model->Triggers_list('', '',$Company_id);
			
			if($trigger_results != NULL)
			{
				foreach($trigger_results as $trig)
				{
					$Trigger_notification_id = $trig->Trigger_notification_id;
					$Trigger_notification_name = $trig->Trigger_notification_name; 
					echo "<br><br>---<b>************************Trigger name--".$Trigger_notification_name."---*Trigger_notification_id--".$Trigger_notification_id."---*********************</b><br>";
					$Trigger_notification_type = $trig->Trigger_notification_type;
					$Tier_id = $trig->Tier_id;
					$Auction_id = $trig->Auction_id;
					$Company_game_id = $trig->Company_game_id;
					$Loyalty_rule = $trig->Loyalty_rule;
					$Threshold_value = $trig->Threshold_value;
					
					if($Trigger_notification_type == 1) //***** customer tier defined ****
					{
						/*$tier_info = $this->Tier_model->edit_tier($Company_id,$Tier_id);
						foreach($tier_info as $Tiers_Record1)
						{
							$Todays_date=date("Y-m-d");
							$Tier_name = $Tiers_Record1->Tier_name;  
							
							$Tier_id = $Tiers_Record1->Tier_id; 
							$New_Tier_level_id = $Tiers_Record1->Tier_level_id; 
							$Excecution_time = $Tiers_Record1->Excecution_time; 
							$Tier_criteria = $Tiers_Record1->Tier_criteria; 
							$Criteria_value2 = $Tiers_Record1->Criteria_value; 
							// $Operator_id = 6; 
							echo "<br>--Tier_name --".$Tier_name."--Tier_criteria --".$Tier_criteria."--Criteria_value --".$Criteria_value2."---<br>";
							
							
						}*/
							$next_tier_info = $this->Trigger_model->get_next_tier_details($Tier_id,$Company_id);
						
						foreach($next_tier_info as $Tiers_Record)
						{
							$Todays_date=date("Y-m-d");
							$next_Tier_name = $Tiers_Record->Tier_name; 
							$next_Tier_id = $Tiers_Record->Tier_id; 
							$next_New_Tier_level_id = $Tiers_Record->Tier_level_id; 
							$next_Excecution_time = $Tiers_Record->Excecution_time; 
							$next_Tier_criteria = $Tiers_Record->Tier_criteria; 
							$next_Criteria_value2 = $Tiers_Record->Criteria_value; 
							$Operator_id = $Tiers_Record->Operator_id; 
							echo "<br><br>--next_Tier_name --".$next_Tier_name."--next_Tier_criteria --".$next_Tier_criteria."---<br>";
							if($next_Excecution_time=="Monthly")
							{
								$From_date = strtotime($Todays_date .' -1 months');
								$From_date=date("Y-m-d",$From_date);
							}
							if($next_Excecution_time=="Quaterly")
							{
								$From_date = strtotime($Todays_date .' -3 months');
								$From_date=date("Y-m-d",$From_date);
							}
							if($next_Excecution_time=="Bi-Annualy")
							{
								$From_date = strtotime($Todays_date .' -6 months');
								$From_date=date("Y-m-d",$From_date);
							}
							if($next_Excecution_time=="Yearly")
							{
								$From_date = strtotime($Todays_date .' -12 months');
								$From_date=date("Y-m-d",$From_date);
							}
							 echo "--From_date --".$From_date."---<br>";
							  
							if($next_Tier_criteria==1)//Cumulative Spend
							{
								$Trans_Records2 = $this->Auto_process_model->Get_Cumulative_spend_transactions($Company_id,$From_date,$Todays_date,$Tier_id);
							}
							if($next_Tier_criteria==2)//Cumulative Number of Transactions
							{
								$Trans_Records2 = $this->Auto_process_model->Get_Cumulative_Total_transactions($Company_id,$From_date,$Todays_date,$Tier_id);
							}
							if($next_Tier_criteria==3)//Cumulative Points Accumlated
							{
								$Trans_Records2 = $this->Auto_process_model->Get_Cumulative_Points_Accumlated($Company_id,$From_date,$Todays_date,$Tier_id);
							}
							// $next_Operator_id = 6; 
							
						}
						
						foreach($Trans_Records2 as $Trans_Records4)
						{
							echo "<br><b>************************************************************</b>";
							echo "<br>--cust name---->". $Trans_Records4->First_name." ".$Trans_Records4->Last_name."---Enrollement_id---->". $Trans_Records4->Enrollement_id;
							
							if($next_Tier_criteria == 1)//Cumulative Spend
							{
								$Cust_done_transaction = $Trans_Records4->Total_Spend;
								echo "<br><b>Total_Spend -->".$Cust_done_transaction."</b>";
							}
							if($next_Tier_criteria == 2)//Cumulative Number of Transactions
							{
								$Cust_done_transaction = $Trans_Records4->Total_Transactions;
								echo "<br><b>Total_Transactions -->".$Cust_done_transaction."</b>";
							}
							if($next_Tier_criteria == 3)//Cumulative Points Accumlated
							{
								$Cust_done_transaction = $Trans_Records4->Total_Points;
								echo "<br><b>Total_Points -->".$Cust_done_transaction."</b>";
							}
					
							$Enrollement_id = $Trans_Records4->Enrollement_id;
							$Old_Tier_level_id = $Trans_Records4->Tier_level_id;
							$Old_Tier_name = $Trans_Records4->Tier_name;
							$Full_name = $Trans_Records4->First_name." ".$Trans_Records4->Last_name;
													
							
							$send_mail_flag = $this->Auto_process_model->validate_notification($Enrollement_id,$Trigger_notification_id,$Company_id);
							
									
							echo "<br> if(send_mail_flag $send_mail_flag == 1 && Cust_done_transaction $Cust_done_transaction >=Threshold_value $Threshold_value && Cust_done_transaction $Cust_done_transaction < next_Criteria_value $next_Criteria_value2)";
							if($send_mail_flag == 1 && $Cust_done_transaction >=$Threshold_value && $Cust_done_transaction < $next_Criteria_value2)
							{
								
								
								$new_criteria_val = $next_Criteria_value2 - $Cust_done_transaction;
								
								
								$Email_content = array(
									'Notification_type' => 'Trigger Notification',
									'Template_type' => 'Trigger Notification',
									'Tier_criteria' => $next_Tier_criteria,
									'Trigger_notification_type' => $Trigger_notification_type,
									'next_Tier_name' => $next_Tier_name,
									'Cust_done_transaction' => $Cust_done_transaction,
									'next_Criteria_value2' => $next_Criteria_value2,
									'Old_Tier_name' => $Old_Tier_name,
									'new_criteria_val' => $new_criteria_val,
									'trigger_id' => $Trigger_notification_id
								);
									
								$Notification=$this->send_notification->send_Notification_email($Enrollement_id,$Email_content,'1',$Company_id); 
								
							}	
							
						}
						
					}
					
					if($Trigger_notification_type == 2)  //********* loyalty rule defined ******
					{
						//echo "lp trigger---<br>";
						
						$lp_type = substr($Loyalty_rule,0,2);		
						
						$lp_array = $this->Transactions_model->get_loyaltyrule_details($Loyalty_rule,$Company_id,$Logged_user_enroll,$Logged_user_id);
						
						//var_dump($lp_array);
						
						//echo "-- lp_name count---".count($lp_array)."---<br><br>";
						//die;
						$Loyalty_at_value = 0;
						
						$lp = count($lp_array);

							foreach($lp_array as $rows)
							{
								$lp_name = $rows['Loyalty_name'];
								
								echo "-- lp_name---".$lp_name."---<br><br>";
								
								$Loyalty_id = $rows['Loyalty_id'];
								$From_date = date("Y-m-d",strtotime($rows['From_date']));
								$Till_date = date("Y-m-d",strtotime($rows['Till_date']));
								$Till_date11 = date("d M Y",strtotime($rows['Till_date']));
								$PABA_val = substr($rows['Loyalty_name'],0,2);
								
								$Loyalty_at_transaction = $rows['Loyalty_at_transaction'];
								$Loyalty_at_value = $rows['Loyalty_at_value'];
								$discount = $rows['discount'];
								$SellerID = $rows['Seller'];
								$Company_id = $rows['Company_id'];
								$todays=date("Y-m-d");
								
							}	
							
								$customers = $this->Auto_process_model->who_did_transactions($Company_id);
								
								foreach($customers as $custinfo)
								{
									
									$send_mail_flag = $this->Auto_process_model->validate_notification($custinfo->Enrollement_id,$Trigger_notification_id,$Company_id);
									echo "-- send_mail_flag---".$send_mail_flag."---<br>";
									if($send_mail_flag == 1)
									{
							
										$Email_content = array(
											'Trigger_notification_type' => $Trigger_notification_type,
											'Loyalty_rule' => $Loyalty_rule,
											'Loyalty_at_transaction' => $Loyalty_at_transaction,
											'Till_date' => $Till_date11,
											'Notification_type' => 'Trigger Notification',
											'Template_type' => 'Trigger Notification',
											'trigger_id' => $Trigger_notification_id
										);
								
										$Notification=$this->send_notification->send_Notification_email($custinfo->Enrollement_id,$Email_content,'1',$Company_id); 
									}
									
								}
							
							
					}
					unset($lp_array);	
					
					$Todays_date = date("m-d-Y");
					
					if($Trigger_notification_type == 3)  //********* Auction defined ******
					{
						
						$auction_info = $this->Administration_model->edit_auction($Auction_id);
						
						print_r($auction_info);
						
						$Auction_name = $auction_info->Auction_name;
						$Auction_Prize = $auction_info->Prize;
						$Trigger_notification_start_days = $auction_info->Trigger_notification_start_days;
						$Trigger_notification_end_days = $auction_info->Trigger_notification_end_days;
						$auction_from_date = date("m-d-Y", strtotime($auction_info->From_date));
						$auction_end_date = date("m-d-Y", strtotime($auction_info->To_date));
						
						echo "<br><br>if($Todays_date >= $auction_from_date || $Todays_date <= $auction_end_date)";
						if($Todays_date >= $auction_from_date || $Todays_date <= $auction_end_date)
						{
							$tUnixTime = time();
							list($month, $day, $year) = EXPLODE('-', $auction_end_date);
							$timeStamp = mktime(0, 0, 0, $month, $day, $year);
							$Difference = ceil(abs($timeStamp - $tUnixTime) / 86400);
							
							// echo "<br>--Difference days---".$Difference."--<br>";
							
							echo "<br><br>if(Difference$Difference == Trigger_notification_start_days$Trigger_notification_start_days || Difference$Difference == Trigger_notification_end_days$Trigger_notification_end_days)";
							if($Difference == $Trigger_notification_start_days || $Difference == $Trigger_notification_end_days)
							{
								$auction_customers = $this->Auto_process_model->get_auction_participents($Company_id,$Auction_id);
								
								foreach($auction_customers as $cust)
								{
									$Full_name = $cust->First_name." ".$cust->Last_name;
									$Bid_value[] = $cust->Bid_value;
									$Highest_Bid_value = max($Bid_value);
									$Bid_date = date("Y-m-d",strtotime($cust->Creation_date));
								
									$send_mail_flag = $this->Auto_process_model->validate_notification($cust->Enrollment_id,$Trigger_notification_id,$Company_id);
									echo "<br>$Full_name-- send_mail_flag---".$send_mail_flag."---<br>";
									if($send_mail_flag == 1)
									{
										$auction_end_date = date("Y-m-d", strtotime($auction_info->To_date));
										$Email_content = array(
											'Trigger_notification_type' => $Trigger_notification_type,
											'Auction_name' => $Auction_name,
											'Difference' => $Difference,
											'Auction_Prize' => $Auction_Prize,
											'auction_end_date' => $auction_end_date,
											'Highest_Bid_value' => $Highest_Bid_value,
											'Bid_date' => $Bid_date,
											'Notification_type' => 'Trigger Notification',
											'Template_type' => 'Trigger Notification',
											'trigger_id' => $Trigger_notification_id
										);
								
										$Notification=$this->send_notification->send_Notification_email($cust->Enrollment_id,$Email_content,'1',$Company_id); 
										
									}
								}
							}
						}
					}
					
					if($Trigger_notification_type == 4)  //********* Game defined ******
					{
						$game_info = $this->Auto_process_model->edit_company_game($Company_game_id);
						
						foreach($game_info as $game)
						{
							$game_name = $game->Game_name; echo "--game name--".$game_name."--<br>";
							$game_from_date = date("m-d-Y", strtotime($game->Competition_start_date));
							$game_end_date = date("m-d-Y", strtotime($game->Competition_end_date));
						
						}
						
						if($Todays_date >= $game_from_date || $Todays_date <= $game_end_date)
						{
							$tUnixTime = time();
							list($month, $day, $year) = EXPLODE('-', $game_end_date);
							$timeStamp = mktime(0, 0, 0, $month, $day, $year);
							$Difference = ceil(abs($timeStamp - $tUnixTime) / 86400);
							
							echo "--Difference days---".$Difference."--<br>";
							
							if($Difference == 1 || $Difference == 7)
							{
								$game_customers = $this->Auto_process_model->get_game_participents($Company_game_id,$Company_id);
								
								foreach($game_customers  as $members)
								{
									$Enrollment_id = $members->Enrollment_id; 
									$Full_name = $members->First_name." ".$members->Last_name;
									
									$send_mail_flag = $this->Auto_process_model->validate_notification($Enrollment_id,$Trigger_notification_id,$Company_id);
									
									if($send_mail_flag == 1)
									{
										$subject = "Exclusive Games related News for You" ; 
									/*
									  
									$html  = '<!DOCTYPE HTML PUBLIC ""-//W3C//DTD XHTML 1.0 Transitional//EN"">' ;
									$html .= "<html>" ;
									$html .= "<head>" ;
									$html .= "<meta http-equiv=\"Content-Type\"" ;
									$html .= "content=\"text/html; charset=iso-8859-1\">" ;
									$html .= "</head>"; 
									$html .= '<body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100%!important;">';
									$html .='<div class="table-responsive"  style="font-family:calibri;">';				
									$html .= '<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0"   class="table table-bordered table-hover"  style="font-family:calibri;"><tr><td>';
								
									$html .= "<tr>";
									$html .= "<td  class='innerpadding borderbottom' colspan=\'2\' width=\'80%\'> Dear " .$Full_name. ",<br><br></td>"; 
									$html .= "</tr>";
								

									$html .= "<tr>";
									$html .= "<td  class='innerpadding borderbottom'  colspan=\'2\' width=\'80%\'> Thank you fot participete in the '$game_name' game competition, <br>
												its last $Difference days remainig of the competition, <br>
												so try to complete all levels and become a competition winner . </td>";
									$html .= "</tr>";

									$html .= "<tr>";
									$html .= "<td  class='innerpadding borderbottom'  colspan=\'2\' width=\'80%\'> <br></td>";
									$html .= "</tr>";
									
									$html .= "<tr>";
									$html .= "<td  class='innerpadding borderbottom'  colspan=\'2\' width=\'80%\'>Thank you. </td>";
									$html .= "</tr>";
									
									$html .= "</table>";
									$html .= "</div>";	
									$html .= "</body>";
									$html .= "</html>";
									*/
									
									
									$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
										$html .= '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><meta http-equiv="X-UA-Compatible" content="IE=edge"><link href="'.base_url().'assets/css/email_template.css" rel="stylesheet" /></head>';
							
							$html .= '<body style="width: 100% !important;min-width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100% !important;margin: 0;padding: 0;background-color: #FFFFFF">
							<table class="body" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;height: 100%;width: 100%;table-layout: fixed" cellpadding="0" cellspacing="0" width="100%" border="0">
								<tbody>
									<tr style="vertical-align: top">
										<td class="center" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;background-color: #FFFFFF" align="center" valign="top">

											<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
											<tbody>
											<tr style="vertical-align: top">
												<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
													<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #000000;background-color: transparent" cellpadding="0" cellspacing="0" width="100%" bgcolor="transparent"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent">						
													<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center">
													<div style="font-size:12px" align="center">
														<a href="#" target="_blank">
															<img class="center fullwidth" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;margin: 0 auto;float: none;width: 100% !important;max-width: 500px" align="center" border="0" src="'.base_url().'images/expiry.jpg" alt="Image" title="Image" width="500">
														</a>
													</div></td></tr></tbody></table>
													</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
												</td>
											</tr>
											</tbody></table>
											
											<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
											<tbody><tr style="vertical-align: top">
												<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
													<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #61626F" cellpadding="0" cellspacing="0" width="100%" bgcolor="#61626F"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 30px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
													<tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px">
														<div style="color:#ffffff;line-height:120%;font-family:Helvetica;">            
															<div style="font-size:12px;line-height:14px;color:#ffffff;font-family:Helvetica;text-align:left;"><p style="margin: 0;font-size: 18px;line-height: 22px;text-align: left"><span style="font-size: 18px; line-height: 28px;"><strong>
																Dear  '.$Full_name.',
															</strong></span></p></div>
														</div>
													</td></tr></tbody></table>
													<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
													  <tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 0px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px">
															<div style="color:#B8B8C0;line-height:150%;font-family:Helvetica;">            
																<div style="font-size:14px;line-height:18px;color:#B8B8C0;font-family:Helvetica;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 21px;text-align: left"><span style="font-size: 14px; line-height: 21px;">
																	
																	
																	
																	Thank you for  participating in the '.$game_name.' game competition,
																<br><br>
																	There are only  '.$Difference.' days remainig of the competition, So try to complete all levels and become a WINNER!

																<br><br>
																	Regards,<br>
																	Loyalty Team

											
																</span></p></div>
															</div>
														</td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
												</td></tr></tbody></table>
												
												<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
												<tbody><tr style="vertical-align: top">
													<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">';
												
												$html .='<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #F0F0F0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F0F0F0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 0px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent">';
												
												$html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
													<tbody><tr style="vertical-align: top">
														<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 15px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px">
															<div style="color:#959595;line-height:150%;font-family:Helvetica;">            
																<div style="font-size:12px;line-height:18px;color:#959595;font-family:Helvetica;text-align:left;">
																	<div class="txtTinyMce-wrapper" style="font-size:12px; line-height:18px;">
																		<p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">You can also visit the below link using your login credentials and check details.</strong> Visit <span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
																			<a style="color:#C7702E" title="Customer Website" href="'.$Company_website.'" target="_blank">Customer Website</a></span>
																		</p>
																		
																		<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
																		<tbody><tr style="vertical-align: top">
																			<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px" align="center">
																				<div style="height: 1px;">
																					<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;border-top: 1px solid #DADADA;width: 100%" align="center" border="0" cellspacing="0">
																						<tbody><tr style="vertical-align: top">
																							<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="center"></td>
																						</tr>
																					</tbody></table>
																				</div>
																			</td>
																		</tr></tbody>
																		</table>';
															
															if( $Cust_apk_link != "" || $Cust_ios_link != "")
															{
																$html .='<p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><strong><span style="font-size: 18px; line-height: 28px;">You can also download Android & iOS App</span></strong></p>
																
																<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="center" valign="top">
																  <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;max-width: 156px" align="center" valign="top">
																		<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
																		<tbody><tr style="vertical-align: top">
																			<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="left" valign="middle">';
																			
																			if($Cust_apk_link != "")
																			{
																				$html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;padding: 0 5px 5px 0" align="left" border="0" cellspacing="0" cellpadding="0" height="37">
																				<tbody><tr style="vertical-align: top">
																					<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="37" align="left" valign="middle">
																						<a href="'.$Cust_apk_link.'" title="Google Play" target="_blank">
																							<img style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;max-width: 32px !important" src="'.base_url().'images/Gooogle_Play.png" alt="Google Play" title="Google Play" width="32">
																						</a>
																					</td>
																				  </tr>
																				</tbody></table>';
																			}
																			
																			if($Cust_ios_link != "")
																			{
																				$html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;padding: 0 5px 5px 0" align="left" border="0" cellspacing="0" cellpadding="0" height="37">
																				<tbody><tr style="vertical-align: top">
																					<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="37" align="left" valign="middle">
																						<a href="'.$Cust_ios_link.'" title="App Store" target="_blank">
																							<img style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;max-width: 32px !important" src="'.base_url().'images/iOs_app_store.png" alt="App Store" title="App Store" width="32">
																						</a>
																					</td>
																				  </tr>
																				</tbody></table>';
																			}
																			
																		$html .='</td>
																		  </tr></tbody>
																		</table></td></tr></tbody>
																	</table></td></tr></tbody>
																</table>';
															}
															
															$html .='</div>
																</div>
															</div>
														</td>
													  </tr></tbody>
													</table>
													
													</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody>
												</table>
												
												<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: #ffffff" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
												<tbody><tr style="vertical-align: top">
													<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
														<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #2C2D37" cellpadding="0" cellspacing="0" width="100%" bgcolor="#2C2D37"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 15px;padding-right: 0px;padding-bottom: 15px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
														<tbody><tr style="vertical-align: top">
														<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 0px;padding-right: 15px;padding-bottom: 0px;padding-left: 15px">
															<div style="color:#959595;line-height:150%;font-family:Helvetica;">            
																<div style="font-size:12px;line-height:18px;color:#959595;font-family:Helvetica;text-align:left;"><div class="txtTinyMce-wrapper" style="font-size:12px; line-height:18px;"><p style="margin: 0;font-size: 14px;line-height: 21px;text-align: left"><span style="font-size: 12px; line-height: 18px;"><em>
																	<strong>DISCLAIMER:</strong> This e-mail message is proprietary to '.$Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
																	If you are not the intended recipient or responsible for delivery to the intended recipient,
																	you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_name.' will not accept any claims for damages arising out of viruses.<br>
																	Thank you for your cooperation.
																</em></span></p></div></div>
															</div>
														</td>
													  </tr></tbody></table>
												</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></table></td></tr></tbody>
											</table>
										</td>
									</tr>
								</tbody>
								</table>
							</body>
							</html>';
							
									echo "<br>".$html."<br>";	
								
									
										$Email_content = array(
										'Contents' => $html,
										'subject' => $subject,
										'Notification_type' => 'Trigger Notification',
										'Template_type' => 'Trigger Notification',
										'trigger_id' => $Trigger_notification_id
										);
								
									$Notification = $this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'1',$Company_id);
									}
								}
							}
						}
						
					}
					/*
					if($Trigger_notification_type == 5)  //******* Hobbies defined (send communication offer)******
					{
						$customer_hobbies = $this->Auto_process_model->get_hobbies_members($Merchant_type,$Company_id);
						
						//print_r($customer_hobbies);
						//echo "--customer_hobbies---<br><br>";
						$hobbie_merchants = $this->Auto_process_model->get_hobbies_merchants($Merchant_type,$Company_id);
						
						//print_r($hobbie_merchants);
						//echo "---hobbie_merchants---<br><br>";
						
						foreach($hobbie_merchants as $merchant)
						{
							$seller_details = $this->Igain_model->get_enrollment_details($merchant->Seller);
							$Merchant_name = $seller_details->First_name.' '.$seller_details->Last_name;
							//$merchants_offer = $this->Auto_process_model->get_merchant_communication_offers($merchant->Seller);
							
							//print_r($merchants_offer);
							//echo "----merchants_offer---<br><br>";
						
								foreach($customer_hobbies as $members)
								{
									$Enrollment_id = $members->Enrollement_id; 
									$Full_name = $members->First_name." ".$members->Last_name;
							
							
							
									$send_mail_flag = $this->Auto_process_model->validate_notification($Enrollment_id,$Trigger_notification_id,$Company_id);
										
										if($send_mail_flag == 1)
										{
											$subject = "Exclusive News for You " ; 
										
												$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
										$html .= '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><meta http-equiv="X-UA-Compatible" content="IE=edge"><link href="'.base_url().'assets/css/email_template.css" rel="stylesheet" /></head>';
							
							$html .= '<body style="width: 100% !important;min-width: 100%;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100% !important;margin: 0;padding: 0;background-color: #FFFFFF">
							<table class="body" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;height: 100%;width: 100%;table-layout: fixed" cellpadding="0" cellspacing="0" width="100%" border="0">
								<tbody>
									<tr style="vertical-align: top">
										<td class="center" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;background-color: #FFFFFF" align="center" valign="top">

											<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
											<tbody>
											<tr style="vertical-align: top">
												<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
													<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #000000;background-color: transparent" cellpadding="0" cellspacing="0" width="100%" bgcolor="transparent"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent">						
													<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px" align="center">
													<div style="font-size:12px" align="center">
														<a href="#" target="_blank">
															<img class="center fullwidth" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;margin: 0 auto;float: none;width: 100% !important;max-width: 500px" align="center" border="0" src="'.base_url().'images/expiry.jpg" alt="Image" title="Image" width="500">
														</a>
													</div></td></tr></tbody></table>
													</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
												</td>
											</tr>
											</tbody></table>
											
											<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
											<tbody><tr style="vertical-align: top">
												<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
													<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #61626F" cellpadding="0" cellspacing="0" width="100%" bgcolor="#61626F"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 30px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
													<tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 20px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px">
														<div style="color:#ffffff;line-height:120%;font-family:Helvetica;">            
															<div style="font-size:12px;line-height:14px;color:#ffffff;font-family:Helvetica;text-align:left;"><p style="margin: 0;font-size: 18px;line-height: 22px;text-align: left"><span style="font-size: 18px; line-height: 28px;"><strong>
																Dear  '.$Full_name.',
															</strong></span></p></div>
														</div>
													</td></tr></tbody></table>
													<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
													  <tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 0px;padding-right: 20px;padding-bottom: 20px;padding-left: 20px">
															<div style="color:#B8B8C0;line-height:150%;font-family:Helvetica;">            
																<div style="font-size:14px;line-height:18px;color:#B8B8C0;font-family:Helvetica;text-align:left;"><p style="margin: 0;font-size: 14px;line-height: 21px;text-align: left"><span style="font-size: 14px; line-height: 21px;">
																	
																	
																	We know you  like '.$Merchant_type.' and hence we would like to let you know that '.$Merchant_name.' has come with existing offer which you will not resist.
																<br><br>			
																	So, do rush to the outlet and grab the Item which is close to your heart!
																<br><br>
																	Regards,<br>
																	Loyalty Team

											
																</span></p></div>
															</div>
														</td></tr></tbody></table></td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table>
												</td></tr></tbody></table>
												
												<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: transparent" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
												<tbody><tr style="vertical-align: top">
													<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">';
												
												$html .='<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #F0F0F0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F0F0F0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 0px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent">';
												
												$html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
													<tbody><tr style="vertical-align: top">
														<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 15px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px">
															<div style="color:#959595;line-height:150%;font-family:Helvetica;">            
																<div style="font-size:12px;line-height:18px;color:#959595;font-family:Helvetica;text-align:left;">
																	<div class="txtTinyMce-wrapper" style="font-size:12px; line-height:18px;">
																		<p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">You can also visit the below link using your login credentials and check details.</strong> Visit <span style="text-decoration: underline; font-size: 14px; line-height: 21px;">
																			<a style="color:#C7702E" title="Customer Website" href="'.$Company_website.'" target="_blank">Customer Website</a></span>
																		</p>
																		
																		<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
																		<tbody><tr style="vertical-align: top">
																			<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px" align="center">
																				<div style="height: 1px;">
																					<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;border-top: 1px solid #DADADA;width: 100%" align="center" border="0" cellspacing="0">
																						<tbody><tr style="vertical-align: top">
																							<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="center"></td>
																						</tr>
																					</tbody></table>
																				</div>
																			</td>
																		</tr></tbody>
																		</table>';
															
															if( $Cust_apk_link != "" || $Cust_ios_link != "")
															{
																$html .='<p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center"><strong><span style="font-size: 18px; line-height: 28px;">You can also download Android & iOS App</span></strong></p>
																
																<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="center" valign="top">
																  <table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px;max-width: 156px" align="center" valign="top">
																		<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
																		<tbody><tr style="vertical-align: top">
																			<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" align="left" valign="middle">';
																			
																			if($Cust_apk_link != "")
																			{
																				$html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;padding: 0 5px 5px 0" align="left" border="0" cellspacing="0" cellpadding="0" height="37">
																				<tbody><tr style="vertical-align: top">
																					<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="37" align="left" valign="middle">
																						<a href="'.$Cust_apk_link.'" title="Google Play" target="_blank">
																							<img style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;max-width: 32px !important" src="'.base_url().'images/Gooogle_Play.png" alt="Google Play" title="Google Play" width="32">
																						</a>
																					</td>
																				  </tr>
																				</tbody></table>';
																			}
																			
																			if($Cust_ios_link != "")
																			{
																				$html .='<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;padding: 0 5px 5px 0" align="left" border="0" cellspacing="0" cellpadding="0" height="37">
																				<tbody><tr style="vertical-align: top">
																					<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="37" align="left" valign="middle">
																						<a href="'.$Cust_ios_link.'" title="App Store" target="_blank">
																							<img style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;line-height: 100%;max-width: 32px !important" src="'.base_url().'images/iOs_app_store.png" alt="App Store" title="App Store" width="32">
																						</a>
																					</td>
																				  </tr>
																				</tbody></table>';
																			}
																			
																		$html .='</td>
																		  </tr></tbody>
																		</table></td></tr></tbody>
																	</table></td></tr></tbody>
																</table>';
															}
															
															$html .='</div>
																</div>
															</div>
														</td>
													  </tr></tbody>
													</table>
													
													</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody>
												</table>
												
												<table style="border-spacing: 0;border-collapse: collapse;vertical-align: top;background-color: #ffffff" cellpadding="0" cellspacing="0" align="center" width="100%" border="0">
												<tbody><tr style="vertical-align: top">
													<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%">
														<table class="container" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;margin: 0 auto;text-align: inherit" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" width="100%"><table class="block-grid" style="border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;background-color: #2C2D37" cellpadding="0" cellspacing="0" width="100%" bgcolor="#2C2D37"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;text-align: center;font-size: 0"><div class="col num12" style="display: inline-block;vertical-align: top;width: 100%"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" align="center" width="100%" border="0"><tbody><tr style="vertical-align: top"><td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;background-color: transparent;padding-top: 15px;padding-right: 0px;padding-bottom: 15px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-left: 0px solid transparent"><table style="border-spacing: 0;border-collapse: collapse;vertical-align: top" cellpadding="0" cellspacing="0" width="100%">
														<tbody><tr style="vertical-align: top">
														<td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-top: 0px;padding-right: 15px;padding-bottom: 0px;padding-left: 15px">
															<div style="color:#959595;line-height:150%;font-family:Helvetica;">            
																<div style="font-size:12px;line-height:18px;color:#959595;font-family:Helvetica;text-align:left;"><div class="txtTinyMce-wrapper" style="font-size:12px; line-height:18px;"><p style="margin: 0;font-size: 14px;line-height: 21px;text-align: left"><span style="font-size: 12px; line-height: 18px;"><em>
																	<strong>DISCLAIMER:</strong> This e-mail message is proprietary to '.$Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law. 
																	If you are not the intended recipient or responsible for delivery to the intended recipient,
																	you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_name.' will not accept any claims for damages arising out of viruses.<br>
																	Thank you for your cooperation.
																</em></span></p></div></div>
															</div>
														</td>
													  </tr></tbody></table>
												</td></tr></tbody></table></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></table></td></tr></tbody>
											</table>
										</td>
									</tr>
								</tbody>
								</table>
							</body>
							</html>';
							
										echo "<br>".$html."<br>";	
									
										
											$Email_content = array(
											'Contents' => $html,
											'subject' => $subject,
											'Notification_type' => 'Trigger Notification',
											'Template_type' => 'Trigger Notification',
											'trigger_id' => $Trigger_notification_id
											);
									
										$Notification = $this->send_notification->send_Notification_email($Enrollment_id,$Email_content,'1',$Company_id);
										}
								}
								
							//}
						}
						
					}*/
				}
			}
		}
	}
}

?>
