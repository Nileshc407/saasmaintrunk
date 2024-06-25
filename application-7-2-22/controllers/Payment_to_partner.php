<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_to_partner extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('login/Login_model');
		$this->load->model('Igain_model');
		$this->load->model('enrollment/Enroll_model');
		$this->load->model('Paymentpartner/Paymentpartner');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Send_notification');
	}
	public function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['enroll'] = $session_data['enroll'];
			$data['userId']= $session_data['userId'];
			$data['Company_id']= $session_data['Company_id'];
			$Company_id = $session_data['Company_id'];
			$data['timezone_entry'] = $session_data['timezone_entry'];
			$data['Country_id'] = $session_data['Country_id'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$data['Super_seller']= $session_data['Super_seller'];
			$data['next_card_no']= $session_data['next_card_no'];
			$data['card_decsion']= $session_data['card_decsion'];
			$data['Seller_licences_limit']= $session_data['Seller_licences_limit'];
			$data['LogginUserName'] = $session_data['Full_name'];
			$SuperSellerFlag = $session_data['Super_seller'];
			$Logged_in_userid = $session_data['enroll'];
			$Payment = $this->Igain_model->get_payement_type();
			$data['Payment_array'] = $Payment;

			$seller_details = $this->Igain_model->get_enrollment_details($session_data['enroll']);
			$currency_details = $this->Igain_model->Get_Country_master($seller_details->Country);
			$Symbol_currency = $currency_details->Symbol_of_currency;
			$data['Symbol_currency'] = $currency_details->Symbol_of_currency;

			// echo"---Symbol_currency----".$Symbol_currency."---<br>";

			$Super_Seller = $this->Igain_model->Fetch_Super_Seller_details($Company_id);
			$super_Seller_enroll=$Super_Seller->Enrollement_id;
			$data["Company_details"] = $this->Igain_model->get_company_details($Company_id);
			$Company_details = $data["Company_details"];
			$return_policy_in_days = $Company_details->Ecommerce_return_policy_in_days;
			$data['return_policy_in_days'] = $return_policy_in_days;
			// echo"---return_policy_in_days----".$return_policy_in_days."---<br>";
			$FetchedCountrys = $this->Igain_model->FetchCountry();
			$data['Country_array'] = $FetchedCountrys;
			
			$data["Sattled_Partener"] = $this->Paymentpartner->Sattled_partener($Company_id);
			
			if($_POST == NULL)
			{
				$this->load->view('Payment_to_partner/Payment_to_partner',$data);
			}
			else
			{

				// print_r($_POST);
				// die;
				if( $this->input->post("submit") == "submit" )
				{

					$Partner_Type =  $this->input->post('Partner_Type');
					$Company_id =  $this->input->post('Company_id');
					$Partner_id =  $this->input->post('Partner_id');
					$start_date =  $this->input->post('start_date');
					$end_date =  $this->input->post('end_date');
					$Payment_type =  $this->input->post('Payment_type');
					$Bank_name1 =  $this->input->post('Bank_name1');
					$Card_number =  $this->input->post('Card_number');
					$Branch_name =  $this->input->post('Branch_name');
					$Cheque_no =  $this->input->post('Cheque_no');


					$data["Trans_Records"] = $this->Paymentpartner->Paymentpartner_transaction($Partner_Type,$Company_id,$start_date,$end_date,$Partner_id,$return_policy_in_days);



					
				}
				if( $this->input->post("Partner_payment") == "Partner_payment" )
				{
					
					// echo"<pre>";
					// print_r($_POST);
					// die;

					$Partner_id =  $this->input->post('Partner_id');
					$Partner_Type =  $this->input->post('Partner_Type');
					$Grand_total =  $this->input->post('Grand_total');
					$Payment_type =  $this->input->post('Payment_type');
					$Invoice_number =  $this->input->post('Invoice_number');
					$Item_id =  $this->input->post('Item_id');
					

					$TransIDArray =  $this->input->post('TransIDArray');

					// print_r($TransIDArray);
					$trans_id=array();
					foreach($TransIDArray as $key => $value) {
						$TransArray=json_decode($value,true);
						$Trans_id_Count=count($TransArray);
						for($i=0; $i< $Trans_id_Count; $i++) {					
					
								if($Partner_Type ==4)
								{
									$trans_id[]=$TransArray[$i]["Item_id"];
								}
								if($Partner_Type !=4)
								{
									$trans_id[]=$TransArray[$i]["Item_id"];
								}
						
							// echo"----Item_id----".$TransArray[$i]["Item_id"]."---<br>";
						}
					}
					/* $trans_id=array();
					foreach($Item_id as $Item)
					{

						if($Partner_Type ==4)
						{
							$trans_id[]=$Item;
						}
						if($Partner_Type !=4)
						{
							$trans_id[]=$Item;
						}

					} */
					// print_r($trans_id);
					
					
					// die;
					$Update_Item_payment = $this->Paymentpartner->Fetch_partner_payment($trans_id,$Partner_id,$Company_id,$Partner_Type);
					$Grand_total = $Update_Item_payment->CostPayablePartner;
					
					
					
					/* foreach($Item_id as $Item)
					{

						if($Partner_Type ==4)
						{
							$Update_data= array(
								'Shipping_payment_flag'=>1,
								'Invoice_no'=>$Invoice_number
							);
						}
						if($Partner_Type !=4)
						{
							$Update_data= array(
								'Payment_to_partner_flag'=>1,
								'Invoice_no'=>$Invoice_number
							);
						}

						$Update_Item_payment = $this->Paymentpartner->Update_item_payment($Item,$Company_id,$Update_data);
					} */
					
					foreach($TransIDArray as $key => $value) {
						$TransArray=json_decode($value,true);
						$Trans_id_Count=count($TransArray);
						for($i=0; $i< $Trans_id_Count; $i++) {					
					
								if($Partner_Type ==4)
								{
									$Update_data= array(
										'Shipping_payment_flag'=>1,
										'Invoice_no'=>$Invoice_number
									);
								}
								if($Partner_Type !=4)
								{
									$Update_data= array(
										'Payment_to_partner_flag'=>1,
										'Invoice_no'=>$Invoice_number
									);
								}
						
							$Item=$TransArray[$i]["Item_id"];
							$Update_Item_payment = $this->Paymentpartner->Update_item_payment($Item,$Company_id,$Update_data);
						}
					}
					
					if($Payment_type==3)
					{
						$Payment_method="Credit Card";
						$Bank_name =  $this->input->post('Bank_name');
						$Branch_name="";
						$Credit_Cheque_number =  $this->input->post('Credit_Cheque_number');
					}
					elseif($Payment_type==2)
					{
						$Payment_method="Cheque";
						$Bank_name =  $this->input->post('Bank_name');
						$Branch_name =  $this->input->post('Branch_name');
						$Credit_Cheque_number =  $this->input->post('Credit_Cheque_number');
					}
					else
					{
						$Payment_method="Cash";
						$Bank_name="";
						$Branch_name="";
						$Credit_Cheque_number="";
					}
					if($Partner_Type ==4)
					{
						$Remarks=' Shipoing Partner Payment';
						$Merchandize_Partner_id=0;
						$Shipping_partner_id=$Partner_id;
						$Payment_to_partner_flag=0;
						$Shipping_payment_flag=1;
					}
					if($Partner_Type !=4)
					{
						$Merchandize_Partner_id=$Partner_id;
						$Shipping_partner_id=0;
						$Remarks=' Merchandize Partner Payment';
						$Payment_to_partner_flag=1;
						$Shipping_payment_flag=0;
					}
					$Update_Item_payment=1;
					if($Update_Item_payment)
					{
							$Insert_data= array(
									'Company_id'=>$Company_id,
									'Trans_type'=>23,
									'Trans_amount'=>$Grand_total,
									'Payment_type_id'=>$Payment_type,
									'Bank_name'=>$Bank_name,
									'Branch_name'=>$Branch_name,
									'Credit_Cheque_number'=>$Credit_Cheque_number,
									'Remarks'=>$Remarks,
									'Trans_date'=>date("Y-m-d"),
									'Seller'=>$session_data['enroll'],
									'Seller_name'=>$session_data['Full_name'],
									'Merchandize_Partner_id'=>$Merchandize_Partner_id,
									'Shipping_partner_id'=>$Shipping_partner_id,
									'Payment_to_partner_flag'=>$Payment_to_partner_flag,
									'Shipping_payment_flag'=>$Shipping_payment_flag,
									'Invoice_no'=>$Invoice_number
								);
							$InsertItemPayment = $this->Paymentpartner->Insert_Item_payment($Insert_data);



						$Partner_details = $this->Paymentpartner->Get_partner_details($Partner_id,$Company_id);

						$Partner_name=$Partner_details->Partner_name;
						$Partner_email=$Partner_details->Partner_contact_person_email;

						$banner_image=base_url().'images/payment.png';

						$subject = "Payment Details of ".$Partner_name ;

						$html = '<html xmlns="http://www.w3.org/1999/xhtml">';
						$html .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head>';

						$html .= '<body scroll="auto" style="padding:0; margin:0; FONT-SIZE: 12px; FONT-FAMILY: Arial, Helvetica, sans-serif; cursor:auto; background:#FEFFFF;height:100% !important; width:100% !important; margin:0; padding:0;">';

						$html .= '<table class="rtable mainTable" cellSpacing=0 cellPadding=0 width="100%" style="height:100% !important; width:100% !important; margin:0; padding:0;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgColor=#feffff>
							<tr>
								<td style="LINE-HEIGHT: 0; HEIGHT: 20px; FONT-SIZE: 0px">&#160;</td>
								<style>@media only screen and (max-width: 616px) {.rimg { max-width: 100%; height: auto; }.rtable{ width: 100% !important; table-layout: fixed; }.rtable tr{ height:auto !important; }}</style>
							</tr>

					<tr>
						<td vAlign=top>
							<table style="MARGIN: 0px auto; WIDTH: 616px;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="rtable" border="0" cellSpacing="0" cellPadding="0" width="616" align="center">
								<tr>
									<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
										<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
											<tr style="HEIGHT: 10px">
												<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
													<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
														<tr>
															<td style="PADDING-BOTTOM: 15px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																	<tr>
																		<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																			<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src='.$banner_image.' width=580 height=200 hspace="0" vspace="0">
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>

													<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 18px; mso-line-height-rule: exactly" align=left>
														Dear '.$Partner_name.' ,
													</P>';

													$html.='<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
														We are pleased to pay you a total of '.$Symbol_currency.' '.number_format((float)$Grand_total, 2).' against the details below. The Payment has been done as '.$Payment_method.'.<br><br>';
														if($Invoice_number != "")
														{
															$html .='<strong>Invoice Number:</strong> '.$Invoice_number. '<br>';
														}
														if($Payment_type==3)
														{
															$html .='<strong>Card of:</strong> '.$Bank_name. '<br>';
															$html .='<strong>Card Details:</strong> '.$this->getTruncatedCCNumber($Credit_Cheque_number). '<br>';
														}
														if($Payment_type==2)
														{
															$html .='<strong>Cheque of:</strong> '.$Bank_name. '<br>';
															$html .='<strong>Cheque Details:</strong> '.$Credit_Cheque_number. '<br>';
														}
														$html .='</P>
														<TABLE style="border: #dbdbdb 1px solid; WIDTH: 100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=center>
														<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Sr.No.</b>
														</TH>
														<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Member Name</b>
														</TH>
														<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Item</b>
														</TH>
														<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Quantity</b>
														</TH>';
														if($Partner_Type !=4)
														{
															$html .='<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Cost</b>
															</TH>';
														}
														if($Partner_Type ==4)
														{
															$html .='<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Delivery Date</b>
															</TH>
															<TH style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
															<b>Shipping Cost</b>
															</TH>';
														}

															$i=0;
															$Grand_total12=0;
															$Total_Shipping_Points=$Grand_total;
															foreach($Item_id as $item)
															{
																$item_details = $this->Paymentpartner->Get_item_transaction_details($item,$Company_id);

																// echo"---First_name---".$item_details->First_name."---First_name----";
																$html .= '<TR>

																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																		   '.($i+1).')
																			</TD>

																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																		   '.$item_details->First_name.' '.$item_details->Last_name.'
																			</TD>

																			<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																		   '.$item_details->Merchandize_item_name.'
																			</TD>


																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			'.$item_details->Quantity.'
																		</TD>';
																	if($Partner_Type !=4)
																	{
																		$Grand_total12=$Grand_total12+$item_details->Cost_payable_partner;
																		$html .= '<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			'.$item_details->Cost_payable_partner.'
																		</TD>';
																	}
																	if($Partner_Type ==4)
																	{
																		$Grand_total12=$Grand_total12+$item_details->Shipping_cost;

																		$html .= '<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			'.$item_details->Update_date.'
																		</TD>
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=left>
																			'.$item_details->Shipping_cost.'
																		</TD>';
																	}
																	'</TR>';
																$i++;
															}



															$html .='</TABLE><br>
															<TABLE style="border: #dbdbdb 1px solid; WIDTH: 40%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable border=0 cellSpacing=0 cellPadding=0 align=right>
																<TR>

																	<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=right >
																		<b>Grand Total</b>
																	</TD>
																		<TD style="border: #dbdbdb 1px solid;PADDING-BOTTOM: 4px; PADDING-LEFT: 4px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=right>
																		'.number_format((float)$Grand_total12, 2).'
																	</TD>
																</TR>
																</TABLE>';
															$html .= '<br><br><br><br><br><br><br>
															<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 10px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #666666; FONT-SIZE: 12px; mso-line-height-rule: exactly" align=left>
															Thank you for your Patronage! <br />
																Regards,<br />
																Loyalty Team.
															</P>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td style="BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
													<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
														<tr style="HEIGHT: 20px">
															<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
																if( $Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "")
																{
																	$html .= '<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 0; COLOR: #333333; FONT-SIZE: 25px; mso-line-height-rule: exactly" align=center>
																			You can also download Android & iOS App
																	</P>';
																}
												$html .= '</td>
											</tr>
										</table>
									</td>
								</tr>';
								if($Company_details->Cust_apk_link != "" || $Company_details->Cust_ios_link != "")
								{
										$html.='<tr>
										<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
										<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
										<tr style="HEIGHT: 10px">
										<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #f5f7fa; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">';
										 if( $Company_details->Cust_apk_link != "" && $Company_details->Cust_ios_link != ""){ $app_table_width = "WIDTH: 49%;"; }else{ $app_table_width = "WIDTH: 100%;"; }
											if($Company_details->Cust_apk_link != "")
											{

												$html.='<table style="BORDER-BOTTOM: transparent 1px solid; BORDER-LEFT: transparent 1px solid; <?php echo $app_table_width; ?> BORDER-TOP: transparent 1px solid; BORDER-RIGHT: transparent 1px solid;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
														<tr>
															<td style="PADDING-BOTTOM: 4px; PADDING-LEFT: 40px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=middle>
																	<DIV style="mso-table-lspace: 0; mso-table-rspace: 0">
																	<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																	<tr>
																	<td style="PADDING-BOTTOM: 10px; PADDING-LEFT: 100px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																		<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																		<tr>
																				<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																				<a href="'.$Company_details->Cust_apk_link.'" title="Google Play" target="_blank">
																					<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.base_url().'images/Gooogle_Play.png" width=64 height=64 hspace="0" vspace="0">
																				</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																	</tr>
																	</table>
																	</DIV>
															</td>
														</tr>
												</table> ';
											}
											if($Company_details->Cust_ios_link != "")
											{

												$html.='<table style="BORDER-BOTTOM: transparent 1px solid; BORDER-LEFT: transparent 1px solid; <?php echo $app_table_width; ?> BORDER-TOP: transparent 1px solid; BORDER-RIGHT: transparent 1px solid;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
														<tr>
														<td style="PADDING-BOTTOM: 4px; PADDING-LEFT: 120px; PADDING-RIGHT: 4px; PADDING-TOP: 4px" align=middle>
														<DIV style="mso-table-lspace: 0; mso-table-rspace: 0">
														<table border=0 cellSpacing=0 cellPadding=0 align=center style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
															<tr>
															<td style="PADDING-BOTTOM: 10px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px; PADDING-TOP: 2px" align=middle>
																	<table border=0 cellSpacing=0 cellPadding=0 style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
																			<tr>
																				<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; BORDER-TOP: medium none; BORDER-RIGHT: medium none">
																					<a href="'.$Company_details->Cust_ios_link.'" title="iOS App" target="_blank">
																						<IMG style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent; DISPLAY: block; BORDER-TOP: medium none; BORDER-RIGHT: medium none;border:0; outline:none; text-decoration:none;" class=rimg border=0 src="'.base_url().'images/iOs_app_store.png" width=64 height=64 hspace="0" vspace="0">
																					</a>
																				</td>
																			</tr>
																	</table>
															</td>
															</tr>
														</table>
														</DIV>
														</td>
														</tr>
												</table>';
											}
										$html.='</td>
										</tr>
									</table>
									</td>
									</tr>';
								}
								$html .= '<tr>
									<td style="BORDER-BOTTOM: #dbdbdb 1px solid; BORDER-LEFT: #dbdbdb 1px solid; PADDING-BOTTOM: 0px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 1px solid; BORDER-RIGHT: #dbdbdb 1px solid; PADDING-TOP: 0px">
										<table style="WIDTH: 100%;border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class=rtable cellSpacing=0 cellPadding=0 align=left>
											<tr style="HEIGHT: 20px">
												<td style="BORDER-BOTTOM: medium none; TEXT-ALIGN: center; BORDER-LEFT: medium none; PADDING-BOTTOM: 5px; BACKGROUND-COLOR: #feffff; PADDING-LEFT: 15px; WIDTH: 100%; PADDING-RIGHT: 15px; VERTICAL-ALIGN: middle; BORDER-TOP: medium none; BORDER-RIGHT: medium none; PADDING-TOP: 5px">
													<P style="LINE-HEIGHT: 155%; BACKGROUND-COLOR: transparent; MARGIN-TOP: 0px; FONT-FAMILY: Arial, Helvetica, sans-serif; MARGIN-BOTTOM: 1em; COLOR: #333333; FONT-SIZE: 10px; mso-line-height-rule: exactly" align=left>
														<strong>DISCLAIMER: </strong><em>This e-mail message is proprietary to '.$Company_details->Company_name.' and is intended solely for the use of the entity to whom it is addressed. It may contain privileged or confidential information exempt from disclosure as per applicable law.
														If you are not the intended recipient or responsible for delivery to the intended recipient,
														you may not copy, deliver, distribute or print this message. The message and its contents have been virus checked. But the recipients may conduct their own. '.$Company_details->Company_name.' will not accept any claims for damages arising out of viruses.<br>
														Thank you for your cooperation.</em>
													</P>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td style="LINE-HEIGHT: 0; HEIGHT: 8px; FONT-SIZE: 0px">&#160;</td>
						</tr>
					</table>
					</table>
					</body>
					</html>
					<style>
					td, th{
					font-size: 13px !IMPORTANT;
					}
					</style>';

					//	echo "<br>".$html;

						$Email_content = array(
							'Redemption_details' => $html,
							'Partner_email' => $Partner_email,
							'subject' => $subject,
							'Notification_type' => 'Partner_payment',
							'Template_type' => 'Partner_payment'
						);

						$Notification=$this->send_notification->send_Notification_email('',$Email_content,$super_Seller_enroll,$session_data['Company_id']);

					}
					$this->session->set_flashdata("success_code","Payment partner done Successfully!!");
					redirect("Payment_to_partner");
				}
				$this->load->view('Payment_to_partner/Payment_to_partner',$data);
				// redirect("Payment_to_partner");
			}
			
			

		}
		else
		{
			redirect('Login', 'refresh');
		}
	}
	function Get_partner()
	{

		$partnertype =  $this->input->post('partnertype');
		$Company_id =  $this->input->post('Company_id');

		$data['State_records'] = $this->Paymentpartner->Get_partner($partnertype,$Company_id);

		$theHTMLResponse = $this->load->view('Payment_to_partner/Partner_details', $data, true);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('Show_Partners'=> $theHTMLResponse)));

	}
    function getTruncatedCCNumber($ccNum)
	{
        $last4Digits    = preg_replace("#(.*?)(\d{4})$#", "$2", $ccNum);
        $firstDigits    = preg_replace("#(.*?)(\d{4})$#", "$1", $ccNum);
        return preg_replace("#(\d)#", "*", $firstDigits) . $last4Digits;
    }
}
?>
