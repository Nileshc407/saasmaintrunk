<!DOCTYPE html>
<html>
  <body style="background-color: #222533; padding: 20px; font-family: font-size: 13px; line-height: 1.43; font-family: &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;">
    <!--max-width: 600px; --->
    <div style="margin: 0px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);">      
		<!--<img alt="" src="<?php echo base_url(); ?>images/email-header-img.jpg" style="max-width: 100%; height: auto;"> -->
		<div style="padding: 0px 20px;">
			<h2 class="text-center" style="margin-top: 0px;">
			   Transaction Receipt
			</h2>
			<table style="margin-top:5px; width: 100%;">
				  <tr>
					<td style="padding-right: 30px;">					  
					  <div style="font-size: 11px; letter-spacing: 1px; color: #020202; margin-bottom: 5px;">
						Transaction Date:<b><?php echo $Transaction_date; ?></b>
					  </div>
					</td>
				  </tr>
			</table>
			
			
			<hr style="height:3px; border:none; color:rgb(60,90,180); background-color:rgb(60,90,180);">
			<div class="table-responsive">
				<table style="margin-top: 40px; width: 100%;" class="table table-striped">
				 <tr>
					<?php 
						if($Transaction_type == 2 || $Transaction_type == 12 || $Transaction_type == 17 || $Transaction_type == 22 || 		$Transaction_type == 4)
						{
							if($Bill_no !=NULL && $Bill_no!=0)
							{
							?>
				 
				   
							<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
							Bill No.
							</td>
							<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;">
							 <?php echo $Bill_no; ?>
							</td>
					
				  
					<?php 
							} 
						} ?>
				</tr>
				  
				<tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
					Trans. Type
					</td>
					<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;">
						<?php
						if($Transaction_type == 1)
						{
							echo "Bonus Point";
						}
						if($Transaction_type == 2)
						{
							echo "Loyalty Transaction";
						}
						if($Transaction_type == 3)
						{
							echo "Only Redeem";
						}
						if($Transaction_type == 4)
						{
							echo "Gift Card Transaction";
						}
						if($Transaction_type == 7)
						{
							echo "Promo Code";
						}
						if($Transaction_type == 8)
						{
							echo "Transfer Points";
						}
						if( $Transaction_type == 10)
						{
							echo "Redemption";
						}
						if($Transaction_type == 12)
						{
							echo "Online Purchase";
						}
						if($Transaction_type == 13)
						{
							echo "Survey Rewards";
						}
						if($Transaction_type == 14)
						{
							echo "Points Expiry";
						}
						if($Transaction_type == 17)
						{
							echo "Purchase Cancel";
						}
						if($Transaction_type == 18)
						{
							echo "Evoucher Expiry";
						}
						if($Transaction_type == 22)
						{
							echo "Purchase Returned";
						}
						?>
					</td>
					
				</tr>
				
				  <?php if($Transaction_type == 10 || $Transaction_type == 18) { ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
						 Voucher No.
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;">
						 <?php echo $Voucher_no; ?>
						</td>				
					</tr>					
				  
				  <?php } ?>
				 
				
				  <tr>
				   
					<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
						Description
					</td>
						<?php if($Transaction_type == 10 || $Transaction_type == 12 || $Transaction_type == 17 || $Transaction_type == 18 || $Transaction_type == 22) 
						{ ?>
							<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;"><?php echo $Redeemed_item; ?></td>
						<?php   
						} 
						else if($Transaction_type == 8)
						{ ?>
							<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;"><?php echo 'Transferred To - '.$Card_id2; ?></td>
						<?php	
						}
						else if($Transaction_type == 7)
						{ ?>
							<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;"><?php echo $remark2; ?></td>
						<?php	
						}
				        else   
						{ ?>
							<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;"><?php echo '-'; ?></td> 
						<?php 	
						} ?>
				  </tr>
				  
				 
				  
				<?php if($Transaction_type == 12){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
							Purchase Amount<?php echo "( ".$Symbol_currency." )"; ?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;  text-align: right;">
							<?php 
								echo $Purchase_amount;
							?>
						</td>				
					</tr>
				  <?php } ?> 
				  
				 
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							<?php echo $Company_details->Currency_name; ?> Received
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;text-align: right;">
							 <?php  
								if($Transaction_type == 1 || $Transaction_type == 17 || $Transaction_type == 7 || $Transaction_type == 13 || $Transaction_type == 18 || $Transaction_type == 22) 
								{ 
								
									echo $Topup_amount;
								
								} else { 
								
									echo $Recived_point; 
								
								} 
								?> 
						</td>				
					</tr>
				  
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
							<?php echo $Company_details->Currency_name; ?> Used
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php
								if($Transaction_type == 8) 
								{
									echo $Transfer_points;
								}
								
								else
								{
									echo $Redeem_points; 
								}
							?>
						</td>				
					</tr>
					
					<?php   if($Transaction_type == 10 && $Delivery_method==29) { ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; ">			
							Shipping <?php echo $Company_details->Currency_name; ?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php
								echo $Shipping_points;
							?>
						</td>				
					</tr>
					<?php } ?>
					
					<?php   if($Transaction_type == 14) { ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Expired <?php echo $Company_details->Currency_name; ?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php
								echo $Expired_points;
							?>
						</td>				
					</tr>
					<?php } ?>
					
					<?php   if($Transaction_type == 2) { ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Category
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php
								echo $Item_category_name;
							?>
						</td>				
					</tr>
					<?php } ?>
					
					<?php  
						if($Transaction_type==12) {
					?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Shipping Cost 
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php
								echo $Shipping_cost;
							?>
						</td>				
					</tr>
					<?php } ?>
					
					
					
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							<?php if($Transaction_type == 1)
							{
								echo "Bonus ".$Company_details->Currency_name." Issued"; 
							}
							else if($Transaction_type == 10 || $Transaction_type == 3)
							{ 
								echo "Total ".$Company_details->Currency_name." Used"; 
							}	
							else if($Transaction_type !=8 && $Transaction_type !=17 && $Transaction_type !=7 && $Transaction_type !=13 && $Transaction_type !=14 && $Transaction_type !=18 && $Transaction_type !=22)
							{ 
								echo "Transaction";
							}
							if($Transaction_type != 1 &&$Transaction_type != 3 && $Transaction_type != 10 && $Transaction_type != 8 && $Transaction_type != 17 && $Transaction_type != 7 && $Transaction_type != 13 && $Transaction_type != 14 && $Transaction_type != 18 && $Transaction_type != 22)
							{
								echo "( ".$Symbol_currency." )";
							}
							?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								if($Transaction_type == 1)
								{
									echo $Topup_amount; 
								}
								if($Transaction_type == 2)
								{
									echo $Purchase_amount. " ( Purchase Amount)";
								}
								if($Transaction_type == 3)
								{
									echo $Redeem_points;
								}
								if($Transaction_type == 4)
								{
									echo $giftcard_purchase. " ( Purchase Amount)";
								}
								if($Transaction_type == 10 && $Delivery_method==29)
								{
									echo $Total_redeem_points+$Shipping_points; 
								}
								else if($Transaction_type == 10 && $Delivery_method==28)
								{
									echo $Total_redeem_points;
								}
								if($Transaction_type==12)
								{
									 echo $Purchase_amount=($Purchase_amount+$Shipping_cost);
								}
								?>
						</td>				
					</tr>
					
					
					<?php  if($Transaction_type == 2 || $Transaction_type == 4){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							<?php
							if($Transaction_type == 2){ echo "Redeemed ".$Company_details->Currency_name; }
							if($Transaction_type == 4){echo " Redeem Amount";}
							?>
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								if($Transaction_type == 2 || $Transaction_type == 4){echo $Redeem_points;}
							?>
						</td>				
					</tr>
					
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Balance Paid
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								if($Transaction_type == 2 || $Transaction_type == 4){echo $balance_to_pay;}
								?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Balance Payment by
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								echo $Payment_description;
								
								?>
						</td>				
					</tr>
					<?php if($Payment_type_id != 1 && $Transaction_type == 2 && $Bank_name != ''){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Bank Name
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								echo $Bank_name;
								
								?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Bank Branch Name
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								echo $Branch_name;
								
								?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Cheque/Credit Number
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								echo $Credit_Cheque_number;
								
								?>
						</td>				
					</tr>
					
					<?php } ?>
					
					<?php if($Transaction_type == 4){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Gift Card No
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								echo $gift_pay_type;
								?>
						</td>				
					</tr>
					
					<?php } ?>
						
					<?php } ?>
					
					
					<?php if($Transaction_type == 4){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Gift Card No
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								echo $gift_pay_type;
								?>
						</td>				
					</tr>
					
					<?php } ?>
					
					<?php  if($Transaction_type == 2){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							<?php echo $Company_details->Currency_name; ?> Gained at Merchant
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								echo $Loyalty_pts;
								?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							<?php echo $Company_details->Currency_name; ?> Gained due to Coalition 
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								echo round($Coalition_Loyalty_pts);
								?>
						</td>				
					</tr>
					
					<?php } ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Merchant
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 								
								echo $Seller_name;
							?>
						</td>				
					</tr>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Remark
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
						<?php
							if($Transaction_type == 4)
							{
								echo "Gift Card Transaction";
							}
							
							if(($Transaction_type == 2 || $Transaction_type == 1 || $Transaction_type == 3 || $Transaction_type == 8 || $Transaction_type == 10 || $Transaction_type == 12 || $Transaction_type == 17 || $Transaction_type == 18) && $Remark!="")
							{
								echo $Remark;
							}
							else if($Transaction_type == 13)
							{
								echo "Survey Rewards";
							}
							else
							{
								echo " - ";
							}
							?>
						</td>				
					</tr>
					<?php
						if($Transaction_type == 2 && $Remark=="FlatFile")
						{ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Flatfile Remarks
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								echo $Flatfile_remarks;
								?>
						</td>				
					</tr>
					
					<?php } ?>
					<?php
						if($Transaction_type == 2 && $GiftCardNo != "0"){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Gift Card No.
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								if($GiftCardNo==0){echo "-";}else{echo $GiftCardNo;};
								?>
						</td>				
					</tr>
					
					<?php } ?>
					
					<?php  if(($Transaction_type == 2 && $Voucher_no != "" && $Voucher_no != "PromoCode-()" ) ){ ?>
					<tr>			   
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px;">			
							Promo Code Used
						</td>
						<td style="letter-spacing: 1px; color: #020202; font-size: 13px; text-align: right;">
							<?php 
								
								echo $Voucher_no;
								?>
						</td>				
					</tr>					
					<?php } ?>
				 
				</table>
			</div>
			
			
			<h6 style="margin-bottom: 10px;float:left;font-size: 13px;">
				<?php
					if($Timezone == "Asia/Kolkata" || $Timezone == "") 
					{	
						$Timezone="Asia/Calcutta";
					}					
					$date = date_default_timezone_set($Timezone);
					echo "<small>".date("F j, Y, g:i a T")."</small>";
					
					
				?>
			</h6>
			<h6 style="margin-bottom: 10px;float:right;font-size: 13px;">
				<small>  Transaction Done :<?php echo $Seller_name; ?></small>
			</h6>
			<!--<div style="color: #A5A5A5; font-size: 12px;">
			  <p>
				If you have any questions you can simply reply to this email or find our contact information below. Also contact us at <a href="#" style="text-decoration: underline; color: #4B72FA;">test@example.com</a>
			  </p>
			</div> -->
		</div>
	  
    </div>
  </body>
</html>


<script>
$(document).ready(function() 
{	
	$("#close_modal").click(function(e)
	{
		$('#receipt_myModal').hide();
		$("#receipt_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>
<style>
@media screen {
  #printSection {
      display: none;
  }
  
}
@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
  #btnPrint{
      display: none;
  }
  #close_modal{
      display: none;
  }
}
@page { size: auto;  margin-top: 5mm; margin-bottom: 0mm; }
</style>
<script>
document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}
function printElement(elem) 
{
    var domClone = elem.cloneNode(true);    
    var $printSection = document.getElementById("printSection");    
    if (!$printSection) 
	{
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
</script>