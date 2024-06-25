<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" /> 
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; " />
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<meta name="x-apple-disable-message-reformatting">
<title> Invoice </title> 
     <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body bgcolor="#FFFFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:100%;font-family:'Open Sans', sans-serif;margin:0 auto;padding: 0;font-size: 12px;">
  <tr>
    <td>   
 			<table border="0" cellpadding="0" cellspacing="0" style="width: 660px; margin:0 auto;background: #fff;padding: 15px;border:1px solid #d8dade; border-radius:5px;">
 				<tr>
 					<td>
 						<table style="font-size:10px;" cellpadding="0" cellspacing="0" width="100%" border="0">
 							<tr>
 								<td style="width:70%;" rowspan="8">&nbsp;</td>						
							</tr>
							<tr><td><strong>Miracle Smart Card Pvt. Ltd.</strong></td></tr>
							<tr><td>407, 4th Floor Sterling Centre</td></tr>
							<tr><td>Opp. Aurora Towers</td></tr>
							<tr><td>M.G Road, Camp</td></tr>
							<tr><td>Pune – 411001</td></tr>
							<tr><td>Email: <a href="mailto:info@miraclecartes.com" target="_blank">info@miraclecartes.com</a></td></tr>
							<tr><td><a href="https://www.miraclecartes.com/saas" target="_blank">https://www.miraclecartes.com</a></td></tr>
 						</table>
 					</td>
 				</tr>
 				<tr>
 					   <td align="center" style="padding: 20px 0;"> 
 					   	<img src="<?php echo base_url() ?>images/invoice_logo/logo.jpg" width="160px;"> 
 					   </td>

 				</tr>
 				<tr>
 					<td  style="padding: 0 0 20px;" align="center"><h2>Tax Invoice</h2></td>
 				</tr>
 				<tr>
 					<td valign="top">
 						<table width="100%" border="0" cellpadding="0" cellspacing="0">
 							<tr>
 								<td style="width:50%;">
 								<table border="0" cellpadding="0" cellspacing="0">
 							<tr>
 								<td valign="top" style="width:40%; padding:2px 0;"><strong>Name</strong></td>
 								<td style="padding:2px 0;">: <?php echo $LogginUserName; ?></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>Company Name</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Company_name; ?> </td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0 15px;"><strong>Address</strong></td>
 								<td style="padding:2px 0 15px;">: <?php echo $Payment_details->Business_address; ?></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>Country</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Payment_details->Country_name; ?></td>
 							</tr>
							<?php if($Payment_details->Country_name == "India") { ?>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>State</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Payment_details->State_name; ?></td>
 							</tr>
							<?php } ?>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>Email Address</strong></td>
 								<td style="padding:2px 0;">: <a href="mailto:<?php echo $Payment_details->Payment_email; ?>" target="_blank"><?php echo $Payment_details->Payment_email; ?></a></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>Phone Number</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Payment_details->Payment_contact; ?></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>GST No.</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Payment_details->Business_GST_No; ?></td>
 							</tr>
 						</table>
 					</td>
 					<td valign="top" style="width:50%;padding-left: 50px;">
 						<table style="padding-left: 20px;" border="0" cellpadding="0" cellspacing="0">
 							<tr>
 								<td valign="top" style="width:60%; padding:2px 0;"><strong>Invoice Date</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Invoice_date; ?></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>Invoice Number</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Payment_details->Bill_no; ?> </td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>Invoice Amount</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Symbol_currency.' '.number_format($Payment_details->Bill_amount,2); ?> /-</td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0 15px;"><strong>Reference No.</strong></td>
 								<td style="padding:2px 0 15px;">: <?php echo $Payment_details->Razorpay_payment_id; ?></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0"><strong>Place of Supply</strong></td>
 								<td style="padding:2px 0;">: <?php if($Payment_details->Country_name == "India") { echo $Payment_details->State_name; } else {  echo $Payment_details->Country_name; } ?></td>
 							</tr>
 							<tr>
 								<td valign="top" style="padding:2px 0;"><strong>SAC</strong></td>
 								<td style="padding:2px 0;">: <?php echo $Payment_details->Sac_code; ?></td>
 							</tr>
 						</table>
 					</td>
 				</tr>

 						</table>
 					</td>
 				</tr>
 				<tr>
 					<td style="padding: 30px 0 15px;">
 						<table style="border:1px solid #000;" width="100%" cellpadding="0" cellspacing="0" border="0">
 							<tr>
 								<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><strong>Particulars</strong></td>
 								<td align="center" style="border-bottom:1px solid #000;"><strong>Amount</strong></td>
 							</tr>
 							<tr>
 								<td style="padding-left:5px; border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo $Application_name.' - ('.$License.')'; ?> License </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;"  align="right"><?php echo $Symbol_currency.' '.number_format($Payment_details->Base_price,2); ?></td>
 							</tr>
 							<tr>
 								<td style="padding-left:5px; border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo '( License Valid till '.$Valid_till.')'; ?></td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;"  align="right"></td>
 							</tr>
 							<tr>
 								<td style="padding-left:5px; border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp; </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;"  align="right">&nbsp;</td>
 							</tr>
							<?php if($Payment_details->Country_name == "India") { 
							if($Payment_details->State_name == "Maharashtra") { ?>
							
 							<tr>
 								<td style="padding-left:5px; border-bottom:1px solid #000;border-right:1px solid #000;">CGST – <?php echo $Payment_details->CGST_Percenatge.'%'; ?> </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;" align="right"><?php echo $Symbol_currency.' '.number_format($Payment_details->CGST,2); ?></td>
 							</tr>
 							<tr>
 								<td style="padding-left:5px; border-bottom:1px solid #000;border-right:1px solid #000;">SGST – <?php echo $Payment_details->SGST_Percenatge.'%'; ?> </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;"  align="right"><?php echo $Symbol_currency.' '.number_format($Payment_details->SGST,2); ?></td>
 							</tr>
							<?php } else { ?>
							<tr>
 								<td style="padding-left:5px; border-bottom:1px solid #000;border-right:1px solid #000;">IGST – <?php echo $Payment_details->IGST_Percenatge.'%'; ?> </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;" align="right"><?php echo $Symbol_currency.' '.number_format($Payment_details->IGST,2); ?></td>
 							</tr>
							<?php
								}
							} ?>
 							<tr>
 								<td style="padding-right:5px; border-bottom:1px solid #000;border-right:1px solid #000;" align="right">Total </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;"  align="right">
								<?php 
								if($Payment_details->Rounding_off > 0) {
									$Total = ($Payment_details->Bill_amount-$Payment_details->Rounding_off);
								}else{
									$Total = $Payment_details->Bill_amount;
								}									
									echo $Symbol_currency.' '.number_format($Total,2); ?>
								</td>
 							</tr>
							<?php if($Payment_details->Rounding_off > 0) { ?>
							<tr>
 								<td style="padding-right:5px; border-bottom:1px solid #000;border-right:1px solid #000;" align="right">Rounding off </td>
 								<td style="padding-right:5px;border-bottom:1px solid #000;"  align="right"><?php echo $Symbol_currency.' '.number_format($Payment_details->Rounding_off,2); ?></td>
 							</tr>
							<?php } ?>
 							<tr>
 								<td style="padding-right:5px; border-right:1px solid #000;" align="right" ><strong>Grand Total</strong> </td>
 								<td style="padding-right:5px;"  align="right"><strong><?php echo $Symbol_currency.' '.number_format($Payment_details->Bill_amount,2); ?></strong></td>
 							</tr>
 						</table>
 					</td>
 				</tr>
 				<tr>
 					<td style="padding:15px 0 25px;">Amount (in words): <strong><?php echo strtoupper($Bill_amaount_in_word); ?></strong></td>
 				</tr>
 				<tr>
 					<td><strong>MIRACLE SMART CARD PRIVATE LIMITED</strong></td>
 				</tr>
 				<tr>
 					<td>
 						<table width="100%" cellpadding="0" cellspacing="0" border="0">
 							<tr>
 								<td style="width: 20%; padding: 2px 0;"><strong>CIN</strong></td>
 								<td style="padding: 2px 0;">: U72100PN2011PTC138564</td>
 							</tr>
 							<tr>
 								<td style="padding: 2px 0;"><strong>PAN Number</strong></td>
 								<td style="padding: 2px 0;">: AAHCM0842L</td>
 							</tr>
 							<tr>
 								<td style="padding: 2px 0;"><strong>GST Number</strong></td>
 								<td style="padding: 2px 0;">: 27AAHCM0842L1ZA</td>
 							</tr>
 						</table>
 					</td>
 				</tr>
 				<tr>
 					<td style="font-size: 10px;padding: 30px 0 50px;">Subject to Pune, Maharashtra, India Jurisdiction</td>
 				</tr>
 				<tr>
 					<td align="center">THIS IS A COMPUTER GENERATED TAX INVOICE AND DOES NOT CONTAIN SIGNATURE</td>
 				</tr>
 				
 			</table>
    
    </td>
  </tr>
</table>
</body>
</html>